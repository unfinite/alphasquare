<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
  }

  public function index($tab = 'account') {
    echo $tab;
  }

}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */