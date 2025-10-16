<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../../../controllers/config/db_con_live_static.php");

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata, true);

if (!isset($result['mobile_no'])) {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
    exit;
}

$mobile_no = $result['mobile_no'];

// Generate a random 6-digit OTP
$otp = rand(100000, 999999);

// Set API credentials and message data
$url = 'https://api.mobireach.com.bd/SendTextMessage';
$data = array(
    'Username' => 'erpcom',
    'Password' => 'AllahOnly@1',
    'From' => '8801894650378',
    'To' => $mobile_no,
    'Message' => "Your OTP code is: $otp"
);


// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute API request
$response = curl_exec($curl);
curl_close($curl);

// Parse XML response
$xml = simplexml_load_string($response);
$status = (string) $xml->ServiceClass->StatusText ?? '';

// Prepare response array including raw API response for debugging
$response_array = [
    "api_response" => $response
];

if ($status === "success") {
    $expire_date = date("Y-m-d H:i:s", strtotime("+5 minutes")); // OTP expires in 5 minutes
    $entry_at = date("Y-m-d H:i:s");
    
    $query = "INSERT INTO forgot_pass_email_otp (otp, status, mobile_no, entry_at, expire_date) 
              VALUES ('$otp', 'PENDING', '$mobile_no', '$entry_at', '$expire_date')";
    
    if (mysqli_query($new_conn, $query)) {
        $response_array["status"] = "success";
        $response_array["message"] = "OTP sent successfully";
    } else {
        $response_array["status"] = "error";
        $response_array["message"] = "Failed to save OTP";
    }
} else {
    $response_array["status"] = "error";
    $response_array["message"] = "Failed to send OTP";
}

echo json_encode($response_array);
?>
