<!DOCTYPE html>
<html lang="en">
<head>
<title>404 Page Not Found</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:200,300,700' rel='stylesheet' type='text/css'>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="/assets/css/error-page.css" rel="stylesheet" />
</head>
<body>
  <div id="container">
    <span class="glyphicon glyphicon-question-sign"></span>
    <h1>This page doesn't exist</h1>
    <p>We're truly sorry, but we couldn't find the page you requested.</p>
    <p class="buttons">
      <form action="/alphasquare/search" method="get">
        <input type="text" name="q" class="form-control" placeholder="Search posts and users..." />
        <button class="btn btn-primary">Search</button>
      </form>
    </p>
    <p>
      <a href="javascript:history.back();" class="back">&larr; Go Back</a>
      &nbsp;&nbsp;
      <a href="/" class="back">Go to Homepage &rarr;</a>
    </p>
    <footer>
      Copyright &copy; <?=date("Y")?> Alphasquare.
    </footer>
  </div>
</body>
</html>