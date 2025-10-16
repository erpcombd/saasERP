<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$unique='id';
$table_master = 'rfq_evaluation_section_vendor';
$table_details = 'rfq_evaluation_section_child_vendor';
$Crud   = new Crud($table_master);

$rfq_no = $_SESSION['rfq_no'];

$_POST['rfq_no'] = $rfq_no;

$_POST['vendor_id'] = $_POST['vendor_id'];
$_POST['edit_at'] = date('Y-m-d H:i:s');
$_POST['edit_by'] = $_SESSION['user']['id'];
$setup_section_id = $_POST['section_id'];
if($_SESSION['rfq_no']>0){



$_POST['setup_section_id'] = $_POST['section_id'];
$secion_id = $Crud->insert();
$up = 'update rfq_evaluation_section set status="EVALUATED" where id="'.$setup_section_id.'"';
db_query($up);
$Crud   = new Crud($table_details);

$sql2 = 'select * from rfq_evaluation_section_child where rfq_no="'.$rfq_no.'" and section_id="'.$setup_section_id.'"';
		 $qry2 = db_query($sql2);
		 while($doc2=mysqli_fetch_object($qry2)){
		 $_POST['setup_section_id'] = $setup_section_id;
		 $_POST['setup_detilas_id'] = $doc2->id;
		 $_POST['section_id'] = $secion_id;
		 $final_mark = $_POST[$setup_section_id.'_'.$doc2->id];
		 $_POST['final_mark'] = $final_mark;
		 $_POST['child_name'] = $doc2->child_name;
		 $_POST['child_percent'] = $doc2->child_percent;
		 $_POST['average_percent'] = $doc2->average_percent;
		 
		 $Crud->insert();
		 $up = 'update rfq_evaluation_section_child set status="EVALUATED" where id="'.$doc2->id.'"';
		 db_query($up);
		 }

}
$all['success'] = 'Successfully Saved';
$all['success_code'] = '1';
echo json_encode($all);
?>

