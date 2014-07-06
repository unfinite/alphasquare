<?php

class ZeamMySQLi {

	$this->db = $db;
	$this->host = $host;
	$this->user = $user;
	$this->password = $password;
	$this->logging = $logging;


	function __construct($db, $host, $user, $password) {

		global $mysqli;

		$mysqli = new mysqli($this->host, $this->user, $this->password, $this->db);

		if ($mysqli->connect_errno) {
    			Zeam::log('Could not establish a connection with the database. Please check your variables. For detailed information, refer to PHP error reporting.');
    		}
    		else {
    			Zeam::log('Connection established.');
	 	}

	}

}