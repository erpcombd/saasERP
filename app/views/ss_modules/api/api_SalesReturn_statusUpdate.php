<?php
include("../config/db.php");
include("../config/function.php");

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata);

// Extract data from the JSON array
echo $or_no        = $result[0]->or_no; // Assuming this is the do_no from ss_do_master
echo $or_status    = $result[0]->or_status; // Extracting do_status

// Update the do_status in ss_do_master table
$sql_update_status = "UPDATE ssn_receive_master SET status = '$or_status' WHERE or_no = '$or_no'";

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
