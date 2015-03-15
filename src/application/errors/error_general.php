<!DOCTYPE html>
<html lang="en">
<head>
<title>Error :(</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:200,300,700' rel='stylesheet' type='text/css'>
<link href="/dev/assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="/dev/assets/css/error-page.css" rel="stylesheet" />
</head>
<body>
  <div id="container">
    <span class="glyphicon glyphicon-exclamation-sign"></span>
    <h1>An Error Occurred</h1>
    <p><?php echo $message; ?></p>
    <p class="buttons">
      <a href="javascript:history.back();" class="btn btn-primary">&larr; Back to Last Page</a>
    </p>
    <p>
      <a href="/" class="back">Go to Homepage</a>
    </p>
    <footer>
      Copyright &copy; <?=date("Y")?> Alphasquare.
      </footer>
  </div>
</body>
</html>