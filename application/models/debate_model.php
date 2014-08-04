<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Debate Model
This is where we access data from the DB (or APIs)
*/

class Debate_model extends CI_Model {

	public function get_all($order = 'desc') {
		$this->db->select('d.*, u.username, u.avatar')
						 ->from('debates d')
						 ->join('users u', 'u.id = d.userid', 'left')
						 ->order_by('d.time', $order)
						 ->limit(30);
		$results = $this->db->get()->result_array();
		return $results;
	}

	public function create($content) {
		$data = array(
			'userid' => 32,
			'content' => $content,
			'time' => time()
		);
		$insert = $this->db->insert('debates', $data);
		if($insert) {
			$data['up_votes'] = 0;
			$data['down_votes'] = 0;
			$data['comments'] = 0;
			$data['id'] = $this->db->insert_id();
			$post_html = $this->post_html($data);
		}
		$return = array('postHtml' => $post_html);
		return $insert ? $return : false;
	}

	public function post_html($data) {
		if(!isset($data['avatar'])) {
			$data['avatar'] = $this->php_session->get('avatar');
		}
		if(!isset($data['username'])) {
			$data['username'] = $this->php_session->get('username');
		}
		$template = $this->load->view('posts/html_template', $data, true);
		return $template;
	}

}

/* End of file debate_model.php */
/* Location: ./application/models/debate_model.php */