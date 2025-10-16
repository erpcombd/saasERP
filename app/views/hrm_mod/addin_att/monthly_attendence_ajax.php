<?
session_start();
require_once "../../config/inc.all.php";


$unique = 'id';
$PBI_ID = $_REQUEST['PBI_ID'];
$mon = $_REQUEST['mon'];
$year = $_REQUEST['year'];
function auto_calculation($PBI_ID,$mon,$year,$search_PBI_ID=''){
$crud      =new crud('hrm_attendence_final');
$_POST[$unique] = $$unique = find_a_field('hrm_attendence_final','id','PBI_ID="'.$PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');

if($$unique>0)
$flag=1;



$start_date = $year.'-'.sprintf("%02d", ($mon-1)).'-26';
$end_date = $year.'-'.sprintf("%02d", ($mon)).'-25';

$startTime = $days1=mktime(1,1,1,(date('m',strtotime($start_date))),26,date('y',strtotime($start_date)));
$endTime = $days2=mktime(1,1,1,date('m',strtotime($end_date)),25,date('y',strtotime($end_date)));


$_REQUEST['td'] = $days_mon=(($endTime - $startTime)/(3600*24))+1;



for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
$day   = date('l',$i);
${'day'.date('N',$i)}++;}

$sqls = 'select id,access_date,access_time,access_stamp,start_time,end_time,off_day from hrm_inout where employee_id="'.$PBI_ID.'" and  access_date between "'.$start_date.'" and "'.$end_date.'" limit 1';
$querys = db_query($sqls);
$datas = mysqli_fetch_object($querys);
$off_dateno = $datas->off_day;
$off_days=${'day'.$datas->off_day};

if($flag==0){



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
if(date('N',$info['access_stamp'][$date])==$datas->off_day)
	{$info['status'][$date] ='Off Day';$info['bgcolor'][$date] = '#FFF';}
	elseif($data->start_time == '')	{$info['status'][$date]='Regular'; $info['bgcolor'][$date] = '#EAFFEF'; ++$regular; }
else{
$info['late'][$date] = (int)(($data->access_stamp - strtotime($data->access_date.' '.$data->start_time))/60);

		if($info['late'][$date]>0)  {++$late;$info['status'][$date]='Late';$info['bgcolor'][$date] = '#FFFFCC';} 
		else 						{++$regular;$info['status'][$date]='Regular';$info['bgcolor'][$date] = '#EAFFEF';}

}
$info['off_day'][$date]=$data->off_day;
}
$_REQUEST['lt'] = $late;

$_REQUEST['ab'] = $_REQUEST['td'] - ($late + $regular + $off_days) - $_REQUEST['lv'] ;
}

$_REQUEST['pre'] = $_REQUEST['td'] - ($_REQUEST['ab'] + $_REQUEST['hd'] + $off_days) - $_REQUEST['lv'] ;
$_REQUEST['pay'] = $_REQUEST['td'] - ($_REQUEST['ab'] + ((int)($_REQUEST['lt']/3)));

if($flag>0)
{
$_REQUEST['edit_by']=$_SESSION['user']['id'];
$_REQUEST['edit_at']=date('Y-m-d H:i:s'); echo 'Updated!!'; $crud->update($unique);
}
else
{
$_REQUEST['entry_by']=$_SESSION['user']['id'];
$_REQUEST['entry_at']=date('Y-m-d H:i:s'); echo 'Saved!'; $crud->insert();
}
}
auto_calculation($PBI_ID,$mon,$year);
?>