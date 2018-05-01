<?php
	if(!isset($_SESSION)) { session_start(); }
	
?>

<html>
  <head>
    <meta charset="UTF-8">
    <link href="css/Bootstrap.css" rel="stylesheet">
    <link href="css/general.css" rel="stylesheet">
    <title>Cocktailulator</title>
  </head>

  <body>
	<div class="home container-fluid">
		<div class="row">
			<div class="col-sm-3 col-xs-2"></div>
			<div class="col-sm-6 col-xs-8">
				<div class="row">
					<div class="col-sm-2 col-xs-0"></div>
					<img class="mainIMG col-sm-8 col-xs-12" src="imgs/main.jpg" />
					<div class="col-sm-2 col-xs-0"></div>
				</div>
				<div class="row">
					<div class="col-md-2 col-sm-0 col-xs-0"></div>
					<div  id="initial" class="col-md-4 col-sm-6 col-xs-12">
						<button class="btn btn-lg btn-primary" type="button" onclick="">Recipes</button>
					</div>
					<div  id="initial" class="col-md-4 col-sm-6 col-xs-12">
						<button class="btn btn-lg btn-primary" type="button" onclick="">Inventory</button>
					</div>
					<div class="col-md-2 col-sm-0 col-xs-0"></div>
				</div>	
			</div> <!-- /container -->
			<div class="col-sm-3 col-xs-2"></div>
		</div>
	</div>
	<script src="js/jQuery.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/Bootstrap.js"></script>
  </body>
  
  <footer>
  </footer>

</html> 
