<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$rfq_no  = $_SESSION['rfq_no'];
$section_id  = $_POST['section_id'];
$child_id  = $_POST['child_id'];

if($rfq_no>0 && $child_id>0){
$del = 'delete from rfq_evaluation_section_child where id="'.$child_id.'"';
db_query($del);

$_POST['rfq_no'] = $rfq_no;
$_POST['field_name'] = 'event_section_cancel';
$_POST['field_value'] = $child_id;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}
$count = find_a_field('rfq_evaluation_section_child','sum(average_percent)','section_id="'.$section_id.'" and rfq_no="'.$rfq_no.'"');
$all['total_child_percent'] = $count;
echo json_encode($all);
?>
