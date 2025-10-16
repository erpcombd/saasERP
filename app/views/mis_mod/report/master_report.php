<?
session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require "../../classes/report.class.php";
date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if($_POST['task_priority']!='')
	$con .= ' and b.id = "'.$_POST['task_priority'].'"';
	
	if($_POST['assign_to']!='')
	$con .= ' and c.id = "'.$_POST['assign_to'].'"';
	
switch ($_POST['report']) {
    
	
	case 1:
	$report="Basic Task Report";
    $sql="select a.id,a.task_details,c.person_name as assign_to,a.task_details,b.priority from mis_task a, mis_priority b,mis_assign c where b.id=a.task_priority and c.id=a.assign_to ".$con;
	
break;


		

		
	


		
	
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>
<style type="text/css">
<!--
.style1 {
	font-size: 24px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">
<?
		//echo $sql;
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h2 style="font-size:24px;">'.$_SESSION['company_name'].'</h2>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';
		$str 	.= '</div>';
		if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		if(isset($project_name)) 
		$str 	.= '<p>Project Name: '.$project_name.'</p>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		if(isset($client_name)) 
		$str 	.= '<p>Client Name: '.$client_name.'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
	
if($_POST['report']==7) 
{
$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department from 
personnel_basic_info a where 1 ".$con;
$query = db_query($sql);
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>
<tr>
<th>S/L</th>
<th>CODE</th>
<th>Name</th>
<th>Desg</th>
<th>Dept</th>
<th>Salary Type</th>
<th>Basic</th>
<th>C.Salary</th>
<th>SL</th>
<th>HR</th>
<th>TA/DA</th>
<th>FA</th>
<th>MA</th>
<th>Sal By </th>
<th>A/C#</th>
<th>Branch</th>
<th>SM</th>
</tr>
</thead><tbody>
<?
while($datas=mysqli_fetch_row($query)){$s++;
$sqld = 'select * from salary_info where PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr><td><?=$s?></td><td><?=$datas[0]?></td><td><?=$datas[1]?></td>
  <td><?=$datas[2]?></td>
  <td><?=$datas[3]?></td><td><?=$data->salary_type?></td><td><?=$data->basic_salary?></td><td><?=$data->consolidated_salary?></td>
  <td style="text-align:right"><?=$data->special_allowance ?></td>
  <td style="text-align:right"><?=$data->house_rent?></td><td><?=$data->ta?></td>
  <td><?=$data->food_allowance?></td>
  <td><?=$data->medical_allowance?>&nbsp;</td>
  <td><?=$data->cash_bank?>&nbsp;</td>
  <td><?=$data->cash?></td>
  <td><?=$data->branch_info?></td><td><?=$data->security_amount?></td></tr>
<?
}
?></tbody></table>
<?
}


if($_POST['report']==801) 
{
$str="Warehouse Details List";
$sqld="
SELECT * 
FROM warehouse
Where use_type = 'SD'
";

$query = db_query($sqld);
?>
<div align="center" class="style1"><?=$str?></div>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr>
<td style="border:0px;"></td>
</tr>
<tr>
<th>SL</th>
<th>ID</th>
<th>Name</th>
<th>Type</th>
<th>Company</th>
<th>Salary Type</th>
<th>Basic</th>
<th>C.Salary</th>
<th>SL</th>
<th>HR</th>
<th>TA/DA</th>
<th>FA</th>
<th>MA</th>
<th>Sal By </th>
<th>A/C#</th>
<th>Branch</th>
<th>SM</th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
$s++;

?>
<tr>
<td><?=$s?></td>
<td><?=$data->warehouse_id?></td>
<td><?=$data->warehouse_name?></td>
<td><?=$data->use_type?></td>
<td><?=$data->group_for?></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<? } ?>
</tbody></table>
<?
}



elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?></div>
</body>
</html>