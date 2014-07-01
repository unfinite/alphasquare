<?php

//*OPTIMIZATION REQUIRED URGENTLY: BUG ID #48274 TOOMANYQUERIES=1QUERYNEEDED *//
$req3 = mysqli_query($link, 'select m1.id, users.id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="no" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="no" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc limit 1');

$queryla = mysqli_fetch_array($req3);

	$notifUser = json_encode($queryla['username']);

	/* Specific Function here, not meant to be used anywhere else */

	$query12 = mysqli_query($link, 'select message from pm where id="'.$queryla['id'].'" and shown="no" ORDER BY timestamp desc limit 1');
   if (mysqli_num_rows($query12) != 0)
   {
    $message12 = mysqli_fetch_array($query12);
    mysqli_query($link, 'update pm set shown="yes" where id="'.$queryla['id'].'"');
    $lastmessagae = base64_decode($message12['message']);   
  $notifUser2 = $queryla['username'];

    ?>
    <script>
    function decodeEntities(s){
    var str, temp= document.createElement('p');
    temp.innerHTML= s;
    str= temp.textContent || temp.innerText;
    temp=null;
    return str;
}
var post = decodeEntities('<?php echo $lastmessagae; ?>');
var user = decodeEntities('<?php echo $notifUser2; ?>');

    function notification(){
    var notification = webkitNotifications.createNotification('https://www.twii.me/data/user/avatar/big/21/bVjk-1K7Tufau4x1396209661X-JjqvKrOnRTyM_.jpg', user, post );
    notification.show();
  } 
  notification();


    </script>
    <?php
}






	 	?>



<?php
    $query12 = mysqli_query($link, 'select message from pm where id="'.$queryla['id'].'" and shown="no" ORDER BY timestamp desc limit 1');
    $message12 = mysqli_fetch_array($query12);
       if (mysqli_num_rows($query12) != 0)
   {
 mysqli_query($link, 'update pm set shown="yes" where id="'.$queryla['id'].'"');
    $last = json_encode(base64_decode($message12['message']));
    ?>
<script>
  
setTimeout(function() {
    $.growl( { 
        title: '<?php echo $notifUser; ?>', 
        message: '<?php echo $last; ?>',
    });
}, 3000);
</script>
<?php
}
?>