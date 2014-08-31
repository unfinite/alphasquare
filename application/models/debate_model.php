<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Debate Model
 *
 * @package Models
*/

class Debate_model extends CI_Model {

  /**
   * Get an array of posts depending on the params passed
   *
   * @param string $type The type of debates (dashboard, profile, etc.)
   * @param string $order The order of the posts (asc or desc)
   * @param int $offset The number of posts to start at
   * @param int $limit The number of posts to select (0 = all)
   * @param array $params An optional array of info (e.g. user id)
   * @return array An array of debates and their info
   */
  public function get_posts($type, $offset = 0, $limit = POST_DISPLAY_LIMIT, $params = array()) {
    $userid = $this->php_session->get('userid');
    $this->db->select('d.*, u.id as userid, u.username, u.email, u.avatar, v.vote')
             ->from('debates d')
             // Get post owner's info
             ->join('users u', 'u.id = d.userid', 'inner')
             // Get the vote that the logged in user made on this post
             ->join('votes v', "v.postid = d.id AND v.userid = '{$userid}'", 'left');

    // If latest_id param is present, add a statement to the WHERE clause
    if(isset($params['latest_id']) && $params['latest_id'] > 0) {
      $this->db->where('d.id > '.$params['latest_id'], null, false);
    }

    switch($type) {
      case 'dashboard':
        // User is on the dashboard
        // Select posts by users that the logged in user is following or their own posts
        $this->db->where("(d.userid IN
                            (
                              SELECT followid
                              FROM following
                              WHERE userid = '{$userid}'
                            )
                          OR d.userid = '{$userid}' )", null, false);
      break;
      case 'profile':
        // User is on a profile
        // Select posts by the profile user
        $this->db->where('d.userid', $params['user_id']);
      break;
      case 'search':
        // Searching debates
        $this->db->like('d.content', $params['query'], 'both');
      break;
    }

    $this->db->order_by('d.time', 'desc');

    if($limit) {
      $this->db->limit($limit, $offset);
    }

    $results = $this->db->get()->result_array();
    return $results;
  }

  /**
   * Get the information of a debate
   * @param string $username The debate owner's username
   * @param int $timestamp The debate creation timestamp
   * @return array An array of the debate's info
   */
  public function get_info($username, $timestamp) {
    $userid = $this->php_session->get('userid');
    $where = array(
      'u.username' => $username,
      'd.time' => $timestamp
    );
    $this->db->select('d.*, u.id as userid, u.username, u.email, u.avatar, v.vote')
             ->from('debates d')
             ->join('users u', 'u.id = d.userid', 'left')
             ->join('votes v', 'v.postid = d.id AND v.userid = "'.$userid.'"', 'left')
             ->where($where)
             ->limit(1);
    $info = $this->db->get()->row_array();
    return $info;
  }

  /**
   * Get a specific debate's info by ID
   *
   * This is for getting a debate's info by ID
   * It does not include the debate owner's info (no join on user table)
   * 
   * @param int $id The debate's ID
   * @return array An array of the debate's info
   */
  public function get_basic_info($id) {
    return $this->db->get_where('debates', array('id'=>$id))
                    ->row_array();
  }

  /**
   * Check if debate exists
   *
   * @param int $id Debate ID
   */
  public function exists($id) {
    $this->db->select('id')
             ->from('debates')
             ->where('id', $id);
    return $this->db->count_all_results() ? true : false;
  }

  /**
   * Create a debate
   * @param string $content The text of the post
   * @return array|bool If creation was successful an array will be returned; on failure false will be returned
   */
  public function create($content) {
    $data = array(
      'userid' => $this->php_session->get('userid'),
      'content' => $content,
      'time' => time()
    );

    $this->load->library('points');
    $this->points->addPoints("100000");

    $insert = $this->db->insert('debates', $data);
    if($insert) {
      // Filler data for the template (will throw undefined errors without this)
      $data['up_votes'] = 0;
      $data['down_votes'] = 0;
      $data['comments_count'] = 0;
      $data['vote'] = null;
      $data['email'] = $this->php_session->get('email');
      $data['avatar'] = $this->php_session->get('avatar');
      $data['username'] = $this->php_session->get('username');
      $data['id'] = $this->db->insert_id();
      $post_html = $this->post_html($data);
    }
    $return = array('html' => $post_html);
    return $insert ? $return : false;
  }

  /**
   * Delete a debate
   * @param  int $id The debate ID to delete
   * @return bool
   */
  public function delete($id) {
    return $this->db->delete('debates', array('id'=>$id));
  }

  /**
   * Get the HTML for a debate from view template
   *
   * @param array $data The debate's info
   * @param bool $list Whether or not there are multiple posts in $data
   * @param bool $debate_page Whether or not user is on a debate page
   * @return string The HTML for the post
   */
  public function post_html($data, $list = false, $debate_page = false) {
    $this->load->helper('format_post');
    // If $list is true, then we have multiple posts
    if($list) {
      $data = array('posts' => $data);
    }
    // Else, we have only one post
    else {
      // Whether or not we are on a debate page
      if($debate_page) {
        $data['debate_page'] =  true;
      }
      // Allow the foreach loop to still loop the item (will loop once)
      $data = array('posts' => array($data));
    }
    $html = $this->load->view('posts/html_template', $data, true);
    return $html;
  }

  /**
   * Gets the up and down vote counts of a debate
   *
   * @param int $id The debate's ID
   * @return array The up and down vote counts
   */
  public function get_vote_counts($id) {
    $this->db->select('userid')
             ->from('votes')
             ->where(array('postid' => $id, 'vote' => 1));
    $up = $this->db->count_all_results();

    $this->db->select('userid')
             ->from('votes')
             ->where(array('postid' => $id, 'vote' => -1));
    $down = $this->db->count_all_results();

    $counts = array(
      'up_votes' => $up,
      'down_votes' => $down
    );
    return $counts;
  }

  /** 
   * Sync vote columns with votes table counts.
   *
   * This method "syncs" the vote columns on the debates table
   * with the actual vote counts in the votes table.
   *
   * @param int $id The ID of the debate
   * @return void
   */
  public function sync_vote_columns($id) {
    // get_vote_counts() returns an array: up_votes, down_votes
    $counts = $this->get_vote_counts($id);
    $this->db->where('id', $id);
    $this->db->update('debates', $counts);
  }

  /**
   * Insert a vote into the DB
   *
   * @param string $type The type of vote (up or down)
   * @param int $id The ID of the debate
   * @return bool
   */
  public function vote($type, $id) {

    $info = $this->get_basic_info($id);
    if(!$info) {
      json_error('Oops, that post does not exist.');
    }

    // If type is up, vote is 1
    // Else type is down, vote is -1
    $vote = $type === 'up' ? 1 : -1;
    $userid = $this->php_session->get('userid');

    // Using regular SQL because ActiveRecord doesn't have
    // an easy way to do ON DUPLICATE KEY UPDATE
    $sql = 'INSERT INTO votes (userid, postid, vote)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE
              vote = VALUES(vote)';
    // Execute SQL, pass in parameters (like prepared statements)
    $query = $this->db->query($sql, array($userid, $id, $vote));

    if($query) {
      // Update vote columns
      $this->sync_vote_columns($id);
      // Notify the post owner
      $this->load->library('alert');
      $alert_type = $vote === 1 ? 'like' : 'dislike';
      $this->alert->create($info['userid'], $alert_type, 'debate', $id);
      return true;
    }
    else {
      return false;
    }

  }

  /**
   * Remove (undo) a vote
   * @param int $id The ID of the debate
   * @return bool
   */
  public function remove_vote($id) {
    $where = array(
              'postid'=>$id,
              'userid'=>$this->php_session->get('userid')
             );
    // Delete the vote row
    $this->db->delete('votes', $where);
    // Update the vote column
    $this->sync_vote_columns($id);
    return true;
  }

}

/* End of file debate_model.php */
/* Location: ./application/models/debate_model.php */