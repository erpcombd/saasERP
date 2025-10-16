<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$value = $data[0];
$id = $data[1];
$type = $data[2];
$rfq = $data[3];

$vendor = $_SESSION['vendor']['id'];

if($type=='file'){
	$unique = 'documents_id';
	$table_master = 'rfq_documents_information';
	$types='documents_information';
}else{
	$unique = 'documents_url_id';
	$table_master = 'rfq_documents_url_information';
	$types='documents_url_information';
}





if($id>0){
$Crud   = new Crud($table_master);

$_POST[$unique] = $id ;
$_POST['terms_accept'] = $value;
$_POST['edit_at'] = date('Y-m-d H:i:s');
$_POST['edit_by'] = $_SESSION['user']['id'];
$Crud->update($unique);

}


$_POST['rfq_no'] = $rfq;
$_POST['vendor_id'] = $vendor;
$_POST['response_date'] =  date('Y-m-d');
//$_POST['is_participate'] = 1;

$_POST['type'] = $types;
$_POST['details_id'] = $id;

if($value=='Yes'){
	$_POST['condition_1'] = 1;
	$_POST['condition_2'] = 0;
}else{
	$_POST['condition_1'] = 0;
	$_POST['condition_2'] = 1;
}

$delQl = 'DELETE FROM `rfq_vendor_terms_condition` WHERE rfq_no="'.$_POST['rfq_no'].'" and  vendor_id="'.$vendor.'" and type="'.$types.'" and details_id="'.$id.'" ';
db_query($delQl);

$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_vendor_terms_condition');
$Crud->insert();



$required = find_a_field('rfq_documents_information','count(tr_from)','tr_from like "sourcing_terms_condition" and rfq_no='.$rfq);
$required += find_a_field('rfq_documents_url_information','count(tr_from)','tr_from like "sourcing_terms_condition" and rfq_no='.$rfq);


$completed = find_a_field('rfq_vendor_terms_condition','count(id)','condition_1 = 1 and vendor_id='.$vendor.' and rfq_no='.$rfq);

//if($required==$completed){
?>

<button class="btn1 btn1-bg-update" id="details-tab" style="background-color:#95aac175" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false" disabled >Enter Response</button>
	
<?
//}


?>


