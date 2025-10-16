<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);

$value = $data[0];
$rfq = $data[1];

$vendor = find_a_field('user_activity_management','vendor_code','user_id="'.$_SESSION['user']['id'].'"');

$id = find_a_field('rfq_vendor_response','id','vendor_id="'.$vendor.'" and rfq_no ='.$rfq);


$unique = 'id';
$table_master = 'rfq_vendor_response';


if($id>0){
$crud   = new crud($table_master);
$_POST[$unique] = $id ;
$_POST['rfq_no'] = $rfq;
$_POST['vendor_id'] = $vendor;
$_POST['response_name'] = $value;
$_POST['response_date'] = date('Y-m-d');
$_POST['edit_at'] = date('Y-m-d H:i:s');
$_POST['edit_by'] = $_SESSION['user']['id'];
$crud->update($unique);

}else{
	$_POST['rfq_no'] = $rfq;
	$_POST['vendor_id'] = $vendor;
	$_POST['response_name'] = $value;
	$_POST['response_date'] = date('Y-m-d');
	$_POST['entry_at'] = date('Y-m-d H:i:s');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$crud   = new crud($table_master);
	$crud->insert();
}

echo $value;

/*$unique='rfq_no';
$table_master = 'rfq_master';
$crud   = new crud($table_master);

$field_name  = $data[0];
$field_value = $data[1];
// Common Field
$_POST['rfq_date'] = date('Y-m-d');


$_POST[$field_name] = $field_value;*/

/*if($_SESSION[$unique]>0){
$_POST[$unique] = $_SESSION[$unique];
$_POST['edit_at'] = date('Y-m-d H:i:s');
$_POST['edit_by'] = $_SESSION['user']['id'];
$crud->update($unique);

}*/

/*else{
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$_SESSION[$unique] = $crud->insert();

}


$_POST['field_name'] = $field_name;
$_POST['field_value'] = $field_value;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$crud   = new crud('rfq_logs');
$crud->insert();*/

?>


