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
 if ($_GET['i']=='purchase') {
     $sql = "SELECT m.paymentID, m.book_date,p.price,m.transactionId FROM pet_payment m,pet p WHERE m.petID=p.petID AND m.paymentID = (SELECT MAX(paymentID) FROM pet_payment)";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $payment_id=$row['paymentID'];
      $transactionId=$row['transactionId'];
      $price=$row['price'];
      $book_date=$row['book_date'];
    }
}
?>

<div class="booking-container">
    <div class="success-animation">
<svg class="checkmark4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark3__circle" cx="26" cy="26" r="25" fill="none" /><path class="checkmark3__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" /></svg>
</div>
    <p class="booking-header" style="color:#248f24">Booking Payment Successful!</p>
    <br>
      <p class="booking-intro" style="font-size:25px">Your payment has been processed</p>
      <p class="booking-intro" style="font-size:25px">Details of transaction are included below</p>
    <br><hr style="border:2px solid #d9d9d9"><br>
        <p class="booking-intro" style="margin-top:0;color:black">Transaction No: <?php echo $transactionId ?></p>
        <br><br><br>
        <table border="0">
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Total Paid
                </td>
                <td width="30%"></td>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                    RM<?php echo number_format((float)$price*0.10, 2, '.', ''); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Transaction Date
                </td>
                <td width="30%"></td>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                    <?php echo $book_date ?>
                </td>
            </tr>
        </table>
        <br><br><br>
        <div class="booking-choice-container">
            <a href="UserHomePage.php">Back To Home Page</a>
        </div>
</div>
<?php }
 elseif ($_GET['i']=='adoption') {
    if(isset($_GET['mid'])){
        $sql = "SELECT m.visit_date, m.visit_time, p.petID, p.sellerID, p.shopID FROM pet_payment m, pet p WHERE m.petID = p.petID AND m.paymentID = " . $_GET['mid'];

    }else{
     $sql = "SELECT m.visit_date, m.visit_time,p.petID,p.sellerID,p.shopID FROM pet_payment m,pet p WHERE m.petID=p.petID AND m.paymentID = (SELECT MAX(paymentID) FROM pet_payment)";
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $visit_date=$row['visit_date'];
      $visit_time=$row['visit_time'];
      $petID=$row['petID'];
      $sellerID=$row['sellerID'];
      $shopID=$row['shopID'];
    }
}
     if ($row['sellerID'] !== NULL) {
        $sql3 = "SELECT address, area, state FROM seller WHERE sellerID = $sellerID" ;
    }
     elseif($row['shopID']!==NULL){
        $sql3 ="SELECT address,area,state from pet_shop where shopID = $shopID" ;
     }

     $result3 = $conn->query($sql3);
     $row3 = $result3->fetch_assoc();
    
?>

<div class="booking-container">
    <img src="../media/adoption-appointment.png" width="380px" height="380px" style="margin-top: 10px;margin-bottom: 20px;">
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
                    <?php echo $row['visit_date'] ?>
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
                   <?php echo $row['visit_time'] ?>
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
                   <?php echo $row3['address'] ?>,<?php echo $row3['area'] ?>,<?php echo $row3['state'] ?>
                </td>
            </tr>
        </table>
        <br><br><br>
        <div class="booking-choice-container">
            <a href="UserHomePage.php">Back To Home Page</a>
        </div>
</div>
<?php } 

elseif ($_GET['i']=='adoption-complete') {
    $mid=$_GET['mid'];
     $sql = "SELECT m.paymentID, m.book_date,p.price,p.sellerID,p.shopID,m.transactionId FROM pet_payment m,pet p WHERE m.petID=p.petID AND m.paymentID = $mid";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $payment_id=$row['paymentID'];
      $transactionId=$row['transactionId'];
      $price=$row['price'];
      $sellerID=$row['sellerID'];
      $shopID=$row['shopID'];
    }
}
date_default_timezone_set('Asia/Singapore');
$complete_date = date('Y-m-d H:i:s');

 if ($row['sellerID'] !== NULL) {
          $sql11 = "SELECT CONCAT(firstName,' ' ,LastName) AS sname FROM seller WHERE sellerID = " . $row['sellerID'];
        }
       elseif($row['shopID']!==NULL){
         $sql11 ="SELECT shopname AS sname from pet_shop where shopID = " . $row['shopID'];
        }

      $result11 = $conn->query($sql11);
      $row11 = $result11->fetch_assoc();
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
        <p class="booking-intro" style="margin-top:0;color:black">Transaction No: <?php echo $transactionId ?></p>
        <br><br><br>
        <table border="0">
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Total Paid
                </td>
                <td width="30%"></td>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                    RM<?php echo number_format((float)$price, 2, '.', ''); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Transfer to
                </td>
                <td width="30%"></td>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                    <?php echo $row11['sname'] ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Transaction Date
                </td>
                <td width="30%"></td>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                    <?php echo $complete_date ?>
                </td>
            </tr>
        </table>
        <br><br><br>
        <div class="booking-choice-container">
            <a href="UserHomePage.php">Back To Home Page</a>
        </div>
</div>
<?php } 


elseif ($_GET['i']=='purchase-complete') {
    $mid=$_GET['mid'];
     $sql = "SELECT m.paymentID, m.book_date,p.price,p.sellerID,p.shopID,m.transactionId FROM pet_payment m,pet p WHERE m.petID=p.petID AND m.paymentID = $mid";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $payment_id=$row['paymentID'];
      $transactionId=$row['transactionId'];
      $price=$row['price'];
      $sellerID=$row['sellerID'];
      $shopID=$row['shopID'];
    }
}
date_default_timezone_set('Asia/Singapore');
$complete_date = date('Y-m-d H:i:s');

 if ($row['sellerID'] !== NULL) {
          $sql11 = "SELECT CONCAT(firstName,' ' ,LastName) AS sname FROM seller WHERE sellerID = " . $row['sellerID'];
        }
       elseif($row['shopID']!==NULL){
         $sql11 ="SELECT shopname AS sname from pet_shop where shopID = " . $row['shopID'];
        }

      $result11 = $conn->query($sql11);
      $row11 = $result11->fetch_assoc();
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
        <p class="booking-intro" style="margin-top:0;color:black">Transaction No: <?php echo $transactionId ?></p>
        <br><br><br>
        <table border="0">
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Paid Booking Fee
                </td>
                <td width="30%"></td>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                    RM<?php echo number_format((float)$price*0.1, 2, '.', ''); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Paid Remaining Amount
                </td>
                <td width="30%"></td>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                    RM<?php echo number_format((float)$price*0.9, 2, '.', ''); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    <b>Total Paid</b>
                </td>
                <td width="30%"></td>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                    <b>RM<?php echo number_format((float)$price, 2, '.', ''); ?></b>
                </td>
            </tr>
            <tr>
                <td colspan="3"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Transfer to
                </td>
                <td width="30%"></td>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                    <?php echo $row11['sname'] ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><hr style="width:100%"></td>
            </tr>
            <tr>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;padding: 10px 0;">
                    Transaction Date
                </td>
                <td width="30%"></td>
                <td class="booking-intro" style="margin-top:0;font-size: 35px;color: black;">
                    <?php echo $complete_date ?>
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