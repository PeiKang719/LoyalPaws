<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
  <link rel="icon" type="image/png" href="../media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="css/ClinicStyle.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style type="text/css">
  #treatment-table{
    cursor: pointer;
  }
</style>
</head>
<body>
<?php include 'ClinicHeader.php'; ?>
<?php include '../Database/Connection.php'; ?>


<div class="container">
  <div class="add-new-treatment-container">
  <button class="add-treatment-button" id="add-treatment-button" style="color:#4d4d4d;font-size:27px;font-weight:bold;background-color: transparent;box-shadow: 0 0 0 0;cursor: text;">My Treatment</button>
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search For Treatment" >
</div>
  <br>
  <table class="treatment-table" border="0" id="treatment-table">
  <th style="width:40px" onclick="sortTable(0,'number');">No</th>
  <th style="width:240px" onclick="sortTable2(1);">Name</th>
  <th onclick="sortTable2(2);">Description</th>
  <th style="width:140px" onclick="sortTable(3,'number');">Unit Price</th>
  
<?php 
$i=1;
$sql = "SELECT * FROM treatment t,vet_treatment vt WHERE vt.treatmentID=t.treatmentID AND vt.vetID= $vetID ORDER BY t.name ";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $clinicID=$row["clinicID"];
          $treatmentID=$row["treatmentID"];
          $name=$row["name"];
          $description=$row["description"];
          $unit_price=$row["unit_price"];
          ?>
    <tr>
    <td><?php echo $i?></td>
    <td><?php echo $name?></td>
    <td><?php echo $description?></td>
    <td>RM<?php echo $unit_price?></td>
  </tr>      
<?php $i++; }

}else{?>
  <tr>
    <td colspan="6">No treatment provided yet...</td>
  </tr>
</table>
<?php } ?>
 </table>
</div>



<script type="text/javascript">
function SearchFunction() {
  var input, filter, table, tr, td2, i, txtValue , txtValue2;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("treatment-table");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {

    td2 = tr[i].getElementsByTagName("td")[1];

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
     
  
function sortTable(n, type) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("treatment-table");
  switching = true;
  dir = "asc";
  
  while (switching) {
    switching = false;
    rows = table.rows;
    
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      
      if (type === "number" && n === 3) {
        // Convert the innerHTML values to numbers by ignoring the first 2 characters "RM"
        x = parseFloat(x.innerHTML.substring(2));
        y = parseFloat(y.innerHTML.substring(2));
      } else if (type === "number") {
        // Convert the innerHTML values to dates for date sorting
        x = parseFloat(x.innerHTML);
        y = parseFloat(y.innerHTML);
      } else if (type === "date") {
        // Convert the innerHTML values to dates for date sorting
        x = new Date(x.innerHTML);
        y = new Date(y.innerHTML);
      } else {
        // Default: treat the values as strings for normal sorting
        x = x.innerHTML;
        y = y.innerHTML;
      }
      
      if (dir == "asc") {
        if (x > y) {
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x < y) {
          shouldSwitch = true;
          break;
        }
      }
    }
    
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function sortTable2(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("treatment-table");
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

</script>

</body>
</html>