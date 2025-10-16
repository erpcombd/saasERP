<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
// Decode the received data
$str = urldecode($str);
$data=explode('##',$str);

$value = $data[0];
$rfq = $data[1];
$id  = $data[2];

$vendor = $_SESSION['vendor']['id'];


$unique = 'id';
$table_master = 'rfq_vendor_response';


if($id>0){
$Crud   = new Crud($table_master);
$_POST[$unique] = $id ;
$_POST['rfq_no'] = $rfq;
$_POST['vendor_id'] = $vendor;
$_POST['response_name'] = $value;
$_POST['response_date'] = date('Y-m-d');
$_POST['edit_at'] = date('Y-m-d H:i:s');
$_POST['edit_by'] = $_SESSION['user']['id'];
$Crud->update($unique);

}else{
	$_POST['rfq_no'] = $rfq;
	$_POST['vendor_id'] = $vendor;
	$_POST['response_name'] = $value;
	$_POST['response_date'] = date('Y-m-d');
	$_POST['entry_at'] = date('Y-m-d H:i:s');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$Crud   = new Crud($table_master);
	$Crud->insert();
}

echo $value;



?>


