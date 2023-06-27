<?php
if (isset($_GET['c'])) {
    $c=$_GET['c'];
    if($c=='pic'){
        pic();
    }
    else if($c=='cover'){
        cover();
    }
    else if($c=='shopname'){
        shopname();
    }
    else if($c=='sellername'){
        sellername();
    }
    else if($c=='password'){
        password();
    }
    else if($c=='address'){
        address();
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
$role=$_POST['role'];
$img=$_FILES['img']['name'];

if($_FILES['img']['name'] !== ""){
  if(isset($_FILES['img'])){
    if($role=='seller'){
        $target_dir = "seller_images/";
    }elseif($role=='pet_shop'){
        $target_dir = "pet_shop_images/";
    }
     
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

if($role=='seller'){
        $sql = "UPDATE seller SET image='$unique_name' WHERE sellerID='$id'";
    }elseif($role=='pet_shop'){
        $sql = "UPDATE pet_shop SET shop_image='$unique_name' WHERE shopID='$id'";
    }
  
  $result = mysqli_query($conn, $sql);
  if ($conn->query($sql) === TRUE) {
     echo '<script type="text/javascript">';
    echo 'alert("Your new profile picture has been updated successfully.");';
    echo 'window.parent.location.href = "Seller-Seller-Profile.php?";';
    echo '</script>';
    }
    else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update your profile picture. Please try again.");';
    echo 'window.location.href = "Seller-Seller-Profile.php";';
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
$role=$_POST['role'];
$img=$_FILES['img']['name'];

if($_FILES['img']['name'] !== ""){
  if(isset($_FILES['img'])){
     if($role=='seller'){
        $target_dir = "s_covers/seller/";
    }elseif($role=='pet_shop'){
        $target_dir = "s_covers/pet_shop/";
    }
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
  if($role=='seller'){
        $sql = "UPDATE seller SET cover='$unique_name' WHERE sellerID='$id'";
    }elseif($role=='pet_shop'){
        $sql = "UPDATE pet_shop SET cover='$unique_name' WHERE shopID='$id'";
    }
  $result = mysqli_query($conn, $sql);
  if ($conn->query($sql) === TRUE) {
     echo '<script type="text/javascript">';
    echo 'alert("Your new cover picture has been updated successfully.");';
    echo 'window.parent.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
    }
    else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update your cover picture. Please try again.");';
    echo 'window.location.href = "Seller-Seller-Profile.php";';
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
function shopname(){
include('Connection.php');
$id=$_POST['id'];
$role=$_POST['role'];
$newName=$_POST['new'];


$sql2 = "UPDATE pet_shop SET shop_name='$newName' WHERE shopID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your shop name has been updated successfully.");';
    echo 'window.parent.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update shop name. Please try again.");';
    echo 'window.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}


$conn->close();
}
?>

<?php
function sellername(){
include('Connection.php');
$id=$_POST['id'];
$role=$_POST['role'];
$firstName=$_POST['firstName'];
$lastName=$_POST['lastName'];


$sql2 = "UPDATE seller SET firstName='$firstName',lastName='$lastName' WHERE sellerID='$id'";
$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your name has been updated successfully.");';
    echo 'window.parent.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update name. Please try again.");';
    echo 'window.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}


$conn->close();
}
?>

<?php
function address(){
include('Connection.php');
$id=$_POST['id'];
$role=$_POST['role'];
$address=$_POST['address'];
$state=$_POST['state'];
$area=$_POST['area'];

if($role=='seller'){
        $sql2 = "UPDATE seller SET address='$address', state='$state', area='$area' WHERE sellerID='$id'";
    }elseif($role=='pet_shop'){
        $sql2 = "UPDATE pet_shop SET address='$address', state='$state', area='$area' WHERE shopID='$id'";
    }

$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your address has been updated successfully.");';
    echo 'window.parent.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update address. Please try again.");';
    echo 'window.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}


$conn->close();
}
?>

<?php
function phone(){
include('Connection.php');
$id=$_POST['id'];
$role=$_POST['role'];
$newPhone=$_POST['new'];

if($role=='seller'){
        $sql2 = "UPDATE seller SET phone='$newPhone' WHERE sellerID='$id'";
    }elseif($role=='pet_shop'){
        $sql2 = "UPDATE pet_shop SET phone='$newPhone' WHERE shopID='$id'";
    }

$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your phone number has been updated successfully.");';
    echo 'window.parent.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to phone number. Please try again.");';
    echo 'window.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}

$conn->close();
}
?>

<?php
function description(){
include('Connection.php');
$id=$_POST['id'];
$role=$_POST['role'];
$description=$_POST['description'];

if($role=='seller'){
        $sql2 = "UPDATE seller SET description='$description' WHERE sellerID='$id'";
    }elseif($role=='pet_shop'){
        $sql2 = "UPDATE pet_shop SET description='$description' WHERE shopID='$id'";
    }


$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Your description has been updated successfully.");';
    echo 'window.parent.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update description. Please try again.");';
    echo 'window.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}
}
?>

<?php
function working(){
include('Connection.php');
$id=$_POST['id'];
$role=$_POST['role'];
$workingday=$_POST['workingday'];
$opentime=$_POST['opentime'];
$closetime=$_POST['closetime'];

$workingdays = implode(',', $workingday);
$opentimes = implode(',', $opentime);
$closetimes = implode(',', $closetime);

if($role=='seller'){
        $sql2 = "UPDATE seller SET available='$workingdays' , start='$opentimes' , end='$closetimes'  WHERE sellerID='$id'";
    }elseif($role=='pet_shop'){
        $sql2 = "UPDATE pet_shop SET work_day='$workingdays' , open_time='$opentimes' , close_time='$closetimes'  WHERE shopID='$id'";
    }


$result2 = mysqli_query($conn, $sql2);
if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    if($role=='seller'){
        echo 'alert("Your available time has been updated successfully.");';
    }elseif($role=='pet_shop'){
        echo 'alert("Your shop working hours has been updated successfully.");';
    }
    echo 'window.parent.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to update time. Please try again.");';
    echo 'window.location.href = "Seller-Seller-Profile.php";';
    echo '</script>';
}
$conn->close();
}


function password(){
include('Connection.php');
$id=$_POST['id'];
$role=$_POST['role'];
$old=MD5($_POST['old']);
$new1=MD5($_POST['new1']);
$new2=MD5($_POST['new2']);

if($new1==$new2){
    if($role=='seller'){
        $sql = "SELECT password from seller WHERE sellerID='$id'";
    }elseif($role=='pet_shop'){
        $sql = "SELECT password from pet_shop WHERE shopID='$id'";
    }
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $oldpassword=$row["password"];
        }
        if($old==$oldpassword){
            if($role=='seller'){
                $sql2 = "UPDATE seller SET password='$new1' WHERE sellerID='$id'";
            }elseif($role=='pet_shop'){
                $sql2 = "UPDATE pet_shop SET password='$new1' WHERE shopID='$id'";
            }
            
            $result2 = mysqli_query($conn, $sql2);
            if ($conn->query($sql2) === TRUE) {
                echo '<script type="text/javascript">';
                echo 'alert("Your password has been updated successfully.");';
                echo 'window.parent.location.href = "Seller-Seller-Profile.php";';
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
        echo 'alert("Cannot find information");';
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