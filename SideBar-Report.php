


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
    <a href="SideBar-Report.php?report=adopter">Adopters</a>
    <a href="SideBar-Report.php?report=breed">Breed</a>
    <a href="SideBar-Report.php?report=clinic">Clinic&Vet</a>
    <a href="SideBar-Report.php?report=pet">Pets</a>
    <a href="SideBar-Report.php?report=owner">Pet Owner</a>
  </div>

<?php if(isset($_GET['report'])){
          if($_GET['report']=='pet'){
            pet();
          }
          elseif($_GET['report']=='adopter'){
            adopter();
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
 adopter();
}?>
 
 <!-------------------------------------------------------PET------------------------------------------------------------->
<?php function pet(){ ?>

 <?php 
include 'Connection.php';
$sql2 =
"SELECT 'rehoming' AS title, SUM(CASE WHEN type = 'Dog' THEN 1 ELSE 0 END) AS Dog, SUM(CASE WHEN type = 'Cat' THEN 1 ELSE 0 END) AS Cat FROM pet WHERE adopterID IS NULL AND purpose = 'Rehome' AND type IN ('Dog', 'Cat') 
UNION ALL 
SELECT 'selling' AS title, SUM(CASE WHEN type = 'Dog' THEN 1 ELSE 0 END) AS Dog, SUM(CASE WHEN type = 'Cat' THEN 1 ELSE 0 END) AS Cat FROM pet WHERE adopterID IS NULL AND purpose = 'Sell' AND type IN ('Dog', 'Cat') 
UNION ALL 
SELECT 'adopted' AS title, SUM(CASE WHEN type = 'Dog' THEN 1 ELSE 0 END) AS Dog, SUM(CASE WHEN type = 'Cat' THEN 1 ELSE 0 END) AS Cat FROM pet WHERE adopterID IS NOT NULL AND purpose = 'Rehome' AND type IN ('Dog', 'Cat')
 UNION ALL 
 SELECT 'purchased' AS title, SUM(CASE WHEN type = 'Dog' THEN 1 ELSE 0 END) AS Dog, SUM(CASE WHEN type = 'Cat' THEN 1 ELSE 0 END) AS Cat FROM pet WHERE adopterID IS NOT NULL AND purpose = 'Sell' AND type IN ('Dog', 'Cat');"; 

$result2 = $conn->query($sql2);
$dog = array();
$cat = array();

while ($row2 = $result2->fetch_assoc()) {
    $dog[] = $row2["Dog"];
    $cat[] = $row2["Cat"];
}

$rehoming = array(
  array("label"=> "Dog", "y"=> $dog[0]),
  array("label"=> "Cat", "y"=> $cat[0])
);
 
$adopted = array(
  array("label"=> "Dog", "y"=> $dog[2]),
  array("label"=> "Cat", "y"=> $cat[2])
);
$selling = array(
  array("label"=> "Dog", "y"=> $dog[1]),
  array("label"=> "Cat", "y"=> $cat[1])
);
$purchased = array(
  array("label"=> "Dog", "y"=> $dog[3]),
  array("label"=> "Cat", "y"=> $cat[3])
);
?>
<script type="text/javascript">
  window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
  title: {
    text: "Distribution of Pets by Category"
  },
  theme: "light2",
  animationEnabled: true,
  toolTip:{
    shared: true,
    reversed: true
  },
  axisY: {
    title: "Number of Pets",
    suffix: "",
    minimum:0

  },
  legend: {
    cursor: "pointer",
    itemclick: toggleDataSeries
  },
  data: [
    {
      type: "stackedColumn",
      name: "Rehoming",
      showInLegend: true,
      yValueFormatString: "#,##0",
      dataPoints: <?php echo json_encode($rehoming, JSON_NUMERIC_CHECK); ?>
    },{
      type: "stackedColumn",
      name: "Adopted",
      showInLegend: true,
      yValueFormatString: "#,##0",
      dataPoints: <?php echo json_encode($adopted, JSON_NUMERIC_CHECK); ?>
    },{
      type: "stackedColumn",
      name: "Selling",
      showInLegend: true,
      yValueFormatString: "#,##0",
      dataPoints: <?php echo json_encode($selling, JSON_NUMERIC_CHECK); ?>
    },{
      type: "stackedColumn",
      name: "Purchased",
      showInLegend: true,
      yValueFormatString: "#,##0",
      dataPoints: <?php echo json_encode($purchased, JSON_NUMERIC_CHECK); ?>
    }
  ]
});
 
chart.render();
 
function toggleDataSeries(e) {
  if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    e.dataSeries.visible = false;
  } else {
    e.dataSeries.visible = true;
  }
  e.chart.render();
}
 
}
</script>
<div class="report-table-container">
<table class="report-table">
  <tr>
    <th></th>
    <th>Rehoming</th>
    <th>Adopted</th>
    <th>Selling</th>
    <th>Purchased</th>
    <th>Total</th>
  </tr>
  <tr>
    <td>Dog</td>
    <td><?php echo $dog[0] ?></td>
    <td><?php echo $dog[2] ?></td>
    <td><?php echo $dog[1] ?></td>
    <td><?php echo $dog[3] ?></td>
    <td style="font-weight: bold;"><?php echo $dog[0]+$dog[1]+$dog[2]+$dog[3] ?></td>
  </tr>
  <tr>
    <td>Cat</td>
    <td><?php echo $cat[0] ?></td>
    <td><?php echo $cat[2] ?></td>
    <td><?php echo $cat[1] ?></td>
    <td><?php echo $cat[3] ?></td>
    <td style="font-weight: bold;"><?php echo $cat[0]+$cat[1]+$cat[2]+$cat[3] ?></td>
  </tr>
  <tr>
    <td style="font-weight: bold;">Total</td>
    <td style="font-weight: bold;"><?php echo $cat[0]+$dog[0] ?></td>
    <td style="font-weight: bold;"><?php echo $cat[2]+$dog[2] ?></td>
    <td style="font-weight: bold;"><?php echo $cat[1]+$dog[1] ?></td>
    <td style="font-weight: bold;"><?php echo $cat[3]+$dog[3] ?></td>
    <td style="font-weight: bold;"><?php echo $cat[0]+$cat[1]+$cat[2]+$cat[3]+$dog[0]+$dog[1]+$dog[2]+$dog[3] ?></td>
  </tr>
</table>
</div>
<div class="report-container">
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</div>
<?php } ?>

<!---------------------------------------------------ADOPTER--------------------------------------------------------------->
<?php function adopter(){ ?>
  <?php
 include 'Connection.php';
$sql = "SELECT state, COUNT(adopterID) AS number FROM adopter GROUP BY state;";
$result = $conn->query($sql);

$dataPoints = array();

while ($row = $result->fetch_assoc()) {
  $dataPoints[] = array("label" => $row['state'], "y" => $row['number']);
}

 
?>
<script type="text/javascript">
  window.onload = function() {
 
var chart2 = new CanvasJS.Chart("chartContainer2", {
  animationEnabled: true,
  title: {
    text: "Adopter Distribution by State"
  },
  subtitles: [{
    text: ""
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0\"\"",
    indexLabel: "{label} ({y})",
    toolTipContent: "{label}: {y} - #percent%",
    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  }]
});
chart2.render();
 
}
</script>
<div class="report-table-container">
<table class="report-table">
  <tr>
    <th>State</th>
<?php 
$i=0;
$result2 = $conn->query($sql);
while ($row2 = $result2->fetch_assoc()) { ?>
        <th><?php echo $row2['state'] ?></th>    
<?php $i++;} ?>
  </tr>
  <tr>
    <td>No of adopter</td>
<?php 
$result3 = $conn->query($sql);
while ($row3 = $result3->fetch_assoc()) { ?>
        <td><?php echo $row3['number'] ?></td>    
<?php } ?>
  </tr>
  <tr>
    <td style="font-weight: bold;">Total</td>
<?php 
$result4 = $conn->query($sql);
$total_adopter=0;
while ($row4 = $result4->fetch_assoc()) { 
  $total_adopter+=$row4['number']; 
 } ?>
 <td colspan="<?php echo $i ?>" style="font-weight: bold;"><?php echo $total_adopter ?></td>    
  </tr>
</table>
</div>
<div class="report-container">
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</div>
<?php } ?>


<!---------------------------------------------------Pet Owner------------------------------------------------------------->
<?php function owner(){ ?>
  <?php
 include 'Connection.php';
$sql = "SELECT 'Individual Seller' as title, COUNT(sellerID)AS number FROM seller UNION ALL SELECT 'Pet Shop' as title, COUNT(shopID) FROM pet_shop;";
$result = $conn->query($sql);

$dataPoints = array();

while ($row = $result->fetch_assoc()) {
  $dataPoints[] = array("label" => $row['title'], "y" => $row['number']);
}

 
?>
<script type="text/javascript">
  window.onload = function() {
 
var chart2 = new CanvasJS.Chart("chartContainer2", {
  animationEnabled: true,
  title: {
    text: "Type of Pet Owner"
  },
  subtitles: [{
    text: ""
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0\"\"",
    indexLabel: "{label} ({y})",
    toolTipContent: "{label}: {y} - #percent%",
    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  }]
});
chart2.render();
 
}
</script>
<div class="report-table-container">
<table class="report-table">
  <tr>
    <th>Type</th>
<?php 
$result2 = $conn->query($sql);
while ($row2 = $result2->fetch_assoc()) { ?>
        <th><?php echo $row2['title'] ?></th>    
<?php } ?>
  </tr>
  <tr>
    <td>Number</td>
<?php 
$result3 = $conn->query($sql);
$total_owner=0;
$i=0;
while ($row3 = $result3->fetch_assoc()) { 
  $total_owner+=$row3['number'];  ?>
        <td><?php echo $row3['number'] ?></td>    
<?php $i++;} ?>
  </tr>
  <tr>
    <td style="font-weight: bold;">Total</td>
      <td colspan="<?php echo $i ?>" style="font-weight: bold;"><?php echo $total_owner ?></td>    
  </tr>
</table>
</div>
<div class="report-container">
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</div>
<?php } ?>

<!---------------------------------------------------CLINIC------------------------------------------------------------->
<?php function clinic(){ ?>
  <?php
 include 'Connection.php';
$sql = "SELECT c.name as title, COUNT(v.vetID)AS number FROM vet v,clinic c WHERE v.clinicID=c.clinicID AND v.ic NOT LIKE 'B%' AND v.ic NOT LIKE 'P%' AND v.ic NOT LIKE 'F%' GROUP BY v.clinicID ORDER BY title;";
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
    text: "Number of vets in each clinic"
  },
  axisY: {
    title: "Number of vets",
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
    <th>Clinic</th>
    <th>No of Vets</th>
  </tr>
<?php 
$result2 = $conn->query($sql);
$i=0;
$total_vet=0;
while ($row2 = $result2->fetch_assoc()) { ?>
  <tr>
        <td><?php echo $row2['title'] ?></td>    
        <td><?php echo $row2['number'] ?></td> 
  </tr>   
<?php $i++;$total_vet+=$row2['number'];} ?>
  <tr>
        <td style="font-weight: bold;">Total: <?php echo $i ?></td>    
        <td style="font-weight: bold;">Total: <?php echo $total_vet ?></td> 
  </tr>   
</table>
</div>
<div class="report-container">
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</div>
<?php } ?>

<!---------------------------------------------------BREED------------------------------------------------------------->
<?php function breed(){ ?>
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
<script type="text/javascript">
  window.onload = function() {
 
var chart2 = new CanvasJS.Chart("chartContainer2", {
  animationEnabled: true,
  title: {
    text: "Distribution of Dogs by Breed"
  },
  subtitles: [{
    text: ""
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0\"\"",
    indexLabel: "{label} ({y})",
    toolTipContent: "{label}: {y} - #percent%",
    dataPoints: <?php echo json_encode($dog, JSON_NUMERIC_CHECK); ?>
  }]
});

var chart3 = new CanvasJS.Chart("chartContainer3", {
  animationEnabled: true,
  title: {
    text: "Distribution of Cats by Breed"
  },
  subtitles: [{
    text: ""
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0\"\"",
    indexLabel: "{label} ({y})",
    toolTipContent: "{label}: {y} - #percent%",
    dataPoints: <?php echo json_encode($cat, JSON_NUMERIC_CHECK); ?>
  }]
});
chart2.render();
chart3.render();
 
}
</script>
<div class="report-table-container" style="flex-direction: row;justify-content: space-evenly;align-items: flex-start;">
<table class="report-table">
  <tr>
    <th>Dog Breed</th>
    <th>No of Pets</th>
  </tr>
<?php 
$result2 = $conn->query($sql);
$total_dbreed=0;
while ($row2 = $result2->fetch_assoc()) { 
  $total_dbreed+= $row2['number'];?>
  <tr>
        <td><?php echo $row2['title'] ?></td>    
        <td><?php echo $row2['number'] ?></td> 
  </tr>   
<?php } ?>
  <tr>
    <td style="font-weight:bold">Total</td>
    <td style="font-weight:bold"><?php echo$total_dbreed ?> </td>
  </tr>
</table>

<table class="report-table">
  <tr>
    <th>Cat Breed</th>
    <th>No of Pets</th>
  </tr>
<?php 
$result3 = $conn->query($sql2);
$total_cbreed=0;
while ($row3 = $result3->fetch_assoc()) { 
  $total_cbreed+= $row3['number'];?>
  <tr>
        <td><?php echo $row3['title'] ?></td>    
        <td><?php echo $row3['number'] ?></td> 
  </tr>   
<?php } ?>
  <tr>
    <td style="font-weight:bold">Total</td>
    <td style="font-weight:bold"><?php echo$total_cbreed ?> </td>
  </tr>
</table>
</div>
<div class="report-container" style="display: flex;flex-direction:row">
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<div id="chartContainer3" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</div>
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
