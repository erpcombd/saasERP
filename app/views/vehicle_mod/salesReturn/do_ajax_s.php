<?php

session_start();

require_once "../../../assets/support/inc.all.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



$str = $_POST['data'];

$data=explode('##',$str);

$item=$data[0];

$finish_goods_code = $item;

echo $depot_id = $data[1];



$item_all= find_all_field('item_info','','finish_goods_code="'.$finish_goods_code.'"');

$in_stock_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" ');


//$ordered_qty = find_a_field('sale_do_details','sum(total_unit)','item_id="'.$item_all->item_id.'" and depot_id="'.$depot_id.'" and status in ("UNCHECKED","CHECKED","PROCESSING")');

//$del_qty = find_a_field('sale_do_chalan','sum(total_unit)','item_id="'.$item_all->item_id.'" and depot_id="'.$depot_id.'" and status in ("UNCHECKED","CHECKED","PROCESSING")');



$in_stock = ($in_stock_pcs / $item_all->pack_size);

?>

<script language="javascript">
if(document.getElementById("item").value>0 && document.getElementById("item").value=='<?php echo $finish_goods_code?>'){
alert('You Have Chosen Same Item Twice');
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

<td><input name="item2" type="text" class="input3" id="item2"  style="width:260px;" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('pkt_unit')"/></td>

<td><input name="in_stock" pattern="[1-9]" type="text" class="input3" id="in_stock"  style="width:55px;" value="<?=$in_stock?>" readonly onfocus="focuson('pkt_unit')"/>

<input name="item_id" type="hidden" class="input3" id="item_id"  style="width:55px;"  value="<?=$item_all->item_id?>" readonly/></td>

<td><input name="undel" type="text" class="input3" id="undel"  style="width:55px;" readonly  value="<?=(int)(($ordered_qty+$del_qty) / $item_all->pack_size)?>"/></td>




<td>

<input name="unit_price" type="hidden" class="input3" id="unit_price"  style="width:55px;" value="<?=$item_all->s_price?>"/>
<input name="unit_price2" type="text" class="input3" id="unit_price2"  style="width:55px;" value="<?=($item_all->s_price*$item_all->pack_size)?>" onkeydown="count()"/>

<input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:55px;"  value="<?=$item_all->pack_size?>" readonly/>

<input  name="s_price" type="hidden" id="s_price" value="<?=$item_all->s_price?>" readonly/></td>




    </tr>

  </table>

