<?php
if (isset($_GET['c'])) {
    $c=$_GET['c'];
    if($c=='password'){
        password();
    }
    else if($c=='phone'){
        phone();
    }
    else if($c=='address'){
        address();
    }
    else if($c=='dob'){
        dob();
    }
    else if($c=='pic'){
        pic();
    }
}


function password(){
include('../Database/Connection.php');
$id=$_POST['id'];
$old=md5($_POST['old']);
$new1=md5($_POST['new1']);
$new2=md5($_POST['new2']);

if($new1==$new2){
    $sql = "SELECT password from adopter WHERE adopterID='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $oldpassword=$row["password"];
        }
        if($old==$oldpassword){
            $sql2 = "UPDATE adopter SET password='$new1' WHERE adopterID='$id'";
            $result2 = mysqli_query($conn, $sql2);
            if ($conn->query($sql2) === TRUE) {
                echo '<script type="text/javascript">';
                echo 'alert("Your password has been updated successfully.");';
                echo 'window.parent.location.href = "User-Profile.php";';

                echo '</script>';
            }
             else { 
                echo '<script type="text/javascript">';
                echo 'alert("Failed to update password. Please try again.");';
                echo 'window.parent.location.href = "User-Profile.php";';

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
include('../Database/Connection.php');
$id=$_POST['id'];
$phone=$_POST['phone'];


$sql2 = "UPDATE adopter SET phone='$phone' WHERE adopterID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your phone number has been updated successfully.");';
    echo 'window.parent.location.href = "User-Profile.php";';

    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update phone number. Please try again.");';
    echo 'window.parent.location.href = "User-Profile.php";';

    echo '</script>';
}


$conn->close();
}
?>


<?php
function address(){
include('../Database/Connection.php');
$id=$_POST['id'];
$state=$_POST['state'];
$area=$_POST['area'];


$sql2 = "UPDATE adopter SET  state='$state', area='$area' WHERE adopterID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your location has been updated successfully.");';
    echo 'window.parent.location.href = "User-Profile.php";';

    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update your location. Please try again.");';
    echo 'window.parent.location.href = "User-Profile.php";';

    echo '</script>';
}


$conn->close();
}
?>

<?php
function pic(){
include('../Database/Connection.php');
$id=$_POST['id'];
$img=$_FILES['img']['name'];

if($_FILES['img']['name'] !== ""){
  if(isset($_FILES['img'])){
     $target_dir = "adopter_images/";
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
  $sql = "UPDATE adopter SET image='$unique_name' WHERE adopterID='$id'";
  $result = mysqli_query($conn, $sql);
  if ($conn->query($sql) === TRUE) {
     echo '<script type="text/javascript">';
    echo 'alert("Your new profile picture has been updated successfully.");';
    echo 'window.parent.location.href = "User-Profile.php";';

    echo '</script>';
    }
    else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update your profile picture. Please try again.");';
    echo 'window.parent.location.href = "User-Profile.php";';

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
function dob(){
include('../Database/Connection.php');
$id=$_POST['id'];
$dob=$_POST['dob'];

$currentDate = date('Y-m-d'); // Get the current date

// Convert the date strings to timestamps
$dobTimestamp = strtotime($dob);
$currentDateTimestamp = strtotime($currentDate);

// Compare the timestamps
if ($dobTimestamp > $currentDateTimestamp) {
  // Date of birth is more than the current date, display an alert
  echo '<script>alert("Error: Date of birth cannot be in the future");</script>';
}else{
$sql2 = "UPDATE adopter SET dob='$dob' WHERE adopterID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your date of birth has been updated successfully.");';
    echo 'window.parent.location.href = "User-Profile.php";';

    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update your date of birth. Please try again.");';
   echo 'window.parent.location.href = "User-Profile.php";';

    echo '</script>';
}


$conn->close();
}
}
?>