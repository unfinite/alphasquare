<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Account Controller
This controller is to do with the user's account.
- Login/Logout
- Register
- Forgot password
- etc.
*/

class Account extends CI_Controller {

	public function login() {

		// If user is already logged in, redirect to dashboard
		if($this->php_session->get('logged_in')) {
			redirect('dashboard');
		}

		// If user submitted login form
		if($this->input->post('submit')) {
			// Store username and password in variables
			// Trim username and hash password
			$username = trim($this->input->post('username'));
			$password = sha1($this->input->post('password'));

			// Check if length of username or password is < 1
			if(strlen($username) < 1 || strlen($password) < 1) {
				msg('Please enter your username and password.');
				redirect('login');
			}

			// Call the login method of the account model, which returns true or false
			$correct = $this->account_model->login($username, $password);

			// If the login method returned true, redirect to dashboard
			if($correct) {
				redirect('dashboard');
			}
			else {
				msg('Incorrect username or password. Please try again.');
				redirect('login');
			}

		}
		else {
			// Load the login page view
			$data['title'] = 'Sign in';
			$data['fixed_container'] = true;
			$this->template->load('account/login', $data);
		}

	}

	public function logout() {
		// destroy session
		$this->php_session->destroy();
		// redirect to homepage
		redirect();
	}

	public function register() {

	}

	public function forgot($key) {

	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */