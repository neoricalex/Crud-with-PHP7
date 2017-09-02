<?php

	$host = "localhost";
	$user = "root";
	$pass = null;
	$bd = "crud";

	$mysqli = new mysqli($host, $user, $pass, $bd);

	if($mysqli->connect_errno){
		echo "Error: Unable to connect to database.</br>";
		echo "Connect error code: (".$mysqli->connect_errno.").</br>";
		echo "Description: ".$mysqli->connect_error.".</br>";
	}
?>