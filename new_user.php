<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if (isset($_SESSION['id'])) {header("location:main.php"); exit();}

	$user = "";
	$password = "";
	$email = "";
	$UserError = "";
	$EmailError = "";
	
	if (isset($_SESSION['register_u'])){$user=$_SESSION['register_u'];}
	if (isset($_SESSION['register_p'])){$password=$_SESSION['register_p'];}
	if (isset($_SESSION['register_m'])){$email=$_SESSION['register_m'];}
	if (isset($_SESSION['register_ue'])){$UserError=$_SESSION['register_ue'];}
	if (isset($_SESSION['register_me'])){$EmailError=$_SESSION['register_me'];}
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
		function pwValidity(str){
			var passRE = new RegExp("^(?=[a-zA-Z0-9])"); if(!passRE.test(str)){return "Invalid symbol: only letters oer numbers accepted";}
			var passRE = new RegExp("^(?=.*[a-z])"); if(!passRE.test(str)){return "Must conatin at least one lowercase letter";}
			var passRE = new RegExp("^(?=.*[A-Z])"); if(!passRE.test(str)){return "Must conatin at least one uppercase letter";}
			var passRE = new RegExp("^(?=.*[0-9])"); if(!passRE.test(str)){return "Must conatin at least one number";}
			var passRE = new RegExp("^(?=.{6,})"); if(!passRE.test(str)){return "Must be at least 6 characters long";}
			return "";			
		}
		
		function emailValidity(email) {
		  var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
		  return re.test(email);
		}		
		function validateForm(){
			var error = false;
			if(document.getElementById('username').value==""){
				document.getElementById('errorUser').innerHTML="Username required";
				document.getElementById('username').classList.add("is-invalid");
				error=true;
			}
			if(document.getElementById('password').value==""){
					document.getElementById('errorPassword').innerHTML="Password Required";
					document.getElementById('password').classList.add("is-invalid");
					error=true;				
			}
			else{
				var str = document.getElementById("password").value;
				var e = pwValidity(str);
				if (e!=""){
					document.getElementById('errorPassword').innerHTML=e;
					document.getElementById('password').classList.add("is-invalid");
					error=true;
				}
			}
			if(document.getElementById('password').value == "" && document.getElementById('password2').value == ""){
				document.getElementById('password2').classList.add("is-invalid");
				error=true;								
			}
			if(document.getElementById('password2').value != document.getElementById('password').value){
				document.getElementById('errorPassword2').innerHTML="Does not match Password";
				document.getElementById('password2').classList.add("is-invalid");
				error=true;				
			}
			var str = document.getElementById("email").value;
			if(!emailValidity(str)){
				document.getElementById('errorMail').innerHTML="Not  valid email address";
				document.getElementById('email').classList.add("is-invalid");
				error=true;				
			}
			if(!error){
				document.getElementById("signupForm").submit();
			}
		}
		
		window.onload = function() {
			var hidden=true;
			document.getElementById("username").addEventListener("focus", function(event){
				var node = document.getElementById("username");
				node.classList.remove("is-invalid");
				document.getElementById("errorUser").innerHTML="";
			});
			document.getElementById("password").addEventListener("focus", function(event){
				var node = document.getElementById("password");
				node.classList.remove("is-invalid");
				document.getElementById("errorPassword").innerHTML="";
			});
			document.getElementById("password2").addEventListener("focus", function(event){
				var node = document.getElementById("password2");
				node.classList.remove("is-invalid");
				document.getElementById("errorPassword2").innerHTML="";
			});
			document.getElementById("email").addEventListener("focus", function(event){
				var node = document.getElementById("email");
				node.classList.remove("is-invalid");
				document.getElementById("errorMail").innerHTML="";
			});
			document.getElementById('PWbutton').addEventListener("click", function(e){
				if(hidden){
					document.getElementById('PWimg').setAttribute('src','imgs/hidepw.png');
					document.getElementById('password').setAttribute('type','text');
					document.getElementById('password2').setAttribute('type','text');
					hidden=false;
				}
				else{
					document.getElementById('PWimg').setAttribute('src','imgs/showpw.png');
					document.getElementById('password').setAttribute('type','password');
					document.getElementById('password2').setAttribute('type','password');
					hidden=true;
				}
			});
			<?php
				if($UserError!=""){
			?>
				document.getElementById("username").classList.add("is-invalid");
			<?php
				}
				if($EmailError!=""){
			?>
				document.getElementById("email").classList.add("is-invalid");
			<?php
				}
			?>
		}
			
	</script>
</head>
  <body>
	<div class="container main">
		<img class="mainIMG img-fluid signUp" src="imgs/main.jpg" >
		<div class="row justify-content-center align-items-start">
			<form class="form-signin col-sm-6 col-8 signupForm" id="signupForm" method="post" action="includes/insert_user.php">
				<h2 class="form-signin-heading mb-4">Create new user</h2>
				<div class="errorMessage text-danger" id="errorUser"><?php echo($UserError); ?></div>
				<label for="username" class="sr-only">Username</label>
				<input type="text" id="username" name="username" class="form-control text-center noaddon" placeholder="Username" Value="<?php echo $user; ?>" required>
				<div class="errorMessage text-danger" id="errorPassword"></div>
				<label for="password" class="sr-only">Password</label>
				<div class="input-group">
					<input type="password" id="password" name="password" class="form-control text-center addon" placeholder="Password" Value="<?php echo $password; ?>" required>
					<div class="input-group-append" id="PWbutton">
						<span class="input-group-text p-0" id="basic-addon"><img class="PWimg" id="PWimg" src="imgs/showpw.png" ></span>
					</div>
				</div>
				<div class="errorMessage text-danger" id="errorPassword2"></div>
				<label for="password2" class="sr-only">Confirm Password</label>
				<input type="password" id="password2" name="password2" class="form-control text-center noaddon" placeholder="Confirm Password" Value="<?php echo $password; ?>" required>
				<div class="errorMessage text-danger" id="errorMail"><?php echo($EmailError); ?></div>
				<label for="email" class="sr-only">Email</label>
				<input type="email" id="email" name="email" class="form-control text-center noaddon" placeholder="Email" Value="<?php echo $email; ?>" required>
				
				<input type="submit" style="display:none"/>
			</form>
				
			<div class="col-12" id="initial" >
				<div class="col-sm-3 col-3"></div>
				<button class="btn btn-lg btn-custom1 col-sm-3 col-6" type="button" onclick="validateForm();">Sign Up</button>
				<div class="d-sm-none col-3"></div>
				<div class="d-sm-none col-3"></div>
				<button class="btn btn-lg btn-custom2 col-sm-3 col-6" type="button" onclick="document.location.href='index.php'">Cancel</button>
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
	</script>
  </footer>

</html> 
