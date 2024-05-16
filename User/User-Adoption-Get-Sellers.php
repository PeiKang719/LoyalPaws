<?php
include('../Database/Connection.php');

$searchQuery = $_GET['searchQuery'];
$area[] = $_GET['area'];
$type[] = $_GET['type'];

if($searchQuery!=='' || $area[0]!=='' || $type[0]!==''){
    if($searchQuery!=='' &&  strlen($area[0])>1 && strlen($type[0])<10 && strlen($type[0])>1 ){
        $areas = (explode(',',$area[0]));
        $areaCondition = '';
        if(count($areas)>1){
        for ($i=0; $i <count($areas) ; $i++) { 
            if ($i==0) {
                $areaCondition .= "(s.state= '$areas[$i]' OR ";
            }
            elseif ($i==count($areas) -1) {
                $areaCondition .= "s.state= '$areas[$i]')";
            }
            else{
            $areaCondition .= "s.state = '$areas[$i]' OR ";
            }
        }
    }
    elseif(count($areas)==1){
        $areaCondition .= "s.state = '$areas[0]' ";
    }

        if ($type[0]=='seller') {
            $sql = "SELECT s.sellerID,CONCAT(s.firstName, ' ' ,s.lastName) AS `name`,s.image,s.state,s.area,count(p.petID) as number from seller s LEFT JOIN pet p ON p.sellerID=s.sellerID WHERE CONCAT(s.firstName, ' ' ,s.lastName) LIKE '%$searchQuery%' AND $areaCondition GROUP BY s.sellerID, `name`, s.image, s.state, s.area DESC; ";
        }
        else{
            $sql = "SELECT s.shopID, s.shopname AS `name`,s.shop_image AS `image`,s.state,s.area,count(p.petID) as number from pet_shop s LEFT JOIN pet p ON p.shopID=s.shopID WHERE s.shopname LIKE '%$searchQuery%' AND $areaCondition GROUP BY s.shopID, `name`, `image`, s.state, s.area DESC; ";
        }
    }
//
    elseif($searchQuery!=='' &&  strlen($area[0])>1  && $type[0]=='' ){
        $areas = (explode(',',$area[0]));
        $areaCondition = '';
        $areaCondition2 = '';
        if(count($areas)>1){
        for ($i=0; $i <count($areas) ; $i++) { 
            if ($i==0) {
                $areaCondition .= "(s.state= '$areas[$i]' OR ";
                $areaCondition2 .= "(h.state= '$areas[$i]' OR ";
            }
            elseif ($i==count($areas) -1) {
                $areaCondition .= "s.state= '$areas[$i]')";
                $areaCondition2 .= "h.state= '$areas[$i]')";
            }
            else{
            $areaCondition .= "s.state = '$areas[$i]' OR ";
            $areaCondition2 .= "h.state = '$areas[$i]' OR ";
            }
        }
    }
    elseif(count($areas)==1){
        $areaCondition .= "s.state = '$areas[0]' ";
        $areaCondition2 .= "h.state = '$areas[0]' ";
    }

         $sql="SELECT * from (SELECT h.shopID,h.shopname as name,h.shop_image as image,h.state,h.area,null as sellerID,count(t.petID) as number FROM pet_shop h LEFT JOIN pet t ON h.shopID = t.shopID WHERE h.shopname LIKE '%$searchQuery%' AND $areaCondition2 GROUP BY h.shopID, name, image, state, area, sellerID UNION ALL SELECT null as shopID,CONCAT(s.firstName, ' ' ,s.lastName) AS name,s.image,s.state,s.area,s.sellerID,count(p.petID) as number from seller s LEFT JOIN pet p ON p.sellerID=s.sellerID WHERE CONCAT(s.firstName, ' ' ,s.lastName) LIKE '%$searchQuery%' AND $areaCondition GROUP BY shopID,name,image,state,area,sellerID) as combined_table order by name;";
    }

//
    elseif($searchQuery!=='' &&  $area[0]=='' && strlen($type[0])<10 && strlen($type[0])>1 ){
        if ($type[0]=='seller') {
        $sql = "SELECT s.sellerID,CONCAT(s.firstName, ' ' ,s.lastName) AS `name`,s.image,s.state,s.area,count(p.petID) as number from seller s LEFT JOIN pet p ON p.sellerID=s.sellerID WHERE CONCAT(s.firstName, ' ' ,s.lastName) LIKE '%$searchQuery%' GROUP BY s.sellerID, `name`, s.image, s.state, s.area ORDER BY `name`; ";
        }
        else{
        $sql = "SELECT s.shopID, s.shopname AS `name`,s.shop_image AS `image`,s.state,s.area,count(p.petID) as number from pet_shop s LEFT JOIN pet p ON p.shopID=s.shopID WHERE s.shopname LIKE '%$searchQuery%' GROUP BY s.shopID, `name`, `image`, s.state, s.area ORDER BY s.shopname; ";
        }
    }

//
    elseif($searchQuery=='' &&  $area[0]=='' && strlen($type[0])<10 && strlen($type[0])>1 ){
        if ($type[0]=='seller') {
        $sql = "SELECT s.sellerID,CONCAT(s.firstName, ' ' ,s.lastName) AS `name`,s.image,s.state,s.area,count(p.petID) as number from seller s LEFT JOIN pet p ON p.sellerID=s.sellerID GROUP BY s.sellerID, `name`, s.image, s.state, s.area ORDER BY `name`; ";
        }
        else{
        $sql = "SELECT s.shopID, s.shopname AS `name`,s.shop_image AS `image`,s.state,s.area,count(p.petID) as number from pet_shop s LEFT JOIN pet p ON p.shopID=s.shopID GROUP BY s.shopID, `name`, `image`, s.state, s.area ORDER BY s.shopname; ";
        }
    }
//
    elseif($searchQuery=='' &&  strlen($area[0])>1 && strlen($type[0])<10 && strlen($type[0])>1 ){
        $areas = (explode(',',$area[0]));
        $areaCondition = '';
        for ($i=0; $i <count($areas) ; $i++) { 
            if ($i==count($areas) -1) {
                $areaCondition .= "s.state= '$areas[$i]'";
            }
            else{
            $areaCondition .= "s.state = '$areas[$i]' OR ";
            }
        }

        if ($type[0]=='seller') {
        $sql = "SELECT s.sellerID,CONCAT(s.firstName, ' ' ,s.lastName) AS `name`,s.image,s.state,s.area,count(p.petID) as number from seller s LEFT JOIN pet p ON p.sellerID=s.sellerID WHERE $areaCondition GROUP BY s.sellerID, `name`, s.image, s.state, s.area ORDER BY `name`; ";
        }
        else{
        $sql = "SELECT s.shopID, s.shopname AS `name`,s.shop_image AS `image`,s.state,s.area,count(p.petID) as number from pet_shop s LEFT JOIN pet p ON p.shopID=s.shopID WHERE $areaCondition GROUP BY s.shopID, `name`, `image`, s.state, s.area ORDER BY s.shopname; ";
        }
    }

//
    elseif(strlen($area[0])>1 && $searchQuery=='' && $type[0]==''){
        $areas = (explode(',',$area[0]));
        $areaCondition = '';
        $areaCondition2 = '';
        for ($i=0; $i <count($areas) ; $i++) { 
            if ($i==count($areas) -1) {
                $areaCondition .= "s.state= '$areas[$i]'";
                $areaCondition2 .= "h.state= '$areas[$i]'";
            }
            else{
            $areaCondition .= "s.state = '$areas[$i]' OR ";
            $areaCondition2 .= "h.state = '$areas[$i]' OR ";
            }
        }

        $sql="SELECT * from (SELECT h.shopID,h.shopname as name,h.shop_image as image,h.state,h.area,null as sellerID,count(t.petID) as number FROM pet_shop h LEFT JOIN pet t ON h.shopID = t.shopID WHERE $areaCondition2 GROUP BY h.shopID, name, image, state, area, sellerID UNION ALL SELECT null as shopID,CONCAT(s.firstName, ' ' ,s.lastName) AS name,s.image,s.state,s.area,s.sellerID,count(p.petID) as number from seller s LEFT JOIN pet p ON p.sellerID=s.sellerID WHERE $areaCondition GROUP BY shopID,name,image,state,area,sellerID) as combined_table order by name;";
    }
//
    elseif(strlen($type[0])>10){
         $sql = "SELECT s.sellerID,CONCAT(s.firstName, ' ' ,s.lastName) AS `name`,s.image,s.state,s.area,count(p.petID) as number from seller s LEFT JOIN pet p ON p.sellerID=s.sellerID WHERE  s.state='abcdef' GROUP BY s.sellerID, `name`, s.image, s.state, s.area DESC; ";
    }

//
    elseif($searchQuery!=='' && $area[0]=='' && $type[0]==''){
     $sql = "SELECT * from (SELECT h.shopID,h.shopname as name,h.shop_image as image,h.state,h.area,null as sellerID,count(t.petID) as number FROM pet_shop h LEFT JOIN pet t ON h.shopID = t.shopID WHERE h.shopname LIKE '%$searchQuery%' GROUP BY h.shopID, name, image, state, area, sellerID UNION ALL SELECT null as shopID,CONCAT(s.firstName, ' ' ,s.lastName) AS name,s.image,s.state,s.area,s.sellerID,count(p.petID) as number from seller s LEFT JOIN pet p ON p.sellerID=s.sellerID WHERE CONCAT(s.firstName, ' ' ,s.lastName) LIKE '%$searchQuery%' GROUP BY shopID,name,image,state,area,sellerID) as combined_table order by name; ";

    }

$result = $conn->query($sql);

if ($result->num_rows > 0) {
        echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
        echo $result->num_rows. " results was found";
        echo '</div>';
    while ($row = $result->fetch_assoc()) {
        $imageData = base64_encode($row['image']);
        $imageSrc = "data:image/jpg;base64," . $imageData;
        if($row['image']==NULL){
                $imageSrc = '../media/shop-image.jpg';
            }
        else if (file_exists('../Seller/pet_shop_images/' . $row['image'])) {
                $imageSrc = '../Seller/pet_shop_images/' . $row['image'];
            }
        elseif(file_exists('../Seller/seller_images/' . $row['image'])) {
            $imageSrc = '../Seller/seller_images/' . $row['image'];
        }
            if(isset($row['shopID'])){
            echo '<a href="Seller-Profile.php?s=pet&&sid=' . $row['shopID'] . '" target="_self" style="margin:2%"><div class="card2">';
            }
            if(isset($row['sellerID'])){
            echo '<a href="Seller-Profile.php?s=pet&&iid=' . $row['sellerID'] . '" target="_self" style="margin:2%"><div class="card2">';
            }
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if(isset($row['shopID'])){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:red;font-weight: 800;">storefront</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            else if(isset($row['sellerID'])){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -6px; color: #33cc00; font-weight: 800;">person</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-4px;color:#c68c53">pets</span> '. $row['number'] . ' pets</p>';
            echo '</div>';
            echo '<div class="view-breed3">';
            echo '<p>View </p>';
            echo '</div>';
            echo '</div></a>';
        }
    }
 else {
    echo "No results found.";

}
}
else{
   $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "select count(*) as total from(SELECT shopID,null as sellerID from pet_shop union all select null as shopID,sellerID from seller) as combined_table;";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT * from (SELECT h.shopID,h.shopname as name,h.shop_image as image,h.state,h.area,null as sellerID,count(t.petID) as number FROM pet_shop h LEFT JOIN pet t ON h.shopID = t.shopID GROUP BY h.shopID, name, image, state, area, sellerID UNION ALL SELECT null as shopID,CONCAT(s.firstName, ' ' ,s.lastName) AS name,s.image,s.state,s.area,s.sellerID,count(p.petID) as number from seller s LEFT JOIN pet p ON p.sellerID=s.sellerID GROUP BY shopID,name,image,state,area,sellerID) as combined_table order by name LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<div style="width:100%;height:20px;margin-top:5px;font-size:20px;margin-left:10px">';
        echo $total_records. " sellers";
        echo '</div>';
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if($row['image']==NULL){
                $imageSrc = '../media/shop-image.jpg';
            }
            else if (file_exists('../Seller/pet_shop_images/' . $row['image'])) {
                $imageSrc = '../Seller/pet_shop_images/' . $row['image'];
            }
            elseif(file_exists('../Seller/seller_images/' . $row['image'])) {
                $imageSrc = '../Seller/seller_images/' . $row['image'];
            }
            if($row['shopID']!==NULL){
            echo '<a href="Seller-Profile.php?s=pet&&sid=' . $row['shopID'] . '" target="_self" style="margin:2%"><div class="card2">';
            }
            else if($row['sellerID']!==NULL){
            echo '<a href="Seller-Profile.php?s=pet&&iid=' . $row['sellerID'] . '" target="_self" style="margin:2%"><div class="card2">';
            }
            echo '<img src="' . $imageSrc . '" alt="Pet Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName3">';
            if($row['shopID']!==NULL){
            echo '<p><span class="material-symbols-outlined" style="font-size:30px;vertical-align:-5px;color:red;font-weight: 800;">storefront</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            else if($row['sellerID']!==NULL){
            echo '<p><span class="material-symbols-outlined" style="font-size: 30px; vertical-align: -6px; color: #33cc00; font-weight: 800;">person</span><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            }
            echo '<div class="card-location">';
            echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-7px">distance</span>' . $row['state'] .'<span style="font-size: 15px;color:#4d4d4d;margin-left: 1%;margin-right: 1%">&#9679;</span>'. $row['area'] . '</p>';
             echo '<p><span class="material-symbols-outlined" style="font-size:25px;vertical-align:-4px;color:#c68c53">pets</span> '. $row['number'] . ' pets</p>';
            echo '</div>';
            echo '<div class="view-breed3">';
            echo '<p>View </p>';
            echo '</div>';
            echo '</div></a>';
        }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
            
        }
        else{
            echo '<a href="User-Adoption-Sellers.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="User-Adoption-Sellers.php?page=' . $i . '" class="page-active">' . $i . '</a>';
            } else {
                echo '<a href="User-Adoption-Sellers.php?page=' . $i . '">' . $i . '</a>';
            }
    }
        if($page == $total_pages){
           
        }
        else{
            echo '<a href="User-Adoption-Sellers.php?page=' . ($page+1) . '"> &gt;</a>';
         }
        echo '</div>';
    }
}
$conn->close();
?>

