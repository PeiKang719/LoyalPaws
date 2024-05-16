<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../media/tabIcon.png">
  </head>

  <body>

<?php
$id=$_GET['id'];
$id2=$_GET['iid'];
$c=$_GET['c'];
$reason=$_GET['reason'];

include '../Database/Connection.php';
$sql = "SELECT CONCAT(a.firstName,' ',a.lastName) AS adopterName,a.email,b.name FROM inquiry i,adopter a,pet p,breed b WHERE i.adopterID=a.adopterID AND i.petID=p.petID AND p.breedID=b.breedID AND inquiryID='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$email = $row['email'];
$adopterName = $row['adopterName'];
$breed = $row['name'];

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ongpeikang57@gmail.com';              //SMTP username
    $mail->Password   = 'czisarbjzuxbenwt';                        //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          //Enable TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to

    //Recipients
    $mail->setFrom('admin@testing.com', 'Admin');
    $mail->addAddress($email, $adopterName);                          //Add a recipient
    //Content
    $mail->isHTML(true);                                         //Set email format to HTML
    $mail->Subject = 'Application Rejected';
    $mail->Body = '<div style="width: 85%; height: 100%; padding: 70px 60px; display: flex; flex-direction: column; justify-content: center;text-align:center">
    <div style="background: #f9f9f9; height: 10%; width: 100%; box-shadow: 0 2px 4px 0 #dfdfdf !important;display:flex; justify-content: center;align-items: center;">
  <img  src="https://i.postimg.cc/6qgrD36t/lp.png" alt="Logo" width="50%" height="auto" style="margin-top:2%">
</div>
    <br><br>
    
    <p style="width: 100%; font-size: 25px; font-weight: bold;">Application Rejected</p>
    <p style="width: 100%; font-size: 20px; color: #4d4d4d;">We regret to inform you that your adoption request for '.$breed.' has been rejected by the pet owner. We understand that this may come as disappointing news, and we sincerely apologize for any inconvenience this may have caused.

Please understand that the decision was made after careful consideration, and it does not reflect on your suitability as a pet owner. There could be various reasons for the decision, including factors related to the pet`s needs, the pet owner`s preferences, or other circumstances.</p><br><br>
    <p style="width: 100%; font-size: 20px; color: #4d4d4d;"><b>Reason:</b> '.$reason.'</p>
</div>';

    $mail->send();
    
    if($c=='rejected'){
        echo '<script type="text/javascript">';
        echo 'window.location.href = "Seller_Adoption-Form-Process.php?id='.$id.'&c=rejected&reason=' . urlencode($reason) . '";';
        echo '</script>';
    }elseif($c=='sreject'){
        echo '<script type="text/javascript">';
        echo 'window.location.href = "Seller_Adoption-Form-Process.php?id=" + ' . $id . ' + "&iid=" + ' . $id2 . ' + "&c=sreject&reason=' . urlencode($reason) . '";';
        echo '</script>';
    }
} catch (Exception $e) {
    echo '<script type="text/javascript">';
    echo 'alert("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");';
    echo '</script>';
}?>

</body>
</html>