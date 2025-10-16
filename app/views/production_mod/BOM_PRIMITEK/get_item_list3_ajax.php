<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
$item=$data[0];
 
$group_for = $data[0];


?>


<input name="fg_item_id" type="text" value="" id="fg_item_id" list="lists" >
<datalist id="lists">

<? foreign_relation('item_info i,item_sub_group s','i.item_id','i.item_name',$item_id,'i.product_nature in ("Purchasable","Salable","Both") and i.status="Active"  and i.group_for="'.$group_for.'" and i.sub_group_id=s.sub_group_id  group by i.item_id')?>


</datalist>

