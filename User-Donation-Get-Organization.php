<?php
include('Connection.php');

$searchQuery = $_GET['searchQuery'];
$category[] = $_GET['category'];
$type[] = $_GET['type'];
$method[] = $_GET['method'];
$methods = explode(',', $method[0]);
$conditions = array();

if($searchQuery!=='' || $category[0]!=='' || $type[0]!=='' || $method[0]!==''){

    if($searchQuery!=='' && $category[0]!=='' && $type[0]!=='' && $method[0]!==''){
    foreach ($methods as $methodss) {
    $conditions[] = "FIND_IN_SET('$methodss', payment_method) > 0";
$sql = "SELECT * FROM organization WHERE oname LIKE '%$searchQuery%' AND category LIKE '%" . implode("','", $category) . "%' and payment_type LIKE '%" . implode("' , '", $type) . "%' and " . implode(" and ", $conditions) . " ORDER BY oname";}}

    else if($searchQuery!=='' &&  $category[0]!=='' && $type[0]!=='' && $method[0]==''){
$sql = "SELECT * FROM organization WHERE oname LIKE '%$searchQuery%' AND category LIKE '%" . implode("','", $category) . "%' and payment_type LIKE '%" . implode("' , '", $type) . "%' ORDER BY oname";}

    else if($searchQuery!=='' &&$category[0]!=='' && $method[0]!=='' && $type[0]==''){
    foreach ($methods as $methodss) {
    $conditions[] = "FIND_IN_SET('$methodss', payment_method) > 0";
$sql = "SELECT * FROM organization WHERE oname LIKE '%$searchQuery%' AND category LIKE '%" . implode("','", $category) . "%' and " . implode(" and ", $conditions) . " ORDER BY oname";}}

    else if($searchQuery!=='' && $type[0]!=='' && $method[0]!=='' &&$category[0]==''){
    foreach ($methods as $methodss) {
    $conditions[] = "FIND_IN_SET('$methodss', payment_method) > 0";
$sql = "SELECT * FROM organization WHERE oname LIKE '%$searchQuery%' AND payment_type LIKE '%" . implode("' , '", $type) . "%' and " . implode(" and ", $conditions) . " ORDER BY oname";}}

    else if($searchQuery=='' && $type[0]!=='' && $method[0]!=='' &&$category[0]!==''){
    foreach ($methods as $methodss) {
    $conditions[] = "FIND_IN_SET('$methodss', payment_method) > 0";
$sql = "SELECT * FROM organization WHERE payment_type LIKE '%" . implode("' , '", $type) . "%'AND category LIKE '%" . implode("','", $category) . "%' and " . implode(" and ", $conditions) . " ORDER BY oname";}}

     else if($searchQuery!=='' &&  $category[0]!=='' && $type[0]=='' && $method[0]==''){
$sql = "SELECT * FROM organization WHERE oname LIKE '%$searchQuery%' AND category LIKE '%" . implode("','", $category) . "%' ORDER BY oname";}

    else if($searchQuery!=='' &&  $category[0]=='' && $type[0]!=='' && $method[0]==''){
$sql = "SELECT * FROM organization WHERE oname LIKE '%$searchQuery%' AND payment_type LIKE '%" . implode("' , '", $type) . "%' ORDER BY oname";}

    else if($searchQuery!=='' && $type[0]=='' && $method[0]!=='' &&$category[0]==''){
    foreach ($methods as $methodss) {
    $conditions[] = "FIND_IN_SET('$methodss', payment_method) > 0";
$sql = "SELECT * FROM organization WHERE oname LIKE '%$searchQuery%' AND " . implode(" and ", $conditions) . " ORDER BY oname";}}

    
    else if($searchQuery=='' &&  $category[0]!=='' && $type[0]!=='' && $method[0]==''){
$sql = "SELECT * FROM organization WHERE category LIKE '%" . implode("','", $category) . "%' AND payment_type LIKE '%" . implode("' , '", $type) . "%' ORDER BY oname";}

    else if($searchQuery=='' && $type[0]=='' && $method[0]!=='' &&$category[0]!==''){
    foreach ($methods as $methodss) {
    $conditions[] = "FIND_IN_SET('$methodss', payment_method) > 0";
$sql = "SELECT * FROM organization WHERE category LIKE '%" . implode("','", $category) . "%' AND " . implode(" and ", $conditions) . " ORDER BY oname";}}

    else if($searchQuery=='' && $type[0]!=='' && $method[0]!=='' &&$category[0]==''){
    foreach ($methods as $methodss) {
    $conditions[] = "FIND_IN_SET('$methodss', payment_method) > 0";
$sql = "SELECT * FROM organization WHERE payment_type LIKE '%" . implode("' , '", $type) . "%' AND " . implode(" and ", $conditions) . " ORDER BY oname";}}

    
    else if($searchQuery!=='' && $type[0]=='' && $method[0]=='' &&$category[0]==''){
$sql = "SELECT * FROM organization WHERE oname LIKE '%$searchQuery%' ORDER BY oname";}

    else if($searchQuery=='' && $type[0]=='' && $method[0]=='' &&$category[0]!==''){
$sql = "SELECT * FROM organization WHERE category LIKE '%" . implode("','", $category) . "%' ORDER BY oname";}

    else if($searchQuery=='' && $type[0]!=='' && $method[0]=='' &&$category[0]==''){
$sql = "SELECT * FROM organization WHERE payment_type LIKE '%" . implode("' ,'", $type) . "%' ORDER BY oname";}

    else if($searchQuery=='' && $type[0]=='' && $method[0]!=='' &&$category[0]==''){
        foreach ($methods as $methodss) {
    $conditions[] = "FIND_IN_SET('$methodss', payment_method) > 0";
}
$sql = $sql = "SELECT * FROM organization WHERE " . implode(" and ", $conditions) . " ORDER BY oname";}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
        echo '<div style="width:100%;height:20px">';
        echo $result->num_rows. " results was found";
        echo '</div>';
    while ($row = $result->fetch_assoc()) {
        $imageData = base64_encode($row['logo']);
        $imageSrc = "data:image/jpg;base64," . $imageData;
        if (file_exists('organization_images/' . $row['logo'])) {
            $imageSrc = 'organization_images/' . $row['logo'];
        }
        echo '<div class="card2">';
        echo '<img src="' . $imageSrc . '" alt="Organization logo" style="width:100%;height: 154px;">';
        echo '<div class="breedName2">';
        echo '<p><b>' . $row['oname'] . '</b></p>';
        echo '</div>';
        echo '<div class="view-breed">';
        echo '<a href="SideBar_Donation-Organization-Profile.php?id=' . $row['oID'] . '" target="_blank"><p>Learn More <span class="material-symbols-outlined" style="vertical-align:-5px">open_in_new</span></p></a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No results found.";
}
}
else{
   $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "SELECT count(*) as total from organization";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT * FROM organization ORDER BY oname LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<div style="width:100%;height:20px">';
        echo $total_records. " results was found";
        echo '</div>';
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['logo']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('organization_images/' . $row['logo'])) {
                $imageSrc = 'organization_images/' . $row['logo'];
            }
            echo '<div class="card2">';
            echo '<img src="' . $imageSrc . '" alt="organization logo" style="width:100%;height: 154px;">';
            echo '<div class="breedName2">';
            echo '<p><b>' . $row['oname'] . '</b></p>';
            echo '</div>';
            echo '<div class="view-breed">';
            echo '<a href="SideBar_Donation-Organization-Profile.php?id=' . $row['oID'] . '" target="_blank"><p>Learn More <span class="material-symbols-outlined" style="vertical-align:-5px">open_in_new</span></p></a>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
            
        }
        else{
            echo '<a href="User-Donation.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="User-Donation.php?page=' . $i . '" class="page-active">' . $i . '</a>';
            } else {
                echo '<a href="User-Donation.php?page=' . $i . '">' . $i . '</a>';
            }
    }
        if($page == $total_pages){
           
        }
        else{
            echo '<a href="User-Donation.php?page=' . ($page+1) . '"> &gt;</a>';
         }
        echo '</div>';
    }
}
$conn->close();
?>

