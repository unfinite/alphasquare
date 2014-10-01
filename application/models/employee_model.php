<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Employee Model
 * Check if user is staff, perform basic moderation actions
 * @package Models
*/

class Employee_model extends CI_Model {

  /** 
   * Allow loggedin user access if session var
   *
   * @return bool
   * 
   */
  

  public function allow_access() {

    // check sess vars
    $staff = $this->php_session->get('employee');
        
    if ($staff == 0) {

      return false;

    } else {

      return true;

    }

  }


  /** 
   * Check if user is staff
   *
   * @param string $username The user's username
   * @return int 0: no, 1: yes
   * 
   */
  

  public function is_staff($username) {

    // query db to check if user is employee
    
    $this->db->select('employee')
             ->from('users')
             ->where('username', $username);

    $result = $this->db->get()->row_array();

    // return 0 or 1
    return $result['employee'];

  }

  /** 
   * Get all users
   *
   * @return array, user's data
   * 
   */
  

  public function get_users() {

    // query db to list usernames and stuff
    
    $this->db->select('name, username, employee, avatar, points, email, id')
             ->from('users');

    return $this->db->get()->result_array();

  }

}
?>