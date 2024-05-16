<?php

include('../Database/Connection.php');

if(isset($_POST['sid'])){
$sid = $_POST['sid'];
$pid = $_POST['pid'];
$aid = $_POST['aid'];
$date = $_POST['date'];
$time = $_POST['time'];}
date_default_timezone_set('Asia/Singapore');
$book_date = date('Y-m-d H:i:s');
 if ($_GET['c']=='purchase') {
    $transactionId = $_GET['transactionId'];
    $adopterID = $_GET['aid'];
    $date = $_GET['date'];
    $time = $_GET['time'];
    $pid = $_GET['pid'];

    $sql2 = "INSERT INTO pet_payment(transactionId,adopterID,visit_date,visit_time,book_date,status,petID)
    VALUES ('$transactionId' ,'$adopterID','$date','$time','$book_date','appointment','$pid')";

    if ($conn->query($sql2) === TRUE) {
        echo "<script type='text/javascript'>";
         echo 'window.location.href = "User-Adoption-Book-Success.php?i=purchase";';
        echo"</script>";
    } else { 
        echo "<script type='text/javascript'>alert('Error Book The Pet,Please Try Again.')</script>";
    }

$conn->close();
}
elseif($_GET['c']=='adoption'){
    $iid = $_POST['iid'];

    $sql2 = "INSERT INTO pet_payment(adopterID,visit_date,visit_time,book_date,status,petID)
    VALUES ('$aid','$date','$time','$book_date','Decision','$pid')";
    $sql3 = "UPDATE inquiry SET status='Decision' WHERE inquiryID=$iid";
    if ($conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE) {
        echo "<script type='text/javascript'>";
         echo 'window.location.href = "User-Adoption-Book-Success.php?i=adoption";';
        echo"</script>";
    } else { 
        echo "<script type='text/javascript'>alert('Error Book The Appointment,Please Try Again.')</script>";
    }

$conn->close();
}

elseif($_GET['c']=='update'){
    $mid = $_GET['action'];


   $sql3 = "UPDATE pet_payment SET visit_date='$date', visit_time='$time' WHERE paymentID='$mid'";

    if ( $conn->query($sql3) === TRUE) {
        echo "<script type='text/javascript'>";
      echo 'window.location.href = "User-Adoption-Book-Success.php?mid='.$mid.'&i=adoption";';
      echo "</script>";

    } else { 
        echo "<script type='text/javascript'>alert('Error Update The Appointment,Please Try Again.')</script>";
    }

$conn->close();
}

elseif($_GET['u']=='udecision'){
    $mid = $_GET['iid'];
    $sql5 ="SELECT p.price from pet p, pet_payment m where p.petID=m.petID AND paymentID='$mid'";
    $result5 = $conn->query($sql5);
  $row5 = $result5->fetch_assoc();

     $sql2 ="SELECT status FROM pet_payment WHERE paymentID='$mid'";
     $result2 = $conn->query($sql2);
     $row2 = $result2->fetch_assoc();

     if($row2['status']=='Decision'){
     $sql = "UPDATE pet_payment SET status='y' WHERE paymentID='$mid'";
     if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Accept the adoption successfully. Please note that the final decision of adoption is confirmed only after both the adopter and the pet owner have accepted the adoption.')</script>";
    echo "<script type='text/javascript'>window.location.href='User-Adoption-List.php?s=Appointment';</script>";
} else {
    echo "<script type='text/javascript'>alert('Error accepting the adoption. Please try again.')</script>";
}

}elseif($row2['status']=='Y'){
     $sql3 = "UPDATE pet_payment SET status='Payment' WHERE paymentID='$mid'";

    if ($conn->query($sql3) === TRUE) {
    echo "<script type='text/javascript'>alert('Accept the adoption successfully. Your adoption is approved by pet owner. You can proceed to make payment.')</script>";
    echo "<script type='text/javascript'>window.location.href='User-Adoption-List.php?s=Appointment';</script>";
} else {
    echo "<script type='text/javascript'>alert('Error accepting the adoption. Please try again.')</script>";
}
}elseif($row2['status']=='Free'){
  date_default_timezone_set('Asia/Singapore');
  $completedate = date('Y-m-d H:i:s');
     $sql3 = "UPDATE pet_payment SET status='Complete', complete_date='$completedate' WHERE paymentID='$mid'";
     $sql4 = "UPDATE pet AS a SET a.adopterID = (SELECT m.adopterID FROM pet_payment AS m WHERE m.paymentID = '$mid') WHERE a.petID = (SELECT petID FROM pet_payment WHERE paymentID = '$mid');";

    if ($conn->query($sql3) === TRUE && $conn->query($sql4) === TRUE) {
    echo "<script type='text/javascript'>alert('Accept the adoption successfully. Your adoption is approved by pet owner. You are the new owner of the pet now.')</script>";
    echo "<script type='text/javascript'>window.location.href='User-Adoption-List.php?s=Appointment';</script>";
} else {
    echo "<script type='text/javascript'>alert('Error accepting the adoption. Please try again.')</script>";
}
}
$conn->close();
}

elseif($_GET['u']=='upayment'){
    $mid = $_GET['iid'];
    $pid = $_GET['pid'];
    $transactionId = $_GET['transactionId'];

    date_default_timezone_set('Asia/Singapore');
  $completedate = date('Y-m-d H:i:s');

   $sql3 = "UPDATE pet_payment SET status='Complete', complete_date='$completedate',transactionId='$transactionId' WHERE paymentID='$mid'";

   $sql4 = "UPDATE inquiry SET status='Rejected' WHERE petID='$pid' AND status='Pending'";
   $sql5 = "UPDATE inquiry SET status='Complete' WHERE petID='$pid' AND status='Decision'";

    $sql6 = "UPDATE pet AS a SET a.adopterID = (SELECT m.adopterID FROM pet_payment AS m WHERE m.paymentID = '$mid') WHERE a.petID = (SELECT petID FROM pet_payment WHERE paymentID = '$mid');";

    if ($conn->query($sql3) === TRUE && $conn->query($sql4)=== TRUE && $conn->query($sql5)=== TRUE && $conn->query($sql6)=== TRUE) {
   echo "<script type='text/javascript'>window.location.href='User-Adoption-Book-Success.php?mid=" . $mid . "&i=adoption-complete';</script>";


} else {
    echo "<script type='text/javascript'>alert('Error payment. Please try again.')</script>";
}


$conn->close();
}

elseif($_GET['r']=='reject'){
    $inquiryID = $_GET['id'];
    $sql = "UPDATE inquiry SET status='Rejected' WHERE inquiryID=$inquiryID";
  $result = mysqli_query($conn, $sql);

  if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Rejected the adoption");';
    echo 'window.location.href = "User-Adoption-List.php";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to reject the adoption");';
    echo 'window.location.href = "User-Adoption-List.php";';
    echo '</script>';
}
$conn->close();
}

elseif($_GET['r']=='fail'){
    $paymentID = $_GET['id'];
    $sql = "UPDATE pet_payment SET status='Fail' WHERE paymentID=$paymentID";
  $result = mysqli_query($conn, $sql);

  if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Rejected the adoption");';
    echo 'window.location.href = "User-Adoption-List.php?s=Appointment";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to reject the adoption");';
    echo 'window.location.href = "User-Adoption-List.php?s=Appointment";';
    echo '</script>';
}
$conn->close();
}


elseif($_GET['u']=='orderpayment'){
    $mid = $_GET['iid'];
    $pid = $_GET['pid'];
    $transactionId = $_GET['transactionId'];

    date_default_timezone_set('Asia/Singapore');
  $completedate = date('Y-m-d H:i:s');

   $sql3 = "UPDATE pet_payment SET status='complete', complete_date='$completedate',transactionId='$transactionId' WHERE paymentID='$mid'";
   $sql6 = "UPDATE pet AS a SET a.adopterID = (SELECT m.adopterID FROM pet_payment AS m WHERE m.paymentID = '$mid') WHERE a.petID = (SELECT petID FROM pet_payment WHERE paymentID = '$mid');";

    if ($conn->query($sql3) === TRUE && $conn->query($sql6) === TRUE) {
   echo "<script type='text/javascript'>window.location.href='User-Adoption-Book-Success.php?mid=" . $mid . "&i=purchase-complete';</script>";


} else {
    echo "<script type='text/javascript'>alert('Error payment. Please try again.')</script>";
}


$conn->close();
}


elseif($_GET['r']=='cancel'){
    $paymentID = $_GET['id'];
    $sql = "UPDATE pet_payment SET status='cancel' WHERE paymentID=$paymentID";
  $result = mysqli_query($conn, $sql);

  if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Cancelled order successfully");';
    echo 'window.location.href = "User-Order-List.php?s=Appointment";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to cancel the order");';
    echo 'window.location.href = "User-Order-List.php?s=Appointment";';
    echo '</script>';
}
$conn->close();
}

?>
