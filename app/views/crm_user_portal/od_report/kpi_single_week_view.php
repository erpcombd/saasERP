<?php

//

//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


  $pbi_id = $_GET['PBI_ID'];
  $weeks= $_GET['week'];
  $week = str_replace('_',' ',$weeks);
  $year = $_GET['year'];

$_GET['id'] =  $pbi_id;
$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_GET['id'].'"');
$reporting = find_a_field('essential_info','ESSENTIAL_REPORTING','PBI_ID="'.$employee->PBI_ID.'"');
$reporting_data = find_all_field('personnel_basic_info','','PBI_ID="'.$reporting.'"');

?><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

<thead><tr><td style="border:0px; font-family:bank gothic; font-size:20px; font-weight:bold;" colspan="11" align="center"></td></tr>
<tr><td style="border:0px;font-family:bank gothic; font-size:25px; font-weight:bold;" colspan="11" align="center">AKSID CORPORATION LIMITED</td></tr>
<tr><td style="border:0px;font-family:cambria; font-size:18px;" colspan="11" align="center">Key Performance Indicator (KPI) Weekly Report</td></tr>
</thead></table><br />
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
<thead>
<tr><td style="border:0px;font-family:cambria; font-size:12px;" colspan="11" align="right">&nbsp;&nbsp;Reporting Time : <?=date('d-M-Y h:i:s a')?></td></tr>
</thead></table>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr height="60">
		  <td style=" border-bottom:0px; border-right:0px; border-left:0px;">
		    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-family:cambria;">
			
			<tr>
			   <td style="font-size:16px; padding:2px;"> ID NO : <strong><?=$employee->PBI_ID?></strong></td>
			   <td style="padding:2px; font-size:14px;">Name : <strong><?=$employee->PBI_NAME?></strong>  </td>
			    <td style="padding:2px; font-size:14px;">Designation :  <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></strong></td>
				<td rowspan="3">
				<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
				   <tr>
				      <td colspan="2" align="center"><strong><?=$week?></strong></td>
					 
				   </tr>
				   <tr>
				      <td>Daily Task</td>
					  <td><?=number_format($daily_task = find_a_field('kpi_task_details','sum(point)','PBI_ID="'.$pbi_id.'" and week="'.$week.'" and year="'.$year.'"'),2);?></td>
				   </tr>
				   <tr>
				      <td>Weekly Task</td>
					  <td><?=number_format($weekly_task = find_a_field(' kpi_log_sheet_details','sum(point)','PBI_ID="'.$pbi_id.'" and week="'.$week.'" and year="'.$year.'"'),2);?></td>
				   </tr>
				   <tr>
				      <td>Errors</td>
					  <td>(<?=number_format($error = find_a_field('kpi_error_overtime_details','score','PBI_ID="'.$pbi_id.'" and week="'.$week.'" and year="'.$year.'"'),2);?>)</td>
				   </tr>
				   <tr>
				      <td>Total Score</td>
					  <td><?=number_format($total_score = ($daily_task+$weekly_task)-$error,2) ;?></td>
				   </tr>
				   <tr>
				      <td>Grade</td>
					  <td>
					     <?
						  
						   $grade = $total_score;
						    if($grade>0){
						   switch($grade){
						   
						    case $grade>=90:
							    echo 'A';
								 break;
								 
						    case $grade>=80 && $grade<90:
							  echo 'B';
							   break;
							   
							   case $grade>=80 && $grade<90:
							   echo 'B';
							   break;
							   
							   case $grade>=70 && $grade<80:
							   echo 'C';
							   break;
							   
							   case $grade>=60 && $grade<70:
							   echo 'D';
							   break;
							   
							   case $grade>=1 && $grade<60:
							   echo 'F';
							   break;
							   
							   default:
							     echo ' ';
						   
						   }
						   }
						 ?>
					  </td>
				   </tr>
				</table>
				</td>
			</tr>
			
			<tr>
			   <td style="padding:2px; font-size:14px;">Department :  <strong><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></strong></td>
			   <td style="padding:2px; font-size:14px;"> Project Name :  <strong><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></strong> </td>
			    <td style="padding:2px; font-size:14px;">Joining Date :  <strong><?=date('d-M-Y',strtotime($employee->PBI_DOJ))?></strong></td>
				
			</tr>
			
			
			 <tr>
			   <td style="padding:2px; font-size:14px;">KPI Authorised Person: <strong><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$reporting_data->PBI_ID.'"');?></strong></td>
			  
			   <td style="padding:2px; font-size:14px;">Designation of Authorised Person : <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$reporting_data->PBI_DESIGNATION);?></strong></td>
			   <td style="font-size:14px;">Service Length : <strong><?php
										  
		  $interval = date_diff(date_create(date('Y-m-d')), date_create($employee->PBI_DOJ));
		echo $interval->format("%Y Year, %M Months, %d Days");
		  ?></strong></td>
			   
			</tr>
			</table>
		  </td>
		   
	 </tr>
	 
	
			
	 
	
</table><br />



<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="padding:0px;">
           <tr>
		   
	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;font-family:cambria;">Daily Task</div></td>
	   </tr>
	   
	   </table>
	  
       <table width="100%"  cellspacing="0" border="1" cellpadding="0" align="center" style="padding:0px; font-family:cambria;">
		
	 
	  <?
	    $ssql = 'select d.*,t.task_name from kpi_task_details d,kpi_task t where t.task_id=d.task_id and d.week="'.$week.'" and d.PBI_ID="'.$_GET['id'].'" and d.year="'.$year.'"';
		$qr = db_query($ssql);
		 $count = find_a_field('kpi_task','count(PBI_ID)','PBI_ID="'.$_GET['id'].'" and week="'.$week.'" and year="'.$year.'"');
		 $per_row = 40/$count;
		 $per_row_column = $per_row/6;
		while($task_data=mysqli_fetch_object($qr)){
		  
		  
		
	  ?>
	 
	  <tr>
	      <td colspan="9" style="background:#edf5ef"><div align="center" style="font-size:16px; font-weight:bold;"><?=$task_data->task_name?></div></td>
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
		 
		   
	 </tr>
	  <tr>
	     
		  <td><div align="center"><?=$task_data->saturday?></div></td>
		  <td><div align="center"><?=$task_data->sunday?></div></td>
		  <td><div align="center"><?=$task_data->monday?></div></td>
		  <td><div align="center"><?=$task_data->tuesday?></div></td>
		  <td><div align="center"><?=$task_data->wednesday?></div></td>
		  <td><div align="center"><?=$task_data->thursday?></div></td>
		  <td><div align="center"><?=$task_data->friday?></div></td>
		  <td><div align="center"><?=$task_data->point?></div></td>
		   
		   
	 </tr>
	 
	 <? } ?>
	 
	
           <tr>
		   
	      <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">Total Score : <?=number_format($daily_task,2)?></div></td>
	   </tr>
	   
	  
	    </table><br />
		
		<table width="100%"  cellspacing="0" cellpadding="0" border="0" align="center" style="padding:0px;font-family:cambria;">
           <tr>
		   
	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Weekly Log Sheet</div></td>
	   </tr>
	   
	   </table>
		<table width="100%" cellspacing="0" border="1" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">
		<tr height="30" style="background:#00CCFF">
		  <td width="5%"><div align="center"><strong>SL</strong></div></td>
		  <td width="60%"><div align="center"><strong>Description</strong></div></td>
		  <td width="10%"><div align="center"><strong>Submitted</strong></div></td>
		  <td width="10%"><div align="center"><strong>Documentary evidence</strong></div></td>
		  <td width="10%"><div align="center"><strong>Documents</strong></div></td>
		 
		   
		 </tr>
	 
	  <?
	    $ssql = 'select d.*,t.task_name from kpi_log_sheet_details d,kpi_log_sheet t where d.week="'.$week.'" and d.log_id=t.task_id and d.PBI_ID="'.$_GET['id'].'" and d.year="'.$year.'"';
		$qr = db_query($ssql);
		
		while($task_data=mysqli_fetch_object($qr)){
	  ?>
	 <tr>
		  <td width="5%"><div align="center"><strong><?=++$i?></strong></div></td>
		  <td width="60%"><div align="left"><?=$task_data->task_name?></div></td>
		  <td width="10%"><div align="center"><?=$task_data->submitted?></div></td>
		  <td width="10%"><div align="center"><?=$task_data->documentart_evidence?></div></td>
		  <td width="10%"><div align="center"><? if($task_data->att_file!=''){?><a href="../../pic/kpi_log/<?=$task_data->att_file?>" target="_blank">Attachment</a><? } ?></div></td>
		 
		 
		 </tr>
	  
	 
	  
	
	 <? } ?>
	  <tr>
		   
	      <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">Total Score : <?=number_format($weekly_task,2)?></div></td>
	   </tr>
	  </table><br />
	 
	 <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="padding:0px;font-family:cambria;">
           <tr>
		   
	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Weekly Error & Overtime Report</div></td>
	   </tr>
	   
	  
	  
	    </table>
		
		<?
		  $ss = 'select * from kpi_error_overtime_details where PBI_ID="'.$_GET['id'].'" and week="'.$week.'" and year="'.$year.'"';
		  $qq = db_query($ss);
		  $data = mysqli_fetch_object($qq);
		?>
		
		<table width="100%" cellspacing="0" border="1" cellpadding="0" align="center" style="padding:0px;font-family:cambria;">
		<tr height="30" style="background:#00CCFF">
		  <td width="10%"><div align="center"><strong>SL</strong></div></td>
		  <td width="30%"><div align="center"><strong>No. of errors for the followings</strong></div></td>
		  <td width="15%"><div align="center"><strong>Number of errors</strong></div></td>
		  <td width="40%"><div align="center"><strong>Justification Note</strong></div></td>
		  
		 </tr>
	 
	 
	    <tr height="30">
		  <td width="10%"><div align="center"><strong>1</strong></div></td>
		  <td width="30%"><div align="center">General Mistakes</div></td>
		  <td width="15%"><div align="center"><?=$data->general_error?></div></td>
		  <td width="40%"><div align="center"><?=$data->general_justification?></div></td>
		 </tr>
		 
		 <tr height="30">
		  <td width="10%"><div align="center"><strong>2</strong></div></td>
		  <td width="30%"><div align="center">Serious errors/ mistakes</div></td>
		  <td width="15%"><div align="center"><strong><?=$data->serious_error?></strong></div></td>
		  <td width="40%"><div align="center"><?=$data->serious_justification?></div></td>
		 </tr>
		 
		 <tr height="30">
		  <td width="10%"><div align="center"><strong>3</strong></div></td>
		  <td width="30%"><div align="center">Overtime Hours</div></td>
		  <td width="15%"><div align="center"><?=$data->overtime_hours?></div></td>
		  <td width="40%"><div align="center"><?=$data->overtime_justification?></div></td>
		 </tr>
	    <tr>
		   
	      <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">Total Error Deductions : <?=number_format($error,2)?></div></td>
	   </tr>
	    </table><br />
		
		<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="padding:5px;font-family:cambria;">
		 <tr style="background:#337AB7; color:#FFFFFF;">
		  
	      <td colspan="9" align="center"><div align="center" style="font-size:16px; font-weight:bold;">Notes :</div></td>
	   </tr>
           <tr>
		  
	      <td colspan="9"><strong><?=$data->final_comment?></strong></td>
	   </tr>
	   
	  
	  
	    </table><br />
		
	
</div>



<br><br><br>


