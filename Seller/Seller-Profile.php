<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LoyalPaws</title>
	<link rel="icon" type="image/png" href="../media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="stylesheet" type="text/css" href="../User/css/UserStyle.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style type="text/css">
	html,body{
		width: 100%;
		height: 100%;
	}
</style>
<body>
<?php 
if(isset($_GET['admin'])){
include '../Admin/AdminHeader.php';
}else{
include '../User/UserHeader.php';
} ?>

<?php 
        if (isset($_GET['sid'])) {
            $id=$_GET['sid'];
            $sql = "SELECT * FROM pet_shop WHERE shopID = $id"; 
            showShop($sql,$id);
        }
        elseif(isset($_GET['iid'])){
            $id=$_GET['iid'];
            $sql = "SELECT * FROM seller WHERE sellerID = $id"; 
            showSeller($sql,$id);
        }



function showSeller($sql,$id){
include('../Database/Connection.php');

$result = $conn->query($sql);

$row = $result->fetch_assoc();
$sname=$row['firstName']." ".$row['lastName'];

$imageData = base64_encode($row['image']);
$imageSrc = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if($row['image']==NULL){
	$imageSrc = '../media/shop-image.jpg';
}
elseif (file_exists('seller_images/' . $row['image'])) {
    $imageSrc = 'seller_images/' . $row['image'];
}

if($row['cover']!=''){
    $imageData2 = base64_encode($row['cover']);
    $imageSrc3 = "data:image/jpg;base64," . $imageData2;
    // Check if the image file exists before displaying it
    if (file_exists('s_covers/seller/' . $row['cover'])) {
        $imageSrc3 = 's_covers/seller/' .$row['cover'];
    }
    }
    else{
        $imageSrc3='../media/clinic_cover.jpg';
    }
?>

<div class="profile-container">
	<div class="cover-picture">
		<img src="<?php echo $imageSrc3 ?>"  style="width: 100%;height: 430px;">
	</div>
	<div class="seller-image-container">
		<img class="seller-image" src="<?php echo $imageSrc ?>" alt="Avatar">
		<div class="seller-name-container">
			<div class="seller-name-row" style="align-items:flex-end;">
				<p class="seller-name"> <?php  echo $row["firstName"] ?> <?php echo $row["lastName"] ?> </p>
			</div>
			<div class="seller-name-row">
				<span class="material-symbols-outlined" style="font-size:40px;margin-right: 3%;">distance</span><p class="seller-location"> <?php echo $row["state"] ?><span style="font-size: 20px;color:#4d4d4d;vertical-align: 5px;margin-left: 3%;margin-right: 3%">&#9679;</span><?php echo $row["area"] ?> </p>
			</div>
		</div>
		<?php if(!isset($_GET['admin'])){ ?>
		<div class="seller-chat-button-container">
			<button class="seller-chat-button" onclick="openChatModal()"><span class="material-symbols-outlined" style="vertical-align:-3px;color: white;" >chat</span>Chat</button>
		</div>
	<?php } ?>
	</div>
	<?php if(isset($_GET['admin'])){ ?>
	<div class="seller-section">
		<a href="Seller-Profile.php?s=pet&iid=<?php echo $id; ?>&admin=yes" style="border-bottom: 5px solid #00a8de;"><button class="seller-section-button" >Pets</button></a>
		<a href="Seller-Profile.php?s=about&iid=<?php echo $id; ?>&admin=yes"><button class="seller-section-button">About Me</button></a>
	</div>
<?php }else{ ?>
	<div class="seller-section">
		<a href="Seller-Profile.php?s=pet&iid=<?php echo $id; ?>" style="border-bottom: 5px solid #00a8de;"><button class="seller-section-button" >Pets</button></a>
		<a href="Seller-Profile.php?s=about&iid=<?php echo $id; ?>"><button class="seller-section-button">About Me</button></a>
	</div>
<?php } ?>

        <?php 
        if (isset($_GET['s'])) {
            $s=$_GET['s'];
            if($s=='pet'){
                seller_pet();
            }
            else if($s=='about'){
                seller_about();
            }
        }
        if (!isset($_GET['s'])){
        	seller_pet();
        }
        ?>
<?php } ?>
        <?php function seller_pet(){
        $id=$_GET['iid'];  ?>
        <input type="hidden" name="iid" id="iid" value="<?php echo$id ?>" >
			<div class="breed-container" style="padding-top:0%;height:auto">
			<div class="filter">
				<div class="search-breed">
					<input type="text" name="search-breed" placeholder="Search" id="breed-search" list="breed-list" style="width:100%;margin: 0;border-radius: 5px 0 0 5px;">
					<button class="search-pet-button"><span class="material-symbols-outlined" id="search-button" style="font-size:35px;vertical-align:0px">search</span></button>
				</div>
				<div class="row" style="justify-content: center;align-items: flex-end;">Type</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="pet[]" value="'Cat'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Cat</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="pet[]" value="'Dog'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Dog</div>
				</div>
				<div class="row" style="justify-content: center;align-items: flex-end;">Purpose</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="purpose[]" value="'Rehome'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Adopt</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="purpose[]" value="'Sell'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Sell</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="purpose[]" value="'Lodging'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Lodging</div>
				</div>
				<div class="row" style="justify-content: center;align-items: flex-end;">Size</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="size[]" value="'small'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Small</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="size[]" value="'medium'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Medium</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="size[]" value="'large'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Large</div>
				</div>
			</div>
			<div class="breed-card" id="breed-card-container">
				<?php include '../Database/Connection.php'; ?>
				<?php
				$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "SELECT count(*) as total from pet where sellerID=$id AND availability='Y'";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN seller s ON p.sellerID=s.sellerID LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE p.sellerID=$id AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC
 	LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    	echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
    	echo $total_records. " pets";
    	echo '</div>';
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
        	if($row['status']=='Complete'  || $row['status']=='complete'){
        		$imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2" style="background-color:#d9d9d9">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3" style="background-color:#999999">';
            if($row['purpose']=='Rehome' || $row['purpose']=='Lodging'){
            echo '<p><b>Adopted</b></p>';
        	}
        	else{
        	echo '<p><b>Sold</b></p>';	
        	}
            echo '</div>';
            echo '</div></a>';
        	}
        	elseif($row['status']=='Payment' || $row['status']=='Decision' || $row['status']=='Booked' || $row['status']=='Appointment' || $row['status']=='Fail' || $row['status']=='Free'|| $row['status']=='appointment'|| $row['status']=='cancel'){
        		$imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2" style="background-color:#d9d9d9">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3" style="background-color:#999999">';
            echo '<p><b>Booked</b></p>';
            echo '</div>';
            echo '</div></a>';
        	}
        	else{
            $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3">';
            echo '<p>RM ' . $row['price'] . '</p>';
            echo '</div>';
            echo '</div></a>';
        }
    }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
        	
        }
        else{
        	echo '<a href="Seller-Profile.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
		    if ($i == $page) {
		        echo '<a href="Seller-Profile.php?page=' . $i . '" class="page-active">' . $i . '</a>';
		    } else {
		        echo '<a href="Seller-Profile.php?page=' . $i . '">' . $i . '</a>';
		    }
	}
		if($page == $total_pages){
		   
		}
		else{
		    echo '<a href="Seller-Profile.php?page=' . ($page+1) . '"> &gt;</a>';
		 }
        echo '</div>';
    }else{
    	echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
    	echo $total_records. " pet";
    	echo '</div>';
    }?>
			</div>
		</div>
	<?php } ?>
	<?php function seller_about(){ 
		$id=$_GET['iid'];
		include('../Database/Connection.php');

		$sql = "SELECT * FROM seller WHERE sellerID = $id"; 

		$result = $conn->query($sql);

		$row = $result->fetch_assoc();?>
		<div class="seller-profile-header">About Me:</div>
	<div class="description-container">
		<div class="seller-description">
			<p style="white-space: pre-line;word-wrap: break-word;"><?php  echo $row["description"] ?></p>
		</div>
	</div>
	<div class="seller-profile-header">My Information:</div>
	<div class="seller-info-container">
		<table border="0" style="width: 80%;padding-left: 5%;">
		<tr>
			<td><span class="material-symbols-outlined" id="seller-info-icon">call</span></td>
			<td style="width:30%"><p class="seller-info" >Contact Number</p></td>
			<td><p class="seller-info">:</p></td>
			<td colspan="4" style="width:60%"><p class="seller-info" ><?php  echo $row["phone"] ?></p></td>
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
			<?php $days = explode(",", $row["available"]);
	  			$opens = explode(",", $row["start"]);
	  			$closes = explode(",", $row["end"]);
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
	</div>
<?php } ?>
</div>

<?php
function showShop($sql,$id){
include('../Database/Connection.php');

$result = $conn->query($sql);

$row = $result->fetch_assoc();
$sname=$row['shopname'];
$imageData = base64_encode($row['shop_image']);
$imageSrc = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if($row['shop_image']==NULL){
	$imageSrc = '../media/shop-image.jpg';
}
elseif (file_exists('pet_shop_images/' . $row['shop_image'])) {
    $imageSrc = 'pet_shop_images/' . $row['shop_image'];
}

if($row['cover']!=''){
    $imageData2 = base64_encode($row['cover']);
    $imageSrc3 = "data:image/jpg;base64," . $imageData2;
    // Check if the image file exists before displaying it
    if (file_exists('s_covers/pet_shop/' . $row['cover'])) {
        $imageSrc3 = 's_covers/pet_shop/' . $row['cover'];
    }
    }
    else{
        $imageSrc3='../media/clinic_cover.jpg';
    }
?>

<div class="profile-container">
	<div class="cover-picture">
		<img src="<?php echo $imageSrc3 ?>"  style="width: 100%;height: 430px;">
	</div>
	<div class="seller-image-container">
		<img class="seller-image" src="<?php echo $imageSrc ?>" alt="Avatar">
		<div class="seller-name-container">
			<div class="seller-name-row" style="align-items:flex-end;">
				<p class="seller-name"> <?php  echo $row["shopname"] ?> </p>
			</div>
			<div class="seller-name-row">
				<span class="material-symbols-outlined" style="font-size:40px;margin-right: 3%;">distance</span><p class="seller-location"> <?php echo $row["state"] ?><span style="font-size: 20px;color:#4d4d4d;vertical-align: 5px;margin-left: 3%;margin-right: 3%">&#9679;</span><?php echo $row["area"] ?> </p>
			</div>
		</div>
		<?php if(!isset($_GET['admin'])){ ?>
		<div class="seller-chat-button-container">
			<button class="seller-chat-button" onclick="openChatModal()"><span class="material-symbols-outlined" style="vertical-align:-3px;color:white" >chat</span>Chat</button>
		</div>
	<?php } ?>
	</div>
	<?php if(isset($_GET['admin'])){ ?>
	<div class="seller-section">
		<a href="Seller-Profile.php?s=pet&sid=<?php echo $id; ?>&admin=yes" style="border-bottom: 5px solid #00a8de;"><button class="seller-section-button" >Pets</button></a>
		<a href="Seller-Profile.php?s=about&sid=<?php echo $id; ?>&admin=yes"><button class="seller-section-button">About Me</button></a>
	</div>
<?php }else{ ?>
	<div class="seller-section">
		<a href="Seller-Profile.php?s=pet&sid=<?php echo $id; ?>" style="border-bottom: 5px solid #00a8de;"><button class="seller-section-button" >Pets</button></a>
		<a href="Seller-Profile.php?s=about&sid=<?php echo $id; ?>"><button class="seller-section-button">About Me</button></a>
	</div>
<?php } ?>

        <?php 
        if (isset($_GET['s'])) {
            $s=$_GET['s'];
            if($s=='pet'){
                pet();
            }
            else if($s=='about'){
                about();
            }
        }
        elseif (!isset($_GET['s'])){
        	pet();
        }
        ?>
        <?php } ?>
        <?php function pet(){ 
        	$id=$_GET['sid'];?>
        	<input type="hidden" name="sid" id="sid" value="<?php echo$id ?>" >
			<div class="breed-container" style="padding-top:0%;height:auto">
			<div class="filter">
				<div class="search-breed">
					<input type="text" name="search-breed" placeholder="Search" id="breed-search" list="breed-list" style="width:100%;margin: 0;border-radius: 5px 0 0 5px;">
					<button class="search-pet-button"><span class="material-symbols-outlined" id="search-button" style="font-size:35px;vertical-align:0px">search</span></button>
				</div>
				<div class="row" style="justify-content: center;align-items: flex-end;">Type</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="pet[]" value="'Cat'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Cat</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="pet[]" value="'Dog'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Dog</div>
				</div>
				<div class="row" style="justify-content: center;align-items: flex-end;">Purpose</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="purpose[]" value="'Rehome'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Adopt</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="purpose[]" value="'Sell'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Sell</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="purpose[]" value="'Lodging'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Lodging</div>
				</div>
				<div class="row" style="justify-content: center;align-items: flex-end;">Size</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="size[]" value="'small'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Small</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="size[]" value="'medium'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Medium</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="size[]" value="'large'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Large</div>
				</div>
			</div>
			<div class="breed-card" id="breed-card-container">
				<?php include '../Database/Connection.php'; ?>
				<?php
				$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "SELECT count(*) as total from pet where shopID=$id AND availability='Y'";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN pet_shop s ON p.shopID=s.shopID LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE p.shopID=$id  AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC
 	LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    	echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
    	echo $total_records. " pets";
    	echo '</div>';
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
        	if($row['status']=='Complete'  || $row['status']=='complete'){
        		$imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2" style="background-color:#d9d9d9">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3" style="background-color:#999999">';
            if($row['purpose']=='Rehome'  || $row['purpose']=='Lodging'){
            echo '<p><b>Adopted</b></p>';
        	}
        	else{
        	echo '<p><b>Sold</b></p>';	
        	}
            echo '</div>';
            echo '</div></a>';
        	}
        	elseif($row['status']=='Payment' || $row['status']=='Decision' || $row['status']=='Booked' || $row['status']=='Appointment' || $row['status']=='Fail' || $row['status']=='Free'|| $row['status']=='appointment'|| $row['status']=='cancel'){
        		$imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2" style="background-color:#d9d9d9">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3" style="background-color:#999999">';
            echo '<p><b>Booked</b></p>';
            echo '</div>';
            echo '</div></a>';
        	}
        	else{
            $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3">';
            echo '<p>RM ' . $row['price'] . '</p>';
            echo '</div>';
            echo '</div></a>';
        }
    }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
        	
        }
        else{
        	echo '<a href="Seller-Profile.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
		    if ($i == $page) {
		        echo '<a href="Seller-Profile.php?page=' . $i . '" class="page-active">' . $i . '</a>';
		    } else {
		        echo '<a href="Seller-Profile.php?page=' . $i . '">' . $i . '</a>';
		    }
	}
		if($page == $total_pages){
		   
		}
		else{
		    echo '<a href="Seller-Profile.php?page=' . ($page+1) . '"> &gt;</a>';
		 }
        echo '</div>';
    }else{
    	echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
    	echo $total_records. " pets";
    	echo '</div>';
    }?>
			</div>
		</div>
	<?php } ?>
	<?php function about(){
		$id=$_GET['sid']; 
		include('../Database/Connection.php');

		$sql = "SELECT * FROM pet_shop WHERE shopID = $id"; 

		$result = $conn->query($sql);

		$row = $result->fetch_assoc();?>
		<div class="seller-profile-header">About Me:</div>
	<div class="description-container">
		<div class="seller-description">
			<p style="white-space: pre-line;word-wrap: break-word;"><?php  echo $row["description"] ?></p>
		</div>
	</div>
	<div class="seller-profile-header">My Information:</div>
	<div class="seller-info-container">
		<table border="0" style="width: 80%;padding-left: 5%;">
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


<div id="chatModal" class="chat-modal">
    <?php
    include '../Database/Connection.php';
    if (isset($_GET['sid'])) {
        $id = $_GET['sid'];
        $sql = "SELECT * FROM pet_shop WHERE shopID = $id"; 
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $sname = $row['shopname'];
        $sellerID = $row['shopID'];
        $adopterID = $_SESSION['adopterID'];
        $column=2;
        //Fixed adopterID 50 HERE

        if($row['shop_image']==NULL){
			$imageSrc = '../media/shop-image.jpg';
		}
			elseif (file_exists('pet_shop_images/' . $row['shop_image'])) {
    			$imageSrc = 'pet_shop_images/' . $row['shop_image'];
		}
    } elseif (isset($_GET['iid'])) {
        $id = $_GET['iid'];
        $sql = "SELECT * FROM seller WHERE sellerID = $id"; 
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $sname = $row['firstName']." ".$row['lastName'];
        $sellerID = $row['sellerID'];
        $adopterID = $_SESSION['adopterID'];
        $column=1;
        //Fixed adopterID 50 HERE


        if($row['image']==NULL){
			$imageSrc = '../media/shop-image.jpg';
		}
			elseif (file_exists('seller_images/' . $row['image'])) {
    			$imageSrc = 'seller_images/' . $row['image'];
		}
    }
    ?>

    <!-- Modal content -->
    <div class="chat-modal-content">
        <div class="chat-modal-header">
        	<img src="<?php echo $imageSrc ?>">
            <h2 style="color:white"><?php echo $sname ?></h2>
            <span class="close" onclick="closeChatModal()">&times;</span>
        </div>
        <div class="message-container"  id="chatbox">
  			
        </div>
        <div class="chat-button-container">
        <input type="text" id="message" placeholder="Type your message" onkeydown="handleEnter(event)">
  		<button id="send">Send  <span class="material-symbols-outlined" id="send-icon">send</span></button>
  	</div>
    </div>
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
	    var sid = null;
		var iid = null;

		if (url.includes('sid') ) {
		    sid = new URLSearchParams(url).get('sid');
		} else if (url.includes('iid')) {
		    iid = new URLSearchParams(url).get('iid');
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
	    var sid = null;
	    var iid = null;

	    if (document.getElementById('sid')) {
	        sid = document.getElementById('sid').value;
	    } else if (document.getElementById('iid')) {
	        iid = document.getElementById('iid').value;
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
  if (sValue === 'pet') {

    $('a[href*="Seller-Profile.php?s=pet"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Seller-Profile.php?s=about"]').css('border-bottom', '0');
  } else if (sValue === 'about') {
    $('a[href*="Seller-Profile.php?s=about"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Seller-Profile.php?s=pet"]').css('border-bottom', '0');
  }
  else{
  	$('a[href*="Seller-Profile.php?s=pet"]').css('border-bottom', '5px solid #00a8de');
  }
});
</script>

<?php if(!isset($_GET['admin'])){ ?>
<script>
function openChatModal() {
    var modal = document.getElementById("chatModal");
    modal.style.display = "block";
}

function closeChatModal() {
  var modal = document.getElementById("chatModal");
  
  modal.classList.add("exit-animation");
  setTimeout(function() {
    modal.style.display = "none";
    modal.classList.remove("exit-animation");
  }, 500); // Delay of 0.5 seconds (500 milliseconds)

}



    $(document).ready(function() {
      // Retrieve initial chat messages
    	var sellerID = <?php echo $sellerID; ?>;
 		 var adopterID = <?php echo $adopterID; ?>;
 		 var column = <?php echo $column; ?>; 
      retrieveMessages(sellerID, adopterID,column);

      // Send new message
      $('#send').click(function() {
        var message = $('#message').val();
        sendMessage(message, sellerID, adopterID,column);
        $('#message').val('');
        console.log(column);
        console.log(sellerID);
        console.log(adopterID);
      });
      // Poll server for new messages every 2 seconds
       setInterval(function() {
    		retrieveMessages(sellerID, adopterID,column);
  		}, 1500);
       setTimeout(scrollToBottom, 1500);
    });

    function handleEnter(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            var message = $('#message').val();
            var sellerID = <?php echo $sellerID; ?>;
   		    var adopterID = <?php echo $adopterID; ?>;
   		    var column = <?php echo $column; ?>; 
            sendMessage(message, sellerID, adopterID,column);
            $('#message').val('');       
        }

        setTimeout(scrollToBottom, 1500);
    }

    function retrieveMessages(sellerID, adopterID,column) {
      $.ajax({
        url: '../ChatFunction/chat-get-message.php',
        method: 'GET',
        data: { sellerID: sellerID, adopterID: adopterID, column:column },
    	success: function(response) {
      $('#chatbox').html(response);
        }
      });
      setTimeout(scrollToBottom, 1500);
    }

    function sendMessage(message, sellerID, adopterID,column) {
      $.ajax({
        url: '../ChatFunction/chat-user-send-message.php',
        method: 'POST',
         data: { message: message, sellerID: sellerID, adopterID: adopterID, column:column },
    	success: function(response) {
      	console.log('Message sent');
      	console.log(column);
        console.log(sellerID);
        console.log(adopterID);
        }
      });
      setTimeout(scrollToBottom, 1500);
    }

    function scrollToBottom() {
        var chatbox = document.getElementById('chatbox');
        chatbox.scrollTop = chatbox.scrollHeight;
    }

    // Scroll to bottom when the page loads
    window.onload = function() {
        scrollToBottom();
    };
</script>
<?php } ?>
</body>

</html>