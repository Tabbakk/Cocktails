<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if(!isset($_POST['bottle'])||!isset($_POST['price'])||!isset($_POST['size'])){header("location:user_logout.php");exit();}

	include 'db_connection.php';
	
	$id = $_POST['bID'];
	$name = $mysqli->real_escape_string($_POST['bottle']);
	$price = $_POST['price'];
	$size = $_POST['size'];
	
//*	
	if(!is_numeric($size)||!is_numeric($price)||!is_numeric($id)){
		$_SESSION['from'] = 'mod_bottle';
		$_SESSION['resultMes'] = "There was an error with the values inserted: please try again";
		$_SESSION['insertE']=1;
		$mysqli->close();
		header("location:../result.php");
		exit();
	}
	else{		
		settype($id, "integer");
		settype($size, "integer");
		settype($price, "float");
	}
//*/
	
//*	#################### STMT method #########################

	$sql = "Update bottles SET name = ?, ml = ?, cost = ? where id = ?";
	if ($stmt = $mysqli->prepare($sql)) {
		
		$stmt->bind_param('sidi', $name, $size, $price, $id);
		$stmt->execute();    // Execute the prepared query.
		if ($stmt->error != ""){
			$_SESSION['resultMes'] = "An error occured: ".$stmt->error;
			$_SESSION['insertE']=1;
		}
		else {
			$_SESSION['resultMes'] = "Bottle successfully modified!";
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
	
	$_SESSION['from'] = 'mod_bottle';
	header("location:../result.php");
	exit();

?>