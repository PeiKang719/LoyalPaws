
<?php
session_start();
$role=$_SESSION['role'];
include('Connection.php');
$selectedUser = $_GET['selectedUser'];

if($role=='seller'){
$sellerID=$_SESSION['sellerID'];
$sql = "SELECT * FROM message m,adopter a where m.adopterID=a.adopterID AND m.adopterID=$selectedUser AND sellerID=$sellerID ORDER BY messageID ";
}else{
$shopID=$_SESSION['shopID'];
$sql = "SELECT * FROM message m,adopter a where m.adopterID=a.adopterID AND m.adopterID=$selectedUser AND shopID=$shopID ORDER BY messageID ";
}

$selectedUser = $_GET['selectedUser'];

$result = $conn->query($sql);
$row = $result->fetch_assoc();

if($row['image']!=''){
          $imageData = base64_encode($row['image']);
          $imageSrc2 = "data:image/jpg;base64," . $imageData;
          // Check if the image file exists before displaying it
          if (file_exists('adopter_images/' . $row['image'])) {
              $imageSrc2 = 'adopter_images/' . $row['image'];
          }
          }
          else{
              $imageSrc2='media/profile.png';
          }?>


      <div class="vet-message-content-container-header">
        <img src="<?php echo $imageSrc2 ?>">
        <p><?php echo $row['firstName'].' '.$row['lastName'] ?></p>
      </div>
      <div class="vet-message-content" id="chatbox">
        
      </div>
      

		