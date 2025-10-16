<?







session_start();







require "../../config/inc.all.php";







require "../../classes/report.class.php";







require_once ('../../../acc_mod/common/class.numbertoword.php');







date_default_timezone_set('Asia/Dhaka');











if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)











{







	if($_POST['name']!='')















	$con.=' and a.PBI_NAME like "%'.$_POST['name'].'%"';



















	if($_POST['PBI_ORG']!='')











	$con.=' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';















	if($_POST['department']!='')















	$con.=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';











	if($_POST['project']!='')







	$con.=' and a.PBI_PROJECT = "'.$_POST['project'].'"';















	if($_POST['designation']!='')











	$con.=' and a.PBI_DESIGNATION = "'.$_POST['designation'].'"';







	if($_POST['zone']!='')















	$con.=' and a.PBI_ZONE = "'.$_POST['zone'].'"';







	if($_POST['JOB_LOCATION']!='')











	$con.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';











	if($_POST['PBI_GROUP']!='')







	$con.=' and a.PBI_GROUP = "'.$_POST['PBI_GROUP'].'"';















	if($_POST['area']!='')







	$con.=' and a.PBI_AREA = "'.$_POST['area'].'"';







	if($_POST['branch']!='')







	$con.=' and a.PBI_BRANCH = "'.$_POST['branch'].'"';























	if($_POST['job_status']!='')







	$con.=' and a.PBI_JOB_STATUS = "'.$_POST['job_status'].'"';







	if($_POST['gender']!='')







	$con.=' and a.PBI_SEX = "'.$_POST['gender'].'"';

















	if($_POST['department']!='')







	$depts = find_a_field('department','DEPT_DESC','DEPT_ID='.$_POST['department'] );















switch ($_POST['report']) {





	case 232:



	$report="Performance Appraisal Summary  ".$_POST['year']."";



	 break;




	 	case 722:
	 	$report="Performance Appraisal   ".$_POST['year']."";
	  break;

		case 723:
	 	$report="Performance Appraisal   ".$_POST['year']."";
	  break;
	  
	  case 724:
	 	$report="Performance Appraisal   ".$_POST['year']."";
	  break;




	 case 322:



	$report="Key Performance Indicator (KPI) Final Report";



	 break;







	 case 878:



	$report="Key Performance Indicator (KPI) Weekly Report";



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







function Pager(tableName, itemsPerPage) {







    this.tableName = tableName;







    this.itemsPerPage = itemsPerPage;







    this.currentPage = 1;







    this.pages = 0;







    this.inited = false;















    this.showRecords = function(from, to) {







        var rows = document.getElementById(tableName).rows;







        // i starts from 1 to skip table header row







        for (var i = 1; i < rows.length; i++) {







            if(i < from || i > to) rows[i].style.display = 'none';







            else rows[i].style.display = '';







        }







    }















    this.showPage = function(pageNumber) {







    	if (! this.inited) {







    		alert("not inited");







    		return;







    	}















        var oldPageAnchor = document.getElementById('pg'+this.currentPage);







        oldPageAnchor.className = 'pg-normal';















        this.currentPage = pageNumber;







        var newPageAnchor = document.getElementById('pg'+this.currentPage);







        newPageAnchor.className = 'pg-selected';















        var from = (pageNumber - 1) * itemsPerPage + 1;







        var to = from + itemsPerPage - 1;







        this.showRecords(from, to);







    }















    this.prev = function() {







        if (this.currentPage > 1)







            this.showPage(this.currentPage - 1);







    }















    this.next = function() {







        if (this.currentPage < this.pages) {







            this.showPage(this.currentPage + 1);







        }







    }















    this.init = function() {







        var rows = document.getElementById(tableName).rows;







        var records = (rows.length - 1);







        this.pages = Math.ceil(records / itemsPerPage);







        this.inited = true;







    }















    this.showPageNav = function(pagerName, positionId) {







    	if (! this.inited) {







    		alert("not inited");







    		return;







    	}







    	var element = document.getElementById(positionId);















    	var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal">Prev</span>';







        for (var page = 1; page <= this.pages; page++)







            pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span>';







        pagerHtml += '<span onclick="'+pagerName+'.next();" class="pg-normal">Next</span>';















        element.innerHTML = pagerHtml;







    }







}







var XMLHttpRequestObject = false;















if (window.XMLHttpRequest)







	XMLHttpRequestObject = new XMLHttpRequest();







else if (window.ActiveXObject)







	{







     	XMLHttpRequestObject = new







        ActiveXObject("Microsoft.XMLHTTP");







    }







function getData(dataSource, divID, data)







	{







	  if(XMLHttpRequestObject)







		  {







				var obj = document.getElementById(divID);







				XMLHttpRequestObject.open("POST", dataSource);







				XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');















				XMLHttpRequestObject.onreadystatechange = function()







					{







						if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)







							obj.innerHTML =   XMLHttpRequestObject.responseText;







					}







				XMLHttpRequestObject.send("ledger=" + data);







		  }







	}







function getData2(dataSource, divID, data1, data2)







	{







	  if(XMLHttpRequestObject)







		  {







				var obj = document.getElementById(divID);







				XMLHttpRequestObject.open("POST", dataSource);







				XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');















				XMLHttpRequestObject.onreadystatechange = function()







					{







						if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)







							obj.innerHTML =   XMLHttpRequestObject.responseText;







					}







				XMLHttpRequestObject.send("data=" + data1+"##" + data2);















		  }







	}







	function getflatData3()







{







	var b=document.getElementById('category_to').value;







	var a=document.getElementById('proj_code_to').value;







			$.ajax({







		  url: '../../common/flat_option_new3.php',







		  data: "a="+a+"&b="+b,







		  success: function(data) {







				$('#fid3').html(data);







			 }







		});







}







	function getflatData2()







{







	var b=document.getElementById('category_from').value;







	var a=document.getElementById('proj_code_from').value;







			$.ajax({







		  url: '../../common/flat_option_new2.php',







		  data: "a="+a+"&b="+b,







		  success: function(data) {







				$('#fid2').html(data);







			 }







		});







}







</script>







</head>







<body>







<form action="advance_report.php" method="post">







<div align="center" id="pr">







<input type="button" value="Print" onclick="hide();window.print();"/>



















</div>















<div class="main">



















<?























		//echo $sql;















		$str 	.= '<div class="header">';







		if(isset($_SESSION['company_name']))



















		$str 	.= '<h2 style="font-size:24px; font-family:bankgothic; transform: uppercase;">AKSID CORPORATION LIMITED</h2>';







		if(isset($report))











		$str 	.= '<h2>'.$report.'</h2>';







		if($_POST['JOB_LOCATION']!='')











		$str 	.= '<h2>'.find_a_field('project','PROJECT_DESC','PROJECT_ID='.$_POST['JOB_LOCATION']).'</h2>';







		if(isset($to_date))







		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';







		$str 	.= '</div>';







		if(isset($_SESSION['company_logo']))







		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';







		$str 	.= '<div class="center">';















		if(($_POST['area_code']>0))







		$str 	.= '<p>Area Name: '.find_a_field('area','AREA_NAME','AREA_CODE="'.$_POST['area_code'].'"').'</p>';







		if(($_POST['zone_code']>0))







		$str 	.= '<p>Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$_POST['zone_code'].'"').'</p>';







		if(($_POST['region_code']>0))







		$str 	.= '<p>Region Name: '.find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$_POST['region_code'].'"').'</p>';







		if(isset($project_name))







		$str 	.= '<p>Project Name: '.$project_name.'</p>';







		if(isset($allotment_no))







		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';







		$str 	.= '</div><div class="right">';







		if(isset($client_name))







		$str 	.= '<p>Client Name: '.$client_name.'</p>';







		$str 	.= '</div><div class="date" style="">Reporting Time: '.date("h:i A d-m-Y").'</div>';







if($_POST['report']==226655)







{



?>





<table width="100%"  cellspacing="0" cellpadding="2" border="0">







<thead><tr><td style="border:0px;" colspan="28"><?=$str?></td></tr><tr><td style="border:0px;" colspan="28"><div align="center" style="font-size:20px;">Leave Report of <? $test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');



 echo date_format($test, 'M-Y');



 ?></div></td></tr>







<tr>







  <th rowspan="2">S/L</th>







  <th rowspan="2">ID</th>







<th rowspan="2">Name</th>



<th rowspan="2"><center>Designation</center></th>



<th rowspan="2">Duties Carried By</th>







<th rowspan="2"><center>Submission Date</center></th>



<th colspan="2"><center>Date Intervel</center></th>







<th rowspan="2"><center>Total Days</center></th>







<th rowspan="2"><center>Leave Type<center></th>







<th rowspan="2"><center>Reporting Authority<center></th>







<th rowspan="2"><center>HR Approval<center></th>







</tr>







<tr>



   <th><div align="center">Start Date</div></th>



   <th><div align="center">End Date</div></th>







</tr>











</thead>







<tbody>







<?







if($_POST['department'] !='')



$leave_con = ' and a.PBI_DEPARTMENT="'.$_POST['department'].'"';







if($_POST['JOB_LOCATION'] !='')



$leave_con .= ' and a.JOB_LOCATION="'.$_POST['JOB_LOCATION'].'"';







if($_POST['year'] !='')



$leave_con .= ' and o.year="'.$_POST['year'].'"';







if($_POST['leave_status'] !='')



$leave_con .= ' and o.leave_status="'.$_POST['leave_status'].'"';







if($_POST['PBI_ID'] !='')



$leave_con .= ' and o.PBI_ID="'.$_POST['PBI_ID'].'"';



















if($_POST['mon'] !='')



$od_con .= ' and o.s_date between "'.$_POST['year'].'-'.$_POST['mon'].'-01" and "'.$_POST['year'].'-'.$_POST['mon'].'-30"';



           $m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';



		   $m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';







   $sqldd = "select o.PBI_ID,a.PBI_NAME as name,o.s_date,o.e_date,(select PBI_NAME from personnel_basic_info where PBI_ID=o.leave_responsibility_name) as duties_carried_by,c.DESG_DESC,DATE_FORMAT(o.leave_apply_date,'%d-%b-%Y') as submission_date,DATE_FORMAT(o.s_date,'%d-%b-%Y') as start_date,DATE_FORMAT(o.e_date,'%d-%b-%Y') as end_date,o.total_days,(select leave_type_name from hrm_leave_type where id=o.type) as leave_type, o.incharge_status ,o.leave_status  from personnel_basic_info a,designation c, department d,hrm_leave_info o where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_ID=o.PBI_ID and  o.type!= 'Short Leave (SHL)' and o.s_date>='".$m_s_date."' and o.e_date<='".$m_e_date."'  ".$leave_con." order by o.s_date desc";







$querydd=mysql_query($sqldd);







while($leaveData = mysql_fetch_object($querydd)){







$entry_by=$data->entry_by;



$year = date('Y');







/*$last_date = find_a_field('hrm_leave_info','e_date','PBI_ID="'.$leaveData->PBI_ID.'" and e_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'"');







if($leaveData->e_date>$m_e_date){







 $start = $leaveData->s_date;



 $end = $m_e_date;











$begin = new DateTime($start);



$end = new DateTime($end);







$interval = DateInterval::createFromDateString('1 day');



$period = new DatePeriod($begin, $interval, $end);



$day_count = 0;



foreach ($period as $dt) {



     $dt->format("l Y-m-d H:i:s\n");



    $today = $dt->format("Y-m-d");



    if($dt->format("l")!='Friday')



    {



$found = 0;



$found = find_a_field('salary_holy_day','1',' holy_day="'.$today.'" ');



if($found==0)



$day_count++;



    }







}



$total_days = $day_count;



}elseif($last_date!=''){







$start = $m_s_date;



 $end = $last_date;











$begin = new DateTime($start);



$end = new DateTime($end);







$interval = DateInterval::createFromDateString('1 day');



$period = new DatePeriod($begin, $interval, $end);



$day_count = 0;



foreach ($period as $dt) {



     $dt->format("l Y-m-d H:i:s\n");



    $today = $dt->format("Y-m-d");



    if($dt->format("l")!='Friday')



    {



$found = 0;



$found = find_a_field('salary_holy_day','1',' holy_day="'.$today.'" ');



if($found==0)



$day_count++;



    }







}



$total_days = $day_count;







}







else



{



$total_days = $leaveData->total_days;



}*/







?>







<tr><td ><?=++$s?></td>



	<td align="center"><?=$leaveData->PBI_ID?></td>







<td nowrap="nowrap"><?=$leaveData->name?></td>



<td><?=$leaveData->DESG_DESC?></td>







 <td><?=$leaveData->duties_carried_by?></td>







 <td align="center"><?=$leaveData->submission_date?></td>







  <td align="center"><?=$leaveData->start_date?></td>











  <td align="center"><?=$leaveData->end_date?></td>







  <td align="center"><?=$leaveData->total_days?></td>







  <td align="center"><?=$leaveData->leave_type?></td>











  <td align="center"><?=$leaveData->incharge_status?></td>











   <td align="center"><?=$leaveData->leave_status?></td>























































</tr>



















<?















}







?>























</tbody></table>











<br><br><br>















































<?



}



if($_POST['report']==226644)







{



?>



















<table width="100%"  cellspacing="0" cellpadding="2" border="0">







<thead><tr><td style="border:0px;" colspan="28"><?=$str?></td></tr><tr><td style="border:0px;" colspan="28"><div align="center" style="font-size:20px;">Short Leave Report of <? $test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');



 echo date_format($test, 'M-Y');



 ?></div></td></tr>







<tr>







  <th rowspan="2">S/L</th>







  <th rowspan="2">ID</th>







<th rowspan="2">Name</th>



<th rowspan="2"><center>Designation</center></th>



<th rowspan="2">Duties Carried By</th>







<th rowspan="2"><center>Submission Date</center></th>



<th rowspan="2"><center>Leave Date</center></th>



<th colspan="2"><center>Time Intervel</center></th>







<th rowspan="2"><center>Total Hours</center></th>















<th rowspan="2"><center>Reporting Authority<center></th>







<th rowspan="2"><center>HR Approval<center></th>







</tr>







<tr>



   <th><div align="center">Start Time</div></th>



   <th><div align="center">End Time</div></th>







</tr>



















</thead>







<tbody>







<?







if($_POST['department'] !='')



$leave_con = ' and a.PBI_DEPARTMENT="'.$_POST['department'].'"';







if($_POST['JOB_LOCATION'] !='')



$leave_con .= ' and a.JOB_LOCATION="'.$_POST['JOB_LOCATION'].'"';







if($_POST['PBI_ID'] !='')



$leave_con .= ' and o.PBI_ID="'.$_POST['PBI_ID'].'"';







if($_POST['year'] !='')



$leave_con .= ' and o.year="'.$_POST['year'].'"';







if($_POST['mon'] !='')



$leave_con .= ' and o.half_leave_date between "'.$_POST['year'].'-'.$_POST['mon'].'-01" and "'.$_POST['year'].'-'.$_POST['mon'].'-30"';







  $sqldd = "select o.PBI_ID,a.PBI_NAME as name,(select PBI_NAME from personnel_basic_info where PBI_ID=o.leave_responsibility_name) as duties_carried_by,c.DESG_DESC,DATE_FORMAT(o.leave_apply_date,'%d-%b-%Y') as submission_date,DATE_FORMAT(o.half_leave_date,'%d-%b-%Y') as leave_date,TIME_FORMAT(o.s_time,'%h:%i') as start_time, TIME_FORMAT(o.e_time, '%h:%i') as end_time,o.total_hrs, o.incharge_status as reporting_authority ,o.leave_status from personnel_basic_info a,designation c, department d,hrm_leave_info o where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_ID=o.PBI_ID  and o.type='Short Leave (SHL)'  ".$leave_con."  order by o.half_leave_date desc";







$querydd=mysql_query($sqldd);







while($leaveData = mysql_fetch_object($querydd)){







$entry_by=$data->entry_by;



$year = date('Y');







?>







<tr><td align="center"><?=++$s?></td>



	<td align="center"><?=$leaveData->PBI_ID?></td>







<td nowrap="nowrap"><?=$leaveData->name?></td>



<td><?=$leaveData->DESG_DESC?></td>







 <td><?=$leaveData->duties_carried_by?></td>







 <td align="center"><?=$leaveData->submission_date?></td>



 <td align="center"><?=$leaveData->leave_date?></td>







  <td align="center"><?=$leaveData->start_time?></td>











  <td align="center"><?=$leaveData->end_time?></td>







  <td align="center"><?=$leaveData->total_hrs?></td>



















  <td align="center"><?=$leaveData->reporting_authority?></td>











   <td align="center"><?=$leaveData->leave_status?></td>















</tr>



















<?















}







?>























</tbody></table>











<br><br><br>























































































































<?







}







if($_POST['report']==201912)







{







?>



















<table width="100%" cellspacing="0" cellpadding="2" border="0">







<thead><tr><td style="border:0px;" colspan="28"><?=$str?></td></tr><tr><td style="border:0px;" colspan="28"><div align="center" style="font-size:20px;">OD Report of <? $test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');



 echo date_format($test, 'M-Y');



 ?>



</div></td></tr>







<tr>







  <th rowspan="2"><div align="center">S/L</div></th>







  <th rowspan="2"><div align="center">ID</div></th>







<th rowspan="2"><div align="center">Name</div></th>







<th rowspan="2"><div align="center">Designation</div></th>







<th rowspan="2"><div align="center">Department</div></th>











<th rowspan="2"><div align="center">Job Location/Project</div></th>







<th rowspan="2"><div align="center">Submission Date</div></th>











<th colspan="2"><div align="center">Date Interval</div></th>







<th rowspan="2"><div align="center">Total Days</div></th>







<th colspan="2"><div align="center">Time Interval</div></th>







<th rowspan="2"><div align="center">Total Hours</div></th>



<th rowspan="2"><div align="center">OD Type</div></th>







<th rowspan="2"><div align="center">Reason</div></th>







</tr>



<tr>



   <th><div align="center">Start Date</div></th>



   <th><div align="center">End Date</div></th>











   <th><div align="center">Start Time</div></th>



   <th><div align="center">End Time</div></th>











</tr>







</thead>







<tbody>







<?







if($_POST['department'] !='')



$od_con = ' and p.PBI_DEPARTMENT="'.$_POST['department'].'"';







if($_POST['JOB_LOCATION'] !='')



$od_con .= ' and p.JOB_LOCATION="'.$_POST['JOB_LOCATION'].'"';







if($_POST['PBI_ID'] !='')



$od_con .= ' and l.PBI_ID="'.$_POST['PBI_ID'].'"';







/*if($_POST['year'] !='')



$od_con .= ' and l.year="'.$_POST['year'].'"';*/







if($_POST['mon'] !='')







  $m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';



   $m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';



$od_con .= ' and l.s_date>="'.$m_s_date.'" and l.e_date<="'.$m_e_date.'"';







//$tr_con .= ' and t.TRANSFER_ORDER_DATE between "'.$_POST['year'].'-'.$_POST['mon'].'-1" and "'.$_POST['year'].'-'.$_POST['mon'].'-30"';











  $sqldd = 'select l.PBI_ID,p.PBI_NAME,p.PBI_DEPARTMENT,(select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project,p.PBI_SEX,p.PBI_DOJ,p.PBI_DESIGNATION,dept.DEPT_DESC,desg.DESG_DESC,DATE_FORMAT(l.od_date,"%d-%b-%Y") as od_date,l.total_days,l.total_hrs ,l.type,l.reason,l.s_time,l.e_time,



        DATE_FORMAT(l.s_date,"%d-%b-%Y") as s_date,DATE_FORMAT(l.e_date,"%d-%b-%Y") as e_date



   from hrm_od_info l,personnel_basic_info p,essential_info e,department dept,designation desg where l.PBI_ID=p.PBI_ID and l.PBI_ID=e.PBI_ID and p.PBI_DEPARTMENT=dept.DEPT_ID and l.od_status="Granted" and  p.PBI_DESIGNATION=desg.DESG_ID '.$od_con.'order by s_date desc';







$querydd=mysql_query($sqldd);







while($leaveData = mysql_fetch_object($querydd)){







$entry_by=$data->entry_by;



$year = date('Y');







?>







<tr><td><?=++$s?></td>



	<td><?=$leaveData->PBI_ID?></td>







<td nowrap="nowrap"><?=$leaveData->PBI_NAME?></td>







 <td><?=$leaveData->DESG_DESC?></td>







  <td><div align="center"><?=$leaveData->DEPT_DESC?></div></td>











  <td><div align="center"><?=$leaveData->project?></div></td>











  <td><div align="center"><?=$leaveData->od_date?></div></td>































   <td><?=$leaveData->s_date?></td>



   <td><?=$leaveData->e_date?></td>







   <td><div align="center"><?=$leaveData->total_days?></div></td>







   <td><div align="center"><?=$leaveData->s_time?></div></td>



   <td><div align="center"><?=$leaveData->e_time?></div></td>







    <td><div align="center"><?=$leaveData->total_hrs?></div></td>











   <td><div align="center"><?=find_a_field('od_type','type_name','id='.$leaveData->type)?></div></td>



   <td><?=$leaveData->reason?></td>







</tr>



















<?















}







?>























</tbody></table>











<br><br><br>























<?







}























if($_POST['report']==878)



{



if($_POST['PBI_ID']!=''){

  $pbi_id = $_POST['PBI_ID'];

}



if($_POST['kpi_weeks']!=''){

  $week = $_POST['kpi_weeks'];

}

if($_POST['mon']!=''){

  $mon = $_POST['mon'];

}



if($_POST['year']!=''){

  $year = $_POST['year'];

}

$_GET['id'] =  $pbi_id;

$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_GET['id'].'"');

$reporting = find_a_field('essential_info','ESSENTIAL_REPORTING','PBI_ID="'.$employee->PBI_ID.'"');

$reporting_data = find_all_field('personnel_basic_info','','PBI_ID="'.$reporting.'"');



?><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">



<thead><tr><td style="border:0px; font-family:bank gothic; font-size:20px; font-weight:bold;" colspan="11" align="center"></td></tr>

<tr><td style="border:0px;font-family:bank gothic; font-size:25px; font-weight:bold;" colspan="11" align="center">AKSID CORPORATION LIMITED</td></tr>

<tr><td style="border:0px;font-family:cambria; font-size:18px;" colspan="11" align="center">Key Performance Indicator (KPI) Weekly Report</td></tr>

</thead></table><br />

<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

<thead>

<tr><td style="border:0px;font-family:cambria; font-size:12px;" colspan="11" align="right">&nbsp;&nbsp;Reporting Time : <?=date('d-M-Y h:i:s a')?></td></tr>

</thead></table>





		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

		<tr height="60">

		  <td style=" border-bottom:0px; border-right:0px; border-left:0px;">

		    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-family:cambria;">



			<tr>

			   <td style="font-size:16px; padding:2px;"> ID NO : <strong><?=$employee->PBI_ID?></strong></td>

			   <td style="padding:2px; font-size:14px;">Name : <strong><?=$employee->PBI_NAME?></strong>  </td>

			    <td style="padding:2px; font-size:14px;">Designation :  <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></strong></td>

				<td rowspan="3">

				<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">

				   <tr>

				      <td colspan="2" align="center"><strong><?=$week?><?=$mon?></strong></td>



				   </tr>

				   <!-- <tr>

				      <td>Daily Task</td>

					  <td><? //=number_format($daily_task = find_a_field('kpi_task_details','sum(point)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"'),2);?></td>

				   </tr> -->

				   <tr>

				      <td>Weekly Task</td>

					  <td><?=number_format($weekly_task = find_a_field(' kpi_log_sheet_details','sum(point)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"'),2);?></td>

				   </tr>

				   <tr>

				      <td>Errors</td>

					  <td>(<?=number_format($error = find_a_field('kpi_error_overtime_details','sum(score)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"'),2);?>)</td>

				   </tr>

				    <tr>

				      <td>Over Time</td>

					  <td><?=number_format($overtime = find_a_field('kpi_error_overtime_details','sum(overtime)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"'),2);?></td>

				   </tr>

				   <tr>

				      <td>Total Score</td>

					  <td><?=($final_score = $weekly_task+$overtime)-$error;  //=number_format(find_a_field('kpi_final_score','sum(SCORE)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"'),2);?></td>

				   </tr>

				   <tr>

				      <td>Grade</td>

					  <td>

					      <?


							//$total_score=find_a_field('kpi_final_score','sum(SCORE)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"');
							
							$total_score = ($weekly_task+$overtime)-$error; 

								switch($total_score){



								    case $total_score>=90:

									    $grade = 'A';

										 break;



								    case $total_score>=80 && $grade<90:

									  $grade = 'B';

									   break;





									   case $total_score>=70 && $grade<80:

									   $grade = 'C';

									   break;



									   case $total_score>=60 && $grade<70:

									   $grade = 'D';

									   break;



									   case $total_score>=1 && $grade<60:

									   $grade = 'F';

									   break;



									   default:

									     $grade = ' ';



								   }

          echo  $grade ;


?>

					  </td>

				   </tr>

				</table>

				</td>

			</tr>



			<tr>

			   <td style="padding:2px; font-size:14px;">Department :  <strong><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></strong></td>

			   <td style="padding:2px; font-size:14px;"> Project Name :  <strong><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></strong> </td>

			    <td style="padding:2px; font-size:14px;">Joining Date :  <strong><?=date('d-M-Y',strtotime($employee->PBI_DOJ))?></strong></td>



			</tr>





			 <tr>

			   <td style="padding:2px; font-size:14px;">KPI Authorised Person: <strong><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$reporting_data->PBI_ID.'"');?></strong></td>



			   <td style="padding:2px; font-size:14px;">Designation of Authorised Person : <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$reporting_data->PBI_DESIGNATION);?></strong></td>

			   <td style="font-size:14px;">Service Length : <strong><?php



		  $interval = date_diff(date_create(date('Y-m-d')), date_create($employee->PBI_DOJ));

		echo $interval->format("%Y Year, %M Months, %d Days");

		  ?></strong></td>



			</tr>

			</table>

		  </td>



	 </tr>











</table><br />







<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="padding:0px;">

           <!-- <tr>



	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;font-family:cambria;">Daily Task</div></td>

	   </tr> -->



    </table>






		<br />



		<table width="100%"  cellspacing="0" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">

           <tr>



	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Weekly Log Sheet (Week 1)</div></td>

	   </tr>



	   </table>

		<table width="100%" cellspacing="0" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">

		<tr height="30" style="background:#00CCFF">

		  <td width="5%"><div align="center"><strong>SL</strong></div></td>

		  <td width="60%"><div align="center"><strong>Description</strong></div></td>

		  <td width="10%"><div align="center"><strong>Submitted</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documentary evidence</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documents</strong></div></td>





		 </tr>



	  <?

	    $ssql = 'select d.*,t.task_name from kpi_log_sheet_details d,kpi_log_sheet t where
			d.mon="'.$mon.'" and d.log_id=t.task_id and d.PBI_ID="'.$_GET['id'].'" and d.week="Week 1" and d.year="'.$year.'" ';

		$qr = mysql_query($ssql);



		while($task_data=mysql_fetch_object($qr)){

	  ?>

	 <tr>

		  <td width="5%"><div align="center"><strong><?=++$i?></strong></div></td>

		  <td width="60%"><div align="left"><?=$task_data->task_name?></div></td>

		  <td width="10%"><div align="center"><?=$task_data->submitted?></div></td>

		  <td width="10%"><div align="center"><?=$task_data->documentart_evidence?></div></td>

		  <td width="10%"><div align="center"><? if($task_data->att_file!=''){?><a href="../../pic/kpi_log/<?=$task_data->att_file?>" target="_blank">Attachment</a><? } ?></div></td>


 </tr>









	 <? } ?>

	  <tr>


  <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">
		Total Score :<?=number_format($weekly_task = find_a_field(' kpi_log_sheet_details','sum(point)','PBI_ID="'.$pbi_id.'" and week="Week 1" and  mon="'.$mon.'" and year="'.$year.'"'),2);?>
	</div></td>

	   </tr>

	  </table>


		<br />



				<table width="100%"  cellspacing="0" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">

		           <tr>



			      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Week 2</div></td>

			   </tr>



			   </table>

				<table width="100%" cellspacing="0" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">

				<tr height="30" style="background:#00CCFF">

				  <td width="5%"><div align="center"><strong>SL</strong></div></td>

				  <td width="60%"><div align="center"><strong>Description</strong></div></td>

				  <td width="10%"><div align="center"><strong>Submitted</strong></div></td>

				  <td width="10%"><div align="center"><strong>Documentary evidence</strong></div></td>

				  <td width="10%"><div align="center"><strong>Documents</strong></div></td>





				 </tr>



			  <?

			    $ssql = 'select d.*,t.task_name from kpi_log_sheet_details d,kpi_log_sheet t where
					d.mon="'.$mon.'" and d.point>0 and d.log_id=t.task_id and d.PBI_ID="'.$_GET['id'].'" and d.week="Week 2" and d.year="'.$year.'" ';

				$qr = mysql_query($ssql);



				while($task_data=mysql_fetch_object($qr)){

			  ?>

			 <tr>

				  <td width="5%"><div align="center"><strong><?=++$i?></strong></div></td>

				  <td width="60%"><div align="left"><?=$task_data->task_name?></div></td>

				  <td width="10%"><div align="center"><?=$task_data->submitted?></div></td>

				  <td width="10%"><div align="center"><?=$task_data->documentart_evidence?></div></td>

				  <td width="10%"><div align="center"><? if($task_data->att_file!=''){?><a href="../../pic/kpi_log/<?=$task_data->att_file?>" target="_blank">Attachment</a><? } ?></div></td>


		 </tr>









			 <? } ?>

			  <tr>


		  <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">
			Total Score :<?=number_format($weekly_task2 = find_a_field(' kpi_log_sheet_details','sum(point)','PBI_ID="'.$pbi_id.'" and week="Week 2" and  mon="'.$mon.'" and year="'.$year.'"'),2);?>
			</div></td>

			   </tr>

			  </table>


				<br />



				<table width="100%"  cellspacing="0" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">
				 <tr><td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Week 3</div></td></tr>

				</table>


		<table width="100%" cellspacing="0" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">

		<tr height="30" style="background:#00CCFF">

		  <td width="5%"><div align="center"><strong>SL</strong></div></td>

		  <td width="60%"><div align="center"><strong>Description</strong></div></td>

		  <td width="10%"><div align="center"><strong>Submitted</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documentary evidence</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documents</strong></div></td>





		 </tr>



	  <?

	    $ssql = 'select d.*,t.task_name from kpi_log_sheet_details d,kpi_log_sheet t where
			d.mon="'.$mon.'" and d.point>0 and d.log_id=t.task_id and d.PBI_ID="'.$_GET['id'].'" and d.week="Week 3" and d.year="'.$year.'" ';

		$qr = mysql_query($ssql);



		while($task_data=mysql_fetch_object($qr)){

	  ?>

	 <tr>

		  <td width="5%"><div align="center"><strong><?=++$i?></strong></div></td>

		  <td width="60%"><div align="left"><?=$task_data->task_name?></div></td>

		  <td width="10%"><div align="center"><?=$task_data->submitted?></div></td>

		  <td width="10%"><div align="center"><?=$task_data->documentart_evidence?></div></td>

		  <td width="10%"><div align="center"><? if($task_data->att_file!=''){?><a href="../../pic/kpi_log/<?=$task_data->att_file?>" target="_blank">Attachment</a><? } ?></div></td>


 </tr>




	 <? } ?>

	  <tr>



	      <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">
			Total Score :<?=number_format($weekly_task3 = find_a_field(' kpi_log_sheet_details','sum(point)','PBI_ID="'.$pbi_id.'" and week="Week 3" and  mon="'.$mon.'" and year="'.$year.'"'),2);?>
				</div></td>

	   </tr>

	  </table>


<br />



<table width="100%"  cellspacing="0" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">
 <tr><td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Week 4</div></td></tr>

</table>

		<table width="100%" cellspacing="0" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">

		<tr height="30" style="background:#00CCFF">

		  <td width="5%"><div align="center"><strong>SL</strong></div></td>

		  <td width="60%"><div align="center"><strong>Description</strong></div></td>

		  <td width="10%"><div align="center"><strong>Submitted</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documentary evidence</strong></div></td>

		  <td width="10%"><div align="center"><strong>Documents</strong></div></td>





		 </tr>



	  <?

	    $ssql = 'select d.*,t.task_name from kpi_log_sheet_details d,kpi_log_sheet t where
			d.mon="'.$mon.'" and d.point>0 and d.log_id=t.task_id and d.PBI_ID="'.$_GET['id'].'" and d.week="Week 4" and d.year="'.$year.'" ';

		$qr = mysql_query($ssql);



		while($task_data=mysql_fetch_object($qr)){

	  ?>

	 <tr>

		  <td width="5%"><div align="center"><strong><?=++$i?></strong></div></td>

		  <td width="60%"><div align="left"><?=$task_data->task_name?></div></td>

		  <td width="10%"><div align="center"><?=$task_data->submitted?></div></td>

		  <td width="10%"><div align="center"><?=$task_data->documentart_evidence?></div></td>

		  <td width="10%"><div align="center"><? if($task_data->att_file!=''){?><a href="../../pic/kpi_log/<?=$task_data->att_file?>" target="_blank">Attachment</a><? } ?></div></td>


 </tr>









	 <? } ?>

	  <tr>


  <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">
			Total Score :<?=number_format($weekly_task4 = find_a_field(' kpi_log_sheet_details','sum(point)','PBI_ID="'.$pbi_id.'" and week="Week 4" and  mon="'.$mon.'" and year="'.$year.'"'),2);?>

	</div></td>

	   </tr>

	  </table>


		<br />


	 <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="padding:0px;font-family:cambria;">

           <tr>



	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Weekly Error & Overtime Report</div></td>

	   </tr>







    </table>



		<?

		  $ss = 'select sum(general_error) as general_error,general_justification,sum(serious_error) as serious_error,serious_justification,sum(overtime_hours) as overtime_hours,
			overtime_justification,sum(score) as score

			 from kpi_error_overtime_details where PBI_ID="'.$_GET['id'].'" and mon="'.$mon.'" and year="'.$year.'"';

		  $qq = mysql_query($ss);

		  $data = mysql_fetch_object($qq);

		?>



		<table width="100%" cellspacing="0" cellpadding="0" align="center" style="padding:0px; border: 0px solid #666666;font-family:cambria;">

		<tr height="30" style="background:#00CCFF">

		  <td width="10%"><div align="center"><strong>SL</strong></div></td>

		  <td width="30%"><div align="center"><strong>No. of errors for the followings</strong></div></td>

		  <td width="15%"><div align="center"><strong>Number of errors</strong></div></td>

		  <td width="40%"><div align="center"><strong>Justification Note</strong></div></td>



		 </tr>





	    <tr height="30">

		  <td width="10%"><div align="center"><strong>1</strong></div></td>

		  <td width="30%"><div align="center">General Mistakes</div></td>

		  <td width="15%"><div align="center"><?=$data->general_error?></div></td>

		  <td width="40%"><div align="center"><?=$data->general_justification?></div></td>

		 </tr>



		 <tr height="30">

		  <td width="10%"><div align="center"><strong>2</strong></div></td>

		  <td width="30%"><div align="center">Serious errors/ mistakes</div></td>

		  <td width="15%"><div align="center"><strong><?=$data->serious_error?></strong></div></td>

		  <td width="40%"><div align="center"><?=$data->serious_justification?></div></td>

		 </tr>



		 <tr height="30">

		  <td width="10%"><div align="center"><strong>3</strong></div></td>

		  <td width="30%"><div align="center">Overtime Hours</div></td>

		  <td width="15%"><div align="center"><?=$data->overtime_hours?></div></td>

		  <td width="40%"><div align="center"><?=$data->overtime_justification?></div></td>

		 </tr>

	    <tr>



	      <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">
					Total Error Deductions : <?=number_format($data->score,2)?></div></td>

	   </tr>

	    <tr>



	      <td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">
					Total Over Time Marks : <?=number_format($data->overtime_hours,2)?></div></td>

	   </tr>

<tr>
<td colspan="8" style="background:#fff; color:#000;"><div align="center" style="font-size:16px; font-weight:bold;">Total Monthly Score :
	<? $tot_mon_score = find_a_field('kpi_final_score','sum(SCORE)','PBI_ID="'.$pbi_id.'" and mon="'.$mon.'" and year="'.$year.'"');

	//echo number_format($tot_mon_score+$data->overtime_hours-$data->score,2);
   $total_weekly_task_at_a_glance = $total_weekly_task + $weekly_task+$weekly_task2+$weekly_task3+$weekly_task4+$data->overtime_hours-$data->score;

	 echo number_format($total_weekly_task_at_a_glance,2);

	?>

</div></td>
</tr>




	    </table><br />



		<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="padding:5px;font-family:cambria;">

		 <tr style="background:#337AB7; color:#FFFFFF;">



	      <td colspan="9" align="center"><div align="center" style="font-size:16px; font-weight:bold;">Notes :</div></td>

	   </tr>

           <tr>



	      <td colspan="9"><strong><?=$data->final_comment?></strong></td>

	   </tr>







	    </table><br />





</div>







<br><br><br>







































<?







}

if($_POST['report']==322)



{







?>



<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">



<thead><tr><td style="border:0px; font-family:bank gothic; font-size:20px; font-weight:bold;" colspan="11" align="center"></td></tr>

<tr><td style="border:0px;font-family:bank gothic; font-size:25px; font-weight:bold;" colspan="11" align="center">AKSID CORPORATION LIMITED</td></tr>

<tr><td style="border:0px;font-family:cambria; font-size:18px;" colspan="11" align="center">Key Performance Indicator (KPI) Final Report</td></tr>

</thead></table><br />

<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

<thead>

<tr><td style="border:0px;font-family:cambria; font-size:12px;" colspan="11" align="right">&nbsp;&nbsp;Reporting Time : <?=date('d-M-Y h:i:s a')?></td></tr>

</thead></table>

<table width="100%" cellspacing="0" cellpadding="2" border="0">





<tr>











  <th rowspan="2"><div align="center">S/L</div></th>







<th rowspan="2"><div align="center">ID</div></th>







<th rowspan="2"><div align="center">Name</div></th>











<th rowspan="2"><div align="center">Designation</div></th>





<th rowspan="2"  align="center"><div align="center">Joining Date</div></th>





<th colspan="12"><div align="center">Grade (Weekly)</div></th>







<th rowspan="2"><div align="center">Final Grade</div></th>











</tr>

<tr>

   <th>January</th>

   <th>February</th>

   <th>March</th>

   <th>April</th>

   <th>May</th>

   <th>June</th>

   <th>July</th>

   <th>August</th>

   <th>September</th>

   <th>October</th>

   <th>November</th>

   <th>December</th>





</tr>





</thead>











<tbody>







<?















if($_POST['department']!='')

$cons.=' and p.PBI_DEPARTMENT ="'.$_POST['department'].'"';



if($_POST['JOB_LOCATION']!='')

$cons.=' and p.JOB_LOCATION ="'.$_POST['JOB_LOCATION'].'"';



if($_POST['job_status']!='')

$cons.=' and p.PBI_JOB_STATUS ="'.$_POST['job_status'].'"';



if($_POST['PBI_ID']!='')

$cons.=' and p.PBI_ID ="'.$_POST['PBI_ID'].'"';



if($_POST['gender']!='')

$cons.=' and p.PBI_SEX ="'.$_POST['gender'].'"';



if($_POST['year']!='')

$cons.=' and k.YEAR ="'.$_POST['year'].'"';



//date_format(a.PBI_DOJ,'%d-%M-%Y')




$sqld="select desg.DESG_DESC,p.PBI_DOJ,p.PBI_NAME,p.PBI_ID,k.GRADE,k.SCORE,k.YEAR from designation desg, personnel_basic_info p,
kpi_final_score k where p.PBI_ID=k.PBI_ID and p.PBI_DESIGNATION=desg.DESG_ID and k.year='".$_POST['year']."' ".$cons." group by k.PBI_ID";
$queryd=mysql_query($sqld);
while($data = mysql_fetch_object($queryd)){



$total_score = find_a_field('kpi_final_score','sum(SCORE)','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'"');

$week_count = find_a_field('kpi_final_score','count(PBI_ID)','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'"');

$avg_week = $total_score/$week_count;



switch($avg_week){



						    case $avg_week>=90:

							    $grade = 'A';

								 break;



						    case $avg_week>=80 && $grade<90:

							  $grade = 'B';

							   break;



							   case $avg_week>=80 && $grade<90:

							   $grade = 'B';

							   break;



							   case $avg_week>=70 && $grade<80:

							   $grade = 'C';

							   break;



							   case $avg_week>=60 && $grade<70:

							   $grade = 'D';

							   break;



							   case $avg_week>=1 && $grade<60:

							   $grade = 'F';

							   break;



							   default:

							     $grade = ' ';



						   }



?>

<tr align="center">

  <td><?=++$k?></td>

  <td><?=$data->PBI_ID?></td>

  <td><?=$data->PBI_NAME?></td>

  <td><?=$data->DESG_DESC?></td>

  <td><?=date('d-M-Y',strtotime($data->PBI_DOJ));?></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=01&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="01"');?></a></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=02&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="02"');?></a></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=03&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="03"');?></a></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=04&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="04"');?></a></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=05&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="05"');?></a></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=06&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="06"');?></a></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=07&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="07"');?></a></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=08&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="08"');?></a></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=09&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="09"');?></a></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=10&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="10"');?></a></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=11&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="11"');?></a></td>

  <td align="center"><a href="kpi_single_week_view.php?PBI_ID=<?=$data->PBI_ID?>&mon=12&year=<?=$data->YEAR?>" target="_blank"><?=find_a_field('kpi_final_score','grade','PBI_ID="'.$data->PBI_ID.'" and year="'.$data->YEAR.'" and mon="12"');?></a></td>



  <td align="center"><?=$grade?></td>











</tr>

<? } ?>



</tbody></table>











<br><br><br>































<!--<div style="width:100%; margin:60px auto">















<div style="float:left; width:20%; text-align:center">-------------------<br>Prepared By</div>







<div style="float:left; width:20%; text-align:center">-------------------<br>Audit</div>







<div style="float:left; width:20%; text-align:center">-------------------<br>Accounts</div>







<div style="float:left; width:20%; text-align:center">-------------------<br>Managing Director</div>







<div style="float:left; width:20%; text-align:center">-------------------<br>Chairman</div>


</div>-->






<?

}
if($_POST['report']==723)
{


//$dep_head = find_a_field('hrm_pa_set','DEPT_HEAD','PBI_ID="'.$_SESSION['employee_selected'].'"');

$pa_check_user = find_all_field('performance_appraisal','','PBI_ID="'.$_SESSION['employee_selected'].'" and EMPLOYMENT_TYPE="Permanent" and status="DONE" and year="'.$_POST['year'].'"');

$pa_check_entry = find_all_field('performance_appraisal','','PBI_ID="'.$_POST['PBI_ID'].'" and entry_by="'.$_SESSION['employee_selected'].'" and EMPLOYMENT_TYPE="Permanent" 
and status="DONE" and year="'.$_POST['year'].'"');

$pa_check_dep_head = find_all_field('performance_appraisal','','PBI_ID="'.$_POST['PBI_ID'].'" and DEPT_HEAD="'.$_SESSION['employee_selected'].'" and EMPLOYMENT_TYPE="Permanent" and 
year="'.$_POST['year'].'"');



if($pa_check_user>0){

$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_SESSION['employee_selected'].'"');
$line_manager = find_a_field('hrm_pa_set','LINE_MANAGER','PBI_ID="'.$_SESSION['employee_selected'].'"');
$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$line_manager.'"');

 $pa = find_all_field('performance_appraisal','','PBI_ID="'.$_SESSION['employee_selected'].'" and year="'.$_POST['year'].'"');

 $sql2=  'select AVG(part_1) as part_1,AVG(part_2) as part_2,AVG(part_3) as part_3,AVG(part_4) as part_4,AVG(part_5) as part_5,AVG(part_6) as part_6,AVG(part_7) as part_7,AVG(part_8) as part_8,
 AVG(part_9) as part_9,AVG(part_10) as part_10,AVG(part_11) as part_11,AVG(part_12) as part_12,AVG(part_13) as part_13,AVG(part_14) as part_14,AVG(part_15) as part_15,
 AVG(part_16) as part_16,AVG(part_17) as part_17,AVG(part_18) as part_18,AVG(part_19) as part_19,AVG(part_20) as part_20,AVG(part_21) as part_21,AVG(part_22) as part_22,AVG(part_23) as part_23,
 AVG(part_24) as part_24,AVG(part_25) as part_25,AVG(total_score) as total_score,entry_by

from performance_appraisal where PBI_ID = '.$_SESSION['employee_selected'].'  and year='.$_POST['year'].' and report_approval="1" and status="DONE"';
 
 

 
$query = mysql_query($sql2);


}elseif($pa_check_entry>0){

$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_SESSION['employee_selected'].'"');
$line_manager = find_a_field('hrm_pa_set','LINE_MANAGER','PBI_ID="'.$_SESSION['employee_selected'].'"');
$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$line_manager.'"');

 $pa = find_all_field('performance_appraisal','','PBI_ID="'.$_SESSION['employee_selected'].'" and year="'.$_POST['year'].'"');

  $sql2=  'select AVG(part_1) as part_1,AVG(part_2) as part_2,AVG(part_3) as part_3,AVG(part_4) as part_4,AVG(part_5) as part_5,AVG(part_6) as part_6,AVG(part_7) as part_7,AVG(part_8) as part_8,
 AVG(part_9) as part_9,AVG(part_10) as part_10,AVG(part_11) as part_11,AVG(part_12) as part_12,AVG(part_13) as part_13,AVG(part_14) as part_14,AVG(part_15) as part_15,
 AVG(part_16) as part_16,AVG(part_17) as part_17,AVG(part_18) as part_18,AVG(part_19) as part_19,AVG(part_20) as part_20,AVG(part_21) as part_21,AVG(part_22) as part_22,AVG(part_23) as part_23,
 AVG(part_24) as part_24,AVG(part_25) as part_25,AVG(total_score) as total_score

 from performance_appraisal where PBI_ID = '.$_POST['PBI_ID'].' and entry_by="'.$_SESSION['employee_selected'].'" and year='.$_POST['year'].' and report_approval="1" and status="DONE"';
$query = mysql_query($sql2);


}elseif($pa_check_dep_head>0){

$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_POST['PBI_ID'].'"');
$line_manager = find_a_field('hrm_pa_set','LINE_MANAGER','PBI_ID="'.$_POST['PBI_ID'].'"');
$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$line_manager.'"');
$pa = find_all_field('performance_appraisal','','PBI_ID="'.$_POST['PBI_ID'].'" and year="'.$_POST['year'].'"');

 $sql2=  'select AVG(part_1) as part_1,AVG(part_2) as part_2,AVG(part_3) as part_3,AVG(part_4) as part_4,AVG(part_5) as part_5,AVG(part_6) as part_6,AVG(part_7) as part_7,AVG(part_8) as part_8,
 AVG(part_9) as part_9,AVG(part_10) as part_10,AVG(part_11) as part_11,AVG(part_12) as part_12,AVG(part_13) as part_13,AVG(part_14) as part_14,AVG(part_15) as part_15,
 AVG(part_16) as part_16,AVG(part_17) as part_17,AVG(part_18) as part_18,AVG(part_19) as part_19,AVG(part_20) as part_20,AVG(part_21) as part_21,AVG(part_22) as part_22,AVG(part_23) as part_23,
 AVG(part_24) as part_24,AVG(part_25) as part_25,AVG(total_score) as total_score

 from performance_appraisal where PBI_ID = '.$_POST['PBI_ID'].' and DEPT_HEAD="'.$_SESSION['employee_selected'].'" and year='.$_POST['year'].' and report_approval="1" and status="DONE"';
$query = mysql_query($sql2);

}else{}

while($result = mysql_fetch_object($query)){
	//Avarage Number Count
	 $question1 = round($result->part_1);
	$question2 = round($result->part_2);
	$question3 = round($result->part_3);
	$question4 = round($result->part_4);
	$question5 = round($result->part_5);
	$question6 = round($result->part_6);
	$question7 = round($result->part_7);
	$question8 = round($result->part_8);
	$question9 = round($result->part_9);
	$question10 = round($result->part_10);
	$question11 = round($result->part_11);
	$question12 = round($result->part_12);
	$question13 = round($result->part_13);
	$question14 = round($result->part_14);
	$question15 = round($result->part_15);
	$question16 = round($result->part_16);
	$question17 = round($result->part_17);
	$question18 = round($result->part_18);
	$question19 = round($result->part_19);
	$question20 = round($result->part_20);
	$question21 = round($result->part_21);
	$question22 = round($result->part_22);
	$question23 = round($result->part_23);
	$question24 = round($result->part_24);
	$question25 = round($result->part_25);
	$Total_Score = round($result->total_score);

}



function rating($rate){

 if($rate==5){

  $status = 'Outstanding';

 }elseif($rate==4){

  $status = 'Very Good';

 }elseif($rate==3){

  $status = 'Good';

 }elseif($rate==2){

  $status = 'Fair';

 }elseif($rate==1){

  $status = 'Need Improvements';

 }elseif($rate==0){

  $status = 'Unsatisfactory';

 }

 return $status;

}

?>

<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
	<thead><tr><td style="border:0px; font-family:bank gothic; font-size:20px; font-weight:bold;" colspan="11" align="center">AKSID CORPORATION LIMITED</td></tr>
	<tr><td style="border:0px;" colspan="11" align="center"><?=$str?></td></tr>


		<tr height="60">



		 



		    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">







			<tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;"> ID NO : <b><?=$employee->PBI_ID?></b></td>



			   <td style="font-size:16px; padding:2px;">NAME : <b><?=$employee->PBI_NAME?></b> </td>



			    <td style="font-size:16px; padding:2px;">DESIGNATION :  <b><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></b></td>



			</tr>







			<tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;">DEPARTMENT :  <b><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></b></td>



			   <td style="font-size:16px; padding:2px;"> PROJECT NAME :  <b><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></b></td>



			    <td style="font-size:16px; padding:2px;">JOINING DATE :  <b><?=date('d-M-Y',strtotime($employee->PBI_DOJ)) ?></b></td>



			</tr>











			 <tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;">Name of Appraiser : <b><?=$appraiser->PBI_NAME?></b></td>







			   <td style="font-size:16px; padding:2px;">Designation of Appraiser : <b><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></b></td>



			   <td></td>



			</tr>



			</table>



		 







	 </tr>



</table><br />

<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px; background-color:#59B2EA;">



		<td style="padding:5px; width:20%;"><div style="text-align:center"><b>Rating Scale</b></div></td>



		<td style="padding:5px; width:30%; text-align:center"><b>Description</b></td>



		<td style="padding:5px; width:20%; text-align:center"><b>Rating Scale</b></td>



		<td style="padding:5px; width:30%; text-align:center"><b>Description</b></td>







	  </tr>







	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; text-align:center">0-Point</td>



		<td style="padding:5px;" >Performance does not meet requirements of the job</td>



		<td style="padding:5px; text-align:center">1-Point</td>



		<td style="padding:5px;">Performance is inconsistent. Meets requirements of the job</td>



	  </tr>







	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; text-align:center">2-Point</td>



		<td style="padding:5px;">Performance is satisfactory. Meets minimum requirements of the needs</td>



		<td style="padding:5px; text-align:center">3-Point</td>



		<td style="padding:5px;">Performance is consistent. Clearly meets job requirements</td>



	  </tr>







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; text-align:center">4-Point</td>



		<td style="padding:5px;">Performance is exceptional and far exceeds expectations. Demonstrates excellent standards</td>



		<td style="padding:5px; text-align:center"></td>



		<td style="padding:5px;"></td>



	  </tr>















  </table><br />

		<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:18px;">







	 <!--Part-1-->



	  <tr style="font-family: Cambria,Georgia,serif;font-size:18px;background-color:#59B2EA;">



		<td style="padding:5px; width:40%" align="left" colspan="2">

		<input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><b>PART I &nbsp;&nbsp;</b> <b>EMPLOYEE</b></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><b>Rating</b></td>

	  </tr>







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Teamwork</span></td>



		<td style="padding:5px;">Able and willing to work effectively with others in a team <br><span style="font-size:14px">দলের অন্যদের সঙ্গে কাজ করতে ইচ্ছুক এবং সক্ষম কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question1?></td>

		<td style="padding:5px;" align="center"><?=rating($question1)?></td>

	  </tr>







  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Communication Skills</span></td>



		<td style="padding:5px;">Highly disciplined in conveying information through presentations and does proper use of English while communicating via email or any other medium.<br>
			<span style="font-size:14px">উপস্থাপনার মাধ্যমে তথ্য জানানোর ক্ষেত্রে অত্যন্ত সুশৃঙ্খল এবং ইমেইল বা অন্য কোনো মাধ্যমে যোগাযোগ করার সময় ইংরেজির যথাযথ ব্যবহার করে থাকে।</span></td>



		<td style="padding:5px;" align="center"><?=$question2?></td>

		<td style="padding:5px;" align="center"><?=rating($question2)?></td>

	  </tr>




		<tr style="font-family: Cambria,Georgia,serif; font-size:18px">



	 <td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Analytical Skills</span></td>



	<td style="padding:5px;">Analyzes data and information from several sources and arrives at logical conclusions.<br>
	<span style="font-size:14px">বিভিন্ন উৎস থেকে ডেটা এবং তথ্য বিশ্লেষণ করে এবং যৌক্তিক সিদ্ধান্তে পৌঁছায় কি না।</span></td>



	 <td style="padding:5px;" align="center"><?=$question21?></td>

	 <td style="padding:5px;" align="center"><?=rating($question21)?></td>

	 </tr>




	 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">


		 <td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Individual  Task</span></td>

		<td style="padding:5px;">Completes tasks in an error free manner and within the timeframe.<br><span style="font-size:14px">নির্ভুলভাবে এবং নির্ধারিত সময়সীমার মধ্যে কাজগুলি সম্পূর্ণ করে।  </span></td>



	<td style="padding:5px;" align="center"><?=$question22?></td>

	<td style="padding:5px;" align="center"><?=rating($question22)?></td>

	</tr>





	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px;text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa->part_1_comment?></td>

	  </tr>



	   <!--Part-1 End-->







	   <!--Part-2-->



	   <tr>



		<td style="padding:5px;font-family: Cambria,Georgia,serif;background-color:#59B2EA;; font-size: 18px;width:40%" align="left" colspan="2">

		<input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><b>PART II &nbsp;&nbsp;</b> <b>PRODUCTS AND SERVICES</b></td>



		<td style="padding:5px; font-family: Cambria,Georgia,serif; font-size:18px;width:10%;background-color:#59B2EA;" align="center" colspan="2"><b>Rating</b></td>

	  </tr>















	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Job Knowledge / Technical Skills </span></th>



		<td style="padding:5px;">Possesses knowledge of work procedures and requirements of job<br>
			<span style="font-size:14px">কাজের পদ্ধতি জানে এবং কাজের জন্য প্রয়োজনীয় জ্ঞান সম্পন্ন কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question3?></td>

		<td style="padding:5px;" align="center"><?=rating($question3)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Shows technical competence/skill in area of specialization<br><span style="font-size:15px">বিশেষ ক্ষেত্রে প্রযুক্তিগত দক্ষতা বা পারদর্শিতা রয়েছে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question4?></td>

		<td style="padding:5px;" align="center"><?=rating($question4)?></td>

	  </tr>











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="3" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Work Attitude </span></th>



		<td style="padding:5px;">Displays commitment to work<br><span style="font-size:14px">কাজের প্রতি নিবেদিত বা প্রতিজ্ঞাবদ্ধ কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question5?></td>

		<td style="padding:5px;" align="center"><?=rating($question5)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Displays a willingness to learn <br> <span style="font-size:14px">নতুন কিছু শিখতে আগ্রহী কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question6?></td>

		<td style="padding:5px;" align="center"><?=rating($question6)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">





		<td style="padding:5px;">Has a sense of urgency in acting on work matters<br>

		  <span style="font-size:14px">জরুরীভিত্তিতে কাজ করার প্রবণতা রয়েছে কি না  </span></td>



		<td style="padding:5px;" align="center"><?=$question7?></td>

		<td style="padding:5px;" align="center"><?=rating($question7)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Quality of Work</span> </td>



		<td style="padding:5px;">Is accurate, thorough and careful with work performed<br>

		  <span style="font-size:14px">কাজ নির্ভুল,সঠিক এবং সতর্কতার সঙ্গে সম্পন্ন করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question8?></td>

		<td style="padding:5px;" align="center"><?=rating($question8)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;"> Quantity of Work </span></td>



		<td style="padding:5px;">Is able to handle a reasonable volume of work<br><span style="font-size:14px">নির্দিষ্ট পরিমানের কাজের চাপ সামলাতে সক্ষম কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question9?></td>

		<td style="padding:5px;" align="center"><?=rating($question9)?></td>

	   </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Safety</span></td>



		<td style="padding:5px;">Ensures careful work habits that comply with safety requirements<br>
			<span style="font-size:14px">সাবধানতার সহিত কাজ করে প্রয়োজনীয় নিরাপত্তা সন্তুষ্ট করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question10?></td>

		<td style="padding:5px;" align="center"><?=rating($question10)?></td>

	   </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Process Improvement </span></td>



		<td style="padding:5px;">Seeks to continuously improve processes and work methods<br>
			<span style="font-size:14px">সবসময় কাজের পদ্ধতি এবং প্রক্রিয়ার উন্নতি করতে চায় কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question11?></td>

		<td style="padding:5px;" align="center"><?=rating($question11)?></td>



	   </tr>



	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px; text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"></td>

	  </tr>





	   <!--Part-2 End-->

	  </table><br />







	  <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">







	 <!--Part-1-->



	  <!-- <tr>



		<td style="padding:5px; width:40%" align="center" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
			<input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" /><strong></strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>



	  </tr> -->







	     <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA;">



		<td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
			<input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" />
			<strong>PART III &nbsp;&nbsp;MANAGEMENT</strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>



	  </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Problem Solving </span></th>



		<td style="padding:5px;">Helps resolve staff problems on work related matters<br>

		 <span style="font-size:14px">কাজ সম্পর্কিত বিষয়ে স্টাফদের সমস্যা সমাধান করতে আন্তরিক কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question12?></td>

		<td style="padding:5px;" align="center"><?=rating($question12)?></td>

	  </tr>











	   <!--Part-1 End-->







	   <!--Part-2-->







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Handles problem situations effectively<br><span style="font-size:14px">যে কোন সমস্যা সামনে আসলে তা সঠিকভাবে পরিচালনা করতে বা সামলাতে পারে কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question13?></td>

		<td style="padding:5px;" align="center"><?=rating($question13)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Motivation of Staff</span> </th>



		<td style="padding:5px;">Is a positive role model for other staff?<br><span style="font-size:14px">অন্য কর্মীদের জন্য একজন আদর্শবান কর্মী কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question14?></td>

		<td style="padding:5px;" align="center"><?=rating($question14)?></td>



	  </tr>











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Effectively supervises work of subordinates<br><span style="font-size:14px">সঠিকভাবে অধীনস্তদের কাজ তত্ত্বাবধান করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question15?></td>

		<td style="padding:5px;" align="center"><?=rating($question15)?></td>

	   </tr>





	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA;">



		<td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" /><strong>PART IV &nbsp;&nbsp; &nbsp; FAIRNESS</strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2" ><strong>Rating</strong></td>



	  </tr>









	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="3"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Dependability / Responsibility</span></th>



		<td style="padding:5px;">Is able to work with limited supervision<br><span style="font-size:14px">অল্পতেই কাজ বুঝিয়ে দিলে কাজ করতে সক্ষম কি না </span> </td>



		<td style="padding:5px;" align="center"><?=$question16?></td>

		<td style="padding:5px;" align="center"><?=rating($question16)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Is trustworthy, responsible and reliable<br><span style="font-size:14px">বিশ্বাসযোগ্য, দায়িত্ববান এবং নির্ভরযোগ্য কি না</span> </td>



		<td style="padding:5px;" align="center"><?=$question17?></td>

		<td style="padding:5px;" align="center"><?=rating($question17)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Is adaptable and willing to accept new responsibilities<br>
			<span style="font-size:14px">যে কোন নতুন পরিস্থিতিতে বা অবস্থায় মানিয়ে চলতে পারে এবং নতুন দায়িত্ব গ্রহণ করতে আগ্রহী কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question18?></td>

		<td style="padding:5px;" align="center"><?=rating($question18)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Attendance/Punctuality</span></th>



		<td style="padding:5px;">Has good attendance<br><span style="font-size:14px">পর্যাপ্ত উপস্থিতি বা হাজিরা রয়েছে কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question19?></td>

		<td style="padding:5px;" align="center"><?=rating($question19)?></td>

	   </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
     <td style="padding:5px;">Is punctual at work <br> <span style="font-size:14px">কর্মক্ষেত্রে সময়নিষ্ঠ কি না</span></td>
     <td style="padding:5px;" align="center"><?=$question20?></td>
     <td style="padding:5px;" align="center"><?=rating($question20)?></td>
    </tr>


		 <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA;">
	  <td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
	  <input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" />
	  <strong>PART V &nbsp;&nbsp; &nbsp; BEHAVIOUR</strong></td>
	  <td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>
	 </tr>


	 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
  <td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Politeness/Respect</span></td>
	<td style="padding:5px;">Able to stay polite in any interaction and treat everybody with respect.<br>
	<span style="font-size:14px">যেকোনো পরিস্থিতিতে মার্জিত এবং সবার সাথে সম্মানের সাথে আচরণ করতে সক্ষম কি না।</span></td>
  <td style="padding:5px;" align="center"><?=$question23?></td>
  <td style="padding:5px;" align="center"><?=rating($question23)?></td>
 </tr>


 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
<td  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Cooperation</span></td>
<td style="padding:5px;">Willingness to work harmoniously with others in getting a job done.<br>
		<span style="font-size:14px">একটি কাজ সম্পন্ন করার জন্য অন্যদের সাথে তাল মিলিয়ে চলার ইচ্ছা শক্তি পোষণ করে কি না।</span></td>
<td style="padding:5px;" align="center"><?=$question24?></td>
<td style="padding:5px;" align="center"><?=rating($question24)?></td>
</tr>


<tr style="font-family: Cambria,Georgia,serif; font-size:18px">
<td  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Emotional Intelligence</span></td>
<td style="padding:5px;">Tries to understand others’ point of view before making judgments.<br>
<span style="font-size:14px">বিচার করার আগে অন্যদের দৃষ্টিভঙ্গি বোঝার চেষ্টা করে কি না।</span></td>
<td style="padding:5px;" align="center"><?=$question25?></td>
<td style="padding:5px;" align="center"><?=rating($question25)?></td>
</tr>



<tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px;" >Comments</td>



		<td style="padding:5px;" colspan="4"><?=$pa->part_3_comment?></td>



	  </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px;" >Total Score : </td>



		<td style="padding:5px;" colspan="4"><?=$Total_Score;?></td>



	  </tr>



	   <!--Part-2 End-->











	 </table>  <br>




<!--New Report for probationary priord emp-->

<? 



}
if($_POST['report']==724)
{
//$dep_head = find_a_field('hrm_pa_set','DEPT_HEAD','PBI_ID="'.$_SESSION['employee_selected'].'"');

$pa_check_user = find_all_field('performance_appraisal','','PBI_ID="'.$_SESSION['employee_selected'].'" and EMPLOYMENT_TYPE="Probationary" and status="DONE" and year="'.$_POST['year'].'"');

$pa_check_entry = find_all_field('performance_appraisal','','PBI_ID="'.$_POST['PBI_ID'].'" and entry_by="'.$_SESSION['employee_selected'].'" and EMPLOYMENT_TYPE="Probationary" 
and status="DONE" and year="'.$_POST['year'].'"');

$pa_check_dep_head = find_all_field('performance_appraisal','','PBI_ID="'.$_POST['PBI_ID'].'" and DEPT_HEAD="'.$_SESSION['employee_selected'].'" and EMPLOYMENT_TYPE="Probationary" and year="'.$_POST['year'].'"');




if($pa_check_user->PBI_ID>0){


$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_SESSION['employee_selected'].'"');
$line_manager = find_a_field('hrm_pa_set','LINE_MANAGER','PBI_ID="'.$_SESSION['employee_selected'].'"');
$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$line_manager.'"');
$pa = find_all_field('performance_appraisal','','PBI_ID="'.$_SESSION['employee_selected'].'" and year="'.$_POST['year'].'"');

 $sql2=  'select id, part_1 as part_1,part_2 as part_2,part_3 as part_3,part_4 as part_4,part_5 as part_5,part_6 as part_6,part_7 as part_7,part_8 as part_8,
 part_9 as part_9,part_10 as part_10,part_11 as part_11,part_12 as part_12,part_13 as part_13,part_14 as part_14,part_15 as part_15,
 part_16 as part_16,part_17 as part_17,part_18 as part_18,part_19 as part_19,part_20 as part_20,part_21 as part_21,part_22 as part_22,part_23 as part_23,
 part_24 as part_24,part_25 as part_25,total_score as total_score,extension_date,part_1_comment,part_2_comment,part_3_comment,part_4_comment,part_5_comment,PBI_ID

 from performance_appraisal where PBI_ID = '.$_SESSION['employee_selected'].'  and EMPLOYMENT_TYPE="Probationary" and year='.$_POST['year'].' and report_approval="1" and status="DONE" order by id desc LIMIT 1';
$query = mysql_query($sql2);
 

 
 
 }elseif($pa_check_entry->PBI_ID>0){

$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_POST['PBI_ID'].'"');
$line_manager = find_a_field('hrm_pa_set','LINE_MANAGER','PBI_ID="'.$_POST['PBI_ID'].'"');
$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$line_manager.'"');
$pa = find_all_field('performance_appraisal','','PBI_ID="'.$_POST['PBI_ID'].'" and year="'.$_POST['year'].'"');
 
  $sql2=  'select id, part_1 as part_1,part_2 as part_2,part_3 as part_3,part_4 as part_4,part_5 as part_5,part_6 as part_6,part_7 as part_7,part_8 as part_8,
 part_9 as part_9,part_10 as part_10,part_11 as part_11,part_12 as part_12,part_13 as part_13,part_14 as part_14,part_15 as part_15,
 part_16 as part_16,part_17 as part_17,part_18 as part_18,part_19 as part_19,part_20 as part_20,part_21 as part_21,part_22 as part_22,part_23 as part_23,
 part_24 as part_24,part_25 as part_25,total_score as total_score,extension_date,part_1_comment,part_2_comment,part_3_comment,part_4_comment,part_5_comment,PBI_ID

 from performance_appraisal where PBI_ID = "'.$_POST['PBI_ID'].'" and entry_by="'.$_SESSION['employee_selected'].'" and EMPLOYMENT_TYPE="Probationary"   and 
 year='.$_POST['year'].' and report_approval="1" and status="DONE" order by id desc LIMIT 1';
$query = mysql_query($sql2);

}elseif($pa_check_dep_head->PBI_ID>0){


$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_POST['PBI_ID'].'"');
$line_manager = find_a_field('hrm_pa_set','LINE_MANAGER','PBI_ID="'.$_POST['PBI_ID'].'"');
$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$line_manager.'"');
$pa = find_all_field('performance_appraisal','','PBI_ID="'.$_POST['PBI_ID'].'" and year="'.$_POST['year'].'"');

//$pa_comments = find_all_field('performance_appraisal','','PBI_ID="'.$_POST['PBI_ID'].'" and DEPT_HEAD="'.$_SESSION['employee_selected'].'" and  EMPLOYMENT_TYPE="Probationary" and year="'.$_POST['year'].'"
//and report_approval="1" and status="DONE" order by id desc LIMIT 1');

 
 $sql2=  'select id, part_1 as part_1,part_2 as part_2,part_3 as part_3,part_4 as part_4,part_5 as part_5,part_6 as part_6,part_7 as part_7,part_8 as part_8,
 part_9 as part_9,part_10 as part_10,part_11 as part_11,part_12 as part_12,part_13 as part_13,part_14 as part_14,part_15 as part_15,
 part_16 as part_16,part_17 as part_17,part_18 as part_18,part_19 as part_19,part_20 as part_20,part_21 as part_21,part_22 as part_22,part_23 as part_23,
 part_24 as part_24,part_25 as part_25,total_score as total_score,extension_date,part_1_comment,part_2_comment,part_3_comment,part_4_comment,part_5_comment,PBI_ID

 from performance_appraisal where PBI_ID = "'.$_POST['PBI_ID'].'" and DEPT_HEAD="'.$_SESSION['employee_selected'].'" and EMPLOYMENT_TYPE="Probationary"   and 
 year='.$_POST['year'].' and report_approval="1" and status="DONE" order by id desc LIMIT 1';
$query = mysql_query($sql2);



}else{}




while($result = mysql_fetch_object($query)){
 $extension_datee = $result->extension_date;
	//Avarage Number Count
	$question1 = round($result->part_1);
	$question2 = round($result->part_2);
	$question3 = round($result->part_3);
	$question4 = round($result->part_4);
	$question5 = round($result->part_5);
	$question6 = round($result->part_6);
	$question7 = round($result->part_7);
	$question8 = round($result->part_8);
	$question9 = round($result->part_9);
	$question10 = round($result->part_10);
	$question11 = round($result->part_11);
	$question12 = round($result->part_12);
	$question13 = round($result->part_13);
	$question14 = round($result->part_14);
	$question15 = round($result->part_15);
	$question16 = round($result->part_16);
	$question17 = round($result->part_17);
	$question18 = round($result->part_18);
	$question19 = round($result->part_19);
	$question20 = round($result->part_20);
	$question21 = round($result->part_21);
	$question22 = round($result->part_22);
	$question23 = round($result->part_23);
	$question24 = round($result->part_24);
	$question25 = round($result->part_25);
	$Total_Score = round($result->total_score);
	
//$pa_comments = find_all_field('performance_appraisal','','PBI_ID="'.$result->PBI_ID.'" and  EMPLOYMENT_TYPE="Probationary" and year="'.$_POST['year'].'" order by id desc LIMIT 1');



$pa_comments1 = $result->part_1_comment;
$pa_comments2 = $result->part_2_comment;
$pa_comments3 = $result->part_3_comment;
$pa_comments4 = $result->part_4_comment;
$pa_comments5 = $result->part_5_comment;


}



function rating($rate){

 if($rate==5){

  $status = 'Outstanding';

 }elseif($rate==4){

  $status = 'Very Good';

 }elseif($rate==3){

  $status = 'Good';

 }elseif($rate==2){

  $status = 'Fair';

 }elseif($rate==1){

  $status = 'Need Improvements';

 }elseif($rate==0){

  $status = 'Unsatisfactory';

 }

 return $status;

}

?>

<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
	<thead><tr><td style="border:0px; font-family:bank gothic; font-size:20px; font-weight:bold;" colspan="11" align="center">AKSID CORPORATION LIMITED</td></tr>
	<tr><td style="border:0px;" colspan="11" align="center"><?=$str?></td></tr>


		<tr height="60">



	



		    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">







			<tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;"> ID NO : <b><?=$employee->PBI_ID?></b></td>



			   <td style="font-size:16px; padding:2px;">NAME : <b><?=$employee->PBI_NAME?></b> </td>



			    <td style="font-size:16px; padding:2px;">DESIGNATION :  <b><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></b></td>



			</tr>







			<tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;">DEPARTMENT :  <b><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></b></td>



			   <td style="font-size:16px; padding:2px;"> PROJECT NAME :  <b><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></b></td>



			    <td style="font-size:16px; padding:2px;">JOINING DATE :  <b><?=date('d-M-Y',strtotime($employee->PBI_DOJ)) ?></b></td>



			</tr>











			 <tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;">Name of Appraiser : <b><?=$appraiser->PBI_NAME?></b></td>







			   <td style="font-size:16px; padding:2px;">Designation of Appraiser : <b><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></b></td>



			   <td></td>



			</tr>



			</table>



		







	 </tr>



</table><br />

<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px; background-color:#59B2EA">



		<td style="padding:5px; width:20%;"><div style="text-align:center"><b>Rating Scale</b></div></td>



		<td style="padding:5px; width:30%; text-align:center"><b>Description</b></td>



		<td style="padding:5px; width:20%; text-align:center"><b>Rating Scale</b></td>



		<td style="padding:5px; width:30%; text-align:center"><b>Description</b></td>







	  </tr>







	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; text-align:center">0-Point</td>



		<td style="padding:5px;" >Performance does not meet requirements of the job</td>



		<td style="padding:5px; text-align:center">1-Point</td>



		<td style="padding:5px;">Performance is inconsistent. Meets requirements of the job</td>



	  </tr>







	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; text-align:center">2-Point</td>



		<td style="padding:5px;">Performance is satisfactory. Meets minimum requirements of the needs</td>



		<td style="padding:5px; text-align:center">3-Point</td>



		<td style="padding:5px;">Performance is consistent. Clearly meets job requirements</td>



	  </tr>







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; text-align:center">4-Point</td>



		<td style="padding:5px;">Performance is exceptional and far exceeds expectations. Demonstrates excellent standards</td>



		<td style="padding:5px; text-align:center"></td>



		<td style="padding:5px;"></td>



	  </tr>















  </table><br />

		<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:18px;">







	 <!--Part-1-->



	  <tr style="font-family: Cambria,Georgia,serif;font-size:18px;background-color:#59B2EA">



		<td style="padding:5px; width:40%" align="left" colspan="2">

		<input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><b>PART I &nbsp;&nbsp;</b> <b>EMPLOYEE</b></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><b>Rating</b></td>

	  </tr>







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Teamwork</span></td>



		<td style="padding:5px;">Able and willing to work effectively with others in a team <br><span style="font-size:14px">দলের অন্যদের সঙ্গে কাজ করতে ইচ্ছুক এবং সক্ষম কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question1?></td>

		<td style="padding:5px;" align="center"><?=rating($question1)?></td>

	  </tr>







  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Communication Skills</span></td>



		<td style="padding:5px;">Highly disciplined in conveying information through presentations and does proper use of English while communicating via email or any other medium.<br>
			<span style="font-size:14px">উপস্থাপনার মাধ্যমে তথ্য জানানোর ক্ষেত্রে অত্যন্ত সুশৃঙ্খল এবং ইমেইল বা অন্য কোনো মাধ্যমে যোগাযোগ করার সময় ইংরেজির যথাযথ ব্যবহার করে থাকে।</span></td>



		<td style="padding:5px;" align="center"><?=$question2?></td>

		<td style="padding:5px;" align="center"><?=rating($question2)?></td>

	  </tr>




		<tr style="font-family: Cambria,Georgia,serif; font-size:18px">



	 <td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Analytical Skills</span></td>



	<td style="padding:5px;">Analyzes data and information from several sources and arrives at logical conclusions.<br>
	<span style="font-size:14px">বিভিন্ন উৎস থেকে ডেটা এবং তথ্য বিশ্লেষণ করে এবং যৌক্তিক সিদ্ধান্তে পৌঁছায় কি না।</span></td>



	 <td style="padding:5px;" align="center"><?=$question21?></td>

	 <td style="padding:5px;" align="center"><?=rating($question21)?></td>

	 </tr>




	 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">


		 <td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Individual  Task</span></td>

		<td style="padding:5px;">Completes tasks in an error free manner and within the timeframe.<br><span style="font-size:14px">নির্ভুলভাবে এবং নির্ধারিত সময়সীমার মধ্যে কাজগুলি সম্পূর্ণ করে।  </span></td>



	<td style="padding:5px;" align="center"><?=$question22?></td>

	<td style="padding:5px;" align="center"><?=rating($question22)?></td>

	</tr>





	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px;text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa_comments1?></td>

	  </tr>



	   <!--Part-1 End-->







	   <!--Part-2-->



	   <tr>



		<td style="padding:5px;font-family: Cambria,Georgia,serif;background-color:#59B2EA; font-size: 18px;width:40%" align="left" colspan="2">

		<input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><b>PART II &nbsp;&nbsp;</b> <b>PRODUCTS AND SERVICES</b></td>



		<td style="padding:5px; font-family: Cambria,Georgia,serif; font-size:18px;width:10%;background-color:#59B2EA" align="center" colspan="2"><b>Rating</b></td>

	  </tr>















	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Job Knowledge / Technical Skills </span></th>



		<td style="padding:5px;">Possesses knowledge of work procedures and requirements of job<br>
			<span style="font-size:14px">কাজের পদ্ধতি জানে এবং কাজের জন্য প্রয়োজনীয় জ্ঞান সম্পন্ন কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question3?></td>

		<td style="padding:5px;" align="center"><?=rating($question3)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Shows technical competence/skill in area of specialization<br><span style="font-size:15px">বিশেষ ক্ষেত্রে প্রযুক্তিগত দক্ষতা বা পারদর্শিতা রয়েছে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question4?></td>

		<td style="padding:5px;" align="center"><?=rating($question4)?></td>

	  </tr>











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="3" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Work Attitude </span></th>



		<td style="padding:5px;">Displays commitment to work<br><span style="font-size:14px">কাজের প্রতি নিবেদিত বা প্রতিজ্ঞাবদ্ধ কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question5?></td>

		<td style="padding:5px;" align="center"><?=rating($question5)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Displays a willingness to learn <br> <span style="font-size:14px">নতুন কিছু শিখতে আগ্রহী কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question6?></td>

		<td style="padding:5px;" align="center"><?=rating($question6)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">





		<td style="padding:5px;">Has a sense of urgency in acting on work matters<br>

		  <span style="font-size:14px">জরুরীভিত্তিতে কাজ করার প্রবণতা রয়েছে কি না  </span></td>



		<td style="padding:5px;" align="center"><?=$question7?></td>

		<td style="padding:5px;" align="center"><?=rating($question7)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Quality of Work</span> </td>



		<td style="padding:5px;">Is accurate, thorough and careful with work performed<br>

		  <span style="font-size:14px">কাজ নির্ভুল,সঠিক এবং সতর্কতার সঙ্গে সম্পন্ন করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question8?></td>

		<td style="padding:5px;" align="center"><?=rating($question8)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;"> Quantity of Work </span></td>



		<td style="padding:5px;">Is able to handle a reasonable volume of work<br><span style="font-size:14px">নির্দিষ্ট পরিমানের কাজের চাপ সামলাতে সক্ষম কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question9?></td>

		<td style="padding:5px;" align="center"><?=rating($question9)?></td>

	   </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Safety</span></td>



		<td style="padding:5px;">Ensures careful work habits that comply with safety requirements<br>
			<span style="font-size:14px">সাবধানতার সহিত কাজ করে প্রয়োজনীয় নিরাপত্তা সন্তুষ্ট করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question10?></td>

		<td style="padding:5px;" align="center"><?=rating($question10)?></td>

	   </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Process Improvement </span></td>



		<td style="padding:5px;">Seeks to continuously improve processes and work methods<br>
			<span style="font-size:14px">সবসময় কাজের পদ্ধতি এবং প্রক্রিয়ার উন্নতি করতে চায় কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question11?></td>

		<td style="padding:5px;" align="center"><?=rating($question11)?></td>



	   </tr>



	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px; text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa_comments2?></td>

	  </tr>





	   <!--Part-2 End-->

	  </table><br />







	  <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">







	 <!--Part-1-->



	  <!-- <tr>



		<td style="padding:5px; width:40%" align="center" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
			<input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" /><strong></strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>



	  </tr> -->







	     <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA">



		<td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
			<input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" />
			<strong>PART III &nbsp;&nbsp;MANAGEMENT</strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>



	  </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Problem Solving </span></th>



		<td style="padding:5px;">Helps resolve staff problems on work related matters<br>

		 <span style="font-size:14px">কাজ সম্পর্কিত বিষয়ে স্টাফদের সমস্যা সমাধান করতে আন্তরিক কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question12?></td>

		<td style="padding:5px;" align="center"><?=rating($question12)?></td>

	  </tr>











	   <!--Part-1 End-->







	   <!--Part-2-->







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Handles problem situations effectively<br><span style="font-size:14px">যে কোন সমস্যা সামনে আসলে তা সঠিকভাবে পরিচালনা করতে বা সামলাতে পারে কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question13?></td>

		<td style="padding:5px;" align="center"><?=rating($question13)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Motivation of Staff</span> </th>



		<td style="padding:5px;">Is a positive role model for other staff?<br><span style="font-size:14px">অন্য কর্মীদের জন্য একজন আদর্শবান কর্মী কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question14?></td>

		<td style="padding:5px;" align="center"><?=rating($question14)?></td>



	  </tr>











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Effectively supervises work of subordinates<br><span style="font-size:14px">সঠিকভাবে অধীনস্তদের কাজ তত্ত্বাবধান করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question15?></td>

		<td style="padding:5px;" align="center"><?=rating($question15)?></td>

	   </tr>
	   
	   
	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px; text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa_comments3?></td>

	  </tr>





	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA">



		<td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" /><strong>PART IV &nbsp;&nbsp; &nbsp; FAIRNESS</strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2" ><strong>Rating</strong></td>



	  </tr>









	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="3"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Dependability / Responsibility</span></th>



		<td style="padding:5px;">Is able to work with limited supervision<br><span style="font-size:14px">অল্পতেই কাজ বুঝিয়ে দিলে কাজ করতে সক্ষম কি না </span> </td>



		<td style="padding:5px;" align="center"><?=$question16?></td>

		<td style="padding:5px;" align="center"><?=rating($question16)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Is trustworthy, responsible and reliable<br><span style="font-size:14px">বিশ্বাসযোগ্য, দায়িত্ববান এবং নির্ভরযোগ্য কি না</span> </td>



		<td style="padding:5px;" align="center"><?=$question17?></td>

		<td style="padding:5px;" align="center"><?=rating($question17)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Is adaptable and willing to accept new responsibilities<br>
			<span style="font-size:14px">যে কোন নতুন পরিস্থিতিতে বা অবস্থায় মানিয়ে চলতে পারে এবং নতুন দায়িত্ব গ্রহণ করতে আগ্রহী কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question18?></td>

		<td style="padding:5px;" align="center"><?=rating($question18)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Attendance/Punctuality</span></th>



		<td style="padding:5px;">Has good attendance<br><span style="font-size:14px">পর্যাপ্ত উপস্থিতি বা হাজিরা রয়েছে কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question19?></td>

		<td style="padding:5px;" align="center"><?=rating($question19)?></td>

	   </tr>



	 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
     <td style="padding:5px;">Is punctual at work <br> <span style="font-size:14px">কর্মক্ষেত্রে সময়নিষ্ঠ কি না</span></td>
     <td style="padding:5px;" align="center"><?=$question20?></td>
     <td style="padding:5px;" align="center"><?=rating($question20)?></td>
    </tr>
	
	<tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px; text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa_comments4?></td>

	  </tr>


		 <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA">
	  <td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
	  <input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" />
	  <strong>PART V &nbsp;&nbsp; &nbsp; BEHAVIOUR</strong></td>
	  <td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>
	 </tr>


	 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
  <td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Politeness/Respect</span></td>
	<td style="padding:5px;">Able to stay polite in any interaction and treat everybody with respect.<br>
	<span style="font-size:14px">যেকোনো পরিস্থিতিতে মার্জিত এবং সবার সাথে সম্মানের সাথে আচরণ করতে সক্ষম কি না।</span></td>
  <td style="padding:5px;" align="center"><?=$question23?></td>
  <td style="padding:5px;" align="center"><?=rating($question23)?></td>
 </tr>


 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
<td  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Cooperation</span></td>
<td style="padding:5px;">Willingness to work harmoniously with others in getting a job done.<br>
		<span style="font-size:14px">একটি কাজ সম্পন্ন করার জন্য অন্যদের সাথে তাল মিলিয়ে চলার ইচ্ছা শক্তি পোষণ করে কি না।</span></td>
<td style="padding:5px;" align="center"><?=$question24?></td>
<td style="padding:5px;" align="center"><?=rating($question24)?></td>
</tr>


<tr style="font-family: Cambria,Georgia,serif; font-size:18px">
<td  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Emotional Intelligence</span></td>
<td style="padding:5px;">Tries to understand others’ point of view before making judgments.<br>
<span style="font-size:14px">বিচার করার আগে অন্যদের দৃষ্টিভঙ্গি বোঝার চেষ্টা করে কি না।</span></td>
<td style="padding:5px;" align="center"><?=$question25?></td>
<td style="padding:5px;" align="center"><?=rating($question25)?></td>
</tr>



<tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px;" >Comments</td>



		<td style="padding:5px;" colspan="4"><?=$pa_comments5?></td>



	  </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px;" >Total Score : </td>



		<td style="padding:5px;" colspan="4"><?=$Total_Score;?></td>



	  </tr>
	  
	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px;" >Remarks : </td>



		<td style="padding:5px;" colspan="4"><?
  if($extension_datee>0){
  
   echo $extension_dateeee = '(Extension Date:'.date('d-M-Y',strtotime($extension_datee)).')';
   
   
  }
  ?></td>



	  </tr>



	   <!--Part-2 End-->











	 </table>  <br>




<!--Probation preiod APPRAISAL REPORT FOR administraion-->



<!--New Report for probationary priord emp-->

<? 



}
if($_POST['report']==725)
{



$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_POST['PBI_ID'].'"');
$line_manager = find_a_field('hrm_pa_set','LINE_MANAGER','PBI_ID="'.$_POST['PBI_ID'].'"');
$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$line_manager.'"');
$pa = find_all_field('performance_appraisal','','PBI_ID="'.$_POST['PBI_ID'].'" and year="'.$_POST['year'].'"');
 
  $sql2=  'select id, part_1 as part_1,part_2 as part_2,part_3 as part_3,part_4 as part_4,part_5 as part_5,part_6 as part_6,part_7 as part_7,part_8 as part_8,
 part_9 as part_9,part_10 as part_10,part_11 as part_11,part_12 as part_12,part_13 as part_13,part_14 as part_14,part_15 as part_15,
 part_16 as part_16,part_17 as part_17,part_18 as part_18,part_19 as part_19,part_20 as part_20,part_21 as part_21,part_22 as part_22,part_23 as part_23,
 part_24 as part_24,part_25 as part_25,total_score as total_score,extension_date,part_1_comment,part_2_comment,part_3_comment,part_4_comment,part_5_comment,PBI_ID

 from performance_appraisal where PBI_ID = "'.$_POST['PBI_ID'].'" and   EMPLOYMENT_TYPE="Probationary"   and 
 year='.$_POST['year'].' and report_approval="1" and status="DONE" order by id desc LIMIT 1';
$query = mysql_query($sql2);





while($result = mysql_fetch_object($query)){
 $extension_datee = $result->extension_date;
	//Avarage Number Count
	$question1 = round($result->part_1);
	$question2 = round($result->part_2);
	$question3 = round($result->part_3);
	$question4 = round($result->part_4);
	$question5 = round($result->part_5);
	$question6 = round($result->part_6);
	$question7 = round($result->part_7);
	$question8 = round($result->part_8);
	$question9 = round($result->part_9);
	$question10 = round($result->part_10);
	$question11 = round($result->part_11);
	$question12 = round($result->part_12);
	$question13 = round($result->part_13);
	$question14 = round($result->part_14);
	$question15 = round($result->part_15);
	$question16 = round($result->part_16);
	$question17 = round($result->part_17);
	$question18 = round($result->part_18);
	$question19 = round($result->part_19);
	$question20 = round($result->part_20);
	$question21 = round($result->part_21);
	$question22 = round($result->part_22);
	$question23 = round($result->part_23);
	$question24 = round($result->part_24);
	$question25 = round($result->part_25);
	$Total_Score = round($result->total_score);
	
//$pa_comments = find_all_field('performance_appraisal','','PBI_ID="'.$result->PBI_ID.'" and  EMPLOYMENT_TYPE="Probationary" and year="'.$_POST['year'].'" order by id desc LIMIT 1');



$pa_comments1 = $result->part_1_comment;
$pa_comments2 = $result->part_2_comment;
$pa_comments3 = $result->part_3_comment;
$pa_comments4 = $result->part_4_comment;
$pa_comments5 = $result->part_5_comment;


}



function rating($rate){

 if($rate==5){

  $status = 'Outstanding';

 }elseif($rate==4){

  $status = 'Very Good';

 }elseif($rate==3){

  $status = 'Good';

 }elseif($rate==2){

  $status = 'Fair';

 }elseif($rate==1){

  $status = 'Need Improvements';

 }elseif($rate==0){

  $status = 'Unsatisfactory';

 }

 return $status;

}

?>

<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
	<thead><tr><td style="border:0px; font-family:bank gothic; font-size:20px; font-weight:bold;" colspan="11" align="center">AKSID CORPORATION LIMITED</td></tr>
	<tr><td style="border:0px;" colspan="11" align="center"><?=$str?></td></tr>


		<tr height="60">



	



		    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">







			<tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;"> ID NO : <b><?=$employee->PBI_ID?></b></td>



			   <td style="font-size:16px; padding:2px;">NAME : <b><?=$employee->PBI_NAME?></b> </td>



			    <td style="font-size:16px; padding:2px;">DESIGNATION :  <b><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></b></td>



			</tr>







			<tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;">DEPARTMENT :  <b><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></b></td>



			   <td style="font-size:16px; padding:2px;"> PROJECT NAME :  <b><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></b></td>



			    <td style="font-size:16px; padding:2px;">JOINING DATE :  <b><?=date('d-M-Y',strtotime($employee->PBI_DOJ)) ?></b></td>



			</tr>











			 <tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;">Name of Appraiser : <b><?=$appraiser->PBI_NAME?></b></td>







			   <td style="font-size:16px; padding:2px;">Designation of Appraiser : <b><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></b></td>



			   <td></td>



			</tr>



			</table>



		







	 </tr>



</table><br />

<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px; background-color:#59B2EA">



		<td style="padding:5px; width:20%;"><div style="text-align:center"><b>Rating Scale</b></div></td>



		<td style="padding:5px; width:30%; text-align:center"><b>Description</b></td>



		<td style="padding:5px; width:20%; text-align:center"><b>Rating Scale</b></td>



		<td style="padding:5px; width:30%; text-align:center"><b>Description</b></td>







	  </tr>







	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; text-align:center">0-Point</td>



		<td style="padding:5px;" >Performance does not meet requirements of the job</td>



		<td style="padding:5px; text-align:center">1-Point</td>



		<td style="padding:5px;">Performance is inconsistent. Meets requirements of the job</td>



	  </tr>







	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; text-align:center">2-Point</td>



		<td style="padding:5px;">Performance is satisfactory. Meets minimum requirements of the needs</td>



		<td style="padding:5px; text-align:center">3-Point</td>



		<td style="padding:5px;">Performance is consistent. Clearly meets job requirements</td>



	  </tr>







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; text-align:center">4-Point</td>



		<td style="padding:5px;">Performance is exceptional and far exceeds expectations. Demonstrates excellent standards</td>



		<td style="padding:5px; text-align:center"></td>



		<td style="padding:5px;"></td>



	  </tr>















  </table><br />

		<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:18px;">







	 <!--Part-1-->



	  <tr style="font-family: Cambria,Georgia,serif;font-size:18px;background-color:#59B2EA">



		<td style="padding:5px; width:40%" align="left" colspan="2">

		<input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><b>PART I &nbsp;&nbsp;</b> <b>EMPLOYEE</b></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><b>Rating</b></td>

	  </tr>







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Teamwork</span></td>



		<td style="padding:5px;">Able and willing to work effectively with others in a team <br><span style="font-size:14px">দলের অন্যদের সঙ্গে কাজ করতে ইচ্ছুক এবং সক্ষম কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question1?></td>

		<td style="padding:5px;" align="center"><?=rating($question1)?></td>

	  </tr>







  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Communication Skills</span></td>



		<td style="padding:5px;">Highly disciplined in conveying information through presentations and does proper use of English while communicating via email or any other medium.<br>
			<span style="font-size:14px">উপস্থাপনার মাধ্যমে তথ্য জানানোর ক্ষেত্রে অত্যন্ত সুশৃঙ্খল এবং ইমেইল বা অন্য কোনো মাধ্যমে যোগাযোগ করার সময় ইংরেজির যথাযথ ব্যবহার করে থাকে।</span></td>



		<td style="padding:5px;" align="center"><?=$question2?></td>

		<td style="padding:5px;" align="center"><?=rating($question2)?></td>

	  </tr>




		<tr style="font-family: Cambria,Georgia,serif; font-size:18px">



	 <td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Analytical Skills</span></td>



	<td style="padding:5px;">Analyzes data and information from several sources and arrives at logical conclusions.<br>
	<span style="font-size:14px">বিভিন্ন উৎস থেকে ডেটা এবং তথ্য বিশ্লেষণ করে এবং যৌক্তিক সিদ্ধান্তে পৌঁছায় কি না।</span></td>



	 <td style="padding:5px;" align="center"><?=$question21?></td>

	 <td style="padding:5px;" align="center"><?=rating($question21)?></td>

	 </tr>




	 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">


		 <td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Individual  Task</span></td>

		<td style="padding:5px;">Completes tasks in an error free manner and within the timeframe.<br><span style="font-size:14px">নির্ভুলভাবে এবং নির্ধারিত সময়সীমার মধ্যে কাজগুলি সম্পূর্ণ করে।  </span></td>



	<td style="padding:5px;" align="center"><?=$question22?></td>

	<td style="padding:5px;" align="center"><?=rating($question22)?></td>

	</tr>





	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px;text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa_comments1?></td>

	  </tr>



	   <!--Part-1 End-->







	   <!--Part-2-->



	   <tr>



		<td style="padding:5px;font-family: Cambria,Georgia,serif;background-color:#59B2EA; font-size: 18px;width:40%" align="left" colspan="2">

		<input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><b>PART II &nbsp;&nbsp;</b> <b>PRODUCTS AND SERVICES</b></td>



		<td style="padding:5px; font-family: Cambria,Georgia,serif; font-size:18px;width:10%;background-color:#59B2EA" align="center" colspan="2"><b>Rating</b></td>

	  </tr>















	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Job Knowledge / Technical Skills </span></th>



		<td style="padding:5px;">Possesses knowledge of work procedures and requirements of job<br>
			<span style="font-size:14px">কাজের পদ্ধতি জানে এবং কাজের জন্য প্রয়োজনীয় জ্ঞান সম্পন্ন কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question3?></td>

		<td style="padding:5px;" align="center"><?=rating($question3)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Shows technical competence/skill in area of specialization<br><span style="font-size:15px">বিশেষ ক্ষেত্রে প্রযুক্তিগত দক্ষতা বা পারদর্শিতা রয়েছে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question4?></td>

		<td style="padding:5px;" align="center"><?=rating($question4)?></td>

	  </tr>











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="3" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Work Attitude </span></th>



		<td style="padding:5px;">Displays commitment to work<br><span style="font-size:14px">কাজের প্রতি নিবেদিত বা প্রতিজ্ঞাবদ্ধ কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question5?></td>

		<td style="padding:5px;" align="center"><?=rating($question5)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Displays a willingness to learn <br> <span style="font-size:14px">নতুন কিছু শিখতে আগ্রহী কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question6?></td>

		<td style="padding:5px;" align="center"><?=rating($question6)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">





		<td style="padding:5px;">Has a sense of urgency in acting on work matters<br>

		  <span style="font-size:14px">জরুরীভিত্তিতে কাজ করার প্রবণতা রয়েছে কি না  </span></td>



		<td style="padding:5px;" align="center"><?=$question7?></td>

		<td style="padding:5px;" align="center"><?=rating($question7)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Quality of Work</span> </td>



		<td style="padding:5px;">Is accurate, thorough and careful with work performed<br>

		  <span style="font-size:14px">কাজ নির্ভুল,সঠিক এবং সতর্কতার সঙ্গে সম্পন্ন করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question8?></td>

		<td style="padding:5px;" align="center"><?=rating($question8)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;"> Quantity of Work </span></td>



		<td style="padding:5px;">Is able to handle a reasonable volume of work<br><span style="font-size:14px">নির্দিষ্ট পরিমানের কাজের চাপ সামলাতে সক্ষম কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question9?></td>

		<td style="padding:5px;" align="center"><?=rating($question9)?></td>

	   </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Safety</span></td>



		<td style="padding:5px;">Ensures careful work habits that comply with safety requirements<br>
			<span style="font-size:14px">সাবধানতার সহিত কাজ করে প্রয়োজনীয় নিরাপত্তা সন্তুষ্ট করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question10?></td>

		<td style="padding:5px;" align="center"><?=rating($question10)?></td>

	   </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Process Improvement </span></td>



		<td style="padding:5px;">Seeks to continuously improve processes and work methods<br>
			<span style="font-size:14px">সবসময় কাজের পদ্ধতি এবং প্রক্রিয়ার উন্নতি করতে চায় কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question11?></td>

		<td style="padding:5px;" align="center"><?=rating($question11)?></td>



	   </tr>



	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px; text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa_comments2?></td>

	  </tr>





	   <!--Part-2 End-->

	  </table><br />







	  <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">







	 <!--Part-1-->



	  <!-- <tr>



		<td style="padding:5px; width:40%" align="center" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
			<input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" /><strong></strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>



	  </tr> -->







	     <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA">



		<td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
			<input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" />
			<strong>PART III &nbsp;&nbsp;MANAGEMENT</strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>



	  </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Problem Solving </span></th>



		<td style="padding:5px;">Helps resolve staff problems on work related matters<br>

		 <span style="font-size:14px">কাজ সম্পর্কিত বিষয়ে স্টাফদের সমস্যা সমাধান করতে আন্তরিক কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question12?></td>

		<td style="padding:5px;" align="center"><?=rating($question12)?></td>

	  </tr>











	   <!--Part-1 End-->







	   <!--Part-2-->







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Handles problem situations effectively<br><span style="font-size:14px">যে কোন সমস্যা সামনে আসলে তা সঠিকভাবে পরিচালনা করতে বা সামলাতে পারে কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question13?></td>

		<td style="padding:5px;" align="center"><?=rating($question13)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Motivation of Staff</span> </th>



		<td style="padding:5px;">Is a positive role model for other staff?<br><span style="font-size:14px">অন্য কর্মীদের জন্য একজন আদর্শবান কর্মী কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question14?></td>

		<td style="padding:5px;" align="center"><?=rating($question14)?></td>



	  </tr>











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Effectively supervises work of subordinates<br><span style="font-size:14px">সঠিকভাবে অধীনস্তদের কাজ তত্ত্বাবধান করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question15?></td>

		<td style="padding:5px;" align="center"><?=rating($question15)?></td>

	   </tr>
	   
	   
	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px; text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa_comments3?></td>

	  </tr>





	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA">



		<td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" /><strong>PART IV &nbsp;&nbsp; &nbsp; FAIRNESS</strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2" ><strong>Rating</strong></td>



	  </tr>









	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="3"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Dependability / Responsibility</span></th>



		<td style="padding:5px;">Is able to work with limited supervision<br><span style="font-size:14px">অল্পতেই কাজ বুঝিয়ে দিলে কাজ করতে সক্ষম কি না </span> </td>



		<td style="padding:5px;" align="center"><?=$question16?></td>

		<td style="padding:5px;" align="center"><?=rating($question16)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Is trustworthy, responsible and reliable<br><span style="font-size:14px">বিশ্বাসযোগ্য, দায়িত্ববান এবং নির্ভরযোগ্য কি না</span> </td>



		<td style="padding:5px;" align="center"><?=$question17?></td>

		<td style="padding:5px;" align="center"><?=rating($question17)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Is adaptable and willing to accept new responsibilities<br>
			<span style="font-size:14px">যে কোন নতুন পরিস্থিতিতে বা অবস্থায় মানিয়ে চলতে পারে এবং নতুন দায়িত্ব গ্রহণ করতে আগ্রহী কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question18?></td>

		<td style="padding:5px;" align="center"><?=rating($question18)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Attendance/Punctuality</span></th>



		<td style="padding:5px;">Has good attendance<br><span style="font-size:14px">পর্যাপ্ত উপস্থিতি বা হাজিরা রয়েছে কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question19?></td>

		<td style="padding:5px;" align="center"><?=rating($question19)?></td>

	   </tr>



	 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
     <td style="padding:5px;">Is punctual at work <br> <span style="font-size:14px">কর্মক্ষেত্রে সময়নিষ্ঠ কি না</span></td>
     <td style="padding:5px;" align="center"><?=$question20?></td>
     <td style="padding:5px;" align="center"><?=rating($question20)?></td>
    </tr>
	
	<tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px; text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa_comments4?></td>

	  </tr>


		 <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA">
	  <td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
	  <input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" />
	  <strong>PART V &nbsp;&nbsp; &nbsp; BEHAVIOUR</strong></td>
	  <td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>
	 </tr>


	 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
  <td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Politeness/Respect</span></td>
	<td style="padding:5px;">Able to stay polite in any interaction and treat everybody with respect.<br>
	<span style="font-size:14px">যেকোনো পরিস্থিতিতে মার্জিত এবং সবার সাথে সম্মানের সাথে আচরণ করতে সক্ষম কি না।</span></td>
  <td style="padding:5px;" align="center"><?=$question23?></td>
  <td style="padding:5px;" align="center"><?=rating($question23)?></td>
 </tr>


 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
<td  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Cooperation</span></td>
<td style="padding:5px;">Willingness to work harmoniously with others in getting a job done.<br>
		<span style="font-size:14px">একটি কাজ সম্পন্ন করার জন্য অন্যদের সাথে তাল মিলিয়ে চলার ইচ্ছা শক্তি পোষণ করে কি না।</span></td>
<td style="padding:5px;" align="center"><?=$question24?></td>
<td style="padding:5px;" align="center"><?=rating($question24)?></td>
</tr>


<tr style="font-family: Cambria,Georgia,serif; font-size:18px">
<td  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Emotional Intelligence</span></td>
<td style="padding:5px;">Tries to understand others’ point of view before making judgments.<br>
<span style="font-size:14px">বিচার করার আগে অন্যদের দৃষ্টিভঙ্গি বোঝার চেষ্টা করে কি না।</span></td>
<td style="padding:5px;" align="center"><?=$question25?></td>
<td style="padding:5px;" align="center"><?=rating($question25)?></td>
</tr>



<tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px;" >Comments</td>



		<td style="padding:5px;" colspan="4"><?=$pa_comments5?></td>



	  </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px;" >Total Score : </td>



		<td style="padding:5px;" colspan="4"><?=$Total_Score;?></td>



	  </tr>
	  
	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px;" >Remarks : </td>



		<td style="padding:5px;" colspan="4"><?
  if($extension_datee>0){
  
   echo $extension_dateeee = '(Extension Date:'.date('d-M-Y',strtotime($extension_datee)).')';
   
   
  }
  ?></td>



	  </tr>



	   <!--Part-2 End-->











	 </table>  <br>




<!--end -->

<?







}



if($_POST['report']==232)



{







?>


<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px; font-family:bank gothic; font-size:20px; font-weight:bold;" colspan="11" align="center">AKSID CORPORATION LIMITED</td></tr>
<tr><td style="border:0px;" colspan="11" align="center"><?=$str?></td></tr>

<tr>











  <th><div align="center">S/L</div></th>







<th><div align="center">ID</div></th>







<th><div align="center">Name</div></th>











<th><div align="center">Designation</div></th>





<th  align="center"><div align="center">Joining Date</div></th>











<th><div align="center">Job Period</div></th>











<th><div align="center">Total Mark</div></th>







<th><div align="center">Category</div></th>



<th><div align="center">Recommendation</div></th>







</tr>





</thead>











<tbody>







<?















if($_POST['department']!='')

$cons.=' and a.PBI_DEPARTMENT ="'.$_POST['department'].'"';



if($_POST['JOB_LOCATION']!='')

$cons.=' and a.JOB_LOCATION ="'.$_POST['JOB_LOCATION'].'"';



if($_POST['job_status']!='')

$cons.=' and a.PBI_JOB_STATUS ="'.$_POST['job_status'].'"';



if($_POST['PBI_ID']!='')

$cons.=' and a.PBI_ID ="'.$_POST['PBI_ID'].'"';



if($_POST['gender']!='')

$cons.=' and a.PBI_SEX ="'.$_POST['gender'].'"';



//date_format(a.PBI_DOJ,'%d-%M-%Y')





    $sqld="select a.PBI_ID,a.PBI_NAME,date_format(a.PBI_DOJ,'%d-%b-%Y') as joining_date,desg.DESG_DESC as designation,(select DEPT_DESC from department where DEPT_ID=a.PBI_DEPARTMENT) as department,
		(select PROJECT_DESC from project where PROJECT_ID=a.JOB_LOCATION) as project,AVG(b.total_score) as total_score,b.recommendation as final_recommendation,b.extension_date
		from personnel_basic_info a,performance_appraisal b, designation desg
		 where b.status='DONE' and year='".$_POST['year']."' and a.PBI_DESIGNATION=desg.DESG_ID and a.PBI_ID=b.PBI_ID ".$cons." group by b.PBI_ID";







$queryd=mysql_query($sqld);







while($data = mysql_fetch_object($queryd)){



if($data->total_score>=90 && $data->total_score<=100){

  $status = 'Outstanding';

}elseif($data->total_score>=76 && $data->total_score<=89){

 $status = 'Very Good';

}elseif($data->total_score>=60 && $data->total_score<=75){

 $status = 'Good';

}elseif($data->total_score>=45 && $data->total_score<=59){

 $status = 'Fair';

}elseif($data->total_score>=31 && $data->total_score<=44){

 $status = 'Needs Improvement';

}elseif($data->total_score>=0 && $data->total_score<=30){

 $status = 'Unsatisfactory';

}


// ************* Final  recommendation *************//
 if($data->total_score>=45 && $data->total_score<=100){
 $recommendation = "Salary Increment";
 }elseif($data->total_score>=31 && $data->total_score<=44){
 $recommendation = "No Salary Increment";
 }elseif($data->total_score>=0 && $data->total_score<=30){
  $recommendation = "Discontinuation/Termination";
 }






$date1 =$data->joining_date;

/*$date2 = date('Y-12-31');



$diff = abs(strtotime($date2) - strtotime($date1));



$years = floor($diff / (365*60*60*24));

$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));*/


$interval = date_diff(date_create(date('Y-m-d')), date_create($data->joining_date));




?>







<tr><td><?=++$s?></td>







<td align="center"><?=$data->PBI_ID?></td>







<td nowrap="nowrap"><?=$data->PBI_NAME?></td>







  <td nowrap="nowrap"><?=$data->designation?></td>





  <td align="center"><?=$data->joining_date?></td>







  <td align="center"><?=$interval->format("%Y Year, %M Months, %d Days");?></td>







  <td align="center"><?=round($data->total_score)?></td>







  <td align="center"><?=$status?></td>



  <td align="center"><?=$data->final_recommendation?>  
  
  
  <?
  if($data->extension_date>0){
  
   echo $extension_datee = '(Extension Date:'.date('d-M-Y',strtotime($data->extension_date)).')';
   
   
  }
  ?></td>















</tr>







<?







}







?>







</tbody></table>











<br><br><br>































<div style="width:100%; margin:60px auto">















<div style="float:left; width:50%; text-align:center">-------------------<br>Prepared By</div>







<div style="float:left; width:50%; text-align:center">-------------------<br>Managing Director</div>









</div>












<?
}
if($_POST['report']==722)
{



//for loop 
 $sql2=  'select *
from performance_appraisal where PBI_ID = '.$_POST['PBI_ID'].'  and year='.$_POST['year'].' and status="DONE" group by entry_by ';
$query2 = mysql_query($sql2);
while($loop = mysql_fetch_object($query2)){





$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_POST['PBI_ID'].'"');

$line_manager = find_a_field('hrm_pa_set','LINE_MANAGER','PBI_ID="'.$_POST['PBI_ID'].'"');

//$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$line_manager.'"');

$pa = find_all_field('performance_appraisal','','PBI_ID="'.$_POST['PBI_ID'].'" and year="'.$_POST['year'].'"');

 $sql=  'select AVG(part_1) as part_1,AVG(part_2) as part_2,AVG(part_3) as part_3,AVG(part_4) as part_4,AVG(part_5) as part_5,AVG(part_6) as part_6,AVG(part_7) as part_7,AVG(part_8) as part_8,
 AVG(part_9) as part_9,AVG(part_10) as part_10,AVG(part_11) as part_11,AVG(part_12) as part_12,AVG(part_13) as part_13,AVG(part_14) as part_14,AVG(part_15) as part_15,
 AVG(part_16) as part_16,AVG(part_17) as part_17,AVG(part_18) as part_18,AVG(part_19) as part_19,AVG(part_20) as part_20,AVG(part_21) as part_21,AVG(part_22) as part_22,AVG(part_23) as part_23,
 AVG(part_24) as part_24,AVG(part_25) as part_25,AVG(total_score) as total_score,entry_by

 from performance_appraisal where PBI_ID = '.$_POST['PBI_ID'].'  and year='.$_POST['year'].' and status="DONE"';
$query = mysql_query($sql);

while($result = mysql_fetch_object($query)){

 $extension_datee = $result->extension_date;
 
 $appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$result->entry_by.'"');
 
	//Avarage Number Count
	 $question1 = round($result->part_1);
	$question2 = round($result->part_2);
	$question3 = round($result->part_3);
	$question4 = round($result->part_4);
	$question5 = round($result->part_5);
	$question6 = round($result->part_6);
	$question7 = round($result->part_7);
	$question8 = round($result->part_8);
	$question9 = round($result->part_9);
	$question10 = round($result->part_10);
	$question11 = round($result->part_11);
	$question12 = round($result->part_12);
	$question13 = round($result->part_13);
	$question14 = round($result->part_14);
	$question15 = round($result->part_15);
	$question16 = round($result->part_16);
	$question17 = round($result->part_17);
	$question18 = round($result->part_18);
	$question19 = round($result->part_19);
	$question20 = round($result->part_20);
	$question21 = round($result->part_21);
	$question22 = round($result->part_22);
	$question23 = round($result->part_23);
	$question24 = round($result->part_24);
	$question25 = round($result->part_25);
	$Total_Score = round($result->total_score);

}



function rating($rate){

 if($rate==5){

  $status = 'Outstanding';

 }elseif($rate==4){

  $status = 'Very Good';

 }elseif($rate==3){

  $status = 'Good';

 }elseif($rate==2){

  $status = 'Fair';

 }elseif($rate==1){

  $status = 'Need Improvements';

 }elseif($rate==0){

  $status = 'Unsatisfactory';

 }

 return $status;

}






 ?>

<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
	<thead><tr><td style="border:0px; font-family:bank gothic; font-size:20px; font-weight:bold;" colspan="11" align="center">AKSID CORPORATION LIMITED</td></tr>
	<tr><td style="border:0px;" colspan="11" align="center"><?=$str?></td></tr>





		    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">







			<tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;"> ID NO : <b><?=$employee->PBI_ID?></b></td>



			   <td style="font-size:16px; padding:2px;">NAME : <b><?=$employee->PBI_NAME?></b> </td>



			    <td style="font-size:16px; padding:2px;">DESIGNATION :  <b><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></b></td>



			</tr>







			<tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;">DEPARTMENT :  <b><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></b></td>



			   <td style="font-size:16px; padding:2px;"> PROJECT NAME :  <b><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></b></td>



			    <td style="font-size:16px; padding:2px;">JOINING DATE :  <b><?=date('d-M-Y',strtotime($employee->PBI_DOJ)) ?></b></td>



			</tr>



			 <tr style="font-family: Cambria,Georgia,serif;">



			   <td style="font-size:16px; padding:2px;">Name of Appraiser : <b><?=$appraiser->PBI_NAME?></b></td>







			   <td style="font-size:16px; padding:2px;">Designation of Appraiser : <b><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></b></td>



			   <td></td>



			</tr>



			</table>






</table>


<br />

<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA">



		<td style="padding:5px; width:20%; "><div style="text-align:center"><b>Rating Scale</b></div></td>



		<td style="padding:5px; width:30%; text-align:center"><b>Description</b></td>



		<td style="padding:5px; width:20%; text-align:center"><b>Rating Scale</b></td>



		<td style="padding:5px; width:30%; text-align:center"><b>Description</b></td>







	  </tr>







	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px;">



		<td style="padding:5px; text-align:center">0-Point</td>



		<td style="padding:5px;" >Performance does not meet requirements of the job</td>



		<td style="padding:5px; text-align:center">1-Point</td>



		<td style="padding:5px;">Performance is inconsistent. Meets requirements of the job</td>



	  </tr>







	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; text-align:center">2-Point</td>



		<td style="padding:5px;">Performance is satisfactory. Meets minimum requirements of the needs</td>



		<td style="padding:5px; text-align:center">3-Point</td>



		<td style="padding:5px;">Performance is consistent. Clearly meets job requirements</td>



	  </tr>







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; text-align:center">4-Point</td>



		<td style="padding:5px;">Performance is exceptional and far exceeds expectations. Demonstrates excellent standards</td>



		<td style="padding:5px; text-align:center"></td>



		<td style="padding:5px;"></td>



	  </tr>















  </table><br />

		<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:18px;">








	 <!--Part-1-->



	  <tr style="font-family: Cambria,Georgia,serif;font-size:18px;background-color:#59B2EA">



		<td style="padding:5px; width:40%" align="left" colspan="2">

		<input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><b>PART I &nbsp;&nbsp;</b> <b>EMPLOYEE</b></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><b>Rating</b></td>

	  </tr>







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Teamwork</span></td>



		<td style="padding:5px;">Able and willing to work effectively with others in a team <br><span style="font-size:14px">দলের অন্যদের সঙ্গে কাজ করতে ইচ্ছুক এবং সক্ষম কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question1?></td>

		<td style="padding:5px;" align="center"><?=rating($question1)?></td>

	  </tr>







  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Communication Skills</span></td>



		<td style="padding:5px;">Highly disciplined in conveying information through presentations and does proper use of English while communicating via email or any other medium.<br>
			<span style="font-size:14px">উপস্থাপনার মাধ্যমে তথ্য জানানোর ক্ষেত্রে অত্যন্ত সুশৃঙ্খল এবং ইমেইল বা অন্য কোনো মাধ্যমে যোগাযোগ করার সময় ইংরেজির যথাযথ ব্যবহার করে থাকে।</span></td>



		<td style="padding:5px;" align="center"><?=$question2?></td>

		<td style="padding:5px;" align="center"><?=rating($question2)?></td>

	  </tr>




		<tr style="font-family: Cambria,Georgia,serif; font-size:18px">



	 <td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Analytical Skills</span></td>



	<td style="padding:5px;">Analyzes data and information from several sources and arrives at logical conclusions.<br>
	<span style="font-size:14px">বিভিন্ন উৎস থেকে ডেটা এবং তথ্য বিশ্লেষণ করে এবং যৌক্তিক সিদ্ধান্তে পৌঁছায় কি না।</span></td>



	 <td style="padding:5px;" align="center"><?=$question21?></td>

	 <td style="padding:5px;" align="center"><?=rating($question21)?></td>

	 </tr>




	 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">


		 <td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Individual  Task</span></td>

		<td style="padding:5px;">Completes tasks in an error free manner and within the timeframe.<br><span style="font-size:14px">নির্ভুলভাবে এবং নির্ধারিত সময়সীমার মধ্যে কাজগুলি সম্পূর্ণ করে।  </span></td>



	<td style="padding:5px;" align="center"><?=$question22?></td>

	<td style="padding:5px;" align="center"><?=rating($question22)?></td>

	</tr>





	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px;text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa->part_1_comment?></td>

	  </tr>



	   <!--Part-1 End-->







	   <!--Part-2-->



	   <tr>



		<td style="padding:5px;font-family: Cambria,Georgia,serif; font-size: 18px;width:40%;background-color:#59B2EA" align="left" colspan="2">

		<input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><b>PART II &nbsp;&nbsp;</b> <b>PRODUCTS AND SERVICES</b></td>



		<td style="padding:5px; font-family: Cambria,Georgia,serif; font-size:18px;width:10%;background-color:#59B2EA" align="center" colspan="2"><b>Rating</b></td>

	  </tr>















	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Job Knowledge / Technical Skills </span></th>



		<td style="padding:5px;">Possesses knowledge of work procedures and requirements of job<br>
			<span style="font-size:14px">কাজের পদ্ধতি জানে এবং কাজের জন্য প্রয়োজনীয় জ্ঞান সম্পন্ন কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question3?></td>

		<td style="padding:5px;" align="center"><?=rating($question3)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Shows technical competence/skill in area of specialization<br><span style="font-size:15px">বিশেষ ক্ষেত্রে প্রযুক্তিগত দক্ষতা বা পারদর্শিতা রয়েছে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question4?></td>

		<td style="padding:5px;" align="center"><?=rating($question4)?></td>

	  </tr>











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="3" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Work Attitude </span></th>



		<td style="padding:5px;">Displays commitment to work<br><span style="font-size:14px">কাজের প্রতি নিবেদিত বা প্রতিজ্ঞাবদ্ধ কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question5?></td>

		<td style="padding:5px;" align="center"><?=rating($question5)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Displays a willingness to learn <br> <span style="font-size:14px">নতুন কিছু শিখতে আগ্রহী কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question6?></td>

		<td style="padding:5px;" align="center"><?=rating($question6)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">





		<td style="padding:5px;">Has a sense of urgency in acting on work matters<br>

		  <span style="font-size:14px">জরুরীভিত্তিতে কাজ করার প্রবণতা রয়েছে কি না  </span></td>



		<td style="padding:5px;" align="center"><?=$question7?></td>

		<td style="padding:5px;" align="center"><?=rating($question7)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Quality of Work</span> </td>



		<td style="padding:5px;">Is accurate, thorough and careful with work performed<br>

		  <span style="font-size:14px">কাজ নির্ভুল,সঠিক এবং সতর্কতার সঙ্গে সম্পন্ন করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question8?></td>

		<td style="padding:5px;" align="center"><?=rating($question8)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;"> Quantity of Work </span></td>



		<td style="padding:5px;">Is able to handle a reasonable volume of work<br><span style="font-size:14px">নির্দিষ্ট পরিমানের কাজের চাপ সামলাতে সক্ষম কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question9?></td>

		<td style="padding:5px;" align="center"><?=rating($question9)?></td>

	   </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Safety</span></td>



		<td style="padding:5px;">Ensures careful work habits that comply with safety requirements<br>
			<span style="font-size:14px">সাবধানতার সহিত কাজ করে প্রয়োজনীয় নিরাপত্তা সন্তুষ্ট করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question10?></td>

		<td style="padding:5px;" align="center"><?=rating($question10)?></td>

	   </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Process Improvement </span></td>



		<td style="padding:5px;">Seeks to continuously improve processes and work methods<br>
			<span style="font-size:14px">সবসময় কাজের পদ্ধতি এবং প্রক্রিয়ার উন্নতি করতে চায় কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question11?></td>

		<td style="padding:5px;" align="center"><?=rating($question11)?></td>



	   </tr>



	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px; text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa->part_2_comment?></td>

	  </tr>
	  
	  
	  





	   <!--Part-2 End-->
<!--
	  </table><br />







	  <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">



-->



	 <!--Part-1-->



	  <!-- <tr>



		<td style="padding:5px; width:40%" align="center" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
			<input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" /><strong></strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>



	  </tr> -->







	     <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA">



		<td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
			<input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" />
			<strong>PART III &nbsp;&nbsp;MANAGEMENT</strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>



	  </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Problem Solving </span></th>



		<td style="padding:5px;">Helps resolve staff problems on work related matters<br>

		 <span style="font-size:14px">কাজ সম্পর্কিত বিষয়ে স্টাফদের সমস্যা সমাধান করতে আন্তরিক কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question12?></td>

		<td style="padding:5px;" align="center"><?=rating($question12)?></td>

	  </tr>











	   <!--Part-1 End-->







	   <!--Part-2-->







	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Handles problem situations effectively<br><span style="font-size:14px">যে কোন সমস্যা সামনে আসলে তা সঠিকভাবে পরিচালনা করতে বা সামলাতে পারে কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question13?></td>

		<td style="padding:5px;" align="center"><?=rating($question13)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Motivation of Staff</span> </th>



		<td style="padding:5px;">Is a positive role model for other staff?<br><span style="font-size:14px">অন্য কর্মীদের জন্য একজন আদর্শবান কর্মী কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question14?></td>

		<td style="padding:5px;" align="center"><?=rating($question14)?></td>



	  </tr>
	  
	  
	  











	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Effectively supervises work of subordinates<br><span style="font-size:14px">সঠিকভাবে অধীনস্তদের কাজ তত্ত্বাবধান করে কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question15?></td>

		<td style="padding:5px;" align="center"><?=rating($question15)?></td>

	   </tr>
	   
	   
	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px;text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa->part_3_comment?></td>

	  </tr>





	    <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA">



		<td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" /><strong>PART IV &nbsp;&nbsp; &nbsp; FAIRNESS</strong></td>



		<td style="padding:5px; width:10%" align="center" colspan="2" ><strong>Rating</strong></td>



	  </tr>









	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="3"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Dependability / Responsibility</span></th>



		<td style="padding:5px;">Is able to work with limited supervision<br><span style="font-size:14px">অল্পতেই কাজ বুঝিয়ে দিলে কাজ করতে সক্ষম কি না </span> </td>



		<td style="padding:5px;" align="center"><?=$question16?></td>

		<td style="padding:5px;" align="center"><?=rating($question16)?></td>

	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Is trustworthy, responsible and reliable<br><span style="font-size:14px">বিশ্বাসযোগ্য, দায়িত্ববান এবং নির্ভরযোগ্য কি না</span> </td>



		<td style="padding:5px;" align="center"><?=$question17?></td>

		<td style="padding:5px;" align="center"><?=rating($question17)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">







		<td style="padding:5px;">Is adaptable and willing to accept new responsibilities<br>
			<span style="font-size:14px">যে কোন নতুন পরিস্থিতিতে বা অবস্থায় মানিয়ে চলতে পারে এবং নতুন দায়িত্ব গ্রহণ করতে আগ্রহী কি না</span></td>



		<td style="padding:5px;" align="center"><?=$question18?></td>

		<td style="padding:5px;" align="center"><?=rating($question18)?></td>



	   </tr>







	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<th rowspan="2"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Attendance/Punctuality</span></th>



		<td style="padding:5px;">Has good attendance<br><span style="font-size:14px">পর্যাপ্ত উপস্থিতি বা হাজিরা রয়েছে কি না </span></td>



		<td style="padding:5px;" align="center"><?=$question19?></td>

		<td style="padding:5px;" align="center"><?=rating($question19)?></td>

	   </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
     <td style="padding:5px;">Is punctual at work <br> <span style="font-size:14px">কর্মক্ষেত্রে সময়নিষ্ঠ কি না</span></td>
     <td style="padding:5px;" align="center"><?=$question20?></td>
     <td style="padding:5px;" align="center"><?=rating($question20)?></td>
    </tr>
	
	<tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:20px;text-align:center" >Comments</td>



		<td style="padding:5px;" colspan="3"><?=$pa->part_4_comment?></td>

	  </tr>


		 <tr style="font-family: Cambria,Georgia,serif; font-size:18px;background-color:#59B2EA">
	  <td style="padding:5px; width:40%" align="left" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
	  <input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" />
	  <strong>PART V &nbsp;&nbsp; &nbsp; BEHAVIOUR</strong></td>
	  <td style="padding:5px; width:10%" align="center" colspan="2"><strong>Rating</strong></td>
	 </tr>


	 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
  <td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Politeness/Respect</span></td>
	<td style="padding:5px;">Able to stay polite in any interaction and treat everybody with respect.<br>
	<span style="font-size:14px">যেকোনো পরিস্থিতিতে মার্জিত এবং সবার সাথে সম্মানের সাথে আচরণ করতে সক্ষম কি না।</span></td>
  <td style="padding:5px;" align="center"><?=$question23?></td>
  <td style="padding:5px;" align="center"><?=rating($question23)?></td>
 </tr>


 <tr style="font-family: Cambria,Georgia,serif; font-size:18px">
<td  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Cooperation</span></td>
<td style="padding:5px;">Willingness to work harmoniously with others in getting a job done.<br>
		<span style="font-size:14px">একটি কাজ সম্পন্ন করার জন্য অন্যদের সাথে তাল মিলিয়ে চলার ইচ্ছা শক্তি পোষণ করে কি না।</span></td>
<td style="padding:5px;" align="center"><?=$question24?></td>
<td style="padding:5px;" align="center"><?=rating($question24)?></td>
</tr>


<tr style="font-family: Cambria,Georgia,serif; font-size:18px">
<td  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Emotional Intelligence</span></td>
<td style="padding:5px;">Tries to understand others’ point of view before making judgments.<br>
<span style="font-size:14px">বিচার করার আগে অন্যদের দৃষ্টিভঙ্গি বোঝার চেষ্টা করে কি না।</span></td>
<td style="padding:5px;" align="center"><?=$question25?></td>
<td style="padding:5px;" align="center"><?=rating($question25)?></td>
</tr>



<tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px;" >Comments</td>



		<td style="padding:5px;" colspan="4"><?=$pa->part_5_comment?></td>



	  </tr>



	   <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px;" >Total Score : </td>



		<td style="padding:5px;" colspan="4"><?=$Total_Score;?></td>



	  </tr>
	  
	  
	  <tr style="font-family: Cambria,Georgia,serif; font-size:18px">



		<td style="padding:5px;" >Remarks : </td>



		<td style="padding:5px;" colspan="4"><?
  if($extension_datee>0){
  
   echo $extension_dateee = '(Extension Date:'.date('d-M-Y',strtotime($extension_datee)).')';
   
   
  }
  ?></td>



	  </tr>



	   <!--Part-2 End-->











	 </table>  <br>






<? }  }















elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}







?></div>







</form>







</body>







</html>
