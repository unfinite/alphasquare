<?php

if(!defined('BASEPATH')) die('No direct script access allowed');

/* Auto Link Text Function
 * Usage:
 * auto_link_text('Hello! Go to http://google.com/ &awesome!');
 *
 * From: http://stackoverflow.com/a/1971451/507629
 * Modified:
 * - Added @username
 */

function auto_link_text($text) {
  // Links
  $text = preg_replace_callback(REGEX_LINK, 'auto_link_text_callback', $text);
  // Replace &amp; with & for tag parser
  $text = str_replace('&amp;', '&', $text);
  // &tags
  $text = preg_replace(REGEX_TAG, '<a href="'.base_url().'tag/$1">&$1</a>', $text);
  //$text = preg_replace_callback(REGEX_AT_REPLY, 'at_reply_link_callback', $text);

  return $text;
}

// cache linked users
/*$auto_linked_users = array();
function at_reply_link_callback($matches) {
    global $auto_linked_users;
    if(!$auto_linked_users) {
        $auto_linked_users = array();
    }
    $username = $matches[1];
    $lower_username = strtolower($username);
    if($username) {
        if(!array_key_exists($lower_username, $auto_linked_users)) {
            $CI =& get_instance();
            $CI->load->model('users_model');
            // get user info
            $user = $CI->users_model->getByUsername($username, 'username');
            // if user doesn't exist, return @username without link
            if(!$user) {
                return '@'.$username;
            }
            $username = $user['username'];
            $new_lower_username = strtolower($username);
            $auto_linked_users[$new_lower_username] = $username;
        }
        else {
            $username = $auto_linked_users[$lower_username];
        }
        return '<a href="'.profile_url($username).'" title="View '.$username.'\'s profile">@'.$username.'</a>';
    }
}*/

function auto_link_text_callback($matches) {
    $max_url_length = 50;
    $max_depth_if_over_length = 2;
    $ellipsis = '...';

    $url_full = $matches[0];
    $url_short = '';

    if (strlen($url_full) > $max_url_length) {
        $parts = parse_url($url_full);
        $url_short = $parts['scheme'] . '://' . preg_replace('/^www\./', '', $parts['host']) . '/';

        $path_components = explode('/', trim($parts['path'], '/'));
        foreach ($path_components as $dir) {
            $url_string_components[] = $dir . '/';
        }

        if (!empty($parts['query'])) {
            $url_string_components[] = '?' . $parts['query'];
        }

        if (!empty($parts['fragment'])) {
            $url_string_components[] = '#' . $parts['fragment'];
        }

        for ($k = 0; $k < count($url_string_components); $k++) {
            $curr_component = $url_string_components[$k];
            if ($k >= $max_depth_if_over_length || strlen($url_short) + strlen($curr_component) > $max_url_length) {
                if ($k == 0 && strlen($url_short) < $max_url_length) {
                    // Always show a portion of first directory
                    $url_short .= substr($curr_component, 0, $max_url_length - strlen($url_short));
                }
                $url_short .= $ellipsis;
                break;
            }
            $url_short .= $curr_component;
        }

    } else {
        $url_short = $url_full;
    }

    return "<a rel=\"nofollow\" href=\"$url_full\" target=\"_blank\">$url_short</a>";
}

/* End of file auto_link_helper.php */
/* Location: ./application/helpers/auto_link_helper.php */