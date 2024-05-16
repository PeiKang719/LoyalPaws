<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loyal Paws-Breed Matching</title>
  <link rel="icon" type="image/png" href="../media/tabIcon.png">
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" type="text/css" href="../User/css/UserStyle.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body style="background-color:white">

<?php include '../User/UserHeader.php'; ?>
<br><br><br><br><br>
    <div class="container" >
        <div class="matchingForm-header" style="text-align: center;position: absolute;font-weight: bold;">Breed Matching Results</div>
        <div style="display:flex;flex-direction: row;align-items: center;">
        <img src="../media/matching-result2.svg" alt="avatar" style="width: 400px;height: 250px;margin-top: -20px;margin-left: 100px;">
        <img src="../media/matching-result.svg" alt="avatar" style="width: 400px;height: 300px;margin-top: -20px;margin-left: 335px;">
    </div>
<?php
include('../Database/Connection.php');

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
                    $score += 5 - abs($average - $characteristics[$trait]);
                } 
            
        } else { // If the user's response is a single value
                $score += 5 - abs($response - $characteristics[$trait]); // Calculate the score based on the difference between the response and the characteristic   
        }
    }
    $breeds[$breed]["score"] = $score; // Store the compatibility score for the breed
}

uasort($breeds, function ($a, $b) {
    return $b["score"] <=> $a["score"];
});

// Display the breeds in order of compatibility
$i=0; ?>
<div style="margin-top:-20px;text-align:center;background-color:#e6f2ff;padding:30px 0px 70px 0px;box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.2);">
    <div style="text-align: center;font-size:30px;font-weight: bold;">Top 10 Highest Match</div>
<?php
foreach ($breeds as $breed => $characteristics) {
    $breed_image = $characteristics["breed_image"];
    $imageData = base64_encode(file_get_contents('breed_images/' . $breed_image));
    $imageSrc = "data:image/jpg;base64," . $imageData;
    // Check if the image file exists before displaying it
    if (file_exists('breed_images/' . $breed_image)) {
        $imageSrc = 'breed_images/' . $breed_image;
    }?>

    <a href="SideBar_Breed-Breed-Profile.php?id=<?php echo $characteristics['breedID']; ?>" target="_self">
        <div class="matching-result-rectangle" style="display:flex;flex-direction:row;align-items:center;border-radius:5px;border: 1px solid #4d4d4d;">
            <img src="<?php echo $imageSrc; ?>" alt="Breed Image" style="width:100px;height: 100px;border-radius: 5px 0 0 5px;">
            <p style="font-size:25px;width:70%;"><b><?php echo $breed; ?><br></b></p>
            <div style="display:flex;width:100%;padding:8px;">
                <p style="text-align:right;width:100%;margin-top:30px;">Match Percentage</p>
                <div class="single-chart" style="width:18%;height:18%;">
                    <?php if ($characteristics['score'] / 50 * 100 > 50) { ?>
                        <svg viewBox="0 0 36 36" class="circular-chart green">
                    <?php } else { ?>
                        <svg viewBox="0 0 36 36" class="circular-chart orange">
                    <?php } ?>
                        <path class="circle-bg"
                            d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                            stroke-dasharray="<?php echo $characteristics['score'] / 50 * 100; ?>, 100"
                            d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage"><?php echo $characteristics['score'] / 50 * 100; ?>%</text>
                    </svg>
                </div>
            </div>
        </div>
    </a>
<?php  

if(++$i > 10) break;
}
 ?>
</div>
<br><br>
<div style="display: flex;justify-content: center;align-items: center;">
<a href='../../../FYP/User/UserHomePage.php' style="width:40%;margin:0"><button class="matching-letsgo-button" style="margin:0;width:100%">Back to homepage</button></a>
</div>
<br><br>
</body>

</html>