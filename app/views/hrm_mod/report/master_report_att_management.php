<?




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

//require "../../classes/report.class.php";

require_once "../../../controllers/core/class.numbertoword.php";

require_once "../../../controllers/core/inc.exporttable.php";
 



date_default_timezone_set('Asia/Dhaka');



//__________________________  Fractional Calculate method Function ______________
function roundToQuarter($number)
{
  $integerPart = floor($number);
  $fractionalPart = $number - $integerPart;

  if ($fractionalPart >= 0.0 && $fractionalPart <= 0.24) {
    $roundedFractionalPart = 0.0;
  } elseif ($fractionalPart >= 0.25 && $fractionalPart <= 0.49) {
    $roundedFractionalPart = 0.25;
  } elseif ($fractionalPart >= 0.5 && $fractionalPart <= 0.74) {
    $roundedFractionalPart = 0.5;
  } elseif ($fractionalPart >= 0.75 && $fractionalPart <= 0.99) {
    $roundedFractionalPart = 0.75;
  } else {
    // Handle invalid input or out-of-range fractional parts here
    return false;
  }

  return $integerPart + $roundedFractionalPart;
}

//__________________________ END  Fractional Calculate method Function ______________





if (isset($_POST['submit']) && isset($_POST['report']) && $_POST['report'] > 0) {
 
	if ($_POST['name'] != '')



		$con .= ' and a.PBI_NAME like "%' . $_POST['name'] . '%"';



	//if($_POST['PBI_ORG']!=''){



	//if($_POST['report']==64&&$_POST['PBI_ORG']=='2')



	//$con.=' and a.PBI_ORG IN (1,2)';



	//else $con.=' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';


	//}






	if ($_POST['department'] != '') {
















		$con .= ' and a.DEPT_ID = "' . $_POST['department'] . '"';















		$DEPARTMENT_con = ' and a.PBI_DEPARTMENT = "' . $_POST['department'] . '"';
	}















	if ($_POST['project'] != '')















		$con .= ' and a.PBI_PROJECT = "' . $_POST['project'] . '"';















	if ($_POST['designation'] != '')















		$con .= ' and a.DESG_ID = "' . $_POST['designation'] . '"';















	if ($_POST['zone'] != '')















		$con .= ' and a.PBI_ZONE = "' . $_POST['zone'] . '"';































	if ($_POST['JOB_LOCATION'] != '') {















		$con .= ' and a.JOB_LOC_ID = "' . $_POST['JOB_LOCATION'] . '"';















		$PBI_LOCATION_con = ' and a.JOB_LOCATION = "' . $_POST['JOB_LOCATION'] . '"';
	}































	if ($_POST['PBI_GROUP'] != '') {















		$con .= ' and a.PBI_GROUP = "' . $_POST['PBI_GROUP'] . '"';















		$PBI_GROUP_con = ' and a.PBI_GROUP = "' . $_POST['PBI_GROUP'] . '"';
	}































	if ($_POST['area'] != '')















		$con .= ' and a.PBI_AREA = "' . $_POST['area'] . '"';































	if ($_POST['report'] != 778 && $_POST['report'] != 79 && $_POST['report'] != 1) {















		if ($_POST['branch'] != '') $con .= ' and t.pbi_region ="' . $_POST['branch'] . '"';
	}















































	if ($_POST['PBI_DOMAIN'] != '')	$con .= " and PBI_DOMAIN = '" . $_POST['PBI_DOMAIN'] . "'";















	if ($_POST['job_status'] != '' && $_POST['report'] != 7811 && $_POST['report'] != 60 && $_POST['report'] != 61)















		$con .= ' and a.PBI_JOB_STATUS = "' . $_POST['job_status'] . '"';















	if ($_POST['gender'] != '')















		$con .= ' and a.PBI_SEX = "' . $_POST['gender'] . '"';































	if ($_POST['ijdb'] != '')















		$con .= ' and a.PBI_DOJ < "' . $_POST['ijdb'] . '"';















	if ($_POST['ppjdb'] != '')















		$con .= ' and a.PBI_DOJ_PP < "' . $_POST['ppjdb'] . '"';































	if ($_POST['ijda'] != '')















		$con .= ' and a.PBI_DOJ > "' . $_POST['ijda'] . '"';















	if ($_POST['ppjda'] != '')















		$con .= ' and a.PBI_DOJ_PP > "' . $_POST['ppjda'] . '"';















	if ($_POST['PBI_ID'] != '')















		$con .= ' and a.PBI_ID="' . $_POST['PBI_ID'] . '"';















	if ($_POST['pbi_id_in'] != '')















		$con .= ' and a.PBI_CODE="' . $_POST['pbi_id_in'] . '"';























	if ($_POST['EMPLOYMENT_TYPE'] != '')















		$con .= " and a.EMPLOYMENT_TYPE='" . $_POST['EMPLOYMENT_TYPE'] . "' ";















	if ($_POST['sub_department'] != '')















		$con .= " and a.PBI_SUB_DEPARTMENT='" . $_POST['sub_department'] . "' ";















	if ($_POST['PBI_POB'] != '')















		$con .= " and a.PBI_POB='" . $_POST['PBI_POB'] . "' ";















	if ($_POST['PBI_FATHER_NAME'] != '')















		$con .= " and a.PBI_FATHER_NAME='" . $_POST['PBI_FATHER_NAME'] . "' ";















	if ($_POST['PBI_UNIVERSITY'] != '')















		$con .= " and a.PBI_UNIVERSITY='" . $_POST['PBI_UNIVERSITY'] . "' ";















	if ($_POST['PBI_PASSING_YEAR'] != '')















		$con .= " and a.PBI_PASSING_YEAR='" . $_POST['PBI_PASSING_YEAR'] . "' ";























	if ($_POST['PBI_EDU_QUALIFICATION'] != '')















		$con .= " and a.PBI_EDU_QUALIFICATION like '" . $_POST['PBI_EDU_QUALIFICATION'] . "%' ";















	if ($_POST['BLOOD_GROUP'] != '')















		$con .= " and a.BLOOD_GROUP ='" . $_POST['BLOOD_GROUP'] . "' ";















	if ($_POST['service_length'] != '')















		$service_con = " and TIMESTAMPDIFF(YEAR, `PBI_DOJ`, CURDATE()) ='" . $_POST['service_length'] . "' ";







































	if ($_POST['start_date'] != '')















		$start_date = $_POST['start_date'];















	if ($_POST['end_date'] != '')















		$end_date = $_POST['end_date'];









	if ($_POST['bank_or_cash'] != '') {

		$bank_or_cash_con = " and s.bank_or_cash= '" . $_POST['bank_or_cash'] . "'";
	} else {

		$bank_or_cash_con = " and s.bank_or_cash in ('Bank','Cash')";
	}































































	switch ($_POST['report']) {







































		case 611111:







			$report = "Full Leave Details Report";







			break;



		case 991:

			$report = "Late Report";

			break;



		case 992:

			$report = "Early Report";

			break;



		case 993:

			$report = "Punch Report";

			break;



		case 994:

			$report = "Department Wise Attedence Summary";

			break;



		case 995:

			$report = "Leave Report Summary";

			break;



		case 20220519:

			$report = "Amendment Report";

			break;



		case 19191:

			$report = "Roster Schedule Report";

			break;





		case 62222:







			$report = "Half Leave Details Report";







			break;







		case 2454:







			$report = "Member Birthday Report";







			break;







		case 81:



			$report = "Attendance Summary Report";





			break;















		case 6655:







			$report = "Yearly PF Report - " . $_POST['year'] . "";







			break;















		case 1:















			$report = "Employee Basic Information";







			$sql = "select a.PBI_ID,a.PBI_NAME as Name, a.PBI_DESIGNATION as designation, a.PBI_DEPARTMENT as department, a.JOB_LOCATION ,a.PBI_JOB_STATUS as job_status,



DATE_FORMAT(a.PBI_DOJ,'%d-%m-%Y') as joining_date,CONCAT(TIMESTAMPDIFF(YEAR, `PBI_DOJ`, CURDATE()),' Year,',TIMESTAMPDIFF(MONTH, `PBI_DOJ`, CURDATE()) % 12,' mon') as service_lenght,a.PBI_SEX as gender,a.PBI_MOBILE as office_mobile,a.PBI_MOBILE_ALTR as personnel_mobile,a.PBI_EMAIL as office_email,a.PBI_EMAIL_ALT as personnel_email,







EMPLOYMENT_TYPE as employment_type from personnel_basic_info a















where	1 " . $con . $employee_con . $service_con . " order by a.PBI_ID";































			// DATE_FORMAT(a.PBI_DOC,'%d-%m-%Y') as due_confirmation_date,















			// (select DESG_DESC from designation where DESG_SHORT_NAME=a.PBI_DESIGNATION) as designation,















			//  schedule_type,punch_type,define_offday,define_schedule,general_schedule,grace_type,employee_type































			break;







		case 22:















			$report = "Member Payroll Information For Recruitment";















































			$sql = "select















(select group_name from user_group where id = a.PBI_ORG) as company,















(select LOCATION_NAME from office_location where ID=a.job_location) as location,















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















" . $con . "















order by a.PBI_ID";































			break;















































		case 23:















			$report = "Member Payroll Information";















































			$sql = "select a.PBI_CODE as emp_id, a.PBI_NAME as employee_name,(select DESG_DESC from designation where DESG_ID=a.PBI_DESIGNATION) as designation,a.PBI_DOJ as joining_date,s.gross_salary,s.basic_salary,s.house_rent,s.special_allowance as basic_aggregation,s.ta as conveyance,s.medical_allowance,s.child_allowance,s.performance_bonus,s.resourse_bonus,s.mobile_allowance from salary_info s, personnel_basic_info a where s.gross_salary>0 and  s.PBI_ID=a.PBI_ID " . $con . " order by s.gross_salary desc";































			break;















































		case 201:















			$report = "Member Leave Information";















			break;































		case 22222:















			$report = "HRM Roaster Summary report";















			break;































		case 777:















			$report = "Member Bonus Report";















			if ($_POST['branch'] != '')















				$con .= ' and a.PBI_BRANCH ="' . $_POST['branch'] . '"';





			$con .= ' and a.JOB_LOC_ID ="' . $_POST['JOB_LOCATION'] . '" ';



			if ($_POST['bank_or_cash'] != '')

				$con .= ' and b.bank_or_cash ="' . $_POST['bank_or_cash'] . '" ';















			$sql = "select a.PBI_CODE as CODE,a.PBI_NAME as Name,d.DESG_DESC as designation, date_format(a.PBI_DOJ,'%d-%m-%Y') as joining_date,b.bank_or_cash,b.bank_acc_no,b.bonus_amt













		from















		personnel_basic_info a, salary_bonus b, salary_info s ,designation d















		where















		1 and a.PBI_ID=b.PBI_ID and a.DESG_ID=d.DESG_ID and















		s.PBI_ID=b.PBI_ID and b.bonus_type=" . $_POST['bonus_type'] . " and















		b.year=" . $_POST['year'] . " " . $con . "































		order by b.bonus_amt desc,a.PBI_DESG_GRADE asc















		";















			// a.PBI_JOB_STATUS= 'In Service'































			break;































		case 64:















			$report = "Member Bonus Summery Report";































			if ($_POST['branch'] != '') $con .= ' and a.PBI_BRANCH ="' . $_POST['branch'] . '"';















































			$sql = "















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















and b.bonus_type=" . $_POST['bonus_type'] . "















and b.year=" . $_POST['year'] . " " . $con . "































group by d.DEPT_DESC















order by d.DEPT_DESC















";































			break;































		case 65:















			$report = "Member Bonus Sales Summery Report";































			if ($_POST['branch'] != '') $con .= ' and a.PBI_BRANCH ="' . $_POST['branch'] . '"';















































			echo $sql = "















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















and b.bonus_type=" . $_POST['bonus_type'] . "















and b.year=" . $_POST['year'] . "















" . $con . "































group by br.BRANCH_NAME















order by br.BRANCH_NAME















";































			break;































		case 778:















			$report = "Member Bonus Report (Sales)";















			if ($_POST['branch'] != '')















				$con .= ' and a.PBI_BRANCH ="' . $_POST['branch'] . '"';































			$sql = "select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation, date_format(a.PBI_DOJ,'%d-%m-%Y') as joining_date,















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















		s.PBI_ID=b.PBI_ID and b.bonus_type=" . $_POST['bonus_type'] . " and















		b.year=" . $_POST['year'] . " " . $con . "















		and b.pbi_held_up = 0















		order by b.bonus_amt desc,a.PBI_DESG_GRADE asc















		";































			break;















































		case 10001:































			$report = "Member Details Information";































			$sql = "select a.PBI_ID as CODE,a.PBI_NAME as Name,















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















(select LOCATION_NAME from office_location where id=a.JOB_LOCATION) JOB_LOCATION,a.PBI_POB as home_dist, PBI_PERMANENT_ADD as address















from personnel_basic_info a















where	1 " . $con;















































































			break;















































		case 2:



			$report = "Employee Salary & Benefits Information";



			$sql = "select a.PBI_CODE as Employee_id,a.PBI_NAME as Name,



(select group_name from user_group where id = a.PBI_ORG) as concern,



a.PBI_DESIGNATION as designation,a.PBI_DEPARTMENT as department,



b.cash as payment_method,b.basic_salary,b.house_rent,b.conveyance,



b.medical_allowance,



b.gross_salary



from personnel_basic_info a,salary_info b where	a.PBI_ID=b.PBI_ID " . $con . " order by b.basic_salary desc";





			break;



		case 789:



			$report = "Salary Final Report";



			$sql = "select a.PBI_CODE as Emp_Id,a.PBI_NAME as Name,desg.DESG_DESC as designation,dept.DEPT_DESC as department,a.PBI_DOJ as joining_date,s.bank_or_cash,s.bank_account_no as account_no,'' as 'Previous Salary','' as 'Increment 2021',s.gross_salary,s.basic_salary,s.house_rent,s.medical_allowance,s.conveyance,s.td as days_in_month,s.pay as present,s.ab as absent,s.late_deduction_days as 'leave_Deduct/salary_deduct',s.gross_salary as gross_payable,s.over_time_hr as Ot_Hr,s.over_time_amount as Ot_Amt,s.arrear,s.incentive,s.total_salary as total_earning,s.advance_install as advance_salary,s.income_tax as tds,s.food_deduction as lunch,s.fine_deduction as fine,s.mobile_bill_amt as mobile_bill,s.stamp_fee,s.total_payable as net_payable_salary,s.bank_amt as Bank_Amount,s.cash_amt as Cash_Amount,'' as 'Revenue_Stamp','' as 'signature' from salary_attendence s left join department dept on dept.DEPT_ID=s.PBI_DEPARTMENT left join designation desg on desg.DESG_ID=s.PBI_DESIGNATION, personnel_basic_info a where s.pbi_held_up=0 and  a.PBI_ID=s.PBI_ID and s.mon='" . $_POST['mon'] . "' and s.year='" . $_POST['year'] . "' " . $bank_or_cash_con . " " . $con . "  ";





			break;













			//     case 3:















			// 	$report="Monthly Attendence Report";















			// if($_POST['mon']>0&&$_POST['year']>0)















			// {















			// 	$mon = $_POST['mon'];















			// 	$year = $_POST['year'];















			// 	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,















			// 	(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,















			// 	a.PBI_DEPARTMENT as department, b.td as total_day,b.od as off_day,b.hd as holy_day, 	b.lt as late_days, 	b.ab as absent_days,b.lv as leave_days,b.pre as present_days, 	b.pay as payable_days,b.ot as over_time_hour FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;















			// }















			// 		break;















		case 4:















			$report = "Over Time Report";















			if ($_POST['mon'] > 0 && $_POST['year'] > 0) {















				$mon = $_POST['mon'];















				$year = $_POST['year'];















				$sql = "SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department, b.ot as over_time_hour,(b.total_salary/208) as rate,b.over_time_amount FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='" . $mon . "' and b.year='" . $year . "'" . $con;
			}















			break;















		case 5:















			$report = "Salary Payroll Report (Detail)";















			if ($_POST['mon'] > 0 && $_POST['year'] > 0) {















				$mon = $_POST['mon'];















				$year = $_POST['year'];















				$sql = "SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,















	b.od,b.hd,b.lt,b.ab,b.lv,b.pre,b.pay,















	b.over_time_amount,















	b.basic_salary,b.total_salary as consolidated_salary,b.house_rent,b.medical_allowance,b.other_allowance,b.special_allowance,b.ta_da as TA_DA, b.food_allowance as fooding, b.mobile_allowance,b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction,b.total_benefits,b.total_payable*(1.00) as total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='" . $mon . "' and b.year='" . $year . "'" . $con;
			}















			break;































		case 6:















			$report = "Salary Payroll Report (Summary)";















			if ($_POST['mon'] > 0 && $_POST['year'] > 0) {















				$mon = $_POST['mon'];















				$year = $_POST['year'];















				$sql = "SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,















	b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction,b.total_benefits,b.total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='" . $mon . "' and b.year='" . $year . "'" . $con;
			}















			break;































		case 60:















			$report = "IOM Report";















			if ($_POST['mon'] > 0 && $_POST['year'] > 0) {















				$mon = $_POST['mon'];















				$year = $_POST['year'];















				$totalDays = date('t', mktime(0, 0, 0, $mon, 01, $year));















				$startDate = $year . '-' . $mon . '-01';















				$endDate = $year . '-' . $mon . '-' . $totalDays;































				$sql = "SELECT a.PBI_NAME,a.PBI_ID as Employee_ID,i.type,i.s_date,i.e_date,i.s_time,i.e_time,i.total_days,i.reason,s.iom_entry_at



	 FROM hrm_iom_info i, personnel_basic_info a,hrm_att_summary s where i.id=s.iom_id and a.PBI_ID=i.PBI_id and i.s_date>='" . $startDate . "' and i.e_date<='" . $endDate . "' " . $con . " order by i.id desc";
			}
















			break;































		case 61:















			$report = "Leave Report Summary";















			if ($_POST['mon'] > 0 && $_POST['year'] > 0) {















				$mon = $_POST['mon'];















				$year = $_POST['year'];















				$totalDays = date('t', mktime(0, 0, 0, $mon, 01, $year));















				$startDate = $year . '-01-01';















				$endDate = $year . '-12-' . $totalDays;































				// $sql="SELECT p.PBI_CODE as Emp_ID,p.PBI_NAME as Employee_Name,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation,p.PBI_DOJ as joining_date, l.casual,l.medical  FROM hrm_leave_info l, personnel_basic_info p where l.s_date>='".$startDate."' and l.e_date<='".$endDate."' and p.PBI_ID=l.PBI_ID";















			}















			break;































		case 7:















			$report = "Salary Payroll Report";















			break;































		case 77:















			$report = "Salary Payroll Report Final (Sales)";















			break;















		case 78:















			$report = "Salary Payroll Report Final";















			break;































		case 979:















			$report = "Vehicle Management";















			break;































		case 79:















			$report = "Salary Pay Slip";















			if ($_POST['mon'] > 0 && $_POST['year'] > 0) {















				$mon = $_POST['mon'];















				$year = $_POST['year'];
			}















			break;































		case 8:















			$report = "Member Mobile Information(Changable)";















			break;















		case 66:















			$report = "Bill of Salary for the month of " . date('M', $_POST['mon']) . '-' . $_POST['year'];















			if ($_POST['mon'] > 0 && $_POST['year'] > 0) {















				$mon = $_POST['mon'];















				$year = $_POST['year'];















				echo  $sql = "SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as desg ,a.PBI_DEPARTMENT as dept,a.PBI_DOJ joining_date,b.pre,b.od,b.hd,b.lv,b.lwp,b.ab,b.pay,















	  b.total_salary,b.special_allowance,(b.total_salary+b.special_allowance) actual_amount,















	b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction, (b.total_salary-b.total_deduction) as actual_salary, b.total_benefits,b.total_payable FROM































	personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='" . $mon . "' and b.year='" . $year . "'" . $con;
			}















			break;















		case 11:















			$report = "OutStanding Dues";















			if (isset($party_code)) {
				$client_name = find_a_field('tbl_party_info', 'party_name', 'party_code=' . $party_code);
				$party_con = ' and d.party_code=' . $party_code;
			}















			if (isset($proj_code))















				if (!isset($flat_no)) {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);
					$proj_con = ' and a.proj_code=' . $proj_code;
				} else {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);















					$allotment_no = $flat_no;
					$flat_show = ',a.flat_no as allot_no';
					$flat_con = ' and a.proj_code=' . $proj_code . ' and a.flat_no=\'' . $flat_no . '\' ';
				}































			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and a.inst_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}















			$sql = "select c.proj_name as project_name,a.flat_no as allot_no,b.party_name as client_name,a.inst_date,a.inst_amount as payable_amt,a.rcv_amount as received_amt from tbl_flat_cost_installment a, tbl_party_info b, tbl_project_info c,tbl_flat_info d where a.proj_code=c.proj_code and d.party_code=b.party_code and a.proj_code=d.proj_code and a.build_code=d.build_code and a.flat_no=d.flat_no and rcv_status=0 " . $proj_con . $date_con . $flat_con . $party_con . " order by a.inst_date";















			break;















		case 12:















			$report = "Expected Collection";















			if (isset($party_code)) {
				$client_name = find_a_field('tbl_party_info', 'party_name', 'party_code=' . $party_code);
				$party_con = ' and d.party_code=' . $party_code;
			}















			if (isset($proj_code))















				if (!isset($flat_no)) {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);
					$proj_con = ' and a.proj_code=' . $proj_code;
				} else {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);















					$allotment_no = $flat_no;
					$flat_show = ',a.flat_no as allot_no';
					$flat_con = ' and a.proj_code=' . $proj_code . ' and a.flat_no=\'' . $flat_no . '\' ';
				}































			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and a.inst_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}















			$sql = "select c.proj_name as project_name,a.flat_no as allot_no,b.party_name as client_name,a.inst_date,a.inst_amount as payable_amt,a.rcv_amount as received_amt from tbl_flat_cost_installment a, tbl_party_info b, tbl_project_info c,tbl_flat_info d where a.proj_code=c.proj_code and d.party_code=b.party_code and a.proj_code=d.proj_code and a.build_code=d.build_code and a.flat_no=d.flat_no " . $proj_con . $date_con . $flat_con . $party_con . " order by a.inst_date";















			break;































		case 203:















			$report = "Leave Encashment Report-2017";















			break;































		case 13:















			$report = "Payment Schedule";















			if (isset($party_code)) {
				$client_name = find_a_field('tbl_party_info', 'party_name', 'party_code=' . $party_code);
				$party_con = ' and d.party_code=' . $party_code;
			}















			if (isset($proj_code))















				if (!isset($flat_no)) {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);
					$proj_con = ' and a.proj_code=' . $proj_code;
				} else {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);















					$allotment_no = $flat_no;
					$flat_show = ',a.flat_no as allot_no';
					$flat_con = ' and a.proj_code=' . $proj_code . ' and a.flat_no=\'' . $flat_no . '\' ';
				}































			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and a.inst_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}















			$sql = "SELECT e.pay_desc,a.inst_no, c.proj_name AS project_name,a.flat_no AS allot_no,  a.inst_date, a.inst_amount AS payable_amt, a.rcv_date AS receive_date, a.rcv_amount AS receive_amt















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















AND a.pay_code = e.pay_code" . $proj_con . $date_con . $flat_con . $party_con . " order by a.inst_date";















			break;















		case 14:















			$report = "Party Rent Agreement Terms";















			if (isset($party_code)) {
				$client_name = find_a_field('tbl_party_info', 'party_name', 'party_code=' . $party_code);
				$party_con = ' and a.party_code=' . $party_code;
			}















			if (isset($proj_code))















				if (!isset($flat_no)) {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);
					$proj_con = ' and a.proj_code=' . $proj_code;
				} else {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);















					$allotment_no = $flat_no;
					$flat_show = ',a.flat_no as allot_no';
					$flat_con = ' and a.proj_code=' . $proj_code . ' and a.flat_no=\'' . $flat_no . '\' ';
				}































			$sql = "SELECT b.`proj_name`,a.`flat_no`,c.`party_name`,a.`monthly_rent`,a.`effective_date`,a.`expire_date`,a.`notice_period`,a.discontinue_term,a.`witness1`,a.`witness1_address` FROM `tbl_rent_info` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code " . $proj_con . $flat_con . $party_con;















			break;















		case 15:















			$report = "Party Rent Payment Terms";















			if (isset($party_code)) {
				$client_name = find_a_field('tbl_party_info', 'party_name', 'party_code=' . $party_code);
				$party_con = ' and a.party_code=' . $party_code;
			}















			if (isset($proj_code))















				if (!isset($flat_no)) {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);
					$proj_con = ' and a.proj_code=' . $proj_code;
				} else {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);















					$allotment_no = $flat_no;
					$flat_show = ',a.flat_no as allot_no';
					$flat_con = ' and a.proj_code=' . $proj_code . ' and a.flat_no=\'' . $flat_no . '\' ';
				}































			$sql = "SELECT b.`proj_name`,a.`flat_no`,c.`party_name`,a.`security_money`,a.`monthly_rent`,a.`electricity_bill`,a.`other_bill`,a.`wasa_bill`,a.`gas_bill`,(a.`monthly_rent`++a.`electricity_bill`+a.`other_bill`+a.`wasa_bill`+a.`gas_bill`) as total_payable FROM `tbl_rent_info` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code " . $proj_con . $flat_con . $party_con;















			break;















		case 16:















			$report = "Party Rent Payment Terms";















			if (isset($party_code)) {
				$client_name = find_a_field('tbl_party_info', 'party_name', 'party_code=' . $party_code);
				$party_con = ' and a.party_code=' . $party_code;
			}















			if (isset($proj_code))















				if (!isset($flat_no)) {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);
					$proj_con = ' and a.proj_code=' . $proj_code;
				} else {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);















					$allotment_no = $flat_no;
					$flat_show = ',a.flat_no as allot_no';
					$flat_con = ' and a.proj_code=' . $proj_code . ' and a.flat_no=\'' . $flat_no . '\' ';
				}































			$sql = "SELECT a.jv_no as Invoice_no,a.mon as period,b.`proj_name`,a.`flat_no`,c.`party_name`,a.`rent_amt`,a.`electricity_bill`,a.`other_bill`,a.`wasa_bill`,a.`gas_bill`,total_amt as total_amt FROM `tbl_rent_receive` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code " . $proj_con . $flat_con . $party_con;















			break;































		case 24:















			$report = "Collection Statement(Cash)";















			if (isset($proj_code))















				if (!isset($flat_no)) {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);
					$proj_con = ' and a.proj_code=' . $proj_code;
				} else {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);















					$allotment_no = $flat_no;
					$flat_show = ',a.flat_no as allot_no';
					$flat_con = ' and a.proj_code=' . $proj_code . ' and a.flat_no=\'' . $flat_no . '\' ';
				}















			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and a.rec_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}















			$sql = "select a.rec_date as tr_date,b.proj_name" . $flat_show . ",a.rec_amount as total_amt from tbl_receipt a,tbl_project_info b where a.pay_mode=0 and a.proj_code=b.proj_code " . $proj_con . $date_con . $flat_con . " order by a.rec_date";















			break;















		case 25:















			$report = "Collection Statement(Chaque)";















			if (isset($proj_code))















				if (!isset($flat_no)) {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);
					$proj_con = ' and a.proj_code=' . $proj_code;
				} else {
					$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);















					$allotment_no = $flat_no;
					$flat_show = ',a.flat_no as allot_no';
					$flat_con = ' and a.proj_code=' . $proj_code . ' and a.flat_no=\'' . $flat_no . '\' ';
				}















			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and a.rec_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}















			$sql = "select a.rec_date as tr_date,a.cheq_no,b.proj_name" . $flat_show . ",a.rec_amount as total_amt from tbl_receipt a,tbl_project_info b where a.pay_mode=1 and a.proj_code=b.proj_code " . $proj_con . $date_con . $flat_con . " order by a.rec_date";















			break;















































			// COMMISION REPORTS















		case 31:















			$report = "Share Holder Investment Amount";















			if (isset($proj_code)) {
				$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);
				$proj_con = ' and a.proj_code=' . $proj_code;
			}































			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and a.opening_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}































			$sql = "SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`status`,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code`" . $date_con . $proj_con . " order by a.proj_code,a.agent_code";















			break;































		case 33:















			$report = "Running Share Holder Information";















			if (isset($proj_code)) {
				$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);
				$proj_con = ' and a.proj_code=' . $proj_code;
			}































			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and a.opening_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}































			$sql = "SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code` and a.status='Running' " . $date_con . $proj_con . " order by a.proj_code,a.agent_code";















			break;































		case 34:















			$report = "Withdrawn Share Holder Information";















			if (isset($proj_code)) {
				$project_name = find_a_field('tbl_project_info', 'proj_name', 'proj_code=' . $proj_code);
				$proj_con = ' and a.proj_code=' . $proj_code;
			}































			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and a.opening_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}































			$sql = "SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`status_date` as withdrawn_date,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code` and a.status='Withdrawn' " . $date_con . $proj_con . " order by a.proj_code,a.agent_code";















			break;































		case 35:















			$report = "Agent Information";































			$sql = "SELECT `emp_id`,`emp_name`,`emp_designation`,`emp_joining_date`,`emp_contact_no`, (select count(1) from tbl_director_info where agent_code=a.emp_id) as total_member, (select sum(invested) from tbl_director_info where agent_code=a.emp_id) as total_invested, (select sum(withdraw) from tbl_director_info where agent_code=a.emp_id)  as total_withdrawn FROM `tbl_employee_info` as a WHERE 1";















			break;































		case 101:















			$report = "Salary Bank Advice";































			break;































		case 102:















			$report = "Salary Cash Advice";































			break;
































































		case 1001:















			$report = "Distributor Dealer Information";















			if ($_POST['dealer_name_e'] != '')















				$con .= ' and a.dealer_name_e like "%' . $_POST['dealer_name_e'] . '%"';















			if ($_POST['dealer_code'] != '')















				$con .= ' and a.dealer_code = "' . $_POST['dealer_code'] . '"';































			if ($_POST['division_code'] != '')















				$con .= ' and a.division_code = "' . $_POST['division_code'] . '"';















			elseif ($_POST['district_code'] != '')















				$con .= ' and a.district_code = "' . $_POST['district_code'] . '"';















			elseif ($_POST['thana_code'] != '')















				$con .= ' and a.thana_code = "' . $_POST['thana_code'] . '"';















































			if ($_POST['region_code'] != '')















				$con .= ' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="' . $_POST['region_code'] . '") ';















			elseif ($_POST['zone_code'] != '')















				$con .= ' and a.area_code in (select AREA_CODE from area where ZONE_ID="' . $_POST['zone_code'] . '") ';















			elseif ($_POST['area_code'] != '')















				$con .= ' and a.area_code = "' . $_POST['area_code'] . '"';















































			if ($_POST['canceled'] != '')















				$con .= ' and a.canceled = "' . $_POST['canceled'] . '"';















			if ($_POST['depot'] != '')















				$con .= ' and a.depot = "' . $_POST['depot'] . '"';































			if ($_POST['product_group'] != '')















				$con .= ' and a.product_group = "' . $_POST['product_group'] . '"';















			if ($_POST['mobile_no'] != '')















				$con .= ' and a.mobile_no = "' . $_POST['mobile_no'] . '"';































			$sql = "select a.dealer_code as code,concat(a.account_code,'-') as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,b.AREA_NAME as area,z.ZONE_NAME as zone,r.BRANCH_NAME as region,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,area b,zon z,branch r,warehouse w















		 where z.region_id =r.BRANCH_ID and b.ZONE_ID =z.ZONE_CODE and a.dealer_type='Distributor' and a.area_code = b.AREA_CODE and w.warehouse_id=a.depot " . $con . " order by a.dealer_code desc";















			break;































		case 1002:















			$report = "Super Shop Dealer Information";















			if ($_POST['dealer_name_e'] != '')















				$con .= ' and a.dealer_name_e like "%' . $_POST['dealer_name_e'] . '%"';















			if ($_POST['dealer_code'] != '')















				$con .= ' and a.dealer_code = "' . $_POST['dealer_code'] . '"';































			if ($_POST['division_code'] != '')















				$con .= ' and a.division_code = "' . $_POST['division_code'] . '"';















			elseif ($_POST['district_code'] != '')















				$con .= ' and a.district_code = "' . $_POST['district_code'] . '"';















			elseif ($_POST['thana_code'] != '')















				$con .= ' and a.thana_code = "' . $_POST['thana_code'] . '"';















































			if ($_POST['region_code'] != '')















				$con .= ' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="' . $_POST['zone_code'] . '") ';















			elseif ($_POST['zone_code'] != '')















				$con .= ' and a.area_code in (select AREA_CODE from area where ZONE_ID="' . $_POST['zone_code'] . '") ';















			elseif ($_POST['area_code'] != '')















				$con .= ' and a.area_code = "' . $_POST['area_code'] . '"';















































			if ($_POST['canceled'] != '')















				$con .= ' and a.canceled = "' . $_POST['canceled'] . '"';















			if ($_POST['depot'] != '')















				$con .= ' and a.depot = "' . $_POST['depot'] . '"';































			if ($_POST['product_group'] != '')















				$con .= ' and a.product_group = "' . $_POST['product_group'] . '"';















			if ($_POST['depot'] != '')















				$con .= ' and a.mobile_no = "' . $_POST['mobile_no'] . '"';































































			$sql = "select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,warehouse w where a.dealer_type='SuperShop' and w.warehouse_id=a.depot " . $con . " order by a.dealer_code desc";































			break;















		case 1003:















			$report = "Corporate Dealer Information";















			if ($_POST['dealer_name_e'] != '')















				$con .= ' and a.dealer_name_e like "%' . $_POST['dealer_name_e'] . '%"';















			if ($_POST['dealer_code'] != '')















				$con .= ' and a.dealer_code = "' . $_POST['dealer_code'] . '"';































			if ($_POST['division_code'] != '')















				$con .= ' and a.division_code = "' . $_POST['division_code'] . '"';















			elseif ($_POST['district_code'] != '')















				$con .= ' and a.district_code = "' . $_POST['district_code'] . '"';















			elseif ($_POST['thana_code'] != '')















				$con .= ' and a.thana_code = "' . $_POST['thana_code'] . '"';















































			if ($_POST['region_code'] != '')















				$con .= ' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="' . $_POST['zone_code'] . '") ';















			elseif ($_POST['zone_code'] != '')















				$con .= ' and a.area_code in (select AREA_CODE from area where ZONE_ID="' . $_POST['zone_code'] . '") ';















			elseif ($_POST['area_code'] != '')















				$con .= ' and a.area_code = "' . $_POST['area_code'] . '"';















































			if ($_POST['canceled'] != '')















				$con .= ' and a.canceled = "' . $_POST['canceled'] . '"';















			if ($_POST['depot'] != '')















				$con .= ' and a.depot = "' . $_POST['depot'] . '"';































			if ($_POST['product_group'] != '')















				$con .= ' and a.product_group = "' . $_POST['product_group'] . '"';















			if ($_POST['depot'] != '')















				$con .= ' and a.mobile_no = "' . $_POST['mobile_no'] . '"';































			$sql = "select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,warehouse w where a.dealer_type='Corporate' and w.warehouse_id=a.depot " . $con . " order by a.dealer_code desc";















			break;































		case 1004:















			$report = "TradeFair Dealer Information";















			if ($_POST['dealer_name_e'] != '')















				$con .= ' and a.dealer_name_e like "%' . $_POST['dealer_name_e'] . '%"';















			if ($_POST['dealer_code'] != '')















				$con .= ' and a.dealer_code = "' . $_POST['dealer_code'] . '"';































			if ($_POST['division_code'] != '')















				$con .= ' and a.division_code = "' . $_POST['division_code'] . '"';















			elseif ($_POST['district_code'] != '')















				$con .= ' and a.district_code = "' . $_POST['district_code'] . '"';















			elseif ($_POST['thana_code'] != '')















				$con .= ' and a.thana_code = "' . $_POST['thana_code'] . '"';















































			if ($_POST['region_code'] != '')















				$con .= ' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="' . $_POST['zone_code'] . '") ';















			elseif ($_POST['zone_code'] != '')















				$con .= ' and a.area_code in (select AREA_CODE from area where ZONE_ID="' . $_POST['zone_code'] . '") ';















			elseif ($_POST['area_code'] != '')















				$con .= ' and a.area_code = "' . $_POST['area_code'] . '"';















































			if ($_POST['canceled'] != '')















				$con .= ' and a.canceled = "' . $_POST['canceled'] . '"';















			if ($_POST['depot'] != '')















				$con .= ' and a.depot = "' . $_POST['depot'] . '"';































			if ($_POST['product_group'] != '')















				$con .= ' and a.product_group = "' . $_POST['product_group'] . '"';















			if ($_POST['depot'] != '')















				$con .= ' and a.mobile_no = "' . $_POST['mobile_no'] . '"';































			$sql = "select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,warehouse w where a.dealer_type='TradeFair' and w.warehouse_id=a.depot " . $con . " order by a.dealer_code desc";















			break;















		case 1005:















			$report = "BulkBuyer Dealer Information";















			if ($_POST['dealer_name_e'] != '')















				$con .= ' and a.dealer_name_e like "%' . $_POST['dealer_name_e'] . '%"';















			if ($_POST['dealer_code'] != '')















				$con .= ' and a.dealer_code = "' . $_POST['dealer_code'] . '"';































			if ($_POST['division_code'] != '')















				$con .= ' and a.division_code = "' . $_POST['division_code'] . '"';















			elseif ($_POST['district_code'] != '')















				$con .= ' and a.district_code = "' . $_POST['district_code'] . '"';















			elseif ($_POST['thana_code'] != '')















				$con .= ' and a.thana_code = "' . $_POST['thana_code'] . '"';















































			if ($_POST['region_code'] != '')















				$con .= ' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="' . $_POST['zone_code'] . '") ';















			elseif ($_POST['zone_code'] != '')















				$con .= ' and a.area_code in (select AREA_CODE from area where ZONE_ID="' . $_POST['zone_code'] . '") ';















			elseif ($_POST['area_code'] != '')















				$con .= ' and a.area_code = "' . $_POST['area_code'] . '"';















































			if ($_POST['canceled'] != '')















				$con .= ' and a.canceled = "' . $_POST['canceled'] . '"';















			if ($_POST['depot'] != '')















				$con .= ' and a.depot = "' . $_POST['depot'] . '"';































			if ($_POST['product_group'] != '')















				$con .= ' and a.product_group = "' . $_POST['product_group'] . '"';















			if ($_POST['depot'] != '')















				$con .= ' and a.mobile_no = "' . $_POST['mobile_no'] . '"';































			$sql = "select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,warehouse w where a.dealer_type='BulkBuyer' and w.warehouse_id=a.depot and a.group_for='" . $_SESSION['user']['group'] . "' " . $con . " order by a.dealer_code desc";















			break;















































		case 7841:















			$report = "Summary of Salary ";















			break;















		case 7842:















			$report = "Summary of Salary ";















			break;
	}
}































?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>
<?= $report ?>
</title>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.js"></script>
<script type="text/javascript" src="../../js/paging.js"></script>
<script type="text/javascript" src="../../js/ddaccordion.js"></script>
<script type="text/javascript" src="../../js/js.js"></script>
<script type="text/javascript" src="../../js/pg.js"></script>
<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />
<style>
		/*.vertical-text div {















	transform: rotate(-90deg);















	transform-origin: left top 1;















	float: left;















	width: 2px;















	padding: 1px;















































}*/















		@media print {















			thead {
				display: table-header-group;
			}















		}















		.vertical-text div {































			float: left;















		}









		@page {

			margin-top: 2.5cm;

			margin-bottom: 2.5cm;

		}
	</style>
<script type="text/javascript">
		function hide()















		{















			document.getElementById('pr').style.display = 'none';















		}































		function update_value(id)















		{















			var mobile = document.getElementById('mobile#' + id).value;















			var sim = document.getElementById('sim#' + id).value;















			getData2('rd_issue_ajax.php', 'po' + id, id, mobile + '#>' + sim);















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















					if (i < from || i > to) rows[i].style.display = 'none';















					else rows[i].style.display = '';















				}















			}































			this.showPage = function(pageNumber) {















				if (!this.inited) {















					alert("not inited");















					return;















				}































				var oldPageAnchor = document.getElementById('pg' + this.currentPage);















				oldPageAnchor.className = 'pg-normal';































				this.currentPage = pageNumber;















				var newPageAnchor = document.getElementById('pg' + this.currentPage);















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















				if (!this.inited) {















					alert("not inited");















					return;















				}















				var element = document.getElementById(positionId);































				var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal">Prev</span>';















				for (var page = 1; page <= this.pages; page++)















					pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span>';















				pagerHtml += '<span onclick="' + pagerName + '.next();" class="pg-normal">Next</span>';































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















			if (XMLHttpRequestObject)















			{















				var obj = document.getElementById(divID);















				XMLHttpRequestObject.open("POST", dataSource);















				XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');































				XMLHttpRequestObject.onreadystatechange = function()















				{















					if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)















						obj.innerHTML = XMLHttpRequestObject.responseText;















				}















				XMLHttpRequestObject.send("ledger=" + data);















			}















		}















		function getData2(dataSource, divID, data1, data2)















		{















			if (XMLHttpRequestObject)















			{















				var obj = document.getElementById(divID);















				XMLHttpRequestObject.open("POST", dataSource);















				XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
































				XMLHttpRequestObject.onreadystatechange = function()















				{















					if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)















						obj.innerHTML = XMLHttpRequestObject.responseText;















				}















				XMLHttpRequestObject.send("data=" + data1 + "##" + data2);































			}















		}















		function getflatData3()















		{















			var b = document.getElementById('category_to').value;















			var a = document.getElementById('proj_code_to').value;















			$.ajax({















				url: '../../common/flat_option_new3.php',















				data: "a=" + a + "&b=" + b,















				success: function(data) {















					$('#fid3').html(data);















				}















			});















		}















		function getflatData2()















		{















			var b = document.getElementById('category_from').value;















			var a = document.getElementById('proj_code_from').value;















			$.ajax({















				url: '../../common/flat_option_new2.php',















				data: "a=" + a + "&b=" + b,















				success: function(data) {















					$('#fid2').html(data);















				}















			});















		}
	</script>
</head>
<body>
<form action="?" method="post">
  <div align="center" id="pr">
    <input type="button" value="Print" onClick="hide();window.print();" />
  </div>
  <!--<div class="main">-->
  <?















		//echo $sql;















		$str 	.= '<div class="header">';















		if ($_POST['PBI_ORG'] != '')















			$str 	.= '<h2 style="font-size:24px;">' . find_a_field('user_group', 'group_name', 'id=' . $_POST['PBI_ORG']) . '</h2>';















		if (isset($report))















			$str 	.= '<h2>' . $report . '</h2>';















		if ($_POST['mon'] != '') {















			if ($_POST['report'] == 777 || $_POST['report'] == 778 || $_POST['report'] == 64) {















				if ($_POST['bonus_type'] == 1) {















					$str 	.= '<h2>Bonus of Eid-Ul-Fitre ' . date('Y', mktime(1, 1, 1, $_POST['mon'], 1, $_POST['year'])) . '</h2>';
				} else {















					$str 	.= '<h2>Bonus of Eid-Ul-Adha ' . date('Y', mktime(1, 1, 1, $_POST['mon'], 1, $_POST['year'])) . '</h2>';
				}
			} else {















				if ($_POST['report'] != 6655 && $_POST['report'] != 61) {















					$str 	.= '<h2>Report of Month: ' . date('F-Y', mktime(1, 1, 1, $_POST['mon'], 1, $_POST['year'])) . '</h2>';
				} elseif ($_POST['report'] == 61) {



					$str 	.= '<h2>Report of Year: ' . date('Y', mktime(1, 1, 1, $_POST['mon'], 1, $_POST['year'])) . '</h2>';
				}
			}
		}































		if ($_POST['department'] != '' || $_POST['JOB_LOCATION'] != '')















			$str 	.= '<h2>';















		if ($_POST['JOB_LOCATION'] != '')















			$str 	.= 'Location: ' . find_a_field('job_location_type', 'job_location_name', 'id="' . $_POST['JOB_LOCATION'] . '"');















		$str 	.= '<br>';









		$str   .= 'Date: ' . $_POST['fdate'] . ' To ' . $_POST['tdate'] . '';















		if ($_POST['job_status'] != '')















			$str 	.= ' Job Status : ' . $_POST['job_status'];















		$str 	.= '<br>';















		if ($_POST['department'] != '')















			$str 	.= 'Department : ' . find_a_field('department', 'DEPT_DESC', 'DEPT_ID="' . $_POST['department'] . '"') . '&nbsp;&nbsp;&nbsp;::';















		$str 	.= '&nbsp;&nbsp;&nbsp;';















		if ($_POST['designation'] != '')















			$str 	.= 'Designation : ' . find_a_field('designation', 'DESG_DESC', 'DESG_ID="' . $_POST['designation'] . '"') . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';















		$str 	.= '<br>';















		if ($_POST['ijda'] != '' && $_POST['ijdb'] != '')















			$str 	.= 'Joining Date Between : ' . $_POST['ijda'] . ' To ' . $_POST['ijdb'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';















		if ($_POST['EMPLOYMENT_TYPE'] != '')















			$str 	.= 'EMPLOYMENT TYPE : ' . $_POST['EMPLOYMENT_TYPE'];































		if ($_POST['department'] != '' || $_POST['JOB_LOCATION'] != '')















			$str 	.= '</h2>';















		$str 	.= '</div>';















		//if(isset($_SESSION['company_logo']))















		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';















		$str 	.= '<div class="left">';















		if (($_POST['PBI_GROUP'] != ''))















			$str 	.= '<p>Product Group: ' . $_POST['PBI_GROUP'] . '</p>';















		if (($_POST['branch'] > 0))















			$str 	.= '<p>Region Name: ' . find_a_field('branch', 'BRANCH_NAME', 'BRANCH_ID="' . $_POST['branch'] . '"') . '</p>';















		if (($_POST['area_code'] > 0))















			$str 	.= '<p>Area Name: ' . find_a_field('area', 'AREA_NAME', 'AREA_CODE="' . $_POST['area_code'] . '"') . '</p>';















		if (($_POST['zone_code'] > 0))















			$str 	.= '<p>Zone Name: ' . find_a_field('zon', 'ZONE_NAME', 'ZONE_CODE="' . $_POST['zone_code'] . '"') . '</p>';















		if (($_POST['region_code'] > 0))















			$str 	.= '<p>Region Name: ' . find_a_field('branch', 'BRANCH_NAME', 'BRANCH_ID="' . $_POST['region_code'] . '"') . '</p>';















		if (isset($project_name))















			$str 	.= '<p>Project Name: ' . $project_name . '</p>';































		if (isset($allotment_no))















			$str 	.= '<p>Allotment No.: ' . $allotment_no . '</p>';















		$str 	.= '</div>';















		$str 	.= '<div class="right">';















		if (isset($client_name))















			$str 	.= '<p>Client Name: ' . $client_name . '</p>';















		if (isset($start_date))















			$str 	.= '<p>Schedule Duration: ' . $start_date . ' to ' . $end_date . '</p>';















		//$str 	.= '</div><span>Bonus Cut-Off Date:'.find_a_field('salary_bonus','cut_off_date','bonus_type='.$_POST['bonus_type'].' and year='.$_POST['year']).'</span><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';















		$str 	.= '</div>';















		$str 	.= '<div class="date">Reporting Time: ' . date("h:i A d-m-Y") . '</div>';































		if ($_POST['report'] == 7) // payroll information















		{
































			$sql1 = "select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,a.PBI_GROUP,







(select pbi_held_up from salary_attendence where PBI_ID=a.PBI_ID order by id desc limit 1) as held,







(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,







(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,







(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,







a.PBI_JOB_STATUS as job_status







from personnel_basic_info a where 1 " . $con;







			$query = db_query($sql1);







		?>
  <table border="0">
    <thead>
      <tr>
        <td style="border:0px;" colspan="13"><?= $str ?></td>
      </tr>
      <tr>
        <th>S/L</th>
        <th>CODE</th>
        <th>Name</th>
        <th>Desg</th>
        <th>Dept</th>
        <th>GRP</th>
        <th>Region</th>
        <th>Zone</th>
        <th>Area</th>
        <th>Held-up</th>
        <th>Status</th>
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
      </tr>
    </thead>
    <tbody>
      <?















					while ($datas = mysqli_fetch_row($query)) {
						$s++;















						$sqld = 'select * from salary_info where PBI_ID=' . $datas[0];















						$data = mysqli_fetch_object(db_query($sqld));















					?>
      <tr>
        <td><?= $s ?></td>
        <td><?= $datas[0] ?></td>
        <td><?= $datas[1] ?></td>
        <td><?= $datas[2] ?></td>
        <td><?= $datas[3] ?></td>
        <td><?= $datas[4] ?></td>
        <td><?= $datas[8] ?></td>
        <td><?= $datas[7] ?></td>
        <td><?= $datas[6] ?></td>
        <td><?= ($datas[5] > 0) ? 'Y' : 'N'; ?></td>
        <td><?= $datas[9] ?></td>
        <td><?= $data->salary_type ?></td>
        <td><?= $data->basic_salary ?></td>
        <td><?= $data->consolidated_salary ?></td>
        <td style="text-align:right"><?= $data->special_allowance ?></td>
        <td style="text-align:right"><?= $data->house_rent ?></td>
        <td><?= $data->ta ?></td>
        <td><?= $data->food_allowance ?></td>
        <td><?= $data->medical_allowance ?>
          &nbsp;</td>
        <td><?= $data->cash_bank ?>
          &nbsp;</td>
        <td><?= $data->cash ?></td>
        <td><?= $data->branch_info ?></td>
        <td><?= $data->security_amount ?></td>
      </tr>
      <?















					}















					?>
    </tbody>
  </table>
  <?















		}































		if ($_POST['report'] == 770) {















			$sqll = "select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department from















personnel_basic_info a, salary_info s where a.PBI_ID=s.PBI_ID  " . $con . " order by (s.consolidated_salary+s.basic_salary) desc";















			$query = db_query($sqll);















		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <td style="border:0px;" colspan="23"><?= $str ?></td>
      </tr>
      <tr>
        <th rowspan="2">S/L</th>
        <th rowspan="2">CODE</th>
        <th rowspan="2">Name</th>
        <th rowspan="2">Desg</th>
        <th rowspan="2">Group</th>
        <th rowspan="2">Joining Date </th>
        <th rowspan="2">DBBL Acc. </th>
        <th rowspan="2">Working Place </th>
        <th rowspan="2">Sales Point </th>
        <th colspan="5" align="center"><?php echo date('F', mktime(0, 0, 0, $_POST['mon'], 01, $_POST['year'])) ?>'<?php echo date('y', mktime(0, 0, 0, $_POST['mon'], 01, $_POST['year'])) ?></th>
        <th colspan="2">Present Gross Amount </th>
        <th colspan="2">Actual Amount </th>
        <th rowspan="2">Special Commission </th>
        <th rowspan="2">Mobile Allowance </th>
        <th rowspan="2">Advance/Bill Payment </th>
        <th rowspan="2">H/Up or Advance Salary </th>
        <th rowspan="2">Co-OP Fund Inst. </th>
        <th rowspan="2">M/cycle Install </th>
        <th rowspan="2">Mobile Bill <?php echo date('M', mktime(0, 0, 0, $_POST['mon'], 01, $_POST['year'])) ?>'<?php echo date('y', mktime(0, 0, 0, $_POST['mon'], 01, $_POST['year'])) ?> </th>
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















					while ($datas = mysqli_fetch_row($query)) {
						$s++;















						$sqld = 'select * from salary_info where PBI_ID=' . $datas[0];















						$data = mysqli_fetch_object(db_query($sqld));















					?>
      <tr>
        <td><?= $s ?></td>
        <td><?= $datas[0] ?></td>
        <td><?= $datas[1] ?></td>
        <td><?= $datas[2] ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?= $datas[3] ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?= $data->salary_type ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?= $data->basic_salary ?></td>
        <td><?= $data->consolidated_salary ?></td>
        <td style="text-align:right"><?= $data->special_allowance ?></td>
        <td style="text-align:right"><?= $data->house_rent ?></td>
        <td><?= $data->ta ?></td>
        <td><?= $data->food_allowance ?></td>
        <td><?= $data->medical_allowance ?>
          &nbsp;</td>
        <td><?= $data->cash_bank ?>
          &nbsp;</td>
        <td><?= $data->cash ?></td>
        <td><?= $data->branch_info ?></td>
        <td><?= $data->security_amount ?></td>
        <td>&nbsp;</td>
      </tr>
      <?















					}















					?>
    </tbody>
  </table>
  <?















		}































		if ($_POST['report'] == 77) {















		?>
  <table border="0" cellpadding="2" cellspacing="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="37"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">CODE</th>
        <th rowspan="3"> <div>Full Name</div></th>
        <th rowspan="3"><img src="images/desgnation.jpg" /></th>
        <th rowspan="3"><img src="images/joining_date.jpg" alt="" /></th>
        <th rowspan="3">Bank AC#</th>
        <th rowspan="3">Work Place</th>
        <th colspan="6"> <div>Monthly Attendence Record</div></th>
        <th colspan="3">Basic Information </th>
        <th colspan="5"> <div>Accrued Salary and Allowance (At Actual) Taka </div></th>
        <th colspan="6"> <div>Deduction </div></th>
        <th colspan="6"> <div>Payable Amount (Taka) </div></th>
        <th colspan="3"> <div>View Only </div></th>
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















					$sqld = 'select















t.basic_salary actual_basic_salary,















t.special_allowance actual_special_allawance,















t.*,a.PBI_ID,a.PBI_NAME,d.DESG_DESC PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ,  t.pbi_held_up held_up_status,s.cash_bank,s.cash































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID ' . $con . '















order by a.PBI_ID';















					$queryd = db_query($sqld);















					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $data->PBI_ID ?></td>
        <td><?= $data->PBI_NAME ?></td>
        <td><?= $data->PBI_DESIGNATION ?></td>
        <td><?= date('d-m-Y', strtotime($data->PBI_DOJ)); ?></td>
        <td><?= $data->cash ?></td>
        <td><? $res = "select concat(a.AREA_NAME,'-',d.dealer_code,'-',d.dealer_name_e) dealer from area a, dealer_info d where a.AREA_CODE=d.area_code and d.dealer_code=" . $data->dealer_code;















								$resq = @db_query($res);















								$res_data = @mysqli_fetch_object($resq);
								echo $res_data->dealer; ?></td>
        <td><?= $data->pre ?></td>
        <td><?= $data->od ?></td>
        <td><?= $data->lv ?></td>
        <td><?= $data->lwp ?></td>
        <td><?= $data->ab ?></td>
        <td><?= $data->pay ?></td>
        <td><?= number_format($data->actual_basic_salary) ?>
          <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary; ?></td>
        <td><?= number_format($data->spl_alw_data) ?>
          <? $total_spl_alw_data = $total_spl_alw_data + $data->spl_alw_data; ?></td>
        <td><?= number_format($data->ta_da_data) ?>
          <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data; ?></td>
        <td><?= number_format($data->basic_salary_payable) ?>
          <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable; ?></td>
        <td><?= number_format($data->actual_special_allawance) ?>
          <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance; ?></td>
        <td><?= number_format($data->ta_da) ?>
          <? $total_ta_da = $total_ta_da + $data->ta_da; ?></td>
        <td><?= number_format($data->benefits) ?>
          <? $total_benefits = $total_benefits + $data->benefits; ?></td>
        <td><?= number_format($data->other_benefits) ?>
          <? $total_other_benefits = $total_other_benefits + $data->other_benefits; ?></td>
        <td><?= number_format($data->income_tax) ?>
          <? $total_income_tax = $total_income_tax + $data->income_tax; ?></td>
        <td><?= number_format(($data->advance_install + $data->other_install)) ?>
          <? $total_advance_install = $total_advance_install + ($data->advance_install + $data->other_install); ?></td>
        <td><?= number_format($data->cooperative_share) ?>
          <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share; ?></td>
        <td><?= number_format($data->motorcycle_install) ?>
          <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install; ?></td>
        <td><?= number_format($data->deduction) ?>
          <? $total_deduction = $total_deduction + $data->deduction; ?></td>
        <td><?= number_format($data->administrative_deduction) ?>
          <? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction; ?></td>
        <td><? if ($data->held_up_status == '1') {
									echo $data->total_payable;
									$total_held_up = $total_held_up + $data->total_payable;
								} ?></td>
        <td><? if ($data->held_up_status == '0') {
									$cash_payment = $data->total_payable - $data->bank_paid;
									echo number_format($cash_payment);
									$total_cash_payment = $total_cash_payment + $cash_payment;
								} ?></td>
        <td><? if ($data->held_up_status == '0') {
									if ($data->bank_name == 'DBBL') {
										echo number_format($data->bank_paid);
										$total_bank_payment_dbbl = $total_bank_payment_dbbl + $data->bank_paid;
									}
								} ?></td>
        <td><? if ($data->held_up_status == '0') {
									if ($data->bank_name == 'ROCKET') {
										echo number_format($data->bank_paid);
										$total_bank_payment_rocket = $total_bank_payment_rocket + $data->bank_paid;
									}
								} ?></td>
        <td><? if ($data->held_up_status == '0') {
									if ($data->bank_name == 'IBBL') {
										echo number_format($data->bank_paid);
										$total_bank_payment_ibbl = $total_bank_payment_ibbl + $data->bank_paid;
									}
								} ?></td>
        <td><span style="text-align:right; font-weight:bold;">
          <?php if ($data->held_up_status == '0') {
										echo number_format($data->total_payable);
										$total_cash = $total_cash + $data->total_payable;
									} ?>
          </span></td>
        <td><?php















								if ($_POST['mon'] == 1) {
									$p_mon = 12;
								} else {
									$p_mon = ($_POST['mon'] - 1);
								}















								if ($_POST['mon'] == 1) {
									$p_yr = ($_POST['year'] - 1);
								} else {
									$p_yr = $_POST['year'];
								}















								echo $pre_salry = find_a_field('salary_attendence', 'total_payable', 'PBI_ID="' . $data->PBI_ID . '" and mon="' . $p_mon . '" and year="' . $p_yr . '" ');















								?></td>
        <td><? echo $differ_last = ($data->total_payable - $pre_salry);
								$differ_last_all = $differ_last_all + $differ_last; ?></td>
        <td><span style="text-align:right">
          <?= (int)$data->absent_deduction ?>
          </span></td>
        <td style="color:#FF0000; font-weight:bold"><?= ($data->held_up_status == '1') ? 'Held-Up' : '' ?></td>
      </tr>
      <?
















					}















					?>
      <tr>
        <td colspan="13"><?= convertNumberMhafuz($total_cash); ?></td>
        <td><strong>
          <?= $total_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_spl_alw_data; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)$total_basic_salary_payable; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da; ?>
          </strong></td>
        <td><strong>
          <?= $total_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_other_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_income_tax; ?>
          </strong></td>
        <td><strong>
          <?= $total_advance_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_cooperative_share; ?>
          </strong></td>
        <td><strong>
          <?= $total_motorcycle_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_deduction; ?>
          </strong></td>
        <td><strong>
          <?= $total_administrative_deduction; ?>
          </strong></td>
        <td><?= $total_held_up ?></td>
        <td><strong>
          <?= $total_cash_payment ?>
          </strong></td>
        <td><? echo (int)$total_bank_payment_dbbl; ?></td>
        <td><? echo (int)$total_bank_payment_rocket; ?></td>
        <td><? echo (int)$total_bank_payment_ibbl; ?></td>
        <td><strong>
          <?= $total_cash ?>
          </strong></td>
        <td>&nbsp;</td>
        <td><strong>
          <?= $differ_last_all ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 781) {















		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="7"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>CODE</th>
        <th>Full Name</th>
        <th>Designation</th>
        <th>Group</th>
        <th><?= $_POST['cash_bank'] ?>
          AC#</th>
        <th>Transfer to
          <?= $_POST['cash_bank'] ?></th>
      </tr>
    </thead>
    <tbody>
      <?















					$bank = $_POST['cash_bank'];















					$sqld = 'select















s.basic_salary actual_basic_salary,















s.special_allowance actual_special_allawance,















t.*,a.PBI_ID,a.PBI_NAME,a.PBI_GROUP,d.DESG_SHORT_NAME PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ,















t.pbi_held_up held_up_status,s.cash_bank,s.cash































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s















where t.pbi_held_up=0 and s.cash_bank="' . $bank . '" and d.DESG_ID=t.pbi_designation















and t.mon=' . $_POST['mon'] . '















and t.year=' . $_POST['year'] . '















and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID ' . $con . '















order by (t.consolidated_salary+t.basic_salary) desc';















































					$queryd = db_query($sqld);















					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $data->PBI_ID ?></td>
        <td><?= $data->PBI_NAME ?></td>
        <td><?= $data->PBI_DESIGNATION ?></td>
        <td><?= $data->PBI_GROUP ?></td>
        <td><?= $data->cash ?></td>
        <td><? if ($data->held_up_status == '0') {
									if ($data->cash_bank == $bank) {
										echo number_format($data->bank_paid);















										$total_bank_payment_dbbl = $total_bank_payment_dbbl + $data->bank_paid;
									}
								} ?></td>
      </tr>
      <?















					}















					?>
      <tr>
        <td colspan="6"><?= convertNumberMhafuz($total_bank_payment_dbbl); ?></td>
        <td><? echo (int)$total_bank_payment_dbbl; ?></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		}































		if ($_POST['report'] == 61) {







			$sdate = strtotime($_REQUEST['fdate']);

			$edate = strtotime($_REQUEST['tdate']);



			$s_date = date("Y-m-01", $sdate);

			$m_date = $new_date = date("Y-m-15", $sdate);

			$e_date = date("Y-m-t", $edate);



			$start_date = strtotime(date("Y-m-01 00:00:00", strtotime($s_date)));

			$end_date = strtotime(date("Y-m-t 23:59:59", strtotime($e_date)));

			for ($c = 1; $c < 13; $c++) {



				if ($new_date > $e_date) {
					$c = $c - 1;
					break;
				} else {

					$st_date[$c] = date("Y-m-01", (strtotime($new_date)));

					$en_date[$c] = date("Y-m-t", (strtotime($new_date)));

					$priod[$c] = date("Ym", (strtotime($new_date)));

					$period_name[$c] = date("M, Y", (strtotime($new_date)));
				}

				$new_date = date("Y-m-d", (strtotime($new_date) + 2592000));
			}





			$full_sql = "select concat(date_format(a.att_date,'%Y%m')) as month ,a.emp_id,sum(a.leave_duration) as full 
			from hrm_att_summary a,hrm_leave_info l 
			where a.leave_id>0 and l.id=a.leave_id and l.type !='Adjust Leave' and 
			l.half_or_full='Full' group by a.emp_id,concat(date_format(a.att_date,'%Y%m'))";



			$full_query = db_query($full_sql);



			while ($full_data = mysqli_fetch_object($full_query)) {

				$full_leave[$full_data->emp_id][$full_data->month] = $full_data->full;
			}



			$half_sql = "select concat(date_format(a.att_date,'%Y%m')) as month,a.emp_id,sum(a.leave_duration) as half from hrm_att_summary a,hrm_leave_info l where a.leave_id>0 and l.id=a.leave_id and l.type !='Adjust Leave' and l.half_or_full='Half' group by a.emp_id,concat(date_format(a.att_date,'%Y%m'))";



			$half_query = db_query($half_sql);



			while ($half_data = mysqli_fetch_object($half_query)) {

				$half_leave[$half_data->emp_id][$half_data->month] = $half_data->half;
			}





			$adjust_sql = "select concat(date_format(a.att_date,'%Y%m')) as month,a.emp_id,sum(a.leave_duration) as full from hrm_att_summary a,hrm_leave_info l where a.leave_id>0 and l.id=a.leave_id and l.type ='Adjust Leave'  group by a.emp_id,concat(date_format(a.att_date,'%Y%m'))";



			$adjust_query = db_query($adjust_sql);



			while ($adjust_data = mysqli_fetch_object($adjust_query)) {

				$adjust_leave[$adjust_data->emp_id][$adjust_data->month] = $adjust_data->full;
			}







			$late_sql = " select emp_id,sum(final_late_min) as late_min,concat(date_format(att_date,'%Y%m')) as month from hrm_att_summary where grace_no=0 group by emp_id,concat(date_format(att_date,'%Y%m'))";



			$late_query = db_query($late_sql);



			while ($late_data = mysqli_fetch_object($late_query)) {



				$late_leave[$late_data->emp_id][$late_data->month] = $late_data->late_min;
			}









			$lwp_sql = "select concat(date_format(a.att_date,'%Y%m')) as month,a.emp_id,sum(a.leave_duration) as full from hrm_att_summary a,hrm_leave_info l where a.leave_id>0 and l.id=a.leave_id and l.type ='LWP (Leave Without Pay)'  group by a.emp_id,concat(date_format(a.att_date,'%Y%m'))";



			$lwp_query = db_query($lwp_sql);



			while ($lwp_data = mysqli_fetch_object($lwp_query)) {

				$lwp_leave[$lwp_data->emp_id][$lwp_data->month] = $lwp_data->full;
			}









		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="<?= 6 + ($c * 5) ?>"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">EMP_ID</th>
        <th rowspan="3">Full Name</th>
        <th rowspan="3">Department</th>
        <th colspan="<?= $c * 5 ?>"> <div align="center">Month</div></th>
        <th rowspan="3">Total Leave</th>
        <th rowspan="3">Leave Balance</th>
      </tr>
      <tr>
        <? for ($p = 1; $p <= $c; $p++) { ?>
        <td colspan="5"><?= $period_name[$p] ?></td>
        <? } ?>
      </tr>
      <tr>
        <? for ($p = 1; $p <= $c; $p++) { ?>
        <td>Half Day</td>
        <td>Full Day</td>
        <td>Adjust Leave</td>
        <td>Leave For Late</td>
        <td>Total Leave</td>
        <? } ?>
      </tr>
    </thead>
    <tbody>
      <?







					if ($_POST['year'] > 0) {













						//$mon = $_POST['mon'];





						$year = $_POST['year'];



						$totalDays = date('t', mktime(0, 0, 0, $mon, 01, $year));



						$startDate = $year . '-01-01';



						$endDate = $year . '-12-31';

						$leave_sql = "SELECT a.PBI_ID,a.PBI_CODE,a.PBI_NAME as Employee_Name,a.EMPLOYMENT_TYPE,(select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as department,a.PBI_DOC as confirm_date  FROM personnel_basic_info a where 1 " . $con . " order by a.DEPT_ID";



						$leave_query = db_query($leave_sql);



						while ($data_leave = mysqli_fetch_object($leave_query)) {



							$total_late_min = find_a_field('hrm_att_summary', 'sum(final_late_min)', 'emp_id="' . $data_leave->PBI_ID . '" and att_date between "' . $startDate . '" and "' . $endDate . '" and grace_no=0 ');

							$leave_for_late = (int)($total_late_min / 20);

							$leave_late = $leave_for_late * (0.5);



							$confirm_year = date('Y', strtotime($data_leave->confirm_date));



							if (($year == $confirm_year) && $data_leave->EMPLOYMENT_TYPE == 'Permanent') {



								$date1 = strtotime($year . '-12-31');

								$date2 = strtotime($data_leave->confirm_date);

								$b_mon = floor(($date1 - $date2) / 60 / 60 / 24 / 30);



								$leave_avail = $b_mon * 2.33;

								$num = explode('.', $leave_avail);

								if ($num[1] > 50) {



									$leave_count = $num[0] . '.5';
								} else {

									$leave_count = $num[0] . '.0';
								}
							} elseif (($year != $confirm_year) && $data_leave->EMPLOYMENT_TYPE == 'Permanent') {

								$leave_count = 24;
							} else {

								$leave_count = 24;
							}







					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $data_leave->PBI_CODE ?></td>
        <td><?= $data_leave->Employee_Name ?></td>
        <td><?= $data_leave->department ?></td>
        <? for ($p = 1; $p <= $c; $p++) { ?>
        <td><?= $h = $half_leave[$data_leave->PBI_ID][$priod[$p]]; ?></td>
        <td><?= $f = $full_leave[$data_leave->PBI_ID][$priod[$p]]; ?></td>
        <td><?= $a = $adjust_leave[$data_leave->PBI_ID][$priod[$p]]; ?></td>
        <? $leave_for_late = (int)($late_leave[$data_leave->PBI_ID][$priod[$p]] / 20);



									$leave_late = $leave_for_late * (0.5);





									$mon_leave = $h + $f + $leave_late;





									$lwp = $lwp_leave[$data_leave->PBI_ID][$priod[$p]];





									$total_lwp[$data_leave->PBI_ID] += $lwp;











									?>
        <td <? if ($leave_late > 0) echo 'style="color:red"'; ?>><?= $leave_late; ?></td>
        <td style="background-color: aquamarine"><?= $mon_leave;
																				$all_month[$data_leave->PBI_ID] += $mon_leave;  ?></td>
        <? } ?>
        <td><?= $all_month[$data_leave->PBI_ID] ?></td>
        <td><?= (($leave_count - $all_month[$data_leave->PBI_ID]) + $total_lwp[$data_leave->PBI_ID]); ?></td>
      </tr>
      <? }
					} ?>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 611111) {



		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>EMP_ID</th>
        <th>Full Name</th>
        <th>Dept.</th>
        <th>Designation</th>
        <th>Leave Start Date</th>
        <th>Leave End Date</th>
        <th> <div align="center">Half Or Full</div></th>
        <th> <div align="center">Leave Type</div></th>
        <th> <div align="center">Leave Days</div></th>
        <th> <div align="center">Entry At</div></th>
        <th> <div align="center">Reason</div></th>
      </tr>
    </thead>
    <tbody>
      <?

					if ($_POST['PBI_ID'] != '') {
						$pbi_con = " and a.PBI_ID='" . $_POST['PBI_ID'] . "' ";
					}

					if ($_POST['PBI_IDD'] != '') {
						$pbi_con = " and a.PBI_ID='" . $_POST['PBI_IDD'] . "' ";
					}

					if ($_POST['JOB_LOC_ID'] != '') {
						$job_loc_con = " and a.JOB_LOC_ID='" . $_POST['JOB_LOC_ID'] . "' ";
					}





					if ($_POST['year'] != '') {


						$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';
						$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
					}


					$date_con = " and l.s_date>='" . $_POST['fdate'] . "' and l.e_date<='" . $_POST['tdate'] . "' ";


					$leave_sql = "SELECT l.*,a.PBI_CODE,a.PBI_ID,a.PBI_NAME as Employee_Name,(select DESG_DESC from designation where DESG_ID=a.DESG_ID) as designation,
(select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as dept

FROM hrm_leave_info l, personnel_basic_info a

where a.PBI_ID=l.PBI_ID  " . $con . $pbi_con . $date_con . $job_loc_con . " ORDER BY  a.PBI_ID ASC ";




					$leave_query = db_query($leave_sql);
					while ($data_leave = mysqli_fetch_object($leave_query)) {


					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $data_leave->PBI_CODE ?></td>
        <td><?= $data_leave->Employee_Name ?></td>
        <td><?= $data_leave->dept ?></td>
        <td><?= $data_leave->designation ?></td>
        <td><?= $data_leave->s_date ?></td>
        <td><?= $data_leave->e_date ?></td>
        <td><?= $data_leave->half_or_full ?></td>
        <td><?= find_a_field('hrm_leave_type', 'leave_type_name', 'id=' . $data_leave->type); ?></td>
        <td><?= $data_leave->total_days ?></td>
        <td><?= $data_leave->leave_entry_at ?></td>
        <td><?= $data_leave->reason ?></td>
      </tr>
      <? $grand_tot_leave = $grand_tot_leave + $data_leave->total_days;
					}  ?>
      <tr>
        <td colspan="9"><div align="right"><b> Total Days</b></div></td>
        <td><b>
          <?= $grand_tot_leave ?>
          </b></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?


		}


		//new section start

		if ($_POST['report'] == 22) {
			$dateObj   = DateTime::createFromFormat('!m', $_POST['mon']);

			$monthName = $dateObj->format('F');

			$pre_mon = $_POST['mon'] - 1;

			if ($_POST['mon'] != '' && $_POST['year'] != '')
				$start = '' . $_POST['year'] . '-' . $pre_mon . '-26';
			$mon_days = date('t', strtotime($start));
			$end = '' . $_POST['year'] . '-' . $_POST['mon'] . '-25';
			//$att_con .= ' and d.att_date between "'.$start.'" and "'.$end.'"';

			//$att_con .= ' and d.att_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



			//if($_POST['mon']!='')
			// $att_con = ' and d.mon="'.$_POST['mon'].'"';
			//if($_POST['year']!='')
			//$att_con .= ' and d.year="'.$_POST['year'].'"';

			if ($_POST['department'] != '')
				$b_con .= ' and p.PBI_DEPARTMENT="' . $_POST['department'] . '"';
			if ($_POST['JOB_LOCATION'] != '')
				$b_con .= ' and p.JOB_LOCATION="' . $_POST['JOB_LOCATION'] . '"';
			if ($_POST['PBI_ID'] != '')
				$att_con .= ' and d.emp_id="' . $_POST['PBI_ID'] . '"';



			$sdate = $_POST['year'] . '-' . $_POST['mon'] . '-01';
			$edate = $_POST['year'] . '-' . $_POST['mon'] . '-31';




		?>
  <table style="width: auto; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">
    <tr></tr>
    <tr>
      <td style="border:0px solid white;"><?= $str ?></td>
    </tr>
  </table>
  <table style="width: 80%; margin: 0 auto;text-align:center;" cellpadding="0" cellspacing="0" class="oe_list_content">
    <thead>
      <tr class="oe_list_header_columns" style=" text-align:center; font-size:12px;" align="center">
        <th>S/L</th>
        <th> <div align="center">Employee ID</div></th>
        <th> <div align="center">Employee Name</div></th>
        <th align="center"> <div align="center">Designation</div></th>
        <th align="center"> <div align="center">Department</div></th>
        <th align="center"> <div align="center">Job Location/Project</div></th>
        <th> <div align="center">Absent in days</div></th>
      </tr>
    </thead>
    <tbody>
      <?




					if ($_POST['year'] != "" && $_POST['mon'] != "") {

						$join_con = ' and j.ESSENTIAL_RESIG_DATE between "' . $_POST['year'] . '-' . $_POST['mon'] . '-1" and "' . $_POST['year'] . '-' . $_POST['mon'] . '-31"';
					}

					$all = 'select p.PBI_NAME,p.PBI_ID,p.PBI_CODE,desg.DESG_DESC as designation,p.PBI_DOJ, dept.DEPT_DESC as department
from personnel_basic_info p, designation desg, department dept,essential_info e
where p.PBI_ID=e.PBI_ID and p.DESG_ID=desg.DESG_ID and p.DEPT_ID=dept.DEPT_ID   
and p.PBI_JOB_STATUS="In Service" ' . $b_con . ' order by p.PBI_ID';




					$att_query = db_query($all);


					$s3 = 1;


					//DYNAMIC DAYS COUNT



					$start = strtotime($_POST['fdate']);
					$end = strtotime($_POST['tdate']);
					$days = ceil(abs($start - $end) / 86400);

					//$days=cal_days_in_month(CAL_GREGORIAN,$_POST['mon'],$_POST['year']);



					while ($basic_data = mysqli_fetch_object($att_query)) {

						for ($i = 1; $i <= $days; $i++) {

							$all_date = '' . $_POST['year'] . '-' . $_POST['mon'] . '-' . $i . '';




							$att_sql = 'select DATE_FORMAT(d.att_date,"%d-%b-%Y") as xdate,d.in_time,d.out_time,d.emp_id,d.final_late_status,d.leave_id,d.iom_sl_no,d.iom_start_time
  from
hrm_att_summary d where d.att_date="' . $all_date . '" and d.emp_id="' . $basic_data->PBI_ID . '" ' . $att_con . ' order by d.emp_id,d.att_date';




							$nquery = db_query($att_sql);
							$att_data = mysqli_fetch_object($nquery);
							$leave_info = find_a_field('hrm_leave_info', 'type', 'id="' . $att_data->leave_id . '"');
							$leave_name = find_a_field('hrm_leave_type', 'leave_short_name', 'id="' . $leave_info . '"');
							$f = date('D', strtotime($all_date));
							$att_status = find_a_field('hrm_attdump', 'attendence', 'bizid="' . $basic_data->PBI_ID . '" and xdate="' . $all_date . '"');
							$holiday = find_a_field('salary_holy_day', 'reason', 'holy_day="' . $all_date . '"');
							//late punch
							/*if($att_data->in_time>0){
$late_punch = date('H:i:s', strtotime($att_data->in_time));
}else{
$late_punch =  '';
}*/


							if ($att_data->in_time > 0) {
								$late_punch = date('h:i:s', strtotime($att_data->in_time));
							} else {
								$late_punch =  '';
							}

							$iom_in_time = date('h:i:s', strtotime($att_data->iom_start_time));



							if ($att_data->in_time != '0000-00-00 00:00:00' && $att_data->in_time != '') {
							} elseif ($att_data->in_time != '' && $att_data->leave_id > 0) {
							} elseif ($f == 'Fri') {
							} elseif ($holiday != '') {
							} elseif ($att_data->leave_id > 0) {
							} else {


								/*  if($att_data->ztime!='0000-00-00 00:00:00' && $att_data->ztime!='') {
}else{
if($f=='Fri'){
} elseif($att_status==3){
}elseif($holiday!=''){
}elseif($att_status==4){
}elseif($att_status==2){
}elseif($att_status==1){
}else{ */
								//   $sac = strtotime($check_joinig_date);
								//   $sac2 = strtotime($att_data->xdate);



					?>
      <tr align="center">
        <td><?= ++$j; ?></td>
        <td><?= $basic_data->PBI_CODE ?></td>
        <td><?= $basic_data->PBI_NAME ?></td>
        <td><?= $basic_data->designation ?></td>
        <td><?= $basic_data->department ?></td>
        <td><?= $basic_data->project ?></td>
        <td><?= date('d-M-Y', strtotime($all_date)); ?></td>
      </tr>
      <? }
						}
					} ?>
  </table>
  </br>
  <?




		} elseif ($_POST['report'] == 991) {



		?>
  <table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>EMP_ID</th>
        <th>Full Name</th>
        <th>Department</th>
        <th>From </th>
        <th>To</th>
        <th>Late Minutes</th>
        <th>Late Hours</th>
        <th>Late Days</th>
      </tr>
    </thead>
    <tbody>
      <?

					if ($_POST['PBI_ID'] != '') {
						$pbi_con = " and p.PBI_ID='" . $_POST['PBI_ID'] . "' ";
					}


					if ($_POST['PBI_ORG'] != '') {
						$org_con = " and a.PBI_ORG='" . $_POST['PBI_ORG'] . "' ";
					}



					if ($_POST['year'] != '') {

						$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';

						$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
					}



					$date_con = " and l.att_date between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "' ";



					$leave_sql = "SELECT l.*,a.PBI_NAME as Employee_Name,a.PBI_CODE,(select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as department

FROM hrm_att_summary l, personnel_basic_info a where   a.PBI_ID=l.emp_id " . $pbi_con . $org_con . $date_con . $con . " group by l.emp_id order by a.DEPT_ID";



					$leave_query = db_query($leave_sql);





					while ($data_leave = mysqli_fetch_object($leave_query)) {

						$total_late_min = find_a_field('hrm_att_summary', 'sum(late_min)', 'emp_id="' . $data_leave->emp_id . '" and att_date between "' . $_POST['fdate'] . '" and  "' . $_POST['tdate'] . '"');



						$total_late_days = find_a_field('hrm_att_summary', 'sum(final_late_status)', 'emp_id="' . $data_leave->emp_id . '" and att_date between "' . $_POST['fdate'] . '" and  "' . $_POST['tdate'] . '"');



						if ($total_late_min > 0) {



					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $data_leave->PBI_CODE ?></td>
        <td><?= $data_leave->Employee_Name ?></td>
        <td><?= $data_leave->department ?></td>
        <td><?= $_POST['fdate'] ?></td>
        <td><?= $_POST['tdate'] ?></td>
        <td align="right"><?= $total_late_min ?></td>
        <td align="right"><?= $hours = floor($total_late_min / 60) . ':' . ($total_late_min -   floor($total_late_min / 60) * 60); ?></td>
        <td align="right"><?= $total_late_days ?></td>
      </tr>
      <?

							$grand_tot_leave = $grand_tot_leave + $total_late_min;

							$grand_tot_leave_days = $grand_tot_leave_days + $total_late_days;
						}
					}  ?>
      <tr>
        <td colspan="6"><div align="right"><b> Total Minutes/Hours</b></div></td>
        <td align="right"><b>
          <?= $grand_tot_leave ?>
          </b></td>
        <td align="right"><b>
          <?= $hours = floor($grand_tot_leave / 60) . ':' . ($grand_tot_leave -   floor($grand_tot_leave / 60) * 60); ?>
          </b></td>
        <td align="right"><b>
          <?= $grand_tot_leave_days ?>
          </b></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;
















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <!-- **************  OUT PUNCH MISSIG REPORT *******************-->
  <?




		} elseif ($_POST['report'] == 997) {



		?>
  <table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>EMP_ID</th>
        <th>Full Name</th>
        <th>Department</th>
        <th>From </th>
        <th>To</th>
        <th>Out Punch Missing Days</th>
      </tr>
    </thead>
    <tbody>
      <?

					if ($_POST['PBI_ID'] != '') {
						$pbi_con = " and p.PBI_ID='" . $_POST['PBI_ID'] . "' ";
					}


					if ($_POST['PBI_ORG'] != '') {
						$org_con = " and a.PBI_ORG='" . $_POST['PBI_ORG'] . "' ";
					}



					if ($_POST['year'] != '') {

						$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';

						$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
					}

					$date_con = " and l.att_date between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "' ";

					$leave_sql = "SELECT l.*,a.PBI_NAME as Employee_Name,a.PBI_CODE,(select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as department

FROM hrm_att_summary l, personnel_basic_info a where   a.PBI_ID=l.emp_id " . $pbi_con . $org_con . $date_con . $con . " group by l.emp_id order by a.DEPT_ID";

					$leave_query = db_query($leave_sql);

					while ($data_leave = mysqli_fetch_object($leave_query)) {



						$total_late_days = find_a_field('hrm_att_summary', 'count(id)', 'emp_id="' . $data_leave->emp_id . '" and in_time=out_time and

 att_date between "' . $_POST['fdate'] . '" and  "' . $_POST['tdate'] . '"');



						if ($total_late_days > 0) {



					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $data_leave->PBI_CODE ?></td>
        <td><?= $data_leave->Employee_Name ?></td>
        <td><?= $data_leave->department ?></td>
        <td><?= $_POST['fdate'] ?></td>
        <td><?= $_POST['tdate'] ?></td>
        <td align="right"><?= $total_late_days ?></td>
      </tr>
      <?


							$grand_tot_leave_days = $grand_tot_leave_days + $total_late_days;
						}
					}  ?>
      <tr>
        <td colspan="6"><div align="right"><b> Total Out Punch Missing Days</b></div></td>
        <td align="right"><b>
          <?= $grand_tot_leave_days ?>
          </b></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {
					border-bottom: 0px solid #000000;
					border-left: 0px solid #000000;
					border-right: 0px solid #000000;
					text-align: center;
					padding: 2px 10px;

				}
			</style>
  <br />
  <!--Attendance Summary Report-->
  <?
		} elseif ($_POST['report'] == 620) {


			# 2x Friday



			function dayCount($from, $to, $day = 5)
			{
				$from = new DateTime($from);
				$to   = new DateTime($to);

				$wF = $from->format('w');
				$wT = $to->format('w');
				if ($wF < $wT)       $isExtraDay = $day >= $wF && $day <= $wT;
				else if ($wF == $wT) $isExtraDay = $wF == $day;
				else                 $isExtraDay = $day >= $wF || $day <= $wT;

				return floor($from->diff($to)->days / 7) + $isExtraDay;
			}

		?>
<!--<tr>
		<td colspan="16">-->
		
		  <table style="width: 100% !important; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">
    <tr>
      <td style="border:0px solid white;"><strong>
        <?= $str ?>
        </strong></td>
    </tr>
    <tr>
      <td style="border:0px solid white;"><strong>Attendance Summary Report
       <?php /*?> <?= $_POST['year'] ?><?php */?>
        </strong></td>
    </tr>
  </table>
<!--		</td>
	</tr>-->
	
  <table style="width: 100% !important; margin:0 auto;" cellpadding="0" cellspacing="0" border="1" id="ExportTable">
  	
    <tr>
      <th><strong>SL</strong></td>
      <th><strong>EMP ID</strong></td>
      <th><strong>Name</strong></td>
      <th><strong>Joining Date</strong></td>
      <td><strong>Designation</strong></td>
      <td><strong>Department</strong></td>
      <td><strong>Total Day</strong></td>
      <td><strong>Off Day</strong></td>
      <td><strong>HoliDay</strong></td>
      <td><strong>Late Days</strong></td>
	  <td><strong>LD Days</strong></td>
      <td><strong>Absent Days</strong></td>
      <td><strong>Leave Days</strong></td>
	  <td><strong>Extra Duty</strong></td>
      <td><strong>Present Days</strong></td>
      <td><strong>Payable Days</strong></td>
      <!--<td><strong>Over Time Hour</strong></td>-->
    </tr>
    <?


				$start_mon = 01;
				$end_mon = 12;
				$year = $_POST['year'];

                  
				
				$startDate = $year . '-' . $start_mon . '-01';
				$endDate  = $year . '-' . $end_mon . '-31';


				if ($_POST['pbi_id_in'] != '')
					$con_pbi .= ' and a.PBI_ID = "' . $_POST['pbi_id_in'] . '"';

				if ($_POST['PBI_ORG'] != '')
					$salaryConn = ' and a.PBI_ORG = "' . $_POST['PBI_ORG'] . '"';

				if ($_POST['PBI_JOB_STATUS'] != '')
					$basicConn = ' and a.PBI_JOB_STATUS = "' . $_POST['PBI_JOB_STATUS'] . '"';



                   $doj = find_a_field('personnel_basic_info', 'PBI_DOJ', 'PBI_ID="' . $_POST['pbi_id_in'] . '"');
				   
				   
				$basic_sql = "
    SELECT 
        a.PBI_ID,
        a.PBI_NAME,
        a.DEPT_ID,
        a.PBI_DESIGNATION,
        a.PBI_DOJ,
        a.PBI_CODE
    FROM 
        personnel_basic_info a
    WHERE 
        a.PBI_DOJ < '" . $_POST['tdate'] . "' 
        AND a.PBI_ID NOT IN (1006, 1009, 1007, 1932, 1952)
        " . $con_pbi . " 
        " . $salaryConn . " 
        " . $basicConn . "
    GROUP BY 
        a.PBI_ID
    ORDER BY 
        a.PBI_ID ASC
";


				$basic_query = db_query($basic_sql);

				$s1 = 1;
				while ($r = mysqli_fetch_object($basic_query)) {



					$actual_fdate = ($_POST['fdate'] >= $doj) ? $_POST['fdate'] : $doj;
					$friday_count =  dayCount($_POST['fdate'], $_POST['tdate'], 5);
					$attedance = find_all_field('hrm_attendence_final', '', 'PBI_ID="' . $r->PBI_ID . '"  and mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');


					$start = strtotime($_POST['fdate']);
					$end = strtotime($_POST['tdate']);
					$days_between = ceil(abs($start - $end) / 86400);

					$total_days = $days_between + 1;

					$present = find_a_field('hrm_att_summary', 'count(id)', 'emp_id="' . $r->PBI_ID . '"  and dayname != "Friday" and att_date between "' . $actual_fdate . '" and  "' . $_POST['tdate'] . '"');
					
					
					$friday = find_a_field('hrm_att_summary', 'count(id)', 'emp_id="' . $r->PBI_ID . '"  and dayname = "Friday" and sch_off_day= 1 and att_date between "' . $actual_fdate . '" and  "' . $_POST['tdate'] . '"');
				
				
					$ac_absent = find_a_field('hrm_att_summary', 'count(id)', 'emp_id="' . $r->PBI_ID . '" and absent =1 and dayname != "Friday" and att_date between "' . $actual_fdate . '" and  "' . $_POST['tdate'] . '"');

					$leave = find_a_field('hrm_att_summary', 'count(leave_id)', 'emp_id="' . $r->PBI_ID . '" and leave_id>0 and att_date between "' .$actual_fdate . '" and  "' . $_POST['tdate'] . '"');
					
											$extra_holy = find_a_field(
							'salary_holy_day_individual',
							'count(id)',
							"PBI_ID = '{$r->PBI_ID}' AND reason LIKE '%Off day%' AND holy_day BETWEEN '{$actual_fdate}' AND '{$_POST['tdate']}'"
						);

					
					$holy = find_a_field('salary_holy_day', 'count(id)', 'holy_day between "' . $_POST['fdate'] . '" and  "' . $_POST['tdate'] . '"');
						

$totdays = find_a_field(
    'hrm_att_summary',
    'count(id)',
    'emp_id="' . $r->PBI_ID . '" AND att_date BETWEEN "' . $actual_fdate . '" AND "' . $_POST['tdate'] . '"'
);


					
					$lt_summary = find_a_field('hrm_att_summary', 'count(id)', 'emp_id="' . $r->PBI_ID . '"  and att_date between "' . $actual_fdate . '" and  "' . $_POST['tdate'] . '" and final_late_status>0 and iom_type=""');
					
					$tot_iom = find_a_field('hrm_iom_info', 'count(total_days)', 'PBI_ID="' . $r->PBI_ID . '" and dept_head_status = "Approve" and iom_status= "GRANTED" and  e_date between "' . $_POST['fdate'] . '" and  "' . $_POST['tdate'] . '"  and s_date between "' . $actual_fdate . '" and  "' . $_POST['tdate'] . '"');

					//$absent = find_a_field('hrm_att_summary','count(leave_id)','emp_id="'.$r->PBI_ID.'" and att_date between "'.$_POST['fdate'].'" and  "'.$_POST['tdate'].'"');
                      
			$doj = find_a_field('personnel_basic_info', 'PBI_DOJ', 'PBI_ID="' . $r->PBI_ID . '"');

$doj_timestamp = strtotime($doj);
$doj_year = date('Y', $doj_timestamp);
$doj_month = date('m', $doj_timestamp);
$ded_day=floor($attedance->lt/3);
// Check if DOJ is in the current month and year
if ($doj_year == $year && $doj_month == $mon) {
    // Joining is this month → count from DOJ to end of month
    $last_day_of_month = date('t', strtotime($doj));
    $doj_day = date('d', $doj_timestamp);
    $totalDays = $last_day_of_month - $doj_day + 1;
} else {
    // Not joined this month → use full month's days
    $totalDays = date('t', mktime(0, 0, 0, $mon, 1, $year));
}
					  
					  
					  
					  
					  
					  
					  
					$absent_days = ($total_days - $present);
					$present_days =  $present;
					$payble_days =  $present + $friday_count;
					$real_lt = $attedance->lt - $tot_iom;
					$total_ld_days= floor($lt_summary/3);
					$total_lt_days=$lt_summary-$tot_iom;



				?>
    <tr> 
      <td><?= $s1++; ?></td>
      <td><div align="center">
          <?= $r->PBI_CODE?>
        </div></td>
      <td><?= $r->PBI_NAME ?></td>
      <td><?= $r->PBI_DOJ; ?></td>
      <td><?= $r->PBI_DESIGNATION ?></td>
      <td><?= find_a_field('department', 'DEPT_DESC', 'DEPT_ID="' . $r->DEPT_ID . '"'); ?></td>
      <td><?= $attedance->td ?></td>
      <td><?= $attedance->od ?></td>
	  <td><?= $attedance->hd ?></td>
      <?php /*?><td><?= $attedance->hd ?></td><?php */?>
      <td><?=  $attedance->lt?></td>
	  <td><?=  $total_ld_days?> </td>
      <td><?= $attedance->ab?></td>
      <td><?= $attedance->lv ?></td>
	  <td></td>
      <td><?= $attedance->pre ?></td>
      <td><?= $attedance->pay-$ded_day?></td>
      <?php /*?><td><?= $attedance->overtime_hour ?></td><?php */?>
    </tr>
    <?

				}
				?>
  </table>
  <!--END Leave summary report-->
  <?


		} elseif ($_POST['report'] == 992) {



		?>
  <table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>EMP_ID</th>
        <th>Full Name</th>
        <th>Department</th>
        <th>From </th>
        <th>To</th>
        <th>Early Out Minutes</th>
        <th>Early Out Hours</th>
        <th>Total Days</th>
      </tr>
    </thead>
    <tbody>
      <?

					if ($_POST['PBI_ID'] != '') {
						$pbi_con = " and p.PBI_ID='" . $_POST['PBI_ID'] . "' ";
					}

					if ($_POST['PBI_ORG'] != '') {
						$org_con = " and a.PBI_ORG='" . $_POST['PBI_ORG'] . "' ";
					}




					if ($_POST['year'] != '') {

						$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';

						$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
					}



					$date_con = " and l.att_date between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "' ";



					$leave_sql = "SELECT l.*,a.PBI_NAME as Employee_Name,a.PBI_CODE,(select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as department  FROM hrm_att_summary l, personnel_basic_info a where   a.PBI_ID=l.emp_id " . $pbi_con . $org_con . $date_con . $con . " group by l.emp_id";



					$leave_query = db_query($leave_sql);





					while ($data_leave = mysqli_fetch_object($leave_query)) {

						$total_early_min = find_a_field('hrm_att_summary', 'sum(early_min)', 'emp_id="' . $data_leave->emp_id . '" and att_date between "' . $_POST['fdate'] . '" and  "' . $_POST['tdate'] . '"');



						$total_early_days = find_a_field('hrm_att_summary', 'sum(final_early_status)', 'emp_id="' . $data_leave->emp_id . '" and att_date between "' . $_POST['fdate'] . '" and  "' . $_POST['tdate'] . '"');



						if ($total_early_min > 0) {



					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $data_leave->PBI_CODE ?></td>
        <td><?= $data_leave->Employee_Name ?></td>
        <td><?= $data_leave->department ?></td>
        <td><?= $_POST['fdate'] ?></td>
        <td><?= $_POST['tdate'] ?></td>
        <td align="right"><?= $total_early_min ?></td>
        <td align="right"><?= $hours = floor($total_early_min / 60) . ':' . ($total_early_min -   floor($total_early_min / 60) * 60); ?></td>
        <td align="right"><b>
          <?= $total_early_days ?></td>
      </tr>
      <? $grand_tot_leave = $grand_tot_leave + $total_early_min;



							$grand_tot_days = $grand_tot_days + $total_early_days;
						}
					}  ?>
      <tr>
        <td colspan="6"><div align="right"><b> Total Minutes/Hours</b></div></td>
        <td align="right"><b>
          <?= $grand_tot_leave ?></td>
        <td align="right"><b>
          <?= $hours = floor($grand_tot_leave / 60) . ':' . ($grand_tot_leave -   floor($grand_tot_leave / 60) * 60); ?></td>
        <td align="right"><b>
          <?= $grand_tot_days ?></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 20220519) {



		?>
  <table width="70%" cellspacing="0" id="ExportTable" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>Emp ID</th>
        <th>Name</th>
        <th>Cost Center</th>
        <th>Department</th>
        <th>Section</th>
        <th>Type</th>
        <th>Applied From</th>
        <th>Applied To</th>
        <th>Total Days</th>
        <th>Reason</th>
        <th>Reporting Supervisor Name</th>
        <th>Supervisor Approval</th>
        <th>HR Approval</th>
      </tr>
    </thead>
    <tbody>
      <?

					
				if ($_POST['JOB_LOCATION'] != '') {
					$job_loc_con = " and a.JOB_LOC_ID='" . $_POST['JOB_LOCATION'] . "' ";
				}

				if ($_POST['job_status'] != '') {
					$job_con .= " and a.PBI_JOB_STATUS='" . $_POST['job_status'] . "' ";
				}
				if ($_POST['PBI_IDD'] > 0) $IDConn = " and a.PBI_ID='" . $_POST['PBI_IDD'] . "'";

				if ($_POST['PBI_CODE'] != "") $codeConn = " and a.PBI_CODE='" . $_POST['PBI_CODE'] . "'";

				if ($_POST['PBI_NAME'] != "") $NameConn = " and a.PBI_NAME='" . $_POST['PBI_NAME'] . "'";

				if ($_POST['PBI_ORG'] > 0) $org = " and a.PBI_ORG='" . $_POST['PBI_ORG'] . "'";

				if ($_POST['cost_center'] != "") $cost_center = " and a.cost_center='" . $_POST['cost_center'] . "'";

				if ($_POST['DEPT_ID'] != "") $dept = " and a.DEPT_ID='" . $_POST['DEPT_ID'] . "'";

				if ($_POST['section'] != "") $section = " and a.section='" . $_POST['section'] . "'";

				if ($_POST['JOB_LOC_ID'] > 0) $job_loc = " and a.JOB_LOC_ID='" . $_POST['JOB_LOC_ID'] . "'";

				if ($_POST['PBI_SEX'] != "") $gender = " and a.PBI_SEX='" . $_POST['PBI_SEX'] . "'";

				if ($_POST['grade'] != "") $grade = " and a.grade='" . $_POST['grade'] . "'";

				if ($_POST['work_station'] != "") $work = " and a.work_station='" . $_POST['work_station'] . "'";

				if ($_POST['level'] != "") $level = " and a.level='" . $_POST['level'] . "'";

				if ($_POST['class'] != "") $class = " and a.class='" . $_POST['class'] . "'";

				if ($_POST['PBI_RELIGION'] != "") $religion = " and a.PBI_RELIGION='" . $_POST['PBI_RELIGION'] . "'";

				if ($_POST['incharge_id'] != "") $incharge = " and a.incharge_id='" . $_POST['incharge_id'] . "'";
					
					

					if ($_POST['year'] != '') {

						$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';

						$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
					}



					//$date_con = " and i.s_date between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "' ";






					 $sql = "SELECT a.PBI_NAME as Name,a.PBI_CODE as Employee_ID,a.PBI_ID,a.define_schedule,a.DEPT_ID,
					i.type,i.s_date,i.e_date,i.s_time,i.e_time,i.total_days,i.reason,i.iom_status,i.dept_head_status,a.cost_center,
					a.section,a.incharge_id,i.entry_at



                	 FROM hrm_iom_info i, personnel_basic_info a
                	 
                	 where  a.PBI_ID=i.PBI_id and i.s_date>='" . $_POST['fdate'] . "' and 
                	 i.e_date<='" . $_POST['tdate'] . "'
					  
					  ".$job_loc_con. $job_con . $date_con . $NameConn . $IDConn . $codeConn .
						$con . $org . $cost_center . $dept . $section . $job_loc . $gender .
						$grade . $work . $level . $class . $religion . $incharge .  "
					  
					  order by i.id desc";
                


					$query = db_query($sql);





					while ($data = mysqli_fetch_object($query)) {



						if ($data->type == "Last Half") {

							$difference = ceil(($e_time - $l_punch) / 60);
						} elseif ($data->type == "Early Half") {

							$difference = ceil(($f_punch - $s_time) / 60);
						} else {

							$difference = 510;
						}

                     $dep_name = find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');
                     $cost_center = find_a_field('hrm_cost_center','center_name','id="'.$data->cost_center.'"');
                     
                     $section_name = find_a_field('PBI_Section','sec_name','sec_id="'.$data->section.'"');
                     $reporting_boss = find_a_field('personnel_basic_info','CONCAT(PBI_NAME,"-",PBI_CODE)','PBI_ID="'.$data->incharge_id.'"');

					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $data->Employee_ID ?></td>
        <td><?= $data->Name?></td>
        <td><?=$cost_center;?></td>
        <td><?=$dep_name;?></td>
        <td><?=$section_name;?></td>
        <td><?
							
							if($data->type=="Early Half") {
								echo "In Late";
							}elseif($data->type=="Full"){
								
								echo "Absent";
								
							}else{ echo "Early Out";}
							
							
							
							?></td>
        <td><?= $data->s_date ?></td>
        <td><?= $data->e_date ?></td>
        <td><?= $data->total_days ?></td>
        <td><?= $data->reason ?></td>
        <td><?=$reporting_boss;?></td>
        <td><?=$data->dept_head_status?></td>
        <td><?=$data->iom_status?></td>
      </tr>
      <? } ?>
    </tbody>
  </table>
  <?
		} elseif ($_POST['report'] == 993) {
		?>
  <table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>EMP_ID</th>
        <th>Full Name</th>
        <th>Department</th>
        <th>Date </th>
        <th>Punch</th>
        <th>View</th>
      </tr>
    </thead>
    <tbody>
      <?







					if ($_POST['PBI_ID'] != '') {
						$pbi_con = " and p.PBI_CODE='" . $_POST['PBI_ID'] . "' ";
					}
					if ($_POST['year'] != '') {
						$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';
						$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
					}


					$date_con = " and l.xdate between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "' ";
					$leave_sql = "SELECT l.*,a.PBI_NAME as Employee_Name,a.resign_date,a.PBI_CODE,(select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as department  

FROM hrm_attdump l, personnel_basic_info a where   a.PBI_ID=l.EMP_CODE " . $pbi_con . $date_con . $con . " order by l.xenrollid,l.xtime asc";





					$leave_query = db_query($leave_sql);



					while ($data_leave = mysqli_fetch_object($leave_query)) {


					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $data_leave->PBI_CODE ?></td>
        <td><?= $data_leave->Employee_Name ?></td>
        <td><?= $data_leave->department ?></td>
        <td><?= $data_leave->xdate ?></td>
        <td align="right"><?= date('H:i:s', strtotime($data_leave->xtime)) ?></td>
        <td align="center"><?

												$in_latitute = $data_leave->latitude;
												$in_longitude = $data_leave->longitude;

												if ($in_latitute != '' && $in_longitude != '') { ?>
          <a href="https://www.latlong.net/c/?lat=<?= $in_latitute ?>&long=<?= $in_longitude ?>" target="_blank" class="btn btn-warning btn-xs">View</a>
          <? } ?>
        </td>
      </tr>
      <? } ?>
    </tbody>
  </table>
  <style type="text/css">
				#new td {

					border-bottom: 0px solid #000000;



					border-left: 0px solid #000000;


					border-right: 0px solid #000000;

					text-align: center;


					padding: 2px 10px;
				}
			</style>
  <br />
  </style>
  <br />
  <!-- **********   Time Card Start  **************** -->
  <?




		} elseif ($_POST['report'] == 9193) {



		?>
  <!--<table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">-->
  <!--  <thead>-->
  <!--    <tr>-->
  <!--      <th style="border:0px;" colspan="21"><?= $str ?></th>-->
  <!--    </tr>-->
  <!--  </thead>-->
  <?

			//$basic=find_all_field('personnel_basic_info','',"PBI_CODE=".$_POST['pbi_id_in']);
			//echo $basic->PBI_CODE;

			if ($_POST['PBI_NAME'] != "") {

				$basic_id = find_a_field('personnel_basic_info', 'PBI_ID', 'PBI_NAME="' . $_POST['PBI_NAME'] . '"');
			} elseif ($_POST['PBI_CODE'] != "") {
				$basic_id = find_a_field('personnel_basic_info', 'PBI_ID', 'PBI_CODE="' . $_POST['PBI_CODE'] . '"');
			}
			 else {
				$basic_id = find_a_field('personnel_basic_info', 'PBI_ID', 'PBI_ID="' . $_POST['PBI_IDD'] . '"');
			}





			$basic_idd = find_all_field('personnel_basic_info', '', 'PBI_ID="' . $basic_id . '"');

			?>
  <!--  <div class="col-12">-->
  <!--    <div class="panel-heading">-->
  <!--      <h3 class="panel-title" align="center">-->
  <? //=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG'])
			?>
  <!--      </h3>-->
  <!--    </div>-->
  <!--  </div>-->
  <!--  </tbody>-->
  <!--</table>-->
  <!--</br>-->
  <style>
				.table-font {
					font-size: 13px;
				}

				.titel-font {
					font-size: 13px;
					line-height: 15px;
				}

				.table-font-sub {
					font-size: 11px;
				}

				@page {
					margin: 10mm 15mm 10mm 20mm;
				}

				@media print {
					.table-font {
						font-size: 10px;
					}

					.titel-font {
						font-size: 11px;
					}

					.table-font-sub {
						font-size: 9px;
					}


				}
			</style>
  <table class="new_table" cellspacing="0" cellpadding="2" border="0" style="margin:0 auto;">
    <tr>
      <td colspan="4" style="border: 0px; padding: 0px;"><table width="100%" cellspacing="0" cellpadding="2" border="0" style="margin:0 auto;">
          <tr>
            <td width="15%" style=" border: 0px; "><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['proj_id'] ?>.png" width="100%" class="logo-img" /> </td>
            <td width="70%" style=" border: 0px; "><h2 class="panel-title" align="center"><b>
                <?= find_a_field('user_group', 'group_name', 'id=' . $basic_idd->PBI_ORG); ?>
                </b></h2>
              <h3 class="panel-title" align="center"><b>Time Card</b></h3>
              <h3 class="panel-title" align="center"> <b>For the month of
                <?=$monthName = date('F', mktime(0, 0, 0, $_POST["mon"], 1));?>
                <?=$_POST["year"];?>
                </b></h3></td>
            <td width="15%" style=" border: 0px; ">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
    
    <td colspan="4" style="border: 0px; padding: 0px;">
    
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tbody>
        <tr class="titel-font">
          <td width="33%" align="left" style="border: 0px; padding: 5px 0px;">Employee ID: <strong>
            <?= $basic_idd->PBI_CODE; ?>
            </strong></td>
          <td width="40%" align="left" style="border: 0px; padding: 5px 0px;">Employee Name: <strong>
            <?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID="' . $basic_idd->PBI_ID . '"'); ?>
            </strong></td>
          <td width="27%" align="left" style="border: 0px; padding: 5px 0px;">Designation: <strong>
            <?= find_a_field('designation', 'DESG_DESC', 'DESG_ID=' . $basic_idd->DESG_ID); ?>
            </strong></td>
          <!--<td width="25%"  align="left" style="border: 0px; padding: 5px 0px;" >Employee ID: <strong><?= $basic_idd->
          PBI_CODE; ?>
          </strong>
      </td>
      -->
      <!--<td width="30%"  align="left" style="border: 0px; padding: 5px 0px;" >Employee Name: <strong><?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID="' . $basic_idd->
      PBI_ID . '"'); ?>
      </strong>
      </td>
      -->
      <!--<td width="20%"  align="left" style="border: 0px; padding: 5px 0px;" >Designation: <strong><?= find_a_field('designation', 'DESG_DESC', 'DESG_ID=' . $basic_idd->
      DESG_ID); ?>
      </strong>
      </td>
      -->
      <!--<td width="25%"  align="right" style="border: 0px; padding: 5px 0px;" >DOJ: <strong> <?= find_a_field('personnel_basic_info', 'PBI_DOJ', 'PBI_ID="' . $basic_idd->
      PBI_ID . '"'); ?>
      </strong>
      </td>
      -->
      </tr>
      
      <tr class="titel-font">
        <td width="33%" align="left" style="border: 0px; padding: 5px 0px;">Cost Center: <strong>
          <?= find_a_field('hrm_cost_center', 'center_name', 'id=' . $basic_idd->cost_center); ?>
          </strong> </td>
        <td width="40%" align="left" style="border: 0px; padding: 5px 0px;">Depertment: <strong>
          <?= find_a_field('department', 'DEPT_DESC', 'DEPT_ID="' . $basic_idd->DEPT_ID . '"'); ?>
          </strong> </td>
        <td width="27%" align="left" style="border: 0px; padding: 5px 0px;"></td>
      </tr>
      <tr class="titel-font">
        <td width="33%" align="left" style="border: 0px; padding: 5px 0px;"> Section: <strong>
          <?= find_a_field('PBI_Section', 'sec_name', 'sec_id=' . $basic_idd->section); ?>
          </strong></td>
        <td width="40%" align="left" style="border: 0px; padding: 5px 0px;"> DOJ: <strong>
          <?= date('d-M-Y', strtotime(find_a_field('personnel_basic_info', 'PBI_DOJ', 'PBI_ID="' . $basic_idd->PBI_ID . '"'))) ?>
          </strong> </td>
        <td width="27%" align="left" style="border: 0px; padding: 5px 0px;"><?php 
    $resign_date = find_a_field('personnel_basic_info', 'resign_date', 'PBI_ID="' . $basic_idd->PBI_ID . '"');
    if ($resign_date && strtotime($resign_date) > 0): ?>
          DOL:<strong>
          <?= date('d-M-Y', strtotime($resign_date)) ?>
          </strong>
          <?php endif; ?>
        </td>
      </tr>
      <!--<tr>-->
      <!--<td align="left" style="border: 0px; padding: 0px;" > Work Station: <strong><?= find_a_field('hrm_workstation', 'work_station_name', 'station_id=' . $basic_idd->
      PBI_WORK_STATION); ?>
      </strong>
      </td>
      -->
      <!--<td align="left" style="border: 0px; padding: 0px;" > Class: <strong> <?= find_a_field('hrm_class', 'class_name', 'id=' . $basic_idd->
      class); ?>
      </strong>
      </td>
      -->
      <!--<td align="left" style="border: 0px; padding: 0px;" >Section: <strong> <?= find_a_field('hrm_workstation', 'work_station_name', 'station_id=' . $basic_idd->
      PBI_WORK_STATION); ?>
      </strong>
      </td>
      -->
      <!--<td align="left" style="border: 0px; padding: 0px;" ><strong></strong></td>-->
      <!--</tr>-->
      </tbody>
      
    </table>
    </td>
    
    </tr>
    
    <tr>
      <td colspan="4" style="border: 0px; padding: 0px;"><table width="100%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;" class="sr-table">
          <thead>
            <tr class="table-font">
              <!--<th>SL </th>-->
              <th>Date </th>
              <th>Day Name </th>
              <th>In Time</th>
              <th>Out Time</th>
              <th>OT Hours</th>
              <th align="center"> <p style="margin: 0px; line-height: 15px; padding: 0px;font-weight: 600; text-align: center;" class="table-font">In Late</p>
                <p style="margin: 0px; line-height: 15px; text-align: center; padding: 0px;font-weight: 600;" class="table-font-sub">(Minute)</p></th>
              <th align="center"> <p style="margin: 0px; line-height: 15px; padding: 0px;font-weight: 600; text-align: center;" class="table-font">Early out</p>
                <p style="margin: 0px; line-height: 15px; text-align: center; padding: 0px;font-weight: 600;" class="table-font-sub">(Minute)</p></th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody class="table-font">
            <?

								//if($_POST['PBI_CODE'] != ''){ $pbi_con = " and a.PBI_ID='".$_POST['PBI_CODE']. "' "; }

								if ($_POST['PBI_IDD'] > 0) $IDConn = " and l.emp_id='" . $_POST['PBI_IDD'] . "'";

								if ($_POST['PBI_CODE'] != "") $codeConn = " and a.PBI_CODE='" . $_POST['PBI_CODE'] . "'";

								if ($_POST['PBI_NAME'] != "") $NameConn = " and a.PBI_NAME='" . $_POST['PBI_NAME'] . "'";

								if ($_POST['year'] != '') {

									$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';

									$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
								}

                               
                                

								$date_con = " and l.att_date between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "' ";

								$leave_sql = "SELECT l.*,a.PBI_NAME as Employee_Name,a.PBI_CODE, a.resign_date,
								(select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as department,
								l.present,l.leave_duration,l.sch_off_day,l.holiday_work
								
								 FROM hrm_att_summary l, personnel_basic_info a 
								 where a.PBI_ID=l.emp_id " . $date_con . $NameConn . $IDConn . $codeConn . $con . " order by l.emp_id,l.att_date asc";

								$leave_query = db_query($leave_sql);
								while ($data = mysqli_fetch_object($leave_query)) {

									$val[$data->att_date]['in_time'] = $data->in_time;
									$val[$data->att_date]['out_time'] = $data->out_time;
									$val[$data->att_date]['sch_in_time'] = $data->sch_in_time;
									$val[$data->att_date]['sch_out_time'] = $data->sch_out_time;
									$val[$data->att_date]['iom'] = $data->iom_id;
									$val[$data->att_date]['leave'] = $data->leave_id;
									$val[$data->att_date]['dayname'] = $data->dayname;
									$val[$data->att_date]['od_id'] = $data->od_id;
									$val[$data->att_date]['od_start_time'] = $data->od_start_time;
									$val[$data->att_date]['iom_start_time'] = $data->iom_start_time;
									$val[$data->att_date]['ot_final_hour'] = $data->ot_time_to_decimal;
									$val[$data->att_date]['iom_total_hrs'] = $data->iom_total_hrs;
									$val[$data->att_date]['sch_off_day'] = $data->sch_off_day;
									$val[$data->att_date]['final_late_min'] = $data->final_late_min;
									$val[$data->att_date]['late_min'] = $data->late_min;
									$val[$data->att_date]['early_min'] = $data->early_min;
									$val[$data->att_date]['final_early_min'] = $data->final_early_min;
									$val[$data->att_date]['final_day_off_status'] = $data->final_day_off_status;
								   
								   $lave_type_id = find_a_field('hrm_leave_info','type','id='.$data->leave_id);
                                   $lave_types = find_a_field('hrm_leave_type','leave_short_name','id='.$lave_type_id);
                                   $val[$data->att_date]['leave_type'] = $lave_types;
								   
								    $val[$data->att_date]['leave_duration'] = $data->leave_duration;
									$val[$data->att_date]['leave_reason'] = $data->leave_reason;
								   
								   $val[$data->att_date]['emp_id'] = $data->emp_id;





									$total_late_min += $data->actual_late_min;
									$total_early_min += $data->final_early_min;
									$total_overtime += $data->ot_time_to_decimal;
									
						$acctual_present += ($data->present -($data->sch_off_day+$data->leave_duration+$data->holiday_work)); //+$data->holiday_work

									//office time
									$sac_formated = date("H:i", strtotime($data->sch_in_time));
									$punch_outtimes = date("H:i", strtotime($data->out_time));


									//od start time
									$od_start_timee = date("h:i", strtotime($data->od_start_time));
									//iom start time
									$sort_leave_start_timee = date("h:i", strtotime($data->iom_start_time));


									$val[$data->att_date]['final_late_status'] = $data->final_late_status;
									$val[$data->att_date]['final_early_status'] = $data->final_early_status;
									$val[$data->att_date]['grace_no'] = $data->grace_no;
									$val[$data->att_date]['holyday'] = $data->holyday;

									if ($data->leave_id > 0)
										$val[$data->att_date]['final_status'] = 'LEAVE';

									elseif ($data->in_time == '' && $data->leave_id == 0  && $data->iom_id == 0)
										$val[$data->att_date]['final_status'] = 'Absent';

									elseif ($data->final_late_status > 0 && $data->final_early_status > 0 && $data->final_day_off_status==0)
										$val[$data->att_date]['final_status'] = 'Late & Early Out';

									elseif ($data->early_min > 0 && $data->final_early_status > 0 && $data->final_day_off_status==0)
										$val[$data->att_date]['final_status'] = 'Early Out';

									elseif ($data->final_late_status > 0 && $data->final_day_off_status==0)
										$val[$data->att_date]['final_status'] = 'LATE';



									elseif ($data->holyday > 0)
										$val[$data->att_date]['final_status'] = 'HOLIDAY';

									elseif ($data->sch_off_day > 0)
										$val[$data->att_date]['final_status'] = 'Weekend';

									elseif ($data->iom_id > 0)
										$val[$data->att_date]['final_status'] = 'Amendment';

									elseif ($data->present > 0 && $data->final_day_off_status==0)
										$val[$data->att_date]['final_status'] = 'PRESENT';
										
									elseif ($data->final_day_off_status > 0)
										$val[$data->att_date]['final_status'] = 'Day Off';





									$dteStart = new DateTime($data->in_time);
									$dteEnd   = new DateTime($data->out_time);
									$dteDiff  = $dteStart->diff($dteEnd);
								}




								$start_date = $_POST['fdate'];
								$end_date = $_POST['tdate'];


								$begin = new DateTime($start_date);
								//$end = new DateTime($end_date);

								$start = new DateTimeImmutable($end_date);
								$end = $start->modify('+1 day');


								$interval = DateInterval::createFromDateString('1 day');
								$period = new DatePeriod($begin, $interval, $end);

								foreach ($period as $dt) {
									++$days;

									$this_date = $dt->format("Ymd");
									$day_date = $dt->format("Y-m-d");
									
									
				 $holiday_id_check = find_a_field('salary_holy_day_individual','id','PBI_ID="'.$val[$day_date]['emp_id'].'" and holy_day="'.$day_date.'"');
									
						if($holiday_id_check >0){
						$holysql = "select * from salary_holy_day_individual where  PBI_ID='".$val[$day_date]['emp_id']."' and  holy_day = '" . $day_date . "'";
						}else{
						$holysql = "select * from salary_holy_day where holy_day = '" . $day_date . "'";
						}
									
									$holy_query = db_query($holysql);
									$holy = mysqli_fetch_object($holy_query);
									$holy_reson = $holy->reason;
									
									
									
									
									
									
									$val[$day_date]['grace_no'];

									if ($holy > 0) {
										$bgcolor = '#000000';
										$val[$day_date]['final_status'] = $holy_reson;
										$public_holy++;
									} elseif ($val[$day_date]['final_status'] == 'Weekend') {
										$bgcolor = '#1294f3';
										$off_days++;
									} elseif ($val[$day_date]['final_status'] == 'LEAVE') {
										$bgcolor = '#4E9BE5';
										$leave++;
									} elseif ($val[$day_date]['final_status'] == 'SHL') {
										$bgcolor = '#D5D6EA';
										$shl++;
									} elseif ($val[$day_date]['final_status'] == 'Amendment') {
										$bgcolor = '#000000';
										$amendment++;
									} elseif ($val[$day_date]['final_status'] == 'Early Out') {
										$bgcolor = '#000000';
										$early++;
									} elseif ($val[$day_date]['final_status'] == 'Late & Early Out') {
										$bgcolor = '#000000';
										$late++;
										$early++;
									} elseif ($val[$day_date]['final_status'] == 'ABSENT') {
										$bgcolor = '#EA6F5A';
										$absent_leave_ck++;
									} elseif ($val[$day_date]['final_status'] == 'LATE') {
										$bgcolor = '#000000';
										$late++;
										$late_min_total = $late_min_total + $val[$day_date]['late_min'];
									} elseif ($val[$day_date]['final_status'] == 'PRESENT') {
										$bgcolor = '#202124';
										$regular++;
										
									} elseif ($val[$day_date]['final_status'] == 'Day Off') {
										$bgcolor = '#202124';
										$day_off++;
										
									} else {
										$bgcolor = '#EA6F5A';
										$absent++;
										$val[$day_date]['final_status'] = 'ABSENT';
									}



								?>
            <tr style="color:<?= $bgcolor ?>">
              <!--<td><?= ++$i; ?></td>-->
              <td><?= $dt->format("d-M-Y"); ?></td>
              <td><?= $dt->format("l"); ?></td>
              <?php if ($val[$day_date]['in_time'] > 0) {  ?>
              <td><div align="center">
                  <?= date("h:i a", strtotime($val[$day_date]['in_time'])); ?>
                </div></td>
              <?php } else {  ?>
              <td></td>
              <?php  } ?>
              <?php if ($val[$day_date]['out_time'] > 0 && $val[$day_date]['in_time'] != $val[$day_date]['out_time']) {  ?>
              <td><div align="center">
                  <?= date("h:i a", strtotime($val[$day_date]['out_time'])); ?>
                </div></td>
              <?php } else {  ?>
              <td></td>
              <?php  } ?>
              <td><? if ($val[$day_date]['ot_final_hour'] > 0) echo $val[$day_date]['ot_final_hour']; ?></td>
              <td><? if ($val[$day_date]['final_late_status'] > 0 && $val[$day_date]['late_min'] > 0)  echo $val[$day_date]['late_min']; ?></td>
              <td><? if ($val[$day_date]['final_early_status'] > 0) echo $val[$day_date]['final_early_min']; ?></td>
              <td><? //= $val[$day_date]['final_status']; ?>
                <? 
				
				
					                    if($val[$day_date]['final_status']=='LEAVE'){ 
										
										echo $val[$day_date]['leave_type'];  
										
										echo " Days:".$val[$day_date]['leave_duration'];
										 
										echo "(".$val[$day_date]['leave_reason'].")"; 
										
			                            }else{ 
										echo $val[$day_date]['final_status'];
										}
										
										?>
              </td>
            </tr>
            <? } ?>
            <tr class="table-font">
              <td colspan="3" style=" border: 0px; "> Summary:</td>
              <td style=" border: 0px; ">Total OT Hrs: </td>
              <td style=" border: 0px; "><?= $total_overtime; ?></td>
              <td style=" border: 0px; "><?= $total_late_min; ?></td>
              <td style=" border: 0px; "><?= $total_early_min; ?></td>
              <td style=" border: 0px; "><!--<span>Absent Amendment: <?= $amendment; ?></span>-->
                <span>Day off: 0</span> </td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr>
      <td colspan="4" style="padding: 0px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr class="table-font">
            <td style=" border: 0px;">Present: <strong>
              <?=$acctual_present; ?>
              </strong></td>
            <td style=" border: 0px;">Absent: <strong>
              <?= $absent; ?>
              </strong></td>
            <td style=" border: 0px;">Holiday: <strong>
              <?= $off_days + $public_holy; ?>
              </strong></td>
            <td style=" border: 0px;">Leave: <strong>
              <?= $leave; ?>
              </strong></td>
            <td style=" border: 0px;">Absent Amendment: <strong>
              <?= $amendment; ?>
              </strong></td>
            <td style=" border: 0px;">Present In Holiday: <strong>0</strong></td>
            <td style=" border: 0px;">In Late: <strong>
              <?= $late; ?>
              </strong></td>
            <td style=" border: 0px;">Early Out: <strong>
              <?= $early; ?>
              </strong></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <style type="text/css">
				#new td {
					border-bottom: 0px solid #000000;
					border-left: 0px solid #000000;
					border-right: 0px solid #000000;
					text-align: center;
					padding: 2px 10px;

				}

				tr td {
					border: 1px solid #646262;
					border-style: dotted;
				}

				.new_table {
					width: 70%;
				}

				.sr-table td {
					padding: 4px 5px !important;
				}

				@media print {
					.new_table {
						width: 100%;
					}
				}
			</style>
  <br />
  <!-- **********   Job Card END  **************** -->
  <?
		} elseif ($_POST['report'] == 994) {



		?>
  <table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>Dept</th>
        <th>Total Employee</th>
        <th>Present</th>
        <th>Absent </th>
        <th>Late</th>
        <th>Early Out</th>
      </tr>
    </thead>
    <tbody>
      <?

					if ($_POST['PBI_ID'] != '') {
						$pbi_con = " and p.PBI_CODE='" . $_POST['PBI_ID'] . "' ";
					}

					if ($_POST['job_status'] != '') {
						$status_con = " and a.PBI_JOB_STATUS='" . $_POST['job_status'] . "' ";
					}





					if ($_POST['year'] != '') {

						$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';

						$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
					}

					$now = strtotime($_POST['tdate']);

					$your_date = strtotime($_POST['fdate']);

					$datediff = $now - $your_date;



					$days = round($datediff / (60 * 60 * 24));



					$date_con = " and l.xdate between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "' ";



					$leave_sql = "select d.DEPT_DESC,d.DEPT_ID, count(a.PBI_ID) as total_employee,count(s.id) as present,sum(s.final_late_status) as late ,sum(s.final_early_status) early_out from personnel_basic_info a left join department d on d.DEPT_ID=a.DEPT_ID left join hrm_att_summary s on s.emp_id=a.PBI_ID and s.att_date between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "'  where 1 " . $con . $status_con . " and s.leave_type !='Full' group by a.DEPT_ID";



					$leave_query = db_query($leave_sql);





					$t_sql = "select count(a.PBI_ID) as total,a.DEPT_ID from personnel_basic_info a  where 1  " . $status_con . " group by a.DEPT_ID";

					$t_query = db_query($t_sql);

					while ($t_data = mysqli_fetch_object($t_query)) {



						$total_empp[$t_data->DEPT_ID] = $t_data->total;
					}





					while ($data_leave = mysqli_fetch_object($leave_query)) {





						//$total_employee = find_a_field('personnel_basic_info','count(PBI_ID)','DEPT_ID="'.$data_leave->DEPT_ID.'" '.$status_con.' ');





					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $data_leave->DEPT_DESC ?></td>
        <td><?= $total_empp[$data_leave->DEPT_ID];
								$total_emp += $total_empp[$data_leave->DEPT_ID]; ?></td>
        <td><?= $data_leave->present ?></td>
        <td><?= $total_empp[$data_leave->DEPT_ID] - $data_leave->present ?></td>
        <td><?= $data_leave->late ?></td>
        <td><?= $data_leave->early_out ?></td>
      </tr>
      <?

						$total_present += $data_leave->present;

						$total_absent += $total_empp[$data_leave->DEPT_ID] - $data_leave->present;

						$total_late += $data_leave->late;

						$total_early += $data_leave->early_out;
					} ?>
      <tr>
        <td colspan="2"><strong>Total</strong></td>
        <td><?= $total_emp ?></td>
        <td><?= $total_present ?></td>
        <td><?= $total_absent ?></td>
        <td><?= $total_late ?></td>
        <td><?= $total_early ?></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 20220524) {



		?>
  <table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Dept</th>
        <th style="text-align:center;" colspan="18">Shift</th>
        <th rowspan="2" colspan="3">Total</th>
      </tr>
      <tr>
        <th colspan="3">A</th>
        <th colspan="3">B</th>
        <th colspan="3">B+</th>
        <th colspan="3">C</th>
        <th colspan="3">G</th>
        <th colspan="3">G+</th>
      </tr>
      <tr>
        <th>Male</th>
        <th>female</th>
        <th>Total</th>
        <th>Male</th>
        <th>female</th>
        <th>Total</th>
        <th>Male</th>
        <th>female</th>
        <th>Total</th>
        <th>Male</th>
        <th>female</th>
        <th>Total</th>
        <th>Male</th>
        <th>female</th>
        <th>Total</th>
        <th>Male</th>
        <th>female</th>
        <th>Total</th>
        <th>Male</th>
        <th>female</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?

					if ($_POST['PBI_ID'] != '') {
						$pbi_con = " and p.PBI_CODE='" . $_POST['PBI_ID'] . "' ";
					}





					if ($_POST['year'] != '') {

						$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';

						$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
					}

					$now = strtotime($_POST['tdate']);

					$your_date = strtotime($_POST['fdate']);

					$datediff = $now - $your_date;



					$days = round($datediff / (60 * 60 * 24));



					$date_con = " and l.xdate between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "' ";



					$leave_sql = "select d.DEPT_DESC,d.DEPT_ID, count(a.PBI_ID) as total_employee,count(s.id) as present,sum(s.final_late_status) as late ,sum(s.final_early_status) early_out from personnel_basic_info a left join department d on d.DEPT_ID=a.DEPT_ID left join hrm_att_summary s on s.emp_id=a.PBI_ID and s.att_date between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "'  where 1 " . $con . " group by a.DEPT_ID";



					$leave_query = db_query($leave_sql);





					while ($data_leave = mysqli_fetch_object($leave_query)) {

						$total_employee = find_a_field('personnel_basic_info', 'count(PBI_ID)', 'DEPT_ID="' . $data_leave->DEPT_ID . '"');

					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $data_leave->DEPT_DESC ?></td>
        <td><?= $a_male = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=6 and p.PBI_ID=s.emp_id and p.PBI_SEX="Male" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . ' ') ?></td>
        <td><?= $a_female = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=6 and p.PBI_ID=s.emp_id and p.PBI_SEX="Female" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . '') ?></td>
        <td><?= $a_total = $a_male + $a_female; ?></td>
        <td><?= $b_male = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=9 and p.PBI_ID=s.emp_id and p.PBI_SEX="Male" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . '') ?></td>
        <td><?= $b_female = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=9 and p.PBI_ID=s.emp_id and p.PBI_SEX="Female" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . '') ?></td>
        <td><?= $b_total = $b_male + $b_female; ?></td>
        <td><?= $b_p_male = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=10 and p.PBI_ID=s.emp_id and p.PBI_SEX="Male" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . '') ?></td>
        <td><?= $b_p_female = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=10 and p.PBI_ID=s.emp_id and p.PBI_SEX="Female" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . '') ?></td>
        <td><?= $b_p_total = $b_p_male + $b_p_female; ?></td>
        <td><?= $c_male = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=11 and p.PBI_ID=s.emp_id and p.PBI_SEX="Male" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . '') ?></td>
        <td><?= $c_female = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=11 and p.PBI_ID=s.emp_id and p.PBI_SEX="Female" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . '') ?></td>
        <td><?= $c_total = $c_male + $c_female; ?></td>
        <td><?= $g_male = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=7 and p.PBI_ID=s.emp_id and p.PBI_SEX="Male" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . '') ?></td>
        <td><?= $g_female = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=7 and p.PBI_ID=s.emp_id and p.PBI_SEX="Female" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . '') ?></td>
        <td><?= $g_total = $g_male + $g_female; ?></td>
        <td><?= $g_p_male = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=8 and p.PBI_ID=s.emp_id and p.PBI_SEX="Male" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . '') ?></td>
        <td><?= $g_p_female = find_a_field('hrm_att_summary s,personnel_basic_info p', 'count(s.id)', ' s.att_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '" and s.sch_id=8 and p.PBI_ID=s.emp_id and p.PBI_SEX="Female" and leave_type!="Full" and p.DEPT_ID=' . $data_leave->DEPT_ID . '') ?></td>
        <td><?= $g_p_total = $g_p_male + $g_p_female; ?></td>
        <td><?= $total_male = $a_male + $b_male + $b_p_male + $c_male + $g_male + $g_p_male; ?></td>
        <td><?= $total_female = $a_female + $b_female + $b_p_female + $c_female + $g_female + $g_p_female; ?></td>
        <td><?= $grand_total = $total_male + $total_female; ?></td>
      </tr>
      <?

						$total_emp += $total_employee;

						$total_present += $data_leave->present;

						$total_absent += $total_employee - $data_leave->present;

						$total_late += $data_leave->late;

						$total_early += $data_leave->early_out;
					} ?>
      <?php /*?><tr>

 <td colspan="2"><strong>Total</strong></td>

 <td><?=$total_emp?></td>

 <td><?=$total_present?></td>

 <td><?=$total_absent?></td>

 <td><?=$total_late?></td>

 <td><?=$total_early?></td>

</tr><?php */ ?>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?

		} elseif ($_POST['report'] == 995) {

		?>
  <table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"> <?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="2">S/L</th>
        <th rowspan="2">EMP ID</th>
        <th rowspan="2">Full Name</th>
        <th rowspan="2">Department</th>
        <th colspan="2"> <div align="center">Leave Availed</div></th>
        <th colspan="7"> <div align="center">Leave Types (AVAIL)</div></th>
        <th colspan="6"> <div align="center">Leave Summary (BALANCE)</div></th>
        <th rowspan="2">Total Leave</th>
        <th colspan="3"> <div align="center">Leave Status</div></th>
      </tr>
      <tr>
        <th>Full</th>
        <th>Half</th>
       
        <th>(CL)</th>
        <th>(SL)</th>
        <th>(AL)</th>
        <th>(ML)</th>
        <th>(MLV)</th>
        <th>(PL)</th>
        <th>(LWP)</th>
        <th>(CL)</th>
        <th>(SL)</th>
        <th>(AL)</th>
        <th>(ML)</th>
        <th>(MLV)</th>
        <th>(PL)</th>
        <th>Entitlement</th>
        <th>Availed</th>
        <th>Balance</th>
      </tr>
    </thead>
    <tbody>
<?php
if ($_POST['year'] > 0) {
    $year = $_POST['year'];
    $startDate = $_POST['fdate'];
    $endDate = $_POST['tdate'];

    if ($_POST['PBI_ORG'] != '')
        $orgcon = ' and a.PBI_ORG = "' . $_POST['PBI_ORG'] . '"';
		
	 if ($_POST['PBI_IDD'] != '')
        $ncon = ' and a.PBI_ID = "' . $_POST['PBI_IDD'] . '"';
		
	  if ($_POST['PBI_NAME'] != '')
        $ncon = ' and a.PBI_NAME = "' . $_POST['PBI_NAME'] . '"';		

      $leave_sql = "SELECT a.PBI_ID,a.PBI_CODE,a.PBI_NAME as Employee_Name,
        (select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as department,
        a.PBI_DOJ as joining_date  
        FROM personnel_basic_info a 
        WHERE PBI_JOB_STATUS='In Service' " . $con.$ncon . $orgcon . " 
        ORDER BY a.PBI_ID ASC";

    $leave_query = db_query($leave_sql);
    $i = 0;
	
	

    while ($data_leave = mysqli_fetch_object($leave_query)) {
	
	
	$leave_rule_check_in = find_all_field('hrm_leave_rull_manage_individual', '', 'PBI_ID="'.$data_leave->PBI_ID.'"');
	
	if($leave_rule_check_in->PBI_ID>0){
		
	$leave_rule_in = find_all_field('hrm_leave_rull_manage_individual', '', 'PBI_ID="'.$data_leave->PBI_ID.'"');    
		
	}else{
	
	$leave_rule_in = find_all_field('hrm_leave_rull_manage', '', '1');    
		
		
	}
	
	$daynamic_year = $_POST['selected_year'] ?? date('Y'); 
	$current_s_date = "$daynamic_year-01-01"; 
	//$g_e_date = "$daynamic_year-12-31";



	
	
	  $joiningdate = $data_leave->joining_date;
	  $year_e_datee = date('Y-12-31');
	  $g_e_datee = date('Y-m-d');
      $start = strtotime($joiningdate);
      $end = strtotime($g_e_datee);
	  $current_y_end = strtotime($year_e_datee);
	  
	   $days_between_current_year = ceil(abs($start - $current_y_end) / 86400);
	  
       $days_between = ceil(abs($start - $end) / 86400);
	   
	    $joiningYear = date('Y', strtotime($joiningdate));
	    $currentYear = date('Y');
		
		
		
		 if ($joiningYear < $currentYear && $days_between >= 365) {
	   
        $total_casual = $leave_rule_in->CL;
        $total_MED = $leave_rule_in->MED;
        $total_ML = $leave_rule_in->ML;
		$total_HL = $leave_rule_in->HL;
		$total_MTR = $leave_rule_in->MTR;
		$total_ANU = $total_al_allocated;
		
	   }elseif($joiningYear < $currentYear && $days_between < 365){
	   
	   $total_casual = $leave_rule_in->CL;
       $total_MED = $leave_rule_in->MED;
       $total_ML = $leave_rule_in->ML;
	   $total_HL = $leave_rule_in->HL;
	   $total_MTR = $leave_rule_in->MTR;
	  // $total_ANU = $annual_leave->BALANCE+$final_annual_earnn; //roundToQuarter($annual_leave / 18);
	   
      } else {

        $total_casual =  roundToQuarter($leave_rule_in->CL / 360 * $days_between_current_year);
        $total_MED =  roundToQuarter($leave_rule_in->MED / 360 * $days_between_current_year);
        $total_ANU =  0; //roundToQuarter($annual_leave / 18);
        $total_ML = roundToQuarter($leave_rule_in->ML / 360 * $days_between_current_year);
      }
      //""""""""""""""""""""" END DYNAMIC BALANCE CHACKEr """""""""""""""""""
	  
	  
	  
	  
	   $tot_leave_balance = $total_casual + $total_MED +$total_ANU;
	  
        $total_full_leave = find_a_field('hrm_leave_info', 'sum(total_days)', 'half_or_full="Full" and type!=4 and 
            PBI_ID="' . $data_leave->PBI_ID . '" and s_date>="' . $startDate . '" and e_date<="' . $endDate . '" ');
        
        $total_half_leave = find_a_field('hrm_leave_info', 'sum(total_days)', 'half_or_full!="Full" and type!="Adjust Leave" and 
            PBI_ID="' . $data_leave->PBI_ID . '" and s_date>="' . $startDate . '" and e_date<="' . $endDate . '" ');
			
			
			
	    $grand_total_full_leave = find_a_field('hrm_leave_info', 'sum(total_days)', 'half_or_full="Full" and type!=4 and 
            PBI_ID="' . $data_leave->PBI_ID . '" and s_date>="' . $current_s_date . '" and e_date<="' . $endDate . '" ');
        
        $grand_total_half_leave = find_a_field('hrm_leave_info', 'sum(total_days)', 'half_or_full!="Full" and type!="Adjust Leave" and 
            PBI_ID="' . $data_leave->PBI_ID . '" and s_date>="' . $current_s_date . '" and e_date<="' . $endDate . '" ');
			
			

        $leave_late = 0; // adjust if needed

        $total_leave = $total_full_leave + $total_half_leave + $leave_late;

        if ($total_leave > 0) {
            $total_days = (new DateTime($data_leave->joining_date))->diff(new DateTime($_POST['tdate']))->days;
?>
<tr>
    <td><?= ++$i; ?></td>
    <td><?= $data_leave->PBI_CODE ?></td>
    <td><?= $data_leave->Employee_Name ?></td>
    <td><?= $data_leave->department ?></td>
    <td><?= $total_full_leave ?></td>
    <td><?= $total_half_leave ?></td>
    <td><?= $cl = find_a_field('hrm_leave_info', 'sum(total_days)', 'half_or_full="Full" and type=1 and PBI_ID="' . $data_leave->PBI_ID . '" and s_date>="' . $startDate . '" and e_date<="' . $endDate . '" ') ?></td>
    <td><?= $sl = find_a_field('hrm_leave_info', 'sum(total_days)', 'half_or_full="Full" and type=2 and PBI_ID="' . $data_leave->PBI_ID . '" and s_date>="' . $startDate . '" and e_date<="' . $endDate . '" ') ?></td>
    <td><?= $al = find_a_field('hrm_leave_info', 'sum(total_days)', 'half_or_full="Full" and type=3 and PBI_ID="' . $data_leave->PBI_ID . '" and s_date>="' . $startDate . '" and e_date<="' . $endDate . '" ') ?></td>
    <td><?= $ml = find_a_field('hrm_leave_info', 'sum(total_days)', 'half_or_full="Full" and type=4 and PBI_ID="' . $data_leave->PBI_ID . '" and s_date>="' . $startDate . '" and e_date<="' . $endDate . '" ') ?></td>
    <td><?= $mlv = find_a_field('hrm_leave_info', 'sum(total_days)', 'half_or_full="Full" and type=5 and PBI_ID="' . $data_leave->PBI_ID . '" and s_date>="' . $startDate . '" and e_date<="' . $endDate . '" ') ?></td>
    <td><?= $pl = find_a_field('hrm_leave_info', 'sum(total_days)', 'half_or_full="Full" and type=6 and PBI_ID="' . $data_leave->PBI_ID . '" and s_date>="' . $startDate . '" and e_date<="' . $endDate . '" ') ?></td>
    <td><?= $lwp = find_a_field('hrm_leave_info', 'sum(total_days)', 'half_or_full="Full" and type=9 and PBI_ID="' . $data_leave->PBI_ID . '" and s_date>="' . $startDate . '" and e_date<="' . $endDate . '" ') ?></td>

    <td><?= ($cl_bl = find_a_field('hrm_leave_rull_manage', 'CL', 'year="'.$year.'"')) - $cl > 0 ? $cl_bl - $cl : '' ?></td>
    <td><?= ($sl_bl = find_a_field('hrm_leave_rull_manage', 'MED', 'year="'.$year.'"')) - $sl > 0 ? $sl_bl - $sl : '' ?></td>
    <td><?= ($al_bl = find_a_field('hrm_leave_rull_manage', 'ANU', 'year="'.$year.'"')) - $al > 0 ? $al_bl - $al : '' ?></td>
    <td><?= ($ml_bl = find_a_field('hrm_leave_rull_manage', 'sum(ML)', 'year="'.$year.'"')) - $ml > 0 ? $ml_bl - $ml : '' ?></td>
    <td><?= ($mlv_bl = find_a_field('hrm_leave_rull_manage', 'sum(MLV)', 'year="'.$year.'"')) - $mlv > 0 ? $mlv_bl - $mlv : '' ?></td>
    <td><?= ($pl_bl = find_a_field('hrm_leave_rull_manage', 'sum(MLV)', 'year="'.$year.'"')) - $pl > 0 ? $pl_bl - $pl : '' ?></td>

    <td><?= $total_leave; ?></td>
    <td><?= $entitlement = $tot_leave_balance; // find_a_field('hrm_leave_rull_manage', 'sum(CL+MED+ANU+MTR+PL)', 'year="'.$year.'"'); ?></td>
    <td><?= $availed = $grand_total_full_leave; ?></td>
    <td><?=$balance = $tot_leave_balance - $availed;?></td>
</tr>
<?php
        } // if total_leave > 0
    } // while loop
} // if year selected
?>
</tbody>

  </table>
  <style type="text/css">
				#new td {



					border-bottom: 0px solid #000000;

					border-left: 0px solid #000000;

					border-right: 0px solid #000000;

					text-align: center;

					padding: 2px 10px;


				}
			</style>
  <br />
  <!-- **************  IN PUNCH MISSIG REPORT *******************-->
  <?
		} elseif ($_POST['report'] == 998) {
		?>
  <table id="ExportTable" width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>EMP_ID</th>
        <th>Full Name</th>
        <th>Department</th>
        <th>From </th>
        <th>To</th>
        <th>IN Punch Missing Days</th>
      </tr>
    </thead>
    <tbody>
      <?

					if ($_POST['PBI_ID'] != '') {
						$pbi_con = " and p.PBI_ID='" . $_POST['PBI_ID'] . "' ";
					}
					if ($_POST['PBI_ORG'] != '') {
						$org_con = " and a.PBI_ORG='" . $_POST['PBI_ORG'] . "' ";
					}
					if ($_POST['year'] != '') {

						$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';
						$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
					}


					$date_con = " and l.att_date between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "' ";


					$leave_sql = "SELECT l.*,a.PBI_NAME as Employee_Name,a.PBI_CODE,(select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as department
 FROM hrm_att_summary l, personnel_basic_info a where   a.PBI_ID=l.emp_id " . $pbi_con . $org_con . $date_con . $con . " group by l.emp_id order by a.DEPT_ID";


					$leave_query = db_query($leave_sql);
					while ($data_leave = mysqli_fetch_object($leave_query)) {

						$total_late_days = find_a_field('hrm_att_summary', 'count(id)', 'emp_id="' . $data_leave->emp_id . '" and TIME(in_time) > "12:00:00" and
 att_date between "' . $_POST['fdate'] . '" and  "' . $_POST['tdate'] . '"');


						if ($total_late_days > 0) {

					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $data_leave->PBI_CODE ?></td>
        <td><?= $data_leave->Employee_Name ?></td>
        <td><?= $data_leave->department ?></td>
        <td><?= $_POST['fdate'] ?></td>
        <td><?= $_POST['tdate'] ?></td>
        <td align="right"><?= $total_late_days ?></td>
      </tr>
      <?
							$grand_tot_leave_days = $grand_tot_leave_days + $total_late_days;
						}
					}  ?>
      <tr>
        <td colspan="6"><div align="right"><b> Total Out Punch Missing Days</b></div></td>
        <td align="right"><b>
          <?= $grand_tot_leave_days ?>
          </b></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {



					border-bottom: 0px solid #000000;



					border-left: 0px solid #000000;



					border-right: 0px solid #000000;



					text-align: center;



					padding: 2px 10px;







				}
			</style>
  <br />
  <!-- ************** Monthly Absent REPORT *******************-->
  <?
		} elseif ($_POST['report'] == 999) {

			// FUnction for  daynamic Total friday
			function dayCount($from, $to, $day = 5)
			{
				$from = new DateTime($from);
				$to   = new DateTime($to);
				$wF = $from->format('w');
				$wT = $to->format('w');
				if ($wF < $wT)       $isExtraDay = $day >= $wF && $day <= $wT;
				else if ($wF == $wT) $isExtraDay = $wF == $day;
				else   $isExtraDay = $day >= $wF || $day <= $wT;
				return floor($from->diff($to)->days / 7) + $isExtraDay;
			}


		?>
  <table id="ExportTable" width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>EMP_ID</th>
        <th>Full Name</th>
        <th>Department</th>
        <th>From </th>
        <th>To</th>
        <th>Absent Days</th>
      </tr>
    </thead>
    <tbody>
      <?

					if ($_POST['PBI_ID'] != '') {
						$pbi_con = " and p.PBI_ID='" . $_POST['PBI_ID'] . "' ";
					}
					if ($_POST['PBI_ORG'] != '') {
						$org_con = " and a.PBI_ORG='" . $_POST['PBI_ORG'] . "' ";
					}
					if ($_POST['year'] != '') {

						$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';
						$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
					}


					$date_con = " and l.att_date between '" . $_POST['fdate'] . "' and '" . $_POST['tdate'] . "' ";


					$leave_sql = "SELECT l.*,a.PBI_NAME as Employee_Name,a.PBI_CODE,(select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as department
	 FROM hrm_att_summary l, personnel_basic_info a where   a.PBI_ID=l.emp_id " . $pbi_con . $org_con . $date_con . $con . " group by l.emp_id order by a.DEPT_ID";


					$leave_query = db_query($leave_sql);
					while ($data_leave = mysqli_fetch_object($leave_query)) {

						$holy = find_a_field('salary_holy_day', 'holy_day', 'holy_day between "' . $_POST['fdate'] . '" and  "' . $_POST['tdate'] . '"');


						$total_pre_days = find_a_field('hrm_att_summary', 'count(id)', 'emp_id="' . $data_leave->emp_id . '" and dayname != "Friday" and
	 att_date between "' . $_POST['fdate'] . '" and  "' . $_POST['tdate'] . '" and att_date!="' . $holy . '"');


						$start = strtotime($_POST['fdate']);
						$end = strtotime($_POST['tdate']);

						$days_between = ceil(abs($start - $end) / 86400);
						$total_days = $days_between + 1;

						$holyday = find_a_field('salary_holy_day', 'count(id)', 'holy_day between "' . $_POST['fdate'] . '" and  "' . $_POST['tdate'] . '"');
						$friday_count =  dayCount($_POST['fdate'], $_POST['tdate'], 5);

						$total_absent_count = ($total_days - ($total_pre_days + $holyday + $friday_count));

						if ($total_absent_count > 0) {

					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $data_leave->PBI_CODE ?></td>
        <td><?= $data_leave->Employee_Name ?></td>
        <td><?= $data_leave->department ?></td>
        <td><?= $_POST['fdate'] ?></td>
        <td><?= $_POST['tdate'] ?></td>
        <td align="right"><?= $total_absent_count ?></td>
      </tr>
      <?
							$grand_tot_leave_days = $grand_tot_leave_days + $total_absent_count;
						}
					}  ?>
      <tr>
        <td colspan="6"><div align="right"><b> Total Absent Days</b></div></td>
        <td align="right"><b>
          <?= $grand_tot_leave_days ?>
          </b></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {



					border-bottom: 0px solid #000000;



					border-left: 0px solid #000000;



					border-right: 0px solid #000000;



					text-align: center;



					padding: 2px 10px;







				}
			</style>
  <br />
  <? } elseif ($_POST['report'] == 1000) { ?>
  <style>
				table {
					border-collapse: collapse;
					width: 100%;
				}

				#heading {
					height: 50px;
					text-align: center;
					font-size: 20px;
					background-color: #BDD7EE;
				}

				.subTotalDig {
					background-color: #DBDBDB;
					color: #0099FF;
				}

				.totaldig {
					background-color: #33FFCC;
				}

				@media print {
					body {
						zoom: 80%;
					}
				}
			</style>
  <table style="margin-top: 10px;">
    <tr>
      <th colspan="10" id="heading">Company: Netrakona Accessories Ltd. </th>
    </tr>
    <tr>
      <td colspan="10"><table width="100%" border="1">
          <tr>
            <th width="16%" scope="col">Cost Center </th>
            <th width="13%" scope="col">Department</th>
            <th width="11%" scope="col">Section</th>
            <th width="11%" scope="col">Class</th>
            <th width="11%" scope="col">Budgeted</th>
            <th width="8%" scope="col">Actual</th>
            <th width="9%" scope="col">Present</th>
            <th width="8%" scope="col">Absent</th>
            <th width="7%" scope="col">Leave</th>
            <th width="6%" scope="col">Late</th>
            <th width="6%" scope="col">Working Hour</th>
          </tr>
          <?php 
							
							
							if($_POST['PBI_CODE']!="") $codeConn = " and a.PBI_CODE='".$_POST['PBI_CODE']."'";
                            if($_POST['PBI_IDD']!="") $idConn = " and a.PBI_ID ='".$_POST['PBI_IDD']."'";
                          
                            if($_POST['PBI_NAME']!="") $NameConn = " and a.PBI_NAME='".$_POST['PBI_NAME']."'";
                            if($_POST['DESG_ID']>0) $desgConn = " and a.DESG_ID='".$_POST['DESG_ID']."'";
                            if($_POST['DEPT_ID']>0) $depConn = " and t.department='".$_POST['DEPT_ID']."'";
                            if($_POST['PBI_SEX']!="") $genderConn = " and a.PBI_SEX='".$_POST['PBI_SEX']."'";
                            if($_POST['grade']>0) $gradeConn = " and a.grade='".$_POST['grade']."'";  
                            if($_POST['work_station']>0) $work_station = " and a.PBI_WORK_STATION='".$_POST['work_station']."'";  
                            
                            
                            
                            if($_POST['PBI_RELIGION']!="") $ReligionConn = " and a.PBI_RELIGION='".$_POST['PBI_RELIGION']."'";
                            if($_POST['PBI_ORG']>0) $OrgConn = " and t.pbi_organization='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and t.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
                            
                            if($_POST['section']>0) $secConn = " and t.section='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and t.job_location='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['cost_center']>0) $CostConn = " and p.cost_center='".$_POST['cost_center']."'";
                     
                            
                            if($_POST['class']>0) $classConn = " and t.hrm_class='".$_POST['class']."'";
                            if($_POST['line']>0) $lineConn = " and a.line='".$_POST['line']."'";
                            if($_POST['incharge_id']>0) $inchargeConn = " and a.incharge_id='".$_POST['incharge_id']."'";
							
                            if($_POST['DOJ']>0) $DOJConn = " and a.PBI_DOJ='".$_POST['DOJ']."'";
                            
						  	if($_POST['shedule']>0) $shiftConn = " and a.define_schedule ='".$_POST['shedule']."'";
							
		
							
							
				 $dept_sql = "select  p.cost_center, dept.center_name 
					 
				from personnel_basic_info p, hrm_cost_center dept 

				where p.cost_center=dept.id  
			
				 " .$job_con . $date_con . $NameConn . $IDConn . $codeConn .
						$con . $org . $CostConn . $dept . $section . $job_loc . $gender .
						$grade . $work . $level . $class . $religion . $incharge ."
				
			      group by p.cost_center order by p.cost_center asc";

					$dept_qry = db_query($dept_sql);

					while ($dept_data = mysqli_fetch_object($dept_qry)) {
					
	
					//___________Department		
							
			    $sqld = 'select p.DEPT_ID,h.DEPT_DESC
				

                from  personnel_basic_info p, department h

                where  p.cost_center="'.$dept_data->cost_center.'" and p.DEPT_ID=h.DEPT_ID 
				
				' . $job_con . $date_con . $NameConn . $IDConn . $codeConn .
						$con . $org . $cost_center . $dept . $section . $job_loc . $gender .
						$grade . $work . $level . $class . $religion . $incharge . ' 
				
				

                group by p.DEPT_ID order by p.DEPT_ID';

                $queryd = db_query($sqld);

                while ($data = mysqli_fetch_object($queryd)) {
				
				
				
				
				$dep_Present = find_a_field('hrm_att_summary a,personnel_basic_info b','count(a.id)','a.emp_id=b.PBI_ID and 
			
			    b.cost_center="'.$dept_data->cost_center.'" and 
				
				b.DEPT_ID="'.$data->DEPT_ID.'" and  a.present=1 and   
				
				a.att_date = "'.$_POST['fdate'].'" group by b.DEPT_ID ');
				
				
				
				$dep_leave = find_a_field('hrm_att_summary a,personnel_basic_info b','count(a.emp_id)','a.emp_id=b.PBI_ID and 
			
			    b.cost_center="'.$dept_data->cost_center.'" and 
				
				b.DEPT_ID="'.$data->DEPT_ID.'" and 
				a.leave_id>0 and  a.att_date = "'.$_POST['fdate'].'" group by b.DEPT_ID ');
				
				
			    $dep_late = find_a_field('hrm_att_summary a,personnel_basic_info b','count(a.emp_id)','a.emp_id=b.PBI_ID and 
			
			    b.cost_center="'.$dept_data->cost_center.'" and 
				
				b.DEPT_ID="'.$data->DEPT_ID.'" and  a.final_late_status>0 and   
				
				a.att_date = "'.$_POST['fdate'].'" group by b.DEPT_ID ');
				
				
				$dep_wo_ho = find_a_field('hrm_att_summary a,personnel_basic_info b','sum(a.working_hours)','a.emp_id=b.PBI_ID and 
			
			    b.cost_center="'.$dept_data->cost_center.'" and 
				
				b.DEPT_ID="'.$data->DEPT_ID.'" and present=1 and   
				
				a.att_date = "'.$_POST['fdate'].'" group by b.DEPT_ID ');
				
				
				
				//---------- Section --------
				
			    $section_sql = 'select p.section,h.sec_name
				

                from  personnel_basic_info p, PBI_Section h

                where  p.DEPT_ID="'.$data->DEPT_ID.'" and p.section=h.sec_id 
				
				' . $job_con . $date_con . $NameConn . $IDConn . $codeConn .
						$con . $org . $cost_center . $dept . $section . $job_loc . $gender .
						$grade . $work . $level . $class . $religion . $incharge . ' 
				
				

                group by p.section order by h.sec_name';

                $section_query = db_query($section_sql);

                while ($sec_data = mysqli_fetch_object($section_query)) {
				
				
				//---------- Class  --------
				
				//count(p.PBI_ID) as total_emp
				
				 $class_sql = 'select c.class_name ,p.class , count(p.PBI_ID) as total_emp
				
				from  
				
				personnel_basic_info p, hrm_class c 

                where 
				
				p.cost_center="'.$dept_data->cost_center.'" and 
				
				p.DEPT_ID="'.$data->DEPT_ID.'" and
				p.section="'.$sec_data->section.'" and  
				
			    p.class=c.id 
                
				'. $job_con . $date_con . $NameConn . $IDConn . $codeConn .
				  $con.$org.$cost_center.$dept.$section.$job_loc.$gender.$grade . $work . $level . $class . $religion . $incharge . ' 
				
				

                GROUP BY p.class ';
				
				

                $class_query = db_query($class_sql);

                while ($class_data = mysqli_fetch_object($class_query)) {
				
				
				 $Present = find_a_field('hrm_att_summary a,personnel_basic_info b','count(a.id)','a.emp_id=b.PBI_ID and 
			
			    b.cost_center="'.$dept_data->cost_center.'" and 
				
				b.DEPT_ID="'.$data->DEPT_ID.'" and 
				
				b.section="'.$sec_data->section.'" and 
				b.class="'.$class_data->class.'" and  a.present=1 and   
				
				a.att_date = "'.$_POST['fdate'].'" group by b.class ');
				
				
				
			   $leave = find_a_field('hrm_att_summary a,personnel_basic_info b','count(a.emp_id)','a.emp_id=b.PBI_ID and 
			
			    b.cost_center="'.$dept_data->cost_center.'" and 
				
				b.DEPT_ID="'.$data->DEPT_ID.'" and 
				
				b.section="'.$sec_data->section.'" and 
				b.class="'.$class_data->class.'" and  a.leave_id>0 and   
				
				a.att_date = "'.$_POST['fdate'].'" group by b.class ');
				
				
			    $late = find_a_field('hrm_att_summary a,personnel_basic_info b','count(a.emp_id)','a.emp_id=b.PBI_ID and 
			
			    b.cost_center="'.$dept_data->cost_center.'" and 
				
				b.DEPT_ID="'.$data->DEPT_ID.'" and 
				
				b.section="'.$sec_data->section.'" and 
				b.class="'.$class_data->class.'" and  a.final_late_status>0 and   
				
				a.att_date = "'.$_POST['fdate'].'" group by b.class ');
				
				
				 $wo_ho = find_a_field('hrm_att_summary a,personnel_basic_info b','sum(a.working_hours)','a.emp_id=b.PBI_ID and 
			
			    b.cost_center="'.$dept_data->cost_center.'" and 
				
				b.DEPT_ID="'.$data->DEPT_ID.'" and 
				
				b.section="'.$sec_data->section.'" and 
				b.class="'.$class_data->class.'" and present=1 and   
				
				a.att_date = "'.$_POST['fdate'].'" group by b.class ');

							
							 ?>
          <tr>
            <td><div align="center"><?=$dept_data->center_name;?></div></td>
            <td><div align="center"><?=$data->DEPT_DESC;?></div></td>
            <td><div align="center"><?=$sec_data->sec_name;?></div></td>
            <td><div align="center"><?=$class_data->class_name;?></div></td>
			<td><div align="center">1</div></td>
            <td><div align="center"><?=$class_data->total_emp;?></div></td>
            <td><div align="center"><?=$Present; $total_present +=$Present;?></div></td>
            <td><div align="center"><?=($class_data->total_emp-$Present); ?></div></td>
            <td><div align="center"><?=$leave; $total_leave +=$leave;?></div></td>
            <td><div align="center"><?=$late; $total_late +=$late;?></div></td>
            <td><div align="center"><?=$wo_ho; $total_wo_ho +=$wo_ho;?></div></td>
          </tr>
       
	   
          <? } }?>
		  
		  
          <tr class="totaldig">
            <td colspan="3"><div align="center"><strong>Total</strong></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"><strong><?=$data->dep_total_emp;?></strong></div></td>
            <td><div align="center"><strong><?=$dep_Present;?></strong></div></td>
            <td><div align="center"><strong><?=($data->dep_total_emp-$dep_Present); ?></strong></div></td>
            <td><div align="center"><strong><?=$dep_leave;?></strong></div></td>
            <td><div align="center"><strong><?=$dep_late;?></strong></div></td>
            <td><div align="center"><strong><?=$dep_wo_ho;?></strong></div></td>
          </tr>
          <?  }}?>
		  
		  
        </table></td>
    </tr>
    <tr>
      <td colspan="10"><table style="margin-top:10px;" width="100%" border="1">
          <tr class="totaldig">
            <td rowspan="8"><div align="center"><strong>Grand Total </strong></div>
              <div align="center"></div>
              <div align="center"></div></td>
            <td width="11%"><div align="center"></div></td>
            <td width="11%"><div align="center"></div></td>
            <td width="8%"><div align="center"><strong>152</strong></div></td>
            <td width="9%"><div align="center"><strong>124</strong></div></td>
            <td width="8%"><div align="center"><strong>20</strong></div></td>
            <td width="7%"><div align="center"><strong>8</strong></div></td>
            <td width="6%"><div align="center"><strong>12</strong></div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <? } elseif ($_POST['report'] == 19191) { ?>
  <table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>EMP_ID</th>
        <th>Full Name</th>
        <th>Department</th>
        <th>Schedule Date </th>
        <th>Schedule Define</th>
        <th>In Time</th>
        <th>Out Time</th>
      </tr>
    </thead>
    <tbody>
      <?

					if ($_POST['PBI_ID'] != '') {
						$pbi_con = " and p.PBI_CODE='" . $_POST['PBI_ID'] . "' ";
					}



					if ($_POST['department'] > 0) {
						$pbi_con .= " and p.DEPT_ID='" . $_POST['department'] . "' ";
					}





					$startDate = $_POST['start_date'];

					$endDate = $_POST['end_date'];





					$roster_sql = "select h.*,s.schedule_name,s.office_start_time,s.office_end_time,p.PBI_CODE,p.PBI_NAME,p.PBI_DEPARTMENT from hrm_roster_allocation h, personnel_basic_info p, hrm_schedule_info s where s.id=h.shedule_1 and p.PBI_ID=h.PBI_ID and h.roster_date between '" . $startDate . "' and '" . $endDate . "' " . $pbi_con . " ";



					$roster_query = db_query($roster_sql);





					while ($roster = mysqli_fetch_object($roster_query)) {



					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= $roster->PBI_CODE ?></td>
        <td><?= $roster->PBI_NAME ?></td>
        <td><?= $roster->PBI_DEPARTMENT ?></td>
        <td><?= $roster->roster_date ?></td>
        <td><?= $roster->schedule_name ?></td>
        <td><?= $roster->office_start_time ?></td>
        <td><?= $roster->office_end_time ?></td>
      </tr>
      <? } ?>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 62222) {















		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="21"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>EMP_ID</th>
        <th>Full Name</th>
        <th>Department</th>
        <th>Designation</th>
        <th>Leave Date</th>
        <th> <div align="center">Leave Type</div></th>
        <th> <div align="center">Leave Days</div></th>
      </tr>
    </thead>
    <tbody>
      <?















					if ($_POST['PBI_ID'] != '') {
						$pbi_con = " and p.PBI_ID='" . $_POST['PBI_ID'] . "' ";
					}















					if ($_POST['year'] != '') {







						$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';



						$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
					}









					$date_con = " and l.s_date>='" . $_POST['fdate'] . "' and l.e_date<='" . $_POST['tdate'] . "' ";























					$leave_sql = "SELECT l.*,a.PBI_NAME as Employee_Name,(select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as dept,(select DESG_DESC from designation where DESG_ID=a.DESG_ID) as designation  FROM hrm_leave_info l, personnel_basic_info a where   a.PBI_ID=l.PBI_ID and l.half_or_full='Half' " . $con . $pbi_con . $date_con . " ";































					$leave_query = db_query($leave_sql);















					while ($data_leave = mysqli_fetch_object($leave_query)) {































					?>
      <tr>
        <td><?= ++$i; ?></td>
        <td><?= find_a_field('personnel_basic_info', 'PBI_CODE', 'PBI_ID=' . $data_leave->PBI_ID); ?></td>
        <td><?= $data_leave->Employee_Name ?></td>
        <td><?= $data_leave->dept ?></td>
        <td><?= $data_leave->designation ?></td>
        <td><?= $data_leave->s_date ?></td>
        <td><?= $data_leave->leave_slot ?></td>
        <td><?= $data_leave->total_days ?></td>
      </tr>
      <? $grand_tot_leave = $grand_tot_leave + $data_leave->total_days;
					}  ?>
      <tr>
        <td colspan="7"><div align="right"><b> Total Days</b></div></td>
        <td><b>
          <?= $grand_tot_leave ?>
          </b></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 6655) {







			$report = "Yearly_Salary_Statement";























			$next_year = $_POST['year'] - 1;















		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <td style="border:0px;" colspan="28"><?= $str ?></td>
      </tr>
      <tr>
        <td style="border:0px;" colspan="28"><div align="center" style="font-size:20px;"> </div></td>
      </tr>
      <tr>
        <th rowspan="2"> <div align="center">SL </div></th>
        <th rowspan="2"> <div align="center">Member ID </div></th>
        <th rowspan="2"> <div align="center">Name </div></th>
        <th rowspan="2"> <div align="center">Designation </div></th>
        <th rowspan="2"> <div align="center">Joining Date </div></th>
        <th rowspan="2"> <div align="center">January<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">February<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">March<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">April<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">May<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">June<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">July<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">August<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">September<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">October<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">November<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">December<br>
            <?= $_POST['year'] ?>
          </div></th>
        <th rowspan="2"> <div align="center">Total</div></th>
      </tr>
    </thead>
    <tbody>
      <?























					if ($_POST['department'] != '')































						$tr_con = ' and p.PBI_DEPARTMENT="' . $_POST['department'] . '"';























					if ($_POST['JOB_LOCATION'] != '')















						$tr_con .= ' and p.JOB_LOCATION="' . $_POST['JOB_LOCATION'] . '"';































					if ($_POST['job_status'] != '')















						$tr_con .= ' and p.PBI_JOB_STATUS="' . $_POST['job_status'] . '"';























					$salary_sql = 'select a.PBI_ID,a.PBI_CODE, a.PBI_NAME,a.PBI_DOJ,(select DESG_DESC from designation where DESG_ID=a.PBI_DESIGNATION) as designation from personnel_basic_info a where 1 ' . $con . ' order by a.PBI_DOJ ';























					$s_query = db_query($salary_sql);























					while ($tf = mysqli_fetch_object($s_query)) {















						$final_sql = 'select sum(pf_deduction) as total_amt from salary_attendence where year="' . $_POST['year'] . '" and PBI_ID="' . $tf->PBI_ID . '" order by pf_deduction desc';























						$final_query = db_query($final_sql);























						while ($final = mysqli_fetch_object($final_query)) {























							if ($final->total_amt > 0) {































					?>
      <tr>
        <td><?= ++$j; ?></td>
        <td><?= $tf->PBI_CODE ?></td>
        <td><?= $tf->PBI_NAME ?></td>
        <td><?= $tf->designation ?></td>
        <td width="6%"><?= date('d-M-Y', strtotime($tf->PBI_DOJ)) ?></td>
        <?php /*?><td><?=$tf->ESSENTIAL_TIN_NO?></td><?php */ ?>
        <?php /*?><td><?=$tf->project?></td><?php */ ?>
        <td align="right"><?= (number_format($jan = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=1 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($jan, 0) : ''; ?></td>
        <td align="right"><?= (number_format($feb = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=2 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($feb, 0) : ''; ?></td>
        <td align="right"><?= (number_format($march = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=3 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($march, 0) : ''; ?></td>
        <td align="right"><?= (number_format($april = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=4 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($april, 0) : ''; ?></td>
        <td align="right"><?= (number_format($may = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=5 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($may, 0) : ''; ?></td>
        <td align="right"><?= (number_format($june = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=6 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($june, 0) : ''; ?></td>
        <td align="right"><?= (number_format($july = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=7 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($july, 0) : ''; ?></td>
        <td align="right"><?= (number_format($august = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=8 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($august, 0) : ''; ?></td>
        <td align="right"><?= (number_format($sept = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=9 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($sept, 0) : ''; ?></td>
        <td align="right"><?= (number_format($oct = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=10 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($oct, 0) : ''; ?></td>
        <td align="right"><?= (number_format($nov = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=11 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($nov, 0) : ''; ?></td>
        <td align="right"><?= (number_format($dec = find_a_field('salary_attendence', 'pf_deduction', 'PBI_ID="' . $tf->PBI_ID . '" and mon=12 and year="' . $_POST['year'] . '" and remarks_details!="hold"'), 0) > 0) ? number_format($dec, 0) : ''; ?></td>
        <td align="right"><?= number_format($tot = $jan + $feb + $march + $april + $may + $june + $july + $august + $sept + $oct + $nov + $dec, 0) ?></td>
      </tr>
      <?















								$jan_total = $jan_total + $jan;































								$feb_total = $feb_total + $feb;































								$march_total = $march_total + $march;























								$april_total = $april_total + $april;























								$may_total = $may_total + $may;























								$june_total = $june_total + $june;























								$july_total = $july_total + $july;























								$august_total = $august_total + $august;































								$sept_total = $sept_total + $sept;































								$oct_total = $oct_total + $oct;























								$nov_total = $nov_total + $nov;























								$dec_total = $dec_total + $dec;































								$grand_total = $grand_total + $tot;
							}
						}
					}















					?>
      <tr>
        <td colspan="5" align="right"><strong>Total</strong></td>
        <td><strong>
          <?= number_format($jan_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($feb_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($march_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($april_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($may_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($june_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($july_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($august_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($sept_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($oct_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($nov_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($dec_total, 0); ?>
          </strong></td>
        <td><strong>
          <?= number_format($grand_total, 0); ?>
          </strong></td>
      </tr>
    </tbody>
  </table>
  <br>
  <br>
  <br>
  <?















		} elseif ($_POST['report'] == 785) {































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="7"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>CODE</th>
        <th>Full Name</th>
        <th>Designation</th>
        <th>Group</th>
        <th><?= $_POST['cash_bank'] ?>
          AC#</th>
        <th>Transfer to
          <?= $_POST['cash_bank'] ?></th>
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















and s.cash_bank="' . $bank . '"















and t.bonus_type=' . $_POST['bonus_type'] . '















and t.year=' . $_POST['year'] . '















and t.bank_paid>0































' . $con . '















group by a.PBI_ID















order by a.PBI_ID';















































					$queryd = db_query($sqld);















					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $data->PBI_ID ?></td>
        <td><?= $data->PBI_NAME ?></td>
        <td><?= $data->PBI_DESIGNATION ?></td>
        <td><?= $data->PBI_GROUP ?></td>
        <td><?= $data->cash ?></td>
        <td><? if ($data->held_up_status == '0') {















									if ($data->cash_bank == $bank) {
										echo number_format($data->bank_paid);















										$total_bank_payment_dbbl = $total_bank_payment_dbbl + $data->bank_paid;
									}
								}































								?></td>
      </tr>
      <?















					}















					?>
      <tr>
        <td colspan="6"><?= convertNumberMhafuz($total_bank_payment_dbbl); ?></td>
        <td><strong><? echo (int)$total_bank_payment_dbbl; ?></strong></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 786) {































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="7"><?= $str ?></th>
      </tr>
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















and s.cash_bank="' . $bank . '"















and t.bonus_type=' . $_POST['bonus_type'] . '















and t.year=' . $_POST['year'] . '















and t.bank_paid>0































' . $con . '















group by a.PBI_ID















order by a.PBI_ID';















































					$queryd = db_query($sqld);















					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $data->PBI_ID ?></td>
        <td><?= $data->PBI_NAME ?></td>
        <td><?= $data->PBI_DESIGNATION ?></td>
        <td><?= $data->PBI_GROUP ?></td>
        <td><?= $data->cash ?></td>
        <td><? if ($data->held_up_status == '0') {















									if ($data->cash_bank == $bank) {
										echo number_format($data->bank_paid);















										$total_bank_payment_dbbl = $total_bank_payment_dbbl + $data->bank_paid;
									}
								}































								?></td>
      </tr>
      <?















					}















					?>
      <tr>
        <td colspan="6"><?= convertNumberMhafuz($total_bank_payment_dbbl); ?></td>
        <td><strong><? echo (int)$total_bank_payment_dbbl; ?></strong></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 7811) {















		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="7"><?= $str ?></th>
      </tr>
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















where t.cooperative_share>0 and d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID ' . $con . ' order by (t.consolidated_salary+t.basic_salary) desc';















					$queryd = db_query($sqld);















					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $data->PBI_ID ?></td>
        <td><?= $data->PBI_NAME ?></td>
        <td><?= $data->PBI_DESIGNATION ?></td>
        <td><?= $data->PBI_GROUP ?></td>
        <td><?= $data->co_operative_code ?></td>
        <td><?= $data->cooperative_share;
								$total += $data->cooperative_share; ?></td>
      </tr>
      <?















					}















					?>
      <tr>
        <td colspan="6"><?= convertNumberMhafuz($total); ?></td>
        <td><? echo $total; ?></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 782) {















		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="8"><?= $str ?></th>
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















where t.pbi_held_up=0 and s.cash_bank="IBBL" and d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID ' . $con . ' order by (t.consolidated_salary+t.basic_salary) desc';















					$queryd = db_query($sqld);















					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><font color="#FFFFFF">'</font>
          <?= $data->cash ?>
        </td>
        <td><?= $data->PBI_ID ?></td>
        <td><?= $data->PBI_NAME ?></td>
        <td><font color="#FFFFFF">'</font>
          <?= $data->cash ?>
        </td>
        <td><?= $data->branch_info ?></td>
        <td>&nbsp;</td>
        <td><? echo number_format($data->bank_paid);
								$total_bank_payment_dbbl = $total_bank_payment_dbbl + $data->bank_paid; ?></td>
      </tr>
      <?















					}















					?>
      <tr>
        <td colspan="5"><?= convertNumberMhafuz($total_bank_payment_dbbl); ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><? echo (int)$total_bank_payment_dbbl; ?></td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 78) // Salary Payroll Report Final















		{











		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="33" align="center"><?= $str ?></th>
      </tr>
    </thead>
  </table>
  <table width="100%" cellspacing="0" cellpadding="2" border="1" id="example">
    <thead>
      <tr>
        <th rowspan="2">S/L</th>
        <th rowspan="2"> <div align="center">Employee ID</div></th>
        <th rowspan="2"> <div align="center">Name</div></th>
        <th rowspan="2"> <div align="center">Concern</div></th>
        <th rowspan="2"> <div align="center">Designation</div></th>
        <th rowspan="2"> <div align="center">Department</div></th>
        <th rowspan="2" nowrap="nowrap"> <div align="center">Joining Date </div></th>
        <th rowspan="2" align="center"> <div align="center">Total Days Works</div></th>
        <th rowspan="2" align="center"> <div align="center">Gross</div></th>
        <th colspan="6"> <div align="center">Salary and Allowance </div></th>
        <th rowspan="2"> <div align="center">Arrear</div></th>
        <th rowspan="2"> <div align="center">Total </div></th>
        <th colspan="8" align="center"> <div align="center">Deduction</div></th>
        <th rowspan="2"> <div align="center">Total Deduction</div></th>
        <th rowspan="2" align="center"> <div align="center">Net Payable Salary</div></th>
        <th rowspan="2"> <div align="center">Salary Given By</div></th>
      </tr>
      <tr>
        <th> <div align="center">Basic</div></th>
        <th> <div align="center">House Rent </div></th>
        <th> <div align="center">Medical</div></th>
        <th> <div align="center">Conveyance</div></th>
        <th> <div align="center">Entertainment</div></th>
        <th> <div align="center">Others</div></th>
        <th> <div align="center">Tax</div></th>
        <th> <div align="center">Provident Fund</div></th>
        <th> <div align="center">PF Loan</div></th>
        <th> <div align="center">Salary Advanced</div></th>
        <th> <div align="center">Absent</div></th>
        <th> <div align="center">Late</div></th>
        <th> <div align="center">Lwp</div></th>
        <th> <div align="center">Others</div></th>
      </tr>
    </thead>
    <tbody>
      <?































					if ($_POST['PBI_ORG'] != '')















						$salaryConn = ' and a.PBI_ORG = "' . $_POST['PBI_ORG'] . '"';











					if ($_POST['branch'] != '')















						$salaryConn .= ' and t.branch=' . $_POST['branch'];











					if ($_POST['GROUP'] != '')















						$salaryConn .= ' and t.dept_group=' . $_POST['GROUP'];















					if ($_POST['job_status'] != '')















						$salaryConn .= ' and a.PBI_JOB_STATUS="' . $_POST['job_status'] . '"';















					$m_s_date = $_POST['year'] . '-' . $_POST['mon'] . '-' . '01';















					$m_e_date = $_POST['year'] . '-' . $_POST['mon'] . '-' . '31';



























					$sqld = 'select t.*, b.gross_salary, a.PBI_ID, a.PBI_NAME, a.PBI_DOJ, (select group_name from user_group where id =a.PBI_ORG) as concern,a.PBI_DESIGNATION as designation,a.PBI_DEPARTMENT as department



from salary_attendence t, personnel_basic_info a, salary_info b



where t.pay>0  and  t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=b.PBI_ID ' . $salaryConn . ' group by t.PBI_ID';







					$queryd = db_query($sqld);







					while ($data = mysqli_fetch_object($queryd)) {































						$m_s_date = $_POST['year'] . '-' . $_POST['mon'] . '-' . '01';































						$m_e_date = $_POST['year'] . '-' . $_POST['mon'] . '-' . '31';































































						//$slq = 'select sum(total_days) from hrm_leave_info where PBI_ID="'.$data->PBI_ID.'" and type=1 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED"';































						$tot_ded = $data->other_deduction + $data->hr_action_amt;















































					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $data->PBI_ID ?></td>
        <td nowrap="nowrap"><?= $data->PBI_NAME ?></td>
        <td nowrap="nowrap"><?= $data->concern ?></td>
        <td nowrap="nowrap"><?= $data->designation ?></td>
        <td nowrap="nowrap"><?= $data->department ?></td>
        <td><?= date('d-M-Y', strtotime($data->PBI_DOJ)) ?></td>
        <td align="center"><?= ($data->pay > 0) ? $data->pay : ''; ?></td>
        <td align="right"><?= ($data->gross_salary > 0) ? $data->gross_salary : '';
												$totGross += $data->gross_salary ?></td>
        <td align="right"><?= ($data->basic_salary > 0) ? $data->basic_salary : '';
												$totBasic += $data->basic_salary ?></td>
        <td align="right"><?= ($data->house_rent > 0) ? $data->house_rent : '';
												$totHouse += $data->house_rent ?></td>
        <td align="right"><?= ($data->medical_allowance > 0) ? $data->medical_allowance : '';
												$totMedical += $data->medical_allowance ?></td>
        <td align="right"><?= ($data->conveyance > 0) ? $data->conveyance : '';
												$totSpecial += $data->conveyance ?></td>
        <td align="right"><?= ($data->entertainment > 0) ? $data->entertainment : '';
												$totEntertain += $data->entertainment ?></td>
        <td align="right"><?= ($data->other_allowance > 0) ? $data->other_allowance : '';
												$totOthers += $data->other_allowance ?></td>
        <td align="right"><?= ($data->salary_arrear > 0) ? $data->salary_arrear : '';
												$totArrear += $data->salary_arrear ?></td>
        <td align="right"><?= ($data->total_salary > 0) ? $data->total_salary : '';
												$totSalary += $data->total_salary ?></td>
        <td align="right"><?= ($data->income_tax > 0) ? $data->income_tax : '';
												$totIincomeTax += $data->income_tax ?></td>
        <td align="right"><?= ($data->pf > 0) ? $data->pf : '';
												$totPfDeduct += $data->pf ?></td>
        <td align="right"><?= ($data->pf_loan > 0) ? $data->pf_loan : '';
												$totPfLoan += $data->pf_loan ?></td>
        <td align="right"><?= ($data->advance_install > 0) ? $data->advance_install : '';
												$totAdvance_install += $data->advance_install ?></td>
        <td align="right"><?= ($data->absent_deduction > 0) ? $data->absent_deduction : '';
												$totAbsentDeduct += $data->absent_deduction ?></td>
        <td align="right"><?= ($data->late_deduction > 0) ? $data->late_deduction : '';
												$totLateDeduct += $data->late_deduction ?></td>
        <td align="right"><?= ($data->lwp_deduction > 0) ? $data->lwp_deduction : '';
												$totLwpDeduct += $data->lwp_deduction ?></td>
        <td align="right"><?= ($data->other_deduction > 0) ? $data->other_deduction : '';
												$totOtherDeduct += $data->other_deduction ?></td>
        <td align="right"><?= ($data->total_deduction > 0) ? $data->total_deduction : '';
												$totTotalDeduct += $data->total_deduction ?></td>
        <td align="right"><? echo ($data->total_payable > 0) ? $data->total_payable : '';
												$total_cash = $total_cash + $data->total_payable; ?></td>
        <td><?= ($data->cash_bank > 0) ? $data->cash_bank : ''; ?></td>
      </tr>
      <?































					}































































					?>
      <!--<tr>















          <td colspan="9" align="right" style="font-weight:bold;">Total:</td>































          <td align="right"><strong>















            <?= ($totGross > 0) ? number_format($totGross, 0) : ''; ?>















            </strong></td>















          <td align="right"><strong>















            <?= ($totBasic > 0) ? number_format($totBasic, 0) : ''; ?>















            </strong></td>



















			 <td align="right"><strong>















            <?= ($totHouse > 0) ? number_format($totHouse, 0) : ''; ?>















            </strong></td>















          <td align="right"><strong>















            <?= ($totMedical > 0) ? number_format($totMedical, 0) : ''; ?>















            </strong></td>







			 <td align="right"><strong>















            <?= ($totOthers > 0) ? number_format($totOthers, 0) : ''; ?>















            </strong></td>







			 <td align="right"><strong>















            <?= ($totConsolidated > 0) ? number_format($totConsolidated, 0) : ''; ?>















            </strong></td>



















         <td align="right"><strong>















            <?= ($totAdjustment > 0) ? number_format($totAdjustment, 0) : ''; ?>















            </strong></td>



















			 <td align="right"><strong>















            <?= ($totArrear > 0) ? number_format($totArrear, 0) : ''; ?>















            </strong></td>







			 <td align="right"><strong>















            <?= ($totAggregation > 0) ? number_format($totAggregation, 0) : ''; ?>















            </strong></td>















          <td align="right"><strong>















            <?= ($totMobileAlw > 0) ? number_format($totMobileAlw, 0) : ''; ?>















            </strong></td>







			<td align="right"><strong>















            <?= ($totPayGross > 0) ? number_format($totPayGross, 0) : ''; ?>















            </strong></td>







			<td align="right"><strong>















            <?= ($totSalary > 0) ? number_format($totSalary, 0) : ''; ?>















            </strong></td>















          <td align="right"><strong>















            <?= ($totMobileDeduct > 0) ? number_format($totMobileDeduct, 0) : ''; ?>















            </strong></td>















          <td align="right"><strong>















            <?= ($totIincomeTax > 0) ? number_format($totIincomeTax, 0) : ''; ?>















            </strong></td>























			 <td align="right"><strong>















            <?= ($totPfDeduct > 0) ? number_format($totPfDeduct, 0) : ''; ?>















            </strong></td>







		   <td align="right"><strong>















            <?= ($totWelfareFund > 0) ? number_format($totWelfareFund, 0) : ''; ?>















            </strong></td>



			 <td align="right"><strong>















            <?= ($totVehicleInstallment > 0) ? number_format($totVehicleInstallment, 0) : ''; ?>















            </strong></td>







			<td align="right"><strong>















            <?= ($totPfLoan > 0) ? number_format($totPfLoan, 0) : ''; ?>















            </strong></td>



















          <td align="right"><strong>















            <?= ($totAbsentDeduct > 0) ? number_format($totAbsentDeduct, 0) : ''; ?>















            </strong></td>































          <td align="right"><strong>















            <?= ($totLwpDeduct > 0) ? number_format($totLwpDeduct, 0) : ''; ?>















            </strong></td>































          <td align="right"><strong>















            <?= ($totOtherDeduct > 0) ? number_format($totOtherDeduct, 0) : ''; ?>















            </strong></td>















          <td align="right"><strong>















            <?= ($totTotalDeduct > 0) ? number_format($totTotalDeduct, 0) : ''; ?>















            </strong></td>















			<td align="right"><strong>















            <?= ($total_cash > 0) ? number_format($total_cash, 0) : ''; ?>















            </strong></td>































          <td>&nbsp;</td>











































        </tr>-->
    </tbody>
  </table>
  <!--<table cellspacing="0" cellpadding="0" border="0" id="grp" width="100%">



	<thead>



	  <tr>



	    <th>test</th>



		<th>test</th>



		<th>test</th>



	  </tr>



	</thead>







	</table>







<div style="width:100px"><? //include('PrintFormat.php');
							?></div>



  <div id="reporting">



  <table cellspacing="0" cellpadding="0" border="0" id="grp" width="100%">



   <thead>



  <tr>



  <td style="border:0px;">&nbsp;</td>



  </tr>



  </thead>



  </table>



</div>-->
  In Words:
  <?















































			echo convertNumberMhafuz($total_cash);































			/*$approval = find_all_field('salary_approval','','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and business_unit="'.$_POST['JOB_LOCATION'].'"');







$entry_by =  $approval->entry_by;







$checked_by = $approval->checked_by;







$approved_by = $approval->approved_by;







$status =  $approval->status;







$file_path_c = '../../pic/signature/'.$checked_by.'.png';







$file_path_a = '../../pic/signature/'.$approved_by.'.png';







if($checked_by>0){







if(file_exists($file_path_c)){







$signature_c = '<img src="'.$file_path_c.'" style="margin-left:35px; margin-top:-40px;">';



}else{



$signature_c = find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$checked_by);



}



}else{



$signature_c = '';



}



if($approved_by>0){



if(file_exists($file_path_a)){



$signature_a = '<img src="'.$file_path_a.'" style="margin-left:35px; margin-top:-40px;">';



}else{



$signature_a = find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$approved_by);



}



}else{



$signature_a = '';



}*/



			?>
  <!--<div style="width:100%; margin:60px auto">















      <div style="float:left; width:20%; text-align:center"><strong><?= find_a_field('user_activity_management', 'fname', 'user_id=' . $entry_by) ?></strong><br>-------------------<br>















        Prepared By</div>















      <div style="float:left; width:20%; text-align:center"><strong><?= $signature_c ?></strong><br>-------------------<br>















        Checked By</div>















      <div style="float:left; width:20%; text-align:center"><strong><?= $signature_a ?></strong><br>-------------------<br>















        Approved By</div>















    </div>-->
  <?































		} elseif ($_POST['report'] == 783) { // Zone Wise Sales Salary Brief Report















































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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 ' . $PBI_GROUP_con . ' group by t.pbi_region ,a.PBI_ZONE';















			$queryd = db_query($sqld);















			while ($i = mysqli_fetch_object($queryd)) {















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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where t.pbi_held_up=1 and d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 ' . $PBI_GROUP_con . ' group by t.pbi_region ,a.PBI_ZONE';















			$q = db_query($sqld);















			while ($i = mysqli_fetch_object($q)) {















				$held_up_paid[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->held_up_paid;
			}















			$sqld = 'select t.pbi_region PBI_BRANCH,a.PBI_ZONE,















sum(t.total_payable-t.bank_paid) cash_paid































from salary_attendence t, personnel_basic_info a, designation d, salary_info s where t.pbi_held_up=0 and d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 ' . $PBI_GROUP_con . ' group by t.pbi_region ,a.PBI_ZONE';















			$q = db_query($sqld);















			while ($i = mysqli_fetch_object($q)) {















				$cash_paid[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->cash_paid;
			}















			$sqld = 'select t.pbi_region PBI_BRANCH,a.PBI_ZONE,















sum(t.bank_paid) dbbl_paid































from salary_attendence t, personnel_basic_info a, designation d, salary_info s where t.pbi_held_up=0 and s.cash_bank="DBBL" and d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 ' . $PBI_GROUP_con . ' group by t.pbi_region ,a.PBI_ZONE';















			$q = db_query($sqld);















			while ($i = mysqli_fetch_object($q)) {















				$dbbl_paid[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->dbbl_paid;
			}































			$sqld = 'select t.pbi_region PBI_BRANCH,a.PBI_ZONE,
















sum(t.bank_paid) ibbl_paid































from salary_attendence t, personnel_basic_info a, designation d, salary_info s where t.pbi_held_up=0 and s.cash_bank="IBBL" and d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 ' . $PBI_GROUP_con . ' group by t.pbi_region ,a.PBI_ZONE';















			$q = db_query($sqld);















			while ($i = mysqli_fetch_object($q)) {















				$ibbl_paid[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->ibbl_paid;
			}















			$sqld = 'select t.pbi_region PBI_BRANCH,a.PBI_ZONE,















sum(t.total_payable) total_payable































from salary_attendence t, personnel_basic_info a, designation d, salary_info s where t.pbi_held_up=0 and d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 ' . $PBI_GROUP_con . ' group by t.pbi_region ,a.PBI_ZONE';















			$q = db_query($sqld);















			while ($i = mysqli_fetch_object($q)) {















				$total_payable[$i->PBI_BRANCH][$i->PBI_ZONE] = $i->total_payable;
			}















































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="31"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Region-Zone</th>
        <th rowspan="3">Nos</th>
        <th colspan="3">Basic Information </th>
        <th colspan="9"> <div>Salary and Allowance (At Actual) Taka </div></th>
        <th colspan="6"> <div>Deduction</div></th>
        <th colspan="5"> <div>Payable Amount (Taka) </div></th>
        <th colspan="4"> <div>View Only </div></th>
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















					while ($info = mysqli_fetch_object($query)) {















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><strong>
          <?= $info->BRANCH_NAME ?>
          RSM/ASM</strong></td>
        <td><?= $nos[$info->BRANCH_ID][''] ?>
          <? $total_nos = $total_nos + $nos[$info->BRANCH_ID]['']; ?></td>
        <td><?= (int)$actual_basic_salary[$info->BRANCH_ID][''] ?>
          <? $total_actual_basic_salary = $total_actual_basic_salary + $actual_basic_salary[$info->BRANCH_ID]['']; ?></td>
        <td><?= (int)$actual_special_allawance[$info->BRANCH_ID][''] ?>
          <? $total_actual_special_allawance = $total_actual_special_allawance + $actual_special_allawance[$info->BRANCH_ID]['']; ?></td>
        <td><?= $ta_da_data[$info->BRANCH_ID][''] ?>
          <? $total_ta_da_data = $total_ta_da_data + $ta_da_data[$info->BRANCH_ID]['']; ?></td>
        <td><?= (int)$basic_salary_payable[$info->BRANCH_ID][''] ?>
          <? $total_basic_salary_payable = $total_basic_salary_payable + $basic_salary_payable[$info->BRANCH_ID]['']; ?></td>
        <td><?= (int)$special_allowance[$info->BRANCH_ID][''] ?>
          <? $total_spl_alw_data = $total_spl_alw_data + $special_allowance[$info->BRANCH_ID]['']; ?></td>
        <td><?= $ta_da[$info->BRANCH_ID][''] ?>
          <? $total_ta_da = $total_ta_da + $ta_da[$info->BRANCH_ID]['']; ?></td>
        <td><?= $house_rent[$info->BRANCH_ID][''] ?>
          <? $total_house_rent = $total_house_rent + $house_rent[$info->BRANCH_ID]['']; ?></td>
        <td><?= $vehicle_allowance[$info->BRANCH_ID][''] ?>
          <? $total_vehicle_allowance = $total_vehicle_allowance + $vehicle_allowance[$info->BRANCH_ID]['']; ?></td>
        <td><?= $food_allowance[$info->BRANCH_ID][''] ?>
          <? $total_food_allowance = $total_food_allowance + $food_allowance[$info->BRANCH_ID]['']; ?></td>
        <td><?= $mobile_allowance[$info->BRANCH_ID][''] ?>
          <? $total_mobile_allowance = $total_mobile_allowance + $mobile_allowance[$info->BRANCH_ID]['']; ?></td>
        <td><?= $benefits[$info->BRANCH_ID][''] ?>
          <? $total_benefits = $total_benefits + $benefits[$info->BRANCH_ID]['']; ?></td>
        <td><?= $other_benefits[$info->BRANCH_ID][''] ?>
          <? $total_other_benefits = $total_other_benefits + $other_benefits[$info->BRANCH_ID]['']; ?></td>
        <td><?= $income_tax[$info->BRANCH_ID][''] ?>
          <? $total_income_tax = $total_income_tax + $income_tax[$info->BRANCH_ID]['']; ?></td>
        <td><?= $total_install[$info->BRANCH_ID][''] ?>
          <? $total_advance_install = $total_advance_install + $total_install[$info->BRANCH_ID]['']; ?></td>
        <td><?= $cooperative_share[$info->BRANCH_ID][''] ?>
          <? $total_cooperative_share = $total_cooperative_share + $cooperative_share[$info->BRANCH_ID]['']; ?></td>
        <td><?= $motorcycle_install[$info->BRANCH_ID][''] ?>
          <? $total_motorcycle_install = $total_motorcycle_install + $motorcycle_install[$info->BRANCH_ID]['']; ?></td>
        <td><?= $deduction[$info->BRANCH_ID][''] ?>
          <? $total_deduction = $total_deduction + $deduction[$info->BRANCH_ID]['']; ?></td>
        <td><?= number_format($data->administrative_deduction) ?>
          <? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction; ?></td>
        <td><? echo $held_up_paid[$info->BRANCH_ID][''];
								$total_help_up_paid = $total_help_up_paid + $held_up_paid[$info->BRANCH_ID]['']; ?></td>
        <td><? echo $cash_paid[$info->BRANCH_ID][''];
								$total_cash_payment = $total_cash_payment + $cash_paid[$info->BRANCH_ID]['']; ?></td>
        <td><? echo $dbbl_paid[$info->BRANCH_ID][''];
								$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid[$info->BRANCH_ID]['']; ?></td>
        <td><? echo $ibbl_paid[$info->BRANCH_ID][''];
								$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid[$info->BRANCH_ID]['']; ?></td>
        <td><? echo $total_payable[$info->BRANCH_ID][''];
								$total_net_payable = $total_net_payable + $total_payable[$info->BRANCH_ID]['']; ?></span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
      </tr>
      <?















						$zsql = "select * from zon where REGION_ID=" . $info->BRANCH_ID;















						$zquery = db_query($zsql);















						while ($zinfo = mysqli_fetch_object($zquery)) {















						?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $zinfo->ZONE_NAME ?></td>
        <td><?= $nos[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_nos = $total_nos + $nos[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= (int)$actual_basic_salary[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_actual_basic_salary = $total_actual_basic_salary + $actual_basic_salary[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= (int)$actual_special_allawance[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_actual_special_allawance = $total_actual_special_allawance + $actual_special_allawance[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $ta_da_data[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_ta_da_data = $total_ta_da_data + $ta_da_data[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= (int)$basic_salary_payable[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_basic_salary_payable = $total_basic_salary_payable + $basic_salary_payable[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= (int)$special_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_spl_alw_data = $total_spl_alw_data + $special_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $ta_da[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_ta_da = $total_ta_da + $ta_da[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $house_rent[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_house_rent = $total_house_rent + $house_rent[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $vehicle_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_vehicle_allowance = $total_vehicle_allowance + $vehicle_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $food_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_food_allowance = $total_food_allowance + $food_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $mobile_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_mobile_allowance = $total_mobile_allowance + $mobile_allowance[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $benefits[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_benefits = $total_benefits + $benefits[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $other_benefits[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_other_benefits = $total_other_benefits + $other_benefits[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $income_tax[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_income_tax = $total_income_tax + $income_tax[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $total_install[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_advance_install = $total_advance_install + $total_install[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $cooperative_share[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_cooperative_share = $total_cooperative_share + $cooperative_share[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $motorcycle_install[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_motorcycle_install = $total_motorcycle_install + $motorcycle_install[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= $deduction[$info->BRANCH_ID][$zinfo->ZONE_CODE] ?>
          <? $total_deduction = $total_deduction + $deduction[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><?= number_format($data->administrative_deduction) ?>
          <? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction; ?></td>
        <td><? echo $held_up_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE];
									$total_help_up_paid = $total_help_up_paid + $held_up_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><? echo $cash_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE];
									$total_cash_payment = $total_cash_payment + $cash_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><? echo $dbbl_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE];
									$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><? echo $ibbl_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE];
									$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></td>
        <td><? echo $total_payable[$info->BRANCH_ID][$zinfo->ZONE_CODE];
									$total_net_payable = $total_net_payable + $total_payable[$info->BRANCH_ID][$zinfo->ZONE_CODE]; ?></span></td>
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
        <td colspan="2"><?= $info->BRANCH_NAME ?>
          Total: </td>
        <td><?= $total_nos ?></td>
        <td><strong>
          <?= $total_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)$total_basic_salary_payable; ?>
          </strong></td>
        <td><strong>
          <?= $total_spl_alw_data; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da; ?>
          </strong></td>
        <td><strong>
          <?= $total_house_rent; ?>
          </strong></td>
        <td><strong>
          <?= $total_vehicle_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_food_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_mobile_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_other_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_income_tax; ?>
          </strong></td>
        <td><strong>
          <?= $total_advance_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_cooperative_share; ?>
          </strong></td>
        <td><strong>
          <?= $total_motorcycle_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_deduction; ?>
          </strong></td>
        <td><strong>
          <?= $total_administrative_deduction; ?>
          </strong></td>
        <td><strong>
          <?= $total_help_up_paid ?>
          </strong></td>
        <td><strong>
          <?= $total_cash_payment ?>
          </strong></td>
        <td><?= $total_bank_payment_dbbl ?></td>
        <td><?= $total_bank_payment_ibbl ?></td>
        <td><strong>
          <?= $total_net_payable ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <?















































						$total_total_actual_basic_salary = $total_total_actual_basic_salary + $total_actual_basic_salary;















						$total_total_actual_special_allawance = $total_total_actual_special_allawance + $total_actual_special_allawance;















						$total_total_ta_da_data = $total_total_ta_da_data + $total_ta_da_data;















						$total_total_basic_salary_payable = $total_total_basic_salary_payable + $total_basic_salary_payable;















						$total_total_spl_alw_data = $total_total_spl_alw_data + $total_spl_alw_data;















						$total_total_ta_da = $total_total_ta_da + $total_ta_da;















						$total_total_house_rent = $total_total_house_rent + $total_house_rent;















						$total_total_vehicle_allowance = $total_total_vehicle_allowance + $total_vehicle_allowance;















						$total_total_food_allowance = $total_total_food_allowance + $total_food_allowance;















						$total_total_mobile_allowance = $total_total_mobile_allowance + $total_mobile_allowance;















						$total_total_benefits = $total_total_benefits + $total_benefits;















						$total_total_other_benefits = $total_total_other_benefits + $total_other_benefits;















						$total_total_income_tax = $total_total_income_tax + $total_income_tax;















						$total_total_advance_install = $total_total_advance_install + $total_advance_install;















						$total_total_cooperative_share = $total_total_cooperative_share + $total_cooperative_share;















						$total_total_motorcycle_install = $total_total_motorcycle_install + $total_motorcycle_install;















						$total_total_deduction = $total_total_deduction + $total_deduction;















						$total_total_help_up_paid = $total_total_help_up_paid + $total_help_up_paid;















						$total_total_cash_payment = $total_total_cash_payment + $total_cash_payment;















						$total_total_bank_payment_dbbl = $total_total_bank_payment_dbbl + $total_bank_payment_dbbl;















						$total_total_bank_payment_ibbl = $total_total_bank_payment_ibbl + $total_bank_payment_ibbl;















						$total_total_net_payable = $total_total_net_payable + $total_net_payable;















						$total_total_nos = $total_total_nos + $total_nos;















































						$total_actual_basic_salary = 0;















						$total_actual_special_allawance = 0;















						$total_ta_da_data = 0;















						$total_basic_salary_payable = 0;















						$total_spl_alw_data = 0;















						$total_ta_da = 0;















						$total_house_rent = 0;















						$total_vehicle_allowance = 0;















						$total_food_allowance = 0;















						$total_mobile_allowance = 0;















						$total_benefits = 0;















						$total_other_benefits = 0;















						$total_income_tax = 0;















						$total_advance_install = 0;















						$total_cooperative_share = 0;















						$total_motorcycle_install = 0;















						$total_deduction = 0;















						$total_help_up_paid = 0;















						$total_cash_payment = 0;















						$total_bank_payment_dbbl = 0;















						$total_bank_payment_ibbl = 0;















						$total_net_payable = 0;















						$total_nos = 0;
					}















					?>
      <tr bgcolor="#FFCC99">
        <td colspan="2"><?= $info->BRANCH_NAME ?>
          National: </td>
        <td><?= $total_total_nos; ?></td>
        <td><strong>
          <?= $total_total_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)$total_total_basic_salary_payable; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_spl_alw_data; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_ta_da; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_house_rent; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_vehicle_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_food_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_mobile_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_other_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_income_tax; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_advance_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_cooperative_share; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_motorcycle_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_total_deduction; ?>
          </strong></td>
        <td>&nbsp;</td>
        <td><?= $total_total_help_up_paid ?></td>
        <td><strong>
          <?= $total_total_cash_payment ?>
          </strong></td>
        <td><?= $total_total_bank_payment_dbbl ?></td>
        <td><?= $total_total_bank_payment_ibbl ?></td>
        <td><strong>
          <?= $total_total_net_payable ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 780) {































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="30"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Region Name</th>
        <th colspan="3">Basic Information </th>
        <th colspan="9"> <div>Salary and Allowance (At Actual) Taka </div></th>
        <th colspan="6"> <div>Deduction</div></th>
        <th colspan="5"> <div>Payable Amount (Taka) </div></th>
        <th colspan="4"> <div>View Only </div></th>
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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales" group by t.pbi_region ';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















					?>
      <? $data->actual_basic_salary ?>
      <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary; ?>
      <? (int)$data->actual_special_allawance ?>
      <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance; ?>
      <? $data->ta_da_data ?>
      <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data; ?>
      <? (int)$data->basic_salary_payable ?>
      <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable; ?>
      <? (int)$data->special_allowance ?>
      <? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance; ?>
      <? $data->ta_da ?>
      <? $total_ta_da = $total_ta_da + $data->ta_da; ?>
      <? $data->house_rent ?>
      <? $total_house_rent = $total_house_rent + $data->house_rent; ?>
      <? $data->vehicle_allowance ?>
      <? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance; ?>
      <? $data->food_allowance ?>
      <? $total_food_allowance = $total_food_allowance + $data->food_allowance; ?>
      <? $data->mobile_allowance ?>
      <? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance; ?>
      <? $data->benefits ?>
      <? $total_benefits = $total_benefits + $data->benefits; ?>
      <? $data->other_benefits ?>
      <? $total_other_benefits = $total_other_benefits + $data->other_benefits; ?>
      <? $data->income_tax ?>
      <? $total_income_tax = $total_income_tax + $data->income_tax; ?>
      <? $total_install ?>
      <? $total_advance_install = $total_advance_install + $total_install; ?>
      <? $data->cooperative_share ?>
      <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share; ?>
      <? $data->motorcycle_install ?>
      <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install; ?>
      <? $data->deduction ?>
      <? $total_deduction = $total_deduction + $data->deduction; ?>
      <? //echo number_format(0);
						?>
      <? $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)/4', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_help_up_paid = $total_help_up_paid + $help_up_paid; ?>
      <? $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)/4', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_cash_payment = $total_cash_payment + $cash_paid; ?>
      <? $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)/4', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid; ?>
      <? $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)/4', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid; ?>
      <?php $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)/4', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_net_payable = $total_net_payable + $net_payable; ?>
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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  ' . $PBI_GROUP_con . ' group by t.pbi_region ';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary; ?>
      <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance; ?>
      <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data; ?>
      <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable; ?>
      <? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance; ?>
      <? $total_ta_da = $total_ta_da + $data->ta_da; ?>
      <? $total_house_rent = $total_house_rent + $data->house_rent; ?>
      <? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance; ?>
      <? $total_food_allowance = $total_food_allowance + $data->food_allowance; ?>
      <? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance; ?>
      <? $total_benefits = $total_benefits + $data->benefits; ?>
      <? $total_other_benefits = $total_other_benefits + $data->other_benefits; ?>
      <? $total_income_tax = $total_income_tax + $data->income_tax; ?>
      <? $total_advance_install = $total_advance_install + $total_install; ?>
      <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share; ?>
      <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install; ?>
      <? $total_deduction = $total_deduction + $data->deduction; ?>
      <? $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ' . $PBI_GROUP_con);
						$total_help_up_paid = $total_help_up_paid + $help_up_paid; ?>
      <? $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ' . $PBI_GROUP_con);
						$total_cash_payment = $total_cash_payment + $cash_paid; ?>
      <? $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ' . $PBI_GROUP_con);
						$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid; ?>
      <? $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ' . $PBI_GROUP_con);
						$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid; ?>
      <?php $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ' . $PBI_GROUP_con);
						$total_net_payable = $total_net_payable + $net_payable; ?>
      <?















					}















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td>Head Office</td>
        <td><strong>
          <?= $total_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)$total_basic_salary_payable; ?>
          </strong></td>
        <td><strong>
          <?= $total_spl_alw_data; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da; ?>
          </strong></td>
        <td><strong>
          <?= $total_house_rent; ?>
          </strong></td>
        <td><strong>
          <?= $total_vehicle_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_food_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_mobile_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_other_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_income_tax; ?>
          </strong></td>
        <td><strong>
          <?= $total_advance_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_cooperative_share; ?>
          </strong></td>
        <td><strong>
          <?= $total_motorcycle_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_deduction; ?>
          </strong></td>
        <td>&nbsp;</td>
        <td><?= $total_help_up_paid ?></td>
        <td><strong>
          <?= $total_cash_payment ?>
          </strong></td>
        <td><?= $total_bank_payment_dbbl ?></td>
        <td><?= $total_bank_payment_ibbl ?></td>
        <td><strong>
          <?= $total_net_payable ?>
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
































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region >0 and t.pbi_department="Sales"  ' . $PBI_GROUP_con . ' group by t.pbi_region ';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= find_a_field('branch', 'BRANCH_NAME', 'BRANCH_ID=' . $data->PBI_BRANCH) ?></td>
        <td><?= (int)$data->actual_basic_salary ?>
          <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary; ?></td>
        <td><?= (int)$data->actual_special_allawance ?>
          <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance; ?></td>
        <td><?= $data->ta_da_data ?>
          <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data; ?></td>
        <td><?= (int)$data->basic_salary_payable ?>
          <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable; ?></td>
        <td><?= (int)$data->special_allowance ?>
          <? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance; ?></td>
        <td><?= $data->ta_da ?>
          <? $total_ta_da = $total_ta_da + $data->ta_da; ?></td>
        <td><?= $data->house_rent ?>
          <? $total_house_rent = $total_house_rent + $data->house_rent; ?></td>
        <td><?= $data->vehicle_allowance ?>
          <? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance; ?></td>
        <td><?= $data->food_allowance ?>
          <? $total_food_allowance = $total_food_allowance + $data->food_allowance; ?></td>
        <td><?= $data->mobile_allowance ?>
          <? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance; ?></td>
        <td><?= $data->benefits ?>
          <? $total_benefits = $total_benefits + $data->benefits; ?></td>
        <td><?= $data->other_benefits ?>
          <? $total_other_benefits = $total_other_benefits + $data->other_benefits; ?></td>
        <td><?= $data->income_tax ?>
          <? $total_income_tax = $total_income_tax + $data->income_tax; ?></td>
        <td><?= $data->total_install ?>
          <? $total_advance_install = $total_advance_install + $data->total_install; ?></td>
        <td><?= $data->cooperative_share ?>
          <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share; ?></td>
        <td><?= $data->motorcycle_install ?>
          <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install; ?></td>
        <td><?= $data->deduction ?>
          <? $total_deduction = $total_deduction + $data->deduction; ?></td>
        <td><?= number_format($data->administrative_deduction) ?>
          <? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction; ?></td>
        <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region ="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con);
								$total_help_up_paid = $total_help_up_paid + $help_up_paid; ?></td>
        <td><? echo $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region ="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con);
								$total_cash_payment = $total_cash_payment + $cash_paid; ?></td>
        <td><? echo $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region ="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con);
								$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid; ?></td>
        <td><? echo $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region ="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con);
								$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid; ?></td>
        <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region ="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con);
																					$total_net_payable = $total_net_payable + $net_payable; ?></span></td>
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
        <td><strong>
          <?= $total_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)$total_basic_salary_payable; ?>
          </strong></td>
        <td><strong>
          <?= $total_spl_alw_data; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da; ?>
          </strong></td>
        <td><strong>
          <?= $total_house_rent; ?>
          </strong></td>
        <td><strong>
          <?= $total_vehicle_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_food_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_mobile_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_other_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_income_tax; ?>
          </strong></td>
        <td><strong>
          <?= $total_advance_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_cooperative_share; ?>
          </strong></td>
        <td><strong>
          <?= $total_motorcycle_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_deduction; ?>
          </strong></td>
        <td>&nbsp;</td>
        <td><?= $total_help_up_paid ?></td>
        <td><strong>
          <?= $total_cash_payment ?>
          </strong></td>
        <td><?= $total_bank_payment_dbbl ?></td>
        <td><?= $total_bank_payment_ibbl ?></td>
        <td><strong>
          <?= $total_net_payable ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 7809) {















			$year = $_POST['year'];















			$mon = $_POST['mon'];































			if ($mon == 1) {















				$syear = $year - 1;















				$smon = 12;
			} else {















				$syear = $year;















				$smon =  $mon - 1;
			}















		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="12"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Name of Unit</th>
        <th colspan="2">Previous Month</th>
        <th colspan="6"> <div>
            <?= date('F', mktime(0, 0, 0, $mon, 10)); ?>
            -
            <?= $year ?>
          </div></th>
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















from  salary_attendence t, personnel_basic_info a, salary_info s where t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location in (1,79,80) and t.pbi_held_up=0  ' . $PBI_GROUP_con . ' group by t.pbi_organization ';















					$queryd = db_query($sqld);















					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















































						$cash_paid[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80)  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_held_up=0 and t.pbi_organization = "' . $data->pbi_organization . '" ' . $PBI_GROUP_con);















































						$dbbl_paid[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80)  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_held_up=0 and t.pbi_organization = "' . $data->pbi_organization . '" ' . $PBI_GROUP_con);































						$ibbl_paid[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80)  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_held_up=0 and t.pbi_organization = "' . $data->pbi_organization . '" ' . $PBI_GROUP_con);































						$ncc_paid[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="NCC" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80)  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_held_up=0 and t.pbi_organization = "' . $data->pbi_organization . '" ' . $PBI_GROUP_con);































						$net_payable[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80)  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_held_up=0 and t.pbi_organization = "' . $data->pbi_organization . '" ' . $PBI_GROUP_con);















































						$smanpower[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a ', 'count(t.PBI_ID) manpower', 't.pbi_job_location in (1,79,80) and t.PBI_ID=a.PBI_ID and t.mon=' . $smon . ' and t.year=' . $syear . ' and t.pbi_held_up=0 and t.pbi_organization = "' . $data->pbi_organization . '" ' . $PBI_GROUP_con);















































						$snet_payable[$data->pbi_organization] = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location in (1,79,80) and t.mon=' . $smon . ' and t.year=' . $syear . ' and t.pbi_held_up=0 and t.pbi_organization = "' . $data->pbi_organization . '" ' . $PBI_GROUP_con);































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















from  salary_attendence t, personnel_basic_info a, salary_info s where t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO") and t.pbi_held_up=0  ' . $PBI_GROUP_con . ' ';















					$queryd = db_query($sqld);















					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















































						$cash_paid[100] = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  ' . $PBI_GROUP_con);















































						$dbbl_paid[100] = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  ' . $PBI_GROUP_con);































						$ibbl_paid[100] = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  ' . $PBI_GROUP_con);































						$ncc_paid[100] = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="NCC" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  ' . $PBI_GROUP_con);































						$net_payable[100] = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  ' . $PBI_GROUP_con);















































						$smanpower[100] = find_a_field('salary_attendence t,personnel_basic_info a ', 'count(t.PBI_ID) manpower', 't.PBI_ID=a.PBI_ID and t.mon=' . $smon . ' and t.year=' . $syear . ' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  ' . $PBI_GROUP_con);















































						$snet_payable[100] = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon=' . $smon . ' and t.year=' . $syear . ' and t.pbi_held_up=0 and t.pbi_department in ("Admin (Support Service Section)","Store (Transport)","STO")  ' . $PBI_GROUP_con);































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
        <td><span style="text-align:left; font-weight:bold;">
          <?= $smanpower[1] + $smanpower[2] + $smanpower[100] ?>
          </span></td>
        <td><span style="text-align:left; font-weight:bold;">
          <?= $snet_payable[1] + $snet_payable[2] + $snet_payable[100] ?>
          </span></td>
        <td><?= $manpower[1] + $manpower[2] + $manpower[100] ?></td>
        <td><?= $dbbl_paid[1] + $dbbl_paid[2] + $dbbl_paid[100] ?></td>
        <td><?= $ibbl_paid[1] + $ibbl_paid[2] + $ibbl_paid[100] ?></td>
        <td><?= $ncc_paid[1] + $ncc_paid[2] + $ncc_paid[100] ?></td>
        <td><strong>
          <?= $cash_paid[1] + $cash_paid[2] + $cash_paid[100] ?>
          </strong></td>
        <td><strong>
          <?= $net_payable[1] + $net_payable[2] + $net_payable[100] ?>
          </strong></td>
        <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
        <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
      </tr>
      <?















					++$j;















					$sqld = 'select id, group_name















from  user_group where id>2 and status>0 order by id';















					$queryd = db_query($sqld);















					while ($data = mysqli_fetch_object($queryd)) {















					?>
      <tr>
        <td><?= ++$j ?></td>
        <td><?= $data->group_name; ?></td>
        <td><span style="text-align:left; font-weight:bold;">
          <?= $smanpower[$data->id]; ?>
          </span></td>
        <td><span style="text-align:left; font-weight:bold;">
          <?= $snet_payable[$data->id]; ?>
          </span></td>
        <td><?= $manpower[$data->id] ?></td>
        <td><?= $dbbl_paid[$data->id] ?></td>
        <td><?= $ibbl_paid[$data->id] ?></td>
        <td><?= $ncc_paid[$data->id] ?></td>
        <td><strong>
          <?= $cash_paid[$data->id] ?>
          </strong></td>
        <td><strong>
          <?= $net_payable[$data->id] ?>
          </strong></td>
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















from  salary_attendence t, personnel_basic_info a, salary_info s where t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region > 0 and t.pbi_department="Sales"  ' . $PBI_GROUP_con . ' group by t.pbi_region ';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <tr>
        <td><?= ++$ws ?></td>
        <td><?= find_a_field('branch', 'BRANCH_NAME', 'BRANCH_ID=' . $data->PBI_BRANCH) ?></td>
        <td><span style="text-align:left; font-weight:bold;"><?php echo $smanpower = find_a_field('salary_attendence t,personnel_basic_info a ', 'count(t.PBI_ID) manpower', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon=' . $smon . ' and t.year=' . $syear . ' and t.pbi_region ="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con);
																					$stotal_smanpower = $stotal_smanpower + $smanpower; ?></span></td>
        <td><span style="text-align:left; font-weight:bold;"><?php echo $snet_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon=' . $smon . ' and t.year=' . $syear . ' and t.pbi_region ="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con);
																					$stotal_net_payable = $stotal_net_payable + $snet_payable; ?></span></td>
        <td><?= $data->manpower ?></td>
        <td><? echo $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region ="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con);
								$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid; ?></td>
        <td><? echo $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region ="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con);
								$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid; ?></td>
        <td>&nbsp;</td>
        <td><? echo $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region ="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con);
								$total_cash_payment = $total_cash_payment + $cash_paid; ?></td>
        <td><span style="text-align:left; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region ="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con);
																					$total_net_payable = $total_net_payable + $net_payable; ?></span></td>
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
        <td><?= $total_help_up_paid ?></td>
        <td><?= $total_bank_payment_dbbl ?></td>
        <td><?= $total_bank_payment_ibbl ?></td>
        <td>&nbsp;</td>
        <td><strong>
          <?= $total_cash_payment ?>
          </strong></td>
        <td><strong>
          <?= $total_net_payable ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 7804) { // Group Wise HO Sales Report































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="30"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Group Name</th>
        <th colspan="3">Basic Information </th>
        <th colspan="9"> <div>Salary and Allowance (At Actual) Taka </div></th>
        <th colspan="6"> <div>Deduction</div></th>
        <th colspan="5"> <div>Payable Amount (Taka) </div></th>
        <th colspan="4"> <div>View Only </div></th>
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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.PBI_ID="3364"';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















					?>
      <? $data->actual_basic_salary ?>
      <? $total_14_actual_basic_salary = $total_14_actual_basic_salary + $data->actual_basic_salary; ?>
      <? (int)$data->actual_special_allawance ?>
      <? $total_14_actual_special_allawance = $total_14_actual_special_allawance + $data->actual_special_allawance; ?>
      <? $data->ta_da_data ?>
      <? $total_14_ta_da_data = $total_14_ta_da_data + $data->ta_da_data; ?>
      <? (int)$data->basic_salary_payable ?>
      <? $total_14_basic_salary_payable = $total_14_basic_salary_payable + $data->basic_salary_payable; ?>
      <? (int)$data->special_allowance ?>
      <? $total_14_spl_alw_data = $total_14_spl_alw_data + $data->special_allowance; ?>
      <? $data->ta_da ?>
      <? $total_14_ta_da = $total_14_ta_da + $data->ta_da; ?>
      <? $data->house_rent ?>
      <? $total_14_house_rent = $total_14_house_rent + $data->house_rent; ?>
      <? $data->vehicle_allowance ?>
      <? $total_14_vehicle_allowance = $total_14_vehicle_allowance + $data->vehicle_allowance; ?>
      <? $data->food_allowance ?>
      <? $total_14_food_allowance = $total_14_food_allowance + $data->food_allowance; ?>
      <? $data->mobile_allowance ?>
      <? $total_14_mobile_allowance = $total_14_mobile_allowance + $data->mobile_allowance; ?>
      <? $data->benefits ?>
      <? $total_14_benefits = $total_14_benefits + $data->benefits; ?>
      <? $data->other_benefits ?>
      <? $total_14_other_benefits = $total_14_other_benefits + $data->other_benefits; ?>
      <? $data->income_tax ?>
      <? $total_14_income_tax = $total_14_income_tax + $data->income_tax; ?>
      <? $total_install ?>
      <? $total_14_advance_install = $total_14_advance_install + $data->total_install; ?>
      <? $data->cooperative_share ?>
      <? $total_14_cooperative_share = $total_14_cooperative_share + $data->cooperative_share; ?>
      <? $data->motorcycle_install ?>
      <? $total_14_motorcycle_install = $total_14_motorcycle_install + $data->motorcycle_install; ?>
      <? $data->deduction ?>
      <? $total_14_deduction = $total_14_deduction + $data->deduction; ?>
      <? $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)/5', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_14_help_up_paid = $total_14_help_up_paid + $help_up_paid; ?>
      <? $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)/5', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_14_cash_payment = $total_14_cash_payment + $cash_paid; ?>
      <? $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)/5', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_14_bank_payment_dbbl = $total_14_bank_payment_dbbl + $dbbl_paid; ?>
      <? $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)/5', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_14_bank_payment_ibbl = $total_14_bank_payment_ibbl + $ibbl_paid; ?>
      <?php $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)/5', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_14_net_payable = $total_14_net_payable + $net_payable; ?>
      <?















					}































					//A















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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  ';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















					?>
      <? $data->actual_basic_salary ?>
      <? $total_A_actual_basic_salary = $total_A_actual_basic_salary + $data->actual_basic_salary; ?>
      <? (int)$data->actual_special_allawance ?>
      <? $total_A_actual_special_allawance = $total_A_actual_special_allawance + $data->actual_special_allawance; ?>
      <? $data->ta_da_data ?>
      <? $total_A_ta_da_data = $total_A_ta_da_data + $data->ta_da_data; ?>
      <? (int)$data->basic_salary_payable ?>
      <? $total_A_basic_salary_payable = $total_A_basic_salary_payable + $data->basic_salary_payable; ?>
      <? (int)$data->special_allowance ?>
      <? $total_A_spl_alw_data = $total_A_spl_alw_data + $data->special_allowance; ?>
      <? $data->ta_da ?>
      <? $total_A_ta_da = $total_A_ta_da + $data->ta_da; ?>
      <? $data->house_rent ?>
      <? $total_A_house_rent = $total_A_house_rent + $data->house_rent; ?>
      <? $data->vehicle_allowance ?>
      <? $total_A_vehicle_allowance = $total_A_vehicle_allowance + $data->vehicle_allowance; ?>
      <? $data->food_allowance ?>
      <? $total_A_food_allowance = $total_A_food_allowance + $data->food_allowance; ?>
      <? $data->mobile_allowance ?>
      <? $total_A_mobile_allowance = $total_A_mobile_allowance + $data->mobile_allowance; ?>
      <? $data->benefits ?>
      <? $total_A_benefits = $total_A_benefits + $data->benefits; ?>
      <? $data->other_benefits ?>
      <? $total_A_other_benefits = $total_A_other_benefits + $data->other_benefits; ?>
      <? $data->income_tax ?>
      <? $total_A_income_tax = $total_A_income_tax + $data->income_tax; ?>
      <? $total_install ?>
      <? $total_A_advance_install = $total_A_advance_install + $data->total_install; ?>
      <? $data->cooperative_share ?>
      <? $total_A_cooperative_share = $total_A_cooperative_share + $data->cooperative_share; ?>
      <? $data->motorcycle_install ?>
      <? $total_A_motorcycle_install = $total_A_motorcycle_install + $data->motorcycle_install; ?>
      <? $data->deduction ?>
      <? $total_A_deduction = $total_A_deduction + $data->deduction; ?>
      <? $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_A_help_up_paid = $total_A_help_up_paid + $help_up_paid; ?>
      <? $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_A_cash_payment = $total_A_cash_payment + $cash_paid; ?>
      <? $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_A_bank_payment_dbbl = $total_A_bank_payment_dbbl + $dbbl_paid; ?>
      <? $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_A_bank_payment_ibbl = $total_A_bank_payment_ibbl + $ibbl_paid; ?>
      <?php $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="A" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_A_net_payable = $total_A_net_payable + $net_payable; ?>
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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  ';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















					?>
      <? $data->actual_basic_salary ?>
      <? $total_B_actual_basic_salary = $total_B_actual_basic_salary + $data->actual_basic_salary; ?>
      <? (int)$data->actual_special_allawance ?>
      <? $total_B_actual_special_allawance = $total_B_actual_special_allawance + $data->actual_special_allawance; ?>
      <? $data->ta_da_data ?>
      <? $total_B_ta_da_data = $total_B_ta_da_data + $data->ta_da_data; ?>
      <? (int)$data->basic_salary_payable ?>
      <? $total_B_basic_salary_payable = $total_B_basic_salary_payable + $data->basic_salary_payable; ?>
      <? (int)$data->special_allowance ?>
      <? $total_B_spl_alw_data = $total_B_spl_alw_data + $data->special_allowance; ?>
      <? $data->ta_da ?>
      <? $total_B_ta_da = $total_B_ta_da + $data->ta_da; ?>
      <? $data->house_rent ?>
      <? $total_B_house_rent = $total_B_house_rent + $data->house_rent; ?>
      <? $data->vehicle_allowance ?>
      <? $total_B_vehicle_allowance = $total_B_vehicle_allowance + $data->vehicle_allowance; ?>
      <? $data->food_allowance ?>
      <? $total_B_food_allowance = $total_B_food_allowance + $data->food_allowance; ?>
      <? $data->mobile_allowance ?>
      <? $total_B_mobile_allowance = $total_B_mobile_allowance + $data->mobile_allowance; ?>
      <? $data->benefits ?>
      <? $total_B_benefits = $total_B_benefits + $data->benefits; ?>
      <? $data->other_benefits ?>
      <? $total_B_other_benefits = $total_B_other_benefits + $data->other_benefits; ?>
      <? $data->income_tax ?>
      <? $total_B_income_tax = $total_B_income_tax + $data->income_tax; ?>
      <? $total_install ?>
      <? $total_B_advance_install = $total_B_advance_install + $data->total_install; ?>
      <? $data->cooperative_share ?>
      <? $total_B_cooperative_share = $total_B_cooperative_share + $data->cooperative_share; ?>
      <? $data->motorcycle_install ?>
      <? $total_B_motorcycle_install = $total_B_motorcycle_install + $data->motorcycle_install; ?>
      <? $data->deduction ?>
      <? $total_B_deduction = $total_B_deduction + $data->deduction; ?>
      <? $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_B_help_up_paid = $total_B_help_up_paid + $help_up_paid; ?>
      <? $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_B_cash_payment = $total_B_cash_payment + $cash_paid; ?>
      <? $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_B_bank_payment_dbbl = $total_B_bank_payment_dbbl + $dbbl_paid; ?>
      <? $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_B_bank_payment_ibbl = $total_B_bank_payment_ibbl + $ibbl_paid; ?>
      <?php $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="B" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_B_net_payable = $total_B_net_payable + $net_payable; ?>
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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  ';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















					?>
      <? $data->actual_basic_salary ?>
      <? $total_C_actual_basic_salary = $total_C_actual_basic_salary + $data->actual_basic_salary; ?>
      <? (int)$data->actual_special_allawance ?>
      <? $total_C_actual_special_allawance = $total_C_actual_special_allawance + $data->actual_special_allawance; ?>
      <? $data->ta_da_data ?>
      <? $total_C_ta_da_data = $total_C_ta_da_data + $data->ta_da_data; ?>
      <? (int)$data->basic_salary_payable ?>
      <? $total_C_basic_salary_payable = $total_C_basic_salary_payable + $data->basic_salary_payable; ?>
      <? (int)$data->special_allowance ?>
      <? $total_C_spl_alw_data = $total_C_spl_alw_data + $data->special_allowance; ?>
      <? $data->ta_da ?>
      <? $total_C_ta_da = $total_C_ta_da + $data->ta_da; ?>
      <? $data->house_rent ?>
      <? $total_C_house_rent = $total_C_house_rent + $data->house_rent; ?>
      <? $data->vehicle_allowance ?>
      <? $total_C_vehicle_allowance = $total_C_vehicle_allowance + $data->vehicle_allowance; ?>
      <? $data->food_allowance ?>
      <? $total_C_food_allowance = $total_C_food_allowance + $data->food_allowance; ?>
      <? $data->mobile_allowance ?>
      <? $total_C_mobile_allowance = $total_C_mobile_allowance + $data->mobile_allowance; ?>
      <? $data->benefits ?>
      <? $total_C_benefits = $total_C_benefits + $data->benefits; ?>
      <? $data->other_benefits ?>
      <? $total_C_other_benefits = $total_C_other_benefits + $data->other_benefits; ?>
      <? $data->income_tax ?>
      <? $total_C_income_tax = $total_C_income_tax + $data->income_tax; ?>
      <? $total_install ?>
      <? $total_C_advance_install = $total_C_advance_install + $data->total_install; ?>
      <? $data->cooperative_share ?>
      <? $total_C_cooperative_share = $total_C_cooperative_share + $data->cooperative_share; ?>
      <? $data->motorcycle_install ?>
      <? $total_C_motorcycle_install = $total_C_motorcycle_install + $data->motorcycle_install; ?>
      <? $data->deduction ?>
      <? $total_C_deduction = $total_C_deduction + $data->deduction; ?>
      <? $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_C_help_up_paid = $total_C_help_up_paid + $help_up_paid; ?>
      <? $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_C_cash_payment = $total_C_cash_payment + $cash_paid; ?>
      <? $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_C_bank_payment_dbbl = $total_C_bank_payment_dbbl + $dbbl_paid; ?>
      <? $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_C_bank_payment_ibbl = $total_C_bank_payment_ibbl + $ibbl_paid; ?>
      <?php $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="C" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_C_net_payable = $total_C_net_payable + $net_payable; ?>
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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  ';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















					?>
      <? $data->actual_basic_salary ?>
      <? $total_D_actual_basic_salary = $total_D_actual_basic_salary + $data->actual_basic_salary; ?>
      <? (int)$data->actual_special_allawance ?>
      <? $total_D_actual_special_allawance = $total_D_actual_special_allawance + $data->actual_special_allawance; ?>
      <? $data->ta_da_data ?>
      <? $total_D_ta_da_data = $total_D_ta_da_data + $data->ta_da_data; ?>
      <? (int)$data->basic_salary_payable ?>
      <? $total_D_basic_salary_payable = $total_D_basic_salary_payable + $data->basic_salary_payable; ?>
      <? (int)$data->special_allowance ?>
      <? $total_D_spl_alw_data = $total_D_spl_alw_data + $data->special_allowance; ?>
      <? $data->ta_da ?>
      <? $total_D_ta_da = $total_D_ta_da + $data->ta_da; ?>
      <? $data->house_rent ?>
      <? $total_D_house_rent = $total_D_house_rent + $data->house_rent; ?>
      <? $data->vehicle_allowance ?>
      <? $total_D_vehicle_allowance = $total_D_vehicle_allowance + $data->vehicle_allowance; ?>
      <? $data->food_allowance ?>
      <? $total_D_food_allowance = $total_D_food_allowance + $data->food_allowance; ?>
      <? $data->mobile_allowance ?>
      <? $total_D_mobile_allowance = $total_D_mobile_allowance + $data->mobile_allowance; ?>
      <? $data->benefits ?>
      <? $total_D_benefits = $total_D_benefits + $data->benefits; ?>
      <? $data->other_benefits ?>
      <? $total_D_other_benefits = $total_D_other_benefits + $data->other_benefits; ?>
      <? $data->income_tax ?>
      <? $total_D_income_tax = $total_D_income_tax + $data->income_tax; ?>
      <? $total_install ?>
      <? $total_D_advance_install = $total_D_advance_install + $data->total_install; ?>
      <? $data->cooperative_share ?>
      <? $total_D_cooperative_share = $total_D_cooperative_share + $data->cooperative_share; ?>
      <? $data->motorcycle_install ?>
      <? $total_D_motorcycle_install = $total_D_motorcycle_install + $data->motorcycle_install; ?>
      <? $data->deduction ?>
      <? $total_D_deduction = $total_D_deduction + $data->deduction; ?>
      <? $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_D_help_up_paid = $total_D_help_up_paid + $help_up_paid; ?>
      <? $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_D_cash_payment = $total_D_cash_payment + $cash_paid; ?>
      <? $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_D_bank_payment_dbbl = $total_D_bank_payment_dbbl + $dbbl_paid; ?>
      <? $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_D_bank_payment_ibbl = $total_D_bank_payment_ibbl + $ibbl_paid; ?>
      <?php $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="D" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_D_net_payable = $total_D_net_payable + $net_payable; ?>
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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  ';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















					?>
      <? $data->actual_basic_salary ?>
      <? $total_E_actual_basic_salary = $total_E_actual_basic_salary + $data->actual_basic_salary; ?>
      <? (int)$data->actual_special_allawance ?>
      <? $total_E_actual_special_allawance = $total_E_actual_special_allawance + $data->actual_special_allawance; ?>
      <? $data->ta_da_data ?>
      <? $total_E_ta_da_data = $total_E_ta_da_data + $data->ta_da_data; ?>
      <? (int)$data->basic_salary_payable ?>
      <? $total_E_basic_salary_payable = $total_E_basic_salary_payable + $data->basic_salary_payable; ?>
      <? (int)$data->special_allowance ?>
      <? $total_E_spl_alw_data = $total_E_spl_alw_data + $data->special_allowance; ?>
      <? $data->ta_da ?>
      <? $total_E_ta_da = $total_E_ta_da + $data->ta_da; ?>
      <? $data->house_rent ?>
      <? $total_E_house_rent = $total_E_house_rent + $data->house_rent; ?>
      <? $data->vehicle_allowance ?>
      <? $total_E_vehicle_allowance = $total_E_vehicle_allowance + $data->vehicle_allowance; ?>
      <? $data->food_allowance ?>
      <? $total_E_food_allowance = $total_E_food_allowance + $data->food_allowance; ?>
      <? $data->mobile_allowance ?>
      <? $total_E_mobile_allowance = $total_E_mobile_allowance + $data->mobile_allowance; ?>
      <? $data->benefits ?>
      <? $total_E_benefits = $total_E_benefits + $data->benefits; ?>
      <? $data->other_benefits ?>
      <? $total_E_other_benefits = $total_E_other_benefits + $data->other_benefits; ?>
      <? $data->income_tax ?>
      <? $total_E_income_tax = $total_E_income_tax + $data->income_tax; ?>
      <? $total_install ?>
      <? $total_E_advance_install = $total_E_advance_install + $data->total_install; ?>
      <? $data->cooperative_share ?>
      <? $total_E_cooperative_share = $total_E_cooperative_share + $data->cooperative_share; ?>
      <? $data->motorcycle_install ?>
      <? $total_E_motorcycle_install = $total_E_motorcycle_install + $data->motorcycle_install; ?>
      <? $data->deduction ?>
      <? $total_E_deduction = $total_E_deduction + $data->deduction; ?>
      <? $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_E_help_up_paid = $total_E_help_up_paid + $help_up_paid; ?>
      <? $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_E_cash_payment = $total_E_cash_payment + $cash_paid; ?>
      <? $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_E_bank_payment_dbbl = $total_E_bank_payment_dbbl + $dbbl_paid; ?>
      <? $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_E_bank_payment_ibbl = $total_E_bank_payment_ibbl + $ibbl_paid; ?>
      <?php $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="1" and t.pbi_Group="E" and t.pbi_department="Sales"  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
						$total_E_net_payable = $total_E_net_payable + $net_payable; ?>
      <?















					}































					?>
      <tr>
        <td>1</td>
        <td>Group-A</td>
        <td><strong>
          <?= $total_14_actual_basic_salary + $total_A_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_14_actual_special_allawance + $total_A_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_14_ta_da_data + $total_A_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)($total_14_basic_salary_payable + $total_A_basic_salary_payable); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_spl_alw_data + $total_A_spl_alw_data); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_ta_da + $total_A_ta_da); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_house_rent + $total_A_house_rent); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_vehicle_allowance + $total_A_vehicle_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_food_allowance + $total_A_food_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_mobile_allowance + $total_A_mobile_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_benefits + $total_A_benefits); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_other_benefits + $total_A_other_benefits); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_income_tax + $total_A_income_tax); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_advance_install + $total_A_advance_install); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_cooperative_share + $total_A_cooperative_share); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_motorcycle_install + $total_A_motorcycle_install); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_deduction + $total_A_deduction); ?>
          </strong></td>
        <td>&nbsp;</td>
        <td><?= ($total_14_help_up_paid + $total_A_help_up_paid) ?></td>
        <td><strong>
          <?= ($total_14_cash_payment + $total_A_cash_payment) ?>
          </strong></td>
        <td><?= ($total_14_bank_payment_dbbl + $total_A_bank_payment_dbbl) ?></td>
        <td><?= ($total_14_bank_payment_ibbl + $total_A_bank_payment_ibbl) ?></td>
        <td><strong>
          <?= ($total_14_net_payable + $total_A_net_payable) ?>
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
          <?= $total_14_actual_basic_salary + $total_B_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_14_actual_special_allawance + $total_B_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_14_ta_da_data + $total_B_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)($total_14_basic_salary_payable + $total_B_basic_salary_payable); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_spl_alw_data + $total_B_spl_alw_data); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_ta_da + $total_B_ta_da); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_house_rent + $total_B_house_rent); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_vehicle_allowance + $total_B_vehicle_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_food_allowance + $total_B_food_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_mobile_allowance + $total_B_mobile_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_benefits + $total_B_benefits); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_other_benefits + $total_B_other_benefits); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_income_tax + $total_B_income_tax); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_advance_install + $total_B_advance_install); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_cooperative_share + $total_B_cooperative_share); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_motorcycle_install + $total_B_motorcycle_install); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_deduction + $total_B_deduction); ?>
          </strong></td>
        <td>&nbsp;</td>
        <td><?= ($total_14_help_up_paid + $total_B_help_up_paid) ?></td>
        <td><strong>
          <?= ($total_14_cash_payment + $total_B_cash_payment) ?>
          </strong></td>
        <td><?= ($total_14_bank_payment_dbbl + $total_B_bank_payment_dbbl) ?></td>
        <td><?= ($total_14_bank_payment_ibbl + $total_B_bank_payment_ibbl) ?></td>
        <td><strong>
          <?= ($total_14_net_payable + $total_B_net_payable) ?>
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
          <?= $total_14_actual_basic_salary + $total_C_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_14_actual_special_allawance + $total_C_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_14_ta_da_data + $total_C_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)($total_14_basic_salary_payable + $total_C_basic_salary_payable); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_spl_alw_data + $total_C_spl_alw_data); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_ta_da + $total_C_ta_da); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_house_rent + $total_C_house_rent); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_vehicle_allowance + $total_C_vehicle_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_food_allowance + $total_C_food_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_mobile_allowance + $total_C_mobile_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_benefits + $total_C_benefits); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_other_benefits + $total_C_other_benefits); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_income_tax + $total_C_income_tax); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_advance_install + $total_C_advance_install); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_cooperative_share + $total_C_cooperative_share); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_motorcycle_install + $total_C_motorcycle_install); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_deduction + $total_C_deduction); ?>
          </strong></td>
        <td>&nbsp;</td>
        <td><?= ($total_14_help_up_paid + $total_C_help_up_paid) ?></td>
        <td><strong>
          <?= ($total_14_cash_payment + $total_C_cash_payment) ?>
          </strong></td>
        <td><?= ($total_14_bank_payment_dbbl + $total_C_bank_payment_dbbl) ?></td>
        <td><?= ($total_14_bank_payment_ibbl + $total_C_bank_payment_ibbl) ?></td>
        <td><strong>
          <?= ($total_14_net_payable + $total_C_net_payable) ?>
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
          <?= $total_14_actual_basic_salary + $total_D_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_14_actual_special_allawance + $total_D_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_14_ta_da_data + $total_D_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)($total_14_basic_salary_payable + $total_D_basic_salary_payable); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_spl_alw_data + $total_D_spl_alw_data); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_ta_da + $total_D_ta_da); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_house_rent + $total_D_house_rent); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_vehicle_allowance + $total_D_vehicle_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_food_allowance + $total_D_food_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_mobile_allowance + $total_D_mobile_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_benefits + $total_D_benefits); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_other_benefits + $total_D_other_benefits); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_income_tax + $total_D_income_tax); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_advance_install + $total_D_advance_install); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_cooperative_share + $total_D_cooperative_share); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_motorcycle_install + $total_D_motorcycle_install); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_deduction + $total_D_deduction); ?>
          </strong></td>
        <td>&nbsp;</td>
        <td><?= ($total_14_help_up_paid + $total_D_help_up_paid) ?></td>
        <td><strong>
          <?= ($total_14_cash_payment + $total_D_cash_payment) ?>
          </strong></td>
        <td><?= ($total_14_bank_payment_dbbl + $total_D_bank_payment_dbbl) ?></td>
        <td><?= ($total_14_bank_payment_ibbl + $total_D_bank_payment_ibbl) ?></td>
        <td><strong>
          <?= ($total_14_net_payable + $total_D_net_payable) ?>
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
        <td><strong>
          <?= $total_14_actual_basic_salary + $total_E_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_14_actual_special_allawance + $total_E_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_14_ta_da_data + $total_E_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)($total_14_basic_salary_payable + $total_E_basic_salary_payable); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_spl_alw_data + $total_E_spl_alw_data); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_ta_da + $total_E_ta_da); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_house_rent + $total_E_house_rent); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_vehicle_allowance + $total_E_vehicle_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_food_allowance + $total_E_food_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_mobile_allowance + $total_E_mobile_allowance); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_benefits + $total_E_benefits); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_other_benefits + $total_E_other_benefits); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_income_tax + $total_E_income_tax); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_advance_install + $total_E_advance_install); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_cooperative_share + $total_E_cooperative_share); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_motorcycle_install + $total_E_motorcycle_install); ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_deduction + $total_E_deduction); ?>
          </strong></td>
        <td>&nbsp;</td>
        <td><?= ($total_14_help_up_paid + $total_E_help_up_paid) ?></td>
        <td><strong>
          <?= ($total_14_cash_payment + $total_E_cash_payment) ?>
          </strong></td>
        <td><?= ($total_14_bank_payment_dbbl + $total_E_bank_payment_dbbl) ?></td>
        <td><?= ($total_14_bank_payment_ibbl + $total_E_bank_payment_ibbl) ?></td>
        <td><strong>
          <?= ($total_14_net_payable + $total_E_net_payable) ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td><strong>
          <?= ($total_14_actual_basic_salary * 5) + $total_A_actual_basic_salary + $total_B_actual_basic_salary + $total_C_actual_basic_salary + $total_D_actual_basic_salary + $total_E_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_actual_special_allawance * 5) + $total_A_actual_special_allawance + $total_B_actual_special_allawance + $total_C_actual_special_allawance + $total_D_actual_special_allawance + $total_E_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= ($total_14_ta_da_data * 5) + $total_A_ta_da_data + $total_B_ta_da_data + $total_C_ta_da_data + $total_D_ta_da_data + $total_E_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= ((int)($total_14_basic_salary_payable * 5) + $total_A_basic_salary_payable + $total_B_basic_salary_payable + $total_C_basic_salary_payable + $total_D_basic_salary_payable + $total_E_basic_salary_payable); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_spl_alw_data * 5) + $total_A_spl_alw_data + $total_B_spl_alw_data + $total_C_spl_alw_data + $total_D_spl_alw_data + $total_E_spl_alw_data); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_ta_da * 5) + $total_A_ta_da + $total_B_ta_da + $total_C_ta_da + $total_D_ta_da + $total_E_ta_da); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_house_rent * 5) + $total_A_house_rent + $total_B_house_rent + $total_C_house_rent + $total_D_house_rent + $total_E_house_rent); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_vehicle_allowance * 5) + $total_A_vehicle_allowance + $total_B_vehicle_allowance + $total_C_vehicle_allowance + $total_D_vehicle_allowance + $total_E_vehicle_allowance); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_food_allowance * 5) + $total_A_food_allowance + $total_B_food_allowance + $total_C_food_allowance + $total_D_food_allowance + $total_E_food_allowance); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_mobile_allowance * 5) + $total_A_mobile_allowance + $total_B_mobile_allowance + $total_C_mobile_allowance + $total_D_mobile_allowance + $total_E_mobile_allowance); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_benefits * 5) + $total_A_benefits + $total_B_benefits + $total_C_benefits + $total_D_benefits + $total_E_benefits); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_other_benefits * 5) + $total_A_other_benefits + $total_B_other_benefits + $total_C_other_benefits + $total_D_other_benefits + $total_E_other_benefits); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_income_tax * 5) + $total_A_income_tax + $total_B_income_tax + $total_C_income_tax + $total_D_income_tax + $total_E_income_tax); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_advance_install * 5) + $total_A_advance_install + $total_B_advance_install + $total_C_advance_install + $total_D_advance_install + $total_E_advance_install); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_cooperative_share * 5) + $total_A_cooperative_share + $total_B_cooperative_share + $total_C_cooperative_share + $total_D_cooperative_share + $total_E_cooperative_share); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_motorcycle_install * 5) + $total_A_motorcycle_install + $total_B_motorcycle_install + $total_C_motorcycle_install + $total_D_motorcycle_install + $total_E_motorcycle_install); ?>
          </strong></td>
        <td><strong>
          <?= (($total_14_deduction * 5) + $total_A_deduction + $total_B_deduction + $total_C_deduction + $total_D_deduction + $total_E_deduction); ?>
          </strong></td>
        <td>&nbsp;</td>
        <td><?= (($total_14_help_up_paid * 5) + $total_A_help_up_paid + $total_B_help_up_paid + $total_C_help_up_paid + $total_D_help_up_paid + $total_E_help_up_paid) ?></td>
        <td><strong>
          <?= (($total_14_cash_payment * 5) + $total_A_cash_payment + $total_B_cash_payment + $total_C_cash_payment + $total_D_cash_payment + $total_E_cash_payment) ?>
          </strong></td>
        <td><?= (($total_14_bank_payment_dbbl * 5) + $total_A_bank_payment_dbbl + $total_B_bank_payment_dbbl + $total_C_bank_payment_dbbl + $total_D_bank_payment_dbbl + $total_E_bank_payment_dbbl) ?></td>
        <td><?= (($total_14_bank_payment_ibbl * 5) + $total_A_bank_payment_ibbl + $total_B_bank_payment_ibbl + $total_C_bank_payment_ibbl + $total_D_bank_payment_ibbl + $total_E_bank_payment_ibbl) ?></td>
        <td><strong>
          <?= (($total_14_net_payable * 5) + $total_A_net_payable + $total_B_net_payable + $total_C_net_payable + $total_D_net_payable + $total_E_net_payable) ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 7801) { // Region Wise Sales Salary Brief Report(Without HO)































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="31"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Region Name</th>
        <th colspan="3">Basic Information </th>
        <th colspan="9"> <div>Salary and Allowance (At Actual) Taka </div></th>
        <th colspan="6"> <div>Deduction</div></th>
        <th colspan="6"> <div>Payable Amount (Taka) </div></th>
        <th colspan="4"> <div>View Only </div></th>
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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region>0 and t.pbi_department="Sales" ' . $PBI_GROUP_con . ' group by t.pbi_region';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= find_a_field('branch', 'BRANCH_NAME', 'BRANCH_ID=' . $data->PBI_BRANCH) ?></td>
        <td><?= round($data->actual_basic_salary) ?>
          <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary; ?></td>
        <td><?= round($data->actual_special_allawance) ?>
          <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance; ?></td>
        <td><?= round($data->ta_da_data) ?>
          <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data; ?></td>
        <td><?= round($data->basic_salary_payable) ?>
          <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable; ?></td>
        <td><?= round($data->special_allowance) ?>
          <? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance; ?></td>
        <td><?= round($data->ta_da) ?>
          <? $total_ta_da = $total_ta_da + $data->ta_da; ?></td>
        <td><?= round($data->house_rent) ?>
          <? $total_house_rent = $total_house_rent + $data->house_rent; ?></td>
        <td><?= round($data->vehicle_allowance) ?>
          <? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance; ?></td>
        <td><?= round($data->food_allowance) ?>
          <? $total_food_allowance = $total_food_allowance + $data->food_allowance; ?></td>
        <td><?= round($data->mobile_allowance) ?>
          <? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance; ?></td>
        <td><?= round($data->benefits) ?>
          <? $total_benefits = $total_benefits + $data->benefits; ?></td>
        <td><?= round($data->other_benefits) ?>
          <? $total_other_benefits = $total_other_benefits + $data->other_benefits; ?></td>
        <td><?= round($data->income_tax) ?>
          <? $total_income_tax = $total_income_tax + $data->income_tax; ?></td>
        <td><?= round($data->total_install) ?>
          <? $total_advance_install = $total_advance_install + $data->total_install; ?></td>
        <td><?= round($data->cooperative_share) ?>
          <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share; ?></td>
        <td><?= round($data->motorcycle_install) ?>
          <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install; ?></td>
        <td><?= round($data->deduction) ?>
          <? $total_deduction = $total_deduction + $data->deduction; ?></td>
        <td><?= round($data->administrative_deduction) ?>
          <? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction; ?></td>
        <td><? echo $help_up_paid = round(find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up="1" and t.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con));
								$total_help_up_paid = $total_help_up_paid + $help_up_paid; ?></td>
        <td><? echo $cash_paid = round(find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up="0" and t.PBI_ID=a.PBI_ID  and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con));
								$total_cash_payment = $total_cash_payment + $cash_paid; ?></td>
        <td><? echo $dbbl_paid = round(find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up="0" and t.bank_name="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con));
								$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid; ?></td>
        <td><? echo $rocket_paid = round(find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up="0" and t.bank_name="ROCKET" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con));
								$total_bank_payment_rocket = $total_bank_payment_rocket + $rocket_paid; ?></td>
        <td><? echo $ibbl_paid = round(find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up="0" and t.bank_name="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con));
								$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid; ?></td>
        <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = round(find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up="0" and t.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.pbi_region="' . $data->PBI_BRANCH . '" ' . $PBI_GROUP_con));
																					$total_net_payable = $total_net_payable + $net_payable; ?></span></td>
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
        <td><strong>
          <?= round($total_actual_basic_salary); ?>
          </strong></td>
        <td><strong>
          <?= round($total_actual_special_allawance); ?>
          </strong></td>
        <td><strong>
          <?= round($total_ta_da_data); ?>
          </strong></td>
        <td><strong>
          <?= round($total_basic_salary_payable); ?>
          </strong></td>
        <td><strong>
          <?= round($total_spl_alw_data); ?>
          </strong></td>
        <td><strong>
          <?= round($total_ta_da); ?>
          </strong></td>
        <td><strong>
          <?= round($total_house_rent); ?>
          </strong></td>
        <td><strong>
          <?= round($total_vehicle_allowance); ?>
          </strong></td>
        <td><strong>
          <?= round($total_food_allowance); ?>
          </strong></td>
        <td><strong>
          <?= round($total_mobile_allowance); ?>
          </strong></td>
        <td><strong>
          <?= round($total_benefits); ?>
          </strong></td>
        <td><strong>
          <?= round($total_other_benefits); ?>
          </strong></td>
        <td><strong>
          <?= round($total_income_tax); ?>
          </strong></td>
        <td><strong>
          <?= round($total_advance_install); ?>
          </strong></td>
        <td><strong>
          <?= round($total_cooperative_share); ?>
          </strong></td>
        <td><strong>
          <?= round($total_motorcycle_install); ?>
          </strong></td>
        <td><strong>
          <?= round($total_deduction); ?>
          </strong></td>
        <td><strong>
          <?= round($total_administrative_deduction); ?>
          </strong></td>
        <td><strong>
          <?= round($total_help_up_paid); ?>
          </strong></td>
        <td><strong>
          <?= round($total_cash_payment); ?>
          </strong></td>
        <td><strong>
          <?= round($total_bank_payment_dbbl); ?>
          </strong></td>
        <td><strong>
          <?= round($total_bank_payment_rocket); ?>
          </strong></td>
        <td><strong>
          <?= round($total_bank_payment_ibbl); ?>
          </strong></td>
        <td><strong>
          <?= round($total_net_payable); ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  In words:
  <?= convertNumberMhafuz($total_net_payable); ?>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 922) {















		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="1">
    <thead>
      <tr>
        <th style="border:0px;" colspan="13"><?= $str ?>
          Employee Name :
          <?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID=' . $_POST['pbi_id_in']); ?>
        </th>
      </tr>
      <tr style="border: 0;">
        <td colspan="13" style="border: 0;">&nbsp;</td>
      </tr>
      <tr style="border: 0;">
        <td colspan="13" style="border: 0;">&nbsp;</td>
      </tr>
      <tr style="border: 0;">
        <td colspan="13" style="border: 0;">&nbsp;</td>
      </tr>
      <tr style="font-size: 12px;">
        <th>বছর</th>
        <th>বর্ণনা</th>
        <th>প্রারম্ভিক স্থিতি</th>
        <th>বছরের চাঁদা </th>
        <th>অগ্রিম আদায়</th>
        <th> অগ্রিম প্রদান </th>
        <th>মোট</th>
        <th>প্রারম্ভিক স্থিতির উপর লভ্যাংশ</th>
        <th>বাৎসরিক চাঁদার উপর লভ্যাংশ </th>
        <th>বৎসরের মোট লভ্যাংশ </th>
        <th>বৎসরের সর্বমোট টাকা </th>
      </tr>
    </thead>
    <tbody>
      <?















					$period = $_POST['year'] . "06";







					$period_from = ($_POST['year'] - 1) . "07";























					if ($_POST['pbi_id_in'] != '') {
						$pbi_con = ' and j.PBI_ID="' . $_POST['pbi_id_in'] . '"';
					};















					$sqld = 'select j.fascicle_year as year,j.PBI_ID,j.period from salary_pl_journal j where 1 ' . $pbi_con . ' group by fascicle_year ';















					$queryd = db_query($sqld);















					while ($data = mysqli_fetch_object($queryd)) {















































					?>
      <tr>
        <td rowspan="3"><? $before_year = $data->year;
											echo --$before_year;
											echo "-" . $data->year ?></td>
        <td style="font-size: 12px">নিজস্ব চাঁদা : </td>
        <td><?







								$my_year_tax1 = find_a_field('salary_pl_journal', 'sum(amt_in)', ' 1 and fascicle_year="' . $data->year . '" and PBI_ID="' . $data->PBI_ID . '" and tr_from in ("Own Pf Opening Interest")');































								?>
          <? $my_before_year_stay = $my_grand_total + $my_year_tax1;
								echo number_format($my_before_year_stay, 2); ?></td>
        <td><?







								$my_year_tax = find_a_field('salary_pl_journal', 'sum(amt_in)', ' 1 and fascicle_year="' . $data->year . '" and PBI_ID="' . $data->PBI_ID . '" and tr_from in ("Salary")');















								echo number_format($my_year_tax, 2);















								?>
        </td>
        <td><?







								$my_advanced_gotten = find_a_field('salary_pl_journal', 'sum(amt_in)', ' 1 and fascicle_year="' . $data->year . '" and PBI_ID="' . $data->PBI_ID . '" and tr_from in ("Loan Return","Loan Return Opening")');







								echo number_format($my_advanced_gotten, 2); ?>
        </td>
        <td><?







								$my_year_advance_given = find_a_field('salary_pl_journal', 'sum(amt_out)', ' 1 and fascicle_year="' . $data->year . '" and PBI_ID="' . $data->PBI_ID . '" and tr_from in ("Loan","Loan Opening") ');
								echo number_format($my_year_advance_given, 2); ?>
        </td>
        <td><? $my_total = (($my_before_year_stay + $my_year_tax + $my_advanced_gotten) - $my_year_advance_given);
								echo number_format($my_total, 2); ?></td>
        <td><?























								$my_gov_given_percen_on_year = find_a_field('pl_gov', 'gov_per', 'year="' . $data->year . '"');















								//$my_before_year_stay_profit = ((($my_before_year_stay/100)*$my_gov_given_percen_on_year)/12*6) ; echo number_format($my_before_year_stay_profit,2);







								$my_before_year_stay_profit = ((($my_before_year_stay / 100) * $my_gov_given_percen_on_year));
								echo number_format($my_before_year_stay_profit, 2);







								?></td>
        <td><?















								//$my_year_tax_on_profit = (((($my_year_tax+$my_advanced_gotten)/100)*$my_gov_given_percen_on_year)/2/12*6);







								$my_year_tax_on_profit = (((($my_year_tax + $my_advanced_gotten) / 100) * $my_gov_given_percen_on_year) / 2);







								echo number_format($my_year_tax_on_profit, 2);







								?></td>
        <td><? $my_year_total_profit = ($my_before_year_stay_profit + $my_year_tax_on_profit);
								echo number_format($my_year_total_profit, 2); ?></td>
        <td><? $my_grand_total = ($my_total + $my_year_total_profit);
								echo number_format($my_grand_total, 2); ?>
        </td>
      </tr>
      <tr style="color:red;">
        <td style="font-size: 12px">অনুদান :</td>
        <td><? $gov_year_gov_tax1 = find_a_field('salary_pl_journal', 'sum(amt_in)', ' 1 and fascicle_year="' . $data->year . '" and PBI_ID="' . $data->PBI_ID . '" and tr_from in ("Gov Pf Opening Interest")'); ?>
          <? $gov_before_year_stay = $gov_grand_total + $gov_year_gov_tax1;
								echo number_format($gov_before_year_stay, 2); ?>
        </td>
        <td><? $gov_year_gov_tax = find_a_field('salary_pl_journal', 'sum(amt_in)', ' 1 and fascicle_year="' . $data->year . '" and PBI_ID="' . $data->PBI_ID . '" and tr_from in ("Government")');
								echo number_format($gov_year_gov_tax, 2); ?>
        </td>
        <td><? $gov_advanced_gotten = 0;
								echo number_format($gov_advanced_gotten, 2); ?>
        </td>
        <td><? $gov_year_advance_given = 0;
								echo number_format($gov_year_advance_given, 2); ?>
        </td>
        <td><? $gov_total = (($gov_before_year_stay + $gov_year_gov_tax + $gov_advanced_gotten) - $gov_year_advance_given);
								echo number_format($gov_total, 2); ?>
        </td>
        <td><?







								$gov_gov_given_percen_on_year = find_a_field('pl_gov', 'gov_per', 'year="' . $data->year . '"');







								//$gov_before_year_stay_profit = ((($gov_before_year_stay/100)*$gov_gov_given_percen_on_year)/12*6);







								$gov_before_year_stay_profit = ((($gov_before_year_stay / 100) * $gov_gov_given_percen_on_year));







								echo number_format($gov_before_year_stay_profit, 2);







								?>
        </td>
        <td><?







								//$gov_year_tax_on_profit = (((($gov_year_gov_tax+$gov_advanced_gotten)/100)*$gov_gov_given_percen_on_year)/2/12*6);







								$gov_year_tax_on_profit = (((($gov_year_gov_tax + $gov_advanced_gotten) / 100) * $gov_gov_given_percen_on_year) / 2);







								echo number_format($gov_year_tax_on_profit, 2);







								?>
        </td>
        <td><? $gov_year_total_profit = ($gov_before_year_stay_profit + $gov_year_tax_on_profit);
								echo number_format($gov_year_total_profit, 2); ?>
        </td>
        <td><? $gov_grand_total = ($gov_total + $gov_year_total_profit);
								echo number_format($gov_grand_total, 2); ?>
        </td>
      </tr>
      <tr>
        <td style="font-size: 12px"><b> মোট : </b></td>
        <td><b>
          <? $grand_before_year_stay = ($my_before_year_stay + $gov_before_year_stay);
									echo number_format($grand_before_year_stay, 2) ?>
          </b></td>
        <td><b>
          <? $grand_year_tax = ($my_year_tax + $gov_year_gov_tax);
									echo number_format($grand_year_tax, 2) ?>
          </b></td>
        <td><b>
          <? $grand_advanced_gotten = ($my_advanced_gotten + $gov_advanced_gotten);
									echo number_format($grand_advanced_gotten, 2) ?>
          </b></td>
        <td><b>
          <? $grand_year_advance_given = ($my_year_advance_given + $gov_year_advance_given);
									echo number_format($grand_year_advance_given, 2) ?>
          </b></td>
        <td><b>
          <? $grand_total = ($gov_total + $my_total);
									echo number_format($grand_total, 2) ?>
          </b> </td>
        <td><b>
          <? $grand_before_year_stay_profit = ($gov_before_year_stay_profit + $my_before_year_stay_profit);
									echo number_format($grand_before_year_stay_profit, 2) ?>
          </b></td>
        <td><b>
          <? $grand_year_tax_on_profit = ($gov_year_tax_on_profit + $my_year_tax_on_profit);
									echo number_format($grand_year_tax_on_profit, 2) ?>
          </b></td>
        <td><b>
          <? $grand_year_total_profit = ($gov_year_total_profit + $my_year_total_profit);
									echo number_format($grand_year_total_profit, 2) ?>
          </b></td>
        <td><b>
          <? $g_g_total = ($gov_grand_total + $my_grand_total);
									echo number_format($g_g_total, 2) ?>
          </b></td>
      </tr>
      <?















					}















					?>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 7800) {































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="28"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Store Name</th>
        <th rowspan="3">Nos</th>
        <th colspan="3">Basic Information </th>
        <th colspan="9"> <div>Salary and Allowance (At Actual) Taka </div></th>
        <th colspan="6"> <div>Deduction</div></th>
        <th colspan="5"> <div>Payable Amount (Taka) </div></th>
        <th> <div>View Only </div></th>
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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s,office_location o where o.ID=a.JOB_LOCATION and d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT like "%STO%" ' . $DEPARTMENT_con . ' group by a.JOB_LOCATION';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $data->LOCATION_NAME ?></td>
        <td><?= $data->nos ?>
          <? $total_nos = $total_nos + $data->nos ?></td>
        <td><?= (int)$data->actual_basic_salary ?>
          <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary; ?></td>
        <td><?= (int)$data->actual_special_allawance ?>
          <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance; ?></td>
        <td><?= $data->ta_da_data ?>
          <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data; ?></td>
        <td><?= (int)$data->basic_salary_payable ?>
          <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable; ?></td>
        <td><?= (int)$data->special_allowance ?>
          <? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance; ?></td>
        <td><?= $data->ta_da ?>
          <? $total_ta_da = $total_ta_da + $data->ta_da; ?></td>
        <td><?= round($data->house_rent); ?>
          <? $total_house_rent = $total_house_rent + $data->house_rent; ?></td>
        <td><?= $data->vehicle_allowance ?>
          <? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance; ?></td>
        <td><?= $data->food_allowance ?>
          <? $total_food_allowance = $total_food_allowance + $data->food_allowance; ?></td>
        <td><?= $data->mobile_allowance ?>
          <? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance; ?></td>
        <td><?= $data->benefits ?>
          <? $total_benefits = $total_benefits + $data->benefits; ?></td>
        <td><?= $data->other_benefits ?>
          <? $total_other_benefits = $total_other_benefits + $data->other_benefits; ?></td>
        <td><?= $data->income_tax ?>
          <? $total_income_tax = $total_income_tax + $data->income_tax; ?></td>
        <td><?= $data->total_install ?>
          <? $total_advance_install = $total_advance_install + $data->total_install; ?></td>
        <td><?= $data->cooperative_share ?>
          <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share; ?></td>
        <td><?= $data->motorcycle_install ?>
          <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install; ?></td>
        <td><?= $data->deduction ?>
          <? $total_deduction = $total_deduction + $data->deduction; ?></td>
        <td><?= number_format($data->administrative_deduction) ?>
          <? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction; ?></td>
        <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and a.JOB_LOCATION="' . $data->JOB_LOCATION . '" ' . $DEPARTMENT_con);
								$total_help_up_paid = $total_help_up_paid + $help_up_paid; ?></td>
        <td><? echo $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and a.JOB_LOCATION="' . $data->JOB_LOCATION . '" ' . $DEPARTMENT_con);
								$total_cash_payment = $total_cash_payment + $cash_paid; ?></td>
        <td><? echo $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and a.JOB_LOCATION="' . $data->JOB_LOCATION . '" ' . $DEPARTMENT_con);
								$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid; ?></td>
        <td><? echo $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and a.JOB_LOCATION="' . $data->JOB_LOCATION . '" ' . $DEPARTMENT_con);
								$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid; ?></td>
        <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and a.JOB_LOCATION="' . $data->JOB_LOCATION . '" ' . $DEPARTMENT_con);
																					$total_net_payable = $total_net_payable + $net_payable; ?></span></td>
        <td>&nbsp;</td>
        <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
      </tr>
      <?















					}















					?>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td><strong>
          <?= $total_nos; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)$total_basic_salary_payable; ?>
          </strong></td>
        <td><strong>
          <?= $total_spl_alw_data; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da; ?>
          </strong></td>
        <td><strong>
          <?= round($total_house_rent); ?>
          </strong></td>
        <td><strong>
          <?= $total_vehicle_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_food_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_mobile_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_other_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_income_tax; ?>
          </strong></td>
        <td><strong>
          <?= $total_advance_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_cooperative_share; ?>
          </strong></td>
        <td><strong>
          <?= $total_motorcycle_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_deduction; ?>
          </strong></td>
        <td><strong>
          <?= $total_administrative_deduction; ?>
          </strong></td>
        <td><?= $total_help_up_paid ?></td>
        <td><strong>
          <?= $total_cash_payment ?>
          </strong></td>
        <td><?= $total_bank_payment_dbbl ?></td>
        <td><?= $total_bank_payment_ibbl ?></td>
        <td><strong>
          <?= $total_net_payable ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 784) {































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="28"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Department</th>
        <th rowspan="3">Nos</th>
        <th colspan="3">Basic Information </th>
        <th colspan="9"> <div>Salary and Allowance (At Actual) Taka </div></th>
        <th colspan="6"> <div>Deduction</div></th>
        <th colspan="5"> <div>Payable Amount (Taka) </div></th>
        <th> <div>View Only </div></th>
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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID  and PBI_ORG in (1,2) and t.pbi_region =0 group by a.PBI_DEPARTMENT';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;















					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= find_a_field('department', 'DEPT_DESC', 'DEPT_SHORT_NAME="' . $data->PBI_DEPARTMENT . '"') ?></td>
        <td><?= $data->nos ?>
          <? $total_nos = $total_nos + $data->nos ?></td>
        <td><?= (int)$data->actual_basic_salary ?>
          <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary; ?></td>
        <td><?= (int)$data->actual_special_allawance ?>
          <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance; ?></td>
        <td><?= $data->ta_da_data ?>
          <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data; ?></td>
        <td><?= (int)$data->basic_salary_payable ?>
          <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable; ?></td>
        <td><?= (int)$data->special_allowance ?>
          <? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance; ?></td>
        <td><?= $data->ta_da ?>
          <? $total_ta_da = $total_ta_da + $data->ta_da; ?></td>
        <td><?= $data->house_rent ?>
          <? $total_house_rent = $total_house_rent + $data->house_rent; ?></td>
        <td><?= round($data->vehicle_allowance) ?>
          <? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance; ?></td>
        <td><?= $data->food_allowance ?>
          <? $total_food_allowance = $total_food_allowance + $data->food_allowance; ?></td>
        <td><?= $data->mobile_allowance ?>
          <? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance; ?></td>
        <td><?= $data->benefits ?>
          <? $total_benefits = $total_benefits + $data->benefits; ?></td>
        <td><?= $data->other_benefits ?>
          <? $total_other_benefits = $total_other_benefits + $data->other_benefits; ?></td>
        <td><?= $data->income_tax ?>
          <? $total_income_tax = $total_income_tax + $data->income_tax; ?></td>
        <td><?= $data->total_install ?>
          <? $total_advance_install = $total_advance_install + $data->total_install; ?></td>
        <td><?= $data->cooperative_share ?>
          <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share; ?></td>
        <td><?= $data->motorcycle_install ?>
          <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install; ?></td>
        <td><?= $data->deduction ?>
          <? $total_deduction = $total_deduction + $data->deduction; ?></td>
        <td><?= number_format($data->administrative_deduction) ?>
          <? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction; ?></td>
        <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and a.PBI_DEPARTMENT="' . $data->PBI_DEPARTMENT . '" and PBI_ORG in (1,2) and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_help_up_paid = $total_help_up_paid + $help_up_paid; ?></td>
        <td><? echo $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and a.PBI_DEPARTMENT="' . $data->PBI_DEPARTMENT . '"  and PBI_ORG in (1,2) and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . '');
								$total_cash_payment = $total_cash_payment + $cash_paid; ?></td>
        <td><? echo $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and a.PBI_DEPARTMENT="' . $data->PBI_DEPARTMENT . '" and PBI_ORG in (1,2) and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid; ?></td>
        <td><? echo $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and a.PBI_DEPARTMENT="' . $data->PBI_DEPARTMENT . '" and PBI_ORG in (1,2) and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid; ?></td>
        <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and a.PBI_DEPARTMENT="' . $data->PBI_DEPARTMENT . '" and PBI_ORG in (1,2) and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
																					$total_net_payable = $total_net_payable + $net_payable; ?></span></td>
        <td>&nbsp;</td>
        <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
      </tr>
      <?















					}















					?>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td><strong>
          <?= $total_nos; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)$total_basic_salary_payable; ?>
          </strong></td>
        <td><strong>
          <?= $total_spl_alw_data; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da; ?>
          </strong></td>
        <td><strong>
          <?= $total_house_rent; ?>
          </strong></td>
        <td><strong>
          <?= round($total_vehicle_allowance); ?>
          </strong></td>
        <td><strong>
          <?= $total_food_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_mobile_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_other_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_income_tax; ?>
          </strong></td>
        <td><strong>
          <?= $total_advance_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_cooperative_share; ?>
          </strong></td>
        <td><strong>
          <?= $total_motorcycle_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_deduction; ?>
          </strong></td>
        <td>&nbsp;</td>
        <td><?= $total_help_up_paid ?></td>
        <td><strong>
          <?= $total_cash_payment ?>
          </strong></td>
        <td><?= $total_bank_payment_dbbl ?></td>
        <td><?= $total_bank_payment_ibbl ?></td>
        <td><strong>
          <?= $total_net_payable ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  In words:
  <?= convertNumberMhafuz($total_net_payable); ?>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 7841) {































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="28"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Department</th>
        <th rowspan="3">Nos</th>
        <th colspan="3">Basic Information </th>
        <th colspan="9"> <div>Salary and Allowance (At Actual) Taka </div></th>
        <th colspan="6"> <div>Deduction</div></th>
        <th colspan="5"> <div>Payable Amount (Taka) </div></th>
        <th> <div>View Only </div></th>
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















d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . '















and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and PBI_ORG in (1,2)















and t.pbi_department not in ("STO", "Store (Transport)","Admin (Support Service Section)","CR")















and t.pbi_region =0















group by t.pbi_department';































					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;































					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= find_a_field('department', 'DEPT_DESC', 'DEPT_SHORT_NAME="' . $data->PBI_DEPARTMENT . '"') ?></td>
        <td><?= (int)$data->nos ?>
          <? $total_nos = $total_nos + $data->nos; ?></td>
        <td><?= (int)$data->actual_basic_salary ?>
          <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary; ?></td>
        <td><?= (int)$data->actual_special_allawance ?>
          <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance; ?></td>
        <td><?= $data->ta_da_data ?>
          <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data; ?></td>
        <td><?= (int)$data->basic_salary_payable ?>
          <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable; ?></td>
        <td><?= (int)$data->special_allowance ?>
          <? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance; ?></td>
        <td><?= $data->ta_da ?>
          <? $total_ta_da = $total_ta_da + $data->ta_da; ?></td>
        <td><?= round($data->house_rent) ?>
          <? $total_house_rent = $total_house_rent + $data->house_rent; ?></td>
        <td><?= round($data->vehicle_allowance) ?>
          <? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance; ?></td>
        <td><?= $data->food_allowance ?>
          <? $total_food_allowance = $total_food_allowance + $data->food_allowance; ?></td>
        <td><?= $data->mobile_allowance ?>
          <? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance; ?></td>
        <td><?= $data->benefits ?>
          <? $total_benefits = $total_benefits + $data->benefits; ?></td>
        <td><?= $data->other_benefits ?>
          <? $total_other_benefits = $total_other_benefits + $data->other_benefits; ?></td>
        <td><?= $data->income_tax ?>
          <? $total_income_tax = $total_income_tax + $data->income_tax; ?></td>
        <td><?= $data->total_install ?>
          <? $total_advance_install = $total_advance_install + $data->total_install; ?></td>
        <td><?= $data->cooperative_share ?>
          <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share; ?></td>
        <td><?= $data->motorcycle_install ?>
          <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install; ?></td>
        <td><?= $data->deduction ?>
          <? $total_deduction = $total_deduction + $data->deduction; ?></td>
        <td><?= number_format($data->administrative_deduction) ?>
          <? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction; ?></td>
        <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '" and PBI_ORG in (1,2) and t.pbi_department not in ("STO", "Store (Transport)") and t.pbi_department !="Admin (Support Service Section)" and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_help_up_paid = $total_help_up_paid + $help_up_paid; ?></td>
        <td><? echo $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '"  and PBI_ORG in (1,2) and t.pbi_department not in ("STO", "Store (Transport)") and t.pbi_department !="Admin (Support Service Section)" and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . '');
								$total_cash_payment = $total_cash_payment + $cash_paid; ?></td>
        <td><? echo $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '" and PBI_ORG in (1,2) and t.pbi_department not in ("STO", "Store (Transport)") and t.pbi_department !="Admin (Support Service Section)" and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid; ?></td>
        <td><? echo $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '" and PBI_ORG in (1,2) and t.pbi_department not in ("STO", "Store (Transport)") and t.pbi_department !="Admin (Support Service Section)" and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid; ?></td>
        <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '" and PBI_ORG in (1,2) and t.pbi_department not in ("STO", "Store (Transport)") and t.pbi_department !="Admin (Support Service Section)" and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
																					$total_net_payable = $total_net_payable + $net_payable; ?></span></td>
        <td>&nbsp;</td>
        <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
      </tr>
      <?















					}















					?>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td><strong>
          <?= $total_nos ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)$total_basic_salary_payable; ?>
          </strong></td>
        <td><strong>
          <?= $total_spl_alw_data; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da; ?>
          </strong></td>
        <td><strong>
          <?= round($total_house_rent); ?>
          </strong></td>
        <td><strong>
          <?= round($total_vehicle_allowance); ?>
          </strong></td>
        <td><strong>
          <?= $total_food_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_mobile_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_other_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_income_tax; ?>
          </strong></td>
        <td><strong>
          <?= $total_advance_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_cooperative_share; ?>
          </strong></td>
        <td><strong>
          <?= $total_motorcycle_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_deduction; ?>
          </strong></td>
        <td><strong>
          <?= round($total_administrative_deduction); ?>
          </strong></td>
        <td><?= $total_help_up_paid ?></td>
        <td><strong>
          <?= $total_cash_payment ?>
          </strong></td>
        <td><?= $total_bank_payment_dbbl ?></td>
        <td><?= $total_bank_payment_ibbl ?></td>
        <td><strong>
          <?= $total_net_payable ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  In words:
  <?= convertNumberMhafuz($total_net_payable); ?>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 78411) {































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="30"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Department</th>
        <th rowspan="3">Nos</th>
        <th colspan="3">Basic Information </th>
        <th colspan="9"> <div>Salary and Allowance (At Actual) Taka </div></th>
        <th colspan="6"> <div>Deduction</div></th>
        <th colspan="7"> <div>Payable Amount (Taka) </div></th>
        <th> <div>View Only </div></th>
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















					if ($_POST['PBI_ORG'] > 0) $org_con = ' and PBI_ORG ="' . $_POST['PBI_ORG'] . '" ';















					if ($_POST['JOB_LOCATION'] != '') {
						$location_con = ' and t.pbi_job_location = "' . $_POST['JOB_LOCATION'] . '"';
					}































					$sqld = 'select t.pbi_department PBI_DEPARTMENT, t.pbi_job_location as job_location,















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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation















and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0















' . $org_con . $location_con . ' group by t.pbi_department';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;































					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= find_a_field('department', 'DEPT_DESC', 'DEPT_SHORT_NAME="' . $data->PBI_DEPARTMENT . '"') ?></td>
        <td><?= (int)$data->nos ?>
          <? $total_nos = $total_nos + $data->nos; ?></td>
        <td><?= (int)$data->actual_basic_salary ?>
          <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary; ?></td>
        <td><?= (int)$data->actual_special_allawance ?>
          <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance; ?></td>
        <td><?= $data->ta_da_data ?>
          <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data; ?></td>
        <td><?= (int)$data->basic_salary_payable ?>
          <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable; ?></td>
        <td><?= (int)$data->special_allowance ?>
          <? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance; ?></td>
        <td><?= $data->ta_da ?>
          <? $total_ta_da = $total_ta_da + $data->ta_da; ?></td>
        <td><?= $data->house_rent ?>
          <? $total_house_rent = $total_house_rent + $data->house_rent; ?></td>
        <td><?= round($data->vehicle_allowance) ?>
          <? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance; ?></td>
        <td><?= $data->food_allowance ?>
          <? $total_food_allowance = $total_food_allowance + $data->food_allowance; ?></td>
        <td><?= $data->mobile_allowance ?>
          <? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance; ?></td>
        <td><?= $data->benefits ?>
          <? $total_benefits = $total_benefits + $data->benefits; ?></td>
        <td><?= $data->other_benefits ?>
          <? $total_other_benefits = $total_other_benefits + $data->other_benefits; ?></td>
        <td><?= $data->income_tax ?>
          <? $total_income_tax = $total_income_tax + $data->income_tax; ?></td>
        <td><?= $data->total_install ?>
          <? $total_advance_install = $total_advance_install + $data->total_install; ?></td>
        <td><?= $data->cooperative_share ?>
          <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share; ?></td>
        <td><?= $data->motorcycle_install ?>
          <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install; ?></td>
        <td><?= $data->deduction ?>
          <? $total_deduction = $total_deduction + $data->deduction; ?></td>
        <td><?= number_format($data->administrative_deduction) ?>
          <? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction; ?></td>
        <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_help_up_paid = $total_help_up_paid + $help_up_paid; ?></td>
        <td><? echo $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '" and t.pbi_job_location="' . $data->job_location . '"  ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . '');
								$total_cash_payment = $total_cash_payment + $cash_paid; ?></td>
        <td><? echo $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid; ?></td>
        <td><? echo $ebl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="EBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_ebl = $total_bank_payment_ebl + $ebl_paid; ?></td>
        <td><? echo $ncc_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="NCC" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_ncc = $total_bank_payment_ncc + $ncc_paid; ?></td>
        <td><? echo $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid; ?></td>
        <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_department="' . $data->PBI_DEPARTMENT . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
																					$total_net_payable = $total_net_payable + $net_payable; ?></span></td>
        <td>&nbsp;</td>
        <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
      </tr>
      <?















					}















					?>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td><strong>
          <?= $total_nos ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)$total_basic_salary_payable; ?>
          </strong></td>
        <td><strong>
          <?= $total_spl_alw_data; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da; ?>
          </strong></td>
        <td><strong>
          <?= $total_house_rent; ?>
          </strong></td>
        <td><strong>
          <?= round($total_vehicle_allowance); ?>
          </strong></td>
        <td><strong>
          <?= $total_food_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_mobile_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_other_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_income_tax; ?>
          </strong></td>
        <td><strong>
          <?= $total_advance_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_cooperative_share; ?>
          </strong></td>
        <td><strong>
          <?= $total_motorcycle_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_deduction; ?>
          </strong></td>
        <td><strong>
          <?= round($total_administrative_deduction); ?>
          </strong></td>
        <td><?= $total_help_up_paid ?></td>
        <td><strong>
          <?= $total_cash_payment ?>
          </strong></td>
        <td><?= $total_bank_payment_dbbl ?></td>
        <td><?= $total_bank_payment_ebl ?></td>
        <td><?= $total_bank_payment_ncc ?></td>
        <td><?= $total_bank_payment_ibbl ?></td>
        <td><strong>
          <?= $total_net_payable ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  In words:
  <?= convertNumberMhafuz($total_net_payable); ?>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 78412) {































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="30"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Location</th>
        <th rowspan="3">Nos</th>
        <th colspan="3">Basic Information </th>
        <th colspan="9"> <div>Salary and Allowance (At Actual) Taka </div></th>
        <th colspan="6"> <div>Deduction</div></th>
        <th colspan="7"> <div>Payable Amount (Taka) </div></th>
        <th> <div>View Only </div></th>
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















					if ($_POST['PBI_ORG'] > 0) $org_con = ' and PBI_ORG ="' . $_POST['PBI_ORG'] . '" ';















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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 ' . $org_con . ' group by t.pbi_job_location';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;































					?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= find_a_field('office_location', 'LOCATION_NAME', 'ID="' . $data->job_location . '"') ?></td>
        <td><?= (int)$data->nos ?>
          <? $total_nos = $total_nos + $data->nos; ?></td>
        <td><?= (int)$data->actual_basic_salary ?>
          <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary; ?></td>
        <td><?= (int)$data->actual_special_allawance ?>
          <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance; ?></td>
        <td><?= $data->ta_da_data ?>
          <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data; ?></td>
        <td><?= (int)$data->basic_salary_payable ?>
          <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable; ?></td>
        <td><?= (int)$data->special_allowance ?>
          <? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance; ?></td>
        <td><?= $data->ta_da ?>
          <? $total_ta_da = $total_ta_da + $data->ta_da; ?></td>
        <td><?= $data->house_rent ?>
          <? $total_house_rent = $total_house_rent + $data->house_rent; ?></td>
        <td><?= round($data->vehicle_allowance) ?>
          <? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance; ?></td>
        <td><?= $data->food_allowance ?>
          <? $total_food_allowance = $total_food_allowance + $data->food_allowance; ?></td>
        <td><?= $data->mobile_allowance ?>
          <? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance; ?></td>
        <td><?= $data->benefits ?>
          <? $total_benefits = $total_benefits + $data->benefits; ?></td>
        <td><?= $data->other_benefits ?>
          <? $total_other_benefits = $total_other_benefits + $data->other_benefits; ?></td>
        <td><?= $data->income_tax ?>
          <? $total_income_tax = $total_income_tax + $data->income_tax; ?></td>
        <td><?= $data->total_install ?>
          <? $total_advance_install = $total_advance_install + $data->total_install; ?></td>
        <td><?= $data->cooperative_share ?>
          <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share; ?></td>
        <td><?= $data->motorcycle_install ?>
          <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install; ?></td>
        <td><?= $data->deduction ?>
          <? $total_deduction = $total_deduction + $data->deduction; ?></td>
        <td><?= number_format($data->administrative_deduction) ?>
          <? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction; ?></td>
        <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="' . $data->job_location . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_help_up_paid = $total_help_up_paid + $help_up_paid; ?></td>
        <td><? echo $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="' . $data->job_location . '"  ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . '');
								$total_cash_payment = $total_cash_payment + $cash_paid; ?></td>
        <td><? echo $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location="' . $data->job_location . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid; ?></td>
        <td><? echo $ebl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="EBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location="' . $data->job_location . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_ebl = $total_bank_payment_ebl + $ebl_paid; ?></td>
        <td><? echo $ncc_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="NCC" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location="' . $data->job_location . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_ncc = $total_bank_payment_ncc + $ncc_paid; ?></td>
        <td><? echo $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID and t.pbi_job_location="' . $data->job_location . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid; ?></td>
        <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_job_location="' . $data->job_location . '" ' . $org_con . ' and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
																					$total_net_payable = $total_net_payable + $net_payable; ?></span></td>
        <td>&nbsp;</td>
        <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
      </tr>
      <?















					}















					?>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td><strong>
          <?= $total_nos ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)$total_basic_salary_payable; ?>
          </strong></td>
        <td><strong>
          <?= $total_spl_alw_data; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da; ?>
          </strong></td>
        <td><strong>
          <?= $total_house_rent; ?>
          </strong></td>
        <td><strong>
          <?= round($total_vehicle_allowance); ?>
          </strong></td>
        <td><strong>
          <?= $total_food_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_mobile_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_other_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_income_tax; ?>
          </strong></td>
        <td><strong>
          <?= $total_advance_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_cooperative_share; ?>
          </strong></td>
        <td><strong>
          <?= $total_motorcycle_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_deduction; ?>
          </strong></td>
        <td><strong>
          <?= round($total_administrative_deduction); ?>
          </strong></td>
        <td><?= $total_help_up_paid ?></td>
        <td><strong>
          <?= $total_cash_payment ?>
          </strong></td>
        <td><?= $total_bank_payment_dbbl ?></td>
        <td><?= $total_bank_payment_ebl ?></td>
        <td><?= $total_bank_payment_ncc ?></td>
        <td><?= $total_bank_payment_ibbl ?></td>
        <td><strong>
          <?= $total_net_payable ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  In words:
  <?= convertNumberMhafuz($total_net_payable); ?>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		} elseif ($_POST['report'] == 7842) {































		?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="29"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="3">S/L</th>
        <th rowspan="3">Department</th>
        <th rowspan="3">Location</th>
        <th rowspan="3">Nos</th>
        <th colspan="3">Basic Information </th>
        <th colspan="9"> <div>Salary and Allowance (At Actual) Taka </div></th>
        <th colspan="6"> <div>Deduction</div></th>
        <th colspan="5"> <div>Payable Amount (Taka) </div></th>
        <th> <div>View Only </div></th>
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































from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and pbi_organization in (1,2,12) and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) )   group by t.pbi_job_location';















					$queryd = db_query($sqld);































					while ($data = mysqli_fetch_object($queryd)) {















						$entry_by = $data->entry_by;































					?>
      <tr>
        <td><?= ++$s ?></td>
        <td>Admin (Support Service Section)</td>
        <td><?= find_a_field('office_location', 'LOCATION_NAME', 'id="' . $data->pbi_job_location . '"') ?></td>
        <td><?= (int)$data->nos ?>
          <? $total_nos = $total_nos + $data->nos; ?></td>
        <td><?= (int)$data->actual_basic_salary ?>
          <? $total_actual_basic_salary = $total_actual_basic_salary + $data->actual_basic_salary; ?></td>
        <td><?= (int)$data->actual_special_allawance ?>
          <? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance; ?></td>
        <td><?= $data->ta_da_data ?>
          <? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data; ?></td>
        <td><?= (int)$data->basic_salary_payable ?>
          <? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable; ?></td>
        <td><?= (int)$data->special_allowance ?>
          <? $total_spl_alw_data = $total_spl_alw_data + $data->special_allowance; ?></td>
        <td><?= $data->ta_da ?>
          <? $total_ta_da = $total_ta_da + $data->ta_da; ?></td>
        <td><?= round($data->house_rent) ?>
          <? $total_house_rent = $total_house_rent + $data->house_rent; ?></td>
        <td><?= $data->vehicle_allowance ?>
          <? $total_vehicle_allowance = $total_vehicle_allowance + $data->vehicle_allowance; ?></td>
        <td><?= $data->food_allowance ?>
          <? $total_food_allowance = $total_food_allowance + $data->food_allowance; ?></td>
        <td><?= $data->mobile_allowance ?>
          <? $total_mobile_allowance = $total_mobile_allowance + $data->mobile_allowance; ?></td>
        <td><?= $data->benefits ?>
          <? $total_benefits = $total_benefits + $data->benefits; ?></td>
        <td><?= $data->other_benefits ?>
          <? $total_other_benefits = $total_other_benefits + $data->other_benefits; ?></td>
        <td><?= $data->income_tax ?>
          <? $total_income_tax = $total_income_tax + $data->income_tax; ?></td>
        <td><?= $data->total_install ?>
          <? $total_advance_install = $total_advance_install + $data->total_install; ?></td>
        <td><?= $data->cooperative_share ?>
          <? $total_cooperative_share = $total_cooperative_share + $data->cooperative_share; ?></td>
        <td><?= $data->motorcycle_install ?>
          <? $total_motorcycle_install = $total_motorcycle_install + $data->motorcycle_install; ?></td>
        <td><?= $data->deduction ?>
          <? $total_deduction = $total_deduction + $data->deduction; ?></td>
        <td><?= number_format($data->administrative_deduction) ?>
          <? $total_administrative_deduction = $total_administrative_deduction + $data->administrative_deduction; ?></td>
        <td><? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) )  and t.pbi_job_location ="' . $data->pbi_job_location . '" and pbi_organization in (1,2,12) and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_help_up_paid = $total_help_up_paid + $help_up_paid; ?></td>
        <td><? echo $cash_paid = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(t.total_payable-t.bank_paid)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) )   and t.pbi_job_location ="' . $data->pbi_job_location . '"  and pbi_organization in (1,2,12) and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . '');
								$total_cash_payment = $total_cash_payment + $cash_paid; ?></td>
        <td><? echo $dbbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID  and t.pbi_job_location ="' . $data->pbi_job_location . '" and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) )  and pbi_organization in (1,2,12) and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid; ?></td>
        <td><? echo $ibbl_paid = find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ', 'sum(t.bank_paid)', 't.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID and s.PBI_ID=a.PBI_ID  and t.pbi_job_location ="' . $data->pbi_job_location . '" and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) ) and pbi_organization in (1,2,12) and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
								$total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid; ?></td>
        <td><span style="text-align:right; font-weight:bold;"><?php echo $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ', 'sum(total_payable)', 't.pbi_held_up=0 and t.PBI_ID=a.PBI_ID  and t.pbi_job_location ="' . $data->pbi_job_location . '" and ( t.pbi_department  = "Admin (Support Service Section)" or( t.pbi_department  = "ADM" and  t.pbi_job_location in (24,22,68)) )  and pbi_organization in (1,2,12) and t.pbi_region =0 and t.mon=' . $_POST['mon'] . ' and t.year=' . $_POST['year'] . ' ');
																					$total_net_payable = $total_net_payable + $net_payable; ?></span></td>
        <td>&nbsp;</td>
        <td style="color:#FF0000; font-weight:bold">&nbsp;</td>
      </tr>
      <?















					}















					?>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td><strong>
          <?= $total_nos ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_basic_salary; ?>
          </strong></td>
        <td><strong>
          <?= $total_actual_special_allawance; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da_data; ?>
          </strong></td>
        <td><strong>
          <?= (int)$total_basic_salary_payable; ?>
          </strong></td>
        <td><strong>
          <?= $total_spl_alw_data; ?>
          </strong></td>
        <td><strong>
          <?= $total_ta_da; ?>
          </strong></td>
        <td><strong>
          <?= round($total_house_rent); ?>
          </strong></td>
        <td><strong>
          <?= $total_vehicle_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_food_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_mobile_allowance; ?>
          </strong></td>
        <td><strong>
          <?= $total_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_other_benefits; ?>
          </strong></td>
        <td><strong>
          <?= $total_income_tax; ?>
          </strong></td>
        <td><strong>
          <?= $total_advance_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_cooperative_share; ?>
          </strong></td>
        <td><strong>
          <?= $total_motorcycle_install; ?>
          </strong></td>
        <td><strong>
          <?= $total_deduction; ?>
          </strong></td>
        <td><strong>
          <?= $total_administrative_deduction; ?>
          </strong></td>
        <td><?= $total_help_up_paid ?></td>
        <td><strong>
          <?= $total_cash_payment ?>
          </strong></td>
        <td><?= $total_bank_payment_dbbl ?></td>
        <td><?= $total_bank_payment_ibbl ?></td>
        <td><strong>
          <?= $total_net_payable ?>
          </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  In words:
  <?= convertNumberMhafuz($total_net_payable); ?>
  <style type="text/css">
				#new td {















					border-bottom: 0px solid #000000;















					border-left: 0px solid #000000;















					border-right: 0px solid #000000;















					text-align: center;















					padding: 2px 10px;















				}
			</style>
  <br />
  <?















		}







		//Payslip English Format







		elseif ($_POST['report'] == 799) { // salary payslip view















			if ($_POST['pbi_id_in'] != '') {







				$pay_con = ' and p.PBI_CODE="' . $_POST['pbi_id_in'] . '"';
			}







			if ($_POST['PBI_DESIGNATION'] != '') {







				$pay_con = ' and p.PBI_DESIGNATION="' . $_POST['PBI_DESIGNATION'] . '"';
			}







			if ($_POST['department'] != '') {







				$pay_con2 = ' and p.DEPT_ID="' . $_POST['department'] . '"';
			}







			if ($_POST['PBI_CODE'] != '') {







				$pay_con = ' and p.PBI_CODE="' . $_POST['PBI_CODE'] . '"';
			}







			if ($_POST['PBI_PROJECT'] != '') {







				$pay_con = ' and p.PBI_PROJECT="' . $_POST['PBI_PROJECT'] . '"';
			}







			if ($_POST['mon'] != '') {



				$pay_con .= ' and s.mon="' . $_POST['mon'] . '"';
			}











			if ($_POST['year'] != '') {



				$pay_con .= ' and s.year="' . $_POST['year'] . '"';
			}















			$sql79 = 'select s.*,p.PBI_NAME,p.PBI_CODE,p.PBI_PROJECT,p.PBI_EMAIL,p.PBI_DESIGNATION,p.PBI_DEPARTMENT from salary_attendence s,personnel_basic_info p where s.PBI_ID=p.PBI_ID ' . $pay_con . $pay_con2 . ' ';



			$res = db_query($sql79);



			$ig = -1;
			while ($data = mysqli_fetch_object($res)) {



			?>
  <div <? if (($ig % 4) == 0 && ($ig > 2)) echo 'style="position:relative;display:block; width:100%; float: none; page-break-after:always; page-break-inside:avoid"'; ?>>
    <? $ig++; ?>
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
      <thead>
        <tr>
          <th style="border:0px;" colspan="33" align="center"><?= $str ?></th>
        </tr>
        <!--<td style="border:0px;" colspan="8"><div class="header"><h1>NETRAKONA ACCESSORIES LTD.</h1>



	<h3>House: 102(2nd Floor),Road# Northern, West Side D.O.H.S Baridhara, Dhaka-1206, Bangladesh.</h3>















  <h2>Pay Slip <?= date('F', mktime(0, 0, 0, $mon, 15, 2000)) ?> <?= $yea ?></h2></div></td>-->
        <tr>
          <th>Staff Picture</th>
          <th>Staff_Information</th>
          <th>Attendence_Info</th>
          <th>Salary_Information</th>
          <th> Other_Benefits</th>
          <th>Deduction/Meal</th>
          <th>Payable_Salary</th>
          <th>Signature</th>
        </tr>
      </thead>
      <tbody>
        <tr style="height:130px;">
          <td align="center" style="text-align:center"><p><img src="../../pic/staff/<?= $data->PBI_ID ?>.jpg" alt="" width="98" height="101" border="1" /></p></td>
          <td align="center">ID: <strong>
            <?= $data->PBI_CODE ?>
            </strong><br />
            Name: <strong>
            <?= $data->PBI_NAME ?>
            </strong><br />
            Designation: <strong>
            <?= $data->PBI_DESIGNATION ?>
            </strong><br />
            Department: <strong>
            <?= $data->PBI_DEPARTMENT ?>
            </strong></td>
          <td align="right">Present Days:<strong>
            <?= $data->pre ?>
            </strong><br />
            Leave Days:<strong>
            <?= $data->lv ?>
            </strong><br />
            Late Days:<strong>
            <?= $data->lt ?>
            </strong><br />
            Absent Days:<strong>
            <?= $data->ab ?>
            </strong><br />
            Total Days:<strong>
            <?= $data->td ?>
            </strong><br />
            Payable Days:<strong>
            <?= $data->pay ?>

            </strong></td>
          <td align="center" style="text-align:right">Basic Salary:<strong>
            <?= $data->basic_salary ?>
            </strong><br />
            House Rent:<strong>
            <?= $data->house_rent ?>
            </strong><br />
            Medical All:<strong>
            <?= $data->medical_allowance ?>
            </strong><br />
            Other All:<strong>
            <?= $data->other_allowance ?>
            </strong><br />
            Special All:<strong>
            <?= $data->special_allowance ?>
            </strong><br />
            Mobile All:<strong>
            <? //=$data->mobile_allowance 
										?>
            </strong><br />
            Total Sal:<strong>
            <?= ($data->total_salary - $data->total_benefits); ?>
            <? //=($data->total_salary + $data->mobile_allowance)
										?>
            </strong></td>
          <td align="center" style="text-align:right">Bonus Amt:<strong>
            <?= $data->bonus_amt ?>
            </strong><br />
            Over-Time Amt:<strong>
            <?= ($data->total_benefits - ($data->benefits + $data->bonus_amt)) ?>
            </strong><br />
            Benefits:<strong>
            <?= $data->benefits ?>
            </strong><br />
            Total Benefits: <strong>
            <?= $data->total_benefits ?>
            </strong></td>
          <td align="center" style="text-align:right">Absent Deduction:<strong>
            <?= ($data->total_deduction - ($data->advance_install + $data->other_install + $data->deduction)) ?>
            </strong><br />
            Advance Install:<strong>
            <?= $data->advance_install ?>
            </strong><br />
            Other Install:<strong>
            <?= $data->other_install ?>
            </strong><br />
            Meal/ Deduction:<strong>
            <?= $data->deduction ?>
            </strong><br />
            Total Deduction:<strong>
            <?= $data->total_deduction ?>
            </strong></td>
          <td align="center" style="text-align:right">Total Sal:<strong>
            <?= $data->total_salary ?>
            <? //=($data->total_salary+$data->mobile_allowance)
										?>
            </strong><br />
            Total Benefits:<strong>
            <?php /*?> <?=$data->total_benefits?><?php */ ?>
            </strong><br />
            Total Ded:<strong>
            <?= $data->total_deduction ?>
            </strong><br />
            Total Payable:<strong>
            <?= ($data->total_salary - $data->total_deduction) ?>
            <? //+($data->total_benefits-$data->total_deduction)-=-=-=-= //=($data->total_salary+$data->mobile_allowance)+($data->total_benefits-$data->total_deduction)
										?>
            </strong></td>
          <td align="center" style="text-align:right">................................<br />
            (<strong>
            <?= $data->PBI_NAME; ?>
            </strong>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
      <br />
      <br />
      <? } ?>
    </table>
  </div>
  <br />
  <br />
  <br />
  <br />
  <?











		} elseif ($_POST['report'] == 79) {















			if ($_POST['pbi_id_in'] != '') {







				$pay_con = ' and p.PBI_ID="' . $_POST['pbi_id_in'] . '"';
			}







			if ($_POST['mon'] != '') {



				$pay_con .= ' and s.mon="' . $_POST['mon'] . '"';
			}











			if ($_POST['year'] != '') {



				$pay_con .= ' and s.year="' . $_POST['year'] . '"';
			}























			$pay = 'select s.*,p.PBI_NAME,p.PBI_EMAIL,p.PBI_DESIGNATION as designation,p.PBI_DEPARTMENT as department, p.PBI_MOBILE as mobile, b.gross_salary







from salary_attendence s,personnel_basic_info p, salary_info b







where s.PBI_ID=p.PBI_ID and s.basic_salary=b.basic_salary ' . $pay_con . ' ';







			$qry = db_query($pay);



			$paySlip = mysqli_fetch_object($qry);















			//while($paySlip = mysqli_fetch_object($qry)){



















			?>
  <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" style="font-size:16px;" class="tabledesign">
    <tr>
      <td style="border:0px;">&nbsp;
        <button type="button" id="print" onClick="hide();window.print();">Print</button></td>
    </tr>
    <tr style="line-height:0px;">
      <td style="border:0px; font-size:15px; font-weight:bold;"><?= $_SESSION['company_name'] ?></td>
      <td style="border:0px;" rowspan="5" align="right"><img src="<?=SERVER_ROOT?>public/uploads/logo/tecno.png" style="height:110px; width:120px;"></td>
    </tr>
    <tr style="line-height:0px;">
      <td style="border:0px; font-size:15px; font-weight:bold;">Pay Slip</td>
    </tr>
    <tr style="line-height:0px;">
      <td style="border:0px; font-size:15px; font-weight:bold;"><span style="font-size:15px; font-weight:bold;">Period :
        <? $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');



								$_SESSION['year'] = $_POST['year'];



								echo date_format($test, 'M-Y'); ?>
        </span></td>
    </tr>
    <tr style="line-height:0px;">
      <td style="border:0px; font-size:15px; font-weight:bold;">Issued by HR Division</td>
    </tr>
    <!--<tr style="line-height:0px;">



	    <td style="border:0px;"><button id="print" onClick="hide(),window.print();">PRINT/PDF</button></td>



	 </tr>-->
  </table>
  <!-- <table width="600" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:16px;">















    <tr>



      <td  align="left" style="border:0px;"><span style="font-size:18px; font-weight:bold;"><?= $_SESSION['company_name'] ?></span></td>



	  <td rowspan="4" style="border:0px;"  align="right"><img src="<?=SERVER_ROOT?>public/uploads/logo/upay.PNG" style="height:155px; width:155px; margin-left:-80%;"></td>



    </tr>







    <tr style="line-height:3px;">







      <td style="border:0px;" align="left"><span style="font-size:16px; font-weight:bold;">Pay Slip</span></td>







    </tr>







    <tr>







      <td style="border:0px;" align="left"  ><span style="font-size:16px; font-weight:bold;">Period :











        <? $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');



















			$_SESSION['year'] = $_POST['year'];







			echo date_format($test, 'M-Y'); ?>















        </span></td>



















    </tr>







	<tr style="line-height:3px;">















      <td style="border:0px;" align="left"><span style="font-size:16px; font-weight:bold;">Issued by HR Division</span></td>















    </tr>







	<tr style="line-height:3px;">















      <td style="border:0px;" align="left"><button id="print" onClick="hide(),window.print();">PRINT/PDF</button></td>















    </tr>







  </table>-->
  <table width="600" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:15px;" class="tabledesign">
    <tr>
      <td style="border:0px;"><table width="600" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:15px;">
          <tr>
            <td>Name</td>
            <td align="center">:</td>
            <td colspan="3"><?= $paySlip->PBI_NAME ?></td>
          </tr>
          <tr>
            <td>Employee ID</td>
            <td align="center">:</td>
            <td colspan="3"><?= $paySlip->PBI_ID ?></td>
          </tr>
          <tr>
            <td>Department</td>
            <td align="center">:</td>
            <td colspan="3"><?= $paySlip->department ?></td>
          </tr>
          <tr>
            <td>Designation</td>
            <td align="center">:</td>
            <td colspan="3"><?= $paySlip->designation ?></td>
          </tr>
          <tr>
            <td>Mobile</td>
            <td align="center">:</td>
            <td colspan="3"><?= $paySlip->mobile ?></td>
          </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left"><strong>Pay Component Description</strong></td>
            <td><strong>Amount (BDT)</strong></td>
            <td colspan="2"><strong>Subtotal Amount (BDT)</strong></td>
          </tr>
          <tr>
            <td colspan="5" align="left" style="font-size:15px;"><strong>Addition (A)</strong></td>
          </tr>
          <tr>
            <td colspan="2" align="left">Basic Salary</td>
            <td align="right"><? if ($paySlip->basic_salary > 0) echo number_format($paySlip->basic_salary, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left">House Rent</td>
            <td align="right"><? if ($paySlip->house_rent > 0) echo number_format($paySlip->house_rent, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left">Medical Allowance</td>
            <td align="right"><? if ($paySlip->medical_allowance > 0) echo number_format($paySlip->medical_allowance, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left">Other Allowance</td>
            <td align="right"><? if ($paySlip->other_allowance > 0) echo number_format($paySlip->other_allowance, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><strong>Gross</strong></td>
            <td align="right"><? if ($paySlip->gross_salary > 0) echo number_format($gross = $paySlip->gross_salary, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left">Arrears</td>
            <td align="right"><? if ($paySlip->salary_arrear > 0) echo number_format($arrear = $paySlip->salary_arrear, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left">Mobile Bill</td>
            <td align="right"><? if ($paySlip->mobile_allowance > 0) echo number_format($mobile_bill = $paySlip->mobile_allowance, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left">Bonus Amount</td>
            <td align="right">&nbsp;</td>
            <td colspan="2" align="right">-</td>
          </tr>
          <tr>
            <td colspan="2" align="left" style="font-size:15px; font-weight:bold;"><strong>Total Gross</strong></td>
            <td align="right"></td>
            <td colspan="2" align="right"><? $total_gross = $gross + $arrear + $mobile_bill;
																	if ($total_gross > 0) echo number_format($total_gross, 2);
																	else echo '-'; ?></td>
          </tr>
          <tr>
            <td colspan="5" align="left" style="font-size:15px;"><strong>Deduction (B)</strong></td>
          </tr>
          <tr>
            <td colspan="2" align="left">PF (Employee Contribution)</td>
            <td align="right"><? if ($paySlip->pf_deduction > 0) echo number_format($pf = $paySlip->pf_deduction, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left">Income Tax</td>
            <td align="right"><? if ($paySlip->income_tax > 0) echo number_format($income_tax = $paySlip->income_tax, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left">Absent</td>
            <td align="right"><? if ($paySlip->absent_deduction > 0) echo number_format($absent_deduction = $paySlip->absent_deduction, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left">Late</td>
            <td align="right"><? if ($paySlip->late_deduction > 0) echo number_format($late_deduction = $paySlip->late_deduction, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left">LWP</td>
            <td align="right"><? if ($paySlip->lwp_deduction > 0) echo number_format($lwp_deduction = $paySlip->lwp_deduction, 0);
														else echo '-'; ?></td>
            <td colspan="2" align="right"></td>
          </tr>
          <tr>
            <td colspan="2" align="left" style="font-size:15px; font-weight:bold;"><strong>Deductions Subtotal</strong></td>
            <td align="right"></td>
            <td align="right"><? if ($paySlip->total_deduction > 0) echo number_format($total_deduction = $paySlip->total_deduction, 0);
														else echo '-'; ?></td>
            <!--   <td colspan="2" align="right"><? $total_deduction = $income_tax + $pf;
																			if ($total_deduction > 0) echo number_format($total_deduction, 2);
																			else echo '-'; ?></td>-->
          </tr>
        </table></td>
    </tr>
    <tr>
      <td style="border:0px;"><table width="600" align="center" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td style="border:0px;" colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td style="border:0px;" colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td style="border:0px; font-size:15px; font-weight:bold;" align="left">Net Payment (BDT) = </td>
            <td style="border:0px; font-size:15px; font-weight:bold;" align="center">Payments(A) - Deductions(B)</td>
            <td style="border:0px; font-size:15px;" align="right"><input type="text" value="<? if ($paySlip->total_payable > 0) echo number_format($total_payable = $paySlip->total_payable, 0);
																													else echo '-'; ?>" readonly style="text-align:right; height:30px; width:120px; font-weight:bold;"></td>
          </tr>
          <tr>
            <td style="border:0px;" colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td style="border:0px;" colspan="3">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td style="border:0px;"><table width="600" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:15px;">
          <tr>
            <td style="border:0px" colspan="5">&nbsp;</td>
          </tr>
          <tr>
            <td style="border:0px; font-size:12px;" align="left" colspan="5">Note: <br>
              • This is a system generated copy and therefore no authorized signature is required.<br>
              • Net salary payable amount has been transferred to your respective bank account. Please check the above salary statement and inform HR immediately if you detect any error for necessary correction. </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td style="border:0px;">&nbsp;</td>
    </tr>
    <tr>
      <td style="border:0px;">&nbsp;</td>
    </tr>
  </table>
  <!--<div style="width:100px"><? //include('PrintFormat.php');
												?></div>



  <div id="reporting">



  <table cellspacing="0" cellpadding="0" border="0" id="grp" width="100%">



   <thead>



  <tr>



  <td style="border:0px;">&nbsp;</td>



  </tr>



  </thead>



  </table>-->
  <? //} 
				?>
  <?































			}















			//Payslip Bangla Format







			elseif ($_POST['report'] == 31032020) {































































				if ($_POST['pbi_id_in'] != '') {































































					$pay_con = ' and p.PBI_CODE="' . $_POST['pbi_id_in'] . '"';
				}















































				if ($_POST['mon'] != '') {















































					$pay_con .= ' and s.mon="' . $_POST['mon'] . '"';
				}































































				if ($_POST['year'] != '') {















































					$pay_con .= ' and s.year="' . $_POST['year'] . '"';
				}































































				if ($_POST['department'] != '') {































					$pay_con .= ' and s.department="' . $_POST['department'] . '"';
				}































































				if ($_POST['job_status'] != '') {















































					$pay_con .= ' and p.PBI_JOB_STATUS="' . $_POST['job_status'] . '"';
				}































				if ($_POST['JOB_LOCATION'] != '') {















































					$pay_con .= ' and p.JOB_LOCATION="' . $_POST['JOB_LOCATION'] . '"';
				}















































				$pay = 'select s.*,p.PBI_NAME,p.PBI_CODE,(select DESG_DESC from designation where DESG_ID=s.designation) as designation,(select DEPT_DESC from department where DEPT_ID=s.department) as department,















 (select unit_name from business_unit where id=s.job_location) as project from salary_attendence s,personnel_basic_info p where s.PBI_ID=p.PBI_ID ' . $pay_con . ' ';































































				$qry = db_query($pay);















































				while ($paySlip = mysqli_fetch_object($qry)) {















































				?>
  <table width="100%" align="center">
    <tr>
      <td style="border:0px;" align="center"><span style="font-size:18px; font-weight:bold;">ইআরপি.কম.বিডি লিমিটেড</span></td>
    </tr>
    <tr>
      <td style="border:0px;" align="center"><span lang="bn"><span title="">বেতন স্লিপ</span></span></td>
    </tr>
    <tr>
      <td style="border:0px;" align="center"><span style="font-size:12px; font-weight:bold;"><span lang="bn"><span title="">সময়কাল</span></span> :
        <? $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');































































































































									$_SESSION['year'] = $_POST['year'];































































































































									echo date_format($test, 'M-Y'); ?>
        </span></td>
    </tr>
  </table>
  <table width="600" border="1" cellpadding="2" cellspacing="0" align="center" style="font-size:normal 12px  thoma;">
    <tr>
      <td colspan="5" align="center"><span lang="bn"><span title="">মৌলিক তথ্য</span></span></td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">কর্মচারী আইডি</span></span></td>
      <td colspan="2"><?= $paySlip->PBI_CODE ?></td>
      <td><span lang="bn"><span title="">নাম</span></span></td>
      <td><?= $paySlip->PBI_NAME ?></td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">পদবি</span></span></td>
      <td colspan="2"><?= $paySlip->designation ?></td>
      <td><span lang="bn"><span title="">ডিপার্টমেন্ট</span></span></td>
      <td><?= $paySlip->department ?></td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">ব্যবসায় ইউনিট</span></span></td>
      <td colspan="4"><?= $paySlip->project ?></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><span lang="bn"><span title="">বিবরণ</span></span></td>
      <td>পরিমাণ </td>
      <td colspan="2">ছাড</td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">বেসিক </span></span></td>
      <td colspan="2" align="center"><?= $paySlip->basic_salary ?></td>
      <td> মোবাইল বিল</td>
      <td><?= ($paySlip->mobile_deduction > 0) ? $paySlip->mobile_deduction : ''; ?></td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">বাড়ি ভাড়া </span></span></td>
      <td colspan="2" align="center"><?= $paySlip->house_rent ?></td>
      <td>কর</td>
      <td><?= ($paySlip->income_tax > 0) ? $paySlip->income_tax : ''; ?></td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">মেডিকেল </span></span></td>
      <td colspan="2" align="center"><?= $paySlip->medical_allowance ?></td>
      <td>খাবার</td>
      <td><?= ($paySlip->food_deduction > 0) ? $paySlip->food_deduction : ''; ?></td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">পরিবহন <span lang="bn"><span title="">পরিবহন </span></span></span></span></td>
      <td colspan="2" align="center"><?= ($paySlip->conveyance_allowance > 0) ? $paySlip->conveyance_allowance : '' ?></td>
      <td><span lang="bn"><span title="">লোন / অগ্রিম</span></span></td>
      <td><?= ($paySlip->advance_install > 0) ? $paySlip->advance_install : ''; ?></td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">বেসিক সমষ্টি: </span></span></td>
      <td colspan="2" align="center"><?= ($paySlip->special_allowance > 0) ? $paySlip->special_allowance : '' ?></td>
      <td>অনুপস্থিত পরিমাণ</td>
      <td><?= ($paySlip->absent_deduction > 0) ? $paySlip->absent_deduction : ''; ?></td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">পারফরম্যান্স বোনাস</span></span></td>
      <td colspan="2" align="center"><?= ($paySlip->performance_bonus > 0) ? $paySlip->performance_bonus : '' ?></td>
      <td> LWP পরিমাণ</td>
      <td><?= ($paySlip->lwp_deduction > 0) ? $paySlip->lwp_deduction : ''; ?></td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">রিসোর্স বোনাস</span></span></td>
      <td colspan="2" align="center"><?= ($paySlip->resourse_bonus > 0) ? $paySlip->resourse_bonus : '' ?></td>
      <td>দেরী ছাড</td>
      <td><?= ($paySlip->late_deduction > 0) ? $paySlip->late_deduction : ''; ?></td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">শিশু ভাতা</span></span></td>
      <td colspan="2" align="center"><?= ($paySlip->child_allowance > 0) ? $paySlip->child_allowance : '' ?></td>
      <td> পিএফ</td>
      <td><?= ($paySlip->pf_deduction > 0) ? $paySlip->pf_deduction : ''; ?></td>
    </tr>
    <!-- <?































								$start = '' . $_POST['year'] . '-' . $_POST['mon'] . '-01';















































								$end = '' . $_POST['year'] . '-' . $_POST['mon'] . '-31';















































								$bonus = find_a_field('salary_bonus', 'bonus_amt', 'cut_off_date between "' . $start . '" and "' . $end . '" and PBI_ID=' . $paySlip->
    PBI_ID);
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    if ($bonus > 0) {
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    ?>
    <tr >
      <td  colspan="2" align="center"><span lang="bn"><span title="">উত্সব বোনাস</span></span></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr >
      <td  colspan="2">ঈদ-উল-ফিতর</td>
      <td ><?= $bonus ?></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <? } ?>
    <tr >
      <td  colspan="2" align="center"><span lang="bn"><span title="">সমন্বয়</span></span></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr >
      <td  colspan="2"><span lang="bn"><span title="">বেতন সমন্বয়</span></span></td>
      <td ><?= ($paySlip->adjustment_amount > 0) ? $paySlip->adjustment_amount : ''; ?></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    -->
    <tr>
      <td><span lang="bn"><span title="">মোট উপার্জন</span></span></td>
      <td colspan="2" align="center"><strong>
        <? $total_earning = $paySlip->gross_salary;
									echo number_format($total_earning, 0); ?>
        </strong></td>
      <td><span lang="bn"><span title="">মোট ছাড়</span></span></td>
      <td><strong>
        <?= $total_deduction = $paySlip->mobile_deduction + $paySlip->food_deduction + $paySlip->advance_install + $paySlip->income_tax + $paySlip->other_deduction + $paySlip->late_deduction + $paySlip->lwp_deduction + $paySlip->absent_deduction + $paySlip->pf_deduction; ?>
        </strong></td>
    </tr>
    <tr>
      <td><span lang="bn"><span title="">নেট বেতন</span></span></td>
      <td><strong>
        <? $net_pay = $total_earning - $total_deduction;
									echo number_format($net_pay, 0); ?>
        </strong></td>
      <td colspan="3"><strong>
        <?= convertNumberMhafuz($net_pay); ?>
        </strong></td>
    </tr>
    <!-- <tr >















      <td colspan="5" align="center"><strong>Payment Details</strong></td>















    </tr>















    <tr >















      <td><strong>Payment Mode</strong></td>















      <td><strong>















        <?















































					if (
						$paySlip->
    bank_or_cash == 1
    ) {
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    echo 'Cash';
    } else {
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    echo 'Bank';
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    ?>
    </strong>
    
    </td>
    
    <td><span lang="bn"><span title="">ব্যাংক হিসাব</span></span></td>
      <td colspan="2"><strong>
        <?= $paySlip->cash; ?>
        </strong></td>
    </tr>
    <tr >
      <td><span lang="bn"><span title="">বেতনের কার্ড নম্বর</span></span></td>
      <td><strong>
        <?= $paySlip->card_no; ?>
        </strong></td>
      <td><span lang="bn"><span title="">ব্যাংকের নাম</span></span></td>
      <td colspan="2"><strong>
        <? if ($paySlip->bank_or_cash != 1) {































						echo 'Eastern Bank Limited';
					} ?>
        </strong></td>
    </tr>
    -->
  </table>
  <? } ?>
  <?































			} elseif ($_POST['report'] == 201) { // Leave Encashment Report































				$company = find_a_field('user_group', 'group_name', 'id=' . $_POST['PBI_ORG']);















			?>
  <center>
    <h1>
      <?= $company ?>
    </h1>
    <strong>Leave Encashment Report Final-2017</strong><br>
    Department:
    <?= $_POST['department'] ?>
    <br>
  </center>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="7"></th>
      </tr>
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















































						$sqld = "select















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















" . $con . "group by a.PBI_ID";















































						$d22 = date("2017-12-31");















						//$d1 = new DateTime('2017-03-20');















						$d2 = new DateTime($d22);















						//$interval = date_diff($d1, $d2);















						//echo $interval->format('%m months');































						$queryd = db_query($sqld);















						while ($data = mysqli_fetch_object($queryd)) {















						?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $data->CODE ?></td>
        <td><?= $data->Name ?></td>
        <td><?= $data->designation ?></td>
        <td><?= $data->department ?></td>
        <td><?= $data->joining_date ?></td>
        <td><?= $data->due_confirmation_date ?></td>
        <td><?= $data->confirmation_date ?></td>
        <td><?= $data->bank ?></td>
        <td><?= $data->bsalary ?></td>
        <td><?= $data->ssalary ?></td>
        <td><?= $data->ta ?></td>
        <td><?php















									if ($data->confirmation_date1 > date("2017-01-14") &&  $data->confirmation_date1 != '0000-00-00') {















										$string = $data->confirmation_date1;















										$timestamp = strtotime($string);















										$tdate = date("d", $timestamp);















										$cd = new DateTime($data->confirmation_date1);















										$interval = date_diff($cd, $d2);































										if ($tdate < 16) {















											$total_leave = $interval->format('%m') * 2.5 + 2.5;















											echo $total_leave;
										} else {















											$total_leave = $interval->format('%m') * 2.5;















											echo $total_leave;
										}
									} elseif ($data->confirmation_date1 < date("2017-01-16") &&  $data->confirmation_date1 != '0000-00-00') {















										$total_leave = 30;
										echo $total_leave;
									} elseif ($data->confirmation_date1 = '0000-00-00') {
										$total_leave = 0;
										echo $total_leave;
									}















									?></td>
        <td><?= $data->leave_consumed ?></td>
        <td><?php $lc = ($total_leave - ($data->leave_consumed));
									echo $lc; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php $pay = ($lc * ($data->bsalary / 30));
									$tpay += $pay;
									echo round($pay, 0); ?></td>
      </tr>
      <?















						}















						?>
      <tr>
        <td colspan="16"><?= convertNumberMhafuz($tpay); ?></td>
        <td><strong>Total</strong></td>
        <td><strong> <?php echo round($tpay, 0); ?> </strong></td>
      </tr>
    </tbody>
  </table>
  <?















			} elseif ($_POST['report'] == 202) {



				// sajeeb group Leave Consumption Report{































				//$f_date = $_REQUEST['f_date'];















				//$t_date = $_REQUEST['t_date'];































				//if(isset($dealer_code)) {$dealer_con=' and d.dealer_code='.$dealer_code;}















				//$date_con = ' and j.ji_date between "'.$f_date.'" and "'.$t_date.'" ';































				// leave table















				$sqlleave = 'SELECT PBI_ID as code, SUM( total_days) as leave1















FROM hrm_leave_info















WHERE type not in("LWP (Leave Without Pay)","Compensatory Off")















and s_date between "2017-01-01" and "2017-12-25"















GROUP BY PBI_ID';































				$res = db_query($sqlleave);















				while ($row = mysqli_fetch_object($res)) {















					$leave1[$row->code] = $row->leave1;
				}































				// salary table















				$sqlsalary = "SELECT PBI_ID as code, SUM(lv) as leave1















FROM salary_attendence a















WHERE year = 2017















and mon between 1 and 12















GROUP BY PBI_ID";































				$res = db_query($sqlsalary);















				while ($row = mysqli_fetch_object($res)) {















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































							$sqlview = "SELECT PBI_ID as code,PBI_NAME,PBI_DESIGNATION,PBI_DEPARTMENT,PBI_ORG,PBI_DOJ















FROM  personnel_basic_info















where PBI_JOB_STATUS = 'In Service'















order by PBI_ID";































							?>
      <?php















							$query = db_query($sqlview);















							while ($data = mysqli_fetch_object($query)) { ?>
      <tr>
        <td><?= ++$op; ?></td>
        <td><?= $data->code ?></td>
        <td><?= $data->PBI_NAME ?></td>
        <td><?= $data->PBI_DESIGNATION ?></td>
        <td><?= $data->PBI_DEPARTMENT ?></td>
        <td><?= $data->PBI_ORG ?></td>
        <td><?= $data->PBI_DOJ ?></td>
        <td><?= $leave1[$data->code] ?></td>
        <td><?= $salary[$data->code] ?></td>
        <td><?= ($leave1[$data->code] - $salary[$data->code]); ?></td>
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















			elseif ($_POST['report'] == 203) {































				$company = find_a_field('user_group', 'group_name', 'id=' . $_POST['PBI_ORG']);















				?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="16"><?= $str ?></th>
      </tr>
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































							$sqld = "select















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















" . $con . "















order by bsalary desc";















































							$queryd = db_query($sqld);















							while ($data = mysqli_fetch_object($queryd)) {















							?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $data->code ?></td>
        <td><?= $data->name ?></td>
        <td><?= $data->designation ?></td>
        <td><?= $data->joining_date ?></td>
        <td><?= $data->confirmation_date ?></td>
        <td><?= $data->bank ?></td>
        <td><?php echo round($data->bsalary, 0);
										$tbsalary += $data->bsalary; ?></td>
        <td><?= $data->leave_quota ?></td>
        <td><?= $data->leave_consumed ?></td>
        <td><?= $data->leave_balance ?></td>
        <td><?php echo round($data->cash_paid, 0);
										$tcash_paid += $data->cash_paid; ?></td>
        <td><?php echo round($data->bank_paid, 0);
										$tbank_paid += $data->bank_paid; ?></td>
        <td><?php echo round($data->damount, 0);
										$tdamount += $data->damount; ?></td>
        <td><?php echo round($data->pamount, 0);
										$tpamount += $data->pamount; ?></td>
        <td>&nbsp;</td>
      </tr>
      <? } ?>
      <tr>
        <td colspan="6" bgcolor="#FFFFCC"><strong><? echo convertNumberMhafuz(round($tpamount, 0)); ?></strong></td>
        <td bgcolor="#FFFFCC"><strong>Total</strong></td>
        <td bgcolor="#FFFFCC"><strong>
          <?= $tbsalary ?>
          </strong></td>
        <td bgcolor="#FFFFCC"></td>
        <td bgcolor="#FFFFCC"></td>
        <td bgcolor="#FFFFCC"></td>
        <td bgcolor="#FFFFCC"><strong>
          <?= round($tcash_paid, 0); ?>
          </strong></td>
        <td bgcolor="#FFFFCC"><strong>
          <?= round($tbank_paid, 0); ?>
          </strong></td>
        <td bgcolor="#FFFFCC"><strong>
          <?= round($tdamount, 0); ?>
          </strong></td>
        <td bgcolor="#FFFFCC"><strong>
          <?= round($tpamount, 0) ?>
          </strong></td>
        <td bgcolor="#FFFFCC">&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <?















			} elseif ($_POST['report'] == 97) {































				$company = find_a_field('user_group', 'group_name', 'id=' . $_POST['PBI_ORG']);















				?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="16"><?= $str ?></th>
      </tr>
      <tr>
        <th>S/L</th>
        <th>Emp ID</th>
        <th>Full Name</th>
        <th>User Name</th>
        <th>Password</th>
      </tr>
    </thead>
    <tbody>
      <?































							$sqld = "select p.PBI_NAME,a.user_name,a.password,a.emp_id from personnel_basic_info p, hrm_user_access a where a.emp_id=p.PBI_ID";















































							$queryd = db_query($sqld);















							while ($data = mysqli_fetch_object($queryd)) {















							?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $data->user_name ?></td>
        <td><?= $data->PBI_NAME ?></td>
        <td><?= $data->user_name ?></td>
        <td><?= $data->password ?></td>
      </tr>
      <? } ?>
    </tbody>
  </table>
  <?















			} elseif ($_POST['report'] == 2454) {































				$report = "Employee Birthday Report";















				?>
  <table style="width: auto; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">
    <tr>
      <td style="border:0px solid white;"><strong>
        <?= $str ?>
        </strong></td>
    </tr>
  </table>
  <table style="width:auto;margin:0 auto;" cellpadding="0" cellspacing="0" border="1">
    <thead>
      <tr>
        <td><strong>Sl</strong></td>
        <td><strong>EMP ID</strong></td>
        <td><strong>NAME</strong></td>
        <td><strong>DESIGNATION</strong></td>
        <td><strong>DEPARTMENT</strong></td>
        <td><strong>PROJECT</strong></td>
        <td><strong>JOINING DATE</strong></td>
        <td><strong>BIRTH DATE</strong></td>
        <td><strong>MOBILE</strong></td>
      </tr>
    </thead>
    <?















						if ($_POST['mon'] != '') {















							if ($_POST['mon'] > 9) {















								$birthDate = ' and DATE_FORMAT(a.PBI_DOB, "%m")="' . $_POST['mon'] . '"';
							} else {















								$birthDate = ' and DATE_FORMAT(a.PBI_DOB, "%m")="0' . $_POST['mon'] . '"';
							}
						}























						$to_d = date('Y-m-d');







































						$basic_sql = "select a.PBI_ID as Emp_ID,  a.PBI_DOB + INTERVAL (YEAR(CURRENT_DATE) - YEAR(a.PBI_DOB))     YEAR AS currbirthday,















    a.PBI_DOB + INTERVAL (YEAR(CURRENT_DATE) - YEAR(a.PBI_DOB)) + 1 YEAR AS nextbirthday   ,DATE_FORMAT(a.PBI_DOB,'%d-%b-%Y') as birth_date,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,(select if(DEPT_DESC='NO DEPARTMENT','',DEPT_DESC) from department where DEPT_ID=a.PBI_DEPARTMENT) as department,(select unit_name from business_unit where id=a.JOB_LOCATION) as project_name,a.PBI_GROUP as `Group`, DATE_FORMAT(a.PBI_DOJ,'%d-%b-%Y') as joining_date,a.PBI_DOJ as total_service_length,a.PBI_MOBILE as mobile  from personnel_basic_info a where 1  " . $con . $birthDate . " ORDER BY CASE























    WHEN currbirthday >= CURRENT_DATE THEN currbirthday























    ELSE nextbirthday















END";























						$basic_query = db_query($basic_sql);























						$sl = 1;















						while ($r = mysqli_fetch_object($basic_query)) {























						?>
    <tr>
      <td><?= $sl++; ?></td>
      <td><?= $r->Emp_ID ?></td>
      <td><?= $r->Name ?></td>
      <td><?= $r->designation ?></td>
      <td><?= $r->department ?></td>
      <td><?= $r->project_name ?></td>
      <td><?= $r->joining_date ?></td>
      <td><?= $r->birth_date ?></td>
      <td><?= $r->mobile ?></td>
    </tr>
    <?































						}























						?>
  </table>
  <?















			} elseif ($_POST['report'] == 979) {
































				$company = find_a_field('user_group', 'group_name', 'id=' . $_POST['PBI_ORG']);















				$report = 'Vehicle Management';















				?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="16"><?= $str ?></th>
      </tr>
      <tr>
        <th rowspan="2">S/L</th>
        <th rowspan="2">Vehicle User</th>
        <th rowspan="2">Designation</th>
        <th rowspan="2">Vehicle Model</th>
        <th rowspan="2">Registration No</th>
        <th rowspan="2">Driver Name</th>
        <th colspan="2"> <div align="center">Driver Mobile No</div></th>
        <th rowspan="2">Vehicle Status</th>
      </tr>
      <tr>
        <th>Office</th>
        <th>Personal</th>
      </tr>
    </thead>
    <tbody>
      <?































							$sqld = "Select * from transport_vehicle where 1";















































							$queryd = db_query($sqld);















							while ($data = mysqli_fetch_object($queryd)) {















								$basic = find_all_field('personnel_basic_info', '', 'PBI_ID=' . $data->vehicle_user);















								if ($basic->PBI_NAME != '') {















									$user = $basic->PBI_NAME;
								} else {















									$user = $data->vehicle_user;
								}















							?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $user ?></td>
        <td><?= find_a_field('designation', 'DESG_DESC', 'DESG_ID=' . $basic->PBI_DESIGNATION); ?></td>
        <td><?= $data->vehicle_model ?></td>
        <td><?= $data->vehicle_registration_no ?></td>
        <td><?= $data->driver_name ?></td>
        <td><?= $data->driver_mobile_office ?></td>
        <td><?= $data->driver_mobile_personal ?></td>
        <td><?= $data->vehicle_status ?></td>
      </tr>
      <? } ?>
    </tbody>
  </table>
  <?















			} elseif ($_POST['report'] == 101) {































				?>
  <table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <h2 align="center">Salary & Allowance[
          <?= find_a_field('job_location_type', 'job_location_name', 'id="' . $_POST['JOB_LOCATION'] . '"'); ?>
          ]</h2>
        <h2 align="center">For the Month of
          <?= date("F", strtotime($_POST['fdate'])) ?>
          -
          <?= date("Y", strtotime($_POST['fdate'])) ?>
        </h2>
        <h4></h4>
        </th>
      </tr>
      <tr>
        <th rowspan="2"> <div align="center">S/L</div></th>
        <th rowspan="2"> <div align="center">Employee Code</div></th>
        <th rowspan="2"> <div align="center">Name of Employee</div></th>
        <th rowspan="2"> <div align="center">Accounts Number</div></th>
        <th rowspan="2"> <div align="center">Salary</div></th>
      </tr>
    </thead>
    <tbody>
      <?































							if ($_POST['mon'] != '')















								$advice_con = " and s.mon='" . $_POST['mon'] . "'";















							if ($_POST['year'] != '')















								$advice_con .= " and s.year='" . $_POST['year'] . "'";















							if ($_POST['JOB_LOCATION'] != '')















								$advice_con .= " and s.PBI_JOB_LOCATION='" . $_POST['JOB_LOCATION'] . "'";















							if ($_POST['job_status'] != '')















								$advice_con .= " and p.PBI_JOB_STATUS='" . $_POST['job_status'] . "'";































							$sql_bank = "select s.PBI_ID,p.PBI_CODE,s.bank_amt,p.PBI_NAME,i.cash,s.bank_account_no from salary_attendence s,personnel_basic_info p,salary_info i where s.PBI_ID=p.PBI_ID and s.PBI_ID=i.PBI_ID and s.bank_amt>0 and s.pbi_held_up=0 " . $advice_con . "";















































							$new_query = db_query($sql_bank);















							while ($bank_data = mysqli_fetch_object($new_query)) {















								$grand_total = $grand_total + $bank_data->bank_amt;















							?>
      <tr>
        <td align="center"><?= ++$s ?></td>
        <td><?= $bank_data->PBI_CODE ?></td>
        <td><?= $bank_data->PBI_NAME ?></td>
        <td align="center"><?= $bank_data->bank_account_no ?></td>
        <td align="right"><?= number_format($bank_data->bank_amt, 0) ?></td>
      </tr>
      <? } ?>
      <tr>
        <td colspan="4"><strong>Total</strong></td>
        <td align="right"><strong>
          <?= number_format($grand_total, 0); ?>
          </strong></td>
      </tr>
    </tbody>
  </table>
  <div style="page-break-after:always"></div>
  <div style="height: 100px"> </div>
  <table width="80%" cellspacing="0" cellpadding="0" border="0" style="margin:auto; font-size:15px;">
    <tr style="page-break-before:always">
      <td style="border-bottom:0px; border-left:0px; border-right:0px;"><strong>Date :
        <?= date('d-m-Y') ?>
        </strong><br>
        <br>
        To<br>
        The Manager<br>
        Dutch-Bangla Bank Ltd.<br>
        Foreign Exchange Branch,<br>
        Motijheel, Dhaka-1000. <br>
        <br>
        <strong>Subject: Salary & allowance disbursement for the month of (
        <?= $month_name = date("F", mktime(0, 0, 0, $_POST['mon'], 10)) . '-' . $_POST['year']; ?>
        )</strong><br>
        <br>
        Dear Sir,<br>
        Please transfer TK =
        <?= number_format($grand_total, 0) ?>
        /- <b>(In Word:<? echo convertNumberMhafuz($grand_total); ?>)</b> to our following employees bank accounts by debiting our Current A/C No:<b>105.110.19663</b> in the name of Bhaiya Housing maintained with you.<br>
        <br>
        We have provided you the soft copy of data through e-mail from ID number:<u>account7@alinfoods.com.</u>Sender Name:Monindra Kumar Mondal affirm you that the soft copy of data is true and exact with hard copy of data submitted to you.For any deviation with soft copy and hardcopy,the contains in the soft copy will be treated as final.<br>
        <br>
        For any query please contract with Mr.Monindra Kumar Modal;Mobile Number:01841918977<br>
        <br>
        <br>
        Thanking You,<br>
        <br>
        <br>
        <br>
        <br>
        Authorized Signature<br>
        <br>
        <br>
        <br>
        <br>
        <br>
        Bhaiya Housing </td>
    <tr>
      <td style="border-bottom:0px; border-left:0px; border-right:0px;float: right;margin-top:-130px;"> Authorized Signature<br>
        <br>
        <br>
        <br>
        <br>
        <br>
        Bhaiya Housing </td>
    </tr>
    </tr>
    
  </table>
  <div> </div>
  <?















			} elseif ($_POST['report'] == 102) {































				?>
  <table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;">
    <thead>
      <tr>
        <th style="border:0px;" colspan="16"><?= $str ?>
        </th>
      </tr>
      <tr>
        <th rowspan="2"> <div align="center">S/L</div></th>
        <th rowspan="2"> <div align="center">Employee Code</div></th>
        <th rowspan="2"> <div align="center">Name of Employee</div></th>
        <th rowspan="2"> <div align="center">Accounts Number</div></th>
        <th rowspan="2"> <div align="center">Salary</div></th>
      </tr>
    </thead>
    <tbody>
      <?































							if ($_POST['mon'] != '')















								$advice_con = " and s.mon='" . $_POST['mon'] . "'";















							if ($_POST['year'] != '')















								$advice_con .= " and s.year='" . $_POST['year'] . "'";















							if ($_POST['JOB_LOCATION'] != '')















								$advice_con .= " and p.JOB_LOC_ID='" . $_POST['JOB_LOCATION'] . "'";















							if ($_POST['job_status'] != '')















								$advice_con .= " and p.PBI_JOB_STATUS='" . $_POST['job_status'] . "'";































							$sql_cash = "select s.PBI_ID,p.PBI_CODE,s.cash_amt,p.PBI_NAME,i.cash from salary_attendence s,personnel_basic_info p,salary_info i where s.PBI_ID=p.PBI_ID and s.PBI_ID=i.PBI_ID and s.cash_amt>0 and s.pbi_held_up=0 " . $advice_con . "";















































							$new_query2 = db_query($sql_cash);















							while ($cash_data = mysqli_fetch_object($new_query2)) {















								$grand_total_cash = $grand_total_cash + $cash_data->cash_amt;















							?>
      <tr>
        <td align="center"><?= ++$s ?></td>
        <td><?= $cash_data->PBI_CODE ?></td>
        <td align="center"><?= $cash_data->PBI_NAME ?></td>
        <td align="center"><?= $cash_data->cash ?></td>
        <td align="right"><?= number_format($cash_data->cash_amt, 0) ?></td>
      </tr>
      <? } ?>
      <tr>
        <td colspan="4"><strong>Total</strong></td>
        <td align="right"><strong>
          <?= number_format($grand_total_cash, 0); ?>
          </strong></td>
      </tr>
    </tbody>
  </table>
  <?















			} elseif ($_POST['report'] == 204) { // --------------- Friday Working Bill































				if ($_POST['pbi_id_in'] != '')  $con .= " and a.PBI_ID in (" . $_POST['pbi_id_in'] . ")";































				//$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);















				?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <th style="border:0px;" colspan="16"><?= $str ?></th>
      </tr>
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































							$sqld = "select















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















" . $con . "















order by bsalary desc";















































							$queryd = db_query($sqld);















							while ($data = mysqli_fetch_object($queryd)) {















							?>
      <tr>
        <td><?= ++$s ?></td>
        <td><?= $data->code ?></td>
        <td><?= $data->name ?></td>
        <td><?= $data->designation ?></td>
        <td><?= $data->joining_date ?></td>
        <td><?= $data->confirmation_date ?></td>
        <td><?= $data->bank ?></td>
        <td><?php echo round($data->bsalary, 0);
										$tbsalary += $data->bsalary; ?></td>
        <td><?= $data->leave_quota ?></td>
        <td><?= $data->leave_consumed ?></td>
        <td><?= $data->leave_balance ?></td>
        <td><?php echo round($data->cash_paid, 0);
										$tcash_paid += $data->cash_paid; ?></td>
        <td><?php echo round($data->bank_paid, 0);
										$tbank_paid += $data->bank_paid; ?></td>
        <td><?php echo round($data->damount, 0);
										$tdamount += $data->damount; ?></td>
        <td><?php echo round($data->pamount, 0);
										$tpamount += $data->pamount; ?></td>
        <td>&nbsp;</td>
      </tr>
      <? } ?>
      <tr>
        <td colspan="6" bgcolor="#FFFFCC"><strong><? echo convertNumberMhafuz(round($tpamount, 0)); ?></strong></td>
        <td bgcolor="#FFFFCC"><strong>Total</strong></td>
        <td bgcolor="#FFFFCC"><strong>
          <?= $tbsalary ?>
          </strong></td>
        <td bgcolor="#FFFFCC"></td>
        <td bgcolor="#FFFFCC"></td>
        <td bgcolor="#FFFFCC"></td>
        <td bgcolor="#FFFFCC"><strong>
          <?= round($tcash_paid, 0); ?>
          </strong></td>
        <td bgcolor="#FFFFCC"><strong>
          <?= round($tbank_paid, 0); ?>
          </strong></td>
        <td bgcolor="#FFFFCC"><strong>
          <?= round($tdamount, 0); ?>
          </strong></td>
        <td bgcolor="#FFFFCC"><strong>
          <?= round($tpamount, 0) ?>
          </strong></td>
        <td bgcolor="#FFFFCC">&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <?















			} elseif ($_POST['report'] == 8) { // mobile number update report















































				$sql = "select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,















a.PBI_GROUP as `Group`,















a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,















(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,















(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,















(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,















a.PBI_EDU_QUALIFICATION as qualification,















a.PBI_MOBILE as mobile,a.PBI_INTERNET as modem















from personnel_basic_info a















where 1 " . $con;















				$query = db_query($sql);















				?>
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <td style="border:0px;" colspan="11"><?= $str ?></td>
      </tr>
      <tr>
        <th>S/L</th>
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
      </tr>
    </thead>
    <tbody>
      <?















							while ($datas = mysqli_fetch_row($query)) {
								$s++;















							?>
      <tr>
        <td><?= $s ?></td>
        <td><?= $datas[0] ?></td>
        <td><?= $datas[1] ?></td>
        <td><?= $datas[2] ?></td>
        <td><?= $datas[3] ?></td>
        <td><?= $datas[4] ?></td>
        <td><?= $datas[5] ?></td>
        <td style="text-align:right"><?= $datas[7] ?></td>
        <td style="text-align:right"><?= $datas[8] ?></td>
        <td><?= $datas[9] ?></td>
        <td><input name="sim#<?= $datas[0] ?>" type="text" id="sim#<?= $datas[0] ?>" value="<?= $datas[12] ?>" /></td>
        <td><input type="hidden" name="PBI_ID#<?= $datas[0] ?>" id="PBI_ID#<?= $datas[0] ?>" value="<?= $datas[0] ?>" />
          <input name="mobile#<?= $datas[0] ?>" type="text" id="mobile#<?= $datas[0] ?>" value="<?= $datas[11] ?>" />
        </td>
        <td><div id="po<?= $datas[0] ?>">
            <input type="button" name="Change" value="Change" onClick="update_value(<?= $datas[0] ?>)" />
          </div></td>
      </tr>
    </tbody>
  </table>
  <?   } ?>
  <? } elseif ($_POST['report'] == 21) {











				//$report="Employee Basic Information";























				if ($_POST['mon'] != '')















					$att_con = ' and d.mon="' . $_POST['mon'] . '"';































				if ($_POST['year'] != '')















					$att_con .= ' and d.year="' . $_POST['year'] . '"';































			?>
  <table style="width: auto; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">
    <tr>
      <td style="border:0px solid white;"><strong>AKSID CORPORATION LTD.</strong></td>
    </tr>
    <tr>
      <td style="border:0px solid white;"><strong>Employee Late Present Report</strong></td>
    </tr>
  </table>
  <table style="width:auto;margin:0 auto;" cellpadding="0" cellspacing="0" border="1">
    <thead>
      <tr>
        <td><strong>Sl</strong></td>
        <td><strong>EMP ID</strong></td>
        <td><strong>NAME</strong></td>
        <td><strong>DESIGNATION</strong></td>
        <td><strong>DEPARTMENT</strong></td>
        <td><strong>PROJECT</strong></td>
        <td><strong>Late in days</strong></td>
        <td><strong>Check in</strong></td>
        <td><strong>Check out</strong></td>
      </tr>
    </thead>
    <?































					echo $basic_sql = "select a.PBI_ID as Emp_ID,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,(select if(DEPT_DESC='NO DEPARTMENT','',DEPT_DESC)







  from department where DEPT_ID=a.PBI_DEPARTMENT) as department,(select PROJECT_DESC from project where PROJECT_ID=a.JOB_LOCATION) as project_name,d.bizid,d.xdate,d.late_in,d.ztime,d.xtime







   from hrm_attdump d,personnel_basic_info a where d.late_in=1 and  d.bizid=a.PBI_ID  " . $att_con . "" . $con . " order by d.bizid,d.xdate ";































					$basic_query = db_query($basic_sql);































					$sl = 1;































































					while ($r = mysqli_fetch_object($basic_query)) {































					?>
    <tr>
      <td><?= $sl++; ?></td>
      <td><?= $r->Emp_ID ?></td>
      <td><?= $r->Name ?></td>
      <td><?= $r->designation ?></td>
      <td><?= $r->department ?></td>
      <td><?= $r->project_name ?></td>
      <td><?= date('d-M-Y', strtotime($r->xdate)) ?></td>
      <td><?= date('h:i', strtotime($r->ztime)) ?></td>
      <td><?= date('h:i', strtotime($r->xtime)) ?></td>
    </tr>
    <?







					}















					?>
  </table>
  <br />
  <br />
  <!-- attendence report from dump   -->
  <? } elseif ($_POST['report'] == 240322) {











				$report = "ATTENDENCE SHEET";







				if ($_POST['mon'] != '')







					$att_con = ' and d.mon="' . $_POST['mon'] . '"';







				if ($_POST['year'] != '')



					$att_con .= ' and d.year="' . $_POST['year'] . '"';



				$d = cal_days_in_month(CAL_GREGORIAN, $_POST['mon'], $_POST['year']);







				$fdate = $_POST['year'] . '-' . $_POST['mon'] . '-01';



				$tdate = $_POST['year'] . '-' . $_POST['mon'] . '-' . $d;







				$fdate =  date('Y-m-d', strtotime($fdate));



				$tdate =  date('Y-m-d', strtotime($tdate));















				$in_out_sql = "select a.PBI_ID,h.in_time,h.out_time,h.att_date



   from personnel_basic_info a,hrm_att_summary h where a.PBI_ID!=0 and h.att_date between '" . $_POST['year'] . "-" . $_POST['mon'] . "-01' and

   '" . $_POST['year'] . "-" . $_POST['mon'] . "-" . $d . "' ";



				//$qrrry = db_query($in_out_sql);



				//$row_count = mysqli_num_rows($qrrry);















			?>
  <table style="width: 100%; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">
    <tr>
      <td style="border:0px solid white;"><strong>Bhaiya Housing</strong></td>
    </tr>
    <tr>
      <td style="border:0px solid white;"><strong>ATTENDANCE SHEET</strong></td>
    </tr>
    <tr>
      <td style="border:0px solid white;">Period :
        <?= date('M-Y', strtotime($fdate)); ?></td>
    </tr>
  </table>
  <table style="width:100%;" cellpadding="0" cellspacing="0" border="1">
    <?

					$dept_sql = "select DISTINCT a.DEPT_ID,dept.DEPT_DESC from personnel_basic_info a left join hrm_att_summary s on s.emp_id=a.PBI_ID left join  department dept on dept.DEPT_ID=a.DEPT_ID

   where 1 " . $con . " group by a.PBI_ID,a.DEPT_ID order by a.DEPT_ID asc";

					$dept_qry = db_query($dept_sql);

					while ($dept_data = mysqli_fetch_object($dept_qry)) {



					?>
    <tr>
      <td style="border:0px; font-size:16px; font-weight:bold;" colspan="10"><div align="left">
          <?= $dept_data->DEPT_DESC ?>
        </div></td>
    </tr>
  </table>
  <table style="width:100%;margin:0 auto;" cellpadding="0" cellspacing="0" border="1">
    <thead>
      <tr>
        <td><strong>Emp Id</strong></td>
        <td><strong>EMP Name</strong></td>
        <td><strong>Department</strong></td>
        <? for ($i = 1; $i <= $d; $i++) { ?>
        <td><strong>
          <?= $i; ?>
          </strong></td>
        <? } ?>
      </tr>
    </thead>
    <?











						$basic_sql = "select s.*,p.PBI_NAME,p.PBI_CODE,p.PBI_DEPARTMENT from personnel_basic_info p left join hrm_att_summary s on s.emp_id=p.PBI_ID and s.att_date between '" . $fdate . "' and '" . $tdate . "'

   where p.DEPT_ID='" . $dept_data->DEPT_ID . "'  group by p.PBI_ID";











						$basic_query = db_query($basic_sql);







						$sl = 1;











						while ($r = mysqli_fetch_object($basic_query)) {











					?>
    <tr>
      <td><?= $r->PBI_CODE ?></td>
      <td><?= $r->PBI_NAME ?></td>
      <td><?= $r->PBI_DEPARTMENT ?></td>
      <? $ssqqll = 'select in_time from hrm_att_summary where emp_id="' . $r->emp_id . '" and att_date between "' . $fdate . '" and "' . $tdate . '"';



							$qrrry = db_query($ssqqll);



							for ($i = $fdate; $i <= $tdate; $i = date('Y-m-d', strtotime($i . " +1 days"))) {



							?>
      <td><?



									$summary = find_all_field('hrm_att_summary', '*', 'att_date="' . $i . '" and emp_id="' . $r->emp_id . '"');



									$att_status = $summary->in_time;



									if ($summary->att_date == '') {

										$dayname = date('D', strtotime($i));

										if ($dayname == 'Fri') {

											echo $att_status = '<span style="color:blue; font-weight:bold;">WH</span>';
										} else {

											$h_check = find_a_field('salary_holy_day', 'reason', 'holy_day="' . $i . '"');

											if ($h_check != '') {

												echo $att_status = '<span style="color:red; font-weight:bold;">Holiday</span>';
											} else {

												echo $att_status = '<span style="color:red; font-weight:bold;">A</span>';
											}
										}
									}



									if ($summary->iom_id > 0) {

										echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">IOM</span><br>';
									}



									if ($summary->leave_id > 0) {

										if ($summary->leave_type == 'Full') {

											echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">LEAVE</span><br>';
										} else {

											echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">HL</span><br>';
										}
									}

									if ($summary->grace_no > 0) {

										echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">Grace</span><br>';
									}

									if ($summary->final_early_status > 0)

										echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">EarlyOut</span><br>';

									if ($summary->final_late_status > 0)



										echo $att_status = '<span style="color:#ff8d00; font-weight:bold;">Late</span><br>';

									if ($summary->in_time != '') {

										echo date('H:i', strtotime($summary->in_time));

										echo '<br>';

										echo date('H:i', strtotime($summary->out_time));
									}







									?>
      </td>
      <? } ?>
    </tr>
    <?







						}
					}

				?>
  </table>
  <br />
  <br />
  <!-- attendence report from dump   -->
  <? } elseif ($_POST['report'] == 20220522) {
				$report = "ATTENDENCE SHEET Factory";
				if ($_POST['mon'] != '')
					$att_con = ' and d.mon="' . $_POST['mon'] . '"';
				if ($_POST['PBI_ID'] > 0)
					$pbi = ' and p.PBI_ID="' . $_POST['PBI_ID'] . '"';
				if ($_POST['job_status'] != '')
					$job_status_con = ' and a.PBI_JOB_STATUS="' . $_POST['job_status'] . '"';
				if ($_POST['year'] != '')
					$att_con .= ' and d.year="' . $_POST['year'] . '"';

				if ($_POST['JOB_LOCATION'] > 0) {

					if ($_POST['JOB_LOCATION'] == 1) {

						$loc = ' and job_loc_id in (' . $_POST['JOB_LOCATION'] . ',3)';
					} else {

						$loc = ' and job_loc_id in (' . $_POST['JOB_LOCATION'] . ',3)';
					}
				}



				$fdate = $_POST['fdate'];
				$tdate = $_POST['tdate'];
				$fdate =  date('Y-m-d', strtotime($fdate));
				$tdate =  date('Y-m-d', strtotime($tdate));


				//$in_out_sql="select a.PBI_ID,h.in_time,h.out_time,h.att_date
				//from personnel_basic_info a,hrm_att_summary h where a.PBI_ID!=0 and h.att_date between '".$_POST['fdate']."' and  
				//'".$_POST['tdate']."' ";
				//$qrrry = db_query($in_out_sql);
				//$row_count = mysqli_num_rows($qrrry);
			?>
			
			<style>
@page {
    size: A4;  /* Landscape fits more columns */
    margin: 0.5cm;
}

@media print {
    
    #ExportTable {
        width: 100% !important;
        border-collapse: collapse;
        font-size: 8px;  /* Smaller font to fit */
        transform: scale(0.85);  /* Scale down */
        transform-origin: top left;
    }
   
}
</style>
			
  <table style="width: 100%; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">
    <tr>
      <td style="border:0px solid white;"><strong>
        <?= find_a_field('user_group', 'group_name', 'id=' . $_SESSION['user']['group']) ?>
        </strong></td>
    </tr>
    <tr>
      <td style="border:0px solid white;"><strong>ATTENDANCE SHEET</strong></td>
    </tr>
    <tr>
      <td style="border:0px solid white;">Period :
        <?= date('M-Y', strtotime($fdate)); ?>
        -
        <?= date('M-Y', strtotime($tdate)); ?>
      </td>
    </tr>
  </table>
  <table id="ExportTable" style="width:100%;margin:0 auto;" cellpadding="0" cellspacing="0" border="1">
    <tr>
      <td>SL</td>
      <td><strong>Emp Id</strong></td>
      <td><strong>EMP Name</strong></td>
      <td><strong>Department</strong></td>
      <? for ($i = $fdate; $i <= $tdate; $i = date('Y-m-d', strtotime($i . " +1 days"))) { ?>
      <td style="width: 2.5%"><strong>
        <?= date('F j D', strtotime($i)); ?>
        </strong></td>
      <? } ?>
    </tr>
    <?


					$basic_sql = "select p.PBI_NAME,p.PBI_CODE,p.PBI_ID,p.JOB_LOC_ID,d.DEPT_DESC as PBI_DEPARTMENT  from department d, personnel_basic_info p  where  p.DEPT_ID=d.DEPT_ID  group by p.PBI_ID";



					$basic_query = db_query($basic_sql);
					$sl = 1;
					while ($r = mysqli_fetch_object($basic_query)) {

						$pbi_code[$r->PBI_ID] = $r->PBI_CODE;
						$pbi_name[$r->PBI_ID] = $r->PBI_NAME;
						$pbi_dept[$r->PBI_ID] = $r->PBI_DEPARTMENT;
					}


					$sql = "select * from hrm_att_summary where att_date between '" . $fdate . "' and '" . $tdate . "' group by att_date,emp_id ";
					$query = db_query($sql);

					while ($summary = mysqli_fetch_object($query)) {

						$in_time[$summary->emp_id][$summary->att_date] = $summary->in_time;
						$out_time[$summary->emp_id][$summary->att_date] = $summary->out_time;
						$dayname[$summary->att_date] = $summary->dayname;
						$leave_type[$summary->emp_id][$summary->att_date] = $summary->leave_type;
						$grace[$summary->emp_id][$summary->att_date] = $summary->grace_no;
						$iom[$summary->emp_id][$summary->att_date] = $summary->iom_id;
						$iom_type[$summary->emp_id][$summary->att_date] = $summary->iom_type;
						$leave[$summary->emp_id][$summary->att_date] = $summary->leave_id;
						$leave_type[$summary->emp_id][$summary->att_date] = $summary->leave_type;
						$leave_category[$summary->emp_id][$summary->att_date] = $summary->leave_category;
						$final_late[$summary->emp_id][$summary->att_date] = $summary->final_late_status;
						$final_early[$summary->emp_id][$summary->att_date] = $summary->final_early_status;
						$att_date[$summary->emp_id][$summary->att_date] = $summary->att_date;
					}



					$h_sql = "select * from salary_holy_day where 1 " . $loc . "";
					$h_query = db_query($h_sql);

					while ($h_data = mysqli_fetch_object($h_query)) {

						$h_date[$h_data->holy_day] = $h_data->holy_day;
					}



					$leve_sql = "select * from hrm_leave_info";
					$leave_query = db_query($leave_sql);

					while ($leave_data = mysqli_fetch_object($leave_query)) {
						$leave_name[$leave_data->id] = $leave_data->type;
					}


					$dept_sql = "select DISTINCT a.JOB_LOC_ID,a.PBI_ID,a.DEPT_ID,a.define_offday,dept.DEPT_DESC,a.PBI_CODE from personnel_basic_info a,department dept   
where    dept.DEPT_ID=a.DEPT_ID " . $con . $job_status_con . "  group by a.PBI_ID order by a.PBI_CODE asc";

					$dept_qry = db_query($dept_sql);
					while ($dept_data = mysqli_fetch_object($dept_qry)) {
					?>
    <tr>
      <td><?= $sl++; ?></td>
      <td style="width: 5%"><?= $pbi_code[$dept_data->PBI_ID] ?></td>
      <td style="width:5%"><?= $pbi_name[$dept_data->PBI_ID] ?></td>
      <td style="width:5%"><?= $pbi_dept[$dept_data->PBI_ID] ?></td>
      <?
							for ($i = $fdate; $i <= $tdate; $i = date('Y-m-d', strtotime($i . " +1 days"))) {
							?>
      <td style="width:2.5%"><?




									if ($in_time[$dept_data->PBI_ID][$i] == 0 && $out_time[$dept_data->PBI_ID][$i] == 0 && $leave[$dept_data->PBI_ID][$i] == 0 && $iom[$dept_data->PBI_ID][$i] == 0) {
										$dayname = date('l', strtotime($i));
										if ($dayname == $dept_data->define_offday) {
											echo $att_status = '<span style="color:blue; font-weight:bold;">WH</span>';
										} else {

											if ($h_date[$i] == $i) {
												echo $att_status = '<span style="color:red; font-weight:bold;">Holiday</span>';
											} else {

												echo $att_status = '<span style="color:red; font-weight:bold;">A</span>';
											}
										}
									}





									if ($iom[$dept_data->PBI_ID][$i] > 0) {
										echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">IOM</span><br>';
									}




									if ($leave[$dept_data->PBI_ID][$i] > 0) {
										if ($leave_type[$dept_data->PBI_ID][$i] == 'Full') {

											$lv_type = find_a_field('hrm_leave_info', 'type', 'id="' . $leave[$dept_data->PBI_ID][$i] . '"');

											$lv_tp_name = find_a_field('hrm_leave_type', 'leave_type_name', 'id="' . $lv_type . '"');


											echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;"> ' . $lv_tp_name . '</span><br>';
										} else {
											echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">HL</span><br>';
										}

										if ($leave_category[$dept_data->PBI_ID][$i] == 'LWP (Leave Without Pay)') {
											echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">LWP</span><br>';
										} elseif ($leave_category[$dept_data->PBI_ID][$i] == 'Adjust Leave') {
											echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">Adjust Leave</span><br>';
										} else {
											echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">' . $leave_name[$leave[$dept_data->PBI_ID][$i]] . '</span><br>';
										}
									}




									if ($grace[$dept_data->PBI_ID][$i] > 0) {
										echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">Grace</span><br>';
									}

									if ($final_early[$dept_data->PBI_ID][$i] > 0 && $iom_type[$dept_data->PBI_ID][$i] != 'Full' && $leave[$dept_data->PBI_ID][$i] == 0)
										echo $att_status = '<span style="color:#ef0fb4; font-weight:bold;">EarlyOut</span><br>';

									if ($final_late[$dept_data->PBI_ID][$i] > 0)
										echo $att_status = '<span style="color:#ff8d00; font-weight:bold;">Late</span><br>';





									if ($in_time[$dept_data->PBI_ID][$i] > 0) {

										if ($in_time[$dept_data->PBI_ID][$i] > 0)
											echo date('H:i', strtotime($in_time[$dept_data->PBI_ID][$i]));
										echo '<br>';
										if ($out_time[$dept_data->PBI_ID][$i] > 0)
											echo date('H:i', strtotime($out_time[$dept_data->PBI_ID][$i]));
									}
									?>
      </td>
      <? } ?>
    </tr>
    <?

					}
					?>
  </table>
  <br />
  <br />
  
  
  
  
  <!-- attendence report from dump   -->
  <? } elseif ($_POST['report'] == 81) {











				$report = "Attendence Summary Sheet";







				if ($_POST['mon'] != '')







					$att_con = ' and d.mon="' . $_POST['mon'] . '"';





				if ($_POST['JOB_LOCATION'] != '') {
					$job_con = " and p.JOB_LOC_ID='" . $_POST['JOB_LOCATION'] . "' ";
				}



				if ($_POST['job_status'] != '') {
					$job_con .= " and p.PBI_JOB_STATUS='" . $_POST['job_status'] . "' ";
				}



				if ($_POST['year'] != '')



					$att_con .= ' and d.year="' . $_POST['year'] . '"';



				$d = cal_days_in_month(CAL_GREGORIAN, $_POST['mon'], $_POST['year']);







				$fdate = $_POST['year'] . '-' . $_POST['mon'] . '-01';



				$tdate = $_POST['year'] . '-' . $_POST['mon'] . '-' . $d;







				$fdate =  date('Y-m-d', strtotime($fdate));



				$tdate =  date('Y-m-d', strtotime($tdate));







			?>
  <table style="width: auto; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">
    <tr>
      <td style="border:0px solid white;"><strong>Attendence Summary Sheet</strong></td>
    </tr>
    <tr>
      <td style="border:0px solid white;">Period :
        <?= date('M-Y', strtotime($fdate)); ?></td>
    </tr>
  </table>
  <table style="width:auto;" cellpadding="0" cellspacing="0" border="1">
    <?

					$dept_sql = "select DISTINCT p.DEPT_ID,dept.DEPT_DESC from hrm_att_summary s,personnel_basic_info p, department dept

   where p.DEPT_ID=dept.DEPT_ID and s.emp_id=p.PBI_ID and att_date between '" . $fdate . "' and '" . $tdate . "' " . $job_con . " group by s.emp_id,p.DEPT_ID order by p.DEPT_ID asc";

					$dept_qry = db_query($dept_sql);





					while ($dept_data = mysqli_fetch_object($dept_qry)) {



					?>
    <tr>
      <td style="border:0px; font-size:16px; font-weight:bold;" colspan="10"><div align="left">
          <?= $dept_data->DEPT_DESC ?>
        </div></td>
    </tr>
  </table>
  <table style="width:100%;margin:0 auto;" cellpadding="0" cellspacing="0" border="1">
    <thead>
      <tr>
        <td rowspan="2"><strong>SL</strong></td>
        <td rowspan="2"><strong>Emp Id</strong></td>
        <td rowspan="2"><strong>EMP Name</strong></td>
        <td rowspan="2"><strong>Designation</strong></td>
        <td rowspan="2"><strong>Total Working Day</strong></td>
        <td colspan="3" align="center"><strong>Leave Days</strong></td>
        <td colspan="2"><strong>Salary Deduct Absent Days</strong></td>
        <td colspan="2" align="center"><strong>Early Leave</strong></td>
        <td colspan="4" align="center"><strong>Late Come</strong></td>
        <td colspan="3" align="center"><strong>IOM Days</strong></td>
        <td rowspan="2"><strong>Remarks</strong></td>
      </tr>
      <tr>
        <td><strong>First Half</strong></td>
        <td><strong>Last Half</strong></td>
        <td><strong>Full</strong></td>
        <td><strong>Absent</strong></td>
        <td><strong>LWP</strong></td>
        <td><strong>Day</strong></td>
        <td><strong>Minute</strong></td>
        <td><strong>Day</strong></td>
        <td><strong>Minute</strong></td>
        <td><strong>Leave Deduct(Days)</strong></td>
        <td><strong>Salary Deduct(Days)</strong></td>
        <td><strong>First Half</strong></td>
        <td><strong>Last Half</strong></td>
        <td><strong>Full</strong></td>
      </tr>
    </thead>
    <?



						$fdate = $_POST['year'] . '-' . $_POST['mon'] . '-01';

						$m_days = date('t', strtotime($fdate));

						$tdate = $_POST['year'] . '-' . $_POST['mon'] . '-' . $m_days;







						$basic_sql = "select s.*,p.PBI_CODE,p.PBI_NAME,p.PBI_DEPARTMENT,p.PBI_DESIGNATION,p.EMPLOYMENT_TYPE from hrm_attendence_final s,personnel_basic_info p

   where s.PBI_ID=p.PBI_ID and p.DEPT_ID='" . $dept_data->DEPT_ID . "' and s.mon='" . $_POST['mon'] . "' and year='" . $_POST['year'] . "' " . $job_con . "";



						$basic_query = db_query($basic_sql);



						$sl = 1;







						while ($r = mysqli_fetch_object($basic_query)) {



							$hl_first = find_a_field('hrm_att_summary', 'count(leave_id)', 'leave_type="Early Half" and att_date between "' . $fdate . '" and "' . $tdate . '" and emp_id="' . $r->PBI_ID . '"');



							$hl_last = find_a_field('hrm_att_summary', 'count(leave_id)', 'leave_type="Last Half" and att_date between "' . $fdate . '" and "' . $tdate . '" and emp_id="' . $r->PBI_ID . '"');



							$full_leave = find_a_field('hrm_att_summary', 'count(leave_id)', 'leave_type="Full" and att_date between "' . $fdate . '" and "' . $tdate . '" and emp_id="' . $r->PBI_ID . '"');



							$early_out_day = find_a_field('hrm_att_summary', 'sum(final_early_status)', 'att_date between "' . $fdate . '" and "' . $tdate . '" and emp_id="' . $r->PBI_ID . '"');



							$early_out_min = find_a_field('hrm_att_summary', 'sum(final_early_min)', 'att_date between "' . $fdate . '" and "' . $tdate . '" and emp_id="' . $r->PBI_ID . '"');



							$late_day = find_a_field('hrm_att_summary', 'sum(final_late_status)', 'att_date between "' . $fdate . '" and "' . $tdate . '" and emp_id="' . $r->PBI_ID . '"');



							$late_min = find_a_field('hrm_att_summary', 'sum(final_late_min)', 'and att_date between "' . $fdate . '" and "' . $tdate . '" and emp_id="' . $r->PBI_ID . '"');



							$iom_first = find_a_field('hrm_att_summary', 'count(iom_id)', 'iom_type="Early Half" and att_date between "' . $fdate . '" and "' . $tdate . '" and emp_id="' . $r->PBI_ID . '"');



							$iom_last = find_a_field('hrm_att_summary', 'count(iom_id)', 'iom_type="Last Half" and att_date between "' . $fdate . '" and "' . $tdate . '" and emp_id="' . $r->PBI_ID . '"');



							$iom_full = find_a_field('hrm_att_summary', 'count(iom_id)', 'iom_type="Full" and att_date between "' . $fdate . '" and "' . $tdate . '" and emp_id="' . $r->PBI_ID . '"');



							$lwp_total = find_a_field('hrm_att_summary', 'sum(leave_duration)', 'leave_category="LWP (Leave Without Pay)" and att_date 
between "' . $fdate . '" and "' . $tdate . '" and emp_id="' . $r->PBI_ID . '"');



							$total_leave_this_year = find_a_field('hrm_attendence_final', 'sum(lv)', 'year="' . $_POST['year'] . '" and PBI_ID=' . $r->PBI_ID . ' ');

							if ($r->total_late_min > 19) {

								$absent_for_late = (int)($r->total_late_min / 20) * (0.5);
							} else {

								$absent_for_late = 0;
							}

							if (($total_leave_this_year > 28) || ($r->EMPLOYMENT_TYPE != "Permanent")) {



								$salary_deduct = $absent_for_late;

								$leave_deduct = 0;
							} else {



								$leave_deduct = $absent_for_late;

								$salary_deduct = 0;
							}

					?>
    <tr>
      <td><?= ++$i ?></td>
      <td><?= $r->PBI_CODE ?></td>
      <td><?= $r->PBI_NAME ?></td>
      <td><?= $r->PBI_DESIGNATION ?></td>
      <td><?= $r->pay ?></td>
      <td><?= $hl_first ?></td>
      <td><?= $hl_last ?></td>
      <td><?= $full_leave ?></td>
      <td><?= $r->ab ?></td>
      <td><?= $lwp_total ?></td>
      <td><?= $r->eo ?></td>
      <td><?= $early_out_min ?></td>
      <td><?= $r->lt ?></td>
      <td><?= $r->total_late_min ?></td>
      <td><?= $leave_deduct ?></td>
      <td><?= $salary_deduct ?></td>
      <td><?= $iom_first ?></td>
      <td><?= $iom_last ?></td>
      <td><?= $iom_full ?></td>
      <td></td>
    </tr>
    <?







						}

						$i = 0;
					}

				?>
  </table>
  <br />
  <br />
  <!-- attendence report from dump   -->
  <br />
  <br />
  <!-- DAILY INVALID REPORT  -->
  <? } elseif ($_POST['report'] == 121223) {


				$report = "Daily Invalid Report";




				if ($_POST['JOB_LOCATION'] != '') {
					$job_con = " and p.JOB_LOC_ID='" . $_POST['JOB_LOCATION'] . "' ";
				}

				if ($_POST['job_status'] != '') {
					$job_con .= " and p.PBI_JOB_STATUS='" . $_POST['job_status'] . "' ";
				}
				if ($_POST['PBI_IDD'] > 0) $IDConn = " and s.emp_id='" . $_POST['PBI_IDD'] . "'";

				if ($_POST['PBI_CODE'] != "") $codeConn = " and p.PBI_CODE='" . $_POST['PBI_CODE'] . "'";

				if ($_POST['PBI_NAME'] != "") $NameConn = " and p.PBI_NAME='" . $_POST['PBI_NAME'] . "'";

				if ($_POST['PBI_ORG'] > 0) $org = " and p.PBI_ORG='" . $_POST['PBI_ORG'] . "'";

				if ($_POST['cost_center'] != "") $cost_center = " and p.cost_center='" . $_POST['cost_center'] . "'";

				if ($_POST['DEPT_ID'] != "") $dept = " and p.DEPT_ID='" . $_POST['DEPT_ID'] . "'";

				if ($_POST['section'] != "") $section = " and p.section='" . $_POST['section'] . "'";

				if ($_POST['JOB_LOC_ID'] > 0) $job_loc = " and p.JOB_LOC_ID='" . $_POST['JOB_LOC_ID'] . "'";

				if ($_POST['PBI_SEX'] != "") $gender = " and p.PBI_SEX='" . $_POST['PBI_SEX'] . "'";

				if ($_POST['grade'] != "") $grade = " and p.grade='" . $_POST['grade'] . "'";

				if ($_POST['work_station'] != "") $work = " and p.work_station='" . $_POST['work_station'] . "'";

				if ($_POST['level'] != "") $level = " and p.level='" . $_POST['level'] . "'";

				if ($_POST['class'] != "") $class = " and p.class='" . $_POST['class'] . "'";

				if ($_POST['PBI_RELIGION'] != "") $religion = " and p.PBI_RELIGION='" . $_POST['PBI_RELIGION'] . "'";

				if ($_POST['incharge_id'] != "") $incharge = " and p.incharge_id='" . $_POST['incharge_id'] . "'";


				$fdate =  date('Y-m-d', strtotime($fdate));
				$tdate =  date('Y-m-d', strtotime($tdate));


			?>
  <table style="width: auto; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">
    <tr>
      <td style="border:0px solid white;"><strong>Daily Invalid Report</strong></td>
    </tr>
    <tr>
      <td style="border:0px solid white;">Attendance Date :
        <?= date('d-M-Y', strtotime($_POST['fdate'])); ?></td>
    </tr>
  </table>
  <table style="width:auto;" cellpadding="0" cellspacing="0" border="1">
    <?
					$dept_sql = "select DISTINCT p.cost_center, dept.center_name 

				from hrm_att_summary s,personnel_basic_info p, hrm_cost_center dept

				where p.cost_center=dept.id and s.emp_id=p.PBI_ID and 

				s.att_date='" . $_POST['fdate'] . "' 

				" . $job_con . $date_con . $NameConn . $IDConn . $codeConn .
						$con . $org . $cost_center . $dept . $section . $job_loc . $gender .
						$grade . $work . $level . $class . $religion . $incharge .  "

				group by s.emp_id,p.cost_center order by p.cost_center asc";

					$dept_qry = db_query($dept_sql);

					while ($dept_data = mysqli_fetch_object($dept_qry)) {



					?>
    <tr>
      <td style="border:0px; font-size:16px; font-weight:bold;" colspan="10"><div align="left">
          <?= $dept_data->center_name ?>
        </div></td>
    </tr>
  </table>
  <table style="width:100%;margin:0 auto;" cellpadding="0" cellspacing="0" border="1">
    <thead>
      <tr>
        <td rowspan="2"><strong>SL</strong></td>
        <td rowspan="2"><strong>Id</strong></td>
        <td rowspan="2"><strong>Name</strong></td>
        <td rowspan="2"><strong>Designation</strong></td>
        <td rowspan="2"><strong>DOJ</strong></td>
        <td rowspan="2"><strong>DOL</strong></td>
        <td rowspan="2"><strong>Department</strong></td>
        <td rowspan="2"><strong>Section</strong></td>
        <td rowspan="2"><strong>Shift In Time</strong></td>
        <td rowspan="2"><strong>Shift Out Time</strong></td>
        <td rowspan="2"><strong>In Time</strong></td>
        <td rowspan="2"><strong>Out Time</strong></td>
        <td rowspan="2"><strong>In Late</strong></td>
        <td rowspan="2"><strong>Early Out</strong></td>
      </tr>
    </thead>
    <?
						if ($_POST['year'] != '') {

							$startDate = $_POST['year'] . '-' . $_POST['mon'] . '-01';

							$endDate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
						}


						$basic_sql = "select s.*,p.PBI_CODE,p.PBI_NAME,p.DEPT_ID,p.section,p.PBI_DESIGNATION,p.EMPLOYMENT_TYPE, p.PBI_DOJ
									from hrm_att_summary s,personnel_basic_info p
									where s.emp_id = p.PBI_ID  and 
									p.cost_center='" . $dept_data->cost_center . "' and s.att_date='" . $_POST['fdate'] . "'  " . $job_con . "
									and s.final_early_min+s.final_late_min  >= 120";

						$basic_query = db_query($basic_sql);
						$sl = 1;

						while ($r = mysqli_fetch_object($basic_query)) {


					?>
    <tr>
      <td><?= ++$i ?></td>
      <td><?= $r->PBI_CODE ?></td>
      <td><?= $r->PBI_NAME ?></td>
      <td><?= $r->PBI_DESIGNATION ?></td>
      <td><?= $r->PBI_DOJ ?></td>
      <td><? //=$hl_first
								?></td>
      <td><?= find_a_field('department', 'DEPT_DESC', 'DEPT_ID="' . $r->DEPT_ID . '"'); ?></td>
      <td><?= find_a_field('PBI_Section', 'sec_name', 'sec_id="' . $r->section . '"'); ?></td>
      <td><?= date("h:i a", strtotime($r->sch_in_time)); ?></td>
      <td><?= date("h:i a", strtotime($r->sch_out_time)); ?></td>
      <td><? if ($r->in_time > 0)  echo date("H:i a", strtotime($r->in_time)); ?></td>
      <td><? if ($r->out_time > 0) echo date("H:i a", strtotime($r->out_time)); ?></td>
      <td><?= $r->final_late_min ?></td>
      <td><?= $r->final_early_min ?></td>
    </tr>
    <?



						}

						$i = 0;
					}

				?>
  </table>
  <br />
  <br />
  <!-- invalid report from dump   -->
  <br />
  <br />
  <!-- DAILY INVALID REPORT  -->
  <?

			} elseif ($_POST['report'] == 121225) {


				$report = "Daily Attendance Report";



			 
				if ($_POST['JOB_LOCATION'] != '') {
					$job_con = " and p.JOB_LOC_ID='" . $_POST['JOB_LOCATION'] . "' ";
				}

				if ($_POST['PBI_JOB_STATUS'] != '') {
					$job_status_con .= " and p.PBI_JOB_STATUS='" . $_POST['PBI_JOB_STATUS'] . "' ";
				}
				if ($_POST['PBI_IDD'] > 0) $IDConn = " and s.emp_id='" . $_POST['PBI_IDD'] . "'";

				if ($_POST['PBI_CODE'] != "") $codeConn = " and p.PBI_CODE='" . $_POST['PBI_CODE'] . "'";

				if ($_POST['PBI_NAME'] != "") $NameConn = " and p.PBI_NAME='" . $_POST['PBI_NAME'] . "'";

				if ($_POST['PBI_ORG'] > 0) $org = " and p.PBI_ORG='" . $_POST['PBI_ORG'] . "'";

				if ($_POST['cost_center'] != "") $cost_center = " and p.cost_center='" . $_POST['cost_center'] . "'";

				if ($_POST['DEPT_ID'] != "") $dept = " and p.DEPT_ID='" . $_POST['DEPT_ID'] . "'";

				if ($_POST['section'] != "") $section = " and p.section='" . $_POST['section'] . "'";

				if ($_POST['JOB_LOC_ID'] > 0) $job_loc = " and p.JOB_LOC_ID='" . $_POST['JOB_LOC_ID'] . "'";

				if ($_POST['PBI_SEX'] != "") $gender = " and p.PBI_SEX='" . $_POST['PBI_SEX'] . "'";

				if ($_POST['grade'] != "") $grade = " and p.grade='" . $_POST['grade'] . "'";

				if ($_POST['work_station'] != "") $work = " and p.work_station='" . $_POST['work_station'] . "'";

				if ($_POST['level'] != "") $level = " and p.level='" . $_POST['level'] . "'";

				if ($_POST['class'] != "") $hrm_class = " and p.class='" . $_POST['class'] . "'";

				if ($_POST['PBI_RELIGION'] != "") $religion = " and p.PBI_RELIGION='" . $_POST['PBI_RELIGION'] . "'";

				if ($_POST['incharge_id'] != "") $incharge = " and p.incharge_id='" . $_POST['incharge_id'] . "'";



				$fdate =  date('Y-m-d', strtotime($fdate));
				$tdate =  date('Y-m-d', strtotime($tdate));


			?>
  <table style="width: auto; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">
    <tr>
      <td style="border:0px solid white;"><strong>Daily Attendance Report</strong></td>
    </tr>
    <tr>
      <td style="border:0px solid white;">Attendance Date :
        <?= date('d-M-Y', strtotime($_POST['fdate'])); ?></td>
    </tr>
  </table>
  <table style="width:auto;" cellpadding="0" cellspacing="0" border="1">
    <?

	$dept_sql = "select DISTINCT p.cost_center, dept.center_name 
   from hrm_att_summary s,personnel_basic_info p, hrm_cost_center dept

   where p.cost_center=dept.id and s.emp_id=p.PBI_ID and 
   
   s.att_date='" . $_POST['fdate'] . "' " 
   .$job_con.$IDConn.$codeConn.$NameConn.$org.$cost_center.$dept.$section.$job_loc.$gender.$grade.$work.$level.$hrm_class.$incharge. 
   
   " group by s.emp_id,p.cost_center order by p.cost_center asc";

					$dept_qry = db_query($dept_sql);
					while ($dept_data = mysqli_fetch_object($dept_qry)) {



					?>
    <tr>
      <td style="border:0px; font-size:16px; font-weight:bold;" colspan="10"><div align="left">
          <?= $dept_data->center_name ?>
        </div></td>
    </tr>
  </table>
  <style>
					.late {
						background-color: #FFFFCC;
					}

					/* Light pink */
					.absent {
						background-color: #FFDDDD;
					}

					/* Light salmon */
					.present {
						background-color: #DDFFDD;
					}

					/* Pale green */
					.leave {
						background-color: #DDFFFF;
					}

					/* Pale green */
					.earlyout {
						background-color: #DDFFDD;
					}

					/* Pale green */
					.leave {
						background-color: #DDFFFF;
					}

					/* Pale green */
				</style>
  <table style="width:100%;margin:0 auto;" cellpadding="0" cellspacing="0" border="1">
    <thead>
      <tr>
        <td rowspan="2"><strong>SL</strong></td>
        <td rowspan="2"><strong>Id</strong></td>
        <td rowspan="2"><strong>Name</strong></td>
        <td rowspan="2"><strong>Designation</strong></td>
        <td rowspan="2"><strong>DOJ</strong></td>
        <td rowspan="2"><strong>DOL</strong></td>
        <td rowspan="2"><strong>Department</strong></td>
        <td rowspan="2"><strong>Section</strong></td>
        <td rowspan="2"><strong>Shift In Time</strong></td>
        <td rowspan="2"><strong>Shift Out Time</strong></td>
        <td rowspan="2"><strong>In Time</strong></td>
        <td rowspan="2"><strong>Out Time</strong></td>
        <td rowspan="2"><strong>In Late</strong></td>
        <td rowspan="2"><strong>Early Out</strong></td>
		<td rowspan="2"><strong>OT</strong></td>
		<td rowspan="2"><strong>Workinng HR</strong></td> 
        <td rowspan="2"><strong>Status</strong></td>
      </tr>
    </thead>
    <?

   
   $basic_sql = "select s.*,p.PBI_CODE,p.PBI_NAME,p.DEPT_ID,p.section,p.PBI_DESIGNATION,p.EMPLOYMENT_TYPE,s.working_hours, s.ot_time_to_decimal,
  p.PBI_DOJ


  from hrm_att_summary s,personnel_basic_info p
  where s.emp_id = p.PBI_ID  and 
  p.cost_center='" . $dept_data->cost_center . "' and s.att_date='" . $_POST['fdate'] . "'  
  ".$job_loc.$IDConn.$org.$dept.$section.$work.$codeConn.$level.$hrm_class.$incharge.$job_status_con." ";

						$basic_query = db_query($basic_sql);
						$sl = 1;

						while ($r = mysqli_fetch_object($basic_query)) {

							if ($r->leave_id > 0) {
								$final_status = 'LEAVE';
							} elseif ($r->in_time == '' && $r->leave_id == 0  && $r->iom_id == 0) {
								$final_status = 'Absent';
							} elseif ($r->final_late_status > 0 && $r->final_early_status > 0) {
								$final_status = 'Late & Early Out';
							} elseif ($r->early_min > 0) {
								$final_status = 'Early Out';
							} elseif ($r->final_late_status > 0) {
								$final_status = 'LATE';
							} elseif ($r->holyday > 0) {
								$final_status = 'HOLIDAY';
							} elseif ($r->sch_off_day > 0) {
								$final_status = 'Weekend';
							} elseif ($r->iom_id > 0) {
								$final_status = 'Amendment';
							} elseif ($r->present > 0) {
								$final_status = 'PRESENT';
							} else {

								$final_status = 'Absent';
							}


							// for warning by color
							$class = '';
							switch ($final_status) {
								case 'LATE':
									$class = 'late';
									break;
								case 'Absent':
									$class = 'absent';
									break;
								case 'PRESENT':
									$class = 'present';
									break;

								case 'Leave':
									$class = 'leave';
									break;
							}





					?>
    <tr>
      <td><?= ++$i ?></td>
      <td><?= $r->PBI_CODE ?></td>
      <td><?= $r->PBI_NAME ?></td>
      <td><?= $r->PBI_DESIGNATION ?></td>
      <td><?= $r->PBI_DOJ ?></td>
      <td><? //=$hl_first
								?></td>
      <td><?= find_a_field('department', 'DEPT_DESC', 'DEPT_ID="' . $r->DEPT_ID . '"'); ?></td>
      <td><?= find_a_field('PBI_Section', 'sec_name', 'sec_id="' . $r->section . '"'); ?></td>
      <td><?= date("h:i a", strtotime($r->sch_in_time)); ?></td>
      <td><?= date("h:i a", strtotime($r->sch_out_time)); ?></td>
      <td><? if ($r->in_time > 0)  echo date("H:i a", strtotime($r->in_time)); ?></td>
      <td><? if ($r->out_time > 0) echo date("H:i a", strtotime($r->out_time)); ?></td>
      <td><?= $r->actual_late_min ?></td>
      <td><?= $r->final_early_min ?></td>
	  <td><?= $r->ot_time_to_decimal ?></td>
	 <td><?= $r->working_hours ?></td> 
      <td class="<?= $class ?>"><?= $final_status; ?></td>
    </tr>
    <?



						}

						$i = 0;
					}

				?>
  </table>
  <br />
  <br />
  <!-- invalid report from dump   -->
  <? } elseif ($_POST['report'] == 11223344) {











				$report = "Employee Basic Information Report";



				$fdate = $_POST['year'] . '-' . $_POST['mon'] . '-01';







			?>
  <table style="width: auto; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">
    <tr>
      <td style="border:0px solid white;"><strong>Employee Basic Information Report</strong></td>
    </tr>
    <tr>
      <td style="border:0px solid white;">Period :
        <?= date('M-Y', strtotime($fdate)); ?></td>
    </tr>
  </table>
  <table style="width:auto;" cellpadding="0" cellspacing="0" border="1">
    <?

					$dept_sql = "select DISTINCT a.DEPT_ID,dept.DEPT_DESC from personnel_basic_info a, department dept

   where a.DEPT_ID=dept.DEPT_ID " . $con . "  group by a.DEPT_ID order by a.DEPT_ID asc";

					$dept_qry = db_query($dept_sql);

					while ($dept_data = mysqli_fetch_object($dept_qry)) {



					?>
    <tr>
      <td style="border:0px; font-size:16px; font-weight:bold;" colspan="10"><div align="left">
          <?= $dept_data->DEPT_DESC ?>
        </div></td>
    </tr>
  </table>
  <table style="width:100%;margin:0 auto;" cellpadding="0" cellspacing="0" border="1">
    <thead>
      <tr>
        <td><strong>SL</strong></td>
        <td><strong>Emp Id</strong></td>
        <td><strong>EMP Name</strong></td>
        <td><strong>Father Name</strong></td>
        <td><strong>MotherName</strong></td>
        <td><strong>National ID</strong></td>
        <td><strong>Date of Birth</strong></td>
        <td><strong>Education</strong></td>
        <td><strong>Gender</strong></td>
        <td><strong>Marital Status</strong></td>
        <td><strong>Religion</strong></td>
        <td><strong>Nationality</strong></td>
        <td><strong>Permanent Address</strong></td>
        <td><strong>Present Address</strong></td>
        <td><strong>Mobile</strong></td>
        <td><strong>Email</strong></td>
        <td><strong>Blood Group</strong></td>
        <td><strong>Emergency Contact</strong></td>
        <td><strong>Emergency Contact Relation</strong></td>
        <td><strong>Employement Type</strong></td>
        <td><strong>Job Location</strong></td>
        <td><strong>Company</strong></td>
        <td><strong>Department</strong></td>
        <td><strong>Date of Joining</strong></td>
        <td><strong>Designation</strong></td>
        <td><strong>Image</strong></td>
      </tr>
    </thead>
    <?









						$report = "Employee Basic Information";



						$sql = "select a.PBI_ID,a.PBI_CODE,a.PBI_ORG,a.PBI_NAME as Name,a.PBI_FATHER_NAME as father_name,a.PBI_MOTHER_NAME as mother_name,a.ESSENTIAL_NATIONAL_ID as national_id,a.PBI_DOB as dob,a.PBI_EDU_QUALIFICATION as education,a.PBI_SEX as gender,a.PBI_MARITAL_STA as marital_status,a.PBI_RELIGION as religion,a.PBI_NATIONALITY as nationality,a.PBI_PERMANENT_ADD,a.PBI_PRESENT_ADD,a.PBI_MOBILE,a.PBI_EMAIL,a.ESSENTIAL_BLOOD_GROUP as blood_group,a.EMR_MOBILE as emergency_contact,a.EMR_RELATION as emergency_contact_relation,a.EMPLOYMENT_TYPE,a.JOB_LOCATION,a.PBI_COMPANY, a.PBI_DESIGNATION as designation, a.PBI_DEPARTMENT as department,a.PBI_DOJ from personnel_basic_info a



where a.DEPT_ID=" . $dept_data->DEPT_ID . " " . $con . $employee_con . $service_con . " order by a.PBI_ID";







						$basic_query = db_query($sql);







						$sl = 1;





						while ($r = mysqli_fetch_object($basic_query)) {



					?>
    <tr>
      <td><?= ++$s; ?></td>
      <td><?= $r->PBI_CODE ?></td>
      <td><?= $r->Name ?></td>
      <td><?= $r->father_name ?></td>
      <td><?= $r->mother_name ?></td>
      <td><?= $r->national_id ?></td>
      <td><?= $r->dob ?></td>
      <td><?= find_a_field('education_detail', 'concat(EDUCATION_NOE,"-",EDUCATION_SUBJECT)', 'PBI_ID=' . $r->PBI_ID); ?></td>
      <td><?= $r->gender ?></td>
      <td><?= $r->marital_status ?></td>
      <td><?= $r->religion ?></td>
      <td><?= $r->nationality ?></td>
      <td><?= $r->PBI_PERMANENT_ADD ?></td>
      <td><?= $r->PBI_PRESENT_ADD ?></td>
      <td><?= $r->PBI_MOBILE ?></td>
      <td><?= $r->PBI_EMAIL ?></td>
      <td><?= $r->blood_group ?></td>
      <td><?= $r->emergency_contact ?></td>
      <td><?= $r->emergency_contact_relation ?></td>
      <td><?= $r->EMPLOYMENT_TYPE ?></td>
      <td><?= $r->JOB_LOCATION ?></td>
      <td><?= find_a_field('user_group', 'group_name', 'id=' . $r->PBI_ORG) ?></td>
      <td><?= $r->department ?></td>
      <td><?= $r->PBI_DOJ ?></td>
      <td><?= $r->designation ?></td>
      <td style="padding:0px !important"><img class="profile-user-img img-fluid img-circle" src="../../pic/staff/<?= $r->PBI_CODE ?>.jpg" alt="User profile picture" width="100px"></td>
    </tr>
    <?php







						}

						$total += $s;



						$s = 0;
					}

				?>
    <tr>
      <td colspan="26">Total :
        <?= $total; ?></td>
    </tr>
  </table>
  <br />
  <br />
  <!-- attendence report from dump   -->
  <? } elseif ($_POST['report'] == 3) {











				$dateObj   = DateTime::createFromFormat('!m', $_POST['mon']);















				$monthName = $dateObj->format('F');
























				if ($_POST['mon'] != '')



					$att_con = ' and d.mon="' . $_POST['mon'] . '"';































				if ($_POST['year'] != '')















					$att_con .= ' and d.year="' . $_POST['year'] . '"';























				if ($_POST['department'] != '')















					$b_con .= ' and p.PBI_DEPARTMENT="' . $_POST['department'] . '"';































				if ($_POST['JOB_LOCATION'] != '')















					$b_con .= ' and p.JOB_LOCATION="' . $_POST['JOB_LOCATION'] . '"';































				if ($_POST['PBI_ID'] != '')















					$att_con .= ' and d.bizid="' . $_POST['PBI_ID'] . '"';















				$sdate = $_POST['year'] . '-' . $_POST['mon'] . '-01';















				$edate = $_POST['year'] . '-' . $_POST['mon'] . '-31';























			?>
  <table style="width: auto; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">
    <tr> </tr>
    <tr>
      <td style="border:0px solid white;"><?= $str ?></td>
    </tr>
  </table>
  <table style="width:300px;margin: 0 auto;  font-size: 20px;text-align:center;" cellpadding="0" cellspacing="0" border="1">
    <tr>
      <td colspan="2">Monthly Summery</td>
    </tr>
    <tr>
      <td colspan="2"><?= $monthName . ' ' . $_POST['year'] ?></td>
    </tr>
    <tr>
      <td>Absent</td>
      <td></td>
    </tr>
    <tr>
      <td>LWP</td>
      <td><?= find_a_field('hrm_leave_info', 'sum(total_days)', 's_date>="' . $sdate . '" and e_date<="' . $edate . '" and type=9 and leave_status="GRANTED"'); ?></td>
    </tr>
    <tr>
      <td>Leave</td>
      <td><?= find_a_field('hrm_leave_info', 'sum(total_days)', 's_date>="' . $sdate . '" and e_date<="' . $edate . '" and type not in ("Short Leave (SHL)") and leave_status="GRANTED"'); ?></td>
    </tr>
    <tr>
      <td>SHL</td>
      <td><?= find_a_field('hrm_leave_info', 'sum(total_days)', 'half_leave_date>="' . $sdate . '" and half_leave_date<="' . $edate . '" and type="Short Leave (SHL)" and leave_status="Granted"'); ?></td>
    </tr>
    <tr>
      <td>Late In</td>
      <td><?= find_a_field('hrm_attdump', 'count(bizid)', 'xdate>="' . $sdate . '" and xdate<="' . $edate . '"  and late_in=1'); ?></td>
    </tr>
  </table>
  <table style="width: 80%; margin: 0 auto;text-align:center;" cellpadding="0" cellspacing="0" class="oe_list_content">
    <thead>
      <tr class="oe_list_header_columns" style=" text-align:center; font-size:12px;" align="center">
        <th>S/L</th>
        <th style=""> <div align="center">Attendance Date</div></th>
        <th> <div align="center">Employee ID</div></th>
        <th> <div align="center">Employee Name</div></th>
        <th align="center"> <div align="center">Designation</div></th>
        <th align="center"> <div align="center">Department</div></th>
        <th align="center"> <div align="center">Job Location/Project</div></th>
        <th> <div align="center">Check in</div></th>
        <th> <div align="center">Check out</div></th>
        <th> <div align="center">Total Working Time</div></th>
        <th> <div align="center">Late in days</div></th>
        <th> <div align="center">OD</div></th>
        <th> <div align="center">SHL</div></th>
        <th> <div align="center">Leave</div></th>
      </tr>
    </thead>
    <tbody>
      <?























						if ($_POST['year'] != "" && $_POST['mon'] != "") {































							$join_con = ' and j.ESSENTIAL_RESIG_DATE between "' . $_POST['year'] . '-' . $_POST['mon'] . '-1" and "' . $_POST['year'] . '-' . $_POST['mon'] . '-31"';
						}
































































						$all = 'select p.PBI_NAME,p.PBI_ID,desg.DESG_DESC as designation, dept.DEPT_DESC as department from personnel_basic_info p, designation desg, department dept where p.PBI_DESIGNATION=desg.DESG_ID and p.PBI_DEPARTMENT=dept.DEPT_ID















 and p.PBI_JOB_STATUS="In Service" ' . $b_con . ' order by p.PBI_ID';































































						$att_query = db_query($all);























						$s3 = 1;















						while ($basic_data = mysqli_fetch_object($att_query)) {















							for ($i = 1; $i <= 30; $i++) {















								$all_date = '' . $_POST['year'] . '-' . $_POST['mon'] . '-' . $i . '';































								$att_sql = 'select DATE_FORMAT(d.xdate,"%d-%b-%Y") as xdate,d.ztime,d.xtime,d.bizid,d.od,d.late_in,d.early_out,d.mon,d.year,d.leave_id,d.od_id,d.shl  from















    hrm_attdump d where d.xdate="' . $all_date . '" and d.bizid="' . $basic_data->PBI_ID . '" ' . $att_con . ' order by d.bizid,d.xdate';































								$nquery = db_query($att_sql);















								$att_data = mysqli_fetch_object($nquery);















								$leave_info = find_a_field('hrm_leave_info', 'type', 'id="' . $att_data->leave_id . '"');















								$leave_infoSHORT = find_a_field('hrm_leave_info', 'type', 'id="' . $att_data->shl . '"');







































































								$leave_name = find_a_field('hrm_leave_type', 'leave_type_name', 'id="' . $leave_info . '"');















								$f = date('D', strtotime($all_date));















								$att_status = find_a_field('hrm_attdump', 'attendence', 'bizid="' . $basic_data->PBI_ID . '" and xdate="' . $all_date . '"');















								$holiday = find_a_field('salary_holy_day', 'reason', 'holy_day="' . $all_date . '"');















						?>
      <tr align="center">
        <td><?= ++$j; ?></td>
        <td><?= date('d-M-Y', strtotime($all_date)) ?></td>
        <td><?= $basic_data->PBI_ID ?></td>
        <td><?= $basic_data->PBI_NAME ?></td>
        <td><?= $basic_data->designation ?></td>
        <td><?= $basic_data->department ?></td>
        <td><?= $basic_data->project ?></td>
        <td><? if ($att_data->ztime != '0000-00-00 00:00:00' && $att_data->ztime != '') {















											echo $ztime = date('h:i', strtotime($att_data->ztime));
										} else {















































											if ($f == 'Fri') {















												echo '<span style="font-weight:bold;">Friday</span>';
											} elseif ($att_status == 3) {















												echo '<span style="font-weight:bold;">Dayoff</span>';
											} elseif ($holiday != '') {















												echo '<span style="font-weight:bold;">' . $holiday . '</span>';
											} elseif ($att_status == 4) {















												echo '<span style="font-weight:bold;">Leave</span>';
											} elseif ($att_status == 2) {















												echo '<span style="font-weight:bold; color:#FF0000;">Absent</span>';
											} elseif ($att_status == 1) {















												echo '<span style="font-weight:bold; color:#000;">' . $ztime . '</span>';
											} else {















												echo '<span style="font-weight:bold; color:#FF0000;">Absent</span>';
											}
										} ?></td>
        <td><? if ($att_data->xtime != '0000-00-00 00:00:00' && $att_data->xtime != '') {















											echo $xtime = date('h:i', strtotime($att_data->xtime));
										} else {















											$friday = find_a_field('friday', 'status', 'date="' . $all_date . '"');































											if ($f == 'Fri') {















												echo '<span style="font-weight:bold;">Friday</span>';
											} elseif ($holiday != '') {















												echo '<span style="font-weight:bold;">' . $holiday . '</span>';
											} elseif ($att_status == 3) {















												echo '<span style="font-weight:bold;">Dayoff</span>';
											} elseif ($att_status == 4) {















												echo '<span style="font-weight:bold;">Leave</span>';
											} elseif ($att_status == 2) {















												echo '<span style="font-weight:bold; color:#FF0000;">Absent</span>';
											} elseif ($att_status == 1) {















												echo '<span style="font-weight:bold; color:#000;">' . $xtime . '</span>';
											} else {















												echo '<span style="font-weight:bold; color:#FF0000;">Absent</span>';
											}
										} ?></td>
        <td><? $datetime1 = new DateTime($xtime);















										$datetime2 = new DateTime($ztime);















										$interval = $datetime1->diff($datetime2);















										$interval->format('%h') . " Hours " . $interval->format('%i') . " Minutes";















										?></td>
        <td><? if ($att_data->late_in > 0) {















											echo '<span style="font-weight:bold;">Late</span>';
										} else {































											if ($f == 'Fri') {















												echo '<span style="font-weight:bold;">Friday</span>';
											} elseif ($holiday != '') {















												echo '<span style="font-weight:bold;">' . $holiday . '</span>';
											} elseif ($att_status == 4) {















												echo '<span style="font-weight:bold;">Leave</span>';
											} elseif ($att_status == 3) {















												echo '<span style="font-weight:bold;">Dayoff</span>';
											} elseif ($att_status == 2) {















												echo '<span style="font-weight:bold; color:#FF0000;">Absent</span>';
											}
										}















										?>
        </td>
        <td><? if ($att_data->od_id > 0) echo '<a href="od_view.php?od_id=' . $att_data->od_id . '" target="_blank">OD</a>'; ?></td>
        <td><? echo $leave_infoSHORT   ?></td>
        <td><? if ($leave_name) echo '<span style="font-weight:bold;">' . $leave_name . '</span>'; ?></td>
      </tr>
      <?















							}
						}























						?>
  </table>
  <br />
  <br />
  <!--end  attendence report from dump   -->
  <? } elseif ($_POST['report'] == 22222) {















			?>
  <table width="100%" cellpadding="0" cellspacing="0" border="1" bordercolor="#000000">
    <thead>
      <tr>
        <td style="border:0px;" colspan="13"><?= $str ?></td>
      </tr>
    </thead>
    <?















					$begin = new DateTime($start_date);















					$end   = new DateTime($end_date);















					$x = 0;















					for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
						$x++;















						$date_ymd[$x] = $i->format("Y-m-d");















						$date_stamp[$x] = strtotime($date[$x]);
					}































					echo $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT,a.JOB_LOCATION from 	personnel_basic_info a where  1 " . $con . "  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";



					$query = db_query($sql);















					while ($info = mysqli_fetch_object($query)) {































						$sql_sks = 'SELECT id, point_short_name,job_location FROM `hrm_roster_point` ';















						$sks_query = db_query($sql_sks);















						while ($sks_r = mysqli_fetch_object($sks_query)) {















					?>
    <tr>
      <td rowspan="2">SL</td>
      <td rowspan="2"><?= $sks_r->point_short_name; ?></td>
      <td rowspan="2">Cell No </td>
      <?















								for ($p = 1; $p >= $x; $p++) {















								?>
      <td><?















										echo date('M-d', $date_stamp[$p]);















										?></td>
      <?















								}















								?>
    </tr>
    <tr>
      <?















								for ($pp = 1; $pp >= $x; $pp++) {















								?>
      <td><?















										echo date('D', $date_stamp[$pp]);















										?></td>
      <?















								}















								?>
    </tr>
    <?















							$sqlss = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT,a.PBI_MOBILE from















personnel_basic_info a,hrm_roster_allocation r















where " . $con . " r.PBI_ID=a.PBI_ID and r.roster_date between '" . $start_date . "' and '" . $end_date . "' and a.JOB_LOCATION = '" . $sks_r->job_location . "'  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";















							$querys = db_query($sqlss);















							while ($datas = mysqli_fetch_array($querys)) {















							?>
    <tr>
      <td><?= ++$s ?></td>
      <td><?= $datas->PBI_NAME ?></td>
      <td><?= $datas->PBI_MOBILE ?></td>
      <?















									for ($ppp = 1; $ppp >= $x; $ppp++) {















									?>
      <td><?= find_a_field('hrm_roster_allocation r,hrm_schedule_info s', 's.schedule_name', 'r.PBI_ID ="' . $info->PBI_ID . '" and r.shedule_1=s.id and r.roster_date = "' . date('Y-m-d', $date_stamp[$ppp]) . '"') ?></td>
      <? } ?>
    </tr>
    <?















							}
						}
					}















					?>
  </table>
  <?















			} elseif (isset($sql) && $sql != '') {
				echo report_create($sql, 1, $str);
			}
			elseif($_POST['report']==9194)
			{
			        $report = "Dropout report";
        $company = $_POST['PBI_ORG'];
        $cost_centre = $_POST['cost_center'];
        $class_name = $_POST['class'];
        $location = $_POST['JOB_LOC_ID'];
        
        
      ?>
  <style>
     
    body {
    @media print {
        margin-top: 1.3cm !important;
        margin-bottom: 1cm !important;
        
    }
}
.print-button {
        display: none;
    }


table {
    border-collapse: collapse;
    width: 100%;
}

#heading {
    text-align: center;
    font-size: 14px;
    height: 70px;
    background-color: #f2f2f2;
    border-bottom: 1px solid black;
    margin-bottom: 20px;
    line-height: 1.7; 
}

.info_table {
    margin-top: 20px;
}

.info_table tr {
    height: 30px;
    border-bottom: 1px solid black;
}

.all_table {
    border: none !important;
}

@media print {
    body {
        zoom: 80%;
    }

    /* Ensure background colors are printed */
    table, th, td {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}




		 
        </style>
		<table width="100%" cellspacing="0" cellpadding="2" border="1" id="ExportTable">
    <thead>
      <tr>
        <th colspan="18" style=" border: none; "> <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tbody>
              <tr>
                <td style="border:0px;" width="10%" align="left"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['proj_id'] ?>.png" width="100%"></td>
                <td style="border:0px;" width="70%" align="center"><h1 style="font-weight: 600;">
                    <?= $report ?>
                  </h1>
                  <h3>For the Month of:
                    <?= date('F-Y', mktime(1, 1, 1, $_POST['mon'], 1, $_POST['year'])) ?>
                  </h3>
                  <h1 style="padding-top: 10px;">
                    <?php if($cost_centre !=0){ ?>
                    <strong>Cost Centre:</strong>
                    <?=find_a_field('hrm_cost_center','center_name','id=' .$cost_centre);?>
                    ,
                    <? } ?>
                    <?php if($class_name!=0){ ?>
                    <strong>Class:</strong>
                    <?=find_a_field('hrm_class','class_name','id='.$class_name);?>
                    ,
                    <? } ?>
                    <?php if($location !=0){ ?>
                    <strong>Location:</strong>
                    <?=find_a_field('project','PROJECT_DESC','PROJECT_ID =' .$location);?>
                    <? } ?>
                  </h1></td>
                <td style="border:0px;" width="10%"></td>
              </tr>
            </tbody>
          </table>
		
  <table width="100%" border="1" cellpadding="0" cellspacing="0" >
    <thead>
      <tr>
        <td style="border:0px;" colspan="6"><h3 style="text-align:center">
            <?=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);?>
          </h3></td>
      </tr>
      <tr>
        <th>SL</th>
        <th>EMP ID</th>
        <th>Name</th>
        <th>Designation</th>
		 <th>Department</th>
		   <th>Section</th>
		      <th>Cost Centre</th>
			     <th>Function</th>
       
        <th>Reason</th>
		 <th>DOL</th>
      </tr>
    </thead>
    <?php 
			  if($_POST['PBI_ORG']!='')
			  {
			  $con='and PBI_ORG="'.$_POST['PBI_ORG'].'"';
			  }
			  
			  $s=1;
			  $res="select a.*,s.*,

a.MACHINE_ID as Machine_ID, a.resign_date,
(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,(select group_name from user_group where id=a.PBI_ORG) as group_name, (select sec_name from PBI_Section where sec_id=a.section)as section,   (select center_name from hrm_cost_center where id=a.cost_center)as cost_center,(select function_name from hrm_function where id=a.PBI_FUNCTION)as funct,
(select DEPT_DESC from department where DEPT_ID = a.DEPT_ID) as department,DATE_FORMAT(a.PBI_DOJ,'%d-%m-%Y') as joining_date, DATE_FORMAT(a.PBI_DOC2,'%d-%m-%Y') as confirmation_date,a.PBI_DOB,DATE_FORMAT(a.PBI_DOC2,'%d-%m-%Y') as confirmation_date, a.PBI_DURATION as confirmation_month,
CONCAT(TIMESTAMPDIFF(YEAR, `PBI_DOJ`, CURDATE()),' Year,',TIMESTAMPDIFF(MONTH, `PBI_DOJ`, CURDATE()) % 12,' mon') as service,
PBI_SEX as gender,PBI_RELIGION as religion,PBI_BLOOD_GROUP as blood_group,a.PBI_PHONE as mobile,a.PBI_EMAIL as email,
a.nid as NID,a.PBI_BANK_ACC_NO as Bank_Account,EMPLOYMENT_TYPE as Employment_Type,a.salary_schedule,a.grade
from personnel_basic_info a , salary_info s
where	1 and emp_deletion_reason=1  " . $secConn . $classConn . $inchargeConn.$CostConn.$depConn.$JoblocConn.$OrgConn.$job_statusConn.$JOB_LOC_ID_BLOCK. " and s.PBI_ID=a.PBI_ID order by a.PBI_ID asc";
			  $query=db_query($res);
			  while($row=mysqli_fetch_object($query))
			  {
			  
			  ?>
    <tr>
      <td><?=$s++;?></td>
      <td><?=$row->PBI_CODE?></td>
      <td><?=$row->PBI_NAME?></td>
      <td><?=$row->PBI_DESIGNATION?></td>
      <td><?=$row->PBI_DEPARTMENT?></td>
	  <td nowrap="nowrap"><?= $row->section ?></td>
	  <td nowrap="nowrap"><?= $row->cost_center ?></td>
	  <td nowrap="nowrap"><?= $row->funct?></td>
       
      <td><?=find_a_field('hrm_deletion_reason','deletion_type','id='.$row->emp_deletion_reason);?></td>
	   <td><? if ($row->resign_date > 0) echo date('j-M-Y', strtotime($row->resign_date)) ?></td>
    </tr>
    <? } ?>
  </table>
  <?
			} elseif($_POST['report']==9195)
			{
			?>
  <table width="100%" border="1" cellpadding="0" cellspacing="0" >
    <thead>
      <tr>
        <td style="border:0px;" colspan="6"><h3 style="text-align:center">
            <?=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);?>
          </h3></td>
      </tr>
      <tr>
        <th>SL</th>
        <th>EMP ID</th>
        <th>Name</th>
        <th>Designation</th>
        <th>Department</th>
        <th>Punishment Type</th>
      </tr>
    </thead>
    <?php 
			  if($_POST['PBI_ORG']!='')
			  {
			  $con='and PBI_ORG="'.$_POST['PBI_ORG'].'"';
			  }
			  
			  $s=1;
			  $res="SELECT l.*, a.leave_punishment_status as punishment_type 
FROM hrm_leave_info a, personnel_basic_info l 
WHERE l.PBI_ID = a.PBI_ID AND a.leave_punishment_status > 0
".$con.";";
 

			  $query=db_query($res);
			  while($row=mysqli_fetch_object($query))
			  {
			  
			  ?>
    <tr>
      <td><?=$s++;?></td>
      <td><?=$row->PBI_CODE?></td>
      <td><?=$row->PBI_NAME?></td>
      <td><?=$row->PBI_DESIGNATION?></td>
      <td><?=$row->PBI_DEPARTMENT?></td>
      <td><?=$row->punishment_type?></td>
    </tr>
    <? } ?>
  </table>
  <? }elseif($_POST['report']==9196)
			{
        $report = "Tiffin Bill";
        $company = $_POST['PBI_ORG'];
        $cost_centre = $_POST['cost_center'];
        $class_name = $_POST['class'];
        $location = $_POST['JOB_LOC_ID'];
        
        
      ?>
  <style>
     
    body {
    @media print {
        margin-top: 1.3cm !important;
        margin-bottom: 1cm !important;
        
    }
}
.print-button {
        display: none;
    }


table {
    border-collapse: collapse;
    width: 100%;
}

#heading {
    text-align: center;
    font-size: 14px;
    height: 70px;
    background-color: #f2f2f2;
    border-bottom: 1px solid black;
    margin-bottom: 20px;
    line-height: 1.7; 
}

.info_table {
    margin-top: 20px;
}

.info_table tr {
    height: 30px;
    border-bottom: 1px solid black;
}

.all_table {
    border: none !important;
}

@media print {
    body {
        zoom: 80%;
    }

    /* Ensure background colors are printed */
    table, th, td {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}




		 
        </style>
  <table width="100%" cellspacing="0" cellpadding="2" border="1" id="ExportTable">
    <thead>
      <tr>
        <th colspan="18" style=" border: none; "> <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tbody>
              <tr>
                <td style="border:0px;" width="10%" align="left"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['proj_id'] ?>.png" width="100%"></td>
                <td style="border:0px;" width="70%" align="center"><h1 style="font-weight: 600;">
                    <?= $report ?>
                  </h1>
                  <h3>For the Month of:
                    <?= date('F-Y', mktime(1, 1, 1, $_POST['mon'], 1, $_POST['year'])) ?>
                  </h3>
                  <h1 style="padding-top: 10px;">
                    <?php if($cost_centre !=0){ ?>
                    <strong>Cost Centre:</strong>
                    <?=find_a_field('hrm_cost_center','center_name','id=' .$cost_centre);?>
                    ,
                    <? } ?>
                    <?php if($class_name!=0){ ?>
                    <strong>Class:</strong>
                    <?=find_a_field('hrm_class','class_name','id='.$class_name);?>
                    ,
                    <? } ?>
                    <?php if($location !=0){ ?>
                    <strong>Location:</strong>
                    <?=find_a_field('project','PROJECT_DESC','PROJECT_ID =' .$location);?>
                    <? } ?>
                  </h1></td>
                <td style="border:0px;" width="10%"></td>
              </tr>
            </tbody>
          </table></th>
      </tr>
      <tr>
        <th> <div align="center">SL </div></th>
        <th> <div align="center">Department </div></th>
        <th> <div align="center">Section </div></th>
        <th> <div align="center">ID Card No.</div></th>
        <th> <div align="left">Name</div></th>
        <th> <div align="center">Designation </div></th>
        <th> <div align="center">OT Days </div></th>
        <th> <div align="center">Rate </div></th>
        <th> <div align="center">Total</div></th>
        <th> <div align="center">Signature</div></th>
      </tr>
    </thead>
    <tbody class="new-body">
      <?


                            if($_POST['PBI_CODE']!="") $codeConn = " and a.PBI_CODE='".$_POST['PBI_CODE']."'";
                            if($_POST['PBI_IDD']!="") $idConn = " and a.PBI_ID ='".$_POST['PBI_IDD']."'";
                          
                            if($_POST['PBI_NAME']!="") $NameConn = " and a.PBI_NAME='".$_POST['PBI_NAME']."'";
                            if($_POST['DESG_ID']>0) $desgConn = " and a.DESG_ID='".$_POST['DESG_ID']."'";
                            if($_POST['DEPT_ID']>0) $depConn = " and a.DEPT_ID='".$_POST['DEPT_ID']."'";
                            if($_POST['PBI_SEX']!="") $genderConn = " and a.PBI_SEX='".$_POST['PBI_SEX']."'";
                            if($_POST['grade']>0) $gradeConn = " and a.grade='".$_POST['grade']."'";  
                            if($_POST['work_station']>0) $work_station = " and a.PBI_WORK_STATION='".$_POST['work_station']."'";  
                            
                            
                            
                            if($_POST['PBI_RELIGION']!="") $ReligionConn = " and a.PBI_RELIGION='".$_POST['PBI_RELIGION']."'";
                            if($_POST['PBI_ORG']>0) $OrgConn = " and a.PBI_ORG='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and a.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
                            
                            if($_POST['section']>0) $secConn = " and a.section='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and a.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['cost_center']>0) $CostConn = " and a.cost_center='".$_POST['cost_center']."'";
                     
                            
                            if($_POST['class']>0) $classConn = " and a.class='".$_POST['class']."'";
                            if($_POST['line']>0) $lineConn = " and a.line='".$_POST['line']."'";
                            if($_POST['incharge_id']>0) $inchargeConn = " and a.incharge_id='".$_POST['incharge_id']."'";
							
                            if($_POST['DOJ']>0) $DOJConn = " and a.PBI_DOJ='".$_POST['DOJ']."'";
                            
						  	if($_POST['shedule']>0) $shiftConn = " and a.define_schedule ='".$_POST['shedule']."'";
						  	
						  	$user_id  =  $_SESSION['user']['id'];
                            if($user_id == 10073 || $user_id == 10074 || $user_id == 10108) $JOB_LOC_ID_BLOCK = " and a.JOB_LOC_ID !=3";
							$days=cal_days_in_month(CAL_GREGORIAN,$_POST['mon'],$_POST['year']);
							
							$joining_date_check = $_POST['year'].'-'.$_POST['mon'].'-'.$days;



  $sqll = "SELECT a.PBI_CODE as Emp_ID,a.PBI_NAME as Name,a.PBI_ID,

(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,
(select sec_name from PBI_Section where sec_id = a.section) as Section,

 

a.PBI_DEPARTMENT as department,a.line as Line, a.PBI_DOJ as DOJ , 

b.td as Tot_days, b.pre as Present,b.od as Weekend ,b.hd as Holiday, b.lv as leave_day , b.ab AS Absent,
b.pay as Payble_days , b.lt as In_Late_days,b.eo as Early_Out_Days,
b.total_late_min as Total_Late_Min, b.ot as OT_Hour, b.lwp as LWP,b.holiday_present,b.day_off,b.full_day_iom, b.leave_punishment ,
 
b.leave_punishment as Leave_Punishment,b.working_hour as Working_Hour,a.resign_date

FROM personnel_basic_info a,hrm_attendence_final b 

where a.PBI_ID=b.PBI_ID and  a.PBI_DOJ <= '" .$joining_date_check. "' and b.pre>0  

and b.mon='" . $_POST['mon'] . "' and b.year='" . $_POST['year'] . "'" 
.$work_station.$OrgConn.$codeConn.$CostConn.$secConn.$idConn.$job_statusConn.$JOB_LOC_ID_BLOCK.$inchargeConn.$DOJConn.$shiftConn.$classConn.$JoblocConn.$depConn. $NameConn . "

order by b.PBI_ID";

               
               
             

            $queryd = db_query($sqll);
            while ($data = mysqli_fetch_object($queryd)) {
                
                
           
	$sdate = $_POST['year'] . '-' . $_POST['mon'] . '-01';
			$edate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
			
  $total_ot_days = find_a_field('hrm_att_summary','count(id)','att_date between 
 "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" and ot_time_to_decimal >=1  and emp_id='.$data->PBI_ID);
 
 $total +=$total_ot_days*20;
 
 if($total_ot_days >0){

            ?>
      <tr>
        <td style="height: 50px;"><?= ++$s ?></td>
        <td style="height: 50px;"><?= $data->department; ?></td>
        <td style="height: 50px;"><?= $data->Section; ?></td>
        <td style="height: 30px;"><?= $data->Emp_ID; ?></td>
        <td style="height: 30px;"><?= $data->Name; ?></td>
        <td style="height: 30px;"><?= $data->designation; ?></td>
        <td style="height: 30px;" ><?=$total_ot_days;?>
        </td>
        <td style="height: 30px;">20</td>
        <td style="height: 30px;"><?=($total_ot_days*20);?></td>
        <td style="height: 30px;"></td>
      </tr>
      <?  }} ?>
      <tr>
        <td style="height: 30px;">&nbsp;</td>
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
        <td style="height: 30px;" colspan="3" align="right" style="font-weight:bold;">
        Total:
        </td>
        <td align="right"><strong></strong></td>
        <td align="right"><strong></strong></td>
        <td align="right"><strong></strong></td>
        <td align="right"><strong></strong></td>
        <td align="right"><strong></strong></td>
        <td align="right"><strong>
          <?=number_format($total,2);?>
          </strong></td>
        <td align="right"><strong></strong></td>
      </tr>
    </tbody>
  </table>
  <tr>
    <td class="all_table"></td>
  </tr>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <tr>
    <td class="all_table"></td>
  </tr>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <tr>
    <td colspan="4" class="all_table"><table width="100%" height="100px">
      <tr>
        <td width="20%" class="all_table"><div align="center">
            <p style="text-decoration: overline;"><strong> Prepared By </strong></p>
          </div></td>
        <td width="20%" class="all_table"><div align="center">
            <p style="text-decoration: overline;"><strong> Checked  By </strong></p>
          </div></td>
        <td width="20%" class="all_table"><div align="center">
            <p style="text-decoration: overline;"><strong> HR & Admin</strong></p>
          </div></td>
        <td width="20%" class="all_table"><div align="center">
            <p style="text-decoration: overline;"><strong>F. &amp; Accounts </strong></p>
          </div></td>
        <td width="20%" class="all_table"><div align="center">
            <p style="text-decoration: overline;"><strong> Approved By </strong></p>
          </div></td>
      </tr>
      <?
      }elseif($_POST['report']==9197)
			{
        $report = "Dinner Bill";
        $company = $_POST['PBI_ORG'];
        $cost_centre = $_POST['cost_center'];
        $class_name = $_POST['class'];
        $location = $_POST['JOB_LOC_ID'];
      ?>
      <style>
	 body {
    @media print {
        margin-top: 1.3cm !important;
        margin-bottom: 1cm !important;
        
    }
}
.print-button {
        display: none;
    }


table {
    border-collapse: collapse;
    width: 100%;
}

#heading {
    text-align: center;
    font-size: 14px;
    height: 70px;
    background-color: #f2f2f2;
    border-bottom: 1px solid black;
    margin-bottom: 20px;
    line-height: 1.7; 
}

.info_table {
    margin-top: 20px;
}

.info_table tr {
    height: 30px;
    border-bottom: 1px solid black;
}

.all_table {
    border: none !important;
}

@media print {
    body {
        zoom: 80%;
    }

    /* Ensure background colors are printed */
    table, th, td {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}

		 
        </style>
      <table width="100%" cellspacing="0" cellpadding="2" border="1" id="ExportTable">
        <thead>
          <tr>
            <th colspan="18" style=" border: none; "> <table width="100%" cellspacing="0" cellpadding="2" border="0">
                <tbody>
                  <tr>
                    <td style="border:0px;" width="10%" align="left"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['proj_id'] ?>.png" width="100%"></td>
                    <td style="border:0px;" width="70%" align="center"><h1 style="font-weight: 600;">
                        <?= $report ?>
                      </h1>
                      <h3>For the Month of:
                        <?= date('F-Y', mktime(1, 1, 1, $_POST['mon'], 1, $_POST['year'])) ?>
                      </h3>
                      <h1 style="padding-top: 10px;">
                        <?php if($cost_centre !=0){ ?>
                        <strong>Cost Centre:</strong>
                        <?=find_a_field('hrm_cost_center','center_name','id=' .$cost_centre);?>
                        ,
                        <? } ?>
                        <?php if($class_name!=0){ ?>
                        <strong>Class:</strong>
                        <?=find_a_field('hrm_class','class_name','id='.$class_name);?>
                        ,
                        <? } ?>
                        <?php if($location !=0){ ?>
                        <strong>Location:</strong>
                        <?=find_a_field('project','PROJECT_DESC','PROJECT_ID =' .$location);?>
                        <? } ?>
                      </h1></td>
                    <td style="border:0px;" width="10%"></td>
                  </tr>
                </tbody>
              </table></th>
          </tr>
          <tr>
            <th> <div align="center">SL </div></th>
            <th> <div align="center">Department </div></th>
            <th> <div align="center">Section </div></th>
            <th> <div align="center">ID Card No.</div></th>
            <th> <div align="left">Name</div></th>
            <th> <div align="center">Designation </div></th>
            <th> <div align="center"> Days </div></th>
            <th> <div align="center">Rate </div></th>
            <th> <div align="center">Total</div></th>
            <th> <div align="center">Signature</div></th>
          </tr>
        </thead>
        <tbody class="new-body">
          <?


                            if($_POST['PBI_CODE']!="") $codeConn = " and a.PBI_CODE='".$_POST['PBI_CODE']."'";
                            if($_POST['PBI_IDD']!="") $idConn = " and a.PBI_ID ='".$_POST['PBI_IDD']."'";
                          
                            if($_POST['PBI_NAME']!="") $NameConn = " and a.PBI_NAME='".$_POST['PBI_NAME']."'";
                            if($_POST['DESG_ID']>0) $desgConn = " and a.DESG_ID='".$_POST['DESG_ID']."'";
                            if($_POST['DEPT_ID']>0) $depConn = " and a.DEPT_ID='".$_POST['DEPT_ID']."'";
                            if($_POST['PBI_SEX']!="") $genderConn = " and a.PBI_SEX='".$_POST['PBI_SEX']."'";
                            if($_POST['grade']>0) $gradeConn = " and a.grade='".$_POST['grade']."'";  
                            if($_POST['work_station']>0) $work_station = " and a.PBI_WORK_STATION='".$_POST['work_station']."'";  
                            
                            
                            
                            if($_POST['PBI_RELIGION']!="") $ReligionConn = " and a.PBI_RELIGION='".$_POST['PBI_RELIGION']."'";
                            if($_POST['PBI_ORG']>0) $OrgConn = " and a.PBI_ORG='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and a.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
                            
                            if($_POST['section']>0) $secConn = " and a.section='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and a.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['cost_center']>0) $CostConn = " and a.cost_center='".$_POST['cost_center']."'";
                     
                            
                            if($_POST['class']>0) $classConn = " and a.class='".$_POST['class']."'";
                            if($_POST['line']>0) $lineConn = " and a.line='".$_POST['line']."'";
                            if($_POST['incharge_id']>0) $inchargeConn = " and a.incharge_id='".$_POST['incharge_id']."'";
							
                            if($_POST['DOJ']>0) $DOJConn = " and a.PBI_DOJ='".$_POST['DOJ']."'";
                            
						  	if($_POST['shedule']>0) $shiftConn = " and a.define_schedule ='".$_POST['shedule']."'";
						  	
						  	$user_id  =  $_SESSION['user']['id'];
                            if($user_id == 10073 || $user_id == 10074 || $user_id == 10108) $JOB_LOC_ID_BLOCK = " and a.JOB_LOC_ID !=3";
							$days=cal_days_in_month(CAL_GREGORIAN,$_POST['mon'],$_POST['year']);
							
							$joining_date_check = $_POST['year'].'-'.$_POST['mon'].'-'.$days;



 $sqll = "SELECT a.PBI_CODE as Emp_ID,a.PBI_NAME as Name,a.PBI_NAME as Name,a.PBI_ID,

(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,
(select sec_name from PBI_Section where sec_id = a.section) as Section,

 

a.PBI_DEPARTMENT as department,a.line as Line, a.PBI_DOJ as DOJ , 

b.td as Tot_days, b.pre as Present,b.od as Weekend ,b.hd as Holiday, b.lv as leave_day , b.ab AS Absent,
b.pay as Payble_days , b.lt as In_Late_days,b.eo as Early_Out_Days,
b.total_late_min as Total_Late_Min, b.ot as OT_Hour, b.lwp as LWP,b.holiday_present,b.day_off,b.full_day_iom, b.leave_punishment ,
 
b.leave_punishment as Leave_Punishment,b.working_hour as Working_Hour,a.resign_date

FROM personnel_basic_info a,hrm_attendence_final b 

where a.PBI_ID=b.PBI_ID and  a.PBI_DOJ <= '" .$joining_date_check. "' and b.pre>0  

and b.mon='" . $_POST['mon'] . "' and b.year='" . $_POST['year'] . "'" 
.$work_station.$OrgConn.$codeConn.$CostConn.$secConn.$idConn.$job_statusConn.$JOB_LOC_ID_BLOCK.$inchargeConn.$DOJConn.$shiftConn.$classConn.$JoblocConn.$depConn. $NameConn . "

order by b.PBI_ID";


        
               
             

            $queryd = db_query($sqll);
            while ($data = mysqli_fetch_object($queryd)) {
                
                
           
           	$sdate = $_POST['year'] . '-' . $_POST['mon'] . '-01';
			$edate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
			
  $total_ot_days = find_a_field('hrm_att_summary','count(id)','att_date between 
 "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" and basic_ot_for_all>=4  and emp_id='.$data->PBI_ID);

     

$amount = 0;


if ($_POST['class'] == 3) {
    $amount = 50;
} else {
    $amount = 100;
}

$total +=$total_ot_days*$amount;


if($total_ot_days >0){
       
            ?>
          <tr>
            <td style="height: 50px;"><?= ++$s ?></td>
            <td><?= $data->department; ?></td>
            <td><?= $data->Section; ?></td>
            <td><?= $data->Emp_ID; ?></td>
            <td><?= $data->Name; ?></td>
            <td><?= $data->designation; ?></td>
            <td><?=$total_ot_days;?></td>
            <td><?=$amount;?></td>
            <td><?=($total_ot_days*$amount);?></td>
            <td></td>
          </tr>
          <?  } }?>
          <tr>
            <td style="height: 50px;">&nbsp;</td>
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
            <td colspan="3" align="right" style="font-weight:bold;">Total:</td>
            <td align="right"><strong></strong></td>
            <td align="right"><strong></strong></td>
            <td align="right"><strong></strong></td>
            <td align="right"><strong></strong></td>
            <td align="right"><strong></strong></td>
            <td align="right"><strong>
              <?=number_format($total,2);?>
              </strong></td>
            <td style="height: 50px;" align="right"><strong></strong></td>
          </tr>
        </tbody>
      </table>
      <tr>
        <td class="all_table"></td>
      </tr>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <tr>
        <td class="all_table"></td>
      </tr>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <tr>
        <td colspan="4" class="all_table"><table width="100%" height="100px">
          <tr>
            <td width="20%" class="all_table"><div align="center">
                <p style="text-decoration: overline;"><strong> Prepared By </strong></p>
              </div></td>
            <td width="20%" class="all_table"><div align="center">
                <p style="text-decoration: overline;"><strong> Checked  By </strong></p>
              </div></td>
            <td width="20%" class="all_table"><div align="center">
                <p style="text-decoration: overline;"><strong> HR & Admin</strong></p>
              </div></td>
            <td width="20%" class="all_table"><div align="center">
                <p style="text-decoration: overline;"><strong>F. &amp; Accounts </strong></p>
              </div></td>
            <td width="20%" class="all_table"><div align="center">
                <p style="text-decoration: overline;"><strong> Approved By </strong></p>
              </div></td>
          </tr>
          <?
      }elseif($_POST['report']==9198)
			{
        $report = "	Mobile Bill Report";
        $company = $_POST['PBI_ORG'];
        $cost_centre = $_POST['cost_center'];
        $class_name = $_POST['class'];
        $location = $_POST['JOB_LOC_ID'];
      ?>
          <style>
	 body {
    @media print {
        margin-top: 1.3cm !important;
        margin-bottom: 1cm !important;
        
    }
}
.print-button {
        display: none;
    }


table {
    border-collapse: collapse;
    width: 100%;
}

#heading {
    text-align: center;
    font-size: 14px;
    height: 70px;
    background-color: #f2f2f2;
    border-bottom: 1px solid black;
    margin-bottom: 20px;
    line-height: 1.7; 
}

.info_table {
    margin-top: 20px;
}

.info_table tr {
    height: 30px;
    border-bottom: 1px solid black;
}

.all_table {
    border: none !important;
}

@media print {
    body {
        zoom: 80%;
    }

    /* Ensure background colors are printed */
    table, th, td {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}

		 
        </style>
          <table width="100%" cellspacing="0" cellpadding="2" border="1" id="ExportTable">
            <thead>
              <tr>
                <th colspan="18" style=" border: none; "> <table width="100%" cellspacing="0" cellpadding="2" border="0">
                    <tbody>
                      <tr>
                        <td style="border:0px;" width="10%" align="left"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['proj_id'] ?>.png" width="100%"></td>
                        <td style="border:0px;" width="70%" align="center"><h1 style="font-weight: 600;">
                            <?= $report ?>
                          </h1>
                          <h3>For the Month of:
                            <?= date('F-Y', mktime(1, 1, 1, $_POST['mon'], 1, $_POST['year'])) ?>
                          </h3>
                          <h1 style="padding-top: 10px;">
                            <?php if($cost_centre !=0){ ?>
                            <strong>Cost Centre:</strong>
                            <?=find_a_field('hrm_cost_center','center_name','id=' .$cost_centre);?>
                            ,
                            <? } ?>
                            <?php if($class_name!=0){ ?>
                            <strong>Class:</strong>
                            <?=find_a_field('hrm_class','class_name','id='.$class_name);?>
                            ,
                            <? } ?>
                            <?php if($location !=0){ ?>
                            <strong>Location:</strong>
                            <?=find_a_field('project','PROJECT_DESC','PROJECT_ID =' .$location);?>
                            <? } ?>
                          </h1></td>
                        <td style="border:0px;" width="10%"></td>
                      </tr>
                    </tbody>
                  </table></th>
              </tr>
              <tr>
                <th> <div align="center">SL </div></th>
                <th> <div align="center">ID </div></th>
                <th> <div align="left"> Employee Name</div></th>
                <th> <div align="center">Designation </div></th>
                <th> <div align="center">Join Date </div></th>
                <th> <div align="center">Department </div></th>
                <th> <div align="center">Section </div></th>
                <th> <div align="center"> Mobile No </div></th>
                <th> <div align="center">Amount </div></th>
              </tr>
            </thead>
            <tbody class="new-body">
              <?


                            if($_POST['PBI_CODE']!="") $codeConn = " and a.PBI_CODE='".$_POST['PBI_CODE']."'";
                            if($_POST['PBI_IDD']!="") $idConn = " and a.PBI_ID ='".$_POST['PBI_IDD']."'";
                          
                            if($_POST['PBI_NAME']!="") $NameConn = " and a.PBI_NAME='".$_POST['PBI_NAME']."'";
                            if($_POST['DESG_ID']>0) $desgConn = " and a.DESG_ID='".$_POST['DESG_ID']."'";
                            if($_POST['DEPT_ID']>0) $depConn = " and a.DEPT_ID='".$_POST['DEPT_ID']."'";
                            if($_POST['PBI_SEX']!="") $genderConn = " and a.PBI_SEX='".$_POST['PBI_SEX']."'";
                            if($_POST['grade']>0) $gradeConn = " and a.grade='".$_POST['grade']."'";  
                            if($_POST['work_station']>0) $work_station = " and a.PBI_WORK_STATION='".$_POST['work_station']."'";  
                            
                            
                            
                            if($_POST['PBI_RELIGION']!="") $ReligionConn = " and a.PBI_RELIGION='".$_POST['PBI_RELIGION']."'";
                            if($_POST['PBI_ORG']>0) $OrgConn = " and a.PBI_ORG='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and a.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
                            
                            if($_POST['section']>0) $secConn = " and a.section='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and a.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['cost_center']>0) $CostConn = " and a.cost_center='".$_POST['cost_center']."'";
                     
                            
                            if($_POST['class']>0) $classConn = " and a.class='".$_POST['class']."'";
                            if($_POST['line']>0) $lineConn = " and a.line='".$_POST['line']."'";
                            if($_POST['incharge_id']>0) $inchargeConn = " and a.incharge_id='".$_POST['incharge_id']."'";
							
                            if($_POST['DOJ']>0) $DOJConn = " and a.PBI_DOJ='".$_POST['DOJ']."'";
                            
						  	if($_POST['shedule']>0) $shiftConn = " and a.define_schedule ='".$_POST['shedule']."'";
						  	
						  	$user_id  =  $_SESSION['user']['id'];
                            if($user_id == 10073 || $user_id == 10074 || $user_id == 10108) $JOB_LOC_ID_BLOCK = " and a.JOB_LOC_ID !=3";
							$days=cal_days_in_month(CAL_GREGORIAN,$_POST['mon'],$_POST['year']);
							
							$joining_date_check = $_POST['year'].'-'.$_POST['mon'].'-'.$days;



  $sqll = "SELECT a.PBI_CODE as Emp_ID,a.PBI_NAME as Name,a.PBI_NAME as Name,a.PBI_ID, a.PBI_PHONE as Phone,

(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,
(select sec_name from PBI_Section where sec_id = a.section) as Section,

 

a.PBI_DEPARTMENT as department,a.line as Line, a.PBI_DOJ as DOJ , 

b.td as Tot_days, b.pre as Present,b.od as Weekend ,b.hd as Holiday, b.lv as leave_day , b.ab AS Absent, c.mobile_allowance,
b.pay as Payble_days , b.lt as In_Late_days,b.eo as Early_Out_Days,
b.total_late_min as Total_Late_Min, b.ot as OT_Hour, b.lwp as LWP,b.holiday_present,b.day_off,b.full_day_iom, b.leave_punishment ,
 
b.leave_punishment as Leave_Punishment,b.working_hour as Working_Hour,a.resign_date

FROM   personnel_basic_info a,hrm_attendence_final b ,  salary_info c

where a.PBI_ID=b.PBI_ID and a.PBI_ID=c.PBI_ID and a.PBI_DOJ <= '" .$joining_date_check. "' and b.pre>0  

and  b.mon='" . $_POST['mon'] . "' and b.year='" . $_POST['year'] . "'" 
.$work_station.$OrgConn.$codeConn.$CostConn.$secConn.$idConn.$job_statusConn.$JOB_LOC_ID_BLOCK.$inchargeConn.$DOJConn.$shiftConn.$classConn.$JoblocConn.$depConn. $NameConn . "

order by b.PBI_ID" ;

        
               
             

            $queryd = db_query($sqll);
            while ($data = mysqli_fetch_object($queryd)) {
                
                
           
           	$sdate = $_POST['year'] . '-' . $_POST['mon'] . '-01';
			$edate = $_POST['year'] . '-' . $_POST['mon'] . '-31';
			


          $total +=$data->mobile_allowance;
     





       
            ?>
              <tr>
                <td style="height: 50px;"><?= ++$s ?></td>
                <td><?= $data->Emp_ID; ?></td>
                <td><?= $data->Name; ?></td>
                <td><?= $data->designation; ?></td>
                <td><?= $data->DOJ; ?></td>
                <td><?= $data->department; ?></td>
                <td><?= $data->Section; ?></td>
                <td><?= $data->Phone; ?></td>
                <td><?= $data->mobile_allowance; ?></td>
              </tr>
              <?  } ?>
              <tr>
                <td style="height: 50px;">&nbsp;</td>
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
                <td colspan="8" align="right" style="font-weight:bold;">Total:</td>
                <td align="right"><strong>
                  <?=number_format($total,2);?>
                  </strong></td>
              </tr>
            </tbody>
          </table>
          <tr>
            <td class="all_table"></td>
          </tr>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <tr>
            <td class="all_table"></td>
          </tr>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <tr>
            <td colspan="4" class="all_table"><table width="100%" height="100px">
              <tr>
                <td width="20%" class="all_table"><div align="center">
                    <p style="text-decoration: overline;"><strong> Prepared By </strong></p>
                  </div></td>
                <td width="20%" class="all_table"><div align="center">
                    <p style="text-decoration: overline;"><strong> Checked  By </strong></p>
                  </div></td>
                <td width="20%" class="all_table"><div align="center">
                    <p style="text-decoration: overline;"><strong> HR & Admin</strong></p>
                  </div></td>
                <td width="20%" class="all_table"><div align="center">
                    <p style="text-decoration: overline;"><strong>F. &amp; Accounts </strong></p>
                  </div></td>
                <td width="20%" class="all_table"><div align="center">
                    <p style="text-decoration: overline;"><strong> Approved By </strong></p>
                  </div></td>
              </tr>
              <?
      }













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
              </div>
              </div>
</form>
</body>
</html>
