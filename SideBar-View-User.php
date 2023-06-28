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
<?php include 'AdminHeader.php'; ?>
<?php include 'Connection.php'; ?>


<div class="container" style="padding-left:0;padding-right:0;width: 100%;">
 <p class="profile-header" style="margin-left:50px">Adopter</p>

  <div style="width:92%;padding:2% 4%" >
    <br>
  <div class="add-new-treatment-container">
  <input type="text" class="search" id="myInput" onkeyup="SearchFunction()" placeholder="Search For Name" >
</div>
  <br>
  <table class="treatment-table" border="0" id="treatment-table">
  <th style="width:40px">No</th>
  <th style="width:105px">Image</th>
  <th style="width:230px">Name</th>
  <th>Date of Birth</th>
  <th style="width:140px">Location</th>
  <th style="width:40px">Phone</th>
  <th style="width:40px">Email</th>
  <th colspan="1" style="width: 50px;" > </th>
<?php 
include 'Connection.php';
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
            $imageSrc = 'media/profile.png';
          }
          if (file_exists('adopter_images/' . $image)) {
              $imageSrc = 'adopter_images/' . $image;
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
    <td><a href="SideBar_View-User-Process.php?adopterID=<?php echo $adopterID ?>" onclick="return confirmDelete(event);"><button class="manage-button" style="background-color:#e62e00"><span class="material-symbols-outlined">delete</span></button></a></td>
  </tr>      
<?php $i++;}

}else{?>
  <tr>
    <td colspan="6">No User yet...</td>
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
  table = document.getElementById("treatment-table");
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
     

</script>

</body>
</html>