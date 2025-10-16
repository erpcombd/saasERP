<?
session_start();
require "../../classes/check.php";
require "../../config/db_connect.php";
require "../../classes/all_functions.php";
require "../../classes/scb.php";
require "../../classes/my.php";
$employee_selected = $_REQUEST['employee_selected'];
if($employee_selected>0)
{
$find_field=mysql_query("SELECT a.DOMAIN_DESC FROM domai a, personnel_basic_info b WHERE b.PBI_DOMAIN=a.DOMAIN_CODE and b.PBI_ID='$employee_selected'");
//var_dump($find_field);
$fo=mysql_fetch_row($find_field);
//print_r($fo);

$find_department=mysql_query("SELECT a.DEPT_DESC FROM department a, personnel_basic_info b WHERE b.PBI_DEPARTMENT=a.DEPT_ID and b.PBI_ID='$employee_selected'");
$find_de=mysql_fetch_row($find_department);


$find_designation=mysql_query("SELECT a.DESG_DESC FROM designation a, personnel_basic_info b WHERE b.PBI_DESIGNATION=a.DESG_ID and b.PBI_ID='$employee_selected'");
$find_des=mysql_fetch_row($find_designation);


$find_job_status=mysql_query("SELECT a.job_status FROM job_status a, personnel_basic_info b WHERE b.PBI_JOB_STATUS=a.id and b.PBI_ID='$employee_selected'");
$find_job=mysql_fetch_row($find_job_status);


$find_office_time=mysql_query("SELECT a.schedule_name FROM hrm_schedule_info a, personnel_basic_info b WHERE b.office_time=a.id and b.PBI_ID='$employee_selected'");
$find_time=mysql_fetch_row($find_office_time);


$place_birth=mysql_query("SELECT a.ZONE_NAME FROM zon a, personnel_basic_info b WHERE b.PBI_POB=a.ZONE_CODE and b.PBI_ID='$employee_selected'");
$find_bir=mysql_fetch_row($place_birth);


$find_edu_qua=mysql_query("SELECT a.EDU_QUA_DESC FROM edu_qua a, personnel_basic_info b WHERE b.PBI_EDU_QUALIFICATION=a.EDU_QUA_CODE and b.PBI_ID='$employee_selected'");
$find_edu=mysql_fetch_row($find_edu_qua);




$personnel_basic_info=find_all_field('personnel_basic_info','','PBI_ID='.$employee_selected);
$essential_info=find_all_field('essential_info','','PBI_ID='.$employee_selected);
$guardian=find_all_field('guardian','','PBI_ID='.$employee_selected);
$pf_status=find_all_field('pf_status','','PBI_ID='.$employee_selected);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Details Staff Report</title>

<style type="text/css">
body { font-family:Tahoma, Geneva, sans-serif;
font-size:12px; }
table{ border:solid; border:#99C; padding:0px; font-size:11px; margin-bottom:5px;}
td{ padding: 1px 5px 1px 5px}
</style>
</head>

<body>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" eight="790">
  <tr>
    <td height="100" colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1"><img src="../../img/company_logo.png" width="109" height="98" /></td>
          <td>
		  <div align="center"><span style="font-size:22px">Employee's Detail Information </span><br />
            REGENT Personal Management System<br />
            Printed On: <?=date('l, F d, Y')?>

          </div>
		  </td>
          <td width="200" align="center">
		  </div>
		  N/A = Not Applicable
          N/I = No Information
         </td>
        </tr>
    </table>
	</td>
  </tr>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" eight="790">
  <tr>
    <td align="right" bgcolor="#E9E9E9">ID</td>
    <td width="31%" bgcolor="#E9E9E9" style="font-size:18px"><?=$personnel_basic_info->PBI_ID?> </td>
    <td width="14%" align="right" bgcolor="#E9E9E9">Maritial Status</td>
    <td width="14%" bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_MARITAL_STA?></td>
    <td width="18%" rowspan="6" align="center"><img src="../../pic/staff/<?=$employee_selected?>.jpg" width="128" height="126" border="1" /></td>
  </tr>
  <tr>
    <td align="right">Name</td>
    <td><?=$personnel_basic_info->PBI_NAME?></td>
    <td align="right">Nationality</td>
    <td><?=$personnel_basic_info->PBI_NATIONALITY?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9">Father's Name</td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_FATHER_NAME?></td>
    <td align="right" bgcolor="#E9E9E9">Phone </td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_PHONE?></td>
  </tr>
  <tr>
    <td align="right" valign="top">Mother's Name</td>
    <td valign="top"><?=$personnel_basic_info->PBI_MOTHER_NAME?></td>
    <td align="right" valign="top">Mobile</td>
    <td valign="top"><?=$personnel_basic_info->PBI_MOBILE?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9">Company Name</td>
    <td bgcolor="#E9E9E9"><?php echo ($fo[0]);?></td>
    <td align="right" bgcolor="#E9E9E9">E-Mail</td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_EMAIL?></td>
  </tr>
  <tr>
    <td align="right">Department</td>
    <td><?php echo ($find_de[0])?></td>
    <td align="right">Speciality</td>
    <td><?=$personnel_basic_info->PBI_SPECIALTY?> </td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9">Bank Account#</td>
    <td bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_ACC_NO?></td>
    <td align="right" bgcolor="#E9E9E9">Initial Job Type</td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_PRIMARY_JOB_STATUS?></td>
  </tr>
  <tr>
    <td align="right">Designation</td>
    <td><?php echo ($find_des[0])?></td>
    <td align="right">Bank Name</td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_BANK_NAME?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9">Bank Address</td>
    <td bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_BANK_ADDRESS?></td>
    <td align="right" bgcolor="#E9E9E9">Bank Branch</td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_BRANCH?></td>
  </tr>
  <tr>
    <td align="right">Appointment Lette No</td>
    <td><?=$personnel_basic_info->PBI_APPOINTMENT_LETTER_NO?></td>
    <td align="right">Blood Group</td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_BLOOD_GROUP?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9">1st Date of Joining </td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_DOJ?></td>
    <td align="right" bgcolor="#E9E9E9">Voter/National ID</td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_VOTER_ID?></td>
  </tr>
  <tr>
    <td align="right">Total Sevice Length</td>
    <td><?=Date2age($personnel_basic_info->PBI_DOJ)?> </td>
    <td align="right">Passport#</td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_PASSPORT_NO?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9">Joing Date of Present Post </td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_DOJ_PP?></td>
    <td align="right" bgcolor="#E9E9E9">Issue Date</td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_ISSUE_DATE?></td>
  </tr>
  <tr>
    <td align="right">Ser. Length of Present Post</td>
    <td><?=Date2age($personnel_basic_info->PBI_DOJ_PP)?></td>
    <td align="right">Type of Passport</td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_TYPE_OF_PASSPORT?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9">Date of Confirmation</td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_DOC?></td>
    <td align="right" bgcolor="#E9E9E9">Visited Country</td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_VISITED_COUNTRY?></td>
  </tr>
  <tr>
    <td align="right">Date of Birth</td>
    <td><?=$personnel_basic_info->PBI_DOB?></td>
    <td align="right">Driving Licence#</td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_DRIVING_LICENSE_NO?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9">Present Age</td>
    <td bgcolor="#E9E9E9"><?=Date2age($personnel_basic_info->PBI_DOB)?></td>
    <td align="right" bgcolor="#E9E9E9">Type of Licence</td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$essential_info->ESSENTIAL_TYPE_OF_LICENSE?></td>
  </tr>
  <tr>
    <td align="right">Place of Birth(District)</td>
    <td><?=$find_bir[0]?></td>
    <td align="right">TIN#</td>
    <td colspan="2"><?=$essential_info->ESSENTIAL_TIN_NO?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9">Sex</td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_SEX?></td>
    <td align="right" bgcolor="#E9E9E9">Educational Qualification</td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$find_edu[0]?></td>
  </tr>
  <tr>
    <td align="right"> Religion</td>
    <td><?=$personnel_basic_info->PBI_RELIGION?></td>
    <td align="right" bgcolor="#fff"> Job Status</td>
    <td colspan="2" bgcolor="#fff"><?php echo ($find_job[0]); ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9">Permanent Address </td>
    <td bgcolor="#E9E9E9"><?=$personnel_basic_info->PBI_PERMANENT_ADD?>    </td>
    <td align="right" bgcolor="#E9E9E9"> Job Location</td>
    <td colspan="2" bgcolor="#E9E9E9"><?=$personnel_basic_info->JOB_LOCATION?></td>
  </tr>
  <tr>
    <td align="right">Present Address</td>
    <td><?=$personnel_basic_info->PBI_PRESENT_ADD?></td>
	<td align="right">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E9E9E9"> Special Notes /Observation</td>
    <td bgcolor="#E9E9E9"> </td>
  </tr>
</table>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" bgcolor="#AAC6FF"> <strong>Guardian</strong></td>
  </tr>
  <tr>
    <td>Guardian Name</td>
    <td><?=$guardian->GUARDIAN_NAME?></td>
    <td>Mobile No</td>
    <td><?=$guardian->GUARDIAN_MOBILE?></td>
  </tr>
  <tr>
    <td>Relation</td>
    <td><?=$guardian->GUARDIAN_RELATION?></td>
    <td>Profession</td>
    <td><?=$guardian->GUARDIAN_PROFESSION?></td>
  </tr>
  <tr>
    <td>National ID# </td>
    <td><?=$guardian->GUARDIAN_NID?></td>
    <td colspan="2" rowspan="7" align="center" valign="middle"><img src="../../pic/gardian/<?=$employee_selected?>.jpg" width="90" height="110" border="1" /></td>
  </tr>
  <tr>
    <td>E-mail</td>
    <td><?=$guardian->GUARDIAN_EMAIL?></td>
  </tr>
  <tr>
    <td> Working Location </td>
    <td><?=$guardian->GUARDIAN_WORKING_LOCATION?></td>
  </tr>
  <tr>
    <td>Present Address</td>
    <td><?=$guardian->GUARDIAN_PRESENT_ADDRESS?></td>
  </tr>
  <tr>
    <td>Permanent Address</td>
    <td><?=$guardian->GUARDIAN_PERMANENT_ADDRESS?></td>
  </tr>
  <tr>
    <td>Fax No</td>
    <td><?=$guardian->GUARDIAN_FAX?></td>
  </tr>
  <tr>
    <td>Phone No</td>
    <td><?=$guardian->GUARDIAN_PHONE?></td>
  </tr>
</table>
<? if(in_array("3", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="11" bgcolor="#AAC6FF"><strong>Particular: Education</strong></td>
  </tr>
  <tr>
    <td align="center">Exam Name </td>
    <td align="center">Year</td>
    <td align="center">Subject </td>
    <td align="center">Group</td>
    <td align="center">Thesis Topic</td>
    <td align="center">Institute</td>
    <td align="center">Board/ University</td>
    <td align="center">Marks</td>
    <td align="center">Grade/Class</td>
    <td align="center">GPA</td>
    <td align="center">Doc</td>
  </tr>
  <? $res=find_all_field_malti('education_detail','PBI_ID='.$employee_selected);
  	 while($education_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$education_detail->EDUCATION_NOE?></td>
    <td><?=$education_detail->EDUCATION_YEAR?></td>
    <td><?=$education_detail->EDUCATION_SUBJECT?></td>
    <td><?=$education_detail->EDUCATION_GROUP?></td>
    <td><?=$education_detail->EDUCATION_THESIS_TOPIC?></td>
    <td><?=$education_detail->EDUCATION_NOI?></td>
    <td><?=$education_detail->EDUCATION_BU?></td>
    <td><?=$education_detail->EDUCATION_TOTAL_MARK?></td>
    <td><?=$education_detail->EDUCATION_GRADE_CLASS?></td>
    <td><?=$education_detail->EDUCATION_GPA?></td>
    <td><?=$education_detail->EDUCATION_DOCUMENT?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("4", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="8" bgcolor="#AAC6FF"><strong>Particular: Nominee</strong></td>
  </tr>
  <tr>
    <td align="center">Name of Nominee</td>
    <td align="center">Relation</td>
    <td align="center">%</td>
    <td align="center">Address </td>
    <td align="center">Voter ID</td>
    <td align="center">Phone</td>
    <td align="center">Mobile</td>
    <td align="center">Picture</td>
  </tr>
  <? $res=find_all_field_malti('nominee_detail','PBI_ID='.$employee_selected);
  	 while($nominee_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$nominee_detail->NOMINEE_NAME?></td>
    <td><?=$nominee_detail->NOMINEE_RELATION?></td>
    <td><?=$nominee_detail->NOMINEE_PERCENT?></td>
    <td><?=$nominee_detail->NOMINEE_ADDRESS?></td>
    <td><?=$nominee_detail->NOMINEE_VOTER_ID?></td>
    <td><?=$nominee_detail->NOMINEE_PHONE?></td>
    <td><?=$nominee_detail->NOMINEE_MOBILE?></td>
    <td align="right"><img src="../../pic/nominnee/<?=$nominee_detail->NOMINEE_DETAIL_ID?>.jpg" width="47" height="52" border="1" /></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("16", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular: Spouse Information</strong></td>
  </tr>
  <tr>
    <td align="center">Name of Spouse</td>
    <td align="center">Profession</td>
    <td align="center">Address </td>
  </tr>
  <? $res=find_all_field_malti('family_master','PBI_ID='.$employee_selected);
  	 while($family_master=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$family_master->FAMILY_SPOUSE_NAME?></td>
    <td><?=$family_master->FAMILY_SPOUSE_PROFESSION?></td>
    <td><?=$family_master->FAMILY_SPOUSE_ADDRESS?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("17", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular: Child Information</strong></td>
  </tr>
  <tr>
    <td align="center">Name of Child</td>
    <td align="center">Gender</td>
    <td align="center">Birth date</td>
    <td align="center">Profession </td>
  </tr>
  <? $res=find_all_field_malti('child_detail','PBI_ID='.$employee_selected);
  	 while($child_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$child_detail->FAMILY_CHILD_NAME?></td>
    <td><?=$child_detail->FAMILY_CHILD_SEX?></td>
    <td><?=$child_detail->FAMILY_CHILD_DOB?></td>
    <td><?=$child_detail->FAMILY_CHILD_PROFESSION?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("18", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular: Brother and Sister Information</strong></td>
  </tr>
  <tr>
    <td align="center">Name</td>
    <td align="center">Relation</td>
    <td align="center">Profession</td>
    <td align="center">Depend </td>
    <td align="center">Address </td>
  </tr>
  <? $res=find_all_field_malti('brother_sister_detail','PBI_ID='.$employee_selected);
  	 while($brother_sister_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$brother_sister_detail->FAMILY_BS_NAME?></td>
    <td><?=$brother_sister_detail->FAMILY_BS_RELATION?></td>
    <td><?=$brother_sister_detail->FAMILY_BS_PROFESSION?></td>
    <td><?=$brother_sister_detail->FAMILY_BS_DEPEND?></td>
    <td><?=$brother_sister_detail->FAMILY_BS_ADDRESS?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("19", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular: Reference Information</strong></td>
  </tr>
  <tr>
    <td align="center">Referance Person</td>
    <td align="center">profession</td>
    <td align="center">Organization</td>
    <td align="center">Working Location </td>
    <td align="center">Working Location</td>
    <td align="center">Mobile</td>
    <td align="center">Email </td>
  </tr>
  <? $res=find_all_field_malti('reference_person','PBI_ID='.$employee_selected);
  	 while($reference_person=mysql_fetch_object($res)){$pi++;?>
  <tr <? echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$reference_person->RPERSON_F_NAME?></td>
    <td><?=$reference_person->RPERSON_F_PROFESSION?></td>
    <td><?=$reference_person->RPERSON_F_OID?></td>
    <td><?=$reference_person->RPERSON_F_WORKING_LOCATION?></td>
    <td><?=$reference_person->RPERSON_F_RELATION?></td>
    <td><?=$reference_person->RPERSON_F_MOBILE?></td>
    <td><?=$reference_person->RPERSON_F_EMAIL?></td>
  </tr>
    <tr>
    <td><?=$reference_person->RPERSON_S_NAME?></td>
    <td><?=$reference_person->RPERSON_S_PROFESSION?></td>
    <td><?=$reference_person->RPERSON_S_OID?></td>
    <td><?=$reference_person->RPERSON_S_WORKING_LOCATION?></td>
    <td><?=$reference_person->RPERSON_S_RELATION?></td>
    <td><?=$reference_person->RPERSON_S_MOBILE?></td>
    <td><?=$reference_person->RPERSON_S_EMAIL?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("5", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="10" bgcolor="#AAC6FF"><strong>Particular: Transfer</strong></td>
  </tr>
  <tr>
    <td align="center">Transfer Order No</td>
    <td align="center">Date</td>
    <td align="center">Present Domain</td>
    <td align="center">Present Project.</td>
    <td align="center">Present Dept.</td>
    <td align="center">Present Region </td>
    <td align="center">Present Zone</td>
    <td align="center">Present Area</td>
    <td align="center">Present Branch</td>
    <td align="center">Notice</td>
  </tr>
    <? $res=find_all_field_malti('transfer_detail','PBI_ID='.$employee_selected.' order by TRANSFER_AFFECT_DATE desc');
  	 while($transfer_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$transfer_detail->TRANSFER_ORDER_NO?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_AFFECT_DATE?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_PRESENT_DOMAIN?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_PRESENT_PROJECT?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_PRESENT_DEPT?></td>
    <td align="center"><?=find_a_field('region','region_name','region_id='.$transfer_detail->TRANSFER_PRESENT_REGION)?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_PRESENT_ZONE?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_PRESENT_AREA?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_PAST_BRANCH?></td>
    <td align="center"><?=$transfer_detail->TRANSFER_NOTES?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("6", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5" bgcolor="#AAC6FF"><strong>Particular: Promotion</strong></td>
  </tr>
  <tr>
    <td align="center">Type of Promotion</td>
    <td align="center">Date</td>
    <td align="center">Past Designation</td>
    <td align="center">Present Designation</td>
    <td align="center">Level Crossed</td>
  </tr>
    <? $res=find_all_field_malti('promotion_detail','PBI_ID='.$employee_selected);
  	 while($promotion_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$promotion_detail->PROMOTION_TYPE?></td>
    <td align="center"><?=$promotion_detail->PROMOTION_DATE?></td>
    <td align="center"><?=$promotion_detail->PROMOTION_PAST_DESG?></td>
    <td align="center"><?=$promotion_detail->PROMOTION_PRESENT_DESG?></td>
    <td align="center"><?=$promotion_detail->PROMOTION_CROSSED_LEVEL?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("7", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" bgcolor="#AAC6FF"><strong>Particular: Increment</strong></td>
  </tr>
  <tr>
    <td align="center">Increment Type</td>
    <td align="center">Number of Increment</td>
    <td align="center">Date</td>
    <td align="center">Designation</td>
  </tr>
    <? $res=find_all_field_malti('increment_detail','PBI_ID='.$employee_selected);
  	 while($increment_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$increment_detail->INCREMENT_TYPE?></td>
    <td align="center"><?=$increment_detail->INCREMENT_AMT?></td>
    <td align="center"><?=$increment_detail->INCREMENT_EFFECT_DATE?></td>
    <td align="center"><?=$increment_detail->INCREMENT_DESG?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("8", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular: Membership/Donor</strong></td>
  </tr>
  <tr>
    <td align="center">Type</td>
    <td align="center">Year</td>
    <td align="center">Date</td>
    <td align="center">Duration</td>
    <td align="center">Amount</td>
    <td align="center">Arce</td>
    <td align="center">Blood Bag </td>
  </tr>
  <? $res=find_all_field_malti('values_detail','PBI_ID='.$employee_selected);
  	 while($values_detail=mysql_fetch_object($res)){$pi++;
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
<? }if(in_array("9", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular: ED Action </strong></td>
  </tr>
  <tr>
    <td align="center">Action Form </td>
    <td align="center">Action No </td>
    <td align="center">Register No </td>
    <td align="center">Date </td>
    <td align="center">Action Memo No </td>
    <td align="center">Cir. Date</td>
    <td align="center">Cir. By </td>
  </tr>
    <? $res=find_all_field_malti('ed_action_detail','PBI_ID='.$employee_selected);
  	 while($ed_action_detail=mysql_fetch_object($res)){$pi++;?>
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
<? }if(in_array("10", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Particular: Department Action </strong></td>
  </tr>
  <tr>
    <td align="center">Type</td>
    <td align="center">Subject</td>
    <td align="center">Amount</td>
    <td align="center">Memo No </td>
    <td align="center">Date</td>
    <td align="center">Circular By </td>
  </tr>
    <? $res=find_all_field_malti('departmental_objection_detail','PBI_ID='.$employee_selected);
  	 while($departmental_objection_detail=mysql_fetch_object($res)){$pi++;?>
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
<? }if(in_array("11", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Particular: Administrative Action </strong></td>
  </tr>
  <tr>
    <td align="center">Type</td>
    <td align="center">Subject</td>
    <td align="center">Amount</td>
    <td align="center">Memo No </td>
    <td align="center">Date</td>
    <td align="center">Circular By </td>
  </tr>
  <? $res=find_all_field_malti('admin_action_detail','PBI_ID='.$employee_selected);
  	 while($admin_action_detail=mysql_fetch_object($res)){$pi++;?>
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

<? }if(in_array("20", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Particular: Course/Diploma Information </strong></td>
  </tr>
  <tr>
    <td align="center">Title</td>
    <td align="center">Subject</td>
    <td align="center">Year</td>
    <td align="center">Institute</td>
    <td align="center">Duration</td>
    <td align="center">Grade</td>
  </tr>
    <? $res=find_all_field_malti('course_diploma_detail','PBI_ID='.$employee_selected);
  	 while($course_diploma_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$course_diploma_detail->CD_NOCD?></td>
    <td><?=$course_diploma_detail->CD_SUBJECT?></td>
    <td align="center"><?=$course_diploma_detail->CD_PASSING_YEAR?></td>
    <td><?=$course_diploma_detail->CD_NOI?></td>
    <td align="center"><?=$course_diploma_detail->CD_DURATION?></td>
    <td align="center"><?=$course_diploma_detail->CD_GRADE_CLASS?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("21", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Particular: Experience Information </strong></td>
  </tr>
  <tr>
    <td align="center">Organization</td>
    <td align="center">Job Nature</td>
    <td align="center">From</td>
    <td align="center">To</td>
    <td align="center">Length</td>
    <td align="center">Post </td>
  </tr>
  <? $res=find_all_field_malti('experience_detail','PBI_ID='.$employee_selected);
  	 while($experience_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$experience_detail->EXPERIENCE_NOO?></td>
    <td><?=$experience_detail->EXPERIENCE_JOB_NATURE?></td>
    <td align="center"><?=$experience_detail->EXPERIENCE_FROM?></td>
    <td><?=$experience_detail->EXPERIENCE_TO?></td>
    <td><?=$experience_detail->EXPERIENCE_LENGTH?></td>
    <td><?=$experience_detail->EXPERIENCE_POST?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("22", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular:  	Leave Information</strong></td>
  </tr>
  <tr>
    <td align="center">Year</td>
    <td align="center">Casual Leave</td>
    <td align="center">Matutity Leave</td>
    <td align="center">Maternity Leave </td>
    <td align="center">Paternity Leave</td>
    <td align="center">Transfer Leave</td>
    <td align="center">LWP Leave</td>
  </tr>
    <? $res=find_all_field_malti('leave_detail','PBI_ID='.$employee_selected);
  	 while($leave_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$leave_detail->LEAVE_YEAR?></td>
    <td><?=$leave_detail->LEAVE_CL_AVAIL?></td>
    <td align="center"><?=$leave_detail->LEAVE_ML_AVAIL?></td>
    <td><?=$leave_detail->LEAVE_MATERNITY?></td>
    <td align="center"><?=$leave_detail->LEAVE_PATERNITY?></td>
    <td align="center"><?=$leave_detail->LEAVE_TRANSFER?></td>
    <td align="center"><?=$leave_detail->LEAVE_LWP?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("23", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Particular: Training Information </strong></td>
  </tr>
  <tr>
    <td align="center">Name</td>
    <td align="center">From</td>
    <td align="center">To</td>
    <td align="center">Length</td>
    <td align="center">Duration</td>
    <td align="center">Country</td>
  </tr>
  <? $res=find_all_field_malti('training_detail','PBI_ID='.$employee_selected);
  	 while($training_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$training_detail->TRAINING_NAME?></td>
    <td><?=$training_detail->TRAINING_DATE_FROM?></td>
    <td align="center"><?=$training_detail->TRAINING_DATE_TO?></td>
    <td><?=$training_detail->TRAINING_LENGTH?></td>
    <td><?=$training_detail->TRAINING_DURATION?></td>
    <td><?=$training_detail->TRAINING_COUNTRY?></td>
  </tr>
  <? }?>
</table>

<? }if(in_array("25", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Particular: Demotion Information </strong></td>
  </tr>
  <tr>
    <td align="center">Reason</td>
    <td align="center">Date</td>
    <td align="center">Past Desg.</td>
    <td align="center">Present Desg.</td>
    <td align="center">Grade Down</td>
  </tr>
  <? $res=find_all_field_malti('demotion_detail','PBI_ID='.$employee_selected);
  	 while($demotion_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$demotion_detail->DEMOTION_REASON?></td>
    <td><?=$demotion_detail->DEMOTION_DATE?></td>
    <td align="center"><?=$demotion_detail->DEMOTION_PAST_DESG?></td>
    <td><?=$demotion_detail->DEMOTION_PRESENT_DESG?></td>
    <td><?=$demotion_detail->DEMOTION_CROSSED_LEVEL?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("26", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular:  	Relative Information</strong></td>
  </tr>
  <tr>
  	<td align="center">ID</td>
    <td align="center">Name of Relative</td>
    <td align="center">Depart.</td>
    <td align="center">Desg.</td>
    <td align="center">Location</td>
    <td align="center">Job Status</td>
    <td align="center">Relation</td>
  </tr>
    <? $res=find_all_field_malti('relative_detail','PBI_ID='.$employee_selected);
  	 while($relative_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
  <td><?=$relative_detail->RELATIVE_ID?></td>
    <td><?=$relative_detail->RELATIVE_NAME?></td>
    <td><?=$relative_detail->RELATIVE_DEPARTMENT?></td>
    <td align="center"><?=$relative_detail->RELATIVE_DESIGNATION?></td>
    <td><?=$relative_detail->RELATIVE_LOCATION 	?></td>
    <td align="center"><?=$relative_detail->RELATIVE_JOB_STATUS?></td>
    <td align="center"><?=$relative_detail->RELATIVE_RELATION?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("27", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="11" bgcolor="#AAC6FF"><strong>Particular: Posting Information </strong></td>
  </tr>
  <tr>
    <td align="center">Name</td>
    <td align="center">Desg.</td>
    <td align="center">Domain</td>
    <td align="center">Project</td>
    <td align="center">Depart.</td>
    <td align="center">Region</td>
    <td align="center">Zone</td>
    <td align="center">Area</td>
    <td align="center">Branch</td>
    <td align="center">by</td>
    <td align="center">Order No.</td>
  </tr>
  <? $res=find_all_field_malti('posting','PBI_ID='.$employee_selected);
  	 while($posting=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$posting->POSTING_NAME?></td>
    <td><?=$posting->POSTING_DESIGNATION?></td>
    <td align="center"><?=$posting->POSTING_DOMAIN?></td>
    <td><?=$posting->POSTING_PROJECT?></td>
    <td><?=$posting->POSTING_DEPARTMENT?></td>
    <td><?=find_a_field('region','region_name','region_id='.$transfer_detail->POSTING_REGION)?></td>
    <td><?=$posting->POSTING_ZONE ?></td>
    <td align="center"><?=$posting->POSTING_AREA?></td>
    <td><?=$posting->POSTING_BRANCH?></td>
    <td><?=$posting->POSTING_BY?></td>
    <td><?=$posting->POSTING_MEMO ?></td>
  </tr>
  <? }?>
</table>

<? }if(in_array("28", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Particular:  Financial Objection</strong></td>
  </tr>
  <tr>
    <td align="center">Type</td>
    <td align="center">Amount</td>
    <td align="center">Memo No.</td>
    <td align="center">Date</td>
    <td align="center">by</td>
  </tr>
    <? $res=find_all_field_malti('financial_objection_detail','PBI_ID='.$employee_selected);
  	 while($financial_objection_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$financial_objection_detail->FINANCIAL_OBJECTION_TYPE?></td>
    <td><?=$financial_objection_detail->FINANCIAL_OBJECTION_AMT?></td>
    <td align="center"><?=$financial_objection_detail->FINANCIAL_OBJECTION_MEMO_NO?></td>
    <td><?=$financial_objection_detail->FINANCIAL_OBJECTION_DATE 	?></td>
    <td align="center"><?=$financial_objection_detail->FINANCIAL_OBJECTION_BY?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("29", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Particular: Project Information </strong></td>
  </tr>
  <tr>
    <td align="center">Name</td>
    <td align="center">Desg.</td>
    <td align="center">Joining Date</td>
    <td align="center">Duration</td>
    <td align="center">Location</td>
  </tr>
  <? $res=find_all_field_malti('project_staff_detail','PBI_ID='.$employee_selected);
  	 while($project_staff_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$project_staff_detail->PS_NOP?></td>
    <td align="center"><?=$project_staff_detail->PS_DESIGNATION?></td>
    <td align="center"><?=$project_staff_detail->PS_DOJ?></td>
    <td><?=$project_staff_detail->PS_DURATION?></td>
    <td><?=$project_staff_detail->PS_WORKING_LOCATION?></td>
  </tr>
  <? }?>
</table>

<? }if(in_array("12", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="8" bgcolor="#AAC6FF"><strong>Particular: Quarter/Dormitory/Hostel </strong></td>
  </tr>
  <tr>
    <td align="center">Type</td>
    <td align="center">QDH Name </td>
    <td align="center">Location</td>
    <td align="center">Rent</td>
    <td align="center">Issue Date</td>
    <td align="center">Cancel Date</td>
    <td align="center">Duration</td>
    <td align="center">Status</td>
  </tr>
    <? $res=find_all_field_malti('quarter_detail','PBI_ID='.$employee_selected);
  	 while($quarter_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td><?=$quarter_detail->QUARTER_TYPE?></td>
    <td align="center"><?=$quarter_detail->QUARTER_NAME?></td>
    <td align="center"><?=$quarter_detail->QUARTER_LOCATION?></td>
    <td align="center"><?=$quarter_detail->QUARTER_RENT?></td>
    <td align="center"><?=$quarter_detail->QUARTER_ISSUE_DATE?></td>
    <td align="center"><?=$quarter_detail->QUARTER_CANCEL_DATE?></td>
    <td align="center"><?=$quarter_detail->QUARTER_DURATION?> </td>
    <td align="center"><?=$quarter_detail->QUARTER_STATUS?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("13", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7" bgcolor="#AAC6FF"><strong>Particular: APR</strong></td>
  </tr>
  <tr>
    <td align="center">Year</td>
    <td align="center">Recomondation</td>
    <td align="center">Marks</td>
    <td align="center">Status</td>
    <td align="center">Result</td>
    <td align="center">Past Designation </td>
    <td align="center">Present Designation</td>
  </tr>
    <? $res=find_all_field_malti('apr_detail','PBI_ID='.$employee_selected);
  	 while($apr_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td align="center"><?=$apr_detail->APR_YEAR?></td>
    <td align="center"><?=$apr_detail->APR_RECOMMENDATION?></td>
    <td align="center"><?=$apr_detail->APR_MARKS?></td>
    <td align="center"><?=$apr_detail->APR_STATUS?></td>
    <td align="center"><?=$apr_detail->APR_RESULT?></td>
    <td align="center"><?=$apr_detail->APR_DESG_FROM?></td>
    <td align="center"><?=$apr_detail->APR_DESG_TO?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("14", $_POST['point'])){?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="9" bgcolor="#AAC6FF"><strong>Particular: Motor Cycle </strong></td>
  </tr>
  <tr>
    <td align="center">Date</td>
    <td align="center">Company</td>
    <td align="center">Model</td>
    <td align="center">CC</td>
    <td align="center">Engine No </td>
    <td align="center">Chassis No </td>
    <td align="center">Total Price </td>
    <td align="center">Register No </td>
    <td align="center">Status</td>
  </tr>
    <? $res=find_all_field_malti('motor_cycle_detail','PBI_ID='.$employee_selected);
  	 while($motor_cycle_detail=mysql_fetch_object($res)){$pi++;?>
  <tr <? if($pi%2) echo ' bgcolor="#E9E9E9"';?>>
    <td align="center"><?=$motor_cycle_detail->MC_RECEIVED_DATE?></td>
    <td align="center"><?=$motor_cycle_detail->MC_COMPANY?></td>
    <td align="center"><?=$motor_cycle_detail->MC_MODEL?></td>
    <td align="center"><?=$motor_cycle_detail->MC_CC?></td>
    <td align="center"><?=$motor_cycle_detail->MC_ENGINE_NO?></td>
    <td align="center"><?=$motor_cycle_detail->MC_CHASSIS_NO?></td>
    <td align="center"><?=$motor_cycle_detail->MC_TOTAL_PRICE?></td>
    <td align="center"><?=$motor_cycle_detail->MC_REGISTRATION_NO?></td>
    <td align="center"><?=$motor_cycle_detail->MC_RECEIVED_STATUS?></td>
  </tr>
  <? }?>
</table>
<? }if(in_array("15", $_POST['point'])){?>
<table width="100%" height="86" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" bgcolor="#AAC6FF"><strong>Personal File Check List </strong></td>
  </tr>
  <tr>
    <td align="center">File/Document</td>
    <td align="center">Status</td>
    <td align="center">File/Document</td>
    <td align="center">Status</td>
    <td align="center">File/Document</td>
    <td align="center">Status</td>
  </tr>
  <tr bgcolor="#E9E9E9">
    <td align="right">CV</td>
    <td align="center"><?=$pf_status->PF_STATUS_CV?></td>
    <td align="right">Guardian's Affidavit </td>
    <td align="center"><?=$pf_status->PF_STATUS_G_AFFIDAVIT?></td>
    <td align="right">Security Money Rceipt</td>
    <td align="center"><?=$pf_status->PF_STATUS_SM_RECITE?></td>
  </tr>
  <tr>
    <td align="right">Appointment Letter</td>
    <td align="center"><?=$pf_status->PF_STATUS_APPOINTMENT_LETTER?></td>
    <td align="right">Guardian Certify Letter </td>
    <td align="center"><?=$pf_status->PF_STATUS_G_CERTIFY_LETTER?></td>
    <td align="right">Received Aya Allowance</td>
    <td align="center"><?=$pf_status->PF_STATUS_R_AYA_A?></td>
  </tr>
  <tr bgcolor="#E9E9E9">
    <td align="right">Joining Letter</td>
    <td align="center"><?=$pf_status->PF_STATUS_JOINING_LETTER?></td>
    <td align="right">Guardian's Photo</td>
    <td align="center"><?=$pf_status->PF_STATUS_G_PHOTO?></td>
    <td align="right">Posting Letter</td>
    <td align="center"><?=$pf_status->PF_STATUS_POSTING_LETTER?></td>
  </tr>
  <tr>
    <td align="right">Employee's Affidavit</td>
    <td align="center"><?=$pf_status->PF_STATUS_E_AFFIDAVIT?></td>
    <td align="right">Medical Certificate</td>
    <td align="center"><?=$pf_status->EPF_STATUS_MC?></td>
    <td align="right">Clearance Certificate</td>
    <td align="center"><?=$pf_status->PF_STATUS_C_CERTIFICATE?></td>
  </tr>
  <tr bgcolor="#E9E9E9">
    <td align="right">Nominee</td>
    <td align="center"><?=$pf_status->PF_STATUS_NOMINEE?></td>
    <td align="right">Nominee Photo</td>
    <td align="center"><?=$pf_status->PF_STATUS_NOMINEE_PHOTO?></td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr bgcolor="#E9E9E9">
    <td align="right">Certificate Received</td>
    <td align="center"><?=$pf_status->RECEIVED_CERTIFICATE?></td>
    <td align="right">Employee Varification Form</td>
    <td align="center"><?=$pf_status->EMPLOYEE_VARIFICATION_FORM?></td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr bgcolor="#E9E9E9">
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<? }?>
</body>
</html>
<? }?>