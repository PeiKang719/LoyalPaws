<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Loyal Paws-Breed Matching</title>
  <link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="UserStyle.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>
<body style="background-image:url('media/matching-bg.jpg');background-size:100% 100%; height: 721px;">
<?php include 'UserHeader.php'; ?>
<div class="dashboard-overlay" style="width: 100%;height: 100%;">
<div class="container" style="top:10%;">
    <div class="question">
        <div class="matchingForm-header">Find Your Perfect Pet Match</div>
        <br>
        <div class="matching-progress">
            <div class="matching-progress-bar">1/11</div>
        </div>
        <div class="tabQ" style="display:block;">
            <p style="margin-top:25px;">What type of pet are you interested in?</p>
        </div>
        <div class="tabQ">
            <p style="margin-top:25px;">What is your preference for cat size are you looking?</p>
        </div>
        <div class="tabQ">
            <p style="margin-top:25px;">What is your preference for dog size are you looking?</p>
        </div>
        <div class="tabQ">
            <p style="margin-top:25px;">Do you have children?</p>
        </div>
        <div class="tabQ">
            <p style="margin-top:25px;">Do you have a pet?</p>
        </div>
        <div class="tabQ">
            <p style="margin-top:25px;">Do you have any experience in training pets?</p>
        </div>
        <div class="tabQ">
            <p style="margin-top:25px;">Are you looking for a pet that is hypoallergenic or low-shedding?</p>
        </div>
        <div class="tabQ">
            <p style="margin-top:25px;">Are you looking for a pet that will play actively with you or one that is more independent?</p>
        </div>
        <div class="tabQ">
            <p style="margin-top:25px;">How much energy do you want your pet to have? </p>
        </div>
        <div class="tabQ">
            <p style="margin-top:25px;">Would you prefer a pet that is generally quiet or one that is more vocal?</p>
        </div>
        <div class="tabQ">
            <p style="margin-top:25px;">How important is it for you that your pet is affectionate and enjoys spending time 
with its owner?</p>
        </div>
        <div class="tabQ">
            <p style="margin-top:25px;">How much time and money are you willing to spend on grooming your pet? </p>
        </div>
         <div class="tabQ">
            <p style="margin-top:25px;">How important is it to you that your pet is friendly with strangers?</p>
        </div>
    </div>

<form id="matchingForm" action="Pet_Matching-Algorithm.php" method="post" enctype="multipart/form-data" >
    <p style="margin-top:15px;">&nbsp;&nbsp;Your Choose:</p>
    <div class="tab" style="display:block;">
        <button type="button" class="button-cat-dog" onclick="changeColor(this)" value="cat" id="cat"><img src="media/cc.png" class="logo-cat-dog"></button>
        <button type="button" class="button-cat-dog" onclick="changeColor(this)" value="dog" id="dog"><img src="media/dd.png" class="logo-cat-dog"></button>
    </div>
    <div class="tab" id="tab-3-choice">
        <label class="radio-container" style="padding-top:10px;height: 49px;">Small cat <br><p style="font-size:15px;margin-top: 1px;">(Weight=2.3-4.5 kg and Length<45.7 cm)</p>
            <input type="radio" name="radio_cat" onchange="changeColor2(this)" value="small">
            <span class="checkmark2"></span>
        </label>
        <label class="radio-container" style="padding-top:10px;height: 49px;">Medium cat <br><p style="font-size:15px;margin-top: 1px;">(Weight=4.5-6.8 kg and Length=45.7-50.8 cm)</p>
            <input type="radio" name="radio_cat" onchange="changeColor2(this)" value="medium">
            <span class="checkmark2"></span>
        </label>
        <label class="radio-container" style="padding-top:10px;height: 49px;">Large cat <br><p style="font-size:15px;margin-top: 1px;">(Weight>6.8 kg and Length>50.8 cm)</p>
            <input type="radio" name="radio_cat" onchange="changeColor2(this)" value="large">
            <span class="checkmark2"></span>
        </label>
    </div>
    <div class="tab" id="tab-3-choice">
        <label class="radio-container" style="padding-top:10px;height: 49px;">Small dog <br><p style="font-size:15px;margin-top: 1px;">(Weight=2-9 kg and Length<40 cm)</p>
            <input type="radio" name="radio_dog" onchange="changeColor2(this)" value="small">
            <span class="checkmark2"></span>
        </label>
        <label class="radio-container" style="padding-top:10px;height: 49px;">Medium dog <br><p style="font-size:15px;margin-top: 1px;">(Weight=10-23 kg and Length=40-60 cm)</p>
            <input type="radio" name="radio_dog" onchange="changeColor2(this)" value="medium">
            <span class="checkmark2"></span>
        </label>
        <label class="radio-container" style="padding-top:10px;height: 49px;">Large dog <br><p style="font-size:15px;margin-top: 1px;">(Weight>23 kg and Length>60 cm)</p>
            <input type="radio" name="radio_dog" onchange="changeColor2(this)" value="large">
            <span class="checkmark2"></span>
        </label>
    </div>
    <div class="tab" id="tab-2-choice">
        <label class="radio-container">Yes
            <input type="radio" name="radio3" onchange="changeColor2(this)" value="4,5">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">No
            <input type="radio" name="radio3" onchange="changeColor2(this)" value="1,2,3,4,5">
            <span class="checkmark2"></span>
        </label>
    </div>
    <div class="tab" id="tab-2-choice">
        <label class="radio-container">Yes
            <input type="radio" name="radio4" onchange="changeColor2(this)" value="4,5">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">No
            <input type="radio" name="radio4" onchange="changeColor2(this)" value="1,2,3,4,5">
            <span class="checkmark2"></span>
    </label>
    </div>
    <div class="tab" id="tab-3-choice">
        <label class="radio-container">Yes, I have trained pets before
            <input type="radio" name="radio6" onchange="changeColor2(this)" value="1,2">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">No,but I'm willing to learn
            <input type="radio" name="radio6" onchange="changeColor2(this)" value="4,5">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">No,I'm not interested in learning
            <input type="radio" name="radio6" onchange="changeColor2(this)" value="3">
            <span class="checkmark2"></span>
        </label>
    </div>
    <div class="tab"  id="tab-4-choice">
        <label class="radio-container">Yes
            <input type="radio" name="radio5" onchange="changeColor2(this)" value="1,2">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">No
            <input type="radio" name="radio5" onchange="changeColor2(this)" value="4,5">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Unsure
            <input type="radio" name="radio5" onchange="changeColor2(this)" value="3">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">I'm open to it
            <input type="radio" name="radio5" onchange="changeColor2(this)" value="1,2,3,4,5">
            <span class="checkmark2"></span>
        </label>
    </div>
    <div class="tab" id="tab-4-choice">
        <label class="radio-container">More playful
            <input type="radio" name="radio7" onchange="changeColor2(this)" value="4,5">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Moderate
            <input type="radio" name="radio7" onchange="changeColor2(this)" value="3">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Less playful
            <input type="radio" name="radio7" onchange="changeColor2(this)" value="1,2">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">I'm open to it
            <input type="radio" name="radio7" onchange="changeColor2(this)" value="1,2,3,4,5">
            <span class="checkmark2"></span>
        </label>
    </div>
        <div class="tab" id="tab-4-choice">
        <label class="radio-container">High energy
            <input type="radio" name="radio8" onchange="changeColor2(this)" value="4,5">
            <span class="checkmark2"></span>
        </label>

            <label class="radio-container">Moderate energy
            <input type="radio" name="radio8" onchange="changeColor2(this)" value="3">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Low energy
            <input type="radio" name="radio8" onchange="changeColor2(this)" value="1,2">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">I'm open to it
            <input type="radio" name="radio8" onchange="changeColor2(this)" value="1,2,3,4,5">
            <span class="checkmark2"></span>
        </label>
    </div>
    <div class="tab" id="tab-4-choice">
        <label class="radio-container">Very vocal and talkative
            <input type="radio" name="radio9" onchange="changeColor2(this)" value="4,5">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Somewhat vocal
            <input type="radio" name="radio9" onchange="changeColor2(this)" value="3">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Generally quiet
            <input type="radio" name="radio9" onchange="changeColor2(this)" value="1,2">
            <span class="checkmark2"></span>
            </label>

        <label class="radio-container">I'm open to it
            <input type="radio" name="radio9" onchange="changeColor2(this)" value="1,2,3,4,5">
            <span class="checkmark2"></span>
        </label>
    </div>
    <div class="tab">
        <label class="radio-container">Very important
            <input type="radio" name="radio10" onchange="changeColor2(this)" value="5">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Somewhat important
            <input type="radio" name="radio10" onchange="changeColor2(this)" value="4">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Unsure
            <input type="radio" name="radio10" onchange="changeColor2(this)" value="3">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Not very important
            <input type="radio" name="radio10" onchange="changeColor2(this)" value="2">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Not important at all
            <input type="radio" name="radio10" onchange="changeColor2(this)" value="1">
            <span class="checkmark2"></span>
        </label>
    </div>
    <div class="tab">
        <label class="radio-container">Unlimited time and money
            <input type="radio" name="radio11" onchange="changeColor2(this)" value="5">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">A lot of time and money
            <input type="radio" name="radio11" onchange="changeColor2(this)" value="4">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Moderate time and money
            <input type="radio" name="radio11" onchange="changeColor2(this)" value="3">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Some time and money
            <input type="radio" name="radio11" onchange="changeColor2(this)" value="2">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Minimal time and money
            <input type="radio" name="radio11" onchange="changeColor2(this)" value="1">
            <span class="checkmark2"></span>
        </label>
    </div>
    <div class="tab">
        <label class="radio-container">Very important
            <input type="radio" name="radio12" onchange="changeColor2(this)" value="5">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Somewhat important
            <input type="radio" name="radio12" onchange="changeColor2(this)" value="4">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Unsure
            <input type="radio" name="radio12" onchange="changeColor2(this)" value="3">
            <span class="checkmark2"></span>
            </label>

        <label class="radio-container">Not very important
            <input type="radio" name="radio12" onchange="changeColor2(this)" value="2">
            <span class="checkmark2"></span>
        </label>

        <label class="radio-container">Not important at all
            <input type="radio" name="radio12" onchange="changeColor2(this)" value="1">
            <span class="checkmark2"></span>
        </label>
    </div>
    <div  style="overflow:auto; ">
        <div class="nextprevButton">
            <button class="matching-next-prev-button" type="button" id="prevBtn" onclick="nextPrev(-1)" style="display:none;"> Previous</button>
            <button class="matching-next-prev-button" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
            <button class="matching-next-prev-button" type="submit" id="subBtn" style="display:none;">Find Matches</button>
        </div>
    </div>
</form>
</div>
</div>
</body>
<script type="text/javascript">

var currentTab=0;
function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("tab");
    var y = document.getElementsByClassName("tabQ");
    x[n].style.display = "block";
    y[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n >= 1) {
        document.getElementById("prevBtn").style.display = "inline";
        document.getElementById("nextBtn").style.padding = "10px 20px";
    } else {
        document.getElementById("prevBtn").style.display = "none";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("subBtn").style.display = "inline";
        /*document.getElementById("nextBtn").innerHTML = 'Find Matches<span class="material-symbols-outlined" style="vertical-align: -7px;">frame_inspect</span> ';*/


    } else {
        document.getElementById("subBtn").style.display = "none";
        document.getElementById("nextBtn").style.display = "inline";
        document.getElementById("nextBtn").innerHTML = "Next";
    }
    fixStepIndicator(n);
}

function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    var y = document.getElementsByClassName("tabQ");
    // Exit the function if any field in the current tab is invalid:
    console.log(currentTab);
    if (n == 1 ){
        if (!validateForm(currentTab)) return false;
        if(currentTab == 0){
            console.log("zero");
            var pet_button = document.getElementsByClassName('button-cat-dog clicked')[0].value;
            console.log(pet_button);
            if (pet_button === "cat"){
                x[currentTab].style.display = "none";
                y[currentTab].style.display = "none";
                console.log("cat");
                currentTab = currentTab + n;
                showTab(currentTab);
            }
            if (pet_button === "dog"){
                x[currentTab].style.display = "none";
                y[currentTab].style.display = "none";
                 console.log("doggg");
                 currentTab = currentTab + n + 1;
                 showTab(currentTab);
            }
        }
        else if(currentTab == 1){
                x[currentTab].style.display = "none";
                y[currentTab].style.display = "none";
                console.log("cat");
                currentTab = currentTab + n + 1;
                showTab(currentTab);
            }
        else{
        x[currentTab].style.display = "none";
        y[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        console.log("here");
        currentTab = currentTab + n;
        showTab(currentTab);
        
        }}
    if(n == -1){
        if(currentTab == 3){
            var pet_button = document.getElementsByClassName('button-cat-dog clicked')[0].value;
            console.log(pet_button);
            if (pet_button === "cat"){
                x[currentTab].style.display = "none";
                y[currentTab].style.display = "none";
                console.log("cat");
                currentTab = currentTab + n - 1;
                showTab(currentTab);
            }
            if (pet_button === "dog"){
                x[currentTab].style.display = "none";
                y[currentTab].style.display = "none";
                 console.log("doge");
                 currentTab = currentTab + n ;
                 showTab(currentTab);
            }}
        else if(currentTab == 2){
            console.log("twooo");
                x[currentTab].style.display = "none";
                y[currentTab].style.display = "none";
                currentTab = currentTab + n - 1;
                showTab(currentTab);
            }
        else{
            console.log("bb");
        x[currentTab].style.display = "none";
        y[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        showTab(currentTab);
    }
    }
    // Otherwise, display the correct tab:
    
    }

function fixStepIndicator(n) {
    var i, x = document.getElementsByClassName("matching-progress-bar");
    console.log("bbb");
    if(currentTab==2){
                console.log("dbar");
                for (i = 0; i < x.length; i++) {
                x[i].style.width = (8.33 * (n)) + '%';
                x[i].innerHTML = (n) + '/12';
            }
    }
    else if(currentTab==1){
                console.log("cbar");
                for (i = 0; i < x.length; i++) {
                x[i].style.width = (8.33 * (n+1)) + '%';
                x[i].innerHTML = (n+1) + '/12';
            }
    }
    else if(currentTab==0){
                for (i = 0; i < x.length; i++) {
                x[i].style.width = (8.33 * (1)) + '%';
                x[i].innerHTML = (1) + '/12';
            }
    }
    else{
        console.log("abar");
    for (i = 0; i < x.length; i++) {
        x[i].style.width = (8.33 * (n)) + '%';
        x[i].innerHTML = (n) + '/12';
    }
    }
}

function validateForm(x) {
  var form = document.getElementById("matchingForm");
  var tabs = form.getElementsByClassName("tab");
  var isValid = true;

  if (x === 0) {
    // First tab with buttons
    var catButton = form.querySelector("#cat");
    var dogButton = form.querySelector("#dog");

    if (!catButton.classList.contains("clicked") && !dogButton.classList.contains("clicked")) {
      isValid = false;
    }
  } else {
    // Subsequent tabs with radio buttons
    var currentTabRadios = tabs[x].querySelectorAll("input[type='radio']:checked");
    if (currentTabRadios.length === 0) {
      isValid = false;
    }
  }

  if (!isValid) {
    alert("Please select an option in each tab before proceeding.");
  }

  return isValid;
}




function changeColor(button) {
    var buttons = document.getElementsByClassName("button-cat-dog");
    for (var i = 0; i < buttons.length; i++) {
      buttons[i].classList.remove("clicked");
    }

    // Add the 'clicked' class to the button that was clicked
    button.classList.add("clicked");
  }


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



</script>
</html>