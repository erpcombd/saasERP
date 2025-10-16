<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
$item=$data[0];
 
$group_id = $data[0];

$group_for = $data[1];

//auto_complete_from_db('item_info i, item_sub_group s','concat(i.item_id,"-> ",i.item_name)','i.item_id',' i.product_nature in ("Salable","Both") and i.status="Active" and i.sub_group_id=s.sub_group_id and s.group_id="'.$group_id.'"','i.item_id');
?>


<input name="item_id" type="text" value="" id="item_id" onblur="getData2('item_data_ajax.php', 'item_data_found2', this.value, document.getElementById('warehouse_id').value);" list="itemList2" autocomplete="off"/>
<datalist id="itemList2">
<? foreign_relation('item_info i,item_sub_group s','concat(i.item_id,"-> ",i.item_name,"->",i.item_id)','""',$item_id,'i.product_nature in ("Purchasable","Salable","Both") and i.status="Active" and i.group_for="'.$group_for.'" and i.sub_group_id=s.sub_group_id and s.group_id="'.$group_id.'" group by i.item_id')?>
</datalist>
