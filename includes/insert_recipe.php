<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if(!isset($_POST)){header("location:user_logout.php");exit();}


	$reps = $_POST['numIngredients'];
	
	if(!is_numeric($reps)){
		$_SESSION['resultMes'] = "There was an error with the operation: please try again (num reps)";
		$_SESSION['insertE']=1;
		header("location:../result.php");
		exit();
	}	
	
	$endValues = array();
	
	for($i=0;$i<$reps;$i++){
		$index = 'bottle'.strval($i+1);
		$ingr = json_decode($_POST[$index]);

		if (json_last_error() === JSON_ERROR_NONE) {
			$index = 'amount'.strval($i+1);
			$amount = $_POST[$index];
			if(!is_numeric($amount)){
				$_SESSION['resultMes'] = "There was an error with the operation: invalid amount";
				$_SESSION['insertE']=1;
				header("location:../result.php");
				exit();
			}
			$endValues[$i] = ",".$ingr->{'id'}.",".$amount.")";
			
		} else {
			$_SESSION['resultMes'] = "There was an error with the operation: invalid JSON format";
			$_SESSION['insertE']=1;
			header("location:../result.php");
			exit();
		} 		

	}
	

	include 'db_connection.php';

	$mysqli->autocommit(FALSE);
		
	$recipeName = $mysqli->real_escape_string($_POST['recipe']);
	
	$sql = "insert into cocktails (user_id, name) values (".$_SESSION['id'].",'".$recipeName."')";
	
	if(!($mysqli->query($sql))) {
		$mysqli->rollback();
		$mysqli->close();
		$_SESSION['resultMes'] = "There was an error with the operation: please try again (cocktail insert)";
		$_SESSION['insertE']=1;
		$_SESSION['from'] = 'insert_recipe';
		header("location:../result.php");
		exit();
	}
		
	$sql = "select id from cocktails where name='".$recipeName."' limit 1";
	$res = $mysqli->query($sql);
	$resID = mysqli_fetch_object($res);
	$id = $resID->id;
	
	if(is_numeric($id)){
		$all_query_ok = true;	
		for($i=0;$i<$reps;$i++){
			$sql = "insert into recipes (cocktail_id, bottle_id, ml) values (".$id.$endValues[$i];
			$mysqli->query($sql) ? null : $all_query_ok=false;
		}
		if($all_query_ok){
			$mysqli->commit();
			$mysqli->close();
			$_SESSION['resultMes'] = "Recipe successfully inserted";
			$_SESSION['insertE']=0;
			$_SESSION['from'] = 'insert_recipe';	
			header("location:../result.php");
			exit();
		}
		else{
			$mysqli->rollback();
			$mysqli->close();
			$_SESSION['resultMes'] = "There was an error with the operation: please try again (recipe insert)";
			$_SESSION['insertE']=1;
			$_SESSION['from'] = 'insert_recipe';
			header("location:../result.php");
			exit();		
		}
	}
	else {
		$mysqli->rollback();
		$mysqli->close();
		$_SESSION['resultMes'] = "There was an error with the operation: please try again (non numeric id)";
		$_SESSION['insertE']=1;
		$_SESSION['from'] = 'insert_recipe';
		header("location:../result.php");
		exit();
	}	

?>