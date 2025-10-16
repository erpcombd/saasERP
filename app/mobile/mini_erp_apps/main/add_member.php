<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";

$title = "Add Member";
$menu = 'home';
$page = "add_member.php";

require_once '../assets/template/inc.header.php';
?>


    <div class="container-fluid py-3 mt-5 pt-3">
        <div class="card mx-auto" style="max-width: 500px;">
            <!-- Header -->
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-danger">Add new member</h5>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
            </div>
            
            <!-- Form Body -->
            <div class="card-body">
                <!-- Tabs -->
                <ul class="nav nav-pills nav-fill mb-4" id="memberTabs">
                    <li class="nav-item">
                        <button class="nav-link active rounded-0" data-bs-toggle="pill" data-bs-target="#customer">
                            Customer
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-dark rounded-0" data-bs-toggle="pill" data-bs-target="#supplier">
                            Supplier
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-dark rounded-0" data-bs-toggle="pill" data-bs-target="#employee">
                            Employee
                        </button>
                    </li>
                </ul>

                <form id="memberForm" class="needs-validation" novalidate>
                    <!-- Profile Photo -->
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img id="profilePreview" 
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Crect width='100' height='100' fill='%23dee2e6'/%3E%3Cpath d='M65,36 A15,15 0 0,1 35,36 A15,15 0 0,1 65,36 M20,80 Q50,60 80,80' stroke='%23adb5bd' stroke-width='8' fill='none'/%3E%3C/svg%3E" 
                                 class="rounded-circle" 
                                 alt="Profile Photo" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            <input type="file" 
                                   id="photoInput" 
                                   class="d-none" 
                                   accept="image/*">
                        </div>
                        <div>
                            <a href="#" class="text-primary text-decoration-none" onclick="document.getElementById('photoInput').click(); return false;">
                                Add photo of user
                            </a>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="customer">
                            <!-- Customer Name -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Customer Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       name="customerName"
                                       placeholder="Customer Name" 
                                       required>

                                <div class="invalid-feedback">
                                    Please enter customer name
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="address"
                                       placeholder="Address">
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Phone Number
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="tel" 
                                       class="form-control" 
                                       name="phone"
                                       placeholder="Phone Number" 
                                       required>
                                <div class="invalid-feedback">
                                    Please enter phone number
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control" 
                                       name="email"
                                       placeholder="Email">
                                <div class="invalid-feedback">
                                    Please enter a valid email address
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="supplier">
                            <!-- Supplier form fields would go here -->
							
							<div class="mb-3">
                                <label class="form-label">
                                    Supplier Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       name="customerName"
                                       placeholder="Customer Name" 
                                       required>

                                <div class="invalid-feedback">
                                    Please enter supplier name
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="address"
                                       placeholder="Address">
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Phone Number
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="tel" 
                                       class="form-control" 
                                       name="phone"
                                       placeholder="Phone Number" 
                                       required>
                                <div class="invalid-feedback">
                                    Please enter phone number
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control" 
                                       name="email"
                                       placeholder="Email">
                                <div class="invalid-feedback">
                                    Please enter a valid email address
                                </div>
                            </div>
							 <div class="mb-3">
                                <label class="form-label">Supplier Items</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="supplierItems"
                                       placeholder="Supplier Items">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="employee">
                            <!-- Employee form fields would go here -->
							
							
							 <div class="mb-3">
                                <label class="form-label">
                                    Employee Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       name="customerName"
                                       placeholder="Customer Name" 
                                       required>

                                <div class="invalid-feedback">
                                    Please enter employee name
                                </div>
                            </div>
							<div class="mb-3">
                                <label class="form-label">Position
								<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       name="position"
                                       placeholder="Position">
                            </div>
                            <!-- Address -->
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="address"
                                       placeholder="Address">
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Phone Number
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="tel" 
                                       class="form-control" 
                                       name="phone"
                                       placeholder="Phone Number" 
                                       required>
                                <div class="invalid-feedback">
                                    Please enter phone number
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control" 
                                       name="email"
                                       placeholder="Email">
                                <div class="invalid-feedback">
                                    Please enter a valid email address
                                </div>
                            </div>
							<div class="mb-3">
                                <label class="form-label">Salary (Monthly)
								<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       name="salary"
                                       placeholder="Salary (Monthly)">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="card-footer bg-white py-3">
                <button type="submit" 
                        class="btn btn-danger w-100" 
                        form="memberForm">
                    Save
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Image Upload Preview
        document.getElementById('photoInput').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePreview').src = e.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Form Validation
        document.getElementById('memberForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            if (!this.checkValidity()) {
                event.stopPropagation();
            } else {
                // Form is valid, collect data
                const formData = new FormData(this);
                const data = Object.fromEntries(formData.entries());
                
                // Add the profile photo if one was selected
                const photoInput = document.getElementById('photoInput');
                if (photoInput.files.length > 0) {
                    data.profilePhoto = photoInput.files[0];
                }

                // Get the active tab
                const activeTab = document.querySelector('.nav-link.active').textContent.trim().toLowerCase();
                data.memberType = activeTab;

                // Here you would typically send the data to your server
                console.log('Form submitted:', data);
                
                // Show success message
                alert('Member added successfully!');
                
                // Reset form
                this.reset();
                document.getElementById('profilePreview').src = 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\'%3E%3Crect width=\'100\' height=\'100\' fill=\'%23dee2e6\'/%3E%3Cpath d=\'M65,36 A15,15 0 0,1 35,36 A15,15 0 0,1 65,36 M20,80 Q50,60 80,80\' stroke=\'%23adb5bd\' stroke-width=\'8\' fill=\'none\'/%3E%3C/svg%3E';
            }
            
            this.classList.add('was-validated');
        });
    </script>
 
<!-- End of Page Content-->

<? require_once '../assets/template/inc.footer.php'; ?>