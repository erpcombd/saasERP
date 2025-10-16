<?
session_start();

require "../../config/inc.all.php";
require "../../classes/report.class.php";
date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if($_POST['name']!='')
	$con.=' and a.PBI_NAME like "%'.$_POST['name'].'%"';
	if($_POST['PBI_ORG']!='')
	$con.=' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';
	if($_POST['department']!='')
	$con.=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';
	if($_POST['project']!='')
	$con.=' and a.PBI_PROJECT = "'.$_POST['project'].'"';
	if($_POST['designation']!='')
	$con.=' and a.PBI_DESIGNATION = "'.$_POST['designation'].'"';
	if($_POST['zone']!='')
	$con.=' and a.PBI_ZONE = "'.$_POST['zone'].'"';
	
	if($_POST['JOB_LOCATION']!='')
	$con.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';
	
	if($_POST['PBI_GROUP']!='')
	$con.=' and a.PBI_GROUP = "'.$_POST['PBI_GROUP'].'"';
	
	if($_POST['area']!='')
	$con.=' and a.PBI_AREA = "'.$_POST['area'].'"';
	if($_POST['branch']!='')
	$con.=' and a.PBI_BRANCH = "'.$_POST['branch'].'"';

	
	if($_POST['job_status']!='')
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
	
switch ($_POST['report']) {
    case 1:
	$report="Employee Basic Information";

        $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,a.PBI_GROUP as `Group`,a.PBI_DOJ as joining_date,(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_MOBILE as mobile  from personnel_basic_info a where	1 ".$con;
break;
		    case 10001:
	$report="Employee Details Information";

        $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,a.PBI_GROUP as `Group`,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,(select group_name from user_group where id=a.PBI_ORG) as Company ,(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_EDU_QUALIFICATION as qualification,a.PBI_MOBILE as mobile,PBI_JOB_STATUS job_status,JOB_LOCATION from personnel_basic_info a where	1 ".$con;
break;
		    case 2:
	$report="Employee Salary & Benefits Information";

       $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation, 
		a.PBI_DEPARTMENT as department,b.consolidated_salary,b.basic_salary,b.special_allowance,b.ta tada,fixed_commission,b.mobile_allowance,
		vehicle_allowance, if( CURDATE()> security_amnt_till_date ,security_amount,'0.00') security_amount, (b.consolidated_salary+b.basic_salary+b.special_allowance+vehicle_allowance+fixed_commission+b.ta) as total_salary from personnel_basic_info a,salary_info b where	a.PBI_ID=b.PBI_ID ".$con." order by (b.consolidated_salary+b.basic_salary) desc";
break;
    case 3:
	$report="Monthly Attendence Report";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department, b.td as total_day,b.od as off_day,b.hd as holy_day, 	b.lt as late_days, 	b.ab as absent_days,b.lv as leave_days,b.pre as present_days, 	b.pay as payable_days,b.ot as over_time_hour FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
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

		
	

case 77:
	$report="Salary Payroll Report Final (Field)";
	break;
case 78:
	$report="Salary Payroll Report Final (Head Office)";
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
         $sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_SEX as Gender,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.PBI_PROJECT as project	,a.PBI_DESIGNATION as designation ,a.PBI_DESG_GRADE as grade,a.PBI_ZONE as zone,a.PBI_AREA as area,a.PBI_BRANCH as branch,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,b.APR_YEAR,b.APR_MARKS,(select avg(APR_MARKS) from apr_detail where APR_YEAR in (".$year.",".($year-1).",".($year-2).") and PBI_ID=a.PBI_ID) as avg_marks,b.APR_STATUS,b.APR_RESULT  from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID ".$con;
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

if($_POST['f_date']!='' && $_POST['t_date']!='')
$con.=' and a.app_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';

$sql="select a.dealer_code as code,
a.account_code as ledger_code,a.dealer_name_e as dealer_name,
(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,
a.product_group as GRP,r.BRANCH_NAME as region,z.ZONE_NAME as zone,b.AREA_NAME as area,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no,
a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,area b,zon z,branch r,warehouse w 

where z.region_id =r.BRANCH_ID and b.ZONE_ID =z.ZONE_CODE and a.dealer_type='Distributor' and a.area_code = b.AREA_CODE 
and w.warehouse_id=a.depot ".$con." 
order by code desc";

break;

case 1006:
$report="Closed Dealer Information";
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



if($_POST['depot']!='')
$con.=' and a.depot = "'.$_POST['depot'].'"';

if($_POST['product_group']!='')
$con.=' and a.product_group = "'.$_POST['product_group'].'"';
if($_POST['mobile_no']!='')
$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';

if($_POST['f_date']!='' && $_POST['t_date']!='')
$con.=' and a.cancel_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';

$sql="select a.cancel_date as closed_date,a.app_date,a.dealer_code as code,a.dealer_name_e as dealer_name,
a.product_group as GRP,r.BRANCH_NAME as region,z.ZONE_NAME as zone,b.AREA_NAME as area,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no,a.canceled as active,w.warehouse_name as depot 

from dealer_info a,area b,zon z,branch r,warehouse w 
where z.region_id =r.BRANCH_ID and b.ZONE_ID =z.ZONE_CODE and a.dealer_type='Distributor' and a.area_code = b.AREA_CODE 
and w.warehouse_id=a.depot ".$con." 
order by closed_date desc";

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


		 
$sql="select a.dealer_code as code,concat('C-',a.account_code) as ledger_code,master_id as join_id,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,warehouse w where a.dealer_type='SuperShop' and w.warehouse_id=a.depot ".$con." 
order by a.dealer_code desc";
		
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
		
		
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />
<style type="text/css">
.vertical-text {
	transform: rotate(270deg);
	transform-origin: left top 1;
	float:left;
	padding:1px;
	font-size:10px;
	font-family:Arial, Helvetica, sans-serif;
}
.style1 {color: #FF0000}
</style>
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
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
<form action="" method="post">
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">
<?
		//echo $sql;
		$str 	.= '<div class="header">';
		if($_POST['PBI_ORG']!='') 
		$str 	.= '<h2 style="font-size:24px;">'.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if($_POST['mon']!='') 
		$str 	.= '<h2>Report of Month: '.date('F-Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year'])).'</h2>';
		if($_POST['department']!='') 
		$str 	.= '<h2>Department Name: '.find_a_field('department','DEPT_DESC','DEPT_SHORT_NAME="'.$_POST['department'].'"').'</h2>';
		$str 	.= '</div>';
		if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		
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
		$str 	.= '</div><div class="right">';
		if(isset($client_name)) 
		$str 	.= '<p>Client Name: '.$client_name.'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
	
if($_POST['report']==7) 
{
$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department from 
personnel_basic_info a where 1 ".$con;
$query = db_query($sql);
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>
<tr><th>S/L</th>
<th>CODE</th>
<th>Name</th>
<th>Desg</th>
<th>Dept</th>
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
<tr><td><?=$s?></td><td><?=$datas[0]?></td><td><?=$datas[1]?></td>
  <td><?=$datas[2]?></td>
  <td><?=$datas[3]?></td><td><?=$data->salary_type?></td><td><?=$data->basic_salary?></td><td><?=$data->consolidated_salary?></td>
  <td style="text-align:right"><?=$data->special_allowance ?></td>
  <td style="text-align:right"><?=$data->house_rent?></td><td><?=$data->ta?></td>
  <td><?=$data->food_allowance?></td>
  <td><?=$data->medical_allowance?>&nbsp;</td>
  <td><?=$data->cash_bank?>&nbsp;</td>
  <td><?=$data->cash?></td>
  <td><?=$data->branch_info?></td><td><?=$data->security_amount?></td></tr>
<?
}
?></tbody></table>
<?
}

if($_POST['report']==77) 
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

elseif($_POST['report']==10001)
{
		$report="Monthly Target Report (Percentage)";
		$region_id = $_POST['region_code'];
		$month = $_POST['mon'];
		$year = $_POST['year'];
		?>
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <thead>
    <tr>
      <td colspan="5" style="border:0px;"><?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'-'.$_POST['sales_item_type'].'</h2>';

if(isset($t_date)) 
		echo '<h2>Reporting Date : '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("H:i A d-m-Y").'</div>';
		
		
$ic = 0;
		if($_POST['product_group']!='')
		$dg = ' and i.sales_item_type like "'.$_POST['product_group'].'"';
		$sql="select * from item_info i where  i.finish_goods_code>0 ".$dg." order by i.item_id";
		$res	 = db_query($sql);
		$rows = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{
		$item_code[$ic] = $row->item_id;
		$item_name[$ic] = $row->item_name;
		$sales_item_type[$ic] = $row->sales_item_type;
		$pack_size[$ic] = $row->pack_size;
		$finish_goods_code[$ic] = $row->finish_goods_code;
		$d_price[$ic] = $row->d_price;
				$ic++;
		}
		$sql="select s.target,s.target_assign,s.level_id,s.item_id from sale_target_assign s,zon z where s.level=12 and s.parent_id=z.ZONE_CODE AND z.REGION_ID=".$region_id." and `target_year`='".$year."' and grp='".$_POST['product_group']."' and `target_month` = '".$month."' ";
		$res	 = db_query($sql);
		$chalan = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{$tg_per[$row->level_id][$row->item_id] = $row->target; 
		 $tg_ass[$row->level_id][$row->item_id] = $row->target_assign; }
		

		


		?>      </td>
    </tr>
    <tr>
      <th rowspan="2">S/L</th>
      <th rowspan="2">Dealer Name </th>
      <th rowspan="2">Area</th>
      <? if($ic>0){?><th colspan="<?=$ic?>"><div align="center">Item List</div></th><? }?>
      <th bgcolor="#99CC99" style="text-align:center">Total</th>
      <th bgcolor="#99CC99" style="text-align:center">ALL-TOTAL</th>
    </tr>
    <tr style="text-align:right">
      <? for($j=0;$j<$ic;$j++){?>
      <th height="300" bgcolor="#339999"><font class="vertical-text" style="margin-top:250px; width:5px; vertical-align:bottom"><nobr><?=$item_name[$j]?> - <?=$finish_goods_code[$j]?></nobr></font></th>
      <? }?>
      <th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
      <th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
    </tr>
  </thead>
  <tbody>
    <?
		 $sql="select d.*,a.*,z.* from dealer_info d, area a, zon z where d.product_group='".$_POST['product_group']."' and d.dealer_type='Distributor' and d.area_code =a.AREA_CODE and a.ZONE_ID=z.ZONE_CODE and z.REGION_ID='".$region_id."'  order by z.REGION_ID,z.ZONE_CODE,a.AREA_CODE ";
		$res	 = db_query($sql);
		$rows = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{

if($row->ZONE_CODE!=$old_zone){$sl = 0;
	?>
	
<tr>
<td colspan="<?=$ic+6?>" bgcolor="#FFFFCC">Zone Name : <?=$row->ZONE_NAME?></td>
</tr>
<? }?>
    <tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
      <td><?=++$sl;?></td>
      <td><?=$row->dealer_code?>-<?=$row->dealer_name_e?></td>
      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;"><?=$row->AREA_NAME?></td>
      <? for($j=0;$j<$ic;$j++){?>
      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;"><?=$tg_per[$row->dealer_code][$item_code[$j]]?></td>
      <? }?>
      <td><? ?></td>
      <td><? ?></td>
    </tr>
    <? 
	$old_zone = $row->ZONE_CODE;
	
	}?>
  </tbody>
</table>
<?
}



elseif($_POST['report']==10002)
{
		$report="Monthly Target Report (CTN)";
		$region_id = $_POST['region_code'];
		$month = $_POST['mon'];
		$year = $_POST['year'];
		$item_brand = $_POST['item_brand'];

if($_POST['item_brand']!='') $item_brand_con = ' and i.item_brand = "'.$_POST['item_brand'].'"';
		?>
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <thead>
    <tr>
      <td colspan="5" style="border:0px;"><?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
echo '<h2>'.$report.'-Group: '.$_POST['product_group'].' Region: -'.find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$_POST['region_code']).'</h2>';

if(isset($t_date)) 
		echo '<h2>Reporting Date : '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("H:i A d-m-Y").'</div>';
		
		
$ic = 0;
		if($_POST['product_group']!='')
		$dg = ' and i.sales_item_type like "'.$_POST['product_group'].'"';
		$sql="select * from item_info i where  i.finish_goods_code>0 ".$dg.$item_brand_con." 
		and i.finish_goods_code not between 5000 and 6000 and i.finish_goods_code not between 2000 and 2010
		order by i.item_id";
		$res	 = db_query($sql);
		$rows = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{
		$item_code[$ic] = $row->item_id;
		$item_name[$ic] = $row->item_name_short;
		$sales_item_type[$ic] = $row->sales_item_type;
		$pack_size[$ic] = $row->pack_size;
		$finish_goods_code[$ic] = $row->finish_goods_code;
		$d_price[$ic] = $row->d_price;
				$ic++;
		}
		$sql="select s.target,s.target_assign,s.level_id,s.item_id from sale_target_assign s,zon z where s.level=12 and s.parent_id=z.ZONE_CODE AND z.REGION_ID=".$region_id." and `target_year`='".$year."' and grp='".$_POST['product_group']."' and `target_month` = '".$month."' ";
		$res	 = db_query($sql);
		$chalan = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{$tg_per[$row->level_id][$row->item_id] = $row->target; 
		 $tg_ass[$row->level_id][$row->item_id] = $row->target_assign; }
		

		


		?>      </td>
    </tr>
    <tr>
      <th rowspan="2">S/L</th>
      <th rowspan="2">Dealer Name </th>
      <th rowspan="2">Area</th>
      <? if($ic>0){?><th colspan="<?=$ic?>"><div align="center">Item List</div></th><? }?>
      <th bgcolor="#99CC99" style="text-align:center">Total</th>
      <th bgcolor="#99CC99" style="text-align:center">ALL-TOTAL</th>
    </tr>
    <tr style="text-align:right">
      <? for($j=0;$j<$ic;$j++){?>
      <th height="150" bgcolor="#339999"><font class="vertical-text" style="margin-top:170px; width:5px; vertical-align:bottom"><nobr><?=$finish_goods_code[$j]?> - <?=$item_name[$j]?></nobr></font></th>
      <? }?>
      <th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
      <th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
    </tr>
  </thead>
  <tbody>
    <?
		 $sql="select d.*,a.*,z.* from dealer_info d, area a, zon z where d.product_group='".$_POST['product_group']."' and d.canceled='Yes' and d.dealer_type='Distributor' and d.area_code =a.AREA_CODE and a.ZONE_ID=z.ZONE_CODE and z.REGION_ID='".$region_id."'  order by z.REGION_ID,z.ZONE_CODE,a.AREA_CODE ";
		$res	 = db_query($sql);
		$rows = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{


if($row->ZONE_CODE!=$old_zone){$sl = 0;
	?>
<?
if($old_zone>0){
?>
    <tr bgcolor="#CCFFFF" <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
      <td colspan="3">Sub Total of Zone </td>
      <? for($j=0;$j<$ic;$j++){
	  $tg_i_grand_total[$item_code[$j]] = $tg_i_grand_total[$item_code[$j]] + $tg_i_total[$item_code[$j]];?>
      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;"><?=$tg_i_total[$item_code[$j]]?></td>
      <? $tg_i_total[$item_code[$j]] = 0; }?>
      <td>&nbsp;</td>
      <td><?=$tg_d_grand_total; $tg_d_grand_total=0;?></td>
    </tr>
<? }
?>
<tr>
<td colspan="<?=$ic+6?>" bgcolor="#FFFFCC">Zone Name : <?=$row->ZONE_NAME?></td>
</tr>
<? }?>

    <tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
      <td><?=++$sl;?></td>
      <td><?=$row->dealer_code?>-<?=$row->dealer_name_e?></td>
      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;"><?=$row->AREA_NAME?></td>
      <? for($j=0;$j<$ic;$j++){
	  
	  $tg_i_total[$item_code[$j]] = $tg_i_total[$item_code[$j]] + $tg_ass[$row->dealer_code][$item_code[$j]];
	  $tg_d_total[$row->dealer_code] = $tg_d_total[$row->dealer_code] + $tg_ass[$row->dealer_code][$item_code[$j]];
	  ?>
      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;"><?=$tg_ass[$row->dealer_code][$item_code[$j]]?></td>
      <? }?>
      <td><? ?></td>
      <td><? echo $tg_d_total[$row->dealer_code]; $tg_d_grand_total = $tg_d_grand_total + $tg_d_total[$row->dealer_code]; $tg_d_total[$row->dealer_code] = 0;?></td>
    </tr>
    <? 
	$old_zone = $row->ZONE_CODE;
	
	}?>
	
	    <tr bgcolor="#CCFFFF" <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
      <td colspan="3">Sub Total of Zone </td>
      <? for($j=0;$j<$ic;$j++){
	   $tg_i_grand_total[$item_code[$j]] = $tg_i_grand_total[$item_code[$j]] + $tg_i_total[$item_code[$j]];
	  ?>
      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;"><?=$tg_i_total[$item_code[$j]]?></td>
      <? }?>
      <td>&nbsp;</td>
      <td><?=$tg_d_grand_total; $tg_d_grand_total=0;?></td>
    </tr>
	    <tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
	      <td colspan="3">&nbsp;</td>
	      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;">&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
        </tr>
	    <tr bgcolor="#FFCCFF" <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
      <td colspan="3">Grand Total of Region </td>
      <? for($j=0;$j<$ic;$j++){
	  $tg_d_grand_totals = $tg_d_grand_totals + $tg_i_grand_total[$item_code[$j]];?>
      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;"><?=$tg_i_grand_total[$item_code[$j]]?></td>
      <? }?>
      <td>&nbsp;</td>
      <td><?=$tg_d_grand_totals;?></td>
    </tr>
  </tbody>
</table>
<?
}
elseif($_POST['report']==78) 
{

?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="22"><?=$str?></td></tr>
<tr><th rowspan="2">S/L 78</th>
<th rowspan="2">CODE</th>
<th rowspan="2">Name</th>
<th rowspan="2">Desg</th>
<th rowspan="2">Joining Date </th>
<th rowspan="2">Bank Account No  </th>
<th colspan="8" align="center">Monthly Attendence Record </th>
<th colspan="8">Salary and Allowance (TK) </th>
<th colspan="9" align="center">Deduction</th>
<th rowspan="2">Cash Payment </th>
<th rowspan="2">Bank Payment </th>
<th rowspan="2">Net Payable Current Month </th>
<th rowspan="2">Last Month's Net Pay </th>
<th rowspan="2">Changeswith Current Month </th>
<th rowspan="2">Signature</th>
</tr>
<tr>
  <th>Present</th>
  <th>Weekend </th>
  <th>Festival Holiday </th>
  <th>Leave</th>
  <th>Late</th>
  <th>LWP</th>
  <th>Absent</th>
  <th>Payable Days </th>
  <th>Salary </th>
  <th>Spl. Allow. </th>
  <th>House Rent </th>
  <th>Vehicle and Transport Allow. </th>
  <th>Mobile Allow. </th>
  <th>Arrear Salary </th>
  <th>Bonus</th>
  <th>Other</th>
  <th>for AIT</th>
  <th>Advace Salary </th>
  <th>Co-Op. Fund </th>
  <th>Motorcycle Ins. </th>
  <th>Excess Mobile Bill </th>
  <th>For Late Attendence </th>
  <th>For Absentence and LWP </th>
  <th>Administrative</th>
  <th>Total Deduction </th>
  </tr>
</thead>
<tbody>
<?
$sqld = 'select s.basic_salary actual_basic_salary, s.*, t.*,a.PBI_ID,a.PBI_NAME,a.PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ from salary_info s, salary_attendence t, personnel_basic_info a where t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and s.PBI_ID=t.PBI_ID and t.PBI_ID=a.PBI_ID '.$con.' order by (s.consolidated_salary+s.basic_salary) desc';
$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
<td><?=$data->PBI_ID?></td>
<td><?=$data->PBI_NAME?></td>
  <td><?=$data->PBI_DESIGNATION?></td>
  <td><?=$data->PBI_DOJ?></td>
  <td><?=$data->cash?></td>
  <td><?=$data->pre?></td>
  <td><?=$data->od?></td>
  <td><?=$data->hd?></td>
  <td><?=$data->lv?></td>
  <td>&nbsp;</td>
  <td><?=$data->lwp?></td>
  <td><?=$data->ab?></td>
  <td><?=$data->pay?></td>
  <td><?=$data->actual_basic_salary?></td>
  <td><?=$data->special_allowance?></td>
  <td><span style="text-align:right">
    <?=$data->house_rent?>
  </span></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><?=$data->benefits?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><?=($data->advance_install+$data->other_install)?></td>
  <td><?=$data->cooperative_share?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><? echo $data->total_payable; $total_cash = $total_cash + $data->total_payable;?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="27">&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><?=$total_cash?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
<?
}

elseif($_POST['report']==1007) {

$report="Location Map";
$gp = $_POST['product_group'];

$sql="select br.BRANCH_NAME as region,z.ZONE_NAME as zone,b.AREA_NAME as area, b.AREA_CODE as area_code
from area b,zon z,branch br
where b.ZONE_ID =z.ZONE_CODE 
and z.REGION_ID= br.BRANCH_ID
order by region,zone,area";

$query = db_query($sql);
?>
<h1><center><?=$report?>. Group <?=$gp?></center></h1>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr><th>S/L-99</th>
<th>Region</th>
<th>Zone</th>
<th>Area</th>
<th>Area Code </th>
<th>Dealer</th>
<th>SO</th>
</tr></thead>
<tbody>
<?
while($data=mysqli_fetch_object($query)){
$s++;
?>
<tr><td><?=$s?></td>
<td><?=$data->region?></td>
<td><?=$data->zone?></td>
<td><?=$data->area?></td>
<td><?=$data->area_code?></td>
<td>
<? $find_dealer = 'select dealer_code,dealer_name_e as dealer_name from dealer_info where canceled="Yes" and product_group="'.$gp.'" and area_code="'.$data->area_code.'" ';
$query1 = db_query($find_dealer);
while($fd=mysqli_fetch_object($query1)){ ?>
<?=$fd->dealer_code;?>-<?=$fd->dealer_name;?>,<br>
<? } ?></td>
<td>
<? $find_so = 'select PBI_ID,PBI_NAME from personnel_basic_info where PBI_JOB_STATUS="In Service" and PBI_GROUP="'.$gp.'" and PBI_AREA="'.$data->area_code.'" ';
$query2 = db_query($find_so);
while($fs=mysqli_fetch_object($query2)){ ?>
<?=$fs->PBI_ID;?>-<?=$fs->PBI_NAME;?>,<br>
<? } ?></td>
</tr>
<?
}
?></tbody></table>
<?
}



elseif($_POST['report']==8) 
{


        echo $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,a.PBI_GROUP as `Group`,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_EDU_QUALIFICATION as qualification,a.PBI_MOBILE as mobile  from personnel_basic_info a where	1 ".$con;
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
<th>PP_join_date</th>
<th>Area</th>
<th>Zone</th>
<th>Region</th>
<th>Qualification</th>
<th>Mobile No </th>
<th>Submit</th>
</tr></thead>
<tbody>
<?
$ajax_page = "rd_issue_ajax.php";
while($datas=mysqli_fetch_row($query)){$s++;
?>
<tr><td><?=$s?></td>
<td><?=$datas[0]?></td>
<td><?=$datas[1]?></td>
  <td><?=$datas[2]?></td>
  <td><?=$datas[3]?></td>
  <td><?=$datas[4]?></td>
  <td><?=$datas[5]?></td>
  <td><?=$datas[6]?></td>
  <td style="text-align:right"><?=$datas[7]?></td>
  <td style="text-align:right"><?=$datas[8]?></td>
  <td><?=$datas[9]?></td>
  <td><?=$datas[10]?></td>
  <td><input type="hidden" name="PBI_ID#<?=$datas[0]?>" id="PBI_ID#<?=$datas[0]?>" value="<?=$datas[0]?>" />
      <input name="mobile#<?=$datas[0]?>" type="text" id="mobile#<?=$datas[0]?>" value="<?=$datas[11]?>" />  </td>
  <td><div id="po<?=$datas[0]?>"><input type="button" name="Change" value="Change" onclick="getData2('<?=$ajax_page?>', 'po<?=$datas[0]?>',document.getElementById('PBI_ID#<?=$datas[0]?>').value,document.getElementById('mobile#<?=$datas[0]?>').value);" /></div></td>
  </tr>
<?
}
?></tbody></table>
<?
}
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?>
<style type="text/css">

#new td {
    border-bottom: 0px solid #000000;
    border-left: 0px solid #000000;
    border-right: 0px solid #000000;
	text-align:center;
    padding: 2px 10px;
}
</style><br /><br /><br /><br />
<!--<table width="100%" border="0" style="padding:0;" id="new">
  
  <tr>
    <td>Prepared By</td>
    <td>Checked By</td>
    <td>Audited By</td>
    <td>Forwarded By</td>
    <td>Approved by</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>...............................</td>
    <td>...............................</td>
    <td>...............................</td>
    <td>...............................</td>
    <td>...............................</td>
    </tr>
  <tr>
    <td><?= find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>
    <td>AGM Accounts</td>
    <td>AM-Internal Audit</td>
    <td>GM-HRM</td>
    <td>Board of Director</td>
    </tr>
</table>-->


</div>
</form>
</body>
</html>