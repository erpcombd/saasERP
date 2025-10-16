<?php
session_start();
require_once "../../../assets/support/inc.all.php";
$contact_no = $_REQUEST['contact_no'];
$contact_check = find_a_field('dealer_pos','dealer_name','contact_no="'.$contact_no.'"');
if($contact_check!=''){
$all_dealer[] ="Phone No. Already Used ! ( ".$contact_check." )";
}else{
$all_dealer[] = '';
}
echo json_encode($all_dealer);
?>