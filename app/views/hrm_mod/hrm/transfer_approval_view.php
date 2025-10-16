<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";




// ::::: Edit This Section :::::





$title = 'Employee Transfer Approved';			// Page Name and Page Title



$page = "transfer_approval_view.php";		// PHP File Name



$root = 'transportation';



$table = 'transfer_detail';		// Database Table Name Mainly related to this page			



$unique ='TRANSFER_D_ID';					//Unique id





//user id

$u_id=$_SESSION['user']['id'];



$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);





	//Insert 







	if(isset($_POST['confirmm'])){



		 $sql="INSERT INTO vehicle_requisition (PBI_ID,req_no, req_date, v_date, prj_name, person, clnt_prf,clnt_org_name,land, pup, dop, emp_name, mb_no, v_s_t, nop)







		VALUES ('".$PBI_ID."','".$_POST['req_no']."', '".$_POST['req_date']."', '".$_POST['v_date']."', '".$_POST['prj_name']."', '".$_POST['person']."', '".$_POST['clnt_prf']."', '".$_POST['clnt_org_name']."','".$_POST['land']."', 



		'".$_POST['pup']."','".$_POST['dop']."','".$_POST['emp_name']."','".$_POST['mb_no']."','".$_POST['v_s_t']."',



		'".$_POST['nop']."')";



		



		$query=db_query($sql);



   header("Location:separation_request_form.php");

   exit; // Make sure to exit after the redirect



}















?>

<?


 $username = find_a_field('user_activity_management','fname','user_id='.$u_id);
$record_id = $_GET['id'];
// Fetch the record data
$sql = "SELECT * FROM `transfer_detail` WHERE `TRANSFER_D_ID` = '$record_id'";
$query = db_query($sql);
$data = mysqli_fetch_object($query);
$all_data=find_all_field('transfer_detail','','TRANSFER_D_ID='.$record_id);

if (isset($_POST['update'])) {
    $approve_by=$_SESSION['user']['id'];
	$approve_at=date('Y-d-m h:i:sa');

    $update_sql = "UPDATE transfer_detail SET status = 'CHECKED',approve_by='".$approve_by."',approve_at='".$approve_at."' WHERE TRANSFER_D_ID = '$record_id'";
    $upd_sql = db_query($update_sql);

    header('Location: transfer_approve.php');
}

if (isset($_POST['cancel'])) {
    $approve_by=$_SESSION['user']['id'];
	$approve_at=date('Y-d-m h:i:sa');

    $update_sql = "UPDATE transfer_detail SET status = 'CANCEL',approve_by='".$approve_by."',approve_at='".$approve_at."' WHERE TRANSFER_D_ID = '$record_id'";
    $upd_sql = db_query($update_sql);

    header('Location: transfer_approve.php');
}
?>


 <style>
        .card {
            margin-top: 50px;
        }
        .card-header {
            background: linear-gradient(45deg, #1717cf, #2B2BFF, #5656FF);
            color: white;
        }
    </style>
</head>
<body>
        <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>View and Change Status</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="full_name">Present Organization Name:</label>
                            <input type="text" name="TRANSFER_PAST_ORG" id="TRANSFER_PAST_ORG" class="form-control" value="<?=find_a_field('user_group','group_name','id='.$all_data->TRANSFER_PAST_ORG); ?>" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="separationdate">New Organization Name:</label>
                            <input type="text" id="separationdate" class="form-control" value="<?=find_a_field('user_group','group_name','id='.$all_data->TRANSFER_PRESENT_ORG); ?>" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="separationreason">Present Job Location:</label>
                            <input type="text" id="separationreason" class="form-control" value="<?=find_a_field('job_location_type','job_location_name','id='.$all_data->TRANSFER_PAST_JOB_LOCATION); ?>" disabled>
                        </div>
						<div class="form-group col-md-6">
                            <label for="separationreason">New Job Location:</label>
                            <input type="text" id="separationreason" class="form-control" value="<?= find_a_field('job_location_type','job_location_name','id='.$all_data->TRANSFER_PRESENT_JOB_LOCATION); ?>" disabled>
                        </div>
						<div class="form-group col-md-6">
                            <label for="separationreason">Present Dept:</label>
                            <input type="text" id="separationreason" class="form-control" value="<?= find_a_field('department','DEPT_DESC','DEPT_ID='.$all_data->TRANSFER_PAST_DEPT); ?>" disabled>
                        </div>
						<div class="form-group col-md-6">
                            <label for="separationreason">New Dept:</label>
                            <input type="text" id="separationreason" class="form-control" value="<?= find_a_field('department','DEPT_DESC','DEPT_ID='.$all_data->TRANSFER_PRESENT_DEPT); ?>" disabled>
                        </div>
						<div class="form-group col-md-6">
                            <label for="separationreason">Present Region:</label>
                            <input type="text" id="separationreason" class="form-control" value="<?= $data->separationreason == 1 ? 'Resignation' : ($data->separationreason == 2 ? 'Retirement' : 'No data'); ?>" disabled>
                        </div>
						<div class="form-group col-md-6">
                            <label for="separationreason">New Region:</label>
                            <input type="text" id="separationreason" class="form-control" value="<?= find_a_field('department','DEPT_DESC','DEPT_ID='.$all_data->TRANSFER_PRESENT_DEPT); ?>" disabled>
                        </div>
						<div class="form-group col-md-6">
                            <label for="separationreason">Present Zone:</label>
                            <input type="text" id="separationreason" class="form-control" value="<?= find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$all_data->TRANSFER_PAST_BRANCH); ?>" disabled>
                        </div>
						<div class="form-group col-md-6">
                            <label for="separationreason">New Zone:</label>
                            <input type="text" id="separationreason" class="form-control" value="<?= find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$all_data->TRANSFER_PRESENT_BRANCH); ?>" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="comments">Present Area:</label>
                            <input type="text" name="current_status" id="current_status" value="<?= find_a_field('area','AREA_NAME','AREA_CODE='.$all_data->TRANSFER_PAST_AREA); ?>" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="current_status">New Area:</label>
                            <input type="text" name="current_status" value="<?= find_a_field('area','AREA_NAME','AREA_CODE='.$all_data->TRANSFER_PRESENT_AREA); ?>" id="current_status" class="form-control">
                        </div>
						<div class="justify-content-center d-flex mt-3" >
                        
							<button type="submit" name="update" class="btn btn-primary">Approved</button>
							<button type="submit" name="cancel" class="btn btn-danger">Cancel</button>
					 </div>
                </form>
            </div>
        </div>
    </div>













<!-- Include Bootstrap CSS and JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>











<?
 require_once SERVER_CORE."routing/layout.bottom.php";
?>