<?php 
include '../universal.php';
$debid = $_GET['id'];
$comment = $_GET['content'];
error_reporting(E_ALL);
if (is_numeric($_GET['id']) and isset($_GET['id']) and isset($_GET['content']) and $_GET['content'] !== '') {
	  $result = mysqli_query($link, 
        "SELECT * FROM debates WHERE id='".$debid."' LIMIT 1");
    if(mysqli_fetch_array($result) !== false) {
	add_comment($comment, $debid);
	echo 'Added';
	} else { echo 'no';}
} else {echo 'No'; }

?>