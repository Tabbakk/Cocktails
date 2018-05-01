<?php
	session_start();
	if (isset($_SESSION['id'])){
		session_unset();
	}
	$_SESSION['id'] = $id;
	$_SESSION['username'] = $username;
	$_SESSION['email'] = $email;
	$_SESSION['authorized'] = true;

	echo '<script language=javascript>document.location.href="../main.php"</script>';