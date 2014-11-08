<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extra Design Elements Library
 *
 * A library of extra design elements you can call using PHP. 
 *
 * Includes: Bootstrap modals, JS elements, etc.
 *
 * Q: Why a library?
 * A: The name says it. Extra. They include extra code that, for performance purposes, is not included everywhere.
 *
 * @package libraries
 */

class Extras {

  public function __construct() {
    $this->CI =& get_instance();
  }

  public function modal($data) {

    $modal =  "
    <div class=\"modal fade\" id=\"modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modallabel\" aria-hidden=\"true\">
      <div class=\"modal-dialog\">
        <div class=\"modal-content\">
          <div class=\"modal-header\">
            <button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
            <h4 class=\"modal-title\" id=\"modal\">".$data['title']."</h4>
          </div>
          <div class=\"modal-body\">
            ".$data['body']."
          </div>
          <div class=\"modal-footer\">
            ".$data['footer']."
            <button type=\"button\"class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
          </div>
        </div>
      </div>
    </div>
    ";

    return $modal;


  }



}

/* End of file designlib.php */
/* Location: ./application/libraries/designlib.php */