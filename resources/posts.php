<?php
include_once('../universal.php');
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
<?php echo showBBcodes($list['content']); ?>
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

<?php
} else{
?>
<p><b>You haven't posted anything yet!</b></p>
<?php
}
?>
</div>