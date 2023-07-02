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
<?php include 'AdminHeader.php'; ?>
<?php
$id = $_GET['id'];

include('Connection.php');

$sql = "SELECT * FROM clinic WHERE clinicID = $id"; 

$result = $conn->query($sql);

$row = $result->fetch_assoc();
$imageData = base64_encode($row['clinic_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if($row['clinic_image']==NULL){
                $imageSrc = 'media/clinic-default.png';
            }
            elseif (file_exists('clinic_images/' . $row['clinic_image'])) {
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
		$id = $_GET['id'];?>
		<div class="breed-container" style="padding-top:2%;height:auto">
            <div class="breed-card" id="breed-card-container" style="width: 85%;padding-left: 7.5%;padding-right:7.5%;">
            <?php include 'Connection.php'; ?>
            <?php
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $count = "SELECT count(*) as total from vet where clinicID=$id AND ic REGEXP '^[0-9]+$'";
            $data = $conn->query($count);
            $dat = $data->fetch_assoc();
            $total_records = $dat["total"];
            $records_per_page = 12;
            $total_pages = ceil($total_records / $records_per_page);
            if ($page < 1) {
                $page = 1;
            }
            $offset = ($page - 1) * $records_per_page;
            $sql = "SELECT * FROM vet WHERE clinicID = $id AND ic REGEXP '^[0-9]+$' ORDER BY vetID ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
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
            echo '<a href="Clinic-Vet-Profile.php?vetid=' . $row['vetID'] . '" target="_blank" style="margin:2%"><div class="card2" style="height:275px">';
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
<script>


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