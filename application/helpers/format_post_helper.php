<?php

/* Helper to format comments and posts */

if(!function_exists('format_post')) {
  function format_post($text) {
    $CI =& get_instance();
    $CI->load->helper('bbcode');
    // Html entities
    $text = htmlentities($text);
    // Convert line breaks to <br>
    $text = nl2br($text);
    // Parse BBCode
    $text = bbcode($text);
    // Make links clickable
    $text = auto_link($text);
    // Parse &tags
    $text = str_replace('&amp;', '&', $text);
    $text = preg_replace(REGEX_TAG, '<a href="'.base_url().'find?q=$1&tag=1">&$1</a>', $text);
    return $text;
  }
}

/*
Helper to format numbers > 1000
  * 6,000 -> 6k
  * 4,300 -> 4.3k
From: http://stackoverflow.com/a/2703903/507629
*/
if(!function_exists('short_number')) {
  function short_number($number) {
      $prefixes = 'kMGTPEZY';
      if ($number >= 1000) {
          for ($i=-1; $number>=1000; ++$i) {
              $number /= 1000;
          }
          return round($number, 1) . $prefixes[$i];
      }
      return $number;
  }
}

/* End of format_post_helper.php */