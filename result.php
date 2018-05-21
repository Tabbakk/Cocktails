<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if (!isset($_SESSION['id'])){header("location:includes/user_logout.php");exit();}
	
	$from = $_SESSION['from'];
	$err = $_SESSION['insertE'];
	$msg = $_SESSION['resultMes'];
	unset($_SESSION['resultMes'], $_SESSION['insertE'], $_SESSION['from']);
	
	if($from == 'insert_bottle'){
		if($err==0){
			$format="";
			$button1="Add Another";
		}
		if($err==1){
			$format=" text-danger";
			$button1="Try Again";		
		}
		$btn1dest = 'add_bottle.php';
		$btn2dest = 'inventory.php';
		$button2 = 'Inventory';
	}
	
	if($from == 'insert_recipe'){
		if($err==0){
			$format="";
			$button1="Add Another";
		}
		if($err==1){
			$format=" text-danger";
			$button1="Try Again";		
		}
		$btn1dest = 'add_recipe.php';
		$btn2dest = 'recipes.php';
		$button2 = 'Recipes';		
	}
	
	if($from == 'delete_bottle'){
		if($err==0){
			$format="";
		}
		if($err==1){
			$format=" text-danger";
		}
		$button1="Return to List";
		$btn1dest='inventory_list.php';
		$btn2dest = 'inventory.php';
		$button2 = 'Inventory';
	}

	if($from == 'delete_recipe'){
		if($err==0){
			$format="";
		}
		if($err==1){
			$format=" text-danger";
		}
		$button1="Return to List";
		$btn1dest='recipe_list.php';
		$btn2dest = 'recipes.php';
		$button2 = 'Recipes';
	}
	
	if($from == 'inventory_list_empty'){
		$format="";
		$button1="Add Bottle";
		$btn1dest='add_bottle.php';
		$btn2dest = 'inventory.php';
		$button2 = 'Back';
	}
	
	if($from == 'recipe_list_empty'){
		$format="";
		$button1="Add Recipe";
		$btn1dest='add_recipe.php';
		$btn2dest = 'recipes.php';
		$button2 = 'Back';
	}
	
	
	if($from == 'mod_bottle'){
		if($err==0){
			$format="";
		}
		if($err==1){
			$format=" text-danger";
		}
		$button1="Return to List";
		$btn1dest='inventory_list.php';
		$btn2dest = 'inventory.php';
		$button2 = 'Inventory';
	}
	
	
?>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/Bootstrap.css" rel="stylesheet">
		<link href="css/general.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cocktailulator</title>
	</head>
	<body>
		<div class="container main">
			<img class="mainIMG img-fluid" src="imgs/main.jpg" >
			<div class="row">
				<div class="col-12">
					<h2 class="errMessage mt-2 text-center<?php echo $format; ?>" id="noLoginMessage"><?php echo($msg); ?></h2>
					<div class="col-sm-3 col-3"></div>
					<button class="btn btn-lg btn-custom1 col-sm-3 col-6" type="button" onclick="document.location.href='<?php echo $btn1dest; ?>'"><?php echo $button1; ?></button>
					<div class="d-sm-none col-3"></div>
		
					<div class="d-sm-none col-3"></div>
					<button class="btn btn-lg btn-custom2 col-sm-3 col-6" type="button" onclick="document.location.href='<?php echo $btn2dest ?>'"><?php echo $button2; ?></button>
					<div class="col-sm-3 col-3"></div>

			</div>	
		</div> <!-- /container -->
		
		<script src="js/jQuery.js"></script>
		<script src="js/popper.js"></script>
		<script src="js/Bootstrap.js"></script>
	</body>
  
	<footer>
	</footer>

</html> 
