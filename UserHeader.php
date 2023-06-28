<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="media/tabIcon.png">
<link rel="stylesheet" type="text/css" href="HeaderStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  </head>
  
  <body>
    <?php
    $currentURL = $_SERVER['PHP_SELF'];
    if (strpos($currentURL, 'Seller_Pets-Profile.php') === false && strpos($currentURL, 'SideBar_Breed-Breed-Profile.php') === false) {
    session_start();
    $adopterID = $_SESSION['adopterID'];
  }else{
     $adopterID = $_SESSION['adopterID'];
  }
  include 'Connection.php';
  $sql ="SELECT image FROM adopter WHERE adopterID=$adopterID";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  $imageData = base64_encode($row['image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if ($row['image']=='') {
                  $imageSrc = 'media/profile.png';
            }
              elseif (file_exists('adopter_images/' . $row['image'])) {
                  $imageSrc = 'adopter_images/' . $row['image'];
            }
    ?>
    <nav>
  <input type="checkbox" id="check">
  <label for="check" class="checkbtn">
    <i class="fas fa-bars"></i>
  </label>
  <label class="logo">
    <a href="UserHomePage.php">
      <img src="media/lp.png" width="250" height="70" style="margin-top: -30px;margin-bottom: -33px;">
    </a>
  </label>
  <ul>
    <li class="dropdown">
      <button class="dropbtn">Pet</button>
      <div class="dropdown-content">
        <a href="User-Order-List.php">Order</a>
        <a href="User-Adoption-List.php">Adoption</a>
      </div>
    </li>
    <li><a href="User-Pet-Appointment-List.php">Clinic</a></li>
    <li><a href="User-Chat.php">Message</a></li>
    <li class="dropdown" style="width:120px;text-align: center;">
      <button class="dropbtn" id="profile-icon" style="padding:9px 30px;"><img src="<?php echo $imageSrc ?>" style="width: 50px;height: 50px;border-radius: 50%;border: 1px solid black;vertical-align: -10px;"> </button>
      <div class="dropdown-content">
        <a href="User-Profile.php">Profile</a>
        <a href="Login.php">Log Out</a>
      </div>
    </li>
    
  </ul>
</nav>

  </body>
</html>