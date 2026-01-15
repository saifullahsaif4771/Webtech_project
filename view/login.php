<!DOCTYPE html>
<html>
<head>
	<title>Login page</title>

		<script>
			
			function validateLogin() {

				var email = document.getElementById("email").value;
				var password = document.getElementById("password").value;


				if(email == "" || password== "") {

					alert("all fields are required ");
					return false;
				}

				return false;
			}
		</script>




</head>

	<body>
			
			<h1>Log in</h1>

		<form action="../controller/authController.php"method= "POST" >
			<input type="hidden" name="action" value="login">

			<label for= "email"> Email: </label>
			<input type = "email" name="email" id="email"> <br><br>

			<label for="password"> Password: </label>
			<input type="password" name="password" id="password"><br><br>

			<button type= "submit">Login</button>

		</form>
		

	<p> Don't have an account? <a href="register.php"> Register</a> </p>	


	</body>
</html>