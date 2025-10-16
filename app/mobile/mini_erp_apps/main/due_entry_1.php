<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Money Given Entry</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body class="bg-light">
    <div class="container-fluid p-0">
        <!-- Header -->
        <div class="bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add Money Given Entry</h5>
            <button type="button" class="btn-close" aria-label="Close"></button>
        </div>

        <!-- Main Content -->
        <div class="p-3">
            <!-- Tabs -->
            <div class="btn-group w-100 mb-4">
                <button type="button" class="btn btn-light active text-dark fw-medium">CUSTOMER</button>
                <button type="button" class="btn btn-light text-secondary">SUPPLIER</button>
                <button type="button" class="btn btn-light text-secondary">EMPLOYEE</button>
            </div>

            <form id="moneyEntryForm" class="needs-validation" novalidate>
                <!-- Date -->
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               id="dateInput"
                               value="February 20th, 2025" 
                               data-input>
                        <span class="input-group-text" data-toggle>
                            <i class="far fa-calendar"></i>
                        </span>
                    </div>
                </div>

                <!-- Cash Options -->
                <div class="mb-3">
                    <label class="form-label">Cash</label>
                    <div class="d-flex gap-3">
                        <div class="border rounded p-3 flex-grow-1" id="givenBox">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="cashOption" 
                                       id="given" 
                                       checked>
                                <label class="form-check-label" for="given">
                                    <div>Given</div>
                                    <small class="text-muted">You give money</small>
                                </label>
                            </div>
                        </div>
                        <div class="border rounded p-3 flex-grow-1" id="receivedBox">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="cashOption" 
                                       id="received">
                                <label class="form-check-label" for="received">
                                    <div>Received</div>
                                    <small class="text-muted">You received money</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Amount -->
                <div class="mb-3">
                    <label class="form-label">
                        Amount
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" 
                           class="form-control" 
                           placeholder="Amount"
                           required>
                    <div class="invalid-feedback">
                        Please enter amount
                    </div>
                </div>

                <!-- Customer Name -->
                <div class="mb-3">
                    <label class="form-label">
                        Customer Name
                        <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               id="customerInput"
                               placeholder="Customer Name"
                               required>
                        <button class="btn btn-outline-secondary" 
                                type="button"
                                data-bs-toggle="modal" 
                                data-bs-target="#customerModal">
                            <i class="fas fa-user"></i>
                        </button>
                    </div>
                    <div class="invalid-feedback">
                        Please enter customer name
                    </div>
                </div>

                <!-- Phone NO -->
                <div class="mb-3">
                    <label class="form-label">
                        Phone NO
                        <span class="text-danger">*</span>
                    </label>
                    <input type="tel" 
                           class="form-control" 
                           id="phoneInput"
                           placeholder="Phone NO"
                           required>
                    <div class="invalid-feedback">
                        Please enter phone number
                    </div>
                </div>

                <!-- Note -->
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               placeholder="Note">
                        <button class="btn btn-outline-secondary" 
                                type="button" 
                                id="attachButton">
                            <i class="fas fa-paperclip"></i>
                        </button>
                    </div>
                    <input type="file" 
                           id="attachmentInput" 
                           class="d-none" 
                           multiple>
                </div>

                <!-- SMS Toggle -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="smsToggle">
                        <label class="form-check-label" for="smsToggle">
                            Send SMS
                        </label>
                    </div>
                    <small class="text-success">SMS Balance 30</small>
                </div>

                <!-- Save Button -->
                <button type="submit" class="btn btn-dark w-100">Save</button>
            </form>
        </div>
    </div>

    <!-- Customer Search Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Find Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Search Input -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   id="customerSearch" 
                                   placeholder="Search customers...">
                        </div>
                    </div>
                    <!-- Customer List -->
                    <div class="list-group" id="customerList">
                        <!-- Sample customers - In production, this would be populated from a database -->
                        <button type="button" class="list-group-item list-group-item-action" data-phone="1234567890">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-1">John Doe</h6>
                                <small>1234567890</small>
                            </div>
                            <small class="text-muted">Last transaction: 2 days ago</small>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" data-phone="9876543210">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-1">Jane Smith</h6>
                                <small>9876543210</small>
                            </div>
                            <small class="text-muted">Last transaction: 5 days ago</small>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        // Initialize date picker
        flatpickr("#dateInput", {
            dateFormat: "F jS, Y",
            defaultDate: "today",
            allowInput: true,
            wrap: true
        });

        // Highlight selected cash option
        document.querySelectorAll('[name="cashOption"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('givenBox').classList.remove('border-primary');
                document.getElementById('receivedBox').classList.remove('border-primary');
                
                if (this.id === 'given') {
                    document.getElementById('givenBox').classList.add('border-primary');
                } else {
                    document.getElementById('receivedBox').classList.add('border-primary');
                }
            });
        });

        // Initialize with 'given' selected
        document.getElementById('givenBox').classList.add('border-primary');

        // Handle attachment button
        document.getElementById('attachButton').addEventListener('click', function() {
            document.getElementById('attachmentInput').click();
        });

        // Show selected file names
        document.getElementById('attachmentInput').addEventListener('change', function() {
            const files = Array.from(this.files).map(file => file.name).join(', ');
            if (files) {
                const noteInput = this.previousElementSibling.querySelector('input');
                noteInput.value = `Attached: ${files}`;
            }
        });

        // Customer search functionality
        document.getElementById('customerSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll('#customerList .list-group-item');
            
            items.forEach(item => {
                const name = item.querySelector('h6').textContent.toLowerCase();
                const phone = item.querySelector('small').textContent;
                if (name.includes(searchTerm) || phone.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Handle customer selection
        document.querySelectorAll('#customerList .list-group-item').forEach(item => {
            item.addEventListener('click', function() {
                const name = this.querySelector('h6').textContent;
                const phone = this.dataset.phone;
                
                document.getElementById('customerInput').value = name;
                document.getElementById('phoneInput').value = phone;
                
                bootstrap.Modal.getInstance(document.getElementById('customerModal')).hide();
            });
        });

        // Form validation and submission
        document.getElementById('moneyEntryForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            if (!this.checkValidity()) {
                event.stopPropagation();
            } else {
                const formData = new FormData(this);
                
                // Add file attachments if any
                const attachmentInput = document.getElementById('attachmentInput');
                if (attachmentInput.files.length > 0) {
                    Array.from(attachmentInput.files).forEach(file => {
                        formData.append('attachments[]', file);
                    });
                }

                // Add SMS preference
                formData.append('sendSMS', document.getElementById('smsToggle').checked);

                // Here you would typically send the data to your server
                console.log('Form submitted:', Object.fromEntries(formData.entries()));
                
                // Show success message
                alert('Transaction saved successfully!');
                
                // Reset form
                this.reset();
                document.getElementById('given').checked = true;
                document.getElementById('givenBox').classList.add('border-primary');
                document.getElementById('receivedBox').classList.remove('border-primary');
            }
            
            this.classList.add('was-validated');
        });
    </script>
</body>
</html>