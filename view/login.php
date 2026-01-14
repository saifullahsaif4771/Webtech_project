<!DOCTYPE html>
<html>
<head>
	<title>Login page</title>
</head>

	<body>
			
			<h1>Log in</h1>

			<form method= "POST" action="">
					<label for="name">Name</label>
					<input type= "text" id="name" name= "name"><br>

					<label for="pass">Password</label>
					<input type= "password" id="pass" name= "pass"><br>

					<input type= "submit" name= "submit">

			</form>
			<?php

			if(isset($_POST['submit'])){

				if(!empty($_POST['name'] && ($_POST['pass']))){

					echo "welcome "." ". $_POST['name']. "Login successful";
				}

				else if(empty($_POST['name'] || ($_POST['pass']))){

					echo "Enter your name and pasword";
				}
				

				else if(empty($_POST['name'])){

					echo "ERROR: Enter your name ";
				}
				else if(empty($_POST['pass'])){

					echo "ERROR: Enter your password ";
				}

				

				
			}	

			


			?>


	</body>
</html>