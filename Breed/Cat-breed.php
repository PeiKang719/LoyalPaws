<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LoyalPaws</title>
	<link rel="icon" type="image/png" href="../media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="../User/css/UserStyle.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style type="text/css">
	html,body{
		height: auto;
	}
</style>
<body>
	<?php include '../User/UserHeader.php'; ?>
	

	<div class="cat-container">
		<div class="match-section" style="background-image:url('../media/foot.png');background-size:auto 100%">
			<p class="learn-more-header" style="font-size:50px;font-weight:bold;margin-top: -20px;">Match Your Ideal Breed!</p>
			<a href='Pet_Matching.php' class="learn-more-button">Learn More</a>
		</div>
		<div class="breed-container">
			<div class="filter">
				<div class="search-breed">
					<input type="text" name="search-breed" placeholder="Search" id="breed-search" list="breed-list" style="width:100%;margin: 0;">
					<button class="search-pet-button"><span class="material-symbols-outlined" id="search-button" style="font-size:35px;vertical-align:0px">search</span></button>
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
    $count = "SELECT count(*) as total from breed where type='Cat'";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $breed_type = 'Cat';
    $sql = "CALL GetBreedByType(?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $offset, $records_per_page,$breed_type);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
    	echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
    	echo $total_records. " results was found";
    	echo '</div>';
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['breed_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('breed_images/' . $row['breed_image'])) {
                $imageSrc = 'breed_images/' . $row['breed_image'];
            }
            echo '<div class="card2">';
            echo '<img src="' . $imageSrc . '" alt="Breed Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName2">';
            echo '<p><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            echo '<div class="view-breed">';
            echo '<a href="SideBar_Breed-Breed-Profile.php?id=' . $row['breedID'] . '" target="_self"><p>Learn More <span class="material-symbols-outlined" style="vertical-align:-5px">open_in_new</span></p></a>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
        	
        }
        else{
        	echo '<a href="Cat-breed.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
		    if ($i == $page) {
		        echo '<a href="Cat-breed.php?page=' . $i . '" class="page-active">' . $i . '</a>';
		    } else {
		        echo '<a href="Cat-breed.php?page=' . $i . '">' . $i . '</a>';
		    }
	}
		if($page == $total_pages){
		   
		}
		else{
		    echo '<a href="Cat-breed.php?page=' . ($page+1) . '"> &gt;</a>';
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
        var size = $('input[name="size[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var searchQuery = $('#breed-search').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'Cat-Breed-Get-Breed.php',
            type: 'GET',
            data: { size: size, searchQuery: searchQuery },
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
        
        var size = $('input[name="size[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var searchQuery = $('#breed-search').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'Cat-Breed-Get-Breed.php',
            type: 'GET',
            data: {  size: size, searchQuery: searchQuery },
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