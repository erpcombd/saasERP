<?php

include("../../../controllers/config/db_con_live_static.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$pdata  = file_get_contents("php://input");
$result = json_decode($pdata, true);

if (!$new_conn) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . mysqli_connect_error()]));
}

$username = isset($result['username']) ? mysqli_real_escape_string($new_conn, $result['username']) : '';
$password  = isset($result['password']) ? mysqli_real_escape_string($new_conn, $result['password']) : '';
$mobile_no  = isset($result['mobile_no']) ? mysqli_real_escape_string($new_conn, $result['mobile_no']) : '';

if (empty($username) || empty($password) || empty($mobile_no)) {
    die(json_encode(["status" => "error", "message" => "Mobile number, username, and password are required"]));
}

// Check if user exists and if OTP is verified
$check_user_query = "SELECT username, otp_verified FROM user_activity_management WHERE mobile = '$mobile_no'";
$check_user_result = mysqli_query($new_conn, $check_user_query);

if ($row = mysqli_fetch_assoc($check_user_result)) {
    if ($row['otp_verified'] != 1) {
        die(json_encode(["status" => "error", "message" => "OTP not verified", "otp_verified" => false]));
    }
} else {
    die(json_encode(["status" => "error", "message" => "User not found"]));
}

// Check if the username already exists for another user
$check_username_query = "SELECT username FROM user_activity_management WHERE username = '$username' AND mobile != '$mobile_no'";
$check_username_result = mysqli_query($new_conn, $check_username_query);

if (mysqli_num_rows($check_username_result) > 0) {
    die(json_encode(["status" => "error", "message" => "Username already exists"]));
}

// Hash the password (if needed, uncomment this line)
// $hashed_password = password_hash($password, PASSWORD_BCRYPT);
$hashed_password = $password; // Keeping as plain text based on your previous logic

// Generate unique token
$token = bin2hex(random_bytes(32));

// Update the user in user_activity_management table
$update_user_query = "UPDATE user_activity_management 
                      SET username = '$username', password = '$hashed_password', token = '$token'
                      WHERE mobile = '$mobile_no'";

if (mysqli_query($new_conn, $update_user_query)) {
    echo json_encode(["status" => "success", "message" => "User updated successfully",]);
} else {
    echo json_encode(["status" => "error", "message" => "User update failed"]);
}

mysqli_close($new_conn);
?>
