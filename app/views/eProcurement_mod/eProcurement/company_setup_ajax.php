<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);
$rfq_no = $_SESSION['rfq_no'];
$unique='id';
$table_master = 'rfq_group_for';
if($_SESSION['master_status']=='MANUAL'){
$Crud   = new Crud($table_master);

$check = find_a_field('rfq_group_for','id','group_for="'.$data[0].'" and rfq_no="'.$rfq_no.'"');

if($check>0){
$del = 'delete from rfq_group_for where group_for="'.$data[0].'" and rfq_no="'.$rfq_no.'"';
db_query($del); 
}else{
$_POST['rfq_no'] = $rfq_no;
$_POST['group_for'] = $data[0];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();
}

$robi_id = find_a_field('rfq_group_for','id','group_for="1" and rfq_no="'.$rfq_no.'"');
if($robi_id>0){
	$imgsrc="../../../controllers/utilities/api_upload_attachment_show.php?name=default_logo.png&folder=logo";
 }else{
	$logo_name = find_a_field('rfq_group_for r, user_group u','company_logo','r.group_for=u.id and r.rfq_no="'.$rfq_no.'" order by r.id desc');
	$imgsrc="../../../controllers/utilities/setup_upload_attachment_show.php?name=".$logo_name."&folder=logo";
}
echo '<img alt="" id="logoshowbasicsourcing" src="'.$imgsrc.'" style="width: 100%; max-height: 80px;mix-blend-mode: multiply;"/>';
//echo '<span style="color:green;">Saved</span>';
}
?>

