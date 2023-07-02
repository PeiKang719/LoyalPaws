<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LoyalPaws</title>
	<link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="UserStyle.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style type="text/css">
	html,body{
		height: auto;
	}
</style>
<body>
	<?php include 'UserHeader.php'; ?>
	

	<div class="cat-container">
		<div class="match-section" style="background-image:url('media/foot.png');background-size:auto 100%">
			<p class="learn-more-header" style="font-weight:bold;font-size: 50px;">Adoption & Purchasing</p>
		</div>
		<div class="category-container">
			<a href="User-Adoption.php"><button class="category-container-button" style="background-color:#008ae6;color: white;">Pets</button></a>
			<a href="User-Adoption-Sellers.php"><button class="category-container-button">Pet Owners</button></a>
		</div>

<div class="breed-container" style="height:auto">
			<div class="filter">
				<div class="search-breed">
                    <?php if(isset($_GET['breedID'])){ ?>
					<input type="text" name="search-breed" placeholder="Search by name" id="breed-search" list="breed-list" style="width:100%;margin: 0;border-radius: 5px 0 0 5px;" value="<?php echo $_GET['breedID'] ?>">
                <?php }else{ ?>
                    <input type="text" name="search-breed" placeholder="Search by name" id="breed-search" list="breed-list" style="width:100%;margin: 0;border-radius: 5px 0 0 5px;">
                <?php } ?> 
					<button class="search-pet-button"><span class="material-symbols-outlined" id="search-button" style="font-size:35px;vertical-align:0px">search</span></button>
		
				</div>
				<div class="row" style="justify-content: center;align-items: flex-end;">Type</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="pet[]" value="'Cat'" id="petCat" style="width: 40%;margin: 0;"></div>
					<div class="column2">Cat</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="pet[]" value="'Dog'" id="petDog" style="width: 40%;margin: 0;"></div>
					<div class="column2">Dog</div>
				</div>
				<div class="row" style="justify-content: center;align-items: flex-end;">Purpose</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="purpose[]" value="'Rehome'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Rehome</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="purpose[]" value="'Sell'" style="width: 40%;margin: 0;"></div>
					<div class="column2">Sell</div>
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
				<?php include 'Connection.php'; ?>
				<?php
				$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "SELECT count(*) as total from pet";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
	}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT * FROM (
    SELECT p.petID, p.pet_image, b.name, p.purpose, p.price, s.state, s.area, p.gender, pp.status
    FROM pet p
    JOIN breed b ON p.breedID = b.breedID
    JOIN seller s ON p.sellerID = s.sellerID
    LEFT JOIN pet_payment pp ON pp.petID = p.petID
    UNION ALL
    SELECT t.petID, t.pet_image, d.name, t.purpose, t.price, o.state, o.area, t.gender, pp.status
    FROM pet t
    JOIN breed d ON t.breedID = d.breedID
    JOIN pet_shop o ON t.shopID = o.shopID
    LEFT JOIN pet_payment pp ON pp.petID = t.petID
	) AS combined_table
	WHERE BINARY status <> 'Cancel' OR status IS NULL
	ORDER BY
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
        	if($row['status']=='Complete' || $row['status']=='complete'){
        		$imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_blank" style="margin:2%"><div class="card2" style="background-color:#d9d9d9">';
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
            if($row['purpose']=='Rehome'){
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
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_blank" style="margin:2%"><div class="card2" style="background-color:#d9d9d9">';
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
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_blank" style="margin:2%"><div class="card2">';
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
        	echo '<a href="User-Adoption.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
		    if ($i == $page) {
		        echo '<a href="User-Adoption.php?page=' . $i . '" class="page-active">' . $i . '</a>';
		    } else {
		        echo '<a href="User-Adoption.php?page=' . $i . '">' . $i . '</a>';
		    }
	}
		if($page == $total_pages){
		   
		}
		else{
		    echo '<a href="User-Adoption.php?page=' . ($page+1) . '"> &gt;</a>';
		 }
        echo '</div>';
    }?>
			</div>
		</div>
	</div>
<script type="text/javascript">

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
            url: 'User-Adoption-Get-Pet.php',
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
            url: 'User-Adoption-Get-Pet.php',
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

<?php if(isset($_GET['breedID'])){ ?>
window.onload = function() {
    var breedID = '<?php echo $_GET["breedID"]; ?>';
    if (breedID) {
      document.getElementById('search-button').click();
    }
  };
<?php } ?>

<?php if(isset($_GET['p'])){ ?>
window.onload = function() {
    var pet = '<?php echo $_GET["p"]; ?>';
    if (pet=='Dog') {
      document.getElementById('petDog').click();
    }
    else if(pet=='Cat'){
      document.getElementById('petCat').click();  
    }
  };
<?php } ?>
</script>
</body>
</html>