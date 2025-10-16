<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Individual Holiday View ';
?>



<style type="text/css">

<!--

.style1 {

	color: #FFFFFF;

	font-weight: bold;

}

-->

</style>
<!--Three input table-->
<div class="form-container_large">
 
 <?php
ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

// Define the db_query function to fix the undefined variable error
function db_query($sql, $params = []) {
    global $conn;
    
    // If using prepared statements with parameters
    if (!empty($params)) {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log("SQL Error: " . $conn->error . " in query: " . $sql);
            return false;
        }
        
        // Determine parameter types
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } elseif (is_string($param)) {
                $types .= 's';
            } else {
                $types .= 'b';
            }
        }
        
        // Bind parameters
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    } else {
        // Simple query without parameters
        $result = $conn->query($sql);
        if (!$result) {
            error_log("SQL Error: " . $conn->error . " in query: " . $sql);
        }
        return $result;
    }
}

// Default values for filters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-7 days'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
$pbi_id = isset($_GET['pbi_id']) ? $_GET['pbi_id'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$rows_per_page = isset($_GET['rows']) ? (int)$_GET['rows'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'last_7_days';

// Calculate offset for pagination
$offset = ($page - 1) * $rows_per_page;

// Base query
$sql = "SELECT r.PBI_ID, r.roster_date, r.point_1, r.shedule_1, 
               e.name, e.job_title, e.profile_pic
        FROM hrm_roster_allocation r
        JOIN employees e ON r.PBI_ID = e.PBI_ID
        WHERE 1=1";

// Add filters
if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND r.roster_date BETWEEN '$start_date' AND '$end_date'";
}

if (!empty($pbi_id)) {
    $sql .= " AND r.PBI_ID = '$pbi_id'";
}

if (!empty($search)) {
    $sql .= " AND (e.name LIKE '%$search%' OR e.job_title LIKE '%$search%')";
}

// Add group by to get unique employees
$sql .= " GROUP BY r.PBI_ID";

// Count total results for pagination
$count_sql = "SELECT COUNT(DISTINCT r.PBI_ID) as total FROM hrm_roster_allocation r 
              JOIN employees e ON r.PBI_ID = e.PBI_ID 
              WHERE 1=1";
              
if (!empty($start_date) && !empty($end_date)) {
    $count_sql .= " AND r.roster_date BETWEEN '$start_date' AND '$end_date'";
}

if (!empty($pbi_id)) {
    $count_sql .= " AND r.PBI_ID = '$pbi_id'";
}

if (!empty($search)) {
    $count_sql .= " AND (e.name LIKE '%$search%' OR e.job_title LIKE '%$search%')";
}

// Use the db_query function instead of direct $conn->query
$count_result = db_query($count_sql);
$total_records = 0;
$total_pages = 1;

// Check if query was successful before using fetch_assoc()
if ($count_result && $count_result !== false) {
    $count_row = $count_result->fetch_assoc();
    $total_records = $count_row['total'];
    $total_pages = ceil($total_records / $rows_per_page);
} else {
    // Log the error
    error_log("Error in count query: " . $conn->error);
}

// Add pagination
$sql .= " LIMIT $offset, $rows_per_page";

// Execute query using db_query function
$result = db_query($sql);

// Get available schedules for each employee
function getEmployeeSchedules($conn, $pbi_id, $start_date, $end_date) {
    $schedule_sql = "SELECT roster_date, point_1, shedule_1 
                    FROM hrm_roster_allocation 
                    WHERE PBI_ID = '$pbi_id' 
                    AND roster_date BETWEEN '$start_date' AND '$end_date'
                    ORDER BY roster_date ASC";
    
    // Use the db_query function
    $schedule_result = db_query($schedule_sql);
    $schedules = [];
    
    // Check if query was successful before using fetch_assoc()
    if ($schedule_result && $schedule_result !== false) {
        while ($row = $schedule_result->fetch_assoc()) {
            $schedules[] = [
                'date' => $row['roster_date'],
                'point' => $row['point_1'],
                'schedule' => $row['shedule_1']
            ];
        }
    } else {
        // Log the error
        error_log("Error in schedule query for PBI_ID: " . $pbi_id);
    }
    
    return $schedules;
}

// Format schedule time for display
function formatScheduleTime($schedule) {
    // Assuming schedule is stored in format like "10:00-11:00"
    $parts = explode('-', $schedule);
    if (count($parts) == 2) {
        $start = date('h:i A', strtotime($parts[0]));
        $end = date('h:i A', strtotime($parts[1]));
        return $start . '-' . $end;
    }
    return $schedule;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Timing List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 0;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: white;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
        }
        .table th {
            background-color: #f1f2f6;
            color: #333;
            font-weight: 600;
        }
        .table td, .table th {
            vertical-align: middle;
            padding: 15px 10px;
        }
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .schedule-btn {
            background-color: #0f1729;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
        }
        .pagination .page-item.active .page-link {
            background-color: #ff6b35;
            border-color: #ff6b35;
        }
        .pagination .page-link {
            color: #333;
        }
        .sort-icon {
            color: #aaa;
            font-size: 12px;
        }
        .date-range-picker {
            border: 1px solid #ddd;
            padding: 8px 15px;
            border-radius: 4px;
        }
        .sort-dropdown {
            border: 1px solid #ddd;
            padding: 8px 15px;
            border-radius: 4px;
        }
        .timing-block {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Schedule Timing List</h4>
                <div class="d-flex">
                    <form action="" method="GET" class="d-flex gap-3">
                        <input type="hidden" name="page" value="<?php echo $page; ?>">
                        <input type="hidden" name="rows" value="<?php echo $rows_per_page; ?>">
                        
                        <div class="date-range">
                            <input type="text" name="date_range" class="date-range-picker" 
                                   value="<?php echo date('m/d/Y', strtotime($start_date)) . ' - ' . date('m/d/Y', strtotime($end_date)); ?>"
                                   id="dateRangePicker">
                            <input type="hidden" name="start_date" id="startDate" value="<?php echo $start_date; ?>">
                            <input type="hidden" name="end_date" id="endDate" value="<?php echo $end_date; ?>">
                        </div>
                        
                        <div class="sort-by">
                            <select name="sort_by" class="sort-dropdown" onchange="this.form.submit()">
                                <option value="last_7_days" <?php echo $sort_by == 'last_7_days' ? 'selected' : ''; ?>>Sort By: Last 7 Days</option>
                                <option value="last_30_days" <?php echo $sort_by == 'last_30_days' ? 'selected' : ''; ?>>Sort By: Last 30 Days</option>
                                <option value="this_month" <?php echo $sort_by == 'this_month' ? 'selected' : ''; ?>>Sort By: This Month</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <span class="me-2">Row Per Page</span>
                        <select name="rows" class="form-select form-select-sm" style="width: 70px;" onchange="changeRowsPerPage(this.value)">
                            <option value="10" <?php echo $rows_per_page == 10 ? 'selected' : ''; ?>>10</option>
                            <option value="25" <?php echo $rows_per_page == 25 ? 'selected' : ''; ?>>25</option>
                            <option value="50" <?php echo $rows_per_page == 50 ? 'selected' : ''; ?>>50</option>
                            <option value="100" <?php echo $rows_per_page == 100 ? 'selected' : ''; ?>>100</option>
                        </select>
                        <span class="ms-3">Entries</span>
                    </div>
                    
                    <div class="search-box">
                        <form action="" method="GET" class="d-flex">
                            <input type="hidden" name="start_date" value="<?php echo $start_date; ?>">
                            <input type="hidden" name="end_date" value="<?php echo $end_date; ?>">
                            <input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>">
                            <input type="hidden" name="rows" value="<?php echo $rows_per_page; ?>">
                            <input type="hidden" name="page" value="1">
                            
                            <input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-primary ms-2">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="40px">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>Name <span class="sort-icon ms-1"><i class="fas fa-sort"></i></span></th>
                                <th>Job Title <span class="sort-icon ms-1"><i class="fas fa-sort"></i></span></th>
                                <th>User Available Timings <span class="sort-icon ms-1"><i class="fas fa-sort"></i></span></th>
                                <th width="150px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result !== false && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $schedules = getEmployeeSchedules($conn, $row['PBI_ID'], $start_date, $end_date);
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input employee-select" 
                                                   data-pbi-id="<?php echo $row['PBI_ID']; ?>">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo !empty($row['profile_pic']) ? $row['profile_pic'] : 'https://via.placeholder.com/40'; ?>" 
                                                     alt="Profile" class="profile-img me-3">
                                                <span><?php echo htmlspecialchars($row['name']); ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                                        <td>
                                            <?php if (!empty($schedules)): ?>
                                                <?php foreach($schedules as $schedule): ?>
                                                    <div class="timing-block">
                                                        <?php 
                                                        echo date('d-m-Y', strtotime($schedule['date'])) . ' - ';
                                                        echo formatScheduleTime($schedule['schedule']);
                                                        ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">No schedules available</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="schedule-btn" 
                                                    onclick="scheduleEmployee('<?php echo $row['PBI_ID']; ?>')">
                                                Schedule Timing
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="5" class="text-center">No records found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Showing <?php echo $total_records > 0 ? $offset + 1 : 0; ?> - <?php echo min($offset + $rows_per_page, $total_records); ?> of <?php echo $total_records; ?> entries
                    </div>
                    
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page-1; ?>&rows=<?php echo $rows_per_page; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&sort_by=<?php echo $sort_by; ?>&search=<?php echo urlencode($search); ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            
                            <?php
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages, $start_page + 4);
                            
                            for ($i = $start_page; $i <= $end_page; $i++) {
                                echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">
                                        <a class="page-link" href="?page=' . $i . '&rows=' . $rows_per_page . '&start_date=' . $start_date . '&end_date=' . $end_date . '&sort_by=' . $sort_by . '&search=' . urlencode($search) . '">' . $i . '</a>
                                      </li>';
                            }
                            ?>
                            
                            <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page+1; ?>&rows=<?php echo $rows_per_page; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&sort_by=<?php echo $sort_by; ?>&search=<?php echo urlencode($search); ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Date Range Picker -->
    <script src="https://cdn.jsdelivr.net/npm/moment/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize date range picker
            $('#dateRangePicker').daterangepicker({
                opens: 'left',
                autoApply: true,
                locale: {
                    format: 'MM/DD/YYYY'
                }
            }, function(start, end) {
                $('#startDate').val(start.format('YYYY-MM-DD'));
                $('#endDate').val(end.format('YYYY-MM-DD'));
                this.element.closest('form').submit();
            });
            
            // Select all checkbox
            $('#selectAll').change(function() {
                $('.employee-select').prop('checked', $(this).prop('checked'));
            });
        });
        
        // Change rows per page
        function changeRowsPerPage(rows) {
            window.location.href = '?page=1&rows=' + rows + 
                                  '&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>' + 
                                  '&sort_by=<?php echo $sort_by; ?>&search=<?php echo urlencode($search); ?>';
        }
        
        // Schedule employee function
        function scheduleEmployee(pbiId) {
            // Redirect to schedule page or open modal
            window.location.href = 'schedule_employee.php?pbi_id=' + pbiId;
        }
    </script>
</body>
</html>
  
</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
