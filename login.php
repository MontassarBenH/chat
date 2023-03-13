<?php

// Include the database connection file
include 'db_connection.php';

// Check if the user has submitted the login form
if(isset($_POST['login'])){

   // Get the user's email or username and password from the form
    $email_or_username = $_POST['email_or_username'];
    $password = $_POST['password'];
/*
    // Connect to the SQL database
    $conn = mysqli_connect("localhost:3306", "root", "", "chat-app");
*/

    // Query the database to find a user with the specified email or username and password
    $query = "SELECT * FROM users WHERE (email = '$email_or_username' OR username = '$email_or_username') AND password = '$password'";
    $result = mysqli_query($conn, $query);

    // If a matching user is found, allow them to log in and redirect them to the appropriate page
    if(mysqli_num_rows($result) == 1){
        session_start();
        $_SESSION['email_or_username'] = $email_or_username;
      
        header('Location: ChatHome.php');
        exit;
    }
    // If no matching user is found, prompt the user to register or display an error message
    else{
        echo "Invalid login credentials. Please register if you haven't already.";
        
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
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

		h1 {
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
		<h1>Login Page</h1>
       

	</header>

	<form method="post" action="login.php">
	    <input type="text" name="email_or_username" placeholder="Email or Username" required>
	    <input type="password" name="password" placeholder="Password" required>
	    <input type="submit" name="login" value="Log In">
        <a href="home.html" class="return-button">Return</a>
	</form>
</body>
</html>

