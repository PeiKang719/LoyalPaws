<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LoyalPaws</title>
	<link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="UserStyle.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style type="text/css">
	html,body{
		height: 100%;
	}

.slide-out-animation {
    -webkit-animation: slide-out-bck-center 1.3s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
    animation: slide-out-bck-center 1.3s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
  }

@keyframes slide-out-bck-center {
  0% {
    -webkit-transform: translateZ(0);
            transform: translateZ(0);
    opacity: 1;
  }
  100% {
    -webkit-transform: translateZ(-1100px);
            transform: translateZ(-1100px);
    opacity: 0;
  }

</style>
<body>
    <?php include 'UserHeader.php'; 
    $petID = $_GET['id'];
    ?>

    <div class="hidden-sent-animation-container" id="hidden-container">
        <img src="media/start.gif" width="850px" width="700px" id="start" >
        <img src="media/end.gif" width="850px" width="700px" id="end" style="display: none;">
    </div>

	<form action="User-Adoption-Inquiry-Process.php" method="POST" id="adoption-form" enctype="multipart/form-data">
        <div class="adoption-form-container" id="form-container">

            <input type="hidden" name="aid" value="<?php echo $adopterID?>">
            <input type="hidden" name="pid" value="<?php echo $petID ?>;">
  <h2 style="color:black">Pet Adoption Evaluation Form</h2>
  <br>
  <hr style="width: 100%;">
  <br>
  <h3>About You:</h3>
  <br>
   <div class="adoption-form-subcontainer">
  <label for="experience">1) Have you owned pets before? If yes, please provide details:</label>
  <textarea id="experience" name="experience" rows="4" required></textarea>

  <label for="occupation">2) What is your occupation?</label>
<input type="text" id="occupation" name="occupation" required>

  <label for="lifestyle">3) Describe your current lifestyle and daily routine:</label>
  <textarea id="lifestyle" name="lifestyle" rows="4" required></textarea>

<label for="pet-training">4) Are you willing to invest time and effort into training a pet if needed?</label>
<div class="adoption-form-container-row">
    <div class="adoption-form-container-subrow">
<input type="radio" id="pet-training-yes" name="pet-training" value="yes" required>
<label for="pet-training-yes">Yes</label>
</div>
<div class="adoption-form-container-subrow">
<input type="radio" id="pet-training-no" name="pet-training" value="no" required>
<label for="pet-training-no">No</label>
</div>
</div>
</div>
<br><hr style="width: 100%;"><br>
  <h3>About Your Home:</h3>
  <br>
  <div class="adoption-form-subcontainer">
  <label for="residence">1) Do you own or rent your residence?</label>
  <div class="adoption-form-container-row">
    <div class="adoption-form-container-subrow">
  <input type="radio" id="own-residence" name="residence" value="own" required>
  <label for="own-residence">Own</label>
</div>
<div class="adoption-form-container-subrow">
  <input type="radio" id="rent-residence" name="residence" value="rent" required>
  <label for="rent-residence">Rent</label>
  </div>
</div>

  <label for="residence-details">2) Please provide details about your residence (e.g., house, apartment, yard size):</label>
  <textarea id="residence-details" name="residence-details" rows="4" required></textarea>
</div>
<br><hr style="width: 100%;"><br>
  <h3>About Pet Care:</h3>
  <br>
   <div class="adoption-form-subcontainer">
  <label for="commitment">1) Are you committed to taking care of a pet for its entire life (typically 10-15 years or longer)?</label>
  <div class="adoption-form-container-row">
    <div class="adoption-form-container-subrow">
  <input type="radio" id="commitment-yes" name="commitment" value="yes" required>
  <label for="commitment-yes">Yes</label>
</div>
<div class="adoption-form-container-subrow">
  <input type="radio" id="commitment-no" name="commitment" value="no" required>
  <label for="commitment-no">No</label>
  </div>
</div>

  <label for="pet-grooming">2) Are you comfortable with grooming and maintenance requirements for the pet you are adopting?</label>
  <div class="adoption-form-container-row">
    <div class="adoption-form-container-subrow">
<input type="radio" id="pet-grooming-yes" name="pet-grooming" value="yes" required>
<label for="pet-grooming-yes">Yes</label>
</div>
<div class="adoption-form-container-subrow">
<input type="radio" id="pet-grooming-no" name="pet-grooming" value="no" required>
<label for="pet-grooming-no">No</label>
</div>
</div>

<label for="pet-expenses">3) Are you prepared for the financial responsibilities of owning a pet, including food, vaccinations, grooming, and veterinary care?</label>
<div class="adoption-form-container-row">
    <div class="adoption-form-container-subrow">
<input type="radio" id="pet-expenses-yes" name="pet-expenses" value="yes" required>
<label for="pet-expenses-yes">Yes</label>
</div>
<div class="adoption-form-container-subrow">
<input type="radio" id="pet-expenses-no" name="pet-expenses" value="no" required>
<label for="pet-expenses-no">No</label>
</div>
</div>
</div>
<br><hr style="width: 100%;"><br>
  <h3>Additional Comments:</h3>
  <br>
   <div class="adoption-form-subcontainer">
  <label for="comments">Please provide any additional comments or information:</label>
  <textarea id="comments" name="comments" rows="4"></textarea>
</div>

<div class="adoption-form-container-row" style="justify-content: center;">
    <button class="proceed-payment" type="submit">Submit</button>
</div>
</div>
</form>


<script type="text/javascript">
    // Get the form and form container elements
  var form = document.getElementById("adoption-form");
  var formContainer = document.getElementById("form-container");
  var hiddenContainer = document.getElementById("hidden-container");
  var start = document.getElementById("start");
  var end = document.getElementById("end");

  // Add a submit event listener to the form
  form.addEventListener("submit", function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    // Add the animation class to the form container
    formContainer.classList.add("slide-out-animation");
    hiddenContainer.style.display="block";
    setTimeout(function () {
      start.style.display="none";
      end.style.display="block";
    }, 1530); 
    // Optionally, you can wait for the animation to finish and then submit the form programmatically
    setTimeout(function () {
      form.submit();
    }, 2700); // Adjust the timeout value to match the animation duration
  });
</script>
</body>
</html>