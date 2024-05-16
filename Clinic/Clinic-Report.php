


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
    <link rel="icon" type="image/png" href="../media/tabIcon.png">
    <link rel="stylesheet" type="text/css" href="css/ClinicStyle.css">
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
    <?php include '../Database/Connection.php'; ?>
<div class="container" style="padding-left:0;padding-right:0;width: 100%;">
 <p class="profile-header" style="margin-left:50px">Report</p>
  <div class="manage-appointment-section">
    <a href="Clinic-Report.php?report=app" style="width: 25%;">Completed Appointment</a>
    <a href="Clinic-Report.php?report=record&interval=total">Vet&Appointment</a>
    <a href="Clinic-Report.php?report=revenue">Revenue</a>

  </div>

<?php if(isset($_GET['report'])){
          if($_GET['report']=='record'){
            record($clinicID);
          }
          elseif($_GET['report']=='revenue'){
            revenue($clinicID);
          }
          elseif($_GET['report']=='app'){
            app($clinicID);
          }
          
}else{
 app($clinicID);
}?>
 
<!---------------------------------------------------MY APPOINTMENT-------------------------------------------------------->
<?php function app($clinicID){ ?>
 

     <?php
 include '../Database/Connection.php';
      $sql = "SELECT MONTHNAME(r.date) as title,COUNT(r.recordID) AS number FROM record r,clinic_appointment ca WHERE r.appointmentID=ca.appointmentID AND ca.clinicID=$clinicID ORDER BY month(r.date);";

$result = $conn->query($sql);

$dataPoints = array();
$vet = array();
$app = array();
while ($row = $result->fetch_assoc()) {
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

<!---------------------------------------------------RECORD------------------------------------------------------------->
<?php function record($clinicID){ ?>
 

<select id="mySelect" style="width: 15%;position: absolute;margin-top: 80px;margin-left: 75px;border: 2px solid black;" >
    <option value="">Select Interval</option>
    <option value="total&report=record">Total</option>
    <option value="year&report=record">This Year</option>
    <option value="month&report=record">This Month</option>
  </select>
  <?php function total($clinicID){ ?>

     <?php
 include '../Database/Connection.php';
 if(isset($_GET['interval'])){
    if($_GET['interval']=='total'){
      $sql = "SELECT v.name as title, COUNT(r.recordID)AS number FROM vet v,record r,clinic_appointment ca WHERE r.appointmentID=ca.appointmentID AND ca.vetID=v.vetID AND v.clinicID=$clinicID GROUP BY v.vetID ORDER BY title;";
    }
 }

$result = $conn->query($sql);

$dataPoints = array();
$vet = array();
$app = array();
while ($row = $result->fetch_assoc()) {
  $dataPoints[] = array("y" => $row['number'], "label" => $row['title']);
  $vet[] = $row['title'];
  $app[] = $row['number'];
}

$sql5= "SELECT name FROM vet WHERE clinicID=$clinicID ORDER BY name";
$result5 = $conn->query($sql5);

$vet_name = array();
while ($row5 = $result5->fetch_assoc()) {
  $vet_name[] = $row5['name'];
}

$final_vet = array();
$final_number = array();
$k=0;
for($i=0 ; $i<COUNT($vet_name); $i++){
  if($k<COUNT($vet)){
  if($vet_name[$i] == $vet[$k]){
    $final_vet[] = $vet[$k];
    $final_number[] = $app[$k];
    $k++;
  }}else{
    $final_vet[] = $vet_name[$i];
    $final_number[] = 0; 
  }
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
    <th>Vet</th>
    <th>No of Appointments</th>
  </tr>
<?php 
$total_app=0;
for($p=0 ; $p < COUNT($final_vet); $p++) { 
  $total_app+= $final_number[$p]; ?>
  <tr>
        <td><?php echo $final_vet[$p] ?></td>    
        <td><?php echo $final_number[$p] ?></td> 
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
<?php function year($clinicID){ ?>
   <?php
 include '../Database/Connection.php';
 if(isset($_GET['interval'])){
    if($_GET['interval']=='year'){
      $sql="SELECT v.name AS title, COUNT(r.recordID) AS number,year(r.date) FROM vet v, record r, clinic_appointment ca WHERE r.appointmentID = ca.appointmentID AND ca.vetID = v.vetID AND v.clinicID = $clinicID AND YEAR(r.date) = YEAR(CURRENT_DATE()) GROUP BY v.vetID ORDER BY title;";
    }
 }

$result = $conn->query($sql);

$dataPoints = array();
$vet = array();
$app = array();
while ($row = $result->fetch_assoc()) {
  $dataPoints[] = array("y" => $row['number'], "label" => $row['title']);
  $vet[] = $row['title'];
  $app[] = $row['number'];
}

$sql5= "SELECT name FROM vet WHERE clinicID=$clinicID ORDER BY name";
$result5 = $conn->query($sql5);

$vet_name = array();
while ($row5 = $result5->fetch_assoc()) {
  $vet_name[] = $row5['name'];
}

$final_vet = array();
$final_number = array();
$k=0;
for($i=0 ; $i<COUNT($vet_name); $i++){
  if($k<COUNT($vet)){
  if($vet_name[$i] == $vet[$k]){
    $final_vet[] = $vet[$k];
    $final_number[] = $app[$k];
    $k++;
  }}else{
    $final_vet[] = $vet_name[$i];
    $final_number[] = 0; 
  }
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
    <th>Vet</th>
    <th>No of Appointments</th>
  </tr>
<?php 
$total_app=0;
for($p=0 ; $p < COUNT($final_vet); $p++) { 
  $total_app+= $final_number[$p]; ?>
  <tr>
        <td><?php echo $final_vet[$p] ?></td>    
        <td><?php echo $final_number[$p] ?></td> 
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
<?php function month($clinicID){ ?>
   <?php
 include '../Database/Connection.php';
 if(isset($_GET['interval'])){
    if($_GET['interval']=='month'){
      $sql="SELECT v.name AS title, COUNT(r.recordID) AS number,MONTHNAME(r.date) FROM vet v, record r, clinic_appointment ca WHERE r.appointmentID = ca.appointmentID AND ca.vetID = v.vetID AND v.clinicID = $clinicID AND MONTH(r.date) = MONTH(CURRENT_DATE()) AND YEAR(r.date) = YEAR(CURRENT_DATE()) GROUP BY v.vetID ORDER BY title;";
    }
 }

$result = $conn->query($sql);

$dataPoints = array();
$vet = array();
$app = array();
while ($row = $result->fetch_assoc()) {
  $dataPoints[] = array("y" => $row['number'], "label" => $row['title']);
  $vet[] = $row['title'];
  $app[] = $row['number'];
}

$sql5= "SELECT name FROM vet WHERE clinicID=$clinicID ORDER BY name";
$result5 = $conn->query($sql5);

$vet_name = array();
while ($row5 = $result5->fetch_assoc()) {
  $vet_name[] = $row5['name'];
}

$final_vet = array();
$final_number = array();
$k=0;
for($i=0 ; $i<COUNT($vet_name); $i++){
  if($k<COUNT($vet)){
  if($vet_name[$i] == $vet[$k]){
    $final_vet[] = $vet[$k];
    $final_number[] = $app[$k];
    $k++;
  }}else{
    $final_vet[] = $vet_name[$i];
    $final_number[] = 0; 
  }
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
    <th>Vet</th>
    <th>No of Appointments</th>
  </tr>
<?php 
$total_app=0;
for($p=0 ; $p < COUNT($final_vet); $p++) { 
  $total_app+= $final_number[$p]; ?>
  <tr>
        <td><?php echo $final_vet[$p] ?></td>    
        <td><?php echo $final_number[$p] ?></td> 
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

<?php if(isset($_GET['interval'])){
          if($_GET['interval']=='total'){
            total($clinicID);
          }
          elseif($_GET['interval']=='year'){
            year($clinicID);
          }
          elseif($_GET['interval']=='month'){
            month($clinicID);
          }
}else{
 total($clinicID);
}?>

</div>
<?php } ?>

<!---------------------------------------------------Revenue------------------------------------------------------------->
<?php function revenue($clinicID){ ?>
  <?php
 include '../Database/Connection.php';
$sql = "SELECT MONTHNAME(cp.date) AS month, SUM(cp.amount) AS total_amount FROM clinic_payment cp,record r,clinic_appointment ca WHERE cp.recordID=r.recordID AND r.appointmentID=ca.appointmentID AND ca.clinicID=$clinicID GROUP BY MONTHNAME(cp.date) ORDER BY MONTH(cp.date);";
$result = $conn->query($sql);

$month = array();
$amount = array();

while ($row = $result->fetch_assoc()) {
  $month[] = $row['month'];
  $amount[] = $row['total_amount'];
}

$sql2 = "SELECT MONTHNAME(cp.date) AS month, SUM(cp.amount*(1+(c.discount_percent/100))-cp.amount) AS discount FROM clinic_payment cp,record r,clinic_appointment ca,clinic c WHERE cp.recordID=r.recordID AND r.appointmentID=ca.appointmentID AND ca.clinicID=c.clinicID AND ca.petID IS NOT NULL AND ca.clinicID=$clinicID GROUP BY MONTHNAME(cp.date) ORDER BY MONTH(cp.date);";
$result2 = $conn->query($sql2);

$month2 = array();
$amount2 = array();

while ($row2 = $result2->fetch_assoc()) {
  $month2[] = $row2['month'];
  $amount2[] = $row2['discount'];
}

$month3 = array();
$amount3 = array();
$p = 0;
for($k=0 ; $k<COUNT($month); $k++){
  if($p < COUNT($month2)){
  if($month[$k] == $month2[$p]){
    $month3[] = $month2[$p];
    $amount3[] = $amount2[$p];
    $p ++;
  }}
  else{
    $month3[] = $month[$p];
    $amount3[] = 0;
  }
}

$category = array_map(function($item) {
  return array('label' => $item . '-2023');
}, $month);

$reve = array_map(function($item) {
  return array('value' => $item);
}, $amount);

$dis = array_map(function($item) {
  return array('value' => number_format($item,2));
}, $amount3);
?>

<div class="report-table-container" style="flex-direction: row;justify-content: space-evenly;align-items: flex-start;">

<table class="report-table">
  <tr>
    <th>Month</th>
    <th width="300px">Revenue</th>
  </tr>
<?php 
$final_total=0;
$result3 = $conn->query($sql);
while ($row3 = $result3->fetch_assoc()) { 
  $final_total += number_format($row3['total_amount'], 2, '.', ''); ?>
  <tr>
        <td><?php echo $row3['month'] ?></td>    
        <td>RM <?php echo number_format($row3['total_amount'],2) ?></td> 
  </tr>   
<?php } ?>
<tr>
  <td style="font-weight: bold;">Total</td>
  <td style="font-weight: bold;">RM <?php echo $final_total ?> </td>
</tr>
</table>

<table class="report-table">
  <tr>
    <th>Month</th>
    <th width="300px">Charitable Discounts</th>
  </tr>
<?php
$final_dis=0; 
for($a=0 ; $a<COUNT($month3); $a++){
  $final_dis+=number_format($amount3[$a],2); ?>
  <tr>
        <td><?php echo $month3[$a] ?></td>    
        <td>RM <?php echo number_format($amount3[$a],2) ?></td> 
  </tr>   
<?php } ?>
<tr>
  <td style="font-weight: bold;">Total</td>
  <td style="font-weight: bold;">RM <?php echo $final_dis ?> </td>
</tr>
</table>
</div>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.candy.js"></script>

<script type="text/javascript">
var category = <?php echo json_encode($category); ?>;
var reve = <?php echo json_encode($reve); ?>;
var dis = <?php echo json_encode($dis); ?>;

const dataSource = {
  chart: {
  caption: "Revenue & Charitable Discounts",
  captionFontSize: "30",
  baseFontSize: "15",
  drawcrossline: "1",
  yaxisname: "Revenue (in RM)",
  syaxisname: "Charitable Discounts (in RM)",
  showvalues: "1",
  showanchors: "1",
  numberprefix: "RM",
  sNumberPrefix: "RM",
  plothighlighteffect: "fadeout",
  theme: "gammel",
  anchorbgcolor: "#cc2900",
  bgcolor: "#FFFFFF",
  showborder: "0",
  numberScaleValue: "0" // Disable scaling and suffix
}
,
  categories: [
    {
      category: category
    }
  ],
  dataset: [
    {
      seriesname: "Revenue",
      plotfillcolor: "#006bb3", // Set the bar color to blue
      plotbordercolor: "#006bb3", // Set the border color to blue
      anchorbordercolor: "#0000FF", // Set the line color to blue
      plottooltext: "Revenue in $label : <b>$dataValue</b>",
      data: reve
    },
    {
      seriesname: "Charitable Discounts",
      parentyaxis: "S",
      renderas: "line",
      showvalues: "0",
      color: "#cc2900", 
      anchorradius: "6",
      anchorbordercolor: "#cc2900",
      plottooltext: "Charitable Discounts : <b>RM$value</b>",
      data: dis
    }
  ]
};

FusionCharts.ready(function() {
  var myChart = new FusionCharts({
    type: "mscombidy2d",
    renderAt: "chart-container",
    width: "100%",
    height: "100%",
    dataFormat: "json",
    dataSource
  }).render();
});
</script>

<div class="report-container" style="display: flex;flex-direction:row">
<div id="chart-container" style="height: 470px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</div>

</div>


<?php } ?>

</div>

<script type="text/javascript">
  $(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('report');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'record') {
    $('a[href*="Clinic-Report.php?report=record"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Clinic-Report.php?report=revenue"]').css('border-bottom', '0');
    $('a[href*="Clinic-Report.php?report=app"]').css('border-bottom', '0');
  }
  else if (sValue === 'revenue') {
    $('a[href*="Clinic-Report.php?report=record"]').css('border-bottom', '0');
    $('a[href*="Clinic-Report.php?report=revenue"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Clinic-Report.php?report=app"]').css('border-bottom', '0');
  }
  else if (sValue === 'app') {
    $('a[href*="Clinic-Report.php?report=record"]').css('border-bottom', '0');
    $('a[href*="Clinic-Report.php?report=app"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Clinic-Report.php?report=revenue"]').css('border-bottom', '0');
  }
  else{
    $('a[href*="Clinic-Report.php?report=app"]').css('border-bottom', '5px solid #00a8de');
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
