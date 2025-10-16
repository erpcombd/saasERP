<?
session_start();
ini_set('max_execution_time', 60);
ini_set('memory_limit', '128M');
set_time_limit(0);
//$msc=microtime(true);
require "../../config/inc.all.php";
require "../../classes/report.class.php";
date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if($_POST['name']!='')
	$con.=' and a.PBI_NAME like "%'.$_POST['name'].'%"';
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
	
	if($_POST['age']!='')
	$con.=' and a.PBI_DOB < "'.(date('Y')-$_POST['age']).'-'.date('m').'-'.date('d').'"';
		
	if($_POST['gender']!='')
	$con.=' and a.PBI_SEX = "'.$_POST['gender'].'"';
	
	if($_POST['ijdb']!='')
	$con.=' and a.PBI_DOJ < "'.$_POST['ijdb'].'"';
	if($_POST['ppjdb']!='')
	$con.=' and a.PBI_DOJ_PP < "'.$_POST['ppjdb'].'"';
    if($_POST['PBI_JOB_STATUS']!='')
    $con.=' and a.PBI_JOB_STATUS = "'.$_POST['PBI_JOB_STATUS'].'"';
    if($_POST['ijda']!='')
    $con.=' and a.PBI_DOJ > "'.$_POST['ijda'].'"';
	if($_POST['ppjda']!='')
	$con.=' and a.PBI_DOJ_PP > "'.$_POST['ppjda'].'"';
	if($_POST['edu_qua']!='')
	$con.=' and a.PBI_EDU_QUALIFICATION = "'.$_POST['edu_qua'].'"';
	
	if($_POST['region']!='')
	$con.=' and a.PBI_REGION = "'.$_POST['region'].'"';
	if($_POST['blood_group']!='')
	$con.=' and a.PBI_ID in (select PBI_ID from essential_info where ESSENTIAL_BLOOD_GROUP = "'.$_POST['blood_group'].'")';
	
	if($_POST['DESG_GRADE1']>0&&$_POST['DESG_GRADE2']>0)
	$con.=" and a.PBI_DESG_GRADE between '".$_POST['DESG_GRADE1']."' and '".$_POST['DESG_GRADE2']."'";
	
switch ($_POST['report']) {
    case 1:
	$report="Employee Basic Information";

        $sql="select 
a.PBI_ID as ID,
a.PBI_NAME as Name,
a.PBI_FATHER_NAME as father_name,
a.PBI_SEX as Gender,
b.DOMAIN_DESC as Company_Name,
c.DEPT_DESC as department,
d.DESG_DESC as designation ,
a.PBI_DOJ as joining_date
from 
personnel_basic_info a, 
domai b, 
department c, 
designation d 
where 
a.PBI_DOMAIN=b.DOMAIN_CODE and 
a.PBI_DEPARTMENT=c.DEPT_ID and 
a.PBI_DESIGNATION=d.DESG_ID".$con;
		//echo $sql;
break;

    case 2:
	$report="Educational Qualification";

         $sql="SELECT b.EDU_QUA_DESC as educational_qualification, count( a.PBI_EDU_QUALIFICATION ) as count
FROM `personnel_basic_info` a, edu_qua b where a.PBI_EDU_QUALIFICATION=b.EDU_QUA_CODE".$con."
GROUP BY PBI_EDU_QUALIFICATION
ORDER BY `PBI_EDU_QUALIFICATION` ASC";
		break;
	    case 3:
	$report="Designation Wise Count";

         $sql="SELECT b.DESG_DESC as designation, count( PBI_DESIGNATION ) as count
FROM `personnel_basic_info` a, designation b where a.PBI_DESIGNATION=b.DESG_ID".$con."
GROUP BY PBI_DESIGNATION
ORDER BY `PBI_DESG_GRADE` ASC";
		break;
		 case 4:
		$report="Over Time Report";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department, b.ot as over_time_hour,(b.total_salary/208) as rate,b.over_time_amount FROM personnel_basic_info a,salary_attendence b where b.ot>0 and	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;
	    case 5:
		$report="Salary Payroll Report (Detail)";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,
	b.basic_salary,b.house_rent,b.medical_allowance,b.other_allowance,b.special_allowance,b.mobile_allowance,b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction,b.total_benefits,b.total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DEPARTMENT,b.total_salary desc";
}
		break;
	
    case 6:
	$report="Salary Payroll Report (Summary)";
	if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,
	b.total_salary as gross_salary,b.mobile_allowance,b.over_time_amount as overtime, b.bonus_amt bonus, b.benefits other_benefits, b.absent_deduction,
	(b.total_salary + b.mobile_allowance + b.over_time_amount + b.bonus_amt + b.benefits  - b.absent_deduction) as total_payable,
	b.advance_install as advance_deduction, b.deduction as food_deduction, b.total_payable as net_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_ID asc";
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
    case 8:
	$report="Salary Payroll Report (Without Overtime)";
	if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,
	b.total_salary as gross_salary, b.bonus_amt bonus, b.benefits other_benefits, b.absent_deduction,
	(b.total_salary +  b.bonus_amt + b.benefits - b.absent_deduction) as total_payable,
	b.advance_install as advance_deduction, b.deduction as food_deduction, (b.total_payable - b.over_time_amount) as net_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DEPARTMENT,b.total_salary desc";
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
	$year=$_POST['year'];
	$report="Total APR Form - ".$year;
	
	
	$year=$_POST['year'];
	
		$qqq="select a.PBI_ID ,a.PBI_NAME,a.PBI_DESIGNATION ,a.PBI_DESG_GRADE,a.PBI_SEX,a.PBI_DOB,a.PBI_DOMAIN,a.PBI_DEPARTMENT,a.JOB_LOCATION,a.PBI_ZONE,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_JOB_STATUS,a.remarks,b.APR_MARKS as m_2012,b.d_r_increment,b.hr_r_increment,b.d_r_promotion,b.APR_STATUS from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID  and b.APR_YEAR = '".$year."' order by a.PBI_ID";
	
	$query=mysql_query($qqq);
	$out.='<table width="100%" cellspacing="0" cellpadding="2" border="0">';
	$out.='<thead><tr>
	<th>SL</th>
	<th>ID</th>
	<th>Name</th>
	<th>Persent Designation</th>
	<th>Grade</th>
	
	<th>Gender</th>
	<th>Age</th>
	<th>Domain</th>
	<th>Department</th>
	<th>Job Location</th>
	
	<th>Zone</th>
	<th>1st Joining Date</th>
	<th>Joining Date Of PP</th>
	<th>Total Service Length</th>
	<th>Service Length Of PP</th>
	<th>Cross Year</th>
	
	<th>APR Marks '.$year.'</th>
	<th>APR Marks '.($year-1).'</th>
	<th>APR Marks '.($year-2).'</th>
	<th>Average Marks</th>
	
	<th>Department Recomandation for Increment</th>
	<th>HR-M Recomandation for Increment</th>
	<th>Department Recomandation for Promotion</th>
	
	<th>Status</th>
	<th>Job Status</th>
	<th>Remarks</th>
	</tr></thead><tbody>';
	
	$sl=0;
	while($data=mysql_fetch_object($query))
	{
	$sl++;
	$info->m_2010=0;
	$info->m_2011=0;
	
	$sss='select APR_MARKS,APR_YEAR from apr_detail where PBI_ID="'.$data->PBI_ID.'" and (APR_YEAR="'.($year-1).'" or APR_YEAR="'.($year-2).'")';
	$ss=mysql_query($sss);
	while($s=mysql_fetch_object($ss))
	{
		if($s->APR_YEAR==($year-1)) $info->m_2011=$s->APR_MARKS;
		if($s->APR_YEAR==($year-2)) $info->m_2010=$s->APR_MARKS;
	}
	if($info->m_2011>0&&$info->m_2010>0)
	$avg=number_format((($data->m_2012+$info->m_2011+$info->m_2010)/3),1);
	elseif($info->m_2011>0&&$info->m_2010<1)
	$avg=number_format((($data->m_2012+$info->m_2011)/2),1);
	elseif($info->m_2011<1&&$info->m_2010>0)
	$avg=number_format((($data->m_2012+$info->m_2010)/2),1);
	else
	$avg=$data->m_2012;
	
	
	if(substr($data->service_length_of_PP,4)=='-01-01')
	$cross_year=($year-substr($data->service_length_of_PP,0,4)+1);
	else
	$cross_year=($year-substr($data->service_length_of_PP,0,4));
	$out.='<tr>';
	$out.='<td>'.$sl.'</td>
	<td>'.$data->PBI_ID.'</td>
	<td>'.$data->PBI_NAME.'</td>
	<td>'.$data->PBI_DESIGNATION.'</td>
	<td>'.$data->PBI_DESG_GRADE.'</td>
	<td>'.$data->PBI_SEX.'</td>
	<td>'.Date2ageNew($data->PBI_DOB,$year).'</td>
	<td>'.$data->PBI_DOMAIN.'</td>
	<td>'.$data->PBI_DEPARTMENT.'</td>
	<td>'.$data->JOB_LOCATION.'</td>
	<td>'.$data->PBI_ZONE.'</td>
	<td>'.$data->joining_date.'</td>
	<td>'.$data->joining_date_of_PP.'</td>
	<td>'.Date2age($data->total_service_length).'</td>
	<td>'.Date2age($data->service_length_of_PP).'</td>
	<td>'.$cross_year.'</td>
	<th>'.$data->m_2012.'</th>
	<th>'.$info->m_2011.'</th>
	<th>'.$info->m_2010.'</th>
	<th>'.$avg.'</th>
	<th>'.$data->d_r_increment.'</th>
	<th>'.$data->hr_r_increment.'</th>
	<th>'.$data->d_r_promotion.'</th>
	<td>'.$data->APR_STATUS.'</td>
	<td>'.$data->PBI_JOB_STATUS.'</td>
	<td>&nbsp;</td>';
	$out.='</tr>';}
	
	$out.='</tbody></table>';
		break;
		    case 102:
	$report="Below Average Marks";
	
	$year=$_POST['year'];
	$qqq="select PBI_ID,avg(APR_MARKS) as avg_marks from apr_detail where APR_YEAR in (".$year.",".($year-1).",".($year-2).") group by PBI_ID";
	
	$query=mysql_query($qqq);
	$out.='<table width="100%" cellspacing="0" cellpadding="2" border="0">';
	$out.='<thead><tr>
	<th>SL</th>
	<th>ID</th>
	<th>Name</th>
	<th>Persent Designation</th>
	<th>Grade</th>
	<th>Domain</th>
	<th>Department</th>
	<th>Job Location</th>
	<th>Joining Date</th>
	<th>Joining Date Of PP</th>
	<th>Total Service Length</th>
	<th>Service Length Of PP</th>
	<th>Marks(AVG)</th>
	<th>Cross Year</th>
	<th>Job Status</th>
	<th>Remarks</th>
	</tr></thead><tbody>';
	
	$sl=0;
	while($info=mysql_fetch_object($query))
	{ 
	if($_POST['markb']==''||$info->avg_marks<$_POST['markb']){
	if($_POST['marka']==''||$info->avg_marks>$_POST['marka']){
	$ppp="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_SEX as Gender,a.PBI_JOB_STATUS 	as job_status,a.remarks from personnel_basic_info a where a.PBI_ID='".$info->PBI_ID."' ".$con;
	$pquery=mysql_query($ppp);
	while($data=mysql_fetch_object($pquery)){
	$sl++;
	if(date('m')>substr($data->cross_year,5,2))	$cross_year=(date('Y')-substr($data->cross_year,0,4));
	else $cross_year=(date('Y')-substr($data->cross_year,0,4))-1;
	$out.='<tr>';
	$out.='<td>'.$sl.'</td>
	<td>'.$data->ID.'</td>
	<td>'.$data->Name.'</td>
	<td>'.$data->persent_designation.'</td>
	<td>'.$data->grade.'</td>
	<td>'.$data->Domain.'</td>
	<td>'.$data->department.'</td>
	<td>'.$data->job_location.'</td>
	<td>'.$data->joining_date.'</td>
	<td>'.$data->joining_date_of_PP.'</td>
	<td>'.Date2age($data->total_service_length).'</td>
	<td>'.Date2age($data->service_length_of_PP).'</td>
	<th>'.$info->avg_marks.'</th>
	<td>'.$cross_year.'</td>
	<td>'.$data->job_status.'</td>
	<td>&nbsp;</td>';
	$out.='</tr>';}}}}
	
	$out.='</tbody></table>';
	
         
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
		case 103:
	$report="Below Service Length";
	if($_POST['markb']!='')
	$con.=' and b.APR_MARKS < "'.$_POST['markb'].'"';
	
	if($_POST['marka']!='')
	$con.=' and b.APR_MARKS > "'.$_POST['marka'].'"';
	
	$year=$_POST['year'];
	$con.=' and b.APR_YEAR = "'.$year.'"';
			 
         $sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_JOB_STATUS 	as job_status,a.remarks
		 from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID ".$con;
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
		case 104:
	
	
			 
    $year=$_POST['year'];
	if($_POST['year2']!='')
	$year2=$_POST['year2'];
	else
	$year2=$_POST['year'];
	
	$report="No APR Form of Year ".$year." to ".$year2;
	
	$qqq="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_SEX as Gender,a.PBI_JOB_STATUS 	as job_status,a.remarks from personnel_basic_info a where 1 ".$con;
	
	$query=mysql_query($qqq);
	$out.='<table width="100%" cellspacing="0" cellpadding="2" border="0">';
	$out.='<thead><tr>
	<th>SL</th>
	<th>ID</th>
	<th>Name</th>
	<th>Persent Designation</th>
	<th>Grade</th>
	<th>Domain</th>
	<th>Department</th>
	<th>Job Location</th>
	<th>Joining Date</th>
	<th>Joining Date Of PP</th>
	<th>Total Service Length</th>
	<th>Service Length Of PP</th>
	<th>Cross Year</th>
	<th>Job Status</th>
	<th>Remarks</th>
	</tr></thead><tbody>';
	
	$sl=0;
	while($data=mysql_fetch_object($query))
	{ 
	$qqq="select 1 from apr_detail where PBI_ID='".$data->ID."' and APR_YEAR between '".$year."' and '".$year2."'";
	$pquery=mysql_query($qqq);
	$count=mysql_num_rows($pquery);
	if($count<1){
	$sl++;
	if(date('m')>substr($data->cross_year,5,2))	$cross_year=(date('Y')-substr($data->cross_year,0,4));
	else $cross_year=(date('Y')-substr($data->cross_year,0,4))-1;
	$out.='<tr>';
	$out.='<td>'.$sl.'</td>
	<td>'.$data->ID.'</td>
	<td>'.$data->Name.'</td>
	<td>'.$data->persent_designation.'</td>
	<td>'.$data->grade.'</td>
	<td>'.$data->Domain.'</td>
	<td>'.$data->department.'</td>
	<td>'.$data->job_location.'</td>
	<td>'.$data->joining_date.'</td>
	<td>'.$data->joining_date_of_PP.'</td>
	<td>'.Date2age($data->total_service_length).'</td>
	<td>'.Date2age($data->service_length_of_PP).'</td>
	<td>'.$cross_year.'</td>
	<td>'.$data->job_status.'</td>
	<td>&nbsp;</td>';
	$out.='</tr>';}}
	
	$out.='</tbody></table>';
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
		case 105:
	$report="3 Year Up & No Recommendation of Promotion";
	
			 
    $year=$_POST['year'];
	$qqq="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_SEX as Gender,a.PBI_JOB_STATUS 	as job_status,a.remarks from personnel_basic_info a where 1 ".$con;
	
	$query=mysql_query($qqq);
	$out.='<table width="100%" cellspacing="0" cellpadding="2" border="0">';
	$out.='<thead><tr>
	<th>SL</th>
	<th>ID</th>
	<th>Name</th>
	<th>Persent Designation</th>
	<th>Grade</th>
	<th>Domain</th>
	<th>Department</th>
	<th>Job Location</th>
	<th>Joining Date</th>
	<th>Joining Date Of PP</th>
	<th>Total Service Length</th>
	<th>Service Length Of PP</th>
	<th>Cross Year</th>
	<th>Job Status</th>
	<th>Remarks</th>
	</tr></thead><tbody>';
	
	$sl=0;
	while($data=mysql_fetch_object($query))
	{ 
	$qqq="select 1 from apr_detail where APR_YEAR in (".$year.",".($year-1).",".($year-2).") and d_r_promotion = '' and PBI_ID = '".$info->PBI_ID."'";
	$pquery=mysql_query($qqq);
	$count=mysql_num_rows($pquery);
	if($count<1){
	$sl++;
	if(date('m')>substr($data->cross_year,5,2))	$cross_year=(date('Y')-substr($data->cross_year,0,4));
	else $cross_year=(date('Y')-substr($data->cross_year,0,4))-1;
	$out.='<tr>';
	$out.='<td>'.$sl.'</td>
	<td>'.$data->ID.'</td>
	<td>'.$data->Name.'</td>
	<td>'.$data->persent_designation.'</td>
	<td>'.$data->grade.'</td>
	<td>'.$data->Domain.'</td>
	<td>'.$data->department.'</td>
	<td>'.$data->job_location.'</td>
	<td>'.$data->joining_date.'</td>
	<td>'.$data->joining_date_of_PP.'</td>
	<td>'.Date2age($data->total_service_length).'</td>
	<td>'.Date2age($data->service_length_of_PP).'</td>
	<td>'.$cross_year.'</td>
	<td>'.$data->job_status.'</td>
	<td>&nbsp;</td>';
	$out.='</tr>';}}
	
	$out.='</tbody></table>';
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
		case 106:
	$report="Promotion Recommend But 3Year Not Up";
	
    $year=$_POST['year'];
	$qqq="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_SEX as Gender,a.PBI_JOB_STATUS 	as job_status,a.remarks from personnel_basic_info a where 1 ".$con;
	
	$query=mysql_query($qqq);
	$out.='<table width="100%" cellspacing="0" cellpadding="2" border="0">';
	$out.='<thead><tr>
	<th>SL</th>
	<th>ID</th>
	<th>Name</th>
	<th>Persent Designation</th>
	<th>Grade</th>
	<th>Domain</th>
	<th>Department</th>
	<th>Job Location</th>
	<th>Joining Date</th>
	<th>Joining Date Of PP</th>
	<th>Total Service Length</th>
	<th>Service Length Of PP</th>
	<th>Cross Year</th>
	<th>Job Status</th>
	<th>Remarks</th>
	</tr></thead><tbody>';
	
	$sl=0;
	while($data=mysql_fetch_object($query))
	{ 
	$qqq="select 1 from apr_detail where APR_YEAR in (".$year.",".($year-1).",".($year-2).") and d_r_promotion = 'Yes' and PBI_ID = '".$info->PBI_ID."'";
	$pquery=mysql_query($qqq);
	$count=mysql_num_rows($pquery);
	if($count>0){
	$sl++;
	if(date('m')>substr($data->cross_year,5,2))	$cross_year=(date('Y')-substr($data->cross_year,0,4));
	else $cross_year=(date('Y')-substr($data->cross_year,0,4))-1;
	$out.='<tr>';
	$out.='<td>'.$sl.'</td>
	<td>'.$data->ID.'</td>
	<td>'.$data->Name.'</td>
	<td>'.$data->persent_designation.'</td>
	<td>'.$data->grade.'</td>
	<td>'.$data->Domain.'</td>
	<td>'.$data->department.'</td>
	<td>'.$data->job_location.'</td>
	<td>'.$data->joining_date.'</td>
	<td>'.$data->joining_date_of_PP.'</td>
	<td>'.Date2age($data->total_service_length).'</td>
	<td>'.Date2age($data->service_length_of_PP).'</td>
	<td>'.$cross_year.'</td>
	<td>'.$data->job_status.'</td>
	<td>&nbsp;</td>';
	$out.='</tr>';}}
	
	$out.='</tbody></table>';
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
		case 108:
	$report="Over Age ".$_POST['age'];
	if($_POST['markb']!='')
	$con.=' and b.APR_MARKS < "'.$_POST['markb'].'"';
	
	if($_POST['marka']!='')
	$con.=' and b.APR_MARKS > "'.$_POST['marka'].'"';
	
	$year=$_POST['year'];
	$con.=' and b.APR_YEAR = "'.$year.'"';
			 
         $sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_DOB as present_age,a.PBI_JOB_STATUS 	as job_status,a.remarks
		 from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID ".$con;
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
		case 109:
	$report=" Already Promoted ";
	if($_POST['markb']!='')
	$con.=' and b.APR_MARKS < "'.$_POST['markb'].'"';
	
	if($_POST['marka']!='')
	$con.=' and b.APR_MARKS > "'.$_POST['marka'].'"';
	
	$year=$_POST['year'];
	$con.=' and b.APR_YEAR = "'.$year.'"';
			 
         $sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_JOB_STATUS 	as job_status,a.remarks
		 from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID and b.APR_RESULT like '%Promotion%' ".$con;
		break;
		    case 201:
	$report="Employee Information";

        $sql.="select a.PBI_ID as Employe_ID";
		
		if($_POST['PBI_NAME']==1) $sql.= ",a.PBI_NAME as Name";
		if($_POST['PBI_SEX']==1) $sql.= ",a.PBI_SEX as Gender";
		if($_POST['PBI_DESIGNATION']==1) $sql.= ",(SELECT DESG_DESC FROM designation WHERE a.PBI_DESIGNATION=DESG_ID) as designation";
		if($_POST['PBI_RELIGION']==1) $sql.= ",a.PBI_RELIGION as Religion";
		if($_POST['PBI_DOB']==1) $sql.= ",a.PBI_DOB as Birth_date";
		if($_POST['PBI_MARITAL_STA']==1) $sql.= ",a.PBI_MARITAL_STA as Marital_status";
		if($_POST['PBI_PERMANENT_ADD']==1) $sql.= ",a.PBI_PERMANENT_ADD as Permanent_address";
		if($_POST['PBI_PRESENT_ADD']==1) $sql.= ",a.PBI_PRESENT_ADD as present_address";
		if($_POST['PBI_PHONE']==1) $sql.= ",a.PBI_PHONE as Phone";
		if($_POST['PBI_MOBILE']==1) $sql.= ",a.PBI_MOBILE as Mobile";
		if($_POST['PBI_EMAIL']==1) $sql.= ",a.PBI_EMAIL as Email";
		if($_POST['JOB_STATUS']==1) $sql.= ",(SELECT job_status FROM job_status WHERE a.PBI_JOB_STATUS=id) as Job_status";
		
		if($_POST['PBI_DOMAIN']==1) $sql.= ",(SELECT DOMAIN_DESC FROM domai WHERE a.PBI_DOMAIN=DOMAIN_CODE) as Company_Name";
		if($_POST['PBI_ZONE']==1) $sql.= ",a.PBI_ZONE as Zone";
		if($_POST['PBI_REGION']==1) $sql.= ",(select region_name from region where region_id=a.PBI_REGION) as Region";
		if($_POST['PBI_DEPARTMENT']==1) $sql.= ",(SELECT DEPT_DESC FROM department WHERE a.PBI_DEPARTMENT=DEPT_ID) as Department";
		if($_POST['PBI_EDU_QUALIFICATION']==1) $sql.= ",(SELECT EDU_QUA_DESC FROM edu_qua WHERE a.PBI_EDU_QUALIFICATION=EDU_QUA_CODE) as Edu_Qualification";
		if($_POST['PBI_DOJ']==1) $sql.= ",a.PBI_DOJ as Initial_Joinning_date";
		if($_POST['PBI_DOJ_PP']==1) $sql.= ",a.PBI_DOJ_PP as Joining_date_PP";
		
		$sql.= " from personnel_basic_info a where	1 ".$con." order by a.PBI_DESG_GRADE,a.PBI_SEX,a.PBI_DOJ";
		//echo $sql;
break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>
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
		$str 	.= '</div>';
		
		//if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		
		$str 	.= '<div class="left">';
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
$sql="SELECT a.*,b.* FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DEPARTMENT,b.total_salary desc";
$res = mysql_query($sql);
	while($data=mysql_fetch_object($res)){
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
 <?=$data->PBI_DESIGNATION?>
 </strong><br />
 Department: <strong>
 <?=$data->PBI_DEPARTMENT?>
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
        <?=($data->total_deduction-($data->advance_install+$data->other_install+$data->deduction))?></strong><br />
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

if($_POST['report']==201912) 

{

?>




<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead><tr><td style="border:0px;" colspan="28"><?=$str?></td></tr><tr><td style="border:0px;" colspan="28"><div align="center" style="font-size:20px;">OD Report of <? $test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');
 echo date_format($test, 'M-Y');
 ?>
</div></td></tr>

<tr>

  <th rowspan="2"><div align="center">S/L</div></th>

  <th rowspan="2"><div align="center">ID</div></th>

<th rowspan="2"><div align="center">Name</div></th>

<th rowspan="2"><div align="center">Designation</div></th>

<th rowspan="2"><div align="center">Department</div></th>


<th rowspan="2"><div align="center">Job Location/Project</div></th>

<th rowspan="2"><div align="center">Submission Date</div></th>


<th colspan="2"><div align="center">Date Interval</div></th>

<th rowspan="2"><div align="center">Total Days</div></th>

<th colspan="2"><div align="center">Time Interval</div></th>

<th rowspan="2"><div align="center">Total Hours</div></th>
<th rowspan="2"><div align="center">OD Type</div></th>

<th rowspan="2"><div align="center">Reason</div></th>

</tr>
<tr>
   <th><div align="center">Start Date</div></th>
   <th><div align="center">End Date</div></th>
   
   
   <th><div align="center">Start Time</div></th>
   <th><div align="center">End Time</div></th>
   
   
</tr>

</thead>

<tbody>

<?

if($_POST['department'] !='')
$od_con = ' and p.PBI_DEPARTMENT="'.$_POST['department'].'"';

if($_POST['JOB_LOCATION'] !='')
$od_con .= ' and p.JOB_LOCATION="'.$_POST['JOB_LOCATION'].'"';

/*if($_POST['year'] !='')
$od_con .= ' and l.year="'.$_POST['year'].'"';*/

if($_POST['mon'] !='')
$od_con .= ' and l.od_date between "'.$_POST['year'].'-'.$_POST['mon'].'-01" and "'.$_POST['year'].'-'.$_POST['mon'].'-30"';
//$tr_con .= ' and t.TRANSFER_ORDER_DATE between "'.$_POST['year'].'-'.$_POST['mon'].'-1" and "'.$_POST['year'].'-'.$_POST['mon'].'-30"';


  echo  $sqldd = 'select l.PBI_ID,p.PBI_NAME,p.PBI_DEPARTMENT,(select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project,p.PBI_SEX,p.PBI_DOJ,p.PBI_DESIGNATION,dept.DEPT_DESC,desg.DESG_DESC,DATE_FORMAT(l.od_date,"%d-%b-%Y") as od_date,l.total_days,l.total_hrs ,l.type,l.reason,l.s_time,l.e_time,
        DATE_FORMAT(l.s_date,"%d-%b-%Y") as s_date,DATE_FORMAT(l.e_date,"%d-%b-%Y") as e_date    
   from hrm_od_info l,personnel_basic_info p,essential_info e,department dept,designation desg where l.PBI_ID=p.PBI_ID and l.PBI_ID=e.PBI_ID and p.PBI_DEPARTMENT=dept.DEPT_ID and l.od_status="Granted" and  p.PBI_DESIGNATION=desg.DESG_ID '.$od_con.'';

$querydd=mysql_query($sqldd);

while($leaveData = mysql_fetch_object($querydd)){

$entry_by=$data->entry_by;
$year = date('Y');

?>

<tr><td><?=++$s?></td>
	<td><?=$leaveData->PBI_ID?></td>

<td nowrap="nowrap"><?=$leaveData->PBI_NAME?></td>

 <td><?=$leaveData->DESG_DESC?></td>

  <td><div align="center"><?=$leaveData->DEPT_DESC?></div></td>

 
  <td><div align="center"><?=$leaveData->project?></div></td>
  

  <td><div align="center"><?=$leaveData->od_date?></div></td>





  

   <td><?=$leaveData->s_date?></td>
   <td><?=$leaveData->e_date?></td>
   
   <td><div align="center"><?=$leaveData->total_days?></div></td>

   <td><div align="center"><?=$leaveData->s_time?></div></td>
   <td><div align="center"><?=$leaveData->e_time?></div></td>

    <td><div align="center"><?=$leaveData->total_hrs?></div></td>


   <td><div align="center"><?=find_a_field('od_type','type_name','id='.$leaveData->type)?></div></td>
   <td><?=$leaveData->reason?></td>

</tr>




<?



}

?>





</tbody></table>


<br><br><br>





<?
	}
}
elseif($_POST['report']==9)
{
	
	$sql="SELECT a.*,b.* FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_ID desc";
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
 <?=$data->PBI_DESIGNATION?>
 </strong><br />
 Department: <strong>
 <?=$data->PBI_DEPARTMENT?>
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
        <?=($data->total_deduction-($data->advance_install+$data->other_install+$data->deduction))?></strong><br />
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
elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);
else echo $str.$out;
?></div>
<?
//$msc=microtime(true)-$msc;
//echo $msc.' seconds'; // in seconds
//echo ($msc*1000).' milliseconds'; // in millseconds
?>
</body>
</html>