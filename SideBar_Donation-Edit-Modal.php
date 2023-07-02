<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoyalPaws</title>
    <link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="stylesheet" type="text/css" href="AdminStyle.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="overflow-x:hidden">
    <?php include 'AdminHeader.php'; ?>
<?php 
include 'Connection.php';
$oID = $_GET['id'];
    $sql = "SELECT * FROM Organization WHERE oID=$oID;";
      $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $oID=$row["oID"];
          $oname= $row["oname"];
          $logo=$row["logo"];
          $url=$row["url"];
          $description=$row["description"];
          $category=$row["category"];
          $payment_type=$row["payment_type"];
          $payment_method=$row["payment_method"];
          $minimum=$row["minimum"];
          $categories = explode(",", $row["category"]);
          $methods = explode(",", $row["payment_method"]);
       }
       } 
$imageData = base64_encode($logo);
$imageSrc = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if (file_exists('organization_images/' . $logo)) {
    $imageSrc = 'organization_images/' .$logo;
}?>
<iframe name="hiddenFrame" class="hide" style="border: 0;display: none;"></iframe>
<form  action="SideBar_Donation-Edit-Organization.php" target="hiddenFrame" method="post" enctype="multipart/form-data">
 <section style="width: 100%;">
<img src="media/ttg.jpeg"  style="width: 100%;height: 500px;">
<div style="margin-left: 50px;width: 60%;">

<input type="hidden" id="oID" name="oID" value="<?php echo "$oID" ?>">
        <img class="organization-image" src="<?php echo $imageSrc ?>">

        <div class="p-image" style="margin-top: 30px;">
        <i class="far fa-edit upload-button" style="font-size: 25px;">Edit Image</i>
        <input class="file-upload" name="img" type="file" accept="image/*"/>
        </div>

</div>
    <table border="0" width="59%" style="margin-top:-195px;margin-left: 380px;">
        <tr>
            <td style="width:25%">
    <label style="font-size: 35px;color: white;">Organization</label></td>
    <td style="font-size: 35px;color: white;">:</td>
    <td colspan="2" >
        <input style="width: 94.5%;vertical-align: -30px;" type="text" placeholder="Name..."  name="name" value="<?php echo"$oname" ?>"  required></td>
    </tr>
    <tr>
        <td>
    <label style="font-size: 35px;">Category</label></td>
    <td style="font-size: 35px;">:</td>
    <td>
        <label class="check-container" style="width:75%;padding:13px 0 13px 50px;height: 27px; <?php if(in_array("Conservation Efforts", $categories)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;"; } ?>">Conservation Efforts
            <input type="checkbox" name="category[]" onchange="changeColor(this)" value="Conservation Efforts" <?php if(in_array("Conservation Efforts", $categories)){ echo "checked";} ?>>
            <span class="checkmark2"></span>
        </label>
    </td>

    <td>
        <label class="check-container" style="width:79%;padding:13px 0 13px 50px;height: 27px; <?php if(in_array("Animal Rescue and Adoption", $categories)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;"; } ?>">Animal Rescue and Adoption
            <input type="checkbox" name="category[]" onchange="changeColor(this)" value="Animal Rescue and Adoption" <?php if(in_array("Animal Rescue and Adoption", $categories)){ echo "checked";} ?>>
            <span class="checkmark2"></span>
        </label>
    </td>
</tr>
<tr>
<td>
      <label style="font-size: 35px;">Website URL</label></td>
      <td style="font-size: 35px;">:</td>
      <td colspan="2" >
        <input type="url" placeholder="URL..." name="url" value="<?php echo"$url" ?>" required style="width: 94.5%;vertical-align: -30px;">
        </td>
    </tr>
    </table>


</section>
<br>
<br><br><br><br>
<label style="font-size: 35px;margin-left: 30px;">Description:</label>
<section class="s3">

    <textarea maxlength="1500" placeholder="Write something to describe the organization...(max 1500 characters)" name="description" required style="height:329px;"><?php echo"$description" ?></textarea>

</section>
<br><br>
<section class="s2" >
    <p class="organization-payment" style="font-weight: 600;">Payment Detail: </p>
    <br>
    <table border="0" style="width: 70%;">
        <tr>
            <td width="35%"><p class="organization-payment" >Payment Type</p></td>
            <td><p style="font-size: 40px;">:</p></td>
            <td colspan="3" ><select name="type" required style="width:91.4%;vertical-align: -13px;">
              <option value="<?php echo"$payment_type" ?>"  selected><?php echo"$payment_type" ?></option>
              <option>One-Time Payment</option>
              <option>Monthly Payment</option>
              <option>Monthly Payment & One-Time Payment</option>
          </select></td>
        </tr>
        <tr valign="middle;">
            <td rowspan="2"><p class="organization-payment" >Payment Methods</p></td>
            <td rowspan="2"><p style="font-size: 40px;">:</p></td>

            <td>

        <label class='check-container' style="width:90px; <?php if(in_array("Card", $methods)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>"><img src='media/card.png' width='50px;' height='40px;'>
            <input type='checkbox' name='method[]' onchange='changeColor(this)' value='Card' <?php if(in_array("Card", $methods)){ echo "checked";} ?>>
            <span class='checkmark2'></span>
        </label></td>
        <td>
        <label class='check-container' style="width:90px; <?php if(in_array("Bank", $methods)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>"><img src='media/bank.png' width='50px;' height='40px;'>
            <input type='checkbox' name='method[]' onchange='changeColor(this)' value='Bank' <?php if(in_array("Bank", $methods)){ echo "checked";} ?>>
            <span class='checkmark2'></span>
        </label></td>
        <td>
         <label class='check-container' style="width:90px; <?php if(in_array("Paypal", $methods)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>"><img src='media/paypal.png' width='50px;' height='40px;'>
            <input type='checkbox' name='method[]' onchange='changeColor(this)' value='Paypal' <?php if(in_array("Paypal", $methods)){ echo "checked";} ?>>
            <span class='checkmark2'></span>
        </label></td>
        </tr>
        <tr>
            <td>
         <label class='check-container' style="width:90px; <?php if(in_array("ApplePay", $methods)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>"><img src='media/applepay.png' width='60px;' height='27px;' style='margin-top:8px;'>
            <input type='checkbox' name='method[]' onchange='changeColor(this)' value='ApplePay' <?php if(in_array("ApplePay", $methods)){ echo "checked";} ?>>
            <span class='checkmark2'></span>
        </label></td>
        <td>
  <label class='check-container' style="width:90px; <?php if(in_array("GooglePay", $methods)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>"><img src='media/googlepay.png' width='60px;' height='60px;' style='margin-top:-8px;'>
            <input type='checkbox' name='method[]' onchange='changeColor(this)' value='GooglePay' <?php if(in_array("GooglePay", $methods)){ echo "checked";} ?>>
            <span class='checkmark2'></span>
        </label></td>
        <td>
 <label class='check-container' style="width:90px; <?php if(in_array("Others", $methods)){ echo "background-color:#cfe8fc;border: 1px solid #6fb9f6;";}?>"><img src='media/others.png' width='80px;' height='80px;' style='margin-top:-20px;margin-left: -10px;'>
            <input type='checkbox' name='method[]' onchange='changeColor(this)' value='Others' <?php if(in_array("Others", $methods)){ echo "checked";} ?>>
            <span class='checkmark2'></span>
        </label></td>
        </tr>
        <tr >
            <td><p class="organization-payment" >Minimum Donation</p></td>
            <td><p style="font-size: 40px;">:</p></td>
            <td colspan="3"><p style="display:inline-block;font-size: 30px;vertical-align: -30px;">RM &nbsp;</p><input type="number" id="minimum" name="minimum" min="0" required style="width:77.2%;vertical-align: -25px;" value="<?php echo"$minimum" ?>"></td>
        </tr>
    </table>    
</section>
<footer ><button class="save-change" type="submit">SAVE CHANGE</button></footer>
</form>

<script>
function changeColor(checkbox) {
  var checkbox = document.getElementsByName(checkbox.name);
  for (var i = 0; i < checkbox.length; i++) {
    var checkboxLabel = checkbox[i].parentNode;
    if (checkbox[i].checked) {
      checkboxLabel.style.backgroundColor = "#cfe8fc";
      checkboxLabel.style.borderColor = "#6fb9f6";
    } else {
      checkboxLabel.style.backgroundColor = "white";
     checkboxLabel.style.borderColor = "#b3b3b3";
    }
  }
}

$(document).ready(function() {

    
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.organization-image').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    

    $(".file-upload").on('change', function(){
        readURL(this);
    });
    
    $(".upload-button").on('click', function() {
       $(".file-upload").click();
    });
});
</script>
</body>

</html>
