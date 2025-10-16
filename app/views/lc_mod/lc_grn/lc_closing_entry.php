<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='L/C Closing Entry';


  //create_combobox('do_no');

do_calander('#invoice_date');
//do_calander('#ldbc_no_date');
do_calander('#cheque_date');

 $data_found = $_POST['lc_no'];

if ($data_found==0) {
 //create_combobox('lc_no');
  }



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$closing_date=$_POST['invoice_date'];
		$group_for=$_POST['group_for'];
		$lc_no=$_POST['lc_no'];
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

		
		$tr_unique=88;
		
		$closing_no = next_transection_no($tr_unique,$closing_date,'lc_purchase_closing','closing_no');

		$sql = "SELECT p.*, i.item_name FROM lc_purchase_invoice p, item_info i WHERE p.item_id=i.item_id and  p.po_no=".$po_data->po_no." order  by  p.id";

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

   $ins_invoice = 'INSERT INTO lc_purchase_closing (closing_no, closing_date, po_no, order_no, group_for, lc_no, lc_number, ledger_id, vendor_id, item_id, unit_name, rec_qty, rec_rate_usd, rec_amt_usd, cost_price_bdt, cost_amt_bdt, exchange_rate, total_pay_amt, entry_by, entry_at)
  
  VALUES("'.$closing_no.'", "'.$closing_date.'", "'.$data->po_no.'", "'.$data->id.'", "'.$group_for.'", "'.$lc_no.'", "'.$lc_number.'", "'.$ledger_id.'", "'.$data->vendor_id.'", "'.$data->item_id.'", "'.$data->unit_name.'", "'.$rec_qty.'", "'.$rec_rate_usd.'", "'.$rec_amt_usd.'", "'.$cost_price.'", "'.$cost_amt.'", "'.$exchange_rate.'", "'.$total_pay_amt.'", "'.$entry_by.'", "'.$entry_at.'")';

db_query($ins_invoice);

$xid = db_insert_id();
journal_item_control($data->item_id, $_SESSION['user']['depot'], $closing_date,  $rec_qty, 0,  'Import Purchase', $xid, $cost_price, $_SESSION['user']['depot'], $closing_no, '', '', $data->po_no, $lc_no, '', $group_for, $cost_price);


}

}



		$up_sql1 = "update lc_purchase_master set status='COMPLETED' where lc_no='".$lc_no."'";
		db_query($up_sql1);
		
		$up_sql2 = "update lc_number_setup set status='COMPLETED' where id='".$lc_no."'";
		db_query($up_sql2);


if($closing_no>0)
{
auto_insert_lc_closing_secoundary($closing_no);
}

?>

<script language="javascript">
window.location.href = "lc_closing_entry.php";
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

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td align="right" ><strong>L/C No: </strong></td>



    <td ><select name="lc_no" id="lc_no" style="width:220px;" required>
      <option></option>
      <? foreign_relation('lc_number_setup','id','lc_number',$_POST['lc_no'],'status!="COMPLETED"'); ?>
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

								 <td width="11%">CLOSING DATE:</td>

									<td width="20%">
									
									<?php /*?><?=($invoice_date!='')?$invoice_date:date('Y-m-d')?><?php */?>
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=$_POST['invoice_date']?>"   required />									</td>
									<td width="14%">L/C NO  :</td>
									<td width="21%">
									
									<? 
									
									$lc_data = find_all_field('lc_number_setup','','id='.$_POST['lc_no']); 
									$bnk_data = find_all_field('lc_bank_entry','','lc_no='.$_POST['lc_no']); 
									$po_data = find_all_field('lc_purchase_master','','lc_no='.$_POST['lc_no']);
									?>
									
					
					<input name="group_for" type="hidden" id="group_for"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->group_for;?>"  required tabindex="105" />
									
					<input name="lc_no" type="hidden" id="lc_no"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->id;?>"  required tabindex="105" />
									
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

								 <td>COMM. LICENCE:</td>

									<td>

									<select name="commercial_licence" id="commercial_licence"   style="width:220px;">
								
								
										<? foreign_relation('commercial_licence_info','company_id','company_name',$_POST['commercial_licence'],'company_id="'.$lc_data->commercial_licence.'"');?>
									</select>									</td>
									<td>L/C TYPE:</td>
									<td>
								
									
									
									<select name="lc_type" id="lc_type" required="required" style="width:220px;">
									 
									  <? foreign_relation('lc_type','id','lc_type',$_POST['lc_type'],'id="'.$lc_data->lc_type.'"');?>
									</select>
									
									</td>
									<td>PI NO:</td>
									<td><input name="pi_no" type="text" id="pi_no"  style="width:220px; height:32px;" value="<?=$bnk_data->pi_no?>"  readonly=""  tabindex="105" />									</td>
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
	
	
	



<? if(isset($_POST['submit'])){ ?>


<table width="100%" border="1" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px;  ">
<tr>

    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="2" align="center" bgcolor="#B0E0E6"><strong>L/C Payment Details </strong></td>
      </tr>

      <tr>

        <td width="64%" align="left" bgcolor="#B0E0E6"><strong>&nbsp;&nbsp;Payment Category </strong></td>

        <td width="36%" align="center" bgcolor="#B0E0E6"><strong>&nbsp;&nbsp;
          Amount</strong></td>
        </tr>
		
		<?
		
		
		
 $sql = "select m.lc_no,  sum(r.amount_usd) as tot_rec_amt_usd  from lc_purchase_master m, lc_purchase_receive r where m.po_no=r.po_no and m.lc_no=".$lc_data->id." group by m.lc_no ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$tot_rec_amt_usd[$data->lc_no]=$data->tot_rec_amt_usd;
}
		
		  
    $pay_sql = "SELECT c.lc_no, a.bill_type, sum(c.pay_amt_in-c.pay_amt_out) as pay_amt_in FROM lc_bill_type a, lc_bill_category b, lc_bill_payment c 
	WHERE a.id=b.bill_type and b.id=c.bill_category and c.lc_no=".$lc_data->id."   group by b.bill_type order by c.bill_type ";
    $pay_query = db_query($pay_sql);
    while($pay_data=mysqli_fetch_object($pay_query)){$pi++;
	
		?>

      <tr bgcolor="<?=($pi%2)?'#E8F3FF':'#fff';?>">

        <td align="left" >&nbsp;&nbsp;<?=$pay_data->bill_type;?></td>

        <td align="right" >&nbsp;&nbsp;

           <?=number_format($pay_data->pay_amt_in,2); $total_pay_amt +=$pay_data->pay_amt_in;?></td>
      </tr>
      
	  
	  <? }?>
	  
	  <tr>
        <td align="center" ><strong>&nbsp;&nbsp;Total <? $tot_rec_amt_usd[$lc_data->id];  $exchange_rate = $total_pay_amt/$tot_rec_amt_usd[$lc_data->id];?> 
		<input name="exchange_rate" type="hidden" id="exchange_rate"  readonly="" style="width:220px; height:32px;" value="<?=$exchange_rate;?>"  required tabindex="105" />
		</strong></td>
        <td align="right" ><span class="style1">
          <?=number_format($total_pay_amt,2);?>
		  
		  <input name="total_pay_amt" type="hidden" id="total_pay_amt"  readonly="" style="width:220px; height:32px;" value="<?=$total_pay_amt;?>"  required tabindex="105" />	
        </span></td>
      </tr>

    </table></td>

  </tr>

</table>

<!--<div class="tabledesign2"></div>-->
<table width="100%" border="1" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase; border: 1px solid #FFFFFF;">
 <thead>
  <tr style="border:1px solid #000000;">
    <th width="26%" rowspan="2" >&nbsp;&nbsp;item name </th>

    <th width="6%" rowspan="2"><div align="center">Unit</div></th>

    <th colspan="3"><div align="center">Order Details </div></th>
    <th colspan="3"><div align="center">Received Details </div></th>
    <th width="8%" rowspan="2"><div align="center">Cost price </div></th>
    <th width="17%" rowspan="2"><div align="center">Value BDT </div></th>
  </tr>
  <tr style="border:1px solid #000000">
    <th width="5%"><div align="center">Qty</div></th>
    <th width="10%"><div align="center">Rate ($) </div></th>
    <th width="8%"><div align="center">value ($) </div></th>
    <th width="7%"><div align="center">Qty</div></th>
    <th width="7%"><div align="center">Rate ($) </div></th>
    <th width="6%"><div align="center">value ($) </div></th>
  </tr>
  </thead>

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['bill_type']!='')
  $bill_type_con=" and bill_type=".$_POST['bill_type'];
  



  
 echo $sql = "select order_no, sum(qty) as rec_qty, rate_usd as rec_rate_usd, sum(amount_usd) as rec_amount_usd  from lc_purchase_receive where po_no=".$po_data->po_no." group by order_no ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rec_qty[$data->order_no]=$data->rec_qty;
$rec_rate_usd[$data->order_no]=$data->rec_rate_usd;
$rec_amount_usd[$data->order_no]=$data->rec_amount_usd;
}
  
 
     
    $sql = "SELECT p.*, i.item_name FROM lc_purchase_invoice p, item_info i WHERE p.item_id=i.item_id and  p.po_no=".$po_data->po_no." order  by  p.id ";
    $query = db_query($sql);
    while($data=mysqli_fetch_object($query)){$i++;


  ?>



<? //if ($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no]>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>" style="border:1px solid #000000; ">
    <td><span class="style13" style="color:#000000; font-weight:700;">
      &nbsp;&nbsp;<?=$data->item_name;?>
    </span></td>

    <td>
   &nbsp;&nbsp;  <?=$data->unit_name;?>    </td>

    <td><div align="right">
      <?=$data->qty;?>
    </div></td>
    <td><div align="right">
      <?=$data->rate_usd;?>
    </div></td>
    <td><div align="right">
      <?=number_format($data->amount_usd,2); $tot_amount_usd +=$data->amount_usd?>
    </div></td>
    <td><div align="right">
      <?=$rec_qty[$data->id];?>
	  
	  <input name="rec_qty_<?=$data->id?>" id="rec_qty_<?=$data->id?>" type="hidden" size="10"  value="<?=$rec_qty[$data->id];?>" style="width:100px; height:25px;"  />
    </div></td>
    <td><div align="right">
      <?=$rec_rate_usd[$data->id];?>
	  <input name="rec_rate_usd_<?=$data->id?>" id="rec_rate_usd_<?=$data->id?>" type="hidden" size="10"  value="<?=$rec_rate_usd[$data->id];?>" style="width:100px; height:25px;"  />
    </div></td>
    <td><div align="right">
      <?=number_format($rec_amount_usd[$data->id],2); $tot_rec_amount_usd +=$rec_amount_usd[$data->id];?>
	   <input name="rec_amt_usd_<?=$data->id?>" id="rec_amt_usd_<?=$data->id?>" type="hidden" size="10"  value="<?=$rec_amount_usd[$data->id];?>" style="width:100px; height:25px;"  />
    </div></td>
    <td>
 <input name="cost_price_<?=$data->id?>" id="cost_price_<?=$data->id?>" type="text" size="10"  value="<?=$cost_price=($rec_rate_usd[$data->id]*$exchange_rate);?>" style="width:100px; height:25px;"  />	</td>
    <td align="center"><input name="cost_amt_<?=$data->id?>" id="cost_amt_<?=$data->id?>" type="text"   value="<?=$cost_amt=($rec_qty[$data->id]*$cost_price); $tot_cost_amt +=$cost_amt;?>" style="width:120px; height:25px;"  />	</td>
  </tr>
   <? } //}?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>" style="border:1px solid #000000; font-size: 14px;">
    <td><div align="right"><strong>&nbsp;&nbsp;Total </strong></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"><strong>
      <?=number_format($tot_amount_usd,2);?>
    </strong></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"><strong>
      <?=number_format($tot_rec_amount_usd,2);?>
    </strong>
	 <input name="tot_grn_amt_usd" type="hidden" id="tot_grn_amt_usd"  readonly="" style="width:220px; height:32px;" value="<?=$tot_rec_amount_usd;?>"  required tabindex="105" />
	</div></td>
    <td><div align="right"></div></td>
    <td align="center"><div align="center"><strong>
      <?=number_format($tot_cost_amt,2);?>
    </strong></div></td>
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


require_once SERVER_CORE."routing/layout.bottom.php";

?>