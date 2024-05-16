<?php
include('../Database/Connection.php');

$date = $_GET['date'];
$time = $_GET['time'];
;

if(isset($_GET['price'])){
	$price = $_GET['price']?>

<table>
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
	<tr>
		<td style="padding:5px 0">Booking Fee</td>
		<td>:</td>
		<td> RM<?php echo $price ?></td>
	</tr>
</table>
<input type="hidden" name="date" id="date" value="<?php echo $date ?>">
<input type="hidden" name="time" id="time" value="<?php echo $time ?>">

<?php }
else{?>

<table>
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


<?php } ?>




