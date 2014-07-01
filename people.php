<?php 
include("universal.php");

?>
<!DOCTYPE html>
<html>
<head>
	<!DOCTYPE html>
<html>
    <head><link href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.0.0/animate.min.css' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <title>People - Alphasquare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <script src="http://code.jquery.com/jquery.js"></script>
<script src="js/growl.js"></script>    <!-- Bootstrap -->
 <link href="themes/bootstrap.css" rel="stylesheet">
<!-- Start of Woopra Code -->


<!-- End of Woopra Code -->
    </head>

    <body>
    <?php 
include('assets/navbar-logged.php');
?>

<br><br>

<br><br>

<?php
$users = show_users();
$following = following($_SESSION['userid']);
if (count($users)){
?>
<table border='1' cellspacing='0' cellpadding='5' width='500'>
<?php

foreach ($users as $key => $value){
	echo "<tr valign='top'>\n";
	echo "<td>".$key ."</td>\n";
	echo "<td>".$value;
	if (in_array($key,$following)){
		echo " <small>
		<a href='resources/do.php?id=$key&do=unfollow'>unfollow</a>
		</small>";
	}else{
		echo " <small>
		<a href='resources/do.php?id=$key&do=follow'>follow</a>
		</small>";
	}
	echo "</td>\n";
	echo "</tr>\n";
}
?></table><?php
}else{
?>
<p><b>There are no users!</b></p>
<?php
}
?>
</body>
</html>