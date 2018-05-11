<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if (!isset($_SESSION['id'])){header("location:includes/user_logout.php");exit();}
	
	include 'includes/bottle_list.php';
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/Bootstrap.css" rel="stylesheet">
		<link href="css/general.css" rel="stylesheet">
		<title>Cocktailulator</title>
		<script>
			var numBottles = <?php echo $amount; ?>;
			function ShowButton(){
				var cID =  "";
				document.getElementById("editBtn").NameClass="btn btn-lg btn-custom2 col-sm-3 col-6";
				document.getElementById("editBtn").setAttribute("onclick","HideButton();");
				document.getElementById("editBtn").innerHTML="Cancel";
				document.getElementById("DeleteButton").setAttribute("style","display:block;");
				var i;
				for (i = 0; i < numBottles; i++){
					cID = "check"+i;
					document.getElementById(cID).setAttribute("style","visibility:visible;");
				}
			}
			function HideButton(){
				var cID =  "";
				document.getElementById("editBtn").NameClass="btn btn-lg btn-custom1 col-sm-3 col-6";
				document.getElementById("editBtn").setAttribute("onclick","ShowButton();");
				document.getElementById("editBtn").innerHTML="Edit";
				document.getElementById("DeleteButton").setAttribute("style","display:none;");
				var i;
				for (i = 0; i < numBottles; i++){
					cID = "check"+i;
					document.getElementById(cID).setAttribute("style","visibility:hidden;");
				}
			}
			function verifyActive(){				
				var verified = false;
				var cID =  "";
				var i;
				for (i = 0; i < numBottles; i++){
					cID = "check"+i;
					if (document.getElementById(cID).checked) {
						verified = true;
					}
				}
				if(verified==true){
					document.getElementById('deleteBtn').removeAttribute("disabled");;
				}
				else {
					document.getElementById('deleteBtn').setAttribute("disabled","true");
				}
			}
		</script>
	</head>
	<body>
		<div class="container main">
			<div class="row">
				<div class="col-12">
					<h2 class="">Bottles</h2>
					<form class="form deleteBottleForm col-6 mx-auto" id="deleteBottleForm" method="post" action="includes/delete_bottle.php">
						<table class="table table-striped text-center">
							<thead>
								<tr>
								  <th></th>
								  <th scope="col">Bottle</th>
								  <th scope="col" class="table-bordered">Size</th>
								  <th scope="col">Price</th>
								  <th></th>
								</tr>
							</thead>
							<tbody>
					<?php
						$i = 0;
						foreach ($bottles as $b){
					?>		
								<tr>
									<td><input class="form-check-input ml-1" type="checkbox" value="<?php echo $b['id']; ?>" id="check<?php echo $i; ?>" name="bottles[]" style="visibility:hidden;" onclick="verifyActive();" ></td>
									<td class="aligned"><?php echo $b['name']; ?></td>
									<td class="table-bordered aligned"><?php echo $b['ml']; ?>ml</td>
									<td class="aligned">$<?php echo $b['price']; ?></td>
									<td><input class="form-check-input mr-1" type="checkbox" style="visibility:hidden;" ></td>
								</tr>

					<?php
							$i++;
						}
					?>
							</tbody>
						</table>
					</form>
					<div id="DeleteButton" style="display:none;">
					<div class="col-md-5 col-3"></div>
					<button class="btn btn-lg btn-custom2 col-md-2 col-6" id="deleteBtn" type="button" disabled="true" data-toggle="modal" data-target="#confirmDelete" >Delete</button>
					<div class="col-md-5 col-3"></div>					
					</div>
					
					<div class="col-sm-3 col-3"></div>
					<button class="btn btn-lg btn-custom1 col-sm-3 col-6" id="editBtn" type="button" onclick="ShowButton();">Edit</button>
					<div class="d-sm-none col-3"></div>
	
					<div class="d-sm-none col-3"></div>
					<button class="btn btn-lg btn-custom2 col-sm-3 col-6" type="button" onclick="document.location.href='inventory.php'">Back</button>
					<div class="col-sm-3 col-3"></div>
				</div>

			</div>	
		</div> <!-- /container -->
		
		

		<!-- Modal -->
		<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDelete" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-body">
				Are you sure you want to delete the selected bottles?
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-custom2" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-custom1" onclick="document.getElementById('deleteBottleForm').submit();">Delete</button>
			  </div>
			</div>
		  </div>
		</div>
		
		<script src="js/jQuery.js"></script>
		<script src="js/popper.js"></script>
		<script src="js/Bootstrap.js"></script>
	</body>
  
	<footer>
	</footer>

</html> 
