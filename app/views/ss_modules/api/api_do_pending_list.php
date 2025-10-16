<?php
include ("../config/db.php");
include ("../config/function.php");

date_default_timezone_set('Asia/Dhaka');



$pdata  = file_get_contents("php://input");
$result = json_decode($pdata); 

$do_no      = $result[0]->do_no;




// $area_id       = $result[0]->area_id;


//query 


// $sql1="SELECT item_id, total_unit,total_amt FROM ss_do_details where do_no=$do_no";
$sql1="SELECT item_id, total_unit,total_amt FROM ssn_do_details where do_no='".$do_no."'";


$query = mysqli_query($conn,$sql1);  


$data = array();
while($info = mysqli_fetch_object($query)) {
	$getdata=[
	    'item_name'=>find_a_field('ssn_item_info','item_name','item_id='.$info->item_id.''),
		'item_id'=>$info->item_id,
		'total_amount'=>$info->total_amt,
		'total_quantity'=>$info->total_unit
	];

    // $info->item_name= preg_replace('/[^A-Za-z0-9\-]/', '',  $info->item_name);
    // $info->item_stock=find_a_field('ss_journal_item','sum(item_in-item_ex)','item_id='.$info->item_id.' and warehouse_id='.$dealer_code.'');
    //  $getdata=$info;
	array_push($data, $getdata);
}


echo json_encode($data);
mysqli_close($conn);

?>