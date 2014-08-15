<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Debate Controller
Anything to do with debates/posts is in this controller, like:
 - Creation
 - Deletion
 - Edit
 - Voting
 - etc.
*/

class Debate extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('debate_model');
		$this->load->model('people_model');
	}

	public function create() {
		login_required();
		$content = $this->input->post('content');
		$created = $this->debate_model->create($content);

		// If not ajax request, redirect user back to dashboard
		if(!$this->input->is_ajax_request()) {
			redirect('dashboard');
		}

		// If the post was created, turn array that the create method returned into JSON
		if($created) {
			json_output($created, true);
		}
		else {
			json_error('Sorry, we could not post your debate.');
		}
	}

	public function edit($id) {
		login_required();
	}

	// Individual post page
	// URL: /username/timestamp (config/routes.php)
	public function view($username, $timestamp) {
		// Load comments model
		$this->load->model('comments_model');
		// Get post info
		$info = $this->debate_model->get_info($username, $timestamp);
		// If post does not exist, show 404 page
		if(!$info) {
			show_404();
		}
		$data['title'] = 'Debate';
		$data['info'] = $info;
		// Load post html
		$data['post_html'] = $this->debate_model->post_html($info,false,true);
		// Get comments
		$comments = $this->comments_model->get_all($info['id']);
		$data['comments'] = $this->comments_model->comment_html($comments, true);
		// Load post view page
		$this->template->load('posts/view', $data);
	}

	// Voting on posts
	public function vote($type = 'up') {
		login_required();
		$id = $this->input->post('id');
		usleep(500*100);
		if(!$this->debate_model->exists($id)) {
      json_error('That post does not exist');
    }
		if(!$id) die('No ID provided');
		switch($type) {
			case 'up':
			case 'down':
				$status = $this->debate_model->vote($type, $id);
			break;
			case 'remove':
				$status = $this->debate_model->remove_vote($id);
			break;
		}
		$counts = $this->debate_model->get_vote_counts($id);
		json_output($counts, $status);
	}

	// Delete post
	public function delete($id) {
		login_required();
	}

	// Load more / Infinite scrolling
	public function load_more() {
		$limit = 10;
		$offset = $this->input->get('offset');
		$type = $this->input->get('type');
		$params = array();
		if($type === 'profile') {
			$params['user_id'] = $this->input->get('user_id');
		}
		// Get posts
		$posts = $this->debate_model->get_posts($type, 'desc', $offset, $limit, $params);
		// Get HTML for the posts
		$html = $this->debate_model->post_html($posts, true);
		// Output JSON
		$json = array(
			'html' => $html,
			'count' => count($posts)
		);
		json_output($json, true);
	}

	// Poll
	public function poll() {
		$latest_id = $this->input->get('latest_id');
		$type = $this->input->get('type');
		$params['latest_id'] = $latest_id;
		// If on profile, do params
		if($type === 'profile') {
			$params['user_id'] = $this->input->get('user_id');
		}
		// Get new posts
		$posts = $this->debate_model->get_posts($type, 'desc', null, null, $params);
		// Get HTML for the posts
		$html = $this->debate_model->post_html($posts, true);
		// Output JSON
		$json = array(
			'html' => $html,
			'count' => count($posts)
		);
		json_output($json, true);
	}

}

/* End of file debate.php */
/* Location: ./application/controllers/debate.php */