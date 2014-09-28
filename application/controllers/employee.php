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

}

/* End of file: employee.php */