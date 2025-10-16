<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$unique='rfq_no';
$table_master = 'rfq_master';

if($_SESSION[$unique]>0 && $_SESSION['master_status']=='MANUAL'){
	$_POST[$unique] = $_SESSION[$unique];
	$now = date('Y-m-d H:i:s');
	
	$Crud   = new Crud($table_master);
	$_POST['commodity'] = $_REQUEST['commodity'];
	$_POST['edit_at'] = $now;
	$_POST['edit_by'] = $_SESSION['user']['id'];
	$Crud->update($unique);
}

$event_commodity = find_a_field('event_commodity','id','event_commodity like "'.$_REQUEST['commodity'].'" ');


//$currency = foreign_relation('event_sub_commodity','event_sub_commodity','""',$coupa_commodity,"1 and event_commodity='".$event_commodity."' ");

$options  = '';
$sql = 'select * from event_sub_commodity where event_commodity= "'.$event_commodity.'" ';
$query = db_query($sql);
while($round_info = mysqli_fetch_object($query)){
	$options  .= '<option value="'.$round_info->event_sub_commodity.'" ></option>';
	
} 


$all['comidityList'] = $options;

echo json_encode($all);





?>

