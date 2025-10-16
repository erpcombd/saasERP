<?php
// Include the configuration file
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."config/db_con_live_static.php";
require_once('config.php');

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

// Retrieve parameters from the GET request
$username = $_GET['Username'] ?? '';
$password = $_GET['Password'] ?? '';
$from = $_GET['From'] ?? '';
$to = $_GET['To'] ?? '';
$message = $_GET['Message'] ?? '';

// Verify username and password
if ($username !== 'fahimerp' || $password !== '35ggh7') {
    // Unauthorized access
    header("HTTP/1.1 401 Unauthorized");
    echo "Unauthorized access";
    exit();
}

// Construct the URL for the Mobireach SMS API
$url = 'https://api.mobireach.com.bd/SendTextMessage';
$data = array(
    'Username' => $config['username'],
    'Password' => $config['password'],
    'From' => $from,
    'To' => $to,
    'Message' => $message
);

// Initialize cURL session
$curl = curl_init();

// Set the URL
curl_setopt($curl, CURLOPT_URL, $url);

// Set the request method to POST
curl_setopt($curl, CURLOPT_POST, 1);

// Set the POST data
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

// Return the response instead of printing it
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($curl);

// Close cURL session
curl_close($curl);
$xml = simplexml_load_string($response);

// Check if the status is "success"
// if ($xml->ServiceClass->StatusText == "success") {
    $status_entry='success';
    $query = 'INSERT INTO sms_api_info (username, password, fromNumber, toNumber, message, status) VALUES ("'.$username.'", "'.$password.'", "'.$from.'", "'.$to.'", "'.$message.'", "'.$xml->ServiceClass->StatusText.'")';
    mysqli_query($new_conn,$query);
// }
   


// Return the response
echo $response;
?>
