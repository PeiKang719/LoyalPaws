<?php
// Establish a database connection (assuming you have already done this)
include'../Database/Connection.php';
// Get the message content from the user input
$pk='';
$content = $_POST['message'];
$sellerID = $_POST['sellerID'];
$adopterID = $_POST['adopterID'];
$column = $_POST['column'];
if($column==1){
  $pk='sellerID';
}
elseif($column==2){
  $pk='shopID';
}
elseif($column==3){
  $pk='vetID';
}
date_default_timezone_set('Asia/Singapore');
$time = date('Y-m-d H:i:s');
// Prepare the SQL statement to insert the message
$sql = "INSERT INTO message (`$pk`,adopterID,content,time,sender) VALUES ('$sellerID','$adopterID','$content','$time','user')";

// Execute the SQL statement
if ($conn->query($sql) === TRUE) {
  echo 'Message inserted successfully';
} else {
  echo 'Error inserting message: ' . $conn->error;
}

// Close the database connection
$conn->close();
?>
