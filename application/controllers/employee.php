<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Employee center controller
 */
class Employee extends CI_Controller {

  /**
   * Constructor for employee controller
   * URL: /employee
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->model('staff_model');
    login_required();
    $employee = $this->staff_model->allowAccess();
    if($employee == false) {
      redirect('dashboard');
    }
  }

  public function index() {
    $data['title'] = 'Welcome to the employee panel';
    $users = $this->staff_model->listUsernames();
	  $data['users'] = $users;
    $data['tab'] = 'users';
    $this->template->load('admin/template', $data);
  }

  public function notes() {
    $data['title'] = 'Make notes';
    $data['tab'] = 'notes';
    $this->template->load('admin/template', $data);
  }

}

/* End of file: employee.php */