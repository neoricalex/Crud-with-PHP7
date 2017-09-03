<?php
	$host = "localhost";
	$user = "root";
	$pass = null;
	$bd = "crud";

	$mysqli = new mysqli($host, $user, $pass, $bd);

	if($mysqli->connect_errno){
		echo "Erro: Não foi possível se conectar ao banco de dados</br>";
		echo "Codigo: (".$mysqli->connect_errno.").</br>";
		echo "Descrição: ".$mysqli->connect_error.".</br>";
	}
?>