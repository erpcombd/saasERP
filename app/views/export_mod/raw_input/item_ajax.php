<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $item_sub_group=$data[0];




?>

<select name="item_id" id="item_id" tabindex="4"  style="width:250px">

                        <option></option>

                        <? foreign_relation('item_info','item_id','item_name',$item_id, 'sub_group_id="'.$item_sub_group.'"');?>

                      </select>





