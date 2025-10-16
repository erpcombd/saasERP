<?php
session_start();

require_once "../../../assets/support/inc.all.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



 $str = $_POST['data'];

$data=explode('##',$str);

$item=$data[0];

$finish_goods_code = $item;

$depot_id = $data[1];





$item_all= find_all_field('item_info','','finish_goods_code="'.$finish_goods_code.'"');

$in_stock_pcs = find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$depot_id.'" ');


//$ordered_qty = find_a_field('sale_do_details','sum(total_unit)','item_id="'.$item_all->item_id.'" and depot_id="'.$depot_id.'" and status in ("UNCHECKED","CHECKED","PROCESSING")');

//$del_qty = find_a_field('sale_do_chalan','sum(total_unit)','item_id="'.$item_all->item_id.'" and depot_id="'.$depot_id.'" and status in ("UNCHECKED","CHECKED","PROCESSING")');



$in_stock = $in_stock_pcs;

?>

<script language="javascript">
if(document.getElementById("item").value>0 && document.getElementById("item").value=='<?php echo $finish_goods_code?>'){
alert('You Have Chosen Same Item Twice');
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

<td style="width:0%;"><input name="item2" type="text" class="input3" id="item2"  style="width:260px;margin-right:-12px;" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('pkt_unit')"/></td>




<td style="width:0%;"><input name="in_stock" pattern="[1-9]" type="text" class="input3" id="in_stock"  style="width:70px;margin-right:-19px;" value="<?=$in_stock?>" readonly="readonly" onfocus="focuson('pkt_unit')"/>

<input name="item_id" type="hidden" class="input3" id="item_id"  style="width:60px;"  value="<?=$item_all->item_id?>" readonly="readonly"/>
<input name="carton_qty" type="hidden" class="input3" id="carton_qty"  style="width:60px;"  value="<?=$item_all->carton_qty?>" readonly="readonly"/></td>


<td style="width:0%;"><input name="dist_unit" type="text" class="input3" id="dist_unit"  style="width:55px;margin-right: -14px;margin-left: 25px;" onkeyup="count();dope_count()" value=""/></td>

<!--<td><input name="undel" type="hidden" class="input3" id="undel"  style="width:55px;" readonly="readonly"  value="<?=(int)(($ordered_qty+$del_qty) / $item_all->pack_size)?>"/></td>
-->

<td style="width:0%"><input name="unit_name2" type="text" class="" id="unit_name2"  style="width:60px;margin-left: 6px; margin-right: -13px;"  value="<?=$item_all->unit_name;?>" readonly/></td>
<td style="width:0%">

<input name="unit_price" type="hidden" class="input3" id="unit_price"  style="width:55px;" value="<?=$item_all->s_price?>"/>
<input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:55px;"  value="<?=$item_all->pack_size?>" readonly="readonly"/>

<input  name="s_price" type="hidden" id="s_price" value="<?=$item_all->s_price?>" readonly="readonly"/>
<input name="unit_price2" type="text" class="input3" id="unit_price2"  style="width:85px;" value="<?=($item_all->s_price*$item_all->pack_size)?>" onkeyup="count()"/></td>
    </tr>
  </table>

