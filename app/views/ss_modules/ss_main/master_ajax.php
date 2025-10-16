<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);

$unique='rfq_no';
$table_master = 'rfq_master';
$Crud   = new Crud($table_master);

$field_name  = $data[0];
$field_value = $data[1];

$_POST['rfq_date'] = date('Y-m-d');
$now = date('Y-m-d H:i:s');

$_POST[$field_name] = $field_value;

if($_SESSION[$unique]>0){

$_POST[$unique] = $_SESSION[$unique];

$info = find_all_field('rfq_master','','rfq_no="'.$_SESSION[$unique].'"');

if($info->status=='MANUAL'){

if($field_name=='eventStartTime'){
echo $_POST['eventStartAt'] =$info->eventStartDate.' '.$_POST['eventStartTime'];
}

if($field_name=='eventEndTime'){
$_POST['eventEndAt'] =$info->eventEndDate.' '.$_POST['eventEndTime'];
}
$_POST['edit_at'] = $now;
$_POST['edit_by'] = $_SESSION['user']['id'];
$Crud->update($unique);

}
}else{
$_POST['entry_at'] = $now;
$_POST['entry_by'] = $_SESSION['user']['id'];
$_SESSION[$unique] = $Crud->insert();

}


$_POST['field_name'] = $field_name;
$_POST['field_value'] = $field_value;
$_POST['entry_at'] = $now;
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();

?>

<input type="hidden" name="new_rfq_no" id="new_rfq_no" value="<?=$_SESSION[$unique]?>" />

