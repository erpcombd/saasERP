<?
session_start();
require "../../classes/check.php";
require "../../config/db_connect.php";
require "../../classes/all_functions.php";
require "../../classes/scb.php";
require "../../classes/my.php";
$employee_selected = $_SESSION['employee_selected'];
if(isset($employee_selected))
{
$personnel_basic_info=find_all_field('personnel_basic_info','','PBI_ID='.$employee_selected);
$essential_info=find_all_field('essential_info','','PBI_ID='.$employee_selected);
$guardian=find_all_field('guardian','','PBI_ID='.$employee_selected);
$pf_status=find_all_field('pf_status','','PBI_ID='.$employee_selected);
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Details Staff Report</title>

<style type="text/css">
body { font-family:Tahoma, Geneva, sans-serif;
font-size:12px; }
table{ border:solid; border:#99C; padding:0px; font-size:10px; margin-bottom:5px;}
td{ padding: 1px 5px 1px 5px}
</style>
</head>

<body>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" eight="790">
  <tr>
    <td height="100" colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1"><img src="images/Logo.png" width="109" height="98" /></td>
          <td><div align="center"><span style="font-size:22px">Employee's Detail Information </span><br />
            TMSS Personal Management System<br />
            Printed On: <?=date('l, F d, Y')?>

          </div></td>
          <td width="200" align="center"></div>N/A = Not Applicable
N/I = No Information</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>ID</strong></td>
    <td width="31%" bgcolor="#E9E9E9" style="font-size:18px"><?=$personnel_basic_info->PBI_ID?> </td>
    <td width="14%" align="right" bgcolor="#E9E9E9"><strong>Maritial Status</strong></td>
    <td width="14%" bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_MARITAL_STA?></td>
    <td width="18%" rowspan="6" align="center"><img src="images/rv.jpg" width="128" height="126" border="1" /></td>
  </tr>
  <tr>
    <td align="right"><strong>Name</strong></td>
    <td><?=$personnel_basic_info->PBI_NAME?></td>
    <td align="right"><strong>Nationality</strong></td>
    <td><?=$personnel_basic_info->PBI_NATIONALITY?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>Father Name</strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_FATHER_NAME?></td>
    <td align="right" bgcolor="#E9E9E9"><strong>Phone </strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_PHONE?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong>Mother Name</strong></td>
    <td valign="top"><?=$personnel_basic_info->PBI_MOTHER_NAME?></td>
    <td align="right" valign="top"><strong>Mobile</strong></td>
    <td valign="top"><?=$personnel_basic_info->PBI_MOBILE?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>Domain</strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_DOMAIN?></td>
    <td align="right" bgcolor="#E9E9E9"><strong>E-Mail</strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_EMAIL?></td>
  </tr>
  <tr>
    <td align="right"><strong>Department</strong></td>
    <td><?=$personnel_basic_info->PBI_DEPARTMENT?></td>
    <td align="right"><strong>Speciality</strong></td>
    <td><?=$personnel_basic_info->PBI_DEPARTMENT?> </td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>Project</strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_PROJECT?></td>
    <td align="right" bgcolor="#E9E9E9"><strong>Initial Job Type</strong></td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_JOB_STATUS?></td>
  </tr>
  <tr>
    <td align="right"><strong>Designation</strong></td>
    <td><?=$personnel_basic_info->PBI_FATHER_NAME?></td>
    <td align="right"><strong>Bank Name</strong></td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_BANK_NAME?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>Zone</strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_ZONE?></td>
    <td align="right" bgcolor="#E9E9E9"><strong>Branch</strong></td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_BRANCH?></td>
  </tr>
  <tr>
    <td align="right"><strong>Area</strong></td>
    <td><?=$personnel_basic_info->PBI_AREA?></td>
    <td align="right"><strong>Bank Address </strong></td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_BANK_ADDRESS?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>Branch</strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_BRANCH?></td>
    <td align="right" bgcolor="#E9E9E9"><strong>Account#</strong></td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_ACC_NO?></td>
  </tr>
  <tr>
    <td align="right"><strong>Appointment Lette No</strong></td>
    <td><?=$personnel_basic_info->PBI_APPOINTMENT_LETTER_NO?></td>
    <td align="right"><strong>Blood Group</strong></td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_BLOOD_GROUP?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>1st Date of Joining in TMSS</strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_DOMAIN?></td>
    <td align="right" bgcolor="#E9E9E9"><strong>Voter/National ID</strong></td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_VOTER_ID?></td>
  </tr>
  <tr>
    <td align="right"><strong>Total Sevice Length</strong></td>
    <td><?=$personnel_basic_info->PBI_SERVICE_LENGTH?> </td>
    <td align="right"><strong>Passport#</strong></td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_PASSPORT_NO?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>Joing Date of Present Post </strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_DOMAIN?></td>
    <td align="right" bgcolor="#E9E9E9"><strong>Issue Date</strong></td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_ISSUE_DATE?></td>
  </tr>
  <tr>
    <td align="right"><strong>Ser. Length of Present Post</strong></td>
    <td><?=$personnel_basic_info->PBI_DOMAIN?></td>
    <td align="right"><strong>Type of Passport</strong></td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_TYPE_OF_PASSPORT?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>Date of Confirmation</strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_DOMAIN?></td>
    <td align="right" bgcolor="#E9E9E9"><strong>Visited Country</strong></td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_VISITED_COUNTRY?></td>
  </tr>
  <tr>
    <td align="right"><strong>Date of Birth</strong></td>
    <td><?=$personnel_basic_info->PBI_DOMAIN?></td>
    <td align="right"><strong>Driving Licence#</strong></td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_DRIVING_LICENSE_NO?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>Present Age</strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_DOMAIN?></td>
    <td align="right" bgcolor="#E9E9E9"><strong>Type of Licence</strong></td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_TYPE_OF_LICENSE?></td>
  </tr>
  <tr>
    <td align="right"><strong>Place of Birth</strong></td>
    <td><?=$personnel_basic_info->PBI_DOMAIN?></td>
    <td align="right"><strong>TIN#</strong></td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_TIN_NO?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>Sex</strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_SEX?></td>
    <td align="right" bgcolor="#E9E9E9"><strong> Job Status</strong></td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_DOMAIN?> </td>
  </tr>
  <tr>
    <td align="right"><strong> Religion</strong></td>
    <td><?=$personnel_basic_info->PBI_RELIGION?></td>
    <td colspan="3" rowspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong>Permanent Address </strong></td>
    <td bgcolor="#E9E9E9"><p><?=$personnel_basic_info->PBI_PERMANENT_ADD?> </p>
    </td>
  </tr>
  <tr>
    <td align="right"><strong>Present Address</strong></td>
    <td><?=$personnel_basic_info->PBI_PRESENT_ADD?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"><strong> Special Notes /Observation</strong></td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_DOMAIN?></td>
  </tr>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" bgcolor="#AAC6FF"> <strong>Guardian</strong></td>
  </tr>
  <tr>
    <td><strong>Guardial Name</strong></td>
    <td><?=$guardian->GUARDIAN_NAME?></td>
    <td>Fax No</td>
    <td><?=$guardian->PBI_DOMAIN?></td>
  </tr>
  <tr>
    <td><strong>Relation</strong></td>
    <td><?=$guardian->GUARDIAN_RELATION?></td>
    <td>Phone No</td>
    <td><?=$guardian->GUARDIAN_PHONE?></td>
  </tr>
  <tr>
    <td><strong>National ID# </strong></td>
    <td><?=$guardian->PBI_DOMAIN?></td>
    <td>Mobiel No</td>
    <td><?=$guardian->GUARDIAN_MOBILE?></td>
  </tr>
  <tr>
    <td><strong>E-mail</strong></td>
    <td><?=$guardian->GUARDIAN_EMAIL?></td>
    <td>Profession</td>
    <td><?=$guardian->GUARDIAN_PROFESSION?></td>
  </tr>
  <tr>
    <td><strong> Working Location </strong></td>
    <td><?=$personnel_basic_info->PBI_DOMAIN?></td>
    <td colspan="2" rowspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Present Address</strong></td>
    <td><?=$guardian->GUARDIAN_PRESENT_ADDRESS?></td>
  </tr>
  <tr>
    <td><strong>Permanent Address</strong></td>
    <td><?=$guardian->GUARDIAN_PERMANENT_ADDRESS?></td>
  </tr>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="10" bgcolor="#AAC6FF"><strong>Particular: Education</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>Exam Name </strong></td>
    <td align="center"><strong>Year</strong></td>
    <td align="center"><strong>Subject </strong></td>
    <td align="center"><strong>Group</strong></td>
    <td align="center"><strong>Thesis Topic</strong></td>
    <td align="center"><strong>Institute</strong></td>
    <td align="center"><strong>Board/ University</strong></td>
    <td align="center"><strong>Marks</strong></td>
    <td align="center"><strong>Grade/Class</strong></td>
    <td align="center"><strong>Doc</strong></td>
  </tr>
  <? $res=find_all_field_malti('education_detail','PBI_ID='.$employee_selected);
  	 while($education_detail=mysqli_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$education_detail->EDUCATION_NOE?></td>
    <td><?=$education_detail->EDUCATION_YEAR?></td>
    <td><?=$education_detail->EDUCATION_SUBJECT?></td>
    <td><?=$education_detail->EDUCATION_GROUP?></td>
    <td><?=$education_detail->EDUCATION_THESIS_TOPIC?></td>
    <td><?=$education_detail->EDUCATION_BU?></td>
    <td><?=$education_detail->EDUCATION_BU?></td>
    <td><?=$education_detail->EDUCATION_TOTAL_MARK?></td>
    <td><?=$education_detail->EDUCATION_GRADE_CLASS?></td>
    <td><?=$education_detail->EDUCATION_DOCUMENT?></td>
  </tr>
  <? }?>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular: Nominee</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>Name of Nominee</strong></td>
    <td align="center"><strong>Relation</strong></td>
    <td align="center"><strong>%</strong></td>
    <td align="center"><strong>Address </strong></td>
    <td align="center"><strong>Voter ID</strong></td>
    <td align="center"><strong>Phone</strong></td>
    <td align="center"><strong>Mobile</strong></td>
  </tr>
  <? $res=find_all_field_malti('nominee_detail','PBI_ID='.$employee_selected);
  	 while($nominee_detail=mysqli_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$nominee_detail->NOMINEE_NAME?></td>
    <td><?=$nominee_detail->NOMINEE_RELATION?></td>
    <td><?=$nominee_detail->NOMINEE_PERCENT?></td>
    <td><?=$nominee_detail->NOMINEE_ADDRESS?></td>
    <td><?=$nominee_detail->NOMINEE_VOTER_ID?></td>
    <td><?=$nominee_detail->NOMINEE_PHONE?></td>
    <td><?=$nominee_detail->NOMINEE_MOBILE?></td>
  </tr>
  <? }?>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="9" bgcolor="#AAC6FF"><strong>Particular: Transfer</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>Transfer Order No</strong></td>
    <td align="center"><strong>Date</strong></td>
    <td align="center"><strong>Desg</strong></td>
    <td align="center"><strong>Past Dept.</strong></td>
    <td align="center"><strong>Present Dept.</strong></td>
    <td align="center"><strong>Present Zone</strong></td>
    <td align="center"><strong>Present Area</strong></td>
    <td align="center"><strong>Present Branch</strong></td>
    <td align="center"><strong>Notice</strong></td>
  </tr>
    <? $res=find_all_field_malti('transfer_detail','PBI_ID='.$employee_selected);
  	 while($transfer_detail=mysqli_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$transfer_detail->TRANSFER_ORDER_NO?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_ORDER_DATE?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_DESIGNATION?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_PAST_DEPT?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_PRESENT_DEPT?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_PRESENT_ZONE?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_PRESENT_AREA?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_PAST_BRANCH?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_NOTES?></td>
  </tr>
  <? }?>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5" bgcolor="#AAC6FF"><strong>Particular: Promotion</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>Type of Promotion</strong></td>
    <td align="center"><strong>Date</strong></td>
    <td align="center"><strong>Past Designation</strong></td>
    <td align="center"><strong>Present Designation</strong></td>
    <td align="center"><strong>Level Crossed</strong></td>
  </tr>
    <? $res=find_all_field_malti('promotion_detail','PBI_ID='.$employee_selected);
  	 while($promotion_detail=mysqli_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$promotion_detail->PROMOTION_TYPE?></td>
    <td align="center"><?=$promotion_detail->PROMOTION_DATE?></td>
    <td align="center"><?=$promotion_detail->ROMOTION_PAST_DESG?></td>
    <td align="center"><?=$promotion_detail->PROMOTION_PRESENT_DESG?></td>
    <td align="center"><?=$promotion_detail->PROMOTION_CROSSED_LEVEL?></td>
  </tr>
  <? }?>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" bgcolor="#AAC6FF"><strong>Particular: Increment</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>Increment Type</strong></td>
    <td align="center"><strong>Number of Increment</strong></td>
    <td align="center"><strong>Date</strong></td>
    <td align="center"><strong>Designation</strong></td>
  </tr>
    <? $res=find_all_field_malti('increment_detail','PBI_ID='.$employee_selected);
  	 while($increment_detail=mysqli_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$increment_detail->INCREMENT_TYPE?></td>
    <td align="center"><?=$increment_detail->PROMOTION_TYPE?></td>
    <td align="center"><?=$increment_detail->INCREMENT_AMT?></td>
    <td align="center"><?=$increment_detail->INCREMENT_DESG?></td>
  </tr>
  <? }?>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular: Membership/Donor</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>Type</strong></td>
    <td width="69" align="center"><strong>Year</strong></td>
    <td width="80" align="center"><strong>Date</strong></td>
    <td width="84" align="center"><strong>Duration</strong></td>
    <td width="90" align="center"><strong>Amount</strong></td>
    <td width="66" align="center"><strong>Arce</strong></td>
    <td width="84" align="center"><strong>Blood Bag </strong></td>
  </tr>
  <? $res=find_all_field_malti('increment_detail','PBI_ID='.$employee_selected);
  	 while($increment_detail=mysqli_fetch_object($res)){$pi++;
	 $tVALUES_AMT=$tVALUES_AMT+$values_detail->VALUES_AMT;
	 $tVALUES_ACRE=$tVALUES_ACRE+$values_detail->VALUES_ACRE;
	 $tVALUES_BLOOD_BAG=$tVALUES_BLOOD_BAG+$values_detail->VALUES_BLOOD_BAG;
	 ?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$values_detail->VALUES_TYPE?></td>
    <td align="center"><?=$values_detail->VALUES_YEAR?></td>
    <td align="center"><?=$values_detail->VALUES_DATE?></td>
    <td><?=$values_detail->VALUES_DURATION?></td>
    <td align="right"><?=$values_detail->VALUES_AMT?></td>
    <td align="right"><?=$values_detail->VALUES_ACRE?></td>
    <td align="right"><?=$values_detail->VALUES_BLOOD_BAG?></td>
  </tr>
    <? }?>
  <tr>
    <td colspan="4" align="right">Total</td>
    <td align="right"><?=$tVALUES_AMT?></td>
    <td align="right"><?=$tVALUES_ACRE?></td>
    <td align="right"><?=$tVALUES_BLOOD_BAG?></td>
  </tr>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular: ED Action </strong></td>
  </tr>
  <tr>
    <td width="138" align="center"><strong>Action Form </strong></td>
    <td width="127" align="center"><strong>Action No </strong></td>
    <td width="147" align="center"><strong>Register No </strong></td>
    <td width="75" align="center"><strong>Date </strong></td>
    <td width="150" align="center"><strong>Action Memo No </strong></td>
    <td width="83" align="center"><strong>Cir. Date</strong></td>
    <td width="147" align="center"><strong>Cir. By </strong></td>
  </tr>
    <? $res=find_all_field_malti('ed_action_detail','PBI_ID='.$employee_selected);
  	 while($ed_action_detail=mysqli_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$ed_action_detail->ED_ACTION_FROM?></td>
    <td><?=$ed_action_detail->ED_ACTION_NO?></td>
    <td align="center"><?=$ed_action_detail->ED_ACTION_REGISTER_NO?></td>
    <td><?=$ed_action_detail->ED_ACTION_DATE?></td>
    <td><?=$ed_action_detail->ED_ACTION_MEMO_NO?></td>
    <td><?=$ed_action_detail->ED_ACTION_CIRCULAR_DATE?></td>
    <td align="center"><?=$ed_action_detail->ED_ACTION_CIRCULAR_BY?></td>
  </tr>
  <? }?>
</table>
<br>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Particular: Department Action </strong></td>
  </tr>
  <tr>
    <td width="112" align="center"><strong>Type</strong></td>
    <td width="218" align="center"><strong>Subject</strong></td>
    <td width="57" align="center"><strong>Amount</strong></td>
    <td width="106" align="center"><strong>Memo No </strong></td>
    <td width="79" align="center"><strong>Date</strong></td>
    <td width="122" align="center"><strong>Circular By </strong></td>
  </tr>
    <? $res=find_all_field_malti('departmental_objection_detail','PBI_ID='.$employee_selected);
  	 while($departmental_objection_detail=mysqli_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$departmental_objection_detail->DEPARTMENTAL_OBJ_TYPE?></td>
    <td><?=$departmental_objection_detail->DEPARTMENTAL_OBJ_SUBJECT?></td>
    <td align="center"><?=$departmental_objection_detail->DEPARTMENTAL_OBJ_AMT?></td>
    <td><?=$departmental_objection_detail->DEPARTMENTAL_OBJ_MEMO_NO?></td>
    <td align="center"><?=$departmental_objection_detail->DEPARTMENTAL_OBJ_DATE?></td>
    <td align="center"><?=$departmental_objection_detail->DEPARTMENTAL_OBJ_BY?></td>
  </tr>
  <? }?>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Particular: Administrative Action </strong></td>
  </tr>
  <tr>
    <td width="101" align="center"><strong>Type</strong></td>
    <td width="243" align="center"><strong>Subject</strong></td>
    <td width="48" align="center"><strong>Amount</strong></td>
    <td width="170" align="center"><strong>Memo No </strong></td>
    <td width="78" align="center"><strong>Date</strong></td>
    <td width="54" align="center"><strong>Circular By </strong></td>
  </tr>
  <? $res=find_all_field_malti('admin_action_detail','PBI_ID='.$employee_selected);
  	 while($admin_action_detail=mysqli_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$admin_action_detail->ADMIN_ACTION_TYPE?></td>
    <td><?=$admin_action_detail->ADMIN_ACTION_SUBJECT?></td>
    <td align="center"><?=$admin_action_detail->ADMIN_ACTION_AMT?></td>
    <td><?=$admin_action_detail->ADMIN_ACTION_MEMO_NO?></td>
    <td><?=$admin_action_detail->ADMIN_ACTION_DATE?></td>
    <td><?=$admin_action_detail->ADMIN_ACTION_BY?></td>
  </tr>
  <? }?>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="8" bgcolor="#AAC6FF"><strong>Particular: Quarter/Dormitory/Hostel </strong></td>
  </tr>
  <tr>
    <td width="149" align="center"><strong>Type</strong></td>
    <td width="222" align="center"><strong>QDH Name </strong></td>
    <td width="226" align="center"><strong>Location</strong></td>
    <td width="132" align="center"><strong>Rent</strong></td>
    <td width="151" align="center"><strong>Issue Date</strong></td>
    <td width="143" align="center"><strong>Cancel Date</strong></td>
    <td width="156" align="center"><strong>Duration</strong></td>
    <td width="103" align="center"><strong>Status</strong></td>
  </tr>
    <? $res=find_all_field_malti('quarter_detail','PBI_ID='.$employee_selected);
  	 while($quarter_detail=mysqli_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$quarter_detail->QUARTER_TYPE?></td>
    <td><?=$quarter_detail->QUARTER_NAME?></td>
    <td align="center"><?=$quarter_detail->QUARTER_LOCATION?></td>
    <td align="center"><?=$quarter_detail->QUARTER_RENT?></td>
    <td><?=$quarter_detail->QUARTER_ISSUE_DATE?></td>
    <td><?=$quarter_detail->QUARTER_CANCEL_DATE?></td>
    <td><?=$quarter_detail->QUARTER_DURATION?> </td>
    <td align="center"><?=$quarter_detail->QUARTER_STATUS?></td>
  </tr>
  <? }?>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular: APR</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>Year</strong></td>
    <td align="center"><strong>Recomondation</strong></td>
    <td align="center"><strong>Marks</strong></td>
    <td align="center"><strong>Status</strong></td>
    <td align="center"><strong>Result</strong></td>
    <td align="center"><strong>Past Designation </strong></td>
    <td align="center"><strong>Present Designation</strong></td>
  </tr>
    <? $res=find_all_field_malti('apr_detail','PBI_ID='.$employee_selected);
  	 while($apr_detail=mysqli_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td align="center"><?=$apr_detail->APR_YEAR?></td>
    <td><?=$quarter_detail->APR_RECOMMENDATION?></td>
    <td align="center"><?=$apr_detail->APR_MARKS?></td>
    <td align="center"><?=$apr_detail->APR_STATUS?></td>
    <td align="center"><?=$apr_detail->APR_RESULT?></td>
    <td align="center"><?=$apr_detail->apr_detail?></td>
    <td align="center"><?=$apr_detail->APR_DESG_TO?></td>
  </tr>
  <? }?>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="9" bgcolor="#AAC6FF"><strong>Particular: Motor Cycle </strong></td>
  </tr>
  <tr>
    <td align="center"><strong>Date</strong></td>
    <td width="111" align="center"><strong>Company</strong></td>
    <td width="77" align="center"><strong>Model</strong></td>
    <td width="70" align="center"><strong>CC</strong></td>
    <td width="103" align="center"><strong>Engine No </strong></td>
    <td width="157" align="center"><strong>Chassis No </strong></td>
    <td width="157" align="center"><strong>Total Price </strong></td>
    <td width="235" align="center"><strong>Register No </strong></td>
    <td width="79" align="center"><strong>Status</strong></td>
  </tr>
    <? $res=find_all_field_malti('motor_cycle_detail','PBI_ID='.$employee_selected);
  	 while($motor_cycle_detail=mysqli_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td align="center"><?=$motor_cycle_detail->MC_RECEIVED_DATE?></td>
    <td align="center"><?=$motor_cycle_detail->MC_COMPANY?></td>
    <td align="center"><?=$motor_cycle_detail->MC_MODEL?></td>
    <td align="center"><?=$motor_cycle_detail->MC_CC?></td>
    <td align="center"><?=$motor_cycle_detail->MC_ENGINE_NO?></td>
    <td align="center"><?=$motor_cycle_detail->MC_CHASSIS_NO?></td>
    <td align="center"><?=$motor_cycle_detail->MC_TOTAL_PRICE?></td>
    <td align="center"><?=$motor_cycle_detail->QUARTER_STATUS?></td>
    <td align="center"><?=$motor_cycle_detail->MC_RECEIVED_STATUS?></td>
  </tr>
  <? }?>
</table>

<table width="100%" height="86" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Personal File Check List </strong></td>
  </tr>
  <tr>
    <td align="center"><strong>File/Document</strong></td>
    <td align="center"><strong>Status</strong></td>
    <td align="center"><strong>File/Document</strong></td>
    <td align="center"><strong>Status</strong></td>
    <td align="center"><strong>File/Document</strong></td>
    <td align="center"><strong>Status</strong></td>
  </tr>
  <tr bgcolor="#E9E9E9">
    <td align="right"><strong>CV</strong></td>
    <td align="center"><?=$pf_status->PF_STATUS_CV?></td>
    <td align="right"><strong>Guardian's Affidavit</strong> </td>
    <td align="center"><?=$pf_status->PF_STATUS_E_AFFIDAVIT?></td>
    <td align="right"><strong>Security Money Rceipt</strong></td>
    <td align="center"><?=$pf_status->PF_STATUS_SM_RECITE?></td>
  </tr>
  <tr>
    <td align="right"><strong>Appointment Letter</strong></td>
    <td align="center"><?=$pf_status->PF_STATUS_APPOINTMENT_LETTER?></td>
    <td align="right"><strong>Guardian Certify Letter </strong></td>
    <td align="center"><?=$pf_status->PF_STATUS_G_CERTIFY_LETTER?></td>
    <td align="right"><strong>Received Aya Alloance</strong></td>
    <td align="center"><?=$pf_status->PF_STATUS_R_AYA_A?></td>
  </tr>
  <tr bgcolor="#E9E9E9">
    <td align="right"><strong>Joining Letter</strong></td>
    <td align="center"><?=$pf_status->PF_STATUS_JOINING_LETTER?></td>
    <td align="right"><strong>Guardian's Photo</strong></td>
    <td align="center"><?=$pf_status->PF_STATUS_G_PHOTO?></td>
    <td align="right"><strong>Posting Letter</strong></td>
    <td align="center"><?=$pf_status->PF_STATUS_POSTING_LETTER?></td>
  </tr>
  <tr>
    <td align="right"><strong>Employee's Affidavit</strong></td>
    <td align="center"><?=$pf_status->MC_RECEIVED_STATUS?></td>
    <td align="right"><strong>Medical Certificate</strong></td>
    <td align="center"><?=$pf_status->PF_STATUS_C_CERTIFICATE?></td>
    <td align="right"><strong>Clearance Certificate</strong></td>
    <td align="center"><?=$pf_status->PF_STATUS_C_CERTIFICATE?></td>
  </tr>
  <tr bgcolor="#E9E9E9">
    <td align="right"><strong>Nominee</strong></td>
    <td align="center"><?=$pf_status->MC_RECEIVED_STATUS?></td>
    <td align="right"><strong>Nominee Photo</strong></td>
    <td align="center"><?=$pf_status->PF_STATUS_NOMINEE_PHOTO?></td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
