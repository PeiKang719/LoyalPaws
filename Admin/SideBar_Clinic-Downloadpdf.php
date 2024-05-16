<?php
  
header("Content-Type: application/octet-stream");

$file = $_GET["file"]  ;

$filepath ="../Clinic/vet_apc/". $_GET["file"];
  
header("Content-Disposition: attachment; filename=" . urlencode($file));   
header("Content-Type: application/pdf");
header("Content-Description: File Transfer");            
header("Content-Length: " . filesize($filepath));
  
flush(); // This doesn't really matter.
  
$fp = fopen($filepath, "r");
while (!feof($fp)) {
    echo fread($fp, 65536);
    flush(); // This is essential for large downloads
} 
  
fclose($fp); 
?>