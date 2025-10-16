<?php
include("../config/db.php");
include("../config/function.php");

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata);

// Extract data from the JSON array
$msg             = $result[0]->msg;
$date            = $result[0]->date;
$entrytime       = $result[0]->time;
$latitude        = $result[0]->latitude;
$longitude       = $result[0]->longitude;
$locationString  = $result[0]->locationString;
$altitude        = $result[0]->altitude;
$heading         = $result[0]->heading;
$speed           = $result[0]->speed;
$accuracy        = $result[0]->accuracy;

// Build the SQL query for ss_do_details table
$sql_details = "INSERT INTO ss_backgroundlocation (
    msg, entrydate, latitude, longitude, time, locationString, altitude, heading, speed, accuracy
) VALUES (
    '$msg', '$date', '$latitude', '$longitude', '$entrytime', '$locationString', '$altitude', '$heading', '$speed', '$accuracy'
)";

// Execute the SQL query for ss_do_details table
if (mysqli_query($conn, $sql_details)) {
    $feedbackDetails = 'Done';
} else {
    $feedbackDetails = 'Failed: ' . mysqli_error($conn);
}

// Prepare the response data
$data = [
    'message_details' => $feedbackDetails,
];

// Encode and output the response
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
