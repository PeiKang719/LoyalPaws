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
<script type="text/javascript">
  var counter = 0;

function expand(n) {
  number = n + counter;
  var x = document.getElementsByClassName("hideTable");
  var y = document.getElementById("educationModal-content");
  y.style.height = "auto";
  y.style.marginBottom = "7%";
  y.style.paddingBottom = "4%";
  x[number].style.display = "block";

  // Make the input fields within the displayed table focusable
  var inputFields = x[number].getElementsByTagName("input");
  for (var i = 0; i < inputFields.length; i++) {
    inputFields[i].disabled = false;
  }

  counter++;

  if (number == 4) {
    var z = document.getElementById("add-button-container");
    z.style.display = "none";
  }
}

var counter2 = 0;
function expand2(n) {
  number=n+counter2;
  var x = document.getElementsByClassName("hideTable2");
  var y = document.getElementById("experienceModal-content");
  y.style.height = "auto";
  y.style.marginBottom = "7%";
  y.style.paddingBottom = "4%";
  x[number].style.display = "block";
  counter2++;

  var inputFields = x[number].getElementsByTagName("input");
  for (var i = 0; i < inputFields.length; i++) {
    inputFields[i].disabled = false;
  }

    if(number==14){
    var z = document.getElementById("add-button-container2");
    z.style.display = "none";
  }
}

$(document).ready(function() {

    
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-preview').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    

    $(".file-upload").on('change', function(){
        readURL(this);
    });
    
    $("#upload-button").on('click', function() {
       $(".file-upload").click();
    });
});
</script>
</head>
<body>

<?php if(isset($_GET['vid'])){
include 'UserHeader.php';
} else{
include 'ClinicHeader.php';
} ?>
<?php include 'Connection.php'; ?>
<?php 
if(isset($_GET['id'])){
$id = $_GET['id'];
}elseif(isset($_GET['vid'])){
  $id = $_GET['vid'];
}
 ?>

<?php 
$sql = "SELECT * FROM vet WHERE vetID=$id";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $id=$row["vetID"];
          $username=$row["username"];
          $password=$row["password"];
          $name=$row["name"];
          $ic=$row["ic"];
          $email=$row["email"];
          $education=$row["education"];
          $experience=$row["experience"];
          $area=$row["area"];
          $phone=$row["phone"];
          $image=$row["image"];
       }
     }
   $areas = explode(",", $area);
    
if ($education=='') {
  $education='-';
}
if ($experience=='') {
  $experience='-';
}

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
<div class="container">
  <p class="profile-header">Vet Profile</p>
  <div class="profile-pic-container">
  <img class="profile-pic" src="<?php echo $imageSrc2 ?>"  alt="Profile image" >
  <?php if(isset($_SESSION['vetID'])){
       if($id!==$_SESSION['vetID']){ ?>
      <br><br><br>
     <?php } else{ ?>
  <div style="cursor: pointer;"  id="upload-button"><span class="material-symbols-outlined">edit_square</span>Edit Image</div>
  <?php }} ?>
</div>

<?php if(isset($_SESSION['adopterID'])){?>
  <br>
  <div style="width: 100%;display: flex;justify-content: center;align-items: center;">
  <button class="seller-chat-button" onclick="openChatModal()" style="width: 20%;"><span class="material-symbols-outlined" style="vertical-align:-3px;color:white" >chat</span>Chat</button>
</div>
<br>
<?php } ?>

  <table class="profile-table" border="0">
    <?php if(isset($_SESSION['vetID'])){
           if($id!==$_SESSION['vetID']){ ?>
      <br>
     <?php } else{ ?>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">account_circle</span></td>
      <td id="td1">Username</td>
      <td>:</td>
      <td id="td3"  colspan="3"><?php echo $username ?></td>
    </tr>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">key</span></td>
      <td id="td1">Password</td>
      <td>:</td>
      <td colspan="3"><button class="change-password" id="password-button">Change Password</button></td>
    </tr>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">badge</span></td>
      <td id="td1">IC Number</td>
      <td>:</td>
      <td colspan="3"><?php echo $ic ?></td>
    </tr>
  <?php }} ?>
    
    <tr>
      <td id="td2"><span class="material-symbols-outlined">person</span></td>
      <td id="td1">Name</td>
      <td>:</td>
      <td colspan="3"><?php echo $name ?></td>
    </tr>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">mail</span></td>
      <td id="td1">Email</td>
      <td>:</td>
      <td colspan="3"><?php echo $email ?></td>
    </tr>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">call</span></td>
      <td id="td1">Phone</td>
      <td>:</td>
      <td colspan="2" id="myPhone" style="transition:background-color 0.3s;"><?php echo $phone ?></td>
      <?php if(isset($_SESSION['adopterID']) || (isset($_SESSION['vetID'])) && $id!=$_SESSION['vetID']){?>
      <td><span class="material-symbols-outlined" id="edit-button1" style="display:none">edit</span></td>
    <?php }else{ ?>
      <td><span class="material-symbols-outlined" id="edit-button1">edit</span></td>
    <?php } ?>
    </tr>
    <?php if($education=='-'){ ?>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">school</span></td>
      <td id="td1">Education</td>
      <td>:</td>
      <td colspan="2"><?php echo $education ?></td>
      <?php if(isset($_SESSION['adopterID'])|| (isset($_SESSION['vetID'])) && $id!=$_SESSION['vetID']){?>
      <td><span class="material-symbols-outlined" id="edit-button2" style="display:none">edit</span></td>
    <?php }else{ ?>
      <td><span class="material-symbols-outlined" id="edit-button2">edit</span></td>
    <?php } ?>
    </tr>
  <?php } 
  else{?>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">school</span></td>
      <td id="td1">Education</td>
      <td>:</td>
          <?php
     $educations = explode("$", $education);

          for($b = 0; $b < count($educations); $b++){
          $details = explode("^", $educations[$b]); 
         ?>
         <?php if($b==0){?>
          <td class="year"><?php echo $details[0] ?></td>
          <td class="edu"><?php echo $details[1] ?></td>
          <?php if(isset($_SESSION['adopterID'])|| (isset($_SESSION['vetID'])) && $id!=$_SESSION['vetID']){?>
      <td><span class="material-symbols-outlined" id="edit-button2" style="display:none">edit</span></td>
    <?php }else{ ?>
      <td><span class="material-symbols-outlined" id="edit-button2">edit</span></td>
    <?php } ?>
    </tr>
    <tr>
      <td></td><td></td><td></td><td></td><td class="location"><?php echo $details[2] ?></td><td></td>
    </tr>
  <?php }
    elseif($b>0){?>
      <tr>
        <td></td><td></td><td></td>
        <td class="year"><?php echo $details[0] ?></td>
        <td class="edu"><?php echo $details[1] ?></td>
            <td></td>
      </tr>
      <tr>
        <td></td><td></td><td></td><td></td><td class="location"><?php echo $details[2] ?></td><td></td>
    </tr>
    
   <?php }
 }
}?>
    <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        <?php if($experience=='-'){ ?>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">business_center</span></td>
      <td id="td1">Experience</td>
      <td>:</td>
      <td colspan="2"><?php echo $experience ?></td>
      <?php if(isset($_SESSION['adopterID'])|| (isset($_SESSION['vetID'])) && $id!=$_SESSION['vetID']){?>
      <td><span class="material-symbols-outlined" id="edit-button3" style="display:none">edit</span></td>
    <?php }else{ ?>
      <td><span class="material-symbols-outlined" id="edit-button3">edit</span></td>
    <?php } ?>
    </tr>
  <?php } 
  else{?>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">business_center</span></td>
      <td id="td1">Experience</td>
      <td>:</td>
          <?php
     $experiences = explode("$", $experience);

          for($b = 0; $b < count($experiences); $b++){
          $details = explode("^", $experiences[$b]); 
         ?>
         <?php if($b==0){?>
          <td class="year2"><?php echo $details[0] ?></td>
          <td class="edu2"><?php echo $details[1] ?></td>
          <?php if(isset($_SESSION['adopterID'])|| (isset($_SESSION['vetID'])) && $id!=$_SESSION['vetID']){?>
      <td><span class="material-symbols-outlined" id="edit-button3" style="display:none">edit</span></td>
    <?php }else{ ?>
      <td><span class="material-symbols-outlined" id="edit-button3">edit</span></td>
    <?php } ?>
    </tr>
    <tr>
      <td></td><td></td><td></td><td></td><td class="location2"><?php echo $details[2] ?></td><td></td>
    </tr>
  <?php }
    elseif($b>0){?>
      <tr>
        <td></td><td></td><td></td>
        <td class="year2"><?php echo $details[0] ?></td>
        <td class="edu2"><?php echo $details[1] ?></td>
            <td></td>
      </tr>
      <tr>
        <td></td><td></td><td></td><td></td><td class="location2"><?php echo $details[2] ?></td><td></td>
    </tr>
   <?php }
 }
}?>
    <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">lab_research</span></td>
      <td id="td1">Area</td>
      <td>:</td>
      <?php for ($c=0; $c <count($areas) ; $c++) {
              if($c==0){?> 
        <td colspan="2" class="area"><p>- <?php echo $areas[$c]?></p></td>
      <?php if(isset($_SESSION['adopterID'])|| (isset($_SESSION['vetID'])) && $id!=$_SESSION['vetID']){?>
      <td><span class="material-symbols-outlined" id="edit-button4" style="display:none">edit</span></td>
    <?php }else{ ?>
      <td><span class="material-symbols-outlined" id="edit-button4">edit</span></td>
    <?php } ?>
    </tr>
      <?php }
      elseif($c>0){?>
         <tr>
      <td></td><td></td><td></td><td colspan="2" class="area"><p>- <?php echo $areas[$c]?></p></td><td></td>
          </tr>
      <?php }
      } ?> 
    
  </table>
</div>


<div id="picModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Profile Picture Preview</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="picForm" action="Clinic-Vet-Profile-Edit.php?c=pic" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
      
        <input class="file-upload" name="img" type="file" accept="image/*"/>
        <img class="profile-preview" name="img" src="<?php echo $imageSrc2 ?>"  alt="Profile image" >
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn6" type="submit">Submit</button>
      <button class="submit-button" id="closebtn6" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<?php if($id==$_SESSION['vetID']){ ?>
<div id="passwordModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      
      <h2>Change Password</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide"></iframe>
    <form class="passwordForm" id="passwordForm" action="Clinic-Vet-Profile-Edit.php?c=password" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
      <table border="0">
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">key</span></td>
          <td  style="width: 36%;"><label>Current Password</label></td>
          <td>:</td>
          <td style="width:55%"><input type="password" oninput="this.className = ''" name="old" required></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">lock</span></td>
          <td><label>New Password</label></td>
          <td>:</td>
          <td><input type="password" oninput="this.className = ''" name="new1" required></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">lock</span></td>
          <td><label>Confirm Password</label></td>
          <td>:</td>
          <td><input type="password" oninput="this.className = ''" name="new2" required></td>
        </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn1" type="submit">Submit</button>
      <button class="submit-button" id="closebtn1" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>
<?php } ?>

<div id="phoneModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Phone Number</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="phoneForm" action="Clinic-Vet-Profile-Edit.php?c=phone" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
      <table border="0">
        <tr>
          <td ><span class="material-symbols-outlined" style="font-size:30px">call</span></td>
          <td style="width: 36%;"><label>Current Phone No.</label></td>
          <td>:</td>
          <td style="width:55%"><p><?php echo$phone ?></p></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">call</span></td>
          <td><label>New Phone No.</label></td>
          <td>:</td>
          <td><input type="text" oninput="this.className = ''" name="phone" required></td>
        </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn2" type="submit">Submit</button>
      <button class="submit-button" id="closebtn2" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="educationModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content" id="educationModal-content">
    <div class="modal-header">
      <h2>Education Level</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="educationForm" id="educationForm" action="Clinic-Vet-Profile-Edit.php?c=education" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
      
        <?php
        $educations = explode("$", $education); 
        if($educations[0] == '-'){ ?>
        <div class="hideTable">
      <table class="educationTable" border="0">
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">calendar_month</span></td>
          <td style="width: 29%;"><label>Year</label></td>
          <td>:</td>
          <td><input type="text" oninput="this.className = ''" name="eduyear1[]" required></td>
          <td> to </td>
          <td><input type="text" oninput="this.className = ''" name="eduyear2[]" required></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">school</span></td>
          <td><label>Academic Level</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="education[]" required></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">location_on</span></td>
          <td><label>institution</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="eduinstitution[]" required></td>
        </tr>
      </table>
    </div>
    <?php for ($i=0; $i < 4 ; $i++) { ?>
      <div class="hideTable" style="display:none">
      <table class="educationTable"  border="0">
        <hr style="width: 93%;">
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">calendar_month</span></td>
          <td style="width: 29%;"><label>Year</label></td>
          <td>:</td>
          <td><input type="text" oninput="this.className = ''" name="eduyear1[]" disabled ></td>
          <td> to </td>
          <td><input type="text" oninput="this.className = ''" name="eduyear2[]" disabled></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">school</span></td>
          <td><label>Academic Level</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="education[]" disabled></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">location_on</span></td>
          <td><label>institution</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="eduinstitution[]" disabled></td>
        </tr>
      </table>
    </div>
   <?php } ?>
        <?php }

        else{ 
          $educations = explode("$", $education); 
         for($d = 0; $d < 5; $d++){
                  if(isset($educations[$d]) && $educations[$d] !==''){
                    $details = explode("^", $educations[$d]); 
                    $year12 = explode("-", $details[0]);    ?>
                      <div class="hideTable">
                      <table class="educationTable" border="0">
                        <hr style="width: 93%;">
                      <tr>
                        <td><span class="material-symbols-outlined" style="font-size:30px">calendar_month</span></td>
                        <td style="width: 29%;"><label>Year</label></td>
                        <td>:</td>
                        <td><input type="text" oninput="this.className = ''" name="eduyear1[]" value="<?php echo $year12[0]?>"></td>
                        <td> to </td>
                        <td><input type="text" oninput="this.className = ''" name="eduyear2[]"  value="<?php echo$year12[1]?>"></td>
                      </tr>
                      <tr>
                        <td><span class="material-symbols-outlined" style="font-size:30px">school</span></td>
                        <td><label>Academic Level</label></td>
                        <td>:</td>
                        <td colspan="3"><input type="text" oninput="this.className = ''" name="education[]"  value="<?php echo$details[1]?>"></td>
                      </tr>
                      <tr>
                        <td><span class="material-symbols-outlined" style="font-size:30px">location_on</span></td>
                        <td><label>institution</label></td>
                        <td>:</td>
                        <td colspan="3"><input type="text" oninput="this.className = ''" name="eduinstitution[]"  value="<?php echo$details[2]?>"></td>
                      </tr>
                    </table>
                  </div>
                  <script>
                    expand(1);
                  </script>
                 <?php }
                 else{?>
                    <div class="hideTable" style="display:none">
                    <table class="educationTable"  border="0">
                      <hr style="width: 93%;">
                      <tr>
                        <td><span class="material-symbols-outlined" style="font-size:30px">calendar_month</span></td>
                        <td style="width: 29%;"><label>Year</label></td>
                        <td>:</td>
                        <td><input type="text" oninput="this.className = ''" name="eduyear1[]" disabled ></td>
                        <td> to </td>
                        <td><input type="text" oninput="this.className = ''" name="eduyear2[]" disabled></td>
                      </tr>
                      <tr>
                        <td><span class="material-symbols-outlined" style="font-size:30px">school</span></td>
                        <td><label>Academic Level</label></td>
                        <td>:</td>
                        <td colspan="3"><input type="text" oninput="this.className = ''" name="education[]" disabled></td>
                      </tr>
                      <tr>
                        <td><span class="material-symbols-outlined" style="font-size:30px">location_on</span></td>
                        <td><label>institution</label></td>
                        <td>:</td>
                        <td colspan="3"><input type="text" oninput="this.className = ''" name="eduinstitution[]" disabled></td>
                      </tr>
                    </table>
                  </div>
            <?php
                 }
              }
            }
         ?>
        
      <div class="add-button-container" id="add-button-container" onclick="expand(1)">
      <span class="material-symbols-outlined" id="add-button">add_circle</span>
      <p>Add More</p>
    </div>
    <div class="submit-button-container">
      <button class="submit-button" id="submitbtn3" type="submit">Submit</button>
      <button class="submit-button" id="closebtn3" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="experienceModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content" id="experienceModal-content">
    <div class="modal-header">
      <h2>Experience</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="educationForm" id="experienceForm" action="Clinic-Vet-Profile-Edit.php?c=experience" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">

      <?php
        $experiences = explode("$", $experience); 
        if($experiences[0] == '-'){ ?>
      <div class="hideTable2">
      <table border="0">
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">calendar_month</span></td>
          <td style="width: 23%;"><label>Year</label></td>
          <td>:</td>
          <td><input type="text" oninput="this.className = ''" name="expyear1[]" required></td>
          <td> to </td>
          <td><input type="text" oninput="this.className = ''" name="expyear2[]" required></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">business_center</span></td>
          <td><label>Position</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="position[]" required></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">location_on</span></td>
          <td><label>institution</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="expinstitution[]" required></td>
        </tr>
      </table>
    </div>
    <?php for ($i=0; $i < 14 ; $i++) { ?>
      <div class="hideTable2" style="display:none">
      <table border="0">
        <hr style="width: 93%;">
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">calendar_month</span></td>
          <td style="width: 23%;"><label>Year</label></td>
          <td>:</td>
          <td><input type="text" oninput="this.className = ''" name="expyear1[]" disabled></td>
          <td> to </td>
          <td><input type="text" oninput="this.className = ''" name="expyear2[]" disabled></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">business_center</span></td>
          <td><label>Position</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="position[]" disabled></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">location_on</span></td>
          <td><label>institution</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="expinstitution[]" disabled></td>
        </tr>
      </table>
    </div>
   <?php }} 

    else{ 
          $experiences = explode("$", $experience); 
         for($e = 0; $e < 15; $e++){
                  if(isset($experiences[$e]) && $experiences[$e] !==''){
                    $expdetails = explode("^", $experiences[$e]); 
                    $expyear12 = explode("-", $expdetails[0]);    ?>

          <div class="hideTable2">
      <table border="0">
        <hr style="width: 93%;">
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">calendar_month</span></td>
          <td style="width: 23%;"><label>Year</label></td>
          <td>:</td>
          <td><input type="text" oninput="this.className = ''" name="expyear1[]"  value="<?php echo $expyear12[0]?>"></td>
          <td> to </td>
          <td><input type="text" oninput="this.className = ''" name="expyear2[]"  value="<?php echo $expyear12[1]?>"></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">business_center</span></td>
          <td><label>Position</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="position[]" value="<?php echo $expdetails[1]?>"></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">location_on</span></td>
          <td><label>institution</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="expinstitution[]" value="<?php echo $expdetails[2]?>"></td>
        </tr>
      </table>
    </div>
    <script>
      expand2(1);
    </script>
   <?php }
   else{?>
    <div class="hideTable2" style="display:none">
      <table border="0">
        <hr style="width: 93%;">
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">calendar_month</span></td>
          <td style="width: 23%;"><label>Year</label></td>
          <td>:</td>
          <td><input type="text" oninput="this.className = ''" name="expyear1[]" disabled></td>
          <td> to </td>
          <td><input type="text" oninput="this.className = ''" name="expyear2[]" disabled></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">business_center</span></td>
          <td><label>Position</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="position[]" disabled></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">location_on</span></td>
          <td><label>institution</label></td>
          <td>:</td>
          <td colspan="3"><input type="text" oninput="this.className = ''" name="expinstitution[]" disabled></td>
        </tr>
      </table>
    </div>
    <?php
                 }
              }
            }
         ?>
      <div class="add-button-container" id="add-button-container2" onclick="expand2(1)">
      <span class="material-symbols-outlined" id="add-button">add_circle</span>
      <p>Add More</p>
    </div>
    <div class="submit-button-container">
      <button class="submit-button" id="submitbtn4" type="submit">Submit</button>
      <button class="submit-button" id="closebtn4" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="areaModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Focus Area</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="areaForm" action="Clinic-Vet-Profile-Edit.php?c=area" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
      <table border="0" width="100%" style="margin-top:-20px">
          <tr >
        <td style="width:33%;text-align:center;padding: 5px 10px;"><label class="check-container" style="<?php if(in_array("Prevention Care", $areas)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>">Prevention Care
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Prevention Care" <?php if(in_array("Prevention Care", $areas)){ echo "checked";} ?>>
            <span class="checkmark3"></span>
        </label></td>
         <td style="width:33%;text-align:center;padding: 5px 10px;"><label class="check-container" style="<?php if(in_array("Surgery", $areas)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>">Surgery
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Surgery" <?php if(in_array("Surgery", $areas)){ echo "checked";} ?>>
            <span class="checkmark3"></span>
        </label></td>
        <td style="text-align:center;padding: 5px 10px;"><label class="check-container" style="<?php if(in_array("Nutrition and diet", $areas)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>">Nutrition and diet
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Nutrition and diet" <?php if(in_array("Nutrition and diet", $areas)){ echo "checked";} ?>>
            <span class="checkmark3"></span>
        </label></td>
    </tr>
         <tr>
         <td style="text-align:center;padding: 5px 10px;"><label class="check-container" style="padding-top:30px;height: 50px;<?php if(in_array("Emergency and critical care", $areas)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>">Emergency and critical care
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Emergency and critical care" <?php if(in_array("Emergency and critical care", $areas)){ echo "checked";} ?>>
            <span class="checkmark3"></span>
        </label></td>
        <td style="text-align:center;padding: 5px 10px;"> <label class="check-container" style="<?php if(in_array("End-of-life care", $areas)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>">End-of-life care
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="End-of-life care" <?php if(in_array("End-of-life care", $areas)){ echo "checked";} ?>>
            <span class="checkmark3"></span>
        </label></td>
    <td style="width:33%;text-align:center;padding: 5px 10px;"><label class="check-container" style="<?php if(in_array("Diagnostic services", $areas)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>">Diagnostic services
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Diagnostic services" <?php if(in_array("Diagnostic services", $areas)){ echo "checked";} ?>>
            <span class="checkmark3"></span>
        </label></td>
    </tr>
    <tr>
      <td></td>
        <td style="text-align:center;padding: 5px 10px;"> <label class="check-container" style="<?php if(in_array("Rehabilitation", $areas)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>">Rehabilitation
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Rehabilitation" <?php if(in_array("Rehabilitation", $areas)){ echo "checked";} ?>>
            <span class="checkmark3"></span>
        </label></td>
        <td></td>
    </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn5" type="submit">Submit</button>
      <button class="submit-button" id="closebtn5" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>


<?php if(isset($_SESSION['adopterID'])){?>
<div id="chatModal" class="chat-modal">
    <?php
    include 'Connection.php';
    if (isset($_GET['vid'])) {
        $vid = $_GET['vid'];
        $sql = "SELECT * FROM vet WHERE vetID = $vid"; 
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $vname = $row['name'];
        $sellerID = $row['vetID'];
        $image = $row['image'];
        $ic = $row['ic'];
        $adopterID = $_SESSION['adopterID'];
        $column = 3;

        if($image!=''){
        $imageData = base64_encode($image);
        $imageSrc = "data:image/jpg;base64," . $imageData;
        // Check if the image file exists before displaying it
        if (file_exists('vet_images/' . $image)) {
            $imageSrc = 'vet_images/' . $image;
        }
        }
        else{
          $gender=$ic[-1];
          if( $gender% 2 == 0){
            $imageSrc='media/email_female.png';
          }
          else{
            $imageSrc='media/email_male.png';
          }
        }
    }
    ?>

    <!-- Modal content -->
    <div class="chat-modal-content">
        <div class="chat-modal-header">
          <img src="<?php echo $imageSrc ?>">
            <h2 style="color:white"><?php echo $vname ?></h2>
            <span class="close" onclick="closeChatModal()">&times;</span>
        </div>
        <div class="message-container"  id="chatbox">
        
        </div>
        <div class="chat-button-container">
        <input type="text" id="message" placeholder="Type your message" onkeydown="handleEnter(event)">
      <button id="send">Send  <span class="material-symbols-outlined" id="send-icon">send</span></button>
    </div>
    </div>
</div>
<?php } ?>

<script type="text/javascript">
  const sidebarItems = document.querySelectorAll('.sidebar-item');

  // loop through each item
  sidebarItems.forEach(item => {
    // check if the item or any of its child links is the current active URL
    if (window.location.href.includes(item.href) ||
        item.querySelector('a')?.href === window.location.href) {
      // add the active class to the item
      item.classList.add('active');
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
     checkboxLabel.style.borderColor = "#b3b3b3";
    }
  }
}

document.addEventListener("DOMContentLoaded", function() {
    var editButton2 = document.getElementById("edit-button1");
    var myPhone = document.getElementById("myPhone");
    var editButton = document.getElementById("edit-button2");
    var eduElements = Array.from(document.getElementsByClassName("edu"));
    var yearElements = Array.from(document.getElementsByClassName("year"));
    var locationElements = Array.from(document.getElementsByClassName("location"));
    var editButton3 = document.getElementById("edit-button3");
    var eduElements2 = Array.from(document.getElementsByClassName("edu2"));
    var yearElements2 = Array.from(document.getElementsByClassName("year2"));
    var locationElements2 = Array.from(document.getElementsByClassName("location2"));
    var editButton4 = document.getElementById("edit-button4");
    var areaElements = Array.from(document.getElementsByClassName("area"));


    editButton2.addEventListener("mouseenter", function() {
        myPhone.classList.add("highlighted");
    });

    editButton2.addEventListener("mouseleave", function() {
      myPhone.classList.remove("highlighted");
    });

    editButton.addEventListener("mouseenter", function() {
      eduElements.forEach(function(element) {
        element.classList.add("highlighted");
      });

      yearElements.forEach(function(element) {
        element.classList.add("highlighted");
      });

      locationElements.forEach(function(element) {
        element.classList.add("highlighted");
      });

      editButton.classList.add("hover-edit");
    });

    editButton.addEventListener("mouseleave", function() {
      eduElements.forEach(function(element) {
        element.classList.remove("highlighted");
      });

      yearElements.forEach(function(element) {
        element.classList.remove("highlighted");
      });

      locationElements.forEach(function(element) {
        element.classList.remove("highlighted");
      });

      editButton.classList.remove("hover-edit");
    });

    editButton3.addEventListener("mouseenter", function() {
      eduElements2.forEach(function(element) {
        element.classList.add("highlighted");
      });

      yearElements2.forEach(function(element) {
        element.classList.add("highlighted");
      });

      locationElements2.forEach(function(element) {
        element.classList.add("highlighted");
      });

      editButton3.classList.add("hover-edit");
    });

    editButton3.addEventListener("mouseleave", function() {
      eduElements2.forEach(function(element) {
        element.classList.remove("highlighted");
      });

      yearElements2.forEach(function(element) {
        element.classList.remove("highlighted");
      });

      locationElements2.forEach(function(element) {
        element.classList.remove("highlighted");
      });

      editButton3.classList.remove("hover-edit");
    });

    editButton4.addEventListener("mouseenter", function() {
      areaElements.forEach(function(element) {
        element.classList.add("highlighted");
      });

      editButton4.classList.add("hover-edit");
    });

    editButton4.addEventListener("mouseleave", function() {
      areaElements.forEach(function(element) {
        element.classList.remove("highlighted");
      });

      editButton4.classList.remove("hover-edit");
    });
  });

</script>

<?php if($id==$_SESSION['vetID']){?>
  <script type="text/javascript">
    var modal2 = document.getElementById("phoneModal");
var btn2 = document.getElementById("edit-button1");
var close2 = document.getElementById("closebtn2");
var submit2 = document.getElementById("submitbtn2");
var span2 = modal2.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn2.onclick = function() {
  modal2.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span2.onclick = function() {
  modal2.style.display = "none";
  document.getElementById("phoneForm").reset();
  window.location.reload();
}

close2.onclick = function() {
  modal2.style.display = "none";
  document.getElementById("phoneForm").reset();
  window.location.reload();
}

submit2.onclick = function() {
  setTimeout(function() {
    document.getElementById("phoneForm").reset();
  }, 500);
};

var modal3 = document.getElementById("educationModal");
var btn3 = document.getElementById("edit-button2");
var close3 = document.getElementById("closebtn3");
var submit3 = document.getElementById("submitbtn3");
var span3 = modal3.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn3.onclick = function() {
  modal3.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span3.onclick = function() {
  modal3.style.display = "none";
  document.getElementById("educationForm").reset();
  window.location.reload();
}

close3.onclick = function() {
  modal3.style.display = "none";
  document.getElementById("educationForm").reset();
  window.location.reload();
}

submit3.onclick = function() {
  setTimeout(function() {
    document.getElementById("educationForm").reset();
  }, 500);
};

var modal4 = document.getElementById("experienceModal");
var btn4 = document.getElementById("edit-button3");
var close4 = document.getElementById("closebtn4");
var submit4= document.getElementById("submitbtn4");
var span4 = modal4.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn4.onclick = function() {
  modal4.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span4.onclick = function() {
  modal4.style.display = "none";
  document.getElementById("experienceForm").reset();
  window.location.reload();
}

close4.onclick = function() {
  modal4.style.display = "none";
  document.getElementById("experienceForm").reset();
  window.location.reload();
}

submit4.onclick = function() {
  setTimeout(function() {
    document.getElementById("experienceForm").reset();
  }, 500);
};

var modal5 = document.getElementById("areaModal");
var btn5 = document.getElementById("edit-button4");
var close5 = document.getElementById("closebtn5");
var submit5 = document.getElementById("submitbtn5");
var span5 = modal5.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn5.onclick = function() {
  modal5.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span5.onclick = function() {
  modal4.style.display = "none";
  document.getElementById("areaForm").reset();
  window.location.reload();
}

close5.onclick = function() {
  modal5.style.display = "none";
  document.getElementById("areaForm").reset();
  window.location.reload();
}

submit5.onclick = function() {
  setTimeout(function() {
    document.getElementById("areaForm").reset();
  }, 500);
};

var modal6 = document.getElementById("picModal");
var btn6 = document.getElementById("upload-button");
var close6 = document.getElementById("closebtn6");
var submit6 = document.getElementById("submitbtn6");
var span6 = modal6.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn6.onclick = function() {
  modal6.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span6.onclick = function() {
  modal6.style.display = "none";
  document.getElementById("picForm").reset();
  window.location.reload();
}

close6.onclick = function() {
  modal6.style.display = "none";
  document.getElementById("picForm").reset();
  window.location.reload();
}

submit6.onclick = function() {
  setTimeout(function() {
    document.getElementById("passwordForm").reset();
  }, 500);
};

    var modal = document.getElementById("passwordModal");
var btn = document.getElementById("password-button");
var close = document.getElementById("closebtn1");
var submit = document.getElementById("submitbtn1");
var span = modal.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  document.getElementById("passwordForm").reset();
  window.location.reload();
}

close.onclick = function() {
  modal.style.display = "none";
  document.getElementById("passwordForm").reset();
  window.location.reload();
}

submit.onclick = function() {
  setTimeout(function() {
    document.getElementById("passwordForm").reset();
  }, 500);
};
  </script>
<?php } ?>


<?php if(isset($_GET['vid'])){?>
  <script type="text/javascript">
   function openChatModal() {
    var modal = document.getElementById("chatModal");
    modal.style.display = "block";
}

function closeChatModal() {
  var modal = document.getElementById("chatModal");
  
  modal.classList.add("exit-animation");
  setTimeout(function() {
    modal.style.display = "none";
    modal.classList.remove("exit-animation");
  }, 500); // Delay of 0.5 seconds (500 milliseconds)

}



    $(document).ready(function() {
      // Retrieve initial chat messages
      var sellerID = <?php echo $sellerID; ?>;
     var adopterID = <?php echo $adopterID; ?>;
     var column = <?php echo $column; ?>; 
      retrieveMessages(sellerID, adopterID,column);

      // Send new message
      $('#send').click(function() {
        var message = $('#message').val();
        sendMessage(message, sellerID, adopterID,column);
        $('#message').val('');
        console.log(column);
        console.log(sellerID);
        console.log(adopterID);
      });
      // Poll server for new messages every 2 seconds
       setInterval(function() {
        retrieveMessages(sellerID, adopterID,column);
      }, 1500);
       setTimeout(scrollToBottom, 1500);
    });

    function handleEnter(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            var message = $('#message').val();
            var sellerID = <?php echo $sellerID; ?>;
          var adopterID = <?php echo $adopterID; ?>;
          var column = <?php echo $column; ?>; 
            sendMessage(message, sellerID, adopterID,column);
            $('#message').val('');       
        }

        setTimeout(scrollToBottom, 1500);
    }

    function retrieveMessages(sellerID, adopterID,column) {
      $.ajax({
        url: 'chat-get-message.php',
        method: 'GET',
        data: { sellerID: sellerID, adopterID: adopterID, column:column },
      success: function(response) {
      $('#chatbox').html(response);
        }
      });
      setTimeout(scrollToBottom, 1500);
    }

    function sendMessage(message, sellerID, adopterID,column) {
      $.ajax({
        url: 'chat-user-send-message.php',
        method: 'POST',
         data: { message: message, sellerID: sellerID, adopterID: adopterID, column:column },
      success: function(response) {
        console.log('Message sent');
        console.log(column);
        console.log(sellerID);
        console.log(adopterID);
        }
      });
      setTimeout(scrollToBottom, 1500);
    }

    function scrollToBottom() {
        var chatbox = document.getElementById('chatbox');
        chatbox.scrollTop = chatbox.scrollHeight;
    }

    // Scroll to bottom when the page loads
    window.onload = function() {
        scrollToBottom();
    };
  </script>
<?php } ?>
</body>
</html>