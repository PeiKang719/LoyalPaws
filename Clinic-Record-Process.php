<?php

include('Connection.php');

if($_GET['action']=='insert'){
    $appointmentID = $_POST['appointmentID'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $quantity = $_POST['quantity'];
    $treatmentID = $_POST['treatmentID'];
    $discount_percent = $_POST['discount_percent'];
    $extra = NULL;
    if(isset($_POST['name2'])){
        $name2 = $_POST['name2'];
        $price2 = $_POST['price2'];
        $quantity2 = $_POST['quantity2'];
        $description2 = $_POST['description2'];

        foreach ($price2 as $number) {
            if ($number > 300) {
                echo '<script type="text/javascript">';
                echo 'alert("Custom price cannot exceed RM300.\n Please ask your clinic admin to add the treatment in treatment list.");';
                echo "window.location.href='Clinic-Record.php?appointmentID=$appointmentID';";
                echo '</script>';
                exit();
            }
        }

        $name3 = implode(',', array_filter($name2, 'strlen'));
        $price3 = implode(',', array_filter($price2, 'strlen'));
        $quantity3 = implode(',', array_filter($quantity2, 'strlen'));
        $description3 = implode(',', array_filter($description2, 'strlen'));

        $name3Array = explode(',', $name3);
        $price3Array = explode(',', $price3);
        $quantity3Array = explode(',', $quantity3);
        $description3Array = explode(',', $description3);

        $extra_descriptions = array();
        for($j = 0; $j < count($name3Array); $j++) {
            $extra_description=$name3Array[$j].'^'.$price3Array[$j].'^'.$quantity3Array[$j].'^'.$description3Array[$j];
            $extra_descriptions[] = $extra_description;
        }
        $extra = implode('$', $extra_descriptions);
    }

    date_default_timezone_set('Asia/Singapore');
    $record_date = date('Y-m-d H:i:s');


   $stmt = $conn->prepare("INSERT INTO record (appointmentID, pet_name, comment, date, extra,discount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $appointmentID, $name, $comment, $record_date, $extra, $discount_percent);
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
            echo 'window.location.href = "Clinic-Record-List.php";';
            echo '</script>';
    }}} else {
        echo '<script type="text/javascript">';
        echo 'alert("Insertion error, Please try again.");';
        echo 'window.location.href = "Clinic-Record-List.php";';
        echo '</script>';
    }
    $stmt->close();
    $conn->close();
}

?>
