<?php
session_start();
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);

$item_id=$data[0];

$pi = find_a_field('item_info','unit_name','item_id="'.$item_id.'"');
?>
<input name="unit_name" type="text" class="input3" id="unit_name" style="width:100px;" value="<?=$pi?>"/>
