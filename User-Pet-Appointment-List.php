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
  <h1>Clinic Appointment</h1>
  <div class="status-section">
    <a href="User-Pet-Appointment-List.php?s=Appointment">
      <button class="status-button">Appointment</button>
    </a>
    <a href="User-Pet-Appointment-List.php?s=Pending">
      <button class="status-button">Pending Payment</button>
    </a>
    <a href="User-Pet-Appointment-List.php?s=History">
      <button class="status-button">History</button>
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
            else if($s=='Pending'){
                pending($adopterID);
            }
            else if($s=='History'){
                history($adopterID);
            }
        }
        if (!isset($_GET['s'])){
          appointment($adopterID);
        }
        ?>


    <?php function appointment($adopterID){ 
      $i=1;
      include 'Connection.php';
      $sql = "SELECT * FROM (SELECT ca.appointmentID,c.clinicID,c.name,ca.description,ca.date,ca.time,ca.adopterID,ca.petID,null as pet_image,null as discount_percent FROM clinic_appointment ca,clinic c WHERE ca.clinicID=c.clinicID AND ca.status='Uncompleted' AND ca.adopterID = $adopterID UNION ALL SELECT ca.appointmentID,c.clinicID,c.name, ca.description,ca.date,ca.time,ca.adopterID,ca.petID,b.pet_image,c.discount_percent FROM clinic_appointment ca,pet b,clinic c WHERE ca.petID=b.petID AND ca.clinicID=c.clinicID AND ca.status='Uncompleted' AND b.adopterID =$adopterID) AS combined_table ORDER BY combined_table.date,combined_table.time;";
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    if ($result->num_rows > 0) {
    foreach ($rows as $row) { 
        if($row['pet_image']!==NULL){
          $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
        }else{
                $imageSrc = 'media/no-pet.png';
            }
        $appointmentID=$row['appointmentID'];
        $clinicID=$row['clinicID'];
        $name=$row['name'];
        $date=$row['date'];
        $time=$row['time'];
        $petID=$row['petID'];
        $discount_percent=$row['discount_percent'];
        if($petID !=NULL){
        $sql9 = "SELECT purpose FROM pet WHERE petID=$petID";
        $result9 = $conn->query($sql9);
        $row9 = $result9->fetch_assoc();
        $purpose=$row9['purpose'];
        $petID=$row9['purpose'];}else{
          $purpose='Sell';
        }

        ?>
    <a href="User-Clinic-Profile.php?cid=<?php echo $clinicID ?>" class="appointment-list-container">
      <div class="appointment-list-container-row">
      <img src="<?php echo $imageSrc ?>" alt="pet">
      <div class="appointment-list-container-column">
        <p><span class="material-symbols-outlined">local_hospital</span> Clinic: <?php echo $name ?></p>
        <?php if($discount_percent!=NULL AND $purpose!='Sell'){ ?>
        <p><span class="material-symbols-outlined">volunteer_activism</span> Discount: <?php echo $discount_percent ?> %</p>
      <?php }else{ ?>
        <p><span class="material-symbols-outlined">volunteer_activism</span> Discount: Not Applied</p>
      <?php } ?>
    </div>
    <div class="appointment-list-container-column">
      <p><span class="material-symbols-outlined">event</span> Date: <?php echo $date ?></p>
      <p><span class="material-symbols-outlined">schedule</span> Time: <?php echo $time ?></p>
    </div>
  </div>
  <br>
      <div style="width:100%;text-align:center;display: flex;flex-direction: row;align-items: center;justify-content: center;">
      <button class="reschedule-button" onclick="reschedule(<?php echo $appointmentID?>,<?php echo$clinicID?>);">Reschedule</button>
      <button class="reschedule-button" id="form-list-button-red" onclick="cancel(event,<?php echo $appointmentID ?>)">Cancel</button>
    </div>
  </a>
  
<?php }}else{?>
  <img src="media/no-document.jpg" width="300px" height="300px">
<?php }
      } ?>

      <?php function pending($adopterID){ 
      $j=1;
      include 'Connection.php';
      $sql = "SELECT * FROM (SELECT ca.appointmentID,c.clinicID,c.name,ca.description,ca.date,ca.time,ca.adopterID,ca.petID,null as pet_image,null as discount_percent,ca.status,r.recordID,r.comment,r.date AS record_date,v.name AS vet_name FROM clinic_appointment ca,clinic c,record r,vet v WHERE r.appointmentID=ca.appointmentID AND ca.vetID=v.vetID AND ca.clinicID=c.clinicID AND ca.status='Completed' AND ca.adopterID = $adopterID UNION ALL SELECT ca.appointmentID,c.clinicID,c.name, ca.description,ca.date,ca.time,ca.adopterID,ca.petID,b.pet_image,c.discount_percent,ca.status,r.recordID,r.comment,r.date AS record_date,v.name AS vet_name FROM clinic_appointment ca,pet b,clinic c,record r,vet v WHERE r.appointmentID=ca.appointmentID AND ca.vetID=v.vetID AND ca.petID=b.petID AND ca.clinicID=c.clinicID AND ca.status='Completed' AND b.adopterID =$adopterID) AS combined_table ORDER BY combined_table.date,combined_table.time;";
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    if ($result->num_rows > 0) {
    foreach ($rows as $row) { 
        if($row['pet_image']!==NULL){
          $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
        }else{
                $imageSrc = 'media/no-pet.png';
            }
        $appointmentID=$row['appointmentID'];
        $clinicID=$row['clinicID'];
        $name=$row['name'];
        $date=$row['date'];
        $time=$row['time'];
        $petID=$row['petID'];
        $discount_percent=$row['discount_percent'];
        $vet_name = $row['vet_name'];
        $record_date = $row['record_date'];
        $recordID = $row['recordID'];

        $sql6 = "SELECT SUM(quantity * unit_price) AS sub_total,r.discount FROM treatment_record tr,treatment t,record r WHERE tr.treatmentID=t.treatmentID AND tr.recordID=r.recordID AND tr.recordID=$recordID";
         $result6 = $conn->query($sql6);
         $row6 = $result6->fetch_assoc();
         $sub_total=$row6['sub_total'];
         $discount=$row6['discount'];

         $sql7 = "SELECT ca.petID, c.discount_percent,c.clinic_image,c.name AS vname FROM clinic c,clinic_appointment ca WHERE ca.clinicID=c.clinicID AND ca.appointmentID=$appointmentID";
         $result7 = $conn->query($sql7);
         $row7 = $result7->fetch_assoc();
         $petID=$row7['petID'];
         $clinic_name=$row7['vname'];
         if($row7['clinic_image']!==NULL){
          $imageData2 = base64_encode($row7['clinic_image']);
            $imageSrc2 = "data:image/jpg;base64," . $imageData2;
            if (file_exists('clinic_images/' . $row7['clinic_image'])) {
                $imageSrc2 = 'clinic_images/' . $row7['clinic_image'];
            }
        }else{
                $imageSrc2 = 'media/clinic-default.png';
            }

          $sql5 = "SELECT extra FROM record WHERE recordID=".$row['recordID'];
          $result5 = $conn->query($sql5);
          $row5 = $result5->fetch_assoc();
          $extra = $row5['extra'];
          if($extra!=NULL){
            $each_treatments=explode("$",$extra);
            foreach ($each_treatments as $each_treatment) {
          $components = explode("^", $each_treatment);
            $sub_total+=($components[1] * $components[2]);
          }
          }
          if($petID!=NULL){
          $sub_total*=(1-$discount/100);
         }

        ?>
        <?php $sql9="SELECT paymentID FROM clinic_payment WHERE recordID=$recordID";
          $result9 = $conn->query($sql9);
          $rows9 = $result9->fetch_all(MYSQLI_ASSOC);

          

          if ($result9->num_rows == 0) {
            if($petID!=NULL){
          $sql88 = "SELECT purpose FROM pet WHERE petID=$petID";
        $result88 = $conn->query($sql88);
        $row88 = $result88->fetch_assoc();
        $purpose=$row88['purpose'];}else{
          $purpose='Sell';
        } ?>
    <a href="User-Clinic-Profile.php?cid=<?php echo $clinicID ?>" class="appointment-list-container">
      <div class="appointment-list-container-row">
      <img src="<?php echo $imageSrc ?>" alt="pet">
      <div class="appointment-list-container-column">
        <p><span class="material-symbols-outlined">local_hospital</span> Clinic: <?php echo $name ?></p>
        <?php if($discount!=NULL AND $purpose!='Sell'){ ?>
        <p><span class="material-symbols-outlined">volunteer_activism</span> Discount: <?php echo $discount ?> %</p>
      <?php }else{ ?>
        <p><span class="material-symbols-outlined">volunteer_activism</span> Discount: Not Applied</p>
      <?php } ?>
    </div>
    <div class="appointment-list-container-column">
      <p><span class="material-symbols-outlined">stethoscope</span> Vet: <?php echo $vet_name ?></p>
      <p><span class="material-symbols-outlined">paid</span> Total: RM <?php echo number_format($sub_total,2) ?></p>
    </div>
  </div>
  <br>
      <div style="width:100%;text-align:center;display: flex;flex-direction: row;align-items: center;justify-content: center;">
      <button class="reschedule-button" style="background-color:#29a329;color:white" onclick="payment(event,<?php echo $recordID?>,<?php echo$sub_total?>);">Make Payment</button>
      <button class="reschedule-button" onclick="recordModal(<?php echo $recordID ?>,event)">View Record</button>
    </div>
  </a>


<div id="PaymentModal<?php echo$recordID ?>" class="modal">
  <div class="modal-content" style="height: auto;padding-bottom: 40px;margin-bottom: 70px;">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Payment</h2>
    </div>
    <div style="width: 100%;display: flex;flex-direction: column; align-items: center;">
      <br><br>
    <img src="<?php echo $imageSrc2 ?>" style="width:300px;height:180px">
    <table width="60%" border="0" style="margin:25px 0">
      <tr>
        <td style="font-size: 30px;">Amount</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><b>RM <?php echo number_format($sub_total,2) ?></b></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Transfer to</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $clinic_name ?></p></td>
      </tr>
  </table>
    <div id="paypal-payment-button<?php echo$recordID ?>" style="width: 100%;margin-left: 170px;"></div>
    <script src="https://www.paypal.com/sdk/js?client-id=AVKhPyIREMp1EynqC_9932cWY2SPi_zMNmnSPlP9hyorwbiOogLrslLKz9bDhXs6vGQr9LYbD38_zapW&currency=MYR"></script>
  </div>
  </div>
</div>
<?php }}}else{?>
  <img src="media/no-document.jpg" width="300px" height="300px">
<?php }
      }?>


<?php function history($adopterID){
 include 'Connection.php';
      $sql = "SELECT * FROM (SELECT c.clinicID,c.name,ca.adopterID,ca.petID,null as pet_image,null as discount,r.recordID,r.comment,r.date AS record_date,v.name AS vet_name,cp.paymentID,cp.transactionID,cp.date,cp.amount FROM clinic_appointment ca,clinic c,record r,vet v,clinic_payment cp WHERE cp.recordID=r.recordID AND r.appointmentID=ca.appointmentID AND ca.vetID=v.vetID AND ca.clinicID=c.clinicID AND ca.adopterID =$adopterID UNION ALL SELECT c.clinicID,c.name,ca.adopterID,ca.petID,b.pet_image,r.discount,r.recordID,r.comment,r.date AS record_date,v.name AS vet_name,cp.paymentID,cp.transactionID,cp.date,cp.amount FROM clinic_appointment ca,pet b,clinic c,record r,vet v,clinic_payment cp WHERE cp.recordID=r.recordID AND r.appointmentID=ca.appointmentID AND ca.vetID=v.vetID AND ca.petID=b.petID AND ca.clinicID=c.clinicID AND b.adopterID =$adopterID) AS combined_table ORDER BY paymentID DESC;;";
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    if ($result->num_rows > 0) {
    foreach ($rows as $row) { 
        if($row['pet_image']!==NULL){
          $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
        }else{
                $imageSrc = 'media/no-pet.png';
            }
        $clinicID=$row['clinicID'];
        $name=$row['name'];
        $petID=$row['petID'];
        $discount_percent = $row['discount'];
        $recordID = $row['recordID'];
        $comment = $row['comment'];
        $record_date = $row['record_date'];
        $vet_name = $row['vet_name'];
        $paymentID = $row['paymentID'];
        $transactionID = $row['transactionID'];
        $date = $row['date'];
        $amount = $row['amount'];

        if($petID !=NULL){
        $sql88 = "SELECT purpose FROM pet WHERE petID=$petID";
        $result88 = $conn->query($sql88);
        $row88 = $result88->fetch_assoc();
        $purpose=$row88['purpose'];
        }else{
          $purpose='Sell';
        }
        ?>
    <a href="User-Clinic-Profile.php?cid=<?php echo $clinicID ?>" class="appointment-list-container">
      <div class="appointment-list-container-row">
      <img src="<?php echo $imageSrc ?>" alt="pet">
      <div class="appointment-list-container-column">
        <p><span class="material-symbols-outlined">local_hospital</span> Clinic: <?php echo $name ?></p>
        <?php if($discount_percent!=NULL AND $purpose!='Sell'){ ?>
        <p><span class="material-symbols-outlined">volunteer_activism</span> Discount: <?php echo $discount_percent ?> %</p>
      <?php }else{ ?>
        <p><span class="material-symbols-outlined">volunteer_activism</span> Discount: Not Applied</p>
      <?php } ?>
    </div>
    <div class="appointment-list-container-column">
      <p><span class="material-symbols-outlined">stethoscope</span> Vet: <?php echo $vet_name ?></p>
      <p><span class="material-symbols-outlined">paid</span> Total: RM <?php echo number_format($amount,2) ?></p>
    </div>
  </div>
  <br>
      <div style="width:100%;text-align:center;display: flex;flex-direction: row;align-items: center;justify-content: center;">
      <button class="reschedule-button" style="background-color:#006bb3;color:white" onclick="detail(event,<?php echo $paymentID?>,<?php echo $adopterID ?>);">Receipt</button>
      <button class="reschedule-button" onclick="recordModal2(<?php echo $recordID ?>,event)">View Record</button>
    </div>
  </a>

<?php }}else{?>
  <img src="media/no-document.jpg" width="300px" height="300px">
<?php }} ?>
  </div>


</div>








<script type="text/javascript">
  $(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('s');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'Appointment') {
    $('a[href*="User-Pet-Appointment-List.php?s=Appointment"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="User-Pet-Appointment-List.php?s=Pending"]').css('border-bottom', '0');
    $('a[href*="User-Pet-Appointment-List.php?s=History"]').css('border-bottom', '0');
  } else if (sValue === 'Pending') {
    $('a[href*="User-Pet-Appointment-List.php?s=Pending"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="User-Pet-Appointment-List.php?s=Appointment"]').css('border-bottom', '0');
    $('a[href*="User-Pet-Appointment-List.php?s=History"]').css('border-bottom', '0');
  }
  else if (sValue === 'History') {
    $('a[href*="User-Pet-Appointment-List.php?s=History"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="User-Pet-Appointment-List.php?s=Appointment"]').css('border-bottom', '0');
    $('a[href*="User-Pet-Appointment-List.php?s=Pending"]').css('border-bottom', '0');
  }
  else{
    $('a[href*="User-Pet-Appointment-List.php?s=Appointment"]').css('border-bottom', '5px solid #00a8de');
  }
});

  function reschedule(appointmentID,clinicID) {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior
    window.location.href = "User-Clinic-Appointment.php?appointmentID="+appointmentID+"&cid="+clinicID+"&purpose=update";
  }

function cancel(event, i) {
  event.preventDefault(); // Prevents anchor tag from triggering its default behavior
  var confirmed = confirm("Are you sure you want to cancel this appointment?");

  if (confirmed) {
    window.location.href = "User-Clinic-Appointment-Process.php?appointmentID=" + i + "&action=delete";
  }
}

function recordModal(recordID, event) {
  event.preventDefault(); // Prevents anchor tag from triggering its default behavior
  window.open("User-Pet-Appointment-List-Record.php?recordID=" + recordID, "_blank");
}

function payment(event,i,price) {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior

     var modal= document.getElementById("PaymentModal"+i);
      var span = modal.getElementsByClassName("close")[0];
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
    var url = "User-Clinic-Appointment-Process.php?action=payment&recordID=" + i + "&amount=" + price +"&transactionID=" + encodeURIComponent(transactionId);

    // Redirect to the URL
    window.location.href = url;
  });
}

  }).render('#paypal-payment-button'+i);
}

function detail(event, paymentID,adopterID) {
  event.preventDefault(); // Prevents anchor tag from triggering its default behavior
   window.open("Clinic-Receipt.php?paymentID=" + paymentID +"&adopterID="+ adopterID, "_blank");
}


function recordModal2(recordID, event) {
  event.preventDefault(); // Prevents anchor tag from triggering its default behavior
  window.open("User-Pet-Appointment-List-Record.php?recordID=" + recordID, "_blank");
}
</script>
</body>
</html>