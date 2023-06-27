<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LoyalPaws</title>
	<link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="UserStyle.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
  function openChatModal() {
    var modal = document.getElementById("chatModal");
    modal.style.display = "block";
}

function closeChatModal() {
  var modal = document.getElementById("chatModal");
  
  modal.classList.add("exit-animation");
  setTimeout(function() {
    modal.style.display = "none";
    modal.classList.remove("exit-animation");
  }, 500); // Delay of 0.5 seconds (500 milliseconds)

}
</script>
</head>

<body>

<?php if(isset($_GET['id'])) {
        $adopterID=$_GET['id'];
        
      }
      else{
         include 'UserHeader.php' ;
      } ?>
<?php if(isset($_GET['sid'])) {
        $sid=$_GET['sid'];
        include 'SellerHeader.php';
      }
      if(isset($_GET['vid'])) {
        $vid=$_GET['vid'];
        include 'ClinicHeader.php';
      } ?>
   <?php
      include 'Connection.php';
      $sql = "SELECT a.adopterID,a.username,a.password,a.firstName,a.lastName,a.dob,a.state,a.area,a.phone,a.email,a.image,COUNT(CASE WHEN p.purpose = 'Sell' THEN p.petID END) AS sellCount,COUNT(CASE WHEN p.purpose = 'Rehome' THEN p.petID END) AS rehomeCount FROM adopter AS a LEFT JOIN pet AS p ON a.adopterID = p.adopterID WHERE a.adopterID =$adopterID; ";
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    if ($result->num_rows > 0) {
    foreach ($rows as $row) { 
          $imageData = base64_encode($row['image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if ($row['image']=='') {
                  $imageSrc = 'media/profile.png';
            }
              elseif (file_exists('adopter_images/' . $row['image'])) {
                  $imageSrc = 'adopter_images/' . $row['image'];
            }
        $adopterID=$row['adopterID'];
        $username=$row['username'];
        $password=$row['password'];
        $firstName=$row['firstName'];
        $lastName=$row['lastName'];
        $dob=$row['dob'];
        $state=$row['state'];
        $area=$row['area'];
        $phone=$row['phone'];
        $email=$row['email'];
        $image=$row['image'];
        $sellCount=$row['sellCount'];
        $rehomeCount=$row['rehomeCount'];
      }
    }
        ?>
        
<div class="user-profile-container">
  <h1>Profile</h1>
  <br>
  <div class="user-profile">
    <img src="<?php echo $imageSrc ?>" alt="Profile-pic">
    <?php if(!isset($_GET['sid']) && !isset($_GET['vid'])){?>
    <div style="cursor: pointer;"  id="upload-button"><span class="material-symbols-outlined">edit_square</span>Edit Image</div>
  <?php }
  else{?>
    <div style="text-align: center;margin-top: 30px;width: 35%;">
  <button class="seller-chat-button" onclick="openChatModal()"><span class="material-symbols-outlined" style="vertical-align:-7px;color: white;" >chat</span>Chat</button><br><br>
</div>
  <?php } ?>
  <?php if(!isset($_GET['id'])) {?>
    <table border="0">
      <tr>
        <td width="4%"><span class="material-symbols-outlined">account_circle</span></td>
        <td width="15%">Username</td>
        <td width="3%">:</td>
        <td colspan="2"><?php echo $username ?></td>
      </tr>
      <tr>
        <td><span class="material-symbols-outlined">key</span></td>
        <td>Password</td>
        <td>:</td>
        <td colspan="2"><button class="change-password" id="password-button">Change Password</button></td>
      </tr>
      <tr>
        <td><span class="material-symbols-outlined">person</span></td>
        <td>Name</td>
        <td>:</td>
        <td colspan="2"><?php echo $firstName ?> <?php echo $lastName ?></td>
      </tr>
      <tr>
        <td><span class="material-symbols-outlined">mail</span></td>
        <td>Email</td>
        <td>:</td>
        <td colspan="2"><?php echo$email ?></td>
      </tr>
      <tr>
        <td><span class="material-symbols-outlined">calendar_month</span></td>
        <td>Date of Birth</td>
        <td>:</td>
        <td width="70%"><?php echo $dob ?></td>
        <td><span class="material-symbols-outlined" id="edit-button3" style="cursor: pointer;">edit</span></td>
      </tr>
      <tr>
        <td><span class="material-symbols-outlined">distance</span></td>
        <td>Location</td>
        <td>:</td>
        <td><?php echo$state ?> <span style='font-size:20px;'>&#9679;</span> <?php echo$area ?></td>
        <td><span class="material-symbols-outlined"  id="edit-button2" style="cursor: pointer;">edit</span></td>
      </tr>
      <tr>
        <td><span class="material-symbols-outlined" >call</span></td>
        <td>Phone</td>
        <td>:</td>
        <td><?php echo$phone ?></td>
        <td><span class="material-symbols-outlined" id="edit-button1" style="cursor: pointer;">edit</span></td>
      </tr>
      
    </table>
  <?php }else{ ?>
    <table border="0">
      <tr>
        <td><span class="material-symbols-outlined">person</span></td>
        <td>Name</td>
        <td>:</td>
        <td ><?php echo $firstName ?> <?php echo $lastName ?></td>
      </tr>
      <tr>
        <td><span class="material-symbols-outlined">mail</span></td>
        <td>Email</td>
        <td>:</td>
        <td ><?php echo$email ?></td>
      </tr>
      <tr>
        <td><span class="material-symbols-outlined">calendar_month</span></td>
        <td>Date of Birth</td>
        <td>:</td>
        <td width="70%"><?php echo $dob ?></td>

      </tr>
      <tr>
        <td><span class="material-symbols-outlined">distance</span></td>
        <td>Location</td>
        <td>:</td>
        <td><?php echo$state ?> <span style='font-size:20px;'>&#9679;</span> <?php echo$area ?></td>

      </tr>
      <tr>
        <td><span class="material-symbols-outlined" >call</span></td>
        <td>Phone</td>
        <td>:</td>
        <td><?php echo$phone ?></td>
        
      </tr>
    </table>
  <?php } ?>
  </div>
  
</div>



<div id="picModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Profile Picture Preview</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="picForm" action="User-Profile-Edit.php?c=pic" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $adopterID ?>">
      
        <input class="file-upload" name="img" type="file" accept="image/*"/ style="display:none">
        <img class="profile-preview" name="img" src="<?php echo $imageSrc ?>"  alt="Profile image" >
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn6" type="submit">Submit</button>
      <button class="submit-button" id="closebtn6" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="passwordModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      
      <h2>Change Password</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide"></iframe>
    <form class="passwordForm" id="passwordForm" action="User-Profile-Edit.php?c=password" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $adopterID ?>">
      <table border="0">
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">key</span></td>
          <td  style="width: 36%;"><label>Current Password</label></td>
          <td>:</td>
          <td style="width:55%"><input type="password" oninput="this.className = ''" name="old" required></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">lock</span></td>
          <td><label>New Password</label></td>
          <td>:</td>
          <td><input type="password" oninput="this.className = ''" name="new1" required></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">lock</span></td>
          <td><label>Confirm Password</label></td>
          <td>:</td>
          <td><input type="password" oninput="this.className = ''" name="new2" required></td>
        </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn1" type="submit">Submit</button>
      <button class="submit-button" id="closebtn1" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="phoneModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Phone Number</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="phoneForm" action="User-Profile-Edit.php?c=phone" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $adopterID ?>">
      <table border="0">
        <tr>
          <td ><span class="material-symbols-outlined" style="font-size:30px">call</span></td>
          <td style="width: 36%;"><label>Current Phone No.</label></td>
          <td>:</td>
          <td style="width:55%"><p><?php echo$phone ?></p></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">call</span></td>
          <td><label>New Phone No.</label></td>
          <td>:</td>
          <td><input type="text" oninput="this.className = ''" name="phone" required></td>
        </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn2" type="submit">Submit</button>
      <button class="submit-button" id="closebtn2" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="addressModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Clinic Address</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="addressForm" action="User-Profile-Edit.php?c=address" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $adopterID ?>">
        <table border="0">
        <tr>
          <td ><span class="material-symbols-outlined" style="font-size:30px">Distance</span></td>
          <td style="width: 36%;"><label>Current Location</label></td>
          <td>:</td>
          <td style="width:55%" colspan="2"><p><?php echo $area ?> <span style='font-size:20px;'>&#9679;</span> <?php echo $state ?></p></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">Distance</span></td>
          <td><label>New Location</label></td>
          <td>:</td>
          <td><select name="state" required >
              <option value="" disabled selected>Select state</option>
              <option>Johor</option>
              <option>Melaka</option>
              <option>Kuala Lumpur</option>
          </select>
          </td>
          <td>
           <select name="area" required >
              <option value="" disabled selected>Select area</option>
              <option>Johor Bahru</option>
              <option>Batu Pahat</option>
              <option>Segamat</option>
          </select>
        </td>
        </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn3" type="submit">Submit</button>
      <button class="submit-button" id="closebtn3" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="dobModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Your Birthday</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="dobForm" action="User-Profile-Edit.php?c=dob" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $adopterID ?>">
      <table border="0">
        <tr>
          <td ><span class="material-symbols-outlined" style="font-size:30px">call</span></td>
          <td style="width: 36%;"><label>Date of Birth</label></td>
          <td>:</td>
          <td style="width:55%"><p><?php echo$dob ?></p></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">call</span></td>
          <td><label>New Date of Birth</label></td>
          <td>:</td>
          <td><input type="date" oninput="this.className = ''" name="dob" required></td>
        </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn4" type="submit">Submit</button>
      <button class="submit-button" id="closebtn4" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>


<div id="chatModal" class="chat-modal">
    <?php
    include 'Connection.php';
    if (isset($_GET['sid']) || isset($_GET['vid'])) {

        $sql = "SELECT * FROM adopter WHERE adopterID = $adopterID"; 
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $name = $row['firstName']." ".$row['lastName'];

        if($row['image']==NULL){
      $imageSrc = 'media/profile.png';
    }
      elseif (file_exists('pet_shop_images/' . $row['image'])) {
          $imageSrc = 'adopter_images/' . $row['image'];
    }
  }
    ?>

    <!-- Modal content -->
    <div class="chat-modal-content">
        <div class="chat-modal-header">
          <img src="<?php echo $imageSrc ?>">
            <h2 style="color:white"><?php echo $name ?></h2>
            <span class="close" onclick="closeChatModal()">&times;</span>
        </div>
        <div class="message-container"  id="chatbox">
        
        </div>
        <div class="chat-button-container">
        <input type="text" id="message" placeholder="Type your message" onkeydown="handleEnter(event)">
      <button id="send">Send  <span class="material-symbols-outlined" id="send-icon">send</span></button>
    </div>
    </div>
</div>


<?php if (isset($sid)) { ?>
<script>
  $(document).ready(function() {
    // Retrieve initial chat messages
    var sellerID = <?php echo $sid; ?>;
    var adopterID = <?php echo $adopterID; ?>;
    var key = '<?php echo $key; ?>';
    retrieveMessages(sellerID, adopterID,key);

    // Send new message
    $('#send').click(function() {
      var message = $('#message').val();
      sendMessage(message, sellerID, adopterID,key);
      $('#message').val('');

    });
    // Poll server for new messages every 2 seconds
    setInterval(function() {
      retrieveMessages(sellerID, adopterID,key);
    }, 1500);
    setTimeout(scrollToBottom, 1500);
  });

  function handleEnter(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      var message = $('#message').val();
      var sellerID = <?php echo $sid; ?>;
      var adopterID = <?php echo $adopterID; ?>;
      var key = '<?php echo $key; ?>';
      sendMessage(message, sellerID, adopterID,key);
      $('#message').val('');
    }

    setTimeout(scrollToBottom, 1500);
  }

  function retrieveMessages(sellerID, adopterID,key) {
    $.ajax({
      url: 'chat-non-user-get-message.php',
      method: 'GET',
      data: { sellerID: sellerID, adopterID: adopterID,key:key },
      success: function(response) {
        $('#chatbox').html(response);
      }
    });
    setTimeout(scrollToBottom, 1500);
  }

  function sendMessage(message, sellerID, adopterID,key) {
    $.ajax({
      url: 'chat-non-user-send-message.php',
      method: 'POST',
      data: { message: message, sellerID: sellerID, adopterID: adopterID, key:key },
      success: function(response) {
        console.log('Message sent');
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
<?php } 

elseif (isset($vid)) { ?>
<script>
  $(document).ready(function() {
    // Retrieve initial chat messages
    var sellerID = <?php echo $vid; ?>;
    var adopterID = <?php echo $adopterID; ?>;
    var column = 3;
    retrieveMessages(sellerID, adopterID, column);

    // Send new message
    $('#send').click(function() {
      var message = $('#message').val();
      sendMessage(message, sellerID, adopterID, column);
      $('#message').val('');

    });
    // Poll server for new messages every 2 seconds
    setInterval(function() {
      retrieveMessages(sellerID, adopterID, column);
    }, 1500);
    setTimeout(scrollToBottom, 1500);
  });

  function handleEnter(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      var message = $('#message').val();
      var sellerID = <?php echo $vid; ?>;
      var adopterID = <?php echo $adopterID; ?>;
      var column = 3;
      sendMessage(message, sellerID, adopterID, column);
      $('#message').val('');
    }

    setTimeout(scrollToBottom, 1500);
  }

  function retrieveMessages(sellerID, adopterID, column) {
    $.ajax({
      url: 'chat-non-user-get-message.php',
      method: 'GET',
      data: { sellerID: sellerID, adopterID: adopterID, column:column },
      success: function(response) {
        $('#chatbox').html(response);
      }
    });
    setTimeout(scrollToBottom, 1500);
  }

  function sendMessage(message, sellerID, adopterID, column) {
    $.ajax({
      url: 'chat-non-user-send-message.php',
      method: 'POST',
      data: { message: message, sellerID: sellerID, adopterID: adopterID, column:column },
      success: function(response) {
        console.log('Message sent');
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
<?php } 

 elseif (!isset($sid) && !isset($vid)) { ?>
<script>
var modal6 = document.getElementById("picModal");
var btn6 = document.getElementById("upload-button");
var close6 = document.getElementById("closebtn6");
var submit6 = document.getElementById("submitbtn6");
var span6 = modal6.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn6.onclick = function() {
  modal6.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span6.onclick = function() {
  modal6.style.display = "none";
  document.getElementById("picForm").reset();
  window.location.reload();
}

close6.onclick = function() {
  modal6.style.display = "none";
  document.getElementById("picForm").reset();
  window.location.reload();
}

  var modal = document.getElementById("passwordModal");
var btn = document.getElementById("password-button");
var close = document.getElementById("closebtn1");
var submit = document.getElementById("submitbtn1");
var span = modal.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  document.getElementById("passwordForm").reset();
  window.location.reload();
}

close.onclick = function() {
  modal.style.display = "none";
  document.getElementById("passwordForm").reset();
  window.location.reload();
}

submit.onclick = function() {
  setTimeout(function() {
    document.getElementById("passwordForm").reset();
  }, 500);
};

var modal2 = document.getElementById("phoneModal");
var btn2 = document.getElementById("edit-button1");
var close2 = document.getElementById("closebtn2");
var submit2 = document.getElementById("submitbtn2");
var span2 = modal2.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn2.onclick = function() {
  modal2.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span2.onclick = function() {
  modal2.style.display = "none";
  document.getElementById("phoneForm").reset();
  window.location.reload();
}

close2.onclick = function() {
  modal2.style.display = "none";
  document.getElementById("phoneForm").reset();
  window.location.reload();
}

submit2.onclick = function() {
  setTimeout(function() {
    document.getElementById("phoneForm").reset();
  }, 500);
};

var modal3 = document.getElementById("addressModal");
var btn3 = document.getElementById("edit-button2");
var close3 = document.getElementById("closebtn3");
var submit3 = document.getElementById("submitbtn3");
var span3 = modal3.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn3.onclick = function() {
  modal3.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span3.onclick = function() {
  modal3.style.display = "none";
  document.getElementById("addressForm").reset();
  window.location.reload();
}

close3.onclick = function() {
  modal3.style.display = "none";
  document.getElementById("addressForm").reset();
  window.location.reload();
}

submit3.onclick = function() {
  setTimeout(function() {
    document.getElementById("addressForm").reset();
  }, 500);
};

var modal4 = document.getElementById("dobModal");
var btn4 = document.getElementById("edit-button3");
var close4= document.getElementById("closebtn4");
var submit4= document.getElementById("submitbtn4");
var span4 = modal4.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn4.onclick = function() {
  modal4.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span4.onclick = function() {
  modal4.style.display = "none";
  document.getElementById("addressForm").reset();
  window.location.reload();
}

close4.onclick = function() {
  modal4.style.display = "none";
  document.getElementById("addressForm").reset();
  window.location.reload();
}

submit4.onclick = function() {
  setTimeout(function() {
    document.getElementById("addressForm").reset();
  }, 500);
};


$(document).ready(function() {

    
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-preview').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    

    $(".file-upload").on('change', function(){
        readURL(this);
    });
    
    $("#upload-button").on('click', function() {
       $(".file-upload").click();
    });
});
</script>
<?php } ?>
</body>
</html>
