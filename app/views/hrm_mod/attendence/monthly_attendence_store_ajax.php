<?
session_start();
require "../../config/inc.all.php";

$crud      =new crud('hrm_attendence_final');
$unique = 'id';
$mon=$_GET['mon'];
$year=$_GET['year'];


$da =  find_all_field('hrm_payroll_setup','',' `year` = "'.$year.'" and `mon` = "'.$mon.'" ');
$days_in_month = $da->days_of_month;

$_POST[$unique] = $$unique = find_a_field('hrm_attendence_final','id','PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ');

$_REQUEST['dealer_code'] = $_REQUEST['ot'];
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