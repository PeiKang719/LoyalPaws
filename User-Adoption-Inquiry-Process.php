<?php

include('Connection.php');

$aid = $_POST['aid'];
$pid = $_POST['pid'];
$experience = $_POST['experience'];
$occupation = $_POST['occupation'];
$lifestyle = $_POST['lifestyle'];
$pet_training = $_POST['pet-training'];
$residence = $_POST['residence'];
$residence_details = $_POST['residence-details'];
$commitment = $_POST['commitment'];
$pet_grooming = $_POST['pet-grooming'];
$pet_expenses = $_POST['pet-expenses'];
$comments = $_POST['comments'];


date_default_timezone_set('Asia/Singapore');
$submit_date = date('Y-m-d');


    $sql2 = "INSERT INTO inquiry(petID,adopterID,question1,question2,question3,question4,question5,question6,question7,question8,question9,question10,submit_date,status)
    VALUES ('$pid','$aid','$experience','$occupation','$lifestyle','$pet_training','$residence','$residence_details','$commitment','$pet_grooming','$pet_expenses','$comments','$submit_date','Pending')";

    if ($conn->query($sql2) === TRUE) {
        echo "<script type='text/javascript'>";
         echo 'window.location.href = "User-Adoption-Inquiry-Pending.php";';
        echo"</script>";
    } else { 
        echo "<script type='text/javascript'>alert('Error Submit The Form,Please Try Again.')</script>";
    }


$conn->close();
?>
