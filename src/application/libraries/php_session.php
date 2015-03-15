<?php if(!defined('BASEPATH')) exit( 'No direct script access allowed' );

// -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
// I likey what you did here, Nathan! 
// Great work on this package. 
// Would love if there was a regenerate sessid option. 
// Maybe I'll work on that tomorrow and on expanding this.
// -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-

/**
 * PHP Session Library
 * 
 * @package Libraries
 * @author Nathan Johnson
 */

class PHP_session {

  public function __construct()
  {
    $this->start();
  }

  /**
   * Start a session
   * @access public
   * @return void
   */
  public function start()
  {
    $session_name = 'session'; // Set a custom session name
    $secure = false; // Set to true if using https.
    $httponly = true; // This stops javascript being able to access the session id.
    ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
    $cookieParams = session_get_cookie_params(); // Gets current cookies params.
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    session_name($session_name); // Sets the session name to the one set above.

    if(!isset($_SESSION)) session_start();
  }

  /**
   * Destroy a session
   * @access public
   * @return void
   */
  public function destroy()
  {
    session_destroy();
    $_SESSION = array();
  }

  /**
   * Set a value in the session
   *
   * If $key is an assoc. array it will loop through it 
   * and put all of the items in the session.
   * 
   * @access public
   * @param string|array  $key     Name of the session item
   * @param string        $value   Value of the session item
   */
  public function set($key, $value = null)
  {
    if(is_array($key)) {
      foreach($key as $k => $v) {
        $_SESSION[$k] = $v;
      }
    }
    else {
      $_SESSION[$key] = $value;
    }
  }

  /**
   * Get a session item's value
   * @access public
   * @param  string $key
   * @return string|null
   */
  public function get($key)
  {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
  }

  /**
   * Regenerate the session ID
   * @access public
   * @param  boolean $del_old Whether or not to delete the old ID
   * @return void
   */
  public function regenerate_id($del_old = false)
  {
    session_regenerate_id($del_old);
  }

  /**
   * Delete a session item
   * @access public
   * @param  string $key The key of the session item to delete
   * @return void
   */
  public function delete($key)
  {
    unset($_SESSION[$key]);
  }

  /**
   * Retreive flashdata
   *
   * Flashdata is simply a session item that self-destructs after it is used
   * 
   * @param  string $key
   * @return string
   */
  public function flashdata($key)
  {
    $key = 'flashdata_'.$key;
    $value = $this->get($key);
    $this->delete($key);
    return $value;
  }

  /**
   * Set flashdata
   * @param string $key   The key of the flashdata item
   * @param string $value The value of the flashdata item
   */
  public function set_flashdata($key, $value)
  {
    $this->set('flashdata_'.$key, $value);
  }

}

/* End of file php_session.php */
/* Location: ./application/libraries/php_session.php */