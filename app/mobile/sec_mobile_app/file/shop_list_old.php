<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Shop List";
$page = "shop_list.php";
$username = $_SESSION['user']['username'];
$emp_code = $username;
require_once '../assets/template/inc.header.php';
?>

<div class="page-content header-clear-medium">
    <?php
    $sql = "SELECT 
                m.do_no, 
                s.*, 
                SUM(d.total_amt) AS total_amt, 
                m.do_date 
            FROM 
                ss_shop s
                JOIN ss_do_master m ON s.dealer_code = m.dealer_code
                JOIN ss_do_details d ON m.do_no = d.do_no
            WHERE 
                m.status = 'CHECKED' 
                AND m.entry_by = '" . $emp_code . "'
            GROUP BY 
                m.do_no 
            ORDER BY 
                m.do_no DESC";

    $query = db_query($sql);
    while ($data = mysqli_fetch_object($query)) {
    ?>
        <div class="card card-style card-bg mb-3">
            <div class="content p-3">
                <div class="d-flex align-items-start">
                    <div>
                        <h2 class="font-700 mb-2 f-16">
                            <span class="text-span">Shop Name:</span> <?= htmlspecialchars($data->shop_name) ?>
                        </h2>
                        <p class="mb-1 f-14">
                            <strong>Route Name:</strong> <span class="text-primary"><?= htmlspecialchars($data->route_id) ?></span>
                        </p>
                        <p class="mb-1 f-14">
                            <strong>Shop Address:</strong> <span class="text-success"><?= htmlspecialchars($data->shop_address) ?></span>
                        </p>
                        <p class="mb-1 f-14">
                            <strong>Owner Name:</strong> <span class="text-primary"><?= htmlspecialchars($data->shop_owner_name) ?></span>
                        </p>
                        <p class="mb-1 f-14">
                            <strong>Mobile No:</strong> <span class="text-danger"><?= htmlspecialchars($data->mobile) ?></span>
                        </p>
                    </div>
                    <?php /*?><div class="ms-auto">
                        <a href="do_chalan.php?do=<?= urlencode($data->do_no) ?>" class="btn btn-info btn-3d text-light" style="height: 35px; padding: 5px 10px;">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div><?php */?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php
require_once '../assets/template/inc.footer.php';
?>