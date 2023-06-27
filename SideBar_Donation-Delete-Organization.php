<?php
$oID = $_GET['id'];
include('Connection.php');

// sql to delete a record
$sql = "DELETE FROM organization WHERE oID = $oID"; 

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
} else {
    echo "Error Deleting Organization Information";
}
?>