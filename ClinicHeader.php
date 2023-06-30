<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="media/tabIcon.png">
<link rel="stylesheet" type="text/css" href="ClinicHeaderStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  </head>
  
  <body>
    <?php
    include 'Connection.php';
    session_start();
    $vetID = $_SESSION['vetID'];
    $clinicID = $_SESSION['clinicID'];

    $sql="SELECT vetID FROM clinic WHERE vetID=$vetID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $role='Admin';
    }
    else{
      $role='Vet';
    }

    $sql="SELECT * FROM vet WHERE vetID=$vetID";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if($row['image']!=''){
        $imageData = base64_encode($row['image']);
        $imageSrc = "data:image/jpg;base64," . $imageData;
        // Check if the image file exists before displaying it
        if (file_exists('vet_images/' . $row['image'])) {
            $imageSrc = 'vet_images/' . $row['image'];
        }
        }
        else{
          $gender=$row['ic'][-1];
          if( $gender% 2 == 0){
            $imageSrc='media/email_female.png';
          }
          else{
            $imageSrc='media/email_male.png';
          }
        }
    ?>
    <nav>
      <label for="check" class="checkbtn" style="display:block;margin-right: 0px;">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo"><a href="UserHomePage.php"><img src="media/lp.png" width="250" height="70" style="margin-top: -30px;margin-bottom: -33px;"></a></label>
      <ul>
        <li><a href="Login.php">Log Out</a></li>
      </ul>
    </nav>
    <input type="checkbox" id="check">
    <div class="sidebar">
  <img id="profile" src="<?php echo $imageSrc ?>">
  <p id="name" style="margin-top: 5px;"><?php echo $row['name'] ?></p>
  <hr >

  <?php if($role=='Admin'){?>
  <a href="Clinic-Dashboard.php" class="sidebar-item" id="dashboard-link"><span class="material-symbols-outlined" id="sidebar-icon">grid_view</span>&nbsp;Dashboard</a>
  <a href="Clinic-Appointment.php" class="sidebar-item" id="dashboard-link"><span class="material-symbols-outlined" id="sidebar-icon">content_paste</span>&nbsp;Appointment</a>
  <a href="Clinic-Record-List.php" class="sidebar-item" id="billing-link"><span class="material-symbols-outlined" id="sidebar-icon">folder_open</span>&nbsp;Record</a>
  <a href="Clinic-Treatment.php" class="sidebar-item" id="treatment-link"><span class="material-symbols-outlined" id="sidebar-icon">vaccines</span>&nbsp;Treatment</a>
  <a href="Clinic-Report.php?&interval=total" class="sidebar-item" id="report-link"><span class="material-symbols-outlined" id="sidebar-icon">bar_chart</span>&nbsp;Report</a>
  <a href="Clinic-Veterinarian.php" class="sidebar-item" id="veterinarian-link"><span class="material-symbols-outlined" id="sidebar-icon">group</span>&nbsp;Veterinarian</a>
  <a href="Clinic-Chat.php" class="sidebar-item" id="veterinarian-link"><span class="material-symbols-outlined" id="sidebar-icon">chat</span>&nbsp;Message</a>
  <a href="Clinic-Clinic-Profile.php" class="sidebar-item" id="clinic-profile-link"><span class="material-symbols-outlined" id="sidebar-icon">local_hospital</span>&nbsp;Clinic Profile</a>
  <a href="Clinic-Vet-Profile.php?id=<?php echo $vetID ?>" class="sidebar-item" id="vet-profile-link"><span class="material-symbols-outlined" id="sidebar-icon">account_circle</span>&nbsp;My Profile</a>
  <br><br><br><br><br>
<?php }else{?>
  <a href="Clinic-Vet-Dashboard.php" class="sidebar-item" id="dashboard-link"><span class="material-symbols-outlined" id="sidebar-icon">grid_view</span>&nbsp;Dashboard</a>
  <a href="Clinic-Appointment.php" class="sidebar-item" id="dashboard-link"><span class="material-symbols-outlined" id="sidebar-icon">content_paste</span>&nbsp;Appointment</a>
  <a href="Clinic-Record-List.php" class="sidebar-item" id="billing-link"><span class="material-symbols-outlined" id="sidebar-icon">folder_open</span>&nbsp;Record</a>
  <a href="Clinic-Treatment-For-Vet.php" class="sidebar-item" id="treatment-link"><span class="material-symbols-outlined" id="sidebar-icon">vaccines</span>&nbsp;Treatment</a>
  <a href="Clinic-Vet-Report.php" class="sidebar-item" id="report-link"><span class="material-symbols-outlined" id="sidebar-icon">bar_chart</span>&nbsp;Report</a>
  <a href="Clinic-Chat.php" class="sidebar-item" id="veterinarian-link"><span class="material-symbols-outlined" id="sidebar-icon">chat</span>&nbsp;Message</a>
  <a href="Clinic-Vet-Profile.php?id=<?php echo $vetID ?>" class="sidebar-item" id="vet-profile-link"><span class="material-symbols-outlined" id="sidebar-icon">account_circle</span>&nbsp;My Profile</a>
<?php } ?>
</div>

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