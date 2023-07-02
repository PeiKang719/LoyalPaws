<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
  <link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="ClinicStyle.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <?php include 'UserHeader.php'; ?>

  <div class="vet-message-container">
    <div class="vet-message-menu">
      <?php
      include 'Connection.php';
      $sql = "SELECT DISTINCT v.name, v.vetID, s.sellerID, CONCAT(s.firstName, ' ', s.lastName) AS sname, ps.shopID, ps.shopname, v.image AS vimage, s.image AS simage, ps.shop_image FROM message m LEFT JOIN vet v ON m.vetID = v.vetID LEFT JOIN seller s ON m.sellerID = s.sellerID LEFT JOIN pet_shop ps ON m.shopID = ps.shopID WHERE m.adopterID = $adopterID AND (v.name IS NOT NULL OR CONCAT(s.firstName, ' ', s.lastName) IS NOT NULL OR ps.shopname IS NOT NULL) ORDER BY m.messageID DESC;";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) { 
          if($row['vetID'] !=NULL){
            $receiverID = $row['vetID'];
            $key = 'vetID';
            $table ='vet';
          }
          if($row['sellerID'] !=NULL){
            $receiverID = $row['sellerID'];
            $key = 'sellerID';
            $table ='seller';
          }
          if($row['shopID'] !=NULL){
            $receiverID = $row['shopID'];
            $key = 'shopID';
            $table ='pet_shop';
          }

          if($row['name'] !=NULL){
            $receiverName = $row['name'];
          }
          if($row['sname'] !=NULL){
            $receiverName = $row['sname'];
          }
          if($row['shopname'] !=NULL){
            $receiverName = $row['shopname'];
          }

          if($row['vetID'] !=NULL){
              if($row['vimage']!=''){
              $imageData = base64_encode($row['vimage']);
              $imageSrc2 = "data:image/jpg;base64," . $imageData;
              // Check if the image file exists before displaying it
              if (file_exists('vet_images/' . $row['vimage'])) {
                  $imageSrc2 = 'vet_images/' . $row['vimage'];
              }
              }
              else{
                  $imageSrc2='media/email_male.png';
              }
          }
          if($row['sellerID'] !=NULL){
              if($row['simage']!=''){
              $imageData = base64_encode($row['simage']);
              $imageSrc2 = "data:image/jpg;base64," . $imageData;
              // Check if the image file exists before displaying it
              if (file_exists('seller_images/' . $row['simage'])) {
                  $imageSrc2 = 'seller_images/' . $row['simage'];
              }
              }
              else{
                  $imageSrc2='media/pet-shop.png';
              }
          }
          if($row['shopID'] !=NULL){
              if($row['shop_image']!=''){
              $imageData = base64_encode($row['shop_image']);
              $imageSrc2 = "data:image/jpg;base64," . $imageData;
              // Check if the image file exists before displaying it
              if (file_exists('pet_shop_images/' . $row['shop_image'])) {
                  $imageSrc2 = 'pet_shop_images/' . $row['shop_image'];
              }
              }
              else{
                  $imageSrc2='media/pet-shop.png';
              }
          }
      ?>
      <label class="message-menu-container">
      <input type="radio" name="selectedUser" value="<?php echo $receiverID; ?>" onchange="changeColor2(this)">
      <input type="hidden" name="key<?php echo $receiverID?>" value="<?php echo $key ?>">
      <input type="hidden" name="table<?php echo $receiverID?>" value="<?php echo $table ?>">
      <img src="<?php echo $imageSrc2 ?>">
      <p><?php echo $receiverName?></p>
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
    <!---------- User-Chat-Get-Message.php ------------>
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
    var key = $('input[name="key'+ selectedUser +'"]').val(); // Get the value of the role variable
    var table = $('input[name="table'+ selectedUser +'"]').val();

    // Make an AJAX request to the server to get the updated message content
    $.ajax({
      url: 'User-Chat-Get-Message.php',
      type: 'GET',
      data: { selectedUser: selectedUser, key: key, table:table }, // Include the role value in the data object
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
  var adopterID = <?php echo $adopterID; ?>;
  var selectedUser;
  var column;

  $('input[name="selectedUser"]').change(function() {
    selectedUser = $(this).val();
    column = $('input[name="key' + selectedUser + '"]').val();
  });

  retrieveMessages(selectedUser, adopterID, column);

  // Send new message
  $('#send').click(function() {
    var message = $('#message').val();
    sendMessage(message, selectedUser, adopterID, column);
    $('#message').val('');
    console.log(column);
    console.log(selectedUser);
    console.log(adopterID);
  });

  // Poll server for new messages every 2 seconds
  setInterval(function() {
    retrieveMessages(selectedUser, adopterID, column);
  }, 1500);

  setTimeout(scrollToBottom, 1500);
});


    function handleEnter(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
    var message = $('#message').val();
    var adopterID = <?php echo $adopterID; ?>;
    var selectedUser = $('input[name="selectedUser"]:checked').val();
    var column = $('input[name="key' + selectedUser + '"]').val();
    sendMessage(message, selectedUser, adopterID, column);
    $('#message').val('');
  }

  setTimeout(scrollToBottom, 1500);
}


    function retrieveMessages(selectedUser, adopterID,column) {
      $.ajax({
        url: 'User-Chat-Retrieve-Message.php',
        method: 'GET',
        data: { selectedUser: selectedUser, adopterID: adopterID, column:column },
      success: function(response) {
      $('#chatbox').html(response);
        }
      });
      setTimeout(scrollToBottom, 1500);
    }

    function sendMessage(message, selectedUser, adopterID,column) {
      $.ajax({
        url: 'User-Chat-Send-Message.php',
        method: 'POST',
         data: { message: message, selectedUser: selectedUser, adopterID: adopterID, column:column },
      success: function(response) {
        console.log('Message sent');
        console.log(column);
        console.log(selectedUser);
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