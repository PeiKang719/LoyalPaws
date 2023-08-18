<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LoyalPaws</title>
	<link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="UserStyle.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style type="text/css">
	html,body{
		height: 100%;
	}
</style>
<body>
	<?php include 'UserHeader.php';
          include 'Connection.php';  ?>

<?php
$petID = $_GET['id'];

     $sql = "SELECT * from seller where sellerID=(Select sellerID from pet where petID='$petID') ";
     $sql3 = "SELECT * from pet_shop where shopID=(Select shopID from pet where petID='$petID') ";
     $sql2 = "SELECT * from pet where petID='$petID' ";

    $result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    // Fetch all the rows into an array
    $rows2 = $result2->fetch_all(MYSQLI_ASSOC);
    foreach ($rows2 as $row2) {
      $pid=$row2['petID'];
      $price=$row2['price'];
      $img=$row2['pet_image'];
    }
}

if($row2['sellerID']!==NULL){
    $result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $id=$row['sellerID'];
      $available=$row['available'];
      $start=$row['start'];
      $end=$row['end'];
    }
    $type='seller';
}
}
elseif($row2['shopID']!==NULL){
    $result = $conn->query($sql3);
if ($result->num_rows > 0) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
      $id=$row['shopID'];
      $available=$row['work_day'];
      $start=$row['open_time'];
      $end=$row['close_time'];
    }
    $type='shop';
}
}
$imageData = base64_encode($img);
$imageSrc = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if (file_exists('pet_images/' . $img)) {
    $imageSrc = 'pet_images/' . $img;
}
else{
    $imageSrc = 'media/tabIcon (2).png' ;
}
?>

<div class="booking-container">
    <p class="booking-header">Book This Pet Now</p>
    <div class="booking-icon"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></div>
    <ul>
      <li class="booking-intro" style="list-style: none;">100% Refundable Booking Fee. Book to:</li>
      <li class="booking-intro">Secure this pet just for you</li>
      <li class="booking-intro">Have a visit to the pet to ensure compatibility</li>
    </ul>
    <br><br>
    <p class="booking-header" style="font-size: 30px;">Booking Fee: RM <?php echo $price * 0.10 ?> </p>
    <input type="hidden" name="price" id="price" value="<?php echo $price * 0.10 ?>">
    <p>*10% of pet's price*</p>
    <br><br><br><hr style="border:2px solid #d9d9d9"><br>
    <p class="booking-header">Schedule a visit</p>
    <div class="appointment-container">
        <div class="choose-date-container">
            <input type="date" id="dateInput" name="date" style="border:2px solid #4d4d4d;">
            <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
            <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
            <div class="time-slot" id="time-slot" >
               <p style="font-size:30px;"><span class="material-symbols-outlined" style="font-size:35px;vertical-align:-7px">today</span> Please select a date.</p> 
            </div>
        </div>

        <div class="available-time-border">
        <table >
            <tr>
        <?php       $days = explode(",", $available);
                    $opens = explode(",", $start);
                    $closes = explode(",", $end);
                    $date = array("Sunday", "Monday", "Tuesday","Wednesday","Thursday","Friday","Saturday");
                     $count = count($days);?>
                <td colspan="4"><p class="available-time" style="font-size: 30px;font-weight: bold;color: black;padding-bottom: 10px;">Available Time:</p></td>
            </tr>
            <tr>
                <?php
                $i=0;
                for($j = 0; $j < count($date); $j++) {
                    
                            if(in_array($date[$j], $days) && $j==0){
                        echo "<td ><p class='available-time'> Sunday </p></td>";
                        echo "<td align=center><p class='available-time'> $opens[$i] </p></td>";
                        echo "<td align=center><p class='available-time' > - </p></td>";
                        echo "<td align=center><p class='available-time' > $closes[$i] </p></td></tr>";
                        $i++;
                        }
                            elseif(!in_array($date[$j], $days) && $j==0){
                        echo "<td ><p class='available-time' style='padding:10px 0px'> Sunday </p></td>";
                        echo "<td colspan=3 align=center><p class='available-time' style='padding:10px 0px'>Closed </p></td></tr>";
                        }
                            elseif(in_array($date[$j], $days) && $j>0){
                        echo "<tr>";
                        echo "<td ><p class='available-time'> $date[$j] </p></td>";
                        echo "<td align=center><p class='available-time'> $opens[$i] </p></td>";
                        echo "<td align=center><p class='available-time' > - </p></td>";
                        echo "<td align=center><p class='available-time' > $closes[$i] </p></td></tr>";
                        $i++;
                        }
                            else{
                        echo "<tr>";
                        echo "<td ><p class='available-time' > $date[$j] </p></td>";
                        echo "<td colspan=3 align=center><p class='available-time'>Closed </p></td></tr>";
                        }
                    }
                
                        ?>
        
        </table>
        </div>  
    </div>
    <hr style="border:2px solid #d9d9d9">
    <div class="proceed-payment-container">
    <button class="proceed-payment" id="proceed-payment" onclick="purchase(<?php echo $price * 0.10 ?>)">Proceed To Payment</button>
</div>
  
</div>


<!--Confirm Payment Modal-->
<div id="ConfirmModal" class="modal" style="padding-top:10px">
  <!-- Modal content -->
  <div class="modal-content" style="width:50%;height:auto">
    <div class="modal-header">
      <h2>Confirm Booking</h2>
      <span class="close">&times;</span>
      </div>
      <img class="booking-pet-img" src="<?php echo $imageSrc ?>" alt='Pet Image'>

      <input type="hidden" name="sid" id="sid" value="<?php echo $id ?>">
      <input type="hidden" name="pid" id="pid" value="<?php echo $pid ?>">

      <input type="hidden" name="aid" id="aid" value="<?php echo $adopterID ?>">

      <div class="confirm-booking-container" id="confirm-booking-container">
      <!--------------User-Adoption-Booking-Modal.php------------------>
  </div>
  <div class="booking-choice-container">
      <div id="paypal-payment-button" style="width: 80%;margin-left: 20px;"></div>
    <script src="https://www.paypal.com/sdk/js?client-id=AVKhPyIREMp1EynqC_9932cWY2SPi_zMNmnSPlP9hyorwbiOogLrslLKz9bDhXs6vGQr9LYbD38_zapW&currency=MYR"></script>
  </div>
</form>
</div>
</div>


<script type="text/javascript">
    
var returnedDate = ''; // Declare as global variable
var returnedTime = '';
  $(document).ready(function() {

    // Listen for changes to the checkboxes
    $('input[type="date"]').change(function() {
        // Get the values of the checked checkboxes
       
        var date = $('#dateInput').val();
        var id = $('#id').val();
        var type = $('#type').val();

        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'User-Adoption-Get-Time-Slot.php',
            type: 'GET',
            data: { date: date , id: id , type: type},
            success: function(response) {
                // Update the breed cards with the new HTML
                $('#time-slot').html(response);
                
            },
            error: function() {
                alert('No available time.Please choose another date.');
            }
        });
    });

    $('#proceed-payment').click(function() {
        var time = $('input[name="radio"]:checked').val();
        var date = $('#dateInput').val();
        var price = $('#price').val();

        if (!time || !date ) {
            alert('Please fill out all fields.');
            return; // Exit the function if any data is null
        }
        // Make an AJAX request to the server to get the updated breed cards
        $.ajax({
            url: 'User-Adoption-Booking-Modal.php',
            type: 'GET',
            data: {time:time, date:date, price:price },
            success: function(response) {
                // Update the breed cards with the new HTML
                $('#ConfirmModal').css('display', 'block');
                $('#confirm-booking-container').html(response);
                 returnedDate = $('#date').val();
                 returnedTime = $('#time').val();
            },
            error: function() {
                alert('Error getting booking details.Please make sure all information have been filled.');
            }
        });
    });
});

function purchase() {
    event.preventDefault(); // Prevents anchor tag from triggering its default behavior

     if (!confirm('Are you sure you want to make this booking? \n\nPlease note that if you cancel the order, you will receive a refund of the booking fee.')) {
    return; // Abort if the user cancels the confirmation
  }

     var modal= document.getElementById("ConfirmModal");
      var span = modal.getElementsByClassName("close")[0];
      

    // When the user clicks the button, open the modal 


    span.onclick = function() {
      modal.style.display = "none";
    }
}
    var sid= document.getElementById("sid").value;
     var pid= document.getElementById("pid").value;
     var aid = document.getElementById("aid").value;
var booking_fee=document.getElementById("price").value;
paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [
          {
            amount: {
              currency_code: 'MYR',
              value: booking_fee
            },
            billing_address: null
          }
        ],
        application_context: {
          shipping_preference: 'NO_SHIPPING'
        }
      });
    },
    onClick: function() {
      return { commit: false };
    },
    onApprove: function(data, actions) {
  return actions.order.capture().then(function(details) {
    // Extract the payment method and transaction ID from the PayPal response
    var transactionId = details.id;

    // Construct the URL with the query parameters
    var url = "User-Adoption-Book-Process.php?c=purchase&aid="+aid+"&date="+returnedDate+"&time="+returnedTime+"&sid=" + sid + "&pid=" + pid +"&transactionId=" + encodeURIComponent(transactionId);

    // Redirect to the URL
    window.location.href = url;
  });
}

  }).render('#paypal-payment-button');
</script>
</body>
</html>