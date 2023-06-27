<?php

include('Connection.php');

$username = $_POST["username"];
$password = $_POST["password1"];

 $sql = "SELECT * FROM adopter WHERE username='$username' AND password=md5('$password')";
 $sql2 = "SELECT * FROM seller WHERE username='$username' AND password=md5('$password')";
 $sql3 = "SELECT * FROM pet_shop WHERE username='$username' AND password=md5('$password')";
 $sql4 = "SELECT * FROM vet WHERE username='$username' AND password=md5('$password')";
 $sql5 = "SELECT * FROM admin WHERE username='$username' AND password=md5('$password')";

 $result = $conn->query($sql);
 $result2 = $conn->query($sql2);
 $result3 = $conn->query($sql3);
 $result4 = $conn->query($sql4);
 $result5 = $conn->query($sql5);
 $row = $result->fetch_assoc();
 $row2 = $result2->fetch_assoc();
 $row3 = $result3->fetch_assoc();
 $row4 = $result4->fetch_assoc();
 $row5 = $result5->fetch_assoc();


 if ($result->num_rows == 1) { // check if the query returned a single row
  session_start();
  $_SESSION['adopterID'] = $row['adopterID'];

  echo '<script type="text/javascript">';
  echo 'alert("Login successful!");';
  echo 'window.location.href = "UserHomePage.php";';
  echo '</script>';
}
elseif($result2->num_rows == 1) {
  session_start();
  $_SESSION['sellerID'] = $row2['sellerID'];
  $_SESSION['role'] = 'sellerID';
  echo '<script type="text/javascript">';
  echo 'alert("Login successful!");';
  echo 'window.location.href = "Seller_HomePage.php";';
  echo '</script>';
}
elseif($result3->num_rows == 1) {
  session_start();
  $_SESSION['shopID'] = $row3['shopID'];
  $_SESSION['role'] = 'shopID';
  echo '<script type="text/javascript">';
  echo 'alert("Login successful!");';
  echo 'window.location.href = "Seller_HomePage.php";';
  echo '</script>';
}
elseif($result4->num_rows == 1) {
  session_start();
  $_SESSION['vetID'] = $row4['vetID'];
   $_SESSION['clinicID'] = $row4['clinicID'];

  echo '<script type="text/javascript">';
  echo 'alert("Login successful!");';
  echo 'window.location.href = "Clinic-Dashboard.php";';
  echo '</script>';
}
elseif($result5->num_rows == 1) {
  session_start();
  $_SESSION['adminID'] = $row5['adminID'];

  echo '<script type="text/javascript">';
  echo 'alert("Login successful!");';
  echo 'window.location.href = "AdminHomePage.php";';
  echo '</script>';
}

else {
  echo '<script type="text/javascript">';
  echo 'alert("Invalid username or password!");';
  echo 'window.location.href = "Login.php";';
  echo '</script>';
}


  // close the connection
  $conn->close();

?>