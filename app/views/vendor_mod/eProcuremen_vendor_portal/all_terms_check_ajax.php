<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$vendor = $_SESSION['vendor']['id'];
$sql = 'select * from rfq_vendor_terms_condition where vendor_id='.$vendor.' and  rfq_no="'.$_SESSION['rfq_no'].'"';
$qry = db_query($sql);
$all_conditions_met = true;
if (mysqli_num_rows($qry) == 0) {
    $all_conditions_met=false;
}else{

    while($res = mysqli_fetch_object($qry)){
        if ($res->condition_1 != 1 || $res->condition_2 != 0) {
            $all_conditions_met = false;
            break;
        }
    
    }
}

echo json_encode(['all_conditions_met' => $all_conditions_met]);
 ?>

