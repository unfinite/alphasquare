<?php 
include '../universal.php';

$debid = $_GET['id'];
$comment = $_GET['content'];

if (is_numeric($debid) and isset($_GET['id']) and isset($_GET['content'])) {

	  $result = mysqli_query($link, 
        "SELECT * FROM debates WHERE id=$debid LIMIT 1");

    if(mysqli_fetch_array($result) !== false) {
	add_comment($comment, $debid);
	echo 'Added';
	} else { echo 'no';}

} else {echo 'No'; }

$comment = 'Hai';
$postid = 323;

add_comment($comment, $postid);
?>