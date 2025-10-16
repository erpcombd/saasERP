<?php
session_start();
ob_start();
require "../../config/inc.all.php";
require "../../template/main_layout.php";



/*if($_GET['PBI_ID']>0){
  
  $_SESSION['employee_selected'] = $_GET['PBI_ID'];
}*/
// ::::: Edit This Section ::::: 
$title='Key Performance Indicator (KPI)';		// Page Name and Page Title
$page="performance_appraisal.php";		// PHP File Name
$input_page="performance_appraisal_input.php";
$root='kpi';

$table='kpi_log_sheet';		// Database Table Name Mainly related to this page
$unique='task_id';			// Primary Key of this Database table
$shown='task_name';	


// ::::: End Edit Section :::::

$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_GET['id'].'"');

$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$_SESSION['employee_selected'].'"');

$crud      =new crud($table);

$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;



			
//if(isset($_POST[$shown]))
//{	
if(isset($_POST['add']))
	{
	
			
			
			
			$_REQUEST['entry_by']=$_SESSION['employee_selected'];
			$inserted = $crud->insert();
			$type=1;
			$msg='New Entry Successfully Inserted.';
			//unset($_POST);
			//unset($$unique);
			

	}
	
	if($_GET['del']>0)
	{
	
			
			
			$del = 'delete from kpi_log_sheet where task_id="'.$_GET['del'].'"';
			mysql_query($del);
			
			echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal_2nd.php?id='.$_GET['id'].'";</script>';
			

	}

	
	
		
/*$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
else
$$unique = $_SESSION['employee_selected']=$_POST['PBI_ID'];*/

	//for Modify..................................
	if(isset($_POST['update']))
	{
		$path='../../pic/staff';
		$_POST['pic']=image_upload($path,$_FILES['pic']);
		
		if($_FILES['emp_pic']['tmp_name']!=''){
			$file_name= $_FILES['emp_pic']['name'];
			$file_tmp= $_FILES['emp_pic']['tmp_name'];
			$ext=end(explode('.',$file_name));
			$path='../../pic/staff/';
			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.jpeg');
			}
			
			if($_FILES['nid_pic']['tmp_name']!=''){
			$file_name= $_FILES['nid_pic']['name'];
			$file_tmp= $_FILES['nid_pic']['tmp_name'];
			$ext=end(explode('.',$file_name));
			$path='../../pic/nid/';
			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.jpeg');
			}
			
			if($_FILES['pass_pic']['tmp_name']!=''){
			$file_name= $_FILES['pass_pic']['name'];
			$file_tmp= $_FILES['pass_pic']['tmp_name'];
			$ext=end(explode('.',$file_name));
			$path='../../pic/passport/';
			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.jpeg');
			}
			
		    $_POST['PBI_ID']=$_SESSION['employee_selected'];
			$inserted = $crud->insert();
			$type=1;
			$msg='New Entry Successfully Inserted.';
			unset($_POST);
			unset($$unique);
			echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/confirmation_list.php";</script>';
	}
	
	if(isset($_POST['reset']))
	{
		echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/confirmation_list.php";</script>';
	}
//}

if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		echo '<script type="text/javascript">

parent.parent.document.location.href = "../'.$root.'/'.$page.'";

</script>';

		$type=1;

		$msg='Successfully Deleted.';

}


if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}

$data = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);

$color = '#00CCFF';


?>

<style>
.skill-bar {
    width: 100%;
    float: left;
    height: 15px;
    
    position: relative;
   
    
}
.skill-bar span {
    background: #00CCFF;
    height: 30px;
    border-radius: 5px;
    display: inline-block;
}
.skill-bar span {
    animation: w70 1s ease forwards;
}
.skill-bar .w70 {
    width:100%;
}
@keyframes w70 {
    from { width: 0%; }
    to { width: 100%; }
}
</style>

	
	
	<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->
          <div class="">
		  

		  
           
        <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
				
				<h3 align="center" style="text-transform:uppercase;"><?=$title?></h3>
                 
		     <? //include('../../common/new_title.php');?>
		 
                    
                  </div>
				  
				  <div class="x_panel">
				  <table width="100%" style="height:30px;" border="0" cellspacing="0" cellpadding="0" align="center">
				     <tr>
					    <td align="center" style="background:<?=$color?>; border-radius: 5px; color: #fff;">Step 1</td>
						<td align="center" style="background:<?=$color?>; border-radius: 5px; color: #fff;">Step 2</td>
						<td align="center" class="skill-bar"><span class="w70" style="color:#fff;">Final</span></td>
						
					 </tr>
				  </table>
                  </div>
				  
				  	 <div class="openerp openerp_webclient_container">
                    
			
				  
				  
                  <div class="x_content">
	
	
	
	
    
<form action="" method="post"  style="text-align:center" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to execute this?');">
  <div class="oe_view_manager oe_view_manager_current">
    <? //include('../../common/title_bar_data.php');?><br />
    <div class="oe_view_manager_body">
      <div  class="oe_view_manager_view_list"></div>
      <div class="oe_view_manager_view_form">
        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
        
            
                <? //include('../../common/input_bar.php');?>
                
                  
                    
                  <div class="container" style="margin-top:1%;">
				 <br />
                <div class="oe_chatter">
                  <div class="oe_followers oe_form_invisible">
                    <div class="oe_follower_list"></div>
                  </div>
               <div style="border: 1px solid #337AB7;padding: 3px; margin-top: -20px;">
		
		<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
		<tr height="60">
		  <td>
		    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
			
			<tr>
			   <td style="font-size:16px; padding:2px;"> ID NO : <strong><?=$employee->PBI_ID?></strong></td>
			   <td style="font-size:16px; padding:2px;">NAME : <strong><?=$employee->PBI_NAME?></strong> , </td>
			    <td style="font-size:16px; padding:2px;">DESIGNATION :  <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></strong></td>
				<td rowspan="3"><img src="../../../hrm_mod/pic/staff/<?=$_GET['id']?>.jpeg" style="height:100px; width:100px;" /></td>
			</tr>
			
			<tr>
			   <td style="font-size:16px; padding:2px;">DEPARTMENT :  <strong><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></strong>,</td>
			   <td style="font-size:16px; padding:2px;"> PROJECT NAME :  <strong><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></strong>,   </td>
			    <td style="font-size:16px; padding:2px;">JOINING DATE :  <strong><?=$employee->PBI_DOJ?></strong></td>
				
			</tr>
			
			
			 <tr>
			   <td style="font-size:16px; padding:2px;">KPI Authorised Person Name: <strong><?=$appraiser->PBI_NAME?></strong></td>
			  
			   <td style="font-size:16px; padding:2px;">Designation of Authorised Person : <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></strong></td>
			   <td>Service Length : <?php
										  
		  $interval = date_diff(date_create(date('Y-m-d')), date_create($employee->PBI_DOJ));
		echo $interval->format("%Y Year, %M Months, %d Days");
		  ?></td>
			   
			</tr>
			</table>
		  </td>
		   
	 </tr>
	 
	
			
	 
	
</table>

<br />

<table width="100%" border="1" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
           <tr>
		   
	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Weekly Error & Overtime Report</div></td>
	   </tr>
	   
	   </table><br />
	   <table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
	   
      </table><br />
       <table width="100%" border="1" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
		<tr height="30" style="background:#00CCFF">
		  <td width="10%"><div align="center"><strong>SL</strong></div></td>
		  <td width="30%"><div align="center"><strong>No. of errors for the followings</strong></div></td>
		  <td width="15%"><div align="center"><strong>Number of errors (Voucher)</strong></div></td>
		  <td width="40%"><div align="center"><strong>Justification Note</strong></div></td>
		  
		 </tr>
	 
	 
	    <tr height="30">
		  <td width="10%"><div align="center"><strong>1</strong></div></td>
		  <td width="30%"><div align="center">General Mistakes</div></td>
		  <td width="15%"><div align="center"><strong><input type="text" name="voucher" id="voucher" style="width: 95%;border-radius: 0px;height: 40px;margin-top: 1%;" /></strong></div></td>
		  <td width="40%"><div align="center"><strong><textarea name="justification_note" style="width:95%"></textarea></div></td>
		 </tr>
		 
		 <tr height="30">
		  <td width="10%"><div align="center"><strong>2</strong></div></td>
		  <td width="30%"><div align="center">Serious errors/ mistakes</div></td>
		  <td width="15%"><div align="center"><strong><input type="text" name="voucher" id="voucher" style="width: 95%;border-radius: 0px;height: 40px;margin-top: 1%;" /></strong></div></td>
		  <td width="40%"><div align="center"><strong><textarea name="justification_note" style="width:95%"></textarea></div></td>
		 </tr>
		 
		 <tr height="30">
		  <td width="10%"><div align="center"><strong>3</strong></div></td>
		  <td width="30%"><div align="center">Overtime Hours</div></td>
		  <td width="15%"><div align="center"><strong><input type="text" name="voucher" id="voucher" style="width: 95%;border-radius: 0px;height: 40px;margin-top: 1%;" /></strong></div></td>
		  <td width="40%"><div align="center"><strong><textarea name="justification_note" style="width:95%"></textarea></div></td>
		 </tr>
	  
	    </table><br />
		
		
		<table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
			<tr>
			   <td colspan="9"><div align="center"><input type="submit" name="submit" value="Confirm" style="width:100px; width: 15%; border-radius: 0px; height: 40px;background:#337AB7; color:#FFFFFF;" /></div></td>
			</tr>
	 
	
</table>
	
	</div>


</form>


 
		   </div>
		   
		   
		   </div>
		    </div>
            </div>
			</div>
			</div>
			 </div>
              </div>
          
          </div>
        </div>
      </div>
    </div>
  </div>


    </div>




<?
include_once("../../template/footer.php");
?>