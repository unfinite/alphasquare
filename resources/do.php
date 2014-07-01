<?php

include_once("../universal.php");
blockGuest();

$id = $_GET['id'];
$do = $_GET['do'];

switch ($do){
	case "follow":
		follow($_SESSION['userid'],$id);
		mysqli_query($link, 'insert into alerts (userid,content) values ("'.$id.'", "'.$_SESSION['username'].' followed you. Woohoo!")');
		$msg = "You have followed a user!";
	break;

	case "unfollow":
		unfollow($_SESSION['userid'],$id);
		$msg = "You have unfollowed a user!";
	break;

}
$_SESSION['message'] = $msg;

header("Location:../dashboard.php");
?>