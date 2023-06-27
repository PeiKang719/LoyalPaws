<?php
include('Connection.php');


$size[] = $_GET['size'];

if(strlen($size[0])<10 && strlen($size[0])>1){

$sql = "SELECT * FROM breed WHERE type='Cat' and size=$size[0] ORDER BY name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
        echo '<div style="width:100%;height:20px">';
        echo $result->num_rows. " results was found";
        echo '</div>';
    while ($row = $result->fetch_assoc()) {
        $imageData = base64_encode($row['breed_image']);
        $imageSrc = "data:image/jpg;base64," . $imageData;
        if (file_exists('breed_images/' . $row['breed_image'])) {
            $imageSrc = 'breed_images/' . $row['breed_image'];
        }
        echo '<div class="card2">';
        echo '<img src="' . $imageSrc . '" alt="Breed Image" style="width:100%;height: 154px;">';
        echo '<div class="breedName2">';
        echo '<p><b>' . $row['name'] . '</b></p>';
        echo '</div>';
        echo '<div class="view-breed">';
        echo '<a href="SideBar_Breed-Breed-Profile.php?id=' . $row['breedID'] . '" target="_blank"><p>Learn More <span class="material-symbols-outlined" style="vertical-align:-5px">open_in_new</span></p></a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No results found.";
}
}
elseif(strlen($size[0])>10){
    echo "No results found.";
}
else{
   $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Cast $page to an integer
    $count = "SELECT count(*) as total from breed where type='Cat'";
    $data = $conn->query($count);
    $dat = $data->fetch_assoc();
    $total_records = $dat["total"];
    $records_per_page = 12;
    $total_pages = ceil($total_records / $records_per_page);
    if ($page < 1) {
    $page = 1;
}
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT * FROM breed WHERE type='Cat' ORDER BY name LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<div style="width:100%;height:20px">';
        echo $total_records. " results was found";
        echo '</div>';
        // Fetch all the rows into an array
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $imageData = base64_encode($row['breed_image']);
            $imageSrc = "data:image/jpg;base64," . $imageData;
            if (file_exists('breed_images/' . $row['breed_image'])) {
                $imageSrc = 'breed_images/' . $row['breed_image'];
            }
            echo '<div class="card2">';
            echo '<img src="' . $imageSrc . '" alt="Breed Image" style="width:100%;height: 154px;">';
            echo '<div class="breedName2">';
            echo '<p><b>' . $row['name'] . '</b></p>';
            echo '</div>';
            echo '<div class="view-breed">';
            echo '<a href="SideBar_Breed-Breed-Profile.php?id=' . $row['breedID'] . '" target="_blank"><p>Learn More <span class="material-symbols-outlined" style="vertical-align:-5px">open_in_new</span></p></a>';
            echo '</div>';
            echo '</div>';
        }
        // Add links to navigate to different pages

        echo '<div class="pagination">';
        
        if($page==1){
            
        }
        else{
            echo '<a href="Cat-breed.php?page=' . ($page-1) . '">&lt;</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="Cat-breed.php?page=' . $i . '" class="page-active">' . $i . '</a>';
            } else {
                echo '<a href="Cat-breed.php?page=' . $i . '">' . $i . '</a>';
            }
    }
        if($page == $total_pages){
           
        }
        else{
            echo '<a href="Cat-breed.php?page=' . ($page+1) . '"> &gt;</a>';
         }
        echo '</div>';
    }
}
$conn->close();
?>

