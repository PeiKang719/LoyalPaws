<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="media/tabIcon.png">
  <link rel="stylesheet" type="text/css" href="AdminStyle.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>Main page</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body>
  <?php include'AdminHeader.php' ?>

  <section class="content" id="AdminHomePage">  
  <canvas id="myChart"></canvas>
</section>


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
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
      dropdownIcon.innerHTML = "folder";
    } else {
      dropdownContent.style.display = "block";
      dropdownIcon.innerHTML = "folder_open";
    }
  });
    var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
    var yValues = [55, 49, 44, 24, 15];
    var barColors = ["#b91d47", "#00aba9","#2b5797","#e8c3b9","#1e7145"];

    new Chart("myChart", {
      type: "pie",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          data: yValues
        }]
      },
      options: {
        title: {
          display: true,
          text: "World Wide Wine Production 2018"
        }
      }
    });
  </script>
</body>
</html>
