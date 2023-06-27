<?php

include('Connection.php');

date_default_timezone_set('Asia/Singapore');
$booking_date = date('Y-m-d H:i:s');

 if ($_GET['action']=='insert') {
    $clinicID = $_POST['cid'];
    $adopterID = $_POST['aid'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $selectedPet = $_POST['selectedPet'];
    $appointment_description = $_POST['appointment_description'];

    if($selectedPet!=0){
        $sql = "INSERT INTO clinic_appointment(clinicID,petID,date,time,booking_date,description,status)
        VALUES ('$clinicID' ,'$selectedPet','$date','$time','$booking_date','$appointment_description','Uncompleted')";

        if ($conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>";
             echo 'window.location.href = "User-Clinic-Appointment-Success.php?action=insert";';
            echo"</script>";
        } else { 
            echo "<script type='text/javascript'>alert('Error Book The Appointment,Please Try Again.')</script>";
        }
    }elseif($selectedPet==0){
        $sql = "INSERT INTO clinic_appointment(clinicID,adopterID,date,time,booking_date,description,status)
        VALUES ('$clinicID' ,'$adopterID','$date','$time','$booking_date','$appointment_description','Uncompleted')";

        if ($conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>";
             echo 'window.location.href = "User-Clinic-Appointment-Success.php?action=insert";';
            echo"</script>";
        } else { 
            echo "<script type='text/javascript'>alert('Error Book The Appointment,Please Try Again.')</script>";
        }
    }

    

$conn->close();
}

elseif($_GET['action']=='update'){
    $appointmentID = $_GET['appointmentID'];
    $sql="SELECT petID FROM clinic_appointment WHERE appointmentID=$appointmentID";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $check=$row['petID'];

    $date = $_POST['date'];
    $time = $_POST['time'];
    $selectedPet = $_POST['selectedPet'];
    $adopterID = $_POST['aid'];
    $appointment_description = $_POST['appointment_description'];

   if($check==NULL){
        if($selectedPet==0){
            $sql3 = "UPDATE clinic_appointment SET date='$date', time='$time',description='$appointment_description' WHERE appointmentID='$appointmentID'";
        }else{
            $sql3 = "UPDATE clinic_appointment SET date='$date', time='$time',description='$appointment_description',petID='$selectedPet',adopterID=NULL WHERE appointmentID='$appointmentID'";
        }
    }else{
        if($selectedPet==0){
            $sql3 = "UPDATE clinic_appointment SET date='$date', time='$time',description='$appointment_description',petID=NULL,adopterID='$adopterID' WHERE appointmentID='$appointmentID'";
        }else{
            $sql3 = "UPDATE clinic_appointment SET date='$date', time='$time',description='$appointment_description',petID='$selectedPet' WHERE appointmentID='$appointmentID'";
        }
    }

    if ( $conn->query($sql3) === TRUE) {
        echo "<script type='text/javascript'>";
     echo 'window.location.href = "User-Clinic-Appointment-Success.php?action=update&appointmentID=' . $appointmentID . '";';
      echo "</script>";

    } else { 
        echo "<script type='text/javascript'>alert('Error Reschedule The Appointment,Please Try Again.')</script>";
    }

$conn->close();
}


elseif($_GET['action']=='delete'){
    $appointmentID = $_GET['appointmentID'];
    $sql = "DELETE FROM clinic_appointment WHERE appointmentID=$appointmentID";
  $result = mysqli_query($conn, $sql);

  if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Cancelled appointment successfully");';
    echo 'window.location.href = "User-Pet-Appointment-List.php?s=Appointment";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to cancel the appointment");';
    echo 'window.location.href = "User-Pet-Appointment-List.php?s=Appointment";';
    echo '</script>';
}
$conn->close();
}
//////////////////////////////////////////////////////////////////

elseif($_GET['action']=='payment'){
    $recordID = $_GET['recordID'];
    $amount = $_GET['amount'];
    $transactionID = $_GET['transactionID'];

    date_default_timezone_set('Asia/Singapore');
  $completedate = date('Y-m-d H:i:s');

   $sql = "INSERT INTO clinic_payment(transactionID,amount,recordID,date)
        VALUES ('$transactionID' ,'$amount','$recordID','$completedate')";

        if ($conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>";
             echo 'window.location.href = "User-Clinic-Appointment-Success.php?action=payment";';
            echo"</script>";
        } else { 
            echo "<script type='text/javascript'>alert('Error Payment,Please Try Again.')</script>";
        }


$conn->close();
}

?>
