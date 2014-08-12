<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Page Controller
Extra pages that don't have anything to do with the user part of the site
Example: All the about pages (about/*)
*/

class Page extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('debate_model');
	}

	public function show($page = '', $data = null) {

		// If the corresponding view doesn't exist, show 404
		if(!file_exists(APPPATH.'views/'.$page.'.php')) {
			show_404();
		}

		// Load the view
		if(!isset($data['title'])) {
			$data['title'] = ucfirst(strtolower($page));
		}
		$this->template->load($page, $data);

	}

	// About pages
	public function about($page = null) {
		// If page is null, make it 'about'
		if(!$page) $page = 'about';

		$data['fixed_container'] = true;
		$data['title'] = ucfirst(strtolower($page));
		$this->show('about/'.$page, $data);
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */