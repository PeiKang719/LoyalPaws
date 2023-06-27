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
			<p class="learn-more-header">Match Your Ideal Breed!</p>
			<a href='Pet_Matching.php' class="learn-more-button">Learn More</a>
		</div>
		<div class="breed-container">
			<div class="filter">
				<div class="search-breed">
					<input type="text" name="search-breed" placeholder="Search" id="breed-search" list="breed-list" style="width:100%;margin: 0;">
					<span class="material-symbols-outlined" style="font-size:35px;vertical-align:10px">search</span>
						<datalist id="breed-list">
						  <?php
						  // Connect to the database
						  include('Connection.php');

						  // Fetch breed names from the database
						  $sql = "SELECT breedID,name FROM breed WHERE type='Dog' ORDER BY name";
						  $result = mysqli_query($conn, $sql);

						  // Loop through the results and populate the datalist options
						  while ($row = mysqli_fetch_assoc($result)) {
						    // Check if breedID exists before adding it as a data attribute
						    $breedID = isset($row['breedID']) ? 'data-breedid="' . $row['breedID'] . '"' : '';
						    echo '<option value="' . $row['name'] . '" ' . $breedID . '>' . $row['name'] . '</option>';
						  }

						  // Close the database connection
						  mysqli_close($conn);
						  ?>
						</datalist>
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
    $count = "SELECT count(*) as total from breed where type='Dog'";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT * FROM breed WHERE type='Dog' ORDER BY name LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    	echo '<div style="width:100%;height:20px">';
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
            echo '<a href="SideBar_Breed-Breed-Profile.php?id=' . $row['breedID'] . '" target="_blank"><p>Learn More <span class="material-symbols-outlined" style="vertical-align:-5px">open_in_new</span></p></a>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
        	
        }
        else{
        	echo '<a href="Dog-breed.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
		    if ($i == $page) {
		        echo '<a href="Dog-breed.php?page=' . $i . '" class="page-active">' . $i . '</a>';
		    } else {
		        echo '<a href="Dog-breed.php?page=' . $i . '">' . $i . '</a>';
		    }
	}
		if($page == $total_pages){
		   
		}
		else{
		    echo '<a href="Dog-breed.php?page=' . ($page+1) . '"> &gt;</a>';
		 }
        echo '</div>';
    }?>
			</div>
		</div>
	</div>
<script type="text/javascript">
var breedInput = document.getElementById('breed-search');
var breedList = document.getElementById('breed-list');

breedInput.addEventListener('change', function() {
  // Get the selected option
  var selectedOption = breedList.querySelector('option[value="' + breedInput.value + '"]');
  
  // Check if an option was selected
  if (selectedOption !== null) {
    // Redirect to the breed profile page with the selected breedID
    var breedID = selectedOption.getAttribute('data-breedid');
    window.open('SideBar_Breed-Breed-Profile.php?id=' + breedID, '_blank');
    breedInput.value = "";
  }
});

$(document).ready(function() {
	// Listen for changes to the checkboxes
	$('input[type="checkbox"]').change(function() {
		// Get the values of the checked checkboxes
		var size = $('input[name="size[]"]:checked').map(function() {
			return this.value;
		}).get().join(',');

		// Make an AJAX request to the server to get the updated breed cards
		$.ajax({
			url: 'Dog-breed-Get-Breed.php',
			type: 'GET',
			data: { size: size },
			success: function(response) {
				// Update the breed cards with the new HTML
				$('#breed-card-container').html(response);
			},
			error: function() {
				alert('Error getting breed cards.');
			}
		});
	});
});

</script>
</body>
</html>