<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$unique='id';
$table_master = 'rfq_evaluation_section';
$Crud   = new Crud($table_master);

$rfq_no  = $_SESSION['rfq_no'];

$_POST['rfq_no'] = $rfq_no;

if($_SESSION['rfq_no']>0){
$_POST['section_name'] = $_POST['section_name'];
$_POST['section_percent'] = $_POST['section_percent'];
$_POST['evaluation_method'] = $_POST['evaluation_method'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();

$update = 'update rfq_master set evaluation_method="'.$_POST['evaluation_method'].'" where rfq_no="'.$_SESSION['rfq_no'].'" and entry_by="'.$_SESSION['user']['id'].'"';
db_query($update);

$_POST['field_name'] = 'event_section_insert';
$_POST['field_value'] = $info[0];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}

$all['msg'] = 'success';
echo json_encode($all);
?>
			