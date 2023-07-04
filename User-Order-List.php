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
<?php include 'UserHeader.php' ?>
<div class="adoption-list-container">
  <h1>Purchase</h1>
  <div class="status-section">
    <a href="User-Order-List.php?s=Appointment">
      <button class="status-button">Appointment / Decision</button>
    </a>
    <a href="User-Order-List.php?s=Complete">
      <button class="status-button">Complete</button>
    </a>
    <a href="User-Order-List.php?s=Refund">
      <button class="status-button">Refund</button>
    </a>
  </div>
  <br>
  <div class="form-list-container">
    <?php 
        if (isset($_GET['s'])) {
            $s=$_GET['s'];
            if($s=='Appointment'){
                appointment($adopterID);
            }
            else if($s=='Complete'){
                complete($adopterID);
            }
            else if($s=='Refund'){
                refund($adopterID);
            }
        }
        elseif (!isset($_GET['s'])){
          appointment($adopterID);
        }
        ?>

      <?php function appointment($adopterID){ 
      $j=1;
      include 'Connection.php';
      $sql = "SELECT p.pet_image,p.gender,p.petID,b.name,m.status,m.paymentID,m.visit_time,m.visit_date,p.price,p.sellerID,p.shopID FROM pet p,breed b,adopter a,pet_payment m WHERE p.breedID=b.breedID AND p.petID=m.petID AND m.adopterID=a.adopterID AND BINARY m.status='appointment' AND m.adopterID=$adopterID ORDER BY m.visit_date,m.visit_time";
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    if ($result->num_rows > 0) {
    foreach ($rows as $row) { 
          $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
        $petID=$row['petID'];
        $price=$row['price'];
        $gender=$row['gender'];
        $name=$row['name'];
        $status=$row['status'];
        $paymentID=$row['paymentID'];
        $visit_date=$row['visit_date'];
        $visit_time=$row['visit_time'];
        $sellerID=$row['sellerID'];
        $shopID=$row['shopID'];

        if ($row['sellerID'] !== NULL) {
          $sql11 = "SELECT CONCAT(firstName,' ' ,LastName) AS sname FROM seller WHERE sellerID = " . $row['sellerID'];
        }
       elseif($row['shopID']!==NULL){
         $sql11 ="SELECT shopname AS sname from pet_shop where shopID = " . $row['shopID'];
        }

      $result11 = $conn->query($sql11);
      $row11 = $result11->fetch_assoc();
        ?>
        <input type="hidden" name="pid" id="pid<?php echo $j ?>" value="<?php echo $petID?>">
        <input type="hidden" name="mid" id="mid<?php echo $j ?>" value="<?php echo $paymentID?>">
    <a href="Seller_Pets-Profile.php?id=<?php echo $petID ?>" class="form-list">
      <img src="<?php echo $imageSrc ?>" alt="pet">
      <div style="display:flex;flex-direction: column;width: 45%;">
      <?php if($gender=='Female'){?>
      <div style="display:flex;flex-direction: row;width: 100%;margin-left: 20px;"><p style="width: 100%;"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -8px; color: #ff99ff; font-weight: 800;">female</span><?php echo $name ?></p></div>
    <?php } else{ ?>
      <div style="display:flex;flex-direction: row;width: 100%;margin-left: 20px;"><p  style="width: 100%;"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -8px; color: #1ab2ff; font-weight: 800;">male</span><?php echo $name ?></p></div>
    <?php } ?>
      <div style="display:flex;flex-direction: row;width: 100%;margin-left: 20px;"><p style="width: 100%;font-size: 27px;font-weight: normal;"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -8px; color: #000000; font-weight: 800;">event</span><?php echo $visit_date ?> <?php echo $visit_time ?></p></div>
      <?php if($status=='y' OR $status=='Y' OR $status=='Payment'){?>
      <button id="visit<?php echo $j?>" onclick="booking2(event,<?php echo $j?>);" style="width: 47%;position: relative;margin-left: auto;margin-right: auto;" disabled>Reschedule Visit</button>
    <?php }else{?>
      <button id="visit<?php echo $j?>" onclick="booking2(event,<?php echo $j?>);" style="width: 47%;position: relative;margin-left: auto;margin-right: auto;">Reschedule Visit</button>
    <?php } ?>
  </div>
      <div style="width:40%;text-align:center;">
      <button class="form-list-button" id="form-list-button-red" onclick="purchase(event,<?php echo $j?>,<?php echo $price ?>)" style="background-color: #29a329;"><span class="material-symbols-outlined"  style="vertical-align:-8px;font-weight: bold;color: white;font-size: 35px;">check</span>Purchase</button>
      <button class="form-list-button" id="form-list-button-red" onclick="cancel2(event,<?php echo $paymentID ?>)"><span class="material-symbols-outlined" style="vertical-align:-8px;font-weight: bold;color: white;font-size: 35px;">close</span>Reject</button>
      <input type="hidden" id="pid<?php echo $j ?>" value="<?php echo $petID ?>">
    <input type="hidden" id="mid<?php echo $j ?>" value="<?php echo $paymentID ?>">
    </div>
  </a>

  <div id="PaymentModal<?php echo$j ?>" class="modal">
  <div class="modal-content" style="height: auto;padding-bottom: 40px;margin-bottom: 30px;margin-top: -20px;">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Payment</h2>
    </div>
    <div style="width: 100%;display: flex;flex-direction: column; align-items: center;">
      <br><br>
    <img src="<?php echo $imageSrc ?>" style="width:300px;height:180px">
    <table width="60%" border="0" style="margin:25px 0">
      <tr>
        <td style="font-size: 30px;">Paid</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;">RM <?php echo number_format((float)$price*0.1, 2, '.', ''); ?></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Remaining amount</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><b>RM <?php echo number_format((float)$price*0.9, 2, '.', ''); ?></b></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Transfer to</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $row11['sname'] ?></p></td>
      </tr>
  </table>
    <div id="paypal-payment-button<?php echo$j ?>" style="width: 100%;margin-left: 170px;"></div>
    <script src="https://www.paypal.com/sdk/js?client-id=AVKhPyIREMp1EynqC_9932cWY2SPi_zMNmnSPlP9hyorwbiOogLrslLKz9bDhXs6vGQr9LYbD38_zapW&currency=MYR"></script>
  </div>
  </div>
</div>

<?php $j++;}}else{?>
  <img src="media/no-document.jpg" width="300px" height="300px">
<?php }
      }?>


<?php function complete($adopterID){
 include 'Connection.php';
 $k=1;
      $sql = "SELECT p.pet_image,p.gender,p.petID,b.name,m.status,m.paymentID,m.complete_date,p.price,p.sellerID,p.shopID,m.transactionId FROM pet p,breed b,pet_payment m,adopter a WHERE p.breedID=b.breedID AND p.petID=m.petID AND m.adopterID=a.adopterID AND BINARY m.status='complete' AND m.adopterID=$adopterID order by m.complete_date";
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    if ($result->num_rows > 0) {
    foreach ($rows as $row) { 
          $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
        $petID=$row['petID'];
        $gender=$row['gender'];
        $name=$row['name'];
        $status=$row['status'];
        $price=$row['price'];
        $paymentID=$row['paymentID'];
        $transactionId=$row['transactionId'];
        $completedate=$row['complete_date'];

         if ($row['sellerID'] !== NULL) {
          $sql11 = "SELECT CONCAT(firstName,' ' ,LastName) AS sname FROM seller WHERE sellerID = " . $row['sellerID'];
        }
       elseif($row['shopID']!==NULL){
         $sql11 ="SELECT shopname AS sname from pet_shop where shopID = " . $row['shopID'];
        }

      $result11 = $conn->query($sql11);
      $row11 = $result11->fetch_assoc();
        ?>
    <a href="Seller_Pets-Profile.php?id=<?php echo $petID ?>" class="form-list">
      <img src="<?php echo $imageSrc ?>" alt="pet">
      <?php if($gender=='Female'){?>
      <p><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -8px; color: #ff99ff; font-weight: 800;">female</span><?php echo $name ?></p>
    <?php } else{ ?>
      <p><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -8px; color: #1ab2ff; font-weight: 800;">male</span><?php echo $name ?></p>
    <?php } ?>
      <div style="width:40%;text-align:center">
     
    <button class="form-list-button up" id="detials<?php echo $k?>" onclick="details(event,<?php echo $paymentID?>,<?php echo $adopterID ?>);">Payment Detail</button>
    <input type="hidden" id="iid<?php echo $k ?>" value="<?php echo $paymentID ?>">
    </div>
  </a>


  <div id="DetailsModal<?php echo$k ?>" class="modal">
  <div class="modal-content" style="height: auto;padding-bottom: 40px;margin-top:130px">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Payment Details</h2>
    </div>
    <div style="width: 100%;display: flex;flex-direction: column; align-items: center;">
      <br><br>
    <table width="70%" border="0" style="margin:25px 0">
      <tr>
        <td style="font-size: 30px;">Payment No</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $transactionId ?></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Amount</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;">RM <?php echo $price ?></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Transfer to</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $row11['sname'] ?></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Completed date</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $completedate ?></p></td>
      </tr>
  </table>
    
  </div>
  </div>
</div>
<?php
$k++;
}}else{?>
  <img src="media/no-document.jpg" width="300px" height="300px">
<?php }}
      ?>

<?php function refund($adopterID){
include 'Connection.php';
 $k=1;
      $sql = "SELECT p.pet_image,p.gender,p.petID,b.name,m.status,m.paymentID,m.complete_date,p.price,p.sellerID,p.shopID,m.transactionId FROM pet p,breed b,pet_payment m,adopter a WHERE p.breedID=b.breedID AND p.petID=m.petID AND m.adopterID=a.adopterID AND (BINARY m.status='cancel' OR BINARY m.status='refund') AND m.adopterID=$adopterID order by m.complete_date";
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    if ($result->num_rows > 0) {
    foreach ($rows as $row) { 
          $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
        $petID=$row['petID'];
        $gender=$row['gender'];
        $name=$row['name'];
        $status=$row['status'];
        $price=$row['price'];
        $paymentID=$row['paymentID'];
        $transactionId=$row['transactionId'];
        $completedate=$row['complete_date'];

         if ($row['sellerID'] !== NULL) {
          $sql11 = "SELECT CONCAT(firstName,' ' ,LastName) AS sname FROM seller WHERE sellerID = " . $row['sellerID'];
        }
       elseif($row['shopID']!==NULL){
         $sql11 ="SELECT shopname AS sname from pet_shop where shopID = " . $row['shopID'];
        }

      $result11 = $conn->query($sql11);
      $row11 = $result11->fetch_assoc();
        ?>
    <a href="Seller_Pets-Profile.php?id=<?php echo $petID ?>" class="form-list">
      <img src="<?php echo $imageSrc ?>" alt="pet">
      <?php if($gender=='Female'){?>
      <p><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -8px; color: #ff99ff; font-weight: 800;">female</span><?php echo $name ?></p>
    <?php } else{ ?>
      <p><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -8px; color: #1ab2ff; font-weight: 800;">male</span><?php echo $name ?></p>
    <?php } ?>
      <div style="width:40%;text-align:center">
     <?php if($status=='cancel'){ ?>
    <button class="form-list-button up" id="detials<?php echo $k?>" disabled style="width: 60%;background-color: #e68a00 !important;"><span class="material-symbols-outlined"  style="vertical-align:-8px;font-weight: bold;color: white;font-size: 35px;">pending</span>Pending Refund</button>
  <?php }else{ ?>
    <button class="form-list-button up" id="detials<?php echo $k?>" disabled style="width: 60%;background-color: #29a329 !important;"><span class="material-symbols-outlined"  style="vertical-align:-8px;font-weight: bold;color: white;font-size: 35px;">done</span>Refunded</button>
  <?php } ?>
    <input type="hidden" id="iid<?php echo $k ?>" value="<?php echo $paymentID ?>">
    </div>
  </a>

<?php
$k++;
}}else{?>
  <img src="media/no-document.jpg" width="300px" height="300px">
<?php }}
      ?>
  </div>
</div>








<script type="text/javascript">
  $(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('s');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'Appointment') {
    $('a[href*="User-Order-List.php?s=Appointment"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="User-Order-List.php?s=Complete"]').css('border-bottom', '0');
    $('a[href*="User-Order-List.php?s=Refund"]').css('border-bottom', '0');
  } else if (sValue === 'Complete') {
    $('a[href*="User-Order-List.php?s=Complete"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="User-Order-List.php?s=Appointment"]').css('border-bottom', '0');
    $('a[href*="User-Order-List.php?s=Refund"]').css('border-bottom', '0');
  }
  else if (sValue === 'Refund') {
    $('a[href*="User-Order-List.php?s=Refund"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="User-Order-List.php?s=Appointment"]').css('border-bottom', '0');
    $('a[href*="User-Order-List.php?s=Complete"]').css('border-bottom', '0');
  }
  else{
    $('a[href*="User-Order-List.php?s=Appointment"]').css('border-bottom', '5px solid #00a8de');
  }
});

  function purchase(event,i,price) {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior

     if (!confirm('Are you sure you want to make this purchase?\n\nKindly make sure you have visited the pet and thought over the compatibility.')) {
    return; // Abort if the user cancels the confirmation
  }

     var modal= document.getElementById("PaymentModal"+i);
      var span = modal.getElementsByClassName("close")[0];
      var mid= document.getElementById("mid"+i).value;
     var pid= document.getElementById("pid"+i).value;
    // When the user clicks the button, open the modal 

      modal.style.display = "block"; 
    
    span.onclick = function() {
      modal.style.display = "none";
    }
    paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [
          {
            amount: {
              currency_code: 'MYR',
              value: price*0.9
            },
            billing_address: null
          }
        ],
        application_context: {
          shipping_preference: 'NO_SHIPPING'
        }
      });
    },
    onClick: function() {
      return { commit: false };
    },
    onApprove: function(data, actions) {
  return actions.order.capture().then(function(details) {
    // Extract the payment method and transaction ID from the PayPal response
    var transactionId = details.id;

    // Construct the URL with the query parameters
    var url = "User-Adoption-Book-Process.php?u=orderpayment&iid=" + mid + "&pid=" + pid +"&transactionId=" + encodeURIComponent(transactionId);

    // Redirect to the URL
    window.location.href = url;
  });
}

  }).render('#paypal-payment-button'+i);
}

function booking2(event, i) {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior
    var id= document.getElementById("pid"+i).value;
    var mid= document.getElementById("mid"+i).value;
    window.location.href = "User-Adoption-List-Appointment.php?id="+ id+"&iid="+mid+"&u=update";

  }

function cancel2(event, i) {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior
    if (!confirm('Are you sure you want to cancel this order?\n\nThe 10% booking fee will be refunded into your account.')) {
    return; // Abort if the user cancels the confirmation
  }
    window.location.href = "User-Adoption-Book-Process.php?id="+i+"&r=cancel";
  }

function details(event, i,adopterID) {
  event.preventDefault();
  window.open("User-Order-Receipt.php?adopterID="+adopterID+"&paymentID=" + i, "_blank");
}
</script>
</body>
</html>
