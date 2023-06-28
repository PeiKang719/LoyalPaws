<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="media/tabIcon.png">
<link rel="stylesheet" type="text/css" href="ClinicHeaderStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  </head>
  <style type="text/css">
    #sidebar-icon{
  color:#999999;
  font-size: 27px;
  vertical-align: -3px;
}

.sidebar a,.dropdown-btn {
  padding: 15px 40px 15px 35px;
  text-decoration: none;
  font-size: 25px;
  color:#999999;
  display: block;
  border: none;
  width: 100%;
  background: black;
  background-size: 300% 100%;

}

#dropdown-btn-id{
  text-align: left;
}

#dropdown-btn-id:hover #sidebar-icon,a:hover #sidebar-icon {
  color: white;

}


/* When you mouse over the navigation links, change their color */
.sidebar a:hover,.dropdown-btn:hover{
  color:white;
  background: linear-gradient(to right,black 20%,#0099ff 60%);
  background-size: 300% 100%;
  background-position: -100% 0;
}


.dropdown-container {
  display: none;
  background-color: #004080;
  padding-left: 50px;
}

/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}

.active {
 background: linear-gradient(to right,black 20%,#0099ff 60%);
 background-size: 300% 100%;
 background-position: -100% 0;
  color: white;
  width: 100%;
}

.sidebar a.active {
  background: linear-gradient(to right,black 20%,#0099ff 60%);
  background-size: 300% 100%;
  background-position: -100% 0;
  color: white;
  width: 100%;
}

.sidebar a.active #sidebar-icon,.dropdown-btn.active #sidebar-icon {
/*icon active color*/
  color: white; 
}

  </style>
  <body>
    <?php
    $currentURL = $_SERVER['PHP_SELF'];
    if (strpos($currentURL, 'Seller_Pets-Profile.php') === false && strpos($currentURL, 'SideBar_Breed-Breed-Profile.php') === false) {
    session_start();
    $adminID = $_SESSION['adminID'];
  }
    ?>
    <nav>
      <label for="check" class="checkbtn" style="display:block;margin-right: 0px;">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo"><a href="UserHomePage.php"><img src="media/lp.png" width="250" height="70" style="margin-top: -30px;margin-bottom: -33px;"></a></label>
      <ul>
        <li><a href="Login.php"> Log Out</a></li>
      </ul>
    </nav>
    <input type="checkbox" id="check">
    <aside class="sidebar" >
  <img id="profile" src="media/admin.jpg">
  <p id="name" style="margin-top:5px">ADMIN</p>
  <hr >

      <a href="AdminHomePage.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon" >grid_view</span>&nbsp;Dashboard</a>
      <a href="SideBar_Clinic.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">vaccines</span>&nbsp;Veterinary Clinic</a>
    <button class="dropdown-btn" id="dropdown-btn-id">
      <span class="material-symbols-outlined" id="sidebar-icon">folder</span>&nbsp;Pet Breed
    </button>
    <div class="dropdown-container">
      <a href="SideBar_Breed_Dog.php" class="sidebar-item">Dog</a>
      <a href="SideBar_Breed_Cat.php" class="sidebar-item">Cat</a>
    </div>
      <a href="SideBar_Donation.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">volunteer_activism</span>&nbsp;Donation</a>
      <a href="SideBar-View-User.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">group</span>&nbsp;View Users</a>
      <a href="Pets.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">pets</span>&nbsp;View Sellers</a>
      <a href="Report.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">bar_chart</span>&nbsp;Report</a>
      <a href="SideBar-Password.php" class="sidebar-item"><span class="material-symbols-outlined" id="sidebar-icon">key</span>&nbsp;Password</a>
      
</aside>

<script>

  var currentUrl = window.location.href;
// get all sidebar links
var sidebarLinks = document.querySelectorAll('.sidebar-item');

// loop through sidebar links and check if the URL matches
sidebarLinks.forEach(function(link) {
  if (link.href === currentUrl) {
    link.classList.add('active');
    if (link.href.includes("SideBar_Breed")) {
      document.getElementById("dropdown-btn-id").classList.add("active");
    }
  }
});

const sidebarItems = document.querySelectorAll('.sidebar-item');

  // loop through each item
  sidebarItems.forEach(item => {
    // check if the item or any of its child links is the current active URL
    if (window.location.href.includes(item.href) ||
        item.querySelector('a')?.href === window.location.href) {
      // add the active class to the item
      item.classList.add('active');

      // if the item is a child of the dropdown, add the active class to the dropdown button
      const dropdown = item.closest('.dropdown-container');
      if (dropdown) {
        const dropdownButton = document.querySelector(`#${dropdown.id}-btn`);
        if (dropdownButton) {
          dropdownButton.classList.add('active');
        }
      }
    }
  });

var dropdownBtn = document.getElementById("dropdown-btn-id");
  var dropdownIcon = dropdownBtn.querySelector("#sidebar-icon");

  dropdownBtn.addEventListener("click", function() {
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
      dropdownIcon.innerHTML = "folder";
    } else {
      dropdownContent.style.display = "block";
      dropdownIcon.innerHTML = "folder_open";
    }
  });

</script>
  </body>
</html>