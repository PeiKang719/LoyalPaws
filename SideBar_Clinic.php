<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Main page</title>
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="AdminStyle.css">
<link rel="icon" type="image/png" href="media/tabIcon.png">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style type="text/css">
  html,body{
    width: 100%;
    height: 100%;
  }
</style>
<body style="background-color:white;">

<?php include 'AdminHeader.php'; ?>


 <?php 
        if (isset($_GET['c'])) {
            $c=$_GET['c'];
            if($c=='clinic'){
                showClinicTab();
            }
            else if($c=='vet'){
                showVetTab();
            }
        }
        if (!isset($_GET['c'])) {
            showClinicTab();
        }
        ?>

  <?php function showClinicTab(){ ?>
<div class="clinic-container">
  <div class="clinic-header">
      <p class="clinic-vet-font">Clinic</p>
      <a href="SideBar_Clinic.php?c=vet"><button class="clinic-vet-button" style="right:0;border-radius:6px 0 0 6px">❯</button> </a>
  </div>
  <div class="clinic-section">
      <a href="SideBar_Clinic.php?c=clinic&t=approved"><button class="clinic-approved-pending-button" style="border-right: 1px solid #4d4d4d;">Approved</button></a>
      <a href="SideBar_Clinic.php?c=clinic&t=pending"><button class="clinic-approved-pending-button">Pending</button></a>
  </div>
  <div class="clinic-card-container">
    <div class="search-part">
  <input type="text" class="search" placeholder="Search For Clinic" id="organization-search" list="clinic-list">
<datalist id="clinic-list">
  <?php
  // Connect to the database
  include('Connection.php');

  $sql = "SELECT clinicID,name FROM clinic ORDER BY name";
  $result = mysqli_query($conn, $sql);

  // Loop through the results and populate the datalist options
  while ($row = mysqli_fetch_assoc($result)) {
    // Check if breedID exists before adding it as a data attribute
    $clinicID = isset($row['clinicID']) ? 'data-clinicid="' . $row['clinicID'] . '"' : '';
    echo '<option value="' . $row['name'] . '" ' . $clinicID . '>' . $row['name'] . '</option>';
  }

  // Close the database connection
  mysqli_close($conn);
  ?>
</datalist>
</div>
<div class="card-part">
  <?php 
        if (isset($_GET['t'])) {
            $t=$_GET['t'];
            if($t=='approved'){
                showClinic_Approved();
            }
            else if($t=='pending'){
                showClinic_Pending();
            }
        }
        if (!isset($_GET['t'])) {
             showClinic_Approved();
        }
        ?>
</div>
<?php } ?>

<?php function showVetTab(){ ?>
<div class="clinic-container">
  <div class="clinic-header" style="height: 15.3%;">
      <p class="clinic-vet-font">Vet</p>
      <a href="SideBar_Clinic.php?c=clinic"><button class="clinic-vet-button" style="left:0;border-radius: 0 6px 6px 0">❮</button> </a>
  </div>
  <div class="clinic-section" style="height: 5.5%;">
      <a href="SideBar_Clinic.php?c=vet&t=approved"><button class="clinic-approved-pending-button">Approved</button></a>
      <a href="SideBar_Clinic.php?c=vet&t=pending"><button class="clinic-approved-pending-button" style="border-left: 1px solid #4d4d4d;">Pending</button></a>
  </div>
  <div class="clinic-card-container">
    <div class="search-part">
  <input type="text" class="search" placeholder="Search For Vet" id="organization-search" list="clinic-list">
<datalist id="clinic-list">
  <?php
  // Connect to the database
  include('Connection.php');

  $sql = "SELECT vetID,name FROM vet ORDER BY name";
  $result = mysqli_query($conn, $sql);

  // Loop through the results and populate the datalist options
  while ($row = mysqli_fetch_assoc($result)) {
    // Check if breedID exists before adding it as a data attribute
    $clinicID = isset($row['clinicID']) ? 'data-clinicid="' . $row['clinicID'] . '"' : '';
    echo '<option value="' . $row['name'] . '" ' . $clinicID . '>' . $row['name'] . '</option>';
  }

  // Close the database connection
  mysqli_close($conn);
  ?>
</datalist>
</div>
<div class="card-part">
  <?php 
        if (isset($_GET['t'])) {
            $t=$_GET['t'];
            if($t=='approved'){
                showVet_Approved();
            }
            else if($t=='pending'){
                showVet_Pending();
            }
        }
        if (!isset($_GET['t'])) {
             showVet_Approved();
        }
        ?>
</div>
<?php } ?>

<?php
function showClinic_Approved() {
    include('Connection.php');
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "SELECT count(c.clinicID) as total FROM clinic c,vet v WHERE c.vetID=v.vetID AND v.ic NOT LIKE 'P.%' AND v.ic NOT LIKE 'F.%' AND v.ic NOT LIKE 'B.%' AND v.ic NOT LIKE 'C.%'";
    
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT c.clinicID,c.name,c.clinic_image,v.ic FROM clinic c,vet v WHERE c.vetID=v.vetID AND v.ic NOT LIKE 'P.%' AND v.ic NOT LIKE 'F.%' AND v.ic NOT LIKE 'B.%' AND v.ic NOT LIKE 'C.%'  ORDER BY c.name LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['clinic_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('clinic_images/' . $row['clinic_image'])) {
                $imageSrc = 'clinic_images/' . $row['clinic_image'];
            }
            echo '<div class="column">';
            echo '<div class="card">';
            echo '<img src="' . $imageSrc . '" alt="Organization Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName">';
            echo '<p><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            echo '<div class="breedIcon">';
            echo '<a href="SideBar_Clinic-Profile.php?id=' . $row['clinicID'] . '" target="_blank"><span class="material-symbols-outlined" id="card-button">open_in_new</span></a>';
            echo '<iframe name="hiddenFrame3" class="hide"></iframe>';
            echo '<a href="SideBar_Donation-Delete-Organization.php?id=' . $row['clinicID'] . '" target="hiddenFrame3" onclick="deleteOrganization(event)"><span class="material-symbols-outlined" id="card-button-delete">delete</span></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages
        echo '<div class="pagination">';
        
        if($page==1){
          
        }
        else{
          echo '<a href="SideBar_Donation.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo '<a href="SideBar_Donation.php?page=' . $i . '" class="page-active">' . $i . '</a>';
        } else {
            echo '<a href="SideBar_Donation.php?page=' . $i . '">' . $i . '</a>';
        }
  }
    if($page == $total_pages){
       
    }
    else{
        echo '<a href="SideBar_Donation.php?page=' . ($page+1) . '"> &gt;</a>';
     }
        echo '</div>';
    }
}

?>

<?php
function showClinic_Pending() {
    include('Connection.php');
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "SELECT count(c.clinicID) as total FROM clinic c JOIN vet v ON c.vetID = v.vetID WHERE v.ic LIKE 'P.%' OR v.ic LIKE 'B.%'";
    
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT c.clinicID, c.name, c.clinic_image, v.ic FROM clinic c JOIN vet v ON c.vetID = v.vetID WHERE v.ic LIKE 'P.%' OR v.ic LIKE 'B.%' ORDER BY c.name LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['clinic_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('clinic_images/' . $row['clinic_image'])) {
                $imageSrc = 'clinic_images/' . $row['clinic_image'];
            }
            echo '<div class="column">';
            echo '<div class="card">';
            echo '<img src="' . $imageSrc . '" alt="Organization Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName">';
            echo '<p><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            echo '<div class="breedIcon">';
            echo '<a href="SideBar_Donation-Organization-Profile.php?id=' . $row['clinicID'] . '" target="_blank"><span class="material-symbols-outlined" id="card-button">open_in_new</span></a>';
            echo '<a href="SideBar_Donation-Edit-Modal.php?id=' . $row['clinicID'] . '" target="_blank"><span class="material-symbols-outlined" id="card-button-edit">edit</span>';
            echo '<iframe name="hiddenFrame3" class="hide"></iframe>';
            echo '<a href="SideBar_Donation-Delete-Organization.php?id=' . $row['clinicID'] . '" target="hiddenFrame3" onclick="deleteOrganization(event)"><span class="material-symbols-outlined" id="card-button-delete">delete</span></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages
        echo '<div class="pagination">';
        
        if($page==1){
          
        }
        else{
          echo '<a href="SideBar_Donation.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo '<a href="SideBar_Donation.php?page=' . $i . '" class="page-active">' . $i . '</a>';
        } else {
            echo '<a href="SideBar_Donation.php?page=' . $i . '">' . $i . '</a>';
        }
  }
    if($page == $total_pages){
       
    }
    else{
        echo '<a href="SideBar_Donation.php?page=' . ($page+1) . '"> &gt;</a>';
     }
        echo '</div>';
    }
}

?>

<?php
function showVet_Approved() {
  include('Connection.php');
  $sql = "SELECT v.name,v.ic,c.name AS cname,v.email,v.phone,v.area,v.education,v.experience,v.image FROM vet v,clinic c WHERE v.clinicID=c.clinicID AND v.ic NOT LIKE 'P.%' AND v.ic NOT LIKE 'F.%' AND v.ic NOT LIKE 'B.%' AND v.ic NOT LIKE 'C.%' ORDER BY v.name ";

    $result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $education=$row['education'];
      $experience=$row['experience'];
      $image=$row['image'];
      $ic=$row['ic'];


      if ($education=='') {
        $education='-';
        }
        if ($experience=='') {
          $experience='-';
        }

        if($image!=''){
        $imageData = base64_encode($image);
        $imageSrc2 = "data:image/jpg;base64," . $imageData;
        // Check if the image file exists before displaying it
        if (file_exists('vet_images/' . $image)) {
            $imageSrc2 = 'vet_images/' . $image;
        }
        }
        else{
          $gender=$ic[-1];
          if( $gender% 2 == 0){
            $imageSrc2='media/email_female.png';
          }
          else{
            $imageSrc2='media/email_male.png';
          }
        }

   echo" <div class='vet-bar'><div class='expand-icon'>❯</div>
   <img class='vet-img' src='$imageSrc2' alt='Vet'>
   <p class='vet-name'>" . $row['name'] . "</p>
   <p class='vet-ic'>" . $row['ic'] . "</p>
   <button class='vet-bar-delete'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-6px;color:white'>delete</span>Delete</button>
   </div>";
   echo "<div class='vet-bar-expand'>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>local_hospital</span>Veterinary Clinic</p><br>
   <p style='margin-left:2.5%'>- " . $row['cname'] . "</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>mail</span>&nbsp;" . $row['email'] . "</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>call</span>&nbsp;" . $row['phone'] . "</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>school</span>&nbsp;Education:</p><br>";
   if($education=='-'){
      echo "<p style='margin-left:2.5%;'>$education</p>";
   }
   else{
    $educations = explode("$", $education);
    echo "<table class='eduTable' border=0>";
    foreach ($educations as $edu) {
        $details = explode("^", $edu);
        echo "<tr>";
        echo "<td width=15%><p class='year'>$details[0]</p></td>";
        echo "<td width=85%><p class='edu'>$details[1]</p></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td><p class='location'>$details[2]</p></td>";
        echo "</tr>";
    }
    echo "</table>";
  }
    echo "
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>business_center</span>&nbsp;Experience:</p><br>";
   if($experience=='-'){
      echo "<p style='margin-left:2.5%;'>$experience</p>";
   }
   else{
    $experiences = explode("$", $experience);
    echo "<table class='eduTable' border=0>";
    foreach ($experiences as $exp) {
        $edetails = explode("^", $exp);
        echo "<tr>";
        echo "<td width=15%><p class='year'>$edetails[0]</p></td>";
        echo "<td width=85%><p class='edu'>$edetails[1]</p></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td><p class='location'>$edetails[2]</p></td>";
        echo "</tr>";
    }
    echo "</table>";
  }
    echo "
    <br>
    <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-2px'>lab_research</span>&nbsp;Area:</p><br>";
   $areas = explode(",", $row["area"]);
    foreach ($areas as $area) {
        echo "<p style='margin-left:2.5%'>- $area</p>";
    }
    echo "
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>badge</span>&nbsp;Annual Practicing Certificate(APC):</p>
   <br>
   <p class='vet-apc' style='margin-left:3.5%'>Click to view</p>
   <p class='vet-apc' style='margin-left:3.5%'>Click to download</p>

   </div>";
  }?>
<?php   
}
}
?>

<?php
function showVet_Pending() {
  include('Connection.php');
  $sql = "SELECT v.vetID, v.name, v.ic,v.email, c.name AS cname, v.email, v.phone, v.area FROM vet v INNER JOIN clinic c ON v.clinicID = c.clinicID WHERE v.ic LIKE 'P.%' OR v.ic LIKE 'B.%' ORDER BY v.name";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
          $ic = substr($row['ic'], 2);

          $gender=$ic[-1];
          if( $gender% 2 == 0){
            $imageSrc2='media/email_female.png';
          }
          else{
            $imageSrc2='media/email_male.png';
          }          
 echo "<div class='vet-bar'>
    <div class='expand-icon'>❯</div>
    <img class='vet-img' src='$imageSrc2' alt='Vet'>
    <p class='vet-name'>" . $row['name'] . "</p>
    <p class='vet-ic'>" . $ic . "</p>";


if (str_starts_with($row['ic'], 'P')) {
    echo "<a style='width:12%;' onclick=\"process_vet('approve', '$ic', " . $row['vetID'] . ",'" . $row['email'] . "','" . $row['name'] . "')\"><button class='vet-bar-approve'><span class='material-symbols-outlined' style='font-weight: 800;font-size:20px;vertical-align:-3px;color:white'>verified</span>Approved</button></a>";
} else if (str_starts_with($row['ic'], 'B')) {
    echo "<a style='width:12%;' onclick=\"process_vet('approve-clinic', '$ic', " . $row['vetID'] . ",'" . $row['email'] . "','" . $row['name'] . "')\"><button class='vet-bar-approve'><span class='material-symbols-outlined' style='font-weight: 800;font-size:20px;vertical-align:-3px;color:white'>verified</span>Approved</button></a>";
}

echo "<a style='width:12%;' onclick=\"process_vet('reject', '$ic', " . $row['vetID'] . ",'" . $row['email'] . "','" . $row['name'] . "')\"><button class='vet-bar-approve' style='background-color:red;margin-left:10px'><span class='material-symbols-outlined' style='font-weight: 800;font-size:20px;vertical-align:-3px;color:white'>block</span>Reject</button></a>
   </div>";

   echo "<div class='vet-bar-expand'>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>local_hospital</span>Veterinary Clinic</p>
   <p style='margin-left:2.5%'>- " . $row['cname'] . "</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-2px'>lab_research</span>&nbsp;Area:</p>";
       $areas = explode(",", $row["area"]);
    foreach ($areas as $area) {
        echo "<p style='margin-left:2.5%'>- $area</p>";
    }
    echo "
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>school</span>&nbsp;Education:</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>business_center</span>&nbsp;Experience:</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>badge</span>&nbsp;Annual Practicing Certificate(APC):</p>
   <p class='vet-apc' style='margin-left:3.5%'>Click to view</p>
   <p class='vet-apc' style='margin-left:3.5%'>Click to download</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>mail</span>&nbsp;" . $row['email'] . "</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>call</span>&nbsp;" . $row['phone'] . "</p>
   </div>";
  }
}
}
?>
</div>
</div>

<script>

var organizationInput = document.getElementById('organization-search');
var organizationList = document.getElementById('clinic-list');

organizationInput.addEventListener('change', function() {
  // Get the selected option
  var selectedOption = organizationList.querySelector('option[value="' + organizationInput.value + '"]');
  
  // Check if an option was selected
  if (selectedOption !== null) {
    // Redirect to the breed profile page with the selected breedID
    var clinicID = selectedOption.getAttribute('data-clinicid');
    window.open('SideBar_Clinic-Profile.php?id=' + clinicID, '_blank');
    organizationInput.value = "";
  }
});

 jQuery(function ($) {

  var $vet_bar = $('.vet-bar');
  var $vet_bar_expand = $('.vet-bar-expand');


  $vet_bar.click(function(){
    if ($(event.target).hasClass('vet-bar-approve')) {
      return;
    }
    // Hide all vet_bar_expands
    $vet_bar_expand.slideUp();

    // Check if this vet_bar_expand is already open
    if($(this).hasClass('open')){
      // If already open, remove 'open' class and hide vet_bar_expand
      $(this).removeClass('open')
             .next($vet_bar_expand).slideUp();
    // If it is not open...
    }else{
      // Remove 'open' class from all other vet_bars
      $vet_bar.removeClass('open');
      // Open this vet_bar_expand and add 'open' class
      $(this).addClass('open')
             .next($vet_bar_expand).slideDown();
           
    }
  });

});

function process_vet(p, ic, vetID,email,name) {
    event.preventDefault(); // Prevent the link from opening

    if (p === 'approve') {
        if (confirm("Are you sure you want to verify this vet's information?")) {
            sendRequest(p, ic, vetID,email,name);
        } else {
            console.log("User cancelled the approval.");
        }
    } else if (p === 'approve-clinic') {
        if (confirm("Are you sure you want to verify this vet's and clinic's registration?")) {
            sendRequest(p, ic, vetID,email,name);
        } else {
            console.log("User cancelled the rejection.");
        }
    }
    else if (p === 'reject') {
        if (confirm("Are you sure you want to reject this vet's registration?")) {
            sendRequest(p, ic, vetID,email,name);
        } else {
            console.log("User cancelled the rejection.");
        }
    }
}

function sendRequest(p, ic, vetID,email,name) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", 'SideBar_Clinic-Process.php?p=' + p + '&c=' + ic + '&i=' + vetID+ '&e=' + email+ '&name=' + name, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            if (p === 'approve') {
                alert("Vet has been approved.");
                sendApprovalEmail(email, name);
            } else if (p === 'reject') {
                alert("Vet has been rejected.");
            }
            if (p === 'approve-clinic') {
                alert("Vet and clinic has been approved.");
                sendApprovalEmail(email, name);
            } else if (p === 'reject') {
                alert("Vet and clinic has been rejected.");
            }
            window.location.reload();
        } else {
            if (p === 'approve') {
                alert("Failed to approve vet.");
            } else if (p === 'reject') {
                alert("Failed to reject vet.");
            }
        }
    };
    xhr.send();
}

function sendApprovalEmail(email, name) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", 'Email_Success.php?email=' + email + '&name=' + name, true);
    xhr.send();
}

  var checkbox = document.getElementById('check');
  var columns = document.getElementsByClassName('column');

  function handleCheckboxChange() {
    for (var i = 0; i < columns.length; i++) {
      var column = columns[i];
      if (checkbox.checked) {
        column.classList.remove('collapsed');
      } else {
        column.classList.add('collapsed');
      }
    }
  }

  checkbox.addEventListener('change', handleCheckboxChange);

  // Initial call to set the initial state based on the checkbox's initial checked state
  handleCheckboxChange();
</script>

</script>
</body>

</html>
