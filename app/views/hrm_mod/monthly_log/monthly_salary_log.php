<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Monthly Salary log";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_new'])) {
    $salary_month = $_POST['salary_month'];
    $month_type = $_POST['month_type'];
    $status = $_POST['status'];
    
    if (!empty($salary_month) && !empty($month_type) && !empty($status)) {
        $insert_sql = "INSERT INTO salary_months (salary_month, month_type, status) 
                       VALUES ('$salary_month', '$month_type', '$status')";
        
        if (db_query($insert_sql)) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?msg=success&type=add");
            exit();
        } else {
            header("Location: " . $_SERVER['PHP_SELF'] . "?msg=error&type=add");
            exit();
        }
    } else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?msg=validation&type=add");
        exit();
    }
}
 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_record'])) {
    $update_id = (int)$_POST['update_id'];
    $status = $_POST['update_status'];
    
    $update_sql = "UPDATE salary_months SET status = '$status' WHERE id = $update_id";
    
    if (db_query($update_sql)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?msg=success&type=update");
        exit();
    } else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?msg=error&type=update");
        exit();
    }
}

$message = '';
if (isset($_GET['msg']) && isset($_GET['type'])) {
    $msg = $_GET['msg'];
    $type = $_GET['type'];
    
    if ($msg == 'success' && $type == 'add') {
        $message = "<div class='alert alert-success'>New salary month added successfully!</div>";
    } elseif ($msg == 'success' && $type == 'update') {
        $message = "<div class='alert alert-success'>Record updated successfully!</div>";
    } elseif ($msg == 'error' && $type == 'add') {
        $message = "<div class='alert alert-danger'>Error adding new salary month.</div>";
    } elseif ($msg == 'error' && $type == 'update') {
        $message = "<div class='alert alert-danger'>Error updating record.</div>";
    } elseif ($msg == 'validation') {
        $message = "<div class='alert alert-warning'>Please fill all required fields.</div>";
    }
}

?>

<div class="container">
    <h4 class="text-center bg-titel bold pt-2 pb-2">Monthly Salary log Status</h4>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5>Add New Salary Month</h5>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <label for="salary_month">Salary Month:</label>
                        <input type="month" name="salary_month" id="salary_month" class="form-control" required>
                    </div>
                    <input type="hidden" name="month_type" value="2">
                    <div class="col-md-3">
                        <label for="status">Status:</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="Active">Active</option>
                            <option value="In-Active">In-Active</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label><br>
                        <button type="submit" name="add_new" class="btn btn-success">Add New</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="clearfix">
        &nbsp;
    </div>

    <form action="" method="post">
        <table class="table1 table-striped table-bordered table-hover table-sm">
            <thead class="thead1">
                <tr class="bgc-info">
                    <th>ID</th>
                    <th>Salary Month</th> 
                    <th>Month Type</th>
                    <th>Status</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            
            <tbody class="tbody1">
                <?php
                $sql = 'SELECT * FROM salary_months ORDER BY id DESC';
                $query = db_query($sql);
                while ($data = mysqli_fetch_object($query)) {
                ?>
                <tr>
                    <td><?= $data->id ?></td>
                    <td><?= $data->salary_month ?></td>
                    <td><?= $data->month_type ?></td>
                    
                    <input type="hidden" name="upId<?=$data->id ?>" id="upId<?=$data->id ?>" value="<?=$data->id ?>">
                    <td>
                        <select name="statusUp<?=$data->id ?>" id="statusUp<?=$data->id ?>" class="form-control">
                            <option value="<?= $data->status ?>"><?= $data->status ?></option>
                            <option value="Active">Active</option>
                            <option value="In-Active">In-Active</option>	
                        </select>
                    </td>
                    
                    <td><?= $data->updated_at ?></td>
            
                    <td>
                        <span id="show<?=$data->id ?>">
                            <button type="button" name="update<?=$data->id ?>" id="update<?=$data->id ?>" 
                                    onclick="getData2('monthly_salary_log_ajax.php', 'show<?=$data->id ?>', document.getElementById('upId<?=$data->id ?>').value, document.getElementById('statusUp<?=$data->id ?>').value);" 
                                    class="btn1 btn1-bg-update">Update</button>                         
                        </span>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
</div>

<script>

</script>

<?php require_once SERVER_CORE."routing/layout.bottom.php"; ?>