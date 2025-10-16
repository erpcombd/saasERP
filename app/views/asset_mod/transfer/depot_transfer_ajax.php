<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$str = $_POST['data'];

$data=explode('##',$str);
$itemData=explode("->",$data[0]);
$item_id= $itemData[1];
$product_type = find_a_field('item_info','item_type','item_id="'.$item_id.'"');

$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');
$item_in = find_a_field('journal_asset_item','sum(item_in)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$item_ex = find_a_field('journal_asset_item','sum(item_ex)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$in_stock = $item_in-$item_ex;

if($in_stock<0){
$new_stock = 0;
}else{
$new_stock = $in_stock;
}
?>

<table style="width:100%;" border="1">
	 <tr>
<td width="33%"><input name="total_unit2" type="text" class="input3" style="width:98%;" onfocus="focuson('total_pkt')" value="<?=$item_all->unit_name?>" readonly="readonly"/>    

<input name="pkt_size" id="pkt_size" type="hidden" value="<?=$item_all->pack_size?>"/></td>
<td width="33%"><input name="old_production_date" type="text" class="input3" id="stock2"  maxlength="100" style="width:98%;" value="<?=$new_stock?>" readonly="readonly"/></td>
	<?
				if($product_type=='Serialized'){
				
				?>
				<td width="33%"><span id="serial_check"></span>
				<input list="serial" name="serial_no" id="serial_no" style="width:170px;" onchange="check_serial()">
<?
 $sq = 'select serial_no,item_id from journal_asset_item where 1 and item_id="'.$item_id.'" and item_in>0 and warehouse_id="'.$_SESSION['user']['depot'].'" group by serial_no';
$qr = db_query($sq);
?>
<datalist id="serial">
<?
while($ro=mysqli_fetch_object($qr)){
$check_in = find_a_field('journal_asset_item','sum(item_in)','serial_no="'.$ro->serial_no.'" and item_id="'.$ro->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$check_ex = find_a_field('journal_asset_item','sum(item_ex)','serial_no="'.$ro->serial_no.'" and item_id="'.$ro->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$stock = $check_in-$check_ex;
if($stock>0){
echo '<option value="'.$ro->serial_no.'">'.$ro->serial_no.'</option>';
}
}
?>
</datalist>
</span>
</td>
<td align="center" bgcolor="#CCCCCC"><input name="total_unit" type="text" class="input3" id="total_unit" value="1"  style="width:115px;" required  onkeyup="total_amtt()" readonly/></td>
<? }else{?>
<td width="33%">
<input name="serial_no" id="serial_no" readonly style="width:170px;">
</td>
<td align="center" bgcolor="#CCCCCC"><input name="total_unit" type="text" class="input3" id="total_unit"  style="width:115px;" required  onkeyup="total_amtt()"/></td>
<? } ?>			
              

</tr></table>