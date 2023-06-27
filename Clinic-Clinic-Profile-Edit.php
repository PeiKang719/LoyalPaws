<?php
if (isset($_GET['c'])) {
    $c=$_GET['c'];
    if($c=='pic'){
        pic();
    }
    else if($c=='cover'){
        cover();
    }
    else if($c=='name'){
        name();
    }
    else if($c=='address'){
        address();
    }
    else if($c=='discount'){
        discount();
    }
    else if($c=='phone'){
        phone();
    }
    else if($c=='description'){
        description();
    }
    else if($c=='working'){
        working();
    }
}

function pic(){
include('Connection.php');
$id=$_POST['id'];
$img=$_FILES['img']['name'];

if($_FILES['img']['name'] !== ""){
  if(isset($_FILES['img'])){
     $target_dir = "clinic_images/";
      $unique_name = time() . '_' . $img;
        $target_path = $target_dir . $unique_name;

        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
                    // File uploaded successfully
                    echo "File uploaded: " .$img . "<br>";
                } else {
                    // Failed to upload file
                    echo "Failed to upload file: " . $img . "<br>";
                }
}
else{
    echo "image not found!";
}
  $sql = "UPDATE clinic SET clinic_image='$unique_name' WHERE clinicID='$id'";
  $result = mysqli_query($conn, $sql);
  if ($conn->query($sql) === TRUE) {
     echo '<script type="text/javascript">';
    echo 'alert("Your new clinic picture has been updated successfully.");';
    echo 'window.parent.location.href = "Clinic-Clinic-Profile.php?";';
    echo '</script>';
    }
    else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update your clinic picture. Please try again.");';
    echo 'window.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
    }
}
else{
    echo '<script type="text/javascript">';
    echo 'alert("No image uploaded.");';
    echo '</script>';
}

$conn->close();
}?>

<?php
function cover(){
include('Connection.php');
$id=$_POST['id'];
$img=$_FILES['img']['name'];

if($_FILES['img']['name'] !== ""){
  if(isset($_FILES['img'])){
     $target_dir = "clinic_covers/";
      $unique_name = time() . '_' . $img;
        $target_path = $target_dir . $unique_name;

        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
                    // File uploaded successfully
                    echo "File uploaded: " .$img . "<br>";
                } else {
                    // Failed to upload file
                    echo "Failed to upload file: " . $img . "<br>";
                }
}
else{
    echo "image not found!";
}
  $sql = "UPDATE clinic SET cover='$unique_name' WHERE clinicID='$id'";
  $result = mysqli_query($conn, $sql);
  if ($conn->query($sql) === TRUE) {
     echo '<script type="text/javascript">';
    echo 'alert("Your new clinic cover picture has been updated successfully.");';
    echo 'window.parent.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
    }
    else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update your clinic cover picture. Please try again.");';
    echo 'window.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
    }
}
else{
    echo '<script type="text/javascript">';
    echo 'alert("No image uploaded.");';
    echo '</script>';
}

$conn->close();
}?>


<?php
function name(){
include('Connection.php');
$id=$_POST['id'];
$newName=$_POST['new'];


$sql2 = "UPDATE clinic SET name='$newName' WHERE clinicID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your clinic name has been updated successfully.");';
    echo 'window.parent.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update clinic name. Please try again.");';
    echo 'window.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}


$conn->close();
}
?>

<?php
function address(){
include('Connection.php');
$id=$_POST['id'];
$address=$_POST['address'];
$state=$_POST['state'];
$area=$_POST['area'];


$sql2 = "UPDATE clinic SET address='$address', state='$state', area='$area' WHERE clinicID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your clinic address has been updated successfully.");';
    echo 'window.parent.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update clinic address. Please try again.");';
    echo 'window.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}


$conn->close();
}
?>

<?php
function discount(){
include('Connection.php');
$id=$_POST['id'];
$newDiscount=$_POST['new'];


$sql2 = "UPDATE clinic SET discount_percent='$newDiscount' WHERE clinicID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your clinic discount percentage has been updated successfully.");';
    echo 'window.parent.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update discount percentage. Please try again.");';
    echo 'window.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}

$conn->close();
}
?>

<?php
function phone(){
include('Connection.php');
$id=$_POST['id'];
$newPhone=$_POST['new'];


$sql2 = "UPDATE clinic SET phone='$newPhone' WHERE clinicID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your clinic phone number has been updated successfully.");';
    echo 'window.parent.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update phone number. Please try again.");';
    echo 'window.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}

$conn->close();
}
?>

<?php
function description(){
include('Connection.php');
$id=$_POST['id'];
$description=$_POST['description'];

$sql2 = "UPDATE clinic SET description='$description' WHERE clinicID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your clinic description has been updated successfully.");';
    echo 'window.parent.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update clinic description. Please try again.");';
    echo 'window.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}
}
?>

<?php
function working(){
include('Connection.php');
$id=$_POST['id'];
$workingday=$_POST['workingday'];
$opentime=$_POST['opentime'];
$closetime=$_POST['closetime'];

$workingdays = implode(',', $workingday);
$opentimes = implode(',', $opentime);
$closetimes = implode(',', $closetime);

$sql2 = "UPDATE clinic SET work_day='$workingdays' , open_time='$opentimes' , close_time='$closetimes'  WHERE clinicID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your clinic working hours has been updated successfully.");';
    echo 'window.parent.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update working hours. Please try again.");';
    echo 'window.location.href = "Clinic-Clinic-Profile.php";';
    echo '</script>';
}
$conn->close();
}
?>