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

<select name="buyer_code" id="buyer_code"  style="width:250px" tabindex="3"  onchange="getData2('merchandizer_ajax.php', 'merchandizer_filter', this.value, 

document.getElementById('buyer_code').value);"  >

                        <option></option>

               <? foreign_relation('buyer_info','buyer_code','buyer_name',$_POST['buyer_code'],'dealer_code="'.$dealer_code.'" order by buyer_code');?>

                      </select>





