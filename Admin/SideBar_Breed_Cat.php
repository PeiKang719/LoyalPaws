<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Main page</title>
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="css/AdminStyle.css">
<link rel="icon" type="image/png" href="../media/tabIcon.png">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

</head>
<body style="background-color: white;">

<?php include 'AdminHeader.php'; ?>

<section class="content" id="cat-breed">
	<div class="container">
	<button class="button1" id="button1"><i class="material-icons addIcon">add</i>Add New Cat Breed</button>
<input type="text" class="search" placeholder="Search For Cat Breed" id="breed-search" list="breed-list">
<datalist id="breed-list">
  <?php
  // Connect to the database
  include('../Database/Connection.php');

  // Fetch breed names from the database
  $sql = "SELECT breedID,name FROM breed WHERE type='Cat' ORDER BY name";
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
<?php showBreed(); ?>
</section>
	
<?php
function showBreed() {
    include('../Database/Connection.php');
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
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['breed_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('../Breed/breed_images/' . $row['breed_image'])) {
                $imageSrc = '../Breed/breed_images/' . $row['breed_image'];
            }
            echo '<div class="column">';
            echo '<div class="card">';
            echo '<img src="' . $imageSrc . '" alt="Breed Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName">';
            echo '<p><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            echo '<div class="breedIcon">';
            echo '<a href="SideBar_Breed-Breed-Profile.php?id=' . $row['breedID'] . '" target="_self"><span class="material-symbols-outlined" id="card-button">open_in_new</span></a>';
             echo '<a href="SideBar_Breed-Edit-Modal.php?id=' . $row['breedID'] . '" target="_self"><span class="material-symbols-outlined" id="card-button-edit">edit</span>';
            echo '<iframe name="hiddenFrame3" class="hide"></iframe>';
            echo '<a href="SideBar_Breed-Delete-Breed.php?id=' . $row['breedID'] . '" target="hiddenFrame3" onclick="deleteBreed(event)"><span class="material-symbols-outlined" id="card-button-delete">delete</span></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
        	
        }
        else{
        	echo '<a href="SideBar_Breed_Cat.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
		    if ($i == $page) {
		        echo '<a href="SideBar_Breed_Cat.php?page=' . $i . '" class="page-active">' . $i . '</a>';
		    } else {
		        echo '<a href="SideBar_Breed_Cat.php?page=' . $i . '">' . $i . '</a>';
		    }
	}
		if($page == $total_pages){
		   
		}
		else{
		    echo '<a href="SideBar_Breed_Cat.php?page=' . ($page+1) . '"> &gt;</a>';
		 }
        echo '</div>';
    }

$stmt->close();
$conn->close();
}



?>


<!-- #############  Add Breed  ################## -->
<div id="AddModal" class="modal">
	<!-- Modal content -->
	<div class="modal-content">
		<div class="modal-header">
      <span class="close">&times;</span>
      <h2>Add New Cat Breed</h2>
      </div>
      <iframe name="hiddenFrame" class="hide"></iframe>
		<form id="breedForm" action="SideBar_Breed-Add-Breed.php" method="post" target="hiddenFrame" enctype="multipart/form-data">

			<div class="tab">
				<input type="hidden" placeholder="Name..." name="type" value="Cat">
				<label>Cat Breed:</label>
				<input type="text" placeholder="Name..." oninput="this.className = ''" name="name" required>
				<label>Select Picture:</label>
				<input type="file" id="img" name="img" accept="image/*" required>
				<label>Description:</label>
				<textarea maxlength="800" placeholder="Write something to describe the breed...(max 800 characters)" name="description" required></textarea>
			</div>
			<div class="tab" id="secondTab">
				<h1 class="tab2head">Vital Statistics</h1>
				<label>Origin:</label><br>
				<input list="country" name="country" class="datalist-input" id="datalist" required>
			    <datalist id="country">
			        <option value="Afghanistan" />
			        <option value="Albania" />
			        <option value="Algeria" />
			        <option value="American Samoa" />
			        <option value="Andorra" />
			        <option value="Angola" />
			        <option value="Anguilla" />
			        <option value="Antarctica" />
			        <option value="Antigua and Barbuda" />
			        <option value="Argentina" />
			        <option value="Armenia" />
			        <option value="Aruba" />
			        <option value="Australia" />
			        <option value="Austria" />
			        <option value="Azerbaijan" />
			        <option value="Bahamas" />
			        <option value="Bahrain" />
			        <option value="Bangladesh" />
			        <option value="Barbados" />
			        <option value="Belarus" />
			        <option value="Belgium" />
			        <option value="Belize" />
			        <option value="Benin" />
			        <option value="Bermuda" />
			        <option value="Bhutan" />
			        <option value="Bolivia" />
			        <option value="Bosnia and Herzegovina" />
			        <option value="Botswana" />
			        <option value="Bouvet Island" />
			        <option value="Brazil" />
			        <option value="British Indian Ocean Territory" />
			        <option value="Brunei Darussalam" />
			        <option value="Bulgaria" />
			        <option value="Burkina Faso" />
			        <option value="Burundi" />
			        <option value="Cambodia" />
			        <option value="Cameroon" />
			        <option value="Canada" />
			        <option value="Cape Verde" />
			        <option value="Cayman Islands" />
			        <option value="Central African Republic" />
			        <option value="Chad" />
			        <option value="Chile" />
			        <option value="China" />
			        <option value="Christmas Island" />
			        <option value="Cocos (Keeling) Islands" />
			        <option value="Colombia" />
			        <option value="Comoros" />
			        <option value="Congo" />
			        <option value="Congo, The Democratic Republic of The" />
			        <option value="Cook Islands" />
			        <option value="Costa Rica" />
			        <option value="Cote D'ivoire" />
			        <option value="Croatia" />
			        <option value="Cuba" />
			        <option value="Cyprus" />
			        <option value="Czech Republic" />
			        <option value="Denmark" />
			        <option value="Djibouti" />
			        <option value="Dominica" />
			        <option value="Dominican Republic" />
			        <option value="Ecuador" />
			        <option value="Egypt" />
			        <option value="El Salvador" />
			        <option value="Equatorial Guinea" />
			        <option value="Eritrea" />
			        <option value="Estonia" />
			        <option value="Ethiopia" />
			        <option value="Falkland Islands (Malvinas)" />
			        <option value="Faroe Islands" />
			        <option value="Fiji" />
			        <option value="Finland" />
			        <option value="France" />
			        <option value="French Guiana" />
			        <option value="French Polynesia" />
			        <option value="French Southern Territories" />
			        <option value="Gabon" />
			        <option value="Gambia" />
			        <option value="Georgia" />
			        <option value="Germany" />
			        <option value="Ghana" />
			        <option value="Gibraltar" />
			        <option value="Greece" />
			        <option value="Greenland" />
			        <option value="Grenada" />
			        <option value="Guadeloupe" />
			        <option value="Guam" />
			        <option value="Guatemala" />
			        <option value="Guinea" />
			        <option value="Guinea-bissau" />
			        <option value="Guyana" />
			        <option value="Haiti" />
			        <option value="Heard Island and Mcdonald Islands" />
			        <option value="Holy See (Vatican City State)" />
			        <option value="Honduras" />
			        <option value="Hong Kong" />
			        <option value="Hungary" />
			        <option value="Iceland" />
			        <option value="India" />
			        <option value="Indonesia" />
			        <option value="Iran, Islamic Republic of" />
			        <option value="Iraq" />
			        <option value="Ireland" />
			        <option value="Israel" />
			        <option value="Italy" />
			        <option value="Jamaica" />
			        <option value="Japan" />
			        <option value="Jordan" />
			        <option value="Kazakhstan" />
			        <option value="Kenya" />
			        <option value="Kiribati" />
			        <option value="Korea, Democratic People's Republic of" />
			        <option value="Korea, Republic of" />
			        <option value="Kuwait" />
			        <option value="Kyrgyzstan" />
			        <option value="Lao People's Democratic Republic" />
			        <option value="Latvia" />
			        <option value="Lebanon" />
			        <option value="Lesotho" />
			        <option value="Liberia" />
			        <option value="Libyan Arab Jamahiriya" />
			        <option value="Liechtenstein" />
			        <option value="Lithuania" />
			        <option value="Luxembourg" />
			        <option value="Macao" />
			        <option value="Macedonia, The Former Yugoslav Republic of" />
			        <option value="Madagascar" />
			        <option value="Malawi" />
			        <option value="Malaysia" />
			        <option value="Maldives" />
			        <option value="Mali" />
			        <option value="Malta" />
			        <option value="Marshall Islands" />
			        <option value="Martinique" />
			        <option value="Mauritania" />
			        <option value="Mauritius" />
			        <option value="Mayotte" />
			        <option value="Mexico" />
			        <option value="Micronesia, Federated States of" />
			        <option value="Moldova, Republic of" />
			        <option value="Monaco" />
			        <option value="Mongolia" />
			        <option value="Montserrat" />
			        <option value="Morocco" />
			        <option value="Mozambique" />
			        <option value="Myanmar" />
			        <option value="Namibia" />
			        <option value="Nauru" />
			        <option value="Nepal" />
			        <option value="Netherlands" />
			        <option value="Netherlands Antilles" />
			        <option value="New Caledonia" />
			        <option value="New Zealand" />
			        <option value="Nicaragua" />
			        <option value="Niger" />
			        <option value="Nigeria" />
			        <option value="Niue" />
			        <option value="Norfolk Island" />
			        <option value="Northern Mariana Islands" />
			        <option value="Norway" />
			        <option value="Oman" />
			        <option value="Pakistan" />
			        <option value="Palau" />
			        <option value="Palestinian Territory, Occupied" />
			        <option value="Panama" />
			        <option value="Papua New Guinea" />
			        <option value="Paraguay" />
			        <option value="Peru" />
			        <option value="Philippines" />
			        <option value="Pitcairn" />
			        <option value="Poland" />
			        <option value="Portugal" />
			        <option value="Puerto Rico" />
			        <option value="Qatar" />
			        <option value="Reunion" />
			        <option value="Romania" />
			        <option value="Russian Federation" />
			        <option value="Rwanda" />
			        <option value="Saint Helena" />
			        <option value="Saint Kitts and Nevis" />
			        <option value="Saint Lucia" />
			        <option value="Saint Pierre and Miquelon" />
			        <option value="Saint Vincent and The Grenadines" />
			        <option value="Samoa" />
			        <option value="San Marino" />
			        <option value="Sao Tome and Principe" />
			        <option value="Saudi Arabia" />
			        <option value="Senegal" />
			        <option value="Serbia and Montenegro" />
			        <option value="Seychelles" />
			        <option value="Sierra Leone" />
			        <option value="Singapore" />
			        <option value="Slovakia" />
			        <option value="Slovenia" />
			        <option value="Solomon Islands" />
			        <option value="Somalia" />
			        <option value="South Africa" />
			        <option value="South Georgia and The South Sandwich Islands" />
			        <option value="Spain" />
			        <option value="Sri Lanka" />
			        <option value="Sudan" />
			        <option value="Suriname" />
			        <option value="Svalbard and Jan Mayen" />
			        <option value="Swaziland" />
			        <option value="Sweden" />
			        <option value="Switzerland" />
			        <option value="Syrian Arab Republic" />
			        <option value="Taiwan, Province of China" />
			        <option value="Tajikistan" />
			        <option value="Tanzania, United Republic of" />
			        <option value="Thailand" />
			        <option value="Timor-leste" />
			        <option value="Togo" />
			        <option value="Tokelau" />
			        <option value="Tonga" />
			        <option value="Trinidad and Tobago" />
			        <option value="Tunisia" />
			        <option value="Turkey" />
			        <option value="Turkmenistan" />
			        <option value="Turks and Caicos Islands" />
			        <option value="Tuvalu" />
			        <option value="Uganda" />
			        <option value="Ukraine" />
			        <option value="United Arab Emirates" />
			        <option value="United Kingdom" />
			        <option value="United States" />
			        <option value="United States Minor Outlying Islands" />
			        <option value="Uruguay" />
			        <option value="Uzbekistan" />
			        <option value="Vanuatu" />
			        <option value="Venezuela" />
			        <option value="Viet Nam" />
			        <option value="Virgin Islands, British" />
			        <option value="Virgin Islands, U.S" />
			        <option value="Wallis and Futuna" />
			        <option value="Western Sahara" />
			        <option value="Yemen" />
			        <option value="Zambia" />
			        <option value="Zimbabwe" />
			    </datalist>
			    <br>
				<label>Life Span:</label><br>
				<input type="number" id="life" name="life1" required> <p class="p1">to</p> <input type="number" id="life" name="life2" required><p class="p1">&nbsp;years</p>
				<br>
				<label>Weight:</label><br>
				<input type="number" id="weight" name="weight1" required> <p class="p1">to</p> <input type="number" id="weight" name="weight2" required><p class="p1">&nbsp;kg</p>
				<br>
				<label>Length:</label><br>
				<input type="number" id="length" name="length1" required> <p class="p1">to</p> <input type="number" id="length" name="length2" required><p class="p1">&nbsp;cm</p>
			</div>
			<div class="tab" id="thirdTab">
				<h1 class="tab3head">Breed Characteristics</h1><br>
				<img src="../media/scale.png" style="position: absolute;margin-left: -150px;margin-top: -70px; width: 100px;height: 500px;">
				<table>
					<tr height="60px">
						<td><label class="characteristics">Kid-Friendly</label></td>
						<td>:</td>
						<td>
						<select name="one" required>
		    			<option value="" disabled selected>Choose</option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
						</td>
						<td width="50px">   </td>
						<td><label class="characteristics">Pet-Friendly</label></td>
						<td>:</td>
						<td>
						<select name="two" required>
		    			<option value="" disabled selected>Choose</option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
						</td>
					</tr>
					<tr height="60px">
						<td><label class="characteristics">Stranger-Friendly</label></td>
						<td>:</td>
						<td>
						<select name="three" required>
		    			<option value="" disabled selected>Choose</option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
						</td>
						<td width="50px">    </td>
						<td><label class="characteristics">Intelligence</label></td>
						<td>:</td>
						<td>
						<select name="four" required>
		    			<option value="" disabled selected>Choose</option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
						</td>
					</tr>
					<tr height="60px">
						<td><label class="characteristics">Grooming Requirements</label></td>
						<td>:</td>
						<td>
						<select name="five" required>
		    			<option value="" disabled selected>Choose</option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
						</td>
						<td width="50px">   </td>
						<td><label class="characteristics">Playfulness</label></td>
						<td>:</td>
						<td>
						<select name="six" required>
		    			<option value="" disabled selected>Choose</option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
						</td>
					</tr>
					<tr height="60px">
						<td><label class="characteristics">Amount of Shedding</label></td>
						<td>:</td>
						<td>
						<select name="seven" required>
		    			<option value="" disabled selected>Choose</option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
						</td>
						<td width="50px">   </td>
						<td><label class="characteristics">Energy Level</label></td>
						<td>:</td>
						<td>
						<select name="eight" required>
		    			<option value="" disabled selected>Choose</option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
						</td>
					</tr>
					<tr height="60px">
						<td><label class="characteristics">Affection Towards Owners</label></td>
						<td>:</td>
						<td>
						<select name="nine" required>
		    			<option value="" disabled selected>Choose</option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
						</td>
						<td width="50px">   </td>
						<td><label class="characteristics">Vocality</label></td>
						<td>:</td>
						<td>
						<select name="ten" required>
		    			<option value="" disabled selected>Choose</option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
						</td>
					</tr>
				</table>			
				<br><br>
			</div>
			<div  style="overflow:auto; ">
				<div class="nextprevButton">
				<button class="nextbutton" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
				<button class="nextbutton" type="button" id="nextBtn" onclick="nextPrev(1)">Next </button>
			</div>
			</div>
			<div style="text-align:center;margin-top:40px;">
				<span class="step"></span>
				<span class="step"></span>
				<span class="step"></span>
			</div>
		</form>
	</div>

</div>



<script>
var breedInput = document.getElementById('breed-search');
var breedList = document.getElementById('breed-list');

breedInput.addEventListener('change', function() {
  // Get the selected option
  var selectedOption = breedList.querySelector('option[value="' + breedInput.value + '"]');
  
  // Check if an option was selected
  if (selectedOption !== null) {
    // Redirect to the breed profile page with the selected breedID
    var breedID = selectedOption.getAttribute('data-breedid');
    window.open('SideBar_Breed-Breed-Profile.php?id=' + breedID, '_self');
    breedInput.value = "";
  }
});




function searchBreeds() {
  // Get the search input value
  var query = document.getElementById('breed-search').value.trim().toLowerCase();
  
  // Get all the breed cards
  var breedCards = document.querySelectorAll('.breed-card');
  
  // Loop through each breed card and check if it matches the search query
  breedCards.forEach(function(card) {
    var name = card.querySelector('.breed-name').innerText.toLowerCase();
    if (name.includes(query)) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}

// Listen for changes to the search input
var searchInput = document.getElementById('breed-search');
searchInput.addEventListener('input', searchBreeds);


var currentUrl = window.location.href;
// get all sidebar links
var sidebarLinks = document.querySelectorAll('.sidebar-item');

// loop through sidebar links and check if the URL matches
sidebarLinks.forEach(function(link) {
  if (link.href === currentUrl) {
    link.classList.add('active');
    if (link.href.includes("SideBar_Breed")) {
      document.getElementById("dropdown-btn-id").classList.add("active");
    }
  }
});


var modal = document.getElementById("AddModal");

// Get the button that opens the modal
var btn = document.getElementById("button1");

// Get the <span> element that closes the modal
var span = AddModal.getElementsByClassName("close")[0];


// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block"; 
    showTab(0); // Display the current tab
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  document.getElementById("breedForm").reset();
  document.getElementsByClassName('tab')[0].style.display="none";
  document.getElementsByClassName('tab')[1].style.display="none";
  document.getElementsByClassName('tab')[2].style.display="none";
  document.getElementsByClassName("step")[0].className="step";
  document.getElementsByClassName("step")[1].className="step";
  document.getElementsByClassName("step")[2].className="step";
  window.location.reload();
}


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    document.getElementById("breedForm").reset();
    document.getElementsByClassName('tab')[0].style.display="none";
    document.getElementsByClassName('tab')[1].style.display="none";
    document.getElementsByClassName('tab')[2].style.display="none";
    document.getElementsByClassName("step")[0].className="step";
    document.getElementsByClassName("step")[1].className="step";
    document.getElementsByClassName("step")[2].className="step";
    window.location.reload();
  }
}


var currentTab =0;

function showTab(n) {
	// This function will display the specified tab of the form...
	var x = document.getElementsByClassName("tab");
	x[n].style.display = "block";
	//... and fix the Previous/Next buttons:
	if (n == 0) {
		document.getElementById("prevBtn").style.display = "none";
	} else {
		document.getElementById("prevBtn").style.display = "inline";
	}
	if (n == (x.length - 1)) {
		document.getElementById("nextBtn").innerHTML = "Submit";


	} else {
		document.getElementById("nextBtn").innerHTML = "Next";

	}
	//... and run a function that will display the correct step indicator:
	fixStepIndicator(n);
}

function nextPrev(n) {
	// This function will figure out which tab to display
	var x = document.getElementsByClassName("tab");
	// Exit the function if any field in the current tab is invalid:
	if (n == 1 ){
		if (!validateForm(currentTab)) return false;
		
		// Hide the current tab:
		document.getElementsByClassName("step")[currentTab].className += " finish";
		x[currentTab].style.display = "none";
		// Increase or decrease the current tab by 1:
		currentTab = currentTab + n;
		
	}
	if(n == -1){
		x[currentTab].style.display = "none";
		// Increase or decrease the current tab by 1:
		currentTab = currentTab + n;
		// if you have reached the end of the form...
	}
	if (currentTab >= x.length) {
		// ... the form gets submitted:
		document.getElementById("breedForm").submit();
	    document.getElementById("breedForm").reset();
    	document.getElementsByClassName('tab')[0].style.display="none";
    	document.getElementsByClassName('tab')[1].style.display="none";
    	document.getElementsByClassName('tab')[2].style.display="none";
    	document.getElementsByClassName("step")[0].className="step";
    	document.getElementsByClassName("step")[1].className="step";
   	    document.getElementsByClassName("step")[2].className="step";
   	    currentTab = 0;
	}
	// Otherwise, display the correct tab:
	showTab(currentTab);
}

function fixStepIndicator(n) {
	// This function removes the "active" class of all steps...
	var i, x = document.getElementsByClassName("step");
	for (i = 0; i < x.length; i++) {
		x[i].className = x[i].className.replace(" activated", "");
	}
	//... and adds the "active" class to the current step:
	x[n].className += " activated";
}

function validateForm(x) {
	if (x==0 ){
  let a = document.forms["breedForm"]["name"].value;
  let b = document.forms["breedForm"]["img"].value;
  let c = document.forms["breedForm"]["description"].value;
  if (a == "" || b == "" || c == "") {
    alert("All fields must be filled out");
    return false;
 	}
 	else
 		{return true;}
	}
	else if (x==1){
    let a = document.forms["breedForm"]["country"].value;
	let b = parseInt(document.forms["breedForm"]["life1"].value.trim());
	let c = parseInt(document.forms["breedForm"]["life2"].value.trim());
	let d = parseInt(document.forms["breedForm"]["weight1"].value.trim());
	let e = parseInt(document.forms["breedForm"]["weight2"].value.trim());
	let f = parseInt(document.forms["breedForm"]["length1"].value.trim());
	let g = parseInt(document.forms["breedForm"]["length2"].value.trim());
	if (a === "" || isNaN(b) || isNaN(c) || isNaN(d) || isNaN(e) || isNaN(f) || isNaN(g)) {
    alert("All fields must be filled out");
    return false;
 	}
  else if ( b >= c ) {
    alert("Maximum life span must be higher than minimum life span");
    return false;
 	}
  else if ( d >= e ) {
    alert("Maximum weight must be higher than minimum weight");
    return false;
 	}
  else if ( f >= g ) {
    alert("Maximum lenth must be higher than minimum length");
    return false;
 	}
  else if ( b <0 || c <0) {
    alert("Life span cannot be negative");
    return false;
 	}
  else if ( d <0 || e <0) {
    alert("Weight cannot be negative");
    return false;
 	}
  else if ( f <0 || g <0) {
    alert("Length cannot be negative");
    return false;
 	}
 	else
 		{return true;}
	}
	else if (x==2){
  let a = document.forms["breedForm"]["one"].value;
  let b = document.forms["breedForm"]["two"].value;
  let c = document.forms["breedForm"]["three"].value;
  let d = document.forms["breedForm"]["four"].value;
  let e = document.forms["breedForm"]["five"].value;
  let f = document.forms["breedForm"]["six"].value;
  let g = document.forms["breedForm"]["seven"].value;
  let h = document.forms["breedForm"]["eight"].value;
  let i = document.forms["breedForm"]["nine"].value;
  let j = document.forms["breedForm"]["ten"].value;
  if (a == "" || b == "" || c == "" || d == "" || e == ""||f == ""||g == ""||h == ""||i == ""||j == "") {
    alert("All fields must be filled out");
    return false;
 	}
 	else
 		{return true;}
	}
}

function deleteBreed(event) {
    event.preventDefault(); // Prevent the link from opening

    if (confirm("Are You Sure To Delete This Breed Information?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", event.currentTarget.href, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Deleted Breed Information");
                window.location.reload();
            } else {
                alert("Error Deleting Breed Information");
            }
        };
        xhr.send();
    } else {
        console.log("User cancelled the delete operation.");
    }
}

  var checkbox = document.getElementById('check');
  var columns = document.getElementsByClassName('column');

  function handleCheckboxChange() {
    for (var i = 0; i < columns.length; i++) {
      var column = columns[i];
      if (checkbox.checked) {
        column.classList.add('collapsed');
      } else {
        column.classList.add('collapsed');
      }
    }
  }

  checkbox.addEventListener('change', handleCheckboxChange);

  // Initial call to set the initial state based on the checkbox's initial checked state
  handleCheckboxChange();
</script>
</body>

</html>
