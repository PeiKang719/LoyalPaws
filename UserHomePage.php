
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LoyalPaws</title>
	<link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="UserStyle.css">
</head>
<style type="text/css">
 .dashboard-overlay{
 	z-index:1;width: 100%;height: 100%;display:flex;flex-direction: row;justify-content: flex-end;border-radius: 0;
 }

 .section-info{
 	display:flex;flex-direction: column;justify-content: center;align-items: center;z-index: 1;margin-left: -360px;background-color: white;height: 593px;box-shadow: -10px 0 20px -10px black;width: 900px;padding: 0 50px;
 }
 .section-title-container{
 	width: 100%;
 	display: flex;
 	flex-direction: row;
 	align-items: center;
 	justify-content: center;
 	margin: 20px 0;
 }
 .section-title{
 	font-size: 40px;
 	font-weight: bold;
 	color: #4d4d4d;
 	background-color: transparent;
 	text-align: center;
 	width: auto;
 	margin: 0 20px;
 }
 .section-hr{
 	position: relative;
 	margin-left: auto;
 	margin-right: auto;
 	border:5px solid #999999;
 	width: 30%;
 	margin:0;
 	border-radius: 3px;
 }
</style>
<body style="background-color:#f8f8f8">
	<?php include 'UserHeader.php'; ?>
<?php
include 'Connection.php';
$sql2 =
"SELECT 'rehoming' AS title, COUNT(petID) as pet FROM pet WHERE adopterID IS NULL AND availability='Y' AND purpose = 'Rehome' 
UNION ALL 
SELECT 'selling' AS title, COUNT(petID) as pet FROM pet WHERE adopterID IS NULL AND availability='Y' AND purpose = 'Sell'
UNION ALL 
SELECT 'adopted' AS title, COUNT(petID) as pet FROM pet WHERE adopterID IS NOT NULL AND availability='Y' AND purpose = 'Rehome'
 UNION ALL 
 SELECT 'purchased' AS title, COUNT(petID) as pet FROM pet WHERE adopterID IS NOT NULL AND availability='Y' AND purpose = 'Sell';"; 

$result2 = $conn->query($sql2);
$pet = array();


while ($row2 = $result2->fetch_assoc()) {
    $pet[] = $row2["pet"];
} 
?>
<?php
$sql3 =
"SELECT 'dog' AS title, COUNT(breedID) as breed FROM breed WHERE type='Dog' 
UNION ALL 
SELECT 'cat' AS title, COUNT(breedID) as breed FROM breed WHERE type='Cat' ;"; 

$result3 = $conn->query($sql3);
$breed = array();


while ($row3 = $result3->fetch_assoc()) {
    $breed[] = $row3["breed"];
} 
?>
<?php
$sql4 =
"SELECT 'clinic' AS title, COUNT(DISTINCT c.clinicID) as c FROM clinic c,vet v WHERE v.ic NOT LIKE 'B%' AND v.ic NOT LIKE 'P%' AND v.ic NOT LIKE 'F%' AND ic NOT LIKE 'C%' UNION ALL SELECT 'vet' AS title, COUNT(vetID) as c FROM vet WHERE ic NOT LIKE 'B%' AND ic NOT LIKE 'P%' AND ic NOT LIKE 'F%' AND ic NOT LIKE 'C%';  ;"; 

$result4 = $conn->query($sql4);
$c = array();


while ($row4 = $result4->fetch_assoc()) {
    $c[] = $row4["c"];
} 
?>
<?php
$sql5 =
"SELECT COUNT(*) AS onumber FROM organization;"; 

$result5 = $conn->query($sql5);
$row5 = $result5->fetch_assoc();
?>

<div class="home">
	<section class="s0" style="background-image:url('media/homepage.jpg');background-size: 100% 100%;box-shadow: 0px 8px 18px 0 rgba(0,0,0,0.3);">



<div class="dashboard-overlay" style="display: flex;flex-direction: row;width: 100%;height: 100%;border-radius: 0;">	
	<div class="centered">Welcome to Loyal Paws</div>
	<div class="find-a-pet-container">
		<h1>Find A Pet</h1>
		<div class="find-a-pet-container-row">
			<a href="User-Adoption.php?p=Cat" class="find-a-pet-button"><img src="media/cc.png"> Cat </a>
			<a href="User-Adoption.php?p=Dog" class="find-a-pet-button"><img src="media/dd.png"> Dog </a>
		</div>
	</div>
</div>
</section>
<br>
<section class="s1" style="position: relative;padding-bottom: 50px;">

<br><br>
	<h1>Discover a Hassle-free Way to Rehome, Adopt, and Support Pets with Loyal Paws Website</h1>
	<p style="text-align: center;margin-top: 30px;">Loyal Paws is a user-friendly website that provides a platform for pet owners to rehome their pets and for potential
	adopters to find their perfect match. It also features a directory of veterinary clinics that offer discounted 
	rates for pet treatment, and a matching service for adopters looking for specific breeds. Users can also make 
	donations to support animal welfare organizations and initiatives. </p><br>
	<p style="text-align: center;">With its range of services and features, Loyal Paws is a one-stop-shop for pet-related needs, making pet 
	ownership and rehoming a hassle-free experience.</p>
</section>

<div class="section-title-container">
<hr class="section-hr">
<p class="section-title">Adoption & Purchasing </p>
<hr class="section-hr">
</div>

<section class="s2" style=" padding: 0;width: 100%;background-image: url('media/section-first.jpg');background-position: 140% 50%;">
	<div class="dashboard-overlay" >
	<div class="section-info">
		<div style="width: 100%;display: flex;flex-direction: row;align-items: center;justify-content: space-evenly;">
			<div class="home-section-data-container-column">
			<div class="home-section-data-container">
				<img src="media/section-rehome.png" width="90px" height="90px">
			</div>
			<p><b><?php echo $pet[0] ?></b> Rehoming</p>
		</div>
		<div class="home-section-data-container-column">
			<div class="home-section-data-container">
				<img src="media/section-adopt.png" width="90px" height="90px">
			</div>
			<p><b><?php echo $pet[2] ?></b> Adopted</p>
		</div>
			<div class="home-section-data-container-column">
			<div class="home-section-data-container">
				<img src="media/section-sell.png" width="90px" height="90px">
			</div>
			<p><b><?php echo $pet[1] ?></b> Selling</p>
		</div>
			<div class="home-section-data-container-column">
			<div class="home-section-data-container">
				<img src="media/section-purchase.png" width="90px" height="90px">
			</div>
			<p><b><?php echo $pet[3] ?></b> Purchased</p>
		</div>
		</div>
		<br><br><br>
		<p style="text-align: center;">Find your perfect pet companion in our Adoption/Purchase Section. Choose from a variety of rehomed and sale pets, ready to bring joy to your home. Start your search today and give a deserving pet a forever home.</p>
		<br>
	<a href="User-Adoption.php" class="homepage-section-button"><button >Explore More</button></a>
</div>
</div>
</section>

<br><br><br><br><br>
<div class="section-title-container">
<hr class="section-hr" style="width:35%">
<p class="section-title">Breed Matching</p>
<hr class="section-hr" style="width:35%">
</div>

<section class="s2" style=" padding: 0;width: 100%;background-image: url('media/section-second.jpg');background-position: 125% 50%;background-size: auto 100%;">
	<div class="dashboard-overlay" style="justify-content:flex-start">
	<div class="section-info" style="margin-left:0;box-shadow: 10px 0 20px -10px black;">
		<div style="width: 100%;display: flex;flex-direction: row;align-items: center;justify-content: space-evenly;">
			<div class="home-section-data-container-column">
			<div class="home-section-data-container">
				<img src="media/section-dog-breed.png" width="90px" height="90px">
			</div>
			<p><b><?php echo $breed[0] ?></b> Dog Breeds</p>
		</div>
			<div class="home-section-data-container-column">
			<div class="home-section-data-container">
				<img src="media/section-cat-breed.png" width="100px" height="100px">
			</div>
			<p><b><?php echo $breed[1] ?></b> Cat Breeds</p>
		</div>
		</div>
		<br><br>
		<p style="text-align: center;">Discover your perfect furry friend with our Breed Match Function. Explore cat and dog breeds, answer questions, and find an ideal companion that aligns with your lifestyle. Experience the joy of a harmonious pet-owner relationship.</p>
		<br>
		<div style="display: flex;flex-direction: row;justify-content: center;align-items: center;width: 100%;">
			<a href='Dog-Breed.php' class="homepage-section-button" style="width:33%;margin: 0 4%;"><button>Dog Breed</button></a>
			<a href='Cat-Breed.php' class="homepage-section-button" style="width:33%;margin: 0 4%;"><button>Cat Breed</button></a>
</div>
</div>
</div>
</section>

<br><br><br><br><br>
<div class="section-title-container">
<hr class="section-hr" style="width:34.5%">
<p class="section-title">Veterinary Clinic</p>
<hr class="section-hr" style="width:34.5%">
</div>

<section class="s2" style=" padding: 0;width: 100%;background-image: url('media/section-third.jpg');background-size: auto 100%;background-position: -30% 0;">
	<div class="dashboard-overlay" >
	<div class="section-info">
		<div style="width: 100%;display: flex;flex-direction: row;align-items: center;justify-content: space-evenly;">
			<div class="home-section-data-container-column">
			<div class="home-section-data-container">
				<img src="media/section-clinic.png" width="90px" height="90px">
			</div>
			<p><b><?php echo $c[0] ?></b> Clinics</p>
		</div>
			<div class="home-section-data-container-column">
			<div class="home-section-data-container">
				<img src="media/section-vet.png" width="90px" height="90px">
			</div>
			<p><b><?php echo $c[1] ?></b> Veterinarians</p>
		</div>
		</div>
		<br><br>
		<p style="text-align: center;">Join our website to access convenient appointment booking and veterinary services. As a special benefit, exclusive discounts are offered to adopters who find their furry companions through our platform. Register now and give your pet the care they deserve while enjoying exclusive perks.</p>
		<br>
	<a href="User-Clinic.php" class="homepage-section-button"><button >Explore More</button></a>
</div>
</div>
</section>

<br><br><br><br><br>
<div class="section-title-container">
<hr class="section-hr" style="width:32%">
<p class="section-title">Donation Guidelines</p>
<hr class="section-hr" style="width:32%">
</div>

<section class="s2" style=" padding: 0;width: 100%;background-image: url('media/dashboard-organization.jpg');background-size: auto 100%;background-position: -110% 0;">
	<div class="dashboard-overlay" style="justify-content:flex-start">
	<div class="section-info" style="margin-left:0;box-shadow: 10px 0 20px -10px black;">
		<div style="width: 100%;display: flex;flex-direction: row;align-items: center;justify-content: space-evenly;">
			<div class="home-section-data-container-column">
			<div class="home-section-data-container">
				<img src="media/section-organization.png" width="100px" height="100px">
			</div>
			<p style="text-align:center"><b><?php echo $row5['onumber'] ?></b> <br>Internationally Recognized Organizations</p>
		</div>
		</div>
		<br><br>
		<p style="text-align: center;">Explore our donation guidelines for Conservation Efforts and Animal Rescue & Adoption. Make a lasting impact on wildlife and care for animals in need. Donate now and be a force for positive change.</p>
		<br>
		<a href="User-Donation.php" class="homepage-section-button"><button >Explore More</button></a>
</div>
</div>
</div>
</section>


</div>
<br><br><br><br><br><br><br>
<script>

</script>
</body>

</html>
