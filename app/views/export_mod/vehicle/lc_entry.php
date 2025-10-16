<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


create_combobox('dealer_code');

do_calander('#lc_date');
do_calander('#lc_expiry_date');
do_calander('#amendment_date');

// ::::: Edit This Section ::::: 



$title='LC Entry';			// Page Name and Page Title

do_datatable('table_head');

$page="lc_entry.php";		// PHP File Name



$table='lc_management';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='lc_no';				// For a New or Edit Data a must have data field



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

$now				= time();

$entry_by = $_SESSION['user'];



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

                                     <td width="12%">LC No :</td>

                                        <td width="20%">
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        				<input name="lc_no" required type="text" id="lc_no" tabindex="1" value="<?=$lc_no?>"  style="width:220px;" >										</td>
                                        <td width="12%">Issuing Bank:</td>
                                        <td width="20%">
										
										<select name="issuing_bank" id="issuing_bank" style="width:220px;">
		
											<option></option>
									
											<? foreign_relation('bank_issuing','bank_id','bank_name',$issuing_bank,'1 order by bank_id');?>
										</select>
										
										</td>
									    <td width="12%">Amendment Date:</td>
									    <td width="20%"><input name="amendment_date" required="required" type="text" id="amendment_date" tabindex="1" value="<?=$amendment_date?>"  style="width:220px;" /></td>
									  </tr>
									  
									  
	  
									  <tr>

                                     <td> LC Date:</td>

                                        <td>

                        				<input name="lc_date"  type="text" id="lc_date" tabindex="1" value="<?=$lc_date?>"  style="width:220px;" >										</td>
                                        <td>Beneficiary Bank:</td>
                                        <td>
										
										<select name="beneficiary_bank" id="beneficiary_bank" style="width:220px;">
		
											<option></option>
									
											<? foreign_relation('bank_issuing','bank_id','bank_name',$beneficiary_bank,'1 order by bank_id');?>
										</select>
										
										</td>
									    <td>Customer:</td>
									    <td>
										
										<select name="dealer_code" id="dealer_code" style="width:220px;">
		
											<option></option>
									
											<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'1 order by dealer_code');?>
										</select>
										
										</td>
									  </tr>
									  
	     

                                      <tr>

                                        <td>LC Expiry Date:</td>

                                        <td>
										<input name="lc_expiry_date"  type="text" id="lc_expiry_date" tabindex="1" value="<?=$lc_expiry_date?>"  style="width:220px;" >										</td>
                                        <td>LC Value:</td>
                                        <td><input name="lc_value"  type="text" id="lc_value" tabindex="1" value="<?=$lc_value?>"  style="width:220px;"></td>
                                        <td>Remarks:</td>
                                        <td><input name="remarks" required="required" type="text" id="remarks" tabindex="1" value="<?=$remarks?>"  style="width:220px;" /></td>
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

<th width="14%" bgcolor="#45777B"><span class="style3">LC No </span></th>

<th width="16%" bgcolor="#45777B"><span class="style3">LC Date</span></th>
<th width="19%" bgcolor="#45777B"><span class="style3">LC Expiry Date</span></th>
<th width="17%" bgcolor="#45777B"><span class="style3">LC Value </span></th>
<th width="29%" bgcolor="#45777B"><span class="style3">Customer</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['warehouse_name']!="")

$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';





 $td='select a.'.$unique.',  a.'.$shown.',  a.lc_date, a.lc_expiry_date, a.lc_value, a.dealer_code from '.$table.' a	where 1 order by a.id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td><?=$rp[1];?></td>

<td><?php echo date('d-m-Y',strtotime($rp[2]));?></td>
<td><?php echo date('d-m-Y',strtotime($rp[3]));?></td>
<td><?=$rp[4];?></td>
<td><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$rp[5]);?></td>
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