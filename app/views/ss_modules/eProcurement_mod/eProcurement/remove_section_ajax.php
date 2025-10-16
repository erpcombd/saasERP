<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$rfq_no  = $_SESSION['rfq_no'];
$section_id  = $_POST['section_id'];



if($rfq_no>0 && $section_id>0){
$del = 'delete from rfq_evaluation_section where id="'.$section_id.'"';
db_query($del);

$del2 = 'delete from rfq_evaluation_section_child where section_id="'.$section_id.'"';
db_query($del2);

$_POST['rfq_no'] = $rfq_no;
$_POST['field_name'] = 'event_section_cancel';
$_POST['field_value'] = $section_id;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}
$all['msg'] = 'success';
echo json_encode($all);
?>
