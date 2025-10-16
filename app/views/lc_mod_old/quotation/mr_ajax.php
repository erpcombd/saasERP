<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



   $str = $_POST['data'];

$data=explode('##',$str);

$item=explode('#>',$data[0]);
$item_id = $item[2];
$data2=explode('/#/',$data[1]);
$warehouse_id=$data2[0];
  $req_ids=$data2[1];


if($item_id>0){

 
$tot_req_qty=find_a_field('requisition_order','sum(qty)','item_id="'.$item_id.'" and id in('.$req_ids.')');
 

$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');}

?>
<table style="width:100%;" border="1">
						 <tr>
<td width="33%"><input name="req_qty" type="text" class="input3" id="req_qty" style="width:98%;" value="<?=$tot_req_qty?>"  readonly/>  </td>


 

<td width="23%"><input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:98%;" value="<?=$item_all->unit_name?>" onfocus="focuson('qty')" /></td>
</tr></table>