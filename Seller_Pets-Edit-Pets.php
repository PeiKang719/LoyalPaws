<?php

include('Connection.php');

$pet_id=$_POST['pet_id'];
$type=$_POST['type'];
$breedID=$_POST['breed'];
$gender=$_POST['gender'];
$birthday=$_POST['birthday'];
$color=$_POST['color'];
$spayed=$_POST['spayed'];
$vaccinated=$_POST['vaccinated'];
$purpose=$_POST['purpose'];
$price=$_POST['price'];
$description=$_POST['description'];
$delete1=$_POST['delete1'];
$delete2=$_POST['delete2'];
$delete3=$_POST['delete3'];
$delete4=$_POST['delete4'];
$delete5=$_POST['delete5'];
$delete6=$_POST['delete6'];
$delete=array('abc',$delete1,$delete2,$delete3,$delete4,$delete5,$delete6);
$img0=$_FILES['img0']['name'];
$img1=$_FILES['img1']['name'];
$img2=$_FILES['img2']['name'];
$img3=$_FILES['img3']['name'];
$img4=$_FILES['img4']['name'];
$img5=$_FILES['img5']['name'];
$img6=$_FILES['img6']['name'];
$image=array($img0,$img1,$img2,$img3,$img4,$img5,$img6);
$delete7=$_POST['delete7'];
$video=$_FILES['video']['name'];
$unique = array(null, null, null, null, null, null, null);

// Loop through each file
for ($i = 1; $i <= 6; $i++) {
    if ($_FILES['img'.$i]['name'] !== "" && $delete[$i]==0) {
        // Set target directory to save uploaded images
        $target_dir = "pet_images/";

        // Generate a unique name for each file to avoid overwriting
        $unique[$i] = time() . '_' . $image[$i];

        // Set target path for each file
        $target_path = $target_dir .  $unique[$i];

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["img{$i}"]['tmp_name'], $target_path)) {
            // File uploaded successfully
            echo "File uploaded1: " . $unique[$i] . "<br>";

            $sql2 = "UPDATE pet SET img$i='$unique[$i]' WHERE petID='$pet_id';";

                if ($conn->query($sql2) === TRUE) {
                    echo "Uploaded file1: " . $unique[$i] . "<br>";
                } else { 
                    echo "SQL Failed to upload file: " . $unique[$i] . "<br>";
                }
        } else {
            // Failed to upload file
            echo "Failed to upload file1: " . $unique[$i] . "<br>";
        }
    }

        else if ($_FILES['img'.$i]['name'] !== "" && $delete[$i]==1) {
        // Set target directory to save uploaded images
        $target_dir = "pet_images/";

        // Generate a unique name for each file to avoid overwriting
        $unique[$i] = time() . '_' . $image[$i];

        // Set target path for each file
        $target_path = $target_dir .  $unique[$i];

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["img{$i}"]['tmp_name'], $target_path)) {
            // File uploaded successfully
            echo "File uploaded2: " . $unique[$i] . "<br>";

            $sql2 = "UPDATE pet SET img$i='$unique[$i]' WHERE petID='$pet_id';";

                if ($conn->query($sql2) === TRUE) {
                    echo "Uploaded file2: " . $unique[$i] . "<br>";
                } else { 
                    echo "SQL Failed to upload file: " . $unique[$i] . "<br>";
                }
        } else {
            // Failed to upload file
            echo "Failed to upload file2: " . $unique[$i] . "<br>";
        }
    }

    else if ($_FILES['img'.$i]['name'] == "" && $delete[$i]==1) {
        // Set target directory to save uploaded images

            $sql2 = "UPDATE pet SET img$i=NULL WHERE petID='$pet_id'";


                if ($conn->query($sql2) === TRUE) {
                    echo "Deleted file<br>";
                } else { 
                    echo "SQL Failed to delete file<br>";
                }
        } 
        else {
            // Failed to upload file
            echo "Image ".$i." Unchanged<br>";
        }
    }



if($_FILES['video']['name'] !== ""){
     $target_dir = "pet_videos/";
      $video_name = time() . '_' . $video;
        $target_path = $target_dir . $video_name;

    if (move_uploaded_file($_FILES['video']['tmp_name'], $target_path)) {
                // File uploaded successfully

            $sql2 = "UPDATE pet SET video='$video_name' WHERE petID='$pet_id';";

                    if ($conn->query($sql2) === TRUE) {
                        echo "Uploaded video: " . $video_name . "<br>";
                    } else { 
                        echo "SQL Failed to upload file: " . $video_name . "<br>";
                    }
    }
}
    else if($_FILES['video']['name'] == "" && $delete7==1){
            $sql2 = "UPDATE pet SET video=NULL WHERE petID='$pet_id'";


                    if ($conn->query($sql2) === TRUE) {
                        echo "Deleted video<br>";
                    } else { 
                        echo "SQL Failed to delete video<br>";
                    }
    }
    else {
            // Failed to upload file
            echo "Video Unchanged<br>";
        }


if($_FILES['img0']['name'] !== ""){
    if(isset($_FILES['img0'])){
         $target_dir = "pet_images/";
          $main = time() . '_' . $img0;
            $target_path = $target_dir . $main;

        if (move_uploaded_file($_FILES['img0']['tmp_name'], $target_path)) {
                // File uploaded successfully
                echo "File uploaded: " .$img0 . "<br>";
            } else {
                // Failed to upload file
                echo "Failed to upload file: " . $img0 . "<br>";
            }
        }
        else{
            echo "image not found!";
        }
$sql2 = "UPDATE pet SET type='$type', breedID='$breedID', gender='$gender',purpose='$purpose', birthday='$birthday', color='$color', spayed='$spayed', vaccinated='$vaccinated', price='$price', description='$description', pet_image='$main' WHERE petID='$pet_id';";

}
else{
$sql2 = "UPDATE pet SET type='$type', breedID='$breedID', gender='$gender',purpose='$purpose', birthday='$birthday', color='$color', spayed='$spayed', vaccinated='$vaccinated', price='$price', description='$description' WHERE petID='$pet_id';";
}

if ($conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Pet Info Edited");';
    echo 'window.location.href = "Seller_Pets-Edit-Modal.php?petID=' . $pet_id . '";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed To Edit Pet Info");';
    echo 'window.location.href = "Seller_Pets-Edit-Modal.php?petID=' . $pet_id . '";';
    echo '</script>';
}


$conn->close();
?>
