<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='L/C Provision Entry';


 // create_combobox('do_no');
  
 create_combobox('lc_no');
  
  

do_calander('#invoice_date');
do_calander('#boe_date');
do_calander('#r_date');

 $data_found = $_POST['lc_no'];

if ($data_found==0) {
 //create_combobox('lc_no');
  }



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$payment_date=$_POST['invoice_date'];
		$order_no =$_POST['item_id'];
		$payment_method=$_POST['payment_method'];
		$group_for=$_POST['group_for'];
		$lc_no=$_POST['lc_no'];
		$lc_number=$_POST['lc_number'];
		$note=$_POST['note'];	
		$boe_no=$_POST['boe_no'];
		$boe_date=$_POST['boe_date'];
		$r_no=$_POST['r_no'];
		$r_date=$_POST['r_date'];	
		$bank_ledger_id=$_POST['bank_ledger_id'];
		
		
		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
	
		$ledger_id=$_POST['ledger_id'];
		
		$lc_part=$_POST['lc_part'];
		
		$lc_part_view=find_a_field('lc_part','lc_part','id="'.$lc_part.'"');
		
		if($lc_part==1) {
			$lc_no_part=$lc_number;
		}elseif($lc_part==""){
			$lc_no_part=$lc_number;
		}else {
			$lc_no_part=$lc_number.' - ('.$lc_part_view.')';
		}
		

		
		//if($_POST['bill_type']==3) {
//			$ledger_id=find_a_field('lc_ledger_config','lc_margin','id="1"');
//		}else{
//			$ledger_id=$_POST['ledger_id'];
//		}
		
		
		if($_POST['cr_loan_ledger_id']>0) {
			$cr_ledger_id=$_POST['cr_loan_ledger_id'];
		}else {
			$cr_ledger_id=$_POST['cr_ledger_id'];
		}
		
		
		
		
	
  if($_POST['bill_type']!='')
  $bill_type_con=" and bill_type=".$_POST['bill_type'];
  


	
		
		
		//$YR = date('Y',strtotime($ch_date));
//  		$yer = date('y',strtotime($ch_date));
//  		$month = date('m',strtotime($ch_date));
//
//  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
//   		$cy_id = sprintf("%07d", $ch_cy_id);
//   		$chalan_no=''.$yer.''.$month.''.$cy_id;


		$tr_unique=77;

		$payment_no = next_transection_no($tr_unique,$payment_date,'lc_provision_payment','payment_no');


		$sql = "SELECT id, bill_type, bill_category as category_view FROM lc_bill_category WHERE 1 ".$bill_type_con." order  by bill_type,id";

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{
			if($_POST['payment_amt_'.$data->id]>0)

			{

				$payment_amt=$_POST['payment_amt_'.$data->id];
				$bill_type=$_POST['bill_type_'.$data->id];
				$bill_category=$_POST['bill_category_'.$data->id];
				$remarks=$_POST['remarks_'.$data->id];
				$qty = $_POST['qty_'.$data->id];
				$rate = $_POST['rate_'.$data->id];
				

   $ins_invoice = 'INSERT INTO lc_provision_payment (payment_no, payment_date, payment_method, lc_no, lc_number, lc_ledger, bank_pay_id, lc_part, lc_part_no, group_for, bill_type, bill_category, category_view, cr_ledger_id,order_no,rate,qty,pay_amt_in, pay_amt_out, remarks, note, r_no, r_date, status, entry_by, entry_at, boe_no, boe_date)
  
  VALUES("'.$payment_no.'", "'.$payment_date.'", "'.$payment_method.'", "'.$lc_no.'", "'.$lc_number.'", "'.$ledger_id.'", "'.$lc_part.'", "'.$lc_part_view.'", "'.$lc_no_part.'", "'.$group_for.'",  "'.$bill_type.'", "'.$bill_category.'", "'.$data->category_view.'", "'.$cr_ledger_id.'","'.$order_no.'","'.$rate.'","'.$qty.'","'.$payment_amt.'", "0", "'.$remarks.'", "'.$note.'", "'.$r_no.'", "'.$r_date.'", "CHECKED", "'.$entry_by.'", "'.$entry_at.'", "'.$boe_no.'", "'.$boe_date.'")';

db_query($ins_invoice);


}

}


//if($payment_no>0)
//{
//auto_insert_lc_all_payment_secoundary($payment_no);
//}

?>

<script language="javascript">
window.location.href = "lc_provision_payment.php";
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


function itemQty(id){

	//alert(id);
	
	var itemCode=id;

$.ajax({
        url: "itemAjax.php",
        type: "post",
		dataType: 'json',
        data: { itemCode: itemCode} ,
        success: function (data) {
		  console.log(data);
		  
		  
		  <?

if($_POST['bill_type']!='')
$bill_type_con=" and bill_type=".$_POST['bill_type'];

$sql = "SELECT id, bill_type, bill_category FROM lc_bill_category WHERE 1 ".$bill_type_con." order  by bill_type,id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
?>
	
	$("#qty_<?=$data->id?>").val(data[8]);	  
<? } ?>		  		  
        }
    });


}


function SUMcalculation(id){

var total_amt = 0;

var  total = document.getElementById('payment_amt_'+id).value*1;
var  qty = document.getElementById('qty_'+id).value*1;
var rate = total/qty;
document.getElementById('rate_'+id).value = rate;

<?

if($_POST['bill_type']!='')
$bill_type_con=" and bill_type=".$_POST['bill_type'];

$sql = "SELECT id, bill_type, bill_category FROM lc_bill_category WHERE 1 ".$bill_type_con." order  by bill_type,id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
?>
total_amt = total_amt + document.getElementById('payment_amt_<?=$data->id?>').value*1;
<?
}

?>
document.getElementById('total_amt').value = total_amt;



}

function rateCal(id){

var total_amt = 0;

var  total = document.getElementById('payment_amt_'+id).value*1;
var  qty = document.getElementById('qty_'+id).value*1;
var  rate = document.getElementById('rate_'+id).value*1;

var total = qty* rate;


document.getElementById('payment_amt_'+id).value = total;

<?

if($_POST['bill_type']!='')
$bill_type_con=" and bill_type=".$_POST['bill_type'];

$sql = "SELECT id, bill_type, bill_category FROM lc_bill_category WHERE 1 ".$bill_type_con." order  by bill_type,id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
?>
total_amt = total_amt + document.getElementById('payment_amt_<?=$data->id?>').value*1;
<?
}

?>
document.getElementById('total_amt').value = total_amt;



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

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td align="right" ><strong>L/C NO: </strong></td>



    <td ><select name="lc_no" id="lc_no" style="width:220px;" required>
      <option></option>
      <?

	//foreign_relation('lc_number_setup','id','lc_number',$_POST['lc_no'],'1 ');
	//foreign_relation('lc_bank_entry','lc_no','bank_lc_no',$_POST['lc_no'],'1');
	
	foreign_relation('lc_pi_reference_setup','id','pi_number',$_POST['lc_no'],'1');

?>
    </select></td>
	
	
	 <td align="right" ><strong>Payment Type: </strong></td>



    <td ><select name="bill_type" id="bill_type" style="width:220px;" required>
      <option></option>
      <?

foreign_relation('lc_bill_type','id','bill_type',$_POST['bill_type'],'1');

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

								 <td >PAYMENT DATE:</td>

									<td >
									
									<?php /*?><?=($invoice_date!='')?$invoice_date:date('Y-m-d')?><?php */?>
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=$_POST['invoice_date']?>"   required />									</td>
									<td  align="right">L/C  NO  :</td>
									<td >
									
									<?
									 $lc_data = find_all_field('lc_number_setup','','id='.$_POST['lc_no']); 
									 $bank_ledger = find_a_field('lc_bank_entry','bank_ledger','lc_no='.$_POST['lc_no']); 
									?>
									
					<input name="bill_type" type="hidden" id="bill_type"  readonly="" style="width:220px; height:32px;" value="<?=$_POST['bill_type'];?>"  required tabindex="105" />
									
					<input name="group_for" type="hidden" id="group_for"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->group_for;?>"  required tabindex="105" />
					
					<input name="bank_ledger_id" type="hidden" id="bank_ledger_id"  readonly="" style="width:220px; height:32px;" value="<?=$bank_ledger;?>"  required tabindex="105" />
						
					<input name="lc_no" type="hidden" id="lc_no"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->id;?>"  required tabindex="105" />
									
					<input name="ledger_id" type="hidden" id="ledger_id"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->ledger_id;?>"  required tabindex="105" />
									
				<input name="lc_number" type="text" id="lc_number"  readonly="" style="width:220px; height:32px;" value="<?=$lc_data->lc_number;?>"  required tabindex="105" />										</td>
									<td  align="right">COMPANY :</td>
									<td >
									
									<table>
		  	<tr>
				<td><input name="company" type="text" id="company"  readonly="" style="width:220px; height:32px;" value="<?=find_a_field('user_group','group_name','id='.$lc_data->group_for); ?>"   tabindex="105" />	</td>
				
			</tr>
		  </table>
									</td>
								  </tr>
								  
								  
					<? if ($_POST['bill_type']==1) {?>
								  
								  <tr>

								 <td>Item Name </td>

									<td>
										<select name="item_id" id="item_id" required="required" style="width:220px;" onchange="itemQty(this.value);">
									  <option></option>
									  <? foreign_relation('lc_purchase_invoice p,lc_purchase_master m,item_info i','p.id','i.item_name',$_POST['item_id'],'1 and m.po_no=p.po_no and  p.item_id=i.item_id and m.lc_no='.$lc_data->id.'');?>
									</select>
										
									</td>
									<td align="right">INSURANCE COMPANY:</td>
									<td>
								
									
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('insurance_company','ledger_id','company_name',$_POST['cr_ledger_id'],'1');?>
									</select>
									
									</td>
									<td align="right">REMARKS:</td>
									<td colspan="2"><input name="note" type="text" id="note"  style="width:220px; height:32px;" value=""   tabindex="105" />									</td>
								  </tr>
								  
								  
							<? } elseif ($_POST['bill_type']==2 || $_POST['bill_type']==8) {?>	  
								  
								  
								
  
							<tr>
								  
								  
								  
								   	 <td>PMT. METHOD:</td>

									<td>
								<!--	onchange="getData2('cash_bank_ajax.php', 'cash_bank_filter', this.value,  document.getElementById('payment_method').value);" -->

	<select name="payment_method" id="payment_method" required  >
		
										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1 order by payment_method');?>
									</select>									</td>
									
									
									<td>Item Name </td>

									<td>
										<select name="item_id" id="item_id" required="required"  onchange="itemQty(this.value);">
									  <option></option>
									  <? foreign_relation('lc_purchase_invoice p,lc_purchase_master m,item_info i','p.id','i.item_name',$_POST['item_id'],'1 and m.po_no=p.po_no and  p.item_id=i.item_id and m.lc_no='.$lc_data->id.'');?>
									</select>
										
									</td>
									
									
									<td align="right">CASH/BANK:</td>
									<td>
								
									<span id="cash_bank_filter">
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" >
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$bank_ledger,'ledger_group_id in (126001,126002)');?>
									</select>
									</span>
									</td>
									<td align="right">REMARKS:</td>
									<td><input name="note" type="text" id="note"  style="height:32px;" value=""   tabindex="105" />									</td>
								  </tr>


								
						<? }  elseif ($_POST['bill_type']==3) {?>
						
						
						
								  
								  
								  
								  
								  <tr>
					
								  
								   	 <td>PMT. METHOD:</td>

									<td>

									<select name="payment_method" id="payment_method"  style="width:220px;">
									<option></option>
	
								
										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1');?>
									</select>									</td>
									<td align="right">CASH/BANK:</td>
									<td>
								
									<span id="cash_bank_filter">
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id in (126001,126002)');?>
									</select>
									</span>
									</td>
									<td align="right">L/C Part:</td>
									<td>
									
									<select name="lc_part" id="lc_part" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('lc_part','id','lc_part',$_POST['lc_part'],'1');?>
									</select>
									</td>
				 </tr>
				 
				 
				 
				 <tr>

								 <td>Item Name </td>

									<td>
										<select name="item_id" id="item_id" required="required" style="width:220px;" onchange="itemQty(this.value);">
									  <option></option>
									  <? foreign_relation('lc_purchase_invoice p,lc_purchase_master m,item_info i','p.id','i.item_name',$_POST['item_id'],'1 and m.po_no=p.po_no and  p.item_id=i.item_id and m.lc_no='.$lc_data->id.'');?>
									</select>
										
									</td>
									
									<td align="right">REMARKS:</td>
									<td><input name="note" type="text" id="note"  style="width:220px; height:32px;" value=""   tabindex="105" />									</td>
								  </tr>
								  
					  
					  
								  
						
						
						<? } elseif ($_POST['bill_type']==4) { ?>
						
						
						
						<tr>
						<td>Item Name </td>

									<td>
										<select name="item_id" id="item_id" required="required" style="width:220px;" onchange="itemQty(this.value);">
									  <option></option>
									  <? foreign_relation('lc_purchase_invoice p,lc_purchase_master m,item_info i','p.id','i.item_name',$_POST['item_id'],'1 and m.po_no=p.po_no and  p.item_id=i.item_id and m.lc_no='.$lc_data->id.'');?>
									</select>
										
									</td>
								  
								   	 		<td align="right">LOAN LEDGER: </td>
									<td>
								
								
									<select name="cr_loan_ledger_id" id="cr_loan_ledger_id" style="width:220px;">
									  <option></option>
									  <? foreign_relation('lc_ltr_loan','ledger_id','ltr_number',$_POST['cr_ledger_id'],'ltr_complete!="Yes" and lc_no="'.$_POST['lc_no'].'"');?>
									</select>
									
									</td>
									 
									<td align="right">L/C Part:</td>
									<td>
									
									<select name="lc_part" id="lc_part" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('lc_part','id','lc_part',$_POST['lc_part'],'1');?>
									</select>
									</td>
								  </tr>
						
						
								
						
						<? } elseif ($_POST['bill_type']==5) { ?>
						
						 
						<tr>
							<td>Item Name </td>

									<td>
										<select name="item_id" id="item_id" required="required" style="width:220px;" onchange="itemQty(this.value);">
									  <option></option>
									  <? foreign_relation('lc_purchase_invoice p,lc_purchase_master m,item_info i','p.id','i.item_name',$_POST['item_id'],'1 and m.po_no=p.po_no and  p.item_id=i.item_id and m.lc_no='.$lc_data->id.'');?>
									</select>
										
									</td>
								  
								   	<td align="right">Transport  COMPANY:</td>

									<td>

									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('transport_company','ledger_id','company_name',$_POST['cr_ledger_id'],'1');?>
									</select>									</td>
									 
									 
									<td align="right">L/C Part:</td>
									<td>
									
									<select name="lc_part" id="lc_part" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('lc_part','id','lc_part',$_POST['lc_part'],'1');?>
									</select>
									</td>
								  </tr>
						
								  
								  
						
						<? } elseif ($_POST['bill_type']==6) {?>
						
						
<tr>
<td>Item Name </td>

									<td>
										<select name="item_id" id="item_id" required="required" style="width:220px;" onchange="itemQty(this.value);">
									  <option></option>
									  <? foreign_relation('lc_purchase_invoice p,lc_purchase_master m,item_info i','p.id','i.item_name',$_POST['item_id'],'1 and m.po_no=p.po_no and  p.item_id=i.item_id and m.lc_no='.$lc_data->id.'');?>
									</select>
										
									</td>

								<td>L/C Part:</td>
									<td>
									
									<select name="lc_part" id="lc_part" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('lc_part','id','lc_part',$_POST['lc_part'],'1');?>
									</select>
									</td>

								 <td align="right">BILL OF ENTRY NO: </td>

									<td>
									<input name="boe_no" type="text" id="boe_no"  style="width:220px; height:32px;" value=""   tabindex="105" />
									</td>
									<td align="right">BILL OF ENTRY DATE: </td>
									<td>
								
								
									
									<input name="boe_date" type="text" id="boe_date"  style="width:220px; height:32px;" value=""   tabindex="105" />
									
									</td>
									
								  </tr>
						
						<tr>

								 <td>C&amp;F COMPANY:</td>

									<td>
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('cnf_company','ledger_id','company_name',$_POST['cr_ledger_id'],'1');?>
									</select>
									</td>
									<td align="right">R. NO: </td>
									<td>
							
									<input name="r_no" type="text" id="r_no"  style="width:220px; height:32px;" value=""   tabindex="105" />
									
									</td>
									<td align="right">R. DATE :</td>
									<td><input name="r_date" type="text" id="r_date"  style="width:220px; height:32px;" value=""   tabindex="105" />									</td>
								  </tr>
								  
						
						
						<? }elseif ($_POST['bill_type']==7){?>
						
						<tr>
								  
								  <td>Item Name </td>

									<td>
										<select name="item_id" id="item_id" required="required" style="width:220px;" onchange="itemQty(this.value);">
									  <option></option>
									  <? foreign_relation('lc_purchase_invoice p,lc_purchase_master m,item_info i','p.id','i.item_name',$_POST['item_id'],'1 and m.po_no=p.po_no and  p.item_id=i.item_id and m.lc_no='.$lc_data->id.'');?>
									</select>
										
									</td>
								  
								   	 <td>PMT. METHOD:</td>

									<td>
								<!--	onchange="getData2('cash_bank_ajax.php', 'cash_bank_filter', this.value,  document.getElementById('payment_method').value);" -->

	<select name="payment_method" id="payment_method"  style="width:220px;" >
									<option></option>
	
								
										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1');?>
									</select>									</td>
									<td align="right">CASH/BANK:</td>
									<td>
								
									<span id="cash_bank_filter">
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id in (126001,126002)');?>
									</select>
									</span>
									</td>
									<td align="right">REMARKS:</td>
									<td><input name="note" type="text" id="note"  style="width:220px; height:32px;" value=""   tabindex="105" />									</td>
								  </tr>
						
						
						<? } else{ ?>
						
						
						



<tr>
<td>Item Name </td>

									<td>
										<select name="item_id" id="item_id" required="required" style="width:220px;" onchange="itemQty(this.value);">
									  <option></option>
									  <? foreign_relation('lc_purchase_invoice p,lc_purchase_master m,item_info i','p.id','i.item_name',$_POST['item_id'],'1 and m.po_no=p.po_no and  p.item_id=i.item_id and m.lc_no='.$lc_data->id.'');?>
									</select>
										
									</td>
								  
						   	 <td>PMT. METHOD:</td>

									<td>
								<!--	onchange="getData2('cash_bank_ajax.php', 'cash_bank_filter', this.value,  document.getElementById('payment_method').value);" -->

	<select name="payment_method" id="payment_method" required style="width:220px;" >
									<option></option>
	
								
										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1');?>
									</select>									</td>
									<td align="right">CASH/BANK:</td>
									<td>
								
									<span id="cash_bank_filter">
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id in (126001,126002)');?>
									</select>
									</span>
									</td>
									<td align="right">REMARKS:</td>
									<td><input name="note" type="text" id="note"  style="width:220px; height:32px;" value=""   tabindex="105" />									</td>
								  </tr>
						
						
						
						
						<? }?>
								  
								  
							
								 
								</table>

    </div>
	
	<? }?>



<? if(isset($_POST['submit'])){ ?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">
 <thead>
  <tr>
    <th width="6%">Code</th>

    <th width="15%">Payment Type </th>

    <th width="33%">Payment Category </th>
    <th width="15%">Qty</th>
    <th width="15%">Rate</th>
    <th width="15%">Payment Amt </th>
    <th width="15%">Remarks</th>
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
 
  


   
    $sql = "SELECT id, bill_type, bill_category FROM lc_bill_category WHERE 1 ".$bill_type_con." order  by bill_type,id ";



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){$i++;


  ?>



<? //if ($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no]>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><span class="style13" style="color:#000000; font-weight:700;">
      <?=$data->id;?>
    </span></td>

    <td>
     <?=find_a_field('lc_bill_type','bill_type','id='.$data->bill_type);?>    </td>

    <td><?=$data->bill_category;?></td>
    <td><input name="qty_<?=$data->id?>" id="qty_<?=$data->id?>" type="text" size="10"  value="" style="width:80px;" readonly /></td>
    <td><input name="rate_<?=$data->id?>" id="rate_<?=$data->id?>" type="text" size="10"  value="" style="width:80px;" onkeyup="rateCal(<?=$data->id?>)" /></td>
    <td>
	
	<input name="bill_type_<?=$data->id?>" id="bill_type_<?=$data->id?>" type="hidden" size="10"  value="<?=$data->bill_type;?>" style="width:80px;" />
 <input name="bill_category_<?=$data->id?>" id="bill_category_<?=$data->id?>" type="hidden" size="10"  value="<?=$data->id;?>" style="width:80px;" />
 <input name="payment_amt_<?=$data->id?>" id="payment_amt_<?=$data->id?>" type="text" size="10"  value="" onkeyup="SUMcalculation(<?=$data->id?>)"  style="width:120px; height:25px;"  />	</td>
    <td align="center"><input name="remarks_<?=$data->id?>" id="remarks_<?=$data->id?>" type="text"   value="" style="width:200px; height:25px;"  />	</td>
  </tr>
  <? } //}?>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><div align="right"><strong>Total:</strong></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="total_amt" id="total_amt" type="text" size="10"  value="<?=$total_amt?>" style="width:120px; height:25px;"  />	</td>
    <td align="center">&nbsp;</td>
  </tr>
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