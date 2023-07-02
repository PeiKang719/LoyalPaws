<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="media/tabIcon.png">
  <link rel="stylesheet" type="text/css" href="ClinicStyle.css">
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
  <?php include'ClinicHeader.php' ?>

<?php 
include 'Connection.php';
$sql =
"SELECT 'Vet' AS title,COUNT(vetID) AS number FROM vet v WHERE ic REGEXP '^[0-9]+$' AND clinicID=$clinicID
UNION ALL
SELECT 'Vet_Pending' AS title,COUNT(vetID) AS number FROM vet v WHERE ic LIKE 'C.%' AND clinicID=$clinicID;"; 
$result = $conn->query($sql);
$number = array();

while ($row = $result->fetch_assoc()) {
    $number[] = $row["number"];
}
?>
<?php 
$sql2 =
"SELECT 'my' AS title, COUNT(appointmentID) AS number FROM clinic_appointment WHERE status = 'Uncompleted' AND vetID =$vetID AND DATE(`date`) = CURDATE()
 UNION ALL
 SELECT 'assigned' AS title,COUNT(appointmentID) AS number FROM clinic_appointment WHERE status='Uncompleted' AND vetID IS NOT NULL AND vetID =$vetID 
 UNION ALL 
 SELECT 'unassigned' AS title,COUNT(appointmentID) AS number FROM clinic_appointment WHERE vetID IS NULL AND clinicID=$clinicID ;"; 
$result2 = $conn->query($sql2);
$number2 = array();

while ($row2 = $result2->fetch_assoc()) {
    $number2[] = $row2["number"];
}
?>
<?php 
$sql3 =
"SELECT 'total' AS title,COUNT(recordID) AS number FROM record 
UNION ALL
 SELECT 'month' AS title, COUNT(recordID) AS number FROM record WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE());"; 
$result3 = $conn->query($sql3);
$number3 = array();

while ($row3 = $result3->fetch_assoc()) {
    $number3[] = $row3["number"];
}
?>
<?php 
$sql4 =
"SELECT SUM(cp.amount) AS number FROM clinic_payment cp,record r,clinic_appointment ca WHERE cp.recordID=r.recordID AND r.appointmentID=ca.appointmentID AND ca.petID IS NOT NULL AND ca.clinicID=$clinicID 
UNION ALL 
SELECT SUM(cp.amount)*(c.discount_percent/100) AS number FROM clinic_payment cp,record r,clinic_appointment ca,clinic c WHERE cp.recordID=r.recordID AND r.appointmentID=ca.appointmentID AND ca.clinicID=c.clinicID AND ca.petID IS NOT NULL AND ca.clinicID=$clinicID;"; 
$result4 = $conn->query($sql4);
$number4 = array();

while ($row4 = $result4->fetch_assoc()) {
    $number4[] = $row4["number"];
}
?>


<div class="content">
  <div class="content-row">
  <div class="dashboard-container" id="dashboard-clinic" style="width:34%;">
    <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;">
      <div class="dashboard-column" style="width:100%">
      <p>Veterinarian</p>
      <h1><?php echo $number[0] ?></h1>
      <p>Pending</p>
      <h1><?php echo $number[1] ?></h1>
    </div>
  </div>
</div>
  <div class="dashboard-container" id="dashboard-appointment" style="width:65%;margin-left: 2%;">
    <div class="dashboard-overlay" style="display: flex;flex-direction: column;width: 100%;height: 100%;justify-content: center;">
      <p style="text-align: center;margin-top: 20px;font-weight:bold">Appointment</p>
      <div style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column">
      <p>Appointment Today</p>
      <h1><?php echo $number2[0] ?></h1>
    </div>
    <div class="dashboard-column">
      <p>Assigned To Me</p>
      <h1><?php echo $number2[1] ?></h1>
    </div>
    <div class="dashboard-column">
      <p>Unassigned</p>
      <h1><?php echo $number2[2] ?></h1>
    </div>
  </div>
</div>
</div>
</div>
<div class="content-row">
    <div class="dashboard-container" id="dashboard-record" style="width:40%">
      <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column">
      <p style="text-align:center">Total Transaction</p>
      <h1><?php echo $number3[0] ?></h1>
    </div>
    <div class="dashboard-column">
      <p style="text-align:center">This Month</p>
      <h1><?php echo $number3[1] ?></h1>
    </div>
  </div>
</div>
<div class="dashboard-container" id="dashboard-revenue" style="width:55%;margin-left: 2%;">
      <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column" style="width:100%">
      <p style="text-align:center">Revenue</p>
      <h1>RM <?php echo number_format($number4[0],2) ?></h1>


      <p style="text-align:center">Charitable Discounts</p>
      <h1>RM <?php echo number_format($number4[1],2) ?></h1>
    </div>
  </div>
</div>
</div>
</div>

</body>
</html>
