<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HAuth extends CI_Controller {

	public function __construct() {
		parent::__construct();
		log_message('debug', 'controllers.HAuth.login: loading HybridAuthLib');
		$this->load->library('HybridAuthLib');
	}

	public function login($provider) {

		//$this->hybridauthlib->logoutAllProviders();

		log_message('debug', "controllers.HAuth.login($provider) called");

		try {

			if ($this->hybridauthlib->providerEnabled($provider))
			{
				log_message('debug', "controllers.HAuth.login: service $provider enabled, trying to authenticate.");
				$service = $this->hybridauthlib->authenticate($provider);

				if ($service->isUserConnected())
				{
					log_message('debug', 'controller.HAuth.login: user authenticated.');

					$user_profile = $service->getUserProfile();

					log_message('info', 'controllers.HAuth.login: user profile:'.PHP_EOL.print_r($user_profile, TRUE));

					// Load the people and account model
					$this->load->model('people_model');
					$this->load->model('account_model');

					// Get user info
					$info = $this->account_model->oauth_info($provider, $user_profile->identifier);
					
					// Check if user doesn't exist by checking if info is false
					// Or if they're already logged in (connecting an account)
					if(!$info || $this->php_session->get('loggedin')) {
						$user_profile_arr = array(
							'displayName' => $user_profile->displayName,
							'username' => $user_profile->displayName,
							'firstName' => $user_profile->firstName,
							'lastName' => $user_profile->lastName,
							'emailVerified' => $user_profile->emailVerified,
							'email' => $user_profile->email,
							'country' => $user_profile->country,
							'identifier' => $user_profile->identifier,
							'photoURL' => $user_profile->photoURL
						);
						$sess['oauth_user_profile'] = $user_profile_arr;
						$sess['oauth_provider'] = $provider;

						if($this->php_session->get('loggedin')) {
							$sess['oauth_connect_account'] = true;
							$this->php_session->set($sess);
							redirect('oauth/connect_account_confirm');
						}
						else {
							// If email exists, go to /oauth/already_exists
							if($this->people_model->email_taken($user_profile->emailVerified)) {
								$sess['oauth_choose'] =  true;
								$sess['oauth_new_account'] =  true;
								$this->php_session->set($sess);
								redirect('oauth/already_exists');
							}
							// Else go to /oauth/new_account
							else {
								$sess['oauth_new_account'] = true;
								$this->php_session->set($sess);
								redirect('oauth/new_account');
							}
						}

					}
					else {
						// If user exists, log them in
						$this->account_model->login($info);
						// Redirect to dashboard
						redirect('dashboard');
					}

				}
				else // Cannot authenticate user
				{
					show_error('Cannot authenticate user');
				}
			}
			else // This service is not enabled.
			{
				log_message('error', 'controllers.HAuth.login: This provider is not enabled ('.$provider.')');
				die('Provider not enabled: '.$provider);
				//show_404($_SERVER['REQUEST_URI']);
			}
		}
		
		catch(Exception $e) {
			$error = 'Unexpected error';
			switch($e->getCode()) {

				case 0 : $error = 'Unspecified error.'; break;
				case 1 : $error = 'Hybriauth configuration error.'; break;
				case 2 : $error = 'Provider not properly configured.'; break;
				case 3 : $error = 'Unknown or disabled provider.'; break;
				case 4 : $error = 'Missing provider application credentials.'; break;
				case 5 : log_message('debug', 'controllers.HAuth.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
				         //redirect();
				         if (isset($service))
				         {
				         	log_message('debug', 'controllers.HAuth.login: logging out from service.');
				         	$service->logout();
				         }
				         show_error('User has cancelled the authentication or the provider refused the connection.');
				         break;
				case 6 : $error = 'User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.';
				         break;
				case 7 : $error = 'User not connected to the provider.';
				         break;
				default: $error = 'Unknown error';
								 break;

			}

			if (isset($service))
			{
				$service->logout();
			}

			log_message('error', 'controllers.HAuth.login: '.$error);
			show_error('Unable to authenticate user. Please try again.');
		}
	}

	public function endpoint() {

		log_message('debug', 'controllers.HAuth.endpoint called.');
		log_message('info', 'controllers.HAuth.endpoint: $_REQUEST: '.print_r($_REQUEST, TRUE));

		if ($_SERVER['REQUEST_METHOD'] === 'GET')
		{
			log_message('debug', 'controllers.HAuth.endpoint: the request method is GET, copying REQUEST array into GET array.');
			$_GET = $_REQUEST;
		}

		log_message('debug', 'controllers.HAuth.endpoint: loading the original HybridAuth endpoint script.');
		require_once APPPATH.'/third_party/hybridauth/index.php';

	}

}

/* End of file hauth.php */
/* Location: ./application/controllers/hauth.php */
