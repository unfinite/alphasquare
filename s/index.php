
<!DOCTYPE html>
<html>
  <head>
    <title>Alphasquare Public Code Repository</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap.css" rel="stylesheet" media="screen">
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
</head>
<body>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand lobster" href="/" >alphasquare</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">

      
    </ul><p class="navbar-text pull-right" ><i class="glyphicon glyphicon-log_in"></i> 
  <a href="../index.php" class="no-decor-link open-sans " style="text-decoration:none;color:white;"> Go back home &raquo;</a>
  </p>
  </div><!-- /.navbar-collapse -->
</nav>
    <div class="container">
<br><br>
<div class="page-header">
  <h1>Share your code <small>Go ahead, store it for free. </small></h1>
</div>

<div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Hi there!</strong> Welcome to Alphasquare's new code storage service. We're in beta, so expect bugs!
</div>
<script>
$(document).ready(function() {
  $('form').submit(function() {
    if(typeof jQuery.data(this, "disabledOnSubmit") == 'undefined') {
      jQuery.data(this, "disabledOnSubmit", { submited: true });
      $('input[type=submit], input[type=button]', this).each(function() {
        $(this).attr("disabled", "disabled");
      });
      return true;
    }
    else
    {
      return false;
    }
  });
});

</script>

<?php
if (isset($_POST['data']))
{
  if ($_POST['data']!='')
  {
function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
         
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
     
    return $_SERVER['REMOTE_ADDR'];
}
$content = "Submitted at: ".date('l jS \of F Y h:i:s A')."

".$_POST['data'];
$filename = substr(md5(microtime()),rand(0,26),5);
$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/s/r/".$filename.".txt","wb");
fwrite($fp,$content);
fclose($fp);
$message = 'File stored successfully. <a href="retrieve.php?file='.$filename.'.txt" class="btn btn-xs btn-success">View</a>';
}
?><div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Awesome!</strong> <?php echo $message ?>
</div>
<?php

} else {
$message = 'Fill all the fields and hit the button.';
?><div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Please:</strong> <?php echo $message ?>
</div>
<?php
}
?><center>
<form action="index.php" method="post">

<textarea name="data" id="code" class="form-control " style="width:98%;" rows="20" placeholder="Place whatever you want to store here..."></textarea>
<br>
<button class="btn btn-primary btn-lg btn-block" type="submit">Okay, store it!</button>
</form>
</center>
</div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap.min.js"></script>
  </body>
</html>