<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="../media/tabIcon.png">
  <link rel="stylesheet" type="text/css" href="css/AdminStyle.css">
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
  <?php include'AdminHeader.php' ?>

<?php 
include '../Database/Connection.php';
$sql =
"SELECT 'Clinic' AS title,COUNT(c.clinicID) AS number FROM clinic c,vet v WHERE c.vetID=v.vetID AND v.ic NOT LIKE 'P.%' AND v.ic NOT LIKE 'F.%' AND v.ic NOT LIKE 'B.%' AND v.ic NOT LIKE 'C.%'
UNION ALL
SELECT 'Clinic_Pending' AS title,COUNT(v.clinicID) AS number FROM clinic c,vet v WHERE c.clinicID=v.clinicID AND v.ic LIKE 'B.%'
UNION ALL
SELECT 'Vet' AS title,COUNT(vetID) AS number FROM vet v WHERE ic REGEXP '^[0-9]+$'
UNION ALL
SELECT 'Vet_Pending' AS title,COUNT(vetID) AS number FROM vet v WHERE ic LIKE 'P.%';"; 
$result = $conn->query($sql);
$number = array();

while ($row = $result->fetch_assoc()) {
    $number[] = $row["number"];
}
?>
<?php 
$sql2 =
"SELECT 'rehome' AS title,COUNT(petID) AS number FROM pet WHERE adopterID IS NULL AND purpose='Rehome' UNION ALL SELECT 'adopted' AS title,COUNT(petID) AS number FROM pet WHERE adopterID IS NOT NULL AND purpose='Rehome' UNION ALL SELECT 'sell' AS title,COUNT(petID) AS number FROM pet WHERE adopterID IS NULL AND purpose='Sell' UNION ALL SELECT 'purchased' AS title,COUNT(petID) AS number FROM pet WHERE adopterID IS NOT NULL AND purpose='Sell';"; 
$result2 = $conn->query($sql2);
$number2 = array();

while ($row2 = $result2->fetch_assoc()) {
    $number2[] = $row2["number"];
}
?>
<?php 
$sql3 =
"SELECT 'seller' AS title,COUNT(sellerID) AS number FROM seller UNION ALL SELECT 'shop' AS title,COUNT(shopID) AS number FROM pet_shop;"; 
$result3 = $conn->query($sql3);
$number3 = 0;

while ($row3 = $result3->fetch_assoc()) {
    $number3 += $row3["number"];
}
?>
<?php 
$sql4 =
"SELECT COUNT(adopterID) AS number FROM adopter"; 
$result4 = $conn->query($sql4);

while ($row4 = $result4->fetch_assoc()) {
    $number4 = $row4["number"];
}
?>
<?php 
$sql5 =
"SELECT COUNT(oID) AS number FROM organization"; 
$result5 = $conn->query($sql5);

while ($row5 = $result5->fetch_assoc()) {
    $number5 = $row5["number"];
}
?>
<?php 
$sql6 =
"SELECT 'cat' AS title,COUNT(breedID) AS number FROM breed WHERE type='Cat' 
UNION ALL 
SELECT 'dog' AS title,COUNT(breedID) AS number FROM breed WHERE type='Dog' ;"; 
$result6 = $conn->query($sql6);
$number6 = array();

while ($row6 = $result6->fetch_assoc()) {
    $number6[] = $row6["number"];
}
?>

<div class="content">
  <div class="content-row">
  <div class="dashboard-container" id="dashboard-clinic" style="width:34%;">
    <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column">
      <p>Clinic</p>
      <h1><?php echo $number[0] ?></h1>
      <p>Pending</p>
      <h1><?php echo $number[1] ?></h1>
    </div>
    <div class="dashboard-column">
      <p>Veterinarian</p>
      <h1><?php echo $number[2] ?></h1>
      <p>Pending</p>
      <h1><?php echo $number[3] ?></h1>
    </div>
  </div>
</div>
  <div class="dashboard-container" id="dashboard-pet" style="width:65%;margin-left: 2%;">
    <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column">
      <p>Rehoming</p>
      <h1><?php echo $number2[0] ?></h1>
      <p>Adopted</p>
      <h1><?php echo $number2[1] ?></h1>
    </div>
    <div class="dashboard-column">
      <p>Selling</p>
      <h1><?php echo $number2[2] ?></h1>
      <p>Purchased</p>
      <h1><?php echo $number2[3] ?></h1>
    </div>
  </div>
</div>
</div>
<div class="content-row">
  <div class="dashboard-container" id="dashboard-owner">
    <div class="dashboard-overlay" style="display: flex;flex-direction: column;width: 100%;height: 100%;">
    <div class="dashboard-column" style="width: 100%;">
      <p>Pet Owner</p>
      <h1><?php echo $number3 ?></h1>
    </div>
    </div>
  </div>

  <div class="dashboard-container" id="dashboard-adopter">
    <div class="dashboard-overlay" style="display: flex;flex-direction: column;width: 100%;height: 100%;">
    <div class="dashboard-column" style="width: 100%;">
      <p>Adopter</p>
      <h1><?php echo $number4 ?></h1>
    </div>
    </div>
  </div>
    <div class="dashboard-container" id="dashboard-organization">
      <div class="dashboard-overlay" style="display: flex;flex-direction: column;width: 100%;height: 100%;">
      <div class="dashboard-column"  style="width: 100%;">
      <p>Organization</p>
      <h1><?php echo $number5 ?></h1>
    </div>
    </div>
  </div>
    <div class="dashboard-container" id="dashboard-breed">
      <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column">
      <p style="text-align:center">Cat Breed</p>
      <h1><?php echo $number6[0] ?></h1>
    </div>
    <div class="dashboard-column">
      <p style="text-align:center">Dog Breed</p>
      <h1><?php echo $number6[1] ?></h1>
    </div>
  </div>
</div>
</div>
</div>

</body>
</html>
