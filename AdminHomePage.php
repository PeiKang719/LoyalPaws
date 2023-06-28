<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="media/tabIcon.png">
  <link rel="stylesheet" type="text/css" href="AdminStyle.css">
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
  </style>
</head>
<body style="background-color:white">
  <?php include'AdminHeader.php' ?>

<div class="content">
  <div class="content-row">
  <div class="dashboard-container" id="dashboard-clinic" style="width:34%;">
    <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column">
      <p>Clinic</p>
      <p>20</p>
      <p>Pending</p>
      <p>2</p>
    </div>
    <div class="dashboard-column">
      <p>Veterinarian</p>
      <p>67</p>
      <p>Pending</p>
      <p>12</p>
    </div>
  </div>
</div>
  <div class="dashboard-container" id="dashboard-pet" style="width:65%;margin-left: 2%;">
    <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column">
      <p>Rehome</p>
      <p>20</p>
      <p>Adopted</p>
      <p>2</p>
    </div>
    <div class="dashboard-column">
      <p>Sell</p>
      <p>67</p>
      <p>Purchased</p>
      <p>12</p>
    </div>
  </div>
</div>
</div>
<div class="content-row">
  <div class="dashboard-container" id="dashboard-owner">
    <div class="dashboard-overlay" style="display: flex;flex-direction: column;width: 100%;height: 100%;">
    <div class="dashboard-column" style="width: 100%;">
      <p>Pet Owner</p>
      <p>20</p>
    </div>
    </div>
  </div>

  <div class="dashboard-container" id="dashboard-adopter">
    <div class="dashboard-overlay" style="display: flex;flex-direction: column;width: 100%;height: 100%;">
    <div class="dashboard-column" style="width: 100%;">
      <p>Adopter</p>
      <p>20</p>
    </div>
    </div>
  </div>
    <div class="dashboard-container" id="dashboard-organization">
      <div class="dashboard-overlay" style="display: flex;flex-direction: column;width: 100%;height: 100%;">
      <div class="dashboard-column"  style="width: 100%;">
      <p>Organization</p>
      <p>20</p>
    </div>
    </div>
  </div>
    <div class="dashboard-container" id="dashboard-breed">
      <div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;">
    <div class="dashboard-column">
      <p>Cat Breed</p>
      <p>20</p>
    </div>
    <div class="dashboard-column">
      <p>Dog Breed</p>
      <p>67</p>
    </div>
  </div>
</div>
</div>
</div>

</body>
</html>
