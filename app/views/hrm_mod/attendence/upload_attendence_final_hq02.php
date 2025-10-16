<?php
session_start();
//


require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";
$title="Attendance Process (Final)";
do_calander("#m_date");
$head ='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

$table = "hrm_inout";
$unique = "id";




if (isset($_POST["upload"])) {

$year_mon = $_POST['salary_month'];

$data =explode("-",$_POST['salary_month']);

$year =$data[0];

$mon = $data[1];

$mon_type = find_a_field('salary_months','month_type','salary_month="'.$_POST['salary_month'].'"');

$mon_date = find_all_field('month_type','','1 and id='.$mon_type);

$firstDay = date('Y-m-01', strtotime($_POST['salary_month']));
$lastDay = date('Y-m-t', strtotime($_POST['salary_month']));
$total_days_dynamic = (strtotime($lastDay) - strtotime($firstDay)) / (60 * 60 * 24) + 1;


if($mon_type==1){

	$start_mon =date('m', strtotime(date(''.$year.'-'.$mon.'')." -1 month"));

	$start_year =date('Y', strtotime(date(''.$year.'-'.$mon.'')." -1 month"));

	

	 $start_date = $start_year."-".$start_mon."-".$mon_date->month_start;

	$end_date  = $year."-".$mon."-".$mon_date->month_end;

}

else{
     $start_date = $year."-".$mon."-".$mon_date->month_start;

	$end_date  = $year."-".$mon."-".$total_days_dynamic;



}





if($_POST['emp_id']>0) 
$emp_id = $_POST['emp_id'];

$PBI_ORG = $_POST['PBI_ORG'];
$job_loc =$_POST['JOB_LOCATION'];


//$emp_id  = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['emp_id'].'"'); // $_POST['emp_id'] ;

//$PBI_ORG = $_POST["PBI_ORG"];
//if($_POST['PBI_ORG']>0) $ORG_con = " and p.PBI_ORG='".$_POST['PBI_ORG']."'";

$datetime = date("Y-m-d H:i:s");
$startTime = $days1 = strtotime($start_date);
$days_in_month = date('t',$startTime);
$days_mon = date("t", $startTime);

$endTime = $days2 = mktime(23, 59, 59, $mon, $days_in_month, $year);
$m_s_date = $year . "-" . $mon . "-01";
$m_e_date = $year . "-" . $mon . "-" . $days_mon;


if($emp_id>0)    $emp_con = " and p.PBI_ID='".$emp_id."'";

if ($PBI_ORG > 0) {$ORG_con = " and p.PBI_ORG='" . $PBI_ORG . "'";}

if($job_loc>0) $loc_con = " and p.JOB_LOC_ID='".$job_loc."'";


  $sql ="SELECT h.emp_id,sum(h.present) as pre, sum(h.final_late_min) l_min,sum(h.final_late_status) l_status, 
 sum(h.leave_duration) as leave_days_lv,sum(h.sch_off_day) as od,
  sum(h.annual_leave) as annual_leave_balance,sum(h.holiday_work) as holiday_work,sum(h.iom_duration) as iom_days,
  sum(h.ot_time_to_decimal) as ot_time_to_decimal,p.PBI_DOJ,p.PBI_ID,sum(h.final_early_status) as early_out,sum(h.final_late_status) as total_late,
  sum(h.actual_late_min+h.final_early_min) as total_late_min,sum(h.holyday) as holyday,
  sum(h.lv_punishment_status) as leave_punishment,h.iom_type,
  
  p.DEPT_ID,p.resign_date
  
  FROM `hrm_att_summary` h,personnel_basic_info p 
  WHERE 1  and p.PBI_ID=h.emp_id and h.att_date BETWEEN '" .$start_date ."' AND '" .$end_date ."' " .$emp_con.$loc_con.$ORG_con ."  group by h.emp_id";

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

}*/



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

$late_panelty = (int) (@($data->l_min / 30) > @($data->l_status / 3) ? @($data->l_min / 30) : @($data->l_status / 3));



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

 $new_emp_days = ceil(($endTime - strtotime($data->PBI_DOJ)) / (3600 * 24));

// $new_emp_days = $days_mon;
$new_emp_holy_day = find_a_field("salary_holy_day","count(holy_day)",'holy_day between "' .$data->PBI_DOJ .'" and "' .$year ."-" .$mon ."-" .$days_mon .'"');

 $new_emp_holiday_individual = find_a_field("salary_holy_day_individual","count(holy_day)",'
PBI_ID="'.$data->emp_id.'" and holy_day between "' .$data->PBI_DOJ .'" and "' .$year ."-" .$mon ."-" .$days_mon .'"');


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


$holiday_and_leave_deduction = find_a_field("hrm_att_summary","sum(leave_duration)",'emp_id="' .$data->PBI_ID .'" and 
att_date between "' .$start_date .'" and "' .$end_date .'" and holyday=1 and leave_type="Full" ');

$leave_days_lwp = find_a_field("hrm_leave_info","sum(total_days)",'PBI_ID="' .$data->PBI_ID .'" and type=9 and s_date between "' .$start_date .'" and "' .$end_date .'" ');

$emp_day_off_count = find_a_field("hrm_att_summary","sum(final_day_off_status)",'emp_id="' .$data->PBI_ID .'" and att_date between "' .$start_date .'" and "' .$end_date .'" ');
$values[$pi]["td"] = $new_emp_days;

// __________________ NEW EMP JOIN DAY CALCULATION  ___________
if(strtotime($data->PBI_DOJ) > $startTime){

 $values[$pi]["od"] = $new_emp_off - $total_lv_fri[$data->emp_id];

 $values[$pi]["hd"] = (($new_emp_holy_day+$new_emp_holiday_individual) - $total_holyday_leave[$data->PBI_ID]);

$values[$pi]["pre"] =  ($data->pre+$values[$pi]["od"]  - ($data->holi_work+$data->od));

//echo $values[$pi]['ab'] = (($values[$pi]['td'])-($values[$pi]['pre']+$values[$pi]['od']+ $values[$pi]['hd']));

//values[$pi]["od"] = $new_emp_off;

} else {

 $values[$pi]["od"] = $data->od;

if(strtotime($data->PBI_DOJ) > $startTime){
$m_s_date =$data->PBI_DOJ;

}

 $values[$pi]["hd"] =  ($data->holyday-$holiday_and_leave_deduction); //find_a_field("salary_holy_day  ","count(id)",'holy_day between "' . $m_s_date . '" and "' . $m_e_date . '"');

 $values[$pi]["pre"] = ($data->pre-$data->holi_work);

}


//______________  Resign Emp Calculation _______________________________

if($data->resign_date>0 && strtotime($data->resign_date) < $endTime){ 

 //$resign_emp_holy_day = find_a_field("salary_holy_day", "count(id)",'holy_day between "'.$m_s_date.'" and "'.$data->resign_date.'"');

if( strtotime($data->PBI_DOJ) > $startTime){

  $sql = "SELECT SUM(sch_off_day) AS offday_count, SUM(present) AS PresentDays,SUM(holyday) AS HoliDays  
  FROM hrm_att_summary WHERE emp_id='".$data->PBI_ID ."' and 
  att_date BETWEEN '" . $data->PBI_DOJ . "' and '" . $data->resign_date ."'";
  $result = db_query($sql);
  $row = mysqli_fetch_assoc($result);
  $resign_emp_off  = $row['offday_count'];
  $resign_emp_PresentDays  = $row['PresentDays'];
  $resign_emp_holy_day  = $row['HoliDays'];
  $resign_emp_days = ceil((strtotime($data->resign_date)-strtotime($data->PBI_DOJ)) / (3600 * 24)+1);
  
  


}else{

  $sql = "SELECT SUM(sch_off_day) AS offday_count, SUM(present) AS PresentDays,SUM(holyday) AS HoliDays  
  FROM hrm_att_summary 
 WHERE emp_id='".$data->PBI_ID ."' and att_date BETWEEN '" . $m_s_date . "' and '" . $data->resign_date ."'";
  $result = db_query($sql);
  $row = mysqli_fetch_assoc($result);
  $resign_emp_off  = $row['offday_count'];
  $resign_emp_PresentDays  = $row['PresentDays'];
  $resign_emp_holy_day  = $row['HoliDays'];
  $resign_emp_days = ceil((strtotime($data->resign_date)-$startTime) / (3600 * 24)+1);
}

$values[$pi]["td"] = $resign_emp_days;
$values[$pi]["od"] = $resign_emp_off; 
$values[$pi]["hd"] = $resign_emp_holy_day;
$values[$pi]["pre"] =  $resign_emp_PresentDays;
}
//______________  end Resign Emp Calculation _______________________________	
	

//Leave Check In Offday

$start_date = date('Y-m-d',strtotime($start_date));

$end_date = date('Y-m-d',strtotime($end_date));




$leave_in_hd_od = 0;



$lv_iom_in_hd = 0;
$values[$pi]['lt'] = $data->total_late;

$values[$pi]["lv"] = $data->leave_days_lv;

$values[$pi]["iom"] = $iom_days;
$values[$pi]["total_late_min"] = $data->total_late_min;

$values[$pi]["lwp"] = $leave_days_lwp;

$values[$pi]["ot_time_to_decimal"] = find_a_field("hrm_att_summary","sum(ot_time_to_decimal)",'emp_id="' .$data->PBI_ID .'" and att_date between "' .$start_date .'" and "' .$end_date .'" ');

$values[$pi]["full_day_iom"] = find_a_field("hrm_att_summary","count(id)",'emp_id="' .$data->PBI_ID .'" and 
att_date between "' .$start_date .'" and "' .$end_date .'" and iom_type="Full" ');
 
$values[$pi]["annual_leave_balance"] = $data->annual_leave_balance;

//$values[$pi]['pay'] = $values[$pi]['pre']  + $values[$pi]['hd'] + $values[$pi]['od'] - $values[$pi]['lt'];

$values[$pi]["early_out"] = $data->early_out;

//$values[$pi]["pre"]

$values[$pi]['hd'] = $values[$pi]['hd']-$lv_iom_in_hd;

 $values[$pi]['od'] = $values[$pi]['od'];

$values[$pi]['pre'] = ($values[$pi]['pre']-($values[$pi]['od']+$values[$pi]["lv"]+$data->holiday_work)); //+$data->holiday_work

$values[$pi]['day_deduct']= $day_deduct[$data->PBI_ID];

if($emp_day_off_count>0)
$values[$pi]["day_off"] = ($emp_day_off_count - $values[$pi]['hd']);


$values[$pi]['pay'] = ($values[$pi]['pre'] + $values[$pi]['hd'] + $values[$pi]['od']+$values[$pi]["lv"]+$values[$pi]["day_off"])-($values[$pi]["lwp"]+$values[$pi]['day_deduct']);


$values[$pi]['ab'] = (($values[$pi]['td']+$values[$pi]['day_deduct'])-($values[$pi]['pre']+$values[$pi]["lv"]+$values[$pi]["day_off"]+$values[$pi]['od']+ $values[$pi]['hd']));

$values[$pi]['pre'];

$values[$pi]['days_mon']= $days_mon;	



}

$sql = "delete h.* from `hrm_attendence_final` h,personnel_basic_info p
WHERE p.PBI_ID=h.PBI_ID and h.year = ".$year." and h.mon=".$mon."  " .$emp_con .$ORG_con ." ";
$query = db_query($sql);




for ($y = 1; $y <= $pi; $y++) {



 $sql ="INSERT INTO `hrm_attendence_final` 

(`mon`, `year`, `PBI_ID`, `td`, `od`, `hd`, `lt`, `total_late_min`, `eo`,`ab`, `lv` , `day_off` ,`iom`,`full_day_iom`,`lwp`, `pre`, `pay`,`ot`,`annual_leave_balance`, `entry_at`, `entry_by`,`days_mon`,`leave_punishment`,`day_deduct`) 
values

('" .$mon."','".$year."','" .$values[$y]["emp_id"] ."','" .$values[$y]["td"] ."','" .$values[$y]["od"] ."', '" .$values[$y]["hd"] ."','" .$values[$y]["lt"] ."','" .$values[$y]["total_late_min"] ."', 
'" .$values[$y]["early_out"] ."', '" .$values[$y]["ab"] ."','" .$values[$y]["lv"] ."', '" .$values[$y]["day_off"] ."' , '" .$values[$y]["iom"] ."',
'" .$values[$y]["full_day_iom"] ."',
'" .$values[$y]["lwp"] ."','" .$values[$y]["pre"] ."','" .$values[$y]["pay"] ."',
'" .$values[$y]["ot_time_to_decimal"] ."','" .$values[$y]["annual_leave_balance"] ."','" .date("Y-m-d H:i:s")."','".$_SESSION["user"]["id"]."',
'".$values[$y]['days_mon']."','".$values[$y]['leave_punishment']."','".$values[$y]['day_deduct']."')";

db_query($sql);



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
              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code : </label>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                <input type="text"  list='eip_ids' name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" />
                <datalist id='eip_ids'>
                  <option></option>
                  <?
			foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_CODE," - ",PBI_NAME)',$emp_id,'1');
			?>
                </datalist>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="form-group row m-0 mb-1 pl-3 pr-3">
              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company : </label>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                <select name="PBI_ORG" id="PBI_ORG">
				<option></option>
                  <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="form-group row m-0 mb-1 pl-3 pr-3">
              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Location : </label>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                          <select name="JOB_LOCATION" id="JOB_LOCATION"  class="form-control"  >
                                            <option></option>
                                            <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$JOB_LOCATION);?>
                                          </select>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="form-group row m-0 mb-1 pl-3 pr-3">
              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Month : </label>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                <select name="salary_month"  id="salary_month" required>
                  <option></option>
                  <?=foreign_relation('salary_months','salary_month','salary_month',$_POST['salary_month'],'1 and status="Active"');?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6"> </div>
        </div>
        <div class="n-form-btn-class">
          <input name="upload" type="submit" class="btn1 btn1-bg-submit" id="upload" value="Sync All Data" />
        </div>
      </div>
    </div>
  </div>
</form>
<?







$main_content=ob_get_contents();







ob_end_clean();







require_once SERVER_CORE."routing/layout.bottom.php";







?>
