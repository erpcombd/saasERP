<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";


header('Content-Type: application/json');




// Read the JSON input
$input = json_decode(file_get_contents('php://input'), true);

$reportId = $input['unique_report_name'] ?? '';
$columnName = $input['column_header'] ?? '';
$sort_order = $input['sort_order'] ?? '';
// $column_index = $input['columnindex'] ?? '';

// Insert or update the record
$query = "
    INSERT INTO report_structure_information (report_id, sort_order, column_name) 
    VALUES (?, ?, ?) 
    ON DUPLICATE KEY UPDATE 
        sort_order = VALUES(sort_order)
";

$stmt = $conn->prepare($query);
$stmt->bind_param("isss", $reportId, $sort_order, $columnName);

if ($stmt->execute()) {
    $response = ['status' => 'success', 'message' => 'Row inserted or updated successfully'];
} else {
    $response = ['status' => 'error', 'message' => $stmt->error];
}

// Return response
echo json_encode($response);
?>
