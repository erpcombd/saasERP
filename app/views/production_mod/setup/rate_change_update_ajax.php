<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$str = $_POST['data'];
$data=explode('##',$str);
$item_id = $data[0];
$val = $data[1];
$data=explode('#',$val);

$pack_size=$data[0];
$m_price=$data[1];
$d_price=$data[2];
$t_price=$data[3];
$f_price=$data[4];
$status=$data[5];


$now = date('Y-m-d H:i:s');
$entry_by=$_SESSION['user']['id'];

$change_date=date('Y-m-d');

$backup_data = find_all_field('item_info','','item_id='.$item_id);



    $sql = 'update item_info set  
	pack_size="'.$pack_size.'", m_price="'.$m_price.'",  d_price="'.$d_price.'", t_price="'.$t_price.'",  f_price="'.$f_price.'", 
	 status="'.$status.'" where item_id='.$item_id;
db_query($sql);
echo 'Updated!';
?>