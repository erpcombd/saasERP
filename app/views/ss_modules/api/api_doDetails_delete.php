<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_AUTH."db_con_live_static.php";

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata);

echo "jjjjjjjjjjjjjjjjjjjjjjjjj";
// Extract data from the JSON array
echo $do_details_delete_id = $result[0]->do_details_delete_id; // Assuming this is the do_no from ss_do_master

// Build the SQL query to delete from ss_do_details table
echo $sql_delete = "DELETE FROM ssn_do_details WHERE id = '$do_details_delete_id'";

// Execute the SQL query to delete from ss_do_details table
if (mysqli_query($new_conn, $sql_delete)) {
    $feedbackDelete = 'Done';
} else {
    $feedbackDelete = 'Failed: ' . mysqli_error($new_conn);
}

// Prepare the response data
$data = [
    'message_delete' => $feedbackDelete
];

// Encode and output the response
echo json_encode($data);

// Close the database connection
mysqli_close($new_conn);
?>
