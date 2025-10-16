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


$qty = $in[0];
$rate_usd = $in[1];
$amount_usd = $in[2];
$rate_ud = $in[3];
$amount_ud = $in[4];
 $rate_bdt =$in[5];
 $amount_bdt = $in[6];
  $kg_qty = $in[7];
   $ctn_qty = $in[8];



			     $new_sql="UPDATE `lc_purchase_invoice` SET 
			 qty = '".$qty."',
			`rate_usd` = '".$rate_usd."',
			`amount_usd` = '".$amount_usd."',
			
			`rate_bdt` = '".$rate_bdt."',
			`amount_bdt` = '".$amount_bdt."',
			
			`rate_ud` = '".$rate_ud."',
			`amount_ud` = '".$amount_ud."',
			`kg_qty` = '".$kg_qty."',
			`ctn_qty` = '".$ctn_qty."'
			
			 WHERE `id` ='".$order_id."'";
			
			db_query($new_sql);
?>
<input name="<?='edit#'.$order_id?>" type="button" id="<?='edit#'.$order_id?>" value="Edit" style="width:50px; height:30px; color:#000; font-weight:700; " onclick="submitButtonStyle(this);update_edit(<?=$order_id?>)" />