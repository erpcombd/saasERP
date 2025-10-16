<?php



session_start();



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


 $str = $_POST['data'];



$data=explode('##',$str);



$item=explode('#>',$data[0]);



 $item_id = $item[1];



if($item_id>0){



$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');



 $warehouse_id = $data[1];



  $stock = warehouse_product_stock($item_id ,$warehouse_id);


  //$stock = (int)(warehouse_product_stock($item_id ,$warehouse_id));

$issue_price=find_a_field_sql('select final_price from journal_item where  item_id="'.$item_id.'"  and final_price > 0 order by id desc');
}



?>
<input name="pkt_size" type="hidden" class="input3" id="pkt_size" style="width:50px;" readonly="readonly" required="required" value="<?=$item_all->pack_size?>" onfocus="focuson('qty')"/>



<input name="stk" type="text" class="input3" id="stk" style="width:50px;" readonly="readonly" required="required" value="<?=$stock?>" onfocus="focuson('qty')"/>



<input name="unit_name" type="text" class="input3" id="unit_name" style="width:50px;" value="<?=$item_all->unit_name?>" readonly required onfocus="focuson('qty')"/>



<input name="rate" type="text" class="input3" id="rate"  maxlength="100" style="width:50px;" onchange="count()" value="<?=$issue_price?>"    readonly=""/>

