<?php
include('universal.php');
?>
<!DOCTYPE html>
<html >
    <head>
        <link href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.0.0/animate.min.css' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>

<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <title>Alphasquare - user</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="themes/bootstrap.css" rel="stylesheet" media="screen">
   </head>
    <body class="profile">
    <div class="container">
    <div class="row">
<div class="col-md-4 profile-zone">
      <?php 
if(isset($_SESSION['username']))
{
include 'assets/navbar-logged.php';
} else {
include 'assets/navbar.php';
}
?>

       
<?php
//We check if the users ID is defined
if(isset($_GET['id']))
{
	$id = intval($_GET['id']);
	//We check if the user exists
	$dn = mysqli_query($link, 'select username, email, avatar, status, id, signup_date from users where id="'.$id.'"');
	if(mysqli_num_rows($dn)>0)
	{
		$dnn = mysqli_fetch_array($dn);
		//We display the user datas

?>

<br>
<?php
$username = htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8');
?>




    <center>
    <p>
                    <img src="<?php profilePicture($username); ?>" style="width:100px;height:100px;border: 5px grey;" class="img-circle"></a>
  </p>
  <p>
                    <h3 class="media-heading"><?php echo $username; ?></h3>
                    </p>
                    &nbsp;<span class="label label-success">User</span>
                        <?php 

$result = mysqli_query($link, 'select officia from users where id="'.$id.'"');

$badges = mysqli_fetch_assoc($result); if($badges['officia'] == 1){
echo '&nbsp;<span class="label label-success">Verified</span>';
} 
$result2 = mysqli_query($link, 'select ranger from users where id="'.$id.'"');

$badges2 = mysqli_fetch_assoc($result2); if($badges2['ranger'] == 1){
echo '&nbsp;<span class="label label-info">Ranger</span>';
} 
?>

                    </center>
                    <hr>
                    <center>
                    <p class="text-left"><strong>About <?php echo $username; ?>: </strong><br>
                        <?php if ($dnn['status'] = "") { echo 'I haven\'t set a description yet... :( '; } else {
echo htmlentities($dnn['status']);
                            }
                            ?> 
</p><p> </p>
<p>
   <?php
if(isset($_SESSION['username']))
{
echo '<a href="/create.php?username='.htmlentities($dnn['username']).'" class="btn btn-primary  btn-lg btn-block"> Follow</a>';
} else {
$username = htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8');
echo '<a href="/" class="btn btn-primary  btn-block ">Sign in to follow me.</a>';
}
?>
</p>

</center>
      
<?php
//We add a link to send a pm to the user

    }
    else
    {
        echo '<br><div class="alert alert-info">This user does not exist.</div>';
    }
}
else
{
    echo '<br><div class="alert alert-info">The user ID is not defined.</div>';
}
?>
     </div>
</div>
</div>
 <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	</body>
</html>
