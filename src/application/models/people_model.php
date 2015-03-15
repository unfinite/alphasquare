<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * People Model
 * Create, get info, update, delete users
 * @package Models
*/

class People_model extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  /**
   * Get a user's information
   *
   * @param int|string $id The user ID or other peice of data
   * @param string $type What to fetch the info by (id, email, or username)
   * @param string $rows The rows to get from the users table.
   */
  public function get_info($id = 0, $type = 'id', $rows = '*') {
    if(!$id) {
      $id = $this->php_session->get('userid');
    }
    $this->db->select($rows)
             ->from('users')
             ->where($type, $id)
             ->limit(1);
    return $this->db->get()->row_array();
  }

  /**
   * Update a user's info
   *
   * @param array $info Assoc. array of rows => values to update.
   * @param int $id The user ID to update.
   * @return bool
   */
  public function update_info($info, $id = 0) {
    if(!$id) {
      $id = $this->php_session->get('userid');
    }
    $this->db->where('id', $id);
    return $this->db->update('users', $info);
  }

  /**
   * Get array of users
   * 
   * @param string $order_type
   * @param int $limit The number of users to return.
   * @return array
   */
  public function get_list($order_type, $limit = 50) {
    if($this->php_session->get('loggedin')) {
      $userid = $this->php_session->get('userid');
    }
    else {
      $userid = 0;
    }
    switch($order_type) {
      case 'popular':
        $order_by = 'u.followers';
      break;
      case 'new':
        $order_by = 'u.joined';
      break;
      case 'random':
        $order_by = 'RAND()';
      break;
    }
    $this->db->select('u.id,
                       u.username,
                       u.email,
                       u.avatar,
                       u.followers,
                       f.followid as is_following')
         ->from('users u')
         ->join('following f', 'f.followid = u.id AND f.userid = '.$userid, 'left')
         ->order_by($order_by, 'desc')
         ->limit($limit);
    $query = $this->db->get();
    return $query->result_array();
  }

  /**
   * Check if username is taken
   * @return bool
   */
  public function username_taken($username) {
    $this->db->select('username')
             ->from('users')
             ->where('username', $username);
    if($this->db->get()->num_rows > 0) return true;
    else return false;
  }

  /**
   * Check if email is taken
   * @return bool
   */
  public function email_taken($email) {
    $this->db->select('email')
             ->from('users')
             ->where('email', $email);
    if($this->db->get()->num_rows > 0) return true;
    else return false;
  }

  /**
   * Get an array of user's links
   * @param int $id The ID of the user.
   * @return array Links
   */
  public function get_links($id) {
    $this->db->select('id, text, url')
             ->from('user_links')
             ->where('userid', $id)
             ->order_by('created', 'asc');
    return $this->db->get()->result_array();
  }

  /**
   * Create a link
   * @return bool
   */
  public function create_links($links) {
    return $this->db->insert_batch('user_links', $links);
  }

  /**
   * Delete all of a user's links
   * @param int $id The ID of the user.
   * @return bool
   */
  public function delete_links($id) {
    return $this->db->delete('user_links', array('userid' => $id));
  }


  /**
   * Check if a user exists
   *
   * This will return true if user exists and false if user doesn't exist.
   *
   * @param int $id The user ID.
   * @return bool
   */
  public function exists($id) {
    $this->db->select('id')
             ->from('users')
             ->where('id', $id)
             ->or_where('username', $id)
             ->limit(1);
    return $this->db->count_all_results() ? true : false;
  }

  /**
   * Check if a user is following another user
   *
   * @param int $followid The ID of the user being followed
   * @param int $userid The ID of the follower
   * @return bool
   */
  public function is_following($followid, $userid = 0) {
    // If userid wasn't passed, use the logged in user's id
    if(!$userid) {
      $userid = $this->php_session->get('userid');
    }
    $this->db->select('userid')
             ->from('following')
             ->where(array('userid' => $userid, 'followid' => $followid));
    return $this->db->count_all_results() ? true : false;
  }

  /** 
   * Follow or unfollow a user
   *
   * @param string $action The action - follow or unfollow
   * @param int $id The ID of the user to follow
   * @return bool
   */
  public function follow($action, $id) {
    // If user doesn't exist, return false
    if(!$this->exists($id)) {
      return false;
    }
    $data = array(
      'userid' => $this->php_session->get('userid'),
      'followid' => $id
    );
    // If action is follow, then insert into db
    if($action === 'follow') {
      $insert_success = $this->db->insert('following', $data);
      if($insert_success) {
        // If follow was successful, send the user an alert
        $this->load->library('alert');
        $this->alert->create($id, 'follow', 'user', $id);
      }
      // Update following/followers rows
      $this->update_follow_counts($id, 'follow');
      return true;
    }
    // Else, delete row from db
    else {
      $delete_success = $this->db->delete('following', $data);
      if($delete_success) {
        // Update following/followers rows
        $this->update_follow_counts($id, 'unfollow');
        return true;
      }
    }
    return false;
  }

  /**
   * Get the people a user is following or the people following a user
   *
   * @param string $type Following or followers
   * @param int $id The user ID
   * @return array Array of followers/following
   */
  public function get_follows($type, $id = 0, $limit = 0) {
    if(!$id) {
      $id = $this->php_session->get('userid');
    }
    $this->db->select('u.id,
                       u.username,
                       u.email,
                       u.avatar,
                       u.followers,
                       f2.followid as is_following')
             ->from('following f');
    if ($limit !== 0) {
      $this->db->limit($limit);
    }
    // If type is following
    if($type == 'following') {
      $this->db->where('f.userid', $id);
      $this->db->join('users u', 'u.id = f.followid');
    }
    // Else type is followers
    else {
      $this->db->where('f.followid', $id);
      $this->db->join('users u', 'u.id = f.userid');
    }
    // Check if logged in user is following
    $this->db->join('following f2', 'f2.followid = u.id AND f2.userid = "'.$this->php_session->get('userid').'"', 'left');
    return $this->db->get()->result_array();
  }

  /**
   * Number of people a user is following, or number of followers
   * @param string $type Following or followers
   * @param int $id The user ID.
   * @return int
   */
  public function get_follow_count($type, $id = 0) {
    if(!$id) {
      $id = $this->php_session->get('userid');
    }
    if($type == 'following') $col = 'userid';
    else $col = 'followid';
    $this->db->select('userid')
             ->from('following')
             ->where($col, $id);
    return $this->db->count_all_results();
  }

  /**
   * Update `following` and `followers` rows on users table
   *
   * Users table has columns to cache the number of followers/following they have
   * This is so the DB doesn't need to be queried to get the number of follows for a user
   * 
   * @param  int $followid The ID of the user being followed
   * @param  string $action The action - 'follow' or 'unfollow'
   * @return null
   */
  public function update_follow_counts($followid, $action) {
    if($action === 'follow') $number = 1;
    else $number = -1;

    // Update the following count for current user
    $this->db->set('following', 'following+'.$number, false);
    $this->db->where('id', $this->php_session->get('userid'));
    $this->db->update('users');

    // Update the followers count for the user being followed
    $this->db->set('followers', 'followers+'.$number, false);
    $this->db->where('id', $followid);
    $this->db->update('users');
  }

}

/* End of file people_model.php */
/* Location: ./application/models/people_model.php */