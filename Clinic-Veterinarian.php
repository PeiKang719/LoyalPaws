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
<style type="text/css">
  html,body{
    width: 100%;
    height: 100%;
  }
</style>
</head>
<body>
<?php include 'ClinicHeader.php'; ?>
<?php include 'Connection.php'; ?>


<div class="clinic-container">
  <div class="clinic-header" >
      <p class="clinic-vet-font">Vet</p>
  </div>
  <div class="clinic-section">
      <a href="Clinic-Veterinarian.php?c=vet&t=approved"><button class="clinic-approved-pending-button" >Approved</button></a>
      <a href="Clinic-Veterinarian.php?c=vet&t=pending"><button class="clinic-approved-pending-button">Pending</button></a>
  </div>
  <div class="clinic-card-container">
    
<div class="card-part">
  <?php 
        if (isset($_GET['t'])) {
            $t=$_GET['t'];
            if($t=='approved'){
                showVet_Approved($clinicID,$vetID);
            }
            else if($t=='pending'){
                showVet_Pending($clinicID);
            }
        }
        if (!isset($_GET['t'])) {
             showVet_Approved($clinicID,$vetID);
        }
        ?>
</div>

<?php
function showVet_Approved($clinicID,$vetID) {
  include('Connection.php');
  $sql = "SELECT v.vetID,v.name,v.ic,c.name AS cname,v.email,v.phone,v.area,v.image,v.education,v.experience FROM vet v,clinic c WHERE v.clinicID=c.clinicID AND v.ic NOT LIKE 'P.%' AND v.ic NOT LIKE 'F.%' AND v.ic NOT LIKE 'B.%' AND v.ic NOT LIKE 'C.%' AND v.clinicID=$clinicID ORDER BY v.vetID ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
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
            echo '<div class="column">';
            echo '<div class="card">';
            echo '<img src="' . $imageSrc . '" alt="Vet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName">';
            echo '<p><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            echo '<div class="breedIcon">';
            echo '<a href="Clinic-Vet-Profile.php?id=' . $row['vetID'] . '" target="_blank"><span class="material-symbols-outlined" id="card-button">open_in_new</span></a>';
            echo '<iframe name="hiddenFrame3" class="hide"></iframe>';
            if($vetID!=$row['vetID']){
            echo '<a href="Clinic-Veterinarian-Process.php?p=delete&i=' . $row['vetID'] . '" target="hiddenFrame3" onclick="deleteVet(event)"><span class="material-symbols-outlined" id="card-button-delete">delete</span></a>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages
        
    }
    else{ ?>
      <img src="media/no-document.jpg" width="300px" height="300px">
    <?php }
}
  ?>


<?php
function showVet_Pending($clinicID) {
  include('Connection.php');
  $sql = "SELECT v.vetID, v.name, v.ic,v.email, c.name AS cname, v.email, v.phone, v.area,v.apc FROM vet v INNER JOIN clinic c ON v.clinicID = c.clinicID WHERE v.ic LIKE 'C.%' AND v.clinicID=$clinicID ORDER BY v.name";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
          $apc = $row['apc'];
          $id = $row['vetID'];
          $ic = substr($row['ic'], 2);

          $gender=$ic[-1];
          if( $gender% 2 == 0){
            $imageSrc2='media/email_female.png';
          }
          else{
            $imageSrc2='media/email_male.png';
          }?>
  
  <?php echo "<div class='vet-bar'>
    <div class='expand-icon'>❯</div>
    <img class='vet-img' src='$imageSrc2' alt='Vet'>
    <p class='vet-name'>" . $row['name'] . "</p>
    <p class='vet-ic'>" . $ic . "</p>";

    echo "
    <a style='width:12%;' onclick=\"process_vet('approve', '$ic', '" . $row['vetID'] . "')\"><button class='vet-bar-approve'><span class='material-symbols-outlined' style='font-weight: 800;font-size:20px;vertical-align:-3px;color:white'>verified</span>Approved</button></a>";

echo "<a style='width:12%;' onclick=\"process_vet('reject', '$ic', '" . $row['vetID'] . "')\"><button class='vet-bar-approve' style='background-color:red;margin-left:10px'><span class='material-symbols-outlined' style='font-weight: 800;font-size:20px;vertical-align:-3px;color:white'>block</span>Reject</button></a>
   </div>";?>
<?php
   echo "<div class='vet-bar-expand'>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>local_hospital</span>Veterinary Clinic</p>
   <br>
   <p style='margin-left:2.5%'>- " . $row['cname'] . "</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>mail</span>&nbsp;" . $row['email'] . "</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>call</span>&nbsp;" . $row['phone'] . "</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>school</span>&nbsp;Education: -</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>business_center</span>&nbsp;Experience: -</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-2px'>lab_research</span>&nbsp;Area:</p><br>";
       $areas = explode(",", $row["area"]);
    foreach ($areas as $area) {
        echo "<p style='margin-left:2.5%'>- $area</p>";
    }
    echo "
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>badge</span>&nbsp;Annual Practicing Certificate(APC):</p>
   <a style='color:#008ae6;text-decoration: underline;' href='SideBar_Clinic-Downloadpdf.php?file=" . $apc . "'>" . $apc . "</a>
   <br><br><br>
   <br>
   
   </div>";?>
<?php
  }
}
}
?>
</div>
</div>

<script type="text/javascript">
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


function SearchFunction() {
  var input, filter, name, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  name = document.getElementsByClassName("vet-name");

  for (var i = 0; i < name.length; i++) {
    var vetName = name[i].textContent || name[i].innerText;
    var parentElement = name[i].closest(".vet-bar");

    if (vetName.toUpperCase().indexOf(filter) > -1) {
      parentElement.style.display = "";
    } else {
      parentElement.style.display = "none";
    }
  }
}

function process_vet(p, ic, vetID) {
    event.preventDefault(); // Prevent the link from opening

    if (p === 'approve') {
        if (confirm("Are you sure you want to accept this vet from joining your clinic?")) {
            sendRequest(p, ic, vetID);
        } else {
            console.log("User cancelled the approval.");
        }
      }
    else if (p === 'reject') {
        if (confirm("Are you sure you want to reject this vet from joining your clinic?")) {
            sendRequest(p, ic, vetID);
        } else {
            console.log("User cancelled the rejection.");
        }
    }
}

function sendRequest(p, ic, vetID) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", 'Clinic-Veterinarian-Process.php?p=' + p + '&c=' + ic + '&i=' + vetID, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            if (p === 'approve') {
                alert("Vet has been approved to join your clinic.");
                
            } else if (p === 'reject') {
                alert("Vet has been rejected.");
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

function deleteVet(event) {
    event.preventDefault(); // Prevent the link from opening

    if (confirm("Are You Sure To Remove This Vet From This Clinic?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", event.currentTarget.href, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Removed Vet");
                window.location.reload();
            } else {
                alert("Error Removing This Vet");
            }
        };
        xhr.send();
    } else {
        console.log("User cancelled the delete operation.");
    }
}

  var checkbox = document.getElementById('check');
  var columns = document.getElementsByClassName('column');

  function handleCheckboxChange() {
    for (var i = 0; i < columns.length; i++) {
      var column = columns[i];
      if (checkbox.checked) {
        column.classList.add('collapsed');
      } else {
        column.classList.add('collapsed');
      }
    }
  }

  checkbox.addEventListener('change', handleCheckboxChange);

  // Initial call to set the initial state based on the checkbox's initial checked state
  handleCheckboxChange();

   $(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('t');
  var sValue2 = urlParams.get('c');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'approved' && sValue2 === 'vet') {
    $('a[href*="Clinic-Veterinarian.php?c=vet&t=approved"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Clinic-Veterinarian.php?c=vet&t=pending"]').css('border-bottom', '0');
  }
  else if (sValue === 'pending'  && sValue2 === 'vet') {
    $('a[href*="Clinic-Veterinarian.php?c=vet&t=approved"]').css('border-bottom', '0');
    $('a[href*="Clinic-Veterinarian.php?c=vet&t=pending"]').css('border-bottom', '5px solid #00a8de');
  } 
  else{
    $('a[href*="Clinic-Veterinarian.php?c=vet&t=approved"]').css('border-bottom', '5px solid #00a8de');
  }
});
</script>
</body>
</html>