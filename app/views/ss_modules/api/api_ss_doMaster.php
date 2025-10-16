<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_AUTH."db_con_live_static.php";

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata);

// Extract data from the JSON array
$do_Date      = $result[0]->do_Date;
$shop_id  = $result[0]->shop_id;
$status       = $result[0]->status;
$remarks      = $result[0]->remarks;
$visit        = $result[0]->visit;
$memo         = $result[0]->memo;
$longitude    = $result[0]->longitude;
$latitude     = $result[0]->latitude;
$dealer_code    = $result[0]->dealer_code;
$entry_by    = $result[0]->entry_by;
$shop_status    = $result[0]->shop_status;

// Build the SQL query
$sql = "INSERT IGNORE INTO ssn_do_master (
    do_Date, shop_id, status, remarks, visit, memo, longitude, latitude,dealer_code,entry_by,shop_status
) VALUES (
    '$do_Date', '$shop_id', '$status', '$remarks', '$visit', '$memo', '$longitude', '$latitude','$dealer_code','$entry_by','$shop_status'
)";

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
    'do_no'   => $lastInsertedId,
];

// Encode and output the response
echo json_encode($data);

// Close the database connection
mysqli_close($new_conn);
?>
