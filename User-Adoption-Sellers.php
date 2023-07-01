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
			<a href="User-Adoption.php"><button class="category-container-button">Pets</button></a>
			<a href="User-Adoption-Sellers.php"><button class="category-container-button" style="background-color:#008ae6;color: white;">Seller</button></a>
		</div>

<div class="breed-container" style="height:auto">
			<div class="filter">
				<div class="search-breed">
					<input type="text" name="search-breed" placeholder="Search by name" id="breed-search" list="breed-list" style="width:100%;margin: 0;border-radius: 5px 0 0 5px;">
					<button class="search-pet-button"><span class="material-symbols-outlined" id="search-button" style="font-size:35px;vertical-align:0px">search</span></button>
				</div>
				<div class="row" style="justify-content: center;align-items: flex-end;">Type</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="type[]" value="seller" style="width: 40%;margin: 0;"></div>
					<div class="column2">Individual</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="type[]" value="pet_shop" style="width: 40%;margin: 0;"></div>
					<div class="column2">Pet Shop</div>
				</div>
				<div class="row" style="justify-content: center;align-items: flex-end;">State</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Selangor" style="width: 40%;margin: 0;"></div>
					<div class="column22">Selangor</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Kuala Lumpur" style="width: 40%;margin: 0;"></div>
					<div class="column22">Kuala Lumpur</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Johor" style="width: 40%;margin: 0;"></div>
					<div class="column22">Johor</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Penang" style="width: 40%;margin: 0;"></div>
					<div class="column22">Penang</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Perak" style="width: 40%;margin: 0;"></div>
					<div class="column22">Perak</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Pahang" style="width: 40%;margin: 0;"></div>
					<div class="column22">Pahang</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Kedah" style="width: 40%;margin: 0;"></div>
					<div class="column22">Kedah</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Kelantan" style="width: 40%;margin: 0;"></div>
					<div class="column22">Kelantan</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Negeri Sembilan" style="width: 40%;margin: 0;"></div>
					<div class="column22">Negeri Sembilan</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Melaka" style="width: 40%;margin: 0;"></div>
					<div class="column22">Melaka</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Terengganu" style="width: 40%;margin: 0;"></div>
					<div class="column22">Terengganu</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Sabah" style="width: 40%;margin: 0;"></div>
					<div class="column22">Sabah</div>
				</div>
				<div class="row2">
					<div class="column11"><input type="checkbox" name="area[]" value="Sarawak" style="width: 40%;margin: 0;"></div>
					<div class="column22">Sarawak</div>
				</div>
			</div>
			<div class="breed-card" id="breed-card-container">
				<?php include 'Connection.php'; ?>
				<?php
				$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "select count(*) as total from(SELECT shopID,null as sellerID from pet_shop union all select null as shopID,sellerID from seller) as combined_table;";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT * from (SELECT h.shopID,h.shopname as name,h.shop_image as image,h.state,h.area,null as sellerID,count(t.petID) as number FROM pet_shop h LEFT JOIN pet t ON h.shopID = t.shopID GROUP BY h.shopID, name, image, state, area, sellerID UNION ALL SELECT null as shopID,CONCAT(s.firstName, ' ' ,s.lastName) AS name,s.image,s.state,s.area,s.sellerID,count(p.petID) as number from seller s LEFT JOIN pet p ON p.sellerID=s.sellerID GROUP BY shopID,name,image,state,area,sellerID) as combined_table order by name LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    	echo '<div style="width:100%;height:20px">';
    	echo $total_records. " sellers";
    	echo '</div>';
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if($row['image']==NULL){
            	$imageSrc = 'media/shop-image.jpg';
            }
            elseif (file_exists('pet_shop_images/' . $row['image'])) {
                $imageSrc = 'pet_shop_images/' . $row['image'];
            }
            elseif(file_exists('seller_images/' . $row['image'])) {
                $imageSrc = 'seller_images/' . $row['image'];
            }
            
            if($row['shopID']!==NULL){
            echo '<a href="Seller-Profile.php?s=pet&&sid=' . $row['shopID'] . '" target="_blank" style="margin:2%"><div class="card2">';
        	}
        	else if($row['sellerID']!==NULL){
        	echo '<a href="Seller-Profile.php?s=pet&&iid=' . $row['sellerID'] . '" target="_blank" style="margin:2%"><div class="card2">';
        	}
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['shopID']!==NULL){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:red;font-weight: 800;">storefront</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            else if($row['sellerID']!==NULL){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -6px; color: #33cc00; font-weight: 800;">person</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-4px;color:#c68c53">pets</span> '. $row['number'] . ' pets</p>';
            echo '</div>';
            echo '<div class="view-breed3">';
            echo '<p>View </p>';
            echo '</div>';
            echo '</div></a>';
        }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
        	
        }
        else{
        	echo '<a href="User-Adoption-Sellers.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
		    if ($i == $page) {
		        echo '<a href="User-Adoption-Sellers.php?page=' . $i . '" class="page-active">' . $i . '</a>';
		    } else {
		        echo '<a href="User-Adoption-Sellers.php?page=' . $i . '">' . $i . '</a>';
		    }
	}
		if($page == $total_pages){
		   
		}
		else{
		    echo '<a href="User-Adoption-Sellers.php?page=' . ($page+1) . '"> &gt;</a>';
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
        var type = $('input[name="type[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var area = $('input[name="area[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var searchQuery = $('#breed-search').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'User-Adoption-Get-Sellers.php',
            type: 'GET',
            data: { type: type, area: area, searchQuery: searchQuery },
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
        var type = $('input[name="type[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var area = $('input[name="area[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var searchQuery = $('#breed-search').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'User-Adoption-Get-Sellers.php',
            type: 'GET',
            data: { type: type,area: area, searchQuery: searchQuery },
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

</script>
</body>
</html>