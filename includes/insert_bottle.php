<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if(!isset($_POST['bottle'])||!isset($_POST['price'])||!isset($_POST['size'])){header("location:user_logout.php");exit();}

	include 'db_connection.php';
	
	$name = $mysqli->real_escape_string($_POST['bottle']);
	$price = $_POST['price'];
	$size = $_POST['size'];
	
//*	
	if(!is_numeric($size)||!is_numeric($price)){
		$_SESSION['resultMes'] = "There was an error with the values inserted: please try again";
		$_SESSION['insertE']=1;
		$mysqli->close();
		header("location:../result.php");
		exit();
	}
	else{
		settype($size, "integer");
		settype($price, "float");
	}
//*/
	
//*	#################### STMT method #########################
	
	$sql = "Insert into bottles (user_id, name, ml, cost) values (?,?,?,?)";
	if ($stmt = $mysqli->prepare($sql)) {
		
		$stmt->bind_param('isid', $_SESSION['id'], $name, $size, $price);
		$stmt->execute();    // Execute the prepared query.
		if ($stmt->error != ""){
			$_SESSION['resultMes'] = "An error occured: ".$stmt->error;
			$_SESSION['insertE']=1;
		}
		else {
			$_SESSION['resultMes'] = "Bottle successfully inserted!";
			$_SESSION['insertE']=0;
		}
		$stmt->close();
	}
	else {
			$_SESSION['resultMes'] = "An error occured: please try again";
			$_SESSION['insertE']=1;
	}
//*/


/*	#################### query method #########################

	if($mysqli->query("Insert into bottles (user_id, name, ml, cost) values (".$_SESSION['id'].",'".$name."',".$size.",".$price.")")){
			$_SESSION['resultMes'] = "Bottle successfully inserted!";				
	}
	else {
		$asd = $mysqli->error;
		$_SESSION['resultMes'] = "There was an error: ".$asd;		
	}
//*/

	$mysqli->close();
	
	$_SESSION['from'] = 'insert_bottle';
	header("location:../result.php");
	exit();

?>