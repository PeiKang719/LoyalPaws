<?php
include('Connection.php');

$clinic_name = $_GET['clinic_name'];
$selectedPet = $_GET['selectedPet'];
$appointment_description = $_GET['appointment_description'];
$appointmentID = $_GET['appointmentID'];
if(!empty($_GET['date']) && !empty($_GET['time'])){
	$date = $_GET['date'];
	$time = $_GET['time'];
}else{
	$sql="SELECT date,time FROM clinic_appointment WHERE appointmentID=$appointmentID";
	$result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $date=$row['date'];
    $time=$row['time'];
}
?>

<table>
	<tr>
		<td style="padding:5px 0">Clinic</td>
		<td>:</td>
		<td><?php echo $clinic_name ?></td>
	</tr>
	<tr>
		<td style="padding:5px 0">Visit Date</td>
		<td>:</td>
		<td><?php echo $date ?></td>
	</tr>
	<tr>
		<td style="padding:5px 0">Visit Time</td>
		<td>:</td>
		<td><?php echo $time ?></td>
	</tr>

</table>
<input type="hidden" name="date" id="date" value="<?php echo $date ?>">
<input type="hidden" name="time" id="time"  value="<?php echo $time ?>">
<input type="hidden" name="selectedPet" id="selectedPet"  value="<?php echo $selectedPet ?>">
<input type="hidden" name="appointment_description" id="appointment_description"  value="<?php echo $appointment_description ?>">
