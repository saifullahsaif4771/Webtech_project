<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	
	<title>Register page</title>

		<script>
			
			function validateRegister() {
            	var name = document.getElementById("name").value;
           	    var email = document.getElementById("email").value;
            	var password = document.getElementById("password").value;

            if (name == "" || email == "" || password == "") {
                alert("All fields are required");
                return false;
            }
            return true;
        }


		</script>
</head>
<body>

	<h1>Register</h1>

		<form action= "../controller/authController.php" method="POST" onsubmit="return validateRegister()" novalidate>

			 <input type="hidden" name="action" value="register">

   	 	<label for="name">Name: </label>
    	<input type="text" name="name" id="name"><br><br>

   		<label for="email" >Email: </label>
    	<input type="email" name="email" id="email"><br><br>

    	<label for="password">Password:</label>
    	<input type="password" name="password" id="password"><br><br>

    	<label>Role:</label>
    	<select name= "Role">

    		<option value="student">Student</option>
        	<option value="admin">Admin</option>

        </select><br><br>

        <button type= "submit">Register</button>
			
			
		</form>

	<p> Already have an account?	<a href="login.php">Login</a></p>

</body>
</html>