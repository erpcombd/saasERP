<?php
include ("../config/db.php");
include ("../config/function.php");

date_default_timezone_set('Asia/Dhaka');




$pdata  = file_get_contents("php://input");
$result = json_decode($pdata);

// Extract data from the JSON array
 // Assuming this is the do_no from ss_do_master
$dealer_code    = $result[0]->dealer_code;
$do_no    = $result[0]->do_no; // Extracting do_status




// $area_id       = $result[0]->area_id;


//query 
 $sql1="select * from ssn_do_details where do_no = '$do_no'";

$query = mysqli_query($conn,$sql1);  


$data = array();
while($info = mysqli_fetch_object($query)) {
    
    	$getdata=[
    	'order_id'=>$info->id,
    	'shop_id'=>$info->dealer_code,
		'item_name'=>find_a_field('ssn_item_info','item_name','item_id='.$info->item_id.''),
		'rate'=>$info->t_price,
		'stock'=>find_a_field('ssn_journal_item','sum(item_in-item_ex)','item_id='.$info->item_id.' and warehouse_id='.$dealer_code.''),
		'orderquantity'=>$info->total_unit,
		'CQ'=>0,
		'do_no'=>$info->do_no,
		'item_id'=>$info->item_id,
		'dealer_code'=>$info->dealer_code,
		'unit_price'=>$info->unit_price,
		'nsp_per'=>$info->nsp_per,
		'total_unit'=>$info->total_unit,
		'total_amt'=>$info->total_amt,
		 'current_date'  => date('Y-m-d')
		
		
	];
   


    //  $getdata=$info;
	array_push($data, $getdata);
}


echo json_encode($data);
mysqli_close($conn);

?>