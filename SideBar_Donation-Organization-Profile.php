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
if(isset($_GET['admin'])){
	include 'AdminHeader.php'; 
}else{
	include 'UserHeader.php'; 
}

?>
<?php
$oID = $_GET['id'];

include('Connection.php');

// sql to delete a record
$sql = "SELECT * FROM organization WHERE oID = $oID"; 

$result = $conn->query($sql);

$row = $result->fetch_assoc();
$imageData = base64_encode($row['logo']);
$imageSrc = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if (file_exists('organization_images/' . $row['logo'])) {
    $imageSrc = 'organization_images/' . $row['logo'];
}

$methods=explode(",",$row["payment_method"]);
?>

<section>
<img src="media/ttg.jpeg"  style="width: 100%;height: 500px;">
<div style="padding-left: 50px;">
	<img class="organization-image" src="<?php echo $imageSrc ?>" alt="Avatar">
	<p class="organization-name"> <?php  echo $row["oname"] ?> </p>
	<p class="organization-category">Category: <?php echo $row["category"] ?> </p>
</div>

</section>
<br>
<div style="width:100%;height: 100px;padding-top: 50px;">
<?php echo"
 <a href= ". $row['url'] ." target='_blank'><button class='donate-button'>I Want Donate &gt;</button></a>"; ?>
</div>
<br><br>
<section class="s3">

	<p style="white-space: pre-line;word-wrap: break-word;"><?php  echo $row["description"] ?></p>

</section>
<br><br>
<section class="s2" >
	<p class="organization-payment" style="font-weight: 600;">Payment Detail: </p>
	<br>
	<table border="0" style="display: flex;width: 100%;">
		<tr>
			<td><p class="organization-payment" >Payment Type</p></td>
			<td><p style="font-size: 40px;">:</p></td>
			<td><p class="organization-payment" ><?php  echo $row["payment_type"] ?></p></td>
		</tr>
		<tr valign="middle;">
			<td><p class="organization-payment" >Payment Methods</p></td>
			<td><p style="font-size: 40px;">:</p></td>

			<td>
				<?php $methods = explode(",", $row["payment_method"]);
      			foreach ($methods as $method) {
        			echo "<div class='methods'><img src='media/$method.png' width='100%;' height='80px;'><br><p style='font-size: 18px;'>$method</p></div>";
      			}?></p></td>
		</tr>
		<tr >
			<td><p class="organization-payment" >Minimum Donation</p></td>
			<td><p style="font-size: 40px;">:</p></td>
			<td ><p class="organization-payment" >RM <?php  echo $row["minimum"] ?></p></td>
		</tr>
	</table>	
</section>

<script>

</script>
</body>

</html>
