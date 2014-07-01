<?php
include '../config.php';
?>
<?php
//We check if the user is logged
if(isset($_SESSION['username']))
{
//We list his messages in a table
//Two queries are executes, one for the unread messages and another for read messages
$req1 = mysqli_query($link, 'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="no" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="no" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
$req2 = mysqli_query($link, 'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.id as userid, users.username  from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="yes" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="yes" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
?>

<?php
//We display the list of unread messages
while($dn1 = mysqli_fetch_array($req1))
{
?>

<?php include_once('../assets/notifications.php'); ?>

<div id="posts message-view" class="row">
        <div class="item col-md-3">
           <div class="panel panel-primary">

  <div class="panel-heading">
<?php echo htmlentities($dn1['username'], ENT_QUOTES, 'UTF-8'); ?>  <a href="read.php?id=<?php echo $dn1['id']; ?>" class="btn btn-xs btn-success right">view &raquo; </a>
  </div>

  <div class="panel-body">
  <h3 class="slab">
    <?php
    $querylast = mysqli_query($link, 'select message from pm where id="'.$dn1['id'].'" ORDER BY timestamp desc limit 1');
    $messageLast = mysqli_fetch_array($querylast);
echo htmlentities(base64_decode($messageLast['message']));
    ?>
    </h3>
  </div>

            </div>
        </div>

<?php
}
?>


<?php
//We display the list of read messages
while($dn2 = mysqli_fetch_array($req2))
{
?>

        <div class="item col-md-3">
           <div class="panel panel-default">

  <div class="panel-heading">
<?php echo htmlentities($dn2['username'], ENT_QUOTES, 'UTF-8'); ?>  <a href="read.php?id=<?php echo $dn2['id']; ?>" class="btn btn-xs btn-success right">view &raquo; </a>
  </div>

  <div class="panel-body">
  <h3 class="slab">
    <?php
    $querylast = mysqli_query($link, 'select message from pm where id="'.$dn2['id'].'" ORDER BY timestamp desc limit 1');
    $messageLast = mysqli_fetch_array($querylast);
    echo htmlspecialchars_decode(base64_decode($messageLast['message']));
    ?>
    </h3>
  </div>

            </div>
        </div>



<?php
}
//If there is no read message we notice it
if (intval(mysqli_num_rows($req2))==0)
{
if(intval(mysqli_num_rows($req1))==0)
{
?>
 <div class="item col-md-5">
           <div class="panel panel-primary">

  <div class="panel-heading">
  You've got no messages yet.
  </div>
    <div class="panel-body">
  <h3 class="slab">
  Hit the paper and pencil in the Action Bar to send a message. Click on the Earth icon to check out our featured developers!
  </h3>
  </div>
	<?php
}
}
?>
</table>
<?php
}
else
{
	echo 'You must be logged to access this page.';
}
?>