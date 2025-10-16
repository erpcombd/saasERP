<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);


$rfq = $_SESSION['rfq_no'];

$required = find_a_field('rfq_documents_information','count(tr_from)','tr_from like "sourcing_terms_condition" and rfq_no='.$rfq);
$required += find_a_field('rfq_documents_url_information','count(tr_from)','tr_from like "sourcing_terms_condition" and rfq_no='.$rfq);


echo $required;
?>