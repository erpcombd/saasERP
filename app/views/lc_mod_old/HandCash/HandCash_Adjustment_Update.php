<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='HandCash Adjustment Entry';


create_combobox('handcash_id');
create_combobox('dr_ledger_id');

do_calander('#invoice_date');

do_calander('#cheque_date');

 $data_found = $_POST['handcash_id'];

if ($data_found==0) {
 create_combobox('handcash_id');
  }








if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$receive_date=$_POST['invoice_date'];
		$group_for=$_POST['group_for'];
		$transaction_type=$_POST['transaction_type'];
		$dr_ledger_id=$_POST['dr_ledger_id'];
		$reference_by=$_POST['reference_by'];	
		$remarks=$_POST['remarks'];
		
	
		

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		$YR = date('Y',strtotime($receive_date));
  		$year = date('y',strtotime($receive_date));
  		$month = date('m',strtotime($receive_date));

  		$rec_cy_id = find_a_field('handcash_adjustment','max(rec_id)','year="'.$YR.'"')+1;
   		$rec_id = sprintf("%06d", $rec_cy_id);

	
			
		$tr_unique=44;

		$receive_no = next_transection_no($tr_unique,$receive_date,'handcash_adjustment','receive_no');

		 
		  if($_POST['handcash_id']!='')
		  $handcash_con=" and b.handcash_id=".$_POST['handcash_id'];
		
		$sql = "SELECT b.*, a.handcash_ledger FROM handcash_ledger a, handcash_payment b WHERE a.id=b.handcash_id  ".$handcash_con." order  by b.payment_date, b.id";

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{
			if($_POST['receive_amt_'.$data->id]>0)

			{

				$handcash_id=$_POST['handcash_id_'.$data->id];
				$ledger_id=$_POST['ledger_id_'.$data->id];
				$receive_amt=$_POST['receive_amt_'.$data->id];
				$note=$_POST['note_'.$data->id];

   $ins_invoice = 'INSERT INTO handcash_adjustment (rec_id, year, receive_no, receive_date, order_no, payment_no, payment_date, group_for, transaction_type, reference_by, remarks, dr_ledger_id, handcash_id, ledger_id, receive_amt, note, entry_by, entry_at)
  
  VALUES("'.$rec_id.'", "'.$YR.'", "'.$receive_no.'", "'.$receive_date.'", "'.$data->id.'", "'.$data->payment_no.'", "'.$data->payment_date.'", "'.$group_for.'", "'.$transaction_type.'", "'.$reference_by.'", "'.$remarks.'", "'.$dr_ledger_id.'", "'.$handcash_id.'", "'.$ledger_id.'", "'.$receive_amt.'", "'.$note.'", "'.$entry_by.'", "'.$entry_at.'")';

db_query($ins_invoice);


}

}


if($receive_no>0)
{
auto_insert_handcash_adjustment_secoundary($receive_no);
}

?>

<script language="javascript">
window.location.href = "HandCash_Adjustment_Update.php";
</script>

<?	

}



if(isset($_REQUEST['confirmit_update']))

{

		$receive_date=$_POST['invoice_date'];
		$group_for=$_POST['group_for'];
		$transaction_type=$_POST['transaction_type'];
		$adjust_from_ledger=$_POST['ledger_id'];
		$dr_ledger_id=$_POST['dr_ledger_id'];
		$reference_by=$_POST['reference_by'];	
		$remarks=$_POST['remarks'];
		
	
		

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		$YR = date('Y',strtotime($receive_date));
  		$year = date('y',strtotime($receive_date));
  		$month = date('m',strtotime($receive_date));

  		$rec_cy_id = find_a_field('handcash_adjustment','max(rec_id)','year="'.$YR.'"')+1;
   		$rec_id = sprintf("%06d", $rec_cy_id);
		
   	

		
		$tr_unique=44;

		$receive_no = next_transection_no($tr_unique,$receive_date,'handcash_adjustment','receive_no');
		
		
		$tr_unique_return=22;
		$return_purchase_no = next_transection_no($tr_unique_return,$receive_date,'foreign_currency_purchase','invoice_no');

		 
		  if($_POST['handcash_id']!='')
		  $handcash_con=" and b.handcash_id=".$_POST['handcash_id'];
		
		$sql = "SELECT b.*, a.handcash_ledger FROM handcash_ledger a, handcash_payment b WHERE a.id=b.handcash_id  ".$handcash_con." order  by b.payment_date, b.id";

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{
			if($_POST['total_amt_usd_'.$data->id]>0)

			{

				$handcash_id=$_POST['handcash_id_'.$data->id];
				$ledger_id=$_POST['ledger_id_'.$data->id];
				$currency_ledger=$_POST['currency_ledger_'.$data->id];
				$exchange_rate=$_POST['exchange_rate_'.$data->id];
				$adjust_amt=$_POST['adjust_amt_'.$data->id];
				$return_amt=$_POST['return_amt_'.$data->id];
				$note=$_POST['note_'.$data->id];
				
				$receive_amt=($adjust_amt+$return_amt)*$exchange_rate;
				
				$adjust_amt_bdt=$adjust_amt*$exchange_rate;
				
				$return_amt_bdt = $exchange_rate*$return_amt;

    $ins_invoice = 'INSERT INTO handcash_adjustment (rec_id, year, receive_no, receive_date, order_no, payment_no, payment_date, group_for, transaction_type, reference_by, remarks, dr_ledger_id, handcash_id, ledger_id, receive_amt, currency_ledger, exchange_rate, currency_adjust_amt, currency_adjust_amt_bdt, currency_return_amt, note, entry_by, entry_at)
  
  VALUES("'.$rec_id.'", "'.$YR.'", "'.$receive_no.'", "'.$receive_date.'", "'.$data->id.'", "'.$data->payment_no.'", "'.$data->payment_date.'", "'.$group_for.'", "'.$transaction_type.'", "'.$reference_by.'", "'.$remarks.'", "'.$dr_ledger_id.'", "'.$handcash_id.'", "'.$ledger_id.'", "'.$receive_amt.'", "'.$currency_ledger.'", "'.$exchange_rate.'", "'.$adjust_amt.'",  "'.$adjust_amt_bdt.'", "'.$return_amt.'", "'.$note.'", "'.$entry_by.'", "'.$entry_at.'")';

db_query($ins_invoice);

$handcash_order_no = db_insert_id() ;


if($_POST['return_amt_'.$data->id]>0){


 $return_sql = 'INSERT INTO foreign_currency_purchase (invoice_no, invoice_date, group_for, transaction_type, cheque_no, cheque_date, reference_by, remarks, cr_ledger_id, ledger_id, purchase_amt, exchange_rate, total_amt_bdt, handcash_adjust_no, handcash_order_no, status, entry_by, entry_at)
  
  VALUES("'.$return_purchase_no.'", "'.$receive_date.'", "'.$group_for.'", "RETURN", "'.$cheque_no.'", "'.$cheque_date.'", "'.$reference_by.'", "'.$remarks.'", "'.$adjust_from_ledger.'", "'.$currency_ledger.'", "'.$return_amt.'", "'.$exchange_rate.'", "'.$return_amt_bdt.'", "'.$receive_no.'", "'.$handcash_order_no.'", "Return",   "'.$entry_by.'", "'.$entry_at.'")';

db_query($return_sql);

}




}

}


if($receive_no>0)
{
auto_insert_handcash_adjustment_foreign_currency_secoundary($receive_no);
}

?>

<script language="javascript">
window.location.href = "HandCash_Adjustment_Update.php";
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


function EXPcalculation(id){
var pending_amt = document.getElementById('pending_amt_'+id).value*1;
var receive_amt = document.getElementById('receive_amt_'+id).value*1;




 if(receive_amt>pending_amt)
  {
alert('Can not entry more than pending amount.');

document.getElementById('receive_amt_'+id).value='';

  } 

}




function USDcalculation(id){
var pending_amt = document.getElementById('pending_amt_'+id).value*1;
var adjust_amt = document.getElementById('adjust_amt_'+id).value*1;
var return_amt = document.getElementById('return_amt_'+id).value*1;

var total_amt_usd = document.getElementById('total_amt_usd_'+id).value= (adjust_amt+return_amt);


 if(total_amt_usd>pending_amt)
  {
alert('Can not entry more than pending amount.');

document.getElementById('adjust_amt_'+id).value='';
document.getElementById('return_amt_'+id).value='';
document.getElementById('total_amt_usd_'+id).value='';
  } 

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



    <td width="20%" align="right" ><strong>HandCash Ledger: </strong></td>



    <td width="17%" >
	<select name="handcash_id" id="handcash_id" style="width:220px;" required>
      <option></option>
      <? foreign_relation('handcash_ledger','id','handcash_ledger',$_POST['handcash_id'],'1'); ?>
    </select></td>



    <td width="17%"  align="right"><strong>Adjustment Type: </strong></td>
    <td width="16%" >
	
	<select name="adjustment_type" id="adjustment_type" required="required" style="width:150px;">								 
	<? foreign_relation('adjustment_type','adjustment_type','adjustment_type',$_POST['adjustment_type'],'1');?>
	</select>
	
	</td>
    <td width="30%" rowspan="4" ><strong>

      <input type="submit" name="submit" id="submit" value="View Data" style="width:180px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>
    </tr>
								</table>

    </div>

<? }?>






<? if($_POST['adjustment_type']=='CASH'){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>

								 <td width="11%">ADJUSTMENT DATE:</td>

									<td width="20%">
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />									</td>
									<td width="14%">COMPANY:</td>
									<td width="21%">
									
									<? $handcash_data = find_all_field('handcash_ledger','','id='.$_POST['handcash_id']); ?>
							
							<input style="width:220px; height:32px;" name="adjustment_type" type="hidden" id="adjustment_type"  value="<?=$_POST['adjustment_type']?>"    />		
									
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
								
							
									<select name="dr_ledger_id" id="dr_ledger_id" required="required" style="width:220px;">
									 
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['dr_ledger_id'],'ledger_id="1011000100010000"');?>
									</select>
																	</td>
								  </tr>
								
								
								<tr>

								 <td>REFERENCE BY:</td>

									<td>

	<input style="width:220px; height:32px;" name="reference_by" type="text" id="reference_by"  value="<?=$_POST['reference_by']?>"    />									</td>
									<td>REMARKS:</td>
									<td>
								<input style="width:220px; height:32px;" name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks']?>"    />		
																	</td>
								  </tr>
								
								</table>

    </div>
	
	




<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">
 <thead>
  <tr>
    <th width="19%">Ledger Name </th>

    <th width="10%">Payment No </th>
    <th width="10%">Payment Date </th>
    <th width="14%">Narration</th>
    <th width="9%">Pay Amt </th>
    <th width="9%">Adjusted </th>
    <th width="7%">Pending</th>
    <th width="7%">Receive Amt </th>
    <th width="15%">Narration</th>
    </tr>
  </thead>

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['handcash_id']!='')
  $handcash_con=" and b.handcash_id=".$_POST['handcash_id'];
  




  

  
  
 $sql = "select order_no, sum(receive_amt) as receive_amt from handcash_adjustment where 1 group by order_no";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$receive_amt[$data->order_no]=$data->receive_amt;
}
 
   
$sql = "SELECT b.*, a.handcash_ledger FROM handcash_ledger a, handcash_payment b WHERE a.id=b.handcash_id and b.transaction_type='CASH'  ".$handcash_con." order  by b.payment_date, b.id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){$i++;

  ?>
<? if ($pending_amt = $data->payment_amt-$receive_amt[$data->id]>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td>
     <?=$data->handcash_ledger;?>    </td>

    <td><?=$data->payment_no;?></td>
    <td><?=date("d-M-Y",strtotime($data->payment_date))?></td>
    <td><?=$data->note;?> </td>
    <td><?=number_format($data->payment_amt,2);?> </td>
    <td><?=number_format($receive_amt[$data->id],2);?> </td>
    <td><?=number_format($pending_amt = $data->payment_amt-$receive_amt[$data->id],2) ?>
	
	<input name="pending_amt_<?=$data->id?>" id="pending_amt_<?=$data->id?>" type="hidden"   value="<?=$pending_amt?>"  onkeyup="EXPcalculation(<?=$data->id?>)" style="width:120px; height:25px;"  />
	 </td>
    <td>
	
	<input name="handcash_id_<?=$data->id?>" id="handcash_id_<?=$data->id?>" type="hidden"   value="<?=$data->handcash_id?>"  onkeyup="EXPcalculation(<?=$data->id?>)" style="width:120px; height:25px;"  />
	
	<input name="ledger_id_<?=$data->id?>" id="ledger_id_<?=$data->id?>" type="hidden"   value="<?=$data->ledger_id?>"  onkeyup="EXPcalculation(<?=$data->id?>)" style="width:120px; height:25px;"  />
	
	
 <input name="receive_amt_<?=$data->id?>" id="receive_amt_<?=$data->id?>" type="text"  value=""  onkeyup="EXPcalculation(<?=$data->id?>)" style="width:100px; height:25px;" />	</td>
    <td><input name="note_<?=$data->id?>" id="note_<?=$data->id?>" type="text"  value=""   style="width:200px; height:25px;"  /></td>
    </tr>

  <? } }?>
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







<? }?>










<? if($_POST['adjustment_type']=='FOREIGN CURRENCY'){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>

								 <td width="11%">ADJUSTMENT DATE:</td>

									<td width="20%">
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />									</td>
									<td width="14%">COMPANY:</td>
									<td width="21%">
									
									<? $handcash_data = find_all_field('handcash_ledger','','id='.$_POST['handcash_id']); ?>
							
							<input style="width:220px; height:32px;" name="adjustment_type" type="hidden" id="adjustment_type"  value="<?=$_POST['adjustment_type']?>"    />
							<input style="width:220px; height:32px;" name="transaction_type" type="hidden" id="transaction_type"  value="<?=$_POST['adjustment_type']?>"    />
							
							
									
									<select name="group_for" id="group_for" required="required" style="width:220px;">
									
									  <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id not in (7,8)');?>
									</select>									</td>
								  </tr>
								  
  
								  <tr>

								 <td>PAYMENT LEDGER (DR):</td>

									<td>

									<select name="dr_ledger_id" id="dr_ledger_id" required="required" style="width:220px;">
	
										<option></option>
									 
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['dr_ledger_id'],'1');?>
									</select>
	
										</td>
									<td>ADJUST FROM (CR):</td>
									<td>
								
							
									<select name="ledger_id" id="ledger_id" required="required" style="width:220px;">
									 
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['ledger_id'],'ledger_id="'.$handcash_data->ledger_id.'"');?>
									</select>
																	</td>
								  </tr>
								
								
								<tr>

								 <td>REFERENCE BY:</td>

									<td>

	<input style="width:220px; height:32px;" name="reference_by" type="text" id="reference_by"  value="<?=$_POST['reference_by']?>"    />									</td>
									<td>REMARKS:</td>
									<td>
								<input style="width:220px; height:32px;" name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks']?>"    />		
																	</td>
								  </tr>
								
								</table>

    </div>
	
	




<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">
 <thead>
  <tr>
    <th width="9%">Payment No </th>
    <th width="9%">Payment Date </th>
    <th width="13%">FOREIGN CURRENCY </th>
    <th width="15%">Narration</th>
    <th width="6%">PAID Amt </th>
    <th width="8%">Adjusted </th>
    <th width="7%">Pending</th>
    <th width="10%">Adjuste Amt </th>
    <th width="9%">Returnn Amt </th>
    <th width="14%">Narration</th>
    </tr>
  </thead>

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['handcash_id']!='')
  $handcash_con=" and b.handcash_id=".$_POST['handcash_id'];
  




  

  
  
  
 $sql = "select order_no, sum(currency_adjust_amt) as currency_adjust_amt, sum(currency_return_amt) as currency_return_amt from handcash_adjustment where 1 group by order_no";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$currency_adjust_amt[$data->order_no]=$data->currency_adjust_amt;
$currency_return_amt[$data->order_no]=$data->currency_return_amt;
}
 
   
 $sql = "SELECT b.*, a.handcash_ledger FROM handcash_ledger a, handcash_payment b WHERE a.id=b.handcash_id and b.transaction_type='FOREIGN CURRENCY'  ".$handcash_con." order  by b.payment_date, b.id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){$i++;

  ?>
<? if ($pending_amt = $data->currency_pay_amt-($currency_adjust_amt[$data->id]+$currency_return_amt[$data->id])>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=$data->payment_no;?></td>
    <td><?=date("d-M-Y",strtotime($data->payment_date))?></td>
    <td><?=find_a_field('accounts_ledger','ledger_name',' ledger_id="'.$data->cr_ledger_id.'" ');?></td>
    <td><?=$data->note;?> </td>
    <td><?=number_format($data->currency_pay_amt,2);?> </td>
    <td><?=number_format($adjusted_amt=($currency_adjust_amt[$data->id]+$currency_return_amt[$data->id]),2);?> </td>
    <td><?=number_format($pending_amt = $data->currency_pay_amt-$adjusted_amt,2) ?>
	
<input name="exchange_rate_<?=$data->id?>" id="exchange_rate_<?=$data->id?>" type="hidden" value="<?=$data->exchange_rate?>"  onkeyup="USDcalculation(<?=$data->id?>)" style="width:120px; height:25px;" />	
	
<input name="pending_amt_<?=$data->id?>" id="pending_amt_<?=$data->id?>" type="hidden"   value="<?=$pending_amt?>"  onkeyup="USDcalculation(<?=$data->id?>)" style="width:120px; height:25px;"  />	 </td>
    <td>
	
	<input name="handcash_id_<?=$data->id?>" id="handcash_id_<?=$data->id?>" type="hidden"   value="<?=$data->handcash_id?>"  onkeyup="USDcalculation(<?=$data->id?>)" style="width:120px; height:25px;"  />
	
	<input name="ledger_id_<?=$data->id?>" id="ledger_id_<?=$data->id?>" type="hidden"   value="<?=$data->ledger_id?>"  onkeyup="USDcalculation(<?=$data->id?>)" style="width:120px; height:25px;"  />
	
<input name="currency_ledger_<?=$data->id?>" id="currency_ledger_<?=$data->id?>" type="hidden"   value="<?=$data->cr_ledger_id?>"  onkeyup="USDcalculation(<?=$data->id?>)" style="width:120px; height:25px;"  />
	

 <input name="adjust_amt_<?=$data->id?>" id="adjust_amt_<?=$data->id?>" type="text"  value=""  onkeyup="USDcalculation(<?=$data->id?>)" style="width:80px; height:25px;" />	</td>
    <td><input name="return_amt_<?=$data->id?>" id="return_amt_<?=$data->id?>" type="text"  value=""  onkeyup="USDcalculation(<?=$data->id?>)" style="width:80px; height:25px;" />
	<input name="total_amt_usd_<?=$data->id?>" id="total_amt_usd_<?=$data->id?>" type="hidden"  value=""  onkeyup="USDcalculation(<?=$data->id?>)" style="width:80px; height:25px;" />
	</td>
    <td><input name="note_<?=$data->id?>" id="note_<?=$data->id?>" type="text"  value=""   style="width:150px; height:25px;"  /></td>
    </tr>

  <? } }?>
</table>



</div>
<br /><br />

<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!
<input name="confirmit_update" type="submit" class="btn1" value="SAVE & NEW" style="width:220px; font-weight:bold; float:right; background:#6699FF; font-size:12px; height:30px; color: #000000;" /></td>

</tr>



</table>




<? }?>











<p>&nbsp;</p>

</form>

</div>



<?



require_once SERVER_CORE."routing/layout.bottom.php";

?>