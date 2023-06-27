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
	<?php include 'ClinicHeader.php';
          include 'Connection.php';  ?>

<?php
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

$appointmentID = $_GET['appointmentID'];
$appointment = $_GET['appointment'];

$sql2 = "SELECT * from clinic_appointment where appointmentID='$appointmentID' ";
  $result2 = $conn->query($sql2);
  $row2 = $result2->fetch_assoc();
  $visit_date=$row2['date'];
  $visit_time=$row2['time'];

?>

<div class="booking-container">
    
    <br><br><br>
    <p class="booking-header">Reschedule appointment</p>
        <p class="booking-header" style="font-weight:normal;font-size: 30px;">[Current Appointment: <?php echo $visit_date ?> <?php echo $visit_time ?>]</p><br>

        <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form id="rescheduleForm" action="Clinic-Appointment-Process.php?action=reschedule" method="post" target="hiddenFrame" enctype="multipart/form-data" style="width:100%">
    <div class="appointment-container">
        <div class="choose-date-container">
            <input type="date" id="dateInput" name="date" style="border:2px solid #4d4d4d;">
            <input type="hidden" id="appointmentID" name="appointmentID" value="<?php echo $appointmentID ?>">
            <input type="hidden" id="appointment" name="appointment" value="<?php echo $appointment ?>">
            <input type="hidden" id="cid" name="cid" value="<?php echo $clinicID ?>">
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
   <hr style="border:2px solid #d9d9d9;margin-left: 150px;width: 80%;">
    <div class="proceed-payment-container" style="padding-top:30px">
        <button class="proceed-payment" id="proceed-payment">Update appointment</button>
</div>
</form>  
</div>


<script type="text/javascript">
  $(document).ready(function() {
    // Listen for changes to the checkboxes
    $('input[type="date"]').change(function() {
      // Get the values of the checked checkboxes
      var date = $('#dateInput').val();
      var cid = $('#cid').val();
      var type = $('#type').val();

      // Make an AJAX request to the server to get the updated time slots
      $.ajax({
        url: 'User-Clinic-Appointment-Time-Slot.php',
        type: 'GET',
        data: { date: date, cid: cid, type: type },
        success: function(response) {
          // Update the time slots with the new HTML
          $('#time-slot').html(response);
        },
        error: function() {
          alert('No available time slots. Please choose another date.');
        }
      });
    });
  });

document.getElementById("proceed-payment").addEventListener("click", function() {
    var confirmed = confirm("Are you sure you want to update the appointment?");
    if (confirmed) {
      // The user confirmed, proceed with form submission
      document.getElementById("rescheduleForm").submit();
    }
  });
</script>
</body>
</html>