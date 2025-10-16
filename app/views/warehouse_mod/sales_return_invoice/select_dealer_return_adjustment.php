<?php
session_start();
ob_start();



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Invoice Wise Sales Return Order';
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
if (isset($_POST['submitit'])) {
    $invoice = $_POST['chalan_no'];
    $company = $_POST['group_for'];
	
$group_for=find_a_field('sale_do_chalan','group_for','chalan_no='.$invoice);

   // if (!empty($invoice) && !empty($company)) {
   
	if ($group_for==$company) {
        header("Location: item_return_adjustments.php?chalan_no=$invoice&company=$company");
        exit();
    } else {
        echo "<p style='color:red;'>Please enter invoice and company correctly.</p>";
    }
}

$tr_from="Warehouse";
?>
<script language="javascript">
window.onload = function() {document.getElementById("do").focus();}
</script>

<div class="form-container_large">

		<form  action="" method="post" name="codz" id="codz">



			<div class="container-fluid bg-form-titel">

				<div class="row">

					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">

						<div class="form-group row m-0">

				<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Invoice No : </label>

							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
							<input name="chalan_no" type="text" id="chalan_no" autocomplete="off"/>

							</div>

						</div>



					</div>
					
					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">

						<div class="form-group row m-0">

				<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company : </label>

							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
							 <select name="group_for" id="group_for" value="<?=$_POST['group_for'];?>" required>

                <option></option>
                <? user_company_access($group_for); ?>
              </select>
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
	
	
	

<?php /*?><div class="form-container_large">
<form action="item_return_adjustments.php" method="post" name="codz" id="codz">
<table width="70%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Invoice No : </strong></td>
    <td bgcolor="#FF9966"><strong>

<input name="chalan_no" type="text" id="chalan_no" autocomplete="off" />
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Open for Return" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong>
	
	</td>
  </tr>
</table>

</form>
</div><?php */?>

<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>