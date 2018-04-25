<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link href="css/Bootstrap.css" rel="stylesheet">
    <link href="css/general.css" rel="stylesheet">
    <title>Main</title>
  </head>

  <body>
  
    <div class="main">

		<img class="mainIMG" src="imgs/cocktails.jpg" />
		<div class="login" id="login" style="display:none;">
			<form class="form-signin">
				<h2 class="form-signin-heading">Sign in</h2>
				<label for="username" class="sr-only">Username</label>
				<input type="username" id="username" class="form-control" placeholder="Username" required autofocus>
				<label for="password" class="sr-only">Password</label>
				<input type="password" id="password" class="form-control" placeholder="Password" required>
				<div class="subButtons">
					<button class="btn btn-lg btn-primary" type="submit">Sign in</button>
					<button class="btn btn-lg btn-danger" type="button" onclick="hide_login();">Cancel</button>
				</div>
			</form>
		</div>

		<div  id="initial">
			<button class="btn btn-lg btn-primary" type="button" onclick="show_login();">Login</button>
		</div>
			
    </div> <!-- /container -->  
  
	<script src="js/jQuery.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/Bootstrap.js"></script>
  </body>
  
  <footer>
	<script>
		function show_login(){
			document.getElementById('login').setAttribute('style','display:inline;');
			document.getElementById('initial').setAttribute('style','display:none;');
		}
		function hide_login() {
			document.getElementById('login').setAttribute('style','display:none;');
			document.getElementById('initial').setAttribute('style','display:inline;');
		}
	</script>
  </footer>

</html> 
