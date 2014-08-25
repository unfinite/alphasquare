<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oauth extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('oauth_model');
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
    $this->template->load('oauth/already_exists', $data);
  }

  /**
   * Have the user confirm they want to connect the account
   * URL: /oauth/connect_account_confirm
   */
  public function connect_account_confirm() {
    if(!$this->php_session->get('oauth_connect_account')) {
      redirect('dashboard');
    }
    $data['title'] = 'Confirm connect account';
    $data['provider'] = $this->php_session->get('oauth_provider');
    $data['fixed_container'] = true;
    $this->template->load('oauth/connect_confirm', $data);
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
    
    // If user already connected this provider, tell them
    if($this->oauth_model->provider_used($provider)) {
      show_error('Sorry, you have already connected a '.$provider.' account.');
    }

    // If this account is already connected to another Alphasquare account
    if($this->oauth_model->already_connected($provider, $oauth_uid)) {
      show_error('That '.$provider.' account is already connected to another Alphasquare account.');
    }

    // Connect the OAuth account to the logged in user's account
    $connect_account = $this->oauth_model->connect_account($provider, $oauth_uid);
    if($connect_account) {
      // Log the event
      $this->events->log('oauth', 'connect', $provider);
      // Set oauth_connected to allow the 'connected' page to be showed
      $this->php_session->set('oauth_connected', true);
      redirect('oauth/connected');
    }
  }

  /**
   * Lets the user know their account has been connected
   * URL: /oauth/connected
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

    $this->template->load('oauth/connected', $data);

    // Clear the OAuth session vars
    $this->oauth_model->clear_oauth_session();
  }

  /**
   * Disconnect an account
   * URL: /oauth/disconnect/PROVIDER
   */
  public function disconnect($provider) {
    login_required();
    try {
      $this->oauth_model->disconnect($provider);
      redirect('settings/oauth');
    }
    catch(Exception $e) {
      show_error($e->getMessage());
    }
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
    
    $this->template->load('oauth/new_account', $data);
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
    $info = $this->oauth_model->create(
      $provider, 
      $user_profile['identifier'], 
      $name, 
      $username, 
      $email,
      $user_profile['country'],
      $user_profile['photoURL']
    );

    if(!$info) {
      show_error('Sorry, an error has occurred. Please try again');
    }

    msg('Welcome to Alphasquare!', 'info');

    // Log the account creation in events
    $this->events->log('oauth', 'create_account', $provider, $info['id']);

    // Destroy the oauth session vars
    $this->oauth_model->clear_oauth_session();

    // Log the user in to new account
    $this->account_model->login($info); 

    redirect();   
  }

  public function cancel() {
    // Destroy the session vars
    $this->php_session->destroy();
    redirect('login');
  }

}

/* End of file oauth.php */
/* Location: ./application/controllers/oauth.php */