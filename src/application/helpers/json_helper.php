<?php 
/**
 * Helper functions for JSON
 * @package Helpers
 * @author Nathan Johnson
 */

/* No direct access allowed */
if(!defined('BASEPATH')) die('No direct script access allowed');


if(!function_exists('json_output')) {
	/**
	 * Outputs JSON from an array and sets the content type to application/json
	 * @param array $json The array to output as JSON
	 * @param bool $success Add "success":true/false to the JSON object
	 * @return void
	 */
	function json_output($json = array(), $success = null) {
		header("Content-Type: application/json");
		if(!is_null($success)) {
			$json['success'] = $success;
		}
		echo json_encode($json);
		exit;
	}
}

if(!function_exists('json_error')) {
	/**
	 * Call this to output error in JSON format
	 * @param  string $error      The error message to display
	 * @param  string $error_word A single word that represents the error (optional)
	 * @return void 
	 */
	function json_error($error, $error_word = '') {
		$data = array(
			'error_word' => $error_word,
			'error' => $error
		);
		json_output($data, false);
	}
}

if(!function_exists('json_success')) {
	/**
	 * Call this to output "success":true JSON
	 * @return void
	 */
	function json_success() {
		json_output(null, true);
	}
}

/* End of file json_helper.php */