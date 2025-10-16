<?php
session_start();
require_once "../../../assets/support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);

$order_no=$data[0];

$pi = find_all_field('purchase_invoice','','id="'.$data[0].'"');
?>
<input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:50px;"  value="<?=$pi->unit_name?>"  readonly required/>

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$pi->warehouse_id?>"/>
<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$pi->vendor_id?>"/>
<input  name="item_id" type="hidden" id="item_id" value="<?=$pi->item_id?>"/>
<input  name="rate" type="hidden" id="rate" value="<?=$pi->rate?>"/>
<input  name="order_no" type="hidden" id="order_no" value="<?=$order_no?>"/>
