<?php

include('../Database/Connection.php');


$action = $_GET['action'];
if($action =='seller'){
$sellerID = $_GET['sellerID'];
$sql = "DELETE FROM seller WHERE sellerID = $sellerID"; 

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
} else {
    echo "Error Deleting Seller Information";
}

}

if($action =='shop'){
$shopID = $_GET['shopID'];
$sql = "DELETE FROM pet_shop WHERE shopID = $shopID"; 

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
} else {
    echo "Error Deleting Pet_Shop Information";
}

}
?>