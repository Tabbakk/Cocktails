	<?php
		session_unset();
	?>

<html>
  <head>
    <meta charset="UTF-8">
    <link href="css/Bootstrap.css" rel="stylesheet">
    <link href="css/general.css" rel="stylesheet">
    <title>Main</title>
  </head>
	<script>
		function show_login(){
			document.getElementById('login').setAttribute('style','display:inline;');
			document.getElementById('initial').setAttribute('style','display:none;');
		}
		function hide_login() {
			document.getElementById('login').setAttribute('style','display:none;');
			document.getElementById('initial').setAttribute('style','display:inline;');
			document.getElementById('noLoginMessage').innerHTML = "";
		}
	</script>
  <body>
	<div class="row">
		<div class="main col-lg-4 col-md-6 col-xs-12">

			<img class="mainIMG col-lg-12 col-md-12 col-xs-12" src="imgs/main.jpg" />
			<div class="login col-lg-12 col-md-12 col-xs-12" id="login" style="display:none;">
				<form class="form-signin" method="post" action="includes/db_auth.php">
					<h2 class="form-signin-heading">Sign in</h2>
					<div class="noLogin" id="noLoginMessage"></div>
					<label for="username" class="sr-only">Username</label>
					<input type="username" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
					<label for="password" class="sr-only">Password</label>
					<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
					<div class="subButtons">
						<button class="btn btn-lg btn-primary" type="submit">Sign in</button>
						<button class="btn btn-lg btn-danger" type="button" onclick="hide_login();">Cancel</button>
					</div>
				</form>
			</div>

			<div  id="initial" class="col-lg-12 col-md-12 col-xs-12">
				<button class="btn btn-lg btn-primary" type="button" onclick="show_login();">Login</button>
			</div>
				
		</div> <!-- /container -->
	</div>

	<script src="js/jQuery.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/Bootstrap.js"></script>
  </body>
  
  <footer>
	<script>
		var url = window.location.href;
		var params = url.split('?');
		if (params[1] === 'p'){
			document.getElementById('noLoginMessage').innerHTML = "Wrong Password";
			show_login();
		}
		if (params[1] === 'u'){
			document.getElementById('noLoginMessage').innerHTML = "User does not exist";
			show_login();
		}
	</script>
  </footer>

</html> 
