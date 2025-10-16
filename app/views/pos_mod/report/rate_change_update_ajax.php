<?php
session_start();
require_once "../../../assets/support/inc.all.php";



$str = $_POST['data'];
$data=explode('##',$str);
$item_id = $data[0];
$val = $data[1];
$data=explode('#',$val);

$pack_size=$data[0];
$m_price=$data[1];
$status=$data[2];


$now = date('Y-m-d H:i:s');
$entry_by=$_SESSION['user']['id'];

$change_date=date('Y-m-d');

$backup_data = find_all_field('item_info','','item_id='.$item_id);



    $sql = 'update item_info set  
	pack_size="'.$pack_size.'", m_price="'.$m_price.'", status="'.$status.'" where item_id='.$item_id;
mysql_query($sql);
echo 'Updated!';
?>