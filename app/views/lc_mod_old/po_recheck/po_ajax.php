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


// $warehouse_id = $data[1];

//$stock = (int)(warehouse_product_stock($item[1] ,$warehouse_id));

//$stock= (int)find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'. $item[1].'"');

?>



<input name="unit_name" type="text" class="input3" id="unit_name" style="width:105px;float:left;" value="<?=$item_all->unit_name;?>" readonly required/>

<?php /*?><input name="rate" type="text" class="input3" id="rate"  maxlength="100" style="width:100px;float:left;" onchange="count()" value="<?=$item_all->cost_price?>"  required/><?php */?>