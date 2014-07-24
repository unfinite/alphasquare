<?php 
include '../universal.php';
$debid = $_POST['id'];
$comment = $_POST['content'];
if (is_numeric($_POST['id']) and isset($_POST['id']) and isset($_POST['content']) and $_POST['content'] !== '') {
	  $result = mysqli_query($link, 
        "SELECT * FROM debates WHERE id='".$debid."' LIMIT 1");
    if(mysqli_fetch_array($result) !== false) {
	add_comment($comment, $debid);
	header("Location: ../debate?post=".$_POST['id']);
	} else { echo 'no'; }
} else {echo 'No'; }

?>