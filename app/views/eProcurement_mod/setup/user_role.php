<?php
require_once "../../../controllers/routing/layout.top.php";
$file = 'user_role.php';
$userLevel = $_SESSION['user']['level']; // Example user level

if(has_permission($file, $userLevel,$conn)){
    

} else {

    // If no permission, raise 404 error
 header('Location:../eProcurement/eprocurement_entry.php');
    exit();
}
// Update handler
if (
    $_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['role_name']) &&
    isset($_POST['update_role']) &&
    !empty($_POST['update_role'])
) {
    $role_name = mysqli_real_escape_string($conn, $_POST['role_name']);
    $role_id = mysqli_real_escape_string($conn, $_POST['update_role']);
    
    $allowed_pages = isset($_POST['allowed_page']) ? $_POST['allowed_page'] : [];
    $allowed_pages_json = json_encode($allowed_pages);

     $update_sql = "UPDATE user_role SET name = '$role_name', allowed_page = '$allowed_pages_json' WHERE id = '$role_id'";
    
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Role updated successfully!'); window.location.href = window.location.href;</script>";
    } else {
        echo "Update Error: " . mysqli_error($conn);
    }
}

//Insert handler
if (
    $_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['role_name']) &&
    !isset($_POST['delete_submit']) &&
    (!isset($_POST['update_role']) || empty($_POST['update_role']))
) {
    // die();   // <-- REMOVE THIS LINE
    // Escape POST data to prevent SQL injection
    $role_name = mysqli_real_escape_string($conn, $_POST['role_name']);
    
    // Get the allowed pages and convert them to JSON
    $allowed_pages = isset($_POST['allowed_page']) ? $_POST['allowed_page'] : [];
    $allowed_pages_json = json_encode($allowed_pages);

    // Insert the new record (auto-increment ID, no level field)
    $insert_sql = "INSERT INTO user_role (name, allowed_page)
                   VALUES ('$role_name', '$allowed_pages_json')";
    
    if (mysqli_query($conn, $insert_sql)) {
        echo "<script>alert('Role added successfully!'); window.location.href = window.location.href;</script>";
    } else {
        echo "Insert Error: " . mysqli_error($conn);
    }
}




// Delete handler
if (isset($_POST['delete_role'])) {
    $roleToDelete = mysqli_real_escape_string($conn, $_POST['delete_role']);

    $delete_sql = "DELETE FROM user_role WHERE name = '$roleToDelete'";

    if (mysqli_query($conn, $delete_sql)) {
        echo "<script>alert('Role deleted successfully!'); window.location.href = window.location.href;</script>";
    } else {
        echo "Error deleting role: " . mysqli_error($conn);
    }
}

// Fetch user roles
$sql = "SELECT `id`, `name`, `allowed_page` FROM `user_role`";
$qry = mysqli_query($conn, $sql);

?>
<? include '../eProcurement/ep_menu.php'; ?>
    <script type="text/javascript" src="../../../../public/assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../../public/assets/js/jquery-3.4.1.min.js"></script>

<style>
    tr:nth-child(odd) {
        background-color: #fffffffb !important;
        color: #333 !important;
    }
    tr:nth-child(even) {
        background-color: #fffffffb!important;
        color: #333 !important;
    }
    .nav-tabs .nav-item .nav-link, .nav-tabs .nav-item .nav-link:hover, .nav-tabs .nav-item .nav-link:focus {
        border: 0 !important;
        color: #007bff !important;
        font-weight: 500;
    }
    .sidebar{
        display: none;
        width: 0% !important;
    }
    .main_content {
        width: 100% !important;
    }
    .tab-content>.active {
        display: block;
        border: 1px solid #f5f5f5;
        background-color: #fbfbfb9e;
    }
    .nav-tabs .nav-item .nav-link.active {
        border: 1px solid #e1e1e1 !important;
        border-radius: 5px 5px 0px 0px;
        border-bottom: 1px solid #f8f8ff !important;
    }
    .nav-tabs .nav-item .nav-link:hover {
        border: 1px solid #e1e1e1 !important;
        border-radius: 5px 5px 0px 0px;
        border-bottom: 1px solid #f8f8ff !important;
    }
    .d-flex-bg-color {
        background-color:#333 !important;
    }
    .ep-bg-color {
        background-color:#f5f5f5 !important;
    }
    .btn1-bg-submit {
        margin:10px !important;
        background-color:#FFFFFF !important;
        color:#333 !important;
        font-weight:bold !important;	
    }
    .alerts-bg {
        background-color:#f0f0f0;
        padding:10px;
    }
    .bg-alerts-bg {
        background-color:#FFFFFF !important;
    }
    .alerts-table {
        height:300px !important;
    }
    .sourcing-table {
        width:100%;
    }
    .sourcing-table tr:nth-child(odd), .sourcing-table tr:nth-child(even)  {
        background-color: #fff !important;
        color: #333!important;
        text-align:left;
    }
    .tab-pane {
        height:292px;
        background-color:#fff !important;
    }
    .nav-tabs {
        border-bottom: 1px solid #d9d9d9;
        background-color: #fffefe;
    }
    .fs-14 {
        font-size:14px !important;
    }
    .bold {
        font-weight: bold;
    }
    .req-input:after {
        content: " *";
        color: red;
    }
    .td1 {
        width: 40%;
        padding: 8px 0;
    }
    .td2 {
        width: 60%;
    }
    .td2 input, .td2 select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .btn1 {
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn1-bg-update {
        background-color: #007bff;
        color: white;
    }
    .btn1-bg-update:hover {
        background-color: #0069d9;
    }
    .btn1-bg-cancel {
        background-color: #6c757d;
        color: white;
    }
    .btn1-bg-cancel:hover {
        background-color: #5a6268;
    }
    .box{
        background-color: #FFFFFF;
        
        border: 1px solid #fff;
    }
    
</style>

<h1 class="container" style="font-size: 30px !important;">User Role Setup</h1>

<div class="container pt-0 mt-5 p-0 box">
<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data" autocomplete="off">
    <div class="row m-10 p-0 pt-1 pb-3">
        <input type="hidden" name="update_role" id="update_role_id">
        <!-- Left Column: Role Name (smaller) -->
        <div class="col-md-6">
            <table class="w-100">
                <tbody>
                    <tr class="tr">
                        <td class="td1 fs-14 bold req-input">Role Name</td>
                        <td class="td2">
                            <input type="text" name="role_name" class="form-control" required>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Right Column: Allowed Pages (larger) -->
        <div class="col-md-12">
            <h2 class="td1 fs-14 bold req-input">Give Access to Pages</h2>
            <table class="w-100">
                <tbody>
                    <tr>
                        <td>
                            <div class="row" style=" padding: 20px;">
                                <?php
                                $pages = [
                                    'admin_page.php', 'moderator_page.php', 'user_page.php', 'alternative_mail_setup.php',
                                    'check_password_vendor.php', 'company_info.php', 'cost_avoidance.php', 'currency_info.php',
                                     'event_commodity.php', 'event_sub_commodity.php', 'get_master_vendor_ajax.php',
                                    'group_create.php', 'item_group.php', 'action_logs.php', 'item_info.php',
                                    'item_sub_group.php', 'mail_logs.php', 'mail_template.php', 'pass_var.php',
                                    'sourcing_type.php', 'unit_management.php', 'update_pass_change_link.php', 'update_pass_change_link_vendor.php',
                                    'user_department.php', 'user_division.php', 'user_info.php', 'user_info_self.php',
                                    'user_p_update.php', 'vendor_category.php', 'vendor_info.php', 'vendor_info_old.php', 'vendor_massage.php'
                                ];

                                $columns = 4;
                                $count = count($pages);
                                $perColumn = ceil($count / $columns);

                                for ($col = 0; $col < $columns; $col++) {
                                    echo '<div style="width: 25%; float: left;">';
                                    for ($i = $col * $perColumn; $i < ($col + 1) * $perColumn && $i < $count; $i++) {
                                        $page = $pages[$i];
                                        echo '<div style="margin-bottom: 5px;">';
                                        echo '<input type="checkbox" name="allowed_page[]" value="' . $page . '" id="page_' . $i . '" style="margin-right: 5px;">';
                                        echo '<label for="page_' . $i . '">' . $page . '</label>';
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                }
                                ?>
                                <div style="clear: both;"></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <!-- Submit Button -->
        <div class="w-100 pt-3 text-center">
            <button type="submit" class="btn1 btn-success" id="submitBtn">Submit</button>
        </div>
    </div>
</form>


    
    <div class="container pt-3">
        <h3>Existing Roles</h3>
        <table id="user_info" class="table1 table-striped table-bordered table-hover table-sm">
            <thead class="thead1">
                <tr class="bgc-info">
                    <th>ID</th>
                    <th>Role Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($qry && mysqli_num_rows($qry) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($qry)) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td>
                                <button type="button" 
                                        class="btn1 btn1-bg-update btn-sm" 
                                        onclick="editRole('<?php echo htmlspecialchars($row['id']); ?>', 
                                                         '<?php echo htmlspecialchars($row['name']); ?>', 
                                                         '<?php echo htmlspecialchars($row['allowed_page']); ?>')">
                                    Update
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No roles found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
    function editRole(id, name, allowedPages) {
        document.getElementsByName('role_name')[0].value = name;
        document.getElementById('update_role_id').value = id;
        
        // Reset all checkboxes
        document.querySelectorAll('input[name="allowed_page[]"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Parse the JSON string of allowed pages
        const pages = JSON.parse(allowedPages);
        
        // Check the appropriate checkboxes
        pages.forEach(page => {
            const checkbox = document.querySelector(`input[name="allowed_page[]"][value="${page}"]`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
        
        // Change submit button text
        document.getElementById('submitBtn').textContent = 'Update';
        
        // Scroll to form
        document.getElementById('form1').scrollIntoView({ behavior: 'smooth' });
    }
    </script>
</div>

<?
datatable("#user_info");
require_once SERVER_ROOT."public/assets/datatable/datatable.php";
require_once "../../../controllers/routing/layout.bottom.php";
?>