<?php
session_start();
ob_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
// ::::: Start Edit Section ::::: 

$title='MRR Re-calculate';			// Page Name and Page Title

if(isset($_POST['transfer'])){
$fledger = end(explode("->",$_REQUEST['from_ledger']));
$tledger = end(explode("->",$_REQUEST['to_ledger']));

//$chalan_check = find_a_field('purchase_receive','po_no','pr_no="'.$chalan_no.'"');
if($fledger>0 && $tledger>0)
{
   
if($fledger==$tledger){
$msg = '<span style="color:red;">From Ledger & To Ledger Should Not Same!!!.</span>';
}else{

db_query("update secondary_journal set ledger_id='".$tledger."' where ledger_id='".$fledger."'");
db_query("update journal set ledger_id='".$tledger."' where ledger_id='".$fledger."'");
db_query("insert into del_modify_logs set tr_no='".$tledger."',tr_from='Ledger Transfer',action='Modify',entry_by='".$_SESSION['user']['id']."',entry_at='".date('Y-m-d H:i:s')."'");
	
$msg = '<span style="color:green;">Ledger Transfer Successfully.</span>';
}
}else{
$msg = '<span style="color:red;">Select Ledger Properly!!</span>';
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
				
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="from_ledger" type="text" id="from_ledger"  value="<?=$from_ledger?>" list="fledgerList" required />
								<datalist id="fledgerList">
								<? foreign_relation('accounts_ledger','concat(ledger_name,"->",ledger_id)','""',$_POST['from_ledger'],'1')?>
								</datalist>
							</div>
							
							
						</div>
	
					</div>
					
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="to_ledger" type="text" id="to_ledger"  value="<?=$to_ledger?>" list="tledgerList" required />
								<datalist id="tledgerList">
								<? foreign_relation('accounts_ledger','concat(ledger_name,"->",ledger_id)','""',$_POST['tledgerList'],'1')?>
								</datalist>
							</div>
							
							
						</div>
	
					</div>
					
					
					
	
					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
						<input name="transfer" type="submit" id="transfer" class="btn1 btn1-bg-submit" value="Transfer" />
					  
					   
					</div>
	
				</div>
			</div>
	</form>


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>