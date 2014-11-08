<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Account Model
 * @package Models
 */


class Account_model extends CI_Model {

	/**
	 * Verifies username and password is correct
	 * @param  string $username 
	 * @param  string $password 
	 * @return bool Whether or not the details are correct.
	 */
	public function authenticate($username, $password) {
		// Hash password
		$password = hash('sha256', $password);
		// Get user's information
		$this->db->select('id, password, username, email, avatar, employee, points')
						 ->from('users')
						 ->where('username', $username)
						 ->limit(1);
		$info = $this->db->get()->row_array();
		// If username doesn't exist or password doesn't match
		if(!$info || $info['password'] !== $password) {
      if($info) {
        // Log failed login event
        $this->events->log('account', 'login_fail', null, $info['id']);
      }
			return false;
		}
		else {
			$this->login($info);
      // Log succeeded login in events
      $this->events->log('account', 'login');
			return true;
		}
	}

  /**
   * Log the user in
   * @param  array $info The info of the user logging in
   * @return true
   */
  public function login($info) {
    // Add some extra variables to $info for session
    $info['loggedin'] = true;
    $info['userid'] = $info['id'];
    // Remove password from $info
    unset($info['password']);
    // Put the items in $info into the session
    $this->php_session->set($info);
    // Update last login
    $this->db->where('id', $info['id']);
    $this->db->update('users', array('last_login'=>time()));
    return true;
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
      'password' => hash('sha256', $password),
      'email' => $email,
      'joined' => time()
    );
    $insert = $this->db->insert('users', $data);
    if($insert) {
      // Log creation
      $this->events->log('account', 'create', null, $this->db->insert_id());
      return true;
    }
    else {
      return false;
    }
  }

  /** 
   * Checks if the logged in user's password is correct
   *
   * Uses current user ID and checks if their password is correct.
   *
   * @param string $password The password the user entered
   * @return bool
   */
  public function password_correct($password) {
    $password = strlen($password) > 0 ? hash('sha256', $password) : '';
    $this->db->select('id')
             ->from('users')
             ->where('password', $password)
             ->where('id', $this->php_session->get('userid'));
    $count = $this->db->count_all_results();
    return $count ? true : false;
  }

  public function change_password($password) {
    $hashed = hash('sha256', $password);
    $this->db->where('id', $this->php_session->get('userid'));
    return $this->db->update('users', array('password'=>$hashed));
  }

  public function change_password_uid($uid, $password) {
    $hashed = hash('sha256', $password);
    $this->db->where('id', $uid);
    return $this->db->update('users', array('password'=>$hashed));
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
	 * Retrieves data for token
	 * @param  int $token the user's token
	 * @return array array of data
	 */
	public function retrieve_data_token($token) {

		$this->db->select('token, userid')
						 ->from('forgot_password')
						 ->where('token', $token)
						 ->limit(1);
		$query = $this->db->get();
		$rowcount = $query->num_rows();

		if ($rowcount == 0) {

			return false;

		} else {

			return $this->db->get()->row_array();

		}

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