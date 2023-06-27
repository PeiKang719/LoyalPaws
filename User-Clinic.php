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
		<div class="match-section">
			<p class="learn-more-header">Clinic Page</p>
		</div>
		<div class="breed-container">
			<div class="filter">
				<div class="search-breed">
					<input type="text" name="search-breed" placeholder="Search" id="breed-search" list="breed-list" style="width:100%;margin: 0;border-radius: 5px 0 0 5px;">
					<button class="search-pet-button"><span class="material-symbols-outlined" id="search-button" style="font-size:35px;vertical-align:0px">search</span></button>
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
    $count = "SELECT count(*) as total from clinic";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT * FROM clinic ORDER BY name LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    	echo '<div style="width:100%;height:20px">';
    	echo $total_records. " results was found";
    	echo '</div>';
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['clinic_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if($row['clinic_image']==NULL){
            	$imageSrc = 'media/clinic-default.jpg';
            }
            elseif (file_exists('clinic_images/' . $row['clinic_image'])) {
                $imageSrc = 'clinic_images/' . $row['clinic_image'];
            }
            echo '<div class="card2" style="box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.2);">';
            echo '<img src="' . $imageSrc . '" alt="organization logo" style="width:100%;height: 154px;">';
            echo '<div class="breedName2" style="height:70px">';
            echo '<p><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
            echo '<p style="font-size:20px;"><img src="media/clinic-discount2.png" style="width:26px;height:26px;vertical-align:-7px"> <b style="color:#2eb82e">'.$row['discount_percent']. '%</b></p>';
            echo '</div>';
            echo '<div class="view-breed" style="padding:0 17px;margin-left:-16.9px;margin-top:5px">';
            echo '<a href="User-Clinic-Profile.php?cid=' . $row['clinicID'] . '" target="_blank"><p>Learn More <span class="material-symbols-outlined" style="vertical-align:-5px">open_in_new</span></p></a>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
        	
        }
        else{
        	echo '<a href="User-Clinic.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
		    if ($i == $page) {
		        echo '<a href="User-Clinic.php?page=' . $i . '" class="page-active">' . $i . '</a>';
		    } else {
		        echo '<a href="User-Clinic.php?page=' . $i . '">' . $i . '</a>';
		    }
	}
		if($page == $total_pages){
		   
		}
		else{
		    echo '<a href="User-Clinic.php?page=' . ($page+1) . '"> &gt;</a>';
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
        var area = $('input[name="area[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
       
        var searchQuery = $('#breed-search').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'User-Clinic-Get-Clinic.php',
            type: 'GET',
            data: { area:area, searchQuery: searchQuery },
            success: function(response) {
                // Update the breed cards with the new HTML
                $('#breed-card-container').html(response);
            },
            error: function() {
                alert('Error getting clinic.');
            }
        });
    });

    $('input[type="checkbox"]').change(function() {
        // Get the values of the checked checkboxes
        var area = $('input[name="area[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');

        var searchQuery = $('#breed-search').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
             url: 'User-Clinic-Get-Clinic.php',
            type: 'GET',
            data: { area:area, searchQuery: searchQuery },
            success: function(response) {
                // Update the breed cards with the new HTML
                $('#breed-card-container').html(response);
            },
            error: function() {
                alert('Error getting clinic.');
            }
        });
    });
});

</script>
</body>
</html>