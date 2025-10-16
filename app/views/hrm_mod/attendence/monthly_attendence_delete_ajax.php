<?
session_start();
require "../../config/inc.all.php";

$crud      =new crud('hrm_attendence_final');

//echo 'PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ';
$_POST[$unique] = $$unique = db_delete('hrm_attendence_final','PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ');
echo 'Deleted';
?>