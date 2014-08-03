<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Dashboard Controller
*/

class Dashboard extends CI_Controller {

	public function index() {

		// If user is not logged in, redirect to homepage
		if($this->php_session->get('logged_in')) {
			redirect();
		}
		else {

			// This uses the custom library template
			// See wiki for more info
			$data['title'] = 'Dashboard';
			$this->template->load('dashboard', $data);

		}

	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */