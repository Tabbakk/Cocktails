<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if (!isset($_SESSION['id'])){header("location:includes/user_logout.php");exit();}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/Bootstrap.css" rel="stylesheet">
		<link href="css/general.css" rel="stylesheet">
		<title>Cocktailulator</title>
	</head>
	<body>
		<div class="container main">
			<img class="mainIMG img-fluid" src="imgs/main.jpg" >
			<div class="row">
				<div class="col-12">
					<div class="col-sm-3 col-3"></div>
					<button class="btn btn-lg btn-custom1 col-sm-3 col-6" type="button" onclick="">Create New</button>
					<div class="d-sm-none col-3"></div>
		
					<div class="d-sm-none col-3"></div>
					<button class="btn btn-lg btn-custom1 col-sm-3 col-6" type="button" onclick="">View Recipes</button>
					<div class="col-sm-3 col-3"></div>

					<div class="col-md-5 col-3"></div>
					<button class="btn btn-lg btn-custom2 col-md-2 col-6" type="button" onclick="document.location.href='main.php'">Back</button>
					<div class="col-md-5 col-3"></div>					
				</div>

			</div>	
		</div> <!-- /container -->
		
		<script src="js/jQuery.js"></script>
		<script src="js/popper.js"></script>
		<script src="js/Bootstrap.js"></script>
	</body>
  
	<footer>
	</footer>

</html> 
