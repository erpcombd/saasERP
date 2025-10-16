<?
session_start();
require "../../config/inc.all.php";
require "../../classes/report.class.php";
require_once ('../../common/class.numbertoword.php');
date_default_timezone_set('Asia/Dhaka');

function find1($sql)
	{
	
	$res=@db_query($sql);
	$count=@mysqli_num_rows($res);
	if($count>0)
	{
	$data=@mysqli_fetch_row($res);
	return $data[0];
	}
	else
	return NULL;
	}




if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if($_POST['name']!='')
	$con.=' and a.PBI_NAME like "%'.$_POST['name'].'%"';
	if($_POST['PBI_ORG']!='')
	$con.=' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';
	if($_POST['department']!=''){
	$con.=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';
	$DEPARTMENT_con=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';
	}
	if($_POST['project']!='')
	$con.=' and a.PBI_PROJECT = "'.$_POST['project'].'"';
	if($_POST['designation']!='')
	$con.=' and a.PBI_DESIGNATION = "'.$_POST['designation'].'"';
	if($_POST['zone']!='')
	$con.=' and a.PBI_ZONE = "'.$_POST['zone'].'"';
	
	if($_POST['JOB_LOCATION']!=''){
	$con.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';
	$PBI_LOCATION_con=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';
	}
	
	if($_POST['PBI_GROUP']!=''){
	$con.=' and a.PBI_GROUP = "'.$_POST['PBI_GROUP'].'"';
	$PBI_GROUP_con=' and a.PBI_GROUP = "'.$_POST['PBI_GROUP'].'"';
	}
	
	if($_POST['area']!='')
	$con.=' and a.PBI_AREA = "'.$_POST['area'].'"';
	
	if($_POST['report']!=778){
	if($_POST['branch']!='')
	$con.=' and t.pbi_region ="'.$_POST['branch'].'"';}

	if($_POST['PBI_DOMAIN']!='')	$con .= " and PBI_DOMAIN = '".$_POST['PBI_DOMAIN']."'";
	if($_POST['job_status']!='' && $_POST['report']!=7811 && $_POST['report']!=60 && $_POST['report']!=61)
	$con.=' and a.PBI_JOB_STATUS = "'.$_POST['job_status'].'"';
	if($_POST['gender']!='')
	$con.=' and a.PBI_SEX = "'.$_POST['gender'].'"';
	
	if($_POST['ijdb']!='')
	$con.=' and a.PBI_DOJ < "'.$_POST['ijdb'].'"';
	if($_POST['ppjdb']!='')
	$con.=' and a.PBI_DOJ_PP < "'.$_POST['ppjdb'].'"';
	
	if($_POST['ijda']!='')
	$con.=' and a.PBI_DOJ > "'.$_POST['ijda'].'"';
	if($_POST['ppjda']!='')
	$con.=' and a.PBI_DOJ_PP > "'.$_POST['ppjda'].'"';
	
		if($_POST['start_date']!='')
	$start_date = $_POST['start_date'];
	if($_POST['end_date']!='')
	$end_date = $_POST['end_date'];
	
	if($_POST['pbi_id_in']!='')  $con .= " and a.PBI_ID in (".$_POST['pbi_id_in'].")";
	
switch ($_POST['report']) {
    case 1:
	$report="Employee Basic Information";


$sql="select 
a.PBI_ID as CODE,a.PBI_NAME as Name,
a.PBI_DESIGNATION as designation,
a.PBI_DEPARTMENT as department,
a.incharge_id,a.head_id,
a.PBI_GROUP as `Group`,
DATE_FORMAT(a.PBI_DOJ,'%d-%m-%Y') as joining_date,

DATE_FORMAT(a.PBI_DOC2,'%d-%m-%Y') as confirmation_date,
(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,
(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,
(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_MOBILE as mobile  

from personnel_basic_info a 
where	1 ".$con;

// DATE_FORMAT(a.PBI_DOC,'%d-%m-%Y') as due_confirmation_date,
// (select DESG_DESC from designation where DESG_SHORT_NAME=a.PBI_DESIGNATION) as designation,
break;


}
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />

<style>

td {
  border-bottom: 0px solid #000000; 
  border-right: 0px solid #000000;
  border-left: 0px solid #000000; 
  font: 11px;
  padding: 2px 5px;
}
/*.vertical-text div {
	transform: rotate(-90deg);
	transform-origin: left top 1;
	float: left;
	width: 2px;
	padding: 1px;
	
	
}*/
       @media print {
           thead {display: table-header-group;}
       }
.vertical-text div{

  float: left;
}
p {
    line-height: 15px;
}

</style>

<script type="Mhafuz">
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
<form action="?" method="post">
<?
		//echo $sql;
		$str 	.= '<div class="header">';
		if($_POST['PBI_ORG']!='') 
		$str 	.= '<h2 style="font-size:24px;">'.find_a_field('user_group','group_name','id='.$_POST['PBI_ORG']).'</h2>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if($_POST['mon']!=''){
			if($_POST['report']==777 || $_POST['report']==778){
				if($_POST['bonus_type']==1){
					$str 	.= '<h2>Bonus of Eid-Ul-Fitre '.date('Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year'])).'</h2>';
				}else{
					$str 	.= '<h2>Bonus of Eid-Ul-Adha '.date('Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year'])).'</h2>';
				}
				
			}else{
			if($_POST['report']!=203)
				$str 	.= '<h2>Report of Month: '.date('F-Y',mktime(1,1,1,$_POST['mon'],1,$_POST['year'])).'</h2>';
			}
		} 
		
		if($_POST['department']!=''||$_POST['JOB_LOCATION']!='')
		$str 	.= '<h2>';
		if($_POST['department']!='') 
		$str 	.= 'Department Name: '.find_a_field('department','DEPT_DESC','DEPT_SHORT_NAME="'.$_POST['department'].'"').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		if($_POST['JOB_LOCATION']!='') 
		$str 	.='Location: '.find_a_field('office_location','LOCATION_NAME','ID="'.$_POST['JOB_LOCATION'].'"');
		if($_POST['department']!=''||$_POST['JOB_LOCATION']!='')
		$str 	.= '</h2>';
		$str 	.= '</div>';
		//if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		if(($_POST['PBI_GROUP']!='')) 
		$str 	.= '<p>Product Group: '.$_POST['PBI_GROUP'].'</p>';
		if(($_POST['branch']>0)) 
		$str 	.= '<p>Region Name: '.find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$_POST['branch'].'"').'</p>';
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
		$str 	.= '</div>';
		$str 	.= '<div class="right">';
		if(isset($client_name)) 
		$str 	.= '<p>Client Name: '.$client_name.'</p>';
		if(isset($start_date)) 
		$str 	.= '<p>Schedule Duration: '.$start_date.' to '.$end_date.'</p>';
		//$str 	.= '</div><span>Bonus Cut-Off Date:'.find_a_field('salary_bonus','cut_off_date','bonus_type='.$_POST['bonus_type'].' and year='.$_POST['year']).'</span><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		$str 	.= '</div>';
		$str 	.= '<div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
	
if($_POST['report']==7) {

$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,a.PBI_GROUP,a.held_up_status from 
personnel_basic_info a where 1 ".$con;
$query = db_query($sql);
?><table border="0">
<thead><tr><td style="border:0px;" colspan="13"><?=$str?></td></tr>
<tr><th>S/L</th>
<th>CODE</th>
<th>Name</th>
<th>Desg</th>
<th>Dept</th>
<th>GRP</th>
<th>HS</th>
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
</tr></thead>
<tbody>
<?
while($datas=mysqli_fetch_row($query)){$s++;
$sqld = 'select * from salary_info where PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
<tr><td><?=$s?></td><td><?=$datas[0]?></td><td><?=$datas[1]?></td>
  <td><?=$datas[2]?></td>
  <td><?=$datas[3]?></td>
  <td><?=$datas[4]?></td>
  <td><?=($datas[5]>0)?'Y':'N';?></td>
  <td><?=$data->salary_type?></td><td><?=$data->basic_salary?></td><td><?=$data->consolidated_salary?></td>
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







// Appoinment Letter Issue
if($_POST['report']==80) {

if    ($_POST['pbi_id_to']=='')  $pbi_con = " and PBI_ID in (".$_POST['pbi_id_fr'].")";
elseif($_POST['pbi_id_fr']!='')  $pbi_con = " and PBI_ID between '".$_POST['pbi_id_fr']."' and '".$_POST['pbi_id_to']."' ";
else " and PBI_ID =0";
?>
<!--Appoinment Letter Issue-->
<?
$pbi_sql = "select * from personnel_basic_info where 1 ".$pbi_con;
$pbi_query = db_query($pbi_sql);
while($pbi_basic = mysqli_fetch_object($pbi_query)){

$pbi_salary = find_all_field('salary_info','*','PBI_ID="'.$pbi_basic->PBI_ID.'"');
$designation = find_a_field('designation','DESG_DESC','DESG_ID="'.$pbi_basic->DESG_ID.'"');
$department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$pbi_basic->DEPT_ID.'"');
$location = find_a_field('office_location','LOCATION_NAME','ID="'.$pbi_basic->JOB_LOCATION.'"');
?>
<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid;">

<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>



Date: <?=date("d-M-Y"); ?><p>&nbsp;</p>
Ref	: Appt/ HR/<?=date("Y");?>/<?=date("m");?>/<strong><?=$pbi_basic->PBI_ID; ?></strong><br>
Name: <?=$pbi_basic->PBI_NAME; ?><br>
Father
: <?=$pbi_basic->PBI_FATHER_NAME; ?><br>
Address : <?=$pbi_basic->PBI_PERMANENT_ADD; ?><br>
<br>
<strong>Subject	: <?=$pbi_basic->PBI_PRIMARY_JOB_STATUS; ?> Appointment Letter for the position of <?=$designation; ?></strong>

<br>
<br><strong>Dear <?=$pbi_basic->PBI_NAME; ?></strong>

<br> 
<br>Based on your application at Sajeeb Logistics Ltd. and subsequent interview, we are pleased to inform you that the 
management has decided to appoint you as <strong><?=$designation; ?></strong>
as a contractual appointment under <?=$department; ?> department according to the conditions mentioned below. 
Therefore, you are requested to be present at <strong><?=$location;?></strong> on <strong><?=$pbi_basic->PBI_DOJ; ?></strong> at 9:00am with necessary papers and documents.

<p>&nbsp;</p> 
1. You must work at Sajeeb Logistics Ltd as a contractual employee for at least 12 months. 
Based on your satisfactory job performance, management will consider of your job confirmation. 
Management holds the right to shift you to any work station as necessary.
 
<br>2. Your gross salary will be <strong>Tk. <?=$pbi_salary->basic_salary; ?> (<?=convertNumberMhafuz($pbi_salary->basic_salary); ?>)</strong>

<br>3. You will not be eligible for any other benefits except salary as a contractual employee. 
You will be entitled for regular benefits of the company ones your service becomes permanent. 

<br>4. You will be eligible for festival bonus upon completion of 1 (One) month of employment in the company.  

<br>5. Leave is availed only by the permanent employee. Any other employement status shall not be applicable for leave or whatsoever.

<br>6. You are bound to carry out your responsibilities according to the tasks assigned, as prescribed in your role profile and as per the instruction of your supervisor.

<br>7. Upon cancellation of this employment agreement, You must submit all the assets, 
for example: raw materials, information, memorandum, note, record, planning, name tag, 
ID, uniform etc. or any other material that belong to the company, to the authority. 
Otherwise, these costs will be deducted from your gross salary.


<br>8. Any party of this agreement holds the right to terminate the agreement upon written notice to the other party 
before 1 (One) month of the separation date. If failed, either party will compensate amount equivalent to 1 (One) month of gross salary to the other party. 

<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<br>9. Sajeeb Logistics Ltd. holds the right to take legal actions on the event of breach of contract, 
misconduct (Such as habitual absenteeism, dishonesty, breach of company law, actions against the 
company discipline or any other action which disobeys the law. Upon such event, 
the management may terminate your employment with this company. 


<br>10. You are bound to make proper usage of your working hour to serve the purpose of the company 
and try your best to uphold and improve the ethical practices, goals and objectives, 
comprehensive development, image and goodwill of the company. 


<p>&nbsp;</p> 
We welcome you coordially in Sajeeb Logistics Ltd. and wish your best doing in this company with sincere effort and diligence. 
<br>Please sign below at the designated place and submit it to your supervisor and report to your departmental head.


  
<p>&nbsp;</p><p>&nbsp;</p><br>

<table width="100%" border="0">
  <tr>
    <td><strong>Thanking You,</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Accepted By </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Jaker Sohail Md Abdulla</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong><?=$pbi_basic->PBI_NAME; ?></strong></td>
  </tr>
  <tr>
    <td><strong>Deputy Manager, HR</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<? }}
// end Appoinment Letter Issue



// Promotional Letter Issue
if($_POST['report']==81) {

if    ($_POST['pbi_id_to']=='')  $pbi_con = " and PBI_ID in (".$_POST['pbi_id_fr'].")";
elseif($_POST['pbi_id_fr']!='')  $pbi_con = " and PBI_ID between '".$_POST['pbi_id_fr']."' and '".$_POST['pbi_id_to']."' ";
else " and PBI_ID =0";

$pbi_sql = "select * from personnel_basic_info where 1 ".$pbi_con;
$pbi_query = db_query($pbi_sql);
while($pbi_basic = mysqli_fetch_object($pbi_query)){

$pbi_salary = find_all_field('salary_info','*','PBI_ID="'.$pbi_basic->PBI_ID.'"');
$designation = find_a_field('designation','DESG_DESC','DESG_ID="'.$pbi_basic->DESG_ID.'"');
$department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$pbi_basic->DEPT_ID.'"');
//$location = find_a_field('office_location','LOCATION_NAME','ID="'.$pbi_basic->JOB_LOCATION.'"');
$eff_date = find_a_field('promotion_detail','PROMOTION_DATE','1 and PBI_ID="'.$pbi_basic->PBI_ID.'" order by PROMOTION_D_ID desc');
$old_desi = find1('SELECT d.DESG_DESC FROM  promotion_detail p, designation d 
WHERE  p.PROMOTION_PAST_DESG =d.DESG_ID and p.PBI_ID ="'.$pbi_basic->PBI_ID.'" order by p.PROMOTION_D_ID desc');
?>


<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid;">
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

Date: <?=date("d-M-Y"); ?><br>
Ref	: RCB/HR/Pro/2018/04/<strong><?=$pbi_basic->PBI_ID; ?></strong>
<br><p>&nbsp;</p>
Name: <strong><?=$pbi_basic->PBI_NAME; ?></strong><br>
ID: <?=$pbi_basic->PBI_ID; ?><br>
Designation: <?=$old_desi; ?><br>
Sajeeb Logistics Limited


<br><br>
<strong>Subject	: Promotional</strong>

<br>
<br><strong>Dear <?=$pbi_basic->PBI_NAME; ?></strong>

<br> 
<br>
I am pleased to inform you, based on your satisfactory performance, management
<br>has decided to promote you as <strong><?=$designation; ?></strong>  with effect from <strong><?=$eff_date; ?></strong>
<br>This recognition has been a result of your dedication, sincerity and honesty towards 
<br>the company through your service.<br>

<p>&nbsp;</p>
I am confident that you will bring the same high level of professionalism and hard 
<br>work to your new role as same you are demonstrating currently. 

 
<p>&nbsp;</p>
Congratulations and best wishes for your continued success and growth in this organization. 
  
<p>&nbsp;</p><p>&nbsp;</p><br>

<table width="100%" border="0">
  <tr>
    <td><strong>Sincerely Yours,</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>----------------------------</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Tareq Ibrahim </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Managing Director </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<? }}
// end promotional Letter Issue


// Confirmation of Service
if($_POST['report']==82) {

if    ($_POST['pbi_id_to']=='')  $pbi_con = " and PBI_ID in (".$_POST['pbi_id_fr'].")";
elseif($_POST['pbi_id_fr']!='')  $pbi_con = " and PBI_ID between '".$_POST['pbi_id_fr']."' and '".$_POST['pbi_id_to']."' ";
else " and PBI_ID =0";

$pbi_sql = "select * from personnel_basic_info where 1 ".$pbi_con;
$pbi_query = db_query($pbi_sql);
while($pbi_basic = mysqli_fetch_object($pbi_query)){

$pbi_salary = find_all_field('salary_info','*','PBI_ID="'.$pbi_basic->PBI_ID.'"');
$designation = find_a_field('designation','DESG_DESC','DESG_ID="'.$pbi_basic->DESG_ID.'"');
$department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$pbi_basic->DEPT_ID.'"');
$location = find_a_field('office_location','LOCATION_NAME','ID="'.$pbi_basic->JOB_LOCATION.'"');

//$eff_date = find_a_field('promotion_detail','PROMOTION_DATE','1 and PBI_ID="'.$pbi_basic->PBI_ID.'" order by PROMOTION_D_ID desc');
?>


<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid;">
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

Date: <?=date("d-M-Y"); ?><br>
Ref	: RCB/HR/Conf/2018/04/<strong><?=$pbi_basic->PBI_ID; ?></strong>
<br><p>&nbsp;</p>
Name: <strong><?=$pbi_basic->PBI_NAME; ?></strong><br>
ID: <?=$pbi_basic->PBI_ID; ?><br>
Designation: <?=$designation; ?><br>
Sajeeb Logistics Limited
<br><br>
<strong>Subject	: Confirmation of Service</strong>

<br>
<br><strong>Dear <?=$pbi_basic->PBI_NAME; ?></strong>

<br><br>
I am pleased to inform you, based on your satisfactory performance during 
<br>probation period; management has decided to confirm your service with this 
<br>company with effect from <?=$pbi_basic->PBI_DOC2; ?>. Your monthly gross salary has also been refixed 
<br>at <strong>BDT <?=$pbi_salary->basic_salary; ?>. (<?=convertNumberMhafuz($pbi_salary->basic_salary); ?>)</strong>.<br>

<p>&nbsp;</p>
You are now eligible to avail all other admissible benefits applicable to permanent 
<br>employees as per policies. 

 
<p>&nbsp;</p>
I hope, this endorsement shall motivate you more to do the best in your service. 
  
<p>&nbsp;</p><p>&nbsp;</p><br>

<table width="100%" border="0">
  <tr>
    <td><strong>Sincerely Yours,</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>----------------------------</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Tareq Ibrahim </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Managing Director </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<? }}
// end 82



// Confirmation of Service
if($_POST['report']==182) {

if    ($_POST['pbi_id_to']=='')  $pbi_con = " and PBI_ID in (".$_POST['pbi_id_fr'].")";
elseif($_POST['pbi_id_fr']!='')  $pbi_con = " and PBI_ID between '".$_POST['pbi_id_fr']."' and '".$_POST['pbi_id_to']."' ";
else " and PBI_ID =0";



$pbi_sql = "select * from personnel_basic_info where 1 ".$pbi_con;
$pbi_query = db_query($pbi_sql);
while($pbi_basic = mysqli_fetch_object($pbi_query)){

$pbi_salary = find_all_field('salary_info','*','PBI_ID="'.$pbi_basic->PBI_ID.'"');
$company = find_a_field('user_group','group_name','id="'.$pbi_basic->PBI_ORG.'"');
$designation = find_a_field('designation','DESG_DESC','DESG_ID="'.$pbi_basic->DESG_ID.'"');
$department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$pbi_basic->DEPT_ID.'"');
$location = find_a_field('office_location','LOCATION_NAME','ID="'.$pbi_basic->JOB_LOCATION.'"');

//$eff_date = find_a_field('promotion_detail','PROMOTION_DATE','1 and PBI_ID="'.$pbi_basic->PBI_ID.'" order by PROMOTION_D_ID desc');
?>
<style>
table {
  font-family: arial, sans-serif;
  font-size:14px;
  border-collapse: collapse;
  width: 80%;
}

td, th {
  border: 0px solid #dddddd;
  text-align: left;
  padding: 3px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid;">
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

Date: <?=date("d-M-Y"); ?><br>
Ref	No: SG/GM/HRM/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/<?=date("Y"); ?>
<p>
<table width="37%" border="0">
  <tr>
    <td width="35%">Name</td>
    <td width="3%">:</td>
    <td width="62%"><?=$pbi_basic->PBI_NAME; ?></td>
  </tr>
  <tr>
    <td>Designation</td>
    <td>:</td>
    <td><?=$designation; ?></td>
  </tr>
  <tr>
    <td>Department</td>
    <td>:</td>
    <td><?=$department; ?></td>
  </tr>
  <tr>
    <td>Code</td>
    <td>:</td>
    <td><?=$pbi_basic->PBI_ID; ?></td>
  </tr>
  <tr>
    <td>Unit/Company</td>
    <td>:</td>
    <td><?=$company; ?></td>
  </tr>
</table>


<br>
<strong>Subject	: <u>Letter of Job Confirmation.</u></strong>

<br>
<br><strong>Dear <?=$pbi_basic->PBI_NAME; ?></strong>
<p>Congratulations!

<br>In view of your satisfactory performance as the <?=$designation; ?> in Sajeeb Group the management 
<br>is pleased to confirm your service as per below
<br>


<table width="37%" border="0">
  <tr>
    <td width="6%">a)</td>
    <td width="29%">Designation</td>
    <td width="5%">:</td>
    <td width="60%"><?=$designation; ?></td>
  </tr>
  <tr>
    <td>b)</td>
    <td>Salary</td>
    <td>:</td>
    <td><?=$pbi_salary->basic_salary; ?></td>
  </tr>
  <tr>
    <td>c)</td>
    <td>Incentive</td>
    <td>:</td>
    <td><?=$pbi_salary->incentive_allowance; ?></td>
  </tr>
  <tr>
    <td>d)</td>
    <td>Special Allowance</td>
    <td>:</td>
    <td><?=$pbi_salary->special_allowance; ?></td>
  </tr>
  <tr>
    <td>e)</td>
    <td>TA/DA</td>
    <td>:</td>
    <td><?=$pbi_salary->ta; ?></td>
  </tr>
  <tr>
    <td>f)</td>
    <td>Food Allowance</td>
    <td>:</td>
    <td><?=$pbi_salary->food_allowance; ?></td>
  </tr>
  <tr>
    <td>g)</td>
    <td>Vehicle Allowance</td>
    <td>:</td>
    <td><?=$pbi_salary->vehicle_allowance; ?></td>
  </tr>
  <tr>
    <td>h)</td>
    <td>Mobile Allowance</td>
    <td>:</td>
    <td><?=$pbi_salary->mobile_allowance; ?></td>
  </tr>
  <tr>
    <td>i)</td>
    <td>House Rent</td>
    <td>:</td>
    <td><?=$pbi_salary->house_rent; ?></td>
  </tr>
  <tr>
    <td>j)</td>
    <td>Effective Date</td>
    <td>:</td>
    <td><?=date_format(date_create($pbi_basic->PBI_DOC2),"d-M-Y");?></td>
  </tr>
</table>


<p>
<br>
All other terms and conditions as stated in your Appointment Letter will remain unaltered.									
<br>
<br>We confidently believe that you will utilize the opportunity the Group has rendered for further 
<br>growth of your career.
<br>
<br>We wish continuous prosperity in your personal and professional life.									


<p><br>
<table width="100%" border="0">
  <tr>
    <td><strong>Sincerely Yours,</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>----------------------------</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>HRM <br>Sajeeb Group</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<? }}
// end 182


// Salary certificate
if($_POST['report']==184) {

if    ($_POST['pbi_id_to']=='')  $pbi_con = " and PBI_ID in (".$_POST['pbi_id_fr'].")";
elseif($_POST['pbi_id_fr']!='')  $pbi_con = " and PBI_ID between '".$_POST['pbi_id_fr']."' and '".$_POST['pbi_id_to']."' ";
else " and PBI_ID =0";



$pbi_sql = "select * from personnel_basic_info where 1 ".$pbi_con;
$pbi_query = db_query($pbi_sql);
while($pbi_basic = mysqli_fetch_object($pbi_query)){

$pbi_salary = find_all_field('salary_info','*','PBI_ID="'.$pbi_basic->PBI_ID.'"');
$company = find_a_field('user_group','group_name','id="'.$pbi_basic->PBI_ORG.'"');
$designation = find_a_field('designation','DESG_DESC','DESG_ID="'.$pbi_basic->DESG_ID.'"');
$department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$pbi_basic->DEPT_ID.'"');
$location = find_a_field('office_location','LOCATION_NAME','ID="'.$pbi_basic->JOB_LOCATION.'"');

//$eff_date = find_a_field('promotion_detail','PROMOTION_DATE','1 and PBI_ID="'.$pbi_basic->PBI_ID.'" order by PROMOTION_D_ID desc');
?>
<style>
table {
  font-family: arial, sans-serif;
  font-size:14px;
  border-collapse: collapse;
  width: 80%;
}

td, th {
  border: 0px solid #dddddd;
  text-align: left;
  padding: 3px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid;">
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<h1><center><b>TO WHOM IT MAY CONCERN</b></center></h1>
<p>&nbsp;</p>

Date: <?=date("d-M-Y"); ?><p>&nbsp;</p>
This is to certify that <?=$pbi_basic->PBI_NAME; ?> has been working as a regular employee in our organization.<br>
His employment details are as follows: 
<p>
<table width="37%" border="0">
  <tr>
    <td width="35%">Job Status </td>
    <td width="3%">:</td>
    <td width="62%"><?=$pbi_basic->PBI_PRIMARY_JOB_STATUS; ?></td>
  </tr>
  <tr>
    <td>Designation</td>
    <td>:</td>
    <td><?=$designation; ?></td>
  </tr>
  <tr>
    <td>Employee Code</td>
    <td>:</td>
    <td><?=$pbi_basic->PBI_ID; ?></td>
  </tr>
  <tr>
    <td>Department</td>
    <td>:</td>
    <td><?=$department; ?></td>
  </tr>
  <tr>
    <td>Unit/Company</td>
    <td>:</td>
    <td><?=$company; ?></td>
  </tr>
  <tr>
    <td>Joining Date </td>
    <td>:</td>
    <td><?=date_format(date_create($pbi_basic->PBI_DOJ),"d-M-Y");?></td>
  </tr>
  <tr>
    <td>Retirement Date </td>
    <td>:</td>
    <td>N/A</td>
  </tr>
  <tr>
    <td>Monthly Salary  </td>
    <td>:</td>
    <td><?=$pbi_salary->bank_paid +$pbi_salary->income_tax; ?></td>
  </tr>
  <tr>
    <td>Income Tax</td>
    <td>&nbsp;</td>
    <td><?=$pbi_salary->income_tax; ?></td>
  </tr>
  <tr>
    <td>Net Payable </td>
    <td>:</td>
    <td><?=$pbi_salary->bank_paid; ?></td>
  </tr>
</table>


<p><br>
I hereby certify that the above mentioned information is correct and accurate to the best of my knowledge. 
<p>
<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>----------------------------</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>HRM <br>Sajeeb Group</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<? }}
// end 184


// ACR-HO
if($_POST['report']==183) {

if    ($_POST['pbi_id_to']=='')  $pbi_con = " and PBI_ID in (".$_POST['pbi_id_fr'].")";
elseif($_POST['pbi_id_fr']!='')  $pbi_con = " and PBI_ID between '".$_POST['pbi_id_fr']."' and '".$_POST['pbi_id_to']."' ";
else " and PBI_ID =0";



$pbi_sql = "select * from personnel_basic_info where 1 ".$pbi_con;
$pbi_query = db_query($pbi_sql);
while($pbi_basic = mysqli_fetch_object($pbi_query)){

$pbi_salary = find_all_field('salary_info','*','PBI_ID="'.$pbi_basic->PBI_ID.'"');
$company = find_a_field('user_group','group_name','id="'.$pbi_basic->PBI_ORG.'"');
$designation = find_a_field('designation','DESG_DESC','DESG_ID="'.$pbi_basic->DESG_ID.'"');
$department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$pbi_basic->DEPT_ID.'"');
$location = find_a_field('office_location','LOCATION_NAME','ID="'.$pbi_basic->JOB_LOCATION.'"');

?>
<style>
table {
  font-family: arial, sans-serif;
  font-size:14px;
  border-collapse: collapse;
  width: 100%;
}
td, th { 
border: 1px solid #dddddd; 
  text-align: left;
  padding: 2px;
}
</style>
<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid;">

<h2><center><b>Job Confirmation/Promotion/Evaluation/Annual Evaluation/Increment</b></center></h2><br>

<table width="100%" border="0">
  <tr>
    <td>Date: <?=date("d-M-Y"); ?></td>
<td><div align="right">Confirmation Date: <?=date_format(date_create($pbi_basic->PBI_DUE_DOJ),"d-M-Y");?>
    </div></td>
  </tr>
</table>
<br>

<table width="60%" border="1">
  <tr>
    <td width="4%">1</td>
    <td width="29%">Name:</td>
    <td width="18%"><?=$pbi_basic->PBI_NAME; ?></td>
    <td width="23%">Code:</td>
    <td width="26%"><?=$pbi_basic->PBI_ID; ?></td>
    </tr>
  <tr>
    <td>2</td>
    <td>Father's Name: </td>
    <td colspan="3"><?=$pbi_basic->PBI_FATHER_NAME; ?></td>
    </tr>
  <tr>
    <td>3</td>
    <td>Educational Qualification: </td>
    <td colspan="3"><?=$pbi_basic->PBI_EDU_QUALIFICATION; ?></td>
    </tr>
  <tr>
    <td>4</td>
    <td>Joining Designation: </td>
    <td><?=$designation; ?></td>
    <td>Existing Designation: </td>
    <td><?=$designation; ?></td>
    </tr>
  <tr>
    <td>5</td>
    <td>Company:</td>
    <td><?=$company; ?></td>
    <td>Department</td>
    <td><?=$department; ?></td>
    </tr>
  <tr>
    <td>6</td>
    <td>Joining Date: </td>
    <td><?=$pbi_basic->PBI_DOJ; ?></td>
    <td>Job Location: </td>
    <td><?=$location; ?></td>
    </tr>
  <tr>
    <td>7</td>
    <td colspan="4">Joining Information: a) Probationer/Permanent/Contractual          b) Duration (For Contractual):</td>
    </tr>
  <tr>
    <td rowspan="4">8</td>
    <td rowspan="4">Present Salary Status </td>
    <td>Salary:</td>
    <td>BDT  
      <?=$pbi_salary->basic_salary; ?></td>
    <td rowspan="4">Last Increment Date: </td>
    </tr>
  <tr>
    <td>TA/DA:</td>
    <td>BDT 
      <?=$pbi_salary->ta; ?></td>
    </tr>
  <tr>
    <td>House Rent: </td>
    <td>BDT
      <?=$pbi_salary->house_rent; ?></td>
    </tr>
  <tr>
    <td>Food Allowance: </td>
    <td>BDT
      <?=$pbi_salary->food_allowance; ?></td>
    </tr>
</table>
<b>9. After Confirmation (To be filled by Respective Supervior or Head of Department)</b><br>
<table width="100%" border="1">
  <tr>
    <td width="3%">a</td>
    <td width="97%">Promotion:</td>
    </tr>
  <tr>
    <td>b</td>
    <td>Designation:</td>
    </tr>
  <tr>
    <td>c</td>
    <td>Increment:</td>
    </tr>
</table>
<b>10. Performance (To be filled by Respective Supervior or Head of Department)</b><br>
<table width="100%" border="1">
  <tr>
    <td rowspan="2"><strong>SL</strong></td>
    <td rowspan="2"><strong>Particulars</strong></td>
    <td rowspan="2"><strong>Key Score </strong></td>
    <td><strong>Outstanding</strong></td>
    <td><strong>Very Good</strong></td>
    <td><strong>Good</strong></td>
    <td><strong>Moderate</strong></td>
    <td><strong>Weak</strong></td>
    <td rowspan="2"><strong>Total Score </strong></td>
  </tr>
  <tr>
    <td><div align="center"><strong>5</strong></div></td>
    <td><div align="center"><strong>4</strong></div></td>
    <td><div align="center"><strong>3</strong></div></td>
    <td><div align="center"><strong>2</strong></div></td>
    <td><div align="center"><strong>1</strong></div></td>
    </tr>
  <tr>
    <td>a</td>
    <td>Attitude, Sense of Descipline &amp; Responsibility </td>
    <td><div align="center">5</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>b</td>
    <td>Endeavoring, Industrious, Quick feedback</td>
    <td><div align="center">5</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>c</td>
    <td>Intelligence, Depth of knowledge</td>
    <td><div align="center">5</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>d</td>
    <td>Confidence, Honesty</td>
    <td><div align="center">5</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>e</td>
    <td>Ability to take decision and to make work done by subordinates</td>
    <td><div align="center">5</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>f</td>
    <td>Relationship with Professionals</td>
    <td><div align="center">5</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>g</td>
    <td>Ability to train subordinates</td>
    <td><div align="center">5</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>h</td>
    <td>Mentality to work with superior and colleagues</td>
    <td><div align="center">5</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>i</td>
    <td>Leadership</td>
    <td><div align="center">5</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>j</td>
    <td>Reporting</td>
    <td><div align="center">5</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Total = </strong></td>
    <td><div align="center"><strong>50</strong></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="1">
  <tr>
    <td><p>Comments-Line-Supervisor:</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
  </tr>
</table>
<table width="100%" border="1">
  <tr>
    <td><p>Comments-HRM:  </p>
      <p>&nbsp;</p>
      </td>
  </tr>
</table>


<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<p>1. This form will be used only for Confirmation/Change of Grade/Half Yearly/Auunal Evaluation/Increment.</p>
<p><br>
  2. Grading will be based on obtained score, such as </p>
<table width="60%" border="1">
  <tr>
    <td width="16%">Grade (A) </td>
    <td width="84%">81-100 (%) </td>
  </tr>
  <tr>
    <td>Grade (B)</td>
    <td>71-80 (%) </td>
  </tr>
  <tr>
    <td>Grade (C)</td>
    <td> 61-70(%) </td>
  </tr>
  <tr>
    <td>Grade (D)</td>
    <td>50-60(%) </td>
  </tr>
  <tr>
    <td>Grade (E)</td>
    <td>Below of 49 (%) </td>
  </tr>
</table>
<p>&nbsp;</p>
<p>3. Each grading value are given below:<b>
<table width="60%" border="1">
  <tr>
    <td>Grade (A) </td>
    <td>Outstanding </td>
  </tr>
  <tr>
    <td>Grade (B)</td>
    <td>Above Average </td>
  </tr>
  <tr>
    <td>Grade (C)</td>
    <td>Average </td>
  </tr>
  <tr>
    <td>Grade (D)</td>
    <td>Below Average</td>
  </tr>
  <tr>
    <td>Grade (E)</td>
    <td>Non-performer, (Incase of Non-performer Employee – 	<br>				
Warning to be issued and if not improved within 3 (three) <br>
months, will be Terminated)</td>
  </tr>
</table>

<br>
<p>4. Employee will be evaluated by his or her performance which based on given score<br>
5. Nepotism and Bias attitude must be avoided in the time of preparing evaluation sheet 
<p>&nbsp;</p>
<strong>Note:</strong>
<table width="100%" border="0">
  <tr>
    <td width="16%">Grade (A) </td>
    <td width="84%">Those who are doing better than your expectations.</td>
    </tr>
  <tr>
    <td>Grade (B)</td>
    <td>Those who are doing better than your expectations.</td>
    </tr>
  <tr>
    <td>Grade (C)</td>
    <td>Those who are doing their duty properly.</td>
    </tr>
  <tr>
    <td>Grade (D)</td>
    <td>Can not perform properly, But it is possible to be prepared properly.</td>
    </tr>
  <tr>
    <td>Grade (E)</td>
    <td>Can be dropped now or Can be given 3 months time.</td>
    </tr>
</table>


<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<p>
<table width="100%" border="0">
  <tr>
    <td><div align="center">HRM</div></td>
    <td><div align="center">Line Supervisor/Head of Department </div></td>
    <td><div align="center">Board Of Director</div></td>
  </tr>
</table>
</div>

<? }}
// end 183


// Promotion and Confirmation of Service 
if($_POST['report']==83) {

if    ($_POST['pbi_id_to']=='')  $pbi_con = " and PBI_ID in (".$_POST['pbi_id_fr'].")";
elseif($_POST['pbi_id_fr']!='')  $pbi_con = " and PBI_ID between '".$_POST['pbi_id_fr']."' and '".$_POST['pbi_id_to']."' ";
else " and PBI_ID =0";

$pbi_sql = "select * from personnel_basic_info where 1 ".$pbi_con;
$pbi_query = db_query($pbi_sql);
while($pbi_basic = mysqli_fetch_object($pbi_query)){

$pbi_salary = find_all_field('salary_info','*','PBI_ID="'.$pbi_basic->PBI_ID.'"');
$designation = find_a_field('designation','DESG_DESC','DESG_ID="'.$pbi_basic->DESG_ID.'"');
$department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$pbi_basic->DEPT_ID.'"');
$location = find_a_field('office_location','LOCATION_NAME','ID="'.$pbi_basic->JOB_LOCATION.'"');
$eff_date = find_a_field('promotion_detail','PROMOTION_DATE','1 and PBI_ID="'.$pbi_basic->PBI_ID.'" order by PROMOTION_D_ID desc');
//$old_desi = find_a_field('promotion_detail p, designation d','d.DESG_DESC','1 and p.PBI_ID="'.$pbi_basic->PBI_ID.'" order by d.PROMOTION_D_ID desc');
$old_desi = find1('SELECT d.DESG_DESC FROM  promotion_detail p, designation d 
WHERE  p.PROMOTION_PAST_DESG =d.DESG_ID and p.PBI_ID ="'.$pbi_basic->PBI_ID.'" order by p.PROMOTION_D_ID desc');

?>


<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid;">
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

Date: <?=date("d-M-Y"); ?><br>
Ref	: RCB/HR/Conf/2018/04/<strong><?=$pbi_basic->PBI_ID; ?></strong>
<br><p>&nbsp;</p>
Name: <strong><?=$pbi_basic->PBI_NAME; ?></strong><br>
ID: <?=$pbi_basic->PBI_ID; ?><br>
Designation: <?=$old_desi; ?><br>
Sajeeb Logistics Limited
<br><br>
<strong>Subject	: Promotion and Confirmation of Service</strong>

<br>
<br><strong>Dear <?=$pbi_basic->PBI_NAME; ?></strong>

<br><br>
I am pleased to inform you, based on your satisfactory performance during 
<br>probation period; management has decided to confirm your service along with 
<br>Promotion as <strong><?=$designation; ?></strong>  with effect from <strong><?=$eff_date; ?></strong> . Your monthly gross salary 
<br>has also been revised at <strong>BDT <?=$pbi_salary->basic_salary; ?>. (<?=convertNumberMhafuz($pbi_salary->basic_salary); ?>)</strong>.<br>

<p>&nbsp;</p>
This recognition has been a result of your dedication, sincerity and honesty towards 
<br>the company through your service. 

<p>&nbsp;</p>
I am confident that you will bring the same high level of professionalism and hard 
<br>work to your new role as same you are demonstrating currently. 
 
<p>&nbsp;</p>
Congratulations and best wishes for your continued success and growth in this organization.  
  
<p>&nbsp;</p><p>&nbsp;</p><br>

<table width="100%" border="0">
  <tr>
    <td><strong>Sincerely Yours,</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>----------------------------</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Tareq Ibrahim </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Managing Director </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<? }}
// end 83


// Confirmation of Service and Change of Designation 
if($_POST['report']==84) {

if    ($_POST['pbi_id_to']=='')  $pbi_con = " and PBI_ID in (".$_POST['pbi_id_fr'].")";
elseif($_POST['pbi_id_fr']!='')  $pbi_con = " and PBI_ID between '".$_POST['pbi_id_fr']."' and '".$_POST['pbi_id_to']."' ";
else " and PBI_ID =0";

$pbi_sql = "select * from personnel_basic_info where 1 ".$pbi_con;
$pbi_query = db_query($pbi_sql);
while($pbi_basic = mysqli_fetch_object($pbi_query)){

$pbi_salary = find_all_field('salary_info','*','PBI_ID="'.$pbi_basic->PBI_ID.'"');
$designation = find_a_field('designation','DESG_DESC','DESG_ID="'.$pbi_basic->DESG_ID.'"');
$department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$pbi_basic->DEPT_ID.'"');
$location = find_a_field('office_location','LOCATION_NAME','ID="'.$pbi_basic->JOB_LOCATION.'"');
$eff_date = find_a_field('promotion_detail','PROMOTION_DATE','1 and PBI_ID="'.$pbi_basic->PBI_ID.'" order by PROMOTION_D_ID desc');
//$old_desi = find_a_field('promotion_detail p, designation d','d.DESG_DESC','1 and p.PBI_ID="'.$pbi_basic->PBI_ID.'" order by d.PROMOTION_D_ID desc');
$old_desi = find1('SELECT d.DESG_DESC FROM  promotion_detail p, designation d 
WHERE  p.PROMOTION_PAST_DESG =d.DESG_ID and p.PBI_ID ="'.$pbi_basic->PBI_ID.'" order by p.PROMOTION_D_ID desc');

?>


<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid;">
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

Date: <?=date("d-M-Y"); ?><br>
Ref	: RCB/HR/Conf/2018/04/<strong><?=$pbi_basic->PBI_ID; ?></strong>
<br><p>&nbsp;</p>
Name: <strong><?=$pbi_basic->PBI_NAME; ?></strong><br>
ID: <?=$pbi_basic->PBI_ID; ?><br>
Designation: <?=$old_desi; ?><br>
Sajeeb Logistics Limited
<br><br>
<strong>Subject	: Confirmation of Service and Change of Designation</strong>

<br>
<br><strong>Dear <?=$pbi_basic->PBI_NAME; ?></strong>

<br><br>
I am pleased to inform you, based on your satisfactory performance during 
<br>probation period; management has decided to confirm your service with this 
<br>company along with a change in your designation to <strong><?=$designation; ?></strong> 
<br>with effect from <strong><?=$eff_date; ?></strong>.  

<p>&nbsp;</p>
You are now eligible to avail all other admissible benefits applicable to permanent 
<br>employees as per policies. 
 
<p>&nbsp;</p>
I hope, this endorsement shall motivate you more to do the best in your service.  
  
<p>&nbsp;</p><p>&nbsp;</p><br>

<table width="100%" border="0">
  <tr>
    <td><strong>Sincerely Yours,</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>----------------------------</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Tareq Ibrahim </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Managing Director </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<? }}
// end 84


// Change of Designation 
if($_POST['report']==85) {

if    ($_POST['pbi_id_to']=='')  $pbi_con = " and PBI_ID in (".$_POST['pbi_id_fr'].")";
elseif($_POST['pbi_id_fr']!='')  $pbi_con = " and PBI_ID between '".$_POST['pbi_id_fr']."' and '".$_POST['pbi_id_to']."' ";
else " and PBI_ID =0";

$pbi_sql = "select * from personnel_basic_info where 1 ".$pbi_con;
$pbi_query = db_query($pbi_sql);
while($pbi_basic = mysqli_fetch_object($pbi_query)){

$pbi_salary = find_all_field('salary_info','*','PBI_ID="'.$pbi_basic->PBI_ID.'"');
$designation = find_a_field('designation','DESG_DESC','DESG_ID="'.$pbi_basic->DESG_ID.'"');
$department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$pbi_basic->DEPT_ID.'"');
$location = find_a_field('office_location','LOCATION_NAME','ID="'.$pbi_basic->JOB_LOCATION.'"');
$eff_date = find_a_field('promotion_detail','PROMOTION_DATE','1 and PBI_ID="'.$pbi_basic->PBI_ID.'" order by PROMOTION_D_ID desc');
//$old_desi = find_a_field('promotion_detail p, designation d','d.DESG_DESC','1 and p.PBI_ID="'.$pbi_basic->PBI_ID.'" order by d.PROMOTION_D_ID desc');
$old_desi = find1('SELECT d.DESG_DESC FROM  promotion_detail p, designation d 
WHERE  p.PROMOTION_PAST_DESG =d.DESG_ID and p.PBI_ID ="'.$pbi_basic->PBI_ID.'" order by p.PROMOTION_D_ID desc');

?>


<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid;">
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

Date: <?=date("d-M-Y"); ?><br>
Ref	: RCB/HR/Conf/2018/04/<strong><?=$pbi_basic->PBI_ID; ?></strong>
<br><p>&nbsp;</p>
Name: <strong><?=$pbi_basic->PBI_NAME; ?></strong><br>
ID: <?=$pbi_basic->PBI_ID; ?><br>
Designation: <?=$old_desi; ?><br>
Sajeeb Logistics Limited
<br><br>
<strong>Subject	: Change of Designation</strong>

<br>
<br><strong>Dear <?=$pbi_basic->PBI_NAME; ?></strong>

<br><br>
With the greater interest of company operational requirement, management has 
<br>decided to change your current designation from <?=$old_desi; ?>, 
<br> to <strong><?=$designation; ?></strong> with effect from <strong><?=$eff_date; ?></strong>. 
<br>You will be given specific Job Responsibility along with this letter.

<p>&nbsp;</p>
I am confident that you will bring the same high level of professionalism and hard 
<br>work to your new role as same you are demonstrating currently. 
 
<p>&nbsp;</p>
All the very best for your new role. 
  
<p>&nbsp;</p><p>&nbsp;</p><br>

<table width="100%" border="0">
  <tr>
    <td><strong>Sincerely Yours,</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>----------------------------</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Tareq Ibrahim </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Managing Director </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<? }}
// end 85






elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?>

</div></div>

</form>
</body>
</html>