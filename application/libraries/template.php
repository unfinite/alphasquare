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

      $CI->load->helper('html');

      // Pass extra meta tags to header if defined
      $meta = '';
      if(isset($view_data['meta'])) {
        $meta = meta($view_data['meta']);
      }
      $this->set('extra_meta', $meta);

      // Pass extra stylesheets (link tags) to header if defined
      $stylesheets = '';
      if(isset($view_data['stylesheets'])) {
        foreach($view_data['stylesheets'] as $href) {
          $stylesheets .= link_tag($href) . "\n";
        }
      }
      $this->set('extra_stylesheets', $stylesheets);

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