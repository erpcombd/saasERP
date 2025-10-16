<?php
    





require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




	
	$type = $_GET['type'];
	$PBI_ID = $_GET['PBI_ID'];
    $year = $_GET['year'];
     
?>


  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
 <tr style="font-weight:bold;">
    <td colspan="4" align="center">Leave Details</td>
    
  </tr>
   <?
       $basic = 'select p.PBI_ID, p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,(select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation  from personnel_basic_info p where p.PBI_ID="'.$PBI_ID.'"';
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
    <td>Leave Type</td>
    <td>Start Date</td>
    <td>End Date</td>
    <td>Totaly Days</td>
  </tr>
  <?php
    $sql = 'select * from hrm_leave_info where 1 and type='.$type.' and PBI_ID="'.$PBI_ID.'" and year="'.$year.'"';
	$query = db_query($sql);
	 while($data = mysqli_fetch_object($query)){
	  $total_days =0;
	   //$total_days = $total_days+$data['total_days'];
	 
  ?>
  <tr>
    <?
	  if($data->type=='Short Leave (SHL)'){
	?>
    <td>Short Leave (SHL)</td>
	<td><?php echo $data->s_time?></td>
    <td><?php echo $data->e_time ?></td>
   
   <? }else{?>	
    <td><?php echo find_a_field('hrm_leave_type','leave_type_name','id='.$data->type) ?></td>
    <td><?php echo date('d-M-Y',strtotime($data->s_date)) ?></td>
    <td><?php echo date('d-M-Y',strtotime($data->e_date)) ?></td>
	<? } ?>
    <td><?php echo $data->total_days ?></td>
  </tr>
  <?php } ?>
  </tbody>
</table>



