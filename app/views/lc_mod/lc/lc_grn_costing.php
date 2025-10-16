<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='L/C Closing Entry';


  create_combobox('do_no');

do_calander('#invoice_date');
//do_calander('#ldbc_no_date');
do_calander('#cheque_date');

 //$data_found = $_POST['lc_no'];
//
//if ($data_found==0) {
// create_combobox('lc_no');
//  }


$lc_no = $_REQUEST['payment_id'];

$bnk_pay_data = find_all_field('lc_bank_payment','','lc_no='.$lc_no);



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$closing_date=$_POST['invoice_date'];
		$group_for=$_POST['group_for'];
		$lc_no=$_POST['lc_no'];
		$payment_id=$_POST['payment_id'];
		$payment_no=$_POST['payment_no'];
		$ledger_id=$_POST['ledger_id'];
		$lc_number=$_POST['lc_number'];
		$exchange_rate=$_POST['exchange_rate'];
		$total_pay_amt=$_POST['total_pay_amt'];
		$tot_grn_amt_usd=$_POST['tot_grn_amt_usd'];
		
		$lc_data = find_all_field('lc_number_setup','','id='.$lc_no); 
		$bnk_data = find_all_field('lc_bank_entry','','lc_no='.$lc_no); 
		$po_data = find_all_field('lc_purchase_master','','lc_no='.$lc_no);
		

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		
		//$YR = date('Y',strtotime($ch_date));
//  		$yer = date('y',strtotime($ch_date));
//  		$month = date('m',strtotime($ch_date));
//
//  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
//   		$cy_id = sprintf("%07d", $ch_cy_id);
//   		$chalan_no=''.$yer.''.$month.''.$cy_id;


		
		$closing_no = next_transection_no_closing($group_for,$closing_date,'lc_purchase_closing','closing_no');


		$sql = "SELECT p.*, i.item_name FROM lc_purchase_receive p, item_info i WHERE p.item_id=i.item_id and p.lc_no=".$lc_no." order  by  p.id ";

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{
			if($_POST['cost_price_'.$data->id]>0)

			{
			
				$rec_qty=$_POST['rec_qty_'.$data->id];
				$rec_rate_usd=$_POST['rec_rate_usd_'.$data->id];
				$rec_amt_usd=$_POST['rec_amt_usd_'.$data->id];
				$cost_price=$_POST['cost_price_'.$data->id];
				$cost_amt=$_POST['cost_amt_'.$data->id];
				$pre_cost_rate=$_POST['pre_cost_rate_'.$data->id];
				$pre_cost_wise_amt=$_POST['pre_cost_wise_amt_'.$data->id];
				$difference_amt=$_POST['difference_amt_'.$data->id];

       $ins_invoice = 'INSERT INTO lc_purchase_closing (closing_no, closing_date, payment_id, payment_no, po_no, order_no, group_for, lc_no, lc_number, ledger_id, vendor_id, item_id, unit_name, rec_qty, rec_rate_usd, rec_amt_usd, cost_price_bdt, cost_amt_bdt, exchange_rate, total_pay_amt, entry_by, entry_at,sub_ledger_id,pre_cost_rate,pre_cost_wise_amt,difference_amt)
  
  VALUES("'.$closing_no.'", "'.$closing_date.'", "'.$payment_id.'", "'.$payment_no.'",  "'.$data->po_no.'", "'.$data->id.'", "'.$group_for.'", "'.$lc_no.'", "'.$lc_number.'", "'.$ledger_id.'", "'.$data->vendor_id.'", "'.$data->item_id.'", "'.$data->unit_name.'", "'.$rec_qty.'", "'.$rec_rate_usd.'", "'.$rec_amt_usd.'", "'.$cost_price.'", "'.$cost_amt.'", "'.$exchange_rate.'", "'.$total_pay_amt.'", "'.$entry_by.'", "'.$entry_at.'", "'.$lc_data->sub_ledger_id.'", "'.$pre_cost_rate.'", "'.$pre_cost_wise_amt.'", "'.$difference_amt.'")';

db_query($ins_invoice);


$xid = db_insert_id();

//journal_item_control($data->item_id, $_SESSION['user']['depot'], $closing_date,  $rec_qty, 0,  'LC Purchase', $xid, $cost_price, $_SESSION['user']['depot'], $closing_no, '', '', $data->po_no, $lc_no, '', $group_for, $cost_price);

//journal_item_control($data->item_id, $_SESSION['user']['depot'], $closing_date,  $rec_qty, 0, 'LC Purchase', $xid, $cost_price, $_SESSION['user']['depot'], $closing_no);


}

}



		//$up_sql1 = "update lc_purchase_master set status='COMPLETED' where lc_no='".$lc_no."'";
		//db_query($up_sql1);
		
		//$up_sql2 = "update lc_number_setup set status='COMPLETED' where id='".$lc_no."'";
		//db_query($up_sql2);
		
		
		$up_sql3 = "update lc_bank_payment set status='COMPLETED' where lc_no='".$lc_no."'";
		db_query($up_sql3);


if($closing_no>0)
{
//auto_insert_lc_closing_secoundary($closing_no);
auto_insert_lc_closing_secoundary_jamuna($closing_no);
}

		  		$link = "voucher_view.php?payment_no=" .$closing_no;
$redirect = "lc_grn_wise_costing.php"; // page you want current tab to go

echo "<script>
        // Open invoice in a new tab
        window.open('$link', '_blank');

        // Redirect current page to another page
        window.location.href = '$redirect';
      </script>";	


?>

<script language="javascript">
//window.location.href = "lc_grn_wise_costing.php";
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


table thead  {
  / Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}


.style1 {font-weight: bold}
</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">




<? if($lc_no>0){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>

								 <td width="11%">CLOSING DATE:</td>

									<td width="20%">
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />									</td>
									<td width="14%">REFERENCE NO  :</td>
									<td width="21%">
									
									<? 
									
									$lc_data = find_all_field('lc_number_setup','','id='.$lc_no); 
									$bnk_data = find_all_field('lc_bank_entry','','lc_no='.$lc_no); 
									$po_data = find_all_field('lc_purchase_master','','lc_no='.$lc_no);
									?>
									
					
					<input name="group_for" type="hidden" id="group_for"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->group_for;?>"  required tabindex="105" />
									
					<input name="lc_no" type="hidden" id="lc_no"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->id;?>"  required tabindex="105" />
					
					<input name="payment_id" type="hidden" id="payment_id"  readonly="" style="width:220px; height:32px;" value="<?=$payment_id;?>"  required tabindex="105" />
					
					<input name="payment_no" type="hidden" id="payment_no"  readonly="" style="width:220px; height:32px;" value="<?=$bnk_pay_data->payment_no;?>"  required tabindex="105" />
									
					<input name="ledger_id" type="hidden" id="ledger_id"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->ledger_id;?>"  required tabindex="105" />
									
					<input name="lc_number" type="text" id="lc_number"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->lc_number;?>"  required tabindex="105" />										</td>
									<td width="14%">COMPANY:</td>
									<td width="20%">
									
									<table>
		  	<tr>
				<td><input name="company" type="text" id="company"  readonly="" style="width:220px; height:32px;" value="<?=find_a_field('user_group','group_name','id='.$lc_data->group_for); ?>"   tabindex="105" />	</td>
				
			</tr>
		  </table>
									</td>
								  </tr>
								  
								 
  
								  
								
								
								<tr>

								 <td>VENDOR NAME:</td>

									<td>

								<select name="vendor_id" id="vendor_id" required style="width:220px;" >
									
	
								
										<? foreign_relation('vendor_foreign','vendor_id','vendor_name',$_POST['vendor_id'],'vendor_id="'.$po_data->vendor_id.'"');?>
									</select>									</td>
									<td>VENDOR AGENT:</td>
									<td>
											
									
									<select name="supplier_agent" id="supplier_agent"  style="width:220px;">
									 
									  <? foreign_relation('agent_info','agent_id','agent_name',$_POST['supplier_agent'],'agent_id="'.$po_data->supplier_agent.'"');?>
									</select>
									
									</td>
									<td>BANK L/C NO:</td>
									<td><input name="bank_lc_no" type="text" id="bank_lc_no"  style="width:220px; height:32px;" value="<?=$bnk_data->bank_lc_no?>"  readonly=""  tabindex="105" />									</td>
								  </tr>
								
								
								  
					  
								
								 
								</table>

    </div>
	
	<? }?>
	
	
	



<? if($lc_no>0){ ?>


<table width="100%" border="1" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px;  ">
<tr>

    <td colspan="5" valign="top"><table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="2" align="center" bgcolor="#B0E0E6"><strong>L/C Payment Details </strong></td>
      </tr>

      <tr>

        <td width="64%" align="left" bgcolor="#B0E0E6"><strong>&nbsp;&nbsp;Payment Category </strong></td>

        <td width="36%" align="center" bgcolor="#B0E0E6"><strong>&nbsp;&nbsp;
          Amount</strong></td>
        </tr>
		
		
		<? //if($bnk_pay_data->lc_part=="A") {?>
		<?
		

		
		  
      $pay_sql01 = "SELECT c.lc_no, a.bill_type, sum(c.pay_amt_in) as pay_amt_in FROM lc_bill_type a, lc_bill_category b, lc_bill_payment c 
	WHERE a.id=b.bill_type and b.id=c.bill_category and c.lc_no='".$lc_no."'    group by b.bill_type order by c.bill_type ";
    $pay_query01 = db_query($pay_sql01);
    while($pay_data01=mysqli_fetch_object($pay_query01)){$pi++;
	
		?>

      <tr bgcolor="<?=($pi%2)?'#E8F3FF':'#fff';?>">

        <td align="left" >&nbsp;&nbsp;<?=$pay_data01->bill_type;?></td>

        <td align="right" >&nbsp;&nbsp;

           <?=number_format($pay_data01->pay_amt_in,2); $total_pay_amt01 +=$pay_data01->pay_amt_in;?></td>
      </tr>
      
	  
	  <? }?>
		  <? //}?>
		
		
		
		<?
		
		
		
  $sql = "select m.lc_no,  r.payment_id, sum(r.amount_usd) as tot_rec_amt_usd  from lc_purchase_master m, lc_purchase_receive r where m.po_no=r.po_no and r.lc_no=".$lc_no."   group by m.lc_no ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$tot_rec_amt_usd[$data->payment_id]=$data->tot_rec_amt_usd;
}
		
		  
   // $pay_sql = "SELECT c.lc_no, a.bill_type, sum(c.pay_amt_in) as pay_amt_in FROM lc_bill_type a, lc_bill_category b, lc_bill_payment c 
//	WHERE a.id=b.bill_type and b.id=c.bill_category and c.bank_pay_id=".$payment_id." and b.id not in (29,30) group by b.bill_type order by c.bill_type ";
//    $pay_query = db_query($pay_sql);
//    while($pay_data=mysqli_fetch_object($pay_query)){$pi++;
//	
		?>

<!--      <tr bgcolor="<?=($pi%2)?'#E8F3FF':'#fff';?>">

        <td align="left" >&nbsp;&nbsp;<?=$pay_data->bill_type;?></td>

        <td align="right" >&nbsp;&nbsp;

           <?=number_format($pay_data->pay_amt_in,2); $total_pay_amt02 +=$pay_data->pay_amt_in;?></td>
      </tr>-->
      
	  
	  <? //}?>
	  
	  <tr>
        <td align="center" ><strong>&nbsp;&nbsp;Total
		</strong></td>
        <td align="right" ><span class="style1">
          <?=number_format($total_pay_amt=($total_pay_amt01+$total_pay_amt02),2);?>
		  
		   <? 
		  // if($tot_rec_amt_usd[$payment_id]>0){
		   //$tot_rec_amt_usd[$payment_id];   $exchange_rate = $total_pay_amt/$tot_rec_amt_usd[$payment_id];
		  // }
		   ?> 
		<input name="exchange_rate" type="hidden" id="exchange_rate"  readonly="" style="width:220px; height:32px;" value="<?=$exchange_rate;?>"  required tabindex="105" />
		  
		  <input name="total_pay_amt" type="hidden" id="total_pay_amt"  readonly="" style="width:220px; height:32px;" value="<?=$total_pay_amt;?>"  required tabindex="105" />	
        </span></td>
      </tr>

    </table></td>
	<td>
	<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
        
        <tr>
          <td colspan="3" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Pre-Costing Payement </strong></td>
        </tr>
		<?php 	
		 $sqlc = 'SELECT sum(a.pay_amt_in) as pay_amt_in, sum(a.pay_amt_out) as pay_amt_out,   a.payment_no, a.payment_date, b.bill_type from lc_bill_payment_provision a, lc_bill_type b, lc_bill_category c 
		 where b.id=c.bill_type and a.bill_category=c.id  and a.lc_no="'.$lc_no.'" group by b.bill_type order by a.payment_date,a.payment_no ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){

			?>
        <tr style="font-size:12px;">
        <!--  <td align="center" valign="top"><?=++$kksm;?></td>-->

  
          <td align="left" valign="top"><?=$datac->bill_type?></td>
          <td align="right" valign="top"><?=number_format($datac->pay_amt_in,2); $tot_pay_amt_in +=$datac->pay_amt_in; ?></td>
      <!--    <td align="right" valign="top"><?=number_format($datac->pay_amt_out,2); $tot_pay_amt_out +=$datac->pay_amt_out; ?></td>-->
        </tr>
        
        <? }?>
 
        <tr style="font-size:12px;">
          <td  align="right" valign="right"><strong>Total Expenses:</strong></td>
          <td   align="right" valign="right">
		  <strong><?=number_format($total_exp_bdt=($tot_pay_amt_in-$tot_pay_amt_out),2);?> <? //$exchange_rate_bdt = $total_exp_bdt/$grn_value_usd;?></strong></td>
        </tr>
	  </table>
	
	</td>

  </tr>

</table>

<!--<div class="tabledesign2"></div>-->
<table width="100%" border="1" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase; border: 1px solid #FFFFFF;">
 <thead>
  <tr style="border:1px solid #000000;">
    <th width="27%" rowspan="2" >&nbsp;&nbsp;item name </th>

    <th width="22%" rowspan="2">Specification</th>
    <th width="4%" rowspan="2"><div align="center">Unit</div></th>

    <th colspan="3"><div align="center">Received Details </div></th>
    <th width="9%" rowspan="2"><div align="center">Cost price </div></th>
    <th width="13%" rowspan="2"><div align="center">Value BDT </div></th>
	    <th width="13%" rowspan="2"><div align="center">Pre-Costing Price </div></th>
		    <th width="13%" rowspan="2"><div align="center">Pre-Costing Wise Amount </div></th>
			    <th width="13%" rowspan="2"><div align="center">Difference </div></th>
  </tr>
  <tr style="border:1px solid #000000">
    <th width="8%"><div align="center">Qty</div></th>
    <th width="9%"><div align="center">Rate ($) </div></th>
    <th width="8%"><div align="center">value ($) </div></th>
    </tr>
  </thead>

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['bill_type']!='')
  $bill_type_con=" and bill_type=".$_POST['bill_type'];
  
/////////////get actual rate Start///////////
///////////////zero processs////////

  $sqlc = 'SELECT sum(a.pay_amt_in) as pay_amt_in, sum(a.pay_amt_out) as pay_amt_out,   a.payment_no, a.payment_date, b.bill_type,a.lc_no from lc_bill_payment a, lc_bill_type b, lc_bill_category c 
		 where b.id=c.bill_type and a.bill_category=c.id  and a.lc_no="'.$lc_no.'" group by a.lc_no ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			$tot_exp_amt_bdt[$datac->lc_no]=$datac->pay_amt_in-$datac->pay_amt_out;
			}
			
			
			
					//////////////////////First find out item wise payement///////////		
				  $sql='select sum(payment_amt) as item_wise_pay,lc_no,item_id from item_wise_payment where 1 and lc_no="'.$lc_no.'" group by lc_no,item_id';
	  $query=db_query($sql);
	  while($row=mysqli_fetch_object($query)){
	 $tot_item_pay_amt[$row->lc_no][$row->item_id]=$row->item_wise_pay;
	  
	  $gr_tot_item_pay_amt+=$row->item_wise_pay;
	  }	
	  
	   ///////////2nd find out just carring charge//////////
	  
	  				  $sql='select sum(pay_amt_in) as tot_carry_charge,lc_no,bill_type from lc_bill_payment where 1 and bill_type=5 and lc_no="'.$lc_no.'" group by lc_no';
	  $query=db_query($sql);
	  while($row=mysqli_fetch_object($query)){
	 $tot_carrying_charge[$row->lc_no]=$row->tot_carry_charge;  
	  }	
	  $tot_carrying_charge[$lc_no];
	  
	  $tot_exp_without_carry_and_partial=$tot_exp_amt_bdt[$lc_no]-($tot_carrying_charge[$lc_no]+$gr_tot_item_pay_amt);
	  
 	  $sql = "select sum(i.qty) as invoice_qty, i.rate_usd as invoice_rate_usd, sum(i.amount_usd) as invoice_amount_usd,i.po_no,m.po_no,m.lc_no from lc_purchase_receive i,lc_purchase_master m where m.lc_no=".$lc_no." and m.po_no=i.po_no group by i.po_no";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$invoice_qty_get[$data->po_no][$data->item_id]=$data->invoice_qty;
$invoice_rate_usd_get[$data->po_no][$data->item_id]=$data->invoice_rate_usd;
$invoice_amount_usd_get[$data->po_no][$data->item_id]=$data->invoice_amount_usd;

$gr_tot_usd_amt_invoice+=$data->invoice_amount_usd;
$gr_invoice_qty_get_invoice+=$data->invoice_qty;
}
    $sqlc = 'select d.*, i.item_name from lc_purchase_master m, lc_purchase_receive d, item_info i where m.po_no=d.po_no and i.item_id=d.item_id and m.lc_no='.$lc_no.'
			 group by d.item_id order by d.id';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			 $value_based_percentage_get= ((100*$datac->amount_usd) /$gr_tot_usd_amt_invoice);
			 $qty_based_percentage_get= ((100*$datac->qty) /$gr_invoice_qty_get_invoice);
			 
			 $amount_without_carry_and_duty_get=(($tot_exp_without_carry_and_partial*$value_based_percentage_get)/100);
			  $amount_carry_get=(($tot_carrying_charge[$lc_no]*$qty_based_percentage_get)/100);
			  $amount_duty_get= $tot_item_pay_amt[$lc_no][$datac->item_id];
			    $final_cost_of_item=($amount_without_carry_and_duty_get+$amount_carry_get+$amount_duty_get);
			  $cost_rate_actual[$datac->item_id]=$final_cost_of_item/$datac->qty;
			}
 
 
 
 
 /////////////get actual rate End///////////
	  
	  
	  /////////////pre costing  start///////
	  ///////////////zero processs////////

  $sqlc = 'SELECT sum(a.pay_amt_in) as pay_amt_in, sum(a.pay_amt_out) as pay_amt_out,   a.payment_no, a.payment_date, b.bill_type,a.lc_no from lc_bill_payment_provision a, lc_bill_type b, lc_bill_category c 
		 where b.id=c.bill_type and a.bill_category=c.id  and a.lc_no="'.$lc_no.'" group by a.lc_no ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			$tot_exp_amt_bdt_precost[$datac->lc_no]=$datac->pay_amt_in-$datac->pay_amt_out;
			}
			//////////////////////First find out item wise payement///////////		
				  $sql='select sum(payment_amt) as item_wise_pay,lc_no,item_id from item_wise_payment_provision where 1 and lc_no="'.$lc_no.'" group by lc_no,item_id';
	  $query=db_query($sql);
	  while($row=mysqli_fetch_object($query)){
	 $tot_item_pay_amt_precost[$row->lc_no][$row->item_id]=$row->item_wise_pay;
	  
	  $gr_tot_item_pay_amt_precost+=$row->item_wise_pay;
	  }	
	  
	  ///////////2nd find out just carring charge//////////
	  
	  				  $sql='select sum(pay_amt_in) as tot_carry_charge,lc_no,bill_type from lc_bill_payment_provision where 1 and bill_type=5 and lc_no="'.$lc_no.'" group by lc_no';
	  $query=db_query($sql);
	  while($row=mysqli_fetch_object($query)){
	 $tot_carrying_charge_precost[$row->lc_no]=$row->tot_carry_charge;  
	  }	
	  $tot_carrying_charge_precost[$lc_no];
	  
	  $tot_exp_without_carry_and_partial_precost=$tot_exp_amt_bdt_precost[$lc_no]-($tot_carrying_charge_precost[$lc_no]+$gr_tot_item_pay_amt_precost);
	  
 	  $sql = "select sum(i.qty) as invoice_qty, i.rate_usd as invoice_rate_usd, sum(i.amount_usd) as invoice_amount_usd,i.po_no,m.po_no,m.lc_no from lc_purchase_invoice i,lc_purchase_master m where m.lc_no=".$lc_no." and m.po_no=i.po_no group by i.po_no";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$invoice_qty_get_precost[$data->po_no][$data->item_id]=$data->invoice_qty;
$invoice_rate_usd_get_precost[$data->po_no][$data->item_id]=$data->invoice_rate_usd;
$invoice_amount_usd_get_precost[$data->po_no][$data->item_id]=$data->invoice_amount_usd;

$gr_tot_usd_amt_invoice_precost+=$data->invoice_amount_usd;
$gr_invoice_qty_get_invoice_precost+=$data->invoice_qty;
}
    $sqlc = 'select d.*, i.item_name from lc_purchase_master m, lc_purchase_invoice d, item_info i where m.po_no=d.po_no and i.item_id=d.item_id and m.lc_no='.$lc_no.'
			 group by d.item_id order by d.id';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			 $value_based_percentage_get_precost= ((100*$datac->amount_usd) /$gr_tot_usd_amt_invoice_precost);
			 $qty_based_percentage_get_precost= ((100*$datac->qty) /$gr_invoice_qty_get_invoice_precost);
			 
			 $amount_without_carry_and_duty_get_precost=(($tot_exp_without_carry_and_partial_precost*$value_based_percentage_get_precost)/100);
			  $amount_carry_get_precost=(($tot_carrying_charge_precost[$lc_no]*$qty_based_percentage_get_precost)/100);
			  $amount_duty_get_precost= $tot_item_pay_amt_precost[$lc_no][$datac->item_id];
			    $final_cost_of_item_precost=($amount_without_carry_and_duty_get_precost+$amount_carry_get_precost+$amount_duty_get_precost);
			  $cost_rate_precost[$datac->item_id]=$final_cost_of_item_precost/$datac->qty;
			}
 
 
	  	  /////////////pre costing  End///////
			

  
  $sql = "select order_no, sum(qty) as rec_qty, sum(rate_usd) as rec_rate_usd, sum(amount_usd) as rec_amount_usd  from lc_purchase_receive where po_no=".$po_data->po_no." group by order_no ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rec_qty[$data->order_no]=$data->rec_qty;
$rec_rate_usd[$data->order_no]=$data->rec_rate_usd;
$rec_amount_usd[$data->order_no]=$data->rec_amount_usd;
}
  
 
     
     $sql = "SELECT p.*, i.item_name FROM lc_purchase_receive p, item_info i WHERE p.item_id=i.item_id and  p.lc_no=".$lc_no." order by  p.id ";
    $query = db_query($sql);
    while($data=mysqli_fetch_object($query)){$i++;


  ?>



<? //if ($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no]>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>" style="border:1px solid #000000; ">
    <td><span class="style13" style="color:#000000; font-weight:700;">
      &nbsp;&nbsp;<?=$data->item_name;?>
    </span></td>

    <td>&nbsp; <?=$data->specification;?>  </td>
    <td>
   &nbsp;&nbsp;  <?=$data->unit_name;?>    </td>

    <td><div align="right">
      <?=$data->qty;?>
	  
	  <input name="rec_qty_<?=$data->id?>" id="rec_qty_<?=$data->id?>" type="hidden" size="10"  value="<?=$data->qty?>" style="width:100px; height:25px;"  />
    </div></td>
    <td><div align="right">
      <?=$data->rate_usd;?>
	  
	  <input name="rec_rate_usd_<?=$data->id?>" id="rec_rate_usd_<?=$data->id?>" type="hidden" size="10"  value="<?=$data->rate_usd;?>" style="width:100px; height:25px;"  />
    </div></td>
    <td><div align="right">
      <?=number_format($data->amount_usd,2); $tot_amount_usd +=$data->amount_usd?>
	  
	  
	  <input name="rec_amt_usd_<?=$data->id?>" id="rec_amt_usd_<?=$data->id?>" type="hidden" size="10"  value="<?=$data->amount_usd;?>" style="width:100px; height:25px;"  />
    </div></td>
    <td>
 <input name="cost_price_<?=$data->id?>" id="cost_price_<?=$data->id?>" type="text" size="10"  value="<?=$cost_price=$cost_rate_actual[$data->item_id];?>" style="width:100px; height:25px;"  />	</td>
    <td align="center"><input name="cost_amt_<?=$data->id?>" id="cost_amt_<?=$data->id?>" type="text"   value="<?=$cost_amt=($data->qty*$cost_price); $tot_cost_amt +=$cost_amt;?>" style="width:120px; height:25px;"  />	</td>
	<td><input type="hidden" name="pre_cost_rate_<?=$data->id?>" id="pre_cost_rate_<?=$data->id?>" value="<?php echo $cost_rate_precost[$data->item_id];?>"  /><?php echo $cost_rate_precost[$data->item_id];?></td>
	<td><input type="hidden" name="pre_cost_wise_amt_<?=$data->id?>" id="pre_cost_wise_amt_<?=$data->id?>" value="<?php echo $precost_wise_amount=($data->qty*$cost_rate_precost[$data->item_id]);?>"  /><?php echo $precost_wise_amount=($data->qty*$cost_rate_precost[$data->item_id]);?></td>
	<td><input type="hidden" name="difference_amt_<?=$data->id?>" id="difference_amt_<?=$data->id?>" value="<?php echo $difference=$cost_amt-$precost_wise_amount;?>"  /><?php echo $difference=$cost_amt-$precost_wise_amount;?></td>
  </tr>
   <? 
   
   $gr_tot_precost_amt+=$precost_wise_amount;
   } //}?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>" style="border:1px solid #000000; font-size: 14px;">
    <td><div align="right"><strong>&nbsp;&nbsp;Total </strong></div></td>
    <td>&nbsp;</td>
    <td><div align="right"></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"><strong>
      <?=number_format($tot_amount_usd,2);?>
	  <input name="tot_amount_usd" type="hidden" id="tot_amount_usd"  readonly="" style="width:220px; height:32px;" value="<?=$tot_amount_usd;?>"  required tabindex="105" />
    </strong></div></td>
    <td><div align="right"></div></td>
    <td align="center"><div align="center"><strong>
      <?=number_format($tot_cost_amt,2);?>
    </strong></div></td>
	<td></td>
	<td><?php echo $gr_tot_precost_amt;?></td>
	<td><?php echo ($tot_cost_amt-$gr_tot_precost_amt);?></td>
  </tr>
</table>




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