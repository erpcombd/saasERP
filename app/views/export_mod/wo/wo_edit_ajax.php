<?php
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$order_id=$data[0];
$info = $data[1];
$in = explode('<@>',$info);


$get_item=explode('#',$in[0]);
$get_item_id=$get_item[1];
$get_measurement = $in[1];
$get_size = $in[2];
$get_po_no = $in[3];
$get_style_no = $in[4];
$get_color = $in[5];
$get_total_weight = $in[6];
$get_unit_price = $in[7];
$get_total_unit = $in[8];
$get_total_amt = $in[9];
$get_remarks = $in[10];
 

			    $new_sql="UPDATE `sale_do_details_foreign` SET 
			 item_id = '".$get_item_id."',
			`measurement` = '".$get_measurement."',
			`size` = '".$get_size."',
			`po_no` = '".$get_po_no."',
			`style_no` = '".$get_style_no."',
			`color` = '".$get_color."',
			`total_weight` = '".$get_total_weight."',
			`unit_price` = '".$get_unit_price."',
			`total_unit` = '".$get_total_unit."',
			`total_amt` = '".$get_total_amt."',
			`remarks` = '".$get_remarks."'
			
			 WHERE `id` ='".$order_id."'";
			
			db_query($new_sql);
?>
<input name="<?='edit#'.$order_id?>" type="button" id="<?='edit#'.$order_id?>" value="Edit" style="width:50px; height:30px; color:#000; font-weight:700; " onclick="submitButtonStyle(this);update_edit(<?=$order_id?>)" />