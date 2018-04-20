<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Title</title>
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
		<script src="../js/dynamicForm.js"></script> 
	</footer>
	
</html> 
