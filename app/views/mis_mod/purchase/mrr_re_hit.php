<?php
session_start();
ob_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
// ::::: Start Edit Section ::::: 

$title='MRR Re-calculate';			// Page Name and Page Title

if(isset($_POST['calculate'])){
$chalan_no = $_REQUEST['chalan_no'];

$chalan_check = find_a_field('purchase_receive','po_no','pr_no="'.$chalan_no.'"');
if($chalan_check>0)
{
    $sec_del = db_query('insert into secondary_journal_del select * from secondary_journal where tr_from in ("Purchase") and tr_no='.$chalan_no.'');
	$sql2 = "DELETE FROM `secondary_journal` WHERE tr_from in ('Purchase') and tr_no=".$chalan_no."";
	db_query($sql2);
	
	$j_del = db_query('insert into journal_del select * from journal where tr_from in ("Purchase") and tr_no='.$chalan_no.'');
	$sql3 = "DELETE FROM `journal` WHERE tr_from in ('Purchase') and tr_no=".$chalan_no."";
	db_query($sql3);
	
	db_query("insert into del_modify_logs set tr_no='".$chalan_no."',tr_from='MRR',action='Modify',entry_by='".$_SESSION['user']['id']."',entry_at='".date('Y-m-d H:i:s')."'");

	auto_insert_purchase_secoundary_journal($chalan_no);
    $msg = '<span style="color:green;">MRR Re-calculate Done.</span>';
}else{
$msg = '<span style="color:red;">MRR Not Found.</span>';
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
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">MRR No</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="chalan_no" type="text" id="chalan_no"  value="<?=$chalan_no?>" required />
							</div>
						</div>
	
					</div>
					
	
					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
						<input name="calculate" type="submit" id="calculate" class="btn1 btn1-bg-submit" value="Confirm" />
					  
					   
					</div>
	
				</div>
			</div>
	</form>


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>