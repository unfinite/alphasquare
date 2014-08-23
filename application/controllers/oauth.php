<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oauth extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('account_model');
  }

  /**
   * The email is already used.
   * 
   * URL: /oauth/already_exists
   * If a user signs in with OAuth and the email is already used,
   * give them the option to connect the account or create a new one.
   */
  public function already_exists() {
    // If oauth_choose isn't in session, go to login page
    if(!$this->php_session->get('oauth_choose')) {
      redirect('login');
    }
    $user_profile = $this->php_session->get('oauth_user_profile');
    // If already_exists_email isn't set
    // Set it and clear it so it can't be used
    if(!isset($user_profile['already_exists_email'])) {
      $user_profile['already_exists_email'] = $user_profile['emailVerified'];
      $user_profile['emailVerified'] = null;
      $this->php_session->set('oauth_user_profile', $user_profile);
    }

    $data['title'] = 'Choose An Option';
    $data['email'] = $user_profile['already_exists_email'];
    $data['provider'] = $this->php_session->get('oauth_provider');
    $data['fixed_container'] = true;
    $this->template->load('hauth/already_exists', $data);
  }

  /**
   * Allow user to connect an OAuth account with existing account
   * URL: /oauth/connect_account
   */
  public function connect_account() {
    if(!$this->php_session->get('oauth_provider')) {
      redirect('dashboard');
    }
    $provider = $this->php_session->get('oauth_provider');
    $user_profile = $this->php_session->get('oauth_user_profile');
    $oauth_uid = $user_profile['identifier'];
    if(!$provider) {
      show_error('Unable to connect account.');
    }
    login_required(false, 'To connect '.$provider.' with your existing Alphasquare account, please sign in to it first.');
    if($this->account_model->oauth_provider_used($provider)) {
      show_error('Sorry, you have already connected a '.$provider.' account.');
    }
    // Connect the OAuth account to the logged in user's account
    $connect_account = $this->account_model->oauth_connect_account($provider, $oauth_uid);
    if($connect_account) {
      $this->php_session->set('oauth_connected', true);
      redirect('oauth/connected');
    }
  }

  /**
   * Lets the user know their account has been connected
   * @return [type] [description]
   */
  public function connected() {
    if(!$this->php_session->get('oauth_connected')) {
      redirect();
    }

    $data['title'] = 'Connected';
    $data['fixed_container'] = true;
    $data['provider'] = $this->php_session->get('oauth_provider');
    if($data['provider']) {
      $this->php_session->set('_oauth_provider', $data['provider']);
    }
    else {
      $data['provider'] = $this->php_session->get('_oauth_provider');
    }

    $this->template->load('hauth/connected', $data);

    // Clear the OAuth session vars
    $this->clear_oauth_session();
  }

  /**
   * Create a new account from OAuth (allow user to confirm details)
   * URL: /oauth/new_account
   */
  public function new_account() {
    // If oauth_new_account isn't in session, go to login page
    if(!$this->php_session->get('oauth_new_account')) {
      redirect('login');
    }

    $user_profile = $this->php_session->get('oauth_user_profile');
    // Process some data given by the oauth provider
    $email = '';
    if($user_profile['emailVerified']) {
      $email = $user_profile['emailVerified'];
    }
    else {
      $email = $user_profile['email'];
    }

    // If username isn't null
    if($user_profile['username']) {
      // Remove non-words in display name 
      $username = preg_replace("/[^\w_]/ui", '', $user_profile['username']);
      $this->load->model('people_model');
      if($this->people_model->username_taken($username)) {
        // If username is taken, add numbers to end
        $username .= mt_rand(000,9999);
      }
    }
    // username is null
    else {
      // Make the username their firstName and oauth UID
      $this->load->helper('string');
      $username = $user_profile['firstName'] . $user_profile['identifier'];
    }

    $data['name'] = $user_profile['displayName'];
    $data['username'] = $username;
    $data['email'] = $email;

    $data['title'] = 'Complete Your Registration';
    $data['provider'] = $this->php_session->get('oauth_provider');

    // Make the container fixed and centered
    $data['fixed_container'] = true;
    
    $this->template->load('hauth/new_account', $data);
  }

  /**
   * Submit handler for new account
   * @return [type] [description]
   */
  public function new_account_submit() {
    // If submit button (input type=button) isn't present, no form was submitted
    if(!$this->input->post('submit')) {
      show_error('Sorry, the form was not submitted. Try again.');
    }
    // If oauth_new_account isn't in session, go to login page
    if(!$this->php_session->get('oauth_new_account')) {
      msg('The session has expired. Please login again.');
      redirect('login');
    }

    $this->load->model('people_model');
    $this->load->helper('validate_helper');

    $user_profile = $this->php_session->get('oauth_user_profile');
    $provider = $this->php_session->get('oauth_provider');

    $name = $this->input->post('name');
    $username = $this->input->post('username');
    $email = $this->input->post('email');

    // Save new entered values into session oauth_user_profile 
    // So on /oauth/new_account the values can be auto filled in if there's an error
    $user_profile['displayName'] = $name;
    $user_profile['username'] = $username;
    $user_profile['emailVerified'] = $email;
    $user_profile['email'] = $email;
    $this->php_session->set('oauth_user_profile', $user_profile);

    if(!valid_email($email)) {
      msg('Email is invalid. '.$email);
      redirect('oauth/new_account');
    } 
    else if($this->people_model->email_taken($email)) {
      msg('That email is already in use by another account.');
      redirect('oauth/new_account');
    }
    else if(!valid_username($username) || strlen($username) < 2) {
      msg('Username is required and can only contain letters, numbers, and underscores.');
      redirect('oauth/new_account');
    } 
    else if($this->people_model->username_taken($username)) {
      msg('That username is taken.');
      redirect('oauth/new_account');
    }

    // Create the account
    $info = $this->account_model->oauth_create(
      $provider, 
      $user_profile['identifier'], 
      $name, 
      $username, 
      $email,
      $user_profile['country']
    );

    if(!$info) {
      show_error('Sorry, an error has occurred. Please try again');
    }

    msg('Welcome to Alphasquare!', 'info');

    // Destroy the session vars
    $this->php_session->destroy();
    $this->php_session->start();

    // Log the user in to new account
    $this->account_model->login($info); 

    redirect();   
  }

  public function cancel() {
    // Destroy the session vars
    $this->php_session->destroy();
    redirect('login');
  }

  private function clear_oauth_session() {
    $this->php_session->delete('oauth_new_account');
    $this->php_session->delete('oauth_connect_account');
    $this->php_session->delete('oauth_choose');
    $this->php_session->delete('oauth_provider');
    $this->php_session->delete('oauth_user_profile');
  }

}

/* End of file oauth.php */
/* Location: ./application/controllers/oauth.php */