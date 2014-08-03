<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Template {

        private $template_data = array();

        private function set($name, $value) {
            $this->template_data[$name] = $value;
        }

        public function load($view = '', $view_data = array(), $template = 'templates/master', $return = FALSE) {

            $CI =& get_instance();

            $view_data['session'] = $CI->php_session;
            $view_data['loggedin'] = $CI->php_session->get('loggedin');

            $title = $view_data['title'].' - Alphasquare';
            $this->set('title', $title);

            $contents = $CI->load->view($view, $view_data, true);
            $this->set('contents', $contents);

            // pass extra meta tags to view if defined
            $meta = '';
            if(isset($view_data['meta'])) {
                $CI->load->helper('html');
                $meta = meta($view_data['meta']);
            }
            $this->set('extra_meta', $meta);

            // Load alert box HTML
            $msg_box_data = array('msg' => show_msg());
            $msg_box = $CI->load->view('templates/msg_box', $msg_box_data, true);
            $this->set('msg', $msg_box);

            $output = $CI->load->view($template, $this->template_data, true);

            if($return) return $output;
            else echo $output;
        }
}

/* End of file Template.php */
/* Location: ./application/libraries/template.php */