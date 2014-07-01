<?php
if (isset($_POST['name']) and $_POST['name']!='')
{
header('Location: retrieve.php?file='.$_POST['name'].'');
}

	?>
<!DOCTYPE html>
<html>
  <head>
    <title>Alphasquare Public Code Repository - Retrieve</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap.css" rel="stylesheet" media="screen">
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>

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
  <h1>Retrieve your code <small>Here's your awesome code </small></h1>
</div>

<div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Hi there!</strong> Welcome to Alphasquare's new code storage service. We're in beta, so expect bugs!
</div>


<?php
if(isset($_GET['file']))
{
	echo '<pre style="width:100%;height:85%" class="prettyprint">
';
if(file_exists("r/".$_GET['file'])) {
$file = "r/".$_GET['file']."";
$f = fopen($file, "r"); 
echo htmlspecialchars(fread($f, filesize($file)));
	echo '</pre>
';
} else {
	echo 'Seems like that code doesn\'t exist.';
}
} else {
?>
<center>
<form action="retrieve.php" method="post">

<input name="name" id="code" class="form-control " placeholder="Please enter the filename and hit that huge button...">
<br>


<button class="btn btn-primary btn-lg btn-block" type="submit">Find it!</button>
</form>
</center>
<?php
}
?>


</div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap.min.js"></script>
  </body>
</html>