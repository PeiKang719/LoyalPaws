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
  }
    ?>
    <nav>
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo"><a href="UserHomePage.php"><img src="media/lp.png" width="250" height="70" style="margin-top: -30px;margin-bottom: -33px;"></a></label>
      <ul>
        <li><a href="User-Pet-Appointment-List.php">Clinic</a></li>
        <li><a href="User-Order-List.php"> Order</a></li>
        <li><a href="User-Adoption-List.php"> Adoption</a></li>
        <li><a href="User-Profile.php"> Profile</a></li>
        <li><a href="Login.php"> Log Out</a></li>
      </ul>
    </nav>
  </body>
</html>