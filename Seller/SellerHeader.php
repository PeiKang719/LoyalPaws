<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../media/tabIcon.png">
<link rel="stylesheet" type="text/css" href="../Clinic/css/ClinicHeaderStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  </head>
  
  <body>

     <?php
     $currentURL = $_SERVER['PHP_SELF'];
    if (strpos($currentURL, 'Seller_Pets-Profile.php') === false && strpos($currentURL, 'Seller_Pets.php') === false) {
    session_start();
    if (!isset($_SESSION['sellerID'])) {
      header("Location: ../index.php");
      exit();
  }
    $sellerID = $_SESSION['sellerID'];
    $role = $_SESSION['role'];
    $key = $_SESSION['key'];
}

   else{
    if (!isset($_SESSION['sellerID'])) {
      header("Location: ../index.php");
      exit();
  }
    $sellerID = $_SESSION['sellerID'];
    $role=$_SESSION['role'];
    $key = $_SESSION['key'];
   }
   include '../Database/Connection.php';
   if($role=='seller'){
      $sql = "SELECT CONCAT(firstName,' ',lastName) AS sname ,image FROM seller WHERE sellerID=$sellerID";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $imageData = base64_encode($row['image']);
              $imageSrc = "data:image/jpg;base64," . $imageData;
              if ($row['image']=='') {
                    $imageSrc = '../media/pet-shop.png';
              }
                elseif (file_exists('seller_images/' . $row['image'])) {
                    $imageSrc = 'seller_images/' . $row['image'];
              }
    }
    elseif($role=='pet_shop'){
      $sql = "SELECT shopname AS sname ,shop_image AS image FROM pet_shop WHERE shopID=$sellerID";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $imageData = base64_encode($row['image']);
              $imageSrc = "data:image/jpg;base64," . $imageData;
              if ($row['image']=='') {
                    $imageSrc = '../media/pet-shop.png';
              }
                elseif (file_exists('pet_shop_images/' . $row['image'])) {
                    $imageSrc = 'pet_shop_images/' . $row['image'];
              }
    }
    
    ?>
    
    <nav>
      <label for="check" class="checkbtn" style="display:block;margin-right: 0px;">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo"><a href="Seller_HomePage.php"><img src="../media/lp.png" width="250" height="70" style="margin-top: -30px;margin-bottom: -33px;"></a></label>
      <ul>
        <li><a href="../index.php">Log Out</a></li>
      </ul>
    </nav>
    <input type="checkbox" id="check">
    <aside class="sidebar" >
  <img id="profile" src="<?php echo $imageSrc ?>">
  <p id="name" style="margin-top: 5px;"><?php echo $row['sname'] ?></p>
  <hr>
  <a href="Seller_HomePage.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon" >grid_view</span>&nbsp;Dashboard</a>
 <a href="Seller_Pets.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">pets</span>&nbsp;Pets</a>
 <a href="Seller_Adoption-Form.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">mail</span>&nbsp;Adoption/Lodging</a>
  <a href="Seller_Orders.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">list_alt</span>&nbsp;Orders</a>
  <a href="Seller_Report.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">bar_chart</span>&nbsp;Report</a>
  <a href="Seller-Chat.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">message</span>&nbsp;Message</a>
  <a href="Seller-Seller-Profile.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">account_circle</span>&nbsp;Profile</a>
</aside>

<script>
  // Get the current URL
  var currentUrl = window.location.href;

  // Get all the sidebar links
  var sidebarLinks = document.getElementsByClassName('sidebar-item');

  // Iterate through the sidebar links
  for (var i = 0; i < sidebarLinks.length; i++) {
    var link = sidebarLinks[i];

    // Check if the link's href contains the current URL
    if (currentUrl.includes(link.href)) {
      // Add the "active" class to the link
      link.classList.add('active');
    }
  }
</script>
  </body>
</html>