<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../media/tabIcon.png">
  </head>

  <body>

<?php
$name=$_GET['name'];
$email=$_GET['email'];

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
    $mail->addAddress($email, $name);                          //Add a recipient

    //Content
    $mail->isHTML(true);                                         //Set email format to HTML
    $mail->Subject = 'Account Verification';
    $mail->Body = '<div style="width: 85%; height: 100%; padding: 70px 60px; display: flex; flex-direction: column; justify-content: center;text-align:center">
    <div style="background: #f9f9f9; height: 10%; width: 100%; box-shadow: 0 2px 4px 0 #dfdfdf !important;display:flex; justify-content: center;align-items: center;">
  <img  src="https://i.postimg.cc/6qgrD36t/lp.png" alt="Logo" width="50%" height="auto" style="margin-top:2%">
</div>
    <br><br>
    <img style="width: 40%; height: auto; margin-top: 1%;margin-bottom: 1%;position:relative;margin-left:auto;margin-right:auto;"  src="https://i.postimg.cc/13x0BfYK/email-male.png" alt="Vet">
    <br><br>
    <p style="width: 100%; font-size: 25px; font-weight: bold;">Account Activated</p>
    <p style="width: 100%; font-size: 28px; color: #4d4d4d;">Thank you for your registration, your information has been verified. Your account is now active.</p>
    <p style="width: 100%; font-size: 25px; color: #4d4d4d;">Click the button below to login to your account.</p>
    <br><br>
    <a href="https://www.google.com" style="width: 60%; height: 70px;position:relative;margin-left:auto;margin-right:auto;cursor:pointer;"><button style="width: 100%; height: 100%; background-color: #00a8de; font-size: 25px; color: white; border-radius: 10px; border: 0;">Login to account</button></a>
    <p  style="font-size:15px; width: 100%; color: #4d4d4d;">*Your application to join the clinic has been sent to the clinic management.*<br>*Please ask the clinic management to approve your application*</p>
</div>';

    $mail->send();
    echo '<script type="text/javascript">';
    echo 'alert("Mesage has been sent");';
    echo '</script>';
} catch (Exception $e) {
    echo '<script type="text/javascript">';
    echo 'alert("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");';
    echo '</script>';
}?>

</body>
</html>