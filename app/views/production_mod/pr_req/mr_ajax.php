<?php


session_start();


require "../../support/inc.all.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');





$str = $_POST['data'];


$data=explode('##',$str);


$item=explode('#>',$data[0]);


 $item_id = $item[2];

$var = $data[1];
$warehouse=explode('#-#',$var);
$warehouse_id=$warehouse[0];
$pl_id=$warehouse[1];
if($item_id>0){

//$stock_pl = warehouse_product_stock($item_id ,$pl_id);
$stock_pl=find_a_field('journal_item','sum(item_in-item_ex)','warehouse_id='.$pl_id.' and item_id='.$item_id.' ');
//$stock = warehouse_product_stock($item_id ,$warehouse_id);_sield(
$stock=find_a_field('journal_item','sum(item_in-item_ex)','warehouse_id='.$warehouse_id.' and item_id='.$item_id.'');
$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');


// $s_journal =  find_a_field('journal_item','SUM(item_in)','item_id="'.$item_id.'" and tr_from="Purchase"');

$s_journal =  find_a_field('purchase_master a, purchase_invoice b, purchase_receive c, item_info i, item_sub_group s, item_group g, requisition_master r ,requisition_order rr','sum(c.qty)','r.req_no=rr.req_no and b.req_id=rr.id and  a.po_no=b.po_no and b.id=c.order_no and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and b.item_id=i.item_id  and b.item_id="'.$item_id.'"');


$s_req =  find_a_field('requisition_order b,requisition_master a','SUM(b.qty)',' a.req_no=b.req_no and a.status in ("PENDING","CHECKED") and b.item_id='.$item_id);

$s_pqty = ($s_req-$s_journal);

}




?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input  name="floor" type="text" id="floor" style="width:55px;"  value="<?=number_format($stock_pl,2)?>"/></td>
    <td><input name="pqty" type="text" class="input3" id="pqty" style="width:60px;" value="<?=number_format($s_pqty,2)?>" onfocus="focuson('qty')" readonly/> </td>
    <td><input name="qoh" type="text" class="input3" id="qoh" style="width:60px;" value="<?=number_format($stock,2)?>" onfocus="focuson('qty')" readonly/> </td>
    <td>
<input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:30px;" value="<?=$item_all->unit_name?>" onfocus="focuson('qty')" readonly/></td>
  </tr>
</table>

 

