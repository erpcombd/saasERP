<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='New Purchase Order Return Entry';
$tr_type="Show";
$page_for = 'Return';
do_calander('#or_date');
do_calander('#quotation_date');

$table_master='warehouse_other_receive';
$table_details='warehouse_other_receive_detail';
$unique='or_no';
$$unique = $_POST[$unique];
unset($_SESSION[$unique]);
if(isset($_POST['confirmm']))
{
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='UNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		//auto_insert_sales_return_secoundary($$unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded.';
}

if(isset($_POST['delete']))
{
		
		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Deleted.';
}




$tr_from="Warehouse";
?>
<script language="javascript">
window.onload = function() {document.getElementById("do").focus();}
</script>



<div class="form-container_large">
		<form action="item_return_adjustments.php" method="post" name="codz" id="codz" autocomplete="off">
			<div class="container-fluid bg-form-titel">
				<div class="row">
					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
						<div class="form-group row m-0">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">GRN No :</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
								<!--<input name="po_no" type="hidden" id="po_no" value="<?=$moin;?>" autocomplete="off" />-->
								
																
									
									<input type="text" list="dealer"  name="po_no" id="po_no" o required />

										<datalist id="dealer">

											<option></option>


<? foreign_relation('purchase_receive p,vendor v','CONCAT(p.pr_no, "##", v.vendor_name)','""',$po_no,'1 and p.status in ("Received","Bill Created") and p.vendor_id=v.vendor_id group by p.pr_no');?>
										</datalist>
							
								
							</div>
						</div>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
					      <input type="submit" name="submitit" id="submitit" value="Open for Return" class="btn1 btn1-submit-input"/>
					</div>
				</div>
			</div>
		</form>

</div>





<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>