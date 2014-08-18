<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Account Model
 * @package Models
 */

class Account_model extends CI_Model {

	/**
	 * Verifies username and password is correct and logs the user in
	 * @param  string $username 
	 * @param  string $password 
	 * @return bool Whether or not the details are correct.
	 */
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

	/**
	 * Creates an account
	 * @param  string $username
	 * @param  string $email
	 * @param  string $password
	 * @return bool Whether or not the creation succeeded.
	 */
	public function create($username, $email, $password) {
		$data = array(
			'username' => $username,
			'password' => sha1($password),
			'email' => $email,
			'joined' => time()
		);
		$insert = $this->db->insert('users', $data);
		if($insert) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Generates a token for resetting password
	 * @param  int $userid The user's ID
	 * @return string|bool If token was created, it is returned; on error false is returned
	 */
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
		$bind = array($userid, $token, $time);
		$query = $this->db->query($sql, $bind);
		return $query ? $token : false;
	}

	/**
	 * Delete a forgot password token
	 * @param  string $token The token to delete
	 * @return bool Whether or not the token was deleted.
	 */
	public function delete_password_token($token) {
		$this->db->where('token', $token);
		return $this->db->delete('forgot_password');
	}

	/**
	 * Validates a password token
	 * @param  string $token The token to validate
	 * @return array|bool Returns token info on success; on error false is returned
	 */
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