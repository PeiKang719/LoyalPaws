<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Caleb Adeleye">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
<title>Pet Adoption Agreement </title>
<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<link rel="stylesheet" type="text/css" href="UserStyle.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script src="https://use.fontawesome.com/65eb163cd4.js"></script>
<style type="text/css">
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
</style>
</head>
<body>

  <?php
  $paymentID = $_GET['paymentID'];
  include 'Connection.php';
  $sql = "SELECT a.firstName,a.lastName,a.phone,a.email,b.name,p.gender,p.birthday,p.color,p.price,p.return_date,pp.complete_date FROM pet_payment pp,adopter a,pet p,breed b WHERE pp.adopterID=a.adopterID AND pp.petID=p.petID AND p.breedID=b.breedID AND pp.paymentID=$paymentID";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc(); 
  ?>
  <div style="width: 80%;padding: 1% 5%;border: 3px solid black;position: relative;margin-right: auto;margin-left: auto;background-color: white;">
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
     <h1 style="margin-left:6px">Pet Adoption Agreement</h1>
     <hr>

  <div class="receipt-container-row">
    <div class="receipt-container-row-content"> <strong>PET INFORMATION</strong>
      <address><div>
      BREED: <?php echo $row['name'] ?><br />
      BIRTHDAY: <?php echo $row['birthday'] ?><br />
      GENDER: <?php echo $row['gender'] ?><br>
      COLOR: <?php echo $row['color'] ?><br></div>
      </address>
    </div>

    <div class="receipt-container-row-content" style="padding-left:13%;width: 37%;"> <strong>ADOPTER</strong>
      <address>
        <div >
      FULL NAME: <?php echo $row['firstName'].' '.$row['lastName'] ?><br />
      EMAIL: <?php echo $row['email']; ?><br />
      CONTACT NO: <?php echo $row['phone']; ?></div>
      </address>
    </div>
  </div>
  
  <div >
    <h2>Adoption Terms</h2>
    <p>I, the undersigned adopter, agree to the following terms and conditions:</p>
    <ol>
      <li>The pet will be given proper care, including adequate food, water, shelter, and veterinary care.</li>
      <?php if($row['return_date']!=NULL && $row['return_date']!='0000-00-00'){ ?>
      <li>2. This pet will be returned to previous owner on <?php echo $row['return_date']?>.</li>
      <?php }else{ ?>
      <li>2. I understand that there is no return date for the pet.</li>
    <?php } ?>
      <?php if($row['price']>0){ ?>
      <li>I understand that the adoption fee for the pet is RM <?php echo $row['price']?>. This fee covers the costs associated with the adoption process and the care provided to the pet prior to adoption.</li>
    <?php }else{ ?>
      <li>I understand that there is no adoption fee for the pet.</li>
    <?php } ?>
      <li>I will not subject the pet to any form of abuse, neglect, or cruelty.</li>
      <li>If for any reason I am no longer able to care for the pet, I will contact the adoption organization to arrange for its return.</li>
      <li>I acknowledge and agree to the terms and conditions outlined in this adoption agreement. I understand that by proceeding with the adoption process, I am legally bound by these terms.</li>
    </ol>
  </div>

<?php 
$date_only = date('Y-m-d', strtotime($row['complete_date']));
?>
  <div class="signature" style="display: flex;flex-direction: row;">
    <p>Date:</p><p style="text-decoration:underline;width: 200px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $date_only ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    
  </div>
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
      filename: 'invoice/adoption_agreement/' + currentDate,
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { scale: 2 },
      jsPDF: { unit: 'pt', format: 'a4', orientation: 'landscape' }
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