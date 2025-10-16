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
$page="performance_appraisal_last.php";		// PHP File Name
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
if(isset($_POST['submit']))
	{
	
		$general_mistake = $_POST['general_mistake'];
		$serious_mistake = $_POST['serious_mistake'];
		$over_time = $_POST['over_time'];
		$score = $_POST['score'];
		$general_justification = $_POST['general_justification'];
		$serious_justification = $_POST['serious_justification'];
		$overtime_justification = $_POST['overtime_justification'];
		$notes = $_POST['notes'];
		
		$insert = 'INSERT INTO `kpi_error_overtime_details` (`PBI_ID`, `general_error`, `general_justification`, `serious_error`, `serious_justification`, `overtime_hours`, `overtime_justification`, `score`, `final_comment`,`entry_by`,`week`,`year`) VALUES ("'.$_GET['id'].'", "'.$general_mistake.'", "'.$general_justification.'", "'.$serious_mistake.'", "'.$serious_justification.'", "'.$over_time.'", "'.$overtime_justification.'", "'.$score.'", "'.$notes.'", "'.$_SESSION['employee_selected'].'","'.$_SESSION['week_name'].'","'.date('Y').'")';
		
		db_query($insert);
		
		$task_total = find_a_field('kpi_task_details','sum(point)','PBI_ID="'.$_GET['id'].'" and year="'.date('Y').'" and week="'.$_SESSION['week_name'].'"');
		$log_total = find_a_field('kpi_log_sheet_details','sum(point)','PBI_ID="'.$_GET['id'].'" and year="'.date('Y').'" and week="'.$_SESSION['week_name'].'"');
		$error_total = find_a_field('kpi_error_overtime_details','sum(score)','PBI_ID="'.$_GET['id'].'" and year="'.date('Y').'" and week="'.$_SESSION['week_name'].'"');
		$total_score = ($task_total+$log_total)-$error_total;
		
		switch($total_score){
						   
						    case $total_score>=90:
							    $grade = 'A';
								 break;
								 
						    case $total_score>=80 && $grade<90:
							  $grade = 'B';
							   break;
							   
							   
							   case $total_score>=70 && $grade<80:
							   $grade = 'C';
							   break;
							   
							   case $total_score>=60 && $grade<70:
							   $grade = 'D';
							   break;
							   
							   case $total_score>=1 && $grade<60:
							   $grade = 'F';
							   break;
							   
							   default:
							     $grade = ' ';
						   
						   }
		
	    $final = 'INSERT INTO `kpi_final_score` (`PBI_ID`, `WEEK`, `GRADE`, `SCORE`,`YEAR`) VALUES ("'.$_GET['id'].'", "'.$_SESSION['week_name'].'", "'.$grade.'", "'.$total_score.'","'.date('Y').'")';
		db_query($final);
		
		
		//Mail function start
		  
		  $str.='<table width="50%" border="0" cellspacing="0" cellpadding="0" style="font-family:cambria;">';
		  $str.= '<tr align="left">';
            $str.= '<td colspan="2">Your KPI result is</td>';
		  $str.= '</tr>';
		  $str.= '</table>';
		  
		  
		  $str.='<table width="50%" border="1" cellspacing="0" cellpadding="0" style="font-family:cambria;">';
		  $str.= '<tr align="center" style="background:#00CCFF;">';
            $str.= '<td colspan="2">'.$_SESSION['week_name'].'</td>';
		  $str.= '</tr>';
		  
		  $str.= '<tr align="center">';
		    $str.= '<td>Daily Task</td>';
            $str.= '<td>'.$task_total.'</td>';
          $str.= '</tr>';
		  
		  $str.= '<tr align="center">';
		    $str.= '<td>Weekly Task</td>';
            $str.= '<td>'.$log_total.'</td>';
          $str.= '</tr>';
		  
		  $str.= '<tr align="center">';
		    $str.= '<td>Errors</td>';
            $str.= '<td>'.$error_total.'</td>';
          $str.= '</tr>';
		  
		  $str.= '<tr align="center">';
		    $str.= '<td>Total Score</td>';
            $str.= '<td>'.$total_score.'</td>';
          $str.= '</tr>';
		  
		  $str.= '<tr align="center">';
		    $str.= '<td>Grade</td>';
            $str.= '<td>'.$grade.'</td>';
          $str.= '</tr>';
		  
		  $str.= '</table>';

$mail = find_a_field('personnel_basic_info','PBI_EMAIL','PBI_ID="'.$_GET['id'].'"');
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$to = $mail.',bimolerp@gmail.com,tanvir@aksidcorp.com';
$subject = "Weekly KPI Report";
$headers .= "From: AKSID HUMAN RESOURCES<hr@aksidcorp.com>";
mail($to,$subject,$str,$headers);
		
		//Mail function end
		
		$_SESSION['week_name']=' ';
		
		echo '<script type="text/javascript">parent.parent.document.location.href = "kpi_view.php";</script>';
		
			
	}
	
	if($_GET['del']>0)
	{
	
			
			
			$del = 'delete from kpi_log_sheet where task_id="'.$_GET['del'].'"';
			db_query($del);
			
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

	 <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>tinymce.init({selector:'textarea'});</script>
  
  <script>
     function cal(){
	    var gm = parseInt(document.getElementById('general_mistake').value);
		var sm = parseInt(document.getElementById('serious_mistake').value);
		var ot = parseInt(document.getElementById('over_time').value);
		
		 
		 if(gm>0){
		    gmm = gm;
		 }else{
		 gmm = 0;
		 }
		 
		 if(sm>0){
		    smm = sm;
		 }else{
		 smm = 0;
		 }
		 
		 if(ot>0){
		    ott = ot;
		 }else{
		 ott = 0;
		 }
		 
		 var gm_deduct = gmm*3;
		 var sm_deduct = smm*10;
		 var ot_score = ott*1;
		 
		 var total_score = (gm_deduct+sm_deduct)-ot_score;
		 
		 document.getElementById('score').value = total_score;
		 
	 
	 }
  </script>
	
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
					    <td align="center" style="background:<?=$color?>; border-radius: 5px; color: #fff;">Step-1</td>
						<td align="center" style="background:<?=$color?>; border-radius: 5px; color: #fff;">Step-2</td>
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
        
            
                <? echo $sl; //include('../../common/input_bar.php'); ?>
                
                  
                    
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
		   
	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Weekly Error & Overtime Report</div></td>
	   </tr>
	   
	   </table><br />
	   <table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
	   
      </table><br />
       <table width="100%" border="1" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
		<tr height="30" style="background:#00CCFF">
		  <td width="10%"><div align="center"><strong>SL</strong></div></td>
		  <td width="30%"><div align="center"><strong>No. of errors for the followings</strong></div></td>
		  <td width="15%"><div align="center"><strong>Number of errors</strong></div></td>
		  <td width="40%"><div align="center"><strong>Justification Note</strong></div></td>
		  
		 </tr>
	 
	 
	    <tr height="30">
		  <td width="10%"><div align="center"><strong>1</strong></div></td>
		  <td width="30%"><div align="center">General Mistakes</div></td>
		  <td width="15%"><div align="center"><strong><input type="text" name="general_mistake" id="general_mistake" style="width: 95%;border-radius: 0px;height: 40px;margin-top: 1%;" onchange="cal()" /></strong></div></td>
		  <td width="40%"><div align="center"><strong><input type="text" name="general_justification" style="width:95%;height: 38px;margin-top: 2px;"></div></td>
		 </tr>
		 
		 <tr height="30">
		  <td width="10%"><div align="center"><strong>2</strong></div></td>
		  <td width="30%"><div align="center">Serious errors/ mistakes</div></td>
		  <td width="15%"><div align="center"><strong><input type="text" name="serious_mistake" id="serious_mistake" style="width: 95%;border-radius: 0px;height: 40px;margin-top: 1%;" onchange="cal()"  /></strong></div></td>
		  <td width="40%"><div align="center"><strong><input type="text" name="serious_justification" style="width:95%;height: 38px;margin-top: 2px;"></div></td>
		 </tr>
		 
		 <tr height="30">
		  <td width="10%"><div align="center"><strong>3</strong></div></td>
		  <td width="30%"><div align="center">Overtime Hours</div></td>
		  <td width="15%"><div align="center"><strong><input type="text" name="over_time" id="over_time" style="width: 95%;border-radius: 0px;height: 40px;margin-top: 1%;" onchange="cal()"  /></strong></div></td>
		  <td width="40%"><div align="center"><strong><input type="text" name="overtime_justification" style="width:95%;height: 38px;margin-top: 2px;"></div></td>
		 </tr>
	  
	    </table><br />
		<table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
			<tr>
			
			   <td colspan="9"><div align="center"><strong>Total Error Deduction:</strong> <input type="text" name="score" value="0" id="score" style="width: 15%; border-radius: 0px; height: 40px;border-color:#337AB7;" /></div></td>
			</tr>
	 
	
</table><br />
		
		<table width="100%" border="1" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
           <tr>
		   
	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Notes</div></td>
	   </tr>
	   
	   </table><br />
		
		<table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
			<tr>
			   <td colspan="9"><div align="center"><textarea name="notes"></textarea></div></td>
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