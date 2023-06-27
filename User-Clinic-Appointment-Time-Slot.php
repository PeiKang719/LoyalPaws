<?php
include('Connection.php');

$date = $_GET['date'];
$cid = $_GET['cid'];

$dayOfWeek = date('l', strtotime($date));
date_default_timezone_set('Asia/Singapore');
$today = date('Y-m-d');
$timeNow = date('h:i a');

     $sql = "SELECT * from clinic where clinicID= $cid ";
     $sql2 = "SELECT a.date,a.time,COUNT(*) AS bookings from clinic_appointment a where a.clinicID= $cid GROUP BY a.date, a.time ORDER BY a.date,STR_TO_DATE(a.time, '%h:%i %p') ";
     $sql3 = "SELECT COUNT(vetID) AS numberOfvet FROM vet WHERE clinicID=$cid";

    $result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $available=$row['work_day'];
      $start=$row['open_time'];
      $end=$row['close_time'];
    }
}
    
    $result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    $visit_date=[];
    $visit_time=[];
    $bookings=[];
    // Fetch all the rows into an array
    $rows2 = $result2->fetch_all(MYSQLI_ASSOC);
    foreach ($rows2 as $row2) {
      $visit_date[]=$row2['date'];
      $visit_time[]=$row2['time'];
      $bookings[]=$row2['bookings'];
    }
}
else{
  $visit_date=[];
$visit_time=[];
$bookings=[];
}

$result3 = $conn->query($sql3);
if ($result3->num_rows > 0) {
    // Fetch all the rows into an array
    $rows3 = $result3->fetch_all(MYSQLI_ASSOC);
    foreach ($rows3 as $row3) {
      $numberOfvet=$row3['numberOfvet'];
    }
}


$availableday = explode(",", $available);
$startTime = explode(",", $start);
$endTime = explode(",", $end);
$index = array_search($dayOfWeek, $availableday);


if($index!== false && $date>=$today){
echo"<br><br><br><br><br>";
$start_time = strtotime($startTime[$index]); // Convert start time to timestamp
$end_time = strtotime($endTime[$index]); // Convert end time to timestamp

$interval = 45 * 60; // 45 minutes in seconds

$current_time = $start_time;
$slots = array();

while ($current_time < $end_time) {
    $slot_start = date('h:i a', $current_time); // Format start time as "9:40 am"
    $slot_end = date('h:i a', $current_time + $interval); // Format end time as "10:10 am"
    
    // Extract the time portion from the end time for comparison
    $end_time_compare = strtotime(date('H:i', $end_time));
    
    if (strtotime($slot_end) > $end_time_compare) {
        break; // Stop generating slots if end time is reached or exceeded
    }
    
    $slot = array(
        'start' => $slot_start,
        'end' => $slot_end
    );
    
    $slots[] = $slot; // Add slot to the array of slots
    
    $current_time += $interval; // Move to the next time slot
}

$n = array_keys($visit_date,$date);
$k=0;

// Display the time slots
foreach ($slots as $slot) {
    if(!empty($n)){
    if($slot['start'] . ' - ' . $slot['end']==$visit_time[$n[$k]] && $date==$visit_date[$n[$k]] && $bookings[$n[$k]]==$numberOfvet){?>
    <label class="radio-container" style="background-color:#cccccc;color: #999999; cursor: not-allowed"><?php echo $slot['start'] . ' - ' . $slot['end'] . '<br>'; ?>
            <input type="radio" name="radio2" onchange="changeColor2(this)" value="<?php echo $slot['start'] . ' - ' . $slot['end'] ?>" disabled style="cursor: not-allowed">
            <span class="checkmark2" style="display:none;"></span>
        </label>
<?php
if($k<count($n)-1){
$k++;}
}   
    elseif($date==$today && strtotime($slot['start'])<=strtotime($timeNow)){?>
        <label class="radio-container" style="background-color:#cccccc;color: #999999; cursor: not-allowed"><?php echo $slot['start'] . ' - ' . $slot['end'] . '<br>'; ?>
            <input type="radio" name="radio2" onchange="changeColor2(this)" value="<?php echo $slot['start'] . ' - ' . $slot['end'] ?>" disabled style="cursor: not-allowed">
            <span class="checkmark2" style="display:none;"></span>
        </label>
<?php
}
else{   ?>
    <label class="radio-container" ><?php echo $slot['start'] . ' - ' . $slot['end'] . '<br>'; ?>
            <input type="radio" name="radio" onchange="changeColor2(this)" value="<?php echo $slot['start'] . ' - ' . $slot['end'] ?>" >
            <span class="checkmark2"></span>
        </label>
<?php
}
}
elseif(empty($n)){
    if($slot['start'] . ' - ' . $slot['end']==$visit_time && $date==$visit_date && $bookings==$numberOfvet ){?>
    <label class="radio-container" style="background-color:#cccccc;color: #999999; cursor: not-allowed"><?php echo $slot['start'] . ' - ' . $slot['end'] . '<br>'; ?>
            <input type="radio" name="radio2" onchange="changeColor2(this)" value="<?php echo $slot['start'] . ' - ' . $slot['end'] ?>" disabled style="cursor: not-allowed">
            <span class="checkmark2" style="display:none;"></span>
        </label>
<?php
if($k<count($n)-1){
$k++;}
}   
    elseif($date==$today && strtotime($slot['start'])<=strtotime($timeNow)){?>
        <label class="radio-container" style="background-color:#cccccc;color: #999999; cursor: not-allowed"><?php echo $slot['start'] . ' - ' . $slot['end'] . '<br>'; ?>
            <input type="radio" name="radio2" onchange="changeColor2(this)" value="<?php echo $slot['start'] . ' - ' . $slot['end'] ?>" disabled style="cursor: not-allowed">
            <span class="checkmark2" style="display:none;"></span>
        </label>
<?php
}
else{   ?>
    <label class="radio-container" ><?php echo $slot['start'] . ' - ' . $slot['end'] . '<br>'; ?>
            <input type="radio" name="radio" onchange="changeColor2(this)" value="<?php echo $slot['start'] . ' - ' . $slot['end'] ?>" >
            <span class="checkmark2"></span>
        </label>
<?php
}
}
}
}

else{
    echo"<p style='font-size:30px;color:red;text-align:center'><span class='material-symbols-outlined' style='font-size:35px;color:red;vertical-align:-7px'>error</span> No available time slot. Please choose another date.</p>";
}


?>


<script type="text/javascript">
    function changeColor2(radio) {
  var radios = document.getElementsByName(radio.name);
  for (var i = 0; i < radios.length; i++) {
    var radioLabel = radios[i].parentNode;
    if (radios[i].checked) {
      radioLabel.style.backgroundColor = "#cfe8fc";
      radioLabel.style.borderColor = "#6fb9f6";
    } else {
      radioLabel.style.backgroundColor = "white";
      radioLabel.style.borderColor = "#b3b3b3";
    }
  }
}
</script>