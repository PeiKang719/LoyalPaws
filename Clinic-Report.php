


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

    <?php include 'AdminHeader.php'; ?>
    <?php include 'Connection.php'; ?>
<div class="container" style="padding-left:0;padding-right:0;width: 100%;">
 <p class="profile-header" style="margin-left:50px">Report</p>
  <div class="manage-appointment-section">
    <a href="Clinic-Report.php?report=record">Record</a>
    <a href="Clinic-Report.php?report=revenue">Revenue</a>
    <a href="Clinic-Report.php?report=clinic">Clinic&Vet</a>

  </div>

<?php if(isset($_GET['report'])){
          if($_GET['report']=='record'){
            record();
          }
          elseif($_GET['report']=='revenue'){
            revenue();
          }
          elseif($_GET['report']=='owner'){
            owner();
          }
          elseif($_GET['report']=='clinic'){
            clinic();
          }
          elseif($_GET['report']=='breed'){
            breed();
          }
}else{
 record();
}?>
 

<!---------------------------------------------------RECORD------------------------------------------------------------->
<?php function record(){ ?>
  <?php
 include 'Connection.php';
$sql = "SELECT v.name as title, COUNT(v.vetID)AS number FROM vet v,record r,clinic_appointment ca WHERE r.appointmentID=ca.appointmentID AND ca.vetID=v.vetID GROUP BY v.vetID ORDER BY title;";
$result = $conn->query($sql);

$dataPoints = array();

while ($row = $result->fetch_assoc()) {
  $dataPoints[] = array("y" => $row['number'], "label" => $row['title']);
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
    title: "Number of appointments"
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
    <th>No of Vets</th>
  </tr>
<?php 
$result2 = $conn->query($sql);
while ($row2 = $result2->fetch_assoc()) { ?>
  <tr>
        <td><?php echo $row2['title'] ?></td>    
        <td><?php echo $row2['number'] ?></td> 
  </tr>   
<?php } ?>
  
</table>
</div>
<div class="report-container">
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</div>
<?php } ?>

<!---------------------------------------------------BREED------------------------------------------------------------->
<?php function revenue(){ ?>
  <?php
 include 'Connection.php';
$sql = "SELECT b.name as title, COUNT(p.petID)AS number FROM pet p,breed b WHERE b.breedID=p.breedID AND b.type='Dog' GROUP BY p.breedID ORDER BY number DESC";
$result = $conn->query($sql);

$dog = array();

while ($row = $result->fetch_assoc()) {
  $dog[] = array("label" => $row['title'], "y" => $row['number']);
}

$sql2 = "SELECT b.name as title, COUNT(p.petID)AS number FROM pet p,breed b WHERE b.breedID=p.breedID AND b.type='Cat' GROUP BY p.breedID ORDER BY number DESC";
$result2 = $conn->query($sql2);

$cat = array();

while ($row2 = $result2->fetch_assoc()) {
  $cat[] = array("label" => $row2['title'], "y" => $row2['number']);
}
 
?>

<div class="report-table-container" style="flex-direction: column;justify-content: space-evenly;align-items: flex-start;">
<table class="report-table">
  <tr>
    <th>Dog Breed</th>
    <th>No of Pets</th>
  </tr>
<?php 
$result2 = $conn->query($sql);
while ($row2 = $result2->fetch_assoc()) { ?>
  <tr>
        <td><?php echo $row2['title'] ?></td>    
        <td><?php echo $row2['number'] ?></td> 
  </tr>   
<?php } ?>
  
</table>
<div class="report-container" style="display: flex;flex-direction:row">
<canvas id="chartContainer2" style="height: 370px; width: 100%;"></canvas>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
        // PHP code to retrieve data
        <?php
            // Retrieve data from your data source
            $labels = ['January', 'February', 'March', 'April', 'May', 'June'];
            $barData = [10, 20, 15, 25, 30, 35];
            $lineData = [50, 45, 55, 60, 58, 65];
        ?>

        // Create the chart using retrieved data
        var ctx = document.getElementById('chartContainer2').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    type: 'bar',
                    label: 'Bar Dataset',
                    data: <?php echo json_encode($barData); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Adjust as needed
                    borderColor: 'rgba(75, 192, 192, 1)', // Adjust as needed
                    borderWidth: 1
                }, {
                    type: 'line',
                    label: 'Line Dataset',
                    data: <?php echo json_encode($lineData); ?>,
                    fill: false,
                    borderColor: 'rgba(255, 99, 132, 1)', // Adjust as needed
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

<?php } ?>

</div>

<script type="text/javascript">
  $(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('report');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'adopter') {
    $('a[href*="SideBar-Report.php?report=adopter"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="SideBar-Report.php?report=breed"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=owner"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=clinic"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=pet"]').css('border-bottom', '0');
  }
  else if (sValue === 'breed') {
    $('a[href*="SideBar-Report.php?report=adopter"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=breed"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="SideBar-Report.php?report=owner"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=clinic"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=pet"]').css('border-bottom', '0');
  }
  else if (sValue === 'owner') {
    $('a[href*="SideBar-Report.php?report=adopter"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=breed"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=owner"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="SideBar-Report.php?report=clinic"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=pet"]').css('border-bottom', '0');
  }
  else if (sValue === 'clinic') {
    $('a[href*="SideBar-Report.php?report=adopter"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=breed"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=owner"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=clinic"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="SideBar-Report.php?report=pet"]').css('border-bottom', '0');
  }
  else if (sValue === 'pet') {
    $('a[href*="SideBar-Report.php?report=adopter"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=breed"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=owner"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=clinic"]').css('border-bottom', '0');
    $('a[href*="SideBar-Report.php?report=pet"]').css('border-bottom', '5px solid #00a8de');
  } 
  else{
    $('a[href*="SideBar-Report.php?report=adopter"]').css('border-bottom', '5px solid #00a8de');
  }
});
</script>
</body>
</html>
