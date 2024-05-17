<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Main page</title>
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="css/SellerStyle.css">
<link rel="icon" type="image/png" href="../media/tabIcon.png">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style type="text/css">
	html,body{
		height: auto;
	}
</style>

</head>
<body style="background-color: white;">

<?php 

include 'SellerHeader.php'; 
	  include '../Database/Connection.php';?>
<div class="form-container" style="padding-left:0;padding-right:0;width: 100%;">
 <p class="profile-header" style="margin-left:50px;font-size:27px;font-weight:bold">Adoption / Lodging</p>
  <div class="manage-appointment-section">
  	<a href="Seller_Adoption-Form.php?adoption=available">Available</a>
    <a href="Seller_Adoption-Form.php?adoption=appointment">Appointment/Decision</a>
    <a href="Seller_Adoption-Form.php?adoption=complete">Completed</a> 
    <a href="Seller_Adoption-Form.php?adoption=cancel">Cancelled</a> 
  </div>
<div style="width:96%;padding: 4% 2%;">
<?php if(isset($_GET['adoption'])){
          if($_GET['adoption']=='available'){
            available($role,$key,$sellerID);
          }
          elseif($_GET['adoption']=='appointment'){
            appointment($role,$key,$sellerID);
          }
          elseif($_GET['adoption']=='complete'){
            complete($role,$key,$sellerID);
          }
          elseif($_GET['adoption']=='cancel'){
            cancel($role,$key,$sellerID);
          }
}else{
 available($role,$key,$sellerID);
}?>

<?php
function available($role,$key,$sellerID){
	include '../Database/Connection.php';
$i=1;
$sql = "SELECT p.petID, s.$key,p.gender, p.pet_image, p.breedID,b.name,i.inquiryID,COUNT(i.inquiryID) AS num,m.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $role s ON  p.$key=s.$key LEFT JOIN inquiry i ON i.petID=p.petID LEFT JOIN pet_payment m ON p.petID=m.petID WHERE s.$key=$sellerID AND (p.purpose='Rehome' OR p.purpose='Lodging') AND m.status IS NULL GROUP BY p.petID ORDER BY
    CASE
        WHEN m.status IS NULL THEN 0
        WHEN m.status = 'Booked' THEN 1
        WHEN m.status = 'Appointment' THEN 2
        WHEN m.status = 'Decision' THEN 3
        WHEN m.status = 'Payment' THEN 4
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
	   $num=$row['num'];
 	   $sql7 = "SELECT status from pet_payment where status='Complete' AND petID=$petID;";
 	   $sql10 = "SELECT status from pet_payment where status='Payment' AND petID=$petID;";
 	   $sql15 = "SELECT status from pet_payment where status='Fail' AND petID=$petID;";
 	   $sql8 = "SELECT status from inquiry where status='Decision' AND petID=$petID;";
 	   $sql9 = "SELECT status from inquiry where status='Appointment' AND petID=$petID;";


 	   $result7 = $conn->query($sql7);
 	   $result8 = $conn->query($sql8);
 	   $result9 = $conn->query($sql9);
 	   $result10 = $conn->query($sql10);
 	   $result15 = $conn->query($sql15);
 	   $z;
    if ($result7->num_rows > 0) {
    	$z=5;
    	$sql10 ="SELECT m.complete_date,m.paymentID,m.transactionId,CONCAT(a.firstName,' ',a.lastName) As adopter_name,p.price FROM pet_payment m,adopter a,pet p WHERE m.adopterID=a.adopterID AND m.petID=p.petID AND m.petID= $petID AND m.status='Complete'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['complete_date'];
    	$visit_time=NULL;
    	$price=$row10['price'];
    	$transactionId=$row10['transactionId'];
    	$adopter_name=$row10['adopter_name'];
    }
    }
    elseif ($result15->num_rows > 0) {
    	$z=6;
    	$sql10 ="SELECT visit_date,visit_time,paymentID FROM pet_payment WHERE petID= $petID AND status='Fail'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    }
    }
    elseif ($result10->num_rows > 0) {
    	$z=4;
    	$sql10 ="SELECT visit_date,visit_time,paymentID FROM pet_payment WHERE petID= $petID AND status='Payment'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    }
    }
    elseif ($result8->num_rows > 0) {
    	$z=3;
    	$sql10 ="SELECT visit_date,visit_time,paymentID,status FROM pet_payment WHERE petID= $petID AND (status='Decision' OR status='Y' OR status='y' OR status='Free')";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    	$status2=$row['status'];
    }
    }
    elseif ($result9->num_rows > 0) {
    	$z=2;
    	$visit_date= NULL;
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
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #005c99; font-weight: 800;">group</span>No of applicants:<b> <?php echo $num ?></b>
			</div>
			</div>
			<div class="column-container" style="width:52%">
			<?php if($z==5){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Completed</b>
			</div>
		<?php }
		elseif ($z==6){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b style="color: #cc0000;">Rejected by adopter</b>
			</div>
		<?php } 
		elseif ($z==4){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Payment</b>
			</div>
		<?php } 
		elseif ($z==3){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Meet with adopter</b>
			</div>
		<?php }
		elseif ($z==2){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Meet with adopter</b>
			</div>
		<?php } 
		elseif ($z==1){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Finding adopter</b>
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
				<span class="material-symbols-outlined visited">quick_reference_all</span>
				<span class="material-symbols-outlined <?php if($z>=2){echo 'visited';} ?>">event</span>
				<?php if($z<6){?>
				<span class="material-symbols-outlined <?php if($z>=3){echo 'visited';} ?>">flaky</span>
				<span class="material-symbols-outlined <?php if($z>=4 ){echo 'visited';} ?>">payments</span>
				<span class="material-symbols-outlined <?php if($z>=5 ){echo 'visited';} ?>" id="last-process" >check_circle</span>
				<?php } 
				elseif($z==6){?>
					<span class="material-symbols-outlined <?php if($z>=3){echo 'fail';} ?>">flaky</span>
					<span class="material-symbols-outlined <?php if($z>=4 ){echo 'fail';} ?>">payments</span>
					<span class="material-symbols-outlined <?php if($z>=5 ){echo 'fail';} ?>" id="last-process" >cancel</span>
				<?php } ?>
			</div>
		<?php
		$sql2 = "SELECT p.petID, p.gender, p.pet_image, p.breedID,b.name,i.inquiryID,i.question1,i.question2,i.question3,i.question4,i.question5,i.question6,i.question7,i.question8,i.question9,i.question10,i.submit_date,i.status, i.adopterID,a.image,CONCAT(a.firstName,a.lastName) As adopter_name FROM pet p,breed b,inquiry i,adopter a WHERE p.breedID=b.breedID AND i.petID=p.petID AND i.adopterID=a.adopterID AND p.petID=$petID AND i.status !='Rejected' order by
			(case WHEN i.status='Appointment' then 1
			WHEN i.status='Pending' then 2
			END),i.inquiryID;";
			$result2 = $conn->query($sql2);
    		$rows2 = $result2->fetch_all(MYSQLI_ASSOC);
    		
    		foreach ($rows2 as $row2) { 
	        	$imageData2 = base64_encode($row2['image']);
	            $imageSrc2 = "data:image/jpg;base64," . $imageData2;
	            if ($row2['image']=='') {
	                $imageSrc2 = '../media/profile.png';
            }
	            elseif (file_exists('../User/adopter_images/' . $row2['image'])) {
	                $imageSrc2 = '../User/adopter_images/' . $row2['image'];
            }
            $qID = $row2['inquiryID'];
            $question1 = $row2['question1'];
            $question2 = $row2['question2'];
            $question3 = $row2['question3'];
            $question4 = $row2['question4'];
            $question5 = $row2['question5'];
            $question6 = $row2['question6'];
            $question7 = $row2['question7'];
            $question8 = $row2['question8'];
            $question9 = $row2['question9'];
            $question10 = $row2['question10'];
            $status = $row2['status'];
            $submit_date = $row2['submit_date'];

		?>
		<?php if($z>1){ 
				if($status=='Pending'){?>
		<div class="column">
			<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card lock">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button lock-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined lock-button" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
<?php }
		elseif($z==3 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<input type="hidden" name="paymentID" id="mid<?php echo $i ?>" value="<?php echo $paymentID ?>">
            	<?php if($status2=='Y' || $status2=='Free'){?>
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>)" style="background-color:#29a329 ;color: white;" disabled><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">check</span>Pending...</button>
            <?php }else{?>
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>)" style="background-color:#29a329 ;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">check</span></button>
            	<button class="view-application-button" id="wrong" type="button" onclick="reject(<?php echo $paymentID ?>,<?php echo $qID ?>,event)" style="background-color: red;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">close</span></button>
            <?php } ?>
            </div>
            </div>
        </a>
		</div>
		<?php }	
		elseif($z==4 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>)" style="background-color:#29a329 ;color: white;" disabled><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">payments</span>Waiting Payment</button>
            </div>
            </div>
        </a>
		</div>
		<?php }
		elseif($z==6 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #cc0000">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="fail" type="button" onclick="restart(<?php echo $qID ?>,<?php echo $paymentID ?>)" style="background-color:#cc0000 ;color: white;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">restart_alt</span>Restart Adoption</button>
            </div>
            </div>
        </a>
		</div>
		<?php }
		elseif($z==5 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="correct" type="button" onclick="details(<?php echo $paymentID ?>,event)" style="background-color:#29a329 ;color: white;">Adoption Agreement</button>
            </div>
            </div>
        </a>
		</div>

		<div id="DetailsModal<?php echo $i ?>" class="modal" >
  <div class="modal-content" style="height: auto;padding-bottom: 40px;margin-top:130px;width:60%">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2 style="font-size:30px">Payment Details</h2>
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
        <td style="font-size: 30px;">From</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $adopter_name ?></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Completed date</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $visit_date ?></p></td>
      </tr>
  </table>
    
  </div>
  </div>
</div>

		<?php }
		else{ ?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
			<?php }}else{ ?>
				<div class="column">
					<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
			<?php } ?>

<?php $date1=date_create($submit_date);
	  date_default_timezone_set('Asia/Singapore');
	  $current=date_create(date("Y-m-d"));
	  $diff=date_diff($date1,$current); 
	  if($diff->format("%a days")=='0 days'){
	  	$submission='today';
	  }
	  else{
	  	$submission = $diff->format("%a days"). " ago";
	  } ?>
	<div id="applicationModal<?php echo $i ?>" class="modal" style="padding-top:50px;">
  <!-- Modal content -->
  <div class="modal-content" style="width:60%;height:auto;margin-bottom:100px;padding-bottom:50px">
    <div class="modal-header" style="font-size:20px">
      <h2>Application Form (Submitted <?php echo $submission ?>)</h2>
      <span class="close">&times;</span>
      </div>
      	<br>
  <div class="applicationModal-style">
  <h3>About:</h3>
  <br>

   <div class="adoption-form-subcontainer">
  <label for="experience">1) Have you owned pets before? If yes, please provide details:</label>
  <p><?php echo $question1 ?></p>

  <label for="occupation">2) What is your occupation?</label>
<p><?php echo $question2 ?></p>

  <label for="lifestyle">3) Describe your current lifestyle and daily routine:</label>
  <p><?php echo $question3 ?></p>

<label for="pet-training">4) Are you willing to invest time and effort into training a pet if needed?</label>
<p><?php echo $question4 ?></p>
</div>
<hr ><br>
  <h3>About Home:</h3>
  <br>
  <div class="adoption-form-subcontainer">
  <label for="residence">1) Do you own or rent your residence?</label>
  <p><?php echo $question5 ?></p>

  <label for="residence-details">2) Please provide details about your residence (e.g., house, apartment, yard size):</label>
  <p><?php echo $question6 ?></p>
</div>
<hr ><br>
  <h3>About Pet Care:</h3>
  <br>
   <div class="adoption-form-subcontainer">
  <label for="commitment">1) Are you committed to taking care of a pet for its entire life (typically 10-15 years or longer)?</label>
  <p><?php echo $question7 ?></p>

  <label for="pet-grooming">2) Are you comfortable with grooming and maintenance requirements for the pet you are adopting?</label>
  <p><?php echo $question8 ?></p>

<label for="pet-expenses">3) Are you prepared for the financial responsibilities of owning a pet, including food, vaccinations, grooming, and veterinary care?</label>
<p><?php echo $question9 ?></p>
</div>
<hr ><br>
  <h3>Additional Comments:</h3>
  <br>
   <div class="adoption-form-subcontainer">
  <label for="comments">Please provide any additional comments or information:</label>
  <?php if (!empty($question10)) { ?>
  <p><?php echo $question10 ?></p>
  <?php
}else{ ?>
	<p><?php echo "-" ?></p>
<?php } ?>
</div>
</div>
<br>
<div class="application-form-button-container">
	<?php if($z>1){ 
				if($status=='Pending'){?>
	
    <?php }
    else{?>
    	<a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=appointment">
<button class="application-form-button" onclick="return confirm('Are you sure to approve this applicant?');">Approve</button>	</a>
        <button class="application-form-button" style="background-color:red;width: 30%;" onclick="reason(<?php echo $qID ?>,0,'rejected',event)">Reject</button>
    <?php }}else{ ?>
    	<a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=appointment">
<button class="application-form-button" onclick="return confirm('Are you sure to approve this applicant?');">Approve</button>	</a>
        <button class="application-form-button" style="background-color:red;width:30%" onclick="reason(<?php echo $qID ?>,0,'rejected',event)">Reject</button>
    <?php } ?>
    </div>
</div>
  </div>


<?php $i++; 
} ?>
		
</div>
</div>



<?php }}else{ ?>
<div style="width: 100%;height: 100%; display: flex;justify-content: center;align-items: center;padding-top: 5%;">
	<img src="../media/no-document.jpg" width="300px" height="300px">
</div>
<?php } ?>
</div>
<?php } ?>


<?php
function appointment($role,$key,$sellerID){
	include '../Database/Connection.php';
$i=1;
$sql = "SELECT p.petID, s.$key,p.gender, p.pet_image, p.breedID,b.name,i.inquiryID,COUNT(i.inquiryID) AS num,m.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $role s ON  p.$key=s.$key LEFT JOIN inquiry i ON i.petID=p.petID LEFT JOIN pet_payment m ON p.petID=m.petID WHERE s.$key=$sellerID AND (p.purpose='Rehome' OR p.purpose='Lodging') AND (m.status='Booked' OR m.status='Appointment' OR m.status='Decision' OR m.status='Payment' OR m.status='Y') GROUP BY p.petID ORDER BY
    CASE
        WHEN m.status IS NULL THEN 0
        WHEN m.status = 'Booked' THEN 1
        WHEN m.status = 'Appointment' THEN 2
        WHEN m.status = 'Decision' THEN 3
        WHEN m.status = 'Payment' THEN 4
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
	   $num=$row['num'];
 	   $sql7 = "SELECT status from pet_payment where status='Complete' AND petID=$petID;";
 	   $sql10 = "SELECT status from pet_payment where status='Payment' AND petID=$petID;";
 	   $sql15 = "SELECT status from pet_payment where status='Fail' AND petID=$petID;";
 	   $sql8 = "SELECT status from inquiry where status='Decision' AND petID=$petID;";
 	   $sql9 = "SELECT status from inquiry where status='Appointment' AND petID=$petID;";


 	   $result7 = $conn->query($sql7);
 	   $result8 = $conn->query($sql8);
 	   $result9 = $conn->query($sql9);
 	   $result10 = $conn->query($sql10);
 	   $result15 = $conn->query($sql15);
 	   $z;
    if ($result7->num_rows > 0) {
    	$z=5;
    	$sql10 ="SELECT m.complete_date,m.paymentID,m.transactionId,CONCAT(a.firstName,' ',a.lastName) As adopter_name,p.price FROM pet_payment m,adopter a,pet p WHERE m.adopterID=a.adopterID AND m.petID=p.petID AND m.petID= $petID AND m.status='Complete'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['complete_date'];
    	$visit_time=NULL;
    	$price=$row10['price'];
    	$transactionId=$row10['transactionId'];
    	$adopter_name=$row10['adopter_name'];
    }
    }
    elseif ($result15->num_rows > 0) {
    	$z=6;
    	$sql10 ="SELECT visit_date,visit_time,paymentID FROM pet_payment WHERE petID= $petID AND status='Fail'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    }
    }
    elseif ($result10->num_rows > 0) {
    	$z=4;
    	$sql10 ="SELECT visit_date,visit_time,paymentID FROM pet_payment WHERE petID= $petID AND status='Payment'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    }
    }
    elseif ($result8->num_rows > 0) {
    	$z=3;
    	$sql10 ="SELECT visit_date,visit_time,paymentID,status FROM pet_payment WHERE petID= $petID AND (status='Decision' OR status='Y' OR status='y' OR status='Free')";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    	$status2=$row['status'];
    }
    }
    elseif ($result9->num_rows > 0) {
    	$z=2;
    	$visit_date= NULL;
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
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #005c99; font-weight: 800;">group</span>No of applicants:<b> <?php echo $num ?></b>
			</div>
			</div>
			<div class="column-container" style="width:52%">
			<?php if($z==5){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Completed</b>
			</div>
		<?php }
		elseif ($z==6){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b style="color: #cc0000;">Rejected by adopter</b>
			</div>
		<?php } 
		elseif ($z==4){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Payment</b>
			</div>
		<?php } 
		elseif ($z==3){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Make Decision</b>
			</div>
		<?php }
		elseif ($z==2){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Meet with adopter</b>
			</div>
		<?php } 
		elseif ($z==1){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Finding adopter</b>
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
				<span class="material-symbols-outlined visited">quick_reference_all</span>
				<span class="material-symbols-outlined <?php if($z>=2){echo 'visited';} ?>">event</span>
				<?php if($z<6){?>
				<span class="material-symbols-outlined <?php if($z>=3){echo 'visited';} ?>">flaky</span>
				<span class="material-symbols-outlined <?php if($z>=4 ){echo 'visited';} ?>">payments</span>
				<span class="material-symbols-outlined <?php if($z>=5 ){echo 'visited';} ?>" id="last-process" >check_circle</span>
				<?php } 
				elseif($z==6){?>
					<span class="material-symbols-outlined <?php if($z>=3){echo 'fail';} ?>">flaky</span>
					<span class="material-symbols-outlined <?php if($z>=4 ){echo 'fail';} ?>">payments</span>
					<span class="material-symbols-outlined <?php if($z>=5 ){echo 'fail';} ?>" id="last-process" >cancel</span>
				<?php } ?>
			</div>
		<?php
		$sql2 = "SELECT p.petID, p.gender, p.pet_image, p.breedID,b.name,i.inquiryID,i.question1,i.question2,i.question3,i.question4,i.question5,i.question6,i.question7,i.question8,i.question9,i.question10,i.submit_date,i.status, i.adopterID,a.image,CONCAT(a.firstName,a.lastName) As adopter_name FROM pet p,breed b,inquiry i,adopter a WHERE p.breedID=b.breedID AND i.petID=p.petID AND i.adopterID=a.adopterID AND p.petID=$petID AND i.status !='Rejected' order by
			(case WHEN i.status='Appointment' then 1
			WHEN i.status='Pending' then 2
			END),i.inquiryID;";
			$result2 = $conn->query($sql2);
    		$rows2 = $result2->fetch_all(MYSQLI_ASSOC);
    		
    		foreach ($rows2 as $row2) { 
	        	$imageData2 = base64_encode($row2['image']);
	            $imageSrc2 = "data:image/jpg;base64," . $imageData2;
	            if ($row2['image']=='') {
	                $imageSrc2 = '../media/profile.png';
            }
	            elseif (file_exists('../User/adopter_images/' . $row2['image'])) {
	                $imageSrc2 = '../User/adopter_images/' . $row2['image'];
            }
            $qID = $row2['inquiryID'];
            $question1 = $row2['question1'];
            $question2 = $row2['question2'];
            $question3 = $row2['question3'];
            $question4 = $row2['question4'];
            $question5 = $row2['question5'];
            $question6 = $row2['question6'];
            $question7 = $row2['question7'];
            $question8 = $row2['question8'];
            $question9 = $row2['question9'];
            $question10 = $row2['question10'];
            $status = $row2['status'];
            $submit_date = $row2['submit_date'];

		?>
		<?php if($z>1){ 
				if($status=='Pending'){?>
		<div class="column">
			<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card lock">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button lock-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined lock-button" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
<?php }
		elseif($z==3 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<input type="hidden" name="paymentID" id="mid<?php echo $i ?>" value="<?php echo $paymentID ?>">
            	<?php if($status2=='Y' || $status2=='Free'){?>
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>,event)" style="background-color:#29a329 ;color: white;" disabled><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">check</span>Pending...</button>
            <?php }else{?>
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>,event)" style="background-color:#29a329 ;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">check</span></button>
            	<button class="view-application-button" id="wrong" type="button" onclick="reason(<?php echo $paymentID ?>,<?php echo $qID ?>,'sreject',event)" style="background-color: red;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">close</span></button>
            <?php } ?>
            </div>
            </div>
        </a>
		</div>
		<?php }	
		elseif($z==4 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>,event)" style="background-color:#29a329 ;color: white;" disabled><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">payments</span>Waiting Payment</button>
            </div>
            </div>
        </a>
		</div>
		<?php }
		elseif($z==6 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #cc0000">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="fail" type="button" onclick="restart(<?php echo $qID ?>,<?php echo $paymentID ?>)" style="background-color:#cc0000 ;color: white;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">restart_alt</span>Restart Adoption</button>
            </div>
            </div>
        </a>
		</div>
		<?php }
		elseif($z==5 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="correct" type="button" onclick="details(<?php echo $paymentID ?>,event)" style="background-color:#29a329 ;color: white;">Adoption Agreement</button>
            </div>
            </div>
        </a>
		</div>

		<div id="DetailsModal<?php echo $i ?>" class="modal" >
  <div class="modal-content" style="height: auto;padding-bottom: 40px;margin-top:130px;width:60%">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2 style="font-size:30px">Payment Details</h2>
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
        <td style="font-size: 30px;">From</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $adopter_name ?></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Completed date</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $visit_date ?></p></td>
      </tr>
  </table>
    
  </div>
  </div>
</div>

		<?php }
		else{ ?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
			<?php }}else{ ?>
				<div class="column">
					<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
			<?php } ?>

<?php $date1=date_create($submit_date);
	  date_default_timezone_set('Asia/Singapore');
	  $current=date_create(date("Y-m-d"));
	  $diff=date_diff($date1,$current); 
	  if($diff->format("%a days")=='0 days'){
	  	$submission='today';
	  }
	  else{
	  	$submission = $diff->format("%a days"). " ago";
	  } ?>
	<div id="applicationModal<?php echo $i ?>" class="modal" style="padding-top:50px;">
  <!-- Modal content -->
  <div class="modal-content" style="width:60%;height:auto;margin-bottom:100px;padding-bottom:50px">
    <div class="modal-header" style="font-size:20px">
      <h2>Application Form (Submitted <?php echo $submission ?>)</h2>
      <span class="close">&times;</span>
      </div>
      	<br>
  <div class="applicationModal-style">
  <h3>About:</h3>
  <br>

   <div class="adoption-form-subcontainer">
  <label for="experience">1) Have you owned pets before? If yes, please provide details:</label>
  <p><?php echo $question1 ?></p>

  <label for="occupation">2) What is your occupation?</label>
<p><?php echo $question2 ?></p>

  <label for="lifestyle">3) Describe your current lifestyle and daily routine:</label>
  <p><?php echo $question3 ?></p>

<label for="pet-training">4) Are you willing to invest time and effort into training a pet if needed?</label>
<p><?php echo $question4 ?></p>
</div>
<hr ><br>
  <h3>About Home:</h3>
  <br>
  <div class="adoption-form-subcontainer">
  <label for="residence">1) Do you own or rent your residence?</label>
  <p><?php echo $question5 ?></p>

  <label for="residence-details">2) Please provide details about your residence (e.g., house, apartment, yard size):</label>
  <p><?php echo $question6 ?></p>
</div>
<hr ><br>
  <h3>About Pet Care:</h3>
  <br>
   <div class="adoption-form-subcontainer">
  <label for="commitment">1) Are you committed to taking care of a pet for its entire life (typically 10-15 years or longer)?</label>
  <p><?php echo $question7 ?></p>

  <label for="pet-grooming">2) Are you comfortable with grooming and maintenance requirements for the pet you are adopting?</label>
  <p><?php echo $question8 ?></p>

<label for="pet-expenses">3) Are you prepared for the financial responsibilities of owning a pet, including food, vaccinations, grooming, and veterinary care?</label>
<p><?php echo $question9 ?></p>
</div>
<hr ><br>
  <h3>Additional Comments:</h3>
  <br>
   <div class="adoption-form-subcontainer">
  <label for="comments">Please provide any additional comments or information:</label>
  <?php if (!empty($question10)) { ?>
  <p><?php echo $question10 ?></p>
  <?php
}else{ ?>
	<p><?php echo "-" ?></p>
<?php } ?>
</div>
</div>
<br>
<div class="application-form-button-container">
	<?php if($z>1){ 
				if($status=='Pending'){?>
	
    <?php }
    else{?>
    	<a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=appointment">
<button class="application-form-button" onclick="return confirm('Are you sure to approve this applicant?');">Approve</button>	</a>
        <a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=rejected"><button class="application-form-button" style="background-color:red" onclick="return confirm('Are you sure to reject this applicant?');">Reject</button></a>
    <?php }}else{ ?>
    	<a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=appointment">
<button class="application-form-button" onclick="return confirm('Are you sure to approve this applicant?');">Approve</button>	</a>
        <a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=rejected"><button class="application-form-button" style="background-color:red" onclick="return confirm('Are you sure to reject this applicant?');">Reject</button></a>
    <?php } ?>
    </div>
</div>
  </div>


<?php $i++; 
} ?>
		
</div>
</div>



<?php }}else{ ?>
<div style="width: 100%;height: 100%; display: flex;justify-content: center;align-items: center;padding-top: 5%;">
	<img src="../media/no-document.jpg" width="300px" height="300px">
</div>
<?php } ?>
</div>
<?php } ?>


<?php
function complete($role,$key,$sellerID){
	include '../Database/Connection.php';
$i=1;
$sql = "SELECT p.petID, s.$key,p.gender,p.purpose, p.pet_image, p.breedID,b.name,i.inquiryID,COUNT(i.inquiryID) AS num,m.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $role s ON  p.$key=s.$key LEFT JOIN inquiry i ON i.petID=p.petID LEFT JOIN pet_payment m ON p.petID=m.petID WHERE s.$key=$sellerID AND (p.purpose='Rehome' OR p.purpose='Lodging') AND m.status='Complete' GROUP BY p.petID ORDER BY
    CASE
        WHEN m.status IS NULL THEN 0
        WHEN m.status = 'Booked' THEN 1
        WHEN m.status = 'Appointment' THEN 2
        WHEN m.status = 'Decision' THEN 3
        WHEN m.status = 'Payment' THEN 4
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
	   $purpose=$row['purpose'];
	   $bname=$row['name'];
	   $num=$row['num'];
 	   $sql7 = "SELECT status from pet_payment where status='Complete' AND petID=$petID;";
 	   $sql10 = "SELECT status from pet_payment where status='Payment' AND petID=$petID;";
 	   $sql15 = "SELECT status from pet_payment where status='Fail' AND petID=$petID;";
 	   $sql8 = "SELECT status from inquiry where status='Decision' AND petID=$petID;";
 	   $sql9 = "SELECT status from inquiry where status='Appointment' AND petID=$petID;";


 	   $result7 = $conn->query($sql7);
 	   $result8 = $conn->query($sql8);
 	   $result9 = $conn->query($sql9);
 	   $result10 = $conn->query($sql10);
 	   $result15 = $conn->query($sql15);
 	   $z;
    if ($result7->num_rows > 0) {
    	$z=5;
    	$sql10 ="SELECT m.complete_date,m.paymentID,m.transactionId,CONCAT(a.firstName,' ',a.lastName) As adopter_name,p.price FROM pet_payment m,adopter a,pet p WHERE m.adopterID=a.adopterID AND m.petID=p.petID AND m.petID= $petID AND m.status='Complete'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['complete_date'];
    	$visit_time=NULL;
    	$price=$row10['price'];
    	$transactionId=$row10['transactionId'];
    	$adopter_name=$row10['adopter_name'];
    }
    }
    elseif ($result15->num_rows > 0) {
    	$z=6;
    	$sql10 ="SELECT visit_date,visit_time,paymentID FROM pet_payment WHERE petID= $petID AND status='Fail'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    }
    }
    elseif ($result10->num_rows > 0) {
    	$z=4;
    	$sql10 ="SELECT visit_date,visit_time,paymentID FROM pet_payment WHERE petID= $petID AND status='Payment'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    }
    }
    elseif ($result8->num_rows > 0) {
    	$z=3;
    	$sql10 ="SELECT visit_date,visit_time,paymentID,status FROM pet_payment WHERE petID= $petID AND (status='Decision' OR status='Y' OR status='y' OR status='Free')";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    	$status2=$row['status'];
    }
    }
    elseif ($result9->num_rows > 0) {
    	$z=2;
    	$visit_date= NULL;
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
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #005c99; font-weight: 800;">group</span>No of applicants:<b> <?php echo $num ?></b>
			</div>
			</div>
			<div class="column-container" style="width:52%">
			<?php if($z==5){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Completed</b>
			</div>
		<?php }
		elseif ($z==6){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b style="color: #cc0000;">Rejected by adopter</b>
			</div>
		<?php } 
		elseif ($z==4){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Payment</b>
			</div>
		<?php } 
		elseif ($z==3){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Meet with adopter</b>
			</div>
		<?php }
		elseif ($z==2){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Meet with adopter</b>
			</div>
		<?php } 
		elseif ($z==1){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Finding adopter</b>
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
				<span class="material-symbols-outlined visited">quick_reference_all</span>
				<span class="material-symbols-outlined <?php if($z>=2){echo 'visited';} ?>">event</span>
				<?php if($z<6){?>
				<span class="material-symbols-outlined <?php if($z>=3){echo 'visited';} ?>">flaky</span>
				<span class="material-symbols-outlined <?php if($z>=4 ){echo 'visited';} ?>">payments</span>
				<span class="material-symbols-outlined <?php if($z>=5 ){echo 'visited';} ?>" id="last-process" >check_circle</span>
				<?php } 
				elseif($z==6){?>
					<span class="material-symbols-outlined <?php if($z>=3){echo 'fail';} ?>">flaky</span>
					<span class="material-symbols-outlined <?php if($z>=4 ){echo 'fail';} ?>">payments</span>
					<span class="material-symbols-outlined <?php if($z>=5 ){echo 'fail';} ?>" id="last-process" >cancel</span>
				<?php } ?>
			</div>
		<?php
		$sql2 = "SELECT p.petID, p.gender, p.pet_image, p.breedID,b.name,i.inquiryID,i.question1,i.question2,i.question3,i.question4,i.question5,i.question6,i.question7,i.question8,i.question9,i.question10,i.submit_date,i.status, i.adopterID,a.image,CONCAT(a.firstName,a.lastName) As adopter_name FROM pet p,breed b,inquiry i,adopter a WHERE p.breedID=b.breedID AND i.petID=p.petID AND i.adopterID=a.adopterID AND p.petID=$petID AND i.status !='Rejected' order by
			(case WHEN i.status='Appointment' then 1
			WHEN i.status='Pending' then 2
			END),i.inquiryID;";
			$result2 = $conn->query($sql2);
    		$rows2 = $result2->fetch_all(MYSQLI_ASSOC);
    		
    		foreach ($rows2 as $row2) { 
	        	$imageData2 = base64_encode($row2['image']);
	            $imageSrc2 = "data:image/jpg;base64," . $imageData2;
	            if ($row2['image']=='') {
	                $imageSrc2 = '../media/profile.png';
            }
	            elseif (file_exists('../User/adopter_images/' . $row2['image'])) {
	                $imageSrc2 = '../User/adopter_images/' . $row2['image'];
            }
            $qID = $row2['inquiryID'];
            $question1 = $row2['question1'];
            $question2 = $row2['question2'];
            $question3 = $row2['question3'];
            $question4 = $row2['question4'];
            $question5 = $row2['question5'];
            $question6 = $row2['question6'];
            $question7 = $row2['question7'];
            $question8 = $row2['question8'];
            $question9 = $row2['question9'];
            $question10 = $row2['question10'];
            $status = $row2['status'];
            $submit_date = $row2['submit_date'];

		?>
		<?php if($z>1){ 
				if($status=='Pending'){?>
		<div class="column">
			<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card lock">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button lock-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined lock-button" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
<?php }
		elseif($z==3 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<input type="hidden" name="paymentID" id="mid<?php echo $i ?>" value="<?php echo $paymentID ?>">
            	<?php if($status2=='Y' || $status2=='Free'){?>
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>,event)" style="background-color:#29a329 ;color: white;" disabled><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">check</span>Pending...</button>
            <?php }else{?>
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>)" style="background-color:#29a329 ;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">check</span></button>
            	<button class="view-application-button" id="wrong" type="button" onclick="reject(<?php echo $paymentID ?>,<?php echo $qID ?>,event)" style="background-color: red;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">close</span></button>
            <?php } ?>
            </div>
            </div>
        </a>
		</div>
		<?php }	
		elseif($z==4 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>)" style="background-color:#29a329 ;color: white;" disabled><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">payments</span>Waiting Payment</button>
            </div>
            </div>
        </a>
		</div>
		<?php }
		elseif($z==6 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #cc0000">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="fail" type="button" onclick="restart(<?php echo $qID ?>,<?php echo $paymentID ?>)" style="background-color:#cc0000 ;color: white;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">restart_alt</span>Restart Adoption</button>
            </div>
            </div>
        </a>
		</div>
		<?php }
		elseif($z==5 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="correct" type="button" onclick="details(<?php echo $paymentID ?>,event)" style="background-color:#29a329 ;color: white;">
            		<?php if($purpose=='Rehome'){ ?>
            	Adoption Agreement
            <?php }else{ ?>
            	Lodging Agreement
            <?php } ?>
            </button>
            </div>
            </div>
        </a>
		</div>

		<div id="DetailsModal<?php echo $i ?>" class="modal" >
  <div class="modal-content" style="height: auto;padding-bottom: 40px;margin-top:130px;width:60%">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2 style="font-size:30px">Payment Details</h2>
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
        <td style="font-size: 30px;">From</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $adopter_name ?></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Completed date</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $visit_date ?></p></td>
      </tr>
  </table>
    
  </div>
  </div>
</div>

		<?php }
		else{ ?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
			<?php }}else{ ?>
				<div class="column">
					<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
			<?php } ?>

<?php $date1=date_create($submit_date);
	  date_default_timezone_set('Asia/Singapore');
	  $current=date_create(date("Y-m-d"));
	  $diff=date_diff($date1,$current); 
	  if($diff->format("%a days")=='0 days'){
	  	$submission='today';
	  }
	  else{
	  	$submission = $diff->format("%a days"). " ago";
	  } ?>
	<div id="applicationModal<?php echo $i ?>" class="modal" style="padding-top:50px;">
  <!-- Modal content -->
  <div class="modal-content" style="width:60%;height:auto;margin-bottom:100px;padding-bottom:50px">
    <div class="modal-header" style="font-size:20px">
      <h2>Application Form (Submitted <?php echo $submission ?>)</h2>
      <span class="close">&times;</span>
      </div>
      	<br>
  <div class="applicationModal-style">
  <h3>About:</h3>
  <br>

   <div class="adoption-form-subcontainer">
  <label for="experience">1) Have you owned pets before? If yes, please provide details:</label>
  <p><?php echo $question1 ?></p>

  <label for="occupation">2) What is your occupation?</label>
<p><?php echo $question2 ?></p>

  <label for="lifestyle">3) Describe your current lifestyle and daily routine:</label>
  <p><?php echo $question3 ?></p>

<label for="pet-training">4) Are you willing to invest time and effort into training a pet if needed?</label>
<p><?php echo $question4 ?></p>
</div>
<hr ><br>
  <h3>About Home:</h3>
  <br>
  <div class="adoption-form-subcontainer">
  <label for="residence">1) Do you own or rent your residence?</label>
  <p><?php echo $question5 ?></p>

  <label for="residence-details">2) Please provide details about your residence (e.g., house, apartment, yard size):</label>
  <p><?php echo $question6 ?></p>
</div>
<hr ><br>
  <h3>About Pet Care:</h3>
  <br>
   <div class="adoption-form-subcontainer">
  <label for="commitment">1) Are you committed to taking care of a pet for its entire life (typically 10-15 years or longer)?</label>
  <p><?php echo $question7 ?></p>

  <label for="pet-grooming">2) Are you comfortable with grooming and maintenance requirements for the pet you are adopting?</label>
  <p><?php echo $question8 ?></p>

<label for="pet-expenses">3) Are you prepared for the financial responsibilities of owning a pet, including food, vaccinations, grooming, and veterinary care?</label>
<p><?php echo $question9 ?></p>
</div>
<hr ><br>
  <h3>Additional Comments:</h3>
  <br>
   <div class="adoption-form-subcontainer">
  <label for="comments">Please provide any additional comments or information:</label>
  <p><?php echo $question10 ?></p>
</div>
</div>
<br>
<div class="application-form-button-container">
	<?php if($z>1){ 
				if($status=='Pending'){?>
	
    <?php }
    else{?>
    	<a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=appointment">
<button class="application-form-button" onclick="return confirm('Are you sure to approve this applicant?');">Approve</button>	</a>
        <a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=rejected"><button class="application-form-button" style="background-color:red" onclick="return confirm('Are you sure to reject this applicant?');">Reject</button></a>
    <?php }}else{ ?>
    	<a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=appointment">
<button class="application-form-button" onclick="return confirm('Are you sure to approve this applicant?');">Approve</button>	</a>
        <a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=rejected"><button class="application-form-button" style="background-color:red" onclick="return confirm('Are you sure to reject this applicant?');">Reject</button></a>
    <?php } ?>
    </div>
</div>
  </div>


<?php $i++; 
} ?>
		
</div>
</div>



<?php }}else{ ?>
<div style="width: 100%;height: 100%; display: flex;justify-content: center;align-items: center;padding-top: 5%;">
	<img src="../media/no-document.jpg" width="300px" height="300px">
</div>
<?php } ?>
</div>
<?php } ?>


<?php
function cancel($role,$key,$sellerID){
	include '../Database/Connection.php';
$i=1;
$sql = "SELECT p.petID, s.$key,p.gender, p.pet_image, p.breedID,b.name,i.inquiryID,COUNT(i.inquiryID) AS num,m.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $role s ON  p.$key=s.$key LEFT JOIN inquiry i ON i.petID=p.petID LEFT JOIN pet_payment m ON p.petID=m.petID WHERE s.$key=$sellerID AND (p.purpose='Rehome' OR p.purpose='Lodging') AND m.status='Fail' GROUP BY p.petID ORDER BY
    CASE
        WHEN m.status IS NULL THEN 0
        WHEN m.status = 'Booked' THEN 1
        WHEN m.status = 'Appointment' THEN 2
        WHEN m.status = 'Decision' THEN 3
        WHEN m.status = 'Payment' THEN 4
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
	   $num=$row['num'];
 	   $sql7 = "SELECT status from pet_payment where status='Complete' AND petID=$petID;";
 	   $sql10 = "SELECT status from pet_payment where status='Payment' AND petID=$petID;";
 	   $sql15 = "SELECT status from pet_payment where status='Fail' AND petID=$petID;";
 	   $sql8 = "SELECT status from inquiry where status='Decision' AND petID=$petID;";
 	   $sql9 = "SELECT status from inquiry where status='Appointment' AND petID=$petID;";


 	   $result7 = $conn->query($sql7);
 	   $result8 = $conn->query($sql8);
 	   $result9 = $conn->query($sql9);
 	   $result10 = $conn->query($sql10);
 	   $result15 = $conn->query($sql15);
 	   $z;
    if ($result7->num_rows > 0) {
    	$z=5;
    	$sql10 ="SELECT m.complete_date,m.paymentID,m.transactionId,CONCAT(a.firstName,' ',a.lastName) As adopter_name,p.price FROM pet_payment m,adopter a,pet p WHERE m.adopterID=a.adopterID AND m.petID=p.petID AND m.petID= $petID AND m.status='Complete'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['complete_date'];
    	$visit_time=NULL;
    	$price=$row10['price'];
    	$transactionId=$row10['transactionId'];
    	$adopter_name=$row10['adopter_name'];
    }
    }
    elseif ($result15->num_rows > 0) {
    	$z=6;
    	$sql10 ="SELECT visit_date,visit_time,paymentID FROM pet_payment WHERE petID= $petID AND status='Fail'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    }
    }
    elseif ($result10->num_rows > 0) {
    	$z=4;
    	$sql10 ="SELECT visit_date,visit_time,paymentID FROM pet_payment WHERE petID= $petID AND status='Payment'";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    }
    }
    elseif ($result8->num_rows > 0) {
    	$z=3;
    	$sql10 ="SELECT visit_date,visit_time,paymentID,status FROM pet_payment WHERE petID= $petID AND (status='Decision' OR status='Y' OR status='y' OR status='Free')";
    $result10 = $conn->query($sql10);
  	$row10 = $result10->fetch_assoc();
    if ($result10->num_rows > 0) {
    	$paymentID=$row10['paymentID'];
    	$visit_date=$row10['visit_date'];
    	$visit_time=$row10['visit_time'];
    	$status2=$row['status'];
    }
    }
    elseif ($result9->num_rows > 0) {
    	$z=2;
    	$visit_date= NULL;
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
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #005c99; font-weight: 800;">group</span>No of applicants:<b> <?php echo $num ?></b>
			</div>
			</div>
			<div class="column-container" style="width:52%">
			<?php if($z==5){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Completed</b>
			</div>
		<?php }
		elseif ($z==6){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b style="color: #cc0000;">Rejected by adopter</b>
			</div>
		<?php } 
		elseif ($z==4){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Payment</b>
			</div>
		<?php } 
		elseif ($z==3){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Meet with adopter</b>
			</div>
		<?php }
		elseif ($z==2){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Meet with adopter</b>
			</div>
		<?php } 
		elseif ($z==1){ ?>
			<div class="adopt-form-pet-name"><span class="material-symbols-outlined" style="font-size: 40px; vertical-align: -5px; color: #4d4d4d; font-weight: 800;">pending</span>Status: <b>Finding adopter</b>
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
				<span class="material-symbols-outlined visited">quick_reference_all</span>
				<span class="material-symbols-outlined <?php if($z>=2){echo 'visited';} ?>">event</span>
				<?php if($z<6){?>
				<span class="material-symbols-outlined <?php if($z>=3){echo 'visited';} ?>">flaky</span>
				<span class="material-symbols-outlined <?php if($z>=4 ){echo 'visited';} ?>">payments</span>
				<span class="material-symbols-outlined <?php if($z>=5 ){echo 'visited';} ?>" id="last-process" >check_circle</span>
				<?php } 
				elseif($z==6){?>
					<span class="material-symbols-outlined <?php if($z>=3){echo 'fail';} ?>">flaky</span>
					<span class="material-symbols-outlined <?php if($z>=4 ){echo 'fail';} ?>">payments</span>
					<span class="material-symbols-outlined <?php if($z>=5 ){echo 'fail';} ?>" id="last-process" >cancel</span>
				<?php } ?>
			</div>
		<?php
		$sql2 = "SELECT p.petID, p.gender, p.pet_image, p.breedID,b.name,i.inquiryID,i.question1,i.question2,i.question3,i.question4,i.question5,i.question6,i.question7,i.question8,i.question9,i.question10,i.submit_date,i.status, i.adopterID,a.image,CONCAT(a.firstName,a.lastName) As adopter_name FROM pet p,breed b,inquiry i,adopter a WHERE p.breedID=b.breedID AND i.petID=p.petID AND i.adopterID=a.adopterID AND p.petID=$petID AND i.status !='Rejected' order by
			(case WHEN i.status='Appointment' then 1
			WHEN i.status='Pending' then 2
			END),i.inquiryID;";
			$result2 = $conn->query($sql2);
    		$rows2 = $result2->fetch_all(MYSQLI_ASSOC);
    		
    		foreach ($rows2 as $row2) { 
	        	$imageData2 = base64_encode($row2['image']);
	            $imageSrc2 = "data:image/jpg;base64," . $imageData2;
	            if ($row2['image']=='') {
	                $imageSrc2 = '../media/profile.png';
            }
	            elseif (file_exists('../User/adopter_images/' . $row2['image'])) {
	                $imageSrc2 = '../User/adopter_images/' . $row2['image'];
            }
            $qID = $row2['inquiryID'];
            $question1 = $row2['question1'];
            $question2 = $row2['question2'];
            $question3 = $row2['question3'];
            $question4 = $row2['question4'];
            $question5 = $row2['question5'];
            $question6 = $row2['question6'];
            $question7 = $row2['question7'];
            $question8 = $row2['question8'];
            $question9 = $row2['question9'];
            $question10 = $row2['question10'];
            $status = $row2['status'];
            $submit_date = $row2['submit_date'];

		?>
		<?php if($z>1){ 
				if($status=='Pending'){?>
		<div class="column">
			<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card lock">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button lock-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined lock-button" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
<?php }
		elseif($z==3 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<input type="hidden" name="paymentID" id="mid<?php echo $i ?>" value="<?php echo $paymentID ?>">
            	<?php if($status2=='Y' || $status2=='Free'){?>
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>)" style="background-color:#29a329 ;color: white;" disabled><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">check</span>Pending...</button>
            <?php }else{?>
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>)" style="background-color:#29a329 ;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">check</span></button>
            	<button class="view-application-button" id="wrong" type="button" onclick="reject(<?php echo $paymentID ?>,<?php echo $qID ?>,event)" style="background-color: red;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">close</span></button>
            <?php } ?>
            </div>
            </div>
        </a>
		</div>
		<?php }	
		elseif($z==4 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="correct" type="button" onclick="accept(<?php echo $i ?>)" style="background-color:#29a329 ;color: white;" disabled><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">payments</span>Waiting Payment</button>
            </div>
            </div>
        </a>
		</div>
		<?php }
		elseif($z==6 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #cc0000">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="fail" type="button" onclick="restart(<?php echo $qID ?>,<?php echo $paymentID ?>)" style="background-color:#cc0000 ;color: white;"><span class="material-symbols-outlined" style="vertical-align:-4px;font-weight: bold;color: white;">restart_alt</span>Restart Adoption</button>
            </div>
            </div>
        </a>
		</div>
		<?php }
		elseif($z==5 && $status!=='Pending'){?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon" style="display: flex;flex-direction: row;">
            	<button class="view-application-button" id="correct" type="button" onclick="details(<?php echo $paymentID ?>,event)" style="background-color:#29a329 ;color: white;">Adoption Agreement</button>
            </div>
            </div>
        </a>
		</div>

		<div id="DetailsModal<?php echo $i ?>" class="modal" >
  <div class="modal-content" style="height: auto;padding-bottom: 40px;margin-top:130px;width:60%">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2 style="font-size:30px">Payment Details</h2>
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
        <td style="font-size: 30px;">From</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $adopter_name ?></p></td>
      </tr>
      <tr>
        <td style="font-size: 30px;">Completed date</td>
        <td style="font-size: 30px;">:</td>
        <td><p style="font-size: 30px;"><?php echo $visit_date ?></p></td>
      </tr>
  </table>
    
  </div>
  </div>
</div>

		<?php }
		else{ ?>
			<div class="column">
				<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card" style="border:2px solid #29a329">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
			<?php }}else{ ?>
				<div class="column">
					<a href="User-Profile.php?id=<?php echo $row2['adopterID'] ?>&sid=<?php echo $row[$key]?>">
            <div class="card">
            <img src="<?php echo $imageSrc2 ?>" alt="Vet" style="width:100%;height: 154px;">
            <div class="petName">
            <p><b><?php echo $row2['adopter_name'] ?></b></p>
            </div>
            <div class="breedIcon">
            	<button class="view-application-button" type="button" onclick="openModal(<?php echo $i ?>)"><span class="material-symbols-outlined" style="vertical-align:-4px">description</span>View Application</button>
            </div>
            </div>
        </a>
	</div>
			<?php } ?>

<?php $date1=date_create($submit_date);
	  date_default_timezone_set('Asia/Singapore');
	  $current=date_create(date("Y-m-d"));
	  $diff=date_diff($date1,$current); 
	  if($diff->format("%a days")=='0 days'){
	  	$submission='today';
	  }
	  else{
	  	$submission = $diff->format("%a days"). " ago";
	  } ?>
	<div id="applicationModal<?php echo $i ?>" class="modal" style="padding-top:50px;">
  <!-- Modal content -->
  <div class="modal-content" style="width:60%;height:auto;margin-bottom:100px;padding-bottom:50px">
    <div class="modal-header" style="font-size:20px">
      <h2>Application Form (Submitted <?php echo $submission ?>)</h2>
      <span class="close">&times;</span>
      </div>
      	<br>
  <div class="applicationModal-style">
  <h3>About:</h3>
  <br>

   <div class="adoption-form-subcontainer">
  <label for="experience">1) Have you owned pets before? If yes, please provide details:</label>
  <p><?php echo $question1 ?></p>

  <label for="occupation">2) What is your occupation?</label>
<p><?php echo $question2 ?></p>

  <label for="lifestyle">3) Describe your current lifestyle and daily routine:</label>
  <p><?php echo $question3 ?></p>

<label for="pet-training">4) Are you willing to invest time and effort into training a pet if needed?</label>
<p><?php echo $question4 ?></p>
</div>
<hr ><br>
  <h3>About Home:</h3>
  <br>
  <div class="adoption-form-subcontainer">
  <label for="residence">1) Do you own or rent your residence?</label>
  <p><?php echo $question5 ?></p>

  <label for="residence-details">2) Please provide details about your residence (e.g., house, apartment, yard size):</label>
  <p><?php echo $question6 ?></p>
</div>
<hr ><br>
  <h3>About Pet Care:</h3>
  <br>
   <div class="adoption-form-subcontainer">
  <label for="commitment">1) Are you committed to taking care of a pet for its entire life (typically 10-15 years or longer)?</label>
  <p><?php echo $question7 ?></p>

  <label for="pet-grooming">2) Are you comfortable with grooming and maintenance requirements for the pet you are adopting?</label>
  <p><?php echo $question8 ?></p>

<label for="pet-expenses">3) Are you prepared for the financial responsibilities of owning a pet, including food, vaccinations, grooming, and veterinary care?</label>
<p><?php echo $question9 ?></p>
</div>
<hr ><br>
  <h3>Additional Comments:</h3>
  <br>
   <div class="adoption-form-subcontainer">
  <label for="comments">Please provide any additional comments or information:</label>
  <p><?php echo $question10 ?></p>
</div>
</div>
<br>
<div class="application-form-button-container">
	<?php if($z>1){ 
				if($status=='Pending'){?>
	
    <?php }
    else{?>
    	<a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=appointment">
<button class="application-form-button" onclick="return confirm('Are you sure to approve this applicant?');">Approve</button>	</a>
        <a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=rejected"><button class="application-form-button" style="background-color:red" onclick="return confirm('Are you sure to reject this applicant?');">Reject</button></a>
    <?php }}else{ ?>
    	<a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=appointment">
<button class="application-form-button" onclick="return confirm('Are you sure to approve this applicant?');">Approve</button>	</a>
        <a href="Seller_Adoption-Form-Process.php?id=<?php echo $qID ?>&c=rejected"><button class="application-form-button" style="background-color:red" onclick="return confirm('Are you sure to reject this applicant?');">Reject</button></a>
    <?php } ?>
    </div>
</div>
  </div>


<?php $i++; 
} ?>
		
</div>
</div>



<?php }}else{ ?>
<div style="width: 100%;height: 100%; display: flex;justify-content: center;align-items: center;padding-top: 5%;">
	<img src="../media/no-document.jpg" width="300px" height="300px">
</div>
<?php } ?>
</div>
<?php } ?>
</div>
<script type="text/javascript">

$(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('adoption');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'available') {
    $('a[href*="Seller_Adoption-Form.php?adoption=available"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Seller_Adoption-Form.php?adoption=appointment"]').css('border-bottom', '0');
    $('a[href*="Seller_Adoption-Form.php?adoption=complete"]').css('border-bottom', '0');
    $('a[href*="Seller_Adoption-Form.php?adoption=cancel"]').css('border-bottom', '0');
  }
  else if (sValue === 'appointment') {
    $('a[href*="Seller_Adoption-Form.php?adoption=appointment"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Seller_Adoption-Form.php?adoption=available"]').css('border-bottom', '0');
    $('a[href*="Seller_Adoption-Form.php?adoption=complete"]').css('border-bottom', '0');
    $('a[href*="Seller_Adoption-Form.php?adoption=cancel"]').css('border-bottom', '0');
  }
  else if (sValue === 'complete') {
    $('a[href*="Seller_Adoption-Form.php?adoption=complete"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Seller_Adoption-Form.php?adoption=appointment"]').css('border-bottom', '0');
    $('a[href*="Seller_Adoption-Form.php?adoption=available"]').css('border-bottom', '0');
    $('a[href*="Seller_Adoption-Form.php?adoption=cancel"]').css('border-bottom', '0');
  }
  else if (sValue === 'cancel') {
    $('a[href*="Seller_Adoption-Form.php?adoption=cancel"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Seller_Adoption-Form.php?adoption=appointment"]').css('border-bottom', '0');
    $('a[href*="Seller_Adoption-Form.php?adoption=complete"]').css('border-bottom', '0');
    $('a[href*="Seller_Adoption-Form.php?adoption=available"]').css('border-bottom', '0');
  }
  else{
    $('a[href*="Seller_Adoption-Form.php?adoption=available"]').css('border-bottom', '5px solid #00a8de');
  }
});


	function openModal(n){
		event.preventDefault();
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
        column.classList.add('collapsed');
      } else {
        column.classList.add('collapsed');
      }
    }
  }

  checkbox.addEventListener('change', handleCheckboxChange);

  // Initial call to set the initial state based on the checkbox's initial checked state
  handleCheckboxChange();


    function accept(i,event) {
    	event.preventDefault();
    	if (confirm("Are you sure you want to accept this applicant?")) {
    	
     var mid= document.getElementById("mid"+i).value;
    window.location.href = "Seller_Adoption-Form-Process.php?id="+mid+"&c=sdecision";
    }
  }

  function reject(i, n,event) {
  	event.preventDefault();
  if (confirm("Are you sure you want to reject this applicant?")) {
    
    window.location.href = "Seller_Adoption-Form-Process.php?id=" + i + "&iid=" + n + "&c=sreject";
  }
}


  function restart(iID,mID) {

    event.preventDefault(); // Prevents anchor tag from triggering its default behavior
    window.location.href = "Seller_Adoption-Form-Process.php?id="+iID+"&mid="+mID+"&c=restart";
  }

function details( i, event) {
  event.preventDefault();
  window.open("User-Adoption-Receipt.php?paymentID=" + i, "_blank");
}

function reason(id,id2,proc,event){
	event.preventDefault();
	let reason = prompt("Please enter the reason", "");
	if (reason === '') {
    alert("Please provide a reason.");
    return;
}

	if(proc=='rejected'){
		window.location.href = "Seller_Adoption-Form-Email.php?id="+id+"&iid=0&c=rejected&reason="+reason;
	}
	else if(proc=='sreject'){
		window.location.href = "Seller_Adoption-Form-Email.php?id=" + id + "&iid=" + id2 + "&c=sreject&reason="+reason;
	}
  }

</script>


</body>
</html>