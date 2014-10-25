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
    
    $this->db->select('name, username, official, employee, avatar, points, email, id')
             ->from('users');

    return $this->db->get()->result_array();

  }

  /** 
   * Delete user
   *
   * @return boolean, status of deletion
   * 
   */
  

  public function delete($id) {

    // query db

    if (is_numeric($id)) {
    
      $this->db->select('employee')
               ->from('users')
               ->where('id', $id);
      $arr = $this->db->get()->row_array();
      $status = $arr['employee'];

      if($status == 1) {

          return false;

        } else {

          $this->db->delete('users', array('id'=>$id));
          return true;

        } 

    }

  }

  public function delete_f($id) {

    if (is_numeric($id)) {

      return $this->db->delete('users', array('id'=>$id));

    } else {

      return false;

    }

  }

  public function delete_post($id) {

    return $this->db->delete('debates', array('id'=>$id));
    
  }

  public function official($id) {

    if (is_numeric($id)) {
      $this->db->where('id', $id);
      $st = 1;
      $this->db->update('users', array('official'=>$st));
    }

  }

  public function staff($id) {

    if (is_numeric($id)) {
      $this->db->where('id', $id);
      $st = 1;
      $this->db->update('users', array('staff'=>$st));
    }

  }

}
?>