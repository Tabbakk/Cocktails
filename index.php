<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if (isset($_SESSION['id'])) {header("location:main.php"); exit();}
	$user='Value=""';
	$password='Value=""';
	$error="";
	$code="";
	if (isset($_SESSION['login_u'])){$user='Value="'.$_SESSION['login_u'].'" ';}
	if (isset($_SESSION['login_p'])){$password='Value="'.$_SESSION['login_p'].'" ';}
	if (isset($_SESSION['login_e'])){
		if($_SESSION['login_e']==='user'){$error="Username does not exist"; $code=1;}
		if($_SESSION['login_e']==='pass'){$error="Incorrect password"; $code=2;}
		if($_SESSION['login_e']==='auth'){$error="This account is not active";}		
	}	
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	session_destroy();
?>
<html>
  <head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="css/Bootstrap.css" rel="stylesheet">
    <link href="css/general.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cocktailulator</title>
	<script>
		function showLogin(){
			document.getElementById('login').setAttribute('style','display:block;');
			document.getElementById('initial').setAttribute('style','display:none;');
			document.getElementById("username").focus();
		}
		function hideLogin() {
			document.getElementById('login').setAttribute('style','display:none;');
			document.getElementById('initial').setAttribute('style','display:block;');
			document.getElementById('noLoginMessage').innerHTML = "";
			document.getElementById('username').classList.remove('is-invalid');
			document.getElementById('username').value = "";
			document.getElementById('password').classList.remove('is-invalid');
			document.getElementById('password').value = "";
		}
		function submitForm() {
			var f = document.getElementById('loginForm');
			if(f.checkValidity()) {
				f.submit();
			} else {
				if(document.getElementById('username').value==""){document.getElementById("username").className += " is-invalid";}
				if(document.getElementById('password').value==""){document.getElementById("password").className += " is-invalid";}
				document.getElementById('noLoginMessage').innerHTML = "Please insert Username & Password";
			}
		}
		window.onload = function(){
			var hidden=true;
			document.getElementById('PWbutton').addEventListener("click", function(e){
				if(hidden){
					document.getElementById('PWimg').setAttribute('src','imgs/hidepw.png');
					document.getElementById('password').setAttribute('type','text');
					hidden=false;
				}
				else{
					document.getElementById('PWimg').setAttribute('src','imgs/showpw.png');
					document.getElementById('password').setAttribute('type','password');
					hidden=true;
				}
			});			
		}
	</script>
  </head>
  <body>
	<div class="container main">
		<img class="mainIMG img-fluid" src="imgs/main.jpg" >
		<div class="row">
				<div class="login col-12" id="login" style="display:none;">
					<form class="form-signin" id="loginForm" method="post" action="includes/db_auth.php">
						<h2 class="form-signin-heading">Sign in</h2>
						<div class="noLogin text-danger" id="noLoginMessage"><?php echo($error); ?></div>
						<label for="username" class="sr-only">Username</label>
						<input type="text" id="username" name="username" class="form-control text-center" placeholder="Username" <?php echo $user; ?> required>

						<div class="input-group">
							<input type="password" id="password" name="password" class="form-control text-center" placeholder="Password" <?php echo $password; ?> required>
							<div class="input-group-append" id="PWbutton">
								<span class="input-group-text p-0" id="basic-addon"><img class="PWimg" id="PWimg" src="imgs/showpw.png" ></span>
							</div>
						</div>
						
						<input id="errorCode" type="hidden" value="<?php echo($code);?>">
						<input type="submit" style="display:none"/>
					</form>
					<div class="col-sm-3 col-3"></div>
					<button class="btn btn-lg btn-custom1 col-sm-3 col-6" type="button" onclick="submitForm()">Sign in</button>
					<div class="d-sm-none col-3"></div>
					<div class="d-sm-none col-3"></div>
					<button class="btn btn-lg btn-custom2 col-sm-3 col-6" type="button" onclick="hideLogin();">Cancel</button>
					<div class="col-sm-3 col-3"></div>
				</div>
				
				<div class="col-12" id="initial" >
					<div class="col-sm-3 col-3"></div>
					<button class="btn btn-lg btn-custom1 col-sm-3 col-6" type="button" onclick="showLogin();">Login</button>
					<div class="d-sm-none col-3"></div>
					<div class="d-sm-none col-3"></div>
					<button class="btn btn-lg btn-custom1 col-sm-3 col-6" type="button" onclick="document.location.href='new_user.php'">Sign Up</button>
					<div class="col-sm-3 col-3"></div>
				</div>	
		</div>
	</div>
	<script src="js/jQuery.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/Bootstrap.js"></script>
  </body>
  
  <footer>
	<script>
		if (document.getElementById('noLoginMessage').innerHTML != ""){
			showLogin();
		}
		var code = document.getElementById('errorCode').value;
		if (code==1){
			document.getElementById("username").className += " is-invalid";
			document.getElementById("username").focus();
		}
		if (code==2){
			document.getElementById("password").className += " is-invalid";
			document.getElementById("password").focus();
		}
		document.getElementById("username").onkeypress = function(){document.getElementById("username").className = "form-control";document.getElementById("noLoginMessage").innerHTML="";}
		document.getElementById("password").onkeypress = function(){document.getElementById("password").className = "form-control";document.getElementById("noLoginMessage").innerHTML="";}
	</script>
  </footer>

</html> 
