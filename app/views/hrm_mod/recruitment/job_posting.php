<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Job Posting';// Page Name and Page Title
$page="job_posting.php";	// PHP File Name
$input_page="job_posting_input.php";
$root='hrm';
$table='job_requisitions';		// Database Table Name Mainly related to this page
$unique='id';	// Primary Key of this Database table
$shown='job_title';	// For a New or Edit Data a must have data field
// ::::: End Edit Section :::::

$crud = new crud($table);

// Fetch all job requisitions for the table view
$sql = "SELECT * FROM $table ORDER BY created_at DESC";
$job_list = db_query($sql);

// Post Starts from here
if(isset($_POST['insert'])){	
    // Process the form submission
    $crud->insert();
    $type=1;
    $msg='New Job Requisition Successfully Created.';
    unset($_POST);
}

// Fetch existing record if editing
if(isset($$unique)){
    $condition=$unique."=".$$unique;
    $data=db_fetch_object($table,$condition);
    foreach($data as $key => $value) {
        $$key=$value;
    }
}
?>

<style>
    /* Main styling */
    body {
        background-color: #f8f9fa;
    }
    
    .form-section, .table-section {
        background: #ffffff;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        margin-top: 2rem;
        margin-bottom: 2rem;
        border-top: 4px solid #1e3a8a;
    }
    
    .form-section h3, .table-section h3 {
        margin-bottom: 1.5rem;
        color: #1e3a8a;
        font-weight: 600;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 500;
        color: #374151;
    }
    
    .btn-primary {
        background-color: #1e3a8a;
        border: none;
        padding: 0.8rem;
        font-size: 1rem;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #172c66;
    }
    
    .navbar-brand {
        font-weight: 600;
        color: #fff !important;
    }
    
    .navbar-nav .nav-link {
        color: #fff !important;
        font-weight: 500;
    }
    
    .navbar-nav .nav-link:hover {
        color: #d1d5db !important;
    }
    
    /* Table styling */
    .table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    
    .table th {
        background-color: #f3f4f6;
        color: #1f2937;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.05em;
        padding: 1rem;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }
    
    .table tr:hover {
        background-color: #f9fafb;
    }
    
    /* Status badges */
    .badge {
        padding: 0.5em 0.8em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 6px;
    }
    
    .badge-open {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .badge-closed {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .badge-hold {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    /* Modal styling */
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
    
    .modal-header {
        background-color: #1e3a8a;
        color: white;
        border-radius: 12px 12px 0 0;
        padding: 1.5rem;
    }
    
    .modal-title {
        font-weight: 600;
    }
    
    .modal-body {
        padding: 2rem;
    }
    
    .detail-label {
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 0.3rem;
    }
    
    .detail-value {
        margin-bottom: 1.5rem;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .btn-action {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        border-radius: 6px;
    }
</style>

<!-- Table View Section -->
<div class="container mt-4">
    <div class="table-section">
        <div class="section-header">
            <h3>Job Requisitions</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createJobModal">
                <i class="fas fa-plus-circle me-2"></i> Create New Job
            </button>
        </div>
        
        <?php if(isset($msg)){ ?>
        <div class="alert alert-success" role="alert">
            <?php echo $msg; ?>
        </div>
        <?php } ?>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Department</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(!empty($job_list)) {
                        foreach($job_list as $job) { 
                    ?>
                    <tr>
                        <td><?php echo $job['job_title']; ?></td>
                        <td><?php echo $job['department']; ?></td>
                        <td><?php echo $job['location']; ?></td>
                        <td><?php echo $job['employment_type']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($job['application_deadline'])); ?></td>
                        <td>
                            <span class="badge <?php echo 'badge-'.strtolower($job['status']); ?>">
                                <?php echo $job['status']; ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-secondary btn-action view-job" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#viewJobModal" 
                                    data-id="<?php echo $job['id']; ?>"
                                    data-title="<?php echo $job['job_title']; ?>"
                                    data-department="<?php echo $job['department']; ?>"
                                    data-location="<?php echo $job['location']; ?>"
                                    data-type="<?php echo $job['employment_type']; ?>"
                                    data-education="<?php echo $job['minimum_education']; ?>"
                                    data-experience="<?php echo $job['years_experience']; ?>"
                                    data-skills="<?php echo $job['required_skills']; ?>"
                                    data-deadline="<?php echo date('M d, Y', strtotime($job['application_deadline'])); ?>"
                                    data-description="<?php echo htmlspecialchars($job['job_description']); ?>"
                                    data-status="<?php echo $job['status']; ?>">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="7" class="text-center">No job requisitions found. Create your first job posting!</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Job Modal -->
<div class="modal fade" id="createJobModal" tabindex="-1" aria-labelledby="createJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createJobModalLabel">Create New Job Requisition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <!-- Job Details Section -->
                    <h5 class="mb-3 text-primary">Job Details</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="job_title" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="job_title" name="job_title" placeholder="Enter job title" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-select" id="department" name="department" required>
                                    <option value="">Select department</option>
                                    <option value="IT">Information Technology</option>
                                    <option value="HR">Human Resources</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Marketing">Marketing</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="employment_type" class="form-label">Employment Type</label>
                                <select class="form-select" id="employment_type" name="employment_type" required>
                                    <option value="">Select employment type</option>
                                    <option value="Full-Time">Full-Time</option>
                                    <option value="Part-Time">Part-Time</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Internship">Internship</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="minimum_education" class="form-label">Minimum Education</label>
                                <select class="form-select" id="minimum_education" name="minimum_education" required>
                                    <option value="">Select education level</option>
                                    <option value="Bachelor">Bachelor's Degree</option>
                                    <option value="Master">Master's Degree</option>
                                    <option value="PhD">PhD</option>
                                    <option value="Diploma">Diploma</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Qualifications Section -->
                    <h5 class="mt-4 mb-3 text-primary">Qualifications</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="years_experience" class="form-label">Years of Experience</label>
                                <input type="number" class="form-control" id="years_experience" name="years_experience" placeholder="Enter years of experience" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="required_skills" class="form-label">Required Skills</label>
                                <input type="text" class="form-control" id="required_skills" name="required_skills" placeholder="e.g., PHP, JavaScript" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="application_deadline" class="form-label">Application Deadline</label>
                                <input type="date" class="form-control" id="application_deadline" name="application_deadline" required>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <h5 class="mt-4 mb-3 text-primary">Additional Information</h5>
                    <div class="form-group">
                        <label for="job_description" class="form-label">Job Description</label>
                        <textarea class="form-control" id="job_description" name="job_description" rows="4" placeholder="Provide a detailed description of the role" required></textarea>
                    </div>

                    <!-- Hidden fields for metadata -->
                    <input type="hidden" name="created_by" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '0'; ?>">
                    <input type="hidden" name="status" value="Open">

                    <!-- Submit Button -->
                    <div class="text-center mt-4">
                        <button type="submit" name="insert" class="btn btn-primary">Create Job Requisition</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- View Job Modal -->
<div class="modal fade" id="viewJobModal" tabindex="-1" aria-labelledby="viewJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewJobModalLabel">Job Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <h4 id="modal-job-title" class="text-primary"></h4>
                        <span id="modal-job-status" class="badge badge-open"></span>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <p class="detail-label">Department</p>
                        <p id="modal-department" class="detail-value"></p>
                    </div>
                    <div class="col-md-4">
                        <p class="detail-label">Location</p>
                        <p id="modal-location" class="detail-value"></p>
                    </div>
                    <div class="col-md-4">
                        <p class="detail-label">Employment Type</p>
                        <p id="modal-type" class="detail-value"></p>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <p class="detail-label">Minimum Education</p>
                        <p id="modal-education" class="detail-value"></p>
                    </div>
                    <div class="col-md-4">
                        <p class="detail-label">Years of Experience</p>
                        <p id="modal-experience" class="detail-value"></p>
                    </div>
                    <div class="col-md-4">
                        <p class="detail-label">Application Deadline</p>
                        <p id="modal-deadline" class="detail-value"></p>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <p class="detail-label">Required Skills</p>
                        <p id="modal-skills" class="detail-value"></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <p class="detail-label">Job Description</p>
                        <div id="modal-description" class="detail-value"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to populate the modal -->
<!-- JavaScript to populate the modal -->



<!-- JavaScript to populate the modal -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all view job buttons
    const viewButtons = document.querySelectorAll('.view-job');
    
    // Add click event to each button
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get data from button attributes
            const jobId = this.getAttribute('data-id');
            const jobTitle = this.getAttribute('data-title');
            const department = this.getAttribute('data-department');
            const location = this.getAttribute('data-location');
            const type = this.getAttribute('data-type');
            const education = this.getAttribute('data-education');
            const experience = this.getAttribute('data-experience');
            const skills = this.getAttribute('data-skills');
            const deadline = this.getAttribute('data-deadline');
            const description = this.getAttribute('data-description');
            const status = this.getAttribute('data-status');
            
            // Debug - check if data is being retrieved
            console.log("Job data:", {jobId, jobTitle, department, location, type, education, experience, skills, deadline, description, status});
            
            // Populate modal with job data - using safer approach with optional chaining
            if(document.getElementById('modal-job-title')) document.getElementById('modal-job-title').textContent = jobTitle || '';
            if(document.getElementById('modal-department')) document.getElementById('modal-department').textContent = department || '';
            if(document.getElementById('modal-location')) document.getElementById('modal-location').textContent = location || '';
            if(document.getElementById('modal-type')) document.getElementById('modal-type').textContent = type || '';
            if(document.getElementById('modal-education')) document.getElementById('modal-education').textContent = education || '';
            if(document.getElementById('modal-experience')) document.getElementById('modal-experience').textContent = (experience ? experience + ' years' : '');
            if(document.getElementById('modal-skills')) document.getElementById('modal-skills').textContent = skills || '';
            if(document.getElementById('modal-deadline')) document.getElementById('modal-deadline').textContent = deadline || '';
            if(document.getElementById('modal-description')) document.getElementById('modal-description').textContent = description || '';
            
            // Set status badge
            const statusBadge = document.getElementById('modal-job-status');
            if(statusBadge) {
                statusBadge.textContent = status || 'Open';
                statusBadge.className = 'badge badge-' + (status ? status.toLowerCase() : 'open');
            }
            
            // Manually show the modal
            const viewJobModal = new bootstrap.Modal(document.getElementById('viewJobModal'));
            viewJobModal.show();
        });
    });
    
    // Fix for Create Job Modal
    const createJobBtn = document.querySelector('[data-bs-target="#createJobModal"]');
    if (createJobBtn) {
        createJobBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var createJobModal = new bootstrap.Modal(document.getElementById('createJobModal'));
            createJobModal.show();
        });
    }
});
</script>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>