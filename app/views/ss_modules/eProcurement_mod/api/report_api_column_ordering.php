<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

header('Content-Type: application/json');

// Read the JSON input
$input = json_decode(file_get_contents('php://input'), true);

$reportId = $input['unique_report_name'] ?? '';
$columnName = 'column_ordanizer';  // Fixed column name for testing
$columnOrder = $input['new_order'] ?? '';

// Check if `new_order` is an array and convert it to a JSON string
if (is_array($columnOrder)) {
    $columnOrder = json_encode($columnOrder);  // Convert to JSON string or implode(',', $columnOrder) for comma-separated values
}

// Check if values are empty or invalid before proceeding
if (empty($reportId) || empty($columnOrder)) {
    $response = ['status' => 'error', 'message' => 'Missing report ID or column order'];
    echo json_encode($response);
    exit;
}

try {
    // Begin transaction
    $conn->begin_transaction();

    // Prepare the SQL query with placeholders
    $query = "
        INSERT INTO report_structure_information (report_id, column_order, column_name) 
        VALUES (?, ?, ?) 
        ON DUPLICATE KEY UPDATE 
            column_order = VALUES(column_order)
    ";

    // Prepare the statement
    $stmt = $conn->prepare($query);
    
    // Bind parameters
    $stmt->bind_param("iss", $reportId, $columnOrder, $columnName);  // 'iss' for integer reportId

    // Execute the statement
    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            $conn->commit();
            $response = [
                'status' => 'success',
                'message' => 'Row inserted or updated successfully',
                'query' => "INSERT INTO report_structure_information (report_id, column_order, column_name) 
                            VALUES ('$reportId', '$columnOrder', '$columnName') 
                            ON DUPLICATE KEY UPDATE column_order = '$columnOrder'"
            ];
        } else {
            $conn->rollback();
            $response = [
                'status' => 'error',
                'message' => 'No rows affected. Please check the input values or duplicate key rules.',
                'query' => "INSERT INTO report_structure_information (report_id, column_order, column_name) 
                            VALUES ('$reportId', '$columnOrder', '$columnName') 
                            ON DUPLICATE KEY UPDATE column_order = '$columnOrder'"
            ];
        }
    } else {
        $conn->rollback();
        $response = [
            'status' => 'error',
            'message' => 'Insert/Update failed: ' . $stmt->error,
            'query' => "INSERT INTO report_structure_information (report_id, column_order, column_name) 
                        VALUES ('$reportId', '$columnOrder', '$columnName') 
                        ON DUPLICATE KEY UPDATE column_order = '$columnOrder'"
        ];
    }
} catch (Exception $e) {
    $conn->rollback();
    $response = [
        'status' => 'error',
        'message' => 'Transaction failed: ' . $e->getMessage(),
        'query' => "INSERT INTO report_structure_information (report_id, column_order, column_name) 
                    VALUES ('$reportId', '$columnOrder', '$columnName') 
                    ON DUPLICATE KEY UPDATE column_order = '$columnOrder'"
    ];
}

// Return response
echo json_encode($response);
?>
