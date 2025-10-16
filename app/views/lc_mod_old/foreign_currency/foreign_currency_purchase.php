<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Foreign Currency Purchase Entry';


create_combobox('cr_ledger_id');

do_calander('#invoice_date');
//do_calander('#ldbc_no_date');
do_calander('#cheque_date');

 $data_found = $_POST['tr_type'];

if ($data_found==0) {
 create_combobox('tr_type');
  }



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$invoice_date=$_POST['invoice_date'];
		$group_for=$_POST['group_for'];
		$transaction_type=$_POST['transaction_type'];
		$cr_ledger_id=$_POST['cr_ledger_id'];
		$cheque_no=$_POST['cheque_no'];
		$cheque_date=$_POST['cheque_date'];
		$reference_by=$_POST['reference_by'];	
		$remarks=$_POST['remarks'];
		
		//$lc_part_no = find_a_field('lc_bank_payment','lc_no_part','id="'.$bank_pay_id.'"');
		
	
  if($_POST['bill_type']!='')
  $bill_type_con=" and bill_type=".$_POST['bill_type'];
  


		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		
		//$YR = date('Y',strtotime($ch_date));
//  		$yer = date('y',strtotime($ch_date));
//  		$month = date('m',strtotime($ch_date));
//
//  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
//   		$cy_id = sprintf("%07d", $ch_cy_id);
//   		$chalan_no=''.$yer.''.$month.''.$cy_id;


			$tr_unique=22;

		
			$invoice_no = next_transection_no($tr_unique,$invoice_date,'foreign_currency_purchase','invoice_no');


		$sql = "SELECT ledger_id, ledger_name FROM accounts_ledger WHERE ledger_group_id=1010 order  by ledger_id";

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{
			if($_POST['total_amt_bdt_'.$data->ledger_id]>0)

			{

				$ledger_id=$_POST['ledger_id_'.$data->ledger_id];
				$purchase_amt=$_POST['purchase_amt_'.$data->ledger_id];
				$exchange_rate=$_POST['exchange_rate_'.$data->ledger_id];
				$total_amt_bdt=$_POST['total_amt_bdt_'.$data->ledger_id];

   $ins_invoice = 'INSERT INTO foreign_currency_purchase (invoice_no, invoice_date, group_for, transaction_type, cheque_no, cheque_date, reference_by, remarks, cr_ledger_id, ledger_id, purchase_amt, exchange_rate, total_amt_bdt, status, entry_by, entry_at)
  
  VALUES("'.$invoice_no.'", "'.$invoice_date.'", "'.$group_for.'", "'.$transaction_type.'", "'.$cheque_no.'", "'.$cheque_date.'", "'.$reference_by.'", "'.$remarks.'", "'.$cr_ledger_id.'", "'.$ledger_id.'", "'.$purchase_amt.'", "'.$exchange_rate.'", "'.$total_amt_bdt.'", "Purchase", "'.$entry_by.'", "'.$entry_at.'")';

db_query($ins_invoice);


}

}


if($invoice_no>0)
{
auto_insert_foreign_currency_purchase_secoundary($invoice_no);
}

?>

<script language="javascript">
window.location.href = "foreign_currency_purchase.php";
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


function EXPcalculation(ledger_id){
var purchase_amt = document.getElementById('purchase_amt_'+ledger_id).value*1;
var exchange_rate = document.getElementById('exchange_rate_'+ledger_id).value*1;
var total_amt_bdt = document.getElementById('total_amt_bdt_'+ledger_id).value= (purchase_amt*exchange_rate);

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


/*table thead  {
  / Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}*/


</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<? if ($data_found=="") { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td align="right" ><strong>Payment Type: </strong></td>



    <td ><select name="tr_type" id="tr_type" style="width:220px;" required>
      <option></option>
      <? foreign_relation('transaction_type','transaction_type','transaction_type',$_POST['tr_type'],'1'); ?>
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

								 <td width="11%">INVOICE DATE:</td>

									<td width="20%">
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />									</td>
									<td width="14%">COMPANY  :</td>
									<td width="21%">
									
									<select name="group_for" id="group_for" required="required" style="width:220px;">
									
									  <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id not in (7,8)');?>
									</select>									</td>
								  </tr>
								  
								  <? if($_POST['tr_type']=='CASH') {?>
  
								  <tr>

								 <td>PMT. METHOD:</td>

									<td>

	<input style="width:220px; height:32px;" name="transaction_type" type="text" id="transaction_type"  value="<?=$_POST['tr_type']?>" readonly=""   required />									</td>
									<td>CASH/BANK:</td>
									<td>
								
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									 
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_id="1011000100010000"');?>
									</select>
																	</td>
								  </tr>
								<? } elseif ($_POST['tr_type']=='BANK' ) {?>
								
								<tr>

								 <td>PMT. METHOD:</td>

									<td>

	<input style="width:220px; height:32px;" name="transaction_type" type="text" id="transaction_type"  value="<?=$_POST['tr_type']?>" readonly=""   required />									</td>
									<td>CASH/BANK:</td>
									<td>
								
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
				 <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id in (1011) and ledger_layer=2 and ledger_name not like "%Cash%"');?>
									</select>
																	</td>
								  </tr>
								  
								  
								  <tr>

								 <td>CHEQUE NO:</td>

									<td>

	<input style="width:220px; height:32px;" name="cheque_no" type="text" id="cheque_no"  value="<?=$_POST['cheque_no']?>"    />									</td>
									<td>CHEQUE DATE:</td>
									<td>
								<input style="width:220px; height:32px;" name="cheque_date" type="text" id="cheque_date"  value="<?=$_POST['cheque_date']?>"    />		
																	</td>
								  </tr>
								
								<? } ?>
								
								<tr>

								 <td>REFERENCE BY:</td>

									<td>

	<input style="width:220px; height:32px;" name="reference_by" type="text" id="reference_by"  value="<?=$_POST['reference_by']?>"  required   />									</td>
									<td>REMARKS:</td>
									<td>
								<input style="width:220px; height:32px;" name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks']?>"    />		
																	</td>
								  </tr>
								
								</table>

    </div>
	
	<? }?>



<? if(isset($_POST['submit'])){ ?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">
 <thead>
  <tr>
    <th width="17%">Code</th>

    <th width="43%">Ledger Name </th>

    <th width="13%">Purchase Amt </th>
    <th width="11%">Exchange Rate</th>
    <th width="16%">Total Amt BDT</th>
  </tr>
  </thead>

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['bill_type']!='')
  $bill_type_con=" and bill_type=".$_POST['bill_type'];
  




  
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
 
   
    $sql = "SELECT ledger_id, ledger_name FROM accounts_ledger WHERE ledger_group_id=1010 order  by ledger_id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  ?>
<? //if ($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no]>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><span class="style13" style="color:#000000; font-weight:700;">
      <?=$data->ledger_id;?>
    </span></td>

    <td>
     <?=$data->ledger_name;?>    </td>

    <td>
	
	<input name="ledger_id_<?=$data->ledger_id?>" id="ledger_id_<?=$data->ledger_id?>" type="hidden"   value="<?=$data->ledger_id?>"  onkeyup="EXPcalculation(<?=$data->ledger_id?>)" style="width:120px; height:25px;"  />
	
	
<input name="purchase_amt_<?=$data->ledger_id?>" id="purchase_amt_<?=$data->ledger_id?>" type="text"  value="" onkeyup="EXPcalculation(<?=$data->ledger_id?>)" style="width:120px;height:25px;"   />	</td>
    <td><input name="exchange_rate_<?=$data->ledger_id?>" id="exchange_rate_<?=$data->ledger_id?>" type="text"  value="" onkeyup="EXPcalculation(<?=$data->ledger_id?>)"  
	style="width:100px; height:25px;"  /></td>
    <td align="center"><input name="total_amt_bdt_<?=$data->ledger_id?>" id="total_amt_bdt_<?=$data->ledger_id?>" type="text"  readonly=""  value="" style="width:120px; height:25px;"   />	</td>
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