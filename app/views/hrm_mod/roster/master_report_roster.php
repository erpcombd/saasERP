<?


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

//require "../../classes/report.class.php";

require_once "../../../controllers/core/class.numbertoword.php";

require_once "../../../controllers/core/inc.exporttable.php";



if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)

{

	if($_POST['name']!='')

	$con.=' and a.PBI_NAME like "%'.$_POST['name'].'%"';

	if($_POST['PBI_ORG']!='')

	$con.=' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';

	if($_POST['department']!=''){

	$con.=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';

	$DEPARTMENT_con=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';

	}

	if($_POST['project']!='')

	$con.=' and a.PBI_PROJECT = "'.$_POST['project'].'"';

	if($_POST['designation']!='')

	$con.=' and a.PBI_DESIGNATION = "'.$_POST['designation'].'"';

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

	

	if($_POST['report']!=778){

	if($_POST['branch']!='')

	$con.=' and t.pbi_region ="'.$_POST['branch'].'"';}



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



//$query = db_query($sql);
$r_date = $rp1_date = $rp2_date = $rp3_date = $_POST['roster_date']; 
$re_date = date('Y-m-d',strtotime($_POST['roster_date2']));
//$re_date = date('Y-m-d',strtotime($r_date)+(6*86400));

$report="Schedule Duration: ".$r_date." to ".$re_date;

// DATE_FORMAT(a.PBI_DOC,'%d-%m-%Y') as due_confirmation_date,

// (select DESG_DESC from designation where DESG_SHORT_NAME=a.PBI_DESIGNATION) as designation,

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

		order by b.bonus_amt desc,a.PBI_DESG_GRADE asc

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

		if(s.cash_bank='IBBL', b.bank_paid, '') as IBBL , 

		b.cash_paid, 

		' ' as Signature  

		from 

		personnel_basic_info a, salary_bonus b, salary_info s 

		where 

		1 and a.PBI_ID=b.PBI_ID and 

		s.PBI_ID=b.PBI_ID and b.bonus_type=".$_POST['bonus_type']." and 

		b.year=".$_POST['year']." ".$con. " 

		order by b.bonus_amt desc,a.PBI_DESG_GRADE asc

		";

		

break;





case 10001:



$report="Employee Details Information";



$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,

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

(select LOCATION_NAME from office_location where id=a.JOB_LOCATION) JOB_LOCATION 

from personnel_basic_info a 

where	1 ".$con;



break;











case 2:

	$report="Schedule Vs Attendance Report";

break;



case 3:

	$report="Over Time Report";

break;





case 4:

	$report="Preset Count Report";

break;









case 30:

	$report="Monthly Attendence Report";

if($_POST['mon']>0&&$_POST['year']>0)

{

	$mon = $_POST['mon'];

	$year = $_POST['year'];

	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department, b.td as total_day,b.od as off_day,b.hd as holy_day, 	b.lt as late_days, 	b.ab as absent_days,b.lv as leave_days,b.pre as present_days, 	b.pay as payable_days,b.ot as over_time_hour FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;

}

		break;

    

	

	case 40:

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

	$mon = $_POST['mon'];

	$year = $_POST['year'];

	$totalDays=date('t',mktime(0,0,0,$mon,01,$year));

	$startDate=$year.'-'.$mon.'-01';

	$endDate=$year.'-'.$mon.'-'.$totalDays;

	

	 $sql="SELECT id, PBI_ID, type, lv_dur, s_date, e_date, total_days, half_or_full, reason, paid_status, leave_join_date, leave_address, leave_mobile_number, leave_responsibility_name, leave_status, note FROM hrm_leave_info where s_date>='".$startDate."' and e_date<='".$endDate."' ".$con." order by id desc";

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

<script type="text/javascript" src="https://mahirgrouperp.com/ddaccordion_new.js"></script>

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

           thead {display: table-header-group;}

       }

.vertical-text div{



  float: left;

}





</style>

<script type="Mhafuz">

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

			if($_POST['report']==777 || $_POST['report']==778){

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

		

		

		

		if($_POST['department']!=''||$_POST['JOB_LOCATION']!='')

		$str 	.= '<h2>';

		

		if($_POST['department']!='') 

		$str 	.= 'Department Name: '.find_a_field('department','DEPT_DESC','DEPT_SHORT_NAME="'.$_POST['department'].'"');



		if($_POST['department']!=''||$_POST['JOB_LOCATION']!='')

		$str 	.= '</h2>';

		$str 	.= '</div>';

		

		if($_POST['PBI_DOMAIN']!='') 

		$str 	.='Section Name: '.$_POST['PBI_DOMAIN'].'<br>';

		

		if($_POST['JOB_LOCATION']!='') 

		$str 	.='Location: '.find_a_field('office_location','LOCATION_NAME','ID="'.$_POST['JOB_LOCATION'].'"').'';

		

		



		

		

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

		



		

	if($_POST['schedule']!='') 

		$str 	.='<p>Schedule: '.find_a_field('hrm_schedule_info','schedule_name','office_start_time="'.$_POST['schedule'].'" 

		and group_for="'.$_SESSION['user']['group'].'"').'</p>';

		

		//$str 	.= '</div><span>Bonus Cut-Off Date:'.find_a_field('salary_bonus','cut_off_date','bonus_type='.$_POST['bonus_type'].' and year='.$_POST['year']).'</span><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		$str 	.= '</div>';

		$str 	.= '<div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';

	














if($_POST['report']==1) {

?>

<table width="100%" class="oe_list_content">

  <thead>

    <tr class="oe_list_header_columns" style="font-size:10px;padding:3px;">

      <th colspan="14"><?=$str?></th>

      </tr>

    <tr class="oe_list_header_columns" style="font-size:10px;padding:3px;">

      <th rowspan="2">SL-1</th>

      <th rowspan="2">Code</th>

      <th rowspan="2">Full Name</th>

      <th rowspan="2">Desg</th>

      <th rowspan="2">Dept</th>

      <th rowspan="2">Section</th>

	  

<? 
while(strtotime($rp1_date) <= strtotime($re_date)){ ?>

<th><?=$rp1_date?></th>
<? $rp1_date = date ("Y-m-d", strtotime("+1 day", strtotime($rp1_date)));} ?>
</tr>
<tr class="oe_list_header_columns" style="font-size:10px;padding:3px;">
<? while(strtotime($rp3_date) <= strtotime($re_date)){ ?>
<th>SCH</th>
<? $rp3_date = date ("Y-m-d", strtotime("+1 day", strtotime($rp3_date)));} ?>
</tr>
</thead>

<style>
@page {
    size: A4;
    margin: 0.5cm;
}


</style>
<tbody>
<?		
$con='';
		if($_POST['designation']>0) 		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];
		if($_POST['department']>0)			$con .=' and a.DEPT_ID='.$_POST['department'];
		if($_POST['sub_dept_id']>0)			$con .=' and a.sub_dept_id='.$_POST['sub_dept_id'];
		if($_POST['unit_id']>0)			$con .=' and a.unit_id='.$_POST['unit_id'];
		if($_POST['sub_unit_id']>0)			$con .=' and a.sub_unit_id='.$_POST['sub_unit_id'];
		
		
		if($_POST['JOB_LOCATION']>0)		$con .=' and a.JOB_LOCATION='.$_POST['JOB_LOCATION'];
		if($_POST['group_for']>0)			$con .=' and a.PBI_ORG='.$_POST['group_for'];
		if($_POST['pbi_in']>0)			    $con .=' and a.PBI_CODE in ('.$_POST['pbi_in'].') ';


//$sub_dept_name=find_all_field_sql("SELECT section_id,section_desc FROM hrm_section");

$s=0;
$sql = "SELECT a.PBI_NAME, a.PBI_ID, a.PBI_DESIGNATION, a.PBI_DEPARTMENT 
        FROM personnel_basic_info a
        WHERE 1 " . $con . " AND a.PBI_JOB_STATUS='In Service' 
        ORDER BY a.PBI_ID";

$query = db_query($sql);
while ($info = mysqli_fetch_object($query)) {
    // Fetch and organize the schedule data for the current employee
    $ros = "SELECT roster_date, shedule_1, point_1 
            FROM hrm_roster_allocation 
            WHERE PBI_ID='" . $info->PBI_ID . "' 
            AND roster_date BETWEEN '" . $r_date . "' AND '" . $re_date . "'";
    
    $ros_r = db_query($ros);
    $schedule_data = []; // Store schedule + point_1 for each date

    while ($roster = mysqli_fetch_object($ros_r)) {
        $schedule_data[$roster->roster_date] = [
            'schedule_id' => $roster->shedule_1,
            'project_id' => $roster->point_1
        ];
    }

    echo "<tr style='font-size:10px; padding:3px;'>";
    echo "<td>" . (++$s) . "</td>";
    echo "<td>" . $info->PBI_ID . "<input type='hidden' name='PBI_ID' id='PBI_ID' value='" . $info->PBI_ID . "' /></td>";
    echo "<td>" . $info->PBI_NAME . "</td>";
    echo "<td>" . $info->PBI_DESIGNATION . "</td>";
    echo "<td>" . $info->PBI_DEPARTMENT . "</td>";
    echo "<td>" . (find_a_field('hrm_section', 'section_desc', 'section_id=' . intval($info->sub_dept_id)) ?? 'No data') . "</td>";

    // Loop through each date in the schedule range
    $rp2_date = $r_date;
    while (strtotime($rp2_date) <= strtotime($re_date)) {
        echo "<td>";
        if (isset($schedule_data[$rp2_date])) {
            $schedule_id = $schedule_data[$rp2_date]['schedule_id'];
            $project_id = $schedule_data[$rp2_date]['project_id'];

            $schedule_name = find_a_field('hrm_schedule_info', 'schedule_name', 'id=' . intval($schedule_id));
            $project_name = find_a_field('crm_project_org', 'name', 'id=' . intval($project_id));

            echo $schedule_name . ' - ' . $project_name;
        } else {
            echo "-";
        }
        echo "</td>";

        $rp2_date = date("Y-m-d", strtotime("+1 day", strtotime($rp2_date)));
    }

    echo "</tr>";
}


?>
	
	

  </tbody>

</table>

<?

}



if($_POST['report']==770) 

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



if($_POST['report']==77) 

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

$sqld = 'select 

t.basic_salary actual_basic_salary,

t.special_allowance actual_special_allawance, 

t.*,a.PBI_ID,a.PBI_NAME,d.DESG_SHORT_NAME PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ,  t.pbi_held_up held_up_status,s.cash_bank,s.cash



from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID '.$con.' 

order by a.PBI_ID';

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

  <td><?=number_format($data->actual_special_allawance)?><? $total_actual_special_allawance = $total_actual_special_allawance + $data->actual_special_allawance;?></td>

  <td><?=number_format($data->ta_da_data)?><? $total_ta_da_data = $total_ta_da_data + $data->ta_da_data;?></td>

  <td><?=number_format($data->basic_salary_payable)?><? $total_basic_salary_payable = $total_basic_salary_payable + $data->basic_salary_payable;?></td>

  <td><?=number_format($data->spl_alw_data)?><? $total_spl_alw_data = $total_spl_alw_data + $data->spl_alw_data;?></td>

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

  <td><strong><?=$total_actual_special_allawance;?></strong></td>

  <td><strong><?=$total_ta_da_data;?></strong></td>

  <td><strong><?=(int)$total_basic_salary_payable;?></strong></td>

  <td><strong><?=$total_spl_alw_data;?></strong></td>

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









if($_POST['report']==3){  // over time roster report



?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead><tr><th style="border:0px;" colspan="6"><?=$str?>



<center>Date Interval: <?=$_POST['roster_date'];?> to <?=$_POST['roster_date2'];?></center></th></tr>



<tr>

  <th>S/L</th>

  <th>Department</th>

  <th>Section</th>

  <th>CODE</th>

  <th>Full Name</th>

  <th>Designation</th>

  

  <th bgcolor="#FF66FF">OT </th>

  </tr>

</thead>

<tbody>

<?

$roster_date = $_POST['roster_date'];

$roster_date2 = $_POST['roster_date2'];

if($_POST['pbi_in']!='')

$pbi_con = ' and a.PBI_ID in ('.$_POST['pbi_in'].')';



$sqld = 'select 

sum(t.ot) ot,a.PBI_ID,a.PBI_NAME,a.PBI_GROUP,d.DESG_SHORT_NAME PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ, a.PBI_DOMAIN



from  hrm_att_summary2 t, personnel_basic_info a, designation d

where  d.DESG_ID=a.DESG_ID and t.att_date between "'.$roster_date.'"  and "'.$roster_date2.'" 

and t.emp_id=a.PBI_ID 

'.$con.$schedule_con.$pbi_con.' 



group by a.PBI_ID

order by a.PBI_DEPARTMENT,a.PBI_DOMAIN,a.PBI_ID

';



$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){

$entry_by=$data->entry_by;

?>

<tr><td><?=++$s?></td>

<td><?=$data->PBI_DEPARTMENT?></td>

<td><?=$data->PBI_DOMAIN?></td>

<td>

<a target="_blank" href="?submit=1&report=2&pbi_in=<?=$data->PBI_ID?>&roster_date=<?=$_REQUEST['roster_date']?>&roster_date2=<?=$_REQUEST['roster_date2']?>">

<?=$data->PBI_ID?></a></td>

<td><?=$data->PBI_NAME?></td>

  <td><?=$data->PBI_DESIGNATION?></td>

  <td><?=$data->ot;?></td>

  </tr>

<? } ?>

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





if($_REQUEST['report']==2){  // schedule vs attendance report



if($_POST['schedule']!='') $schedule_con =' and t.sch_in_time = "'.$_POST['schedule'].'"';

$company=find_a_field('user_group','group_name','id='.$_SESSION['user']['group']);



$roster_date = $_REQUEST['roster_date'];

$roster_date2 = $_REQUEST['roster_date2'];

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead><tr><th style="border:0px;" colspan="11"><center><h1><? echo $company;?></h1><h2>Schedule Vs Attendance Report</h2>

Date Interval: <?=$roster_date;?> to <?=$roster_date2;?>&nbsp;&nbsp;

Reporting Time: <?=date("h:i A d-m-Y"); ?>

</center></th></tr>



<tr>

  <th>S/L-2</th>

  <th>Department</th>

  <th>Section</th>

  <th>CODE</th>

  <th>Full Name</th>

  <th>Designation</th>

  <th>Date</th>

  

  <th bgcolor="#66CC99">IN SCH</th>

  <th bgcolor="#66CC99">IN Time </th>

  <th bgcolor="#66CC99">Status</th>

  <th bgcolor="#FF66FF">OUT  SCH</th>

  <th bgcolor="#FF66FF">OUT Time </th>

  <th bgcolor="#FF66FF">OT </th>

  <th bgcolor="#FF66FF">Status</th>

  </tr>

</thead>

<style>
h1{
margin-top: 23px !important;
padding-left: 230px !important;
}

h2{
	padding-left: 238px !important;
}


@media print {
    h1 {
        padding-left: 140px !important;
    }
	
	h2{
	   padding-left: 150px !important;
	}
}

</style>

<tbody>

<?





if($_REQUEST['pbi_in']!='')

$pbi_con = ' and a.PBI_ID in ('.$_REQUEST['pbi_in'].')';



$sqld = 'select 

t.*,a.PBI_ID,a.PBI_NAME,a.PBI_GROUP,d.DESG_SHORT_NAME PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ, a.PBI_DOMAIN



from  hrm_att_summary2 t, personnel_basic_info a, designation d

where  d.DESG_ID=a.DESG_ID and t.att_date between "'.$roster_date.'"  and "'.$roster_date2.'" 

and t.emp_id=a.PBI_ID 

'.$con.$schedule_con.$pbi_con.' 

order by a.PBI_DEPARTMENT,a.PBI_DOMAIN,a.PBI_ID,t.att_date

';



$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){

$entry_by=$data->entry_by;

?>

<tr><td><?=++$s?></td>

<td><?=$data->PBI_DEPARTMENT?></td>

<td><?=$data->PBI_DOMAIN?></td>

<td><?=$data->PBI_ID?></td>

<td><?=$data->PBI_NAME?></td>

<td><?=$data->PBI_DESIGNATION?></td>

<td><?=$data->att_date?></td>

  

  <td><?=$data->sch_in_time?></td>

  <td><? $in_sch = $data->att_date.' '.$data->sch_in_time; $in = explode(' ',$data->in_time); echo $in[1];?></td>

  <td><? if((strtotime($in_sch) - strtotime($data->in_time))>0) echo '<font color="#009900">Regular</font>'; else echo '<font color="#FF0000">Late</font>'; ?></td>

  <td><?=$data->sch_out_time?></td>

  <td><? $out_sch = $data->att_date.' '.$data->sch_out_time; $out = explode(' ',$data->out_time); echo $out[1];?></td>

  

  <td><?=$data->ot; $tot +=$data->ot;?></td>

  

  <td><? if((strtotime($data->out_time) - strtotime($out_sch))>0) echo '<font color="#009900">Regular</font>'; else echo '<font color="#FF0000">Early</font>'; ?></td>

  </tr>

<? } ?>

<tr>

  <td colspan="12"><div align="right"><strong>Total OT </strong></div></td>

  <td bgcolor="#00FFFF"><strong>

    <?=$tot; ?>

  </strong></td>

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







if($_REQUEST['report']==4){  // schedule vs attendance report



if($_POST['schedule']!='') $schedule_con =' and t.sch_in_time = "'.$_POST['schedule'].'"';

$company=find_a_field('user_group','group_name','id='.$_SESSION['user']['group']);



$roster_date = $_REQUEST['roster_date'];

$roster_date2 = $_REQUEST['roster_date2'];

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead><tr><th style="border:0px;" colspan="11"><center><h1><? echo $company;?></h1>

<h2>Summery Attendance Report</h2>

Date Interval: <?=$roster_date;?> to <?=$roster_date2;?>&nbsp;&nbsp;

Reporting Time: <?=date("h:i A d-m-Y"); ?>

</center></th></tr>



<tr>

  <th>S/L</th>

  <th>Department</th>

  <th>Section</th>

  <th>CODE</th>

  <th>Full Name</th>

  <th>Designation</th>

  <th>Present</th>



  </tr>

</thead>

<tbody>

<?





if($_REQUEST['pbi_in']!='')

$pbi_con = ' and a.PBI_ID in ('.$_REQUEST['pbi_in'].')';



$sqld = 'select 

t.*,a.PBI_ID,a.PBI_NAME,a.PBI_GROUP,d.DESG_SHORT_NAME PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ, a.PBI_DOMAIN, count(id) as pre



from  hrm_att_summary2 t, personnel_basic_info a, designation d

where  d.DESG_ID=a.DESG_ID and t.att_date between "'.$roster_date.'"  and "'.$roster_date2.'" 

and t.emp_id=a.PBI_ID 

'.$con.$schedule_con.$pbi_con.' 

group by emp_id

order by a.PBI_DEPARTMENT,a.PBI_DOMAIN,a.PBI_DOMAIN,a.PBI_ID

';



$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){

$entry_by=$data->entry_by;

?>

<tr><td><?=++$s?></td>

<td><?=$data->PBI_DEPARTMENT?></td>

<td><?=$data->PBI_DOMAIN?></td>

<td><?=$data->PBI_ID?></td>

<td><?=$data->PBI_NAME?></td>

<td><?=$data->PBI_DESIGNATION?></td>

<td><?=$data->pre?></td>

  </tr>

<? } ?>

</tbody></table>

<?

}







if($_POST['report']==7811) 

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

if($_POST['report']==782) 

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

if($_POST['report']==78) // Salary Payroll Report Final

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

if($_POST['report']==783) 

{





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

if($_POST['report']==780) 

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

  <? echo number_format(0);?>



  <? echo $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)/4','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_help_up_paid = $total_help_up_paid + $help_up_paid;?>

  <? echo $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)/4','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_cash_payment = $total_cash_payment + $cash_paid; ?>

  

  <? echo $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)/4','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ' ); $total_bank_payment_dbbl = $total_bank_payment_dbbl + $dbbl_paid;?>

  

  <? echo $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)/4','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_bank_payment_ibbl = $total_bank_payment_ibbl + $ibbl_paid;?>

  

<?php  $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)/4','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_net_payable = $total_net_payable + $net_payable;?>



<?

}

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



if($_POST['report']==7809) 

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



if($_POST['report']==7804) 

{



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





  <?  $help_up_paid = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)/4','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_14_help_up_paid = $total_14_help_up_paid + $help_up_paid;?>

  <?  $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)/4','t.pbi_held_up=1 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_14_cash_payment = $total_14_cash_payment + $cash_paid; ?>

  

  <?  $dbbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)/4','t.pbi_held_up=0 and s.cash_bank="DBBL" and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ' ); $total_14_bank_payment_dbbl = $total_14_bank_payment_dbbl + $dbbl_paid;?>

  

  <?  $ibbl_paid=find_a_field('salary_attendence t,personnel_basic_info a,salary_info s ','sum(t.bank_paid)/4','t.pbi_held_up=0 and s.cash_bank="IBBL" and t.PBI_ID=a.PBI_ID t.PBI_ID=s.PBI_ID and and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '); $total_14_bank_payment_ibbl = $total_14_bank_payment_ibbl + $ibbl_paid;?>

  

<?php  $net_payable = find_a_field('salary_attendence t,personnel_basic_info a ','sum(total_payable)/4','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_region =0 and a.PBI_GROUP="" and t.pbi_department="Sales"  and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' ');$total_14_net_payable = $total_14_net_payable + $net_payable;?>



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

<td><strong><?=$total_14_actual_basic_salary+$total_D_actual_basic_salary;?></strong></td>

<td><strong><?=$total_14_actual_special_allawance+$total_D_actual_special_allawance;?></strong></td>

<td><strong><?=$total_14_ta_da_data+$total_D_ta_da_data;?></strong></td>

<td><strong><?=(int)($total_14_basic_salary_payable+$total_D_basic_salary_payable);?></strong></td>

<td><strong><?=($total_14_spl_alw_data+$total_D_spl_alw_data);?></strong></td>

<td><strong><?=($total_14_ta_da+$total_D_ta_da);?></strong></td>

<td><strong><?=($total_14_house_rent+$total_D_house_rent);?></strong></td>

<td><strong><?=($total_14_vehicle_allowance+$total_D_vehicle_allowance);?></strong></td>

<td><strong><?=($total_14_food_allowance+$total_D_food_allowance);?></strong></td>

<td><strong><?=($total_14_mobile_allowance+$total_D_mobile_allowance);?></strong></td>

<td><strong><?=($total_14_benefits+$total_D_benefits);?></strong></td>

<td><strong><?=($total_14_other_benefits+$total_D_other_benefits);?></strong></td>

<td><strong><?=($total_14_income_tax+$total_D_income_tax);?></strong></td>

<td><strong><?=($total_14_advance_install+$total_D_advance_install);?></strong></td>

<td><strong><?=($total_14_cooperative_share+$total_D_cooperative_share);?></strong></td>

<td><strong><?=($total_14_motorcycle_install+$total_D_motorcycle_install);?></strong></td>

<td><strong><?=($total_14_deduction+$total_D_deduction);?></strong></td>

<td>&nbsp;</td>

<td><?=($total_14_help_up_paid+$total_D_help_up_paid)?></td>

<td><strong><?=($total_14_cash_payment+$total_D_cash_payment)?></strong></td>

<td><?=($total_14_bank_payment_dbbl+$total_D_bank_payment_dbbl)?></td>

<td><?=($total_14_bank_payment_ibbl+$total_D_bank_payment_ibbl)?></td>

<td><strong><?=($total_14_net_payable+$total_D_net_payable)?></strong></td>

<td>&nbsp;</td>

<td>&nbsp;</td>

<td>&nbsp;</td>

<td>&nbsp;</td>

<td style="color:#FF0000; font-weight:bold">&nbsp;</td>

</tr>



<tr>

  <td colspan="2">&nbsp;</td>

  <td><strong>

    <?=($total_14_actual_basic_salary*4)+$total_A_actual_basic_salary+$total_B_actual_basic_salary+$total_C_actual_basic_salary+$total_D_actual_basic_salary;?>

  </strong></td>

  <td><strong>

    <?=($total_14_actual_special_allawance*4)+$total_A_actual_special_allawance+$total_B_actual_special_allawance+$total_C_actual_special_allawance+$total_D_actual_special_allawance;?>

  </strong></td>

  <td><strong>

    <?=($total_14_ta_da_data*4)+$total_A_ta_da_data+$total_B_ta_da_data+$total_C_ta_da_data+$total_D_ta_da_data;?>

  </strong></td>

  <td><strong>

    <?=((int)($total_14_basic_salary_payable*4)+$total_A_basic_salary_payable+$total_B_basic_salary_payable+$total_C_basic_salary_payable+$total_D_basic_salary_payable);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_spl_alw_data*4)+$total_A_spl_alw_data+$total_B_spl_alw_data+$total_C_spl_alw_data+$total_D_spl_alw_data);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_ta_da*4)+$total_A_ta_da+$total_B_ta_da+$total_C_ta_da+$total_D_ta_da);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_house_rent*4)+$total_A_house_rent+$total_B_house_rent+$total_C_house_rent+$total_D_house_rent);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_vehicle_allowance*4)+$total_A_vehicle_allowance+$total_B_vehicle_allowance+$total_C_vehicle_allowance+$total_D_vehicle_allowance);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_food_allowance*4)+$total_A_food_allowance+$total_B_food_allowance+$total_C_food_allowance+$total_D_food_allowance);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_mobile_allowance*4)+$total_A_mobile_allowance+$total_B_mobile_allowance+$total_C_mobile_allowance+$total_D_mobile_allowance);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_benefits*4)+$total_A_benefits+$total_B_benefits+$total_C_benefits+$total_D_benefits);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_other_benefits*4)+$total_A_other_benefits+$total_B_other_benefits+$total_C_other_benefits+$total_D_other_benefits);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_income_tax*4)+$total_A_income_tax+$total_B_income_tax+$total_C_income_tax+$total_D_income_tax);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_advance_install*4)+$total_A_advance_install+$total_B_advance_install+$total_C_advance_install+$total_D_advance_install);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_cooperative_share*4)+$total_A_cooperative_share+$total_B_cooperative_share+$total_C_cooperative_share+$total_D_cooperative_share);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_motorcycle_install*4)+$total_A_motorcycle_install+$total_B_motorcycle_install+$total_C_motorcycle_install+$total_D_motorcycle_install);?>

  </strong></td>

  <td><strong>

    <?=(($total_14_deduction*4)+$total_A_deduction+$total_B_deduction+$total_C_deduction+$total_D_deduction);?>

  </strong></td>

  <td>&nbsp;</td>

  <td><?=(($total_14_help_up_paid*4)+$total_A_help_up_paid+$total_B_help_up_paid+$total_C_help_up_paid+$total_D_help_up_paid)?></td>

  <td><strong><?=(($total_14_cash_payment*4)+$total_A_cash_payment+$total_B_cash_payment+$total_C_cash_payment+$total_D_cash_payment)?>

  </strong></td>

  <td><?=(($total_14_bank_payment_dbbl*4)+$total_A_bank_payment_dbbl+$total_B_bank_payment_dbbl+$total_C_bank_payment_dbbl+$total_D_bank_payment_dbbl)?></td>

  <td><?=(($total_14_bank_payment_ibbl*4)+$total_A_bank_payment_ibbl+$total_B_bank_payment_ibbl+$total_C_bank_payment_ibbl+$total_D_bank_payment_ibbl)?></td>

  <td><strong><?=(($total_14_net_payable*4)+$total_A_net_payable+$total_B_net_payable+$total_C_net_payable+$total_D_net_payable)?></strong></td>

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

if($_POST['report']==7801) 

{



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

if($_POST['report']==7800) 

{



?>

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="27"><?=$str?></th></tr>



<tr>



<th rowspan="3">S/L</th>

<th rowspan="3">Store Name</th>

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

$sqld = 'select a.JOB_LOCATION,o.LOCATION_NAME,

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



from  salary_attendence t, personnel_basic_info a, designation d, salary_info s,office_location o where o.ID=a.JOB_LOCATION and d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and a.PBI_DEPARTMENT like "%STO%" '.$DEPARTMENT_con.' group by a.JOB_LOCATION';

$queryd=db_query($sqld);



while($data = mysqli_fetch_object($queryd)){

$entry_by=$data->entry_by;

?>

<tr><td><?=++$s?></td>

<td><?=$data->LOCATION_NAME?></td>

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

if($_POST['report']==784) 

{



?>

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="27"><?=$str?></th></tr>



<tr>



<th rowspan="3">S/L</th>

<th rowspan="3">Department</th>

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

if($_POST['report']==7841) 

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



from  salary_attendence t, personnel_basic_info a, designation d, salary_info s where d.DESG_ID=t.pbi_designation and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and PBI_ORG in (1,2) and t.pbi_department not in ("STO", "Store (Transport)") and t.pbi_department !="Admin (Support Service Section)" and t.pbi_region =0 group by t.pbi_department';

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

if($_POST['report']==78411) 

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

  <th>Other</th>

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

if($_POST['report']==78412) 

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

if($_POST['report']==7842) 

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

elseif($_POST['report']==79)

{



$sql22="SELECT a.*,b.*,p.DEPT_DESC, d.DESG_SHORT_NAME

FROM personnel_basic_info a, salary_attendence b, department p, designation d

WHERE a.PBI_ID = b.PBI_ID

AND held_up_status != 'Yes'

AND b.pbi_department=p.DEPT_SHORT_NAME

AND b.pbi_designation = d.DESG_ID and b.cash_paid>0 and b.mon='".$mon."' and b.year='".$year."' ".$con." order by b.total_salary desc";

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









if($_POST['report']==8) 

{





$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,a.PBI_GROUP as `Group`,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,

(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_EDU_QUALIFICATION as qualification,a.PBI_MOBILE as mobile  from personnel_basic_info a where	1 ".$con;

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

      <input name="mobile#<?=$datas[11]?>" type="text" id="mobile#<?=$datas[11]?>" value="<?=$datas[11]?>" /></td>

  <td>

  <div id="po<?=$datas[0]?>">

 <input type="button" name="Change" value="Change" onClick="getData2('<?=$ajax_page?>', 'po<?=$datas[0]?>',document.getElementById('PBI_ID#<?=$datas[0]?>').value,document.getElementById('mobile#<?=$datas[11]?>').value);" />

 </div>

 </td></tr>

 

 

 

 

 

 

 

<?

}

?></tbody></table>

<?

}



elseif($_POST['report']==301){ // Leave Encashment Report



$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);

?>

<center>

  <h1><?=$company?></h1><strong>Leave Report-2021</strong><br>Department: <?=$_POST['department'] ?><br>

  

</center>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr><th style="border:0px;" colspan="7"></th></tr>



<tr>

  <th>S/L-301</th>

  <th>CODE</th>

  <th>Full Name</th>

  <th>Designation</th>

  <th>Department</th>

  <th>Joining Date</th>

  <th>Conf Date</th>

  <th>Bank Acc </th>

  <th>Leave Quota</th>

  <th>Leave Consume(Salary Table)</th>

  <th>Balance</th>

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



WHERE a.PBI_ID=t.PBI_ID and t.year='2021' AND a.PBI_JOB_STATUS != 'Not In Service'

and a.JOB_LOCATION not in(1)

".$con."group by a.PBI_ID";





$d22=date("2021-12-31");

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

  <td><?=$data->confirmation_date?></td>

  <td><?=$data->bank?></td>

  <td><?php 

if($data->confirmation_date1 > date("2020-12-25") &&  $data->confirmation_date1 !='0000-00-00'){

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



}elseif($data->confirmation_date1 < date("2021-12-26") &&  $data->confirmation_date1 !='0000-00-00'){

$total_leave = 30; echo $total_leave;

}elseif($data->confirmation_date1 ='0000-00-00'){$total_leave=0; echo $total_leave;

}

?></td>

  <td><?=$data->leave_consumed?></td>

  <td><?php $lc=($total_leave - ($data->leave_consumed)); echo $lc;?></td>

</tr>

<? } ?>

</tbody></table>

<?

}





elseif($_POST['report']==302){ // Leave Encashment Report



$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);

?>

<center>

  <h1><?=$company?></h1>

  <strong>Leave Report-2020</strong><br>

  Department: <?=$_POST['department'] ?><br>

  

</center>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr><th style="border:0px;" colspan="7"></th></tr>



<tr>

  <th>S/L-302</th>

  <th>CODE</th>

  <th>Full Name</th>

  <th>Designation</th>

  <th>Department</th>

  <th>Joining Date</th>

  <th>Conf Date</th>

  <th>Bank Acc </th>

  <th>Leave Quota</th>

  <th>Leave Consume(Salary Table)</th>

  <th>Balance</th>

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



WHERE a.PBI_ID=t.PBI_ID and t.year='2020' AND a.PBI_JOB_STATUS != 'Not In Service'

and a.JOB_LOCATION not in(1)

".$con."group by a.PBI_ID";





$d22=date("2020-12-31");

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

  <td><?=$data->confirmation_date?></td>

  <td><?=$data->bank?></td>

  <td><?php 

if($data->confirmation_date1 > date("2019-12-25") &&  $data->confirmation_date1 !='0000-00-00'){

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



}elseif($data->confirmation_date1 < date("2019-12-26") &&  $data->confirmation_date1 !='0000-00-00'){

$total_leave = 30; echo $total_leave;

}elseif($data->confirmation_date1 ='0000-00-00'){$total_leave=0; echo $total_leave;

}

?></td>

  <td><?=$data->leave_consumed?></td>

  <td><?php $lc=($total_leave - ($data->leave_consumed)); echo $lc;?></td>

</tr>

<? } ?>

</tbody></table>

<?

}





elseif($_POST['report']==2025) 

{



?>

<table width="70%" cellspacing="0" cellpadding="2" border="0" style="margin:auto;"><thead><tr><th style="border:0px;" colspan="21"><?=$str?></th></tr>

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

if($_POST['PBI_ID'] != ''){ $pbi_con = " and p.PBI_CODE='".$_POST['PBI_ID']. "' "; } 

if($_POST['department']>0){ $pbi_con .= " and p.DEPT_ID='".$_POST['department']. "' "; } 

$startDate = $_POST['roster_date'];

$endDate = $_POST['roster_date2'];

$roster_sql="select h.*,s.schedule_name,s.office_start_time,s.office_end_time,p.PBI_CODE,p.PBI_NAME,p.PBI_DEPARTMENT 
 
from hrm_roster_allocation h, personnel_basic_info p, hrm_schedule_info s 
 
where s.id=h.shedule_1 and p.PBI_ID=h.PBI_ID and h.roster_date between '".$startDate."' and '".$endDate."' ".$pbi_con." ";

$roster_query=db_query($roster_sql);

while($roster = mysqli_fetch_object($roster_query)){

?>

<tr>

<td><?=++$i;?></td>

<td><?=$roster->PBI_CODE?></td>

<td><?=$roster->PBI_NAME?></td>

<td><?=$roster->PBI_DEPARTMENT?></td>

<td><?=$roster->roster_date?></td>

<td><?=$roster->schedule_name?></td>

<td><?=$roster->office_start_time?></td>

<td><?=$roster->office_end_time?></td>

</tr>

<? } ?>

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

elseif(isset($sql)&&$sql!='') {}

?>







</div></div>



</form>

</body>

</html>