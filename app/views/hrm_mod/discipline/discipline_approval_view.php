<?php



session_start();



ob_start();



require_once "../../../assets/support/inc.all.php";




// ::::: Edit This Section :::::





$title = 'discipline Status Change';			// Page Name and Page Title



$page = "discipline_approval_view.php";		// PHP File Name



$root = 'discipline';



$table = 'disciplinary_action';		// Database Table Name Mainly related to this page			



$unique ='id';					//Unique id





//user id

$u_id=$_SESSION['user']['id'];



$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);





	//Insert 







	if(isset($_POST['confirmm'])){



		 $sql="INSERT INTO vehicle_requisition (PBI_ID,req_no, req_date, v_date, prj_name, person, clnt_prf,clnt_org_name,land, pup, dop, emp_name, mb_no, v_s_t, nop)







		VALUES ('".$PBI_ID."','".$_POST['req_no']."', '".$_POST['req_date']."', '".$_POST['v_date']."', '".$_POST['prj_name']."', '".$_POST['person']."', '".$_POST['clnt_prf']."', '".$_POST['clnt_org_name']."','".$_POST['land']."', 



		'".$_POST['pup']."','".$_POST['dop']."','".$_POST['emp_name']."','".$_POST['mb_no']."','".$_POST['v_s_t']."',



		'".$_POST['nop']."')";



		



		$query=mysql_query($sql);



   header("Location:separation_request_form.php");

   exit; // Make sure to exit after the redirect



}















?>

<?


 $username = find_a_field('user_activity_management','fname','user_id='.$u_id);
$record_id = $_GET['id'];
// Fetch the record data
$sql = "SELECT * FROM `disciplinary_action` WHERE `id` = '$record_id'";
$query = mysql_query($sql);
$data = mysql_fetch_object($query);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['new_status'];

    $update_sql = "UPDATE `disciplinary_action` SET `status` = '$new_status' WHERE `id` = '$record_id'";
    $upd_sql = mysql_query($update_sql);

    if ($upd_sql) {
        echo "<script>alert('Status updated successfully'); window.location.href = 'discipline_approve.php';</script>";
    } else {
        echo "<script>alert('Failed to update status');</script>";
    }
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
                        <div class="form-group col-md-12">
                            <label for="full_name">Full Name:</label>
                            <input type="text" id="PBI_ID" class="form-control" value="<?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$data->PBI_ID);
; ?>" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="separationdate">Date of Incident:</label>
                            <input type="text" id="dateIncident" class="form-control" value="<?= date('d-M-Y', strtotime($data->dateIncident)); ?>" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="separationreason">Witness:</label>
                            <input type="text" id="witnesses" class="form-control" value="<?= $data->witnesses; ?>" disabled>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="comments">Comments:</label>
                            <textarea id="description" class="form-control" disabled><?= $data->description; ?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="current_status">Current Status:</label>
                            <input type="text" id="current_status" class="form-control" value="<?= $data->status == 1 ? 'Pending' : ($data->status == 2 ? 'Approved' : 'No data'); ?>" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="new_status">Change Status:</label>
                            <select name="new_status" id="new_status" class="form-control">
                                <option value="1" <?= $data->status == 1 ? 'selected' : ''; ?>>Pending</option>
                                <option value="2" <?= $data->status == 2 ? 'selected' : ''; ?>>Approved</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update </button>
                    <a href="discipline_approve.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>













<!-- Include Bootstrap CSS and JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>











<?



$main_content=ob_get_contents();



ob_end_clean();



include ("../../template/main_layout.php");



?>