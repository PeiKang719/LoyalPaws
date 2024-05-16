<!DOCTYPE html>
<html>
<head>
  <title>Live Chat</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div id="chatbox"></div>
  <input type="text" id="message" placeholder="Type your message">
  <button id="send">Send</button>

  <script>
    $(document).ready(function() {
      // Retrieve initial chat messages
      retrieveMessages();

      // Send new message
      $('#send').click(function() {
        var message = $('#message').val();
        sendMessage(message);
        $('#message').val('');
      });

      // Poll server for new messages every 2 seconds
      setInterval(retrieveMessages, 2000);
    });

    function retrieveMessages() {
      $.ajax({
        url: 'chat-get-message.php',
        method: 'GET',
        success: function(response) {
          $('#chatbox').html(response);
        }
      });
    }

    function sendMessage(message) {
      $.ajax({
        url: 'chat-send-message.php',
        method: 'POST',
        data: { message: message },
        success: function(response) {
          console.log('Message sent');
        }
      });
    }
  </script>
</body>
</html>
