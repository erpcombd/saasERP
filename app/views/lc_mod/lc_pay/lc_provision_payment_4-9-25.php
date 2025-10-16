<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='L/C Provision Entry';


 // create_combobox('do_no');
  
// create_combobox('lc_no');
  
  

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


			
		$payment_method=$_POST['payment_method'];
		$group_for=$_POST['group_for'];
		$lc_no=$_POST['lc_no'];
		$payment_date = find_a_field('lc_purchase_master','po_date','lc_no='.$lc_no);
		
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
  





		$tr_unique=77;

		$payment_no = next_transection_no($tr_unique,$payment_date,'lc_provision_payment','payment_no');
		
		
		
		
		
		
		$item_sql=" select d.id as order_no,i.item_name,d.qty,m.po_date from lc_purchase_master m, lc_purchase_invoice d, item_info i where m.po_no=d.po_no and d.item_id=i.item_id and m.lc_no= ".$lc_no."";
		
		$item_query = db_query($item_sql);
		
		while($item_data=mysqli_fetch_object($item_query)){
		
		
		

		$sql = "SELECT id, bill_type, bill_category as category_view FROM lc_bill_category WHERE 1 ".$bill_type_con." order  by bill_type,id";

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{
			if($_POST['payment_amt_'.$data->id.'_'.$item_data->order_no]>0)

			{
				$rate = $_POST['payment_amt_'.$data->id.'_'.$item_data->order_no] / $item_data->qty ;
				$qty = $item_data->qty;
				
				$payment_amt=$_POST['payment_amt_'.$data->id.'_'.$item_data->order_no];
				$bill_type=$data->bill_type;
				$bill_category=$data->id;
				
				
				
				

   $ins_invoice = 'INSERT INTO lc_provision_payment (payment_no, payment_date, payment_method, lc_no, lc_number, lc_ledger, bank_pay_id, lc_part, lc_part_no, group_for, bill_type, bill_category, category_view, cr_ledger_id,order_no,rate,qty,pay_amt_in, pay_amt_out, remarks, note, r_no, r_date, status, entry_by, entry_at, boe_no, boe_date)
  
  VALUES("'.$payment_no.'", "'.$item_data->po_date.'", "'.$payment_method.'", "'.$lc_no.'", "'.$lc_number.'", "'.$ledger_id.'", "'.$lc_part.'", "'.$lc_part_view.'", "'.$lc_no_part.'", "'.$group_for.'",  "'.$bill_type.'", "'.$bill_category.'", "'.$data->category_view.'", "'.$cr_ledger_id.'","'.$item_data->order_no.'","'.$rate.'","'.$qty.'","'.$payment_amt.'", "0", "'.$remarks.'", "'.$note.'", "'.$r_no.'", "'.$r_date.'", "CHECKED", "'.$entry_by.'", "'.$entry_at.'", "'.$boe_no.'", "'.$boe_date.'")';

db_query($ins_invoice);


}

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


function itemQty(id) {
    var rate = id;
    var po_no = document.getElementById('po_no').value * 1;
	
	var bill_type =document.getElementById('bill_type').value * 1;
	
	
	
	if(bill_type!=8){
	var percentage = document.getElementById('rate_percentage').value * 1;
		if(percentage>0){
		percentage = ( percentage / 100);
		}else{
			percentage=1;
		}
	}else {
		
	percentage = 1;
	}
	
	
	if(bill_type==3){
	var global_tax =document.getElementById('global_tax').value * 1;
	
	global_tax = (global_tax /100);
	}
	var sum = 0;
	var total=0;
	
	
    $.ajax({
        url: "itemAmountAjax.php",
        type: "post",
        dataType: 'json',
        data: { rate: rate, po_no: po_no ,bill_type : bill_type },
        success: function (data) {
            // Check if data is an array (it should be)
            if (Array.isArray(data)) {
                data.forEach(function (item, index) {
				
				let amount =item.amount;
				
				
				
				let assessable_value =(amount*(1.02+percentage )); 
				
				let total_duty = assessable_value * item.tti;
				
				let global = assessable_value * global_tax;
				
				
				let cd = assessable_value * (item.cd /100);
				let rd = (assessable_value) * (item.rd /100);
				let sd = (assessable_value+cd+rd)*(item.sd / 100);
				
				let total_app_duty =(cd+rd+sd);
				
				let app_tti = (total_app_duty/assessable_value) *100;
				
				let app_tti_g_t = total_app_duty + global;
					
					$("#tot_duty_g_t" + item.id).val(total_duty + global);
					
					$("#tot_applicable_tti" + item.id).val(total_app_duty);
					
					$("#applicable_tti" + item.id).val(app_tti);
                    
                    $("#amount_" + item.id).val(item.amount);
					
					$("#assessable_" + item.id).val(assessable_value);
					
					$("#total_duty_" + item.id).val(total_duty);
					
					$("#global_" + item.id).val(global);
					
					
					
					if(bill_type==3){
					$("#payment_amt_"+item.cat +"_"+item.id).val(app_tti_g_t);
					
					 	total = app_tti_g_t;
						
					}else{
						$("#payment_amt_" + item.cat +"_"+item.id).val(item.amount*percentage);
						 total = item.amount*percentage;
					}
					
					console.log(total);
					sum +=total;
					
					
					
					$("#total_amt").val(sum);
					
					
					
                });
            } else {
                // Handle the case where data is not an array (an error occurred)
                console.error("Received unexpected data format from the server.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle AJAX errors here
            console.error("AJAX Request Error:", textStatus, errorThrown);
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

		foreign_relation('lc_number_setup','id','lc_number',$_POST['lc_no'],'1 ');
	//foreign_relation('lc_bank_entry','lc_no','bank_lc_no',$_POST['lc_no'],'1');
	
	//foreign_relation('lc_pi_reference_setup','id','pi_number',$_POST['lc_no'],'1');

?>
    </select></td>
	
	
	 <td align="right" ><strong>Payment Type: </strong></td>



    <td ><select name="bill_type" id="bill_type" style="width:220px;" required>
      <option></option>
      <?

foreign_relation('lc_bill_type','id','bill_type',$_POST['bill_type'],'1 order by ordering');

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

								 <!--<td >PAYMENT DATE:</td>

									<td >
									
									<?php /*?><?=($invoice_date!='')?$invoice_date:date('Y-m-d')?><?php */?>
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=$_POST['invoice_date']?>"   required />									</td>-->
									<td  align="right">L/C  NO  :</td>
									<td >
									
									<?
									 $lc_data = find_all_field('lc_number_setup','','id='.$_POST['lc_no']);
									 
									 
										 $master_data = find_all_field('lc_purchase_master','','lc_no='.$_POST['lc_no']);
									 
						
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
									<td align="right">INSURANCE COMPANY:</td>
									<td>
								
									
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('insurance_company','ledger_id','company_name',$_POST['cr_ledger_id'],'1');?>
									</select>
									
									</td>
									
				
								  </tr>
								  	
								  <? } elseif($_POST['bill_type']==2){ ?>
								  
								  <td align="right">BANK:</td>
									<td>
								
									
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$bank_ledger,'ledger_group_id in (126002)');?>
									</select>
									
									</td>
								  
								  <? } elseif($_POST['bill_type']==3){ ?>
								  
								  <td align="right">Vendor:</td>
									<td>
								
									
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$bank_ledger,'ledger_group_id in (126002)');?>
									</select>
									
									</td>
									
									<td align="right">Global Tax Percentage ( % ):</td>
										<td><input type="text" name="global_tax" id="global_tax"  /></td>
								  
								  <? }  elseif($_POST['bill_type']==4){ ?>
								  
								  <td align="right">C&amp;F COMPANY:</td>

									<td>
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('cnf_company','ledger_id','company_name',$_POST['cr_ledger_id'],'1');?>
									</select>
									</td>
								  <? }  elseif($_POST['bill_type']==8){ ?>
								  
								  <td align="right">Supplier:</td>

									<td>
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  
									  <? foreign_relation('vendor_foreign','ledger_id','vendor_name',$_POST['cr_ledger_id'],'1 and vendor_id='.$master_data->vendor_id.'');?>
									</select>
									</td>
								  <? }  else{ ?>
								  
								  <td align="right">C&amp;F COMPANY:</td>

									<td>
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('cnf_company','ledger_id','company_name',$_POST['cr_ledger_id'],'1');?>
									</select>
									</td>
								  <? } ?>
								  
								  
								  <tr>
								  <? if($_POST['bill_type']!=8) { ?>
								  <td align="right"><?=($_POST['bill_type']==3) ? 'Load' : 'Rate' ?> Percentage ( % ):</td>
										<td><input type="text" name="rate_percentage" id="rate_percentage"  /></td>
										
									<? } ?>
								  		<td align="right">Exchange Rate :</td>
										<td><select onchange="itemQty(this.value)" >
												<option></option>
												<option value="<?=$master_data->exchange_rate_ex;?>">Exchange Rate Expected - <?=$master_data->exchange_rate_ex;?> </option>
												<? if($_POST['bill_type']!=8){ ?>
												<option value="<?=$master_data->exchange_rate_cur;?>">Exchange Rate Current - <?=$master_data->exchange_rate_cur;?></option>
												<option value="<?=$master_data->exchange_rate_duty;?>">Exchange Rate Duty - <?=$master_data->exchange_rate_duty;?></option>
												<? } ?>
										</select></td>
										
										
								  
								  </tr>
								  
								</table>

    </div>
	
	<? }?>



<? if(isset($_POST['submit'])){ 



 $bill_cat_sql = "select * from lc_bill_category where bill_type=".$_POST['bill_type']." and ledger_id=0";
$query  = db_query($bill_cat_sql);
$c=0;
while($data= mysqli_fetch_object($query)){
	$c++;
	$cat_name[$c] =$data->bill_category;
	$cat_id[$c] =$data->id; 

}




?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>
  <th rowspan="2">Item Id</th>
    <th rowspan="2" >Item Name </th>
    <th rowspan="2" >Qty</th>
	<th rowspan="2">Amount</th>
	<? if($_POST['bill_type']==3){ ?>
		<th rowspan="2">HS CODE</th>
		<th rowspan="2">Assessable Value</th>
		<th rowspan="2">Global Tax</th>
		<th rowspan="2">TTI (%)</th>
		
		<th rowspan="2">Total Duty</th>
		
		
		<th rowspan="2"> Total Duty With Global Tax</th>
		
		<th rowspan="2">Applicable Duty (%)</th>
		
		<th rowspan="2"> Total Applicable Duty</th>
		
		
		
	
	<? } ?>
    <th colspan="<?=$c?>">Type</th>
  
  </tr>

  <tr>
  
  <? for($j=1;$j<=$c;$j++){ ?>
  	<th><?=$cat_name[$j];?></th>
	
	<?  } ?>
	
	
  </tr>

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
  if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
  if($_POST['bill_type']!='')
  $bill_type_con=" and bill_type=".$_POST['bill_type']; 
 // $sql = "SELECT id, bill_type, bill_category FROM lc_bill_category WHERE 1 ".$bill_type_con." order  by bill_type,id ";
  
  
  $sql=" select d.id as order_no,i.item_name,d.qty,i.item_id,d.amount_usd,m.po_no,d.hs_code,h.tti,h.cd,h.rd,h.sd from lc_purchase_master m, lc_purchase_invoice d, item_info i,hs_code h where m.po_no=d.po_no and d.item_id=i.item_id and d.hs_code=h.hs_code and m.lc_no= ".$lc_data->id."";
  
  
  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){$i++;
  ?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    
		<td><?=$data->item_id;?></td>
    <td>
     <?=$data->item_name;?> </td>

    <td><input name="qty" id="qty" type="text" size="10"  value="<?=$data->qty;?>" style="width:80px;" readonly /></td>
	
	
	<td>
	<input name="amount_usd_<?=$data->order_no?>" id="amount_usd" type="text" size="10"  value="<?=$data->amount_usd;?>" />
	<input name="po_no" id="po_no" type="hidden" size="10"  value="<?=$data->po_no;?>" />
	<input name="amount_<?=$data->order_no?>" id="amount_<?=$data->order_no?>" type="text"  value="" style="width:80px;" readonly />
	
	</td>	
	
	<? if($_POST['bill_type']==3){ ?>
		<td><?=$data->hs_code;?></td>
		<td><input name="assessable_<?=$data->order_no?>" id="assessable_<?=$data->order_no?>" type="text"  value="" style="width:80px;" readonly /> </td>
		<td><input name="global_<?=$data->order_no?>" id="global_<?=$data->order_no?>" type="text"  value="" style="width:80px;" readonly /></td>
		<td><input name="tti_<?=$data->order_no?>" id="tti_<?=$data->order_no?>" type="text"  value="<?=$data->tti?>" style="width:80px;" readonly /></td>
		<td><input name="total_duty_<?=$data->order_no?>" id="total_duty_<?=$data->order_no?>" type="text"  value="" style="width:80px;" readonly /></td>
		<td><input name="tot_duty_g_t<?=$data->order_no?>" id="tot_duty_g_t<?=$data->order_no?>" type="text"  value="" style="width:80px;" readonly /></td>
		<td><input name="applicable_tti<?=$data->order_no?>" id="applicable_tti<?=$data->order_no?>" type="text"  value="<?='CD-'.$data->cd." RD-".$data->rd." SD-".$data->sd;?>" style="width:80px;" readonly /></td>
		
		<td><input name="tot_applicable_tti<?=$data->order_no?>" id="tot_applicable_tti<?=$data->order_no?>" type="text"  value="" style="width:80px;" readonly /></td>
		
		
		
		
	
	<? } ?>
	
	
	
	
	<? for($k=1;$k<=$c;$k++){ ?>
	
    <td>
	<input name="amt_<?=$cat_id[$k]."_".$data->order_no;?>" id="amt_<?=$cat_id[$k]."_".$data->order_no;?>" type="hidden"  value="" style="width:80px;" />
	
	<input name="payment_amt_<?=$cat_id[$k]."_".$data->order_no;?>" id="payment_amt_<?=$cat_id[$k]."_".$data->order_no;?>" type="text"  value="" style="width:80px;" /></td>
	<? } ?>
	
	
    <?php /*?><td>
	
	<input name="bill_type_<?=$data->id?>" id="bill_type_<?=$data->id?>" type="hidden" size="10"  value="<?=$data->bill_type;?>" style="width:80px;" />
 <input name="bill_category_<?=$data->id?>" id="bill_category_<?=$data->id?>" type="hidden" size="10"  value="<?=$data->id;?>" style="width:80px;" />
 <input name="payment_amt_<?=$data->id?>" id="payment_amt_<?=$data->id?>" type="text" size="10"  value="" onkeyup="SUMcalculation(<?=$data->id?>)"  style="width:120px; height:25px;"  />	</td><?php */?>
    
  </tr>
  <? } //}?>
  
  <tr>

    <td colspan="<?=($_POST['bill_type']==3) ? '12' : '4' ?>" align="center"><div align="right"><strong>Total:</strong></div></td>

    <td colspan="<?=$c?>"><input name="total_amt" id="total_amt" type="text" size="10"   style="width:120px; height:25px;"  />	</td>
    
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