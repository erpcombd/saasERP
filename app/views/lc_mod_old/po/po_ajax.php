<?php
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$item=explode('-',$data[0]);
$item_all= find_all_field('item_info','','item_id="'.$item[0].'"');
 $warehouse_id = $data[1];
//$stock = (int)(warehouse_product_stock($item[1] ,$warehouse_id));

//echo $item_id=$item_all->item_id;
?>
<table>
<tr>

<td>
<input name="unit_name" type="text" class="input3" id="unit_name" style="width:80px; height:32px;" value="<?=$item_all->unit_name?>" readonly required/>
<input name="pkt_size" type="hidden" class="input3" id="pkt_size" style="width:80px; height:32px;" onchange="count()" value="<?=$item_all->pack_size?>" readonly required/>
</td>

</tr>
</table>