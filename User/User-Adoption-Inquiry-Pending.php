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
     $sql = "SELECT m.paymentID, m.book_date,p.price FROM pet_payment m,pet p WHERE m.petID=p.petID AND m.paymentID = (SELECT MAX(paymentID) FROM pet_payment)";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $payment_id=$row['paymentID'];
      $price=$row['price'];
      $book_date=$row['book_date'];
    }
}
?>

<div class="booking-container">
    <img src="../media/mailbox.gif" alt="mailbox" style="width:348px;height:348px;">
    <p class="booking-header" style="color:#248f24">Adoption Form Sent Successfully! Thank You for Your Application!</p>
    <br><br><hr style="border:2px solid #d9d9d9"><br>
      <p class="booking-intro" style="font-size:25px;padding: 0px 60px;text-align: center;">Thank you for submitting your adoption form! We appreciate your interest in adopting a pet. Your application has been received and will be carefully reviewed by the pet owner.<br><br>

Please note that submitting this form <b>does not guarantee</b> adoption. The pet owner will carefully assess all applications and select the most suitable adopter based on various factors, including compatibility and the pet's welfare.<br><br>

We will notify you via email if you are selected as a potential adopter. In the meantime, we kindly ask for your patience as the review process may take some time.<br><br>

 Thank you once again for your interest in providing a loving home to a deserving pet!</p>
      
        <div class="booking-choice-container">
            <a href="UserHomePage.php">Back To Home Page</a>
        </div>
</div>


<script type="text/javascript">
    



</script>
</body>
</html>