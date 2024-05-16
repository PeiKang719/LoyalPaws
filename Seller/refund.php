<?php
// Get the transactionId from the AJAX request
$transactionId = $_POST['transactionId'];
$price = $_POST['price'];

// Set up your PayPal API credentials and endpoint
$clientId = 'AVKhPyIREMp1EynqC_9932cWY2SPi_zMNmnSPlP9hyorwbiOogLrslLKz9bDhXs6vGQr9LYbD38_zapW';
$clientSecret = 'ENLd3yZwwET5IoOeXrrilTbN3tG2esSp04Aqyoxq3sel-1tJRu7vE-Ly2Fp4fv9LioU3ukJIrPT-maEw';
$endpoint = 'https://api.sandbox.paypal.com';


// Set up the request headers
$headers = array(
  'Content-Type: application/json',
);

// Set up the request data
$data = array(
  'amount' => array(
     'total' => $price, // The refund amount
    'currency' => 'MYR', // The currency code
  ),
);

// Convert the data to JSON format
$dataJson = json_encode($data);

// Set up the cURL request
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $endpoint . '/v2/payments/captures/' . $transactionId . '/refund');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_USERPWD, $clientId . ':' . $clientSecret);

// Execute the cURL request
$response = curl_exec($curl);

// Check for any errors
if (curl_errno($curl)) {
  $error = curl_error($curl);
  // Handle the error
  http_response_code(500);
  echo 'Error: ' . $error;
} else {
  // Process the refund response
  $refund = json_decode($response, true);
  // Access refund details as needed
  http_response_code(200);
  echo 'Refund successful';
}

// Close the cURL request
curl_close($curl);
?>
