<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
  <link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="ClinicStyle.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<?php include 'ClinicHeader.php'; ?>
<?php include 'Connection.php'; ?>


<div class="container" style="padding-left:0;padding-right:0;width: 100%;">
 <p class="profile-header" style="margin-left:50px">Treatment</p>
  <div class="manage-appointment-section">
    <a href="Clinic-Treatment.php?treatment=my">My Treatments</a>
    <a href="Clinic-Treatment.php?treatment=manage">Manage Treatments</a> 
  </div>

<?php if(isset($_GET['treatment'])){
          if($_GET['treatment']=='my'){
            my($clinicID,$vetID);
          }
          elseif($_GET['treatment']=='manage'){
            manage($clinicID,$vetID);
          }
}else{
 my($clinicID,$vetID);
}?>

  <?php function manage($clinicID,$vetID){ ?>
  <div style="width:92%;padding:2% 4%" >
    <br>
  <div class="add-new-treatment-container">
  <button class="add-treatment-button" id="add-treatment-button"><i class="material-icons addIcon">add</i>Add New Treatment</button>
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search For Treatment" >
</div>
  <br>
  <table class="treatment-table" border="0" id="treatment-table">
  <th style="width:40px">No</th>
  <th style="width:240px">Name</th>
  <th>Description</th>
  <th style="width:140px">Unit Price</th>
  <th style="width:40px">Vets</th>
  <th colspan="1" style="width: 110px;" > </th>
<?php 
include 'Connection.php';
$i=1;
$sql = "SELECT * FROM treatment WHERE clinicID= $clinicID  ORDER BY name ";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $clinicID=$row["clinicID"];
          $treatmentID=$row["treatmentID"];
          $name=$row["name"];
          $description=$row["description"];
          $unit_price=$row["unit_price"];
          ?>
    <tr>
    <td><?php echo $i?></td>
    <td><?php echo $name?></td>
    <td><?php echo $description?></td>
    <td>RM<?php echo $unit_price?></td>
    <td><button class="manage-button" onclick="treatment_vet(<?php echo $treatmentID ?>)"><span class="material-symbols-outlined">groups</span></button></td>
    <td><button class="manage-button" onclick="edit_treatment(<?php echo$treatmentID?>)"><span class="material-symbols-outlined">edit</span></button>  <a href="Clinic-Treatment-Process.php?action=delete&treatmentID=<?php echo $treatmentID ?>" onclick="return confirmDelete();"><button class="manage-button" style="background-color:#e62e00"><span class="material-symbols-outlined">delete</span></button></a></td>
    <td style="width: 0px;padding: 0;border:0" >
    <div id="treatment_vet_Modal<?php echo$treatmentID ?>" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header" >
      <h2 style="font-size:25px"><?php echo $name?></h2>
      <span class="close" style="font-size:40px">&times;</span>
      </div>
    <div style="padding:30px 100px">
        <p style="font-size: 25px;">Provided by:</p>
        <br>
        <div class="treatment-assign-vet-container">
            <?php
            $sql3 = "SELECT v.image,v.name,v.vetID,v.ic,t.clinicID,t.name AS tname,t.description,t.unit_price,t.treatmentID FROM vet_treatment vt, vet v,treatment t WHERE vt.vetID=v.vetID AND vt.treatmentID=t.treatmentID AND vt.treatmentID= $treatmentID ";
            $result3 = $conn->query($sql3);
            if ($result3->num_rows > 0) {
              // output data of each row
              while($row3 = $result3->fetch_assoc()) {
                $image=$row3["image"];
                $name=$row3["name"];
                $vetID=$row3["vetID"];
                $ic=$row3['ic'];
                $clinicID=$row3['clinicID'];
                $tname=$row3['tname'];
                $description=$row3['description'];
                $price=$row3['unit_price'];
                $treatmentID=$row3['treatmentID'];

                if($image!=''){
                $imageData = base64_encode($image);
                $imageSrc3 = "data:image/jpg;base64," . $imageData;
                // Check if the image file exists before displaying it
                if (file_exists('vet_images/' . $image)) {
                    $imageSrc3 = 'vet_images/' . $image;
                }
                }
                else{
                  $gender=$ic[-1];
                  if( $gender% 2 == 0){
                    $imageSrc3='media/email_female.png';
                  }
                  else{
                    $imageSrc3='media/email_male.png';
                  }
                }     
          ?>
            <a href="Clinic-Vet-Profile.php?id=<?php echo$vetID ?>" target="_blank">
                <label class="assign-vet-container">
                  <img src="<?php echo $imageSrc3 ?>">
                  <p><?php echo $name ?></p>
                </label> 
            </a>
              <?php }}else{ ?>
                <p>No vet...</p>
              <?php } ?>
        </div>
    </div>
  </div>
</div>
</td>
<td style="width: 0px;padding: 0;border:0">
  <div id="editModal<?php echo$treatmentID?>" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2 style="font-size:25px">Edit Treatment</h2>
      <span class="close" style="font-size:40px">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="edittreatmentForm<?php echo$treatmentID?>" action="Clinic-Treatment-Process.php?action=edit" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="clinicID" value="<?php echo $clinicID ?>">
      <input type="hidden" name="treatmentID" value="<?php echo $treatmentID ?>">
      <div class="edittab<?php echo $treatmentID ?>" style="display:block">
        <table border="0" style="font-size:27px" id="edit-treatment-table">
        <tr>
          <td style="width: 36%;"><label>Treatment Name</label></td>
          <td>:</td>
          <td style="width:55%"><input type="text" name="name" required value="<?php echo$tname ?>"></td>
        </tr>
        <tr>
          <td style="width: 36%;"><label>Description</label></td>
          <td>:</td>
          <td style="width:55%"><textarea name="description" rows="4" cols="50"><?php echo str_replace("'", "&#39;", $description); ?></textarea></td>
        </tr>
        <tr>
          <td style="width: 36%;"><label>Unit Price (RM)</label></td>
          <td>:</td>
          <td style="width:55%"><input type="number" name="price" required value="<?php echo$price ?>"></td>
        </tr>
      </table>
    </div>
    <div class="edittab<?php echo $treatmentID ?>" style="display:none">
        <p style="font-size: 25px;">Provided by:</p>
        <div class="treatment-assign-vet-container">
            <?php
            $vets = array();

            $sql2 = "SELECT * FROM vet WHERE clinicID= $clinicID AND ic REGEXP '^[0-9]+$'";
            $sql5 = "SELECT * FROM vet_treatment WHERE treatmentID= $treatmentID ";
            $result5 = $conn->query($sql5);
            while($row5 = $result5->fetch_assoc()) {
              $vets[]=$row5['vetID'];
            }

            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
              // output data of each row
              while($row2 = $result2->fetch_assoc()) {
                $image=$row2["image"];
                $name=$row2["name"];
                $vetID=$row2["vetID"];
                $ic=$row2['ic'];

                if($image!=''){
                $imageData = base64_encode($image);
                $imageSrc2 = "data:image/jpg;base64," . $imageData;
                // Check if the image file exists before displaying it
                if (file_exists('vet_images/' . $image)) {
                    $imageSrc2 = 'vet_images/' . $image;
                }
                }
                else{
                  $gender=$ic[-1];
                  if( $gender% 2 == 0){
                    $imageSrc2='media/email_female.png';
                  }
                  else{
                    $imageSrc2='media/email_male.png';
                  }
                }     
          ?>
                
                  <?php if (in_array($vetID, $vets)){?>
                  <label class="assign-vet-container" style="background-color:#cfe8fc ;border: 1px solid #6fb9f6;">
                  <img src="<?php echo $imageSrc2 ?>">
                  <p><?php echo $name ?></p>
                  <input type="checkbox" name="vet[]" onchange="changeColor(this)" value="<?php echo $vetID ?>" checked >
                  </label> 
                <?php } else{ ?>
                  <label class="assign-vet-container">
                  <img src="<?php echo $imageSrc2 ?>">
                  <p><?php echo $name ?></p>
                  <input type="checkbox" name="vet[]" onchange="changeColor(this)" value="<?php echo $vetID ?>">
                  </label> 
                <?php } ?>
                
              <?php }}else{ ?>
                <p>No vet...</p>
              <?php } ?>
        </div>
    </div>
      <div class="submit-button-container" style="margin-top:3%">
      <button class="submit-button" id="submitbtn<?php echo$treatmentID?>" type="button" onclick="nextPrev2(1,<?php echo$treatmentID ?>)">Next</button>
      <button class="submit-button" id="closebtn<?php echo$treatmentID?>" type="button" style="background-color: white;color: #4d4d4d;" onclick="nextPrev2(-1,<?php echo$treatmentID ?>)">Back</button>
    </div>
    </form>
  </div>
</div>
</td>
  </tr>      
<?php $i++;}

}else{?>
  <tr>
    <td colspan="6">No treatment provided yet...</td>
  </tr>
</table>
<?php } ?>
 </table>
</div>
<?php } ?>


<?php function my($clinicID,$vetID){ ?>
  <div style="width:92%;padding:2% 4%" >
    <br>
    <div class="add-new-treatment-container">
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search For Treatment" >
</div>
<br>
  <table class="treatment-table" border="0" id="treatment-table">
  <th style="width:40px">No</th>
  <th style="width:240px">Name</th>
  <th>Description</th>
  <th style="width:140px">Unit Price</th>
<?php 
include 'Connection.php';
$i=1;
$sql = "SELECT * FROM treatment t,vet_treatment vt WHERE vt.treatmentID=t.treatmentID AND vt.vetID= $vetID ORDER BY t.name ";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $clinicID=$row["clinicID"];
          $treatmentID=$row["treatmentID"];
          $name=$row["name"];
          $description=$row["description"];
          $unit_price=$row["unit_price"];
          ?>
    <tr>
    <td><?php echo $i?></td>
    <td><?php echo $name?></td>
    <td><?php echo $description?></td>
    <td>RM<?php echo $unit_price?></td>
  </tr>      
<?php $i++;}

}else{?>
  <tr>
    <td colspan="6">No treatment assigned yet...</td>
  </tr>
</table>
<?php } ?>
 </table>
</div>
<?php } ?>
</div>


<div id="treatmentModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>New Treatment</h2>
      <span class="close">&times;</span>
      </div>
  
    <form class="passwordForm" id="treatmentForm" action="Clinic-Treatment-Process.php?action=add" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="clinicID" value="<?php echo $clinicID ?>">
      <div class="tab" style="display:block">
        <table border="0">
        <tr>
          <td style="width: 36%;"><label>Treatment Name</label></td>
          <td>:</td>
          <td style="width:55%"><input type="text" name="name" required></td>
        </tr>
        <tr>
          <td style="width: 36%;"><label>Description</label></td>
          <td>:</td>
          <td style="width:55%"><textarea id="description" name="description" rows="4" cols="50"></textarea></td>
        </tr>
        <tr>
          <td style="width: 36%;"><label>Unit Price (RM)</label></td>
          <td>:</td>
          <td style="width:55%"><input type="number" name="price" required></td>
        </tr>
      </table>
    </div>
    <div class="tab" style="display:none">
        <p style="font-size: 25px;">Provided by:</p>
        <div class="treatment-assign-vet-container">
            <?php
            $sql2 = "SELECT * FROM vet WHERE clinicID = $clinicID AND ic REGEXP '^[0-9]+$'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
              // output data of each row
              while($row2 = $result2->fetch_assoc()) {
                $image=$row2["image"];
                $name=$row2["name"];
                $vetID=$row2["vetID"];
                $ic=$row2['ic'];

                if($image!=''){
                $imageData = base64_encode($image);
                $imageSrc2 = "data:image/jpg;base64," . $imageData;
                // Check if the image file exists before displaying it
                if (file_exists('vet_images/' . $image)) {
                    $imageSrc2 = 'vet_images/' . $image;
                }
                }
                else{
                  $gender=$ic[-1];
                  if( $gender% 2 == 0){
                    $imageSrc2='media/email_female.png';
                  }
                  else{
                    $imageSrc2='media/email_male.png';
                  }
                }     
          ?>
                <label class="assign-vet-container">
                  <img src="<?php echo $imageSrc2 ?>">
                  <p><?php echo $name ?></p>
                  <input type="checkbox" name="vet[]" onchange="changeColor(this)" value="<?php echo $vetID ?>">
                </label> 
              <?php }}else{ ?>
                <p>No vet...</p>
              <?php } ?>
        </div>
    </div>
      <div class="submit-button-container" style="margin-top:3%">
      <button class="submit-button" id="submitbtn" type="button" onclick="nextPrev(1)">Next</button>
      <button class="submit-button" id="closebtn" type="button" style="background-color: white;color: #4d4d4d;" onclick="nextPrev(-1)">Back</button>
    </div>
    </form>
  </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('treatment');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'my') {
    $('a[href*="Clinic-Treatment.php?treatment=my"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Clinic-Treatment.php?treatment=manage"]').css('border-bottom', '0');
  }
  else if (sValue === 'manage') {
    $('a[href*="Clinic-Treatment.php?treatment=manage"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="Clinic-Treatment.php?treatment=my"]').css('border-bottom', '0');
  } 
  else{
    $('a[href*="Clinic-Treatment.php?treatment=my"]').css('border-bottom', '5px solid #00a8de');
  }
});


function changeColor(checkbox) {
  var checkbox = document.getElementsByName(checkbox.name);
  for (var i = 0; i < checkbox.length; i++) {
    var checkboxLabel = checkbox[i].parentNode;
    if (checkbox[i].checked) {
      checkboxLabel.style.backgroundColor = "#cfe8fc";
      checkboxLabel.style.borderColor = "#6fb9f6";
    } else {
      checkboxLabel.style.backgroundColor = "white";
     checkboxLabel.style.borderColor = "#4d4d4d";
    }
  }
}

var modal2 = document.getElementById("treatmentModal");
var btn2 = document.getElementById("add-treatment-button");
var close2 = document.getElementById("closebtn");
var submit2 = document.getElementById("submitbtn");
var span2 = modal2.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn2.onclick = function() {
  modal2.style.display = "block"; 
  showTab(0);
}
// When the user clicks on <span> (x), close the modal
span2.onclick = function() {
  modal2.style.display = "none";
  document.getElementById("treatmentForm").reset();
  window.location.reload();
}

var currentTab =0;

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:

  if (n == 0) {
    document.getElementById("closebtn").style.display = "none";
  } else {
    document.getElementById("closebtn").style.display = "inline";
  }

  if (n == (x.length - 1)) {
    document.getElementById("submitbtn").innerHTML = "Submit";
  } else {
    document.getElementById("submitbtn").innerHTML = "Next";
  }
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 ){
    if (!validateForm(currentTab)) return false;
    
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

    document.getElementById("treatmentForm").submit();
      document.getElementById("treatmentForm").reset();
      document.getElementsByClassName('tab')[0].style.display="none";
      document.getElementsByClassName('tab')[1].style.display="none";
      var checkboxes = document.getElementsByName("vet[]");
      for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
        checkboxes[i].parentNode.style.backgroundColor = "white"; // Change background color to white
        checkboxes[i].parentNode.style.border = "1px solid #4d4d4d";

      }
        currentTab = 0;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm(x) {
  if (x==0 ){
  let a = document.forms["treatmentForm"]["name"].value;
  let b = document.forms["treatmentForm"]["description"].value;
  let c = document.forms["treatmentForm"]["price"].value;
  if (a == "" || b == "" || c == "") {
    alert("All fields must be filled out");
    return false;
  }
  else
    {return true;}
  }
  else{
    return true;
  }
}

function treatment_vet(treatmentID){
var modal3 = document.getElementById("treatment_vet_Modal"+treatmentID);
var span3 = modal3.getElementsByClassName("close")[0];

  modal3.style.display = "block"; 

// When the user clicks on <span> (x), close the modal
span3.onclick = function() {
  modal3.style.display = "none";
}
}

function edit_treatment(treatmentID){
var modal2 = document.getElementById("editModal"+treatmentID);
var close2 = document.getElementById("closebtn"+treatmentID);
var submit2 = document.getElementById("submitbtn"+treatmentID);
var span2 = modal2.getElementsByClassName("close")[0];

  modal2.style.display = "block"; 
  showTab2(0,treatmentID);

// When the user clicks on <span> (x), close the modal
span2.onclick = function() {
  modal2.style.display = "none";
  document.getElementById("edittreatmentForm"+treatmentID).reset();
  window.location.reload();
}
}

var currentTab2=0;
function showTab2(n,treatmentID) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("edittab"+treatmentID);
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("closebtn"+treatmentID).style.display = "none";
  } else {
    document.getElementById("closebtn"+treatmentID).style.display = "inline";
  }

  if (n == 1) {
    document.getElementById("submitbtn"+treatmentID).innerHTML = "Submit";
  } else {
    document.getElementById("submitbtn"+treatmentID).innerHTML = "Next";
  }
}

function nextPrev2(n,treatmentID) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("edittab"+treatmentID);
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 ){
    if (!validateForm2(currentTab,treatmentID)) return false;
    
    x[currentTab2].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab2 = currentTab2 + n;
    console.log("plus"+currentTab2);
  }
  if(n == -1){
    x[currentTab2].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab2 = currentTab2 + n;
    // if you have reached the end of the form...
    console.log("minus"+currentTab2);
  }
  if (currentTab2 >= x.length) {
    // ... the form gets submitted:
    console.log(currentTab2);
    document.getElementById("edittreatmentForm"+treatmentID).submit();
      document.getElementById("edittreatmentForm"+treatmentID).reset();
      document.getElementsByClassName('edittab'+treatmentID)[0].style.display="none";
      document.getElementsByClassName('edittab'+treatmentID)[1].style.display="none";
      currentTab2 = 0;
       setTimeout(function() {
    window.location.reload();
}, 400);
  }
  // Otherwise, display the correct tab:
  console.log("showtab");
  showTab2(currentTab2,treatmentID);
}

function validateForm2(x,treatmentID) {
  if (x==0 ){
  let a = document.forms["edittreatmentForm"+treatmentID]["name"].value;
  let b = document.forms["edittreatmentForm"+treatmentID]["description"].value;
  let c = document.forms["edittreatmentForm"+treatmentID]["price"].value;
  if (a == "" || b == "" || c == "") {
    alert("All fields must be filled out");
    return false;
  }
  else
    {return true;}
  }
  else{
    return true;
  }
}

function confirmDelete() {
  return confirm("Are you sure you want to delete this treatment?"); // Display confirmation dialog
}


function SearchFunction() {
  var input, filter, table, tr, td2, i, txtValue , txtValue2;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("treatment-table");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {

    td2 = tr[i].getElementsByTagName("td")[1];

   if (td2) {
      txtValue2 = td2.textContent || td2.innerText;
      if (txtValue2.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      }  else {
        tr[i].style.display = "none";
      }
    }     
    }      
    }
     
  

</script>

</body>
</html>