<?php
include('Connection.php');

$qID=$_GET['id'];
$status=$_GET['c'];

if($status=='rejected'){

  $sql = "UPDATE inquiry SET status='Rejected' WHERE inquiryID=$qID";
  $result = mysqli_query($conn, $sql);

  if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Rejected applicant");';
    echo 'window.location.href = "Seller_Adoption-Form.php?id=' . 1 . '";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to reject the applicant");';
    echo 'window.location.href = "Seller_Adoption-Form.php?id=' . 1 . '";';
    echo '</script>';
}
$conn->close();
}

elseif($status=='appointment'){

  $sql = "UPDATE inquiry SET status='Appointment' WHERE inquiryID=$qID";
  $result = mysqli_query($conn, $sql);

  if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Approved applicant");';
    echo 'window.location.href = "Seller_Adoption-Form.php?id=' . 1 . '";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to approve the applicant");';
    echo 'window.location.href = "Seller_Adoption-Form.php?id=' . 1 . '";';
    echo '</script>';
}
$conn->close();
}

elseif($status=='sdecision'){
   $sql5 ="SELECT p.price from pet p, pet_payment m where p.petID=m.petID AND paymentID=$qID";
    $result5 = $conn->query($sql5);
  $row5 = $result5->fetch_assoc();

  $sql2 ="SELECT status FROM pet_payment WHERE paymentID=$qID";
  $result2 = $conn->query($sql2);
  $row2 = $result2->fetch_assoc();
  if($row2['status']=='Decision'){
    if($row5['price']>0){
    $sql = "UPDATE pet_payment SET status='Y' WHERE paymentID=$qID";
    }else{
   $sql = "UPDATE pet_payment SET status='Free' WHERE paymentID=$qID"; 
  }
      $result = mysqli_query($conn, $sql);

      if ($conn->query($sql) === TRUE) {
        echo '<script type="text/javascript">';
        echo 'alert("Approved adoption of this applicant ");';
        echo 'window.location.href = "Seller_Adoption-Form.php?adoption=appointment&id=' . 1 . '";';
        echo '</script>';
    }
     else { 
        echo '<script type="text/javascript">';
        echo 'alert("Failed to approve the applicant");';
        echo 'window.location.href = "Seller_Adoption-Form.php?adoption=appointment&id=' . 1 . '";';
        echo '</script>';
    }
  }
  elseif($row2['status']=='y'){

  if($row5['price']>0){
  $sql = "UPDATE pet_payment SET status='Payment' WHERE paymentID=$qID";

  $result = mysqli_query($conn, $sql);

  if ($conn->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Approved adoption to the this applicant ");';
    echo 'window.location.href = "Seller_Adoption-Form.php?adoption=appointment";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to approve the applicant");';
    echo 'window.location.href = "Seller_Adoption-Form.php?id=' . 1 . '";';
    echo '</script>';
}
  }else{
    date_default_timezone_set('Asia/Singapore');
  $completedate = date('Y-m-d H:i:s');
   $sql = "UPDATE pet_payment SET status='Complete', complete_date='$completedate' WHERE paymentID=$qID";
   $sql6 = "UPDATE pet AS a SET a.adopterID = (SELECT m.adopterID FROM pet_payment AS m WHERE m.paymentID = '$qID') WHERE a.petID = (SELECT petID FROM pet_payment WHERE paymentID = '$qID');"; 

   $result = mysqli_query($conn, $sql);
   $result6 = mysqli_query($conn, $sql6);

  if ($conn->query($sql) === TRUE && $conn->query($sql6) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Approved adoption to the this applicant ");';
    echo 'window.location.href = "Seller_Adoption-Form.php?adoption=appointment";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to approve the applicant");';
    echo 'window.location.href = "Seller_Adoption-Form.php?id=' . 1 . '";';
    echo '</script>';
}
  }
  
$conn->close();
}
}

elseif($status=='sreject'){
  $inquiryID=$_GET['iid'];
  $sql = "UPDATE inquiry SET status='Rejected' WHERE inquiryID=$inquiryID";
  $sql2 = "DELETE FROM pet_payment WHERE paymentID=$qID";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);

  if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Rejected the adopter");';
    echo 'window.location.href = "Seller_Adoption-Form.php?id=' . 1 . '";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to reject the adopter");';
    echo 'window.location.href = "Seller_Adoption-Form.php?id=' . 1 . '";';
    echo '</script>';
}
$conn->close();
}

elseif($status=='restart'){
  $mid=$_GET['mid'];
  $sql = "UPDATE inquiry SET status='Rejected' WHERE inquiryID=$qID";
  $sql2 = "DELETE FROM pet_payment WHERE paymentID=$mid";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);

  if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Restarted finding potential adopter");';
    echo 'window.location.href = "Seller_Adoption-Form.php?id=' . 1 . '";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to Restarted finding potential adopter");';
    echo 'window.location.href = "Seller_Adoption-Form.php?id=' . 1 . '";';
    echo '</script>';
}
$conn->close();
}


elseif($status=='refund'){
  $transactionId=$qID;

  $sql2 = "UPDATE pet_payment SET status='refund' WHERE transactionId='$transactionId'";

  $result2 = mysqli_query($conn, $sql2);

  if ( $conn->query($sql2) === TRUE) {
    echo '<script type="text/javascript">';
    echo 'alert("Refunded to the customer successfully.");';
    echo 'window.location.href = "Seller_Orders.php?id=' . 1 . '";';
    echo '</script>';
}
 else { 
    echo '<script type="text/javascript">';
    echo 'alert("Failed to refund to the customer. Please try again.");';
    echo 'window.location.href = "Seller_Orders.php?id=' . 1 . '";';
    echo '</script>';
}
$conn->close();
}



?>
