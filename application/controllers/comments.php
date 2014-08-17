<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Comments Controller
Anything to do with comments
*/

class Comments extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('comments_model');
		login_required();
	}

	public function create() {

		$postid = $this->input->post('postid');
		$content = trim($this->input->post('content'));

		$this->load->model('debate_model');
		$info = $this->debate_model->get_basic_info($postid);
		if(!$info) {
			json_error('That post does not exist.');
		}

		if(strlen($content) < 1) {
			json_error('Please enter a comment.');
		}

		$created = $this->comments_model->create($postid, $content);
		if($created) {
			// Send the debate owner an alert
			$this->load->library('alert');
			$this->alert->create($info['userid'], 'comment', 'debate', $created['id']);
			// Debate HTML
			$html = $this->comments_model->comment_html($created, false);
			// Output JSON with the comment's html
			$data = array('html' => $html);
			json_output($data, true);
		}
		else {
			json_error('Sorry, your comment could not be posted. Please try again later.');
		}

	}

	public function load_all() {
		$id = $this->input->get('id');
		// Get comments on this post (null = no limit)
		$comments = $this->comments_model->get_all($id, null);
		// Load comments HTML
		$html = $this->comments_model->comment_html($comments, true);
		// Output JSON
		json_output(array('html' => $html), true);
	}

	public function poll() {
		$postid = $this->input->get('postid');
		$startid = $this->input->get('startid');
		// Get comments newer than $startid
		$comments = $this->comments_model->get_all($postid, null, null, $startid);
		// Load comments HTML
		$html = $this->comments_model->comment_html($comments, true);
		// Output JSON
		json_output(array('html' => $html), true);
	}

}

/* End of file comments.php */
/* Location: ./application/controllers/comments.php */