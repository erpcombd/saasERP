<?
session_start();
//require "../../config/inc.all.php";

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$crud      =new crud('hrm_attendence_final');
$unique = 'id';
$mon=$_GET['mon'];
$year=$_GET['year'];

if($mon == 1)
{
$syear = $year - 1;
$smon = 12;
}
else
{
$syear = $year;
$smon =  $mon - 1;
}

$startTime 	= $days1=mktime(0,0,0,$smon,26,$year);
$endTime 	= $days2=mktime(0,0,0,$mon,25,$year);

$startday 	= date('Y-m-d',$startTime);
$endday 	= date('Y-m-d',$endTime);


$days_in_month = date('t',$endTime);



$_POST[$unique] = $$unique = find_a_field('hrm_attendence_final','id','PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ');

$_REQUEST['dealer_code'] = $_REQUEST['ot'];

if($_REQUEST['dealer_code']>0)
$_REQUEST['do_amt'] = find_a_field('sale_do_details','sum(total_amt)','dealer_code="'.$_REQUEST['dealer_code'].'" and do_date between "'.$startday.'" and "'.$endday.'" '); 
$_REQUEST['ot'] = 0;
if($$unique>0)
{
$_REQUEST['edit_by']=$_SESSION['user']['id'];
$_REQUEST['edit_at']=date('Y-m-d H:i:s');
echo 'Updated!';
$crud->update($unique);
}
else
{
$_REQUEST['entry_by']=$_SESSION['user']['id'];
$_REQUEST['entry_at']=date('Y-m-d H:i:s');
echo 'Saved!';
$crud->insert();
}
?>