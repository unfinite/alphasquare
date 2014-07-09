<?php
include('universal.php');
if(isset($_SESSION['username']))
{
	unset($_SESSION['username'], $_SESSION['userid']);
	?>
	<br>
	<br><br><div class="alert alert-info">You have been logged out securely.</div>
	<?php
}
else
{
	$ousername = '';
	if(isset($_POST['username'], $_POST['password']))
	{
		if(get_magic_quotes_gpc())
		{
			$passsanitize1 = stripslashes($_POST['username']);
			$usersanitize1 = $_POST['username'];
			$ousername = stripslashes($_POST['username']);
			$username = mysqli_real_escape_string($link, stripslashes($_POST['username']));
			$password = sha1(stripslashes($_POST['password']));
		}
		else
		{
			$username = mysqli_real_escape_string($link, $_POST['username']);
			$password = sha1($_POST['password']);
		}
		//We get the password of the user
		$query = 'select password, id from users where username="'.$username.'"';
		$req = mysqli_query($link, $query);
		$dn = mysqli_fetch_array($req);
		//We compare the submited password and the real one, and we check if the user exists
		if($dn['password']==$password and mysqli_num_rows($req)>0)
		{
			//If the password is good, we dont show the form
			$form = false;
			//We save the user name in the session username and the user Id in the session userid
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['userid'] = $dn['id'];
			header("Location: dashboard");
		}
		else
		{
			//Otherwise, we say the password is incorrect.
			$form = true;
			$message = 'incorrect';
		}
	}
	else
	{
		$form = true;
	}
	if($form)
	{
		header('Location: login?message='.$message);
	}
}
?>