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
			<p class="learn-more-header" style="font-weight:bold;font-size: 50px;">Internationally Recognized Organizations</p>
		</div>
		<div class="breed-container">
			<div class="filter">
				<div class="search-breed">
					<input type="text" name="search-breed" placeholder="Search" id="breed-search" list="breed-list" style="width:100%;margin: 0;border-radius: 5px 0 0 5px;">
					<button class="search-pet-button"><span class="material-symbols-outlined" id="search-button" style="font-size:35px;vertical-align:0px">search</span></button>
				</div>

				<div class="row" style="justify-content: center;align-items: flex-end;">Category</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="category[]" value="Conservation Efforts" style="width: 40%;margin: 0;"></div>
					<div class="column2">Conservation Efforts</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="category[]" value="Animal Rescue and Adoption" style="width: 40%;margin: 0;"></div>
					<div class="column2">Animal Rescue and Adoption</div>
				</div>
				<br>
				<div class="row" style="justify-content: center;align-items: flex-end;">Payment Type</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="type[]" value="Monthly Payment" style="width: 40%;margin: 0;"></div>
					<div class="column2">Monthly Payment</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="type[]" value="One-Time Payment" style="width: 40%;margin: 0;"></div>
					<div class="column2">One-Time Payment</div>
				</div>
				<br>
				<div class="row" style="justify-content: center;align-items: flex-end;">Payment Method</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="method[]" value="Card" style="width: 40%;margin: 0;"></div>
					<div class="column2">Card</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="method[]" value="Bank" style="width: 40%;margin: 0;"></div>
					<div class="column2">Bank</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="method[]" value="Paypal" style="width: 40%;margin: 0;"></div>
					<div class="column2">Paypal</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="method[]" value="ApplePay" style="width: 40%;margin: 0;"></div>
					<div class="column2">ApplePay</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="method[]" value="GooglePay" style="width: 40%;margin: 0;"></div>
					<div class="column2">GooglePay</div>
				</div>
				<div class="row">
					<div class="column1"><input type="checkbox" name="method[]" value="Others" style="width: 40%;margin: 0;"></div>
					<div class="column2">Others</div>
				</div>
			</div>
			<div class="breed-card" id="breed-card-container">
				<?php include 'Connection.php'; ?>
				<?php
				$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "SELECT count(*) as total from organization";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT * FROM organization ORDER BY oname LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    	echo '<div style="width:100%;height:20px">';
    	echo $total_records. " results was found";
    	echo '</div>';
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['logo']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('organization_images/' . $row['logo'])) {
                $imageSrc = 'organization_images/' . $row['logo'];
            }
            echo '<div class="card2">';
            echo '<img src="' . $imageSrc . '" alt="organization logo" style="width:100%;height: 154px;">';
            echo '<div class="breedName2">';
            echo '<p><b>' . $row['oname'] . '</b></p>';
            echo '</div>';
            echo '<div class="view-breed">';
            echo '<a href="SideBar_Donation-Organization-Profile.php?id=' . $row['oID'] . '" target="_blank"><p>Learn More <span class="material-symbols-outlined" style="vertical-align:-5px">open_in_new</span></p></a>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
        	
        }
        else{
        	echo '<a href="User-Donation.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
		    if ($i == $page) {
		        echo '<a href="User-Donation.php?page=' . $i . '" class="page-active">' . $i . '</a>';
		    } else {
		        echo '<a href="User-Donation.php?page=' . $i . '">' . $i . '</a>';
		    }
	}
		if($page == $total_pages){
		   
		}
		else{
		    echo '<a href="User-Donation.php?page=' . ($page+1) . '"> &gt;</a>';
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
        var category = $('input[name="category[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var type = $('input[name="type[]"]:checked').map(function() {
            return this.value;
        }).get().join(' & ');
        var method = $('input[name="method[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var searchQuery = $('#breed-search').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'User-Donation-Get-Organization.php',
            type: 'GET',
            data: { category:category, type:type, method:method, searchQuery: searchQuery },
            success: function(response) {
                // Update the breed cards with the new HTML
                $('#breed-card-container').html(response);
            },
            error: function() {
                alert('Error getting organization.');
            }
        });
    });

    $('input[type="checkbox"]').change(function() {
        // Get the values of the checked checkboxes
        var category = $('input[name="category[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var type = $('input[name="type[]"]:checked').map(function() {
            return this.value;
        }).get().join(' & ');
        var method = $('input[name="method[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var searchQuery = $('#breed-search').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
             url: 'User-Donation-Get-Organization.php',
            type: 'GET',
            data: { category:category, type:type, method:method, searchQuery: searchQuery },
            success: function(response) {
                // Update the breed cards with the new HTML
                $('#breed-card-container').html(response);
            },
            error: function() {
                alert('Error getting organization.');
            }
        });
    });
});

</script>
</body>
</html>