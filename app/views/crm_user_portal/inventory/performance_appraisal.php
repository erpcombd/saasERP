<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require "../../template/main_layout.php";



/*if($_GET['PBI_ID']>0){
  
  $_SESSION['employee_selected'] = $_GET['PBI_ID'];
}*/
// ::::: Edit This Section ::::: 
$title='Key Performance Indicator (KPI)';		// Page Name and Page Title
$page="performance_appraisal.php";		// PHP File Name
$input_page="performance_appraisal_input.php";
$root='kpi';

$table='kpi_task';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
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
	
	if(isset($_POST['submit']))
	{
	
		echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal_2nd.php?id='.$_GET['id'].'";</script>';
	}
	
	if($_GET['del']>0)
	{
	
			
			
			$del = 'delete from kpi_task where task_id="'.$_GET['del'].'"';
			db_query($del);
			
			echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal.php?id='.$_GET['id'].'";</script>';
			

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
foreach ($data as $key => $value)
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
					    <td align="center" class="skill-bar"><span class="w70" style="color: #fff;">Step 1</span></td>
						<td align="center" >Step 2</td>
						<td align="center">Final</td>
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
			  
			   <td style="font-size:16px; padding:2px;">Designation of Authorised Person: <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></strong></td>
			   <td> Service Length : <?php
										  
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
		   
	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Daily Task</div></td>
	   </tr>
	   
	   </table><br />
	   <table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
	   <tr>
		  
	      <td colspan="9"><div align="center" style="font-size:16px; font-weight:bold;"><input type="text" name="task_name" id="task_name" style="width:200px;height: 40px;width: 25%; border-radius: 0px; margin-top: -1px;border-color: #337AB7;" />&nbsp;&nbsp;<input type="submit" name="add" value="ADD" style="width:100px; width: 100px; border-radius: 0px; height: 40px;background:#337AB7; color:#FFFFFF;" /><input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_GET['id']?>"/></div></td>
	   </tr>
      </table><br />
       <table width="100%" border="1" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
		
	 
	  <?
	    $ssql = 'select * from kpi_task where PBI_ID="'.$_GET['id'].'"';
		$qr = db_query($ssql);
		while($task_data=mysqli_fetch_object($qr)){
	  ?>
	 
	  <tr>
	      <td colspan="9" style="background:#00CCFF"><div align="center" style="font-size:16px; font-weight:bold;"><?=$task_data->task_name?></div></td>
	   </tr>
	 <tr>
		 
		  <td width="11%"><div align="center">Saturday</div></td>
		  <td width="11%"><div align="center">Sunday</div></td>
		  <td width="11%"><div align="center">Monday</div></td>
		  <td width="11%"><div align="center">Tuesday</div></td>
		  <td width="11%"><div align="center">Wednesday</div></td>
		  <td width="11%"><div align="center">Thursday</div></td>
		  <td width="11%"><div align="center">Friday</div></td>
		  <td width="11%"><div align="center">Score/Points</div></td>
		  <td width="11%"><div align="center">Action</div></td>
		   
	 </tr>
	  <tr>
	     
		  <td><div align="center"><select name="saturday" id="saturday" style="width: 100%; border-radius: 0px;height: 30px;"><option></option><option>YES</option><option>NO</option></select></div></td>
		  <td><div align="center"><select name="saturday" id="saturday" style="width: 100%; border-radius: 0px;height: 30px;"><option></option><option>YES</option><option>NO</option></select></div></td>
		  <td><div align="center"><select name="saturday" id="saturday" style="width: 100%; border-radius: 0px;height: 30px;"><option></option><option>YES</option><option>NO</option></select></div></td>
		  <td><div align="center"><select name="saturday" id="saturday" style="width: 100%; border-radius: 0px;height: 30px;"><option></option><option>YES</option><option>NO</option></select></div></td>
		  <td><div align="center"><select name="saturday" id="saturday" style="width: 100%; border-radius: 0px;height: 30px;"><option></option><option>YES</option><option>NO</option></select></div></td>
		  <td><div align="center"><select name="saturday" id="saturday" style="width: 100%; border-radius: 0px;height: 30px;"><option></option><option>YES</option><option>NO</option></select></div></td>
		  <td><div align="center"><select name="saturday" id="saturday" style="width: 100%; border-radius: 0px;height: 30px;"><option></option><option>YES</option><option>NO</option></select></div></td>
		  <td><div align="center"><input type="text" name="score" style="width: 100%; border-radius: 0px;height: 30px;" /></div></td>
		   <td><div align="center"><a href="?del=<?=$task_data->task_id?>&&id=<?=$_GET['id']?>" onclick="show_alert();"><span style=" border-radius: 0px; background:#FF3300; color:#FFFFFF;">Delete</span></a></div></td>
		   
	 </tr>
	 <tr>
	   <td colspan="9">&nbsp;</td>
	 </tr>
	 <? } ?>
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