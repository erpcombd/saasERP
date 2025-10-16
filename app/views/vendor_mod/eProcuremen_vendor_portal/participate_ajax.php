<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$rfq = $data[0];
$checked = $data[1];

$now = date('Y-m-d H:i:s');

$vendor = $_SESSION['vendor']['id'];

if($checked == 'checked'){
	$upQl = 'UPDATE  `rfq_vendor_terms_condition` set is_participate=1 WHERE rfq_no="'.$rfq.'" and  vendor_id="'.$vendor.'" ';
	db_query($upQl);
	
	
	$sql1l = 'insert into vendor_entry_log (rfq_no, field_name, field_value, vendor_id, entry_at) 
				values ('.$rfq.',"Submit Acceptance", "I intend to participate in this event","'.$vendor.'", "'.$now.'")';
	db_query($sql1l);
	
}

 $required = find_a_field('rfq_documents_information','count(tr_from)','tr_from like "sourcing_terms_condition" and rfq_no='.$rfq);
 $required += find_a_field('rfq_documents_url_information','count(tr_from)','tr_from like "sourcing_terms_condition" and rfq_no='.$rfq);

$is_participate = find_a_field('rfq_vendor_terms_condition','is_participate','rfq_no="'.$rfq.'" and  vendor_id="'.$vendor.'"');

$completed = find_a_field('rfq_vendor_terms_condition','count(id)','condition_1 = 1 and vendor_id='.$vendor.' and rfq_no='.$rfq);

if($completed>=$required){
	$info['status']='success';
	$info['button'] = '<form action="" method="post">
					<button class="btn1 btn1-bg-update" type="submit" name="enter_response" id="details-tab">Enter Response</button>
				</form>';
	$info['alert'] = '<div class="alert alert-success" role="alert">Accepted ! now you can enter to response area.Now scroll down and click on Enter Response</div>';
	$info['reason'] = '<div></div>';
}else{	
	$info['button'] = '<button class="btn1 btn1-bg-update" id="details-tab" style="background-color:#95aac175" data-toggle="tab" href="#tab3" role="tab" aria-controls="details" aria-selected="false" disabled >Enter Response</button>';
    $info['alert'] = '<div class="alert alert-danger" role="alert">You need to accept all terms and conditions.</div>';
    $info['reason'] = '<form action="" method="post">
     <div class="row d-flex justify-content-center align-items-center">
	<textarea class="col-4" name="response_reason_textinput" id="response_reason_textinput" rows="10"></textarea>
	<div class="col-1"></div>
	<button class="btn1 btn1-bg-update" type="submit" name="response_reason_textinput_buttonfire" id="details-tab">Enter Reason</button>
	</div>
</form>';

 
 } 
 echo json_encode($info);
 
 ?>

