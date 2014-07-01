<?php
	include '../universal.php';
	$name = $_POST['user'];
	// Our first OOP script!
	$var = new User;
	$var->set_username($name);
	header('Location: ../index.php');

	// We're done with our first OOP script!
?>
