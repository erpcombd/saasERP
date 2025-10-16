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
   
   $floor_all = find_all_field('floor_setup','',"warehouse_id=".$customer);

?>

  
 
	<select id="floor_no" name="floor_no">
				
				<? foreign_relation('floor_setup','id','floor_short_name',$_POST['floor_no'],'1 and warehouse_id='.$floor_all->warehouse_id);?>
			</select>
 
	 	
 

 
		 