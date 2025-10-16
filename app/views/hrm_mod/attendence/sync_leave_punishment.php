<?

ini_set('memory_limit', '512M');
session_start();
//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="Late Calculation";
do_calander('#m_date');
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

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






// -------------------------------------- start process for late calculation ----------------------------
if(isset($_POST["upload"])){
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
}else{
$start_date = $year."-".$mon."-".$mon_date->month_start;
$end_date  = $year."-".$mon."-".$mon_date->month_end;

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


// Holy Day sync for ALL
$holysql = "select holy_day from salary_holy_day where holy_day between '".$start_date."' AND '".$end_date."' ";// Make Status
$holy_query = db_query($holysql);
while($holy_data = mysqli_fetch_object($holy_query)){

$holy_day[$holy_data->holy_day]=1;
//and p.JOB_LOC_ID=".$job_loc."
 $holy_final_sql = "update hrm_att_summary s,personnel_basic_info p  set s.holyday = 1 where p.PBI_ID=s.emp_id  and  s.att_date='".$holy_data->holy_day."'";// Make Status
db_query($holy_final_sql);

}
	
	
	
	
// Schedule Info Fetch All

$sql = 'select * from hrm_schedule_info';
$query  =db_query($sql);

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

echo $sql = "SELECT h.*,p.define_schedule,p.define_offday,p.punch_type,p.grace_type,p.PBI_DOJ,p.JOB_LOC_ID,p.class,
p.Friday,p.Saturday,p.Sunday,p.Monday,p.Tuesday,p.Wednesday,p.Thursday
FROM hrm_att_summary h,personnel_basic_info p
WHERE  p.PBI_ID=h.emp_id and p.class!=3 and 
h.att_date BETWEEN '".$start_date."' AND '".$end_date."'   ".$emp_con.$ORG_con.$loc_con.$department_con."
order by emp_id,att_date";

$query = db_query($sql);
while($data = mysqli_fetch_object($query))

{

$current_date = date('Y-m-d');
$service_length = ceil(abs(strtotime($data->PBI_DOJ) - strtotime($current_date)) / 86400);
$ot_extra[$data->att_date][$data->emp_id]=$data->ot_extra_min;
$data->nextday_att_day = date('Y-m-d',strtotime($data->att_date)+(24*60*60));
$emp_id = $data->emp_id;
$dayName = date('l', strtotime($data->att_date));
$off_day_status = $data->sch_off_day;

// Fetch Sch ID
if($roster_assign[$data->emp_id][$data->att_date]>0) $sch_id[$data->emp_id][$data->att_date] = $roster_assign[$data->emp_id][$data->att_date];
else $sch_id[$data->emp_id][$data->att_date] = $data->define_schedule;




// Fetch Sch Off Day (SCH NO-3)
if( $sch_type[$roster_assign[$data->emp_id][$data->att_date]]=="offday")
{ $sch_off_day[$data->emp_id][$data->att_date] = 1;}

elseif($dayName === 'Friday' && $data->Friday === 'Weekend') 
$sch_off_day[$data->emp_id][$data->att_date] = 1;

elseif($dayName === 'Saturday' && $data->Saturday === 'Weekend') 
$sch_off_day[$data->emp_id][$data->att_date] = 1;

elseif($dayName === 'Sunday' && $data->Sunday === 'Weekend') 
$sch_off_day[$data->emp_id][$data->att_date] = 1;


else $sch_off_day[$data->emp_id][$data->att_date] = 0;

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


 $holyday[$data->emp_id][$data->att_date] = $data->holyday;

// FETCH IN OUT TIME
$ins_datetime[$data->emp_id][$data->att_date]  = strtotime($data->in_time);
$outs_datetime[$data->emp_id][$data->att_date] = strtotime($data->out_time); 

$weekend_status  = $sch_off_day[$data->emp_id][$data->att_date];
$dayoff_status  = $sch_day_off[$data->emp_id][$data->att_date];

if(($ins_datetime[$data->emp_id][$data->att_date] > $sch_ins_datetime[$data->emp_id][$data->att_date])  && ($data->iom_type !='Full') 
&& ($data->leave_id ==0) && ($weekend_status==0) && ($data->holyday==0))
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
		   $early_min = 0; $final_early_status = 0; 
		    }
		else
			{
			
         $final_early_min = max(0, $initialEarlyMinutes - ($graceOutSeconds/ 60)); $final_early_status = 1;
			
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





//_____________ LATE punishment Start  _______
$g_s_date = date($year . '-01-01');
$g_e_date = date($year . '-12-31');


$joiningdate = find_a_field('personnel_basic_info', 'PBI_DOJ', 'PBI_ID=' . $emp_id);

$g_e_datee = date('Y-m-d');
$start = strtotime($joiningdate);
$end = strtotime($g_e_datee);
$days_between_pre = ceil(abs($start - $end) / 86400);
$joiningYear = date('Y', strtotime($joiningdate));
$currentYear = date('Y');


$annual_leave_opening = find_a_field('annual_leave_balance', 'BALANCE', 'PBI_ID="' .$emp_id. '"');
$annual_leave_earn = find_a_field('hrm_att_summary', 'sum(annual_leave)', 'emp_id="' . $emp_id. '" and att_date BETWEEN  "' . $g_s_date . '" 
 and "' . $g_e_date . '" ');

$final_annual_earn = ($annual_leave_earn / 18);
$total_annual_allocated = ($annual_leave_opening+$final_annual_earn);







 $delay = ($actual_late_min+$final_early_min); // 15 minutes delay


	if ($joiningYear < $currentYear && $days_between_pre >= 365) {
      
	  $cl_entitlement =10;
      $al_entitlement = $total_annual_allocated; 
    
	  
   }elseif($joiningYear < $currentYear && $days_between_pre < 365){
	   $cl_entitlement =10;
       $al_entitlement = 0;
		
    } else {

       $cl_entitlement =10;
       $al_entitlement = 0;
     
    }
	
	


$al_availd = find_a_field('hrm_leave_info','sum(total_days)','type=3 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  
and PBI_ID='.$emp_id);

$cl_availd = find_a_field('hrm_leave_info','sum(total_days)','type=1 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"  
 and PBI_ID='.$emp_id);


$al_balance = ($al_entitlement-$al_availd);
$cl_balance = ($cl_entitlement-$cl_availd);


// Convert minutes to hours for simplicity
$delay_hours = $delay / 60;



//if( $data->JOB_LOC_ID == 3 && $final_early_status>0 || $final_late_status>0 )

//($al_balance > 0 || $cl_balance > 0) && 

if ($data->class!=3 && ($data->sch_off_day==0) && ($data->holyday==0) && ($final_early_status > 0 || $final_late_status > 0) )


      {
     
     
         if($delay_hours >0 && $delay_hours <= 0.1667){
             
            	$leave_punishment =  "";
				$leave_punishment_status = 0;
				$actual_late_min = 0;
				$final_late_status = 0;
				$final_early_status = 0;
				$final_early_min = 0; 
             
             
         }elseif ($delay_hours > 0.1667 && $delay_hours <= 2) {
    	


			if ($al_balance > 0) {
				
				$leave_punishment =  "Qtr Leave Punishment";
				$leave_punishment_status = 1;
				$actual_late_min = 0;
				$final_late_status = 0;
				$final_early_status = 0;
				$final_early_min = 0;
				
				 $al_query = "INSERT INTO hrm_leave_info( leave_apply_date , incharge_status , half_or_full , PBI_ID, type, s_date,e_date,total_days,reason,
				 leave_status,leave_punishment_status)
				  
				VALUES ('".$data->att_date."', 'Approve' , 'first_qtr' ,   '" .$data->emp_id."', 3 , '" .$data->att_date. "' , '" .$data->att_date. "' ,'0.25', 
				'Leave Punishment', 'GRANTED' , 1)";
				$result = db_query($al_query);


         /* $full_leave = find_all_field('hrm_leave_info','','PBI_ID="'.$data->emp_id.'" and leave_apply_date="'.$data->att_date.'" 
		  and type=3 and s_date="'.$data->att_date.'" and  e_date="'.$data->att_date.'" and total_days="0.20"');*/
		  
		  $_GET['leave_id'] =  mysqli_insert_id();
          $full_leave = find_all_field('hrm_leave_info', '', 'id=' . $_GET['leave_id']);
		  
		  $up_query = "update hrm_att_summary set leave_id='" . $full_leave->id . "', leave_type='" . $full_leave->half_or_full . "',
          leave_reason='" . $full_leave->reason . "',leave_duration='" . $full_leave->total_days. "', leave_approved_by='" . $_SESSION['user']['id'] . "',
          leave_entry_at='" . $full_leave->entry_at . "', leave_entry_by='" . $full_leave->PBI_ID . "' where id=" . $data->id;
          $result_new = db_query($up_query);
				  
		
				 
			} elseif ($cl_balance > 0) {
				$leave_punishment =  "Qtr Leave Punishment";
				$leave_punishment_status = 1;
				$actual_late_min = 0;
				$final_late_status = 0;
				$final_early_status = 0;
				$final_early_min = 0;
				
			 $cl_query = "INSERT INTO hrm_leave_info( leave_apply_date , incharge_status,half_or_full , PBI_ID, type, s_date,e_date,total_days,reason,
				 leave_status,leave_punishment_status)
				  
				VALUES ('".$data->att_date."','Approve', 'first_qtr','" .$data->emp_id."',1, '" .$data->att_date. "' , '" .$data->att_date. "' ,'0.25', 
				'Leave Punishment', 'GRANTED' , 1)";
				$result = db_query($cl_query);
				
				
		  $_GET['leave_id'] =  mysqli_insert_id();
          $full_leave = find_all_field('hrm_leave_info', '', 'id=' . $_GET['leave_id']);

          $up_query = "update hrm_att_summary set leave_id='" . $full_leave->id . "', leave_type='" . $full_leave->half_or_full . "',
          leave_reason='" . $full_leave->reason . "',leave_duration='" .$full_leave->total_days. "', leave_approved_by='" . $_SESSION['user']['id'] . "',
          leave_entry_at='" . $full_leave->entry_at . "', leave_entry_by='" . $full_leave->PBI_ID . "' where id=" . $data->id;
          $result_new = db_query($up_query);
				
				
				
				
			} else {
			  
				$leave_punishment =  "2 hours gross_salary deduction.";
				$leave_punishment_status = 0;
				
				
				
			}
	
	
    } elseif ($delay_hours > 2 && $delay_hours <= 4) {
 
			if ($al_balance > 0) {
			
				$leave_punishment = "Half Leave Punishment";
				$leave_punishment_status = 1;
				$actual_late_min = 0;
				$final_late_status = 0;
				$final_early_status = 0;
				$final_early_min = 0;
				
				$al_four_hr_query = "INSERT INTO hrm_leave_info( leave_apply_date , incharge_status, half_or_full , PBI_ID, type, s_date,e_date,total_days,reason,
				 leave_status,leave_punishment_status)
				  
				VALUES ('".$data->att_date."','Approve', 'Last Half' ,'" .$data->emp_id."',3, '" .$data->att_date. "' , '" .$data->att_date. "' ,'0.50', 
				'Leave Punishment', 'GRANTED' , 1)";
				$result = db_query($al_four_hr_query);
			
			//_________ Leave Deduct From HRM SUMMARY __________	
		  $_GET['leave_id'] =  mysqli_insert_id();
          $full_leave = find_all_field('hrm_leave_info', '', 'id=' . $_GET['leave_id']);
		  
		  $up_query = "update hrm_att_summary set leave_id='" . $full_leave->id . "', leave_type='" . $full_leave->half_or_full . "',
          leave_reason='" . $full_leave->reason . "',leave_duration='" . $full_leave->total_days. "', leave_approved_by='" . $_SESSION['user']['id'] . "',
          leave_entry_at='" . $full_leave->entry_at . "', leave_entry_by='" . $full_leave->PBI_ID . "' where id=" . $data->id;
          $result_new = db_query($up_query);
				
				
			} elseif ($cl_balance > 0) {
				$leave_punishment = "Half Leave Punishment";
				$leave_punishment_status = 1;
				$actual_late_min = 0;
				$final_late_status = 0;
				$final_early_status = 0;
				$final_early_min = 0;
				
				$cl_four_hr_query = "INSERT INTO hrm_leave_info( leave_apply_date , incharge_status , half_or_full , PBI_ID, type, s_date,e_date,total_days,reason,
				 leave_status,leave_punishment_status)
				  
				VALUES ('".$data->att_date."','Approve', 'Last Half' ,'" .$data->emp_id."',1, '" .$data->att_date. "' , '" .$data->att_date. "' ,'0.50', 
				'Leave Punishment', 'GRANTED' , 1)";
				$result = db_query($cl_four_hr_query);
				
				
					//_________ Leave Deduct From HRM SUMMARY __________	
		  $_GET['leave_id'] =  mysqli_insert_id();
          $full_leave = find_all_field('hrm_leave_info', '', 'id=' . $_GET['leave_id']);
		  
		  $up_query = "update hrm_att_summary set leave_id='" . $full_leave->id . "', leave_type='" . $full_leave->half_or_full . "',
          leave_reason='" . $full_leave->reason . "',leave_duration='" . $full_leave->total_days. "', leave_approved_by='" . $_SESSION['user']['id'] . "',
          leave_entry_at='" . $full_leave->entry_at . "', leave_entry_by='" . $full_leave->PBI_ID . "' where id=" . $data->id;
          $result_new = db_query($up_query);
		  
				
			} else {
			 
				$leave_punishment =  "4 hours gross_salary deduction.";
				$leave_punishment_status = 0;
			}
	
	
}  elseif ($delay_hours > 4  &&  $system_OutTimeOnly >= $sch_break_start) {
 
			if ($al_balance > 0) {
			
				$leave_punishment = "Half Leave Punishment";
				$leave_punishment_status = 1;
				$actual_late_min = 0;
				$final_late_status = 0;
				$final_early_status = 0;
				$final_early_min = 0;
				
				$al_four_hr_query = "INSERT INTO hrm_leave_info( leave_apply_date , incharge_status, half_or_full , PBI_ID, type, s_date,e_date,total_days,reason,
				 leave_status,leave_punishment_status)
				  
				VALUES ('".$data->att_date."','Approve', 'Last Half' ,'" .$data->emp_id."',3, '" .$data->att_date. "' , '" .$data->att_date. "' ,'0.50', 
				'Leave Punishment', 'GRANTED' , 1)";
				$result = db_query($al_four_hr_query);
			
			//_________ Leave Deduct From HRM SUMMARY __________	
		  $_GET['leave_id'] =  mysqli_insert_id();
          $full_leave = find_all_field('hrm_leave_info', '', 'id=' . $_GET['leave_id']);
		  
		  $up_query = "update hrm_att_summary set leave_id='" . $full_leave->id . "', leave_type='" . $full_leave->half_or_full . "',
          leave_reason='" . $full_leave->reason . "',leave_duration='" . $full_leave->total_days. "', leave_approved_by='" . $_SESSION['user']['id'] . "',
          leave_entry_at='" . $full_leave->entry_at . "', leave_entry_by='" . $full_leave->PBI_ID . "' where id=" . $data->id;
          $result_new = db_query($up_query);
				
				
			} elseif ($cl_balance > 0) {
				$leave_punishment = "Half Leave Punishment";
				$leave_punishment_status = 1;
				$actual_late_min = 0;
				$final_late_status = 0;
				$final_early_status = 0;
				$final_early_min = 0;
				
				$cl_four_hr_query = "INSERT INTO hrm_leave_info( leave_apply_date , incharge_status , half_or_full , PBI_ID, type, s_date,e_date,total_days,reason,
				 leave_status,leave_punishment_status)
				  
				VALUES ('".$data->att_date."','Approve', 'Last Half' ,'" .$data->emp_id."',1, '" .$data->att_date. "' , '" .$data->att_date. "' ,'0.50', 
				'Leave Punishment', 'GRANTED' , 1)";
				$result = db_query($cl_four_hr_query);
				
				
					//_________ Leave Deduct From HRM SUMMARY __________	
		  $_GET['leave_id'] =  mysqli_insert_id();
          $full_leave = find_all_field('hrm_leave_info', '', 'id=' . $_GET['leave_id']);
		  
		  $up_query = "update hrm_att_summary set leave_id='" . $full_leave->id . "', leave_type='" . $full_leave->half_or_full . "',
          leave_reason='" . $full_leave->reason . "',leave_duration='" . $full_leave->total_days. "', leave_approved_by='" . $_SESSION['user']['id'] . "',
          leave_entry_at='" . $full_leave->entry_at . "', leave_entry_by='" . $full_leave->PBI_ID . "' where id=" . $data->id;
          $result_new = db_query($up_query);
		  
				
			} else {
			 
				$leave_punishment =  "4 hours gross_salary deduction.";
				$leave_punishment_status = 0;
			}
	
	
}  elseif ($delay_hours > 4   ) {

   
   
    if ($al_balance > 0) {
	
        $leave_punishment = "Full Leave Punishment";
		$leave_punishment_status = 1;
		$actual_late_min = 0;
		$final_late_status = 0;
		$final_early_status = 0;
        $final_early_min = 0;
		
		$al_full_day_query = "INSERT INTO hrm_leave_info( leave_apply_date , incharge_status, half_or_full  , PBI_ID, type, s_date,e_date,total_days,reason,
		 leave_status,leave_punishment_status)
		  
		VALUES ('".$data->att_date."','Approve', 'Full' , '" .$data->emp_id."',3, '" .$data->att_date. "' , '" .$data->att_date. "'  ,'1', 
		'Leave Punishment', 'GRANTED' , 1)";
		$result = db_query($al_full_day_query);
		
		
			//_________ Leave Deduct From HRM SUMMARY __________	
		  $_GET['leave_id'] =  mysqli_insert_id();
          $full_leave = find_all_field('hrm_leave_info', '', 'id=' . $_GET['leave_id']);
		  
		  $up_query = "update hrm_att_summary set leave_id='" . $full_leave->id . "', leave_type='" . $full_leave->half_or_full . "',
          leave_reason='" . $full_leave->reason . "',leave_duration='" . $full_leave->total_days. "', leave_approved_by='" . $_SESSION['user']['id'] . "',
          leave_entry_at='" . $full_leave->entry_at . "', leave_entry_by='" . $full_leave->PBI_ID . "' where id=" . $data->id;
          $result_new = db_query($up_query);
		
		
		
    } elseif ($cl_balance > 0) {
	
        $leave_punishment = "Full Leave Punishment";
		$leave_punishment_status = 1;
		$actual_late_min = 0;
		$final_late_status = 0;
		$final_early_status = 0;
        $final_early_min = 0;
		
		$cl_full_day_query = "INSERT INTO hrm_leave_info( leave_apply_date , incharge_status , half_or_full , PBI_ID, type, s_date,e_date,total_days,reason,
		 leave_status,leave_punishment_status)
		  
		VALUES ('".$data->att_date."','Approve', 'Full' , '" .$data->emp_id."',1, '" .$data->att_date. "' , '" .$data->att_date. "' ,'1', 
		'Leave Punishment', 'GRANTED' , 1)";
		$result = db_query($cl_full_day_query);
		
			//_________ Leave Deduct From HRM SUMMARY __________	
		  $_GET['leave_id'] =  mysqli_insert_id();
          $full_leave = find_all_field('hrm_leave_info', '', 'id=' . $_GET['leave_id']);
		  
		  $up_query = "update hrm_att_summary set leave_id='" . $full_leave->id . "', leave_type='" . $full_leave->half_or_full . "',
          leave_reason='" . $full_leave->reason . "',leave_duration='" . $full_leave->total_days. "', leave_approved_by='" . $_SESSION['user']['id'] . "',
          leave_entry_at='" . $full_leave->entry_at . "', leave_entry_by='" . $full_leave->PBI_ID . "' where id=" . $data->id;
          $result_new = db_query($up_query);
		
    } else {
        // Insufficient leave balance, deduct from salary
        //$gross_salary -= 8 * ($gross_salary / $working_hours) * 60; // Assuming monthly salary
		
	
		$leave_punishment =  "Full Day gross_salary deduction.";
		$leave_punishment_status = 1;
		$actual_late_min = 0;
		$final_late_status = 0;
		$final_early_status = 0;
        $final_early_min = 0;
		
		
		$lwp_query = "INSERT INTO hrm_leave_info( leave_apply_date , incharge_status , half_or_full, PBI_ID, type, s_date,e_date,total_days,reason,
		 leave_status,leave_punishment_status)
		  
		VALUES ('".$data->att_date."','Approve', 'Full' , '" .$data->emp_id."', 9 , '" .$data->att_date. "' , '" .$data->att_date. "' ,'1', 
		'Leave Punishment', 'GRANTED' , 1)";
		$result = db_query($lwp_query);
		
		
		
		
		
			//_________ Leave Deduct From HRM SUMMARY __________	
		  $_GET['leave_id'] =  mysqli_insert_id();
          $full_leave = find_all_field('hrm_leave_info', '', 'id=' . $_GET['leave_id']);
		  
		  $up_query = "update hrm_att_summary set leave_id='" . $full_leave->id . "', leave_type='" . $full_leave->half_or_full . "',
          leave_reason='" . $full_leave->reason . "',leave_duration='" . $full_leave->total_days. "', leave_approved_by='" . $_SESSION['user']['id'] . "',
          leave_entry_at='" . $full_leave->entry_at . "', leave_entry_by='" . $full_leave->PBI_ID . "' where id=" . $data->id;
          $result_new = db_query($up_query);
		
		
	
    }
	
	
	
}else{

	$leave_punishment = "";
	$leave_punishment_status = 0;

    }



}else{

$leave_punishment = "";
$leave_punishment_status = 0;

}


//_______________ END PUNISHMENT _______________	

$update_sql = "update hrm_att_summary 
set 

actual_late_min='".$actual_late_min."',
final_late_status='".$final_late_status."', 
final_early_min='".$final_early_min."', 
leave_punishment='".$leave_punishment."',
lv_punishment_status='".$leave_punishment_status."',
final_early_status ='".$final_early_status."'


where id=".$data->id;







db_query($update_sql);



$old_emp_id = $data->emp_id;







}







echo ' Process Complete! OK.';















}







?>
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
          <?php /*?><div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







                                <div class="form-group row m-0 mb-1 pl-3 pr-3">







                                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Month :    </label>







                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">







                                        <select name="mon"  id="mon" required>







											<option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>







											<option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>







											<option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>







											<option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>







											<option value="5" <?=($mon=='5')?'selected':''?>>May</option>







											<option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>







											<option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>







											<option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>







											<option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>







											<option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>







											<option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>







											<option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>







										</select>















                                    </div>







                                </div>







                            </div><?php */?>
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
          <input name="upload" class="btn1 btn1-bg-submit" type="submit" id="upload" value="Sync All Data" />
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







<td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Late Calculation Process </div></td>







</tr>







<tr><td>Employee ID</td>







<td colspan="3"><input type="text" name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" /></td></tr>







<tr><td>Company:</td>







<td colspan="3"><span class="oe_form_group_cell">







<select name="PBI_ORG" style="width:160px;" id="PBI_ORG">







<? foreign_relation('user_group','id','group_name',$PBI_ORG);?>







</select>







</span></td></tr>







<tr>







<td>Job Location</td>







<td><select name="JOB_LOCATION" id="JOB_LOCATION"  class="form-control" required  >







<option><?=$JOB_LOCATION?></option>







<option value="1">Head Office</option>







<option value="2">Factory</option>







</select></td>







</tr>







<tr>







<td width="20%">Month :</td>







<td colspan="3"><span class="oe_form_group_cell">







<select name="mon" style="width:160px;" id="mon" required>







<option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>







<option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>







<option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>







<option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>







<option value="5" <?=($mon=='5')?'selected':''?>>May</option>







<option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>







<option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>







<option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>







<option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>







<option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>







<option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>







<option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>







</select>







</span></td>







</tr><?php */?>
<?php /*?><tr><td>End Date</td>







<td colspan="3"><input type="date" name="f_date" id="f_date" value="<?=$_POST['f_date']?>" /></td></tr>







<tr><td>End Date</td>







<td colspan="3"><input type="date" name="	t_date" id="t_date" value="<?=$_POST['t_date']?>" /></td></tr><?php */?>
<tr>
  <?php /*?><td>Year :</td>







<td colspan="3"><select name="year" style="width:160px;" id="year" required>







<option <?=($year=='2022')?'selected':''?>>2022</option>







<option <?=($year=='2023')?'selected':''?>>2023</option>







<option <?=($year=='2021')?'selected':''?>>2021</option>







</select></td>







</tr>







<tr>







<td colspan="4">







<div align="center">







<input name="upload" class="btn1 btn1-bg-submit" type="submit" id="upload" value="Sync All Data" />







</div></td>







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




require_once SERVER_CORE."routing/layout.bottom.php";




?>