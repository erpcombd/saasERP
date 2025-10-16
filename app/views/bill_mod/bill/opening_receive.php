<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Opening Receive';
do_calander("#cheque_date");
create_combobox('bill_no');
do_calander('#invoice_date');
do_calander('#realization_date');
$data_found = $_POST['account_code'];
	if ($data_found==0) {
	create_combobox('account_code');
}
if(isset($_REQUEST['confirmit']))
		{
		$proj_id = 'clouderp'; 
		$cc_code = '1';
		$group_for =  $_SESSION['user']['group'];
		$config_ledger = find_all_field('config_group_class','','group_for="'.$group_for.'"');
		$jv_date=$_POST['invoice_date'];
		$bank_ledger=$_POST['dr_ledger_id'];
		$payment_method=$_POST['payment_method'];
		$group_for= $_SESSION['user']['group'];
		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		$cheque_no = $_POST['cheque_no'];
		$cheque_date = $_POST['cheque_date'];
		$ledger_id = $_POST['ledger_id'];
		$osql = "select j.*,a.ledger_name from journal j, accounts_ledger a where a.ledger_id=j.ledger_id and j.tr_from in ('MCOpening','LFOpening') and j.ledger_id='".$ledger_id."' and j.dr_amt>0";
		$oquery = db_query($osql);
			while($data=mysqli_fetch_object($oquery)){
			if($_POST['receipt_amt_'.$data->jv_no]>0)
				{
				$jv_no=next_journal_sec_voucher_id();
				$tr_from = $data->tr_from;
				$receipt_amt=$_POST['receipt_amt_'.$data->jv_no];
				$account_code=$_POST['account_code_'.$data->jv_no];
				$tr_no=$_POST['tr_no_'.$data->jv_no];
				if($_FILES['receive_att'.$data->jv_no]['tmp_name']!=''){
				$file_name= $_FILES['receive_att'.$data->jv_no]['name'];
				$file_tmp= $_FILES['receive_att'.$data->jv_no]['tmp_name'];
				$ext=end(explode('.',$file_name));
				$path='../../../../resource/newerp/bill/';
				$rand = rand();
				$uploaded_file = $path.$rand.'.'.$ext;
				$file_name = $rand.'.'.$ext;
				unlink($uploaded_file);
				db_query('delete from document_upload where master_id="'.$rand.'" and tr_from="BillReceive"');
				move_uploaded_file($file_tmp, $uploaded_file);
				$file_insert = 'insert into document_upload (`master_id`,`tr_from`,`file_name`,`entry_at`,`entry_by`) value("'.$data->bill_no.'","BillReceive","'.$uploaded_file.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
				db_query($file_insert);
				}
				$tr_no = $data->tr_no;
				$customer_ledger = $ledger_id;
				$narration = 'Opening bill receive';
				add_to_sec_journal($proj_id, $jv_no, $jv_date, $bank_ledger, $narration, $receipt_amt, '0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
				add_to_sec_journal($proj_id, $jv_no, $jv_date,$customer_ledger, $narration,'0', $receipt_amt, $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
				sec_journal_journal($jv_no,$jv_no,$tr_from);
				}
			}
		echo "<script>window.top.location='opening_receive.php'</script>";
}
?>
<script>
	function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp=false;	
		try{
		xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
		try{			
		xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
		try{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e1){
		xmlhttp=false;
		}
		}
		}
	return xmlhttp;
}
function update_value(pi_id)
	{
	var pi_id=pi_id; // Rent
	var lc_no=(document.getElementById('lc_no').value);
	var flag=(document.getElementById('flag_'+pi_id).value); 
	var strURL="lc_update_ajax.php?pi_id="+pi_id+"&lc_no="+lc_no+"&flag="+flag;
	var req = getXMLHTTP();
		if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
			// only if "OK"
			if (req.status == 200) {						
			document.getElementById('divi_'+pi_id).style.display='inline';
			document.getElementById('divi_'+pi_id).innerHTML=req.responseText;						
			} else {
			alert("There was a problem while using XMLHTTP:\n" + req.statusText);
			}
			}				
		}
		req.open("GET", strURL, true);
		req.send(null);
		}	
}
	function sum_sum(id){
		var tot_due_amt = (document.getElementById('tot_due_amt_'+id).value)*1;
		document.getElementById('receipt_amt_'+id).value = tot_due_amt;
	}
</script>
<div class="form-container_large">
	<form action="" method="post" name="codz" id="codz" enctype="multipart/form-data">
	<? if ($data_found==0) { ?>
	<div class="container-fluid bg-form-titel">
	<div class="row">
	<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
	<div class="form-group row m-0">
	<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Name :</label>
	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
	<select name="account_code" id="account_code">
	<option></option>
	<?
	foreign_relation('service_customer','customer_id','customer_name',$_POST['dealer_code'],'1');
	?>
	</select>
	</div>
	</div>
	</div>
	<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
	<input type="submit" name="submit" id="submit" class="btn1 btn1-bg-submit" value="View Invoice"/>
	</div>
	</div>
	</div>
	<? }?>
	<? if(isset($_POST['submit'])){ ?>
	<!--        top form start hear-->
	<div class="container-fluid bg-form-titel">
	<div class="row">
	<!--left form-->
	<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
	<div class="container n-form2">
	<div class="form-group row m-0 pb-1">
	<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date :</label>
	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
	<input name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />
	</div>
	</div>
	<div class="form-group row m-0 pb-1">
	<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Received From :</label>
	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
	<input name="account_code" type="hidden" id="account_code"  readonly="" style="width:220px; height:32px;" value="<?=$_POST['account_code'];?>"  required tabindex="105" />
	<? $dealer_data = find_all_field('dealer_info','','account_code='.$_POST['account_code']);
	$dealer_closing = find_a_field_sql("select sum(dr_amt-cr_amt) from journal where ledger_id = '".$_POST['account_code']."'");
	$closing_balance=$dealer_closing;
	?>
	<input name="received_from" type="text" id="received_from"  readonly="" style="width:220px; height:32px;" value="<?=$dealer_data->dealer_name_e;?>"  required tabindex="105" />
	</div>
	</div>
	<div class="form-group row m-0 pb-1">
	<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Balance :</label>
	<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0 pr-2 ">
	<input name="custemer_balance" type="text" id="custemer_balance" required readonly="" autocomplete="off"
	value="<? if ($dealer_closing>0) { echo  number_format($closing_balance,2). ""; } else { echo number_format($closing_balance*(-1),2). ""; }?>"/>
	</div>
	<div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
	<? 	if ($dealer_closing>0) { echo  "<b>(DR)</b>"; } else { echo  "<b>(CR)</b>"; } ?>
	</div>
	</div>
	<div class="form-group row m-0 pb-1">
	<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bill No :</label>
	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
	<select name="bill_no" id="bill_no" >
	<option></option>
	<? foreign_relation('bill_info','bill_no','manual_bill_no',$_POST['bill_no'],'status="BILL SUBMITTED"'); ?>
	</select>
	</div>
	</div>
	<div class="form-group row m-0 pb-1">
	<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PMT. Method :</label>
	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
	<select name="payment_method" id="payment_method" required  onchange="getData2('cash_bank_ajax.php', 'cash_bank_filter',        this.value,  document.getElementById('payment_method').value);">
	<option></option>
	<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1');?>
	</select>
	</div>
	</div>
	</div>
	</div>
	<!--Right form-->
	<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
	<div class="container n-form2">
	<div class="form-group row m-0 pb-1">
	<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cash/Bank :</label>
	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
	<span id="cash_bank_filter">
	<select name="dr_ledger_id" id="dr_ledger_id" required="required">
	<option></option>
	<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['dr_ledger_id'],'ledger_group_id in (10201,10202)');?>
	</select>
	</span>
	</div>
	</div>
	<div class="form-group row m-0 pb-1">
	<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Of Bank :</label>
	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
	<input name="of_bank" type="text" id="of_bank"  value="<?=$_POST['of_bank']?>" />
	</div>
	</div>
	<div class="form-group row m-0 pb-1">
	<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cheque No :</label>
	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
	<input name="cheque_no" type="text" id="cheque_no"  value="<?=$_POST['cheque_no']?>"/>
	</div>
	</div>
	<div class="form-group row m-0 pb-1">
	<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cheque Date :</label>
	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
	<input  name="cheque_date" type="text" id="cheque_date"  value="<?=$_POST['cheque_date']?>"/>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<? }?>
	<? if(isset($_POST['submit'])){ ?>
	<div class="container-fluid pt-3 p-0">
	<table  id="grp"  class="table1  table-striped table-bordered table-hover table-sm">
	<thead class="thead1">
	<tr class="bgc-info">
	<th>SL</th>
	<th>Bill No </th>
	<th>Invoice Type</th>
	<th>Invoice Date </th>
	<th>Invoice Amt </th>
	<th>Total Paid Amt </th>
	<th>Due Amt </th>
	<th>Receipt Amt </th>
	<th>Action</th>
	<th width="17%">Invoice View</th>
	</tr>
	</thead>
	<tbody class="tbody1">
	<?
	$ledger_id = find_a_field('service_customer','ledger_id','customer_id="'.$_POST['account_code'].'"');
	$osql = "select j.*,a.ledger_name from journal j, accounts_ledger a where a.ledger_id=j.ledger_id and j.tr_from in ('MCOpening','LFOpening') and j.ledger_id='".$ledger_id."' and dr_amt>0";
	$oquery = db_query($osql);
	while($data=mysqli_fetch_object($oquery)){$i++;
	$op_net_pay = $data->dr_amt-$data->discount_amt;
	$op_received_amt = find_a_field('journal','sum(cr_amt)','ledger_id="'.$ledger_id.'" and tr_from="'.$data->tr_from.'"');
	?>
	<tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
	<td><?=++$i;?></td>
	<td><?=$data->jv_no?></td>
	<td><?=$data->tr_from?></td>
	<td><?php echo date('d-m-Y',strtotime($data->jv_date));?></td>
	<td><strong>
	<?=number_format($op_net_pay,2);?>
	</strong></td>
	<td><strong>
	<?=number_format($op_received_amt,2);?>
	</strong></td>
	<td><strong><? echo number_format($op_due_amt=$op_net_pay-$op_received_amt,2);?></strong>
	<input name="tot_due_amt_<?=$data->jv_no?>" id="tot_due_amt_<?=$data->jv_no?>" type="hidden" size="10"  value="<?=$op_due_amt?>" />	
	<input type="hidden" name="ledger_id" id="ledger_id" value="<?=$ledger_id?>" /></td>
	<td>
	<input name="account_code_<?=$data->jv_no?>" id="account_code_<?=$data->jv_no?>" type="hidden" size="10"  value="<?=$data->ledger_id?>" />
	<input name="tr_no_<?=$data->jv_no?>" id="tr_no_<?=$data->jv_no?>" type="hidden" size="10"  value="<?=$data->tr_no?>" />
	<input name="receipt_amt_<?=$data->jv_no?>" id="receipt_amt_<?=$data->jv_no?>" type="text" size="10"  value=""  />	</td>
	<td align="center"><center><button onclick="sum_sum(<?=$data->jv_no?>)" type="button" class="btn1 btn1-bg-submit" >Full</button></center></td>
	<td><input type="file" name="receive_att<?=$data->jv_no?>" id="receive_att<?=$data->jv_no?>"  /></td>
	</tr>
	<? } ?>
	</tbody>
	</table>
	</div>
	<div class="container-fluid p-0 ">
	<div class="n-form-btn-class">
	<input name="confirmit" type="submit" class="btn1 btn1-bg-submit" value="Save & New"/>
	</div>
	</div>
	<? }?>
	</form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>