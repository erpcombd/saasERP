<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_AUTH."db_con_live_static.php";


date_default_timezone_set('Asia/Dhaka');



$pdata  = file_get_contents("php://input");
$result = json_decode($pdata); 

$dealer_code      = $result[0]->dealer_code;




// $area_id       = $result[0]->area_id;


//query 


$sql1="SELECT item_id, item_name, category_id, subcategory_id, finish_goods_code, unit_name, pack_size, t_price FROM ssn_item_info where product_nature='Salable' limit 2;";


$query = mysqli_query($new_conn,$sql1);  


$data = array();
while($info = mysqli_fetch_object($query)) {
// 	$getdata=[
// 		'route_id'=>$info->route_id,
// 		'route_name'=>$info->route_name
// 	];

    $info->item_name= preg_replace('/[^A-Za-z0-9\-]/', '',  $info->item_name);
    // $info->item_stock=find_a_field('ssn_journal_item','sum(item_in-item_ex)','item_id='.$info->item_id.' and warehouse_id='.$dealer_code.'');
     $getdata=$info;
	array_push($data, $getdata);
}


echo json_encode($data);
mysqli_close($new_conn);

?>