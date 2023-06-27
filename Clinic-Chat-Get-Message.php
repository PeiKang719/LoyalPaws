
<?php
session_start();
include('Connection.php');
$vetID=$_SESSION['vetID'];

$selectedUser = $_GET['selectedUser'];


$sql = "SELECT * FROM message m,adopter a where m.adopterID=a.adopterID AND m.adopterID=$selectedUser AND vetID=$vetID ORDER BY messageID ";
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
      

		
