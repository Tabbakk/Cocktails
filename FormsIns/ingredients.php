<html>
	<head>
		<meta charset="UTF-8">
		<title>Title</title>
		<script>
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
					console.log(newField[i]);
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
				counter++;
				document.getElementById('ingredientTitle').innerHTML = "Ingredient "+counter+": ";				
				var newFields = document.getElementById('template').cloneNode(true);
				newFields.id = 'block'+counter;
				newFields.style.display = 'block';
				if(newFields.hasChildNodes()){				
					var newField = newFields.childNodes;
					for (var i=0;i<newField.length;i++){
						setChildNodes(newField[i]);
					}					
				}
				var insertHere = document.getElementById('writeZone');
				insertHere.parentNode.insertBefore(newFields,insertHere);				
			}

			function firstAdd() {
			  moreFields();
			  document.getElementById('moreFields').onclick = moreFields;
			  document.getElementById('removeField').setAttribute("style","display:inline");
			}

			function remF() {
			  var elem = document.getElementById('block'+counter);
			  elem.parentNode.removeChild(elem);
			  counter--;
			  if (counter < 2) {
				document.getElementById('moreFields').onclick = firstAdd;
				document.getElementById('removeField').setAttribute("style","display:none");
			  }	
			}
		</script> 
	</head>
	<body>
		<div id="template" style="display: none">
			<div class ="">
			<div id="ingredientTitle"></div><br />
			Ingredient:
			<div class="asd">
			<select name="bottle">
				<option>Bottle</option>
				<option value=""></option>
			</select>
			</div>
			<br /><br />
			<div class="qr">
			Quantity (ml): <input type="text" name="quantity" placeholder="quantity in ml" />
			</div>
			<br /><br /><br />
			</div>
		</div>

		<form method="post" action="#">

			<span id="writeZone"></span>

			<input type="button" id="removeField" onclick="remF();" value="Remove ingredient" style="display:none;" />
			<input type="button" id="moreFields" value="Add ingredient" />
			<input type="submit" value="Send form" />

		</form>
	</body>
	
	<footer>
		<script>
			var counter = 0;
			window.onload = function(e){
				moreFields();
			}
			document.getElementById('moreFields').onclick = firstAdd;		
		</script>
	</footer>
	
</html> 
