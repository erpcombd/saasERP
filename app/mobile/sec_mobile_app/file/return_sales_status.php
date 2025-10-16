<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Return Report";
$page = "return_sales_status.php";
require_once '../assets/template/inc.header.php';

$user_id = $_SESSION['user']['username'];
$emp_code = $user_id;
$today = date('Y-m-d');

$unique = 'po_no';
$status = 'CHECKED';
$target_url = 'receive_view1.php';

// Initialize variables
$con = '';
$query_result = null;

if (isset($_REQUEST[$unique]) && $_REQUEST[$unique] > 0) {
    $_SESSION[$unique] = $_REQUEST[$unique];
    header('location:' . $target_url);
    exit();
}

if (isset($_POST['submitit'])) {
    // Validate and sanitize inputs
    $fdate = isset($_POST['fdate']) ? trim($_POST['fdate']) : '';
    $tdate = isset($_POST['tdate']) ? trim($_POST['tdate']) : '';
    
    // Build query conditions
    if (!empty($fdate) && !empty($tdate)) {
        $con = ' AND a.or_date BETWEEN "' . mysqli_real_escape_string($conn, $fdate) . '" AND "' . mysqli_real_escape_string($conn, $tdate) . '"';
    }
    
    // Build SQL query for Sales Return
    $res = 'SELECT a.or_no, a.or_no as Replace_No, a.or_date as return_date, 
            a.vendor_id as Party_Code, a.vendor_name as Party_Name, 
            FORMAT(SUM(b.qty),2) as Replace_Qty, FORMAT(SUM(b.amount),2) as Total
            FROM ss_receive_master a
            INNER JOIN ss_receive_details b ON a.or_no = b.or_no
            WHERE a.receive_type = "Sales Return" 
            AND a.status = "Checked"
            AND a.entry_by = "' . mysqli_real_escape_string($conn, $emp_code) . '"
            ' . $con . '
            GROUP BY a.or_no 
            ORDER BY a.or_no DESC';
    
    // Execute query
    $query_result = mysqli_query($conn, $res);
    
    if (!$query_result) {
        echo "<div class='alert alert-danger'>Error executing query: " . mysqli_error($conn) . "</div>";
    }
} else {
    // Default query for current month
    $res = 'SELECT a.or_no, a.or_no as Replace_No, a.or_date as return_date, 
            a.vendor_id as Party_Code, a.vendor_name as Party_Name, 
            FORMAT(SUM(b.qty),2) as Replace_Qty, FORMAT(SUM(b.amount),2) as Total
            FROM ss_receive_master a
            INNER JOIN ss_receive_details b ON a.or_no = b.or_no
            WHERE a.receive_type = "Sales Return" 
            AND a.status = "Checked"
            AND a.or_date BETWEEN "' . date('Y-m-01') . '" AND "' . date('Y-m-d') . '"
            AND a.entry_by = "' . mysqli_real_escape_string($conn, $emp_code) . '"
            GROUP BY a.or_no 
            ORDER BY a.or_no DESC';
    
    // Execute default query
    $query_result = mysqli_query($conn, $res);
    
    if (!$query_result) {
        echo "<div class='alert alert-danger'>Error executing query: " . mysqli_error($conn) . "</div>";
    }
}

?>
<script language="javascript">
    function custom(theUrl) {
        window.open('<?= $target_url ?>?v_no=' + theUrl);
    }
</script>

<!-- start of Page Content-->
<div class="page-content header-clear-medium">

    <div class="card card-style">
        <form action="" method="post" name="codz" id="codz">
            <div class="content">

                <label for="fdate">Date From</label>
                <input type="date" name="fdate" id="fdate" value="<?= isset($_POST['fdate']) ? htmlspecialchars($_POST['fdate']) : date('Y-m-01') ?>" placeholder="Date From" class="form-control validate-text" />

                <label for="tdate">Date To</label>
                <input type="date" name="tdate" id="tdate" value="<?= isset($_POST['tdate']) ? htmlspecialchars($_POST['tdate']) : date('Y-m-d') ?>" placeholder="Date To" class="form-control validate-text" />

                <div class="d-flex justify-content-center row mt-3">
                    <div class="col-6">
                        <input type="submit" name="submitit" id="submitit" class="b-n btn btn-success btn-3d btn-block text-light w-100 py-3" value="View" />
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="card card-style"> 
        <div class="content ms-0 me-0">
            <div class="table-responsive pt-3" style="zoom: 80%;">
                <table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;">
                    <thead>
                        <tr class="bg-night-light1">
                            <th scope="col" class="color-white">Return NO</th>
                            <th scope="col" class="color-white">Return Date</th>
                            <th scope="col" class="color-white">Party Code</th>
                            <th scope="col" class="color-white">Party Name</th>
                            <th scope="col" class="color-white">Return Qty</th>
                            <th scope="col" class="color-white">Return Amount</th>
                            <th scope="col" class="color-white">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    // Display data if query was executed and successful
                    if ($query_result && mysqli_num_rows($query_result) > 0) {
                        $sl = 1;
                        while($data = mysqli_fetch_object($query_result)) {
                    ?>
                            <tr>
                                <td style="color: green; font-weight: bold;"><?= htmlspecialchars($data->or_no); ?></td>
                                <td><?= htmlspecialchars($data->return_date); ?></td>
                                <td style="color: #0069b5; font-weight: bold;"><?= htmlspecialchars($data->Party_Code); ?></td>
                                <td><?= htmlspecialchars($data->Party_Name); ?></td>
                                <td><?= htmlspecialchars($data->Replace_Qty); ?></td>
                                <td><?= htmlspecialchars($data->Total); ?></td>
                                <td class="d-flex gap-2 justify-content-center align-items-center">
                                    <a href="receive_view1.php?do=<?= urlencode($data->Replace_No); ?>"> 
                                        <button class="b-n btn btn-info btn-3d btn-block text-light w-100" type="button">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </a>
                                    <a href="receive_view1.php?do=<?= urlencode($data->Replace_No); ?>">
                                        <button class="b-n btn btn-warning btn-3d btn-block text-light w-100" type="button">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                    <?php 
                            $sl++;
                        } 
                    } else if (isset($_POST['submitit'])) {
                        // Show message if form was submitted but no results found
                    ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No records found for the selected date range.
                            </td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Please select date range and click "View" to display records.
                            </td>
                        </tr>
                    <?php } ?> 
                    </tbody>
                </table>
            </div> 
        </div>
    </div>
</div>
<!-- End of Page Content-->

<?php
require_once '../assets/template/inc.footer.php';
?>