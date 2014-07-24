<?php
include('universal.php');

blockGuest();


 if(isset($_GET['q'])) {

   $query = mysqli_real_escape_string($link, $_GET['q']);
   $queryr = mysqli_query($link, "SELECT id, userid, content, time FROM `debates` WHERE content LIKE '%$query%' or tags LIKE '%$query%' ORDER BY `time` DESC");
 } 
 if (isset($_POST['box'])){

       $query = mysqli_real_escape_string($link, $_POST['box']);
   $queryr = mysqli_query($link, "SELECT id, userid, content, time FROM `debates` WHERE content LIKE '%$query%' or tags LIKE '%$query%' ORDER BY `time` DESC");

  }

 ?>

<!DOCTYPE html>
<html>
    <head>
  <link href='http://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <title>Find - Alphasquare</title>
    <link href='resources/notifications.css' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="themes/bootstrap.css" rel="stylesheet">
<style>
.post {
	height:50px;width:100%;font-family:'Roboto Slab';font-size:20px;
padding-left:10px;padding-right:10px;border:1px solid #bdc3c7;border-radius:5px;
}
.box {
	width:100%;font-family:'Roboto Slab';padding-top:20px;padding-bottom:20px;
padding-left:10px;padding-right:10px;border:1px solid #bdc3c7;border-radius:4px;background-color: white;
}
.slab {
	font-family: Roboto Slab;
}
.fw {

width:100%;display:flex;
}
.prp {
  height:53px;width:53px; border:1px solid white;
}
.postc {
  word-wrap:break-word;font-size:17px;flex:1 0 0;padding-bottom:10px;
}
.dvs {
  margin-bottom:5px;
}
.tmecont {
  color:grey;font-size:15px;
}

input.statusi:focus {
    outline-width: 0;
}
</style>

    </head>

    <body style="background-color:rgb(236, 240, 241);">

    <?php
include('assets/navbar-logged.php');

?>


<div class="container">
<center>
<div class="page-header">
  <h1>Find anything.<br> <small>Really <a href="find?q=awesome" > <b>&awesome</b></a>, right?</small></h1>
</div>
<form method="POST" action="find.php">
<input class="form-control input-lg" name="box" placeholder="Type anything and hit enter...">
</form>
</center>
<?php

if (isset($queryr) && mysqli_num_rows($queryr) !== 0){
while($list = mysqli_fetch_assoc($queryr)){
    $foobar = str_replace('&amp;', '&', $list['content']);

  ?><br>
  <div style="width:75%;margin:0 auto;">
<div class="fw"> 
<img class="img-circle prp" src="<?php profilePictureID($list['userid']) ?>" >&nbsp;&nbsp;&nbsp;
<article class="box postc">
<?php echo showBBcodes(atag_link(stripslashes($foobar))); ?>
<hr class="dvs">
<small>

  <a href="debate?post=<?php echo $list['id']; ?>" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-search"></span> View &raquo;</a>
  </small><span class="pull-right tmecont" >
  <abbr title="<?php echo gmdate('Y-m-d\TH:i:s\Z', $list['time']); ?>" class="timeago"></abbr>
  </span></article></div></div>
<br><br>
<?php

}
}
?>
</center>



</div>

<script src="js/jquery.js"></script>
<script src="js/timeago.js" type="text/javascript"></script>
<script>  $("abbr.timeago").timeago();
</script>
<script src="resources/notifications.js"></script>
    <script src="js/bootstrap.min.js"></script>


</body>
</html>