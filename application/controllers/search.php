<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Search page
 *
 * @package Controllers
 * @copyright (c) 2014 Alphasquare
 */

class Search extends CI_Controller {

  public function __construct() {
    parent::__construct();
    // For follows sidebar
    $this->load->model('people_model');
    $this->load->model('search_model');
  }

  public function index() {
    $query = $this->input->get('q');
    if($query) {
      $data['title'] = 'Results for '.$query;
      $data['query'] = $query;
      $results = $this->search_model->get_results($query);
      $data['results_count'] = count($results);
      $data['results_html'] = $this->debate_model->post_html($results, true);
      $this->template->load('search/results', $data);
    }
    else {
      $data['title'] = 'Find';
      $this->template->load('search/box', $data);
    }
  }

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */