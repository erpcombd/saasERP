<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');



$str = $_POST['data'];
$data=explode('##',$str);

$value = $data[0];
// $id = $data[1];
// $type = $data[2];
// $rfq = $data[3];

$vendor = $_SESSION['vendor']['id'];

$update = 'update rfq_vendor_details set want_to_participate="'.$value.'" where rfq_no="'.$_SESSION['rfq_no'].'" and vendor_id="'.$vendor.'"';
db_query($update);

?>
<?if($value=="Yes"){?>
	<div class="pl-3 row">
		<div class="col-sm-16 col-md-6 col-lg-6">

		<span style="font-family: Helvetica,Arial,sans-serif !important; color:">Buyer will be notified of your intent to participate.</span>
	</div>
	<span id="form_details"></span>
</div>	
<span id="participate_button">
	<button class="btn1 btn1-bg-update" id="details-tab" data-toggle="tab" href="#tab3" role="tab"  onclick="is_participate('checked',<?=$_SESSION['rfq_no'];?>)" aria-controls="details" aria-selected="false">Submit Acceptence</button>
</span>
<?}else if($value=="No"){?>
	
	<form action="" method="post">
     <div class="row d-flex justify-content-center align-items-center">
	<textarea class="col-4" name="response_reason_textinput" id="response_reason_textinput" rows="4" required></textarea>
	<div class="col-1"></div>
	<button class="btn1 btn1-bg-update" type="submit" name="response_reason_textinput_buttonfire" id="details-tab">Enter Reason</button>
	</div>
</form>

	<?}?>

