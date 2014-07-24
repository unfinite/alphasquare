<?php 
include '../universal.php';


if (is_numeric($_GET['id']) and isset($_GET['id']) and isset($_GET['content'])) {
$debid = $_GET['id'];
$comment = $_GET['content'];

	  $result = mysqli_query($link, 
        "SELECT * FROM debates WHERE id=$debid LIMIT 1");

    if(mysqli_fetch_array($result) !== false) {
	add_comment($comment, $debid);
	echo 'Added';
	} else { echo 'no';}

} else {echo 'No'; }

$postid = $_GET['id'];
$comment = $_GET['content'];

add_comment($comment, $postid);
?>