<?php
session_start();
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$order_id=$data[0];
$info = $data[1];
$in = explode('<@>',$info);


$exp_date = $in[0];
$remarks = $in[1];
$qty = $in[2];

			$new_sql="UPDATE `requisition_order` SET 
			`exp_date` = '".$exp_date."',
			`remarks` = '".$remarks."',
			`qty` = '".$qty."' WHERE `id` ='".$order_id."'";
			
			db_query($new_sql);
?>
<input name="<?='edit#'.$order_id?>" type="button" id="<?='edit#'.$order_id?>" value="Edit" style="width:40px; height:20px; background-color:#009933;" onclick="update_edit(<?=$order_id?>)" />