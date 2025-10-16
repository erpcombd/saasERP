<?php

include("../config/db.php");

include("../config/function.php");



$pdata  = file_get_contents("php://input");

$result = json_decode($pdata);





// Extract data from the JSON array

$return_Date      = $result[0]->return_Date;

$vendorid  = $result[0]->vendor_id;

$vendor_name  = $result[0]->vendor_name;

$status       = $result[0]->status;

$receive_type       = $result[0]->receive_type;

$remarks      = $result[0]->remarks;

$visit        = $result[0]->visit;

$memo         = $result[0]->memo;

$longitude    = $result[0]->longitude;

$latitude     = $result[0]->latitude;

$dealer_depot_id    = $result[0]->dealer_depot_id;

$entry_by    = $result[0]->entry_by;







// Build the SQL query

$sql = "INSERT IGNORE INTO ssn_receive_master(

    or_date, vendor_id,vendor_name,warehouse_id, status,receive_type,entry_by

) VALUES (

    '$return_Date', '$vendorid', '$vendor_name', '$dealer_depot_id', '$status', '$receive_type', '$entry_by'

)";



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

    'or_no'   => $lastInsertedId,

];



// Encode and output the response

echo json_encode($data);



// Close the database connection

mysqli_close($conn);

?>

