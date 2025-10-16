<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='HandCash Adjustment Entry';


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
		
   		$receive_no=''.$year.''.$month.''.$rec_id;

		


		 
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
window.location.href = "HandCash_Adjustment.php";
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

								 <td width="11%">ADJUSTMENT DATE:</td>

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
	
	<? }?>



<? if(isset($_POST['submit'])){ ?>

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
 
   
$sql = "SELECT b.*, a.handcash_ledger FROM handcash_ledger a, handcash_payment b WHERE a.id=b.handcash_id  ".$handcash_con." order  by b.payment_date, b.id ";
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








<p>&nbsp;</p>

</form>

</div>



<?



require_once SERVER_CORE."routing/layout.bottom.php";

?>