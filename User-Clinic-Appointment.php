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
</head>
<style type="text/css">
	html,body{
		height: 100%;
	}
</style>
<body>
	<?php include 'UserHeader.php';
          include 'Connection.php';  ?>

<?php
$clinicID = $_GET['cid'];
if(isset($_GET['purpose'])){
    $appointmentID = $_GET['appointmentID'];
    $sql7 = "SELECT * from clinic_appointment where appointmentID='$appointmentID' ";
    $result7 = $conn->query($sql7);
    $row7 = $result7->fetch_assoc();
    $visit_date=$row7['date'];
    $visit_time=$row7['time'];
    $description=$row7['description'];
    $pet=$row7['petID'];
}

$sql = "SELECT * from clinic where clinicID='$clinicID' ";

    $result = $conn->query($sql);
if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $available=$row['work_day'];
      $start=$row['open_time'];
      $end=$row['close_time'];
      $img=$row['clinic_image'];
      $clinic_name=$row['name'];
    }
}

$imageData = base64_encode($img);
$imageSrc2 = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if (file_exists('clinic_images/' . $img)) {
    $imageSrc2 = 'clinic_images/' . $img;
}
else{
    $imageSrc2 = 'media/clinic-default.png' ;
}
?>

<div class="booking-container">
    
    <br><br><br>
    <?php if(isset($_GET['purpose'])){ ?>
    <p class="booking-header">Reschedule appointment</p>
    <input type="hidden" name="appointmentID" id="appointmentID" value="<?php echo $appointmentID ?>">
<?php }else{ ?>
    <p class="booking-header">Schedule appointment</p>
     <input type="hidden" name="appointmentID" id="appointmentID" value="NULL">
<?php } ?>
    <?php if(isset($_GET['purpose'])){ ?>
        <p class="booking-header" style="font-weight:normal;font-size: 30px;">[Current Appointment: <?php echo $visit_date ?> <?php echo $visit_time ?>]</p>
    <?php } ?>
    <div class="appointment-container">
        <div class="choose-date-container">
            <input type="date" id="dateInput" name="date" style="border:2px solid #4d4d4d;">
            <input type="hidden" id="cid" name="cid" value="<?php echo $clinicID ?>">
            <input type="hidden" id="clinic_name" name="clinic_name" value="<?php echo $clinic_name ?>">
            <div class="time-slot" id="time-slot" >
               <p style="font-size:30px;"><span class="material-symbols-outlined" style="font-size:35px;vertical-align:-7px">today</span> Please select a date.</p> 
            </div>
        </div>

        <div class="available-time-border">
        <table >
            <tr>
        <?php       $days = explode(",", $available);
                    $opens = explode(",", $start);
                    $closes = explode(",", $end);
                    $date = array("Sunday", "Monday", "Tuesday","Wednesday","Thursday","Friday","Saturday");
                     $count = count($days);?>
                <td colspan="4"><p class="available-time" style="font-size: 30px;font-weight: bold;color: black;padding-bottom: 10px;">Working Hours:</p></td>
            </tr>
            <tr>
                <?php
                $i=0;
                for($j = 0; $j < count($date); $j++) {
                    
                            if(in_array($date[$j], $days) && $j==0){
                        echo "<td ><p class='available-time'> Sunday </p></td>";
                        echo "<td align=center><p class='available-time'> $opens[$i] </p></td>";
                        echo "<td align=center><p class='available-time' > - </p></td>";
                        echo "<td align=center><p class='available-time' > $closes[$i] </p></td></tr>";
                        $i++;
                        }
                            elseif(!in_array($date[$j], $days) && $j==0){
                        echo "<td ><p class='available-time' style='padding:10px 0px'> Sunday </p></td>";
                        echo "<td colspan=3 align=center><p class='available-time' style='padding:10px 0px'>Closed </p></td></tr>";
                        }
                            elseif(in_array($date[$j], $days) && $j>0){
                        echo "<tr>";
                        echo "<td ><p class='available-time'> $date[$j] </p></td>";
                        echo "<td align=center><p class='available-time'> $opens[$i] </p></td>";
                        echo "<td align=center><p class='available-time' > - </p></td>";
                        echo "<td align=center><p class='available-time' > $closes[$i] </p></td></tr>";
                        $i++;
                        }
                            else{
                        echo "<tr>";
                        echo "<td ><p class='available-time' > $date[$j] </p></td>";
                        echo "<td colspan=3 align=center><p class='available-time'>Closed </p></td></tr>";
                        }
                    }
                
                        ?>
        
        </table>
        </div>  
    </div>
    <hr style="border:2px solid #d9d9d9"><br><br>
    <p class="booking-header">Select your pet</p>
    <div style="width: 90%;padding: 1% 5%;font-size: 20px;text-align: center;">
    <p>By booking your clinic appointment with your adopted pet, you'll automatically be eligible for our <b>Adopter Exclusive Discount</b>. This discount is our way of recognizing your commitment to providing a loving home to a shelter animal.</p></div>
    <br><br>
        <div class="exclusive-discount-pet-container">
            <?php
            $sql = "SELECT p.petID,b.name,p.gender,p.pet_image from pet p,breed b,adopter a where p.breedID=b.breedID AND p.adopterID=a.adopterID AND p.adopterID=$adopterID ";

                $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($rows as $row) {
                  $petID=$row['petID'];
                  $name=$row['name'];
                  $gender=$row['gender'];
                  $pet_image=$row['pet_image'];

                $imageData = base64_encode($pet_image);
                $imageSrc = "data:image/jpg;base64," . $imageData;
                // Check if the image file exists before displaying it
                if (file_exists('pet_images/' . $pet_image)) {
                    $imageSrc = 'pet_images/' . $pet_image;
                }
                ?>

<?php if(isset($_GET['purpose'])){
            if($petID==$pet){ ?>
           <label class="exclusive-discount-pet" style="background-color:#e7f3fd;border:#b8dcf9;box-shadow:0px 0px 12px rgba(0, 0, 0, 0.3)">
               <input type="radio" name="selectedPet" value="<?php echo $petID; ?>" onchange="changeColor2(this)" checked>
           <?php }else{ ?>
            <label class="exclusive-discount-pet">
               <input type="radio" name="selectedPet" value="<?php echo $petID; ?>" onchange="changeColor2(this)">
           <?php }}else{ ?>
            <label class="exclusive-discount-pet">
               <input type="radio" name="selectedPet" value="<?php echo $petID; ?>" onchange="changeColor2(this)">
           <?php } ?>
               <img src="<?php echo$imageSrc?>">
               <div class="exclusive-discount-pet-name-container">
                <?php
                if($gender=='Male'){?>
            <p><span class="material-symbols-outlined" style="font-size:35px;vertical-align:-7px;color:#1ab2ff;font-weight: 800;">male</span><b><?php echo $name?></b></p>
            <?php
            }else if($gender=='Female'){?>
            <p><span class="material-symbols-outlined" style="font-size: 35px; vertical-align: -7px; color: #ff99ff; font-weight: 800;">female</span><b><?php echo $name?></b></p>
            <?php }?>
           </div>
           </label>
           <?php }}else{?>
                <p style="font-size: 27px;margin-top:5%;margin-bottom:5%;margin-left:41.5%">No adopted pet...</p>
           <?php } ?>

           <?php if(isset($_GET['purpose'])){
            if($pet==0){ ?>
           <label class="exclusive-discount-pet" style="background-color:#e7f3fd;border:#b8dcf9;box-shadow:0px 0px 12px rgba(0, 0, 0, 0.3)">
                 <input type="radio" name="selectedPet" value="0" onchange="changeColor2(this)" checked>
               <img src="media/no-pet.png">
               <div class="exclusive-discount-pet-name-container">      
            <p><b>Other Pet</b></p>
           </div>
           </label>
       <?php }else{?>
            <label class="exclusive-discount-pet">
                 <input type="radio" name="selectedPet" value="0" onchange="changeColor2(this)">
               <img src="media/no-pet.png">
               <div class="exclusive-discount-pet-name-container">      
            <p><b>Other Pet</b></p>
           </div>
           </label>
       <?php }}else{?>
        <label class="exclusive-discount-pet">
                 <input type="radio" name="selectedPet" value="0" onchange="changeColor2(this)">
               <img src="media/no-pet.png">
               <div class="exclusive-discount-pet-name-container">      
            <p><b>Other Pet</b></p>
           </div>
           </label>
       <?php } ?>
        </div><br><br>
        <hr style="border:2px solid #d9d9d9"><br><br>
    <p class="booking-header">Description of pet</p>
    <br>
        <div class="appointment-description-container">

            <textarea rows="4" id="appointment_description"><?php if(isset($_GET['purpose'])){ echo $description; }?></textarea>
        </div>
    <div class="proceed-payment-container">
     <?php if(isset($_GET['purpose'])){ ?>
        <button class="proceed-payment" id="proceed-payment">Update appointment</button>
    <?php }else{ ?>
    <button class="proceed-payment" id="proceed-payment">Book appointment</button>
<?php } ?>
</div>
  
</div>


<!--Confirm Payment Modal-->
<div id="ConfirmModal" class="modal" style="padding-top:70px">
  <!-- Modal content -->
  <div class="modal-content" style="width:50%;height:auto">
    <div class="modal-header">
      <h2>Confirm Booking</h2>
      <span class="close">&times;</span>
      </div>
      <img class="booking-pet-img" src="<?php echo $imageSrc2 ?>" alt='Pet Image' style="width: 200px;height: 150px;">
      <?php if(isset($_GET['purpose'])){ ?>
        <form id="bookingForm" action="User-Clinic-Appointment-Process.php?action=update&appointmentID=<?php echo $appointmentID?>" method="post" enctype="multipart/form-data">
    <?php }else{ ?>
    <form id="bookingForm" action="User-Clinic-Appointment-Process.php?action=insert" method="post" enctype="multipart/form-data">
<?php } ?>
      
      <input type="hidden" name="cid" value="<?php echo $clinicID ?>">
      <input type="hidden" name="aid" value="<?php echo $adopterID ?>">
      <div class="confirm-booking-container" id="confirm-booking-container" style="background-color: #eef3f5 !important;">
      <!--------------User-Adoption-Booking-Modal.php------------------>
  </div>

  <div class="booking-choice-container">
      <button class="booking-choice" type="button" style="background-color: white;color: #4d4d4d;" id="cancel-booking-btn">Cancel</button>
      <button class="booking-choice" type="submit">Book</button>
  </div>
  </form>
</div>
</div>


<script type="text/javascript">
     function changeColor2(radio) {
  var radios = document.getElementsByName(radio.name);
  for (var i = 0; i < radios.length; i++) {
    var radioLabel = radios[i].parentNode;
    if (radios[i].checked) {
      radioLabel.style.backgroundColor = "#e7f3fd";
      radioLabel.style.borderColor = "#b8dcf9";
      radioLabel.style.boxShadow = "0px 0px 12px rgba(0, 0, 0, 0.3)";
    } else {
      radioLabel.style.backgroundColor = "white";
      radioLabel.style.borderColor = "#b3b3b3";
      radioLabel.style.boxShadow = "0px 0px 6px rgba(0, 0, 0, 0.2)";
    }
  }
}

  $(document).ready(function() {
    // Listen for changes to the checkboxes
    $('input[type="date"]').change(function() {
        // Get the values of the checked checkboxes
       
        var date = $('#dateInput').val();
        var cid = $('#cid').val();
        var type = $('#type').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'User-Clinic-Appointment-Time-Slot.php',
            type: 'GET',
            data: { date: date , cid: cid , type: type},
            success: function(response) {
                // Update the breed cards with the new HTML
                $('#time-slot').html(response);
            },
            error: function() {
                alert('No available time.Please choose another date.');
            }
        });
    });

    $('#proceed-payment').click(function() {
        var time = $('input[name="radio"]:checked').val();
        var selectedPet = $('input[name="selectedPet"]:checked').val();
        var date = $('#dateInput').val();
        var clinic_name = $('#clinic_name').val();
        var appointment_description = $('#appointment_description').val();
        var appointmentID = $('#appointmentID').val();

        if (!time || !selectedPet || !date || !clinic_name || !appointment_description || !appointmentID) {
            alert('Please fill out all fields.');
            return; // Exit the function if any data is null
        }

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'User-Clinic-Booking-Modal.php',
            type: 'GET',
            data: {time:time, date:date, clinic_name:clinic_name, selectedPet:selectedPet, appointment_description:appointment_description, appointmentID:appointmentID},
            success: function(response) {
                // Update the breed cards with the new HTML
                $('#ConfirmModal').css('display', 'block');
                $('#confirm-booking-container').html(response);
            },
            error: function() {
                alert('Error getting booking details.Please make sure all information have been filled.');
            }
        });
    });
});

var modal8 = document.getElementById("ConfirmModal");
var btn8 = document.getElementById("proceed-payment");
var btn9 = document.getElementById("cancel-booking-btn");
var span8 = modal8.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span8.onclick = function() {
  modal8.style.display = "none";
}
btn9.onclick = function() {
  modal8.style.display = "none";
}
</script>
</body>
</html>