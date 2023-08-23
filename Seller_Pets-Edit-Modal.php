<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
    <link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="stylesheet" type="text/css" href="SellerStyle.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body >
    <?php include 'SellerHeader.php'; ?>
<?php 
include 'Connection.php';
$petID = $_GET['petID'];
    $sql = "SELECT p.petID, p.type, p.gender, p.birthday, p.color,p.purpose, p.description, p.video,p.pet_image, p.img1, p.img2, p.img3, p.img4, p.img5, p.img6, p.vaccinated, p.spayed, p.price, p.breedID ,p.availability,p.return_date,b.name FROM pet p,breed b WHERE p.petID = $petID AND p.breedID=b.breedID;";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $pet_id=$row["petID"];
          $name=$row["name"];
          $petID=$row["petID"];
          $breedID= $row["breedID"];
          $type=$row["type"];
          $gender=$row["gender"];
          $birthday=$row["birthday"];
          $color=$row["color"];
          $purpose=$row["purpose"];
          $description=$row["description"];
          $vaccinated=$row["vaccinated"];
          $spayed=$row["spayed"];
          $price=$row["price"];
          $availability=$row["availability"];
          $return_date=$row['return_date'];
          if ($availability == 'Y') {
              $available = 'Yes';
          }else{
              $available = 'No';
          }
          $video=$row["video"];
          $img0=$row["pet_image"];
          $img1=$row["img1"];
          $img2=$row["img2"];
          $img3=$row["img3"];
          $img4=$row["img4"];
          $img5=$row["img5"];
          $img6=$row["img6"];
          $image=array($img0,$img1,$img2,$img3,$img4,$img5,$img6);
       }
       $imageData = base64_encode($img0);
$imageSrc2 = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if (file_exists('pet_images/' . $img0)) {
    $imageSrc2 = 'pet_images/' . $img0;
}

$videoData = base64_encode($video);
  $videoSrc = "data:video/mp4;base64," . $videoData;
  if (file_exists('pet_videos/' . $video)) {
    $videoSrc = 'pet_videos/' . $video;
   }
} ?>

<form  action="Seller_Pets-Edit-Pets.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="pet_id" value=<?php echo"$pet_id" ?>>
 <section style="box-shadow: 0 0px 5px 2px rgba(0,0,0,0.2);height: 470px;">
    <div class="slideshow-container">
<?php
for ($i = 1; $i <= 6; $i++) {
    // Check if the image file exists
    if (isset($image[$i]) && file_exists('pet_images/' .$image[$i])) {
        $imageSrc = 'pet_images/' . $image[$i];
?>
        <div class="mySlides fade">
            
            <img class="img_now" src="<?php echo $imageSrc; ?>" style="width:auto;height:400px;margin-left: auto;margin-right: auto;display: flex;">
            <button type="button" class="delete-image-button" id="<?php echo"delete$i" ?>">Delete<span class="material-symbols-outlined" style="color:white;vertical-align: -5px;">delete</span></button>
            <input type="hidden" name="<?php echo"delete$i" ?>" value=0 class="delete-toggle">
            <i class="fas fa-upload upload-button" style="font-size: 25px;margin-left: 410px;margin-top: -60px;position: absolute;display: none;color: red;">Upload Image</i>
            <input class="file-upload"  name="<?php echo"img$i" ?>" type="file" accept="image/*"/>
        </div>

<?php
    }
    else{?>
        <div class="mySlides fade">

            <img class="img_now" src="media/noimage.jpg" style="width:auto;height:400px;margin-left: auto;margin-right: auto;display: flex;">
            <button type="button" class="delete-image-button" id="<?php echo"delete$i" ?>" style="display: none;">Delete<span class="material-symbols-outlined" style="color:white;vertical-align: -5px;">delete</span></button>
            <input type="hidden" name="<?php echo"delete$i" ?>" value=0 class="delete-toggle">
            <i class="fas fa-upload upload-button" style="font-size: 25px;margin-left: 410px;margin-top: -60px;position: absolute;display: block;color: red;">Upload Image</i>
            <input class="file-upload" name="<?php echo"img$i" ?>" type="file" accept="image/*"/>
        </div>
<?php
    }
}

 if (isset($video) && file_exists('pet_videos/' . $video)) {?>
        <div class="mySlides fade">
            <video class="video_now" controls loop style="width:auto;height:400px;margin-left: auto;margin-right: auto;display: block;">
                <source  src="<?php echo $videoSrc; ?>" type="video/mp4" >
            </video>
            <img class="img_now" src="media/novideo.jpg" style="width:711.1px;height:400px;margin-left: 144.45px;margin-right: auto;display: flex;display: none;">
             <button type="button" class="delete-video-button" id="delete7">Delete<span class="material-symbols-outlined" style="color:white;vertical-align: -5px;">delete</span></button>
            <input type="hidden" name="delete7" value=0 class="delete-toggle">
             <i class="fas fa-upload upload-button3" style="font-size: 25px;margin-left: -445.5px;margin-top: 340px;position: absolute;display: none;color: red;">Upload Video</i>
            <input class="file-upload3" type="file" id="video" name="video" accept="video/*" > 
        </div>
    <?php }
    else { ?>
        <div class="mySlides fade">
            <video class="video_now" controls loop style="width:100%;height:400px;margin-left:auto;margin-right: auto;display: none;">
                <source  src=" " type="video/mp4" >
            </video>
            <img class="img_now" src="media/novideo.jpg" style="width:711.1px;height:400px;margin-left: 144.45px;margin-right: auto;display: flex;display: block;">
             <button type="button" class="delete-video-button" id="delete7" style="display:none">Delete<span class="material-symbols-outlined" style="color:white;vertical-align: -5px;">delete</span></button>
            <input type="hidden" name="delete7" value=0 class="delete-toggle">
            <i class="fas fa-upload upload-button3" style="font-size: 25px;margin-left: 410px;margin-top: -60px;position: absolute;display: block;color: red;">Upload Video</i>
            <input class="file-upload3" type="file" id="video" name="video" accept="video/*" > 
        </div>
<?php } ?>
  <!-- Next and previous buttons -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
<?php
for ($i = 1; $i <= 7; $i++) {
    { 
        echo "<span class='dot' onclick='currentSlide($i)'></span>";
   }}?>

</div>

<div style="padding-left: 55px;">
    <div class="row" style="margin-top:0px">
   <div class="small-12 medium-2 large-2 columns">

       <img class="pet-image" src="<?php echo $imageSrc2 ?>">

     <div class="p-image" style="top:600px">
      <i class="far fa-edit upload-button2" style="font-size: 25px;">Edit Image</i>
        <input class="file-upload2" name="img0" type="file" accept="image/*"/>
     </div>
  </div>
</div>
    <p style="display: inline-flex;margin-left: 320px;font-size: 35px;margin-top: 25px;vertical-align: -3px;">Type:</p>
<select name="type" required style="width:5%;" onchange="updateBreedOptions(this.value)">
    <option value="<?php echo $type; ?>" selected><?php echo $type; ?></option>
    <?php if($type=='Dog') {
        echo "<option>Cat</option>";
    } else {
        echo "<option>Dog</option>";
    } ?>
</select>

<p style="display: inline-flex;margin-left: 200px;font-size: 35px;margin-top: 25px;vertical-align: -3px;">Breed:</p> 
<select name="breed" required style="width:30%;" id="breedSelect">
    <option value="<?php echo $breedID; ?>" selected><?php echo $name; ?></option>
    <?php BreedSelectOption($type);?>
</select>   
</div>
</section>
<br>
<br>
<br><br><br><br>

<section class="s2" style="margin-top: 50px;">
    <table border="0" style="width: 90%;" class="pet-info">
        <tr >
            <td>Gender</td>
            <td>:</td>
            <td width="30%"><select name="gender" required style="width:100%;">
              <option value="<?php echo"$gender" ?>"  selected><?php echo"$gender" ?></option>
              <?php if($gender=='Female'){
              echo "<option>Male</option>";}
              else{
              echo "<option>Female</option>";} ?>
          </select></td>
            <td width="10%"></td>
            <td>Color</td>
            <td>:</td>
            <td width="30%"><input type="text" placeholder="Color..." name="color" required value="<?php echo"$color" ?>" style="width:90%;"></td>
        </tr>
        <tr>
            <td>Spayed</td>
            <td>:</td>
            <td><select name="spayed" required style="width:100%;">
                <option value="<?php echo"$spayed" ?>"  selected><?php echo"$spayed" ?></option>
              <?php if($spayed=='Yes'){
              echo "<option>No</option>";}
              else{
              echo "<option>Yes</option>";} ?>
          </select></td>
            <td width="30%"></td>
            <td>Vaccinated</td>
            <td>:</td>
            <td><select name="vaccinated" required style="width:100%;">
                <option value="<?php echo"$vaccinated" ?>"  selected><?php echo"$vaccinated" ?></option>
              <?php if($vaccinated=='Yes'){
              echo "<option>No</option>";}
              else{
              echo "<option>Yes</option>";} ?>
          </select></td>
        </tr>
        <tr>
            <td>BirthDay</td>
            <td>:</td>
            <td><input type="date" id="birthday" name="birthday" style="width:90%;" value="<?php echo"$birthday"?>"></td>
            <td width="30%"></td>
            <td>Price</td>
            <td>:</td>
            <td><p style="display: inline-block;vertical-align: -7px;">RM</p>  <input type="number" id="minimum" name="price" required style="width:40%;" value="<?php echo"$price"?>"></td>
        </tr>
        <tr>
            <td>Purpose</td>
            <td>:</td>
            <td><select id="purpose" name="purpose" required style="width:100%;">
                <option value="<?php echo"$purpose" ?>"  selected><?php echo"$purpose" ?></option>
              <?php if($purpose=='Sell'){
              echo "<option value='Rehome'>Adopt</option>";
              echo "<option>Lodging</option>";}
              elseif($purpose=='Rehome'){
              echo "<option>Sell</option>";
              echo "<option>Lodging</option>";}
              else{
                echo "<option>Sell</option>";
                echo "<option value='Rehome'>Adopt</option>";
              } ?>
          </select></td>
            <td width="30%"></td>
            <td>Availability</td>
            <td>:</td>
            <td><select name="availability" required style="width:100%;">
                <option value="<?php echo"$availability" ?>"  selected><?php echo"$available" ?></option>
              <?php if($availability=='Y'){
              echo "<option value='N'>No</option>";}
              else{
              echo "<option value='Y'>Yes</option>";} ?>
          </select></td>
        </tr>
        <tr style="display: none;" id="return">
            <td style="width:15%">Duration</td>
            <td>:</td>
            <td style="width: 32.5%;text-align: center;">
                        <label class="switch" for="return_date">
                        <input type="checkbox" id="return_date" name="return_date" value="Yes" <?php if($return_date!='0000-00-00' && $return_date !=NULL){echo 'checked';} ?> />
                        <div class="slider round"></div>
                        </label> </td>
            <td style="width: 34.7%;"></td>
            <td style="font-size: 31px;">Return Date</td>
            <td>: </td>
            <td><input type="date" name="date" id="date" style="width:90%" <?php if($return_date=='0000-00-00' || $return_date==NULL){echo 'disabled';} ?> value="<?php echo $return_date ?>"> </td>
        </tr>
        <tr style="display:none;" id="warning">
            <td colspan="4"></td>
            <td colspan="3" style="color: red;font-size: 15px;padding-top: 0;">*The pet will become unavailable if return date has expired*</td>
        </tr>
    </table>
    <br><br>
    <p class="pet-info" style="font-weight: 600;">About the pet: </p>
    <br>
    <section class="s3">
        <textarea maxlength="800" placeholder="Write something to describe the pet...(max 800 characters)" name="description" required style="height:311px;"><?php  echo $description ?></textarea>
</section>
</section>


<footer id="foot" style="margin-top: -938px;"><button class="save-change" type="submit">SAVE CHANGE</button></footer>
<br><br><br><br>
</form>
<?php
/*Select Option of Rules When Insertion Of Penalty*/
function BreedSelectOption($pet) {
include('Connection.php');
$sql = "SELECT * FROM breed WHERE type='$pet' order by name";
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
let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active2", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active2";
}

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

    $(document).on('change', '.file-upload', function() {
        var fileInput = $(this);
        var imgElement = fileInput.closest('.mySlides').find('.img_now');
        readURL(this, imgElement);
        $(this).siblings('.upload-button').hide();
        $(this).siblings('.delete-image-button').show();
    });

    $(document).on('click', '.upload-button', function() {
        var fileInput = $(this).closest('.mySlides').find('.file-upload');
        fileInput.click();
    });

    $(document).on('change', '.file-upload2', function() {
        var fileInput = $(this);
        var imgElement = fileInput.closest('.row').find('.pet-image');
        readURL(this, imgElement);
    });

    $(document).on('click', '.upload-button2', function() {
        var fileInput = $(this).closest('.row').find('.file-upload2');
        fileInput.click();
    });

    $(document).on('click', '.delete-image-button', function() {
        var imgElement = $(this).closest('.mySlides').find('.img_now');
        imgElement.attr('src', 'media/noimage.jpg');
        $(this).hide();
        $(this).siblings('.upload-button').show();
        $(this).siblings('.delete-toggle').val(1);
    });

    $(document).on('change', '.file-upload3', function() {
    var fileInput = $(this);
    var imgElement = fileInput.closest('.mySlides').find('.video_now');
    readURL(this, imgElement);
    $(this).siblings('.upload-button3').hide();
    $(this).siblings('.delete-video-button').show();
    $(this).siblings('.video_now').show();
    $(this).siblings('.img_now').hide();
    });

    $(document).on('click', '.upload-button3', function() {
    var fileInput = $(this).closest('.mySlides').find('.file-upload3');
    fileInput.click();
    });

    $(document).on('click', '.delete-video-button', function() {
        var imgElement = $(this).closest('.mySlides').find('.video_now');
        imgElement.attr('src', ' ');
        $(this).hide();
        $(this).siblings('.video_now').hide();
        $(this).siblings('.img_now').show();
        $(this).siblings('.upload-button3').show();
        $(this).siblings('.delete-toggle').val(1);
    });
});

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

document.addEventListener('DOMContentLoaded', function() {
    var purpose = document.getElementById('purpose');
    var tr = document.getElementById('return');
    var tr2 = document.getElementById('warning');
    var return_btn = document.getElementById('return_date');
    var r_date = document.getElementById('date');
    var foot = document.getElementById('foot');

    // Function to handle the behavior
    function handlePurposeChange() {
        var selectedValue = purpose.value;
        if (selectedValue == 'Lodging') {
            tr.style.display = 'table-row';
            tr2.style.display = 'table-row';
            foot.style.marginTop = '-1067px';
        } else {
            tr.style.display = 'none';
            tr2.style.display = 'none';
            return_btn.checked = false; 
            r_date.value = '';
            foot.style.marginTop = '-938px';
            r_date.removeAttribute('required');
        }
    }

    // Initial behavior setup
    handlePurposeChange();

    // Listen for changes to the select element
    purpose.addEventListener('change', handlePurposeChange);
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