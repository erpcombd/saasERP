<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='L/C Shipment Entry';


  create_combobox('do_no');
  
   $pay_id 		= $_REQUEST['pay_id'];

do_calander('#payment_date');
//do_calander('#bank_lc_date');
//do_calander('#cheque_date');

 $data_found = $pay_id;

if ($data_found==0) {
 create_combobox('pay_id');
  }



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$group_for=$_POST['group_for'];
		$ledger_id=$_POST['ledger_id'];
		$po_no=$_POST['po_no'];
		$lc_no=$_POST['lc_no'];
		$lc_number=$_POST['lc_number'];

		$payment_date=$_POST['payment_date'];
		$bank_ledger_id=$_POST['bank_ledger_id'];
		$bank_pay_amt=$_POST['bank_pay_amt'];
	
		$lc_ltr_ledger=$_POST['lc_ltr_ledger'];
		$loan_amt=$_POST['loan_amt'];
		$remarks=$_POST['remarks'];
		
		$tr_unique=66;
		
		$payment_no = next_transection_no($tr_unique,$payment_date,'lc_bank_payment','payment_no');
		
		$payment_id = find_a_field('lc_bank_payment','max(payment_id)','lc_no="'.$lc_no.'"')+1;	
		
		$lc_bank_data = find_all_field('lc_bank_entry','','id="'.$pay_id.'"');
		
	
		
if ($payment_id==1) {
  $lc_part='A';
} elseif ($payment_id==2) {
  $lc_part='B';
} elseif ($payment_id==3) {
  $lc_part='C';
} elseif ($payment_id==4) {
  $lc_part='D';
} elseif ($payment_id==5) {
  $lc_part='E';
} elseif ($payment_id==6) {
  $lc_part='F';
} elseif ($payment_id==7) {
  $lc_part='G';
} elseif ($payment_id==8) {
  $lc_part='H';
} elseif ($payment_id==9) {
  $lc_part='I';
} elseif ($payment_id==10) {
  $lc_part='J';
} else {
  $lc_part='0';
}


$lc_no_part = $lc_number.' - ('.$lc_part.')';


		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		
//  		$YR = date('Y',strtotime($ch_date));
//  		$yer = date('y',strtotime($ch_date));
//  		$month = date('m',strtotime($ch_date));
//
//  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
//   		$cy_id = sprintf("%07d", $ch_cy_id);
//   		$chalan_no=''.$yer.''.$month.''.$cy_id;




  $ins_invoice = 'INSERT INTO lc_bank_payment (payment_no, payment_date, payment_id, order_no, lc_part, lc_no_part, tr_no, po_no, lc_no, lc_number, ledger_id, group_for, lc_bank_ledger, bank_pay_amt, lc_ltr_ledger, loan_amt, lc_margin_adjustment, remarks, status, entry_at, entry_by)
  
  VALUES("'.$payment_no.'", "'.$payment_date.'", "'.$payment_id.'", "'.$pay_id.'", "'.$lc_part.'", "'.$lc_no_part.'", "'.$lc_bank_data->tr_no.'", "'.$po_no.'", "'.$lc_no.'", "'.$lc_number.'", "'.$ledger_id.'", "'.$group_for.'", "'.$bank_ledger_id.'", "'.$bank_pay_amt.'", "'.$lc_ltr_ledger.'", "'.$loan_amt.'", "'.$lc_margin_adjustment.'", "'.$remarks.'", "CHECKED", "'.$entry_at.'", "'.$entry_by.'")';

db_query($ins_invoice);

//$xid = db_insert_id();



$up_ltr_sql = "update lc_ltr_loan set ltr_complete='Yes' where ledger_id='".$lc_ltr_ledger."'";
db_query($up_ltr_sql);


		


//if($payment_no>0)
//{
//auto_insert_lc_bank_payment_secoundary($payment_no);
//}

?>

<script language="javascript">
window.location.href = "pending_lc_for_payment.php";
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


<script>

function calculation_ud(id){

var pay_amt_usd=((document.getElementById('pay_amt_usd_'+id).value)*1);
var exchange_rate=((document.getElementById('exchange_rate_'+id).value)*1);

var pay_amt_bdt= document.getElementById('pay_amt_bdt_'+id).value= (pay_amt_usd*exchange_rate);





// if(total_issue_qty>rm_stock)
//  {
//alert('Can not issue more than stock.');
//document.getElementById('rm_issue_qty_'+item_id).value='';
//document.getElementById('westage_qty_'+item_id).value='';
//document.getElementById('total_issue_qty_'+item_id).value='';
//document.getElementById('net_total_qty_'+item_id).value='';
//  } 



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


table thead  {
  / Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}


</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">


<? if($pay_id>0){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>

								 <td width="12%">L/C   NO:</td>

									<td width="19%">
									
					<? $pay_data = find_all_field('lc_bank_entry','','id='.$pay_id); ?>
									
					<input name="group_for" type="hidden" id="group_for"  readonly="" style="width:220px; height:32px;" value="<?=$pay_data->group_for;?>"  required tabindex="105" />
					
					<input name="po_no" type="hidden" id="po_no"  readonly="" style="width:220px; height:32px;" value="<?=$pay_data->po_no;?>"  required tabindex="105" />
						
					<input name="lc_no" type="hidden" id="lc_no"  readonly="" style="width:220px; height:32px;" value="<?=$pay_data->lc_no;?>"  required tabindex="105" />
									
					<input name="ledger_id" type="hidden" id="ledger_id"  readonly="" style="width:220px; height:32px;" 
					value="<?=find_a_field('lc_number_setup','ledger_id','id='.$pay_data->lc_no);?>"  required tabindex="105" />
									
					<input name="lc_number" type="text" id="lc_number"  readonly="" style="width:220px; height:32px;" value="<?=$pay_data->lc_number;?>"  required tabindex="105" />										</td>
									<td width="14%">L/C TYPE:</td>
									<td width="21%">
									
									<select name="lc_type" id="lc_type" required="required" style="width:220px;">
									  
									  <? foreign_relation('lc_type','id','lc_type',$_POST['lc_type'],'id="'.$pay_data->lc_type.'"');?>
									</select>								</td>
									<td width="14%">COMPANY:</td>
									<td width="20%">
									
									<table>
		  	<tr>
				<td><input name="company" type="text" id="company"  readonly="" style="width:220px; height:32px;" value="<?=find_a_field('user_group','group_name','id='.$pay_data->group_for); ?>"   tabindex="105" />	</td>
			</tr>
		  </table>									</td>
								  </tr>
								  
								
								  
								  
								  
								  
								  
								  <tr>

								 <td>PI  NO:</td>

									<td>

									<input name="bank_lc_no" type="text" id="bank_lc_no"  readonly=""  style="width:220px; height:32px;" value="<?=$pay_data->pi_no?>"  required tabindex="105" />									</td>
									<td>BANK L/C NO:</td>
									<td>
							
									<input name="bank_lc_no" type="text" id="bank_lc_no"  readonly=""  style="width:220px; height:32px;" value="<?=$pay_data->bank_lc_no?>"  required tabindex="105" />									</td>
									<td>L/C VALUE (USD$):</td>
									<td>
									
				<input name="lc_value" type="text" id="lc_value"  style="width:220px; height:32px;" readonly=""  value="<?=$pay_data->lc_value?>"  required tabindex="105" />									</td>
								  </tr>
								  
								  
								  <?php /*?><tr>

								 <td>L/C Margin (BDT):</td>

									<td><input name="lc_margin" type="text" id="lc_margin"  style="width:220px; height:32px;" value="<?=find_a_field('lc_bill_payment','sum(pay_amt_in)','lc_no="'.$pay_data->lc_no.'" and bill_category=7'); ?>"  required tabindex="105" /></td>
									<td>Margin Adjustment: </td>
									<td>
							
									<input name="lc_margin_adjustment" type="text" id="lc_margin_adjustment"  style="width:220px; height:32px;" value="<?=find_a_field('lc_bill_payment','sum(pay_amt_out)','lc_no="'.$pay_data->lc_no.'" and bill_category=7'); ?>"  required tabindex="105" />									</td>
									<td>L/C Margin Due:</td>
									<td>
									
				<input name="lc_margin_due" type="text" id="lc_margin_due"  style="width:220px; height:32px;" value="<?=find_a_field('lc_bill_payment','sum(pay_amt_in-pay_amt_out)','lc_no="'.$pay_data->lc_no.'" and bill_category=7'); ?>"  required tabindex="105" />									</td>
								  </tr><?php */?>
								</table>

    </div>
	
	<? }?>
	
	
	<? if($pay_id>0){ ?>
	
	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:12px;">

<tr>

    <td colspan="5" valign="top">


	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:12px">

      <tr>
        <td width="22%" align="right" bgcolor="#9999FF"><strong>Entry Date: </strong></td>
        <td width="23%" align="right" bgcolor="#9999FF">
		<input style="width:80%; height:30px; "  name="payment_date" type="text" id="payment_date" value="<?= $_POST['payment_date']=date('Y-m-d')?>" required="required" readonly=""/>	</td>
		
        <td width="21%" bgcolor="#9999FF" align="right"><strong>Remarks:</strong></td>
        <td width="34%" bgcolor="#9999FF">
		<input style="width:80%; height:30px;"  name="remarks" type="text" id="remarks" value="<?=$remarks;?>"  /></td>
      </tr>
      
    </table></td>

    </tr>

    <?php /*?><tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>

            <th width="5%" rowspan="2">SL</th>

            <th width="24%" rowspan="2">L/C No </th>

            <th rowspan="2" bgcolor="#FF99FF">L/C Value($) </th>

            <th rowspan="2" bgcolor="#009900"><strong>Payment($) </strong></th>

            <th rowspan="2" bgcolor="#FFFF00">Pending($) </th>

            <th colspan="3" bgcolor="#0099CC"><strong>Payment</strong> Amt</th>
          </tr>
          <tr>
            <th bgcolor="#0099CC">Amt(USD$)</th>
            <th bgcolor="#0099CC">Exch. Rate </th>
            <th bgcolor="#0099CC">Amt(BDT)</th>
          </tr>

          

          <? 
		
		 $sql='select a.* from lc_bank_entry a where  a.id='.$pay_id;
		 $res=db_query($sql);
		  
		  while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>" style="height:25px; font-size:12px;">

            <td><?=++$ss;?></td>

            <td><?=$row->lc_number;?>

              <input type="hidden" name="order_no_<?=$row->id?>" id="order_no_<?=$row->id?>" value="<?=$row->id;?>" /></td>

              <td width="11%" align="center"><?=$row->lc_value;?></td>

              <td width="11%" align="center"><? echo $pay_amt = (find_a_field('lc_bank_payment','sum(pay_amt_usd)','order_no="'.$pay_id.'"')*(1));?></td>

              <td width="15%" align="center"><? echo $pending_amt =($row->lc_value-$pay_amt);?>

                <input type="hidden" name="pending_amt_<?=$row->id?>" id="pending_amt_<?=$row->id?>" value="<?=$pending_amt;?>" /></td>

              <td width="11%" align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($pending_amt>0){$cow++;?>
			  <input name="pay_amt_usd_<?=$row->id?>" type="text" id="pay_amt_usd_<?=$row->id?>" style="width:80px; height:30px; float:none" value=""  onKeyUp="calculation_ud(<?=$row->id;?>)" />
			  <? } else echo 'Done';?></td>
              <td width="12%" align="center" bgcolor="#6699FF" style="text-align:center">
			  
			  <? if($pending_amt>0){$cow++;?>
			  <input name="exchange_rate_<?=$row->id?>" type="text" id="exchange_rate_<?=$row->id?>" style="width:80px;  height:30px; float:none" value="" onKeyUp="calculation_ud(<?=$row->id;?>)" />
			  <? } else echo 'Done';?>
			  </td>
              <td width="11%" align="center" bgcolor="#6699FF" style="text-align:center">
			  
			  <? if($pending_amt>0){$cow++;?>
<input name="pay_amt_bdt_<?=$row->id?>" type="text" id="pay_amt_bdt_<?=$row->id?>" readonly="" style="width:100px;  height:30px; float:none" value="" onKeyUp="calculation_ud(<?=$row->id;?>)" />
			  <? } else echo 'Done';?>
			  </td>
          </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr><?php */?>

  </table>

<? }?>


<? if($pay_id>0){ ?>


<br /> <br />

<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirmit" type="submit" class="btn1" value="SAVE & NEW" style="width:220px; font-weight:bold; float:right; background:#6699FF; font-size:12px; height:30px; color: #000000;" /></td>

</tr>



</table>




<? }?>








<p>&nbsp;</p>

</form>

</div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>