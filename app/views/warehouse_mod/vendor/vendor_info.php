<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Vendor Information';			// Page Name and Page Title

do_datatable('vendor_table');

$page="vendor_info.php";		// PHP File Name



$table='vendor';		// Database Table Name Mainly related to this page

$unique='vendor_id';			// Primary Key of this Database table

$shown='vendor_name';				// For a New or Edit Data a must have data field



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

//if ($_POST['dealer_found']==0) {}
	

$proj_id			= $_SESSION['proj_id'];

$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d h:i:s');



//$wh_data = find_all_field('warehouse','','warehouse_id='.$_POST['depot']); 

$_POST['ledger_group_id']=$_POST['ledger_group'];

$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$_POST['ledger_group_id'])+1;

$_POST['ledger_sl'] = sprintf("%04d", $cy_id);


$_POST['ledger_id'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];

$gl_group = find_all_field('ledger_group','','group_id='.$_POST['ledger_group_id']); 

$_POST['ledger_name'] = $_POST['vendor_name'];


$crud->insert();


$ledger_gl_found = find_a_field('accounts_ledger','ledger_id','ledger_name='.$_POST['ledger_name']);

if ($ledger_gl_found==0) {
   $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id, acc_class, acc_sub_class, acc_sub_sub_class, opening_balance, balance_type, depreciation_rate, credit_limit, proj_id, budget_enable, group_for, parent, cost_center, entry_by, entry_at)
  
  VALUES("'.$_POST['ledger_id'].'", "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$_POST['ledger_group_id'].'", "'.$gl_group->acc_class.'", "'.$gl_group->acc_sub_class.'",
   "'.$gl_group->acc_sub_sub_class.'", "0", "Both", "0", "0", "'.$proj_id.'", "YES", "'.$_POST['group_for'].'", "0", "0", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';

db_query($acc_ins_led);
}
		
		
	
		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);




}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);

		
		 $vendor_id =$_POST['vendor_id'];
		 $ledger_id = $_POST['ledger_id'];

	  $sql1 = 'update accounts_ledger set ledger_name="'.$_POST['vendor_name'].'" 
	  where ledger_id = '.$ledger_id;
		db_query($sql1);




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

/*.style1 {color: #FF0000}*/
/*.style2 {*/
	/*font-weight: bold;*/
	/*color: #000000;*/
	/*font-size: 14px;*/
/*}*/
/*.style3 {color: #FFFFFF}*/

-->

</style>





<div class="container-fluid pt-5 p-0 ">


			<table id="vendor_table" class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					<th>ID</th>
					<th>Vendor Name</th>
					<th>GL Code</th>
					<th>Address</th>

					<th>Action</th>
				</tr>
				</thead>

				<tbody class="tbody1">

				<?php


				if($_POST['group_for']!="")

					$con .= 'and a.group_for="'.$_POST['group_for'].'"';

				if($_POST['depot']!="")

					$con .= 'and a.depot="'.$_POST['depot'].'"';



				$td='select a.'.$unique.',  a.'.$shown.' as vendor_name,   a.address, a.ledger_id from '.$table.' a, user_group u
				where   a.group_for=u.id  and a.group_for="'.$_SESSION['user']['group'].'"    '.$con.' order by a.vendor_id ';

				$report=db_query($td);

				while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

					<tr<?=$cls?>  bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
						<td><?=$rp[0];?></td>

						<td style="text-align:left"><?=$rp[1];?></td>

						<td><?=$rp[3];?></td>
						<td style="text-align:left"><?=$rp[2];?></td>
						<td>
						<button type="button" onclick="DoNav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
						
						<!--<input type="button" onclick="DoNav('<?php echo $rp[0];?>');" class="btn1 btn1-bg-update" value="Edit"/>-->
						</td>
					</tr>
				<?php }?>
				</tbody>
			</table>

		</div>




	<div class="form-container_large">

		<h4 class="text-center bg-titel bold pt-2 pb-2">
			VENDOR FILE UPLOAD
		</h4>


		<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">



			<!--4 input table  for-->
			<div class="container-fluid bg-form-titel">
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Tin Certificate :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input type="file" name="tin" id="tin" class="pt-1 pb-1 pl-1" />
							</div>
						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Trade License :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

								<input type="file" name="trade" id="trade" class="pt-1 pb-1 pl-1"  />

							</div>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bin certificate :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="bin" type="file" id="bin" class="pt-1 pb-1 pl-1" />

							</div>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Blank Cheque :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="cheque" type="file" id="cheque" class="pt-1 pb-1 pl-1"/>


							</div>
						</div>
					</div>

				</div>
			</div>

			<br>


			<div class="container-fluid n-form1">
				<div class="row">

					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
						<label class="container bg-form-titel-text">Tin Certificate:</label>
						<div class="container vendor_info_img">
							<a href="<?php echo $tin_att?>" target="_blank" download><img src="<?php echo $tin_att?>" /></a>
						</div>
					</div>



					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
						<label class="container bg-form-titel-text">Trade License:</label>
						<div class="container vendor_info_img">
							<a href="<?=$trade_att?>" target="_blank" download><img src="<?=$trade_att?>"/></a>
						</div>
					</div>


					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
							<label class="container bg-form-titel-text">Bin certificate:</label>
							<div class="container vendor_info_img">
								<a href="<?=$bin_att?>" target="_blank" download><img src="<?=$bin_att?>"/></a>
							</div>
					</div>

					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
						<label class="container bg-form-titel-text">Blank Cheque:</label>
						<div class="container vendor_info_img">
							<a href="<?=$cheque_att?>" target="_blank" download><img src="<?=$cheque_att?>"/></a>
						</div>
					</div>

				</div>
			</div>


			<br>
			<div class="container-fluid bg-form-titel">

				<div class="row">
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">Vendor Name:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

								<input class="vendor_label_text" name="group_for" required type="hidden" id="group_for" tabindex="1" value="<?=$_SESSION['user']['group'];?>" >

								<input class="vendor_label_text" name="vendor_name" required type="text" id="vendor_name" tabindex="1" value="<?=$vendor_name?>">

							</div>
						</div>

					</div>

					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor Company:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

								<input class="vendor_label_text" name="vendor_company" type="text" id="vendor_company" tabindex="2" value="<?=$vendor_company?>" />

							</div>
						</div>
					</div>

					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">Vendor Category:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<select name="vendor_category" required id="vendor_category" class="vendor_label_text" tabindex="3">
									<option></option>
									<? foreign_relation('vendor_category','id','category_name',$vendor_category,'1');?>
								</select>


							</div>
						</div>
					</div>

					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Main Phone:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="contact_no" type="text" id="contact_no" tabindex="4" value="<?=$contact_no?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">SMS Phone:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="sms_mobile_no" type="text" id="sms_mobile_no" tabindex="5" value="<?=$sms_mobile_no?>" />

							</div>
						</div>
					</div>



					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Fax No:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="fax_no" type="text" id="fax_no" tabindex="6" value="<?=$fax_no?>"/>

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Main Email:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="email" type="text" id="email" tabindex="7" value="<?=$email?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">CC Email:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="cc_email" type="text" id="cc_email" tabindex="8" value="<?=$cc_email?>"/>
							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">A/C Configuration:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<? if ($ledger_id==0) {?>
									<select class="vendor_label_text" name="ledger_group" required="required" id="ledger_group" tabindex="9">

										<option></option>
										<? foreign_relation('ledger_group','group_id','group_name',$ledger_group,'acc_sub_sub_class=223'); //acc_sub_class=203?>
									</select>
								<? }?>

								<? if ($ledger_id>0) {?>
									<input class="vendor_label_text" name="ledger_id" type="text" id="ledger_id" tabindex="9" value="<?=$ledger_id?>"  readonly=""  />
								<? }?>


							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-end align-items-center pr-1 bg-form-titel-text">Beneficiary Name:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="beneficiary_name"  type="text" id="beneficiary_name" tabindex="10" value="<?=$beneficiary_name?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-end align-items-center pr-1 bg-form-titel-text">Beneficiary Bank:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="beneficiary_bank" type="text" id="beneficiary_bank" tabindex="11" value="<?=$beneficiary_bank?>" />

							</div>
						</div>
					</div>

					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-end align-items-center pr-1 bg-form-titel-text">Account No:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="beneficiary_bank_ac" type="text" id="beneficiary_bank_ac" tabindex="12" value="<?=$beneficiary_bank_ac?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Swift Code:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="swift_code" type="text" id="swift_code" tabindex="13" value="<?=$swift_code?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Address:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="address" type="text" id="address" tabindex="14" value="<?=$address?>"  />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Country:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="country" type="text" id="country" tabindex="15" value="<?=$country?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Contact Person:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="contact_person_name" type="text" id="contact_person_name" tabindex="16" value="<?=$contact_person_name?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Title:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="contact_person_designation" type="text" id="contact_person_designation" tabindex="17" value="<?=$contact_person_designation?>"/>

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Contact Person Phone:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="contact_person_mobile" type="text" id="contact_person_mobile" tabindex="18" value="<?=$contact_person_mobile?>" />

							</div>
						</div>
					</div>

				</div>


				<hr>
				<div class="n-form-btn-class">
							<? if(!isset($_GET[$unique])){?>
								<input name="insert" type="submit" id="insert" value="Save &amp; New" class="btn1 btn1-bg-submit" />
							<? }?>

							<? if(isset($_GET[$unique])){?>
								<input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update" />
							<? }?>

							<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />


				</div>


			</div>
		</form>
		<?

		//if(isset($_POST['search'])){

		?>

		

		<? //}?>
	</div>








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

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>