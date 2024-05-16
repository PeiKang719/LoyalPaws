<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
  <link rel="icon" type="image/png" href="../media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="../Clinic/css/ClinicStyle.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <?php include 'SellerHeader.php';
        include '../Database/Connection.php'; ?>

  <div class="vet-message-container">
    <div class="vet-message-menu">
      <?php
      $sql = "SELECT DISTINCT a.firstName,a.lastName,a.adopterID,a.image FROM message m,adopter a WHERE m.adopterID=a.adopterID AND $key= $sellerID ORDER BY (SELECT MAX(messageID) FROM message WHERE adopterID = a.adopterID) DESC, a.adopterID ASC;";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) { 
          $adopterID = $row['adopterID'];
          if($row['image']!=''){
          $imageData = base64_encode($row['image']);
          $imageSrc2 = "data:image/jpg;base64," . $imageData;
          // Check if the image file exists before displaying it
          if (file_exists('../User/adopter_images/' . $row['image'])) {
              $imageSrc2 = '../User/adopter_images/' . $row['image'];
          }
          }
          else{
              $imageSrc2='../media/profile.png';
          }
      ?>
      <label class="message-menu-container">
      <input type="radio" name="selectedUser" value="<?php echo $adopterID; ?>" onchange="changeColor2(this)">
      <img src="<?php echo $imageSrc2 ?>">
      <p><?php echo $row['firstName'].' '.$row['lastName']?></p>
      </label>

    <?php }}else{?>
      <p style="font-weight:bold;margin-top:250px;margin-left:100px">No Message...</p>
      
    <?php } ?>
    </div>
    <div style="display: flex;flex-direction: column;width: 70%;;">
    <div class="vet-message-content-container" id="vet-message-content-container">
      <div style="display:flex;justify-content: center;align-items: center;">
      <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<lottie-player src="https://assets3.lottiefiles.com/packages/lf20_QpolL2.json"  background="transparent"  speed="1"  style="width: 650px; height: 650px;"  loop  autoplay></lottie-player>
    </div>
    <!---------- Seller-Chat-Get-Message.php ------------>
    </div>
    <div class="vet-typing-container">
        <input type="text" id="message" class="vet-typing" placeholder="Type your message" onkeydown="handleEnter(event)" disabled>
      <button id="send" class="vet-typing-send">Send  <span class="material-symbols-outlined" id="send-icon">send</span></button>
      </div>
    </div>
  </div>

<script type="text/javascript">
   function changeColor2(radio) {
  var radios = document.getElementsByName(radio.name);
  for (var i = 0; i < radios.length; i++) {
    var radioLabel = radios[i].parentNode;
    if (radios[i].checked) {
      radioLabel.style.backgroundColor = "#cfe8fc";
      radioLabel.style.borderColor = "#6fb9f6";
    } else {
      radioLabel.style.backgroundColor = "white";
      radioLabel.style.borderColor = "#b3b3b3";
    }
  }
}

$(document).ready(function() {
    $('input[name="selectedUser"]').change(function() {
      var isRadioChecked = $(this).is(':checked');
    $('#message').prop('disabled', !isRadioChecked);
    if (isRadioChecked) {
      $('#message').removeAttr('disabled');
    }
      var selectedUser = $('input[name="selectedUser"]:checked').val();
      // Make an AJAX request to the server to get the updated message content
      $.ajax({
        url: 'Seller-Chat-Get-Message.php',
        type: 'GET',
        data: { selectedUser: selectedUser },
        success: function(response) {
          // Update the message content with the new HTML
          $('#vet-message-content-container').html(response);
        },
        error: function() {
          alert('Error getting message.');
        }
      });
    });
  });


$(document).ready(function() {
      // Retrieve initial chat messages
      var sellerID = <?php echo $sellerID; ?>;
      var key = '<?php echo $key; ?>';
     var adopterID;
$('input[name="selectedUser"]').change(function() {
  adopterID = $(this).val();
});

      retrieveMessages(sellerID, adopterID,key);

      // Send new message
      $('#send').click(function() {
        var message = $('#message').val();
        sendMessage(message, sellerID, adopterID,key);
        $('#message').val('');
        console.log(key);
        console.log(sellerID);
        console.log(adopterID);
      });
      // Poll server for new messages every 2 seconds
       setInterval(function() {
        retrieveMessages(sellerID, adopterID, key);
      }, 1500);
       setTimeout(scrollToBottom, 1500);
    });

    function handleEnter(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            var message = $('#message').val();
            var sellerID = <?php echo $sellerID; ?>;
          var adopterID = $('input[name="selectedUser"]:checked').val();
          var key = '<?php echo $key; ?>';
            sendMessage(message, sellerID, adopterID, key);
            $('#message').val('');       
        }

        setTimeout(scrollToBottom, 1500);
    }

    function retrieveMessages(sellerID, adopterID, key) {
      $.ajax({
        url: '../ChatFunction/chat-non-user-get-message.php',
        method: 'GET',
        data: { sellerID: sellerID, adopterID: adopterID, key:key },
      success: function(response) {
      $('#chatbox').html(response);
        }
      });
      setTimeout(scrollToBottom, 1500);
    }

    function sendMessage(message, sellerID, adopterID, key) {
      $.ajax({
        url: '../ChatFunction/chat-non-user-send-message.php',
        method: 'POST',
         data: { message: message, sellerID: sellerID, adopterID: adopterID,key:key },
      success: function(response) {
        console.log('Message sent');
        console.log(key);
        console.log(sellerID);
        console.log(adopterID);
        }
      });
      setTimeout(scrollToBottom, 1500);
    }

    function scrollToBottom() {
        var chatbox = document.getElementById('chatbox');
        chatbox.scrollTop = chatbox.scrollHeight;
    }

    // Scroll to bottom when the page loads
    window.onload = function() {
        scrollToBottom();
    };
</script>
</body>
</html>