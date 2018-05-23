<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if (!isset($_SESSION['id'])){header("location:includes/user_logout.php");exit();}
	
	include 'includes/bottle_list.php';
	
	if ($amount == 0){
			$_SESSION['from'] = "inventory_list_empty";
			$_SESSION['insertE'] = 0;
			$_SESSION['resultMes'] = "There are currently no bottles in your inventory";
			header("location:result.php");exit();
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/Bootstrap.css" rel="stylesheet">
		<link href="css/general.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cocktailulator</title>
		<script>
			var numBottles = <?php echo $amount; ?>;
			function check(checkID) {
						if(document.getElementById(checkID).checked){document.getElementById(checkID).checked=false;}
						else{document.getElementById(checkID).checked=true;}
			}
			
			function ShowButton(){
				verifyActive();
				var cID, nameID;
				document.getElementById("ModButtons").setAttribute("style","display:block;");
				document.getElementById("CancelButtons").setAttribute("style","display:block;");
				document.getElementById("MainButtons").setAttribute("style","display:none;");
				var i;
				for (i = 0; i < numBottles; i++){
					cID = "check"+i;
					nameID = "name"+i;
					document.getElementById(cID).setAttribute("style","visibility:visible;");
					document.getElementById(nameID).setAttribute("onclick","check('"+cID+"');verifyActive();");
				}
			}
			function HideButton(){
				var cID, nameID;
				document.getElementById("ModButtons").setAttribute("style","display:none;");
				document.getElementById("CancelButtons").setAttribute("style","display:none;");
				document.getElementById("MainButtons").setAttribute("style","display:block;");
				var i;
				for (i = 0; i < numBottles; i++){
					cID = "check"+i;
					nameID = "name"+i;
					if(document.getElementById(cID).checked){document.getElementById(cID).checked=false;}
					document.getElementById(cID).setAttribute("style","visibility:hidden;");
					document.getElementById(nameID).setAttribute("onclick","check("+cID+");verifyActive();");
				}
			}
			function verifyActive(){				
				var verified = false;
				var cID =  "";
				var i;
				var count = 0;
				for (i = 0; i < numBottles; i++){
					cID = "check"+i;
					if (document.getElementById(cID).checked) {
						verified = true;
						count++;
					}
				}
				if(verified==true){
					document.getElementById('deleteBtn').removeAttribute("disabled");
				}
				else {
					document.getElementById('deleteBtn').setAttribute("disabled","true");
				}
				if(count==1){
					document.getElementById('modBtn').removeAttribute("disabled");
				}
				else {
					document.getElementById('modBtn').setAttribute("disabled","true");
				}
			}
			window.onload = function(){
				var i;
				var mytable = document.getElementById('bottlesList');
				var myrows = mytable.getElementsByTagName("tr");
				var lastrow = myrows[myrows.length -1];
				var bottomcells = lastrow.getElementsByTagName("td");
				for (i = 0; i < bottomcells.length; i++) {
					bottomcells[i].className += " border-bottom";
				}
				$('#modModal').on('hide.bs.modal', function (e) {
					document.getElementById("bottle").className = "form-control";
					document.getElementById("errorName").innerHTML="";
					document.getElementById("size").className = "form-control";
					document.getElementById("errorSize").innerHTML="";
					document.getElementById("price").className = "form-control";
					document.getElementById("errorPrice").innerHTML="";
				})
			}
			
			function populateModModal() {
				var i=0;
				var cID = "check"+i;
				while(!document.getElementById(cID).checked) {
					i++;
					cID = "check"+i;
				}
				nID = "name"+i;
				pID = "price"+i;
				sID = "size"+i;
				document.getElementById('bID').value = document.getElementById(cID).value;
				document.getElementById('bottle').value = document.getElementById(nID).innerHTML;
				document.getElementById('price').value = document.getElementById(pID).innerHTML.replace('$ ','');
				document.getElementById('size').value = document.getElementById(sID).innerHTML.replace(' ml','');
			}
			
			function populateDelModal(){
				var ul = document.getElementById("delModalList");
				var li;
				for (var i=0; i < numBottles; i++){
					if(document.getElementById("check"+i).checked){
						li = document.createElement("li");
						small = document.createElement("small");
						small.className="text-muted smallList";
						small.appendChild(document.createTextNode(document.getElementById("name"+i).innerHTML));
						li.appendChild(small);
						ul.appendChild(li);
					}
				}
			}
			
			
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
				var f = document.getElementById('modBottleForm');
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
				<div class="col-12">
					<h2>Bottles</h2>
			<div class="row">
					<form class="form deleteBottleForm col-sm-8 col-12 mx-auto" id="deleteBottleForm" method="post" action="includes/delete_bottle.php">
						<table class="table table-striped text-center" id="bottlesList">
							<thead>
								<tr>
								  <th></th>
								  <th scope="col">Bottle</th>
								  <th scope="col" class="table-bordered">Size (ml)</th>
								  <th scope="col">Price</th>
								</tr>
							</thead>
							<tbody>
					<?php
						$i = 0;
						foreach ($bottles as $b){
					?>		
								<tr>
									<td id="td<?php echo $i; ?>"><input style="visibility:hidden;" class="form-check-input ml-1" type="checkbox" value="<?php echo $b['id']; ?>" id="check<?php echo $i; ?>" name="bottles[]" onclick="verifyActive();" ></td>
									<td class="aligned" id="name<?php echo $i ?>" ><?php echo stripslashes($b['name']); ?></td>
									<td class="table-bordered aligned" id="size<?php echo $i ?>" ><?php echo $b['ml']; ?></td>
									<td class="aligned" id="price<?php echo $i ?>"><?php echo $b['price']; ?></td>
								</tr>

					<?php
							$i++;
						}
					?>
							</tbody>
						</table>
					</form>
					</div>
					<div id="ModButtons" style="display:none;">
						<div class="col-sm-3 col-3"></div>
						<button class="btn btn-lg btn-custom1 col-sm-3 col-6" id="modBtn" type="button" disabled="true" data-toggle="modal" data-target="#modModal" onclick="populateModModal();" >Modify</button>
						<div class="d-sm-none col-3"></div>
						<div class="d-sm-none col-3"></div>
						<button class="btn btn-lg btn-custom1 col-sm-3 col-6" id="deleteBtn" type="button" disabled="true" data-toggle="modal" data-target="#confirmDelete" onclick="populateDelModal();" >Delete</button>
						<div class="col-sm-3 col-3"></div>
					</div>

					<div id="MainButtons">
						<div class="col-sm-3 col-3"></div>
						<button class="btn btn-lg btn-custom1 col-sm-3 col-6" id="editBtn" type="button" onclick="ShowButton();">Edit</button>
						<div class="d-sm-none col-3"></div>
		
						<div class="d-sm-none col-3"></div>
						<button class="btn btn-lg btn-custom2 col-sm-3 col-6" type="button" onclick="document.location.href='inventory.php'">Back</button>
						<div class="col-sm-3 col-3"></div>
					</div>

					<div id="CancelButtons" style="display:none;">
						<div class="col-3"></div>
						<button class="btn btn-lg btn-custom2 col-6" id="cancelBtn" type="button" onclick="HideButton();" >Cancel</button>
						<div class="col-3"></div>					
					</div>
				</div>

			</div>	
		</div> <!-- /container -->
		
		

		<!-- Delete Modal -->
		<div class="modal fade delModal noselect" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDelete" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-body">
				Are you sure you want to delete the following bottles?
				<ul id="delModalList" class="delModalList">
				</ul>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-lg btn-custom2" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-lg btn-custom1" onclick="document.getElementById('deleteBottleForm').submit();">Delete</button>
			  </div>
			</div>
		  </div>
		</div>

		<!-- Mod Modal -->
		<div class="modal fade modModal noselect" id="modModal" tabindex="-1" role="dialog" aria-labelledby="modModal" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" >Modify Bottle</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div id="modBottle" >
								<form class="form modBottleForm" id="modBottleForm" method="post" action="includes/mod_bottle.php">
									<div class="row">
										
										<input type="hidden" id="bID" name="bID" value="">

										<div class="col-4"></div>
										<div class="errorMessage text-danger col-8 d-block text-center" id="errorName"></div>							
										<label for="bottle" class="sr-only">Bottle Name</label>
										<div class="col-12 mb-3">
											<div class="row">
												<div class="col-4 d-inline text-center">
													<small id="smbottleName" class="form-text text-muted my-2">Name</small>
												</div>
												<div class="col-8 d-inline">
													<div class="input-group">
														<input type="text" id="bottle" name="bottle" class="form-control" placeholder="Name of the bottle" required>
													</div>
												</div>
											</div>
										</div>

										<div class="col-4"></div>
										<div class="errorMessage text-danger col-8 d-block text-center" id="errorPrice"></div>							
										<label for="price" class="sr-only">Price</label>
										<div class="col-12 mb-3">
											<div class="row">
												<div class="col-4 d-inline text-center">
													<small id="smbottleSize" class="form-text text-muted my-2">Price</small>
												</div>
												<div class="col-8 d-inline">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text dollar" id="basic-addon">$</span>
														</div>
														<input type="number" name="price" class="form-control currency" min="0.01" step="0.01" data-number-stepfactor="100" id="price" placeholder="0.00" onblur="evenNumber(2,'p');" required>
													</div>
												</div>
											</div>
										</div>

										<div class="col-4"></div>
										<div class="errorMessage text-danger col-8 d-block text-center" id="errorSize"></div>							
										<label for="size" class="sr-only">Size (ml)</label>
										<div class="col-12 mb-3">
											<div class="row">
												<div class="col-4 d-inline text-center">
													<small id="smbottlePrice" class="form-text text-muted my-2">Size</small>
												</div>
												<div class="col-8 d-inline">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text ml" id="basic-addon">ml</span>
														</div>
														<input type="number" id="size" name="size" class="form-control" placeholder="Size (ml)" min="1" onblur="evenNumber(0,'s');" required>
													</div>
												</div>
											</div>
										</div>

									</div>
									<input type="submit" style="display:none"/>
								</form>
							</div>
						</div>
					</div>
					<div class="modal-footer">
							<button class="btn btn-lg btn-custom2" type="button" data-dismiss="modal">Cancel</button>
							<button class="btn btn-lg btn-custom1" type="button" onclick="submitForm();">Modify</button>
					</div>
				</div>
			</div>
		</div>
		
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
