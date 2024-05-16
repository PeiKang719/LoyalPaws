 <?php 

  $id=$_GET['i'];
        $ic=$_GET['c'];

if (isset($_GET['p'])) {
    $p = $_GET['p'];
    if ($p == 'approve') {
        approve_vet($ic, $id);
    } 
     else if ($p == 'reject') {
        reject_vet($ic, $id);
    }
    else if($p == 'delete'){
        delete_vet($id);
    }
}

 

function approve_vet($ic,$id){
    include('../Database/Connection.php');
  $sql = "UPDATE vet SET ic='$ic' WHERE vetID=$id";
  $result = mysqli_query($conn, $sql);

  if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Vet has been approved to join your clinic.");';
    echo 'window.parent.location.href = "Clinic-Veterinarian.php?c=vet&t=pending";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to approve vet to join your clinic.");';
    echo '</script>';
}

$conn->close();
}
?>

<?php
function reject_vet($ic,$id){
    include('../Database/Connection.php');
    $ic = "F." . $ic;
  $sql = "UPDATE vet SET ic='$ic' WHERE vetID=$id";
  $result = mysqli_query($conn, $sql);

  if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Vet has been rejected to join your clinic.");';
    echo 'window.parent.location.href = "Clinic-Veterinarian.php?c=vet&t=pending";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to reject vet to join your clinic.");';
    echo '</script>';
}

$conn->close();
}
?>

<?php
function delete_vet($id){
    include('../Database/Connection.php');

  $sql2 = "UPDATE clinic_appointment SET vetID=NULL WHERE vetID=$id";
  $result2 = mysqli_query($conn, $sql2);

  if ($conn->query($sql2) === TRUE) {
  $sql = "DELETE FROM vet WHERE vetID=$id";
  $result = mysqli_query($conn, $sql);

  if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
} else {
    echo "Error Removing This Vet";
}

$conn->close();
}
}
?>

