<?php


session_start();



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $data_id=$data[0];




?>


<select name="acc_sub_class" required id="acc_sub_class"  tabindex="2" style="width:220px;"
onchange="getData2('acc_group_ajax.php', 'acc_group', this.value, 
document.getElementById('acc_sub_class').value);">
	<option></option>
      <? foreign_relation('acc_sub_class','id','CONCAT(id, ": ", sub_class_name)',$acc_sub_class,'acc_class="'.$data_id.'"');?>
</select>

