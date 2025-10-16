<?php
include("../config/db.php");
include("../config/function.php");

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata);

// Extract data from the JSON array
$do_no        = $result[0]->do_no; // Assuming this is the do_no from ss_do_master
$do_status    = $result[0]->do_status; // Extracting do_status

// Update the do_status in ss_do_master table
$sql_update_status = "UPDATE ssn_do_master SET status = '$do_status' WHERE do_no = '$do_no'";

// Execute the SQL query to update the status
if (mysqli_query($conn, $sql_update_status)) {
    $feedbackStatus = 'Status updated successfully';
} else {
    $feedbackStatus = 'Failed to update status: ' . mysqli_error($conn);
}

// Prepare the response data
$data = [
    'message_status' => $feedbackStatus,
];

// Encode and output the response
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
