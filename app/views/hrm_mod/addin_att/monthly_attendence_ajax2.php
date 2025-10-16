<?
session_start();
require_once "../../config/inc.all.php";
function auto_calculation($PBI_ID,$mon,$year){
$crud      =new crud('hrm_attendence_final');
$unique = 'id';
$PBI_ID = $_REQUEST['PBI_ID'];
$mon = $_REQUEST['mon'];
$year = $_REQUEST['year'];

$days1=mktime(1,1,1,$mon,1,$year);
$days_mon=date('t',$days1);

$start_date = $year.'-'.$mon.'-01';
$end_date = $year.'-'.$mon.'-'.$days_mon;

$_POST[$unique] = $$unique = find_a_field('hrm_attendence_final','id','PBI_ID="'.$PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');


$sql = 'select 
 access_date, access_time, access_stamp, start_time, off_day 
from hrm_inout where 
employee_id="'.$PBI_ID.'" and access_date between "'.$start_date.'" and "'.$end_date.'" group by access_date order by access_stamp desc';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$date = date('Ymd',$data->access_stamp);
$info['access_date'][$date]=$data->access_date;
$info['access_time'][$date]=$data->access_time;
$info['access_stamp'][$date]=$data->access_stamp;
$info['start_time'][$date]=$data->start_time;
$info['off_day'][$date]=$data->off_day;

$in_time = date('H:i:s',$data->access_stamp);
if($data->start_time=='')
{$info['status'][$date]='Regular';$info['bgcolor'][$date] = '#EAFFEF';++$regular;}
else{
$info['late'][$date] = (int)(($data->access_stamp - strtotime($data->access_date.' '.$data->start_time))/60);
if($info['late'][$date]>0) {++$late;$info['status'][$date]='Late';$info['bgcolor'][$date] = '#FFFFCC';} else {++$regular;$info['status'][$date]='Regular';$info['bgcolor'][$date] = '#EAFFEF';}
}
$info['off_day'][$date]=$data->off_day;
}
$_REQUEST['lt'] = $late;
$_REQUEST['ab'] = $_REQUEST['td'] - ($late + $regular);


$_REQUEST['pre'] = $_REQUEST['td'] - ($_REQUEST['ab'] + $_REQUEST['hd']);
$_REQUEST['pay'] = $_REQUEST['td'] - ($_REQUEST['ab'] + ((int)($_REQUEST['lt']/3)));

$_REQUEST['entry_by']=$_SESSION['user']['id'];
$_REQUEST['entry_at']=date('Y-m-d H:i:s'); echo 'Saved!'; $crud->insert();
}
?>