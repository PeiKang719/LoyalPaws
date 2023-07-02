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
  #treatment-table{
    cursor: pointer;
  }
</style>
</head>
<body>
<?php include 'ClinicHeader.php'; ?>
<?php include 'Connection.php'; ?>


<div class="container">
  <div class="add-new-treatment-container">
  <button class="add-treatment-button" id="add-treatment-button" style="color:#4d4d4d;font-size:27px;font-weight:bold;background-color: transparent;box-shadow: 0 0 0 0;cursor: text;">Record History</button>
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search For Pet Owner" >
</div>
  <br>
  <table class="treatment-table" border="0" id="treatment-table">
  <th style="width:180px" onclick="sortTable(0,'date');">Date</th>
  <th style="width:300px" onclick="sortTable2(1);">Pet Owner</th>
  <th onclick="sortTable2(2);">Pet</th>
  <th style="width:300px" onclick="sortTable2(3);">Vet</th>
  <th style="width:100px">Record</th>
  <?php if($role=='Admin'){?>
  <th style="width:100px">Receipt</th>
<?php } ?>
<?php 
$i=1;
$sql = "SELECT * FROM (SELECT r.date,CONCAT(firstName,' ',lastName) AS adopterName,a.adopterID,r.pet_name,v.name AS vet_name,r.recordID FROM record r,adopter a,vet v,clinic_appointment ca WHERE r.appointmentID=ca.appointmentID AND ca.vetID=v.vetID AND ca.adopterID=a.adopterID AND ca.clinicID=$clinicID UNION ALL SELECT r.date,CONCAT(a.firstName,' ',a.lastName) AS adopterName,a.adopterID,r.pet_name,v.name AS vet_name,r.recordID FROM record r,adopter a,vet v,clinic_appointment ca,pet p,clinic c WHERE r.appointmentID=ca.appointmentID AND ca.vetID=v.vetID AND ca.clinicID=c.clinicID AND ca.petID=p.petID AND p.adopterID=a.adopterID AND c.clinicID=$clinicID) AS combined_table ORDER BY recordID DESC ";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $date=$row["date"];
          $adopterName=$row["adopterName"];
          $adopterID=$row["adopterID"];
          $pet_name=$row["pet_name"];
          $recordID=$row["recordID"];
          $vet_name=$row["vet_name"];

          
          ?>
    <tr>
    <td style="text-align:center"><?php echo $date?></td>
    <td style="text-align:center"><?php echo $adopterName?></td>
    <td style="text-align:center"><?php echo $pet_name?></td>
    <td style="text-align:center"><?php echo $vet_name?></td>
    <td style="text-align:center">
      <button class="reschedule-button" onclick="recordModal2(<?php echo $recordID ?>)"><span class="material-symbols-outlined" style="vertical-align:-3px">history_edu</span></button>
    </td>
    <?php if($role=='Admin'){?>
    <?php $sql2 = "SELECT paymentID FROM clinic_payment WHERE recordID = $recordID";
          $result2 = $conn->query($sql2);
          if ($result2->num_rows > 0) { 
          $row2 = $result2->fetch_assoc();?>
    <td style="text-align:center">
      <button class="reschedule-button" style="color:white" onclick="receipt(<?php echo $row2['paymentID']?>,<?php echo $adopterID ?>);"><span class="material-symbols-outlined" style="vertical-align:-3px">receipt_long</span></button>
    </td>
  <?php }else{ ?>
    <td style="text-align:center">
      <button class="reschedule-button" style="color:white;cursor:not-allowed;background-color: #cc9900;" disabled ><span class="material-symbols-outlined" style="vertical-align:-3px">hourglass_bottom</span></button>
    </td>
  <?php }} ?>
  </tr>      
<?php $i++; }

}else{?>
  <tr>
    <td colspan="6">No record history yet...</td>
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
     
  
function recordModal2(recordID) {
  window.open("User-Pet-Appointment-List-Record.php?role=clinic&recordID=" + recordID, "_blank");
}

function receipt(paymentID,adopterID) {
  window.open("Clinic-Receipt.php?paymentID=" + paymentID +"&adopterID="+ adopterID, "_blank");
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
      
      if (type === "number") {
        // Convert the innerHTML values to numbers for numeric sorting
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