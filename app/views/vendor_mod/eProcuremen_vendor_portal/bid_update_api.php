<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

header('Content-Type: text/html');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


// Read the JSON input
$input = json_decode(file_get_contents('php://input'), true);

$rfq_name = $input['rfq_no'] ?? '';
$item_id = $input['item_id'] ?? '';
$user_id = $input['user_id'] ?? '';
$bid_amount = $input['bid_amount'] ?? '';
$bid_currency = $input['bid_currency'] ?? '';
$response_id = $input['response_id'] ?? '';
$item_details_id = $input['item_details_id'] ?? '';

$item_name = find_a_field('item_info','item_name','item_id="'.$item_id.'"');


$rfq_master = find_all_field('rfq_master','','rfq_no="'.$rfq_name.'"');
$rfq_item_details_data = find_all_field('rfq_item_details','','item_id="'.$item_id.'" and rfq_no="'.$rfq_name.'" ');
$info=[];
$tie_value_flag='yes';


$sql_each_rank2='WITH VendorMinPrices AS (
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
    rid.ceiling_value, 
    rid.visibility_start,  
    rid.visibility_end   
FROM 
    RankedVendors rv
JOIN 
    rfq_item_details rid ON rv.rfq_no = rid.rfq_no AND rv.item_id = rid.item_id
WHERE 
    rv.vendor_id = "'.$user_id.'"
    and 
    rv.item_id="'.$item_id.'"
';
$qry_each_rank2 = db_query($sql_each_rank2);
$data_each_rank2=mysqli_fetch_object($qry_each_rank2);

$previous_rank=$data_each_rank2->price_rank;

$auction_type='reverse_auction';

$bid_ceiling_flag='false';

if (empty($rfq_item_details_data->ceiling_value)) {
    $bid_ceiling_flag = 'true';
} else if ($bid_amount < $rfq_item_details_data->ceiling_value) {

    $bid_ceiling_flag = 'true';
}



$minumum_improve_restriction_flag='true';
if(!empty($data_each_rank2->min_unit_amount)){
if($bid_amount>$data_each_rank2->min_unit_amount){
    $minumum_improve_restriction_flag='false';
}else{
    $minumum_improve_restriction_flag='true';
}
}










$same_value_count = find_a_field('rfq_vendor_item_response','count(id)','item_id="'.$item_id.'" and rfq_no="'.$rfq_name.'" and vendor_id="'.$user_id.'" and unit_price= "'.$bid_amount.'"');
if($rfq_master->tie_bids=='no'){
$tie_bid_value_count = find_a_field('rfq_vendor_item_response','count(id)','item_id="'.$item_id.'" and rfq_no="'.$rfq_name.'" and  unit_price= "'.$bid_amount.'" and vendor_id !="'.$user_id.'"');
if($tie_bid_value_count>0)
{
$tie_value_flag='no';
}
}
if($bid_ceiling_flag=='true'){
if($tie_value_flag=='yes'){

if($same_value_count>0){
$info['status']='failed';
$info['alertmsg']='<div class="alert alert-danger" role="alert">You can not enter same value twice for item '.$item_name.'</div';
}
else{
if($minumum_improve_restriction_flag=='true'){
if($bid_amount%$rfq_master->improve_bid_amt==0){
// Get the current time
$current_time = new DateTime();

$Crud   = new Crud("rfq_vendor_item_response");

$_POST['vendor_id']=$user_id;
// $_POST['expected_qty']=$doc->expected_qty;
// $_POST['unit_price']=$_POST['vendor_price'.$doc->id];
// $_POST['total_amount']=$_POST['vendor_total_amount'.$doc->id];
// $_POST['need_by']=$_POST['need_by'.$doc->id];
$_POST['item_id']=$item_id;
$_POST['rfq_no']=$rfq_name;
$_POST['section_id'] = $response_id;
$_POST['event_item_details_id']=$item_details_id;

$_POST['currency']=$bid_currency;
$_POST['unit_price']=$bid_amount;
$_POST['entry_at']= date('Y-m-d H:i:s');

$_POST['entry_by']=$user_id;;

$Crud->insert();
$info['status']='success';
$info['alertmsg']='<div class="alert alert-success" role="alert">Bid Successfully placed for item '.$item_name.'</div';
$info['ceiling_value']=$rfq_item_details_data->ceiling_value;
$info['bid_amount']=$bid_amount;


 $sql_each_vendor = 'SELECT 
rvr.entry_at, 
rvr.rfq_no, 
rvr.vendor_id, 
rvr.item_id, 
rvr.unit_price,
rid.expected_qty
FROM 
rfq_vendor_item_response rvr
JOIN (
SELECT 
    item_id, 
    MIN(unit_price) AS lowest_unit_price
FROM 
    rfq_vendor_item_response 
WHERE 
    rfq_no = "'.$rfq_name.'" 
    AND vendor_id = "'.$user_id.'" 
GROUP BY 
    item_id
) AS min_prices 
ON 
rvr.item_id = min_prices.item_id 
AND rvr.unit_price = min_prices.lowest_unit_price
JOIN 
rfq_item_details rid 
ON 
rvr.rfq_no = rid.rfq_no 
AND rvr.item_id = rid.item_id
WHERE 
rvr.rfq_no = "'.$rfq_name.'" 
AND rvr.vendor_id = "'.$user_id.'"';



$current_total=0;

$qry_each_vendor = db_query($sql_each_vendor);
while ($res2 = mysqli_fetch_object($qry_each_vendor)) {

$total=$res2->unit_price*$res2->expected_qty;

$current_total =$current_total+$total;

}








$sql_auction_history_graph='INSERT INTO auction_graph_history (rfq_no, vendor_id, entry_at, total_amount, changed_item_id, change_item_new_amount)
VALUES ("'.$rfq_name.'", "'.$user_id.'", "'.date('Y-m-d H:i:s').'", "'.$current_total.'", "'.$item_id.'", '.$bid_amount.');
';
db_query($sql_auction_history_graph);
if($previous_rank<=$rfq_master->rank_tringgers_overtime)
{

}else{





//auto time extend

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
    rid.visibility_start,  
    rid.visibility_end   
FROM 
    RankedVendors rv
JOIN 
    rfq_item_details rid ON rv.rfq_no = rid.rfq_no AND rv.item_id = rid.item_id
WHERE 
    rv.vendor_id = "'.$user_id.'"
    and 
    rv.item_id="'.$item_id.'"
';
$qry_each_rank = db_query($sql_each_rank);
$data_each_rank=mysqli_fetch_object($qry_each_rank);








$end_time = new DateTime($data_each_rank->visibility_end);
$end_time_master = new DateTime($rfq_master->eventEndAt);

$current_time = new DateTime();
$interval = $end_time->diff($current_time);
$minutes_difference = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

if ($minutes_difference <= $rfq_master->submitted_within_minutes) {
 
    if ($data_each_rank->price_rank <= $rfq_master->rank_tringgers_overtime) {
        $overtime_period_minutes = $rfq_master->overtime_period;
        $end_time->modify("+$overtime_period_minutes minutes");
        $end_time_master->modify("+$overtime_period_minutes minutes");
        $updated_visibility_end = $end_time->format('Y-m-d H:i:s');
        $updated_master_end_time = $end_time_master->format('Y-m-d H:i:s');
        
        $event_end_date = $end_time_master->format('Y-m-d');  // Extracting the date (YYYY-MM-DD)
        $event_end_time = $end_time_master->format('H:i:s');

        
      $sql_time_update='UPDATE rfq_item_details 
                SET visibility_end = "'.$updated_visibility_end.'" WHERE rfq_no="'.$data_each_rank->rfq_no.'" ';
        db_query($sql_time_update);


        $sql_time_update_master = 'UPDATE rfq_master 
        SET eventEndAt = "'.$updated_master_end_time.'", 
            eventEndDate = "'.$event_end_date.'", 
            eventEndTime = "'.$event_end_time.'" 
        WHERE rfq_no = "'.$data_each_rank->rfq_no.'"';
    db_query($sql_time_update_master);

    $info['changeclock']='yes';
    $info['eventEndDate']=$event_end_date;
    $info['eventEndTime']=$event_end_time;
    $info['sql']=$sql_time_update_master;
    

    }
}

}










}else{
    $info['status']='failed';
    $info['alertmsg']='<div class="alert alert-danger" role="alert"> Minimum Bid improve value should be '.$rfq_master->improve_bid_amt.' for item '.$item_name.'</div';  
}

}else{
    $info['status']='failed';
    $info['alertmsg']='<div class="alert alert-danger" role="alert">You can not enter value greater than your previous bid for item '.$item_name.'</div'; 

}

}
}
else{
    $info['status']='failed';
    $info['alertmsg']='<div class="alert alert-danger" role="alert">This value is already placed by another person please improve your bid for item '.$item_name.'</div';   
}
}else{
    $info['status']='failed';
    $info['alertmsg']='<div class="alert alert-danger" role="alert">You can not place the bid more than ceilng value for item '.$item_name.'</div';
}
echo json_encode($info);
