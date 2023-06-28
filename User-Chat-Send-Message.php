<?php
// Establish a database connection (assuming you have already done this)
include'Connection.php';
// Get the message content from the user input
$pk='';
$content = $_POST['message'];
$selectedUser = $_POST['selectedUser'];
$adopterID = $_POST['adopterID'];
$column = $_POST['column'];

date_default_timezone_set('Asia/Singapore');
$time = date('Y-m-d H:i:s');
// Prepare the SQL statement to insert the message
$sql = "INSERT INTO message (`$column`,adopterID,content,time,sender) VALUES ('$selectedUser','$adopterID','$content','$time','user')";

// Execute the SQL statement
if ($conn->query($sql) === TRUE) {
  echo 'Message inserted successfully';
} else {
  echo 'Error inserting message: ' . $conn->error;
}

// Close the database connection
$conn->close();
?>
