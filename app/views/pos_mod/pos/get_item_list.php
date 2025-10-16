<?php
session_start();
require_once "../../../assets/support/inc.all.php";
$con= "";
if(isset($_REQUEST['item_info']) && $_REQUEST['item_info']!=""){
    $con.=" and (item_name like '%".$_REQUEST['item_info']."%'";
    $con.=" or finish_goods_code like '%".$_REQUEST['item_info']."%') ";
	$cus_sql = "select * from item_info where 1 ".$con;

	$cus_query = mysql_query($cus_sql);

	while($data = mysql_fetch_assoc($cus_query)){
     
     extract($data);
     
     $all_dealer[] = $item_name."::".$finish_goods_code;
    
    }
	echo json_encode($all_dealer);
}

?>