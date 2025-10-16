<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);

$currencyid = $data[0];

$unique='id';
$table_master = 'rfq_multiple_currency';
$Crud   = new Crud($table_master);

$rfq_no  = $_SESSION['rfq_no'];



if($_SESSION['rfq_no']>0){
$_POST['rfq_no'] = $_SESSION['rfq_no'];
$_POST['currency_id'] = $currencyid;

$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();


}

?>
	
