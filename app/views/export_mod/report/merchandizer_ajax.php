<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $buyer=$data[0];
   
   $buyer_exp=explode('->',$buyer);
   
	$buyer_code=$buyer_exp[0];

	$dealer_code = find_a_field('buyer_info','dealer_code',"buyer_code=".$buyer_code);
	
	


?>


			  
<input list="merchandizer_name" name="merchandizer" id="merchandizer"  style="width:250px; float:left;"  onchange="getData2('merchandizer_code_ajax.php', 'merchandizer_code_filter', this.value, document.getElementById('merchandizer').value);"  autocomplete="off"   >
  <datalist id="merchandizer_name">

	  <? foreign_relation('merchandizer_info','CONCAT(merchandizer_code, "->", merchandizer_name)','merchandizer_name',$merchandizer,'buyer_code="'.$buyer_code.'"
	  and dealer_code="'.$dealer_code.'" order by merchandizer_name');?>
	  
  </datalist>





