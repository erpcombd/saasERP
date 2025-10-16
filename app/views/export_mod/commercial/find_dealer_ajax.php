<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


$dealer_group=$data[0];
   
 

?>

		  

  
  
  <select name="dealer_code" id="dealer_code" required style="width:220px;" onchange="getData2('find_dealer_bank_ajax.php', 'find_dealer_bank', this.value,document.getElementById('dealer_code').value);" >
		
		<option></option>
									
		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'dealer_group="'.$dealer_group.'" order by dealer_code');?>
</select>









