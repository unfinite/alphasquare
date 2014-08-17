<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Alerts Controller
*/

class Alerts extends CI_Controller {

	public function __construct() {
		parent::__construct();
		login_required();
		$this->load->model('alerts_model');
		$this->load->library('alert');
	}

	// Alerts page
	public function index() {
		$data['title'] = 'Alerts';
		$this->load->view('alerts/page', $data);
	}

	// View an alert object
	public function view($id) {
		$url = $this->alert->get_url($id);
		// If alert doesn't exist (or user doesn't own it), $url will be false
		if(!$url) {
			show_404();
		}
		// Mark the alert as clicked
		$this->alert->mark_as_clicked($id);
		// Redirect to the object
		redirect($url);
	}

	// Alerts modal
	public function modal() {
		// Limit to 30 alerts, rest can be viewed on page
		$data['alerts'] = $this->alert->get_all(30);
		$this->load->view('alerts/alerts', $data);
	}

	// Poll alert count
	public function poll() {
		$count = $this->alert->get_unread_count();
		if($count !== false) {
			$json = array('unread'=>$count);
			json_output($json, true);
		}
		else {
			json_error('Sorry, an error occurred.');
		}
	}

	// Mark alert as read
	public function mark_read() {
		$id = $this->input->post('id');
		if(!$id) json_error('No id provided');
		$this->alert->mark_as_clicked($id);
		$json = array('id'=>$id);
		json_output($json, true);
	}

	// Delete an alert
	public function delete() {
		$id = $this->input->post('id');
		if(!$id) json_error('No id provided');
		// Get the alert's info
		$info = $this->alert->get_info($id);
		// Check if user owns alert
		if(!$info || $this->php_session->get('userid') !== $info['to']) {
			json_error('That alert was not sent to you or it does not exist.');
		}
		// Finally delete the alert
		if($this->alert->delete($id)) {
			json_output(array('id'=>$id), true);
		}
		else {
			json_error('Sorry, could not delete alert.');
		}
	}

}

/* End of file alerts.php */
/* Location: ./application/controllers/alerts.php */