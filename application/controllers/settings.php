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
    $data['events'] = $this->events->get();
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
    $this->load->library('HybridAuthLib');
    $data['title'] = 'Connected OAuth Accounts';
    $data['tab'] = 'oauth';
    $data['providers'] = 'hyrbidauthlib';
    $data['fixed_container'] = true;
    $data['stylesheets'] = array(
      'assets/css/bootstrap-social.css',
      'http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'
    );
    $this->template->load('settings/template', $data);
  }

}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */