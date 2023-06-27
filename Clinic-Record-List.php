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
  <button class="add-treatment-button" id="add-treatment-button" style="color:#4d4d4d;font-size:27px;font-weight:bold;background-color: transparent;box-shadow: 0 0 0 0;cursor: text;">Record History</button>
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search For Pet Owner" >
</div>
  <br>
  <table class="treatment-table" border="0" id="treatment-table">
  <th style="width:180px">Date</th>
  <th style="width:300px">Pet Owner</th>
  <th>Pet</th>
  <th style="width:300px">Vet</th>
  <th style="width:100px">Record</th>
  <th style="width:100px">Receipt</th>
<?php 
$i=1;
$sql = "SELECT * FROM (SELECT cp.paymentID,cp.date,CONCAT(firstName,' ',lastName) AS adopterName,a.adopterID,r.pet_name,v.name AS vet_name,cp.recordID,cp.amount,cp.transactionID FROM clinic_payment cp,record r,adopter a,vet v,clinic_appointment ca WHERE cp.recordID=r.recordID AND r.appointmentID=ca.appointmentID AND ca.vetID=v.vetID AND ca.adopterID=a.adopterID AND ca.clinicID=$clinicID UNION ALL SELECT cp.paymentID,cp.date,CONCAT(a.firstName,' ',a.lastName) AS adopterName,a.adopterID,r.pet_name,v.name AS vet_name,cp.recordID,cp.amount,cp.transactionID FROM clinic_payment cp,record r,adopter a,vet v,clinic_appointment ca,pet p,clinic c WHERE cp.recordID=r.recordID AND r.appointmentID=ca.appointmentID AND ca.vetID=v.vetID AND ca.clinicID=c.clinicID AND ca.petID=p.petID AND p.adopterID=a.adopterID AND c.clinicID=$clinicID) AS combined_table ORDER BY paymentID DESC ";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $paymentID=$row["paymentID"];
          $date=$row["date"];
          $adopterName=$row["adopterName"];
          $adopterID=$row["adopterID"];
          $pet_name=$row["pet_name"];
          $recordID=$row["recordID"];
          $amount=$row["amount"];
          $vet_name=$row["vet_name"];
          $transactionID=$row["transactionID"];
          ?>
    <tr>
    <td style="text-align:center"><?php echo $date?></td>
    <td style="text-align:center"><?php echo $adopterName?></td>
    <td style="text-align:center"><?php echo $pet_name?></td>
    <td style="text-align:center"><?php echo $vet_name?></td>
    <td style="text-align:center">
      <button class="reschedule-button" onclick="recordModal2(<?php echo $recordID ?>)"><span class="material-symbols-outlined" style="vertical-align:-3px">history_edu</span></button>
    </td>
    <td style="text-align:center">
      <button class="reschedule-button" style="color:white" onclick="receipt(<?php echo $paymentID?>,<?php echo $adopterID ?>);"><span class="material-symbols-outlined" style="vertical-align:-3px">receipt_long</span></button>
    </td>
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
</script>

</body>
</html>