<?php
include('../Database/Connection.php');

 if ($_GET['sid']!=NULL) {
            $id=$_GET['sid'];
            $table='pet_shop';
            $pk='shopID';
        }
        elseif($_GET['iid']!=NULL){
            $id=$_GET['iid'];
            $table='seller';
            $pk='sellerID';
        }
        
$searchQuery = $_GET['searchQuery'];
$type[] = $_GET['type'];
$size[] = $_GET['size'];
$purpose[] = $_GET['purpose'];

if($searchQuery!=='' || $size[0]!=='' || $type[0]!=='' || $purpose[0]!==''){
    if($searchQuery!=='' && strlen($size[0])<10 && strlen($size[0])>1 && strlen($type[0])<6 && strlen($type[0])>1 && strlen($purpose[0])<11 && strlen($purpose[0])>1){
        $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.name LIKE '%$searchQuery%' AND b.size=$size[0] AND b.type=$type[0] AND p.purpose=$purpose[0] AND p.$pk='$id'  AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif($searchQuery!=='' && strlen($size[0])<10 && strlen($size[0])>1 && strlen($type[0])<6 && strlen($type[0])>1 && strlen($purpose[0])==0){
        $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.name LIKE '%$searchQuery%' AND b.size=$size[0] AND b.type=$type[0] AND p.$pk='$id'  AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif($searchQuery!=='' && strlen($size[0])<10 && strlen($size[0])>1 && strlen($purpose[0])<11 && strlen($purpose[0])>1 &&strlen($type[0])==0){
        $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.name LIKE '%$searchQuery%' AND b.size=$size[0] AND p.purpose=$purpose[0] AND p.$pk='$id'  AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif($searchQuery!=='' && strlen($type[0])<6 && strlen($type[0])>1 && strlen($purpose[0])<11 && strlen($purpose[0])>1 && strlen($size[0])==0){
        $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.name LIKE '%$searchQuery%' AND b.type=$type[0] AND p.purpose=$purpose[0] AND p.$pk='$id'  AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif(strlen($type[0])<6 && strlen($type[0])>1 && strlen($size[0])<10 && strlen($size[0])>1 && strlen($purpose[0])<11 && strlen($purpose[0])>1 &&$searchQuery==''){
        $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.size=$size[0] AND b.type=$type[0] AND p.purpose=$purpose[0] AND p.$pk='$id'  AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif($searchQuery!=='' && strlen($size[0])<10 && strlen($size[0])>1 && strlen($type[0])==0 && strlen($purpose[0])==0){
    $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.name LIKE '%$searchQuery%' AND b.size=$size[0] AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif($searchQuery!=='' && strlen($type[0])<6 && strlen($type[0])>1 && strlen($size[0])==0 && strlen($purpose[0])==0){
    $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.name LIKE '%$searchQuery%' AND b.type=$type[0] AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif($searchQuery!=='' && strlen($purpose[0])<11 && strlen($purpose[0])>1 && strlen($size[0])==0 && strlen($type[0])==0){
    $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.name LIKE '%$searchQuery%' AND p.purpose=$purpose[0] AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif(strlen($type[0])<6 && strlen($type[0])>1 && strlen($size[0])<10 && strlen($size[0])>1  && strlen($purpose[0])==0 && $searchQuery==''){
    $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.type=$type[0] AND b.size=$size[0] AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif(strlen($purpose[0])<11 && strlen($purpose[0])>1 && strlen($size[0])<10 && strlen($size[0])>1  && strlen($type[0])==0 && $searchQuery==''){
    $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE p.purpose=$purpose[0] AND b.size=$size[0] AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif(strlen($purpose[0])<11 && strlen($purpose[0])>1 && strlen($type[0])<6 && strlen($type[0])>1  && strlen($size[0])==0 && $searchQuery==''){
    $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE p.purpose=$purpose[0] AND b.type=$type[0] AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }

    elseif($searchQuery!=='' && strlen($type[0])==0 && strlen($size[0])==0 && strlen($purpose[0])==0){
        $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.name LIKE '%$searchQuery%' AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }

    elseif(strlen($type[0])<6 && strlen($type[0])>1 && strlen($size[0])==0 && $searchQuery=='' && strlen($purpose[0])==0){
        $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.type=$type[0] AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif(strlen($size[0])<10 && strlen($size[0])>1 && strlen($type[0])==0 && $searchQuery=='' && strlen($purpose[0])==0){
        $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.size=$size[0] AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif(strlen($purpose[0])<11 && strlen($purpose[0])>1 && strlen($type[0])==0 && $searchQuery=='' && strlen($size[0])==0){
        $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE p.purpose=$purpose[0] AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }

    elseif(strlen($size[0])>10){

        $sql="SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.size='abc' AND p.$pk='$id' AND BINARY (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }

    elseif(strlen($type[0])>6){
         $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE b.type='abc' AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }
    elseif(strlen($purpose[0])>11){
     $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE p.purpose='abc' AND p.$pk='$id' AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC";
    }

$result = $conn->query($sql);

if ($result->num_rows > 0) {
        echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
        echo $result->num_rows. " results was found";
        echo '</div>';
    while ($row = $result->fetch_assoc()) {
            if($row['status']=='Complete'  || $row['status']=='complete'){
                $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2" style="background-color:#d9d9d9">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3" style="background-color:#999999">';
            if($row['purpose']=='Rehome' || $row['purpose']=='Lodging'){
            echo '<p><b>Adopted</b></p>';
            }
            else{
            echo '<p><b>Sold</b></p>';  
            }
            echo '</div>';
            echo '</div></a>';
            }
            elseif($row['status']=='Payment' || $row['status']=='Decision' || $row['status']=='Booked' || $row['status']=='Appointment' || $row['status']=='Fail' || $row['status']=='Free'|| $row['status']=='appointment'|| $row['status']=='cancel'){
                $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2" style="background-color:#d9d9d9">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3" style="background-color:#999999">';
            echo '<p><b>Booked</b></p>';
            echo '</div>';
            echo '</div></a>';
            }
            else{
            $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3">';
            echo '<p>RM ' . $row['price'] . '</p>';
            echo '</div>';
            echo '</div></a>';
        }
    }
    }
 else {

    echo "<div style='width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px'>No results found.</div>";
}
}


else{
   $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "SELECT count(*) as total from pet where $pk='$id' AND availability='Y'";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT p.petID,p.pet_image,b.name,p.purpose,p.price,s.state,s.area,p.gender,p.availability,pp.status FROM pet p JOIN breed b ON p.breedID=b.breedID JOIN $table s ON p.$pk=s.$pk LEFT JOIN pet_payment pp ON pp.petID=p.petID WHERE p.$pk=$id AND (BINARY status <> 'Cancel' OR status IS NULL) AND availability='Y' ORDER BY
    CASE
        WHEN status IS NULL THEN 0
        WHEN status = 'Booked' THEN 1
        WHEN status = 'Appointment' THEN 2
        WHEN status = 'Decision' THEN 3
        WHEN status = 'Fail' THEN 4
        WHEN status = 'Payment' THEN 5
        WHEN status = 'Free' THEN 6
        WHEN status = 'cancel' THEN 7
        WHEN status = 'Complete' THEN 8
    END,
    petID DESC LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
     if ($result->num_rows > 0) {
        echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
        echo $total_records. " results was found";
        echo '</div>';
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            if($row['status']=='Complete'   || $row['status']=='complete'){
                $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2" style="background-color:#d9d9d9">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3" style="background-color:#999999">';
            if($row['purpose']=='Rehome' || $row['purpose']=='Lodging'){
            echo '<p><b>Adopted</b></p>';
            }
            else{
            echo '<p><b>Sold</b></p>';  
            }
            echo '</div>';
            echo '</div></a>';
            }
            elseif($row['status']=='Payment' || $row['status']=='Decision' || $row['status']=='Booked' || $row['status']=='Appointment' || $row['status']=='Free' || $row['status']=='Fail'|| $row['status']=='appointment'|| $row['status']=='cancel'){
                $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2" style="background-color:#d9d9d9">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3" style="background-color:#999999">';
            echo '<p><b>Booked</b></p>';
            echo '</div>';
            echo '</div></a>';
            }
            else{
            $imageData = base64_encode($row['pet_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('pet_images/' . $row['pet_image'])) {
                $imageSrc = 'pet_images/' . $row['pet_image'];
            }
            echo '<a href="Seller_Pets-Profile.php?id=' . $row['petID'] . '" target="_self" style="margin:2%"><div class="card2">';
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['gender']=='Male'){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:#1ab2ff;font-weight: 800;">male</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            else if($row['gender']=='Female'){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -5px; color: #ff99ff; font-weight: 800;">female</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">label</span>' .  $row['purpose'] .'</p>';
            echo '</div>';
            echo '<div class="view-breed3">';
            echo '<p>RM ' . $row['price'] . '</p>';
            echo '</div>';
            echo '</div></a>';
        }
    }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
            
        }
        else{
            echo '<a href="../Breed/Dog-breed.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="../Breed/Dog-breed.php?page=' . $i . '" class="page-active">' . $i . '</a>';
            } else {
                echo '<a href="../Breed/Dog-breed.php?page=' . $i . '">' . $i . '</a>';
            }
    }
        if($page == $total_pages){
           
        }
        else{
            echo '<a href="../Breed/Dog-breed.php?page=' . ($page+1) . '"> &gt;</a>';
         }
        echo '</div>';
    }else{
        echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
        echo $total_records. " pets";
        echo '</div>';
    }
}
$conn->close();
?>

