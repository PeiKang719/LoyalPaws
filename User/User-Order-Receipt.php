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
<link rel="stylesheet" type="text/css" href="css/UserStyle.css">
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
    include '../Database/Connection.php';
    $paymentID=$_GET['paymentID'];
    $adopterID=$_GET['adopterID'];

    $sql= "SELECT pp.transactionID,pp.complete_date,p.sellerID,p.shopID,b.name,p.price FROM pet_payment pp,pet p,breed b WHERE pp.petID=p.petID AND p.breedID=b.breedID AND pp.paymentID='$paymentID'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if($row['sellerID']!=NULL){
      $sql3 = "SELECT CONCAT(firstName, ' ', lastName) AS sname, email, phone, address, area, state FROM seller WHERE sellerID = " . $row['sellerID'];
    }elseif($row['shopID']!=NULL){
      $sql3= "SELECT shopname AS sname,email,phone,address,area,state FROM pet_shop WHERE shopID=". $row['shopID'];
    }

    $sql2 = "SELECT * FROM adopter WHERE adopterID='$adopterID'";

    
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $result3 = $conn->query($sql3);
    $row3 = $result3->fetch_assoc();

?>
<!-- Container -->
<div style="width: 80%;padding: 1% 3%;border: 3px solid black;position: relative;margin-right: auto;margin-left: auto;background-color: white;">
<div class="receipt-container" id="invoice">

  <!-- Header -->
  <header>
  <div>
    <div style="text-align: center;">
      <img style="width:200px; height:50px; border-radius:100px; margin-top:10px;" id="logo" src="../media/lp.png" title="Clinic Logo" alt="Clinic Logo" />
    </div>

     
  </div>
  </header>
  
  <!-- Main Content -->
  <main  id="receipt">
     <h1 style="margin-left:6px">Pet Purchase Receipt</h1>
     <hr>

  <div class="receipt-container-row">
    <div class="receipt-container-row-content"> 
      <div ><strong>Transaction ID:</strong> <?php echo $row['transactionID']; ?> </div>
    </div>

    <div class="receipt-container-row-content" style="padding-left:13%;width: 37%;">
     <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    ?>
    <div ><strong>Date:</strong> <?php echo $row['complete_date']; ?> </div>
  </div>
</div>


  <hr>
  <div class="receipt-container-row">
    <div class="receipt-container-row-content"> <strong>FROM</strong>
      <address><div>
      <?php echo $row3['sname'] ?><br />
      +6<?php echo $row3['phone'] ?><br />
      <?php echo $row3['email'] ?><br>
      <?php echo $row3['address'] ?>, <br>
      <?php echo $row3['area'] ?>,<br>
      <?php echo $row3['state'] ?>.</div>
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
          <th style="width: 600px;">Item</th>
          <th width="130px">Unit Price</th>
          <th width="120px">Quantity</th>
          <th width="147px">Total</th>

          <tr>
            <td class="td1"><b><?php echo $row['name'] ?></b></td>
            <td style="text-align: center;">RM <?php echo$row['price'] ?></td>
            <td style="text-align: center;"> 1 </td>
            <td style="text-align: center;">RM <?php echo $row['price'] ?></td>
          </tr>

          <tr>
            <td colspan="3" class="total_row" style="text-align: right;background-color: #e6f5ff;"><b>Total:</b></td>
            <td colspan="3" class="total_row" width="138px" style="text-align: center;"><b>RM <?php echo $row['price'] ?></b></td>
          </tr>
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
      filename: 'invoice/purchase_receipt/' + currentDate,
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