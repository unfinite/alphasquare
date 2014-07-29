<?php
include('universal.php');
?>
<!DOCTYPE html><html><head><link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"><link href='themes/css-login.css' rel='stylesheet' type='text/css'><link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'><script src="css/jquery-verticalcentering-plugin.min.js"></script><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="css/bootstrap.css" rel="stylesheet" media="screen"><title>Alphasquare - secure connection</title><link href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.0.0/animate.min.css' rel='stylesheet' type='text/css'><script>(function(){var t,i,e,n=window,o=document,a=arguments,s="script",r=["config","track","identify","visit","push","call"],c=function(){var t,i=this;for(i._e=[],t=0;r.length>t;t++)(function(t){i[t]=function(){return i._e.push([t].concat(Array.prototype.slice.call(arguments,0))),i}})(r[t])};for(n._w=n._w||{},t=0;a.length>t;t++)n._w[a[t]]=n[a[t]]=n[a[t]]||new c;i=o.createElement(s),i.async=1,i.src="//static.woopra.com/js/w.js",e=o.getElementsByTagName(s)[0],e.parentNode.insertBefore(i,e)})("woopra");woopra.config({domain: 'alphasquare.us'});woopra.track();</script><script>$('#example').tooltip();$(document).ready(function(){$('#example').popover({trigger: "hover", placement: "top", title: "This is a default title",});});</script><style>body{margin-top: 60px;}#right{float: right;} </style></head><body>      <?php
include 'assets/navbar.php';
if(!empty($_GET['message'])) {
    $message = $_GET['message'];
    if ($message == "incorrect") {
      $display = "Your credentials are incorrect, or your account hasn't been activated. Verify your details and try again.";
    }
        if ($message == "badauth") {
      $display = "Oh noes, something went really wrong while authenticating you with the provider. Contact a Ranger.";
    }

          if ($message == "sess") {
      $display = $_SESSION['autherror'].$_SESSION['technical'];
      unset($_SESSION['autherror']);
            unset($_SESSION['technical']);
    }

    if ($message == "notexists") {
      $display = "We're sorry, but temporarily to login with Twitter your email should match an accountalready created. This is because we haven't finished the system yet. If you're extremely mad about this, send your rants to rants@rants.com because we don't care. Thanks.";
    }

    }
?><div class="container"><div class="page-header"><h1>Hello there! <small>Sign in to view your alerts, debates, and more. </small></h1></div><div class="row"><div class="col-md-5">
<?php
//If the user is logged, we log him out
if(isset($_SESSION['username']))
{
  //We log him out by deleting the username and userid sessions
  unset($_SESSION['username'], $_SESSION['userid']);
?>
<div class="alert alert-info">You have been logged out securely.</div>
<?php
}
?>
<?php
if(isset($display)) {
  echo '<div class="alert alert-info">'.$display.'</div>';

  ?>
  
<?php
}
?>


<div class="panel panel-default">

<div class="panel-heading"><h3 class="panel-title">Please sign in</h3>
</div>

<div class="panel-body">

          <a href="#" class="btn btn-md btn-primary btn-block"><i class="fa fa-facebook fa-md"></i>&nbsp;&nbsp;Sign in with Facebook</a>

          <a href="auth-twitter" class="btn btn-md btn-info btn-block"><i class="fa fa-twitter fa-md"></i>&nbsp;&nbsp;Sign in with Twitter</a>

   <div class="login-or">
        <hr class="hr-or">
        <span class="span-or">or</span>
      </div>

<form action="process-login" method="post">

<fieldset>

<div class="form-group">
<input class="form-control input-md" type="text" name="username" placeholder="Username" id="username" >
</div>

<div class="form-group">
<input class="form-control input-md" type="password" name="password" id="password" placeholder="Password">
</div>
<input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
</fieldset>
</form>
</div>
<div class="panel-footer">
Forgot your credentials? <a href="forgot" >Reset them here &raquo; </a>
</div>
</div>
</div>

<div class="col-md-4">

<div class="panel panel-default">

<div class="panel-heading"><h3 class="panel-title">No Account?</h3>
</div>

<div class="panel-body"><a class="btn btn-success btn-lg btn-block" href="register"> Sign up</a>
</div>
</div>


</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery.js">
</script>
<script src="js/bootstrap.min.js">
</script>
</body>
</html>