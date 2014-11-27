<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Alerts Controller
 * View, mark as read, and delete alerts
 *
 * @package Controllers
*/

class Alerts extends CI_Controller {

  public function __construct() {
    parent::__construct();
    login_required();
    $this->load->model('alerts_model');
    $this->load->library('alert');
  }

  /**
   * Alerts page
   * URL: /alerts
   */
  public function index() {
    $data['title'] = 'Alerts';
    $this->load->view('alerts/page', $data);
  }

  /**
   * Redirects to the alert object
   * URL: /alerts/view/ID
   *
   * @param int $id
   */
  public function view($id) {
    $url = $this->alert->get_url($id);
    // If alert doesn't exist (or user doesn't own it), $url will be false
    if(!$url) {
      show_404();
    }
    // Mark the alert as clicked
    $this->alert->mark_as_clicked($id);
    // Redirect to the object
    redirect($url);
  }

  /**
   * Alerts modal box
   * URL: /alerts/modal
   */
  public function modal() {
    // Limit to 30 alerts, rest can be viewed on page
    $data['alerts'] = $this->alert->get_all(30);
    $this->load->view('alerts/alerts', $data);
  }

  /**
   * Mark an alert as read
   */
  public function mark_read() {
    $id = $this->input->post('id');
    if(!$id) json_error('No id provided');
    $this->alert->mark_as_clicked($id);
    $json = array('id'=>$id);
    json_output($json, true);
  }

  /**
   * Delete an alert
   */
  public function delete() {
    $id = $this->input->post('id');
    if(!$id) json_error('No id provided');
    // Get the alert's info
    $info = $this->alert->get_info($id);
    // Check if user owns alert
    if(!$info || $this->php_session->get('userid') !== $info['to']) {
      json_error('That alert was not sent to you or it does not exist.');
    }
    // Finally delete the alert
    if($this->alert->delete($id)) {
      json_output(array('id'=>$id), true);
    }
    else {
      json_error('Sorry, could not delete alert.');
    }
  }
  
    /**
     * Mark all alerts as read
     */
    public function mark_all_read() {
        $json_alerts = array();
        
        foreach ($this->alert->get_all() as $alert) {
            $id = $alert['id'];
            $info = $this->alert->get_info($id);
            
            $this->alert->mark_as_clicked($id);
            array_push($json_alerts, $id);
        }
        
        json_output(array('ids'=>$json_alerts), true);
    }

    /**
     * Delete all alerts
     */
    public function delete_all() {
        $json_alerts = array();
        
        $success = true;
                
        foreach ($this->alert->get_all() as $alert) {
            $id = $alert['id'];
            $info = $this->alert->get_info($id);
            
            if (!info || $this->php_session->get('userid') !== $info['to']) {
                // Ignore ones that don't exist.
            }
            elseif ($this->alert->delete($id)) {
                array_push($json_alerts, $id);
            }
            else {
                $success = false;
            }      
        }
        
        if (!$success) {
            json_error('Sorry, could not delete all the alerts.');
        }
        else {
            json_output(array('ids'=>$json_alerts), true);
        }
    }
}

/* End of file alerts.php */
/* Location: ./application/controllers/alerts.php */
