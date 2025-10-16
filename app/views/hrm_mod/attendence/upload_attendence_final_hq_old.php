<?php
session_start();
//

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";
$title="Attendance Process (Final)";


do_calander("#m_date");


$head =







'<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';







$table = "hrm_inout";







$unique = "id";







$fix_intime = "05:00:00";







$fix_outtime = "11:59:00";













if (isset($_POST["upload"])) {





$year_mon = $_POST['salary_month'];

$data =explode("-",$_POST['salary_month']);

$year =$data[0];

$mon = $data[1];

$mon_type = find_a_field('salary_months','month_type','salary_month="'.$_POST['salary_month'].'"');

$mon_date = find_all_field('month_type','','1 and id='.$mon_type);





if($mon_type==1){

	$start_mon =date('m', strtotime(date(''.$year.'-'.$mon.'')." -1 month"));

	$start_year =date('Y', strtotime(date(''.$year.'-'.$mon.'')." -1 month"));

	

	$start_date = $start_year."-".$start_mon."-".$mon_date->month_start;

	$end_date  = $year."-".$mon."-".$mon_date->month_end;

}

else{



	$start_date = $year."-".$mon."-".$mon_date->month_start;

	$end_date  = $year."-".$mon."-".$mon_date->month_end;



}

















$emp_id = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['emp_id'].'"');



$PBI_ORG = $_POST["PBI_ORG"];



if($_POST['JOB_LOCATION']>0) $job_location_con = " and p.JOB_LOC_ID='".$_POST['JOB_LOCATION']."'";



$datetime = date("Y-m-d H:i:s");





$startTime = $days1 = strtotime($start_date);



$days_in_month = date('t',$startTime);



$days_mon = date("t", $startTime);





$endTime = $days2 = mktime(23, 59, 59, $mon, $days_in_month, $year);



$m_s_date = $year . "-" . $mon . "-01";



$m_e_date = $year . "-" . $mon . "-" . $days_mon;



$holy_day = find_a_field(

"salary_holy_day",

"count(holy_day)",

'holy_day between "' . $start_date . '" and "' . $end_date . '" and job_loc_id in ('.$_POST['JOB_LOCATION'].',3) '

);

for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {

$day = date("l", $i);

${"day" . date("N", $i)}++;

}

// ------------------------------------------------------------------------------ Manually Set Friday days

//$r_count=${'day5'};

$r_count = find_a_field(

"hrm_payroll_setup",

"friday_of_month",

' `year` = "' . $year . '" and `mon` = "' . $mon . '" '

);

 $sql =

"SELECT h.emp_id,sum(h.leave_duration) lv

FROM `hrm_att_summary` h, personnel_basic_info p

WHERE h.emp_id=p.PBI_ID and h.att_date BETWEEN '" .

$start_date .

"' AND '" .

$end_date .

"' ".$job_location_con." And h.leave_id>0 

AND h.dayname = 'Friday' group by h.emp_id";

$query = db_query($sql);

while ($data = mysqli_fetch_object($query)) {

$total_lv_fri[$data->emp_id] = $data->lv;

}

 $sql =

"SELECT h.emp_id,sum(leave_duration) lv

FROM `hrm_att_summary` h, salary_holy_day d, personnel_basic_info p

WHERE h.emp_id=p.PBI_ID and att_date=holy_day and `att_date` BETWEEN '" .

$start_date .

"' AND '" .

$end_date .

"' ".$job_location_con."  And leave_id>'0' and d.job_loc_id in (1,3)

group by h.emp_id";

$query = db_query($sql);

while ($data = mysqli_fetch_object($query)) {

$total_holyday_leave[$data->emp_id] = $data->lv;

}

if ($emp_id > 0) {

$emp_con = " and p.PBI_ID='" . $emp_id . "'";

}

if ($PBI_ORG > 0) {

$ORG_con = " and p.PBI_ORG='" . $PBI_ORG . "'";

}











  $sql ="SELECT h.emp_id,(count(1)-sum(h.leave_duration)) pre, 
  sum(h.final_late_min) l_min,
  sum(h.final_late_status) l_status,sum(h.ot_final_hour) as total_over_time,sum(h.sch_off_day) as od,
 p.PBI_DOJ,p.PBI_ID,sum(h.final_early_status) as early_out,sum(h.final_late_status) as total_late,sum(h.final_late_min+h.final_early_min) as total_late_min,p.DEPT_ID 
 
 FROM `hrm_att_summary` h,personnel_basic_info p 
 
 WHERE 1 and h.present=1  and p.PBI_ID=h.emp_id and h.att_date BETWEEN '" .$start_date ."' AND '" .$end_date ."' " .$emp_con .$ORG_con .$job_location_con.

"  group by h.emp_id";

$query = db_query($sql);

while ($data = mysqli_fetch_object($query)) {


/*$sqll ="SELECT h.*,p.PBI_DOJ FROM `hrm_att_summary` h,personnel_basic_info p WHERE 1 and p.PBI_ID=h.emp_id and  (h.sch_off_day=1 or h.holyday=1)  and 
h.att_date BETWEEN '" .$start_date ."' AND '" .$end_date ."' and h.emp_id=".$data->emp_id."  ";

$queryy = db_query($sqll);

$force_leave=0;

while($datas=mysqli_fetch_object($queryy)){

if($datas->att_date > $datas->PBI_DOJ){

$pre_date = find_all_field('hrm_att_summary','','1 and att_date<"'.$datas->att_date.'" and emp_id='.$datas->emp_id.' and holyday=0 and sch_off_day=0 order by att_date desc');

$post_date = find_all_field('hrm_att_summary','','1 and att_date>"'.$datas->att_date.'" and emp_id='.$datas->emp_id.' and holyday=0 and sch_off_day=0 order by att_date asc');

if($pre_date->present==0 && $post_date->present==0){

$force_leave++;

}

}

$day_deduct[$datas->emp_id]=$force_leave;

}
*/


$pi++;

//echo $startTime; echo '<br>'.strtotime($data->PBI_DOJ);

$values[$pi]["emp_id"] = $data->emp_id;

$late_panelty = 0;

$leave_days_lv = 0;

$iom_days = 0;

$leave_days_lwp = 0;

$new_emp_days = 0;

$new_emp_off = 0;

$new_emp_holy_day = 0;

$late_panelty =

(int) (@($data->l_min / 30) > @($data->l_status / 3)

? @($data->l_min / 30)

: @($data->l_status / 3));

if (strtotime($data->PBI_DOJ) > $startTime) {

//get friday

$no = 0;

$start = new DateTime($data->PBI_DOJ);

$end = new DateTime($end_date);

$interval = DateInterval::createFromDateString("1 day");

$period = new DatePeriod($start, $interval, $end);

foreach ($period as $dt) {

if ($dt->format("N") == 5) {

$no++;

}

}

//echo  $no;

//get friday

$new_emp_days = ceil(

($endTime - strtotime($data->PBI_DOJ)) / (3600 * 24)

);

// $new_emp_days = $days_mon;

 $new_emp_holy_day = find_a_field(

"salary_holy_day",

"count(holy_day)",

'holy_day between "' .

$data->PBI_DOJ .

'" and "' .

$year .

"-" .

$mon .

"-" .

$days_mon .

'"  and job_loc_id in (1,3) '

);

// echo  $data->PBI_DOJ;

${"day5"} = 0;

for (

$i = strtotime($data->PBI_DOJ);

$i <= $endTime;

$i = $i + 86400

) {

$day = date("l", $i);

if ($day == "Friday") {

${"day" . date("N", $i)}++;

}

}

$new_emp_off = ${"day5"};

} else {

$new_emp_days = $days_mon;

$new_emp_off = $r_count;

$new_emp_holy_day = $holy_day;

}

// leave

'PBI_ID="' .

$data->PBI_ID .

'" and leave_type=1 and leave_id>0 and att_date between "' .

$start_date .

'" and "' .

$end_date .

'" ';

$leave_days_lv = find_a_field(

"hrm_att_summary",

"sum(leave_duration)",

'emp_id="' .

$data->PBI_ID .

'" and  leave_id>0 and att_date between "' .

$start_date .

'" and "' .

$end_date .

'" '

);

$iom_days = find_a_field(

"hrm_att_summary",

"count(1)",

'emp_id="' .

$data->PBI_ID .

'" and  iom_id>0 and att_date between "' .

$start_date .

'" and "' .

$end_date .

'" '

);

$leave_days_lwp = find_a_field(

"hrm_leave_info",

"sum(total_days)",

'PBI_ID="' .

$data->PBI_ID .

'" and type="LWP (Leave Without Pay)" and s_date between "' .

$start_date .

'" and "' .

$end_date .

'" '

);

$values[$pi]["td"] = $new_emp_days;



if(strtotime($data->PBI_DOJ) > $startTime){

$values[$pi]["od"] = $new_emp_off - $total_lv_fri[$data->emp_id];

$values[$pi]["hd"] =

$new_emp_holy_day - $total_holyday_leave[$data->PBI_ID];

//$values[$pi]["pre"] =  $new_emp_days - ($leave_days_lv + $leave_days_lwp + $new_emp_holy_day + $values[$pi]["od"]);

$values[$pi]["pre"] =  $data->pre;

//values[$pi]["od"] = $new_emp_off;

} else {

$values[$pi]["od"] = $data->od; // find_a_field("hrm_payroll_setup","friday_of_month",'mon="' . $mon . '" and year="' . $year . '"')-$total_lv_fri[$data->emp_id];

if(strtotime($data->PBI_DOJ) > $startTime){

 $m_s_date =$data->PBI_DOJ;

}

$values[$pi]["hd"] = find_a_field(

"salary_holy_day  ",

"count(id)",

'holy_day between "' . $m_s_date . '" and "' . $m_e_date . '" and job_loc_id in (1,3) '

);

 $values[$pi]["pre"] = $data->pre;

$values[$pi]["hourly_leave"] = $data->total_hourly_leave;

//$data->absent_count;

}

//Leave Check In Offday

$start_date = date('Y-m-d',strtotime($start_date));

$end_date = date('Y-m-d',strtotime($end_date));

$leave_in_hd_od = 0;

for($i=$start_date;$i<=$end_date;$i = date('Y-m-d', strtotime( $i . " +1 days"))){ 

$new_date = $i;

$check_roster = find_a_field('hrm_roster_allocation','shedule_1','roster_date="'.$new_date.'" and PBI_ID="'.$data->PBI_ID.'"');

if($check_roster==3){

$check_od_in_roster_od = find_a_field('hrm_att_summary','id','att_date="'.$new_date .'" and emp_id="'.$data->PBI_ID.'" and leave_id>0');

if($check_od_in_roster_od>0){

$leave_in_hd_od++;

}

}else{

$check_sch_id = find_a_field('hrm_att_summary','sch_id','att_date="'.$new_date .'" and emp_id="'.$data->PBI_ID.'"');

$sch_od = find_a_field('hrm_schedule_info','off_day','id="'.$check_sch_id.'"');

if($sch_od==''){

$sch_od = find_a_field('personnel_basic_info','define_offday','PBI_ID="'.$data->PBI_ID.'"');

}

$check_leave_in_od_hd = find_a_field('hrm_att_summary','count(id)','dayname="'.$sch_od.'" and att_date="'.$new_date.'" and emp_id="'.$data->PBI_ID.'"  and leave_id>0');

if($check_leave_in_od_hd>0){

$leave_in_hd_od++;

// '<br>';

}

}

}

//Leave IOM Check In Holyday

$lv_iom_in_hd = 0;

$holy_sql = db_query('select * from salary_holy_day where holy_day between "'.$start_date.'" and "'.$end_date.'" and job_loc_id in (1,3)');

while($holy_data=mysqli_fetch_object($holy_sql)){

$check_lv_iom_in_hd = find_a_field('hrm_att_summary','id','att_date="'.$holy_data->holy_day.'" and emp_id="'.$data->PBI_ID.'"  and (leave_id>0 or iom_id>0)');

if($check_lv_iom_in_hd>0){

$lv_iom_in_hd++;

}

}

// $values[$pi]['lt'] = $late_panelty*.5;

$values[$pi]['lt'] = $data->total_late;

// $values[$pi]["lt"] = $data->l_status;

$values[$pi]["lv"] = $leave_days_lv;

$values[$pi]["iom"] = $iom_days;

$values[$pi]["total_late_min"] = $data->total_late_min;

$values[$pi]["lwp"] = $leave_days_lwp;

$values[$pi]["total_over_time"] = $data->total_over_time ;

//$values[$pi]['pay'] = $values[$pi]['pre']  + $values[$pi]['hd'] + $values[$pi]['od'] - $values[$pi]['lt'];

$values[$pi]["early_out"] = $data->early_out;

 $friday_office = find_a_field('hrm_att_summary','count(id)','dayname="Friday" and att_date between "'.$start_date.'" and "'.$end_date.'" and emp_id="'.$data->PBI_ID.'" and leave_id=0 and iom_id=0');

 $hollyday_office = find_a_field('hrm_att_summary','sum(Holiday_Work)','att_date between "'.$start_date.'" and "'.$end_date.'" and emp_id="'.$data->PBI_ID.'"');

$iom_in_friday = find_a_field('hrm_att_summary','count(id)','iom_type="Full" and dayname="Friday" and emp_id="'.$data->PBI_ID.'" and att_date between "'.$start_date.'" and "'.$end_date.'"');

//$values[$pi]["pre"]

$values[$pi]['hd'] = $values[$pi]['hd']-$lv_iom_in_hd;

 $values[$pi]['od'] = $values[$pi]['od'];

 $values[$pi]['pre'] = ($values[$pi]['pre']-($friday_office+$hollyday_office));

$values[$pi]['day_deduct']= $day_deduct[$data->PBI_ID];



 $values[$pi]['pay'] = ($values[$pi]['pre'] + $values[$pi]['hd'] + $values[$pi]['od']+$values[$pi]["lv"])-($values[$pi]["lwp"]+$values[$pi]['day_deduct']);



 $values[$pi]['ab'] = (($values[$pi]['td']+$values[$pi]['day_deduct'])-($values[$pi]['pre'] + $values[$pi]['hd'] + $values[$pi]['od']+$values[$pi]["lv"]));

$values[$pi]['pre'];

$values[$pi]['days_mon']= $days_mon;	



}

for ($y = 1; $y <= $pi; $y++) {

$found = find_a_field(

"hrm_attendence_final",

"1",

'PBI_ID="' .

$values[$y]["emp_id"] .

'" and mon="' .

$mon .

'" and year="' .

$year .

'"'

);

if ($found == 0) {

 $sql =

"INSERT INTO `hrm_attendence_final` 

(`mon`, `year`, `PBI_ID`, `td`, `od`, `hd`, `lt`, `total_late_min`, `eo`,`ab`, `lv`,`iom`,`lwp`, `pre`, `pay`,`ot`,`hourly_leave`, `entry_at`, `entry_by`,`days_mon`,`day_deduct`) 
values

('" .$mon."','".$year."','" .$values[$y]["emp_id"] ."','" .$values[$y]["td"] ."','" .$values[$y]["od"] ."', '" .$values[$y]["hd"] ."','" .$values[$y]["lt"] ."','" .$values[$y]["total_late_min"] ."', '" .$values[$y]["early_out"] ."', '" .$values[$y]["ab"] ."','" .$values[$y]["lv"] ."','" .$values[$y]["iom"] ."','" .$values[$y]["lwp"] ."','" .$values[$y]["pre"] ."','" .$values[$y]["pay"] ."',
'" .$values[$y]["total_over_time"] ."','" .$values[$y]["hourly_leave"] ."','" .date("Y-m-d H:i:s")."','".$_SESSION["user"]["id"]."','".$values[$y]['days_mon']."','".$values[$y]['day_deduct']."')";

db_query($sql);

} else {

 $sql =

"Update `hrm_attendence_final` set 

td='" .

$values[$y]["td"] .

"', od='" .

$values[$y]["od"] .

"',hd='" .

$values[$y]["hd"] .

"', lt='" .

$values[$y]["lt"] .

"',total_late_min='" .

$values[$y]["total_late_min"] .

"',iom='" .

$values[$y]["iom"] .

"',   eo='" .

$values[$y]["early_out"] .

"',

ab='" .

$values[$y]["ab"] .

"',lv='" .

$values[$y]["lv"] .

"',lwp='" .

$values[$y]["lwp"] .

"',pre='" .

$values[$y]["pre"] .

"',pay='" .

$values[$y]["pay"] .

"',

ot='" .

$values[$y]["total_over_time"] .

"',hourly_leave='" .

$values[$y]["hourly_leave"] .

"',entry_at='" .

date("Y-m-d H:i:s") .

"',entry_by='" .

$_SESSION["user"]["id"] .

"',days_mon='".$values[$y]['days_mon']."',day_deduct='".$values[$y]['day_deduct']."' where mon='" .

$mon .

"' and year='" .

$year .

"' and PBI_ID='" .

$values[$y]["emp_id"] .

"'";

db_query($sql);

}

}

echo "Complete";

//echo $sql;

}



?>







<style type="text/css">







<!--







.style1 {font-size: 24px}







.style2 {







color: #FF66CC;







font-weight: bold;







}







-->







</style>







<form action=""  method="post" enctype="multipart/form-data">







    <div class="d-flex justify-content-center">







        <div class="n-form1 fo-width pt-0">



            <h4 class="text-center bg-titel bold pt-2 pb-2">Salary Process HRM Attendance Final</h4>



            <div class="container-fluid p-0">



                <div class="row">



                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



                        <div class="form-group row  m-0 mb-1 pl-3 pr-3">



                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code :  </label>



                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">



                          
							  
							  
    <input type="text"  list='eip_ids' name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" />
                <datalist id='eip_ids'>
                  <option></option>
                  <?
			foreign_relation('personnel_basic_info','PBI_CODE','concat(PBI_CODE," - ",PBI_NAME)',$emp_id,'1');
			?>
                </datalist>



                            </div>



                        </div>



                    </div>







                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







                        <div class="form-group row m-0 mb-1 pl-3 pr-3">



                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company :    </label>



                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">



                              <select name="PBI_ORG" id="PBI_ORG">







								<? foreign_relation('user_group','id','group_name',$PBI_ORG);?>



								



								</select>



                            </div>



                        </div>







                    </div>



					



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







                        <div class="form-group row m-0 mb-1 pl-3 pr-3">



                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Location :    </label>



                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">



                              
                                       <select name="JOB_LOCATION" id="JOB_LOCATION"  class="form-control" required >
                                            <option></option>
                                            <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$JOB_LOCATION);?>
                                          </select>








                            </div>



                        </div>



						



                    </div>







                    











                    















                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



                                

							<div class="form-group row m-0 mb-1 pl-3 pr-3">



                                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Month :    </label>



                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">







                                       <select name="salary_month"  id="salary_month" required>

	

												  <option></option>

	

												  <?=foreign_relation('salary_months','salary_month','salary_month',$_POST['salary_month'],'1 and status="Active"');?>

											  </select>







                                    </div>



                                </div>

								



                            </div>







                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



                                



								



                            </div>















                </div>











                <div class="n-form-btn-class">



                    <input name="upload" type="submit" class="btn1 btn1-bg-submit" id="upload" value="Sync All Data" />



                </div>







            </div>







        </div>







    </div>











    











</form>















<?php /*?><div class="oe_view_manager oe_view_manager_current">







<form action=""  method="post" enctype="multipart/form-data">







<div class="oe_view_manager_body">







<div  class="oe_view_manager_view_list"></div>







<div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">







<div class="oe_form_buttons"></div>







<div class="oe_form_sidebar"></div>







<div class="oe_form_pager"></div>







<div class="oe_form_container"><div class="oe_form">







<div class="">







<div class="oe_form_sheetbg">







<div class="oe_form_sheet oe_form_sheet_width">







<div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">







<table width="80%" border="1" align="center">







<tr>







<td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Salary Process - hrm_attendence_final</div></td>







</tr>







<tr>







<td>Employee ID</td>







<td colspan="3"><label>







<input type="text" name="emp_id" id="emp_id" value="<?= $_POST[







"emp_id"







] ?>" />







</label></td>







</tr>







<tr>







<td>Company:</td>







<td colspan="3"><span class="oe_form_group_cell">







<select name="PBI_ORG" style="width:160px;" id="PBI_ORG">







<? foreign_relation('user_group','id','group_name',$PBI_ORG);?>







</select>







</span></td>







</tr>







<tr>







<td>Location:</td>







<td colspan="3"><span class="oe_form_group_cell">







<select name="JOB_LOCATION" style="width:160px;" id="JOB_LOCATION">







<option></option>







<? foreign_relation('job_location_type','id','job_location_name',$JOB_LOCATION);?>







</select>







</span></td>







</tr>







<tr>







<td width="20%">Month :</td>







<td colspan="3"><span class="oe_form_group_cell">







<select name="mon" style="width:160px;" id="mon" required="required">







<option value="1" <?= $mon == "01" ? "selected" : "" ?>>Jan</option>







<option value="2" <?= $mon == "02" ? "selected" : "" ?>>Feb</option>







<option value="3" <?= $mon == "03" ? "selected" : "" ?>>Mar</option>







<option value="4" <?= $mon == "04" ? "selected" : "" ?>>Apr</option>







<option value="5" <?= $mon == "05" ? "selected" : "" ?>>May</option>







<option value="6" <?= $mon == "06" ? "selected" : "" ?>>Jun</option>







<option value="7" <?= $mon == "07" ? "selected" : "" ?>>Jul</option>







<option value="8" <?= $mon == "08" ? "selected" : "" ?>>Aug</option>







<option value="9" <?= $mon == "09" ? "selected" : "" ?>>Sep</option>







<option value="10" <?= $mon == "10" ? "selected" : "" ?>>Oct</option>







<option value="11" <?= $mon == "11" ? "selected" : "" ?>>Nov</option>







<option value="12" <?= $mon == "12" ? "selected" : "" ?>>Dec</option>







</select>







</span></td>







</tr>







<tr>







<td>Year :</td>







<td colspan="3"><select name="year" style="width:160px;" id="year" required="required">







<option <?= $year == "2022" ? "selected" : "" ?>>2022</option>







<option <?= $year == "2023" ? "selected" : "" ?>>2023</option>







<option <?= $year == "2021" ? "selected" : "" ?>>2021</option>







</select></td>







</tr>







<tr>







<td colspan="4">







<div align="center">







<input name="upload" type="submit" class="btn1 btn1-bg-submit" id="upload" value="Sync All Data" />







</div></td>







</tr>







<tr>







<td colspan="4"><label>







<div align="center">







<p>&nbsp;</p>







</div>







</label></td>







</tr>







</table>







<br />







</div>







</div>







</div>







</div>







<div class="oe_chatter"><div class="oe_followers oe_form_invisible">







<div class="oe_follower_list"></div>







</div></div></div></div></div>







</div></div>







</div>







</form>   </div><?php */?>







<?







$main_content=ob_get_contents();







ob_end_clean();







require_once SERVER_CORE."routing/layout.bottom.php";







?>