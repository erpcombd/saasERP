/**
 * HRM Analytics Dashboard - PHP Integration
 * 
 * This file demonstrates how to connect the dashboard.js with the dashboard_data.php
 * to fetch real data from the database instead of using mock data.
 * 
 * Replace the chart initialization functions in dashboard.js with these functions
 * to enable PHP data integration.
 */

// Load all data when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Display current date
    const currentDate = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('currentDate').textContent = currentDate.toLocaleDateString('en-US', options);
    
    // Load employees and departments for dropdowns
    loadEmployeesList();
    loadDepartmentsList();
    
    // Initialize all charts with PHP data
    loadHeadcount();
    loadGenderDistribution();
    loadAgeDistribution();
    loadOrganizationAttendance();
    loadIndividualAttendance('emp001'); // Default employee
    loadIndividualLeave('emp001'); // Default employee
    loadConveyanceSummary('emp001'); // Default employee
    loadPendingRequests();
    loadUpcomingBirthdays();
    
    // Set up event listeners
    setupEventListeners();
});

/**
 * Load total headcount and animate counter
 */
function loadHeadcount() {
    fetch('dashboard_data.php?request=headcount')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const total = data.data.total;
                animateCounter('totalHeadcount', 0, total, 2000);
            } else {
                console.error('Error loading headcount:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load gender distribution data and initialize chart
 */
function loadGenderDistribution() {
    fetch('dashboard_data.php?request=gender_distribution')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('genderDistributionChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: data.data,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.label}: ${context.raw}%`;
                                    }
                                }
                            }
                        },
                    }
                });
            } else {
                console.error('Error loading gender distribution:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load age distribution data and initialize chart
 */
function loadAgeDistribution() {
    fetch('dashboard_data.php?request=age_distribution')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('ageDistributionChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: data.data,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        },
                    }
                });
            } else {
                console.error('Error loading age distribution:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load organization attendance data and initialize chart
 * @param {string} department - Optional department filter
 */
function loadOrganizationAttendance(department = 'All') {
    fetch(`dashboard_data.php?request=organization_attendance&department=${department}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('organizationAttendanceChart').getContext('2d');
                
                // Store chart instance in global variable for later updates
                window.organizationAttendanceChart = new Chart(ctx, {
                    type: 'bar',
                    data: data.data,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Employees'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Attendance Status'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } else {
                console.error('Error loading organization attendance:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load individual attendance data and initialize chart
 * @param {string} employeeId - Employee ID
 */
function loadIndividualAttendance(employeeId) {
    fetch(`dashboard_data.php?request=individual_attendance&employee_id=${employeeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('individualAttendanceChart').getContext('2d');
                
                // Store chart instance in global variable for later updates
                if (window.individualAttendanceChart) {
                    window.individualAttendanceChart.data = data.data;
                    window.individualAttendanceChart.update();
                } else {
                    window.individualAttendanceChart = new Chart(ctx, {
                        type: 'line',
                        data: data.data,
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Days'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Month'
                                    }
                                }
                            }
                        }
                    });
                }
            } else {
                console.error('Error loading individual attendance:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load individual leave data and initialize chart
 * @param {string} employeeId - Employee ID
 */
function loadIndividualLeave(employeeId) {
    fetch(`dashboard_data.php?request=individual_leave&employee_id=${employeeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('individualLeaveChart').getContext('2d');
                
                // Store chart instance in global variable for later updates
                if (window.individualLeaveChart) {
                    window.individualLeaveChart.data = data.data;
                    window.individualLeaveChart.update();
                } else {
                    window.individualLeaveChart = new Chart(ctx, {
                        type: 'pie',
                        data: data.data,
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                }
                            }
                        }
                    });
                }
            } else {
                console.error('Error loading individual leave:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load conveyance summary data and initialize chart
 * @param {string} employeeId - Employee ID
 */
function loadConveyanceSummary(employeeId) {
    fetch(`dashboard_data.php?request=conveyance_summary&employee_id=${employeeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('conveyanceSummaryChart').getContext('2d');
                
                // Store chart instance in global variable for later updates
                if (window.conveyanceSummaryChart) {
                    window.conveyanceSummaryChart.data = data.data;
                    window.conveyanceSummaryChart.update();
                } else {
                    window.conveyanceSummaryChart = new Chart(ctx, {
                        type: 'line',
                        data: data.data,
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Amount ($)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Month'
                                    }
                                }
                            }
                        }
                    });
                }
            } else {
                console.error('Error loading conveyance summary:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load pending requests data and initialize chart
 */
function loadPendingRequests() {
    fetch('dashboard_data.php?request=pending_requests')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('pendingRequestsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: data.data,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            x: {
                                stacked: true,
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Requests'
                                }
                            }
                        }
                    }
                });
            } else {
                console.error('Error loading pending requests:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load upcoming birthdays and populate the widget
 */
function loadUpcomingBirthdays() {
    fetch('dashboard_data.php?request=upcoming_birthdays')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const birthdaysContainer = document.getElementById('upcomingBirthdays');
                birthdaysContainer.innerHTML = '';
                
                data.data.forEach(person => {
                    const birthdayCard = document.createElement('div');
                    birthdayCard.className = 'birthday-card';
                    birthdayCard.innerHTML = `
                        <img src="${person.image}" alt="${person.name}" class="birthday-img">
                        <div>
                            <div class="fw-bold">${person.name}</div>
                            <small class="text-muted">${person.date}</small>
                        </div>
                    `;
                    birthdaysContainer.appendChild(birthdayCard);
                });
            } else {
                console.error('Error loading upcoming birthdays:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load employees list and populate dropdowns
 */
function loadEmployeesList() {
    fetch('dashboard_data.php?request=employees_list')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const employeeSelectors = [
                    document.getElementById('employeeSelector'),
                    document.getElementById('leaveEmployeeSelector'),
                    document.getElementById('conveyanceEmployeeSelector')
                ];
                
                employeeSelectors.forEach(selector => {
                    if (selector) {
                        selector.innerHTML = '';
                        data.data.forEach(employee => {
                            const option = document.createElement('option');
                            option.value = employee.id;
                            option.textContent = employee.name;
                            selector.appendChild(option);
                        });
                    }
                });
            } else {
                console.error('Error loading employees list:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load departments list and populate filters
 */
function loadDepartmentsList() {
    fetch('dashboard_data.php?request=departments_list')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Main filter dropdown
                const filterDropdown = document.getElementById('filterDropdown');
                if (filterDropdown) {
                    filterDropdown.innerHTML = '';
                    data.data.forEach(dept => {
                        const item = document.createElement('li');
                        item.innerHTML = `<a class="dropdown-item" href="#" data-id="${dept.id}">${dept.name}</a>`;
                        filterDropdown.appendChild(item);
                    });
                }
                
                // Attendance department filter
                const attendanceDeptFilter = document.getElementById('attendanceDeptFilter');
                if (attendanceDeptFilter) {
                    attendanceDeptFilter.innerHTML = '';
                    data.data.forEach(dept => {
                        const item = document.createElement('li');
                        item.innerHTML = `<a class="dropdown-item" href="#" data-id="${dept.id}">${dept.name}</a>`;
                        attendanceDeptFilter.appendChild(item);
                    });
                }
                
                // Set up event listeners for the new items
                setupFilterEventListeners();
            } else {
                console.error('Error loading departments list:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Set up event listeners for all interactive elements
 */
function setupEventListeners() {
    // Employee selectors
    const employeeSelector = document.getElementById('employeeSelector');
    if (employeeSelector) {
        employeeSelector.addEventListener('change', function() {
            loadIndividualAttendance(this.value);
        });
    }
    
    const leaveEmployeeSelector = document.getElementById('leaveEmployeeSelector');
    if (leaveEmployeeSelector) {
        leaveEmployeeSelector.addEventListener('change', function() {
            loadIndividualLeave(this.value);
        });
    }
    
    const conveyanceEmployeeSelector = document.getElementById('conveyanceEmployeeSelector');
    if (conveyanceEmployeeSelector) {
        conveyanceEmployeeSelector.addEventListener('change', function() {
            loadConveyanceSummary(this.value);
        });
    }
}

/**
 * Set up event listeners for filter dropdowns
 * This is called after loading the departments list
 */
function setupFilterEventListeners() {
    // Department filter for attendance
    const attendanceFilterItems = document.querySelectorAll('#attendanceDeptFilter .dropdown-item');
    attendanceFilterItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const selectedDept = this.textContent;
            const deptId = this.getAttribute('data-id');
            document.getElementById('attendanceFilterDropdown').textContent = selectedDept;
            loadOrganizationAttendance(deptId);
        });
    });
    
    // Main filter dropdown
    const filterItems = document.querySelectorAll('#filterDropdown .dropdown-item');
    filterItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const selectedFilter = this.textContent;
            const filterId = this.getAttribute('data-id');
            document.getElementById('navbarDropdown').innerHTML = `<i class="fas fa-filter me-1"></i> ${selectedFilter}`;
            
            // Update all charts based on the selected filter
            updateAllCharts(filterId);
        });
    });
}

/**
 * Update all charts based on a global filter
 * @param {string} filter - The selected filter value
 */
function updateAllCharts(filter) {
    // Reload all charts with the filter applied
    loadOrganizationAttendance(filter);
    // Other charts can be updated here as needed
}

/**
 * Counter animation function
 * @param {string} elementId - ID of the element to animate
 * @param {number} start - Starting value
 * @param {number} end - Ending value
 * @param {number} duration - Animation duration in milliseconds
 */
function animateCounter(elementId, start, end, duration) {
    const element = document.getElementById(elementId);
    const range = end - start;
    const increment = end > start ? 1 : -1;
    const stepTime = Math.abs(Math.floor(duration / range));
    let current = start;
    
    const timer = setInterval(function() {
        current += increment;
        element.textContent = current;
        if (current == end) {
            clearInterval(timer);
        }
    }, stepTime);
}

// Add these new functions to your existing dashboard_integration.js file

/**
 * Load department headcount data and initialize chart
 */
function loadDepartmentHeadcount() {
    fetch('dashboard_data.php?request=department_headcount')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('departmentHeadcountChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: data.data,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Employees'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } else {
                console.error('Error loading department headcount:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load turnover rate data and initialize chart
 */
function loadTurnoverRate() {
    fetch('dashboard_data.php?request=turnover_rate')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('turnoverRateChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: data.data,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Percentage (%)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            }
                        }
                    }
                });
            } else {
                console.error('Error loading turnover rate:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load performance ratings data and initialize chart
 */
function loadPerformanceRatings() {
    fetch('dashboard_data.php?request=performance_ratings')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('performanceRatingsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: data.data,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Employees'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } else {
                console.error('Error loading performance ratings:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load training completion data and initialize chart
 */
function loadTrainingCompletion() {
    fetch('dashboard_data.php?request=training_completion')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('trainingCompletionChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: data.data,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        },
                        cutout: '70%'
                    }
                });
            } else {
                console.error('Error loading training completion:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load recruitment pipeline data and initialize chart
 */
function loadRecruitmentPipeline() {
    fetch('dashboard_data.php?request=recruitment_pipeline')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('recruitmentPipelineChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: data.data,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Candidates'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } else {
                console.error('Error loading recruitment pipeline:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load onboarding status data and initialize chart
 */
function loadOnboardingStatus() {
    fetch('dashboard_data.php?request=onboarding_status')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ctx = document.getElementById('onboardingStatusChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: data.data,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Employees'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } else {
                console.error('Error loading onboarding status:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Load upcoming interviews and populate the widget
 */
function loadUpcomingInterviews() {
    fetch('dashboard_data.php?request=upcoming_interviews')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const interviewsContainer = document.querySelector('.list-group');
                interviewsContainer.innerHTML = '';
                
                data.data.forEach(interview => {
                    const interviewItem = document.createElement('div');
                    interviewItem.className = 'list-group-item interview-item';
                    interviewItem.innerHTML = `
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">${interview.position}</h6>
                            <small class="text-primary">${interview.time}</small>
                        </div>
                        <p class="mb-1">Candidate: ${interview.candidate}</p>
                        <small class="text-muted">Interviewer: ${interview.interviewer}</small>
                    `;
                    interviewsContainer.appendChild(interviewItem);
                });
            } else {
                console.error('Error loading upcoming interviews:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Add these new function calls to the DOMContentLoaded event
document.addEventListener('DOMContentLoaded', function() {
    // ... existing code ...
    
    // Initialize new charts with PHP data
    loadDepartmentHeadcount();
    loadTurnoverRate();
    loadPerformanceRatings();
    loadTrainingCompletion();
    loadRecruitmentPipeline();
    loadOnboardingStatus();
    loadUpcomingInterviews();
    
    // ... existing code ...
});