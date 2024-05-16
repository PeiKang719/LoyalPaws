<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LoyalPaws</title>
	<link rel="icon" type="image/png" href="../media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="css/UserStyle.css">
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
          include '../Database/Connection.php';  ?>

<?php
 if ($_GET['action']=='insert') {
    
     $sql = "SELECT m.date, m.time,m.clinicID,c.name,c.address,c.state,c.area FROM clinic_appointment m,clinic c WHERE m.clinicID=c.clinicID AND m.appointmentID = (SELECT MAX(appointmentID) FROM clinic_appointment)";
    

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $visit_date=$row['date'];
      $visit_time=$row['time'];
      $clinic_name=$row['name'];
      $address=$row['address'];
      $state=$row['state'];
      $area=$row['area'];
    }
}
    
?>

<div class="booking-container">
    <img src="../media/clinic-appointment.jpg" width="380px" height="380px" style="margin-top: 30px;margin-bottom: 20px;">
    <p class="booking-header" style="color:#248f24">Appointment Scheduled Successful!</p>
    <br>
      <p class="booking-intro" style="font-size:25px">You can reschedule your appointment before the day</p>
      <p class="booking-intro" style="font-size:25px">Details of appointment are included below</p>
    <br><hr style="border:2px solid #d9d9d9"><br>
        <br><br><br>
        <table border="0" width="70%">
            <tr>
                <td class="booking-intro" style="width: 30%;margin-top:0;font-size: 35px;padding: 10px 70px 10px 0;">
                    Visit Date
                </td>
                
                <td class="booking-intro" style="width: 70%;margin-top:0;font-size: 35px;color: black;">
                    <?php echo $visit_date ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Visit Time
                </td>
                
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                   <?php echo $visit_time ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Address
                </td>
                
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;word-wrap: break-word;">
                   <?php echo $address ?>,<?php echo $area ?>,<?php echo $state ?>
                </td>
            </tr>
        </table>
        <br><br><br>
        <div class="booking-choice-container">
            <a href="UserHomePage.php">Back To Home Page</a>
        </div>
</div>
<?php } 

elseif ($_GET['action']=='update') {
    $appointmentID = $_GET['appointmentID'];
    $sql = "SELECT m.date, m.time,m.clinicID,c.name,c.address,c.state,c.area FROM clinic_appointment m,clinic c WHERE m.clinicID=c.clinicID AND m.appointmentID = $appointmentID";
    

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $visit_date=$row['date'];
      $visit_time=$row['time'];
      $clinic_name=$row['name'];
      $address=$row['address'];
      $state=$row['state'];
      $area=$row['area'];
    }
}
    
?>

<div class="booking-container">
    <img src="../media/clinic-appointment.jpg" width="380px" height="380px" style="margin-top: 30px;margin-bottom: 20px;">
    <p class="booking-header" style="color:#248f24">Appointment Rescheduled Successful!</p>
    <br>
      <p class="booking-intro" style="font-size:25px">You can reschedule your appointment before the day</p>
      <p class="booking-intro" style="font-size:25px">Details of appointment are included below</p>
    <br><hr style="border:2px solid #d9d9d9"><br>
        <br><br><br>
        <table border="0" width="70%">
            <tr>
                <td class="booking-intro" style="width: 30%;margin-top:0;font-size: 35px;padding: 10px 70px 10px 0;">
                    Visit Date
                </td>
                
                <td class="booking-intro" style="width: 70%;margin-top:0;font-size: 35px;color: black;">
                    <?php echo $visit_date ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Visit Time
                </td>
                
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                   <?php echo $visit_time ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Address
                </td>
                
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;word-wrap: break-word;">
                   <?php echo $address ?>,<?php echo $area ?>,<?php echo $state ?>
                </td>
            </tr>
        </table>
        <br><br><br>
        <div class="booking-choice-container">
            <a href="UserHomePage.php">Back To Home Page</a>
        </div>
</div>
<?php } 


 elseif ($_GET['action']=='payment') {
    
     $sql = "SELECT cp.date, cp.amount,cp.transactionID,c.name FROM clinic_payment cp,clinic c,record r,clinic_appointment a WHERE cp.recordID=r.recordID AND r.appointmentID=a.appointmentID AND a.clinicID=c.clinicID AND cp.paymentID = (SELECT MAX(paymentID) FROM clinic_payment)";
    

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $date=$row['date'];
      $amount=$row['amount'];
      $transactionID=$row['transactionID'];
      $name=$row['name'];
    }
}
    
?>

<div class="booking-container">
    <div class="success-animation">
<svg class="checkmark4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark3__circle" cx="26" cy="26" r="25" fill="none" /><path class="checkmark3__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" /></svg>
</div>
    <p class="booking-header" style="color:#248f24">Payment Successful!</p>
    <br>
      <p class="booking-intro" style="font-size:25px">Your payment has been processed</p>
      <p class="booking-intro" style="font-size:25px">Details of transaction are included below</p>
    <br><hr style="border:2px solid #d9d9d9"><br>
    <p class="booking-intro" style="margin-top:0;color:black">Transaction No: <?php echo $transactionID ?></p>
        <br><br><br>
        <table border="0" width="70%">
            <tr>
                <td class="booking-intro" style="width: 30%;margin-top:0;font-size: 35px;padding: 10px 70px 10px 0;">
                    Payment Date
                </td>
                
                <td class="booking-intro" style="width: 70%;margin-top:0;font-size: 35px;color: black;">
                    <?php echo $date ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Amount
                </td>
                
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                   RM <?php echo number_format($amount,2) ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Transfer to
                </td>
                
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;word-wrap: break-word;">
                   <?php echo $name ?>
                </td>
            </tr>
        </table>
        <br><br><br>
        <div class="booking-choice-container">
            <a href="UserHomePage.php">Back To Home Page</a>
        </div>
</div>
<?php } ?>
<script type="text/javascript">
    

</script>
</body>
</html>