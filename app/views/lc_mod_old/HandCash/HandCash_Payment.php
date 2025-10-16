<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='HandCash Payment Entry';


create_combobox('handcash_id');

do_calander('#invoice_date');

do_calander('#cheque_date');

 $data_found = $_POST['handcash_id'];

if ($data_found==0) {
 create_combobox('handcash_id');
  }



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$payment_date=$_POST['invoice_date'];
		$group_for=$_POST['group_for'];
		$transaction_type=$_POST['transaction_type'];
		$cr_ledger_id=$_POST['cr_ledger_id'];
		$reference_by=$_POST['reference_by'];	
		$remarks=$_POST['remarks'];
		
	
		

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		$YR = date('Y',strtotime($payment_date));
  		$year = date('y',strtotime($payment_date));
  		$month = date('m',strtotime($payment_date));

  		$pay_cy_id = find_a_field('handcash_payment','max(pay_id)','year="'.$YR.'"')+1;
   		$pay_id = sprintf("%06d", $pay_cy_id);
		
   		$payment_no=''.$year.''.$month.''.$pay_id;

		
		

		  if($_POST['handcash_id']!='')
		  $handcash_con=" and id=".$_POST['handcash_id'];
		
		$sql = "SELECT id, ledger_id, handcash_ledger FROM handcash_ledger WHERE 1 ".$handcash_con." order  by id";

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{
			if($_POST['payment_amt_'.$data->ledger_id]>0)

			{

				$handcash_id=$_POST['handcash_id_'.$data->ledger_id];
				$ledger_id=$_POST['ledger_id_'.$data->ledger_id];
				$payment_amt=$_POST['payment_amt_'.$data->ledger_id];
				$note=$_POST['note_'.$data->ledger_id];

   $ins_invoice = 'INSERT INTO handcash_payment (pay_id, year, payment_no, payment_date, group_for, transaction_type, reference_by, remarks, cr_ledger_id, handcash_id, ledger_id, payment_amt, note, entry_by, entry_at)
  
  VALUES("'.$pay_cy_id.'", "'.$YR.'", "'.$payment_no.'", "'.$payment_date.'", "'.$group_for.'", "'.$transaction_type.'", "'.$reference_by.'", "'.$remarks.'", "'.$cr_ledger_id.'", "'.$handcash_id.'", "'.$ledger_id.'", "'.$payment_amt.'", "'.$note.'", "'.$entry_by.'", "'.$entry_at.'")';

db_query($ins_invoice);


}

}


if($payment_no>0)
{
auto_insert_handcash_payment_secoundary($payment_no);
}

?>

<script language="javascript">
window.location.href = "HandCash_Payment.php";
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



function getXMLHTTP() { 



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



var pi_id=pi_id; 


var lc_no=(document.getElementById('lc_no').value);


var flag=(document.getElementById('flag_'+pi_id).value); 

var strURL="lc_update_ajax.php?pi_id="+pi_id+"&lc_no="+lc_no+"&flag="+flag;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

			

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



div.form-container_large input {
    width: 200px;
    height: 38px;
    border-radius: 0px !important;
}





</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<? if ($data_found=="") { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td align="right" ><strong>HandCash Ledger: </strong></td>



    <td >
	<select name="handcash_id" id="handcash_id" style="width:220px;" required>
      <option></option>
      <? foreign_relation('handcash_ledger','id','handcash_ledger',$_POST['handcash_id'],'1'); ?>
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

								 <td width="11%">PAYMENT  DATE:</td>

									<td width="20%">
									
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />									</td>
									<td width="14%">COMPANY:</td>
									<td width="21%">
									
									<? $handcash_data = find_all_field('handcash_ledger','','id='.$_POST['handcash_id']); ?>
									
									<select name="group_for" id="group_for" required="required" style="width:220px;">
									
									  <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id not in (7,8)');?>
									</select>									</td>
								  </tr>
								  
  
								  <tr>

								 <td>PMT. METHOD:</td>

									<td>

									<select name="transaction_type" id="transaction_type" required="required" style="width:220px;">
									 
									  <? foreign_relation('transaction_type','transaction_type','transaction_type',$_POST['transaction_type'],'id="1"');?>
									</select>
	
										</td>
									<td>CASH/BANK:</td>
									<td>
								
							
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									 
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_id="1011000100010000"');?>
									</select>
																	</td>
								  </tr>
								
								
								<tr>

								 <td>REFERENCE BY:</td>

									<td>

	<input style="width:220px; height:32px;" name="reference_by" type="text" id="reference_by"  value="<?=$_POST['reference_by']?>"   required  />									</td>
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
    <th width="17%">Ledger Code</th>

    <th width="43%">Ledger Name </th>

    <th width="13%">Current Balance </th>
    <th width="13%">Payment Amt </th>
    <th width="11%">Narration</th>
    </tr>
  </thead>

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['handcash_id']!='')
  $handcash_con=" and id=".$_POST['handcash_id'];
  




  

  
  
  
 $sql = "select ledger_id, sum(dr_amt-cr_amt) as balance_amt from journal where 1 group by ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$balance_amt[$data->ledger_id]=$data->balance_amt;
}
 
   
    $sql = "SELECT id, ledger_id, handcash_ledger FROM handcash_ledger WHERE 1 ".$handcash_con." order  by id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  ?>


  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><span class="style13" style="color:#000000; font-weight:700;">
      <?=$data->ledger_id;?>
    </span></td>

    <td>
     <?=$data->handcash_ledger;?>    </td>

    <td><?=number_format($balance_amt[$data->ledger_id],2);?></td>
    <td>
	
	<input name="handcash_id_<?=$data->ledger_id?>" id="handcash_id_<?=$data->ledger_id?>" type="hidden"   value="<?=$data->id?>"  onkeyup="EXPcalculation(<?=$data->ledger_id?>)" style="width:120px; height:25px;"  />
	
	<input name="ledger_id_<?=$data->ledger_id?>" id="ledger_id_<?=$data->ledger_id?>" type="hidden"   value="<?=$data->ledger_id?>"  onkeyup="EXPcalculation(<?=$data->ledger_id?>)" style="width:120px; height:25px;"  />
	
	
 <input name="payment_amt_<?=$data->ledger_id?>" id="payment_amt_<?=$data->ledger_id?>" type="text"  value=""  onkeyup="EXPcalculation(<?=$data->ledger_id?>)" style="width:120px; height:25px;" required  />	</td>
    <td><input name="note_<?=$data->ledger_id?>" id="note_<?=$data->ledger_id?>" type="text"  value="" onkeyup="EXPcalculation(<?=$data->ledger_id?>)"  style="width:200px; height:25px;"  required /></td>
    </tr>


</table>



</div>
<br /><br />

<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>

<td align="center">

<input name="confirmit" type="submit" class="btn1" value="SAVE & NEW" style="width:220px; font-weight:bold; float:right; background:#6699FF; font-size:12px; height:30px; color: #000000;" /></td>

</tr>



</table>










<p>&nbsp;</p>

</form>

</div>



<?


require_once SERVER_CORE."routing/layout.bottom.php";

?>