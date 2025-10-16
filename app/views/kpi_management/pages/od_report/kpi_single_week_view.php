<?php



session_start();



ob_start();



require "../../config/inc.all.php";





  $pbi_id = $_GET['PBI_ID'];

  $months= $_GET['mon'];

  $mon = str_replace('_',' ',$months);

  $year = $_GET['year'];



$_GET['id'] =  $pbi_id;

$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_GET['id'].'"');

$reporting = find_a_field('essential_info','ESSENTIAL_REPORTING','PBI_ID="'.$employee->PBI_ID.'"');

$reporting_data = find_all_field('personnel_basic_info','','PBI_ID="'.$reporting.'"');



?>



<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">



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

				<?php /*?>   <tr>

				      <td>Daily Task</td>

					  <td><?=number_format($daily_task = find_a_field('kpi_task_details','sum(point)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"'),2);?></td>

				   </tr><?php */?>

				   <tr>

				      <td>Weekly Task</td>

					  <td><?=number_format($weekly_task = find_a_field(' kpi_log_sheet_details','sum(point)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"'),2);?></td>

				   </tr>

				   <tr>

				      <td>Errors</td>

					  <td>(<?=number_format($error = find_a_field('kpi_error_overtime_details','sum(score)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"'),2);?>)</td>

				   </tr>

				   <tr>

				      <td>Over Time</td>

					  <td><?=number_format($error = find_a_field('kpi_error_overtime_details','sum(overtime)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"'),2);?></td>

				   </tr>

				  <tr>

				      <td>Total Score</td>

					  <td><?=number_format(find_a_field('kpi_final_score','sum(SCORE)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"'),2);?></td>

				   </tr>

				   <tr>

				      <td>Grade</td>

					  <td>

					      <?  //=find_a_field('kpi_final_score','GRADE','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"');
						  
						  
						  
						  
						  
						  
						  
						  	$total_score=find_a_field('kpi_final_score','sum(SCORE)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"');

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

                                echo  $grade ;

						  
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

	 

	

			

	 

	

</table>


<br />







		
		<table width="100%" cellspacing="0" border="1" cellpadding="0" align="center" style="padding:0px;font-family:cambria;">

           <tr>



	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Weekly Log Sheet (Week 1)</div></td>

	   </tr>



	   </table>

	<table width="100%" cellspacing="0" border="1" cellpadding="0" align="center" style="padding:0px;font-family:cambria;">

		<tr height="30" style="background:#00CCFF">

		  <td width="5%"><div align="center"><strong>SL</strong></div></td>

		  <td width="60%"><div align="center"><strong>Description</strong></div></td>

		  <td width="10%"><div align="center"><strong>Submitted</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documentary evidence</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documents</strong></div></td>





		 </tr>



	  <?

	    $ssql = 'select d.*,t.task_name from kpi_log_sheet_details d,kpi_log_sheet t where
			d.mon="'.$mon.'" and d.log_id=t.task_id and d.PBI_ID="'.$_GET['id'].'" and d.week="Week 1" and d.year="'.$year.'" ';

		$qr = mysql_query($ssql);
		
		
		


	

	



		while($task_data=mysql_fetch_object($qr)){

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


  <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">
		Total Score :<?=number_format($weekly_task1 = find_a_field(' kpi_log_sheet_details','sum(point)','PBI_ID="'.$pbi_id.'" and week="Week 1" and  mon="'.$mon.'" and year="'.$year.'"'),2);?>
	</div></td>

	   </tr>

	  </table>


		<br />



				<table width="100%" cellspacing="0" border="1" cellpadding="0" align="center" style="padding:0px;font-family:cambria;">

		           <tr>



			      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Week 2</div></td>

			   </tr>



			   </table>

				<table width="100%" cellspacing="0" border="1" cellpadding="0" align="center" style="padding:0px;font-family:cambria;">

				<tr height="30" style="background:#00CCFF">

				  <td width="5%"><div align="center"><strong>SL</strong></div></td>

				  <td width="60%"><div align="center"><strong>Description</strong></div></td>

				  <td width="10%"><div align="center"><strong>Submitted</strong></div></td>

				  <td width="10%"><div align="center"><strong>Documentary evidence</strong></div></td>

				  <td width="10%"><div align="center"><strong>Documents</strong></div></td>





				 </tr>



			  <?

			    $ssql = 'select d.*,t.task_name from kpi_log_sheet_details d,kpi_log_sheet t where
					d.mon="'.$mon.'" and d.point>0 and d.log_id=t.task_id and d.PBI_ID="'.$_GET['id'].'" and d.week="Week 2" and d.year="'.$year.'" ';

				$qr = mysql_query($ssql);



				while($task_data=mysql_fetch_object($qr)){

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


		  <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">
			Total Score :<?=number_format($weekly_task1 = find_a_field(' kpi_log_sheet_details','sum(point)','PBI_ID="'.$pbi_id.'" and week="Week 2" and  mon="'.$mon.'" and year="'.$year.'"'),2);?>
			</div></td>

			   </tr>

			  </table>


				<br />



				<table width="100%"  cellspacing="0" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">
				 <tr><td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Week 3</div></td></tr>

				</table>


		<table width="100%" cellspacing="0" border="1" cellpadding="0" align="center" style="padding:0px;font-family:cambria;">

		<tr height="30" style="background:#00CCFF">

		  <td width="5%"><div align="center"><strong>SL</strong></div></td>

		  <td width="60%"><div align="center"><strong>Description</strong></div></td>

		  <td width="10%"><div align="center"><strong>Submitted</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documentary evidence</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documents</strong></div></td>





		 </tr>



	  <?

	    $ssql = 'select d.*,t.task_name from kpi_log_sheet_details d,kpi_log_sheet t where
			d.mon="'.$mon.'" and d.point>0 and d.log_id=t.task_id and d.PBI_ID="'.$_GET['id'].'" and d.week="Week 3" and d.year="'.$year.'" ';

		$qr = mysql_query($ssql);



		while($task_data=mysql_fetch_object($qr)){

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



	      <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">
			Total Score :<?=number_format($weekly_task1 = find_a_field(' kpi_log_sheet_details','sum(point)','PBI_ID="'.$pbi_id.'" and week="Week 3" and  mon="'.$mon.'" and year="'.$year.'"'),2);?>
				</div></td>

	   </tr>

	  </table>


<br />



<table width="100%"  cellspacing="0" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">
 <tr><td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Week 4</div></td></tr>

</table>

		<table width="100%" cellspacing="0" border="1" cellpadding="0" align="center" style="padding:0px;font-family:cambria;">

		<tr height="30" style="background:#00CCFF">

		  <td width="5%"><div align="center"><strong>SL</strong></div></td>

		  <td width="60%"><div align="center"><strong>Description</strong></div></td>

		  <td width="10%"><div align="center"><strong>Submitted</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documentary evidence</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documents</strong></div></td>





		 </tr>



	  <?

	    $ssql = 'select d.*,t.task_name from kpi_log_sheet_details d,kpi_log_sheet t where
			d.mon="'.$mon.'" and d.point>0 and d.log_id=t.task_id and d.PBI_ID="'.$_GET['id'].'" and d.week="Week 4" and d.year="'.$year.'" ';

		$qr = mysql_query($ssql);



		while($task_data=mysql_fetch_object($qr)){

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


  <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">
			Total Score :<?=number_format($weekly_task1 = find_a_field(' kpi_log_sheet_details','sum(point)','PBI_ID="'.$pbi_id.'" and week="Week 4" and  mon="'.$mon.'" and year="'.$year.'"'),2);?>

	</div></td>

	   </tr>

	  </table>

	
	
	
	
	
	
	
	
	<br />

	 

	 <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="padding:0px;font-family:cambria;">

           <tr>

		   

	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Weekly Error & Overtime Report</div></td>

	   </tr>

	   

	  

	  

	    </table>

		

		<?
		  
		  
		  	  $ss = 'select sum(general_error) as general_error,general_justification,sum(serious_error) as serious_error,serious_justification,sum(overtime_hours) as overtime_hours,
			overtime_justification,sum(score) as score

			 from kpi_error_overtime_details where PBI_ID="'.$_GET['id'].'" and mon="'.$mon.'" and year="'.$year.'"';

		  $qq = mysql_query($ss);

		  $data = mysql_fetch_object($qq);

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

		  <td width="15%"><div align="center"><?=$data->serious_error?></div></td>

		  <td width="40%"><div align="center"><?=$data->serious_justification?></div></td>

		 </tr>

		 

		 <tr height="30">

		  <td width="10%"><div align="center"><strong>3</strong></div></td>

		  <td width="30%"><div align="center">Overtime Hours</div></td>

		  <td width="15%"><div align="center"><?=$data->overtime_hours?></div></td>

		  <td width="40%"><div align="center"><?=$data->overtime_justification?></div></td>

		 </tr>

	    <tr>

		   

	      <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">Total Error Deductions : <?=number_format($data->score,2)?></div></td>

	   </tr>

	    <tr>

		   

	      <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">Total Over Time Marks : <?=number_format($data->overtime_hours,2)?></div></td>

	   </tr>
	   
	   
	   <tr>
<td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">Total Monthly Score :
	<?=number_format(find_a_field('kpi_final_score','sum(SCORE)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"'),2);?> </div></td>
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





