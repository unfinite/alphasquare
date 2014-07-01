<?php
include '../config.php';
if(isset($_POST['status']))
{
$status = stripslashes(mysqli_real_escape_string($link, $_POST['status']));
mysqli_query($link, 'update users set status="'.$status.'" where id="'.$_SESSION['userid'].'"');
$profile = '../profile.php?id='.$_SESSION['userid'].'';
header('Location:'.$profile);
}
?>