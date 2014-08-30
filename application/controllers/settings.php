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

  public function experimental() {

    $data['title'] = 'Labs';
    $data['tab'] = 'experimental';
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

    $this->load->model('people_model');
    $info = $this->people_model->get_info();

    // Whether or not user has a password
    $data['existing_password'] = empty($info['password']) ? false : true;
    
    $this->template->load('settings/template', $data);
  }

  public function password_submit() {
    $current = $this->input->post('current');
    $new = $this->input->post('new');
    $confirm = $this->input->post('confirm');

    // Check if current password is correct
    if(!$this->account_model->password_correct($current)) {
      msg('The password you entered is incorrect.');
      redirect('settings/password');
    }
    // Make sure password is long enough
    else if(strlen($new) < MIN_PASS_LENGTH) {
      msg('Password must be at least 6 characters.');
      redirect('settings/password');
    }
    else if($new !== $confirm) {
      msg('Both passwords do not match.');
      redirect('settings/password');
    }

    if($this->account_model->change_password($new)) {
      msg('Your password has been changed.', 'success');
    }
    else {
      msg('Sorry, unable to change password.');
    }
    redirect('settings/password');

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