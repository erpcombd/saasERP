<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Attendance Approval";
$page = "attendance_approval.php";

// Check if user has admin permissions
if(!isset($_SESSION['user']['is_admin']) || $_SESSION['user']['is_admin'] != 1) {
    // Redirect to login or display error message
    header("Location: login.php");
    exit;
}

// Handle approval/denial actions
if(isset($_POST['action']) && isset($_POST['log_id'])) {
    $log_id = $_POST['log_id'];
    $action = $_POST['action'];
    $status = ($action == 'approve') ? 'APPROVED' : 'DENIED';
    
    // Update the attendance record
    $update_query = "UPDATE ss_location_log SET approved_status = '$status' WHERE id = '$log_id'";
    query($update_query);
    
    $msg = "Attendance has been " . strtolower($status);
}

// Get pending attendance records
$pending_records = findallrows("SELECT l.*, u.fname 
                               FROM ss_location_log l 
                               JOIN ss_user u ON l.user_id = u.username 
                               WHERE l.approved_status = 'PENDING' 
                               ORDER BY l.access_date DESC, l.access_time DESC");

// Include header
require_once '../assets/template/inc.header.php';
?>

<div class="page-content header-clear-medium">
    <div class="card card-style mb-0">
        <div class="content mt-0 mb-0">
            <?php if(isset($msg)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $msg; ?>
            </div>
            <?php endif; ?>
            
            <h2>Pending Attendance Records</h2>
            
            <?php if(count($pending_records) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Type</th>
                            <th>Shop</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pending_records as $record): ?>
                        <tr>
                            <td><?php echo $record->fname; ?></td>
                            <td><?php echo date('Y-m-d', strtotime($record->access_date)); ?></td>
                            <td><?php echo date('H:i:s', strtotime($record->access_time)); ?></td>
                            <td><?php echo $record->attendance_type; ?></td>
                            <td><?php echo $record->shop_name; ?></td>
                            <td>
                                <form method="post" style="display: inline-block">
                                    <input type="hidden" name="log_id" value="<?php echo $record->id; ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form method="post" style="display: inline-block">
                                    <input type="hidden" name="log_id" value="<?php echo $record->id; ?>">
                                    <input type="hidden" name="action" value="deny">
                                    <button type="submit" class="btn btn-danger btn-sm">Deny</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p>No pending attendance records found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php 
require_once '../assets/template/inc.footer.php';
?>