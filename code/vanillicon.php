<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vanillicon PHP function - Alphasquare Open Code</title>

 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="container">


  <center>
  <div class="page-header">
    <h1>vanillicon()<small><br>A micro-function made for simply fetching the Vanillicon of an user</small></h1>
    
</div>

    </center>
  <div class="container">
   <Br>
  <form  method="post">
  <input class="form-control" type="text" name="name" placeholder="Put anyone's name here, and press enter.">
  </form>

  <?php
  function vanillicon($username) 
{
echo '<br><center><img class="img-circle" src="http://www.vanillicon.com/'.md5($username).'_200.png"></center><br>';
}
  if (isset($_POST["name"])) {
$username = $_POST["name"];;
vanillicon($username);
  }
  ?>
  <br>

    <pre> function vanillicon($username) 
{
echo '&lt;img class="img-circle" src="http://www.vanillicon.com/'.md5($username).'_200.png"&gt;';
}
</pre>
</div>
  </body>
</html>