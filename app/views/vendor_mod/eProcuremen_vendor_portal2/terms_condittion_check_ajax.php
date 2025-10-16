<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);

$value = $data[0];
$id = $data[1];
$type = $data[2];
$rfq = $data[3];

$required = find_a_field('documents_information','count(tr_from)','tr_from like "sourcing_terms_condition" and master_id='.$rfq->rfq_no);
$required += find_a_field('documents_url_information','count(tr_from)','tr_from like "sourcing_terms_condition" and master_id='.$rfq->rfq_no);

$completed = find_a_field('rfq_vendor_terms_condition','count(id)','condition_1 = 1 and vendor_id='.$vendor.' and rfq_no='.$rfq->rfq_no);
if($required==$completed){
?>
	<button class="btn1 btn1-bg-update" id="details-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false">Enter Response</button>
<? } ?>



