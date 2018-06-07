<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if(isset($_POST['ids'])){
		include 'includes/db_connection.php';
		$userIDs = $_POST['ids'];
		$first=true;
		$ids="";
		foreach ($userIDs as $id){
			if($first){
				$ids=$ids.$id;
				$first=false;
			}
			else{
				$ids=$ids.",".$id;
			}
		}
		
		$auth=$_POST['actionType'];
			
		$sql = "update users set auth = ".$auth." where id in (".$ids.")";

		if($mysqli->query($sql)){
			$message = "Operation Successful";
		}
		else {
			$message = "Operation Failed";
		}

	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/Bootstrap.css" rel="stylesheet">
		<link href="css/general.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Admin</title>
		<script>
			function submitForm(n){
				document.getElementById('actionType').value=n;
				document.getElementById('activeUsers').submit();
			}
			window.onload = function(){
			<?php
				if(isset($_POST['ids'])){
			?>
				window.alert("<?php echo $message; ?>");
			<?php
				}
			?>
			}
		</script>
	</head>
	<body>
		<div class="container main">
			<div class="row">
				<div class="col-12">
					<h2>Manage activations</h2>
					<div class="row">
					<form class="form col-sm-8 col-12 mx-auto" id="activeUsers" method="post">
						<input type="hidden" id="actionType" name="actionType" value="" />
						<table class="table table-striped text-center">
							<tr>
								<th scope="col"></th>
								<th scope="col">User</th>
								<th scope="col">Active</th>
							</tr>
<?php

	if(!isset($_POST['ids'])){include 'includes/db_connection.php';}

	$sql = "select id, username, auth from users";
	
	$stmt = $mysqli->prepare($sql);
	
	if($stmt = $mysqli->prepare($sql)){
	$stmt->execute();    // Execute the prepared query.
	if ($stmt->error != ""){

	}
	
	$stmt->bind_result($id, $user, $auth);
	while($stmt->fetch()){
?>
							<tr>
								<td><input type="checkbox" value="<?php echo($id); ?>" name="ids[]" \></td>
								<td><?php echo($user); ?></td>
								<td><?php if($auth){echo"X";} ?></td>
							</tr>
<?php
	}
	$stmt->close();
	$mysqli->close();
	}
?>
							</table>
						</form>
						</div>
					</div>
					<div class="col-12 justify-content-center">
					<button class="btn btn-lg btn-custom1" id="editBtn" type="button" onclick="submitForm(1);">Authorize</button>
					<button class="btn btn-lg btn-custom2" type="button" onclick="submitForm(0);">Revoke</button>
					</div>
				</div>
			</div>
		<script src="js/jQuery.js"></script>
		<script src="js/popper.js"></script>
		<script src="js/Bootstrap.js"></script>
	</body>
</html>