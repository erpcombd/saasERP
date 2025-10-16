<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


//create_combobox('dealer_code');

do_calander('#lc_date');
do_calander('#contact_date');
do_calander('#export_lc_date');
do_calander('#expiry_date');
do_calander('#exp_date');
do_calander('#amd_date');

do_calander('#latest_date_of_shipment');
// ::::: Edit This Section ::::: 



$title='LC Entry';			// Page Name and Page Title

do_datatable('table_head');

$page="lc_entry.php";		// PHP File Name



$table='lc_master';		// Database Table Name Mainly related to this page

$unique='lc_no';			// Primary Key of this Database table

$shown='export_lc_no';				// For a New or Edit Data a must have data field



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


 $lc_date=$_POST['lc_date'];

 $YR = date('Y',strtotime($lc_date));
  
  $year = date('y',strtotime($lc_date));
  $month = date('m',strtotime($lc_date));
  
  
  $lc_id = find_a_field('lc_master','max(lc_id)','year="'.$YR.'"')+1;
  
   $cy_id = sprintf("%06d", $lc_id);
   
   //$pi_code = find_a_field('pi_type','code','id="'.$_POST['pi_type'].'"');

   $lc_no_generate=$year.''.$month.''.$cy_id;

   
   $_POST['lc_no_view']=$lc_no_generate;
   $_POST['lc_id']=$lc_id;
   $_POST['year']=$YR;

   $_POST['dealer_group'] = find_a_field('dealer_info','dealer_group','dealer_code="'.$_POST['dealer_code'].'"');


$crud->insert();

	$id = $_POST['dealer_code'];
	
	if($_FILES['cr_upload']['tmp_name']!=''){ 
	$file_temp = $_FILES['cr_upload']['tmp_name'];
	$folder = "../../images/cr_pic/";
	move_uploaded_file($file_temp, $folder.$id.'.jpg');}


	
	if($_FILES['pp']['tmp_name']!=''){ 
	$file_temp = $_FILES['pp']['tmp_name'];
	$folder = "../../pp_pic/pp/";
	move_uploaded_file($file_temp, $folder.$id.'.jpg');}
	
	if($_FILES['np']['tmp_name']!=''){ 
	$file_temp = $_FILES['np']['tmp_name'];
	$folder = "../../np_pic/np/";
	move_uploaded_file($file_temp, $folder.$id.'.jpg');}
	
	if($_FILES['spp']['tmp_name']!=''){ 
	$file_temp = $_FILES['spp']['tmp_name'];
	$folder = "../../spp_pic/spp/";
	move_uploaded_file($file_temp, $folder.$id.'.jpg');}
	
	if($_FILES['nsp']['tmp_name']!=''){ 
	$file_temp = $_FILES['nsp']['tmp_name'];
	$folder = "../../nsp_pic/nsp/";
	move_uploaded_file($file_temp, $folder.$id.'.jpg');}
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

	$id = $_POST['dealer_code'];



	if($_FILES['cr_upload']['tmp_name']!=''){ 
	$file_temp = $_FILES['cr_upload']['tmp_name'];
	$folder = "../../images/cr_pic/";
	move_uploaded_file($file_temp, $folder.$id.'.jpg');}


	if($_FILES['pp']['tmp_name']!=''){ 
	$file_temp = $_FILES['pp']['tmp_name'];
	$folder = "../../pp_pic/pp/";
	move_uploaded_file($file_temp, $folder.$id.'.jpg');}
	
	if($_FILES['np']['tmp_name']!=''){ 
	$file_temp = $_FILES['np']['tmp_name'];
	$folder = "../../np_pic/np/";
	move_uploaded_file($file_temp, $folder.$id.'.jpg');}
	
	if($_FILES['spp']['tmp_name']!=''){ 
	$file_temp = $_FILES['spp']['tmp_name'];
	$folder = "../../spp_pic/spp/";
	move_uploaded_file($file_temp, $folder.$id.'.jpg');}
	
	if($_FILES['nsp']['tmp_name']!=''){ 
	$file_temp = $_FILES['nsp']['tmp_name'];
	$folder = "../../nsp_pic/nsp/";
	move_uploaded_file($file_temp, $folder.$id.'.jpg');}

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
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
<style type="text/css">

<!--

.style1 {color: #FF0000}
.style2 {
font-weight: bold;
color: #000000;
font-size: 11px!important;
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


td{
font-size:12px;
}

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

								 <td width="12%">LC S/L:</td>

									<td width="20%">
									<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
									<input name="lc_no" type="hidden" id="lc_no" tabindex="1" value="<?=$lc_no?>" readonly>
								
								<? if($lc_no_view=="") {?>

								
								<input name="pi_no_test" type="text" id="pi_no_test" style="width:220px;" value="" readonly="" tabindex="105" />

								<? }?>
								
								
								<? if($lc_no_view!="") {?>

								<input name="lc_no_view" type="text" id="lc_no_view" style="width:220px;" value="<?=$lc_no_view?>" readonly="" tabindex="105" />
								<input name="lc_id" type="hidden" id="lc_id" style="width:220px;" value="<?=$lc_id?>" readonly="" tabindex="105" />
								<input name="year" type="hidden" id="year" style="width:220px;" value="<?=$year?>" readonly="" tabindex="105" />
								
								
								<? }?>									</td>
									<td width="12%">LC No:</td>
									<td width="20%">
									
									<input name="export_lc_no" type="text" id="export_lc_no" style="width:220px;" value="<?=$export_lc_no?>" required tabindex="105" />										</td>
									<td width="12%"><!--Customer Group:-->
								    Seller's Bank</td>
									<td width="20%">
									<?php /*?><select name="dealer_group" id="dealer_group" required style="width:220px;" onchange="getData2('find_dealer_ajax.php', 'find_dealer', this.value,document.getElementById('dealer_group').value);" >
	
										<option></option>
								
										<? foreign_relation('dealer_group','id','dealer_group',$dealer_group,'1 order by id');?>
									</select><?php */?>
									<select name="bank_sellers" id="bank_sellers" required style="width:220px;">
	
										<option></option>
								
										<? foreign_relation('bank_sellers','bank_id','bank_name',$bank_sellers,'1 order by bank_id');?>
									</select>									</td>
								  </tr>
								  
								  
  
								  <tr>

								 <td> Date:</td>

									<td>

									<? if($lc_date=="") {?>
									
									<input style="width:220px;"  name="lc_date" type="text" id="lc_date" value="<?=($lc_date!='')?$lc_date:date('Y-m-d')?>"  required />

									<? }?>
									
									<? if($lc_date!="") {?>

									<input style="width:220px;"  name="lc_date" type="hidden" id="lc_date" value="<?=$lc_date;?>"  required/>
									
									<input style="width:220px;"  name="pi_date2" type="text" id="pi_date2" value="<?=$lc_date;?>" readonly="" required/>
									
									<? }?>								</td>
									<td>LC Date:</td>
<td><input style="width:220px;"  name="export_lc_date" type="text" id="export_lc_date" value="<?=($export_lc_date!='')?$export_lc_date:date('Y-m-d')?>"  required /></td>



									<td>Customer Name:</td>
									<td><span id="find_dealer">
									
									
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
									
									
									
									</span>										</td>
								  </tr>
								  
						
						 
								  <tr>
								    <td>Tolerance:</td>
								    <td>
									<table>
		  	<tr>
				<td><input name="tolerance" type="text" id="tolerance"  style="width:100px; " autocomplete="off"  value="<?=$tolerance?>"/>				</td>
				<td>&nbsp;&nbsp; %(+/-)</td>
			</tr>
		  </table>									</td>
			  <td>Amendment No:</td>
								  <td><input style="width:220px;"  name="amd_no" type="text" id="amd_no" value="<?=$amd_no?>"   /></td>
								    <td>Customer Bank:</td>
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
																		
									
									<? }?>						</td>
							      </tr>
								  <tr>
								    <td>Applicant's IRC No</td>
								    <td><input name="importer_irc_no" type="text" id="importer_irc_no" style="width:220px;" value="<?=$importer_irc_no?>"  tabindex="105" /></td>
									
								    <td>Amendment Date:</td>
								  <td><input style="width:220px;"  name="amd_date" type="text" id="amd_date" value="<?=$amd_date?>" autocomplete="off"   /></td>
								    <td>Contact No:</td>
								    <td><input name="contact_no" type="text" id="contact_no" style="width:220px;" value="<?=$contact_no?>"  tabindex="105" /></td>
							      </tr>
								  <tr>
								     <td>Applicant's ERC No</td>
								    <td><input name="appplicant_erc_no" type="text" id="appplicant_erc_no" style="width:220px;" value="<?=$appplicant_erc_no?>"  tabindex="105" /></td>
								    <td>Issuing Bank BIN No</td>
								    <td><input name="issuing_bank_bin_no" type="text" id="issuing_bank_bin_no" style="width:220px;" value="<?=$issuing_bank_bin_no?>"  tabindex="105" /></td>
								    <td>Contact Date: </td>
								    <td><input name="contact_date" type="text" id="contact_date" style="width:220px;" value="<?=$contact_date?>"  tabindex="105" /></td>
							      </tr>
								  <tr>
								  <td>Applicant's TIN No</td>
								    <td><input name="applicants_tin_no" type="text" id="applicants_tin_no" style="width:220px;" value="<?=$applicants_tin_no?>"  tabindex="105" /></td>
							  					    <td>Expiry Date:</td>
								    <td><input style="width:220px;"  name="expiry_date" type="text" id="expiry_date" value="<?=($expiry_date!='')?$expiry_date:date('Y-m-d')?>"  required /></td>
									 <!--<td>Exp No</td>
								    <td><input name="exp_no" type="text" id="exp_no" style="width:220px;" value="<?=$exp_no?>"  tabindex="105" /></td>-->
								    <td>Remarks</td>
								    <td><input name="remarks" type="text" id="remarks" style="width:220px;" value="<?=$remarks?>"  tabindex="105" /></td>
							      </tr>
								  <tr>
								      <td>Applicant's BIN No</td>
								    <td><input name="applicants_bin_no" type="text" id="applicants_bin_no" style="width:220px;" value="<?=$applicants_bin_no?>"  tabindex="105" /></td>
	
								    <td>Tenor</td>
								    <td>
									<select name="tenor_days" id="tenor_days" required style="width:220px;">
	
										<option></option>
								
										 <? foreign_relation('tenor_days','tenor_days','tenor_type',$tenor_days,'1 order by id');?>
									</select>									</td>
								    <td>LC Value</td>
								    <td><input name="lc_value" type="text" id="lc_value" style="width:220px;" value="<?=$lc_value?>"  tabindex="105" /></td>
							      </tr>
								  
								  <tr>
								    <td>Partial Shipments</td>
								    <td><input name="partial_shipment" type="text" id="partial_shipment" style="width:220px;" value="<?=$partial_shipment?>"  tabindex="105" /></td>
								    <td>Trans Shipment<br /></td>
								    <td><input name="trans_shipment" type="text" id="trans_shipment" style="width:220px;" value="<?=$trans_shipment?>"  tabindex="105" /></td>
								    <td>Latest Date of Shipment</td>
								    <td><input name="latest_date_of_shipment" type="text" id="latest_date_of_shipment" style="width:220px;" value="<?=$latest_date_of_shipment?>"  tabindex="105" /></td>
							      </tr>
								  <tr>	
						 		  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  
								  <? if($_REQUEST['lc_no']!=''){?>
 <td style="text-align:right" colspan="2"><a href="lc_export_contact.php?lc_no=<?=$_REQUEST['lc_no']?>" " class="btn btn-primary">Export Sales Contract <i class="fa-solid fa-plus-large"></i></a></td>
 
 <? }else{?>
 <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <? }?>
								  
						</tr>
								  <tr></
								  
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
<th width="4%" bgcolor="#45777B"><span class="style3">S/L</span></th>

<th width="10%" bgcolor="#45777B"><span class="style3">Date</span></th>
<th width="14%" bgcolor="#45777B"><span class="style3"> LC No </span></th>

<th width="11%" bgcolor="#45777B"><span class="style3">LC Date</span></th>
<th width="13%" bgcolor="#45777B"><span class="style3">Expiry Date</span></th>
<th width="29%" bgcolor="#45777B"><span class="style3">Customer Name</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['warehouse_name']!="")

$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';





 $td='select a.'.$unique.',  a.'.$shown.',  a.lc_no_view,  a.dealer_group, a.dealer_code, a.lc_date, a.export_lc_date, a.expiry_date from '.$table.' a	where 1 order by a.lc_no  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
<td><?=$rp[2];?></td>

<td><?php echo date('d-m-Y',strtotime($rp[5]));?></td>
<td><?=$rp[1];?></td>

<td><?php echo date('d-m-Y',strtotime($rp[6]));?></td>
<td><?php echo date('d-m-Y',strtotime($rp[7]));?></td>
<td><?=find_a_field('lc_buyer','buyer_name','id='.$rp[4]);?></td>
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