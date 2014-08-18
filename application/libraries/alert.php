<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Alerts (Notifications) Library
 * Send, update, get, and delete alerts
 *
 * @package Libraries
 * @author Nathan Johnson
 */

class Alert {

  public function __construct() {
    $this->CI =& get_instance();
    $this->CI->load->model('alerts_model');
  }

  /**
   * Gets count of unread alerts
   * @return int The number of unread alerts the user has.
   * @access public
   */
  public function get_unread_count() {
    $where = array(
      'to' => $this->CI->php_session->get('userid'),
      'seen' => 0
    );
    $this->CI->db->select('id')
                 ->from('alerts')
                 ->where($where);
    return $this->CI->db->count_all_results();
  }

  /** 
   * Get an alert's info
   * @param int $id The ID of the alert.
   * @return array Information about the alert like action, object, id, etc.
   * @access public
   */
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

  /**
   * Create an alert
   *
   * @param int $to The user id to send the alert to.
   * @param string $action The action the alert is about.
   * @param string $object_type The type of object the alert is about.
   * @param int $object_id The ID of the object the alert is about.
   * @return bool
   * @access public
   */
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
    return $this->CI->db->insert('alerts', $data);
  }

  /**
   * Delete an alert
   * @param int $id The ID of the alert to delete.
   * @access public
   */
  public function delete($id) {
    return $this->CI->db->delete('alerts', array('id'=>$id));
  }

  /**
   * Get an array of the user's alerts
   * @param int $limit The amount of alerts to return.
   * @return array The user's alerts.
   * @access public
   */
  public function get_all($limit = 0) {
    // Select from the DB
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
    // Loop through the alerts, adding to $alerts
    foreach($raw_alerts as $info) {
      $text = $this->text($info['action']);
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

  /**
   * Make the URL for the object of the alert.
   *
   * When visiting /alert/view/ID, this determines the URL of the 
   * object that the user needs redirected to.
   *
   * @param int $id The ID of the alert.
   * @return string URL of the object
   * @access public
   */
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
      /*case 'follow':
        $this->load->model('people_model');
        $info = $this->people_model->get_info($data['object_id'], 'id', 'username');
        $url = profile_url($info['username']);
      break;*/
      default:
        die("Invalid alert object type.");
      break;
    }
    return $url;

  }

  /**
   * Mark an alert as clicked
   *
   * @param int $id The ID of the alert to mark as clicked.
   * @access public
   */
  public function mark_as_clicked($id) {
    $this->CI->db->where('id', $id);
    $this->CI->db->update('alerts', array('clicked'=>1));
  }

  /**
   * Mark all the user's alerts as read
   *
   * When the user views their alerts, this marks all their alerts as read.
   * But they will still be highlighted until they're marked as clicked.
   *
   * @return bool
   * @access private
   */
  private function mark_all_read() {
    $this->CI->db->where('to', $this->CI->php_session->get('userid'));
    return $this->CI->db->update('alerts', array('seen'=>1));
  }

  /**
   * Mark a batch of alerts as read.
   * @param array $ids The array of alert IDs to mark as read.
   * @return void
   * @access private
   */
  private function mark_read_batch($ids) {
    if(count($ids) > 0) {
      foreach($ids as $id) {
        $this->CI->db->or_where('id', $id);
      }
      $this->CI->db->update('alerts', array('seen'=>1));
    }
  }

  /*private function object_link_text($type) {
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
  }*/

  /**
   * Generate the text for the alert.
   * This determines the text to use for the alert depending on the action.
   * @param string $action The alert's action.
   * @return string
   * @access private
   */
  private function text($action) {
    // Determine action text
    switch($action) {
      case 'like':
        $text = 'likes your';
      break;
      case 'dislike':
        $text = 'dislikes your';
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

  /**
   * Make the URL for the alert (which then redirects to the object)
   * @param  array $data The information about the alert (should contain action and ID)
   * @return string The URL of the alert
   * @access private
   */
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