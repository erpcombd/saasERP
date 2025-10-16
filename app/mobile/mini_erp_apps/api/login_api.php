<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../../controllers/config/db_con_live_static.php");

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata, true);

if (!$new_conn) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . mysqli_connect_error()]));
}

$username = isset($result['username']) ? mysqli_real_escape_string($new_conn, $result['username']) : '';
$password  = isset($result['password']) ? mysqli_real_escape_string($new_conn, $result['password']) : '';

if (empty($username) || empty($password)) {
    die(json_encode(["status" => "error", "message" => "Mobile number and password are required"]));
}

// Check if user exists
 $check_user_query = "SELECT username, password, token FROM user_activity_management WHERE username = '$username'";
$check_user_result = mysqli_query($new_conn, $check_user_query);

if (mysqli_num_rows($check_user_result) == 1) {
    $user_data = mysqli_fetch_assoc($check_user_result);
    
    // Verify password
    if ($password == $user_data['password']) {
        echo json_encode(["status" => "success", "message" => "Login successful", "token" => $user_data['token']]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}

mysqli_close($new_conn);
?>
