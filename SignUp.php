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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

textarea{
    font-size: 20px;
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
	<div class="signup-form">
        <?php 
        if (isset($_GET['c'])) {
            $c=$_GET['c'];
            if($c=='1'){
                showTab();
            }
            else if($c=='seller'){
                sellerType();
            }
            else if($c=='vet-type'){
                vetType();
            }
            else if($c=='seller-type'){
                sellerType();
            }
            else if($c=='adopter'){
                adopter();
            }
            else if($c=='pet-shop'){
                petshop();
            }
            else if($c=='individual'){
                individual();
            }
            else if($c=='clinic'){
                clinic();
            }
            else if($c=='vet'){
                vet();
            }
        }
        if (!isset($_GET['c'])) {
            showTab();
        }
        ?>
        <?php function showTab(){ ?>
        <div class="tab" style="display:block;animation: fade-in 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) ;">
        <p class="role-form-header"> Tell us what's your situation: </p>
        <a href="SignUp.php?c=seller-type" onclick="window.location=this.href"><label class="radio-container">I'm a pet seller
            <input type="radio" name="role" onchange="changeColor2(this)" value="seller">
            <span class="checkmark"><img src="media/seller.png" ></span>
        </label>
        <a href="SignUp.php?c=adopter" onclick="window.location=this.href"><label class="radio-container">I want to adopt a pet
            <input type="radio" name="role" onchange="changeColor2(this)" value="adopter">
            <span class="checkmark"><img src="media/adopter.png" ></span>
        </label>
        <a href="SignUp.php?c=vet-type" onclick="window.location=this.href"><label class="radio-container">I'm a veterinarian
            <input type="radio" name="role" onchange="changeColor2(this)" value="vet">
            <span class="checkmark"><img src="media/vet.png" ></span>
        </label>
        </div>
    <?php } ?>
        <?php function sellerType(){ ?>
        <div class="tab"  style="display:block;animation: fade-in 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) ;">
        <a href="SignUp.php?c=1"><p style="color:#4d4d4d;position: relative;left: 5%">&larr;Back </p></a>
        <p class="role-form-header" style="margin-bottom: 70px;">Tell us what's your situation:</p>
        <a href="SignUp.php?c=pet-shop" onclick="window.location=this.href"><label class="radio-container">I have a pet shop
            <input type="radio" name="role" onchange="changeColor2(this)" value="pet-shop">
            <span class="checkmark"><img src="media/pet-shop.png" ></span>
        </label>
        <a href="SignUp.php?c=individual" onclick="window.location=this.href"><label class="radio-container" id="individual">I'm a individual seller
            <input type="radio" name="role" onchange="changeColor2(this)" value="individual">
            <span class="checkmark"><img src="media/individual.png" ></span>
        </label>
        </div>
    <?php } ?>
        <?php function vetType(){ ?>
        <div class="tab"  style="display:block;animation: fade-in 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) ;">
        <a href="SignUp.php?c=1"><p style="color:#4d4d4d;position: relative;left: 5%">&larr;Back </p></a>
        <p class="role-form-header" style="margin-bottom: 70px;">Tell us what's your situation:</p>
        <a href="SignUp.php?c=clinic" onclick="window.location=this.href"><label class="radio-container" id="clinic-container1">I want to register a vet clinic
            <input type="radio" name="role" onchange="changeColor2(this)" value="pet-shop">
            <span class="checkmark"><img src="media/clinic.png" ></span>
        </label>
        <a href="SignUp.php?c=vet" onclick="window.location=this.href"><label class="radio-container" id="clinic-container2">I want to join a registered clinic
            <input type="radio" name="role" onchange="changeColor2(this)" value="individual">
            <span class="checkmark"><img src="media/vet.png" ></span>
        </label>
    </div>
    <?php } ?>
        <?php function adopter(){ ?>
            <iframe name="hiddenFrame" class="hide" style="border: 0;display: none;"></iframe>
            <form action="SignUp-Validation.php?r=adopter" method="post" target="hiddenFrame" enctype="multipart/form-data">
        <div class="tab" id="tab-signup"  style="display:block;animation: fade-in 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) ;">
        <a href="SignUp.php?c=1"><p style="color:#4d4d4d;position: relative;left: -20%">&larr;Back </p></a>
        <p class="signup-form-header" > Sign Up </p>
    
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password1" required>
            <input type="password" placeholder="Confirm Password" name="password2" required><br>
            <input type="text" placeholder="First Name" name="first" required style="width:22.3%" id="firstname">
            <input type="text" placeholder="Last Name" name="last" required style="width:22.3%;margin-left: 3.5%;" id="lastname">
            <input type="email" placeholder="Email" name="email" required>
            <input type="date" placeholder="Date of Birth" name="dob" required>
            <input type="text" placeholder="Contact No." name="contact" required><br>
            <select name="state" required style="width:23.3% !important" onchange="updateAreaOptions(this.value);">
              <option value="" disabled selected>Select your living state</option>
              <option>Johor</option>
                <option>Kedah</option>
                <option>Kelantan</option>
                <option>Melaka</option>
                <option>Negeri Sembilan</option>
                <option>Pahang</option>
                <option>Perak</option>
                <option>Perlis</option>
                <option>Penang</option>
                <option>Sabah</option>
                <option>Sarawak</option>
                <option>Terengganu</option>
                <option>Kuala Lumpur</option>
                <option>Labuan</option>
                <option>Putrajaya</option>
                <option>Kelantan</option>
          </select>
           <select name="area" required style="width:23.3% !important;margin-left: 3.8%;" id="areaSelect">
              <option value="" disabled selected>Select your area</option>

          </select><br>
          <label id="clinic-image">Profile Image:</label>
            <input type="file" id="img" name="img" accept="image/*" style="width:39%"><br><br><br>
            <button type="submit" class="signup-button">Sign Up</button>
            <br><br><br><br>
        </div>
    </form>
    <?php } ?>
        <?php function individual(){ ?>
            <iframe name="hiddenFrame" class="hide" style="border: 0;display: none;"></iframe>
            <form action="SignUp-Validation.php?r=individual" method="post" target="hiddenFrame" enctype="multipart/form-data">
        <div class="tab" id="tab-signup"  style="display:block;animation: fade-in 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) ;">
        <a href="SignUp.php?c=seller-type"><p style="color:#4d4d4d;position: relative;left: -20%">&larr;Back </p></a>
        <p class="signup-form-header" > Sign Up </p>
    
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password1" required>
            <input type="password" placeholder="Confirm Password" name="password2" required><br>
            <input type="text" placeholder="First Name" name="first" required style="width:22.3%" id="firstname">
            <input type="text" placeholder="Last Name" name="last" required style="width:22.3%;margin-left: 3.5%;" id="lastname">
            <input type="email" placeholder="Email" name="email" required>
            <input type="date" placeholder="Date of Birth" name="dob" required>
            <input type="text" placeholder="Contact No." name="contact" required><br>
            <select name="state" required style="width:23.3% !important" id="state" onchange="updateAreaOptions(this.value);">
              <option value="" disabled selected>Select your living state</option>
              <option>Johor</option>
                <option>Kedah</option>
                <option>Kelantan</option>
                <option>Melaka</option>
                <option>Negeri Sembilan</option>
                <option>Pahang</option>
                <option>Perak</option>
                <option>Perlis</option>
                <option>Penang</option>
                <option>Sabah</option>
                <option>Sarawak</option>
                <option>Terengganu</option>
                <option>Kuala Lumpur</option>
                <option>Labuan</option>
                <option>Putrajaya</option>
                <option>Kelantan</option>
          </select>
           <select name="area" required style="width:23.3% !important;margin-left: 3.8%;" id="areaSelect">
              <option value="" disabled selected>Select your area</option>

          </select>
          <input type="text" placeholder="Detailed Address (e.g: 1,Jalan ABC)" name="address" required><br>
          <label id="clinic-image">Profile Image:</label>
            <input type="file" id="img" name="img" accept="image/*" style="width:39%">
          <textarea maxlength="1000" placeholder="Write something to describe your bussiness...(max 1000 characters)" name="description" required style="height:250px;width: 50%;"></textarea><br><br><br>
          <label >Available Time:</label>
            <table class="workingday" border="0"><br>
                <tr>
                    <td>Sunday</td>
                    <td>
                        <label class="switch" for="checkbox21">
                        <input type="checkbox" id="checkbox21" name="workingday3[]" value="Sunday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime3[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime3[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Monday</td>
                    <td>
                        <label class="switch" for="checkbox15">
                        <input type="checkbox" id="checkbox15" name="workingday3[]" value="Monday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime3[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime3[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Tuesday</td>
                    <td>
                        <label class="switch" for="checkbox16">
                        <input type="checkbox" id="checkbox16" name="workingday3[]" value="Tuesday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime3[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime3[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Wednesday</td>
                    <td>
                        <label class="switch" for="checkbox17">
                        <input type="checkbox" id="checkbox17" name="workingday3[]" value="Wednesday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime3[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime3[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Thursday</td>
                    <td>
                        <label class="switch" for="checkbox18">
                        <input type="checkbox" id="checkbox18" name="workingday3[]" value="Thursday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime3[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime3[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Friday</td>
                    <td>
                        <label class="switch" for="checkbox19">
                        <input type="checkbox" id="checkbox19" name="workingday3[]" value="Friday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime3[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime3[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Saturday</td>
                    <td>
                        <label class="switch" for="checkbox20">
                        <input type="checkbox" id="checkbox20" name="workingday3[]" value="Saturday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime3[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime3[]" disabled required> </td>
                </tr>
            </table>
            <button type="submit" class="signup-button">Sign Up</button>
            <br><br><br><br>
        </div>
    </form>
    <?php } ?>
        <?php function petshop(){ ?>
            <iframe name="hiddenFrame" class="hide" style="border: 0;display: none;"></iframe>
            <form action="SignUp-Validation.php?r=pet-shop" method="post" target="hiddenFrame" enctype="multipart/form-data">
        <div class="tab" id="tab-signup"  style="display:block;animation: fade-in 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) ;">
        <a href="SignUp.php?c=seller-type"><p style="color:#4d4d4d;position: relative;left: -20%">&larr;Back </p></a>
        <p class="signup-form-header"> Sign Up </p>
    
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password1" required>
            <input type="password" placeholder="Confirm Password" name="password2" required>
        <p class="signup-form-header" > About Your Shop </p>
            <input type="text" placeholder="Shop Name" name="shop-name" required><br>
            <select name="state" required style="width: 23.3% !important" onchange="updateAreaOptions(this.value);">
    <option value="" disabled selected>Select shop state</option>
    <option>Johor</option>
    <option>Kedah</option>
    <option>Kelantan</option>
    <option>Melaka</option>
    <option>Negeri Sembilan</option>
    <option>Pahang</option>
    <option>Perak</option>
    <option>Perlis</option>
    <option>Penang</option>
    <option>Sabah</option>
    <option>Sarawak</option>
    <option>Terengganu</option>
    <option>Kuala Lumpur</option>
    <option>Labuan</option>
    <option>Putrajaya</option>
    <option>Kelantan</option>
</select>

<select name="area" required style="width: 23.3% !important; margin-left: 3.8%;" id="areaSelect">
    <option value="" disabled selected>Select shop area</option>
 
</select>

            <input type="text" placeholder="Detailed Address (e.g: 1,Jalan ABC)" name="address" required>
            <input type="number" placeholder="Contact No." name="contact" required><br>
            <input type="email" placeholder="Email" name="email" required><br>
            <label id="clinic-image">Shop Image:</label>
            <input type="file" id="img" name="img" accept="image/*"  style="width:40.2%">
            <textarea maxlength="1000" placeholder="Write something to describe the shop...(max 1000 characters)" name="description" required style="height:250px;width: 50%;"></textarea><br><br><br>
            <label >Working Day & Hour:</label>
            <table class="workingday"  border="0" ><br>
                <tr>
                    <td>Sunday</td>
                    <td>
                        <label class="switch" for="checkbox7">
                        <input type="checkbox" id="checkbox7" name="workingday[]" value="Sunday" />
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Monday</td>
                    <td>
                        <label class="switch" for="checkbox1">
                        <input type="checkbox" id="checkbox1" name="workingday[]" value="Monday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Tuesday</td>
                    <td>
                        <label class="switch" for="checkbox2">
                        <input type="checkbox" id="checkbox2" name="workingday[]" value="Tuesday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Wednesday</td>
                    <td>
                        <label class="switch" for="checkbox3">
                        <input type="checkbox" id="checkbox3" name="workingday[]" value="Wednesday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Thursday</td>
                    <td>
                        <label class="switch" for="checkbox4">
                        <input type="checkbox" id="checkbox4" name="workingday[]" value="Thursday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Friday</td>
                    <td>
                        <label class="switch" for="checkbox5">
                        <input type="checkbox" id="checkbox5" name="workingday[]" value="Friday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Saturday</td>
                    <td>
                        <label class="switch" for="checkbox6">
                        <input type="checkbox" id="checkbox6" name="workingday[]" value="Saturday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime[]" disabled required> </td>
                </tr>
            </table>

            <button type="submit" class="signup-button">Sign Up</button>
            <br><br><br><br>
        </div>
    </form>
    <?php } ?>
        <?php function clinic(){ ?>
            <iframe name="hiddenFrame" class="hide" style="border: 0;display: none;"></iframe>
            <form action="SignUp-Validation.php?r=clinic" method="post" target="hiddenFrame" enctype="multipart/form-data">
        <div class="tab" id="tab-signup"  style="display:block;animation: fade-in 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) ;">
        <a href="SignUp.php?c=vet-type"><p style="color:#4d4d4d;position: relative;left: -20%">&larr;Back </p></a>
        <p class="signup-form-header" > Sign Up </p>
    
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password1" required>
            <input type="password" placeholder="Confirm Password" name="password2" required>
            <input type="text" placeholder="Your real name" name="name" required>
            <input type="number" placeholder="Identity Card No." name="ic" required>
            <input type="text" placeholder="Your Contact No." name="contact" required>
            <input type="email" placeholder="Email" name="email" required>
            
        <p class="signup-form-header">About Your Professional</p>
            <label>APC:</label>
            <input name="apc" type="file" accept="application/pdf" required><br>
            <div class="focus" style="width:100%;height:550px;">
            <label  id="professional-focus">The areas of services you are focusing on:</label>
            <table id="professional-area" style="width: 55%;text-align: center;margin-top: 30px;" border="0">
          <tr >
        <td style="width:33%"><label class="check-container">Prevention Care
            <input type="checkbox" name="focus-area[]" onchange="changeColor(this)" value="Prevention Care">
            <span class="checkmark3"></span>
        </label></td>
         <td style="width:33%"><label class="check-container">Surgery
            <input type="checkbox" name="focus-area[]" onchange="changeColor(this)" value="Surgery">
            <span class="checkmark3"></span>
        </label></td>
    </tr>
         <tr>
          <td ><label class="check-container">Nutrition and diet
            <input type="checkbox" name="focus-area[]" onchange="changeColor(this)" value="Nutrition and diet">
            <span class="checkmark3"></span>
        </label></td>
         <td><label class="check-container" style="padding-top:30px;height: 50px;">Emergency and critical care
            <input type="checkbox" name="focus-area[]" onchange="changeColor(this)" value="Emergency and critical care">
            <span class="checkmark3"></span>
        </label></td>
    </tr>
    <tr>
        <td> <label class="check-container">End-of-life care
            <input type="checkbox" name="focus-area[]" onchange="changeColor(this)" value="End-of-life care">
            <span class="checkmark3"></span>
        </label></td>
    <td style="width:33%"><label class="check-container">Diagnostic services
            <input type="checkbox" name="focus-area[]" onchange="changeColor(this)" value="Diagnostic services">
            <span class="checkmark3"></span>
        </label></td>
    </tr>
    <tr>
        <td> <label class="check-container">Rehabilitation
            <input type="checkbox" name="focus-area[]" onchange="changeColor(this)" value="Rehabilitation">
            <span class="checkmark3"></span>
        </label></td>
    </tr>
      </table>
  </div>
        <p class="signup-form-header" > About Your Clinic </p>
            <input type="text" placeholder="Clinic Name" name="clinic-name" required><br>
            <select name="state" required style="width:23.3% !important" onchange="updateAreaOptions(this.value);">
              <option value="" disabled selected>Select clinic state</option>
              <option>Johor</option>
                <option>Kedah</option>
                <option>Kelantan</option>
                <option>Melaka</option>
                <option>Negeri Sembilan</option>
                <option>Pahang</option>
                <option>Perak</option>
                <option>Perlis</option>
                <option>Penang</option>
                <option>Sabah</option>
                <option>Sarawak</option>
                <option>Terengganu</option>
                <option>Kuala Lumpur</option>
                <option>Labuan</option>
                <option>Putrajaya</option>
                <option>Kelantan</option>
          </select>
           <select name="area" required style="width:23.3% !important;margin-left: 3.8%;" id="areaSelect">
              <option value="" disabled selected>Select clinic area</option>

          </select>
            <input type="text" placeholder="Detailed Address (e.g: 1,Jalan ABC)" name="address" required>
            <input type="text" placeholder="Clinic Contact No." name="contact2" required><br>
            <input type="email" placeholder="Email" name="email2" required><br>
            <label id="clinic-image">Clinic Image:</label>
            <input type="file" id="img" name="img" accept="image/*" style="width:40.2%">
            <input type="number" placeholder="Adopter Exclusive Discount" name="discount" min="1" max="100" required>
            <textarea id="description-clinic" maxlength="1000" placeholder="Write something to describe the clinic...(max 1000 characters)" name="description" required style="height:250px;width: 50%;"></textarea><br><br><br>
            <label >Working Day & Hour:</label>
            <table class="workingday" border="0"><br>
                <tr>
                    <td>Sunday</td>
                    <td>
                        <label class="switch" for="checkbox14">
                        <input type="checkbox" id="checkbox14" name="workingday2[]" value="Sunday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime2[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime2[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Monday</td>
                    <td>
                        <label class="switch" for="checkbox8">
                        <input type="checkbox" id="checkbox8" name="workingday2[]" value="Monday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime2[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime2[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Tuesday</td>
                    <td>
                        <label class="switch" for="checkbox9">
                        <input type="checkbox" id="checkbox9" name="workingday2[]" value="Tuesday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime2[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime2[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Wednesday</td>
                    <td>
                        <label class="switch" for="checkbox10">
                        <input type="checkbox" id="checkbox10" name="workingday2[]" value="Wednesday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime2[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime2[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Thursday</td>
                    <td>
                        <label class="switch" for="checkbox11">
                        <input type="checkbox" id="checkbox11" name="workingday2[]" value="Thursday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime2[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime2[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Friday</td>
                    <td>
                        <label class="switch" for="checkbox12">
                        <input type="checkbox" id="checkbox12" name="workingday2[]" value="Friday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime2[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime2[]" disabled required> </td>
                </tr>
                <tr>
                    <td>Saturday</td>
                    <td>
                        <label class="switch" for="checkbox13">
                        <input type="checkbox" id="checkbox13" name="workingday2[]" value="Saturday"/>
                        <div class="slider round"></div>
                        </label>
                    </td>
                    <td style="text-align: center;"><input type="time" name="opentime2[]" disabled required> </td>
                    <td style="text-align: center;">to</td>
                    <td style="text-align: center;"><input type="time" name="closetime2[]" disabled required> </td>
                </tr>
            </table>

            <button type="submit" class="signup-button">Sign Up</button>
            <br><br><br><br>
        </div>
    </form>
    <?php } ?>
        <?php function vet(){ ?>
            <iframe name="hiddenFrame" class="hide" style="border: 0;display: none;"></iframe>
            <form action="SignUp-Validation.php?r=vet" method="post" target="hiddenFrame" enctype="multipart/form-data">
        <div class="tab-signup" id="tab-signup"  style="display:block;animation: fade-in 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) ;">
        <a href="SignUp.php?c=vet-type"><p id="back" style="color:#4d4d4d;position: relative;left: -20%">&larr;Back </p></a>
        <p class="signup-form-header" > Sign Up </p>
    
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password1" required>
            <input type="password" placeholder="Confirm Password" name="password2" required>
            <input type="text" placeholder="Your real name" name="name" required>
            <input type="number" placeholder="Identity Card No." name="ic" required>
            <input type="text" placeholder="Contact No." name="contact" required>
            <input type="email" placeholder="Email" name="email" required>

        <p class="signup-form-header">About Your Professional</p>
            <label id="apc">APC:</label>
            <input name="apc" type="file" accept="application/pdf" required><br>
            <div class="focus" style="width:100%;height:550px;">
            <label id="professional-focus">The areas of services you are focusing on:</label>
            <table id="professional-area" style="width: 55%;margin-top: 30px;" border="0">
          <tr >
        <td style="width:33%"><label class="check-container">Prevention Care
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Prevention Care">
            <span class="checkmark3"></span>
        </label></td>
         <td style="width:33%"><label class="check-container">Surgery
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Surgery">
            <span class="checkmark3"></span>
        </label></td>
    </tr>
         <tr>
          <td ><label class="check-container">Nutrition and diet
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Nutrition and diet">
            <span class="checkmark3"></span>
        </label></td>
         <td><label class="check-container" style="padding-top:30px;height: 50px;">Emergency and critical care
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Emergency and critical care">
            <span class="checkmark3"></span>
        </label></td>
    </tr>
    <tr>
        <td> <label class="check-container">End-of-life care
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="End-of-life care">
            <span class="checkmark3"></span>
        </label></td>
    <td style="width:33%"><label class="check-container">Diagnostic services
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Diagnostic services">
            <span class="checkmark3"></span>
        </label></td>
    </tr>
    <tr>
        <td> <label class="check-container">Rehabilitation
            <input type="checkbox" name="area[]" onchange="changeColor(this)" value="Rehabilitation">
            <span class="checkmark3"></span>
        </label></td>
    </tr>
      </table>
  </div>
        <p class="signup-form-header">Your working clinic: </p>

            <select name="clinic" required style="width:54% !important;margin-bottom: 80px;">
              <option value="" disabled selected>Select one clinic</option>
               <?php
                  // Connect to the database
                  include('Connection.php');

                  // Fetch breed names from the database
                  $sql = "SELECT DISTINCT c.clinicID,c.name FROM clinic c,vet v WHERE c.clinicID=v.clinicID AND v.ic REGEXP '^[0-9]+$' ORDER BY c.name";
                  $result = mysqli_query($conn, $sql);

                  if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["clinicID"] . '">' . $row['name'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No clinic found</option>';
                    }

                  // Close the database connection
                  mysqli_close($conn);
                  ?>
          </select>
            <br>
            <button type="submit" class="signup-button">Sign Up</button>
            <br><br><br><br>
        </div>
    </form>
    <?php } ?>

    </div>
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

function changeColor(checkbox) {
  var checkbox = document.getElementsByName(checkbox.name);
  for (var i = 0; i < checkbox.length; i++) {
    var checkboxLabel = checkbox[i].parentNode;
    if (checkbox[i].checked) {
      checkboxLabel.style.backgroundColor = "#cfe8fc";
      checkboxLabel.style.borderColor = "#6fb9f6";
    } else {
      checkboxLabel.style.backgroundColor = "white";
     checkboxLabel.style.borderColor = "#b3b3b3";
    }
  }
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

// get all checkboxes
const checkboxes = document.querySelectorAll('input[type=checkbox][name="workingday[]"]');

// add event listener to each checkbox
checkboxes.forEach(checkbox => {
  checkbox.addEventListener('change', function() {
    // find parent row element
    const row = this.closest('tr');
    // find time input fields in the same row
    const openTime = row.querySelector('input[name="opentime[]"]');
    const closeTime = row.querySelector('input[name="closetime[]"]');
    // enable or disable the time input fields based on checkbox status
    if (this.checked) {
      openTime.disabled = false;
      closeTime.disabled = false;
    } else {
      openTime.disabled = true;
      closeTime.disabled = true;
      openTime.value = '';
      closeTime.value = '';
    }
  });
});

const checkboxes2 = document.querySelectorAll('input[type=checkbox][name="workingday2[]"]');

// add event listener to each checkbox
checkboxes2.forEach(checkbox => {
  checkbox.addEventListener('change', function() {
    // find parent row element
    const row = this.closest('tr');
    // find time input fields in the same row
    const openTime = row.querySelector('input[name="opentime2[]"]');
    const closeTime = row.querySelector('input[name="closetime2[]"]');
    // enable or disable the time input fields based on checkbox status
    if (this.checked) {
      openTime.disabled = false;
      closeTime.disabled = false;
    } else {
      openTime.disabled = true;
      closeTime.disabled = true;
      openTime.value = '';
      closeTime.value = '';
    }
  });
});

const checkboxes3 = document.querySelectorAll('input[type=checkbox][name="workingday3[]"]');

// add event listener to each checkbox
checkboxes3.forEach(checkbox => {
  checkbox.addEventListener('change', function() {
    // find parent row element
    const row = this.closest('tr');
    // find time input fields in the same row
    const openTime = row.querySelector('input[name="opentime3[]"]');
    const closeTime = row.querySelector('input[name="closetime3[]"]');
    // enable or disable the time input fields based on checkbox status
    if (this.checked) {
      openTime.disabled = false;
      closeTime.disabled = false;
    } else {
      openTime.disabled = true;
      closeTime.disabled = true;
      openTime.value = '';
      closeTime.value = '';
    }
  });
});



    function updateAreaOptions(state) {
        var areaSelect = document.getElementById('areaSelect');
        areaSelect.innerHTML = '';
        areaSelect.options.add(new Option('Loading areas...'));

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                areaSelect.innerHTML = xhr.responseText;
            }
        }
        xhr.open('GET', 'Area-Getter.php?state=' + state, true);
        xhr.send();
    }

</script>
</body>

</html>
