<?php

$query = "SELECT * FROM admin_login";
$result = pg_query($query);

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $adminName = $row['admin_name'];
        $adminType = $row['admin_type'];

    }

    // Free the result set
    pg_free_result($result);
} else {
    // Handle the error case
    echo "Error executing the query: " . pg_last_error();
}
?>


<style>
/* message styleing */
.chat-container {
    position: fixed;
    bottom: 100px;
    right: 20px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    height: 500px;
    width: 300px;
    background-image: linear-gradient(to right, rgb(242, 112, 156), rgb(255, 148, 114));
    color: black;
    font-weight: bold;
    border-radius: 8px;
    padding: 16px;
    overflow-y: auto;
    z-index: 9999;
}

.chat-area {
  height: 450px; /* Set the desired height of the chat area */
  overflow-y: scroll; /* Enable vertical scrolling */
  scroll-behavior: smooth; /* Enable smooth scrolling behavior */
}

/* Style for the message container */
.message-container {
  margin-bottom: 10px; /* Adjust the spacing between messages */
  padding-right: 9px;
}

/* Style for the message content */
.message-content {
  animation-duration: 0.5s; /* Duration of the move-up animation */
}


.chat-header {
    background-image: linear-gradient(25deg, #d64c7f, #ee4758 50%);
    color: #fff;
    padding: 4px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    border-bottom-left-radius: 35px;
    border-bottom-right-radius: 35px;
    font-weight: bold;
    position: fixed;
    z-index: 9999;
    bottom: 600px;
    right: 17px;
    left: 83%;
}

.close-button {
    background-color: darkturquoise;
    border: none;
    border-radius: 50%;
    padding: 8px;
    cursor: pointer;
}

.message-container {
    display: flex;
    align-items: flex-start;
    margin-bottom: 5px;
}

.typing-indicator {
    display: inline-flex;
    align-items: center;
    margin-right: 8px;
}

.typing-indicator span {
    width: 8px;
    height: 8px;
    background-color: #ddd;
    border-radius: 50%;
    margin-right: 4px;
    animation: typing 1s infinite;
}

@keyframes typing {
    0% { opacity: 0.4; }
    50% { opacity: 1; }
    100% { opacity: 0.4; }
}

.message-content {
    background-color: #fff;
    border-radius: 38px;
    padding: 8px 12px;
    margin-top: -2px;
    /* margin-bottom: -63px; */
}

.message {
    margin: 0;
}

.input-container {
    display: flex;
    align-items: center;
    position: fixed;
    bottom: 24px;
    right: 44px;
    z-index: 9999;
}

.message-input {
    flex: 1;
    border: none;
    border-radius: 4px;
    padding: 8px;
    margin-bottom: 30px;
}

.send-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 8px 12px;
    margin-left: 10px;
    cursor: pointer;
    margin-bottom: 30px;
}

.chat-footer {
    background-image: linear-gradient(25deg, #d64c7f, #ee4758 50%);
    color: #fff;
    padding: 8px;
    border-bottom-left-radius: 35px;
    border-bottom-right-radius: 35px;
    font-size: 12px;
    text-align: center;
    position: fixed;
    bottom: 43px;
    left: 83%;
    right: 10px;
    height: 57px;
}


/* Define the animation for moving the message content upwards */
@keyframes messageMoveUp {
  0% {
    transform: translateY(100%);
  }
  100% {
    transform: translateY(0%);
  }
}

</style>


<div class="chat-container" style="display: none;" id="message-box">
      <div class="chat-header">
      &nbsp; &nbsp; JC Bot 
        <button class="close-button" onclick="closeChat()" style="margin-left: 163px; background-color: darkturquoise; margin-right: 11px;">X</button>
      </div>


   <div class="chat-area">
     <div class="message-container">
        <div class="message-content">
            <div class="message" id="intro-message">Hello! I am JC Bot, your Jurisdictional Changes Assistant. I am here to help you with your Census-related queries. What would you like to do?</div>
        </div>
    </div>
   </div>

    <div class="input-container">
        <input type="text" class="message-input" placeholder="Type your message..." />
        <button class="send-button" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
    </div>
   
<div class="chat-footer">
</div>
</div>


<script>

function sendMessage() {
  var input = document.querySelector(".message-input");
  var message = input.value.trim();

  if (message !== "") {
    // Process the user's message here
    
    // Create a new message container
    var messageContainer = document.createElement("div");
    messageContainer.classList.add("message-container");
    
    // Create a new message content
    var messageContent = document.createElement("div");
    messageContent.classList.add("message-content");
    
    // Set the message text
    var messageText = document.createElement("div");
    messageText.classList.add("message");
    messageText.textContent = message;
    
    // Append the message text to the message content
    messageContent.appendChild(messageText);
    
    // Append the message content to the message container
    messageContainer.appendChild(messageContent);
    
    // Append the message container to the chat area
    var chatArea = document.querySelector(".chat-area");
    chatArea.appendChild(messageContainer);
    
    // Clear the input field
    input.value = "";
    
    // Check if the scroll position is at the bottom
    var isAtBottom = chatArea.scrollHeight - chatArea.scrollTop === chatArea.clientHeight;
    
    // If not at the bottom, scroll to the bottom after a small delay
    if (!isAtBottom) {
      setTimeout(function() {
        chatArea.scrollTop = chatArea.scrollHeight;
      }, 100);
    } else {
      // If at the bottom, continuously scroll to the bottom
      chatArea.scrollTop = chatArea.scrollHeight;
    }
    
    // Apply the animation to the message content
    messageContent.style.animation = "messageMoveUp 0.5s ease-in";
    
    // Remove the animation class after the animation is finished
    messageContent.addEventListener("animationend", function() {
      messageContent.style.animation = "";
    });
  }
}



// Retrieve and display the stored messages on page load
// window.addEventListener("load", function() {
//     var messages = JSON.parse(localStorage.getItem("chatMessages")) || [];
//     var messageContainer = document.querySelector(".message-container");

//     messages.forEach(function(message) {
//         var messageElement = document.createElement("div");
//         messageElement.className = "message";
//         messageElement.textContent = message.content;

//         if (message.sender === "user") {
//             messageElement.classList.add("user-message");
//         } else {
//             messageElement.classList.add("admin-message");
//         }

//         messageContainer.appendChild(messageElement);
//     });

//     // Scroll to the bottom of the message container
//     messageContainer.scrollTop = messageContainer.scrollHeight;
// });


// function receiveMessage() {
//     // Simulate receiving a message from the admin
//     var message = "This is an admin message.";
    
//     // Store the received message in local storage
//     var messages = JSON.parse(localStorage.getItem("chatMessages")) || [];
//     messages.push({ sender: "admin", content: message });
//     localStorage.setItem("chatMessages", JSON.stringify(messages));
    
//     // Reload the page to display the received message
//     location.reload();
// }


</script>