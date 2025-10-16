<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user']['warehouse_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Get POST data
$do_no = isset($_POST['do_no']) ? intval($_POST['do_no']) : 0;
$item_id = isset($_POST['item_id']) ? intval($_POST['item_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

// Validate required parameters
if ($do_no <= 0 || $item_id <= 0 || empty($action)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    exit;
}

try {
    // Start transaction
    mysqli_autocommit($conn, FALSE);
    
    if ($action === 'update') {
        $qty = isset($_POST['qty']) ? floatval($_POST['qty']) : 0;
        $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
        $nsp_per = isset($_POST['nsp_per']) ? floatval($_POST['nsp_per']) : 0;
        
        // Check if item already exists in DO
        $check_sql = "SELECT id FROM ss_do_details WHERE do_no = ? AND item_id = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "ii", $do_no, $item_id);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        
        if ($qty > 0) {
            if (mysqli_num_rows($check_result) > 0) {
                // Update existing item - no duplicates allowed
                $update_sql = "UPDATE ss_do_details SET 
                              pkt_unit = ?, 
                              total_amt = pkt_unit * t_price,
                              nsp_per = ?,
                              updated_at = NOW()
                              WHERE do_no = ? AND item_id = ?";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "ddii", $qty, $nsp_per, $do_no, $item_id);
                
                if (mysqli_stmt_execute($update_stmt)) {
                    mysqli_commit($conn);
                    echo json_encode(['status' => 'success', 'message' => 'Item updated successfully']);
                } else {
                    throw new Exception('Failed to update item');
                }
                mysqli_stmt_close($update_stmt);
            } else {
                // Get item details for insertion
                $item_sql = "SELECT item_name, unit_name, t_price FROM item_info WHERE item_id = ?";
                $item_stmt = mysqli_prepare($conn, $item_sql);
                mysqli_stmt_bind_param($item_stmt, "i", $item_id);
                mysqli_stmt_execute($item_stmt);
                $item_result = mysqli_stmt_get_result($item_stmt);
                $item_data = mysqli_fetch_object($item_result);
                
                if (!$item_data) {
                    throw new Exception('Item not found');
                }
                
                // Insert new item (prevent duplicate by checking again)
                $insert_sql = "INSERT INTO ss_do_details 
                              (do_no, item_id, item_name, unit_name, pkt_unit, t_price, total_amt, nsp_per, created_at)
                              SELECT ?, ?, ?, ?, ?, ?, pkt_unit * t_price, ?, NOW()
                              WHERE NOT EXISTS (
                                  SELECT 1 FROM ss_do_details 
                                  WHERE do_no = ? AND item_id = ?
                              )";
                $insert_stmt = mysqli_prepare($conn, $insert_sql);
                $t_price = $item_data->t_price;
                mysqli_stmt_bind_param($insert_stmt, "iissddddii", 
                    $do_no, $item_id, $item_data->item_name, $item_data->unit_name, 
                    $qty, $t_price, $nsp_per, $do_no, $item_id);
                
                if (mysqli_stmt_execute($insert_stmt)) {

                    mysqli_commit($conn);
                    echo json_encode(['status' => 'success', 'message' => 'Item added successfully']);
                } else {
                    throw new Exception('Failed to add item');
                }
                mysqli_stmt_close($insert_stmt);
                mysqli_stmt_close($item_stmt);
            }
        } else {
            // Quantity is 0, remove item if it exists
            $delete_sql = "DELETE FROM ss_do_details WHERE do_no = ? AND item_id = ?";
            $delete_stmt = mysqli_prepare($conn, $delete_sql);
            mysqli_stmt_bind_param($delete_stmt, "ii", $do_no, $item_id);
            
            if (mysqli_stmt_execute($delete_stmt)) {
                mysqli_commit($conn);
                echo json_encode(['status' => 'success', 'message' => 'Item removed successfully']);
            } else {
                throw new Exception('Failed to remove item');
            }
            mysqli_stmt_close($delete_stmt);
        }
        mysqli_stmt_close($check_stmt);
        
    } elseif ($action === 'remove') {
        // Remove item completely
        $delete_sql = "DELETE FROM ss_do_details WHERE do_no = ? AND item_id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_sql);
        mysqli_stmt_bind_param($delete_stmt, "ii", $do_no, $item_id);
        
        if (mysqli_stmt_execute($delete_stmt)) {
            mysqli_commit($conn);
            echo json_encode(['status' => 'success', 'message' => 'Item removed successfully']);
        } else {
            throw new Exception('Failed to remove item');
        }
        mysqli_stmt_close($delete_stmt);
    } else {
        throw new Exception('Invalid action');
    }
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    mysqli_autocommit($conn, TRUE);
}
?>