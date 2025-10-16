// Display current date
document.addEventListener('DOMContentLoaded', function() {
    const currentDate = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('currentDate').textContent = currentDate.toLocaleDateString('en-US', options);
    
    // Initialize all charts
    initGenderDistributionChart();
    initAgeDistributionChart();
    initOrganizationAttendanceChart();
    initIndividualAttendanceChart();
    initIndividualLeaveChart();
    initConveyanceSummaryChart();
    initPendingRequestsChart();
    animateCounter('totalHeadcount', 0, 1250, 2000); // Animate from 0 to 1250 over 2 seconds
    
    // Set up event listeners
    setupEventListeners();
});

// Counter animation function
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

// Gender Distribution Chart
function initGenderDistributionChart() {
    const ctx = document.getElementById('genderDistributionChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const genderData = {
        labels: ['Male', 'Female'],
        datasets: [{
            data: [65, 35],
            backgroundColor: ['#4e73df', '#1cc88a'],
            hoverBackgroundColor: ['#2e59d9', '#17a673'],
            hoverBorderColor: 'rgba(234, 236, 244, 1)',
        }]
    };
    
    new Chart(ctx, {
        type: 'pie',
        data: genderData,
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
}

// Age Distribution Chart
function initAgeDistributionChart() {
    const ctx = document.getElementById('ageDistributionChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const ageData = {
        labels: ['20-25', '26-30', '31-35', '36-40', '41+'],
        datasets: [{
            label: 'Employees',
            data: [15, 30, 25, 20, 10],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#d52a1a'],
            borderWidth: 1,
        }]
    };
    
    new Chart(ctx, {
        type: 'doughnut',
        data: ageData,
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
}

// Organization-wise Attendance Chart
function initOrganizationAttendanceChart() {
    const ctx = document.getElementById('organizationAttendanceChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const attendanceData = {
        labels: ['Present', 'Absent', 'On Leave', 'Late'],
        datasets: [{
            label: 'Employees',
            data: [75, 10, 12, 3],
            backgroundColor: ['#1cc88a', '#e74a3b', '#f6c23e', '#4e73df'],
            hoverBackgroundColor: ['#17a673', '#d52a1a', '#dda20a', '#2e59d9'],
            borderWidth: 1,
        }]
    };
    
    new Chart(ctx, {
        type: 'bar',
        data: attendanceData,
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
}

// Individual Attendance Chart
function initIndividualAttendanceChart() {
    const ctx = document.getElementById('individualAttendanceChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const monthlyData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [
            {
                label: 'Present',
                data: [20, 18, 22, 19, 21, 17],
                backgroundColor: '#1cc88a',
                borderColor: '#1cc88a',
                borderWidth: 2,
                tension: 0.1
            },
            {
                label: 'Absent',
                data: [2, 3, 0, 1, 2, 3],
                backgroundColor: '#e74a3b',
                borderColor: '#e74a3b',
                borderWidth: 2,
                tension: 0.1
            },
            {
                label: 'Leave',
                data: [0, 1, 0, 2, 0, 2],
                backgroundColor: '#f6c23e',
                borderColor: '#f6c23e',
                borderWidth: 2,
                tension: 0.1
            }
        ]
    };
    
    new Chart(ctx, {
        type: 'line',
        data: monthlyData,
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

// Individual Leave Chart
function initIndividualLeaveChart() {
    const ctx = document.getElementById('individualLeaveChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const leaveData = {
        labels: ['Casual Leave', 'Sick Leave', 'Earned Leave', 'Unpaid Leave'],
        datasets: [{
            data: [5, 3, 2, 1],
            backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#dda20a', '#d52a1a'],
            hoverBorderColor: 'rgba(234, 236, 244, 1)',
        }]
    };
    
    new Chart(ctx, {
        type: 'pie',
        data: leaveData,
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

// Conveyance Summary Chart
function initConveyanceSummaryChart() {
    const ctx = document.getElementById('conveyanceSummaryChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const conveyanceData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Conveyance Amount',
            data: [1200, 1900, 1500, 2000, 1800, 2200],
            backgroundColor: 'rgba(78, 115, 223, 0.2)',
            borderColor: '#4e73df',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    };
    
    new Chart(ctx, {
        type: 'line',
        data: conveyanceData,
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

// Pending Requests Chart
function initPendingRequestsChart() {
    const ctx = document.getElementById('pendingRequestsChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const requestsData = {
        labels: ['Attendance', 'Leave', 'Onsite', 'Outstation'],
        datasets: [
            {
                label: 'Pending',
                data: [12, 8, 5, 3],
                backgroundColor: '#f6c23e',
                borderColor: '#f6c23e',
                borderWidth: 1
            },
            {
                label: 'Approved',
                data: [8, 15, 7, 4],
                backgroundColor: '#1cc88a',
                borderColor: '#1cc88a',
                borderWidth: 1
            },
            {
                label: 'Rejected',
                data: [2, 3, 1, 0],
                backgroundColor: '#e74a3b',
                borderColor: '#e74a3b',
                borderWidth: 1
            }
        ]
    };
    
    new Chart(ctx, {
        type: 'bar',
        data: requestsData,
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
}

// Set up event listeners for all interactive elements
function setupEventListeners() {
    // Employee selectors
    const employeeSelector = document.getElementById('employeeSelector');
    if (employeeSelector) {
        employeeSelector.addEventListener('change', function() {
            // PHP will handle this to fetch and update data
            console.log('Selected employee:', this.value);
            // Example of how PHP would update the chart:
            // updateIndividualAttendanceChart(this.value);
        });
    }
    
    const leaveEmployeeSelector = document.getElementById('leaveEmployeeSelector');
    if (leaveEmployeeSelector) {
        leaveEmployeeSelector.addEventListener('change', function() {
            // PHP will handle this to fetch and update data
            console.log('Selected employee for leave:', this.value);
            // Example of how PHP would update the chart:
            // updateIndividualLeaveChart(this.value);
        });
    }
    
    const conveyanceEmployeeSelector = document.getElementById('conveyanceEmployeeSelector');
    if (conveyanceEmployeeSelector) {
        conveyanceEmployeeSelector.addEventListener('change', function() {
            // PHP will handle this to fetch and update data
            console.log('Selected employee for conveyance:', this.value);
            // Example of how PHP would update the chart:
            // updateConveyanceSummaryChart(this.value);
        });
    }
    
    // Department filter for attendance
    const attendanceFilterItems = document.querySelectorAll('#attendanceDeptFilter .dropdown-item');
    attendanceFilterItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const selectedDept = this.textContent;
            document.getElementById('attendanceFilterDropdown').textContent = selectedDept;
            // PHP will handle this to fetch and update data
            console.log('Selected department:', selectedDept);
            // Example of how PHP would update the chart:
            // updateOrganizationAttendanceChart(selectedDept);
        });
    });
    
    // Main filter dropdown
    const filterItems = document.querySelectorAll('#filterDropdown .dropdown-item');
    filterItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const selectedFilter = this.textContent;
            document.getElementById('navbarDropdown').innerHTML = `<i class="fas fa-filter me-1"></i> ${selectedFilter}`;
            // PHP will handle this to fetch and update data
            console.log('Selected filter:', selectedFilter);
            // Example of how PHP would update all charts:
            // updateAllCharts(selectedFilter);
        });
    });
}

// Example functions for PHP integration

/**
 * Update individual attendance chart with data from PHP
 * @param {string} employeeId - The selected employee ID
 */
function updateIndividualAttendanceChart(employeeId) {
    // In a real implementation, this would make an AJAX call to a PHP endpoint
    // Example:
    // fetch(`get_attendance_data.php?employee_id=${employeeId}`)
    //     .then(response => response.json())
    //     .then(data => {
    //         // Update chart with new data
    //         individualAttendanceChart.data = data;
    //         individualAttendanceChart.update();
    //     });
}

/**
 * Update individual leave chart with data from PHP
 * @param {string} employeeId - The selected employee ID
 */
function updateIndividualLeaveChart(employeeId) {
    // Similar AJAX call to PHP endpoint
}

/**
 * Update conveyance summary chart with data from PHP
 * @param {string} employeeId - The selected employee ID
 */
function updateConveyanceSummaryChart(employeeId) {
    // Similar AJAX call to PHP endpoint
}

/**
 * Update organization attendance chart with data from PHP
 * @param {string} department - The selected department
 */
function updateOrganizationAttendanceChart(department) {
    // Similar AJAX call to PHP endpoint
}

/**
 * Update all charts based on a global filter
 * @param {string} filter - The selected filter value
 */
function updateAllCharts(filter) {
    // This would make multiple AJAX calls or a single call that returns all needed data
}

// Add these new chart initialization functions to your existing dashboard.js file

// Department Headcount Chart
function initDepartmentHeadcountChart() {
    const ctx = document.getElementById('departmentHeadcountChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const deptData = {
        labels: ['IT', 'HR', 'Finance', 'Marketing', 'Operations', 'Sales'],
        datasets: [{
            label: 'Employees',
            data: [45, 25, 30, 35, 40, 50],
            backgroundColor: [
                'rgba(78, 115, 223, 0.8)',
                'rgba(28, 200, 138, 0.8)',
                'rgba(54, 185, 204, 0.8)',
                'rgba(246, 194, 62, 0.8)',
                'rgba(231, 74, 59, 0.8)',
                'rgba(133, 135, 150, 0.8)'
            ],
            borderWidth: 1
        }]
    };
    
    new Chart(ctx, {
        type: 'bar',
        data: deptData,
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
}

// Employee Turnover Rate Chart
function initTurnoverRateChart() {
    const ctx = document.getElementById('turnoverRateChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const turnoverData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Turnover Rate (%)',
            data: [2.1, 1.8, 2.3, 1.9, 2.5, 2.0],
            borderColor: '#e74a3b',
            backgroundColor: 'rgba(231, 74, 59, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    };
    
    new Chart(ctx, {
        type: 'line',
        data: turnoverData,
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
}

// Performance Ratings Distribution Chart
function initPerformanceRatingsChart() {
    const ctx = document.getElementById('performanceRatingsChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const performanceData = {
        labels: ['Outstanding', 'Exceeds Expectations', 'Meets Expectations', 'Needs Improvement', 'Unsatisfactory'],
        datasets: [{
            label: 'Employees',
            data: [15, 30, 40, 10, 5],
            backgroundColor: [
                '#1cc88a',
                '#4e73df',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b'
            ],
            borderWidth: 1
        }]
    };
    
    new Chart(ctx, {
        type: 'bar',
        data: performanceData,
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
}

// Training Completion Status Chart
function initTrainingCompletionChart() {
    const ctx = document.getElementById('trainingCompletionChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const trainingData = {
        labels: ['Completed', 'In Progress', 'Not Started'],
        datasets: [{
            data: [65, 25, 10],
            backgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b'],
            hoverBackgroundColor: ['#17a673', '#dda20a', '#d52a1a'],
            hoverBorderColor: 'rgba(234, 236, 244, 1)',
        }]
    };
    
    new Chart(ctx, {
        type: 'doughnut',
        data: trainingData,
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
}

// Recruitment Pipeline Chart
function initRecruitmentPipelineChart() {
    const ctx = document.getElementById('recruitmentPipelineChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const recruitmentData = {
        labels: ['Applied', 'Screening', 'Interview', 'Assessment', 'Offer', 'Hired'],
        datasets: [{
            label: 'Candidates',
            data: [120, 80, 40, 25, 15, 10],
            backgroundColor: 'rgba(78, 115, 223, 0.8)',
            borderColor: '#4e73df',
            borderWidth: 1
        }]
    };
    
    new Chart(ctx, {
        type: 'bar',
        data: recruitmentData,
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
}

// Onboarding Status Chart
function initOnboardingStatusChart() {
    const ctx = document.getElementById('onboardingStatusChart').getContext('2d');
    
    // Mock data - PHP will replace this with actual data
    const onboardingData = {
        labels: ['Documentation', 'IT Setup', 'Training', 'Department Intro', 'Buddy Assignment', 'Completed'],
        datasets: [{
            label: 'New Hires',
            data: [18, 15, 12, 10, 8, 5],
            backgroundColor: 'rgba(28, 200, 138, 0.8)',
            borderColor: '#1cc88a',
            borderWidth: 1
        }]
    };
    
    new Chart(ctx, {
        type: 'bar',
        data: onboardingData,
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
}

// Add these new chart initializations to the DOMContentLoaded event
document.addEventListener('DOMContentLoaded', function() {
    // ... existing code ...
    
    // Initialize new charts
    initDepartmentHeadcountChart();
    initTurnoverRateChart();
    initPerformanceRatingsChart();
    initTrainingCompletionChart();
    initRecruitmentPipelineChart();
    initOnboardingStatusChart();
    
    // Initialize quick stats
    document.getElementById('quickStatHeadcount').textContent = '1250';
    document.getElementById('quickStatPresent').textContent = '1180';
    document.getElementById('quickStatLeave').textContent = '45';
    document.getElementById('quickStatPending').textContent = '28';
    
    // ... existing code ...
});