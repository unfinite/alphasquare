<?php
session_start();

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
    $extra =  " and id in ($user_string)";

	if ($limit > 0){
		$extra = "limit $limit";
	}
	$sql = "select id, userid, content, time, votes, comments from debates where `userid` in (".$user_string.") or `userid`='".$sessionid."' order by time desc";
	$result = mysqli_query($link, $sql);

	while($data = mysqli_fetch_array($result)){
		$posts[] = array(	'time' => $data['time'],
							'id' => $data['id'],
							'userid' => $data['userid'],
							'content' => base64_decode(mysqli_real_escape_string($link, htmlentities(stripslashes($data['content']), ENT_QUOTES, 'UTF-8'))),
							'votes' => $data['votes'],
							'comments' => $data['comments']
					);
	}
	return $posts;

}
function add_debate($userid,$body){
		global $link;

	if ($body == '') {
		$_SESSION['message'] = 'Empty content!';
		die();
	} else {
	$sql = 'insert into debates (`userid`, `content`, `time`)
			values ("'.$userid.'", "'. base64_encode(htmlentities($body)). '", "'.time().'")';

	$result = mysqli_query($link, $sql);
}
}
function show_users($user_id=0){
global $link;
	if ($user_id > 0){
		$follow = array();
		$fsql = "select userid from following
				where followid='$user_id'";
		$fresult = mysqli_query($link, $fsql);

		while($f = mysqli_fetch_object($fresult)){
			array_push($follow, $f->userid);
		}

		if (count($follow)){
			$id_string = implode(',', $follow);
			$extra =  " and id in ($id_string)";

		}else{
			return array();
		}

	}
if (!isset($extra)){
	$extra = '';
}
	$users = array();
	$sql = "select id, username from users
		where active='1'
		".$extra." order by id";


	$result = mysqli_query($link, $sql);

	while ($data = mysqli_fetch_object($result)){
		$users[$data->id] = $data->username;
	}
	return $users;
}
function following($userid){
	global $link;
	$users = array();

	$sql = "select distinct userid from following
			where followid = '$userid'";
	$result = mysqli_query($link, $sql);

	while($data = mysqli_fetch_object($result)){
		array_push($users, $data->userid);

	}

	return $users;
}
function follow_count($followid, $userid){
	global $link;
	$sql = "select count(*) from following
			where userid='".$userid."' and followid='".$followid."'";
	$result = mysqli_query($link, $sql);

	$row = mysqli_fetch_row($result);
	return $row[0];

}

function follow($me,$them){
	global $link;
	$count = follow_count($me,$them);

	if ($count == 0){
		$sql = 'insert into following (userid, followid)
				values ("'.$them.'","'.$me.'")';

		$result = mysqli_query($link, $sql);
	} else {
				die();

		echo 'You are already following this user!';

	}
}


function unfollow($me,$them){
	global $link;
	$count = follow_count($me,$them);

	if ($count != 0){
		$sql = "delete from following
				where userid='".$them."' and followid='".$me."'
				limit 1";

		$result = mysqli_query($link, $sql);
	} else {
		die();
		echo 'You aren\'t following this user!';
	}
}

function votes($postid, $type) {
	global $link;
	$result = mysqli_query($link, 'select * from votes where postid="'.$postid.'" and type="'.$type.'"');
	$data=mysqli_num_rows($result);
	echo $data;
}

function GetUsername()
{

if(isset($_SESSION['username'])){echo ' '.htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8');}
}

function blockGuest()
{

if(isset($_SESSION['username'])) {
} else {
header ('Location: login.php');
}
if($_SESSION['username'] == "") {
header ('Location: login.php');
}

}

function blockMember()
{
if(isset($_SESSION['username'])) {
header ('Location: dashboard.php');
}

}
function getPoints()
{

global $link;
$mysqliquer = mysqli_query($link, 'select points from users where id="'.$_SESSION['userid'].'"');
$points = mysqli_fetch_array($mysqliquer);
echo $points['points'];
}
function profilePicture($username)
{

	if(isset($username)) {
	global $link;
		$dn = mysqli_query($link, 'select avatar from users where username="'.$username.'"');
	if(mysqli_num_rows($dn)>0)
	{
		$dnn = mysqli_fetch_array($dn);
		//We display the user datas
	}
if($dnn['avatar']!='')
{
	echo htmlentities($dnn['avatar']);
}
else
{
	echo 'http://www.vanillicon.com/'.md5(htmlentities($username, ENT_QUOTES, 'UTF-8')).'_200.png';

}
}
}

function profilePictureID($id)
{

	if(isset($id)) {
	global $link;
		$dn = mysqli_query($link, 'select avatar from users where id="'.$id.'"');
	if(mysqli_num_rows($dn)>0)
	{
		$dnn = mysqli_fetch_array($dn);
		//We display the user datas
	}
if($dnn['avatar']!='')
{
	echo htmlentities($dnn['avatar']);
}
else
{
			$dn1 = mysqli_query($link, 'select username from users where id="'.$id.'"');
		$dnn1 = mysqli_fetch_array($dn1);

	echo 'http://www.vanillicon.com/'.md5(htmlentities($dnn1['username'], ENT_QUOTES, 'UTF-8')).'_200.png';

}
}
}


function showBBcodes($text) {

// BBcode array
$find = array(
'~\[b\](.*?)\[/b\]~s',
'~\[trololo\](.*?)\[/trololo\]~s',
'~\[nyan\](.*?)\[/nyan\]~s',
'~\[alphasquare\](.*?)\[/alphasquare\]~s',
'~\[code\](.*?)\[/code\]~s',
'~\[i\](.*?)\[/i\]~s',
'~\[u\](.*?)\[/u\]~s',
'~\[quote\](.*?)\[/quote\]~s',
'~\[size=(.*?)\](.*?)\[/size\]~s',
'~\[color=(.*?)\](.*?)\[/color\]~s',
'~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
'~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
'~\[awesomeness\](.*?)\[/awesomeness\]~s'
);

// HTML tags to replace BBcode
$replace = array(
'<b>$1</b>',
'<img src="http://stream1.gifsoup.com/view/201665/trololo-o.gif" style="height:500px;width:500px;"></img>',
'<img src="http://37.media.tumblr.com/tumblr_lj0wls8poh1qb9bjho1_400.gif" style="height:500px;width:500px;"></img>',
'<span class="lobster">alphasquare</span>',
'<pre class="prettyprint codeblock">$1</pre>',
'<i>$1</i>',
'<span style="text-decoration:underline;">$1</span>',
'<pre>$1</'.'pre>',
'<span style="font-size:$1px;">$2</span>',
'<span style="color:$1;">$2</span>',
'<a href="$1">$1</a>',
'<img src="$1" alt="" />',
'<img src="http://blog.christoffer.me/post/2011-03-12-awesomeness-is-when-i-use-jquery-true-story/awesomeness.png" style="height:500px;width:600px;" alt="" />'
);

// Replacing the BBcodes with corresponding HTML tags
return preg_replace($find,$replace,$text);
}

function alert($userid,$content) {
	global $link;
	mysqli_query($link, 'insert into alerts (userid,content) values ("'.$userid.'", "'.htmlentities(mysqli_real_escape_string($link, $content)).'")');

}

function alert_count() {
	global $link;
	$result = mysqli_query($link, 'select count(*) as notifs from alerts where seen="0" and userid="'.$_SESSION['userid'].'"');
	$data=mysqli_fetch_assoc($result);
	echo $data['notifs'];

}
?>
