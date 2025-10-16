<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$page_id = 36;
check_access($page_id);
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#start_date');

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
<th colspan="2"><span style="text-align: center; font-size:18px; color:#09F">Summary Attendance Report </span></th>
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
<td align="right"><span class="oe_form_group_cell_label oe_form_group_cell"><strong>Attendance Status </strong></span><strong> : </strong></td>
<td align="left"><span class="oe_form_group_cell">
<select name="status">
<option value="<?=$_POST['status']?>"><?=$_POST['status']?></option>
<option value="Regular">Regular</option>
<option value="Late">Late</option>
<option value="Absent">Absent</option>
</select>
</span></td>
</tr>
<tr >
<td align="right"><strong>Attendance Date  :</strong></td>
<td align="left"><input type="text" name="start_date" id="start_date" value="<?=$_POST['start_date']?>" style="width:100px;" required="required" /></td>
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
$PBI_DEPARTMENT = $_POST['PBI_DEPARTMENT'];

if($PBI_DEPARTMENT>0)
$con = ' and PBI_DEPARTMENT = "'.$PBI_DEPARTMENT.'"';


?></td>
</tr>
<tr class="oe_list_header_columns">
  <th colspan="4" style="text-align:center"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="grp">
    <tr>
      <th colspan="10" bgcolor="#333333"><span class="style2">Attendance Date: 
        <?=$start_date?>
      </span></th>
    </tr>
    <tr>
      <th colspan="10" bgcolor="#333333"><span class="style2">Company Name : 
        <?=find_a_field('domai','DOMAIN_DESC','DOMAIN_CODE='.$PBI_DOMAIN);?>
      </span></th>
      </tr>
    <tr>
      <th colspan="10" bgcolor="#FFFFFF">&nbsp;</th>
      </tr>
    <tr>
      <th bgcolor="#333333"><span class="style2">CODE</span></th>
      <th bgcolor="#333333"><div align="center" class="style2">Name</div></th>
      <th bgcolor="#333333"><span class="style2">Designation</span></th>
      <th bgcolor="#333333"><div align="center" class="style2">Status</div></th>
      <th bgcolor="#333333"><span class="style2">Office Time</span></th>
      <th bgcolor="#333333"><div align="center" class="style2">IN</div></th>
      <th bgcolor="#333333"><div align="center" class="style2">Late(min)</div></th>
      <th bgcolor="#333333"><div align="center" class="style2">Out</div></th>
      <th bgcolor="#333333"><span class="style2">Early(min)</span></th>
      <th bgcolor="#333333"><div align="center" class="style2">OFF</div></th>
      </tr>
<? 

$sql="SELECT a.PBI_NAME as name,a.PBI_ID, b.DOMAIN_DESC as company_name,a.PBI_DEPARTMENT,d.DESG_DESC,a.off_day,a.office_time 
FROM personnel_basic_info a, domai b, designation d WHERE 
a.special_attendence = 0 and 
a.PBI_DESIGNATION=d.DESG_ID and a.PBI_DOMAIN=b.DOMAIN_CODE and a.PBI_DOMAIN='".$PBI_DOMAIN."' ".$con." 
order by PBI_DEPARTMENT,a.PBI_ID";
$query = db_query($sql);
$date = date('Ymd',strtotime($start_date));
while($data=mysqli_fetch_object($query)){
if($data->office_time==2){

$info['out_time'][$date]=0;
$info['out_stamp'][$date]=0;
$info['out_time'][$date]=0;
$earlytime = 0;

$info['access_date'][$date]=$date;
$info['access_time'][$date]=$date;
$info['access_stamp'][$date]=0;
$info['start_time'][$date]=0;
$info['end_time'][$date]=0;
$info['off_day'][$date]=0;

$in_time = date('H:i:s',$access->access_stamp);

$info['status'][$date]='Regular';$info['bgcolor'][$date] = '#EAFFEF';++$regular;


$info['off_day'][$date]=$access->off_day;


++$days;
$department = $data->PBI_DEPARTMENT;}
else{

$latetime = 0;
$s = 'select id,access_date,access_time,access_stamp,start_time,end_time,off_day from hrm_inout where employee_id="'.$data->PBI_ID.'" and  access_date = "'.$start_date.'" order by access_stamp asc';
$access = find_all_field_sql($s);

$s = 'select access_date,id,access_time,access_stamp,end_time from hrm_inout where  employee_id="'.$data->PBI_ID.'" and  access_date = "'.$start_date.'" order by access_stamp desc';
$out = find_all_field_sql($s);

$info['out_stamp'][$date]=0;
$earlytime = 0;
if($access->id!=$out->id)
{
$info['out_time'][$date]=$out->access_time;
$info['out_stamp'][$date]=strtotime($out->access_time);
$info['out_time'][$date]=$out->end_time;

$earlytime = (int)((strtotime($out->access_date.' '.$out->end_time) - $out->access_stamp)/60);
}
$info['access_date'][$date]=$access->access_date;
$info['access_time'][$date]=$access->access_time;
$info['access_stamp'][$date]=strtotime($access->access_time);
$info['start_time'][$date]=$access->start_time;
$info['end_time'][$date]=$access->end_time;
$info['off_day'][$date]=$access->off_day;

$in_time = date('H:i:s',$access->access_stamp);
if(date('N',$access->access_stamp)==$access->off_day)
{$info['status'][$date] ='Off Day';$info['bgcolor'][$date] = '#FFF';++$off_day;}
elseif($access->start_time==''&&$access->access_stamp>0)
{$info['status'][$date]='Regular';$info['bgcolor'][$date] = '#EAFFEF';++$regular;}
elseif($access->access_stamp>0){
$latetime = (int)(($access->access_stamp - strtotime($access->access_date.' '.$access->start_time))/60);
if($latetime>0) 
{++$late;$info['status'][$date]='Late';$info['bgcolor'][$date] = '#FFFFCC';} else 
{++$regular;$info['status'][$date]='Regular';$info['bgcolor'][$date] = '#EAFFEF';}}
else
{$info['status'][$date] ='Absent';$info['bgcolor'][$date] = '#FFECFF';++$absent;}

$info['off_day'][$date]=$access->off_day;


++$days;
$department = $data->PBI_DEPARTMENT;
}
	  ?>

	  
	  <? if($_POST['status']!=''){if($_POST['status']==$info['status'][$date]){
	  ?>
	  	<? if($old_department!=$department){?>
	<tr bgcolor="<?=$info['bgcolor'][$date]?>">
		<td colspan="10" bgcolor="#33FF99">&nbsp;&nbsp;&nbsp;DEMARTMENT NAME: <?=find_a_field('department','DEPT_DESC','DEPT_ID='.$department)?></td>
	</tr>
	<? } $old_department = $data->PBI_DEPARTMENT; ?>
    <tr bgcolor="<?=$info['bgcolor'][$date]?>">
      <td><?=$data->PBI_ID;?></td>
      <td><?=$data->name;?></td>
      <td><?=$data->DESG_DESC;?></td>
      <td><?=$info['status'][$date];?></td>
      <td>
	  <? 
	  
	  $ddd = strtotime($data->access_date.' '.$info['start_time'][$date]);
      $ddd1 = (int)$ddd-600;
	  if($info['status'][$date]=='Absent')echo '-'; else{?>
	  <?='IT-'.date('h:iA',$ddd1).'<Br>OT-'.date('h:iA',strtotime($data->access_date.' '.$info['end_time'][$date]));?>
	  <? }?>
	  </td><td><?=($info['access_stamp'][$date]!=0)?date('h:i A',$info['access_stamp'][$date]):'';?></td>
      <td><?=($latetime>0)?(($latetime)):'';?></td>
      <td><?=($info['out_stamp'][$date]!=0)?date('h:i:sA',$info['out_stamp'][$date]):'';?></td>
      <td><?=($earlytime!=0)?$earlytime:'';?></td>
      <td><?=date('l',mktime(1,1,1,1,$info['off_day'][$date],2001));?></td>
    </tr>
<? }}else {?>	<? if($old_department!=$department){?>
	<tr bgcolor="<?=$info['bgcolor'][$date]?>">
		<td colspan="10" bgcolor="#33FF99">&nbsp;&nbsp;&nbsp;DEMARTMENT NAME: <?=find_a_field('department','DEPT_DESC','DEPT_ID='.$department)?></td>
	</tr>
	<? } $old_department = $data->PBI_DEPARTMENT; ?><tr bgcolor="<?=$info['bgcolor'][$date]?>">
      <td><?=$data->PBI_ID;?></td>
      <td><?=$data->name;?></td>
      <td><?=$data->DESG_DESC;?></td>
      <td><?=$info['status'][$date];?></td>
      <td>
	  <? $ddd = strtotime($data->access_date.' '.$info['start_time'][$date]);
      $ddd1 = (int)$ddd-600;
	  if($info['status'][$date]=='Absent')echo '-'; else{?>
	  <?='IT-'.date('h:iA',$ddd1).'<Br>OT-'.date('h:iA',strtotime($data->access_date.' '.$info['end_time'][$date]));?>
	  <? }?>
	  </td>
      <td><?=($info['access_stamp'][$date]!=0)?date('h:i:sA',$info['access_stamp'][$date]):'';?></td>
      <td><?=($latetime>0)?(($latetime)):'';?></td>
      <td><?=($info['out_stamp'][$date]!=0)?date('h:i:sA',$info['out_stamp'][$date]):'';?></td>
      <td><?=($earlytime!=0)?$earlytime:'';?></td>
      <td><?=date('l',mktime(1,1,1,1,$data->off_day,2001));?></td>
    </tr> <? }}?>
  </table>
  <br />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th bgcolor="#666666"><div align="center" class="style2">Total Employee </div></th>
        <th bgcolor="#006600"><div align="center" class="style2">Regular</div></th>
        <th bgcolor="#FFCC00"><div align="center" class="style2">Late</div></th>
        <th bgcolor="#FF3300"><div align="center" class="style2">Absent</div></th>
        <th bgcolor="#5FAFAF"><div align="center" class="style2">Off Day </div></th>
        </tr>

      <tr >
        <td bgcolor="#CCCCCC"><div align="center">
          <?=$days;?>
        </div></td>
        <td bgcolor="#33FF00"><div align="center">
          <?=$regular;?>
        </div></td>
        <td bgcolor="#FFFF99"><div align="center">
          <?=$late;?>
        </div></td>
        <td bgcolor="#FF9966"><div align="center">
            <?=$absent;?>
        </div></td>
        <td bgcolor="#99CCCC"><div align="center">
          <?=($off_day*1);?>
        </div></td>
        </tr>
		<? }?>
    </table></th>
  </tr>
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