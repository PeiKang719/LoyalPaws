<?php
// Establish a database connection (assuming you have already done this)
include'../Database/Connection.php';
$adopterID = $_GET['adopterID'];
$sellerID = $_GET['sellerID'];
if(isset($_GET['column'])){
  $column='vetID';
}
elseif(isset($_GET['key'])){
  if($_GET['key']=='sellerID'){
  $column='sellerID';
  }
  elseif($_GET['key']=='shopID'){
    $column='shopID';
  }
}
// Prepare the SQL statement to retrieve the messages
$sql = "SELECT * FROM message WHERE adopterID=$adopterID AND $column=$sellerID";

// Execute the SQL statement
$result = $conn->query($sql);

// Check if there are any messages
if ($result->num_rows > 0) {
  // Loop through each row and display the message content
  while ($row = $result->fetch_assoc()) {
    if($row['sender']=='non-user'){
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
