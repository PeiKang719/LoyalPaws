<?php
$petID = $_GET['id'];
include('../Database/Connection.php');

// sql to delete a record
$sql = "DELETE FROM pet WHERE petID = $petID"; 

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
} else {
    echo "Error Deleting Pet Information";
}
?>