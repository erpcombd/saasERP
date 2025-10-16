<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);

$item=$data[0];

$item_all= find_all_field('item_info','','item_id="'.$item.'"');
  
  
  

?>

<input name="unit_name" type="text" class="input3" id="unit_name" style="width:30px;" value="<?=$item_all->unit_name?>" readonly required onfocus="focuson('rate')"/>

