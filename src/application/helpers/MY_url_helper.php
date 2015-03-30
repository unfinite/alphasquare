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

if(!function_exists('avatar_url')) {
	/**
	 * Get the URL to a user's avatar
	 * 
	 * If $avatar is null, it will use gravatar from email
	 * 
	 * @param  string  $email   [description]
	 * @param  string  $avatar  [description]
	 * @param  integer $size    [description]
	 * @return [type]           [description]
	 */
	function avatar_url($avatar = null, $email = null, $size = 80) {
	    if(!$avatar && !$email) {
	    	$CI =& get_instance();
	    	$avatar = $CI->php_session->get('avatar');
	    	$email = $CI->php_session->get('email');
	    }
	    //if($avatar) {
	    //	$url = base_url("avatars/".$avatar);
	    //} 
	    //else {
	    $url = gravatar_url($email, $size);
	    //}
	    return $url;
	}
}

/* End of file MY_url_helper.php */
