<?php

if(!defined('BASEPATH')) die('No direct script access allowed');

if(!function_exists('json_output')) {
	function json_output($json = array(), $success = null, $error = null) {
		header("Content-Type: application/json");
		if(!is_null($success)) {
			$json['success'] = $success;
		}
		if(!is_null($error)) {
			$json['error'] = $error;
		}
		echo json_encode($json);
		exit;
	}
}

if(!function_exists('json_error')) {
	function json_error($error, $error_word = '') {
		json_output(array(
			'error_word' => $error_word,
			'error' => $error
		), false);
	}
}

/* End of file json_helper.php */