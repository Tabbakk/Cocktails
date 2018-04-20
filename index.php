<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link href="css/general.css" rel="stylesheet">
    <title>Main</title>
  </head>

  <body>
    <div class="main">
		<div class="image"></div>
		<div class="login" id="login" style="display:none;">
			<form method="post" action="#">
				Username: <input type="text" name="username" placeholder="username" /></br>
				Password: <input type="text" name="password" placeholder="password" /></br>
				<input type="submit" value="Login" />
				<input type="button" id="cancel" onclick="hide_login();" value="Cancel" />
			</form>			
		</div>
		<div class="center" >
			<input id="center" type="button" onclick="show_login();" value="Login" />
		</div>
	</div>
  </body>
  
  <footer>
	<script>
		function show_login(){
			document.getElementById('login').setAttribute('style','display:inline;');
			document.getElementById('center').setAttribute('style','display:none;');
		}
		function hide_login() {
			document.getElementById('login').setAttribute('style','display:none;');
			document.getElementById('center').setAttribute('style','display:inline;');
		}
	</script>
  </footer>

</html> 
