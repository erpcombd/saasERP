<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
//include 'config/db.php';
//include 'config/function.php';
include '../config/access.php';

$u_id= $_SESSION['user']['id'];  //$_SESSION['user_id']; //
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$user_id	= $PBI_ID; //$_SESSION['user_id'];

$page="do_unfinished";
include "../inc/header.php";
?>


<?



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
echo '<script type="text/javascript">parent.parent.document.location.href = "home.php?notify=12";</script>';
}


?>
	<!-- main page content -->



	<div class="main-container container">







		<!-- User list items  -->



		<div class="row">



			<div class="row text-center mb-2"><h4> Leave Application Form</h4></div>









			<div class="row" style="margin: 0 auto;">



				<div class="card">



					<form action="leave.php" method="post" style="padding:10px" id="form1">



						<div class="form-group pt-1 pb-1">

							<label for="date"> Leave Types :</label>

							<select class="form-control border border-info" name="type" id="type" required="">

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

						</div>







						<div class="form-group pt-1 pb-1">

							<label for="date">   Duration Form :</label>



							<input type="date" name="s_date" value="<?php if($s_date=='') echo ''; else echo $s_date ; ?>" class="form-control border border-info" tabindex="1">



						</div>







						<div class="form-group pt-1 pb-1">

							<label for="date">   Duration To :</label>



							<input type="date" name="e_date" id="e_date"  value="<?php if($e_date=='') echo ''; else echo $e_date ; ?>" class="form-control border border-info" tabindex="1">



						</div>





						<div class="form-group pt-1 pb-1">

							<label for="date"> Reason :</label>

							<textarea class="form-control border border-info" name="reason" required="" spellcheck="false"></textarea>

						</div>







						<div class="form-group pt-1 pb-1">

							<label for="date"> Submission Date :</label>



							<input type="date" name="leave_apply_date" class="form-control border border-info" tabindex="1" value="<?=$leave_apply_date?>" >



						</div>





						<div class="form-group pt-1 pb-1">

							<label for="date">Joining Date After Leave :</label>



							<input type="date" name="tdate" class="form-control border border-info" tabindex="1" id="leave_join_date" value="<?php if($leave_join_date) echo $leave_join_date; ?>">



						</div>





						<div class="form-group pt-1 pb-1">

							<label for="date"> Substitute Associate :</label>

							<select class="form-control border border-info"  name="leave_responsibility_name" id="leave_responsibility_name" >

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

						</div>



						<div class="form-group pt-1 pb-1">

							<label for="date">Supporting Doc : </label>



							<input class="form-control border border-info" type="file" name="att_file">



						</div>













						<div align="center" class="class pt-3 pb-3">



							<input type="submit" name="save_leave" id="save_leave" class="btn btn-info" id="form1" value="Apply">



						</div>



					</form>



				</div>



			</div>











		</div>









	</div>



	<!-- main page content ends -->



	<!-- Page ends-->







<?php include "../inc/footer.php"; ?>