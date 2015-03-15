<?php

/*
Validate Helper Functions
*/

if(!function_exists('valid_username')) {
	function valid_username($str) {
	    $regex = "/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/";
	    return preg_match($regex, $str);
	}
}

if(!function_exists('valid_email')) {
	function valid_email($email) {
	    $regex = "/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i";
	    return preg_match($regex, $email);
	}
}

if(!function_exists('valid_url')) {
	function valid_url($str) {
		$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
		if (!preg_match($pattern, $str)) {
			return FALSE;
		}
		return TRUE;
	}
}

/* End */