<?php
 

 // 1 = LIKE, 0 = DISLIKE

include '../universal.php';
if (isset($_SESSION['userid'])) {
 if (isset($_GET['id'])) {
 	$postid = $_GET['id'];
 	$userid = $_SESSION['userid'];
 	$username = $_SESSION['username'];
 	if (is_numeric($postid)) {
 	
 	$query = mysqli_query($link, 'select * from votes where userid="'.$userid.'" and postid="'.$postid.'"');
 	if (mysqli_num_rows($query) > 0) {
 		echo 'You\'ve already voted for this debate!';
 	} else {
 		//go on
 		if (isset($_GET['type'])) {
 			$type = $_GET['type'];
 			if (is_numeric($_GET['type'])) {
 				if ($type == 1) {
 					mysqli_query($link, 'insert into votes (postid, userid, type) values ("'.$postid.'","'.$userid.'","1")');

 					$quer3y = mysqli_query($link, 'select userid from debates where id="'.$postid.'"');
 					$result = mysqli_fetch_array($quer3y);
 					if ($result['userid'] == $_SESSION['userid']) {
 						$content = "You upvoted your own post."; 
 					} else {
 					$content = "".$username." just upvoted your <a href=\"debate.php?id=".$postid."\">debate.</a>";
 					}
					alert($result['userid'], $content);

 				}
 				if ($type == 0) {
 					mysqli_query($link, 'insert into votes (postid, userid, type) values ("'.$postid.'","'.$userid.'","0")');
 					$quer3y = mysqli_query($link, 'select userid from debates where id="'.$postid.'"');
 					$result = mysqli_fetch_array($quer3y);
 					if ($result['userid'] == $_SESSION['userid']) {
 						$content = "You downvoted your own post."; 
 					} else {
 					$content = ''.$username.' just downvoted your <a href="debate.php?id='.$postid.'">debate.</a>';
 				}
					alert($result['userid'], $content);
 				}
 			} else { echo 'That value you\'ve given me is invalid. ';}
 	} else { echo 'That value you\'ve given me is invalid. ';}
 	} // if type is set
 	}
 } //IS NUMERIC IF END, PUT ELSE TO SESSION VAR
 } else { header('Location: ../index.php'); }
 ?>