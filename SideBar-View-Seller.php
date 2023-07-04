<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
  <link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="ClinicStyle.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style type="text/css">
#myTable th{
  cursor: pointer;
}
</style>
</head>
<body>
<?php include 'AdminHeader.php'; ?>
<?php include 'Connection.php'; ?>


<div class="container" style="padding-left:0;padding-right:0;width: 100%;">
 <p class="profile-header" style="margin-left:50px">Pet Owner</p>
  <div class="manage-appointment-section">
    <a href="SideBar-View-Seller.php?type=individual">Individual Seller</a>
    <a href="SideBar-View-Seller.php?type=shop">Pet Shop</a> 
  </div>

<?php if(isset($_GET['type'])){
          if($_GET['type']=='individual'){
            individual();
          }
          elseif($_GET['type']=='shop'){
            shop();
          }
}else{
 individual();
}?>

  <?php function individual(){ ?>
  <div style="width:92%;padding:2% 4%" >
    <br>
  <div class="add-new-treatment-container">
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search By Name" >
</div>
  <br>
  <table class="treatment-table" border="0" id="myTable">
  <th style="width:40px" onclick="sortTable2(0)">ID</th>
  <th style="width:105px">Image</th>
  <th style="width:230px" onclick="sortTable(2)">Name</th>
  <th style="width:40px" onclick="sortTable2(3)">Phone</th>
  <th style="width:40px" onclick="sortTable(4)">Email</th>
  <th style="width:40px" onclick="sortTable2(5)">Pets</th>
  <th colspan="1" style="width: 110px;" > </th>
<?php 
include 'Connection.php';
$i=1;
$sql = "SELECT s.sellerID,s.image,s.firstName,s.lastName,s.dob,s.phone,s.email,COUNT(p.petID) as pet FROM seller s LEFT JOIN pet p ON p.sellerID=s.sellerID GROUP BY s.sellerID ORDER BY s.sellerID ";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $sellerID=$row["sellerID"];
          $image=$row["image"];
          $firstName=$row["firstName"];
          $lastName=$row["lastName"];
          $dob=$row["dob"];
          $phone=$row["phone"];
          $email=$row["email"];
          $pet=$row['pet'];

          $imageData = base64_encode($image);
          $imageSrc = "data:image/jpg;base64," . $imageData;
          // Check if the image file exists before displaying it
          if($image==NULL){
            $imageSrc = 'media/shop-image.jpg';
          }
          elseif (file_exists('seller_images/' . $image)) {
              $imageSrc = 'seller_images/' . $image;
          }
          ?>
    <tr>
    <td><?php echo $sellerID?></td>
    <td><img src="<?php echo $imageSrc ?>" style="width: 100px;height: 100px;"> </td>
    <td><?php echo $firstName?> <?php echo $lastName ?></td>
    <td><?php echo $phone?></td>
    <td><?php echo $email?></td>
    <td style="text-align: center;"><?php echo $pet?></td>
    <td><button class="manage-button" onclick="view_seller(<?php echo$sellerID ?>)"><span class="material-symbols-outlined">person</span></button>  <a href="SideBar-View-Seller-Process.php?action=seller&sellerID=<?php echo $sellerID ?>" onclick="confirmDeleteSeller(event);"><button class="manage-button" style="background-color:#e62e00"><span class="material-symbols-outlined">delete</span></button></a></td>
  </tr>      
<?php $i++;}

}else{?>
  <tr>
    <td colspan="7">No individual seller...</td>
  </tr>
</table>
<?php } ?>
 </table>
</div>
<?php } ?>


  <?php function shop(){ ?>
  <div style="width:92%;padding:2% 4%" >
    <br>
  <div class="add-new-treatment-container">
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search By Name" >
</div>
  <br>
  <table class="treatment-table" border="0" id="myTable">
  <th style="width:40px" onclick="sortTable2(0)">ID</th>
  <th style="width:105px">Image</th>
  <th style="width:230px" onclick="sortTable(2)">Name</th>
  <th style="width:40px" onclick="sortTable2(3)">Phone</th>
  <th style="width:40px" onclick="sortTable(4)">Email</th>
  <th style="width:40px" onclick="sortTable2(5)">Pets</th>
  <th colspan="1" style="width: 110px;" > </th>
<?php 
include 'Connection.php';
$i=1;
$sql = "SELECT s.shopID,s.shop_image,s.shopname,s.phone,s.email,COUNT(p.petID) as pet FROM pet_shop s LEFT JOIN pet p ON p.shopID=s.shopID GROUP BY s.shopID  ORDER BY s.shopID ";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $sellerID=$row["shopID"];
          $image=$row["shop_image"];
          $firstName=$row["shopname"];
          $phone=$row["phone"];
          $email=$row["email"];
          $pet=$row['pet'];

          $imageData = base64_encode($image);
          $imageSrc = "data:image/jpg;base64," . $imageData;
          // Check if the image file exists before displaying it
          if($image==NULL){
            $imageSrc = 'media/shop-image.jpg';
          }
          elseif (file_exists('pet_shop_images/' . $image)) {
              $imageSrc = 'pet_shop_images/' . $image;
          }
          ?>
    <tr>
    <td><?php echo $sellerID?></td>
    <td><img src="<?php echo $imageSrc ?>" style="width: 100px;height: 100px;"> </td>
    <td><?php echo $firstName ?></td>
    <td><?php echo $phone?></td>
    <td><?php echo $email?></td>
    <td style="text-align: center;"><?php echo $pet?></td>
    <td><button class="manage-button" onclick="view_shop(<?php echo$sellerID ?>)"><span class="material-symbols-outlined">person</span></button>  <a href="SideBar-View-Seller-Process.php?action=shop&shopID=<?php echo $sellerID ?>" onclick="confirmDeleteShop(event);"><button class="manage-button" style="background-color:#e62e00"><span class="material-symbols-outlined">delete</span></button></a></td>
  </tr>      
<?php $i++;}

}else{?>
  <tr>
    <td colspan="7">No pet shop...</td>
  </tr>
</table>
<?php } ?>
 </table>
</div>
<?php } ?>
</div>



<script type="text/javascript">
  $(document).ready(function() {
  var urlParams = new URLSearchParams(window.location.search);
  var sValue = urlParams.get('type');

  // Add or modify styles based on the 's' parameter value
  if (sValue === 'individual') {
    $('a[href*="SideBar-View-Seller.php?type=individual"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="SideBar-View-Seller.php?type=shop"]').css('border-bottom', '0');
  }
  else if (sValue === 'shop') {
    $('a[href*="SideBar-View-Seller.php?type=shop"]').css('border-bottom', '5px solid #00a8de');
    $('a[href*="SideBar-View-Seller.php?type=individual"]').css('border-bottom', '0');
  } 
  else{
    $('a[href*="SideBar-View-Seller.php?type=individual"]').css('border-bottom', '5px solid #00a8de');
  }
});


function SearchFunction() {
  var input, filter, table, tr, td2, i, txtValue , txtValue2;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {

    td2 = tr[i].getElementsByTagName("td")[2];

   if (td2) {
      txtValue2 = td2.textContent || td2.innerText;
      if (txtValue2.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      }  else {
        tr[i].style.display = "none";
      }
    }     
    }      
    }
     
 function view_seller(i) {
    window.location.href = "Seller-Profile.php?iid="+ i+"&admin=yes";

  } 
 function view_shop(i) {
    window.location.href = "Seller-Profile.php?sid="+ i+"&admin=yes";

  } 

function confirmDeleteSeller(event) {
  event.preventDefault();
    if (confirm("Are You Sure To Delete This Seller Information?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", event.currentTarget.href, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Deleted Seller Information");
                window.location.reload();
            } else {
                alert("Error Deleting Seller Information");
            }
        };
        xhr.send();
    } else {
        console.log("User cancelled the Seller operation.");
    }
}

function confirmDeleteShop(event) {
  event.preventDefault();
    if (confirm("Are You Sure To Delete This Pet Shop Information?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", event.currentTarget.href, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Deleted Pet Shop Information");
                window.location.reload();
            } else {
                alert("Error Deleting Pet Shop Information");
            }
        };
        xhr.send();
    } else {
        console.log("User cancelled the Pet Shop operation.");
    }
}


function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}


function sortTable2(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from the current row and one from the next: */
      x = parseFloat(rows[i].getElementsByTagName("TD")[n].innerHTML);
      y = parseFloat(rows[i + 1].getElementsByTagName("TD")[n].innerHTML);
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x > y) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x < y) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

</script>

</body>
</html>