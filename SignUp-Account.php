<?php

include('Connection.php');

$r = $_GET['r'];

if ($r=='pet-shop') {

  $name = $_POST['name'];
  $password = $_POST['password'];
  $shop_name = $_POST['shop_name'];
  $state = $_POST['state'];
  $area = $_POST['area'];
  $address = $_POST['address'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
   if($_POST['unique_name']!=NULL){
  $img = $_POST['unique_name'];
    }else{
        $img=NULL;
    }
  $description = $_POST['description'];
    $workingday = $_POST['workingday'];
    $opentime = $_POST['opentime'];
    $closetime = $_POST['closetime'];

  $stmt = $conn->prepare("INSERT INTO pet_shop(username,password,shopname,phone,state,area,address,shop_image,work_day,open_time,close_time,email,description) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param("sssssssssssss", $name, $password, $shop_name, $contact, $state, $area, $address, $img, $workingday, $opentime, $closetime, $email, $description);

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
$clinic_name=$_POST['clinic_name'];
$state=$_POST['state'];
$area=$_POST['area'];
$address=$_POST['address'];
$contact2=$_POST['contact2'];
$email2=$_POST['email2'];
if($_POST['unique_name']!=NULL){
  $img = $_POST['unique_name'];
    }else{
        $img=NULL;
    }
$description = $_POST['description'];
$workingday=$_POST['workingday'];
$opentime=$_POST['opentime'];
$closetime=$_POST['closetime'];
$discount=$_POST['discount'];

$username = $_POST['username'];
$password = $_POST['password'];
$ic = $_POST['ic'];
$name = $_POST['name'];
$email = $_POST['email'];
$focus_area = $_POST['focus_area'];
$apc = $_POST['unique_name2'];
$contact = $_POST['contact'];


   $sql = "INSERT INTO clinic(name,phone,email,state,area,address,clinic_image,work_day,open_time,close_time,discount_percent,description)
VALUES ('$clinic_name','$contact2','$email2','$state','$area','$address','$img','$workingday','$opentime','$closetime','$discount','$description')";


    if ($conn->query($sql) === TRUE) {
        $sql2 = "SELECT * FROM clinic WHERE clinicID = (SELECT MAX(clinicID) FROM clinic)"; 
        $result = $conn->query($sql2);
        $row = $result->fetch_assoc();
        $clinicID=$row['clinicID'];

    $ic = "B." . $ic;
    $stmt = $conn->prepare("INSERT INTO vet (username, password, ic, name, email, apc, area, phone, clinicID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $username, $password, $ic, $name, $email, $apc, $focus_area, $contact, $clinicID);
    if ($stmt->execute()) {
        echo '<script type="text/javascript">';
        echo 'alert("Thank you for registering!\nYour information has been received and is pending approval. Please allow up to 24 hours for your account to be verified.\nYou will receive an email notification confirming your registration,once your account is approved");';
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
    $password = $_POST['password'];
    $ic = $_POST['ic'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $focus_area = $_POST['area'];
    $clinic = $_POST['clinic'];
    $contact = $_POST['contact'];
    $apc = $_POST['apc'];

    $ic = "P." . $ic;
    $stmt = $conn->prepare("INSERT INTO vet (username, password, ic, name, email, apc, area, phone, clinicID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $username, $password, $ic, $name, $email, $apc, $focus_area, $contact, $clinic);
    if ($stmt->execute()) {
        echo '<script type="text/javascript">';
        echo 'alert("Thank you for registering!\nYour information has been received and is pending approval. Please allow up to 24 hours for your account to be verified.\nYou will receive an email notification confirming your registration,once your account is approved");';
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

    $username = $_POST['name'];
    $password = $_POST['password'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $state = $_POST['state'];
    $area = $_POST['area'];
    if($_POST['unique_name']!=NULL){
  $img = $_POST['unique_name'];
    }else{
        $img=NULL;
    }

    // prepare the SQL statement with placeholders
    $sql = "INSERT INTO adopter (username, password, firstName, lastName, dob, state, area, phone, email,image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    // prepare the statement
    $stmt = $conn->prepare($sql);

    // bind parameters to the statement
    $stmt->bind_param("ssssssssss", $username, $password, $first, $last, $dob, $state, $area, $contact, $email,$img);

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
    $username = $_POST['name'];
    $password = $_POST['password'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $state = $_POST['state'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    if($_POST['unique_name']!=NULL){
        $img = $_POST['unique_name'];
    }else{
        $img=NULL;
    }
    $workingday = $_POST['workingday'];
    $opentime = $_POST['opentime'];
    $closetime = $_POST['closetime'];

    $stmt = $conn->prepare("INSERT INTO seller (username, password, firstName, lastName, dob, state, area, address, phone, email,description,available,start,end,image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssssssss", $username, $password, $first, $last, $dob, $state, $area, $address, $contact, $email,$description,$workingday, $opentime, $closetime,$img);

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