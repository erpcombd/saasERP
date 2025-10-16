<?php


//


require "../../support/inc.all.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $group_id=$data[0];




?>

<select name="src_sub_group_id" id="src_sub_group_id" style="width:250px; float:left">

<option></option>
          
                   <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$src_sub_group_id,'group_id="'.$group_id.'" order by sub_group_name');?>
</select>





