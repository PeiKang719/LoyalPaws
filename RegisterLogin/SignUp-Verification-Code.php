<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up-LoyalPaws</title>
  <link rel="icon" type="image/png" href="../media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="../User/css/UserStyle.css">
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
<body style="margin: 0;background-image: url(../media/login.jpg);background-repeat: no-repeat;background-size: 1550px 800px;">


<div class="side-container move-left"> 
    <p id="toggle-word1">Already have an account?</p>
    <button id="toggle-btn1" type="button" class="side-container-button" >Login</button>
</div>
<div class="signup-container move-right">
    <div style="padding-left:30px;padding-top:10px;border-bottom: 2px solid #4d4d4d;"><img src="../media/lp.png" width="250" height="70" >
    <a href="../index.php"><button type="button" class="loginbtn">Login</button></a>
    </div>
    <?php

    if($_GET['role']=='vet'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $ic = $_POST['ic'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $focus_area = $_POST['focus_area'];
    $clinic = $_POST['clinic'];
    $contact = $_POST['contact'];
    $unique_name2=$_POST['unique_name2'];

  }elseif($_GET['role']=='pet-shop'){
    $name = $_POST['name'];
    $password = $_POST['password'];
    $shop_name = $_POST['shop_name'];
    $state = $_POST['state'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $description = $_POST['description'];
    $workingday = $_POST['workingday'];
    $opentime = $_POST['opentime'];
    $closetime = $_POST['closetime'];
    $unique_name = $_POST['unique_name'];
  }
  elseif($_GET['role']=='individual'){
    $name = $_POST['name'];
    $password = $_POST['password'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $state = $_POST['state'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $description = $_POST['description'];
    $workingday = $_POST['workingday'];
    $opentime = $_POST['opentime'];
    $closetime = $_POST['closetime'];
    $unique_name = $_POST['unique_name'];
  }
  elseif($_GET['role']=='adopter'){
    $name = $_POST['name'];
    $password = $_POST['password'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $state = $_POST['state'];
    $area = $_POST['area'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $unique_name = $_POST['unique_name'];
  }
  elseif($_GET['role']=='clinic'){
    $clinic_name=$_POST['clinic_name'];
    $state=$_POST['state'];
    $area=$_POST['area'];
    $address=$_POST['address'];
    $contact2=$_POST['contact2'];
    $email2=$_POST['email2'];
    $unique_name = $_POST['unique_name'];
    $description = $_POST['description'];
    $discount=$_POST['discount'];
    $workingday = $_POST['workingday'];
    $opentime = $_POST['opentime'];
    $closetime = $_POST['closetime'];

    $username = $_POST['username'];
    $password = $_POST['password'];
    $ic = $_POST['ic'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $focus_area = $_POST['focus_area'];
    $contact = $_POST['contact'];
    $unique_name2 = $_POST['unique_name2'];
  }
  

$code=(rand(1000,9999));
 include 'SignUp-Email.php'; 

date_default_timezone_set("Asia/Kuala_Lumpur");
$duration=strtotime("+10 Minutes");
$expired=date("h:i:sa", $duration)?>

<div class="signup-form">

            <form id="verifyForm" action="SignUp-Account.php?r=<?php echo $_GET['role'] ?>" method="post"  enctype="multipart/form-data">
        <div class="tab-signup" id="tab-signup"  style="display:block;animation: fade-in 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) ;">
        <a href="SignUp.php?c=<?php echo $_GET['role'] ?>"><p id="back" style="color:#4d4d4d;position: relative;left: -20%">&larr;Back </p></a>
        <p class="signup-form-header" > Email Verification </p>
        <?php if($_GET['role']=='vet'){ ?>
            <input type="hidden"  name="username" value='<?php echo$username ?>'>
            <input type="hidden"  name="password" value=<?php echo$password ?>>
            <input type="hidden"  name="ic" value=<?php echo$ic ?>>
            <input type="hidden"  name="name" value='<?php echo$name ?>'>
            <input type="hidden"  name="email" value=<?php echo$email ?>>
            <input type="hidden"  name="area" value=<?php echo$focus_area ?>>
            <input type="hidden"  name="clinic" value=<?php echo$clinic ?>>
            <input type="hidden"  name="contact" value=<?php echo$contact ?>>
            <input type="hidden"  name="apc" value="<?php echo $unique_name2; ?>">
          <?php }elseif($_GET['role']=='pet-shop'){?>
            <input type="hidden" name="name" value="<?php echo $name ?>">
            <input type="hidden" name="password" value="<?php echo $password ?>">
            <input type="hidden" name="shop_name" value="<?php echo $shop_name ?>">
            <input type="hidden" name="state" value="<?php echo $state ?>">
            <input type="hidden" name="area" value="<?php echo $area ?>">
            <input type="hidden" name="address" value="<?php echo $address ?>">
            <input type="hidden" name="contact" value="<?php echo $contact ?>">
            <input type="hidden" name="email" value="<?php echo $email ?>">
            <input type="hidden" name="description" value="<?php echo $description ?>">
            <input type="hidden" name="workingday" value="<?php echo $workingday ?>">
            <input type="hidden" name="opentime" value="<?php echo $opentime ?>">
            <input type="hidden" name="closetime" value="<?php echo $closetime ?>">
            <input type="hidden" name="unique_name" value="<?php echo $unique_name ?>">
          <?php }elseif($_GET['role']=='individual'){ ?>
            <input type="hidden" name="name" value="<?php echo $name ?>">
            <input type="hidden" name="password" value="<?php echo $password ?>">
            <input type="hidden" name="first" value="<?php echo $first ?>">
            <input type="hidden" name="last" value="<?php echo $last ?>">
            <input type="hidden" name="state" value="<?php echo $state ?>">
            <input type="hidden" name="area" value="<?php echo $area ?>">
            <input type="hidden" name="address" value="<?php echo $address ?>">
            <input type="hidden" name="contact" value="<?php echo $contact ?>">
            <input type="hidden" name="email" value="<?php echo $email ?>">
            <input type="hidden" name="dob" value="<?php echo $dob ?>">
            <input type="hidden" name="description" value="<?php echo $description ?>">
            <input type="hidden" name="workingday" value="<?php echo $workingday ?>">
            <input type="hidden" name="opentime" value="<?php echo $opentime ?>">
            <input type="hidden" name="closetime" value="<?php echo $closetime ?>">
            <input type="hidden" name="unique_name" value="<?php echo $unique_name ?>">
          <?php } elseif($_GET['role']=='adopter'){ ?>
            <input type="hidden" name="name" value="<?php echo $name ?>">
            <input type="hidden" name="password" value="<?php echo $password ?>">
            <input type="hidden" name="first" value="<?php echo $first ?>">
            <input type="hidden" name="last" value="<?php echo $last ?>">
            <input type="hidden" name="state" value="<?php echo $state ?>">
            <input type="hidden" name="area" value="<?php echo $area ?>">
            <input type="hidden" name="contact" value="<?php echo $contact ?>">
            <input type="hidden" name="email" value="<?php echo $email ?>">
            <input type="hidden" name="dob" value="<?php echo $dob ?>">
            <input type="hidden" name="unique_name" value="<?php echo $unique_name ?>">
          <?php } elseif($_GET['role']=='clinic'){ ?>
            <input type="hidden" name="clinic_name" value="<?php echo $clinic_name ?>">
            <input type="hidden" name="state" value="<?php echo $state ?>">
            <input type="hidden" name="area" value="<?php echo $area ?>">
            <input type="hidden" name="address" value="<?php echo $address ?>">
            <input type="hidden" name="contact2" value="<?php echo $contact2 ?>">
            <input type="hidden" name="email2" value="<?php echo $email2 ?>">
            <input type="hidden" name="description" value="<?php echo $description ?>">
            <input type="hidden" name="unique_name" value="<?php echo $unique_name ?>">
            <input type="hidden" name="discount" value="<?php echo $discount ?>">
            <input type="hidden" name="workingday" value="<?php echo $workingday ?>">
            <input type="hidden" name="opentime" value="<?php echo $opentime ?>">
            <input type="hidden" name="closetime" value="<?php echo $closetime ?>">

            <input type="hidden" name="username" value="<?php echo $username ?>">
            <input type="hidden" name="password" value="<?php echo $password ?>">
            <input type="hidden" name="ic" value="<?php echo $ic ?>">
            <input type="hidden" name="name" value="<?php echo $name ?>">
            <input type="hidden" name="email" value="<?php echo $email ?>">
            <input type="hidden" name="focus_area" value="<?php echo $focus_area ?>">
            <input type="hidden" name="contact" value="<?php echo $contact ?>">
            <input type="hidden" name="unique_name2" value="<?php echo $unique_name2 ?>">
          <?php };?>
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
    window.location.href = '../index.php';
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
    window.location.href = '../index.php';
  }, 900); // wait for 700 milliseconds (the duration of the CSS transition) before redirecting
}
</script>

</body>
</html>






?>