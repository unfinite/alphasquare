<?php
include('universal.php');
?>
<!DOCTYPE html><html><head><link href='http://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'><link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'><script src="css/jquery-verticalcentering-plugin.min.js"></script><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="css/bootstrap.css" rel="stylesheet" media="screen"><title>Alphasquare - secure connection</title><link href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.0.0/animate.min.css' rel='stylesheet' type='text/css'><script>(function(){var t,i,e,n=window,o=document,a=arguments,s="script",r=["config","track","identify","visit","push","call"],c=function(){var t,i=this;for(i._e=[],t=0;r.length>t;t++)(function(t){i[t]=function(){return i._e.push([t].concat(Array.prototype.slice.call(arguments,0))),i}})(r[t])};for(n._w=n._w||{},t=0;a.length>t;t++)n._w[a[t]]=n[a[t]]=n[a[t]]||new c;i=o.createElement(s),i.async=1,i.src="//static.woopra.com/js/w.js",e=o.getElementsByTagName(s)[0],e.parentNode.insertBefore(i,e)})("woopra");woopra.config({domain: 'alphasquare.us'});woopra.track();</script><script>$('#example').tooltip();$(document).ready(function(){$('#example').popover({trigger: "hover", placement: "top", title: "This is a default title",});});</script><style>body{margin-top: 60px;}#right{float: right;}</style></head><body>      <?php 
include 'assets/navbar.php';
if(!empty($_GET['message'])) {
    $message = $_GET['message'];
    if ($message == "incorrect") {
    	$display = "Your credentials are incorrect, or your account hasn't been activated. Verify your details and try again.";
    }
    }
?><div class="container"><div class="page-header"><h1>Hello there! <small>Sign in to view your messages, and apps. </small></h1></div><div class="row"><div class="col-md-4">
<?php
//If the user is logged, we log him out
if(isset($_SESSION['username']))
{
	//We log him out by deleting the username and userid sessions
	unset($_SESSION['username'], $_SESSION['userid']);
?>
<script>
  function notification(){
    var notification = webkitNotifications.createNotification('https://www.twii.me/data/user/avatar/big/21/bVjk-1K7Tufau4x1396209661X-JjqvKrOnRTyM_.jpg', 'Logged out', 'You logged out successfully, and securely.');
    notification.show();
  } 
  notification();
  </script>
<div class="alert alert-info">You have been logged out securely.</div>
<?php
}
?>
<?php 
if(isset($display)) {
	echo '<div class="alert alert-info">'.$display.'</div>';

	?>
	<script>
  function notification(){
    var notification = webkitNotifications.createNotification('https://www.twii.me/data/user/avatar/big/21/bVjk-1K7Tufau4x1396209661X-JjqvKrOnRTyM_.jpg', 'Something went wrong', 'Your credentials are incorrect. Please try again. Maybe you mistyped them?');
    notification.show();
  } 
  notification();
  </script>
<?php
}
?>
<div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">Please sign in</h3></div><div class="panel-body"><form action="process-login.php" method="post"><fieldset><div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username" id="username" ></div><div class="form-group"><input class="form-control" type="password" name="password" id="password" placeholder="Password"></div><input class="btn btn-lg btn-success btn-block" type="submit" value="Login"></fieldset></form><br><a class="btn btn-info btn-lg btn-block" href="forgot.php"> Forgot something?</a></div></div></div><div class="col-md-4"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">No Squarepass?</h3></div><div class="panel-body"><a class="btn btn-success btn-lg btn-block" href="register.php"> Get a Squarepass.</a></div></div><div class="panel panel-default"><div class="panel-body"><div class="modal fade" id="squarepass-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title" id="myModalLabel">One password. All our sites.</h4></div><div class="modal-body"><h5>Meet the Squarepass, the new way to access your digital life. One password, all of the 1Pixel network. It's easy, convenient, and free. Go ahead, close this and create a pass! We're sure you'll love it. </h5></div><div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Okay, got it!</button></div></div></div></div><button class="btn btn-info btn-lg btn-block" data-toggle="modal" data-target="#squarepass-info"> Why get one?</button></div></div></div></div></div><script src="https://code.jquery.com/jquery.js"></script><script src="js/bootstrap.min.js"></script></body></html>