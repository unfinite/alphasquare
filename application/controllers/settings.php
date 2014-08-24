<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    login_required();
  }

  public function index() {
    redirect('settings/account');
  }

  public function account() {
    $this->load->model('people_model');
    $data = $this->people_model->get_info();
    $data['title'] = 'Account';
    $data['tab'] = 'account';
    $data['fixed_container'] = true;
    $this->template->load('settings/template', $data);
  }

  public function security() {
    $data['title'] = 'Account Security';
    $data['tab'] = 'security';
    $data['fixed_container'] = true;
    $this->template->load('settings/template', $data);
  }

  public function password() {
    $data['title'] = 'Change Password';
    $data['tab'] = 'password';
    $data['fixed_container'] = true;
    $this->template->load('settings/template', $data);
  }

  public function oauth() {
    $data['title'] = 'Connected OAuth Accounts';
    $data['tab'] = 'oauth';
    $data['fixed_container'] = true;
    $this->template->load('settings/template', $data);
  }

}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */