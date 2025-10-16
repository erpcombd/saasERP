<?php
ini_set('max_execution_time', 600); 
set_time_limit(600);

session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";


$title = "Machine Data Sync (Roster)";

do_calander('#m_date');

if ($_POST['mon'] != '') {
    $mon = $_POST['mon'];
} else {
    $mon = date('n');
}

echo "<script>
        $(document).ready(function() {
            // Trigger form submission after 50 seconds
            setTimeout(function() {
                document.getElementById('upload').click();
            }, 3600000); // 50 seconds in milliseconds
        });
      </script>";
      
      

if (isset($_POST["upload"])) {
    if ($_POST['s_date'] != '' && $_POST['e_date'] != '') {
        $start_date = date('Y-m-d', strtotime($_POST['s_date']));
        $end_date = date('Y-m-d', strtotime($_POST['e_date']));
        $date_con = " and h.xdate BETWEEN '$start_date' AND '$end_date'";
    }
	
	
	


// Schedule Info Fetch All // __________________ ROSTER INSERT ____________
	
		for($i=$start_date;$i<=$end_date;$i = date('Y-m-d', strtotime( $i . " +1 days"))){ 
	    
		 $sql = "SELECT * FROM hrm_roster_assign WHERE '$i' BETWEEN roster_start_date AND roster_end_date";
         $ros_assign = db_query($sql);
         $num_rows = mysqli_num_rows($ros_assign);
         if ($num_rows > 0) {
         
		 while($assign_roster = mysqli_fetch_object($ros_assign)){
            
         $assign_schdule = $assign_roster->shedule_1;
		 $assign_emp_id = $assign_roster->PBI_ID;
		
	      
		  
		 $found = find_a_field('hrm_roster_allocation','1','PBI_ID="'.$assign_emp_id.'" and roster_date="'.$i.'" ');
         
		 if($found==0) { 
		
		
	    $insSql = 'INSERT INTO hrm_roster_allocation( PBI_ID, roster_date,  shedule_1, job_location,group_for, entry_by) 
		 VALUES ("'.$assign_emp_id.'", "'.$i.'",  "'.$assign_schdule.'", "'.$_POST['job_location'].'", "'.$_POST['group_for'].'", "'.$entry_by.'")';
		$result_new = db_query($insSql); 
		
		
		}   } }} 
		
		
//_______________________ROSTER INSERT OFFFFFFFFF___________________

    // Fetch schedule info
    $sql = 'SELECT * FROM hrm_schedule_info';
    $query = db_query($sql);
    while ($data = mysqli_fetch_object($query)) {
        $sch_start[$data->id] = $data->office_start_time;
        $sch_end[$data->id] = $data->office_end_time;
        $sch_mid[$data->id] = $data->office_mid_time;
        $sch_mid_end[$data->id] = $data->office_mid_time2;
    }

    // Fetch roster allocation
    $sql = "SELECT * FROM hrm_roster_allocation WHERE roster_date BETWEEN '$start_date' AND '$end_date'";
    $query = db_query($sql);
    while ($data = mysqli_fetch_object($query)) {
        $roster_assign[$data->PBI_ID][$data->roster_date] = $data->shedule_1;
    }

    $datetime = date('Y-m-d H:i:s');
    $emp_id = $_POST['emp_id'];
    $PBI_ORG = $_POST['PBI_ORG'];
    $job_location_con = $_POST['JOB_LOCATION'] > 0 ? " and p.JOB_LOC_ID='{$_POST['JOB_LOCATION']}'" : '';
    $department_con = $_POST['department'] > 0 ? " and p.DEPT_ID='{$_POST['department']}'" : '';
    $ORG_con = $PBI_ORG > 0 ? " and p.PBI_ORG='$PBI_ORG'" : '';
    $emp_id_con = $emp_id > 0 ? " and p.PBI_ID='$emp_id'" : '';

   echo $sql = "SELECT d.EMP_CODE, a.roster_date, MIN(d.xtime) AS in_time, MAX(d.xtime) AS out_time, a.shedule_1, p.schedule_type, p.PBI_ID, d.type
            FROM hrm_attdump d
            JOIN hrm_roster_allocation a ON d.EMP_CODE = a.PBI_ID
            JOIN hrm_schedule_info s ON a.shedule_1 = s.id
            JOIN personnel_basic_info p ON a.PBI_ID = p.PBI_ID
            WHERE d.type != 2
            AND d.xdate IN (d.xdate, DATE_ADD(d.xdate, INTERVAL 1 DAY))
            AND a.roster_date BETWEEN '$start_date' AND '$end_date'
            AND d.xtime BETWEEN DATE_ADD(CONCAT(a.roster_date, ' ', s.office_start_time), INTERVAL s.min_in HOUR)
            AND DATE_ADD(CONCAT(a.roster_date, ' ', s.office_start_time), INTERVAL s.max_out HOUR)
            $job_location_con $emp_id_con $department_con
            GROUP BY a.PBI_ID, a.roster_date";
			
	
	
	
	$query = db_query($sql);



while ($data = mysqli_fetch_object($query)) {
    $value[$data->PBI_ID][$data->roster_date] = [
        'sch_in_time' => $sch_start[$data->shedule_1],
        'sch_mid_time' => $sch_mid[$data->shedule_1],
        'sch_mid_time_end' => $sch_mid_end[$data->shedule_1],
        'sch_out_time' => $sch_end[$data->shedule_1],
        'emp_id' => $data->EMP_CODE,
        'att_date' => $data->roster_date,
        'sch_id' => $data->shedule_1,
        'in_time' => $data->in_time,
        'out_time' => ($data->in_time != $data->out_time) ? $data->out_time : null
    ];
}



    $start = strtotime($_POST['s_date']);
    $end = strtotime($_POST['e_date']);

    $sqll = "SELECT p.PBI_ID, d.type, a.roster_date
            FROM hrm_attdump d
            JOIN hrm_roster_allocation a ON d.EMP_CODE = a.PBI_ID
            JOIN hrm_schedule_info s ON a.shedule_1 = s.id
            JOIN personnel_basic_info p ON a.PBI_ID = p.PBI_ID
            WHERE d.type != 2
            AND d.xdate IN (d.xdate, DATE_ADD(d.xdate, INTERVAL 1 DAY))
            AND a.roster_date BETWEEN '$start_date' AND '$end_date'
            AND d.xtime BETWEEN DATE_ADD(CONCAT(a.roster_date, ' ', s.office_start_time), INTERVAL s.min_in HOUR)
            AND DATE_ADD(CONCAT(a.roster_date, ' ', s.office_start_time), INTERVAL s.max_out HOUR)
            $job_location_con $emp_id_con $department_con
            GROUP BY a.PBI_ID, a.roster_date";

    $queryy = db_query($sqll);
    
	
	while ($datas = mysqli_fetch_object($queryy)) {
        for ($i = $start; $i <= $end; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $found = find_a_field('hrm_att_summary', '1', 'emp_id="'.$datas->PBI_ID.'" and att_date="'.$thisDate.'"');
            if ($found == 0) {
                $sql = "INSERT INTO hrm_att_summary 
                        (emp_id, att_date, sch_id, in_time, out_time, dayname, sch_in_time, sch_mid_time, sch_mid_endTime, sch_out_time)
                        VALUES 
                        ('".$datas->PBI_ID."', '".$thisDate."', '".$value[$datas->PBI_ID][$thisDate]['sch_id']."', '".$value[$datas->PBI_ID][$thisDate]['in_time']."', '".$value[$datas->PBI_ID][$thisDate]['out_time']."', 
                         dayname('".$thisDate."'), '".$value[$datas->PBI_ID][$thisDate]['sch_in_time']."', 
                         '".$value[$datas->PBI_ID][$thisDate]['sch_mid_time']."', 
                         '".$value[$datas->PBI_ID][$thisDate]['sch_mid_time_end']."', 
                         '".$value[$datas->PBI_ID][$thisDate]['sch_out_time']."')";
                         $query=db_query($sql);
            } else {
			
$sql='update hrm_att_summary set sch_id="'.$value[$datas->PBI_ID][$thisDate]['sch_id'].'",
in_time="'.$value[$datas->PBI_ID][$thisDate]['in_time'].'", out_time="'.$value[$datas->PBI_ID][$thisDate]['out_time'].'", sch_in_time="'.$value[$datas->PBI_ID][$thisDate]['sch_in_time'].'",
sch_mid_time="'.$value[$datas->PBI_ID][$thisDate]['sch_mid_time'].'",

sch_mid_endTime="'.$value[$datas->PBI_ID][$thisDate]['sch_mid_time_end'].'",

sch_out_time="'.$value[$datas->PBI_ID][$thisDate]['sch_out_time'].'" where  emp_id="'.$datas->PBI_ID.'" and att_date="'.$thisDate.'" ';
			$query=db_query($sql);
		
		}
		
		
		
		
		}

}

//echo 'Complete';

$msz = 'Machine Data Sync Complete';

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
    
    <? if($msz!=""){ ?>

<div class="alert alert-success" role="alert">

  <?=$msz;?>

</div>

<? }?>

    <div class="d-flex justify-content-center">

        <div class="n-form1 fo-width pt-0">
            <h4 class="text-center bg-titel bold pt-2 pb-2">      Collect Machine Data Factory  </h4>
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
			foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_CODE," - ",PBI_NAME)',$emp_id,'1');
			?>
                </datalist>
				
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company :    </label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                <select name="PBI_ORG"  id="PBI_ORG">

							  <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
						
							</select>
                            </div>
                        </div>

                    </div>


                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Location :    </label>
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
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department :    </label>
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
                                    <label for="group_for" 
                                    class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Start Date : </label>
                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                    
                                        <input type="date" name="s_date" id="s_date" value="<?= date('Y-m-d', strtotime('-1 day')); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">End Date :    </label>
                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                                        <input type="date" name="e_date" id="e_date" value="<?=date("Y-m-d");?>" autocomplete="off"/>

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



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>





