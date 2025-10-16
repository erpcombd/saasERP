<?php 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$title = "IOM Entry Form";
$page = "iom_entry.php";


require_once '../assets/template/inc.header.php';

$u_id= $_SESSION['user']['id']; //$_SESSION['user_id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$user_id	= $PBI_ID; //$_SESSION['user_id'];




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
$leave_apply_date = $_POST['s_date'];
$entry_at= date('Y-m-d H:i:s');

$entry_by = $PBI->PBI_ID;
$start_date = date('Y-m-d',strtotime($_POST['s_date']));


$end_date   = date('Y-m-d',strtotime($_POST['e_date']));
$mon = date('m',strtotime($_POST['s_date']));
$year = date('Y',strtotime($_POST['s_date']));

$start = strtotime($_POST['s_date']);
$end  = strtotime($_POST['e_date']);

$days_between = ceil(abs($start - $end) / 86400)+1;






if($_FILES['att_file']['tmp_name']!=''){
$file_name= $_FILES['att_file']['name'];
$file_tmp= $_FILES['att_file']['tmp_name'];
$ext=end(explode('.',$file_name));
$path='../file/leave_file/';
move_uploaded_file($file_tmp, $path.$max_id.'.'.$ext);
}

if($_POST['type'] =='Early Half'){

	 $s_time = '08:30';

	 $e_time = '12:45';

	}elseif($_POST['type']=='Last Half'){

		$s_time = '12:45';

		$e_time = '17:00';

		}elseif($_POST['type']=='Full'){

		$s_time = '08:30';

		$e_time = '17:00';

		}


  $sql_master="INSERT INTO hrm_iom_info (iom_apply_date,PBI_IN_CHARGE,PBI_DEPT_HEAD,dept_head_status,PBI_ID,type,mon,year,s_date,e_date,total_days,reason,iom_status,entry_by,s_time,e_time)

VALUES ('".$leave_apply_date."', '".$incharge."','".$incharge."','".$incharge_status."', '".$PBI_ID."', '".$_POST['type']."','".$mon."','".$year."', '".$start_date."',

'".$end_date."','".$days_between."','".$_POST['reason']."','".$leave_status."','".$entry_by."','".$s_time."','".$e_time."')";



    $insert = $conn->query($sql_master);




    unset($_POST);

    unset($$unique);

    echo '<script type="text/javascript">parent.parent.document.location.href = "iom_status.php?notify=12";</script>';

}





?>

    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
   
   


		
		
		

        <div class="card card-style">
			<form action="iom_entry.php" method="post">
				<div class="content">

					 <div class="row mb-0">
					<div class="col-12">
						<label for="form2" >Employee Code</label>
						 <input name="PBI_ID" type="text"   class="form-control validate-text"  value="<?=$PBI_ID?>"  placeholder="Employee Code"  readonly />
					</div>
					
					<div class="col-6">
						<label for="form6" >Date Form</label>
						<input type="date" name="s_date" value="<?php if($s_date=='') echo ''; else echo $s_date ; ?>" class="form-control validate-text" id="form6" placeholder="Date Form">
					</div>
					
					
					<div class="col-6">
						<label for="form6" >Date To</label>
						<input type="date" name="e_date" value="<?php if($e_date=='') echo ''; else echo $e_date ; ?>" class="form-control validate-text" id="form6" placeholder="Date To">
					</div>
					
					
					<div class="col-6">
						<label for="form6" >IOM Type </label>
						<select name="type" id="type" >
						<option></option>

                                <option>Full</option>

                                <option>Early Half</option>

                                <option>Last Half</option>
						</select>
					</div>
					
					
					<div class="col-6">
						<label for="form6" >Reason</label>
						<textarea id="form7" name="reason"  placeholder="Reason" spellcheck="false" required></textarea>
					</div>
					
					
					</div>
		
					<div class="d-flex justify-content-center row">

						<div class="col-6">
							   <input type="submit" name="save_leave"  class="btn btn-3d btn-m btn-full mb-0 mt-3 b-n rounded-xs font-900 shadow-s btn-success w-100" id="form1"  value="Apply">
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