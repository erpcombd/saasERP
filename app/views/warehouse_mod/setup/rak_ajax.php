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
   
   $floor_all = find_all_field('room_setup','',"floor_no=".$customer);

?>

  
 
 
 	<select name="room_no" id="room_no" value="<?=$_POST['room_no']?>">
		<? foreign_relation('room_setup','room_no','room_no',$room_no,'1 and floor_no="'.$floor_all->floor_no.'" order by room_no asc');?>
	</select>

	
 
	 	
 

 
		 