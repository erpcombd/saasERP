<?php 



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
    require "../include/custom.php";
   date_default_timezone_set('Asia/Dhaka');

$title="<center class=''><h2>".$_SESSION['company_name']."</h2></center>";

if($_POST['report']==404){
     $company = $_POST['org'];

?>
   
        
        
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
  <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Organization Report</title>
	<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Organization Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
 	<?
 	
 	

	



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>
 
  	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">
  <thead>
    <tr>
      <th scope="col"style="text-align:center">S/L</th>
      <th scope="col"style="text-align:center">Organization Name</th>
      <th scope="col"style="text-align:center">Address</th>
	  <th scope="col"style="text-align:center">Zip</th>
	  <th scope="col"style="text-align:center">Country</th>
      <th scope="col"style="text-align:center">Total Employee</th>
	   <th scope="col"style="text-align:center">Anual Revenue</th>
	   <th scope="col"style="text-align:center">Contact Person </th>
	   <th scope="col"style="text-align:center">Contact Number </th>
	   <th scope="col"style="text-align:center">Website</th>
	    <th scope="col"style="text-align:center">Discription</th>
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
    $sql='select * from crm_project_org where 1  '.$con.'';
  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->name?></td>
      <td><?=$data->address?> <?=$data->city?><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
	  <td><?=$data->zip?></td>
	   <td><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
      <td><?=$data->total_employees?></td>
	  <td><?=$data->annual_revenue?></td>
	  <td><?=$data->contact_person?></td>
	  <td><?=$data->contact_number?></td>
	   <td><?=$data->website?></td>
	     <td><?=$data->description?></td>

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}


if($_POST['report']==405){
     $company = $_POST['org'];

?>
   
        
        
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
  <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Sales Last Week Report</title>
	<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Sales last week Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
 	<?
 	
 	

	



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>
 
  	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">
  <thead>
    <tr>
      <th scope="col"style="text-align:center">S/L</th>
      <th scope="col"style="text-align:center">Sales/Deal Owner</th>
      <th scope="col"style="text-align:center">Client Name</th>
	  <th scope="col"style="text-align:center">Sales/Deal Name</th>
	  <th scope="col"style="text-align:center">Amount</th>
      <th scope="col"style="text-align:center">DO Number</th>
	   <th scope="col"style="text-align:center">Client Site</th>
	   <th scope="col"style="text-align:center">First Name </th>
	   <th scope="col"style="text-align:center">Last Name </th>
	   
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
    $sql='select * from crm_project_org where 1  '.$con.'';
  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->name?></td>
      <td><?=$data->address?> <?=$data->city?><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
	  <td><?=$data->zip?></td>
	   <td><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
      <td><?=$data->total_employees?></td>
	  <td><?=$data->annual_revenue?></td>
	  <td><?=$data->contact_person?></td>
	  <td><?=$data->contact_number?></td>
	   

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}




if($_POST['report']==406){
     $company = $_POST['org'];

?>
   
        
        
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
  <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Sales Last Week Report</title>
	<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Sales last week Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
 	<?
 	
 	

	



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>
 
  	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">
  <thead>
    <tr>
      <th scope="col"style="text-align:center">S/L</th>
      <th scope="col"style="text-align:center">Call Owner</th>
      <th scope="col"style="text-align:center">Call Start Time</th>
	  <th scope="col"style="text-align:center">Call Type</th>
	  <th scope="col"style="text-align:center">Client Name</th>
      <th scope="col"style="text-align:center">First Name</th>
	   <th scope="col"style="text-align:center">Last Name</th>
	   <th scope="col"style="text-align:center">Prospective Status </th>
	   <th scope="col"style="text-align:center">Call Duration </th>
	    <th scope="col"style="text-align:center">Description </th>
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
    $sql='select * from crm_project_org where 1  '.$con.'';
  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->name?></td>
      <td><?=$data->address?> <?=$data->city?><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
	  <td><?=$data->zip?></td>
	   <td><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
      <td><?=$data->total_employees?></td>
	  <td><?=$data->annual_revenue?></td>
	  <td><?=$data->contact_person?></td>
	  <td><?=$data->contact_number?></td>
	    <td><?=$data->contact_number?></td>

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}









if($_POST['report']==407){
     $company = $_POST['org'];

?>
   
        
        
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
  <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Sales Lost Last Month Report</title>
	<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" > Sales Lost Last Month Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
 	<?
 	
 	

	



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>
 
  	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">
  <thead>
    <tr>
     
      <th scope="col"style="text-align:center">S/L</th>
      <th scope="col"style="text-align:center">Sales/Deal Owner</th>
      <th scope="col"style="text-align:center">Client Name</th>
	  <th scope="col"style="text-align:center">Sales/Deal Name</th>
	  <th scope="col"style="text-align:center">Amount</th>
      <th scope="col"style="text-align:center">Project Name</th>
	   <th scope="col"style="text-align:center">Disrict</th>
	   <th scope="col"style="text-align:center">Stage </th>
	   
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
    $sql='select * from crm_project_org where 1  '.$con.'';
  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->name?></td>
      <td><?=$data->address?> <?=$data->city?><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
	  <td><?=$data->zip?></td>
	   <td><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
      <td><?=$data->total_employees?></td>
	  <td><?=$data->annual_revenue?></td>
	  <td><?=$data->contact_person?></td>
	  

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}













if($_POST['report']==408){
     $company = $_POST['org'];

?>
   
        
        
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
  <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Completed Sales Monthly Report</title>
	<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Completed Sales Monthly Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
 	<?
 	
 	

	



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>
 
  	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">
  <thead>
    <tr>
     
      <th scope="col"style="text-align:center">S/L</th>
      <th scope="col"style="text-align:center">Sales/Deal Owner</th>
      <th scope="col"style="text-align:center">Client Name</th>
	  <th scope="col"style="text-align:center">Amount</th>
	  <th scope="col"style="text-align:center">DO Number</th>
      <th scope="col"style="text-align:center">Division</th>
	   
	   
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
    $sql='select * from crm_project_org where 1  '.$con.'';
  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->name?></td>
      <td><?=$data->address?> <?=$data->city?><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
	  <td><?=$data->zip?></td>
	   <td><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
      <td><?=$data->total_employees?></td>
	 
	  

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}















if($_POST['report']==409){
     $company = $_POST['org'];

?>
   
        
        
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
  <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Today's Meetings / Visits Report</title>
	<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Today's Meetings / Visits Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
 	<?
 	
 	

	



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>
 
  	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">
  <thead>
    <tr>
     
  <th scope="col"style="text-align:center">S/L</th>
      <th scope="col"style="text-align:center">Created By</th>
      <th scope="col"style="text-align:center">From</th>
	  <th scope="col"style="text-align:center">Title</th>
	  <th scope="col"style="text-align:center">To</th>
      <th scope="col"style="text-align:center">Locationr</th>
	   <th scope="col"style="text-align:center">Client Name</th>
	   <th scope="col"style="text-align:center">Contact Name </th>
	   <th scope="col"style="text-align:center">Designation </th>
	    <th scope="col"style="text-align:center">Description </th>
	   
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
    $sql='select * from crm_project_org where 1  '.$con.'';
  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->name?></td>
      <td><?=$data->address?> <?=$data->city?><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
	  <td><?=$data->zip?></td>
	   <td><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
      <td><?=$data->total_employees?></td>
	  <td><?=$data->annual_revenue?></td>
	  <td><?=$data->contact_person?></td>
	  <td><?=$data->contact_number?></td>
	  	  <td><?=$data->contact_number?></td>

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}








if($_POST['report']==410){
     $company = $_POST['org'];

?>
   
        
        
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
  <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Open Sales Deals(No Activity) Report</title>
	<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Open Sales Deals(No Activity) Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
 	<?
 	
 	

	



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>
 
  	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">
  <thead>
    <tr>
      <th scope="col"style="text-align:center">S/L</th>
      <th scope="col"style="text-align:center">Sales/Deal Owner</th>
      <th scope="col"style="text-align:center">Last Activity Time</th>
	  <th scope="col"style="text-align:center">Client Name</th>
	  <th scope="col"style="text-align:center">Sales/Deal Name</th>
      <th scope="col"style="text-align:center">Stage</th>
	   <th scope="col"style="text-align:center">Amount</th>
	   <th scope="col"style="text-align:center">District</th>
	  
	   
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
    $sql='select * from crm_project_org where 1  '.$con.'';
  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->name?></td>
      <td><?=$data->address?> <?=$data->city?><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
	  <td><?=$data->zip?></td>
	   <td><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
      <td><?=$data->total_employees?></td>
	  <td><?=$data->annual_revenue?></td>
	  <td><?=$data->contact_person?></td>
	
	   

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}











if($_POST['report']==411){
     $company = $_POST['org'];

?>
   
        
        
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
  <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >NO CONTACT 15 DAYS Report</title>
	<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >NO CONTACT 15 DAYS Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
 	<?
 	
 	

	



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>
 
  	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">
  <thead>
    <tr>
      <th scope="col"style="text-align:center">S/L</th>
      <th scope="col"style="text-align:center">Client Owner</th>
      <th scope="col"style="text-align:center">Last Activity Time</th>
	  <th scope="col"style="text-align:center">Client Name</th>
	  <th scope="col"style="text-align:center">First Name</th>
      <th scope="col"style="text-align:center">Last Name</th>
	   <th scope="col"style="text-align:center">Rating</th>
	  
	  
	   
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
    $sql='select * from crm_project_org where 1  '.$con.'';
  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->name?></td>
      <td><?=$data->address?> <?=$data->city?><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
	  <td><?=$data->zip?></td>
	   <td><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
      <td><?=$data->total_employees?></td>
	  <td><?=$data->annual_revenue?></td>
	 
	
	   

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

} if($_POST['report']==505){ ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title>Organization Report</title>
		<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
	
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD </h3></center>
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;">Lead Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>

 	<?

	



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>
 
  	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">
  <thead>
    <tr>
      <th scope="col">S/L</th>
      <th scope="col">Lead Name</th>
      <th scope="col">Lead Status</th>
      <th scope="col">Lead Owner</th>
      <th scope="col">Lead Primary Contact</th>
      <th scope="col">Call</th>
      <th scope="col">Visit</th>
      <th scope="col">Meeting</th>
      <th scope="col">Module Name</th>
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and organization="'.$_POST['org'].'"';
  }
	 if($_POST['leadstatus']!=''){
  $con=' and l.status="'.$_POST['leadstatus'].'"';
  }
  
  if($_POST['assignperson']!=''){
  $con_assign=' and l.assign_person="'.$_POST['assignperson'].'"';
  }
  
   if($_POST['lead']!=''){
  $con_lead=' and l.id="'.$_POST['lead'].'"';
  }
    $sql='select l.*,o.name from crm_project_lead l,crm_project_org o where l.organization=o.id   '.$con.$con_assign.$con_lead.'';
  $query=db_query($sql);
  $i=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$i++?></th>
      <td><?=$data->name."".$data->products?></td>
      <td><?=find_a_field('crm_lead_status','status','id="'.$data->status.'"')?></td>
      <td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->assign_person.'"');?></td>
	  <td><?=find_a_field('crm_lead_contacts','concat(contact_name,"- ",contact_phone)','id="'.$data->id.'"')?></td>
    <td><?=find_a_field('crm_lead_activity','count(lead_id)','lead_id="'.$data->id.'" and activity_type="Call"')?></td>
    <td><?=find_a_field('crm_lead_activity','count(lead_id)','lead_id="'.$data->id.'" and activity_type="Visit"')?></td>
    <td><?=find_a_field('crm_lead_activity','count(lead_id)','lead_id="'.$data->id.'" and activity_type="Meeting"')?></td>
    <td><?php 
    $sql2='select * from crm_lead_product_individual where lead_id="'.$data->id.'"';
    $query_db=db_query($sql2);
    while($data2=mysqli_fetch_object($query_db))
    {
    
    echo find_a_field('crm_lead_products','products','id='.$data2->product_id).", <br>"; } ?></td>
    

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>




<?php

} if($_POST['report']==420){ ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title>Organization Report</title>
		<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
	
  </head>
  <body>

<?=$title?>

<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;">Task Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">
 Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>

 	<?

	



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>
 
  	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">
  <thead>
    <tr>
      <th scope="col">S/L</th>
      <th scope="col">Task Name</th>
      <th scope="col">Company Name</th>
      <th scope="col">Task Details</th>
      <th scope="col">Assign Person</th>
      <th scope="col">Task Date</th>
      <th scope="col">Deadline Date</th>
      <th scope="col">Status</th>
      <th scope="col">Feedback</th>
    </tr>
  </thead>
  <tbody>
  
  <?php
  
   if (isset($_POST['assign_person']) && is_array($_POST['assign_person'])) {
                                 $person_ids = $_POST['assign_person'];
								 $ffffff = implode(",", $person_ids);
									} else {
									
										$ffffff = ''; 
										
									}
									
  if($_POST['assign_person']>0) $personCon = " and  FIND_IN_SET('$ffffff', assign_person)";									
  
  if($_POST['org']!=''){ $con=' and project_id="'.$_POST['org'].'"';}
  if($_POST['leadstatus']!=''){ $con=' and status="'.$_POST['leadstatus'].'"';}


  if($_POST['time_from']>0) $dateConn = " and date between '".$_POST['time_from']."' and '".$_POST['time_to']."'";
    
	/*$sql='select l.*,o.name from crm_project_lead l,crm_project_org o 
	where l.organization=o.id   '.$con.$con_assign.$con_lead.'';
    $query=db_query($sql);*/
	
	 $sql = 'SELECT * FROM crm_lead_activity a 
	WHERE mode ="postsale"  '.$dateConn.$con.$statusConn.$personCon.'
	ORDER BY `date` DESC;';
	$query=db_query($sql);
	
	
  $i=1;
  while($row=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$i++?></th>
      <td><?=$row->subject;?></td>
      <td><?=find_a_field('crm_project_org', 'name', 'id = "'.$row->project_id.'"')?></td>
      <td> <?=$row->details;?></td>
	  
	    
		  
		  <td>
  <?php
  $ids = explode(',', $row->assign_person);
  foreach ($ids as $id) { ?>
    <span class="badge bg-blue-dark color-white font-10 mt-2">
      <?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "' . $id . '"') ?>
    </span><br> <!-- Adding a line break after each badge -->
  <?php } ?>
</td>


		  
    <td><?=$row->date;?></td>
    <td><?=$row->deadline;?></td>
    <td>
          <? if($row->status =='2'){ ?>
          <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
          <? }elseif($row->status =='1'){ ?>
          <span class="badge bg-highlight color-white font-10 mt-2">PENDING</span>
          <? }else{ ?>
          <span class="badge bg-blue-dark color-white font-10 mt-2">CANCELLED</span>
          <?  } ?>
		  
		  </td>
   <td>
  <!-- Feedback Section -->
  <?php  
    // Fetch feedback for the current activity
    $activity_id = $row->activity_id;
    $sqlFeedback = "SELECT * FROM crm_lead_activity_feedback WHERE activity_id = $activity_id ORDER BY id DESC";
    $resultFeedback = db_query($sqlFeedback);
    
    while ($feedbackRow = mysqli_fetch_object($resultFeedback)) { ?>
    
    <div style="margin-bottom: 10px; display: flex;">
      <div style="width: 100%;">
        <!-- Username display with bold font and color -->
        <span style="font-size: 11px; padding-left: 5px; font-weight: bold; color: #007bff;">
          <?= find_a_field('user_activity_management', 'fname', 'user_id="'.$feedbackRow->entry_by.'"'); ?>
        </span>
        
        <!-- Feedback content container with padding, border, and light background -->
        <div style="background-color: #f8f9fa; padding: 10px; border-radius: 8px; border: 1px solid #ccc; margin-top: 5px;">
          <p style="line-height: 1.5; margin: 0; color: #333;">
            <?= nl2br($feedbackRow->feedback); ?>  <!-- Keeps original line breaks -->
          </p>
        </div>
      </div>
    </div>
    
  <?php } ?>
  <!-- End of Feedback Display -->
</td>


    

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>





<?php

}
if($_POST['report']==606 ){ ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
     <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />
    <title>Lead Log Report</title>
		<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
	
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD </h3></center>
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;">Lead Log Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
<center><h4><?=find_a_field('crm_project_org o,crm_project_lead l,crm_lead_log a,crm_lead_products p','concat(o.name,"##(",p.products,")")','l.organization=o.id and l.product=p.id and l.id="'.$_POST['lead'].'"')?></h4></center><br><br>
 
  <table class="table table-bordered" id="ExportTable">
  <thead>
    <tr>
      <th scope="col">S/L</th>
          <th scope="col"style="text-align:center">Organization Name</th>
      <th scope="col"style="text-align:center">Address</th>
      <th scope="col"style="text-align:center">Activity Type</th>
      <th scope="col"style="text-align:center">Date</th>
      <th scope="col"style="text-align:center">Details</th>
    </tr>
  </thead>
  <tbody>
  
  <?php
  
 
  if($_POST['lead']!= ''){
  $con=' and l.lead_id="'.$_POST['lead'].'"';
  
 }
  $sql='select l.*,s.status,a.lead_name, a.organization from crm_lead_log l,crm_lead_status s , crm_project_lead a
  where l.status=s.id and l.id=a.id '.$con.' order by id ASC';
  
  $query=db_query($sql);
  $i=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$i++?></th>
      <td><?=$data->lead_name?></td>
      <td><?=find_a_field('crm_project_org','address','id="'.$data->organization.'"')?></td>
	  <td><?=$data->status?></td>
	  <td><?=date("d-m-Y H:i A",strtotime($data->entry_at))?></td>
	  <td><?=$data->note?></td>
    

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

} if($_POST['report']==707){ ?>

  <!doctype html>
  <html lang="en">
    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
  
      <title>Activity Report</title>
      <script language="javascript">
  function hide()
  {
  document.getElementById('pr').style.display='none';
  }
  </script>
  
  
    <?
   // require_once "../../../controllers/core/inc.exporttable.php";
    ?>
    
    </head>
    <body>
  
  <center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD</h3></center>
  <?=$title?>
  <center class="mb-4"><h3 style="text-align:center; line-height:5px; padding-top:5px;">Lead Activity Report</h3></center>
   <h6 style="text-align:center; line-height:10px">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
    <table class="table table-bordered" id="ExportTable">
    <thead>
      <tr>
        <th scope="col">S/L</th>
        <th scope="col">Lead Name</th>
        <th scope="col">Lead Status</th>
        <th scope="col">Lead Owner</th>
       
		<th scope="col">Activity Date</th>
        <th scope="col">Activity Type</th>
        
      </tr>
    </thead>
    <tbody>
    
    <?php
    if($_POST['org']!=''){
    $con=' and organization="'.$_POST['org'].'"';
    }
	if($_POST['time_from']!='' || $_POST['time_to']!='')
		{
		
		$con=' and a.date between "'.$_POST['time_from'].'" and "'.$_POST['time_to'].'"';
		
		}
		if($_POST['leadstatus']!='')
		{
			$con=' and l.status="'.$_POST['leadstatus'].'"';
		
		}
		
		if($_POST['assignperson']!='')
		{
			$con=' and l.assign_person="'.$_POST['assignperson'].'"';
		
		}
		if($_POST['activity_type']!='')
		{
			$con=' and a.activity_type="'.$_POST['activity_type'].'"';
		
		}
  
      $sql='select l.*,a.*,l.status,a.activity_type
	 
	 from crm_project_lead l,crm_lead_activity a 
	 
	 where a.lead_id=l.id  '.$con.'';
    $query=db_query($sql);
    $i=1;
    while($data=mysqli_fetch_object($query)){
    ?>
      <tr>
        <th scope="row"><?=$i++?></th>
        <td><?=$data->lead_name?></td>
        <td><?=find_a_field('crm_lead_status','status','id='.$data->status);?></td>
        <td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->assign_person.'"');?></td>
      
	  <td><?=$data->date;?></td>
      <td><?=$data->activity_type;?></td>
      
      
  
      </tr>
  <? }?>
    </tbody>
  </table>
  
    </body>
  </html>
  <?php
  
  } ?>