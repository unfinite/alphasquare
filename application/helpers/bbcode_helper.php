<?php
/**
 * BBCode Parser
 * @package Helpers
 * @author Nathan Johnson
 */

function bbcode($text) {

  $codes = array(

    // Text formatting
    '~\[b\](.*)\[/b\]~s' => '<span style="font-weight:bold;">$1</span>',
    '~\[i\](.*)\[/i\]~s' => '<span style="font-style:italic;">$1</span>',
    '~\[u\](.*)\[/u\]~s' => '<span style="text-decoration:underline;">$1</span>',
    '~\[key\](.*?)\[/key\]~s' => '<kbd>$1</kbd>',
    '~\[size=([0-9]+)\](.*?)\[/size\]~s' => '<span style="font-size:$1px;">$2</span>',
    '~\[color=(.*?)\](.*?)\[/color\]~s' => '<span style="color:$1;">$2</span>',


    // Text blocks
    '~\[snippet\](.*?)\[/snippet\]~s'
      => '<pre>$1</pre>',
    '~\[code\](.*)\[/code\]~s'
      => '<pre class="prettyprint codeblock pre-scrollable">$1</pre>',
    '~\[quote\](.*)\[/quote\]~s'
      => '<blockquote>$1</blockquote>',


    // Alphasquare text
    '~\[alphasquare\]~s' => '<span class="alphasquare">alphasquare</span>',


    // Images
    '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
      => '<div class="img"><a href="$1" target="_blank" title="Click to view image in new tab"><img src="$1" /></a></div>',

    // Silly stuff
    '~\[trololo\]~s'
      => '<div class="img"><img src="http://stream1.gifsoup.com/view/201665/trololo-o.gif" title="Trololo" /></div>',
    '~\[nyan\]~s'
      => '<div class="img"><img src="http://37.media.tumblr.com/tumblr_lj0wls8poh1qb9bjho1_400.gif" title="Nyan Cat!" /></div>',
    '~\[awesomeness\]~s'
      => '<div class="img"><img src="http://blog.christoffer.me/post/2011-03-12-awesomeness-is-when-i-use-jquery-true-story/awesomeness.png" /></div>'
  );

  $patterns = array_keys($codes);
  $replacements = array_values($codes);

  // Replacing the BBcodes with corresponding HTML tags
  return preg_replace($patterns, $replacements, $text);

}