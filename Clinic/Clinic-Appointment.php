<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
  <link rel="icon" type="image/png" href="../media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="css/ClinicStyle.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<?php include 'ClinicHeader.php'; ?>



<div class="container" style="padding-left:0;padding-right:0;width: 100%;">
  <p class="profile-header" style="margin-left:50px">Appointment</p>
  <div class="manage-appointment-section">
    <a href="Clinic-Appointment.php?appointment=myAppointment">My Appointments</a>
    <?php if($role=='Admin'){ ?>
    <a href="Clinic-Appointment.php?appointment=assigned">Assigned</a>
    <a href="Clinic-Appointment.php?appointment=unassigned">Unassigned</a>  
  <?php } ?>
  </div>
<?php if(isset($_GET['appointment'])){
          if($_GET['appointment']=='assigned'){
            assigned($clinicID,$vetID);
          }
          elseif($_GET['appointment']=='unassigned'){
            unassigned($clinicID,$vetID);
          }
          elseif($_GET['appointment']=='myAppointment'){
            myAppointment($clinicID,$vetID);
          }
}else{
 myAppointment($clinicID,$vetID);
}?>


<?php function myAppointment($clinicID,$vetID){?>
  <?php include '../Database/Connection.php'; ?>

  <table class="treatment-table" border="0" id="treatment-table" style="margin-left: 50px;margin-right: 50px;width: 94%;">
  <th style="width:150px">Date</th>
  <th style="width:280px">Time</th>
  <th style="width:300px">Name</th>
  <th>Description</th>
  <th style="width:100px">Record</th>
  <th colspan="1" style="width: 60px;" > </th>
<?php 
$sql = "SELECT * FROM (SELECT ca.appointmentID,CONCAT(a.firstName, ' ', a.lastName) AS adopterName,ca.description,ca.date,ca.time,a.adopterID,v.name AS vname FROM clinic_appointment ca,adopter a,vet v WHERE ca.vetID=v.vetID AND ca.adopterID = a.adopterID AND ca.vetID = $vetID AND ca.status='Uncompleted' AND ca.vetID IS NOT NULL
  UNION ALL
  SELECT ca.appointmentID,CONCAT(a.firstName, ' ', a.lastName) AS adopterName, ca.description,ca.date,ca.time,a.adopterID,v.name AS vname FROM clinic_appointment ca,adopter a,pet b,vet v WHERE ca.vetID=v.vetID AND ca.petID=b.petID AND b.adopterID = a.adopterID AND ca.vetID = $vetID AND ca.status='Uncompleted' AND ca.vetID IS NOT NULL) AS combined_table ORDER BY combined_table.date,combined_table.time; ";


      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $appointmentID=$row["appointmentID"];
          $adopterName=$row["adopterName"];
          $adopterID=$row["adopterID"];
          $date=$row["date"];
          $description=$row["description"];
          $time=$row["time"];
          $vname=$row["vname"];
          ?>
    <tr>
    <td><?php echo $date?></td>
    <td><?php echo $time?></td>
    <td><?php echo $adopterName?></td>
    <?php if($description==NULL){?>
      <td style="text-align:center"> - </td>
    <?php }else{ ?>
    <td><?php echo $description?></td>
  <?php } ?>
    <td style="text-align: center;"><button class="manage-button" onclick="record(<?php echo $appointmentID ?>)"><span class="material-symbols-outlined" style="font-size:32px">history_edu</span></button></td>
    <td style="text-align:center;"><a href="User-Profile.php?id=<?php echo $adopterID ?>&vid=<?php echo $vetID ?>"><button class="manage-button"><span class="material-symbols-outlined">person</span></button></a></td>
  </tr>      
<?php 
}}else{?>
  <tr>
    <td colspan="6">No assigned appointment yet...</td>
  </tr>
<?php } ?>
 </table>
 </div>
  <?php } ?>

<?php function assigned($clinicID,$vetID){?>
  <?php include '../Database/Connection.php'; ?>

  <table class="treatment-table" border="0" id="treatment-table" style="margin-left: 50px;margin-right: 50px;width: 94%;">
  <th style="width:150px">Date</th>
  <th style="width:280px">Time</th>
  <th style="width:300px">Name</th>
  <th>Description</th>
  <th style="width:100px">Vet</th>
  <th colspan="1" style="width: 170px;" > </th>
<?php 
$sql = "SELECT * FROM (SELECT ca.appointmentID,CONCAT(a.firstName, ' ', a.lastName) AS adopterName,ca.description,ca.date,ca.time,a.adopterID,v.name AS vname FROM clinic_appointment ca,adopter a,vet v WHERE ca.vetID=v.vetID AND ca.adopterID = a.adopterID AND ca.clinicID = $clinicID AND ca.status='Uncompleted' AND ca.vetID IS NOT NULL
  UNION ALL
  SELECT ca.appointmentID,CONCAT(a.firstName, ' ', a.lastName) AS adopterName, ca.description,ca.date,ca.time,a.adopterID,v.name AS vname FROM clinic_appointment ca,adopter a,pet b,vet v WHERE ca.vetID=v.vetID AND ca.petID=b.petID AND b.adopterID = a.adopterID AND ca.clinicID = $clinicID AND ca.status='Uncompleted' AND ca.vetID IS NOT NULL) AS combined_table ORDER BY combined_table.date,combined_table.time; ";


      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $appointmentID=$row["appointmentID"];
          $adopterName=$row["adopterName"];
          $adopterID=$row["adopterID"];
          $date=$row["date"];
          $description=$row["description"];
          $time=$row["time"];
          $vname=$row["vname"];
          ?>
    <tr>
    <td><?php echo $date?></td>
    <td><?php echo $time?></td>
    <td><?php echo $adopterName?></td>
    <?php if($description==NULL){?>
      <td style="text-align:center"> - </td>
    <?php }else{ ?>
    <td><?php echo $description?></td>
  <?php } ?>
    <td style="text-align: center;"><?php echo $vname?></td>
    <td><a href="User-Profile.php?id=<?php echo $adopterID ?>&vid=<?php echo $vetID ?>"><button class="manage-button"><span class="material-symbols-outlined">person</span></button></a> <button class="manage-button" onclick="optionModal(<?php echo $appointmentID ?>)"><span class="material-symbols-outlined">edit</span></button> <a href="Clinic-Appointment-Process.php?action=delete&appointmentID=<?php echo $appointmentID ?>&appointment=assigned" onclick="return confirmDelete();"><button class="manage-button" style="background-color:#e62e00"><span class="material-symbols-outlined">delete</span></button></a></td>

    <td style="width:0;padding: 0;border: 0;">
      <div id="optionModal<?php echo$appointmentID?>" class="modal">
  <!-- Modal content -->
  <div class="modal-content" style="width:40%;height:60%;margin-top: 100px;">
    <div class="modal-header">
      <h2 style="font-size:27px">Edit</h2>
      <span class="close" style="font-size:40px">&times;</span>
      </div>
      <input type="hidden" name="appointmentID" value="<?php echo $appointmentID ?>">
      <div style="width:100%;height: 100%; display: flex;flex-direction: column;justify-content: center;align-items: center;font-size: 35px;">
        <p >Select the option you want to edit:</p>
           <button class="edit-image-choose" id="edit-vet" onclick="editVet(<?php echo $appointmentID ?>);">Vet</button>
           <a class="edit-image-choose" href="Clinic-Appointment-Reschedule.php?appointmentID=<?php echo $appointmentID ?>&appointment=assigned" style="text-align: center;padding-top: 10px;height: 45px;">Appointment date/time</a>
    </div>
  </div>
</div>
    </td>

    <td style="width:0;padding: 0;border: 0;">
      <div id="reassignModal<?php echo$appointmentID?>" class="modal">
  <!-- Modal content -->
  <div class="modal-content" style="animation: scale-in-center 0.3s ;">
    <div class="modal-header">
      <h2 style="font-size:27px">Assign Vet</h2>
      <span class="close" style="font-size:40px">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="treatmentForm" action="Clinic-Appointment-Process.php?action=reassign&appointmentID=<?php echo$appointmentID ?>" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="appointmentID" value="<?php echo $appointmentID ?>">
        <p style="font-size: 25px;">Assign to:</p>
        <div class="treatment-assign-vet-container">
            <?php
            $sql3="SELECT * FROM vet v,clinic_appointment ct WHERE v.vetID=ct.vetID AND v.clinicID=$clinicID AND ct.date='$date' AND ct.time='$time'";
              $result3 = $conn->query($sql3);
              if ($result3->num_rows > 0) {
                $unavailable_vet=[];
              while($row3 = $result3->fetch_assoc()) {
                $unavailable_vet[]=$row3['vetID'];
              }}else{
                $unavailable_vet=[];
              }

            $sql2 = "SELECT * FROM vet WHERE clinicID = $clinicID AND ic REGEXP '^[0-9]+$'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
              // output data of each row
              while($row2 = $result2->fetch_assoc()) {
                $image=$row2["image"];
                $name=$row2["name"];
                $vetID=$row2["vetID"];
                $ic=$row2['ic'];

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
                    $imageSrc2='../media/email_female.png';
                  }
                  else{
                    $imageSrc2='../media/email_male.png';
                  }
                } 
          ?>    
          <?php if(in_array($vetID, $unavailable_vet)){?>
                <label class="assign-vet-container" style="background-color:#d9d9d9;cursor: not-allowed;">
                  <img src="<?php echo $imageSrc2 ?>">
                  <p style="color:#999999"><?php echo $name ?>  <b style="color: #999999;">(Unavailable)</b></p>
                  <input type="radio" name="Unavailable" onchange="changeColor2(this)" value="<?php echo $vetID ?>" disabled>
                </label> 
              <?php }else{?>
                <label class="assign-vet-container">
                  <img src="<?php echo $imageSrc2 ?>">
                  <p><?php echo $name ?></p>
                  <input type="radio" name="vet" onchange="changeColor2(this)" value="<?php echo $vetID ?>">
                </label> 
              <?php }
            }}else{ ?>
                <p>No vet...</p>
              <?php } ?>
    </div>
      <div class="submit-button-container" style="margin-top:3%">
      <button class="submit-button" id="submitbutton<?php echo$appointmentID?>" type="submit">Assign</button>
      <button class="submit-button" id="closebutton<?php echo$appointmentID?>" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>
    </td>
  </tr>      
<?php 
}}else{?>
  <tr>
    <td colspan="6">No assigned appointment yet...</td>
  </tr>
<?php } ?>
 </table>
 </div>
  <?php } ?>


  <?php function unassigned($clinicID,$vetID){?>
    <?php include '../Database/Connection.php'; ?>

  <table class="treatment-table" border="0" id="treatment-table" style="margin-left: 50px;margin-right: 50px;width: 94%;">
  <th style="width:150px">Date</th>
  <th style="width:280px">Time</th>
  <th style="width:300px">Name</th>
  <th>Description</th>
  <th style="width:60px">Vet</th>
  <th colspan="1" style="width: 170px;" > </th>
<?php 
$sql = "SELECT * FROM (SELECT ca.appointmentID,CONCAT(a.firstName, ' ', a.lastName) AS adopterName,ca.description,ca.date,ca.time,a.adopterID FROM clinic_appointment ca,adopter a WHERE ca.adopterID = a.adopterID AND ca.clinicID = $clinicID AND ca.status='Uncompleted' AND ca.vetID IS NULL
  UNION ALL
  SELECT ca.appointmentID,CONCAT(a.firstName, ' ', a.lastName) AS adopterName, ca.description,ca.date,ca.time,a.adopterID FROM clinic_appointment ca,adopter a,pet b WHERE ca.petID=b.petID AND b.adopterID = a.adopterID AND ca.clinicID = $clinicID AND ca.status='Uncompleted' AND ca.vetID IS NULL) AS combined_table ORDER BY combined_table.date,combined_table.time; ";


      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $appointmentID=$row["appointmentID"];
          $adopterName=$row["adopterName"];
          $adopterID=$row["adopterID"];
          $date=$row["date"];
          $description=$row["description"];
          $time=$row["time"];
          ?>
    <tr>
    <td><?php echo $date?></td>
    <td><?php echo $time?></td>
    <td><?php echo $adopterName?></td>
    <?php if($description==NULL){?>
      <td style="text-align:center"> - </td>
    <?php }else{ ?>
    <td><?php echo $description?></td>
  <?php } ?>
    <td><button class="manage-button" onclick="assign_vet(<?php echo $appointmentID ?>)"><span class="material-symbols-outlined">stethoscope</span></button>
    </td>
    <td><a href="User-Profile.php?id=<?php echo $adopterID ?>&vid=<?php echo $vetID ?>"><button class="manage-button"><span class="material-symbols-outlined">person</span></button></a> <a href="Clinic-Appointment-Reschedule.php?appointmentID=<?php echo $appointmentID ?>&appointment=unassigned"><button class="manage-button"><span class="material-symbols-outlined">edit</span></button></a>  <a href="Clinic-Appointment-Process.php?action=delete&appointmentID=<?php echo $appointmentID ?>&appointment=unassigned" onclick="return confirmDelete();"><button class="manage-button" style="background-color:#e62e00"><span class="material-symbols-outlined">delete</span></button></a></td>

    <td style="width: 0px;padding: 0;border:0">
      <div id="assignModal<?php echo$appointmentID?>" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2 style="font-size:27px">Assign Vet</h2>
      <span class="close" style="font-size:40px">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="treatmentForm" action="Clinic-Appointment-Process.php?action=assign" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="appointmentID" value="<?php echo $appointmentID ?>">
        <p style="font-size: 25px;">Assign to:</p>
        <div class="treatment-assign-vet-container">
            <?php
            $sql3="SELECT * FROM vet v,clinic_appointment ct WHERE v.vetID=ct.vetID AND v.clinicID=$clinicID AND ct.date='$date' AND ct.time='$time'";
              $result3 = $conn->query($sql3);
              if ($result3->num_rows > 0) {
                $unavailable_vet=[];
              while($row3 = $result3->fetch_assoc()) {
                $unavailable_vet[]=$row3['vetID'];
              }}else{
                $unavailable_vet=[];
              }

            $sql2 = "SELECT * FROM vet WHERE clinicID = $clinicID AND ic REGEXP '^[0-9]+$'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
              // output data of each row
              while($row2 = $result2->fetch_assoc()) {
                $image=$row2["image"];
                $name=$row2["name"];
                $vetID=$row2["vetID"];
                $ic=$row2['ic'];

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
                    $imageSrc2='../media/email_female.png';
                  }
                  else{
                    $imageSrc2='../media/email_male.png';
                  }
                } 
          ?>    
          <?php if(in_array($vetID, $unavailable_vet)){?>
                <label class="assign-vet-container" style="background-color:#d9d9d9;cursor: not-allowed;">
                  <img src="<?php echo $imageSrc2 ?>">
                  <p style="color:#999999"><?php echo $name ?>  <b style="color: #999999;">(Unavailable)</b></p>
                  <input type="radio" name="Unavailable" onchange="changeColor2(this)" value="<?php echo $vetID ?>" disabled>
                </label> 
              <?php }else{?>
                <label class="assign-vet-container">
                  <img src="<?php echo $imageSrc2 ?>">
                  <p><?php echo $name ?></p>
                  <input type="radio" name="vet" onchange="changeColor2(this)" value="<?php echo $vetID ?>">
                </label> 
              <?php }
            }}else{ ?>
                <p>No vet...</p>
              <?php } ?>
    </div>
      <div class="submit-button-container" style="margin-top:3%">
      <button class="submit-button" id="submitbtn<?php echo$appointmentID?>" type="submit">Assign</button>
      <button class="submit-button" id="closebtn<?php echo$appointmentID?>" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>
    </td>
  </tr>      
<?php 
}}else{?>
  <tr>
    <td colspan="6">No appointment yet...</td>
  </tr>
<?php } ?>
 </table>
 </div>
  <?php } ?>




<script type="text/javascript">
$(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('appointment');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'myAppointment') {
    $('a[href*="Clinic-Appointment.php?appointment=myAppointment"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Clinic-Appointment.php?appointment=unassigned"]').css('border-bottom', '0');
    $('a[href*="Clinic-Appointment.php?appointment=assigned"]').css('border-bottom', '0');
  }
  else if (sValue === 'assigned') {
    $('a[href*="Clinic-Appointment.php?appointment=assigned"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Clinic-Appointment.php?appointment=unassigned"]').css('border-bottom', '0');
    $('a[href*="Clinic-Appointment.php?appointment=myAppointment"]').css('border-bottom', '0');
  } else if (sValue === 'unassigned') {
    $('a[href*="Clinic-Appointment.php?appointment=unassigned"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Clinic-Appointment.php?appointment=assigned"]').css('border-bottom', '0');
    $('a[href*="Clinic-Appointment.php?appointment=myAppointment"]').css('border-bottom', '0');
  }
  else{
    $('a[href*="Clinic-Appointment.php?appointment=myAppointment"]').css('border-bottom', '5px solid #00a8de');
  }
});


function assign_vet(appointmentID){
var modal = document.getElementById("assignModal"+appointmentID);
var close = document.getElementById("closebtn"+appointmentID);
var submit = document.getElementById("submitbtn"+appointmentID);
var span = modal.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 

  modal.style.display = "block"; 

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

close.onclick = function() {
  modal.style.display = "none";
}
}

function changeColor2(radio) {
  var radios = document.getElementsByName(radio.name);
  for (var i = 0; i < radios.length; i++) {
    var radioLabel = radios[i].parentNode;
    if (radios[i].checked) {
      radioLabel.style.backgroundColor = "#cfe8fc";
      radioLabel.style.borderColor = "#6fb9f6";
    } else {
      radioLabel.style.backgroundColor = "white";
      radioLabel.style.borderColor = "#4d4d4d";
    }
  }
}

function confirmDelete() {
  return confirm("Are you sure you want to delete this appointment?"); // Display confirmation dialog
}


function optionModal(appointmentID){
var modal = document.getElementById("optionModal"+appointmentID);
var span = modal.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 

  modal.style.display = "block"; 

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
}

function editVet(appointmentID){
var modal0 = document.getElementById("reassignModal"+appointmentID);
var close0 = document.getElementById("closebutton"+appointmentID);
var submit0 = document.getElementById("submitbutton"+appointmentID);
var span0 = modal0.getElementsByClassName("close")[0];

  modal0.style.display = "block"; 

// When the user clicks on <span> (x), close the modal
span0.onclick = function() {
  modal0.style.display = "none";
}

close0.onclick = function() {
  modal0.style.display = "none";
}
}

function record(i) {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior
    window.location.href = "Clinic-Record.php?appointmentID="+i+"";
  }
</script>

</body>
</html>