<?php

        
        $id=$_GET['i'];
        $ic=$_GET['c'];
        $email=$_GET['e'];
        $name=$_GET['name'];
if (isset($_GET['p'])) {
    $p = $_GET['p'];
    if ($p == 'approve') {
        approve_vet($ic, $id,$email,$name);
    } else if ($p == 'approve-clinic') {
        approve_vet_clinic($ic, $id,$email,$name);
    } else if ($p == 'reject') {
        reject_vet($ic, $id,$email,$name);
    }
}

function approve_vet($ic, $id,$email,$name){
    include('Connection.php');
    $ic = "C." . $ic;
  $sql = "UPDATE vet SET ic='$ic' WHERE vetID=$id";
  $result = mysqli_query($conn, $sql);

  if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Vet has been approved");';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to approve vet");';
    echo '</script>';
}

$conn->close();
}

function approve_vet_clinic($ic, $id,$email,$name)
{
    include('Connection.php');
    $sql = "UPDATE vet SET ic='$ic' WHERE vetID=$id";

    if ($conn->query($sql) === TRUE) {
        $sql2 = "UPDATE clinic SET vetID = $id WHERE clinicID = (SELECT clinicID FROM vet WHERE vetID = $id)";

        if ($conn->query($sql2) === TRUE) {
            echo '<script type="text/javascript">';
            echo 'alert("Vet and clinic have been approved");';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Failed to approve vet and clinic");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Failed to approve vet and clinic");';
        echo '</script>';
    }

    $conn->close();
}

function reject_vet($ic, $id,$email,$name){
    include('Connection.php');
    $ic = "F." . $ic;
  $sql = "UPDATE vet SET ic='$ic' WHERE vetID=$id";
  $result = mysqli_query($conn, $sql);

  if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Vet has been rejected");';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to reject vet");';
    echo '</script>';
}

$conn->close();
}


