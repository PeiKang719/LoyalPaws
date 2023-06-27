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
$(document).ready(function() {
    var readURL = function(input, imgElement) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                imgElement.attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".file-upload").on('change', function(){
        var fileInput = $(this);
        var imgElement = fileInput.siblings('.profile-preview');
        readURL(this, imgElement);
    });
    
    $("#pp").on('click', function() {
       $(".file-upload").click();
    });

    $(".file-upload2").on('change', function(){
        var fileInput = $(this);
        var imgElement = fileInput.siblings('.profile-preview2');
        readURL(this, imgElement);
    });
    
    $("#cp").on('click', function() {
       $(".file-upload2").click();
    });
});

</script>
</head>
<body>
<?php include 'ClinicHeader.php'; ?>
<?php include 'Connection.php'; ?>

<?php 
$sql = "SELECT * FROM clinic WHERE clinicID= $clinicID ";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $id=$row["clinicID"];
          $name=$row["name"];
          $phone=$row["phone"];
          $email=$row["email"];
          $state=$row["state"];
          $area=$row["area"];
          $address=$row["address"];
          $description=$row["description"];
          $discount=$row["discount_percent"];
          $image=$row["clinic_image"];
          $cover=$row["cover"];
          $days = explode(",", $row["work_day"]);
          $opens = explode(",", $row["open_time"]);
          $closes = explode(",", $row["close_time"]);
          
       }
     }
$date = array("Sunday", "Monday", "Tuesday","Wednesday","Thursday","Friday","Saturday");
$count = count($days);

if($image!=''){
$imageData = base64_encode($image);
$imageSrc2 = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if (file_exists('clinic_images/' . $image)) {
    $imageSrc2 = 'clinic_images/' . $image;
}
}
else{
    $imageSrc2='media/clinic.png';
  }

if($cover!=''){
$imageData2 = base64_encode($cover);
$imageSrc3 = "data:image/jpg;base64," . $imageData2;
// Check if the image file exists before displaying it
if (file_exists('clinic_covers/' . $cover)) {
    $imageSrc3 = 'clinic_covers/' . $cover;
}
}
else{
    $imageSrc3='media/clinic_cover.png';
  }


?>


<div class="container">
  <p class="profile-header">Clinic Profile</p>
  <br>
  <div class="profile-pic-container">
  <img src="<?php echo $imageSrc3 ?>" width="100%" height="300px" style="border-radius:15px;border:1px solid #4d4d4d;">
  <img class="profile-pic2" src="<?php echo $imageSrc2 ?>"  alt="Profile image" >
  <div style="cursor: pointer;"  id="upload-button"><span class="material-symbols-outlined">edit_square</span>Edit Image</div>
</div>

  <table class="profile-table" border="0">
    <tr>
      <td id="td2"><span class="material-symbols-outlined">local_hospital</span></td>
      <td id="td1">Name</td>
      <td>:</td>
      <td id="clinic_name" colspan="4" style="transition:background-color 0.3s;"><?php echo $name ?></td>
      <td><span class="material-symbols-outlined" id="edit-button1">edit</span></td>
    </tr>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">mail</span></td>
      <td id="td1">Email</td>
      <td>:</td>
      <td colspan="5"  id="td3"><?php echo $email ?></td>
    </tr>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">distance</span></td>
      <td id="td1">Address</td>
      <td>:</td>
      <td colspan="4" id="clinic_address" style="transition:background-color 0.3s;"><?php echo $address ?>,<?php echo $area ?>,<?php echo $state ?></td>
      <td><span class="material-symbols-outlined" id="edit-button2">edit</span></td>
    </tr>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">volunteer_activism</span></td>
      <td id="td1">Discount</td>
      <td>:</td>
      <td colspan="4" id="clinic_discount" style="transition:background-color 0.3s;"><?php echo $discount ?> %</td>
      <td><span class="material-symbols-outlined" id="edit-button3">edit</span></td>
    </tr>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">call</span></td>
      <td id="td1">Phone</td>
      <td>:</td>
      <td colspan="4" id="clinic_phone" style="transition:background-color 0.3s;"><?php echo $phone ?></td>
      <td><span class="material-symbols-outlined" id="edit-button4">edit</span></td>
    </tr>
    <tr>
      <td colspan="7"></td>
    </tr>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">description</span></td>
      <td id="td1">About me</td>
      <td>:</td>
      <td colspan="4" id="clinic_description" style="transition:background-color 0.3s;white-space: pre-line;word-wrap: break-word;"><?php echo $description ?></td>
      <td><span class="material-symbols-outlined" id="edit-button5">edit</span></td>
    </tr>
    <tr>
      <td colspan="7"></td>
    </tr>
    <tr>
      <td id="td2"><span class="material-symbols-outlined">calendar_month</span></td>
      <td id="td1" style="width: 19%;">Working Hour</td>
      <td>:</td>
      <?php
      $i=0;
      for($j = 0; $j < count($date); $j++) {
        
              if(in_array($date[$j], $days) && $j==0){
              echo "<td class='date' style='transition:background-color 0.3s;'><p> Sunday </p></td>";
              echo "<td align=center class='time' style='transition:background-color 0.3s;'><p > $opens[$i] </p></td>";
              echo "<td align=center class='nothing' style='transition:background-color 0.3s;'><p > - </p></td>";
              echo "<td align=center class='time' style='transition:background-color 0.3s;'><p> $closes[$i] </p></td>";
              echo "<td><span class='material-symbols-outlined' id='edit-button6'>edit</span></td></tr>";
              $i++;
              }
                elseif(!in_array($date[$j], $days) && $j==0){
              echo "<td class='nothing' style='transition:background-color 0.3s;'><p > Sunday </p></td>";
              echo "<td colspan=3 align=center class='nothing' style='transition:background-color 0.3s;'><p >Closed </p></td>";
              echo "<td><span class='material-symbols-outlined' id='edit-button6'>edit</span></td></tr>";
              }
                elseif(in_array($date[$j], $days) && $j>0){
              echo "<tr><td></td><td></td><td></td>";
              echo "<td class='date' style='transition:background-color 0.3s;'><p > $date[$j] </p></td>";
              echo "<td align=center class='time' style='transition:background-color 0.3s;'><p> $opens[$i] </p></td>";
              echo "<td align=center class='nothing' style='transition:background-color 0.3s;'><p > - </p></td>";
              echo "<td align=center class='time' style='transition:background-color 0.3s;'><p > $closes[$i] </p></td><td></td></tr>";
              $i++;
              }
                else{
              echo "<tr><td></td><td></td><td></td>";
              echo "<td class='date' style='transition:background-color 0.3s;'><p > $date[$j] </p></td>";
              echo "<td colspan=3 align=center class='nothing' style='transition:background-color 0.3s;'><p>Closed </p></td><td></td></tr>";
              }
            }
          
              ?>
  </table>
</div>

<div id="chooseModal" class="modal" style="padding-top:150px">
  <!-- Modal content -->
  <div class="modal-content" style="width:40%;height:60%">
    <div class="modal-header">
      <h2>Edit Picture</h2>
      <span class="close">&times;</span>
      </div>
      <div class="edit-image-choose-container">
        <p>I want to edit:</p>
        <button class="edit-image-choose" id="pp">Profile Picture</button>
        <button class="edit-image-choose" id="cp">Cover Picture</button>
  </div>
</div>
</div>

<div id="picModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content" style="animation: scale-in-center 0.3s ;">
    <div class="modal-header">
      <h2>Profile Picture Preview</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="picForm" action="Clinic-Clinic-Profile-Edit.php?c=pic" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
      
        <input class="file-upload" id="file-upload" name="img" type="file" accept="image/*"/>
        <img class="profile-preview" name="img" src="<?php echo $imageSrc2 ?>"  alt="Profile image" >
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn" type="submit">Submit</button>
      <button class="submit-button" id="closebtn" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="coverModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content" style="animation: scale-in-center 0.3s ;">
    <div class="modal-header">
      <h2>Cover Picture Preview</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="coverForm" action="Clinic-Clinic-Profile-Edit.php?c=cover" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
      
        <input class="file-upload2" id="file-upload2" name="img" type="file" accept="image/*"/>
        <img class="profile-preview2" name="img" src="<?php echo $imageSrc3 ?>"  alt="Cover image" >
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn0" type="submit">Submit</button>
      <button class="submit-button" id="closebtn0" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="nameModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Clinic Name</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="nameForm" action="Clinic-Clinic-Profile-Edit.php?c=name" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
        <table border="0">
        <tr>
          <td ><span class="material-symbols-outlined" style="font-size:30px">local_hospital</span></td>
          <td style="width: 36%;"><label>Current Clinic Name</label></td>
          <td>:</td>
          <td style="width:55%"><p><?php echo$name ?></p></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">local_hospital</span></td>
          <td><label>New Clinic Name</label></td>
          <td>:</td>
          <td><input type="text" oninput="this.className = ''" name="new" required></td>
        </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn2" type="submit">Submit</button>
      <button class="submit-button" id="closebtn2" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="addressModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Clinic Address</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="addressForm" action="Clinic-Clinic-Profile-Edit.php?c=address" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
        <table border="0">
        <tr>
          <td ><span class="material-symbols-outlined" style="font-size:30px">Distance</span></td>
          <td style="width: 36%;"><label>Current Address</label></td>
          <td>:</td>
          <td style="width:55%" colspan="2"><p><?php echo $address ?>,<?php echo $area ?>,<?php echo $state ?></p></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">Distance</span></td>
          <td><label>New Address</label></td>
          <td>:</td>
          <td colspan="2"><input type="text" oninput="this.className = ''" name="address" placeholder="Building no. and street" required></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td><select name="state" required >
              <option value="" disabled selected>Select state</option>
              <option>Johor</option>
              <option>Melaka</option>
              <option>Kuala Lumpur</option>
          </select>
          </td>
          <td>
           <select name="area" required >
              <option value="" disabled selected>Select area</option>
              <option>Johor Bahru</option>
              <option>Batu Pahat</option>
              <option>Segamat</option>
          </select>
        </td>
        </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn3" type="submit">Submit</button>
      <button class="submit-button" id="closebtn3" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="discountModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Discount Percentage</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="discountForm" action="Clinic-Clinic-Profile-Edit.php?c=discount" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
        <table border="0">
        <tr>
          <td ><span class="material-symbols-outlined" style="font-size:30px">volunteer_activism</span></td>
          <td style="width: 36%;"><label>Current Discount (%)</label></td>
          <td>:</td>
          <td style="width:55%"><p><?php echo$discount ?></p></td>
        </tr>
        <tr>
          <td><span class="material-symbols-outlined" style="font-size:30px">volunteer_activism</span></td>
          <td><label>New Discount (%)</label></td>
          <td>:</td>
          <td><input type="text" oninput="this.className = ''" name="new" required></td>
        </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn4" type="submit">Submit</button>
      <button class="submit-button" id="closebtn4" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="phoneModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Phone Number</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="phoneForm" action="Clinic-Clinic-Profile-Edit.php?c=phone" method="post" target="hiddenFrame" enctype="multipart/form-data">
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
          <td><input type="text" oninput="this.className = ''" name="new" required></td>
        </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn5" type="submit">Submit</button>
      <button class="submit-button" id="closebtn5" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="descriptionModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>About Me</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="passwordForm" id="aboutForm" action="Clinic-Clinic-Profile-Edit.php?c=description" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
        <table border="0">
        <tr>
          <td ><span class="material-symbols-outlined" style="font-size:30px">description</span></td>
          <td style="width: 20%;"><label>About Me</label></td>
          <td>:</td>
          <td style="width:75%"><textarea id="description-clinic" maxlength="1000" placeholder="Write something to describe the clinic...(max 1000 characters)" name="description" required style="height:270px;width: 100%;"><?php echo $description ?></textarea></td>
        </tr>
      </table>
      <div class="submit-button-container">
      <button class="submit-button" id="submitbtn6" type="submit">Submit</button>
      <button class="submit-button" id="closebtn6" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>

<div id="workingModal" class="modal" style=";padding-top:30px">
  <!-- Modal content -->
  <div class="modal-content" style="height:90%">
    <div class="modal-header">
      <h2>Working Hours</h2>
      <span class="close">&times;</span>
      </div>
      <iframe name="hiddenFrame" class="hide" style="display: none;"></iframe>
    <form class="workingForm" id="workingForm" action="Clinic-Clinic-Profile-Edit.php?c=working" method="post" target="hiddenFrame" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
        <table border="0">
        <tr>
          <td ><span class="material-symbols-outlined" style="font-size:30px">calendar_month</span></td>
          <td style="width: 25%;"><label>Working Hours</label></td>
          <td>:</td>
        <?php
      $i=0;
      for($j = 0; $j < count($date); $j++) {
        
              if(in_array($date[$j], $days) && $j==0){
              echo "<td ><p> Sunday </p></td>";
              echo"<td><label class='switch' for='checkbox7'><input type='checkbox' id='checkbox7' name='workingday[]' value='Sunday' checked/><div class='slider round'></div></label></td>";
              echo "<td style='text-align: center;'><input type='time' name='opentime[]' value='$opens[$i]'> </td>";
              echo "<td align=center><p> to </p></td>";
              echo "<td style='text-align: center;'><input type='time' name='closetime[]' value='$closes[$i]'> </td></tr>";
              $i++;
              }
                elseif(!in_array($date[$j], $days) && $j==0){
              echo "<td ><p> Sunday </p></td>";
              echo"<td><label class='switch' for='checkbox$j'><input type='checkbox' id='checkbox$j' name='workingday[]' value='$date[$j]'/><div class='slider round'></div></label></td>";
              echo "<td style='text-align: center;'><input type='time' name='opentime[]' disabled> </td>";
              echo "<td align=center><p> to </p></td>";
              echo "<td style='text-align: center;'><input type='time' name='closetime[]' disabled> </td></tr>";
              }
                elseif(in_array($date[$j], $days) && $j>0){
              echo "<tr><td></td><td></td><td></td>";
              echo "<td ><p> $date[$j] </p></td>";
              echo"<td><label class='switch' for='checkbox$j'><input type='checkbox' id='checkbox$j' name='workingday[]' value='$date[$j]' checked/><div class='slider round'></div></label></td>";
              echo "<td style='text-align: center;'><input type='time' name='opentime[]' value='$opens[$i]'> </td>";
              echo "<td align=center><p> to </p></td>";
              echo "<td style='text-align: center;'><input type='time' name='closetime[]' value='$closes[$i]'> </td></tr>";
              $i++;
              }
                else{
              echo "<tr><td></td><td></td><td></td>";
              echo "<td ><p> $date[$j] </p></td>";
              echo"<td><label class='switch' for='checkbox$j'><input type='checkbox' id='checkbox$j' name='workingday[]' value='$date[$j]'/><div class='slider round'></div></label></td>";
              echo "<td style='text-align: center;'><input type='time' name='opentime[]' disabled> </td>";
              echo "<td align=center><p> to </p></td>";
              echo "<td style='text-align: center;'><input type='time' name='closetime[]' disabled> </td></tr>";
              }
            }
          
              ?>
        
      </table>
      <div class="submit-button-container" style="margin-top:3%">
      <button class="submit-button" id="submitbtn7" type="submit">Submit</button>
      <button class="submit-button" id="closebtn7" type="button" style="background-color: white;color: #4d4d4d;">Close</button>
    </div>
    </form>
  </div>
</div>


<script type="text/javascript">

var modal0 = document.getElementById("coverModal");
var btn0 = document.getElementById("cp");
var close0 = document.getElementById("closebtn0");
var submit0 = document.getElementById("submitbtn0");
var span0 = modal0.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn0.onclick = function() {
  modal0.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span0.onclick = function() {
  modal0.style.display = "none";
  document.getElementById("coverForm").reset();
  document.getElementById("file-upload2").value = null;
}

close0.onclick = function() {
  modal0.style.display = "none";
  document.getElementById("coverForm").reset();
  document.getElementById("file-upload2").value = null;
}

var modal1 = document.getElementById("picModal");
var btn1 = document.getElementById("pp");
var close1 = document.getElementById("closebtn");
var submit1 = document.getElementById("submitbtn");
var span1 = modal1.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn1.onclick = function() {
  modal1.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span1.onclick = function() {
  document.getElementById("picForm").reset();
  document.getElementById("file-upload").value = null;
  console.log(document.getElementById("file-upload").value);
  modal1.style.display = "none";
  
}

close1.onclick = function() {
  document.getElementById("picForm").reset();
  document.getElementById("file-upload").value = null;
  console.log(document.getElementById("file-upload").value);
  modal1.style.display = "none";
  
}

var modal2 = document.getElementById("nameModal");
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
  document.getElementById("nameForm").reset();
  window.location.reload();
}

close2.onclick = function() {
  modal2.style.display = "none";
  document.getElementById("nameForm").reset();
  window.location.reload();
}

submit2.onclick = function() {
  setTimeout(function() {
    document.getElementById("nameForm").reset();
  }, 500);
};

var modal3 = document.getElementById("addressModal");
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
  document.getElementById("addressForm").reset();
  window.location.reload();
}

close3.onclick = function() {
  modal3.style.display = "none";
  document.getElementById("addressForm").reset();
  window.location.reload();
}

submit3.onclick = function() {
  setTimeout(function() {
    document.getElementById("addressForm").reset();
  }, 500);
};

var modal4 = document.getElementById("discountModal");
var btn4 = document.getElementById("edit-button3");
var close4 = document.getElementById("closebtn4");
var submit4 = document.getElementById("submitbtn4");
var span4 = modal4.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn4.onclick = function() {
  modal4.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span4.onclick = function() {
  modal4.style.display = "none";
  document.getElementById("discountForm").reset();
  window.location.reload();
}

close4.onclick = function() {
  modal4.style.display = "none";
  document.getElementById("discountForm").reset();
  window.location.reload();
}

submit4.onclick = function() {
  setTimeout(function() {
    document.getElementById("discountForm").reset();
  }, 500);
};

var modal5 = document.getElementById("phoneModal");
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
  modal5.style.display = "none";
  document.getElementById("phoneForm").reset();
  window.location.reload();
}

close5.onclick = function() {
  modal5.style.display = "none";
  document.getElementById("phoneForm").reset();
  window.location.reload();
}

submit5.onclick = function() {
  setTimeout(function() {
    document.getElementById("phoneForm").reset();
  }, 500);
};

var modal6 = document.getElementById("descriptionModal");
var btn6 = document.getElementById("edit-button5");
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
  document.getElementById("aboutForm").reset();
  window.location.reload();
}

close6.onclick = function() {
  modal6.style.display = "none";
  document.getElementById("aboutForm").reset();
  window.location.reload();
}

submit6.onclick = function() {
  setTimeout(function() {
    document.getElementById("aboutForm").reset();
  }, 500);
};

var modal7 = document.getElementById("workingModal");
var btn7 = document.getElementById("edit-button6");
var close7 = document.getElementById("closebtn7");
var submit7 = document.getElementById("submitbtn7");
var span7 = modal7.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn7.onclick = function() {
  modal7.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span7.onclick = function() {
  modal7.style.display = "none";
  document.getElementById("workingForm").reset();
  window.location.reload();
}

close7.onclick = function() {
  modal7.style.display = "none";
  document.getElementById("workingForm").reset();
  window.location.reload();
}

submit7.onclick = function() {
  setTimeout(function() {
    document.getElementById("workingForm").reset();
  }, 500);
};

var modal8 = document.getElementById("chooseModal");
var btn8 = document.getElementById("upload-button");
var span8 = modal8.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn8.onclick = function() {
  modal8.style.display = "block"; 
}
// When the user clicks on <span> (x), close the modal
span8.onclick = function() {
  modal8.style.display = "none";
  window.location.reload();
}


document.addEventListener("DOMContentLoaded", function() {
    var editButton1 = document.getElementById("edit-button1");
    var clinicname = document.getElementById("clinic_name");
    var editButton2 = document.getElementById("edit-button2");
    var clinicaddress = document.getElementById("clinic_address");
    var editButton3 = document.getElementById("edit-button3");
    var clinicdiscount = document.getElementById("clinic_discount");
    var editButton4 = document.getElementById("edit-button4");
    var clinicphone = document.getElementById("clinic_phone");
    var editButton5 = document.getElementById("edit-button5");
    var clinicdescription = document.getElementById("clinic_description");
    var editButton6 = document.getElementById("edit-button6");
    var dateElements = Array.from(document.getElementsByClassName("date"));
    var timeElements = Array.from(document.getElementsByClassName("time"));
    var nothingElements = Array.from(document.getElementsByClassName("nothing"));
   

    editButton1.addEventListener("mouseenter", function() {
        clinicname.classList.add("highlighted");
        editButton1.classList.add("hover-edit");
    });

    editButton1.addEventListener("mouseleave", function() {
      clinicname.classList.remove("highlighted");
      editButton1.classList.remove("hover-edit");
    });

    editButton2.addEventListener("mouseenter", function() {
        clinicaddress.classList.add("highlighted");
        editButton2.classList.add("hover-edit");
      });

    editButton2.addEventListener("mouseleave", function() {
      clinicaddress.classList.remove("highlighted");
      editButton2.classList.remove("hover-edit");
    });

    editButton3.addEventListener("mouseenter", function() {
        clinicdiscount.classList.add("highlighted");
        editButton3.classList.add("hover-edit");
    });

    editButton3.addEventListener("mouseleave", function() {
      clinicdiscount.classList.remove("highlighted");
      editButton3.classList.remove("hover-edit");
    });

    editButton4.addEventListener("mouseenter", function() {
        clinicphone.classList.add("highlighted");
        editButton4.classList.add("hover-edit");
    });

    editButton4.addEventListener("mouseleave", function() {
      clinicphone.classList.remove("highlighted");
      editButton4.classList.remove("hover-edit");
    });

    editButton5.addEventListener("mouseenter", function() {
        clinicdescription.classList.add("highlighted");
        editButton5.classList.add("hover-edit");
    });

    editButton5.addEventListener("mouseleave", function() {
      clinicdescription.classList.remove("highlighted");
      editButton5.classList.remove("hover-edit");
    });

    editButton6.addEventListener("mouseenter", function() {
      dateElements.forEach(function(element) {
        element.classList.add("highlighted");
      });

      timeElements.forEach(function(element) {
        element.classList.add("highlighted");
      });

      nothingElements.forEach(function(element) {
        element.classList.add("highlighted");
      });

      editButton6.classList.add("hover-edit");
    });

    editButton6.addEventListener("mouseleave", function() {
      dateElements.forEach(function(element) {
        element.classList.remove("highlighted");
      });

      timeElements.forEach(function(element) {
        element.classList.remove("highlighted");
      });

      nothingElements.forEach(function(element) {
        element.classList.remove("highlighted");
      });

      editButton6.classList.remove("hover-edit");
    });
    });


const checkboxes = document.querySelectorAll('input[type=checkbox][name="workingday[]"]');

// add event listener to each checkbox
checkboxes.forEach(checkbox => {
  checkbox.addEventListener('change', function() {
    // find parent row element
    const row = this.closest('tr');
    // find time input fields in the same row
    const openTime = row.querySelector('input[name="opentime[]"]');
    const closeTime = row.querySelector('input[name="closetime[]"]');
    // enable or disable the time input fields based on checkbox status
    if (this.checked) {
      openTime.disabled = false;
      closeTime.disabled = false;
    } else {
      openTime.disabled = true;
      closeTime.disabled = true;
      openTime.value = '';
      closeTime.value = '';
    }
  });
});
</script>

</body>
</html>