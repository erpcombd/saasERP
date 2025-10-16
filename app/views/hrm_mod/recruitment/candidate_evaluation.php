<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Candidate Evaluation';// Page Name and Page Title
$page="pf_status.php";	// PHP File Name
$input_page="pf_status_input.php";
$root='hrm';
$table='pf_status';		// Database Table Name Mainly related to this page
$unique='PF_STATUS_ID';	// Primary Key of this Database table
$shown='PF_STATUS_CV';	// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

$crud = new crud($table);
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);
$required_id = find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;



// Post Starts from here

//if(isset($_POST[$shown])){	
	if(isset($_POST['insert'])){	
	
		

	$_POST['PBI_ID']=$_SESSION['employee_selected'];
	$folder='hrm_pf_status'; 
	$field = 'PBI_CV_ATT_PATH'; 

//$file_name = $folder.'-'.$_SESSION['employee_selected'];


if($_FILES['PBI_CV_ATT_PATH']['tmp_name']!=''){



    $_POST['file_type'] = find_a_field('hrm_pf_type_info','file_type','id='.$_POST['type']); //$_POST['type']; 
	$_POST['file_path'] = find_a_field('hrm_pf_type_info','file_path','id='.$_POST['type']); //$_POST['type'];   
	$_POST['status'] = $_POST['PF_STATUS_CV'];
    $file_name = ''.$_POST['file_path'].'-'.$_SESSION['employee_selected'];	
	$_POST['file_path']=upload_file($folder,$field,$file_name);



}

	$crud->insert();
	$type=1;
	$msg='New Entry Successfully Inserted.';
	unset($_POST);
	unset($$unique);

	$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
	if($required_id>0)
	$$unique = $_GET[$unique] = $required_id;

}
	
	
if(isset($$unique)){

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach($data as $key => $value)

{ $$key=$value;}

}

?>

    <style>
       
        .form-section {
            background: #ffffff; /* Clean white background for form */
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            margin-top: 3rem;
        }
        .form-section h3 {
            margin-bottom: 1.5rem;
            color: #1e3a8a; /* Professional blue color */
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 500;
            color: #374151; /* Dark gray for labels */
        }
        .btn-primary {
            background-color: #1e3a8a; /* Professional blue button */
            border: none;
            padding: 0.8rem;
            font-size: 1rem;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #172c66; /* Darker shade on hover */
        }
        .evaluation-score {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .score-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e3a8a;
        }
        .evaluation-summary {
            background: #f3f4f6; /* Light gray background */
            padding: 1rem;
            border-radius: 10px;
            margin-top: 1.5rem;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .summary-item:last-child {
            border-bottom: none;
        }
    </style>


    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-section">
                    <h3>Candidate Evaluation Process</h3>
                    <p class="text-muted">Evaluate candidates based on predefined criteria and provide feedback.</p>

                    <!-- Candidate Details Section -->
                    <h5 class="mb-3 text-primary">Candidate Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="candidateName" class="form-label">Candidate Name</label>
                                <input type="text" class="form-control" id="candidateName" placeholder="Enter candidate name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jobRole" class="form-label">Job Role</label>
                                <input type="text" class="form-control" id="jobRole" placeholder="Enter job role" required>
                            </div>
                        </div>
                    </div>

                    <!-- Evaluation Criteria Section -->
                    <h5 class="mt-4 mb-3 text-primary">Evaluation Criteria</h5>
                    <div class="evaluation-score">
                        <span>Technical Skills</span>
                        <div class="score-value">/10</div>
                    </div>
                    <input type="range" class="form-range" id="technicalSkills" min="0" max="10" value="5">

                    <div class="evaluation-score">
                        <span>Communication Skills</span>
                        <div class="score-value">/10</div>
                    </div>
                    <input type="range" class="form-range" id="communicationSkills" min="0" max="10" value="5">

                    <div class="evaluation-score">
                        <span>Problem-Solving Abilities</span>
                        <div class="score-value">/10</div>
                    </div>
                    <input type="range" class="form-range" id="problemSolving" min="0" max="10" value="5">

                    <div class="evaluation-score">
                        <span>Cultural Fit</span>
                        <div class="score-value">/10</div>
                    </div>
                    <input type="range" class="form-range" id="culturalFit" min="0" max="10" value="5">

                    <!-- Feedback Section -->
                    <h5 class="mt-4 mb-3 text-primary">Feedback</h5>
                    <div class="form-group">
                        <label for="feedback" class="form-label">Provide Feedback</label>
                        <textarea class="form-control" id="feedback" rows="4" placeholder="Provide detailed feedback about the candidate"></textarea>
                    </div>

                    <!-- Final Recommendation Section -->
                    <h5 class="mt-4 mb-3 text-primary">Final Recommendation</h5>
                    <div class="form-group">
                        <label for="recommendation" class="form-label">Recommendation</label>
                        <select class="form-select" id="recommendation" required>
                            <option value="">Select recommendation</option>
                            <option value="Hire">Hire</option>
                            <option value="Reject">Reject</option>
                            <option value="Hold">Hold for Further Review</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mt-4">Submit Evaluation</button>

                    <!-- Evaluation Summary Section -->
                    <h5 class="mt-4 mb-3 text-primary">Evaluation Summary</h5>
                    <div class="evaluation-summary">
                        <div class="summary-item">
                            <span>John Doe</span>
                            <span class="badge bg-success">Hire</span>
                        </div>
                        <div class="summary-item">
                            <span>Jane Smith</span>
                            <span class="badge bg-danger">Reject</span>
                        </div>
                        <div class="summary-item">
                            <span>Emily Johnson</span>
                            <span class="badge bg-secondary">Hold</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
