<?php
include('universal.php');
?>

<!DOCTYPE html>
<html>
    <head>
  <link href='http://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <title>Debates - Alphasquare</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/growl.js"></script>    <!-- Bootstrap -->
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
    if(isset($_SESSION['userid'])) {
      include('assets/navbar-logged.php');
    } else {
      include('assets/navbar-inverse.php');
    }
?>
<div class="container-fluid">
<div class="row">
  <div class="col-xs-12 col-md-8">
<div id="post">

  <?php

  $post = $_GET['post'];
  if (is_numeric($post)) {
    $query = mysqli_query($link, 'select * from debates where id="'.$post.'" limit 1');
    if (mysqli_num_rows($query) !== 0) {
      $list = mysqli_fetch_array($query);
  $foobar = str_replace('&amp;', '&', $list['content']);

  ?>
  <div class="fw">
<img class="img-circle prp" src="<?php profilePictureID($list['userid']) ?>" >&nbsp;&nbsp;&nbsp;
<article class="box postc">
<?php echo showBBcodes(atag_link(stripslashes($foobar))); ?>
<hr class="dvs">
<small><?php
    if(isset($_SESSION['userid'])) {
?> <button class="btn btn-success btn-xs slab rate" data-ref="resources/vote?id=<?php echo $list['id']; ?>&type=1">
<span class="glyphicon glyphicon-thumbs-up "></span>
 <?php votes($list['id'], 1); ?> </button>&nbsp;
  <button class="btn btn-success btn-xs slab rate" data-ref="resources/vote?id=<?php echo $list['id']; ?>&type=0">
  <span class="glyphicon glyphicon-thumbs-down"></span> <?php votes($list['id'], 0); ?></button>&nbsp;
<?php
    } else {
      ?> <span class="glyphicon glyphicon-thumbs-up "></span>
 <?php votes($list['id'], 1); ?> </button>&nbsp; <span class="glyphicon glyphicon-thumbs-down"></span> <?php votes($list['id'], 0); ?> &nbsp;<span class="slab">Sign in to vote on this. <a href="/">Let's go &raquo;</a></span>
      <?php
    }
?>

  </small><span class="pull-right tmecont" >
  <abbr title="<?php echo gmdate('Y-m-d\TH:i:s\Z', $list['time']); ?>" class="timeago"></abbr>
  </span></article></div>

<br>

TESTING CAUTION!!!
<BR>
<form action="resources/add_comment" method="POST">
<input name="id" hidden value="<?php echo $list['id']; ?>">
<input placeholder="Comment" name="content">
<button type="submit">Add</button>
</form>
<?php 
$posts = show_comments($list['id']);
if (count($posts)){

foreach ($posts as $key => $t){
    $foobar = str_replace('&amp;', '&', $list['content']);
    echo '<pre>'.$t['content'].'</pre><br>
    ';
} }
?>

<?php
} else {
  echo '<span class="slab">Oh noes! I couldn\'t find that debate you wanted! </span>';
}

} else {
  echo '<span class="slab">That debate ID isn\'t valid.</span>';
}

?>
</div></div>

  <div class="col-xs-6 col-sm-4">
    <?php
    if(isset($_SESSION['userid'])) {
      include('assets/sidebar-logged.php');
    } else {
      include('assets/sidebar.php');
    }
?>
</div>

</div>
<div id="invisible">
</div>
<script src="js/jquery.js"></script>
<script src="js/timeago.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
        $('.timeago').timeago();
    });

function quasar(){
  $('#post').on('click', '.rate', function(e){
var url = $(this).attr('data-ref');
      console.log('Console: liked/disliked '+url);
      $.post(url);
      e.preventDefault();
      quasar();
  });

    $.post('resources/count',function(data){
    $("#alerts2").html(data);
    });

    $.post('resources/alerts',function(data){
    $("#alert-modal").html(data);
    });

 $.post('resources/notifications',function(data){
      $("#invisible").html(data);
});

    setTimeout("quasar();",10000);
}

window.onload = quasar();

function notify() {

  $.growl({ message: "Triggered test notification." });

}
function manual(){
    $.post('resources/posts',function(data){
        $("#posts").html(data);
    });

    $.post('resources/count',function(data){
    $("#alerts2").html(data);
    });

    $.post('resources/alerts',function(data){
    $("#alert-modal").html(data);
    });

}

function markread() {
    $.get("resources/mark");
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
