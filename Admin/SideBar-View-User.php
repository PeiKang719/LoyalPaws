<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
  <link rel="icon" type="image/png" href="../media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="../Clinic/css/ClinicStyle.css">
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
<?php include '../Database/Connection.php'; ?>


<div class="container" style="padding-left:0;padding-right:0;width: 100%;">
 <p class="profile-header" style="margin-left:50px">Adopter</p>

  <div style="width:92%;padding:2% 4%" >
    <br>
  <div class="add-new-treatment-container">
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search For Name" >
</div>
  <br>
  <table class="treatment-table" border="0" id="myTable">
  <th style="width:40px" onclick="sortTable2(0)">No</th>
  <th style="width:105px">Image</th>
  <th style="width:230px" onclick="sortTable(2)">Name</th>
  <th onclick="sortTable(3)">Date of Birth</th>
  <th style="width:140px" onclick="sortTable(4)">Location</th>
  <th style="width:40px" onclick="sortTable2(5)">Phone</th>
  <th style="width:40px" onclick="sortTable(6)">Email</th>
  <th colspan="1" style="width: 50px;" > </th>
<?php 
include '../Database/Connection.php';
$i=1;
$sql = "SELECT * FROM adopter  ORDER BY adopterID ";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $image =$row['image'];
          $adopterID=$row["adopterID"];
          $firstName=$row["firstName"];
          $lastName=$row["lastName"];
          $dob=$row["dob"];
          $area=$row["area"];
          $state=$row["state"];
          $phone=$row["phone"];
          $email=$row["email"];

          $imageData = base64_encode($image);
          $imageSrc = "data:image/jpg;base64," . $imageData;
          // Check if the image file exists before displaying it
          if($image==NULL){
            $imageSrc = '../media/profile.png';
          }
          elseif (file_exists('../User/adopter_images/' . $image)) {
              $imageSrc = '../User/adopter_images/' . $image;
          }
          ?>
    <tr>
    <td><?php echo $adopterID?></td>
    <td><img src="<?php echo $imageSrc ?>" style="width: 100px;height: 100px;"> </td>
    <td><?php echo $firstName ?> <?php echo $lastName ?></td>
    <td><?php echo $dob?></td>
    <td><?php echo $area ?>,<?php echo $state ?></td>
    <td><?php echo $phone?></td>
    <td><?php echo $email?></td>
    <td><a href="SideBar-View-User-Process.php?adopterID=<?php echo $adopterID ?>" onclick="confirmDelete(event);"><button class="manage-button" style="background-color:#e62e00"><span class="material-symbols-outlined">delete</span></button></a></td>
  </tr>      
<?php $i++;}

}else{?>
  <tr>
    <td colspan="8">No User yet...</td>
  </tr>
</table>
<?php } ?>
 </table>
</div>

<script type="text/javascript">
function confirmDelete(event) {
  event.preventDefault();
    if (confirm("Are You Sure To Delete This Adopter Information?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", event.currentTarget.href, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Deleted Adopter Information");
                window.location.reload();
            } else {
                alert("Error Deleting Adopter Information");
            }
        };
        xhr.send();
    } else {
        console.log("User cancelled the delete operation.");
    }
}

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