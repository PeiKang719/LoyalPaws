<?php
session_start();

// Check if a session exists, then destroy it
if (isset($_SESSION['adminID']) || isset($_SESSION['adopterID']) || isset($_SESSION['sellerID']) || isset($_SESSION['shopID'])  || isset($_SESSION['vet'])) {
    session_destroy();
}?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign Up-LoyalPaws</title>
  <link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="User/css/UserStyle.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<style>
@keyframes fade-in {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
  </style>
<body style="margin: 0;background-image: url(media/login.jpg);background-repeat: no-repeat;background-size: 1550px 800px;">

<?php
include 'Database/Connection.php';
$timezone = new DateTimeZone('Asia/Kuala_Lumpur');
$current_date = new DateTime('now', $timezone);
$expired = $current_date->format('Y-m-d');

$sql = "UPDATE pet SET availability='N' WHERE return_date IS NOT NULL AND return_date !='0000-00-00' AND return_date<='$expired' ";
$conn->query($sql);
$conn->close();
?>
<div class="side-container"> 
    <p id="toggle-word2">Don't have an account?</p>
    <button id="toggle-btn2" type="button" class="side-container-button" >Sign Up</button>
</div>

<div class="login-container" style="overflow-y:hidden">
  <div style="padding-left:30px;padding-top:10px;border-bottom: 2px solid #4d4d4d;"><img src="media/lp.png" width="250" height="70" >
    <a href="RegisterLogin/SignUp.php?c=1"><button type="button" class="signupbtn">Sign Up</button></a>
    </div>
  <div class="signup-form">
    <form action="RegisterLogin/Login-Authentication.php" method="POST">
        <div class="tab" id="tab-signup" style="display:block;animation: fade-in 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) ;">
        <p class="signup-form-header" > Login To Account</p><br>
    
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password1" required><br><br><br><br><br>
            <button type="submit" class="signup-button">Login</button>
        </div>
      </form>
            </div>
</div>
<script type="text/javascript">
    function changeColor2(radio) {
  var radios = document.getElementsByName(radio.name);
  for (var i = 0; i < radios.length; i++) {
    var radioLabel = radios[i].parentNode;
    if (radios[i].checked) {
      radioLabel.style.backgroundColor = "#cfe8fc";
      radioLabel.style.borderColor = "#6fb9f6";
    } else {
      radioLabel.style.backgroundColor = "white";
      radioLabel.style.borderColor = "#b3b3b3";
    }
  }
}


const toggleBtn2 = document.getElementById('toggle-btn2');
const sideContainer = document.querySelector('.side-container');
const loginContainer = document.querySelector('.login-container');

toggleBtn2.addEventListener('click', () => {
  sideContainer.classList.add('move-left');
  loginContainer.classList.add('move-right');
  setTimeout(() => {
    window.location.href = 'RegisterLogin/SignUp.php?c=1';
  }, 700);
});



</script>
</body>

</html>
