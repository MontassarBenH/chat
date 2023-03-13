<?php
      include 'db_connection.php';

session_start();
if(isset($_SESSION['email_or_username'])){
    $email_or_username = $_SESSION['email_or_username'];
    echo "Welcome, " . $email_or_username . "!";
} else {
    header('Location: login.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
$stmt->bind_param("ss", $email_or_username, $email_or_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // If the query returns a row with the user data, store the user data in the session
    $user_data = $result->fetch_assoc();

    $_SESSION['user_id'] = $user_data['user_id'];
 
    // Save the session user data in variables
    $logged_in_user_id = $user_data['user_id'];
    echo "USerID, " . $logged_in_user_id . "!";

} else {
    // Handle the case when the user data is not found in the database
}

?>