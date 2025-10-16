<?php 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';



$title = "Short Leave Application Form";
$page = "short_leave.php";


require_once '../assets/template/inc.header.php';


$u_id= $_SESSION['user']['id'];  //$_SESSION['user_id']; 
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$user_id	= $PBI_ID; //$_SESSION['user_id'];  

$_SESSION['employee_selected'] = $PBI_ID;

$essentialInfo = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);

$leave_status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);

$incharge_status = find_a_field('hrm_leave_info','incharge_status','id='.$_REQUEST['id']);


$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);



$today_date = date('Y-m-d');




if(isset($_POST['insert']))

{

//if(($_POST['half_leave_date']) < $today_date){
//$msggg= "<p style='color:#FF0000'>You can not apply back date leave <br></p>";
//}else{
$now= time();
$extention=explode('.',$_FILES['att_file']['name']);
$extention=strtolower(end($extention));
$target_dir = "picture/leave_files/";
$target_file = $target_dir . $$unique.'.'.$extention;
$projectId = array(2,3,4,5);
//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];

if(in_array($essentialInfo->ESSENTIAL_PROJECT, $projectId)){
$_REQUEST['PBI_DEPT_HEAD'] = 1007;}

$incharge = $PBI->incharge_id;
$leave_status = "Pending";
$incharge_status = "Pending";
$days = 0.5;
$leave_apply_date = $_POST['leave_apply_date'];
$leave_slot = $_POST['leave_slot'];
$entry_by = $PBI->PBI_ID;
$_POST['half_or_full'] = "Half";
$_POST['entry_at'] = date('Y-m-d H:i:s');



    $entry_at = date('Y-m-d H:i:s');
    $entry_by = $PBI->PBI_ID;
    $start_date = date('Y-m-d', strtotime($_POST['leave_apply_date']));
    $end_date = date('Y-m-d', strtotime($_POST['leave_apply_date']));
    $leave_join_date = date('Y-m-d', strtotime($_POST['leave_join_date']));
    $mon = date('m', strtotime($_POST['leave_apply_date']));
    $year = date('Y', strtotime($_POST['leave_apply_date']));
    $start = strtotime($_POST['s_date']);
    $end = strtotime($_POST['e_date']);
    $days_between = $_POST['total_days']; 


//$start_date = date('Y-m-d',strtotime($_POST['leave_apply_date']));
//$end_date   = date('Y-m-d',strtotime($_POST['leave_apply_date']));

if($_POST['leave_slot']=="Early Half"){
$_POST['sort_leave_start_time'] = '8:30';
$_POST['sort_leave_end_time']   = '12:45';

$_POST['s_time'] = '8:30';
$_POST['e_time']   = '12:45';

}else{
$_POST['sort_leave_start_time']= '12:45';
$_POST['sort_leave_end_time']   = '5:00';

$_POST['s_time'] = '12:45';
$_POST['e_time'] = '5:00';

}

if($_FILES['att_file']['tmp_name']!=""){
$_REQUEST['att_file']= $target_file;}

$leave_apply_date=date('Y-m-d');
//$crud->insert();

 $sql_master="INSERT INTO hrm_leave_info (leave_apply_date,PBI_IN_CHARGE,reporting_auth,incharge_status,PBI_ID,type,mon,year,s_date,e_date,total_days,reason,
 leave_status,entry_by,s_time,e_time,half_or_full,leave_slot,sort_leave_start_time,sort_leave_end_time,half_leave_date)

VALUES ('".$leave_apply_date."', '".$incharge."', '".$incharge."', '".$incharge_status."', '".$PBI_ID."', 'Short Leave (SHL)','".$_POST['mon']."','".$_POST['year']."', 
'".$start_date."','".$end_date."','".$days."','".$_POST['reason']."','".$leave_status."','".$entry_by."','".$_POST['s_time']."','".$_POST['e_time']."','".$_POST['half_or_full']."','".$_POST['leave_slot']."',
'".$_POST['sort_leave_start_time']."','".$_POST['sort_leave_end_time']."','".$_POST['half_leave_date']."')";

$insert = $conn->query($sql_master);

//move_uploaded_file($_FILES["att_file"]["tmp_name"], '../../'.$target_file);

/*$type=1;
$msg='New Entry Successfully Inserted.';*/
unset($_POST);
unset($$unique);

echo '<script type="text/javascript">parent.parent.document.location.href = "leave_status.php?notify=12";</script>';


//}

}



?>


    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
   
  
		
		
		

        <div class="card card-style">
			<form action=""  method="post">
				<div class="content">
				 <div class="row mb-0">
				  <div class="col-12">
				 <h4>Short Leave Application Form  <?php if (isset($msggg)) { echo $msggg; } ?></h4>
				 <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                        <input name="PBI_ID" id="PBI_ID" value="<?=$PBI_ID;?>" type="hidden" />
                                        <input name="mon" id="mon" value="<?=date('n')?>" type="hidden" />
                                        <input name="year" id="year" value="<?=date('Y')?>" type="hidden" />
					</div>
				 <div class="col-6">
					 <label for="form1" >Leave Types</label>
					 <input type="name" class="form-control validate-name" id="form1" value="Short Leave (SHL)" placeholder="Name">
				 
				 </div>
				  <div class="col-6">
				 	<label for="form5" >Leave Slot</label>
					<select id="form5" name="leave_slot" required="required">
						<option></option>
						<option <?= (isset($half_or_full) && $half_or_full == 'Early Half') ? 'Selected' : ''; ?>>Early Half</option>
						<option <?= (isset($half_or_full) && $half_or_full == 'Last Half') ? 'Selected' : ''; ?>>Last Half</option>
						</select>
				 </div>
				 
				 
				 <div class="col-6">
					 <label for="form1" >Leave Date</label>
					<input type="date" name="half_leave_date" id="half_leave_date" value="<?php if($half_leave_date) echo $half_leave_date; ?>" class="form-control validate-text"  placeholder="Leave Date">
				 
				 </div>
				  <div class="col-6">
				 	<label for="form5" >Reason</label>
					<textarea id="form7" name="reason"  placeholder="Reason" spellcheck="false" required></textarea>
				 </div>
				 
				   <div class="col-12">
				 	<label for="form5" >Supporting Doc</label>
						<input type="file" name="att_file" class="form-control validate-name" id="form1" placeholder="Supporting Doc">
				 </div>
				 
				 
				 <div class="col-6">
					 <label for="form5" >Sub Associate</label>
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
				 
				 </div>
				  <div class="col-6">
				 	<label for="form5" >Submission Date</label>
					<input type="date" name="leave_apply_date"  value="<?=$leave_apply_date?>" class="form-control validate-text" id="form6" 
						placeholder="Submission Date">
				 </div>
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 </div>
				
				
				
				
				
					
					
					
					 
					
					
					
					
					
					
					
					
				<!--	---------------------------->
	
					
					<div class="d-flex mt-3 justify-content-center row">

						<div class="col-6">
							<input type="submit" name="insert" class="btn btn-3d btn-m btn-full mb-0 b-n rounded-xs font-900 shadow-s btn-success w-100" value="Apply">
						</div>
					</div>
				</div>
			</form>
            </div>
			
			
			
			
			
			
			
			
			
			
        </div>
    <!-- End of Page Content--> 
    
    











<?php 
 require_once '../assets/template/inc.footer.php';
 ?>