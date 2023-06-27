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
$petID = $_GET['id'];
$inquiryID = $_GET['iid'];
 if(isset($_GET['u'])){ 
    $paymentID=$inquiryID;
     $sql7 = "SELECT * from pet_payment where paymentID=$paymentID";
     $result7 = $conn->query($sql7);
     $row7 = $result7->fetch_assoc();
     
     $paymentID = $row7['paymentID'];
     $visit_date = $row7['visit_date'];
     $visit_time = $row7['visit_time'];
 }

     $sql = "SELECT * from seller where sellerID=(Select sellerID from pet where petID='$petID') ";
     $sql3 = "SELECT * from pet_shop where shopID=(Select shopID from pet where petID='$petID') ";
     $sql2 = "SELECT * from pet where petID='$petID' ";

    $result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    $rows2 = $result2->fetch_all(MYSQLI_ASSOC);
    foreach ($rows2 as $row2) {
      $pid=$row2['petID'];
      $img=$row2['pet_image'];
    }
}

if($row2['sellerID']!==NULL){
    $result = $conn->query($sql);
if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $id=$row['sellerID'];
      $available=$row['available'];
      $start=$row['start'];
      $end=$row['end'];
    }
    $type='seller';
}
}
elseif($row2['shopID']!==NULL){
    $result = $conn->query($sql3);
if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $id=$row['shopID'];
      $available=$row['work_day'];
      $start=$row['open_time'];
      $end=$row['close_time'];
    }
    $type='shop';
}
}
$imageData = base64_encode($img);
$imageSrc = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if (file_exists('pet_images/' . $img)) {
    $imageSrc = 'pet_images/' . $img;
}
else{
    $imageSrc = 'media/tabIcon (2).png' ;
}
?>

<div class="booking-container">
    
    <br><br><br>
    <p class="booking-header">Schedule a visit</p>
    <?php if(isset($_GET['u'])){ ?>
        <p class="booking-header" style="font-weight:normal;font-size: 30px;">[Current Appointment: <?php echo $visit_date ?> <?php echo $visit_time ?>]</p>
    <?php } ?>
    <div class="appointment-container">
        <div class="choose-date-container">
            <input type="date" id="dateInput" name="date" style="border:2px solid #4d4d4d;">
            <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
            <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
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
                <td colspan="4"><p class="available-time" style="font-size: 30px;font-weight: bold;color: black;padding-bottom: 10px;">Available Time:</p></td>
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
    <hr style="border:2px solid #d9d9d9">
    <div class="proceed-payment-container">
     <?php if(isset($_GET['u'])){ ?>
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
      <img class="booking-pet-img" src="<?php echo $imageSrc ?>" alt='Pet Image'>
      <?php if(isset($_GET['u'])){ ?>
        <form id="bookingForm" action="User-Adoption-Book-Process.php?c=update&action=<?php echo $paymentID ?>" method="post" enctype="multipart/form-data">
    <?php }else{ ?>
    <form id="bookingForm" action="User-Adoption-Book-Process.php?c=adoption" method="post" enctype="multipart/form-data">
<?php } ?>
      
      <input type="hidden" name="sid" value="<?php echo $id ?>">
      <input type="hidden" name="pid" value="<?php echo $pid ?>">
      <input type="hidden" name="iid" value="<?php echo $inquiryID ?>">
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <!--------------------------------------------Fixed adopter ID 50 here--------------------------------->
      <input type="hidden" name="aid" value="<?php echo $adopterID ?>">
      <div class="confirm-booking-container" id="confirm-booking-container">
      <!--------------User-Adoption-Booking-Modal.php------------------>
  </div>
  <div class="booking-choice-container">
      <button class="booking-choice" type="button" style="background-color: white;color: #4d4d4d;" id="cancel-booking-btn">Cancel</button>
      <button class="booking-choice" type="submit">Book</button>
  </div>
</div>
</div>


<script type="text/javascript">
    

  $(document).ready(function() {
    // Listen for changes to the checkboxes
    $('input[type="date"]').change(function() {
        // Get the values of the checked checkboxes
       
        var date = $('#dateInput').val();
        var id = $('#id').val();
        var type = $('#type').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'User-Adoption-Get-Time-Slot.php',
            type: 'GET',
            data: { date: date , id: id , type: type},
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
        var date = $('#dateInput').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'User-Adoption-Booking-Modal.php',
            type: 'GET',
            data: {time:time, date:date},
            success: function(response) {
                // Update the breed cards with the new HTML
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

// When the user clicks the button, open the modal 
btn8.onclick = function() {
  modal8.style.display = "block"; 
}
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