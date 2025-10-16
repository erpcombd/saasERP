<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";

$title = "Table Data Delete";
do_datatable('master_table');

// Handle table truncation
if (isset($_POST['truncate_table'])) {
    $tableToDelete = $_POST['truncate_table'];
    db_query("TRUNCATE TABLE `$tableToDelete`");
    $_SESSION['message'] = "Table `$tableToDelete` has been truncated successfully.";
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
    exit();
}

?>

<div class="container">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <table id="master_table" class="table1 table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
            <tr class="bgc-info">
                <th>Table Name</th>
                <th>Row Count</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?
            $query = db_query("SELECT table_name, table_rows  
                FROM information_schema.tables 
                WHERE table_schema = '" . $_SESSION['db_name'] . "'");
            while ($data = mysqli_fetch_object($query)) {
                if ($data->table_rows > 0) {
            ?>
                <tr class="text-left">
                    <td><?= $data->table_name ?></td>
                    <td><?= $data->table_rows ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete all data in <?= $data->table_name ?>?');">
                            <input type="hidden" name="truncate_table" value="<?= $data->table_name ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <? } } ?>
        </tbody>
    </table>
</div>

<?
require_once SERVER_CORE . "routing/layout.bottom.php";
?>
