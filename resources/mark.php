<?php
include '../universal.php';
mysqli_query($link, 'update alerts set seen="1" where userid="'.$_SESSION['userid'].'" and seen="0"');
?>