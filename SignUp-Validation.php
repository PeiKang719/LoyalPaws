<?php

include('Connection.php');

$r = $_GET['r'];

if ($r=='pet-shop') {

  $name = $_POST['username'];
  $password = md5($_POST['password1']);
  $password2 = md5($_POST['password2']);
  $shop_name = $_POST['shop-name'];
  $state = $_POST['state'];
  $area = $_POST['area'];
  $address = $_POST['address'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $img = $_FILES['img']['name'];
  $description = $_POST['description'];
if(!isset($_POST['opentime']) ){
    echo '<script type="text/javascript">';
    echo 'alert("Working day & time cannot be empty.");';
    echo '</script>';
}else{
    $workingday = $_POST['workingday'];
    $opentime = $_POST['opentime'];
    $closetime = $_POST['closetime'];
    $workingday = implode(',', $workingday);
  $opentime = implode(',', $opentime);
  $closetime = implode(',', $closetime);
  
}
  // Check if the image file was uploaded without errors
  if (isset($_FILES['img'])) {
    $target_dir = "pet_shop_images/";
    $unique_name = time() . '_' . $img;
    $target_path = $target_dir . $unique_name;

    if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
      // File uploaded successfully
      echo "File uploaded: " . $img . "<br>";
    } else {
      // Failed to upload file
      echo "Failed to upload file: " . $img . "<br>";
      $unique_name=NULL;
    }
  }else{
    $unique_name=NULL;
  }

  $sql="SELECT username FROM pet_shop WHERE username = '$name' UNION ALL SELECT username FROM seller WHERE username = '$name' UNION ALL SELECT username FROM adopter WHERE username = '$name' UNION ALL SELECT username FROM vet WHERE username = '$name'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo '<script type="text/javascript">';
    echo 'alert("This username is already taken. Try another username.");';
    echo '</script>';
  }else{
    if($password == $password2){ ?>
  
      <form id="signup-form" action="SignUp-Verification-Code.php?role=pet-shop" method="post" enctype="multipart/form-data">
        <input type="hidden" name="name" value="<?php echo $name ?>">
        <input type="hidden" name="password" value="<?php echo $password ?>">
        <input type="hidden" name="shop_name" value="<?php echo $shop_name ?>">
        <input type="hidden" name="state" value="<?php echo $state ?>">
        <input type="hidden" name="area" value="<?php echo $area ?>">
        <input type="hidden" name="address" value="<?php echo $address ?>">
        <input type="hidden" name="contact" value="<?php echo $contact ?>">
        <input type="hidden" name="email" value="<?php echo $email ?>">
        <input type="hidden" name="description" value="<?php echo $description ?>">
        <input type="hidden" name="workingday" value="<?php echo $workingday ?>">
        <input type="hidden" name="opentime" value="<?php echo $opentime ?>">
        <input type="hidden" name="closetime" value="<?php echo $closetime ?>">
        <input type="hidden" name="unique_name" value="<?php echo $unique_name ?>">
      </form>
      <script>
      window.onload = function() {
        document.getElementById('signup-form').target = '_parent';
        document.getElementById('signup-form').submit();
      };
    </script>
<?php
}else{
    echo '<script type="text/javascript">';
    echo 'alert("The new passwords entered do not match. Please make sure you enter the same password in both fields.");';
    echo '</script>';
}
}
}
else if ($r == 'individual') {
    $name = $_POST['username'];
    $password = md5($_POST['password1']);
    $password2 = md5($_POST['password2']);
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $state = $_POST['state'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $img = $_FILES['img']['name'];
    $currentDate = date('Y-m-d');

    if ($dob > $currentDate) {
  echo '<script type="text/javascript">';
    echo 'alert("Invalid date of birth");';
    echo '</script>';
    exit();
  }

    if(!isset($_POST['opentime3']) ){
    echo '<script type="text/javascript">';
    echo 'alert("Available day & time cannot be empty.");';
    echo '</script>';
}else{
    $workingday3 = $_POST['workingday3'];
    $opentime3 = $_POST['opentime3'];
    $closetime3 = $_POST['closetime3'];
    $workingday3 = implode(',', $workingday3);
  $opentime3 = implode(',', $opentime3);
  $closetime3 = implode(',', $closetime3);
  
}

    if (isset($_FILES['img'])) {
    $target_dir = "seller_images/";
    $unique_name = time() . '_' . $img;
    $target_path = $target_dir . $unique_name;

    if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
      // File uploaded successfully
      echo "File uploaded: " . $img . "<br>";
    } else {
      // Failed to upload file
      echo "Failed to upload file: " . $img . "<br>";
      $unique_name=NULL;
    }
  } else{
    $unique_name=NULL;
  }

  $sql="SELECT username FROM pet_shop WHERE username = '$name' UNION ALL SELECT username FROM seller WHERE username = '$name' UNION ALL SELECT username FROM adopter WHERE username = '$name' UNION ALL SELECT username FROM vet WHERE username = '$name'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo '<script type="text/javascript">';
    echo 'alert("This username is already taken. Try another username.");';
    echo '</script>';
  }else{
    if($password == $password2){ ?>
      <form id="signup-form" action="SignUp-Verification-Code.php?role=individual" method="post" enctype="multipart/form-data">
        <input type="hidden" name="name" value="<?php echo $name ?>">
        <input type="hidden" name="password" value="<?php echo $password ?>">
        <input type="hidden" name="first" value="<?php echo $first ?>">
        <input type="hidden" name="last" value="<?php echo $last ?>">
        <input type="hidden" name="state" value="<?php echo $state ?>">
        <input type="hidden" name="area" value="<?php echo $area ?>">
        <input type="hidden" name="address" value="<?php echo $address ?>">
        <input type="hidden" name="contact" value="<?php echo $contact ?>">
        <input type="hidden" name="email" value="<?php echo $email ?>">
        <input type="hidden" name="dob" value="<?php echo $dob ?>">
        <input type="hidden" name="description" value="<?php echo $description ?>">
        <input type="hidden" name="workingday" value="<?php echo $workingday3 ?>">
        <input type="hidden" name="opentime" value="<?php echo $opentime3 ?>">
        <input type="hidden" name="closetime" value="<?php echo $closetime3 ?>">
        <input type="hidden" name="unique_name" value="<?php echo $unique_name ?>">
      </form>
      <script>
      window.onload = function() {
        document.getElementById('signup-form').target = '_parent';
        document.getElementById('signup-form').submit();
      };
    </script>
<?php
}else{
    echo '<script type="text/javascript">';
    echo 'alert("The new passwords entered do not match. Please make sure you enter the same password in both fields.");';
    echo '</script>';
}
}
}

else if ($r == 'adopter') {

    $name = $_POST['username'];
    $password = md5($_POST['password1']);
    $password2 = md5($_POST['password2']);
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $state = $_POST['state'];
    $area = $_POST['area'];
    $img = $_FILES['img']['name'];
    $currentDate = date('Y-m-d');

    if ($dob > $currentDate) {
  echo '<script type="text/javascript">';
    echo 'alert("Invalid date of birth");';
    echo '</script>';
    exit();
  }

    if (isset($_FILES['img'])) {
    $target_dir = "adopter_images/";
    $unique_name = time() . '_' . $img;
    $target_path = $target_dir . $unique_name;

    if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
      // File uploaded successfully
      echo "File uploaded: " . $img . "<br>";
    } else {
      // Failed to upload file
      echo "Failed to upload file: " . $img . "<br>";
      $unique_name=NULL;
    }
  }else{
    $unique_name=NULL;
  }

    // prepare the SQL statement with placeholders
   $sql="SELECT username FROM pet_shop WHERE username = '$name' UNION ALL SELECT username FROM seller WHERE username = '$name' UNION ALL SELECT username FROM adopter WHERE username = '$name' UNION ALL SELECT username FROM vet WHERE username = '$name'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo '<script type="text/javascript">';
    echo 'alert("This username is already taken. Try another username.");';
    echo '</script>';
  }else{
    if($password == $password2){ ?>
      <form id="signup-form" action="SignUp-Verification-Code.php?role=adopter" method="post" enctype="multipart/form-data">
        <input type="hidden" name="name" value="<?php echo $name ?>">
        <input type="hidden" name="password" value="<?php echo $password ?>">
        <input type="hidden" name="first" value="<?php echo $first ?>">
        <input type="hidden" name="last" value="<?php echo $last ?>">
        <input type="hidden" name="state" value="<?php echo $state ?>">
        <input type="hidden" name="area" value="<?php echo $area ?>">
        <input type="hidden" name="contact" value="<?php echo $contact ?>">
        <input type="hidden" name="email" value="<?php echo $email ?>">
        <input type="hidden" name="dob" value="<?php echo $dob ?>">
        <input type="hidden" name="unique_name" value="<?php echo $unique_name ?>">
      </form>
      <script>
      window.onload = function() {
        document.getElementById('signup-form').target = '_parent';
        document.getElementById('signup-form').submit();
      };
    </script>
<?php
}else{
    echo '<script type="text/javascript">';
    echo 'alert("The new passwords entered do not match. Please make sure you enter the same password in both fields.");';
    echo '</script>';
}
}
}

else if($r=='clinic'){
$clinic_name=$_POST['clinic-name'];
$state=$_POST['state'];
$area=$_POST['area'];
$address=$_POST['address'];
$contact2=$_POST['contact2'];
$email2=$_POST['email2'];
$img=$_FILES['img']['name'];
$description = $_POST['description'];
$discount=$_POST['discount'];

$username = $_POST['username'];
$password = md5($_POST['password1']);
$password2 = md5($_POST['password2']);
$ic = $_POST['ic'];
$name = $_POST['name'];
$email = $_POST['email'];
$focus_area = $_POST['focus-area'];
$contact = $_POST['contact'];
$apc = $_FILES['apc']['name'];

if(!isset($_POST['opentime2']) ){
    echo '<script type="text/javascript">';
    echo 'alert("Working day & time cannot be empty.");';
    echo '</script>';
    exit();
}else{
    $workingday = $_POST['workingday2'];
    $opentime = $_POST['opentime2'];
    $closetime = $_POST['closetime2'];
    $workingday = implode(',', $workingday);
  $opentime = implode(',', $opentime);
  $closetime = implode(',', $closetime);
  
}

if(!isset($_POST['focus-area']) ){
    echo '<script type="text/javascript">';
    echo 'alert("Must Choose Atleast 1 Focus Area.");';
    echo '</script>';
    exit();
}else{
  $focus_area = implode(',', $focus_area);
  
}

if (strlen($ic) > 12 || strlen($ic)<12) {
   echo '<script type="text/javascript">';
    echo 'alert("Invalid IC length");';
    echo '</script>';
    exit();
}


// Check if the image file was uploaded without errors
if(isset($_FILES['img'])){
     $target_dir = "clinic_images/";
      $unique_name = time() . '_' . $img;
        $target_path = $target_dir . $unique_name;

if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
            // File uploaded successfully
            echo "File uploaded: " .$img . "<br>";
        } else {
            // Failed to upload file
            echo "Failed to upload file: " . $img . "<br>";
        $unique_name=NULL;
    }
  }else{
    $unique_name=NULL;
  }

if(isset($_FILES['apc'])) {
            $target_dir2 = "vet_apc/";
            $unique_name2 = time() . '_' .$_FILES['apc']['name'];
            $target_file2 = $target_dir2 . $unique_name2;

    if (move_uploaded_file($_FILES["apc"]["tmp_name"], $target_file2)) {
        echo "The file ". basename( $_FILES["apc"]["name"]). " has been uploaded.";
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Error Upload File");';
        echo 'window.location.href = "SignUp.php?c=clinic";';
        echo '</script>';
    }
}


   $sql="SELECT username FROM pet_shop WHERE username = '$name' UNION ALL SELECT username FROM seller WHERE username = '$name' UNION ALL SELECT username FROM adopter WHERE username = '$name' UNION ALL SELECT username FROM vet WHERE username = '$name'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo '<script type="text/javascript">';
    echo 'alert("This username is already taken. Try another username.");';
    echo '</script>';
    exit();
  }else{
    if($password == $password2){ ?>

      <form id="signup-form" action="SignUp-Verification-Code.php?role=clinic" method="post" enctype="multipart/form-data">
        <input type="hidden" name="clinic_name" value="<?php echo $clinic_name ?>">
        <input type="hidden" name="state" value="<?php echo $state ?>">
        <input type="hidden" name="area" value="<?php echo $area ?>">
        <input type="hidden" name="address" value="<?php echo $address ?>">
        <input type="hidden" name="contact2" value="<?php echo $contact2 ?>">
        <input type="hidden" name="email2" value="<?php echo $email2 ?>">
        <input type="hidden" name="unique_name" value="<?php echo $unique_name ?>">
        <input type="hidden" name="description" value="<?php echo $description ?>">
        <input type="hidden" name="discount" value="<?php echo $discount ?>">
        <input type="hidden" name="opentime" value="<?php echo $opentime ?>">
        <input type="hidden" name="closetime" value="<?php echo $closetime ?>">
        <input type="hidden" name="workingday" value="<?php echo $workingday ?>">

        <input type="hidden" name="username" value="<?php echo $username ?>">
        <input type="hidden" name="password" value="<?php echo $password ?>">
        <input type="hidden" name="ic" value="<?php echo $ic ?>">
        <input type="hidden" name="name" value="<?php echo $name ?>">
        <input type="hidden" name="email" value="<?php echo $email ?>">
        <input type="hidden" name="focus_area" value="<?php echo $focus_area ?>">
        <input type="hidden" name="unique_name2" value="<?php echo $unique_name2 ?>">
        <input type="hidden" name="contact" value="<?php echo $contact ?>">
      </form>
      <script>
      window.onload = function() {
        document.getElementById('signup-form').target = '_parent';
        document.getElementById('signup-form').submit();
      };

    </script>

<?php
}else{
    echo '<script type="text/javascript">';
    echo 'alert("The new passwords entered do not match. Please make sure you enter the same password in both fields.");';
    echo '</script>';
}
}
}

else if ($r == 'vet') {
    $username = $_POST['username'];
    $password = md5($_POST['password1']);
    $password2 = md5($_POST['password2']);
    $ic = $_POST['ic'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $clinic = $_POST['clinic'];
    $contact = $_POST['contact'];
    $apc = $_FILES['apc']['name'];




if(isset($_FILES['apc'])) {
            $target_dir2 = "vet_apc/";
            $unique_name2 = time() . '_' .$_FILES['apc']['name'];
            $target_file2 = $target_dir2 . $unique_name2;

    if (move_uploaded_file($_FILES["apc"]["tmp_name"], $target_file2)) {
        echo "The file ". basename( $_FILES["apc"]["name"]). " has been uploaded.";
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Error Upload File");';
        echo 'window.location.href = "SignUp.php?c=clinic";';
        echo '</script>';
    }
}
      if(!isset($_POST['area']) ){
    echo '<script type="text/javascript">';
    echo 'alert("Must Choose Atleast 1 Focus Area.");';
    echo '</script>';
}else{
  $focus_area = implode(',',  $_POST['area']);
  if (strlen($ic) > 12 || strlen($ic)<12) {
   echo '<script type="text/javascript">';
    echo 'alert("Invalid IC length");';
    echo '</script>';
}else{
      $sql="SELECT username FROM pet_shop WHERE username = '$name' UNION ALL SELECT username FROM seller WHERE username = '$name' UNION ALL SELECT username FROM adopter WHERE username = '$name' UNION ALL SELECT username FROM vet WHERE username = '$name'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo '<script type="text/javascript">';
    echo 'alert("This username is already taken. Try another username.");';
    echo '</script>';
  }else{
    if($password == $password2){ ?>

      <form id="signup-form" action="SignUp-Verification-Code.php?role=vet" method="post" enctype="multipart/form-data">
        <input type="hidden" name="username" value="<?php echo $username ?>">
        <input type="hidden" name="password" value="<?php echo $password ?>">
        <input type="hidden" name="ic" value="<?php echo $ic ?>">
        <input type="hidden" name="name" value="<?php echo $name ?>">
        <input type="hidden" name="email" value="<?php echo $email ?>">
        <input type="hidden" name="focus_area" value="<?php echo $focus_area ?>">
        <input type="hidden" name="unique_name2" value="<?php echo $unique_name2 ?>">
        <input type="hidden" name="contact" value="<?php echo $contact ?>">
        <input type="hidden" name="clinic" value="<?php echo $clinic ?>">
      </form>
      <script>
      window.onload = function() {
        document.getElementById('signup-form').target = '_parent';
        document.getElementById('signup-form').submit();
      };

    </script>

<?php
}else{
    echo '<script type="text/javascript">';
    echo 'alert("The new passwords entered do not match. Please make sure you enter the same password in both fields.");';
    echo '</script>';
}
}
}
}
}
?>