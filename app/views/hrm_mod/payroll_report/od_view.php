<?php
    
 session_start();

require "../../config/inc.all.php";

require "../../classes/report.class.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');
	
	$od_id = $_GET['od_id'];
	$od_info = find_all_field('hrm_od_info','','id="'.$od_id.'"');
	
     
?>


  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
 <tr style="font-weight:bold;">
    <td colspan="4" align="center" style="text-decoration:underline">OD Details</td>
    
  </tr>
   <?
       $basic = 'select p.PBI_ID, p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,(select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation  from personnel_basic_info p where p.PBI_ID="'.$od_info->PBI_ID.'"';
	$basic_query = db_query($basic);
	 $basic_data = mysqli_fetch_object($basic_query);
   ?>
  <tr style="font-weight:bold; padding:10px;">
   
    <td style=""><span><?=$basic_data->PBI_NAME?> [<?=$basic_data->PBI_ID?>]</span></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr style="font-weight:bold;">
   
    <td><span><?=$basic_data->designation?></span></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	
  </tr>
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr style="font-weight:bold;">
   
    <td><span"><?=$basic_data->department?></span></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	
  </tr>
  
  
  </tbody>
</table>
<br />
   
   <table width="50%" border="1" align="center" cellpadding="0" cellspacing="0" style="text-align:center">
   <tbody>
   
   
   
  
  <tr style="font-weight:bold;">
    <td>OD Type</td>
    <td>Od Date</td>
    <td>Start Time</td>
    <td>End Time</td>
	<td>Tota Hours</td>
	<td>Purpose</td>
  </tr>
  <?php
     $sql = 'select o.*,t.type from hrm_od_info o, hrm_od_type t where o.type=t.id and o.id="'.$od_id.'"';
	$query = db_query($sql);
	 while($data = mysqli_fetch_object($query)){
	  $total_days =0;
	   //$total_days = $total_days+$data['total_days'];
	 
  ?>
  <tr>
    
    <td><?=$data->type?></td>
    <td><?=date('d-M-Y',strtotime($data->s_date))?></td>
    <td><?=$data->s_time?>&nbsp;<?=$data->s_time_format?></td>
    <td><?=$data->e_time?>&nbsp;<?=$data->e_time_format?></td>
	<td><?=$data->total_hrs?>&nbsp;Hours</td>
	<td align="left"><?=$data->reason?>&nbsp;</td>
  </tr>
  <?php } ?>
  </tbody>
</table>



