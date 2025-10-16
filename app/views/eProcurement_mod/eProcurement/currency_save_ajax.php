<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
$Crud   = new Crud('rfq_master');
$currency = $_POST['currency'];
$_POST['rfq_no'] = $_SESSION['rfq_no'];
$_POST['planned_savings_currency'] = $currency;
$_POST['cost_avoidance_currency'] = $currency;
$_POST['project_amount_currency'] = $currency; 

$Crud->update('rfq_no');

$all['msg'] = $currency;

echo json_encode($all);





?>

