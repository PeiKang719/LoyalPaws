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
$id = $_GET['id'];

include('Connection.php');

$sql = "SELECT * FROM clinic WHERE clinicID = $id"; 

$result = $conn->query($sql);

$row = $result->fetch_assoc();
$imageData = base64_encode($row['clinic_image']);
$imageSrc = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if (file_exists('clinic_images/' . $row['clinic_image'])) {
    $imageSrc = 'clinic_images/' . $row['clinic_image'];
}

if($row['cover']!=''){
$cover=$row['cover'];
$imageData2 = base64_encode($cover);
$imageSrc3 = "data:image/jpg;base64," . $imageData2;
// Check if the image file exists before displaying it
if (file_exists('clinic_covers/' . $cover)) {
    $imageSrc3 = 'clinic_covers/' . $cover;
}
}
else{
    $imageSrc3='media/clinic_cover.png';
  }
?>

<div class="profile-container">
	<div class="cover-picture">
		<img src="<?php echo $imageSrc3 ?>"  style="width: 100%;height: 100%;">
	</div>
	<div class="seller-image-container">
		<img class="seller-image" src="<?php echo $imageSrc ?>" alt="Avatar">
		<div class="seller-name-container">
			<div class="seller-name-row" style="align-items:flex-end;">
				<p class="seller-name"> <?php  echo $row["name"] ?> </p>
			</div>
			<div class="seller-name-row">
				<span class="material-symbols-outlined" style="font-size:40px;margin-right: 3%;">distance</span><p class="seller-location"> <?php echo $row["state"] ?><span style="font-size: 20px;color:#4d4d4d;vertical-align: 5px;margin-left: 3%;margin-right: 3%">&#9679;</span><?php echo $row["area"] ?> </p>
			</div>
		</div>
		<div class="seller-chat-button-container">
			<button class="seller-chat-button"><span class="material-symbols-outlined" style="vertical-align:-3px">chat</span>Chat</button>
		</div>
	</div>
	<div class="seller-section">
		<a href="SideBar_Clinic-Profile.php?s=details&id=<?php echo$id ?>" style="border-bottom: 5px solid #00a8de;"><button class="seller-section-button" >Details</button></a>
		<a href="SideBar_Clinic-Profile.php?s=vets&id=<?php echo$id ?>"><button class="seller-section-button">Veterinarians</button></a>
	</div>

        <?php 
        if (isset($_GET['s'])) {
            $s=$_GET['s'];
            if($s=='details'){
                details();
            }
            else if($s=='vets'){
                vets();
            }
        }
        if (!isset($_GET['s'])){
        	details();
        }
        ?>
        <?php function details(){
        	$id = $_GET['id'];
			include('Connection.php');

		$sql = "SELECT * FROM clinic WHERE clinicID = $id"; 

		$result = $conn->query($sql);

		$row = $result->fetch_assoc();?>
		<div class="seller-profile-header">Discount For Adopters:</div>
		<div class="seller-info-container">
		<table border="0" style="display: flex;width: 100%;padding-left: 5%;">
		<tr>
			<td><span class="material-symbols-outlined" id="seller-info-icon">volunteer_activism</span></td>
			<td><p class="seller-info" >Discount Percentage</p></td>
			<td><p class="seller-info">:</p></td>
			<td ><p class="seller-info" ><?php  echo $row["discount_percent"] ?> %</p></td>
		</tr>
	</table>
</div>
			
			
		<div class="seller-profile-header">About Me:</div>
	<div class="description-container">
		<div class="seller-description">
			<p style="white-space: pre-line;word-wrap: break-word;"><?php  echo $row["description"] ?></p>
		</div>
	</div>
	<div class="seller-profile-header">My Information:</div>
	<div class="seller-info-container">
		<table border="0" style="display: flex;width: 100%;padding-left: 5%;">
		<tr>
			<td><span class="material-symbols-outlined" id="seller-info-icon">call</span></td>
			<td><p class="seller-info" >Contact Number</p></td>
			<td><p class="seller-info">:</p></td>
			<td colspan="4"><p class="seller-info" ><?php  echo $row["phone"] ?></p></td>
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
			<td rowspan=$count><p class="seller-info" style="padding:10px 0px">Working Hours</p></td>
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
	<?php function vets(){ 
		$id = $_GET['id'];
		include('Connection.php');

		$sql = "SELECT * FROM vet WHERE clinicID = $id ORDER BY vetID"; 

		    $result = $conn->query($sql);
		    echo" <div class='vet-bar-container'>";
    if ($result->num_rows > 0) {
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
   echo" <div class='vet-bar'><div class='expand-icon'>❯</div>
   <img class='vet-img' src='media/email_male.png' alt='Vet'>
   <p class='vet-name'>" . $row['name'] . "</p>
   <button class='vet-bar-delete' style='background-color:#2eb82e'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-6px;color:white'>chat</span>Chat</button>
   </div>";
   echo "<div class='vet-bar-expand'>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-2px'>lab_research</span>&nbsp;Area:</p>";
   $areas = explode(",", $row["area"]);
    foreach ($areas as $area) {
        echo "<p style='margin-left:2.5%'>- $area</p>";
    }
    echo "
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>school</span>&nbsp;Education:</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>business_center</span>&nbsp;Experience:</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>mail</span>&nbsp;" . $row['email'] . "</p>
   <br>
   <p class='vet-bar-expand-header'><span class='material-symbols-outlined' style='font-weight: 800;font-size:30px;vertical-align:-5px'>call</span>&nbsp;" . $row['phone'] . "</p>
   </div>";
    echo" </div>";
  }?>
<?php   
}
} ?>
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

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'Seller-Get-Pet.php',
            type: 'GET',
            data: { type: type, size: size,purpose: purpose, searchQuery: searchQuery },
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

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'Seller-Get-Pet.php',
            type: 'GET',
            data: { type: type, size: size,purpose: purpose, searchQuery: searchQuery },
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
  if (sValue === 'pet') {
    $('a[href="Seller-Profile.php?s=pet"]').css('border-bottom', '5px solid #00a8de');
    $('a[href="Seller-Profile.php?s=about"]').css('border-bottom', '0');
  } else if (sValue === 'about') {
    $('a[href="Seller-Profile.php?s=about"]').css('border-bottom', '5px solid #00a8de');
    $('a[href="Seller-Profile.php?s=pet"]').css('border-bottom', '0');
  }
  else{
  	$('a[href="Seller-Profile.php?s=pet"]').css('border-bottom', '5px solid #00a8de');
  }
});


jQuery(function ($) {

  var $vet_bar = $('.vet-bar');
  var $vet_bar_expand = $('.vet-bar-expand');


  $vet_bar.click(function(){
    if ($(event.target).hasClass('vet-bar-approve')) {
      return;
    }
    // Hide all vet_bar_expands
    $vet_bar_expand.slideUp();

    // Check if this vet_bar_expand is already open
    if($(this).hasClass('open')){
      // If already open, remove 'open' class and hide vet_bar_expand
      $(this).removeClass('open')
             .next($vet_bar_expand).slideUp();
    // If it is not open...
    }else{
      // Remove 'open' class from all other vet_bars
      $vet_bar.removeClass('open');
      // Open this vet_bar_expand and add 'open' class
      $(this).addClass('open')
             .next($vet_bar_expand).slideDown();
           
    }
  });

});

$(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('s');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'details') {
    $('a[href*="SideBar_Clinic-Profile.php?s=details"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="SideBar_Clinic-Profile.php?s=vets"]').css('border-bottom', '0');
  } else if (sValue === 'vets') {
    $('a[href*="SideBar_Clinic-Profile.php?s=vets"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="SideBar_Clinic-Profile.php?s=details"]').css('border-bottom', '0');
  }
  else{
  	$('a[href*="SideBar_Clinic-Profile.php?s=details"]').css('border-bottom', '5px solid #00a8de');
  }
});
</script>
</body>

</html>