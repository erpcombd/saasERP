<?php
include ("../config/db.php");
include ("../config/function.php");

date_default_timezone_set('Asia/Dhaka');

$servername = "localhost";

$username = "ezzyerp_uand";
$password = "Z?ogY]4FSj2p";
$dbname = "ezzyerp_android";


$conn = new mysqli($servername, $username, $password, $dbname);


// $pdata  = file_get_contents("php://input");
// $result = json_decode($pdata); 




// $area_id       = $result[0]->area_id;


//query 
$sql1="select id,subcategory_name,category_id from ssn_item_subcategory";

$query = mysqli_query($conn,$sql1);  


$data = array();
while($info = mysqli_fetch_object($query)) {
// 	$getdata=[
// 		'route_id'=>$info->route_id,
// 		'route_name'=>$info->route_name
// 	];
     $getdata=$info;
	array_push($data, $getdata);
}


echo json_encode($data);
mysqli_close($conn);

?>