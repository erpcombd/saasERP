<?php
include ("../config/db.php");
include ("../config/function.php");

date_default_timezone_set('Asia/Dhaka');




$pdata  = file_get_contents("php://input");
$result = json_decode($pdata);

// Extract data from the JSON array
 // Assuming this is the do_no from ss_do_master
$dealercode    = $result[0]->dealercode; // Extracting do_status
$do_status    = $result[0]->do_status; // Extracting do_status




// $area_id       = $result[0]->area_id;


//query 
 $sql1="select * from ssn_do_master where status = '$do_status' and dealer_depot_id='$dealercode'";

$query = mysqli_query($conn,$sql1);  


$data = array();
while($info = mysqli_fetch_object($query)) {
   
    $info->shop_name=find_a_field('ss_shop','shop_name','dealer_code='.$info->dealer_code.'');

     $getdata=$info;
	array_push($data, $getdata);
}


echo json_encode($data);
mysqli_close($conn);

?>