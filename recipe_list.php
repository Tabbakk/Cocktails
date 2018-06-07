<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if (!isset($_SESSION['id'])){header("location:user_logout.php");exit();}

	include 'includes/db_connection.php';


	$sql = "Select id, name, ml, cost from bottles where user_id = ?";

	if($stmt = $mysqli->prepare($sql)){
		$stmt->bind_param('i', $_SESSION['id']);
		$stmt->execute();    // Execute the prepared query.
		if ($stmt->error != ""){
			
			// error first execution
			
		}
		
		$stmt->bind_result($id, $name, $ml, $price);
		$bottles = array();
		while($stmt->fetch()){
			$bottles[$id]['ml']=$ml;
			$bottles[$id]['name']=$name;
			$bottles[$id]['price']=$price;
		}
		$stmt->close();


		$sql = "Select id, name from cocktails where user_id = ?";
		
		if($stmt = $mysqli->prepare($sql)){
			$stmt->bind_param('i', $_SESSION['id']);
			$stmt->execute();    // Execute the prepared query.
			if ($stmt->error != ""){
				
				//error second execution
				
			}
			$stmt->bind_result($id, $name);
			$i = -1;
			$recipes = array();
			while($stmt->fetch()){
				$i++;
				$recipes[$i]['id']=$id;
				$recipes[$i]['name']=$name;
			}
			$stmt->close();
			
			if($i==-1){
				$_SESSION['from']="recipe_list_empty";
				$_SESSION['insertE']=0;
				$_SESSION['resultMes']="There are no recipies to view";
				$mysqli->close();
				header("location:result.php");
				exit();				
			}
			
			$sql = "Select bottle_id, ml from recipes where cocktail_id = ?";
			$costs = array();
			$max = sizeof($recipes);
			for ($i=0; $i<$max; $i++){
				$cost = 0;
				if($stmt = $mysqli->prepare($sql)){
					$stmt->bind_param('i', $recipes[$i]['id']);
					$stmt->execute();    // Execute the prepared query.
					if ($stmt->error != ""){
						
						// error third execution
						
					}
					
					$stmt->bind_result($ingr_id, $ingr_ml);
					$z = 0;
					while($stmt->fetch()){
						$recipes[$i]['ingr'][$z]['bid'] = $ingr_id;
						$recipes[$i]['ingr'][$z]['ml'] = $ingr_ml;
						$cost += ($bottles[$ingr_id]['price']/$bottles[$ingr_id]['ml'])*$ingr_ml;
						$z++;
					}
					$stmt->close();
				}
				else {
					echo "ERROR";
				}
				$recipes[$i]['cost'] = round($cost,2);
			}


		}
		else{
			// error second statement.
		}
	}
	else{
		// error 1st statement
	}
	
	
	$mysqli->close();

	
	// ############## creating bottles and cocktais JSONS ####################
	$json = '[';
	foreach ($bottles as $id=>$b){
		$name = str_replace("'"," ",stripslashes($b['name']));
		$name = str_replace('"',' ',$name);
		$json = $json.'{"id":"'.$id.'","name":"'.$name.'","size":"'.$b['ml'].'","price":"'.$b['price'].'"},';
	}
	$json = substr($json, 0, -1);
	$json = $json.']';
	$bjson = $json;
	
	$json = '[';
	foreach ($recipes as $recipe){
		$name = str_replace("'"," ",stripslashes($recipe['name']));
		$name = str_replace('"',' ',$name);
		$json = $json.'{"id":"'.$recipe['id'].'", "name":"'.$name.'", "cost":"'.$recipe['cost'].'", "ingredients":[';
		$numIng = 0;
		foreach ($recipe['ingr'] as $ingredient){
			$json = $json.'{"bid":"'.$ingredient['bid'].'", "amount":"'.$ingredient['ml'].'"},';
			$numIng++;
		}
		$json = substr($json, 0, -1);
	$json = $json.'],"ings":"'.$numIng.'"},';
	}
	$json = substr($json, 0, -1);
	$json = $json.']';
	$cjson = $json;
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/Bootstrap.css" rel="stylesheet">
		<link href="css/general.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cocktailulator</title>
		<script>
			var bottlesJSON = JSON.parse('<?php echo $bjson; ?>');
			// bottlesJSON['bottle'][n]['id']
			var cocktailsJSON = JSON.parse('<?php echo $cjson; ?>');
			// cocktailsJSON[0]['ingredients'][0]['amount']
			
			function showModal(n) {
				var name, cost;
				var ingredients = new Array();
				var amount = new Array();
				for(var i = 0; i < cocktailsJSON.length; i++){
					if (cocktailsJSON[i]['id'] == n){
						name = cocktailsJSON[i]['name'];
						cost = cocktailsJSON[i]['cost']
						for(var z = 0; z < cocktailsJSON[i]['ingredients'].length; z++){
							amount.push(cocktailsJSON[i]['ingredients'][z]['amount']);
							for(var y = 0; y < bottlesJSON.length; y++){
								if(bottlesJSON[y]['id']==cocktailsJSON[i]['ingredients'][z]['bid']){
									ingredients.push(bottlesJSON[y]['name']);
								break;
								}
							}
						}
						break;
					}
				}
				
				ul = document.getElementById("recipeModalList")
				for(var i = 0; i < ingredients.length; i++){
					li = document.createElement("li");
					small = document.createElement("small");
					small.className="text-muted smallList";
					small.appendChild(document.createTextNode("- "+amount[i]+"ml of "+ingredients[i]));
					if( i < ingredients.length-1){small.appendChild(document.createTextNode(","));}
					li.appendChild(small);
					ul.appendChild(li);
				}
				document.getElementById('recipeName').innerHTML = name;
				document.getElementById('recipeCost').innerHTML = cost;
				document.getElementById('delRecipeName').innerHTML = name;
				document.getElementById('delRecipeId').value = n;
				$('#viewRecipe').modal();				
			}
			
			
			function delRecipeConfirm(){
				document.getElementById('viewRecipe').classList.remove('fade');
				$('#delRecipe').modal();
				$('#viewRecipe').modal("hide");
				document.getElementById('viewRecipe').classList.add('fade');
			}
			
			function returnToModal(){
				document.getElementById('viewRecipe').classList.remove('fade');
				showModal(document.getElementById('delRecipeId').value);
				$('#delRecipe').modal("hide");
				document.getElementById('viewRecipe').classList.add('fade');				
			}
			
			window.onload = function(){
				$('#viewRecipe').on('hide.bs.modal', function (e) {
					while(document.getElementById("recipeModalList").lastChild){
						document.getElementById("recipeModalList").removeChild(document.getElementById("recipeModalList").lastChild);
					}
				});
				var i;
				var mytable = document.getElementById('RecipesList');
				var myrows = mytable.getElementsByTagName("tr");
				var lastrow = myrows[myrows.length -1];
				var bottomcells = lastrow.getElementsByTagName("td");
				for (i = 0; i < bottomcells.length; i++) {
					if(i!=0 && i!=bottomcells.length-1){
						bottomcells[i].className += " border-bottom";
					}
				}
			}
			
		</script>
	</head>
	<body>
		<div class="container main">
			<div class="row">
				<div class="col-12">
					<h2>Recipes</h2>
					<div class="col-12">
						<table class="table table-striped text-center" id="RecipesList">
							<thead>
								<tr>
								  <th class="d-sm-block d-none" style="visibility:hidden; border:none;"></th>
								  <th scope="col" class="table-bordered">Recipe</th>
								  <th scope="col" class="table-bordered">Cost</th>
								</tr>
							</thead>
							<tbody>
					<?php
						$i = 0;
						foreach ($recipes as $r){
					?>	
								<tr class="d-table-row d-sm-none" onclick="showModal('<?php echo $r['id']; ?>');">
									<td class="table-bordered aligned" id="name<?php echo $i ?>"><?php echo stripslashes($r['name']); ?></td>		
									<td class="table-bordered aligned" id="size<?php echo $i ?>" ><?php echo $r['cost']; ?></td>
								</tr>
								
								<tr></tr>
					
								<tr class="d-sm-table-row d-none">
									<td style="border:none; background:#fff; text-align:right"><button class="btn btn-sm btn-outline-mini1 m-0" type="button" style="width:auto;" onclick="showModal('<?php echo $r['id']; ?>');">view</button></td>
									<td class="table-bordered aligned" id="name<?php echo $i ?>"><?php echo stripslashes($r['name']); ?></td>		
									<td class="table-bordered aligned" id="size<?php echo $i ?>" ><?php echo $r['cost']; ?></td>
									<td style="visibility:hidden; border:none; background:#fff;"><button class="btn btn-sm btn-outline-mini1 m-0" type="button" style="width:auto;" onclick="showModal('<?php echo $r['id']; ?>');">view</button></td>
								</tr>
					<?php
							$i++;
						}
					?>
							</tbody>
						</table>
					</div>

					<div class="col-12 mx-auto" id="MainButtons">
						<button class="btn btn-lg btn-custom2 col-sm-3 col-6" type="button" onclick="document.location.href='recipes.php'">Back</button>
					</div>

				</div>	
			</div>
		</div> <!-- /container -->

		
		<!-- view Modal -->
		<div class="modal fade viewRecipeModal noselect" id="viewRecipe" tabindex="-1" role="dialog" aria-labelledby="viewRecipe" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered viewRecipe" role="document">
			<div class="modal-content">
				<div class="modal-header">
						<h5 class="modal-title" id="recipeName" ></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
				</div>
				<div class="modal-body">
					<ul id="recipeModalList" class="recipeModalList">
					</ul>
					
					<div class="mr-2" style="text-align:right;">Total cost: $<b id="recipeCost"></b></div>
						
					<form class="form deleteRecipeForm" id="deleteRecipeForm" method="post" action="includes/delete_recipe.php" style="visibility:none;">
						<input type="hidden" id="delRecipeId" name="RecipeId" value="" />
					</form>
				</div>
				<div class="modal-footer">
	<!--			  
					<div class="container" style="min-width:auto;">
						<div class="row">
							<div class="d-none d-sm-block col-8" style="text-align:left;">
								<button type="button" class="btn btn-lg btn-custom1" onclick="">Modify</button>
								<button type="button" class="btn btn-lg btn-custom1" onclick="delRecipeConfirm();">Delete</button>
							</div>
							<div class="d-none d-sm-block col-4" style="text-align:right;">
								<button type="button" class="btn btn-lg btn-custom2" data-dismiss="modal">Cancel</button>
							</div>
						</div>
						<div class="row">
							<div class="d-sm-none d-block col-12" style="text-align:center;">
								<button type="button" class="btn btn-lg btn-custom1" onclick="">Modify</button>
								<button type="button" class="btn btn-lg btn-custom1" onclick="delRecipeConfirm();">Delete</button>
							</div>
							<div class="d-sm-none d-block col-12"  style="text-align:center;">
								<button type="button" class="btn btn-lg btn-custom2" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
	-->
					<button type="button" class="btn btn-lg btn-custom1" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-lg btn-custom2" onclick="delRecipeConfirm();">Delete</button>

				</div>
			</div>
		  </div>
		</div>


		
		
	<!-- Del Modal -->
	
		<div class="modal delRecipeModal noselect" id="delRecipe" tabindex="-1" role="dialog" aria-labelledby="delRecipe" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered delRecipe" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="delRecipeTitle" >Delete the following recipe?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
			  <div class="modal-body text-center">
				<span id="delRecipeName"></span>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-lg btn-custom1" onclick="document.getElementById('deleteRecipeForm').submit();">Delete</button>
				<button type="button" class="btn btn-lg btn-custom2" onclick = "returnToModal();" >Cancel</button>
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

