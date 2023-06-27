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

</head>
<body>
<?php include 'ClinicHeader.php'; ?>
<?php include 'Connection.php'; ?>


<div class="container">
  <div class="add-new-treatment-container">
  <button class="add-treatment-button" id="add-treatment-button" style="color:#4d4d4d;font-size:27px;font-weight:bold;background-color: transparent;box-shadow: 0 0 0 0;cursor: text;">My Treatment</button>
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search For Treatment" >
</div>
  <br>
  <table class="treatment-table" border="0" id="treatment-table">
  <th style="width:40px">No</th>
  <th style="width:240px">Name</th>
  <th>Description</th>
  <th style="width:140px">Unit Price</th>
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
     
  

</script>

</body>
</html>