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
$page="performance_appraisal_2nd.php";		// PHP File Name
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
			$_REQUEST['week']=$_SESSION['week_name'];
			$_REQUEST['year']=date('Y');
			$inserted = $crud->insert();
			$type=1;
			$in = 'INSERT INTO `kpi_log_sheet_temporary` (`PBI_ID`, `task_name`, `week`, `year`, `entry_by`) VALUES ("'.$_GET['id'].'", "'.$_POST['task_name'].'", "'.$_SESSION['week_name'].'", "'.date('Y').'", "'.$_SESSION['employee_selected'].'")';
			mysql_query($in);
			$msg='New Entry Successfully Inserted.';
			//unset($_POST);
			//unset($$unique);
			

	}
	
	if(isset($_POST['submit']))
	{
	    
		$ssql = 'select * from kpi_log_sheet_temporary where PBI_ID="'.$_GET['id'].'"  and year="'.date('Y').'"';
		$qr = mysql_query($ssql);
		$row = find_a_field('kpi_log_sheet_temporary','count(PBI_ID)','PBI_ID="'.$_GET['id'].'" and year="'.date('Y').'"');
	    $per_row = 60/$row;
		while($task_data=mysql_fetch_object($qr)){
		
		$img_id = rand();
		
		 $submitted = $_POST['submitted_'.$task_data->task_id];
		 $check = $_POST['check_'.$task_data->task_id];
		 
		 if($submitted=='YES'){
		    $point = $per_row;
		 }else{
		    $point = 0;
		 }
		 
		  if($_FILES['att_file_'.$task_data->task_id]['tmp_name']!=''){
			$file_name= $_FILES['att_file_'.$task_data->task_id]['name'];
			$file_tmp= $_FILES['att_file_'.$task_data->task_id]['tmp_name'];
			$ext=end(explode('.',$file_name));
			$upload = $img_id.'.'.$ext;
			$path='../../pic/kpi_log/';
			move_uploaded_file($file_tmp, $path.$upload);
			}
		 $insert = 'INSERT INTO `kpi_log_sheet_details` (`PBI_ID`, `log_id`, `submitted`, `documentart_evidence`,`point`,`entry_by`,`week`,`year`,`att_file`) VALUES ("'.$_GET['id'].'", "'.$task_data->task_id.'", "'.$submitted.'", "'.$check.'","'.number_format($point,0).'","'.$_SESSION['employee_selected'].'","'.$_SESSION['week_name'].'","'.date('Y').'","'.$upload.'")';
		 mysql_query($insert);
		 
		
		
		}
	
	
		echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal_last.php?id='.$_GET['id'].'";</script>';
	}
	
	if($_GET['del']>0)
	{
	
			
			
			$del = 'delete from kpi_log_sheet_temporary where task_id="'.$_GET['del'].'"';
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
<script>
    
	function cal(id){
	
	     
		 
	  var status = document.getElementById('submitted_'+id).value;
	 var exist_score = parseFloat(document.getElementById('score').value);
	 
	  var per_row_column = parseFloat(document.getElementById('per_row_column_'+id).value);
	    
	      var score = per_row_column;
		  if(status=='YES'){
		    
			var s = score;
			
			
			}if(status=='NO' || status=='N/A' || status==''){
			 
			 if(exist_score>0){
			   s = exist_score-score
			 }else{
			   s=0;
			 }
			  
			}
			
			document.getElementById('score').value = exist_score+s;
	}
  
</script>
	
	
	<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->
          <div class="">
		  

		  
           
        <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
				
				<h3 align="center" style="text-transform:uppercase;"><?=$title; echo $per_row;?></h3>
                 
		     <? //include('../../common/new_title.php');?>
		 
                    
                  </div>
				  
				  <div class="x_panel">
				  <table width="100%" style="height:30px;" border="0" cellspacing="0" cellpadding="0" align="center">
				     <tr>
					    <td align="center" style="background:<?=$color?>; border-radius: 5px; color: #fff;">Step-1</td>
						<td align="center" class="skill-bar"><span class="w70" style="color: #fff;">Step-2</span></td>
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
			   <td style="padding:2px;">Name : <strong><?=$employee->PBI_NAME?></strong>  </td>
			    <td style="padding:2px;">Designation :  <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></strong></td>
				<td rowspan="3"><img src="../../../hrm_mod/pic/staff/<?=$_GET['id']?>.jpeg" style="height:100px; width:100px;" /></td>
			</tr>
			
			<tr>
			   <td style="padding:2px;">Department :  <strong><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></strong></td>
			   <td style="padding:2px;"> Project Name :  <strong><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></strong> </td>
			    <td style="padding:2px;">Joining Date :  <strong><?=date('d-M-Y',strtotime($employee->PBI_DOJ))?></strong></td>
				
			</tr>
			
			
			 <tr>
			   <td style="padding:2px;">KPI Authorised Person: <strong><?=$appraiser->PBI_NAME?></strong></td>
			  
			   <td style="padding:2px;">Designation of Authorised Person : <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></strong></td>
			   <td>Service Length : <strong><?php
										  
		  $interval = date_diff(date_create(date('Y-m-d')), date_create($employee->PBI_DOJ));
		echo $interval->format("%Y Year, %M Months, %d Days");
		  ?></strong></td>
			   
			</tr>
			</table>
		  </td>
		   
	 </tr>
	 
	
			
	 
	
</table>

<br />

<table width="100%" border="1" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
           <tr>
		   
	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Weekly Log Sheet</div></td>
	   </tr>
	   
	   </table><br />
	   <table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
	   <tr>
		  
	      <td colspan="9"><div align="center" style="font-size:16px; font-weight:bold;"><input type="text" name="task_name" id="task_name" style="width:200px;height: 40px;width: 25%; border-radius: 0px; margin-top: -1px;border-color: #337AB7;" />&nbsp;&nbsp;<input type="submit" name="add" value="ADD" style="width:100px; width: 100px; border-radius: 0px; height: 40px;background:#337AB7; color:#FFFFFF;" /><input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_GET['id']?>"/></div></td>
	   </tr>
      </table><br />
       <table width="100%" border="1" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
		<tr height="30" style="background:#00CCFF">
		  <td width="5%"><div align="center"><strong>SL</strong></div></td>
		  <td width="60%"><div align="center"><strong>Description</strong></div></td>
		  <td width="10%"><div align="center"><strong>Submitted</strong></div></td>
		  <td width="10%"><div align="center"><strong>Documentary evidence</strong></div></td>
		  <td width="10%"><div align="center"><strong>Attachment</strong></div></td>
		   <td width="5%"><div align="center"><strong>Action</strong></div></td>
		 </tr>
	 
	  <?
	    $ssql = 'select * from kpi_log_sheet_temporary where PBI_ID="'.$_GET['id'].'" and year="'.date('Y').'"';
		$qr = mysql_query($ssql);
		 $count = find_a_field('kpi_log_sheet_temporary','count(PBI_ID)','PBI_ID="'.$_GET['id'].'" and year="'.date('Y').'"');
		 $per_row_column = 60/$count;
		 //$per_row_column = $per_row/6;
		while($task_data=mysql_fetch_object($qr)){
	  ?>
	 <tr>
		  <td width="5%"><div align="center"><strong><?=++$i?></strong></div></td>
		  <td width="60%"><div align="left"><?=$task_data->task_name?></div></td>
		  <td width="10%"><div align="center"><strong><select name="submitted_<?=$task_data->task_id?>" id="submitted_<?=$task_data->task_id?>" style="width: 100%;
    border-radius: 0px;height: 40px;margin-top: 1%;" onchange="cal(<?=$task_data->task_id?>)">
	<option></option>
	<option>YES</option>
	<option>NO</option>
	<option>N/A</option>
	
	</select>
	 <input type="hidden" name="per_row_column_<?=$task_data->task_id?>" id="per_row_column_<?=$task_data->task_id?>" value="<?=$per_row_column?>" />
	</strong></div></td>
		  <td width="10%">
		   <table width="50%">
		   <tr>
		     <td><input type="checkbox" name="check_<?=$task_data->task_id?>" id="check_<?=$task_data->task_id?>" value="YES" style="width:60px;"/></td><td>Check</td>
		  </tr>
		  </table>
		  </td>
		  <td><input type="file" name="att_file_<?=$task_data->task_id?>" id="att_file_<?=$task_data->task_id?>" style="width:100%" /></td>
		  <td width="5%"><div align="center"><a href="?del=<?=$task_data->task_id?>&&id=<?=$_GET['id']?>"><span style=" border-radius: 0px; background:#FF3300; color:#FFFFFF;">Delete</span></a></div></td>
		 </tr>
	  
	 
	  
	
	 <? } ?>
	 
	  
	    </table><br />
		<!--<table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
			<tr>
			
			   <td colspan="9"><div align="center"><strong>Weekly Log Sheet Score:</strong> <input type="text" name="score" value="0" id="score" style="width: 15%; border-radius: 0px; height: 40px;border-color:#337AB7;" /></div></td>
			</tr>
	 
	
</table>--><br />

<table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
			<tr>
			   <td colspan="9"><div align="center">
			     <input type="submit" name="submit" value="Confirm" style="width: 15%; border-radius: 0px; height: 40px;background:#337AB7; color:#FFFFFF;" />
			   </div></td>
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