<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if (!isset($_SESSION['id'])){header("location:includes/user_logout.php");exit();}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/Bootstrap.css" rel="stylesheet">
		<link href="css/general.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cocktailulator</title>
		
		<script>
			function evenNumber(i,d) {
				var n, numb;
				if(d==='p'){
					numb = document.getElementById("price");
				}
				else if(d==='s'){
					numb = document.getElementById("size");
				}
				else{return;}
				n = numb.value;
				if(!isNaN(n)){
					numb.value = Number.parseFloat(n).toFixed(i);
				}
				else {
					numb.value = 0;					
				}
			}
		function createMessage(ID1, messageKey){
			document.getElementById(ID1).innerHTML = "Please insert valid "+messageKey;
		}
		function submitForm() {
			var f = document.getElementById('addBottleForm');
			if(f.checkValidity()) {
				f.submit();
			} else {
				if(document.getElementById('bottle').value==""){
					document.getElementById("bottle").className += " is-invalid";
					createMessage("errorName", "name");
				}
				if(document.getElementById('price').value=="" || document.getElementById('price').value<=0){
					document.getElementById("price").className += " is-invalid";
					createMessage("errorPrice", "price");
				}
				if(document.getElementById('size').value=="" || document.getElementById('size').value<=0){
					document.getElementById("size").className += " is-invalid";
					createMessage("errorSize", "size");
					}
			}
		}
		</script>
		
	</head>
	<body>
		<div class="container main">
			<div class="row">
				<div class="col-12" id="addBottle" >
					<h2>Add a bottle</h2>
					<form class="form addBottleForm" id="addBottleForm" method="post" action="includes/insert_bottle.php">
						<div class="row">
						
							<div class="errorMessage text-danger col-12 d-block" id="errorName"></div>							
							<label for="bottle" class="sr-only">Bottle Name</label>
							<div class="input-group col-12">
								<input type="text" id="bottle" name="bottle" class="form-control" placeholder="Name of the bottle" required>
							</div>
							<small id="smbottleName" class="form-text text-muted col-12 d-block">Bottle Name</small>

							<div class="errorMessage text-danger col-12 d-block" id="errorPrice"></div>							
							<label for="price" class="sr-only">Price</label>	
							<div class="input-group col-12">
								<input type="number" name="price" class="form-control currency padded" min="0.01" step="0.01" data-number-stepfactor="100" id="price" placeholder="0.00" onblur="evenNumber(2,'p');" required>
								<div class="input-group-append">
									<span class="input-group-text dollar" id="basic-addon">$</span>
								</div>
							</div>
							<small id="smbottleSize" class="form-text text-muted col-12 d-block">Bottle Price</small>

							<div class="errorMessage text-danger col-12 d-block" id="errorSize"></div>							
							<label for="size" class="sr-only">Size (ml)</label>
							<div class="input-group col-12">
								<input type="number" id="size" name="size" class="form-control padded" placeholder="Size (ml)" min="1" onblur="evenNumber(0,'s');" required>
								<div class="input-group-append">
									<span class="input-group-text ml" id="basic-addon" >ml</span>
								</div>
							</div>
							<small id="smbottleSize" class="form-text text-muted col-12 d-block">Bottle Size (ml)</small>

						</div>
						<input type="submit" style="display:none"/>
					</form>
					<button class="btn btn-lg btn-custom1 col-sm-3 col-6" type="button" onclick="submitForm();">Add</button>
					<button class="btn btn-lg btn-custom2 col-sm-3 col-6" type="button" onclick="document.location.href='includes/erase.php'">Cancel</button>
				</div>

			</div>	
		</div> <!-- /container -->

		<script src="js/jQuery.js"></script>
		<script src="js/popper.js"></script>
		<script src="js/Bootstrap.js"></script>
	</body>
  
	<footer>
		<script>
		document.getElementById("bottle").onchange = function(){
			document.getElementById("bottle").className = "form-control";
			document.getElementById("errorName").innerHTML="";
		}		
		document.getElementById("price").onchange = function(){
			document.getElementById("price").className = "form-control";
			document.getElementById("errorPrice").innerHTML="";
		}		
		document.getElementById("size").onchange = function(){
			document.getElementById("size").className = "form-control";
			document.getElementById("errorSize").innerHTML="";
		}		
		</script>
	</footer>

</html> 
