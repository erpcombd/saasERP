<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Start Edit Section ::::: 

$title='Purchase Return Delete';			// Page Name and Page Title

if(isset($_POST['ch_delete'])){

$chalan_no = $_REQUEST['chalan_no'];

$type = find_a_field('purchase_return_master s,purchase_return_type t','t.return_type','1 and s.pr_no = "'.$chalan_no.'" and s.return_type=t.id');
if($chalan_no>0){

	db_query("INSERT INTO journal_item_del select * from journal_item where tr_from ='".$type."' and sr_no=".$chalan_no."");
	db_query("DELETE FROM `journal_item` WHERE tr_from ='".$type."' and  sr_no=".$chalan_no."");

    $chalan_del_insert = db_query("INSERT INTO purchase_return_master_del select * from purchase_return_master where pr_no=".$chalan_no."");
    db_query("DELETE FROM `purchase_return_master` WHERE pr_no=".$chalan_no."");
	
	$chalan_del_insert = db_query("INSERT INTO purchase_return_details_del select * from purchase_return_details where pr_no=".$chalan_no."");
    db_query("DELETE FROM `purchase_return_details` WHERE pr_no=".$chalan_no."");
	
	$chalan_del_insert = db_query("INSERT INTO secondary_journal_del select * from secondary_journal where tr_from ='".$type."' and tr_no=".$chalan_no."");
    db_query("DELETE FROM `secondary_journal` WHERE tr_from ='".$type."' and tr_no=".$chalan_no."");
	
	$chalan_del_insert = db_query("INSERT INTO journal_del select * from journal where tr_from ='".$type."' and tr_no=".$chalan_no."");
    db_query("DELETE FROM `journal` WHERE tr_from ='".$type."' and tr_no=".$chalan_no."");

	
	db_query("insert into del_modify_logs set tr_no='".$chalan_no."',tr_from='Purchase Return',action='Delete',entry_by='".$_SESSION['user']['id']."',entry_at='".date('Y-m-d H:i:s')."'");
	$msg = '<span style="color:green;">Purchase Return Deleted Successfully.</span>';

}

}



	?>

<style type="text/css">

<!--

.style1 {

	color: #FF0000;

	font-weight: bold;

}

.style2 {

	color: #006600;

	font-weight: bold;

}

-->

</style>
<? if(isset($msg)){ ?>

	<div class="alert alert-success p-2" role="alert">
  			<?=$msg?>
	</div>

<? } ?>

<form action="" method="post">
	<div class="container-fluid bg-form-titel">
				<div class="row">
				<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
						
					  
					   
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Return No</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="chalan_no" type="text" id="chalan_no" value="<?=$chalan_no?>" required />
							</div>
						</div>
	
					</div>
					
	
					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
						<input name="ch_delete" type="submit" id="ch_delete" class="btn1 btn1-submit-input" value="Delete Chalan" />
					  
					   
					</div>
	
				</div>
			</div>
	</form>


<br /><br />



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>