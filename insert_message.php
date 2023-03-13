<?php


include 'db_connection.php';
$chat_room_id = $_POST['chat_room_id'];
$user_id = $_POST['user_id'];
$message_text = $_POST['message_text'];

// Insert the new message into the database
$sql = "INSERT INTO messages (chat_room_id, user_id, message_text)
        VALUES ('$chat_room_id', '$user_id', '$message_text')";
if ($conn->query($sql) === TRUE) {
    echo "Message sent successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>