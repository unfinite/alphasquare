<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Employee center controller
 * 
 * @package controllers
 * 
 */
class Employee extends CI_Controller {

  /**
   * Constructor for employee controller
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->model('employee_model');
    login_required();
    $employee = $this->employee_model->allow_access();
    if($employee == false) {
      redirect('dashboard');
    }
  }

  /**
   * Employee index page
   * URL: /employee
   */
  public function index() {
    $data['title'] = 'Users - Employee Panel';
    $users = $this->employee_model->get_users();
	  $data['users'] = $users;
    $data['tab'] = 'users';
    $this->template->load('employee/template', $data);
  }

  /**
   * Allows mods to add notes
   * URL: /employee/notes
   */
  public function notes() {
    $data['title'] = 'Notes - Employee Panel';
    $data['tab'] = 'notes';
    $this->template->load('employee/template', $data);
  }

  /**
   * Deletes user
   * URL: /employee/delete/:id
   */

  public function delete($id = '') {

    if (!empty($id) and is_numeric($id)) {

      $status = $this->employee_model->delete($id);

      if ($status == true) {

        msg("User deleted successfully.");
        redirect('dashboard');

      } else {

        msg("User couldn't be deleted. (Is he/her staff?)");
        redirect('dashboard');

      }

    } else {

      msg("Empty ID.");

    }

  }

  /**
   * Deletes user regardless of status (staff)
   * NOTICE: FOR SPECIAL EMERGENCY USE ONLY. This is a secret and this method cannot be used by anyone outside management or dev. Do not 
   * ever mention this method's existence in the Slack or anywhere. If this happens, action will be taken.
   * URL: /employee/delete_f/:id
   */

  public function delete_f($id = '') {

    if (!empty($id) and is_numeric($id)) {

      $status = $this->employee_model->delete_f($id);

      if ($status == true) {

        msg("User deleted successfully.");

        redirect('dashboard');

      } else {

        msg("User couldn't be deleted. Did something fail in the DB?");
        redirect('dashboard');

      }

    } else {

      msg("Empty ID.");

    }
  }

  public function delete_post($id) {

    if (!empty($id) and is_numeric($id)) {

      $this->employee_model->delete_post($id);
      msg("Post deleted successfully.");

      redirect('dashboard');
    }

  }

  public function official($id) {

    if (!empty($id) and is_numeric($id)) {

      $this->employee_model->official($id);
      msg("Made official.");

      redirect('dashboard');

    }

  }

  public function staff($id) {

    if (!empty($id) and is_numeric($id)) {

      $this->employee_model->staff($id);
      msg("Made staff.");

      redirect('dashboard');

    }

  }

}

/* End of file: employee.php */