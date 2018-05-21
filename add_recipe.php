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
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script>
			var counter = 0;
			
			function setChildNodes(newFields) {
				var newField;
				if(newFields.hasChildNodes()){
					var newField = newFields.childNodes;
					for (var i=0;i<newField.length;i++){
						setChildNodes(newField[i]);
					}					
				}
				newField = newFields.childNodes;
				var theName, theID;
				for (var i=0;i<newField.length;i++) {
					theName = newField[i].name;
					if (theName){
						newField[i].name = theName + counter;
					}
					theID = newField[i].id;
					if (theID){
						newField[i].id = theID + counter;
					}
				}
			}
			
			function moreFields() {
				var node;
				counter++;
				var errorAmount = "errorAmount"+counter;
				var errorBottle = "errorBottle"+counter;
				var amount = "amount"+counter;
				var bottle = "bottle"+counter;
				document.getElementById('ingredientNum').innerHTML = counter+": ";
				var newFields = document.getElementById('template').cloneNode(true);
				newFields.id = 'ingredient'+counter;
				newFields.style.display = 'block';
				if(counter%2==0){
					newFields.className +=  " bg-light";
				}
				if(newFields.hasChildNodes()){				
					var newField = newFields.childNodes;
					for (var i=0;i<newField.length;i++){
						setChildNodes(newField[i]);
					}					
				}
				var insertHere = document.getElementById('targetZone');
				insertHere.parentNode.insertBefore(newFields,insertHere);

				document.getElementById(amount).addEventListener("focus", function(event){
					node = document.getElementById(amount);
					node.classList.remove("is-invalid");
					document.getElementById(errorAmount).innerHTML="";
				});
				document.getElementById(bottle).addEventListener("focus", function(event){
					node = document.getElementById(bottle);
					node.classList.remove("is-invalid");
					document.getElementById(errorBottle).innerHTML="";
				});
				
				if (counter > 1) {
					document.getElementById('removeField').disabled = false;
				}
			}

			function remF() {
			  var elem = document.getElementById('ingredient'+counter);
			  elem.parentNode.removeChild(elem);
			  counter--;
			  if (counter < 2) {
				document.getElementById('removeField').disabled = true;
			  }	
			}			
			
			
			
			
			
			function evenNumber(i) {
					var n;
					n = this.value;
					if(!isNaN(n)){
						this.value = Number.parseFloat(n).toFixed(i);
					}
					else {
						this.value = 0;					
					}
				}
			function createMessage(messageKey){
				this.innerHTML = "Invalid "+messageKey;
			}
			
			function populateModal(){
				var obj, json, cost, ul, li, amount,name;
				cost = 0;
				document.getElementById("phrase").appendChild(document.createTextNode("Create the recipe '"+document.getElementById("recipe").value+"'?"));
				ul = document.getElementById("recipeModalList")
				for(var i=1; i<=counter; i++){
					amount = document.getElementById('amount'+i).value;
					json = document.getElementById("bottle"+i).value;
					name = document.getElementById("bottle"+i);
					obj = JSON && JSON.parse(json) || $.parseJSON(json);
					cost = cost + (obj.price/obj.ml)*amount;

					li = document.createElement("li");
					small = document.createElement("small");
					small.className="text-muted smallList";
					small.appendChild(document.createTextNode("- "+amount+"ml of "+name.options[name.selectedIndex].text));
					if( i < counter){small.appendChild(document.createTextNode(","));}
					li.appendChild(small);
					ul.appendChild(li);
					
				}
				
				document.getElementById("recipeCost").innerHTML = Number.parseFloat(cost).toFixed(2);
			}
			
			function emptyModal(){
				document.getElementById("phrase").innerHTML="";
				document.getElementById("recipeCost").innerHTML="";
				while(document.getElementById("recipeModalList").lastChild){
					document.getElementById("recipeModalList").removeChild(document.getElementById("recipeModalList").lastChild);
				}
			}
			
			function showModal(event) {
				event.preventDefault();
				document.getElementById('numIngredients').value = counter;
				var f = document.getElementById('addRecipeForm');
				if(f.checkValidity()) {
					populateModal();
					$('#confirmRecipe').modal();
				} 
				else {
					var nameNode = document.getElementById('recipe');
					if(nameNode.value==""){
						nameNode.classList.add("is-invalid");
						createMessage.call(document.getElementById('errorName'), "recipe name");
					}
					var bottleNode, amountNode;
					for	(var i=1; i<=counter; i++){
						bottleNode = document.getElementById('bottle'+i);
						if (bottleNode.value == "") {
							bottleNode.classList.add("is-invalid");
							createMessage.call(document.getElementById('errorBottle'+i), "bottle name");
						}
						amountNode = document.getElementById('amount'+i);
						if (amountNode.value == "") {
							amountNode.classList.add("is-invalid");
							createMessage.call(document.getElementById('errorAmount'+i), "amount");
						}
					}
				}
			}

			function submitForm() {
				document.getElementById('numIngredients').value = counter;
				var f = document.getElementById('addRecipeForm');
				$('#confirmRecipe').modal("hide");
				if(f.checkValidity()) {
					f.submit();
				} 
				else {
					var nameNode = document.getElementById('recipe');
					if(nameNode.value==""){
						nameNode.classList.add("is-invalid");
						createMessage.call(document.getElementById('errorName'), "recipe name");
					}
					var bottleNode, amountNode;
					for	(var i=1; i<=counter; i++){
						bottleNode = document.getElementById('bottle'+i);
						if (bottleNode.value == "") {
							bottleNode.classList.add("is-invalid");
							createMessage.call(document.getElementById('errorBottle'+i), "bottle name");
						}
						amountNode = document.getElementById('amount'+i);
						if (amountNode.value == "") {
							amountNode.classList.add("is-invalid");
							createMessage.call(document.getElementById('errorAmount'+i), "amount");
						}
					}
				}
			}
			
			window.onload = function() {
				moreFields();
				document.getElementById("recipe").addEventListener("focus", function(event){
					var node = document.getElementById("recipe");
					node.classList.remove("is-invalid");
					document.getElementById("errorName").innerHTML="";
				});
				$('#confirmRecipe').on('hide.bs.modal', function (e) {
					emptyModal();
				});
			}
			
		</script>
		<title>Cocktailulator</title>
	</head>
	
	
	<body>

		<div ID="template" style="display: none" class="col-12 border-top border-bottom">		
		<div class="row">
			<div id="ingredientNum" class="col-sm-2 col-1 d-flex align-items-center justify-content-end"></div>
			<div class="col-sm-8 col-10">
				<div class="row">
					<div class="d-flex flex-row justify-content-sm-end justify-content-center col-12 col-sm-6">
						<div style="width:320px; padding:0 20px;">
							<div class="d-flex flex-row justify-content-center">
								<div class="errorMessage text-danger mt-3" id="errorBottle"></div>
							</div>
							<div class="d-flex flex-row justify-content-center">
								<label for="bottle" class="sr-only">Ingredient</label>	
								<div class="input-group">
									<select class="form-control" name="bottle" id="bottle" required>
										<option value="" disabled selected>Select ingredient</option>
									<?php
										foreach ($bottles as $b){
											$name = str_replace("'"," ",stripslashes($b['name']));
											$name = str_replace('"',' ',$name);
											$json = '{"id":"'.$b['id'].'","name":"'.$name.'","ml":"'.$b['ml'].'","price":"'.$b['price'].'"}';
									?>
										<option value='<?php echo($json); ?>'><?php echo(stripslashes($b['name'])); ?></option>
									<?php
										}
									?>
									</select>
								</div>
							</div>
							<div class="d-flex flex-row justify-content-center">
								<small class="form-text text-muted recipeBottle">Bottle</small>					
							</div>
						</div>
					</div>
					<div class="d-flex flex-row justify-content-sm-start justify-content-center col-12 col-sm-6">
						<div style="width:320px; padding:0 20px;">
							<div class="d-flex flex-row justify-content-center">
								<div class="errorMessage text-danger mt-3" id="errorAmount"></div>							
							</div>
							<div class="d-flex flex-row justify-content-center">
								<label for="amount" class="sr-only">Amount (ml)</label>
								<div class="input-group">
									<input type="number" id="amount" name="amount" class="form-control" placeholder="Amount" min="1" onblur="evenNumber.call(this,0);" required>
									<div class="input-group-append">
										<span class="input-group-text" id="basic-addon">ml</span>
									</div>
								</div>
							</div>
							<div class="d-flex flex-row justify-content-center">
								<small class="form-text text-muted recipeAmount">Amount</small>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-2 col-1"></div>
		</div>
	</div>



		<div class="container main">
			<div class="d-flex flex-row justify-content-center">
				<h2>Add Recipe</h2>
			</div>
			<form class="form addRecipeForm" id="addRecipeForm" method="post" action="includes/insert_recipe.php">
				<div class="row">
					<div class="col-1 d-sm-none"></div>
					<div class="col-sm-12 col-10">
						<div class="d-flex flex-row justify-content-center">
							<div class="errorMessage text-danger mt-3" id="errorName"></div>							
						</div>
						<div class="d-flex flex-row justify-content-center">
							<label for="recipe" class="sr-only">Recipe Name</label>
							<div class="input-group">
								<input type="text" id="recipe" name="recipe" class="form-control" placeholder="Recipe Name" required>
							</div>
						</div>
						<div class="d-flex flex-row justify-content-center">
							<small id="recipeName" class="form-text text-muted">Recipe Name</small>
						</div>
					</div>
					<div class="col-1 d-sm-none"></div>
				</div>
				<span id="targetZone"></span>


				<input id="numIngredients" name="numIngredients" type="hidden" value="">
				<input type="submit" style="display:none"  onclick="showModal(event);"/>
			
			</form>

			
			<div class="d-flex flex-row justify-content-center">
				<div class="btn-group btn-group-toggle addRemove" data-toggle="buttons">
					<button class="btn btn-sm btn-mini1 p-2" type="button" id="moreFields" onclick="moreFields();">+</button>
					<button class="btn btn-sm btn-mini2 p-2" type="button" id="removeField" onclick="remF();" disabled="true">-</button>
				</div>			
			</div>

			<div class="row">
			<div class="col-12">
				<div class="col-sm-3 col-3"></div>
				<button class="btn btn-lg btn-custom1 col-sm-3 col-6" type="button" onclick="showModal(event);">Add Recipe</button>
				<div class="d-sm-none col-3"></div>
	
				<div class="d-sm-none col-3"></div>
				<button class="btn btn-lg btn-custom2 col-sm-3 col-6" type="button" onclick="document.location.href='recipes.php'">Cancel</button>
				<div class="col-sm-3 col-3"></div>
			</div>
			</div>
			
			
		</div>
		
		
		
		
		<!-- Confirm Modal -->
		<div class="modal fade addRecipeModal noselect" id="confirmRecipe" tabindex="-1" role="dialog" aria-labelledby="confirmRecipe" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-body">
				<span id="phrase"></span>
				<ul id="recipeModalList" class="recipeModalList">
				</ul>
					<div class="mr-2" style="text-align:right;">Total cost: $<b id="recipeCost"></b></div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-lg btn-custom2" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-lg btn-custom1" onclick="submitForm();">Create</button>
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
			
		</script>
	</footer>

</html>