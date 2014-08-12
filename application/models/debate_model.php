<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Debate Model
This is where we access data from the DB (or APIs)
*/

class Debate_model extends CI_Model {

  // Get an array of posts
  public function get_posts($type, $order = 'desc', $offset = 0, $limit = POST_DISPLAY_LIMIT, $params = array()) {
    $userid = $this->php_session->get('userid');
    $this->db->select('d.*, u.id as userid, u.username, u.email, v.vote')
             ->from('debates d')
             // Get post owner's info
             ->join('users u', 'u.id = d.userid', 'inner')
             // Get the vote that the logged in user made on this post
             ->join('votes v', 'v.postid = d.id AND v.userid = '.$userid, 'left');

    // If latest_id param is present, add a statement to the WHERE clause
    if(isset($params['latest_id']) && $params['latest_id'] > 0) {
      $this->db->where('d.id > '.$params['latest_id'], null, false);
    }

    switch($type) {
      case 'dashboard':
        // We are in the dashboard
        // Select posts by users that the logged in user is following or their own posts
        $this->db->where("(d.userid IN
                            (
                              SELECT followid
                              FROM following
                              WHERE userid = {$userid}
                            )
                          OR d.userid = {$userid} )", null, false);
      break;
      case 'profile':
        // We are on a profile
        // Select posts that the profile user owns
        $this->db->where('d.userid', $params['user_id']);
      break;
    }

    $this->db->order_by('d.time', $order);

    if($limit) {
      $this->db->limit($limit, $offset);
    }

    $results = $this->db->get()->result_array();
    //die($this->db->last_query());
    return $results;
  }

  // Get a specific post's info with the owner's info
  public function get_info($id) {
    $userid = $this->php_session->get('userid');
    $this->db->select('d.*, u.id as userid, u.username, u.email, v.vote')
             ->from('debates d')
             ->join('users u', 'u.id = d.userid', 'left')
             ->join('votes v', 'v.postid = d.id AND v.userid = '.$userid, 'left')
             ->where('d.id', $id)
             ->limit(1);
    $info = $this->db->get()->row_array();
    return $info;
  }

  // Get a specific post's info (without owner's info)
  public function get_basic_info($id) {
    return $this->db->get_where('debates', array('id'=>$id))
                    ->row_array();
  }

  // Check if a post exists
  public function exists($id) {
    $this->db->select('id')
             ->from('debates')
             ->where('id', $id)
             ->limit(1);
    return $this->db->count_all_results();
  }

  // Create a post
  public function create($content) {
    $data = array(
      'userid' => $this->php_session->get('userid'),
      'content' => $content,
      'time' => time()
    );
    $insert = $this->db->insert('debates', $data);
    if($insert) {
      // Filler data for the template (will throw undefined errors without this)
      $data['up_votes'] = 0;
      $data['down_votes'] = 0;
      $data['comments_count'] = 0;
      $data['vote'] = null;
      $data['email'] = $this->php_session->get('email');
      $data['username'] = $this->php_session->get('username');
      $data['id'] = $this->db->insert_id();
      $post_html = $this->post_html($data);
    }
    $return = array('postHtml' => $post_html);
    return $insert ? $return : false;
  }

  // Get a post's HTML
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

  // Returns an array with up and down vote count of a post
  public function get_vote_counts($id, $type = 'all') {
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

  // Sync vote columns with votes table counts
  // The vote columns on debates table act as a cache
  // so the DB doesn't have to be queried 2 times for every post
  public function sync_vote_columns($id) {
    // get_vote_counts() returns an array: up_votes, down_votes
    $counts = $this->get_vote_counts($id);
    $this->db->where('id', $id);
    $this->db->update('debates', $counts);
  }

  // Vote on a post
  public function vote($type, $id) {

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
      return true;
    }
    else {
      return false;
    }

  }

  // Undo/remove vote
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