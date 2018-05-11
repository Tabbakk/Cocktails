<html>
	<head>
		<meta charset="UTF-8">
		<title>Title</title>
		<script>
			function moreFields() {
			  counter++;
			  document.getElementById('ingredientTitle').innerHTML = "Ingredient "+counter+": ";				
			  var newFields = document.getElementById('template').cloneNode(true);
			  newFields.id = 'block'+counter;
			  newFields.style.display = 'block';
			  var newField = newFields.childNodes;
			  for (var i=0;i<newField.length;i++) {
				var theName = newField[i].name
				if (theName)
				  newField[i].name = theName + counter;
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
			<div id="ingredientTitle"></div><br />
			Ingredient:
			<select name="bottle">
				<option>Bottle</option>
				<option value=""></option>
			</select>
			<br /><br />
			Quantity (ml): <input type="text" name="quantity" placeholder="quantity in ml" />
			<br /><br /><br />
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
			window.onload = moreFields;
			document.getElementById('moreFields').onclick = firstAdd;		
		</script>
	</footer>
	
</html> 
