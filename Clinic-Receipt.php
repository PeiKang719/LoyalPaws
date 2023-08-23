<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Caleb Adeleye">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
<title>Receipt </title>
<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<link rel="stylesheet" type="text/css" href="UserStyle.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script src="https://use.fontawesome.com/65eb163cd4.js"></script>

<style type="text/css">
  .receiptTab th, .receiptTab td {
    border: 2px solid black;
  }
  body{
    height: 100%;
    background-color: #bfbfbf;
  }
  header{
    width: 85%;
  }
  hr{
    width: 100%;
    border: 1px solid #4d4d4d;
    margin: 10px 0;
  }
  .treatment-record-table th{
    font-size: 25px;
  }
</style>
</head>

<body>
<?php
    include 'Connection.php';
    $paymentID=$_GET['paymentID'];
    $adopterID=$_GET['adopterID'];

    $sql= "SELECT cp.transactionID,cp.date,cp.recordID,c.address,c.area,c.state,c.phone,c.name,c.email,r.discount,ca.petID FROM clinic_payment cp,record r,clinic_appointment ca,clinic c WHERE cp.recordID=r.recordID AND r.appointmentID=ca.appointmentID AND ca.clinicID=c.clinicID AND cp.paymentID='$paymentID'";
    $sql2 = "SELECT * FROM adopter WHERE adopterID='$adopterID'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $petID=$row['petID'];

    $sql3 = "SELECT tr.recordID,tr.treatmentID,t.name,t.description,t.unit_price,tr.quantity,(tr.quantity*t.unit_price) AS total,r.comment,r.date,r.pet_name FROM treatment_record tr,treatment t,record r WHERE tr.treatmentID=t.treatmentID AND tr.recordID=r.recordID AND r.recordID=".$row['recordID'];

    $sql5 = "SELECT extra FROM record WHERE recordID=".$row['recordID'];
$result5 = $conn->query($sql5);
$row5 = $result5->fetch_assoc();
$extra = $row5['extra'];
if($extra!=NULL){
  $each_treatments=explode("$",$extra);

  }
  if($petID != NULL){
  $sql9 = "SELECT purpose from pet WHERE petID=$petID;";
  $result9 = $conn->query($sql9);
  $row9 = $result9->fetch_assoc();
}
?>
<!-- Container -->
<div style="width: 80%;padding: 1% 3%;border: 3px solid black;position: relative;margin-right: auto;margin-left: auto;background-color: white;">
<div class="receipt-container" id="invoice">

  <!-- Header -->
  <header>
  <div>
    <div style="text-align: center;">
      <img style="width:200px; height:50px; border-radius:100px; margin-top:10px;" id="logo" src="media/lp.png" title="Clinic Logo" alt="Clinic Logo" />
    </div>

     
  </div>
  </header>
  
  <!-- Main Content -->
  <main  id="receipt">
     <h1 style="margin-left:6px">Receipt</h1>
     <hr>

  <div class="receipt-container-row">
    <div class="receipt-container-row-content"> 
      <div ><strong>Transaction ID:</strong> <?php echo $row['transactionID']; ?> </div>
    </div>

    <div class="receipt-container-row-content" style="padding-left:13%;width: 37%;">
     <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    ?>
    <div ><strong>Date:</strong> <?php echo $row['date']; ?> </div>
  </div>
</div>


  <hr>
  <div class="receipt-container-row">
    <div class="receipt-container-row-content"> <strong>CLINIC ADDRESS</strong>
      <address><div>
      <?php echo $row['name'] ?><br />
      +6<?php echo $row['phone'] ?><br />
      <?php echo $row['email'] ?><br>
      <?php echo $row['address'] ?>, <br>
      <?php echo $row['area'] ?>,<br>
      <?php echo $row['state'] ?>.</div>
      </address>
    </div>

    <div class="receipt-container-row-content" style="padding-left:13%;width: 37%;"> <strong>Payment By</strong>
      <address>
        <div >
      FULL NAME: <?php echo $row2['firstName'].' '.$row2['lastName'] ?><?php echo " " ?><br />
      EMAIL: <?php echo $row2['email']; ?><br />
      CONTACT NO: <?php echo $row2['phone']; ?></div>
      </address>
    </div>
  </div>
  
  <div >
    <div >
      <div >
        <table class="treatment-record-table" border="1" style="width: 100%;">
          <th style="width: 600px;">Treatment</th>
          <th width="130px">Unit Price</th>
          <th width="120px">Quantity</th>
          <th width="147px">Total</th>

          <?php
          $sub_total=0;
          $result3 = $conn->query($sql3);
          $rows3 = $result3->fetch_all(MYSQLI_ASSOC);
          foreach ($rows3 as $row3) { 
          $unit_price = $row3['unit_price'];
          $quantity = $row3['quantity'];
          $total = $row3['total'];
          $description = $row3['description'];
          $tname = $row3['name'];
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
        <?php
          if($row['petID'] != NULL AND $row9['purpose']!='Sell'){?>
            <tr>
            <td colspan="3" class="total_row" style="text-align: right;background-color: #e6f5ff;">Adopter Exclusive Discount (<?php echo $row['discount'] ?>%):</td>
            <td colspan="3" class="total_row" width="138px" style="text-align: center;">-RM <?php echo number_format($row['discount']/100*$sub_total,2)?></td>
          </tr>
          <tr>
            <td colspan="3" class="total_row" style="text-align: right;background-color: #e6f5ff;"><b>Sub-Total:</b></td>
            <td colspan="3" class="total_row" width="138px" style="text-align: center;"><b>RM <?php echo number_format($sub_total*(1-$row['discount']/100),2) ?></b></td>
          </tr>
          <?php }else{ ?>
          <tr>
            <td colspan="3" class="total_row" style="text-align: right;background-color: #e6f5ff;"><b>Sub-Total:</b></td>
            <td colspan="3" class="total_row" width="138px" style="text-align: center;"><b>RM <?php echo number_format($sub_total,2) ?></b></td>
          </tr>
        <?php } ?>
        </table> 
      </div>
    </div>
  </div>
  <p class="text-1"><strong>NOTE :</strong> Any alteration on this receipt will be rendered invalid.</p>
 <br>
  </div>

  </main>
</div>
  <!-- Footer -->
  <footer >
  

 <br>
  <div class="receipt-button-container"> 
    <a href="javascript:window.print()" style="font-size:20px; font-weight: bold; color:black;" class="receipt-button"><i class="fa fa-print"></i> Print</a> 
    <a href="#" style="font-size:20px; font-weight: bold; color:black;" id="download" class="receipt-button"><i class="fa fa-download"></i> Download</a> 
    <a href="javascript:void(0)" style="font-size: 20px; font-weight: bold; color: black;" class="receipt-button" onclick="window.close()"><i class="fa fa-chevron-left"></i> Back</a>
</div>
  </footer> 
  <br><br>

  <script>
window.onload = function() {
  document.getElementById("download").addEventListener("click", () => {
    const invoice = document.getElementById("invoice");
    var currentDate = "<?php echo date('Y-m-d H:i:s'); ?>";
    var opt = {
      filename: 'invoice/receipt/' + currentDate,
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { scale: 2 },
      jsPDF: { unit: 'pt', format: 'a4', orientation: 'portrait' }
    };

    // Delay the PDF generation to allow content to load
    setTimeout(() => {
      html2pdf().from(invoice).set(opt).save();
    }, 500);
  });
}
    </script>
</body>
</html>