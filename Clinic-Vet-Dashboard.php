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
"SELECT 'Vet' AS title,COUNT(t.treatmentID) AS number FROM vet v,treatment t,vet_treatment vt WHERE vt.treatmentID=t.treatmentID AND vt.vetID=v.vetID AND v.vetID=$vetID"; 
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
 SELECT 'assigned' AS title,COUNT(appointmentID) AS number FROM clinic_appointment WHERE status='Uncompleted' AND vetID IS NOT NULL AND vetID =$vetID  ;"; 
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
"SELECT area FROM vet WHERE vetID=$vetID";
$result4 = $conn->query($sql4);
$row4 = $result4->fetch_assoc();
$area=(explode(",",$row4['area']));
?>


<div class="content">
  <div class="content-row">
  <div class="dashboard-container" id="dashboard-treatment" style="width:34%;">
    <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;">
      <div class="dashboard-column" style="width:100%">
      <p>My Responsible Treatments</p>
      <h1><?php echo $number[0] ?></h1>
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
<div class="dashboard-container" id="dashboard-vet-profile" style="width:55%;margin-left: 2%;">
      <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;justify-content: center;align-items: center;">

      <p style="text-align:center;margin-right: 50px;font-size: 40px;">My Area</p>
      <table>
      <?php for($i=0; $i<COUNT($area); $i++){ ?>
      <tr><td style="font-size:25px;color:white"><span style='font-size:20px;color:white'>&#9679;</span> <?php echo $area[$i] ?></td></tr>
    <?php } ?>
  </table>

  </div>
</div>
</div>
</div>

</body>
</html>
