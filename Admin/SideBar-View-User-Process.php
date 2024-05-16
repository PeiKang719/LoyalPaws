<?php
$adopterID = $_GET['adopterID'];
include('../Database/Connection.php');

// sql to delete a record
$sql = "DELETE FROM adopter WHERE adopterID = $adopterID"; 

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
} else {
    echo "Error Deleting Adopter Information";
}
?>