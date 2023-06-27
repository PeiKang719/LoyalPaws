<?php
include('Connection.php');

$breedID=$_POST['breedID'];
$type=$_POST['type'];
$name=$_POST['name'];
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
        elseif($avg_length>=30 && $avg_length<=50){
            $size='medium';
        }
        elseif($avg_length>50){
            $size='large';
        }
    }

if($_FILES['img']['name'] !== ""){
 if(isset($_FILES['img'])){
     $target_dir = "breed_images/";
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
  $sql = "UPDATE breed SET name='$name',breed_image='$unique_name',description='$description',origin='$country',life_span='$life',weight='$weight',length='$length',kid_friendly='$one',pet_friendly='$two',stranger_friendly='$three',intelligence='$four',grooming='$five',playfulness='$six',shedding='$seven',energy_level='$eight',affection='$nine',vocality='$ten',size='$size' WHERE breedID=$breedID";
}
else{
	$sql = "UPDATE breed SET name='$name',description='$description',origin='$country',life_span='$life',weight='$weight',length='$length',kid_friendly='$one',pet_friendly='$two',stranger_friendly='$three',intelligence='$four',grooming='$five',playfulness='$six',shedding='$seven',energy_level='$eight',affection='$nine',vocality='$ten',size='$size' WHERE breedID=$breedID";
}


$result = mysqli_query($conn, $sql);
?>
<?php
if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Pet Info Edited");';
    echo 'window.location.href = "SideBar_Breed-Edit-Modal.php?id=' . $breedID . '";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed To Edit Pet Info");';
    echo 'window.location.href = "SideBar_Breed-Edit-Modal.php?id=' . $breedID . '";';
    echo '</script>';
}

$con->close();
?>
