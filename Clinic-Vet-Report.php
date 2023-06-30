


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
    <link rel="icon" type="image/png" href="media/tabIcon.png">
    <link rel="stylesheet" type="text/css" href="ClinicStyle.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.w3schools.com/lib/w3data.js"></script>
    <style type="text/css">
      .report-container{
        width:80%;padding:3% 5%;text-align: center;border: 2px solid black;border-radius: 10px;margin-top: 50px;position: relative;margin-right: auto;margin-left: auto;box-shadow: 0 0px 12px 0 rgba(0,0,0,0.2);
      }
    </style>

</head>
<body>

    <?php include 'ClinicHeader.php'; ?>
    <?php include 'Connection.php'; ?>
<div class="container" style="padding-left:0;padding-right:0;width: 100%;">
 <p class="profile-header" style="margin-left:50px">Report</p>
  <div class="manage-appointment-section">
    <a href="Clinic-Vet-Report.php?report=record&interval=total" style="width:30%">My Completed Appointment</a>

  </div>

<?php if(isset($_GET['report'])){
          if($_GET['report']=='record'){
            record($vetID);
          }
          
}else{
 record($vetID);
}?>
 

<!---------------------------------------------------RECORD------------------------------------------------------------->
<?php function record($vetID){ ?>
 

     <?php
 include 'Connection.php';
      $sql = "SELECT MONTHNAME(r.date) as title,COUNT(r.recordID) AS number FROM record r,clinic_appointment ca WHERE r.appointmentID=ca.appointmentID AND ca.vetID=$vetID ORDER BY month(r.date);";

$result = $conn->query($sql);

$dataPoints = array();
$vet = array();
$app = array();
while ($row = $result->fetch_assoc()) {
  if($row['title']==NULL){
    $row['title']='Unknown';
  }
  $dataPoints[] = array("y" => $row['number'], "label" => $row['title']);
  $month[] = $row['title'];
  $app[] = $row['number'];
}

?>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  theme: "light2",
  title:{
    text: "Number Of Appointment Completed"
  },
  axisY: {
    title: "Number of appointments",
    interval: 1,
    minimum: 0
  },
  data: [{
    type: "column",
    yValueFormatString: "#,##0",
    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 
}
</script>
<div class="report-table-container">
<table class="report-table">
  <tr>
    <th>Month</th>
    <th>No of Completed Appointments</th>
  </tr>
<?php 
$total_app=0;
for($p=0 ; $p < COUNT($month); $p++) { 
  $total_app+= $app[$p]; ?>
  <tr>
        <td><?php echo $month[$p] ?></td>    
        <td><?php echo $app[$p] ?></td> 
  </tr>   
<?php } ?>
  <tr>
    <td style="font-weight: bold;">Total</td>
    <td style="font-weight: bold;"><?php echo $total_app ?> </td>
  </tr>
</table>
</div>
<div class="report-container">
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<?php } ?>

</div>

<script type="text/javascript">
  $(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('report');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'record') {
    $('a[href*="Clinic-Vet-Report.php?report=record"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Clinic-Vet-Report.php?report=revenue"]').css('border-bottom', '0');
  }
  else if (sValue === 'revenue') {
    $('a[href*="Clinic-Vet-Report.php?report=record"]').css('border-bottom', '0');
    $('a[href*="Clinic-Vet-Report.php?report=revenue"]').css('border-bottom', '5px solid #00a8de');
  }
  else{
    $('a[href*="Clinic-Vet-Report.php?report=record"]').css('border-bottom', '5px solid #00a8de');
  }
});

 document.addEventListener('DOMContentLoaded', function() {
  var selectElement = document.getElementById('mySelect');

  // Function to handle option selection
  function handleOptionSelection() {
    var selectedValue = selectElement.value;

    if (selectedValue !== '') {
      // Update the URL with the selected option value
      var currentURL = window.location.href;
      var baseURL = currentURL.split('?')[0]; // Remove any existing query parameters
      var newURL = baseURL + '?interval=' + selectedValue;
      history.replaceState(null, null, newURL);

      // Reload the page
      window.location.reload();
    }
  }

  // Event listener for option change
  selectElement.addEventListener('change', handleOptionSelection);
});

</script>
</body>
</html>
