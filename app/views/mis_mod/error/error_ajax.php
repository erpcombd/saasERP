<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$item=explode('#>',$data[0]);
$item_id = $item[2];
$a= $data[1];
$id= $data[0];

$update = 'update error_check_details set status="'.$a.'" where id="'.$id.'"';
$updated = db_query($update);
if($updated){

	echo '<span style="color:green;">Saved</span>';
}

?>
