<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Create Your CV';// Page Name and Page Title
$page="candidate_invitation_process.php";	// PHP File Name
$input_page="candidate_invitation_input.php";
$root='hrm';
$table='candidate_profiles';		// Database Table Name Mainly related to this page
$unique='candidate_id';	// Primary Key of this Database table
$shown='full_name';	// For a New or Edit Data a must have data field
// ::::: End Edit Section :::::

$crud = new crud($table);

// Generate unique token for new candidates
if(!isset($$unique)) {
    $token = md5(uniqid(rand(), true));
}

// Post Starts from here
if(isset($_POST['insert'])){	
    // Add token and timestamp to the form data
    $_POST['token'] = $token;
    $_POST['created_at'] = date('Y-m-d H:i:s');
    
    // Process the form submission
    $crud->insert();
    $type=1;
    $msg='Candidate Profile Successfully Created.';
    
    // Store the candidate ID for CV generation
    $new_candidate_id = mysqli_insert_id($conn);
    
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

// Fetch existing candidates for the table view
$sql = "SELECT * FROM $table ORDER BY created_at DESC";
$candidate_list = db_query($sql);
?>

<style>
    /* Main styling */
    body {
        background-color: #f8f9fa;
    }
    
    .form-section, .table-section, .cv-preview {
        background: #ffffff;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        margin-top: 2rem;
        margin-bottom: 2rem;
        border-top: 4px solid #1e3a8a;
    }
    
    .form-section h3, .table-section h3, .cv-preview h3 {
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
    
    .cv-preview {
        max-height: 600px;
        overflow-y: auto;
    }
    
    .cv-preview h4 {
        color: #1e3a8a;
        font-weight: 600;
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
    
    .token-badge {
        background-color: #e5e7eb;
        color: #4b5563;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-family: monospace;
    }
</style>

<!-- Main Content -->
<div class="container mt-4">
    <?php if(isset($msg)){ ?>
    <div class="alert alert-success" role="alert">
        <?php echo $msg; ?>
    </div>
    <?php } ?>

    <div class="row">
        <div class="col-lg-12">
            <!-- Candidate List Section -->
            <div class="table-section">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Candidate Profiles</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCandidateModal">
                        <i class="fas fa-plus-circle me-2"></i> Add New Candidate
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Experience</th>
                                <th>Created Date</th>
                                <th>Token</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(!empty($candidate_list)) {
                                foreach($candidate_list as $candidate) { 
                            ?>
                            <tr>
                                <td><?php echo $candidate['full_name']; ?></td>
                                <td><?php echo $candidate['email']; ?></td>
                                <td><?php echo $candidate['phone']; ?></td>
                                <td><?php echo $candidate['work_experience_years']; ?> years</td>
                                <td><?php echo date('M d, Y', strtotime($candidate['created_at'])); ?></td>
                                <td><span class="token-badge"><?php echo substr($candidate['token'], 0, 8); ?>...</span></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-secondary view-cv" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewCVModal" 
                                            data-id="<?php echo $candidate['candidate_id']; ?>">
                                        <i class="fas fa-eye"></i> View CV
                                    </button>
                                </td>
                            </tr>
                            <?php 
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="7" class="text-center">No candidate profiles found. Add your first candidate!</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Candidate Modal -->
<div class="modal fade" id="createCandidateModal" tabindex="-1" aria-labelledby="createCandidateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCandidateModalLabel">Create Candidate Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="candidateForm" enctype="multipart/form-data">
                    <!-- Personal Information -->
                    <h5 class="mb-3 text-primary">Personal Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                            </div>
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <h5 class="mt-4 mb-3 text-primary">Work Experience</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="work_experience_years" class="form-label">Years of Experience</label>
                                <input type="number" class="form-control" id="work_experience_years" name="work_experience_years" placeholder="Enter years of experience" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_position" class="form-label">Current Position</label>
                                <input type="text" class="form-control" id="current_position" name="current_position" placeholder="Enter current position">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="work_experience_details" class="form-label">Work Experience Details</label>
                        <textarea class="form-control" id="work_experience_details" name="work_experience_details" rows="3" placeholder="e.g., Software Developer at XYZ Company (2020 - Present)"></textarea>
                    </div>

                    <!-- Education -->
                    <h5 class="mt-4 mb-3 text-primary">Education</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="highest_degree" class="form-label">Highest Degree</label>
                                <select class="form-select" id="highest_degree" name="highest_degree" required>
                                    <option value="">Select highest degree</option>
                                    <option value="High School">High School</option>
                                    <option value="Associate's Degree">Associate's Degree</option>
                                    <option value="Bachelor's Degree">Bachelor's Degree</option>
                                    <option value="Master's Degree">Master's Degree</option>
                                    <option value="Doctorate">Doctorate</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="graduation_year" class="form-label">Graduation Year</label>
                                <input type="number" class="form-control" id="graduation_year" name="graduation_year" placeholder="Enter graduation year">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="education_details" class="form-label">Education Details</label>
                        <textarea class="form-control" id="education_details" name="education_details" rows="3" placeholder="e.g., Bachelor's Degree in Computer Science, ABC University (2016 - 2020)"></textarea>
                    </div>

                    <!-- Skills -->
                    <h5 class="mt-4 mb-3 text-primary">Skills</h5>
                    <div class="form-group">
                        <label for="skills" class="form-label">Skills (Separate with commas)</label>
                        <input type="text" class="form-control" id="skills" name="skills" placeholder="e.g., JavaScript, Python, Leadership">
                    </div>

                    <!-- Additional Information -->
                    <h5 class="mt-4 mb-3 text-primary">Additional Information</h5>
                    <div class="form-group">
                        <label for="additional_info" class="form-label">Additional Information</label>
                        <textarea class="form-control" id="additional_info" name="additional_info" rows="3" placeholder="e.g., Certifications, Projects, Achievements"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-4">
                        <button type="submit" name="insert" class="btn btn-primary">Create Candidate Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View CV Modal -->
<div class="modal fade" id="viewCVModal" tabindex="-1" aria-labelledby="viewCVModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCVModalLabel">Candidate CV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="cv-preview" id="modalCvPreview">
                    <!-- CV Content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="downloadCV">Download CV</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fix for modal not opening - add direct click handler
    const addNewCandidateBtn = document.querySelector('[data-bs-target="#createCandidateModal"]');
    if (addNewCandidateBtn) {
        addNewCandidateBtn.addEventListener('click', function() {
            const modal = document.getElementById('createCandidateModal');
            // Try using Bootstrap 5 modal method
            try {
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            } catch (error) {
                console.error('Bootstrap modal error:', error);
                // Fallback for older Bootstrap versions or if bootstrap object is not available
                $(modal).modal('show');
            }
        });
    }

    // View CV button click handler
    const viewButtons = document.querySelectorAll('.view-cv');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const candidateId = this.getAttribute('data-id');
            
            // AJAX request to get candidate details
            fetch(`get_candidate_details.php?id=${candidateId}`)
                .then(response => response.json())
                .then(data => {
                    // Generate CV content
                    const cvContent = `
                        <div class="cv-content">
                            <h4>${data.full_name}</h4>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Phone:</strong> ${data.phone}</p>
                            <p><strong>Address:</strong> ${data.address}</p>
                            
                            <hr class="my-4">
                            
                            <h5 class="text-primary">Work Experience</h5>
                            <p><strong>Current Position:</strong> ${data.current_position || 'N/A'}</p>
                            <p><strong>Years of Experience:</strong> ${data.work_experience_years} years</p>
                            <div class="mb-3">
                                <strong>Experience Details:</strong>
                                <p>${data.work_experience_details || 'No details provided'}</p>
                            </div>
                            
                            <hr class="my-4">
                            
                            <h5 class="text-primary">Education</h5>
                            <p><strong>Highest Degree:</strong> ${data.highest_degree}</p>
                            <p><strong>Graduation Year:</strong> ${data.graduation_year || 'N/A'}</p>
                            <div class="mb-3">
                                <strong>Education Details:</strong>
                                <p>${data.education_details || 'No details provided'}</p>
                            </div>
                            
                            <hr class="my-4">
                            
                            <h5 class="text-primary">Skills</h5>
                            <p>${data.skills ? data.skills.split(',').map(skill => 
                                `<span class="badge bg-light text-dark me-2 mb-2 p-2">${skill.trim()}</span>`
                            ).join('') : 'No skills listed'}</p>
                            
                            <hr class="my-4">
                            
                            <h5 class="text-primary">Additional Information</h5>
                            <p>${data.additional_info || 'No additional information provided'}</p>
                            
                            <div class="mt-4 text-muted">
                                <small>CV Token: ${data.token}</small><br>
                                <small>Created: ${new Date(data.created_at).toLocaleDateString('en-US', {
                                    year: 'numeric', 
                                    month: 'long', 
                                    day: 'numeric'
                                })}</small>
                            </div>
                        </div>
                    `;
                    
                    // Update the modal content
                    document.getElementById('modalCvPreview').innerHTML = cvContent;
                    
                    // Initialize the download button
                    document.getElementById('downloadCV').onclick = function() {
                        // Create a printable version of the CV
                        const printContent = `
                            <!DOCTYPE html>
                            <html>
                            <head>
                                <title>CV - ${data.full_name}</title>
                                <style>
                                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                                    .container { max-width: 800px; margin: 0 auto; padding: 20px; }
                                    h1, h2, h3, h4, h5 { color: #1e3a8a; }
                                    hr { border: 0; border-top: 1px solid #eee; margin: 20px 0; }
                                    .badge { display: inline-block; background: #f3f4f6; padding: 5px 10px; margin: 2px; border-radius: 4px; }
                                </style>
                            </head>
                            <body>
                                <div class="container">
                                    ${document.getElementById('modalCvPreview').innerHTML}
                                </div>
                            </body>
                            </html>
                        `;
                        
                        // Create a Blob with the HTML content
                        const blob = new Blob([printContent], { type: 'text/html' });
                        const url = URL.createObjectURL(blob);
                        
                        // Create a link and trigger download
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `CV_${data.full_name.replace(/\s+/g, '_')}.html`;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        URL.revokeObjectURL(url);
                    };
                })
                .catch(error => {
                    console.error('Error fetching candidate details:', error);
                    document.getElementById('modalCvPreview').innerHTML = `
                        <div class="alert alert-danger">
                            Error loading candidate data. Please try again later.
                        </div>
                    `;
                });
        });
    });
    // Add form submission handler
    const candidateForm = document.getElementById('candidateForm');
    if (candidateForm) {
        candidateForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('save_candidate.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('createCandidateModal'));
                    modal.hide();
                    
                    // Show success message and reload page
                    alert('Candidate profile created successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving candidate profile');
            });
        });
    }
    // Initialize Bootstrap modals
    const createCandidateModal = document.getElementById('createCandidateModal');
    if (createCandidateModal) {
        createCandidateModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('full_name').focus();
        });
    }
    
    // Close button handlers
    const closeButtons = document.querySelectorAll('[data-bs-dismiss="modal"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    });
});
</script>

<script>
// Check if Bootstrap is loaded properly
document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap JS is not loaded. Adding it dynamically.');
        const bootstrapScript = document.createElement('script');
        bootstrapScript.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js';
        bootstrapScript.integrity = 'sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p';
        bootstrapScript.crossOrigin = 'anonymous';
        document.body.appendChild(bootstrapScript);
    }
});
</script>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>