<?php

session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$item_id =$_POST['id'];
$info = findall("select * from item_info where item_id='".$item_id."'");
$price      = $info->d_price;
$unit       = $info->unit_name;
$arr = array('price' => $price, 'unit' => $unit);
echo json_encode($arr);

?>