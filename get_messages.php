<?php
include 'db_connection.php';

$room_id = $_GET['room_id'];

// Retrieve the chat messages for the selected room ID
$sql = "SELECT * FROM messages
        WHERE chat_room_id = '$room_id'
        ORDER BY created_at DESC";
$result = $conn->query($sql);

// Generate the chat messages HTML
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $username = $row["username"];
        $message_text = $row["message_text"];
        $created_at = date("h:i A", strtotime($row["created_at"]));
        
        echo '<div class="message">';
        echo '<p><strong>' . $username . ':</strong> ' . $message_text . '</p>';
        echo '<time>' . $created_at . '</time>';
        echo '</div>';
    }
} else {
    echo '<p>No messages found.</p>';
}

// Close the database connection
$conn->close();
?>
