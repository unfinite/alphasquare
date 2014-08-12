<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Extra URL Helper functions
 * MY_url_helper.php
 * In CI, prepending "MY_" extends the helper or library
 */

if(!function_exists('profile_url')) {
	function profile_url($username = null) {
		if(is_null($username)) {
			$CI =& get_instance();
			$username = $CI->php_session->get('username');
		}
		return base_url('people/'.strtolower($username));
	}
}

if(!function_exists('gravatar_url')) {
	function gravatar_url($email = null, $size = 80, $default = "identicon", $rating = "pg") {
	    if(!$email) {
	    	$CI =& get_instance();
	    	$email = $CI->php_session->get('email');
	    }
	    $emailHash = md5(strtolower(trim($email)));
	    $url = "http://gravatar.com/avatar/{$emailHash}?s={$size}&d={$default}&r={$rating}";
	    return $url;
	}
}

/* End of file MY_url_helper.php */