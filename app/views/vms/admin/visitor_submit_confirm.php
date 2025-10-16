<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$company_id     = $_SESSION['company_id'];
$username       = $_SESSION['username'];



if($_POST['visitor_name']==!''){
    

    $visitor_name				= get_safe_value($conn,$_POST['visitor_name']);
    $visitor_nid				= get_safe_value($conn,$_POST['visitor_nid']);
    $visitor_mobile_no			= get_safe_value($conn,$_POST['visitor_mobile_no']);
    
    $visitor_address			= get_safe_value($conn,$_POST['visitor_address']);
    $visitor_meet_person_name	= get_safe_value($conn,$_POST['visitor_meet_person_name']);
    $visitor_department			= get_safe_value($conn,$_POST['visitor_department']);
    $visitor_reason_to_meet		= get_safe_value($conn,$_POST['visitor_reason_to_meet']);
    $visitor_card_no			= get_safe_value($conn,$_POST['visitor_card_no']);
    $visitor_in_image			= get_safe_value($conn,$_POST['visitor_in_image']);
    $visitor_id			        = get_safe_value($conn,$_POST['visitor_id']);
    
    
    $visitor_enter_date			= date('Y-m-d');
    $visitor_enter_time			= date('Y-m-d H:i:s');
    
    
echo    $sql = "insert ignore into visitor_table
    (company_id,visitor_name,visitor_nid,visitor_mobile_no,visitor_enter_date,visitor_enter_time,visitor_in_image,visitor_address,
    visitor_meet_person_name,visitor_department,visitor_reason_to_meet,visitor_card_no,visitor_entry_by) 
    
    values
    
    ('$company_id','$visitor_name','$visitor_nid','$visitor_mobile_no','$visitor_enter_date','$visitor_enter_time','$visitor_in_image','$visitor_address',
    '$visitor_meet_person_name','$visitor_department','$visitor_reason_to_meet','$visitor_card_no','$username')";
    
    mysqli_query($conn,$sql);
    
    
    $sql_update="update visitor_table_self set sync_status=1 where visitor_id='".$visitor_id."'";
    mysqli_query($conn,$sql_update);
    
    
    echo "insert";
}
// end form submit


?>