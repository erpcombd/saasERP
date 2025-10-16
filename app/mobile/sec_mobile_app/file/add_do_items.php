<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

// Verify user is logged in
if(!isset($_SESSION['user']) || empty($_SESSION['user']['warehouse_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
    exit;
}

// Get form data
$do_no = isset($_POST['do_no']) ? intval($_POST['do_no']) : 0;
$selected_items = isset($_POST['selected_items']) ? $_POST['selected_items'] : array();
$item_quantities = isset($_POST['qty']) ? $_POST['qty'] : array();
$nsp_percentages = isset($_POST['nsp_per']) ? $_POST['nsp_per'] : array();
$tp_prices = isset($_POST['tp']) ? $_POST['tp'] : array();

// Validate DO number
if($do_no <= 0) {
    echo "<script>alert('Invalid DO number'); window.history.back();</script>";
    exit;
}

// Validate selected items
if(empty($selected_items)) {
    echo "<script>alert('Please select at least one item'); window.history.back();</script>";
    exit;
}

$success_count = 0;
$error_count = 0;
$messages = array();

// Process each selected item
foreach($selected_items as $item_id) {
    $item_id = intval($item_id);
    $qty = isset($item_quantities[$item_id]) ? floatval($item_quantities[$item_id]) : 0;
    $nsp_per = isset($nsp_percentages[$item_id]) ? floatval($nsp_percentages[$item_id]) : 0;
    $tp = isset($tp_prices[$item_id]) ? floatval($tp_prices[$item_id]) : 0;
    
    // Skip if quantity is 0 or less
    if($qty <= 0) {
        continue;
    }
    
    // Calculate unit price after NSP discount
    $unit_price = $tp * (1 - ($nsp_per / 100));
    $total_amt = $qty * $unit_price;
    
    // Check if item already exists in DO
    $check_sql = "SELECT do_details_id, pkt_unit FROM ss_do_details WHERE do_no = ? AND item_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "ii", $do_no, $item_id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if(mysqli_num_rows($check_result) > 0) {
        // Item exists, update it
        $row = mysqli_fetch_object($check_result);
        
        // Add to existing quantity instead of replacing
        $new_qty = $row->pkt_unit + $qty;
        $new_total = $new_qty * $unit_price;
        
        $update_sql = "UPDATE ss_do_details SET 
                       pkt_unit = ?,
                       nsp_per = ?, 
                       unit_price = ?,
                       total_amt = ?,
                       updated_at = NOW()
                       WHERE do_details_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "ddddi", $new_qty, $nsp_per, $unit_price, $new_total, $row->do_details_id);
        
        if(mysqli_stmt_execute($update_stmt)) {
            $success_count++;
            $messages[] = "Updated item ID $item_id (Qty: $qty added to existing)";
        } else {
            $error_count++;
            $messages[] = "Failed to update item ID $item_id: " . mysqli_error($conn);
        }
    } else {
        // Item doesn't exist, insert it
        $insert_sql = "INSERT INTO ss_do_details 
                      (do_no, item_id, pkt_unit, nsp_per, unit_price, total_amt, created_at) 
                      VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $insert_stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "iidddd", $do_no, $item_id, $qty, $nsp_per, $unit_price, $total_amt);
        
        if(mysqli_stmt_execute($insert_stmt)) {
            $success_count++;
            $messages[] = "Added new item ID $item_id (Qty: $qty)";
        } else {
            $error_count++;
            $messages[] = "Failed to add item ID $item_id: " . mysqli_error($conn);
        }
    }
}

// Update DO total
$total_sql = "UPDATE ss_do_header SET 
              total_amt = (SELECT SUM(total_amt) FROM ss_do_details WHERE do_no = ?),
              updated_at = NOW()
              WHERE do_no = ?";
$total_stmt = mysqli_prepare($conn, $total_sql);
mysqli_stmt_bind_param($total_stmt, "ii", $do_no, $do_no);
mysqli_stmt_execute($total_stmt);

// Prepare response message
$message = "Items processed successfully!\n";
$message .= "Success: $success_count items\n";
if($error_count > 0) {
    $message .= "Errors: $error_count items\n";
}

// Return response
if($error_count > 0) {
    // Show detailed messages if there were errors
    $detailed_message = $message . "\n\nDetails:\n" . implode("\n", $messages);
    echo "<script>alert('" . addslashes($detailed_message) . "'); window.history.back();</script>";
} else {
    // Show success message and redirect/refresh
    echo "<script>
        alert('" . addslashes($message) . "');
        if(window.opener) {
            window.opener.location.reload();
            window.close();
        } else {
            window.location.reload();
        }
    </script>";
}
?>