<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
People Model
*/

class People_model extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  // Get a user's information
  // Second param, $type, is what to fetch the info by (default 'id')
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

  // Update a user's info
  public function update_info($info, $id = 0) {
    if(!$id) {
      $id = $this->php_session->get('userid');
    }
    $this->db->where('id', $id);
    return $this->db->update('users', $info);
  }

  // Get list of users
  public function get_list($type, $limit = 50) {
    if($this->php_session->get('loggedin')) {
      $userid = $this->php_session->get('userid');
    }
    else {
      $userid = 0;
    }
    switch($type) {
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
                       u.followers,
                       f.followid as is_following')
         ->from('users u')
         ->join('following f', 'f.followid = u.id AND f.userid = '.$userid, 'left')
         ->order_by($order_by, 'desc')
         ->limit($limit);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Check if username is taken
  public function username_taken($username) {
    $this->db->select('username')
             ->from('users')
             ->where('username', $username);
    if($this->db->get()->num_rows > 0) return true;
    else return false;
  }

  // Check if email is taken
  public function email_taken($email) {
    $this->db->select('email')
             ->from('users')
             ->where('email', $email);
    if($this->db->get()->num_rows > 0) return false;
    else return true;
  }

  // Get a user's links
  public function get_links($id) {
    $this->db->select('id, text, url')
             ->from('user_links')
             ->where('userid', $id)
             ->order_by('created', 'asc');
    return $this->db->get()->result_array();
  }

  // Create a link
  public function create_links($links) {
    return $this->db->insert_batch('user_links', $links);
  }

  // Delete user's links
  public function delete_links($id) {
    return $this->db->delete('user_links', array('userid' => $id));
  }


  // Check if a user exists (by id or username)
  public function exists($id) {
    $this->db->select('id')
             ->from('users')
             ->where('id', $id)
             ->or_where('username', $id)
             ->limit(1);
    return $this->db->count_all_results();
  }

  // Check if a user is following another user
  public function is_following($followid, $userid = 0) {
    // If userid wasn't passed, use the logged in user's id
    if(!$userid) {
      $userid = $this->php_session->get('userid');
    }
    $this->db->select('userid')
             ->from('following')
             ->where(array('userid' => $userid, 'followid' => $followid));
    return $this->db->count_all_results();
  }

  // Follow or unfollow a user
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
      return $insert_success;
    }
    // Else, delete row from db
    else {
      return $this->db->delete('following', $data);
    }
  }

  // Get the people a user is following / who are following a user
  public function get_follows($type, $id = 0) {
    if(!$id) {
      $id = $this->php_session->get('userid');
    }
    $this->db->select('u.id,
                       u.username,
                       u.email,
                       u.followers,
                       f2.followid as is_following')
             ->from('following f');
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

  // Number of people a user is following
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

}

/* End of file people_model.php */
/* Location: ./application/models/people_model.php */