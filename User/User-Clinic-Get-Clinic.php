<?php
include('../Database/Connection.php');

$searchQuery = $_GET['searchQuery'];
$area[] = $_GET['area'];

if($searchQuery!=='' || $area[0]!=='' ){
    if($searchQuery!=='' &&  strlen($area[0])>1 ){
        $areas = (explode(',',$area[0]));
        $areaCondition = '';
        if(count($areas)>1){
        for ($i=0; $i <count($areas) ; $i++) { 
            if ($i==0) {
                $areaCondition .= "(state= '$areas[$i]' OR ";
            }
            elseif ($i==count($areas) -1) {
                $areaCondition .= "state= '$areas[$i]')";
            }
            else{
            $areaCondition .= "state = '$areas[$i]' OR ";
            }
        }
    }
    elseif(count($areas)==1){
        $areaCondition .= "state = '$areas[0]' ";
    }
            $sql = "SELECT DISTINCT c.clinic_image,c.name,c.state,c.area,c.discount_percent,c.clinicID FROM clinic c,vet v WHERE c.clinicID=v.clinicID AND v.ic REGEXP '^[0-9]+$' AND c.name LIKE '%$searchQuery%' AND $areaCondition ORDER BY c.name; ";

    }
//
    elseif($searchQuery=='' &&  strlen($area[0])>1 ){
        $areas = (explode(',',$area[0]));
        $areaCondition = '';
        $areaCondition2 = '';
        if(count($areas)>1){
        for ($i=0; $i <count($areas) ; $i++) { 
            if ($i==0) {
                $areaCondition .= "(state= '$areas[$i]' OR ";
            }
            elseif ($i==count($areas) -1) {
                $areaCondition .= "state= '$areas[$i]')";
            }
            else{
            $areaCondition .= "state = '$areas[$i]' OR ";
            }
        }
    }
    elseif(count($areas)==1){
        $areaCondition .= "state = '$areas[0]' ";
    }

          $sql = "SELECT DISTINCT c.clinic_image,c.name,c.state,c.area,c.discount_percent,c.clinicID FROM clinic c,vet v WHERE c.clinicID=v.clinicID AND v.ic REGEXP '^[0-9]+$' AND $areaCondition ORDER BY c.name; ";
    }

//
    elseif($searchQuery!=='' &&  $area[0]=='' ){

        $sql = "SELECT DISTINCT c.clinic_image,c.name,c.state,c.area,c.discount_percent,c.clinicID FROM clinic c,vet v WHERE c.clinicID=v.clinicID AND v.ic REGEXP '^[0-9]+$' AND c.name LIKE '%$searchQuery%' ORDER BY c.name; ";
        }


$result = $conn->query($sql);

if ($result->num_rows > 0) {
        echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
        echo $result->num_rows. " results was found";
        echo '</div>';
    while ($row = $result->fetch_assoc()) {
        $imageData = base64_encode($row['clinic_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if($row['clinic_image']==NULL){
                $imageSrc = '../media/clinic-default.png';
            }
            elseif (file_exists('../Clinic/clinic_images/' . $row['clinic_image'])) {
                $imageSrc = '../Clinic/clinic_images/' . $row['clinic_image'];
            }
            echo '<div class="card2" style="box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.2);">';
            echo '<img src="' . $imageSrc . '" alt="organization logo" style="width:100%;height: 154px;">';
            echo '<div class="breedName2">';
            echo '<p><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
            echo '</div>';
            echo '<div class="view-breed" style="padding:0 17px;margin-left:-16.9px">';
            echo '<a href="User-Clinic-Profile.php?cid=' . $row['clinicID'] . '" target="_self"><p>Learn More <span class="material-symbols-outlined" style="vertical-align:-5px">open_in_new</span></p></a>';
            echo '</div>';
            echo '</div>';
        }
    }
 else {
    echo "<div style='width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px'>No results found.</div>";
}
}
else{
   $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "SELECT count(*) as total from clinic c,vet v WHERE c.vetID=v.vetID AND v.ic REGEXP '^[0-9]+$'";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT DISTINCT c.clinic_image,c.name,c.state,c.area,c.discount_percent,c.clinicID FROM clinic c,vet v WHERE c.clinicID=v.clinicID AND v.ic REGEXP '^[0-9]+$' ORDER BY c.name LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
        echo $total_records. " results was found";
        echo '</div>';
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['clinic_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if($row['clinic_image']==NULL){
                $imageSrc = '../media/clinic-default.png';
            }
            elseif (file_exists('../Clinic/clinic_images/' . $row['clinic_image'])) {
                $imageSrc = '../Clinic/clinic_images/' . $row['clinic_image'];
            }
            echo '<div class="card2" style="box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.2);">';
            echo '<img src="' . $imageSrc . '" alt="organization logo" style="width:100%;height: 154px;">';
            echo '<div class="breedName2">';
            echo '<p><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
            echo '</div>';
            echo '<div class="view-breed" style="padding:0 17px;margin-left:-16.9px">';
            echo '<a href="User-Clinic-Profile.php?cid=' . $row['clinicID'] . '" target="_self"><p>Learn More <span class="material-symbols-outlined" style="vertical-align:-5px">open_in_new</span></p></a>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
            
        }
        else{
            echo '<a href="User-Clinic.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="User-Clinic.php?page=' . $i . '" class="page-active">' . $i . '</a>';
            } else {
                echo '<a href="User-Clinic.php?page=' . $i . '">' . $i . '</a>';
            }
    }
        if($page == $total_pages){
           
        }
        else{
            echo '<a href="User-Clinic.php?page=' . ($page+1) . '"> &gt;</a>';
         }
        echo '</div>';
    }
}
$conn->close();
?>

