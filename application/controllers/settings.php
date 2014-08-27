<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('account_model');
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

  public function report_events() {
    $ids = $this->input->post('ids');
    $ids = explode(',', $ids);
    foreach($ids as $id) {
      $id = (int) $id;
      if(!$id) {
        json_error('Invalid event ID.');
      }
    }
    if($this->events->report($ids)) {
      json_success();
    }
    else {
      json_error('Error.');
    }
  }

  public function password() {
    $data['title'] = 'Change Password';
    $data['tab'] = 'password';
    $data['fixed_container'] = true;
    $this->template->load('settings/template', $data);
  }

  public function oauth() {
    $this->load->model('oauth_model');
    $data['providers'] = array(
      array(
        'name' => 'Facebook', 
        'class' => 'facebook'
      ),
      array(
        'name' => 'Google', 
        'class' => 'google-plus'
      )
    );
    $data['connected'] = $this->oauth_model->get_connected();
    $data['title'] = 'Connected OAuth Accounts';
    $data['tab'] = 'oauth';
    $data['fixed_container'] = true;
    $data['stylesheets'] = array('assets/css/bootstrap-social.css', 'assets/css/oauth-settings.css');
    $this->template->load('settings/template', $data);
  }

}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */