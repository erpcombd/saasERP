<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

header('Content-Type: application/json');


// Read the JSON input
$input = json_decode(file_get_contents('php://input'), true);

$rfq_name = $input['rfq_no'] ?? '';
// $item_id = $input['item_id'] ?? '';

// Prepare arrays to store prices and entry dates for each vendor
$vendors_data = [];
$all_entry_dates = []; // To store all unique entry_at dates


    // For each vendor, fetch the entry_at and lowest unit price, ordered by entry_at
  $sql_each_vendor = 'SELECT 
    entry_at, 
    rfq_no, 
    vendor_id, 
    total_amount
FROM 
    auction_graph_history

WHERE 
    rfq_no = "'.$rfq_name.'"
    AND vendor_id ="'.$_SESSION['vendor']['id'].'" 
 
ORDER BY 
    entry_at ASC;';

    
    $qry_each_vendor = db_query($sql_each_vendor);
    
    $vendor_prices = [];
    $vendor_dates = [];

    while ($res2 = mysqli_fetch_object($qry_each_vendor)) {
        // Store each entry_at and lowest_unit_price for this vendor
        $vendor_prices[$res2->entry_at] = $res2->total_amount;
        $vendor_dates[] = $res2->entry_at;

        // Collect all unique entry_at dates
        if (!in_array($res2->entry_at, $all_entry_dates)) {
            $all_entry_dates[] = $res2->entry_at;
        }
    }

    // Store this vendor's data in the vendors_data array
    $vendors_data[] = [
        'vendor_name' => $res->vendor_name,
        'prices' => $vendor_prices // Now this is a dictionary with entry_at as key and price as value
    ];


// Sort all entry_at dates in ascending order
sort($all_entry_dates);

// Send the response as JSON
echo json_encode([
    'all_entry_dates' => $all_entry_dates,
    'vendors' => $vendors_data
]);

?>
