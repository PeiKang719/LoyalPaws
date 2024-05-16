
<?php
session_start();
include('../Database/Connection.php');
$adopterID=$_SESSION['adopterID'];

$selectedUser = $_GET['selectedUser'];
$key = $_GET['key'];
$table = $_GET['table'];


$sql = "SELECT * FROM message m,$table s WHERE m.adopterID=$adopterID AND s.$key=$selectedUser ORDER BY messageID ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if($table=='vet'){
    $name=$row['name'];
    if($row['image']!=''){
              $imageData = base64_encode($row['image']);
              $imageSrc2 = "data:image/jpg;base64," . $imageData;
              // Check if the image file exists before displaying it
              if (file_exists('../Clinic/vet_images/' . $row['image'])) {
                  $imageSrc2 = '../Clinic/vet_images/' . $row['image'];
              }
              }
              else{
                  $imageSrc2='../media/email_male.png';
              }
  }
  elseif($table=='seller'){
    $name=$row['firstName'].' '.$row['lastName'];
    if($row['image']!=''){
              $imageData = base64_encode($row['image']);
              $imageSrc2 = "data:image/jpg;base64," . $imageData;
              // Check if the image file exists before displaying it
              if (file_exists('../Seller/seller_images/' . $row['image'])) {
                  $imageSrc2 = '../Seller/seller_images/' . $row['image'];
              }
              }
              else{
                  $imageSrc2='../media/pet-shop.png';
              }
  }
  elseif($table=='pet_shop'){
    $name=$row['shopname'];
    if($row['shop_image']!=''){
              $imageData = base64_encode($row['shop_image']);
              $imageSrc2 = "data:image/jpg;base64," . $imageData;
              // Check if the image file exists before displaying it
              if (file_exists('../Seller/pet_shop_images/' . $row['shop_image'])) {
                  $imageSrc2 = '../Seller/pet_shop_images/' . $row['shop_image'];
              }
              }
              else{
                  $imageSrc2='../media/pet-shop.png';
              }
  }?>


      <div class="vet-message-content-container-header">
        <img src="<?php echo $imageSrc2 ?>">
        <p><?php echo $name ?></p>
      </div>
      <div class="vet-message-content" id="chatbox">
        
      </div>
      

		