<?php


session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


  $str = $_POST['data'];

 
$data=explode('##',$str);
 

   $customer=$data[0];
   
   //$dealer=explode('->',$customer);
   
   //$dealer_code=$dealer[0];
   
   $rak_no = find_a_field('rak_setup','rak_no',"rak_no=".$customer);

?>

  
 
	<select id="selve_no" name="selve_no">
				
				<? foreign_relation('cell_setup','sub_cell_no','cell_no',$selve_no,'1 and rak_no='.$rak_no);?>
	</select>
 
	 	
 

 
		 