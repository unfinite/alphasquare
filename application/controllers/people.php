<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
People Controller
Anything to do with displaying users and their profiles
Also for actions such as following, reporting, etc.
*/

class People extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('people_model');
		$this->load->model('account_model');
	}

	public function index($tab = null) {
		if(!$tab) {
			redirect('people/popular');
		}
		$data['title'] = 'People';
		$data['tab'] = $tab;
		$users = $this->people_model->get_list($tab);
		$data['users'] = $this->load->view('people/list_users', array('users'=>$users), true);
		$this->template->load('people/main', $data);
	}

	public function profile($username, $tab = 'debates') {
		$this->load->model('debate_model');
		$this->load->helper('format_post');

		// Get user's info
		$data = $this->people_model->get_info($username, 'username');

		// If user doesn't exist, show 404
		if(!$data) {
			show_404();
		}

		$tab_data = $data;
		switch($tab) {
			case null:
			case 'debates':
				// Get user's posts
				$posts = $this->debate_model->get_posts('profile', 'desc', null, null, array('user_id' => $data['id']));
				$tab_data['posts'] = $this->debate_model->post_html($posts, true);
				$tab_data['posts_count'] = count($posts);
				$data['tab_content'] = $this->load->view('people/profile/tab/debates', $tab_data, true);
			break;
			case 'comments':
				$data['tab_content'] = $this->load->view('people/profile/tab/comments', $tab_data, true);
			break;
			case 'about':
				$data['tab_content'] = $this->load->view('people/profile/tab/about', $tab_data, true);
			break;
			case 'followers':
			case 'following':
				$tab_data['users'] = $this->people_model->get_follows($tab, $data['id']);
				$data['tab_content'] = $this->load->view('people/list_users', $tab_data, true);
			break;
			default:
				show_404();
			break;
		}

		$data['tab'] = $tab;
		$data['title'] = $data['username'] . "'s Profile";
		if($tab) {
			 $data['title'] .= ' - '.ucfirst($tab);
		}
		if(!$data['location']) {
			$data['location'] = 'Earth';
		}
		$data['avatar'] = gravatar_url($data['email'], 100);

		// Check if logged in user is following this user
		$data['is_following'] = $this->people_model->is_following($data['id']);

		$data['stylesheets'] = array('assets/css/profile.css');

		$this->template->load('people/profile/page', $data);
	}

	public function follow($id) {
		login_required();
		if($id == $this->php_session->get('userid')) {
			json_error('You cannot follow yourself.');
		}
		$follow = $this->people_model->follow('follow', $id);
		if($follow) {
			json_output(null,true);
		}
		else {
			json_output(null,false,'Sorry, an error occurred.');
		}
	}

	public function unfollow($id) {
		login_required();
		if($id == $this->php_session->get('userid')) {
			json_error('You cannot follow yourself.');
		}
		$follow = $this->people_model->follow('unfollow', $id);
		if($follow) {
			json_output(null,true);
		}
		else {
			json_output(null,false,'Sorry, an error occurred.');
		}
	}


}

/* End of file people.php */
/* Location: ./application/controllers/people.php */