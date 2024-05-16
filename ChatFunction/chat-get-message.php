<?php
// Establish a database connection (assuming you have already done this)
include'../Database/Connection.php';
$pk='';
$adopterID = $_GET['adopterID'];
$sellerID = $_GET['sellerID'];
$column = $_GET['column'];
if($column==1){
  $pk='sellerID';
}
elseif($column==2){
  $pk='shopID';
}
elseif($column==3){
  $pk='vetID';
}
// Prepare the SQL statement to retrieve the messages
$sql = "SELECT * FROM message WHERE adopterID=$adopterID AND `$pk`=$sellerID";

// Execute the SQL statement
$result = $conn->query($sql);

// Check if there are any messages
if ($result->num_rows > 0) {
  // Loop through each row and display the message content
  while ($row = $result->fetch_assoc()) {
    if($row['sender']=='user'){
      echo'<div class="user-message-container"><div class="user-message">'. $row['content'] .'</div><div class="message-time">
      '.$row['time'].'</div></div>';
  }
  else{
    echo'<div class="non-user-message-container"><div class="non-user-message">'. $row['content'] .'</div><div class="message-time">
      '.$row['time'].'</div></div>';
  }
  }
} else {
  echo 'No messages available';
}

// Close the database connection
$conn->close();
?>
