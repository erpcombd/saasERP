<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

//--========Table information==========-----------//

$table_master='purchase_master';

$table_details='purchase_invoice';

$unique='po_no';


$unique_detail='id';

//--========Table information==========-----------//

		

$sql= 'update purchase_invoice set qty='.$_POST['qty'].',rate='.$_POST['rate'].',amount='.$_POST['amount'].' where id="'.$_POST['id'].'"';
$query=db_query($sql);


		


echo json_encode($all_dealer);

?>



