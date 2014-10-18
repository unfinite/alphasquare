<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Template library
 *
 * Use this to load a full page in a controller, rather than loading 
 * each view (header, footer, etc.) individually
 * 
 * @package Libraries
 * @author Nathan Johnson
 */

class Template {

    /**
     * Data to pass to the template
     * @var array
     */
    private $template_data = array();

    /**
     * Add an item to template_data
     * 
     * @param string $name 
     * @param string $value
     * @return void
     */
    private function set($name, $value) {
      $this->template_data[$name] = $value;
    }

    /**
     * Load a view into the main template
     * @param  string  $view      The view to load
     * @param  array   $view_data The data to pass to the view
     * @param  string  $template  The template to load the view into
     * @param  boolean $return    Whether or not to return the output as a HTML string
     * @return void|string
     */
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