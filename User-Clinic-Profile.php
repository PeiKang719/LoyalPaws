<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LoyalPaws</title>
	<link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="stylesheet" type="text/css" href="UserStyle.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style type="text/css">
	html,body{
		width: 100%;
		height: 100%;
	}
</style>
<body>
<?php include 'UserHeader.php'; ?>
<?php 
        if (isset($_GET['cid'])) {
            $cid=$_GET['cid'];
            $sql = "SELECT * FROM clinic WHERE clinicID = $cid"; 
            showClinic($sql,$cid);
        }

function showClinic($sql,$cid){
include('Connection.php');

$result = $conn->query($sql);

$row = $result->fetch_assoc();
$clinic_name=$row['name'];
$imageData = base64_encode($row['clinic_image']);
$imageSrc = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if($row['clinic_image']==NULL){
	$imageSrc = 'media/clinic-default.png';
}
if (file_exists('clinic_images/' . $row['clinic_image'])) {
    $imageSrc = 'clinic_images/' . $row['clinic_image'];
}


$imageData2 = base64_encode($row['cover']);
$imageSrc2 = "data:image/jpg;base64," . $imageData2;
// Check if the image file exists before displaying it
if($row['cover']==''){
	$imageSrc2 = 'media/clinic_cover.png';
}
elseif (file_exists('clinic_covers/' . $row['cover'])) {
    $imageSrc2 = 'clinic_covers/' . $row['cover'];
}
?>

<div class="profile-container">
	<div class="cover-picture">
		<img src="<?php echo $imageSrc2 ?>"  style="width: 100%;height: 500px;">
	</div>
	<div class="seller-image-container">
		<img class="seller-image" src="<?php echo $imageSrc ?>" alt="Avatar">
		<div class="seller-name-container">
			<div class="seller-name-row" style="align-items:flex-end;">
				<p class="seller-name"> <?php  echo $clinic_name ?> </p>
			</div>
			<div class="seller-name-row">
				<span class="material-symbols-outlined" style="font-size:40px;margin-right: 3%;">distance</span><p class="seller-location"> <?php echo $row["state"] ?><span style="font-size: 20px;color:#4d4d4d;vertical-align: 5px;margin-left: 3%;margin-right: 3%">&#9679;</span><?php echo $row["area"] ?> </p>
			</div>
		</div>
	</div>
	<br><br><br>
	<div class="book-appointment-container">
		<a href="User-Clinic-Appointment.php?cid=<?php echo $cid ?>">Book Appointment
	</a>
	</div>
	<div class="seller-section">
		<a href="User-Clinic-Profile.php?s=about&cid=<?php echo $cid; ?>" style="border-bottom: 5px solid #00a8de;"><button class="seller-section-button" >About</button></a>
		<a href="User-Clinic-Profile.php?s=vet&cid=<?php echo $cid; ?>"><button class="seller-section-button">Veterinarians</button></a>
	</div>

        <?php 
        if (isset($_GET['s'])) {
            $s=$_GET['s'];
            if($s=='vet'){
                vet();
            }
            else if($s=='about'){
                about();
            }
        }
        elseif (!isset($_GET['s'])){
        	about();
        }
        ?>
        <?php } ?>
        <?php function vet(){ 
        	$cid=$_GET['cid'];?>
			<div class="breed-container" style="padding-top:2%;height:auto">
			<div class="breed-card" id="breed-card-container" style="width: 85%;padding-left: 7.5%;padding-right:7.5%;">
            <?php include 'Connection.php'; ?>
            <?php
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $count = "SELECT count(*) as total from vet where clinicID=$cid AND ic REGEXP '^[0-9]+$'";
            $data = $conn->query($count);
            $dat = $data->fetch_assoc();
            $total_records = $dat["total"];
            $records_per_page = 12;
            $total_pages = ceil($total_records / $records_per_page);
            if ($page < 1) {
                $page = 1;
            }
            $offset = ($page - 1) * $records_per_page;
            $sql = "SELECT * FROM vet WHERE clinicID = $cid AND ic REGEXP '^[0-9]+$' ORDER BY vetID ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<div style="width:100%;height:20px">';
                echo $total_records. " vets";
                echo '</div>';
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($rows as $row) {
                    if($row['image']!=''){
                $imageData = base64_encode($row['image']);
                $imageSrc = "data:image/jpg;base64," . $imageData;
                // Check if the image file exists before displaying it
                if (file_exists('vet_images/' . $row['image'])) {
                    $imageSrc = 'vet_images/' . $row['image'];
                }
                }
                else{
                  $gender=$row['ic'][-1];
                  if( $gender% 2 == 0){
                    $imageSrc='media/email_female.png';
                  }
                  else{
                    $imageSrc='media/email_male.png';
                  }
                }
            echo '<a href="Clinic-Vet-Profile.php?vid=' . $row['vetID'] . '" target="_blank" style="margin:2%"><div class="card2" style="height:275px">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            
            echo '<p><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	       
            echo '<div class="view-breed3">';
            echo '<p>View Profile</p>';
            echo '</div>';
            echo '</div></a>';
                }
            }
            ?>
        </div>
    </div>
<?php
}
?>
	<?php function about(){
		$cid=$_GET['cid']; 
		include('Connection.php');

		$sql = "SELECT * FROM clinic WHERE clinicID = $cid"; 

		$result = $conn->query($sql);

		$row = $result->fetch_assoc();?>
		<div class="seller-profile-header">About Clinic:</div>
	<div class="description-container">
		<div class="seller-description">
			<p style="white-space: pre-line;word-wrap: break-word;"><?php  echo $row["description"] ?></p>
		</div>
	</div>
	<div class="seller-profile-header">More Information:</div>
	<div class="seller-info-container">
		<table border="0" style="width: 80%;padding-left: 5%;">
		<tr>
			<td><span class="material-symbols-outlined" id="seller-info-icon">volunteer_activism</span></td>
			<td  style="width:30%"><p class="seller-info" >Adopter Exclusive Discount</p></td>
			<td><p class="seller-info">:</p></td>
			<td colspan="4"  style="width:60%"><p class="seller-info" ><b><?php  echo $row["discount_percent"] ?> %</b></p></td>
		</tr>
		<tr>
			<td><span class="material-symbols-outlined" id="seller-info-icon">call</span></td>
			<td  style="width:30%"><p class="seller-info" >Contact Number</p></td>
			<td><p class="seller-info">:</p></td>
			<td colspan="4"  style="width:60%"><p class="seller-info" ><?php  echo $row["phone"] ?></p></td>
		</tr>
		<tr valign="middle;">
			<td><span class="material-symbols-outlined" id="seller-info-icon">mail</span></td>
			<td><p class="seller-info" >Email</p></td>
			<td><p class="seller-info">:</p></td>
			<td colspan="4"><p class="seller-info" ><?php  echo $row["email"] ?></p></td>
		</tr>
		<tr >
			<td><span class="material-symbols-outlined" id="seller-info-icon">home</span></td>
			<td><p class="seller-info" >Address</p></td>
			<td><p class="seller-info">:</p></td>
			<td colspan="4"><p class="seller-info" ><?php  echo $row["address"] ?>,<?php  echo $row["area"] ?>,<?php  echo $row["state"] ?></p></td>
		</tr>
		<tr >
			<?php $days = explode(",", $row["work_day"]);
	  			$opens = explode(",", $row["open_time"]);
	  			$closes = explode(",", $row["close_time"]);
	  			$date = array("Sunday", "Monday", "Tuesday","Wednesday","Thursday","Friday","Saturday");
	 			 $count = count($days);?>
			<td><span class="material-symbols-outlined" id="seller-info-icon">calendar_month</span></td>
			<td><p class="seller-info" style="padding:10px 0px">Working Hours</p></td>
			<td><p class="seller-info" style="padding:10px 0px">:</p></td>
			<?php
			$i=0;
			for($j = 0; $j < count($date); $j++) {
				
					    if(in_array($date[$j], $days) && $j==0){
        			echo "<td ><p class='seller-info' style='padding:10px 0px'> Sunday </p></td>";
        			echo "<td align=center><p class='seller-info' style='padding:10px 0px'> $opens[$i] </p></td>";
        			echo "<td align=center><p class='seller-info' style='padding:10px 0px'> - </p></td>";
        			echo "<td align=center><p class='seller-info' style='padding:10px 0px'> $closes[$i] </p></td></tr>";
        			$i++;
        			}
        				elseif(!in_array($date[$j], $days) && $j==0){
        			echo "<td ><p class='seller-info' style='padding:10px 0px'> Sunday </p></td>";
        			echo "<td colspan=3 align=center><p class='seller-info' style='padding:10px 0px'>Closed </p></td></tr>";
        			}
        				elseif(in_array($date[$j], $days) && $j>0){
        			echo "<tr><td></td><td></td><td></td>";
        			echo "<td ><p class='seller-info' style='padding:10px 0px'> $date[$j] </p></td>";
        			echo "<td align=center><p class='seller-info' style='padding:10px 0px'> $opens[$i] </p></td>";
        			echo "<td align=center><p class='seller-info' style='padding:10px 0px'> - </p></td>";
        			echo "<td align=center><p class='seller-info' style='padding:10px 0px'> $closes[$i] </p></td></tr>";
        			$i++;
        			}
        				else{
        			echo "<tr><td></td><td></td><td></td>";
        			echo "<td ><p class='seller-info' style='padding:10px 0px'> $date[$j] </p></td>";
        			echo "<td colspan=3 align=center><p class='seller-info' style='padding:10px 0px'>Closed </p></td></tr>";
        			}
        		}
        	
        			?>

	</table>	
		<br><br>
	</div>
<?php } ?>
</div>





<script>
$(document).ready(function() {
    // Listen for changes to the checkboxes
    $('#search-button').click(function() {
        var type = $('input[name="pet[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var purpose = $('input[name="purpose[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var size = $('input[name="size[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var searchQuery = $('#breed-search').val();
         var url = window.location.href;
	    if (url.includes('sid')) {
	        var sid = new URLSearchParams(url).get('sid');
	    } else if (url.includes('iid')) {
	        var iid = new URLSearchParams(url).get('iid');
	    }
        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'Seller-Get-Pet.php',
            type: 'GET',
            data: { sid : sid,iid : iid,type: type, size: size,purpose: purpose, searchQuery: searchQuery },
            success: function(response) {
                // Update the breed cards with the new HTML
                $('#breed-card-container').html(response);
            },
            error: function() {
                alert('Error getting pets.');
            }
        });
    });

    $('input[type="checkbox"]').change(function() {
        // Get the values of the checked checkboxes
        var type = $('input[name="pet[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var purpose = $('input[name="purpose[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var size = $('input[name="size[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var searchQuery = $('#breed-search').val();

         var url = window.location.href;
	    if (url.includes('sid')) {
	        var sid = new URLSearchParams(url).get('sid');
	    } else if (url.includes('iid')) {
	        var iid = new URLSearchParams(url).get('iid');
	    }
        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'Seller-Get-Pet.php',
            type: 'GET',
            data: { sid : sid,iid : iid, type: type, size: size,purpose: purpose, searchQuery: searchQuery },
            success: function(response) {
                // Update the breed cards with the new HTML
                $('#breed-card-container').html(response);
            },
            error: function() {
                alert('Error getting pets.');
            }
        });
    });
});

$(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('s');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'about') {

    $('a[href*="User-Clinic-Profile.php?s=about"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="User-Clinic-Profile.php?s=vet"]').css('border-bottom', '0');
  } else if (sValue === 'vet') {
    $('a[href*="User-Clinic-Profile.php?s=vet"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="User-Clinic-Profile.php?s=about"]').css('border-bottom', '0');
  }
  else{
  	$('a[href*="User-Clinic-Profile.php?s=about"]').css('border-bottom', '5px solid #00a8de');
  }
});



</script>
</body>

</html>