<?php
	include "db_init.php";
	
	# DBMS connection
	// creating MySQLi object
	$mysqli = new mysqli($db["host"], $db["user"], $db["password"], $db["name"]);

	// verifica su eventuali errori di connessione
	if ($mysqli->connect_errno) {
		echo "Connessione fallita: ". $mysqli->connect_error . ".";
		exit();
	}

	
/*	
	$sql = 'Select id, username, password, email from users where id = 1';
	$select = $mysqli->query($sql);
	if(mysqli_num_rows($select)==1) {
		$res = $select->fetch_assoc();
		echo $res['username'].": ".$res['email'];
	}
//*/

/*	
	$sql = 'Select id, username, password, email from users where id = ?';
	$stmt = $mysqli->prepare($sql);
		$i = 1; //value to bind to id, in form of a variable (necessary)
		$stmt->bind_param('i', $i);  // Bind $i (=1) to id
		$stmt->execute();    // Execute the prepared query.
		$stmt->store_result();
		$stmt->bind_result($id, $username, $db_password, $email);
		$stmt->fetch();
	 if ($stmt->num_rows == 1) {
		echo $username.": ".$email;
	}	 
//*/

//	$mysqli->close();
