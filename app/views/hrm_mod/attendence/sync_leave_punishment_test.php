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




// Main Data Fetch

 $sql = "SELECT h.*,p.define_schedule,p.define_offday,p.punch_type,p.grace_type,p.PBI_DOJ,p.JOB_LOC_ID,p.class,
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

 $late_min  = $data->actual_late_min;
 $early_min = $data->final_early_min;
 
  $final_late_min_count = ($late_min +$early_min);


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







  $delay = $final_late_min_count; // 15 minutes delay


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



if ($data->class!=3 && ($data->sch_off_day==0) && ($data->holyday==0) && (($al_balance > 0 || $cl_balance > 0) && ($final_early_status > 0 || $final_late_status > 0)))


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
				
				/////
				/*$actual_late_min = $data->actual_late_min;
				$final_late_status = $data->final_late_status;
				$final_early_min = $data->final_early_min;
				$final_early_status = $data->final_early_status;*/
				
		
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
				
				/////
				/*$actual_late_min = $data->actual_late_min;
				$final_late_status = $data->final_late_status;
				$final_early_min = $data->final_early_min;
				$final_early_status = $data->final_early_status;*/
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
				
				/////
				/*$actual_late_min = $data->actual_late_min;
				$final_late_status = $data->final_late_status;
				$final_early_min = $data->final_early_min;
				$final_early_status = $data->final_early_status;*/
			}
	
	
}  elseif ($delay_hours > 4  &&  $system_OutTimeOnly < $sch_break_start ) {
   
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
		
		/////
				$actual_late_min = 0;
				$final_late_status = 0;
				$final_early_min = 0;
				$final_early_status = 0;
		
		
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
	
	/////
				$actual_late_min = $data->actual_late_min;
				$final_late_status = $data->final_late_status;
				$final_early_min = $data->final_early_min;
				$final_early_status = $data->final_early_status;

    }



}else{

$leave_punishment = "";
$leave_punishment_status = 0;

/////
				$actual_late_min = $data->actual_late_min;
				$final_late_status = $data->final_late_status;
				$final_early_min = $data->final_early_min;
				$final_early_status = $data->final_early_status;

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


<tr>

	
<?




require_once SERVER_CORE."routing/layout.bottom.php";




?>