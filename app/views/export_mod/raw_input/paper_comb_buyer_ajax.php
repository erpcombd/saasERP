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


  	<select name="buyer_code" required id="buyer_code" style="width:250px;" tabindex="7" >
			<option></option>

            <? foreign_relation('buyer_info','buyer_code','buyer_name',$buyer_code,'dealer_code="'.$dealer_code.'"');?>
    </select>









