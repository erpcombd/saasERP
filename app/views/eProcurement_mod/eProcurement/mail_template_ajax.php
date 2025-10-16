<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$unique='rfq_no';
$table_master = 'vendor';
$_POST[$unique] = $_SESSION['rfq_no'];
$_POST['mail_template'] = $_POST['mail_template'];
$Crud   = new Crud('rfq_master');
$Crud->update($unique);
?>

