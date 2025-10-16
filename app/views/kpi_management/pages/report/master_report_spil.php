<?
session_start();

require "../../config/inc.all.php";
require "../../classes/report.class.php";
date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if($_POST['name']!='')
	$con.=' and a.PBI_NAME like "%'.$_POST['name'].'%"';
	if($_POST['employee_selected']!='')
	$con.=' and a.PBI_ID like "%'.$_POST['employee_selected'].'%"';
	if($_POST['domain']!='')
	$con.=' and a.PBI_DOMAIN = "'.$_POST['domain'].'"';
	if($_POST['department']!='')
	$con.=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';
	if($_POST['project']!='')
	$con.=' and a.PBI_PROJECT = "'.$_POST['project'].'"';
	if($_POST['designation']!='')
	$con.=' and a.PBI_DESIGNATION = "'.$_POST['designation'].'"';
	if($_POST['zone']!='')
	$con.=' and a.PBI_ZONE = "'.$_POST['zone'].'"';
	
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

        $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name, c.DESG_DESC as designation ,d.DEPT_DESC as department, a.PBI_GROUP as `Group`,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,a.PBI_EDU_QUALIFICATION as qualification,a.PBI_MOBILE as mobile  from personnel_basic_info a, designation c, department d  where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID".$con;
break;
		
	case 2:
	$report="Employee Salary Information";

        $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,c.DESG_DESC as designation ,d.DEPT_DESC as department, b.basic_salary,b.house_rent,b.medical_allowance,b.others other_allowance,b.special_allowance,b. consolidated_salary as total_salary from personnel_basic_info a,salary_info b, designation c, department d where a.PBI_ID=b.PBI_ID and a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID".$con;
break;
    case 3:
	$report="Monthly Attendence Report";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,c.DESG_DESC as designation, d.DEPT_DESC as department, b.td as total_day,b.od as off_day,b.hd as holy_day, 	(b.lt*1.00) as late_days, 	(b.ab*1.00) as absent_days,(b.lv*1.00) as leave_days,b.pre as present_days, 	b.pay as payable_days,(b.ot*1.00) as over_time_hour FROM personnel_basic_info a, salary_attendence b, designation c, department d where a.PBI_ID=b.PBI_ID and a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;
    case 4:
		$report="Over Time Report";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,c.DESG_DESC as designation, d.DEPT_DESC as department, b.ot as over_time_hour,(b.total_salary/208) as rate,b.over_time_amount FROM personnel_basic_info a,salary_attendence b, designation c, department d where b.ot>0 and a.PBI_ID=b.PBI_ID and a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;
	    case 5:
		$report="Salary Payroll Report (Detail)";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,c.DESG_DESC as designation ,d.DEPT_DESC as department,
	b.basic_salary,b.house_rent,b.medical_allowance,b.other_allowance,b.special_allowance,b.mobile_allowance,b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction,b.total_benefits,b.total_payable FROM personnel_basic_info a,salary_attendence b, designation c, department d where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DEPARTMENT,b.total_salary desc";
}
		break;
	
    case 6:
	$report="Salary Payroll Report (Summary)";
	if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name, c.DESG_DESC as designation , d.DEPT_DESC as department,
	b.total_salary as gross_salary,b.mobile_allowance,b.over_time_amount as overtime, b.bonus_amt bonus, b.benefits other_benefits, b.absent_deduction,
	(b.total_salary + b.mobile_allowance + b.over_time_amount + b.bonus_amt + b.benefits  - b.absent_deduction) as total_payable,
	b.advance_install as advance_deduction, b.deduction as food_deduction, b.total_payable as net_payable FROM personnel_basic_info a,salary_attendence b, designation c, department d where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_ID asc";
}	break;
	case 7:
	$report="Pay Slip (With Over-time)";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
}
		break;
		case 9:
	$report="Pay Slip (Without Over-time)";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
}
		break;
				case 10:
	$report="Salary Cheque";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
}
		break;
    case 8:
	$report="Salary Payroll Report (Without Overtime)";
	if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,c.DESG_DESC as designation , d.DEPT_DESC as department,
	b.total_salary as gross_salary, b.bonus_amt bonus, b.benefits other_benefits, b.absent_deduction,
	(b.total_salary +  b.bonus_amt + b.benefits - b.absent_deduction) as total_payable,
	b.advance_install as advance_deduction, b.deduction as food_deduction, (b.total_payable - b.over_time_amount) as net_payable FROM personnel_basic_info a,salary_attendence b, designation c, department d where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DEPARTMENT,b.total_salary desc";
}	break;
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
	$report="APR Information";
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

         $sql="select a.dealer_code as code,a.dealer_name_e as dealer_name ,a.propritor_name_e as propritor_name ,a.address_e as address,b.AREA_NAME as area,a.product_group ,a.mobile_no ,a.tel_no ,c.l_name as division,d.l_name as district,e.l_name as thana,a.security_deposit,a.app_date, a.credit_limit ,a.canceled as status,w.warehouse_name as depot from dealer_info a,area b,location c,location d,location e,warehouse w where a.area_code = b.AREA_CODE and a.division_code=c.l_id and a.district_code=d.l_id and a.thana_code=e.l_id and w.warehouse_id=a.depot".$con;
		break;
    case 10001:
$report="Final Attendance Report";
	$mon = $_POST['mon'];
	$year = $_POST['year'];
         $sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,c.DESG_DESC as designation , d.DEPT_DESC as department,
	`td` as total_days,`od` as off_days,`hd` as holy_days,`lt` as late_days,`ab` as absent_days,`lv` as leave_days,`pre` as present_days,`pay` as payable_days,`ot` as office_tour FROM personnel_basic_info a,hrm_attendence_final b, designation c, department d where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DEPARTMENT desc";
		break;
		case 10002:
		$report="Provident Fund Report";
		if($_POST['mon']>0)		$con .= ' and b.mon="'.$_POST['mon'].'"';
		if($_POST['year']>0)	$con .= ' and b.year="'.$_POST['year'].'"';
		if($_POST['employee_selected']>0)	$con .= ' and b.PBI_ID="'.$_POST['employee_selected'].'"';
		

		break;
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<? if($_POST['report']!=10){?><link href="../../css/report.css" type="text/css" rel="stylesheet" /><? }?>
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
.style4 {font-size: 12px}
.style5 {
	font-size: 16px;
	font-weight: bold;
}
.style6 {font-weight: bold}
.style8 {font-size: 12px; font-weight: bold; }
-->
</style>
</head>
<body>
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">
<?
		//echo $sql;
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';
		if($_POST['mon']>0) 
		$str 	.= '<h2>'.date('F', mktime(0,0,0,$_POST['mon'],15,2000)).', '.$_POST['year'].'</h2>';
		$str 	.= '</div>';
		if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		if($_POST['domain']!='') 
		$str 	.= '<p>Employee Type: '.$_POST['domain'].'</p>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		if(isset($client_name)) 
		$str 	.= '<p>Client Name: '.$client_name.'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';

if(isset($sql)&&$sql!=''&&$_POST['report']!=7) echo report_create($sql,1,$str);
elseif($_POST['report']==10002)
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="9"><div class="header"><h1>REGENT :: Human Resource Management Solution</h1><h2>Provident Fund Report</h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: 09:53 AM 15-08-2015</div></td></tr>
	
	<tr><th>SL</th><th>CODE</th><th>Name</th><th>Designation</th><th>Department</th><th>Year</th><th>Period</th><th>PF FUND ORG</th><th>PF FUND OWN</th></tr></thead><tbody>
<?
		$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,c.DESG_DESC as designation , d.DEPT_DESC as department,b.year,concat(b.mon,'-',b.year) as period,
		`pf` as PF_FUND_ORG,`pf_own` as PF_FUND_OWN FROM personnel_basic_info a,salary_attendence b, designation c, department d where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_ID=b.PBI_ID and (b.pf>0 or b.pf_own>0) ".$con." order by a.PBI_DEPARTMENT desc";	
$res = mysql_query($sql);
	while($data=mysql_fetch_row($res))
	{
	$pf_org=$pf_org + $data[6];
	$pf_own=$pf_own + $data[7];
	?>
	<tr><td><?=++$i;?></td><td><?=$data[0]?></td><td><?=$data[1]?></td><td><?=$data[2]?></td><td><?=$data[3]?></td><td><?=$data[4]?></td><td><?=$data[5]?></td><td><?=$data[6]?></td><td><?=$data[7]?></td></tr>
	<?
	}
	?>
	<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=$pf_org?></td><td><?=$pf_own?></td>
	</tr></tbody></table>
	<br /><br />
	<?
}
elseif($_POST['report']==7)
{
$sql="SELECT a.*,b.*,c.DEPT_DESC,d.DESG_DESC FROM personnel_basic_info a,salary_attendence b,department c,designation d where a.PBI_DEPARTMENT=c.DEPT_ID and a.PBI_DESIGNATION=d.DESG_ID and a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DEPARTMENT,b.total_salary desc";
//echo $sql;
$res = mysql_query($sql);
	while($data=mysql_fetch_object($res))
	{
	?>
	<div<? $i++;if(($i%3)==0) echo 'style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid"';?>>
	<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="8"><div class="header"><h1><?=$_SESSION['company_name']?></h1>
	<h2>Pay Slip (With Over-Time): <?=date('F', mktime(0,0,0,$mon,15,2000))?>, <?=$year?></h2></div></td></tr><tr>
	<th>Staff Picture</th>
	<th>Staff_Information</th>
	<th>Attendence_Info</th>
	<th>Salary_Information</th>
	<th> Other_Benefits</th>
	<th>Deduction/Meal</th>
	<th>Payable_Salary</th>
	<th>Signature</th></tr></thead><tbody><tr>
	  <td align="center" style="text-align:center"><p><img src="../../pic/staff/<?=$data->PBI_ID?>.jpg" alt="" width="98" height="101" border="1" /></p></td>
	  <td align="center">ID: <strong><?=$data->PBI_ID?></strong><br />
	Name: <strong>
	<?=$data->PBI_NAME ?>
	</strong><br />
	Designation: <strong>
	<?=$data->DESG_DESC?>
	</strong><br />
	Department: <strong>
	<?=$data->DEPT_DESC?>
	</strong></td>
	  <td align="right">Present Days:<strong>
		<?=$data->pre?></strong><br />
		Leave Days:<strong>
		<?=$data->lv?></strong><br />
		Late Days:<strong>
		<?=$data->lt?></strong><br />
		Absent Days:<strong>
		<?=$data->ab?></strong><br />
		Total Days:<strong>
		<?=$data->td?></strong><br />Payable Days:<strong>
		<?=$data->pay?>
		</strong></td>
	  <td align="center" style="text-align:right">Basic Salary:<strong>
		<?=$data->basic_salary?></strong><br />
	  House Rent:<strong>
	  <?=$data->house_rent?></strong><br />
	  Medical All:<strong>
	  <?=$data->medical_allowance?></strong><br />
	  Other All:<strong>
	  <?=$data->other_allowance?></strong><br />
	  Special All:<strong>
	  <?=$data->special_allowance?></strong><br />
	  Mobile All:<strong>
	  <?=$data->mobile_allowance?></strong><br />
	  Total Sal:<strong>
	  <?=($data->total_salary+$data->mobile_allowance)?>
	  
	  </strong></td>
	  <td align="center" style="text-align:right">Bonus Amt:<strong>
		<?=$data->bonus_amt?></strong><br />
		Over-Time Amt:<strong>
		<?=($data->total_benefits-($data->benefits+$data->bonus_amt))?></strong><br />
		Benefits:<strong>
		<?=$data->benefits?></strong><br />
		Total Benefits: <strong>
		<?=$data->total_benefits?>
		</strong></td>
	  <td align="center" style="text-align:right">Absent Deduction:<strong>
		<?=($data->total_deduction-($data->advance_install+$data->other_install+$data->deduction+$data->pf+$data->pf_own))?></strong><br />
		PF ORG:<strong>
		<?=$data->pf?></strong><br />
		PF OWN:<strong>
		<?=$data->pf_own?></strong><br />
		Advance Install:<strong>
		<?=$data->advance_install?></strong><br />
		Other Install:<strong>
		<?=$data->other_install?></strong><br />
		Meal/ Deduction:<strong>
		<?=$data->deduction?></strong><br />Total Deduction:<strong>
		<?=$data->total_deduction?>
		</strong></td>
	  <td align="center" style="text-align:right">Total Sal:<strong>
		<?=($data->total_salary+$data->mobile_allowance)?>
	  </strong><br />
		Total Benefits:<strong>
		<?=$data->total_benefits?>
		</strong><br />
		Total Ded:<strong>
		<?=$data->total_deduction?>
		</strong><br />
		Total Payable:<strong>
		<?=($data->total_salary+$data->mobile_allowance)+($data->total_benefits-$data->total_deduction)?>
		</strong></td>
	  <td align="center" style="text-align:right">................................<br />
		(<strong><?=$data->PBI_NAME;?></strong>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr></tbody></table>
	</div><br /><br />
	<?
	}
}
elseif($_POST['report']==9)
{

	$sql="SELECT a.*,b.*,c.DEPT_DESC,d.DESG_DESC FROM personnel_basic_info a,salary_attendence b, department c, designation d where a.PBI_DEPARTMENT=c.DEPT_ID and a.PBI_DESIGNATION=d.DESG_ID and	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_ID desc";
$res = mysql_query($sql);
	while($data=mysql_fetch_object($res)){
?>
<div <? $i++;if(($i%3)==0) echo 'style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid"';?>>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="8"><div class="header"><h1><?=$_SESSION['company_name']?></h1>
  <h2>Pay Slip (Without Over-Time): 
    <?=date('F', mktime(0,0,0,$mon,15,2000))?>, <?=$year?></h2></div></td></tr><tr>
  <th>Staff Picture</th>
  <th>Staff_Information</th>
  <th>Attendence_Info</th>
  <th>Salary_Information</th>
  <th> Other_Benefits</th>
  <th>Deduction/Meal</th>
  <th>Payable_Salary</th>
  <th>Signature</th></tr></thead><tbody><tr>
      <td align="center" style="text-align:center"><p><img src="../../pic/staff/<?=$data->PBI_ID?>.jpg" alt="" width="98" height="101" border="1" /></p></td>
      <td align="center">ID: <strong><?=$data->PBI_ID?></strong><br />
 Name: <strong>
 <?=$data->PBI_NAME ?>
 </strong><br />
 Designation: <strong>
 <?=$data->DESG_DESC?>
 </strong><br />
 Department: <strong>
 <?=$data->DEPT_DESC?>
 </strong></td>
      <td align="right">Present Days:<strong>
        <?=$data->pre?></strong><br />
        Leave Days:<strong>
        <?=$data->lv?></strong><br />
        Late Days:<strong>
        <?=$data->lt?></strong><br />
        Absent Days:<strong>
        <?=$data->ab?></strong><br />
        Total Days:<strong>
        <?=$data->td?></strong><br />Payable Days:<strong>
        <?=$data->pay?>
        </strong></td>
      <td align="center" style="text-align:right">Basic Salary:<strong>
        <?=$data->basic_salary?></strong><br />
      House Rent:<strong>
      <?=$data->house_rent?></strong><br />
      Medical All:<strong>
      <?=$data->medical_allowance?></strong><br />
      Other All:<strong>
      <?=$data->other_allowance?></strong><br />
      Special All:<strong>
      <?=$data->special_allowance?></strong><br />
      Mobile All:<strong>
      <?=$data->mobile_allowance?></strong><br />
      Total Sal:<strong>
      <?=($data->total_salary+$data->mobile_allowance)?>
      </strong></td>
      <td align="center" style="text-align:right">Bonus Amt:<strong>
        <?=$data->bonus_amt?></strong><br />
        Benefits:<strong>
        <?=$data->benefits?></strong><br />
        Total Benefits: <strong>
        <?=($data->benefits+$data->bonus_amt)?>
        </strong></td>
      <td align="center" style="text-align:right">Absent Deduction:<strong>
      <?=($data->total_deduction-($data->advance_install+$data->other_install+$data->deduction+$data->pf+$data->pf_own))?>
      </strong><br />
PF ORG:<strong>
<?=$data->pf?>
</strong><br />
PF OWN:<strong>
<?=$data->pf_own?>
</strong><br />
        Advance Install:<strong>
        <?=$data->advance_install?></strong><br />
        Other Install:<strong>
        <?=$data->other_install?></strong><br />
        Meal/ Deduction:<strong>
        <?=$data->deduction?></strong><br />Total Deduction:<strong>
        <?=$data->total_deduction?>
        </strong></td>
      <td align="center" style="text-align:right">Total Sal:<strong>
      <?=($data->total_salary+$data->mobile_allowance)?>
      </strong><br />
Total Benefits:<strong>
<?=$data->total_benefits?>
</strong><br />
Total Ded:<strong>
<?=$data->total_deduction?>
</strong><br />
Total Payable:<strong>
<?=($data->total_salary+$data->mobile_allowance)+($data->total_benefits-$data->total_deduction)?>
</strong></td>
      <td align="center" style="text-align:right">................................<br />
        (<strong>
        <?=$data->PBI_NAME ?>
        </strong>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></tbody></table>
</div>
<p><br />
    <br />
    <?
	}
}
elseif($_POST['report']==10)
{
require "../../../engine/tools/class.numbertoword.php";
$sql="SELECT a.*,b.*,c.DEPT_DESC,d.DESG_DESC,e.DOMAIN_DESC FROM personnel_basic_info a,salary_attendence b, department c, designation d,domai e where a.PBI_DOMAIN=e.DOMAIN_CODE and a.PBI_DEPARTMENT=c.DEPT_ID and a.PBI_DESIGNATION=d.DESG_ID and	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_ID desc";
$res = mysql_query($sql);
	while($data=mysql_fetch_object($res)){
	$total = (int)(($data->total_salary+$data->mobile_allowance)+($data->total_benefits-$data->total_deduction));
?>
<div <? $i++;if(($i%3)==0) echo 'style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid"';?>>
<style type="text/css">
<!--
.style1 {
	font-size: 10px;
	font-weight: bold;
}
.style2 {font-size: 14px}
.style4 {font-size: 12px}
.style6 {font-size: 14px; font-weight: bold; }
.style8 {font-size: 10px}
.style9 {font-size: 8px}
-->
</style>
<table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="30%"><table width="80%" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="2"><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="52" height="70" align="center"><p><img src="../../../logo/lo.jpg" width="27" height="22" /></p></td>
                          <td width="195"><p><span class="style1 style4"> <span class="style8">REGENT</span><br />
                                    <span class="style8">
                                      <?=$data->DOMAIN_DESC?>
                                    </span> </span><span class="style2"><br />
                                    <span class="style9"> Salary Cheque (Only for office head)</span></span><br />
                          </p></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="2"><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="20%" rowspan="2" valign="top" class="style4">SL No.: </td>
                          <td width="27%" rowspan="2" valign="top" class="style4"><?=$data->id?></td>
                          <td width="53%" height="25" valign="top" class="style4">Date:</td>
                        </tr>
                        <tr>
                          <td height="25" valign="top" class="style4">Month:
                            <?=date('M, Y',mktime(12,59,59,$mon,1,$year));?></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td width="30%" rowspan="2" align="left" valign="middle"><span class="style4">Pay to:</span></td>
                    <td height="4" valign="bottom"><span class="style4">
                      <?=$data->PBI_NAME ?>
                    </span> </td>
                  </tr>
                  <tr>
                    <td height="4" valign="bottom">````````````````````````````</td>
                  </tr>
                  <tr>
                    <td width="30%" rowspan="2" align="left" valign="middle"><span class="style4">ID No:</span></td>
                    <td width="70%" height="7" valign="bottom"><span class="style4">
                      <?=$data->PBI_ID?>
                    </span> </td>
                  </tr>
                  <tr>
                    <td height="15" align="left" valign="bottom">````````````````````````````</td>
                  </tr>
                  <tr>
                    <td height="10" align="left" valign="top">&nbsp;</td>
                    <td height="10" valign="top" class="style4">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="30%" height="40" align="left" valign="top"><span class="style4">In-Words:</span></td>
                    <td height="40" valign="top" class="style4"><?=convertNumberMhafuz($total)?></td>
                  </tr>
                  <tr>
                    <td height="20" colspan="2" valign="bottom">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"><span class="style4">Amount Tk.
                      <?=number_format($total,2);?>
                    </span></td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="right"><table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><div align="center">__________________</div></td>
                        </tr>
                        <tr>
                          <td><div align="center" class="style4">Authorized Signature </div></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
        <td width="75%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="69%"><table width="80%" border="0" align="right" cellpadding="5" cellspacing="0">
                        <tr>
                          <td align="right"><img src="../../../logo/lo.jpg" width="70" height="58" /></td>
                          <td><span class="style6">REGENT<br />
                                <?=$data->DOMAIN_DESC?>
                            </span><span class="style2"><br />
                            <span class="style4">Salary Cheque (Only for office head)</span></span></td>
                        </tr>
                    </table></td>
                    <td width="31%"><table width="100%" border="0" align="right" cellpadding="5" cellspacing="0">
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td><div align="right">Date: </div></td>
                          <td><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000">
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td><div align="right">Month:</div></td>
                          <td><?=date('F, Y',mktime(12,59,59,$mon,1,$year));?></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td width="70%" valign="bottom"><table width="97%" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="4" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="9%" height="40" valign="top">SL No.: </td>
                          <td width="91%" valign="top"><span style="font-size:14px; font-weight:bold">
                            <?=$data->id?>
                          </span></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td width="10%" rowspan="2" valign="top">Pay to : </td>
                    <td height="20" valign="bottom"><span class="style4"> <span class="style5">
                      <?=$data->PBI_NAME ?>
                    </span></span></td>
                    <td width="7%" rowspan="2" valign="top">ID No : </td>
                    <td height="20" valign="bottom"><span class="style5">
                      <?=$data->PBI_ID?>
                    </span></td>
                  </tr>
                  <tr>
                    <td height="1" valign="top">`````````````````````````````````````````````````````````````````````````````</td>
                    <td valign="bottom">```````````````````````````</td>
                  </tr>
                  <tr>
                    <td height="40" rowspan="2" valign="top">In Words :</td>
                    <td height="20" colspan="3" valign="bottom"><span class="style5">
                      <?=convertNumberMhafuz($total)?>
                    </span></td>
                  </tr>
                  <tr>
                    <td height="20" colspan="3" valign="bottom">`````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````</td>
                  </tr>
                  <tr>
                    <td colspan="4" valign="bottom">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="40" colspan="4" valign="bottom">Amount Tk. <strong>
                      <?=number_format($total,2);?>
                    </strong></td>
                  </tr>
                  <tr>
                    <td colspan="4">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                        <tr>
                          <td><table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td><div align="center">__________________</div></td>
                              </tr>
                              <tr>
                                <td><div align="center" class="style4">Authorized Signature </div></td>
                              </tr>
                          </table></td>
                          <td><table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td><div align="center">__________________</div></td>
                              </tr>
                              <tr>
                                <td><div align="center" class="style4">Authorized Signature </div></td>
                              </tr>
                          </table></td>
                          <td><table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td><div align="center">__________________</div></td>
                              </tr>
                              <tr>
                                <td><div align="center" class="style4">Authorized Signature </div></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" style="height:10px;"></td>
  </tr>
</table>
</div>
<p><br />
    <br />
    <?
	}
}
?>
</p>
<!--<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:#FFFFFF; border-width:0px;">
  <tr>
    <td style="border:#FFFFFF; border-width:0px;"><div align="center">____________________________</div></td>
    <td style="border:#FFFFFF; border-width:0px;"><div align="center">____________________________</div></td>
    <td style="border:#FFFFFF; border-width:0px;"><div align="center">____________________________</div></td>
  </tr>
  <tr>
    <td style="border:#FFFFFF; border-width:0px;"><div align="center">(Admin)</div></td>
    <td style="border:#FFFFFF; border-width:0px;"><div align="center">(Accounts)</div></td>
    <td style="border:#FFFFFF; border-width:0px;"><div align="center">(Managing Director)</div></td>
  </tr>
</table>-->
<p>&nbsp; </p>
</div>
</body>
</html>