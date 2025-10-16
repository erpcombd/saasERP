<?php
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
$unique='id';
$table_master = 'rfq_evaluation_section_child';
$Crud   = new Crud($table_master);

$rfq_no  = $_SESSION['rfq_no'];

$_POST['rfq_no'] = $rfq_no;
$section_info = find_all_field('rfq_evaluation_section','','id="'.$_POST['section_id'].'"');
if($_SESSION['rfq_no']>0){
$_POST['section_id'] = $_POST['section_id'];
$_POST['child_name'] = $_POST['section_child_name'];
$_POST['child_percent'] = $_POST['section_child_percent'];
$_POST['average_percent'] = (($_POST['section_child_percent']/100)*($section_info->section_percent/100))*100;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();

$_POST['field_name'] = 'event_section_insert';
$_POST['field_value'] = $_POST['section_id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}

$count = find_a_field('rfq_evaluation_section_child','sum(average_percent)','section_id="'.$_POST['section_id'].'" and rfq_no="'.$_SESSION['rfq_no'].'"');
$all['total_child_percent'] = $count;
echo json_encode($all);
?>
