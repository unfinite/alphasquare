<?php
include('universal.php');
blockMember();
?>
<!DOCTYPE html>
<html>
    <head>

         <link href='http://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>

<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <title>Alphasquare - secure connection</title>
        <link href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.0.0/animate.min.css' rel='stylesheet' type='text/css'>

    </head>
    <body>
<br>
<br>
      <?php 
include 'assets/navbar.php';
?>
 <div class="container">
  <div class="page-header">
  <h1>Forgot something?<small>don't worry, help is on the way</small></h1>
</div>
<br>
<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Reset your password</h3>
			 	</div>
			  	<div class="panel-body">
<form action="" method="post">
<br>
<input type="text"  class="form-control" name="remail" size="50" maxlength="255" placeholder="Email Address">
<br>

<input class="btn btn-success btn-block" type="submit" name="submit" value="Reset">
<br>

</form>
<div class="alert alert-info">
<?php

//This code runs if the form has been submitted
if (isset($_POST['submit']))
{
 
// check for valid email address
$email = mysqli_real_escape_string($link, $_POST['remail']);
$pattern = '/^[^@]+@[^\s\r\n\'";,@%]+$/';
if (!preg_match($pattern, trim($email))) {
  $error = 'Please enter a valid email address.';
}
 
// checks if the username is in use
$check = mysqli_query($link, "SELECT email FROM users WHERE email = '$email'");
$check2 = mysqli_num_rows($check);
 
//if the name exists it gives an error
if ($check2 == 0) {
$error = 'Sorry, we cannot find your account details please try another email address.';
}
 
// if no errors then carry on
if (!$error) {
 
$query = mysqli_query($link, "SELECT username FROM users WHERE email = '$email' ");
$r = mysqli_fetch_object($query);
 
//create a new random password
 
$password = substr(md5(uniqid(rand(),1)),3,10);
$pass = sha1($password); //encrypted version for database entry
 
//send email
$to = "$email";
$subject = "Alphasquare Password Request";
$body = "Hey there! We reset your password due to a request. Here's your new password: $password";
$additionalheaders = "From: <admin@alphasquare.us>rn";
$additionalheaders .= "Reply-To: admin@alphasquare.us";
mail($to, $subject, $body, $additionalheaders);
 
//update database
$sql = mysqli_query($link, "UPDATE users SET password='$pass' WHERE email = '$email'");
$rsent = true;
 
 
}// close errors
}// close if form sent
 

 
 
if ($rsent == true){
    echo "<p>You have been sent an email with your account details to $email</p>";
    } else {
    echo 'Please enter your e-mail address. You will receive a new password via e-mail.';
    }
 
?></div>
<?php if (isset($error)) {echo '<div class="alert alert-info">'.$error.'</div>';} ?>
</div>
</div>
<?php 
include 'assets/footer.php'
?>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
 </body>
</html>
