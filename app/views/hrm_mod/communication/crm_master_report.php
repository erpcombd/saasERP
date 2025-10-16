



<?



session_start();



 
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";



//require "../../classes/report.class.php";



//require_once ('../../common/class.numbertoword.php');



date_default_timezone_set('Asia/Dhaka');







if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)



{



	if($_POST['name']!='')



	$con.=' and a.PBI_NAME like "%'.$_POST['name'].'%"';



	



	if($_POST['PBI_ORG']!=''){



	if($_POST['report']==64&&$_POST['PBI_ORG']=='2')



	$con.=' and a.PBI_ORG IN (1,2)';



	else $con.=' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';



	}







	



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



	



	if($_POST['report']!=778 && $_POST['report']!=79 && $_POST['report']!=1){



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











 $sql="select a.PBI_ID,



a.PBI_CODE as EMP_ID,a.PBI_NAME as Name,



(select DESG_DESC from designation where DESG_ID = a.PBI_DESIGNATION) as designation,(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department,(select PBI_NAME from personnel_basic_info where PBI_ID=a.incharge_id) as incharge,a.PBI_DOC2 as confirmation_date,a.PBI_RELIGION as religion,a.PBI_NATIONALITY as nationality,a.PBI_JOB_STATUS as job_status,a.PBI_POB as place_of_birth,



BLOOD_GROUP as blood_group,







DATE_FORMAT(a.PBI_DOJ,'%d-%m-%Y') as joining_date,



CONCAT(TIMESTAMPDIFF(YEAR, `PBI_DOJ`, CURDATE()),' Year,',TIMESTAMPDIFF(MONTH, `PBI_DOJ`, CURDATE()) % 12,' mon') as service_lenght,a.PBI_SEX as gender,a.PBI_MARITAL_STA as marital_status,a.PBI_DOB as date_of_birth,a.PBI_EDU_QUALIFICATION as Graduation,a.PBI_FATHER_NAME as father_name,a.PBI_MOTHER_NAME as mother_name,















a.PBI_MOBILE as office_mobile,a.PBI_MOBILE_ALT as personnel_mobile,a.PBI_EMAIL as office_email,a.PBI_EMAIL_ALT as personnel_email,







EMPLOYMENT_TYPE as employment_type







from personnel_basic_info a 



where	1 ".$con." order by a.JOB_LOCATION";







// DATE_FORMAT(a.PBI_DOC,'%d-%m-%Y') as due_confirmation_date,



// (select DESG_DESC from designation where DESG_SHORT_NAME=a.PBI_DESIGNATION) as designation,



//  schedule_type,punch_type,define_offday,define_schedule,general_schedule,grace_type,employee_type







break;









case 20444 :



$report="All Peoples Information";



break;







case 22:



$report="Project Information Report";











$sql="select project_id as company_ID, project_desc  as Company_name, project_detail as Company_details_Information from crm_project where 1";



 



break;











case 23:



$report="Service/Product Report";











  $sql="select service_id , service_name,service_detail as service_detail_information  from crm_service where 1"



;



 



break;











case 201:



$report="Customer Information";



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



(select LOCATION_NAME from office_location where id=a.JOB_LOCATION) JOB_LOCATION,a.PBI_POB as home_dist, PBI_PERMANENT_ADD as address



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



	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,



	(select DESG_DESC from designation where DESG_ID = a.DESG_ID) as designation,



	a.PBI_DEPARTMENT as department, b.td as total_day,b.od as off_day,b.hd as holy_day, 	b.lt as late_days, 	b.ab as absent_days,b.lv as leave_days,b.pre as present_days, 	b.pay as payable_days,b.ot as over_time_hour FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;



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



	$mon = $_POST['mon'];



	$year = $_POST['year'];



	$totalDays=date('t',mktime(0,0,0,$mon,01,$year));



	$startDate=$year.'-01-01';



	$endDate=$year.'-12-'.$totalDays;



	



	// $sql="SELECT p.PBI_CODE as Emp_ID,p.PBI_NAME as Employee_Name,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation,p.PBI_DOJ as joining_date, l.casual,l.medical  FROM hrm_leave_info l, personnel_basic_info p where l.s_date>='".$startDate."' and l.e_date<='".$endDate."' and p.PBI_ID=l.PBI_ID";



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



	



case 979:



	$report="Vehicle Management";



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



        $report="Daily Task Report";



		break;

		

		case 205:



        $report="Daily Conveyance Report";



		break;



		



		case 204:



        $report="Communication Report (Customer Wise)";



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





<title><?=date('Y-m-d')?> | ERP.COM.BD</title>

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



	



		



		



		if($_POST['f_date']!='' && $_POST['t_date']!='') 



		$str 	.= 'Time Duration : '.$_POST['f_date'].' TO '.$_POST['t_date'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';



		



		if($_POST['project_id']!='') 



		$str 	.= '<br>Company : '.find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$_POST['project_id'].'"').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';



		



		



		if($_POST['service_id']!='') 



		$str 	.= '<br>Service  : '.find_a_field('crm_service','service_name','service_id="'.$_POST['service_id'].'"').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';



		



		



		if($_POST['PBI_ID']!='') 



		$str 	.= '<br>Employee Name  : '.find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$_POST['PBI_ID'].'"').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';



		



		



		if($_POST['dealer_code']!='') 



		$str 	.= '<br>Customer Person  : '.find_a_field('crm_customer_info','dealer_name_e','dealer_code="'.$_POST['dealer_code'].'"').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';



		



		



		$str 	.= '</h2>';



		$str 	.= '</div>';



		//if(isset($_SESSION['company_logo'])) 



		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';



		



		$str 	.= '<div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';



	



if($_POST['report']==7) // payroll information



{







$sql1="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,a.PBI_GROUP,







(select pbi_held_up from salary_attendence where PBI_ID=a.PBI_ID order by id desc limit 1) as held,



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



t.*,a.PBI_ID,a.PBI_NAME,d.DESG_DESC PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ,  t.pbi_held_up held_up_status,s.cash_bank,s.cash







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



if($_POST['report']==781) 



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



$bank = $_POST['cash_bank'];



$sqld = 'select 



s.basic_salary actual_basic_salary,



s.special_allowance actual_special_allawance, 



t.*,a.PBI_ID,a.PBI_NAME,a.PBI_GROUP,d.DESG_SHORT_NAME PBI_DESIGNATION ,a.PBI_DEPARTMENT, a.PBI_DOJ,



t.pbi_held_up held_up_status,s.cash_bank,s.cash







from  salary_attendence t, personnel_basic_info a, designation d, salary_info s 



where t.pbi_held_up=0 and s.cash_bank="'.$bank.'" and d.DESG_ID=t.pbi_designation 



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







if($_POST['report']==20444) 



{



?>



<html>

<head>

<title><?=date('Y-m-d')?> | ERP.COM.BD</title>



    <link href="../../vendors/bootstrap/dist/css/buttons.bootstrap.min.css" rel="stylesheet">



    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">



</head>

<body>







<table width="100%" cellspacing="0" cellpadding="2" border="0">







<thead><tr><th style="border:0px;" colspan="7"><h3 style="text-align:center; margin-bottom: 50px; font-weight: bold;">All Peoples Information</h3></th></tr>

</thead>

</table>





<table id="example" class="display nowrap table" style="width:100%" cellpadding="0" cellspacing="0">



        <thead style="background: #1ABB9C;">



            <tr>

			<th>Code</th>

<th>Mobile NO</th>

<th>Telephone NO</th>

<th>Name</th>

<th>Address</th>

<th>Father Name</th>

<th>Mother Name</th>

<th>Date Of Birth</th>

<th>Nationality</th>

<th>Religion</th>

<th>Bank Acc NO</th>

<th>Spouse Name</th>

<th>Gender</th>

<th>Email</th>

<th>Marital Status</th>

<th>Home Mobil No</th>

<th>NID NO</th>

<th>Parmanent Street</th>

<th>Parmanent Apartment</th>

<th>Parmanent City</th>

<th>Parmanent Postal Code</th>

<th>Parmanent District</th>

<th>Parmanent Other Info</th>

<th>Present Street</th>

<th>Present Apartment</th>

<th>Present City</th>

<th>Present Postal Code</th>

<th>Present District</th>

<th>Present Other Info</th>

<th>Customer</th>



<th>Designation</th>

<th>Department</th>

<th>Office Email</th>

<th>Office Mobile No</th>

<th>Office Other Info</th>

<th>Children Info</th>

<th>Wife Birth Day</th>

<th>Wife Occupation</th>

<th>Wife Name</th>

			

			</tr>



        </thead>



        <tbody>





<?

$select = 'select * from crm_customer_info where 1';

$query = db_query($select);



while($row = mysqli_fetch_object($query)){



?>



        

		<tr>



		<td><?=$row->dealer_code ?></td>



		<td><?=$row->mobile_no ?></td>



		<td><?=$row->tel_no ?></td>



		<td><?=$row->dealer_name_e ?></td>



		<td><?=$row->address_e ?></td>



		<td><?=$row->father_name ?></td>



		<td><?=$row->mother_name ?></td>



		<td><?=$row->date_of_birth ?></td>



		<td><?=$row->nationality ?></td>



		<td><?=$row->religion ?></td>

		<td><?=$row->bank_acc_no ?></td>



		<td><?=$row->spouse_name ?></td>



		<td><?=$row->gender ?></td>



		<td><?=$row->email ?></td>



		<td><?=$row->marr_sta ?></td>



		<td><?=$row->hmobile ?></td>



		<td><?=$row->nid_no ?></td>



		<td><?=$row->pr_street ?></td>



		<td><?=$row->pr_apartment ?></td>



		<td><?=$row->pr_city ?></td>

		<td><?=$row->pr_postal_code ?></td>



		<td><?=$row->pr_distric ?></td>

		<td><?=$row->pr_other_info ?></td>

		



		<td><?=$row->ps_street ?></td>



		<td><?=$row->ps_apartment ?></td>



		<td><?=$row->ps_city ?></td>



		<td><?=$row->ps_postal_code ?></td>



		<td><?=$row->ps_distric ?></td>

		<td><?=$row->ps_other_info ?></td>



		<td><?=$row->PROJECT_ID ?></td>

		<td><?=$row->project_desg ?></td>



		<td><?=$row->project_dept ?></td>

		<td><?=$row->project_email ?></td>



		<td><?=$row->project_mobile_no ?></td>



		<td><?=$row->others_information ?></td>



		<td><?=$row->children_information ?></td>



		<td><?=$row->wife_birth_day ?></td>



		<td><?=$row->wife_ocp ?></td>



		<td><?=$row->wife_name ?></td>





		</tr>



<? } ?>

        </tbody>



        <tfoot>



            <tr>

			

			<th>Code</th>

<th>Mobile NO</th>

<th>Telephone NO</th>

<th>Name</th>

<th>Address</th>

<th>Father Name</th>

<th>Mother Name</th>

<th>Date Of Birth</th>

<th>Nationality</th>

<th>Religion</th>

<th>Bank Acc NO</th>

<th>Spouse Name</th>

<th>Gender</th>

<th>Email</th>

<th>Marital Status</th>

<th>Home Mobil No</th>

<th>NID NO</th>

<th>Parmanent Street</th>

<th>Parmanent Apartment</th>

<th>Parmanent City</th>

<th>Parmanent Postal Code</th>

<th>Parmanent District</th>

<th>Parmanent Other Info</th>

<th>Present Street</th>

<th>Present Apartment</th>

<th>Present City</th>

<th>Present Postal Code</th>

<th>Present District</th>

<th>Present Other Info</th>

<th>Customer</th>



<th>Designation</th>

<th>Department</th>

<th>Office Email</th>

<th>Office Mobile No</th>

<th>Office Other Info</th>

<th>Children Info</th>

<th>Wife Birth Day</th>

<th>Wife Occupation</th>

<th>Wife Name</th>

			</tr>



        </tfoot>



    </table>









    <script src="../../vendors/jquery/dist/jquery.min.js"></script>

	

	<script type="text/javascript" src="../../vendors/customjs/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/buttons.bootstrap.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/jszip.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/0.1.53/pdfmake.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript" src="../../vendors/customjs/buttons.html5.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/buttons.print.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/buttons.colVis.min.js"></script>



<script>

//$(document).ready(function() {

//    $('#example').DataTable( {

//        dom: 'Bfrtip',

//        buttons: [

//            'copy', 'csv', 'excel', 'pdf', 'print'

//        ]

//    } );

//} );





$(document).ready(function() {

    $('#example').DataTable( {

        dom: 'Bfrtip',

        buttons: [

		

		

		{

                extend: 'csvHtml5',

                exportOptions: {

                    columns: [ 'pdf', ':visible' ]

                }

            },

			

            {

                extend: 'copyHtml5',

                exportOptions: {

                    columns: [ 0, ':visible' ]

                }

            },

            {

                extend: 'excelHtml5',

                exportOptions: {

                    columns: ':visible'

                }

            },

            {

                extend: 'pdfHtml5',

                exportOptions: {

                    columns: [ 0, 1, 2, 5 ]

                }

            },

            'colvis'

        ]

    } );

} );

</script>



</body>



</html>





<?



}



if($_POST['report']==61) 



{



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><th style="border:0px;" colspan="21"><?=$str?></th></tr>







<tr>



  <th rowspan="2">S/L</th>



  <th rowspan="2">EMP_ID</th>



  <th rowspan="2">Full Name</th>



  <th rowspan="2">Designation</th>



  <th rowspan="2">Joining Date</th>



  <th colspan="2"><div align="center">Leave Availed</div></th>



  <th colspan="2"><div align="center">Leave Balance</div></th>



  <th colspan="12" align="center"><div align="center">List Of Holyday Duty</div></th>



  </tr>



  <tr>



  <th>Casual</th>



  <th>Medical</th>



  



  <th>Casual</th>



  <th>Medical</th>



  



   <th>Jan</th>



   <th>Feb</th>



   <th>March</th>



   <th>April</th>



    <th>May</th>



  <th>June</th>



   <th>July</th>



  <th>Aug</th>



   <th>Sept</th>



  <th>Oct</th>



   <th>Nov</th>



  <th>Dec</th>



   



  </tr>



</thead>



<tbody>



<?



if($_POST['year']>0)



{



	//$mon = $_POST['mon'];



	$year = $_POST['year'];



	$totalDays=date('t',mktime(0,0,0,$mon,01,$year));



	$startDate=$year.'-01-01';



	$endDate=$year.'-12-31';



	



	 $leave_sql="SELECT l.*,p.PBI_CODE as Emp_ID,p.PBI_NAME as Employee_Name,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation,p.PBI_DOJ as joining_date  FROM hrm_leave_info l, personnel_basic_info p where l.s_date>='".$startDate."' and l.e_date<='".$endDate."' and p.PBI_ID=l.PBI_ID";







$leave_query=db_query($leave_sql);



while($data_leave = mysqli_fetch_object($leave_query)){







?>



<tr>



    <td><?=++$i;?></td>



	<td><?=$data_leave->Emp_ID?></td>



	<td><?=$data_leave->Employee_Name?></td>



	<td><?=$data_leave->designation?></td>



	<td><?=$data_leave->joining_date?></td>



	<td><?=$data_leave->casual?></td>



	<td><?=$data_leave->medical?></td>



	<td><?=10-$data_leave->casual?></td>



	<td><?=14-$data_leave->medical?></td>



	<td><?=$data_leave->jan?></td>



	<td><?=$data_leave->feb?></td>



	<td><?=$data_leave->march?></td>



	<td><?=$data_leave->april?></td>



	<td><?=$data_leave->may?></td>



	<td><?=$data_leave->june?></td>



	<td><?=$data_leave->july?></td>



	<td><?=$data_leave->august?></td>



	<td><?=$data_leave->sept?></td>



	<td><?=$data_leave->oct?></td>



	<td><?=$data_leave->nov?></td>



	<td><?=$data_leave->december?></td>



</tr>



<? } } ?>



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











if($_POST['report']==785) {







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















if($_POST['report']==786) {







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



    <table width="100%" cellspacing="0" cellpadding="2" border="0">



      <thead>



        <tr>



          <td style="border:0px;" colspan="6" align="left"><img src="../../img/company_logo.png" style="height:90px; width:180px;"  /></td>



          <td style="border:0px;" colspan="30" align="center"><?=$str?></td>



        </tr>



		



        <tr>



          <th rowspan="3">S/L</th>



          <th rowspan="3"><div align="center">ID</div></th>



		  <th rowspan="3"><div align="center">Emp Code</div></th>



          <th rowspan="3"><div align="center">Name</div></th>



          <th rowspan="3"><div align="center">Designation</div></th>



          <th rowspan="3" nowrap="nowrap"><div align="center">



            Joining Date </th>



          <th colspan="4" align="center"><div align="center">Attendance</div></th>



          <th colspan="9"><div align="center">Salary and Allowance </div></th>



         



         <th rowspan="3"><div align="center">Total Earning</div></th>



		 <th rowspan="3"><div align="center">Salary Arrear</div></th>



		  <th rowspan="3"><div align="center">Mobile Limit</div></th>



          <th colspan="9" align="center"><div align="center">Deduction</div></th>



          <th rowspan="3"><div align="center">Total Deduction </div></th>



		   



          <th rowspan="3" align="center"><div align="center">Net Payable Salary </div></th>



          <th rowspan="3"><div align="center">Bank A/C</div></th>



          <th rowspan="3"><div align="center">Cash</div></th>



          <th rowspan="3"><div align="center">Remarks</div></th>



        </tr>



        <tr>



         



          <th rowspan="2"><div align="center">LP</div></th>



          <th rowspan="2"><div align="center">LWP</div></th>



          <th rowspan="2"><div align="center">AB</div></th>



          <th rowspan="2"><div align="center">Total Days Works </div></th>



          <th rowspan="2"><div align="center">Gross </div></th>



          <th rowspan="2"><div align="center">Basic</div></th>



		  <th rowspan="2"><div align="center">Basic Increment Aggregation</div></th>



          <th rowspan="2"><div align="center">House Rent </div></th>



          <th rowspan="2"><div align="center">Medical</div></th>



          <th rowspan="2"><div align="center">Conveyance</div></th>



		  <th rowspan="2"><div align="center">Child Allowance</div></th>



		  <th rowspan="2"><div align="center">Performance Bonus</div></th>



		  <th rowspan="2"><div align="center">Resource Bonus</div></th>



		  



		 



         



        



          <th rowspan="2"><div align="center">Mobile</div></th>



          <th rowspan="2"><div align="center">Tax</div></th>



          <th rowspan="2"><div align="center">Food </div></th>



          <th rowspan="2"><div align="center">Loan /Advance</div></th>



		   <th rowspan="2"><div align="center">Provident Fund</div></th>



          <th rowspan="2"><div align="center">Absent</div></th>



          <th rowspan="2"><div align="center">LWP</div></th>



          <th rowspan="2"><div align="center">Late</div></th>



          <th rowspan="2"><div align="center">Others</div></th>



        </tr>



       



      </thead>



      <tbody>



        <?







 if($_POST['PBI_ORG']!='')



 $salaryConn =' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';











if ($_POST['JOB_LOCATION'] !='')



 $salaryConn .= ' and t.job_location='.$_POST['JOB_LOCATION'];



if ($_POST['department'] !='')



 $salaryConn .= ' and t.department='.$_POST['department'];



 $m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';



 $m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';







  $sqld = 'select t.*, a.PBI_ID,a.PBI_CODE, a.PBI_NAME, a.PBI_DOJ, d.DESG_SHORT_NAME as Designation







 from salary_attendence t,designation d, personnel_basic_info a 



 



 where t.designation = d.DESG_ID and t.pay>0 and t.remarks_details!="hold" and  t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID '.$salaryConn.' order by (t.total_payable) desc';







$queryd=db_query($sqld);







while($data = mysqli_fetch_object($queryd)){







$m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';







$m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';







$entry_by=$data->entry_by;











  //$slq = 'select sum(total_days) from hrm_leave_info where PBI_ID="'.$data->PBI_ID.'" and type=1 and s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and  leave_status="GRANTED"';







  $tot_ded = $data->other_deduction+$data->hr_action_amt;











?>



        <tr>



          <td><?=++$s?></td>



          <td><?=$data->PBI_ID?></td>



		   <td><?=$data->PBI_CODE?></td>



          <td nowrap="nowrap"><?=$data->PBI_NAME?></td>



          <td nowrap="nowrap"><?=$data->Designation?></td>



          <td><?=date('d-M-Y',strtotime($data->PBI_DOJ))?></td>



          



          <td align="center"><?=($data->lt>0)? $data->lt : '';?></td>



          <td align="center"><?=($data->lwp>0)? $data->lwp : '';?></td>



          <td align="center"><?=($data->ab>0)? $data->ab : '';?></td>



          <td align="center"><?=($data->pay>0)? $data->pay : '';?></td>



          <td align="right"><?=($data->gross_salary>0)? $data->gross_salary : '';               $totGross += $data->gross_salary?></td>



          <td align="right"><?=($data->basic_salary>0)? $data->basic_salary : '';               $totBasic += $data->basic_salary?></td>



		    <td align="right"><?=($data->special_allowance>0)? $data->special_allowance : '';               $totAggregation += $data->special_allowance?></td>



          <td align="right"><?=($data->house_rent>0)? $data->house_rent : '';                   $totHouse += $data->house_rent?></td>



          <td align="right"><?=($data->medical_allowance>0)? $data->medical_allowance : '';     $totMedical += $data->medical_allowance?></td>



          <td align="right"><?=($data->conveyance_allowance>0)? $data->conveyance_allowance : '';     $totspecial += $data->conveyance_allowance?></td>



		   <td align="right"><?=($data->child_allowance>0)? $data->child_allowance : '';     $totChildAlw += $data->child_allowance?></td>



		    <td align="right"><?=($data->performance_bonus>0)? $data->performance_bonus : '';     $totPerBonus += $data->performance_bonus?></td>



			



			<td align="right"><?=($data->resourse_bonus>0)? $data->resourse_bonus : '';     $totResourse_bonus += $data->resourse_bonus?></td>



			



			



         



          <td align="right"><?=($data->total_salary>0)? $data->total_salary : '';     $totSalary += $data->total_salary?></td>



		    <td align="right"><?=($data->salary_arrear>0)? $data->salary_arrear : '';     $totArrear += $data->salary_arrear?></td>



		  



		  <td align="right"><?=($data->mobile_allowance>0)? $data->mobile_allowance : '';     $totMobileAlw += $data->mobile_allowance?></td>



          



          <td align="right"><?=($data->mobile_deduction>0)? $data->mobile_deduction : '';       $totMobileDeduct += $data->mobile_deduction?></td>



          <td align="right"><?=($data->income_tax>0)? $data->income_tax : '';                   $totIincomeTax += $data->income_tax?></td>



          <td align="right"><?=($data->food_deduction>0)? $data->food_deduction : '';           $totFoodDeduct += $data->food_deduction?></td>



          <td align="right"><?=($data->other_install>0)? $data->other_install : '';         $totAdvInstall += $data->other_install?></td>



		   <td align="right"><?=($data->pf_deduction>0)? $data->pf_deduction : '';         $totPfDeduct += $data->pf_deduction?></td>



          <td align="right"><?=($data->absent_deduction>0)? $data->absent_deduction : '';       $totAbsentDeduct += $data->absent_deduction?></td>



          <td align="right"><?=($data->lwp_deduction>0)? $data->lwp_deduction : '';             $totLwpDeduct += $data->lwp_deduction?></td>



          <td align="right"><?=($data->late_deduction>0)? $data->late_deduction : '';           $totLateDeduct += $data->late_deduction?></td>



          <td align="right"><?=($tot_ded>0)? $tot_ded : '';       $totOtherDeduct += $tot_ded?></td>



          <td align="right"><?=($data->total_deduction>0)? $data->total_deduction : '';         $totTotalDeduct += $data->total_deduction?></td>



		 



          <td align="right"><? echo ($data->total_payable>0)? $data->total_payable : '';        $total_cash = $total_cash + $data->total_payable;?></td>



          <td><?=($data->cash>0)? $data->cash : '';?></td>



          <td><?=($data->card_no>0)? $data->card_no : '';?></td>



          <?















 $hr_action_remarks = find_a_field('admin_action_detail','ADMIN_ACTION_SUBJECT','EFFECT_MON="'.$_POST['mon'].'" and EFFECT_YEAR="'.$_POST['year'].'" and PBI_ID="'.$data->PBI_ID.'" ');















 















 ?>



          <? if($hr_action_remarks!=''){?>



          <td nowrap="nowrap" style="width:150px;"><?=$hr_action_remarks?></td>



          <? } else{?>



          <td nowrap="nowrap" style="width:150px;"><?=$data->remarks_details?></td>



          <? } ?>



        </tr>



        <?







}















?>



        <tr>



          <td colspan="10" align="right" style="font-weight:bold;">Total:</td>



		    



          <td align="right"><strong>



            <?=($totGross>0)? number_format($totGross,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totBasic>0)? number_format($totBasic,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totAggregation>0)? number_format($totAggregation,0) : '';?>



            </strong></td>



			 <td align="right"><strong>



            <?=($totHouse>0)? number_format($totHouse,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totMedical>0)? number_format($totMedical,0) : '';?>



            </strong></td>



         



          <td align="right"><strong>



            <?=($totspecial>0)? number_format($totspecial,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totChildAlw>0)? number_format($totChildAlw,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totPerBonus>0)? number_format($totPerBonus,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totResourse_bonus>0)? number_format($totResourse_bonus,0) : '';?>



            </strong></td>



         



          



          <td align="right"><strong>



            <?=($totSalary>0)? number_format($totSalary,0) : '';?>



            </strong></td>



			 <td align="right"><strong>



            <?=($totArrear>0)? number_format($totArrear,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totMobileAlw>0)? number_format($totMobileAlw,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totMobileDeduct>0)? number_format($totMobileDeduct,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totIincomeTax>0)? number_format($totIincomeTax,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totFoodDeduct>0)? number_format($totFoodDeduct,0) : '';?>



            </strong></td>



			 <td align="right"><strong>



            <?=($totAdvInstall>0)? number_format($totAdvInstall,0) : '';?>



            </strong></td>



			 <td align="right"><strong>



            <?=($totPfDeduct>0)? number_format($totPfDeduct,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totAbsentDeduct>0)? number_format($totAbsentDeduct,0) : '';?>



            </strong></td>



        



          <td align="right"><strong>



            <?=($totLwpDeduct>0)? number_format($totLwpDeduct,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totLateDeduct>0)? number_format($totLateDeduct,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totOtherDeduct>0)? number_format($totOtherDeduct,0) : '';?>



            </strong></td>



          <td align="right"><strong>



            <?=($totTotalDeduct>0)? number_format($totTotalDeduct,0) : '';?>



            </strong></td>



			<td align="right"><strong>



            <?=($total_cash>0)? number_format($total_cash,0) : '';?>



            </strong></td>



        



          <td>&nbsp;</td>



          <td>&nbsp;</td>



          <td>&nbsp;</td>



		 



        </tr>



      </tbody>



    </table>



    In Words:



    <?











echo convertNumberMhafuz($total_cash);











?>



    <br>



    <br>



    <br>



    <!--<div style="width:100%; margin:60px auto">



      <div style="float:left; width:20%; text-align:center">-------------------<br>



        Prepared By</div>



      <div style="float:left; width:20%; text-align:center">-------------------<br>



        Audit</div>



      <div style="float:left; width:20%; text-align:center">-------------------<br>



        Accounts</div>



      <div style="float:left; width:20%; text-align:center">-------------------<br>



        Managing Director</div>



      <div style="float:left; width:20%; text-align:center">-------------------<br>



        Chairman</div>



    </div>-->



    <?







}



if($_POST['report']==783){ // Zone Wise Sales Salary Brief Report











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







if($_POST['report']==7804) { // Group Wise HO Sales Report







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











if($_POST['report']==7801){ // Region Wise Sales Salary Brief Report(Without HO)







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



In words: <?=convertNumberMhafuz($total_net_payable);?>



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



if($_POST['report']==784) 



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



In words: <?=convertNumberMhafuz($total_net_payable);?>



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



In words: <?=convertNumberMhafuz($total_net_payable);?>



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



  <th>NCC</th>



  <th>IBBL</th>



</tr>



</thead>



<tbody>







<?



if($_POST['PBI_ORG']>0) $org_con = ' and PBI_ORG ="'.$_POST['PBI_ORG'].'" ';



if($_POST['JOB_LOCATION']!=''){ $location_con=' and t.pbi_job_location = "'.$_POST['JOB_LOCATION'].'"';}







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



and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' and t.PBI_ID=a.PBI_ID and t.PBI_ID=s.PBI_ID and t.pbi_region =0 



'.$org_con.$location_con.' group by t.pbi_department';



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



  <td><? echo $cash_paid=find_a_field('salary_attendence t,personnel_basic_info a ','sum(t.total_payable-t.bank_paid)','t.pbi_held_up=0 and t.PBI_ID=a.PBI_ID and t.pbi_department="'.$data->PBI_DEPARTMENT.'" and t.pbi_job_location="'.$data->job_location.'"  '.$org_con.' and t.pbi_region =0 and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].''); $total_cash_payment = $total_cash_payment + $cash_paid; ?></td>



  



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



</tr>



</tbody></table>



In words: <?=convertNumberMhafuz($total_net_payable);?>



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



In words: <?=convertNumberMhafuz($total_net_payable);?>



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



In words: <?=convertNumberMhafuz($total_net_payable);?>



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







$sql22="SELECT a.*,b.*,p.DEPT_DESC, d.DESG_SHORT_NAME



FROM personnel_basic_info a, salary_attendence b, department p, designation d



WHERE a.PBI_ID = b.PBI_ID



AND b.pbi_held_up = 0



AND b.pbi_department=p.DEPT_SHORT_NAME



AND b.pbi_designation = d.DESG_ID 



and b.cash_paid>0 



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















elseif($_REQUEST['report']==201){ // Leave Encashment Report







$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);



?>



<center>



  <h1><?=$company?></h1>



  <strong>Customer Information Report</strong><br><br><br><br>



  



</center>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead>



<tr><th style="border:0px;" colspan="7"></th></tr>







<tr>



  <th>S/L</th>



  <th>Customer Code</th>



  <th>Customer Name</th>



  <th>Address</th>



  <th>Mobile No</th>



  <th>Telephone No</th>



  <th>Company</th>



  </tr>



</thead>



<tbody>



<?











if($_REQUEST['project_id']!=''){ $project_con = " and PROJECT_ID='".$_REQUEST['project_id']."'";}











$sqld="select * from crm_customer_info where 1 ".$project_con." ";











//$d1 = new DateTime('2017-03-20');



$d2 = new DateTime($d22);



//$interval = date_diff($d1, $d2);



//echo $interval->format('%m months');







$queryd=db_query($sqld);



while($data = mysqli_fetch_object($queryd)){



?>



<tr>



  <td><?=++$s?></td>



  <td><?=$data->dealer_code?></td>



  <td><?=$data->dealer_name_e?></td>



  <td><?=$data->address_e?></td>



  <td><?=$data->mobile_no?></td>



  <td><?=$data->tel_no?></td>



  <td><?=find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$data->PROJECT_ID.'"')?></td>



</tr>



<?



}



?>







</tbody></table>



<?



}



















elseif($_REQUEST['report']==202) {       // sajeeb group Leave Consumption Report{







//$f_date = $_REQUEST['f_date'];



//$t_date = $_REQUEST['t_date'];







//if(isset($dealer_code)) {$dealer_con=' and d.dealer_code='.$dealer_code;} 



//$date_con = ' and j.ji_date between "'.$f_date.'" and "'.$t_date.'" ';







// leave table











if($_REQUEST['project_id']!=''){ $lead_type = " and l.project_id='".$_REQUEST['project_id']."' "; }



if($_REQUEST['lead_status']!=''){ $lead_status = " and l.lead_status='".$_REQUEST['lead_status']."' "; }



if($_REQUEST['group_id']!=''){ $group_con = " and g.id='".$_REQUEST['group_id']."' "; }



if($_REQUEST['lead_type']!=''){ $lead_type = " and l.lead_type='".$_REQUEST['lead_type']."' "; }



if($_REQUEST['lead_status']!=''){ $lead_status = " and l.lead_status='".$_REQUEST['lead_status']."' "; }







if($_REQUEST['project_id']!=''){ $project_con = " and p.PROJECT_ID='".$_REQUEST['project_id']."' ";}







?>











<html>

<head>

<title><?=date('Y-m-d')?> | ERP.COM.BD</title>



    <link href="../../vendors/bootstrap/dist/css/buttons.bootstrap.min.css" rel="stylesheet">



    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">



</head>

<body>



<center>



<h1>Lead Report</h1>











<table width="100%" border="0" cellspacing="0" cellpadding="2" id="example">



<thead>



<tr>



	<th>S/L</th>



  <th>Lead No</th>

  <th>Title</th>

  <th>Description</th>

  <th>Address</th>

  <th>Remarks</th>



  <th>Group</th>

  <th>Customer</th>



  <th>Type Of Lead</th>



  <th>Value Of Lead</th>





  <th>Lead Status</th>

  <th>Sales Person</th>

  <th>Service And Value</th>



  </tr>



</thead>



<tbody>



<?







 $sqlview="select l.*,p.*,g.group_name from crm_lead_master l, crm_project p,  crm_company_group  g where 1 and p.group_id=g.id and l.project_id=p.project_id  ".$project_con.$lead_status.$lead_status.$group_con." ";







?>



<?php



$query = db_query($sqlview);



while($data= mysqli_fetch_object($query)){ ?>



<tr><td><?=++$op;?></td>



  <td><?=$data->lead_no?></td>

  <td><?=$data->lead_title?></td>

  <td><?=$data->descript?></td>

  <td><?=$data->address?></td>

  <td><?=$data->remarks?></td>



  <td><?=$data->group_name?></td>

  <td><?=$data->PROJECT_DESC?></td>



  <td><?=find_a_field('crm_type_of_lead','type','id="'.$data->lead_type.'"');?></td>



  <td><?=$data->lead_value?></td>



  <td><?=find_a_field('crm_lead_status','status','id="'.$data->lead_status.'"')?></td>

  <td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->PBI_ID.'"')?></td>

  

  <td>

  <table border="1" cellpadding="0" cellspacing="0">

  <tr bgcolor="#CCCCCC" style="font-weight:bold;">

  <td>Service</td>

  <td>Value</td>

  </tr>

  

  

  <? 

  

  $selects = 'select * from crm_lead_service_detail where lead_no="'.$data->lead_no.'"';

  $querys = db_query($selects);

  

  while($rows=mysqli_fetch_object($querys)){

  

  ?>

  

  

   <tr>

  <td><?=find_a_field('crm_service','service_name','service_id="'.$rows->service_id.'"');?></td>

  <td><?=$rows->amount?></td>

  </tr>

  

  <? } ?>

  

  </table>

  </td>



</tr>



<? } ?>



</tbody>



</table>











    <script src="../../vendors/jquery/dist/jquery.min.js"></script>

	

	<script type="text/javascript" src="../../vendors/customjs/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/buttons.bootstrap.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/jszip.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/0.1.53/pdfmake.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript" src="../../vendors/customjs/buttons.html5.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/buttons.print.min.js"></script>

<script type="text/javascript" src="../../vendors/customjs/buttons.colVis.min.js"></script>



<script>

//$(document).ready(function() {

//    $('#example').DataTable( {

//        dom: 'Bfrtip',

//        buttons: [

//            'copy', 'csv', 'excel', 'pdf', 'print'

//        ]

//    } );

//} );





$(document).ready(function() {

    $('#example').DataTable( {

        dom: 'Bfrtip',

        buttons: [

		

		

		{

                extend: 'csvHtml5',

                exportOptions: {

                    columns: [ 'pdf', ':visible' ]

                }

            },

			

            {

                extend: 'copyHtml5',

                exportOptions: {

                    columns: [ 0, ':visible' ]

                }

            },

            {

                extend: 'excelHtml5',

                exportOptions: {

                    columns: ':visible'

                }

            },

            {

                extend: 'pdfHtml5',

                exportOptions: {

                    columns: [ 0, 1, 2, 5 ]

                }

            },

            'colvis'

        ]

    } );

} );

</script>



</body>



</html>



<br>







<?



}



// end leave report











elseif($_POST['report']==483164){







 $select = 'select * from crm_customer_info where 1 and dealer_code="'. $_POST['dealer_code'] .'"';



$query = db_query($select);



$rows = mysqli_fetch_object($query);



?>







<h1 style="text-align: center;">Individual Customer Information Report</h1>







<h4 style="text-align:center; margin-top: 0px;">Customer Code : #<?=$_POST['dealer_code']?> </h4>











<table width="90%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group " align="center" style="font-size: 14px;">



                              <tbody>



                                <tr class="oe_form_group_row">



                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>CUSTOMER INFORMATION </strong></div></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td width="21%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Customer Code:</td>



                                  <td width="29%" class="oe_form_group_cell">#<?=$rows->dealer_code?></td>



                                  <td width="8%" class="oe_form_group_cell">&nbsp;</td>



                                  <td width="16%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">



                                    <label style="min-width:100px;">&nbsp;&nbsp;Customer Name:</label>



                                  </span></td>



                                  <td width="26%" class="oe_form_group_cell"><span class="oe_form_group_cell">



                                    <?=$rows->dealer_name_e?>



                                  </span></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell">Father's Name :</td>



                                  <td class="oe_form_group_cell"><?=$rows->father_name?></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Mother's Name :</td>



                                  <td class="oe_form_group_cell"><?=$rows->mother_name?></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell">Date Of Birth </td>



                                  <td class="oe_form_group_cell"><?=$rows->date_of_birth?></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Mobile No:</td>



                                  <td class="oe_form_group_cell" style=""><?=$rows->mobile_no?></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell">Wife Name : </td>



                                  <td class="oe_form_group_cell"><?=$rows->wife_name?></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">Wife Occupation:</td>



                                  <td class="oe_form_group_cell"><?=$rows->wife_ocp?></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell">Wife Birth Day : </td>



                                  <td class="oe_form_group_cell"><?=$rows->wife_birth_day?></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell">Others Details : </td>



                                  <td colspan="4" class="oe_form_group_cell"><?=$rows->others_information?></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell">Children Information : </td>



                                  <td colspan="4" class="oe_form_group_cell"><?=$rows->children_information?></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell">Nationality :</td>



                                  <td class="oe_form_group_cell"><?=$rows->nationality?></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Religion :</td>



                                  <td class="oe_form_group_cell">



								  <?=$rows->religion?>



								  							  </td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell">Bank Account Number :</td>



                                  <td class="oe_form_group_cell"><?=$rows->bank_acc_no?></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Spouse Name</td>



                                  <td class="oe_form_group_cell"><?=$rows->spouse_name?></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell">Gender :</td>



                                  <td class="oe_form_group_cell">



								  <?=$rows->gender?>



								  								  </td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Email ID:</td>



                                  <td class="oe_form_group_cell"><?=$rows->email?></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell">Marital Status :</td>



                                  <td class="oe_form_group_cell">



								  <?=$rows->marr_sta?>							  </td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Home&nbsp;Mobile :</td>



                                  <td class="oe_form_group_cell"><?=$rows->hmobile?></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Tel No:</td>



                                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><?=$rows->tel_no?></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">National ID/Passport No</td>



                                  <td class="oe_form_group_cell"><?=$rows->nid_no?></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Address(E):</td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell">



								  <?=$rows->address_e?>



                                   



                                  </span></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                </tr>



                                <tr>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



								  </tr><tr>



                                  <td colspan="5" class="oe_form_group_cell oe_form_group_cell_label" bgcolor="#00CCFF"><div align="center"><strong>PARMANENT ADDRESS </strong></div></td>



                                </tr>



                                <tr>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Street Address :</td>



                                  <td class="oe_form_group_cell"> <?=$rows->pr_street?></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Apartment/Unit:</td>



                                  <td class="oe_form_group_cell"><?=$rows->pr_apartment?></td>



                                </tr><tr>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">City:</td>



                                  <td class="oe_form_group_cell"><?=$rows->pr_city?></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Postal Code:</td>



                                  <td class="oe_form_group_cell"><?=$rows->pr_postal_code?></td>



                                </tr><tr>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">District:</td>



                                  <td class="oe_form_group_cell"><?=$rows->pr_distric?></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                </tr><tr>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Others Information </td>



                                  <td colspan="4" class="oe_form_group_cell"><?=$rows->pr_other_info?></td>



                                </tr><tr>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                </tr><tr>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



								  </tr><tr>



                                  <td colspan="5" class="oe_form_group_cell oe_form_group_cell_label" bgcolor="#00CCFF"><div align="center"><strong>PRESENT ADDRESS </strong></div></td>



                                </tr>



                                  <tr>



                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Street Address :</td>



                                    <td class="oe_form_group_cell"><?=$rows->ps_street?></td>



                                    <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Apartment/Unit:</td>



                                    <td class="oe_form_group_cell"><?=$rows->ps_apartment?></td>



                                  </tr>



                                  <tr>



                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">City:</td>



                                    <td class="oe_form_group_cell"><?=$rows->ps_city?></td>



                                    <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Postal Code:</td>



                                    <td class="oe_form_group_cell"><?=$rows->ps_postal_code?></td>



                                  </tr>



                                  <tr>



                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">District:</td>



                                    <td class="oe_form_group_cell"><?=$rows->ps_distric?></td>



                                    <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                    <td class="oe_form_group_cell">&nbsp;</td>



                                  </tr>



                                  <tr>



                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Others Information </td>



                                    <td colspan="4" class="oe_form_group_cell"><?=$rows->ps_other_info?></td>



                                </tr><tr>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                </tr><tr>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                </tr><tr>



                                  <td colspan="5" class="oe_form_group_cell oe_form_group_cell_label" bgcolor="#00CCFF"><div align="center"><strong>COMPANY INFORMATION </strong></div></td>



                                </tr>



								<tr>



								<td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Company Name :</td>



                                  <td class="oe_form_group_cell"><span class="oe_form_group_cell">



								  



								  <?=find_a_field('crm_project','PROJECT_DESC',' PROJECT_ID="'.$rows->PROJECT_ID.'"');?>



                                    



                                    </span></td>











                                    <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Designation</td>



                                  <td class="oe_form_group_cell"><?=$rows->project_desg?></td>



								</tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell oe_form_group_cell_label">Office E-mail ID:</td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label"><?=$rows->project_email?></td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label">Department</td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label"><?=$rows->project_dept?></td>



                                </tr>



                                <tr class="oe_form_group_row">



                                  <td class="oe_form_group_cell oe_form_group_cell_label">Office Mobile No </td>



                                  <td class="oe_form_group_cell oe_form_group_cell_label"><?=$rows->project_mobile_no?></td>



								  <td>&nbsp;</td>



								  <td>&nbsp;</td>



								  <td>&nbsp;</td>



                                </tr>



                                



                                <tr bgcolor="#FFFFFF" class="oe_form_group_row">



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Others Information </td>



                                  <td colspan="4" class="oe_form_group_cell"><?=$rows->com_other_info?></td>



                                </tr>



                                <tr bgcolor="#FFFFFF" class="oe_form_group_row">



                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                  <td class="oe_form_group_cell">&nbsp;</td>



                                </tr>



                                



                                <tr class="oe_form_group_row">



                                  <td bgcolor="#FFFFFF" colspan="5" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                </tr>



                              </tbody>



                            </table>















<?



}















// 2017 leave encashment report 11 january 2018



elseif($_REQUEST['report']==203){



$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);

if($_POST['PBI_ID']!=''){ $contact_con = " and c.entry_by='".$_POST['PBI_ID']."' ";}

if($_POST['f_date']!='' && $_POST['t_date']!=''){ $service_con = " and c.c_date between '".$_POST['f_date']."' and  '".$_POST['t_date']."' ";}

if($_POST['status']!='') {
  $status_con = ' and c.status="'.$_POST['status'].'"';
  $str .='<h4>Status : '.$_POST['status'].'</h4>';
 }

?>







<table width="100%" cellspacing="0" cellpadding="0" border="1">



<thead>



<tr><th style="border:0px;" colspan="16"><?=$str?>











</th></tr>







<tr>



  <th>S/L</th>

  <th>Employee Name</th>

  <th>Customer Organization</th>

  <th>Customer Address</th>

  <th>Customer Cotact No</th>

  <th>Customer Email</th>

  <th>Customer Designation</th>

  <th>Service Name</th>

  <th>Contact Person</th>

  <th>Time</th>

  <th>Date</th>

  <th>Remarks</th>

  <th>Feedback</th>

  <th>Attachment</th>

  </tr>



</thead>



<tbody>



<?







 $sqld="select c.id,c.lead_no,c.PROJECT_ID,crm.dealer_name_e as customer_name,crm.address_e,crm.organization,crm.mobile_no,crm.email,c.contact_person, c.service_name,c.overcome as feedback, c.c_reason,c.c_detail,c.c_time,c.c_date,(select PBI_NAME from personnel_basic_info where PBI_ID=c.entry_by) as entry_by, c.entry_at,c.c_designation,c.attachment from crm_comunication c, crm_customer_info crm where crm.dealer_code=c.customer_name ".$project_con.$contact_con.$service_con.$lead_con.$status_con."";





$sl=0;





$queryd=db_query($sqld);



while($data = mysqli_fetch_object($queryd)){



?>



<tr <? ++$sl; if(($sl%2)==0) { echo "style='background: #F0F0F0'" ;} ?>>



  <td><?=++$s?> </td>



  <td><?=$data->entry_by?></td>

  <td><?=$data->organization?></td>

  <td><?=$data->address_e?></td>

  <td><?=$data->mobile_no?></td>

  <td><?=$data->email?></td>

  <td><?=$data->c_designation?></td>

  <td><?=$data->service_name?></td>

  <td><?=$data->contact_person?></td>

  <td><?=$data->c_time?></td>

  <td><?=$data->c_date?></td>

  <td><?=$data->c_detail?></td>

  <td><?=$data->feedback?></td>

  <td><? if($data->attachment!=''){?><a href="<?=$data->attachment?>" target="_blank">Attachment</a><? } ?></td>



</tr>



<? } ?>



</tbody></table>



<?



}

	
	
	
elseif($_REQUEST['report']==2003){



$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);

if($_POST['PBI_ID']!=''){ $contact_con = " and c.entry_by='".$_POST['PBI_ID']."' ";}

if($_POST['f_date']!='' && $_POST['t_date']!=''){ $service_con = " and c.c_date between '".$_POST['f_date']."' and  '".$_POST['t_date']."' ";}



?>







<table width="100%" cellspacing="0" cellpadding="0" border="1">



<thead>



<tr><th style="border:0px;" colspan="16"><?=$str?>











</th></tr>







<tr>



  <th>S/L</th>

  <th>Employee Name</th>

  <th>Customer Organization</th>

  <th>Customer Address</th>

  <th>Customer Cotact No</th>

  <th>Customer Email</th>

  <th>Customer Designation</th>

  <th>Service Name</th>

  <th>Contact Person</th>

  <th>Time</th>

  <th>Date</th>

  <th>Remarks</th>

  <th>Feedback</th>

  <th>Attachment</th>

  </tr>



</thead>



<tbody>



<?







 $sqld="select c.id,c.lead_no,c.PROJECT_ID,crm.dealer_name_e as customer_name,crm.address_e,crm.organization,crm.mobile_no,crm.email,c.contact_person, c.service_name,c.overcome as feedback, c.c_reason,c.c_detail,c.c_time,c.c_date,(select PBI_NAME from personnel_basic_info where PBI_ID=c.entry_by) as entry_by, c.entry_at,c.c_designation,c.attachment from crm_comunication c, crm_customer_info crm where crm.dealer_code=c.customer_name ".$project_con.$contact_con.$service_con.$lead_con."";





$sl=0;





$queryd=db_query($sqld);



while($data = mysqli_fetch_object($queryd)){



?>



<tr <? ++$sl; if(($sl%2)==0) { echo "style='background: #F0F0F0'" ;} ?>>



  <td><?=++$s?> </td>



  <td><?=$data->entry_by?></td>

  <td><?=$data->organization?></td>

  <td><?=$data->address_e?></td>

  <td><?=$data->mobile_no?></td>

  <td><?=$data->email?></td>

  <td><?=$data->c_designation?></td>

  <td><?=$data->service_name?></td>

  <td><?=$data->contact_person?></td>

  <td><?=$data->c_time?></td>

  <td><?=$data->c_date?></td>

  <td><?=$data->c_detail?></td>

  <td><?=$data->feedback?></td>

  <td><? if($data->attachment!=''){?><a href="<?=$data->attachment?>" target="_blank">Attachment</a><? } ?></td>



</tr>



<? } ?>



</tbody></table>



<?



}



elseif($_REQUEST['report']==205){



$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);

if($_POST['PBI_ID']!=''){ $contact_con = " and c.entry_by='".$_POST['PBI_ID']."' ";}

if($_POST['f_date']!='' && $_POST['t_date']!=''){ $service_con = " and c.c_date between '".$_POST['f_date']."' and  '".$_POST['t_date']."' ";}

if($_POST['status']!='') {
  $status_con = ' and c.status="'.$_POST['status'].'"';
  $str .='<h4>Status : '.$_POST['status'].'</h4>';
 }

?>







<table width="100%" cellspacing="0" cellpadding="0" border="1" style="border-collapse:collapse; font-family:'Times New Roman', Times, serif; padding:5px;">

<thead>

<tr><th style="border:0px;" colspan="16"><?=$str?></th>

</tr>



<tr>

  <th>S/L</th>

  <th>CID</th>

  <th>Employee Name</th>

  <th>Customer Organization</th>

  <th>Customer Cotact No</th>

  <th>Date</th>

  <th>From Address</th>

  <th>To Address</th>

  <th>Buss Bill</th>

  <th>CNG Bill</th>

  <th>Bike Bill</th>

  <th>Rickshaw Bill</th>

  <th>Other Transport Bill</th>

  <th>Food Bill</th>

  <th>Total Bill</th>

  <th>Attachment</th>

  </tr>



</thead>



<tbody>



<?







$sqld="select c.id,c.lead_no,c.PROJECT_ID,crm.dealer_name_e as customer_name,crm.address_e,crm.organization,crm.mobile_no,crm.email,c.contact_person, c.service_name,c.c_reason as subject, c.c_reason,c.c_detail,c.c_time,c.c_date,c.rickshaw_bill,c.bike_bill,(select PBI_NAME from personnel_basic_info where PBI_ID=c.entry_by) as entry_by, c.from_address,c.to_address,c.attachment,c.entry_at,c.bus_bill,c.cng_bill,c.others_bill,c.food_bill,c.total_bill from crm_comunication c, crm_customer_info crm where crm.dealer_code=c.customer_name ".$project_con.$contact_con.$service_con.$lead_con.$status_con." order by c.c_date";





$sl=0;





$queryd=db_query($sqld);



while($data = mysqli_fetch_object($queryd)){

$grand_total = $grand_total+$data->total_bill;

?>



<tr <? ++$sl; if(($sl%2)==0) { echo "style='background: #F0F0F0'" ;} ?>>



  <td align="center"><?=++$s?> </td>

  <td align="center"><?=$data->id?> </td>

  <td><?=$data->entry_by?></td>

  <td><?=$data->organization?></td>

  <td align="center"><?=$data->mobile_no?></td>

  <td align="center"><?=$data->c_date?></td>

  <td align="center"><?=$data->from_address?></td>

  <td align="center"><?=$data->to_address?></td>

  <td align="right"><? if($data->bus_bill>0) echo $data->bus_bill?></td>

  <td align="right"><? if($data->cng_bill>0) echo $data->cng_bill?></td>

  <td align="right"><? if($data->bike_bill>0) echo $data->bike_bill?></td>

  <td align="right"><? if($data->rickshaw_bill>0) echo $data->rickshaw_bill?></td>

  <td align="right"><? if($data->others_bill>0) echo $data->others_bill?></td>

  <td align="right"><? if($data->food_bill>0) echo $data->food_bill?></td>

  <td align="right"><? if($data->total_bill>0) echo $data->total_bill?></td>

  <td><? if($data->attachment!=''){?><a href="<?=$data->attachment?>" target="_blank">Attachment</a><? } ?></td>

 



</tr>



<? } ?>

<tr>



<td colspan="14" align="right"><strong>Total</strong></td>

<td align="right"><strong><?=number_format($grand_total,2)?></strong></td>

<td>&nbsp;</td>

</tr>



</tbody></table>



<?



}







elseif($_POST['report']==97){







$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);



?>







<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead>



<tr><th style="border:0px;" colspan="16"><?=$str?></th></tr>







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







 $sqld="select p.PBI_NAME,a.user_name,a.password,a.emp_id from personnel_basic_info p, hrm_user_access a where a.emp_id=p.PBI_ID";











$queryd=db_query($sqld);



while($data = mysqli_fetch_object($queryd)){



?>



<tr>



  <td><?=++$s?></td>



  <td><?=$data->user_name?></td>



  <td><?=$data->PBI_NAME?></td>



  <td><?=$data->user_name?></td>



  <td><?=$data->password?></td>



 



</tr>



<? } ?>







</tbody></table>



<?



}







elseif($_POST['report']==979){







$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);



$report = 'Vehicle Management';



?>







<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead>



<tr><th style="border:0px;" colspan="16"><?=$str?></th></tr>







<tr>



  <th rowspan="2">S/L</th>



  <th rowspan="2">Vehicle User</th>



  <th rowspan="2">Designation</th>



  <th rowspan="2">Vehicle Model</th>



  <th rowspan="2">Registration No</th>



  <th rowspan="2">Driver Name</th>



  <th colspan="2"><div align="center">Driver Mobile No</div></th>



  <th rowspan="2">Vehicle Status</th>



 



  </tr>



  <tr>



    <th>Office</th>



	<th>Personal</th>



  </tr>



</thead>



<tbody>



<?







 $sqld="Select * from transport_vehicle where 1";











$queryd=db_query($sqld);



while($data = mysqli_fetch_object($queryd)){



$basic = find_all_field('personnel_basic_info','','PBI_ID='.$data->vehicle_user);



if($basic->PBI_NAME!=''){



  $user = $basic->PBI_NAME;



}else{



$user =$data->vehicle_user;



 }



?>



<tr>



  <td><?=++$s?></td>



  <td><?=$user?></td>



  <td><?=find_a_field('designation','DESG_DESC','DESG_ID='.$basic->PBI_DESIGNATION);?></td>



  <td><?=$data->vehicle_model?></td>



  <td><?=$data->vehicle_registration_no?></td>



  <td><?=$data->driver_name?></td>



  <td><?=$data->driver_mobile_office?></td>



  <td><?=$data->driver_mobile_personal?></td>



  <td><?=$data->vehicle_status?></td>







 



</tr>



<? } ?>







</tbody></table>



<?



}















elseif($_REQUEST['report']==204){ // --------------- Friday Working Bill







if($_POST['pbi_id_in']!='')  $con .= " and a.PBI_ID in (".$_POST['pbi_id_in'].")";







//$company=find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']);















?>







<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead>



<tr><th style="border:0px;" colspan="16"><?=$str?></th></tr>







<tr>



  <th>S/L</th>



  <th>Com ID</th>



  <th>Contact Person</th>



  <th>Customer Name</th>



  <th>Company</th>



  <th>Designation</th>



  <th>Department</th>



  <th>Date</th>



  <th>Time</th>



  <th>Subject</th>



  <th>Details</th>



  </tr>



</thead>



<tbody>



<?







if($_POST['project_id'] !=''){ $project_con = " and a.project_id='".$_POST['project_id']."' ";}



if($_POST['service_id'] !=''){ $service_con = " and a.service_id='".$_POST['service_id']."' ";}



if($_POST['dealer_code'] !=''){ $service_con = " and b.dealer_code='".$_POST['dealer_code']."' ";}



if($_POST['PBI_ID'] !=''){ $service_con = " and a.PBI_ID='".$_POST['PBI_ID']."' ";}



if($_POST['f_date'] !='' && $_POST['t_date'] !=''){ $date_con = " and a.c_date between '".$_POST['f_date']."' and '".$_POST['t_date']."' ";}











 $sqld="select b.com_id,(select PBI_NAME from personnel_basic_info where PBI_ID=a.EMP_ID) as contact_person ,(select dealer_name_e from crm_customer_info where dealer_code=b.dealer_code)  as Customer_name, (select PROJECT_DESC from crm_project where PROJECT_ID=a.PROJECT_ID) as project, b.project_desg as designation, b.project_dept as project_dept, a.c_date as datea, a.c_time as timea, a.c_reason as subject, a.c_detail as details from crm_comunication a, crm_com_detail b  where 1 ".$project_con.$service_con.$date_con." and a.id=b.com_id group by b.id order by a.c_date";











$queryd=db_query($sqld);



while($data = mysqli_fetch_object($queryd)){



?>



<tr>



  <td><?=++$s?></td>



  <td><?=$data->com_id?></td>



  <td><?=$data->contact_person?></td>



  <td><?=$data->Customer_name?></td>



  <td><?=$data->project?></td>



  <td><?=$data->designation?></td>



  <td><?=$data->project_dept?></td>



  <td><?=$data->datea?></td>



  <td><?=$data->timea?></td>



  <td><?=$data->subject?></td>



  <td><?=$data->details?></td>



</tr>



<? } ?>







</tbody></table>



<?



}











if($_POST['report']==8) { // mobile number update report











$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,



a.PBI_GROUP as `Group`,



a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,



(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,



(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,



(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,



a.PBI_EDU_QUALIFICATION as qualification,



a.PBI_MOBILE as mobile,a.PBI_INTERNET as modem



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



<!--



<table width="100%"  border="0" id="No CSS Style">



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