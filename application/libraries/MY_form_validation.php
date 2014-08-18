<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * Extension of the CI Form Validation Class
 *
 * This extension to CI's form validation class:
 * - Adds valid_url and valid_username methods
 * - Changes error prefixes & suffixes to '<li></li>'
 */
class MY_Form_validation extends CI_Form_validation {

    public function __construct() {
        parent::__construct();

        $this->_error_prefix = '<li>';
        $this->_error_suffix = '</li>';
    }

    /**
     * Validate the URL
     * @param  string $str The URL to validate
     * @return bool
     */
    function valid_url($str) {
    	if (!preg_match(REGEX_URL, $str)) {
    		$CI =& get_instance();
    		$CI->form_validation->set_message('valid_url', "The %s field must be a valid URL.");
    		return FALSE;
    	}
    	return TRUE;
    }

    /**
     * Validate a username
     * @param  string $str The username to validate
     * @return bool
     */
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