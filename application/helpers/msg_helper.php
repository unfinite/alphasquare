<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('msg')) {
	function msg($msg, $type = "danger", $css = null) {
		$CI =& get_instance();
		$CI->php_session->set_flashdata('msg_text', $msg);
		$CI->php_session->set_flashdata('msg_type', $type);
		if($css) $CI->php_session->set_flashdata('msg_style', $css);
	}
}

if (!function_exists('show_msg')) {
	function show_msg() {
	    $CI =& get_instance();
	    $msg = array();
	    $msg['text'] = $CI->php_session->flashdata('msg_text');
	    $msg['type'] = $CI->php_session->flashdata('msg_type');
	    $msg['style'] = $CI->php_session->flashdata('msg_style');
	    $msg['exists'] = ($msg['text'] && $msg['type']);
	    return $msg;
	}
}

if (!function_exists('msg_list_errors')) {
	function msg_list_errors($errors, $redirect = null, $return = false) {
		$CI =& get_instance();
		$content = $CI->load->view('templates/error_list', array('errors'=>$errors), true);
		if($return) return $content;
		else msg($content, 'danger');
		if($redirect) redirect($redirect);
	}
}

if (!function_exists('show_form_errors')) {
	function show_form_errors($errors) {
		$CI =& get_instance();
		$CI->load->view('templates/validation_errors', array('errors'=>$errors));
	}
}

if (!function_exists('login_required')) {
	function login_required() {
		$CI =& get_instance();
		if($CI->php_session->get('loggedin')) {
			return false;
		}
		// If it's an ajax request, return json
		if($CI->input->is_ajax_request()) {
			header("Content-Type: application/json");
			header("HTTP/1.0 401 Unauthorized");
			json_error('Please sign in to do that.', 'login');
		}
		// Else redirect page
		else {
			msg('Please sign in to continue.', 'info');
			redirect('login?next='.current_url());
		}
	}
}


/* End of file msg_helper.php */
/* Location: ./application/helpers/msg_helper.php */