<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';
$title = "Shop List";
$page = "shop_list.php";
$menu = 'shop';
$menu_active='active';
$username = $_SESSION['user']['username'];
$emp_code = $username;
require_once '../assets/template/inc.header.php';

// Initialize counter
$s = 0;

// Option 1: If the dealer_code is stored in u.dealer_code
$sql = "SELECT s.*, r.route_name 
        FROM ss_shop s
        INNER JOIN ss_route r ON s.route_id = r.route_id
        INNER JOIN ss_user u ON u.username = s.emp_code
        WHERE u.dealer_code = '" . mysqli_real_escape_string($conn, $emp_code) . "' 
        AND s.status = 1
        ORDER BY s.dealer_code DESC";

/* 
// Option 2: If the logged in user is the dealer and wants to see related shops
// This might be the case if the relationship is different
$sql = "SELECT s.*, r.route_name 
        FROM ss_shop s
        INNER JOIN ss_route r ON s.route_id = r.route_id
        INNER JOIN ss_user u ON u.username = s.emp_code
        WHERE s.dealer_code = '" . mysqli_real_escape_string($conn, $emp_code) . "' 
        AND s.status = 1
        ORDER BY s.dealer_code DESC";
*/

// Debug: Print the query to see what's being executed
// echo "<pre>$sql</pre>";

// Execute query with error handling
$query = mysqli_query($conn, $sql);

if (!$query) {
    echo "Database error: " . mysqli_error($conn);
    exit;
}

// Check if any shops found
if (mysqli_num_rows($query) == 0) {
    echo "<div class='alert alert-info'>No shops found for this dealer.</div>";
} else {
?>
    <div class="container">
        <h2>Shop List</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Shop Name</th>
                        <th>Route</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($data = mysqli_fetch_object($query)) {
                        $s++;
                    ?>
                        <tr>
                            <td><?php echo $s; ?></td>
                            <td><?php echo htmlspecialchars($data->shop_name ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($data->route_name ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($data->address ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($data->contact_person ?? ''); ?></td>
                            <td>
                                <a href="shop_edit.php?id=<?php echo $data->shop_id; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="shop_view.php?id=<?php echo $data->shop_id; ?>" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    <?php
                    } // End while loop
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
} // End else

// Include footer if needed
require_once '../assets/template/inc.footer.php';
?>;
?>