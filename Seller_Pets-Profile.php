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
<link rel="stylesheet" type="text/css" href="SellerStyle.css">
<style type="text/css">
	body{
		overflow-x: hidden;
	}
</style>
</head>
<body>


<?php 
session_start();
if(isset($_SESSION['adopterID'])){
include 'UserHeader.php';
}
elseif(isset($_SESSION['sellerID'])){
include 'SellerHeader.php';
}
elseif(isset($_SESSION['shopID'])){
include 'SellerHeader.php';
}
elseif(isset($_SESSION['adminID'])){
include 'AdminHeader.php';
} ?>
<?php
$petID = $_GET['id'];

include('Connection.php');

// sql to delete a record
$sql = "SELECT p.petID, p.type, p.gender, p.birthday, p.color, p.purpose, p.description, p.video, p.pet_image, p.img1, p.img2, p.img3, p.img4, p.img5, p.img6, p.vaccinated, p.spayed, p.price, p.breedID,p.return_date, b.name, m.status
	FROM pet p
	JOIN breed b ON p.breedID = b.breedID
	LEFT JOIN pet_payment m ON m.petID = p.petID
	WHERE p.petID = $petID ORDER BY
    CASE
        WHEN status = 'Complete' THEN 0
        WHEN status = 'Free' THEN 1
        WHEN status = 'Payment' THEN 2
        WHEN status = 'Fail' THEN 3
        WHEN status = 'Decision' THEN 4
        WHEN status = 'Appointment' THEN 5
        WHEN status = 'Booked' THEN 6
        ELSE 7
    END,
    petID DESC"; 

$sql2 ="SELECT sellerID,shopID from pet where petID = $petID ";

$result = $conn->query($sql);
$result2 = $conn->query($sql2);

$row = $result->fetch_assoc();
$row2 = $result2->fetch_assoc();

$imageData = base64_encode($row['pet_image']);
$imageSrc2 = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if (file_exists('pet_images/' . $row['pet_image'])) {
    $imageSrc2 = 'pet_images/' . $row['pet_image'];
}

$videoData = base64_encode($row['video']);
  $videoSrc = "data:video/mp4;base64," . $videoData;
  if (file_exists('pet_videos/' . $row['video'])) {
    $videoSrc = 'pet_videos/' . $row['video'];
   }


 if ($row2['sellerID'] !== NULL) {
 	$url_parameter='iid';
    $sql3 = "SELECT sellerID AS id,address, area, state,image,CONCAT(firstName,' ',lastName) AS sname FROM seller WHERE sellerID = " . $row2['sellerID'];
    $result3 = $conn->query($sql3);
 	$row3 = $result3->fetch_assoc();


    $imageData6 = base64_encode($row3['image']);
	$imageSrc6 = "data:image/jpg;base64," . $imageData6;
	// Check if the image file exists before displaying it
	if($row3['image']==NULL){
		$imageSrc6 = 'media/shop-image.jpg';
	}
	elseif (file_exists('seller_images/' . $row3['image'])) {
	    $imageSrc6 = 'seller_images/' . $row3['image'];
}
}
 elseif($row2['shopID']!==NULL){
 	$url_parameter='sid';
 	$sql3 ="SELECT shopID AS id,address,area,state,shop_image AS image,shopname AS sname from pet_shop where shopID = " . $row2['shopID'];
 	$result3 = $conn->query($sql3);
 	$row3 = $result3->fetch_assoc();

    $imageData6 = base64_encode($row3['image']);
	$imageSrc6 = "data:image/jpg;base64," . $imageData6;
	// Check if the image file exists before displaying it
	if($row3['image']==NULL){
		$imageSrc6 = 'media/shop-image.jpg';
	}
	elseif (file_exists('pet_shop_images/' . $row3['image'])) {
	    $imageSrc6 = 'pet_shop_images/' . $row3['image'];
}
 }

 
?>

<section style="box-shadow: 0 0px 5px 2px rgba(0,0,0,0.2);height: 470px;">
	<div class="slideshow-container">
<?php
for ($i = 1; $i <= 6; $i++) {
    // Check if the image file exists
    if (isset($row['img' . $i]) && file_exists('pet_images/' . $row['img' . $i])) {
        $imageSrc = 'pet_images/' . $row['img' . $i];
?>
		<input type="hidden" name="haveImage" id="haveImage" value="1">
        <div class="mySlides fade">
            
            <img src="<?php echo $imageSrc; ?>" style="width:auto;height:400px;margin-left: auto;margin-right: auto;display: flex;max-width: 1000px;">
        </div>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  		<a class="next" onclick="plusSlides(1)">&#10095;</a>
<?php
    }
    else{?>
    	<input type="hidden" name="haveImage" id="haveImage" value="0">
        <div style="display:none">
            
            <img src="" style="width:auto;height:400px;margin-left: auto;margin-right: auto;display: flex;">
        </div>
    <?php
    }
}
 if (isset($row['video']) && file_exists('pet_videos/' . $row['video'])) {?>
 		<input type="hidden" name="haveImage" id="haveVideo" value="1">
        <div class="mySlides fade">
            <video controls loop style="width:auto;height:400px;margin-left: auto;margin-right: auto;display: flex;max-width: 1000px;">
                <source src="<?php echo $videoSrc; ?>" type="video/mp4" >
            </video>
        </div>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  		<a class="next" onclick="plusSlides(1)">&#10095;</a>
    <?php
    }
    else{?>
    	<input type="hidden" name="haveImage" id="haveVideo" value="0">
        <div style="display:none">
            <video controls loop style="width:auto;height:400px;margin-left: auto;margin-right: auto;display: flex;">
                <source src="" type="video/mp4" >
            </video>
        </div>
    <?php
    }
    ?>
  <!-- Next and previous buttons -->
  
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
<?php
for ($i = 1; $i <= 6; $i++) {
	if (isset($row['img' . $i]) && file_exists('pet_images/' . $row['img' . $i])) { 
  		echo "<span class='dot' onclick='currentSlide($i)'></span>";
   }}
   if (isset($row['video']) && file_exists('pet_videos/' . $row['video'])) {
   		echo "<span class='dot' onclick='currentSlide($i)'></span>";
   	}?> 
</div>

</div>
<div style="padding-left: 50px;">
	<img class="pet-image" src="<?php echo $imageSrc2 ?>" alt="Avatar">
	<p class="pet-name"> <?php  echo $row["name"] ?> </p>
	
</div>

</section>
<br>
<br><br>
<br>
<section class="s2" style="margin-top: 50px;">
	<table border="0" style="width: 90%;" class="pet-info">
		<tr >
			<td>Gender</td>
			<td>:</td>
			<td width="30%"><?php  echo $row["gender"] ?></td>
			<td width="10%"></td>
			<td>Color</td>
			<td>:</td>
			<td width="30%"><?php  echo $row["color"] ?></td>
		</tr>
		<tr>
			<td>Spayed</td>
			<td>:</td>
			<td><?php  echo $row["spayed"] ?></td>
			<td width="30%"></td>
			<td>Vaccinated</td>
			<td>:</td>
			<td><?php  echo $row["vaccinated"] ?></td>
		</tr>
		<tr>
			<td>Birthday</td>
			<td>:</td>
			<td><?php  echo $row["birthday"] ?></td>
			<td width="30%"></td>
			<td>Price</td>
			<td>:</td>
			<td>RM <?php  echo $row["price"] ?></td>
		</tr>
		<tr>
			<td>Purpose</td>
			<td>:</td>
			<td><?php  echo $row["purpose"] ?></td>
			<td width="30%"></td>
			<?php 
			if($row["purpose"]=='Rehome'){ ?>
			<td style="font-size: 31px;">Return Date</td>
			<td>:</td>
			<?php if($row['return_date']!=NULL AND $row['return_date']!='0000-00-00'){?>
				<td style="font-size: 31px;"><?php echo $row['return_date'] ?></td>
			<?php }else{ ?>
				<td> - </td>
			<?php } ?>
		<?php }else{ ?>
			<td colspan="3"></td>
		<?php } ?>
		</tr>
	</table>
	<br><br>
	<p class="pet-info" style="font-weight: 600;">About the pet: </p>
	<br>
	<section class="s3">
		<p style="white-space: pre-line;word-wrap: break-word;"><?php  echo $row["description"] ?></p>
	</section>
	<div>
		<br><br>
		<p class="pet-info" style="font-weight: 600;">Visit the pet at: </p>
		<br>
		<p style="font-size: 35px;margin-left: 6%;"><span class="material-symbols-outlined" style="font-size:50px;vertical-align:-10px">distance</span> <?php echo $row3['address'] ?>, <?php echo $row3['area'] ?>, <?php echo $row3['state'] ?>. </p>
		<br><br>
	<?php if (!isset($_SESSION['key'])){ ?>
		<p class="pet-info" style="font-weight: 600;">Feel free to inquire: </p>
		<br><br>
		<a href="Seller-Profile.php?s=pet&<?php echo$url_parameter?>=<?php echo$row3['id']?>" class="inquire-seller-container">
			<div class="inquire-container">
				<img src="<?php echo $imageSrc6 ?>">
				<div style="display: flex;flex-direction: column;justify-content: center; width:70%">
				<p style="font-size: 30px;margin-bottom: 10px;"><b><?php echo $row3['sname'] ?></b></p>
				<p><?php echo $row3['area'] ?><span style="font-size: 20px;color:#4d4d4d;vertical-align: 2px;margin-left: 3%;margin-right: 3%">&#9679;</span><?php echo $row3['state'] ?></p>
				</div>
			</div>
			
		</a>
<?php } ?>
		<br>
	</div>
</section>
<div style="width:100%;height: 100px;padding-top: 50px;">
	<?php 
	if($row["status"]=='Booked' || $row["status"]=='Appointment' || $row["status"]=='Decision' || $row["status"]=='Payment'|| $row['status']=='appointment'|| $row['status']=='Fail' || $row['status']=='Free'|| $row['status']=='cancel'){?>
		<a href="User-Adoption-Appointment.php?id=<?php echo $petID; ?>" style="pointer-events: none"><button class='adopt-pet-button' id="adoptBtn" style="background-color: #999999;" disabled>Booked</button></a>
	<?php }
	else{
	if($row["purpose"]=='Sell' && isset($_SESSION['adopterID'])){ 
		if($row["status"]=='complete'){?>
			<a href="User-Adoption-Appointment.php?id=<?php echo $petID; ?>" style="pointer-events: none"><button class='adopt-pet-button' id="adoptBtn" style="background-color: #999999;" disabled>Sold</button></a>
		<?php }else{ ?>
		<a href="User-Adoption-Appointment.php?id=<?php echo $petID; ?>"><button class='adopt-pet-button' id="adoptBtn">I Want Adopt &gt;</button></a>
<?php }}
	elseif($row['purpose']=='Rehome' && isset($_SESSION['adopterID'])){
		if($row["status"]=='Complete'){?>
			<a href="User-Adoption-Inquiry-Form.php?id=<?php echo $petID; ?>" style="pointer-events: none"><button class='adopt-pet-button' id="adoptBtn" style="background-color: #999999;" disabled>Adopted</button></a>
		<?php }else{?>
		<a href="User-Adoption-Inquiry-Form.php?id=<?php echo $petID; ?>"><button class='adopt-pet-button' id="adoptBtn">I Want Adopt &gt;</button></a>
	<?php }}}?>
</div>


<script>
let slideIndex = 1;

if (document.getElementById("haveImage").value == 1 || document.getElementById("haveVideo").value == 1) {
  showSlides(slideIndex);
}

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active2", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active2";
}

</script>
</body>

</html>
