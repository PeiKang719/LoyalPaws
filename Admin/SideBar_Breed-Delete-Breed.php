<?php
$breedID = $_GET['id'];
include('../Database/Connection.php');

// sql to delete a record
$sql = "DELETE FROM breed WHERE breedID = $breedID"; 

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
} else {
    echo "Error Deleting Breed Information";
}
?>