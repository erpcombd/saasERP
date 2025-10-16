<?php
session_start();
ob_start();
require_once "../../config/inc.all.php";
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#start_date');
do_calander('#end_date');

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

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view"><form action=""  method="post">
<table width="100%" border="0" class="oe_list_content"><thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Individial Attendance Report </span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>

  <tr  class="alt">
    <td width="37%" align="right"><strong>Employee Code  :</strong></td><td colspan="3" align="left"><input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" required /></td>
    </tr>
	  <tr >
    <td align="right"><strong>Start Date  :</strong></td>
    <td width="9%" align="left"><input type="text" name="start_date" id="start_date" style="width:100px;" required /></td>
    <td width="16%" align="right"><strong>End Date   :</strong></td>
    <td width="38%"><input type="text" name="end_date" id="end_date" style="width:100px;" required /></td>
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
<br /><div style="text-align:center"><div class="print_box">	
						
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
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
									</div>
<table width="100%" class="oe_list_content" id="grp">
  <thead>

<? if($_POST['PBI_ID']>0){?>
<tr><td colspan="4">
<? 
$PBI_ID = $_POST['PBI_ID'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$begin = new DateTime($start_date);
$end = new DateTime($end_date);
$end->modify('+1 day');

$ab="SELECT a.PBI_NAME as name, b.DOMAIN_DESC as company_name, c.DEPT_DESC as department, d.DESG_DESC as designation,off_day FROM personnel_basic_info a, domai b, department c, designation d WHERE a.PBI_DOMAIN=b.DOMAIN_CODE and a.PBI_DEPARTMENT=c.DEPT_ID and a.PBI_DESIGNATION=d.DESG_ID and a.PBI_ID='".$_POST['PBI_ID']."'";
$data=mysql_query($ab);
$emp=mysql_fetch_object($data);
?>
<span id="id_view">
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="50" bgcolor="#006600"><div align="center" class="style2">
  <p>ATTENDANCE REPORT</p>
  <p>DATE INTERVAL : <?=$_POST['start_date']?> AND <?=$_POST['end_date']?></p>
</div></td>
</tr>
<tr>
<td><div align="center"><img src="../../pic/staff/<?php echo $_POST['PBI_ID'];?>.jpg" width="190" height="191" /></div></td>
</tr>
<tr>
<td><div align="center" class="cell_fonts_grant_total style7"><strong><em>Employee Code  : <?php echo $_POST['PBI_ID'];?></em></strong></div></td>
</tr>
<tr>
<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->name." (".$emp->designation.")";?> </em></strong></div></td>
</tr><tr>
<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->department.", ".$emp->company_name;?> </em></strong></div></td>
</tr>
</table>
</span>          

</td></tr>
<tr class="oe_list_header_columns">
  <th colspan="4" style="text-align:center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th bgcolor="#333333"><div align="center" class="style2">Date</div></th>
      <th bgcolor="#333333"><div align="center" class="style2">Day</div></th>
      <th bgcolor="#333333"><div align="center" class="style2">Status</div></th>
      <th bgcolor="#333333"><div align="center" class="style2">Office Time</div></th>
      <th bgcolor="#333333"><div align="center" class="style2">IN</div></th>
      <th bgcolor="#333333"><div align="center" class="style2">Late(min)</div></th>
      <th bgcolor="#333333"><span class="style2">OUT</span></th>
      <th bgcolor="#333333"><span class="style2">Early(min)</span></th>
      <th bgcolor="#333333"><div align="center" class="style2">Off Day </div></th>
      </tr>
	  <? 

$sql = 'select id,access_date,access_time,access_stamp,start_time,end_time,off_day from hrm_inout where employee_id="'.$PBI_ID.'" and  access_date between "'.$start_date.'" and "'.$end_date.'" group by access_date order by access_stamp desc';
$query = mysql_query($sql);
while($data=mysql_fetch_object($query)){
$s = 'select access_date,id,access_time,access_stamp,end_time from hrm_inout where employee_id="'.$PBI_ID.'" and  access_date = "'.$data->access_date.'" order by access_stamp desc limit 1';
$out = find_all_field_sql($s);
	$date = date('Ymd',$data->access_stamp);
	$info['access_date'][$date] = $data->access_date;
	$info['access_time'][$date]=$data->access_time;
	$info['access_stamp'][$date]=$data->access_stamp;
	$info['start_time'][$date]=$data->start_time;
	$info['end_time'][$date]=$data->end_time;
	$info['off_day'][$date]=$data->off_day;
	$info['out_time'][$date]=$out->access_time;
	$info['out_stamp'][$date]=$out->access_stamp;
	$in_time = date('H:i:s',$data->access_stamp);
	//$out_time = date('H:i:s',$out->access_stamp);

	if(date('N',$info['access_stamp'][$date])==$data->off_day)
	{$info['status'][$date] ='Off Day';$info['bgcolor'][$date] = '#FFF';++$off_day;}
	elseif($data->start_time == '')	{$info['status'][$date]='Regular'; $info['bgcolor'][$date] = '#EAFFEF'; ++$regular; }

	else						{$info['late'][$date] = (int)(($data->access_stamp - strtotime($data->access_date.' '.$data->start_time))/60);
	
	if($info['late'][$date]>0) 	{++$late; $info['status'][$date]='Late'; $info['bgcolor'][$date] = '#FFFFCC'; } 
	else 						{++$regular; $info['status'][$date]='Regular'; $info['bgcolor'][$date] = '#EAFFEF'; }
	}
	$info['off_day'][$date] = $data->off_day;
	$off_date = date('l',mktime(1,1,1,1,$info['off_day'][$date],2001));
}
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ( $period as $dt ){
++$days;
$thisdate = $dt->format( "Ymd" );

if($info['access_stamp'][$thisdate]=='')
{
	if(date('N',$info['access_stamp'][$thisdate])==$data->off_day)
	{$info['status'][$thisdate] ='Off Day';$info['bgcolor'][$thisdate] = '#FFF';++$off_day;}
	else {$info['status'][$thisdate] ='Absent';$info['bgcolor'][$thisdate] = '#FFECFF';++$absent;}
}
if($dt->format("l")==$off_date)
{
$info['status'][$thisdate] ='Off Day';$info['bgcolor'][$thisdate] = '#FFF';++$off_day;
}
	  ?>
    <tr bgcolor="<?=$info['bgcolor'][$thisdate]?>">
      <td><?=$dt->format( "Y-m-d" );?></td>
      <td><?=$dt->format("l");?></td>
      <td><?=$info['status'][$thisdate];?></td>
      <td><?='IT-'.date('h:i:sA',strtotime($data->access_date.' '.$info['start_time'][$date])).'<Br>OT-'.date('h:i:sA',strtotime($data->access_date.' '.$info['end_time'][$date]));?></td>
      <td><?=($info['access_stamp'][$thisdate]!=0)?date('h:i:s A',$info['access_stamp'][$thisdate]):'';?></td>
      <td><?=($info['late'][$thisdate]>0)?(($info['late'][$thisdate])):'';?></td>
      <td><?=($info['out_stamp'][$thisdate]!=0)?date('h:i:s A',$info['out_stamp'][$thisdate]):'';?></td>
      <td><?=($earlytime!=0)?$earlytime:'';?></td>
      <td><?=$off_date;?></td>
    </tr>
<? }?>
  </table>
  <br />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th bgcolor="#666666"><div align="center" class="style2">Total Days </div></th>
        <th bgcolor="#006600"><div align="center" class="style2">Regular</div></th>
        <th bgcolor="#FFCC00"><div align="center" class="style2">Late</div></th>
        <th bgcolor="#FF3300"><div align="center" class="style2">Absent</div></th>
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
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>