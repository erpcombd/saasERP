<?php
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

$str = $_POST['data'];

$data=explode('##',$str);

$item=explode('#>',$data[0]);

$item_id=$item[1];


$item_all= find_all_field('item_info','','item_id="'.$item[1].'"');
/*$item_in = find_a_field('journal_item','sum(item_in)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" ');
$item_ex = find_a_field('journal_item','sum(item_ex)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" ');
$in_stock = $item_in-$item_ex;*/
?>

<table style="width:100%;" border="1">
	 <tr>
<td width="33%"><input name="uom" type="text" class="input3" style="width:98%;" value="<?=$item_all->unit_name?>" readonly="readonly"/></td>
</tr></table>