<?php 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$title = "Leave Application Form";
$page = "leave.php";

$u_id= $_SESSION['user']['id'];  //$_SESSION['user_id']; //
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
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





if(isset($_POST['save_leave']))

{
	
$now= time();

$projectId = array(2,3,4,5);

$incharge = $PBI->incharge_id; //$essentialInfo->ESSENTIAL_REPORTING;

if(in_array($essentialInfo->ESSENTIAL_PROJECT, $projectId)){

$_REQUEST['PBI_DEPT_HEAD'] = 111659;}

$leave_status = "Pending";

$incharge_status = "Pending";

$leave_apply_date = $_POST['leave_apply_date'];

$entry_at= date('Y-m-d H:i:s');

$entry_by = $PBI->PBI_ID;

$start_date = date('Y-m-d',strtotime($_POST['s_date']));

$end_date   = date('Y-m-d',strtotime($_POST['e_date']));

$leave_join_date = date('Y-m-d',strtotime($_POST['leave_join_date']));

$mon = date('m',strtotime($_POST['leave_apply_date']));
$year = date('Y',strtotime($_POST['leave_apply_date']));

$start = strtotime($_POST['s_date']);

$end  = strtotime($_POST['e_date']);

$days_between = ceil(abs($start - $end) / 86400);

if($_FILES['att_file']['tmp_name']!=''){

$file_name= $_FILES['att_file']['name'];

$file_tmp= $_FILES['att_file']['tmp_name'];

$ext=end(explode('.',$file_name));

$path='../file/leave_file/';

move_uploaded_file($file_tmp, $path.$max_id.'.'.$ext);

}


echo $sql_master="INSERT INTO hrm_leave_info (leave_apply_date,PBI_IN_CHARGE,reporting_auth,incharge_status,PBI_ID,type,mon,year,s_date,e_date,total_days,reason,leave_status,entry_by)

VALUES ('".$leave_apply_date."', '".$incharge."', '".$incharge."', '".$incharge_status."', '".$PBI_ID."', '".$_POST['type']."','".$mon."','".$year."', '".$start_date."',
'".$end_date."','".$days_between."','".$_POST['reason']."','".$leave_status."','".$entry_by."')";

 $insert = $conn->query($sql_master);




//$crud->insert();

unset($_POST);
unset($$unique);
echo '<script type="text/javascript">parent.parent.document.location.href = "../main/home.php?notify=12";</script>';
}


?>
	<!-- main page content -->


    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
   
   

		
		
		

        <div class="card card-style">
			<form action="leave.php" method="post" id="form1">
				<div class="content">
					<h4>Leave Application Form</h4> </br>
				
		  <div class="input-style has-borders no-icon mb-4">
		      
            <div class="input-style has-borders input-style-always-active has-icon validate-field mb-4"> <i class="color-green-dark fa fa-calendar-alt"></i>
             	            <select name="type" id="type">
							<option value=""></option>

								<option value="1">Casual Leave (CL)</option>

								<option value="2">Sick Leave (SL)</option>

								<option value="3">Annual Leave (AL)</option>

								<option value="4">Marriage Leave (ML)</option>

								<option value="6">Paternity Leave (PL)</option>

								<option value="7">Hajj Leave</option>

								<option value="8">Extra Ordinary Leave (EOL)</option>

								<option value="9">Leave Without Pay (LWP)</option>
						</select>
              <label for="shedule_1" class="color-blue-dark">Leave Type</label>
              <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> </div>
          </div>
					
					
					
									
		<div class="row mb-0">
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 mt-1">Duration Form</label>
            <input type="date" style="width:100%" name="s_date" class="form-control validate-text" id="s_date">
          </div>
        </div>
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 mt-1">Duration To </label>
            <input type="date" style="width:100%" name="e_date" class="form-control validate-text" id="e_date">
          </div>
        </div>
      </div>
      
    
			
			
	   <div class="row mb-0">
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 mt-1">Total Days</label>
              <input type="text" style="width:100%" name="total_days" class="form-control validate-text" id="total_days" readonly>
          </div>
        </div>
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 mt-1">Reason</label>
            <input type="text" id="form7" name="reason" placeholder="Reason">
          </div>
        </div>
      </div>		
					
					
					
					
		<div class="row mb-0">
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 mt-1">Submission Date</label>
            <input type="date" style="width:100%" name="leave_apply_date" class="form-control validate-text" id="form-6">
          </div>
        </div>
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 mt-1">Joining Date After Leave </label>
            <input type="date" style="width:100%" name="tdate" class="form-control validate-text" id="form-6">
          </div>
        </div>
      </div>
      
      
					
					
			
					
					
					
										<div class="input-style has-borders no-icon mb-4">
						<label for="form5" class="color-highlight">Substitute Associate :</label>
					<select name="leave_responsibility_name" id="leave_responsibility_name">		
			 <option value=""></option>
              <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $assign_person, '1'); ?>
            </select>
			
			
						
						<span><i class="fa fa-chevron-down"></i></span>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<i class="fa fa-check disabled invalid color-red-dark"></i>
						<em></em>
					</div>
					
					
					
					<div class="input-style has-borders has-icon validate-field mb-4">
						<input type="file"  name="att_file" class="form-control validate-name" id="form1" placeholder="Supporting Doc">
						<label for="form1" class="color-highlight">Supporting Doc</label>
						<i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div>
					
	<!------------------------------>
					
	
					
	
				
	
	
			
	
	
					
					<div class="d-flex justify-content-center row">
						<div class="col-6">
							<input type="submit" name="save_leave" id="save_leave" value="Apply" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-mint-dark bg-mint-dark w-100">
						</div>
					</div>
				</div>
			</form>
            </div>
			
			
			
			
			
			
			
			
			
        </div>
    <!-- End of Page Content--> 
    
    


<script>
document.getElementById('s_date').addEventListener('change', calculateDays);
document.getElementById('e_date').addEventListener('change', calculateDays);

function calculateDays() {
    const s_date = document.getElementById('s_date').value;
    const e_date = document.getElementById('e_date').value;

    if (s_date && e_date) {
        const startDate = new Date(s_date);
        const endDate = new Date(e_date);
        const timeDiff = endDate.getTime() - startDate.getTime();
     
        const totalDays = (timeDiff / (1000 * 3600 * 24)) + 1;
        
        document.getElementById('total_days').value = totalDays >= 0 ? totalDays : 0;
    } else {
        document.getElementById('total_days').value = '';
    }
}


</script>








<?php 
 require_once '../assets/template/inc.footer.php';
 ?>