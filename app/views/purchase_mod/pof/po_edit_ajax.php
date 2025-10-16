<?php
session_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$order_id=$data[0];
$info = $data[1];
$in = explode('<@>',$info);


$pkt_size = $in[0];
$pkt_unit = $in[1];
$qty = $in[2];
$unit_price = $in[3];
$amount = $in[4];

			  $new_sql="UPDATE `purchase_invoice` SET 
			`pkt_size` = '".$pkt_size."',
			`pkt_unit` = '".$pkt_unit."',
			`qty` = '".$qty."',
			`rate` = '".$unit_price."', 
			`amount` = '".$amount."'
			
			 WHERE `id` ='".$order_id."'";
			
			db_query($new_sql);
?>
<input name="<?='edit#'.$order_id?>" type="button" id="<?='edit#'.$order_id?>" value="Edit" style="width:50px; height:30px; color:#000; font-weight:700; " onclick="submitButtonStyle(this);update_edit(<?=$order_id?>)" />