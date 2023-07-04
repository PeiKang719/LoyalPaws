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
<style type="text/css">
  .confirmBtn{
    width: 30%;
    border: 0;
    color: white;
    background-color: #29a329;
    border-radius: 5px;
    font-size: 30px;
    padding: 5px 10px;
    text-align: center;
    cursor: pointer;
    box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.2);
    margin: 0 10px;
  }
  .closeBtn{
    width: 30%;
    border: 0;
    color: #4d4d4d;
    background-color: white;
    border-radius: 5px;
    font-size: 30px;
    padding: 5px 10px;
    text-align: center;
    cursor: pointer;
    box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.2);
    margin: 0 10px;
  }
</style>
</head>

<body>
<?php include 'UserHeader.php' ?>
<div class="adoption-list-container">
  <h1>Adoption</h1>
  <div class="status-section">
    <a href="User-Adoption-List.php?s=Pending">
      <button class="status-button">Pending</button>
    </a>
    <a href="User-Adoption-List.php?s=Appointment">
      <button class="status-button">Appointment / Decision</button>
    </a>
    <a href="User-Adoption-List.php?s=Complete">
      <button class="status-button">Complete</button>
    </a>
  </div>
  <br>
  <div class="form-list-container">
    <?php 
        if (isset($_GET['s'])) {
            $s=$_GET['s'];
            if($s=='Pending'){
                pending($adopterID);
            }
            else if($s=='Appointment'){
                appointment($adopterID);
            }
            else if($s=='Complete'){
                complete($adopterID);
            }
        }
        if (!isset($_GET['s'])){
          pending($adopterID);
        }
        ?>


    <?php function pending($adopterID){ 
      $i=1;
      include 'Connection.php';
      $sql = "SELECT p.pet_image,p.gender,p.petID,b.name,i.status,i.inquiryID FROM pet p,breed b,inquiry i,adopter a WHERE p.breedID=b.breedID AND p.petID=i.petID AND i.adopterID=a.adopterID AND (i.status='Pending' OR i.status='Appointment') AND i.adopterID=$adopterID order by
       (case WHEN i.status='Appointment' then 1
       WHEN i.status='Pending' then 2
       END)";
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
        $inquiryID=$row['inquiryID'];?>
    <a href="Seller_Pets-Profile.php?id=<?php echo $petID ?>" class="form-list">
      <img src="<?php echo $imageSrc ?>" alt="pet">
      <?php if($gender=='Female'){?>
      <p><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -8px; color: #ff99ff; font-weight: 800;">female</span><?php echo $name ?></p>
    <?php } else{ ?>
      <p><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -8px; color: #1ab2ff; font-weight: 800;">male</span><?php echo $name ?></p>
    <?php } ?>
      <div style="width:40%;text-align:center">
      <?php if($status=='Pending'){?>
    <button class="form-list-button" disabled>Schedule Visit</button>
  <?php } elseif($status=='Appointment'){?>
    <button class="form-list-button up" id="visit<?php echo $i?>" onclick="booking(event,<?php echo $i?>);">Schedule Visit</button>
    <input type="hidden" id="iid<?php echo $i ?>" value="<?php echo $inquiryID ?>">
    <input type="hidden" id="pid<?php echo $i ?>" value="<?php echo $petID ?>">
  <?php } ?>
      <button class="form-list-button" id="form-list-button-red" onclick="cancel(event,<?php echo $inquiryID ?>)">Cancel</button>
    </div>
  </a>
  
<?php $i++;}}else{?>
  <img src="media/no-document.jpg" width="300px" height="300px">
<?php }
      } ?>

      <?php function appointment($adopterID){ 
      $j=1;
      include 'Connection.php';
      $sql = "SELECT p.pet_image,p.gender,p.petID,b.name,m.status,m.paymentID,m.visit_time,m.visit_date,p.price,p.sellerID,p.shopID FROM pet p,breed b,adopter a,pet_payment m WHERE p.breedID=b.breedID AND p.petID=m.petID AND m.adopterID=a.adopterID AND (m.status='Decision' OR m.status='y' OR m.status='Y' OR m.status='Payment' OR m.status='Free') AND m.adopterID=$adopterID ORDER BY m.visit_date,m.visit_time";
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
      <?php if($status=='y'){?>
      <button class="form-list-button down" style="width: 90%;font-size: 23px;" disabled>Waiting response from pet owner...</button>
      
    <?php }
    elseif($status=='Payment'){?>
      <button class="form-list-button" id="form-list-button-payment<?php echo $j?>" onclick="payment(event,<?php echo $j?>,<?php echo $price?>)" style="width: 90%;font-size: 23px;background-color: #00cc00;color: white;cursor: pointer;">Make Payment</button>
    <?php }
    else{ ?>
      <button class="form-list-button" id="form-list-button-red" onclick="adoptModal(event,<?php echo $j?>)" style="background-color: #29a329;"><span class="material-symbols-outlined"  style="vertical-align:-8px;font-weight: bold;color: white;font-size: 35px;">check</span>Adopt</button>
      <button class="form-list-button" id="form-list-button-red" onclick="cancel2(event,<?php echo $paymentID ?>)"><span class="material-symbols-outlined" style="vertical-align:-8px;font-weight: bold;color: white;font-size: 35px;">close</span>Reject</button>
    <?php } ?>
      <input type="hidden" id="pid<?php echo $j ?>" value="<?php echo $petID ?>">
    <input type="hidden" id="mid<?php echo $j ?>" value="<?php echo $paymentID ?>">
    </div>
  </a>

  <div id="PaymentModal<?php echo$j ?>" class="modal">
  <div class="modal-content" style="height: auto;padding-bottom: 40px;margin-bottom: 70px;">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Payment</h2>
    </div>
    <div style="width: 100%;display: flex;flex-direction: column; align-items: center;">
      <br><br>
    <img src="<?php echo $imageSrc ?>" style="width:300px;height:180px">
    <table width="40%" border="0" style="margin:25px 0">
      <tr>
        <td style="font-size: 30px;">Amount</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;">RM <?php echo number_format((float)$price, 2, '.', ''); ?></p></td>
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

<div id="agreementModal<?php echo$j ?>" class="modal">
  <div class="modal-content" style="height: auto;padding-bottom: 40px;margin-top:-15px">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Agreement</h2>
    </div>
    <div style="width: 100%;display: flex;flex-direction: column; align-items: center;">
      <br><br>
    <div style="width: 90%;padding: 0 5%;font-size: 20px;">
    <h2>Adoption Terms</h2><br>
    <p>I, the undersigned adopter, agree to the following terms and conditions:</p>
    <ol>
      <li style="margin-top: 5px;">1. The pet will be given proper care, including adequate food, water, shelter, and veterinary care.</li>
      <li style="margin-top: 5px;">2. The pet will receive necessary vaccinations and regular veterinary check-ups as recommended by the veterinarian.</li>
      <?php if($price>0){ ?>
      <li style="margin-top: 5px;">3. I understand that the adoption fee for the pet is RM <?php echo $price?>. This fee covers the costs associated with the adoption process and the care provided to the pet prior to adoption.</li>
    <?php }else{ ?>
      <li style="margin-top: 5px;">3. I understand that there is no adoption fee for the pet.</li>
    <?php } ?>
      <li style="margin-top: 5px;">4. I will not subject the pet to any form of abuse, neglect, or cruelty.</li>
      <li style="margin-top: 5px;">5. If for any reason I am no longer able to care for the pet, I will contact the adoption organization to arrange for its return.</li>
      <li style="margin-top: 5px;">6. I acknowledge and agree to the terms and conditions outlined in this adoption agreement. I understand that by proceeding with the adoption process, I am legally bound by these terms.</li>
    </ol>
  </div>
    
  </div>
  <div style="width: 100%;display: flex;flex-direction: row;justify-content: center;align-items: center;margin-top: 50px;">
    <button class="closeBtn" id="closeBtn<?php echo$j ?>">Close</button>
    <button class="confirmBtn" id="confirmBtn<?php echo$j ?>">Confirm</button>
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
      $sql = "SELECT p.pet_image,p.gender,p.petID,b.name,m.status,m.paymentID,m.transactionId,m.complete_date,p.price,p.sellerID,p.shopID FROM pet p,breed b,pet_payment m,adopter a WHERE p.breedID=b.breedID AND p.petID=m.petID AND m.adopterID=a.adopterID AND BINARY m.status='Complete' AND m.adopterID=$adopterID order by m.complete_date";
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
     
    <button class="form-list-button up" id="detials<?php echo $k?>" onclick="details(event,<?php echo $paymentID?>);" style="width: 60%;">Adoption Agreement</button>
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
        <td><p style="font-size: 30px;">RM <?php echo number_format((float)$price, 2, '.', ''); ?></p></td>
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
$k++;}}else{?>
  <img src="media/no-document.jpg" width="300px" height="300px">
<?php }} ?>
  </div>


</div>








<script type="text/javascript">
  $(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('s');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'Pending') {
    $('a[href*="User-Adoption-List.php?s=Pending"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="User-Adoption-List.php?s=Appointment"]').css('border-bottom', '0');
    $('a[href*="User-Adoption-List.php?s=Complete"]').css('border-bottom', '0');
  } else if (sValue === 'Appointment') {
    $('a[href*="User-Adoption-List.php?s=Appointment"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="User-Adoption-List.php?s=Pending"]').css('border-bottom', '0');
    $('a[href*="User-Adoption-List.php?s=Complete"]').css('border-bottom', '0');
  }
  else if (sValue === 'Complete') {
    $('a[href*="User-Adoption-List.php?s=Complete"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="User-Adoption-List.php?s=Pending"]').css('border-bottom', '0');
    $('a[href*="User-Adoption-List.php?s=Appointment"]').css('border-bottom', '0');
  }
  else{
    $('a[href*="User-Adoption-List.php?s=Pending"]').css('border-bottom', '5px solid #00a8de');
  }
});

  function booking(event, i) {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior
    var id= document.getElementById("pid"+i).value;
    var iid= document.getElementById("iid"+i).value;
    window.location.href = "User-Adoption-List-Appointment.php?id="+ id+"&iid="+iid;
  }

  function cancel(event,i) {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior
    window.location.href = "User-Adoption-Book-Process.php?id="+i+"&r=reject";
  }

  function booking2(event, i) {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior
    var id= document.getElementById("pid"+i).value;
    var mid= document.getElementById("mid"+i).value;
    window.location.href = "User-Adoption-List-Appointment.php?id="+ id+"&iid="+mid+"&u=update";
  }


function adoptModal(event, i) {
  event.preventDefault(); // Prevents anchor tag from triggering its default behavior
  
  // Show the modal pop-up
  var modal = document.getElementById("agreementModal"+i);
  modal.style.display = "block";
  var span = modal.getElementsByClassName("close")[0];
  // Add event listeners to the buttons
  var confirmBtn = document.getElementById("confirmBtn"+i);
  var cancelBtn = document.getElementById("closeBtn"+i);
  confirmBtn.addEventListener("click", function() {
    closeModal(i);
    executeAdopt(i);
  });
  cancelBtn.addEventListener("click", function() {
    closeModal(i);
  });
  span.onclick = function() {
      modal.style.display = "none";
    }
}
  function executeAdopt(i) {
     var mid= document.getElementById("mid"+i).value;
    window.location.href = "User-Adoption-Book-Process.php?iid="+mid+"&u=udecision";
    
  }
function closeModal(i) {
  var modal = document.getElementById("agreementModal" + i);
  modal.style.display = "none";
}

  function cancel2(event, i) {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior
    if (confirm("Are you sure you want to reject this adoption?")) {
    window.location.href = "User-Adoption-Book-Process.php?id="+i+"&r=fail";
  }
}


 function payment(event,n,price){
  event.preventDefault();
    var modal = document.getElementById("PaymentModal"+n);
    var btn = document.getElementById("form-list-button-payment"+n);
    // Get the <span> element that closes the modal
    var mid= document.getElementById("mid"+n).value;
    var pid= document.getElementById("pid"+n).value;
    var span = modal.getElementsByClassName("close")[0];
    console.log(price);

    // When the user clicks the button, open the modal 

      modal.style.display = "block"; 
    

    // When the user clicks on <span> (x), close the modal
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
              value: price
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
    var url = "User-Adoption-Book-Process.php?u=upayment&iid=" + mid + "&pid=" + pid +"&transactionId=" + encodeURIComponent(transactionId);

    // Redirect to the URL
    window.location.href = url;
  });
}

  }).render('#paypal-payment-button'+n);
}


function details(event, i) {
  event.preventDefault();
  window.open("User-Adoption-Receipt.php?paymentID=" + i, "_blank");
}

</script>
</body>
</html>