<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$rfq = $data[0];
$checked = $data[1];

$vendor = $_SESSION['vendor']['id'];



$required = find_a_field('rfq_documents_information','count(tr_from)','tr_from like "sourcing_terms_condition" and rfq_no='.$rfq);
$required += find_a_field('rfq_documents_url_information','count(tr_from)','tr_from like "sourcing_terms_condition" and rfq_no='.$rfq);

$is_participate = find_a_field('rfq_vendor_terms_condition','is_participate','rfq_no="'.$rfq.'" and  vendor_id="'.$vendor.'"');

$completed = find_a_field('rfq_vendor_terms_condition','count(id)','condition_1 = 1 and vendor_id='.$vendor.' and rfq_no='.$rfq);

if($required==$completed && $is_participate==1){
?>
	<div class="alert alert-success" role="alert">Accepted ! now you can enter to response area.</div>
<?
}else{
?>
 <div class="alert alert-danger" role="alert">You need to accept all terms and conditions.</div>
 
 <? } ?>

