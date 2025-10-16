<?
session_start();
require "../../config/inc.all.php";

$crud      =new crud('hrm_requisition');
$unique = 'id';
$mon=$_GET['mon'];
$year=$_GET['year'];


//$days_in_month = date('t',$endTime);

$_POST[$unique] = $$unique = find_a_field('hrm_requisition','id','dealer_code="'.$_REQUEST['dealer_code'].'" and mon="'.$_REQUEST['mon'].'" 
and year="'.$_REQUEST['year'].'" ');

//$_REQUEST['dealer_code'] = $_REQUEST['ot'];
//$_REQUEST['ot'] = 0;
if($$unique>0)
{
$_REQUEST['status']='apply';
$_REQUEST['edit_by']=$_SESSION['user']['id'];
$_REQUEST['edit_at']=date('Y-m-d H:i:s');
echo 'Updated!';
$crud->update($unique);
}
else
{
$_REQUEST['status']='apply';
$_REQUEST['entry_by']=$_SESSION['user']['id'];
$_REQUEST['entry_at']=date('Y-m-d H:i:s');
echo 'Saved!';
$crud->insert();
}
?>