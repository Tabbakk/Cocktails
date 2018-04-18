<?php
	# DBMS connection
	// creating MySQLi object
	$mysqli = new mysqli("localhost", "root", "", "cocktails");

	// verifica su eventuali errori di connessione
	if ($mysqli->connect_errno) {
		echo "Connessione fallita: ". $mysqli->connect_error . ".";
		exit();
	}
	
	// $mysqli->close();
?>