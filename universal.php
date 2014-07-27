<?php
session_start();

$prankmode = false;

if ($prankmode == true) {
die("<img src=\"http://my.fakingnews.firstpost.com/files/2014/04/Hacked.jpg\"> I TELL YOU I WOULD GET REVENG3 <br> U GOT HXEDDD HAHAHAHAHAH <br> HAXED BY D4H4x0RR 0x937493xx ");
}


$link = mysqli_connect('localhost', 'u7736617_new', '2{..~?5Q2D0+', 'u7736617_new');
if (mysqli_connect_errno()) {
    print("We had a little hiccup and we couldn't connect to the main servers properly. Try later please!");
    exit();
}


function get_posts($userid, $limit=0){
  global $link;
  $posts = array();
  $sessionid = $_SESSION['userid'];
  $user_string = join(",", $userid);
  $extra =  " AND id IN ($user_string)";

  if($limit > 0) $extra = "LIMIT $limit";

  $sql = "SELECT id, userid, content, time, votes, comments
          FROM debates
          WHERE `userid`
           IN ($user_string)
            OR `userid` = $sessionid
          ORDER BY time DESC";
  $result = mysqli_query($link, $sql);

  while($data = mysqli_fetch_array($result)){
    $posts[] = array(
                'time' => $data['time'],
                'id' => $data['id'],
                'userid' => $data['userid'],
                'content' => mysqli_real_escape_string($link, $data['content']),
                'votes' => $data['votes'],
                'comments' => $data['comments']
               );
  }
  return $posts;

}

function show_users($user_id=0){
  global $link;
  if($user_id > 0) {
    $follow = array();
    $sql = "SELECT userid
            FROM following
            WHERE followid = $user_id";
    $result = mysqli_query($link, $sql);

    while($row = mysqli_fetch_object($result)){
      // this is the same as array_push, but faster to type
      $follow[] = $row->userid;
    }

    if(count($follow)) {
      $id_string = implode(',', $follow);
      $extra =  " AND id IN ($id_string)";
    }
    else {
      return array();
    }

  }

  if(!isset($extra)) $extra = '';

  $users = array();
  $sql = "SELECT id, username FROM users
          WHERE active = 1 $extra
          ORDER BY id";
  $result = mysqli_query($link, $sql);

  while ($data = mysqli_fetch_object($result)){
    $users[$data->id] = $data->username;
  }
  return $users;
}

function following($userid) {
  global $link;
  $users = array();

  $sql = "SELECT DISTINCT userid
          FROM following
          WHERE followid = $userid";
  $result = mysqli_query($link, $sql);

  while($data = mysqli_fetch_object($result)){
    array_push($users, $data->userid);
  }

  return $users;
}

function follow_count($followid, $userid){
  global $link;
  $sql = "SELECT count(*)
          FROM following
          WHERE userid = $userid
            AND followid = $followid";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_row($result);
  return $row[0];
}

function follow($me, $them){
  global $link;
  $count = follow_count($me,$them);

  if($count == 0){
    $sql = "INSERT INTO following (userid, followid)
            VALUES ($them, $me)";
    $result = mysqli_query($link, $sql);
  }
  else {
    die('You are already following this user.');
  }
}


function unfollow($me,$them){
  global $link;
  $count = follow_count($me,$them);

  if ($count != 0){
    $sql = "DELETE FROM following
            WHERE userid = ".$them."
              AND followid = ".$me."
            LIMIT 1";

    $result = mysqli_query($link, $sql);
  }
  else {
    die('You aren\'t following this user.');
  }
}

function votes($postid, $type) {
  global $link;
  $result = mysqli_query($link, "SELECT * FROM votes
                                 WHERE postid = $postid
                                 AND type = $type");
  $data = mysqli_num_rows($result);
  echo $data;
}

function GetUsername() {
  if(isset($_SESSION['username'])){
    echo ' '.htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8');
  }
}

function blockGuest() {
  if(!isset($_SESSION['username']) || $_SESSION['username'] == "") {
    header ("Location: login");
  }
}

function blockMember() {
  if(isset($_SESSION['username'])) {
    header('Location: dashboard');
  }
}

function getPoints() {
  global $link;
  $sql = "SELECT points
          FROM users
          WHERE id = $_SESSION[userid]";
  $result = mysqli_query($link, $sql);
  $info = mysqli_fetch_array($result);
  echo $info['points'];
}

function vanillicon($username, $size = 200) {
  $username = md5(htmlentities($username, ENT_QUOTES, 'UTF-8'));
  return "http://www.vanillicon.com/{$username}_{$size}.png";
}

function profilePicture($username) {

  if(!isset($username)) return;

  global $link;
  $sql = "SELECT avatar
          FROM users
          WHERE username = '$username'";
  $result = mysqli_query($link, $sql);
  if(mysqli_num_rows($result) > 0) {
    $info = mysqli_fetch_array($result);
    //We display the user datas
  }
  if($info['avatar'] != '') {
    echo htmlentities($info['avatar']);
  }
  else {
    echo vanillicon($username);
  }

}

function profilePictureID($id) {
  if(!isset($id)) return;

  global $link;
  $sql = "SELECT username, avatar
          FROM users
          WHERE id = $id";
  $result = mysqli_query($link, $sql);
  if(mysqli_num_rows($result) > 0) {
    $info = mysqli_fetch_array($result);
  }
  if($info['avatar']!='') {
    echo htmlentities($info['avatar']);
  }
  else {
    echo vanillicon($info['username']);
  }

}


function showBBcodes($text) {

  // BBcode array
  $find = array(
  '~\[b\](.*?)\[/b\]~s',
  '~\[snippet\](.*?)\[/snippet\]~s',
  '~\[code\](.*?)\[/code\]~s',
  '~\[key\](.*?)\[/key\]~s',
  '~\[trololo\](.*?)\[/trololo\]~s',
  '~\[nyan\](.*?)\[/nyan\]~s',
  '~\[alphasquare\](.*?)\[/alphasquare\]~s',
  '~\[code\](.*?)\[/code\]~s',
  '~\[i\](.*?)\[/i\]~s',
  '~\[u\](.*?)\[/u\]~s',
  '~\[quote\](.*?)\[/quote\]~s',
  '~\[size=(.*?)\](.*?)\[/size\]~s',
  '~\[color=(.*?)\](.*?)\[/color\]~s',
  '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
  '~\[awesomeness\](.*?)\[/awesomeness\]~s'
  );

  // HTML tags to replace BBcode
  $replace = array(
  '<b>$1</b>',
  '<code>$1</code>',
  '<pre>$1</pre>',
  '<kbd>$1</kbd>',
  '<img src="http://stream1.gifsoup.com/view/201665/trololo-o.gif" style="height:500px;width:500px;"></img>',
  '<img src="http://37.media.tumblr.com/tumblr_lj0wls8poh1qb9bjho1_400.gif" style="height:500px;width:500px;"></img>',
  '<span class="lobster">alphasquare</span>',
  '<pre class="prettyprint codeblock">$1</pre>',
  '<i>$1</i>',
  '<span style="text-decoration:underline;">$1</span>',
  '<pre>$1</'.'pre>',
  '<span style="font-size:$1px;">$2</span>',
  '<span style="color:$1;">$2</span>', 
  '<img src="$1" alt="" />',
  '<img src="http://blog.christoffer.me/post/2011-03-12-awesomeness-is-when-i-use-jquery-true-story/awesomeness.png" style="height:500px;width:600px;" alt="" />'
  );

  // Replacing the BBcodes with corresponding HTML tags
  return preg_replace($find,$replace,$text);

}

function alert($userid, $content) {
  global $link;
  $content = htmlentities(mysqli_real_escape_string($link, $content));
  $sql = "INSERT INTO alerts (userid, content)
          VALUES ($userid, '$content')";
  mysqli_query($link, $sql);
}

function alert_count() {
  global $link;
  $sql = "SELECT count(*) AS notifs
          FROM alerts
          WHERE seen = 0
          AND userid = $_SESSION[userid]";
  $result = mysqli_query($link, $sql);
  $data = mysqli_fetch_assoc($result);
  echo $data['notifs'];
}

function atag_main($text) {
  preg_match_all('/(^|[^a-z0-9_])&([a-z0-9_]+)/i', $text, $matched_tags);
  $tag = array();

  if(empty($matched_tags[0])) return '';

  foreach($matched_tags[0] as $match) {
    $tag[] = preg_replace("/[^a-z0-9]+/i", "", $match);
  }
  return implode(',', array_unique($tag));
}

function atag_link($message) {
  $atag_link = preg_replace(array('/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))/', '/(^|[^a-z0-9_])@([a-z0-9_]+)/i', '/(^|[^a-z0-9_])&([a-z0-9_]+)/i'), array('<a href="$1" target="_blank">$1</a>', '$1<a href="">@$2</a>', '$1<a href="find?q=$2&type=tag">&$2</a>'), $message);
  return $atag_link;
}

function add_debate($userid,$body) {
  global $link;
  if($body == '') {
    $_SESSION['message'] = 'Empty content!';
    exit;
  }
  else {
    $tags = atag_main($body);
    $body_encoded = mysqli_real_escape_string($link, htmlentities($body));
    $time = time();
    $sql = "INSERT INTO debates (`userid`, `content`, `tags`, `time`)
            VALUES ($userid, '$body_encoded', '$tags', $time)";
    $result = mysqli_query($link, $sql);
  }
}

function add_comment($comment, $debid) {

  global $link;

  if ($comment == '') {

    $_SESSION['message'] == 'The comment can\'t be empty, silly.';

  } else {

    $time = time();

    $tags = atag_main($comment);

    $uid = $_SESSION['userid'];

    $comment_sanitized = mysqli_real_escape_string($link, htmlentities($comment));

      $sql = "INSERT INTO discussion (`userid`, `postid`, `content`, `time`)
            VALUES ($uid, $debid, '$comment_sanitized', $time)";

      $result = mysqli_query($link, $sql);

  }

}

function show_comments($debid) {
global $link;
  $sql = "SELECT content, time, userid, postid
          FROM discussion
          WHERE `postid`='".$debid."'
          ORDER BY time DESC";
  $result = mysqli_query($link, $sql);

  while($data = mysqli_fetch_array($result)){
    $comments[] = array(
                'time' => $data['time'],
                'postid' => $data['postid'],
                'userid' => $data['userid'],
                'content' => mysqli_real_escape_string($link, $data['content'])
                );
  }
  return $comments;

}

function msg($msg) {
   $_SESSION['msg'] = $msg;
}

function show_msg() {


   if(isset($_SESSION['msg'])) {
$msg = $_SESSION['msg'];
      echo '<script>';
      echo 'function decodeEntities(s){
    var str, temp= document.createElement(\'p\');
    temp.innerHTML= s;
    str= temp.textContent || temp.innerText;
    temp=null;
    return str;
}
function notify(post) {

  $.notifyBar({  html: decodeEntities(post), position: "top" }); 

} notify(';
      echo $msg;
      echo ')';
      echo '</script>';
      unset($_SESSION['msg']);

   }

}
/* End of universal.php */