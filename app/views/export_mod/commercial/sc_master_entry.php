<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


//create_combobox('dealer_code');



do_calander('#invoice_date');
do_calander('#expiry_date');
do_calander('#last_shipment_date');

// ::::: Edit This Section ::::: 



$title='Sales Contract';			// Page Name and Page Title

do_datatable('table_head');

$page="sc_master_entry.php";		// PHP File Name



$table='sales_contract_master';		// Database Table Name Mainly related to this page

$unique='sc_no';			// Primary Key of this Database table

$shown='invoice_date';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];

//for Insert..................................

if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

//$now				= time();

$_POST['entry_by'] = $_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d H:i:s');


 $invoice_date=$_POST['invoice_date'];

 $YR = date('Y',strtotime($invoice_date));
  
  $year = date('y',strtotime($invoice_date));
  $month = date('m',strtotime($invoice_date));
  
  
  $sc_id = find_a_field('sales_contract_master','max(sc_id)','year="'.$YR.'"')+1;
  
   $cy_id = sprintf("%06d", $sc_id);

   //$sc_no_generate=$year.''.$month.''.$cy_id;
   
   $sc_no_generate='SC'.$year.''.$month.''.$cy_id;
   
   $ref_no_generate='NPL/'.$year.'/'.$cy_id;

   $_POST['sc_ref_no']=$ref_no_generate;
   $_POST['sc_no_view']=$sc_no_generate;
   $_POST['sc_id']=$sc_id;
   $_POST['year']=$YR;

   $_POST['dealer_group'] = find_a_field('dealer_info','dealer_group','dealer_code="'.$_POST['dealer_code'].'"');
   
   $_POST['invoice_no']= next_transection_no('0',$invoice_date,'sales_contract_master','invoice_no');


$crud->insert();

	
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{


	$_POST['edit_by'] = $_SESSION['user']['id'];
	 
	 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');
	 
	  $_POST['dealer_group'] = find_a_field('dealer_info','dealer_group','dealer_code="'.$_POST['dealer_code'].'"');


	$crud->update($unique);

	

	$type=1;

	$msg='Successfully Updated.';

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

	unset($$unique);

	$type=1;

	$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>

<script type="text/javascript">

$(function() {

	$("#fdate").datepicker({

		changeMonth: true,

		changeYear: true,

		dateFormat: 'yy-mm-dd'

	});

});

function Do_Nav()

{

var URL = 'pop_ledger_selecting_list.php';

popUp(URL);

}




function DoNav(theUrl)

{

document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;

}

function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<style type="text/css">

<!--

.style1 {color: #FF0000}
.style2 {
font-weight: bold;
color: #000000;
font-size: 14px;
}
.style3 {color: #FFFFFF}



/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
color: #454545;
text-decoration: none;
display: none;
}*/


div.form-container_large input {
width: 220px;
height: 37px;
border-radius: 0px !important;
}



-->

</style>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td valign="top" width="60%"><div class="left">

						<table width="100%" border="0" cellspacing="0" cellpadding="0">

															  <tr>

								<td><div class="box"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
						  
						  
						  <tr>
							
							
							

							  <td width="100%" colspan="2"><div class="box style2" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  


								  <tr>

									<th style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B"> <div align="center">
									  <?=$title?>
									</div></th>
								  </tr></table>

							  </div></td>
							</tr>

							<tr>
							
							
							

							  <td width="100%" colspan="2"><div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								 <td width="9%">SC S/L:</td>

									<td width="28%">
									<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
									<input name="sc_no" type="hidden" id="sc_no" tabindex="1" value="<?=$sc_no?>" readonly>
								
								<? if($sc_no_view=="") {?>

								
								<input name="sc_no_test" type="text" id="sc_no_test" style="width:220px;" value="" readonly="" tabindex="105" />

								<? }?>
								
								
								<? if($sc_no_view!="") {?>

								<input name="sc_no_view" type="text" id="sc_no_view" style="width:220px;" value="<?=$sc_no_view?>" readonly="" tabindex="105" />
								<input name="sc_id" type="hidden" id="sc_id" style="width:220px;" value="<?=$sc_id?>" readonly="" tabindex="105" />
								<input name="year" type="hidden" id="year" style="width:220px;" value="<?=$year?>" readonly="" tabindex="105" />
								
								
								<? }?>									</td>
									<td width="14%">Ship Mode:</td>
									<td width="21%">
									
									<input name="hs_code" type="hidden" id="hs_code" readonly="" required style="width:200px; height:30px;" autocomplete="off"  value="4819.10.00" />
									
									<input name="group_for" type="hidden" id="group_for"  style="width:220px; height:30px;" autocomplete="off"   value="<?=$_SESSION['user']['group'];?>" />
									
									<select name="shipment_mode" id="shipment_mode" required style="width:200px; height:30px;">
		 

        <? foreign_relation('shipment_mode','id','shipment_mode',$_POST['shipment_mode'],'1 order by id');?>
    </select>										</td>
									<td width="7%" rowspan="3"><!--Customer Group:-->Tolerance:</td>
									<td width="21%" rowspan="3">
									
									<textarea id="tolerance" name="tolerance"  rows="3"
           style="height:80px; width:200px; background:#FFFFFF; color: #000000;">
2% +/-, IN QUANTITY AND VALUE CAN BE ACCEPTED SUBJECT TO BUYER'S APPROVAL.
ITEM QUANTITY, UNIT PRICE AND TOTAL VALUE CAN BE AMENDMENT AS PER ORDER
SHEET.
</textarea>										</td>
								  </tr>
								  
								  
  
								  <tr>

								 <td> Date:</td>

									<td>

									<? if($invoice_date=="") {?>
									
									<input style="width:220px;"  name="invoice_date" type="text" id="invoice_date" value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"  required />

									<? }?>
									
									<? if($invoice_date!="") {?>

									<input style="width:220px;"  name="invoice_date" type="hidden" id="invoice_date" value="<?=$invoice_date;?>"  required/>
									
									<input style="width:220px;"  name="invoice_date2" type="text" id="invoice_date2" value="<?=$invoice_date;?>" readonly="" required/>
									
									<? }?>								</td>
									<td>Partial Shipment:</td>
									<td>
								
									<select name="partial_shipment" id="partial_shipment"  required style="width:200px; height:30px;">
		 

        <? foreign_relation('allow_type','id','allow_type',$_POST['partial_shipment'],'1 order by id');?>
    </select>																		</td>
								  </tr>
								  <tr>
								    <td>Consignee:</td>
								    <td>
									<table>
		  	<tr>
				<td>
				<span id="find_dealer">
									
									
									<?
				  					$lc_count = find_a_field('lc_receive','count(lc_no)','lc_no="'.$_GET[$unique].'"');
					
									if ($lc_count==0) {
				 					 ?>			
									<select name="dealer_code" id="dealer_code" required style="width:220px;"  onchange="getData2('find_dealer_bank_ajax.php', 'find_dealer_bank', this.value,document.getElementById('dealer_code').value);" >
	
										<option></option>
								
										<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'1 order by dealer_name_e');?>
									</select>
									<? }else {?>
									
									<input name="dealer_code" type="hidden" id="dealer_code"  style="width:220px; " autocomplete="off"  readonly="" value="<?=$dealer_code?>"/>	
									<input name="dealer_name" type="text" id="dealer_name"  style="width:220px; " autocomplete="off"  readonly=""
									 value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code="'.$dealer_code.'"')?>"/>	
									
									<? }?>
									</span>								</td>
				</tr>
		  </table>									</td>
								    <td>Trans Shipment:</td>
								    <td><select name="trans_shipment" id="trans_shipment"  required style="width:200px; height:30px;">
		 

        <? foreign_relation('allow_type','id','allow_type',$trans_shipment,'1 order by id');?>
    </select></td>
							      </tr>
								  <tr>
								    <td>Buyer's Bank:</td>
								    <td>
									<? if ($lc_count==0) {?>
									<span id="find_dealer_bank">
									<select name="bank_buyers" id="bank_buyers" required style="width:220px;">
	
										<option></option>
								
										<? foreign_relation('bank_buyers','bank_id','bank_name',$bank_buyers,'dealer_code="'.$dealer_code.'" order by bank_id');?>
									</select>
									</span>	
									<? }else {?>	
									
									<select name="bank_buyers" id="bank_buyers" required style="width:220px;">
	
										<option></option>
																	
										<? foreign_relation('bank_buyers','bank_id','bank_name',$bank_buyers,'dealer_code="'.$dealer_code.'" order by bank_id');?>
									</select>	
																		
									
									<? }?>									</td>
								    <td>Mode of Shipment:</td>
								    <td>
									<input name="mode_of_shipment" type="text" id="mode_of_shipment"  required style="width:200px; height:30px;" autocomplete="off"  value="BY ROAD" />									</td>
								    <td rowspan="3">Terms Of Payment:</td>
								    <td rowspan="3">
									
									<textarea id="payment_terms" name="payment_terms"  rows="3"
            style="height:80px; width:200px; background:#FFFFFF; color: #000000;">
FDD/TT (DRAWN ON BANGLADESH BANK), 30 DAYS FROM THE DATE OF DELIVERY
CHALLAN IN FAVOUR OF NATIVE PACKAGES LTD.
</textarea>									</td>
								  </tr>
								  <tr>
								    <td> Seller's Bank:</td>
								    <td>
									
									<select name="bank_sellers" id="bank_sellers" required style="width:220px;">
	
										<option></option>
								
										<? foreign_relation('bank_sellers','bank_id','bank_name',$bank_sellers,'1 order by bank_id');?>
									</select>									</td>
								    <td>Last Shipment Date:</td>
								    <td><input name="last_shipment_date" type="text" id="last_shipment_date"  required style="width:200px; height:30px;" autocomplete="off"  value="<?=$_POST['last_shipment_date']?>" /></td>
							      </tr>
								  <tr>
								    <td>LC No: </td>
								    <td><input name="export_lc_no" type="text" id="export_lc_no"  style="width:220px; height:30px;" autocomplete="off"   value="<?=$export_lc_no;?>" /></td>
								    <td>Description:</td>
								    <td><input name="discription_goods" type="text" id="discription_goods"  required style="width:200px; height:30px;" autocomplete="off" 
		   value="CARTON, TOP BOTTOM" /></td>
							      </tr>
								  <tr>
								    <td>Expiry Date: </td>
								    <td><input name="expiry_date" type="text" id="expiry_date"  required style="width:220px; height:30px;" autocomplete="off"  
		  value="<?=$expiry_date;?>" /></td>
								    <td>Trade Terms:</td>
								    <td>
									 <input name="trade_terms" type="text" id="trade_terms"  required style="width:200px; height:30px;" autocomplete="off"  value="CPT, APPLICANT'S FACTORY"   />
								    </td>
								    <td>&nbsp;</td>
								    <td>&nbsp;</td>
							      </tr>
								</table>

							  </div></td>
							</tr>

							

							<tr>

							  <td colspan="2">&nbsp;</td>
							</tr>

							<tr>

							  <td colspan="2">

							  <div class="box1">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
			  <td><div class="button">
				  <? if(!isset($_GET[$unique])){?>
				  <center><input name="insert" type="submit" id="insert" value="SAVE" class="btn" /></center>
				  <? }?>
				</div></td>
			  <td><div class="button">
				  <? if(isset($_GET[$unique])){?>
				  
				  <center><input name="update" type="submit" id="update" value="UPDATE" class="btn" /></center>
				  <? }?>
				</div></td>
			  <td><div class="button">
				 <center> <input name="reset" type="button" class="btn" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" /></center>
				</div></td>
			  
			</tr>
								</table>
							  </div>								  </td>
							</tr>
						  </table>

</form></div></td>
						  </tr>

							   <tr>

								<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="table_head" class="table table-bordered" width="100%" cellspacing="0">
<thead>
<tr>
<th width="6%" bgcolor="#45777B"><span class="style3">SC No </span></th>

<th width="8%" bgcolor="#45777B"><span class="style3">Date</span></th>
<th width="13%" bgcolor="#45777B"><span class="style3">Expiry Date</span></th>
<th width="19%" bgcolor="#45777B"><span class="style3">Customer Group</span></th>
<th width="29%" bgcolor="#45777B"><span class="style3">Customer Name</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['warehouse_name']!="")

$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';





 $td='select a.'.$unique.',  a.'.$shown.',  a.sc_no_view,  a.dealer_group, a.dealer_code, a.invoice_date, a.export_lc_no, a.expiry_date from '.$table.' a	where 1 order by a.sc_no  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
<td><?=$rp[2];?></td>

<td><?php echo date('d-m-Y',strtotime($rp[5]));?></td>
<td><?php echo date('d-m-Y',strtotime($rp[7]));?></td>
<td><?=find_a_field('dealer_group','dealer_group','id='.$rp[3]);?></td>
<td><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$rp[4]);?></td>
</tr>

<?php }?>
</tbody>
</table>

<? //}?>

								<div id="pageNavPosition"></div>									</td>

							  </tr>
	</table>



</div></td>
</tr>
</table>

<script type="text/javascript"><!--

var pager = new Pager('grp', 10000);

pager.init();

pager.showPageNav('pager', 'pageNavPosition');

pager.showPage(1);

//-->

document.onkeypress=function(e){

var e=window.event || e

var keyunicode=e.charCode || e.keyCode

if (keyunicode==13)

{

	return false;

}

}

</script>




<script>


function duplicate(){

var dealer_code_2 = ((document.getElementById('dealer_code_2').value)*1);

var customer_id = ((document.getElementById('customer_id').value)*1);



if(dealer_code_2>0)
{

alert('This customer code already exists.');
document.getElementById('customer_id').value='';


document.getElementById('customer_id').focus();

} 



}

</script>

<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>