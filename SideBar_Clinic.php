<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Main page</title>
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="AdminStyle.css">
<link rel="stylesheet" type="text/css" href="ClinicStyle.css">
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

#myTable th{
  cursor: pointer;
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
      <a href="SideBar_Clinic.php?c=clinic&t=approved"><button class="clinic-approved-pending-button" >Approved</button></a>
      <a href="SideBar_Clinic.php?c=clinic&t=pending"><button class="clinic-approved-pending-button">Pending</button></a>
  </div>
  <div class="clinic-card-container">

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
  <div class="clinic-header">
      <p class="clinic-vet-font">Vet</p>
      <a href="SideBar_Clinic.php?c=clinic"><button class="clinic-vet-button" style="left:0;border-radius: 0 6px 6px 0">❮</button> </a>
  </div>
  <div class="clinic-section">
      <a href="SideBar_Clinic.php?c=vet&t=approved"><button class="clinic-approved-pending-button">Approved</button></a>
      <a href="SideBar_Clinic.php?c=vet&t=pending"><button class="clinic-approved-pending-button" >Pending</button></a>
  </div>
  <div class="clinic-card-container">

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
    $sql = "SELECT c.clinicID,c.name,c.clinic_image,c.phone,c.email,c.no_of_patient,v.ic,v.name AS cname FROM clinic c,vet v WHERE c.vetID=v.vetID AND v.ic NOT LIKE 'P.%' AND v.ic NOT LIKE 'F.%' AND v.ic NOT LIKE 'B.%' AND v.ic NOT LIKE 'C.%'  ORDER BY c.clinicID LIMIT $offset, $records_per_page";?>
<div style="width:92%;padding:1% 4%" >
    <br>
  <div class="add-new-treatment-container">
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search By Name" >
</div>
  <br>
  <table class="treatment-table" border="0" id="myTable">
  <th style="width:40px" onclick="sortTable2(0)">ID</th>
  <th style="width:105px">Image</th>
  <th style="width:230px" onclick="sortTable(2)">Name</th>
  <th style="width:40px" onclick="sortTable2(3)">Phone</th>
  <th style="width:40px" onclick="sortTable(4)">Email</th>
  <th style="width:40px" onclick="sortTable2(5)">No of patient</th>
  <th style="width:40px" onclick="sortTable(6)">Admin</th>
  <th colspan="1" style="width: 110px;" > </th>
  <?php 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['clinic_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if($row['clinic_image']==NULL){
                $imageSrc = 'media/clinic-default.png';
            }
            elseif (file_exists('clinic_images/' . $row['clinic_image'])) {
                $imageSrc = 'clinic_images/' . $row['clinic_image'];
            }?>
<tr>
    <td><?php echo $row['clinicID']?></td>
    <td><img src="<?php echo $imageSrc ?>" style="width: 100px;height: 100px;"> </td>
    <td><?php echo $row['name'] ?></td>
    <td><?php echo $row['phone']?></td>
    <td><?php echo $row['email'] ?></td>
    <td style="text-align:center"><?php echo $row['no_of_patient'] ?></td>
    <td><?php echo $row['cname'] ?></td>
    <td><button class="manage-button" onclick="view_clinic(<?php echo$row['clinicID'] ?>)"><span class="material-symbols-outlined">person</span></button>  <a href="SideBar_Clinic-Process.php?p=deleteClinic&i=<?php echo $row['clinicID'] ?>" onclick="confirmDeleteClinic(event);"><button class="manage-button" style="background-color:#e62e00"><span class="material-symbols-outlined">delete</span></button></a></td>
  </tr>      
        

       
    <?php }} 
else{?>
  <tr>
    <td colspan="8">No clinic...</td>
  </tr>
</table>
<?php } ?>
 </table>

<?php } ?>

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
    $sql = "SELECT c.clinicID, c.name, c.clinic_image, v.ic FROM clinic c, vet v WHERE c.clinicID = v.clinicID AND v.ic LIKE 'B.%' ORDER BY c.name LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['clinic_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if($row['clinic_image']==NULL){
                $imageSrc = 'media/clinic-default.png';
            }
            elseif (file_exists('clinic_images/' . $row['clinic_image'])) {
                $imageSrc = 'clinic_images/' . $row['clinic_image'];
            }
            echo '<div class="column">';
            echo '<div class="card">';
            echo '<img src="' . $imageSrc . '" alt="Organization Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName">';
            echo '<p><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            echo '<div class="breedIcon">';
            echo '<a href="SideBar_Clinic-Profile.php?admin=yes&id=' . $row['clinicID'] . '" target="_blank"><span class="material-symbols-outlined" id="card-button">open_in_new</span></a>';
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
    }else{?>
        <div style="width: 100%;display: flex;align-items: center;justify-content: center;">
        <img src="media/no-document.jpg" width="300px" height="300px">
    </div>
    <?php }
}

?>

<?php
function showVet_Approved() {
  include('Connection.php');
?>

   <div style="width:92%;padding:1% 4%" >
    <br>
  <div class="add-new-treatment-container">
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search By Name" >
</div>
  <br>
  <table class="treatment-table" border="0" id="myTable">
  <th style="width:40px" onclick="sortTable2(0)">ID</th>
  <th style="width:105px">Image</th>
  <th style="width:230px" onclick="sortTable(2)">Name</th>
  <th style="width:130px" onclick="sortTable(3)">Clinic</th>
  <th style="width:40px" onclick="sortTable2(4)">Phone</th>
  <th style="width:140px" onclick="sortTable(5)">APC</th>
  <th colspan="1" style="width: 150px;" > </th>
<?php 
include 'Connection.php';
$i=1;
$sql = "SELECT v.vetID,v.name,v.image,v.phone,v.email,c.name AS cname,v.ic,v.apc FROM vet v,clinic c WHERE v.clinicID=c.clinicID  AND v.ic NOT LIKE 'P.%' AND v.ic NOT LIKE 'F.%' AND v.ic NOT LIKE 'B.%' AND v.ic NOT LIKE 'C.%' ORDER BY vetID ";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $sellerID=$row["vetID"];
          $image=$row["image"];
          $firstName=$row["name"];
          $phone=$row["phone"];
          $email=$row["email"];
          $cname=$row["cname"];
          $ic=$row["ic"];
          $apc = $row['apc'];

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
          ?>
    <tr>
    <td><?php echo $sellerID?></td>
    <td><img src="<?php echo $imageSrc2 ?>" style="width: 100px;height: 100px;"> </td>
    <td><?php echo $firstName ?></td>
    <td><?php echo $cname ?></td>
    <td><?php echo $phone?></td>
    <td style="word-wrap: break-word;"><a style="color:#008ae6;text-decoration: underline;" href="SideBar_Clinic-Downloadpdf.php?file=<?php echo $apc ?>"><?php echo $apc ?></a> </td>
    <td><button class="manage-button" onclick="view_vet(<?php echo$sellerID ?>)"><span class="material-symbols-outlined">person</span></button>  <a href="SideBar_Clinic-Process.php?p=deleteVet&i=<?php echo $sellerID ?>" onclick="confirmDeleteVet(event);"><button class="manage-button" style="background-color:#e62e00"><span class="material-symbols-outlined">delete</span></button></a></td>
  </tr>      
<?php $i++;}

}else{?>
  <tr>
    <td colspan="7">No vet...</td>
  </tr>
</table>
<?php } ?>
 </table>
</div>
<?php 
}
?>

<?php
function showVet_Pending() {
  include('Connection.php');
  $sql = "SELECT v.vetID, v.name, v.ic,v.email, c.name AS cname, v.email, v.phone, v.area,v.apc FROM vet v INNER JOIN clinic c ON v.clinicID = c.clinicID WHERE v.ic LIKE 'P.%' OR v.ic LIKE 'B.%' ORDER BY v.name";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $apc = $row['apc'];
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
   <a style='color:#008ae6;text-decoration: underline;' href='SideBar_Clinic-Downloadpdf.php?file=" . $apc . "'>" . $apc . "</a>
   <br><br><br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>mail</span>&nbsp;" . $row['email'] . "</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>call</span>&nbsp;" . $row['phone'] . "</p>
   </div>";
  }
}else{?>
    <div style="width: 100%;display: flex;align-items: center;justify-content: center;">
        <img src="media/no-document.jpg" width="300px" height="300px">
    </div>
<?php
}
}
?>
</div>
</div>

<script>


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
        column.classList.add('collapsed');
      } else {
        column.classList.add('collapsed');
      }
    }
  }

  checkbox.addEventListener('change', handleCheckboxChange);

  // Initial call to set the initial state based on the checkbox's initial checked state
  handleCheckboxChange();

   function view_vet(i) {
    window.location.href = "Clinic-Vet-Profile.php?vetid="+ i+"&admin=yes";

  } 

  function confirmDeleteVet(event) {
  event.preventDefault();
    if (confirm("Are You Sure To Delete This Vet Information?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", event.currentTarget.href, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Deleted Vet Information");
                window.location.reload();
            } else {
                alert("Error Deleting Vet Information");
            }
        };
        xhr.send();
    } else {
        console.log("User cancelled the Vet operation.");
    }
}

function SearchFunction() {
  var input, filter, table, tr, td2, i, txtValue , txtValue2;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {

    td2 = tr[i].getElementsByTagName("td")[2];

   if (td2) {
      txtValue2 = td2.textContent || td2.innerText;
      if (txtValue2.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      }  else {
        tr[i].style.display = "none";
      }
    }     
    }      
    }
     
 function view_clinic(i) {
    window.location.href = "SideBar_Clinic-Profile.php?id="+ i+"&admin=yes";

  } 

  function confirmDeleteClinic(event) {
  event.preventDefault();
    if (confirm("Are You Sure To Delete This Clinic Information?\nAll the veterinarians under this clinic will be removed.")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", event.currentTarget.href, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Deleted Clinic Information");
                window.location.reload();
            } else {
                alert("Error Deleting Clinic Information");
            }
        };
        xhr.send();
    } else {
        console.log("User cancelled the Clinic operation.");
    }
}


  $(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('t');
  var sValue2 = urlParams.get('c');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'approved' && sValue2 === 'clinic') {
    $('a[href*="SideBar_Clinic.php?c=clinic&t=approved"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="SideBar_Clinic.php?c=clinic&t=pending"]').css('border-bottom', '0');
  }
  else if (sValue === 'pending'  && sValue2 === 'clinic') {
    $('a[href*="SideBar_Clinic.php?c=clinic&t=approved"]').css('border-bottom', '0');
    $('a[href*="SideBar_Clinic.php?c=clinic&t=pending"]').css('border-bottom', '5px solid #00a8de');
  } 
  else{
    $('a[href*="SideBar_Clinic.php?c=clinic&t=approved"]').css('border-bottom', '5px solid #00a8de');
  }
});

  $(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('t');
  var sValue2 = urlParams.get('c');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'approved' && sValue2 === 'vet') {
    $('a[href*="SideBar_Clinic.php?c=vet&t=approved"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="SideBar_Clinic.php?c=vet&t=pending"]').css('border-bottom', '0');
  }
  else if (sValue === 'pending'  && sValue2 === 'vet') {
    $('a[href*="SideBar_Clinic.php?c=vet&t=approved"]').css('border-bottom', '0');
    $('a[href*="SideBar_Clinic.php?c=vet&t=pending"]').css('border-bottom', '5px solid #00a8de');
  } 
  else{
    $('a[href*="SideBar_Clinic.php?c=vet&t=approved"]').css('border-bottom', '5px solid #00a8de');
  }
});



function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function sortTable2(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from the current row and one from the next: */
      x = parseFloat(rows[i].getElementsByTagName("TD")[n].innerHTML);
      y = parseFloat(rows[i + 1].getElementsByTagName("TD")[n].innerHTML);
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x > y) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x < y) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

</script>
</body>

</html>
