<?php

include("../../../controllers/config/db_con_live_static.php");

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata, true);

if (!$new_conn) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . mysqli_connect_error()]));
}

$mobile_no = isset($result['mobile_no']) ? mysqli_real_escape_string($new_conn, $result['mobile_no']) : '';
// $password  = isset($result['password']) ? mysqli_real_escape_string($new_conn, $result['password']) : '';

if (empty($mobile_no)) {
    die(json_encode(["status" => "error", "message" => "Mobile number is required"]));
}

// Check if user already exists in user_activity_management
 $check_user_query = "SELECT username FROM user_activity_management WHERE mobile = '$mobile_no'";
$check_user_result = mysqli_query($new_conn, $check_user_query);

if (mysqli_num_rows($check_user_result) > 0) {
    die(json_encode(["status" => "error", "message" => "User already exists"]));
}

// Hash the password
// $hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Generate unique token
// $token = bin2hex(random_bytes(32));

// Insert into user_activity_management table
$insert_user_query = "INSERT INTO user_activity_management (mobile, otp_verified) VALUES ('$mobile_no', '0')";

if (mysqli_query($new_conn, $insert_user_query)) {
    echo json_encode(["status" => "success", "message" => "User registered successfully", "otp_verify" => "0"]);
} else {
    echo json_encode(["status" => "error", "message" => "User registration failed"]);
}

mysqli_close($new_conn);
?>
