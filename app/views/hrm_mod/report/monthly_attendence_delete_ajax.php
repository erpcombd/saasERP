<?
session_start();
require "../../config/inc.all.php";

$crud      =new crud('salary_attendence');
$unique = 'id';
$mon=$_GET['mon'];
$year=$_GET['year'];
$startTime = $days1=mktime(0,0,0,$mon,01,$year);
$endTime = $days2=mktime(0,0,0,$mon,date('t',$startTime),$year);

$days_in_month = date('t',$endTime);

//echo 'PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ';
$_POST[$unique] = $$unique = db_delete('salary_attendence','PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ');

?>