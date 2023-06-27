<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up-LoyalPaws</title>
  <link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="UserStyle.css">
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

input {
  font-size: 3rem;
  width: 2.6rem;
  border: 2px solid #aaa;
  text-align: center;
  box-shadow: 0 0 8px rgba(0,0,0,0.25);
  padding: 10px;
  height: 50px;
  margin-left: 1%;
}
input:focus {
  border: 2px solid #0099ff;
  outline: none;
}

.digits {
    margin-top: 5%;
  padding: 20px;
  display: inline-block;
  width: 100%;
  display: flex;
  justify-content: left;
  padding-left: 13.5%;
}
  </style>
<body style="margin: 0;background-image: url(media/login.jpg);background-repeat: no-repeat;background-size: 1550px 800px;">


<div class="side-container move-left"> 
    <p id="toggle-word1">Already have an account?</p>
    <button id="toggle-btn1" type="button" class="side-container-button" >Login</button>
</div>
<div class="signup-container move-right">
    <div style="padding-left:30px;padding-top:10px;border-bottom: 2px solid #4d4d4d;"><img src="media/lp.png" width="250" height="70" >
    <a href="Login.php"><button type="button" class="loginbtn">Login</button></a>
    </div>
    <?php
    $username = $_POST['username'];
    $password = $_POST['password1'];
    $ic = $_POST['ic'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $focus_area = $_POST['area'];
    $focus = implode(',', $focus_area);
    $clinic = $_POST['clinic'];
    $contact = $_POST['contact'];
    $apc=$_FILES['apc']['name'];

if(isset($_FILES['apc'])) {
    $target_dir = "vet_apc/";
    $unique_name = time() . '_' .$_FILES['apc']['name'];
    $target_file = $target_dir . $unique_name;

    if (move_uploaded_file($_FILES["apc"]["tmp_name"], $target_file)) {
        
    } 
} 

$code=(rand(1000,9999));
 include 'SignUp-Email.php'; 

date_default_timezone_set("Asia/Kuala_Lumpur");
$duration=strtotime("+10 Minutes");
$expired=date("h:i:sa", $duration)?>

<div class="signup-form">

            <form id="verifyForm" action="SignUp-Account.php?r=vet" method="post"  enctype="multipart/form-data">
        <div class="tab-signup" id="tab-signup"  style="display:block;animation: fade-in 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) ;">
        <a href="SignUp.php?c=vet"><p id="back" style="color:#4d4d4d;position: relative;left: -20%">&larr;Back </p></a>
        <p class="signup-form-header" > Email Verification </p>
            <input type="hidden"  name="username" value='<?php echo$username ?>'>
            <input type="hidden"  name="password" value=<?php echo$password ?>>
            <input type="hidden"  name="ic" value=<?php echo$ic ?>>
            <input type="hidden"  name="name" value='<?php echo$name ?>'>
            <input type="hidden"  name="email" value=<?php echo$email ?>>
            <input type="hidden"  name="area" value=<?php echo$focus ?>>
            <input type="hidden"  name="clinic" value=<?php echo$clinic ?>>
            <input type="hidden"  name="contact" value=<?php echo$contact ?>>
            <input type="hidden"  name="apc" value="'<?php echo $unique_name; ?>'">

            <label id="professional-focus" style="left:-5%;position:relative;">Enter the code sent to <?php echo $email ?></label>
            <br>
            <div class="digits">
              <input type="text" name="digit1" />
              <input type="text" name="digit2" />
              <input type="text" name="digit3" />
              <input type="text" name="digit4" />  
            </div>
            <br>
            <button type="button" class="signup-button" onclick="verify('<?php echo $code ?>','<?php echo $expired ?>')">Verify</button>
            <br><br><br><br>
        </div>
    </form>
    </div>
</div>

<script type="text/javascript">
    document.querySelector("input").focus();

document.querySelector(".digits").addEventListener("input", function({ target, data }){

  // Exclude non-numeric characters (if a value has been entered)
  data && ( target.value = data.replace(/[^0-9]/g,'') );
  
  const hasValue = target.value !== "";
  const hasSibling = target.nextElementSibling;
  const hasSiblingInput = hasSibling && target.nextElementSibling.nodeName === "INPUT";

  if ( hasValue && hasSiblingInput ){

    target.nextElementSibling.focus();
  
  } 

});

function verify(n,x) {
        if (validateForm(n,x)){      
          document.getElementById("verifyForm").submit();
          } 
        else{
            document.getElementById("verifyForm").reset();  
        }   
}

function validateForm(n,x) {

  let a = document.forms["verifyForm"]["digit1"].value;
  let b = document.forms["verifyForm"]["digit2"].value;
  let c = document.forms["verifyForm"]["digit3"].value;
  let d = document.forms["verifyForm"]["digit4"].value;
  let result = a.concat (b, c, d);
  let currentTime = getCurrentTime();
  if (a == "" || b == "" || c == "") {
    alert("All fields must be filled out");
    return false;
    }
  else if (result == n ) {
    const timeFormat = /(\d{2}):(\d{2}):(\d{2})(am|pm)/;
    const [, hoursA, minutesA, secondsA, periodA] = currentTime.match(timeFormat);
    const [, hoursB, minutesB, secondsB, periodB] = x.match(timeFormat);

    // Convert to 24-hour format
    let hours24A = parseInt(hoursA);
    let hours24B = parseInt(hoursB);

    if (periodA === "pm" && hours24A < 12) {
      hours24A += 12;
    } else if (periodA === "am" && hours24A === 12) {
      hours24A = 0;
    }

    if (periodB === "pm" && hours24B < 12) {
      hours24B += 12;
    } else if (periodB === "am" && hours24B === 12) {
      hours24B = 0;
    }

    if (hours24B > hours24A) {
        return true;
    } else if (hours24B < hours24A) {
      alert("Invalid code");
        return false;
    } else if (minutesB > minutesA) {
        return true;
    } else if (minutesB < minutesA) {
      alert("Invalid code");
         return false;
    } else if (secondsB > secondsA) {
        return true;
    } else if (secondsB < secondsA) {
      alert("Invalid code");
        return false;
    } else {
      alert("Invalid code");
        return false;
    }
    
    }
    else if (result !== n ){
        alert("Invalid code");
        return false;
    }
    else
        {return true;}
}
    



function getCurrentTime() {
  const date = new Date();
  let hours = date.getHours();
  let minutes = date.getMinutes();
  let seconds = date.getSeconds();
  let amOrPm = "am";

  // Adjust hours and set am/pm
  if (hours > 12) {
    hours -= 12;
    amOrPm = "pm";
  }

  // Pad single-digit hours, minutes, and seconds with leading zeros
  hours = String(hours).padStart(2, "0");
  minutes = String(minutes).padStart(2, "0");
  seconds = String(seconds).padStart(2, "0");

  // Format the time string
  const formattedTime = `${hours}:${minutes}:${seconds}${amOrPm}`;

  return formattedTime;
}

const toggleBtn1 = document.getElementById('toggle-btn1');
const sideContainer = document.querySelector('.side-container');
const signupContainer = document.querySelector('.signup-container');

toggleBtn1.addEventListener('click', () => {
  sideContainer.classList.remove('move-left');
  signupContainer.classList.remove('move-right');
  setTimeout(() => {
    window.location.href = 'Login.php';
  }, 900);
});

if (window.location.href.indexOf('success') > -1) {
  clickButton();
}

function clickButton() {
  console.log('hihi');
  setTimeout(() => {
    sideContainer.classList.remove('move-left');
    signupContainer.classList.remove('move-right');
  }, 0); // add a delay of 100 milliseconds before removing the classes
  setTimeout(() => {
    window.location.href = 'Login.php';
  }, 900); // wait for 700 milliseconds (the duration of the CSS transition) before redirecting
}
</script>

</body>
</html>






?>