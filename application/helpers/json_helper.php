<?php

if(!defined('BASEPATH')) die('No direct script access allowed');

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

/* End of file json_helper.php */