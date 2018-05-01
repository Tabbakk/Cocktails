<?php
	include 'db_connection.php';
	
	$username = $mysqli->real_escape_string($_POST['username']);
	$password = $mysqli->real_escape_string($_POST['password']);
	
	$sql = 'Select id, username, password, email from users where username = ?';
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('s', $username);  // Bind $username to ?
	$stmt->execute();    // Execute the prepared query.
	$stmt->store_result();
	$stmt->bind_result($id, $username, $db_hash, $email);
	$stmt->fetch();
	if ($stmt->num_rows == 1) {
		// Verify stored hash against plain-text password
		if (password_verify($password, $db_hash)) {
			// Check if a newer hashing algorithm is available
			if (password_needs_rehash($db_hash, PASSWORD_DEFAULT)) {
				// If so, create a new hash, and save to DB
				$newHash = password_hash($password, PASSWORD_DEFAULT);
				$sql = "update users set password = ? where id = ?";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('si', $newHash, $id);  // Bind $username to ?
				$stmt->execute();    // Execute the prepared query.
			}
			$mysqli->close();
			include 'user_init.php';
		}
		else {
			$mysqli->close();
			echo '<script language=javascript>document.location.href="../index.php?p"</script>'; // wrong password
		}			
	}
	else {
		$mysqli->close();
		echo '<script language=javascript>document.location.href="../index.php?u"</script>'; //user doesn't exist
	}


?>