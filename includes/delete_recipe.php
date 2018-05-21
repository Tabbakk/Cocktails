<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if (!isset($_SESSION['id'])||!isset($_POST['RecipeId'])||!is_numeric($_POST['RecipeId'])){header("location:user_logout.php");exit();}
	
	include 'db_connection.php';
	
	$recipeID = $_POST['RecipeId'];

	$sql = "delete from cocktails where id = ".$recipeID;


	if($mysqli->query($sql)){
		$_SESSION['resultMes'] = "Recipe was eliminated successfully";
		$_SESSION['insertE']=0;		
	}
	else {
		$_SESSION['resultMes'] = "There was an error: ".$mysqli->error;		
		$_SESSION['insertE']=1;
	}

	$mysqli->close();

	$_SESSION['from'] = 'delete_recipe';
	header("location:../result.php");
	exit();
	
?>