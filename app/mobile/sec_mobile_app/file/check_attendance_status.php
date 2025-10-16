<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

// Ensure we have the required parameters
if(isset($_POST['user_id']) && isset($_POST['date'])) {
    $user_id = $_POST['user_id'];
    $date = $_POST['date'];
    
    // Get the latest status for this user and date
    $status_query = "SELECT approved_status FROM ss_location_log 
                     WHERE access_date='$date' 
                     AND user_id='$user_id' 
                     ORDER BY access_time DESC LIMIT 1";
    
    $result = findall($status_query);
    
    $status = "PENDING"; // Default status
    if(isset($result->approved_status) && !empty($result->approved_status)) {
        $status = $result->approved_status;
    }
    
    // Return the status as JSON
    echo json_encode(['status' => $status]);
} else {
    // If parameters are missing, return an error
    echo json_encode(['error' => 'Missing required parameters']);
}
?>