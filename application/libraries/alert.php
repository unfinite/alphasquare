<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Alphasquare - Alert Library
By Nathan Johnson
*/

class Alert {

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('alerts_model');
	}

	// Get count of unread alerts
	public function get_unread_count() {
		$where = array(
			'to' => $this->CI->php_session->get('userid'),
			'seen' => 0
		);
		$this->CI->db->select('id')
						 		 ->from('alerts')
						 		 ->where($where);
		return $this->CI->db->count_all_results();
		//die($this->CI->db->last_query());
	}

	// Get an alert's info
	public function get_info($id) {
		$where = array(
			'id' => $id,
			'to' => $this->CI->php_session->get('userid')
		);
		$this->CI->db->select('*')
								 ->from('alerts')
								 ->where($where)
								 ->limit(1);
		$query = $this->CI->db->get();
		return $query ? $query->row_array() : false;
	}

	// Create an alert
	public function create($to, $action, $object_type, $object_id) {
		$from = $this->CI->php_session->get('userid');
		if($to === $from) return;
		$data = array(
			'to' => $to,
			'from' => $from,
			'action' => $action,
			'object_id' => $object_id,
			'object_type' => $object_type,
			'time' => time()
		);
		$this->CI->db->insert('alerts', $data);
	}

	// Delete an alert
	public function delete($id) {
		return $this->CI->db->delete('alerts', array('id'=>$id));
	}

	// Get an array of the user's alerts
	public function get_all($limit = 0) {
		$this->CI->db->select('a.id, a.from, a.object_id, a.object_type,
													 a.action, a.clicked, a.time,
													 u.username, u.email')
								 ->from('alerts a')
								 ->join('users u', 'a.from = u.id', 'inner')
								 ->where('to', $this->CI->php_session->get('userid'))
								 ->order_by('time', 'desc');
		if($limit) {
			$this->CI->db->limit($limit);
		}
		$raw_alerts = $this->CI->db->get()->result_array();
		$alerts = array();
		foreach($raw_alerts as $info) {
			$text = $this->text($info);
			$url = $this->get_alert_url($info);
			$alerts[] = array(
				'id' => $info['id'],
				'username' => $info['username'],
				'email' => $info['email'],
				'text' => $text,
				'object' => $info['object_type'],
				'url' => $url,
				'clicked' => $info['clicked'],
				'time_iso' => date('c', $info['time']),
				'time_formatted' => date('F j, Y g:i A', $info['time'])
			);
		}
		$this->mark_all_read();
		return $alerts;
	}

	// Make the URL for the object of the alert
	public function get_url($id) {

		$data = $this->get_info($id);
		if(!$data) return false;

		switch($data['action']) {
			case 'like':
			case 'dislike':
				$this->CI->db->select('d.time, u.username')
										 ->from('debates d')
										 ->join('users u', 'd.userid = u.id', 'inner')
										 ->where('d.id', $data['object_id'])
										 ->limit(1);
				$info = $this->CI->db->get()->row_array();
				$url = 'debate/'.strtolower($info['username']).'/'.$info['time'];
			break;
			case 'comment':
				$this->CI->db->select('d.time, u.username')
										 ->from('comments c')
										 ->join('debates d', 'c.postid = d.id', 'inner')
										 ->join('users u', 'd.userid = u.id', 'inner')
										 ->where('c.id', $data['object_id'])
										 ->limit(1);
				$info = $this->CI->db->get()->row_array();
				$url = 'debate/'.strtolower($info['username']).'/'.$info['time'].'#comment_'.$data['object_id'];
			break;
			case 'follow':
				$this->load->model('people_model');
				$info = $this->people_model->get_info($data['object_id'], 'id', 'username');
				$url = profile_url($info['username']);
			break;
			default:
				die("Invalid alert object type.");
			break;
		}
		return $url;

	}

	public function mark_as_clicked($id) {
		$this->CI->db->where('id', $id);
		$this->CI->db->update('alerts', array('clicked'=>1));
	}

	public function mark_all_read() {
		$this->CI->db->where('to', $this->CI->php_session->get('userid'));
		$this->CI->db->update('alerts', array('seen'=>1));
	}

	private function mark_read_batch($ids) {
		if(count($ids) > 0) {
			foreach($ids as $id) {
				$this->CI->db->or_where('id', $id);
			}
			$this->CI->db->update('alerts', array('seen'=>1));
		}
	}

	private function object_link_text($type) {
		switch($type) {
			case 'debate':
			case 'comment':
				$text = 'debate';
			break;
			default:
				$text = '';
			break;
		}
		return $text;
	}

	private function text($data) {
		// Determine action text
		switch($data['action']) {
			case 'like':
				$text = 'likes your';
			break;
			case 'follow':
				$text = 'is now following you.';
			break;
			case 'comment':
				$text = 'commented on your';
			break;
			default:
				die("Invalid alert action type.");
			break;
		}
		return $text;
	}

	// Make the URL for the alert (which then redirects to the object)
	private function get_alert_url($data) {
		// No link to object is needed for these actions
		$no_link_actions = array('follow');
		if(in_array($data['action'], $no_link_actions)) {
			$url = false;
		}
		else {
			$url = base_url('alerts/view/'.$data['id']);
		}
		return $url;
	}
}

/* End of file alerts.php */
/* Location: ./application/libaries/alerts.php */