<?php 

session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Leave Application Form";
$page = "leave.php";

$u_id= $_SESSION['user']['id'];  //$_SESSION['user_id']; //
$PBI_ID = find_a_field('ss_user','user_id','user_id='.$u_id);
$user_id	= $PBI_ID; //$_SESSION['user_id'];

require_once '../assets/template/inc.header.php';

$root='leave';

$table='hrm_leave_info';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='type';				// For a New or Edit Data a must have data field

$g_s_date=date('Y-01-01');

$g_e_date=date('Y-12-31');

do_calander('#leave_apply_date');

$unique_name = md5(uniqid(rand(), true));	

$_SESSION['employee_selected'] = $PBI_ID;

$essentialInfo = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);

$leave_status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);

$incharge_status = find_a_field('hrm_leave_info','incharge_status','id='.$_REQUEST['id']);

$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);

$leave_rule = find_all_field('hrm_leave_rull_manage', '', '1');   

$lv_days_casual = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=1 and `leave_status` IN ("PENDING","GRANTED") and s_date between "' . $g_s_date . '" and "' . $g_e_date . '" and PBI_ID=' .$PBI_ID);
$lv_days_sick   = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=2 and `leave_status` IN ("PENDING","GRANTED")  and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$PBI_ID);
$lv_days_annual   = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=3 and `leave_status` IN ("PENDING","GRANTED")  and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$PBI_ID);
$lv_days_marrage  = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=4 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$PBI_ID);
$lv_days_maternity  = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=5 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$PBI_ID);
$lv_days_paternity  = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=6 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$PBI_ID);
$hj_days = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=7 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$PBI_ID);
$old_leave = find_a_field('hrm_att_summary', 'leave_id', 'leave_id>0 and att_date between "' . $_POST['s_date'] . '" and  "' . $_POST['e_date'] . '" and emp_id="' .$PBI_ID. '"');

if(isset($_POST['save_leave'])) {
	
    $now = time();

    $projectId = array(2, 3, 4, 5);

    $incharge = $PBI->incharge_id;

    if(in_array($essentialInfo->ESSENTIAL_PROJECT, $projectId)) {
        $_REQUEST['PBI_DEPT_HEAD'] = 111659;
    }

    $leave_status = "Pending";
    $incharge_status = "Pending";
    $leave_apply_date = $_POST['leave_apply_date'];
    $entry_at = date('Y-m-d H:i:s');
    $entry_by = $PBI->PBI_ID;
    $start_date = date('Y-m-d', strtotime($_POST['s_date']));
    $end_date = date('Y-m-d', strtotime($_POST['e_date']));
    $leave_join_date = date('Y-m-d', strtotime($_POST['leave_join_date']));
    $mon = date('m', strtotime($_POST['leave_apply_date']));
    $year = date('Y', strtotime($_POST['leave_apply_date']));
    $start = strtotime($_POST['s_date']);
    $end = strtotime($_POST['e_date']);
    $days_between = $_POST['total_days']; // ceil(abs($start - $end) / 86400);

    if($_FILES['att_file']['tmp_name'] != '') {
        $file_name = $_FILES['att_file']['name'];
        $file_tmp = $_FILES['att_file']['tmp_name'];
        $ext = end(explode('.', $file_name));
        $path = '../file/leave_file/';
        move_uploaded_file($file_tmp, $path.$max_id.'.'.$ext);
    }

    if ($old_leave > 0) {
        $msggg = "<h4 class='alert alert-danger'>You Can't Add Duplicate Leave</h4>";
    }
    elseif (($_POST['type'] == 1) && (($lv_days_casual + $days_between) > $leave_rule->CL)) {
        $msggg = "<h4 class='alert alert-danger'>You Can't apply Casual Leave (CL) more than the limit</h4>";
    }
    elseif (($_POST['type'] == 2) && (($lv_days_sick + $days_between) > $leave_rule->MED)) {
        $msggg = "<h4 class='alert alert-danger'>You Can't apply Sick Leave (SL) more than the limit</h4>";
    }
    elseif (($_POST['type'] == 3) && (($lv_days_annual + $days_between) > $leave_rule->ANU)) {
        $msggg = "<h4 class='alert alert-danger'>You Can't apply Annual Leave (AL) more than the limit</h4>";
    }
    elseif (($_POST['type'] == 4) && (($lv_days_marrage + $days_between) > $leave_rule->ML)) {
        $msggg = "<h4 class='alert alert-danger'>You Can't apply Marriage Leave (ML) more than the limit</h4>";
    }
    elseif (($_POST['type'] == 5) && (($lv_days_maternity + $days_between) > $leave_rule->MTR)) {
        $msggg = "<h4 class='alert alert-danger'>You Can't apply Maternity Leave (MLV) more than the limit</h4>";
    }
    elseif (($_POST['type'] == 6) && (($lv_days_paternity + $days_between) > $leave_rule->PL)) {
        $msggg = "<h4 class='alert alert-danger'>You Can't apply Paternity Leave (PL) more than the limit</h4>";
    }
    elseif (($_POST['type'] == 7) && (($hj_days + $days_between) > $leave_rule->HL)) {
        $msggg = "<h4 class='alert alert-danger'>You Can't apply Hajj Leave (HL) more than the limit</h4>";
    }
    else {
        $sql_master = "INSERT INTO hrm_leave_info (leave_apply_date, PBI_IN_CHARGE, reporting_auth, incharge_status, PBI_ID, type, mon, year, s_date,
		 e_date, total_days, reason, leave_status, entry_by)
            VALUES ('".$leave_apply_date."', '".$incharge."', '".$incharge."', '".$incharge_status."', '".$PBI_ID."', '".$_POST['type']."', '".$mon."', 
			'".$year."', '".$start_date."', '".$end_date."', '".$days_between."', '".$_POST['reason']."', '".$leave_status."', '".$entry_by."')";

        $insert = $conn->query($sql_master);

        unset($_POST);
        unset($$unique);
        echo '<script type="text/javascript">parent.parent.document.location.href = "leave_status.php?notify=12";</script>';
    }
}

?>








<!-- main page content -->

<!-- start of Page Content-->  
<div class="page-content header-clear-medium">
    <div class="card card-style">
        <form action="leave.php" method="post" id="form1">
            <div class="content">
                
                
                <!-- Leave Types -->
             		<div class="row">
						<div class="col-12">
						<label for="form5" >Leave Types :</label>
                    <select name="type" id="type">
                        <option value="">Select Leave Type</option>
                        <option value="1">Casual Leave (CL)</option>
                        <option value="2">Sick Leave (SL)</option>
                        <option value="3">Annual Leave (AL)</option>
                        
                    </select>
						</div>
						
						<div class="col-6">
    <label for="s_date">Duration From</label>
    <input type="date" name="s_date" id="s_date" class="form-control validate-text" onclick="openDatePicker(this)" onchange="calculateTotalDays()" style="cursor: pointer;" >
</div>
						<div class="col-6">
						 <label for="e_date" >Duration To</label>
					<input type="date" name="e_date" id="e_date" class="form-control validate-text" onclick="openDatePicker(this)" onchange="calculateTotalDays()" style="cursor: pointer;" >
   
						</div>
						<div class="col-6">
						 <label for="form6" >Total Days </label>
						   <input type="text" name="total_days"  class="form-control validate-text" id="total_days" readonly="readonly">
						</div>
						<div class="col-6">
						<label for="form7" >Reason</label>
						  <textarea id="form7" placeholder="Reason" name="reason"></textarea>
						</div>
						<div class="col-6">
						  <label for="form6">Submission Date </label>
						  <input type="date" name="leave_apply_date" id="form6" value="<?=$leave_apply_date?>" class="form-control validate-text" onclick="openDatePicker(this)"  style="cursor: pointer;" >
						</div>
						<div class="col-6">
						 <label for="form6" >Joining Date After Leave </label>
						   
						   <input type="date" name="leave_join_date" id="leave_join_date" value="<?php if($leave_join_date) echo $leave_join_date; ?>" class="form-control validate-text" onclick="openDatePicker(this)" style="cursor: pointer;" >
						</div>
					</div>
                    
                    
               <!-- Start Date -->
<div class="input-style has-borders no-icon mb-4 input-style-active">
    
    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
</div>

<!-- End Date -->
<div class="input-style has-borders no-icon mb-4 input-style-active">
   
    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
</div>


       <div class="input-style has-borders no-icon mb-4 input-style-active">
                  
                   
                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                </div>
                         
       

                <!-- Reason -->
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                  
                    
                    <em class="mt-n3">(required)</em>
                </div>

                <!-- Submission Date -->
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    
                  
                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                </div>
				
				
				   
				
				

                <!-- Joining Date After Leave -->
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                  
                   
                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                </div>

                <!-- Substitute Associate -->
                <!--<div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="form5" class="color-highlight">Substitute Associate :</label>
                    <select name="leave_responsibility_name" id="leave_responsibility_name">
                        <option value="1019">Abu Hasan :: Software Engineer</option>
                        <option value="1004">Al Amin Ali Dawan :: Team Leader</option>
                        <option value="1001">Bimol Chandra Das :: Chief Technical Officer(CTO)</option>
                        <option value="1011">Chandan Das :: Software Engineer</option>
                        <option value="1008">Iftekhar Wahid(Srabon) :: Chief Technical Officer(CTO)</option>
                        <option value="1018">Jahirul Islam :: Software Engineer</option>
                        <option value="1017">Jobaraj Miah :: Software Engineer</option>
                        <option value="1002">Kawsar Mahmud :: Team Leader</option>
                        <option value="1021">Mainul Islam Himel :: Software Engineer</option>
                        <option value="1003">Md. Kamrul Hasan :: Team Leader</option>
                        <option value="1005">Payer Alam Rony :: Team Leader</option>
                        <option value="10117">Pintu  :: Jr. Software Engineer</option>
                        <option value="30015">Shakil :: Software Engineer</option>
                        <option value="1013">SK Akash :: Software Engineer</option>
                        <option value="1010">Tanjil Khandokar :: Software Engineer</option>
                        <option value="1016">Tariqul Islam :: Software Engineer</option>
                    </select>
                    <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>-->

                <!-- Supporting Document -->
                <!--<div class="input-style has-borders no-icon mb-4 input-style-active">
                    <input type="file" name="att_file" class="form-control validate-name" id="form1" placeholder="Supporting Doc">
                    <label for="form1" class="color-highlight">Supporting Doc</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>-->
                
                <!-- Submit Button -->
                <div class="d-flex justify-content-center row">
                    <div class="col-6">
                        <input type="submit" name="save_leave" id="save_leave" value="Apply" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-mint-dark bg-mint-dark w-100">
                    </div>
                </div>
                
                <!-- Display Messages -->
                <?php if (isset($msggg)) { echo $msggg; } ?>
            </div>
        </form>
    </div>
</div>
<!-- End of Page Content--> 


<script>
    function calculateTotalDays() {
        // Get the start and end date values
        const startDate = document.getElementById('s_date').value;
        const endDate = document.getElementById('e_date').value;

        // Check if both dates are selected
        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);

            // Calculate the difference in time and add 1 to include both days
            const timeDifference = end - start;
            const totalDays = (timeDifference / (1000 * 3600 * 24)) + 1;

            // Display total days in the input field
            document.getElementById('total_days').value = totalDays;
        } else {
            // Clear the total days field if one or both dates are not selected
            document.getElementById('total_days').value = '';
        }
    }
</script>

<script>
function openDatePicker(input) {
    if (input.showPicker) {
        input.showPicker();
    } else {
        input.focus();
        input.click();
    }
}
</script>

<?php 
 require_once '../assets/template/inc.footer.php';
?>
