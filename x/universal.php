<?php 
session_start();
/*

AX-3847


Alphasquare X
Security Protocol Experiment
&
My idiotic attempt into OOP (Object-Oriented programming)


*/


class User
{
	var $username = "No value set. Type anything in the box and it'll create a notification!";

	function set_username($var) 
	{
		$this->username = $var;
		$_SESSION['username'] = $this->username;
	}
	function get_username()
	{	
		if (isset($_SESSION['username'])) {
		echo $_SESSION['username'];
		} else {
			echo 'No value set.';
		}
	}
}

class SessionManage {

	function __construct($action) {
		if ($action = "unset") {
			session_destroy();
		}
		if ($action = "create") {
			session_start();
		}
	}
}
?>