<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

header('Content-Type: text/html');

// Read the JSON input
$input = json_decode(file_get_contents('php://input'), true);

$rfq_name = $input['rfq_no'] ?? '';
 $bid_amount = $input['bid_amount'] ?? '';
$bid_currency = $input['bid_currency'] ?? '';
$user_id = $input['user_id'] ?? '';

// Get the current time
$current_time = new DateTime();
$lead_bid='';
// $rfq_sql='SELECT * FROM rfq_master WHERE rfq_no="'..'"'
$rfq_master = find_all_field('rfq_master','','rfq_no="'.$rfq_name.'"');
$response_data = [];
// Query to get the relevant rows

$sql = 'SELECT d.*, i.item_name FROM rfq_item_details d, item_info i WHERE i.item_id = d.item_id AND rfq_no = "'.$rfq_name.'"';
$qry = db_query($sql);

// while ($res = mysqli_fetch_object($qry)) {
//     // Get the showtime and endtime
//     $showtime = new DateTime($res->visibility_start);
//     $endtime = new DateTime($res->visibility_end);
 $sql_each_rank='WITH VendorMinPrices AS (
    SELECT 
        rv.rfq_no, 
        rv.item_id, 
        rv.vendor_id, 
        MIN(rv.unit_price) AS min_unit_amount 
    FROM 
        rfq_vendor_item_response rv
    WHERE 
        rv.rfq_no = "'.$rfq_name.'" 
    GROUP BY 
        rv.rfq_no, rv.item_id, rv.vendor_id
),
RankedVendors AS (
    SELECT 
        vmp.rfq_no, 
        vmp.item_id, 
        vmp.vendor_id, 
        vmp.min_unit_amount, 
        RANK() OVER (PARTITION BY vmp.rfq_no, vmp.item_id ORDER BY vmp.min_unit_amount ASC) AS price_rank 
    FROM 
        VendorMinPrices vmp
)
SELECT 
    rv.rfq_no, 
    rv.item_id, 
    rv.vendor_id, 
    rv.min_unit_amount, 
    rv.price_rank, 
    rid.expected_qty,
    rid.visibility_start,  
    rid.visibility_end   
FROM 
    RankedVendors rv
JOIN 
    rfq_item_details rid ON rv.rfq_no = rid.rfq_no AND rv.item_id = rid.item_id
WHERE 
    rv.vendor_id = "'.$user_id.'"
';
$qry_each_rank = db_query($sql_each_rank);
// $each_item_rank_information=mysqli_fetch_object($qry_each_rank);
while ($res = mysqli_fetch_object($qry_each_rank)) {
    $lead_bid=find_a_field('rfq_vendor_item_response','MIN(unit_price)','item_id="'.$res->item_id.'" and rfq_no="'.$rfq_name.'" ');
   $show_status='expired';
   $showtime = new DateTime($res->visibility_start);
   $endtime = new DateTime($res->visibility_end);
   if ($current_time >= $showtime && $current_time <= $endtime) {
    $show_status='active';

   }
    $response_data[] = [
        'rfq_no' => $res->rfq_no,
        'item_id' => $res->item_id,
        'vendor_id' => $res->vendor_id,
        'min_unit_amount' => $res->min_unit_amount,
        'price_rank' => $res->price_rank,
        'show_status'=>$show_status,
        'total_amount'=>$res->expected_qty*$res->min_unit_amount,
        'lead_bid'=>$lead_bid,
        'event_end_date'=>$rfq_master->eventEndDate,
        'event_end_time'=>$rfq_master->eventEndTime,
        'event_end_datetime'=>$rfq_master->eventEndAt,

    ];


    
}

    

    
    // }
    echo json_encode($response_data);
    ?>
