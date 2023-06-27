<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loyal Paws-Breed Matching</title>
  <link rel="icon" type="image/png" href="media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="UserStyle.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body style="background-color: #e6f3ff">

<?php include 'UserHeader.php'; ?>
<br><br><br><br><br>
    <div class="container" >
        <div class="matchingForm-header" style="text-align: center;">Pet Matching Results</div>
<?php
include('Connection.php');

if(isset ($_POST['radio_cat'])){
    $size = $_POST['radio_cat'];
    $animal = 'cat';
}
if (isset  ($_POST['radio_dog'])) {
    $size = $_POST['radio_dog'];
    $animal = 'dog';
}

$kid_friendly = $_POST['radio3'];
$kid_friendly_array = explode(",", $kid_friendly);
$pet_friendly = $_POST['radio4'];
$pet_friendly_array = explode(",", $pet_friendly);
$shedding = $_POST['radio5'];
$shedding_array = explode(",", $shedding);
$intelligence = $_POST['radio6'];
$intelligence_array = explode(",", $intelligence);
$playfulness = $_POST['radio7'];
$playfulness_array = explode(",", $playfulness);
$energy_level = $_POST['radio8'];
$energy_level_array = explode(",", $energy_level);
$vocality = $_POST['radio9'];
$vocality_array = explode(",", $vocality);
$affection = $_POST['radio10'];
$affection_array = explode(",", $affection);
$grooming = $_POST['radio11'];
$grooming_array = explode(",", $grooming);
$stranger_friendly = $_POST['radio12'];
$stranger_array = explode(",", $stranger_friendly);


$sql = "SELECT * FROM breed WHERE type='$animal' AND size='$size'";
    $result = $conn->query($sql);
 
    // output data of each row
$breeds = array();
while($row = $result->fetch_assoc()) {
    $name = $row["name"];
    $breeds[$name] = array(
        "breedID" => $row['breedID'],
        "breed_image" => $row['breed_image'],
        "kid_friendly" => $row["kid_friendly"],
        "pet_friendly" => $row["pet_friendly"],
        "shedding" => $row["shedding"],
        "intelligence" => $row["intelligence"],
        "playfulness" => $row["playfulness"],
        "energy_level" => $row["energy_level"],
        "vocality" => $row["vocality"],
        "affection" => $row["affection"],
        "grooming" => $row["grooming"],
        "stranger_friendly" => $row["stranger_friendly"]
    );
}


// Define the user's responses
$userResponses = array(
    "kid_friendly" => $kid_friendly_array,
    "pet_friendly" => $pet_friendly_array,
    "shedding" => $shedding_array,
    "intelligence" => $intelligence_array,
    "playfulness" => $playfulness_array,
    "energy_level" => $energy_level_array,
    "vocality" => $vocality_array,
    "affection" => $affection_array,
    "grooming" => $grooming_array,
    "stranger_friendly" => $stranger_array,
);

// Loop through each breed and calculate a compatibility score
foreach ($breeds as $breed => $characteristics) {
    $score = 0;
    foreach ($userResponses as $trait => $response) {
        if (is_array($response)) { // If the user's response is a range
            $diff = 0;
                if (in_array($characteristics[$trait], $response)) {
                    $score += 5;
                } else if (!in_array($characteristics[$trait], $response)) {
                    $average = array_sum($response)/count($response);
                    $score -=  abs($average - $characteristics[$trait]);
                } 
            
        } else { // If the user's response is a single value
                if ($response == $characteristics[$trait]){
                    $score +=5;
                }
                else{
                $score -=  abs($response - $characteristics[$trait]); // Calculate the score based on the difference between the response and the characteristic 
                }  
        }
    }
    $breeds[$breed]["score"] = $score; // Store the compatibility score for the breed
}

uasort($breeds, function ($a, $b) {
    return $b["score"] <=> $a["score"];
});

// Display the breeds in order of compatibility
$i=0;
echo"<div style='margin-top:150px;text-align:center;background-color:#cce6ff;padding:30px 0px 70px 0px;box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.2);'><div style='text-align: center;font-size:30px;''>Top 3 Highest Match</div>";
foreach ($breeds as $breed => $characteristics) {
    $breed_image = $characteristics["breed_image"];
    $imageData = base64_encode(file_get_contents('breed_images/' . $breed_image));
    $imageSrc = "data:image/jpg;base64," . $imageData;
    // Check if the image file exists before displaying it
    if (file_exists('breed_images/' . $breed_image)) {
        $imageSrc = 'breed_images/' . $breed_image;
    }
    if ($i <= 2){
        echo"<a href='SideBar_Breed-Breed-Profile.php?id=".$characteristics["breedID"]."' target='_blank'><div class='card'>
                            <img src='$imageSrc' alt='Breed Image' style='width:100%;height: 154px;'>
                            <div class='breedName' style='font-size:25px;'>
                                <p><b> $breed <br></b></p> 
                            </div>
                            <hr>
                                    <div style='display:flex;'>
                                    <p style='text-align:left;width:70%;font-size:25px;margin-top:20px;'>Match Percentage</p>
                                    <div class='single-chart' style='display:inline-block;margin-top:-15px;'>";
                                        if($characteristics['score']/50 *100 >50){
                                        echo"<svg viewBox='0 0 36 36' class='circular-chart green'>";
                                        }
                                        else{
                                             echo"<svg viewBox='0 0 36 36' class='circular-chart orange'>";
                                        }
                                        echo"<path class='circle-bg'
                                        d='M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831'
                                        />
                                        <path class='circle'
                                        stroke-dasharray='" . $characteristics["score"]/50 *100 .", 100'
                                        d='M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831'
                                        />
                                        <text x='18' y='20.35' class='percentage'>" . $characteristics["score"]/50 *100 ."%</text>
                                        </svg>
                                    </div>
                            </div></a>
                        </div>";
    }

    else if($i>2){
echo "</div></a><a href='SideBar_Breed-Breed-Profile.php?id=".$characteristics["breedID"]."' target='_blank'><div class='matching-result-rectangle'><img src='$imageSrc' alt='Breed Image' style='width:100px;height: 100px;'> <p style='font-size:25px;padding-left:40px;padding-top:10px;height:100%;width:70%;'><b> $breed <br></b></p>
                                    <div style='display:flex;width:100%;padding:8px;'>
                                    <p style='text-align:right;width:100%;margin-top:30px;'>Match Percentage</p>
                                    <div class='single-chart' style='width:18%;height:18%;'>";
                                    if($characteristics['score']/50 *100 >50){
                                        echo"<svg viewBox='0 0 36 36' class='circular-chart green'>";
                                        }
                                        else{
                                             echo"<svg viewBox='0 0 36 36' class='circular-chart orange'>";
                                        }
                                        echo"<path class='circle-bg'
                                        d='M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831'
                                        />
                                        <path class='circle'
                                        stroke-dasharray='" . $characteristics["score"]/50 *100 .", 100'
                                        d='M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831'
                                        />
                                        <text x='18' y='20.35' class='percentage'>" . $characteristics["score"]/50 *100 ."%</text>
                                        </svg>
                                    </div>
                            </div>";

}
if($i===2){
    echo"</div><div style='text-align: center;font-size:30px;''>Other pets that may match your preferences:</div>";
}
if(++$i > 12) break;
}
 ?>
</div>
<br><br><br>
</body>

</html>