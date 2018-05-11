<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if (!isset($_SESSION['id'])){header("location:user_logout.php");exit();}

	include 'db_connection.php';

	$sql = "Select id, name, ml, cost from bottles where user_id = ?";
	
	if($stmt = $mysqli->prepare($sql)){
		$stmt->bind_param('i', $_SESSION['id']);
		$stmt->execute();    // Execute the prepared query.
		if ($stmt->error != ""){
			
			//ERROR WITH STMT
			
		}
		
		$stmt->bind_result($id, $name, $ml, $price);
		$i = 0;
		$bottles = array();
		while($stmt->fetch()){
			$bottles[$i]['id']=$id;
			$bottles[$i]['name']=$name;
			$bottles[$i]['ml']=$ml;
			$bottles[$i]['price']=$price;
			$i++;
		}
		$stmt->close();
	}
	$mysqli->close();
	
	$amount = $i
?>