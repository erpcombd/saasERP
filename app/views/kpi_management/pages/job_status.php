<?
//mysql_connect('localhost','root','');
mysql_connect('localhost','usoftbd_tmsscode','tmsscode');
mysql_select_db('usoftbd_tmsscode');
require "../classes/report.class.php";
$sql = 'select a.PBI_ID as Employe_ID,a.PBI_NAME as Name,a.PBI_SEX as Gender,a.PBI_DESIGNATION as designation , a.PBI_DESG_GRADE as grade,a.PBI_DOB as Birth_date,a.PBI_MOBILE as Mobile,a.PBI_JOB_STATUS as Job_status,a.PBI_DOMAIN as Domain,a.PBI_ZONE as Zone,a.PBI_DEPARTMENT as Department,a.PBI_DOJ as Initial_Joinning_date,a.PBI_DOJ_PP as Joining_date_PP from personnel_basic_info a where a.PBI_JOB_STATUS="" order by a.PBI_ID';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../css/report.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>No Job Status Employees</title>

<style type="text/css">
body { font-family:Tahoma, Geneva, sans-serif;
font-size:12px; }
table{ border:solid; border:#99C; padding:0px;}
td{ padding:0;}
</style>
</head>

<body>
<?
echo report_create($sql,1,$str);?>
</body>
</html>
