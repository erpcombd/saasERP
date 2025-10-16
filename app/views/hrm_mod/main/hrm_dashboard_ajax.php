<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."core/init.php";


@ini_set('error_reporting', E_ALL);



@ini_set('display_errors', 'Off');



$today = date('Y-m-d');

$last30days = date("Y-m-d", strtotime("-30 days", strtotime($today)));

$lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));

$sunday=date('Y-m-d',strtotime('last sunday'));

$monday=date('Y-m-d',strtotime('last monday'));

$tuesday=date('Y-m-d',strtotime('last tuesday'));

$wednesday=date('Y-m-d',strtotime('last wednesday'));

$thursday=date('Y-m-d',strtotime('last thursday'));

$friday=date('Y-m-d',strtotime('last friday'));

$saturday=date('Y-m-d',strtotime('last saturday'));



$jan_start = date('Y-01-01');

$jan_end = date('Y-01-31');



$feb_start = date('Y-02-01');

$feb_end = date('Y-02-28');



$mar_start = date('Y-03-01');

$mar_end = date('Y-03-31');



$apr_start = date('Y-04-01');

$apr_end = date('Y-04-30');



$may_start = date('Y-05-01');

$may_end = date('Y-05-31');



$jun_start = date('Y-06-01');

$jun_end = date('Y-06-30');



$jul_start = date('Y-07-01');

$jul_end = date('Y-07-31');



$aug_start = date('Y-08-01');

$aug_end = date('Y-08-31');



$sep_start = date('Y-09-01');

$sep_end = date('Y-9-30');



$oct_start = date('Y-10-01');

$oct_end = date('Y-10-31');



$nov_start = date('Y-11-01');

$nov_end = date('Y-11-30');



$dec_start = date('Y-12-01');

$dec_end = date('Y-12-31');





$totalActiveEmp = find_a_field('personnel_basic_info','count(PBI_ID)','PBI_JOB_STATUS="In Service"');

$totalInactiveEmp = find_a_field('personnel_basic_info','count(PBI_ID)','PBI_JOB_STATUS="Not In Service"');

$totalLeaveRequest = find_a_field('hrm_leave_info','count(id)','s_date<="'.$last30days.'" and e_date>="'.$today.'"');



$nextHoliday = find_all_field('salary_holy_day','','holy_day>"'.$today.'" order by id asc');

$nextHolidayDate = date('M d',strtotime($nextHoliday->holy_day));

$nextEvent = $nextHoliday->reason;



$total_att = find_a_field('hrm_attdump','count(sl)','xdate="'.$today.'" group by EMP_CODE');

$absent = $totalActiveEmp-$total_att;







$total_public=$totalActiveEmp;

$presentP = ($total_att*100)/$total_public;

$absentP = ($absent*100)/$total_public;



$approvedLeave = find_a_field('hrm_leave_info','count(id)','s_date<="'.$last30days.'" and e_date>="'.$today.'" and leave_status="Approve"');

$pendingdLeave = find_a_field('hrm_leave_info','count(id)','s_date<="'.$last30days.'" and e_date>="'.$today.'" and leave_status="Pending"');



$male = find_a_field('personnel_basic_info','count(PBI_ID)','PBI_JOB_STATUS="In Service" and PBI_SEX="Male"');

$female = find_a_field('personnel_basic_info','count(PBI_ID)','PBI_JOB_STATUS="In Service" and PBI_SEX="Female"');



$thisYear = date('Y');

$lastYear = date('Y')-1;

$previousYear = date('Y')-2;

$thisYearSalary = find_a_field('salary_attendence','sum(total_payable)','year="'.$thisYear.'"');

$lastYearSalary = find_a_field('salary_attendence','sum(total_payable)','year="'.$lastYear.'"');

$preYearSalary = find_a_field('salary_attendence','sum(total_payable)','year="'.$previousYear.'"');


$sql = "select xenrollid,  max(xtime) as max_time  from hrm_attdump where xdate ='".$today."' and xenrollid>0 group by xenrollid ";
$query = db_query($sql);
while($info=mysqli_fetch_object($query)){
++$p;
}

$today_absent = $totalActiveEmp-$p;





$Sat=find_a_field('hrm_attdump','count(sl)','xdate="'.$saturday.'" group by EMP_CODE');

$Sun=find_a_field('hrm_attdump','count(sl)','xdate="'.$sunday.'" group by EMP_CODE');

$Mon=find_a_field('hrm_attdump','count(sl)','xdate="'.$monday.'" group by EMP_CODE');

$Tue=find_a_field('hrm_attdump','count(sl)','xdate="'.$tuesday.'" group by EMP_CODE');

$Wed=find_a_field('hrm_attdump','count(sl)','xdate="'.$wednesday.'" group by EMP_CODE');

$Thu=find_a_field('hrm_attdump','count(sl)','xdate="'.$thursday.'" group by EMP_CODE');

$Fri=find_a_field('hrm_attdump','count(sl)','xdate="'.$friday.'" group by EMP_CODE');



$totalAtt = $Sat+$Sun+$Mon+$Tue+$Wed+$Thu+$Fri;



$hSat=($Sat*100)/$totalAtt;

$hSun=($Sun*100)/$totalAtt;

$hMon=($Mon*100)/$totalAtt;

$hTue=($Tue*100)/$totalAtt;

$hWed=($Wed*100)/$totalAtt;

$hThu=($Thu*100)/$totalAtt;

$hFri=($Fri*100)/$totalAtt;





$notice_title = find_a_field('notice','notice_title','1 order by id desc');

$notice_description = find_a_field('notice','notice_description','1 order by id desc');



$res = 'select PBI_CODE, PBI_NAME as employee_name, PBI_DESIGNATION as designation, PBI_DEPARTMENT as department from personnel_basic_info where 1 order by PBI_ID desc limit 5';









$all_dealer[]=number_format($totalActiveEmp,2);

$all_dealer[]=number_format($totalInactiveEmp,2);

$all_dealer[]=number_format($totalLeaveRequest,2);

$all_dealer[]=$nextHolidayDate;

$all_dealer[]=$nextEvent;



$all_dealer[]=$presentP;

$all_dealer[]=$absentP;

$all_dealer[]=$today_absent;//$total_att;

$all_dealer[]=$p;//$absent;



$all_dealer[]=$approvedLeave;

$all_dealer[]=$pendingLeave;



$all_dealer[]=$male;

$all_dealer[]=$female;



$all_dealer[]=$thisYearSalary;

$all_dealer[]=$lastYearSalary;

$all_dealer[]=$preYearSalary;



$all_dealer[]=$hSat;

$all_dealer[]=$hSun;

$all_dealer[]=$hMon;

$all_dealer[]=$hTue;

$all_dealer[]=$hWed;

$all_dealer[]=$hThu;

$all_dealer[]=$hFri;



$all_dealer[]=link_report($res);

$all_dealer[]=$notice_title;
$all_dealer[]=$notice_description;

echo json_encode($all_dealer);



?>







