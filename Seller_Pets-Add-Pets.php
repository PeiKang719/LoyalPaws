<?php

include('Connection.php');

$type=$_POST['type'];
$breedID=$_POST['breed'];
$gender=$_POST['gender'];
$birthday=$_POST['birthday'];
$color=$_POST['color'];
$purpose=$_POST['purpose'];
$spayed=$_POST['spayed'];
$vaccinated=$_POST['vaccinated'];
$price=$_POST['price'];
$description=$_POST['description'];
$img0=$_FILES['img0']['name'];
$img1=$_FILES['img1']['name'];
$img2=$_FILES['img2']['name'];
$img3=$_FILES['img3']['name'];
$img4=$_FILES['img4']['name'];
$img5=$_FILES['img5']['name'];
$img6=$_FILES['img6']['name'];
$image=array($img0,$img1,$img2,$img3,$img4,$img5,$img6);
$video=$_FILES['video']['name'];
$unique = array(null, null, null, null, null, null, null);
$a=0;
// Loop through each file
for ($i = 0; $i <= 6; $i++) {
    if (isset($_FILES["img{$i}"])) {
        // Set target directory to save uploaded images
        $target_dir = "pet_images/";

        // Generate a unique name for each file to avoid overwriting
        $unique[$i] = time() . '_' . $image[$i];

        // Set target path for each file
        $target_path = $target_dir .  $unique[$i];

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["img{$i}"]['tmp_name'], $target_path)) {
            // File uploaded successfully
            echo "File uploaded: " . $image[$i] . "<br>";
            $imgName[$a]=$unique[$i];
            $a++;
        } else {
            // Failed to upload file
            echo "Failed to upload file: " . $image[$i] . "<br>";
        }
    }
}

if(isset($_FILES['video'])){
     $target_dir = "pet_videos/";
      $video_name = time() . '_' . $video;
        $target_path = $target_dir . $video_name;

if (move_uploaded_file($_FILES['video']['tmp_name'], $target_path)) {
            // File uploaded successfully
            echo "File uploaded: " .$video . "<br>";
        } else {
            // Failed to upload file
            echo "Failed to upload file: " . $video . "<br>";
        }
}
else{
    echo "video not found!";
}

$sql2 = "INSERT INTO pet(type,breedID,gender, birthday, color,spayed, vaccinated,purpose, price, description,video,pet_image,img1,img2,img3,img4,img5,img6,sellerID) 
VALUES ('$type','$breedID','$gender','$birthday','$color','$spayed','$vaccinated','$purpose','$price','$description','$video_name',";

$sql2 .= isset($imgName[0]) ? "'$imgName[0]'" : "null";
$sql2 .= ",";
$sql2 .= isset($imgName[1]) ? "'$imgName[1]'" : "null";
$sql2 .= ",";
$sql2 .= isset($imgName[2]) ? "'$imgName[2]'" : "null";
$sql2 .= ",";
$sql2 .= isset($imgName[3]) ? "'$imgName[3]'" : "null";
$sql2 .= ",";
$sql2 .= isset($imgName[4]) ? "'$imgName[4]'" : "null";
$sql2 .= ",";
$sql2 .= isset($imgName[5]) ? "'$imgName[5]'" : "null";
$sql2 .= ",";
$sql2 .= isset($imgName[6]) ? "'$imgName[6]'" : "null";
$sql2 .= ",1)";



if ($conn->query($sql2) === TRUE) {
    echo "<script type='text/javascript'>alert('New Pet Inserted')</script>";
} else { 
    echo "<script type='text/javascript'>alert('Error Insert Pet,Please Try Again.')</script>";
}


$conn->close();
?>
