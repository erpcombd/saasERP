<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$str = $_POST['data'];

$data=explode('##',$str);
$itemData=explode("#",$data[0]);
$item_id= $itemData[2];
$asset_tag = $itemData[0];
$item_info = find_all_field('item_info','','item_id="'.$item_id.'"');
if($item_info->item_type=='Serialized'){
$item_rate = find_a_field('journal_asset_item','item_price','item_id="'.$item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" and asset_tag="'.$asset_tag.'"');
?>


<input class="form-control" list="serial" name="serial_no" id="serial_no" />
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
<? }else{ echo 'Non-Serialized';
$item_rate = find_a_field('journal_asset_item','item_price','item_id="'.$item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" and asset_tag="'.$asset_tag.'"');
 }?>
<input type="hidden" name="unit_price" id="unit_price" value="<?=$item_rate?>" />