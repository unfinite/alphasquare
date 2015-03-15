<?php

// Session shorthand helper function

function session_get($key) {
	$CI =& get_instance();
	return $CI->php_session->get($key);
}

/* End */