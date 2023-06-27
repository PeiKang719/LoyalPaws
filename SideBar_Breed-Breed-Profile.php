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
<link rel="stylesheet" type="text/css" href="AdminStyle.css">
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
$breedID = $_GET['id'];

include('Connection.php');

// sql to delete a record
$sql = "SELECT * FROM breed WHERE breedID = $breedID"; 

$result = $conn->query($sql);

$row = $result->fetch_assoc();
$imageData = base64_encode($row['breed_image']);
$imageSrc = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if (file_exists('breed_images/' . $row['breed_image'])) {
    $imageSrc = 'breed_images/' . $row['breed_image'];
}
?>

<section>
<img src="media/ttg.jpeg"  style="width: 100%;height: 500px;">
<div style="padding-left: 50px;">
	<img class="organization-image" src="<?php echo $imageSrc ?>" alt="Avatar">
	<p class="organization-name"> <?php  echo $row["name"] ?> </p>
	<button class="button-adoptable-pet" style="margin-left:-230px;margin-top: 20px;"><span class="material-symbols-outlined" style="font-size:35px;vertical-align: -8px;color:white;">filter_list</span>View Adoptable Pets</button>
</div>

</section>
<br><br><br><br><br><br><br>

<section class="s2">
	 <p class="head">Characteristics:</p>
	 <br>
	<table class="breed-characteristic-table">
		<tr>
			<td ><p>Kid-Friendly</p></td>
			<td>:</td>
			<td>
		<?php for ($x = 1; $x <= 5; $x++) {
				if($x <= $row["kid_friendly"]) { ?>
				<i class="material-icons" id="breed-characteristic-star">star</i>
				<?php }
				else{?>
					<i class="material-icons" id="breed-characteristic-star">star_border</i>
				<?php }
			}?>

			</td>
			<td width="100px"></td>
			<td><p>Pet-Friendly</p></td>
			<td>:</td>
			<td>
		<?php for ($x = 1; $x <= 5; $x++) {
				if($x <= $row["pet_friendly"]) { ?>
				<i class="material-icons" id="breed-characteristic-star">star</i>
				<?php }
				else{?>
					<i class="material-icons" id="breed-characteristic-star">star_border</i>
				<?php }
			}?>
			</td>
		</tr>
		<tr>
			<td><p>Stranger-Friendly</p> </td>
			<td>:</td>
			<td>
		<?php for ($x = 1; $x <= 5; $x++) {
				if($x <= $row["stranger_friendly"]) { ?>
				<i class="material-icons" id="breed-characteristic-star">star</i>
				<?php }
				else{?>
					<i class="material-icons" id="breed-characteristic-star">star_border</i>
				<?php }
			}?>
			</td>
			<td width="100px"></td>
			<td><p>Intelligence</p></td>
			<td>:</td>
			<td>
		<?php for ($x = 1; $x <= 5; $x++) {
				if($x <= $row["intelligence"]) { ?>
				<i class="material-icons" id="breed-characteristic-star">star</i>
				<?php }
				else{?>
					<i class="material-icons" id="breed-characteristic-star">star_border</i>
				<?php }
			}?>
			</td>
		</tr>
		<tr>
			<td><p>Grooming Requirements</p> </td>
			<td>:</td>
			<td>
		<?php for ($x = 1; $x <= 5; $x++) {
				if($x <= $row["grooming"]) { ?>
				<i class="material-icons" id="breed-characteristic-star">star</i>
				<?php }
				else{?>
					<i class="material-icons" id="breed-characteristic-star">star_border</i>
				<?php }
			}?>
			</td>
			<td width="100px"></td>
			<td><p>Playfulness</p></td>
			<td>:</td>
			<td>
		<?php for ($x = 1; $x <= 5; $x++) {
				if($x <= $row["playfulness"]) { ?>
				<i class="material-icons" id="breed-characteristic-star">star</i>
				<?php }
				else{?>
					<i class="material-icons" id="breed-characteristic-star">star_border</i>
				<?php }
			}?>
			</td>
		</tr>
		<tr>
			<td><p>Amount of Shedding</p> </td>
			<td>:</td>
			<td>
		<?php for ($x = 1; $x <= 5; $x++) {
				if($x <= $row["shedding"]) { ?>
				<i class="material-icons" id="breed-characteristic-star">star</i>
				<?php }
				else{?>
					<i class="material-icons" id="breed-characteristic-star">star_border</i>
				<?php }
			}?>
			</td>
			<td width="100px"></td>
			<td><p>Energy Level</p></td>
			<td>:</td>
			<td>
		<?php for ($x = 1; $x <= 5; $x++) {
				if($x <= $row["energy_level"]) { ?>
				<i class="material-icons" id="breed-characteristic-star">star</i>
				<?php }
				else{?>
					<i class="material-icons" id="breed-characteristic-star">star_border</i>
				<?php }
			}?>
			</td>
		</tr>
		<tr>
			<td><p>Affection Towards Owners</p></td>
			<td>:</td>
			<td>
		<?php for ($x = 1; $x <= 5; $x++) {
				if($x <= $row["affection"]) { ?>
				<i class="material-icons" id="breed-characteristic-star">star</i>
				<?php }
				else{?>
					<i class="material-icons" id="breed-characteristic-star">star_border</i>
				<?php }
			}?>
			</td>
			<td width="100px"></td>
			<td><p>Vocality</p></td>
			<td>:</td>
			<td>
		<?php for ($x = 1; $x <= 5; $x++) {
				if($x <= $row["vocality"]) { ?>
				<i class="material-icons" id="breed-characteristic-star">star</i>
				<?php }
				else{?>
					<i class="material-icons" id="breed-characteristic-star">star_border</i>
				<?php }
			}?>
			</td>
		</tr>
	</table>
	<small>*This disclaimer emphasizes that pets are individuals, and while breed characteristics may be useful, they may not apply to every pet. It advises consulting the adoption organization and spending time with the pet before adoption.*</small>
</section>
<br><br>
<p class="head" style="margin-left:42px">About the breed:</p>
<br>
<section class="s3">
	<p style="white-space: pre-line;word-wrap: break-word;"><?php  echo $row["description"] ?></p>
</section>
<br><br><br>
<section class="s2" >
	<p class="head" >Vital Stat:</p>
	<table style="margin-left: 20px;">
		<tr>
			<td rowspan="2" class="breed-stat-icon-in-table"><img class="breed-stat-icon" src="media/origin1.png" alt="Avatar"></td>
			<td width="200px" height="65px" valign="bottom"><b>Origin</b></td>
			<td rowspan="2" class="breed-stat-icon-in-table"><img class="breed-stat-icon" src="media/life1.png" alt="Avatar"></td>
			<td width="200px" valign="bottom"><b>Life Span</b></td>
			<td rowspan="2" class="breed-stat-icon-in-table"><img class="breed-stat-icon" src="media/length1.png" alt="Avatar"></td>
			<td width="200px" valign="bottom"><b>Length</b></td>
			<td rowspan="2" class="breed-stat-icon-in-table"><img class="breed-stat-icon" src="media/weight1.png" alt="Avatar"></td>
			<td width="200px" valign="bottom"><b>Weight</b></td>
		</tr>
		<tr>
			<td valign="top"><?php  echo $row["origin"] ?></td>
			<td valign="top"><?php  echo $row["life_span"] ?> years</td>
			<td valign="top"><?php  echo $row["length"] ?> cm</td>
			<td valign="top"><?php  echo $row["weight"] ?> kg</td>

		</tr>
	</table>	
</section>

<script>

</script>
</body>

</html>
