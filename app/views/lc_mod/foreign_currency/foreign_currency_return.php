<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Foreign Currency Return Entry';


create_combobox('foreign_currency');
create_combobox('return_ledger');

do_calander('#invoice_date');

do_calander('#fdate');
do_calander('#tdate');
//do_calander('#ldbc_no_date');
do_calander('#cheque_date');

 $data_found = $_POST['foreign_currency'];

if ($data_found==0) {
 create_combobox('foreign_currency');
  }



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$invoice_date=$_POST['invoice_date'];
		$group_for=$_POST['group_for'];
	
		$remarks=$_POST['remarks'];
		
		$foreign_currency = $_POST['foreign_currency'];
		$return_ledger = $_POST['return_ledger'];
		
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

		
		$invoice_no = next_transection_no($group_for,$invoice_date,'foreign_currency_return','invoice_no');


 if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and p.invoice_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
	
 if($_POST['return_ledger']!='')
  $return_ledger_con=" and p.dr_ledger_id=".$_POST['return_ledger'];
  
 if($_POST['foreign_currency']!='')
  $foreign_currency_con=" and p.ledger_id=".$_POST['foreign_currency'];
 
	


		$sql = "SELECT p.id, p.invoice_no, p.invoice_date, p.ledger_id as currency_ledger, p.dr_ledger_id as return_ledger, p.pay_amt, p.exchange_rate, p.pay_amt_bdt, a.ledger_name 
		FROM foreign_currency_payment p, accounts_ledger a
	WHERE p.dr_ledger_id=a.ledger_id ".$return_ledger_con.$foreign_currency_con.$date_con." order  by p.invoice_date, p.id ";

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{
			if($_POST['return_amt_bdt_'.$data->id]>0)

			{

				$order_no=$_POST['order_no_'.$data->id];
				$currency_ledger=$_POST['currency_ledger_'.$data->id];
				$return_ledger=$_POST['return_ledger_'.$data->id];
				$return_amt=$_POST['return_amt_'.$data->id];
				$exchange_rate=$_POST['exchange_rate_'.$data->id];
				$return_amt_bdt=$_POST['return_amt_bdt_'.$data->id];

   $ins_invoice = 'INSERT INTO foreign_currency_return (invoice_no, invoice_date, group_for, payment_no, order_no, remarks, currency_ledger, return_ledger, return_amt, exchange_rate, return_amt_bdt, entry_by, entry_at)
  
  VALUES("'.$invoice_no.'", "'.$invoice_date.'", "'.$group_for.'", "'.$data->invoice_no.'", "'.$order_no.'", "'.$remarks.'", "'.$currency_ledger.'", "'.$return_ledger.'", "'.$return_amt.'", "'.$exchange_rate.'", "'.$return_amt_bdt.'", "'.$entry_by.'", "'.$entry_at.'")';

db_query($ins_invoice);


}

}


//$ledger_group = find_a_field('accounts_ledger','ledger_group_id','ledger_id="'.$return_ledger.'"');
//
//
//if($ledger_group==1013) {
//
//
//		$YR = date('Y',strtotime($invoice_date));
//  		$year = date('y',strtotime($invoice_date));
//  		$month = date('m',strtotime($invoice_date));
//
//  		$pay_cy_id = find_a_field('handcash_payment','max(pay_id)','year="'.$YR.'"')+1;
//   		$pay_id = sprintf("%06d", $pay_cy_id);
//		
//   		$payment_no=''.$year.''.$month.''.$pay_id;
//		
//		$handcash_id = find_a_field('handcash_ledger','id','ledger_id="'.$dr_ledger_id.'"');
//		
//		$hand_pay_amt = find_a_field('foreign_currency_payment','sum(pay_amt_bdt)','invoice_no="'.$invoice_no.'"');
//
//
// $ins_hnd = 'INSERT INTO handcash_payment (pay_id, year, payment_no, payment_date, group_for, transaction_type, reference_by, remarks, cr_ledger_id, handcash_id, ledger_id, payment_amt, note, entry_by, entry_at)
//  
//  VALUES("'.$pay_cy_id.'", "'.$YR.'", "'.$payment_no.'", "'.$invoice_date.'", "'.$group_for.'", "CASH", "'.$reference_by.'", "'.$remarks.'", "'.$currency_ledger.'", "'.$handcash_id.'", "'.$dr_ledger_id.'", "'.$hand_pay_amt.'", "'.$remarks.'", "'.$entry_by.'", "'.$entry_at.'")';
//
//db_query($ins_hnd);
//
//}



//if($invoice_no>0)
//{
//auto_insert_foreign_currency_payment_secoundary($invoice_no);
//}

?>

<script language="javascript">
window.location.href = "foreign_currency_return.php";
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


function EXPcalculation(id){
var balance_amt = document.getElementById('balance_amt_'+id).value*1;
var return_amt = document.getElementById('return_amt_'+id).value*1;
var exchange_rate = document.getElementById('exchange_rate_'+id).value*1;
var return_amt_bdt = document.getElementById('return_amt_bdt_'+id).value= (return_amt*exchange_rate);



 if(return_amt>balance_amt)
  {
alert('Can not entry more than balance amount.');

document.getElementById('return_amt_'+id).value='';
document.getElementById('return_amt_bdt_'+id).value='';

  } 

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
								    <td align="right" ><strong>Date Between:</strong></td>
								    <td ><input type="text" name="fdate" id="fdate" style="width:200px; height:32px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" /></td>
								    <td  align="center"><strong>To</strong></td>
								    <td ><input type="text" name="tdate" id="tdate" style="width:200px; height:32px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" /></td>
								    <td width="29%" rowspan="6" ><strong>
								      
							        <input type="submit" name="submit" id="submit" value="View Data" style="width:180px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
								      
							        </strong></td>
							      </tr>
								  <tr>



    <td width="16%" align="right" ><strong>Foreign Currency: </strong></td>



    <td ><select name="foreign_currency" id="foreign_currency" style="width:220px;" required>
      <option></option>
      <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['foreign_currency'],'ledger_group_id=1010 order  by ledger_id'); ?>
    </select></td>



    <td  align="right"><strong>Return From: </strong></td>
    <td >
	<select name="return_ledger" id="return_ledger"  style="width:220px;" required>
	
										<option></option>
									 
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['return_ledger'],'1');?>
			</select>	</td>
    </tr>
								  <tr>
								    <td align="right" >&nbsp;</td>
								    <td width="18%" >&nbsp;</td>
							        <td width="15%" align="center" >&nbsp;</td>
							        <td width="22%" >&nbsp;</td>
								  </tr>
								</table>

    </div>

<? }?>


<? if(isset($_POST['submit'])){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>

								 <td width="11%">RETURN  DATE:</td>

									<td width="20%">
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />									</td>
									<td width="14%">COMPANY  :</td>
									<td width="21%">
									
									
									
									<input style="width:220px; height:32px;" name="fdate" type="hidden" id="fdate"  value="<?=$_POST['fdate']?>"    />
									<input style="width:220px; height:32px;" name="tdate" type="hidden" id="tdate"  value="<?=$_POST['tdate']?>"    />
									
						
									<select name="group_for" id="group_for" required="required" style="width:220px;">
									
									  <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id not in (7,8)');?>
									</select>									</td>
								  </tr>
								  
								
  
								  <tr>

								 <td>FOREIGN CURRENCY:</td>

									<td>

									<select name="ledger_id" id="ledger_id" required="required" style="width:220px;">
	
									 
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['ledger_id'],'ledger_id="'.$_POST['foreign_currency'].'"');?>
									</select>									</td>
									<td>REMARKS:</td>
									<td>
								
							
									<input style="width:220px; height:32px;" name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks']?>"    />									</td>
								  </tr>
								</table>

    </div>
	
	<? }?>



<? if(isset($_POST['submit'])){ ?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">
 <thead>
  <tr>
    <th width="8%">Payment no </th>

    <th width="10%">Payment date </th>
    <th width="21%">Return From Ledger </th>

    <th width="10%">Paid Amt </th>
    <th width="10%">Return Amt </th>
    <th width="11%">Balance Amt </th>
    <th width="9%">Return Amt </th>
    <th width="11%">Exchange Rate</th>
    <th width="10%"> Return Amt BDT</th>
  </tr>
  </thead>

  <?
  
 if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and p.invoice_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
	
 if($_POST['return_ledger']!='')
  $return_ledger_con=" and p.dr_ledger_id=".$_POST['return_ledger'];
  
 if($_POST['foreign_currency']!='')
  $foreign_currency_con=" and p.ledger_id=".$_POST['foreign_currency'];
  

  
//$sql = "select sum(dr_amt) as payment_amt, ledger_id, tr_id  from journal where tr_from='Payment' group by tr_id ";
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query)){
//$payment_amt[$data->ledger_id][$data->tr_id]=$data->payment_amt;
//}
  
  
  
$sql = "select order_no, sum(return_amt) as return_amt  from foreign_currency_return where 1 group by order_no";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$return_amt[$data->order_no]=$data->return_amt;
}
 
   
    $sql = "SELECT p.id, p.invoice_no, p.invoice_date, p.ledger_id as currency_ledger, p.dr_ledger_id as return_ledger, p.pay_amt, p.exchange_rate, p.pay_amt_bdt, a.ledger_name FROM foreign_currency_payment p, accounts_ledger a
	WHERE p.dr_ledger_id=a.ledger_id ".$return_ledger_con.$foreign_currency_con.$date_con." order  by p.invoice_date, p.id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  ?>
<? //if ($due_amt=$data->purchase_amt-$pay_amt[$data->id]>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><span class="style13" style="color:#000000; font-weight:700;">
      <?=$data->invoice_no;?>
    </span></td>

    <td><span class="style13" style="color:#000000; font-weight:700;">
     <?php echo date('d-m-Y',strtotime($data->invoice_date));?>
    </span></td>
    <td>
     <?=$data->ledger_name;?>    </td>

    <td><?=number_format($data->pay_amt,2);?></td>
    <td><?=number_format($return_amt[$data->id],2);?></td>
    <td><?=number_format($balance_amt =$data->pay_amt-$return_amt[$data->id],2); ?>
	<input name="balance_amt_<?=$data->id?>" id="balance_amt_<?=$data->id?>" type="hidden"   value="<?=$balance_amt;?>"  onkeyup="EXPcalculation(<?=$data->id?>)" style="width:120px; height:25px;"  />	</td>
    <td>
	
<input name="order_no_<?=$data->id?>" id="order_no_<?=$data->id?>" type="hidden"   value="<?=$data->id?>" style="width:120px; height:25px;"  />
	
<input name="currency_ledger_<?=$data->id?>" id="currency_ledger_<?=$data->id?>" type="hidden"   value="<?=$data->currency_ledger?>"  onkeyup="EXPcalculation(<?=$data->id?>)" style="width:80px;"  />

<input name="return_ledger_<?=$data->id?>" id="return_ledger_<?=$data->id?>" type="hidden"   value="<?=$data->return_ledger?>"  onkeyup="EXPcalculation(<?=$data->id?>)" style="width:80px; "  />
	
 <input name="return_amt_<?=$data->id?>" id="return_amt_<?=$data->id?>" type="text"  value=""  onkeyup="EXPcalculation(<?=$data->id?>)" style="width:80px; height:25px;"   />	</td>
    <td><input name="exchange_rate_<?=$data->id?>" id="exchange_rate_<?=$data->id?>" type="text"  value="<?=$data->exchange_rate?>" readonly="" onkeyup="EXPcalculation(<?=$data->id?>)"  style="width:80px; height:25px;"  /></td>
    <td align="center"><input name="return_amt_bdt_<?=$data->id?>" id="return_amt_bdt_<?=$data->id?>" type="text"  readonly=""  value="" style="width:100px; height:25px;"  />	</td>
  </tr>

  <? }// }?>
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