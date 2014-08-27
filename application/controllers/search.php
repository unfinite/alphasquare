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


  /**
   * Search Alphasquare
   * 
   * @return [type] [description]
   */
  public function index() {
    $query = $this->input->get('q');
    if($query) {

      // Get search results
      $results = $this->search_model->get_results($query);

      // Get count
      $data['results_count'] = count($results);

      // Get HTML of the posts for the search results
      $data['results_html'] = $this->debate_model->post_html($results, true);
      
      // Encode special characters with their HTML entities
      $query = htmlspecialchars($query);
      $data['title'] = 'Search results for '.$query;
      $data['query'] = $query;

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