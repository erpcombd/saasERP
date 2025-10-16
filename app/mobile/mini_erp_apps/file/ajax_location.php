<?php
//error_reporting(E_ALL);
session_start();
include 'config/db.php';
include 'config/function.php';

$dealer_code =$_POST['id'];

$info = findall("select * from ss_shop where dealer_code='".$dealer_code."'");

$lat      = $info->latitude;
$long      = $info->longitude;




//$arr = array('price' => $price, 'cost_rate' => $cost_rate, 'stock' => $stock, 'unit' => $unit);

$arr = array('lat2' => $lat, 'long2' => $long);

echo json_encode($arr);

?>