<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Resume Screening';// Page Name and Page Title
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
        .resume-upload {
            border: 2px dashed #d1d5db; /* Light gray dashed border */
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }
        .resume-upload:hover {
            border-color: #1e3a8a; /* Highlight border on hover */
        }
        .shortlisted-candidates {
            background: #f3f4f6; /* Light gray background */
            padding: 1rem;
            border-radius: 10px;
            margin-top: 1.5rem;
        }
        .candidate-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .candidate-item:last-child {
            border-bottom: none;
        }
       
    
    </style>


    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="form-section">
                    <h3>Error-free Resume Screening</h3>
                    <p class="text-muted">Upload resumes and screen candidates based on predefined criteria.</p>

                    <!-- Resume Upload Section -->
                    <h5 class="mb-3 text-primary">Upload Resumes</h5>
                    <div class="resume-upload" onclick="document.getElementById('resumeUpload').click();">
                        <input type="file" id="resumeUpload" multiple style="display: none;" />
                        <i class="bi bi-cloud-upload" style="font-size: 3rem; color: #1e3a8a;"></i>
                        <p class="mt-2 mb-0">Drag and drop files here or click to upload</p>
                        <small class="text-muted">Supported formats: PDF, DOCX (Max 10MB)</small>
                    </div>

                    <!-- Screening Criteria Section -->
                    <h5 class="mt-4 mb-3 text-primary">Screening Criteria</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="requiredSkills" class="form-label">Required Skills</label>
                                <input type="text" class="form-control" id="requiredSkills" placeholder="e.g., PHP, JavaScript" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="minExperience" class="form-label">Minimum Years of Experience</label>
                                <input type="number" class="form-control" id="minExperience" placeholder="Enter years" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="educationLevel" class="form-label">Minimum Education Level</label>
                        <select class="form-select" id="educationLevel" required>
                            <option value="">Select education level</option>
                            <option value="Bachelor">Bachelor's Degree</option>
                            <option value="Master">Master's Degree</option>
                            <option value="PhD">PhD</option>
                            <option value="Diploma">Diploma</option>
                        </select>
                    </div>

                    <!-- Shortlisted Candidates Section -->
                    <h5 class="mt-4 mb-3 text-primary">Shortlisted Candidates</h5>
                    <div class="shortlisted-candidates">
                        <div class="candidate-item">
                            <span>John Doe</span>
                            <span class="badge bg-success">Shortlisted</span>
                        </div>
                        <div class="candidate-item">
                            <span>Jane Smith</span>
                            <span class="badge bg-danger">Rejected</span>
                        </div>
                        <div class="candidate-item">
                            <span>Emily Johnson</span>
                            <span class="badge bg-secondary">Pending</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mt-4">Screen Resumes</button>
                </div>
            </div>
        </div>
    </div>




<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
