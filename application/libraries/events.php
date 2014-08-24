<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events {

  public function __construct() {
    $this->CI =& get_instance();
  }

  /**
   * Get a user's events
   * @param int $id The user id
   * @return array
   */
  public function get($id = null) {
    $id = $id ? $id : $this->CI->php_session->get('userid');
    $this->delete_old();
    $this->CI->db->select('id, object, event, value, time, ip, userid')
                 ->from('account_events')
                 ->where('userid', $id)
                 ->order_by('time', 'desc')
                 ->limit(50);
    return $this->CI->db->get()->result_array();
  }

  /**
   * Log an event
   * @param  string $object The object the event is about (account, user, oauth, etc.)
   * @param  string $event  The event that occurred
   * @param  int    $userid The id of the user that initiated it
   * @return null
   */
  public function log($object, $event, $value = null, $userid = null) {
    $userid = $userid ? $userid : $this->CI->php_session->get('userid');
    
    $data = array(
      'userid' => $userid,
      'object' => $object,
      'event' => $event,
      'value' => $value,
      'time' => time(),
      'ip' => inet_pton($_SERVER['REMOTE_ADDR'])
    );
    $this->CI->db->insert('account_events', $data);
  }

  /**
   * Delete all of a user's events except the latest 50
   * @return null
   */
  public function delete_old() {
    $userid = $this->CI->php_session->get('userid');
    $sql = "
    DELETE FROM `account_events`
    WHERE userid = '$userid' AND id NOT IN (
      SELECT id
      FROM `account_events`        
      ORDER BY time DESC
      LIMIT 50
    )";
    //$this->CI->db->query($sql);
  }

}

/* End of file events.php */
/* Location: ./application/libraries/events.php */