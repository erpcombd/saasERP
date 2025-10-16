<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";  // ✅ fixed

$entry_by = $_SESSION['user']['id'];
$PBI_ID   = $_REQUEST['PBI_ID']; 
$id       = $_REQUEST['inc_id']; 
$entry_at = date('Y-m-d H:i:s');

// --------- Update salary_info ----------
$sqlo = "UPDATE salary_info s
JOIN increment_detail d ON s.PBI_ID = d.PBI_ID
SET
    s.basic_salary      = d.new_basic_salary, 
    s.house_rent        = d.new_house_rent,
    s.convenience       = d.new_convenience,
    s.medical_allowance = d.new_medical_allowance,
    -- s.technical        = d.technical_new,   -- ❌ check real column name
    s.special_allowance = d.new_special_allowance,
   
    s.food_allowance    = d.new_food_allowance,
    s.mobile_allowance  = d.new_mobile_allowance,
    s.total_salary      = d.grossSalary_new,
    s.total_payable     = d.grossSalary_new,
    s.cash_amt          = d.grossSalary_new,
    s.gross_salary      = d.grossSalary_new
WHERE s.PBI_ID = '$PBI_ID' 
  AND d.INCREMENT_D_ID = '$id'";

mysqli_query($conn, $sqlo) or die(mysqli_error($conn));

// --------- Update personnel_basic_info ----------
$pbi_info = "UPDATE personnel_basic_info s
JOIN increment_detail d ON s.PBI_ID = d.PBI_ID
SET
    s.PBI_ORG        = d.PBI_ORG_NEW, 
    s.PBI_FUNCTION   = d.PBI_FUNCTION_NEW,
    s.DEPT_ID        = d.DEPT_ID_NEW,
    s.section        = d.section_new,
    s.cost_center    = d.cost_center_new,
    s.DESG_ID        = d.DESG_ID_NEW,
    s.grade          = d.grade_new,
    s.salary_schedule= d.salary_schedule_new,
    s.class          = d.class_new,
    s.JOB_LOC_ID     = d.JOB_LOC_ID_NEW,
    s.edit_by        = '$entry_by'
    
WHERE s.PBI_ID = '$PBI_ID' 
  AND d.INCREMENT_D_ID = '$id'";

mysqli_query($conn, $pbi_info) or die(mysqli_error($conn));

// --------- Update increment_detail ----------
$status_update = "UPDATE increment_detail 
SET status = 'APPROVED',
    approve_by = '$entry_by',
    approve_at = '$entry_at'
WHERE PBI_ID = '$PBI_ID' 
  AND INCREMENT_D_ID = '$id'";

mysqli_query($conn, $status_update) or die(mysqli_error($conn));

echo '<p style="color:red;">Approved Successful</p>';
?>
