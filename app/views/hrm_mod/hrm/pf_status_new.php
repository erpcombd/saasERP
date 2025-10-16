<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Personal File Check Status';// Page Name and Page Title
$page="pf_status_new.php";	// PHP File Name
$input_page="pf_status_input.php";
$root='hrm';
$table='pf_status_new';		// Database Table Name Mainly related to this page
$unique='PF_STATUS_ID';	// Primary Key of this Database table
$shown='PF_STATUS_CV';	// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

$crud = new crud($table);
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);
$required_id = find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;



// Post Starts from here

//if(isset($_POST[$shown])){	
	if(isset($_POST['insert'])){	
	
		

	$_POST['PBI_ID']=$_SESSION['employee_selected'];
	$folder='hrm_pf_status'; 
	$field = 'PBI_CV_ATT_PATH'; 

//$file_name = $folder.'-'.$_SESSION['employee_selected'];


if($_FILES['PBI_CV_ATT_PATH']['tmp_name']!=''){



    $_POST['file_type'] = $_POST['type'];
	$_POST['status'] = $_POST['PF_STATUS_CV'];
    $file_name = ''.$_POST['type'].'-'.$_SESSION['employee_selected'];	
	$_POST['file_path']=upload_file($folder,$field,$file_name);



}

	$crud->insert();
	$type=1;
	$msg='New Entry Successfully Inserted.';
	unset($_POST);
	unset($$unique);

	$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
	if($required_id>0)
	$$unique = $_GET[$unique] = $required_id;

}
	
	

//Update starts from here

/*if(isset($_POST['update'])){

$folder='hrm_cv'; 
$field = 'PBI_CV_ATT_PATH'; 
//$file_name = $folder.'-'.$_SESSION['employee_selected'];

if($_FILES['PBI_CV_ATT_PATH']['tmp_name']!=''){

if($_POST['type']==1){

	$_POST['cv'] = $_POST['PF_STATUS_CV'];
	$file_name = 'CV-'.$_SESSION['employee_selected'];	$_POST['PBI_CV_ATT_PATH']=upload_file($folder,$field,$file_name);

}
	
elseif($_POST['type']==2){
	
	$_POST['PF_STATUS_APPOINTMENT_LETTER'] = $_POST['PF_STATUS_CV'];
	$file_name = 'App-'.$_SESSION['employee_selected'];	$_POST['PBI_APOINT_ATT_PATH']=upload_file($folder,$field,$file_name);
}
elseif($_POST['type']==3){
	
	$_POST['PF_STATUS_JOINING_LETTER']=$_POST['PF_STATUS_CV'];
	$file_name = 'joining-'.$_SESSION['employee_selected'];	$_POST['PBI_JOIN_ATT_PATH']=upload_file($folder,$field,$file_name);
}

	
elseif($_POST['type']==4){
	$_POST['PF_STATUS_E_AFFIDAVIT'] = $_POST['PF_STATUS_CV'];
	
	$file_name = 'affidavid-'.$_SESSION['employee_selected'];	$_POST['affidavid_path']=upload_file($folder,$field,$file_name);
	}
	
elseif($_POST['type']==5){
	$_POST['PF_STATUS_G_AFFIDAVIT'] = $_POST['PF_STATUS_CV'];
	
	$file_name = 'gurdian_aff-'.$_SESSION['employee_selected'];	$_POST['gurdian_aff_path']=upload_file($folder,$field,$file_name);
	}
	
elseif($_POST['type']==6){
	$_POST['PF_STATUS_G_CERTIFY_LETTER'] = $_POST['PF_STATUS_CV'];
	
	$file_name = 'gard_cert-'.$_SESSION['employee_selected'];	$_POST['gard_cert_path']=upload_file($folder,$field,$file_name);
	}

}

	
	
$crud->update($unique);
$type=1;

}*///}

if(isset($$unique)){

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach($data as $key => $value)

{ $$key=$value;}

}

?>


<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}
</script>



<style>
	
.style1{
padding-left:20px;
}

.container {
  padding: 2rem 0rem;
}

h4 {
  margin: 2rem 0rem 1rem;
}

.table-image {
  td, th {
    vertical-align: middle;
  }
}

</style>




<form action="" method="post" enctype="multipart/form-data">

<div class="oe_view_manager oe_view_manager_current">

<? include('../common/title_bar.php');?>

<div class="oe_view_manager_body">

<div  class="oe_view_manager_view_list"></div>

<div class="oe_view_manager_view_form">

<div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

<div class="oe_form_buttons"></div>

<div class="oe_form_sidebar"></div>

<div class="oe_form_pager"></div>

<div class="oe_form_container">

<div class="oe_form">

<div class="">

<? //include('../../common/input_bar.php');?>

<div class="oe_form_sheetbg" >

<div class="oe_form_sheet oe_form_sheet_width">



	<table 
		   border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-sm ">
		<tbody>
 			<tr>

                <td align="right" class="alt">
					<strong>File Type  : </strong>
				</td>

                              <td align="left" class="alt"><span class="oe_form_group_cell">

                                <select name="type" id="type">

                                  <option value="CV" <?=($type=='1')?'selected':''?>>CV</option>

                                  <option value="App_Letter" <?=($type=='2')?'selected':''?>>Appointment Letter</option>
								  
								  <option value="3" <?=($type=='3')?'selected':''?>>Joining Letter</option>


                                </select>

                                </span></td>
								
								
      <td  height="24" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Status :</td>

      <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell">
		<!--  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />-->

			<input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />

			<select name="PF_STATUS_CV" id="PF_STATUS_CV"> 
				<option selected="selected"></option>
				<option>Yes</option>
				<option>No</option>
			</select>
		</td>

		<td align="left">
			<strong>Select File :</strong>
		</td>
				
		<td>
			<span class="oe_form_group_cell">
				<input type="file" name="PBI_CV_ATT_PATH" id="PBI_CV_ATT_PATH"  class="form-control" />
			</span>
		</td>
		
		
		<td>
				<span class="oe_form_buttons_edit" style="display: inline;">
				
			<!--	<input type="button"  name="insert" id="insert"  class="btn btn-danger form-control" value="SAVE"/>-->
		
			  <button name="insert" accesskey="S" class="btn btn-danger form-control" type="submit"> <i class="fa-duotone fa-share-all"></i> Upload</button>
		
			   </span>
		</td>
		
		
		
		
		
	
	
		
      </tr>

  </tbody>
</table>

  <? 

 $pf = find_all_field('pf_status','','PBI_ID="'.$_SESSION['employee_selected'].'"');
  ?>
  
  
	
<table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>Documents</th>
      <th>Title</th>
      <th>Status</th>   
    </tr>
  </thead>
	
  <tbody>
   
    <tr>
      <td>
		  
        <div class="d-flex align-items-center">
                       <? if($pf->PBI_CV_ATT_PATH!=""){  ?>
						  <a 
							 href="../../../assets/support/upload_view.php?
								   name=<?=$pf->PBI_CV_ATT_PATH?>&folder=hrm_pf_status&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank" download> 

						   <img 
								src="../../../assets/support/upload_view.php?
									 name=<?=$pf->PBI_CV_ATT_PATH?>&folder=hrm_pf_status" width="70px" height="40px" class="img-fluid img-thumbnail" />
					   	</a>
			
                      <? }else{ ?>
			<img src="../../pic/employee.png" width="100px" height=""/>
			<? } ?>
          <div class="ms-3"></div>
        </div>
      </td>
		
      <td>
        <p class="fw-normal mb-1">Curriculum Vitae (CV)</p>
      </td>
		
      <td>
		  <span class="badge badge-primary rounded-pill d-inline">
		  	<?=$pf->PF_STATUS_CV?>
		  </span>
	  </td>
	  
    </tr>
	  
	
	
	
	  
  
  </tbody>
</table>



	<div class="oe_chatter">
	  <div class="oe_followers oe_form_invisible">
		<div class="oe_follower_list"></div>
	  </div>
	</div>

</form>
	
	

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

