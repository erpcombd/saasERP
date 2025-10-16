<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $customer=$data[0];
   
   $dealer=explode('->',$customer);
   
   $dealer_code=$dealer[0];

?>

		  
<input list="buyer_name" name="buyer" id="buyer"  style="width:250px; float:left;"   autocomplete="off"  
onchange="getData2('buyer_code_ajax.php', 'buyer_code_filter', this.value, 
document.getElementById('buyer').value);">
  <datalist id="buyer_name">
	 
	 <? foreign_relation('buyer_info','CONCAT(buyer_code, "->", buyer_name)','buyer_name',$buyer,'dealer_code="'.$dealer_code.'" order by buyer_name');?>
  </datalist>









