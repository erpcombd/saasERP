<?php
//error_reporting(E_ALL);
session_start();
include 'config/db.php';
include 'config/function.php';

$item_id        =$_POST['id'];

$info = findall("select * from item_info where item_id='".$item_id."'");

$price      = $info->nsp_amt;
$unit       = $info->unit_name;


$arr = array('price' => $price, 'unit' => $unit);

echo json_encode($arr);

?>