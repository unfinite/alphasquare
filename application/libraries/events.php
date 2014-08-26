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
    $this->CI->db->select('id, object, event, value, time, ip, userid')
                 ->from('account_events')
                 ->where('userid', $id)
                 ->order_by('time', 'desc')
                 ->limit(50);
    $events = $this->CI->db->get()->result_array();
    // Create comma separated list of IDs of the events
    $ids = array();
    foreach($events as $event) {
      $ids[] = $event['id'];
    }
    // Delete all the user's events except for these ones (50 latest)
    $this->delete($ids);
    return $events;
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
    $ip = $this->CI->input->ip_address();
    $data = array(
      'userid' => $userid,
      'object' => $object,
      'event' => $event,
      'value' => $value,
      'time' => time(),
      'ip' => $ip_bin
    );
    $this->CI->db->insert('account_events', $data);
  }

  /**
   * Delete all of a user's events except the IDs in the array
   *
   * @param array $ids The IDs of the events to NOT delete
   * @return null
   */
  public function delete($ids) {
    $userid = $this->CI->php_session->get('userid');
    return $this->CI->db->where('userid', $userid)
                        ->where_not_in('id', $ids)
                        ->delete('account_events');
  }

  /**
   * Report events
   * @param  array $ids Event IDs
   * @return bool
   */
  public function report($ids) {
    $ids = implode(',', $ids);
    $userid = $this->CI->php_session->get('userid');
    $data = array(
      'userid' => $userid,
      'ids' => $ids,
      'time' => time()
    );
    return $this->CI->db->insert('account_event_reports', $data);
  }

}

/* End of file events.php */
/* Location: ./application/libraries/events.php */