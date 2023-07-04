<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LoyalPaws</title>
	<link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="UserStyle.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<?php 
if(isset($_GET['role'])){
  include 'ClinicHeader.php';
}else{
include 'UserHeader.php';
}
      include 'Connection.php';
$recordID = $_GET['recordID'];
$sql = "SELECT tr.recordID,tr.treatmentID,t.name,t.description,t.unit_price,tr.quantity,(tr.quantity*t.unit_price) AS total,r.comment,r.date,r.pet_name FROM treatment_record tr,treatment t,record r WHERE tr.treatmentID=t.treatmentID AND tr.recordID=r.recordID AND r.recordID=$recordID";

$sql2 = "SELECT r.pet_name,r.date,r.comment,r.extra,r.discount,ca.petID FROM record r,clinic_appointment ca,clinic c WHERE ca.clinicID=c.clinicID AND r.appointmentID=ca.appointmentID AND r.recordID=$recordID";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
$pet_name = $row2['pet_name'];
$date = $row2['date'];
$comment = $row2['comment'];
$petID = $row2['petID'];
$extra = $row2['extra'];
if($extra!=NULL){
  $each_treatments=explode("$",$extra);

  }
?>

  <div class="treatment-record-container">
    <div class="treatment-record">
        <h1>Treatment Record</h1>
        <div style="display:flex;flex-direction: row;font-size: 27px;align-items: flex-start;width: 100%;">
        <label>Pet Name: </label>
        <p><b><?php echo $pet_name ?></b></p>
        <p style="margin-left:660px;">Date:<b> <?php echo $date ?></b></p>
      </div>
      <br><br>
        <table class="treatment-record-table" border="1">
          <th style="width: 600px;">Treatment</th>
          <th width="130px">Unit Price</th>
          <th width="120px">Quantity</th>
          <th width="147px">Total</th>

          <?php
          $sub_total=0;
          $result = $conn->query($sql);
          $rows = $result->fetch_all(MYSQLI_ASSOC);
          foreach ($rows as $row) { 
          $unit_price = $row['unit_price'];
          $quantity = $row['quantity'];
          $total = $row['total'];
          $description = $row['description'];
          $tname = $row['name'];
          $sub_total+=$total;
           ?>
          <tr>
            <td class="td1"><b><?php echo $tname ?></b></td>
            <td rowspan="2" style="text-align: center;">RM <?php echo $unit_price ?></td>
            <td rowspan="2" style="text-align: center;"><?php echo $quantity ?></td>
            <td rowspan="2" style="text-align: center;">RM <?php echo $total ?></td>
          </tr>
          <tr>
            <td class="td2"><?php echo $description ?></td>
          </tr>
        <?php } ?>

        <?php 
        if(isset($each_treatments)){
        foreach ($each_treatments as $each_treatment) {
          $components = explode("^", $each_treatment);
            $sub_total+=($components[1] * $components[2]);
           ?>
       
          <tr>
            <td class="td1"><b><?php echo $components[0] ?></b></td>
            <td rowspan="2" style="text-align: center;">RM <?php echo $components[1] ?></td>
            <td rowspan="2" style="text-align: center;"><?php echo $components[2] ?></td>
            <td rowspan="2" style="text-align: center;">RM <?php echo $components[1] * $components[2] ?></td>
          </tr>
          <tr>
            <td class="td2"><?php echo $components[3] ?></td>
          </tr>
          
       <?php }}?>

          <?php if($petID != NULL){?>
            <tr>
            <td colspan="3" class="total_row" style="text-align: right;background-color: #e6f5ff;">Adopter Exclusive Discount (<?php echo $row2['discount'] ?>%):</td>
            <td colspan="3" class="total_row" width="145px" style="text-align: center;">-RM <?php echo number_format($row2['discount']/100*$sub_total,2); ?></td>
          </tr>
          <tr>
            <td colspan="3" class="total_row" style="text-align: right;background-color: #e6f5ff;"><b>Sub-Total:</b></td>
            <td colspan="3" class="total_row" width="145px" style="text-align: center;"><b>RM <?php echo number_format($sub_total*(1-$row2['discount']/100),2); ?></b></td>

          </tr>
          <?php }else{ ?>
          <tr>
            <td colspan="3" class="total_row" style="text-align: right;background-color: #e6f5ff;"><b>Sub-Total:</b></td>
            <td colspan="3" class="total_row" width="145px" style="text-align: center;"><b>RM <?php echo number_format($sub_total,2); ?></b></td>
          </tr>
        <?php } ?>
        </table> 
 


        <br><br><br><br>
        <div style="display:flex;flex-direction: row;font-size: 27px;align-items: flex-start;width: 100%;">
        <p>Comment:<b> <?php echo $comment ?></b></p>    
      </div>
    </div>
  </div>
</body>
</html>