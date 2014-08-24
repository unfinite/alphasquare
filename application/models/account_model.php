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
	public function auth($username, $password) {
		// Hash password
		$password = hash('sha256', $password);
		// Get user's information
		$this->db->select('id, password, username, email, avatar')
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
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * Get a user's info by their OAuth UID
   * @param  string $provider The OAuth provider
   * @param  string $uid The OAuth user id
   * @return bool
   */
  public function oauth_info($provider, $uid) {
    $where = array(
      'o.oauth_provider' => $provider,
      'o.oauth_uid' => $uid
    );
    $this->db->select('o.oauth_provider, o.oauth_uid,
                       u.id, u.username, u.email, u.avatar')
             ->from('user_oauth o')
             ->join('users u', 'u.id = o.userid', 'left')
             ->where($where)
             ->limit(1);
    $query = $this->db->get();
    return $query->num_rows ? $query->row_array() : false;
  }

  /**
   * Checks if user account is connected with an OAuth provider already
   * @param string $provider The OAuth provider
   * @param string $oauth_uid The OAuth UID
   * @param int $userid The user's local ID
   * @return bool
   */
  public function oauth_provider_used($provider, $userid = null) {
    if(!$userid) {
      $userid = $this->php_session->get('userid');
    }
    $this->db->select('id')
             ->from('user_oauth')
             ->where(array('oauth_provider'=>$provider,'userid'=>$userid));
    return $this->db->count_all_results() > 0 ? true : false;
  }

  /**
   * Creates an account from OAuth provider
   * @param  string $oauth_provider The OAuth provider/service.
   * @param  string $oauth_uid The user id on the OAuth provider.
   * @param  string $email
   * @param  string $username
   * @return bool Whether or not the creation succeeded.
   */
  public function oauth_create($oauth_provider, $oauth_uid, $name, $username, $email, $location, $photo) {
    $this->load->helper('avatar_helper');
    $photo_url = avatar_from_url($photo);
    $data = array(
      'name' => $name,
      'username' => $username,
      'email' => $email,
      'location' => $location,
      'joined' => time(),
      'avatar' => $photo_url
    );
    $insert = $this->db->insert('users', $data);
    if($insert) {
      $userid = $this->db->insert_id();
      $this->oauth_connect_account($oauth_provider, $oauth_uid, $userid);
      $data['id'] = $userid;
      return $data;
    }
    else {
      return false;
    }
  }

  public function oauth_connect_account($oauth_provider, $oauth_uid, $userid = null) {
    if(!$userid) {
      $userid = $this->php_session->get('userid');
    }
    $data = array(
      'userid' => $userid,
      'oauth_provider' => $oauth_provider,
      'oauth_uid' => $oauth_uid
    );
    $insert = $this->db->insert('user_oauth', $data);
    return $insert;
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