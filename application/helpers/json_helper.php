<?php

if(!defined('BASEPATH')) die('No direct script access allowed');

// Call this to output an array as JSON
// First parameter is the array
// Second parameter is success: true or false
if(!function_exists('json_output')) {
	function json_output($json = array(), $success = null) {
		header("Content-Type: application/json");
		if(!is_null($success)) {
			$json['success'] = $success;
		}
		echo json_encode($json);
		exit;
	}
}

// Call this to output error in JSON format
if(!function_exists('json_error')) {
	function json_error($error, $error_word = '') {
		$data = array(
			'error_word' => $error_word,
			'error' => $error
		);
		json_output($data, false);
	}
}

// Call this to output JSON { "success": true }
if(!function_exists('json_success')) {
	function json_success() {
		json_output(null, true);
	}
}

/* End of file json_helper.php */