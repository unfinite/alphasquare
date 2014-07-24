<?php

include("universal.php");

$userid = $_SESSION['userid'];
$body = $_POST['body'];

add_debate($userid,$body);

?>