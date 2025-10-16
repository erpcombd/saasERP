<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='DO Status change';			// Page Name and Page Title

$do_no = $_REQUEST['do_no'];

$status = $_REQUEST['status'];

if(isset($_REQUEST['do_no'])!='')

{
$check_calan = find_a_field('sale_do_chalan','chalan_no','do_no="'.$do_no.'"');
if($check_calan>0){
$msg = '<span style="color:red;">A challan has already been prepared for this DO</span>';
}else{
$sql1 = "update sale_do_master set status = '".$status."' where do_no='".$do_no."'";
db_query($sql1);
db_query("insert into del_modify_logs set tr_no='".$do_no."',tr_from='DO',action='Modify',entry_by='".$_SESSION['user']['id']."',entry_at='".date('Y-m-d H:i:s')."'");
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
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Do No</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="do_no" type="text" id="do_no" value="<?=$do_no?>" required />
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