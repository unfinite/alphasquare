<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Staff Model
 * Check if user is staff, perform basic moderation actions
 * @package Models
*/

class Staff_model extends CI_Model {

  /** 
   * Allow loggedin user access if session var
   *
   * @return bool
   * 
   */
  

  public function allowAccess() {

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
   * @return bool
   * 
   */
  

  public function isStaff($username) {

    // query db to check if user is employee
    
    $this->db->select('employee')
             ->from('users')
             ->where('username', $username);

    $result = $this->db->get()->row_array();

    // return boolean
    
    if ($result['employee'] == 0) {

      return false;

    } else {

      return true;

    }

  }

  /** 
   * Provide a nice array of user data. 
   *
   * @return array, user's data
   * 
   */
  

  public function listUsernames() {

    // query db to list usernames and stuff
    
    $this->db->select('username, employee, avatar, points, email, id')
             ->from('users');

    return $this->db->get()->result_array();

  }

  /** 
   * Provide a nice array of user data for a specific uid. 
   *
   * @return array, user's data
   * 
   */
  

  public function retrieveUID($uid) {

    // query db to list usernames and stuff
    
    $this->db->select('username, employee, avatar, points, email, id')
             ->where('id', $uid)
             ->from('users');

    return $this->db->get()->row_array();

  }




}
?>