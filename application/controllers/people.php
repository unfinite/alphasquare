<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * People Controller
 * Anything to do with displaying users and their profiles
 * Also for actions such as following, reporting, etc.
 *
 * @package Controllers
*/

class People extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('people_model');
		$this->load->model('account_model');
	}

	/**
	 * People list page
	 * URL: /people/[popular|new|recent]
	 *
	 * @param string $tab
	 */
	public function index($tab = null) {
		if(!$tab) {
			redirect('people/list/popular');
		}
		$data['title'] = 'People';
		$data['tab'] = $tab;
		$users = $this->people_model->get_list($tab);
		$data['users'] = $this->load->view('people/list_users', array('users'=>$users), true);
		$this->template->load('people/main', $data);
	}

	/**
	 * Profile page
	 * URL: /people/username
	 *
	 * @param string $username
	 * @param string $tab The profile tab to show
	 */
	public function profile($username, $tab = 'debates') {
		$this->load->model('debate_model');
		$this->load->helper('format_post');

		// Get user's info
		$data = $this->people_model->get_info($username, 'username');

		// If user doesn't exist, show 404
		if(!$data) {
			show_404();
		}

		$id = $data['id'];

		$data['tab'] = $tab;
		$data['title'] = $data['username'] . "'s Profile";
		if($tab) {
			 $data['title'] .= ' - '.ucfirst($tab);
		}
		if(!$data['location']) {
			$data['location'] = 'Earth';
		}
		if($data['birthday']) {
			$data['birthday_formatted'] = date('F jS, Y', strtotime($data['birthday']));

			// Get age from DOB
			$dob = new DateTime($data['birthday']);
			$now = new DateTime();
			$interval = $now->diff($dob);
			$data['age'] = $interval->y;
		}
		$data['avatar'] = gravatar_url($data['email'], 100);
		$data['is_owner'] = ($this->php_session->get('userid') === $id);

		$tab_data = $data;
		switch($tab) {
			case null:
			case 'debates':
				// Get user's posts
				$posts = $this->debate_model->get_posts('profile', null, null, array('user_id' => $id));
				$tab_data['posts'] = $this->debate_model->post_html($posts, true);
				$tab_data['posts_count'] = count($posts);
				$data['tab_content'] = $this->load->view('people/profile/tab/debates', $tab_data, true);
			break;
			case 'comments':
				$data['tab_content'] = $this->load->view('people/profile/tab/comments', $tab_data, true);
			break;
			case 'about':
				$tab_data['total_debates'] = 5;
				$tab_data['total_comments'] = 5;
				$tab_data['links'] = $this->people_model->get_links($id);
				$data['tab_content'] = $this->load->view('people/profile/tab/about', $tab_data, true);
			break;
			case 'followers':
			case 'following':
				$tab_data['users'] = $this->people_model->get_follows($tab, $id);
				$data['tab_content'] = $this->load->view('people/list_users', $tab_data, true);
			break;
			default:
				show_404();
			break;
		}

		// Check if logged in user is following this user
		$data['is_following'] = $this->people_model->is_following($id);

		// Profile stylesheet
		$data['stylesheets'] = array('assets/css/profile.css');

		// Load the main profile page
		$this->template->load('people/profile/page', $data);
	}

	/**
	 * Edit profile function
	 *
	 * URL: /people/username/edit/type
	 * GET: loads the modal
	 * POST: saves the info
	 *
	 * @param string $username
	 * @param string $type The type of profile info being edited
	 */
	public function edit_profile($username, $type) {
		login_required(true);
		// If edit view doesn't exist
		if(!file_exists(APPPATH."views/people/profile/edit/{$type}.php")) {
			die('Invalid request!');
		}
		// If username of editing is not the logged in user
		if($username !== strtolower($this->php_session->get('username'))) {
			die('Access denied.');
		}
		// Get user info
		$info = $this->people_model->get_info($username, 'username');

		if($type == 'links') {
			$info['links'] = $this->people_model->get_links($info['id']);
		}

		// If form is being submitted
		if($this->input->post('save')) {
			$this->load->helper('validate');
			switch($type) {
				case 'basic':

					$name = trim($this->input->post('name'));
					$username = trim($this->input->post('username'));

					// If username is not equal to current username
					if($username != $info['username']) {
						// Check if username is valid
						if(!valid_username($username)) {
							json_error('<b>Username is invalid.</b> You may use only letters, numbers, and underscores.');
						}
						// Check if username is available
						else if($this->people_model->username_taken($username)) {
							json_error('That username is taken.');
						}
					}

					$data = array(
						'name' => $name,
						'username' => $username
					);

				break;
				case 'about':

					$tagline = trim($this->input->post('tagline'));
					$bio = trim($this->input->post('bio'));
					$birthday = trim($this->input->post('birthday'));
					$location = trim($this->input->post('location'));

					if(strlen($tagline) > 100) {
						json_error('Tagline cannot be longer than 100 chars.');
					}
					else if(strlen($bio) > 1500) {
						json_error('Bio cannot be longer than 1500 chars.');
					}
					else if(strlen($location) > 50) {
						json_error('Location cannot be longer than 50 chars.');
					}
					if(strlen($birthday) > 0) {
						$birthday_time = strtotime($birthday);
						// Check if birthday is correctly formatted date
						if(!$birthday_time) {
							json_error('Birthday is in an invalid format. Please use <b>YYYY-MM-DD</b>.');
						}
						// Transform date into YYYY-MM-DD format
						$birthday = date('Y-m-d', $birthday_time);
					}
					else {
						$birthday = null;
					}
					$data = array(
						'tagline' => $tagline,
						'bio' => $bio,
						'location' => $location,
						'birthday' => $birthday
					);

				break;
				case 'links':

					$website = $this->input->post('website');
					$links = $this->input->post('links');
					if(strlen($website['url']) > 0) {
						if(strlen($website['text']) < 1) {
							json_error('Enter text for your website URL.');
						}
						else if(!filter_var($website['url'], FILTER_VALIDATE_URL)) {
							json_error('Invalid website URL.');
						}
					}
					if(count($links) > 5) {
						json_error('You may not have more than 5 links.');
					}
					// Check if any links were added, deleted, or changed
					else if($links !== $info['links']) {
						$links_to_create = array();
						// Make sure $links is an array
						// If it's not then there are no links
						if(is_array($links)) {
							// Loop through links user inputted
							foreach($links as $link) {
								$text_len = strlen($link['text']);
								$url_len = strlen($link['url']);
								// If url and text isn't entered, skip to next
								if($text_len < 1 && $url_len < 1) {
									continue;
								}
								else if($text_len < 1) {
									json_error('One or more of the links you have entered is missing text.');
								}
								else if($text_len > 35) {
									json_error('The text for links cannot be longer than 35 chars.');
								}
								else if(!filter_var($link['url'], FILTER_VALIDATE_URL)) {
									json_error('One or more of the links you have entered has an valid URL.');
								}
								$links_to_create[] = array(
									'userid' => $info['id'],
									'text' => $link['text'],
									'url' => $link['url'],
									'created' => time()+mt_rand(1,30)
								);
							}
						}
						// Delete all the user's links (only feasible way to do this)
						$this->people_model->delete_links($info['id']);
						// Insert links
						if($links_to_create) {
							$this->people_model->create_links($links_to_create);
						}
					}
					$data = array(
						'website_title' => $website['text'],
						'website_url' => $website['url']
					);
				break;

				case 'favorites':
					$movies = trim($this->input->post('movies'));
					$tv = trim($this->input->post('tv'));
					$music = trim($this->input->post('music'));
					$quotes = trim($this->input->post('quotes'));
					if(strlen($movies) > 500 || strlen($tv) > 500 || strlen($music) > 500 || strlen($quotes) > 500) {
						json_error('Movies, TV, music, and quotes must be less than 500 chars.');
					}
					$data = array(
						'favorite_movies' => $movies,
						'favorite_tv' => $tv,
						'favorite_music' => $music,
						'favorite_quotes' => $quotes
					);
				break;
			}

			// Update info in DB
			$update = $this->people_model->update_info($data);
			if($update) {
				// Update info in php session
				$this->php_session->set($data);
				$json['url'] = profile_url($username).'/about';
				// Output JSON
				json_output($json, true);
			}
			else {
				json_error('Could not update profile info. Please try again.');
			}

		}
		// Else, load the edit view
		else {
			$this->load->view('people/profile/edit/'.$type, $info);
		}
	}

	/**
	 * Follow a user
	 * @param int $id User ID to follow
	 */
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

	/**
	 * Unfollow a user
	 * @param int $id User ID to unfollow
	 */
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