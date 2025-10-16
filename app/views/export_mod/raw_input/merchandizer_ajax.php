<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $buyer_code=$data[0];




?>

<select name="merchandizer_code" id="merchandizer_code"  style="width:250px" required >

                        <option></option>

              <?
		
		foreign_relation('merchandizer_info','merchandizer_code','merchandizer_name',$_POST['merchandizer_code'],'buyer_code="'.$buyer_code.'" order by merchandizer_code');

		?>
                      </select>





