<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Personal File Check Status';// Page Name and Page Title
$page="pf_status.php";	// PHP File Name
$input_page="pf_status_input.php";
$root='hrm';
$table='pf_status';		// Database Table Name Mainly related to this page
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



    $_POST['file_type'] = find_a_field('hrm_pf_type_info','file_type','id='.$_POST['type']); //$_POST['type']; 
	$_POST['file_path'] = find_a_field('hrm_pf_type_info','file_path','id='.$_POST['type']); //$_POST['type'];   
	$_POST['status'] = $_POST['PF_STATUS_CV'];
    $file_name = ''.$_POST['file_path'].'-'.$_SESSION['employee_selected'];	
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

<? //include('../common/input_bar.php');?>

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
								     <? foreign_relation('hrm_pf_type_info','id','file_type',$type,'1');?>
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


  
  
	
<table class="table table-bordered table-sm">
  <thead class="bg-light">
    <tr class="table-info" align="center">
	
	  <th>SL</th>
	  <th>File Type</th>
	  <th>Status</th> 
	  
	 <!-- <th>View</th> -->
	  
	  <th>Action</th>   
    </tr>
  </thead>
	
  <tbody>
  
  
  
    <? 

 $pf = find_all_field('pf_status','','PBI_ID="'.$_SESSION['employee_selected'].'"');
 
 
$sqld = 'select *
from pf_status
where PBI_ID="'.$_SESSION['employee_selected'].'" and file_path!="" order by PF_STATUS_ID';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){


  ?>
  
  
   
    <tr align="center">
	
	   <td><?=++$s?></td>
	   <td align="center"><p class="fw-normal mb-1"><?=$data->file_type?></p></td>
		
      <td align="center"><span class="badge badge-primary rounded-pill d-inline"><?=$data->status?></span></td>
	  
	  

<!--<td><iframe src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$data->file_path?>&folder=hrm_pf_status&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" width="100" height="100"></iframe></td>
-->


	
	
      <!--<td>
		  
        <div class="d-flex align-items-center">
                       <? if($data->file_path!=""){  ?>
						  <a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$data->file_path?>&folder=hrm_pf_status&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank" download> 

						   <img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$data->file_path?>&folder=hrm_pf_status" width="70px" height="40px" class="img-fluid img-thumbnail" />
					   	</a>
			
                      <? }else{ ?>
			<img src="../../pic/employee.png" width="100px" height=""/>
			<? } ?>
          <div class="ms-3"></div>
        </div>
      </td>-->
	  
	  
	  
	   <td align="center"> <a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$data->file_path?>&folder=hrm_pf_status&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank" download> 
            <button type="button" class="btn btn-success"><i class="fa fa-download"></i></button></a>  
			
			
			<a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$data->file_path?>&folder=hrm_pf_status&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank">
			<button type="button" class="btn btn-primary"><i class="far fa-eye"></i></button></a>
			
			
			<a href="pf_delete.php?asign_id=<?=$data->PF_STATUS_ID;?>" onclick="return confirm('Are you sure you want to delete this item?');"   
			class="btn btn-danger btn-flat">   <i class="fa fa-trash"></i> </a>
			
			
            
			
			
	

						
						
						</td>
		
  
	  
    </tr>
	  
	
	<? } ?>
	
	  
  
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

