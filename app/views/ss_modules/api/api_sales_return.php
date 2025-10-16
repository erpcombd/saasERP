<?php
include("../config/db.php");
include("../config/function.php");

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata);

// Extract data from the JSON object
$or_no          = $result[0]->or_no;
$vendor_id      = $result[0]->vendor_id;
$vendor_name    = $result[0]->vendor_name;
$or_date        = $result[0]->or_date;
$receive_type   = $result[0]->receive_type;
$item_id        = $result[0]->item_id;
$warehouse_id   = $result[0]->warehouse_id;
$rate           = $result[0]->rate;
$disc           = $result[0]->disc;
$unit_name      = $result[0]->unit_name;
$qty            = $result[0]->qty;
$amount         = $result[0]->amount;
$entry_by       = $result[0]->entry_by;


// Build the SQL query for your table
$sql = "INSERT INTO ssn_receive_details (
    or_no, vendor_id, vendor_name, or_date, receive_type, item_id, warehouse_id, rate, disc, unit_name, qty, amount, entry_by
) VALUES (
    '$or_no', '$vendor_id', '$vendor_name', '$or_date', '$receive_type', '$item_id', '$warehouse_id', '$rate', '$disc', '$unit_name', '$qty', '$amount', '$entry_by'
)";

// Execute the SQL query
if (mysqli_query($conn, $sql)) {
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
