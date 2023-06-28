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
  input[type=number]{
    width: 50%;
    font-size: 25px;
    text-align: center;
  }
  input[type=number]:focus{
    border: 2px solid black;
    border-bottom: 2px solid black;
    background-color: white;
  }
  input[type=text]{
    width: 90%;
    font-size: 25px;
  }
  input[type=text]:focus{
    border: 2px solid black;
    border-bottom: 2px solid black;
    background-color: white;
  }

  hr{
    width: 95% !important;
    border:2px solid #d9d9d9;
  }
  .hide_td{
    width: 0px;
    border: 0;
    padding: 0 !important;
  }
</style>
</head>
<body>
<?php include 'ClinicHeader.php'; ?>
<?php include 'Connection.php'; ?>
<?php $appointmentID = $_GET['appointmentID']; 
      $sql11 ="SELECT ca.petID,ca.adopterID,c.discount_percent FROM clinic_appointment ca,clinic c WHERE ca.clinicID=c.clinicID AND ca.appointmentID=$appointmentID";
      $result11 = $conn->query($sql11);
      $row11 = $result11->fetch_assoc();
      $petID =$row11['petID'];
      $discount_percent = $row11['discount_percent'];
?>

<div class="container" style="display:flex;flex-direction: column;">
  <div class="add-new-treatment-container" >
    <p class="profile-header" style="margin-left:0px;width:100px;margin-bottom:-30px">Record</p>
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search For Treatment" >
</div>
  <table class="treatment-table" border="0" id="treatment-table" style="margin-top: 50px;">
  <th style="width:240px;font-size: 25px;">Name</th>
  <th style="font-size: 25px;">Description</th>
  <th style="width:140px;font-size: 25px;">Unit Price</th>
  <th style="width:40px;font-size: 25px;">Quantity</th>
  <th colspan="1" style="width: 60px;font-size: 25px;" > </th>
<?php 
$sql = "SELECT *,t.name AS tname FROM treatment t,vet_treatment vt, vet v WHERE t.treatmentID=vt.treatmentID AND vt.vetID = v.vetID AND vt.vetID= $vetID  ORDER BY t.name ";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $clinicID=$row["clinicID"];
          $treatmentID=$row["treatmentID"];
          $tname=$row["tname"];
          $description=$row["description"];
          $unit_price=$row["unit_price"];
          ?>
    <tr>
    <td style="font-size: 25px;"><?php echo $tname?></td>
    <td style="font-size: 25px;"><?php echo $description?></td>
    <td style="text-align:center;font-size: 25px;">RM <?php echo $unit_price?></td>
    <td style="text-align: center;font-size: 25px;"><input type="number" name="quantity" value="1" required></td>
    <td><button class="manage-button" style="background-color: #29a329;"><span class="material-symbols-outlined" style="font-size:35px;vertical-align: -3px;">add_circle</span></button></td>
    <td style="width:0%;border:0;padding:0"><input type="hidden" name="treatmentID" value="<?php echo $treatmentID ?>"></td>
  </tr>      
<?php  }?>
<tr  style="display:none">
    <td style="font-size: 25px;"><input type="text" name="name2[]" disabled> </td>
    <td style="font-size: 25px;"><input type="text" name="description2[]" disabled></td>
    <td style="text-align:center;font-size: 25px;">RM <input type="number" name="price2[]" disabled></td>
    <td style="text-align: center;font-size: 25px;"><input type="number" name="quantity2[]" value="1" required disabled></td>
    <td><button class="manage-button" style="background-color: #29a329;"><span class="material-symbols-outlined" style="font-size:35px;vertical-align: -3px;">add_circle</span></button></td>
  </tr> 
  <tr style="display:none">
    <td style="font-size: 25px;"><input type="text" name="name2[]" disabled> </td>
    <td style="font-size: 25px;"><input type="text" name="description2[]" disabled></td>
    <td style="text-align:center;font-size: 25px;">RM <input type="number" name="price2[]" disabled></td>
    <td style="text-align: center;font-size: 25px;"><input type="number" name="quantity2[]" value="1" required disabled></td>
    <td><button class="manage-button" style="background-color: #29a329;"><span class="material-symbols-outlined" style="font-size:35px;vertical-align: -3px;">add_circle</span></button></td>
  </tr>
  <tr style="display:none">
    <td style="font-size: 25px;"><input type="text" name="name2[]" disabled> </td>
    <td style="font-size: 25px;"><input type="text" name="description2[]" disabled></td>
    <td style="text-align:center;font-size: 25px;">RM <input type="number" name="price2[]" disabled></td>
    <td style="text-align: center;font-size: 25px;"><input type="number" name="quantity2[]" value="1" required disabled></td>
    <td><button class="manage-button" style="background-color: #29a329;"><span class="material-symbols-outlined" style="font-size:35px;vertical-align: -3px;">add_circle</span></button></td>
  </tr>
  <?php
}else{?>
  <tr>
    <td colspan="6">No treatment provided yet...</td>
  </tr>
<?php } ?>

 </table>
 <div class="add-button-container" id="add-more-button" >
      <span class="material-symbols-outlined" id="add-button">add_circle</span>
      <p>Custom Treatment</p>
    </div>
 <br><br>
<hr>
<form id="recordForm" action="Clinic-Record-Process.php?action=insert" method="post" target="hiddenFrame" enctype="multipart/form-data">
  <input type="hidden" name="appointmentID" value="<?php echo $appointmentID ?>">
  <?php if($petID != NULL){ ?>
  <input type="hidden" name="discount_percent" id="discount_percent" value="<?php echo $discount_percent ?>">
  <?php }else{ ?>
    <input type="hidden" name="discount_percent" id="discount_percent" value="100">
  <?php } ?>
<div class="patient-recod-container">
  <p class="recordTable-header">Treatment Record</p>
  <div style="display:flex;flex-direction: row;width: 100%;align-items: center;margin-bottom: 20px;height: 60px;">
  <label style="width:13%;font-size:27px">Pet Name:</label>
  <input type="text" name="name" style="width:25%;font-size: 25px;" required>
  </div>
  <table border="1" id="recordTable">
    <th style="width:580px">Treatment</th>
    <th>Unit Price</th>
    <th>Quantity</th>
    <th style="width:147px">Total</th>

  </table>

<table border="1" style="width: 100%;margin-bottom: 50px;">
  <?php if($petID != NULL){ ?>
    <tr>
<td colspan="3" class="total_row" style="text-align:right;background-color: #e6f5ff;">Adopter Exclusive Discount (<?php echo $discount_percent ?>%): </td>
<td id="minus" class="total_row" style="width:137.5px;text-align:center"></td>
</tr>
  <?php } ?>
  <tr>
<td colspan="3" class="total_row" style="text-align:right;background-color: #e6f5ff;">Sub-Total: </td>
<td id="total" class="total_row" style="width:137.5px;text-align:center"></td>
</tr>
</table>

<p style="font-size:20px;margin-top: 30px;">Comment:</p>
<textarea class="record-description" name="comment" rows="5"></textarea>
<br><br><br><br>
<button class="submit-record-button" type="submit" onclick="confirmSubmit()">Submit</button>

</div>
</form>
</div>




<script type="text/javascript">
$(document).ready(function() {
  $('.manage-button').click(function() {
    // Get the current row
   var row = $(this).closest('tr');
var treatmentID = row.find('input[name="treatmentID"]').val();

if (treatmentID) {
  // Row other than the custom row is being added or deleted
  var treatment = row.find('td:first-child').text();
  var description = row.find('td:nth-child(2)').text();
  var unitPrice = parseFloat(row.find('td:nth-child(3)').text().replace('RM', ''));
  var quantity = row.find('input[name="quantity"]').val();
  var total = unitPrice * quantity;
} else {
  // Custom row is being added or deleted
  var treatment = row.find('input[name="name2[]"]').val();
  var description = row.find('input[name="description2[]"]').val();
  var unitPrice = parseFloat(row.find('input[name="price2[]"]').val());
  var quantity = parseInt(row.find('input[name="quantity2[]"]').val());
  var total = unitPrice * quantity;
}

    console.log(treatmentID);
    // Check if the row exists in the record table
    var isRowExist = $('#recordTable').find('td:contains(' + treatment + ')').length > 0;

    if (isRowExist) {
      // Row exists in record table, remove the row
      var recordRow = $('#recordTable').find('td:contains(' + treatment + ')').closest('tr');
      recordRow.next('tr').remove(); // Remove the next row
      recordRow.remove();
      updateSubtotal();
      // Change the button back to "Add"
      $(this).html('<span class="material-symbols-outlined" style="font-size:35px;vertical-align: -3px;">add_circle</span>');
      $(this).css('background-color', '#29a329');
    } else if (treatmentID) {
      // Row does not exist in record table, append it
      $('#recordTable').append('<tr><td class="td1"><b>' + treatment + '</b></td><td style="text-align: center;" rowspan="2">RM ' + unitPrice + '</td><td style="text-align: center;" rowspan="2"><input type="hidden" name="quantity[]" value="'+quantity+'">' + quantity + '</td><td style="text-align: center;" rowspan="2">RM ' + total + '</td><td class="hide_td"><input type="hidden" name="treatmentID[]" value="'+treatmentID+'"</td></tr><tr><td style="font-style:italic"  class="td2">' + description + '</td>');
      // Change the button to "Remove"
      updateSubtotal();
      toggleAddRemoveButton(row);
    }else{
       $('#recordTable').append('<tr><td class="td1"><input type="hidden" name="name2[]" value="'+treatment+'"><b>' + treatment + '</b></td><td style="text-align: center;" rowspan="2"><input type="hidden" name="price2[]" value="'+unitPrice+'">RM ' + unitPrice + '</td><td style="text-align: center;" rowspan="2"><input type="hidden" name="quantity2[]" value="'+quantity+'">' + quantity + '</td><td style="text-align: center;" rowspan="2">RM ' + total + '</td></tr><tr><td style="font-style:italic"  class="td2"><input type="hidden" name="description2[]" value="'+description+'">' + description + '</td>');
      // Change the button to "Remove"
      updateSubtotal();
      toggleAddRemoveButton(row);
    }

    function updateSubtotal() {
  var rows = $('#recordTable tr:not(:last-child):odd');
// Exclude the last row (subtotal row)
  var subtotal = 0;
  var discountGet = document.getElementById("discount_percent");
  var discount = parseFloat(discountGet.value);

  rows.each(function() {
    var unitPrice = parseFloat($(this).find('td:nth-child(2)').text().replace('RM ', ''));
    var quantity = parseInt($(this).find('td:nth-child(3)').text());
    console.log("unit price"+unitPrice);
    console.log("quantity"+quantity);
    var total = unitPrice * quantity;
    subtotal += total;

    // Update the "Total" value in the row
    $(this).find('td:nth-child(4)').text('RM ' + total.toFixed(2));
  });

  // Calculate the total
  if (discount==100){var minus = 0;}else{var minus = (subtotal * (discount/100)).toFixed(2);}
  subtotal -= minus;
  var total = subtotal.toFixed(2);

  // Display the subtotal and total in the designated elements
  if (discount==100){}else{$('#minus').html('<b>- RM ' + minus + '</b>');}
  
  $('#total').html('<b>RM ' + total + '</b>');
}

  });
});

$(document).ready(function() {
  $("#add-more-button").click(function() {
    // Show the first hidden template row
    var newRow = $("#treatment-table tr:hidden:first");
    newRow.show();
    
    // Enable inputs in the new row
    newRow.find('input').prop('disabled', false);
    
    // Check if there are any more hidden rows
    if ($("#treatment-table tr:hidden").length === 0) {
      // No more hidden rows, hide the "Add more" button
      $("#add-more-button").hide();
    }
  });
});




function toggleAddRemoveButton(row) {
  var treatment = row.find('td:first-child').text();
  var addButton = row.find('.manage-button');

  if ($('#recordTable').find('td:contains(' + treatment + ')').length > 0) {
    // Row exists in record table, change button to "Remove"
    addButton.html('<span class="material-symbols-outlined" style="font-size:35px;vertical-align: -3px;">delete</span>');
    addButton.css('background-color', 'red');
  } else {
    // Row does not exist in record table, change button to "Add"
    addButton.html('<span class="material-symbols-outlined" style="font-size:35px;vertical-align: -3px;">add_circle</span>');
  }

}

function confirmSubmit() {
  // Display a confirmation dialog
  var result = confirm("Are you sure you want to submit the record?");
  
  // If user confirms, submit the form
  if (result) {
    // Get the form element
    var form = document.getElementById("recordForm");
    
    // Submit the form
    form.submit();
  }
}


function SearchFunction() {
  var input, filter, table, tr, td2, i, txtValue , txtValue2;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("treatment-table");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {

    td2 = tr[i].getElementsByTagName("td")[0];

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