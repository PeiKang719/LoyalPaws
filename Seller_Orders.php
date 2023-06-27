<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Main page</title>
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="SellerStyle.css">
<link rel="icon" type="image/png" href="media/tabIcon.png">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<style type="text/css">
	html,body{
		height: auto;
	}
</style>

</head>
<body style="background-color: white;">

<?php include 'SellerHeader.php'; 
	  include 'Connection.php';?>
	<div class="form-container">
<?php 
$i=1;
$sql = "SELECT p.petID, s.sellerID,p.gender, p.pet_image, p.breedID,b.name,m.status,m.visit_date,m.visit_time,p.price,m.adopterID FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN seller s ON  p.sellerID=s.sellerID JOIN pet_payment m ON p.petID=m.petID WHERE s.sellerID=1 AND p.purpose='Sell' GROUP BY p.petID ORDER BY
    CASE
        WHEN m.status IS NULL THEN 0
        WHEN m.status = 'Appointment' THEN 1
        WHEN m.status = 'Decision' THEN 2
        WHEN m.status = 'Payment' THEN 3
        WHEN m.status = 'cancel' THEN 4
        WHEN m.status = 'Complete' THEN 5
    END,
    petID DESC;";
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
	   $bname=$row['name'];
	   $price=$row['price'];
	   $visit_date=$row['visit_date'];
	   $visit_time=$row['visit_time'];

 	   $sql4 = "SELECT status from pet_payment where status='refund' AND petID=$petID;";
 	   $sql3 = "SELECT status from pet_payment where status='cancel' AND petID=$petID;";
 	   $sql2 = "SELECT status from pet_payment where status='complete' AND petID=$petID;";
 	   $sql1 = "SELECT status from pet_payment where status='appointment' AND petID=$petID;";




 	   $result1 = $conn->query($sql1);
 	   $result2 = $conn->query($sql2);
 	   $result3 = $conn->query($sql3);
 	   $result4 = $conn->query($sql4);
 	   $z;
    if ($result1->num_rows > 0) {
    	$z=1;
    	
    }
    elseif ($result2->num_rows > 0) {
    	$z=2;
    	$sql10 ="SELECT visit_date,visit_time,paymentID,complete_date FROM pet_payment WHERE petID= $petID AND status='complete'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['complete_date'];
    	$visit_time=NULL;
    }
    }
    elseif ($result3->num_rows > 0) {
    	$z=3;
    	$sql10 ="SELECT visit_date,visit_time,paymentID FROM pet_payment WHERE petID= $petID AND status='cancel'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    }
    }
    elseif ($result4->num_rows > 0) {
    	$z=4;
    	$sql10 ="SELECT visit_date,visit_time,paymentID FROM pet_payment WHERE petID= $petID AND status='refund'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    }
    }
    else{
    	$z=1;
    	$visit_date=NULL;
    }

    
    ?>

	<div class="each-pet-container">
		<div class="each-pet-img-container">
			<div style="width: 14%;">
				<img src="<?php echo $imageSrc ?>">
			</div>
			<div class="column-container">
				<?php if($gender=='Female'){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b><?php echo $bname ?></b>
			</div>
		<?php }
		else {?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #1ab2ff; font-weight: 800;">male</span><b><?php echo $bname ?></b>
			</div>
		<?php } ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -7px; color: #cc7a00; font-weight: 800;">paid</span>Price:<b> RM <?php echo $price ?></b>
			</div>
			</div>
			<div class="column-container" style="width:52%">
			<?php 
		if ($z==4){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Refunded</b>
			</div>
		<?php } 
		elseif ($z==3){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Pending Refund</b>
			</div>
		<?php }
		elseif ($z==2){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Completed</b>
			</div>
		<?php } 
		elseif ($z==1){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Appointmnet</b>
			</div>
		<?php } ?>
		<?php if ($visit_date !== NULL) {?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -8px; color: #4d4d4d; font-weight: 800;">schedule</span><?php if($visit_time !== NULL) { echo "Scheduled date: ";}else{echo "Completed date: ";}?><b  style="font-size:20px"> <?php echo $visit_date ?><?php if($visit_time !== NULL) { echo "[" . $visit_time . "]"; } ?> </b></div>
			<?php }else{ ?>
				<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -8px; color: #4d4d4d; font-weight: 800;">schedule</span>Scheduled date: <b> - </b></div>
				<?php } ?>
			
		</div>
		</div>
		
		<div class="pet-application-container">
			<div class="adoption-process-container">
				<span class="material-symbols-outlined visited">event</span>
				<?php if($z==1){?>
				<span class="material-symbols-outlined ">flaky</span>
					<span class="material-symbols-outlined ">payments</span>
				<span class="material-symbols-outlined " id="last-process" >check_circle</span>
				<?php } 
				elseif($z==2){?>
				<span class="material-symbols-outlined visited">flaky</span>
					<span class="material-symbols-outlined visited">payments</span>
				<span class="material-symbols-outlined visited" id="last-process" >check_circle</span>
				<?php } 
				elseif($z>2){?>
					<span class="material-symbols-outlined fail">flaky</span>
					<span class="material-symbols-outlined fail">payments</span>
					<span class="material-symbols-outlined fail" id="last-process" >cancel</span>
				</div>
			</div>
				<?php } ?>
			</div>
		<?php
		$i;
		$sql10 ="SELECT CONCAT(a.firstName,' ',a.lastName) As adopter_name,a.image,p.price,m.visit_date,m.visit_time,m.paymentID,m.transactionId FROM adopter a,pet p,pet_payment m WHERE m.adopterID=a.adopterID AND m.petID=p.petID AND m.petID=$petID;";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    	$price=$row10['price'];
    	$transactionId=$row10['transactionId'];
    	$adopter_name=$row10['adopter_name'];
    }
    $imageData2 = base64_encode($row10['image']);
	            $imageSrc2 = "data:image/jpg;base64," . $imageData2;
	            if ($row10['image']=='') {
	                $imageSrc2 = 'media/profile.png';
            }
	            elseif (file_exists('adopter_images/' . $row10['image'])) {
	                $imageSrc2 = 'adopter_images/' . $row10['image'];
            }
		
				if($z==1 ){?>
		<div class="column">
			<a href="User-Profile.php?id=<?php echo $row['adopterID'] ?>&sid=<?php echo $row['sellerID']?>">
            <div class="card">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $adopter_name ?></b></p>
            </div>
            <div class="breedIcon">
            	
            </div>
            </div>
          </a>
	</div>
	</div>
</div>

<?php } 
elseif($z==2 ){?>
		<div class="column">
			<a href="User-Profile.php?id=<?php echo $row['adopterID'] ?>&sid=<?php echo $row['sellerID']?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $adopter_name ?></b></p>
            </div>
            <div class="breedIcon">
            	
            </div>
            </div>
          </a>
	</div>
	</div>
</div>
<?php } 
 
elseif($z==3 ){?>
		<div class="column">
			<a href="User-Profile.php?id=<?php echo $row['adopterID'] ?>&sid=<?php echo $row['sellerID']?>">
            <div class="card" style="border:2px solid #cc0000 ">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $adopter_name ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button" id="fail" type="button" onclick="refund(<?php echo $i ?>,<?php echo $paymentID ?>)" style="background-color:#cc0000 ;color: white;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">restart_alt</span>Refund</button>
            </div>
            </div>
          </a>
	</div>
</div>
</div>

<div id="RefundModal<?php echo$i ?>" class="modal">
  <div class="modal-content" style="height: auto;padding-bottom: 40px;margin-top:130px;width: 55%;">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2 style="font-size:27px">Refund Details</h2>
    </div>
    <div style="width: 100%;display: flex;flex-direction: column; align-items: center;">
      <br><br>
    <table width="80%" border="0" style="margin:25px 0">
      <tr>
        <td style="font-size: 30px;">Payment No</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $transactionId ?></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Amount</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;">RM <?php echo $price*0.1 ?></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Transfer to</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $adopter_name ?></p></td>
      </tr>
  </table>
    <button class="view-application-button" id="fail" type="button" onclick="confirmRefund('<?php echo $transactionId ?>',<?php echo $price*0.1 ?>)" style="background-color:#cc0000 ;color: white;font-size: 30px;height: 60px;">Refund</button>
  </div>
  </div>
</div>

<?php } ?>

<?php $i++; 
}}else{?>
	<div style="width: 100%;height: 100%; display: flex;justify-content: center;align-items: center;padding-top: 5%;">
	<img src="media/no-document.jpg" width="300px" height="300px">
</div>
<?php } ?>
		

</div>
</div>


<script type="text/javascript">

	function openModal(n){
	var modal8 = document.getElementById("applicationModal"+n);
var span8 = modal8.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 

  modal8.style.display = "block"; 

// When the user clicks on <span> (x), close the modal
span8.onclick = function() {
  modal8.style.display = "none";

}
}
	  var checkbox = document.getElementById('check');
  var columns = document.getElementsByClassName('column');

  function handleCheckboxChange() {
    for (var i = 0; i < columns.length; i++) {
      var column = columns[i];
      if (checkbox.checked) {
        column.classList.remove('collapsed');
      } else {
        column.classList.add('collapsed');
      }
    }
  }

  checkbox.addEventListener('change', handleCheckboxChange);

  // Initial call to set the initial state based on the checkbox's initial checked state
  handleCheckboxChange();



  

function refund(n,mID) {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior
   
    var modal = document.getElementById("RefundModal"+n);
    // Get the <span> element that closes the modal
    var span = modal.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 

      modal.style.display = "block"; 
    

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }
}

function confirmRefund(transactionId, price) {
  if (!confirm("Are you sure you want to initiate a refund?")) {
    return;
  }

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'refund.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Refund was successful, handle any response if needed
        window.location.href = "Seller_Adoption-Form-Process.php?id=" + transactionId + "&c=refund";
      } else {
        // Refund failed, handle the error response
        alert("Refund failed: " + xhr.responseText);

      }
    }
  };
  
  // Send the transactionId and price as parameters
  var params = 'transactionId=' + encodeURIComponent(transactionId) + '&price=' + encodeURIComponent(price);
  
  xhr.send(params);
}



</script>


</body>
</html>