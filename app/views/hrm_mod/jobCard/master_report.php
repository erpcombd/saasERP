<?





session_start();








require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{



	if($_POST['fdate']!='')
  $fdate = $_POST['fdate'];

  if($_POST['tdate']!='')
  $tdate = $_POST['tdate'];


  if($_POST['jfdate']!='')
  $jfdate = $_POST['jfdate'];

  if($_POST['jtdate']!='')
  $jtdate = $_POST['jtdate'];



	if($_POST['name']!='')
	$con.=' and a.PBI_NAME like "%'.$_POST['name'].'%"';

	if($_POST['PBI_ORG']!=''){
	if($_POST['report']==64&&$_POST['PBI_ORG']=='2')

	$con.=' and a.PBI_ORG IN (1,2,3,4,5,6)';
	else $con.=' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';
	}



	if($_POST['PBI_ORG']!='')
	$con2.=' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	if($_POST['shedule_no']!='')
	$roster_con.=' and s.shedule_no = "'.$_POST['shedule_no'].'"';


if($_POST['shedule_no']!='')
	$att_roster_con.=' and s.shedule_1 = "'.$_POST['shedule_no'].'"';





if($_POST['mess_bill_type']!='')
	$con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';


	if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';


	if($_POST['shedule_no']!='')
	$con2.=' and r.shedule_1 = "'.$_POST['shedule_no'].'"';


	if($_POST['department']!=''){
	$con.=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';
	$DEPARTMENT_con=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';
	}
	if($_POST['project']!='')
	$con.=' and a.PBI_PROJECT = "'.$_POST['project'].'"';

	if($_POST['designation']!='')
	$con.=' and a.PBI_DESIGNATION = "'.$_POST['designation'].'"';
	$DESIGNATION_con.=' and a.PBI_DESIGNATION = "'.$_POST['designation'].'"';



	if($_POST['PBI_RESIDENT']!='')
	$con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

	if($_POST['payroll_type']!='')
	$con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';



	if($_POST['salary_shift']!='')
	$con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

	if($_POST['temporary_id']!='')
	$con.=' and a.temporary_id = "'.$_POST['temporary_id'].'"';

	if($_POST['zone']!='')
	$con.=' and a.PBI_ZONE = "'.$_POST['zone'].'"';

	if($_POST['JOB_LOCATION']!=''){
	$con.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';
	$PBI_LOCATION_con=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';
	}

	if($_POST['PBI_GROUP']!=''){
	$con.=' and a.PBI_GROUP = "'.$_POST['PBI_GROUP'].'"';
	$PBI_GROUP_con=' and a.PBI_GROUP = "'.$_POST['PBI_GROUP'].'"';
	}

	if($_POST['area']!='')
	$con.=' and a.PBI_AREA = "'.$_POST['area'].'"';

	if($_POST['report']!=778 && $_POST['report']!=79){
	if($_POST['branch']!='') $con.=' and t.pbi_region ="'.$_POST['branch'].'"';}


	if($_POST['PBI_DOMAIN']!='')	$con .= " and PBI_DOMAIN = '".$_POST['PBI_DOMAIN']."'";
	if($_POST['job_status']!='' && $_POST['report']!=7811 && $_POST['report']!=60 && $_POST['report']!=61)
	$con.=' and a.PBI_JOB_STATUS = "'.$_POST['job_status'].'"';
	if($_POST['gender']!='')
	$con.=' and a.PBI_SEX = "'.$_POST['gender'].'"';

	if($_POST['ijdb']!='')
	$con.=' and a.PBI_DOJ < "'.$_POST['ijdb'].'"';

	if($_POST['ppjdb']!='')
	$con.=' and a.PBI_DOJ_PP < "'.$_POST['ppjdb'].'"';

	if($_POST['ijda']!='')
	$con.=' and a.PBI_DOJ > "'.$_POST['ijda'].'"';

	if($_POST['ppjda']!='')
	$con.=' and a.PBI_DOJ_PP > "'.$_POST['ppjda'].'"';

		if($_POST['start_date']!='')
	$start_date = $_POST['start_date'];
	if($_POST['end_date']!='')
	$end_date = $_POST['end_date'];

	if($_POST['pbi_id_in']!='')  $con .= " and a.PBI_ID in (".$_POST['pbi_id_in'].")";

switch ($_POST['report']) {


case 1:
$report="Employee Basic Information";


 $sql="select
a.PBI_ID as CODE,a.PBI_NAME as Name,
(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,
a.PBI_DEPARTMENT as department,
a.PBI_DOMAIN as section,
a.PBI_FATHER_NAME as father,a.PBI_MOTHER_NAME as mother,
a.incharge_id,a.head_id,
a.PBI_GROUP as `Group`,
DATE_FORMAT(a.PBI_DOJ,'%d-%m-%Y') as joining_date,

DATE_FORMAT(a.PBI_DOC2,'%d-%m-%Y') as confirmation_date,
CONCAT(
TIMESTAMPDIFF(YEAR, `PBI_DOJ`, CURDATE()),' Year,',TIMESTAMPDIFF(MONTH, `PBI_DOJ`, CURDATE()) % 12
,' mon'
) as service,

(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,
(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,
(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,
a.PBI_MOBILE as mobile
from personnel_basic_info a
where	1 ".$con;

// DATE_FORMAT(a.PBI_DOC,'%d-%m-%Y') as due_confirmation_date,
// (select DESG_DESC from designation where DESG_SHORT_NAME=a.PBI_DESIGNATION) as designation,
break;


case 22:
$report="Employee Payroll Information For Recruitment";


 $sql="select
(select group_name from user_group where id = a.PBI_ORG) as company,
(select office_location from office_location where id=a.job_location) as location,
(select dept_desc from department where DEPT_SHORT_NAME = a.PBI_DEPARTMENT) as department,

a.PBI_ID as CODE,
a.PBI_NAME as Name,
(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,


DATE_FORMAT(a.PBI_DOJ,'%d-%m-%Y') as DOJ,
DATE_FORMAT(a.PBI_DOC2,'%d-%m-%Y') as DOC,
CONCAT(TIMESTAMPDIFF(YEAR, `PBI_DOJ`, CURDATE()),' Year,',TIMESTAMPDIFF(MONTH, `PBI_DOJ`, CURDATE()) % 12,' mon') as service,
a.PBI_EDU_QUALIFICATION as qualification,

a.PBI_GROUP as `Group`,
(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,
(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,
(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,


a.PBI_MOBILE as mobile,
s.basic_salary,
s.special_allowance as sp_Allow,
s.incentive_allowance as inc_allow,
s.ta as ta_da,
s.food_allowance as food_allow,
s.mobile_allowance as mobile_allow,
s.house_rent


from personnel_basic_info a , salary_info s
where
a.PBI_ID=s.PBI_ID
".$con."
order by a.PBI_ID"
;

break;


case 23:
$report="Employee Payroll Information";


 $sql="select
(select group_name from user_group where id = a.PBI_ORG) as company,
(select office_location from office_location where id=a.job_location) as location,
(select dept_desc from department where DEPT_SHORT_NAME = a.PBI_DEPARTMENT) as department,

a.PBI_ID as CODE,
a.PBI_NAME as Name,
(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,

a.PBI_GROUP as `Group`,
(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,
(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,
(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,

a.PBI_MOBILE as mobile,
s.basic_salary,
s.special_allowance as sp_Allow,
s.incentive_allowance as inc_allow,
s.ta as ta_da,
s.food_allowance as food_allow,
s.mobile_allowance as mobile_allow,
s.house_rent,
s.cash_bank as bank,s.cash as bank_code,s.branch_info,


(select pbi_held_up from salary_attendence where PBI_ID=a.PBI_ID order by id desc limit 1) as held_up

from personnel_basic_info a , salary_info s
where
a.PBI_ID=s.PBI_ID
".$con."
order by a.PBI_ID"
;

break;


case 201:
$report="Employee Leave Information";
break;

		case 22222:
		$report= "HRM Roaster Summary report";
		break;

case 777:
	$report="Employee Bonus Report";
if($_POST['branch']!='')
$con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

        $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation, date_format(a.PBI_DOJ,'%d-%m-%Y') as joining_date,
		if(s.bonus_mode!='Bank','',s.cash) as bank_AC,
		b.basic_salary,
		if((bonus_days<180 && job_status!='Permanent'), bonus_days, '') as payable_days,
		b.bonus_amt as Bonus_amount,
		b.bank_paid,
		if(s.cash_bank='DBBL', b.bank_paid, '') as DBBL ,
		if(s.cash_bank='IBBL', b.bank_paid, '') as IBBL ,
		b.cash_paid,
		' ' as Signature
		from
		personnel_basic_info a, salary_bonus b, salary_info s
		where
		1 and a.PBI_ID=b.PBI_ID and
		s.PBI_ID=b.PBI_ID and b.bonus_type=".$_POST['bonus_type']." and
		b.year=".$_POST['year']." ".$con. "
		and b.pbi_held_up = 0
		order by a.pbi_grade desc,b.bonus_amt desc,a.PBI_DESG_GRADE asc
		";
		// a.PBI_JOB_STATUS= 'In Service'

break;



case 7711:
		$report= "Monthly Salary Sheet";
		break;


case 771171:
		$report= "Monthly Salary Sheet Summary";
		break;

		case 77117171:
		$report= "Monthly Salary Sheet Summary";
		break;

		case 2122019:
		$report= "Monthly Salary Sheet Summary";
		break;



case 212201911:
		$report= "Monthly Salary Sheet Summary";
		break;



case 220419001:
		$report= "Eid Bonus Report";
		break;



		case 210713001:
		$report= "Partial Salary Report";
		break;



		case 21220191122:
		$report= "Monthly Salary Sheet Summary";
		break;

		case 210713002:
		$report= "Partial Salary Report";
		break;

		case 212201912:
		$report= "Partial Salary Payroll Report";
		break;


		case 212201922:
		$report= "Employee List For Salary Increment";
		break;


		case 220607001:
		$report= "Employee Information";
		break;


		case 212201933:
		$report= "Employee Contact Information";
		break;


case 21220193301:
		$report= "Employee Essential Information";
		break;

		case 220126001:
		$report= "Employee Leave Information";
		break;


		case 22042101:
		$report= "Employee PF Information";
		break;


		case 7711717121:
		$report= "Monthly Mess &amp; Dormitory Bill";
		break;


		case 7711717121050121:
		$report= "Monthly Mess Bill Report";
		break;

		case 771171712111:
		$report= "Mess &amp; Dormitory Bill (Partial Salary)";
		break;

		case 7711717122:
		$report= "Department Wise Consolidated Mess Bill";
		break;

		case 771171712212:
		$report= "Department Wise Consolidated Mess Bill (Partial Salary)";
		break;


case 771171712121:
		$report= "Monthly Attendance Bonus &amp; Mess Dormitory Bill";
		break;



case 7713:
		$report= "Monthly Attendence Report";
		break;





case 7714:
$report="Daily Absent Report";
break;



case 7723:
$report="Employee Salary Information";
break;



case 9999999:

				$report="Salary Pay Slip";

				if($_POST['mon']>0&&$_POST['year']>0)

				{

				$mon = $_POST['mon'];

				$year = $_POST['year'];

					}

			break;


case 7715:
$report="Daily Attendance Report";
break;



case 771520012020:
$report="Daily Attendance Report";
break;

case 771506022020:
$report="Daily Attendance Late &amp; Absent Report";
break;


case 771511:
$report="Daily Attendance Late Report";
break;



case 64:
	$report="Employee Bonus Summery Report";

if($_POST['branch']!='') $con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';


$sql="
select d.DEPT_DESC as department,
sum(b.basic_salary) as basic_salary,
sum(b.bonus_amt) as Bonus_amount,
sum(b.bank_paid) as bank_paid,
if(s.cash_bank='DBBL', sum(b.bank_paid), '') as DBBL ,
if(s.cash_bank='IBBL', sum(b.bank_paid), '') as IBBL ,
sum(b.cash_paid) as cash_paid,
sum(b.bonus_amt) as net_payable,
' ' as Remarks

from personnel_basic_info a, salary_bonus b, salary_info s,department d

where 1
and b.PBI_ID=a.PBI_ID
and b.pbi_department=d.DEPT_SHORT_NAME
and s.PBI_ID=b.PBI_ID
and b.bonus_type=".$_POST['bonus_type']."
and b.year=".$_POST['year']." ".$con. "

group by d.DEPT_DESC
order by d.DEPT_DESC
";

break;

case 65:
$report="Employee Bonus Sales Summery Report";

if($_POST['branch']!='') $con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';


echo $sql="
select br.BRANCH_NAME as region,
sum(b.basic_salary) as basic_salary,
sum(b.bonus_amt) as Bonus_amount,
sum(b.bank_paid) as bank_paid,

if(s.cash_bank='DBBL', sum(b.bank_paid), '') as DBBL,
if(s.cash_bank='ROCKET', sum(b.bank_paid), '') as ROCKET,
if(s.cash_bank='IBBL', sum(b.bank_paid), '') as IBBL,

sum(b.cash_paid) as cash_paid,
sum(b.bonus_amt) as net_payable, ' ' as Remarks

from personnel_basic_info a, salary_bonus b, salary_info s, branch br

where 1
and a.PBI_BRANCH=br.BRANCH_ID
and b.PBI_ID=a.PBI_ID
and s.PBI_ID=b.PBI_ID
and a.PBI_ID=s.PBI_ID

and a.PBI_DEPARTMENT = 'Sales'
and b.bonus_type=".$_POST['bonus_type']."
and b.year=".$_POST['year']."
".$con. "

group by br.BRANCH_NAME
order by br.BRANCH_NAME
";

break;

    case 778:
	$report="Employee Bonus Report (Sales)";
if($_POST['branch']!='')
$con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

       $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation, date_format(a.PBI_DOJ,'%d-%m-%Y') as joining_date,
		 if(b.cash_paid>0 && a.PBI_AREA!='',(select concat('[',d.dealer_code,'] - ',d.dealer_name_e,' - ',aa.AREA_NAME) from  dealer_info d, area aa where d.dealer_code=b.dealer_code and d.area_code=aa.AREA_CODE),'') as dealer_name,
		if(s.bonus_mode!='Bank','',s.cash) as bank_AC,
		b.basic_salary,
		if((bonus_days<180 && job_status!='Permanent'), bonus_days, '') as payable_days,
		b.bonus_amt as Bonus_amount,
		b.bank_paid,
		if(s.cash_bank='DBBL', b.bank_paid, '') as DBBL ,
		if(s.cash_bank='ROCKET', b.bank_paid, '') as ROCKET ,
		if(s.cash_bank='IBBL', b.bank_paid, '') as IBBL ,
		b.cash_paid,
		' ' as Signature
		from
		personnel_basic_info a, salary_bonus b, salary_info s
		where
		1 and a.PBI_ID=b.PBI_ID and
		s.PBI_ID=b.PBI_ID and b.bonus_type=".$_POST['bonus_type']." and
		b.year=".$_POST['year']." ".$con. "
		and b.pbi_held_up = 0
		order by b.bonus_amt desc,a.PBI_DESG_GRADE asc
		";

break;



case 10001:

	$report="Employee Basic Information";


	//if(isset($_POST['PBI_ORG']!='')) {

		//$str 	.= '<h2>Dealer Name : '.$_POST['PBI_ORG'].' - '.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';

	//if($_POST['PBI_ORG']!='')

//{

	//$concern = '<h2>Concern Name : '.$_POST['PBI_ORG'].' - '.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';




    $sql="select a.PBI_ID as CODE,  a.PBI_CODE as PBI_ID, a.EMP_CODE, a.PBI_NAME as Name,(select DESG_DESC from designation where DESG_ID=a.PBI_DESIGNATION) as designation,(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department,DATE_FORMAT(a.PBI_DOJ,'%d-%b-%Y') as joining_date,a.PBI_SERVICE_LENGTH as total_service_length,a.PBI_MOBILE as mobile,PBI_JOB_STATUS as job_status  from personnel_basic_info a where	a.payroll_type=2 ".$con." order by a.EMP_CODE ";

//}
break;



 case 10003:

	$report="Employee Basic Information (Detail)";


	//if(isset($_POST['PBI_ORG']!='')) {

		//$str 	.= '<h2>Dealer Name : '.$_POST['PBI_ORG'].' - '.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';

	//if($_POST['PBI_ORG']!='')

//{

	//$concern = '<h2>Concern Name : '.$_POST['PBI_ORG'].' - '.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';




    $sql="select a.PBI_ID as CODE,  a.PBI_CODE as PBI_ID, a.PBI_NAME as Name,a.PBI_NAME_BANGLA, a.PBI_FATHER_NAME as father_name, a.PBI_MOTHER_NAME as mother_name, (select DESG_DESC from designation where DESG_ID=a.PBI_DESIGNATION) as designation,(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department, (select group_name from user_group where id=a.PBI_ORG) as organization, DATE_FORMAT(a.PBI_DOJ,'%d-%b-%Y') as joining_date,a.PBI_SERVICE_LENGTH as total_service_length, a.PBI_MOBILE as mobile, a.PBI_APPOINTMENT_LETTER_NO, a.PBI_APPOINTMENT_LETTER_DATE, a.PBI_DOJ, a.PBI_DOL, a.PBI_SERVICE_LENGTH_YEAR, a.PBI_DOJ_PP, a.PBI_SERVICE_LENGTH_PP, a.PBI_SERVICE_LENGTH_PP_YEAR, a.PBI_DOC, a.PBI_MONTH, a.PBI_YEAR, a.PBI_DOB, a.PBI_PRESENT_AGE, a.PBI_PRESENT_AGE_YEAR, a.PBI_POB, a.PBI_EDU_QUALIFICATION, a.PBI_SEX, a.PBI_MARITAL_STA, a.PBI_RELIGION, a.PBI_NATIONALITY, a.PBI_PERMANENT_ADD, a.PBI_PRESENT_ADD, a.PBI_PHONE, a.PBI_MOBILE_ALTR, a.PBI_EMAIL, a.PBI_EMAIL_ALT, a.PBI_SPECIALTY, a.PBI_PRIMARY_JOB_STATUS, a.JOB_STATUS_DATE, a.U_ID, a.USED_DT, a.personal_file_status, a.institute_id, (select warehouse_name from warehouse where warehouse_id=a.JOB_LOCATION) as job_location, a.extended_upto, a.PBI_DOC2, a.ESSENTIAL_BLOOD_GROUP, a.ESSENTIAL_TIN_NO, a.ESSENTIAL_VOTER_ID, a.ESSENTIAL_DRIVING_LICENSE_NO, a.PBI_COB, a.PBI_SPOUSE, a.PBI_PRESENT_CITY_ADD, a.PBI_PRESENT_STREET_ADD, a.PBI_PRESENT_APRT_ADD, a.PBI_PRESENT_DIST_ADD, (select l_name from location where l_id=a.PBI_PRESENT_THANA_ADD) as thana, a.PBI_PARM_STREET_ADD, a.PBI_PARM_APRT_ADD, a.PBI_PARM_THANA_ADD, a.PBI_PARM_DIST_ADD, a.PBI_PARM_CITY_ADD, a.EMR_FULL_NAME, a.EMR_MOBILE, a.EMR_RELATION, a.EMR_ADDRESS, a.EMR_EMAIL, a.PBI_BANK, a.PBI_BANK_BRANCH, a.PBI_BANK_SWIFT, a.PBI_BANK_ACC_NAME, a.PBI_BANK_ACC_NO, a.PBI_REF1_NAME, PBI_JOB_STATUS as job_status  from personnel_basic_info a where 1 ".$con;

//}
break;





case 20003:

	$report="Daily Attendance  Report";


	//if(isset($_POST['PBI_ORG']!='')) {

		//$str 	.= '<h2>Dealer Name : '.$_POST['PBI_ORG'].' - '.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';

	//if($_POST['PBI_ORG']!='')

//{

	//$concern = '<h2>Concern Name : '.$_POST['PBI_ORG'].' - '.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';

	//$sql="select a.PBI_ID as CODE,  a.PBI_CODE as PBI_ID, a.PBI_NAME as Name  from personnel_basic_info a, hr_employee b where	a.ATT_ID=b.id ";


	if($_POST['sch_in_time']!=''&&$_POST['sch_out_time']!='')
$con .= " AND a.sch_in_time='".$_POST['sch_in_time']."' AND a.sch_out_time='".$_POST['sch_out_time']."'  ";


     $sql="SELECT p.PBI_ID, p.PBI_CODE, p.PBI_NAME, a.att_date, a.dayname as Day_Name, a.in_time,  IF(a.in_time> concat(a.att_date,' ',a.sch_in_time), 'LATE', 'REGULER') as in_status,  a.out_time,  IF(a.out_time< concat(a.att_date,' ',a.sch_out_time), 'EARLY', 'REGULER') as out_status FROM hrm_att_summary a, personnel_basic_info p WHERE a.emp_id=p.PBI_ID and a.att_date BETWEEN '".$_POST['fdate']."' AND '".$_POST['tdate']."'  ".$con;

//}
break;




  case 20000:

	$report="Attendance Machine Access Information";


	//if(isset($_POST['PBI_ORG']!='')) {

		//$str 	.= '<h2>Dealer Name : '.$_POST['PBI_ORG'].' - '.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';

	//if($_POST['PBI_ORG']!='')

//{

	//$concern = '<h2>Concern Name : '.$_POST['PBI_ORG'].' - '.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';

	//$sql="select a.PBI_ID as CODE,  a.PBI_CODE as PBI_ID, a.PBI_NAME as Name  from personnel_basic_info a, hr_employee b where	a.ATT_ID=b.id ";


    $sql="select b.id as Machine_ID, b.emp_pin from hr_employee b where 1 order by b.id desc";

//}
break;





  case 20001:

	$report="Attendance Machine Integration Information";


	//if(isset($_POST['PBI_ORG']!='')) {

		//$str 	.= '<h2>Dealer Name : '.$_POST['PBI_ORG'].' - '.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';

	//if($_POST['PBI_ORG']!='')

//{

	//$concern = '<h2>Concern Name : '.$_POST['PBI_ORG'].' - '.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';

	//$sql="select a.PBI_ID as CODE,  a.PBI_CODE as PBI_ID, a.PBI_NAME as Name  from personnel_basic_info a, hr_employee b where	a.ATT_ID=b.id ";


    $sql="select a.PBI_ID as ERP_CODE,  a.PBI_CODE as Employee_ID, b.emp_pin, b.id as Machine_ID, a.PBI_NAME as Name  from personnel_basic_info a, hr_employee b where	a.PBI_ID=b.emp_pin order by b.id desc ";

//}
break;





case 100000000000001:

$report="Employee Details Information";

 $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,
(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,
a.PBI_DEPARTMENT as department,
a.incharge_id,a.PBI_DOMAIN Section, a.PBI_GROUP as `Group`,
DATE_FORMAT(a.PBI_DOJ,'%d-%m-%Y') as joining_date,
DATE_FORMAT(a.PBI_DOJ_PP,'%d-%m-%Y') as PP_joining_date,

DATE_FORMAT(a.PBI_DOC,'%d-%m-%Y') as doc,
DATE_FORMAT(a.PBI_DOC2,'%d-%m-%Y') as doc2,

(select group_name from user_group where id=a.PBI_ORG) as Company ,
(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,
(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,
(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,
a.PBI_EDU_QUALIFICATION as qualification,a.PBI_MOBILE as mobile,PBI_JOB_STATUS job_status,
(select office_location from office_location where id=a.JOB_LOCATION) JOB_LOCATION
from personnel_basic_info a
where	1 ".$con;




break;


case 2:
	$report="Employee Salary & Benefits Information";

$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,
(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,
a.PBI_DEPARTMENT as department,
b.consolidated_salary,b.cash as AC_NO,b.basic_salary,b.special_allowance,
b.ta tada,fixed_commission,b.mobile_allowance,vehicle_allowance,

if( CURDATE()> security_amnt_till_date,security_amount,'0.00') security_amount,
b.cooperative_share,
(b.consolidated_salary+b.basic_salary+b.special_allowance+vehicle_allowance+fixed_commission+b.ta) as total_salary,
bank_paid,cash_paid,total_payable

from personnel_basic_info a,salary_info b where	a.PBI_ID=b.PBI_ID ".$con." order by (b.consolidated_salary+b.basic_salary) desc";
break;
    case 3:
	$report="Monthly Attendence Report";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	echo $sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,
	(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,
	a.PBI_DEPARTMENT as department, b.td as total_day,b.od as off_day,b.hd as holy_day, 	b.lt as late_days, 	b.ab as absent_days,b.lv as leave_days,b.pre as present_days, 	b.pay as payable_days,b.ot as over_time_hour FROM personnel_basic_info a,hrm_attendence_final b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;
    case 4:
		$report="Over Time Report";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department, b.ot as over_time_hour,(b.total_salary/208) as rate,b.over_time_amount FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;
	    case 5:
		$report="Salary Payroll Report (Detail)";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,
	b.od,b.hd,b.lt,b.ab,b.lv,b.pre,b.pay,
	b.over_time_amount,
	b.basic_salary,b.total_salary as consolidated_salary,b.house_rent,b.medical_allowance,b.other_allowance,b.special_allowance,b.ta_da as TA_DA, b.food_allowance as fooding, b.mobile_allowance,b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction,b.total_benefits,b.total_payable*(1.00) as total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;

    case 6:
				$report="Salary Payroll Report (Summary)";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,
	b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction,b.total_benefits,b.total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;

 case 60:
$report="IOM Report";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$totalDays=date('t',mktime(0,0,0,$mon,01,$year));
	$startDate=$year.'-'.$mon.'-01';
	$endDate=$year.'-'.$mon.'-'.$totalDays;

	 $sql="SELECT id, PBI_DEPT_HEAD, dept_head_status, dept_head_aprv_at, PBI_ID, type, iom_dur, s_date, e_date, total_days, reason, note FROM hrm_iom_info where s_date>='".$startDate."' and e_date<='".$endDate."' ".$con." order by id desc";
}
break;

 case 61:
$report="Leave Report";
if($_POST['mon']>0&&$_POST['year']>0)
{

// , lv_dur, leave_join_date, leave_address, leave_mobile_number, leave_responsibility_name, leave_status, note cut from this query///////////
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$totalDays=date('t',mktime(0,0,0,$mon,01,$year));
	$startDate=$year.'-'.$mon.'-01';
	$endDate=$year.'-'.$mon.'-'.$totalDays;

 $sql="SELECT id, PBI_ID, type, s_date, e_date, total_days, type as half_or_full, reason, paid_status FROM hrm_leave_info where s_date>='".$startDate."' and e_date<='".$endDate."' ".$con." order by id desc";
}
break;

case 7:
	$report="Salary Payroll Report";
	break;

case 77:
	$report="Salary Payroll Report Final (Sales)";
	break;
case 78:
	$report="Salary Payroll Report Final";
	break;

case 79:
	$report="Salary Pay Slip";
	if($_POST['mon']>0&&$_POST['year']>0)
	{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	}
break;


case 7712:
	$report="Salary Pay Slip";
	if($_POST['mon']>0&&$_POST['year']>0)
	{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	}
break;



case 771211:
	$report="Partial Salary Pay Slip";
	if($_POST['mon']>0&&$_POST['year']>0)
	{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	}
break;



case 8:
$report="Staff Mobile Information(Changable)";
break;
					case 66:
				$report="Bill of Salary for the month of ".date('M',$_POST['mon']).'-'.$_POST['year'];
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	 echo  $sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as desg ,a.PBI_DEPARTMENT as dept,a.PBI_DOJ joining_date,b.pre,b.od,b.hd,b.lv,b.lwp,b.ab,b.pay,
	  b.total_salary,b.special_allowance,(b.total_salary+b.special_allowance) actual_amount,
	b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction, (b.total_salary-b.total_deduction) as actual_salary, b.total_benefits,b.total_payable FROM

	personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;
	case 11:
        $report="OutStanding Dues";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}
		if(isset($proj_code))
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code);
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		if(isset($t_date))
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select c.proj_name as project_name,a.flat_no as allot_no,b.party_name as client_name,a.inst_date,a.inst_amount as payable_amt,a.rcv_amount as received_amt from tbl_flat_cost_installment a, tbl_party_info b, tbl_project_info c,tbl_flat_info d where a.proj_code=c.proj_code and d.party_code=b.party_code and a.proj_code=d.proj_code and a.build_code=d.build_code and a.flat_no=d.flat_no and rcv_status=0 ".$proj_con.$date_con.$flat_con.$party_con." order by a.inst_date";
		break;
	case 12:
        $report="Expected Collection";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}
		if(isset($proj_code))
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code);
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		if(isset($t_date))
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select c.proj_name as project_name,a.flat_no as allot_no,b.party_name as client_name,a.inst_date,a.inst_amount as payable_amt,a.rcv_amount as received_amt from tbl_flat_cost_installment a, tbl_party_info b, tbl_project_info c,tbl_flat_info d where a.proj_code=c.proj_code and d.party_code=b.party_code and a.proj_code=d.proj_code and a.build_code=d.build_code and a.flat_no=d.flat_no ".$proj_con.$date_con.$flat_con.$party_con." order by a.inst_date";
		break;

			case 203:
        $report="Leave Encashment Report-2017";
		break;

	case 13:
        $report="Payment Schedule";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}
		if(isset($proj_code))
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code);
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		if(isset($t_date))
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="SELECT e.pay_desc,a.inst_no, c.proj_name AS project_name,a.flat_no AS allot_no,  a.inst_date, a.inst_amount AS payable_amt, a.rcv_date AS receive_date, a.rcv_amount AS receive_amt
FROM
tbl_flat_cost_installment a,
tbl_party_info b,
tbl_project_info c,
tbl_flat_info d,
tbl_payment_head e
WHERE a.proj_code = c.proj_code
AND d.party_code = b.party_code
AND a.proj_code = d.proj_code
AND a.build_code = d.build_code
AND a.flat_no = d.flat_no
AND a.pay_code = e.pay_code".$proj_con.$date_con.$flat_con.$party_con." order by a.inst_date";
		break;
		case 14:
        $report="Party Rent Agreement Terms";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}
		if(isset($proj_code))
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code);
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		$sql="SELECT b.`proj_name`,a.`flat_no`,c.`party_name`,a.`monthly_rent`,a.`effective_date`,a.`expire_date`,a.`notice_period`,a.discontinue_term,a.`witness1`,a.`witness1_address` FROM `tbl_rent_info` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;
		break;
		case 15:
        $report="Party Rent Payment Terms";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}
		if(isset($proj_code))
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code);
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		$sql="SELECT b.`proj_name`,a.`flat_no`,c.`party_name`,a.`security_money`,a.`monthly_rent`,a.`electricity_bill`,a.`other_bill`,a.`wasa_bill`,a.`gas_bill`,(a.`monthly_rent`++a.`electricity_bill`+a.`other_bill`+a.`wasa_bill`+a.`gas_bill`) as total_payable FROM `tbl_rent_info` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;
		break;
		case 16:
        $report="Party Rent Payment Terms";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}
		if(isset($proj_code))
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code);
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		$sql="SELECT a.jv_no as Invoice_no,a.mon as period,b.`proj_name`,a.`flat_no`,c.`party_name`,a.`rent_amt`,a.`electricity_bill`,a.`other_bill`,a.`wasa_bill`,a.`gas_bill`,total_amt as total_amt FROM `tbl_rent_receive` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;
		break;

	case 24:
	$report="Collection Statement(Cash)";
		if(isset($proj_code))
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code);
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		if(isset($t_date))
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select a.rec_date as tr_date,b.proj_name".$flat_show.",a.rec_amount as total_amt from tbl_receipt a,tbl_project_info b where a.pay_mode=0 and a.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." order by a.rec_date";
		break;
	case 25:
	$report="Collection Statement(Chaque)";
		if(isset($proj_code))
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code);
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		if(isset($t_date))
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select a.rec_date as tr_date,a.cheq_no,b.proj_name".$flat_show.",a.rec_amount as total_amt from tbl_receipt a,tbl_project_info b where a.pay_mode=1 and a.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." order by a.rec_date";
		break;


// COMMISION REPORTS
		case 31:
	$report="Share Holder Investment Amount";
		if(isset($proj_code))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}

		if(isset($t_date))
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`status`,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code`".$date_con.$proj_con ." order by a.proj_code,a.agent_code";
		break;

		case 33:
	$report="Running Share Holder Information";
		if(isset($proj_code))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}

		if(isset($t_date))
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code` and a.status='Running' ".$date_con.$proj_con ." order by a.proj_code,a.agent_code";
		break;

		case 34:
	$report="Withdrawn Share Holder Information";
		if(isset($proj_code))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}

		if(isset($t_date))
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`status_date` as withdrawn_date,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code` and a.status='Withdrawn' ".$date_con.$proj_con ." order by a.proj_code,a.agent_code";
		break;

		case 35:
	$report="Agent Information";

		$sql="SELECT `emp_id`,`emp_name`,`emp_designation`,`emp_joining_date`,`emp_contact_no`, (select count(1) from tbl_director_info where agent_code=a.emp_id) as total_member, (select sum(invested) from tbl_director_info where agent_code=a.emp_id) as total_invested, (select sum(withdraw) from tbl_director_info where agent_code=a.emp_id)  as total_withdrawn FROM `tbl_employee_info` as a WHERE 1";
		break;

    case 101:
	$report="APR Information";
			if($_POST['markb']!='')
	$con.=' and b.APR_MARKS < "'.$_POST['markb'].'"';

		if($_POST['marka']!='')
	$con.=' and b.APR_MARKS > "'.$_POST['marka'].'"';
	$year=$_POST['year'];
	$con.=' and b.APR_YEAR = "'.$year.'"';
         $sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_SEX as Gender,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.PBI_PROJECT as project	,a.PBI_DESIGNATION as designation ,a.PBI_DESG_GRADE as grade,a.PBI_ZONE as zone,a.PBI_AREA as area,t.pbi_region PBI_BRANCH as branch,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,b.APR_YEAR,b.APR_MARKS,(select avg(APR_MARKS) from apr_detail where APR_YEAR in (".$year.",".($year-1).",".($year-2).") and PBI_ID=a.PBI_ID) as avg_marks,b.APR_STATUS,b.APR_RESULT  from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID ".$con;
		break;


case 1001:
$report="Distributor Dealer Information";
if($_POST['dealer_name_e']!='')
$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';
if($_POST['dealer_code']!='')
$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';

if($_POST['division_code']!='')
$con.=' and a.division_code = "'.$_POST['division_code'].'"';
elseif($_POST['district_code']!='')
$con.=' and a.district_code = "'.$_POST['district_code'].'"';
elseif($_POST['thana_code']!='')
$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';


if($_POST['region_code']!='')
$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['region_code'].'") ';
elseif($_POST['zone_code']!='')
$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['area_code']!='')
$con.=' and a.area_code = "'.$_POST['area_code'].'"';


if($_POST['canceled']!='')
$con.=' and a.canceled = "'.$_POST['canceled'].'"';
if($_POST['depot']!='')
$con.=' and a.depot = "'.$_POST['depot'].'"';

if($_POST['product_group']!='')
$con.=' and a.product_group = "'.$_POST['product_group'].'"';
if($_POST['mobile_no']!='')
$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';

        $sql="select a.dealer_code as code,concat(a.account_code,'-') as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,b.AREA_NAME as area,z.ZONE_NAME as zone,r.BRANCH_NAME as region,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,area b,zon z,branch r,warehouse w
		 where z.region_id =r.BRANCH_ID and b.ZONE_ID =z.ZONE_CODE and a.dealer_type='Distributor' and a.area_code = b.AREA_CODE and w.warehouse_id=a.depot ".$con." order by a.dealer_code desc";
		break;

case 1002:
$report="Super Shop Dealer Information";
if($_POST['dealer_name_e']!='')
$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';
if($_POST['dealer_code']!='')
$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';

if($_POST['division_code']!='')
$con.=' and a.division_code = "'.$_POST['division_code'].'"';
elseif($_POST['district_code']!='')
$con.=' and a.district_code = "'.$_POST['district_code'].'"';
elseif($_POST['thana_code']!='')
$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';


if($_POST['region_code']!='')
$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['zone_code']!='')
$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['area_code']!='')
$con.=' and a.area_code = "'.$_POST['area_code'].'"';


if($_POST['canceled']!='')
$con.=' and a.canceled = "'.$_POST['canceled'].'"';
if($_POST['depot']!='')
$con.=' and a.depot = "'.$_POST['depot'].'"';

if($_POST['product_group']!='')
$con.=' and a.product_group = "'.$_POST['product_group'].'"';
if($_POST['depot']!='')
$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';



		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,warehouse w where a.dealer_type='SuperShop' and w.warehouse_id=a.depot ".$con." order by a.dealer_code desc";

		break;
case 1003:
$report="Corporate Dealer Information";
if($_POST['dealer_name_e']!='')
$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';
if($_POST['dealer_code']!='')
$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';

if($_POST['division_code']!='')
$con.=' and a.division_code = "'.$_POST['division_code'].'"';
elseif($_POST['district_code']!='')
$con.=' and a.district_code = "'.$_POST['district_code'].'"';
elseif($_POST['thana_code']!='')
$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';


if($_POST['region_code']!='')
$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['zone_code']!='')
$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['area_code']!='')
$con.=' and a.area_code = "'.$_POST['area_code'].'"';


if($_POST['canceled']!='')
$con.=' and a.canceled = "'.$_POST['canceled'].'"';
if($_POST['depot']!='')
$con.=' and a.depot = "'.$_POST['depot'].'"';

if($_POST['product_group']!='')
$con.=' and a.product_group = "'.$_POST['product_group'].'"';
if($_POST['depot']!='')
$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';

		 		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,warehouse w where a.dealer_type='Corporate' and w.warehouse_id=a.depot ".$con." order by a.dealer_code desc";
		break;

case 1004:
$report="TradeFair Dealer Information";
if($_POST['dealer_name_e']!='')
$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';
if($_POST['dealer_code']!='')
$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';

if($_POST['division_code']!='')
$con.=' and a.division_code = "'.$_POST['division_code'].'"';
elseif($_POST['district_code']!='')
$con.=' and a.district_code = "'.$_POST['district_code'].'"';
elseif($_POST['thana_code']!='')
$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';


if($_POST['region_code']!='')
$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['zone_code']!='')
$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['area_code']!='')
$con.=' and a.area_code = "'.$_POST['area_code'].'"';


if($_POST['canceled']!='')
$con.=' and a.canceled = "'.$_POST['canceled'].'"';
if($_POST['depot']!='')
$con.=' and a.depot = "'.$_POST['depot'].'"';

if($_POST['product_group']!='')
$con.=' and a.product_group = "'.$_POST['product_group'].'"';
if($_POST['depot']!='')
$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';

		 		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,warehouse w where a.dealer_type='TradeFair' and w.warehouse_id=a.depot ".$con." order by a.dealer_code desc";
		break;
case 1005:
$report="BulkBuyer Dealer Information";
if($_POST['dealer_name_e']!='')
$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';
if($_POST['dealer_code']!='')
$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';

if($_POST['division_code']!='')
$con.=' and a.division_code = "'.$_POST['division_code'].'"';
elseif($_POST['district_code']!='')
$con.=' and a.district_code = "'.$_POST['district_code'].'"';
elseif($_POST['thana_code']!='')
$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';


if($_POST['region_code']!='')
$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['zone_code']!='')
$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['area_code']!='')
$con.=' and a.area_code = "'.$_POST['area_code'].'"';


if($_POST['canceled']!='')
$con.=' and a.canceled = "'.$_POST['canceled'].'"';
if($_POST['depot']!='')
$con.=' and a.depot = "'.$_POST['depot'].'"';

if($_POST['product_group']!='')
$con.=' and a.product_group = "'.$_POST['product_group'].'"';
if($_POST['depot']!='')
$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';

		 		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,warehouse w where a.dealer_type='BulkBuyer' and w.warehouse_id=a.depot and a.group_for='".$_SESSION['user']['group']."' ".$con." order by a.dealer_code desc";
		break;


case 7841:
$report="Summary of Salary ";
break;
case 7842:
$report="Summary of Salary ";
break;
}
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.js"></script>
<script type="text/javascript" src="../../js/paging.js"></script>
<script type="text/javascript" src="../../js/ddaccordion.js"></script>
<script type="text/javascript" src="../../js/js.js"></script>
<script type="text/javascript" src="../../js/pg.js"></script>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />
<style>
/*.vertical-text div {
	transform: rotate(-90deg);
	transform-origin: left top 1;
	float: left;
	width: 2px;
	padding: 1px;


}*/
       @media print {
           thead {display: table-header-group;}
       }
.vertical-text div{

  float: left;
}


.style1 {font-weight: bold}
.style2 {font-weight: bold}
.style3 {font-weight: bold}
.style4 {font-weight: bold}
.style5 {font-weight: bold}
.style6 {font-weight: bold}
.style7 {font-weight: bold}
.style8 {font-weight: bold}
.style9 {font-weight: bold}
.style10 {font-weight: bold}
.style11 {font-weight: bold}
.style12 {font-weight: bold}
.style13 {font-weight: bold}
.style14 {font-weight: bold}
.style15 {font-weight: bold}
.style16 {font-weight: bold}


tr.noBorder td {
  border: 0;
}
.style19 {font-size: 18px}
.style21 {color: #FFFFFF}
.style22 {font-weight: bold}
.style23 {font-weight: bold}
.style24 {font-weight: bold}
.style25 {font-weight: bold}
</style>
<script type="text/javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}

function update_value(id)
{
var mobile 	= document.getElementById('mobile#'+id).value;
var sim 	= document.getElementById('sim#'+id).value;
getData2('rd_issue_ajax.php', 'po'+id,id,mobile+'#>'+sim);
}

function Pager(tableName, itemsPerPage) {
    this.tableName = tableName;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
    this.pages = 0;
    this.inited = false;

    this.showRecords = function(from, to) {
        var rows = document.getElementById(tableName).rows;
        // i starts from 1 to skip table header row
        for (var i = 1; i < rows.length; i++) {
            if(i < from || i > to) rows[i].style.display = 'none';
            else rows[i].style.display = '';
        }
    }

    this.showPage = function(pageNumber) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}

        var oldPageAnchor = document.getElementById('pg'+this.currentPage);
        oldPageAnchor.className = 'pg-normal';

        this.currentPage = pageNumber;
        var newPageAnchor = document.getElementById('pg'+this.currentPage);
        newPageAnchor.className = 'pg-selected';

        var from = (pageNumber - 1) * itemsPerPage + 1;
        var to = from + itemsPerPage - 1;
        this.showRecords(from, to);
    }

    this.prev = function() {
        if (this.currentPage > 1)
            this.showPage(this.currentPage - 1);
    }

    this.next = function() {
        if (this.currentPage < this.pages) {
            this.showPage(this.currentPage + 1);
        }
    }

    this.init = function() {
        var rows = document.getElementById(tableName).rows;
        var records = (rows.length - 1);
        this.pages = Math.ceil(records / itemsPerPage);
        this.inited = true;
    }

    this.showPageNav = function(pagerName, positionId) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}
    	var element = document.getElementById(positionId);

    	var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal">Prev</span>';
        for (var page = 1; page <= this.pages; page++)
            pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span>';
        pagerHtml += '<span onclick="'+pagerName+'.next();" class="pg-normal">Next</span>';

        element.innerHTML = pagerHtml;
    }
}
var XMLHttpRequestObject = false;

if (window.XMLHttpRequest)
	XMLHttpRequestObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	{
     	XMLHttpRequestObject = new
        ActiveXObject("Microsoft.XMLHTTP");
    }
function getData(dataSource, divID, data)
	{
	  if(XMLHttpRequestObject)

		  {
				var obj = document.getElementById(divID);
				XMLHttpRequestObject.open("POST", dataSource);
				XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

				XMLHttpRequestObject.onreadystatechange = function()
					{
						if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
							obj.innerHTML =   XMLHttpRequestObject.responseText;
					}
				XMLHttpRequestObject.send("ledger=" + data);
		  }
	}
function getData2(dataSource, divID, data1, data2)
	{
	  if(XMLHttpRequestObject)
		  {
				var obj = document.getElementById(divID);
				XMLHttpRequestObject.open("POST", dataSource);
				XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

				XMLHttpRequestObject.onreadystatechange = function()
					{
						if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
							obj.innerHTML =   XMLHttpRequestObject.responseText;
					}
				XMLHttpRequestObject.send("data=" + data1+"##" + data2);

		  }
	}
	function getflatData3()
{
	var b=document.getElementById('category_to').value;
	var a=document.getElementById('proj_code_to').value;
			$.ajax({
		  url: '../../common/flat_option_new3.php',
		  data: "a="+a+"&b="+b,
		  success: function(data) {
				$('#fid3').html(data);
			 }
		});
}
	function getflatData2()
{
	var b=document.getElementById('category_from').value;
	var a=document.getElementById('proj_code_from').value;
			$.ajax({
		  url: '../../common/flat_option_new2.php',
		  data: "a="+a+"&b="+b,
		  success: function(data) {
				$('#fid2').html(data);
			 }
		});
}


</script>
</head>
<body>
<form action="?" method="post">
<!--<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div><div class="main">-->

<?
		//echo $sql;
		$str 	.= '<div class="header">';
		if($_POST['PBI_ORG']!='')
		$str 	.= '<h2 style="font-size:24px;">'.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';
		if(isset($report))
		$str 	.= '<h2>'.$report.'</h2>';
		if($_POST['mon']!=''){
			if($_POST['report']==777 || $_POST['report']==778 || $_POST['report']==64){
				if($_POST['bonus_type']==1){
					$str 	.= '<h2>Bonus of Eid-Ul-Fitre '.date('Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year'])).'</h2>';
				}else{
					$str 	.= '<h2>Bonus of Eid-Ul-Adha '.date('Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year'])).'</h2>';
				}

			}else{
			if($_POST['report']!=203)
				$str 	.= '<h2>Report of Month: '.date('F-Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year'])).'</h2>';
			}
		}



if($_POST['salary_shift']!='')
		$str 	.='<h2>Salary Shift: '.find_a_field('salary_shift_info','shift_name','ID="'.$_POST['salary_shift'].'"').'&nbsp;&nbsp;</h2>';


		if($_POST['payroll_type']!='')
		$str 	.='<h2>Payroll Type: '.find_a_field('salary_payroll_type','payroll_type','ID="'.$_POST['payroll_type'].'"').'&nbsp;&nbsp;</h2>';



if($_POST['mess_bill_type']!='')
		$str 	.='<h2>Mess Bill Type: '.find_a_field('mess_bill_type','bill_type','id="'.$_POST['mess_bill_type'].'"').'&nbsp;&nbsp;</h2>';





		if($_POST['department']!=''||$_POST['JOB_LOCATION']!='')
		$str 	.= '<h2>';
		if($_POST['department']!='')
		$str 	.= 'Department: '.find_a_field('department','DEPT_DESC','DEPT_ID="'.$_POST['department'].'"').'&nbsp;&nbsp;<br/>';
		if($_POST['JOB_LOCATION']!='')
		$str 	.='Location: '.find_a_field('job_location_type','job_location_name','id="'.$_POST['JOB_LOCATION'].'"');
		if($_POST['shedule_no']!='')
		$str 	.='Roster Schedule: '.find_a_field('hrm_schedule_info','schedule_name','ID="'.$_POST['shedule_no'].'"').'&nbsp;&nbsp;<br/>';
		if($_POST['define_shift']!='')
		$str 	.='Define Shift: '.find_a_field('hrm_shift_info','shift_name','ID="'.$_POST['define_shift'].'"').'&nbsp;&nbsp;<br/>';
		if($_POST['department']!=''||$_POST['JOB_LOCATION']!='')
		$str 	.= '</h2>';
		$str 	.= '</div>';


		//if(isset($_SESSION['company_logo']))
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		if(($_POST['PBI_GROUP']!=''))
		$str 	.= '<p>Product Group: '.$_POST['PBI_GROUP'].'</p>';
		if(($_POST['branch']>0))
		$str 	.= '<p>Region Name: '.find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$_POST['branch'].'"').'</p>';
		if(($_POST['area_code']>0))
		$str 	.= '<p>Area Name: '.find_a_field('area','AREA_NAME','AREA_CODE="'.$_POST['area_code'].'"').'</p>';
		if(($_POST['zone_code']>0))
		$str 	.= '<p>Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$_POST['zone_code'].'"').'</p>';
		if(($_POST['region_code']>0))
		$str 	.= '<p>Region Name: '.find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$_POST['region_code'].'"').'</p>';
		if(isset($project_name))
		$str 	.= '<p>Project Name: '.$project_name.'</p>';

		if(isset($allotment_no))
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div>';
		$str 	.= '<div class="right">';
		if(isset($client_name))
		$str 	.= '<p>Client Name: '.$client_name.'</p>';
		if(isset($start_date))
		$str 	.= '<p>Schedule Duration: '.$start_date.' to '.$end_date.'</p>';
		//$str 	.= '</div><span>Bonus Cut-Off Date:'.find_a_field('salary_bonus','cut_off_date','bonus_type='.$_POST['bonus_type'].' and year='.$_POST['year']).'</span><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		$str 	.= '</div>';
		$str 	.= '<div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';

if($_POST['report']==7) // payroll information   //(select pbi_held_up from salary_attendence where PBI_ID=a.PBI_ID order by id desc limit 1) as held, Cut from this sql
{

 $sql1="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,a.PBI_GROUP,


(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,
(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,
(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,
a.PBI_JOB_STATUS as job_status

from personnel_basic_info a where 1 ".$con;

$query = db_query($sql1);
?><table border="0">
<thead><tr><td style="border:0px;" colspan="13"><?=$str?></td></tr>
<tr><th>S/L</th>
<th>CODE</th>
<th>Name</th>
<th>Desg</th>
<th>Dept</th>
<th>GRP</th><th>Region</th><th>Zone</th><th>Area</th>
<th>Held-up</th><th>Status</th>
<th>Salary Type</th>
<th>Basic</th>
<th>C.Salary</th>
<th>SL</th>
<th>HR</th>
<th>TA/DA</th>
<th>FA</th>
<th>MA</th>
<th>Sal By </th>
<th>A/C#</th>
<th>Branch</th>
<th>SM</th>
</tr></thead>
<tbody>
<?
while($datas=mysqli_fetch_row($query)){$s++;
$sqld = 'select * from salary_info where PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr><td><?=$s?></td>
<td><?=$datas[0]?></td>
<td><?=$datas[1]?></td>
  <td><?=$datas[2]?></td>
  <td><?=$datas[3]?></td>
  <td><?=$datas[4]?></td>
  <td><?=$datas[8]?></td>
  <td><?=$datas[7]?></td>
  <td><?=$datas[6]?></td>
  <td><?=($datas[5]>0)?'Y':'N';?></td>
  <td><?=$datas[9]?></td>
  <td><?=$data->salary_type?></td>
  <td><?=$data->basic_salary?></td>
  <td><?=$data->consolidated_salary?></td>
  <td style="text-align:right"><?=$data->special_allowance ?></td>
  <td style="text-align:right"><?=$data->house_rent?></td>
  <td><?=$data->ta?></td>
  <td><?=$data->food_allowance?></td>
  <td><?=$data->medical_allowance?>&nbsp;</td>
  <td><?=$data->cash_bank?>&nbsp;</td>
  <td><?=$data->cash?></td>
  <td><?=$data->branch_info?></td>
  <td><?=$data->security_amount?></td></tr>
<?
}
?></tbody></table>
<?
}
elseif($_POST['report']==770)
{




$sqll="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department from
personnel_basic_info a, salary_info s where a.PBI_ID=s.PBI_ID  ".$con." order by (s.consolidated_salary+s.basic_salary) desc";
$query = db_query($sqll);
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="23"><?=$str?></td></tr>
<tr><th rowspan="2">S/L</th>
<th rowspan="2">CODE</th>
<th rowspan="2">Name</th>
<th rowspan="2">Desg</th>
<th rowspan="2">Group</th>
<th rowspan="2">Joining Date </th>
<th rowspan="2">DBBL Acc. </th>
<th rowspan="2">Working Place </th>
<th rowspan="2">Sales Point </th>
<th colspan="5" align="center"><?php echo date('F',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?>'<?php echo date('y',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?></th>
<th colspan="2">Present Gross Amount </th>
<th colspan="2">Actual Amount </th>
<th rowspan="2">Special Commission </th>
<th rowspan="2">Mobile Allowance </th>
<th rowspan="2">Advance/Bill Payment </th>
<th rowspan="2">H/Up or Advance Salary </th>
<th rowspan="2">Co-OP Fund Inst. </th>
<th rowspan="2">M/cycle Install </th>
<th rowspan="2">Mobile Bill <?php echo date('M',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?>'<?php echo date('y',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?> </th>
<th rowspan="2">Security Deposit </th>
<th rowspan="2">Panalty</th>
<th rowspan="2">Transfer to DBBL </th>
<th rowspan="2">Net Payable (Taka) </th>
<th rowspan="2">Signature</th>
</tr>
<tr>
  <th>Present</th>
  <th>Absent</th>
  <th>Leave</th>
  <th>W/Days</th>
  <th>Off Day </th>
  <th>Salary (Taka)</th>
  <th>TA/DA (Taka) </th>
  <th>Salary (Taka) </th>
  <th>TA/DA (Taka)</th>
</tr>
</thead>
<tbody>
<?
while($datas=mysqli_fetch_row($query)){$s++;
$sqld = 'select * from salary_info where PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr><td><?=$s?></td><td><?=$datas[0]?></td><td><?=$datas[1]?></td>
  <td><?=$datas[2]?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><?=$datas[3]?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><?=$data->salary_type?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><?=$data->basic_salary?></td><td><?=$data->consolidated_salary?></td>
  <td style="text-align:right"><?=$data->special_allowance ?></td>
  <td style="text-align:right"><?=$data->house_rent?></td><td><?=$data->ta?></td>
  <td><?=$data->food_allowance?></td>
  <td><?=$data->medical_allowance?>&nbsp;</td>
  <td><?=$data->cash_bank?>&nbsp;</td>
  <td><?=$data->cash?></td>
  <td><?=$data->branch_info?></td><td><?=$data->security_amount?></td>
  <td>&nbsp;</td>
</tr>
<?
}
?></tbody></table>
<?
}



elseif($_POST['report']==7711)
{



if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

 $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE , a.PBI_NAME_BANGLA as bangla from
personnel_basic_info a, department dp, designation ds, salary_attendence s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and s.mon='".$mon."' and s.year='".$year."'  ".$con." order by a.EMP_CODE ";
}
$query = db_query($sqll);
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="36"><?=$str?></td></tr>

<tr>
  <th rowspan="2">S/L</th>
<th rowspan="2">CODE</th>
<th rowspan="2">Name</th>
<th rowspan="2">Bangla</th>
<th rowspan="2">Designation</th>
<th rowspan="2">Joining_Date </th>
<th colspan="5" align="center"><div align="center">Salary Structure </div></th>
<th colspan="10"><div align="center">Attendance, <?php echo date('F',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?>'<?php echo date('y',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?></div></th>
<th rowspan="2">Attn. Bonus </th>
<th colspan="4"><div align="center">Deduction</div></th>
<th colspan="3"><div align="center">Over Time </div></th>
<th rowspan="2">Other Allow. </th>
<th rowspan="2">Bonus</th>
<th rowspan="2">Total Earnings </th>
<th rowspan="2">Provident fund </th>
<th rowspan="2">Payable Amount </th>
<th rowspan="2">Signature</th>
</tr>
<tr>
  <th>Gross</th>
  <th>Basic</th>
  <th>H.Rent</th>
  <th>Medical</th>
  <th>Conve.</th>
  <th>TD</th>
  <th>OD</th>
  <th>HDD</th>
  <th>HD</th>
  <th>LTP</th>
  <th>LWP</th>
  <th>LV</th>
  <th>AB</th>
  <th>PRE</th>
  <th>PAY</th>
  <th>Absent</th>
  <th>Advance</th>
  <th>Mess &amp; Dorm </th>
  <th>Other</th>
  <th>Day</th>
  <th>Rate</th>
  <th>Amount</th>
</tr>
</thead>
<tbody>
<?
while($datas=mysqli_fetch_row($query)){$s++;
$sqld = 'select * from salary_attendence where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr height="80"><td><?=$s?></td><td><?=$datas[1]?></td><td><?=$datas[2]?></td>
  <td><?=$datas[7]?></td>
  <td><?=$datas[3]?></td>
  <td><?=date("j-M-y",strtotime($data->PBI_DOJ));?></td>
  <td><?=number_format($data->gross_salary,2); $tot_gross_salary+=$data->gross_salary; ?></td>
  <td><?=number_format($data->basic_salary,2); $tot_basic_salary+=$data->basic_salary; ?></td>
  <td><?=number_format($data->house_rent,2); $tot_house_rent+=$data->house_rent; ?></td>
  <td><?=number_format($data->medical_allowance,2); $tot_medical_allowance+=$data->medical_allowance; ?></td>
  <td><?=number_format($data->conveyance_allowance,2); $tot_conveyance_allowance+=$data->conveyance_allowance; ?></td>
  <td><?=$data->td?></td>
  <td><?=$data->od?></td>
  <td><?=$data->hdd?></td>
  <td><?=$data->hd?></td>
  <td><?=$data->lt?></td>
  <td><?=$data->lwp?></td>
  <td><?=$data->lv?></td>
  <td><?=$data->ab?></td>
  <td><?=$data->pre?></td>
  <td><?=$data->pay?></td>
  <td><?=number_format($data->attendance_bonus,2); $tot_attendance_bonus+=$data->attendance_bonus;?></td>
  <td style="text-align:right"><?=number_format($data->absent_deduction,2); $tot_absent_deduction+=$data->absent_deduction;?></td>
  <td style="text-align:right"><?=number_format($data->advance_install,2); $tot_advance_install+=$data->advance_install;?></td>
  <td style="text-align:right"><?=number_format($data->mess_dormitory,2); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
  <td style="text-align:right"><?=number_format($data->deduction,2); $tot_deduction+=$data->deduction;?></td>
  <td style="text-align:right"><?=$data->potd?></td>
  <td style="text-align:right"><?=$data->per_day?></td>
  <td style="text-align:right"><?=number_format($data->over_time_amount,2); $tot_over_time_amount+=$data->over_time_amount;?></td>
  <td><?=number_format($data->benefits,2); $tot_benefits+=$data->benefits;?></td>
  <td><?=number_format($data->festival_bonus,2); $tot_festival_bonus+=$data->festival_bonus;?></td>
  <td><?=number_format($data->total_earnings,2); $tot_total_earnings+=$data->total_earnings;?></td>
  <td><?=number_format($data->pf,2); $tot_pf+=$data->pf;?></td>
  <td><?=number_format($data->total_payable,2); $tot_total_payable+=$data->total_payable;?></td>
  <td>&nbsp;</td>
</tr>
<?
}
?>


<tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong>TOTAL</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><span class="style1">
    <?=number_format($tot_gross_salary,2);?>
  </span></td>
  <td><span class="style2">
    <?=number_format($tot_basic_salary,2);?>
  </span></td>
  <td><span class="style3">
    <?=number_format($tot_house_rent,2);?>
  </span></td>
  <td><span class="style4">
    <?=number_format($tot_medical_allowance,2);?>
  </span></td>
  <td><span class="style5">
    <?=number_format($tot_conveyance_allowance,2);?>
  </span></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><span class="style6">
    <?=number_format($tot_attendance_bonus,2);?>
  </span></td>
  <td style="text-align:right"><span class="style7">
    <?=number_format($tot_absent_deduction,2);?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($tot_advance_install,2);?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($tot_mess_dormitory,2);?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($tot_deduction,2);?>
  </span></td>
  <td style="text-align:right">&nbsp;</td>
  <td style="text-align:right">&nbsp;</td>
  <td style="text-align:right"><span class="style10">
    <?=number_format($tot_over_time_amount,2);?>
  </span></td>
  <td><span class="style11">
    <?=number_format($tot_benefits,2);?>
  </span></td>
  <td><span class="style16">
    <?=number_format($tot_festival_bonus,2);?>
  </span></td>
  <td><span class="style12">
    <?=number_format($tot_total_earnings,2);?>
  </span></td>
  <td><span class="style13">
    <?=number_format($tot_pf,2);?>
  </span></td>
  <td><span class="style14">
    <?=number_format($tot_total_payable,2);?>
  </span></td>
  <td>&nbsp;</td>
</tr>
</tbody></table>
<?
}







elseif($_POST['report']==771171)
{

if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

 $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and s.mon='".$mon."' and s.year='".$year."'  ".$con." order by a.EMP_CODE ";
}
$query = db_query($sqll);
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="23"><?=$str?></td></tr>

<tr>
  <th rowspan="2">S/L  </th>
<th rowspan="2">CODE</th>
<th rowspan="2">Name</th>
<th rowspan="2">Day</th>
<th colspan="5" align="center"><div align="center">Salary Structure </div></th>
<th rowspan="2">Attn. Bonus </th>
<th colspan="4"><div align="center">Deduction</div></th>
<th colspan="3"><div align="center">Over Time </div></th>
<th rowspan="2">Other Allow. </th>
<th rowspan="2">Bonus</th>
<th rowspan="2">Total Earnings </th>
<th rowspan="2">Provident fund </th>
<th rowspan="2">Payable Amount </th>
</tr>
<tr>
  <th>Gross</th>
  <th>Basic</th>
  <th>H.Rent</th>
  <th>Medical</th>
  <th>Conve.</th>
  <th>Absent</th>
  <th>Advance</th>
  <th>Mess &amp; Dorm </th>
  <th>Other</th>
  <th>Day</th>
  <th>Rate</th>
  <th>Amount</th>
</tr>
</thead>
<tbody>
<?
while($datas=mysqli_fetch_row($query)){$s++;
 $sqld = 'select * from salary_attendence where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr height="80"><td><?=$s?></td><td><?=$datas[1]?></td><td><?=$datas[2]?></td>
  <td><?= $tot_day = ($data->pay+$data->potd)?></td>
  <td><?=number_format($data->gross_salary,2); $tot_gross_salary+=$data->gross_salary; ?></td>
  <td><?=number_format($data->basic_salary,2); $tot_basic_salary+=$data->basic_salary; ?></td>
  <td><?=number_format($data->house_rent,2); $tot_house_rent+=$data->house_rent; ?></td>
  <td><?=number_format($data->medical_allowance,2); $tot_medical_allowance+=$data->medical_allowance; ?></td>
  <td><?=number_format($data->conveyance_allowance,2); $tot_conveyance_allowance+=$data->conveyance_allowance; ?></td>
  <td><?=number_format($data->attendance_bonus,2); $tot_attendance_bonus+=$data->attendance_bonus;?></td>
  <td style="text-align:right"><?=number_format($data->absent_deduction,2); $tot_absent_deduction+=$data->absent_deduction;?></td>
  <td style="text-align:right"><?=number_format($data->advance_install,2); $tot_advance_install+=$data->advance_install;?></td>
  <td style="text-align:right"><?=number_format($data->mess_dormitory,2); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
  <td style="text-align:right"><?=number_format($data->deduction,2); $tot_deduction+=$data->deduction;?></td>
  <td style="text-align:right"><?=$data->potd?></td>
  <td style="text-align:right"><?=$data->per_day?></td>
  <td style="text-align:right"><?=number_format($data->over_time_amount,2); $tot_over_time_amount+=$data->over_time_amount;?></td>
  <td><?=number_format($data->benefits,2); $tot_benefits+=$data->benefits;?></td>
  <td><?=number_format($data->festival_bonus,2); $tot_festival_bonus+=$data->festival_bonus;?></td>
  <td><?=number_format($data->total_earnings,2); $tot_total_earnings+=$data->total_earnings;?></td>
  <td><?=number_format($data->pf,2); $tot_pf+=$data->pf;?></td>
  <td><?=number_format($data->total_payable,2); $tot_total_payable+=$data->total_payable;?></td>
  </tr>
<?
}
?>


<tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td colspan="2"><strong>TOTAL</strong></td>
  <td><span class="style1">
    <?=number_format($tot_gross_salary,2);?>
  </span></td>
  <td><span class="style2">
    <?=number_format($tot_basic_salary,2);?>
  </span></td>
  <td><span class="style3">
    <?=number_format($tot_house_rent,2);?>
  </span></td>
  <td><span class="style4">
    <?=number_format($tot_medical_allowance,2);?>
  </span></td>
  <td><span class="style5">
    <?=number_format($tot_conveyance_allowance,2);?>
  </span></td>
  <td><span class="style6">
    <?=number_format($tot_attendance_bonus,2);?>
  </span></td>
  <td style="text-align:right"><span class="style7">
    <?=number_format($tot_absent_deduction,2);?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($tot_advance_install,2);?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($tot_mess_dormitory,2);?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($tot_deduction,2);?>
  </span></td>
  <td style="text-align:right">&nbsp;</td>
  <td style="text-align:right">&nbsp;</td>
  <td style="text-align:right"><span class="style10">
    <?=number_format($tot_over_time_amount,2);?>
  </span></td>
  <td><span class="style11">
    <?=number_format($tot_benefits,2);?>
  </span></td>
  <td><span class="style16">
    <?=number_format($tot_festival_bonus,2);?>
  </span></td>
  <td><span class="style12">
    <?=number_format($tot_total_earnings,2);?>
  </span></td>
  <td><span class="style13">
    <?=number_format($tot_pf,2);?>
  </span></td>
  <td><span class="style14">
    <?=number_format($tot_total_payable,2);?>
  </span></td>
  </tr>
</tbody></table>
<?
}





elseif($_POST['report']==77117171)
{




 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";


if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr><td style="border:0px;" colspan="23"><?=$str?></td></tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">




<thead>

  <tr>
    <th width="4%" rowspan="2">SL Update</th>
    <th width="3%" rowspan="2">CODE</th>
    <th width="3%" rowspan="2">Name</th>
    <th width="3%" rowspan="2">Joining</th>
    <th colspan="3">Month Day</th>
    <th colspan="5" align="center"><div align="center">Salary Structure </div></th>
    <th width="6%" rowspan="2">Attn. Bonus </th>
    <th colspan="5"><div align="center">Deduction</div></th>
<th width="4%" rowspan="2">OT AMT</th>
<th width="6%" rowspan="2">Other Allow. </th>
  <th width="4%" rowspan="2">Bonus</th>
  <th width="5%" rowspan="2">Total Earnings </th>
  <th width="5%" rowspan="2">Provident fund </th>
  <th width="4%" rowspan="2">Payable Amount </th>
  <th width="14%" rowspan="2" >Signature<span style="color:#FFFFFF">Signature</span></th>
  </tr>
<tr>
  <th width="2%">Pre</th>
  <th width="2%">OT</th>
  <th width="4%">Tot</th>
  <th width="3%">Gross</th>
  <th width="3%">Basic</th>
  <th width="4%">H.Rent</th>
  <th width="4%">Medical</th>
  <th width="4%">Conve.</th>
  <th width="2%">AB</th>
  <th width="3%">AB Amt </th>
  <th width="4%">Advance</th>
  <th width="3%">Mess &amp; Dorm </th>
  <th width="4%">Other</th>
  </tr>
</thead>
<tbody>
<?
 $dsql="select dp.DEPT_DESC as department, s.PBI_DEPARTMENT from
personnel_basic_info a, department dp, salary_attendence s where a.PBI_ID=s.PBI_ID and s.PBI_DEPARTMENT=dp.DEPT_ID and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con."  group by s.PBI_DEPARTMENT order by s.PBI_DEPARTMENT";

 }

$dquery = db_query($dsql);
$p=0;
while($ddata=mysqli_fetch_object($dquery)){

?>


  <tr>
    <th align="center" colspan="25"><center><?=$ddata->department?></center></th>
    </tr>

<?




if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

 $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and
s.PBI_DEPARTMENT='".$ddata->PBI_DEPARTMENT."' and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
 $sqld = 'select * from salary_attendence where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr style="font-size:14px; " height="50" ><td><?=$s?></td><td><?=$datas[1]?></td><td><?=$datas[2]?></td>
  <td><?php echo date('d-m-Y',strtotime($datas[5]));?></td>
  <td><?= $data->pay?></td>
  <td><?= $data->potd?></td>
  <td><?= $tot_day = ($data->pay+$data->potd)?></td>
  <td><?=number_format($data->gross_salary,2); $tot_gross_salary+=$data->gross_salary; ?></td>
  <td><?=number_format($data->basic_salary,2); $tot_basic_salary+=$data->basic_salary; ?></td>
  <td><?=number_format($data->house_rent,2); $tot_house_rent+=$data->house_rent; ?></td>
  <td><?=number_format($data->medical_allowance,2); $tot_medical_allowance+=$data->medical_allowance; ?></td>
  <td style="padding:0;"><?=number_format($data->conveyance_allowance,2); $tot_conveyance_allowance+=$data->conveyance_allowance; ?></td>
  <td><?=number_format($data->attendance_bonus,2); $tot_attendance_bonus+=$data->attendance_bonus;?></td>
  <td style="text-align:right"><?= $tot_ab = ($data->ab+$data->lt+$data->lwp);?></td>
  <td style="text-align:right"><?=number_format($data->absent_deduction,2); $tot_absent_deduction+=$data->absent_deduction;?></td>
  <td style="text-align:right"><?=number_format($data->advance_install,2); $tot_advance_install+=$data->advance_install;?></td>
  <td style="text-align:right"><?=number_format($data->mess_dormitory,2); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
  <td style="text-align:right"><?=number_format($data->deduction,2); $tot_deduction+=$data->deduction;?></td>
  <td style="text-align:right"><?=number_format($data->over_time_amount,2); $tot_over_time_amount+=$data->over_time_amount;?></td>
  <td><?=number_format($data->benefits,2); $tot_benefits+=$data->benefits;?></td>
  <td><?=number_format($data->festival_bonus,2); $tot_festival_bonus+=$data->festival_bonus;?></td>
  <td><?=number_format($data->total_earnings,2); $tot_total_earnings+=$data->total_earnings;?></td>
  <td><?=number_format($data->pf,2); $tot_pf+=$data->pf;?></td>
  <td><?=number_format($data->total_payable,2); $tot_total_payable+=$data->total_payable;?></td>
  <td>&nbsp;</td>
</tr>
<?



}
?>


<tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td colspan="5"><strong>TOTAL</strong></td>
  <td><span class="style1">
    <?=number_format($tot_gross_salary,2); $grand_tot_gross_salary+=$tot_gross_salary;?>
  </span></td>
  <td><span class="style2">
    <?=number_format($tot_basic_salary,2); $grand_tot_basic_salary +=$tot_basic_salary;?>
  </span></td>
  <td><span class="style3">
    <?=number_format($tot_house_rent,2); $grand_tot_house_rent+=$tot_house_rent;?>
  </span></td>
  <td><span class="style4">
    <?=number_format($tot_medical_allowance,2); $grand_tot_medical_allowance+=$tot_medical_allowance;?>
  </span></td>
  <td  style="padding:0;"><span class="style5">
    <?=number_format($tot_conveyance_allowance,2); $grand_tot_conveyance_allowance+=$tot_conveyance_allowance;?>
  </span></td>
  <td><span class="style6">
    <?=number_format($tot_attendance_bonus,2); $grand_tot_attendance_bonus+=$tot_attendance_bonus;?>
  </span></td>
  <td style="text-align:right">&nbsp;</td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($tot_absent_deduction,2); $grand_tot_absent_deduction+=$tot_absent_deduction;?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($tot_advance_install,2); $grand_tot_advance_install+=$tot_advance_install;?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($tot_mess_dormitory,2); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($tot_deduction,2); $grand_tot_deduction+=$tot_deduction;?>
  </span></td>
  <td style="text-align:right"><span class="style10">
    <?=number_format($tot_over_time_amount,2); $grand_tot_over_time_amount+=$tot_over_time_amount;?>
  </span></td>
  <td><span class="style11">
    <?=number_format($tot_benefits,2); $grand_tot_benefits+=$tot_benefits;?>
  </span></td>
  <td><span class="style16">
    <?=number_format($tot_festival_bonus,2); $grand_tot_festival_bonus+=$tot_festival_bonus;?>
  </span></td>
  <td><span class="style12">
    <?=number_format($tot_total_earnings,2); $grand_tot_total_earnings+=$tot_total_earnings;?>
  </span></td>
  <td><span class="style13">
    <?=number_format($tot_pf,2); $grand_tot_pf+=$tot_pf;?>
  </span></td>
  <td><span class="style14">
    <?=number_format($tot_total_payable,2); $grand_tot_total_payable+=$tot_total_payable;?>
  </span></td>
  <td>&nbsp;</td>
</tr>


<?

$tot_gross_salary = 0;
$tot_basic_salary=0;
$tot_house_rent=0;
$tot_medical_allowance=0;
$tot_conveyance_allowance=0;
$tot_attendance_bonus=0;
$tot_absent_deduction=0;
$tot_advance_install=0;
$tot_mess_dormitory=0;
$tot_deduction=0;
$tot_over_time_amount=0;
$tot_benefits=0;
$tot_festival_bonus=0;
$tot_total_earnings=0;
$tot_pf=0;
$tot_total_payable=0;





  }?>





 <tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td colspan="5"><strong>GRAND TOTAL</strong></td>
  <td><span class="style1">
    <?=number_format($grand_tot_gross_salary,2);?>
  </span></td>
  <td><span class="style2">
    <?=number_format($grand_tot_basic_salary,2);?>
  </span></td>
  <td><span class="style3">
    <?=number_format($grand_tot_house_rent,2);?>
  </span></td>
  <td><span class="style4">
    <?=number_format($grand_tot_medical_allowance,2);?>
  </span></td>
  <td  style="padding:0;"><span class="style5">
    <?=number_format($grand_tot_conveyance_allowance,2);?>
  </span></td>
  <td><span class="style6">
    <?=number_format($grand_tot_attendance_bonus,2);?>
  </span></td>
  <td style="text-align:right">&nbsp;</td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($grand_tot_absent_deduction,2);?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($grand_tot_advance_install,2);?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($grand_tot_mess_dormitory,2);?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($grand_tot_deduction,2);?>
  </span></td>
  <td style="text-align:right"><span class="style10">
    <?=number_format($grand_tot_over_time_amount,2);?>
  </span></td>
  <td><span class="style11">
    <?=number_format($grand_tot_benefits,2);?>
  </span></td>
  <td><span class="style16">
    <?=number_format($grand_tot_festival_bonus,2);?>
  </span></td>
  <td><span class="style12">
    <?=number_format($grand_tot_total_earnings,2);?>
  </span></td>
  <td><span class="style13">
    <?=number_format($grand_tot_pf,2);?>
  </span></td>
  <td><span class="style14">
    <?=number_format($grand_tot_total_payable,2);?>
  </span></td>
  <td>&nbsp;</td>
</tr>
 </tbody>

 <tfoot>

	  <tr>
      <td colspan="11" style="border-right-color:#FFFFFF;" align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	  <hr style="width:20%;" />
        Prepared By</td>

	  <td colspan="7" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Checked By</td>

	  <td colspan="8" style="border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Authorised By	    </td>
      </tr>
  </tfoot>
 </table>


<?
}





elseif($_POST['report']==2122019)
{




 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';


if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";

if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr><td style="border:0px;" colspan="23"><?=$str?></td></tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">




<thead>

  <tr>
    <th width="4%" rowspan="2">SL Omar</th>
    <th width="3%" rowspan="2">CODE</th>
    <th width="3%" rowspan="2">Name</th>
    <th width="3%" rowspan="2">Joining</th>
    <th colspan="3">Month Day</th>
    <th colspan="5" align="center"><div align="center">Salary Structure </div></th>
    <th width="6%" rowspan="2">Attn. Bonus </th>
    <th colspan="5"><div align="center">Deduction</div></th>
<th width="4%" rowspan="2">OT AMT</th>
<th width="6%" rowspan="2">Other Allow. </th>
  <th width="4%" rowspan="2">Bonus</th>
  <th width="5%" rowspan="2">Total Earnings </th>
  <th width="5%" rowspan="2">Provident fund </th>
  <th width="4%" rowspan="2">Payable Amount </th>
  <th width="14%" rowspan="2" >Signature<span style="color:#FFFFFF">Signature</span></th>
  </tr>
<tr>
  <th width="2%">Pre</th>
  <th width="2%">OT</th>
  <th width="4%">Tot</th>
  <th width="3%">Gross</th>
  <th width="3%">Basic</th>
  <th width="4%">H.Rent</th>
  <th width="4%">Medical</th>
  <th width="4%">Conve.</th>
  <th width="2%">AB</th>
  <th width="3%">AB Amt </th>
  <th width="4%">Advance</th>
  <th width="3%">Mess &amp; Dorm </th>
  <th width="4%">Other</th>
  </tr>
</thead>
<tbody>
<?

 }
 $omar = 0;
 $dsql="select dp.DEPT_DESC as department, s.PBI_DEPARTMENT from
personnel_basic_info a, department dp, salary_attendence s where a.PBI_ID=s.PBI_ID and s.PBI_DEPARTMENT=dp.DEPT_ID and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con."  group by s.PBI_DEPARTMENT order by s.PBI_DEPARTMENT";

$dquery = db_query($dsql);
$p=0;
while($ddata=mysqli_fetch_object($dquery)){
$omar++;

?>


  <tr  <? if($omar>1) echo ' style="page-break-before:always" ';?>>
    <th align="center" colspan="25"><center><?=$ddata->department?></center></th>
    </tr>

<?




if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

  $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and
s.PBI_DEPARTMENT='".$ddata->PBI_DEPARTMENT."' and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
  $sqld = 'select * from salary_attendence where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr style="font-size:14px; " height="50" ><td><?=$s?></td><td><?=$datas[1]?></td><td><?=$datas[2]?></td>
  <td><?php echo date('d-m-Y',strtotime($datas[5]));?></td>
  <td><?= $data->pay?></td>
  <td><?= $data->potd?></td>
  <td><?= $tot_day = ($data->pay+$data->potd)?></td>
  <td><?=number_format($data->gross_salary,2); $tot_gross_salary+=$data->gross_salary; ?></td>
  <td><?=number_format($data->basic_salary,2); $tot_basic_salary+=$data->basic_salary; ?></td>
  <td><?=number_format($data->house_rent,2); $tot_house_rent+=$data->house_rent; ?></td>
  <td><?=number_format($data->medical_allowance,2); $tot_medical_allowance+=$data->medical_allowance; ?></td>
  <td style="padding:0;"><?=number_format($data->conveyance_allowance,2); $tot_conveyance_allowance+=$data->conveyance_allowance; ?></td>
  <td><?=number_format($data->attendance_bonus,2); $tot_attendance_bonus+=$data->attendance_bonus;?></td>
  <td style="text-align:right"><?= $tot_ab = ($data->ab+$data->lt+$data->lwp);?></td>
  <td style="text-align:right"><?=number_format($data->absent_deduction,2); $tot_absent_deduction+=$data->absent_deduction;?></td>
  <td style="text-align:right"><?=number_format($data->advance_install,2); $tot_advance_install+=$data->advance_install;?></td>
  <td style="text-align:right"><?=number_format($data->mess_dormitory,2); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
  <td style="text-align:right"><?=number_format($data->deduction,2); $tot_deduction+=$data->deduction;?></td>
  <td style="text-align:right"><?=number_format($data->over_time_amount,2); $tot_over_time_amount+=$data->over_time_amount;?></td>
  <td><?=number_format($data->benefits,2); $tot_benefits+=$data->benefits;?></td>
  <td><?=number_format($data->festival_bonus,2); $tot_festival_bonus+=$data->festival_bonus;?></td>
  <td><?=number_format($data->total_earnings,2); $tot_total_earnings+=$data->total_earnings;?></td>
  <td><?=number_format($data->pf,2); $tot_pf+=$data->pf;?></td>
  <td><?=number_format($data->total_payable,2); $tot_total_payable+=$data->total_payable;?></td>
  <td>&nbsp;</td>
</tr>
<?



}
?>


<tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td colspan="5"><strong>TOTAL</strong></td>
  <td><span class="style1">
    <?=number_format($tot_gross_salary,2); $grand_tot_gross_salary+=$tot_gross_salary;?>
  </span></td>
  <td><span class="style2">
    <?=number_format($tot_basic_salary,2); $grand_tot_basic_salary +=$tot_basic_salary;?>
  </span></td>
  <td><span class="style3">
    <?=number_format($tot_house_rent,2); $grand_tot_house_rent+=$tot_house_rent;?>
  </span></td>
  <td><span class="style4">
    <?=number_format($tot_medical_allowance,2); $grand_tot_medical_allowance+=$tot_medical_allowance;?>
  </span></td>
  <td  style="padding:0;"><span class="style5">
    <?=number_format($tot_conveyance_allowance,2); $grand_tot_conveyance_allowance+=$tot_conveyance_allowance;?>
  </span></td>
  <td><span class="style6">
    <?=number_format($tot_attendance_bonus,2); $grand_tot_attendance_bonus+=$tot_attendance_bonus;?>
  </span></td>
  <td style="text-align:right">&nbsp;</td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($tot_absent_deduction,2); $grand_tot_absent_deduction+=$tot_absent_deduction;?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($tot_advance_install,2); $grand_tot_advance_install+=$tot_advance_install;?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($tot_mess_dormitory,2); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($tot_deduction,2); $grand_tot_deduction+=$tot_deduction;?>
  </span></td>
  <td style="text-align:right"><span class="style10">
    <?=number_format($tot_over_time_amount,2); $grand_tot_over_time_amount+=$tot_over_time_amount;?>
  </span></td>
  <td><span class="style11">
    <?=number_format($tot_benefits,2); $grand_tot_benefits+=$tot_benefits;?>
  </span></td>
  <td><span class="style16">
    <?=number_format($tot_festival_bonus,2); $grand_tot_festival_bonus+=$tot_festival_bonus;?>
  </span></td>
  <td><span class="style12">
    <?=number_format($tot_total_earnings,2); $grand_tot_total_earnings+=$tot_total_earnings;?>
  </span></td>
  <td><span class="style13">
    <?=number_format($tot_pf,2); $grand_tot_pf+=$tot_pf;?>
  </span></td>
  <td><span class="style14">
    <?=number_format($tot_total_payable,2); $grand_tot_total_payable+=$tot_total_payable;?>
  </span></td>
  <td>&nbsp;</td>
</tr>


<?

$tot_gross_salary = 0;
$tot_basic_salary=0;
$tot_house_rent=0;
$tot_medical_allowance=0;
$tot_conveyance_allowance=0;
$tot_attendance_bonus=0;
$tot_absent_deduction=0;
$tot_advance_install=0;
$tot_mess_dormitory=0;
$tot_deduction=0;
$tot_over_time_amount=0;
$tot_benefits=0;
$tot_festival_bonus=0;
$tot_total_earnings=0;
$tot_pf=0;
$tot_total_payable=0;





  }?>





 <tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td colspan="5"><strong>GRAND TOTAL</strong></td>
  <td><span class="style1">
    <?=number_format($grand_tot_gross_salary,2);?>
  </span></td>
  <td><span class="style2">
    <?=number_format($grand_tot_basic_salary,2);?>
  </span></td>
  <td><span class="style3">
    <?=number_format($grand_tot_house_rent,2);?>
  </span></td>
  <td><span class="style4">
    <?=number_format($grand_tot_medical_allowance,2);?>
  </span></td>
  <td  style="padding:0;"><span class="style5">
    <?=number_format($grand_tot_conveyance_allowance,2);?>
  </span></td>
  <td><span class="style6">
    <?=number_format($grand_tot_attendance_bonus,2);?>
  </span></td>
  <td style="text-align:right">&nbsp;</td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($grand_tot_absent_deduction,2);?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($grand_tot_advance_install,2);?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($grand_tot_mess_dormitory,2);?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($grand_tot_deduction,2);?>
  </span></td>
  <td style="text-align:right"><span class="style10">
    <?=number_format($grand_tot_over_time_amount,2);?>
  </span></td>
  <td><span class="style11">
    <?=number_format($grand_tot_benefits,2);?>
  </span></td>
  <td><span class="style16">
    <?=number_format($grand_tot_festival_bonus,2);?>
  </span></td>
  <td><span class="style12">
    <?=number_format($grand_tot_total_earnings,2);?>
  </span></td>
  <td><span class="style13">
    <?=number_format($grand_tot_pf,2);?>
  </span></td>
  <td><span class="style14">
    <?=number_format($grand_tot_total_payable,2);?>
  </span></td>
  <td>&nbsp;</td>
</tr>
 </tbody>

 <tfoot>

	  <tr>
      <td colspan="11" style="border-right-color:#FFFFFF;" align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	  <hr style="width:20%;" />
        Prepared By</td>

	  <td colspan="7" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Checked By</td>

	  <td colspan="8" style="border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Authorised By	    </td>
      </tr>
  </tfoot>
 </table>


<?
}
















elseif($_POST['report']==212201911)
{





 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	 if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

	if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";





if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
  <!--<table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="24"><?=$str?></td>
    </tr>
  </table>-->
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>

	<tr>
		<td colspan="27" style="border:0px;" align="center">
		<? if($_POST['PBI_ORG']!='') { ?>
		<h2 style="font-size:24px;"> <?= find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']) ?></h2>

		<? }?>


		<h2 style="text-align: center;">Monthly Salary Sheet Summary</h2>

		<h2>Report of Month: <?= date('F-Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year']))?></h2>



		<?php /*?>	<? if($_POST['payroll_type']!='') { ?>
		<h2 style="font-size:20px;"> Payroll Type: <?= find_a_field('salary_payroll_type','payroll_type','ID='.$_POST['payroll_type']) ?></h2>
		<? }?>
		<?php */?>


		<?php /*?><? if($_POST['department']!='') { ?>
		<h2> <?= find_a_field('department','DEPT_DESC','DEPT_ID='.$_POST['department']) ?></h2>
		<? }?><?php */?>		</td>
	  </tr>

      <tr>
        <th width="4%" rowspan="2">SL</th>
        <th width="3%" rowspan="2">CODE</th>
        <th width="3%" rowspan="2">Name</th>
        <th width="3%" rowspan="2">Joining</th>
        <th colspan="3">Month Day</th>
        <th colspan="5" align="center" bgcolor="#99CCCC"><div align="center">Salary Structure </div></th>
        <th colspan="4" bgcolor="#99CCCC"><div align="center">Earnings</div></th>
        <th colspan="2" bgcolor="#99CCCC"><div align="center">Absence</div></th>
        <th width="6%" rowspan="2" bgcolor="#99CCCC">Total<br> Earnings</th>
        <th colspan="6" bgcolor="#538ED5"><div align="center">Deduction</div></th>
        <th width="4%" rowspan="2">Payable Amount </th>
        <th width="14%" rowspan="2" >Signature<span style="color:#FFFFFF">Signature</span></th>
      </tr>
      <tr>
        <th width="2%">Pre</th>
        <th width="2%">OT</th>
        <th width="4%">Tot</th>
        <th width="3%" bgcolor="#99CCCC">Gross</th>
        <th width="3%" bgcolor="#99CCCC">Basic</th>
        <th width="4%" bgcolor="#99CCCC">H.Rent</th>
        <th width="4%" bgcolor="#99CCCC">Medical</th>
        <th width="4%" bgcolor="#99CCCC">Conve.</th>
        <th width="3%" bgcolor="#99CCCC">Att Bonus </th>
        <th width="3%" bgcolor="#99CCCC">OT AMT</th>
        <th width="6%" bgcolor="#99CCCC">Other Allow. </th>
        <th width="6%" bgcolor="#99CCCC">Bonus</th>
        <th width="6%" bgcolor="#99CCCC">AB</th>
        <th width="6%" bgcolor="#99CCCC">AB Amt </th>
        <th width="4%" bgcolor="#538ED5">Advance</th>
        <th width="3%" bgcolor="#538ED5">Mess &amp; Dorm </th>
        <th width="2%" bgcolor="#538ED5">Other</th>
        <th width="1%" bgcolor="#538ED5">PF</th>
        <th width="1%" bgcolor="#538ED5">Partial Salary Adjust</th>
        <th width="1%" bgcolor="#538ED5">Total Deduction </th>
      </tr>
    </thead>
    <tbody>
      <?

 }
 $omar = 0;
 $dsql="select dp.DEPT_DESC as department, s.PBI_DEPARTMENT from
personnel_basic_info a, department dp, salary_attendence s where a.PBI_ID=s.PBI_ID and s.PBI_DEPARTMENT=dp.DEPT_ID and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON."  group by s.PBI_DEPARTMENT order by s.PBI_DEPARTMENT";

$dquery = db_query($dsql);
$p=0;
while($ddata=mysqli_fetch_object($dquery)){
$omar++;

?>
      <tr  <? if($omar>1) echo ' style="page-break-before:always" ';?>>
        <th align="center" colspan="27"><center>
            <?=$ddata->department?>
        </center></th>
      </tr>
      <?




if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

   $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and
s.PBI_DEPARTMENT='".$ddata->PBI_DEPARTMENT."' and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
  $sqld = 'select * from salary_attendence where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
      <tr style="font-size:14px; " height="80" >
        <td><?=$s?></td>
        <td><?=$datas[1]?></td>
        <td><?=$datas[2]?></td>
        <td><?php echo date('d-m-Y',strtotime($datas[5]));?></td>
        <td><?= $data->pay?></td>
        <td><?= $data->potd?></td>
        <td><?= $tot_day = ($data->pay+$data->potd)?></td>
        <td><?=number_format($data->gross_salary,0); $tot_gross_salary+=$data->gross_salary; ?></td>
        <td><?=number_format($data->basic_salary,0); $tot_basic_salary+=$data->basic_salary; ?></td>
        <td><?=number_format($data->house_rent,0); $tot_house_rent+=$data->house_rent; ?></td>
        <td><?=number_format($data->medical_allowance,0); $tot_medical_allowance+=$data->medical_allowance; ?></td>
        <td style="padding:0;"><?=number_format($data->conveyance_allowance,0); $tot_conveyance_allowance+=$data->conveyance_allowance; ?></td>
        <td><?=number_format($data->attendance_bonus,0); $tot_attendance_bonus+=$data->attendance_bonus;?></td>
        <td><span style="text-align:right">
          <?=number_format($data->over_time_amount,0); $tot_over_time_amount+=$data->over_time_amount;?>
          </span></td>
        <td><?=number_format($data->benefits,0); $tot_benefits+=$data->benefits;?></td>
        <td><?=number_format($data->festival_bonus,0); $tot_festival_bonus+=$data->festival_bonus;?></td>
        <td><span style="text-align:right">
          <?= $tot_ab = ($data->ab+$data->lt+$data->lwp);?>
        </span></td>
        <td><span style="text-align:right">
          <?=number_format($data->absent_deduction,0); $tot_absent_deduction+=$data->absent_deduction;?>
        </span></td>
        <td><?=number_format($salary_total_earnings=($data->total_salary+$data->attendance_bonus+$data->over_time_amount+$data->other_benefits+$data->festival_bonus+$data->benefits)-$data->absent_deduction,0);
		$tot_total_earnings+=($data->total_salary+$data->attendance_bonus+$data->over_time_amount+$data->other_benefits+$data->festival_bonus+$data->benefits)-$data->absent_deduction;?></td>
        <td style="text-align:right"><?=number_format($data->advance_install,0); $tot_advance_install+=$data->advance_install;?></td>
        <td style="text-align:right"><?=number_format($data->mess_dormitory,0); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
        <td style="text-align:right"><?=number_format($data->deduction,0); $tot_deduction+=$data->deduction;?></td>
        <td style="text-align:right"><?=number_format($data->pf,0); $tot_pf+=$data->pf;?></td>
        <td style="text-align:right"><?=number_format($data->partial_salary_adjustment,0); $tot_partial_salary_adjustment+=$data->partial_salary_adjustment;?></td>
        <td style="text-align:right"><?=number_format($salary_total_deduction=($data->advance_install+$data->mess_dormitory+$data->other_deduction+$data->pf+$data->stamp_charge+$data->partial_salary_adjustment+$data->deduction),0);
		$tot_total_deduction+=($data->advance_install+$data->mess_dormitory+$data->other_deduction+$data->pf+$data->stamp_charge
		+$data->partial_salary_adjustment+$data->deduction);?></td>
        <td><?=number_format($salary_total_payable=($salary_total_earnings-$salary_total_deduction),0); $tot_total_payable+=($salary_total_earnings-$salary_total_deduction);?></td>
        <td>&nbsp;</td>
      </tr>
      <?



}
?>
      <tr height="30">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5"><strong>TOTAL</strong></td>
        <td><span class="style1">
          <?=number_format($tot_gross_salary,0); $grand_tot_gross_salary+=$tot_gross_salary;?>
          </span></td>
        <td><span class="style2">
          <?=number_format($tot_basic_salary,0); $grand_tot_basic_salary +=$tot_basic_salary;?>
          </span></td>
        <td><span class="style3">
          <?=number_format($tot_house_rent,0); $grand_tot_house_rent+=$tot_house_rent;?>
          </span></td>
        <td><span class="style4">
          <?=number_format($tot_medical_allowance,0); $grand_tot_medical_allowance+=$tot_medical_allowance;?>
          </span></td>
        <td  style="padding:0;"><span class="style5">
          <?=number_format($tot_conveyance_allowance,0); $grand_tot_conveyance_allowance+=$tot_conveyance_allowance;?>
          </span></td>
        <td><span class="style6">
          <?=number_format($tot_attendance_bonus,0); $grand_tot_attendance_bonus+=$tot_attendance_bonus;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_over_time_amount,0); $grand_tot_over_time_amount+=$tot_over_time_amount;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_benefits,0); $grand_tot_benefits+=$tot_benefits;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_festival_bonus,0); $grand_tot_festival_bonus+=$tot_festival_bonus;?>
          </span></td>
        <td>&nbsp;</td>
        <td><span class="style16">
          <?=number_format($tot_absent_deduction,0); $grand_tot_absent_deduction+=$tot_absent_deduction;?>
        </span></td>
        <td><span class="style16">
          <?=number_format($tot_total_earnings,0); $grand_tot_total_earnings+=$tot_total_earnings;?>
          </span></td>
        <td style="text-align:right"><span class="style8">
          <?=number_format($tot_advance_install,0); $grand_tot_advance_install+=$tot_advance_install;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_mess_dormitory,0); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
          </span></td>
        <td style="text-align:right"><span class="style9">
          <?=number_format($tot_deduction,0); $grand_tot_deduction+=$tot_deduction;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_pf,0); $grand_tot_pf+=$tot_pf;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_partial_salary_adjustment,0); $grand_tot_tot_partial_salary_adjustment+=$tot_partial_salary_adjustment;?>
        </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_total_deduction,0); $grand_tot_total_deduction+=$tot_total_deduction;?>
          </span></td>
        <td><span class="style14">
          <?=number_format($tot_total_payable,0); $grand_tot_total_payable+=$tot_total_payable;?>
          </span></td>
        <td>&nbsp;</td>
      </tr>
      <?

$tot_gross_salary = 0;
$tot_basic_salary=0;
$tot_house_rent=0;
$tot_medical_allowance=0;
$tot_conveyance_allowance=0;
$tot_attendance_bonus=0;
$tot_absent_deduction=0;
$tot_advance_install=0;
$tot_mess_dormitory=0;
$tot_deduction=0;
$tot_over_time_amount=0;
$tot_benefits=0;
$tot_festival_bonus=0;
$tot_total_earnings=0;
$tot_total_deduction=0;
$tot_pf=0;
$tot_stamp_charge=0;
$tot_partial_salary_adjustment=0;
$tot_total_payable=0;


  }?>
      <tr height="30">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5"><strong>GRAND TOTAL</strong></td>
        <td><span class="style1">
          <?=number_format($grand_tot_gross_salary,0);?>
          </span></td>
        <td><span class="style2">
          <?=number_format($grand_tot_basic_salary,0);?>
          </span></td>
        <td><span class="style3">
          <?=number_format($grand_tot_house_rent,0);?>
          </span></td>
        <td><span class="style4">
          <?=number_format($grand_tot_medical_allowance,0);?>
          </span></td>
        <td  style="padding:0;"><span class="style5">
          <?=number_format($grand_tot_conveyance_allowance,0);?>
          </span></td>
        <td><span class="style6">
          <?=number_format($grand_tot_attendance_bonus,0);?>
          </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_over_time_amount,0);?>
          </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_benefits,0);?>
          </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_festival_bonus,0);?>
          </span></td>
        <td>&nbsp;</td>
        <td><span class="style16">
          <?=number_format($grand_tot_absent_deduction,0);?>
        </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_total_earnings,0);?>
          </span></td>
        <td style="text-align:right"><span class="style8">
          <?=number_format($grand_tot_advance_install,0);?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($grand_tot_mess_dormitory,0);?>
          </span></td>
        <td style="text-align:right"><span class="style9">
          <?=number_format($grand_tot_deduction,0);?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($grand_tot_pf,0);?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($grand_tot_tot_partial_salary_adjustment,0);?>
        </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($grand_tot_total_deduction,0);?>
          </span></td>
        <td><span class="style14">
          <?=number_format($grand_tot_total_payable,0);?>
          </span></td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="11" style="border-right-color:#FFFFFF;" align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Prepared By</td>
        <td colspan="14" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Checked By</td>
        <td colspan="3" style="border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Authorised By </td>
      </tr>
    </tfoot>
  </table>
  <?
}








elseif($_POST['report']==220419001)
{



 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	 if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

	if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";





if($_POST['bonus_type']>0&&$_POST['year']>0)

{

	$bonus_type = $_POST['bonus_type'];
	$year = $_POST['year'];


?>
  <!--<table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="24"><?=$str?></td>
    </tr>
  </table>-->
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>

	<tr>
		<td colspan="9" style="border:0px;" align="center">
		<? if($_POST['PBI_ORG']!='') { ?>
		<h2 style="font-size:24px; margin:0; padding-bottom:10px;"> <?= find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']) ?></h2>

		<? }?>


		<h2 style="text-align: center; margin:0; padding-bottom:10px;">Eid Bonus Sheet Summary</h2>

		<? if($_POST['bonus_type']!='') { ?>
		<h2 style="font-size:20px; margin:0; padding-bottom:10px;">Eid Bonus: <?= find_a_field('salary_festival_bonus','festival_type','id='.$_POST['bonus_type']) ?></h2>

		<? }?>

		<h2 style=" margin:0; padding-bottom:10px;">Report of Month: <?= date('F-Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year']))?></h2>



		<?php /*?>	<? if($_POST['payroll_type']!='') { ?>
		<h2 style="font-size:20px;"> Payroll Type: <?= find_a_field('salary_payroll_type','payroll_type','ID='.$_POST['payroll_type']) ?></h2>
		<? }?>
		<?php */?>


		<?php /*?><? if($_POST['department']!='') { ?>
		<h2> <?= find_a_field('department','DEPT_DESC','DEPT_ID='.$_POST['department']) ?></h2>
		<? }?><?php */?>		</td>
	  </tr>

      <tr style="font-size:14px;" height="35">
        <th width="3%">SL</th>
        <th width="7%">EMP CODE</th>
        <th width="19%">Employee Name</th>
        <th width="10%">Joining</th>
        <th width="7%" align="center" bgcolor="#99CCCC"><div align="center">Gross Salary  </div></th>
        <th width="7%" align="center" bgcolor="#99CCCC">Service Length</th>
        <th width="7%" align="center" bgcolor="#99CCCC">Month Count</th>
        <th width="9%" bgcolor="#99CCCC"><div align="center">Eid Bonus </div></th>
        <th width="13%" ><div align="center">Signature</div></th>
      </tr>
    </thead>
    <tbody>
      <?

 }
 $omar = 0;
 $dsql="select dp.DEPT_DESC as department, s.PBI_DEPARTMENT from
personnel_basic_info a, department dp, salary_attendence_bonus s where a.PBI_ID=s.PBI_ID and s.PBI_DEPARTMENT=dp.DEPT_ID and s.bonus_type='".$bonus_type."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON."  group by s.PBI_DEPARTMENT order by s.PBI_DEPARTMENT";

$dquery = db_query($dsql);
$p=0;
while($ddata=mysqli_fetch_object($dquery)){
$omar++;

?>
      <tr  <? if($omar>1) echo ' style="page-break-before:always" ';?> >
        <th align="center" colspan="9" style="font-size:14px;"><center>
            <?=$ddata->department?>
        </center></th>
      </tr>
      <?




if($_POST['bonus_type']>0&&$_POST['year']>0)

{

	$bonus_type = $_POST['bonus_type'];
	$year = $_POST['year'];

   $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence_bonus s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and
s.PBI_DEPARTMENT='".$ddata->PBI_DEPARTMENT."' and s.bonus_type='".$bonus_type."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
  $sqld = 'select * from salary_attendence_bonus where bonus_type="'.$bonus_type.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
      <tr style="font-size:14px; " height="80" >
        <td><?=$s?></td>
        <td><?=$datas[1]?></td>
        <td><?=$datas[2]?></td>
        <td><?php echo date('d-m-Y',strtotime($datas[5]));?></td>
        <td><div align="right">
          <?=number_format($data->gross_salary,0); $tot_gross_salary+=$data->gross_salary; ?>
        </div></td>
        <td><?=$data->service_length?></td>
        <td><?=$data->month_count?></td>
        <td><div align="right">
          <?=number_format($data->festival_bonus,0); $tot_festival_bonus+=$data->festival_bonus;?>
        </div></td>
        <td>&nbsp;</td>
      </tr>
      <?



}
?>
      <tr height="30" style="font-size:14px;">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><strong>TOTAL</strong></td>
        <td><div align="right"><span class="style1">
          <?=number_format($tot_gross_salary,0); $grand_tot_gross_salary+=$tot_gross_salary;?>
        </span></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="right"><span class="style16">
          <?=number_format($tot_festival_bonus,0); $grand_tot_festival_bonus+=$tot_festival_bonus;?>
        </span></div></td>
        <td>&nbsp;</td>
      </tr>
      <?

$tot_gross_salary = 0;
$tot_basic_salary=0;
$tot_house_rent=0;
$tot_medical_allowance=0;
$tot_conveyance_allowance=0;
$tot_attendance_bonus=0;
$tot_absent_deduction=0;
$tot_advance_install=0;
$tot_mess_dormitory=0;
$tot_deduction=0;
$tot_over_time_amount=0;
$tot_benefits=0;
$tot_festival_bonus=0;
$tot_total_earnings=0;
$tot_total_deduction=0;
$tot_pf=0;
$tot_stamp_charge=0;
$tot_partial_salary_adjustment=0;
$tot_total_payable=0;


  }?>
      <tr height="30" style="font-size:14px;">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><strong>GRAND TOTAL</strong></td>
        <td><div align="right"><span class="style1">
          <?=number_format($grand_tot_gross_salary,0);?>
        </span></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="right"><span class="style16">
          <?=number_format($grand_tot_festival_bonus,0);?>
        </span></div></td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3" align="center" style="border-color:#FFFFFF;"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Prepared By</td>
        <td colspan="3" align="center" style="border-color:#FFFFFF;"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
        Checked By</td>
        <td colspan="4" align="center" style="border-color:#FFFFFF;"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
        Authorised By </td>
      </tr>
    </tfoot>
  </table>
  <?
}









elseif($_POST['report']==220423001)
{



 if($_POST['PBI_ORG']!='')
	$group_con.=' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	 if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

if($_POST['shedule_no']!='')
	$shedule_con.=' and s.shedule_1 = "'.$_POST['shedule_no'].'"';


	if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";





	$bonus_type = $_POST['bonus_type'];
	$year = $_POST['year'];

	$att_date = $_POST['tdate'];




?>
  <!--<table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="24"><?=$str?></td>
    </tr>
  </table>-->
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>

	<tr>
		<td colspan="8" style="border:0px;" align="center">
		<? if($_POST['PBI_ORG']!='') { ?>
		<h2 style="font-size:24px; margin:0; padding-bottom:10px;"> <?= find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']) ?></h2>

		<? }?>


		<h2 style="text-align: center; margin:0; padding-bottom:10px;">Daily Attendance Report </h2>

		<? if($_POST['define_shift']!='') { ?>
		<h2 style="font-size:20px; margin:0; padding-bottom:10px;">Define Shift: <?= find_a_field('hrm_shift_info','shift_name','id='.$_POST['define_shift']) ?></h2>

		<? }?>

		<h2 style=" margin:0; padding-bottom:10px;">Report of Month: <?= date('F-Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year']))?></h2>



		<?php /*?>	<? if($_POST['payroll_type']!='') { ?>
		<h2 style="font-size:20px;"> Payroll Type: <?= find_a_field('salary_payroll_type','payroll_type','ID='.$_POST['payroll_type']) ?></h2>
		<? }?>
		<?php */?>


		<?php /*?><? if($_POST['department']!='') { ?>
		<h2> <?= find_a_field('department','DEPT_DESC','DEPT_ID='.$_POST['department']) ?></h2>
		<? }?><?php */?>		</td>
	  </tr>

      <tr style="font-size:14px;">
        <th width="3%" rowspan="2">SL</th>
        <th width="7%" rowspan="2">EMP CODE</th>
        <th width="19%" rowspan="2">Employee Name</th>
        <th width="10%" rowspan="2">Att. Date </th>
        <th colspan="2" align="center" bgcolor="#99CCCC"><div align="center">Schedule Time </div></th>
        <th bgcolor="#99CCCC"><div align="center">
          <div align="center">Attendance Time </div>
            </div></th>
        <th width="13%" rowspan="2" >Status</th>
      </tr>
      <tr style="font-size:14px;">
        <th width="7%" bgcolor="#99CCCC">In Time </th>
        <th width="8%" bgcolor="#99CCCC">Out Time </th>
        <th bgcolor="#99CCCC">In Time </th>
      </tr>
    </thead>
    <tbody>
      <?


	$sql = "select xdate, xenrollid, xtime, time(xtime) as punch_time  from hrm_attdump where  xdate='".$att_date."' ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $punch_time[$info->xenrollid][$info->xdate]=$info->punch_time;
		 $xtime[$info->xenrollid][$info->xdate]=$info->xtime;

		}



 $omar = 0;
    $dsql="select dp.DEPT_DESC as department, a.PBI_DEPARTMENT from
personnel_basic_info a, department dp, hrm_roster_allocation s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and s.roster_date='".$att_date."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON.$shedule_con."  group by a.PBI_DEPARTMENT order by a.PBI_DEPARTMENT";

$dquery = db_query($dsql);
$p=0;
while($ddata=mysqli_fetch_object($dquery)){
$omar++;

?>
      <tr  <? if($omar>1) echo ' style="page-break-before:always" ';?> >
        <th align="center" colspan="8" style="font-size:14px;"><center>
            <?=$ddata->department?>
        </center></th>
      </tr>
      <?







   $sqll="select s.PBI_ID, a.PBI_CODE, a.PBI_NAME, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, s.roster_date, s.EMP_CODE, s.sch_in_time, s.sch_out_time
    from personnel_basic_info a, department dp, designation ds, hrm_roster_allocation s
	 where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID  and s.roster_date='".$att_date."'  and a.PBI_DEPARTMENT='".$ddata->PBI_DEPARTMENT."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON.$shedule_con." group by a.PBI_ID order by s.EMP_CODE ";

$query = db_query($sqll);

$s=0;

while($datas=mysqli_fetch_object($query)){$s++;
 // $sqld = 'select * from salary_attendence_bonus where bonus_type="'.$bonus_type.'" and year="'.$year.'" and PBI_ID='.$datas[0];
//$data = mysqli_fetch_object(db_query($sqld));
?>
      <tr style="font-size:14px; " height="30" >
        <td><?=$s?></td>
        <td><?=$datas->EMP_CODE;?></td>
        <td><?=$datas->PBI_NAME?></td>
        <td><?php echo date('d-m-Y',strtotime($datas->roster_date));?></td>
        <td><div align="right">
          <?=$datas->sch_in_time; ?>

        </div></td>
        <td style="padding:0;"><div align="right">
           <?=$datas->sch_out_time; ?>
        </div></td>
        <td width="9%"><div align="right">



		<?
		$before_time=$datas->sch_in_time;
		$before_time = date('H:i', strtotime($before_time.'-1 hour'));
		 $before_time;

		$after_time=$datas->sch_in_time;
		$after_time = date('H:i', strtotime($after_time.'+2 hour'));
		 $after_time;
		?>


	<? if($punch_time[$datas->PBI_ID][$datas->roster_date]  > $before_time  && $punch_time[$datas->PBI_ID][$datas->roster_date] < $after_time) { ?>

		<?= $today_att_tiem = $punch_time[$datas->PBI_ID][$datas->roster_date];?>

	<? }?>


        </div></td>
        <td>

	<? if($punch_time[$datas->PBI_ID][$datas->roster_date]  > $before_time  && $punch_time[$datas->PBI_ID][$datas->roster_date] < $after_time) { ?>

<?php
$start = strtotime($datas->sch_in_time);
$end = strtotime($punch_time[$datas->PBI_ID][$datas->roster_date]);
$mins = ($end - $start) / 60;
  $mins;
?>

	<? }?>

	<? if($punch_time[$datas->PBI_ID][$datas->roster_date]  > $before_time  && $punch_time[$datas->PBI_ID][$datas->roster_date] < $after_time) { ?>
	<?
	if ($mins>0) {
	 echo 'Late '.number_format($mins,0). ' Min';
	} elseif ($mins<0) {
	 echo 'Regular';
	}

	?>
<? } else { ?>

		Absence

		<? }?>

		</td>
      </tr>
      <?



}
?>

      <?



  }?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="5" style="border-right-color:#FFFFFF;" align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Prepared By</td>
        <td colspan="2" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Checked By</td>
        <td colspan="2" style="border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Authorised By </td>
      </tr>
    </tfoot>
  </table>
  <?
}
















elseif($_POST['report']==210713001)
{





 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	 if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

	if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";





if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
  <!--<table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="24"><?=$str?></td>
    </tr>
  </table>-->
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>

	<tr>
		<td colspan="27" style="border:0px;" align="center">
		<? if($_POST['PBI_ORG']!='') { ?>
		<h2 style="font-size:24px;"> <?= find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']) ?></h2>

		<? }?>


		<h2 style="text-align: center;">Partial Salary Report</h2>

		<h2>Report of Month: <?= date('F-Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year']))?></h2>



		<?php /*?>	<? if($_POST['payroll_type']!='') { ?>
		<h2 style="font-size:20px;"> Payroll Type: <?= find_a_field('salary_payroll_type','payroll_type','ID='.$_POST['payroll_type']) ?></h2>
		<? }?>
		<?php */?>


		<?php /*?><? if($_POST['department']!='') { ?>
		<h2> <?= find_a_field('department','DEPT_DESC','DEPT_ID='.$_POST['department']) ?></h2>
		<? }?><?php */?>		</td>
	  </tr>

      <tr>
        <th width="4%" rowspan="2">SL </th>
        <th width="3%" rowspan="2">CODE</th>
        <th width="3%" rowspan="2">Name</th>
        <th width="3%" rowspan="2">Joining</th>
        <th colspan="4">Month Day</th>
        <th colspan="5" align="center" bgcolor="#99CCCC"><div align="center">Salary Structure </div></th>
        <th colspan="4" bgcolor="#99CCCC"><div align="center">Earnings</div></th>
        <th colspan="2" bgcolor="#99CCCC"><div align="center">Absence</div></th>
        <th width="6%" rowspan="2" bgcolor="#99CCCC">Total<br> Earnings</th>
        <th colspan="5" bgcolor="#538ED5"><div align="center">Deduction</div></th>
        <th width="4%" rowspan="2">Payable Amount </th>
        <th width="14%" rowspan="2" >Signature<span style="color:#FFFFFF">Signature</span></th>
      </tr>
      <tr>
        <th width="2%">Pre</th>
        <th width="2%">OT</th>
        <th width="2%">AB</th>
        <th width="4%">PAY</th>
        <th width="3%" bgcolor="#99CCCC">Gross</th>
        <th width="3%" bgcolor="#99CCCC">Basic</th>
        <th width="4%" bgcolor="#99CCCC">H.Rent</th>
        <th width="4%" bgcolor="#99CCCC">Medical</th>
        <th width="4%" bgcolor="#99CCCC">Conve.</th>
        <th width="3%" bgcolor="#99CCCC">Att Bonus </th>
        <th width="3%" bgcolor="#99CCCC">OT AMT</th>
        <th width="6%" bgcolor="#99CCCC">Other Allow. </th>
        <th width="6%" bgcolor="#99CCCC">Bonus</th>
        <th width="6%" bgcolor="#99CCCC">AB</th>
        <th width="6%" bgcolor="#99CCCC">AB Amt </th>
        <th width="4%" bgcolor="#538ED5">Advance</th>
        <th width="3%" bgcolor="#538ED5">Mess &amp; Dorm </th>
        <th width="2%" bgcolor="#538ED5">Other</th>
        <th width="1%" bgcolor="#538ED5">PF</th>
        <th width="1%" bgcolor="#538ED5">Total Deduction </th>
      </tr>
    </thead>
    <tbody>
      <?

 }
 $omar = 0;
 $dsql="select dp.DEPT_DESC as department, s.PBI_DEPARTMENT from
personnel_basic_info a, department dp, salary_attendence_partial s where a.PBI_ID=s.PBI_ID and s.PBI_DEPARTMENT=dp.DEPT_ID and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON."  group by s.PBI_DEPARTMENT order by s.PBI_DEPARTMENT";

$dquery = db_query($dsql);
$p=0;
while($ddata=mysqli_fetch_object($dquery)){
$omar++;

?>
      <tr  <? if($omar>1) echo ' style="page-break-before:always" ';?>>
        <th align="center" colspan="27"><center>
            <?=$ddata->department?>
        </center></th>
      </tr>
      <?




if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

   $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence_partial s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and
s.PBI_DEPARTMENT='".$ddata->PBI_DEPARTMENT."' and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
  $sqld = 'select * from salary_attendence_partial where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
      <tr style="font-size:14px; " height="80" >
        <td><?=$s?></td>
        <td><?=$datas[1]?></td>
        <td><?=$datas[2]?></td>
        <td><?php echo date('d-m-Y',strtotime($datas[5]));?></td>
        <td><?= $data->partial_day?></td>
        <td><?= $data->ot_day?></td>
        <td><?= $data->ab_day?></td>
        <td><?= $data->pay_day?></td>
        <td><?=number_format($data->gross_salary,0); $tot_gross_salary+=$data->gross_salary; ?></td>
        <td><?=number_format($data->basic_salary,0); $tot_basic_salary+=$data->basic_salary; ?></td>
        <td><?=number_format($data->house_rent,0); $tot_house_rent+=$data->house_rent; ?></td>
        <td><?=number_format($data->medical_allowance,0); $tot_medical_allowance+=$data->medical_allowance; ?></td>
        <td style="padding:0;"><?=number_format($data->conveyance_allowance,0); $tot_conveyance_allowance+=$data->conveyance_allowance; ?></td>
        <td><?=number_format($data->attendance_bonus,0); $tot_attendance_bonus+=$data->attendance_bonus;?></td>
        <td><span style="text-align:right">
          <?=number_format($data->over_time_amount,0); $tot_over_time_amount+=$data->over_time_amount;?>
          </span></td>
        <td><?=number_format($data->benefits,0); $tot_benefits+=$data->benefits;?></td>
        <td><?=number_format($data->festival_bonus,0); $tot_festival_bonus+=$data->festival_bonus;?></td>
        <td><span style="text-align:right">
          <?= $tot_ab = ($data->ab+$data->lt+$data->lwp);?>
        </span></td>
        <td><span style="text-align:right">
          <?=number_format($data->absent_deduction,0); $tot_absent_deduction+=$data->absent_deduction;?>
        </span></td>
        <td><?=number_format($salary_total_earnings=($data->partial_salary+$data->attendance_bonus+$data->over_time_amount+$data->other_benefits+$data->festival_bonus+$data->benefits)-$data->absent_deduction,0);
		$tot_total_earnings+=($data->partial_salary+$data->attendance_bonus+$data->over_time_amount+$data->other_benefits+$data->festival_bonus+$data->benefits)-$data->absent_deduction;?></td>
        <td style="text-align:right"><?=number_format($data->advance_install,0); $tot_advance_install+=$data->advance_install;?></td>
        <td style="text-align:right"><?=number_format($data->mess_dormitory,0); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
        <td style="text-align:right"><?=number_format($data->deduction,0); $tot_deduction+=$data->deduction;?></td>
        <td style="text-align:right"><?=number_format($data->pf,0); $tot_pf+=$data->pf;?></td>
        <td style="text-align:right"><?=number_format($salary_total_deduction=($data->advance_install+$data->mess_dormitory+$data->other_deduction+$data->pf+$data->stamp_charge+$data->partial_salary_adjustmentt+$data->deduction),0);
		$tot_total_deduction+=($data->advance_install+$data->mess_dormitory+$data->other_deduction+$data->pf+$data->stamp_charge+$data->partial_salary_adjustment+$data->deduction);?></td>
        <td><?=number_format($salary_total_payable=($salary_total_earnings-$salary_total_deduction),0); $tot_total_payable+=($salary_total_earnings-$salary_total_deduction);?></td>
        <td>&nbsp;</td>
      </tr>
      <?



}
?>
      <tr height="30">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6"><strong>TOTAL</strong></td>
        <td><span class="style1">
          <?=number_format($tot_gross_salary,0); $grand_tot_gross_salary+=$tot_gross_salary;?>
          </span></td>
        <td><span class="style2">
          <?=number_format($tot_basic_salary,0); $grand_tot_basic_salary +=$tot_basic_salary;?>
          </span></td>
        <td><span class="style3">
          <?=number_format($tot_house_rent,0); $grand_tot_house_rent+=$tot_house_rent;?>
          </span></td>
        <td><span class="style4">
          <?=number_format($tot_medical_allowance,0); $grand_tot_medical_allowance+=$tot_medical_allowance;?>
          </span></td>
        <td  style="padding:0;"><span class="style5">
          <?=number_format($tot_conveyance_allowance,0); $grand_tot_conveyance_allowance+=$tot_conveyance_allowance;?>
          </span></td>
        <td><span class="style6">
          <?=number_format($tot_attendance_bonus,0); $grand_tot_attendance_bonus+=$tot_attendance_bonus;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_over_time_amount,0); $grand_tot_over_time_amount+=$tot_over_time_amount;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_benefits,0); $grand_tot_benefits+=$tot_benefits;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_festival_bonus,0); $grand_tot_festival_bonus+=$tot_festival_bonus;?>
          </span></td>
        <td>&nbsp;</td>
        <td><span class="style16">
          <?=number_format($tot_absent_deduction,0); $grand_tot_absent_deduction+=$tot_absent_deduction;?>
        </span></td>
        <td><span class="style16">
          <?=number_format($tot_total_earnings,0); $grand_tot_total_earnings+=$tot_total_earnings;?>
          </span></td>
        <td style="text-align:right"><span class="style8">
          <?=number_format($tot_advance_install,0); $grand_tot_advance_install+=$tot_advance_install;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_mess_dormitory,0); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
          </span></td>
        <td style="text-align:right"><span class="style9">
          <?=number_format($tot_deduction,0); $grand_tot_deduction+=$tot_deduction;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_pf,0); $grand_tot_pf+=$tot_pf;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_total_deduction,0); $grand_tot_total_deduction+=$tot_total_deduction;?>
          </span></td>
        <td><span class="style14">
          <?=number_format($tot_total_payable,0); $grand_tot_total_payable+=$tot_total_payable;?>
          </span></td>
        <td>&nbsp;</td>
      </tr>
      <?

$tot_gross_salary = 0;
$tot_basic_salary=0;
$tot_house_rent=0;
$tot_medical_allowance=0;
$tot_conveyance_allowance=0;
$tot_attendance_bonus=0;
$tot_absent_deduction=0;
$tot_advance_install=0;
$tot_mess_dormitory=0;
$tot_deduction=0;
$tot_over_time_amount=0;
$tot_benefits=0;
$tot_festival_bonus=0;
$tot_total_earnings=0;
$tot_total_deduction=0;
$tot_pf=0;
$tot_stamp_charge=0;
$tot_partial_salary_adjustment=0;
$tot_total_payable=0;


  }?>
      <tr height="30">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6"><strong>GRAND TOTAL</strong></td>
        <td><span class="style1">
          <?=number_format($grand_tot_gross_salary,0);?>
          </span></td>
        <td><span class="style2">
          <?=number_format($grand_tot_basic_salary,0);?>
          </span></td>
        <td><span class="style3">
          <?=number_format($grand_tot_house_rent,0);?>
          </span></td>
        <td><span class="style4">
          <?=number_format($grand_tot_medical_allowance,0);?>
          </span></td>
        <td  style="padding:0;"><span class="style5">
          <?=number_format($grand_tot_conveyance_allowance,0);?>
          </span></td>
        <td><span class="style6">
          <?=number_format($grand_tot_attendance_bonus,0);?>
          </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_over_time_amount,0);?>
          </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_benefits,0);?>
          </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_festival_bonus,0);?>
          </span></td>
        <td>&nbsp;</td>
        <td><span class="style16">
          <?=number_format($grand_tot_absent_deduction,0);?>
        </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_total_earnings,0);?>
          </span></td>
        <td style="text-align:right"><span class="style8">
          <?=number_format($grand_tot_advance_install,0);?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($grand_tot_mess_dormitory,0);?>
          </span></td>
        <td style="text-align:right"><span class="style9">
          <?=number_format($grand_tot_deduction,0);?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($grand_tot_pf,0);?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($grand_tot_total_deduction,0);?>
          </span></td>
        <td><span class="style14">
          <?=number_format($grand_tot_total_payable,0);?>
          </span></td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="12" style="border-right-color:#FFFFFF;" align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Prepared By</td>
        <td colspan="13" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Checked By</td>
        <td colspan="3" style="border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Authorised By </td>
      </tr>
    </tfoot>
  </table>
  <?
}














elseif($_POST['report']==21220191122)
{





 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	 if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

	if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";





if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
  <!--<table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="24"><?=$str?></td>
    </tr>
  </table>-->
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>

	<tr>
		<td colspan="28" style="border:0px;" align="center">
		<? if($_POST['PBI_ORG']!='') { ?>
		<h2 style="font-size:24px;"> <?= find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']) ?></h2>

		<? }?>


		<h2 style="text-align: center;">Monthly Salary Sheet Summary</h2>

		<h2>Report of Month: <?= date('F-Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year']))?></h2>



		<?php /*?>	<? if($_POST['payroll_type']!='') { ?>
		<h2 style="font-size:20px;"> Payroll Type: <?= find_a_field('salary_payroll_type','payroll_type','ID='.$_POST['payroll_type']) ?></h2>
		<? }?>
		<?php */?>


		<?php /*?><? if($_POST['department']!='') { ?>
		<h2> <?= find_a_field('department','DEPT_DESC','DEPT_ID='.$_POST['department']) ?></h2>
		<? }?><?php */?>		</td>
	  </tr>

      <tr>
        <th width="4%" rowspan="2">SL </th>
        <th width="3%" rowspan="2">PBI ID </th>
        <th width="3%" rowspan="2">CODE</th>
        <th width="3%" rowspan="2">Name</th>
        <th width="3%" rowspan="2">Joining</th>
        <th colspan="3">Month Day</th>
        <th colspan="5" align="center" bgcolor="#99CCCC"><div align="center">Salary Structure </div></th>
        <th colspan="4" bgcolor="#99CCCC"><div align="center">Earnings</div></th>
        <th colspan="2" bgcolor="#99CCCC"><div align="center">Absence</div></th>
        <th width="6%" rowspan="2" bgcolor="#99CCCC">Total<br /> Earnings </th>
        <th colspan="6" bgcolor="#538ED5"><div align="center">Deduction</div></th>
        <th width="4%" rowspan="2">Payable Amount </th>
        <th width="14%" rowspan="2" >Signature<span style="color:#FFFFFF">Signature</span></th>
      </tr>
      <tr>
        <th width="2%">Pre</th>
        <th width="2%">OT</th>
        <th width="4%">Tot</th>
        <th width="3%" bgcolor="#99CCCC">Gross</th>
        <th width="3%" bgcolor="#99CCCC">Basic</th>
        <th width="4%" bgcolor="#99CCCC">H.Rent</th>
        <th width="4%" bgcolor="#99CCCC">Medical</th>
        <th width="4%" bgcolor="#99CCCC">Conve.</th>
        <th width="3%" bgcolor="#99CCCC">Att Bonus </th>
        <th width="3%" bgcolor="#99CCCC">OT AMT</th>
        <th width="6%" bgcolor="#99CCCC">Other Allow. </th>
        <th width="6%" bgcolor="#99CCCC">Bonus</th>
        <th width="6%" bgcolor="#99CCCC">AB</th>
        <th width="6%" bgcolor="#99CCCC">AB Amt </th>
        <th width="4%" bgcolor="#538ED5">Advance</th>
        <th width="3%" bgcolor="#538ED5">Mess &amp; Dorm </th>
        <th width="2%" bgcolor="#538ED5">Other</th>
        <th width="1%" bgcolor="#538ED5">PF</th>
        <th width="1%" bgcolor="#538ED5">Partial Salary Adjust</th>
        <th width="1%" bgcolor="#538ED5">Total Deduction </th>
      </tr>
    </thead>
    <tbody>
      <?

 }


?>

      <?




if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

   $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and
s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
  $sqld = 'select * from salary_attendence where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
      <tr style="font-size:14px; " height="80" >
        <td><?=$s?></td>
        <td><?=$datas[0]?></td>
        <td><?=$datas[1]?></td>
        <td><?=$datas[2]?></td>
        <td><?php echo date('d-m-Y',strtotime($datas[5]));?></td>
        <td><?= $data->pay?></td>
        <td><?= $data->potd?></td>
        <td><?= $tot_day = ($data->pay+$data->potd)?></td>
        <td><?=number_format($data->gross_salary,0); $tot_gross_salary+=$data->gross_salary; ?></td>
        <td><?=number_format($data->basic_salary,0); $tot_basic_salary+=$data->basic_salary; ?></td>
        <td><?=number_format($data->house_rent,0); $tot_house_rent+=$data->house_rent; ?></td>
        <td><?=number_format($data->medical_allowance,0); $tot_medical_allowance+=$data->medical_allowance; ?></td>
        <td style="padding:0;"><?=number_format($data->conveyance_allowance,0); $tot_conveyance_allowance+=$data->conveyance_allowance; ?></td>
        <td><?=number_format($data->attendance_bonus,0); $tot_attendance_bonus+=$data->attendance_bonus;?></td>
        <td><span style="text-align:right">
          <?=number_format($data->over_time_amount,0); $tot_over_time_amount+=$data->over_time_amount;?>
          </span></td>
        <td><?=number_format($data->benefits,0); $tot_benefits+=$data->benefits;?></td>
        <td><?=number_format($data->festival_bonus,0); $tot_festival_bonus+=$data->festival_bonus;?></td>
        <td><span style="text-align:right">
          <?= $tot_ab = ($data->ab+$data->lt+$data->lwp);?>
        </span></td>
        <td><span style="text-align:right">
          <?=number_format($data->absent_deduction,0); $tot_absent_deduction+=$data->absent_deduction;?>
        </span></td>
        <td><?=number_format($salary_total_earnings=($data->total_salary+$data->attendance_bonus+$data->over_time_amount+$data->other_benefits+$data->festival_bonus+$data->benefits)-$data->absent_deduction,0);
		$tot_total_earnings+=($data->total_salary+$data->attendance_bonus+$data->over_time_amount+$data->other_benefits+$data->festival_bonus+$data->benefits)-$data->absent_deduction;?></td>
        <td style="text-align:right"><?=number_format($data->advance_install,0); $tot_advance_install+=$data->advance_install;?></td>
        <td style="text-align:right"><?=number_format($data->mess_dormitory,0); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
        <td style="text-align:right"><?=number_format($data->deduction,0); $tot_deduction+=$data->deduction;?></td>
        <td style="text-align:right"><?=number_format($data->pf,0); $tot_pf+=$data->pf;?></td>
        <td style="text-align:right"><?=number_format($data->partial_salary_adjustment,0); $tot_partial_salary_adjustment+=$data->partial_salary_adjustment;?></td>
        <td style="text-align:right"><?=number_format($salary_total_deduction=($data->advance_install+$data->mess_dormitory+$data->other_deduction+$data->pf+$data->stamp_charge+$data->partial_salary_adjustment+$data->deduction),0);
		$tot_total_deduction+=($data->advance_install+$data->mess_dormitory+$data->other_deduction+$data->pf+$data->stamp_charge+$data->partial_salary_adjustment+$data->deduction);?></td>
        <td><?=number_format($salary_total_payable=($salary_total_earnings-$salary_total_deduction),0); $tot_total_payable+=($salary_total_earnings-$salary_total_deduction);?></td>
        <td>&nbsp;</td>
      </tr>
      <?



}
?>
      <tr height="30">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5"><strong>TOTAL</strong></td>
        <td><span class="style1">
          <?=number_format($tot_gross_salary,0); $grand_tot_gross_salary+=$tot_gross_salary;?>
          </span></td>
        <td><span class="style2">
          <?=number_format($tot_basic_salary,0); $grand_tot_basic_salary +=$tot_basic_salary;?>
          </span></td>
        <td><span class="style3">
          <?=number_format($tot_house_rent,0); $grand_tot_house_rent+=$tot_house_rent;?>
          </span></td>
        <td><span class="style4">
          <?=number_format($tot_medical_allowance,0); $grand_tot_medical_allowance+=$tot_medical_allowance;?>
          </span></td>
        <td  style="padding:0;"><span class="style5">
          <?=number_format($tot_conveyance_allowance,0); $grand_tot_conveyance_allowance+=$tot_conveyance_allowance;?>
          </span></td>
        <td><span class="style6">
          <?=number_format($tot_attendance_bonus,0); $grand_tot_attendance_bonus+=$tot_attendance_bonus;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_over_time_amount,0); $grand_tot_over_time_amount+=$tot_over_time_amount;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_benefits,0); $grand_tot_benefits+=$tot_benefits;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_festival_bonus,0); $grand_tot_festival_bonus+=$tot_festival_bonus;?>
          </span></td>
        <td>&nbsp;</td>
        <td><span class="style16">
          <?=number_format($tot_absent_deduction,0); $grand_tot_absent_deduction+=$tot_absent_deduction;?>
        </span></td>
        <td><span class="style16">
          <?=number_format($tot_total_earnings,0); $grand_tot_total_earnings+=$tot_total_earnings;?>
          </span></td>
        <td style="text-align:right"><span class="style8">
          <?=number_format($tot_advance_install,0); $grand_tot_advance_install+=$tot_advance_install;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_mess_dormitory,0); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
          </span></td>
        <td style="text-align:right"><span class="style9">
          <?=number_format($tot_deduction,0); $grand_tot_deduction+=$tot_deduction;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_pf,0); $grand_tot_pf+=$tot_pf;?>
          </span></td>
        <td style="text-align:right"><span class="style25">
          <?=number_format($tot_partial_salary_adjustment,0); $grand_tot_tot_partial_salary_adjustment+=$tot_partial_salary_adjustment;?>
        </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_total_deduction,0); $grand_tot_total_deduction+=$tot_total_deduction;?>
          </span></td>
        <td><span class="style14">
          <?=number_format($tot_total_payable,0); $grand_tot_total_payable+=$tot_total_payable;?>
          </span></td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="12" style="border-right-color:#FFFFFF;" align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Prepared By</td>
        <td colspan="14" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Checked By</td>
        <td colspan="3" style="border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Authorised By </td>
      </tr>
    </tfoot>
  </table>
  <?
}









elseif($_POST['report']==210713002)
{





 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	 if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

	if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";





if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
  <!--<table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="24"><?=$str?></td>
    </tr>
  </table>-->
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>

	<tr>
		<td colspan="28" style="border:0px;" align="center">
		<? if($_POST['PBI_ORG']!='') { ?>
		<h2 style="font-size:24px;"> <?= find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']) ?></h2>

		<? }?>


		<h2 style="text-align: center;">Partial Salary Report</h2>

		<h2>Report of Month: <?= date('F-Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year']))?></h2>



		<?php /*?>	<? if($_POST['payroll_type']!='') { ?>
		<h2 style="font-size:20px;"> Payroll Type: <?= find_a_field('salary_payroll_type','payroll_type','ID='.$_POST['payroll_type']) ?></h2>
		<? }?>
		<?php */?>


		<?php /*?><? if($_POST['department']!='') { ?>
		<h2> <?= find_a_field('department','DEPT_DESC','DEPT_ID='.$_POST['department']) ?></h2>
		<? }?><?php */?>		</td>
	  </tr>

      <tr>
        <th width="4%" rowspan="2">SL </th>
        <th width="3%" rowspan="2">CODE</th>
        <th width="3%" rowspan="2">Name</th>
        <th width="3%" rowspan="2">Joining</th>
        <th colspan="4">Month Day</th>
        <th colspan="5" align="center" bgcolor="#99CCCC"><div align="center">Salary Structure </div></th>
        <th colspan="4" bgcolor="#99CCCC"><div align="center">Earnings</div></th>
        <th colspan="2" bgcolor="#99CCCC"><div align="center">Absence</div></th>
        <th width="6%" rowspan="2" bgcolor="#99CCCC">Total<br /> Earnings </th>
        <th colspan="6" bgcolor="#538ED5"><div align="center">Deduction</div></th>
        <th width="4%" rowspan="2">Payable Amount </th>
        <th width="14%" rowspan="2" >Signature<span style="color:#FFFFFF">Signature</span></th>
      </tr>
      <tr>
        <th width="2%">Pre</th>
        <th width="2%">OT</th>
        <th width="2%">AB</th>
        <th width="4%">PAY</th>
        <th width="3%" bgcolor="#99CCCC">Gross</th>
        <th width="3%" bgcolor="#99CCCC">Basic</th>
        <th width="4%" bgcolor="#99CCCC">H.Rent</th>
        <th width="4%" bgcolor="#99CCCC">Medical</th>
        <th width="4%" bgcolor="#99CCCC">Conve.</th>
        <th width="3%" bgcolor="#99CCCC">Att Bonus </th>
        <th width="3%" bgcolor="#99CCCC">OT AMT</th>
        <th width="6%" bgcolor="#99CCCC">Other Allow. </th>
        <th width="6%" bgcolor="#99CCCC">Bonus</th>
        <th width="6%" bgcolor="#99CCCC">AB</th>
        <th width="6%" bgcolor="#99CCCC">AB Amt </th>
        <th width="4%" bgcolor="#538ED5">Advance</th>
        <th width="3%" bgcolor="#538ED5">Mess &amp; Dorm </th>
        <th width="2%" bgcolor="#538ED5">Other</th>
        <th width="1%" bgcolor="#538ED5">PF</th>
        <th width="1%" bgcolor="#538ED5">Partial Salary Adjust</th>
        <th width="1%" bgcolor="#538ED5">Total Deduction </th>
      </tr>
    </thead>
    <tbody>
      <?

 }


?>

      <?




if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

   $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence_partial s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and
s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
  $sqld = 'select * from salary_attendence_partial where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
      <tr style="font-size:14px; " height="80" >
        <td><?=$s?></td>
        <td><?=$datas[1]?></td>
        <td><?=$datas[2]?></td>
        <td><?php echo date('d-m-Y',strtotime($datas[5]));?></td>
        <td><?= $data->partial_day?></td>
        <td><?= $data->ot_day?></td>
        <td><?= $data->ab_day?></td>
        <td><?= $data->pay_day?></td>
        <td><?=number_format($data->gross_salary,0); $tot_gross_salary+=$data->gross_salary; ?></td>
        <td><?=number_format($data->basic_salary,0); $tot_basic_salary+=$data->basic_salary; ?></td>
        <td><?=number_format($data->house_rent,0); $tot_house_rent+=$data->house_rent; ?></td>
        <td><?=number_format($data->medical_allowance,0); $tot_medical_allowance+=$data->medical_allowance; ?></td>
        <td style="padding:0;"><?=number_format($data->conveyance_allowance,0); $tot_conveyance_allowance+=$data->conveyance_allowance; ?></td>
        <td><?=number_format($data->attendance_bonus,0); $tot_attendance_bonus+=$data->attendance_bonus;?></td>
        <td><span style="text-align:right">
          <?=number_format($data->over_time_amount,0); $tot_over_time_amount+=$data->over_time_amount;?>
          </span></td>
        <td><?=number_format($data->benefits,0); $tot_benefits+=$data->benefits;?></td>
        <td><?=number_format($data->festival_bonus,0); $tot_festival_bonus+=$data->festival_bonus;?></td>
        <td><span style="text-align:right">
          <?= $tot_ab = ($data->ab+$data->lt+$data->lwp);?>
        </span></td>
        <td><span style="text-align:right">
          <?=number_format($data->absent_deduction,0); $tot_absent_deduction+=$data->absent_deduction;?>
        </span></td>
        <td><?=number_format($salary_total_earnings=($data->partial_salary+$data->attendance_bonus+$data->over_time_amount+$data->other_benefits+$data->festival_bonus+$data->benefits)-$data->absent_deduction,0);
		$tot_total_earnings+=($data->partial_salary+$data->attendance_bonus+$data->over_time_amount+$data->other_benefits+$data->festival_bonus+$data->benefits)-$data->absent_deduction;?></td>
        <td style="text-align:right"><?=number_format($data->advance_install,0); $tot_advance_install+=$data->advance_install;?></td>
        <td style="text-align:right"><?=number_format($data->mess_dormitory,0); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
        <td style="text-align:right"><?=number_format($data->deduction,0); $tot_deduction+=$data->deduction;?></td>
        <td style="text-align:right"><?=number_format($data->pf,0); $tot_pf+=$data->pf;?></td>
        <td style="text-align:right"><?=number_format($data->partial_salary_adjustment,0); $tot_partial_salary_adjustment+=$data->partial_salary_adjustment;?></td>
        <td style="text-align:right"><?=number_format($salary_total_deduction=($data->advance_install+$data->mess_dormitory+$data->other_deduction+$data->pf+$data->stamp_charge+$data->partial_salary_adjustment+$data->deduction),0);
		$tot_total_deduction+=($data->advance_install+$data->mess_dormitory+$data->other_deduction+$data->pf+$data->stamp_charge+$data->partial_salary_adjustment+$data->deduction);?></td>
        <td><?=number_format($salary_total_payable=($salary_total_earnings-$salary_total_deduction),0); $tot_total_payable+=($salary_total_earnings-$salary_total_deduction);?></td>
        <td>&nbsp;</td>
      </tr>
      <?



}
?>
      <tr height="30">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6"><strong>TOTAL</strong></td>
        <td><span class="style1">
          <?=number_format($tot_gross_salary,0); $grand_tot_gross_salary+=$tot_gross_salary;?>
          </span></td>
        <td><span class="style2">
          <?=number_format($tot_basic_salary,0); $grand_tot_basic_salary +=$tot_basic_salary;?>
          </span></td>
        <td><span class="style3">
          <?=number_format($tot_house_rent,0); $grand_tot_house_rent+=$tot_house_rent;?>
          </span></td>
        <td><span class="style4">
          <?=number_format($tot_medical_allowance,0); $grand_tot_medical_allowance+=$tot_medical_allowance;?>
          </span></td>
        <td  style="padding:0;"><span class="style5">
          <?=number_format($tot_conveyance_allowance,0); $grand_tot_conveyance_allowance+=$tot_conveyance_allowance;?>
          </span></td>
        <td><span class="style6">
          <?=number_format($tot_attendance_bonus,0); $grand_tot_attendance_bonus+=$tot_attendance_bonus;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_over_time_amount,0); $grand_tot_over_time_amount+=$tot_over_time_amount;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_benefits,0); $grand_tot_benefits+=$tot_benefits;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_festival_bonus,0); $grand_tot_festival_bonus+=$tot_festival_bonus;?>
          </span></td>
        <td>&nbsp;</td>
        <td><span class="style16">
          <?=number_format($tot_absent_deduction,0); $grand_tot_absent_deduction+=$tot_absent_deduction;?>
        </span></td>
        <td><span class="style16">
          <?=number_format($tot_total_earnings,0); $grand_tot_total_earnings+=$tot_total_earnings;?>
          </span></td>
        <td style="text-align:right"><span class="style8">
          <?=number_format($tot_advance_install,0); $grand_tot_advance_install+=$tot_advance_install;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_mess_dormitory,0); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
          </span></td>
        <td style="text-align:right"><span class="style9">
          <?=number_format($tot_deduction,0); $grand_tot_deduction+=$tot_deduction;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_pf,0); $grand_tot_pf+=$tot_pf;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_partial_salary_adjustment,0); $grand_tot_tot_partial_salary_adjustment+=$tot_partial_salary_adjustment;?>
        </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_total_deduction,0); $grand_tot_total_deduction+=$tot_total_deduction;?>
          </span></td>
        <td><span class="style14">
          <?=number_format($tot_total_payable,0); $grand_tot_total_payable+=$tot_total_payable;?>
          </span></td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="12" style="border-right-color:#FFFFFF;" align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Prepared By</td>
        <td colspan="14" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Checked By</td>
        <td colspan="3" style="border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Authorised By </td>
      </tr>
    </tfoot>
  </table>
  <?
}




















elseif($_POST['report']==212201912)
{


 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";





if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="24"><?=$str?></td>
    </tr>
  </table>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th width="4%" rowspan="2">SL </th>
        <th width="3%" rowspan="2">CODE</th>
        <th width="10%" rowspan="2">Name</th>
        <th width="3%" rowspan="2">Joining</th>
        <th colspan="4"><div align="center">Month Day</div></th>
        <th colspan="5" align="center" bgcolor="#99CCCC"><div align="center">Salary Structure </div></th>
        <th colspan="2" bgcolor="#99CCCC"><div align="center">Earnings</div></th>
        <th bgcolor="#99CCCC"><div align="center">Absence</div></th>
        <th width="6%" rowspan="2" bgcolor="#99CCCC"><div align="center">Total Earnings </div></th>
        <th colspan="2" bgcolor="#538ED5"><div align="center">Deduction</div></th>
        <th width="4%" rowspan="2">Payable Amount </th>
        <th width="14%" rowspan="2" >Signature<span style="color:#FFFFFF">Signature</span></th>
      </tr>
      <tr>
        <th width="2%">Partial Day</th>
        <th width="2%">OT Day </th>
        <th width="4%">AB Day</th>
        <th width="4%">Pay Day</th>
        <th width="3%" bgcolor="#99CCCC">Gross</th>
        <th width="3%" bgcolor="#99CCCC">Basic</th>
        <th width="4%" bgcolor="#99CCCC">H.Rent</th>
        <th width="4%" bgcolor="#99CCCC">Medical</th>
        <th width="4%" bgcolor="#99CCCC">Conve.</th>
        <th width="3%" bgcolor="#99CCCC">OT AMT</th>
        <th width="6%" bgcolor="#99CCCC">Other Allow. </th>
        <th width="6%" bgcolor="#99CCCC">AB Amt </th>
        <th width="3%" bgcolor="#538ED5">Mess &amp; Dorm </th>
        <th width="2%" bgcolor="#538ED5">Other</th>
      </tr>
    </thead>
    <tbody>
      <?

 }
 $omar = 0;
 $dsql="select dp.DEPT_DESC as department, s.PBI_DEPARTMENT from
personnel_basic_info a, department dp, salary_attendence_partial s where a.PBI_ID=s.PBI_ID and s.PBI_DEPARTMENT=dp.DEPT_ID and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con."  group by s.PBI_DEPARTMENT order by s.PBI_DEPARTMENT";

$dquery = db_query($dsql);
$p=0;
while($ddata=mysqli_fetch_object($dquery)){
$omar++;

?>
      <tr  <? if($omar>1) echo ' style="page-break-before:always" ';?>>
        <th align="center" colspan="21"><center>
            <?=$ddata->department?>
        </center></th>
      </tr>
      <?




if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

  $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence_partial s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and
s.PBI_DEPARTMENT='".$ddata->PBI_DEPARTMENT."' and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
  $sqld = 'select * from salary_attendence_partial where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
      <tr style="font-size:14px; " height="50" >
        <td><?=$s?></td>
        <td><?=$datas[1]?></td>
        <td><?=$datas[2]?></td>
        <td><?php echo date('d-m-Y',strtotime($datas[5]));?></td>
        <td><?= $data->partial_day?></td>
        <td><?= $data->ot_day?></td>
        <td><?= $data->ab_day?></td>
        <td><?= $data->pay_day?></td>
        <td><?=number_format($data->gross_salary,2); $tot_gross_salary+=$data->gross_salary; ?></td>
        <td><?=number_format($data->basic_salary,2); $tot_basic_salary+=$data->basic_salary; ?></td>
        <td><?=number_format($data->house_rent,2); $tot_house_rent+=$data->house_rent; ?></td>
        <td><?=number_format($data->medical_allowance,2); $tot_medical_allowance+=$data->medical_allowance; ?></td>
        <td style="padding:0;"><?=number_format($data->conveyance_allowance,2); $tot_conveyance_allowance+=$data->conveyance_allowance; ?></td>
        <td><span style="text-align:right">
          <?=number_format($data->over_time_amount,2); $tot_over_time_amount+=$data->over_time_amount;?>
          </span></td>
        <td><?=number_format($data->benefits,2); $tot_benefits+=$data->benefits;?></td>
        <td><span style="text-align:right">
          <?=number_format($data->absent_deduction,2); $tot_absent_deduction+=$data->absent_deduction;?>
        </span></td>
        <td><?=number_format(($data->total_earnings+$data->total_deduction)-$data->absent_deduction,2);
		$tot_total_earnings+=($data->total_earnings+$data->total_deduction)-$data->absent_deduction;?></td>
        <td style="text-align:right"><?=number_format($data->mess_dormitory,2); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
        <td style="text-align:right"><?=number_format($data->deduction,2); $tot_deduction+=$data->deduction;?></td>
        <td><?=number_format($data->total_payable,2); $tot_total_payable+=$data->total_payable;?></td>
        <td>&nbsp;</td>
      </tr>
      <?



}
?>
      <tr height="30">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6"><strong>TOTAL</strong></td>
        <td><span class="style1">
          <?=number_format($tot_gross_salary,2); $grand_tot_gross_salary+=$tot_gross_salary;?>
          </span></td>
        <td><span class="style2">
          <?=number_format($tot_basic_salary,2); $grand_tot_basic_salary +=$tot_basic_salary;?>
          </span></td>
        <td><span class="style3">
          <?=number_format($tot_house_rent,2); $grand_tot_house_rent+=$tot_house_rent;?>
          </span></td>
        <td><span class="style4">
          <?=number_format($tot_medical_allowance,2); $grand_tot_medical_allowance+=$tot_medical_allowance;?>
          </span></td>
        <td  style="padding:0;"><span class="style5">
          <?=number_format($tot_conveyance_allowance,2); $grand_tot_conveyance_allowance+=$tot_conveyance_allowance;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_over_time_amount,2); $grand_tot_over_time_amount+=$tot_over_time_amount;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_benefits,2); $grand_tot_benefits+=$tot_benefits;?>
          </span></td>
        <td><span class="style16">
          <?=number_format($tot_absent_deduction,2); $grand_tot_absent_deduction+=$tot_absent_deduction;?>
        </span></td>
        <td><span class="style16">
          <?=number_format($tot_total_earnings,2); $grand_tot_total_earnings+=$tot_total_earnings;?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($tot_mess_dormitory,2); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
          </span></td>
        <td style="text-align:right"><span class="style9">
          <?=number_format($tot_deduction,2); $grand_tot_deduction+=$tot_deduction;?>
          </span></td>
        <td><span class="style14">
          <?=number_format($tot_total_payable,2); $grand_tot_total_payable+=$tot_total_payable;?>
          </span></td>
        <td>&nbsp;</td>
      </tr>
      <?

$tot_gross_salary = 0;
$tot_basic_salary=0;
$tot_house_rent=0;
$tot_medical_allowance=0;
$tot_conveyance_allowance=0;
$tot_attendance_bonus=0;
$tot_absent_deduction=0;
$tot_advance_install=0;
$tot_mess_dormitory=0;
$tot_deduction=0;
$tot_over_time_amount=0;
$tot_benefits=0;
$tot_festival_bonus=0;
$tot_total_earnings=0;
$tot_total_deduction=0;
$tot_pf=0;
$tot_total_payable=0;





  }?>
      <tr height="30">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6"><strong>GRAND TOTAL</strong></td>
        <td><span class="style1">
          <?=number_format($grand_tot_gross_salary,2);?>
          </span></td>
        <td><span class="style2">
          <?=number_format($grand_tot_basic_salary,2);?>
          </span></td>
        <td><span class="style3">
          <?=number_format($grand_tot_house_rent,2);?>
          </span></td>
        <td><span class="style4">
          <?=number_format($grand_tot_medical_allowance,2);?>
          </span></td>
        <td  style="padding:0;"><span class="style5">
          <?=number_format($grand_tot_conveyance_allowance,2);?>
          </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_over_time_amount,2);?>
          </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_benefits,2);?>
          </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_absent_deduction,2);?>
        </span></td>
        <td><span class="style16">
          <?=number_format($grand_tot_total_earnings,2);?>
          </span></td>
        <td style="text-align:right"><span class="style16">
          <?=number_format($grand_tot_mess_dormitory,2);?>
          </span></td>
        <td style="text-align:right"><span class="style9">
          <?=number_format($grand_tot_deduction,2);?>
          </span></td>
        <td><span class="style14">
          <?=number_format($grand_tot_total_payable,2);?>
          </span></td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="12" style="border-right-color:#FFFFFF;" align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Prepared By</td>
        <td colspan="7" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Checked By</td>
        <td colspan="3" style="border-left-color:#FFFFFF; " align="center"><br />
          <br />
          <br />
          <br />
          <hr style="width:20%;" />
          Authorised By </td>
      </tr>
    </tfoot>
  </table>
  <?
}










elseif($_POST['report']==212201922)
{


if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="23"><?=$str?></td>
    </tr>
  </table>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr style="font-size:14px; " height="30">
        <th width="2%" bgcolor="#45777B"><span class="style24 style21">SL</span></th>
        <th width="8%" bgcolor="#45777B"><span class="style24 style21">EMP CODE</span></th>
        <th width="16%" bgcolor="#45777B"><span class="style24 style21">Employee Name</span></th>
        <th width="9%" bgcolor="#45777B"><span class="style24 style21">Joining Date </span></th>
        <th width="9%" bgcolor="#45777B"><span class="style24 style21">Service Length</span></th>
        <th width="9%" bgcolor="#45777B"><span class="style24 style21">Month Count </span></th>
        <th width="7%" bgcolor="#45777B"><span class="style24 style21">OT Days </span></th>
        <th width="6%" bgcolor="#45777B"><span class="style24 style21">Pay Days </span></th>
        <th width="12%" bgcolor="#45777B"><span class="style24 style21">Attendance Bonus Count</span></th>
        <th width="10%" align="center" bgcolor="#45777B"><span class="style24 style21">Gross Salary</span></th>
        <th width="12%" align="center" bgcolor="#45777B"><span class="style24 style21">Eid Bonus </span></th>
      </tr>
    </thead>
    <tbody>
      <? }?>


      <?

if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


	$start_date = $_POST['fdate'];
	$end_date = $_POST['tdate'];

	 $start_m = date("m",strtotime($start_date));
	 $start_y = date("Y",strtotime($start_date));

	 $end_m = date("m",strtotime($end_date));
	 $end_y = date("Y",strtotime($end_date));



	$sql = "select PBI_ID, ot, pay, attendance_bonus from salary_attendence where mon='".$mon."' and year='".$year."' ";
	$query = db_query($sql);
	while($info=mysqli_fetch_object($query)){
 	 $ot_days[$info->PBI_ID]=$info->ot;
	 $pay_days[$info->PBI_ID]=$info->ot+$info->pay;
	 $att_bonus[$info->PBI_ID]=$info->attendance_bonus;
	}




	 $sql = "select PBI_ID, EMP_CODE, count(attendance_bonus) as att_bonus_count from salary_attendence where mon BETWEEN '".$start_m."' AND '".$end_m."' AND year BETWEEN '".$start_y."' AND '".$end_y."'
	 AND attendance_bonus>0 group by PBI_ID";
	$query = db_query($sql);
	while($info=mysqli_fetch_object($query)){
 	 $att_bonus_count[$info->PBI_ID]=$info->att_bonus_count;
	}




		if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';



   $sqll="select a.PBI_ID, a.PBI_CODE, a.PBI_NAME, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE, s.gross_salary from
personnel_basic_info a, department dp, designation ds, salary_info s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID   and a.PBI_JOB_STATUS='In Service'
 ".$con.$JOB_LOCATION_CON." order by a.EMP_CODE";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_object($query)){$s++;


?>
      <tr style="font-size:14px; " height="30" >
        <td><?=$s?></td>
        <td><?=$datas->PBI_CODE?></td>
        <td><?=$datas->PBI_NAME?></td>
        <td><?= date('d-m-Y',strtotime($datas->PBI_DOJ));?></td>
        <td><?
echo $servicel=find_a_field('personnel_basic_info','CONCAT( TIMESTAMPDIFF(YEAR, PBI_DOJ, CURDATE())," Year,",TIMESTAMPDIFF(MONTH, PBI_DOJ, CURDATE()) % 12," mon")','1 and PBI_ID="'.$datas->PBI_ID.'"');
?></td>
        <td>
		<?

$to_date = date("Y-m-d");
$timeStart = strtotime($datas->PBI_DOJ);
$timeEnd = strtotime($to_date);
$numMonths = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
$numMonths += date("m",$timeEnd)-date("m",$timeStart);
echo $numMonths;
		?>		</td>
        <td><? if($ot_days[$datas->PBI_ID]>0) {?><?=$ot_days[$datas->PBI_ID]?><? }?></td>
        <td><? if($pay_days[$datas->PBI_ID]>0) {?><?=$pay_days[$datas->PBI_ID]?><? }?></td>
        <td> <?=$att_bonus_count[$datas->PBI_ID]; ?> </td>
        <td><?=number_format($datas->gross_salary,2); $tot_gross_salary+=$datas->gross_salary; ?></td>
        <td>

		<?

		if ($numMonths >=6)
			{
  			echo $eid_bonus = ($datas->gross_salary*50)/100;
			} else {
			echo $eid_bonus = $numMonths*400;
			}

		?>

		</td>
      </tr>
      <?



}
?>
      <tr style="font-size:14px; " height="30">
        <td colspan="6"><div align="right"><strong>TOTAL</strong></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><span class="style1">
          <?=number_format($tot_gross_salary,2);?>
          </span></td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <?
}










elseif($_POST['report']==220607001)
{


if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

$report='Employee Information';
?>
  <?php /*?><table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="23"><?=$str?></td>
    </tr>
  </table><?php */?>



  <table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>
				</tr>


		 <? if ($_POST['PBI_ORG']>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG'])?></strong></td>
         </tr>
		 <? }?>

	 <tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>
		</tr>


		<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>Employee Average Age:
					<?
					 $avg_sql="SELECT AVG(YEAR(NOW())-YEAR(a.PBI_DOB)) as avg_age FROM personnel_basic_info a WHERE a.PBI_DOB > '1971-01-01' ".$con." ";
					 $avg_age = find_a_field_sql($avg_sql);

					 echo $avg_age;
					?>

					 </strong></td>
		</tr>


		<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>Average Service Length:
					<?
					 $avg_sql="SELECT AVG(YEAR(NOW())-YEAR(a.PBI_DOJ)) as avg_age FROM personnel_basic_info a WHERE a.PBI_DOJ > '1971-01-01' ".$con." ";
					 $avg_age = find_a_field_sql($avg_sql);

					 echo $avg_age;
					?>

					 </strong></td>
		</tr>

			</table>

		</td>

		<td  width="25%" align="center" style="border:0px; border-color:white;">&nbsp;

		</td>
		</tr>

		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>





  </table>





  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr style="font-size:14px; " height="30">
        <th width="3%" bgcolor="#45777B"><span class="style24 style21">SL  </span></th>
        <th width="7%" bgcolor="#45777B"><span class="style24 style21">EMP CODE</span></th>
        <th width="33%" bgcolor="#45777B"><span class="style24 style21">Employee Name</span></th>
        <th width="8%" bgcolor="#45777B"><span class="style24 style21">Birth Date</span></th>
        <th width="15%" bgcolor="#45777B"><span class="style24 style21">Worker Age</span></th>
        <th width="7%" bgcolor="#45777B"><span class="style24 style21">Joining Date </span></th>
        <th width="15%" bgcolor="#45777B"><span class="style24 style21">Service Length</span></th>
        <th width="5%" bgcolor="#45777B"><span class="style24 style21">Attendance </span></th>
        <th width="7%" align="center" bgcolor="#45777B"><span class="style24 style21">Gross Salary</span></th>
      </tr>
    </thead>
    <tbody>
      <? }?>


      <?

if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


	$start_date = $_POST['fdate'];
	$end_date = $_POST['tdate'];

	 $start_m = date("m",strtotime($start_date));
	 $start_y = date("Y",strtotime($start_date));

	 $end_m = date("m",strtotime($end_date));
	 $end_y = date("Y",strtotime($end_date));



	$sql = "select PBI_ID, ot, pay, attendance_bonus from salary_attendence where mon='".$mon."' and year='".$year."' ";
	$query = db_query($sql);
	while($info=mysqli_fetch_object($query)){
 	 $ot_days[$info->PBI_ID]=$info->ot;
	 $pay_days[$info->PBI_ID]=$info->ot+$info->pay;
	 $att_bonus[$info->PBI_ID]=$info->attendance_bonus;
	}




	 $sql = "select PBI_ID, EMP_CODE, count(attendance_bonus) as att_bonus_count from salary_attendence where mon BETWEEN '".$start_m."' AND '".$end_m."' AND year BETWEEN '".$start_y."' AND '".$end_y."'
	 AND attendance_bonus>0 group by PBI_ID";
	$query = db_query($sql);
	while($info=mysqli_fetch_object($query)){
 	 $att_bonus_count[$info->PBI_ID]=$info->att_bonus_count;
	}




		if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

		if($_POST['mon']!='')
	$MON_CON.=' and sa.mon = "'.$_POST['mon'].'"';

	if($_POST['year']!='')
	$YEAR_CON.=' and sa.year = "'.$_POST['year'].'"';



   $sqll="select a.PBI_ID, a.PBI_CODE, a.PBI_NAME, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.PBI_DOB, a.EMP_CODE, sa.gross_salary from
personnel_basic_info a, salary_attendence sa, department dp, designation ds where a.PBI_ID=sa.PBI_ID  and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID
 ".$con.$JOB_LOCATION_CON.$MON_CON.$YEAR_CON." order by a.EMP_CODE";

$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_object($query)){$s++;


?>
      <tr style="font-size:14px; " height="30" >
        <td><?=$s?></td>
        <td><?=$datas->PBI_CODE?></td>
        <td><?=$datas->PBI_NAME?></td>
        <td><?= date('d-M-Y',strtotime($datas->PBI_DOB));?></td>
        <td><?
echo $servicel=find_a_field('personnel_basic_info','CONCAT( TIMESTAMPDIFF(YEAR, PBI_DOB, CURDATE())," Year,",TIMESTAMPDIFF(MONTH, PBI_DOB, CURDATE()) % 12," mon")','1 and PBI_ID="'.$datas->PBI_ID.'"');
?></td>
        <td><?= date('d-M-Y',strtotime($datas->PBI_DOJ));?></td>
        <td><?
echo $servicel=find_a_field('personnel_basic_info','CONCAT( TIMESTAMPDIFF(YEAR, PBI_DOJ, CURDATE())," Year,",TIMESTAMPDIFF(MONTH, PBI_DOJ, CURDATE()) % 12," mon")','1 and PBI_ID="'.$datas->PBI_ID.'"');
?></td>
        <td><? if($pay_days[$datas->PBI_ID]>0) {?><?=$pay_days[$datas->PBI_ID]?><? }?></td>
        <td><?=number_format($datas->gross_salary,2); $tot_gross_salary+=$datas->gross_salary; ?></td>
      </tr>
      <? }?>
      <tr style="font-size:14px; " height="30">
        <td colspan="7"><div align="right"><strong>TOTAL</strong></div></td>
        <td>&nbsp;</td>
        <td><span class="style1">
          <?=number_format($tot_gross_salary,2);?>
          </span></td>
      </tr>
    </tbody>
  </table>
  <?

  }
}










elseif($_POST['report']==212201933)
{





?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="23"><?=$str?></td>
    </tr>
  </table>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr style="font-size:14px; " height="30">
        <th width="3%" bgcolor="#45777B"><span class="style24 style21">SL </span></th>
        <th width="12%" bgcolor="#45777B"><span class="style24 style21">EMP CODE</span></th>
        <th width="23%" bgcolor="#45777B"><span class="style24 style21">Employee Name</span></th>
        <th width="13%" bgcolor="#45777B"><span class="style24 style21">Departemnt</span></th>
        <th width="13%" bgcolor="#45777B"><span class="style24 style21">Joining Date </span></th>
        <th width="11%" bgcolor="#45777B"><span class="style24 style21">Company</span></th>
        <th width="11%" bgcolor="#45777B"><span class="style24 style21">Mobilie No </span></th>
      </tr>
    </thead>
    <tbody>



      <?


if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';



if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';


   $sqll="select a.PBI_ID, a.PBI_CODE, a.PBI_NAME, a.PBI_MOBILE, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE, u.short_name from
personnel_basic_info a, department dp, designation ds, user_group u where a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID   and a.PBI_JOB_STATUS='In Service'
 ".$con.$JOB_LOCATION_CON.$shift_con." order by a.EMP_CODE";

$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_object($query)){$s++;


?>
      <tr style="font-size:14px; " height="30" >
        <td><?=$s?></td>
        <td><?=$datas->PBI_CODE?></td>
        <td><?=$datas->PBI_NAME?></td>
        <td><?=$datas->department?></td>
        <td><?= date('d-m-Y',strtotime($datas->PBI_DOJ));?></td>
        <td><?=$datas->short_name?></td>
        <td><?=$datas->PBI_MOBILE?></td>
      </tr>
      <?



}
?>

    </tbody>
  </table>
  <?
}




elseif($_POST['report']==21220193301)
{





?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="23"><?=$str?></td>
    </tr>
  </table>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr style="font-size:14px; " height="30">
        <th width="3%" bgcolor="#45777B"><span class="style24 style21">SL </span></th>
        <th width="12%" bgcolor="#45777B"><span class="style24 style21">EMP CODE</span></th>
        <th width="23%" bgcolor="#45777B"><span class="style24 style21">Employee Name</span></th>
        <th width="13%" bgcolor="#45777B"><span class="style24 style21">Designation</span></th>
        <th width="13%" bgcolor="#45777B"><span class="style24 style21">Departemnt</span></th>
        <th width="13%" bgcolor="#45777B"><span class="style24 style21">Salary</span></th>
        <th width="13%" bgcolor="#45777B"><span class="style24 style21">Joining Date </span></th>
        <th width="11%" bgcolor="#45777B"><span class="style24 style21"> Date of Birth </span></th>
        <th width="11%" bgcolor="#45777B"><span class="style24 style21">Contact No </span></th>
        <th width="11%" bgcolor="#45777B"><span class="style24 style21">Father Name </span></th>
        <th width="11%" bgcolor="#45777B"><span class="style24 style21">Mother Name </span></th>
        <th width="11%" bgcolor="#45777B"><span class="style24 style21">Address</span></th>
        <th width="11%" bgcolor="#45777B"><span class="style24 style21">Blood</span></th>
      </tr>
    </thead>
    <tbody>



      <?




if($_POST['jfdate']!=''&&$_POST['jtdate']!='')

    $date_con .= ' and a.PBI_DOJ between "'.$_POST['jfdate'].'" and "'.$_POST['jtdate'].'"';


	if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

	//if($_POST['job_status']!='')
	//$JOB_STATUS_CON.=' and a.PBI_JOB_STATUS = "'.$_POST['job_status'].'"';



if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';


    $sqll="select a.PBI_ID, a.PBI_CODE, a.PBI_NAME, a.PBI_MOBILE, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE, u.short_name ,
  s.gross_salary, a.PBI_DOB,a.PBI_FATHER_NAME, a.PBI_MOTHER_NAME, a.ESSENTIAL_BLOOD_GROUP, a.PBI_PARM_STREET_ADD, a.PBI_PARM_CITY_ADD, a.PBI_PARM_THANA_ADD,a.PBI_PARM_DIST_ADD from
personnel_basic_info a, department dp, designation ds, salary_info s, user_group u where a.PBI_ID=s.PBI_ID and a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID  ".$con.$date_con.$JOB_LOCATION_CON.$JOB_STATUS_CON.$shift_con." order by a.EMP_CODE";

$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_object($query)){$s++;


?>
      <tr style="font-size:14px; " height="30" >
        <td><?=$s?></td>
        <td><?=$datas->PBI_CODE?></td>
        <td><?=$datas->PBI_NAME?></td>
        <td><?=$datas->designation?></td>
        <td><?=$datas->department?></td>
        <td><?=number_format($datas->gross_salary,2);?></td>
        <td><? if ($datas->PBI_DOJ!='0000-00-00') {?><?= date('d-m-Y',strtotime($datas->PBI_DOJ));?> <? }?></td>
        <td><? if ($datas->PBI_DOB!='0000-00-00') {?> <?= date('d-m-Y',strtotime($datas->PBI_DOB));?> <? }?></td>
        <td><?=$datas->PBI_MOBILE?></td>
        <td><?=$datas->PBI_FATHER_NAME?></td>
        <td><?=$datas->PBI_MOTHER_NAME?></td>
        <td><?=$datas->PBI_PARM_STREET_ADD?> <?=$datas->PBI_PARM_CITY_ADD?>, Thana: <?=find_a_field('location','l_name','l_id="'.$datas->PBI_PARM_THANA_ADD.'" ');?>, District: <?=$datas->PBI_PARM_DIST_ADD?></td>
        <td><?=$datas->ESSENTIAL_BLOOD_GROUP?></td>
      </tr>
      <?



}
?>
    </tbody>
  </table>
  <?
}







elseif($_POST['report']==220126001)
{





?>
  <table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>
				</tr>

		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>





		 <tr>
          <td colspan="15" align="center" style="font-size:16px;border:0px; border-color:white;">For the Year of: <?php echo $_POST['year'];?></td>
         </tr>
			</table>

		</td>

		<td  width="25%" align="center" style="border:0px; border-color:white;">&nbsp;

		</td>
		</tr>

		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>





  </table>


  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr style="font-size:14px; " height="30">
        <th width="2%" bgcolor="#45777B"><span class="style24 style21">SL </span></th>
        <th width="6%" bgcolor="#45777B"><span class="style24 style21">EMP CODE</span></th>
        <th width="17%" bgcolor="#45777B"><span class="style24 style21">Employee Name</span></th>
        <th width="13%" bgcolor="#45777B"><span class="style24 style21">Designation</span></th>
        <th width="12%" bgcolor="#45777B"><span class="style24 style21">Departemnt</span></th>
        <th width="15%" bgcolor="#45777B"><span class="style24 style21">Joining Date </span></th>
        <th width="17%" bgcolor="#45777B"><span class="style24 style21">Leave In </span></th>
        <th width="18%" bgcolor="#45777B"><span class="style24 style21">Leave Out </span></th>
      </tr>
    </thead>
    <tbody>



      <?




if($_POST['jfdate']!=''&&$_POST['jtdate']!='')

    $date_con .= ' and a.PBI_DOJ between "'.$_POST['jfdate'].'" and "'.$_POST['jtdate'].'"';


	if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

	if($_POST['year']!='')
	$year_con.=' and s.year = "'.$_POST['year'].'"';

	//if($_POST['job_status']!='')
	//$JOB_STATUS_CON.=' and a.PBI_JOB_STATUS = "'.$_POST['job_status'].'"';


	  $sql = "select s.PBI_ID,  sum(s.leave_in) as leave_in, sum(s.leave_out) as leave_out, s.year   from hrm_leave_journal	s where 1 ".$year_con."  group by s.PBI_ID ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $leave_in[$info->PBI_ID]=$info->leave_in;
		 $leave_out[$info->PBI_ID]=$info->leave_out;

		}




    $sqll="select a.PBI_ID, a.PBI_CODE, a.PBI_NAME, a.PBI_MOBILE, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE, u.short_name ,
   a.PBI_DOB,a.PBI_FATHER_NAME, a.PBI_MOTHER_NAME, a.ESSENTIAL_BLOOD_GROUP, a.PBI_PARM_STREET_ADD, a.PBI_PARM_CITY_ADD, a.PBI_PARM_THANA_ADD,a.PBI_PARM_DIST_ADD from
personnel_basic_info a, department dp, designation ds, hrm_leave_journal s, user_group u where a.PBI_ID=s.PBI_ID and a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID  ".$con.$date_con.$JOB_LOCATION_CON.$JOB_STATUS_CON.$year_con." group by s.PBI_ID order by dp.DEPT_SHORT_NAME, a.EMP_CODE";

$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_object($query)){$s++;


?>
      <tr style="font-size:14px; " height="30" >
        <td><?=$s?></td>
        <td><?=$datas->PBI_CODE?></td>
        <td><a style="color:#000000; text-decoration: none; " href="master_report.php?year=<?=$_POST['year'];?>&PBI_ID=<?=$datas->PBI_ID;?>&report=220126002&submit=1" target="_blank" >
		<?=$datas->PBI_NAME?></a></td>
        <td><?=$datas->designation?></td>
        <td><?=$datas->department?></td>
        <td><? if ($datas->PBI_DOJ!='0000-00-00') {?><?= date('d-m-Y',strtotime($datas->PBI_DOJ));?> <? }?></td>
        <td><?=$leave_in[$datas->PBI_ID];?></td>
        <td><?=$leave_out[$datas->PBI_ID];?></td>
      </tr>
      <?



}
?>
    </tbody>
  </table>
  <?
}







elseif($_REQUEST['report']==220126002)
{


		$report="Employee Leave Information";
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}

		?>


		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >

			<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>
			  </tr>

				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>
				</tr>


		 <tr>
          <td colspan="15" align="center" style="font-size:16px;border:0px; border-color:white;">For the Year of: <?php echo $_REQUEST['year'];?></td>
         </tr>


			</table>

		</td>

		<td  width="25%" align="center" style="border:0px; border-color:white;">&nbsp;</td>
		</tr>

		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>





       </table>


		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">

		<thead>



		<tr height="30">
		<th width="4%" bgcolor="#FFFACD">SL</th>
		<th width="14%" bgcolor="#FFFACD">EMP CODE</th>
		<th width="33%" bgcolor="#FFFACD">Employee Name </th>
		<th width="12%" bgcolor="#d6eaf8" style="text-align:center">Date</th>
		<th width="13%" bgcolor="#d6eaf8" style="text-align:center">Leave Type </th>
		<th width="12%" bgcolor="#99FFFF" style="text-align:center">Leave In</th>
		<th width="12%" bgcolor="#ebdef0" style="text-align:center">Leave Out </th>
		</tr>
		</thead><tbody>
		<? $sl=1;




		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}



		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}





		?>



		<?


 		 $sql="select l.*, a.PBI_CODE, a.PBI_NAME from hrm_leave_journal l, personnel_basic_info a where l.PBI_ID=a.PBI_ID and l.PBI_ID='".$_REQUEST['PBI_ID']."' and l.year='".$_REQUEST['year']."' order by l.jv_date, l.id";

		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{



		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>

		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->PBI_CODE?></td>
		<td><?=$row->PBI_NAME?></td>
		<td><?=date("d-M-Y",strtotime($row->jv_date))?></td>
		<td><?=$row->tr_from?></td>
		<td><? if($row->leave_in>0) {?><?=$row->leave_in;?> <? }?><? $tot_leave_in +=$row->leave_in;?></td>
		<td><? if($row->leave_out>0) {?><?=$row->leave_out; ?> <? }?><? $tot_leave_out +=$row->leave_out;?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong> TOTAL:</strong></div></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=number_format($tot_leave_in,2); ?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($tot_leave_out,2); ?>
		  </span></td>
		  </tr>





		</tbody>
		</table>
		<?
}












elseif($_POST['report']==22042101)
{



?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="border:0px;" colspan="23"><?=$str?></td>
    </tr>
  </table>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr style="font-size:14px; " height="30">
        <th width="3%" bgcolor="#45777B"><span class="style24 style21">SL </span></th>
        <th width="12%" bgcolor="#45777B"><span class="style24 style21">PBI ID </span></th>
        <th width="12%" bgcolor="#45777B"><span class="style24 style21">EMP CODE</span></th>
        <th width="23%" bgcolor="#45777B"><span class="style24 style21">Employee Name</span></th>
        <th width="13%" bgcolor="#45777B"><span class="style24 style21">Departemnt</span></th>
        <th width="13%" bgcolor="#45777B"><span class="style24 style21">Opening </span></th>
        <th width="13%" bgcolor="#45777B"><span class="style24 style21">Employer P.F. </span></th>
        <th width="11%" bgcolor="#45777B"><span class="style24 style21">Self P.F.</span></th>
        <th width="11%" bgcolor="#45777B"><span class="style24 style21">P.F. Payment </span></th>
        <th width="11%" bgcolor="#45777B"><span class="style24 style21">Closing Balance </span></th>
      </tr>
    </thead>
    <tbody>



      <?


if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';



		$f_date = $_POST['fdate'];

		$t_date = $_POST['tdate'];



		 $sql = "select PBI_ID, sum(amt_in-amt_out) as pf_opening  from salary_pl_journal where jv_date <'".$f_date."'  group by  PBI_ID ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pf_opening[$info->PBI_ID]=$info->pf_opening;

		 }


		  $sql = "select PBI_ID, sum(amt_in) as pf_employer  from salary_pl_journal where tr_from in ('EMPLOYER PF','EMPLOYER PF OPENING') and jv_date between '".$f_date."' and '".$t_date."'  group by  PBI_ID ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pf_employer[$info->PBI_ID]=$info->pf_employer;

		}


		$sql = "select PBI_ID, sum(amt_in) as pf_self  from salary_pl_journal where tr_from in ('SELF PF','SELF PF OPENING') and jv_date between '".$f_date."' and '".$t_date."'  group by  PBI_ID ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pf_self[$info->PBI_ID]=$info->pf_self;

		}


		 $sql = "select PBI_ID, sum(amt_out) as pf_return  from salary_pl_journal where  jv_date between '".$f_date."' and '".$t_date."'  group by  PBI_ID ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pf_return[$info->PBI_ID]=$info->pf_return;

		}


		 $sql = "select PBI_ID, sum(amt_in-amt_out) as pf_closing from salary_pl_journal where jv_date <'".$t_date."'  group by  PBI_ID ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pf_closing[$info->PBI_ID]=$info->pf_closing;


		}




   $sqll="select a.PBI_ID, a.PBI_CODE, a.PBI_NAME, a.PBI_MOBILE, a.PBI_DOJ, a.EMP_CODE  from
personnel_basic_info a where 1
 ".$con.$JOB_LOCATION_CON." order by a.EMP_CODE";

$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_object($query)){$s++;


?>
      <tr style="font-size:14px; " height="30" >
        <td><?=$s?></td>
        <td><?=$datas->PBI_ID?></td>
        <td><?=$datas->PBI_CODE?></td>
        <td><?=$datas->PBI_NAME?></td>
        <td><?=$datas->department?></td>
        <td><?=number_format($pf_opening[$datas->PBI_ID],2); $total_pf_opening +=$pf_opening[$datas->PBI_ID]?></td>
        <td><?=number_format($pf_employer[$datas->PBI_ID],2);  $total_pf_employer +=$pf_employer[$datas->PBI_ID]?></td>
        <td><?=number_format($pf_self[$datas->PBI_ID],2);  $total_pf_self +=$pf_self[$datas->PBI_ID]?></td>
        <td><?=number_format($pf_return[$datas->PBI_ID],2);  $total_pf_return +=$pf_return[$datas->PBI_ID]?></td>
        <td><?=number_format($pf_closing[$datas->PBI_ID],2);  $total_pf_closing +=$pf_closing[$datas->PBI_ID]?></td>
      </tr>
      <?

}
?>


<tr style="font-size:14px; " height="30" >
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong>Total:</strong></td>
        <td><strong>
          <?=number_format($total_pf_opening,2);?>
        </strong></td>
        <td><strong>
          <?=number_format($total_pf_employer,2);?>
        </strong></td>
        <td><strong>
          <?=number_format($total_pf_self,2);?>
        </strong></td>
        <td><strong>
          <?=number_format($total_pf_return,2);?>
        </strong></td>
        <td><strong>
          <?=number_format($total_pf_closing,2);?>
        </strong></td>
      </tr>
    </tbody>
  </table>
  <?
}









elseif($_POST['report']==7711717121)
{


 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';


if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";



if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr><td style="border:0px;" colspan="23"><?=$str?></td></tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">




<thead>

  <tr>
    <th width="2%" rowspan="2">SL</th>
    <th width="3%" rowspan="2">CODE</th>
    <th width="3%" rowspan="2">Name</th>
    <th colspan="4"><div align="center">Deduction</div></th>
</tr>
<tr>
  <th width="4%">Total Meal</th>
  <th width="4%">Mess Bill</th>
  <th width="7%">Dormitory Charge</th>
  <th width="4%">Total Amount</th>
  </tr>
</thead>
<tbody>
<?




  $dsql="select dp.DEPT_DESC as department, s.PBI_DEPARTMENT from
personnel_basic_info a, department dp, salary_attendence s where a.PBI_ID=s.PBI_ID and s.PBI_DEPARTMENT=dp.DEPT_ID and
   s.mon='".$mon."' and s.year='".$year."'
 ".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON."  group by s.PBI_DEPARTMENT order by dp.DEPT_DESC";

 }

$dquery = db_query($dsql);
$p=0;
while($ddata=mysqli_fetch_object($dquery)){

?>


  <tr>
    <th align="center" colspan="7"><center><?=$ddata->department?></center></th>
    </tr>

<?




if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

 $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and
s.PBI_DEPARTMENT='".$ddata->PBI_DEPARTMENT."' and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
 $sqld = 'select * from salary_attendence where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr style="font-size:14px" ><td><?=$s?></td><td><?=$datas[1]?></td><td><?=$datas[2]?></td>
  <td style="text-align:right"><?=number_format($data->total_meal,2); $tot_total_meal+=$data->total_meal;?></td>
  <td style="text-align:right"><?=number_format($data->mess_bill,2); $tot_mess_bill+=$data->mess_bill;?></td>
  <td style="text-align:right"><?=number_format($data->dormitory,2); $tot_dormitory+=$data->dormitory;?></td>
  <td style="text-align:right"><?=number_format($data->mess_dormitory,2); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
  </tr>
<?



}
?>


<tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong>TOTAL</strong></td>
  <td style="text-align:right"><span class="style7">
    <?=number_format($tot_total_meal,2); $grand_tot_total_meal+=$tot_total_meal;?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($tot_mess_bill,2); $grand_tot_mess_bill+=$tot_mess_bill;?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($tot_dormitory,2); $grand_tot_dormitory+=$tot_dormitory;?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($tot_mess_dormitory,2); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
  </span></td>
  </tr>


<?

$tot_total_meal = 0;
$tot_mess_bill=0;
$tot_dormitory=0;
$tot_mess_dormitory=0;



  }?>





 <tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong>GRAND TOTAL</strong></td>
  <td style="text-align:right"><span class="style7">
    <?=number_format($grand_tot_total_meal,2);?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($grand_tot_mess_bill,2);?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($grand_tot_dormitory,2);?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($grand_tot_mess_dormitory,2);?>
  </span></td>
  </tr>
 </tbody>

 <tfoot>

	  <tr>
      <td colspan="3" style="border-right-color:#FFFFFF;" align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	  <hr style="width:20%;" />
        Prepared By</td>

	  <td colspan="2" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Checked By</td>

	  <td colspan="2" style="border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Authorised By	    </td>
      </tr>
  </tfoot>
 </table>


<?
}








elseif($_POST['report']==7711717121050121)
{


 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';


if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";



if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr><td style="border:0px;" colspan="23"><?=$str?></td></tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">




<thead>

  <tr>
    <th width="2%" rowspan="2">SL</th>
    <th width="8%" rowspan="2">CODE</th>
    <th width="19%" rowspan="2">Name</th>
    <th width="10%" rowspan="2">Mess Bill Type </th>
    <th colspan="3"><div align="center">Deduction</div></th>
</tr>
<tr>
  <th width="15%">Previous Rate Mess Bill </th>
  <th width="14%">Running Rate Mess Bill </th>
  <th width="9%">Difference</th>
  </tr>
</thead>
<tbody>
<?




  $dsql="select dp.DEPT_DESC as department, s.PBI_DEPARTMENT from
personnel_basic_info a, department dp, salary_attendence s where a.PBI_ID=s.PBI_ID and s.PBI_DEPARTMENT=dp.DEPT_ID and
   s.mon='".$mon."' and s.year='".$year."' and s.total_meal>0
 ".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON."  group by s.PBI_DEPARTMENT order by dp.DEPT_DESC";

 }

$dquery = db_query($dsql);
$p=0;
while($ddata=mysqli_fetch_object($dquery)){

?>

  <tr>
    <th align="center" colspan="7"><center><?=$ddata->department?></center></th>
    </tr>

<?

if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

 $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE,  a.mess_bill_type from
personnel_basic_info a, department dp, designation ds, salary_attendence s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and
s.PBI_DEPARTMENT='".$ddata->PBI_DEPARTMENT."' and s.mon='".$mon."' and s.year='".$year."'  and s.total_meal>0
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
 $sqld = 'select * from salary_attendence where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr style="font-size:14px" ><td><?=$s?></td><td><?=$datas[1]?></td><td><?=$datas[2]?></td>
  <td><?= find_a_field('mess_bill_type','bill_type','id="'.$datas[7].'"'); ?>




  <? number_format($data->morning_meal,2); $tot_morning_meal+=$data->morning_meal;?>
  <? number_format($data->lunch_meal,2); $tot_lunch_meal+=$data->lunch_meal;?>
  <? number_format($data->dinner_meal,2); $tot_dinner_meal+=$data->dinner_meal;?>
  <? number_format($data->total_meal,2); $tot_total_meal+=$data->total_meal;?>
  <? number_format($previous_rate_morning=$data->morning_meal*18.00,2); $tot_morning_mess_bill+=$previous_rate_morning;?>
  <? number_format($previous_rate_lunch=$data->lunch_meal*36.00,2); $tot_lunch_mess_bill+=$previous_rate_lunch;?>
  <? number_format($previous_rate_dinner=$data->dinner_meal*18.00,2); $tot_dinner_mess_bill+=$previous_rate_dinner;?>
  <? number_format($previous_rate_mess_bill = ($previous_rate_morning+$previous_rate_lunch+$previous_rate_dinner),2);  $tot_mess_bill+=$previous_rate_mess_bill;?>  </td>
  <td style="text-align:right">

  <? if($datas[7]==1) {
   $previous_final_mess_bill=0;
 } elseif ($datas[7]==3) {
   $previous_final_mess_bill= $previous_rate_morning+$previous_rate_dinner;
 } else {
   $previous_final_mess_bill= $previous_rate_morning+$previous_rate_lunch+$previous_rate_dinner;
  }?>
      <?=$previous_final_mess_bill; $previous_tot_final_mess_bill+=$previous_final_mess_bill;?>  </td>
  <td style="text-align:right">

 <? if($datas[7]==1) {
   $final_mess_bill=0;
 } elseif ($datas[7]==3) {
   $final_mess_bill= $data->morning_mess_bill+$data->dinner_mess_bill;
 } else {
   $final_mess_bill= $data->morning_mess_bill+$data->lunch_mess_bill+$data->dinner_mess_bill;
  }?>

  <?=$final_mess_bill; $tot_final_mess_bill+=$final_mess_bill;?>  </td>
  <td style="text-align:right"><?= $difference_mess_bill = ($final_mess_bill-$previous_final_mess_bill); $tot_difference_mess_bill+=$difference_mess_bill;?></td>
  </tr>
<?



}
?>


<tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong>TOTAL</strong></td>
  <td><? number_format($tot_morning_meal,2); $grand_tot_morning_meal+=$tot_morning_meal;?>
   <? number_format($tot_lunch_meal,2); $grand_tot_lunch_meal+=$tot_lunch_meal;?>
   <? number_format($tot_dinner_meal,2); $grand_tot_dinner_meal+=$tot_dinner_meal;?>
   <? number_format($tot_total_meal,2); $grand_tot_total_meal+=$tot_total_meal;?>
   <? number_format($tot_morning_mess_bill,2); $grand_tot_morning_mess_bill+=$tot_morning_mess_bill;?>
    <? number_format($tot_lunch_mess_bill,2); $grand_tot_lunch_mess_bill+=$tot_lunch_mess_bill;?>
	 <? number_format($tot_dinner_mess_bill,2); $grand_tot_dinner_mess_bill+=$tot_dinner_mess_bill;?>
	  <? number_format($tot_mess_bill,2); $grand_tot_mess_bill+=$tot_mess_bill;?>  </td>
  <td style="text-align:right"><span class="style22">
    <?=number_format($previous_tot_final_mess_bill,2); $grand_previous_tot_final_mess_bill+=$previous_tot_final_mess_bill;?>
  </span></td>
  <td style="text-align:right"><span class="style24">
    <?=number_format($tot_final_mess_bill,2); $grand_tot_final_mess_bill+=$tot_final_mess_bill;?>
  </span></td>
  <td style="text-align:right"><span class="style24">
    <?=number_format($tot_difference_mess_bill,2); $grand_tot_difference_mess_bill+=$tot_difference_mess_bill;?>
  </span></td>
  </tr>


<?
$tot_morning_meal = 0;
$tot_lunch_meal = 0;
$tot_dinner_meal = 0;
$tot_total_meal = 0;
$tot_morning_mess_bill=0;
$tot_lunch_mess_bill=0;
$tot_dinner_mess_bill=0;
$tot_mess_bill=0;
$tot_dormitory=0;
$tot_mess_dormitory=0;
 $previous_tot_final_mess_bill=0;
  $tot_difference_mess_bill=0;
 $tot_final_mess_bill=0;


  }?>





 <tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong>GRAND TOTAL</strong></td>
  <td><span class="style16">
    <? number_format($grand_tot_morning_meal,2);?>
    <? number_format($grand_tot_lunch_meal,2);?>
    <? number_format($grand_tot_dinner_meal,2);?>
    <? number_format($grand_tot_total_meal,2);?>
    <? number_format($grand_tot_morning_mess_bill,2);?>
    <? number_format($grand_tot_lunch_mess_bill,2);?>
    <? number_format($grand_tot_dinner_mess_bill,2);?>
    <? number_format($grand_tot_mess_bill,2);?>
  </span></td>
  <td style="text-align:right"><span class="style23">
    <?=number_format($grand_previous_tot_final_mess_bill,2);?>
  </span></td>
  <td style="text-align:right"> <span class="style25">
    <?=number_format($grand_tot_final_mess_bill,2);?>
  </span></td>
  <td style="text-align:right">
  <span class="style25">
    <?=number_format($grand_tot_difference_mess_bill,2);?>
  </span>  </td>
  </tr>
 </tbody>

 <tfoot>

	  <tr>
      <td colspan="4" style="border-right-color:#FFFFFF;" align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	  <hr style="width:20%;" />
        Prepared By</td>

	  <td colspan="3" style="border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Authorised By	    </td>
      </tr>
  </tfoot>
 </table>


<?
}









elseif($_POST['report']==771171712111)
{






 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';


if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";



if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr><td style="border:0px;" colspan="23"><?=$str?></td></tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">




<thead>

  <tr>
    <th width="2%" rowspan="2">SL</th>
    <th width="3%" rowspan="2">CODE</th>
    <th width="3%" rowspan="2">Name</th>
    <th colspan="4"><div align="center">Deduction</div></th>
</tr>
<tr>
  <th width="4%">Total Meal</th>
  <th width="4%">Mess Bill</th>
  <th width="7%">Dormitory Charge</th>
  <th width="4%">Total Amount</th>
  </tr>
</thead>
<tbody>
<?




  $dsql="select dp.DEPT_DESC as department, s.PBI_DEPARTMENT from
personnel_basic_info a, department dp, salary_attendence_partial s where a.PBI_ID=s.PBI_ID and s.PBI_DEPARTMENT=dp.DEPT_ID and
   s.mon='".$mon."' and s.year='".$year."'
 ".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON."  group by s.PBI_DEPARTMENT order by dp.DEPT_DESC";

 }

$dquery = db_query($dsql);
$p=0;
while($ddata=mysqli_fetch_object($dquery)){

?>


  <tr>
    <th align="center" colspan="7"><center><?=$ddata->department?></center></th>
    </tr>

<?




if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

 $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence_partial s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and
s.PBI_DEPARTMENT='".$ddata->PBI_DEPARTMENT."' and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
 $sqld = 'select * from salary_attendence_partial where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr style="font-size:14px" ><td><?=$s?></td><td><?=$datas[1]?></td><td><?=$datas[2]?></td>
  <td style="text-align:right"><?=number_format($data->total_meal,2); $tot_total_meal+=$data->total_meal;?></td>
  <td style="text-align:right"><?=number_format($data->mess_bill,2); $tot_mess_bill+=$data->mess_bill;?></td>
  <td style="text-align:right"><?=number_format($data->dormitory,2); $tot_dormitory+=$data->dormitory;?></td>
  <td style="text-align:right"><?=number_format($data->mess_dormitory,2); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
  </tr>
<?



}
?>


<tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong>TOTAL</strong></td>
  <td style="text-align:right"><span class="style7">
    <?=number_format($tot_total_meal,2); $grand_tot_total_meal+=$tot_total_meal;?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($tot_mess_bill,2); $grand_tot_mess_bill+=$tot_mess_bill;?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($tot_dormitory,2); $grand_tot_dormitory+=$tot_dormitory;?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($tot_mess_dormitory,2); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
  </span></td>
  </tr>


<?

$tot_total_meal = 0;
$tot_mess_bill=0;
$tot_dormitory=0;
$tot_mess_dormitory=0;



  }?>





 <tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong>GRAND TOTAL</strong></td>
  <td style="text-align:right"><span class="style7">
    <?=number_format($grand_tot_total_meal,2);?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($grand_tot_mess_bill,2);?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($grand_tot_dormitory,2);?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($grand_tot_mess_dormitory,2);?>
  </span></td>
  </tr>
 </tbody>

 <tfoot>

	  <tr>
      <td colspan="3" style="border-right-color:#FFFFFF;" align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	  <hr style="width:20%;" />
        Prepared By</td>

	  <td colspan="2" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Checked By</td>

	  <td colspan="2" style="border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Authorised By	    </td>
      </tr>
  </tfoot>
 </table>


<?
}








elseif($_POST['report']==7711717122)
{


?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr><td style="border:0px;" colspan="23"><?=$str?></td></tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">




<thead>

  <tr>
    <th width="2%" rowspan="2">SL</th>
    <th width="3%" rowspan="2">Department</th>
    <th colspan="4"><div align="center">Deduction</div></th>
</tr>
<tr>
  <th width="4%">Total Meal</th>
  <th width="4%">Mess Bill</th>
  <th width="7%">Dormitory Charge</th>
  <th width="4%">Total Amount</th>
  </tr>
</thead>
<tbody>





<?




if($_POST['mon']>0&&$_POST['year']>0)

{



    if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';


	$mon = $_POST['mon'];
	$year = $_POST['year'];

  $sqll="select  dp.DEPT_SHORT_NAME as department, sum(s.total_meal) as total_meal,
 sum(s.mess_bill) as mess_bill, sum(s.dormitory) as dormitory , sum(s.mess_dormitory) as mess_dormitory from
 department dp, salary_attendence s  where s.PBI_DEPARTMENT=dp.DEPT_ID and s.mon='".$mon."' and s.year='".$year."'  ".$group_con."  group by s.PBI_DEPARTMENT order by dp.DEPT_SHORT_NAME ";
}
$query = db_query($sqll);

$s=0;


while($data=mysqli_fetch_object($query)){$s++;

?>
<tr style="font-size:14px" ><td><?=$s?></td><td><?=$data->department?></td>
  <td style="text-align:right"><?=number_format($data->total_meal,2); $tot_total_meal+=$data->total_meal;?></td>
  <td style="text-align:right"><?=number_format($data->mess_bill,2); $tot_mess_bill+=$data->mess_bill;?></td>
  <td style="text-align:right"><?=number_format($data->dormitory,2); $tot_dormitory+=$data->dormitory;?></td>
  <td style="text-align:right"><?=number_format($data->mess_dormitory,2); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
  </tr>
<?



}
?>


<tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td style="text-align:right"><span class="style7">
    <?=number_format($tot_total_meal,2); $grand_tot_total_meal+=$tot_total_meal;?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($tot_mess_bill,2); $grand_tot_mess_bill+=$tot_mess_bill;?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($tot_dormitory,2); $grand_tot_dormitory+=$tot_dormitory;?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($tot_mess_dormitory,2); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
  </span></td>
  </tr>
 </tbody>

 <tfoot>

	  <tr>
      <td colspan="2" style="border-right-color:#FFFFFF;" align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	  <hr style="width:20%;" />
        Prepared By</td>

	  <td colspan="2" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Checked By</td>

	  <td colspan="2" style="border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Authorised By	    </td>
      </tr>
  </tfoot>
 </table>


<?
}






elseif($_POST['report']==771171712212)
{


?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr><td style="border:0px;" colspan="23"><?=$str?></td></tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">




<thead>

  <tr>
    <th width="2%" rowspan="2">SL</th>
    <th width="3%" rowspan="2">Department</th>
    <th colspan="4"><div align="center">Deduction</div></th>
</tr>
<tr>
  <th width="4%">Total Meal</th>
  <th width="4%">Mess Bill</th>
  <th width="7%">Dormitory Charge</th>
  <th width="4%">Total Amount</th>
  </tr>
</thead>
<tbody>





<?




if($_POST['mon']>0&&$_POST['year']>0)

{



    if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';


	if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';


	$mon = $_POST['mon'];
	$year = $_POST['year'];

  $sqll="select  dp.DEPT_SHORT_NAME as department, sum(s.total_meal) as total_meal,
 sum(s.mess_bill) as mess_bill, sum(s.dormitory) as dormitory , sum(s.mess_dormitory) as mess_dormitory from
 department dp, salary_attendence_partial s  where s.PBI_DEPARTMENT=dp.DEPT_ID and s.mon='".$mon."' and s.year='".$year."'  ".$group_con.$JOB_LOCATION_CON."  group by s.PBI_DEPARTMENT order by dp.DEPT_SHORT_NAME ";
}
$query = db_query($sqll);

$s=0;


while($data=mysqli_fetch_object($query)){$s++;

?>
<tr style="font-size:14px" ><td><?=$s?></td><td><?=$data->department?></td>
  <td style="text-align:right"><?=number_format($data->total_meal,2); $tot_total_meal+=$data->total_meal;?></td>
  <td style="text-align:right"><?=number_format($data->mess_bill,2); $tot_mess_bill+=$data->mess_bill;?></td>
  <td style="text-align:right"><?=number_format($data->dormitory,2); $tot_dormitory+=$data->dormitory;?></td>
  <td style="text-align:right"><?=number_format($data->mess_dormitory,2); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
  </tr>
<?



}
?>


<tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td style="text-align:right"><span class="style7">
    <?=number_format($tot_total_meal,2); $grand_tot_total_meal+=$tot_total_meal;?>
  </span></td>
  <td style="text-align:right"><span class="style8">
    <?=number_format($tot_mess_bill,2); $grand_tot_mess_bill+=$tot_mess_bill;?>
  </span></td>
  <td style="text-align:right"><span class="style16">
    <?=number_format($tot_dormitory,2); $grand_tot_dormitory+=$tot_dormitory;?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($tot_mess_dormitory,2); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
  </span></td>
  </tr>
 </tbody>

 <tfoot>

	  <tr>
      <td colspan="2" style="border-right-color:#FFFFFF;" align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	  <hr style="width:20%;" />
        Prepared By</td>

	  <td colspan="2" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Checked By</td>

	  <td colspan="2" style="border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Authorised By	    </td>
      </tr>
  </tfoot>
 </table>


<?
}









elseif($_POST['report']==771171712121)
{


 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";


if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];


?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr><td style="border:0px;" colspan="23"><?=$str?></td></tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">




<thead>

  <tr>
    <th width="5%" rowspan="2">SL </th>
    <th width="7%" rowspan="2">EMP CODE</th>
    <th width="31%" rowspan="2">Employee Name</th>
    <th colspan="2"><div align="center">Attendance Bonus</div></th>
    <th><div align="center">Deduction</div></th>
</tr>
<tr>
  <th width="8%">Pay Days </th>
  <th width="13%">Att Bonus </th>
  <th width="13%">Mess &amp; Dormitory</th>
  </tr>
</thead>
<tbody>
<?
 $dsql="select dp.DEPT_DESC as department, s.PBI_DEPARTMENT from
personnel_basic_info a, department dp, salary_attendence s where a.PBI_ID=s.PBI_ID and s.PBI_DEPARTMENT=dp.DEPT_ID and  s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON."  group by s.PBI_DEPARTMENT order by s.PBI_DEPARTMENT";

 }

$dquery = db_query($dsql);
$p=0;
while($ddata=mysqli_fetch_object($dquery)){

?>


  <tr>
    <th align="center" colspan="6" style="font-size:16px;"><center><?=$ddata->department?></center></th>
    </tr>

<?




if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

 $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.EMP_CODE from
personnel_basic_info a, department dp, designation ds, salary_attendence s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID  and
s.PBI_DEPARTMENT='".$ddata->PBI_DEPARTMENT."' and s.mon='".$mon."' and s.year='".$year."'
".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON." order by a.EMP_CODE ";
}
$query = db_query($sqll);

$s=0;


while($datas=mysqli_fetch_row($query)){$s++;
 $sqld = 'select * from salary_attendence where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr style="font-size:14px" ><td><?=$s?></td><td><?=$datas[1]?></td><td><?=$datas[2]?></td>
  <td><?=$pay_days =$data->pay+$data->potd; ?></td>
  <td><?=number_format($data->attendance_bonus,2); $tot_attendance_bonus+=$data->attendance_bonus;?></td>
  <td style="text-align:right"><?=number_format($data->mess_dormitory,2); $tot_mess_dormitory+=$data->mess_dormitory;?></td>
  </tr>
<?



}
?>


<tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong>TOTAL</strong></td>
  <td>&nbsp;</td>
  <td><span class="style16">
    <?=number_format($tot_attendance_bonus,2); $grand_tot_attendance_bonus+=$tot_attendance_bonus;?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($tot_mess_dormitory,2); $grand_tot_mess_dormitory+=$tot_mess_dormitory;?>
  </span></td>
  </tr>


<?

$tot_attendance_bonus = 0;
$tot_total_meal = 0;
$tot_mess_bill=0;
$tot_dormitory=0;
$tot_mess_dormitory=0;



  }?>





 <tr height="30"><td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong>GRAND TOTAL</strong></td>
  <td>&nbsp;</td>
  <td><span class="style16">
    <?=number_format($grand_tot_attendance_bonus,2);?>
  </span></td>
  <td style="text-align:right"><span class="style9">
    <?=number_format($grand_tot_mess_dormitory,2);?>
  </span></td>
  </tr>
 </tbody>

 <tfoot>

	  <tr>
      <td colspan="2" style="border-right-color:#FFFFFF;" align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	  <hr style="width:40%;" />
        Prepared By</td>

	  <td colspan="2" style="border-right-color:#FFFFFF; border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Checked By</td>

	  <td colspan="2" style="border-left-color:#FFFFFF; " align="center">
	  <br />
	  <br />
	  <br />
	  <br />
	   <hr style="width:20%;" />
	   Authorised By	    </td>
      </tr>
  </tfoot>
 </table>


<?
}



elseif($_POST['report']==7713)
{



if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];
	$year = $_POST['year'];

  $sqll="select a.PBI_ID as CODE, a.PBI_CODE, a.PBI_NAME as Name, ds.DESG_SHORT_NAME as designation , dp.DEPT_SHORT_NAME as department, a.PBI_DOJ, a.PBI_DEPARTMENT from
personnel_basic_info a, department dp, designation ds, hrm_attendence_final s where a.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and s.mon='".$mon."' and s.year='".$year."'  ".$con." order  by dp.DEPT_SHORT_NAME,a.PBI_CODE ";
}
$query = db_query($sqll);
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="20"><?=$str?></td></tr>

<tr><th width="2%" rowspan="3">S/L</th>
<th width="6%" rowspan="3">CODE</th>
<th width="27%" rowspan="3">Name</th>
<th width="9%" rowspan="3">Department</th>
<th width="9%" rowspan="3">Designation</th>
<th colspan="14"><div align="center">Attendance, <?php echo date('F',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?>'<?php echo date('y',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?></div></th>
</tr>
<tr>
  <th width="5%" rowspan="2">Month Days </th>
  <th colspan="3">Off Days</th>
  <th width="4%" rowspan="2">Present</th>
  <th width="4%" rowspan="2">Abscent</th>
  <th colspan="2">Leave</th>
  <th colspan="2">Late Days </th>
  <th colspan="2">Early Days </th>
  <th width="4%" rowspan="2">Deduct Days </th>
  <th width="4%" rowspan="2">PAY</th>
  </tr>
<tr>
  <th width="2%">OD</th>
  <th width="2%">HD</th>
  <th width="3%">HDD</th>
  <th width="2%">LV</th>
  <th width="3%">LWP</th>
  <th width="2%">Late</th>
  <th width="4%">Panelty</th>
  <th width="4%">Early</th>
  <th width="4%">Panelty</th>
</tr>
</thead>
<tbody>
<?
while($datas=mysqli_fetch_row($query)){ $s++;


  $sqld = 'select * from hrm_attendence_final where mon="'.$mon.'" and year="'.$year.'" and PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));


?>
<tr ><td><?=$s?></td><td><?=$datas[1]?></td><td><?=$datas[2]?></td>
  <td><?=$datas[4]?></td>
  <td><?=$datas[3]?></td>
  <td><?=$data->td?></td>
  <td><?=$data->od?></td>
  <td><?=$data->hd?></td>
  <td><?=$data->hdd?></td>
  <td><?=$data->pre?></td>
  <td><?=$data->ab?></td>
  <td><?=$data->lv?></td>
  <td><?=$data->lwp?></td>
  <td><?=$data->tlt?></td>
  <td><?=$data->ltp?></td>
  <td><?=$data->er?></td>
  <td><?=$data->erp?></td>
  <td><?=$data->lt+$data->ab+$data->lwp;?></td>
  <td><?=$data->pay?></td>
  </tr>
<?
}
?>
</tbody></table>
<?
}






elseif($_POST['report']==7714){

$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);
?>
<center>
  <!--<h1><?=$company?></h1>
  <strong>Daily Absent Report</strong><br>-->
  <?=$str ?><br>

</center>


<?
 $to_day = $_POST['fdate'];

 $sql="SELECT a.PBI_ID, a.PBI_CODE, a.PBI_NAME,  s.dayname as Day_Name FROM hrm_att_summary s, personnel_basic_info a WHERE s.emp_id=a.PBI_ID and  s.att_date = '".$to_day."' ".$con." group by s.emp_id";
$query=db_query($sql);
while($data = mysqli_fetch_object($query)){
$found[$data->PBI_ID][$to_day] = 1;
}



       $sql="SELECT a.PBI_ID, a.PBI_DESIGNATION, a.PBI_CODE, a.PBI_NAME , r.roster_date FROM personnel_basic_info a, hrm_roster_allocation r, user_group u, hrm_shift_info sf WHERE a.PBI_ORG=u.id and a.define_shift=sf.id and a.PBI_ID=r.PBI_ID and  r.roster_date = '".$to_day."' ".$con2.$shift_con." group by a.PBI_ID order by a.PBI_CODE";




$query=db_query($sql);


?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr><th style="border:0px;" colspan="7"></th></tr>

<tr>
  <th width="8%">S/L</th>
  <th width="13%">PBI ID </th>
  <th width="14%">PBI CODE</th>
  <th width="24%">PBI Name</th>
  <th width="14%">Designation</th>
  <th width="14%">Roster  Date </th>
  <th width="27%"><div align="center">Remarks</div></th>
</tr>
</thead>
<tbody>
<?


while($data = mysqli_fetch_object($query)){
if($found[$data->PBI_ID][$to_day]!=1){
?>
<tr>
  <td><?=++$s?></td>
  <td><?=$data->PBI_ID?></td>
  <td><?=$data->PBI_CODE?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=find_a_field('designation','DESG_DESC','DESG_ID='.$data->PBI_DESIGNATION)?></td>
  <td><?=date("d-m-Y",strtotime($data->roster_date));?></td>
  <td>&nbsp;</td>
</tr>
<?
}
}
?>
</tbody></table>
<?
}






elseif($_POST['report']==7715){

//$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);


	//if($_POST['PBI_ORG']!='')
//	$org_con.=' and p.PBI_ORG = "'.$_POST['PBI_ORG'].'"';


?>
<center>
  <!--<h1><?=$company?></h1>
  <strong>Daily Attendance Report</strong><br>-->


  <?=$str ?><br>

</center>


<?

//if($_POST['sch_in_time']!=''&&$_POST['sch_out_time']!='')
//$con .= " AND a.sch_in_time='".$_POST['sch_in_time']."' AND a.sch_out_time='".$_POST['sch_out_time']."'  ";


       $sql="SELECT a.PBI_CODE, a.PBI_NAME, s.att_date, s.dayname as Day_Name, s.in_time,  IF(s.in_time> concat(s.att_date,' ',s.sch_in_time), 'LATE', 'REGULER') as in_status,  s.out_time,  IF(s.out_time< concat(s.att_date,' ',s.sch_out_time), 'EARLY', 'REGULER') as out_status FROM hrm_att_summary s, personnel_basic_info a, user_group u, department dp, hrm_shift_info sf WHERE a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.define_shift=sf.id and s.emp_id=a.PBI_ID and  s.att_date BETWEEN '".$_POST['fdate']."' AND '".$_POST['tdate']."' ".$con.$roster_con.$shift_con." group by s.emp_id";




$query=db_query($sql);


?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr><th style="border:0px;" colspan="7"></th></tr>

<tr>
  <th>S/L</th>
  <th>PBI CODE</th>
  <th>PBI Name</th>
  <th>ATT Date </th>
  <th>Day Name</th>
  <th>In Time</th>
  <th>In Status</th>
  <th>Out Time</th>
  <th>Out Status</th>
  </tr>
</thead>
<tbody>
<?


while($data = mysqli_fetch_object($query)){
?>
<tr>
  <td><?=++$s?></td>
  <td><?=$data->PBI_CODE?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=$data->att_date?></td>
  <td><?=$data->Day_Name?></td>
  <td><?=$data->in_time?></td>
  <td><?=$data->in_status?></td>
  <td><?=$data->out_time?></td>
  <td><?=$data->out_status?></td>
  </tr>
<?
}
?>

</tbody></table>
<?
}




elseif($_POST['report']==771520012020){

//$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);


	//if($_POST['PBI_ORG']!='')
//	$org_con.=' and p.PBI_ORG = "'.$_POST['PBI_ORG'].'"';


?>
<center>

  <!--<strong>Daily Attendance Report</strong><br>-->


  <?=$str ?>

   <h1>Attendance Date: <?=date("d-m-Y",strtotime($tdate)); ?></h1>

</center>


<?

//if($_POST['sch_in_time']!=''&&$_POST['sch_out_time']!='')
//$con .= " AND a.sch_in_time='".$_POST['sch_in_time']."' AND a.sch_out_time='".$_POST['sch_out_time']."'  ";


      // $sql="SELECT a.PBI_CODE, a.PBI_NAME, s.att_date, s.dayname as Day_Name, s.in_time,  IF(s.in_time> concat(s.att_date,' ',s.sch_in_time), 'LATE', 'REGULER') as in_status,  s.out_time,  IF(s.out_time< concat(s.att_date,' ',s.sch_out_time), 'EARLY', 'REGULER') as out_status FROM hrm_att_summary s, personnel_basic_info a, user_group u, department dp, hrm_shift_info sf WHERE a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.define_shift=sf.id and s.emp_id=a.PBI_ID and  s.att_date BETWEEN '".$_POST['fdate']."' AND '".$_POST['tdate']."' ".$con.$roster_con.$shift_con." group by s.emp_id";


	  if(isset($fdate))
		{$date_con=' and s.roster_date between "'.$fdate.'" and "'.$tdate.'"';}


		 if(isset($fdate))
		{$att_date_con=' and s.att_date between "'.$fdate.'" and "'.$tdate.'"';}







 $sql = "select s.emp_id, s.dayname, time(s.in_time) as in_time,  IF(s.in_time> concat(s.att_date,' ',s.sch_in_time), 'LATE', 'REGULER') as in_status,  time(s.out_time) as out_time, IF(s.out_time< concat(s.att_date,' ',s.sch_out_time), 'EARLY', 'REGULER') as out_status ,
 s.iom_sl_no, s.leave_id, s.leave_type, att_date
 from hrm_att_summary s where 1 ".$att_date_con." ";
$query = db_query($sql);
while($info=mysqli_fetch_object($query)){
  $dayname[$info->PBI_ID]=$info->dayname;
  $in_time[$info->emp_id]=$info->in_time;
  $in_status[$info->emp_id]=$info->in_status;
  $out_time[$info->emp_id]=$info->out_time;
  $out_status[$info->emp_id]=$info->out_status;

  $iom_sl_no[$info->emp_id]=$info->iom_sl_no;
  $leave_id[$info->emp_id]=$info->leave_id;
  $leave_type[$info->emp_id]=$info->leave_type;
  $att_date[$info->emp_id]=$info->att_date;

}





	   $sql="SELECT a.PBI_ID, a.PBI_CODE, a.EMP_CODE, a.PBI_NAME, s.roster_date, dp.DEPT_DESC, dg.DESG_DESC

	   FROM hrm_roster_allocation s, personnel_basic_info a, user_group u, department dp, designation dg, hrm_shift_info sf

	   WHERE a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=dg.DESG_ID and a.define_shift=sf.id and s.PBI_ID=a.PBI_ID ".$con.$att_roster_con.$shift_con.$date_con.$service_con." order by a.PBI_DEPARTMENT,a.EMP_CODE";






$query=db_query($sql);


?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr><th style="border:0px;" colspan="8"></th></tr>

<tr>
  <th bgcolor="#CCCCFF">S/L</th>
  <th bgcolor="#CCCCFF">PBI CODE</th>
  <th bgcolor="#CCCCFF">PBI Name</th>
  <th bgcolor="#CCCCFF">Designation</th>
  <th bgcolor="#CCCCFF">Department</th>
  <th bgcolor="#CCCCFF">Day Name</th>
  <th bgcolor="#CCCCFF">In Time</th>
  <th bgcolor="#CCCCFF">In Status</th>
  <th bgcolor="#CCCCFF">Out Time</th>
  <th bgcolor="#CCCCFF">Out Status</th>
  </tr>
</thead>
<tbody>
<?


while($data = mysqli_fetch_object($query)){
?>
<tr <?=($att_date[$data->PBI_ID]=="")?' bgcolor="#FC4136"':'';?>>
  <td><?=++$s?></td>
  <td><?=$data->PBI_CODE?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=$data->DESG_DESC?></td>
  <td><?=$data->DEPT_DESC?></td>
  <td><?=$dayname[$info->PBI_ID];?> </td>
  <td>
  <? if ($iom_sl_no[$data->PBI_ID]>0) {
	  echo 'Outside duty';
  }elseif ($leave_id[$data->PBI_ID]>0) {
  	  echo $leave_type[$data->PBI_ID];
  }elseif ($att_date[$data->PBI_ID]=="") {
  	   echo 'Absence';
  }else {
  	echo $in_time[$data->PBI_ID];
  }
  ?>
   </td>
  <td>
  <? if ($iom_sl_no[$data->PBI_ID]>0) {
	  echo 'Outside duty';
  }elseif ($leave_id[$data->PBI_ID]>0) {
  	  echo $leave_type[$data->PBI_ID];
  }elseif ($att_date[$data->PBI_ID]=="") {
  	   echo 'Absence';
  }else {
  	echo $in_status[$data->PBI_ID];
  }
  ?> </td>
  <td>
   <? if ($iom_sl_no[$data->PBI_ID]>0) {
	  echo 'Outside duty';
  }elseif ($leave_id[$data->PBI_ID]>0) {
  	  echo $leave_type[$data->PBI_ID];
  }elseif ($att_date[$data->PBI_ID]=="") {
  	   echo 'Absence';
  }else {
  	echo $out_time[$data->PBI_ID];
  }
  ?>   </td>
  <td>
 <? if ($iom_sl_no[$data->PBI_ID]>0) {
	  echo 'Outside duty';
  }elseif ($leave_id[$data->PBI_ID]>0) {
  	  echo $leave_type[$data->PBI_ID];
  }elseif ($att_date[$data->PBI_ID]=="") {
  	   echo 'Absence';
  }else {
  	echo $out_status[$data->PBI_ID];
  }
  ?> </td>
  </tr>
<?
}
?>
</tbody></table>
<?
}





elseif($_POST['report']==771506022020){

//$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);


	//if($_POST['PBI_ORG']!='')
//	$org_con.=' and p.PBI_ORG = "'.$_POST['PBI_ORG'].'"';


?>
<center>

  <!--<strong>Daily Attendance Report</strong><br>-->


  <?=$str ?>

   <h1>Attendance Date: <?=date("d-m-Y",strtotime($tdate)); ?></h1>

</center>


<?

//if($_POST['sch_in_time']!=''&&$_POST['sch_out_time']!='')
//$con .= " AND a.sch_in_time='".$_POST['sch_in_time']."' AND a.sch_out_time='".$_POST['sch_out_time']."'  ";


      // $sql="SELECT a.PBI_CODE, a.PBI_NAME, s.att_date, s.dayname as Day_Name, s.in_time,  IF(s.in_time> concat(s.att_date,' ',s.sch_in_time), 'LATE', 'REGULER') as in_status,  s.out_time,  IF(s.out_time< concat(s.att_date,' ',s.sch_out_time), 'EARLY', 'REGULER') as out_status FROM hrm_att_summary s, personnel_basic_info a, user_group u, department dp, hrm_shift_info sf WHERE a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.define_shift=sf.id and s.emp_id=a.PBI_ID and  s.att_date BETWEEN '".$_POST['fdate']."' AND '".$_POST['tdate']."' ".$con.$roster_con.$shift_con." group by s.emp_id";


	  if(isset($fdate))
		{$date_con=' and s.roster_date between "'.$fdate.'" and "'.$tdate.'"';}


		 if(isset($fdate))
		{$att_date_con=' and s.att_date between "'.$fdate.'" and "'.$tdate.'"';}







 $sql = "select s.emp_id, s.dayname, time(s.in_time) as in_time,  IF(s.in_time> concat(s.att_date,' ',s.sch_in_time), 'LATE', 'REGULER') as in_status,  time(s.out_time) as out_time, IF(s.out_time< concat(s.att_date,' ',s.sch_out_time), 'EARLY', 'REGULER') as out_status ,
 s.iom_sl_no, s.leave_id, s.leave_type, att_date, late_grace_no
 from hrm_att_summary s where 1 ".$att_date_con." ";
$query = db_query($sql);
while($info=mysqli_fetch_object($query)){
  $dayname[$info->PBI_ID]=$info->dayname;
  $in_time[$info->emp_id]=$info->in_time;
  $in_status[$info->emp_id]=$info->in_status;
  $out_time[$info->emp_id]=$info->out_time;
  $out_status[$info->emp_id]=$info->out_status;

  $iom_sl_no[$info->emp_id]=$info->iom_sl_no;
  $leave_id[$info->emp_id]=$info->leave_id;
  $leave_type[$info->emp_id]=$info->leave_type;
  $att_date[$info->emp_id]=$info->att_date;

   $late_grace_no[$info->emp_id]=$info->late_grace_no;

}





	    $sql="SELECT a.PBI_ID, a.PBI_CODE, a.EMP_CODE, a.PBI_NAME, s.roster_date, dp.DEPT_DESC, dg.DESG_DESC

	   FROM hrm_roster_allocation s, personnel_basic_info a, user_group u, department dp, designation dg, hrm_shift_info sf

	   WHERE a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=dg.DESG_ID and a.define_shift=sf.id and s.PBI_ID=a.PBI_ID ".$con.$att_roster_con.$shift_con.$date_con.$service_con." order by a.PBI_DEPARTMENT,a.EMP_CODE";






$query=db_query($sql);


?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr><th style="border:0px;" colspan="8"></th></tr>

<tr>
  <th bgcolor="#CCCCFF">S/L</th>
  <th bgcolor="#CCCCFF">PBI CODE</th>
  <th bgcolor="#CCCCFF">PBI Name</th>
  <th bgcolor="#CCCCFF">Designation</th>
  <th bgcolor="#CCCCFF">Department</th>
  <th bgcolor="#CCCCFF">Day Name</th>
  <th bgcolor="#CCCCFF">In Time</th>
  <th bgcolor="#CCCCFF">In Status</th>
  <th bgcolor="#CCCCFF">Out Time</th>
  <th bgcolor="#CCCCFF">Out Status</th>
  </tr>
</thead>
<tbody>



<?


while($data = mysqli_fetch_object($query)){
?>

<? if ($late_grace_no[$data->PBI_ID]==1 || $att_date[$data->PBI_ID]=="") {?>

<tr >
  <td><?=++$s?></td>
  <td><?=$data->PBI_CODE?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=$data->DESG_DESC?></td>
  <td><?=$data->DEPT_DESC?></td>
  <td><?=$dayname[$info->PBI_ID];?> </td>
  <td>
  <? if ($iom_sl_no[$data->PBI_ID]>0) {
	  echo 'Outside duty';
  }elseif ($leave_id[$data->PBI_ID]>0) {
  	  echo $leave_type[$data->PBI_ID];
  }elseif ($att_date[$data->PBI_ID]=="") {
  	   echo 'Absence';
  }else {
  	echo $in_time[$data->PBI_ID];
  }
  ?>
   </td>
  <td>
  <? if ($iom_sl_no[$data->PBI_ID]>0) {
	  echo 'Outside duty';
  }elseif ($leave_id[$data->PBI_ID]>0) {
  	  echo $leave_type[$data->PBI_ID];
  }elseif ($att_date[$data->PBI_ID]=="") {
  	   echo 'Absence';
  }else {
  	echo $in_status[$data->PBI_ID];
  }
  ?> </td>
  <td>
   <? if ($iom_sl_no[$data->PBI_ID]>0) {
	  echo 'Outside duty';
  }elseif ($leave_id[$data->PBI_ID]>0) {
  	  echo $leave_type[$data->PBI_ID];
  }elseif ($att_date[$data->PBI_ID]=="") {
  	   echo 'Absence';
  }else {
  	echo $out_time[$data->PBI_ID];
  }
  ?>   </td>
  <td>
 <? if ($iom_sl_no[$data->PBI_ID]>0) {
	  echo 'Outside duty';
  }elseif ($leave_id[$data->PBI_ID]>0) {
  	  echo $leave_type[$data->PBI_ID];
  }elseif ($att_date[$data->PBI_ID]=="") {
  	   echo 'Absence';
  }else {
  	echo $out_status[$data->PBI_ID];
  }
  ?> </td>
  </tr>

  <? }?>

<?
}
?>
</tbody></table>
<?
}














elseif($_POST['report']==771511){

//$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);


	//if($_POST['PBI_ORG']!='')
//	$org_con.=' and p.PBI_ORG = "'.$_POST['PBI_ORG'].'"';


?>
<center>
  <!--<h1><?=$company?></h1>
  <strong>Daily Attendance Report</strong><br>-->


  <?=$str ?><br>

</center>


<?

//if($_POST['sch_in_time']!=''&&$_POST['sch_out_time']!='')
//$con .= " AND a.sch_in_time='".$_POST['sch_in_time']."' AND a.sch_out_time='".$_POST['sch_out_time']."'  ";


       $sql="SELECT a.PBI_CODE, a.PBI_NAME, s.att_date, s.dayname as Day_Name, s.in_time,  IF(s.in_time> concat(s.att_date,' ',s.sch_in_time), 'LATE', 'REGULER') as in_status,  s.out_time,  IF(s.out_time< concat(s.att_date,' ',s.sch_out_time), 'EARLY', 'REGULER') as out_status FROM hrm_att_summary s, personnel_basic_info a, user_group u, department dp, hrm_shift_info sf WHERE a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.define_shift=sf.id and s.emp_id=a.PBI_ID and s.late_min>0 and  s.att_date BETWEEN '".$_POST['fdate']."' AND '".$_POST['tdate']."' ".$con.$roster_con.$shift_con." group by s.emp_id";




$query=db_query($sql);


?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr><th style="border:0px;" colspan="7"></th></tr>

<tr>
  <th>S/L</th>
  <th>PBI CODE</th>
  <th>PBI Name</th>
  <th>ATT Date </th>
  <th>Day Name</th>
  <th>In Time</th>
  <th>In Status</th>
  <th>Out Time</th>
  <th>Out Status</th>
  </tr>
</thead>
<tbody>
<?


while($data = mysqli_fetch_object($query)){
?>
<tr>
  <td><?=++$s?></td>
  <td><?=$data->PBI_CODE?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=$data->att_date?></td>
  <td><?=$data->Day_Name?></td>
  <td><?=$data->in_time?></td>
  <td><?=$data->in_status?></td>
  <td><?=$data->out_time?></td>
  <td><?=$data->out_status?></td>
  </tr>
<?
}
?>

</tbody></table>
<?
}









elseif($_POST['report']==7721)
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="14"><?=$str?></th></tr>

<tr>
  <th width="3%" rowspan="2">S/L </th>
  <th width="5%" rowspan="2">PBI PIC </th>
  <th width="4%" rowspan="2">PBI ID </th>
  <th width="4%" rowspan="2">EMP CODE</th>
  <th width="4%" rowspan="2">PBI CODE</th>
  <th width="12%" rowspan="2">EMP Name</th>
  <th width="12%" rowspan="2">Name Bangla </th>
  <th width="6%" rowspan="2">Joining Date </th>
  <th width="10%" rowspan="2">Department</th>
  <th colspan="40" align="center"><div align="center">Salary Information </div></th>
  </tr>
<tr>
  <th width="8%">Basic (60%) </th>
  <th width="8%">H. Rant (30%)</th>
  <th width="8%">Madical (6%)</th>
  <th width="8%">Convence (4%) </th>
  <th width="8%">Gross Salary </th>
  </tr>
</thead>
<tbody>
<?
//================================= and d.DESG_ID=t.pbi_designation cut from this query======//
$bank = $_POST['cash_bank'];
 $sqld = 'select a.PBI_ID, a.PBI_CODE, a.EMP_CODE, a.PBI_NAME, a.PBI_NAME_BANGLA, a.PBI_DOJ, ds.DESG_DESC, ds.DESG_NAME_BANGLA, dp.DEPT_NAME_BANGLA, u.group_name, s.basic_salary, s.house_rent, s.medical_allowance, s.conveyance_allowance, s.gross_salary
from  personnel_basic_info a, user_group u, designation ds, salary_info s, department dp
where a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and a.PBI_ID=s.PBI_ID '.$con.'
order by a.PBI_ID';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){



?>
<tr><td><?=++$s?></td>
  <td><img src="../../pic/staff/<?=$data->PBI_ID?>.jpeg" width="auto" height="60"/></td>
  <td><?=$data->PBI_ID?></td>
  <td><?=$data->PBI_CODE?></td>
  <td><?=$data->EMP_CODE?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_NAME_BANGLA?></td>
  <td><?=$data->PBI_DOJ?></td>
  <td><?=$data->DEPT_NAME_BANGLA?></td>
  <td><?=$data->basic_salary ?></td>
  <td><?=$data->house_rent ?></td>
  <td><?=$data->medical_allowance   ?></td>
  <td><?=$data->conveyance_allowance  ?></td>
  <td><?=$data->gross_salary ?></td>
  </tr>
<?
}
?>
</tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}


</style><br />
<?
}





elseif($_POST['report']==7723)
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="6"><?=$str?></th></tr>

<thead>
<tr>
  <th width="7%">S/L  </th>
  <th width="10%">EMP CODE</th>
  <th width="22%">Employee  Name</th>
  <th width="12%">Joining Date </th>
  <th width="16%">Department</th>
  <th width="14%" colspan="36" align="center">Gross Salary </th>
  </tr>
</thead>
<tbody>
<?
//================================= and d.DESG_ID=t.pbi_designation cut from this query======//
$bank = $_POST['cash_bank'];

if(isset($jfdate))
    {$jdate_con=' and a.PBI_DOJ between "'.$jfdate.'" and "'.$jtdate.'"';}

	if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

  $sqld = 'select a.PBI_ID, a.PBI_CODE, a.EMP_CODE, a.PBI_NAME, a.PBI_NAME_BANGLA, a.PBI_DOJ, ds.DESG_DESC, ds.DESG_NAME_BANGLA, dp.DEPT_NAME_BANGLA, dp.DEPT_DESC, u.group_name, s.basic_salary, s.house_rent, s.medical_allowance, s.conveyance_allowance, s.gross_salary
from  personnel_basic_info a, user_group u, designation ds, salary_info s, department dp
where a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and a.PBI_ID=s.PBI_ID '.$con.$jdate_con.$JOB_LOCATION_CON.'
order by a.PBI_ID';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){



?>
<tr><td><?=++$s?></td>
  <td><?=$data->PBI_CODE?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=date("d-m-Y",strtotime($data->PBI_DOJ));?></td>
  <td><?=$data->DEPT_DESC?></td>
  <td><?=number_format($data->gross_salary,2); ?></td>
  </tr>
<?
}
?>
</tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}


</style><br />
<?
}





elseif($_POST['report']==7722)
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="9"><?=$str?></th></tr>

<tr>
  <th width="3%">S/L </th>
  <th width="5%">PBI PIC </th>
  <th width="4%">PBI ID </th>
  <th width="4%">EMP CODE</th>
  <th width="4%">PBI CODE</th>
  <th width="12%">EMP Name</th>
  <th width="12%">Name Bangla </th>
  <th width="6%">Joining Date </th>
  <th width="10%">Department</th>
  </tr>

</thead>
<tbody>
<?
//================================= and d.DESG_ID=t.pbi_designation cut from this query======//
$bank = $_POST['cash_bank'];


if($_POST['jfdate']!=''&&$_POST['jtdate']!='')

		$date_con .= ' and a.PBI_DOJ between "'.$_POST['jfdate'].'" and "'.$_POST['jtdate'].'"';

	if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';



if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';


  $sqld = 'select a.PBI_ID, a.PBI_CODE, a.EMP_CODE, a.PBI_NAME, a.PBI_NAME_BANGLA, a.PBI_DOJ, ds.DESG_DESC, ds.DESG_NAME_BANGLA, dp.DEPT_NAME_BANGLA, u.group_name
from  personnel_basic_info a, user_group u, designation ds,  department dp
where a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and a.PBI_JOB_STATUS="In Service" '.$con.$date_con.$JOB_LOCATION_CON.$shift_con.'
order by a.EMP_CODE';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){



?>
<tr><td><?=++$s?></td>
  <td><img src="../../pic/staff/<?=$data->PBI_ID?>.jpeg" width="auto" height="60"/></td>
  <td><?=$data->PBI_ID?></td>
  <td><?=$data->PBI_CODE?></td>
  <td><?=$data->EMP_CODE?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_NAME_BANGLA?></td>
  <td><?=$data->PBI_DOJ?></td>
  <td><?=$data->DEPT_NAME_BANGLA?></td>
  </tr>
<?
}
?>
</tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}


</style><br />
<?
}







elseif($_POST['report']==7716)
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="12"><?=$str?></th></tr>

<tr>
  <th width="2%">S/L</th>
  <th width="5%">PBI PIC </th>
  <th width="5%">PBI ID </th>
  <th width="8%">EMP CODE</th>
  <th width="9%">PBI CODE</th>
  <th width="14%">PBI Name</th>
  <th width="14%">Name Bangla </th>
  <th width="9%">Joining Date </th>
  <th width="10%">Department</th>
  <th width="10%">Designation</th>
  <th width="10%">Group</th>
  <th width="19%">Barcode</th>
  </tr>
</thead>
<tbody>
<?
//================================= and d.DESG_ID=t.pbi_designation cut from this query======//
$bank = $_POST['cash_bank'];
 $sqld = 'select a.PBI_ID, a.PBI_CODE, a.EMP_CODE, a.PBI_NAME, a.PBI_NAME_BANGLA, a.PBI_DOJ, ds.DESG_DESC, ds.DESG_NAME_BANGLA, dp.DEPT_NAME_BANGLA, u.group_name
from  personnel_basic_info a, user_group u, designation ds, hrm_residential r, department dp
where a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and a.PBI_RESIDENT=r.id '.$con.'
order by a.PBI_ID';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){


		  $barcode_content = $data->EMP_CODE;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=20;
          $printText='';


?>
<tr><td><?=++$s?></td>
  <td><img src="../../pic/staff/<?=$data->PBI_ID?>.jpeg" width="auto" height="60"/></td>
  <td><?=$data->PBI_ID?></td>
  <td><?=$data->PBI_CODE?></td>
  <td><?=$data->EMP_CODE?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_NAME_BANGLA?></td>
  <td><?=$data->PBI_DOJ?></td>
  <td><?=$data->DEPT_NAME_BANGLA?></td>
  <td><?=$data->DESG_NAME_BANGLA?></td>
  <td><?=$data->group_name?></td>
  <td>&nbsp;&nbsp;&nbsp;<?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>&nbsp;&nbsp;&nbsp;</td>
  </tr>
<?
}
?>
</tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}


</style><br />
<?
}





elseif($_POST['report']==7720)
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="12"><?=$str?></th></tr>

<tr>
  <th width="2%">S/L</th>
  <th width="5%">PBI PIC </th>
  <th width="5%">PBI ID </th>
  <th width="8%">EMP CODE</th>
  <th width="9%">PBI CODE</th>
  <th width="14%">PBI Name</th>
  <th width="14%">Name Bangla </th>
  <th width="9%">Date of Birth </th>
  <th width="10%">Department</th>
  <th width="10%">Designation</th>
  <th width="10%">Group</th>
  <th width="19%">Barcode</th>
  </tr>
</thead>
<tbody>
<?
//================================= and d.DESG_ID=t.pbi_designation cut from this query======//
$bank = $_POST['cash_bank'];
 $sqld = 'select a.PBI_ID, a.PBI_CODE, a.EMP_CODE, a.PBI_NAME, a.PBI_NAME_BANGLA, a.PBI_DOJ, ds.DESG_DESC, ds.DESG_NAME_BANGLA, dp.DEPT_NAME_BANGLA, u.group_name
from  personnel_basic_info a, user_group u, designation ds, hrm_residential r, department dp
where a.PBI_ORG=u.id and a.PBI_DEPARTMENT=dp.DEPT_ID and a.PBI_DESIGNATION=ds.DESG_ID and a.PBI_RESIDENT=r.id and a.PBI_DOJ="0000-00-00" '.$con.'
order by a.PBI_ID';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){


		  $barcode_content = $data->EMP_CODE;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=20;
          $printText='';


?>
<tr><td><?=++$s?></td>
  <td><img src="../../pic/staff/<?=$data->PBI_ID?>.jpeg" width="auto" height="60"/></td>
  <td><?=$data->PBI_ID?></td>
  <td><?=$data->PBI_CODE?></td>
  <td><?=$data->EMP_CODE?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_NAME_BANGLA?></td>
  <td><?=$data->PBI_DOJ?></td>
  <td><?=$data->DEPT_NAME_BANGLA?></td>
  <td><?=$data->DESG_NAME_BANGLA?></td>
  <td><?=$data->group_name?></td>
  <td>&nbsp;&nbsp;&nbsp;<?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>&nbsp;&nbsp;&nbsp;</td>
  </tr>
<?
}
?>
</tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}


</style><br />
<?
}






elseif($_POST['report']==7717){ // salary payslip view
?><table border="1" cellpadding="100" align="center"><tr style="position:relative;display:block; width:100%; float: none;  ">
<?
if($_POST['branch']!='') $con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

  echo $sql22="SELECT a.*, sum(s.gross_salary) as gross_salary
FROM personnel_basic_info a, salary_info s
WHERE  a.PBI_ID=s.PBI_ID ".$con."  group by s.PBI_ID
order by a.PBI_ID  ";

$res = db_query($sql22);
	$ig=0;$pg=-2; while($data=mysqli_fetch_object($res)){



		  $barcode_content = $data->EMP_CODE;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=30;
          $printText='';



?>

<? $ig++;?>


       <td style="width:220px;" border="0" >
		   <table width="100%"  border="0" bordercolor="#99CCFF" style="height:310px; "   >
		   		<tr width="100%" border="0" bordercolor="#99CCFF"  <?=($data->PBI_RESIDENT==1 || $data->PBI_RESIDENT==3)?' bgcolor="#FFFF00"':'';?> >
					<td width="100%"  border="0" bordercolor="#99CCFF" style="border-bottom: 1px solid #fff; border-right: 1px solid #fff; border-left: 1px solid #fff;">
						 <table  width="100%"  border="0" bordercolor="#99CCFF" >


							<tr align="center" class="noBorder">
								<td align="right"><img style="border-radius: 50%; float:right;" src="images/idlogo.png" width="40" height="40"/></td>

								<td colspan="3" align="left" >

								<span style="font-size:24px; font-weight:700; ">

								ফরিদ গ্রুপ</span>	</td>
							</tr>



							<tr align="center" class="noBorder">
								<td colspan="3" >

								<table  width="100%"  border="0" bordercolor="#99CCFF" >
									<tr>
										<td width="20%">&nbsp;</td>
										<td width="60%" align="center"><img src="../../pic/staff/<?=$data->PBI_ID?>.jpeg" width="auto" height="60"/></td>
										<td width="20%">
											<table  width="100%"  border="0" bordercolor="#99CCFF" style="font-size:22px; color:#FF0000; font-weight:700;" >

												<tr align="center">
													<td>গ্রেড</td>
												</tr>

												<tr align="center">
													<td>
															<?
															if($data->gross_salary >= 5800 && $data->gross_salary <= 6000 )
															{
															echo $grade = '(Z)';
															}
															elseif($data->gross_salary >= 6001 && $data->gross_salary <= 6300)
															{
															echo $grade = '(Y)';
															}
															elseif($data->gross_salary >= 6301 && $data->gross_salary <= 6600)
															{
															echo $grade = '(X)';
															}
															elseif($data->gross_salary >= 6601 && $data->gross_salary <= 7000)
															{
															echo $grade = '(W)';
															}
															elseif($data->gross_salary >= 7001 && $data->gross_salary <= 7500)
															{
															echo $grade = '(V)';
															}
															elseif($data->gross_salary >= 7501 && $data->gross_salary <= 8000)
															{
															echo $grade = '(U)';
															}
															elseif($data->gross_salary >= 8001 && $data->gross_salary <= 8500)
															{
															echo $grade = '(T)';
															}
															elseif($data->gross_salary >= 8501 && $data->gross_salary <= 9000)
															{
															echo $grade = '(S)';
															}
															elseif($data->gross_salary >= 9001 && $data->gross_salary <= 9500)
															{
															echo $grade = '(R)';
															}
															elseif($data->gross_salary >= 9501 && $data->gross_salary <= 10000)
															{
															echo $grade = '(Q)';
															}
															elseif($data->gross_salary >= 10001 && $data->gross_salary <= 10500)
															{
															echo $grade = '(P)';
															}
															elseif($data->gross_salary >= 10501 && $data->gross_salary <= 11000)
															{
															echo $grade = '(O)';
															}
															elseif($data->gross_salary >= 11001 && $data->gross_salary <= 11500)
															{
															echo $grade = '(N)';
															}
															elseif($data->gross_salary >= 11501 && $data->gross_salary <= 12000)
															{
															echo $grade = '(M)';
															}
															elseif($data->gross_salary >= 12001 && $data->gross_salary <= 12500)
															{
															echo $grade = '(L)';
															}
															elseif($data->gross_salary >= 12501 && $data->gross_salary <= 13000)
															{
															echo $grade = '(K)';
															}
															elseif($data->gross_salary >= 13001 && $data->gross_salary <= 13500)
															{
															echo $grade = '(J)';
															}
															elseif($data->gross_salary >= 13501 && $data->gross_salary <= 14000)
															{
															echo $grade = '(I)';
															}
															elseif($data->gross_salary >= 14001 && $data->gross_salary <= 14500)
															{
															echo $grade = '(H)';
															}
															elseif($data->gross_salary >= 14501 && $data->gross_salary <= 15000)
															{
															echo $grade = '(G)';
															}
															elseif($data->gross_salary >= 15001 && $data->gross_salary <= 17000)
															{
															echo $grade = '(F)';
															}
															elseif($data->gross_salary >= 17001 && $data->gross_salary <= 20000)
															{
															echo $grade = '(E)';
															}
															elseif($data->gross_salary >= 20001 && $data->gross_salary <= 25000)
															{
															echo $grade = '(D)';
															}
															elseif($data->gross_salary >= 25001 && $data->gross_salary <= 35000)
															{
															echo $grade = '(C)';
															}
															elseif($data->gross_salary >= 35001 && $data->gross_salary <= 50000)
															{
															echo $grade = '(B)';
															}
															elseif($data->gross_salary >= 50001 && $data->gross_salary <= 100000)
															{
															echo $grade = '(A)';
															}

															?>

													</td>
												</tr>

											</table>

										</td>

									</tr>

								</table>

							  </td>
							</tr>

							<tr width="100%"  align="center" class="noBorder">
								<td colspan="3" ><span style="font-size:14px; font-weight:700; ">
								  <?=$data->PBI_NAME_BANGLA?>
								</span>
								<br>
								<? if ($data->PBI_RESIDENT==1 || $data->PBI_RESIDENT==3  ) { ?>
								<span style="font-size:10px; font-weight:700; color:#FF0000;">
								  (আবাসিক)
								</span>
								<? } ?>
								</td>
							</tr>
							<tr width="100%" align="left" class="noBorder" style="margin:0; padding:0;">
								<td  width="8%"  style="font-size:10px"  >ইউনিট</td>

							    <td   width="92%" style="font-size:8px" >:&nbsp;
						        <?=find_a_field('user_group','name_bangla','id='.$data->PBI_ORG)?></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%" style="font-size:10px"  >বিভাগ</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=find_a_field('department','DEPT_NAME_BANGLA','DEPT_ID='.$data->PBI_DEPARTMENT)?></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td   width="8%" style="font-size:10px"  >পদবী</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=find_a_field('designation','DESG_NAME_BANGLA','DESG_ID='.$data->PBI_DESIGNATION)?></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%" style="font-size:10px; color:#FF0000"  >আইডি নং</td>

							    <td width="92%" style="font-size:15px; color:#FF0000; font-weight:700;">:&nbsp;
								<span ><?=$data->PBI_CODE?></span></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td   width="8%" style="font-size:10px"  >যোগদান</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=date("d-m-Y",strtotime($data->PBI_DOJ));?></td>
							</tr>

							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%"  style="font-size:8px" >রক্তের গ্রুপ</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=$data->ESSENTIAL_BLOOD_GROUP?></td>
							</tr>




							<tr width="100%"  align="center"  class="noBorder">

								<td colspan="3">
								  <?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>								</td>
							</tr>
						 </table>
					</td>
				</tr>

		   </table>
	   </td>
	  <? if(($ig%3)==0){ $pg++; ?></tr><tr style="display:block; width:100%; <? if(($pg%3)==0){?>page-break-after:always; <? }?>"><? }?>


	  <? } ?>
  </table>

</div>
<br /><br /><br /><br />

<? }











elseif($_POST['report']==77170001){ // salary payslip view
?><table border="1" cellpadding="100" align="center"><tr style="position:relative;display:block; width:100%; float: none;  ">
<?
if($_POST['branch']!='') $con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

echo  $sql22="SELECT a.*, sum(s.gross_salary) as gross_salary
FROM personnel_basic_info a, salary_info s
WHERE  a.PBI_ID=s.PBI_ID ".$con."  group by s.PBI_ID
order by a.PBI_ID  ";

$res = db_query($sql22);
	$ig=0;$pg=-2; while($data=mysqli_fetch_object($res)){



		  $barcode_content = $data->EMP_CODE;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=30;
          $printText='';



?>

<? $ig++;?>


       <td style="width:190px;" border="0" >
		   <table width="100%"  border="0" bordercolor="#99CCFF" style="height:280px; "   >
		   		<tr width="100%" border="0" bordercolor="#99CCFF"  <?=($data->PBI_RESIDENT==1 || $data->PBI_RESIDENT==3)?' bgcolor="#FFFF00"':'';?> >
					<td width="100%"  border="0" bordercolor="#99CCFF" style="border-bottom: 1px solid #fff; border-right: 1px solid #fff; border-left: 1px solid #fff;">
						 <table  width="100%"  border="0" bordercolor="#99CCFF" >


							<tr align="center" class="noBorder">
								<td align="right"><img style="border-radius: 50%; float:right;" src="images/idlogo.png" width="40" height="40"/></td>

								<td colspan="3" align="left" >

								<span style="font-size:24px; font-weight:700; ">

								ফরিদ গ্রুপ</span>	</td>
							</tr>



							<tr align="center" class="noBorder">
								<td colspan="3" >

								<table  width="100%"  border="0" bordercolor="#99CCFF" >
									<tr>
										<td width="20%">&nbsp;</td>
										<td width="60%" align="center"><img src="../../pic/staff/<?=$data->PBI_ID?>.jpeg" width="auto" height="50"/></td>
										<td width="20%">
											<table  width="100%"  border="0" bordercolor="#99CCFF" style="font-size:22px; color:#FF0000; font-weight:700;" >

												<tr align="center">
													<td>গ্রেড</td>
												</tr>

												<tr align="center">
													<td>
															<?
															if($data->gross_salary >= 5800 && $data->gross_salary <= 6000 )
															{
															echo $grade = '(Z)';
															}
															elseif($data->gross_salary >= 6001 && $data->gross_salary <= 6300)
															{
															echo $grade = '(Y)';
															}
															elseif($data->gross_salary >= 6301 && $data->gross_salary <= 6600)
															{
															echo $grade = '(X)';
															}
															elseif($data->gross_salary >= 6601 && $data->gross_salary <= 7000)
															{
															echo $grade = '(W)';
															}
															elseif($data->gross_salary >= 7001 && $data->gross_salary <= 7500)
															{
															echo $grade = '(V)';
															}
															elseif($data->gross_salary >= 7501 && $data->gross_salary <= 8000)
															{
															echo $grade = '(U)';
															}
															elseif($data->gross_salary >= 8001 && $data->gross_salary <= 8500)
															{
															echo $grade = '(T)';
															}
															elseif($data->gross_salary >= 8501 && $data->gross_salary <= 9000)
															{
															echo $grade = '(S)';
															}
															elseif($data->gross_salary >= 9001 && $data->gross_salary <= 9500)
															{
															echo $grade = '(R)';
															}
															elseif($data->gross_salary >= 9501 && $data->gross_salary <= 10000)
															{
															echo $grade = '(Q)';
															}
															elseif($data->gross_salary >= 10001 && $data->gross_salary <= 10500)
															{
															echo $grade = '(P)';
															}
															elseif($data->gross_salary >= 10501 && $data->gross_salary <= 11000)
															{
															echo $grade = '(O)';
															}
															elseif($data->gross_salary >= 11001 && $data->gross_salary <= 11500)
															{
															echo $grade = '(N)';
															}
															elseif($data->gross_salary >= 11501 && $data->gross_salary <= 12000)
															{
															echo $grade = '(M)';
															}
															elseif($data->gross_salary >= 12001 && $data->gross_salary <= 12500)
															{
															echo $grade = '(L)';
															}
															elseif($data->gross_salary >= 12501 && $data->gross_salary <= 13000)
															{
															echo $grade = '(K)';
															}
															elseif($data->gross_salary >= 13001 && $data->gross_salary <= 13500)
															{
															echo $grade = '(J)';
															}
															elseif($data->gross_salary >= 13501 && $data->gross_salary <= 14000)
															{
															echo $grade = '(I)';
															}
															elseif($data->gross_salary >= 14001 && $data->gross_salary <= 14500)
															{
															echo $grade = '(H)';
															}
															elseif($data->gross_salary >= 14501 && $data->gross_salary <= 15000)
															{
															echo $grade = '(G)';
															}
															elseif($data->gross_salary >= 15001 && $data->gross_salary <= 17000)
															{
															echo $grade = '(F)';
															}
															elseif($data->gross_salary >= 17001 && $data->gross_salary <= 20000)
															{
															echo $grade = '(E)';
															}
															elseif($data->gross_salary >= 20001 && $data->gross_salary <= 25000)
															{
															echo $grade = '(D)';
															}
															elseif($data->gross_salary >= 25001 && $data->gross_salary <= 35000)
															{
															echo $grade = '(C)';
															}
															elseif($data->gross_salary >= 35001 && $data->gross_salary <= 50000)
															{
															echo $grade = '(B)';
															}
															elseif($data->gross_salary >= 50001 && $data->gross_salary <= 100000)
															{
															echo $grade = '(A)';
															}

															?>

													</td>
												</tr>

											</table>

										</td>

									</tr>

								</table>

							  </td>
							</tr>

							<tr width="100%"  align="center" class="noBorder">
								<td colspan="3" ><span style="font-size:14px; font-weight:700; ">
								  <?=$data->PBI_NAME_BANGLA?>
								</span>
								<br>
								<? if ($data->PBI_RESIDENT==1 || $data->PBI_RESIDENT==3  ) { ?>
								<span style="font-size:10px; font-weight:700; color:#FF0000;">
								  (আবাসিক)
								</span>
								<? } ?>
								</td>
							</tr>
							<tr width="100%" align="left" class="noBorder" style="margin:0; padding:0;">
								<td  width="8%"  style="font-size:10px"  >ইউনিট</td>

							    <td   width="92%" style="font-size:8px" >:&nbsp;
						        <?=find_a_field('user_group','name_bangla','id='.$data->PBI_ORG)?></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%" style="font-size:10px"  >বিভাগ</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=find_a_field('department','DEPT_NAME_BANGLA','DEPT_ID='.$data->PBI_DEPARTMENT)?></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td   width="8%" style="font-size:10px"  >পদবী</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=find_a_field('designation','DESG_NAME_BANGLA','DESG_ID='.$data->PBI_DESIGNATION)?></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%" style="font-size:10px; color:#FF0000"  >আইডি নং</td>

							    <td width="92%" style="font-size:15px; color:#FF0000; font-weight:700;">:&nbsp;
								<span ><?=$data->PBI_CODE?></span></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td   width="8%" style="font-size:10px"  >যোগদান</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=date("d-m-Y",strtotime($data->PBI_DOJ));?></td>
							</tr>

							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%"  style="font-size:8px" >রক্তের গ্রুপ</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=$data->ESSENTIAL_BLOOD_GROUP?></td>
							</tr>




							<tr width="100%"  align="center"  class="noBorder">

								<td colspan="3">
								  <?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>								</td>
							</tr>
						 </table>
					</td>
				</tr>

		   </table>
	   </td>
	  <? if(($ig%3)==0){ $pg++; ?></tr><tr style="display:block; width:100%; <? if(($pg%3)==0){?>page-break-after:always; <? }?>"><? }?>


	  <? } ?>
  </table>

</div>
<br /><br /><br /><br />

<? }












elseif($_POST['report']==77170002){ // salary payslip view
?><table border="1" cellpadding="100" align="center"><tr style="position:relative;display:block; width:100%; float: none;  ">
<?
if($_POST['branch']!='') $con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

  $sql22="SELECT a.*, sum(s.gross_salary) as gross_salary
FROM personnel_basic_info a, hrm_residential r, salary_info s
WHERE a.PBI_RESIDENT=r.id and a.PBI_ID=s.PBI_ID ".$con."  group by s.PBI_ID
order by a.PBI_ID  ";

$res = db_query($sql22);
	$ig=0;$pg=-2; while($data=mysqli_fetch_object($res)){



		  $barcode_content = $data->EMP_CODE;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=30;
          $printText='';



?>

<? $ig++;?>


       <td style="width:190px;" border="0" >
		   <table width="100%"  border="0" bordercolor="#99CCFF" style="height:280px; "   >
		   		<tr width="100%" border="0" bordercolor="#99CCFF"  <?=($data->PBI_RESIDENT==1 || $data->PBI_RESIDENT==3)?' bgcolor="#FFFF00"':'';?> >
					<td width="100%"  border="0" bordercolor="#99CCFF" style="border-bottom: 1px solid #fff; border-right: 1px solid #fff; border-left: 1px solid #fff;">
						 <table  width="100%"  border="0" bordercolor="#99CCFF" >


							<tr align="center" class="noBorder">
								<td align="right"><img style="border-radius: 50%; float:right;" src="images/idlogo.png" width="40" height="40"/></td>

								<td colspan="3" align="left" >

								<span style="font-size:18px; font-weight:700; ">

								Farid Group</span>	</td>
							</tr>



							<tr align="center" class="noBorder">
								<td colspan="3" >

								<table  width="100%"  border="0" bordercolor="#99CCFF" >
									<tr>
										<td width="6%">&nbsp;</td>
										<td width="57%" align="center"><img src="../../pic/staff/<?=$data->PBI_ID?>.jpeg" width="60" height="50"/></td>
										<td width="37%">
											<table  width="100%"  border="0" bordercolor="#99CCFF" style="font-size:20px; color:#FF0000; font-weight:700;" >

												<tr align="center">
													<td>Grade</td>
												</tr>

												<tr align="center">
													<td>
															<?
															if($data->gross_salary >= 5800 && $data->gross_salary <= 6000 )
															{
															echo $grade = '(Z)';
															}
															elseif($data->gross_salary >= 6001 && $data->gross_salary <= 6300)
															{
															echo $grade = '(Y)';
															}
															elseif($data->gross_salary >= 6301 && $data->gross_salary <= 6600)
															{
															echo $grade = '(X)';
															}
															elseif($data->gross_salary >= 6601 && $data->gross_salary <= 7000)
															{
															echo $grade = '(W)';
															}
															elseif($data->gross_salary >= 7001 && $data->gross_salary <= 7500)
															{
															echo $grade = '(V)';
															}
															elseif($data->gross_salary >= 7501 && $data->gross_salary <= 8000)
															{
															echo $grade = '(U)';
															}
															elseif($data->gross_salary >= 8001 && $data->gross_salary <= 8500)
															{
															echo $grade = '(T)';
															}
															elseif($data->gross_salary >= 8501 && $data->gross_salary <= 9000)
															{
															echo $grade = '(S)';
															}
															elseif($data->gross_salary >= 9001 && $data->gross_salary <= 9500)
															{
															echo $grade = '(R)';
															}
															elseif($data->gross_salary >= 9501 && $data->gross_salary <= 10000)
															{
															echo $grade = '(Q)';
															}
															elseif($data->gross_salary >= 10001 && $data->gross_salary <= 10500)
															{
															echo $grade = '(P)';
															}
															elseif($data->gross_salary >= 10501 && $data->gross_salary <= 11000)
															{
															echo $grade = '(O)';
															}
															elseif($data->gross_salary >= 11001 && $data->gross_salary <= 11500)
															{
															echo $grade = '(N)';
															}
															elseif($data->gross_salary >= 11501 && $data->gross_salary <= 12000)
															{
															echo $grade = '(M)';
															}
															elseif($data->gross_salary >= 12001 && $data->gross_salary <= 12500)
															{
															echo $grade = '(L)';
															}
															elseif($data->gross_salary >= 12501 && $data->gross_salary <= 13000)
															{
															echo $grade = '(K)';
															}
															elseif($data->gross_salary >= 13001 && $data->gross_salary <= 13500)
															{
															echo $grade = '(J)';
															}
															elseif($data->gross_salary >= 13501 && $data->gross_salary <= 14000)
															{
															echo $grade = '(I)';
															}
															elseif($data->gross_salary >= 14001 && $data->gross_salary <= 14500)
															{
															echo $grade = '(H)';
															}
															elseif($data->gross_salary >= 14501 && $data->gross_salary <= 15000)
															{
															echo $grade = '(G)';
															}
															elseif($data->gross_salary >= 15001 && $data->gross_salary <= 17000)
															{
															echo $grade = '(F)';
															}
															elseif($data->gross_salary >= 17001 && $data->gross_salary <= 20000)
															{
															echo $grade = '(E)';
															}
															elseif($data->gross_salary >= 20001 && $data->gross_salary <= 25000)
															{
															echo $grade = '(D)';
															}
															elseif($data->gross_salary >= 25001 && $data->gross_salary <= 35000)
															{
															echo $grade = '(C)';
															}
															elseif($data->gross_salary >= 35001 && $data->gross_salary <= 50000)
															{
															echo $grade = '(B)';
															}
															elseif($data->gross_salary >= 50001 && $data->gross_salary <= 100000)
															{
															echo $grade = '(A)';
															}

															?>													</td>
												</tr>
											</table>										</td>
									</tr>
								</table>							  </td>
							</tr>

							<tr width="100%"  align="center" class="noBorder">
								<td colspan="3" ><span style="font-size:12px; text-transform:uppercase; font-weight:700; ">
								  <?=$data->PBI_NAME?>
								</span>
								<br>
								<? if ($data->PBI_RESIDENT==1 || $data->PBI_RESIDENT==3  ) { ?>
								<span style="font-size:10px; font-weight:700; color:#FF0000;">
								  (Residential)								</span>
								<? } ?>								</td>
							</tr>
							<tr width="100%" align="left" class="noBorder" style="margin:0; padding:0;">
								<td  style="font-size:10px" align="left"  >Unit</td>
						        <td  style="font-size:9px" align="left"  >:&nbsp;<?=find_a_field('user_group','group_name','id='.$data->PBI_ORG)?></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%" style="font-size:10px"  >Dept.</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=find_a_field('department','DEPT_DESC','DEPT_ID='.$data->PBI_DEPARTMENT)?></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td   width="8%" style="font-size:10px"  >Desg.</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=find_a_field('designation','DESG_DESC','DESG_ID='.$data->PBI_DESIGNATION)?></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%" style="font-size:10px; color:#FF0000"  >ID No</td>

							    <td width="92%" style="font-size:15px; color:#FF0000; font-weight:700;">:&nbsp;
								<span ><?=$data->PBI_CODE?></span></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td   width="8%" style="font-size:10px"  >Join</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=date("d-m-Y",strtotime($data->PBI_DOJ));?></td>
							</tr>

							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%"  style="font-size:8px" >Blood</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=$data->ESSENTIAL_BLOOD_GROUP?></td>
							</tr>




							<tr width="100%"  align="center"  class="noBorder">

								<td colspan="3">
								  <?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>								</td>
							</tr>
						 </table>
					</td>
				</tr>

		   </table>
	   </td>
	  <? if(($ig%3)==0){ $pg++; ?></tr><tr style="display:block; width:100%; <? if(($pg%3)==0){?>page-break-after:always; <? }?>"><? }?>


	  <? } ?>
  </table>

</div>
<br /><br /><br /><br />

<? }








elseif($_POST['report']==77170003){ // salary payslip view
?><table border="1" cellpadding="100" align="center"><tr style="position:relative;display:block; width:100%; float: none;  ">
<?
if($_POST['branch']!='') $con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

  echo $sql22="SELECT a.*, sum(s.gross_salary) as gross_salary
FROM personnel_basic_info a, salary_info s
WHERE  a.PBI_ID=s.PBI_ID ".$con."  group by s.PBI_ID
order by a.PBI_ID  ";

$res = db_query($sql22);
	$ig=0;$pg=-2; while($data=mysqli_fetch_object($res)){



		  $barcode_content = $data->EMP_CODE;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=30;
          $printText='';



?>

<? $ig++;?>


       <td style="width:190px;" border="0" >
		   <table width="100%"  border="0" bordercolor="#99CCFF" style="height:280px; "   >
		   		<tr width="100%" border="0" bordercolor="#99CCFF"  <?=($data->PBI_RESIDENT==1 || $data->PBI_RESIDENT==3)?' bgcolor="#FFFF00"':'';?> >
					<td width="100%"  border="0" bordercolor="#99CCFF" style="border-bottom: 1px solid #fff; border-right: 1px solid #fff; border-left: 1px solid #fff;">
						 <table  width="100%"  border="0" bordercolor="#99CCFF" >


							<tr align="center" class="noBorder">
								<td align="right"><img style="border-radius: 50%; float:right;" src="images/idlogo.png" width="40" height="40"/></td>

								<td colspan="3" align="left" >

								<span style="font-size:18px; font-weight:700; ">

								Farid Group</span>	</td>
							</tr>



							<tr align="center" class="noBorder">
								<td colspan="3" >

								<table  width="100%"  border="0" bordercolor="#99CCFF" >
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="90%" align="center"><img src="../../pic/staff/<?=$data->PBI_ID?>.jpeg" width="auto" height="50"/></td>
										<td width="5%">&nbsp;
									  </td>
									</tr>
								</table>							  </td>
							</tr>

							<tr width="100%"  align="center" class="noBorder">
								<td colspan="3" ><span style="font-size:12px; text-transform:uppercase; font-weight:700; ">
								  <?=$data->PBI_NAME?>
								</span>
								<br>
								<? if ($data->PBI_RESIDENT==1 || $data->PBI_RESIDENT==3  ) { ?>
								<span style="font-size:10px; font-weight:700; color:#FF0000;">
								  (Residential)								</span>
								<? } ?>								</td>
							</tr>
							<tr width="100%" align="left" class="noBorder" style="margin:0; padding:0;">
								<td  style="font-size:10px" align="left"  >Unit</td>
						        <td  style="font-size:8px" align="left"  >:&nbsp;<?=find_a_field('user_group','company_name','id='.$data->PBI_ORG)?></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%" style="font-size:10px"  >Dept.</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=find_a_field('department','DEPT_DESC','DEPT_ID='.$data->PBI_DEPARTMENT)?></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td   width="8%" style="font-size:10px"  >Desg.</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=find_a_field('designation','DESG_DESC','DESG_ID='.$data->PBI_DESIGNATION)?></td>
							</tr>

							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%" style="font-size:10px; color:#FF0000"  >ID No</td>

							    <td width="92%" style="font-size:15px; color:#FF0000; font-weight:700;">:&nbsp;
								<span ><?=$data->PBI_CODE?></span></td>
							</tr>
							<tr width="100%"  align="left" class="noBorder">
								<td   width="8%" style="font-size:10px"  >Join</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=date("d-m-Y",strtotime($data->PBI_DOJ));?></td>
							</tr>

							<tr width="100%"  align="left" class="noBorder">
								<td  width="8%"  style="font-size:8px" >Blood</td>

							    <td width="92%" style="font-size:10px" >:&nbsp;<?=$data->ESSENTIAL_BLOOD_GROUP?></td>
							</tr>




							<tr width="100%"  align="center"  class="noBorder">

								<td colspan="3">
								  <?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>								</td>
							</tr>
						 </table>
					</td>
				</tr>

		   </table>
	   </td>
	  <? if(($ig%3)==0){ $pg++; ?></tr><tr style="display:block; width:100%; <? if(($pg%3)==0){?>page-break-after:always; <? }?>"><? }?>


	  <? } ?>
  </table>

</div>
<br /><br /><br /><br />

<? }











elseif($_POST['report']==771702901){ // Parking Card info
?><table border="1" cellpadding="100" align="center"><tr style="position:relative;display:block; width:100%; float: none;  ">
<?
if($_POST['branch']!='') $con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

  $sql22="SELECT a.*
FROM personnel_basic_info a, hrm_residential r
WHERE a.PBI_RESIDENT=r.id ".$con."
order by a.PBI_ID  ";

$res = db_query($sql22);
	$ig=0;$pg=-2; while($data=mysqli_fetch_object($res)){



		  $barcode_content = $data->EMP_CODE;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=30;
          $printText='';



?>

<? $ig++;?>


       <td style="width:220px;" >
		   <table width="100%"  border="0" bordercolor="#FFFFFF" style="height:310px; " >
		   		<tr width="100%" border="0" bordercolor="#FFFFFF" >
					<td width="100%"  border="0" bordercolor="#FFFFFF" style="border-bottom: 1px solid #fff; border-right: 1px solid #fff; border-left: 1px solid #fff;">
						 <table  width="100%"  border="0" bordercolor="#FFFFFF">


							<tr align="center" class="noBorder">
								<td align="center"><img style="float:right;" src="images/faridgrouplogo.jpg" width="190" /></td>
							</tr>



							<tr align="center" class="noBorder">
								<td colspan="2" >															</td>
							</tr>

							<tr width="100%"  align="center" class="noBorder">
								<td colspan="2" >								</td>
							</tr>
							<tr width="100%" align="left" class="noBorder"  height="230" style="margin:0; padding:0;">
								<td  width="8%" align="center"  style="font-size:26px; font-weight:700;"  >Parking : <?=$data->barcode_id?></td>
						    </tr>






						 </table>
					</td>
				</tr>

		   </table>
	   </td>
	  <? if(($ig%3)==0){ $pg++; ?></tr><tr style="display:block; width:100%; <? if(($pg%3)==0){?>page-break-after:always; <? }?>"><? }?>


	  <? } ?>
  </table>

</div>
<br /><br /><br /><br />

<? }









elseif($_POST['report']==7719){ // salary payslip view
?><table border="1"  cellpadding="100"  align="center"><tr style="position:relative;display:block; width:100%; float: none; ">
<?
if($_POST['branch']!='') $con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

  echo $sql22="SELECT a.*
FROM personnel_basic_info a  WHERE 1 ".$con."
order by a.PBI_ID  limit 9";

$res = db_query($sql22);
	$ig=0;$pg=-2; while($data=mysqli_fetch_object($res)){






?>

<? $ig++;?>


       <td style="width:220px;">
		   <table width="100%"    border="0" bordercolor="#FFFFFF" style="height:310px; ">
		   		<tr width="100%"   border="0" bordercolor="#FFFFFF" >
					<td width="100%"   border="0" bordercolor="#FFFFFF" style="border-bottom: 1px solid #fff; border-right: 1px solid #fff; border-left: 1px solid #fff;" >
						 <table  width="100%"  border="0"  bordercolor="#FFFFFF">


							<tr align="left" class="noBorder">
								<td>
					 			১. ডিউটি চলাকালিন সময়ে আইডি কার্ড অবশ্যই প্রদর্শন করিতে হইবে।
					 </td>
							</tr>

							<tr align="left" class="noBorder">
								<td>
					 			২. অবসর গ্রহন অথবা অব্যহতির সময় আইডি কার্ড অবশ্যই প্রশাসনের প্রধানের নিকট প্রদান করিতে হইবে।
					 </td>
							</tr>

							<tr align="left" class="noBorder">
								<td>
					 			৩. আইডি কার্ড নষ্ট হয়ে গেলে অথবা হারিয়ে গেলে নিকটবর্তী পুলিশ ষ্টেশন এবং কোম্পানির প্রশাসনের প্রধান কে জানাতে হইবে।
					 </td>
							</tr>

							<tr align="center" class="noBorder">
								<td>
					 			<img  src="images/signature.jpg" width="80" height="auto"/>

								<p style="text-align: center; margin:0; padding: 4px 0 0 0; font-size: 14px; font-weight:bold;">কর্তৃপক্ষের স্বাক্ষর </p>
					 </td>
							</tr>

							<tr align="center" class="noBorder">
								<td style="font-weight:700; font-size:14px;">
					 			ফরিদ গ্রুপ
					 </td>
							</tr>

							<tr align="center" class="noBorder">
								<td>
					 			প্লট - ১৯/বি,বিসিক, কুমিল্লা - ৩৫০০, বাংলাদেশ।
					 </td>
							</tr>

							<tr align="center" class="noBorder">
								<td>
					 			ফোনঃ ০৮১-৭৭২৩৩, ৭৭২৪৬
					 </td>
							</tr>

							<tr align="center" class="noBorder">
								<td>
					 			ওয়েব সাইটঃ www.faridgroupbd.com
					 </td>
							</tr>

							<tr align="center" class="noBorder">
								<td>
					 			ই-মেইলঃ info@faridgroupbd.com
					 </td>
							</tr>


						 </table>
					</td>
				</tr>

		   </table>
	   </td>
	  <? if(($ig%3)==0){ $pg++; ?></tr><tr style="position:relative;display:block; width:100%; float: none; <? if(($pg%3)==0){?>page-break-after:always; page-break-inside:avoid<? }?>"><? }?>


	  <? } ?>
  </table>
</div>
<br /><br /><br /><br />

<? }









elseif($_POST['report']==7718){ // salary payslip view

if($_POST['branch']!='') $con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

  $sql22="SELECT a.*
FROM personnel_basic_info a, hrm_residential r
WHERE a.PBI_RESIDENT=r.id ".$con."
order by a.PBI_ID ";

$res = db_query($sql22);
	$ig=-1; while($data=mysqli_fetch_object($res)){



		   $barcode_content = $data->EMP_CODE;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=30;
          $printText='';



?>
<div <? if(($ig%4)==0&&($ig>3)) echo 'style="position:relative;display:block; width:100%; float: none; page-break-after:always; page-break-inside:avoid"'; ?>>
<? $ig++;?>




<table  width="100%" border="1">




      <tr>
       <td >
		   <table width="80%" border="1">
		   		<tr>

					<td width="50%">
						 <table width="100%" border="1">


							<tr align="center" class="noBorder">
								<td width="40%" align="right"><img style="border-radius: 50%; float:right;" src="images/idlogo.png" width="50" height="50"/></td>

								<td width="40%" colspan="3" align="left" >

								<span style="font-size:24px; font-weight:700; ">

								ফরিদ গ্রুপ</span>	</td>
								<td width="20%">&nbsp;</td>
							</tr>



							<tr align="center" class="noBorder">
								<td colspan="3" >
									<img src="../../pic/staff/<?=$data->PBI_ID?>.jpeg" width="auto" height="60"/>								</td>
							</tr>

							<tr align="center" class="noBorder">
								<td colspan="3" ><span class="style19">
								  <?=$data->PBI_NAME_BANGLA?>
								</span></td>
							</tr>
							<tr align="left" class="noBorder">
								<td width="15%" style="font-size:12px"  >ইউনিট</td>
							    <td width="5%" >:</td>
							    <td width="80%" style="font-size:12px" ><?=find_a_field('user_group','name_bangla','id='.$data->PBI_ORG)?></td>
							</tr>
							<tr align="left" class="noBorder">
								<td width="15%" style="font-size:12px"  >বিভাগ</td>
							    <td width="5%" >:</td>
							    <td width="80%" style="font-size:12px" ><?=find_a_field('department','DEPT_NAME_BANGLA','DEPT_ID='.$data->PBI_DEPARTMENT)?></td>
							</tr>
							<tr align="left" class="noBorder">
								<td width="15%" style="font-size:12px"  >পদবী</td>
							    <td width="5%" >:</td>
							    <td width="80%" style="font-size:12px" ><?=find_a_field('designation','DESG_NAME_BANGLA','DESG_ID='.$data->PBI_DESIGNATION)?></td>
							</tr>
							<tr align="left" class="noBorder">
								<td width="15%" style="font-size:12px"  >আইডি নং</td>
							    <td width="5%" >:</td>
							    <td width="80%" style="font-size:12px"><?=$data->PBI_CODE?></td>
							</tr>
							<tr align="left" class="noBorder">
								<td width="15%" style="font-size:12px"  >যোগদান</td>
							    <td width="5%" >:</td>
							    <td width="80%" style="font-size:12px" ><?=date("d-m-Y",strtotime($data->PBI_DOJ));?></td>
							</tr>

							<tr align="left" class="noBorder">
								<td width="15%" style="font-size:12px" >রক্তের গ্রুপ</td>
							    <td width="5%" >:</td>
							    <td width="80%" style="font-size:12px" ><?=$data->ESSENTIAL_BLOOD_GROUP?></td>
							</tr>



							<tr align="center" class="noBorder">
								<td colspan="3" >
								  &nbsp;&nbsp;&nbsp;<?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>&nbsp;&nbsp;&nbsp;
								</td>
							</tr>


						 </table>
					</td>



					<td width="50%">
						 <table width="100%" border="1" style="font-size:12px;">

						 	<tr align="left" class="noBorder">
								<td>
					 			১. ডিউটি চলাকালিন সময়ে আইডি কার্ড অবশ্যই প্রদর্শন করিতে হইবে।
					 </td>
							</tr>

							<tr align="left" class="noBorder">
								<td>
					 			২. অবসর গ্রহন অথবা অব্যহতির সময় আইডি কার্ড অবশ্যই প্রশাসনের প্রধানের নিকট প্রদান করিতে হইবে।
					 </td>
							</tr>

							<tr align="left" class="noBorder">
								<td>
					 			৩. আইডি কার্ড নষ্ট হয়ে গেলে অথবা হারিয়ে গেলে নিকটবর্তী পুলিশ ষ্টেশন এবং কোম্পানির প্রশাসনের প্রধান কে জানাতে হইবে।
					 </td>
							</tr>

							<tr align="left" class="noBorder">
								<td>
					 			হারিয়ে যাওয়া কার্ডটি ব্যবহারকারী ব্যতীত অন্য কোথাও পাওয়া গেলে নিন্ম ঠিকানায় যোগাযোগ করার জন্য অনুরোধ করা গেল।
					 </td>
							</tr>

							<tr align="center" class="noBorder">
								<td>
					 			ফরিদ গ্রুপ
					 </td>
							</tr>

							<tr align="center" class="noBorder">
								<td>
					 			প্লট - ১৯/বি,বিসিক, কুমিল্লা - ৩৫০০, বাংলাদেশ।
					 </td>
							</tr>

							<tr align="center" class="noBorder">
								<td>
					 			ফোনঃ ০৮১-৭৭২৩৩, ৭৭২৪৬
					 </td>
							</tr>

							<tr align="center" class="noBorder">
								<td>
					 			ওয়েব সাইটঃ www.faridgroupbd.com
					 </td>
							</tr>

							<tr align="center" class="noBorder">
								<td>
					 			ই-মেইলঃ info@faridgroupbd.com
					 </td>
							</tr>
						</table>
					</td>
				</tr>

		   </table>
	   </td>


      </tr>








	  <? } ?>
  </table>
</div>
<br /><br /><br /><br />

<? }






elseif($_POST['report']==77)
{
?><table border="0" cellpadding="2" cellspacing="0"><thead><tr><th style="border:0px;" colspan="37"><?=$str?></th></tr>

<tr>
<th rowspan="3">S/L</th>
<th rowspan="3">CODE</th>
<th rowspan="3"><div>Full Name</div></th>
<th rowspan="3"><img src="images/desgnation.jpg" /></th>
<th rowspan="3"><img src="images/joining_date.jpg" alt="" /></th>
<th rowspan="3">Bank AC#</th>
<th rowspan="3">Work Place</th>
<th colspan="6"><div>Monthly Attendence Record</div></th>
<th colspan="3">Basic Information </th>
<th colspan="5"><div>Accrued Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction </div></th>
<th colspan="6"><div>Payable Amount (Taka) </div></th>
<th colspan="3"><div>View Only </div></th>
<th rowspan="3">Remarks</th>
</tr>
<tr class="vertical-text">
  <th rowspan="2"><img src="images/present.jpg" /></th>
  <th rowspan="2"><img src="images/weekend.jpg" /></th>
  <th rowspan="2"><img src="images/leave.JPG" /></th>
  <th rowspan="2"><img src="images/lwp.jpg" /></th>
  <th rowspan="2"><img src="images/absent.JPG" /></th>
  <th rowspan="2"><img src="images/payable_days.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/arear.JPG" /></th>
  <th rowspan="2"><img src="images/other.JPG" /></th>
  <th rowspan="2"><img src="images/ait.JPG" /></th>
  <th rowspan="2"><img src="images/advance_salary.JPG" /></th>
  <th rowspan="2"><img src="images/co-op-fund.JPG" /></th>
  <th rowspan="2"><img src="images/bike.JPG" /></th>
  <th rowspan="2"><img src="images/excess_mobile.JPG" /></th>
  <th rowspan="2"><img src="images/administrative.JPG" /></th>
  <th rowspan="2">H-Up</th>
  <th rowspan="2"><img src="images/cash.JPG" /></th>
  <th colspan="3">BANK</th>
  <th rowspan="2"><img src="images/total_salary.JPG" /></th>
  <th rowspan="2"><img src="images/last_salary.JPG" /></th>
  <th rowspan="2"><img src="images/diff.JPG" /></th>

  <th rowspan="2"><img src="images/absent_lwp.JPG" /></th>
</tr>
<tr class="vertical-text">
  <th>DBBL</th>
  <th>Rocket</th>
  <th>IBBL</th>
</tr>
</thead>
<tbody>
<?
/////d.DESG_ID=t.pbi_designation and  is cut from this query replace by group by a.PBI_ID
 $sqld = 'select
t.basic_salary actual_basic_salary,
t.special_allowance actual_special_allawance,
t.*,a.PBI_ID,a.PBI_NAME,d.DESG_DESC PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ,  t.pbi_held_up held_up_status,s.cash_bank,s.cash

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where  t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID '.$con.'
group by a.PBI_ID order by a.PBI_ID';
$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
<td><?=$data->PBI_ID?></td>
<td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_DESIGNATION?></td>
  <td><?=date('d-m-Y',strtotime($data->PBI_DOJ));?></td>
  <td><?=$data->cash?></td>
  <td><?  $res = "select concat(a.AREA_NAME,'-',d.dealer_code,'-',d.dealer_name_e) dealer from area a, dealer_info d where a.AREA_CODE=d.area_code and d.dealer_code=".$data->dealer_code;
		  $resq = @db_query($res);
		  $res_data = @mysqli_fetch_object($resq); echo $res_data->dealer; ?></td>
  <td><?=$data->pre?></td>
  <td><?=$data->od?></td>
  <td><?=$data->lv?></td>
  <td><?=$data->lwp?></td>
  <td><?=$data->ab?></td>
  <td><?=$data->pay?></td>
  <td><?=number_format($data->actual_basic_salary)?><? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?></td>
  <td><?=number_format($data->spl_alw_data)?><? $total_spl_alw_data = $total_spl_alw_data + $data->spl_alw_data;?></td>


  <td><?=number_format($data->ta_da_data)?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?></td>
  <td><?=number_format($data->basic_salary_payable)?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?></td>

  <td><?=number_format($data->actual_special_allawance)?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?></td>

  <td><?=number_format($data->ta_da)?><? $total_ta_da = $total_ta_da + $data->ta_da;?></td>
  <td><?=number_format($data->benefits)?><? $total_benefits = $total_benefits + $data->benefits;?></td>
  <td><?=number_format($data->other_benefits)?><? $total_other_benefits = $total_other_benefits + $data->other_benefits;?></td>
  <td><?=number_format($data->income_tax)?><? $total_income_tax = $total_income_tax + $data->income_tax;?></td>
  <td><?=number_format(($data->advance_install+$data->other_install))?><? $total_advance_install = $total_advance_install + ($data->advance_install+$data->other_install);?></td>

  <td><?=number_format($data->cooperative_share)?><? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?></td>
  <td><?=number_format($data->motorcycle_install)?><? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?></td>
  <td><?=number_format($data->deduction)?><? $total_deduction = $total_deduction + $data->deduction;?></td>
  <td><?=number_format($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

<td><? if($data->held_up_status=='1'){echo $data->total_payable; $total_held_up = $total_held_up + $data->total_payable;}?></td>
<td><? if($data->held_up_status=='0'){$cash_payment = $data->total_payable-$data->bank_paid; echo number_format($cash_payment); $total_cash_payment = $total_cash_payment + $cash_payment;} ?></td>
<td><? if($data->held_up_status=='0'){if($data->bank_name=='DBBL'){ echo number_format($data->bank_paid); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $data->bank_paid;}}?></td>
<td><? if($data->held_up_status=='0'){if($data->bank_name=='ROCKET'){ echo number_format($data->bank_paid); $total_bank_payment_rocket = $total_bank_payment_rocket + $data->bank_paid;}}?></td>
<td><? if($data->held_up_status=='0'){if($data->bank_name=='IBBL'){echo number_format($data->bank_paid);  $total_bank_payment_ibbl = $total_bank_payment_ibbl + $data->bank_paid; }}?></td>
<td><span style="text-align:right; font-weight:bold;"><?php if($data->held_up_status=='0'){echo number_format($data->total_payable); $total_cash = $total_cash + $data->total_payable;}?></span></td>
  <td><?php
  if($_POST['mon']==1){$p_mon=12;}else{$p_mon=($_POST['mon']-1);}
  if($_POST['mon']==1){$p_yr=($_POST['year']-1);}else{$p_yr=$_POST['year'];}
  echo $pre_salry=find_a_field('salary_attendence','total_payable','PBI_ID="'.$data->PBI_ID.'" and mon="'.$p_mon.'" and year="'.$p_yr.'" ');
  ?></td>
  <td><? echo $differ_last = ($data->total_payable-$pre_salry); $differ_last_all = $differ_last_all + $differ_last; ?></td>
    <td><span style="text-align:right">
    <?=(int)$data->absent_deduction?>
  </span></td>

  <td style="color:#FF0000; font-weight:bold"><?=($data->held_up_status=='1')?'Held-Up':''?></td>
</tr>
<?
}
?>
<tr>
  <td colspan="13"><?=convertNumberMhafuz($total_cash);?></td>
  <td><strong><?=$total_actual_basic_salary;?></strong></td>
  <td><strong><?=$total_spl_alw_data;?></strong></td>

  <td><strong><?=$total_ta_da_data;?></strong></td>
  <td><strong><?=(int)$total_basic_salary_payable;?></strong></td>
  <td><strong><?=$total_actual_special_allawance;?></strong></td>
  <td><strong><?=$total_ta_da;?></strong></td>
  <td><strong><?=$total_benefits;?></strong></td>
  <td><strong><?=$total_other_benefits;?></strong></td>
  <td><strong><?=$total_income_tax;?></strong></td>
  <td><strong><?=$total_advance_install;?></strong></td>
  <td><strong><?=$total_cooperative_share;?></strong></td>
  <td><strong><?=$total_motorcycle_install;?></strong></td>
  <td><strong><?=$total_deduction;?></strong></td>
  <td><strong><?=$total_administrative_deduction ;?></strong></td>
  <td><?=$total_held_up?></td>
  <td><strong><?=$total_cash_payment?></strong></td>
  <td><? echo (int)$total_bank_payment_dbbl;?></td>
  <td><? echo (int)$total_bank_payment_rocket;?></td>
  <td><? echo (int)$total_bank_payment_ibbl;?></td>
  <td><strong><?=$total_cash?></strong></td>
  <td>&nbsp;</td>
  <td><strong><?=$differ_last_all?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}



elseif($_POST['report']==781)
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="7"><?=$str?></th></tr>

<tr>
  <th>S/L</th>
  <th>CODE</th>
  <th>Full Name</th>
  <th>Designation</th>
  <th>Group</th>
  <th><?=$_POST['cash_bank']?> AC#</th>
  <th>Transfer to <?=$_POST['cash_bank']?></th>
  </tr>
</thead>
<tbody>
<?
//================================= and d.DESG_ID=t.pbi_designation cut from this query======//
$bank = $_POST['cash_bank'];
echo $sqld = 'select
s.basic_salary actual_basic_salary,
s.special_allowance actual_special_allawance,
t.*,a.PBI_ID,a.PBI_NAME,a.PBI_GROUP,d.DESG_SHORT_NAME PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ,
t.pbi_held_up held_up_status,s.cash_bank,s.cash

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s
where t.pbi_held_up=0 and s.cash_bank="'.$bank.'"
and t.mon='.$_POST['mon'].'
and t.year='.$_POST['year'].'
and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID '.$con.'
order by (t.consolidated_salary+t.basic_salary) desc';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
<td><?=$data->PBI_ID?></td>
<td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_DESIGNATION?></td>
  <td><?=$data->PBI_GROUP?></td>
  <td><?=$data->cash?></td>
  <td><? if($data->held_up_status=='0'){if($data->cash_bank==$bank){ echo number_format($data->bank_paid);
  $total_bank_payment_dbbl = $total_bank_payment_dbbl + $data->bank_paid;}}?></td>
</tr>
<?
}
?>
<tr>
  <td colspan="6"><?=convertNumberMhafuz($total_bank_payment_dbbl);?></td>
  <td><? echo (int)$total_bank_payment_dbbl;?></td>
  </tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}

elseif($_POST['report']==785) {

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="7"><?=$str?></th></tr>

<tr>
  <th>S/L</th>
  <th>CODE</th>
  <th>Full Name</th>
  <th>Designation</th>
  <th>Group</th>
  <th><?=$_POST['cash_bank']?> AC#</th>
  <th>Transfer to <?=$_POST['cash_bank']?></th>
  </tr>
</thead>
<tbody>
<?
$bank = $_POST['cash_bank'];

$sqld = 'select
t.*,t.pbi_held_up held_up_status,
a.PBI_ID,a.PBI_NAME,a.PBI_GROUP,d.DESG_SHORT_NAME PBI_DESIGNATION ,a.PBI_DEPARTMENT,s.cash_bank,s.cash

from  salary_bonus t, personnel_basic_info a, designation d, salary_info s
where
t.PBI_ID=a.PBI_ID
and t.PBI_ID=s.PBI_ID
and d.DESG_SHORT_NAME=a.pbi_designation
and d.DESG_SHORT_NAME=t.pbi_designation

and t.pbi_held_up=0
and s.cash_bank="'.$bank.'"
and t.bonus_type='.$_POST['bonus_type'].'
and t.year='.$_POST['year'].'
and t.bank_paid>0

'.$con.'
group by a.PBI_ID
order by a.PBI_ID';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
<td><?=$data->PBI_ID?></td>
<td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_DESIGNATION?></td>
  <td><?=$data->PBI_GROUP?></td>
  <td><?=$data->cash?></td>
  <td><? if($data->held_up_status=='0'){
  			if($data->cash_bank==$bank){ echo number_format($data->bank_paid);
  				$total_bank_payment_dbbl = $total_bank_payment_dbbl + $data->bank_paid;}}

	   ?></td>
</tr>
<?
}
?>
<tr>
  <td colspan="6"><?=convertNumberMhafuz($total_bank_payment_dbbl);?></td>
  <td><strong><? echo (int)$total_bank_payment_dbbl;?></strong></td>
  </tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}



elseif($_POST['report']==786) {

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="7"><?=$str?></th></tr>

<tr>
  <th>S/L</th>
  <th>CODE</th>
  <th>Full Name</th>
  <th>Designation</th>
  <th>Group</th>
  <th>IBBL AC#</th>
  <th>Transfer to IBBL</th>
  </tr>
</thead>
<tbody>
<?
$bank = 'IBBL';

$sqld = 'select
t.*,t.pbi_held_up held_up_status,
a.PBI_ID,a.PBI_NAME,a.PBI_GROUP,d.DESG_SHORT_NAME PBI_DESIGNATION ,a.PBI_DEPARTMENT,s.cash_bank,s.cash

from  salary_bonus t, personnel_basic_info a, designation d, salary_info s
where
t.PBI_ID=a.PBI_ID
and t.PBI_ID=s.PBI_ID
and d.DESG_SHORT_NAME=a.pbi_designation
and d.DESG_SHORT_NAME=t.pbi_designation

and t.pbi_held_up=0
and s.cash_bank="'.$bank.'"
and t.bonus_type='.$_POST['bonus_type'].'
and t.year='.$_POST['year'].'
and t.bank_paid>0

'.$con.'
group by a.PBI_ID
order by a.PBI_ID';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
<td><?=$data->PBI_ID?></td>
<td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_DESIGNATION?></td>
  <td><?=$data->PBI_GROUP?></td>
  <td><?=$data->cash?></td>
  <td><? if($data->held_up_status=='0'){
  			if($data->cash_bank==$bank){ echo number_format($data->bank_paid);
  				$total_bank_payment_dbbl = $total_bank_payment_dbbl + $data->bank_paid;}}

	   ?></td>
</tr>
<?
}
?>
<tr>
  <td colspan="6"><?=convertNumberMhafuz($total_bank_payment_dbbl);?></td>
  <td><strong><? echo (int)$total_bank_payment_dbbl;?></strong></td>
  </tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==7811)
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="7"><?=$str?></th></tr>

<tr>
  <th>S/L</th>
  <th>CODE</th>
  <th>Full Name</th>
  <th>Designation</th>
  <th>Group</th>
  <th>Co-Operative Code </th>
  <th>Amount</th>
  </tr>
</thead>
<tbody>
<?
 $sqld = 'select a.co_operative_code, t.*, a.PBI_ID, a.PBI_NAME, a.PBI_GROUP, d.DESG_SHORT_NAME PBI_DESIGNATION , a.PBI_DEPARTMENT, a.PBI_DOJ

from  salary_attendence t, personnel_basic_info a, designation d
where t.cooperative_share>0 and d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID '.$con.' order by (t.consolidated_salary+t.basic_salary) desc';
$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
<td><?=$data->PBI_ID?></td>
<td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_DESIGNATION?></td>
  <td><?=$data->PBI_GROUP?></td>
  <td><?=$data->co_operative_code?></td>
  <td><?=$data->cooperative_share; $total+=$data->cooperative_share;?></td>
</tr>
<?
}
?>
<tr>
  <td colspan="6"><?=convertNumberMhafuz($total);?></td>
  <td><? echo $total;?></td>
  </tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==782)
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
    <tr>
      <th style="border:0px;" colspan="8"><?=$str?></th>
    </tr>
    <tr>
      <th>S/L</th>
      <th>AC#</th>
      <th>CODE</th>
      <th>Full Name</th>
      <th>IBBL AC#</th>
      <th>Branch</th>
      <th>Branch Code</th>
      <th>Transfer to IBBL</th>
    </tr>
  </thead>
  <tbody>
    <?
$sqld = 'select
s.basic_salary actual_basic_salary,
s.special_allowance actual_special_allawance,
t.*,a.PBI_ID,a.PBI_NAME,a.PBI_GROUP,d.DESG_SHORT_NAME PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ,  t.pbi_held_up held_up_status,s.cash_bank,s.cash,s.branch_info

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s
where t.pbi_held_up=0 and s.cash_bank="IBBL" and d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID '.$con.' order by (t.consolidated_salary+t.basic_salary) desc';
$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
    <tr>
      <td><?=++$s?></td>
      <td><font color="#FFFFFF">'</font><?=$data->cash?></td>
      <td><?=$data->PBI_ID?></td>
      <td><?=$data->PBI_NAME?></td>
      <td><font color="#FFFFFF">'</font><?=$data->cash?></td>
      <td><?=$data->branch_info?></td>
      <td>&nbsp;</td>
      <td><? echo number_format($data->bank_paid); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $data->bank_paid;?></td>
    </tr>
    <?
}
?>
    <tr>
      <td colspan="5"><?=convertNumberMhafuz($total_bank_payment_dbbl);?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><? echo (int)$total_bank_payment_dbbl;?></td>
    </tr>
  </tbody>
</table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==78) // Salary Payroll Report Final
{

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="41"><?=$str?></th></tr>

<tr>

<th rowspan="2">S/L</th>
<th rowspan="2">CODE</th>
<th rowspan="2"><div>Full Name</div></th>
<th rowspan="2"><img src="images/desgnation.jpg" /></th>
<th rowspan="2"><img src="images/joining_date.jpg" alt="" /></th>
<th rowspan="2">Bank AC#</th>
<th colspan="8"><div>Monthly Attendence Record</div></th>
<th colspan="3">Basic Information </th>
<th colspan="9"><div>Accrued Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction</div></th>
<th colspan="4"><div>Payable Amount (Taka) </div></th>
<th colspan="4"><div>View Only </div></th>
<th rowspan="2">Remarks</th>
</tr>
<tr class="vertical-text">
  <th><img src="images/present.jpg" /></th>
  <th><img src="images/weekend.jpg" /></th>
  <th><img src="images/festival.jpg" /></th>
  <th><img src="images/leave.JPG" /></th>
  <th><img src="images/late.JPG" /></th>
  <th><img src="images/lwp.jpg" /></th>
  <th><img src="images/absent.JPG" /></th>
  <th><img src="images/payable_days.JPG" /></th>
  <th><img src="images/salary.jpg" /></th>
  <th><img src="images/special_allowance.JPG" /></th>
  <th><img src="images/ta_da.JPG" /></th>
  <th><img src="images/salary.jpg" /></th>
  <th><img src="images/special_allowance.JPG" /></th>
  <th><img src="images/ta_da.JPG" /></th>
  <th><img src="images/house_rent.JPG" /></th>
  <th><img src="images/car.JPG" /></th>
  <th><img src="images/food.JPG" /></th>
  <th><img src="images/mobile.JPG" /></th>
  <th><img src="images/arear.JPG" /></th>
  <th><img src="images/other.JPG" /></th>
  <th><img src="images/ait.JPG" /></th>
  <th><img src="images/advance_salary.JPG" /></th>
  <th><img src="images/co-op-fund.JPG" /></th>
  <th><img src="images/bike.JPG" /></th>
  <th><img src="images/excess_mobile.JPG" /></th>
  <th><img src="images/administrative.JPG" /></th>
  <th>H-Up</th>
  <th><img src="images/cash.JPG" /></th>
  <th><img src="images/bank_payment.JPG" /></th>
  <th><img src="images/total_salary.JPG" /></th>
  <th><img src="images/last_salary.JPG" /></th>
  <th><img src="images/diff.JPG" /></th>
  <th><img src="images/late_attendence.JPG" /></th>
  <th><img src="images/absent_lwp.JPG" /></th>
</tr>
</thead>
<tbody>
<?
$sqld = 'select
t.basic_salary actual_basic_salary,
t.spl_alw_data actual_special_allawance,
t.*,a.PBI_ID,a.PBI_NAME,d.DESG_DESC PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ,  t.pbi_held_up held_up_status,s.cash_bank,s.cash

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID '.$con.'
ORDER BY
a.pbi_grade desc,
(t.consolidated_salary+t.basic_salary) desc
';
// ,a.PBI_DESG_GRADE
// a.PBI_DESG_GRADE asc,(t.consolidated_salary+t.basic_salary) desc';
$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
<td><?=$data->PBI_ID?></td>
<td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_DESIGNATION?></td>
  <td><?=date('d-m-Y',strtotime($data->PBI_DOJ));?></td>
  <td><?=$data->cash?></td>
  <td><?=$data->pre?></td>
  <td><?=$data->od?></td>
  <td><?=$data->hd?></td>
  <td><?=$data->lv?></td>
  <td><?=$data->lt?></td>
  <td><?=$data->lwp?></td>
  <td><?=$data->ab?></td>
  <td><?=$data->pay?></td>
  <td><?=(int)$data->actual_basic_salary?><? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?></td>
  <td><?=(int)$data->actual_special_allawance?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?></td>
  <td><?=$data->ta_da_data?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?></td>
  <td><?=(int)$data->basic_salary_payable?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?></td>
  <td><?=(int)$data->special_allowance?><? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance;?></td>
  <td><?=$data->ta_da?><? $total_ta_da = $total_ta_da + $data->ta_da;?></td>
  <td><?=round($data->house_rent)?><? $total_house_rent = $total_house_rent + $data->house_rent;?></td>
  <td><?=round($data->vehicle_allowance)?><? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance;?></td>
  <td><?=$data->food_allowance?><? $total_food_allowance = $total_food_allowance + $data->food_allowance;?></td>
  <td><?=$data->mobile_allowance?><? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance;?></td>

  <td><?=$data->benefits?><? $total_benefits = $total_benefits + $data->benefits;?></td>
  <td><?=$data->other_benefits?><? $total_other_benefits = $total_other_benefits + $data->other_benefits;?></td>
  <td><?=$data->income_tax?><? $total_income_tax = $total_income_tax + $data->income_tax;?></td>
  <td><?=($data->advance_install+$data->other_install)?><? $total_advance_install = $total_advance_install + ($data->advance_install+$data->other_install);?></td>

  <td><?=$data->cooperative_share?><? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?></td>
  <td><?=$data->motorcycle_install?><? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?></td>
  <td><?=$data->deduction?><? $total_deduction = $total_deduction + $data->deduction;?></td>
  <td><?=number_format($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

<td><? if($data->held_up_status=='1'){echo $data->total_payable; $total_held_up = $total_held_up + $data->total_payable;}?></td>
<td><? if($data->held_up_status=='0'){$cash_payment = $data->total_payable-$data->bank_paid; echo number_format($cash_payment); $total_cash_payment = $total_cash_payment + $cash_payment;} ?></td>
  <td><? if($data->held_up_status=='0'){echo number_format($data->bank_paid);  $total_bank_payment = $total_bank_payment + $data->bank_paid;}?></td>
  <td><span style="text-align:right; font-weight:bold;"><?php if($data->held_up_status=='0'){echo $data->total_payable; $total_cash = $total_cash + $data->total_payable;}?></span></td>
  <td><?php
  if($_POST['mon']==1){$p_mon=12;}else{$p_mon=($_POST['mon']-1);}
  if($_POST['mon']==1){$p_yr=($_POST['year']-1);}else{$p_yr=$_POST['year'];}
  echo $pre_salry=find_a_field('salary_attendence','total_payable','PBI_ID="'.$data->PBI_ID.'" and mon="'.$p_mon.'" and year="'.$p_yr.'" ');
  ?></td>
  <td><? echo $differ_last = ($data->total_payable-$pre_salry); $differ_last_all = $differ_last_all + $differ_last; ?></td>
  <td><span style="text-align:right"><?=(int)$data->late_deduction?></span></td>
  <td><span style="text-align:right"><?=(int)$data->absent_deduction?></span></td>
  <td style="color:#FF0000; font-weight:bold"><?=($data->held_up_status=='1')?'Held-Up':''?></td>
</tr>
<?
}
?>
<tr>
  <td colspan="14"><?=convertNumberMhafuz($total_cash);?></td>
  <td><strong><?=$total_actual_basic_salary;?></strong></td>
  <td><strong><?=$total_actual_special_allawance;?></strong></td>
  <td><strong><?=$total_ta_da_data;?></strong></td>
  <td><strong><?=(int)$total_basic_salary_payable;?></strong></td>
  <td><strong><?=$total_spl_alw_data;?></strong></td>
  <td><strong><?=$total_ta_da;?></strong></td>
  <td><strong><?=round($total_house_rent);?></strong></td>
  <td><strong><?=round($total_vehicle_allowance);?></strong></td>
  <td><strong><?=$total_food_allowance;?></strong></td>
  <td><strong><?=$total_mobile_allowance;?></strong></td>
  <td><strong><?=$total_benefits;?></strong></td>
  <td><strong><?=$total_other_benefits;?></strong></td>
  <td><strong><?=$total_income_tax;?></strong></td>
  <td><strong><?=$total_advance_install;?></strong></td>
  <td><strong><?=$total_cooperative_share;?></strong></td>
  <td><strong><?=$total_motorcycle_install;?></strong></td>
  <td><strong><?=$total_deduction;?></strong></td>
  <td><strong><?=$total_administrative_deduction;?></strong></td>
  <td><?=$total_held_up?></td>
  <td><strong><?=$total_cash_payment?></strong></td>
  <td><strong><?=$total_bank_payment?></strong></td>
  <td><strong><?=$total_cash?></strong></td>
  <td>&nbsp;</td>
  <td><strong><?=$differ_last_all?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==783){ // Zone Wise Sales Salary Brief Report


$sqld = 'select t.pbi_region PBI_BRANCH,a.PBI_ZONE,count(a.PBI_ID) nos,
sum(s.basic_salary) actual_basic_salary,
sum(s.special_allowance) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,
sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 '.$PBI_GROUP_con.' group by t.pbi_region ,a.PBI_ZONE';
$queryd=db_query($sqld);
while($i=mysqli_fetch_object($queryd))
{
$nos[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->nos;
$actual_basic_salary[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->actual_basic_salary;
$actual_special_allawance[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->actual_special_allawance;
$basic_salary_payable[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->basic_salary_payable;
$special_allowance[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->special_allowance;
$ta_da_data[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->ta_da_data;
$ta_da[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->ta_da;
$house_rent[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->house_rent;
$vehicle_allowance[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->vehicle_allowance;
$food_allowance[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->food_allowance;
$mobile_allowance[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->mobile_allowance;
$benefits[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->benefits;
$other_benefits[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->other_benefits;
$income_tax[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->income_tax;
$total_install[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->total_install;
$cooperative_share[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->cooperative_share;
$motorcycle_install[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->motorcycle_install;
$deduction[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->deduction;
$absent_deduction[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->absent_deduction;
$held_up_status[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->held_up_status;
$cash_bank[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->cash_bank;
}
$sqld = 'select t.pbi_region PBI_BRANCH,a.PBI_ZONE,
sum(t.total_payable) held_up_paid

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where t.pbi_held_up=1 and d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 '.$PBI_GROUP_con.' group by t.pbi_region ,a.PBI_ZONE';
$q=db_query($sqld);
while($i=mysqli_fetch_object($q))
{
$held_up_paid[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->held_up_paid;
}
$sqld = 'select t.pbi_region PBI_BRANCH,a.PBI_ZONE,
sum(t.total_payable-t.bank_paid) cash_paid

from salary_attendence t, personnel_basic_info a, designation d, salary_info s where t.pbi_held_up=0 and d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 '.$PBI_GROUP_con.' group by t.pbi_region ,a.PBI_ZONE';
$q=db_query($sqld);
while($i=mysqli_fetch_object($q))
{
$cash_paid[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->cash_paid;
}
$sqld = 'select t.pbi_region PBI_BRANCH,a.PBI_ZONE,
sum(t.bank_paid) dbbl_paid

from salary_attendence t, personnel_basic_info a, designation d, salary_info s where t.pbi_held_up=0 and s.cash_bank="DBBL" and d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 '.$PBI_GROUP_con.' group by t.pbi_region ,a.PBI_ZONE';
$q=db_query($sqld);
while($i=mysqli_fetch_object($q))
{
$dbbl_paid[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->dbbl_paid;
}

$sqld = 'select t.pbi_region PBI_BRANCH,a.PBI_ZONE,
sum(t.bank_paid) ibbl_paid

from salary_attendence t, personnel_basic_info a, designation d, salary_info s where t.pbi_held_up=0 and s.cash_bank="IBBL" and d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 '.$PBI_GROUP_con.' group by t.pbi_region ,a.PBI_ZONE';
$q=db_query($sqld);
while($i=mysqli_fetch_object($q))
{
$ibbl_paid[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->ibbl_paid;
}
$sqld = 'select t.pbi_region PBI_BRANCH,a.PBI_ZONE,
sum(t.total_payable) total_payable

from salary_attendence t, personnel_basic_info a, designation d, salary_info s where t.pbi_held_up=0 and d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 '.$PBI_GROUP_con.' group by t.pbi_region ,a.PBI_ZONE';
$q=db_query($sqld);
while($i=mysqli_fetch_object($q))
{
$total_payable[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->total_payable;
}


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="31"><?=$str?></th></tr>

<tr>

<th rowspan="3">S/L</th>
<th rowspan="3">Region-Zone</th>
<th rowspan="3">Nos</th>
<th colspan="3">Basic Information </th>
<th colspan="9"><div>Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction</div></th>
<th colspan="5"><div>Payable Amount (Taka) </div></th>
<th colspan="4"><div>View Only </div></th>
<th rowspan="3">Remarks</th>
</tr>
<tr class="vertical-text">
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/house_rent.JPG" /></th>
  <th rowspan="2"><img src="images/car.JPG" /></th>
  <th rowspan="2"><img src="images/food.JPG" /></th>
  <th rowspan="2"><img src="images/mobile.JPG" /></th>
  <th rowspan="2"><img src="images/arear.JPG" /></th>
  <th rowspan="2"><img src="images/other.JPG" /></th>
  <th rowspan="2"><img src="images/ait.JPG" /></th>
  <th rowspan="2"><img src="images/advance_salary.JPG" /></th>
  <th rowspan="2"><img src="images/co-op-fund.JPG" /></th>
  <th rowspan="2"><img src="images/bike.JPG" /></th>
  <th rowspan="2"><img src="images/excess_mobile.JPG" /></th>
  <th rowspan="2"><img src="images/administrative.JPG" /></th>
  <th rowspan="2">H-Up</th>
  <th rowspan="2"><img src="images/cash.JPG" /></th>
  <th colspan="2">BANK</th>
  <th rowspan="2"><img src="images/total_salary.JPG" /></th>
  <th rowspan="2"><img src="images/last_salary.JPG" /></th>
  <th rowspan="2"><img src="images/diff.JPG" /></th>
  <th rowspan="2"><img src="images/late_attendence.JPG" /></th>
  <th rowspan="2"><img src="images/absent_lwp.JPG" /></th>
</tr>
<tr class="vertical-text">
  <th>DBBL</th>
  <th>IBBL</th>
</tr>
</thead>
<tbody>
<?
$sqls = "select * from branch";
$query = db_query($sqls);
while($info = mysqli_fetch_object($query)){
?>
<tr><td><?=++$s?></td>
  <td><strong><?=$info->BRANCH_NAME?> RSM/ASM</strong></td>
  <td><?=$nos[$info->BRANCH_ID]['']?><? $total_nos = $total_nos + $nos[$info->BRANCH_ID][''];?></td>
  <td><?=(int)$actual_basic_salary[$info->BRANCH_ID]['']?><? $total_actual_basic_salary = $total_actual_basic_salary + $actual_basic_salary[$info->BRANCH_ID][''];?></td>
  <td><?=(int)$actual_special_allawance[$info->BRANCH_ID]['']?><? $total_actual_special_allawance = $total_actual_special_allawance + $actual_special_allawance[$info->BRANCH_ID][''];?></td>
  <td><?=$ta_da_data[$info->BRANCH_ID]['']?><? $total_ta_da_data = $total_ta_da_data + $ta_da_data[$info->BRANCH_ID][''];?></td>
  <td><?=(int)$basic_salary_payable[$info->BRANCH_ID]['']?><? $total_basic_salary_payable = $total_basic_salary_payable + $basic_salary_payable[$info->BRANCH_ID][''];?></td>
  <td><?=(int)$special_allowance[$info->BRANCH_ID]['']?><? $total_spl_alw_data = $total_spl_alw_data + $special_allowance[$info->BRANCH_ID][''];?></td>
  <td><?=$ta_da[$info->BRANCH_ID]['']?><? $total_ta_da = $total_ta_da + $ta_da[$info->BRANCH_ID][''];?></td>
  <td><?=$house_rent[$info->BRANCH_ID]['']?><? $total_house_rent = $total_house_rent + $house_rent[$info->BRANCH_ID][''];?></td>
  <td><?=$vehicle_allowance[$info->BRANCH_ID]['']?><? $total_vehicle_allowance = $total_vehicle_allowance + $vehicle_allowance[$info->BRANCH_ID][''];?></td>
  <td><?=$food_allowance[$info->BRANCH_ID]['']?><? $total_food_allowance = $total_food_allowance + $food_allowance[$info->BRANCH_ID][''];?></td>
  <td><?=$mobile_allowance[$info->BRANCH_ID]['']?><? $total_mobile_allowance = $total_mobile_allowance + $mobile_allowance[$info->BRANCH_ID][''];?></td>

  <td><?=$benefits[$info->BRANCH_ID]['']?><? $total_benefits = $total_benefits + $benefits[$info->BRANCH_ID][''];?></td>
  <td><?=$other_benefits[$info->BRANCH_ID]['']?><? $total_other_benefits = $total_other_benefits + $other_benefits[$info->BRANCH_ID][''];?></td>
  <td><?=$income_tax[$info->BRANCH_ID]['']?><? $total_income_tax = $total_income_tax + $income_tax[$info->BRANCH_ID][''];?></td>
  <td><?=$total_install[$info->BRANCH_ID]['']?><? $total_advance_install = $total_advance_install + $total_install[$info->BRANCH_ID][''];?></td>

  <td><?=$cooperative_share[$info->BRANCH_ID]['']?><? $total_cooperative_share = $total_cooperative_share + $cooperative_share[$info->BRANCH_ID][''];?></td>
  <td><?=$motorcycle_install[$info->BRANCH_ID]['']?><? $total_motorcycle_install = $total_motorcycle_install + $motorcycle_install[$info->BRANCH_ID][''];?></td>
  <td><?=$deduction[$info->BRANCH_ID]['']?><? $total_deduction = $total_deduction + $deduction[$info->BRANCH_ID][''];?></td>
  <td><?=number_format($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

  <td><? echo $held_up_paid[$info->BRANCH_ID]['']; $total_help_up_paid = $total_help_up_paid + $held_up_paid[$info->BRANCH_ID][''];?></td>
  <td><? echo $cash_paid[$info->BRANCH_ID]['']; $total_cash_payment = $total_cash_payment + $cash_paid[$info->BRANCH_ID]['']; ?></td>

  <td><? echo $dbbl_paid[$info->BRANCH_ID]['']; $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid[$info->BRANCH_ID][''];?></td>

  <td><? echo $ibbl_paid[$info->BRANCH_ID]['']; $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid[$info->BRANCH_ID][''];?></td>

  <td><? echo $total_payable[$info->BRANCH_ID][''];$total_net_payable = $total_net_payable + $total_payable[$info->BRANCH_ID][''];?></span></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
$zsql = "select * from zon where REGION_ID=".$info->BRANCH_ID;
$zquery = db_query($zsql);
while($zinfo=mysqli_fetch_object($zquery))
{
?>
<tr><td><?=++$s?></td>
 <td><?=$zinfo->ZONE_NAME?></td>
  <td><?=$nos[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_nos = $total_nos + $nos[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=(int)$actual_basic_salary[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_actual_basic_salary = $total_actual_basic_salary + $actual_basic_salary[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=(int)$actual_special_allawance[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_actual_special_allawance = $total_actual_special_allawance + $actual_special_allawance[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=$ta_da_data[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_ta_da_data = $total_ta_da_data + $ta_da_data[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=(int)$basic_salary_payable[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_basic_salary_payable = $total_basic_salary_payable + $basic_salary_payable[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=(int)$special_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_spl_alw_data = $total_spl_alw_data + $special_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=$ta_da[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_ta_da = $total_ta_da + $ta_da[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=$house_rent[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_house_rent = $total_house_rent + $house_rent[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=$vehicle_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_vehicle_allowance = $total_vehicle_allowance + $vehicle_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=$food_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_food_allowance = $total_food_allowance + $food_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=$mobile_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_mobile_allowance = $total_mobile_allowance + $mobile_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>

  <td><?=$benefits[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_benefits = $total_benefits + $benefits[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=$other_benefits[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_other_benefits = $total_other_benefits + $other_benefits[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=$income_tax[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_income_tax = $total_income_tax + $income_tax[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=$total_install[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_advance_install = $total_advance_install + $total_install[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>

  <td><?=$cooperative_share[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_cooperative_share = $total_cooperative_share + $cooperative_share[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=$motorcycle_install[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_motorcycle_install = $total_motorcycle_install + $motorcycle_install[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=$deduction[$info->BRANCH_ID][$zinfo->ZONE_CODE]?><? $total_deduction = $total_deduction + $deduction[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><?=number_format($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

  <td><? echo $held_up_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE]; $total_help_up_paid = $total_help_up_paid + $held_up_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>
  <td><? echo $cash_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE]; $total_cash_payment = $total_cash_payment + $cash_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>

  <td><? echo $dbbl_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE]; $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>

  <td><? echo $ibbl_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE]; $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></td>

  <td><? echo $total_payable[$info->BRANCH_ID][$zinfo->ZONE_CODE];$total_net_payable = $total_net_payable + $total_payable[$info->BRANCH_ID][$zinfo->ZONE_CODE];?></span></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
}
?>
<tr bgcolor="#3399CC">
  <td colspan="2"><?=$info->BRANCH_NAME?>Total: </td>
  <td><?=$total_nos?></td>
  <td><strong><?=$total_actual_basic_salary;?></strong></td>
  <td><strong><?=$total_actual_special_allawance;?></strong></td>
  <td><strong><?=$total_ta_da_data;?></strong></td>
  <td><strong><?=(int)$total_basic_salary_payable;?></strong></td>
  <td><strong><?=$total_spl_alw_data;?></strong></td>
  <td><strong><?=$total_ta_da;?></strong></td>
  <td><strong><?=$total_house_rent;?></strong></td>
  <td><strong><?=$total_vehicle_allowance;?></strong></td>
  <td><strong><?=$total_food_allowance;?></strong></td>
  <td><strong><?=$total_mobile_allowance;?></strong></td>
  <td><strong><?=$total_benefits;?></strong></td>
  <td><strong><?=$total_other_benefits;?></strong></td>
  <td><strong><?=$total_income_tax;?></strong></td>
  <td><strong><?=$total_advance_install;?></strong></td>
  <td><strong><?=$total_cooperative_share;?></strong></td>
  <td><strong><?=$total_motorcycle_install;?></strong></td>
  <td><strong><?=$total_deduction;?></strong></td>
  <td><strong><?=$total_administrative_deduction;?></strong></td>
  <td><strong><?=$total_help_up_paid?></strong></td>
  <td><strong><?=$total_cash_payment?></strong></td>
  <td><?=$total_bank_payment_dbbl?></td>
  <td><?=$total_bank_payment_ibbl?></td>
  <td><strong><?=$total_net_payable?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<?


$total_total_actual_basic_salary=$total_total_actual_basic_salary+$total_actual_basic_salary;
$total_total_actual_special_allawance=$total_total_actual_special_allawance+$total_actual_special_allawance;
$total_total_ta_da_data=$total_total_ta_da_data+$total_ta_da_data;
$total_total_basic_salary_payable=$total_total_basic_salary_payable+$total_basic_salary_payable;
$total_total_spl_alw_data=$total_total_spl_alw_data+$total_spl_alw_data;
$total_total_ta_da=$total_total_ta_da+$total_ta_da;
$total_total_house_rent=$total_total_house_rent+$total_house_rent;
$total_total_vehicle_allowance=$total_total_vehicle_allowance+$total_vehicle_allowance;
$total_total_food_allowance=$total_total_food_allowance+$total_food_allowance;
$total_total_mobile_allowance=$total_total_mobile_allowance+$total_mobile_allowance;
$total_total_benefits=$total_total_benefits+$total_benefits;
$total_total_other_benefits=$total_total_other_benefits+$total_other_benefits;
$total_total_income_tax=$total_total_income_tax+$total_income_tax;
$total_total_advance_install=$total_total_advance_install+$total_advance_install;
$total_total_cooperative_share=$total_total_cooperative_share+$total_cooperative_share;
$total_total_motorcycle_install=$total_total_motorcycle_install+$total_motorcycle_install;
$total_total_deduction=$total_total_deduction+$total_deduction;
$total_total_help_up_paid=$total_total_help_up_paid+$total_help_up_paid;
$total_total_cash_payment=$total_total_cash_payment+$total_cash_payment;
$total_total_bank_payment_dbbl=$total_total_bank_payment_dbbl+$total_bank_payment_dbbl;
$total_total_bank_payment_ibbl=$total_total_bank_payment_ibbl+$total_bank_payment_ibbl;
$total_total_net_payable=$total_total_net_payable+$total_net_payable;
$total_total_nos=$total_total_nos+$total_nos;


$total_actual_basic_salary=0;
$total_actual_special_allawance=0;
$total_ta_da_data=0;
$total_basic_salary_payable=0;
$total_spl_alw_data=0;
$total_ta_da=0;
$total_house_rent=0;
$total_vehicle_allowance=0;
$total_food_allowance=0;
$total_mobile_allowance=0;
$total_benefits=0;
$total_other_benefits=0;
$total_income_tax=0;
$total_advance_install=0;
$total_cooperative_share=0;
$total_motorcycle_install=0;
$total_deduction=0;
$total_help_up_paid=0;
$total_cash_payment=0;
$total_bank_payment_dbbl=0;
$total_bank_payment_ibbl=0;
$total_net_payable=0;
$total_nos=0;
}
?>
<tr bgcolor="#FFCC99">
  <td colspan="2"><?=$info->BRANCH_NAME?>National: </td>
  <td><?=$total_total_nos;?></td>
  <td><strong><?=$total_total_actual_basic_salary;?></strong></td>
  <td><strong><?=$total_total_actual_special_allawance;?></strong></td>
  <td><strong><?=$total_total_ta_da_data;?></strong></td>
  <td><strong><?=(int)$total_total_basic_salary_payable;?></strong></td>
  <td><strong><?=$total_total_spl_alw_data;?></strong></td>
  <td><strong><?=$total_total_ta_da;?></strong></td>
  <td><strong><?=$total_total_house_rent;?></strong></td>
  <td><strong><?=$total_total_vehicle_allowance;?></strong></td>
  <td><strong><?=$total_total_food_allowance;?></strong></td>
  <td><strong><?=$total_total_mobile_allowance;?></strong></td>
  <td><strong><?=$total_total_benefits;?></strong></td>
  <td><strong><?=$total_total_other_benefits;?></strong></td>
  <td><strong><?=$total_total_income_tax;?></strong></td>
  <td><strong><?=$total_total_advance_install;?></strong></td>
  <td><strong><?=$total_total_cooperative_share;?></strong></td>
  <td><strong><?=$total_total_motorcycle_install;?></strong></td>
  <td><strong><?=$total_total_deduction;?></strong></td>
  <td>&nbsp;</td>
  <td><?=$total_total_help_up_paid?></td>
  <td><strong><?=$total_total_cash_payment?></strong></td>
  <td><?=$total_total_bank_payment_dbbl?></td>
  <td><?=$total_total_bank_payment_ibbl?></td>
  <td><strong><?=$total_total_net_payable?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==780)
{

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="30"><?=$str?></th></tr>

<tr>

<th rowspan="3">S/L</th>
<th rowspan="3">Region Name</th>
<th colspan="3">Basic Information </th>
<th colspan="9"><div>Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction</div></th>
<th colspan="5"><div>Payable Amount (Taka) </div></th>
<th colspan="4"><div>View Only </div></th>
<th rowspan="3">Remarks</th>
</tr>
<tr class="vertical-text">
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/house_rent.JPG" /></th>
  <th rowspan="2"><img src="images/car.JPG" /></th>
  <th rowspan="2"><img src="images/food.JPG" /></th>
  <th rowspan="2"><img src="images/mobile.JPG" /></th>
  <th rowspan="2"><img src="images/arear.JPG" /></th>
  <th rowspan="2"><img src="images/other.JPG" /></th>
  <th rowspan="2"><img src="images/ait.JPG" /></th>
  <th rowspan="2"><img src="images/advance_salary.JPG" /></th>
  <th rowspan="2"><img src="images/co-op-fund.JPG" /></th>
  <th rowspan="2"><img src="images/bike.JPG" /></th>
  <th rowspan="2"><img src="images/excess_mobile.JPG" /></th>
  <th rowspan="2"><img src="images/administrative.JPG" /></th>
  <th rowspan="2">H-Up</th>
  <th rowspan="2"><img src="images/cash.JPG" /></th>
  <th colspan="2">BANK</th>
  <th rowspan="2"><img src="images/total_salary.JPG" /></th>
  <th rowspan="2"><img src="images/last_salary.JPG" /></th>
  <th rowspan="2"><img src="images/diff.JPG" /></th>
  <th rowspan="2"><img src="images/late_attendence.JPG" /></th>
  <th rowspan="2"><img src="images/absent_lwp.JPG" /></th>
</tr>
<tr class="vertical-text">
  <th>DBBL</th>
  <th>IBBL</th>
</tr>
</thead>
<tbody>
<?
$sqld = 'select t.pbi_region PBI_BRANCH,
sum(s.basic_salary/4) actual_basic_salary,
sum(s.special_allowance/4) actual_special_allawance,
sum(t.basic_salary_payable/4) basic_salary_payable,
sum(t.special_allowance/4) special_allowance,
sum(t.ta_da_data/4) ta_da_data,
sum(t.ta_da/4) ta_da,
sum(t.house_rent/4) house_rent,
sum(t.vehicle_allowance/4) vehicle_allowance,
sum(t.food_allowance/4) food_allowance,
sum(t.mobile_allowance/4) mobile_allowance,
sum(t.benefits/4) benefits,
sum(t.other_benefits/4) other_benefits,
sum(t.income_tax/4) income_tax,
sum((t.advance_install+ t.other_install)/4) total_install,
sum(t.cooperative_share/4) cooperative_share,
sum(t.motorcycle_install/4) motorcycle_install,
sum(t.deduction/4) deduction,

sum(t.absent_deduction/4) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales" group by t.pbi_region ';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
?>

<? $data->actual_basic_salary?><? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?>
  <? (int)$data->actual_special_allawance?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?>
  <? $data->ta_da_data?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?>
  <? (int)$data->basic_salary_payable?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?>
  <? (int)$data->special_allowance?><? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance;?>
  <? $data->ta_da?><? $total_ta_da = $total_ta_da + $data->ta_da;?>
  <? $data->house_rent?><? $total_house_rent = $total_house_rent + $data->house_rent;?>
  <? $data->vehicle_allowance?><? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance;?>
  <? $data->food_allowance?><? $total_food_allowance = $total_food_allowance + $data->food_allowance;?>
  <? $data->mobile_allowance?><? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance;?>

  <? $data->benefits?><? $total_benefits = $total_benefits + $data->benefits;?>
  <? $data->other_benefits?><? $total_other_benefits = $total_other_benefits + $data->other_benefits;?>
  <? $data->income_tax?><? $total_income_tax = $total_income_tax + $data->income_tax;?>
  <? $total_install?><? $total_advance_install = $total_advance_install + $total_install;?>

  <? $data->cooperative_share?><? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?>
  <? $data->motorcycle_install?><? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?>
  <? $data->deduction?><? $total_deduction = $total_deduction + $data->deduction;?>
  <? //echo number_format(0);?>

  <? $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)/4','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_help_up_paid = $total_help_up_paid + $help_up_paid;?>
  <? $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)/4','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_cash_payment = $total_cash_payment + $cash_paid; ?>

  <? $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)/4','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ' ); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?>

  <? $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)/4','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?>

<?php  $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)/4','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_net_payable = $total_net_payable + $net_payable;?>

<?
}
$sqld = 'select t.pbi_region PBI_BRANCH,
sum(s.basic_salary) actual_basic_salary,
sum(t.spl_alw_data) actual_special_allawance,

sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,

sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  '.$PBI_GROUP_con.' group by t.pbi_region ';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>

  <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?>
  <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?>
  <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?>
  <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?>
  <? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance;?>
  <? $total_ta_da = $total_ta_da + $data->ta_da;?>
  <? $total_house_rent = $total_house_rent + $data->house_rent;?>
  <? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance;?>
  <? $total_food_allowance = $total_food_allowance + $data->food_allowance;?>
  <? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance;?>

  <? $total_benefits = $total_benefits + $data->benefits;?>
  <? $total_other_benefits = $total_other_benefits + $data->other_benefits;?>
  <? $total_income_tax = $total_income_tax + $data->income_tax;?>
  <? $total_advance_install = $total_advance_install + $total_install;?>

  <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?>
  <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?>
  <? $total_deduction = $total_deduction + $data->deduction;?>


  <? $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '.$PBI_GROUP_con); $total_help_up_paid = $total_help_up_paid + $help_up_paid;?>
  <? $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '.$PBI_GROUP_con); $total_cash_payment = $total_cash_payment + $cash_paid; ?>

  <?  $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '.$PBI_GROUP_con); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?>

  <? $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '.$PBI_GROUP_con); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?>

  <?php $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '.$PBI_GROUP_con);$total_net_payable = $total_net_payable + $net_payable;?>
<?
}
?>
<tr><td><?=++$s?></td>
<td>Head Office</td>
<td><strong><?=$total_actual_basic_salary;?></strong></td>
<td><strong><?=$total_actual_special_allawance;?></strong></td>
<td><strong><?=$total_ta_da_data;?></strong></td>
<td><strong><?=(int)$total_basic_salary_payable;?></strong></td>
<td><strong><?=$total_spl_alw_data;?></strong></td>
<td><strong><?=$total_ta_da;?></strong></td>
<td><strong><?=$total_house_rent;?></strong></td>
<td><strong><?=$total_vehicle_allowance;?></strong></td>
<td><strong><?=$total_food_allowance;?></strong></td>
<td><strong><?=$total_mobile_allowance;?></strong></td>
<td><strong><?=$total_benefits;?></strong></td>
<td><strong><?=$total_other_benefits;?></strong></td>
<td><strong><?=$total_income_tax;?></strong></td>
<td><strong><?=$total_advance_install;?></strong></td>
<td><strong><?=$total_cooperative_share;?></strong></td>
<td><strong><?=$total_motorcycle_install;?></strong></td>
<td><strong><?=$total_deduction;?></strong></td>
<td>&nbsp;</td>
<td><?=$total_help_up_paid?></td>
<td><strong><?=$total_cash_payment?>
</strong></td>
<td><?=$total_bank_payment_dbbl?></td>
<td><?=$total_bank_payment_ibbl?></td>
<td><strong><?=$total_net_payable?>
</strong></td>
<td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
$sqld = 'select t.pbi_region PBI_BRANCH,
sum(s.basic_salary) actual_basic_salary,
sum(t.spl_alw_data) actual_special_allawance,

sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,

sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 and t.pbi_department="Sales"  '.$PBI_GROUP_con.' group by t.pbi_region ';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
<td><?=find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$data->PBI_BRANCH)?></td>
<td><?=(int)$data->actual_basic_salary?><? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?></td>
  <td><?=(int)$data->actual_special_allawance?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?></td>
  <td><?=$data->ta_da_data?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?></td>
  <td><?=(int)$data->basic_salary_payable?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?></td>
  <td><?=(int)$data->special_allowance?><? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance;?></td>
  <td><?=$data->ta_da?><? $total_ta_da = $total_ta_da + $data->ta_da;?></td>
  <td><?=$data->house_rent?><? $total_house_rent = $total_house_rent + $data->house_rent;?></td>
  <td><?=$data->vehicle_allowance?><? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance;?></td>
  <td><?=$data->food_allowance?><? $total_food_allowance = $total_food_allowance + $data->food_allowance;?></td>
  <td><?=$data->mobile_allowance?><? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance;?></td>

  <td><?=$data->benefits?><? $total_benefits = $total_benefits + $data->benefits;?></td>
  <td><?=$data->other_benefits?><? $total_other_benefits = $total_other_benefits + $data->other_benefits;?></td>
  <td><?=$data->income_tax?><? $total_income_tax = $total_income_tax + $data->income_tax;?></td>
  <td><?=$data->total_install?><? $total_advance_install = $total_advance_install + $data->total_install;?></td>

  <td><?=$data->cooperative_share?><? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?></td>
  <td><?=$data->motorcycle_install?><? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?></td>
  <td><?=$data->deduction?><? $total_deduction = $total_deduction + $data->deduction;?></td>
  <td><?=number_format($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

  <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region ="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con); $total_help_up_paid = $total_help_up_paid + $help_up_paid;?></td>
  <td><? echo $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region ="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con); $total_cash_payment = $total_cash_payment + $cash_paid; ?></td>

  <td><? echo $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region ="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?></td>

  <td><? echo $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region ="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?></td>

  <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region ="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con);$total_net_payable = $total_net_payable + $net_payable;?></span></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="2">&nbsp;</td>
  <td><strong><?=$total_actual_basic_salary;?></strong></td>
  <td><strong><?=$total_actual_special_allawance;?></strong></td>
  <td><strong><?=$total_ta_da_data;?></strong></td>
  <td><strong><?=(int)$total_basic_salary_payable;?></strong></td>
  <td><strong><?=$total_spl_alw_data;?></strong></td>
  <td><strong><?=$total_ta_da;?></strong></td>
  <td><strong><?=$total_house_rent;?></strong></td>
  <td><strong><?=$total_vehicle_allowance;?></strong></td>
  <td><strong><?=$total_food_allowance;?></strong></td>
  <td><strong><?=$total_mobile_allowance;?></strong></td>
  <td><strong><?=$total_benefits;?></strong></td>
  <td><strong><?=$total_other_benefits;?></strong></td>
  <td><strong><?=$total_income_tax;?></strong></td>
  <td><strong><?=$total_advance_install;?></strong></td>
  <td><strong><?=$total_cooperative_share;?></strong></td>
  <td><strong><?=$total_motorcycle_install;?></strong></td>
  <td><strong><?=$total_deduction;?></strong></td>
  <td>&nbsp;</td>
  <td><?=$total_help_up_paid?></td>
  <td><strong><?=$total_cash_payment?></strong></td>
  <td><?=$total_bank_payment_dbbl?></td>
  <td><?=$total_bank_payment_ibbl?></td>
  <td><strong><?=$total_net_payable?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==7809)
{
$year = $_POST['year'];
$mon = $_POST['mon'];

if($mon == 1)
{
$syear = $year - 1;
$smon = 12;
}
else
{
$syear = $year;
$smon =  $mon - 1;
}
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="12"><?=$str?></th></tr>

<tr>
    <th rowspan="3">S/L</th>
    <th rowspan="3">Name of Unit</th>
    <th colspan="2">Previous Month</th>
    <th colspan="6"><div><?=date('F', mktime(0, 0, 0, $mon, 10));?>-<?=$year?></div></th>
    <th rowspan="3">Difference</th>
    <th rowspan="3">Remark</th>
</tr>
<tr>
  <th rowspan="2">Man Power</th>
  <th rowspan="2">Total Amount</th>
  <th rowspan="2">Man Power</th>
  <th colspan="3">BANK</th>
  <th rowspan="2">Cash Tk</th>
  <th rowspan="2">Total Tk</th>
</tr>
<tr>
  <th>DBBL</th>
  <th>IBBL</th>
  <th>Other</th>
  </tr>
</thead>
<tbody>
<?

echo $sqld = 'select t.pbi_organization, count(t.PBI_ID) manpower,s.cash_bank
from  salary_attendence t, personnel_basic_info a, salary_info s where t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location in (1,79,80) and t.pbi_held_up=0  '.$PBI_GROUP_con.' group by t.pbi_organization ';
$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;


  $cash_paid[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80)  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_held_up=0 and t.pbi_organization = "'.$data->pbi_organization.'" '.$PBI_GROUP_con);


  $dbbl_paid[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80)  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_held_up=0 and t.pbi_organization = "'.$data->pbi_organization.'" '.$PBI_GROUP_con);

  $ibbl_paid[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80)  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_held_up=0 and t.pbi_organization = "'.$data->pbi_organization.'" '.$PBI_GROUP_con);

  $ncc_paid[$data->pbi_organization]=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="NCC" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80)  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_held_up=0 and t.pbi_organization = "'.$data->pbi_organization.'" '.$PBI_GROUP_con);

  $net_payable[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80)  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_held_up=0 and t.pbi_organization = "'.$data->pbi_organization.'" '.$PBI_GROUP_con);


  $smanpower[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a ','count(t.PBI_ID) manpower','t.pbi_job_location in (1,79,80) and t.PBI_ID=a.PBI_ID and t.mon='.$smon.' and t.year='.$syear.' and t.pbi_held_up=0 and t.pbi_organization = "'.$data->pbi_organization.'" '.$PBI_GROUP_con);


  $snet_payable[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80) and t.mon='.$smon.' and t.year='.$syear.' and t.pbi_held_up=0 and t.pbi_organization = "'.$data->pbi_organization.'" '.$PBI_GROUP_con);

  $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid[$data->pbi_organization];
  $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid[$data->pbi_organization];
  $total_cash_payment = $total_cash_payment + $cash_paid[$data->pbi_organization];
  $total_bank_payment_ncc = $total_bank_payment_ncc + $ncc_paid[$data->pbi_organization];
  $total_net_payable = $total_net_payable + $net_payable[$data->pbi_organization];
  $stotal_smanpower = $stotal_smanpower + $smanpower[$data->pbi_organization];
  $stotal_net_payable = $stotal_net_payable + $snet_payable[$data->pbi_organization];
  ++$s;

  $manpower[$data->pbi_organization] = $data->manpower;
  $total_manpower = $total_manpower + $manpower[$data->pbi_organization];
  }



$sqld = 'select count(t.PBI_ID) manpower,s.cash_bank
from  salary_attendence t, personnel_basic_info a, salary_info s where t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO") and t.pbi_held_up=0  '.$PBI_GROUP_con.' ';
$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;


 $cash_paid[100] = find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  '.$PBI_GROUP_con);


  $dbbl_paid[100] = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  '.$PBI_GROUP_con);

  $ibbl_paid[100] = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  '.$PBI_GROUP_con);

  $ncc_paid[100]=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="NCC" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  '.$PBI_GROUP_con);

  $net_payable[100] = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  '.$PBI_GROUP_con);


  $smanpower[100] = find_a_field('salary_attendence t,personnel_basic_info a ','count(t.PBI_ID) manpower','t.PBI_ID=a.PBI_ID and t.mon='.$smon.' and t.year='.$syear.' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  '.$PBI_GROUP_con);


  $snet_payable[100] = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon='.$smon.' and t.year='.$syear.' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  '.$PBI_GROUP_con);

  $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid[100];
  $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid[100];
  $total_cash_payment = $total_cash_payment + $cash_paid[100];
  $total_bank_payment_ncc = $total_bank_payment_ncc + $ncc_paid[100];
  $total_net_payable = $total_net_payable + $net_payable[100];
  $stotal_smanpower = $stotal_smanpower + $smanpower[100];
  $stotal_net_payable = $stotal_net_payable + $snet_payable[100];
  ++$s;

  $manpower[100] = $data->manpower;
  $total_manpower = $total_manpower + $manpower[100];
  }
?>
<tr>
    <td>1</td>
    <td>Sajeeb Corporation</td>
    <td><span style="text-align:left; font-weight:bold;"><?=$smanpower[1]+$smanpower[2]+$smanpower[100]?></span></td>
    <td><span style="text-align:left; font-weight:bold;"><?=$snet_payable[1]+$snet_payable[2]+$snet_payable[100]?></span></td>
    <td><?=$manpower[1] + $manpower[2]+ $manpower[100]?></td>
    <td><?=$dbbl_paid[1]+$dbbl_paid[2]+$dbbl_paid[100]?></td>
    <td><?=$ibbl_paid[1]+$ibbl_paid[2]+$ibbl_paid[100]?></td>
    <td><?=$ncc_paid[1]+$ncc_paid[2]+$ncc_paid[100]?></td>
    <td><strong><?=$cash_paid[1]+$cash_paid[2]+$cash_paid[100]?></strong></td>
    <td><strong><?=$net_payable[1]+$net_payable[2]+$net_payable[100]?></strong></td>
    <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
    <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
++$j;
$sqld = 'select id, group_name
from  user_group where id>2 and status>0 order by id';
$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
?>
<tr>
    <td><?=++$j?></td>
    <td><?=$data->group_name;?></td>
    <td><span style="text-align:left; font-weight:bold;"><?=$smanpower[$data->id];?></span></td>
    <td><span style="text-align:left; font-weight:bold;"><?=$snet_payable[$data->id];?></span></td>
    <td><?=$manpower[$data->id]?></td>
    <td><?=$dbbl_paid[$data->id]?></td>
    <td><?=$ibbl_paid[$data->id]?></td>
    <td><?=$ncc_paid[$data->id]?></td>
    <td><strong><?=$cash_paid[$data->id]?></strong></td>
    <td><strong><?=$net_payable[$data->id]?></strong></td>
    <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
    <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
}
?>



<tr>
  <td colspan="2">Sub Total (A)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<tr>
  <td colspan="2">Sales Department:</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
$sqld = 'select t.pbi_region PBI_BRANCH, count(t.PBI_ID) manpower, s.cash_bank
from  salary_attendence t, personnel_basic_info a, salary_info s where t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region > 0 and t.pbi_department="Sales"  '.$PBI_GROUP_con.' group by t.pbi_region ';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>


<tr><td><?=++$ws?></td>
<td><?=find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$data->PBI_BRANCH)?></td>
  <td><span style="text-align:left; font-weight:bold;"><?php echo $smanpower = find_a_field('salary_attendence t,personnel_basic_info a ','count(t.PBI_ID) manpower','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon='.$smon.' and t.year='.$syear.' and t.pbi_region ="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con);$stotal_smanpower = $stotal_smanpower + $smanpower;?></span></td>
  <td><span style="text-align:left; font-weight:bold;"><?php echo $snet_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon='.$smon.' and t.year='.$syear.' and t.pbi_region ="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con);$stotal_net_payable = $stotal_net_payable + $snet_payable;?></span></td>
  <td><?=$data->manpower?></td>
  <td><? echo $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region ="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?></td>

  <td><? echo $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region ="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?></td>
  <td>&nbsp;</td>
  <td><? echo $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region ="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con); $total_cash_payment = $total_cash_payment + $cash_paid; ?></td>
  <td><span style="text-align:left; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region ="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con);$total_net_payable = $total_net_payable + $net_payable;?></span></td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="2">Sub Total (B)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td colspan="2">Sub Total (A+B)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><?=$total_help_up_paid?></td>
  <td><?=$total_bank_payment_dbbl?></td>
  <td><?=$total_bank_payment_ibbl?></td>
  <td>&nbsp;</td>
  <td><strong>
    <?=$total_cash_payment?>
  </strong></td>
  <td><strong>
    <?=$total_net_payable?>
  </strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==7804) { // Group Wise HO Sales Report

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="30"><?=$str?></th></tr>

<tr>

<th rowspan="3">S/L</th>
<th rowspan="3">Group Name</th>
<th colspan="3">Basic Information </th>
<th colspan="9"><div>Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction</div></th>
<th colspan="5"><div>Payable Amount (Taka) </div></th>
<th colspan="4"><div>View Only </div></th>
<th rowspan="3">Remarks</th>
</tr>
<tr class="vertical-text">
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/house_rent.JPG" /></th>
  <th rowspan="2"><img src="images/car.JPG" /></th>
  <th rowspan="2"><img src="images/food.JPG" /></th>
  <th rowspan="2"><img src="images/mobile.JPG" /></th>
  <th rowspan="2"><img src="images/arear.JPG" /></th>
  <th rowspan="2"><img src="images/other.JPG" /></th>
  <th rowspan="2"><img src="images/ait.JPG" /></th>
  <th rowspan="2"><img src="images/advance_salary.JPG" /></th>
  <th rowspan="2"><img src="images/co-op-fund.JPG" /></th>
  <th rowspan="2"><img src="images/bike.JPG" /></th>
  <th rowspan="2"><img src="images/excess_mobile.JPG" /></th>
  <th rowspan="2"><img src="images/administrative.JPG" /></th>
  <th rowspan="2">H-Up</th>
  <th rowspan="2"><img src="images/cash.JPG" /></th>
  <th colspan="2">BANK</th>
  <th rowspan="2"><img src="images/total_salary.JPG" /></th>
  <th rowspan="2"><img src="images/last_salary.JPG" /></th>
  <th rowspan="2"><img src="images/diff.JPG" /></th>
  <th rowspan="2"><img src="images/late_attendence.JPG" /></th>
  <th rowspan="2"><img src="images/absent_lwp.JPG" /></th>
</tr>
<tr class="vertical-text">
  <th>DBBL</th>
  <th>IBBL</th>
</tr>
</thead>
<tbody>
<?
$sqld = 'select t.pbi_region PBI_BRANCH,
sum(s.basic_salary/5) actual_basic_salary,
sum(s.special_allowance/5) actual_special_allawance,
sum(t.basic_salary_payable/5) basic_salary_payable,
sum(t.special_allowance/5) special_allowance,
sum(t.ta_da_data/5) ta_da_data,
sum(t.ta_da/5) ta_da,
sum(t.house_rent/5) house_rent,
sum(t.vehicle_allowance/5) vehicle_allowance,
sum(t.food_allowance/5) food_allowance,
sum(t.mobile_allowance/5) mobile_allowance,
sum(t.benefits/5) benefits,
sum(t.other_benefits/5) other_benefits,
sum(t.income_tax/5) income_tax,
sum((t.advance_install+ t.other_install)/5) total_install,
sum(t.cooperative_share/5) cooperative_share,
sum(t.motorcycle_install/5) motorcycle_install,
sum(t.deduction/5) deduction,

sum(t.absent_deduction/5) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.PBI_ID="3364"';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
?>

<? $data->actual_basic_salary?><? $total_14_actual_basic_salary = $total_14_actual_basic_salary + $data->actual_basic_salary;?>
  <? (int)$data->actual_special_allawance?><? $total_14_actual_special_allawance = $total_14_actual_special_allawance + $data->actual_special_allawance;?>
  <? $data->ta_da_data?><? $total_14_ta_da_data = $total_14_ta_da_data + $data->ta_da_data;?>
  <? (int)$data->basic_salary_payable?><? $total_14_basic_salary_payable = $total_14_basic_salary_payable + $data->basic_salary_payable;?>
  <? (int)$data->special_allowance?><? $total_14_spl_alw_data = $total_14_spl_alw_data + $data->special_allowance;?>
  <? $data->ta_da?><? $total_14_ta_da = $total_14_ta_da + $data->ta_da;?>
  <? $data->house_rent?><? $total_14_house_rent = $total_14_house_rent + $data->house_rent;?>
  <? $data->vehicle_allowance?><? $total_14_vehicle_allowance = $total_14_vehicle_allowance + $data->vehicle_allowance;?>
  <? $data->food_allowance?><? $total_14_food_allowance = $total_14_food_allowance + $data->food_allowance;?>
  <? $data->mobile_allowance?><? $total_14_mobile_allowance = $total_14_mobile_allowance + $data->mobile_allowance;?>

  <? $data->benefits?><? $total_14_benefits = $total_14_benefits + $data->benefits;?>
  <? $data->other_benefits?><? $total_14_other_benefits = $total_14_other_benefits + $data->other_benefits;?>
  <? $data->income_tax?><? $total_14_income_tax = $total_14_income_tax + $data->income_tax;?>
  <? $total_install?><? $total_14_advance_install = $total_14_advance_install + $data->total_install;?>

  <? $data->cooperative_share?><? $total_14_cooperative_share = $total_14_cooperative_share + $data->cooperative_share;?>
  <? $data->motorcycle_install?><? $total_14_motorcycle_install = $total_14_motorcycle_install + $data->motorcycle_install;?>
  <? $data->deduction?><? $total_14_deduction = $total_14_deduction + $data->deduction;?>


  <?  $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)/5','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_14_help_up_paid = $total_14_help_up_paid + $help_up_paid;?>
  <?  $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)/5','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_14_cash_payment = $total_14_cash_payment + $cash_paid; ?>

  <?  $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)/5','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ' ); $total_14_bank_payment_dbbl = $total_14_bank_payment_dbbl + $dbbl_paid;?>

  <?  $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)/5','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_14_bank_payment_ibbl = $total_14_bank_payment_ibbl + $ibbl_paid;?>

<?php  $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)/5','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_14_net_payable = $total_14_net_payable + $net_payable;?>

<?
}

////A
$sqld = 'select t.pbi_region PBI_BRANCH,
sum(s.basic_salary) actual_basic_salary,
sum(s.special_allowance) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,

sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  ';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
?>

<? $data->actual_basic_salary?><? $total_A_actual_basic_salary = $total_A_actual_basic_salary + $data->actual_basic_salary;?>
  <? (int)$data->actual_special_allawance?><? $total_A_actual_special_allawance = $total_A_actual_special_allawance + $data->actual_special_allawance;?>
  <? $data->ta_da_data?><? $total_A_ta_da_data = $total_A_ta_da_data + $data->ta_da_data;?>
  <? (int)$data->basic_salary_payable?><? $total_A_basic_salary_payable = $total_A_basic_salary_payable + $data->basic_salary_payable;?>
  <? (int)$data->special_allowance?><? $total_A_spl_alw_data = $total_A_spl_alw_data + $data->special_allowance;?>
  <? $data->ta_da?><? $total_A_ta_da = $total_A_ta_da + $data->ta_da;?>
  <? $data->house_rent?><? $total_A_house_rent = $total_A_house_rent + $data->house_rent;?>
  <? $data->vehicle_allowance?><? $total_A_vehicle_allowance = $total_A_vehicle_allowance + $data->vehicle_allowance;?>
  <? $data->food_allowance?><? $total_A_food_allowance = $total_A_food_allowance + $data->food_allowance;?>
  <? $data->mobile_allowance?><? $total_A_mobile_allowance = $total_A_mobile_allowance + $data->mobile_allowance;?>

  <? $data->benefits?><? $total_A_benefits = $total_A_benefits + $data->benefits;?>
  <? $data->other_benefits?><? $total_A_other_benefits = $total_A_other_benefits + $data->other_benefits;?>
  <? $data->income_tax?><? $total_A_income_tax = $total_A_income_tax + $data->income_tax;?>
  <? $total_install?><? $total_A_advance_install = $total_A_advance_install + $data->total_install;?>

  <? $data->cooperative_share?><? $total_A_cooperative_share = $total_A_cooperative_share + $data->cooperative_share;?>
  <? $data->motorcycle_install?><? $total_A_motorcycle_install = $total_A_motorcycle_install + $data->motorcycle_install;?>
  <? $data->deduction?><? $total_A_deduction = $total_A_deduction + $data->deduction;?>


  <?  $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_A_help_up_paid = $total_A_help_up_paid + $help_up_paid;?>
  <?  $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_A_cash_payment = $total_A_cash_payment + $cash_paid; ?>

  <?  $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ' ); $total_A_bank_payment_dbbl = $total_A_bank_payment_dbbl + $dbbl_paid;?>

  <?  $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_A_bank_payment_ibbl = $total_A_bank_payment_ibbl + $ibbl_paid;?>

<?php  $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_A_net_payable = $total_A_net_payable + $net_payable;?>

<?
}

//B

$sqld = 'select t.pbi_region PBI_BRANCH,
sum(s.basic_salary) actual_basic_salary,
sum(s.special_allowance) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,

sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  ';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
?>

<? $data->actual_basic_salary?><? $total_B_actual_basic_salary = $total_B_actual_basic_salary + $data->actual_basic_salary;?>
  <? (int)$data->actual_special_allawance?><? $total_B_actual_special_allawance = $total_B_actual_special_allawance + $data->actual_special_allawance;?>
  <? $data->ta_da_data?><? $total_B_ta_da_data = $total_B_ta_da_data + $data->ta_da_data;?>
  <? (int)$data->basic_salary_payable?><? $total_B_basic_salary_payable = $total_B_basic_salary_payable + $data->basic_salary_payable;?>
  <? (int)$data->special_allowance?><? $total_B_spl_alw_data = $total_B_spl_alw_data + $data->special_allowance;?>
  <? $data->ta_da?><? $total_B_ta_da = $total_B_ta_da + $data->ta_da;?>
  <? $data->house_rent?><? $total_B_house_rent = $total_B_house_rent + $data->house_rent;?>
  <? $data->vehicle_allowance?><? $total_B_vehicle_allowance = $total_B_vehicle_allowance + $data->vehicle_allowance;?>
  <? $data->food_allowance?><? $total_B_food_allowance = $total_B_food_allowance + $data->food_allowance;?>
  <? $data->mobile_allowance?><? $total_B_mobile_allowance = $total_B_mobile_allowance + $data->mobile_allowance;?>

  <? $data->benefits?><? $total_B_benefits = $total_B_benefits + $data->benefits;?>
  <? $data->other_benefits?><? $total_B_other_benefits = $total_B_other_benefits + $data->other_benefits;?>
  <? $data->income_tax?><? $total_B_income_tax = $total_B_income_tax + $data->income_tax;?>
  <? $total_install?><? $total_B_advance_install = $total_B_advance_install + $data->total_install;?>

  <? $data->cooperative_share?><? $total_B_cooperative_share = $total_B_cooperative_share + $data->cooperative_share;?>
  <? $data->motorcycle_install?><? $total_B_motorcycle_install = $total_B_motorcycle_install + $data->motorcycle_install;?>
  <? $data->deduction?><? $total_B_deduction = $total_B_deduction + $data->deduction;?>


  <?  $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_B_help_up_paid = $total_B_help_up_paid + $help_up_paid;?>
  <?  $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_B_cash_payment = $total_B_cash_payment + $cash_paid; ?>

  <?  $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ' ); $total_B_bank_payment_dbbl = $total_B_bank_payment_dbbl + $dbbl_paid;?>

  <?  $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_B_bank_payment_ibbl = $total_B_bank_payment_ibbl + $ibbl_paid;?>

<?php  $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_B_net_payable = $total_B_net_payable + $net_payable;?>

<?
}

//C

$sqld = 'select t.pbi_region PBI_BRANCH,
sum(s.basic_salary) actual_basic_salary,
sum(s.special_allowance) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,

sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  ';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
?>

<? $data->actual_basic_salary?><? $total_C_actual_basic_salary = $total_C_actual_basic_salary + $data->actual_basic_salary;?>
  <? (int)$data->actual_special_allawance?><? $total_C_actual_special_allawance = $total_C_actual_special_allawance + $data->actual_special_allawance;?>
  <? $data->ta_da_data?><? $total_C_ta_da_data = $total_C_ta_da_data + $data->ta_da_data;?>
  <? (int)$data->basic_salary_payable?><? $total_C_basic_salary_payable = $total_C_basic_salary_payable + $data->basic_salary_payable;?>
  <? (int)$data->special_allowance?><? $total_C_spl_alw_data = $total_C_spl_alw_data + $data->special_allowance;?>
  <? $data->ta_da?><? $total_C_ta_da = $total_C_ta_da + $data->ta_da;?>
  <? $data->house_rent?><? $total_C_house_rent = $total_C_house_rent + $data->house_rent;?>
  <? $data->vehicle_allowance?><? $total_C_vehicle_allowance = $total_C_vehicle_allowance + $data->vehicle_allowance;?>
  <? $data->food_allowance?><? $total_C_food_allowance = $total_C_food_allowance + $data->food_allowance;?>
  <? $data->mobile_allowance?><? $total_C_mobile_allowance = $total_C_mobile_allowance + $data->mobile_allowance;?>

  <? $data->benefits?><? $total_C_benefits = $total_C_benefits + $data->benefits;?>
  <? $data->other_benefits?><? $total_C_other_benefits = $total_C_other_benefits + $data->other_benefits;?>
  <? $data->income_tax?><? $total_C_income_tax = $total_C_income_tax + $data->income_tax;?>
  <? $total_install?><? $total_C_advance_install = $total_C_advance_install + $data->total_install;?>

  <? $data->cooperative_share?><? $total_C_cooperative_share = $total_C_cooperative_share + $data->cooperative_share;?>
  <? $data->motorcycle_install?><? $total_C_motorcycle_install = $total_C_motorcycle_install + $data->motorcycle_install;?>
  <? $data->deduction?><? $total_C_deduction = $total_C_deduction + $data->deduction;?>


  <?  $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_C_help_up_paid = $total_C_help_up_paid + $help_up_paid;?>
  <?  $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_C_cash_payment = $total_C_cash_payment + $cash_paid; ?>

  <?  $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ' ); $total_C_bank_payment_dbbl = $total_C_bank_payment_dbbl + $dbbl_paid;?>

  <?  $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_C_bank_payment_ibbl = $total_C_bank_payment_ibbl + $ibbl_paid;?>

<?php  $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_C_net_payable = $total_C_net_payable + $net_payable;?>

<?
}

//D

$sqld = 'select t.pbi_region PBI_BRANCH,
sum(s.basic_salary) actual_basic_salary,
sum(s.special_allowance) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,

sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  ';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
?>

<? $data->actual_basic_salary?><? $total_D_actual_basic_salary = $total_D_actual_basic_salary + $data->actual_basic_salary;?>
  <? (int)$data->actual_special_allawance?><? $total_D_actual_special_allawance = $total_D_actual_special_allawance + $data->actual_special_allawance;?>
  <? $data->ta_da_data?><? $total_D_ta_da_data = $total_D_ta_da_data + $data->ta_da_data;?>
  <? (int)$data->basic_salary_payable?><? $total_D_basic_salary_payable = $total_D_basic_salary_payable + $data->basic_salary_payable;?>
  <? (int)$data->special_allowance?><? $total_D_spl_alw_data = $total_D_spl_alw_data + $data->special_allowance;?>
  <? $data->ta_da?><? $total_D_ta_da = $total_D_ta_da + $data->ta_da;?>
  <? $data->house_rent?><? $total_D_house_rent = $total_D_house_rent + $data->house_rent;?>
  <? $data->vehicle_allowance?><? $total_D_vehicle_allowance = $total_D_vehicle_allowance + $data->vehicle_allowance;?>
  <? $data->food_allowance?><? $total_D_food_allowance = $total_D_food_allowance + $data->food_allowance;?>
  <? $data->mobile_allowance?><? $total_D_mobile_allowance = $total_D_mobile_allowance + $data->mobile_allowance;?>

  <? $data->benefits?><? $total_D_benefits = $total_D_benefits + $data->benefits;?>
  <? $data->other_benefits?><? $total_D_other_benefits = $total_D_other_benefits + $data->other_benefits;?>
  <? $data->income_tax?><? $total_D_income_tax = $total_D_income_tax + $data->income_tax;?>
  <? $total_install?><? $total_D_advance_install = $total_D_advance_install + $data->total_install;?>

  <? $data->cooperative_share?><? $total_D_cooperative_share = $total_D_cooperative_share + $data->cooperative_share;?>
  <? $data->motorcycle_install?><? $total_D_motorcycle_install = $total_D_motorcycle_install + $data->motorcycle_install;?>
  <? $data->deduction?><? $total_D_deduction = $total_D_deduction + $data->deduction;?>


  <?  $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_D_help_up_paid = $total_D_help_up_paid + $help_up_paid;?>
  <?  $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_D_cash_payment = $total_D_cash_payment + $cash_paid; ?>

  <?  $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ' ); $total_D_bank_payment_dbbl = $total_D_bank_payment_dbbl + $dbbl_paid;?>

  <?  $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_D_bank_payment_ibbl = $total_D_bank_payment_ibbl + $ibbl_paid;?>

<?php  $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_D_net_payable = $total_D_net_payable + $net_payable;?>

<?
}

// E
$sqld = 'select t.pbi_region PBI_BRANCH,
sum(s.basic_salary) actual_basic_salary,
sum(s.special_allowance) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,

sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  ';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
?>

<? $data->actual_basic_salary?><? $total_E_actual_basic_salary = $total_E_actual_basic_salary + $data->actual_basic_salary;?>
  <? (int)$data->actual_special_allawance?><? $total_E_actual_special_allawance = $total_E_actual_special_allawance + $data->actual_special_allawance;?>
  <? $data->ta_da_data?><? $total_E_ta_da_data = $total_E_ta_da_data + $data->ta_da_data;?>
  <? (int)$data->basic_salary_payable?><? $total_E_basic_salary_payable = $total_E_basic_salary_payable + $data->basic_salary_payable;?>
  <? (int)$data->special_allowance?><? $total_E_spl_alw_data = $total_E_spl_alw_data + $data->special_allowance;?>
  <? $data->ta_da?><? $total_E_ta_da = $total_E_ta_da + $data->ta_da;?>
  <? $data->house_rent?><? $total_E_house_rent = $total_E_house_rent + $data->house_rent;?>
  <? $data->vehicle_allowance?><? $total_E_vehicle_allowance = $total_E_vehicle_allowance + $data->vehicle_allowance;?>
  <? $data->food_allowance?><? $total_E_food_allowance = $total_E_food_allowance + $data->food_allowance;?>
  <? $data->mobile_allowance?><? $total_E_mobile_allowance = $total_E_mobile_allowance + $data->mobile_allowance;?>

  <? $data->benefits?><? $total_E_benefits = $total_E_benefits + $data->benefits;?>
  <? $data->other_benefits?><? $total_E_other_benefits = $total_E_other_benefits + $data->other_benefits;?>
  <? $data->income_tax?><? $total_E_income_tax = $total_E_income_tax + $data->income_tax;?>
  <? $total_install?><? $total_E_advance_install = $total_E_advance_install + $data->total_install;?>

  <? $data->cooperative_share?><? $total_E_cooperative_share = $total_E_cooperative_share + $data->cooperative_share;?>
  <? $data->motorcycle_install?><? $total_E_motorcycle_install = $total_E_motorcycle_install + $data->motorcycle_install;?>
  <? $data->deduction?><? $total_E_deduction = $total_E_deduction + $data->deduction;?>


  <?  $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_E_help_up_paid = $total_E_help_up_paid + $help_up_paid;?>
  <?  $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_E_cash_payment = $total_E_cash_payment + $cash_paid; ?>

  <?  $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ' ); $total_E_bank_payment_dbbl = $total_E_bank_payment_dbbl + $dbbl_paid;?>

  <?  $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_E_bank_payment_ibbl = $total_E_bank_payment_ibbl + $ibbl_paid;?>

<?php  $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_E_net_payable = $total_E_net_payable + $net_payable;?>

<?
}

?>
<tr>
  <td>1</td>
  <td>Group-A</td>
  <td><strong>
    <?=$total_14_actual_basic_salary+$total_A_actual_basic_salary;?>
  </strong></td>
  <td><strong>
    <?=$total_14_actual_special_allawance+$total_A_actual_special_allawance;?>
  </strong></td>
  <td><strong>
    <?=$total_14_ta_da_data+$total_A_ta_da_data;?>
  </strong></td>
  <td><strong>
    <?=(int)($total_14_basic_salary_payable+$total_A_basic_salary_payable);?>
  </strong></td>
  <td><strong>
    <?=($total_14_spl_alw_data+$total_A_spl_alw_data);?>
  </strong></td>
  <td><strong>
    <?=($total_14_ta_da+$total_A_ta_da);?>
  </strong></td>
  <td><strong>
    <?=($total_14_house_rent+$total_A_house_rent);?>
  </strong></td>
  <td><strong>
    <?=($total_14_vehicle_allowance+$total_A_vehicle_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_food_allowance+$total_A_food_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_mobile_allowance+$total_A_mobile_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_benefits+$total_A_benefits);?>
  </strong></td>
  <td><strong>
    <?=($total_14_other_benefits+$total_A_other_benefits);?>
  </strong></td>
  <td><strong>
    <?=($total_14_income_tax+$total_A_income_tax);?>
  </strong></td>
  <td><strong>
    <?=($total_14_advance_install+$total_A_advance_install);?>
  </strong></td>
  <td><strong>
    <?=($total_14_cooperative_share+$total_A_cooperative_share);?>
  </strong></td>
  <td><strong>
    <?=($total_14_motorcycle_install+$total_A_motorcycle_install);?>
  </strong></td>
  <td><strong>
    <?=($total_14_deduction+$total_A_deduction);?>
  </strong></td>
  <td>&nbsp;</td>
  <td><?=($total_14_help_up_paid+$total_A_help_up_paid)?></td>
  <td><strong>
    <?=($total_14_cash_payment+$total_A_cash_payment)?>
  </strong></td>
  <td><?=($total_14_bank_payment_dbbl+$total_A_bank_payment_dbbl)?></td>
  <td><?=($total_14_bank_payment_ibbl+$total_A_bank_payment_ibbl)?></td>
  <td><strong>
    <?=($total_14_net_payable+$total_A_net_payable)?>
  </strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<tr>
  <td>2</td>
  <td>Group-B</td>
  <td><strong>
    <?=$total_14_actual_basic_salary+$total_B_actual_basic_salary;?>
  </strong></td>
  <td><strong>
    <?=$total_14_actual_special_allawance+$total_B_actual_special_allawance;?>
  </strong></td>
  <td><strong>
    <?=$total_14_ta_da_data+$total_B_ta_da_data;?>
  </strong></td>
  <td><strong>
    <?=(int)($total_14_basic_salary_payable+$total_B_basic_salary_payable);?>
  </strong></td>
  <td><strong>
    <?=($total_14_spl_alw_data+$total_B_spl_alw_data);?>
  </strong></td>
  <td><strong>
    <?=($total_14_ta_da+$total_B_ta_da);?>
  </strong></td>
  <td><strong>
    <?=($total_14_house_rent+$total_B_house_rent);?>
  </strong></td>
  <td><strong>
    <?=($total_14_vehicle_allowance+$total_B_vehicle_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_food_allowance+$total_B_food_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_mobile_allowance+$total_B_mobile_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_benefits+$total_B_benefits);?>
  </strong></td>
  <td><strong>
    <?=($total_14_other_benefits+$total_B_other_benefits);?>
  </strong></td>
  <td><strong>
    <?=($total_14_income_tax+$total_B_income_tax);?>
  </strong></td>
  <td><strong>
    <?=($total_14_advance_install+$total_B_advance_install);?>
  </strong></td>
  <td><strong>
    <?=($total_14_cooperative_share+$total_B_cooperative_share);?>
  </strong></td>
  <td><strong>
    <?=($total_14_motorcycle_install+$total_B_motorcycle_install);?>
  </strong></td>
  <td><strong>
    <?=($total_14_deduction+$total_B_deduction);?>
  </strong></td>
  <td>&nbsp;</td>
  <td><?=($total_14_help_up_paid+$total_B_help_up_paid)?></td>
  <td><strong>
    <?=($total_14_cash_payment+$total_B_cash_payment)?>
  </strong></td>
  <td><?=($total_14_bank_payment_dbbl+$total_B_bank_payment_dbbl)?></td>
  <td><?=($total_14_bank_payment_ibbl+$total_B_bank_payment_ibbl)?></td>
  <td><strong>
    <?=($total_14_net_payable+$total_B_net_payable)?>
  </strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<tr>
  <td>3</td>
  <td>Group-C</td>
  <td><strong>
    <?=$total_14_actual_basic_salary+$total_C_actual_basic_salary;?>
  </strong></td>
  <td><strong>
    <?=$total_14_actual_special_allawance+$total_C_actual_special_allawance;?>
  </strong></td>
  <td><strong>
    <?=$total_14_ta_da_data+$total_C_ta_da_data;?>
  </strong></td>
  <td><strong>
    <?=(int)($total_14_basic_salary_payable+$total_C_basic_salary_payable);?>
  </strong></td>
  <td><strong>
    <?=($total_14_spl_alw_data+$total_C_spl_alw_data);?>
  </strong></td>
  <td><strong>
    <?=($total_14_ta_da+$total_C_ta_da);?>
  </strong></td>
  <td><strong>
    <?=($total_14_house_rent+$total_C_house_rent);?>
  </strong></td>
  <td><strong>
    <?=($total_14_vehicle_allowance+$total_C_vehicle_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_food_allowance+$total_C_food_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_mobile_allowance+$total_C_mobile_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_benefits+$total_C_benefits);?>
  </strong></td>
  <td><strong>
    <?=($total_14_other_benefits+$total_C_other_benefits);?>
  </strong></td>
  <td><strong>
    <?=($total_14_income_tax+$total_C_income_tax);?>
  </strong></td>
  <td><strong>
    <?=($total_14_advance_install+$total_C_advance_install);?>
  </strong></td>
  <td><strong>
    <?=($total_14_cooperative_share+$total_C_cooperative_share);?>
  </strong></td>
  <td><strong>
    <?=($total_14_motorcycle_install+$total_C_motorcycle_install);?>
  </strong></td>
  <td><strong>
    <?=($total_14_deduction+$total_C_deduction);?>
  </strong></td>
  <td>&nbsp;</td>
  <td><?=($total_14_help_up_paid+$total_C_help_up_paid)?></td>
  <td><strong>
    <?=($total_14_cash_payment+$total_C_cash_payment)?>
  </strong></td>
  <td><?=($total_14_bank_payment_dbbl+$total_C_bank_payment_dbbl)?></td>
  <td><?=($total_14_bank_payment_ibbl+$total_C_bank_payment_ibbl)?></td>
  <td><strong>
    <?=($total_14_net_payable+$total_C_net_payable)?>
  </strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<tr>
  <td>4</td>
  <td>Group-D</td>
  <td><strong>
    <?=$total_14_actual_basic_salary+$total_D_actual_basic_salary;?>
  </strong></td>
  <td><strong>
    <?=$total_14_actual_special_allawance+$total_D_actual_special_allawance;?>
  </strong></td>
  <td><strong>
    <?=$total_14_ta_da_data+$total_D_ta_da_data;?>
  </strong></td>
  <td><strong>
    <?=(int)($total_14_basic_salary_payable+$total_D_basic_salary_payable);?>
  </strong></td>
  <td><strong>
    <?=($total_14_spl_alw_data+$total_D_spl_alw_data);?>
  </strong></td>
  <td><strong>
    <?=($total_14_ta_da+$total_D_ta_da);?>
  </strong></td>
  <td><strong>
    <?=($total_14_house_rent+$total_D_house_rent);?>
  </strong></td>
  <td><strong>
    <?=($total_14_vehicle_allowance+$total_D_vehicle_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_food_allowance+$total_D_food_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_mobile_allowance+$total_D_mobile_allowance);?>
  </strong></td>
  <td><strong>
    <?=($total_14_benefits+$total_D_benefits);?>
  </strong></td>
  <td><strong>
    <?=($total_14_other_benefits+$total_D_other_benefits);?>
  </strong></td>
  <td><strong>
    <?=($total_14_income_tax+$total_D_income_tax);?>
  </strong></td>
  <td><strong>
    <?=($total_14_advance_install+$total_D_advance_install);?>
  </strong></td>
  <td><strong>
    <?=($total_14_cooperative_share+$total_D_cooperative_share);?>
  </strong></td>
  <td><strong>
    <?=($total_14_motorcycle_install+$total_D_motorcycle_install);?>
  </strong></td>
  <td><strong>
    <?=($total_14_deduction+$total_D_deduction);?>
  </strong></td>
  <td>&nbsp;</td>
  <td><?=($total_14_help_up_paid+$total_D_help_up_paid)?></td>
  <td><strong>
    <?=($total_14_cash_payment+$total_D_cash_payment)?>
  </strong></td>
  <td><?=($total_14_bank_payment_dbbl+$total_D_bank_payment_dbbl)?></td>
  <td><?=($total_14_bank_payment_ibbl+$total_D_bank_payment_ibbl)?></td>
  <td><strong>
    <?=($total_14_net_payable+$total_D_net_payable)?>
  </strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<tr>
  <td>5</td>
<td>Group-E</td>
<td><strong><?=$total_14_actual_basic_salary+$total_E_actual_basic_salary;?></strong></td>
<td><strong><?=$total_14_actual_special_allawance+$total_E_actual_special_allawance;?></strong></td>
<td><strong><?=$total_14_ta_da_data+$total_E_ta_da_data;?></strong></td>
<td><strong><?=(int)($total_14_basic_salary_payable+$total_E_basic_salary_payable);?></strong></td>
<td><strong><?=($total_14_spl_alw_data+$total_E_spl_alw_data);?></strong></td>
<td><strong><?=($total_14_ta_da+$total_E_ta_da);?></strong></td>
<td><strong><?=($total_14_house_rent+$total_E_house_rent);?></strong></td>
<td><strong><?=($total_14_vehicle_allowance+$total_E_vehicle_allowance);?></strong></td>
<td><strong><?=($total_14_food_allowance+$total_E_food_allowance);?></strong></td>
<td><strong><?=($total_14_mobile_allowance+$total_E_mobile_allowance);?></strong></td>
<td><strong><?=($total_14_benefits+$total_E_benefits);?></strong></td>
<td><strong><?=($total_14_other_benefits+$total_E_other_benefits);?></strong></td>
<td><strong><?=($total_14_income_tax+$total_E_income_tax);?></strong></td>
<td><strong><?=($total_14_advance_install+$total_E_advance_install);?></strong></td>
<td><strong><?=($total_14_cooperative_share+$total_E_cooperative_share);?></strong></td>
<td><strong><?=($total_14_motorcycle_install+$total_E_motorcycle_install);?></strong></td>
<td><strong><?=($total_14_deduction+$total_E_deduction);?></strong></td>
<td>&nbsp;</td>
<td><?=($total_14_help_up_paid+$total_E_help_up_paid)?></td>
<td><strong><?=($total_14_cash_payment+$total_E_cash_payment)?></strong></td>
<td><?=($total_14_bank_payment_dbbl+$total_E_bank_payment_dbbl)?></td>
<td><?=($total_14_bank_payment_ibbl+$total_E_bank_payment_ibbl)?></td>
<td><strong><?=($total_14_net_payable+$total_E_net_payable)?></strong></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>

<tr>
  <td colspan="2">&nbsp;</td>
  <td><strong>
    <?=($total_14_actual_basic_salary*5)+$total_A_actual_basic_salary+$total_B_actual_basic_salary+$total_C_actual_basic_salary+$total_D_actual_basic_salary+$total_E_actual_basic_salary;?>
  </strong></td>
  <td><strong>
    <?=($total_14_actual_special_allawance*5)+$total_A_actual_special_allawance+$total_B_actual_special_allawance+$total_C_actual_special_allawance+$total_D_actual_special_allawance+$total_E_actual_special_allawance;?>
  </strong></td>
  <td><strong>
    <?=($total_14_ta_da_data*5)+$total_A_ta_da_data+$total_B_ta_da_data+$total_C_ta_da_data+$total_D_ta_da_data+$total_E_ta_da_data;?>
  </strong></td>
  <td><strong>
    <?=((int)($total_14_basic_salary_payable*5)+$total_A_basic_salary_payable+$total_B_basic_salary_payable+$total_C_basic_salary_payable+$total_D_basic_salary_payable+$total_E_basic_salary_payable);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_spl_alw_data*5)+$total_A_spl_alw_data+$total_B_spl_alw_data+$total_C_spl_alw_data+$total_D_spl_alw_data+$total_E_spl_alw_data);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_ta_da*5)+$total_A_ta_da+$total_B_ta_da+$total_C_ta_da+$total_D_ta_da+$total_E_ta_da);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_house_rent*5)+$total_A_house_rent+$total_B_house_rent+$total_C_house_rent+$total_D_house_rent+$total_E_house_rent);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_vehicle_allowance*5)+$total_A_vehicle_allowance+$total_B_vehicle_allowance+$total_C_vehicle_allowance+$total_D_vehicle_allowance+$total_E_vehicle_allowance);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_food_allowance*5)+$total_A_food_allowance+$total_B_food_allowance+$total_C_food_allowance+$total_D_food_allowance+$total_E_food_allowance);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_mobile_allowance*5)+$total_A_mobile_allowance+$total_B_mobile_allowance+$total_C_mobile_allowance+$total_D_mobile_allowance+$total_E_mobile_allowance);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_benefits*5)+$total_A_benefits+$total_B_benefits+$total_C_benefits+$total_D_benefits+$total_E_benefits);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_other_benefits*5)+$total_A_other_benefits+$total_B_other_benefits+$total_C_other_benefits+$total_D_other_benefits+$total_E_other_benefits);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_income_tax*5)+$total_A_income_tax+$total_B_income_tax+$total_C_income_tax+$total_D_income_tax+$total_E_income_tax);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_advance_install*5)+$total_A_advance_install+$total_B_advance_install+$total_C_advance_install+$total_D_advance_install+$total_E_advance_install);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_cooperative_share*5)+$total_A_cooperative_share+$total_B_cooperative_share+$total_C_cooperative_share+$total_D_cooperative_share+$total_E_cooperative_share);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_motorcycle_install*5)+$total_A_motorcycle_install+$total_B_motorcycle_install+$total_C_motorcycle_install+$total_D_motorcycle_install+$total_E_motorcycle_install);?>
  </strong></td>
  <td><strong>
    <?=(($total_14_deduction*5)+$total_A_deduction+$total_B_deduction+$total_C_deduction+$total_D_deduction+$total_E_deduction);?>
  </strong></td>
  <td>&nbsp;</td>
  <td><?=(($total_14_help_up_paid*5)+$total_A_help_up_paid+$total_B_help_up_paid+$total_C_help_up_paid+$total_D_help_up_paid+$total_E_help_up_paid)?></td>
  <td><strong><?=(($total_14_cash_payment*5)+$total_A_cash_payment+$total_B_cash_payment+$total_C_cash_payment+$total_D_cash_payment+$total_E_cash_payment)?>
  </strong></td>
  <td><?=(($total_14_bank_payment_dbbl*5)+$total_A_bank_payment_dbbl+$total_B_bank_payment_dbbl+$total_C_bank_payment_dbbl+$total_D_bank_payment_dbbl+$total_E_bank_payment_dbbl)?></td>
  <td><?=(($total_14_bank_payment_ibbl*5)+$total_A_bank_payment_ibbl+$total_B_bank_payment_ibbl+$total_C_bank_payment_ibbl+$total_D_bank_payment_ibbl+$total_E_bank_payment_ibbl)?></td>
  <td><strong><?=(($total_14_net_payable*5)+$total_A_net_payable+$total_B_net_payable+$total_C_net_payable+$total_D_net_payable+$total_E_net_payable)?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==7801){ // Region Wise Sales Salary Brief Report(Without HO)

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="31"><?=$str?></th></tr>

<tr>

<th rowspan="3">S/L</th>
<th rowspan="3">Region Name</th>
<th colspan="3">Basic Information </th>
<th colspan="9"><div>Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction</div></th>
<th colspan="6"><div>Payable Amount (Taka) </div></th>
<th colspan="4"><div>View Only </div></th>
<th rowspan="3">Remarks</th>
</tr>
<tr class="vertical-text">
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/house_rent.JPG" /></th>
  <th rowspan="2"><img src="images/car.JPG" /></th>
  <th rowspan="2"><img src="images/food.JPG" /></th>
  <th rowspan="2"><img src="images/mobile.JPG" /></th>
  <th rowspan="2"><img src="images/arear.JPG" /></th>
  <th rowspan="2"><img src="images/other.JPG" /></th>
  <th rowspan="2"><img src="images/ait.JPG" /></th>
  <th rowspan="2"><img src="images/advance_salary.JPG" /></th>
  <th rowspan="2"><img src="images/co-op-fund.JPG" /></th>
  <th rowspan="2"><img src="images/bike.JPG" /></th>
  <th rowspan="2"><img src="images/excess_mobile.JPG" /></th>
  <th rowspan="2"><img src="images/administrative.JPG" /></th>
  <th rowspan="2">H-Up</th>
  <th rowspan="2"><img src="images/cash.JPG" /></th>
  <th colspan="3">BANK</th>
  <th rowspan="2"><img src="images/total_salary.JPG" /></th>
  <th rowspan="2"><img src="images/last_salary.JPG" /></th>
  <th rowspan="2"><img src="images/diff.JPG" /></th>
  <th rowspan="2"><img src="images/late_attendence.JPG" /></th>
  <th rowspan="2"><img src="images/absent_lwp.JPG" /></th>
</tr>
<tr class="vertical-text">
  <th>DBBL</th>
  <th>Rocket</th>
  <th>IBBL</th>
</tr>
</thead>
<tbody>
<?
$sqld = 'select t.pbi_region PBI_BRANCH,
sum(s.basic_salary) actual_basic_salary,
sum(s.special_allowance) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.administrative_deduction) administrative_deduction,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,
sum(t.spl_alw_data) actual_special_allawance,

sum(t.absent_deduction) absent_deduction,
t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region>0 and t.pbi_department="Sales" '.$PBI_GROUP_con.' group by t.pbi_region';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
<td><?=find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$data->PBI_BRANCH)?></td>
<td><?=round($data->actual_basic_salary)?><? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?></td>

<td><?=round($data->actual_special_allawance)?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?></td>

<td><?=round($data->ta_da_data)?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?></td>
<td><?=round($data->basic_salary_payable)?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?></td>
<td><?=round($data->special_allowance)?><? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance;?></td>
<td><?=round($data->ta_da)?><? $total_ta_da = $total_ta_da + $data->ta_da;?></td>
<td><?=round($data->house_rent)?><? $total_house_rent = $total_house_rent + $data->house_rent;?></td>
<td><?=round($data->vehicle_allowance)?><? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance;?></td>
<td><?=round($data->food_allowance)?><? $total_food_allowance = $total_food_allowance + $data->food_allowance;?></td>
<td><?=round($data->mobile_allowance)?><? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance;?></td>

<td><?=round($data->benefits)?><? $total_benefits = $total_benefits + $data->benefits;?></td>
<td><?=round($data->other_benefits)?><? $total_other_benefits = $total_other_benefits + $data->other_benefits;?></td>
<td><?=round($data->income_tax)?><? $total_income_tax = $total_income_tax + $data->income_tax;?></td>
<td><?=round($data->total_install)?><? $total_advance_install = $total_advance_install + $data->total_install;?></td>

<td><?=round($data->cooperative_share)?><? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?></td>
<td><?=round($data->motorcycle_install)?><? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?></td>
<td><?=round($data->deduction)?><? $total_deduction = $total_deduction + $data->deduction;?></td>
<td><?=round($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

  <td><? echo $help_up_paid = round(find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up="1" and t.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con)); $total_help_up_paid = $total_help_up_paid + $help_up_paid;?></td>
  <td><? echo $cash_paid=round(find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up="0" and t.PBI_ID=a.PBI_ID  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con)); $total_cash_payment = $total_cash_payment + $cash_paid; ?></td>

  <td><? echo $dbbl_paid=round(find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up="0" and t.bank_name="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con)); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?></td>

  <td><? echo $rocket_paid=round(find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up="0" and t.bank_name="ROCKET" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con)); $total_bank_payment_rocket = $total_bank_payment_rocket + $rocket_paid;?></td>
  <td><? echo $ibbl_paid=round(find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up="0" and t.bank_name="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con)); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?></td>

  <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = round(find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up="0" and t.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.pbi_region="'.$data->PBI_BRANCH.'" '.$PBI_GROUP_con));$total_net_payable = $total_net_payable + $net_payable;?></span></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="2">&nbsp;</td>
  <td><strong><?=round($total_actual_basic_salary);?></strong></td>
  <td><strong><?=round($total_actual_special_allawance);?></strong></td>
  <td><strong><?=round($total_ta_da_data);?></strong></td>
  <td><strong><?=round($total_basic_salary_payable);?></strong></td>
  <td><strong><?=round($total_spl_alw_data);?></strong></td>
  <td><strong><?=round($total_ta_da);?></strong></td>
  <td><strong><?=round($total_house_rent);?></strong></td>
  <td><strong><?=round($total_vehicle_allowance);?></strong></td>
  <td><strong><?=round($total_food_allowance);?></strong></td>
  <td><strong><?=round($total_mobile_allowance);?></strong></td>
  <td><strong><?=round($total_benefits);?></strong></td>
  <td><strong><?=round($total_other_benefits);?></strong></td>
  <td><strong><?=round($total_income_tax);?></strong></td>
  <td><strong><?=round($total_advance_install);?></strong></td>
  <td><strong><?=round($total_cooperative_share);?></strong></td>
  <td><strong><?=round($total_motorcycle_install);?></strong></td>
  <td><strong><?=round($total_deduction);?></strong></td>
  <td><strong><?=round($total_administrative_deduction);?></strong></td>
  <td><strong><?=round($total_help_up_paid);?></strong></td>
  <td><strong><?=round($total_cash_payment);?></strong></td>
  <td><strong><?=round($total_bank_payment_dbbl);?></strong></td>
  <td><strong>
    <?=round($total_bank_payment_rocket);?>
  </strong></td>
  <td><strong><?=round($total_bank_payment_ibbl);?></strong></td>
  <td><strong><?=round($total_net_payable);?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==7800)
{

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="28"><?=$str?></th></tr>

<tr>

<th rowspan="3">S/L</th>
<th rowspan="3">Store Name</th>
<th rowspan="3">Nos</th>
<th colspan="3">Basic Information </th>
<th colspan="9"><div>Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction</div></th>
<th colspan="5"><div>Payable Amount (Taka) </div></th>
<th><div>View Only </div></th>
<th rowspan="3">Remarks</th>
</tr>
<tr class="vertical-text">
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/house_rent.JPG" /></th>
  <th rowspan="2"><img src="images/car.JPG" /></th>
  <th rowspan="2"><img src="images/food.JPG" /></th>
  <th rowspan="2"><img src="images/mobile.JPG" /></th>
  <th rowspan="2"><img src="images/arear.JPG" /></th>
  <th rowspan="2"><img src="images/other.JPG" /></th>
  <th rowspan="2"><img src="images/ait.JPG" /></th>
  <th rowspan="2"><img src="images/advance_salary.JPG" /></th>
  <th rowspan="2"><img src="images/co-op-fund.JPG" /></th>
  <th rowspan="2"><img src="images/bike.JPG" /></th>
  <th rowspan="2"><img src="images/excess_mobile.JPG" /></th>
  <th rowspan="2"><img src="images/administrative.JPG" /></th>
  <th rowspan="2">H-Up</th>
  <th rowspan="2"><img src="images/cash.JPG" /></th>
  <th colspan="2">BANK</th>
  <th rowspan="2"><img src="images/total_salary.JPG" /></th>
  <th rowspan="2"><img src="images/last_salary.JPG" /></th>
  </tr>
<tr class="vertical-text">
  <th>DBBL</th>
  <th>IBBL</th>
</tr>
</thead>
<tbody>

<?
$sqld = 'select count(1) nos,a.JOB_LOCATION,o.LOCATION_NAME,
sum(s.basic_salary) actual_basic_salary,
sum(s.special_allowance) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,
sum(t.administrative_deduction) administrative_deduction,

sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s,office_location o where o.ID=a.JOB_LOCATION and d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT like "%STO%" '.$DEPARTMENT_con.' group by a.JOB_LOCATION';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
  <td><?=$data->LOCATION_NAME?></td>
  <td><?=$data->nos?><? $total_nos = $total_nos + $data->nos?></td>
<td><?=(int)$data->actual_basic_salary?><? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?></td>
  <td><?=(int)$data->actual_special_allawance?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?></td>
  <td><?=$data->ta_da_data?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?></td>
  <td><?=(int)$data->basic_salary_payable?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?></td>
  <td><?=(int)$data->special_allowance?><? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance;?></td>
  <td><?=$data->ta_da?><? $total_ta_da = $total_ta_da + $data->ta_da;?></td>
  <td><?=round($data->house_rent);?><? $total_house_rent = $total_house_rent + $data->house_rent;?></td>
  <td><?=$data->vehicle_allowance?><? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance;?></td>
  <td><?=$data->food_allowance?><? $total_food_allowance = $total_food_allowance + $data->food_allowance;?></td>
  <td><?=$data->mobile_allowance?><? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance;?></td>

  <td><?=$data->benefits?><? $total_benefits = $total_benefits + $data->benefits;?></td>
  <td><?=$data->other_benefits?><? $total_other_benefits = $total_other_benefits + $data->other_benefits;?></td>
  <td><?=$data->income_tax?><? $total_income_tax = $total_income_tax + $data->income_tax;?></td>
  <td><?=$data->total_install?><? $total_advance_install = $total_advance_install + $data->total_install;?></td>

  <td><?=$data->cooperative_share?><? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?></td>
  <td><?=$data->motorcycle_install?><? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?></td>
  <td><?=$data->deduction?><? $total_deduction = $total_deduction + $data->deduction;?></td>
  <td><?=number_format($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

  <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and a.JOB_LOCATION="'.$data->JOB_LOCATION.'" '.$DEPARTMENT_con); $total_help_up_paid = $total_help_up_paid + $help_up_paid;?></td>
  <td><? echo $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and a.JOB_LOCATION="'.$data->JOB_LOCATION.'" '.$DEPARTMENT_con); $total_cash_payment = $total_cash_payment + $cash_paid; ?></td>

  <td><? echo $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and a.JOB_LOCATION="'.$data->JOB_LOCATION.'" '.$DEPARTMENT_con); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?></td>

  <td><? echo $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and a.JOB_LOCATION="'.$data->JOB_LOCATION.'" '.$DEPARTMENT_con); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?></td>

  <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and a.JOB_LOCATION="'.$data->JOB_LOCATION.'" '.$DEPARTMENT_con);$total_net_payable = $total_net_payable + $net_payable;?></span></td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="2">&nbsp;</td>
  <td><strong>
    <?=$total_nos;?>
  </strong></td>
  <td><strong><?=$total_actual_basic_salary;?></strong></td>
  <td><strong><?=$total_actual_special_allawance;?></strong></td>
  <td><strong><?=$total_ta_da_data;?></strong></td>
  <td><strong><?=(int)$total_basic_salary_payable;?></strong></td>
  <td><strong><?=$total_spl_alw_data;?></strong></td>
  <td><strong><?=$total_ta_da;?></strong></td>
  <td><strong><?=round($total_house_rent);?></strong></td>
  <td><strong><?=$total_vehicle_allowance;?></strong></td>
  <td><strong><?=$total_food_allowance;?></strong></td>
  <td><strong><?=$total_mobile_allowance;?></strong></td>
  <td><strong><?=$total_benefits;?></strong></td>
  <td><strong><?=$total_other_benefits;?></strong></td>
  <td><strong><?=$total_income_tax;?></strong></td>
  <td><strong><?=$total_advance_install;?></strong></td>
  <td><strong><?=$total_cooperative_share;?></strong></td>
  <td><strong><?=$total_motorcycle_install;?></strong></td>
  <td><strong><?=$total_deduction;?></strong></td>
  <td><strong><?=$total_administrative_deduction;?></strong></td>
  <td><?=$total_help_up_paid?></td>
  <td><strong><?=$total_cash_payment?></strong></td>
  <td><?=$total_bank_payment_dbbl?></td>
  <td><?=$total_bank_payment_ibbl?></td>
  <td><strong><?=$total_net_payable?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==784)
{

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="28"><?=$str?></th></tr>

<tr>

<th rowspan="3">S/L</th>
<th rowspan="3">Department</th>
<th rowspan="3">Nos</th>
<th colspan="3">Basic Information </th>
<th colspan="9"><div>Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction</div></th>
<th colspan="5"><div>Payable Amount (Taka) </div></th>
<th><div>View Only </div></th>
<th rowspan="3">Remarks</th>
</tr>
<tr class="vertical-text">
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/house_rent.JPG" /></th>
  <th rowspan="2"><img src="images/car.JPG" /></th>
  <th rowspan="2"><img src="images/food.JPG" /></th>
  <th rowspan="2"><img src="images/mobile.JPG" /></th>
  <th rowspan="2"><img src="images/arear.JPG" /></th>
  <th rowspan="2"><img src="images/other.JPG" /></th>
  <th rowspan="2"><img src="images/ait.JPG" /></th>
  <th rowspan="2"><img src="images/advance_salary.JPG" /></th>
  <th rowspan="2"><img src="images/co-op-fund.JPG" /></th>
  <th rowspan="2"><img src="images/bike.JPG" /></th>
  <th rowspan="2"><img src="images/excess_mobile.JPG" /></th>
  <th rowspan="2"><img src="images/administrative.JPG" /></th>
  <th rowspan="2">H-Up</th>
  <th rowspan="2"><img src="images/cash.JPG" /></th>
  <th colspan="2">BANK</th>
  <th rowspan="2"><img src="images/total_salary.JPG" /></th>
  <th rowspan="2"><img src="images/last_salary.JPG" /></th>
  </tr>
<tr class="vertical-text">
  <th>DBBL</th>
  <th>IBBL</th>
</tr>
</thead>
<tbody>

<?
$sqld = 'select a.PBI_DEPARTMENT,
sum(s.basic_salary) actual_basic_salary,
sum(s.special_allowance) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,

sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID  and PBI_ORG in (1,2) and t.pbi_region =0 group by a.PBI_DEPARTMENT';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
  <td><?=find_a_field('department','DEPT_DESC','DEPT_SHORT_NAME="'.$data->PBI_DEPARTMENT.'"')?></td>
  <td><?=$data->nos?>
    <? $total_nos = $total_nos + $data->nos?></td>
<td><?=(int)$data->actual_basic_salary?><? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?></td>
  <td><?=(int)$data->actual_special_allawance?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?></td>
  <td><?=$data->ta_da_data?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?></td>
  <td><?=(int)$data->basic_salary_payable?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?></td>
  <td><?=(int)$data->special_allowance?><? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance;?></td>
  <td><?=$data->ta_da?><? $total_ta_da = $total_ta_da + $data->ta_da;?></td>
  <td><?=$data->house_rent?><? $total_house_rent = $total_house_rent + $data->house_rent;?></td>
  <td><?=round($data->vehicle_allowance)?><? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance;?></td>
  <td><?=$data->food_allowance?><? $total_food_allowance = $total_food_allowance + $data->food_allowance;?></td>
  <td><?=$data->mobile_allowance?><? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance;?></td>

  <td><?=$data->benefits?><? $total_benefits = $total_benefits + $data->benefits;?></td>
  <td><?=$data->other_benefits?><? $total_other_benefits = $total_other_benefits + $data->other_benefits;?></td>
  <td><?=$data->income_tax?><? $total_income_tax = $total_income_tax + $data->income_tax;?></td>
  <td><?=$data->total_install?><? $total_advance_install = $total_advance_install + $data->total_install;?></td>

  <td><?=$data->cooperative_share?><? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?></td>
  <td><?=$data->motorcycle_install?><? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?></td>
  <td><?=$data->deduction?><? $total_deduction = $total_deduction + $data->deduction;?></td>
  <td><?=number_format($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

  <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and a.PBI_DEPARTMENT="'.$data->PBI_DEPARTMENT.'" and PBI_ORG in (1,2) and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_help_up_paid = $total_help_up_paid + $help_up_paid;?></td>
  <td><? echo $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and a.PBI_DEPARTMENT="'.$data->PBI_DEPARTMENT.'"  and PBI_ORG in (1,2) and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].''); $total_cash_payment = $total_cash_payment + $cash_paid; ?></td>

  <td><? echo $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and a.PBI_DEPARTMENT="'.$data->PBI_DEPARTMENT.'" and PBI_ORG in (1,2) and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?></td>

  <td><? echo $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and a.PBI_DEPARTMENT="'.$data->PBI_DEPARTMENT.'" and PBI_ORG in (1,2) and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?></td>

  <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and a.PBI_DEPARTMENT="'.$data->PBI_DEPARTMENT.'" and PBI_ORG in (1,2) and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_net_payable = $total_net_payable + $net_payable;?></span></td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="2">&nbsp;</td>
  <td><strong>
    <?=$total_nos;?>
  </strong></td>
  <td><strong><?=$total_actual_basic_salary;?></strong></td>
  <td><strong><?=$total_actual_special_allawance;?></strong></td>
  <td><strong><?=$total_ta_da_data;?></strong></td>
  <td><strong><?=(int)$total_basic_salary_payable;?></strong></td>
  <td><strong><?=$total_spl_alw_data;?></strong></td>
  <td><strong><?=$total_ta_da;?></strong></td>
  <td><strong><?=$total_house_rent;?></strong></td>
  <td><strong><?=round($total_vehicle_allowance);?></strong></td>
  <td><strong><?=$total_food_allowance;?></strong></td>
  <td><strong><?=$total_mobile_allowance;?></strong></td>
  <td><strong><?=$total_benefits;?></strong></td>
  <td><strong><?=$total_other_benefits;?></strong></td>
  <td><strong><?=$total_income_tax;?></strong></td>
  <td><strong><?=$total_advance_install;?></strong></td>
  <td><strong><?=$total_cooperative_share;?></strong></td>
  <td><strong><?=$total_motorcycle_install;?></strong></td>
  <td><strong><?=$total_deduction;?></strong></td>
  <td>&nbsp;</td>
  <td><?=$total_help_up_paid?></td>
  <td><strong><?=$total_cash_payment?></strong></td>
  <td><?=$total_bank_payment_dbbl?></td>
  <td><?=$total_bank_payment_ibbl?></td>
  <td><strong><?=$total_net_payable?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==7841)
{

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="28"><?=$str?></th></tr>

<tr>

<th rowspan="3">S/L</th>
<th rowspan="3">Department</th>
<th rowspan="3">Nos</th>
<th colspan="3">Basic Information </th>
<th colspan="9"><div>Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction</div></th>
<th colspan="5"><div>Payable Amount (Taka) </div></th>
<th><div>View Only </div></th>
<th rowspan="3">Remarks</th>
</tr>
<tr class="vertical-text">
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/house_rent.JPG" /></th>
  <th rowspan="2"><img src="images/car.JPG" /></th>
  <th rowspan="2"><img src="images/food.JPG" /></th>
  <th rowspan="2"><img src="images/mobile.JPG" /></th>
  <th rowspan="2"><img src="images/arear.JPG" /></th>
  <th rowspan="2"><img src="images/other.JPG" /></th>
  <th rowspan="2"><img src="images/ait.JPG" /></th>
  <th rowspan="2"><img src="images/advance_salary.JPG" /></th>
  <th rowspan="2"><img src="images/co-op-fund.JPG" /></th>
  <th rowspan="2"><img src="images/bike.JPG" /></th>
  <th rowspan="2"><img src="images/excess_mobile.JPG" /></th>
  <th rowspan="2"><img src="images/administrative.JPG" /></th>
  <th rowspan="2">H-Up</th>
  <th rowspan="2"><img src="images/cash.JPG" /></th>
  <th colspan="2">BANK</th>
  <th rowspan="2"><img src="images/total_salary.JPG" /></th>
  <th rowspan="2"><img src="images/last_salary.JPG" /></th>
  </tr>
<tr class="vertical-text">
  <th>DBBL</th>
  <th>IBBL</th>
</tr>
</thead>
<tbody>

<?
$sqld = 'select t.pbi_department PBI_DEPARTMENT,
count(1) nos,
sum(s.basic_salary) actual_basic_salary,
sum(t.spl_alw_data) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,
sum(t.administrative_deduction) administrative_deduction,
sum(t.absent_deduction) absent_deduction,
t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s
where
d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].'
and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and PBI_ORG in (1,2)
and t.pbi_department not in ("STO", "Store (Transport)","Admin (Support Service Section)","CR")
and t.pbi_region =0
group by t.pbi_department';

$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;

?>
<tr><td><?=++$s?></td>
  <td><?=find_a_field('department','DEPT_DESC','DEPT_SHORT_NAME="'.$data->PBI_DEPARTMENT.'"')?></td>
  <td><?=(int)$data->nos?><? $total_nos = $total_nos + $data->nos;?></td>
<td><?=(int)$data->actual_basic_salary?><? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?></td>
  <td><?=(int)$data->actual_special_allawance?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?></td>
  <td><?=$data->ta_da_data?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?></td>
  <td><?=(int)$data->basic_salary_payable?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?></td>
  <td><?=(int)$data->special_allowance?><? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance;?></td>
  <td><?=$data->ta_da?><? $total_ta_da = $total_ta_da + $data->ta_da;?></td>
  <td><?=round($data->house_rent)?><? $total_house_rent = $total_house_rent + $data->house_rent;?></td>
  <td><?=round($data->vehicle_allowance)?><? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance;?></td>
  <td><?=$data->food_allowance?><? $total_food_allowance = $total_food_allowance + $data->food_allowance;?></td>
  <td><?=$data->mobile_allowance?><? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance;?></td>

  <td><?=$data->benefits?><? $total_benefits = $total_benefits + $data->benefits;?></td>
  <td><?=$data->other_benefits?><? $total_other_benefits = $total_other_benefits + $data->other_benefits;?></td>
  <td><?=$data->income_tax?><? $total_income_tax = $total_income_tax + $data->income_tax;?></td>
  <td><?=$data->total_install?><? $total_advance_install = $total_advance_install + $data->total_install;?></td>

  <td><?=$data->cooperative_share?><? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?></td>
  <td><?=$data->motorcycle_install?><? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?></td>
  <td><?=$data->deduction?><? $total_deduction = $total_deduction + $data->deduction;?></td>
  <td><?=number_format($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

  <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'" and PBI_ORG in (1,2) and t.pbi_department not in ("STO", "Store (Transport)") and t.pbi_department !="Admin (Support Service Section)" and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_help_up_paid = $total_help_up_paid + $help_up_paid;?></td>
  <td><? echo $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'"  and PBI_ORG in (1,2) and t.pbi_department not in ("STO", "Store (Transport)") and t.pbi_department !="Admin (Support Service Section)" and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].''); $total_cash_payment = $total_cash_payment + $cash_paid; ?></td>

  <td><? echo $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'" and PBI_ORG in (1,2) and t.pbi_department not in ("STO", "Store (Transport)") and t.pbi_department !="Admin (Support Service Section)" and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?></td>

  <td><? echo $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'" and PBI_ORG in (1,2) and t.pbi_department not in ("STO", "Store (Transport)") and t.pbi_department !="Admin (Support Service Section)" and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?></td>

  <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'" and PBI_ORG in (1,2) and t.pbi_department not in ("STO", "Store (Transport)") and t.pbi_department !="Admin (Support Service Section)" and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_net_payable = $total_net_payable + $net_payable;?></span></td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="2">&nbsp;</td>
  <td><strong><?=$total_nos?></strong></td>
  <td><strong><?=$total_actual_basic_salary;?></strong></td>
  <td><strong><?=$total_actual_special_allawance;?></strong></td>
  <td><strong><?=$total_ta_da_data;?></strong></td>
  <td><strong><?=(int)$total_basic_salary_payable;?></strong></td>
  <td><strong><?=$total_spl_alw_data;?></strong></td>
  <td><strong><?=$total_ta_da;?></strong></td>
  <td><strong><?=round($total_house_rent);?></strong></td>
  <td><strong><?=round($total_vehicle_allowance);?></strong></td>
  <td><strong><?=$total_food_allowance;?></strong></td>
  <td><strong><?=$total_mobile_allowance;?></strong></td>
  <td><strong><?=$total_benefits;?></strong></td>
  <td><strong><?=$total_other_benefits;?></strong></td>
  <td><strong><?=$total_income_tax;?></strong></td>
  <td><strong><?=$total_advance_install;?></strong></td>
  <td><strong><?=$total_cooperative_share;?></strong></td>
  <td><strong><?=$total_motorcycle_install;?></strong></td>
  <td><strong><?=$total_deduction;?></strong></td>
  <td><strong>
    <?=round($total_administrative_deduction);?>
  </strong></td>
  <td><?=$total_help_up_paid?></td>
  <td><strong><?=$total_cash_payment?></strong></td>
  <td><?=$total_bank_payment_dbbl?></td>
  <td><?=$total_bank_payment_ibbl?></td>
  <td><strong><?=$total_net_payable?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==78411)
{

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="30"><?=$str?></th></tr>

<tr>

<th rowspan="3">S/L</th>
<th rowspan="3">Department</th>
<th rowspan="3">Nos</th>
<th colspan="3">Basic Information </th>
<th colspan="9"><div>Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction</div></th>
<th colspan="7"><div>Payable Amount (Taka) </div></th>
<th><div>View Only </div></th>
<th rowspan="3">Remarks</th>
</tr>
<tr class="vertical-text">
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/house_rent.JPG" /></th>
  <th rowspan="2"><img src="images/car.JPG" /></th>
  <th rowspan="2"><img src="images/food.JPG" /></th>
  <th rowspan="2"><img src="images/mobile.JPG" /></th>
  <th rowspan="2"><img src="images/arear.JPG" /></th>
  <th rowspan="2"><img src="images/other.JPG" /></th>
  <th rowspan="2"><img src="images/ait.JPG" /></th>
  <th rowspan="2"><img src="images/advance_salary.JPG" /></th>
  <th rowspan="2"><img src="images/co-op-fund.JPG" /></th>
  <th rowspan="2"><img src="images/bike.JPG" /></th>
  <th rowspan="2"><img src="images/excess_mobile.JPG" /></th>
  <th rowspan="2"><img src="images/administrative.JPG" /></th>
  <th rowspan="2">H-Up</th>
  <th rowspan="2"><img src="images/cash.JPG" /></th>
  <th colspan="4">BANK</th>
  <th rowspan="2"><img src="images/total_salary.JPG" /></th>
  <th rowspan="2"><img src="images/last_salary.JPG" /></th>
  </tr>
<tr class="vertical-text">
  <th>DBBL</th>
  <th>EBL</th>
  <th>NCC</th>
  <th>IBBL</th>
</tr>
</thead>
<tbody>

<?
if($_POST['PBI_ORG']>0) $org_con = ' and PBI_ORG ="'.$_POST['PBI_ORG'].'" ';
$sqld = 'select t.pbi_department PBI_DEPARTMENT,
count(1) nos,
sum(t.basic_salary) actual_basic_salary,
sum(t.spl_alw_data) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,
sum(t.administrative_deduction) administrative_deduction,
sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 '.$org_con.' group by t.pbi_department';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;

?>
<tr><td><?=++$s?></td>
  <td><?=find_a_field('department','DEPT_DESC','DEPT_SHORT_NAME="'.$data->PBI_DEPARTMENT.'"')?></td>
  <td><?=(int)$data->nos?><? $total_nos = $total_nos + $data->nos;?></td>
<td><?=(int)$data->actual_basic_salary?><? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?></td>
  <td><?=(int)$data->actual_special_allawance?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?></td>
  <td><?=$data->ta_da_data?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?></td>
  <td><?=(int)$data->basic_salary_payable?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?></td>
  <td><?=(int)$data->special_allowance?><? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance;?></td>
  <td><?=$data->ta_da?><? $total_ta_da = $total_ta_da + $data->ta_da;?></td>
  <td><?=$data->house_rent?><? $total_house_rent = $total_house_rent + $data->house_rent;?></td>
  <td><?=round($data->vehicle_allowance)?><? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance;?></td>
  <td><?=$data->food_allowance?><? $total_food_allowance = $total_food_allowance + $data->food_allowance;?></td>
  <td><?=$data->mobile_allowance?><? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance;?></td>

  <td><?=$data->benefits?><? $total_benefits = $total_benefits + $data->benefits;?></td>
  <td><?=$data->other_benefits?><? $total_other_benefits = $total_other_benefits + $data->other_benefits;?></td>
  <td><?=$data->income_tax?><? $total_income_tax = $total_income_tax + $data->income_tax;?></td>
  <td><?=$data->total_install?><? $total_advance_install = $total_advance_install + $data->total_install;?></td>

  <td><?=$data->cooperative_share?><? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?></td>
  <td><?=$data->motorcycle_install?><? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?></td>
  <td><?=$data->deduction?><? $total_deduction = $total_deduction + $data->deduction;?></td>
  <td><?=number_format($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

  <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_help_up_paid = $total_help_up_paid + $help_up_paid;?></td>
  <td><? echo $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'"  '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].''); $total_cash_payment = $total_cash_payment + $cash_paid; ?></td>

  <td><? echo $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?></td>

  <td><? echo $ebl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="EBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_ebl = $total_bank_payment_ebl + $ebl_paid;?></td>
  <td><? echo $ncc_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="NCC" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_ncc = $total_bank_payment_ncc + $ncc_paid;?></td>
  <td><? echo $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?></td>

  <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_net_payable = $total_net_payable + $net_payable;?></span></td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="2">&nbsp;</td>
  <td><strong><?=$total_nos?></strong></td>
  <td><strong><?=$total_actual_basic_salary;?></strong></td>
  <td><strong><?=$total_actual_special_allawance;?></strong></td>
  <td><strong><?=$total_ta_da_data;?></strong></td>
  <td><strong><?=(int)$total_basic_salary_payable;?></strong></td>
  <td><strong><?=$total_spl_alw_data;?></strong></td>
  <td><strong><?=$total_ta_da;?></strong></td>
  <td><strong><?=$total_house_rent;?></strong></td>
  <td><strong><?=round($total_vehicle_allowance);?></strong></td>
  <td><strong><?=$total_food_allowance;?></strong></td>
  <td><strong><?=$total_mobile_allowance;?></strong></td>
  <td><strong><?=$total_benefits;?></strong></td>
  <td><strong><?=$total_other_benefits;?></strong></td>
  <td><strong><?=$total_income_tax;?></strong></td>
  <td><strong><?=$total_advance_install;?></strong></td>
  <td><strong><?=$total_cooperative_share;?></strong></td>
  <td><strong><?=$total_motorcycle_install;?></strong></td>
  <td><strong><?=$total_deduction;?></strong></td>
  <td><strong>
    <?=round($total_administrative_deduction);?>
  </strong></td>
  <td><?=$total_help_up_paid?></td>
  <td><strong><?=$total_cash_payment?></strong></td>
  <td><?=$total_bank_payment_dbbl?></td>
  <td><?=$total_bank_payment_ebl?></td>
  <td><?=$total_bank_payment_ncc?></td>
  <td><?=$total_bank_payment_ibbl?></td>
  <td><strong><?=$total_net_payable?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==78412)
{

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="30"><?=$str?></th></tr>

<tr>

<th rowspan="3">S/L</th>
<th rowspan="3">Location</th>
<th rowspan="3">Nos</th>
<th colspan="3">Basic Information </th>
<th colspan="9"><div>Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction</div></th>
<th colspan="7"><div>Payable Amount (Taka) </div></th>
<th><div>View Only </div></th>
<th rowspan="3">Remarks</th>
</tr>
<tr class="vertical-text">
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/house_rent.JPG" /></th>
  <th rowspan="2"><img src="images/car.JPG" /></th>
  <th rowspan="2"><img src="images/food.JPG" /></th>
  <th rowspan="2"><img src="images/mobile.JPG" /></th>
  <th rowspan="2"><img src="images/arear.JPG" /></th>
  <th rowspan="2"><img src="images/other.JPG" /></th>
  <th rowspan="2"><img src="images/ait.JPG" /></th>
  <th rowspan="2"><img src="images/advance_salary.JPG" /></th>
  <th rowspan="2"><img src="images/co-op-fund.JPG" /></th>
  <th rowspan="2"><img src="images/bike.JPG" /></th>
  <th rowspan="2"><img src="images/excess_mobile.JPG" /></th>
  <th rowspan="2"><img src="images/administrative.JPG" /></th>
  <th rowspan="2">H-Up</th>
  <th rowspan="2"><img src="images/cash.JPG" /></th>
  <th colspan="4">BANK</th>
  <th rowspan="2"><img src="images/total_salary.JPG" /></th>
  <th rowspan="2"><img src="images/last_salary.JPG" /></th>
  </tr>
<tr class="vertical-text">
  <th>DBBL</th>
  <th>EBL</th>
  <th>NCC</th>
  <th>IBBL</th>
</tr>
</thead>
<tbody>

<?
if($_POST['PBI_ORG']>0) $org_con = ' and PBI_ORG ="'.$_POST['PBI_ORG'].'" ';
 $sqld = 'select t.pbi_job_location job_location ,
count(1) nos,
sum(s.basic_salary) actual_basic_salary,
sum(s.special_allowance) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,
sum(t.administrative_deduction) administrative_deduction,
sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 '.$org_con.' group by t.pbi_job_location';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;

?>
<tr><td><?=++$s?></td>
  <td><?=find_a_field('office_location','LOCATION_NAME','ID="'.$data->job_location.'"')?></td>
  <td><?=(int)$data->nos?><? $total_nos = $total_nos + $data->nos;?></td>
<td><?=(int)$data->actual_basic_salary?><? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?></td>
  <td><?=(int)$data->actual_special_allawance?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?></td>
  <td><?=$data->ta_da_data?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?></td>
  <td><?=(int)$data->basic_salary_payable?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?></td>
  <td><?=(int)$data->special_allowance?><? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance;?></td>
  <td><?=$data->ta_da?><? $total_ta_da = $total_ta_da + $data->ta_da;?></td>
  <td><?=$data->house_rent?><? $total_house_rent = $total_house_rent + $data->house_rent;?></td>
  <td><?=round($data->vehicle_allowance)?><? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance;?></td>
  <td><?=$data->food_allowance?><? $total_food_allowance = $total_food_allowance + $data->food_allowance;?></td>
  <td><?=$data->mobile_allowance?><? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance;?></td>

  <td><?=$data->benefits?><? $total_benefits = $total_benefits + $data->benefits;?></td>
  <td><?=$data->other_benefits?><? $total_other_benefits = $total_other_benefits + $data->other_benefits;?></td>
  <td><?=$data->income_tax?><? $total_income_tax = $total_income_tax + $data->income_tax;?></td>
  <td><?=$data->total_install?><? $total_advance_install = $total_advance_install + $data->total_install;?></td>

  <td><?=$data->cooperative_share?><? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?></td>
  <td><?=$data->motorcycle_install?><? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?></td>
  <td><?=$data->deduction?><? $total_deduction = $total_deduction + $data->deduction;?></td>
  <td><?=number_format($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

  <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="'.$data->job_location.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_help_up_paid = $total_help_up_paid + $help_up_paid;?></td>
  <td><? echo $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="'.$data->job_location.'"  '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].''); $total_cash_payment = $total_cash_payment + $cash_paid; ?></td>

  <td><? echo $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location="'.$data->job_location.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?></td>

  <td><? echo $ebl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="EBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location="'.$data->job_location.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_ebl = $total_bank_payment_ebl + $ebl_paid;?></td>
  <td><? echo $ncc_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="NCC" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location="'.$data->job_location.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_ncc = $total_bank_payment_ncc + $ncc_paid;?></td>
  <td><? echo $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location="'.$data->job_location.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?></td>

  <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="'.$data->job_location.'" '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_net_payable = $total_net_payable + $net_payable;?></span></td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="2">&nbsp;</td>
  <td><strong><?=$total_nos?></strong></td>
  <td><strong><?=$total_actual_basic_salary;?></strong></td>
  <td><strong><?=$total_actual_special_allawance;?></strong></td>
  <td><strong><?=$total_ta_da_data;?></strong></td>
  <td><strong><?=(int)$total_basic_salary_payable;?></strong></td>
  <td><strong><?=$total_spl_alw_data;?></strong></td>
  <td><strong><?=$total_ta_da;?></strong></td>
  <td><strong><?=$total_house_rent;?></strong></td>
  <td><strong><?=round($total_vehicle_allowance);?></strong></td>
  <td><strong><?=$total_food_allowance;?></strong></td>
  <td><strong><?=$total_mobile_allowance;?></strong></td>
  <td><strong><?=$total_benefits;?></strong></td>
  <td><strong><?=$total_other_benefits;?></strong></td>
  <td><strong><?=$total_income_tax;?></strong></td>
  <td><strong><?=$total_advance_install;?></strong></td>
  <td><strong><?=$total_cooperative_share;?></strong></td>
  <td><strong><?=$total_motorcycle_install;?></strong></td>
  <td><strong><?=$total_deduction;?></strong></td>
  <td><strong>
    <?=round($total_administrative_deduction);?>
  </strong></td>
  <td><?=$total_help_up_paid?></td>
  <td><strong><?=$total_cash_payment?></strong></td>
  <td><?=$total_bank_payment_dbbl?></td>
  <td><?=$total_bank_payment_ebl?></td>
  <td><?=$total_bank_payment_ncc?></td>
  <td><?=$total_bank_payment_ibbl?></td>
  <td><strong><?=$total_net_payable?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}
elseif($_POST['report']==7842)
{

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="29"><?=$str?></th></tr>

<tr>

<th rowspan="3">S/L</th>
<th rowspan="3">Department</th>
<th rowspan="3">Location</th>
<th rowspan="3">Nos</th>
<th colspan="3">Basic Information </th>
<th colspan="9"><div>Salary and Allowance (At Actual) Taka </div></th>
<th colspan="6"><div>Deduction</div></th>
<th colspan="5"><div>Payable Amount (Taka) </div></th>
<th><div>View Only </div></th>
<th rowspan="3">Remarks</th>
</tr>
<tr class="vertical-text">
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/salary.jpg" /></th>
  <th rowspan="2"><img src="images/special_allowance.JPG" /></th>
  <th rowspan="2"><img src="images/ta_da.JPG" /></th>
  <th rowspan="2"><img src="images/house_rent.JPG" /></th>
  <th rowspan="2"><img src="images/car.JPG" /></th>
  <th rowspan="2"><img src="images/food.JPG" /></th>
  <th rowspan="2"><img src="images/mobile.JPG" /></th>
  <th rowspan="2"><img src="images/arear.JPG" /></th>
  <th rowspan="2"><img src="images/other.JPG" /></th>
  <th rowspan="2"><img src="images/ait.JPG" /></th>
  <th rowspan="2"><img src="images/advance_salary.JPG" /></th>
  <th rowspan="2"><img src="images/co-op-fund.JPG" /></th>
  <th rowspan="2"><img src="images/bike.JPG" /></th>
  <th rowspan="2"><img src="images/excess_mobile.JPG" /></th>
  <th rowspan="2"><img src="images/administrative.JPG" /></th>
  <th rowspan="2">H-Up</th>
  <th rowspan="2"><img src="images/cash.JPG" /></th>
  <th colspan="2">BANK</th>
  <th rowspan="2"><img src="images/total_salary.JPG" /></th>
  <th rowspan="2"><img src="images/last_salary.JPG" /></th>
  </tr>
<tr class="vertical-text">
  <th>DBBL</th>
  <th>IBBL</th>
</tr>
</thead>
<tbody>

<?
$sqld = 'select t.pbi_department,t.pbi_job_location,
count(1) nos,
sum(s.basic_salary) actual_basic_salary,
sum(s.special_allowance) actual_special_allawance,
sum(t.basic_salary_payable) basic_salary_payable,
sum(t.special_allowance) special_allowance,
sum(t.ta_da_data) ta_da_data,
sum(t.ta_da) ta_da,
sum(t.house_rent) house_rent,
sum(t.vehicle_allowance) vehicle_allowance,
sum(t.food_allowance) food_allowance,
sum(t.mobile_allowance) mobile_allowance,
sum(t.benefits) benefits,
sum(t.other_benefits) other_benefits,
sum(t.income_tax) income_tax,
sum((t.advance_install+ t.other_install)) total_install,
sum(t.cooperative_share) cooperative_share,
sum(t.motorcycle_install) motorcycle_install,
sum(t.deduction) deduction,
sum(t.administrative_deduction) administrative_deduction,
sum(t.absent_deduction) absent_deduction,
 t.pbi_held_up held_up_status,s.cash_bank

from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and pbi_organization in (1,2,12) and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) )   group by t.pbi_job_location';
$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;

?>
<tr><td><?=++$s?></td>
  <td>Admin (Support Service Section)</td>
  <td><?=find_a_field('office_location','LOCATION_NAME','id="'.$data->pbi_job_location.'"')?></td>
  <td><?=(int)$data->nos?><? $total_nos = $total_nos + $data->nos;?></td>
<td><?=(int)$data->actual_basic_salary?><? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary;?></td>
  <td><?=(int)$data->actual_special_allawance?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?></td>
  <td><?=$data->ta_da_data?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?></td>
  <td><?=(int)$data->basic_salary_payable?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?></td>
  <td><?=(int)$data->special_allowance?><? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance;?></td>
  <td><?=$data->ta_da?><? $total_ta_da = $total_ta_da + $data->ta_da;?></td>
  <td><?=round($data->house_rent)?><? $total_house_rent = $total_house_rent + $data->house_rent;?></td>
  <td><?=$data->vehicle_allowance?><? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance;?></td>
  <td><?=$data->food_allowance?><? $total_food_allowance = $total_food_allowance + $data->food_allowance;?></td>
  <td><?=$data->mobile_allowance?><? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance;?></td>

  <td><?=$data->benefits?><? $total_benefits = $total_benefits + $data->benefits;?></td>
  <td><?=$data->other_benefits?><? $total_other_benefits = $total_other_benefits + $data->other_benefits;?></td>
  <td><?=$data->income_tax?><? $total_income_tax = $total_income_tax + $data->income_tax;?></td>
  <td><?=$data->total_install?><? $total_advance_install = $total_advance_install + $data->total_install;?></td>

  <td><?=$data->cooperative_share?><? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share;?></td>
  <td><?=$data->motorcycle_install?><? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install;?></td>
  <td><?=$data->deduction?><? $total_deduction = $total_deduction + $data->deduction;?></td>
  <td><?=number_format($data->administrative_deduction)?><? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction;?></td>

  <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) )  and t.pbi_job_location ="'.$data->pbi_job_location.'" and pbi_organization in (1,2,12) and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_help_up_paid = $total_help_up_paid + $help_up_paid;?></td>
  <td><? echo $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) )   and t.pbi_job_location ="'.$data->pbi_job_location.'"  and pbi_organization in (1,2,12) and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].''); $total_cash_payment = $total_cash_payment + $cash_paid; ?></td>

  <td><? echo $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID  and t.pbi_job_location ="'.$data->pbi_job_location.'" and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) )  and pbi_organization in (1,2,12) and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?></td>

  <td><? echo $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID  and t.pbi_job_location ="'.$data->pbi_job_location.'" and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) ) and pbi_organization in (1,2,12) and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?></td>

  <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID  and t.pbi_job_location ="'.$data->pbi_job_location.'" and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) )  and pbi_organization in (1,2,12) and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_net_payable = $total_net_payable + $net_payable;?></span></td>
  <td>&nbsp;</td>
  <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="3">&nbsp;</td>
  <td><strong><?=$total_nos?></strong></td>
  <td><strong><?=$total_actual_basic_salary;?></strong></td>
  <td><strong><?=$total_actual_special_allawance;?></strong></td>
  <td><strong><?=$total_ta_da_data;?></strong></td>
  <td><strong><?=(int)$total_basic_salary_payable;?></strong></td>
  <td><strong><?=$total_spl_alw_data;?></strong></td>
  <td><strong><?=$total_ta_da;?></strong></td>
  <td><strong><?=round($total_house_rent);?></strong></td>
  <td><strong><?=$total_vehicle_allowance;?></strong></td>
  <td><strong><?=$total_food_allowance;?></strong></td>
  <td><strong><?=$total_mobile_allowance;?></strong></td>
  <td><strong><?=$total_benefits;?></strong></td>
  <td><strong><?=$total_other_benefits;?></strong></td>
  <td><strong><?=$total_income_tax;?></strong></td>
  <td><strong><?=$total_advance_install;?></strong></td>
  <td><strong><?=$total_cooperative_share;?></strong></td>
  <td><strong><?=$total_motorcycle_install;?></strong></td>
  <td><strong><?=$total_deduction;?></strong></td>
  <td><strong><?=$total_administrative_deduction;?></strong></td>
  <td><?=$total_help_up_paid?></td>
  <td><strong><?=$total_cash_payment?></strong></td>
  <td><?=$total_bank_payment_dbbl?></td>
  <td><?=$total_bank_payment_ibbl?></td>
  <td><strong><?=$total_net_payable?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br />
<?
}


elseif($_POST['report']==79){ // salary payslip view

if($_POST['branch']!='') $con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

echo $sql22="SELECT a.*,b.*
FROM personnel_basic_info a, salary_attendence b
WHERE a.PBI_ID = b.PBI_ID
AND b.pbi_held_up = 0
and b.mon='".$mon."' and b.year='".$year."' ".$con."
order by b.total_salary desc";

$res = db_query($sql22);
	$ig=-1; while($data=mysqli_fetch_object($res)){
?>
<div <? if(($ig%4)==0&&($ig>2)) echo 'style="position:relative;display:block; width:100%; float: none; page-break-after:always; page-break-inside:avoid"'; ?>>
<? $ig++;?>
<table  width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th width="5%">&nbsp;</th>
        <th width="30%">Employee Information</th>
        <th width="20%">Attendence Info</th>
        <th width="20%">Payable Salary</th>
        <th width="25%">Signature</th>
      </tr>
    </thead>
    <tbody>
      <tr style="height:130px;">
        <td rowspan="2" align="center">&nbsp;</td>
        <td rowspan="2" align="center">ID: <strong><?=$data->PBI_ID?></strong><br />
          Name: <strong><?=$data->PBI_NAME ?></strong><br />
          Designation: <strong><?=$data->DESG_SHORT_NAME?></strong><br />
          Department: <strong><?=$data->DEPT_DESC?></strong></td>
        <td rowspan="2" align="right">
		<?php if($data->pre>0){?>
		Present Days:<strong><?=$data->pre?></strong><br />
		   <?php }?>


		   <?php if($data->od>0){?>
          Off Days:<strong><?=$data->od?></strong><br />
			 <?php }?>

			 <?php if($data->hd>0){?>
          Holy Days:<strong><?=$data->hd?></strong><br />
			 <?php }?>

		  <?php if($data->lv>0){?>
          Leave Days:<strong><?=$data->lv?></strong><br />
			 <?php }?>

		 <?php if($data->lt>0){?>
          Late Days:<strong><?=$data->lt?></strong><br />
			 <?php }?>

		<?php if($data->ab>0){?>
          Absent Days:<strong><?=$data->ab?></strong><br />
			 <?php }?>
		<?php if($data->td>0){?>
          Total Days:<strong><?=$data->td?></strong><br />
			<?php }?>

			<?php if($data->pay>0){?>
          Payable Days:<strong><?=$data->pay?></strong>
		  <?php }?>		  </td>
        <td align="center" style="text-align:right">
		<?php if($data->total_salary>0){?>
		Gross:<strong><?=number_format($data->total_salary,2)?></strong><br />
		  <?php }?>

		  <?php if($data->total_benefits>0){?>
          Total Benf:<strong><?=number_format($data->total_benefits,2)?></strong><br />
			 <?php }?>

			<?php if($data->total_deduction>0){?>
          Total Ded:<strong><?=number_format($data->total_deduction,2)?></strong><br />
		    <?php }?>
			<?php if($data->bank_paid>0){?>
          Total Bank Payment:<strong><?=number_format($data->bank_paid,2)?></strong><br />
		    <?php }?>


		  </td>
        <td rowspan="2" align="center" style="text-align:center">...........................<br />
          (<strong><?=$data->PBI_NAME ?></strong>)</td>
      </tr>

      <tr>
        <?php if($data->DEPT_DESC=='Sales Marketing'){?>
        <?php }?>
        <td align="center" style="text-align:right">Cash Payment:<strong><?=number_format($data->cash_paid,2); $n_p_total+=$data->total_payable;?></strong></td>
      </tr>
      <br /><br />
	  <? } ?>
  </table>
</div>
<br /><br /><br /><br />

<? }





elseif($_POST['report']==7712){ // salary payslip view


if($_POST['PBI_ORG']!='')
	$company_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

	if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";


    $sql22="SELECT a.*,s.*
FROM personnel_basic_info a, salary_attendence s
WHERE a.PBI_ID = s.PBI_ID

and s.mon='".$mon."' and s.year='".$year."' ".$company_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON."
order by s.EMP_CODE ";




$res = db_query($sql22);
	$ig=-1; while($data=mysqli_fetch_object($res)){


	$dateString = ''.$year.'-'.$mon.'-01';

     $jv_date = date("Y-m-t", strtotime($dateString));


?>
<div <? if(($ig%3)==0&&($ig>2)) echo 'style="position:relative;display:block; width:100%; float: none; page-break-after:always; page-break-inside:avoid"'; ?>>

<? $ig++;?>
<table  width="100%" cellspacing="0" cellpadding="2" border="0" style="font-size:14px;">
    <thead>

      <tr>
        <th colspan="6"><div align="center">পে-স্লিপ, <?php echo date('F',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?>'<?php echo date('Y',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?></div></th>
        </tr>
      <tr>
        <th>ইউনিটঃ </th>
        <th><?=$group=find_a_field('user_group','name_bangla','id='.$data->PBI_ORG)?></th>
        <th>বিভাগঃ </th>
        <th><?=$department=find_a_field('department','DEPT_NAME_BANGLA','DEPT_ID='.$data->PBI_DEPARTMENT)?></th>
        <th>প্রভিডেন্ড ফান্ড নিজ জমাঃ</th>
        <th><?
		$pf_self_in=find_a_field('salary_pl_journal','sum(amt_in)','tr_from in ("SELF PF","SELF PF OPENING") and  jv_date<="'.$jv_date.'"  and PBI_ID='.$data->PBI_ID);
		$pf_self_out=find_a_field('salary_pl_journal','sum(amt_out)','tr_from in ("SELF PF RETURN") and  jv_date<="'.$jv_date.'"  and PBI_ID='.$data->PBI_ID);

		echo number_format($pf_self = ($pf_self_in - $pf_self_out),2);

		?></th>
      </tr>
      <tr>
        <th>নামঃ</th>
        <th><?=$data->PBI_NAME_BANGLA?></th>
        <th>আইডি নং</th>
        <th><?=$data->PBI_CODE?></th>
        <th>প্রভিডেন্ড ফান্ড অফিস জমাঃ</th>
        <th>

		<?
		$pf_company_in=find_a_field('salary_pl_journal','sum(amt_in)','tr_from in ("EMPLOYER PF","EMPLOYER PF OPENING") and  jv_date<="'.$jv_date.'"  and PBI_ID='.$data->PBI_ID);
		$pf_company_out=find_a_field('salary_pl_journal','sum(amt_out)','tr_from in ("EMPLOYER PF RETURN") and  jv_date<="'.$jv_date.'"  and PBI_ID='.$data->PBI_ID);

		echo number_format($pf_company = ($pf_company_in - $pf_company_out),2);

		?></th>
      </tr>
      <tr>
        <th>উপস্থিতিঃ </th>
        <th><?= $tot_day = ($data->pay+$data->potd)?></th>
        <th>বেতনঃ</th>
        <th><?=number_format($data->gross_salary,2);?></th>
        <th>প্রভিডেন্ড ফান্ড মোট জমাঃ</th>
        <th><?=number_format($total_pf=$pf_self+$pf_company,2);?></th>
      </tr>
      <tr>
        <th width="12%">যোগদানের তাঃ </th>
        <th width="18%"><?php echo date('d-m-Y',strtotime($data->PBI_DOJ));?></th>
        <th width="9%">&nbsp;</th>
        <th>&nbsp;</th>
        <th>অগ্রীম বাকীঃ</th>
        <th>
		<? $advance_in=find_a_field('salary_advance_journal','sum(amt_in)',' jv_date<="'.$jv_date.'" and  PBI_ID='.$data->PBI_ID);?>
		<? $advance_out=find_a_field('salary_advance_journal','sum(amt_out)',' jv_date<="'.$jv_date.'" and PBI_ID='.$data->PBI_ID);?>

		<?=number_format($advance_closing=$advance_in-$advance_out,2);?></th>
      </tr>
      <tr style=" font-size:14px; font-weight:700;" >
        <th colspan="3"><div align="center">উপার্জন</div></th>
        <th width="14%"><div align="center">টাকা</div></th>
        <th width="34%"><div align="center">কর্তন</div></th>
        <th width="13%"><div align="center">টাকা</div></th>
      </tr>
    </thead>
    <tbody>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">মুল বেতন</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->basic_salary,2)?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left">প্রভিডেন্ড ফান্ড কর্তন</div></td>
        <td align="center" style="text-align:right"><div align="center">
          <?=number_format($data->pf,2);?>
        </div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">বাসা ভাড়া</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->house_rent,2);?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left">অগ্রীম কর্তন</div></td>
        <td align="center" style="text-align:right"><div align="center">
          <?=number_format($data->advance_install,2);?>
        </div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">চিকিৎসা ভাতা</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->medical_allowance,2);?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left">অনুপস্থিতি কর্তন</div></td>
        <td align="center" style="text-align:right"><div align="center">
          <?=number_format($data->absent_deduction,2)?>
        </div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">যাতায়াত</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->conveyance_allowance,2)?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left">মেছ বিল ও ডরমেটরী <? if($data->mess_dormitory>0) {?> <strong>[সঃ <?=$data->morning_meal ?>, দুঃ <?=$data->lunch_meal ?>, রাঃ <?=$data->dinner_meal ?>, সাহরীঃ <?=$data->sehri_meal ?>] </strong><? }?></div></td>
        <td align="center" style="text-align:right"><div align="center">
          <?=number_format($data->mess_dormitory,2)?>
        </div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">উপস্থিত ভাতা</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->attendance_bonus,2)?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left">অন্যান্য কর্তন</div></td>
        <td align="center" style="text-align:right"><div align="center">
          <?=number_format($data->deduction,2)?>
        </div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">উৎপাদন বোনাস</div></td>
        <td align="center"><div align="center"></div></td>
        <td align="center" style="text-align:right"><div align="left">আংশিক বেতন এডজাস্টমেন্ট</div></td>
        <td align="center" style="text-align:right"><div align="center"> <?=number_format($data->partial_salary_adjustment,2)?></div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">অতিরিক্ত কাজের মজুরী</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->over_time_amount,2)?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left">স্ট্যাম্প চার্জ</div></td>
        <td align="center" style="text-align:right"><div align="center"><?=number_format($data->stamp_charge,2)?></div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">উৎসব বোনাস</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->festival_bonus,2)?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left"></div></td>
        <td align="center" style="text-align:right"><div align="center"></div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">অন্যান্য উপার্জন</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->benefits,2)?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left"></div></td>
        <td align="center" style="text-align:right"><div align="center"></div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left"><strong>মোট উপার্জনঃ</strong></div></td>
        <td align="center"><div align="center">
          <span class="style15">
          <?=number_format($data->total_salary+$data->total_benefits,2)?>
          </span>        </div></td>
        <td align="center" style="text-align:right"><div align="left"><strong>মোট কর্তনঃ</strong></div></td>
        <td align="center" style="text-align:right"><div align="center"><strong>
          <?=number_format($data->total_deduction+$data->pf,2)?>
        </strong></div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left"></div></td>
        <td align="center"><div align="center"></div></td>
        <td align="center" style="text-align:right"><div align="right"><strong>নীট বেতনঃ</strong></div></td>
        <td align="center" style="text-align:right"><div align="center">
          <span class="style16">
          <?=number_format($data->total_payable,2);?>
          </span>        </div></td>
      </tr>
      <br /> <br />
	  <? } ?>
  </table>
</div>
<br /><br /><br />

<? }









elseif($_POST['report']==771211){ // salary payslip view



 if($_POST['PBI_ORG']!='')
	$group_con.=' and s.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	if($_POST['JOB_LOCATION']!='')
	$JOB_LOCATION_CON.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';

if($_POST['mess_bill_type']!='')
	$mess_bill_con.=' and a.mess_bill_type = "'.$_POST['mess_bill_type'].'"';

if($_POST['define_shift']!='')
	$shift_con.=' and a.define_shift = "'.$_POST['define_shift'].'"';

if($_POST['department']!='')
	$department_con.=' and s.PBI_DEPARTMENT = "'.$_POST['department'].'"';

if($_POST['designation']!='')
	$designation_con.=' and s.PBI_DESIGNATION = "'.$_POST['designation'].'"';

if($_POST['payroll_type']!='')
	$payroll_type_con.=' and a.payroll_type = "'.$_POST['payroll_type'].'"';

if($_POST['PBI_RESIDENT']!='')
	$resident_con.=' and a.PBI_RESIDENT = "'.$_POST['PBI_RESIDENT'].'"';

if($_POST['salary_shift']!='')
	$salary_shift_con.=' and a.salary_shift = "'.$_POST['salary_shift'].'"';

	if($_POST['pbi_id_in']!='')
	$pbi_id_in_con .= " and s.EMP_CODE in (".$_POST['pbi_id_in'].")";


   $sql22="SELECT a.*,s.*
FROM personnel_basic_info a, salary_attendence_partial s
WHERE a.PBI_ID = s.PBI_ID

and s.mon='".$mon."' and s.year='".$year."' ".$group_con.$mess_bill_con.$shift_con.$department_con.$designation_con.$payroll_type_con.$resident_con.$salary_shift_con.$pbi_id_in_con.$JOB_LOCATION_CON."
order by s.EMP_CODE ";

$res = db_query($sql22);
	$ig=-1; while($data=mysqli_fetch_object($res)){


	$dateString = ''.$year.'-'.$mon.'-01';

    $jv_date = date("Y-m-t", strtotime($dateString));


?>
<div <? if(($ig%3)==0&&($ig>2)) echo 'style="position:relative;display:block; width:100%; float: none; page-break-after:always; page-break-inside:avoid"'; ?>>

<? $ig++;?>
<table  width="100%" cellspacing="0" cellpadding="2" border="0" style="font-size:14px;">
    <thead>

      <tr>
        <th colspan="6"><div align="center">আংশিক পে-স্লিপ, <?php echo date('F',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?>'<?php echo date('Y',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))?></div></th>
        </tr>
      <tr>
        <th>ইউনিটঃ </th>
        <th><?=$group=find_a_field('user_group','name_bangla','id='.$data->PBI_ORG)?></th>
        <th>বিভাগঃ </th>
        <th><?=$department=find_a_field('department','DEPT_NAME_BANGLA','DEPT_ID='.$data->PBI_DEPARTMENT)?></th>
        <th>প্রভিডেন্ড ফান্ড নিজ জমাঃ</th>
        <th><?=number_format($pf=find_a_field('salary_pl_journal','sum(amt_in)','tr_from in ("SELF PF","SELF PF OPENING") and  jv_date<="'.$jv_date.'"  and PBI_ID='.$data->PBI_ID),2);?></th>
      </tr>
      <tr>
        <th>নামঃ</th>
        <th><?=$data->PBI_NAME_BANGLA?></th>
        <th>আইডি নং</th>
        <th><?=$data->PBI_CODE?></th>
        <th>প্রভিডেন্ড ফান্ড অফিস জমাঃ</th>
        <th><?=number_format($pf_company=find_a_field('salary_pl_journal','sum(amt_in)','tr_from in ("EMPLOYER PF","EMPLOYER PF OPENING") and  jv_date<="'.$jv_date.'" and  PBI_ID='.$data->PBI_ID),2);?></th>
      </tr>
      <tr>
        <th>উপস্থিতিঃ </th>
        <th><?= $tot_day = ($data->pay_day)?></th>
        <th>বেতনঃ</th>
        <th><?=number_format($data->gross_salary,2);?></th>
        <th>প্রভিডেন্ড ফান্ড মোট জমাঃ</th>
        <th><?=number_format($total_pf=$pf+$pf_company,2);?></th>
      </tr>
      <tr>
        <th width="6%">&nbsp;</th>
        <th width="20%">&nbsp;</th>
        <th width="9%">&nbsp;</th>
        <th>&nbsp;</th>
        <th>অগ্রীম বাকীঃ</th>
        <th>
		<? $advance_in=find_a_field('salary_advance_journal','sum(amt_in)',' jv_date<="'.$jv_date.'" and  PBI_ID='.$data->PBI_ID);?>
		<? $advance_out=find_a_field('salary_advance_journal','sum(amt_out)',' jv_date<="'.$jv_date.'" and PBI_ID='.$data->PBI_ID);?>

		<?=number_format($advance_closing=$advance_in-$advance_out,2);?></th>
      </tr>
      <tr style=" font-size:14px; font-weight:700;" >
        <th colspan="3"><div align="center">উপার্জন</div></th>
        <th width="15%"><div align="center">টাকা</div></th>
        <th width="35%"><div align="center">কর্তন</div></th>
        <th width="15%"><div align="center">টাকা</div></th>
      </tr>
    </thead>
    <tbody>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">আংশিক বেতন</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->partial_salary,2)?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left">প্রভিডেন্ড ফান্ড কর্তন</div></td>
        <td align="center" style="text-align:right"><div align="center">
          <?=number_format($data->pf,2);?>
        </div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">অতিরিক্ত কাজের মজুরী</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->over_time_amount,2)?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left">অগ্রীম কর্তন</div></td>
        <td align="center" style="text-align:right"><div align="center">
          <?=number_format($data->advance_install,2);?>
        </div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">উৎসব বোনাস</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->festival_bonus,2)?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left">অনুপস্থিতি কর্তন</div></td>
        <td align="center" style="text-align:right"><div align="center">
          <?=number_format($data->absent_deduction,2)?>
        </div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left">অন্যান্য উপার্জন</div></td>
        <td align="center"><div align="center">
          <?=number_format($data->benefits,2)?>
        </div></td>
        <td align="center" style="text-align:right"><div align="left">মেছ বিল ও ডরমেটরী</div></td>
        <td align="center" style="text-align:right"><div align="center">
          <?=number_format($data->mess_dormitory,2)?>
        </div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left"></div></td>
        <td align="center"><div align="center"></div></td>
        <td align="center" style="text-align:right"><div align="left">অন্যান্য কর্তন</div></td>
        <td align="center" style="text-align:right"><div align="center">
          <?=number_format($data->deduction,2)?>
        </div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left"></div></td>
        <td align="center"><div align="center"></div></td>
        <td align="center" style="text-align:right"><div align="left"></div></td>
        <td align="center" style="text-align:right"><div align="center"></div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left"></div></td>
        <td align="center"><div align="center"></div></td>
        <td align="center" style="text-align:right"><div align="left"></div></td>
        <td align="center" style="text-align:right"><div align="center"></div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left"></div></td>
        <td align="center"><div align="center"></div></td>
        <td align="center" style="text-align:right"><div align="left"></div></td>
        <td align="center" style="text-align:right"><div align="center"></div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left"></div></td>
        <td align="center"><div align="center"></div></td>
        <td align="center" style="text-align:right"><div align="left"></div></td>
        <td align="center" style="text-align:right"><div align="center"></div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left"><strong>মোট উপার্জনঃ</strong></div></td>
        <td align="center"><div align="center">
          <span class="style15">
          <?=number_format($data->partial_salary+$data->total_benefits,2)?>
          </span>        </div></td>
        <td align="center" style="text-align:right"><div align="left"><strong>মোট কর্তনঃ</strong></div></td>
        <td align="center" style="text-align:right"><div align="center"><strong>
          <?=number_format($data->total_deduction+$data->pf,2)?>
        </strong></div></td>
      </tr>
      <tr style="height:20px;">
        <td colspan="3" align="center"><div align="left"></div></td>
        <td align="center"><div align="center"></div></td>
        <td align="center" style="text-align:right"><div align="right"><strong>নীট বেতনঃ</strong></div></td>
        <td align="center" style="text-align:right"><div align="center">
          <span class="style16">
          <?=number_format($data->total_payable,2);?>
          </span>        </div></td>
      </tr>
      <br /> <br />
	  <? } ?>
  </table>
</div>
<br /><br /><br />

<? }










elseif($_POST['report']==9999999)

{

?>

<div class="header"><h1><?=$_SESSION['company_name']?></h1>

  <h2 style="margin:0; padding:0; font-weight:700;">Salary Pay Slip :

    <?=date('F', mktime(0,0,0,$mon,15,2000))?>, <?=$year?></h2></div>





	<h3 style="margin:0; padding:0; font-weight:400;">



	<?php if($_POST['department']!=''){?>Department: <?=find_a_field('department','DEPT_DESC','DEPT_ID='.$_POST['department']); }?>



	<?php if($_POST['PBI_GARDEN']!='' && $_POST['department']!=''){?> , Garden: <?=find_a_field('tea_estate','ESTATE_NAME','ESTATE_ID='.$_POST['PBI_GARDEN']); }elseif($_POST['PBI_GARDEN']!=''){

	 ?>Garden: <?=find_a_field('tea_estate','ESTATE_NAME','ESTATE_ID='.$_POST['PBI_GARDEN']); }?>



	<?php if($_POST['JOB_LOCATION']!='' && ($_POST['PBI_GARDEN']!='' || $_POST['department']!='')){?> , Job Location: <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['JOB_LOCATION']); }elseif($_POST['JOB_LOCATION']!=''){?>Job Location: <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['JOB_LOCATION']); }?>



	</h3>





	<?



	$sql="SELECT a.*,b.*, d.DESG_SHORT_NAME, p.DEPT_DESC FROM personnel_basic_info a,salary_attendence b, designation d, department p where	a.PBI_ID=b.PBI_ID and a.PBI_DESIGNATION=d.DESG_ID and a.PBI_DEPARTMENT=p.DEPT_ID  and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_ID asc";

$res = db_query($sql);

	$ig=-1; while($data=mysqli_fetch_object($res)){

?>

<div <? if(($ig%3)==0&&($ig>2)) echo 'style="position:relative;display:block; width:100%; float: none; page-break-after:always; page-break-inside:avoid"'; ?>>

<? $ig++;?>

<table  width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;" colspan="12"></td>

      </tr>

      <tr>

        <th width="8%">Staff Picture</th>

        <th width="13%">Employee Information</th>

        <th width="8%">Attendence Info</th>

        <th width="15%">Salary Information</th>



        <th width="4%">Ta Da </th>

        <th width="4%">Commi</th>

        <th width="4%">Mob All </th>

        <th width="4%">Other</th>



        <th width="11%">Advance if Any </th>

        <th width="10%">Deduction if Any </th>

        <th width="9%">Payable Salary</th>

        <th width="10%">Signature</th>

      </tr>

    </thead>

    <tbody>

      <tr>

        <td rowspan="2" align="center" style="text-align:center"><p><img src="../../pic/staff/<?=$data->PBI_ID?>.jpg" alt="" width="78" height="89" border="1" /></p></td>

        <td rowspan="2" align="center">



		<?php if($data->PBI_DOJ>0){?>



		  Joining Date:<strong> <?=date("jS F, Y",strtotime($data->PBI_DOJ))?>



          </strong><br />



		  <?php }?>



		  ID: <strong>

          <?=$data->PBI_ID?>

          </strong><br />

          Name: <strong>

            <?=$data->PBI_NAME ?>

            </strong><br />

          Designation: <strong>

            <?=$data->DESG_SHORT_NAME?>

            </strong><br />

          Department: <strong>

            <?=$data->DEPT_DESC?>

          </strong></td>

        <td rowspan="2" align="right">

		<?php if($data->pre>0){?>

		Present Days:<strong>

          <?=$data->pre?>

          </strong><br />

		   <?php }?>





		   <?php if($data->od>0){?>

          Off Days:<strong>

            <?=$data->od?>

            </strong><br />

			 <?php }?>



			 <?php if($data->hd>0){?>

          Holy Days:<strong>

            <?=$data->hd?>

            </strong><br />

			 <?php }?>



		  <?php if($data->lv>0){?>

          Leave Days:<strong>

            <?=$data->lv?>

            </strong><br />

			 <?php }?>



		 <?php if($data->lt>0){?>

          Late Days:<strong>

            <?=$data->lt?>

            </strong><br />

			 <?php }?>



		<?php if($data->ab>0){?>

          Absent Days:<strong>

            <?=$data->ab?>

            </strong><br />

			 <?php }?>

		<?php if($data->td>0){?>

          Total Days:<strong>

            <?=$data->td?>

            </strong><br />

			<?php }?>



			<?php if($data->pay>0){?>

          Payable Days:<strong>

            <?=$data->pay?>

          </strong>

		  <?php }?>		  </td>

        <td align="center" style="text-align:right">

		<?php if($data->consolidated_salary>0){?>

          Consolidated Salary:<strong>

            <?=$data->consolidated_salary?>

            </strong><br />

          <?php }?>

          <?php if($data->basic_salary>0){?>

          Basic Salary:<strong>

            <?=$data->basic_salary?>

            </strong><br />

          <?php }?>



		  <?php if($data->dearness_allowance>0){?>

          Dearness All:<strong>

            <?=$data->dearness_allowance?>

            </strong><br />

          <?php }?>



		  <?php  if($data->house_rent>0){?>

          House Rent:<strong>

            <?=$data->house_rent?>

            </strong><br />

          <?php }?>







          <?php if($data->entertainment>0){?>

          Ent. All:<strong>

            <?=$data->entertainment?>

            </strong><br />

          <?php }?>



          <?php if($data->medical_allowance>0){?>

          Medical All:<strong>

            <?=$data->medical_allowance?>

            </strong><br />

          <?php }?>



          <?php if($data->convenience>0){?>

          Convenience :<strong>

            <?=$data->convenience?>

            </strong><br />

          <?php }?>









		  <?php if($data->utility_allowance>0){?>

          Utility All :<strong>

            <?=$data->utility_allowance?>

          </strong><br />

		  <?php }?>



		   <?php if($data->children_edu_allowance>0){?>

          CEA All :<strong>

            <?=$data->children_edu_allowance?>

          </strong><br />

		  <?php }?>



		  <?php if($data->responsibility_allowance>0){?>

          Respty. All :<strong>

            <?=$data->responsibility_allowance?>

          </strong><br />

		  <?php }?>





		    <?php if($data->transport_allowance>0){?>

          Trans. All :<strong>

            <?=$data->transport_allowance?>

          </strong><br />

		  <?php }?>



			<?php if($data->fuel_allowance>0){?>

          Fuel All :<strong>

            <?=$data->fuel_allowance?>

          </strong><br />

		  <?php }?>



		  <?php if($data->superintendent_allowance>0){?>

          Supdt. All :<strong>

            <?=$data->superintendent_allowance?>

          </strong><br />

		  <?php }?>



		   <?php if($data->servant_allowance>0){?>

          Servent All :<strong>

            <?=$data->servant_allowance?>

          </strong><br />

		  <?php }?>



		   <?php if($data->special_allowance>0){?>

          Special All :<strong>

            <?=$data->special_allowance?>

          </strong><br />

		  <?php }?>



		  <?php if($data->comstry_allowance>0){?>

          Comstry. All :<strong>

            <?=$data->comstry_allowance?>

          </strong><br />

		  <?php }?>



		   <?php if($data->marketing_allowance>0){?>

          Marketing All :<strong>

            <?=$data->marketing_allowance?>

          </strong><br />

		  <?php }?>



		   <?php if($data->realestate_allowance>0){?>

          Real Estate :<strong>

            <?=$data->realestate_allowance?>

          </strong><br />

		  <?php }?>



		   <?php if($data->car_driver_allowance>0){?>

          Car &amp; Driver :<strong>

            <?=$data->car_driver_allowance?>

          </strong><br />

		  <?php }?>



		   <?php if($data->other_allowance>0){?>

          Other All :<strong>

            <?=$data->other_allowance?>

          </strong><br />

		  <?php }?>





		  <?php if($data->pf>0){?>

          PF :<strong>

            <?=$data->pf?>

          </strong><br />

		  <?php }?>		 </td>



        <td align="center" style="text-align:right"><strong>

		<?php if($data->ta_da>0){?>

          <?=$data->ta_da; $tada_total+=$data->ta_da;?>

		 <?php }?>



		 <?php if($data->fixed_tada>0){?>

		  <?=$data->fixed_tada; $fixed_tada_total+=$data->fixed_tada;?>

		  <?php }?>

        </strong> <br /><br /> <br /><br /></td>

        <td align="center" style="text-align:right"><strong>

          <?=$data->commission; $comm_total+=$data->commission;?>

        </strong> <br /><br /> <br /><br /></td>

        <td align="center" style="text-align:right"><strong>

          <?=$data->mobile_allowance; $mob_total+=$data->mobile_allowance;?>

        </strong> <br /><br /> <br /><br /></td>

        <td align="center" style="text-align:right"><strong>

          <?=$data->benefits; $benefits_total+=$data->benefits;?>

        </strong><br /><br /> <br /><br /></td>

        <td rowspan="2" align="center" style="text-align:right">



		<?php

		$z=0; $ad_sql='SELECT advance_amt, sum(payable_amt) as total_pay, payable_amt  FROM salary_advance WHERE PBI_ID='.$data->PBI_ID.' and (( current_mon>='.$mon.' and current_year>='.$year.' ) or current_year>'.$year.') and (( start_mon<='.$mon.' and start_year<='.$year.' ) or start_year<'.$year.')  group By start_year,start_mon,advance_amt';



		$ad_query=db_query($ad_sql);

		while($ad_data=mysqli_fetch_object($ad_query)){

		?>



		  Loan <?php echo ++$z?>: <strong><?php echo $ad_data->total_pay?></strong> <br/>

          Install: <strong><?php echo $ad_data->payable_amt?> </strong><br />

		   Bala:<strong> <?php echo number_format(($ad_data->total_pay-$ad_data->payable_amt),2)?></strong> <br />

		   <br />





		   <?php }?>	   	    </td>

        <td align="center" style="text-align:right">

		<?php if($data->deduction>0){?>

		Other Ded:<strong>

          <?=number_format($data->deduction,2)?>

          </strong><br />

		  <?php }?>



		  <?php if($data->advance_install>0){?>

          Adv Install:<strong>

            <?=number_format($data->advance_install,2)?>

            </strong><br />

			 <?php }?>



		 <?php if($data->pf>0){?>

          PF :<strong>

            <?=number_format(($data->pf+$data->pf),2)?>

            </strong><br />

			<?php }?>

			<?php if($data->sm_money>0){?>

          SM Money :<strong>

            <?=number_format(($data->sm_money),2)?>

            </strong><br />

			<?php }?>



		<?php if($data->income_tax>0){?>

          Income Tax :<strong>

            <?=number_format($data->income_tax,2)?>

            </strong><br />

			<?php }?>          </td>

        <td align="center" style="text-align:right">

		<?php if($data->total_salary>0){?>

		Gross:<strong> <?=number_format($data->total_salary,2)?></strong><br />

		  <?php }?>



		  <?php if($data->total_benefits>0){?>

          Totl Benf:<strong>

            <?=number_format($data->total_benefits,2)?>

            </strong><br />

			 <?php }?>



			<?php if($data->total_deduction>0){?>

          Totl Ded:<strong>

            <?=number_format($data->total_deduction,2)?>

            </strong><br />

		    <?php }?>			</td>

        <td rowspan="2" align="center" style="text-align:center">...........................<br />

          (<strong>

            <?=$data->PBI_NAME ?>



          </strong>) <br />

		 </td>

      </tr>



      <tr>

        <td align="center" style="text-align:right"> Gross Salary:<strong>

          <?=number_format($data->total_salary,2); $g_total+=$data->total_salary;?>

        </strong></td>



        <td colspan="4" align="center" style="text-align:right">Total Bene: <strong>

        <?=number_format($data->total_benefits,2); $b_gtotal+=$data->total_benefits;?>

        </strong></td>

        <td align="center" style="text-align:right">Total Ded:<strong>

        <?=number_format($data->total_deduction,2); $d_gtotal+=$data->total_deduction;?>

        </strong></td>

        <td align="center" style="text-align:right">Net  Pay:<strong>

        <?=number_format($data->total_payable,2); $n_p_total+=$data->total_payable;?>

        </strong></td>

      </tr>

      <br />

	  <? } ?>

      <tr>

        <td align="center" style="text-align:center">&nbsp;</td>

        <td align="center">&nbsp;</td>

        <td align="right">&nbsp;</td>

        <td align="center" style="text-align:right">&nbsp;</td>



        <td colspan="4" align="center" style="text-align:right">&nbsp;</td>

        <td align="center" style="text-align:right">&nbsp;</td>

        <td align="center" style="text-align:right">&nbsp;</td>

        <td align="center" style="text-align:right">&nbsp;</td>

        <td align="center" style="text-align:center">&nbsp;</td>

      </tr>







      <tr>

        <td align="center" style="text-align:center">&nbsp;</td>

        <td align="center">&nbsp;</td>

        <td align="right"><strong>Grand Total:</strong></td>

        <td align="center" style="text-align:right"> <strong><?= number_format($g_total,2);?></strong></td>



        <td align="center" style="text-align:right"><strong><?= number_format( $tada_total+$fixed_tada_total,2);?></strong></td>

        <td align="center" style="text-align:right"><strong>

          <?= number_format( $comm_total,2);?>

        </strong></td>

        <td align="center" style="text-align:right"><strong>

          <?= number_format( $mob_total,2);?>

        </strong></td>

        <td align="center" style="text-align:right"><strong>

          <?= number_format( $benefits_total,2);?>

        </strong></td>

        <td align="center" style="text-align:right">&nbsp;</td>

        <td align="center" style="text-align:right"><strong><?= number_format( $d_gtotal,2);?></strong></td>

        <td align="center" style="text-align:right"><strong><?= number_format( $n_p_total,2);?></strong></td>

        <td align="center" style="text-align:center">&nbsp;</td>

      </tr>

    </tbody>

  </table>

</div>

<br />



<? }











elseif($_POST['report']==201){ // Leave Encashment Report

$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);
?>
<center>
  <h1><?=$company?></h1>
  <strong>Leave Encashment Report Final-2017</strong><br>
  Department: <?=$_POST['department'] ?><br>

</center>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr><th style="border:0px;" colspan="7"></th></tr>

<tr>
  <th>S/L</th>
  <th>CODE</th>
  <th>Full Name</th>
  <th>Designation</th>
  <th>Department</th>
  <th>Joining Date</th>
  <th>Due Conf Date</th>
  <th>Conf Date</th>
  <th>Bank Acc </th>
  <th>Salary</th>
  <th>Sp</th>
  <th>TA/DA</th>
  <th>Leave Quota</th>
  <th>Leave Consume</th>
  <th>Balance</th>
  <th>Cash</th>
  <th>Bank</th>
  <th>Payable</th>
  </tr>
</thead>
<tbody>
<?


$sqld="select
a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,a.PBI_GROUP as `Group`,
(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,
(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,
(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,
(select cash from salary_info where PBI_ID=a.PBI_ID) as bank,
(select basic_salary from salary_info where PBI_ID=a.PBI_ID) as bsalary,
(select sum(special_allowance+incentive_allowance) from salary_info where PBI_ID=a.PBI_ID) as ssalary,
(select ta from salary_info where PBI_ID=a.PBI_ID) as ta,


DATE_FORMAT(a.PBI_DOJ,'%d-%m-%Y') as joining_date,
DATE_FORMAT(a.PBI_DOC,'%d-%m-%Y') as due_confirmation_date,
DATE_FORMAT(a.PBI_DOC2,'%d-%m-%Y') as confirmation_date,
a.PBI_DOJ joining_date1,
a.PBI_DOC due_confirmation_date1,
a.PBI_DOC2 confirmation_date1,

sum(t.lv)as leave_consumed

FROM personnel_basic_info a, salary_attendence t
WHERE
a.PBI_ID=t.PBI_ID
and t.year='2017'
AND a.PBI_JOB_STATUS != 'Not In Service'
".$con."group by a.PBI_ID";


$d22=date("2017-12-31");
//$d1 = new DateTime('2017-03-20');
$d2 = new DateTime($d22);
//$interval = date_diff($d1, $d2);
//echo $interval->format('%m months');

$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
?>
<tr>
  <td><?=++$s?></td>
  <td><?=$data->CODE?></td>
  <td><?=$data->Name?></td>
  <td><?=$data->designation?></td>
  <td><?=$data->department?></td>
  <td><?=$data->joining_date?></td>
  <td><?=$data->due_confirmation_date?></td>
  <td><?=$data->confirmation_date?></td>
  <td><?=$data->bank?></td>
  <td><?=$data->bsalary?></td>
  <td><?=$data->ssalary?></td>
  <td><?=$data->ta?></td>
  <td><?php
if($data->confirmation_date1 > date("2017-01-14") &&  $data->confirmation_date1 !='0000-00-00'){
$string = $data->confirmation_date1;
$timestamp = strtotime($string);
$tdate = date("d", $timestamp);
$cd =new DateTime($data->confirmation_date1);
$interval = date_diff($cd, $d2);

if($tdate<16){
$total_leave=$interval->format('%m')*2.5+2.5;
echo $total_leave;
}else{
$total_leave=$interval->format('%m')*2.5;
echo $total_leave;
}

}elseif($data->confirmation_date1 < date("2017-01-16") &&  $data->confirmation_date1 !='0000-00-00'){
$total_leave = 30; echo $total_leave;
}elseif($data->confirmation_date1 ='0000-00-00'){$total_leave=0; echo $total_leave;
}
?></td>
  <td><?=$data->leave_consumed?></td>
  <td><?php $lc=($total_leave - ($data->leave_consumed)); echo $lc;?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><?php $pay=($lc*($data->bsalary/30)); $tpay+=$pay; echo round($pay,0); ?></td>
</tr>
<?
}
?>
<tr>
<td colspan="16"><?=convertNumberMhafuz($tpay);?></td>
<td><strong>Total</strong></td>
<td><strong>
  <?php echo round($tpay,0); ?>
</strong></td>
</tr>
</tbody></table>
<?
}




elseif($_POST['report']==202) {       // sajeeb group Leave Consumption Report{

//$f_date = $_REQUEST['f_date'];
//$t_date = $_REQUEST['t_date'];

//if(isset($dealer_code)) {$dealer_con=' and d.dealer_code='.$dealer_code;}
//$date_con = ' and j.ji_date between "'.$f_date.'" and "'.$t_date.'" ';

// leave table
$sqlleave='SELECT PBI_ID as code, SUM( total_days) as leave1
FROM hrm_leave_info
WHERE type not in("LWP (Leave Without Pay)","Compensatory Off")
and s_date between "2017-01-01" and "2017-12-25"
GROUP BY PBI_ID';

$res = db_query($sqlleave);
	while($row=mysqli_fetch_object($res))
	{
		$leave1[$row->code] = $row->leave1;
	}

// salary table
$sqlsalary="SELECT PBI_ID as code, SUM(lv) as leave1
FROM salary_attendence a
WHERE year = 2017
and mon between 1 and 12
GROUP BY PBI_ID";

$res = db_query($sqlsalary);
	while($row=mysqli_fetch_object($res))
	{
		$salary[$row->code] = $row->leave1;

	}


?>
<center>
<h1>Leave Consumption Report </h1>
<h2>Sajeeb Group</h2>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<thead>
<tr>
	<th>S/L</th>
  <th>Code</th>
  <th>Name</th>
  <th>Designation</th>
  <th bgcolor="#009999">Department</th>
  <th bgcolor="#009999">Company</th>
  <th bgcolor="#FF6699">Date Of Join </th>
  <th bgcolor="#FF6699">Leave</th>
  <th bgcolor="#FF6699">Salary</th>
  <th>Diff</th>
  <th>Remarks </th>
  </tr>
</thead>
<tbody>
<?

$sqlview="SELECT PBI_ID as code,PBI_NAME,PBI_DESIGNATION,PBI_DEPARTMENT,PBI_ORG,PBI_DOJ
FROM  personnel_basic_info
where PBI_JOB_STATUS = 'In Service'
order by PBI_ID";

?>
<?php
$query = db_query($sqlview);
while($data= mysqli_fetch_object($query)){ ?>
<tr><td><?=++$op;?></td>
  <td><?=$data->code?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_DESIGNATION?></td>
  <td><?=$data->PBI_DEPARTMENT?></td>
  <td><?=$data->PBI_ORG?></td>
  <td><?=$data->PBI_DOJ?></td>
  <td><?=$leave1[$data->code]?></td>
  <td><?=$salary[$data->code]?></td>
  <td><?=($leave1[$data->code]-$salary[$data->code]);?></td>
  <td>&nbsp;</td>
</tr>
<? } ?>
</tbody>
</table>
<br>

<?
}
// end leave report


// 2017 leave encashment report 11 january 2018
elseif($_POST['report']==203){

$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr><th style="border:0px;" colspan="16"><?=$str?></th></tr>

<tr>
  <th>S/L</th>
  <th>Code</th>
  <th>Full Name</th>
  <th>Designation</th>
  <th>Joining Date</th>
  <th>Conf. Date</th>
  <th>Bank Acc No</th>
  <th>Basic Salary</th>
  <th>Leave Quota</th>
  <th>Leave Consumed</th>
  <th>Leave Balance</th>
  <th>Cash</th>
  <th>Bank</th>
  <th>Net Deduction</th>
  <th>Net Payable </th>
  <th>Signature</th>
  </tr>
</thead>
<tbody>
<?

$sqld="select
t.PBI_ID as code,a.PBI_NAME as name,t.pbi_designation as designation,

(select cash from salary_info where PBI_ID=a.PBI_ID) as bank,
t.basic_salary as bsalary,

a.PBI_GROUP as `Group`,
(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,
(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,
(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,
DATE_FORMAT(t.pbi_doj,'%d-%m-%Y') as joining_date,
DATE_FORMAT(t.pbi_doc,'%d-%m-%Y') as confirmation_date,
t.leave_quota,t.leave_consumed,t.leave_balance,
(Case when t.cash_paid>0 then t.cash_paid else 0 end) as cash_paid,
(Case when t.bank_paid>0 then t.bank_paid else 0 end) as bank_paid,
(Case when t.amount>0 then t.amount else 0 end) as pamount,
(Case when t.amount<0 then t.amount else 0 end) as damount
FROM personnel_basic_info a, salary_leave_cash t
WHERE
a.PBI_ID=t.PBI_ID
and t.year='2017'
".$con."
order by bsalary desc";


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
?>
<tr>
  <td><?=++$s?></td>
  <td><?=$data->code?></td>
  <td><?=$data->name?></td>
  <td><?=$data->designation?></td>
  <td><?=$data->joining_date?></td>
  <td><?=$data->confirmation_date?></td>
  <td><?=$data->bank?></td>
  <td><?php echo round($data->bsalary,0); $tbsalary +=$data->bsalary;?></td>
  <td><?=$data->leave_quota?></td>
  <td><?=$data->leave_consumed?></td>
  <td><?=$data->leave_balance?></td>
  <td><?php echo round($data->cash_paid,0); $tcash_paid +=$data->cash_paid;?></td>
  <td><?php echo round($data->bank_paid,0); $tbank_paid +=$data->bank_paid;?></td>
  <td><?php echo round($data->damount,0); $tdamount +=$data->damount;?></td>
  <td><?php echo round($data->pamount,0); $tpamount +=$data->pamount;?></td>
  <td>&nbsp;</td>
</tr>
<? } ?>
<tr>
<td colspan="6" bgcolor="#FFFFCC"><strong><? echo convertNumberMhafuz(round($tpamount,0));?></strong></td>
<td bgcolor="#FFFFCC"><strong>Total</strong></td>
<td bgcolor="#FFFFCC"><strong><?=$tbsalary?></strong></td>
<td bgcolor="#FFFFCC"></td>
<td bgcolor="#FFFFCC"></td>
<td bgcolor="#FFFFCC"></td>
<td bgcolor="#FFFFCC"><strong><?=round($tcash_paid,0);?></strong></td>
<td bgcolor="#FFFFCC"><strong><?=round($tbank_paid,0);?></strong></td>
<td bgcolor="#FFFFCC"><strong><?=round($tdamount,0);?></strong></td>
<td bgcolor="#FFFFCC"><strong>
  <?=round($tpamount,0)?>
</strong></td>
<td bgcolor="#FFFFCC">&nbsp;</td>
</tr>
</tbody></table>
<?
}

elseif($_POST['report']==666){
$mon = $_POST['mon'];
  $year = $_POST['year'];
  $totalDays=date('t',mktime(0,0,0,$mon,01,$year));
  $start_date=$year.'-'.$mon.'-01';
	$end_date=$year.'-'.$mon.'-'.$totalDays;
$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);
?>
<style>  th, td {
  border: 1px solid black;
}</style>

<table width="100%" cellspacing="0" cellpadding="2" border="1">
<thead>
<tr><th style="border:0px; height:50px; width:20px; font-size:24px; text-align:center" colspan="17">Periodic Attendance Report</th></tr>
<tr><th style="border:0px;" colspan="17"><?=$str?></th></tr>
<tr>
 <th>S/L</th>
  <th>Code</th>
  <th>Full Name</th>
  <th>Designation</th>
  <?php
   $sql_new_sks = 'select * from hrm_att_summary where   att_date between "'.$start_date.'" and "'.$end_date.'" group by att_date order by att_date asc';

	 $new_query_sks = db_query($sql_new_sks);
 while($new_r = mysqli_fetch_object($new_query_sks)){
  ?>
  <th><?=$new_r->att_date?></th>
  <?php
 }
  ?>
</tr>
</thead>
<tbody>
<?php  $sqlr = 'select distinct emp_id from hrm_att_summary where   att_date between "'.$start_date.'" and "'.$end_date.'" group by att_date,emp_id order by emp_id asc';
	 $queryr = db_query($sqlr);
	 $sl=1;
	 while($rr = mysqli_fetch_object($queryr)){
	 ?>
<tr>
<td ><?=$sl++;?></td>
  <td ><?=$rr->emp_id?></td>
  <td ><?=$name=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$rr->emp_id.'"');?></td>
  <? $des_id=find_a_field('personnel_basic_info','DESG_ID','PBI_ID="'.$rr->emp_id.'"');?>
  <td ><?=find_a_field('designation','DESG_DESC','DESG_ID="'.$des_id.'"');?></td>
    <?php
   $sql_new_sks2 = 'select * from hrm_att_summary where att_date between "'.$start_date.'" and "'.$end_date.'" group by att_date order by att_date asc';

	 $new_query_sks2 = db_query($sql_new_sks2);
 while($new_r2 = mysqli_fetch_object($new_query_sks2)){
  ?>
  <td>
<table border="0" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0">

  <?php
   $sql_new = 'select * from hrm_att_summary where   att_date ="'.$new_r2->att_date.'" and emp_id="'.$rr->emp_id.'" group by att_date order by att_date asc';

	 $new_query = db_query($sql_new);

	 while($r = mysqli_fetch_object($new_query)){
		 ?>
         <tr>
         <td><?=$r->sch_in_time?></td>
         <td><?=$r->sch_out_time?></td>
         </tr>
         <tr>
  <td>Late: </td>
  <td><?=$r->late_min?></td>
  </tr>
         <?php
		 }
  ?>

  </table>
  </td>
  <?php
 }
  ?>

</tr>
<?php
	 }
?>
</tbody>
</table>

<!--<table width="100%" cellspacing="0" cellpadding="2" border="1">
<thead>
<tr><th style="border:0px;" colspan="17"><?=$str?></th></tr>


<tr>
  <th>S/L</th>
  <th>Code</th>
  <th>Full Name</th>
  <th>Designation</th>

  </tr>
</thead>
<tbody>
<?php echo $sqlr = 'select distinct emp_id from hrm_att_summary where   att_date between "'.$start_date.'" and "'.$end_date.'" group by att_date,emp_id order by emp_id asc';
	 $queryr = db_query($sqlr);
	 $sl=0;
	 while($rr = mysqli_fetch_object($queryr)){ ?>
<tr>
  <td rowspan="2"><?=$sl++;?></td>
  <td rowspan="2"><?=$rr->emp_id?></td>
  <td rowspan="2"><?=$name=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$rr->emp_id.'"');?></td>
  <td rowspan="2">Robin</td>

</tr>
<?php

 }

 ?>
</tbody>
</table>-->
<?php
}

elseif($_POST['report']==204){ // --------------- Friday Working Bill

if($_POST['pbi_id_in']!='')  $con .= " and a.PBI_ID in (".$_POST['pbi_id_in'].")";

//$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr><th style="border:0px;" colspan="16"><?=$str?></th></tr>

<tr>
  <th>S/L</th>
  <th>Code</th>
  <th>Full Name</th>
  <th>Designation</th>
  <th>Joining Date</th>
  <th>Conf. Date</th>
  <th>Bank Acc No</th>
  <th>Basic Salary</th>
  <th>Leave Quota</th>
  <th>Leave Consumed</th>
  <th>Leave Balance</th>
  <th>Cash</th>
  <th>Bank</th>
  <th>Net Deduction</th>
  <th>Net Payable </th>
  <th>Signature</th>
  </tr>
</thead>
<tbody>
<?

$sqld="select
t.PBI_ID as code,a.PBI_NAME as name,t.pbi_designation as designation,

(select cash from salary_info where PBI_ID=a.PBI_ID) as bank,
t.basic_salary as bsalary,

a.PBI_GROUP as `Group`,
(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,
(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,
(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,
DATE_FORMAT(t.pbi_doj,'%d-%m-%Y') as joining_date,
DATE_FORMAT(t.pbi_doc,'%d-%m-%Y') as confirmation_date,
t.leave_quota,t.leave_consumed,t.leave_balance,
(Case when t.cash_paid>0 then t.cash_paid else 0 end) as cash_paid,
(Case when t.bank_paid>0 then t.bank_paid else 0 end) as bank_paid,
(Case when t.amount>0 then t.amount else 0 end) as pamount,
(Case when t.amount<0 then t.amount else 0 end) as damount
FROM personnel_basic_info a, salary_leave_cash t
WHERE
a.PBI_ID=t.PBI_ID
and t.year='2017'
".$con."
order by bsalary desc";


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
?>
<tr>
  <td><?=++$s?></td>
  <td><?=$data->code?></td>
  <td><?=$data->name?></td>
  <td><?=$data->designation?></td>
  <td><?=$data->joining_date?></td>
  <td><?=$data->confirmation_date?></td>
  <td><?=$data->bank?></td>
  <td><?php echo round($data->bsalary,0); $tbsalary +=$data->bsalary;?></td>
  <td><?=$data->leave_quota?></td>
  <td><?=$data->leave_consumed?></td>
  <td><?=$data->leave_balance?></td>
  <td><?php echo round($data->cash_paid,0); $tcash_paid +=$data->cash_paid;?></td>
  <td><?php echo round($data->bank_paid,0); $tbank_paid +=$data->bank_paid;?></td>
  <td><?php echo round($data->damount,0); $tdamount +=$data->damount;?></td>
  <td><?php echo round($data->pamount,0); $tpamount +=$data->pamount;?></td>
  <td>&nbsp;</td>
</tr>
<? } ?>
<tr>
<td colspan="6" bgcolor="#FFFFCC"><strong><? echo convertNumberMhafuz(round($tpamount,0));?></strong></td>
<td bgcolor="#FFFFCC"><strong>Total</strong></td>
<td bgcolor="#FFFFCC"><strong><?=$tbsalary?></strong></td>
<td bgcolor="#FFFFCC"></td>
<td bgcolor="#FFFFCC"></td>
<td bgcolor="#FFFFCC"></td>
<td bgcolor="#FFFFCC"><strong><?=round($tcash_paid,0);?></strong></td>
<td bgcolor="#FFFFCC"><strong><?=round($tbank_paid,0);?></strong></td>
<td bgcolor="#FFFFCC"><strong><?=round($tdamount,0);?></strong></td>
<td bgcolor="#FFFFCC"><strong>
  <?=round($tpamount,0)?>
</strong></td>
<td bgcolor="#FFFFCC">&nbsp;</td>
</tr>
</tbody></table>
<?
}
elseif($_POST['report']==8) { // mobile number update report


 $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,
a.PBI_GROUP as `Group`,
a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,
(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,
(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,
(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,
a.PBI_EDU_QUALIFICATION as qualification,
a.PBI_MOBILE as mobile
from personnel_basic_info a
where 1 ".$con;
$query = db_query($sql);
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>
<tr><th>S/L</th>
<th>CODE</th>
<th>Name</th>
<th>Desg</th>
<th>Dept</th>
<th>Group</th>
<th>Join_date</th>

<th>Area</th>
<th>Zone</th>
<th>Region</th>
<th>Internet Sim</th>
<th>Mobile No </th>
<th>Update</th>
</tr></thead>
<tbody>
<?
while($datas=mysqli_fetch_row($query)){$s++;
?>
<tr><td><?=$s?></td>
<td><?=$datas[0]?></td>
<td><?=$datas[1]?></td>
  <td><?=$datas[2]?></td>
  <td><?=$datas[3]?></td>
  <td><?=$datas[4]?></td>
  <td><?=$datas[5]?></td>

  <td style="text-align:right"><?=$datas[7]?></td>
  <td style="text-align:right"><?=$datas[8]?></td>
  <td><?=$datas[9]?></td>
  <td>
    <input name="sim#<?=$datas[0]?>" type="text" id="sim#<?=$datas[0]?>" value="<?=$datas[12]?>" /></td>
  <td><input type="hidden" name="PBI_ID#<?=$datas[0]?>" id="PBI_ID#<?=$datas[0]?>" value="<?=$datas[0]?>" />
      <input name="mobile#<?=$datas[0]?>" type="text" id="mobile#<?=$datas[0]?>" value="<?=$datas[11]?>" /></td>
  <td>
  <div id="po<?=$datas[0]?>">
 <input type="button" name="Change" value="Change" onClick="update_value(<?=$datas[0]?>)" />
 </div> </td></tr>







<?
}
?></tbody></table>
<?
}
elseif($_POST['report']==22222){
?>

<table width="100%" cellpadding="0" cellspacing="0" border="1" bordercolor="#000000">
<thead><tr><td style="border:0px;" colspan="13"><?=$str?></td></tr></thead>
<?
$begin = new DateTime( $start_date );
$end   = new DateTime( $end_date );
$x = 0;
for($i = $begin; $i <= $end; $i->modify('+1 day')){ $x++;
$date_ymd[$x] = $i->format("Y-m-d");
$date_stamp[$x] = strtotime($date[$x]);
}

		$sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT,a.JOB_LOCATION from
		personnel_basic_info a
		where  1 ".$con."  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";
		$query = db_query($sql);
		while($info=mysqli_fetch_object($query))
		{

$sql_sks = 'SELECT id, point_short_name,job_location FROM `hrm_roster_point` ';
$sks_query = db_query($sql_sks);
while($sks_r = mysqli_fetch_object($sks_query)){
?>
<tr>
  <td rowspan="2">SL</td>
  <td rowspan="2"><?=$sks_r->point_short_name;?></td>
  <td rowspan="2">Cell No </td>


<?
for($p=1;$p>=$x;$p++){
?><td>
<?
echo date('M-d',$date_stamp[$p]);
?></td>
<?
}
?>
  </tr>
<tr>
<?
for($pp=1;$pp>=$x;$pp++){
?><td>
<?
echo date('D',$date_stamp[$pp]);
?></td>
<?
}
?>
</tr>
<?
$sqlss = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT,a.PBI_MOBILE from
personnel_basic_info a,hrm_roster_allocation r
where ".$con." r.PBI_ID=a.PBI_ID and r.roster_date between '".$start_date."' and '".$end_date."' and a.JOB_LOCATION = '".$sks_r->job_location."'  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";
$querys = db_query($sqlss);
while($datas = mysqli_fetch_array($querys)){
?>
<tr>
<td><?=++$s?></td>
<td><?=$datas->PBI_NAME?></td>
<td><?=$datas->PBI_MOBILE?></td>
<?
for($ppp=1;$ppp>=$x;$ppp++){
?>
<td><?=find_a_field('hrm_roster_allocation r,hrm_schedule_info s','s.schedule_name','r.PBI_ID ="'.$info->PBI_ID.'" and r.shedule_1=s.id and r.roster_date = "'.date('Y-m-d',$date_stamp[$ppp]).'"')?></td>
<? }?>
</tr>
<?
}}}
?>
</table>
<?
	}
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?>

<!--<table width="100%"  border="0" id="No CSS Style">
<tr>
  <td style="border-color:#FFFFFF">&nbsp;</td>
  <td style="border-color:#FFFFFF">&nbsp;</td>
  <td style="border-color:#FFFFFF">&nbsp;</td>
  <td style="border-color:#FFFFFF">&nbsp;</td>
  <td style="border-color:#FFFFFF">&nbsp;</td>
</tr>
<tr>
  <td style="border-color:#FFFFFF">&nbsp;</td>
  <td style="border-color:#FFFFFF">&nbsp;</td>
  <td style="border-color:#FFFFFF">&nbsp;</td>
  <td style="border-color:#FFFFFF">&nbsp;</td>
  <td style="border-color:#FFFFFF">&nbsp;</td>
</tr>
<tr>
    <td style="border-color:#FFFFFF">...............................</td>
    <td style="border-color:#FFFFFF">...............................</td>
    <td style="border-color:#FFFFFF">...............................</td>
    <td style="border-color:#FFFFFF">...............................</td>
    <td style="border-color:#FFFFFF">...............................</td>
  </tr>
  <tr>
    <td style="border-color:#FFFFFF">Prepared By</td>
    <td style="border-color:#FFFFFF">Checked By</td>
    <td style="border-color:#FFFFFF">Audited By</td>
    <td style="border-color:#FFFFFF">Forwarded By</td>
    <td style="border-color:#FFFFFF">Approved By</td>
    </tr>
</table>-->

</div></div>

</form>
</body>
</html>
