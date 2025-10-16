<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";
$title="Employee Requisition view";
do_calander('#m_date');

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');


?>

<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <label class="me-2 text-secondary">Show</label>
                    <select class="form-select form-select-sm" style="width: 70px;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <label class="ms-2 text-secondary">entries</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="me-2 text-secondary">Search:</label>
                    <input type="search" class="form-control form-control-sm" style="width: 200px;">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="py-2">ID</th>
                            <th class="py-2">Date</th>
                            <th class="py-2">Section Name</th>
                            <th class="py-2">Job Title</th>
                            <th class="py-2">Required Staff</th>
                            <th class="py-2">Current Staff</th>
                            <th class="py-2">Required Current Staff</th>
                            <th class="py-2">Male Count</th>
                            <th class="py-2">Female Count</th>
                            <th class="py-2">Reason For Demand</th>
                            <th class="py-2">Educational Qualification</th>
                            <th class="py-2">Experience</th>
                            <th class="py-2">Salary</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM `employee_requisition`";
                        $result = db_query($query);
                        if($result && mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>".$row['emp_req_id']."</td>";
                                echo "<td>".$row['date']."</td>";
                                echo "<td>".$row['section_name']."</td>";
                                echo "<td>".$row['job_title']."</td>";
                                echo "<td>".$row['required_staff']."</td>";
                                echo "<td>".$row['current_staff']."</td>";
                                echo "<td>".$row['required_current_staff']."</td>";
                                echo "<td>".$row['male_count']."</td>";
                                echo "<td>".$row['female_count']."</td>";
                                echo "<td>".$row['reason_for_demand']."</td>";
                                echo "<td>".$row['educational_qualification']."</td>";
                                echo "<td>".$row['experience']."</td>";
                                echo "<td>".$row['salary']."</td>";
                                echo "<td>";
                                echo "<a target='_blank' href='employee_requisition_pdf_view.php?id=".$row['emp_req_id']."' 
                                      class='btn btn-primary btn-sm px-3'>Show</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='14' class='text-center py-3'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-secondary">
                    Showing <span class="fw-semibold">1</span> to <span class="fw-semibold">3</span> of <span class="fw-semibold">3</span> entries
                </div>
                <nav aria-label="Table navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th {
        font-weight: 500;
        border-bottom-width: 1px;
    }
    .table td {
        font-size: 0.9rem;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .form-select:focus,
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    }
</style>



    <?
require_once SERVER_CORE."routing/layout.bottom.php";
?>