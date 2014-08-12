<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Account Model
*/

class Account_model extends CI_Model {

	// Login to an account
	public function login($username, $password) {
		// Hash password
		$password = sha1($password);
		// Get user's information
		$this->db->select('id, password, username, email')
						 ->from('users')
						 ->where('username', $username)
						 ->limit(1);
		$info = $this->db->get()->row_array();
		// If username doesn't exist or password doesn't match
		if(!$info || $info['password'] !== $password) {
			return false;
		}
		else {
			// Add some extra variables to $info
			$info['loggedin'] = true;
			$info['userid'] = $info['id'];
			// Remove password from $info
			unset($info['password']);
			// Put the items in $info into the session
			$this->php_session->set($info);
			return true;
		}
	}

	// Create an account
	public function create($username, $email, $password) {
		$data = array(
			'username' => $username,
			'password' => sha1($password),
			'email' => $email,
			'signup_date' => time()
		);
		$insert = $this->db->insert('users', $data);
		if($insert) {
			return true;
		}
		else {
			return false;
		}
	}

	// Generate a token to use for password reset
	public function create_password_token($userid) {
		$this->load->helper('string');
		$token = random_string('unique');
		$time = time();

		// Using regular SQL because ActiveRecord doesn't have
		// an easy way to do ON DUPLICATE KEY UPDATE
		$sql = 'INSERT INTO forgot_password (userid, `token`, created)
		        VALUES (?, ?, ?)
		        ON DUPLICATE KEY UPDATE
		        	token = VALUES(token),
		          created = VALUES(created)';
		$query = $this->db->query($sql, array($userid, $token, $time));
		return $query ? $token : false;
	}

	// Delete password reset token
	public function delete_password_token($token) {
		$this->db->where('token', $token);
		return $this->db->delete('forgot_password');
	}

	// Validate a password token
	public function validate_password_token($token) {
		// Get the information of the token
		$this->db->select('token, userid, created')
						 ->from('forgot_password')
						 ->where('token', $token)
						 // Make sure the token is less than 24 hrs old
						 ->where('created+(60*60*24) > UNIX_TIMESTAMP()', null, false)
						 ->limit(1);
		$query = $this->db->get();
		if($query->num_rows < 1) {
			// Delete expired tokens
			$this->db->where('created+(60*60*24) < UNIX_TIMESTAMP()', null, false);
			$this->db->delete('forgot_password');
			return false;
		}
		else {
			return $query->row_array();
		}
	}

}

/* End of file account_model.php */
/* Location: ./application/models/account_model.php */