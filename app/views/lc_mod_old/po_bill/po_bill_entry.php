<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


//create_combobox('dealer_code');

do_calander('#bill_date');


// ::::: Edit This Section ::::: 



$title='PO Bill Entry';			// Page Name and Page Title

do_datatable('table_head');

$page="po_bill_entry.php";		// PHP File Name



$table='po_bill_master';		// Database Table Name Mainly related to this page

$unique='bill_id';			// Primary Key of this Database table

$shown='bill_date';				// For a New or Edit Data a must have data field



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


 $bill_date=$_POST['bill_date'];

 $YR = date('Y',strtotime($bill_date));
  
  $year = date('y',strtotime($bill_date));
  $month = date('m',strtotime($bill_date));
  
  
   $bill_sl = find_a_field('po_bill_master','max(bill_sl)','year="'.$YR.'"')+1;
  
   $cy_id = sprintf("%06d", $bill_sl);
   
   //$pi_code = find_a_field('pi_type','code','id="'.$_POST['pi_type'].'"');

   $bill_no_generate=$year.''.$month.''.$cy_id;
   
    $order_bill_no = $$unique;
   
   
   $_POST['bill_no']=$bill_no_generate;
   $_POST['bill_sl']=$cy_id;
   $_POST['year']=$YR;



$crud->insert();

	
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}

?>


<script language="javascript">
window.location.href = "po_bill_update.php?bill_id=<?=$order_bill_no;?>";
</script>

<?



//for Modify..................................



if(isset($_POST['update']))

{


	$_POST['edit_by'] = $_SESSION['user']['id'];
	 
	 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');


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

								 <td width="12%">Bill No:</td>

									<td width="20%">
									<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
									<input name="bill_id" type="hidden" id="bill_id" tabindex="1" value="<?=$bill_id?>" readonly>
								
								<? if($bill_no=="") {?>

								
								<input name="bill_no_test" type="text" id="bill_no_test" style="width:220px;" value="" readonly="" tabindex="105" />

								<? }?>
								
								
								<? if($bill_no!="") {?>

								<input name="bill_no" type="text" id="bill_no" style="width:220px;" value="<?=$bill_no?>" readonly="" tabindex="105" />
								<input name="bill_sl" type="hidden" id="bill_sl" style="width:220px;" value="<?=$bill_sl?>" readonly="" tabindex="105" />
								<input name="year" type="hidden" id="year" style="width:220px;" value="<?=$year?>" readonly="" tabindex="105" />
								
								
								<? }?>									</td>
									<td width="12%">Purchase Manager:</td>
									<td width="20%">
									
									<select name="purchase_manager" id="purchase_manager" required style="width:220px;"  >
	
										<option></option>
								
										<? foreign_relation('purchase_manager','id','purchase_manager',$purchase_manager,'1 order by id');?>
									</select>										</td>
								  </tr>
								  
								  
  
								  <tr>

								 <td> Bill Date:</td>

									<td>

									<? if($bill_date=="") {?>
									
									<input style="width:220px;"  name="bill_date" type="text" id="bill_date" value="<?=($bill_date!='')?$bill_date:date('Y-m-d')?>"  required />

									<? }?>
									
									<? if($bill_date!="") {?>

									<input style="width:220px;"  name="bill_date" type="hidden" id="bill_date" value="<?=$bill_date;?>"  required/>
									
									<input style="width:220px;"  name="bill_date2" type="text" id="bill_date2" value="<?=$bill_date;?>" readonly="" required/>
									
									<? }?>								</td>
									<td>Remarks:</td>
									<td>
									
									<input name="remarks" type="text" id="remarks" tabindex="1" value="<?=$remarks?>"  style="width:220px;" />																			</td>
								  </tr></table>

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
<th width="5%" bgcolor="#45777B"><span class="style3">ID</span></th>

<th width="14%" bgcolor="#45777B"><span class="style3">Bill No </span></th>

<th width="16%" bgcolor="#45777B"><span class="style3">Bill Date</span></th>
<th width="17%" bgcolor="#45777B"><span class="style3">Purchase Manager</span></th>
<th width="29%" bgcolor="#45777B"><span class="style3">Status</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['warehouse_name']!="")

$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';





$td='select a.'.$unique.',  a.'.$shown.',  a.bill_no, a.purchase_manager, status from '.$table.' a	where 1 order by a.bill_id';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
<td><?=$rp[0];?></td>

<td><?=$rp[2];?></td>

<td><?php echo date('d-m-Y',strtotime($rp[1]));?></td>
<td><?=find_a_field('purchase_manager','purchase_manager','id='.$rp[3]);?></td>
<td><?=$rp[4];?></td>
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