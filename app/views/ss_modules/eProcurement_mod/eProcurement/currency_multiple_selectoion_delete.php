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

$delete_sql='delete from rfq_multiple_currency where rfq_no="'.$_SESSION['rfq_no'].'" and currency_id="'.$currencyid.'"';
db_query($delete_sql);



}

?>
	
