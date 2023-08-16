<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Main page</title>
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="SellerStyle.css">
<link rel="icon" type="image/png" href="media/tabIcon.png">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<style type="text/css">
  .unavailable{
    position: absolute;
    color: red;
    margin-left: 70px;
    font-weight: bold;
  }
</style>

</head>
<body style="background-color: white;">

<?php 
session_start();
include 'SellerHeader.php'; 
?>


<section class="content" id="dog-breed">
	<div class="container">
	<button class="button1" id="button1"><i class="material-icons addIcon">add</i>Add New Pets</button>
<input type="text" class="search" name="search" placeholder="Search by name" oninput="searchPets(this.value)">




</div>
<?php showPet($key, $sellerID ); ?>
</section>
	
<?php
function showPet($pk, $sid) {
    include('Connection.php');
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "SELECT count(*) as total from pet where $pk=$sid";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT p.petID, p.type, p.gender, p.birthday, p.color, p.description, p.pet_image, p.img1, p.img2, p.img3, p.img4, p.img5, p.img6, p.vaccinated, p.spayed, p.price,p.availability, p.breedID,b.name,p.adopterID FROM pet p,breed b WHERE p.breedID=b.breedID AND $pk=$sid ORDER BY CASE WHEN p.adopterID IS NULL THEN 0 ELSE 1 END,b.name LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
        	if($row['adopterID']==NULL){
            $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<div class="column">';
            echo '<div class="card">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            if($row['availability']=='N'){
            echo '<p class="unavailable">Unavailable</p>';
            }
            echo '<div class="petName">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            echo '<div class="breedIcon">';
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_blank"><span class="material-symbols-outlined" id="card-button">open_in_new</span></a>';
            echo '<a href="Seller_Pets-Edit-Modal.php?petID=' . $row['petID'] . '" target="_blank"><span class="material-symbols-outlined" id="card-button-edit">edit</span>';
            echo '<iframe name="hiddenFrame3" class="hide"></iframe>';
            echo '<a href="Seller_Pets-Delete-Pets.php?id=' . $row['petID'] . '" target="hiddenFrame3" onclick="deletePet(event)"><span class="material-symbols-outlined" id="card-button-delete">delete</span></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        else{
        	
            $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<div class="column">';
            echo '<div class="card" style="background-color:#d9d9d9">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="petName">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
        	}
            echo '<div class="breedIcon">';
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_blank"><span class="material-symbols-outlined" id="card-button">open_in_new</span></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        }
    
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
        	
        }
        else{
        	echo '<a href="Seller_Pets.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
		    if ($i == $page) {
		        echo '<a href="Seller_Pets.php?page=' . $i . '" class="page-active">' . $i . '</a>';
		    } else {
		        echo '<a href="Seller_Pets.php?page=' . $i . '">' . $i . '</a>';
		    }
	}
		if($page == $total_pages){
		   
		}
		else{
		    echo '<a href="Seller_Pets.php?page=' . ($page+1) . '"> &gt;</a>';
		 }
        echo '</div>';
    }else{
    	echo "0 pet";
    }
}
?>


<!---------------------------- Add Modal ----------------------------------->
<div id="AddModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Add New Pet</h2>
      </div>
      <iframe name="hiddenFrame" class="hide"></iframe>
    <form id="petForm" action="Seller_Pets-Add-Pets.php" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="pk" value="<?php echo $key ?>" >
      <input type="hidden" name="sellerID" value="<?php echo $sellerID ?>" >
      <div class="tab" style="margin-bottom:-3px">
        <h1 class="tab2head" style="margin-left:283px;">Pet Data</h1>
        <label>Cat or Dog:</label><br>
         <table  width="720px;" style="margin-bottom:9px;" >
          <td width="50%" align="center">
        <label class="radio-container"  >Cat
            <input type="radio" name="type" onchange="changeColor(this);updateBreedOptions(this.value)" value="Cat">
            <span class="radiomark2"></span>
        </label>
      </td>
      <td align="center">
        <label class="radio-container" >Dog
            <input type="radio" name="type" onchange="changeColor(this);updateBreedOptions(this.value)" value="Dog">
            <span class="radiomark2"></span>
        </label>
      </td>
      </table>
        <label>Breed:</label><br>
         <select name="breed" required style="width:100%;" id="breedSelect">
    		<?php BreedSelectOption($type);?>
		</select>   
         <br><br>
        <label>Gender:</label>
         <table  width="720px;" style="margin-bottom:9px;">
          <td width="50%" align="center">
        <label class="radio-container" >Male
            <input type="radio" name="gender" onchange="changeColor(this)" value="Male">
            <span class="radiomark2"></span>
        </label>
      	</td>
      <td align="center">
        <label class="radio-container" >Female
            <input type="radio" name="gender" onchange="changeColor(this)" value="Female">
            <span class="radiomark2"></span>
        </label>
      </td>
      </table>
        <label>Date of Birth</label>
        <input type="date" id="birthday" name="birthday" style="width:97%;margin-left: 5px;">
    	</div>
    	<div class="tab" style="margin-top:-25px;margin-bottom: -23px;">
        <label>Purpose</label>
         <table  width="720px;" style="margin-bottom:9px;">
          <td width="50%" align="center">
        <label class="radio-container" >Sell
            <input type="radio" name="purpose" onchange="changeColor(this)" value="Sell" id="sell_btn">
            <span class="radiomark2"></span>
        </label>
      	</td>
      <td align="center">
        <label class="radio-container" >Rehome
            <input type="radio" name="purpose" onchange="changeColor(this)" value="Rehome" id="rehome_btn">
            <span class="radiomark2"></span>
        </label>
      </td>
      </table>
        <label>Spayed?</label>
         <table  width="720px;" style="margin-bottom:9px;">
          <td width="50%" align="center">
        <label class="radio-container"  >Yes
            <input type="radio" name="spayed" onchange="changeColor(this)" value="Yes">
            <span class="radiomark2"></span>
        </label>
      	</td>
      <td align="center">
        <label class="radio-container" >No
            <input type="radio" name="spayed" onchange="changeColor(this)" value="No">
            <span class="radiomark2"></span>
        </label>
      </td>
      </table>
      <label>Vaccinated?</label>
         <table  width="720px;" style="margin-bottom:9px;">
          <td width="50%" align="center">
        <label class="radio-container" >Yes
            <input type="radio" name="vaccinated" onchange="changeColor(this)" value="Yes">
            <span class="radiomark2"></span>
        </label>
      	</td>
      <td align="center">
        <label class="radio-container" >No
            <input type="radio" name="vaccinated" onchange="changeColor(this)" value="No">
            <span class="radiomark2"></span>
        </label>
      </td>
      </table>
      <label>Color:</label><br>
        <input type="text" placeholder="Color..." name="color" required onkeydown="return /[a-z ]/i.test(event.key)">
      <label>Price (RM):</label><br>
        <input type="number" id="minimum" name="price" min="0" required style="width:100%;">
      
      </div>
       <div class="tab">
        <label>Description:</label>
        <textarea maxlength="800" placeholder="Write something to describe the pet...(max 800 characters)" name="description" required style="height:181px;" id="description"></textarea>
        <label id="required" style="display: none;">Return required? (Optional)<p style="color:red">*The pet will become unavailable if return date has expired*</p></label>
         <table  width="720px;" style="margin-bottom:9px;margin-top: 20px;">
          <tr id="return" style="display: none;">
          <td width="50%" align="center">
        <label class="switch" for="return_date">
                        <input type="checkbox" id="return_date" name="return_date" value="Yes" />
                        <div class="slider round"></div>
                        </label>
        </td>
      <td align="center">
        <input type="date" name="date" id="date" style="width:90%" disabled>
      </td>
    </tr>
      </table>
      </div>
        <div class="tab">
	        <h1 class="tab2head" style="margin-left:215px;">Images & Video</h1>
	        <label>Main Image:</label>
	        <input type="file" id="img" name="img0" accept="image/*" required >
	        <p style="margin: 0;text-align: center;color: red;">************Optional************</p>
	      <table border="0" style="width: 100%;margin-left: 30px;margin-bottom: 5.5px;">
	      	<tr>
	        <td style="width: 10%;"><label>Image1:</label></td>
	        <td style="width: 210px;"><input type="file" id="img2" name="img1" accept="image/*" ></td>
	        <td style="width: 10%;"><label>Image2:</label></td>
	        <td style="width: 210px;"><input type="file" id="img2" name="img2" accept="image/*"></td>
	        </tr>
	        <tr>
	        <td><label>Image3:</label></td>
	        <td><input type="file" id="img2" name="img3" accept="image/*" ></td>
	        <td><label>Image4:</label></td>
	        <td><input type="file" id="img2" name="img4" accept="image/*" ></td>
	        </tr>
	    	<tr>
	        <td><label>Image5:</label></td>
	        <td><input type="file" id="img2" name="img5" accept="image/*" ></td>
	        <td><label>Image6:</label></td>
	        <td><input type="file" id="img2" name="img6" accept="image/*" ></td>
	        </tr>
	    </table>
	        <label>Video:</label>
	        <input type="file" id="video" name="video" accept="video/*">    
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
        <span class="step"></span>
      </div>
    </form>
  </div>
</div>


<?php
/*Select Option of Rules When Insertion Of Penalty*/
function BreedSelectOption() {
include('Connection.php');
$sql = "SELECT * FROM breed order by name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {?>
    <option value="">Select the breed</option>
    <?php
    while($row = $result->fetch_assoc()) {
        echo "<option value=". $row["breedID"].">" . $row['name'] . "</option>";
        ?>

<?php
    }

} else {?>
    <option value="">No Breed Found</option>
<?php }

$conn->close();

}?>



<script>




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


function changeColor(radio) {
  var radio = document.getElementsByName(radio.name);
  for (var i = 0; i < radio.length; i++) {
    var radioLabel = radio[i].parentNode;
    if (radio[i].checked) {
      radioLabel.style.backgroundColor = "#cfe8fc";
      radioLabel.style.borderColor = "#6fb9f6";
    } else {
     radioLabel.style.backgroundColor = "white";
     radioLabel.style.borderColor = "#b3b3b3";
    }
  }
}

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
  document.getElementById("petForm").reset();
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
    document.getElementById("petForm").reset();
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
		document.getElementById("petForm").submit();
	    document.getElementById("petForm").reset();
    	document.getElementsByClassName('tab')[0].style.display="none";
    	document.getElementsByClassName('tab')[1].style.display="none";
    	document.getElementsByClassName('tab')[2].style.display="none";
    	document.getElementsByClassName("step")[0].className="step";
    	document.getElementsByClassName("step")[1].className="step";
   	    document.getElementsByClassName("step")[2].className="step";
   	    var checkbox = document.getElementsByName("type");
	    for (var i = 0; i < checkbox.length; i++) {
	    var checkboxLabel = checkbox[i].parentNode;
	      checkboxLabel.style.backgroundColor = "white";
	     checkboxLabel.style.borderColor = "#b3b3b3";
	  }
	  var checkbox2 = document.getElementsByName("gender");
	    for (var i = 0; i < checkbox2.length; i++) {
	    var checkboxLabel2 = checkbox2[i].parentNode;
	      checkboxLabel2.style.backgroundColor = "white";
	     checkboxLabel2.style.borderColor = "#b3b3b3";
	  }
	  var checkbox3 = document.getElementsByName("sprayed");
	    for (var i = 0; i < checkbox3.length; i++) {
	    var checkboxLabel3 = checkbox3[i].parentNode;
	      checkboxLabel3.style.backgroundColor = "white";
	     checkboxLabel3.style.borderColor = "#b3b3b3";
	  }
	  var checkbox4 = document.getElementsByName("vaccinated");
	    for (var i = 0; i < checkbox4.length; i++) {
	    var checkboxLabel4 = checkbox4[i].parentNode;
	      checkboxLabel4.style.backgroundColor = "white";
	     checkboxLabel4.style.borderColor = "#b3b3b3";
	  }

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
  if (x == 0) {
  let a = document.forms["petForm"]["type"].value;
  let b = document.forms["petForm"]["breed"].value;
  let c = document.forms["petForm"]["gender"].value;
  let d = document.forms["petForm"]["birthday"].value;
  
  if (a == "" || b == "" || c == "" || d == "") {
    alert("All fields must be filled out");
    return false;
  }
  
  // Validate birthday not after current date
  let currentDate = new Date().toISOString().split('T')[0];
  if (d > currentDate) {
    alert("Invalid birthday. Please select a date before or equal to the current date.");
    return false;
  }

  return true;
}

	else if (x == 1) {
  let a = document.forms["petForm"]["purpose"].value;
  let b = document.forms["petForm"]["spayed"].value;
  let c = document.forms["petForm"]["vaccinated"].value;
  let d = document.forms["petForm"]["color"].value;
  let e = document.forms["petForm"]["price"].value;
  
  if (a == "" || b == "" || c == "" || d == "" || e == "") {
    alert("All fields must be filled out");
    return false;
  }
  
  // Validate price must be at least 0
  if (e < 0) {
    alert("Invalid price. Please enter a value greater than or equal to 0.");
    return false;
  }

  return true;
}

	else if (x==2 ){
  let a = document.forms["petForm"]["description"].value;
  let b = document.getElementById('return_date');
  let c = document.forms["petForm"]["date"].value;

  if (a == "" ) {
    alert("All fields must be filled out");
    return false;
  }
  else if(b.checked && c==""){
    alert("Please enter a valid return date");
    return false;
  }
  let currentDate = new Date().toISOString().split('T')[0];
  if (c!="" && c < currentDate) {
    alert("Invalid return date. Please select a date which is after today");
    return false;
  }
  else
    {return true;}
  }
  else if (x==3 ){
  let a = document.forms["petForm"]["img0"].value;
  if (a == "") {
    alert("Must upload atleast one pet image");
    return false;
  }
  else
    {return true;}
  }
}

function deletePet(event) {
    event.preventDefault(); // Prevent the link from opening

    if (confirm("Are You Sure To Delete This Pet Information?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", event.currentTarget.href, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Deleted Pet Information");
                window.location.reload();
            } else {
                alert("Error Deleting Pet Information");
            }
        };
        xhr.send();
    } else {
        console.log("User cancelled the delete operation.");
    }
}

function updateBreedOptions(type) {
    var breedSelect = document.getElementById('breedSelect');
    breedSelect.innerHTML = '';
    breedSelect.options.add(new Option('Loading breeds...'));

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            breedSelect.innerHTML = xhr.responseText;
        }
    }
    xhr.open('GET', 'Seller_Pets-Get-Breed.php?type=' + type, true);
    xhr.send();
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


var searchTimeout;

function searchPets(searchQuery) {
  clearTimeout(searchTimeout); // Clear previous timeout
  
  // Set a new timeout to wait for user to finish typing
  searchTimeout = setTimeout(function() {
    // Get all the pet cards
    var petCards = document.getElementsByClassName('card');
  
    // Loop through each pet card and check if it matches the search query
    for (var i = 0; i < petCards.length; i++) {
      var petName = petCards[i].querySelector('.petName b').textContent;
      
      // Hide or show the pet card based on the search query match
      if (petName.toLowerCase().includes(searchQuery.toLowerCase())) {
        petCards[i].style.display = 'block'; // Show the card
      } else {
        petCards[i].style.display = 'none'; // Hide the card
      }
    }
  }, 300); // Adjust the timeout delay (in milliseconds) to fit your needs
}


var tr = document.getElementById('return');
var btn = document.getElementById('rehome_btn');
var sbtn = document.getElementById('sell_btn');
var description = document.getElementById('description');
var required = document.getElementById('required');
var ret = document.getElementById('return_date');
var dat = document.getElementById('date');

btn.addEventListener('change', function() {
    if (btn.checked) {
        required.style.display = 'block';
        tr.style.display = 'table-row';
        description.style.height = '181px';
    }
});
sbtn.addEventListener('change', function() {
    if (sbtn.checked) {
        required.style.display = 'none';
        tr.style.display = 'none';
        description.style.height = '282px';
        ret.checked = false;
        dat.value = '';
    } 
});

var return_date = document.getElementById('return_date');
var date = document.getElementById('date');

return_date.addEventListener('change', function() {
    if (return_date.checked) {
        date.disabled = false;
        date.setAttribute('required', 'required');
    } else {
        date.disabled = true;
        date.value = '';
        date.removeAttribute('required');
    }
});
</script>
</body>

</html>
