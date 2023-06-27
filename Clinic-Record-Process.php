<?php

include('Connection.php');


if($_GET['action']=='insert'){
    $appointmentID = $_POST['appointmentID'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $quantity = $_POST['quantity'];
    $treatmentID = $_POST['treatmentID'];
    date_default_timezone_set('Asia/Singapore');
    $record_date = date('Y-m-d H:i:s');


   $stmt = $conn->prepare("INSERT INTO record (appointmentID, pet_name, comment, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $appointmentID, $name, $comment, $record_date);
    if ($stmt->execute()) {
        $sql5 = "UPDATE clinic_appointment SET status='Completed' WHERE appointmentID=$appointmentID ";
        if ( $conn->query($sql5) === TRUE) {
            $sql="SELECT MAX(recordID) AS recordID from record ";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $recordID = $row['recordID'];
            $data = array_combine($quantity, $treatmentID);

            if (is_array($quantity) && is_array($treatmentID) && count($quantity) === count($treatmentID)) {
            for ($i = 0; $i < count($quantity); $i++) {
                $currentQuantity = $quantity[$i];
                $currentTreatmentID = $treatmentID[$i];
                
                $stmt2 = $conn->prepare("INSERT INTO treatment_record (recordID, treatmentID, quantity) VALUES (?, ?, ?)");
                $stmt2->bind_param("sss", $recordID, $currentTreatmentID, $currentQuantity);
                $stmt2->execute();
        }
            echo '<script type="text/javascript">';
            echo 'alert("New record inserted successfully.");';
            echo 'window.location.href = "Clinic-Appointment.php";';
            echo '</script>';
    }}} else {
        echo '<script type="text/javascript">';
        echo 'alert("Insertion error, Please try again.");';
        echo 'window.location.href = "Clinic-Record.php";';
        echo '</script>';
    }
    $stmt->close();
    $conn->close();
}

?>
