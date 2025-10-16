<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Sales Invoice Wise Receipt Voucher';

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

        $jv_no=next_journal_sec_voucher_id();

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

	



		 $sql = "select b.bill_no,d.customer_name, b.bill_date, b.manual_bill_no, b.amount, b.status,d.ledger_id,b.customer,t.type as type_name from bill_info b, service_customer d,acc_bill_type t where b.customer=d.customer_id and b.status='BILL SUBMITTED' and b.service_type=t.id ".$con."";



		$query = db_query($sql);


		while($data=mysqli_fetch_object($query))



		{


			if($_POST['receipt_amt_'.$data->bill_no]>0)



			{

			$discount = $_POST['discount_'.$data->bill_no];
			$tax = $_POST['tax_'.$data->bill_no];
            $tr_from = $data->type_name.' Receive';
			$receipt_amt=$_POST['receipt_amt_'.$data->bill_no];
			$total_receivable = $_POST['tot_due_amt_'.$data->bill_no];
			$account_code=$_POST['account_code_'.$data->bill_no];
			

		     $tr_no=$_POST['tr_no_'.$data->bill_no];

			

			if($_FILES['receive_att'.$data->bill_no]['tmp_name']!=''){

		               

						$file_name= $_FILES['receive_att'.$data->bill_no]['name'];

			

						$file_tmp= $_FILES['receive_att'.$data->bill_no]['tmp_name'];

			

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

			

	



        $tr_no = $data->bill_no;

        $customer_ledger = find_all_field('service_customer','ledger_id','customer_id="'.$data->customer.'"');

		$narration = 'Bill Receive #'.$customer_ledger->customer_name.', Bill No.'.$data->manual_bill_no;


        add_to_sec_journal($proj_id, $jv_no, $jv_date, $customer_ledger->ledger_id, $narration,'0', $total_receivable, $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
		if($discount>0){
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->sales_discount, $narration, $discount,'0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
		}
		if($tax>0){
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->tds, $narration, $tax,'0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
		}
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $bank_ledger, $narration, $receipt_amt, '0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);

		

		

		

 	$bill_amount  = find_a_field('bill_info','sum(net_receivable_amt)','bill_no="'.$data->bill_no.'"'); 

 $receive_journal_amt = find_a_field('secondary_journal','sum(cr_amt)','ledger_id="'.$data->ledger_id.'" and tr_no="'.$data->bill_no.'" and tr_from="BillReceive"');

if($receive_journal_amt>=$bill_amount){

 $update = 'update bill_info set status="BILL RECEIVED",bank="'.$bank_ledger.'",cheque_no="'.$cheque_no.'",checkq_date="'.$cheque_date.'",receive_date="'.$jv_date.'",bill_received_by="'.$_SESSION['user']['id'].'",bill_received_at="'.date('Y-m-d H:i:s').'" where bill_no="'.$data->bill_no.'"';

 db_query($update);

 }







}



}







sec_journal_journal($jv_no,$jv_no,$tr_from);


echo "<script>window.top.location='bill_receive.php'</script>";
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
var discount = (document.getElementById('discount_'+id).value)*1;
var tax = (document.getElementById('tax_'+id).value)*1;

if(discount>tot_due_amt){
alert('Overflow!');
document.getElementById('discount_'+id).value = 0;
discount = 0;
}

if(tax>tot_due_amt){
alert('Overflow!');
document.getElementById('tax_'+id).value = 0;
tax = 0;
}

var rest_amt = tot_due_amt-(discount+tax);



document.getElementById('receipt_amt_'+id).value = rest_amt;



}















</script>













<style>

/*

.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {

    color: #454545;

    text-decoration: none;

    display: none;

}*/





/*div.form-container_large input {*/

    /*width: 200px;*/

    /*height: 38px;*/

    /*border-radius: 0px !important;*/

/*}*/







</style>















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



										<input name="received_from" type="text" id="received_from" style="width:220px; height:32px;" value="<?=$dealer_data->dealer_name_e;?>" tabindex="105" />





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

						<th width="10%">Discount Amount</th>
						<th width="10%">Tax Amount</th>
						<th width="10%">Receipt Amt </th>

						<th width="17%">Invoice View</th>
					</tr>
					</thead>



					<tbody class="tbody1">





					<?







					if($_POST['f_date']!=''&&$_POST['t_date']!='') {$con = ' and b.bill_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';}







					if($_POST['account_code']!='')

						{$con .=" and b.customer=".$_POST['account_code'];}







					$sql = "select b.bill_no,d.customer_name, b.bill_date, b.manual_bill_no, b.status,d.ledger_id,b.discount_amt,t.type as type_name from bill_info b, service_customer d,acc_bill_type t where b.customer=d.customer_id and b.status='BILL SUBMITTED' and t.id=b.service_type ".$con."";







					$query = db_query($sql);





					while($data=mysqli_fetch_object($query)){$i++;



		$invoice_amt = find_a_field('bill_details','sum(service_charge)','bill_no="'.$data->bill_no.'"');

		$net_pay = $invoice_amt-$data->discount_amt;

		$received_amt = find_a_field('journal','sum(cr_amt)','ledger_id="'.$data->ledger_id.'" and tr_no="'.$data->bill_no.'" and tr_from="'.$data->type_name.' Receive"');

						?>









						<tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

							<td><?=++$i;?></td>

							<td><a href="invoice_print_view.php?bill_no=<?=$data->bill_no?>" target="_blank"><span class="style13" >

      <?=$data->manual_bill_no?>

    </span></a><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data->manual_bill_no?>"></a></td>



							<td><?=$data->type_name?></td>
							<td><?php echo date('d-m-Y',strtotime($data->bill_date));?></td>

							<td><strong>

									<?=number_format($net_pay,2);?>

								</strong></td>

							<td><strong>

									<?=number_format($received_amt,2);?>

								</strong></td>

							<td><strong><? echo number_format($due_amt=$net_pay-$received_amt,2);?></strong>

								<input name="tot_due_amt_<?=$data->bill_no?>" id="tot_due_amt_<?=$data->bill_no?>" type="hidden" value="<?=$due_amt?>" />							</td>

							<td><input name="discount_<?=$data->bill_no?>" id="discount_<?=$data->bill_no?>" type="text" value="" onchange="sum_sum(<?=$data->bill_no?>)"  /></td>
							<td><input name="tax_<?=$data->bill_no?>" id="tax_<?=$data->bill_no?>" type="text" value="" onchange="sum_sum(<?=$data->bill_no?>)"  /></td>
							<td>

								<input name="account_code_<?=$data->bill_no?>" id="account_code_<?=$data->bill_no?>" type="hidden" size="10"  value="<?=$data->ledger_id?>" />

								<input name="tr_no_<?=$data->bill_no?>" id="tr_no_<?=$data->bill_no?>" type="hidden" size="10"  value="<?=$data->bill_no?>" />

								<input name="receipt_amt_<?=$data->bill_no?>" id="receipt_amt_<?=$data->bill_no?>" type="text" value="" />	</td>

							<td><input type="file" name="receive_att<?=$data->bill_no?>" id="receive_att<?=$data->bill_no?>"  /></td>
						</tr>



					<?  }?>
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

















<?/*>

	<br>

<br>

<br>

<br>

<br>





<div class="form-container_large">



<form action="" method="post" name="codz" id="codz" enctype="multipart/form-data">



<? if ($data_found==0) { ?>



<div class="box" style="width:100%;">





<table width="100%" border="0" cellspacing="0" cellpadding="0">

 <tr>



    <td align="right" ><strong>Customer Name : </strong></td>







    <td >

		<select name="account_code" id="account_code" style="width:220px;">

      <option></option>

      <?



foreign_relation('service_customer','customer_id','customer_name',$_POST['dealer_code'],'1');



?>

    </select>



	</td>







    <td rowspan="4" ><strong>



      <input type="submit" name="submit" id="submit"  class="btn1 btn1-submit-input"value="View Invoice"/>



    </strong></td>

    </tr>

								  

					  

								  

								</table>



    </div>



<? }?>





<? if(isset($_POST['submit'])){ ?>





<div class="box" style="width:100%;">



								

 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">



	 <tr>

	 <td width="7%"> <strong>DATE:</strong></td>

	 

	 <td width="24%">							

	 <input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />									     </td>

	 

   	<td width="14%"><strong>RECEIVED FROM :</strong></td>

	 <td width="21%">



	<input name="account_code" type="hidden" id="account_code"  readonly="" style="width:220px; height:32px;" value="<?=$_POST['account_code'];?>"  required tabindex="105" />

									

									<? $dealer_data = find_all_field('dealer_info','','account_code='.$_POST['account_code']); 

									$dealer_closing = find_a_field_sql("select sum(dr_amt-cr_amt) from journal where ledger_id = '".$_POST['account_code']."'");

	

									$closing_balance=$dealer_closing;

									?>

																		

         <input name="received_from" type="text" id="received_from"  readonly="" style="width:220px; height:32px;" value="<?=$dealer_data->dealer_name_e;?>"  required tabindex="105" />



	 </td>

									

									

									

			<td width="14%"><strong>CUSTOMER BALANCE :</strong></td>

			<td width="20%">

									

			<table>

		  	<tr>

				<td>

					<input name="custemer_balance" type="text" id="custemer_balance" required readonly="" style="width:120px; height:32px; " autocomplete="off"

				 value="<? if ($dealer_closing>0) { echo  number_format($closing_balance,2). ""; } else { echo number_format($closing_balance*(-1),2). ""; }?>"/>



				</td>

				<td>

					<? 	if ($dealer_closing>0) { echo  "<b>(DR)</b>"; } else { echo  "<b>(CR)</b>"; } ?>



				</td>

			</tr>

		   </table>

		   </td>						

		  </tr>

								  

								  

  

			  <tr>

			  <td> <strong>Bill No:</strong></td>

			 <td>



	<select name="bill_no" id="bill_no" style="width:220px;">

	

	<option></option>



        <? foreign_relation('bill_info','bill_no','manual_bill_no',$_POST['bill_no'],'status="BILL SUBMITTED"'); ?>



    </select>

			 </td>

									<td><strong>PMT. METHOD:</strong></td>

									<td>

								

									<select name="payment_method" id="payment_method" required style="width:220px;" onchange="getData2('cash_bank_ajax.php', 'cash_bank_filter',        this.value,  document.getElementById('payment_method').value);">

									<option></option>

	

								

										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1');?>

									</select>



																											</td>

									<td><strong>CASH/BANK:</strong></td>

									<td>

										<span id="cash_bank_filter">

									

									

									<select name="dr_ledger_id" id="dr_ledger_id" required="required" style="width:220px;">

									  <option></option>

									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['dr_ledger_id'],'ledger_group_id in (10201,10202)');?>

									</select>

									</span>



									</td>

								  </tr>

								  <tr>

								    <td> <strong>CHEQUE NO:</strong></td>

								    <td>

									<input style="width:220px; height:32px;"  name="cheque_no" type="text" id="cheque_no"  value="<?=$_POST['cheque_no']?>"    />



									</td>

								    <td><strong>CHEQUE DATE:</strong></td>

								    <td><input style="width:220px; height:32px;"  name="cheque_date" type="text" id="cheque_date"  value="<?=$_POST['cheque_date']?>"    />		</td>

								    <td><strong>OF BANK: </strong></td>

								    <td>

									<input style="width:220px; height:32px;"  name="of_bank" type="text" id="of_bank"  value="<?=$_POST['of_bank']?>"    />	

									</span>

									</td>

							      </tr>

								  

								  

								  

								</table>



    </div>

	

	<? }?>







<? if(isset($_POST['submit'])){ ?>



<div class="tabledesign2" style="width:100%">



<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">



  <tr>

    <th width="5%">SL</th>



    <th width="15%">Bill No </th>



    <th width="10%">Invoice Date </th>

    <th width="12%">Invoice Amt </th>

    <th width="11%">Total Pay  Amt </th>

    <th width="9%">Due Amt </th>

    <th width="11%">Receipt Amt </th>

    <th width="11%">Action</th>

	<th width="15%">Invoice View</th>

  </tr>

  



  <?

  



   

    if($_POST['f_date']!=''&&$_POST['t_date']!='') $con = ' and b.bill_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';

  

  

	

 if($_POST['account_code']!='')

  $con .=" and b.customer=".$_POST['account_code'];

  

 

   

    $sql = "select b.bill_no,d.customer_name, b.bill_date, b.manual_bill_no, b.status,d.ledger_id,b.discount_amt from bill_info b, service_customer d where b.customer=d.customer_id and b.status='BILL SUBMITTED' ".$con."";







  $query = db_query($sql);





  while($data=mysqli_fetch_object($query)){$i++;



$invoice_amt = find_a_field('bill_details','sum(service_charge)','bill_no="'.$data->bill_no.'"'); 

$net_pay = $invoice_amt-$data->discount_amt;

$received_amt = find_a_field('journal','sum(cr_amt)','ledger_id="'.$data->ledger_id.'" and tr_no="'.$data->bill_no.'"');

  ?>









  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td><?=++$i;?></td>

    <td><a href="invoice_print_view.php?bill_no=<?=$data->bill_no?>" target="_blank"><span class="style13" style="color:#000000; font-weight:700;">

      <?=$data->manual_bill_no?>

    </span></a><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data->manual_bill_no?>"></a></td>



    <td><?php echo date('d-m-Y',strtotime($data->bill_date));?></td>

    <td><strong>

      <?=number_format($net_pay,2);?>

    </strong></td>

    <td><strong>

      <?=number_format($received_amt,2);?>

    </strong></td>

    <td><strong><? echo number_format($due_amt=$net_pay-$received_amt,2);?></strong>

	<input name="tot_due_amt_<?=$data->bill_no?>" id="tot_due_amt_<?=$data->bill_no?>" type="hidden" size="10"  value="<?=$due_amt?>" style="width:80px;" />

	</td>

    <td>

	<input name="account_code_<?=$data->bill_no?>" id="account_code_<?=$data->bill_no?>" type="hidden" size="10"  value="<?=$data->ledger_id?>" style="width:80px;" />

 <input name="tr_no_<?=$data->bill_no?>" id="tr_no_<?=$data->bill_no?>" type="hidden" size="10"  value="<?=$data->bill_no?>" style="width:80px;" />

 <input name="receipt_amt_<?=$data->bill_no?>" id="receipt_amt_<?=$data->bill_no?>" type="text" size="10"  value="" style="width:120px; height:25px;"  />	</td>

    <td align="center"><center><button onclick="sum_sum(<?=$data->bill_no?>)" type="button" class="btn1 btn1-bg-submit" >Full</button></center></td>

	<td><input type="file" name="receive_att<?=$data->bill_no?>" id="receive_att<?=$data->bill_no?>" style="width:100px;" /></td>

  </tr>



  <?  }?>

</table>







</div>

<br /><br />



<table width="100%" border="0">













<tr>



<td align="center">&nbsp;



</td>



<td align="center">

<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->

<input name="confirmit" type="submit" class="btn1 btn1-submit-input" value="SAVE & NEW"  />



</td>



</tr>







</table>





//<?php /*?><table width="100%" border="0">

//

//<?

//

// 		$pi_status = find_a_field('pi_master','status','id="'.$_POST['pi_id'].'"');

//		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);

//

//

//if($pi_status!="MANUAL"){

//

//

//

//

//?>

//

//<tr>

//

//<td colspan="2" align="center" bgcolor="#FF3333"><strong> Master PI Data Entry Completed</strong></td>

//

//</tr>

//

//<? }else{?>

//

//<tr>

//

//<td align="center">&nbsp;

//

//</td>

//

//<td align="center">

//<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->

//<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

//

//</tr>

//

//<? }?>

//

//</table><?php?>









<? }?>



<p>&nbsp;</p>



</form>



</div>





	<*/?>











<?


require_once SERVER_CORE."routing/layout.bottom.php";



?>