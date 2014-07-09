<?php
include('universal.php');
blockMember();
?>
<!DOCTYPE html>
<html>
    <head>
      <?php

?>

         <link href='http://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>

<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <title>Alphasquare - secure connection</title>
        <link href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.0.0/animate.min.css' rel='stylesheet' type='text/css'>
<!-- Start of Woopra Code -->
<script>
(function(){
    var t,i,e,n=window,o=document,a=arguments,s="script",r=["config","track","identify","visit","push","call"],c=function(){var t,i=this;for(i._e=[],t=0;r.length>t;t++)(function(t){i[t]=function(){return i._e.push([t].concat(Array.prototype.slice.call(arguments,0))),i}})(r[t])};for(n._w=n._w||{},t=0;a.length>t;t++)n._w[a[t]]=n[a[t]]=n[a[t]]||new c;i=o.createElement(s),i.async=1,i.src="//static.woopra.com/js/w.js",e=o.getElementsByTagName(s)[0],e.parentNode.insertBefore(i,e)
})("woopra");

woopra.config({
    domain: 'alphasquare.us'
});
woopra.track();
</script>
<!-- End of Woopra Code -->
    </head>
    <body>

      <?php
include 'assets/navbar.php';
?>
<br>
<br>
<div class="container">
 <div class="container">
   <div class="page-header">
  <h1>Hello there!<small>&nbsp;let's create an account</small></h1>
</div>


<?php

require_once("resources/ayah.php");
$ayah = new AYAH();

//We check if the form has been sent
if(isset($_POST['username'], $_POST['password'], $_POST['passverif'], $_POST['email']) and $_POST['username']!=='')
{
	$score = $ayah->scoreResult();

  if (!$score) {
    include_once('assets/navbar.php');
    echo '<br><div class="alert alert-info"> Oh noes! The captcha is incorrect. Try again.</div>';
    die();
  }
	//We remove slashes depending on the configuration
	if(get_magic_quotes_gpc())
	{
		$_POST['username'] = stripslashes($_POST['username']);
		$_POST['password'] = sha1(stripslashes($_POST['password']));
		$_POST['passverif'] = stripslashes($_POST['passverif']);
		$_POST['email'] = stripslashes($_POST['email']);
	}

//We check if the two passwords are identical
	if($_POST['password']==$_POST['passverif'])
	{
		//We check if the password has 6 or more characters
		if(strlen($_POST['password'])>=6)
		{
			//We check if the email form is valid
			if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
			{
				//We protect the variables
				$username = mysqli_real_escape_string($link, $_POST['username']);
				$password = sha1(mysqli_real_escape_string($link, $_POST['password']));
				$email = mysqli_real_escape_string($link, $_POST['email']);

				//We check if there is no other user using the same username
				$query = 'select id from users where username="'.$username.'" or email="'.$email.'"';
				$dn = mysqli_num_rows(mysqli_query($link, $query));
				if($dn==0)
				{
					//We count the number of users to give an ID to this one
					//We save the informations to the databse
					$query = 'insert into users(`username`, `password`, `email`, `signup_date`) values ("'.$username.'", "'.$password.'", "'.$email.'", "'.time().'")';
					if(mysqli_query($link, $query))
					{

?>
<br><div class="alert alert-info">Awesome, thanks for signing up! You can now log in and start sharing code.<br />
</div>
<?php
					}
					else
					{
						//Otherwise, we say that an error occured
						$form = true;
						$message = 'An error occurred while signing up. Try again with different details or email support.';
					}
				}
				else
				{
					//Otherwise, we say the username is not available
					$form = true;
					$message = 'The username or email you want to use is not available, please choose another one.';
				}
			}
			else
			{
				//Otherwise, we say the email is not valid
				$form = true;
				$message = 'The email you entered is not valid.';
			}
		}
		else
		{
			//Otherwise, we say the password is too short
			$form = true;
			$message = 'Your password must contain at least 6 characters.';
		}
	}
	else
	{
		//Otherwise, we say the passwords are not identical
		$form = true;
		$message = 'The passwords you entered are not identical.';
	}
}
else
{
	$form = true;
}
if($form)
{
	//We display a message if necessary
	if(isset($message))
	{
		echo '<br><div class="alert alert-info">'.$message.'</div>';
	}
	//We display the form

?>
<br>
<div class="col-md-5 col-md-offset-1">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Register at Alphasquare</h3>
			 	</div>
			  	<div class="panel-body">

 <form action="register" method="post" >



<div class="form-group">
                <input class="form-control" type="text" placeholder="Username (make it awesome)" name="username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
           <input class="form-control" placeholder="Password" type="password" name="password" /><br />
         <input class="form-control" placeholder="Password (again)" type="password" name="passverif" /><br />
          <input class="form-control" type="text" name="email" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');} ?>" placeholder="Email" /><br />

       <?php

            echo $ayah->getPublisherHTML();
        ?>
        <br> <label>By using this website, you agree to the <a href="tos">terms of use.</a>
    </label><br><br>
            <input  type="submit" class="btn btn-success btn-lg btn-block" value="Sign up"   />

    </form>
</div>
</div>
<div class="panel-footer">Got one? <a href="login">Sign in </a></div>
</div>
</div>
<div class="col-md-4 col-md-offset-2">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Steps for awesomeness</h3>
			 	</div>
			  	<div class="panel-body">
<div class="list-group">
  <a href="#" class="list-group-item active">
    <h4 class="list-group-item-heading">1. Create an account</h4>
    <p class="list-group-item-text">Start by making an account.</p>
  </a>
<a href="#" class="list-group-item">
    <h4 class="list-group-item-heading">2. Get some usernames</h4>
    <p class="list-group-item-text"> Use the meet people page or tell your friends to move over to Alphasquare and you'll get more points!</p>
<a href="#" class="list-group-item">
    <h4 class="list-group-item-heading">3. Send some messages and start earning points</h4>
    <p class="list-group-item-text"> Communicating with your friends has never been so fun!</p>
  </a>
<a href="#" class="list-group-item">
    <h4 class="list-group-item-heading">4. The journey never ends!</h4>
    <p class="list-group-item-text"> Don't stop sending! We frequently update the Square with great features and stuff to make your life easier.</p>
</a>
</div>


</div>
</div>
</div>
<?php
}
?>
     <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

	</body>
</html>
