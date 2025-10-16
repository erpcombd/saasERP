<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);
$rfq_no = $_SESSION['rfq_no'];
$unique='id';
$table_master = 'rfq_group_for';
$Crud   = new Crud($table_master);

$check = find_a_field('rfq_group_for','id','group_for="'.$data[0].'" and rfq_no="'.$rfq_no.'"');

if($check>0){
$del = 'delete from rfq_group_for where group_for="'.$data[0].'" and rfq_no="'.$rfq_no.'"';
db_query($del); 
}else{
$_POST['rfq_no'] = $rfq_no;
$_POST['group_for'] = $data[0];
$_POST['entry_at'] = $now;
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();
}

?>

