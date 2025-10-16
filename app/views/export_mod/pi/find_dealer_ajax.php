<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);
//$data_1=explode('#>',$str);
//$data=explode('##',$data_1[1]);

   $dealer_group=$data[0];
   
 

?>

		  

  
  
  <select name="dealer_code" id="dealer_code" required style="width:220px;">
		
		<option></option>
									
		<? foreign_relation('dealer_info_foreign','dealer_code','dealer_name_e',$dealer_code,'dealer_group="'.$dealer_group.'" order by dealer_code');?>
</select>









