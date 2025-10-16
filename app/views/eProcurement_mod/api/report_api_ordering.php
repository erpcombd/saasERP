<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

header('Content-Type: application/json');

// Read the JSON input
$input = json_decode(file_get_contents('php://input'), true);

$reportId = $input['unique_report_name'] ?? '';
$columnName = $input['column_header'] ?? '';
$sort_order = $input['sort_order'] ?? '';
$column_index = $input['columnindex'] ?? '';

// Begin transaction
$conn->begin_transaction();

// Insert or update the record
$query = "
    INSERT INTO report_structure_information (report_id, sort_order, column_name, column_index) 
    VALUES (?, ?, ?, ?) 
    ON DUPLICATE KEY UPDATE 
        sort_order = VALUES(sort_order),
        column_index = VALUES(column_index)
";

$stmt = $conn->prepare($query);
$stmt->bind_param("isss", $reportId, $sort_order, $columnName, $column_index);

if ($stmt->execute()) {
    // Update the sort_order for other columns: make them empty (null) except the updated column
    $updateQuery = "
        UPDATE report_structure_information 
        SET sort_order = NULL
        WHERE report_id = ? 
        AND column_index <> ?
    ";
    
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ss", $reportId, $column_index);
    
    if ($updateStmt->execute()) {
        $conn->commit();
        $response = ['status' => 'success', 'message' => 'Row inserted/updated and other sort orders cleared successfully'];
    } else {
        $conn->rollback();
        $response = ['status' => 'error', 'message' => 'Failed to clear other sort orders: ' . $updateStmt->error];
    }
} else {
    $conn->rollback();
    $response = ['status' => 'error', 'message' => 'Failed to insert/update row: ' . $stmt->error];
}

// Return response
echo json_encode($response);
?>
