<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Insurance Payment Voucher';


  

do_calander('#invoice_date');
//do_calander('#ldbc_no_date');
do_calander('#cheque_date');

 $data_found = $_POST['lc_no'];

if ($data_found==0) {
 create_combobox('lc_no');
 create_combobox('insurance_company');
  }



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$payment_date=$_POST['invoice_date'];
		$cr_ledger_id=$_POST['cr_ledger_id'];
		$lc_no=$_POST['lc_no'];
		$ledger_id=$_POST['ledger_id'];
		$lc_number=$_POST['lc_number'];
		$group_for=$_POST['group_for'];
		$insurance_no=$_POST['insurance_no'];
		$cheque_no=$_POST['cheque_no'];
		$cheque_date=$_POST['cheque_date'];
		$of_bank=$_POST['of_bank'];
		

  
 if($_POST['po_no']!='')
  $po_no_con=" and j.tr_id=".$_POST['po_no'];
  


		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		
		//$YR = date('Y',strtotime($ch_date));
//  		$yer = date('y',strtotime($ch_date));
//  		$month = date('m',strtotime($ch_date));
//
//  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
//   		$cy_id = sprintf("%07d", $ch_cy_id);
//   		$chalan_no=''.$yer.''.$month.''.$cy_id;


		
		$payment_no = next_transection_no($group_for,$payment_date,'insurance_payment_voucher','payment_no');


		 $sql = "SELECT company_id, ledger_id, company_name FROM insurance_company WHERE 1 group by company_id";

		$query = db_query($sql);

	


		while($data=mysqli_fetch_object($query))

		{
	

			if($_POST['payment_amt_'.$data->company_id]>0)

			{

				$company_id=$_POST['company_id_'.$data->company_id];
				$account_code=$_POST['account_code_'.$data->company_id];
				$payment_amt=$_POST['payment_amt_'.$data->company_id];
				$remarks=$_POST['remarks_'.$data->company_id];

   $ins_invoice = 'INSERT INTO insurance_payment_voucher (payment_no, payment_date, insurance_no, group_for, lc_no, lc_number, ledger_id, company_id, company_ledger, cr_ledger_id, payment_amt, remarks, cheque_no, cheque_date, of_bank,  entry_at, entry_by)
  
  VALUES("'.$payment_no.'", "'.$payment_date.'", "'.$insurance_no.'", "'.$group_for.'", "'.$lc_no.'", "'.$lc_number.'", "'.$ledger_id.'", "'.$company_id.'", "'.$account_code.'", "'.$cr_ledger_id.'", "'.$payment_amt.'", "'.$remarks.'","'.$cheque_no.'","'.$cheque_date.'", "'.$of_bank.'", "'.$entry_by.'", "'.$entry_at.'")';

db_query($ins_invoice);


}

}


if($payment_no>0)
{
auto_insert_insurance_payment_secoundary($payment_no);
}

?>

<script language="javascript">
window.location.href = "insurance_payment.php";
</script>

<?	

}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

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


div.form-container_large input {
    width: 200px;
    height: 38px;
    border-radius: 0px !important;
}



</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td align="right" ><strong>L/C No: </strong></td>



    <td ><select name="lc_no" id="lc_no" style="width:220px;">
      <option></option>
      <?

foreign_relation('lc_number_setup','id','lc_number',$_POST['lc_no'],'status="CHECKED"');

?>
    </select></td>
	
	
	 <td align="right" ><strong>Insurance Company: </strong></td>



    <td ><select name="insurance_company" id="insurance_company" required style="width:220px;">
      <option></option>
      <?

foreign_relation('insurance_company','company_id','company_name',$_POST['insurance_company'],'1');

?>
    </select></td>



    <td rowspan="4" ><strong>

      <input type="submit" name="submit" id="submit" value="View Data" style="width:180px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>
    </tr>
								  
								  
  
								  
								  
								  
								  
								  
								</table>

    </div>

<? }?>


<? if(isset($_POST['submit'])){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>

								 <td width="11%">DATE:</td>

									<td width="20%">
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />									</td>
									<td width="14%">L/C NO  :</td>
									<td width="21%">
									
									<? $lc_data = find_all_field('lc_number_setup','','id='.$_POST['lc_no']); 
									$dealer_closing = find_a_field_sql("select sum(dr_amt-cr_amt) from journal where ledger_id = '".$_POST['account_code']."'");
	
									?>
									
					<input name="group_for" type="hidden" id="group_for"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->group_for;?>"  required tabindex="105" />
									
					<input name="lc_no" type="hidden" id="lc_no"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->id;?>"  required tabindex="105" />
									
					<input name="ledger_id" type="hidden" id="ledger_id"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->ledger_id;?>"  required tabindex="105" />
									
				<input name="lc_number" type="text" id="lc_number"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->lc_number;?>"  required tabindex="105" />										</td>
									<td width="14%">COMPANY :</td>
									<td width="20%">
									
									<table>
		  	<tr>
				<td><input name="company" type="text" id="company"  readonly="" style="width:220px; height:32px;" value="<?=find_a_field('user_group','group_name','id='.$lc_data->group_for); ?>"   tabindex="105" />	</td>
				
			</tr>
		  </table>
									</td>
								  </tr>
								  
								  
  
								  <tr>

								 <td>INSURANCE NO:</td>

									<td>

	<input name="insurance_no" type="text" id="insurance_no"   style="width:220px; height:32px;" value="<?=$_POST['insurance_no'];?>"   tabindex="105" />									</td>
									<td>PMT. METHOD:</td>
									<td>
								
									<select name="payment_method" id="payment_method" required style="width:220px;" onchange="getData2('cash_bank_ajax.php', 'cash_bank_filter', this.value,  document.getElementById('payment_method').value);">
									<option></option>
	
								
										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1');?>
									</select>
																											</td>
									<td>CASH/BANK:</td>
									<td><span id="cash_bank_filter">
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id in (10210,10211)');?>
									</select>
									</span>										</td>
								  </tr>
								  <tr>
								    <td>CHEQUE NO:</td>
								    <td>
									<input style="width:220px; height:32px;"  name="cheque_no" type="text" id="cheque_no"  value="<?=$_POST['cheque_no']?>"    />									</td>
								    <td>CHEQUE DATE:</td>
								    <td><input style="width:220px; height:32px;"  name="cheque_date" type="text" id="cheque_date"  value="<?=$_POST['cheque_date']?>"    />		</td>
								    <td>OF BANK:</td>
								    <td>
									<input style="width:220px; height:32px;"  name="of_bank" type="text" id="of_bank"  value="<?=$_POST['of_bank']?>"    />	
									</span>									</td>
							      </tr>
								  
								  
								  
								</table>

    </div>
	
	<? }?>



<? if(isset($_POST['submit'])){ ?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>
    <th width="6%">ID</th>

    <th width="15%">GL Code </th>

    <th width="33%">Insurance Company </th>
    <th width="15%">Payment Amt </th>
    <th width="15%">Remarks</th>
  </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['insurance_company']!='')
  $insurance_con=" and company_id=".$_POST['insurance_company'];
  




  
//$sql = "select sum(dr_amt) as payment_amt, ledger_id, tr_id  from journal where tr_from='Payment' group by tr_id ";
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query)){
//$payment_amt[$data->ledger_id][$data->tr_id]=$data->payment_amt;
//}
  
  
  
 //$sql = "select sum(dr_amt) as return_amt, ledger_id, tr_id  from journal where tr_from='Purchase Return'  group by tr_id";
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query)){
//$return_amt[$data->ledger_id][$data->tr_id]=$data->return_amt;
//}
 
  


   
    $sql = "SELECT company_id, ledger_id, company_name FROM insurance_company WHERE 1 ".$insurance_con." group by company_id";



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){$i++;


  ?>



<? //if ($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no]>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><span class="style13" style="color:#000000; font-weight:700;">
      <?=$data->company_id;?>
    </span></td>

    <td><span class="style13" style="color:#000000; font-weight:700;">
      <?=$data->ledger_id?>
    </span></td>

    <td><?=$data->company_name;?></td>
    <td>
	
	<input name="company_id_<?=$data->company_id?>" id="company_id_<?=$data->company_id?>" type="hidden" size="10"  value="<?=$data->company_id?>" style="width:80px;" />
	<input name="account_code_<?=$data->company_id?>" id="account_code_<?=$data->company_id?>" type="hidden" size="10"  value="<?=$data->ledger_id?>" style="width:80px;" />
 
 <input name="payment_amt_<?=$data->company_id?>" id="payment_amt_<?=$data->company_id?>" type="text" size="10"  value="" style="width:120px; height:25px;"  />	</td>
    <td align="center"><input name="remarks_<?=$data->company_id?>" id="remarks_<?=$data->company_id?>" type="text"   value="" style="width:200px; height:25px;"  />	</td>
  </tr>

  <? } //}?>
</table>



</div>
<br /><br />

<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirmit" type="submit" class="btn1" value="SAVE & NEW" style="width:220px; font-weight:bold; float:right; background:#6699FF; font-size:12px; height:30px; color: #000000;" /></td>

</tr>



</table>


<?php /*?><table width="100%" border="0">

<? 

 		$pi_status = find_a_field('pi_master','status','id="'.$_POST['pi_id'].'"');
		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);


if($pi_status!="MANUAL"){




?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong> Master PI Data Entry Completed</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table><?php */?>




<? }?>








<p>&nbsp;</p>

</form>

</div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>