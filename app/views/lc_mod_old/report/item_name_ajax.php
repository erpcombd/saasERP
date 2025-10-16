<?php


//


require "../../support/inc.all.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $sub_group_id=$data[0];




?>


<select name="item_id" id="item_id" >

	<option></option>

	<? foreign_relation('item_info','item_id','item_name',$item_id, 'sub_group_id="'.$sub_group_id.'"  order by item_id ');?>



</select>

