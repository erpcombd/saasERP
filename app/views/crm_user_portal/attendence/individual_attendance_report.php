<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once "../sms_function.php";
$page_id = 35;

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
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Payroll Calculation Report </span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>

  <tr  class="alt">
    <td width="37%" align="right"><strong>Employee Code  :</strong></td><td colspan="3" align="left"><input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" required value="<?=$_POST['PBI_ID']?>" /></td>
    </tr>
	  <tr >
    <td align="right"><strong>Start Date  :</strong></td>
    <td width="9%" align="left">
	<input type="text" name="start_date" id="start_date" style="width:100px;" required 
	value="<? if(isset($_POST['start_date'])){ echo $_POST['start_date']; }else{echo date('Y-m-01'); } ?>" /></td>
	
    <td width="16%" align="right"><strong>End Date   :</strong></td>
    <td width="38%">
	<input type="text" name="end_date" id="end_date" style="width:100px;" required 
	value="<? if(isset($_POST['end_date'])){ echo $_POST['end_date']; }else{echo date('Y-m-25'); } ?>" /></td>
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
j.LOCATION_NAME
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
    <td>&nbsp;<?=$pbi->department?></td>
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



$sql  = 'select * from hrm_att_summary where emp_id="'.$PBI_ID.'" and  att_date between "'.$start_date.'" and "'.$end_date.'" order by att_date asc';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$val[$data->att_date]['in_time'] = $data->in_time;
$val[$data->att_date]['out_time'] = $data->out_time;

$val[$data->att_date]['sch_in_time'] = $data->sch_in_time;
$val[$data->att_date]['sch_out_time'] = $data->sch_out_time;

$val[$data->att_date]['sch_in'] = $data->att_date.' '.$data->sch_in_time;
$val[$data->att_date]['sch_out'] = $data->att_date.' '.$data->sch_out_time;

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

if($data->leave_id>0)
$val[$data->att_date]['final_status'] = 'LEAVE';
elseif($data->holyday>0)
$val[$data->att_date]['final_status'] = 'HOLYDAY';
elseif($data->dayname=='Friday')
$val[$data->att_date]['final_status'] = 'OFFDAY';
elseif($data->iom_sl_no>0)
$val[$data->att_date]['final_status'] = 'IOM';
elseif($val[$data->att_date]['out_time']<$val[$data->att_date]['sch_out'])
$val[$data->att_date]['final_status'] = 'EARLY';
elseif($data->final_late_status>0||$data->final_late_min>0)
$val[$data->att_date]['final_status'] = 'LATE';
elseif($data->id>0)
$val[$data->att_date]['final_status'] = 'REGULAR';
}



$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
//echo $off_day;
foreach ( $period as $dt ){
++$days;



$this_date = $dt->format( "Ymd" );

$day_date = $dt->format( "Y-m-d" );


$holysql = "select 1 from salary_holy_day where holy_day = '".$day_date."'";
$holy_query = db_query($holysql);
$holy = mysqli_fetch_row($holy_query);

$val[$day_date]['grace_no'];

if($val[$day_date]['final_status']=='LEAVE')
$bgcolor = '#FFCCCC';
if($holy>0){
$bgcolor = '#FF00CC';
$val[$day_date]['final_status']='HOLYDAY';}
elseif($dt->format("l")=='Friday')
{$bgcolor = '#CCCCCC';$off_days++;}


elseif($dt->format("l")=='Friday') {$bgcolor = '#CCCCCC'; $off_days++;}
elseif($val[$day_date]['final_status']=='IOM') $bgcolor = '#9966CC';
elseif($val[$day_date]['final_status']=='EARLY') $bgcolor = '#FF6666';
elseif($val[$day_date]['final_status']=='LATE') {$bgcolor = '#FFFF99'; $late++;$late_min_total = $late_min_total + $val[$day_date]['final_late_min'];}
elseif($val[$day_date]['final_status']=='REGULAR'){$bgcolor = '#66CC66'; $regular++;}
else{$bgcolor = '#FF6666';$regular++;$absent++;}

?>
    <tr bgcolor="<?=$bgcolor?>">
      <td><?=$dt->format( "Y-m-d" );?></td>
      <td><?=$dt->format("l");?></td>
      <td><?=$val[$day_date]['sch_in_time'];?></td>
      <td><?=$val[$day_date]['sch_out_time'];?></td>
      <td><?=$val[$day_date]['in_time'];?></td>
      <td><?=$val[$day_date]['out_time'];?></td>
      <td><?=($val[$day_date]['grace_no']>0&&$val[$day_date]['iom']==0)?$val[$day_date]['grace_no']:'';?></td>
      <td><?=($val[$day_date]['iom']==0&&$val[$day_date]['late_min']>0)?$val[$day_date]['late_min']:'';?></td>
      <td><?=($val[$day_date]['iom']==0&&$val[$day_date]['final_late_min']>0)?$val[$day_date]['final_late_min']:'';?></td>
      <td><?=$val[$day_date]['final_status'];?></td>
      </tr>
<? }?>
    <tr bgcolor="#FFFFFF">
      <td colspan="10"><br />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th bgcolor="#666666"><div align="center" class="style2">Total Days </div></th>
        <th bgcolor="#CC6666"><div align="center" class="style2">Off Day</div></th>
        <th bgcolor="#006600"><div align="center" class="style2">Regular</div></th>
        <th bgcolor="#FF3300"><div align="center" class="style2">Absent</div></th>
        <th bgcolor="#FFCC00"><div align="center" class="style2">Late Days</div></th>
        <th bgcolor="#336699">Late Min</th>
        <th bgcolor="#336699">Penalty Slab</th>
        <th bgcolor="#336699"><div align="center" class="style2">Penalty </span></th>
      </tr>

      <tr >
        <td bgcolor="#CCCCCC"><div align="center">
          <?=$days;?>
        </div></td>
        <td align="center" bgcolor="#CC99CC"><div align="center"><?=$off_days;?></div>
          <div align="center"></div></td>
        <td bgcolor="#33FF00"><div align="center">
          <?=$regular;?>
        </div></td>
        <td bgcolor="#FF9966"><div align="center">
          <?=$absent;?>
        </div></td>
        <td bgcolor="#FFFF99"><div align="center">
            <?=$late;?>
        </div></td>
        <td bgcolor="#33CCFF"><?=$late_min_total?></td>
        <td bgcolor="#33CCFF"><? $late_day_p = (int)($late/3); $late_min_p = (int)($late_min_total/30); if($late_min_p>$late_day_p) echo $late_min_p; else echo $late_day_p;?></td>
        <td bgcolor="#33CCFF"><div align="center"><? if($late_min_p>$late_day_p) echo $late_min_p*.5; else echo $late_day_p*.5;?></div></td>
      </tr>
    </table></td>
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
  </div><? 
  
// SMS Send
if($_POST['PBI_ID']=='1867'){
$dest_addr='8801711763169';
$sms_text = 'Single Attendance View from '.$_POST['start_date'].' to '.$_POST['end_date'].' by id:'.$_SESSION['user']['id'];
gpsms('SAJEEBGROUP',$dest_addr,$sms_text);
}  
  
  
  }?></div></div>
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