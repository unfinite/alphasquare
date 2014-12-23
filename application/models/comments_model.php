<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Comments Model 
 * Creating, editing, deleteing, and fetching comments
 *
 * @package Models
 */

class Comments_model extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  /**
   * Get all comments on a post (and the commenter's info)
   * @param  int  $id       The ID of the debate
   * @param  int  $limit    Number of comments to return
   * @param  int  $offset   Number of comments to start from
   * @param  int  $startid  The ID to start loading comments from
   * @return array          An array of comments.
   */
  public function get_all($id, $limit = COMMENT_DISPLAY_LIMIT, $offset = 0, $startid = 0) {
    // Manual SQL for comment limit ordered by DESC but newest (can't do with ActiveRecord)
    $bindings = array($id);
    $where_and = '';
    if($startid) {
      $bindings[] = $startid;
      $where_and = ' AND c.id > ?';
    }
    if($limit) {
      $limit = "LIMIT $limit";
      if($offset) {
        $limit .= " OFFSET $offset";
      }
    }
    $sql = "(SELECT c.*, u.username, u.email
              FROM comments c
                INNER JOIN users u
                  ON u.id = c.userid
              WHERE postid = ? {$where_and}
              ORDER BY time DESC
              {$limit} ) ORDER BY time ASC";
    $query = $this->db->query($sql, $bindings);
    return $query->result_array();
  }

  /**
   * Create a comment
   * @param  int $postid  The ID of the debate
   * @param  string $content The comment's content
   * @return array  The created comment's info
   */
  public function create($postid, $content) {
    $data = array(
      'userid' => $this->php_session->get('userid'),
      'postid' => $postid,
      'content' => $content,
      'time' => time()
    );

    $this->load->library('points');
    $this->points->addPoints(3);

    $created = $this->db->insert('comments', $data);
    // If it was created
    if($created) {
      // Return the array of info
      $data['username'] = $this->php_session->get('username');
      $data['email'] = $this->php_session->get('email');
      $data['id'] = $this->db->insert_id();
      // Update comments count row
      $this->sync_comments_count($postid);

      $this->load->library('mentions');
      $this->load->library('alert');

      $mentions = $this->mentions->list_mentions($content);

      if ($mentions) {
        foreach ($mentions as $m) {
          
          if ($this->mentions->user_exists($m)) {
            $userid = $this->mentions->get_userid($m);
            $this->alert->create($userid, 'mention', 'comment', $data['postid']);
          }

        }
      }

      return $data;
    }
  }

  /**
   * Delete a comment
   * @param  int $id The comment ID
   * @return bool Whether or not the comment deleted
   */
  public function delete($id) {

  }

  /**
   * Sync the comments count with the comments count row
   * @param  int $postid The post ID
   * @return bool
   */
  private function sync_comments_count($postid) {
    $new_count = $this->db->select('id')
                          ->from('comments')
                          ->where('postid', $postid)
                          ->count_all_results();
    $this->db->where('id', $postid);
    return $this->db->update('debates', array('comments_count'=>$new_count));
  }

  /**
   * Get a comment's HTML from template view
   * @param  array $data An array of comments (or one comment's info)
   * @param  bool $list True if data has multiple comments, false if not
   * @return string  The HTML from the template view.
   */
  public function comment_html($data, $list) {
    $this->load->helper('format_post');
    // If $list is true, then we have multiple comments
    if($list) {
      $data = array('comments' => $data);
    }
    // Else, we have only one post
    else {
      // Allow the foreach loop to still loop the item (will loop once)
      $data = array('comments' => array($data));
    }
    // Load comments view
    $html = $this->load->view('posts/comments', $data, true);
    return $html;
  }

}

/* End of file comments_model.php */
/* Location: ./application/models/comments_model.php */