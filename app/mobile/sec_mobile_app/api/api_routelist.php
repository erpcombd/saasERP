<?php
include ("../engine/config/db_con_live_static.php");
include ("../config/function.php");

date_default_timezone_set('Asia/Dhaka');




$pdata  = file_get_contents("php://input");
$result = json_decode($pdata); 




$area_id       = $result[0]->area_id;


//query 
$sql1="select route_id,route_name from ss_route where  area_id = '".$area_id."' ";

$query = mysqli_query($new_conn,$sql1);  


$data = array();
while($info = mysqli_fetch_object($query)) {
	$getdata=[
		'route_id'=>$info->route_id,
		'route_name'=>$info->route_name
	];

	array_push($data, $getdata);
}


echo json_encode($data);
mysqli_close($new_conn);

?>