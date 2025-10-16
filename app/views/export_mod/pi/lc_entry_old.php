<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


//create_combobox('dealer_code');

do_calander('#pi_date');
do_calander('#lc_expiry_date');
do_calander('#amendment_date');

// ::::: Edit This Section ::::: 



$title='Master PI Entry';			// Page Name and Page Title

do_datatable('table_head');

$page="lc_entry.php";		// PHP File Name



$table='pi_master';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='pi_date';				// For a New or Edit Data a must have data field



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


 $pi_date=$_POST['pi_date'];

 $YR = date('Y',strtotime($pi_date));
  
  $year = date('y',strtotime($pi_date));
  $month = date('m',strtotime($pi_date));
  
  
  $pi_id = find_a_field('pi_master','max(pi_id)','year="'.$YR.'"')+1;
  
   $cy_id = sprintf("%06d", $pi_id);
   
   $pi_code = find_a_field('pi_type','code','id="'.$_POST['pi_type'].'"');

   $pi_no_generate=$pi_code.''.$year.''.$month.''.$cy_id;
   
   $view_pi_no_generate=$pi_code.' '.$year.' '.$month.' '.$cy_id;
   
   $_POST['pi_no']=$pi_no_generate;
   $_POST['view_pi_no']=$view_pi_no_generate;
   $_POST['pi_id']=$cy_id;
   $_POST['year']=$YR;



		 $pi_sql = 'select * from terms_condition_setup where status="Active" order by sl_no';

		$pi_query = db_query($pi_sql);

		
		while($pi_data=mysqli_fetch_object($pi_query))

		{
	

  $pi_terms = 'INSERT INTO pi_terms_condition ( pi_id, terms_condition, sl_no, entry_at, entry_by)
  
  VALUES("'.$$unique.'", "'.$pi_data->terms_condition.'", "'.$pi_data->sl_no.'",  "'.$_POST['entry_at'].'", "'.$_POST['entry_by'].'")';

db_query($pi_terms);

}



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

								 <td width="12%">PI No:</td>

									<td width="20%">
									<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
									<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
								
								<? if($pi_no=="") {?>

								
								<input name="pi_no_test" type="text" id="pi_no_test" style="width:220px;" value="" readonly="" tabindex="105" />

								<? }?>
								
								
								<? if($pi_no!="") {?>

								<input name="pi_no" type="text" id="pi_no" style="width:220px;" value="<?=$pi_no?>" readonly="" tabindex="105" />
								<input name="pi_id" type="hidden" id="pi_id" style="width:220px;" value="<?=$pi_id?>" readonly="" tabindex="105" />
								<input name="year" type="hidden" id="year" style="width:220px;" value="<?=$year?>" readonly="" tabindex="105" />
								
								
								<? }?>
		
							
									</td>
									<td width="12%">Customer Group:</td>
									<td width="20%">
									<!--<input list="deal_list" name="dealer_group" id="dealer_group" value="<?php //echo find_a_field('dealer_group','dealer_group','id="'.$dealer_group.'"')."#>".$dealer_group;?>" onchange="getData2('find_dealer_ajax.php', 'find_dealer', this.value,document.getElementById('dealer_group').value);" required style="width:220px;" autocomplete="off">

<datalist id="deal_list">
<?php 
$d_sql='select * from dealer_group';
$d_query=db_query($d_sql);
while($drow=mysqli_fetch_object($d_query)){
?>
  <option value="<?php echo $drow->dealer_group."#>".$drow->id;?>">
 <?php } ?>
</datalist>-->
									<select name="dealer_group" id="dealer_group" required style="width:220px;" onchange="getData2('find_dealer_ajax.php', 'find_dealer', this.value,document.getElementById('dealer_group').value);" >
	
										<option></option>
								
										<? foreign_relation('dealer_group','id','dealer_group',$dealer_group,'1 order by id');?>
									</select>										</td>
									<td width="12%">&nbsp;&nbsp;&nbsp;PI Type:</td>
									<td width="20%">
									<select name="pi_type" id="pi_type" required style="width:220px;">
	
										<option></option>
								
										<? foreign_relation('pi_type','id','pi_type',$pi_type,'id!=1 order by id');?>
									</select></td>
								  </tr>
								  
								  
   
								  <tr>

								 <td> PI Date:</td>

									<td>

									<? if($pi_date=="") {?>
									
									<input style="width:220px;"  name="pi_date" type="text" id="pi_date" value="<?=($pi_date!='')?$pi_date:date('Y-m-d')?>"  required />

									<? }?>
									
									<? if($pi_date!="") {?>

									<input style="width:220px;"  name="pi_date" type="hidden" id="pi_date" value="<?=$pi_date;?>"  required/>
									
									<input style="width:220px;"  name="pi_date2" type="text" id="pi_date2" value="<?=$pi_date;?>" readonly="" required/>
									
									<? }?>

								</td>
									<td>Customer Name:</td>
									<td>
									
									<span id="find_dealer">
									
									<select name="dealer_code" id="dealer_code" required style="width:220px;">
	
										<option></option>
								
										<? foreign_relation('dealer_info_foreign','dealer_code','dealer_name_e',$dealer_code,'1 order by dealer_code');?>
									</select>
									</span>										</td>
									
									
									
									<td>&nbsp;&nbsp;&nbsp;Advising Bank:</td>
									<td><select name="bank_seller" id="bank_seller" required style="width:220px;">
	
										<option></option>
								
										<? foreign_relation('bank_sellers','bank_id','bank_name',$bank_seller,'1 order by bank_id');?>
									</select>								</td>
								  </tr>
								  
								  
								  <tr>

								 <td> HS CODE:</td>

									<td>

								 
									
									<input style="width:220px;"  name="hs_code" type="text" id="hs_code" value="<?=$hs_code?>"  required />

									 
									
							 

								</td>
				 
									
									
									
									 
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
<th width="5%" bgcolor="#45777B"><span class="style3">ID</span></th>

<th width="14%" bgcolor="#45777B"><span class="style3">PI No </span></th>

<th width="16%" bgcolor="#45777B"><span class="style3">PI Date</span></th>
<th width="19%" bgcolor="#45777B"><span class="style3">PI Type </span></th>
<th width="17%" bgcolor="#45777B"><span class="style3">Customer Group</span></th>
<th width="29%" bgcolor="#45777B"><span class="style3">Customer Name</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['warehouse_name']!="")

$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';





$td='select a.'.$unique.',  a.'.$shown.',  a.pi_no, a.pi_type, a.dealer_group, a.dealer_code from '.$table.' a	where a.pi_type!=1 order by a.id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
<td><?=$rp[0];?></td>

<td><?=$rp[2];?></td>

<td><?php echo date('d-m-Y',strtotime($rp[1]));?></td>
<td><?=find_a_field('pi_type','pi_type','id='.$rp[3]);?></td>
<td><?=find_a_field('dealer_group','dealer_group','id='.$rp[4]);?></td>
<td><?=find_a_field('dealer_info_foreign','dealer_name_e','dealer_code='.$rp[5]);?></td>
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