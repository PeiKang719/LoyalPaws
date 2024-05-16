<?php
// Establish a database connection (assuming you have already done this)
include'../Database/Connection.php';
// Get the message content from the user input
$content = $_POST['message'];
$sellerID = $_POST['sellerID'];
$adopterID = $_POST['adopterID'];
if(isset($_POST['column'])){
  $column='vetID';
}
elseif(isset($_POST['key'])){
  if($_POST['key']=='sellerID'){
  $column='sellerID';
  }
  elseif($_POST['key']=='shopID'){
    $column='shopID';
  }
}
date_default_timezone_set('Asia/Singapore');
$time = date('Y-m-d H:i:s');
// Prepare the SQL statement to insert the message
$sql = "INSERT INTO message (`$column`,adopterID,content,time,sender) VALUES ('$sellerID','$adopterID','$content','$time','non-user')";

// Execute the SQL statement
if ($conn->query($sql) === TRUE) {
  echo 'Message inserted successfully';
} else {
  echo 'Error inserting message: ' . $conn->error;
}

// Close the database connection
$conn->close();
?>
