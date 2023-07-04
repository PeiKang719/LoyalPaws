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
<body>
<?php include 'AdminHeader.php'; ?>
<?php	
include 'Connection.php';
$breedID = $_GET['id'];
		$sql = "SELECT * FROM breed WHERE breedID=$breedID";
    	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
	    	// output data of each row
	    	while($row = $result->fetch_assoc()) {
	    	$type=$row["type"];
	      	$breedID=$row["breedID"];
	      	$name= $row["name"];
	      	$breed_image=$row["breed_image"];
	      	$description=$row["description"];
	      	$kid_friendly=$row["kid_friendly"];
	      	$pet_friendly=$row["pet_friendly"];
	      	$stranger_friendly=$row["stranger_friendly"];
	      	$affection=$row["affection"];
	      	$grooming=$row["grooming"];
	      	$playfulness=$row["playfulness"];
	      	$shedding=$row["shedding"];
	      	$energy_level=$row["energy_level"];
	      	$intelligence=$row["intelligence"];
	      	$vocality=$row["vocality"];
	      	$origin=$row["origin"];
	      	$life_span=$row["life_span"];
	      	$length=$row["length"];
	      	$weight=$row["weight"];
	      	$life_span1=explode(" ",$row["life_span"])[0];
	      	$life_span2=explode(" ",$row["life_span"])[2];
	      	$length1=explode(" ",$row["length"])[0];
	      	$length2=explode(" ",$row["length"])[2];
	      	$weight1=explode(" ",$row["weight"])[0];
	      	$weight2=explode(" ",$row["weight"])[2];
	 		 }
	 		 } 
$imageData = base64_encode($breed_image);
$imageSrc = "data:image/jpg;base64," . $imageData;
// Check if the image file exists before displaying it
if (file_exists('breed_images/' . $breed_image)) {
    $imageSrc = 'breed_images/' .$breed_image;
}?>
<iframe name="hiddenFrame" class="hide" style="border: 0;display: none;"></iframe>
<form  action="SideBar_Breed-Edit-Breed.php" method="post" target="hiddenFrame" enctype="multipart/form-data">
<section>
<input type="hidden" id="type" name="type" value="<?php echo "$type" ?>">
				<input type="hidden" id="breedID" name="breedID" value="<?php echo "$breedID" ?>">
<img src="media/ttg.jpeg"  style="width: 100%;height: 500px;">
<div style="padding-left: 50px;">
	<img class="organization-image" src="<?php echo $imageSrc ?>">

        <div class="p-image" style="margin-top: 30px;">
        <i class="far fa-edit upload-button" style="font-size: 25px;">Edit Image</i>
        <input class="file-upload" name="img" type="file" accept="image/*"/>
        </div>
	<label style="font-size: 35px;color: white;margin-top: -175px;display: block;margin-left: 340px;">Breed:
	<input type="text" placeholder="Name..." name="name" value="<?php echo"$name" ?>"  required style="width: 64%;vertical-align: 7px;"></label>
</div>

</section>
<br><br><br><br><br><br><br><br><br>

<section class="s2">
	 <p class="head">Characteristics:</p>
	 <br>
	<table class="breed-characteristic-table">
		<tr>
			<td ><p>Kid-Friendly</p></td>
			<td>:</td>
			<td>
		<select name="one" required>
		    			<option value="<?php echo"$kid_friendly" ?>"  selected><?php echo"$kid_friendly" ?></option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
			</td>
			<td width="100px"></td>
			<td><p>Pet-Friendly</p></td>
			<td>:</td>
			<td>
		<select name="two" required>
		    			<option value="<?php echo"$pet_friendly" ?>" selected><?php echo"$pet_friendly" ?></option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
			</td>
		</tr>
		<tr>
			<td><p>Stranger-Friendly</p> </td>
			<td>:</td>
			<td>
		<select name="three" required>
		    			<option value="<?php echo"$stranger_friendly" ?>"  selected><?php echo"$stranger_friendly" ?></option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
			</td>
			<td width="100px"></td>
			<td><p>Intelligence</p></td>
			<td>:</td>
			<td>
		<select name="four" required>
		    			<option value="<?php echo"$intelligence" ?>"  selected><?php echo"$intelligence" ?></option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
			</td>
		</tr>
		<tr>
			<td><p>Grooming Requirements</p> </td>
			<td>:</td>
			<td>
		<select name="five" required>
		    			<option value="<?php echo"$grooming" ?>" selected><?php echo"$grooming" ?></option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
			</td>
			<td width="100px"></td>
			<td><p>Playfulness</p></td>
			<td>:</td>
			<td>
		<select name="six" required>
		    			<option value="<?php echo"$playfulness" ?>" selected><?php echo"$playfulness" ?></option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
			</td>
		</tr>
		<tr>
			<td><p>Amount of Shedding</p> </td>
			<td>:</td>
			<td>
		<select name="seven" required>
		    			<option value="<?php echo"$shedding" ?>" selected><?php echo"$shedding" ?></option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
			</td>
			<td width="100px"></td>
			<td><p>Energy Level</p></td>
			<td>:</td>
			<td>
		<select name="eight" required>
		    			<option value="<?php echo"$energy_level" ?>" selected><?php echo"$energy_level" ?></option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
			</td>
		</tr>
		<tr>
			<td><p>Affection Towards Owners</p></td>
			<td>:</td>
			<td>
		<select name="nine" required>
		    			<option value="<?php echo"$affection" ?>" selected><?php echo"$affection" ?></option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
			</td>
			<td width="100px"></td>
			<td><p>Vocality</p></td>
			<td>:</td>
			<td>
		<select name="ten" required>
		    			<option value="<?php echo"$vocality" ?>" selected><?php echo"$vocality" ?></option>
		   			    <option value="1">1</option>
		   			    <option value="2">2</option>
		   			    <option value="3">3</option>
		   			    <option value="4">4</option>
		   			    <option value="5">5</option>
						</select>
			</td>
		</tr>
	</table>
	<small>*This disclaimer emphasizes that pets are individuals, and while breed characteristics may be useful, they may not apply to every pet. It advises consulting the adoption organization and spending time with the pet before adoption.*</small>
</section>
<br><br>
<p class="head" style="margin-left:42px">About the breed:</p>
<br>
<section class="s3" style="height:350px">
	<textarea maxlength="4000" placeholder="Write something to describe the breed...(max 4000 characters)" name="description"  required style="height:320px"><?php echo"$description" ?></textarea>
</section>
<br><br><br>
<section class="s2" >
	<p class="head" >Vital Stat:</p>
	<br>
	<table style="margin-left: 20px;font-size: 35px;text-align: center;width: 70%;" border="0">
		<tr>
			<td  class="breed-stat-icon-in-table" style="width:20%"><img class="breed-stat-icon" src="media/origin1.png" alt="Avatar"></td>
			<td width="200px" height="65px" style="text-align:left"><b>Origin</b></td>
			<td>:</td>
			<td colspan="4">		<input list="country" name="country" class="datalist-input" id="datalist" value="<?php echo"$origin" ?>" required style="width: 95%;vertical-align: -10px;">
			    <datalist id="country">
			        <option value="Afghanistan" />
			        <option value="Albania" />
			        <option value="Algeria" />
			        <option value="American Samoa" />
			        <option value="Andorra" />
			        <option value="Angola" />
			        <option value="Anguilla" />
			        <option value="Antarctica" />
			        <option value="Antigua and Barbuda" />
			        <option value="Argentina" />
			        <option value="Armenia" />
			        <option value="Aruba" />
			        <option value="Australia" />
			        <option value="Austria" />
			        <option value="Azerbaijan" />
			        <option value="Bahamas" />
			        <option value="Bahrain" />
			        <option value="Bangladesh" />
			        <option value="Barbados" />
			        <option value="Belarus" />
			        <option value="Belgium" />
			        <option value="Belize" />
			        <option value="Benin" />
			        <option value="Bermuda" />
			        <option value="Bhutan" />
			        <option value="Bolivia" />
			        <option value="Bosnia and Herzegovina" />
			        <option value="Botswana" />
			        <option value="Bouvet Island" />
			        <option value="Brazil" />
			        <option value="British Indian Ocean Territory" />
			        <option value="Brunei Darussalam" />
			        <option value="Bulgaria" />
			        <option value="Burkina Faso" />
			        <option value="Burundi" />
			        <option value="Cambodia" />
			        <option value="Cameroon" />
			        <option value="Canada" />
			        <option value="Cape Verde" />
			        <option value="Cayman Islands" />
			        <option value="Central African Republic" />
			        <option value="Chad" />
			        <option value="Chile" />
			        <option value="China" />
			        <option value="Christmas Island" />
			        <option value="Cocos (Keeling) Islands" />
			        <option value="Colombia" />
			        <option value="Comoros" />
			        <option value="Congo" />
			        <option value="Congo, The Democratic Republic of The" />
			        <option value="Cook Islands" />
			        <option value="Costa Rica" />
			        <option value="Cote D'ivoire" />
			        <option value="Croatia" />
			        <option value="Cuba" />
			        <option value="Cyprus" />
			        <option value="Czech Republic" />
			        <option value="Denmark" />
			        <option value="Djibouti" />
			        <option value="Dominica" />
			        <option value="Dominican Republic" />
			        <option value="Ecuador" />
			        <option value="Egypt" />
			        <option value="El Salvador" />
			        <option value="Equatorial Guinea" />
			        <option value="Eritrea" />
			        <option value="Estonia" />
			        <option value="Ethiopia" />
			        <option value="Falkland Islands (Malvinas)" />
			        <option value="Faroe Islands" />
			        <option value="Fiji" />
			        <option value="Finland" />
			        <option value="France" />
			        <option value="French Guiana" />
			        <option value="French Polynesia" />
			        <option value="French Southern Territories" />
			        <option value="Gabon" />
			        <option value="Gambia" />
			        <option value="Georgia" />
			        <option value="Germany" />
			        <option value="Ghana" />
			        <option value="Gibraltar" />
			        <option value="Greece" />
			        <option value="Greenland" />
			        <option value="Grenada" />
			        <option value="Guadeloupe" />
			        <option value="Guam" />
			        <option value="Guatemala" />
			        <option value="Guinea" />
			        <option value="Guinea-bissau" />
			        <option value="Guyana" />
			        <option value="Haiti" />
			        <option value="Heard Island and Mcdonald Islands" />
			        <option value="Holy See (Vatican City State)" />
			        <option value="Honduras" />
			        <option value="Hong Kong" />
			        <option value="Hungary" />
			        <option value="Iceland" />
			        <option value="India" />
			        <option value="Indonesia" />
			        <option value="Iran, Islamic Republic of" />
			        <option value="Iraq" />
			        <option value="Ireland" />
			        <option value="Israel" />
			        <option value="Italy" />
			        <option value="Jamaica" />
			        <option value="Japan" />
			        <option value="Jordan" />
			        <option value="Kazakhstan" />
			        <option value="Kenya" />
			        <option value="Kiribati" />
			        <option value="Korea, Democratic People's Republic of" />
			        <option value="Korea, Republic of" />
			        <option value="Kuwait" />
			        <option value="Kyrgyzstan" />
			        <option value="Lao People's Democratic Republic" />
			        <option value="Latvia" />
			        <option value="Lebanon" />
			        <option value="Lesotho" />
			        <option value="Liberia" />
			        <option value="Libyan Arab Jamahiriya" />
			        <option value="Liechtenstein" />
			        <option value="Lithuania" />
			        <option value="Luxembourg" />
			        <option value="Macao" />
			        <option value="Macedonia, The Former Yugoslav Republic of" />
			        <option value="Madagascar" />
			        <option value="Malawi" />
			        <option value="Malaysia" />
			        <option value="Maldives" />
			        <option value="Mali" />
			        <option value="Malta" />
			        <option value="Marshall Islands" />
			        <option value="Martinique" />
			        <option value="Mauritania" />
			        <option value="Mauritius" />
			        <option value="Mayotte" />
			        <option value="Mexico" />
			        <option value="Micronesia, Federated States of" />
			        <option value="Moldova, Republic of" />
			        <option value="Monaco" />
			        <option value="Mongolia" />
			        <option value="Montserrat" />
			        <option value="Morocco" />
			        <option value="Mozambique" />
			        <option value="Myanmar" />
			        <option value="Namibia" />
			        <option value="Nauru" />
			        <option value="Nepal" />
			        <option value="Netherlands" />
			        <option value="Netherlands Antilles" />
			        <option value="New Caledonia" />
			        <option value="New Zealand" />
			        <option value="Nicaragua" />
			        <option value="Niger" />
			        <option value="Nigeria" />
			        <option value="Niue" />
			        <option value="Norfolk Island" />
			        <option value="Northern Mariana Islands" />
			        <option value="Norway" />
			        <option value="Oman" />
			        <option value="Pakistan" />
			        <option value="Palau" />
			        <option value="Palestinian Territory, Occupied" />
			        <option value="Panama" />
			        <option value="Papua New Guinea" />
			        <option value="Paraguay" />
			        <option value="Peru" />
			        <option value="Philippines" />
			        <option value="Pitcairn" />
			        <option value="Poland" />
			        <option value="Portugal" />
			        <option value="Puerto Rico" />
			        <option value="Qatar" />
			        <option value="Reunion" />
			        <option value="Romania" />
			        <option value="Russian Federation" />
			        <option value="Rwanda" />
			        <option value="Saint Helena" />
			        <option value="Saint Kitts and Nevis" />
			        <option value="Saint Lucia" />
			        <option value="Saint Pierre and Miquelon" />
			        <option value="Saint Vincent and The Grenadines" />
			        <option value="Samoa" />
			        <option value="San Marino" />
			        <option value="Sao Tome and Principe" />
			        <option value="Saudi Arabia" />
			        <option value="Senegal" />
			        <option value="Serbia and Montenegro" />
			        <option value="Seychelles" />
			        <option value="Sierra Leone" />
			        <option value="Singapore" />
			        <option value="Slovakia" />
			        <option value="Slovenia" />
			        <option value="Solomon Islands" />
			        <option value="Somalia" />
			        <option value="South Africa" />
			        <option value="South Georgia and The South Sandwich Islands" />
			        <option value="Spain" />
			        <option value="Sri Lanka" />
			        <option value="Sudan" />
			        <option value="Suriname" />
			        <option value="Svalbard and Jan Mayen" />
			        <option value="Swaziland" />
			        <option value="Sweden" />
			        <option value="Switzerland" />
			        <option value="Syrian Arab Republic" />
			        <option value="Taiwan, Province of China" />
			        <option value="Tajikistan" />
			        <option value="Tanzania, United Republic of" />
			        <option value="Thailand" />
			        <option value="Timor-leste" />
			        <option value="Togo" />
			        <option value="Tokelau" />
			        <option value="Tonga" />
			        <option value="Trinidad and Tobago" />
			        <option value="Tunisia" />
			        <option value="Turkey" />
			        <option value="Turkmenistan" />
			        <option value="Turks and Caicos Islands" />
			        <option value="Tuvalu" />
			        <option value="Uganda" />
			        <option value="Ukraine" />
			        <option value="United Arab Emirates" />
			        <option value="United Kingdom" />
			        <option value="United States" />
			        <option value="United States Minor Outlying Islands" />
			        <option value="Uruguay" />
			        <option value="Uzbekistan" />
			        <option value="Vanuatu" />
			        <option value="Venezuela" />
			        <option value="Viet Nam" />
			        <option value="Virgin Islands, British" />
			        <option value="Virgin Islands, U.S" />
			        <option value="Wallis and Futuna" />
			        <option value="Western Sahara" />
			        <option value="Yemen" />
			        <option value="Zambia" />
			        <option value="Zimbabwe" />
			    </datalist></td>
		</tr>
		<tr>
			<td  class="breed-stat-icon-in-table"><img class="breed-stat-icon" src="media/life1.png" alt="Avatar"></td>
			<td width="200px" style="text-align:left"><b>Life Span</b></td>
			<td>:</td>
			<td><input type="number" id="life" name="life1" value="<?php echo"$life_span1" ?>" required style="width: 80%;vertical-align: -10px;"></td>
			<td style="width: 5%;">to</td>
			<td><input type="number" id="life" name="life2" value="<?php echo"$life_span2" ?>" required style="width: 80%;vertical-align: -10px;"></td>
			<td>years</td>
		</tr>
		<tr>
			<td  class="breed-stat-icon-in-table"><img class="breed-stat-icon" src="media/length1.png" alt="Avatar"></td>
			<td width="200px" style="text-align:left"><b>Length</b></td>
			<td>:</td>
			<td><input type="number" id="length" name="length1" value="<?php echo"$length1" ?>" required style="width: 80%;vertical-align: -10px;"></td>
			<td>to</td>
			<td><input type="number" id="length" name="length2" value="<?php echo"$length2" ?>" required style="width: 80%;vertical-align: -10px;"></td>
			<td>cm</td>
		</tr>
		<tr>
			<td  class="breed-stat-icon-in-table"><img class="breed-stat-icon" src="media/weight1.png" alt="Avatar"></td>
			<td width="200px" style="text-align:left"><b>Weight</b></td>
			<td>:</td>
			<td><input type="number" id="weight" name="weight1" value="<?php echo"$weight1" ?>" required style="width: 80%;vertical-align: -10px;"></td>
			<td>to</td>
			<td><input type="number" id="weight" name="weight2" value="<?php echo"$weight2" ?>" required style="width: 80%;vertical-align: -10px;"></td>
			<td>kg</td>
		</tr>
	</table>
	<footer ><button class="save-change" type="submit" >SAVE CHANGE</button></footer>	
</section>
</form>
<script>
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
