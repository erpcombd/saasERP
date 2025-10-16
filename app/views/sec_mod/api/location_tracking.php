<?php
require_once "../../../controllers/routing/default_values.php";

require_once SERVER_CORE."config/db_con_live_static.php";

// $pdata  = file_get_contents("php://input");
// $result = json_decode($pdata);
$pdata = file_get_contents("php://input");
file_put_contents('debug_log.txt', $pdata); // Save the exact input for inspection
$result = json_decode($pdata);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo ' | JSON Decode Error: ' . json_last_error_msg();
}

if (is_array($result) && isset($result[0])) {
    echo "\nLatitude: " . $result[0]->latitude;
    echo "\nLongitude: " . $result[0]->longitude;
    echo "\nUser ID: " . $result[0]->user_id;
} else {
    echo "\nInvalid or missing JSON structure.";
}

// Extract data from the JSON array
$tracking_date  =date('Y-m-d H:i:s');;
echo $lat            = $result[0]->latitude;
echo $long           = $result[0]->longitude;
echo $user_id        = $result[0]->user_id;


// Build the SQL query
 $sql = "INSERT IGNORE INTO ss_location_log (
    access_time, user_id, latitude, longitude, type) VALUES ('$tracking_date','$user_id','$lat', '$long','tracking_info')";

// Execute the SQL query
if (mysqli_query($new_conn, $sql)) {
    $lastInsertedId = mysqli_insert_id($new_conn);
    $feedback = 'Done';
} else {
    $lastInsertedId = null;
    $feedback = 'Failed: ' . mysqli_error($new_conn);
}

// Prepare the response data
$data = [
    'message' => $feedback,
    'status'   => 'success',
];

// Encode and output the response
echo json_encode($data);

// Close the database connection
mysqli_close($new_conn);
?>
