<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Extra URL Helper functions
 * MY_url_helper.php
 * In CI, prepending "MY_" extends the helper or library
 */

if(!function_exists('profile_url')) {
	function profile_url($username = null) {
		if(is_null($username)) {
			$username = $this->php_session->get('username');
		}
		return base_url('people/'.$username);
	}
}

/* End of file MY_url_helper.php */