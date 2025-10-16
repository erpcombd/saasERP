<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $buyer=$data[0];
   
   $buyer_cd=explode('->',$buyer);
   
   $buyer_code=$buyer_cd[0];
   
  
?>

  
  
  
  



		 
		 
		 
		<input name="buyer_code" type="hidden" id="buyer_code" required readonly="" style="width:250px;" value="<?=$buyer_code?>" tabindex="105" />

