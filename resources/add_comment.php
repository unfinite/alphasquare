<?php 
include '../universal.php';
$debid = $_POST['id'];
$comment = $_POST['content'];

if (is_numeric($_GET['id']) and isset($_GET['id']) and isset($_GET['content']) and $_GET['content'] !== '') {
	  $result = mysqli_query($link, 
        "SELECT * FROM debates WHERE id='".$debid."' LIMIT 1");
    if(mysqli_fetch_array($result) !== false) {
	add_comment($comment, $debid);
	echo 'Added';
	header("Location: ../dashboard");
	} else { echo 'no'; }
} else {echo 'No'; }

?>