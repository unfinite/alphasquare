<?php 
include('universal.php');

$action = $_GET['action'];

$session = New SessionManage($action);
	header('Location: index.php');

?>

