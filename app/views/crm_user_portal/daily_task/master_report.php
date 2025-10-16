<?
//
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
if($_POST['PBI_GARDEN']!='')
$con.=' and a.PBI_GARDEN = "'.$_POST['PBI_GARDEN'].'"';
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
$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department,a.PBI_GROUP as `Group`,a.PBI_DOJ as joining_date,(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone, (select SUB_REGION_NAME from sub_region where SUB_REGION_CODE=a.PBI_SUB_REGION) as sub_region,(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_MOBILE as mobile  from personnel_basic_info a where	1 ".$con;
break;
case 10001:
$report="Employee Basic Information";
$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department,a.PBI_DOJ as joining_date,a.PBI_DOC2 as confirmation_date,(select EDU_QUA_DESC from edu_qua where EDU_QUA_CODE=a.PBI_EDU_QUALIFICATION) as qualification,a.PBI_MOBILE as mobile,PBI_JOB_STATUS as job_status,(select warehouse_name from warehouse where warehouse_id=a.JOB_LOCATION) as job_location, (select group_name from user_group where id=a.PBI_ORG) as Company  from personnel_basic_info a where	1 ".$con;
break;
case 2:
$report="Employee Salary Information Details";
$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,
(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department, b.consolidated_salary , b.basic_salary, b.dearness_allowance as dearness_all, b.house_rent, b.convenience ,  b.entertainment ,b.medical_allowance as medical_all,b.pf as PF,b.utility_allowance as utility_all,b.children_edu_allowance as CEA_all ,b.other_allowance as other_all,b.responsibility_allowance as respty_all , b.transport_allowance as transport_all, b.fuel_allowance as fual_all, b.superintendent_allowance as supdt_all, b.servant_allowance as servent_all, b.comstry_allowance as comstry_all, b.marketing_allowance as marketing_all, b.realestate_allowance as real_estate, b.car_driver_allowance as car_driver,  b.special_allowance as special_all, (b.consolidated_salary+b.basic_salary+ b.dearness_allowance+b.house_rent+b.convenience+b.entertainment+b.medical_allowance+b.pf+ b.utility_allowance + b.children_edu_allowance + b.other_allowance + b.responsibility_allowance+ b.transport_allowance+ b.fuel_allowance+ b.superintendent_allowance + b.servant_allowance + b.comstry_allowance + b.marketing_allowance + b.realestate_allowance + b.car_driver_allowance + b.special_allowance ) as gross_salary from personnel_basic_info a,salary_info b where	a.PBI_ID=b.PBI_ID ".$con;
break;
case 22:
$report="Employee Salary Information Summary";
$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,
(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department, b.consolidated_salary , b.basic_salary, b.dearness_allowance as dearness_all, (b.house_rent + b.convenience + b.entertainment + b.medical_allowance + b.pf + b.utility_allowance + b.children_edu_allowance + b.other_allowance + b.responsibility_allowance + 
b.transport_allowance + b.fuel_allowance + b.superintendent_allowance + b.servant_allowance + b.comstry_allowance + b.marketing_allowance + b.realestate_allowance + b.car_driver_allowance + b.special_allowance ) as other_all , (b.consolidated_salary+b.basic_salary+ b.dearness_allowance+b.house_rent+b.convenience+b.entertainment+b.medical_allowance+b.pf+ b.utility_allowance + b.children_edu_allowance + b.other_allowance + b.responsibility_allowance+ b.transport_allowance+ b.fuel_allowance+ b.superintendent_allowance + b.servant_allowance + b.comstry_allowance + b.marketing_allowance + b.realestate_allowance + b.car_driver_allowance + b.special_allowance ) as gross_salary , b.mobile_allowance as mobile_all, b.income_tax, (select warehouse_name from warehouse where warehouse_id=a.JOB_LOCATION) as job_location from personnel_basic_info a,salary_info b where	a.PBI_ID=b.PBI_ID ".$con." order by a.PBI_ID asc";
break;
case 3:
$report="Monthly Attendence Report";
if($_POST['mon']>0&&$_POST['year']>0)
{
$mon = $_POST['mon'];
$year = $_POST['year'];
$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,
(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department, b.td as total_day,b.od as off_day,b.hd as holy_day, 	b.lt as late_days, 	b.ab as absent_days,b.lv as leave_days,b.pre as present_days, 	b.pay as payable_days,b.ot as over_time_hour FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
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
$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department,
b.basic_salary, b.consolidated_salary, b.house_rent, b.dearness_allowance, b.contribution, b.pf, b.entertainment, b.medical_allowance, b.ta_da, b.commission, b.total_salary, 
b.mobile_allowance, b.ta_da, b.commission, b.benefits, b.total_benefits, 
b.pf, b.contribution, b.deduction, b.advance_install, total_deduction
FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
break;
case 6:
$report="Salary Payroll Report";
if($_POST['mon']>0&&$_POST['year']>0)
{
$mon = $_POST['mon'];
$year = $_POST['year'];
$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,
(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department,
(b.total_salary) as Gross_salary, b.mobile_allowance, b.ta_da, b.total_deduction, b.total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by b.total_salary desc";
}
break;
case 60:
$report="Salary Statement";
if($_POST['mon']>0&&$_POST['year']>0)
{
$mon = $_POST['mon'];
$year = $_POST['year'];
$sql="SELECT a.PBI_NAME as Name,
b.total_payable as Net_Amount, (select acc_no from salary_info where PBI_ID=b.PBI_ID) as Account_Number FROM personnel_basic_info a, salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by b.total_salary desc";
}
break;
case 7:
$report="Salary Payroll Report";
break;
case 8:
$report="Staff Mobile Information(Changable)";
break;
case 9:
$report="Salary Pay Slip";
if($_POST['mon']>0&&$_POST['year']>0)
{
$mon = $_POST['mon'];
$year = $_POST['year'];
}
break;
case 66:
$report="Salary Payroll Report (Final)";
if($_POST['mon']>0&&$_POST['year']>0)
{
$mon = $_POST['mon'];
$year = $_POST['year'];
$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,b.od,b.hd,b.lt,b.ab,b.lv,b.pre,b.pay,
b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction, (b.total_salary-b.total_deduction) as actual_salary, b.total_benefits,b.total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
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
case 19:
$report="Att Report";
if($_POST['markb']!='')
$con.=' and b.APR_MARKS < "'.$_POST['markb'].'"';
if($_POST['marka']!='')
$con.=' and b.APR_MARKS > "'.$_POST['marka'].'"';
$year=$_POST['year'];
$con.=' and b.APR_YEAR = "'.$year.'"';
if($_POST['emp_id']!=''){ $emp_con = " and d.xenrollid=".$_POST['emp_id']." "; };
echo $sqll="select d.*,u.* from hrm_attdump d, user_activity_management u where 1 ".$emp_con." and u.user_id=d.xenrollid group by d.xdate ";
?>
<table  width="100%" border="0" cellpadding="2" cellspacing="0"><thead><tr><td colspan="12" style="border:0px;" >
<thead>
<tr>
<td>Employee Code</td>
<td>Employee Name</td>
<td>Date</td>
<td>IN</td>
<td>OUT</td>
<td>Latitude</td>
<td>Longitude</td>
</tr>
</thead>
<tbody>
<?
$query = db_query($sqll);
while($row = mysqli_fetch_object($query)){
?>
<tr>
<td><?=$row->xenrollid ?></td>
<td><?=$row->fname ?></td>
<td><?=$row->xdate ?></td>
<td><?=find_a_field('hrm_attdump','entry_time',' 1 and xdate="'.$row->xdate.'" order by sl asc limit 1'); echo "select entry_time from hrm_attdump where 1 and xdate='".$row->xdate."' order by sl asc limit 1"?></td>
<td><?=$row->xdate ?></td>
<td><a href="https://www.latlong.net/c/?lat=<?=$row->latitude?>&long=<?=$row->longitude?>" target="_blank">ADDRESS</a></td>
</tr>
<? } ?>
</tbody>
<tfoot></tfoot>
</table>
<?
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
if($_POST['team_name']!='')
$con.=' and a.team_name = "'.$_POST['team_name'].'"';
$sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.mobile_no as mobile_no,a.propritor_name_e as proprietor_name, a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, r.BRANCH_NAME as region,w.warehouse_name as depot , a.canceled as active
from dealer_info a, area ar, zon z, branch r, warehouse w
where a.area_code=ar.AREA_CODE and ar.ZONE_ID=z.ZONE_CODE and 
z.REGION_ID=r.BRANCH_ID and a.depot=w.warehouse_id and a.dealer_type='Distributor' 
".$con." order by a.dealer_code asc";
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
if($_POST['team_name']!='')
$con.=' and a.team_name = "'.$_POST['team_name'].'"';
$sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.mobile_no as mobile_no,a.propritor_name_e as propritor_name ,a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, r.BRANCH_NAME as region, a.canceled as active, a.commission from dealer_info a, area ar, zon z, branch r
where ar.AREA_CODE=a.area_code and z.ZONE_CODE=ar.ZONE_ID and r.BRANCH_ID=z.REGION_ID and a.dealer_type='SuperShop'  ".$con." order by a.dealer_code desc";
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
if($_POST['team_name']!='')
$con.=' and a.team_name = "'.$_POST['team_name'].'"';
$sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.mobile_no as mobile_no,a.propritor_name_e as propritor_name ,a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, r.BRANCH_NAME as region, a.canceled as active, a.commission from dealer_info a, area ar, zon z, branch r
where ar.AREA_CODE=a.area_code and z.ZONE_CODE=ar.ZONE_ID and r.BRANCH_ID=z.REGION_ID and a.dealer_type='Corporate'  ".$con." order by a.dealer_code desc";
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
if($_POST['team_name']!='')
$con.=' and a.team_name = "'.$_POST['team_name'].'"';
$sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.mobile_no as mobile_no,a.propritor_name_e as propritor_name ,a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, r.BRANCH_NAME as region, a.canceled as active, a.commission from dealer_info a, area ar, zon z, branch r
where ar.AREA_CODE=a.area_code and z.ZONE_CODE=ar.ZONE_ID and r.BRANCH_ID=z.REGION_ID and a.dealer_type='Personal'  ".$con." order by a.dealer_code desc";
break;
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>master report all</title>
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
<form action="" method="post">
<div align="center" id="pr">
<input type="button" value="Print" onClick="hide();window.print();"/>
</div>
<div class="main">
<?
//echo $sql;
$str 	.= '<div class="header">';
//if(isset($_SESSION['company_name'])) 
$str 	.= '<h2 style="font-size:24px;">ERP COM BD</h2>';
if(isset($report)) 
$str 	.= '<h2>'.$report.'</h2>';
if(isset($to_date)) 
$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';
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
if($_POST['report']==7000) 
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
if($_POST['report']==8) 
{
echo $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department,a.PBI_GROUP as `Group`,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_EDU_QUALIFICATION as qualification,a.PBI_MOBILE as mobile  from personnel_basic_info a where	1 ".$con;
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
<td><div id="po<?=$datas[0]?>"><input type="button" name="Change" value="Change" onClick="getData2('<?=$ajax_page?>', 'po<?=$datas[0]?>',document.getElementById('PBI_ID#<?=$datas[0]?>').value,document.getElementById('mobile#<?=$datas[0]?>').value);" /></div></td>
</tr>
<?
}
?></tbody></table>
<?
}
elseif($_POST['report']==9)
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
$sql="SELECT a.*,b.*, d.DESG_SHORT_NAME, p.DEPT_DESC FROM personnel_basic_info a,salary_attendence b, designation d, department p where	a.PBI_ID=b.PBI_ID and a.PBI_DESIGNATION=d.DESG_ID and a.PBI_DEPARTMENT=p.DEPT_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_ID asc";
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
<td rowspan="2" align="center">ID: <strong>
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
<?=$data->ta_da; $tada_total+=$data->ta_da;?>
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
</strong>)</td>
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
<td align="center" style="text-align:right"><strong><?= number_format( $tada_total,2);?></strong></td>
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
elseif($_POST['report']==12345)
{
$report = "Daily Task Report";
echo $str;
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
<th>S/N</th>
<th>Date</th>
<th>Name</th>
<th>Project</th>
<!--<th>Daily Task</th>-->
<th>In Time</th>
<th>Out Time</th>
<th>Bus</th>
<th>Rickshaw</th>
<th>Lunch</th>
<th>Others</th>
<th>Total</th>
</tr>
<?php
if ($_POST['emp_name']!= "")
$task_con = ' and m.PBI_ID = '.$_POST['emp_name'];
if (($_POST['f_date']!= "") && ($_POST['t_date']!= ""))
$task_con .= ' and m.task_date >= "'.$_POST['f_date'].'" and m.task_date <= "'.$_POST['t_date'].'"'; 
$task_query = 'select m.* 
from daily_task_master m
where 1   ' .$task_con.'  order by m.task_date asc'; 
//echo $task_query = 'select m.*,s.task_desc from daily_task_master m
// LEFT JOIN daily_task_details s 
// ON m.task_id=s.task_id
//where 1   ' .$task_con.'  order by m.task_date asc'; 
$task_sql = db_query($task_query);
$i = 0;
while($task_data = mysqli_fetch_object($task_sql)){
$i++;
$grand_total+=$task_data->total;
?>
<tr>
<td><?php echo $i?></td>
<td><?php echo $task_data->task_date ?></td>
<td><?php echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$task_data->PBI_ID) ?> </td>
<td><?php 
$add_project=find_a_field('project','PROJECT_NAME','PROJECT_ID='.$task_data->add_project);
$project_id=find_a_field('project','PROJECT_NAME','PROJECT_ID='.$task_data->project_id); 
echo ($add_project!='')? $project_id.'<b> + </b>'.$add_project : $project_id ;
?> </td>
<?php /*?><td><?php echo $task_data->task_desc; ?> </td><?php */?>
<td><?php echo $task_data->in_time ?> </td>
<td><?php echo $task_data->out_time ?> </td>
<td><?php echo $task_data->bus_exp ?> </td>
<td><?php echo $task_data->rickshaw ?> </td>
<td><?php echo $task_data->lunch ?> </td>
<td><?php echo $task_data->other ?> </td>
<td><?php echo $task_data->total ?> </td>
</tr>
<?php
}
?>
<tr>
<td colspan="10" align="right">Grand Total : </td>
<td><?php echo $grand_total ?></td>
</tr>
</table>
<? }

elseif($_POST['report']==420)
{
if($_POST['project_id'] !=''){
?>
<div align="center" style="font-size:18px;">Task Status Report Details</div>
<div align="center" style="font-size:18px;">Project Name : <?=find_a_field('project','PROJECT_NAME','PROJECT_ID='.$_POST['project_id'])?></div>
<? } else{
 ?>
<div align="center" style="font-size:18px;">Given Task Status Report Details</div>

<? } ?>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
<th>S/N</th>
<th>Date</th>
<th>Name</th>
<th>Remarks</th>
<th>Master task status</th>
<th>Project</th>
<th>Module</th>
<th>Task Name</th>
<th>Status</th>
<th>Task Details</th>
<th>Details Task Name</th>
<th>Details Task Desc</th>
<th>Details Status</th>
<th>Emp.Remarks</th>

</tr>

<?php
if ($_POST['emp_name']!= "")
$task_conn = ' and m.PBI_ID = '.$_POST['emp_name'];
//if ($_POST['project_id']!= "")
// $task_conn .= ' and m.project_id = '.$_POST['project_id'];
if (($_POST['f_date']!= "") && ($_POST['t_date']!= ""))
$task_conn .= ' and m.task_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
if ($_POST['emp_name']!= "")
$task_conn .= ' and m.given_to = "'.$_POST['emp_name'].'" ';


 $task_queryy = 'select m.*  from daily_give_task_master m where 1  '.$task_conn.'  order by m.task_date,m.given_to asc'; 
$task_sqll = db_query($task_queryy);
$i = 0;
while($task_dataa=mysqli_fetch_object($task_sqll)){
$i++;

 $details_query='select d.id, d.id, d.task_id, p.PROJECT_NAME,(select MODUL_NAME FROM project_modul where MODUL_ID=d.module_id ) as MODUL_NAME, d.task_name, d.task_desc as description from daily_give_task_details d, project p where d.project_name=p.PROJECT_ID  and d.task_id='.$task_dataa->task_id;
$query=db_query($details_query);

//while($deitals=mysqli_fetch_object($query)){
//echo $rowspan=find_a_field('daily_give_task_details','count(task_id)','task_id='.$task_dataa->task_id);

?>
<tr>
<td ><?php echo $i;?></td>
<td ><?php echo $task_dataa->task_date ?></td>
<td ><?php echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$task_dataa->given_to) ?> </td>
<td ><?php echo $task_dataa->remarks;?></td>
<td ><?php echo $task_dataa->status;?></td>
<td><?php  $s="select p.PROJECT_NAME FROM project p,daily_give_task_details d WHERE d.task_id=".$task_dataa->task_id." and d.project_name=p.PROJECT_ID";
          $q=db_query($s);
           while($r=mysqli_fetch_object($q)){echo $r->PROJECT_NAME.'</br>';}
   ?> </td>

<td><?php  $s="select p.MODUL_NAME FROM project_modul p,daily_give_task_details d where p.MODUL_ID=d.module_id and d.task_id=".$task_dataa->task_id ;
          $q=db_query($s);
           while($r=mysqli_fetch_object($q)){echo $r->MODUL_NAME.'</br>';}
   ?> </td>

<td><?php  $s="select d.task_name from daily_give_task_details d where  d.task_id=".$task_dataa->task_id ;
           $q=db_query($s);
           while($r=mysqli_fetch_object($q)){echo $r->task_name.'</br>';}
   ?> </td>
   
   <td><?php  $s="select d.status from daily_give_task_details d where  d.task_id=".$task_dataa->task_id ;
           $q=db_query($s);
           while($r=mysqli_fetch_object($q)){echo $r->status.'</br>';}
   ?> </td>

<td><?php  $s="select d.task_desc from daily_give_task_details d where  d.task_id=".$task_dataa->task_id ;
           $q=db_query($s);
           while($r=mysqli_fetch_object($q)){echo $r->task_desc.'</br>';}
   ?></td>
<!---------test------->

<td><?php  $s="select d.task_name from given_task_details d where  d.master_id=".$task_dataa->task_id ;
           $q=db_query($s);
           while($r=mysqli_fetch_object($q)){echo $r->task_name.'</br>';}
   ?></td>
   
   <td><?php  $s="select d.task_desc from given_task_details d where  d.master_id=".$task_dataa->task_id ;
           $q=db_query($s);
           while($r=mysqli_fetch_object($q)){echo $r->task_desc.'</br>';}
   ?></td>
   
   <td><?php  $s="select d.status from given_task_details d where  d.master_id=".$task_dataa->task_id ;
           $q=db_query($s);
           while($r=mysqli_fetch_object($q)){echo $r->status.'</br>';}
   ?></td>
   
   <td><?php  $s="select d.remarks from given_task_details d where  d.master_id=".$task_dataa->task_id ;
           $q=db_query($s);
           while($r=mysqli_fetch_object($q)){echo $r->remarks.'</br>';}
   ?></td>   

</tr>
<?php
}
?>
</table>
<? }
elseif($_POST['report']==5482)
{
if($_POST['project_id'] !=''){
?>
<div align="center" style="font-size:18px;">Task Status Report Details</div>
<div align="center" style="font-size:18px;">Project Name : <?=find_a_field('project','PROJECT_NAME','PROJECT_ID='.$_POST['project_id'])?></div>
<? } else{ 
echo $str;
} ?>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
<th>S/N</th>
<th>Date</th>
<th>Name</th>
<th>Project</th>
<th>In Time</th>
<th>Out Time</th>
<th>Module</th>
<th>Task Name</th>
<th>Task Details</th>
<th>Remarks</th>
</tr>
<?php
if ($_POST['emp_name']!= "")
$task_conn = ' and m.PBI_ID = '.$_POST['emp_name'];
//if ($_POST['project_id']!= "")
// $task_conn .= ' and m.project_id = '.$_POST['project_id'];
if (($_POST['f_date']!= "") && ($_POST['t_date']!= ""))
$task_conn .= ' and m.task_date >= "'.$_POST['f_date'].'" and m.task_date <= "'.$_POST['t_date'].'"';
$task_queryy = 'select m.*,s.project_name,s.task_name,s.task_desc  
from daily_task_master m 
LEFT JOIN  daily_task_details s
ON m.task_id=s.task_id
where 1 and m.project_id=s.project_name '.$task_conn.'  order by m.task_date asc'; 
$task_sqll = db_query($task_queryy);
$i = 0;
while($task_dataa = mysqli_fetch_object($task_sqll)){
$i++;
$grand_total+=$task_data->total;
?>
<tr>
<td><?php echo $i?></td>
<td><?php echo $task_dataa->task_date ?></td>
<td><?php echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$task_dataa->PBI_ID) ?> </td>
<td><?php echo find_a_field('project','PROJECT_NAME','PROJECT_ID='.$task_dataa->project_name)?> </td>
<td><?php echo $task_dataa->in_time ?> </td>
<td><?php echo $task_dataa->out_time ?> </td>
<td><?php echo $task_dataa->MODUL_NAME ?> </td>
<?php /*?><td><?php echo find_a_field('daily_task_details','task_name','task_id='.$task_dataa->task_id)?> </td><?php */?>
<td><?php echo $task_dataa->task_name ?> </td>
<?php /*?><td><?php echo find_a_field('daily_task_details','task_desc','task_id='.$task_dataa->task_id)?> </td><?php */?>
<td><?php echo $task_dataa->task_desc ?> </td>
<td></td>
</tr>
<?php
}
?>
</table>
<? }
elseif($_POST['report']==007)
{
if($_POST['emp_name'] !=''){
?>
<div align="center" style="font-size:18px;">User Wise Schedule</div>
<div align="center" style="font-size:18px;">User Name : <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$_POST['emp_name'])?></div>
<? }  ?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
<th>S/N</th>
<th>Date</th>
<th>Employe ID</th>
<th>Name</th>
<th>Project</th>
</tr>
<?php
if ($_POST['emp_name']!= "")
$task_conn = ' and e.PBI_ID = '.$_POST['emp_name'];
if ($_POST['project_id']!= "")
$task_conn .= ' and p.project_id = '.$_POST['project_id'];
if (($_POST['f_date']!= "") && ($_POST['t_date']!= ""))
$task_conn .= ' and sc.schedule >= "'.$_POST['f_date'].'" and sc.schedule <= "'.$_POST['t_date'].'"';
$task_queryy = 'select sc.*  
from project p,personnel_basic_info e,schedule_setup_new sc
where 1 and p.project_id=sc.prjid and e.pbi_id=sc.impid '.$task_conn.' order by schedule asc'; 
$task_sqll = db_query($task_queryy);
$i = 0;
while($task_dataa = mysqli_fetch_object($task_sqll)){
$i++;
$grand_total+=$task_data->total;
?>
<tr>
<td><?php echo $i?></td>
<td><?php echo $task_dataa->schedule ?></td>
<td><?php echo $task_dataa->impid ?> </td>
<td><?php echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$task_dataa->impid) ?> </td>
<td><?php echo find_a_field('project','PROJECT_NAME','PROJECT_ID='.$task_dataa->prjid)?> </td>
</tr>
<?php
}
?>
</table>
<? 
}
// Leave Report Modified on 2019-09-11
elseif ($_POST['report']==20190911)
{
if($_POST['emp_name'] !=''){
?>
<div align="center" style="font-size:18px;">Leave Summery Report</div>
<div align="center" style="font-size:18px;">User Name : <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$_POST['emp_name'])?></div>
<? }  ?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
<th>S/N</th>
<th>Date</th>
<th>Employe ID</th>
<th>Name</th>
<th>Leave Duration Date</th>
<th>Total Leave</th>
<th>Leave Type</th>
<th>Leave For</th>
<th>Responsible Person</th>
<th>Status</th>
</tr>
<?php
if ($_POST['emp_name']!= "")
$task_conn = ' and l.PBI_ID = '.$_POST['emp_name'];
// if ($_POST['project_id']!= "")
//$task_conn .= ' and p.project_id = '.$_POST['project_id'];
if (($_POST['f_date']!= "") && ($_POST['t_date']!= ""))
$task_conn .= ' and l.leave_apply_date >= "'.$_POST['f_date'].'" and l.leave_apply_date <= "'.$_POST['t_date'].'"';
$task_queryy = 'SELECT l.* ,e.PBI_NAME,t.leave_type_name
FROM hrm_leave_info l,personnel_basic_info e, hrm_leave_type t
WHERE 1 and l.PBI_ID=e.pbi_id and t.id=l.type  '.$task_conn.' order by l.leave_apply_date;'; 
$task_sqll = db_query($task_queryy);
$i = 0;
while($task_dataa = mysqli_fetch_object($task_sqll)){
$i++;
$grand_total+=$task_data->total;
?>
<tr>
<td><?php echo $i?></td>
<td><?php echo $task_dataa->leave_apply_date ?></td>
<td><?php echo $task_dataa->PBI_ID ?> </td>
<td><?php echo $task_dataa->PBI_NAME; ?> </td>
<td><?php echo $task_dataa->s_date;?> -To- <?=$task_dataa->e_date;?></td>
<td><?php echo $task_dataa->total_days;?> </td>
<td><?php echo $task_dataa->leave_type_name;?> </td>
<td><?php echo $task_dataa->reason;?> </td>
<td><?php echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$task_dataa->leave_responsibility_name);?> </td>
<td><?php echo $task_dataa->leave_status;?> </td>
</tr>
<?php /*?><tr bordercolordark="#FFFFFF">
<td colspan="6"><span><? echo $tleave=$tleave+$task_dataa->total_days;?></span></td>
<td colspan="4">&nbsp;</td>
</tr><?php */?>
<?php
}
?>
</table>
<? 
}
elseif ($_POST['report']==050919)
{
?>
<div align="center" style="font-size:18px;">User Wise Schedule</div>
<div align="center" style="font-size:18px;">User Name : <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$_POST['emp_name'])?></div>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
<th>S/N</th>
<th>Date</th>
<th>Employe ID</th>
<th>Name</th>
<th>Project</th>
</tr>
<?php
//if ($_POST['emp_name']!= "")
// $task_conn = ' and e.PBI_ID = '.$_POST['emp_name'];
// if ($_POST['project_id']!= "")
// $task_conn .= ' and p.project_id = '.$_POST['project_id'];
if (($_POST['f_date']!= "") && ($_POST['t_date']!= "")){
$tconn .= ' and sc.schedule >= "'.$_POST['f_date'].'" and sc.schedule <= "'.$_POST['t_date'].'"';
}
echo $task_queryy1 = 'select sc.*,p.PROJECT_NAME, e.PBI_NAME 
from project p,personnel_basic_info e,schedule_setup_new sc
where 1 and p.project_id=sc.prjid and e.pbi_id=sc.impid '.$tconn.' order by sc.schedule asc'; 
$task_sql11 = db_query($task_queryy1);
$i = 0;
while($task_dataaa = mysqli_fetch_object($task_sql11)){
$i++;
//$grand_total+=$task_data->total;
?>
<tr>
<td><?php echo $i?></td>
<td><?php echo $task_dataaa->schedule ?></td>
<td><?php echo $task_dataaa->impid ?> </td>
<td><?php echo $task_dataaa->PROJECT_NAME ?> </td>
<td><?php echo $task_dataaa->PBI_NAME?> </td>
</tr>
<?php
}
?>
</table>
<? 
}
elseif($_POST['report']==5481)
{
if($_POST['project_id'] !=''){
?>
<div align="center" style="font-size:18px;">Task Status Report Details</div>
<div align="center" style="font-size:18px;">Project Name : <?=find_a_field('project','PROJECT_NAME','PROJECT_ID='.$_POST['project_id'])?></div>
<? } ?>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>
<?php 
if ($_POST['emp_name']!= "")
$task_conn = ' and impid = '.$_POST['emp_name'];
if ($_POST['project_id']!= "")
$task_conn .= ' and prjid = '.$_POST['project_id'];
if (($_POST['f_date']!= "") && ($_POST['t_date']!= ""))
$task_conn .= ' and schedule between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
echo $str;?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
<th>S/N</th>
<th>Schedule Date</th>
<th>Name</th>
<th>Project</th>
<th>In Time</th>
<th>Out Time</th>
<th>Status</th>
<th>Latitude</th>
<th>Longitude</th>
<th>Location</th>
<th>Location Info</th>
</tr>
<?php
//$sql = 'select min(ztime) as in_time, max(ztime) as out_time,xenrollid,xdate,latitude,longitude from hrm_attdump where xenrollid="'.$_SESSION['employee_selected'].'" and xdate between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" group by xenrollid, xdate'; 
//$sql='select ssn.impid,had.xdate as schedule,pbi.PBI_NAME, p.PROJECT_NAME,ssn.note, time(min(had.ztime)) as in_time,time(max(had.xtime)) as out_time, had.latitude,had.longitude
//from hrm_attdump had 
//left join schedule_setup_new ssn on ssn.schedule = had.xdate and ssn.impid = had.bizid 
//LEFT join personnel_basic_info pbi on pbi.PBI_ID = had.bizid 
//LEFT join project p on p.PROJECT_ID = ssn.prjid 
//
//where 1 '.$task_conn.' GROUP BY had.xdate,ssn.impid ORDER BY had.xdate,ssn.impid ASC'; 
// and ssn.schedule between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"  and ssn.impid=
echo $sql = "select * from schedule_setup_new  where 1 ".$task_conn."";
$query = db_query($sql);
$i = 0;
while($row = mysqli_fetch_object($query)){
$i++
?>
<tr>
<td><?=$i?></td>

<td><?=$row->schedule?></td>

<td><?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID='.$row->impid)?></td>

<td><?=find_a_field('project', 'PROJECT_NAME', 'PROJECT_ID='.$row->prjid)?></td>

<td><?=$in_time = find_a_field('hrm_attdump', 'time(min(ztime))', 'xdate="'.$row->schedule.'" and bizid = '.$row->impid.'')?></td>

<td><?=$out_time = find_a_field('hrm_attdump', 'time(max(ztime))', 'xdate="'.$row->schedule.'" and bizid = '.$row->impid.'')?></td>

<td><? if($in_time <= '10:00:00' && $in_time >= '06:00:00')

{echo '<span style="background-color:green;color:white;width:100%;">OK</span>';}

elseif($in_time <= '11:30:00' && $in_time >= '10:00:01' )

{ echo '<span style="background-color:orange;color:black;width:100%;">Late(Leave/3late)</span>';}

elseif($in_time <= '12:30:00' && $in_time >= '11:30:01' )

{ echo '<span style="background-color:#9F035B;color:white;width:100%;">Half Day Leave</span>';}

else{ echo '<span style="background-color:red;color:white;width:100%;">Absent</span>';} ?></td>

<td><?=$lati = find_a_field('hrm_attdump', 'latitude', 'xdate="'.$row->schedule.'" and bizid = '.$row->impid.'')?></td>

<td><?=$long = find_a_field('hrm_attdump', 'longitude', 'xdate="'.$row->schedule.'" and bizid = '.$row->impid.'')?></td>

<td>
<?  if( $lati !='' && $long!=''){ ?>
<iframe 
  width="auto" 
  height="auto" 
  frameborder="0" 
  scrolling="no" 
  marginheight="0" 
  marginwidth="0" 
  src="https://maps.google.com/maps?q=<?=$lati?>,<?=$long?>&hl=en&z=12&amp;output=embed">
 </iframe>
 
 <? } else { echo "NO Location Found"; }?>
 </td>
 <td><? if (stristr($_SERVER['HTTP_USER_AGENT'],'mobi')!==FALSE) {
    echo 'mobile device detected';
}  else { echo "Pc"; }  echo $ipAddress = $_SERVER['REMOTE_ADDR'];       echo $_SERVER['HTTP_REFERER'];
  echo $_SERVER['HTTP_REFERER'];
  echo $_SERVER['HTTP_USER_AGENT'];  ?></td>
</tr>
<?
}
?>
</table>
</br>
<?php /*?><? $absence=find_all_field_sql("select s.* from schedule_setup_new s, hrm_attdump h where s.impid!=h.bizid and s.schedule=h.xdate order by s.schedule ");
$leave = db_query($absence);
$i = 0;
while($row = mysqli_fetch_object($leave)){
{?>
<table  width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<th colspan="9"><span style=" font-size:14px; text-align:center">Daily Absence Employee List.</span></th>
</thead>
<tr>
<td><? echo ++$i?></td>
<td><?php echo $row->schedule; ?></td>
<td><?php echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$row->impid) ?></td>
<td><?php echo find_a_field('project','PROJECT_NAME','PROJECT_ID='.$row->prjid) ?></td>
<td style="background:#FF0000; color:#000000">lEAVE</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<? }?>
</table><?php */?>
<? }
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?>
</div>
</form>
</body>

</html>