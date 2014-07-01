<?php
include('universal.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Alphasquare X</title>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>

  <link href='notifications.css' rel='stylesheet' type='text/css'>
</head>
<body style="font-family: Roboto Slab;"><center>
<span style="font-size: 20px;"><br><br>Welcome to Alphasquare X. You're gonna see some bleeding-edge not-ready-for-production stuff, so expect bugs!</span><br><i><small>This little demo was made 100% with OOP!</small></i>

<br><br>
<form action="assets/change.php" method="POST">
<input name="user">
<button type="submit">Set value.</button>
</form>
<br>
<a href="session.php?action=unset">Clear</a>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="notifications.js"></script>

<style>

.notify {
	width:100%;
	background-color: #3498db;
	display: flex;
	max-height:50px;
	text-align: center;
	margin: 0px auto;
	padding-top: 5px;
	padding-bottom: 5px;
	word-wrap: break-word;
}

</style>
<script>
$(function () { $.notifyBar({  html: "<b>Notification:  </b>   <?php $var = new User;
$var->get_username();  ?>" }); });
</script>
</body>
</html>