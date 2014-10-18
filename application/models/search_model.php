<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Search model
 * @package Models
 * @copyright (c) 2014 Alphasquare
 */
class Search_model extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  /**
   * Search debates
   * @param  string $query The search query
   * @return string The results
   */
  public function get_results($query, $offset = 0) {
    $this->load->model('debate_model');
    $params = array('query' => $query);
    $limit = 20;
    $results = $this->debate_model->get_posts('search', $offset, $limit, $params);
    return $results;
  }

}

/* End of file search_model.php */
/* Location: ./application/models/search_model.php */