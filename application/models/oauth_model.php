<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oauth_model extends CI_Model {

  public $variable;

  public function __construct() {
    parent::__construct();
    
  }

  /**
   * Get a user's info by their OAuth UID
   * @param  string $provider The OAuth provider
   * @param  string $uid The OAuth user id
   * @return bool
   */
  public function info($provider, $uid) {
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
  public function provider_used($provider, $userid = null) {
    if(!$userid) {
      $userid = $this->php_session->get('userid');
    }
    $this->db->select('id')
             ->from('user_oauth')
             ->where(array('oauth_provider'=>$provider,'userid'=>$userid));
    return $this->db->count_all_results() > 0 ? true : false;
  }

  /**
   * Checks if OAuth account is already connected to an Alphasquare account
   * @param  string $provider  The OAuth provider
   * @param  string|int $oauth_uid The OAuth provided UID
   * @return bool
   */
  public function already_connected($provider, $oauth_uid) {
    $this->db->select('id')
             ->from('user_oauth')
             ->where(array('oauth_provider'=>$provider,'oauth_uid'=>$oauth_uid));
    return $this->db->count_all_results() > 0 ? true : false;
  }

  /**
   * Gets a list of OAuth accounts connected 
   * @return array
   */
  public function get_connected() {
    $userid = $this->php_session->get('userid');
    $this->db->select('*')
             ->from('user_oauth')
             ->where('userid', $userid);
    $accounts = $this->db->get()->result_array();
    $connected = array();
    foreach($accounts as $row) {
      $connected[] = $row['oauth_provider'];
    }
    return $connected;
  }

  /**
   * Creates an account from OAuth provider
   * @param  string $oauth_provider The OAuth provider/service.
   * @param  string $oauth_uid The user id on the OAuth provider.
   * @param  string $email
   * @param  string $username
   * @return bool Whether or not the creation succeeded.
   */
  public function create($oauth_provider, $oauth_uid, $name, $username, $email, $location, $photo) {
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
      $this->connect_account($oauth_provider, $oauth_uid, $userid);
      $data['id'] = $userid;
      return $data;
    }
    else {
      return false;
    }
  }

  /**
   * Connect an account to an OAuth provider 
   * 
   * Inserts row into user_oauth
   * 
   * @param  string $oauth_provider The provider
   * @param  int $oauth_uid      The OAuth UID
   * @param  int $userid         The local user ID
   * @return bool
   */
  public function connect_account($oauth_provider, $oauth_uid, $userid = null) {
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

  public function disconnect($provider) {
    $where = array(
      'oauth_provider' => $provider
    );
    $delete = $this->db->delete('user_oauth', $where);
    if($this->db->affected_rows() < 1) {
      throw new Exception("Your account wasn't connected to $provider.");
    }
    else {
      $this->clear_oauth_session();
      return true;
    }
  }

  public function clear_oauth_session() {
    $this->php_session->delete('oauth_new_account');
    $this->php_session->delete('oauth_connect_account');
    $this->php_session->delete('oauth_choose');
    $this->php_session->delete('oauth_provider');
    $this->php_session->delete('oauth_user_profile');
  }

}

/* End of file  */
/* Location: ./application/models/ */