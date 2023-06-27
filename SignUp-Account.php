<?php

include('Connection.php');

$r = $_GET['r'];

if ($r=='pet-shop') {

  $name = $_POST['username'];
  $password = md5($_POST['password1']);
  $shop_name = $_POST['shop-name'];
  $state = $_POST['state'];
  $area = $_POST['area'];
  $address = $_POST['address'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $img = $_FILES['img']['name'];
  $description = $_POST['description'];
  $workingday = $_POST['workingday'];
  $opentime = $_POST['opentime'];
  $closetime = $_POST['closetime'];

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
    }
  } else {
    echo "image not found!";
  }

  $workingday = implode(',', $workingday);
  $opentime = implode(',', $opentime);
  $closetime = implode(',', $closetime);

  // Prepare the SQL statement
  $stmt = $conn->prepare("INSERT INTO pet_shop(username,password,shopname,phone,state,area,address,shop_image,work_day,open_time,close_time,email,description) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param("sssssssssssss", $name, $password, $shop_name, $contact, $state, $area, $address, $unique_name, $workingday, $opentime, $closetime, $email, $description);

  if ($stmt->execute()) {
    echo '<script type="text/javascript">';
    echo 'alert("Your account has been successfully created");';
    echo 'parent.location.href = "SignUp.php?c=pet-shop-success";';
    echo '</script>';
  } else {
    echo '<script type="text/javascript">';
    echo 'alert("Registration error, Please try again.");';
    echo 'window.location.href = "SignUp.php?c=pet-shop";';
    echo '</script>';
  }
  $stmt->close();
  $conn->close();
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
$workingday=$_POST['workingday2'];
$opentime=$_POST['opentime2'];
$closetime=$_POST['closetime2'];
$discount=$_POST['discount'];

$username = $_POST['username'];
$password = md5($_POST['password1']);
$ic = $_POST['ic'];
$name = $_POST['name'];
$email = $_POST['email'];
$focus_area = $_POST['focus-area'];
$clinic = $_POST['clinic'];
$contact = $_POST['contact'];


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
        }
}
else{
    echo "image not found!";
}


    $workingday = implode(',', $_POST['workingday2']);
    $opentime = implode(',', $_POST['opentime2']);
    $closetime = implode(',', $_POST['closetime2']);

   $sql = "INSERT INTO clinic(name,phone,email,state,area,address,clinic_image,work_day,open_time,close_time,discount_percent,description)
VALUES ('$clinic_name','$contact2','$email2','$state','$area','$address','$unique_name','$workingday','$opentime','$closetime','$discount','$description')";


    if ($conn->query($sql) === TRUE) {
        $sql2 = "SELECT * FROM clinic WHERE clinicID = (SELECT MAX(clinicID) FROM clinic)"; 
        $result = $conn->query($sql2);
        $row = $result->fetch_assoc();
        $clinicID=$row['clinicID'];
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
    $ic = "B." . $ic;
     $focus = implode(',', $focus_area);
    $stmt = $conn->prepare("INSERT INTO vet (username, password, ic, name, email, apc, area, phone, clinicID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $username, $password, $ic, $name, $email, $unique_name2, $focus, $contact, $clinicID);
    if ($stmt->execute()) {
        echo '<script type="text/javascript">';
        echo 'alert("Thank you for registering! Your information has been received and is pending approval. Please allow up to 24 hours for your account to be verified.");';
        echo 'parent.location.href = "SignUp.php?c=clinic-success";';
        echo '</script>';
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Registration error, Please try again.");';
        echo 'window.location.href = "SignUp.php?c=clinic";';
        echo '</script>';
    }
    } else { 
        echo '<script type="text/javascript">';
        echo 'alert("Registration error, Please try again.");';
        echo 'window.location.href = "SignUp.php?c=clinic";';
        echo '</script>';
    }
    $conn->close();
}


else if ($r == 'vet') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $ic = $_POST['ic'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $focus_area = $_POST['area'];
    $clinic = $_POST['clinic'];
    $contact = $_POST['contact'];
    $unique_name = $_POST['apc'];

    $ic = "P." . $ic;
    $focus_areas = implode(',', $focus_area);
    $stmt = $conn->prepare("INSERT INTO vet (username, password, ic, name, email, apc, area, phone, clinicID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $username, $password, $ic, $name, $email, $unique_name, $focus_areas, $contact, $clinic);
    if ($stmt->execute()) {
        echo '<script type="text/javascript">';
        echo 'alert("Thank you for registering! Your information has been received and is pending approval. Please allow up to 24 hours for your account to be verified.");';
        echo 'parent.location.href = "SignUp.php?c=vet-success";';
        echo '</script>';
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Registration error, Please try again.");';
        echo 'window.location.href = "SignUp.php?c=vet";';
        echo '</script>';
    }
    $stmt->close();
    $conn->close();
}




else if ($r == 'adopter') {

    $username = $_POST['username'];
    $password = md5($_POST['password1']);
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $state = $_POST['state'];
    $area = $_POST['area'];
    $img = $_FILES['img']['name'];

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
    }
  } else {
    echo "image not found!";
  }

    // prepare the SQL statement with placeholders
    $sql = "INSERT INTO adopter (username, password, firstName, lastName, dob, state, area, phone, email,image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    // prepare the statement
    $stmt = $conn->prepare($sql);

    // bind parameters to the statement
    $stmt->bind_param("ssssssssss", $username, $password, $first, $last, $dob, $state, $area, $contact, $email,$unique_name);

    // execute the statement
    if ($stmt->execute()) {
        echo '<script type="text/javascript">';
        echo 'alert("Your account has been successfully created");';
       echo 'parent.location.href = "SignUp.php?c=adopter-success";';
        echo '</script>';
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Registration error, Please try again.");';
        echo 'window.location.href = "SignUp.php?c=adopter";';
        echo '</script>';
    }

    // close the statement and connection
    $stmt->close();
    $conn->close();
}


else if ($r == 'individual') {
    $username = $_POST['username'];
    $password = md5($_POST['password1']);
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
    $workingday3 = $_POST['workingday3'];
    $opentime3 = $_POST['opentime3'];
    $closetime3 = $_POST['closetime3'];

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
    }
  } else {
    echo "image not found!";
  }

  $workingday = implode(',', $workingday3);
  $opentime = implode(',', $opentime3);
  $closetime = implode(',', $closetime3);

    $stmt = $conn->prepare("INSERT INTO seller (username, password, firstName, lastName, dob, state, area, address, phone, email,description,available,start,end,image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssssssss", $username, $password, $first, $last, $dob, $state, $area, $address, $contact, $email,$description,$workingday, $opentime, $closetime,$unique_name);

    if ($stmt->execute()) {
        echo '<script type="text/javascript">';
        echo 'alert("Your account has been successfully created");';
       echo 'parent.location.href = "SignUp.php?c=individual-success";';
        echo '</script>';
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Registration error, Please try again.");';
        echo 'window.location.href = "SignUp.php?c=individual";';
        echo '</script>';
    
}

    $stmt->close();
    $conn->close();
}


?>