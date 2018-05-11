<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if (!isset($_SESSION['id'])||!isset($_POST['bottles'])){header("location:user_logout.php");exit();}

	include 'db_connection.php';

	$bottleIDs = $_POST['bottles'];
	
	$ids="";
	$first=true;
	foreach ($bottleIDs as $b){
		if($first){
			$ids=$ids.$b;
			$first=false;
		}
		else{
			$ids=$ids.",".$b;
		}
	}
	
	$sql = "delete from bottles where id in (".$ids.")";

	if($mysqli->query($sql)){
		$_SESSION['resultMes'] = "Selection was eliminated successfully";
		$_SESSION['insertE']=0;		
	}
	else {
		$_SESSION['resultMes'] = "There was an error: ".$mysqli->error;		
		$_SESSION['insertE']=1;
	}

	$mysqli->close();

	$_SESSION['from'] = 'delete_bottle';
	header("location:../result.php");
	exit();
?>