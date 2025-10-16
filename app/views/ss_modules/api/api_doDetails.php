<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_AUTH."db_con_live_static.php";

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata);


// Extract data from the JSON array
$do_no        = $result[0]->do_no; // Assuming this is the do_no from ss_do_master
$date         = $result[0]->do_date;
$item_id      = $result[0]->item_id;
$dealer_code  = $result[0]->dealer_code;
$t_price      = $result[0]->t_price;
$nsp_per      = $result[0]->nsp_per;
$pack_size    = $result[0]->pack_size;
$unit_price   = $result[0]->unit_price;
$total_unit   = $result[0]->total_unit;
$total_amt    = $result[0]->total_amt;
 $shop_id    = $result[0]->shop_id;




// Build the SQL query for ss_do_details table
$sql_details = "INSERT INTO ssn_do_details (
    do_no, do_date, item_id, shop_id, t_price,nsp_per,pkt_size, unit_price, total_unit, total_amt,depot_id
) VALUES (
    '$do_no', '$date', '$item_id', '$shop_id', '$t_price','$nsp_per', '$pack_size','$unit_price', '$total_unit', '$total_amt',$dealer_code
)";

// Execute the SQL query for ss_do_details table
if (mysqli_query($new_conn, $sql_details)) {
    $last_inserted_id = mysqli_insert_id($new_conn);
    $feedbackDetails = 'Done';
} else {
 
    $feedbackDetails = 'Failed: ' . mysqli_error($new_conn);
}

// Prepare the response data
$data = [
    'message_details' => $feedbackDetails,
    'last_do_Details_item_id' => $last_inserted_id
   
];

// Encode and output the response
echo json_encode($data);

// Close the database new_connection
mysqli_close($new_conn);
?>