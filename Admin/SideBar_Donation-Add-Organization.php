<?php

include('../Database/Connection.php');

$name=$_POST['name'];
$url=$_POST['url'];
$img=$_FILES['img']['name'];
$category=$_POST['category'];
$description = $_POST['description'];
$type=$_POST['type'];
$method=$_POST['method'];
$minimum=$_POST['minimum'];


// Check if the image file was uploaded without errors
if(isset($_FILES['img'])){
     $target_dir = "organization_images/";
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


$sql = "SELECT * FROM organization WHERE oname = '".$_POST['name']."' ";
$result = $conn->query($sql);

if ($result->num_rows > 0){
    echo "<script type='text/javascript'>alert('Organization Already In Database,Please Try Again.')</script>";
}
else{
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
$uploadedFileExtension = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

if (in_array($uploadedFileExtension, $allowedExtensions)) {
    $categories = implode(',', $_POST['category']);
    $methods = implode(',', $_POST['method']);
   $sql2 = "INSERT INTO organization(oname,url,logo,category,description,payment_type,payment_method,minimum,adminID)
VALUES ('$name','$url','$unique_name','$categories','$description','$type','$methods','$minimum',1)";


    if ($conn->query($sql2) === TRUE) {
        echo "<script type='text/javascript'>alert('New Organization Inserted')</script>";
    } else { 
        echo "<script type='text/javascript'>alert('Error Insert Organization,Please Try Again.')</script>";
    }
}else{
    echo '<script type="text/javascript">';
    echo 'alert("Please upload a file with correct image format.");';
    echo '</script>';
}
}

$conn->close();
?>
