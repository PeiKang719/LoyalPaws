<?php
include('Connection.php');

$oID=$_POST['oID'];
$name=$_POST['name'];
$url=$_POST['url'];
$img=$_FILES['img']['name'];
$category=$_POST['category'];
$description = $_POST['description'];
$type=$_POST['type'];
$method=$_POST['method'];
$minimum=$_POST['minimum'];



if (filter_var($url, FILTER_VALIDATE_URL)) {
    if($_POST['category']==NULL){
        echo '<script type="text/javascript">';
        echo 'alert("Organization category cannot be null.");';
        echo '</script>';
        exit();
    }else{
        $categories = implode(',', $_POST['category']);
        if($_POST['method']==NULL){
           echo '<script type="text/javascript">';
            echo 'alert("Payment method cannot be null.");';
            echo '</script>'; 
            exit();
        }else{
           $methods = implode(',', $_POST['method']); 
        }
    }
    
}else{
        echo '<script type="text/javascript">';
        echo 'alert("Invalid URL.");';
        echo '</script>';
        exit();
}


if($_FILES['img']['name'] !== ""){
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
  $sql = "UPDATE organization SET oname='$name',logo='$unique_name',description='$description',url='$url',category='$categories',payment_type='$type',payment_method='$methods',minimum='$minimum' WHERE oID=$oID";
}
else{
	$sql = "UPDATE organization SET oname='$name',description='$description',url='$url',category='$categories',payment_type='$type',payment_method='$methods',minimum='$minimum' WHERE oID=$oID";
}


$result = mysqli_query($conn, $sql);
?>
<?php
if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Pet Info Edited");';
    echo 'parent.window.location.href = "SideBar_Donation-Edit-Modal.php?id=' . $oID . '";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed To Edit Pet Info");';
    echo 'parent.window.location.href = "SideBar_Donation-Edit-Modal?id=' . $oID . '";';
    echo '</script>';
}

$conn->close();
?>
