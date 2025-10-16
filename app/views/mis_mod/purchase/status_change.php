<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='PO Status change';			// Page Name and Page Title

$po_no = $_REQUEST['po_no'];

$status = $_REQUEST['status'];

if(isset($_REQUEST['po_no'])!='')

{
$check_grn = find_a_field('purchase_receive','po_no','po_no="'.$po_no.'"');
if($check_grn>0){
$msg = '<span style="color:red;">A GRN has already been prepared for this PO</span>';
}else{
$sql1 = "update purchase_master set status = '".$status."' where po_no='".$po_no."'";
db_query($sql1);
db_query("insert into del_modify_logs set tr_no='".$po_no."',tr_from='PO',action='Modify',entry_by='".$_SESSION['user']['id']."',entry_at='".date('Y-m-d H:i:s')."'");
$msg = '<span style="color:green;">Status Changed to manual successfully.</span>';
}
}



?><title>Status Change</title>

<? if(isset($msg)){ ?>

	<div class="alert alert-success p-2" role="alert">
  			<?=$msg?>
	</div>

<? } ?>


<form action="" method="post">
	<div class="container-fluid bg-form-titel">
				<div class="row">
					<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO No</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="po_no" type="text" id="po_no" value="<?=$po_no?>" required />
							</div>
						</div>
	
					</div>
					<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Return Type</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							   <select name="status" id="status">
	
								   <option value=""></option>
							
								  <option value="MANUAL">MANUAL</option>
							
							
							 </select>
	
							</div>
						</div>
					</div>
	
					<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
						<input name="search" type="submit" class="btn1 btn1-submit-input" id="search" value="CONFIRM" />
					  
					   
					</div>
	
				</div>
			</div>
	</form>


<?





require_once SERVER_CORE."routing/layout.bottom.php";



?>