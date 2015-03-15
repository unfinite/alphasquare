<?php
if(!defined('BASEPATH')) die('No direct script access allowed');

/**
 * Downloads image from OAuth provider
 *
 * @param string $url The url of the image from OAuth provider
 * @return string The local url to image
 */

if(!function_exists('avatar_from_url')) {
  function avatar_from_url($url) {

    $ext = pathinfo($url, PATHINFO_EXTENSION);
    $filename = mt_rand(00,99999);
    $dir1 = mt_rand(0,99);
    $dir2 = mt_rand(0,99);
    $path = "avatars/$dir1/$dir2";
    $file = "$filename.$ext";
    $return_path = "$dir1/$dir2/$file";

    // If directories don't exist, create them
    if(!is_dir($path)) {
      mkdir($path, 0755, true);
    }

    // Copy image from OAuth to local server
    copy($url, $path.'/'.$file);

    return $return_path;

  }
}