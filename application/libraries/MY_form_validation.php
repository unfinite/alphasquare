<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    public function __construct() {
        parent::__construct();

        $this->_error_prefix = '<li>';
        $this->_error_suffix = '</li>';
    }

    function valid_url($str) {
    	if (!preg_match(REGEX_URL, $str)) {
    		$CI =& get_instance();
    		$CI->form_validation->set_message('valid_url', "The %s field must be a valid URL.");
    		return FALSE;
    	}
    	return TRUE;
    }

    function valid_username($str) {
        if (!preg_match(REGEX_USERNAME, $str)) {
            $CI =& get_instance();
            $CI->form_validation->set_message('valid_username', "%s may only contain letters, numbers, and underscores.");
            return FALSE;
        }
        return TRUE;
    }

}

/* End of file MY_form_validation.php */
/* Location: ./application/controllers/MY_form_validation.php */