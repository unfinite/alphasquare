<?php
include '../universal.php';
$req = mysqli_query($link, 'select content, seen from alerts where userid="'.$_SESSION['userid'].'" order by time desc ');
while($row=mysqli_fetch_array($req)){
?>
<div class="panel <?php if ($row['seen'] == 1) { echo "panel-default"; } else { echo "panel-primary"; } ?>" >
<div class="panel-body">
  <?php echo html_entity_decode($row['content']); ?>
</div>
           </div> 
<?php
}
?>