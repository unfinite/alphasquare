<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Main Controller
The Index method on this is the homepage
*/

class Main extends CI_Controller {

	public function index() {

		// If user is logged in, redirect to dashboard
		if($this->php_session->get('logged_in')) {
			redirect('dashboard');
		}
		else {

			// This uses the custom library template
			// See wiki for more info
			$data['title'] = 'Home';
			$data['stylesheets'] = array(
				'assets/css/home.css',
				'http://fonts.googleapis.com/css?family=Lato:700'
			);
			$this->template->load('home', $data);

		}

	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */