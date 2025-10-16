<?
session_start();
require "../../classes/check.php";
require "../../config/db_connect.php";
require "../../classes/all_functions.php";
require "../../classes/scb.php";
require "../../classes/my.php";
$leave_id = $_REQUEST['id'];
if($leave_id>0)
{

$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');

$hrm_leave_info=find_all_field('hrm_leave_info','','PBI_ID='.$leave_id);

$leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type="Casual Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type="Sick Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type="Annual" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_compensatory=find_a_field('hrm_leave_info','sum(total_days)','type="Compensatory Off" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and PBI_ID='.$hrm_leave_info->PBI_ID);

$leave_days_lwp=find_a_field('hrm_leave_info','sum(total_days)','type="LWP (Leave Without Pay)" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  and PBI_ID='.$hrm_leave_info->PBI_ID);

$personnel_basic_info=find_all_field('personnel_basic_info','','PBI_ID='.$hrm_leave_info->PBI_ID);

$designation=find_all_field('designation','','DESG_ID='.$personnel_basic_info->DESG_ID);

$department=find_all_field('department','','DEPT_ID='.$personnel_basic_info->DEPT_ID);

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
table{ border:solid; border:#99C; padding:0px; font-size:11px; margin-bottom:5px;}
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
    <td height="100" colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1"><img src="<?=SERVER_ROOT?>public/uploads/logo/1.png" width="200"  style="padding-left:20px;" /></td>
          <td>
		  <div align="center"><span style="font-size:22px">Staff Details </span><br />
            REGENT AIRWAYS HRM<br />
            Printed On: <?=date('l, F d, Y')?>

          </div>
		  </td>
		  
           <td width="18%" rowspan="6" align="center"><img src="../../pic/staff/<?=$employee_selected?>.jpg" width="128" height="126" border="1" /></td>
        </tr>
    </table>
	</td>
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
      <td colspan="9"  bgcolor="#FFFFFF"><h2>Individual Leave Status 2016</h2></td>
    </tr>
    <tr>
      <td width="78" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"></div></td>
      <td width="73" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"><strong><span class="style10">Type</span></strong></div></td>
      <td width="53" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"><strong><span class="style10">Casual</span></strong></div></td>
      <td width="102" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"><strong><span class="style10">Sick / Medical</span></strong></div></td>
      <td width="65" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"><strong><span class="style10">Annual</span></strong></div></td>
      <td width="72" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"><strong><span class="style10">Maternity</span></strong></div></td>
      <td width="140" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"><strong><span class="style10">Compensatory Off</span></strong></div></td>
      <td width="135" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"><strong><span class="style10">Leave without pay</span></strong></div></td>
      <td width="493" height="25" align="center" valign="middle"  bgcolor="#666666"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="78" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="73" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">Entitlement</span></div></td>
      <td width="53" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
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
      <td width="135" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="493" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="78" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="73" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">Availed</span></div></td>
      <td width="53" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
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
      <td width="135" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$leave_days_lwp?></div></td>
      <td width="493" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="78" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="73" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">Balance</span></div></td>
      <td width="53" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
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
      <td width="135" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
      <td width="493" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"></div></td>
    </tr>
	
	<tr>
      <td width="78" height="23" align="center" valign="middle"  bgcolor="#666666"><div align="center"><span class="style10">From</span></div></td>
      <td width="73" align="center" valign="middle"  bgcolor="#666666"><div align="center"><span class="style10">To</span></div></td>
      <td width="53" align="center" valign="middle"  bgcolor="#666666"><div align="center"><span class="style9"></span></div></td>
      <td width="102"  bgcolor="#666666"><div align="center"><span class="style9"></span></div></td>
      <td width="65"  bgcolor="#666666"><span class="style9"></span></td>
      <td width="72"  bgcolor="#666666"><span class="style9"></span></td>
      <td width="140"  bgcolor="#666666"><span class="style9"></span></td>
      <td width="135"  bgcolor="#666666"><span class="style9"></span></td>
      <td  bgcolor="#666666"><span class="style10"><strong>Purpose / Reason</strong></span></td>
    </tr>
	
	
   
  
  
  <? 
$res = "select o.*, a.EMP_ID, a.PBI_NAME from personnel_basic_info a, hrm_leave_info o where  a.PBI_ID=o.PBI_ID and leave_status='GRANTED' and s_date>='".$g_s_date."' and e_date<='".$g_e_date."'   and o.PBI_ID=".$hrm_leave_info->PBI_ID;

$sqll=db_query($res);

while ($data=mysqli_fetch_object($sqll)){?>

 <tr>
      <td width="78" height="23" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=$data->s_date?></span></div></td>
      <td width="73" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=$data->e_date?></span></div></td>
      <td width="53" align="center" valign="middle"  bgcolor="#FFFFFF"><span class="style16">
        <?=($data->type=="Casual Leave")?$data->total_days:"";?>
      </span></td>
      <td width="102"  bgcolor="#FFFFFF"><div align="center" class="style16"><?=($data->type=="Sick Leave")?$data->total_days:"";?></div></td>
      <td width="65"  bgcolor="#FFFFFF"><span class="style16">
        <?=($data->type=="Annual")?$data->total_days:"";?>
      </span></td>
      <td width="72"  bgcolor="#FFFFFF">&nbsp;</td>
      <td width="140"  bgcolor="#FFFFFF"><?=($data->type=="Compensatory Off")?$data->total_days:"";?></td>
      <td width="135"  bgcolor="#FFFFFF"><?=($data->type=="LWP (Leave Without Pay)")?$data->total_days:"";?></td>
      <td  bgcolor="#FFFFFF"><span class="style4"><strong><?=$data->reason?></strong></span></td>
    </tr>



<? } ?>
</table>
  
  
</form>
  
  
  
</body>
</html>