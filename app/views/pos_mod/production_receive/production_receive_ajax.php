<?php
session_start();
require_once "../../../assets/support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$item=explode('#>',$data[0]);
$item_id=$item[2];
$warehouse_id = $_SESSION['user']['depot'];
$warehouse_from = $data[1];
$stock = warehouse_product_stock($item_id ,$warehouse_id);

$last_p = find_all_field('production_receive_detail','','item_id="'.$item[2].'" and warehouse_from = "'.$warehouse_from.'" order by id desc');
$item_all= find_all_field('item_info','','item_id="'.$item[2].'"');
?>
<table style="width:100%;" border="1">
						 <tr>
<td width="25%"><input name="total_unit2" type="text" class="input3" style="98%" onfocus="focuson('total_unit')" value="<?=$item_all->unit_name?>"/></td> 
<td width="25%"><input name="total_unit3" type="text" class="input3" style="98%" onfocus="focuson('total_unit')" value="<?=$stock?>"/></td>    
<td width="25%"><input name="total_unit4" type="text" class="input3" style="98%" onfocus="focuson('total_unit')" value="<?=$last_p->total_unit?>"/>  </td>     
<td width="25%"><input name="total_unit5" type="text" class="input3" style="98%" onfocus="focuson('total_unit')" value="<?=$last_p->pr_date?>"/> </td> 
</tr>
</table>