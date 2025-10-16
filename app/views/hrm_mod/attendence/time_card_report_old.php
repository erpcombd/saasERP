
<script src="sweetalerts/sweetalert2.min.js"></script>
<script src="sweetalerts/promise-polyfill.js"></script>
<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />


<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require_once "../sms_function.php";

$title='Time Card';
//$page_id = 35;
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#start_date');
do_calander('#end_date');

//echo "alamin".$_POST['PBI_CODE'];
 $PBI_ID = find_a_field('personnel_basic_info','PBI_ID','PBI_ID='.$_POST['PBI_ID']);
  $all_info = find_all_field('personnel_basic_info','*','PBI_CODE="'.$_POST['PBI_CODE'].'"'); 
 
 
 
 function calculateWorkingHours($inTime, $outTime) {
    // Check if both in-time and out-time are provided
    if (!empty($inTime) && !empty($outTime)) {
        // Create DateTime objects for in-time and out-time
        $inDateTime = new DateTime($inTime);
        $outDateTime = new DateTime($outTime);

        // Calculate the difference between in-time and out-time
        $interval = $inDateTime->diff($outDateTime);

        // Format the total working hours
        $workingHours = $interval->format('%H:%I');

        return $workingHours;
    } else {
        // Return null if either in-time or out-time is not provided
        return null;
    }
}


?>
<style>
    .new-color {
        background-color: #E3F1FD !important;
    }
    .new-btn{
        width:100% !important;
    }
    
    input[type=submit], input[type=button] {
        min-width: 90px!important;
        outline: none!important;
    }
</style>




<?php
    
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {
  
		 $user_id=$_SESSION['user']['id'];
		 $emp=$_POST['PBI_IDD'];
		 
	
	    //$bulk_s_date =  date('Y-m-d',strtotime($_POST['bulk_start_date']));
		//$bulk_e_date =  date('Y-m-d',strtotime($_POST['bulk_end_date']));
		
		$selectedinTime = $_POST['punch_in'];
		$selectedoutTime = $_POST['punch_out'];
		
		
		           $display = $_POST['check_list'];
				   
                   foreach ( $display as $key  ) {
				   
				   $access_time = $key . ' ' . $selectedinTime;
	
		
				 $att_sql = "INSERT INTO hrm_attdump ( ztime, bizid, xenrollid, xdate, xtime,EMP_CODE,time,entry_by,type) 
					VALUES ('$access_time', '$emp', '$emp', '$key', '$access_time','$emp','$selectedinTime','$user_id',1)";
					$att_query=db_query($att_sql);
					
					/// For out time 
					if($_POST['punch_out']>0){
					//$access_time = $att_date.' '.$_POST['o_hr'].':'.$_POST['o_min'].':'.'00';
					$access_time = $key . ' ' . $selectedoutTime;
					 $att_sql1 = "INSERT INTO hrm_attdump ( ztime, bizid, xenrollid, xdate, xtime,EMP_CODE,time,entry_by,type) 
					VALUES ('$access_time', '$emp', '$emp', '$key', '$access_time','$emp','$selectedoutTime','$user_id',1)";
					$att_query1=db_query($att_sql1);
					}
		
		
				   
				   }




      	/* for($i=$bulk_s_date;$i<=$bulk_e_date;$i = date('Y-m-d', strtotime( $i . " +1 days"))){
	
		 $access_time = $i . ' ' . $selectedinTime;
		
		 $att_sql = "INSERT INTO hrm_attdump ( ztime, bizid, xenrollid, xdate, xtime,EMP_CODE,time,entry_by) 
		VALUES ('$access_time', '$emp', '$emp', '$i', '$access_time','$emp','$selectedinTime','$user_id')";
		$att_query=db_query($att_sql);
		
	
		if($_POST['punch_out']>0){
	
		$access_time = $i . ' ' . $selectedoutTime;
		$att_sql1 = "INSERT INTO hrm_attdump ( ztime, bizid, xenrollid, xdate, xtime,EMP_CODE,time,entry_by) 
		VALUES ('$access_time', '$emp', '$emp', '$i', '$access_time','$emp','$selectedoutTime','$user_id')";
		$att_query1=db_query($att_sql1);
		}}*/

			
			
			if ($att_query1) {
				// Include SweetAlert script to display a success message
				echo "<script>
					$(document).ready(function() {
						swal({
							title: 'Shift Successfully Changed.',
							text: 'You Follow The Right Step!',
							type: 'success',
							padding: '2em'
						});
					});
				</script>";
			}}

  ?>


      <?  if (isset($_POST['submit'])) {
              // Loop through the input fields and update the corresponding rows in the database
              for ($i = 0; $i < count($_POST['emp_id']); $i++) {
                $id = $_POST['id'][$i];
				$in_time = $_POST['update_ztime'][$i];
                $out_time = $_POST['update_xtime'][$i];
		        $date_att = $_POST['att_date'][$i];
				$dump_emp = $_POST['PBI_IDD'];
				
				$user_id=$_SESSION['user']['id'];
	
				
				$access_time_in  = $date_att . ' ' . $in_time;
				$access_time_out = $date_att . ' ' . $out_time;
				  
               
            
             
                if($in_time>0 || $out_time>0){
                 $sql = "UPDATE hrm_att_summary SET in_time = '$access_time_in' , out_time='$access_time_out' WHERE id = $id";
                db_query($sql);
				
				$access_time = $i . ' ' . $selectedoutTime;
				$att_sql1 = "INSERT INTO hrm_attdump ( ztime, bizid, xenrollid, xdate, xtime, EMP_CODE,time,entry_by,type) 
				VALUES ('$access_time_out', '$dump_emp', '$dump_emp', '$date_att', '$access_time_in','$dump_emp','$in_time','$user_id',1)";
				$att_query1=db_query($att_sql1);
				
				
				
                }
              }
                    //$s_date = isset($_GET['s_date']) ? $_GET['s_date'] : (isset($_POST['fdate']) ? $_POST['fdate'] : '');
					//$t_date = isset($_GET['tdate']) ? $_GET['tdate'] : (isset($_POST['tdate']) ? $_POST['tdate'] : '');
					//$emp_id = isset($_GET['PBI_IDD']) ? $_GET['PBI_IDD'] : (isset($_POST['PBI_IDD']) ? $_POST['PBI_IDD'] : '');

                   /* $s_date = isset($_POST['fdate']) ? urlencode($_POST['fdate']) : '';
                    $t_date = isset($_POST['tdate']) ? urlencode($_POST['tdate']) : '';
                    $emp_id = isset($_POST['PBI_IDD']) ? urlencode($_POST['PBI_IDD']) : '';*/
                    
      
                    //header("Location: time_card_report.php?s_date=$s_date&t_date=$t_date&emp_id=$emp_id");
                    //exit();
            
            
            }
			
			
			
			
			
            
            ?>


<form method="post" id="employeeForm">
  <div class="container-fluid">
    <? include('../../common/title_bar_shift.php');?>
  </div>
  
  <div class="container-fluid  new-color pt-3 mb-3">
    <div class="row m-0 p-0" style="zoom: 90%;">
        
        <!-- <div class="col-md-2 form-group">
            <label class="label" for="fdate">Shift Start Date </label>
                <input type="date" name="fdate" autocomplete="off" id="fdate" value="<?=$_POST['fdate']?>"  class="form-control" />                           
        </div>
        
        <div class="col-md-2 form-group">
            <label class="label" for="tdate">Shift End  Date  </label>
            <input type="date" name="tdate" autocomplete="off" id="tdate" value="<?=$_POST['tdate']?>"  class="form-control" />                         
        </div> -->
        
     <!--   <div class="col-md-2 form-group">
            <label class="label" for="bulk_start_date"> Attendance Start  Date  </label>
            <input type="date" name="bulk_start_date" autocomplete="off" id="bulk_start_date" value="<?=$_POST['bulk_start_date']?>"  class="form-control" />                            
        </div>
            
        <div class="col-md-2 form-group">
            <label class="label" for="bulk_end_date"> Attendance End  Date </label>
                <input type="date" name="bulk_end_date" autocomplete="off" id="bulk_end_date" value="<?=$_POST['bulk_end_date']?>"  class="form-control" />                             
        </div>-->
        
        <div class="col-sm-4 pb-1">
                
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Employee ID : </label>
                    <div class="col-sm-8 p-0">
                        <p class="m-0 p-0"><?=$all_info->PBI_CODE?></p>
                    </div>
                </div>
                
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center"> Designation : </label>
                    <div class="col-sm-8 p-0">
                       <p class="m-0 p-0"><?=$all_info->PBI_DESIGNATION?></p>
                    </div>
                </div>
                
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center"> Department : </label>
                    <div class="col-sm-8 p-0">
                        <p class="m-0 p-0"><?=$all_info->PBI_DEPARTMENT?></p>
                    </div>
                </div>
                
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">DOJ : </label>
                    <div class="col-sm-8 p-0">
                        <p class="m-0 p-0"><?=$all_info->PBI_DOJ?></p>
                    </div>
                </div>
        </div>
                
        <div class="col-sm-4  pb-1">
                
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Name : </label>
                    <div class="col-sm-8 p-0">
                        <p class="m-0 p-0"><?=$all_info->PBI_NAME?></p>
                    </div>
                </div>
                
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Cost Centre : </label>
                    <div class="col-sm-8 p-0">
                        <p class="m-0 p-0"><?=find_a_field('cost_center','center_name','id='.$all_info->cost_center);?></p>
                    </div>
                </div>
                
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Section : </label>
                    <div class="col-sm-8 p-0">
                        <p class="m-0 p-0"><?=find_a_field('PBI_Section','sec_name','sec_id='.$all_info->section);?></p>
                    </div>
                </div>
                
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center"> DOL : </label>
                    <div class="col-sm-8 p-0">
                        <p class="m-0 p-0"><?=$all_info->resign_date?></p>
                    </div>
                </div>
        </div>
        
        <div class="col-sm-3">
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="punch_in" class="col-sm-4 m-0 p-0 d-flex align-items-center">In Time </label>
                    <div class="col-sm-8 p-0">
                        <input type="time" name="punch_in" autocomplete="off" id="punch_in" value="<?=$_POST['punch_in']?>"  class="form-control" /> 
                    </div>
                </div>
                
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="punch_out" class="col-sm-4 m-0 p-0 d-flex align-items-center">Out Time  </label>
                    <div class="col-sm-8 p-0">
                        <input type="time" name="punch_out" autocomplete="off" id="punch_out" value="<?=$_POST['punch_out']?>"  class="form-control" />  
                    </div>
                </div>
        </div>
        
        
        <div class="col-sm-1 m-0 p-0">
              <input type="submit" name="save" class="btn btn-success" value="Save"> <br>   
              <input type="submit" name="save" class="btn btn-success mt-2 mb-2" value="Time Card">  
        </div>
	  
    </div>
  </div>
  <div class="container-fluid p-0">
    <?  





  //if(isset($_POST['button'])){
  
  
?>
    <table width="100%" class="table1 table-bordered table-sm" cellspacing="0" cellpadding="0" id="grp">
      <thead class="thead1">
        <tr class="bgc-info">
          <th rowspan="2" style="width:50px;text-align:center">Mark</th>
          <th rowspan="2">Date</th>
          <th rowspan="2">Day Name</th>
          <th>Assigned</th>
          <th colspan="2">Shift Time</th>
     
          <th rowspan="2">In Time</th>
          <th rowspan="2">Out Time</th>
          <th rowspan="2">Over Time</th>
          <th>In Late</th>
          <th>Early Out</th>
		  <th rowspan="2">W.Hr</th>

          <th rowspan="2">Status</th>
          <th rowspan="2">Save Button</th>
        </tr>
        <tr class="bgc-info">
          <th>Shift</th>
          <th>Start</th>
          <th>End</th>
          <th>(minute)</th>
          <th>(minute)</th>
        </tr>
      </thead>
      <tbody>
        <?

					
                            if($_POST['PBI_CODE']!="") $codeConn = " and a.PBI_CODE='".$_POST['PBI_CODE']."'";
                            if($_POST['PBI_IDD']!="") $idConn = " and a.PBI_ID ='".$_POST['PBI_IDD']."'";
                          
                            if($_POST['PBI_NAME']!="") $NameConn = " and a.PBI_NAME='".$_POST['PBI_NAME']."'";
                            if($_POST['DESG_ID']>0) $desgConn = " and a.DESG_ID='".$_POST['DESG_ID']."'";
                            if($_POST['DEPT_ID']>0) $depConn = " and a.DEPT_ID='".$_POST['DEPT_ID']."'";
                            if($_POST['PBI_SEX']!="") $genderConn = " and a.PBI_SEX='".$_POST['PBI_SEX']."'";
                            if($_POST['grade']>0) $gradeConn = " and a.grade='".$_POST['grade']."'";  
                            if($_POST['work_station']>0) $work_station = " and a.PBI_WORK_STATION='".$_POST['work_station']."'";  
                            
                            
                            
                            if($_POST['PBI_RELIGION']!="") $ReligionConn = " and a.PBI_RELIGION='".$_POST['PBI_RELIGION']."'";
                            if($_POST['PBI_ORG']>0) $OrgConn = " and a.PBI_ORG='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and a.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
                            
                            if($_POST['section']>0) $secConn = " and a.section='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and a.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['cost_center']>0) $CostConn = " and a.cost_center='".$_POST['cost_center']."'";
                     
                            
                            if($_POST['class']>0) $classConn = " and a.class='".$_POST['class']."'";
                            if($_POST['line']>0) $lineConn = " and a.line='".$_POST['line']."'";
                            if($_POST['incharge_id']>0) $inchargeConn = " and a.incharge_id='".$_POST['incharge_id']."'";
							
                            if($_POST['DOJ']>0) $DOJConn = " and a.PBI_DOJ='".$_POST['DOJ']."'";
                            
						  	if($_POST['shedule']>0) $shiftConn = " and a.define_schedule ='".$_POST['shedule']."'";
						  	
						  	//________
						  	$s_date = isset($_GET['s_date']) ? $_GET['s_date'] : (isset($_POST['fdate']) ? $_POST['fdate'] : '');
						  	$t_date = isset($_GET['t_date']) ? $_GET['t_date'] : (isset($_POST['t_date']) ? $_POST['t_date'] : '');
						  	$emp_id = isset($_GET['emp_id']) ? $_GET['emp_id'] : (isset($_POST['PBI_IDD']) ? $_POST['PBI_IDD'] : '');

						  	//$s_date = isset($_GET['s_date']) ? $_GET['s_date'] : '';
                            //$t_date = isset($_GET['t_date']) ? $_GET['t_date'] : '';
                            //$emp_id = isset($_GET['emp_id']) ? $_GET['emp_id'] : '';
                            
                            if ($emp_id > 0) { $emp_code_con = " and l.emp_id='$emp_id'";}
                        
                            
                            // Use the values in conditions
                            if ($s_date > 0) { $fdate = $s_date;}else{  $fdate = $_POST['fdate']; $fdate =  date('Y-m-d',strtotime($fdate)); }
                            
                            if ($t_date > 0) {  $tdate = $t_date;}else{  $tdate = $_POST['tdate']; $tdate =  date('Y-m-d',strtotime($tdate));}
						  	
						   
                    	
                    	
                            						
          
	 $leave_sql="SELECT l.*,a.PBI_NAME as Employee_Name,a.PBI_CODE,
      (select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as department
 FROM hrm_att_summary l, personnel_basic_info a 
 where a.PBI_ID=l.emp_id and l.att_date between '".$fdate."' and '".$tdate."'
 
 ".$codeConn.$idConn.$genderConn.$NameConn.$ReligionConn.$DOJConn.$OrgConn.$classConn.$gradeConn.$work_station.
$lineConn.$inchargeConn.$depConn.$desgConn.$secConn.$emp_code_con.$JoblocConn.$CostConn.$levelConn.$job_statusConn.$shiftConn." order 
by l.emp_id,l.att_date asc";

 $leave_query=db_query($leave_sql);
 while($data = mysqli_fetch_object($leave_query)){

$val[$data->att_date]['in_time'] = $data->in_time;
$val[$data->att_date]['out_time'] = $data->out_time;
$val[$data->att_date]['sch_in_time'] = $data->sch_in_time;
$val[$data->att_date]['sch_out_time'] = $data->sch_out_time;
$val[$data->att_date]['iom'] = $data->iom_id;
$val[$data->att_date]['leave'] = $data->leave_id;
$val[$data->att_date]['dayname'] = $data->dayname;
$val[$data->att_date]['od_id'] = $data->od_id;
$val[$data->att_date]['od_start_time'] = $data->od_start_time;
$val[$data->att_date]['iom_start_time'] = $data->iom_start_time;
$val[$data->att_date]['ot_final_hour'] = $data->ot_final_hour;
$val[$data->att_date]['iom_total_hrs'] = $data->iom_total_hrs;
$val[$data->att_date]['sch_off_day'] = $data->sch_off_day;
$val[$data->att_date]['final_late_min'] = $data->final_late_min;
$val[$data->att_date]['late_min'] = $data->late_min;
$val[$data->att_date]['early_min'] = $data->early_min;
$val[$data->att_date]['sch_id'] = $data->sch_id;
$val[$data->att_date]['emp_id'] = $data->emp_id;
$val[$data->att_date]['id'] = $data->id;



$total_late_min += $data->late_min;
$total_early_min += $data->early_min;
$total_overtime += $data->ot_final_hour;
//office time
$sac_formated = date("H:i",strtotime($data->sch_in_time));
$punch_outtimes= date("H:i",strtotime($data->out_time));


//od start time
$od_start_timee = date("h:i",strtotime($data->od_start_time));
//iom start time
$sort_leave_start_timee = date("h:i",strtotime($data->iom_start_time));


$val[$data->att_date]['final_late_status'] = $data->final_late_status;
$val[$data->att_date]['grace_no'] = $data->grace_no;
$val[$data->att_date]['holyday'] = $data->holyday;

if($data->leave_id>0)
$val[$data->att_date]['final_status'] = 'LEAVE';

elseif( $data->in_time=='' && $data->leave_id==0  && $data->iom_id==0 )
$val[$data->att_date]['final_status'] = 'Absent';

elseif($data->early_min>0)
$val[$data->att_date]['final_status'] = 'Early Out';

elseif( $data->final_late_status>0)
$val[$data->att_date]['final_status'] = 'LATE';

elseif( $data->final_late_status>0 && $data->early_min>0)
$val[$data->att_date]['final_status'] = 'LateEarlyOut';

elseif($data->holyday>0)
$val[$data->att_date]['final_status'] = 'HOLIDAY';

elseif($data->sch_off_day>0)
$val[$data->att_date]['final_status'] = 'Weekend';

elseif($data->iom_id>0)
$val[$data->att_date]['final_status'] = 'Amendment';

elseif($data->present>0)
$val[$data->att_date]['final_status'] = 'PRESENT';

$dteStart = new DateTime($data->in_time);
$dteEnd   = new DateTime($data->out_time);
$dteDiff  = $dteStart->diff($dteEnd);

  }


  
    if ($s_date > 0) { $start_date = $s_date;}else{  $start_date = $_POST['fdate'];}
   
    if ($t_date > 0) { $end_date = $t_date;}else{  $end_date = $_POST['tdate'];}

 


 $begin = new DateTime($start_date);
 //$end = new DateTime($end_date);

 $start = new DateTimeImmutable($end_date);
 $end = $start->modify('+1 day');


 $interval = DateInterval::createFromDateString('1 day');
 $period = new DatePeriod($begin, $interval, $end);
 
 foreach ( $period as $dt ){
  ++$days;

  $this_date = $dt->format( "Ymd" );
  $day_date = $dt->format( "Y-m-d" );

  

  $holysql = "select * from salary_holy_day where holy_day = '".$day_date."'";
	$holy_query = db_query($holysql);
	$holy = mysqli_fetch_object($holy_query);
	$holy_reson=$holy->reason;
	$val[$day_date]['grace_no'];

	if($holy>0){
	$bgcolor = '#DDFFFF';
	$val[$day_date]['final_status']= $holy_reson;
	$public_holy++;
	}


	elseif($val[$day_date]['final_status']=='Weekend')
    {$bgcolor = '#E7E9EB'; $off_days++;}

	elseif($val[$day_date]['final_status']=='LEAVE')
	{$bgcolor = '#DDFFFF'; $leave++;}


	elseif($val[$day_date]['final_status']=='SHL')
	{$bgcolor = '#D5D6EA'; $shl++;}

	elseif($val[$day_date]['final_status']=='Amendment')
    {$bgcolor = '#DDFFFF'; $amendment++;}

	elseif($val[$day_date]['final_status']=='Early Out')
	{$bgcolor = '#FFFFCC'; $early++;}

  elseif($val[$day_date]['final_status']=='LateEarlyOut')
	{$bgcolor = '#FFFFCC'; $late_early++;}

	elseif($val[$day_date]['final_status']=='ABSENT')
	{$bgcolor = '#FFDDDD'; $absent_leave_ck++;}

	elseif($val[$day_date]['final_status']=='LATE')
	{$bgcolor = '#FFFFCC';$late++; $late_min_total = $late_min_total + $val[$day_date]['late_min'];}


	elseif($val[$day_date]['final_status']=='PRESENT')
	{$bgcolor = '#DDFFDD';$regular++;}

	else
	{$bgcolor = '#FFDDDD';   $absent++;
	$val[$day_date]['final_status']='ABSENT';
	} 

   

?>
        <tr>
		
		   <td bgcolor="<?=$bgcolor?>" style="width:50px"><input type="checkbox" style="width:50px" name="check_list[]" value="<?=$day_date;?>"></td>
                
            
        
          <td bgcolor="<?=$bgcolor?>"><?=$dt->format( "d-M-Y" );?>
		  
            <input type="hidden" id="id" name="id[]" value="<?=$val[$day_date]['id'];?>">
            <input type="hidden" id="emp_id" name="emp_id[]" value="<?=$val[$day_date]['emp_id'];?>">
            <input type="hidden" id="att_date" name="att_date[]" value="<?=$day_date;?>">
			<input type="hidden" id="bulk_pbi_id" name="bulk_pbi_id" value="<?=$val[$day_date]['emp_id'];?>">
		  
		  
		  </td>
          <td bgcolor="<?=$bgcolor?>"><?=$dt->format("l");?></td>
          <td bgcolor="<?=$bgcolor?>"><?=find_a_field('hrm_schedule_info','acronyms','id='.$val[$day_date]['sch_id']); ?></td>
          <td bgcolor="<?=$bgcolor?>"><? echo ($val[$day_date]['sch_in_time']) ? date("h:i a", strtotime($val[$day_date]['sch_in_time'])) : ''; ?></td>
          <td bgcolor="<?=$bgcolor?>"><?php echo (!empty($val[$day_date]['sch_out_time'])) ? date("h:i a", strtotime($val[$day_date]['sch_out_time'])) : ''; ?></td>
      
          <td bgcolor="<?=$bgcolor?>">
		  
		  <span style="color:#18226D; font-weight:bold" data-toggle="collapse" data-target="#timeInput">
			<?php
			if ($val[$day_date]['in_time'] > 0)
				echo date("h:i a", strtotime($val[$day_date]['in_time']));
			?>
			</span> 	 
            <br />
			
			
			<div id="timeInput" class="collapse">
				<input type="time" id="update_ztime" name="update_ztime[]">
			</div>
	
		  
		  
			
			
			</td>
			
			
			
          <td bgcolor="<?=$bgcolor?>">
		  
	
           <span style="color:#18226D; font-weight:bold" data-toggle="collapse" data-target="#timeInput2">
            <?
			if($val[$day_date]['out_time']>0)
			echo date("h:i a", strtotime($val[$day_date]['out_time']));
			
			?>
            </span>  	 
            <br />
			
			<div id="timeInput2" class="collapse">
			 <input type="time" id="update_xtime"  name="update_xtime[]">
			</div>
			
			
			</td>
			
			
			
          <td bgcolor="<?=$bgcolor?>"><?=round($val[$day_date]['ot_final_hour']);?></td>
          <td bgcolor="<?=$bgcolor?>"><? if($val[$day_date]['late_min']>0) echo $val[$day_date]['late_min'];?></td>
          <td bgcolor="<?=$bgcolor?>"><? if($val[$day_date]['early_min']>0) echo $val[$day_date]['early_min'];?></td>
		  
		  <td bgcolor="<?=$bgcolor?>"><? 
		  
		    $inTime = $val[$day_date]['in_time'];
			$outTime = $val[$day_date]['out_time'];
			
			echo $totalWorkingHours = calculateWorkingHours($inTime, $outTime);
			
		
		  
		  ?></td>
		
		  
          <td bgcolor="<?=$bgcolor?>"><?=$val[$day_date]['final_status'];?></td>
          <!--<td><button type="button" class="btn btn-danger" onClick="submitForm()">Submit</button> </td>-->
          <td bgcolor="<?=$bgcolor?>"><button type="submit" name="submit" class="btn btn-primary">Update</button></td>
        </tr>
		
		 <tr>
		 <td colspan="8">
		 
		 
<?php
$damp_sql = "SELECT * FROM hrm_attdump WHERE EMP_CODE= '".$val[$day_date]['emp_id']."' AND xdate = '".$day_date."' and type!=1 ORDER BY sl";
$damp_query = db_query($damp_sql);
if ($damp_query) {
    // Initialize an array to store formatted xtime values
    $formatted_xtime_values = array();

    // Loop through the result set
    while ($damp = mysqli_fetch_object($damp_query)) {
        // Store and format xtime values in the array
        $formatted_xtime_values[] = date('d-M-Y H:i:s', strtotime($damp->xtime));
    }

    // Find and remove the minimum time from the array
    $min_time = min($formatted_xtime_values);
    $min_time_index = array_search($min_time, $formatted_xtime_values);
    unset($formatted_xtime_values[$min_time_index]);

    // Output the minimum time followed by the sorted xtime values
    echo '<span style="color: navy;">'.$min_time.'</span>, ';
    sort($formatted_xtime_values, SORT_STRING);
    echo '<span style="color: navy;">'.implode(', ', $formatted_xtime_values).'</span>, '; 
} else {
    // Handle the case when the query is not successful
}

?>


		 
		 
		 
		 
		 
		 
		 
		 
		 
		 <?  
           /* $damp_sql = "SELECT * FROM hrm_attdump WHERE EMP_CODE= '".$val[$day_date]['emp_id']."' 
            AND xdate = '".$day_date."' order by sl";
              $damp_query = db_query($damp_sql);
              if ($damp_query) {
                  // Initialize variables to store xtime and ztime values
                  $xtime_values = '';
                  $ztime_values = '';

                  // Loop through the result set
                  while ($damp = mysqli_fetch_object($damp_query)) {
                      // Concatenate xtime and ztime values with a separator (e.g., comma)
                      $xtime_values .= $damp->xtime.', ';
                      $ztime_values .= $damp->ztime.', ';
                  }

                  // Remove the trailing commas and output the span with all xtime and ztime values
                  echo '<span style="color: red;"> '.rtrim($xtime_values, ', ').' '.rtrim($ztime_values, ', ').'</span>';
              } else { }*/

            ?></td>
		 </tr>
		
		
        <? } ?>
		
  
			
			

		
      </tbody>
    </table>


   <div align="left">
	<input type="checkbox" class="form-check-input" id="select-all">
	<label for="checkbox"><span class="bg-danger text-white">Select All</span></label>
	</div>
	
	
  </div>
</form>
<script>
/* function submitForm() {
    var intime =  $("#update_ztime").val();
    var outtime = $("#update_xtime").val();
	var emp_id = $("#emp_id").val();
    var att_date = $("#att_date").val();
    
	
    $.ajax({
        type: "POST",
        url: "time_adjust_ajax.php",
        data: {
            in_time: intime,
            out_time: outtime,
            id_no: emp_id,
            date: att_date
        },
		
        success: function(response) {
            $("#result").html(response);
        }
    });
}
*/
</script>


  <script>

document.getElementById('select-all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}




</script>

<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../assets/js/popper.min.js"></script>
<script type="text/javascript" src="../../../assets/js/jquery-3.4.1.min.js"></script>

<?
  require_once SERVER_CORE."routing/layout.bottom.php";
?>
