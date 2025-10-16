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

$stock_pl=find_a_field('journal_item','sum(item_in-item_ex)','warehouse_id='.$pl_id.' and item_id='.$item_id.'');

//$stock = warehouse_product_stock($item_id ,$warehouse_id);_sield(

$stock=find_a_field('journal_item','sum(item_in-item_ex)','warehouse_id='.$warehouse_id.' and item_id='.$item_id.'');

$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');





 $s_journal =  find_a_field('journal_item','SUM(item_in)','item_id="'.$item_id.'" and tr_from="Local Purchase"');



//$s_req =  find_a_field('requisition_order_local','SUM(qty)','item_id="'.$item_id.'"');



//$s_journal =  find_a_field('purchase_receive','SUM(qty)','item_id="'.$item_id.'"');





$s_req =  find_a_field('requisition_order_local b,requisition_master_local a','SUM(b.qty)','b.item_id="'.$item_id.'" and a.status in ("CHECKED","PENDING") and a.req_no=b.req_no and a.req_for='.$pl_id.'');



$s_pqty = ($s_req-$s_journal);


$avg_month = find_a_field('journal_item','ji_date','item_id='.$item_id.' and tr_from="Consumption" order by ji_date');





 $s_time = strtotime($avg_month);

 



  $e_time = time();







 $diff_month =round((($e_time - $s_time)/(60*60*24*30)));

}









?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><input  name="floor" type="text" id="floor" style="width:55px;"  value="<?=number_format($stock_pl,2)?>"/></td>

    <td><input name="pqty" type="text" class="input3" id="pqty" style="width:60px;" value="<?=number_format($s_req,2)?>" onfocus="focuson('qty')" readonly/> </td>
	
	<td><input name="avgconsump" type="text" class="input3" id="avgconsump" style="width:60px;" value="<?  
	$c_issue=find_a_field('journal_item','sum(item_ex) as ex', 'tr_from="Consumption" and item_id='.$item_id);



			if($c_issue=='') {echo "null"; }else {echo	number_format($c_issue/$diff_month,2);}?>" onfocus="focuson('qty')" readonly/> </td>

    <td><input name="qoh" type="text" class="input3" id="qoh" style="width:60px;" value="<?=number_format($stock,2)?>" onfocus="focuson('qty')" readonly/> </td>

    <td>

<input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:30px;" value="<?=$item_all->unit_name?>" onfocus="focuson('qty')" readonly/></td>

  </tr>

</table>



 



