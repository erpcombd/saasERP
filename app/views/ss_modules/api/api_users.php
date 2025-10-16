<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_AUTH."db_con_live_static.php";

$pdata  = file_get_contents("php://input");
$result = json_decode($pdata); 

$user     = $result[0]->user;
$password = $result[0]->password;

function find1($new_conn, $sql){
    $query2 = mysqli_query($new_conn, $sql); 
    while($info2 = mysqli_fetch_object($query2)) {
        return $info2;
    }
    return null;
}

function ensure_not_null($value) {
    return $value !== null ? $value : "";
}

$sql1 = "SELECT * FROM ssn_user WHERE username = '".$user."' AND password = '".$password."' AND status='Active'";
$query = mysqli_query($new_conn, $sql1);  

$data = array();
while($info = mysqli_fetch_object($query)) {
    $newDeviceID = uniqid();
    $Temporary_stop_Checking_Device = '0';
    $updateDeviceID = "UPDATE ssn_user SET device_id = '".$Temporary_stop_Checking_Device."' WHERE user_id = '".$info->user_id."'";
    mysqli_query($new_conn, $updateDeviceID);
    $info->device_id = $newDeviceID;

    $region_name = find1($new_conn, "SELECT BRANCH_NAME FROM ssn_branch WHERE BRANCH_ID='".$info->region_id."'")->BRANCH_NAME;  
    $zone_name = find1($new_conn, "SELECT ZONE_NAME FROM ssn_zone WHERE ZONE_CODE='".$info->zone_id."'")->ZONE_NAME;
    $area_name = find1($new_conn, "SELECT AREA_NAME FROM ssn_area WHERE AREA_CODE='".$info->area_id."'")->AREA_NAME;
    $info->password;
    $getdata = [
        'user_id'      => ensure_not_null($info->user_id),
        'user'         => ensure_not_null($info->username),
        'password'     => ensure_not_null($info->password),
        'full_name'    => ensure_not_null($info->fname),
        'mobile'       => ensure_not_null($info->mobile),
        'dealer_code'  => ensure_not_null($info->dealer_code),
        'region_id'    => ensure_not_null($info->region_id),
        'zone_id'      => ensure_not_null($info->zone_id),
        'area_id'      => ensure_not_null($info->area_id),
        'region_name'  => ensure_not_null($region_name),
        'zone_name'    => ensure_not_null($zone_name),
        'area_name'    => ensure_not_null($area_name),
        'user_image'   => ensure_not_null($info->profile_pic_url)
    ];

    array_push($data, $getdata);
}

echo json_encode($data[0]);

mysqli_close($new_conn);
?>
