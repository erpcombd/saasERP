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
   
   $floor_all = find_all_field('rak_setup','',"room_no=".$customer);

?>

  
 
	<select id="rak_name" name="rak_name" onchange="getData2('rak_ajax.php', 'selve', this.value, 
document.getElementById('rak_name').value);" >
				
				<? foreign_relation('rak_setup','rak_no','rak_name',$rak_name,'1 and room_no='.$floor_all->room_no);?>
	</select>
 
	 	
 

 
		 