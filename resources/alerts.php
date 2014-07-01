<?php
include '../universal.php';
$req = mysqli_query($link, 'select content, seen from alerts where userid="'.$_SESSION['userid'].'" order by time desc ');
while($row=mysqli_fetch_array($req)){
?>
<div class="panel panel-default">
<div class="panel-body">
  <?php echo html_entity_decode($row['content']); ?>
</div>
           </div> 
<?php
}
?>