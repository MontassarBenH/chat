<!DOCTYPE html>
<html>
<head>
	<title>Registration Form</title>
	<style>
		body {
			background-color: #f1f1f1;
			font-family: Arial, sans-serif;
			font-size: 16px;
			margin: 0;
			padding: 0;
		}

		header {
			background-color: #333;
			color: #fff;
			padding: 10px;
			text-align: center;
		}

		h2 {
			margin: 20px;
			text-align: center;
		}

		form {
			background-color: #fff;
			border-radius: 4px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
			margin: 20px auto;
			max-width: 400px;
			padding: 20px;
			text-align: center;
		}

		label {
			display: block;
			margin: 10px auto;
			text-align: left;
			width: 100%;
		}

		input[type="text"], input[type="password"], input[type="submit"] {
			border-radius: 4px;
			border: none;
			box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2);
			display: block;
			margin: 10px auto;
			padding: 10px;
			width: 100%;
		}

		input[type="submit"] {
			background-color: #4CAF50;
			color: #fff;
			cursor: pointer;
			font-size: 1.2em;
			transition: background-color 0.3s;
		}

		input[type="submit"]:hover {
			background-color: #3e8e41;
		}

        .return-button {
			position: fixed;
			top: 20px;
			left: 20px;
			padding: 10px;
			background-color: #4CAF50;
			color: #fff;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 1em;
			transition: background-color 0.3s;
		}

        .return-button:hover {
			background-color: #3e8e41;
		}

	</style>
</head>
<body>
	<header>
		<h2>Register</h2>
	</header>

	<form action="register.php" method="post">
        <label for="Email">Email:</label>
		<input type="text" id="Email" name="Email" required><br><br>
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" required><br><br>
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required><br><br>
		<input type="submit" value="Register">
        <a href="home.html" class="return-button">Return</a>

	</form>



	<?php

       include 'db_connection.php';
/*
	// Connect to the database
	$conn = mysqli_connect("localhost:3306", "root", "", "chat-app");

	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
*/
	// Handle form submission
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Email = $_POST["Email"];
	    $username = $_POST["username"];
	    $password = $_POST["password"];

	    // Insert data into the database
	    $sql = "INSERT INTO users (Email ,username, password) VALUES ('$Email','$username', '$password')";

	    if (mysqli_query($conn, $sql)) {
	        echo "Registration successful";
            header('Location: home.html');
            exit;
	    } else {
	        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	    }
	}

	mysqli_close($conn);
?>

</body>
</html>
