<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$page_id = 35;

function auto_dropdown($sql){
$res=db_query($sql);
while($data=mysqli_fetch_row($res)){
if($value==$data[0])
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
else
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}}

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#start_date');
do_calander('#end_date');
$PBI_ID = $_POST['PBI_ID'];




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

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view"><form action="?"  method="post">
<table width="100%" border="0" class="oe_list_content"><thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Single Attendance  Report (After IN OUT Process) </span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>

  <tr  class="alt">
    <td width="37%" align="right"><strong>Employee Code  :</strong></td><td colspan="3" align="left">
	<!--<input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" required value="<?=$_POST['PBI_ID']?>" />-->
	<select name="PBI_ID" id="PBI_ID" required>
      <option>
        <? if(isset($_POST['PBI_ID'])){ echo $_POST['PBI_ID']; }else{echo''; } ?>
        </option>
      <?php 
	auto_dropdown("select PBI_ID,concat(PBI_ID,'-',PBI_NAME) from personnel_basic_info 
	where PBI_ORG='".$_SESSION['user']['group']."' and PBI_JOB_STATUS='In Service' 
	and JOB_LOCATION not in('1')"); ?>
    </select></td>
    </tr>
	  <tr >
    <td align="right"><strong>Start Date  :</strong></td>
    <td width="9%" align="left">
	<input type="text" name="start_date" id="start_date" style="width:100px;" required 
	value="<? if(isset($_POST['start_date'])){ echo $_POST['start_date']; }else{echo date('Y-m-01'); } ?>" /></td>
	
    <td width="16%" align="right"><strong>End Date   :</strong></td>
    <td width="38%">
	<input type="text" name="end_date" id="end_date" style="width:100px;" required 
	 value="<? if(isset($_POST['end_date'])){ echo $_POST['end_date']; }else{echo date('Y-m-25'); } ?>"/></td>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><table width="1%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><input name="create" type="submit" id="create" value="Show Report" /></td>
    </tr>
  </table>
    </th>
</tr>

  </tbody></table></form>
<br /><? if($_POST['PBI_ID']>0){

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$begin = new DateTime($start_date);
$end = new DateTime($end_date);
$end->modify('+1 day');

$startTime = $days1=mktime(1,1,1,date('m',strtotime($start_date)),26,date('y',strtotime($start_date)));

$endTime = $days2=mktime(1,1,1,date('m',strtotime($end_date)),25,date('y',strtotime($end_date)));

$days_mon=($endTime - $startTime)/(3600*24);

for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
$day   = date('l',$i);
${'day'.date('N',$i)}++;

//if(isset($$day))
//$$day .= ',"'.date('Y-m-d', $i).'"';
//else
//$$day .= '"'.date('Y-m-d', $i).'"';
}


$ab="SELECT 
a.PBI_NAME as name,
c.group_name as company,
desi.DESG_DESC as designation, 
d.DEPT_DESC as department,
j.LOCATION_NAME ,a.PBI_DOMAIN as section,a.employee_type,a.grace_type
FROM 
personnel_basic_info a, 
user_group c, 
department d, 
designation desi,
office_location j 
WHERE 
a.PBI_ORG=c.id and 
a.PBI_DEPARTMENT=d.DEPT_SHORT_NAME and 
a.PBI_DESIGNATION=desi.DESG_SHORT_NAME and 
a.JOB_LOCATION = j.ID and
a.PBI_ID='".$_POST['PBI_ID']."'";
$abb = db_query($ab);
$pbi=mysqli_fetch_object($abb);
?>
<div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>


<tr><td colspan="4">

<span id="id_view"></span>          

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Name: </td>
    <td>&nbsp;<?=$pbi->name?></td>
    <td>Company:</td>
    <td>&nbsp;<?=$pbi->company?>,<?=$pbi->LOCATION_NAME?></td>
  </tr>

  <tr>
    <td>Designation:</td>
    <td>&nbsp;<?=$pbi->designation?></td>
    <td>Department:</td>
    <td>&nbsp;<?=$pbi->department?>  (Section: <?=$pbi->section?>)</td>
  </tr>
    <tr>
    <td>Roster Type:</td>
    <td><?=$pbi->employee_type?></td>
    <td>Grace Type:</td>
    <td><?=$pbi->grace_type?></td>
  </tr>
</table></td></tr>
<tr class="oe_list_header_columns">
  <th colspan="4" style="text-align:center"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="grp">
   <thead> <tr bgcolor="#CCCCCC">
      <th><div align="center" class="style2">Date</div></th>
      <th><div align="center" class="style2">Day</div></th>
      <th>Sch-IN</th>
      <th>Sch-Out</th>
      <th><div align="center" class="style2">IN</div></th>
      <th><span class="style2">OUT</span></th>
      <th><span class="style2">Grace</span></th>
      <th>LBG</th>
      <th>LAG</th>
      <th>Status</th>
      </tr></thead>
	  <? 



$sql  = 'select office_start_time,office_end_time,r.roster_date att_date,s.schedule_type,s.schedule_name from hrm_roster_allocation r,hrm_schedule_info s where r.shedule_1=s.id and PBI_ID="'.$PBI_ID.'" and  roster_date between "'.$start_date.'" and "'.$end_date.'" order by roster_date asc';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sch[$data->att_date]['sch_name'] = $data->schedule_name;
$val[$data->att_date]['sch_in_time'] = $data->office_start_time;
$val[$data->att_date]['sch_out_time'] = $data->office_end_time;
}


$sql  = 'select iom_sl_no,leave_id,leave_duration,att_date from hrm_att_summary2 where emp_id="'.$PBI_ID.'" and  att_date between "'.$start_date.'" and "'.$end_date.'" and (iom_sl_no>0 or leave_id>0) order by att_date asc';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
if($data->iom_sl_no>0)
$sch[$data->att_date]['iom'] = $data->iom_sl_no;
if($data->leave_id>0)
$sch[$data->att_date]['leave'] = $data->leave_id;
}


$sql  = 'select * from hrm_att_summary2 where emp_id="'.$PBI_ID.'" and  att_date between "'.$start_date.'" and "'.$end_date.'" order by att_date asc';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$val[$data->att_date]['in_time'] = $data->in_time;
$val[$data->att_date]['out_time'] = $data->out_time;



$val[$data->att_date]['iom'] = $data->iom_sl_no	;
$val[$data->att_date]['leave'] = $data->leave_id;
$val[$data->att_date]['dayname'] = $data->dayname;

if($data->late_min>0)
$val[$data->att_date]['late_status'] = 'LATE';
$val[$data->att_date]['final_late_min'] = $data->final_late_min;
$val[$data->att_date]['late_min'] = $data->late_min;
$val[$data->att_date]['final_late_status'] = $data->final_late_status;
$val[$data->att_date]['grace_no'] = $data->grace_no;
$val[$data->att_date]['holyday'] = $data->holyday;


}



$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
//echo $off_day;
foreach ( $period as $dt ){
++$days;



$this_date = $dt->format( "Ymd" );

$day_date = $dt->format( "Y-m-d" );


//$holysql = "select 1 from salary_holy_day where holy_day = '".$day_date."'";
//$holy_query = db_query($holysql);
//$holy = mysqli_fetch_row($holy_query);
//
//
//

if($sch[$day_date]['leave']>0)
$val[$day_date]['final_status'] = 'HALF-LEAVE';
elseif($sch[$day_date]['iom']>0)
$val[$day_date]['final_status'] = 'IOM';



elseif($sch[$day_date]['sch_name']=='Leave')
$val[$day_date]['final_status'] = 'LEAVE';

elseif($sch[$day_date]['sch_name']=='LWP')
$val[$day_date]['final_status'] = 'LWP';

elseif($sch[$day_date]['sch_name']=='Compensatory Leave')
$val[$day_date]['final_status'] = 'Compensatory Leave';

elseif($sch[$day_date]['sch_name']=='Shift Change')
$val[$day_date]['final_status'] = 'Shift Change';

elseif($sch[$day_date]['sch_name']=='Offday')
$val[$day_date]['final_status'] = 'OFFDAY';

elseif($sch[$day_date]['sch_name']=='Holiday')
$val[$day_date]['final_status'] = 'HOLIDAY';

$ydate = date('Y-m-d',(strtotime($day_date) + 86400));


$in = $day_date.' '.$val[$day_date]['sch_in_time'];

if($val[$day_date]['sch_in_time']<$val[$day_date]['sch_out_time'])
$out = $day_date.' '.$val[$day_date]['sch_out_time'];
else 
$out = $ydate.' '.$val[$day_date]['sch_out_time'];





if($val[$day_date]['final_status']=='')
{
if($val[$day_date]['sch_in_time']=='00:00:00'||$val[$day_date]['sch_out_time']=='00:00:00'||$val[$day_date]['sch_in_time']==''||$val[$day_date]['sch_out_time']=='')
$val[$day_date]['final_status']='NO SCH';
elseif($val[$day_date]['in_time']==''||$val[$day_date]['out_time']=='')
$val[$day_date]['final_status']='ABSENT';
elseif($val[$day_date]['out_time']<$out)
$val[$day_date]['final_status']='EARLY';

elseif($val[$day_date]['in_time']>$in)
$val[$day_date]['final_status']='LATE';
else
$val[$day_date]['final_status']='REGULAR';
}


if($val[$day_date]['final_status']=='ABSENT')
{$text_color = '#D476B7';} 
elseif($val[$day_date]['final_status']=='EARLY')
{$text_color = '#ed173b';} 
elseif($val[$day_date]['final_status']=='LEAVE')
{$text_color = '#E36BEA';} 
elseif($val[$day_date]['final_status']=='HALF-LEAVE')
{$text_color = 'tomato';} 
elseif($val[$day_date]['final_status']=='LATE')
{$text_color = 'Red';} 
elseif($val[$day_date]['final_status']=='NO SCH')
{$text_color = '#E2DC21';} 

else {$text_color = 'Black';}

//if($val[$day_date]['final_status']=='ABSENT')
//$bgcolor = 'RED';
//elseif($val[$day_date]['final_status']=='LEAVE')
//$bgcolor = '#FFCCCC';
//if($val[$day_date]['final_status']=='Compensatory Leave'){
//$bgcolor = '#FF00CC';
//$val[$day_date]['final_status']='CL';}
//elseif($val[$day_date]['final_status']=='OFFDAY')
//$bgcolor = 'Blue';
//elseif($val[$day_date]['final_status']=='EARLY')
//$bgcolor = 'ASH';
//
//elseif($val[$day_date]['final_status']=='IOM')
//$bgcolor = 'Yellow';
//elseif($val[$day_date]['final_status']=='LATE')
//{$bgcolor = 'Orange';}
//elseif($val[$day_date]['final_status']=='REGULAR')
//{$bgcolor = 'GREEN';}
//elseif($val[$day_date]['final_status']=='NO SCH')
//{$bgcolor = 'White';}
?>
    <tr bgcolor="<?=$bgcolor?>"; style="border: 1px solid #333333;"}>
      <td><?=$dt->format( "Y-m-d" );?></td>
      <td><?=$dt->format("l");?></td>
      <td><?=$val[$day_date]['sch_in_time'];?></td>
      <td><?=$val[$day_date]['sch_out_time'];?></td>
      <td><?=$val[$day_date]['in_time'];?></td>
      <td><?=$val[$day_date]['out_time'];?></td>
      <td><?=($val[$day_date]['grace_no']>0&&$val[$day_date]['iom']==0)?$val[$day_date]['grace_no']:'';?></td>
      <td><?=($val[$day_date]['iom']==0&&$val[$day_date]['late_min']>0)?$val[$day_date]['late_min']:'';?></td>
      <td><?=($val[$day_date]['iom']==0&&$val[$day_date]['final_late_min']>0)?$val[$day_date]['final_late_min']:'';?></td>
      <td style="color:<?=$text_color;?>"><?=$val[$day_date]['final_status'];?></td>
      </tr>
<? }?>
    <tr bgcolor="#FFFFFF">
      <td colspan="10"><br /></td>
    </tr>
  </table>
  </th>
  </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>
  </tbody>
</table>
  </div><? }?></div></div>
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