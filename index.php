<!DOCTYPE html>

<html lang="en">
	<head>
		<link rel="shortcut icon" type="image/png" href="images/logo.png"/>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="views/styles.css">
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<title>Signup Page</title>
	</head>
	<body>

	<div class="container">
		<div class="login-box">
			<div class="row">
				<div class="col-md-6 login-left">
					<h2> Sign In </h2>
					<div class="form-group">
						<label>Username</label>
						<input id="username" placeholder="Username"><br>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input id="password" type="password" placeholder="Password"><br>
					</div>
						<button onclick="signin()">Signin</button>
				</div>

				<div class="col-md-6 login-right">
					<h2> Sign Up </h2>
					<div class="form-group">
						<label>Full Name</label>
						<input id="signup-name" placeholder="Name"><br>
					</div>
					<div class="form-group">
						<label>Username</label>
						<input id="signup-username" placeholder="Username"><br>
					</div>

					<div class="form-group">
						<label>Password</label>
						<input id="signup-password" type="password" placeholder="Password"><br>
					</div>
						<button onclick="signup()">Signup</button>
				</div>
			</div>
		</div>
	</body>

	<script>		

		function signin()
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {					
					let response = JSON.parse(this.responseText);					
					if (response.status == "success") {
						window.location.href = "./views/dashboard.php";
					}
					else
					{
						alert("Invalid username/password");
					}
				}
			};			
			xhttp.open("POST", "http://localhost/CSE391_Project/scripts/users.php", true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send(JSON.stringify({
				query: "signin",
				username: document.getElementById("username").value,
				password: document.getElementById("password").value,
			}));
		}

		function signup()
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {					
					let response = JSON.parse(this.responseText);					
					if (response.status == "success") {
						alert("Account Created!");
					}
					else
					{
						alert("Invalid username/password");
					}
				}
			};			
			xhttp.open("POST", "http://localhost/CSE391_Project/scripts/users.php", true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send(JSON.stringify({
				query: "signup",
				name: document.getElementById("signup-name").value,
				username: document.getElementById("signup-username").value,
				password: document.getElementById("signup-password").value,				
				type: "student"
			}));
		}

	</script>
</html>