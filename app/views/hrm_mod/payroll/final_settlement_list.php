<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

?>

<div class="container mt-4">
    <h4 class="mb-4">Final Settlement Employee List</h4>
    
    <div class="table-responsive">
        <table id="finalSettlementTable" class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>SL</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Payable Amount</th>
                    <th>Settlement Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $con = ''; // Optional: Add filters like " AND p.PBI_DEPARTMENT = 'HR' "

                $sql = 'SELECT f.*,  
                               p.PBI_NAME, 
                               p.PBI_ID, 
                               p.PBI_DEPARTMENT, 
                               p.PBI_JOB_STATUS 
                        FROM final_settlements f, personnel_basic_info p 
                        WHERE f.employee_id = p.PBI_ID ' . $con . ' 
                        ORDER BY f.employee_id';

                $query = db_query($sql);

                if (!$query) {
                    echo "<tr><td colspan='8'>SQL Error: " . mysqli_error($conn) . "</td></tr>";
                } else {
                    $sl = 1;
                    while ($data = mysqli_fetch_object($query)) {
                        echo "<tr>";
                        echo "<td>{$sl}</td>";
                        echo "<td>{$data->PBI_ID}</td>";
                        echo "<td>{$data->PBI_NAME}</td>";
                        echo "<td>{$data->PBI_DEPARTMENT}</td>";
                        echo "<td>{$data->PBI_JOB_STATUS}</td>";
                        echo "<td>" . number_format($data->total_payable, 2) . " BDT</td>";
                        echo "<td>{$data->settlement_date}</td>";
                        echo "<td>
                                <a href='view_final_report.php?id={$data->id}' class='btn btn-info btn-sm' target='_blank'>View</a>
                                <a href='download_pdf.php?id={$data->id}' class='btn btn-success btn-sm' target='_blank'>Print</a>
                              </td>";
                        echo "</tr>";
                        $sl++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#finalSettlementTable').DataTable({
            "pageLength": 10,
            "lengthChange": true,
            "ordering": true,
            "searching": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>

<?php
require_once SERVER_CORE . "routing/layout.bottom.php";
?>
