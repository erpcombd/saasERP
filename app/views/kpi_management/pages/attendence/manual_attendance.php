<?php
session_start();
ob_start();
require_once "../../config/inc.all.php";
do_calander('#m_date');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
$table='hrm_inout';
$unique='id';

if(isset($_POST['search']))
{		
$emp_id=$_POST['PBI_ID'];
$access_date=$a_date=$_POST['m_date'];
$c_date=explode('-',$a_date);
$access_time=$a_date.' '.$_POST['m_hr'].':'.$_POST['m_min'].':'.'00';
$access_stamp=mktime($_POST['m_hr'],$_POST['m_min'],0,$c_date[1],$c_date[2],$c_date[0]);
$sch = find_all_field_sql('select p.off_day,s.office_start_time,s.office_end_time from personnel_basic_info p, hrm_schedule_info s where p.PBI_ID="'.$emp_id.'" and p.office_time=s.id');
	
	$date = date('Ymd',$access_stamp);
	if(date('N',$access_stamp)==$sch->off_day) $info['status'][$date]=0;
	else{
	if($sch->office_start_time == '')	$info['status'][$date]=1;
	else								{$info['late'][$date] = (int)(($access_stamp - strtotime($access_date.' '.$sch->office_start_time))/60);
	
	if($info['late'][$date]>0) 	$info['status'][$date]=2;
	else 						$info['status'][$date]=1;
	}}


$sql="INSERT INTO `hrm_inout` (
`employee_id` ,
card_no,
`access_date` ,
`access_time` ,
`access_stamp` ,
`user` ,
`status`,off_day,start_time,end_time )
VALUES ('$emp_id', '$data[3]', '$access_date','$access_time', '$access_stamp', '$user1', '".$info['status'][$date]."','$sch->off_day', '$sch->office_start_time', '$sch->office_end_time')";
$query=mysql_query($sql);
		}
?>


<style type="text/css">
<!--
.style1 {font-size: 24px}
.style2 {
	color: #FFFFFF;
	font-size: 24px;
	font-weight: bold;
}
-->
</style>


<div class="oe_view_manager oe_view_manager_current">
        <form action=""  method="post">

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
            <table width="80%" border="1" align="center">
              <tr>
                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Manual Attendance </div></td>
                </tr>
              <tr>
                <td><div align="right">Employee Code: </div></td>
                <td colspan="3"><input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" /></td>
              </tr>
              <tr>
                <td width="20%"><div align="right">Access Date-Time:</div></td>
                <td><input type="text" name="m_date" id="m_date" style="width:100px;" /></td>
                <td><select name="m_hr" id="m_hr">
                    <? for($i=7;$i<20;$i++){
	  ?>
                  <option>
                    <?=sprintf('%02d', $i);?>
                    </option>
                    <? }?>
                </select>
                Hr</td>
                <td><select name="m_min" id="m_min">
                    <? for($i=0;$i<60;$i++){
	  ?>
                  <option>
                    <?=sprintf('%02d', $i);?>
                    </option>
                    <? }?>
                </select>
                Min</td>
              </tr>
              <tr>
                <td colspan="4"><label>
                    <div align="center">
                      <input name="search" type="submit" id="search" value="Manual Attendence" />
                    </div>
                  </label></td>
              </tr>
            </table>
            <br /><div style="text-align:center">
              <div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div class="oe_view_manager_view_list"><div class="oe_list oe_view">
<? if($emp_id>0){

$ab="SELECT a.PBI_NAME as name, b.DOMAIN_DESC as company_name, c.DEPT_DESC as department, d.DESG_DESC as designation FROM personnel_basic_info a, domai b, department c, designation d WHERE a.PBI_DOMAIN=b.DOMAIN_CODE and a.PBI_DEPARTMENT=c.DEPT_ID and a.PBI_DESIGNATION=d.DESG_ID and a.PBI_ID=$emp_id";
$data=mysql_query($ab);
$emp=mysql_fetch_object($data);
?>
<span id="id_view">
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="50" bgcolor="#006600"><div align="center" class="style2">ACCESS IN AT: 
  <?=date('d/m/Y H:i:s A',$access_stamp)?>
</div></td>
</tr>
<tr>
<td><div align="center"><img src="../../pic/staff/<?php echo $emp_id;?>.jpg" width="190" height="191" /></div></td>
</tr>
<tr>
<td><div align="center" class="cell_fonts_grant_total style7"><strong><em>Employee Code  : <?php echo $emp_id;?></em></strong></div></td>
</tr>
<tr>
<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->name." (".$emp->designation.")";?> </em></strong></div></td>
</tr><tr>
<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->department.", ".$emp->company_name;?> </em></strong></div></td>
</tr>
</table>
</span>          
<? }?>
</div></div>
          </div>
    </div>

  </div></div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
 </form>   </div>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>