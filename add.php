<?php

include("universal.php");

$userid = $_SESSION['userid'];
$body = substr($_POST['body'],0,140);

add_debate($userid,$body);

?>