<?php
include('../Database/Connection.php');

$type = $_GET['type'];
$sql = "SELECT * FROM breed WHERE type='$type' ORDER BY name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<option value="">Select the breed</option>';
    while($row = $result->fetch_assoc()) {
        echo '<option value="' . $row["breedID"] . '">' . $row['name'] . '</option>';
    }
} else {
    echo '<option value="">No breed found</option>';
}

$conn->close();
?>
