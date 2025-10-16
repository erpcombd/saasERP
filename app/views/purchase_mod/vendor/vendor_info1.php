<?php

 
 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

 $module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);


// ::::: Edit This Section ::::: 
$tr_type="Show";


$title='Vendor Information';			// Page Name and Page Title

do_datatable('vendor_table');

$page="vendor_info.php";		// PHP File Name



$table='vendor';		// Database Table Name Mainly related to this page

$unique='vendor_id';			// Primary Key of this Database table

$shown='vendor_name';				// For a New or Edit Data a must have data field

function createSubLedger($code,$name,$tr_from,$tr_id,$ledger_id,$type){

 $insert = 'insert into general_sub_ledger set sub_ledger_id="'.$code.'",sub_ledger_name="'.$name.'",tr_from="'.$tr_from.'",tr_id="'.$tr_id.'",ledger_id="'.$ledger_id.'",type="'.$type.'",entry_at="'.date('Y-m-d H:i:s').'",entry_by="'.$_SESSION['user']['id'].'",group_for="'.$_SESSION['user']['group'].'"';
db_query($insert);
return db_insert_id();

}

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
	

$proj_id = $_SESSION['proj_id'];

$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d h:i:s');

/*tin*/	


$folder='vendor';
$field = 'tin';
$file_name = $field.'-'.$_POST['vendor_id'];
if($_FILES['tin']['tmp_name']!=''){
$_POST['tin']=upload_file($folder,$field,$file_name);
$tr_type="Add";
}

//////////trade////////////////


//$_POST['pic']=image_upload($path,$_FILES['pic']);

$field = 'trade';
$file_name = $field.'-'.$_POST['vendor_id'];
if($_FILES['trade']['tmp_name']!=''){
$_POST['trade']=upload_file($folder,$field,$file_name);
}





//////////BIN////////////////

$field = 'bin';
$file_name = $field.'-'.$_POST['vendor_id'];


if($_FILES['bin']['tmp_name']!=''){

$_POST['bin']=upload_file($folder,$field,$file_name);


}

//////////cheque////////////////

$field = 'cheque';
$file_name = $field.'-'.$_POST['vendor_id'];

if($_FILES['cheque']['tmp_name']!=''){

$_POST['cheque']=upload_file($folder,$field,$file_name);


}

$custome_codes = find_a_field('vendor','max(sub_ledger_id)','1');
if($custome_codes>0){
	$custome_code = $custome_codes+1;
	}
	else{
	$custome_code = 50000001;
	}

//$wh_data = find_all_field('warehouse','','warehouse_id='.$_POST['depot']); 

$_POST['ledger_id'] = $_POST['ledger_id'];
$_POST['sub_ledger_id'] = $custome_code;

$_POST['ledger_name'] = $_POST['vendor_name'];

 


$crud->insert();
$ledger_gl_found = find_a_field('general_sub_ledger','sub_ledger_id','sub_ledger_name='.$_POST['ledger_name']);


if ($ledger_gl_found==0) {
createSubLedger($custome_code,$_POST['ledger_name'],'vendor',$_POST[$unique],$_POST['ledger_id'] ,$_POST['vendor_category']);
}
		
		
	
$tr_type="Initiate";

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);


header("Location: vendor_info.php");

}





//for Modify..................................



if(isset($_POST['update']))

{
$tr_type="update";
			
$folder='vendor';

$field = 'tin';
$file_name = $field.'-'.$_POST['vendor_id'];

if($_FILES['tin']['tmp_name']!=''){

$_POST['tin']=upload_file($folder,$field,$file_name);

}

$field = 'trade';
$file_name = $field.'-'.$_POST['vendor_id'];

if($_FILES['trade']['tmp_name']!=''){

$_POST['trade']=upload_file($folder,$field,$file_name);


}

$field = 'bin';
$file_name = $field.'-'.$_POST['vendor_id'];


if($_FILES['bin']['tmp_name']!=''){

$_POST['bin']=upload_file($folder,$field,$file_name);


}
$field = 'cheque';
$file_name = $field.'-'.$_POST['vendor_id'];

if($_FILES['cheque']['tmp_name']!=''){

$_POST['cheque']=upload_file($folder,$field,$file_name);


}

		
		
		

		$crud->update($unique);

		
		 $vendor_id =$_POST['vendor_id'];
		 $ledger_id = $_POST['ledger_id'];

	$sub_ledger_id = $_POST['sub_ledger_id'];



	  $sql1 = 'update  general_sub_ledger set sub_ledger_name="'.$_POST['vendor_name'].'" 

	  where sub_ledger_id  = '.$sub_ledger_id;
		db_query($sql1);




		$type=1;

		$msg='Successfully Updated.';
		$tr_type="Add";
}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);
		$tr_type="Delete";
		$type=1;

		$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

 
foreach($data as $key=>$value)

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
$tr_from="Purchase";
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


</style>





<div class="container-fluid pt-5 p-0 ">


			<table id="vendor_table" class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					<th>ID</th>
					<th style="text-align:left">Vendor Name</th>
					<th>GL Code</th>
					<th style="text-align:left">Address</th>

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
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">TIN Certificate :</label>
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
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">BIN Certificate :</label>
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
						<label class="container bg-form-titel-text">TIN Certificate:</label>
						<div class="container vendor_info_img">
						
						<?php
							$imageUrl = SERVER_CORE . "core/upload_view.php?name=$tin&folder=vendor&proj_id=" . $_SESSION['proj_id'];
							$defaultImage = SERVER_CORE . "core/default.png";
						?>

						<a href="<?= $imageUrl ?>" target="_blank" download>
    						<img src="<?= $imageUrl ?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" />
						</a>
						
						
						
						
							<?php /*?><a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$tin?>&folder=vendor&proj_id=<?=$_SESSION['proj_id']?>" target="_blank" download><img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$tin?>&folder=vendor&proj_id=<?=$_SESSION['proj_id']?>" /></a><?php */?>
							

							
							</a>
						</div>
					</div>



					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
						<label class="container bg-form-titel-text">Trade License:</label>
						<div class="container vendor_info_img">
						
						<?php
							$imageUrl = SERVER_CORE . "core/upload_view.php?name=$trade&folder=vendor&proj_id=" . $_SESSION['proj_id'];
							$defaultImage = SERVER_CORE . "core/default.png";
						?>

						<a href="<?= $imageUrl ?>" target="_blank" download>
    						<img src="<?= $imageUrl ?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" />
						</a>
								
						
						
							<?php /*?><a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$trade?>&folder=vendor&proj_id=<?=$_SESSION['proj_id']?>" target="_blank" download><img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$trade?>&folder=vendor&proj_id=<?=$_SESSION['proj_id']?>" /></a><?php */?>
						</div>
					</div>


					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
							<label class="container bg-form-titel-text">BIN Certificate:</label>
							<div class="container vendor_info_img">
							
							<?php
							$imageUrl = SERVER_CORE . "core/upload_view.php?name=$bin&folder=vendor&proj_id=" . $_SESSION['proj_id'];
							$defaultImage = SERVER_CORE . "core/default.png";
						?>

						<a href="<?= $imageUrl ?>" target="_blank" download>
    						<img src="<?= $imageUrl ?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" />
						</a>
							
							
							
							
							
								<?php /*?><a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$bin?>&folder=vendor&proj_id=<?=$_SESSION['proj_id']?>" target="_blank" download><img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$bin?>&folder=vendor&proj_id=<?=$_SESSION['proj_id']?>" /></a><?php */?>
							</div>
					</div>

					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
						<label class="container bg-form-titel-text">Blank Cheque:</label>
						<div class="container vendor_info_img">
						
						<?php
							$imageUrl = SERVER_CORE . "core/upload_view.php?name=$cheque&folder=vendor&proj_id=" . $_SESSION['proj_id'];
							$defaultImage = SERVER_CORE . "core/default.png";
						?>

						<a href="<?= $imageUrl ?>" target="_blank" download>
    						<img src="<?= $imageUrl ?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" />
						</a>
						
						
						
							<?php /*?><a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$cheque?>&folder=vendor&proj_id=<?=$_SESSION['proj_id']?>" target="_blank" download><img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$cheque?>&folder=vendor&proj_id=<?=$_SESSION['proj_id']?>" /></a><?php */?>
						</div>
					</div>

				</div>
			</div>


			<br>
			<div class="container-fluid bg-form-titel">

				<div class="row">
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">Vendor Name:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

								<input class="vendor_label_text" name="group_for" required type="hidden" id="group_for" tabindex="1" value="<?=$_SESSION['user']['group'];?>" >

								<input class="vendor_label_text" name="vendor_name" required type="text" id="vendor_name" tabindex="1" value="<?=$vendor_name?>">

							</div>
						</div>

					</div>

					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Vendor Company:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

								<input class="vendor_label_text" name="vendor_company" type="text" id="vendor_company" tabindex="2" value="<?=$vendor_company?>" />

							</div>
						</div>
					</div>

					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">Vendor Category:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<select name="vendor_category" required id="vendor_category" class="vendor_label_text" tabindex="3">
									<option></option>
									<? foreign_relation('vendor_category v','v.id','v.category_name',$vendor_category,'v.status="ACTIVE" and v.group_for="'.$_SESSION['user']['group'].'"');?>
								</select>


							</div>
						</div>
					</div>

					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Main Phone:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="contact_no" type="text" id="contact_no" tabindex="4" value="<?=$contact_no?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">SMS Phone:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="sms_mobile_no" type="text" id="sms_mobile_no" tabindex="5" value="<?=$sms_mobile_no?>" />

							</div>
						</div>
					</div>



					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Fax No:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="fax_no" type="text" id="fax_no" tabindex="6" value="<?=$fax_no?>"/>

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Main Email:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="email" type="text" id="email" tabindex="7" value="<?=$email?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">CC Email:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="cc_email" type="text" id="cc_email" tabindex="8" value="<?=$cc_email?>"/>
							</div>
						</div>
					</div>
					
					
					
						<?php 
							$proj_all=find_all_field('project_info','*','1');
							$gr_all=find_all_field('config_group_class','*','group_for='.$_SESSION['user']['group']); 
						
							$vendor_ledg_group_id=$gr_all->payable;
							
							?>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">A/C Configuration:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<? if ($ledger_id==0){ ?>
									<select class="vendor_label_text" name="ledger_id" required="required" id="ledger_id" tabindex="9">
                                           <option></option>
										  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$ledger_id,'ledger_group_id="'.$vendor_ledg_group_id.'" and group_for="'.$_SESSION['user']['group'].'"');?>
									</select>
								<? }?>

								<? if ($ledger_id>0){ ?>
									<input class="vendor_label_text" name="ledger_id" type="text" id="ledger_id" tabindex="9" value="<?=$ledger_id?>"  readonly=""  />
										<input class="vendor_label_text" name="sub_ledger_id" type="hidden" id="sub_ledger_id" tabindex="9" value="<?=$sub_ledger_id?>"  readonly=""  />
								<? }?>


							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-start align-items-center pr-1 bg-form-titel-text">Beneficiary Name:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="beneficiary_name"  type="text" id="beneficiary_name" tabindex="10" value="<?=$beneficiary_name?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-start align-items-center pr-1 bg-form-titel-text">Beneficiary Bank:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="beneficiary_bank" type="text" id="beneficiary_bank" tabindex="11" value="<?=$beneficiary_bank?>" />

							</div>
						</div>
					</div>

					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-start align-items-center pr-1 bg-form-titel-text">Account No:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="beneficiary_bank_ac" type="text" id="beneficiary_bank_ac" tabindex="12" value="<?=$beneficiary_bank_ac?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Swift Code:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="swift_code" type="text" id="swift_code" tabindex="13" value="<?=$swift_code?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Address:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="address" type="text" id="address" tabindex="14" value="<?=$address?>"  />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Country:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="country" type="text" id="country" tabindex="15" value="<?=$country?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="contact_person_name" type="text" id="contact_person_name" tabindex="16" value="<?=$contact_person_name?>" />

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Job Title:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="contact_person_designation" type="text" id="contact_person_designation" tabindex="17" value="<?=$contact_person_designation?>"/>

							</div>
						</div>
					</div>


					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person Phone:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="contact_person_mobile" type="text" id="contact_person_mobile" tabindex="18" value="<?=$contact_person_mobile?>" />

							</div>
						</div>
					</div>
					
					
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text rrq-input req-input">Status:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<select name="status" id="status" required="required">

                              <option value="<?=$status?>"><?=$status?></option>

                              <option value="ACTIVE">ACTIVE</option>

                               <option value="INACTIVE">INACTIVE</option>


                        </select>

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
	require_once SERVER_CORE."routing/layout.bottom.php";
?>