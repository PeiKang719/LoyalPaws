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

    <?php include 'SellerHeader.php'; ?>
    <?php include 'Connection.php'; ?>
<div class="container" style="padding-left:0;padding-right:0;width: 100%;">
 <p class="profile-header" style="margin-left:50px">Report</p>
  <div class="manage-appointment-section">
    <a href="Seller_Report.php?report=breed" style="width:30%">Breed</a>
    <a href="Seller_Report.php?report=pet" style="width:30%">Pet</a>
    <a href="Seller_Report.php?report=revenue" style="width:30%">Revenue</a>

  </div>

<?php if(isset($_GET['report'])){
          if($_GET['report']=='breed'){
            breed($role,$key,$sellerID);
          }elseif($_GET['report']=='pet'){
            pet($role,$key,$sellerID);
          }elseif($_GET['report']=='revenue'){
            revenue($role,$key,$sellerID);
          }

          
}else{
 breed($role,$key,$sellerID);
}?>
 


<!---------------------------------------------------BREED------------------------------------------------------------->
<?php function breed($role,$key,$sellerID){ ?>
  <?php
 include 'Connection.php';
$sql = "SELECT b.name as title, COUNT(p.petID)AS number FROM pet p,breed b WHERE b.breedID=p.breedID AND b.type='Dog' AND $key=$sellerID GROUP BY p.breedID ORDER BY number DESC";
$result = $conn->query($sql);

$dog = array();
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
  $dog[] = array("label" => $row['title'], "y" => $row['number']);
}
}else{
  $cat[] = array("label" => 'Unknown', "y" => 0);
}

$sql2 = "SELECT b.name as title, COUNT(p.petID)AS number FROM pet p,breed b WHERE b.breedID=p.breedID AND b.type='Cat' AND $key=$sellerID GROUP BY p.breedID ORDER BY number DESC";
$result2 = $conn->query($sql2);

$cat = array();
if ($result2->num_rows > 0) {
while ($row2 = $result2->fetch_assoc()) {
  $cat[] = array("label" => $row2['title'], "y" => $row2['number']);
}
}else{
  $cat[] = array("label" => 'Unknown', "y" => 0);
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
$total_dog=0;
while ($row2 = $result2->fetch_assoc()) { 
  $total_dog+=$row2['number']; ?>
  <tr>
        <td><?php echo $row2['title'] ?></td>    
        <td><?php echo $row2['number'] ?></td> 
  </tr>   
<?php } ?>
  <tr>
    <td style="font-weight: bold;">Total</td>
    <td style="font-weight: bold;"><?php echo $total_dog ?></td>
  </tr>
</table>

<table class="report-table">
  <tr>
    <th>Cat Breed</th>
    <th>No of Pets</th>
  </tr>
<?php 
$result3 = $conn->query($sql2);
$total_cat=0;
while ($row3 = $result3->fetch_assoc()) {
 $total_cat+=$row3['number']; ?>
  <tr>
        <td><?php echo $row3['title'] ?></td>    
        <td><?php echo $row3['number'] ?></td> 
  </tr>   
<?php } ?>
  <tr>
    <td style="font-weight: bold;">Total</td>
    <td style="font-weight: bold;"><?php echo $total_cat ?></td>
  </tr>
</table>
</div>
<div class="report-container" style="display: flex;flex-direction:row">
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<div id="chartContainer3" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</div>
<?php } ?>

<!---------------------------------------------------PET------------------------------------------------------------->
<?php function pet($role,$key,$sellerID){ ?>
  <?php
 include 'Connection.php';
$sql = "
SELECT 'Rehoming' as title,'Dog' as pet, COUNT(petID)AS number FROM pet WHERE type='Dog' AND (purpose='Rehome' OR purpose='Lodging') AND adopterID IS NULL AND availability='Y' AND $key=$sellerID  
UNION ALL
SELECT 'Adopted' as title,'Dog' as pet, COUNT(petID)AS number FROM pet WHERE type='Dog' AND (purpose='Rehome' OR purpose='Lodging') AND adopterID IS NOT NULL AND availability='Y' AND $key=$sellerID  
UNION ALL
SELECT 'Rehoming' as title,'Cat' as pet, COUNT(petID)AS number FROM pet WHERE type='Cat' AND (purpose='Rehome' OR purpose='Lodging') AND adopterID IS NULL AND availability='Y' AND $key=$sellerID  
UNION ALL
SELECT 'Adoption' as title,'Cat' as pet, COUNT(petID)AS number FROM pet WHERE type='Cat' AND (purpose='Rehome' OR purpose='Lodging') AND adopterID IS NOT NULL AND availability='Y' AND $key=$sellerID  ";
$result = $conn->query($sql);

$dataPoints = array();

while ($row = $result->fetch_assoc()) {
  $dataPoints[] = array("label" => $row['title'].' ('.$row['pet'].')', "y" => $row['number']);
}

$sql2 = "
SELECT 'Selling' as title,'Dog' as pet, COUNT(petID)AS number FROM pet WHERE type='Dog' AND purpose='Sell' AND availability='Y' AND adopterID IS NULL AND $key=$sellerID    
UNION ALL
SELECT 'Purchased' as title,'Dog' as pet, COUNT(petID)AS number FROM pet WHERE type='Dog' AND purpose='Sell' AND availability='Y'  AND adopterID IS NOT NULL AND $key=$sellerID  
UNION ALL
SELECT 'Selling' as title,'Cat' as pet, COUNT(petID)AS number FROM pet WHERE type='Cat' AND purpose='Sell' AND availability='Y'  AND adopterID IS NULL AND $key=$sellerID  
UNION ALL
SELECT 'Purchased' as title,'Cat' as pet, COUNT(petID)AS number FROM pet WHERE type='Cat' AND purpose='Sell' AND availability='Y'  AND adopterID IS NOT NULL AND $key=$sellerID  ";
$result2 = $conn->query($sql2);

$dataPoints2 = array();

while ($row2 = $result2->fetch_assoc()) {
  $dataPoints2[] = array("label" => $row2['title'].' ('.$row2['pet'].')', "y" => $row2['number']);

}
 
?>
<script type="text/javascript">
  window.onload = function() {
 
var chart2 = new CanvasJS.Chart("chartContainer2", {
  animationEnabled: true,
  title: {
    text: "Distribution of Pets in Adoption"
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

var chart3 = new CanvasJS.Chart("chartContainer3", {
  animationEnabled: true,
  title: {
    text: "Distribution of Pets in Order"
  },
  subtitles: [{
    text: ""
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0\"\"",
    indexLabel: "{label} ({y})",
    toolTipContent: "{label}: {y} - #percent%",
    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
  }]
});
chart2.render();
chart3.render();
 
}
</script>
<div class="report-table-container" style="flex-direction: row;justify-content: space-evenly;align-items: flex-start;">
<table class="report-table">
  <tr>
    <th>Pet</th>
    <th>Status</th>
    <th>No of Pets</th>
  </tr>
<?php 
$result3 = $conn->query($sql);
$total_adoption=0;
while ($row3 = $result3->fetch_assoc()) { 
  $total_adoption+=$row3['number']; ?>
  <tr>
        <td><?php echo $row3['pet'] ?></td>  
        <td><?php echo $row3['title'] ?></td>    
        <td><?php echo $row3['number'] ?></td> 
  </tr>   
<?php } ?>
  <tr>
    <td colspan="2" style="font-weight: bold;">Total</td>
    <td style="font-weight: bold;"><?php echo $total_adoption ?></td>
  </tr>
</table>

<table class="report-table">
  <tr>
    <th>Pet</th>
    <th>Status</th>
    <th>No of Pets</th>

  </tr>
<?php 
$result4 = $conn->query($sql2);
$total_order=0;
while ($row4 = $result4->fetch_assoc()) { 
  $total_order+=$row4['number']; ?>
  <tr>
        <td><?php echo $row4['pet'] ?></td>  
        <td><?php echo $row4['title'] ?></td>    
        <td><?php echo $row4['number'] ?></td> 
  </tr>   
<?php } ?>
    <tr>
    <td colspan="2" style="font-weight: bold;">Total</td>
    <td style="font-weight: bold;"><?php echo $total_order ?></td>
  </tr>
</table>
</div>
<div class="report-container" style="display: flex;flex-direction:row">
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<div id="chartContainer3" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

</div>
<?php } ?>


<!---------------------------------------------------REVENUE------------------------------------------------------------->
<?php function revenue($role,$key,$sellerID){ ?>
 

     <?php
  include 'Connection.php';
$sql = "SELECT MONTHNAME(pp.complete_date) AS month, SUM(p.price) AS amount, ( SELECT COUNT(pp2.paymentID) FROM pet_payment pp2,pet p WHERE pp2.petID=p.petID AND p.$key=$sellerID AND BINARY pp2.status = 'Complete' AND MONTH(pp2.complete_date) = MONTH(pp.complete_date) AND YEAR(pp2.complete_date) = YEAR(pp.complete_date) ) AS adoption, ( SELECT COUNT(pp3.paymentID) FROM pet_payment pp3,pet p WHERE pp3.petID=p.petID AND p.$key=$sellerID AND BINARY pp3.status = 'complete' AND MONTH(pp3.complete_date) = MONTH(pp.complete_date) AND YEAR(pp3.complete_date) = YEAR(pp.complete_date) ) AS orders FROM pet_payment pp JOIN pet p ON pp.petID = p.petID WHERE pp.complete_date IS NOT NULL AND p.$key = $sellerID GROUP BY MONTHNAME(pp.complete_date), YEAR(pp.complete_date) ORDER BY YEAR(pp.complete_date), MONTH(pp.complete_date);";
$result = $conn->query($sql);

$month = array();
$amount = array();
$adopt = array();
$order = array();

while ($row = $result->fetch_assoc()) {
  $month[] = $row['month'];
  $amount[] = $row['amount'];
  $adopt[] = $row['adoption'];
  $order[] = $row['orders'];
}


$category = array_map(function($item) {
  return array('label' => $item . '-2023');
}, $month);

$reve = array_map(function($item) {
  return array('value' => $item);
}, $amount);

$adoption = array_map(function($item) {
  return array('value' => $item);
}, $adopt);

$orders = array_map(function($item) {
  return array('value' => $item);
}, $order);
?>

<div class="report-table-container" style="flex-direction: row;justify-content: space-evenly;align-items: flex-start;">

<table class="report-table">
  <tr>
    <th>Month</th>
    <th width="300px">Monthly Revenue</th>
    <th>Completed Adoption</th>
    <th>Completed Order</th>
  </tr>
<?php 
$final_total=0;
$final_adoption=0;
$final_order=0;
$result3 = $conn->query($sql);
while ($row3 = $result3->fetch_assoc()) { 
  $final_total += number_format($row3['amount'], 2, '.', '');
  $final_adoption +=$row3['adoption'] ;
  $final_order +=$row3['orders'];  ?>
  <tr>
        <td><?php echo $row3['month'] ?></td>    
        <td>RM <?php echo number_format($row3['amount'],2) ?></td> 
        <td><?php echo $row3['adoption'] ?></td>
        <td><?php echo $row3['orders'] ?></td>
  </tr>   
<?php } ?>
<tr>
  <td style="font-weight: bold;">Total</td>
  <td style="font-weight: bold;">RM <?php echo $final_total ?> </td>
  <td style="font-weight: bold;"><?php echo $final_adoption ?> </td>
  <td style="font-weight: bold;"><?php echo $final_order ?> </td>
</tr>
</table>

</div>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.candy.js"></script>

<script type="text/javascript">
var category = <?php echo json_encode($category); ?>;
var reve = <?php echo json_encode($reve); ?>;
var adoption = <?php echo json_encode($adoption); ?>;
var orders = <?php echo json_encode($orders); ?>;

const dataSource = {
  chart: {
    caption: "Monthly Revenue",
    captionFontSize: "30",
    baseFontSize: "15",
    drawcrossline: "1",
    yaxisname: "Revenue (in RM)",
    syaxisname: "No of Completed Order / Adoption",
    showvalues: "1",
    showanchors: "1",
    numberprefix: "RM",
    plothighlighteffect: "fadeout",
    theme: "gammel",
    bgcolor: "#FFFFFF",
    showborder: "0",
    numberScaleValue: "0" // Disable scaling and suffix
  },
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
      seriesname: "Completed Adoption",
      parentyaxis: "S",
      renderas: "line",
      showvalues: "0",
      color: "#2eb82e",
      anchorbgcolor: "#2eb82e",
      anchorbordercolor: "#2eb82e",
      anchorradius: "6", 
      plottooltext: "Completed Adoption : <b>$value</b>",
      data: adoption
    },
    {
      seriesname: "Completed Orders",
      parentyaxis: "S",
      renderas: "line",
      showvalues: "0",
      color: "#cc2900",
      anchorbgcolor: "#cc2900",
      anchorbordercolor: "#cc2900",
      plottooltext: "Completed Orders : <b>$value</b>",
      data: orders
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
    dataSource: dataSource
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
  if (sValue === 'breed') {
    $('a[href*="Seller_Report.php?report=breed"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Seller_Report.php?report=pet"]').css('border-bottom', '0');
    $('a[href*="Seller_Report.php?report=revenue"]').css('border-bottom', '0');
  }
  else if (sValue === 'revenue') {
    $('a[href*="Seller_Report.php?report=breed"]').css('border-bottom', '0');
    $('a[href*="Seller_Report.php?report=pet"]').css('border-bottom', '0');
    $('a[href*="Seller_Report.php?report=revenue"]').css('border-bottom', '5px solid #00a8de');
  }
  else if (sValue === 'pet') {
    $('a[href*="Seller_Report.php?report=breed"]').css('border-bottom', '0');
    $('a[href*="Seller_Report.php?report=pet"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Seller_Report.php?report=revenue"]').css('border-bottom', '0');
  }
  else{
    $('a[href*="Seller_Report.php?report=breed"]').css('border-bottom', '5px solid #00a8de');
  }
});


</script>
</body>
</html>
