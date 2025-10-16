<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../../controllers/config/db_con_live_static.php");

// Get JSON request data
$pdata  = file_get_contents("php://input");
$result = json_decode($pdata, true);

if (!isset($result['mobile_no']) || !isset($result['otp'])) {
    echo json_encode(["status" => "error", "message" => "Mobile number and OTP are required"]);
    exit;
}

$mobile_no = $result['mobile_no'];
$otp = $result['otp'];

// Fetch the latest OTP for the given mobile number
$query = "SELECT * FROM forgot_pass_email_otp 
          WHERE mobile_no = '$mobile_no' 
          ORDER BY entry_at DESC 
          LIMIT 1";
$result = mysqli_query($new_conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $stored_otp = $row['otp'];
    $expire_date = $row['expire_date'];
    $otp_status = $row['status'];

    if ($otp_status !== 'PENDING') {
        echo json_encode(["status" => "error", "message" => "OTP already used or invalid"]);
        exit;
    }

    if (strtotime($expire_date) < time()) {
        echo json_encode(["status" => "error", "message" => "OTP expired"]);
        exit;
    }

    if ($otp == $stored_otp) {
        // Update OTP status to VERIFIED
        $update_query = "UPDATE forgot_pass_email_otp SET status = 'VERIFIED' WHERE id = ".$row['id'];
        mysqli_query($new_conn, $update_query);

        // Update user_activity_management table to mark OTP as verified
        $update_activity_query = "UPDATE user_activity_management 
                                  SET otp_verified = 1 
                                  WHERE mobile = '$mobile_no'";
        mysqli_query($new_conn, $update_activity_query);

        echo json_encode(["status" => "success", "message" => "OTP verified successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid OTP"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No OTP found"]);
}
?>
