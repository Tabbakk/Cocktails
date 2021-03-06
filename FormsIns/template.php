<html>
	<head>
		<meta charset="UTF-8">
		<link href="../css/Bootstrap.css" rel="stylesheet">
		<link href="../css/general.css" rel="stylesheet">
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
				var theName, theID;
				counter++;
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
				if (counter > 1) {
					document.getElementById('removeField').className="btn btn-sm btn-custom2 p-2";
					document.getElementById('removeField').disabled = false;
					window.alert(counter);	
				}
			}

			function remF() {
			  var elem = document.getElementById('ingredient'+counter);
			  elem.parentNode.removeChild(elem);
			  counter--;
			  if (counter < 2) {
				document.getElementById('removeField').className="btn btn-sm btn-custom2 p-2 disabled";
				document.getElementById('removeField').disabled = true;
				window.alert(counter);	
			  }	
			}			
			
			
			
			
			
			function evenNumber(i) {
					var n, numb;
					numb = document.getElementById("");
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
				var f = document.getElementById('');
				if(f.checkValidity()) {
					f.submit();
				} else {
					if(document.getElementById('').value==""){
						document.getElementById("").className += " is-invalid";
						createMessage("errorName", "name");
					}
					if(document.getElementById('').value=="" || document.getElementById('').value<=0){
						document.getElementById("").className += " is-invalid";
						createMessage("errorSize", "size");
						}
				}
			}
			
			window.onload = function() {
				moreFields();
			}
			
		</script>
		<title>Template</title>
	</head>
	
	
	<body>

		<div ID="template" style="display: none" class="col-12 border-top border-bottom ingredientList">
		<div class="row">
			<div id="ingredientNum" class="col-sm-2 col-1 d-flex align-items-center justify-content-end">1: </div>
			<div class="col-sm-8 col-10">
				<div class="row">
					<div class="d-flex flex-row justify-content-sm-end justify-content-center col-12 col-sm-6">
						<div style="width:320px; padding:0 20px;">
							<div class="d-flex flex-row justify-content-center">
								<div class="errorMessage text-danger" id="errorBottle"></div>
							</div>
							<div class="d-flex flex-row justify-content-center">
								<label for="bottle" class="sr-only">Bottle</label>	
								<div class="input-group">
									<select class="form-control" name="bottle" id="bottle" required>
										<option value="" disabled selected>Select a bottle</option>
										<option></option>
									</select>
								</div>
							</div>
							<div class="d-flex flex-row justify-content-center">
								<small id="recipeBottle" class="form-text text-muted">Bottle</small>					
							</div>
						</div>
					</div>
					<div class="d-flex flex-row justify-content-sm-start justify-content-center col-12 col-sm-6">
						<div style="width:320px; padding:0 20px;">
							<div class="d-flex flex-row justify-content-center">
								<div class="errorMessage text-danger" id="errorAmount"></div>							
							</div>
							<div class="d-flex flex-row justify-content-center">
								<label for="amount" class="sr-only">Amount (ml)</label>
								<div class="input-group">
									<input type="number" id="amount" name="amount" class="form-control" placeholder="Amount" min="1" onblur="evenNumber(0);" required>
									<div class="input-group-append">
										<span class="input-group-text" id="basic-addon">ml</span>
									</div>
								</div>
							</div>
							<div class="d-flex flex-row justify-content-center">
								<small id="recipeAmount" class="form-text text-muted">Amount</small>
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
			<form class="form addRecipeForm" id="addRecipeForm" method="post" action="">
				<div class="row">
					<div class="col-1 d-sm-none"></div>
					<div class="col-sm-12 col-10">
						<div class="d-flex flex-row justify-content-center">
							<div class="errorMessage text-danger" id="errorName"></div>							
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


				<input id="errorCode" type="hidden" value="<?php echo('');?>">
				<input type="submit" style="display:none"/>
			
			</form>

			
			<div class="d-flex flex-row justify-content-center">
				<div class="btn-group btn-group-toggle addRemove" data-toggle="buttons">
					<button class="btn btn-sm btn-custom1 p-2" type="button" id="moreFields" onclick="moreFields();">+</button>
					<button class="btn btn-sm btn-custom2 p-2" type="button" id="removeField" onclick="remF();" disabled="true";>-</button>
				</div>			
			</div>

			<div class="row">
			<div class="col-12">
				<div class="col-sm-3 col-3"></div>
				<button class="btn btn-lg btn-custom1 col-sm-3 col-6" type="button" onclick="submitForm();">Add Recipe</button>
				<div class="d-sm-none col-3"></div>
	
				<div class="d-sm-none col-3"></div>
				<button class="btn btn-lg btn-custom2 col-sm-3 col-6" type="button" onclick="document.location.href='includes/erase.php'">Cancel</button>
				<div class="col-sm-3 col-3"></div>
			</div>
			</div>
			
			
		</div>
		<script src="../js/jQuery.js"></script>
		<script src="../js/popper.js"></script>
		<script src="../js/Bootstrap.js"></script>
	</body>
  
	<footer>
		<script>
			
		</script>
	</footer>

</html>