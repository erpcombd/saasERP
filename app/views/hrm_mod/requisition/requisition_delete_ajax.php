<?
session_start();
require "../../config/inc.all.php";

$crud      =new crud('hrm_requisition');

//echo 'PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ';
$_POST[$unique] = $$unique = db_delete('hrm_requisition','dealer_code="'.$_REQUEST['dealer_code'].'" 
and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ');
echo 'Deleted';
?>