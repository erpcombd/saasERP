<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_AUTH."db_con_live_static.php";


date_default_timezone_set('Asia/Dhaka');




$pdata  = file_get_contents("php://input");
$result = json_decode($pdata); 




$dealer_code      = $result[0]->dealer_code;


//query 
$sql1="select * from ssn_shop where  master_dealer_code = '".$dealer_code."' ";

$query = mysqli_query($new_conn,$sql1);  


$data = array();
while($info = mysqli_fetch_object($query)) {

$getdata = [
    "shop_id" => $info->shop_id,
    "emp_code" => $info->emp_code,
    "shop_name" => $info->shop_name,
    // "shop_owner_name" => $info->shop_owner_name,
    // "manager_name" => $info->manager_name,
    // "manager_mobile" => $info->manager_mobile,
    // "master_dealer_code" => $info->master_dealer_code,
    // "product_group" => $info->product_group,
    // "target_shop" => $info->target_shop,
    // "market_id" => $info->market_id,
    // "route_id" => $info->route_id,
    // "area_id" => $info->area_id,
    // "zone_id" => $info->zone_id,
    // "region_id" => $info->region_id,
    // "shop_class" => $info->shop_class,
    // "shop_type" => $info->shop_type,
    // "shop_channel" => $info->shop_channel,
    // "shop_route_type" => $info->shop_route_type,
    // "shop_identity" => $info->shop_identity,
    // "mobile" => $info->mobile,
    // "shop_address" => $info->shop_address,
    // "status" => $info->status,
    // "otp" => $info->otp,
    // "latitude" => $info->latitude,
    // "longitude" => $info->longitude,
    // "picture" => $info->picture,
    // "picture_sm" => $info->picture_sm,
    // "image_compress" => $info->image_compress,
    // "copy_done" => $info->copy_done,
    // "entry_by" => $info->entry_by,
    // "entry_at" => $info->entry_at
];


	array_push($data, $getdata);
}


echo json_encode($data);
mysqli_close($new_conn);

?>