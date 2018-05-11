<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if(!isset($_POST['username'])||!isset($_POST['password'])){header("location:user_logout.php");exit();}
	
	include 'db_connection.php';	
	
	$_SESSION['login_u'] = $_POST['username'];
	$_SESSION['login_p'] = $_POST['password'];
	
	$username = $mysqli->real_escape_string($_POST['username']);
	$password = $mysqli->real_escape_string($_POST['password']);
	
	$sql = 'Select id, username, password, email, auth from users where username = ?';
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('s', $username);  // Bind $username to ?
	$stmt->execute();    // Execute the prepared query.
	$stmt->store_result();
	$stmt->bind_result($id, $username, $db_hash, $email, $auth);
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
			if($auth) {include 'user_init.php';} //successful login
			else{
			$_SESSION['login_e']='auth';
			echo '<script language=javascript>document.location.href="../index.php"</script>'; // wrong password
			}
		}
		else {
			$mysqli->close();
			$_SESSION['login_e']='pass';
			echo '<script language=javascript>document.location.href="../index.php"</script>'; // wrong password
		}			
	}
	else {
		$mysqli->close();
		$_SESSION['login_e']='user';
		echo '<script language=javascript>document.location.href="../index.php"</script>'; //user doesn't exist
	}


?>