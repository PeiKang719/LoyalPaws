<?php

include('Connection.php');


if($_GET['action']=='assign'){
    $vetID = $_POST['vet'];
    $appointmentID = $_POST['appointmentID'];


   $sql3 = "UPDATE clinic_appointment SET vetID='$vetID' WHERE appointmentID='$appointmentID'";

    if ( $conn->query($sql3) === TRUE) {
       echo "<script type='text/javascript'>";
        echo "alert('Appointment assigned successfully.');";
        echo "parent.location.reload();";
        echo "</script>";


    } else { 
        echo "<script type='text/javascript'>alert('Error Assign The Appointment,Please Try Again.')</script>";
    }

$conn->close();
}


elseif($_GET['action']=='delete'){
    $appointmentID = $_GET['appointmentID'];
    $appointment = $_GET['appointment'];


   $sql3 = "DELETE FROM clinic_appointment WHERE appointmentID='$appointmentID'";

    if ( $conn->query($sql3) === TRUE) {
       echo "<script type='text/javascript'>";
        echo "alert('Appointment deleted successfully.');";
        echo "window.location.href = 'Clinic-Appointment.php?appointment=$appointment';";
        echo "</script>";


    } else { 
        echo "<script type='text/javascript'>alert('Error Delete The Appointment,Please Try Again.')</script>";
    }

$conn->close();
}


elseif($_GET['action']=='reschedule'){
    $appointmentID = $_POST['appointmentID'];
    $appointment = $_POST['appointment'];
    $date = $_POST['date'];
    $time = $_POST['radio'];



   $sql3 = "UPDATE clinic_appointment SET date='$date', time='$time' WHERE appointmentID='$appointmentID'";

    if ( $conn->query($sql3) === TRUE) {
       echo "<script type='text/javascript'>";
        echo "alert('Appointment rescheduled successfully.');";
         echo "parent.window.location.href = 'Clinic-Appointment.php?appointment=$appointment';";
        echo "</script>";


    } else { 
        echo "<script type='text/javascript'>alert('Error Reschedule The Appointment,Please Try Again.')</script>";
    }

$conn->close();
}

elseif($_GET['action']=='reassign'){
    $appointmentID = $_GET['appointmentID'];
    $vetID = $_POST['vet'];

   $sql3 = "UPDATE clinic_appointment SET vetID='$vetID' WHERE appointmentID='$appointmentID'";

    if ( $conn->query($sql3) === TRUE) {
       echo "<script type='text/javascript'>";
        echo "alert('Appointment reassigned successfully.');";
         echo "parent.window.location.href = 'Clinic-Appointment.php?appointment=assigned';";
        echo "</script>";


    } else { 
        echo "<script type='text/javascript'>alert('Error Reassign The Appointment,Please Try Again.')</script>";
    }

$conn->close();
}
?>
