<?php



//



//




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



require_once "../../../controllers/core/class.numbertoword.php";



date_default_timezone_set('Asia/Dhaka');if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0){


$group = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');




	if($_POST['name']!='')







	$con.=' and a.PBI_NAME like "%'.$_POST['name'].'%"';



	if($_POST['PBI_ORG']!='')	$con.=' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';







	if($_POST['department']!='')







	$con.=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';	if($_POST['project']!='')



	$con.=' and a.PBI_PROJECT = "'.$_POST['project'].'"';







	if($_POST['designation']!='')	$con.=' and a.PBI_DESIGNATION = "'.$_POST['designation'].'"';



	if($_POST['zone']!='')







	$con.=' and a.PBI_ZONE = "'.$_POST['zone'].'"';



	if($_POST['JOB_LOCATION']!='')	$con.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';	if($_POST['PBI_GROUP']!='')



	$con.=' and a.PBI_GROUP = "'.$_POST['PBI_GROUP'].'"';







	if($_POST['area']!='')



	$con.=' and a.PBI_AREA = "'.$_POST['area'].'"';



	if($_POST['branch']!='')



	$con.=' and a.PBI_BRANCH = "'.$_POST['branch'].'"';	if($_POST['job_status']!='')



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



	if($_POST['department']!='')



	$depts = find_a_field('department','DEPT_DESC','DEPT_ID='.$_POST['department'] );



	if($_POST['bonus_type']!=''){



		if($_POST['bonus_type']==2)



			$bonusName = 'Eid-Ul Adha';



		else



			$bonusName = 'Eid-Ul Fitre';



	}



switch ($_POST['report']) {







	case 1:
    $report="Employee Basic Information";
	break;
	
	case 999:
    $report="Progress Report";
	break;



	case 10001:



	$report="Employee Details Information";







	$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,a.PBI_DEPARTMENT as department,a.PBI_GROUP as `Group`,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,(select group_name from user_group where id=a.PBI_ORG) as Company ,(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_EDU_QUALIFICATION as qualification,a.PBI_MOBILE as mobile,PBI_JOB_STATUS job_status,JOB_LOCATION from personnel_basic_info a where	1 ".$con." order by a.PBI_DOJ asc";



	break;







	case 2:



	$report="Employee Salary Information";







	 $sql="select a.PBI_ID as CODE, a.PBI_NAME as Name,



	(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,



	(select if(DEPT_DESC='NO DEPARTMENT','',DEPT_DESC) from department where DEPT_ID=a.PBI_DEPARTMENT) as department,



 DATE_FORMAT(a.PBI_DOJ,'%d-%b-%Y') as joining_date,a.PBI_DOJ as total_service_length,	b.gross_salary, b.basic_salary, b.house_rent, b.medical_allowance, b.special_allowance as conveyance, b.food_allowance, b.transport_allowance,b.card_no as payroll_card_no,b.cash as Bank_account_no from personnel_basic_info a,salary_info b where	a.PBI_ID=b.PBI_ID ".$con." order by a.PBI_DOJ asc";



	break;







    case 3:



	$report="Monthly Attendence Report";



if($_POST['mon']>0&&$_POST['year']>0)



{



	$mon = $_POST['mon'];



	$year = $_POST['year'];



    $sql="SELECT a.PBI_ID as ID,a.PBI_NAME as Name, g.DESG_DESC as designation, if(d.DEPT_DESC='NO DEPARTMENT','',d.DEPT_DESC) as department,  b.td as total_day,b.od as off_day,b.hd as holiday, 	b.lt as late_days, 	b.ab as absent_days,b.lv as leave_days,b.pre as present_days, 	b.pay as payable_days FROM personnel_basic_info a,salary_attendence b, designation g, department d where a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_DESIGNATION=g.DESG_ID and a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DOJ asc";



}



		break;



    case 4:



		$report="Over Time Report";



if($_POST['mon']>0&&$_POST['year']>0)



{



	$mon = $_POST['mon'];



	$year = $_POST['year'];



	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department, b.ot as over_time_hour,(b.total_salary/208) as rate,b.over_time_amount FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DOJ asc";



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



	b.basic_salary,b.total_salary as consolidated_salary,b.house_rent,b.medical_allowance,b.other_allowance,b.special_allowance,b.ta_da as TA_DA, b.food_allowance as fooding, b.mobile_allowance,b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction,b.total_benefits,b.total_payable*(1.00) as total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DOJ asc";



}



		break;







    case 6:



				$report="Salary Payroll Report (Summary)";



if($_POST['mon']>0&&$_POST['year']>0)



{



	$mon = $_POST['mon'];



	$year = $_POST['year'];



	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,



	b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction,b.total_benefits,b.total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DOJ asc";



}



break;



	case 7:



	$report="Salary Payroll Report";



	break;







	case 77:



	$report="Salary Payroll Report Final (Field)";



	break;







	case 78:



	$report="Salary Sheet for the Month of ".date('F Y',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))." <br> ".$depts;



	break;







	case 776:



	$report="Salary Sheet for the Month of ".date('F Y',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))." <br> ".$depts;



	break;







	case 788:



	$report="Salary Advice Bank Account for the Month of ".date('F Y',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))." <br> ".$depts;



	break;







	case 789:



	$report="Salary Advice Payroll Card for the Month of ".date('F Y',mktime(0,0,0,$_POST['mon'],01,$_POST['year']))." <br> ".$depts;



	break;







	case 777:



	$report="Festival Bonus Report of ".$bonusName." <br> ".$depts;



	break;







	case 778:



	$report="Festival Bonus Bank Account of ".$bonusName." <br> ".$depts;



	break;







	case 779:



	$report="Festival Bonus Payroll Card of ".$bonusName." <br> ".$depts;



	break;







	case 232:



	$report="Performance Appraisal Summary";



	break;







	case 781:



	$report="".$depts;



	break;







	case 8:



	$report="Staff Mobile Information(Changable)";



	break;







case 66:



$report="Salary Payroll Report (Final)";



if($_POST['mon']>0&&$_POST['year']>0)



{



	$mon = $_POST['mon'];



	$year = $_POST['year'];



	  $sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,b.od,b.hd,b.lt,b.ab,b.lv,b.pre,b.pay,



	b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction, (b.total_salary-b.total_deduction) as actual_salary, b.total_benefits,b.total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DOJ asc";



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



		break;// COMMISION REPORTS



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



         $sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_SEX as Gender,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.PBI_PROJECT as project	,a.PBI_DESIGNATION as designation ,a.PBI_DESG_GRADE as grade,a.PBI_ZONE as zone,a.PBI_AREA as area,a.PBI_BRANCH as branch,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,b.APR_YEAR,b.APR_MARKS,(select avg(APR_MARKS) from apr_detail where APR_YEAR in (".$year.",".($year-1).",".($year-2).") and PBI_ID=a.PBI_ID) as avg_marks,b.APR_STATUS,b.APR_RESULT  from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID ".$con." order by a.PBI_DOJ asc";



		break;case 1001:



$report="Sales Channel Parter(SCP) Information";



if($_POST['dealer_name_e']!='')



$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';



if($_POST['dealer_code']!='')



$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';







if($_POST['division_code']!='')



$con.=' and a.division_code = "'.$_POST['division_code'].'"';



elseif($_POST['district_code']!='')



$con.=' and a.district_code = "'.$_POST['district_code'].'"';



elseif($_POST['thana_code']!='')



$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';if($_POST['region_code']!='')



$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['region_code'].'") ';



elseif($_POST['zone_code']!='')



$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['area_code']!='')



$con.=' and a.area_code = "'.$_POST['area_code'].'"';if($_POST['canceled']!='')



$con.=' and a.canceled = "'.$_POST['canceled'].'"';



if($_POST['depot']!='')



$con.=' and a.depot = "'.$_POST['depot'].'"';







if($_POST['product_group']!='')



$con.=' and a.product_group = "'.$_POST['product_group'].'"';



if($_POST['mobile_no']!='')



$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';if($_POST['team_name']!='')



$con.=' and a.team_name = "'.$_POST['team_name'].'"';







    $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.mobile_no as mobile_no,a.propritor_name_e as propritor_name ,a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, sr.SUB_REGION_NAME as sub_region, r.BRANCH_NAME as region, a.canceled as active, a.commission from dealer_info a, area ar, zon z, sub_region sr, branch r



		 where a.area_code=ar.AREA_CODE and ar.ZONE_ID=z.ZONE_CODE and z.REGION_ID=sr.SUB_REGION_CODE and sr.REGION_ID=r.BRANCH_ID and a.dealer_type='Sales Channel Parter(SCP)'  ".$con." order by a.PBI_DOJ asc"." order by a.dealer_code desc";		break;







case 1002:



$report="Project Information";



if($_POST['dealer_name_e']!='')



$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';



if($_POST['dealer_code']!='')



$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';







if($_POST['division_code']!='')



$con.=' and a.division_code = "'.$_POST['division_code'].'"';



elseif($_POST['district_code']!='')



$con.=' and a.district_code = "'.$_POST['district_code'].'"';



elseif($_POST['thana_code']!='')



$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';if($_POST['region_code']!='')



$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['zone_code']!='')



$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['area_code']!='')



$con.=' and a.area_code = "'.$_POST['area_code'].'"';if($_POST['canceled']!='')



$con.=' and a.canceled = "'.$_POST['canceled'].'"';



if($_POST['depot']!='')



$con.=' and a.depot = "'.$_POST['depot'].'"';







if($_POST['product_group']!='')



$con.=' and a.product_group = "'.$_POST['product_group'].'"';



if($_POST['depot']!='')



$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';if($_POST['team_name']!='')



$con.=' and a.team_name = "'.$_POST['team_name'].'"';		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.mobile_no as mobile_no,a.propritor_name_e as propritor_name ,a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, r.BRANCH_NAME as region, a.canceled as active, a.commission from dealer_info a, area ar, zon z, branch r



		 where ar.AREA_CODE=a.area_code and z.ZONE_CODE=ar.ZONE_ID and r.BRANCH_ID=z.REGION_ID and a.dealer_type='Project'  ".$con." order by a.PBI_DOJ asc";







		break;case 1003:



$report="Corporate Customer Information";if($_POST['dealer_name_e']!='')$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';if($_POST['dealer_code']!='')



$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';



if($_POST['division_code']!='')



$con.=' and a.division_code = "'.$_POST['division_code'].'"';



elseif($_POST['district_code']!='')



$con.=' and a.district_code = "'.$_POST['district_code'].'"';



elseif($_POST['thana_code']!='')



$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';



if($_POST['region_code']!='')$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';elseif($_POST['zone_code']!='')



$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['area_code']!='')



$con.=' and a.area_code = "'.$_POST['area_code'].'"';



if($_POST['canceled']!='')



$con.=' and a.canceled = "'.$_POST['canceled'].'"';







if($_POST['depot']!='')



$con.=' and a.depot = "'.$_POST['depot'].'"';if($_POST['product_group']!='')



$con.=' and a.product_group = "'.$_POST['product_group'].'"';if($_POST['depot']!='')



$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';



if($_POST['team_name']!='')



$con.=' and a.team_name = "'.$_POST['team_name'].'"';



		 		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as customer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,(select sum(dr_amt-cr_amt) from journal where ledger_id=a.account_code) as closing_balance,a.mobile_no as mobile_no,a.dealer_name_b as designation , a.propritor_name_b as contact_person , a.address_e as address, a.canceled as active, a.commission from dealer_info a



		 where a.dealer_type='Corporate'  ".$con."  order by a.dealer_code asc";



		// , area ar, zon z, branch r;		 //,a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, r.BRANCH_NAME as region;







		 //ar.AREA_CODE=a.area_code and z.ZONE_CODE=ar.ZONE_ID and r.BRANCH_ID=z.REGION_ID;







		break;



		case 10044:



$report="Direct Sales(DS) Customer Information";



if($_POST['dealer_name_e']!='')



$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';



if($_POST['dealer_code']!='')



$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';







if($_POST['division_code']!='')



$con.=' and a.division_code = "'.$_POST['division_code'].'"';



elseif($_POST['district_code']!='')



$con.=' and a.district_code = "'.$_POST['district_code'].'"';



elseif($_POST['thana_code']!='')



$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';if($_POST['region_code']!='')



$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['zone_code']!='')



$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['area_code']!='')



$con.=' and a.area_code = "'.$_POST['area_code'].'"';if($_POST['canceled']!='')



$con.=' and a.canceled = "'.$_POST['canceled'].'"';



if($_POST['depot']!='')



$con.=' and a.depot = "'.$_POST['depot'].'"';







if($_POST['product_group']!='')



$con.=' and a.product_group = "'.$_POST['product_group'].'"';



if($_POST['depot']!='')



$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';if($_POST['team_name']!='')



$con.=' and a.team_name = "'.$_POST['team_name'].'"';







		 		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as customer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.mobile_no as mobile_no,a.dealer_name_b as designation , a.propritor_name_b as contact_person , a.address_e as address, a.canceled as active, a.commission from dealer_info a



		 where a.dealer_type='Direct Sales(DS)'  ".$con." order by a.dealer_code asc";		// , area ar, zon z, branch r;



		 //,a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, r.BRANCH_NAME as region;



		 //ar.AREA_CODE=a.area_code and z.ZONE_CODE=ar.ZONE_ID and r.BRANCH_ID=z.REGION_ID;



		break;







				case 1005:



$report="Retailer Partner(RP) Customer Information";



if($_POST['dealer_name_e']!='')



$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';



if($_POST['dealer_code']!='')



$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';







if($_POST['division_code']!='')



$con.=' and a.division_code = "'.$_POST['division_code'].'"';



elseif($_POST['district_code']!='')



$con.=' and a.district_code = "'.$_POST['district_code'].'"';



elseif($_POST['thana_code']!='')



$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';if($_POST['region_code']!='')



$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['zone_code']!='')



$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['area_code']!='')



$con.=' and a.area_code = "'.$_POST['area_code'].'"';if($_POST['canceled']!='')



$con.=' and a.canceled = "'.$_POST['canceled'].'"';



if($_POST['depot']!='')



$con.=' and a.depot = "'.$_POST['depot'].'"';







if($_POST['product_group']!='')



$con.=' and a.product_group = "'.$_POST['product_group'].'"';



if($_POST['depot']!='')



$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';if($_POST['team_name']!='')



$con.=' and a.team_name = "'.$_POST['team_name'].'"';







		 		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as customer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.mobile_no as mobile_no,a.dealer_name_b as designation , a.propritor_name_b as contact_person , a.address_e as address, a.canceled as active, a.commission from dealer_info a



		 where a.dealer_type='Retailer Partner(RP)'  ".$con."  order by a.dealer_code asc";		// , area ar, zon z, branch r;



		 //,a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, r.BRANCH_NAME as region;



		 //ar.AREA_CODE=a.area_code and z.ZONE_CODE=ar.ZONE_ID and r.BRANCH_ID=z.REGION_ID;



		break;







						case 1006:



$report="RMC Customer Information";



if($_POST['dealer_name_e']!='')



$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';



if($_POST['dealer_code']!='')



$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';







if($_POST['division_code']!='')



$con.=' and a.division_code = "'.$_POST['division_code'].'"';



elseif($_POST['district_code']!='')



$con.=' and a.district_code = "'.$_POST['district_code'].'"';



elseif($_POST['thana_code']!='')



$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';if($_POST['region_code']!='')



$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['zone_code']!='')



$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['area_code']!='')



$con.=' and a.area_code = "'.$_POST['area_code'].'"';if($_POST['canceled']!='')



$con.=' and a.canceled = "'.$_POST['canceled'].'"';



if($_POST['depot']!='')



$con.=' and a.depot = "'.$_POST['depot'].'"';







if($_POST['product_group']!='')



$con.=' and a.product_group = "'.$_POST['product_group'].'"';



if($_POST['depot']!='')



$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';if($_POST['team_name']!='')



$con.=' and a.team_name = "'.$_POST['team_name'].'"';







		 		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as customer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.mobile_no as mobile_no,a.dealer_name_b as designation , a.propritor_name_b as contact_person , a.address_e as address, a.canceled as active, a.commission from dealer_info a



		 where a.dealer_type='RMC'  ".$con."  order by a.dealer_code asc";		// , area ar, zon z, branch r;



		 //,a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, r.BRANCH_NAME as region;



		 //ar.AREA_CODE=a.area_code and z.ZONE_CODE=ar.ZONE_ID and r.BRANCH_ID=z.REGION_ID;



		break;







case 1004:



$report="Personal Sales Information";



if($_POST['dealer_name_e']!='')



$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';



if($_POST['dealer_code']!='')



$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';







if($_POST['division_code']!='')



$con.=' and a.division_code = "'.$_POST['division_code'].'"';



elseif($_POST['district_code']!='')



$con.=' and a.district_code = "'.$_POST['district_code'].'"';



elseif($_POST['thana_code']!='')



$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';if($_POST['region_code']!='')



$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['zone_code']!='')



$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['area_code']!='')



$con.=' and a.area_code = "'.$_POST['area_code'].'"';if($_POST['canceled']!='')



$con.=' and a.canceled = "'.$_POST['canceled'].'"';



if($_POST['depot']!='')



$con.=' and a.depot = "'.$_POST['depot'].'"';







if($_POST['product_group']!='')



$con.=' and a.product_group = "'.$_POST['product_group'].'"';



if($_POST['depot']!='')



$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';if($_POST['team_name']!='')



$con.=' and a.team_name = "'.$_POST['team_name'].'"';







		 		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.mobile_no as mobile_no,a.propritor_name_e as propritor_name ,a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, r.BRANCH_NAME as region, a.canceled as active, a.commission from dealer_info a, area ar, zon z, branch r



		 where ar.AREA_CODE=a.area_code and z.ZONE_CODE=ar.ZONE_ID and r.BRANCH_ID=z.REGION_ID and a.dealer_type='Personal'  ".$con." order by a.dealer_code desc";



break;}



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



<form action="advance_report.php" method="post">



<div align="center" id="pr">



<input type="button" value="Print" onclick="hide();window.print();"/>



</div>







<div class="main">



<?		//echo $sql;







		$str 	.= '<div class="header">';



		if(isset($_SESSION['company_name']))



		$str 	.= '<h2 style="font-size:24px; font-family:bankgothic; transform: uppercase;">ERP COM BD</h2>';



		if(isset($report))		$str 	.= '<h2>'.$report.'</h2>';



		if($_POST['JOB_LOCATION']!='')		$str 	.= '<h2>'.find_a_field('project','PROJECT_DESC','PROJECT_ID='.$_POST['JOB_LOCATION']).'</h2>';



		if(isset($to_date))



		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';



		$str 	.= '</div>';



		if(isset($_SESSION['company_logo']))



		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';



		$str 	.= '<div class="center">';







		if(($_POST['area_code']>0))



		$str 	.= '<p>Area Name: '.find_a_field('area','AREA_NAME','AREA_CODE="'.$_POST['area_code'].'"').'</p>';



		if(($_POST['zone_code']>0))



		$str 	.= '<p>Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$_POST['zone_code'].'"').'</p>';



		if(($_POST['region_code']>0))



		$str 	.= '<p>Region Name: '.find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$_POST['region_code'].'"').'</p>';
		
		
		if($_POST['project']!='') {
		$str 	.= 'Project Name: '.find_a_field('project','PROJECT_NAME','PROJECT_ID="'.$_POST['project'].'"').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$str 	.= '<br>';
		}
		
		if($_POST['PBI_ID']!='') {
		$str 	.= 'Employee: '.find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$_POST['PBI_ID'].'"').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$str 	.= '<br>';
		}



		if(isset($project_name))



		$str 	.= '<p>Project Name: '.$project_name.'</p>';



		if(isset($allotment_no))



		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';



		$str 	.= '</div><div class="right">';



		if(isset($client_name))



		$str 	.= '<p>Client Name: '.$client_name.'</p>';



		$str 	.= '</div><div class="date" style="">Reporting Time: '.date("h:i A d-m-Y").'</div>';







if($_POST['report']==7)



{



$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department from



personnel_basic_info a where 1 ".$con." order by a.PBI_DOJ asc";



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
if($_POST['report']==999){ // Leave Encashment Report

$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr><th style="border:0px;" colspan="12"><?=$str?></th></tr>

<tr>
  <th>SL</th>
  <th>Project</th>
  <th>Module</th>
  <th>Feature</th>
  <th>Task</th>
  <th>Requested By</th>
  <th>Request Date</th>
  <th>Status</th>
  <th>Complete Date </th>
  <th>Remarks</th>
  <th>Entry By</th>
  <th>Entry at</th>
  </tr>
</thead>
<tbody>
<?

if($_POST['PBI_ID']>0){
 $conn = ' and p.entry_by="'.$_POST['PBI_ID'].'"';
}
if($_POST['project']>0){
 $conn .= ' and p.project="'.$_POST['project'].'"';
}
if($_POST['f_date']!='' && $_POST['t_date']!=''){
 $conn .= ' and p.entry_date between  "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
}
if($_POST['fdate']!='' && $_POST['tdate']!=''){
 $conn .= ' and p.request_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
}

$res='select p.id,proj.PROJECT_NAME,m.module_name,f.feature_name,p.task,p.request_by,p.request_date,p.status,p.complete_date,p.remarks,p.entry_at,u.PBI_NAME from daily_progress p left join user_module_manage m on m.id=p.module_id left join user_feature_manage f on f.id=p.feature_id left join personnel_basic_info u on u.PBI_ID=p.entry_by left join project proj on proj.PROJECT_ID=p.project where 1 '.$conn.'';
$queryd=db_query($res);
while($data = mysqli_fetch_object($queryd)){
?>
<tr>
  <td><?=++$s?></td>
  <td><?=$data->PROJECT_NAME?></td>
  <td><?=$data->module_name?></td>
  <td><?=$data->feature_name?></td>
  <td><?=$data->task?></td>
  <td><?=$data->request_by?></td>
  <td><?=$data->request_date?></td>
  <td><?=$data->status?></td>
  <td><?=$data->complete_date?></td>
  <td><?=$data->remarks?></td>
  <td><?=$data->PBI_NAME?></td>
  <td><?=$data->entry_at?></td>
</tr>
<?
}
?>

</tbody></table>
<?
}
if($_POST['report']==77)



{



$sqll="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department from



personnel_basic_info a, salary_info s where a.PBI_ID=s.PBI_ID  ".$con." order by a.PBI_DOJ asc, (s.consolidated_salary+s.basic_salary) desc";



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



if($_POST['report']==777)







{







?><table width="100%" cellspacing="0" cellpadding="2" border="0">







<thead><tr><td style="border:0px;" colspan="13" align="center"><?=$str?></td></tr>







<tr>







  <th rowspan="3"><div align="center">S/L</div></th>







<th rowspan="3"><div align="center">ID</div></th>







<th rowspan="3"><div align="center">Name</div></th>







<th rowspan="3"><div align="center">Desgnation</div></th>







<th rowspan="3" nowrap="nowrap"><div align="center">Joining Date </div></th>







<th rowspan="3" nowrap="nowrap"><div align="center">Job Period </div></th>







<th colspan="2" align="center"><div align="center">Salary</div></th>







<th rowspan="3"><div align="center">Bonus (Basic) %</div></th>







<th rowspan="3"><div align="center">Bonus Amount </div></th>







<th rowspan="3"><div align="center">Bank Acc.</div></th>







<th rowspan="3"><div align="center">Payroll Card No</div></th>







<th rowspan="3"><div align="center">Remarks</div></th>







</tr>







<tr>







  <th><div align="center">Gross</div></th>







  <th><div align="center">Basic</div></th>







</tr>







<tr>







  <th><div align="center">100%</div></th>







  <th><div align="center">50%</div></th>



</tr>







</thead>







<tbody>







<?if($_POST['branch']!='')







$cons=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';



if($_POST['JOB_LOCATION']!='')







$cons.=' and b.pbi_job_location ="'.$_POST['JOB_LOCATION'].'"';



if($_POST['department']!='')







$cons.=' and b.pbi_department ="'.$_POST['department'].'"';



$found = find_a_field('salary_bonus','lock_status','bonus_type="'.$_POST['bonus_type'].'" and year="'.$_POST['year'].'"');



 if($found==0){



        $sqld="select a.PBI_ID, a.PBI_NAME, d.DESG_SHORT_NAME as designation, date_format(a.PBI_DOJ,'%d-%b-%y') as joining_date,



        b.job_period,







		 b.gross_salary,







		b.basic_salary,







		b.bonus_percent,







		b.bonus_amt,



		b.remarks,







		s.cash as bank_ac,







		s.card_no







		from







		personnel_basic_info a, salary_bonus b, salary_info s, designation d







		where







		1 and b.pbi_designation=d.DESG_ID and a.PBI_ID=b.PBI_ID and







		s.PBI_ID=b.PBI_ID and b.bonus_type=".$_POST['bonus_type']." and



		b.bonus_percent not like 0 and







		b.year=".$_POST['year']." ".$cons."







		order by b.bonus_amt desc";



}else{



  $sqld="select a.PBI_ID, a.PBI_NAME, d.DESG_SHORT_NAME as designation, date_format(a.PBI_DOJ,'%d-%b-%y') as joining_date,



        b.job_period,







		 b.gross_salary,







		b.basic_salary,







		b.bonus_percent,







		b.bonus_amt,



		b.remarks,







		s.cash as bank_ac,







		s.card_no







		from







		personnel_basic_info a, salary_bonus_lock b, salary_info s, designation d







		where







		1 and b.pbi_designation=d.DESG_ID and a.PBI_ID=b.PBI_ID and







		s.PBI_ID=b.PBI_ID and b.bonus_type=".$_POST['bonus_type']." and



		b.bonus_percent not like 0 and







		b.year=".$_POST['year']." ".$cons."







		order by b.bonus_amt desc";



}







$queryd=db_query($sqld);







while($data = mysqli_fetch_object($queryd)){







$entry_by=$data->entry_by;?>







<tr><td><?=++$s?></td>







<td><?=$data->PBI_ID?></td>







<td nowrap="nowrap"><?=$data->PBI_NAME?></td>







  <td nowrap="nowrap"><?=$data->designation?></td>







  <td align="center"><?=$data->joining_date?></td>







  <td align="center"><?=$data->job_period?></td>







  <td align="right"><?=($data->gross_salary>0)? $data->gross_salary : ''; $tot_gross+=$data->gross_salary;?></td>







  <td align="right"><?=($data->basic_salary>0)? $data->basic_salary : ''; $tot_basic+=$data->basic_salary;?></td>







  <td align="center"><?=$data->bonus_percent?></td>







  <td align="right"><?=$data->bonus_amt; $totalBonus+=$data->bonus_amt;?></td>







  <td><?=$data->bank_ac;?></td>







  <td><?=$data->card_no;?></td>







  <td><?=$data->remarks;?></td>







</tr>







<?







}







?>







<tr>







  <td colspan="6" align="right">Total:</td>







  <td align="right"><strong><?=$tot_gross?></strong></td>







  <td align="right"><strong><?=$tot_basic?></strong></td>  <td>&nbsp;</td>







  <td align="right"><strong><?=$totalBonus?></strong></td>







  <td>&nbsp;</td>







  <td>&nbsp;</td>







  <td>&nbsp;</td>







</tr></tbody></table>



In Words:



<?echo convertNumberMhafuz($totalBonus);



?>



<br><br><br>



<div style="width:100%; margin:60px auto">



<div style="float:left; width:20%; text-align:center">-------------------<br>Prepared By</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Audit</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Accounts</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Managing Director</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Chairman</div>



</div>



<?



}



if($_POST['report']==78)



{



?><table width="100%" cellspacing="0" cellpadding="2" border="0">







<thead><tr>







<td style="border:0px;" colspan="6" align="left"><img src="../../img/company_logo.png" style="height:100px; width:65px;"  /></td>







<td style="border:0px;" colspan="30" align="center"><?=$str?></td></tr>







<tr>







  <th rowspan="3">S/L</th>







<th rowspan="3"><div align="center">ID</div></th>







<th rowspan="3"><div align="center">Name</div></th>







<th rowspan="3"><div align="center">Designation</div></th>







<th rowspan="3" nowrap="nowrap"><div align="center">Joining Date </th>







<th colspan="14" align="center"><div align="center">Attendance</div></th>







<th colspan="5"><div align="center">Salary and Allowance </div></th>







<th colspan="3"><div align="center">Extra Allowance </div></th>







<th rowspan="3"><div align="center">OT. Hrs.</div> </th>







<th rowspan="3"><div align="center">OT. Amt. </div></th>







<th colspan="8" align="center"><div align="center">Deduction</div></th>







<th rowspan="3"><div align="center">Total Deduction </div></th>







<th rowspan="3" align="center"><div align="center">Net Salary Payment </div></th>







<th rowspan="3"><div align="center">Bank A/C</div></th>







<th rowspan="3"><div align="center">Payroll Card No</div></th>







<th rowspan="3"><div align="center">Remarks</div></th>







</tr>







<tr>







  <th colspan="9"><div align="center">No of Leave's </div></th>







  <th rowspan="2"><div align="center">Total Days Works </div></th>







  <th rowspan="2"><div align="center">LP</div></th>







  <th rowspan="2"><div align="center">LWP</div></th>







  <th rowspan="2"><div align="center">AB</div></th>







  <th rowspan="2"><div align="center">OD</div></th>







  <th><div align="center">Gross </div></th>







  <th><div align="center">Basic</div></th>







  <th><div align="center">House Rent </div></th>







  <th><div align="center">Medical</div></th>







  <th><div align="center">Conveyance</div></th>







  <th rowspan="2"><div align="center">Food</div></th>







  <th rowspan="2"><div align="center">Transport</div></th>



  <th rowspan="2"><div align="center">Other</div></th>







  <th rowspan="2"><div align="center">Mobile</div></th>







  <th rowspan="2"><div align="center">Tax</div></th>







  <th rowspan="2"><div align="center">Food </div></th>







  <th rowspan="2"><div align="center">Loan /Advance</div></th>







  <th rowspan="2"><div align="center">Absent</div></th>







  <th rowspan="2"><div align="center">LWP</div></th>







  <th rowspan="2"><div align="center">Late</div></th>







  <th rowspan="2"><div align="center">Others</div></th>







</tr>







<tr>







  <th>CL</th>







  <th>SL</th>







  <th>AL</th>







  <th>SHL</th>



  <th>ML</th>



  <th>PL</th>



  <th>EOL</th>



  <th>HL</th>



  <th>MLV</th>  <th><div align="center">100%</div></th>  <th><div align="center">50%</div></th>  <th><div align="center">25%</div></th>







  <th><div align="center">15%</div></th>



  <th><div align="center">10%</div></th>







  </tr>



</thead>



<tbody>



<?



$found = find_a_field('salary_attendence','lock_status','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'"');



  if($found==0){







  if($_POST['PBI_ORG']!='')







	$salaryCon =' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';



if ($_POST['JOB_LOCATION'] !='')







	$salaryCon .= ' and t.job_location='.$_POST['JOB_LOCATION'];



if ($_POST['department'] !='')







	$salaryCon .= ' and t.department='.$_POST['department'];



if ($_POST['job_status'] !='')







$salaryCon .=' and a.PBI_JOB_STATUS="'.$_POST['job_status'].'"';   $sqld = 'select t.*, a.PBI_ID, a.PBI_NAME, a.PBI_DOJ, d.DESG_SHORT_NAME as Designation from salary_attendence t,designation d, personnel_basic_info a



 where t.designation = d.DESG_ID and t.pay>0 and  t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID '.$salaryCon.' order by (t.total_payable) desc';}else{



 if($_POST['PBI_ORG']!='')







	$salaryConn =' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';



if ($_POST['JOB_LOCATION'] !='')







	$salaryConn .= ' and t.job_location='.$_POST['JOB_LOCATION'];



if ($_POST['department'] !='')







	$salaryConn .= ' and t.department='.$_POST['department'];



            $m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';







		   $m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';   $sqld = 'select t.*, a.PBI_ID, a.PBI_NAME, a.PBI_DOJ, d.DESG_SHORT_NAME as Designation from salary_attendence_lock t,designation d, personnel_basic_info a



 where t.designation = d.DESG_ID and t.pay>0 and  t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID '.$salaryConn.' order by (t.total_payable) desc';}



$queryd=db_query($sqld);



while($data = mysqli_fetch_object($queryd)){



$m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';







$m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';







$entry_by=$data->entry_by;







  //$slq = 'select sum(total_days) from hrm_leave_info where PBI_ID="'.$data->PBI_ID.'" and type=1 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED"';







?>



<tr><td><?=++$s?></td>



<td><?=$data->PBI_ID?></td>







<td nowrap="nowrap"><?=$data->PBI_NAME?></td>







  <td nowrap="nowrap"><?=$data->Designation?></td>







  <td><?=date('d-M-Y',strtotime($data->PBI_DOJ))?></td>







  <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID="'.$data->PBI_ID.'" and type=1 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED"') ?></td>







  <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=2 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ') ?></td>







  <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=3 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ') ?></td>







  <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type="Short Leave (SHL)" and leave_status="GRANTED" and mon='.$_POST['mon'].' and year='.$_POST['year'].'') ?></td>



   <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=4 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ')?></td>



    <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=6 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ')?></td>



	 <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=8 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ')?></td>



	  <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=7 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ')?></td>  <td><?=find_a_field('hrm_leave_info','sum(total_days)','PBI_ID='.$data->PBI_ID.' and type=5 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED" ')?></td>







  <td align="center"><?=($data->pay>0)? $data->pay : '';?></td>







  <td align="center"><?=($data->lt>0)? $data->lt : '';?></td>







  <td align="center"><?=($data->lwp>0)? $data->lwp : '';?></td>







  <td align="center"><?=($data->ab>0)? $data->ab : '';?></td>  <td align="center"><?=($data->oDuty>0)? $data->oDuty : '';?></td>



 <td align="right"><?=($data->gross_salary>0)? $data->gross_salary : '';               $totGross += $data->gross_salary?></td>







  <td align="right"><?=($data->basic_salary>0)? $data->basic_salary : '';               $totBasic += $data->basic_salary?></td>







  <td align="right"><?=($data->house_rent>0)? $data->house_rent : '';                   $totHouse += $data->house_rent?></td>







  <td align="right"><?=($data->medical_allowance>0)? $data->medical_allowance : '';     $totMedical += $data->medical_allowance?></td>







  <td align="right"><?=($data->special_allowance>0)? $data->special_allowance : '';     $totspecial += $data->special_allowance?></td>







  <td align="right"><?=($data->food_allowance>0)? $data->food_allowance : '';           $totFood += $data->food_allowance?></td>







  <td align="right"><?=($data->transport_allowance>0)? $data->transport_allowance :''; $totTransport += $data->transport_allowance?></td>



  <td align="right"><?=($data->other_allowance>0)? $data->other_allowance :'';        $totOther += $data->other_allowance?></td>



  <td align="right"><?=($data->over_time_hour>0)? $data->over_time_hour : '';           $totOverTimeHr += $data->over_time_hour?></td>







  <td align="right"><?=($data->over_time_amount>0)? $data->over_time_amount : '';       $totOverTimeAmt += $data->over_time_amount?></td>







  <td align="right"><?=($data->mobile_deduction>0)? $data->mobile_deduction : '';       $totMobileDeduct += $data->mobile_deduction?></td>







  <td align="right"><?=($data->income_tax>0)? $data->income_tax : '';                   $totIincomeTax += $data->income_tax?></td>







  <td align="right"><?=($data->food_deduction>0)? $data->food_deduction : '';           $totFoodDeduct += $data->food_deduction?></td>







  <td align="right"><?=($data->advance_install>0)? $data->advance_install : '';         $totAdvInstall += $data->advance_install?></td>







  <td align="right"><?=($data->absent_deduction>0)? $data->absent_deduction : '';       $totAbsentDeduct += $data->absent_deduction?></td>







  <td align="right"><?=($data->lwp_deduction>0)? $data->lwp_deduction : '';             $totLwpDeduct += $data->lwp_deduction?></td>







  <td align="right"><?=($data->late_deduction>0)? $data->late_deduction : '';           $totLateDeduct += $data->late_deduction?></td>







  <td align="right"><?=($data->other_deduction>0)? $data->other_deduction : '';       $totOtherDeduct += $data->other_deduction?></td>







  <td align="right"><?=($data->total_deduction>0)? $data->total_deduction : '';         $totTotalDeduct += $data->total_deduction?></td>







  <td align="right"><? echo ($data->total_payable>0)? $data->total_payable : '';        $total_cash = $total_cash + $data->total_payable;?></td>







  <td><?=($data->cash>0)? $data->cash : '';?></td>







  <td><?=($data->card_no>0)? $data->card_no : '';?></td>







  <td nowrap="nowrap" style="width:150px;"><?=$data->remarks_details?></td>







</tr>







<?



}?><tr>



  <td colspan="10" align="right" style="font-weight:bold;">Total:</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td align="right"><strong><?=($totGross>0)? $totGross : '';?></strong></td>



  <td align="right"><strong><?=($totBasic>0)? $totBasic : '';?></strong></td>



  <td align="right"><strong><?=($totHouse>0)? $totHouse : '';?></strong></td>



  <td align="right"><strong><?=($totMedical>0)? $totMedical : '';?></strong></td>



  <td align="right"><strong><?=($totspecial>0)? $totspecial : '';?></strong></td>



  <td align="right"><strong><?=($totFood>0)? $totFood : '';?></strong></td>



  <strong><td align="right"><?=($totTransport>0)? $totTransport : '';?></td></strong>



  <td align="right"><strong><?=($totOther>0)? $totOther : '';?></strong></td>



  <td align="right"><strong><?=($totOverTimeHr>0)? $totOverTimeHr : '';?></strong></td>



  <td align="right"><strong><?=($totOverTimeAmt>0)? $totOverTimeAmt : '';?></strong></td>



  <td align="right"><strong><?=($totMobileDeduct>0)? $totMobileDeduct : '';?></strong></td>



  <td align="right"><strong><?=($totIncomeTax>0)? $totIncomeTax : '';?></strong></td>



  <td align="right"><strong><?=($totFoodDeduct>0)? $totFoodDeduct : '';?></strong></td>



  <td align="right"><strong><?=($totAdvInstall>0)? $totAdvInstall : '';?></strong></td>



  <td align="right"><strong><?=($totAbsentDeduct>0)? $totAbsentDeduct : '';?></strong></td>



  <td align="right"><?=($totLwpDeduct>0)? $totLwpDeduct : '';?></td>



  <td align="right"><?=($totLateDeduct>0)? $totLateDeduct : '';?></td>



  <td align="right"><?=($totOtherDeduct>0)? $totOtherDeduct : '';?></td>



  <td align="right"><?=($totTotalDeduct>0)? $totTotalDeduct : '';?></td>



  <td align="right"><?=($total_cash>0)? $total_cash : '';?></td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



</tr></tbody></table>



In Words:



<?







echo convertNumberMhafuz($total_cash);







?>



<br><br><br>







<?







}







if($_POST['report']==226655)



{







?>



<table width="100%"  cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px;" colspan="28"><?=$str?></td></tr><tr><td style="border:0px;" colspan="28"><div align="center" style="font-size:20px;">Leave Report of <? $test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');







 echo date_format($test, 'M-Y');







 ?></div></td></tr>



<tr>



  <th rowspan="2">S/L</th>



  <th rowspan="2">ID</th>



<th rowspan="2">Name</th>







<th rowspan="2"><center>Designation</center></th>







<th rowspan="2">Duties Carried By</th>



<th rowspan="2"><center>Submission Date</center></th>







<th colspan="2"><center>Date Intervel</center></th>



<th rowspan="2"><center>Total Days</center></th>



<th rowspan="2"><center>Leave Type<center></th>



<th rowspan="2"><center>Reporting Authority<center></th>



<th rowspan="2"><center>HR Approval<center></th>



</tr>



<tr>







   <th><div align="center">Start Date</div></th>







   <th><div align="center">End Date</div></th>



</tr></thead>



<tbody>



<?



if($_POST['department'] !='')

$leave_con = ' and a.PBI_DEPARTMENT="'.$_POST['department'].'"';
if($_POST['JOB_LOCATION'] !='')



$leave_con .= ' and a.JOB_LOCATION="'.$_POST['JOB_LOCATION'].'"';
if($_POST['year'] !='')







$leave_con .= ' and o.year="'.$_POST['year'].'"';



if($_POST['leave_status'] !='')
$leave_con .= ' and o.leave_status="'.$_POST['leave_status'].'"';



if($_POST['PBI_ID'] !='')







$leave_con .= ' and a.PBI_CODE="'.$_POST['PBI_ID'].'"';



if($_POST['mon'] !='')







$od_con .= ' and o.s_date between "'.$_POST['year'].'-'.$_POST['mon'].'-01" and "'.$_POST['year'].'-'.$_POST['mon'].'-30"';







           $m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';







		   $m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';



   $sqldd = "select o.PBI_ID,a.PBI_CODE,a.PBI_NAME as name,o.s_date,o.e_date,(select PBI_NAME from personnel_basic_info where PBI_ID=o.leave_responsibility_name) as duties_carried_by,c.DESG_DESC,DATE_FORMAT(o.leave_apply_date,'%d-%b-%Y') as submission_date,DATE_FORMAT(o.s_date,'%d-%b-%Y') as start_date,DATE_FORMAT(o.e_date,'%d-%b-%Y') as end_date,o.total_days,(select leave_type_name from hrm_leave_type where id=o.type) as leave_type, o.incharge_status ,o.leave_status  from personnel_basic_info a,designation c, department d,hrm_leave_info o where a.DESG_ID=c.DESG_ID and a.DEPT_ID=d.DEPT_ID and a.PBI_ID=o.PBI_ID and  o.type!= 'Short Leave (SHL)' and o.s_date>='".$m_s_date."' and o.e_date<='".$m_e_date."'  ".$leave_con." order by o.s_date desc";



$querydd=db_query($sqldd);



while($leaveData = mysqli_fetch_object($querydd)){



$entry_by=$data->entry_by;







$year = date('Y');



/*$last_date = find_a_field('hrm_leave_info','e_date','PBI_ID="'.$leaveData->PBI_ID.'" and e_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'"');



if($leaveData->e_date>$m_e_date){



 $start = $leaveData->s_date;







 $end = $m_e_date;$begin = new DateTime($start);







$end = new DateTime($end);



$interval = DateInterval::createFromDateString('1 day');







$period = new DatePeriod($begin, $interval, $end);







$day_count = 0;







foreach ($period as $dt) {







     $dt->format("l Y-m-d H:i:s\n");







    $today = $dt->format("Y-m-d");







    if($dt->format("l")!='Friday')







    {







$found = 0;







$found = find_a_field('salary_holy_day','1',' holy_day="'.$today.'" ');







if($found==0)







$day_count++;







    }



}







$total_days = $day_count;







}elseif($last_date!=''){



$start = $m_s_date;







 $end = $last_date;$begin = new DateTime($start);







$end = new DateTime($end);



$interval = DateInterval::createFromDateString('1 day');







$period = new DatePeriod($begin, $interval, $end);







$day_count = 0;







foreach ($period as $dt) {







     $dt->format("l Y-m-d H:i:s\n");







    $today = $dt->format("Y-m-d");







    if($dt->format("l")!='Friday')







    {







$found = 0;







$found = find_a_field('salary_holy_day','1',' holy_day="'.$today.'" ');







if($found==0)







$day_count++;







    }



}







$total_days = $day_count;



}



else







{







$total_days = $leaveData->total_days;







}*/



?>



<tr><td ><?=++$s?></td>







	<td align="center"><?=$leaveData->PBI_CODE?></td>



<td nowrap="nowrap"><?=$leaveData->name?></td>







<td><?=$leaveData->DESG_DESC?></td>



 <td><?=$leaveData->duties_carried_by?></td>



 <td align="center"><?=$leaveData->submission_date?></td>



  <td align="center"><?=$leaveData->start_date?></td>  <td align="center"><?=$leaveData->end_date?></td>



  <td align="center"><?=$leaveData->total_days?></td>



  <td align="center"><?=$leaveData->leave_type?></td>  <td align="center"><?=$leaveData->incharge_status?></td>   <td align="center"><?=$leaveData->leave_status?></td></tr><?







}







?>







</tbody></table><br><br><br>



<?







}







if($_POST['report']==226644)



{







?>



<table width="100%"  cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px;" colspan="28"><?=$str?></td></tr><tr><td style="border:0px;" colspan="28"><div align="center" style="font-size:20px;">Short Leave Report of <? $test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');







 echo date_format($test, 'M-Y');







 ?></div></td></tr>



<tr>



  <th rowspan="2">S/L</th>



  <th rowspan="2">ID</th>



<th rowspan="2">Name</th>







<th rowspan="2"><center>Designation</center></th>







<th rowspan="2">Duties Carried By</th>



<th rowspan="2"><center>Submission Date</center></th>







<th rowspan="2"><center>Leave Date</center></th>







<th colspan="2"><center>Time Intervel</center></th>



<th rowspan="2"><center>Total Hours</center></th><th rowspan="2"><center>Reporting Authority<center></th>



<th rowspan="2"><center>HR Approval<center></th>



</tr>



<tr>







   <th><div align="center">Start Time</div></th>







   <th><div align="center">End Time</div></th>



</tr></thead>



<tbody>



<?



if($_POST['department'] !='')







$leave_con = ' and a.PBI_DEPARTMENT="'.$_POST['department'].'"';







if($_POST['leave_status'] !='')
$leave_con .= ' and o.leave_status="'.$_POST['leave_status'].'"';







if($_POST['JOB_LOCATION'] !='')







$leave_con .= ' and a.JOB_LOCATION="'.$_POST['JOB_LOCATION'].'"';



if($_POST['PBI_ID'] !='')







$leave_con .= ' and a.PBI_CODE="'.$_POST['PBI_ID'].'"';



if($_POST['year'] !='')







$leave_con .= ' and o.year="'.$_POST['year'].'"';



if($_POST['mon'] !='')







$leave_con .= ' and o.half_leave_date between "'.$_POST['year'].'-'.$_POST['mon'].'-01" and "'.$_POST['year'].'-'.$_POST['mon'].'-31"';



  $sqldd = "select o.PBI_ID,a.PBI_CODE,a.PBI_NAME as name,(select PBI_NAME from personnel_basic_info where PBI_ID=o.leave_responsibility_name) as duties_carried_by,c.DESG_DESC,DATE_FORMAT(o.leave_apply_date,'%d-%b-%Y') as submission_date,DATE_FORMAT(o.half_leave_date,'%d-%b-%Y') as leave_date,TIME_FORMAT(o.s_time,'%h:%i') as start_time, TIME_FORMAT(o.e_time, '%h:%i') as end_time,o.total_hrs, o.incharge_status as reporting_authority ,o.leave_status from personnel_basic_info a,designation c, department d,hrm_leave_info o where a.DESG_ID=c.DESG_ID and a.DEPT_ID=d.DEPT_ID and a.PBI_ID=o.PBI_ID  and o.type='Short Leave (SHL)'  ".$leave_con."  order by o.half_leave_date desc";



$querydd=db_query($sqldd);



while($leaveData = mysqli_fetch_object($querydd)){



$entry_by=$data->entry_by;







$year = date('Y');



?>



<tr><td align="center"><?=++$s?></td>







	<td align="center"><?=$leaveData->PBI_CODE?></td>



<td nowrap="nowrap"><?=$leaveData->name?></td>







<td><?=$leaveData->DESG_DESC?></td>



 <td><?=$leaveData->duties_carried_by?></td>



 <td align="center"><?=$leaveData->submission_date?></td>







 <td align="center"><?=$leaveData->leave_date?></td>



  <td align="center"><?=$leaveData->start_time?></td>  <td align="center"><?=$leaveData->end_time?></td>



  <td align="center"><?=$leaveData->total_hrs?></td>



  <td align="center"><?=$leaveData->reporting_authority?></td>   <td align="center"><?=$leaveData->leave_status?></td></tr>







<?







}



?>







</tbody></table>







<br><br><br>







<?



}



if($_POST['report']==201912)



{



?>







<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px; text-align:center; font-size:20px; font-family:bankgothic;" colspan="28">AKSID CORPORATION LTD</td></tr><tr><td style="border:0px;" colspan="28"><div align="center" style="font-size:20px;">OD Report of <? $test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');







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


<th rowspan="2"><div align="center">Reporting Authority Name</div></th>
<th rowspan="2"><div align="center">Submission Date</div></th>

<th rowspan="2"><div align="center">Reporting Authority Approval Date</div></th><th colspan="2"><div align="center">Date Interval</div></th>



<th rowspan="2"><div align="center">Total Days</div></th>



<th colspan="2"><div align="center">Time Interval</div></th>



<th rowspan="2"><div align="center">Total Hours</div></th>







<th rowspan="2"><div align="center">OD Type</div></th>

<th rowspan="2"><div align="center">Day Tour Type</div></th>







<th colspan="3"><div align="center">Description</div></th>

<th rowspan="2"><div align="center">Reason</div></th>


</tr>







<tr>







   <th><div align="center">Start Date</div></th>







   <th><div align="center">End Date</div></th>   <th><div align="center">Start Time</div></th>







   <th><div align="center">End Time</div></th>



   <th><div align="center">Company Name</div></th>







   <th><div align="center">Place/Address</div></th>







   <th><div align="center">Project Name</div></th></tr>



</thead>



<tbody>



<?



if($_POST['department'] !='')







$od_con = ' and p.PBI_DEPARTMENT="'.$_POST['department'].'"';



if($_POST['JOB_LOCATION'] !='')







$od_con .= ' and p.JOB_LOCATION="'.$_POST['JOB_LOCATION'].'"';



if($_POST['PBI_ID'] !='')







$od_con .= ' and p.PBI_CODE="'.$_POST['PBI_ID'].'"';



/*if($_POST['year'] !='')







$od_con .= ' and l.year="'.$_POST['year'].'"';*/



if($_POST['mon'] !='')



  $m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';







   $m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';







$od_con .= ' and l.s_date>="'.$m_s_date.'" and l.e_date<="'.$m_e_date.'"';



//$tr_con .= ' and t.TRANSFER_ORDER_DATE between "'.$_POST['year'].'-'.$_POST['mon'].'-1" and "'.$_POST['year'].'-'.$_POST['mon'].'-30"';







 $sqldd = 'select l.PBI_ID,p.PBI_CODE,p.PBI_NAME,p.PBI_DEPARTMENT,(select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project,p.PBI_SEX,
 (select PBI_NAME from personnel_basic_info where PBI_ID=l.PBI_IN_CHARGE) as reporting_auth ,
 p.PBI_DOJ,p.PBI_DESIGNATION,dept.DEPT_DESC,desg.DESG_DESC,
DATE_FORMAT(l.od_date,"%d-%b-%Y") as od_date,l.total_days,l.total_hrs ,l.type,l.reason,l.s_time,l.e_time,l.place4,l.organization,l.company_name,l.s_time_format,l.e_time_format,l.project_name,l.organization2,l.place,l.place2,l.place3,DATE_FORMAT(l.auth_date,"%d-%b-%Y") as auth_date,DATE_FORMAT(l.s_date,"%d-%b-%Y") as s_date,DATE_FORMAT(l.e_date,"%d-%b-%Y") as e_date,
l.incharge_status as reporting_authority,l.od_status
from hrm_od_info l,personnel_basic_info p,department dept,designation desg where l.PBI_ID=p.PBI_ID  and p.DEPT_ID=dept.DEPT_ID and l.od_status="Granted" 
and  p.DESG_ID=desg.DESG_ID '.$od_con.'order by s_date desc';


$querydd=db_query($sqldd);
while($leaveData = mysqli_fetch_object($querydd)){

$entry_by=$data->entry_by;
$year = date('Y');

?>



<tr><td><?=++$s?></td>







	<td><?=$leaveData->PBI_CODE?></td>



<td nowrap="nowrap"><?=$leaveData->PBI_NAME?></td>



 <td><?=$leaveData->DESG_DESC?></td>



  <td><div align="center"><?=$leaveData->DEPT_DESC?></div></td>  <td><div align="center"><?=$leaveData->project?></div></td>

<td><div align="center"><?=$leaveData->reporting_auth?></div></td>









  <td><div align="center"><?=$leaveData->od_date?></div></td>



  <td><div align="center"><?=$leaveData->auth_date?></div></td>   <td><?=$leaveData->s_date?></td>







   <td><?=$leaveData->e_date?></td>



   <td><div align="center"><?=$leaveData->total_days?></div></td>



   <td><div align="center"><?=$leaveData->s_time.' '.$leaveData->s_time_format?></div></td>







   <td><div align="center"><?=$leaveData->e_time.' '.$leaveData->e_time_format?></div></td>



    <td><div align="center"><?=$leaveData->total_hrs?></div></td>




   <td><div align="center"><?=find_a_field('od_type','type_name','id='.$leaveData->type)?></div></td>

   <td><div align="center"><?=$leaveData->daytour_name?></div></td>









   <td><div align="center">







   <?







   if($leaveData->organization!='')



   {



    echo $leaveData->organization;



   }elseif($leaveData->organization2!=''){



    echo $leaveData->organization2;



   }else{



    echo $leaveData->company_name;



   }



   ?>







   </div></td>







   <td><div align="center">







   <?



    if($leaveData->place4!='')



	{



	   echo $leaveData->place4;



	}elseif($leaveData->place!=''){



	   echo $leaveData->place;



	}



	elseif($leaveData->place2!=''){



	   echo $leaveData->place2;



	}elseif($leaveData->place3!=''){



	   echo $leaveData->place3;



	}







   ?>







   </div></td>







   <td><div align="center"><?=$leaveData->project_name?></div></td>







   <td><?=$leaveData->reason?></td>










</tr>







<?}



?></tbody></table><br><br><br>









<?



}



if($_POST['report']==201913)



{



?>







<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px; text-align:center; font-size:20px; font-family:bankgothic;" colspan="28"><?=$group->group_name?></td></tr><tr><td style="border:0px;" colspan="28"><div align="center" style="font-size:20px;">OD Report of <? $test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');







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


<th rowspan="2"><div align="center">Reporting Authority Name</div></th>



<th rowspan="2"><div align="center">Submission Date</div></th>

<th rowspan="2"><div align="center">Reporting Authority Approval Date</div></th><th colspan="2"><div align="center">Date Interval</div></th>



<th rowspan="2"><div align="center">Total Days</div></th>



<th colspan="2"><div align="center">Time Interval</div></th>



<th rowspan="2"><div align="center">Total Hours</div></th>







<th rowspan="2"><div align="center">OD Type</div></th>

<th rowspan="2"><div align="center">Day Tour Type</div></th>







<th colspan="3"><div align="center">Description</div></th>

<th rowspan="2"><div align="center">Reason</div></th>

<th rowspan="2"><center>Reporting Authority<center></th>

<th rowspan="2"><center>HR Approval<center></th>
</tr>







<tr>







   <th><div align="center">Start Date</div></th>







   <th><div align="center">End Date</div></th>   <th><div align="center">Start Time</div></th>







   <th><div align="center">End Time</div></th>



   <th><div align="center">Company Name</div></th>







   <th><div align="center">Place/Address</div></th>







   <th><div align="center">Project Name</div></th></tr>



</thead>



<tbody>



<?



if($_POST['department'] !='')







$od_con = ' and p.PBI_DEPARTMENT="'.$_POST['department'].'"';



if($_POST['JOB_LOCATION'] !='')







$od_con .= ' and p.JOB_LOCATION="'.$_POST['JOB_LOCATION'].'"';



if($_POST['PBI_ID'] !='')







$od_con .= ' and p.PBI_CODE="'.$_POST['PBI_ID'].'"';



/*if($_POST['year'] !='')







$od_con .= ' and l.year="'.$_POST['year'].'"';*/



if($_POST['mon'] !='')



  $m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';







   $m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';







$od_con .= ' and l.s_date>="'.$m_s_date.'" and l.e_date<="'.$m_e_date.'"';



//$tr_con .= ' and t.TRANSFER_ORDER_DATE between "'.$_POST['year'].'-'.$_POST['mon'].'-1" and "'.$_POST['year'].'-'.$_POST['mon'].'-30"';







 $sqldd = 'select l.PBI_ID,p.PBI_NAME,p.PBI_CODE,p.PBI_DEPARTMENT,(select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project,p.PBI_SEX,p.PBI_DOJ,
 (select PBI_NAME from personnel_basic_info where PBI_ID=l.PBI_IN_CHARGE) as reporting_auth ,
 p.PBI_DESIGNATION,dept.DEPT_DESC,desg.DESG_DESC,
DATE_FORMAT(l.od_date,"%d-%b-%Y") as od_date,l.total_days,l.total_hrs ,l.type,l.reason,l.s_time,l.e_time,l.place4,l.organization,l.company_name,l.s_time_format,l.e_time_format,l.project_name,l.organization2,l.place,l.place2,l.place3,DATE_FORMAT(l.auth_date,"%d-%b-%Y") as auth_date,DATE_FORMAT(l.s_date,"%d-%b-%Y") as s_date,DATE_FORMAT(l.e_date,"%d-%b-%Y") as e_date,
l.incharge_status as reporting_authority,l.od_status
from hrm_od_info l,personnel_basic_info p,department dept,designation desg where l.PBI_ID=p.PBI_ID   and p.DEPT_ID=dept.DEPT_ID and l.od_status="Pending" 
and  p.DESG_ID=desg.DESG_ID '.$od_con.'order by s_date desc';


$querydd=db_query($sqldd);
while($leaveData = mysqli_fetch_object($querydd)){

$entry_by=$data->entry_by;
$year = date('Y');

?>



<tr><td><?=++$s?></td>







	<td><?=$leaveData->PBI_CODE?></td>



<td nowrap="nowrap"><?=$leaveData->PBI_NAME?></td>



 <td><?=$leaveData->DESG_DESC?></td>



  <td><div align="center"><?=$leaveData->DEPT_DESC?></div></td>  <td><div align="center"><?=$leaveData->project?></div></td>

	<td><div align="center"><?=$leaveData->reporting_auth?></div></td>  <td><div align="center"><?=$leaveData->od_date?></div></td>



  <td><div align="center"><?=$leaveData->auth_date?></div></td>   <td><?=$leaveData->s_date?></td>







   <td><?=$leaveData->e_date?></td>



   <td><div align="center"><?=$leaveData->total_days?></div></td>



   <td><div align="center"><?=$leaveData->s_time.' '.$leaveData->s_time_format?></div></td>







   <td><div align="center"><?=$leaveData->e_time.' '.$leaveData->e_time_format?></div></td>



    <td><div align="center"><?=$leaveData->total_hrs?></div></td>



   <td><div align="center"><?=find_a_field('od_type','type_name','id='.$leaveData->type)?></div></td>

   <td><div align="center"><?=$leaveData->daytour_name?></div></td>





   <td><div align="center">







   <?







   if($leaveData->organization!='')



   {



    echo $leaveData->organization;



   }elseif($leaveData->organization2!=''){



    echo $leaveData->organization2;



   }else{



    echo $leaveData->company_name;



   }



   ?>







   </div></td>







   <td><div align="center">







   <?



    if($leaveData->place4!='')



	{



	   echo $leaveData->place4;



	}elseif($leaveData->place!=''){



	   echo $leaveData->place;



	}



	elseif($leaveData->place2!=''){



	   echo $leaveData->place2;



	}elseif($leaveData->place3!=''){



	   echo $leaveData->place3;



	}







   ?>







   </div></td>







   <td><div align="center"><?=$leaveData->project_name?></div></td>







   <td><?=$leaveData->reason?></td>

<td align="center"><?=$leaveData->reporting_authority?></td>
<td align="center"><?=$leaveData->od_status?></td></tr>







<?}



?></tbody></table><br><br><br>












<?







}







if($_POST['report']==201914)







{







?>















<table width="100%" cellspacing="0" cellpadding="2" border="0">







<thead><tr><td style="border:0px; text-align:center; font-size:20px; font-family:bankgothic;" colspan="28"><?=$group->group_name?></td></tr><tr><td style="border:0px;" colspan="28"><div align="center" style="font-size:20px;">OD Report of <? $test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');















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





<th rowspan="2"><div align="center">Reporting Authority Name</div></th>







<th rowspan="2"><div align="center">Submission Date</div></th>



<th rowspan="2"><div align="center">Reporting Authority Approval Date</div></th><th colspan="2"><div align="center">Date Interval</div></th>







<th rowspan="2"><div align="center">Total Days</div></th>







<th colspan="2"><div align="center">Time Interval</div></th>







<th rowspan="2"><div align="center">Total Hours</div></th>















<th rowspan="2"><div align="center">OD Type</div></th>



<th rowspan="2"><div align="center">Day Tour Type</div></th>















<th colspan="3"><div align="center">Description</div></th>



<th rowspan="2"><div align="center">Reason</div></th>



<th rowspan="2"><center>Reporting Authority<center></th>



<th rowspan="2"><center>HR Approval<center></th>

</tr>















<tr>















   <th><div align="center">Start Date</div></th>















   <th><div align="center">End Date</div></th>   <th><div align="center">Start Time</div></th>















   <th><div align="center">End Time</div></th>







   <th><div align="center">Company Name</div></th>















   <th><div align="center">Place/Address</div></th>















   <th><div align="center">Project Name</div></th></tr>







</thead>







<tbody>







<?







if($_POST['department'] !='')















$od_con = ' and p.PBI_DEPARTMENT="'.$_POST['department'].'"';







if($_POST['JOB_LOCATION'] !='')















$od_con .= ' and p.JOB_LOCATION="'.$_POST['JOB_LOCATION'].'"';







if($_POST['PBI_ID'] !='')















$od_con .= ' and p.PBI_CODE="'.$_POST['PBI_ID'].'"';







/*if($_POST['year'] !='')















$od_con .= ' and l.year="'.$_POST['year'].'"';*/







if($_POST['mon'] !='')







  $m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';















   $m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';















$od_con .= ' and l.s_date>="'.$m_s_date.'" and l.e_date<="'.$m_e_date.'"';







//$tr_con .= ' and t.TRANSFER_ORDER_DATE between "'.$_POST['year'].'-'.$_POST['mon'].'-1" and "'.$_POST['year'].'-'.$_POST['mon'].'-30"';















 $sqldd = 'select l.PBI_ID,p.PBI_NAME,p.PBI_CODE,p.PBI_DEPARTMENT,(select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project,p.PBI_SEX,p.PBI_DOJ,

 (select PBI_NAME from personnel_basic_info where PBI_ID=l.PBI_IN_CHARGE) as reporting_auth ,

 p.PBI_DESIGNATION,dept.DEPT_DESC,desg.DESG_DESC,

DATE_FORMAT(l.od_date,"%d-%b-%Y") as od_date,l.total_days,l.total_hrs ,l.type,l.reason,l.s_time,l.e_time,l.place4,l.organization,l.company_name,l.s_time_format,l.e_time_format,l.project_name,l.organization2,l.place,l.place2,l.place3,DATE_FORMAT(l.auth_date,"%d-%b-%Y") as auth_date,DATE_FORMAT(l.s_date,"%d-%b-%Y") as s_date,DATE_FORMAT(l.e_date,"%d-%b-%Y") as e_date,

l.incharge_status as reporting_authority,l.od_status

from hrm_od_info l,personnel_basic_info p,department dept,designation desg where l.PBI_ID=p.PBI_ID  and p.DEPT_ID=dept.DEPT_ID and l.od_status="Not Granted" 
and  p.DESG_ID=desg.DESG_ID '.$od_con.'order by s_date desc';





$querydd=db_query($sqldd);

while($leaveData = mysqli_fetch_object($querydd)){



$entry_by=$data->entry_by;

$year = date('Y');



?>







<tr><td><?=++$s?></td>















	<td><?=$leaveData->PBI_CODE?></td>







<td nowrap="nowrap"><?=$leaveData->PBI_NAME?></td>







 <td><?=$leaveData->DESG_DESC?></td>







  <td><div align="center"><?=$leaveData->DEPT_DESC?></div></td>  <td><div align="center"><?=$leaveData->project?></div></td>



	<td><div align="center"><?=$leaveData->reporting_auth?></div></td>  <td><div align="center"><?=$leaveData->od_date?></div></td>







  <td><div align="center"><?=$leaveData->auth_date?></div></td>   <td><?=$leaveData->s_date?></td>















   <td><?=$leaveData->e_date?></td>







   <td><div align="center"><?=$leaveData->total_days?></div></td>







   <td><div align="center"><?=$leaveData->s_time.' '.$leaveData->s_time_format?></div></td>















   <td><div align="center"><?=$leaveData->e_time.' '.$leaveData->e_time_format?></div></td>







    <td><div align="center"><?=$leaveData->total_hrs?></div></td>







   <td><div align="center"><?=find_a_field('od_type','type_name','id='.$leaveData->type)?></div></td>



   <td><div align="center"><?=$leaveData->daytour_name?></div></td>











   <td><div align="center">















   <?















   if($leaveData->organization!='')







   {







    echo $leaveData->organization;







   }elseif($leaveData->organization2!=''){







    echo $leaveData->organization2;







   }else{







    echo $leaveData->company_name;







   }







   ?>















   </div></td>















   <td><div align="center">















   <?







    if($leaveData->place4!='')







	{







	   echo $leaveData->place4;







	}elseif($leaveData->place!=''){







	   echo $leaveData->place;







	}







	elseif($leaveData->place2!=''){







	   echo $leaveData->place2;







	}elseif($leaveData->place3!=''){







	   echo $leaveData->place3;







	}















   ?>















   </div></td>















   <td><div align="center"><?=$leaveData->project_name?></div></td>















   <td><?=$leaveData->reason?></td>



<td align="center"><?=$leaveData->reporting_authority?></td>

<td align="center"><?=$leaveData->od_status?></td></tr>















<?}







?></tbody></table><br><br><br>






<?



}if($_POST['report']==232)







{



?><table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px; font-family:bank gothic; font-size:20px; font-weight:bold;" colspan="11" align="center">AKSID CORPORETION LTD</td></tr>







<tr><td style="border:0px;" colspan="11" align="center"><?=$str?></td></tr>







<tr>







  <th><div align="center">S/L</div></th>



<th><div align="center">ID</div></th>



<th><div align="center">Name</div></th>







<th><div align="center">Desgnation</div></th><th  align="center"><div align="center">Joining Date</div></th>







<th><div align="center">Job Period</div></th>







<th><div align="center">Total Mark</div></th>



<th><div align="center">Category</div></th>







<th><div align="center">Recommendation</div></th>



</tr></thead>







<tbody>



<?







if($_POST['department']!='')



$cons.=' and a.PBI_DEPARTMENT ="'.$_POST['department'].'"';







if($_POST['JOB_LOCATION']!='')



$cons.=' and a.JOB_LOCATION ="'.$_POST['JOB_LOCATION'].'"';







if($_POST['job_status']!='')



$cons.=' and a.PBI_JOB_STATUS ="'.$_POST['job_status'].'"';







if($_POST['PBI_ID']!='')



$cons.=' and a.PBI_ID ="'.$_POST['PBI_ID'].'"';







if($_POST['gender']!='')



$cons.=' and a.PBI_SEX ="'.$_POST['gender'].'"';







//date_format(a.PBI_DOJ,'%d-%M-%Y')        $sqld="select a.PBI_ID,a.PBI_NAME,date_format(a.PBI_DOJ,'%d-%b-%Y') as joining_date,desg.DESG_DESC as designation,(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department,(select PROJECT_DESC from project where PROJECT_ID=a.JOB_LOCATION) as project,b.total_score,b.recommendation from personnel_basic_info a,performance_appraisal b, designation desg where a.PBI_DESIGNATION=desg.DESG_ID and a.PBI_ID=b.PBI_ID ".$cons." ";



$queryd=db_query($sqld);



while($data = mysqli_fetch_object($queryd)){







if($data->total_score>=90 && $data->total_score<=100){



  $status = 'Outstanding';



}elseif($data->total_score>=76 && $data->total_score<=89){



 $status = 'Very Good';



}elseif($data->total_score>=60 && $data->total_score<=75){



 $status = 'Good';



}elseif($data->total_score>=45 && $data->total_score<=59){



 $status = 'Fair';



}elseif($data->total_score>=31 && $data->total_score<=44){



 $status = 'Needs Improvement';



}elseif($data->total_score>=0 && $data->total_score<=30){



 $status = 'Unsatisfactory';



}$date1 =$data->joining_date;



$date2 = date('Y-12-31');







$diff = abs(strtotime($date2) - strtotime($date1));







$years = floor($diff / (365*60*60*24));



$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));



$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));



?>



<tr><td><?=++$s?></td>



<td align="center"><?=$data->PBI_ID?></td>



<td nowrap="nowrap"><?=$data->PBI_NAME?></td>



  <td nowrap="nowrap"><?=$data->designation?></td>  <td align="center"><?=$data->joining_date?></td>



  <td align="center"><?php printf("%d Y, %d M, %d D\n", $years, $months, $days);?></td>



  <td align="center"><?=$data->total_score?></td>



  <td align="center"><?=$status?></td>







  <td align="center"><?=$data->recommendation?></td>







</tr>



<?



}



?>



</tbody></table><br><br><br>



<div style="width:100%; margin:60px auto"><div style="float:left; width:20%; text-align:center">-------------------<br>Prepared By</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Audit</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Accounts</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Managing Director</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Chairman</div></div>



<?



}if($_POST['report']==781){







?>



<table cellspacing="0" cellpadding="0"  border="0" align="center"><tr>







<thead><tr><td colspan="9" style="text-align: center;border:0px solid white; font-family:bankgothic; font-weight:bold; font-size:18px;"><strong>AKSID CORPORATION LIMITED</strong></td></tr>



<tr><td colspan="9" style="text-align: center;border:0px solid white; font-size:18px;"><?php echo find_a_field('department','DEPT_SHORT_NAME','DEPT_ID='.$_POST['department']);?><?php echo find_a_field('project','PROJECT_DESC','PROJECT_ID='.$_POST['JOB_LOCATION']);?></td></tr>



<tr><tr><td style="border:0px; font-size:16px;" colspan="9" align="center">Billing Period <?$test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');$_SESSION['year'] = $_POST['year'] ;  echo date_format($test, 'M-Y');?>







<div class="date"><?php echo "Reporting Time:". date("h:i A d-m-Y")?></div>







</td></tr>







  <th><div align="center">ID No </div></th>







  <th><div align="center"> NAME </div></th>







<th><div align="center" style="width:auto;">Designation</div></th>







<th><div align="center">Mobile No</div> </th><th><div align="center">Limit</div></th>







<th><div align="center">Billing Amount</div> </th><th><div align="center">Deduction from Salary</div> </th>







<th><div align="center">Remarks</div></th>



</tr>



</thead><tbody><?



$found = find_a_field('salary_attendence','lock_status','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'"');



  if($found==0){







  if($_POST['PBI_ORG']!='')







	$mobileCon =' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';



if ($_POST['JOB_LOCATION'] !='')







	$mobileCon .= ' and t.job_location='.$_POST['JOB_LOCATION'];



if ($_POST['department'] !='')







	$mobileCon .= ' and t.department='.$_POST['department'];



if ($_POST['job_status'] !='')







$mobileCon .=' and a.PBI_JOB_STATUS="'.$_POST['job_status'].'"';   $sqld = 'select t.*, a.PBI_ID, a.PBI_NAME, a.PBI_DOJ, d.DESG_SHORT_NAME as Designation, a.PBI_MOBILE, i.cash_amt







 from salary_attendence t,designation d, personnel_basic_info a, salary_info i







 where i.PBI_ID = t.PBI_ID and t.designation = d.DESG_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and a.PBI_MOBILE>0 '.$mobileCon.' order by a.PBI_MOBILE asc';



}else{



  if($_POST['PBI_ORG']!='')







	$mobileCon =' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';



if ($_POST['JOB_LOCATION'] !='')







	$mobileCon .= ' and t.job_location='.$_POST['JOB_LOCATION'];



if ($_POST['department'] !='')







	$mobileCon .= ' and t.department='.$_POST['department'];



   $sqld = 'select t.*, a.PBI_ID, a.PBI_NAME, a.PBI_DOJ, d.DESG_SHORT_NAME as Designation, a.PBI_MOBILE, i.cash_amt







 from salary_attendence_lock t,designation d, personnel_basic_info a, salary_info i







 where i.PBI_ID = t.PBI_ID and t.designation = d.DESG_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.mobile_bill_amt>0 '.$mobileCon.' order by a.PBI_MOBILE asc';



}



$queryd=db_query($sqld);while($data = mysqli_fetch_object($queryd)){$entry_by=$data->entry_by;?>  <td nowrap="nowrap"><?=$data->PBI_ID?></td>  <td nowrap="nowrap"><?=$data->PBI_NAME?></td>  <td align="left"><?=$data->Designation?></td>  <td><?=$data->PBI_MOBILE?></td>  <td><div align="center"><? echo ($data->mobile_bill_limit>0)? $data->mobile_bill_limit : '';$total_mobile_bill_limit =$total_mobile_bill_limit + $data->mobile_bill_limit;







  ?></div></td>



  <td><div align="center"><?=($data->mobile_bill_amt>0)? $data->mobile_bill_amt : ''; $total_mobile_bill =$total_mobile_bill+ $data->mobile_bill_amt;?></div></td>  <td><div align="center"><?=($data->mobile_deduction>0)? $data->mobile_deduction : '';$total_mobile_deduction=$total_mobile_deduction+$data->mobile_deduction;?></div></td>    <?php







       if($data->mobile_deduction>0){ ?>	   <td>Deduction From Salary</td>	  <?php } else{ ?>	   <td></td>







 <?php }  ?></tr>







<?}?><tr>



  <td colspan="2" ></td>



  <td align="right"><?=($total_cash>0)? $total_cash : '';?></td>  <td align="right"><strong>Total:</strong></td>  <td><strong><div align="center"><?=$total_mobile_bill_limit;?></div></strong></td>



  <td><strong><div align="center"><?= $total_mobile_bill;?></div></strong></td>







  <td><strong><div align="center"><?=$total_mobile_deduction;?></div></strong></td>



  <td>&nbsp;</td>



</tr></tbody></table><br />



<div style="margin-left:300px; width:1170px" align="left">In Words:<?



echo convertNumberMhafuz($total_mobile_bill);?>



</div><br><br><br>



<div style="width:100%; margin:0 auto">



<div style="float:left; width:20%; text-align:center">-------------------<br>Prepared By</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Audit</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Accounts</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Managing Director</div>



<div style="float:left; width:20%; text-align:center">-------------------<br>Chairman</div>



</div>



<?}if($_POST['report']==2244)







{







?>



<table  style="width:auto;margin: 0 auto; padding:0px;"><tr>







<td style="text-align: center;border:0px solid white; font-family:bankgothic; font-weight:bold; font-size:18px;"><strong>AKSID CORPORATION LIMITED</strong></td></tr><tr>







<td style="text-align: center;border:0px solid white; font-size:15px;"><strong>Mobile Bill Summary</strong></td>



</tr>



<tr><td style="text-align: center;border:0px solid white;"><?$test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');  echo date_format($test, 'F-Y');?></td>







</tr></table><table width="50%" border="1" cellspacing="0" cellpadding="0" style="margin:0 auto; padding:0px; "><tr>



<th width="60%" style="text-align:center">Job Location </th>







<th width="40%" style="text-align:center; ">Bill Amount</th></tr>



<?



$found = find_a_field('salary_attendence','lock_status','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'"');



  if($found==0){



    $jl_sql1 = 'select proj.PROJECT_DESC , sum(a.mobile_bill_amt) as total_amt from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.JOB_LOCATION = proj.PROJECT_ID and b.PBI_JOB_STATUS="In Service" GROUP BY proj.PROJECT_ID';



}else{ $jl_sql1 = 'select proj.PROJECT_DESC , sum(a.mobile_bill_amt) as total_amt from salary_attendence_lock a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and  mon='.$_POST['mon'].' and year='.$_POST['year'].' and a.job_location = proj.PROJECT_ID  GROUP BY proj.PROJECT_ID';}



$jl_query1= db_query($jl_sql1 );while($jl1_result1 = mysqli_fetch_object($jl_query1)){







?><tr style="margin:0px;">



<td style="margin:0px;">



<?=$jl1_result1->PROJECT_DESC?>



</td>



<td style="text-align:right"><?=number_format($jl1_result1->total_amt); $all_proj_salary =$all_proj_salary + $jl1_result1->total_amt;?></td>







</tr>







<?







}



?><?$found = find_a_field('salary_attendence','lock_status','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'"');



  if($found==0){  $jl_sql = 'select dept.DEPT_DESC, sum(a.mobile_bill_amt) as total_amt  from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_DEPARTMENT = dept.DEPT_ID and dept.DEPT_ID not in (13) and a.job_location=0 and b.PBI_JOB_STATUS="In Service" GROUP BY dept.DEPT_ID  ';}else{



$jl_sql = 'select dept.DEPT_DESC, sum(a.mobile_bill_amt) as total_amt  from salary_attendence_lock a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and a.department = dept.DEPT_ID and dept.DEPT_ID not in (13)  GROUP BY dept.DEPT_ID  ';



}



$jl_query= db_query($jl_sql );while($jl_result = mysqli_fetch_object($jl_query)){



?>







<tr><td style="text-align:left"><?=$jl_result->DEPT_DESC;?>







</td><td style="text-align: right"><?=number_format($jl_result->total_amt); $all_dept_salary = $all_dept_salary + $jl_result->total_amt;?></td></tr><?}







?><tr>



  <td align="right"><strong>Total Paid Bill Amount</strong></td><td style="text-align:right"><strong>



    <?=number_format($total=$all_dept_salary+$all_proj_salary);?>  </strong></td></tr>



	  <?php







	           $deduction_query = "select sum(mobile_deduction) as mobile_deduction from salary_attendence where mon=".$_POST['mon']." and year=".$_POST['year']." ";







			   $dd = db_query($deduction_query);







			   $data = mysqli_fetch_object($dd);







	  ?>







	  <tr>  <td align="right"><strong>Salary Deduction</strong></td><td style="text-align:right"><strong>    <?=$data->mobile_deduction?>  </strong></td></tr>  <tr>







  <tr>  <td align="right"><strong>Company Actual Bill</strong></td><td style="text-align:right"><strong>    <?=number_format($total-$data->mobile_deduction);?>



  </strong></td></tr>  <td align="right"><strong>Grand Total</strong></td><td style="text-align:right"><strong>    <?=number_format($total_bill=$all_dept_salary+$all_proj_salary);?>



  </strong></td></tr></table><br />







<div style=" margin-left:15%;" align="left">In Words:<?







echo convertNumberMhafuz($total_bill);?>







</div><br><br><br>







<div style="width:100%; margin:0 auto">







<div style="float:left; width:20%; text-align:center">-------------------<br>Prepared By</div><div style="float:left; width:20%; text-align:center">-------------------<br>Audit</div><div style="float:left; width:20%; text-align:center">-------------------<br>Accounts</div><div style="float:left; width:20%; text-align:center">-------------------<br>Managing Director</div><div style="float:left; width:20%; text-align:center">-------------------<br>Chairman</div></div>







<?



}



if($_POST['report']==8)



{



  $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,a.PBI_GROUP as `Group`,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_EDU_QUALIFICATION as qualification,a.PBI_MOBILE as mobile  from personnel_basic_info a where	1 ".$con." order by a.PBI_DOJ asc";







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



      <input name="mobile#<?=$datas[0]?>" type="hidden" id="mobile#<?=$datas[0]?>" value="<?=$datas[11]?>" />  </td>



  <td><div id="po<?=$datas[0]?>"><input type="button" name="Change" value="Change" onclick="getData2('<?=$ajax_page?>', 'po<?=$datas[0]?>',document.getElementById('PBI_ID#<?=$datas[0]?>').value,document.getElementById('mobile#<?=$datas[0]?>').value);" /></div></td>



  </tr>



<?



}



?></tbody></table><?



}



elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}



?></div>



</form>



</body>



</html>
