<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Bill Create';

create_combobox('do_no');

do_calander('#invoice_date');

//do_calander('#ldbc_no_date');

do_calander('#bill_date');



if($_POST['dealer_code']>0){

$_SESSION['new_biller'] = $_POST['dealer_code'];

}



if($_REQUEST['new']>0){

unset($_SESSION['new_biller']);

}



if ($data_found==0) {

 create_combobox('dealer_code');

  }





//Auto bill create every month start



$m_day = date('t',strtotime(date('Y-m-d')));

$m_s = date('Y-m-01');  

$m_e = date('Y-m-'.$m_day);
$today = date('Y-m-d');

$sqql = 'select b.*,c.short_name from crm_bill_assign b,crm_service_customer c where b.customer=c.customer_id and b.billing_cycle<="'.$today.'" and b.cycle="monthly" group by b.customer order by b.customer';

$qrry = db_query($sqql);

if(mysqli_num_rows($qrry)>0){

$crud = new crud('crm_bill_info');
$t_date = date('Y-m-d');
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
while($data=mysqli_fetch_object($qrry)){
$_POST['service_type'] = $data->service_id;
$f_date = $data->billing_cycle;
//if($data->bill_count==0) $total_bill = 1; else $total_bill= $data->bill_count;
//find_a_field('bill_assign','max(bill_count)+1','id="'.$details->id.'"');
$max_count = $data->bill_count+1;
for($i=$f_date;$i<=$t_date;$i = date('Y-m-d', strtotime( $i . " +1 month"))){


$_POST['mon'] = date('m',strtotime($i));

$_POST['year'] = date('Y',strtotime($i));


$_POST['manual_bill_no'] = 'ERP/BILL/'.$data->short_name.'/'.date('Y').'/'.$max_count;

$_POST['customer'] = $data->customer;

$_POST['bill_date'] = $i;

$_POST['amount'] = $data->service_charge;
$_POST['net_receivable_amt'] = $data->service_charge;

$master_id=$crud->insert();

$ssqqll = 'select * from crm_bill_assign where customer="'.$data->customer.'" and billing_cycle="'.$i.'" and cycle="monthly" order by customer';

$qqrryy=db_query($ssqqll);

while($details=mysqli_fetch_object($qqrryy)){

$insert = 'insert into crm_bill_details(`bill_no`,`customer`,`service_type`,`service_charge`) value("'.$master_id.'","'.$details->customer.'","'.$details->service_id.'","'.$details->service_charge.'")';

db_query($insert);
$next_billing_cycle = date("Y-m-d", strtotime("+1 month", strtotime($i)));
$billing_cycle_update = 'update crm_bill_assign set billing_cycle="'.$next_billing_cycle.'",bill_count="'.$max_count.'" where id="'.$details->id.'"';
db_query($billing_cycle_update);

}
$max_count++;
}
$max_count = 0;
unset($_POST);




}

}

//Auto bill create every month end


//Auto bill create for license



$m_day = date('t',strtotime(date('Y-m-d')));

$today = date('Y-m-d');  

$sqql = 'select b.*,c.short_name from crm_bill_assign b,crm_service_customer c where b.customer=c.customer_id and b.billing_cycle<="'.$today.'" and b.cycle="license" and b.billed=0 group by b.customer order by b.customer';

$qrry = db_query($sqql);

if(mysqli_num_rows($qrry)>0){

$crud = new crud('crm_bill_info');
$_POST['entry_by'] = $_SESSION['user']['id'];

$_POST['entry_at'] = date('Y-m-d H:i:s');

while($data=mysqli_fetch_object($qrry)){

$_POST['mon'] = date('m',strtotime($data->billing_cycle));

$_POST['year'] = date('Y',strtotime($data->billing_cycle));

if($data->bill_count==0) $total_bill = 1; else $total_bill= $data->bill_count;

$_POST['manual_bill_no'] = 'ERP/LF/'.$data->short_name.'/'.date('Y').'/'.$total_bill;

$_POST['customer'] = $data->customer;
$_POST['entry_by'] = $_SESSION['user']['id'];

$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['bill_date'] = $data->billing_cycle;
$_POST['service_type'] = $data->service_id;
$_POST['amount'] = $data->service_charge;
$_POST['net_receivable_amt'] = $data->service_charge;
$master_id=$crud->insert();



$ssqqll = 'select * from crm_bill_assign where customer="'.$data->customer.'" and billing_cycle<="'.$today.'" and cycle="license" and billed=0 order by customer';

$qqrryy=db_query($ssqqll);

while($details=mysqli_fetch_object($qqrryy)){

$insert = 'insert into crm_bill_details(`bill_no`,`customer`,`service_type`,`service_charge`) value("'.$master_id.'","'.$details->customer.'","'.$details->service_id.'","'.$details->service_charge.'")';

 db_query($insert);

 

//$next_billing_cycle = date("Y-m-d", strtotime("+1 year", strtotime($details->billing_cycle)));

$max_count = find_a_field('crm_bill_assign','max(bill_count)+1','id="'.$details->id.'"');

if($max_count==0 || $max_count==''){

$max_count = 001;

}

$billing_cycle_update = 'update crm_bill_assign set bill_count="'.$max_count.'",billed=1 where id="'.$details->id.'"';

db_query($billing_cycle_update);

}

unset($_POST);



}

}

//Auto bill create every year end



if(isset($_REQUEST['confirmit']))



{



$proj_id = 'clouderp'; 

$cc_code = '1';

$group_for =  $_SESSION['user']['group'];

$config_ledger = find_all_field('config_group_class','','group_for="'.$group_for.'"');

$sql = "select b.bill_no, d.customer_name, b.bill_date, b.manual_bill_no, b.status,b.customer,b.service_type,t.type as type_name,t.ledger_id as credit_ledger from crm_bill_info b, crm_service_customer d,crm_acc_bill_type t where b.customer=d.customer_id and b.status='PENDING' and b.customer='".$_SESSION['new_biller']."' and b.service_type=t.id";

$query = db_query($sql);

while($data=mysqli_fetch_object($query)){



if($_POST['check'.$data->bill_no]=='checked'){

        $jv_no=next_journal_sec_voucher_id();
		$tr_from = $data->type_name;
		
        $discount = $_POST['discount_amt'.$data->bill_no];

		$net_receivable = $_POST['net_receivable'.$data->bill_no];

        $jv_date = $data->bill_date;

        $tr_no = $data->bill_no;

        $customer_ledger = find_all_field('crm_service_customer','ledger_id','customer_id="'.$data->customer.'"');

		$narration = 'Bill For #'.$customer_ledger->customer_name.', Bill No.'.$data->manual_bill_no;

		$bill_amount  = find_a_field('crm_bill_details','sum(service_charge)','bill_no="'.$data->bill_no.'"'); 

		

		

		add_to_sec_journal($proj_id, $jv_no, $jv_date, $customer_ledger->ledger_id, $narration, $net_receivable,'0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);

if($_POST['discount_amt'.$data->bill_no]>0){

		add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->sales_discount, $narration, $discount, '0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
		}

		add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->credit_ledger, $narration, '0', $bill_amount, $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);

		

		

$update = 'update crm_bill_info set status="BILL SUBMITTED",discount_amt="'.$discount.'",net_receivable_amt="'.$net_receivable.'" where bill_no="'.$data->bill_no.'"';

db_query($update);
sec_journal_journal($jv_no,$jv_no,$tr_from);

}





		

}



}



if(isset($_POST['bill_create'])){



$crud      =new crud('crm_bill_info');



$_POST['entry_by'] = $_SESSION['user']['id'];

$_POST['entry_at'] = date('Y-m-d H:i:s');

$_POST['mon'] = date('m',strtotime($_POST['bill_date']));

$_POST['year'] = date('Y',strtotime($_POST['bill_date']));

/*$check = find_a_field('bill_info','bill_no','year="'.$_POST['year'].'" and mon="'.$_POST['mon'].'" and customer="'.$_POST['customer'].'" and service_type="'..'"');

if($check>0){

echo '<span style="color:red; font-weight:bold;">Already Bill Created For This Month!</span>';

}else{*/

$master_id=$crud->insert();

$crud      =new crud('crm_bill_details');

$_POST['bill_no'] = $master_id;

$_POST['service_charge'] = $_POST['amount'];

$crud->insert();

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

//}

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



document.getElementById('payment_amt_'+id).value = tot_due_amt;



}















</script>













<style>

/*

.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {

    color: #454545;

    text-decoration: none;

    display: none;

}*/





div.form-container_large input[type=checkbox] {

    width: 100%;

    height: 30px;

    /*border-radius: 0px !important;*/

}







</style>















	<div class="form-container_large">

		<form action="bill_submit.php" method="post" name="codz" id="codz">



			<? if ($_SESSION['new_biller']==0) { ?>

			<div class="container-fluid bg-form-titel">

				<div class="row">



					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">

						<div class="form-group row m-0">

							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Client Name : </label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

								<select name="dealer_code" id="dealer_code">

									<option></option>

									<?

									foreign_relation('crm_service_customer','customer_id','customer_name',$_POST['dealer_code'],'1');

									?>

								</select>

							</div>

						</div>

					</div>



					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">

						<input type="submit" name="submit" id="submit" value="View Invoice" class="btn1 btn1-bg-submit" />

					</div>



				</div>

			</div>





			<? }?>





			<? if($_SESSION['new_biller']>0){ ?>

			<!--        top form start hear-->

			<div class="container-fluid bg-form-titel">

				<div class="row">

					<!--left form-->

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

						<div class="container n-form2">



							<div class="form-group row m-0 pb-1">

								<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">



				<input   name="bill_date" type="text" id="bill_date"  value="<?=($bill_date!='')?$bill_date:date('Y-m-d')?>"   required autocomplete="off" />



								</div>

							</div>





							<div class="form-group row m-0 pb-1">

								<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

									<input name="customer" type="hidden" id="customer"  readonly="" value="<?=$_SESSION['new_biller'];?>"  required tabindex="105" />



									<? $dealer_data = find_all_field('crm_service_customer','','customer_id='.$_SESSION['new_biller']);



									?>



									<input name="dealer_name" type="text" id="dealer_name"  readonly="" value="<?=$dealer_data->customer_name;?>"  required tabindex="105" />





								</div>

							</div>





							<div class="form-group row m-0 pb-1">

								<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Billing Amount :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">



									<input name="amount" type="text" id="amount" value="<?=$dealer_data->service_charge?>" autocomplete="off"/>



								</div>

							</div>





						</div>





					</div>



					<!--Right form-->

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

						<div class="container n-form2">



							<div class="form-group row m-0 pb-1">

								<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Service Type :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">



									<select name="service_type" id="service_type">

										<option></option>

										<? foreign_relation('crm_acc_bill_type','id','type',$service_type,'1')?>

									</select>



								</div>

							</div>



							<div class="form-group row m-0 pb-1">

								<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Invoice No :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">



									<input  name="manual_bill_no" type="text" id="manual_bill_no"  value="<?=$_POST['manual_bill_no']?>"/>

								</div>

							</div>





							<div class="form-group row m-0 pb-1">

								<label for="po_no" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Remarks :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">



									<input name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks']?>" />



								</div>

							</div>









						</div>

					</div>

				</div>



				<div class="n-form-btn-class">

					<input type="submit" name="bill_create" id="bill_create" value="Create Bill" class="btn1 btn1-bg-submit" />



				</div>

			</div>

			<? }?>





			<div class="container-fluid pt-3 p-0">



				<table  id="grp"  class="table1  table-striped table-bordered table-hover table-sm">

					<thead class="thead1">

					<tr class="bgc-info">

						<th>Check</th>

						<th>Bill No</th>

						<th style=" width: 10%;">Bill Date</th>

						<th>Invoice Amount</th>

						<th>Discount Amount</th>

						<th>Net Payment</th>

						<th>Bill  Submit</th>

						<th>Show Invoice</th>

					</tr>

					</thead>



					<tbody class="tbody1">



					<?

					if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



					if($_POST['dealer_code']!='')

						$dealer_code_con=" and d.ledger_id=".$_POST['dealer_code'];



					if($_POST['do_no']!='')

						$do_no_con=" and j.tr_id=".$_POST['do_no'];



					$sql = "select b.bill_no,d.customer_name, b.bill_date, b.manual_bill_no, b.amount, b.status,b.service_type from crm_bill_info b, crm_service_customer d where b.customer=d.customer_id and b.status='PENDING' and b.customer='".$_SESSION['new_biller']."'";



					$query = db_query($sql);



					while($data=mysqli_fetch_object($query)){$i++;

						$service_type = find_a_field('crm_acc_bill_type','type','id="'.$data->service_type.'"');

						$bill_amount  = find_a_field('crm_bill_details','sum(service_charge)','bill_no="'.$data->bill_no.'"');



						?>



						<tr>

							<td><input type="checkbox" name="check<?=$data->bill_no?>" id="check<?=$data->bill_no?>" value="checked" /></td>

							<td><?=$data->manual_bill_no?></td>

							<td><?=$data->bill_date?></td>

							<td><input type="text" value="<?=$bill_amount?>" name="invoice_amt<?=$data->bill_no?>" id="invoice_amt<?=$data->bill_no?>" readonly="readonly" /></td>

							<td><input type="text" name="discount_amt<?=$data->bill_no?>" id="discount_amt<?=$data->bill_no?>" onblur="disc(<?=$data->bill_no?>)" /></td>

							<td><input type="text" value="<?=$bill_amount?>" name="net_receivable<?=$data->bill_no?>" id="net_receivable<?=$data->bill_no?>" readonly="readonly" /></td>

							<td><?=$data->status?></td>

							<td><a href="invoice_print_view.php?bill_no=<?=$data->bill_no?>" target="_blank">View Invoice</a></td>

						</tr>



					<? }?>



					</tbody>

				</table>



			</div>



				<div class="container-fluid p-0 ">



					<div class="n-form-btn-class">



						<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->

						<?

						if($_SESSION['new_biller']>0){

							?>

							<input name="confirmit" type="submit" class="btn1 btn1-bg-submit" value="BILL SUBMIT" />

						<? } ?>



					</div>



				</div>





		</form>



	</div>



















<?/*>

<br>

<br>

<br>

<br>

<br>

<br>

<br>







<div class="form-container_large">



<form action="bill_submit.php" method="post" name="codz" id="codz">



<? if ($_SESSION['new_biller']==0) { ?>



<div class="box" style="width:100%;">



								<table width="100%" border="0" cellspacing="0" cellpadding="0">



								  <tr>







    <td align="right" ><strong>Client Name : </strong></td>







    <td >

		<select name="dealer_code" id="dealer_code" style="width:220px;">

      <option></option>

      <?



foreign_relation('crm_service_customer','customer_id','customer_name',$_POST['dealer_code'],'1');



?>

    </select>



	</td>







    <td rowspan="4" ><strong>



      <input type="submit" name="submit" id="submit" value="View Invoice" class="btn1 btn1-submit-input" />



    </strong></td>

    </tr>

								  

								  

  

								  

								  

								  

								  

								  

								</table>



    </div>



<? }?>





<? if($_SESSION['new_biller']>0){ ?>





<div class="box" style="width:100%;">



								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">



								  <tr>



								 <td width="7%">DATE:</td>



									<td width="24%">

									

			<input style="width:220px; height:32px;"  name="bill_date" type="text" id="bill_date"  value="<?=($bill_date!='')?$bill_date:date('Y-m-d')?>"   required />

									</td>

									<td width="14%">VENDOR :</td>

									<td width="21%">

									

									<input name="customer" type="hidden" id="customer"  readonly="" style="width:220px; height:32px;" value="<?=$_SESSION['new_biller'];?>"  required tabindex="105" />

									

									<? $dealer_data = find_all_field('crm_service_customer','','customer_id='.$_SESSION['new_biller']);

									

									?>

									

										

									

									<input name="dealer_name" type="text" id="dealer_name"  readonly="" style="width:220px; height:32px;" value="<?=$dealer_data->customer_name;?>"  required tabindex="105" />



									</td>

									<td width="14%">Billing Amount :</td>

									<td width="20%">

									

									<table>

		  	<tr>

				<td>

					<input name="amount" type="text" id="amount" style="width:120px; height:32px;" value="<?=$dealer_data->service_charge?>" autocomplete="off"/>

				</td>

				<td></td>

			</tr>

		  </table>

									</td>

								  </tr>

								  

								  

  

								  

								  <tr>

								    <td>Remarks:</td>

								    <td>

									<input style="width:220px; height:32px;"  name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks']?>" />



									</td>

									<td>Service Type:</td>

								    <td>

									<select name="service_type" id="service_type">

									 <option></option>

									 <? foreign_relation('crm_acc_bill_type','id','type',$service_type,'1')?>

									</select>

									</td>

									

									<td>Invoice No.</td>

									<td>

									<input style="width:220px; height:32px;"  name="manual_bill_no" type="text" id="manual_bill_no"  value="<?=$_POST['manual_bill_no']?>"    />					</td>                               





									  <td>

									

								

							      </tr>

								  

								  <tr>

								    

									<td colspan="6" align="center">

									   <input type="submit" name="bill_create" id="bill_create" value="Create Bill" class="btn1 btn1-submit-input" />

									</td>

								

							      </tr>

								  

								  

								  

								</table>



    </div>

	

	<? }?>











<div class="tabledesign2" style="width:100%">



<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">



  <tr>

    <th width="12%">Check </th>

	<th width="12%">Bill No </th>

    <th width="15%">Bill Date </th>

    <th width="19%">Invoice Amount</th>

    <th width="12%">Discount Amount</th>

    <th width="12%">Net Payment</th>

    <th width="12%">Bill Submit </th>

	<th width="12%">Show Invoice</th>

  </tr>

  



  <?

  

  

  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

  

  

	

 if($_POST['dealer_code']!='')

  $dealer_code_con=" and d.ledger_id=".$_POST['dealer_code'];

  

 if($_POST['do_no']!='')

  $do_no_con=" and j.tr_id=".$_POST['do_no'];

  











   

    $sql = "select b.bill_no,d.customer_name, b.bill_date, b.manual_bill_no, b.amount, b.status,b.service_type from crm_bill_info b, crm_service_customer d where b.customer=d.customer_id and b.status='PENDING' and b.customer='".$_SESSION['new_biller']."'";







  $query = db_query($sql);







  while($data=mysqli_fetch_object($query)){$i++;

  $service_type = find_a_field('crm_acc_bill_type','type','id="'.$data->service_type.'"');

  $bill_amount  = find_a_field('crm_bill_details','sum(service_charge)','bill_no="'.$data->bill_no.'"'); 



  ?>











  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td><input type="checkbox" name="check<?=$data->bill_no?>" id="check<?=$data->bill_no?>" value="checked" /></td>

    <td><?=$data->manual_bill_no?></td>

	<td><?=$data->bill_date?></td>

	<td><input type="text" value="<?=$bill_amount?>" name="invoice_amt<?=$data->bill_no?>" id="invoice_amt<?=$data->bill_no?>" readonly="readonly" /></td>

	<td><input type="text" name="discount_amt<?=$data->bill_no?>" id="discount_amt<?=$data->bill_no?>" onblur="disc(<?=$data->bill_no?>)" /></td>

	<td><input type="text" value="<?=$bill_amount?>" name="net_receivable<?=$data->bill_no?>" id="net_receivable<?=$data->bill_no?>" readonly="readonly" /></td>

	<td><?=$data->status?></td>

	<td><a href="invoice_print_view.php?bill_no=<?=$data->bill_no?>" target="_blank">View Invoice</a></td>

  </tr>



  <? }?>

</table>







</div>

<br /><br />



<table width="100%" border="0">













<tr>



<td align="center">&nbsp;



</td>



<td align="center">

<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->

<?

if($_SESSION['new_biller']>0){

?>

<input name="confirmit" type="submit" class="btn1 btn1-submit-input" value="BILL SUBMIT" />

<? } ?>

</td>



</tr>







</table>



















<p>&nbsp;</p>



</form>



</div>



	<*/?>









<script>

  

  function disc(id){

   var invoice_amt = (document.getElementById('invoice_amt'+id).value)*1;

   var disc_amt = (document.getElementById('discount_amt'+id).value)*1;

   var net_recv = invoice_amt-disc_amt;

   document.getElementById('net_receivable'+id).value = net_recv;

  }



</script>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>