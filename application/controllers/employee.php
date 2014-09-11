<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('staff_model');
    login_required();
    $employee = $this->staff_model->allowAccess();
    if ($employee == false) {
      redirect('dashboard');
    }
  }

  public function index() {

    $data['title'] = 'Panel';
    $users = $this->staff_model->listUsernames();
    $data['table'] = $this->load->view('admin/list_users', array('users'=>$users), true);
    $this->template->load('admin/welcome', $data);

  }

  public function ban() {
    $data['title'] = 'Panel';
    $this->template->load('admin/ban', $data);
  }

}
