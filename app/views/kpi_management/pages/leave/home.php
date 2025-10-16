<?php
session_start();
ob_start();
require "../../config/inc.all.php";
$title='Inventory Home Page';

?>
<style type="text/css">
.oe_app .oe_app_icon{
display:block;
float: left;
height: 48px;
position: relative;
width: 48px;
}

.oe_app .oe_app_icon img{
display:block;
height: 100%;
width: 100%;
}

.oe_app .oe_app_descr{
font-family:"Open Sans";
margin-left: 64px;
font-weight: 300;
font-size: 17px;
text-decoration:none;
color:#959494;
}

.oe_app_descr{

font-family:"Open Sans";
}


.oe_app .oe_app_name {
    font-size: 18px;
    /*font-weight: 400;*/
	/*text-align:center;*/
    margin-left: 64px;
    margin-top: -4px;
	/*font-family:"Open Sans";*/
	color:#646464;
	
}
.home_table td {
    padding: 2px;
}
.home_table_title {
    color: #617a03;
    font-weight: bold;
}
.home_box1 {
    background: url("../images/h_box_01.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 249px;
}
.home_box2 {
    background: url("../images/h_box_02.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 266px;
}
.home_box3 {
    background: url("../images/h_box_03.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 241px;
}
.home_box4 {
    background: url("../images/h_box_04.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 249px;
}
.home_box5 {
    background: url("../images/h_box_05.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 266px;
}
.home_box6 {
    background: url("../images/h_box_06.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 241px;
}
.left_report {
    overflow: auto;
}
.oe_app {
    background: none repeat scroll 0 0 whitesmoke;
    border: 1px solid transparent;
    border-radius: 2px;
    box-shadow: 0 0 white;
    box-sizing: border-box;
    color: inherit !important;
    cursor: pointer;
    display: block;
    float: left;
    height: 76px;
    margin: 16px;
    overflow: hidden;
    padding: 16px;
    position: relative;
    text-align: left;
    top: 0;
    transition: all 150ms linear 0s;
    width: 276px;
}
.oe_app:hover {
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 4px #dddddd, 0 4px 4px rgba(0, 0, 0, 0.1);
    top: -4px;
}
.style1 {font-size: 24px}
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
</style>
<div class="oe_view_manager oe_view_manager_current">
        <table width="96%" border="0" align="center" cellpadding="10" cellspacing="0" style="margin:20px;">
  <tr>
    <td><?
//session_start();
//require "../../classes/check.php";
//require "../../config/db_connect.php";
//require "../../classes/all_functions.php";
//require "../../classes/scb.php";
//require "../../classes/my.php";
$leave_id = $_SESSION['user']['id'];
if($leave_id>0)
{

$g_s_date=date('2016-01-01');
$g_e_date=date('2016-12-31');

$hrm_leave_info=find_all_field('hrm_leave_info','','PBI_ID='.$leave_id);

$leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type="Casual Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type="Sick Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type="Annual" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_compensatory=find_a_field('hrm_leave_info','sum(total_days)','type="Compensatory Off" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_lwp=find_a_field('hrm_leave_info','sum(total_days)','type="LWP (Leave Without Pay)" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);

$personnel_basic_info=find_all_field('personnel_basic_info','','PBI_ID='.$leave_id);

$designation=find_all_field('designation','DESG_DESC','DESG_ID='.$personnel_basic_info->PBI_DESIGNATION);

$department=find_all_field('department','DEPT_DESC','DEPT_ID='.$personnel_basic_info->PBI_DEPARTMENT);

$hrm_leave_rull_manage=find_all_field('hrm_leave_rull_manage','','id='.$personnel_basic_info->LEAVE_RULE_ID);
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Details Staff Report</title>

<style type="text/css">
body { font-family:Tahoma, Geneva, sans-serif;
font-size:12px; }
table{ border:solid; border:#99C; padding:5px; margin-bottom:5px;}
td{
text-align:center;
}
.style4 {font-size: 14px}
.style9 {color: #FFFFFF}
.style10 {font-size: 14px; color: #FFFFFF; }
.style14 {font-size: 16px; font-weight: bold; }
.style16 {font-size: 12}
</style>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data">

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" eight="790">
  <tr>
    <td height="40" colspan="5">
	  <div align="center" class="style1">Employee Basic Information </div></td>
  </tr>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" eight="790">
  <tr>
    <td width="100" height="30" align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#FFFFFF"><div align="center" class="style14">ID</div></td>
    <td width="100" height="30" align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#FFFFFF" style="font-size:15px"><div align="center" class="style14">Name</div></td>
    <td width="100" height="30" align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#FFFFFF" style="font-size:15px"><div align="center" class="style14">
      Designation     </div></td>
    <td width="100" height="30" align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#FFFFFF"><div align="center" class="style14">Gender</div></td>
    <td width="100" height="30" align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#FFFFFF"><div align="center" class="style14">
      Department</div></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#FFFFFF">
    <td width="100" height="30"><div align="center" class="style4">
      <?=$personnel_basic_info->EMP_ID?>
    </div></td>
    <td width="100" height="30"><div align="center" class="style4"><?=$personnel_basic_info->PBI_NAME?></div></td>
    <td width="100" height="30"><div align="center" class="style4"><?php echo $designation->DESG_DESC?></div></td>
    <td width="100" height="30"><div align="center" class="style4">
      <?=$personnel_basic_info->PBI_SEX?>
    </div></td>
    <td width="100" height="30"><div align="center" class="style4"><?php echo $department->DEPT_DESC?></div></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#FFFFFF">
    <td width="100" height="30"><div align="center" class="style14">Date of Confirmation</div></td>
    <td width="100" height="30"><div align="center" class="style14">Date  of Joining</div></td>
    <td width="100" height="30"><div align="center" class="style14">
      Section  / Team
      
    </div></td>
    <td width="100" height="30"><div align="center" class="style14">Job Location</div></td>
    <td width="100" height="30"><div align="center" class="style14">
      Total Sevice Length</div></td>
  </tr>
  
  
  
  <tr align="center" valign="middle" bgcolor="#FFFFFF">
    <td width="100" height="30"><div align="center" class="style4">
      <?=$personnel_basic_info->PBI_DOC?>
    </div></td>
    <td width="100" height="30"><div align="center" class="style4"><?=$personnel_basic_info->PBI_DOJ?></div></td>
    <td width="100" height="30"><div align="center" class="style4">
      <?=$personnel_basic_info->PBI_SECTION?>
    </div></td>
    <td width="100" height="30"><div align="center" class="style4">
      <?=$personnel_basic_info->JOB_LOCATION?>
    </div></td>
    <td width="100" height="30"><div align="center" class="style4">
      <?=Date2age($personnel_basic_info->PBI_DOJ)?>
    </div></td>
  </tr>
</table>
  
  
  
  
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
    
    <tr>
      <td colspan="10"  bgcolor="#FFFFFF"><h2 align="center">Individual Leave Status <?php echo date('Y')?></h2></td>
    </tr>
    <tr>
      <td width="85" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"></div></td>
      <td width="73" height="25" align="center" valign="middle"  bgcolor="#666666"><strong><span class="style10">Type</span></strong></td>
      <td width="46" height="25" align="center" valign="middle"  bgcolor="#666666"><strong><span class="style10">Casual</span></strong></td>
      <td width="102" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"><strong><span class="style10">Sick / Medical</span></strong></div></td>
      <td width="65" height="25" align="center" valign="middle"  bgcolor="#666666"><strong><span class="style10">Annual</span></strong></td>
      <td width="72" height="25" align="center" valign="middle"  bgcolor="#666666"><strong><span class="style10">Maternity</span></strong></td>
      <td width="140" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"><strong><span class="style10">Compensatory <br/> 
      Off</span></strong></div></td>
      <td width="140" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"><strong><span class="style10">Leave <br/> 
        Without Pay</span></strong></div></td>
      <td width="140" align="center" valign="middle"  bgcolor="#666666"><div align="center" class="style2">Special Leave <br/> 
      (With Pay) </div></td>
      <td width="493" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="85" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="73" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">Entitlement</span></div></td>
      <td width="46" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
        <?=$hrm_leave_rull_manage->CL?>
      </span></div></td>
      <td width="102" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
        <?=$hrm_leave_rull_manage->MED?>
      </span></div></td>
      <td width="65" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
        <?=$hrm_leave_rull_manage->ANU?>
      </span></div></td>
      <td width="72" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
        <?=($personnel_basic_info->PBI_SEX=="Female")?$hrm_leave_rull_manage->MTR:""?>
      </span></div></td>
      <td width="140" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="67" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="68" height="25" align="center" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
      <td width="493" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="85" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="73" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">Availed</span></div></td>
      <td width="46" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
        <?=$leave_days_casual?>
      </span></div></td>
      <td width="102" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
        <?=$leave_days_sick?>
      </span></div></td>
      <td width="65" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
        <?=$leave_days_annual?>
      </span></div></td>
      <td width="72" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="140" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$leave_days_compensatory?></div></td>
      <td width="67" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$leave_days_lwp?></div></td>
      <td width="68" height="25" align="center" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
      <td width="493" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="85" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="73" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">Balance</span></div></td>
      <td width="46" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
        <?=$hrm_leave_rull_manage->CL-$leave_days_casual?>
      </span></div></td>
      <td width="102" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
        <?=$hrm_leave_rull_manage->MED-$leave_days_sick?>
      </span></div></td>
      <td width="65" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
        <?=$hrm_leave_rull_manage->ANU-$leave_days_annual?>
      </span></div></td>
      <td width="72" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="140" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="67" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="68" height="25" align="center" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
      <td width="493" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
    </tr>
	
	<tr>
      <td width="90" height="23" align="center" valign="middle"  bgcolor="#666666"><div align="center"><span class="style10">From</span></div></td>
      <td width="90" align="center" valign="middle"  bgcolor="#666666"><div align="center"><span class="style10">To</span></div></td>
      <td width="46" align="center" valign="middle"  bgcolor="#666666"><div align="center"><span class="style9"></span></div></td>
      <td width="102"  bgcolor="#666666"><div align="center"><span class="style9"></span></div></td>
      <td width="65"  bgcolor="#666666"><span class="style9"></span></td>
      <td width="72"  bgcolor="#666666"><span class="style9"></span></td>
      <td width="140"  bgcolor="#666666"><span class="style9"></span></td>
      <td width="67"  bgcolor="#666666"><span class="style9"></span></td>
      <td width="68"  bgcolor="#666666">&nbsp;</td>
      <td  bgcolor="#666666"><span class="style10"><strong>Purpose / Reason</strong></span></td>
    </tr>
	
	
   
  
  
  <? 
$res = "select o.*, a.EMP_ID, a.PBI_NAME from personnel_basic_info a, hrm_leave_info o where  a.PBI_ID=o.PBI_ID and leave_status='GRANTED' and o.s_date>='".$g_s_date."' and o.e_date<='".$g_e_date."'   and o.PBI_ID=".$hrm_leave_info->PBI_ID;

$sqll=mysql_query($res);

while ($data=mysql_fetch_object($sqll)){?>

 <tr>
      <td width="85" height="23" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=$data->s_date?></span></div></td>
      <td width="73" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=$data->e_date?></span></div></td>
      <td width="46" align="center" valign="middle"  bgcolor="#FFFFFF"><span class="style16">
        <?=($data->type=="Casual Leave")?$data->total_days:"";?>
      </span></td>
      <td width="102"  bgcolor="#FFFFFF"><div align="center" class="style16"><?=($data->type=="Sick Leave")?$data->total_days:"";?></div></td>
      <td width="65"  bgcolor="#FFFFFF"><span class="style16">
        <?=($data->type=="Annual")?$data->total_days:"";?>
      </span></td>
      <td width="72"  bgcolor="#FFFFFF">&nbsp;</td>
      <td width="140"  bgcolor="#FFFFFF"><?=($data->type=="Compensatory Off")?$data->total_days:"";?></td>
      <td width="67"  bgcolor="#FFFFFF"><?=($data->type=="LWP (Leave Without Pay)")?$data->total_days:"";?></td>
      <td width="68"  bgcolor="#FFFFFF"><?=($data->type=="Special Leave (Leave With Pay)")?$data->total_days:"";?></td>
      <td  bgcolor="#FFFFFF"><span class="style4"><strong><?=$data->reason?></strong></span></td>
    </tr>



<? } ?>
</table>
  
  
</form>
  
  
  
</body>
</html></td>
  </tr>
</table>

</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>