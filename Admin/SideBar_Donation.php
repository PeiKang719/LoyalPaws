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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>
<body style="background-color:white;">

<?php include 'AdminHeader.php'; ?>



<section class="content" id="donation">
	<div class="container">
	<button class="button1" id="button1"><i class="material-icons addIcon">add</i>Add Donation</button>
  <input type="text" class="search" placeholder="Search For Organization" id="organization-search" list="organization-list">
<datalist id="organization-list">
  <?php
  // Connect to the database
  include('../Database/Connection.php');

  $sql = "SELECT oID,oname FROM organization ORDER BY oname";
  $result = mysqli_query($conn, $sql);

  // Loop through the results and populate the datalist options
  while ($row = mysqli_fetch_assoc($result)) {
    // Check if breedID exists before adding it as a data attribute
    $oID = isset($row['oID']) ? 'data-oid="' . $row['oID'] . '"' : '';
    echo '<option value="' . $row['oname'] . '" ' . $oID . '>' . $row['oname'] . '</option>';
  }

  // Close the database connection
  mysqli_close($conn);
  ?>
</datalist>
</div>

<?php showOrganization(); ?>
</section>


<?php
function showOrganization() {
    include('../Database/Connection.php');
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
    $sql = "CALL GetOrganization(?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $records_per_page);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['logo']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('organization_images/' . $row['logo'])) {
                $imageSrc = 'organization_images/' . $row['logo'];
            }
            echo '<div class="column">';
            echo '<div class="card">';
            echo '<img src="' . $imageSrc . '" alt="Organization Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName">';
            echo '<p><b>' . $row['oname'] . '</b></p>';
            echo '</div>';
            echo '<div class="breedIcon">';
            echo '<a href="SideBar_Donation-Organization-Profile.php?admin=yes&id=' . $row['oID'] . '" target="_self"><span class="material-symbols-outlined" id="card-button">open_in_new</span></a>';
            echo '<a href="SideBar_Donation-Edit-Modal.php?id=' . $row['oID'] . '" target="_self"><span class="material-symbols-outlined" id="card-button-edit">edit</span>';
            echo '<iframe name="hiddenFrame3" class="hide"></iframe>';
            echo '<a href="SideBar_Donation-Delete-Organization.php?id=' . $row['oID'] . '" target="hiddenFrame3" onclick="deleteOrganization(event)"><span class="material-symbols-outlined" id="card-button-delete">delete</span></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages
        echo '<div class="pagination">';
        
        if($page==1){
          
        }
        else{
          echo '<a href="SideBar_Donation.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo '<a href="SideBar_Donation.php?page=' . $i . '" class="page-active">' . $i . '</a>';
        } else {
            echo '<a href="SideBar_Donation.php?page=' . $i . '">' . $i . '</a>';
        }
  }
    if($page == $total_pages){
       
    }
    else{
        echo '<a href="SideBar_Donation.php?page=' . ($page+1) . '"> &gt;</a>';
     }
        echo '</div>';
    }
}

?>

<!---------------------------- Add Modal ----------------------------------->
<div id="AddModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Add New Organization</h2>
      </div>
      <iframe name="hiddenFrame" class="hide"></iframe>
    <form id="organizationForm" action="SideBar_Donation-Add-Organization.php" method="post" target="hiddenFrame" enctype="multipart/form-data">

      <div class="tab">
        <h1 class="tab2head" style="margin-left:215px;">Organization Data</h1>
        <label>Organization:</label>
        <input type="text" placeholder="Name..." oninput="this.className = ''" name="name" required>
        <br>
        <label>Organization Logo:</label>
        <input type="file" id="img" name="img" accept="image/*" required>
        <br>
        <label>Website URL:</label>
        <input type="url" placeholder="URL..." name="url" required>
        <br>
        <label>Category:</label><br>
        <table  width="720px;" style="margin-bottom:9px;">
          <td width="50%" align="center">
        <label class="check-container"  style="width:83%;padding:13px 0 13px 50px;height: 27px;">Conservation Efforts
            <input type="checkbox" name="category[]" onchange="changeColor(this)" value="Conservation Efforts">
            <span class="checkmark2"></span>
        </label>
      </td>
      <td align="center">
        <label class="check-container" style="width:83%;padding:13px 0 13px 50px;height: 27px;">Animal Rescue and Adoption
            <input type="checkbox" name="category[]" onchange="changeColor(this)" value="Animal Rescue and Adoption">
            <span class="checkmark2"></span>
        </label>
      </td>
      </table>
        
      </div>
       <div class="tab">
        <label>Description:</label>
        <textarea maxlength="1500" placeholder="Write something to describe the organization...(max 1500 characters)" name="description" required style="height:320px;"></textarea>
      </div>
      <div class="tab" id="secondTab">
        <h1 class="tab2head">Payment Detail</h1>
        <label>Payment Type:</label><br>
         <select name="type" required style="width:82%;margin-bottom: 25px;">
              <option value="" disabled selected>Select the payment type</option>
              <option>One-Time Payment</option>
              <option>Monthly Payment</option>
              <option>Monthly Payment & One-Time Payment</option>
          </select>
          <br>
        <label>Payment Method:</label><br>
        <table style="width: 85%;">
          <tr >
        <td ><label class="check-container"><img src="../media/card.png" width="50px;" height="40px;">
            <input type="checkbox" name="method[]" onchange="changeColor(this)" value="Card">
            <span class="checkmark2"></span>
        </label></td>
         <td><label class="check-container"><img src="../media/bank.png" width="50px;" height="40px;">
            <input type="checkbox" name="method[]" onchange="changeColor(this)" value="Bank">
            <span class="checkmark2"></span>
        </label></td>
         <td><label class="check-container"><img src="../media/paypal.png" width="50px;" height="40px;">
            <input type="checkbox" name="method[]" onchange="changeColor(this)" value="Paypal">
            <span class="checkmark2"></span>
        </label></td>
         <tr>
          <td><label class="check-container"><img src="../media/applepay.png" width="60px;" height="27px;" style="margin-top:8px;">
            <input type="checkbox" name="method[]" onchange="changeColor(this)" value="ApplePay">
            <span class="checkmark2"></span>
        </label></td>
         <td><label class="check-container"><img src="../media/googlepay.png" width="60px;" height="60px;" style="margin-top:-8px;">
            <input type="checkbox" name="method[]" onchange="changeColor(this)" value="GooglePay">
            <span class="checkmark2"></span>
        </label></td>
        <td> <label class="check-container"><img src="../media/others.png" width="80px;" height="80px;" style="margin-top:-20px;margin-left: -10px;">
            <input type="checkbox" name="method[]" onchange="changeColor(this)" value="Others">
            <span class="checkmark2"></span>
        </label></td>
      </table>
        <br>
        <label>Minimum Donation (RM):</label><br>
        <input type="number" id="minimum" name="minimum" required min="0" style="width:79%;">
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

var organizationInput = document.getElementById('organization-search');
var organizationList = document.getElementById('organization-list');

organizationInput.addEventListener('change', function() {
  // Get the selected option
  var selectedOption = organizationList.querySelector('option[value="' + organizationInput.value + '"]');
  
  // Check if an option was selected
  if (selectedOption !== null) {
    // Redirect to the breed profile page with the selected breedID
    var oID = selectedOption.getAttribute('data-oid');
    window.open('SideBar_Donation-Organization-Profile.php?admin=yes&id=' + oID, '_self');
    organizationInput.value = "";
  }
});

var modal = document.getElementById("AddModal");
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
  document.getElementById("organizationForm").reset();
  window.location.reload();
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    document.getElementById("organizationForm").reset();
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
    console.log("submit");
    document.getElementById("organizationForm").submit();
      document.getElementById("organizationForm").reset();
    var checkbox = document.getElementsByName("category[]");
    for (var i = 0; i < checkbox.length; i++) {
    var checkboxLabel = checkbox[i].parentNode;
      checkboxLabel.style.backgroundColor = "white";
     checkboxLabel.style.borderColor = "#b3b3b3";
  }
    var checkbox2 = document.getElementsByName("method[]");
    for (var i = 0; i < checkbox2.length; i++) {
    var checkboxLabel2 = checkbox2[i].parentNode;
      checkboxLabel2.style.backgroundColor = "white";
     checkboxLabel2.style.borderColor = "#b3b3b3";
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

function changeColor(checkbox) {
  var checkbox = document.getElementsByName(checkbox.name);
  for (var i = 0; i < checkbox.length; i++) {
    var checkboxLabel = checkbox[i].parentNode;
    if (checkbox[i].checked) {
      checkboxLabel.style.backgroundColor = "#cfe8fc";
      checkboxLabel.style.borderColor = "#6fb9f6";
    } else {
      checkboxLabel.style.backgroundColor = "white";
     checkboxLabel.style.borderColor = "#b3b3b3";
    }
  }
}

function validateForm(x) {
  if (x==0 ){
  let a = document.forms["organizationForm"]["name"].value;
  let b = document.forms["organizationForm"]["img"].value;
  let c = document.forms["organizationForm"]["url"].value;

  if (a == "" || b == "" || c == "") {
    alert("All fields must be filled out");
    return false;
  }
  else
    var checkboxes = document.getElementsByName("category[]");
  var checked = false;
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      checked = true;
      break;
    }
  }
  if (!checked) {
    alert("All fields must be filled out");
    return false;
  }

  var urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
    if (!c.match(urlRegex)) {
      alert("Invalid URL");
      return false;
    }

  return true;
  }
  else if (x==1){
    let a = document.forms["organizationForm"]["description"].value;
  if (a === "") {
    alert("All fields must be filled out");
    return false;
  }
  else
    {return true;}
  }
  else if (x==2){
  let a = document.forms["organizationForm"]["type"].value;
  let c = document.forms["organizationForm"]["minimum"].value;

  if (a == "" || c == "" ) {
    alert("All fields must be filled out");
    return false;
  }
  else
  var checkboxes = document.getElementsByName("method[]");
  var checked = false;
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      checked = true;
      break;
    }
  }
  if (!checked) {
    alert("All fields must be filled out");
    return false;
  }
  return true;
  }
}

function deleteOrganization(event) {
    event.preventDefault(); // Prevent the link from opening

    if (confirm("Are You Sure To Delete This Organization Information?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", event.currentTarget.href, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Deleted Organization Information");
                window.location.reload();
            } else {
                alert("Error Deleting Organization Information");
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
