<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

do_calander('#reg_date');
// ::::: Edit This Section ::::: 
$tr_type="Show";
 //var_dump($_SESSION);

$title='Vendor Information';			// Page Name and Page Title

do_datatable('vendor_table');

$page="vendor_jamuna_entry.php";		// PHP File Name
$page_info="vendor_info_jamuna.php";		// PHP File Name


$table='vendor';		// Database Table Name Mainly related to this page
$table_details='vendor_key_person';
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
$random = random_int(10000,99999);
$newFileName = 'vendor_tin_'.$random;
$ext = end(explode(".",$_FILES['tin']['name']));
//$_POST['tin']=upload_file($folder,$field,$file_name);
file_upload_aws('tin','vendor_tin',$newFileName);
$_POST['tin']= $newFileName.'.'.$ext;
$tr_type="Add";
}

//////////trade////////////////


//$_POST['pic']=image_upload($path,$_FILES['pic']);

$field = 'trade';
$file_name = $field.'-'.$_POST['vendor_id'];
if($_FILES['trade']['tmp_name']!=''){
$random = random_int(10000,99999);
$newFileName = 'vendor_trade_'.$random;
$ext = end(explode(".",$_FILES['trade']['name']));
//$_POST['trade']=upload_file($folder,$field,$file_name);
file_upload_aws('trade','vendor_trade',$newFileName);
$_POST['trade']= $newFileName.'.'.$ext;
}


//////////BIN////////////////

$field = 'bin';
$file_name = $field.'-'.$_POST['vendor_id'];
if($_FILES['bin']['tmp_name']!=''){
$random = random_int(10000,99999);
$newFileName = 'vendor_bin_'.$random;
$ext = end(explode(".",$_FILES['bin']['name']));
//$_POST['bin']=upload_file($folder,$field,$file_name);
file_upload_aws('bin','vendor_bin',$newFileName);
$_POST['bin']= $newFileName.'.'.$ext;
}

//////////cheque////////////////

$field = 'cheque';
$file_name = $field.'-'.$_POST['vendor_id'];
if($_FILES['cheque']['tmp_name']!=''){
$random = random_int(10000,99999);
$newFileName = 'vendor_cheque_'.$random;
$ext = end(explode(".",$_FILES['cheque']['name']));
//$_POST['cheque']=upload_file($folder,$field,$file_name);
file_upload_aws('cheque','vendor_cheque',$newFileName);
$_POST['cheque']= $newFileName.'.'.$ext;
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
$last_id=db_insert_id();

$ledger_gl_found = find_a_field('general_sub_ledger','sub_ledger_id','sub_ledger_name='.$_POST['ledger_name']);


if ($ledger_gl_found==0) {
createSubLedger($custome_code,$_POST['ledger_name'],'vendor',$_POST[$unique],$_POST['ledger_id'] ,$_POST['vendor_category']);
}
		
		
	
$tr_type="Initiate";
$type=1;
$msg='New Entry Successfully Inserted.';

unset($_POST);
unset($$unique);
?>
<script>
    window.location.href = "vendor_jamuna_entry.php?vendor_id=<?=$last_id;?>";
</script>
<?
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


if(isset($_POST['add'])){

	if($_POST['vendor_id']>0){
		/////////Details table query
		$crud   = new crud($table_details);
		$crud->insert();
				
		//$msg='Product added to order successfully!';
		header("Location: vendor_jamuna_entry.php?vendor_id=".$_POST['vendor_id']);
	} else{
		
	}
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
.h_titel{
	padding: 0px !important;
    font-size: 12px !important;
	font-weight: 600;
}

</style>

	<div class="form-container_large">

		<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
				<input class="vendor_label_text" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
				<input class="vendor_label_text" name="group_for" required type="hidden" id="group_for" tabindex="1" value="<?=$_SESSION['user']['group'];?>" >

<!-- Tab button start-->
<div class="row p-0 m-0">
                        <div class="col-lg-12 col-lg-12 p-0">
                          <div class="mt-3 mb-0" data-sr-id="2"  style=" zoom: 77%; visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s; border-radius: 0px !important; border: 0px !important; background-color: #fff; box-shadow: none !important;">
                            <div class="d-flex">
                              <ul class="nav new-sr nav-pills">
                                <li class="nav-item">
										<a class="nav-link active" href="#" data-toggle="tab" data-target="#tab_1" style="color:#333;font-weight:bold"> <i class="fa-solid fa-pen-to-square"></i> GENERAL INFO </a>
								</li>
								
 								<li class="nav-item">
										<a class="nav-link" href="#" data-toggle="tab" data-target="#tab_2" style="color:#333;font-weight:bold"> <i class="fa-solid fa-business-time"></i> KEY CONTACT PERSONS</a>
								</li>
								
								
 								<li class="nav-item">
										<a class="nav-link" href="#" data-toggle="tab" data-target="#tab_7" style="color:#333;font-weight:bold"> <i class="fa-solid fa-business-time"></i> MERCHANDISE SUPPLIED</a>
								</li>
								
 								<li class="nav-item">
										<a class="nav-link" href="#" data-toggle="tab" data-target="#tab_3" style="color:#333;font-weight:bold"> <i class="fa-regular fa-clock"></i> BANKING INFO</a>
								</li>
 
  								<li class="nav-item">
										<a class="nav-link" href="#" data-toggle="tab" data-target="#tab_4" style="color:#333;font-weight:bold"> <i class="fa-solid fa-envelope-open"></i> TECHNICAL CAPARILITY </a>
								</li>
 
 								<li class="nav-item">
										<a class="nav-link" href="#" data-toggle="tab" data-target="#tab_5" style="color:#333;font-weight:bold"> <i class="fa-solid fa-person-chalkboard"></i> SUPPLY CONDITION</a>
								</li>
								
								<li class="nav-item"><a class="nav-link" href="#" data-toggle="tab" data-target="#tab_6" style="color:#333;font-weight:bold"> <i class="fa-regular fa-folder-open"></i> FILES UPLOAD</a></li>

                              </ul>
                            </div>
                          </div>
                          <div class="tab-content" style="border: 1px solid #005395; padding: 0px 10px; border-radius: 0px 0px 5px 5px;">
                            <div class="tab-pane fade active show" id="tab_1">
                              <div class="card">
                                <div  class="h_titel">
                                  <center>
                                    GENERAL INFORMATION
                                  </center>
                                </div>
                                <div class="card-body new-color">
                                  <div class="row">
								  	<div class="col-sm-6 col-md-6 col-lg-6">
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Vendor Code : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
											<input class="vendor_label_text" name="vendor_code" required type="text" id="vendor_code" tabindex="1" value="<?=$vendor_code?>">
                                        </div>
                                      </div>
									  
									<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Vendor Name : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											<input class="vendor_label_text" name="vendor_name" required type="text" id="vendor_name" tabindex="1" value="<?=$vendor_name?>">
                                        </div>
                                      </div>
									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Vendor Company : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input class="vendor_label_text" name="vendor_company" type="text" id="vendor_company" tabindex="2" value="<?=$vendor_company?>" />
										</div>
                                      </div>
									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Vendor Category : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
											<select name="vendor_category" required id="vendor_category" class="vendor_label_text" tabindex="3">
												<option></option>
												<? foreign_relation('vendor_category v','v.id','v.category_name',$vendor_category,'v.status="ACTIVE" and v.group_for="'.$_SESSION['user']['group'].'"');?>
											</select>
										</div>
                                      </div>
									  
									  <div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Phone:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="contact_no" type="text" id="contact_no" tabindex="4" value="<?=$contact_no?>" />

							</div>
						</div>
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Fax No:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="fax_no" type="text" id="fax_no" tabindex="6" value="<?=$fax_no?>"/>

							</div>
						</div>
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">SMS Phone:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="sms_mobile_no" type="text" id="sms_mobile_no" tabindex="5" value="<?=$sms_mobile_no?>" />

							</div>
						</div>
												
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Vendor Credit Days:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="vendor_credit_days" type="text" id="vendor_credit_days" tabindex="18" value="<?=$vendor_credit_days?>" />

							</div>
						</div>
											
									  
									
									
									</div>
									
									<div class="col-sm-6 col-md-6 col-lg-6">
										  <div class="form-group row m-0 pb-1">
											<label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Registation Date :</label>
											<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0  ">
											<input class="vendor_label_text" name="reg_date" type="text" id="reg_date" tabindex="2" value="<?=$reg_date?>" />
											</div>
										  </div>
										  
										 
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Address:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="address" type="text" id="address" tabindex="14" value="<?=$address?>"  />

							</div>
						</div>
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Mailing Address:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="mailing_address" type="text" id="mailing_address" tabindex="14" value="<?=$mailing_address?>"  />

							</div>
						</div>
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Factory Address:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="factory_address" type="text" id="factory_address" tabindex="14" value="<?=$factory_address?>"  />

							</div>
						</div>
					
					<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Email:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="email" type="text" id="email" tabindex="7" value="<?=$email?>" />

							</div>
						</div>
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Web Address/URL:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input class="vendor_label_text" name="web_address" type="text" id="web_address" tabindex="8" value="<?=$web_address?>"/>
							</div>
						</div>

											

						<div class="form-group row m-0 pb-1">
                               <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">A/C Configuration : </label>
                                 <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<?php 
									$proj_all=find_all_field('project_info','*','1');
									$gr_all=find_all_field('config_group_class','*','group_for='.$_SESSION['user']['group']); 
									$vendor_ledg_group_id=$gr_all->payable;
								?>
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
						
												
												
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Status:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
									<select name="status" id="status" required="required">
										  <option value="<?=$status?>"><?=$status?></option>
										  <option value="ACTIVE">ACTIVE</option>
										   <option value="INACTIVE">INACTIVE</option>
									</select>
							</div>
						</div>
										
									</div>
									

									
                                  <!--Card END-->
                                </div>
<center style="padding: 0px; padding-top: 15px;padding-bottom: 15px;background-color: white;margin: 10px;border-radius: 10px;">
								<? if(!isset($_GET[$unique])){?>
									<input name="insert" type="submit" id="insert" value="Save &amp; New" class="btn1 btn1-bg-submit" />
								<? }?>
								<? if(isset($_GET[$unique])){?>
									<input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update" />
								<? }?>
								<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page_info?>'" />
</center>
                              </div>
                            </div>
                            <!--end-->
                          </div>
						  
                          <div class="tab-pane fade" id="tab_2">
                            <div class="card">
                              <div class="h_titel">
                                <center>
                                  KEY CONTACT PERSONS
                                </center>
                              </div>
                              <div class="row m-0 new-color pt-3 pb-3"> 
							  <? if ($_GET['vendor_id'] !=''){?>
							  		<div class="col-sm-12 col-md-12 col-lg-12">
									<table class="table1  table-striped table-bordered table-hover table-sm">
										<thead class="thead1">
											<tr class="bgc-info">
												<th scope="col">Department</th>
												<th scope="col">Name</th>
												<th scope="col">Designation</th>
												<th scope="col">Cell Number</th>
												<th scope="col">Alternative Number</th>
												<th scope="col">Email</th>
												<th scope="col">Add</th>
											</tr>
										</thead>
									<tbody class="tbody1">
									<tr>
										<td>
											<select name="key_department" id="key_department" class="form-control">
												<option>- please select -</option>
												<option value="MANAGEMENT">MANAGEMENT</option>
												<option value="MARKETING">MARKETING</option>
												<option value="FINANCIAL">FINANCIAL</option>
												<option value="KEY CONTACT PERSON">KEY CONTACT PERSON</option>
											</select>
										</td> 
										<td><input name="key_name" type="text" id="key_name" tabindex="12" value="" /></td>
										<td><input name="key_designation" type="text" id="key_designation" tabindex="12" value="" /></td>
										<td><input name="key_number" type="text" id="key_number" tabindex="12" value="" /></td>
										<td><input name="key_alt_number" type="text" id="key_alt_number" tabindex="12" value="" /></td>
										<td><input name="key_email" type="text" id="key_email" tabindex="12" value="" /></td>
										<td><input name="add" type="submit" id="add" value="Add" class="btn1 btn1-bg-submit"></td>
									</tr>
									</tbody>
									</table>
									
									</div>
									<div class="col-sm-12 col-md-12 col-lg-12 pt-3">
									<table class="table1  table-striped table-bordered table-hover table-sm">
										<thead class="thead1">
											<tr class="bgc-info">
												<th scope="col">Department</th>
												<th scope="col">Name</th>
												<th scope="col">Designation</th>
												<th scope="col">Cell Number</th>
												<th scope="col">Alternative Number</th>
												<th scope="col">Email</th>
											</tr>
										</thead>
									<tbody class="tbody1">
										<? $res = 'select * from vendor_key_person where vendor_id='.$$unique.' order by id';
										  $query = db_query($res);
										  $sl = 1;
										  while ($data = mysqli_fetch_object($query)) {
										?>
										<tr>
											<td><?=$data->key_department;?></td>
											<td><?=$data->key_name;?></td>
											<td><?=$data->key_designation;?></td>
											<td><?=$data->key_number;?></td>
											<td><?=$data->key_alt_number;?></td>
											<td><?=$data->key_email;?></td>
										</tr>
										<? } ?>
									</tbody>
									</table>
									</div>
									<? } else{?>
											<div class="alert alert-warning" role="alert">Please Complete and save General information first. </div>
									<? } ?>
                              </div>
                            </div>
                          </div>


<div class="tab-pane fade" id="tab_7">
                            <div class="card">
                              <div class="h_titel">
                                <center>IF MERCHANDISE SUPPLIED BY DISTRIBUTOR </center>
                              </div>
                              <div class="row m-0 new-color pt-3 pb-3"> 
									<div class="col-sm-6 col-md-6 col-lg-6">
									
									<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Distributor Name : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											<input class="vendor_label_text" name="distributor_name" type="text" id="distributor_name" tabindex="1" value="<?=$distributor_name;?>">
                                        </div>
                                      </div>
									 
									 <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Address : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											<input class="vendor_label_text" name="distributor_address" type="text" id="distributor_address" tabindex="1" value="<?=$distributor_address?>">
                                        </div>
                                      </div>
									  
									 <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Tel : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											<input class="vendor_label_text" name="distributor_tal"  type="text" id="distributor_tal" tabindex="1" value="<?=$distributor_tal?>">
                                        </div>
                                      </div>
									  
									<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Fax : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											<input class="vendor_label_text" name="distributor_fax" type="text" id="distributor_fax" tabindex="1" value="<?=$distributor_fax; ?>">
                                        </div>
                                      </div>
									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">E-mail : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											<input class="vendor_label_text" name="distributor_email" type="text" id="distributor_email" tabindex="1" value="<?=$distributor_email?>">
                                        </div>
                                      </div>
									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Web address/URL : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											<input class="vendor_label_text" name="distributor_url" type="text" id="distributor_url" tabindex="1" value="<?=$distributor_url; ?>">
                                        </div>
                                      </div>
									
									</div>
									
									
									
									<div class="col-sm-6 col-md-6 col-lg-6">

									 <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Key Contact Person Name : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											<input class="vendor_label_text" name="key_person_name" type="text" id="key_person_name" tabindex="1" value="<?=$key_person_name?>">
                                        </div>
                                      </div>
									  
									 <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Designation : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											<input class="vendor_label_text" name="key_person_designation" type="text" id="key_person_designation" tabindex="1" value="<?=$key_person_designation?>">
                                        </div>
                                      </div>
									  
									<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Cell : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											<input class="vendor_label_text" name="key_person_cell" type="text" id="key_person_cell" tabindex="1" value="<?=$key_person_cell?>">
                                        </div>
                                      </div>
									  
									<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">E-mail : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											<input class="vendor_label_text" name="key_person_email" type="text" id="key_person_email" tabindex="1" value="<?=$key_person_email?>">
                                        </div>
                                      </div>
									
																		  
									<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Type of Business : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
											  <select name="business_type" id="business_type" class="form-control">
												<option <?php if($business_type!=''){?> value="<?=$business_type?>" <? } ?>><?php if($business_type!=''){ echo $business_type; }else{ echo "- please select -";}?></option>
												<option value="CORPORATE/LIMITED">CORPORATE/LIMITED</option>
												<option value="PARTNERSHIP">PARTNERSHIP</option>
												<option value="PROPRIETORSHIP">PROPRIETORSHIP</option>
												<option value="OTHER">OTHER (SPECIFY)</option>
											  </select>
                                        </div>
                                      </div>
									  
									  									  
									<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Nature of Business : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 ">
										<select name="business_nature" id="business_nature" class="form-control">
									  	<option <?php if($business_nature!=''){?> value="<?=$business_nature?>" <? } ?>><?php if($business_nature!=''){ echo $business_nature; }else{ echo "- please select -";}?></option>
										<option value="MANUFACTURER">MANUFACTURER</option>
										<option value="DISTRIBUTOR">DISTRIBUTOR</option>
										<option value="TRADER">TRADER</option>
										<option value="IMPORTER">IMPORTER</option>
										<option value="WHOLE SELLER">WHOLE SELLER</option>
										<option value="OTHER">OTHER (SPECIFY)</option>
									  </select>
									  
                                        </div>
                                      </div>
									
									
									</div>
                              </div>
							  
							  <div class="h_titel">
                                <center>License info </center>
                              </div>
                              <div class="row m-0 new-color pt-3 pb-3"> 
								  <div class="col-sm-6 col-md-6 col-lg-6">
								  
								  	  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">License No : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input class="vendor_label_text" name="license_no" type="text" id="license_no" tabindex="1" value="<?=$license_no?>">
										</div>
                                      </div>
								  	
									<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Country where reg : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input class="vendor_label_text" name="license_country" type="text" id="license_country" tabindex="1" value="<?=$license_country?>">
										</div>
                                      </div>
								  	
									<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">VAT No : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input class="vendor_label_text" name="vat_text" type="text" id="vat_text" tabindex="1" value="<?=$vat_text?>">
										</div>
                                      </div>


								  </div>
								  <div class="col-sm-6 col-md-6 col-lg-6">
								  
								  								  	
									<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">TIN/TaxID : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input class="vendor_label_text" name="tin_text" type="text" id="tin_text" tabindex="1" value="<?=$tin_text?>">
										</div>
                                      </div>
								  								  	
									<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Incorporation No : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input class="vendor_label_text" name="incorporation_no" type="text" id="incorporation_no" tabindex="1" value="<?=$incorporation_no?>"> 
										</div>
                                      </div>
								  
								  
								  </div>
							  
							  </div>
							  <center style="padding: 0px; padding-top: 15px;padding-bottom: 15px;background-color: white;margin: 10px;border-radius: 10px;">
								<? if(!isset($_GET[$unique])){?>
									<input name="insert" type="submit" id="insert" value="Save &amp; New" class="btn1 btn1-bg-submit" />
								<? }?>
								<? if(isset($_GET[$unique])){?>
									<input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update" />
								<? }?>
								<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page_info?>'" />
							</center>
                            </div>
                          </div>





                          <div class="tab-pane fade" id="tab_3">
                            <div class="card">
                              <div class="h_titel">
                                <center>
                                 CHEQUE ISSUES IN FAVOR OF
                                </center>
                              </div>
                              <div class="card-body new-color">
                                <div class="row">
								<div class="col-sm-6 col-md-6 col-lg-6">
								
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Account No : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input class="vendor_label_text" name="beneficiary_bank_ac" type="text" id="beneficiary_bank_ac" tabindex="12" value="<?=$beneficiary_bank_ac?>" />										
										</div>
                                      </div>
									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Bank Name: </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input class="vendor_label_text" name="beneficiary_bank" type="text" id="beneficiary_bank" tabindex="11" value="<?=$beneficiary_bank?>" />
										</div>
                                      </div>
									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Routing Number : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input class="vendor_label_text" name="routing_bank" type="text" id="routing_bank" tabindex="11" value="<?=$routing_bank?>" />
										</div>
                                      </div>
									  
									  
									  
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
								
								<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Account Name : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input class="vendor_label_text" name="beneficiary_name"  type="text" id="beneficiary_name" tabindex="10" value="<?=$beneficiary_name?>" />
										</div>
                                
								</div>
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Branch Name : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input class="vendor_label_text" name="branch_bank" type="text" id="branch_bank" tabindex="11" value="<?=$branch_bank?>" />
										</div>
                                      </div>
								
									  
									  
									  
									  <!--<div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Swift Code: </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input class="vendor_label_text" name="swift_code" type="text" id="swift_code" tabindex="13" value="<?=$swift_code?>" />
										</div>
                                      </div>-->
								
								</div>
									
			
                                </div>
<center style="padding: 0px; padding-top: 15px;padding-bottom: 15px;background-color: white;margin: 10px;border-radius: 10px;">
								<? if(!isset($_GET[$unique])){?>
									<input name="insert" type="submit" id="insert" value="Save &amp; New" class="btn1 btn1-bg-submit" />
								<? }?>
								<? if(isset($_GET[$unique])){?>
									<input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update" />
								<? }?>
								<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page_info?>'" />
</center>
                              </div>
                            </div>
                          </div>
						  
                          <div class="tab-pane fade" id="tab_4">
                            <div class="card">
                              <div class="h_titel">
                                <center>
                                  Technical Capability and information on goods / services offered
                                </center>
                              </div>
                              <div class="card-body new-color">
                                <div class="row">
								
                                  <div class="col-sm-12 col-md-12 col-lg-12">
								  	  <p class="">For Good sonly, do those offered for supply conform to National / International Quality Standards?</p>
									  <select name="national_standard" id="national_standard" style=" width: 120px !important; ">
									  	<option <?php if($national_standard!=''){?> value="<?=$national_standard?>" <? } ?>><?php if($national_standard!=''){ echo $national_standard; }else{ echo "- please select -";}?></option>
										<option value="YES">YES</option>
										<option value="NO">NO</option>
									  </select>
									  
									 <p class="mt-3">Quality Assurance Certification (e.g.ISO9000 or Equivalent):</p>
									  <select name="quality_certification" id="quality_certification" style=" width: 120px !important; ">
									  	<option <?php if($quality_certification!=''){?> value="<?=$quality_certification?>" <? } ?>><?php if($quality_certification!=''){ echo $quality_certification; }else{ echo "- please select -";}?></option>
										<option value="YES">YES</option>
										<option value="NO">NO</option>
									  </select>
									  
									  									  
									 <p class="mt-3">Other Certifications (IN Applicable)</p>
									  <select name="other_certification" id="other_certification" class="form-control" style=" width: 120px !important; ">
									  	<option <?php if($other_certification!=''){?> value="<?=$other_certification?>" <? } ?>><?php if($other_certification!=''){ echo $other_certification; }else{ echo "- please select -";}?></option>
										<option value="YES">YES</option>
										<option value="NO">NO</option>
									  </select>
									  
								  </div>
                                  
                                </div>
<center style="padding: 0px; padding-top: 15px;padding-bottom: 15px;background-color: white;margin: 10px;border-radius: 10px;">
								<? if(!isset($_GET[$unique])){?>
									<input name="insert" type="submit" id="insert" value="Save &amp; New" class="btn1 btn1-bg-submit" />
								<? }?>
								<? if(isset($_GET[$unique])){?>
									<input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update" />
								<? }?>
								<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page_info?>'" />
</center>
                              </div>
                            </div>
                          </div>
                          
                          <div class="tab-pane fade" id="tab_5">
                            <div class="card">
                              <div class="h_titel">
                                <center>
                                  supply goods condition on wcl
                                </center>
                              </div>
                              <div class="card-body new-color">
                                <div class="row">
									<div class="col-sm-12 col-md-12 col-lg-12">
										  <div class="form-group row m-0 pb-1">
											<label for="cost_center" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Payment Terms & Condition : </label>
											<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2 ">
											<input type="text"  name="term_condition" id="term_condition" tabindex="11" value="<?=$term_condition;?>" />
											</div>
										  </div>	
									</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Credit Period (Days) : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input type="text"  name="credit_period" id="credit_period" tabindex="11" value="<?=$credit_period;?>" />
										</div>
                                      </div>	
									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Payment of Mode : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input type="text"  name="payment_mode" id="payment_mode" tabindex="11" value="<?=$payment_mode;?>" />
										</div>
                                      </div>
									  
									  		  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Payment Hold : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">										
										<select name="payment_hold" id="payment_hold" class="form-control">
									  	<option <?php if($payment_hold!=''){?> value="<?=$payment_hold?>" <? } ?>><?php if($payment_hold!=''){ echo $payment_hold; }else{ echo "- please select -";}?></option>
										<option value="YES">YES</option>
										<option value="NO">NO</option>
									  </select>
										
										
										</div>
                                      </div>
									  
									  									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Delivery Lead Time : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input type="text"  name="delivery_time" id="delivery_time" tabindex="11" value="<?=$delivery_time;?>" />
										</div>
                                      </div>
									  
									  									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0  d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Minimum Order Qty (MOQ) : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input type="text"  name="min_order_qty" id="min_order_qty" tabindex="11" value="<?=$min_order_qty?>" />
										</div>
                                      </div>
									  
									  									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Packaging Type : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
											<select name="packaging_type" id="packaging_type" class="form-control">
												<option <?php if($packaging_type!=''){?> value="<?=$packaging_type?>" <? } ?>><?php if($packaging_type!=''){ echo $packaging_type; }else{ echo "- please select -";}?></option>
												<option value="BALED">Baled</option>
												<option value="SACK">Sack</option>
												<option value="JUMBO">Jumbo</option>
												<option value="BAG">Bag</option>
												<option value="ETC">ETC</option>
											</select>
										</div>
                                      </div>
									  
									  									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Pricing Basis : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
											<input type="text"  name="pricing_basis" id="pricing_basis" tabindex="11" value="<?=$pricing_basis;?>" />
										</div>
                                      </div>
									  
									  									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Currency : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										
											<select name="currency" id="currency" class="form-control">
												<option <?php if($currency!=''){?> value="<?=$currency?>" <? } ?>><?php if($currency!=''){ echo $currency; }else{ echo "- please select -";}?></option>
												<option value="USD">USD</option>
												<option value="MT">MT</option>
												<option value="BDT">BDT</option>
												<option value="ETC">ETC</option>
											</select>
										</div>
                                      </div>
									  						
								</div>
								
<div class="col-sm-6 col-md-6 col-lg-6">
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Transportation Mode : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
											<select name="transport_mode" id="transport_mode" class="form-control">
												<option <?php if($transport_mode!=''){?> value="<?=$transport_mode?>" <? } ?>><?php if($transport_mode!=''){ echo $transport_mode; }else{ echo "- please select -";}?></option>
												<option value="BY ROAD">BY ROAD</option>
												<option value="SEA">SEA</option>
												<option value="AIR">AIR</option>
											</select>
										</div>
                                      </div>	
									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Last Supply Date : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input type="text"  name="last_supply_date" id="last_supply_date" tabindex="11" value="<?=$last_supply_date?>" />
										</div>
                                      </div>
									  
									  									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Average Supply Volume : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input type="text"  name="supply_volume" id="supply_volume" tabindex="11" value="<?=$supply_volume;?>" />
										</div>
                                      </div>
									  
									  									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Performance Rating (internal) : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
											<select name="performance_rating" id="performance_rating" class="form-control">
												<option <?php if($performance_rating!=''){?> value="<?=$performance_rating?>" <? } ?>><?php if($performance_rating!=''){ echo $performance_rating; }else{ echo "- please select -";}?></option>
												<option value="QUALITY">QUALITY</option>
												<option value="DELIVERY">DELIVERY</option>
												<option value="SERVICE">SERVICE</option>
												<option value="ETC">ETC</option>
											</select>
										</div>
                                      </div>
									  
									  									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Remarks / Notes : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input type="text"  name="remarks" id="remarks" tabindex="11" value="<?=$remarks?>" />
										</div>
                                      </div>
									  
									  									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Type of Products : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
											<select name="type_product" id="type_product" class="form-control">
												<option <?php if($type_product!=''){?> value="<?=$type_product?>" <? } ?>><?php if($type_product!=''){ echo $type_product; }else{ echo "- please select -";}?></option>
												<option value="LOCAL">LOCAL</option>
												<option value="FOREIGN">FOREIGN</option>
												<option value="OTHER">OTHER (SPECIFY)</option>
											</select>
										</div>
                                      </div>
									  
									  									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Type of Raw Material Supplied : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input type="text"  name="rm_supplied" id="rm_supplied" tabindex="11" value="<?=$rm_supplied;?>" />
										</div>
                                      </div>
									  
									  									  
									  <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Material Grade / Specification : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input type="text"  name="material_grade" id="material_grade" tabindex="11" value="<?=$material_grade;?>" />
										</div>
                                      </div>
									  
									  									  
									  
									  						
								</div>
								
								
								
                                </div>
                                  <center style="padding: 0px; padding-top: 15px;padding-bottom: 15px;background-color: white;margin: 10px;border-radius: 10px;">
								<? if(!isset($_GET[$unique])){?>
									<input name="insert" type="submit" id="insert" value="Save &amp; New" class="btn1 btn1-bg-submit" />
								<? }?>
								<? if(isset($_GET[$unique])){?>
									<input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update" />
								<? }?>
								<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page_info?>'" />
</center>
                              </div>
                            </div>
                          </div>
						  
						  
						  <div class="tab-pane fade" id="tab_6">
                            <div class="card">
                              <div  class="h_titel">
                                <center>
                                  Vendor File Upload
                                </center>
                              </div>
                              <div class="card-body new-color">
                                <div class="row">
                                  <div class="col-md-3 form-group">
                                    <label class="label" for="pic">TIN Certificate :</label>
                                   	<input type="file" name="tin" id="tin" class="pt-1 pb-1 pl-1" />
                                  </div>
                                  <div class="col-md-3 form-group">
                                    <label class="label" for="pic">Trade License :</label>
                                    <input type="file" name="trade" id="trade" class="pt-1 pb-1 pl-1"  />
                                  </div>
                                  <div class="col-md-3 form-group">
                                    <label class="label" for="pic">BIN Certificate :</label>
                                    <input name="bin" type="file" id="bin" class="pt-1 pb-1 pl-1" />
                                  </div>
                                  <div class="col-md-3 form-group">
                                    <label class="label" for="pic">Blank Cheque :</label>
                                    <input name="cheque" type="file" id="cheque" class="pt-1 pb-1 pl-1"/>
                                  </div>
                                </div>
                                <div class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                  <td colspan="2"  class="oe_form_group_cell">&nbsp;</td>
                                  <td  class="oe_form_group_cell_label oe_form_group_cell">&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;</td>
                                </div>
                                <div class="row">
                                  <div class="col-md-3 form-group">
                                    <label class="label" for="pic">TIN Certificate </label>
                                  </div>
                                  <div class="col-md-3 form-group">
                                    <label class="label" for="pic">Trade License</label>
                                  </div>
                                  <div class="col-md-3 form-group">
                                    <label class="label" for="pic">BIN Certificate</label>
                                  </div>
                                  <div class="col-md-3 form-group">
                                    <label class="label" for="pic">Blank Cheque</label>
                                  </div>
                                </div>
								
                                <div class="row">
                                  <div class="col-md-3 form-group">
								  		<?php
											$imageUrl = SERVER_CORE . "core/upload_view.php?name=$tin&folder=vendor&proj_id=" . $_SESSION['proj_id'];
											$defaultImage = SERVER_CORE . "core/default.png";
										?>
										<a href="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=vendor_tin&&name=<?=$tin;?>" target="_blank"><img src="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=vendor_tin&&name=<?=$tin;?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" width="150px" height="160" /></a>
                                  </div>
                                  <div class="col-md-3 form-group">
								  		<?php
											$imageUrl = SERVER_CORE . "core/upload_view.php?name=$trade&folder=vendor&proj_id=" . $_SESSION['proj_id'];
											$defaultImage = SERVER_CORE . "core/default.png";
										?>
										<a href="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=vendor_trade&&name=<?=$trade;?>" target="_blank"><img src="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=vendor_trade&&name=<?=$trade;?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" width="150px" height="160"/>
										</a>
                                  </div>
                                  <div class="col-md-3 form-group">
								  		<?php
											$imageUrl = SERVER_CORE . "core/upload_view.php?name=$bin&folder=vendor&proj_id=" . $_SESSION['proj_id'];
											$defaultImage = SERVER_CORE . "core/default.png";
										?>
											<a href="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=vendor_bin&&name=<?=$bin;?>" target="_blank"><img src="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=vendor_bin&&name=<?=$bin;?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" width="150px" height="160"/>
										</a>
                                  </div>
                                  <div class="col-md-3 form-group">
											<?php
												$imageUrl = SERVER_CORE . "core/upload_view.php?name=$cheque&folder=vendor&proj_id=" . $_SESSION['proj_id'];
												$defaultImage = SERVER_CORE . "core/default.png";
											?>
												<a href="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=vendor_cheque&&name=<?=$cheque;?>" target="_blank" >
												<img src="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=vendor_cheque&&name=<?=$cheque;?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" width="150px" height="160"/>
											</a>
                                  </div>
								  
                                </div>
                              </div>
                            </div>
                  <center style="padding: 0px; padding-top: 15px;padding-bottom: 15px;background-color: white;margin: 10px;border-radius: 10px;">
								<? if(!isset($_GET[$unique])){?>
									<input name="insert" type="submit" id="insert" value="Save &amp; New" class="btn1 btn1-bg-submit" />
								<? }?>
								<? if(isset($_GET[$unique])){?>
									<input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update" />
								<? }?>
								<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page_info?>'" />
</center>
                          </div>
						  
                          
                        </div>
                      </div>
                    </div>


<!-- Tab button end-->

</form>
		
		
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