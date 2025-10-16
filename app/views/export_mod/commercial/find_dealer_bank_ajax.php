<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $dealer_code=$data[0];
   
 

?>

		  

  
  
<select name="bank_buyers" id="bank_buyers" required style="width:220px;">
	
	<option></option>
								
	<? foreign_relation('bank_buyers','bank_id','bank_name',$bank_buyers,'dealer_code="'.$dealer_code.'" order by bank_id');?>
</select>









