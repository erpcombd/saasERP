<?php


//


require "../../support/inc.all.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $mother_group_id=$data[0];




?>


<select name="item_group" id="item_group"  onchange="getData2('item_sub_group_update_ajax.php', 'sub_group', this.value, 
document.getElementById('item_group').value);">

	<option></option>

	<? foreign_relation('item_group','group_id','group_name',$item_group, 'mother_group_id="'.$mother_group_id.'" order by item_group_sl ');?>



</select>

