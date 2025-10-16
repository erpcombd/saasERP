<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$page_id = 37;
check_access($page_id);
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#start_date');
do_calander('#end_date');

function find_brief_attendence($PBI_ID,$start_date,$end_date)
{
$sqls = 'select id,access_date,access_time,access_stamp,start_time,end_time,off_day from hrm_inout where employee_id="'.$PBI_ID.'" and  access_date between "'.$start_date.'" and "'.$end_date.'" group by access_date order by access_date asc';
$querys = db_query($sqls);
$datas = mysqli_fetch_object($querys);


$sql = 'select id,access_date,access_time,access_stamp,start_time,end_time,off_day from hrm_inout where employee_id="'.$PBI_ID.'" and  access_date between "'.$start_date.'" and "'.$end_date.'" group by access_date order by access_date asc';
$query = db_query($sql);

while($data=mysqli_fetch_object($query)){

	$date = date('Ymd',strtotime($data->access_time));
	$info['access_date'][$date] = $data->access_date;
	$info['access_time'][$date]=$data->access_time;
	$info['access_stamp'][$date]=strtotime($data->access_time);
	$info['start_time'][$date]=$data->start_time;
	$info['end_time'][$date]=$data->end_time;
	$info['off_day'][$date]=$data->off_day;
	$in_time = date('H:i:s',$info['access_stamp'][$date]);
	//$out_time = date('H:i:s',$out->access_stamp);

	if(date('N',$info['access_stamp'][$date])==$datas->off_day)++$off_day;
	elseif($data->start_time == '')	++$regular; 

	else						{$info['late'][$date] = (int)(($data->access_stamp - strtotime($data->access_date.' '.$data->start_time))/60);
	
	if($info['late'][$date]>0) 	++$late; 
	else 						++$regular; 
	}
	
}

$all['regular'] = $regular;
$all['late'] = $late;
return $all;
}
?>
<style type="text/css">
<!--
.style2 {color: #FFFFFF; }
-->
</style>




<div class="oe_view_manager oe_view_manager_current">
        
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
<form action="?"  method="post">
<table width="100%" border="0" class="oe_list_content"><thead>
<tr class="oe_list_header_columns">
<th colspan="2"><span style="text-align: center; font-size:18px; color:#09F">Brief Attendance Report </span></th>
</tr>
<tr class="oe_list_header_columns">
<th colspan="2"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
</tr>
</thead><tfoot>
</tfoot><tbody>

<tr  class="alt">
<td width="37%" align="right"><strong>Company Name   :</strong></td>
<td align="left"><span class="oe_form_group_cell">
<select name="PBI_DOMAIN" required="required">
<? foreign_relation('domai','DOMAIN_CODE','DOMAIN_DESC',$_POST['PBI_DOMAIN']);?>
</select>
</span></td>
</tr>
<tr >
<td align="right"><span class="oe_form_group_cell_label oe_form_group_cell"><strong>Department</strong></span><strong> Name : </strong></td>
<td align="left"><span class="oe_form_group_cell">
<select name="PBI_DEPARTMENT">
<? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['PBI_DEPARTMENT']);?>
</select>
</span></td>
</tr>

<tr >
<td align="right"><strong>Attendance Date  :</strong></td>
<td align="left"><input type="text" name="start_date" id="start_date" value="<?=$_POST['start_date']?>" style="width:100px;" required="required" />
to  <input type="text" name="end_date" id="end_date" value="<?=$_POST['end_date']?>" style="width:100px;" required="required" /></td>
</tr>
<tr >
<td colspan="2" align="right"><div align="center">
<input name="create" type="submit" id="create" value="Show Report" />
</div></td>
</tr>
</tbody></table>
</form>
<br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
									  <tr>
										<td>
<form action="ShowForPrint.php" method="post" name="form_print" target="_blank" id="form_print" onsubmit='$("#datatodisplay1").val( $("<div>").append( $("#grp").eq(0).clone() ).html() )'>
  <input  type="image" src="../images/print.png" width="26" height="26" style="width:26px; height:26px;">
  <input type="hidden" id="datatodisplay1" name="datatodisplay1" />
  <input type="hidden" id="page_title" name="page_title" value="<?=$title?>" />
  <input type="hidden" id="report_detail" name="report_detail" value="<?=$report_detail?>" />
</form></td>
									  </tr>
									</table>
    </th>
</tr>
<? if($_POST['PBI_DOMAIN']>0){?>
<tr><td colspan="4">
<? 
$PBI_DOMAIN = $_POST['PBI_DOMAIN'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$PBI_DEPARTMENT = $_POST['PBI_DEPARTMENT'];
$days = ((int)((strtotime($end_date) - strtotime($start_date))/(60*60*24)))+1;
if($PBI_DEPARTMENT>0)
$con = ' and PBI_DEPARTMENT = "'.$PBI_DEPARTMENT.'"';


?></td>
</tr>
<tr class="oe_list_header_columns">
  <th colspan="4" style="text-align:center"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="grp">
    <tr>
      <th colspan="7" bgcolor="#333333"><span class="style2">Attendance Date: 
        <?=$start_date?>
      </span></th>
    </tr>
    <tr>
      <th colspan="7" bgcolor="#333333"><span class="style2">Company Name : 
        <?=find_a_field('domai','DOMAIN_DESC','DOMAIN_CODE='.$PBI_DOMAIN);?>
      </span></th>
      </tr>
    <tr>
      <th colspan="7" bgcolor="#FFFFFF">&nbsp;</th>
      </tr>
    <tr>
      <th bgcolor="#333333"><span class="style2">CODE</span></th>
      <th bgcolor="#333333"><div align="center" class="style2">Name</div></th>
      <th bgcolor="#333333"><span class="style2">Designation</span></th>
      <th bgcolor="#333333"><span class="style2">Regular</span></th>
      <th bgcolor="#333333"><div align="center" class="style2">Late</div></th>
      <th bgcolor="#333333"><div align="center" class="style2">Absent</div></th>
      <th bgcolor="#333333"><div align="center" class="style2">Total days </div></th>
      </tr>
<? 

$sql="SELECT a.PBI_NAME as name,a.PBI_ID, b.DOMAIN_DESC as company_name,a.PBI_DEPARTMENT,d.DESG_DESC,a.off_day,a.office_time 
FROM personnel_basic_info a, domai b, designation d WHERE a.special_attendence = 0 and  a.PBI_DESIGNATION=d.DESG_ID and a.PBI_DOMAIN=b.DOMAIN_CODE and a.PBI_DOMAIN='".$PBI_DOMAIN."' ".$con." 
order by PBI_DEPARTMENT,a.PBI_ID";
$query = db_query($sql);
$date = date('Ymd',strtotime($start_date));
while($data=mysqli_fetch_object($query)){
$all = find_brief_attendence($data->PBI_ID,$start_date,$end_date);
$department = $data->PBI_DEPARTMENT;

if($old_department!=$department){?>
	<tr>
		<td colspan="7" bgcolor="#33FF99">&nbsp;&nbsp;&nbsp;DEMARTMENT NAME: <?=find_a_field('department','DEPT_DESC','DEPT_ID='.$department)?></td>
	</tr>
	<? } $old_department = $data->PBI_DEPARTMENT; ?><tr  bgcolor="<?=((++$i%2)?'#CCFFCC':'');?>">
      <td><?=$data->PBI_ID;?></td>
      <td><?=$data->name;?></td>
      <td><?=$data->DESG_DESC;?></td>
      <td><?=$all['regular'];?></td>
      <td><?=$all['late'];?></td>
      <td><?=$days - ($all['regular']+$all['late']);?></td>
      <td><?=$days;?></td>
    </tr> <? }?>
  </table>
  <br />
    </th>
  </tr>
  <? }?>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>
    </tbody>
</table>
  </div></div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
    </div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>