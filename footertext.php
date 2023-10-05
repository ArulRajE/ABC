
<style>
.chat-icon-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: flex;
    align-items: flex-end;
}

.chat-icon {
    background-color: #F44336;
    color: white;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 10px;
    cursor: pointer;
}
</style>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-TqtuIyDFhq53uOfutgqFfM5WIv6fui/x9PrkLjLSg3gKWSItv4FQ78FvVCmI9T5O" crossorigin="anonymous"> -->

<footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                &copy; <?php echo date("Y"); ?> ORGI, Ministry of Home Affairs, Government of India
                                <br>
                                Developed By : IT Team DCO Gujarat & NDC-DRS Bengaluru
                            </div>
                        </div>
                    </div>
                    
<div class="chat-icon-container">
    <div class="chat-icon">
        <i class="fas fa-comments" onclick="openChat()"></i>
    </div>
</div>

</footer>
<?php include "popupmodel.php"; ?>
<?php include "chat.php"; ?>

<script>
function openChat() {
    var chatContainer = document.querySelector(".chat-container");
    if (chatContainer) {
        chatContainer.style.display = "block";
    }

    console.log("Chat icon clicked!");
}

// to close chat window
function closeChat() {
    var messageBox = document.getElementById("message-box");
    if (messageBox) {
        messageBox.style.display = "none";
        location.reload();
    }
}

</script>




