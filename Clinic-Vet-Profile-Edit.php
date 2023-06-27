<?php
if (isset($_GET['c'])) {
    $c=$_GET['c'];
    if($c=='password'){
        password();
    }
    else if($c=='phone'){
        phone();
    }
    else if($c=='education'){
        education();
    }
    else if($c=='experience'){
        experience();
    }
    else if($c=='area'){
        area();
    }
    else if($c=='pic'){
        pic();
    }
}


function password(){
include('Connection.php');
$id=$_POST['id'];
$old=$_POST['old'];
$new1=$_POST['new1'];
$new2=$_POST['new2'];

if($new1==$new2){
    $sql = "SELECT password from vet WHERE vetID='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $oldpassword=$row["password"];
        }
        if($old==$oldpassword){
            $sql2 = "UPDATE vet SET password='$new1' WHERE vetID='$id'";
            $result2 = mysqli_query($conn, $sql2);
            if ($conn->query($sql2) === TRUE) {
                echo '<script type="text/javascript">';
                echo 'alert("Your password has been updated successfully.");';
                echo "window.parent.location.href = 'Clinic-Vet-Profile.php?id=$id';";

                echo '</script>';
            }
             else { 
                echo '<script type="text/javascript">';
                echo 'alert("Failed to update password. Please try again.");';
                echo '</script>';
            }
        }
        else{
        echo '<script type="text/javascript">';
        echo 'alert("The old password entered is incorrect. Please verify and try again.");';


        echo '</script>';
        }
    }
    else{
        echo '<script type="text/javascript">';
        echo 'alert("Cannot find vet information");';
        echo '</script>';
    }
}
else{
    echo '<script type="text/javascript">';
    echo 'alert("The new passwords entered do not match. Please make sure you enter the same password in both fields.");';
    echo '</script>';
}


$conn->close();
}
?>

<?php
function phone(){
include('Connection.php');
$id=$_POST['id'];
$phone=$_POST['phone'];


$sql2 = "UPDATE vet SET phone='$phone' WHERE vetID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your phone number has been updated successfully.");';
    echo "window.parent.location.href = 'Clinic-Vet-Profile.php?id=$id';";

    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update phone number. Please try again.");';
    echo "window.parent.location.href = 'Clinic-Vet-Profile.php?id=$id';";

    echo '</script>';
}


$conn->close();
}
?>


<?php
function education(){
include('Connection.php');
$id=$_POST['id'];
$year1=$_POST['eduyear1'];
$year2=$_POST['eduyear2'];
$education=$_POST['education'];
$institution=$_POST['eduinstitution'];

$years1 = implode(',', array_filter($year1, 'strlen'));
$years2 = implode(',', array_filter($year2, 'strlen'));
$educations = implode(',', array_filter($education, 'strlen'));
$institutions = implode(',', array_filter($institution, 'strlen'));

$years1Array = explode(',', $years1);
$years2Array = explode(',', $years2);
$educationsArray = explode(',', $educations);
$institutionsArray = explode(',', $institutions);

$education_descriptions = array();
for($j = 0; $j < count($years1Array); $j++) {
    $education_description=$years1Array[$j].'-'.$years2Array[$j].'^'.$educationsArray[$j].'^'.$institutionsArray[$j];
    $education_descriptions[] = $education_description;
}
$education_detail = implode('$', $education_descriptions);

$sql2 = "UPDATE vet SET education='$education_detail' WHERE vetID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your education details has been updated successfully.");';
    echo "window.parent.location.href = 'Clinic-Vet-Profile.php?id=$id';";

    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update education details. Please try again.");';
    echo "window.parent.location.href = 'Clinic-Vet-Profile.php?id=$id';";

    echo '</script>';
}
$conn->close();
}
?>


<?php
function experience(){
include('Connection.php');
$id=$_POST['id'];
$year1=$_POST['expyear1'];
$year2=$_POST['expyear2'];
$position=$_POST['position'];
$institution=$_POST['expinstitution'];

$years1 = implode(',', array_filter($year1, 'strlen'));
$years2 = implode(',', array_filter($year2, 'strlen'));
$positions = implode(',', array_filter($position, 'strlen'));
$institutions = implode(',', array_filter($institution, 'strlen'));

$years1Array = explode(',', $years1);
$years2Array = explode(',', $years2);
$positionsArray = explode(',', $positions);
$institutionsArray = explode(',', $institutions);

$experience_descriptions = array();
for($j = 0; $j < count($years1Array); $j++) {
    $experience_description=$years1Array[$j].'-'.$years2Array[$j].'^'.$positionsArray[$j].'^'.$institutionsArray[$j];
    $experience_descriptions[] = $experience_description;
}
$experience_detail = implode('$', $experience_descriptions);

$sql2 = "UPDATE vet SET experience='$experience_detail' WHERE vetID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your job experiences has been updated successfully.");';
    echo "window.parent.location.href = 'Clinic-Vet-Profile.php?id=$id';";

    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update job experiences. Please try again.");';
    echo "window.parent.location.href = 'Clinic-Vet-Profile.php?id=$id';";

    echo '</script>';
}
$conn->close();
}
?>


<?php
function area(){
include('Connection.php');
$id=$_POST['id'];
$area=$_POST['area'];

$areas = implode(',', $area);

$sql2 = "UPDATE vet SET area='$areas' WHERE vetID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your focus areas has been updated successfully.");';
    echo "window.parent.location.href = 'Clinic-Vet-Profile.php?id=$id';";

    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update your focus areas. Please try again.");';
    echo "window.parent.location.href = 'Clinic-Vet-Profile.php?id=$id';";

    echo '</script>';
}
$conn->close();
}
?>

<?php
function pic(){
include('Connection.php');
$id=$_POST['id'];
$img=$_FILES['img']['name'];

if($_FILES['img']['name'] !== ""){
  if(isset($_FILES['img'])){
     $target_dir = "vet_images/";
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
  $sql = "UPDATE vet SET image='$unique_name' WHERE vetID='$id'";
  $result = mysqli_query($conn, $sql);
  if ($conn->query($sql) === TRUE) {
     echo '<script type="text/javascript">';
    echo 'alert("Your new profile picture has been updated successfully.");';
    echo "window.parent.location.href = 'Clinic-Vet-Profile.php?id=$id';";

    echo '</script>';
    }
    else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update your profile picture. Please try again.");';
   echo "window.parent.location.href = 'Clinic-Vet-Profile.php?id=$id';";

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