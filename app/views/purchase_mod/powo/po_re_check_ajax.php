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

$sql_pr_id = "select id from purchase_receive where order_no='".$order_id."'  ";
$pr_id = find_a_field_sql($sql_pr_id);

$warehouse_id = $in[0];
$pkt_size = $in[1];
$pkt_unit = $in[2];
$qty = $in[3];
$unit_price = $in[4];
$amount = $in[5];

			   $po_sql="UPDATE `purchase_invoice` SET 
			 warehouse_id = '".$warehouse_id."',
			`pkt_size` = '".$pkt_size."',
			`pkt_unit` = '".$pkt_unit."',
			`qty` = '".$qty."',
			`rate` = '".$unit_price."', 
			`amount` = '".$amount."'
			 WHERE `id` ='".$order_id."'";
			db_query($po_sql);
			
			$pr_sql="UPDATE `purchase_receive` SET 
			 warehouse_id = '".$warehouse_id."',
			`pkt_size` = '".$pkt_size."',
			`pkt_unit` = '".$pkt_unit."',
			`qty` = '".$qty."',
			`rate` = '".$unit_price."', 
			`amount` = '".$amount."'
			 WHERE `id` ='".$pr_id."'";
			db_query($pr_sql);
			
			$ji_sql="UPDATE `journal_item` SET 
			 warehouse_id = '".$warehouse_id."',
			`item_in` = '".$qty."',
			`item_price` = '".$unit_price."'
			 WHERE `tr_no` ='".$pr_id."' and tr_from='Purchase'";
			db_query($ji_sql);
?>
<input name="<?='edit#'.$order_id?>" type="button" id="<?='edit#'.$order_id?>" value="Edit" style="width:50px; height:30px; color:#000; font-weight:700; " onclick="submitButtonStyle(this);update_edit(<?=$order_id?>)" />