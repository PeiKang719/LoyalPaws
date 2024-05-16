<?php

include('../Database/Connection.php');

$name=$_POST['name'];
$type=$_POST['type'];
$img=$_FILES['img']['name'];
$description = $_POST['description'];
$country=$_POST['country'];
$life=$_POST['life1']." to ".$_POST['life2'];
$weight=$_POST['weight1']." to ".$_POST['weight2'];
$length=$_POST['length1']." to ".$_POST['length2'];
$avg_weight = ($_POST['weight1'] + $_POST['weight2']) / 2; 
$avg_length = ($_POST['length1'] + $_POST['length2']) / 2; 
$one=$_POST['one'];
$two=$_POST['two'];
$three=$_POST['three'];
$four=$_POST['four'];
$five=$_POST['five'];
$six=$_POST['six'];
$seven=$_POST['seven'];
$eight=$_POST['eight'];
$nine=$_POST['nine'];
$ten=$_POST['ten'];

// Check if the image file was uploaded without errors
if(isset($_FILES['img'])){
     $target_dir = "../Breed/breed_images/";
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


$sql = "SELECT * FROM breed WHERE name = '".$_POST['name']."' AND type='$type';";
$result = $conn->query($sql);

if ($result->num_rows > 0){
    echo "<script type='text/javascript'>alert('Pet Breed Already In Database,Please Try Again.')</script>";
}
else{
    if($type == 'Dog'){
        if($avg_length<40){
            $size='small';
        }
        elseif($avg_length>=40 && $avg_length<=60){
            $size='medium';
        }
        elseif($avg_length>60){
            $size='large';
        }
    }
    else if ($type == 'Cat') {
        if($avg_length<30){
            $size='small';
        }
        elseif($avg_length>=30 && $avg_length<=40){
            $size='medium';
        }
        elseif($avg_length>40){
            $size='large';
        }
    }
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
$uploadedFileExtension = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

if (in_array($uploadedFileExtension, $allowedExtensions)) {
       $sql2 = "INSERT INTO breed(name, type, description, breed_image, kid_friendly, pet_friendly, stranger_friendly, affection, grooming, playfulness, shedding, energy_level, intelligence, vocality, origin, life_span, length, weight, size) 
VALUES ('$name','$type','$description','$unique_name','$one','$two','$three','$four','$five','$six','$seven','$eight','$nine','$ten','$country','$life','$length','$weight', '$size')";


    if ($conn->query($sql2) === TRUE) {
        echo "<script type='text/javascript'>alert('New Pet Breed Inserted')</script>";
    } else { 
        echo "<script type='text/javascript'>alert('Error Insert Pet Breed,Please Try Again.')</script>";
    }
}else{
    echo '<script type="text/javascript">';
    echo 'alert("Please upload a file with correct image format.");';
    echo '</script>';
}

}

$conn->close();
?>
