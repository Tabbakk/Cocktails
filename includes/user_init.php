<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if(!isset($id)||!isset($username)||!isset($email)){header("location:user_logout.php");exit();}
	$_SESSION['id'] = $id;
	$_SESSION['username'] = $username;
	$_SESSION['email'] = $email;
	$_SESSION['authorized'] = true;
	unset($_SESSION['login_u'],$_SESSION['login_p']);

	echo '<script language=javascript>document.location.href="../main.php"</script>';