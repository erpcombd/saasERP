<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$proj_all=find_all_field('project_info','*','1');
$po_no 		= $_GET['po_no'];

 $condition="po_no=".$po_no;
 
$data=find_all_field('lc_bank_entry','*',$condition);
//////currency all///
$csql='select * from currency_type where 1 group by id';
$cquery=db_query($csql);
while($crow=mysqli_fetch_object($cquery)){
	$currency_name[$crow->id]=$crow->currency_type;
	$currency_icon[$crow->id]=$crow->icon;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>LC Status</title>
  </head>
  <body>
  <div class="container">
  <center><h2><u>LC Entry Information</u></h2></center><br><br><br>
  <div class="row">
  <div class="col-4">
  LC ISSUE DATE: <strong><?=$data->lc_issue_date?> </strong>
  <br> <br>
  LC NO: <strong><?=$data->bank_lc_no?></strong>
<br> <br>
  LC EXPIRY DATE:<strong> <?=$data->lc_expiry_date?></strong>
  <br> <br>
  TOLERANCE: <strong><?=$data->tolerance?></strong>
  <br> <br>
  INSURANCE COVER NOTE NO: <strong><?=$data->insurance_cover_note_no?></strong>
  </div>
   <div class="col-4">
   	PI NO: <strong><?=$data->pi_no?></strong>
	<br><br>
	SHIPMENT DATE: <strong><?=$data->shipment_date?></strong>
	<br><br>
	SHIPMENT EXPIRY DATE: <strong><?=$data->shipment_expiry_date?></strong>
	<br><br>
	LC AF NO: <strong><?=$data->lc_af_no?></strong>
	<br><br>
	BANK NAME: <strong><?=$data->bank_name?></strong>
	<br><br>
	COVER NOTE DATE: <strong><?=$data->cover_note_date?></strong>
		
   </div>
    <div class="col-4">
		COMPANY: <strong><?=find_a_field('user_group','group_name','id="'.$data->group_for.'"')?></strong>
		<br><br>
		LC TYPE: <strong><?=find_a_field('lc_type','lc_type','id="'.$data->lc_type.'"')?></strong>
		<br><br>
		LC VALUE (<?=$currency_name[$data->currency]?>): <strong><?=$data->lc_value?></strong>
		<br><br>
			MODE OF TRANSPORT: <strong><?=find_a_field('mode_of_transport','mode_of_transport','id="'.$data->mode_of_transport.'"')?></strong>
		<br><br>
		AMMENDMENT DATE: <strong><?=($data->ammendment_date!='0000-00-00')?$data->ammendment_date:''?></strong>
		<br><br>
			REMARKS: <strong><?=$data->remarks?></strong>
		</div>
  </div>
  </div>
  



  </body>
</html>