<?
session_start();
require "../../config/inc.all.php";

$crud      =new crud('hrm_requisition');
$unique = 'id';
$mon=$_GET['mon'];
$year=$_GET['year'];



$_POST[$unique] = $$unique = find_a_field('hrm_requisition','id','dealer_code="'.$_REQUEST['dealer_code'].'" and mon="'.$_REQUEST['mon'].'" 
and year="'.$_REQUEST['year'].'" ');

//$_REQUEST['dealer_code'] = $_REQUEST['ot'];
//$_REQUEST['ot'] = 0;
if($$unique>0)
{
$_REQUEST['status']='approve';
$_REQUEST['approve_by']=$_SESSION['user']['id'];
$_REQUEST['approve_at']=date('Y-m-d H:i:s');
echo 'Approved!';
$crud->update($unique);
}

?>