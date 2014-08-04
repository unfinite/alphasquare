<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Debate Controller
Anything to do with debates/posts is in this controller, like:
 - Creation
 - Deletion
 - Edit
 - Votes
 - etc.
*/

class Debate extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('debate_model');
	}

	public function create() {
		$content = $this->input->post('content');
		$created = $this->debate_model->create($content);
		if($created) {
			json_output($created, true);
		}
		else {
			json_output(null, false, 'Sorry, we could not post your debate at this time.');
		}
	}

	public function edit($id) {

	}

	public function show($id) {

	}

	public function vote($type, $id) {

	}

	public function delete($id) {

	}

}

/* End of file debate.php */
/* Location: ./application/controllers/debate.php */