<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Main page</title>
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="SellerStyle.css">
<link rel="icon" type="image/png" href="media/tabIcon.png">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>
<body >

<?php include 'SellerHeader.php';  ?>



<section class="content" id="AdminHomePage">	
	<canvas id="myChart" style="width:100%;max-width:600px"></canvas>
</section>



<script>
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
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

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