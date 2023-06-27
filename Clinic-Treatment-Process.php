<?php
include 'Connection.php';
$action=$_GET['action'];

if ($action == 'add') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $vet = $_POST['vet'];
    $clinicID = $_POST['clinicID'];

    $stmt = $conn->prepare("INSERT INTO treatment (name, description, unit_price, clinicID) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $description, $price, $clinicID);
    if ($stmt->execute()) {
        $sql="SELECT MAX(treatmentID) AS treatmentID from treatment ";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        foreach ($vet as $vetID) {
            $stmt2 = $conn->prepare("INSERT INTO vet_treatment (vetID, treatmentID) VALUES (?, ?)");
            $stmt2->bind_param("ss", $vetID, $row['treatmentID']);
            $stmt2->execute();
        }
            echo '<script type="text/javascript">';
            echo 'alert("New treatment inserted successfully.");';
            echo 'window.location.href = "Clinic-Treatment.php";';
            echo '</script>';
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Insertion error, Please try again.");';
        echo 'window.location.href = "Clinic-Treatment.php";';
        echo '</script>';
    }
    $stmt->close();
    $conn->close();
}

elseif ($action == 'edit') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $vet = $_POST['vet'];
    $clinicID = $_POST['clinicID'];
    $treatmentID = $_POST['treatmentID'];

   
     $sql = "UPDATE treatment SET name='$name',description='$description',unit_price='$price' WHERE treatmentID=$treatmentID";
    if (mysqli_query($conn, $sql)) {

        $sql2 = "DELETE FROM vet_treatment WHERE treatmentID = $treatmentID"; 
        $result2 = mysqli_query($conn, $sql2);

        if ($conn->query($sql2) === TRUE) {
            foreach ($vet as $vetID) {
            $stmt2 = $conn->prepare("INSERT INTO vet_treatment (vetID, treatmentID) VALUES (?, ?)");
            $stmt2->bind_param("ss", $vetID, $treatmentID);
            $stmt2->execute();
        }
            echo '<script type="text/javascript">';
            echo 'alert("Treatment edited successfully.");';
            echo 'window.location.href = "Clinic-Treatment.php";';
            echo '</script>';
        }
            
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Edition error, Please try again.");';
        echo 'window.location.href = "Clinic-Treatment.php";';
        echo '</script>';
    }
    $stmt->close();
    $conn->close();
}

elseif ($action == 'delete') {
    $treatmentID = $_GET['treatmentID'];


        $sql2 = "DELETE FROM treatment WHERE treatmentID = $treatmentID"; 
        $result2 = mysqli_query($conn, $sql2);

        if ($conn->query($sql2) === TRUE) {
            echo '<script type="text/javascript">';
            echo 'alert("Treatment deleted successfully.");';
            echo 'window.location.href = "Clinic-Treatment.php";';
            echo '</script>';
        }          
     else {
        echo '<script type="text/javascript">';
        echo 'alert("Deletion error, Please try again.");';
        echo 'window.location.href = "Clinic-Treatment.php";';
        echo '</script>';
    }
    $stmt->close();
    $conn->close();
}
?>
