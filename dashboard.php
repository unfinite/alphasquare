<?php
include('universal.php');

blockGuest();

?>

<!DOCTYPE html>
<html>
    <head>
  <link href='http://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <title>Debates - Alphasquare</title>
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
</style>

    </head>

    <body style="background-color:rgb(236, 240, 241);">

    <?php 
include('assets/navbar-logged.php');

?>
<div class="container-fluid">
<br><br><br><br>
<div class="row">
  <div class="col-xs-12 col-md-8">
  
<form method='post' class="form-inline" id="postbar">

<input id="pst" name='body' class="post" placeholder="Whatcha debatin' on, <?php getUsername(); ?>?">
</input>
</form>

<br>



<div id="posts"> 
<?php 
$users = show_users($_SESSION['userid']);
if (count($users)){
  $myusers = array();
  $myusers = array_keys($users);
}else{
  $myusers = array();
}
$myusers[] = $_SESSION['userid'];
$posts = get_posts($myusers,0);
if (count($posts)){
?>
<?php
foreach ($posts as $key => $list){
?>
<div class="fw"> 
<img class="img-circle prp" src="<?php profilePictureID($list['userid']) ?>" >&nbsp;&nbsp;&nbsp;
<article class="box postc">
<?php echo showBBcodes(atag_link($list['content'])); ?>
<hr class="dvs">
<small>
<button class="btn btn-success btn-xs slab rate" data-ref="resources/vote.php?id=<?php echo $list['id']; ?>&type=1">
<span class="glyphicon glyphicon-thumbs-up "></span>
 <?php votes($list['id'], 1); ?> </button>&nbsp;
  <button class="btn btn-success btn-xs slab rate" data-ref="resources/vote.php?id=<?php echo $list['id']; ?>&type=0">
  <span class="glyphicon glyphicon-thumbs-down"></span> <?php votes($list['id'], 0); ?></button>&nbsp;
  <a href="#" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-comment"></span> Discussion</a>
  </small><span class="pull-right tmecont" >
  <abbr title="<?php echo gmdate('Y-m-d\TH:i:s\Z', $list['time']); ?>" class="timeago"></abbr>
  </span></article></div>
<br><br>
<?php 
}
?>
</table>
<?php
} else{
?>
<p><b>You haven't posted anything yet!</b></p>
<?php
}
?>
</div></div>
  <div class="col-xs-6 col-sm-4"><div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab">Sponsored</h3>
  </div>
  <div class="panel-body">
  <center>
  <b>Help us get a new amazing and fast server, courtesy of Neq3!</b> Your contribution will assure Alphasquare's future. Please click below and sign up,
it will really help us! <br><br>
<a href="http://api.neq3.com/redir/6146700" target="_blank"><img src="http://neq3.com/banners/300x250.gif" alt="http://neq3.com" border="0" width="300" height="250" /></a>
</center>
  </div>
  </div>

  <div class="alert alert-info"> <span class="glyphicon glyphicon-flash"></span> We encourage you all to post any bugs or proposals in it. <a href="https://snowy-evening.com/alphasquare/alphasquare/">Click here to check it out!</a></div>
<br>
  <div class="panel panel-default" style="width:100%">
  <div class="panel-body">
    <ul class="nav nav-pills nav-stacked slab">

  <li class="active">
    <a href="#">
      
      Dashboard
    </a>
    
  </li>
  <li>
   <a onclick="markread()"   data-toggle="modal"
   data-target="#alerts" href="#">
 <span class="badge badge-danger pull-right" id="alerts2"></span>
      Alerts
    </a>
    </li>
  <li>
  <a href="#">
      People
    </a>
    </li>
    <li>
    <a href="#">
      Me
    </a>
    </li>
</ul>

  </div>
</div>
<br>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab">People</h3>
  </div>
  <div class="panel-body">
    <?php

$users = show_users($_SESSION['userid']);

if (count($users)){
?>

<?php
foreach ($users as $key => $value){
?> <img src="<?php profilePicture($value) ?>" class="img-circle" style="width:40px;height:40px;">
<?php
}
?>
<?php
}else{
?>
<b>You're not following anyone yet. </b>
<?php
}
?>
  </div>
</div>
<br>
<!-- TOOLKIT START -->
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab">Development Toolkit</h3>
  </div>
  <div class="panel-body">
<a href="https://snowy-evening.com/alphasquare/alphasquare/" class="btn btn-lg btn-info btn-block">Report a bug</a>
<br>
  <button onclick="manual()" class="btn btn-lg btn-info btn-block">Manual AJAX request (override)</button>
  <br>  <button onclick="notify()" class="btn btn-lg btn-info btn-block">Trigger test notification</button>
<br>
    <button onclick="document.location.reload(true)" class="btn btn-lg btn-info btn-block">Refresh site (update HTML and JS)</button>

  </div>
</div>
<!-- TOOLKIT END -->
</div>
</div>
</div>
  <div id="invisible">
</div>

<script src="js/jquery.js"></script>
<script src="js/timeago.js" type="text/javascript"></script>
<script src="resources/notifications.js"></script>

<script>
console.log('Y U LOOKIN AT CONZOLE? WHAT IZ YOUR BUSINEZZ HERE??!?!!? Y U NO USE THE SITE INSTEAD?');
console.log('Just kidding, welcome to Alphasquare 1.1.1a. ');

$("#postbar").submit(function() {

    var url = "add.php"; // the script where you handle the form input.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#postbar").serialize(), // serializes the form's elements.
           beforeSend: function(){ 
           $('#pst').prop('disabled', true);
           },
           success: function(data)
           {
          $('#pst').prop('disabled', false);
          $('#pst').val('');
          $.post('resources/posts.php');

           }
         });

    return false; // avoid to execute the actual submit of the form.
});

function quasar(){


$.post('resources/posts.php',function(data){

  $("#posts").html(data);
  $("abbr.timeago").timeago();

  $('#posts').on('click', '.rate', function(e){
var url = $(this).attr('data-ref');
      $.post(url);
      e.preventDefault();
      manual();
  });
});
    $.post('resources/count.php',function(data){
    $("#alerts2").html(data);
    });

    $.post('resources/alerts.php',function(data){
    $("#alert-modal").html(data);
    });

 $.post('resources/notifications.php',function(data){
      $("#invisible").html(data);

});

    setTimeout("quasar();",15000);
}

window.onload = quasar();

function notify() {

  $.notifyBar({  html: "This is a test.", position: "top" }); 

}

function notifFetch() {

    $.post('resources/count.php',function(data){
    $("#alerts2").html(data);
    });

    $.post('resources/alerts.php',function(data){
    $("#alert-modal").html(data);
    });

    $.post('resources/notifications.php',function(data){
      $("#invisible").html(data);
    });

}

function manual(){
    $.post('resources/posts.php',function(data){
        $("#posts").html(data);
    });

    $.post('resources/count.php',function(data){
    $("#alerts2").html(data);
    });

    $.post('resources/alerts.php',function(data){
    $("#alert-modal").html(data);
    });

}

function markread() {
    $.get("resources/mark.php");
}

 </script>

    <script src="js/bootstrap.min.js"></script> 

 <div class="modal fade" id="alerts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" >
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title slab">Alerts</h4>
        </div>
        <div class="modal-body" id="alert-modal" style="max-height: 420px;
    overflow-y: auto;">
    
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-primary">Okay, I'm done.</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
    </body>
</html>
