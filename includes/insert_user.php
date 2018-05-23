<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if(!isset($_POST['username'])||!isset($_POST['password'])||!isset($_POST['email'])){header("location:user_logout.php");exit();}

	$_SESSION['register_u'] = $_POST['username'];
	$_SESSION['register_p'] = $_POST['password'];
	$_SESSION['register_m'] = $_POST['email'];
	
	include 'db_connection.php';	
	
	$username = $mysqli->real_escape_string($_POST['username']);
	$username = strtolower($username);
	$password = $mysqli->real_escape_string($_POST['password']);
	$email = $mysqli->real_escape_string($_POST['email']);
	$email = strtolower($email);
	
	$ok = true;

	$sql = "select id from users where username = '".$username."' limit 1";


	if ($result = $mysqli->query($sql)){
		if($result->num_rows!=0){
			$_SESSION['register_ue'] = "Username already exists";
			$ok = false;
		}
	}
	else{
	}

	$sql = "select id from users where email = '".$email."' limit 1";
	
	if ($result = $mysqli->query($sql)){
		if($result->num_rows!=0){
			$_SESSION['register_me'] = "Email already used";
			$ok = false;
		}
	}
	else{
	}
	
	if(!$ok){
		$mysqli->close();
		header("location:../new_user.php");
		exit();
	}
	
	
	$sql = "insert into users (username, password, email) values (?,?,?)";
	
	$password = password_hash($password, PASSWORD_DEFAULT);

	if ($stmt = $mysqli->prepare($sql)) {
		
		$stmt->bind_param('sss', $username, $password, $email);
		$stmt->execute();    // Execute the prepared query.
		if ($stmt->error != ""){
			$_SESSION['resultMes'] = "An error occured: ".$stmt->error;
			$_SESSION['insertE']=1;
		}
		else {
			$_SESSION['resultMes'] = "User successfully inserted!";
			$_SESSION['insertE']=0;
		}
		$stmt->close();
	}
	else {
		$_SESSION['resultMes'] = "An error occured: please try again";
		$_SESSION['insertE']=1;
	}
		
	$mysqli->close();
	
	$_SESSION['from'] = 'insert_user';
	header("location:../result.php");
	exit();	
?>