<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="../media/tabIcon.png">
  <link rel="stylesheet" type="text/css" href="../Clinic/css/ClinicStyle.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>Main page</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <style type="text/css">
    .content{
    padding: 18px 50px;
    width: 93.4%;
    top: 73px;
    height: 75%;
    position: absolute;
    display: flex;
    flex-direction: column;
    left: 0px;
    }

    .content-row{
      display: flex;
      flex-direction: row;
      margin: 1% 0 ;
    }
    h1{
      font-size: 80px;
      font-weight: bold;
      color: white;
    }
  </style>
</head>
<body style="background-color:#f2f2f2">
  <?php include'SellerHeader.php' ?>

<?php 
include '../Database/Connection.php';
$sql =
"SELECT 'Available' as title, COUNT(p.petID) AS number FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $role s ON  p.$key=s.$key LEFT JOIN inquiry i ON i.petID=p.petID LEFT JOIN pet_payment m ON p.petID=m.petID WHERE s.$key=$sellerID AND (p.purpose='Rehome' OR p.purpose='Lodging') AND p.availability='Y' AND m.status IS NULL
UNION ALL
SELECT 'Appointment' as title, COUNT(p.petID) AS number FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $role s ON  p.$key=s.$key LEFT JOIN inquiry i ON i.petID=p.petID LEFT JOIN pet_payment m ON p.petID=m.petID WHERE s.$key=$sellerID AND (p.purpose='Rehome' OR p.purpose='Lodging') AND p.availability='Y' AND  (m.status='Booked' OR m.status='Appointment' OR m.status='Decision' OR m.status='Payment')
UNION ALL
SELECT 'Complete' as title, COUNT(p.petID) AS number FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $role s ON  p.$key=s.$key LEFT JOIN inquiry i ON i.petID=p.petID LEFT JOIN pet_payment m ON p.petID=m.petID WHERE s.$key=$sellerID AND (p.purpose='Rehome' OR p.purpose='Lodging') AND p.availability='Y' AND m.status='Complete'
UNION ALL
SELECT 'Cancelled' as title, COUNT(p.petID) AS number FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $role s ON  p.$key=s.$key LEFT JOIN inquiry i ON i.petID=p.petID LEFT JOIN pet_payment m ON p.petID=m.petID WHERE s.$key=$sellerID AND (p.purpose='Rehome' OR p.purpose='Lodging') AND p.availability='Y' AND m.status='Fail';"; 
$result = $conn->query($sql);
$number = array();

while ($row = $result->fetch_assoc()) {
    $number[] = $row["number"];
}
?>
<?php 
$sql2 =
"SELECT 'Appointment' as title,COUNT(p.petID) as number FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN  $role s ON  p.$key=s.$key JOIN pet_payment m ON p.petID=m.petID WHERE s.$key=$sellerID AND p.purpose='Sell' AND (m.status='appointment' OR m.status='decision' OR m.status='payment' OR m.status='cancel')
UNION ALL
SELECT 'Completed' as title,COUNT(p.petID) as number FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN  $role s ON  p.$key=s.$key JOIN pet_payment m ON p.petID=m.petID WHERE s.$key=$sellerID AND p.purpose='Sell' AND m.status='complete'
UNION ALL
SELECT 'Refunded' as title,COUNT(p.petID) as number FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN  $role s ON  p.$key=s.$key JOIN pet_payment m ON p.petID=m.petID WHERE s.$key=$sellerID AND p.purpose='Sell' AND m.status='refund';"; 
$result2 = $conn->query($sql2);
$number2 = array();

while ($row2 = $result2->fetch_assoc()) {
    $number2[] = $row2["number"];
}
?>
<?php 
$sql3 =
"SELECT 'dog' AS title,COUNT(petID) AS number FROM pet WHERE $key=$sellerID AND type='Dog'
UNION ALL
 SELECT 'cat' AS title,COUNT(petID) AS number FROM pet WHERE $key=$sellerID AND type='Cat'"; 
$result3 = $conn->query($sql3);
$number3 = array();

while ($row3 = $result3->fetch_assoc()) {
    $number3[] = $row3["number"];
}
?>
<?php 
$sql4 =
"SELECT SUM(price) AS number FROM pet WHERE adopterID IS NOT NULL AND $key=$sellerID"; 
$result4 = $conn->query($sql4);
$number4 = array();

while ($row4 = $result4->fetch_assoc()) {
    $number4[] = $row4["number"];
}
?>


<div class="content">
  <div class="content-row">
  <div class="dashboard-container" id="dashboard-adoption" style="width:65%;margin-left: 2%;">
    <div class="dashboard-overlay" style="display: flex;flex-direction: column;width: 100%;height: 100%;justify-content: center;">
      <p style="text-align: center;margin-top: 20px;font-weight:bold">Adoption</p>
      <div style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column">
      <p>Available</p>
      <h1><?php echo $number[0] ?></h1>
    </div>
    <div class="dashboard-column">
      <p>Appointment</p>
      <h1><?php echo $number[1] ?></h1>
    </div>
    <div class="dashboard-column">
      <p>Completed</p>
      <h1><?php echo $number[2] ?></h1>
    </div>
    <div class="dashboard-column">
      <p>Cancelled</p>
      <h1><?php echo $number[3] ?></h1>
    </div>
  </div>
</div>
</div>
<div class="dashboard-container" id="dashboard-dog-cat" style="width:34%;">
    <div class="dashboard-overlay" style="display: flex;flex-direction: column;width: 100%;height: 100%;justify-content: center;align-items: center;">
     
      <p style="text-align: center;font-weight:bold">Total Pets</p>
       <div style="display:flex;flex-direction:row;width: 100%;align-items: center;">
      <div class="dashboard-column">
      <p>Dog</p>
      <h1><?php echo $number3[0] ?></h1>
    </div>
    <div class="dashboard-column">
      <p>Cat</p>
      <h1><?php echo $number3[1] ?></h1>
    </div>
  </div>
  </div>
</div>
</div>
<div class="content-row">
    <div class="dashboard-container" id="dashboard-order" style="width:55%;margin-left: 2%;">
    <div class="dashboard-overlay" style="display: flex;flex-direction: column;width: 100%;height: 100%;justify-content: center;">
      <p style="text-align: center;margin-top: 20px;font-weight:bold">Order</p>
      <div style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column">
      <p>Appointment</p>
      <h1><?php echo $number2[0] ?></h1>
    </div>
    <div class="dashboard-column">
      <p>Completed</p>
      <h1><?php echo $number2[1] ?></h1>
    </div>
    <div class="dashboard-column">
      <p>Refunded</p>
      <h1><?php echo $number2[2] ?></h1>
    </div>
  </div>
</div>
</div>
<div class="dashboard-container" id="dashboard-revenue" style="width:40%;margin-left: 2%;">
      <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column" style="width:100%">
      <p style="text-align:center">Revenue</p>
      <h1>RM <?php echo number_format($number4[0],2) ?></h1>
    </div>
  </div>
</div>
</div>
</div>

</body>
</html>
