<?
 

ini_set('memory_limit', '512M');
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="Late Calculation";
do_calander('#m_date');

$mon = date("n",strtotime($_POST['e_date']));
$year = date("Y",strtotime($_POST['e_date']));

//___________FUNCTION FOR OVERTIME CALCULATION _______

function convertMinutesToRoundedHours($totalMinutes) {
    // Round to the nearest 30 minutes
    $roundedMinutes = round($totalMinutes / 30) * 30;

    $hours = floor($roundedMinutes / 60);
    $minutes = $roundedMinutes % 60;

    return sprintf("%02d.%02d", $hours, $minutes);
}


//___________FUNCTION FOR OVERTIME CALCULATION Time To Decimal Format  _______
function convertTimeToDecimal($time) {
    // Split the time into hours and minutes
    list($hours, $minutes) = explode('.', $time);

    // Convert hours and minutes to decimal format
    $decimalHours = $hours + ($minutes / 60);

    // Format the decimal hours to two decimal places
    $formattedDecimalHours = number_format($decimalHours, 2);

    return $formattedDecimalHours;
}



 /* echo "<script>
        $(document).ready(function() {
            // Trigger form submission after 50 seconds
            setTimeout(function() {
                document.getElementById('synchLate').click();
            }, 3600000); // 50 seconds in milliseconds
        });
      </script>"; */
      
      
 



// -------------------------------------- start process for late calculation ----------------------------
if(isset($_POST["upload"])){
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
}else{
$start_date = $year."-".$mon."-".$mon_date->month_start;
$end_date  = $year."-".$mon."-".$total_days_dynamic;

}




$datetime = date('Y-m-d H:i:s');



//$start_date = $_POST['s_date'];



//$end_date = $_POST['e_date'];



$startTime  = strtotime($start_date);



$endTime  = strtotime($end_date);







 $emp_id  = $_POST['emp_id']; // array iy



$PBI_ORG = $_POST['PBI_ORG'];
$job_loc =$_POST['JOB_LOCATION'];




if($_POST['department']>0) $department_con = " and p.DEPT_ID='".$_POST['department']."'";

//$start_date = date('Y-m-d',strtotime($_POST['f_date']));
//$end_date = date('Y-m-d',strtotime($_POST['t_date']));
if($emp_id>0)  $emp_con = " and h.emp_id='".$emp_id."'";
//if($emp_id>0)  $pbi_con = " and p.PBI_ID='".$emp_id."'";
if($PBI_ORG>0) $ORG_con = " and p.PBI_ORG='".$PBI_ORG."'";
if($job_loc>0) $loc_con = " and p.JOB_LOC_ID='".$job_loc."'";
// Recalculate Start and Old Calculation Clean
if($emp_id!=''){
    


$clearSql = "UPDATE hrm_att_summary
SET
dayname = dayname(att_date),
sch_in_time = '',
sch_out_time = '',
sch_off_day = '',
grace_no = '0',
grace_pending_min = '0',
ot_min = '0',
ot_final_min = '0',
ot_final_hour = '0',
holyday = '0',
present='0',
annual_leave='0',
holiday_work='0',
leave_punishment='',
early_min = '0',
final_early_min = '0',
final_early_status = '0',
late_min = '0',
final_late_min = '0',

final_late_status = '0',
final_day_off_status='0',
actual_late_min='0'

WHERE

att_date BETWEEN  '".$start_date."' AND  '".$end_date."' AND emp_id ='".$emp_id."'";



$query=db_query($clearSql);









}











// Holy Day sync for ALL
$holysql = "select holy_day from salary_holy_day where holy_day between '".$start_date."' AND '".$end_date."' ";// Make Status
$holy_query = db_query($holysql);
while($holy_data = mysqli_fetch_object($holy_query)){

$holy_day[$holy_data->holy_day] = $holy_data->holy_day;
//and p.JOB_LOC_ID=".$job_loc."
//$holy_final_sql = "update hrm_att_summary s,personnel_basic_info p  set s.holyday = 1 where p.PBI_ID=s.emp_id  and  s.att_date='".$holy_data->holy_day."'";
//mysql_query($holy_final_sql);

}


//HoliDay Individual 
// Holy Day sync for ALL
$holiday = "select holy_day,PBI_ID from salary_holy_day_individual where holy_day between '".$start_date."' AND '".$end_date."' ";// Make Status
$holi_query = db_query($holiday);
while($holi_data = mysqli_fetch_object($holi_query)){
$holi_day[$holi_data->PBI_ID][$holi_data->holy_day]=$holi_data->PBI_ID;


}
	
	
	
	
	
		
/*$grace_sql ="select * from grace_type";
$grace_query = mysql_query($grace_sql);

while($grace_data=mysql_fetch_object($grace_query)){
	
	$grace_time[$grace_data->ID]=$grace_data->grace_time;
	$grace_days[$grace_data->ID]=$grace_data->total_grace_days;
	$total_grace_time[$grace_data->ID]=$grace_data->total_grace_time;
}
*/





// Schedule Info Fetch All

$sql = 'select * from hrm_schedule_info';
$query  = db_query($sql);

while($data=mysqli_fetch_object($query)){

$sch_start[$data->id] = $data->office_start_time;
$sch_end[$data->id] = $data->office_end_time;
$sch_mid[$data->id] = $data->office_mid_time;
$sch_mid_end[$data->id] = $data->office_mid_time2;
$sch_break[$data->id]=$data->break_time;
$sch_type[$data->id] =$data->sch_type;
$grace_type[$data->id] = $data->grace_type;

$in_grace_time[$data->id] = $data->in_grace_time;
$out_grace_time[$data->id] = $data->grace_time;




}



// Roster Schedule Fetch All
 $sql = "select * from hrm_roster_allocation where roster_date  BETWEEN '".$start_date."' AND '".$end_date."' ";
$query  =db_query($sql);

while($data=mysqli_fetch_object($query)){
$roster_assign[$data->PBI_ID][$data->roster_date] = $data->shedule_1;

}



	



//over_time applicabel

$sql_ot = "select * from salary_info where 1"; // Make Joining
$query_ot  =db_query($sql_ot);

while($data_ot=mysqli_fetch_object($query_ot)){
$ot_applicable[$data_ot->PBI_ID] = $data_ot->overtime_applicable;
$ot_weekend_applicable[$data_ot->PBI_ID] = $data_ot->ot_weekend_applicable;
$ot_holiday_applicable[$data_ot->PBI_ID] = $data_ot->ot_holiday_applicable;
$ot_hour_adjust[$data_ot->PBI_ID] =$data_ot->overtime_hour_adjust;
}





// Main Data Fetch

 $sql = "SELECT h.*,p.define_schedule,p.define_offday,p.punch_type,p.grace_type,p.define_offday2,
p.PBI_DOJ,p.Friday,p.Saturday,p.Sunday,p.Monday,p.Tuesday,p.Wednesday,p.Thursday,p.class
FROM hrm_att_summary h,personnel_basic_info p
WHERE  p.PBI_ID=h.emp_id 
and h.att_date BETWEEN '".$start_date."' AND '".$end_date."'   ".$emp_con.$ORG_con.$loc_con.$department_con."
order by emp_id,att_date";

$query = db_query($sql);
while($data = mysqli_fetch_object($query))

{

$current_date = date('Y-m-d');
$service_length = ceil(abs(strtotime($data->PBI_DOJ) - strtotime($current_date)) / 86400);
$ot_extra[$data->att_date][$data->emp_id] = $data->ot_extra_min;
$data->nextday_att_day = date('Y-m-d',strtotime($data->att_date)+(24*60*60));
$emp_id = $data->emp_id;
$dayName = date('l', strtotime($data->att_date));




// Fetch Sch ID
if($roster_assign[$data->emp_id][$data->att_date]>0) $sch_id[$data->emp_id][$data->att_date] = $roster_assign[$data->emp_id][$data->att_date];
else $sch_id[$data->emp_id][$data->att_date] = $data->define_schedule;




// Fetch Sch Off Day (SCH NO-3)


if($dayName === 'Friday' && $data->Friday === 'Weekend' && $data->manual_day_status!=2){ 
$sch_off_day[$data->emp_id][$data->att_date] = 1;

}elseif($dayName === 'Saturday' && $data->Saturday === 'Weekend' && $data->manual_day_status!=2){ 
$sch_off_day[$data->emp_id][$data->att_date] = 1;

}elseif($dayName === 'Sunday' && $data->Sunday === 'Weekend' && $data->manual_day_status!=2){ 
$sch_off_day[$data->emp_id][$data->att_date] = 1;
}else $sch_off_day[$data->emp_id][$data->att_date] = 0;

//_____________DAY OFF STATUS__ _________
if($dayName === 'Friday' && $data->Friday === 'Day_Off'){
$sch_day_off[$data->emp_id][$data->att_date] = 1;

}elseif($dayName === 'Saturday' && $data->Saturday === 'Day_Off') {
$sch_day_off[$data->emp_id][$data->att_date] = 1;

}elseif($dayName === 'Sunday' && $data->Sunday === 'Day_Off') {
 $sch_day_off[$data->emp_id][$data->att_date] = 1;

} elseif($dayName === 'Monday' && $data->Saturday === 'Day_Off'){ 
$sch_day_off[$data->emp_id][$data->att_date] = 1;

} elseif($dayName === 'Tuesday' && $data->Sunday === 'Day_Off'){
$sch_day_off[$data->emp_id][$data->att_date] = 1;

} elseif($dayName === 'Wednesday' && $data->Saturday === 'Day_Off') { 
$sch_day_off[$data->emp_id][$data->att_date] = 1;

} elseif($dayName === 'Thursday' && $data->Sunday === 'Day_Off') { 
$sch_day_off[$data->emp_id][$data->att_date] = 1;

} else { $sch_day_off[$data->emp_id][$data->att_date] = 0; } 



// Fetch Sch TIME

$data->sch_in_time  = $sch_in_time[$data->emp_id][$data->att_date]  = $sch_start[$sch_id[$data->emp_id][$data->att_date]];
$data->sch_out_time = $sch_out_time[$data->emp_id][$data->att_date] = $sch_end[$sch_id[$data->emp_id][$data->att_date]];
$data->sch_mid_time = $sch_mid_time[$data->emp_id][$data->att_date] = $sch_mid[$sch_id[$data->emp_id][$data->att_date]];
//$data->sch_mid_endTime = $sch_mid_endTime[$data->emp_id][$data->att_date] = $sch_mid_end[$sch_id[$data->emp_id][$data->att_date]];



// UPDATE SCH FOR HALF LEAVE & IOM 
if($data->leave_type == 'Early Half'||$data->iom_type == 'Early Half')
$data->sch_in_time  = $sch_in_time[$data->emp_id][$data->att_date]  = $sch_mid[$sch_id[$data->emp_id][$data->att_date]];

if($data->leave_type == 'Last Half'||$data->iom_type == 'Last Half' || $data->iom_type_early_out == 'Last Half')
$data->sch_out_time = $sch_out_time[$data->emp_id][$data->att_date] = $sch_mid[$sch_id[$data->emp_id][$data->att_date]];


// Fetch SCH FULL DAY TIME
$sch_in_datetime[$data->emp_id][$data->att_date] = $data->att_date.' '.$sch_in_time[$data->emp_id][$data->att_date];
$sch_out_datetime[$data->emp_id][$data->att_date]= $data->att_date.' '.$sch_out_time[$data->emp_id][$data->att_date];


if($data->sch_in_time>$data->sch_out_time) $sch_out_datetime[$data->emp_id][$data->att_date]= $data->nextday_att_day.' '.$sch_out_time[$data->emp_id][$data->att_date];
$sch_ins_datetime[$data->emp_id][$data->att_date] = strtotime($sch_in_datetime[$data->emp_id][$data->att_date]);
$sch_outs_datetime[$data->emp_id][$data->att_date]= strtotime($sch_out_datetime[$data->emp_id][$data->att_date]);


$dayoff_status  = $sch_day_off[$data->emp_id][$data->att_date];

//Holiday Individual sattus
if( ($holi_day[$data->emp_id][$data->att_date] >0 || $holy_day[$data->att_date] >0)){
  $holiday_individual_status   = 1;
}else{
 $holiday_individual_status   = 0;
}



$holyday[$data->emp_id][$data->att_date] = $data->holyday;



// FETCH IN OUT TIME
$ins_datetime[$data->emp_id][$data->att_date]  = strtotime($data->in_time);
$outs_datetime[$data->emp_id][$data->att_date] = strtotime($data->out_time); 

$weekend_status  = $sch_off_day[$data->emp_id][$data->att_date];




if(($ins_datetime[$data->emp_id][$data->att_date] > $sch_ins_datetime[$data->emp_id][$data->att_date])  && ($data->iom_type !='Full') 
&& ($data->leave_id ==0) && ($weekend_status==0) && ($data->holyday==0) && ( $holiday_individual_status ==0))
{

//$late_min = round(abs($ins_datetime[$data->emp_id][$data->att_date] - $sch_ins_datetime[$data->emp_id][$data->att_date]) / 60,2)+2;
  $late_min = (int)(($ins_datetime[$data->emp_id][$data->att_date] - $sch_ins_datetime[$data->emp_id][$data->att_date]) / 60);

}

else {$late_min = 0 ; }


//_______________ EARLY OUT STATUS _______________
/*if(

($sch_outs_datetime[$data->emp_id][$data->att_date] > $outs_datetime[$data->emp_id][$data->att_date]) && 
($sch_off_day[$data->emp_id][$data->att_date] == 0) && 
($ins_datetime[$data->emp_id][$data->att_date]>0)) {

    if(($outs_datetime[$data->emp_id][$data->att_date]>0)){
	
    $early_min = (int)(($sch_outs_datetime[$data->emp_id][$data->att_date] - $outs_datetime[$data->emp_id][$data->att_date]) / 60);
     }else{
	$early_min = (int)(($sch_outs_datetime[$data->emp_id][$data->att_date] - $ins_datetime[$data->emp_id][$data->att_date]) / 60);
	 }


}else{
$early_min = 0;
}

*/

//$schIntDatetime = $sch_ins_datetime[$data->emp_id][$data->att_date];

//________ Qutar Leave Min _____
if($data->leave_type == 'first_qtr' || $data->leave_type == 'second_qtr' || $data->leave_type == 'fourth_qtr' || $data->leave_type == 'third_qtr'){
$tot_QutarLeave_Min = 120;

}else{
$tot_QutarLeave_Min = 0;

}

//________ END Qutar Leave Min _____

$sch_break_start  = $data->sch_mid_time;
$sch_break_end =  $sch_mid_end[$data->sch_id];

$schOutDatetime = $sch_outs_datetime[$data->emp_id][$data->att_date];
$schInDatetime = $sch_ins_datetime[$data->emp_id][$data->att_date];

$outsDatetime = $outs_datetime[$data->emp_id][$data->att_date];
$insDatetime = $ins_datetime[$data->emp_id][$data->att_date];
$schOffDay = $sch_off_day[$data->emp_id][$data->att_date];

//_______________BREAK TIME _____________
$system_OutTimeOnly = (new DateTime($data->out_time))->format('H:i');  

if($system_OutTimeOnly === '00:00' || $system_OutTimeOnly>$sch_break_end ){
$mid_break_min = (strtotime($sch_break_end) - strtotime($sch_break_start)) / 60;
}else{
$mid_break_min = 0;
}


if ($system_OutTimeOnly>0 && $system_OutTimeOnly >= $sch_break_start && $system_OutTimeOnly <= $sch_break_end) {
    $with_punch_mid_break_min = (strtotime($sch_break_end)- strtotime($system_OutTimeOnly)) / 60;
} else {
    $with_punch_mid_break_min = 0;
}



//_______________ EARLY OUT MIN  _______________
if ($schOutDatetime > $outsDatetime && $schOffDay == 0 && $insDatetime > 0 && $data->holyday==0) {
    if ($outsDatetime > 0) {
	
         $tot_early_min_in = (int)(($schOutDatetime - ($outsDatetime)) / 60);
		 
		 $early_min = ($tot_early_min_in-($with_punch_mid_break_min+$tot_QutarLeave_Min)) ;
		 
    } else {
	
	    $baseTime = ($insDatetime > $schInDatetime) ? $insDatetime : $schInDatetime;
        $tot_early_min = (int)(($schOutDatetime - $baseTime) / 60);
        $early_min = $tot_early_min - ($mid_break_min + $tot_QutarLeave_Min);
		
	 
    }
	
	
} else {
    $early_min = 0;
}


//__________________ Total working hours Calculation Part & Basic Overtime calculation For All / Extra duty ____________

$net_working_min  = (int)(($outsDatetime - ($insDatetime )) / 60);
$total_working_min  = ($net_working_min-($mid_break_min+$tot_QutarLeave_Min));
$tot_working_hours  = convertMinutesToRoundedHours($total_working_min);

if($total_working_min >0 && $total_working_min < 1440  ){
$working_hours  = $tot_working_hours;
}else{
$working_hours  = 0;
}



if( ($outs_datetime[$data->emp_id][$data->att_date]>0) && ($outs_datetime[$data->emp_id][$data->att_date]> $sch_outs_datetime[$data->emp_id][$data->att_date])  ){    
    
$basic_ot_min = (int)(($outs_datetime[$data->emp_id][$data->att_date] - $sch_outs_datetime[$data->emp_id][$data->att_date]) / 60);
	 
if($basic_ot_min>0){

		if($basic_ot_min >= 30 ){
		$basic_ot_min = $basic_ot_min-14;
		}
		
		$basic_ot_final_min =$basic_ot_min;
		if($basic_ot_final_min>30){
		$basic_ot_f_min = $basic_ot_final_min; //($ot_final_min / 60); //($ot_final_min%60);
		}else {
		
		 $basic_ot_f_min=0; 
		
			}
      
	   $basic_totalMinutes =   $basic_ot_f_min;
       $basic_ot_for_all_hours = convertMinutesToRoundedHours($basic_totalMinutes);
	   $basic_ot_for_all =  convertTimeToDecimal($basic_ot_for_all_hours);

  } else {

	$basic_ot_min=0;
  	$basic_ot_final_min=0;
  	

	} 
	

}else {

$basic_ot_for_all = 0;
}



// $basic_ot_min = (int)(($outs_datetime[$data->emp_id][$data->att_date] - $sch_outs_datetime[$data->emp_id][$data->att_date]) / 60);
// $basic_ot_for_all_hours =  convertMinutesToRoundedHours($basic_ot_min);

// if($basic_ot_for_all_hours >0){
// $basic_ot_for_all =  convertTimeToDecimal($basic_ot_for_all_hours);
// }else{
// $basic_ot_for_all = 0;
// }

//__________________ END Total working hours Calculation Part & Basic Overtime calculation For All / Extra duty ____________

//if($late_min>$grace_time[$data->grace_type]) $final_late_status = 1;
//else $final_late_status = 0;


//_________________GRACE CALCULATION
$grace_pending_min =  $in_grace_time[$data->sch_id];
$manual_in_grace = $data->manual_in_grace;
$grace_out_min =  $out_grace_time[$data->sch_id];

$initialLateMinutes  = $late_min;
$initialEarlyMinutes = $early_min;

//_________________ IN LATE ______________
$graceSeconds = strtotime("1970-01-01 $grace_pending_min UTC")+strtotime("1970-01-01 $manual_in_grace UTC");
if($initialLateMinutes>0) // Late Day

{

		if($initialLateMinutes <=$grace_pending_min) // if Late min less than Daily gress Limit
			{
			$final_late_min = 0; $final_late_status = 0; //$grace_pending_min = $graceSeconds - ($initialLateSeconds); // Best Case
			
			
			}
		else
			{
			

			// Calculate final late minute by subtracting grace time in seconds
			 $final_late_min = max(0, $initialLateMinutes - ($graceSeconds/ 60)); $final_late_status = 1;
			

			}
			
						
						
	}else{
    $final_late_min = 0;
    $final_late_status = 0;
    $grace = 0;
}




//_____________ Early Out ________
$graceOutSeconds = strtotime("1970-01-01 $grace_out_min UTC");
if($initialEarlyMinutes>0) // Late Day
{
   if($initialEarlyMinutes <=$graceOutSeconds) 
	     {
		   $early_min = 0; 
		   $final_early_status = 0; 
		    }
		else
			{
			
         $final_early_min = max(0, $initialEarlyMinutes - ($graceOutSeconds/ 60)); 
         $final_early_status = 1;
			
			}
			
	}else{
    $final_early_min = 0;
    $final_early_status = 0;
   
}

//_____________ Early out End ________________

//_______ Actual_late_min Calculation _____
if($final_late_min>0 && $final_late_status>0){
$actual_late_min = $late_min;
}else{

$actual_late_min = 0;
}





if($final_late_min==0){$final_late_status = 0;}
if($final_early_min==0){$final_early_status = 0;}

					

if($data->leave_type == 'Full'||$data->iom_type == 'Full'){
$final_early_status = 0;
$final_late_status = 0;
$final_early_min = 0;
$final_late_min=0;

}

if($data->iom_type == 'Last Half' || $data->leave_type == 'Last Half' || $data->iom_type_early_out == 'Last Half'){
$final_early_status = 0;
$final_early_min = 0;
}

if($data->iom_type == 'Early Half' || $data->leave_type == 'Early Half'){
$final_late_status = 0;
$final_late_min = 0;
$actual_late_min =0;

}


// RECHECK??
if( ($ins_datetime[$data->emp_id][$data->att_date]>0) || ($outs_datetime[$data->emp_id][$data->att_date]>0) || ($sch_off_day[$data->emp_id][$data->att_date]==1) || ($data->leave_id>0) || ($data->iom_id>0) || ($data->punch_type !='Regular') ){
$present=1;
}else{
$present=0;
}


 $delay = ($final_late_min+$final_early_min); // 15 minutes delay

// Force Absent ??
//( ($ins_datetime[$data->emp_id][$data->att_date]>0) || ($outs_datetime[$data->emp_id][$data->att_date]>0) ) 


if ( $data->class == 3 &&  ( $delay>240 || $data->force_absent > 0 ) ) {
$present=0;
}


	  
	  

// RECHECK??
if(($ins_datetime[$data->emp_id][$data->att_date]>0 || $outs_datetime[$data->emp_id][$data->att_date]>0) && ($data->holyday>0)){
$holiday_work=1;
}else{
$holiday_work=0;
}


if( ($ins_datetime[$data->emp_id][$data->att_date]>0) && ($data->leave_id==0) && ($data->iom_id==0) && ($service_length>365) && ($data->holyday==0) && ($data->final_late_status==0) &&
 ($data->final_early_status==0) && ($data->sch_off_day==0) ){
$annual_leave=1;
}else{
$annual_leave=0;
}

//_______FINAL DAY OFF __
if($dayoff_status>0 || $data->manual_day_status==1){
$present=0;
$actual_late_min = 0;
$final_early_status = 0;
$final_late_status = 0;
$final_early_min = 0;
$final_late_min==0;

}

//__________Day Off status values show in summary
if(($dayoff_status>0 || $data->manual_day_status==1) && ($holiday_individual_status==0)){
$final_day_off_status=1;
}else{
$final_day_off_status=0;
}



//_________________ Final Absent Signal ______________________
if( ($final_day_off_status>0) || ($present>0) || ($holiday_individual_status>0) || ($data->leave_id>0) || ($data->iom_id>0) || ($data->holyday>0) ) {
$final_absent_status = 0;
}else{
$final_absent_status = 1;
}       



// ______________ -----  Overtime Calculation  ----  ________________
if(($ot_applicable[$data->emp_id]=='YES' || $ot_holiday_applicable[$data->emp_id]=='YES' || $ot_weekend_applicable[$data->emp_id]=='YES') && 
$data->leave_type != 'Last Half' &&  $data->iom_type!='Last Half' ) {	


if(($ot_applicable[$data->emp_id]=='YES') && ($outs_datetime[$data->emp_id][$data->att_date]>0) && 
($sch_off_day[$data->emp_id][$data->att_date] == 0) && ($holiday_individual_status==0)){
$ot_min = (int)(($outs_datetime[$data->emp_id][$data->att_date] - $sch_outs_datetime[$data->emp_id][$data->att_date]) / 60);
	 
if($ot_min>0){
if($ot_min >= 30 ){
$ot_min = $ot_min-14;
}

$ot_final_min =$ot_min;
if($ot_final_min>30){

$ot_hour = (int)($ot_final_min/60);
$ot_f_min = $ot_final_min; //($ot_final_min / 60); //($ot_final_min%60);
}else {

	$ot_hour=0;

	$ot_f_min=0; //$ot_final_min;

	}
      $totalMinutes =   $ot_f_min;
     //$ot_f_min =($ot_final_min%60);
      $ot_final_hour = convertMinutesToRoundedHours($totalMinutes); //round($ot_f_min);  
     $ot_final_status=1;

     

	}



	else {

	$ot_min=0;
  	$ot_final_min=0;
  	$ot_final_hour = 0;
  	$ot_final_status=0;

	}



//_____________ ----  Overtime For Holiday ------ ___________



} elseif(($ot_holiday_applicable[$data->emp_id]=='YES') && ($outs_datetime[$data->emp_id][$data->att_date]>0) && ($holiday_individual_status==1)){

$ot_min = (int)(($outs_datetime[$data->emp_id][$data->att_date] - $ins_datetime[$data->emp_id][$data->att_date]) / 60);

if($ot_min>0){
if($ot_min >= 30 ){
$ot_min = $ot_min-14;
}
$ot_final_min = ($ot_min-$mid_break_min);
$ot_final_hour = convertMinutesToRoundedHours($ot_final_min);
$ot_final_status=1;

}

else {


$ot_min=0;
$ot_final_min=0;
$ot_final_hour = 0;
$ot_final_status=0;
}


//_____________ ----  Overtime For Weekend ------ ___________

} elseif(($ot_weekend_applicable[$data->emp_id]=='YES') && ($outs_datetime[$data->emp_id][$data->att_date]>0) && ($sch_off_day[$data->emp_id][$data->att_date]==1)){

$ot_min = (int)(($outs_datetime[$data->emp_id][$data->att_date] - $ins_datetime[$data->emp_id][$data->att_date]) / 60);
if($ot_min>0){
if($ot_min >= 30 ){
$ot_min = $ot_min-14;
}
$ot_final_min = ($ot_min-$mid_break_min);
$ot_final_hour = convertMinutesToRoundedHours($ot_final_min);
$ot_final_status=1;

}

else {


$ot_min=0;
$ot_final_min=0;
$ot_final_hour = 0;
$ot_final_status=0;
}




	
//_____________ ----  Overtime For Holiday ------ ___________

}  else {


$ot_min=0;
$ot_final_min=0;
$ot_final_hour = 0;
$ot_final_status=0;
}


//____________________


} else {

$ot_min=0;
$ot_final_min=0;
$ot_final_hour = 0;
$ot_final_status=0;



}


// Overtime time to deciaml format 

$ot_time_to_decimal = convertTimeToDecimal($ot_final_hour);



 $update_sql = "update hrm_att_summary 



set 



sch_off_day = '".$sch_off_day[$data->emp_id][$data->att_date]."',sch_id = '".$sch_id[$data->emp_id][$data->att_date]."',
sch_in_time = '".$sch_in_time[$data->emp_id][$data->att_date]."',sch_out_time = '".$sch_out_time[$data->emp_id][$data->att_date]."',
sch_mid_time = '".$sch_mid_time[$data->emp_id][$data->att_date]."',

late_min='".$late_min."', final_late_min='".$final_late_min."', final_late_status='".$final_late_status."', early_min='".$early_min."', 
final_early_min='".$final_early_min."', final_early_status='".$final_early_status."' ,
ot_time_to_decimal='".$ot_time_to_decimal."', absent='".$final_absent_status."' , 
ot_min='".$ot_min."', ot_final_min='".$ot_final_min."',ot_final_hour='".$ot_final_hour."' , ot_final_hour='".$ot_final_hour."' ,

ot_final_status='".$ot_final_status."', holyday='".$holiday_individual_status."', working_hours='".$working_hours."' , basic_ot_for_all='".$basic_ot_for_all."' ,  

grace_no='".$grace."',grace_pending_min='".$grace_pending_min."', actual_late_min='".$actual_late_min."' ,

process_time='".$datetime."',present='".$present."', holiday_work='".$holiday_work."' , annual_leave='".$annual_leave."' ,

leave_punishment='".$leave_punishment."' , final_day_off_status = '".$final_day_off_status."' 



where id=".$data->id;

db_query($update_sql);

//mysql_query($update_sql);

$old_emp_id = $data->emp_id;

 }


echo ' Process Complete! OK.';

}







?>




<script>
/*    $(document).ready(function() {
        // Function to check and trigger form submission
        function checkAndSubmit() {
            var shouldReload = localStorage.getItem('reloadFlag');

            if (shouldReload) {
                // Trigger form submission
                document.getElementById('synchLate').click();

                // Clear the reload flag to avoid triggering on subsequent page loads
                localStorage.removeItem('reloadFlag');
            }
        }

        // Check and submit on page load
        checkAndSubmit();

        // Set the reload flag to true (will persist across pages) every 1 minute
        setInterval(function() {
            localStorage.setItem('reloadFlag', 'true');
        }, 60000); // 1 minute = 60 seconds * 1000 milliseconds

        // Check and submit when the window gains focus
        $(window).on('focus', function() {
            checkAndSubmit();
        });
    });*/
</script>



<style type="text/css">







<!--







.style1 {font-size: 24px}







-->







</style>
<form action=""  method="post" enctype="multipart/form-data">
  <div class="d-flex justify-content-center">
    <div class="n-form1 fo-width pt-0">
      <h4 class="text-center bg-titel bold pt-2 pb-2">Late Calculation Process</h4>
      <div class="container-fluid p-0">
        <div class="row">
          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="form-group row  m-0 mb-1 pl-3 pr-3">
              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code : </label>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                <input type="text"  list='eip_ids' name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" autocomplete="off" />
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
                <select name="select" id="select">
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
            <div class="form-group row m-0 mb-1 pl-3 pr-3">
              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department : </label>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                <select name="department"  class="form-control" id="department">
                  <option></option>
                  <? foreign_relation('department','DEPT_ID','DEPT_DESC',$department,' 1 order by DEPT_DESC');?>
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
        </div>
        <div class="n-form-btn-class">
          <input name="upload" class="btn1 btn1-bg-submit" type="submit"  id="synchLate" value="Sync All Data" />
        </div>
      </div>
    </div>
  </div>
</form>

<tr>
 




<script>
  // Get current date
  var currentDate = new Date();

  // Get current year and month
  var currentYear = currentDate.getFullYear();
  var currentMonth = ('0' + (currentDate.getMonth() + 1)).slice(-2);

  // Create the current year and month string in the format "YYYY-MM"
  var currentYearMonth = currentYear + '-' + currentMonth;

  // Set the selected attribute for the option with the current year and month value
  document.getElementById('salary_month').value = currentYearMonth;
</script>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
