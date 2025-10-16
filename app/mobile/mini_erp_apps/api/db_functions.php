<?php
include("../../../controllers/config/db_con_live_static.php");


function isTokenValid($mobile_no, $token) {
    // Escape input to prevent SQL injection
    $mobile_no = mysqli_real_escape_string($new_conn, $mobile_no);
    $token = mysqli_real_escape_string($new_conn, $token);

    // Query to check if the token exists for the given mobile_no
    $query = "SELECT username FROM user_activity_management WHERE mobile = '$mobile_no' AND token = '$token'";
    $result = mysqli_query($new_conn, $query);

    if (mysqli_num_rows($result) > 0) {
        return true; // Token is valid
    } else {
        return false; // Token is invalid
    }
}
?>
