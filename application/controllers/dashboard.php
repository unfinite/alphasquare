<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Dashboard Controller
*/

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('debate_model');
	}

	public function index() {

		// If user is not logged in, redirect to homepage
		if(!$this->php_session->get('logged_in')) {
			redirect();
		}
		else {

			$data['title'] = 'Dashboard';

			// Get array of debates
			$posts = $this->debate_model->get_all();

			// Loop through the array, append html for
			// each post (from view) to $posts_html
			$posts_html = '';
			foreach($posts as $post) {
				$posts_html .= $this->debate_model->post_html($post);
			}

			$data['posts_html'] = $posts_html;

			$this->template->load('dashboard', $data);

		}

	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */