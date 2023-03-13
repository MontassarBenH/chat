<!DOCTYPE html>
<html>
  <head>
    <title>Chat Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
  <?php
      
      include 'db_connection.php';

      // Start the session
      session_start();
  
     

      if(isset($_SESSION['email_or_username'])){
        $email_or_username = $_SESSION['email_or_username'];
        
        echo "Welcome, " . $email_or_username . "!";
        
    } else {
        header('Location: login.php');
        exit;
    }
     //get data of the user on the session 
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
    
    } else {
        // Handle the case when the user data is not found in the database
    }
   
    // Retrieve chatroom data from database
    $sql = "SELECT * FROM chat_rooms";
    $resultChatroom = $conn->query($sql);

    // Retrieve user data from database
    $sql = "SELECT * FROM users";
    $resultUser = $conn->query($sql);

     // Retrieve chat messages from the database
     $sql = "SELECT * FROM messages";
     $resultMessages = $conn->query($sql);

     // Retrieve chat messages for the selected chat room from the database
     //$sql = "SELECT * FROM messages WHERE chat_room_id = $roomId";
    // $resultMessagesSelected = $conn->query($sql);



    ?>
    <header>
      <h1>Chat Rooms</h1>
    </header>
    <main>
      <aside id="sidebar">
        <div id="room-list">
          <h2>Rooms</h2>
          <ul>
            <?php
            
            // Display chatroom data in HTML
            if ($result->num_rows > 0) {
              while($row = $resultChatroom->fetch_assoc()) {
                  $roomId = isset($_GET['room_id']) ? $_GET['room_id'] : 1;
                  $link = "ChatHome.php?room_id=" . $row["chat_room_id"];
                  $active = ($row["chat_room_id"] == $roomId) ? "active" : "";
                  echo "<li><a href='$link' class='$active'>" . $row["chat_room_name"] . "</a></li>";
              }
            } else {
              echo "No chatrooms found.";
            }

            $chat_room_id =  $roomId;
            $query3 = "SELECT chat_room_name FROM chat_rooms WHERE chat_room_id = $chat_room_id";
            $result3 = mysqli_query($conn, $query3);
            $row = mysqli_fetch_assoc($result3);
            $chat_room_name = $row['chat_room_name'];
           
            ?>
          </ul>
        </div>
        <div id="user-list">
          <h2>Users</h2>
          <ul>
            <?php
              
              // Display user data in HTML
              if ($resultUser->num_rows > 0) {
                  while($row = $resultUser->fetch_assoc()) {
                      echo "<li><a href='#'>" . $row["username"] . "</a></li>";
                  }
              } else {
                  echo "No users found.";
              }

            ?>
          </ul>
        </div>
        <form action="logout.php" method="post">
  <button type="submit" name="logout">Logout</button>
</form>
      </aside>
      <section id="chat-window">
        <header>
          <h2><?php echo $chat_room_name; ?></h2>
        </header>
        <div id="chat-messages">
        <?php
          // Get the selected room ID from the URL
            $roomId = isset($_GET['room_id']) ? $_GET['room_id'] : 1;

            // Prepare the SQL query with a WHERE clause to filter by the selected room ID
            $sql = "SELECT * FROM messages WHERE chat_room_id = '$roomId' ORDER BY created_at ASC";

            // Execute the SQL query
            $resultMessages = $conn->query($sql);

            // Display the chat messages
            if ($resultMessages->num_rows > 0) {
                while($row = $resultMessages->fetch_assoc()) {
                    echo '<div class="message">';
                    echo '<p><strong>' . $row["username"] . ':</strong> ' . $row["message_text"] . '</p>';
                    echo '<time>' . date("h:i A", strtotime($row["created_at"])) . '</time>';
                    echo '</div>';
                }
            }

              ?>

        </div>
        <form id="message-form">
    <input type="hidden" name="chat_room_id" value="<?php echo $roomId; ?>">
    <input type="hidden" name="user_id" value="<?php echo $logged_in_user_id; ?>">
    <input type="text" name="message_text" placeholder="Type your message...">
    <button type="submit">Send</button>
</form>

<div id="chat-messages">
    <!-- The chat messages will be displayed here -->
</div>

<script>
    // Submit the message form using AJAX
    $("#message-form").submit(function(event) {
        // Prevent the form from submitting normally
        event.preventDefault();

        // Get the form data
        var formData = $(this).serialize();

        // Send the form data to the server using AJAX
        $.ajax({
            type: "POST",
            url: "insert_message.php",
            data: formData,
            success: function() {
                // Clear the message input field
                $("#message-form input[name='message_text']").val("");

                // Reload the chat messages using AJAX
                loadChatMessages();
            }
        });
    });

    // Load the chat messages using AJAX
    function loadChatMessages() {
        // Get the selected room ID from the URL
        var roomId = "<?php echo $roomId; ?>";

        // Send a GET request to the server to retrieve the chat messages
        $.ajax({
            type: "GET",
            url: "get_messages.php",
            data: {room_id: roomId},
            success: function(data) {
                // Update the chat messages
                $("#chat-messages").html(data);
            }
        });
    }

    // Load the initial chat messages
    loadChatMessages();

    // Refresh the chat messages every 5 seconds
    setInterval(loadChatMessages, 5000);
</script>


     
      </section>
   
    </main>
  </body>
</html>
