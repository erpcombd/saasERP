<?php
include("../config/db.php");
include("../config/function.php");

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata);

// Extract data from the JSON array
$tracking_date  =date('Y-m-d H:i:s');;
$lat            = $result[0]->latitude;
$long           = $result[0]->longitude;
$user_id        = $result[0]->user_id;


// Build the SQL query
$sql = "INSERT IGNORE INTO ss_location_log (
    access_time, user_id, latitude, longitude, type) VALUES ('$tracking_date','$user_id','$lat', '$long','tracking_info')";

// Execute the SQL query
if (mysqli_query($conn, $sql)) {
    $lastInsertedId = mysqli_insert_id($conn);
    $feedback = 'Done';
} else {
    $lastInsertedId = null;
    $feedback = 'Failed: ' . mysqli_error($conn);
}

// Prepare the response data
$data = [
    'message' => $feedback,
    'status'   => 'success',
];

// Encode and output the response
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
