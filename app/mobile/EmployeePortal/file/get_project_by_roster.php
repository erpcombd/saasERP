<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "config/db_con_live_static.php";

// Set JSON response header
header('Content-Type: application/json; charset=utf-8');

// Read POST values
$roster_date = $_POST['roster_date'] ?? '';
$PBI_ID = $_POST['PBI_ID'] ?? '';

// Debug log (optional)
file_put_contents('debug_log.txt', "roster_date: $roster_date | PBI_ID: $PBI_ID\n", FILE_APPEND);

// Check inputs
if ($roster_date && $PBI_ID) {
    $sql = "SELECT point_1 FROM hrm_roster_allocation
            WHERE PBI_ID = '$PBI_ID' 
            AND roster_date = '$roster_date'";

    $result = mysqli_query($new_conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Ensure proper JSON format
        echo json_encode(['point_1' => $row['point_1']]);
    } else {
        echo json_encode(['point_1' => null, 'message' => 'No data found']);
    }
} else {
    echo json_encode(['point_1' => null, 'message' => 'Missing inputs']);
}
?>
