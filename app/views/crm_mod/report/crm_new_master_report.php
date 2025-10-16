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
    // $sql2 = "SELECT count(id) AS Meeting, name
    //         FROM crm_project_org a
    //         LEFT JOIN crm_project_lead b ON b.organization = a.id
    //         LEFT JOIN crm_lead_activity c ON c.lead_id = b.id
    //         WHERE activity_type = 'Meeting '.$con"

    
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

} 
 

if($_POST['report']==420){ ?>

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
      <th scope="col">Entry At</th>
      <th scope="col">Entry By</th>
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
  
  if($_POST['time_start']>0) $entryConn = " and DATE(entry_at) between '".$_POST['time_start']."' and '".$_POST['time_end']."'";
    
	/*$sql='select l.*,o.name from crm_project_lead l,crm_project_org o 
	where l.organization=o.id   '.$con.$con_assign.$con_lead.'';
    $query=db_query($sql);*/
	
	 $sql = 'SELECT * FROM crm_lead_activity a 
	WHERE mode ="postsale"  '.$dateConn.$con.$statusConn.$personCon.$entryConn.'
	ORDER BY `date` DESC;';
	$query=db_query($sql);
	
	
  $i=1;
  while($row=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$i++?></th>
      <td><?=$row->subject;?></td>
      <td><?=find_a_field('crm_project_org', 'name', 'id = "'.$row->project_id.'"')?></td>
      <td> <?=$row->note;?></td>
	  
	    
		  
		  <td>
  <?php
  $ids = explode(',', $row->assign_person);
  foreach ($ids as $id) { ?>
    <span class="badge bg-blue-dark color-white font-10 mt-2">
      <?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "' . $id . '"') ?>
    </span><br> <!-- Adding a line break after each badge -->
  <?php } ?>
</td>
        <td> <?=$row->entry_at;?></td>
         <td><?=find_a_field('user_activity_management', 'fname', 'username = "'.$row->entry_by.'"')?></td>

		  
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




<!--Meeting Report-->


<?php

} if($_POST['report']==421){ ?>

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

<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;">Meeting Report</h3></center>
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
      <th scope="col">Meeting Subject</th>
      <th scope="col">Company Name</th>
      <th scope="col">Meeting Details</th>
	  <th scope="col">Note</th>
      <th scope="col">Assign Person</th>
      <th scope="col">Entry At</th>
      <th scope="col">Entry By</th>
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
  
  if($_POST['time_start']>0) $entryConn = " and DATE(entry_at) between '".$_POST['time_start']."' and '".$_POST['time_end']."'";
    
	/*$sql='select l.*,o.name from crm_project_lead l,crm_project_org o 
	where l.organization=o.id   '.$con.$con_assign.$con_lead.'';
    $query=db_query($sql);*/
	
	 $sql = 'SELECT * FROM crm_lead_activity a 
	WHERE activity_type="Meeting" and  mode ="postsale"  '.$dateConn.$con.$statusConn.$personCon.$entryConn.'
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
	   <td> <? //=$row->note;?>
	   	<?php
	$text_meeting_note = $row->note;
	// Insert line breaks before any number (using regex)
	$text_with_meeting_note = preg_replace('/(\d+)/', '<br>$1', $text_meeting_note);
	
	// Output the result
	echo $text_with_meeting_note;
	?>
	   </td>
	  
	    
		  
		  <td>
  <?php
  $ids = explode(',', $row->assign_person);
  foreach ($ids as $id) { ?>
    <span class="badge bg-blue-dark color-white font-10 mt-2">
      <?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "' . $id . '"') ?>
    </span><br> <!-- Adding a line break after each badge -->
  <?php } ?>
</td>
        <td> <?=$row->entry_at;?></td>
         <td><?=find_a_field('user_activity_management', 'fname', 'username = "'.$row->entry_by.'"')?></td>

		  
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

} 



if($_POST['report']==707){ ?>

  <!doctype html>
  <html lang="en">
    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
  
      <title>Renponse Time Report (Lead to Contact)</title>
      <script language="javascript">
      function hide() {
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
      <center class="mb-4"><h3 style="text-align:center; line-height:5px; padding-top:5px;">Renponse Time Report (Lead to Contact)</h3></center>
      <h6 style="text-align:center; line-height:10px">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
      <table class="table table-bordered" id="ExportTable">
        <thead>
          <tr>
            <th scope="col" style="text-align:center">S/L</th>
            <th scope="col" style="text-align:center">Lead Name</th>
            <th scope="col" style="text-align:center">Assigned Representative</th>
            <th scope="col" style="text-align:center">Date Created</th>
            <th scope="col" style="text-align:center">First Contacted</th>
            <th scope="col" style="text-align:center">Response Time (Hours)</th>
            <th scope="col" style="text-align:center">Lead Status</th>
          </tr>
        </thead>

        <tbody>
          <?php
            if($_POST['org']!='') {
              $con=' and organization="'.$_POST['org'].'"';
            }
	          if($_POST['time_from']!='' || $_POST['time_to']!='') {
		          $con=' and a.date between "'.$_POST['time_from'].'" and "'.$_POST['time_to'].'"';
            }
		        if($_POST['leadstatus']!='') {
			        $con=' and l.status="'.$_POST['leadstatus'].'"';
            }
		        if($_POST['assignperson']!='') {
			        $con=' and l.assign_person="'.$_POST['assignperson'].'"';
            }
		        if($_POST['activity_type']!='') {
			        $con=' and a.activity_type="'.$_POST['activity_type'].'"';
            }
  
            // $sql='select l.*,a.*,l.status,a.activity_type
	          //     from crm_project_lead l,crm_lead_activity a 
	          //     where a.lead_id=l.id  '.$con.'';
            $sql = "SELECT l.*, a.*, l.status, a.activity_type, m.fname AS assigned_representative
                FROM crm_project_lead l
                LEFT JOIN crm_lead_activity a ON a.lead_id = l.id
                LEFT JOIN user_activity_management m ON m.user_id = l.entry_by
                WHERE 1 $con";


            $query=db_query($sql);
            $i=1;
            while($data=mysqli_fetch_object($query)){
            ?>
        <tr>
          <th scope="row"><?=$i++?></th>
          <td><?=$data->lead_name?></td>
          <td><?=$data->assigned_representative?></td>
          <td><?=$data->date;?></td>
          <td><?=$data->first_contacted?? ''?></td>
          <td><?=$data->response_time?? ''?></td>
          <td><?=find_a_field('crm_lead_status','status','id='.$data->status);?></td> <!-- query for status column -->
        </tr>
        <? }?>
        </tbody>
  </table>
    </body>
  </html>
  <?php
  
  }


// Field Visit Log (Custom Report or Activity Report) (1)

if($_POST['report']==409){
     $company = $_POST['org'];

?>

<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Field Visit Log (Custom Report or Activity Timeline)</title>
	  <script language="javascript">
      function hide() {
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
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Field Visit Log (Custom Report or Activity Timeline)</h3></center>
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
      <th scope="col"style="text-align:center; min-width: 65px;">Date</th>
      <th scope="col"style="text-align:center">Sales Representative</th>
      <th scope="col"style="text-align:center; min-width: 90px;">Company Name</th>
      <th scope="col"style="text-align:center; min-width: 150px;">Address</th>
      <th scope="col"style="text-align:center">Purpose of Visit</th>
      <th scope="col"style="text-align:center">Meeting Outcome</th>
      <th scope="col"style="text-align:center; min-width: 165px;">Next Step</th>
      <th scope="col"style="text-align:center; min-width: 65px;">Follow-up date</th>
      
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
  
    $sql = "SELECT o.*, a.note AS meeting_outcome, a.subject AS purpose_of_visit, u.fname AS sales_representative
            FROM crm_project_org o
            LEFT JOIN crm_lead_activity a ON a.project_id = o.id
            LEFT JOIN user_activity_management u ON o.assigned_person_id = u.user_id
            WHERE 1 $con";

  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=date("d-m-Y", strtotime($data->entry_at))?></td>
      <td><?=$data->sales_representative ?> </td> 
      <td><?=$data->name?></td>

      <!-- <td><?=$data->zip?></td>
      <td><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td> -->

      <td><?=$data->address?> <?=$data->city?><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
      <td><?=$data->purpose_of_visit?></td>
      <td><?=$data->meeting_outcome?></td>      
      <td><?=$data->next_step ?? ''?></td>
      <td><?=$data->follow_up_dates ?? ''?></td>

      <!-- <td><?=$data->contact_person?></td>
      <td><?=$data->contact_number?></td>
      <td><?=$data->total_employees?></td>
      <td><?=$data->contact_number?></td> -->
      
      
    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}




// Lead Report (Contacts Report with Lifecycle Stage & Lead Source) (2)

if($_POST['report']==505) { 
  ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title>Lead Report (Contacts Report with Lifecycle Stage & Lead Source)</title>
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
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;">Lead Report (Contacts Report with Lifecycle Stage & Lead Source)</h3></center>
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
      <th scope="col">Company Name</th>
      <th scope="col">Source</th>
      <th scope="col">Lifecycle Stage</th>
      <th scope="col">Owner</th>
      <th scope="col">Lead Status</th>
      <th scope="col">Last Contact Date</th>
      <th scope="col">Notes</th>
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
      <td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->assign_person.'"');?></td>
      <td><?=$data->name."".$data->products?></td>
      <td><?=$data->lead_name?? ''?></td>
      <td><?=$data->source?? ''?></td>
      <td><?=$data->lifecycle_stage?? ''?></td>
      <td><?=find_a_field('crm_lead_status','status','id="'.$data->status.'"')?></td>
      <td><?=$data->last_contact_date?? ''?></td>
      <td><?=$data->notes?? ''?></td>  
    

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>

<?php

}



//Sales Report (Deal Pipeline Report) (3)

if($_POST['report']==811){
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

    <title >Sales Report (Deal Pipeline Report)</title>
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
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Sales Report (Deal Pipeline Report)</h3></center>
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
      <th scope="col"style="text-align:center">Company Name</th>
	    <th scope="col"style="text-align:center">Lead Name</th>
	    <th scope="col"style="text-align:center">Amount (BDT)</th>
      <th scope="col"style="text-align:center">Status</th>
	    <th scope="col"style="text-align:center">Owner</th>
	    <th scope="col"style="text-align:center">Close Date </th>
	    <th scope="col"style="text-align:center">Probability (%) </th>
	   
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
    $sql= 'SELECT o.*, b.lead_value, a.*,b.assign_person, b.lead_name
			FROM crm_project_org o
			LEFT JOIN crm_project_lead b ON b.organization = o.id
			LEFT JOIN crm_lead_activity a ON a.lead_id = b.id
			WHERE 1'. $con.'';

  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->name?></td>
      <td><?=$data->lead_name?></td>
	    <td><?=$data->lead_value?></td>
      <!-- <td><?=find_a_field('crm_lead_status','status','id="'.$data->status.'"')?></td> -->
      <td><?=find_a_field('crm_lead_status', 'status', 'id = "'.$data->status.'"')?></td>
	    <td><?=find_a_field('user_activity_management','fname','user_id="'.$data->assign_person.'" ');?></td>
	    <td><?=$data->close_date?? '' ?> </td>
      <td><?$prob=find_a_field('crm_lead_status', 'probability', 'id = "'.$data->status.'"')?><?= $prob ? $prob.'%' : '' ?></td>
	   
    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}




//Final Sales with Deal Closed Report (4)

if($_POST['report']==24082025){
     $company = $_POST['org'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Final Sales with Deal Closed Report</title>
	  <script language="javascript">
      function hide() {
        document.getElementById('pr').style.display='none';
      }
    </script>

	  <?  //require_once "../../../controllers/core/inc.exporttable.php"; ?>
  </head>

  <body>
    <?=$title?>
    <center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
    <center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Final Sales with Deal Closed Report</h3></center>
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
          <th scope="col"style="text-align:center; min-width: 65px;">Date Closed</th>
          <th scope="col"style="text-align:center">Client Name</th>
          <th scope="col"style="text-align:center; min-width: 90px;">Deal Name</th>
          <th scope="col"style="text-align:center; min-width: 150px;">Product/Service</th>
          <th scope="col"style="text-align:center">Amount(BDT)</th>
          <th scope="col"style="text-align:center">Sales Representative</th>
          <th scope="col"style="text-align:center; min-width: 165px;">Payment Status</th>
          <th scope="col"style="text-align:center; min-width: 165px;">Delivery Status</th>
          <th scope="col"style="text-align:center; min-width: 65px;">Notes</th> 
        </tr>
      </thead>

      <tbody>
        <?php
          if($_POST['org']!=''){
          $con=' and id="'.$_POST['org'].'"';
          }

          $sql = "SELECT org.*, lead.lead_value AS value, activity.subject AS purpose_of_visit, user.fname AS sales_representative
                  FROM crm_project_org org
                  LEFT JOIN crm_lead_activity activity ON activity.project_id = org.id
                  LEFT JOIN user_activity_management user ON org.assigned_person_id = user.user_id
                  LEFT JOIN crm_project_lead lead ON lead.organization = org.id
                  WHERE 1 $con group by lead.id ";
                  $query=db_query($sql);
                  $ia=1;
                  while($data=mysqli_fetch_object($query)){
          ?>
        <tr>
          <th scope="row"><?=$ia++?></th>
          <td><?=date("d-m-Y", strtotime($data->entry_at))?></td>
          <td><?=$data->name?></td>
          <td><?=$data->deal_name ?? '' ?> </td>
          <td><?=$data->product_or_service ?? '' ?> </td>
          <td><?=$data->value ?> </td>
          <td><?=$data->sales_representative ?> </td>
          <td><?=$data->payment_status ?? '' ?></td>     
          <td><?=$data->delivery_status ?? '' ?></td>     
          <td><?=$data->note ?? ''?></td>
        </tr>
        <?  } ?>
      </tbody>
    </table>

  </body>
</html>
<?php

}



//Client Follow-up report (5)

if($_POST['report']==708){ ?>

  <!doctype html>
  <html lang="en">
    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
  
      <title>Client Follow-up report</title>
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
  <center class="mb-4"><h3 style="text-align:center; line-height:5px; padding-top:5px;">Client Follow-up report</h3></center>
   <h6 style="text-align:center; line-height:10px">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
    <table class="table table-bordered" id="ExportTable">
    <thead>
      <tr>
        <th scope="col" style="text-align:center">S/L</th>
        <th scope="col" style="text-align:center">Client Name</th>
        <th scope="col" style="text-align:center">Contact Person</th>
        <th scope="col" style="text-align:center">Last Contact Date</th>
        <th scope="col" style="text-align:center">Next follow-up date</th>
        <th scope="col" style="text-align:center">Assigned Representative</th>
        <th scope="col" style="text-align:center">Priority</th> <!-- Priority Column -->
        <th scope="col" style="text-align:center">Follow-up Date</th>
		    <th scope="col" style="text-align:center">Status</th>
        
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

    $sql = "SELECT o.*, a.*, o.name AS client_name, a.fname AS assigned_representative 
            FROM crm_project_org o
            JOIN user_activity_management a ON o.assigned_person_id = a.user_id
            WHERE 1 $con";
  


    $query=db_query($sql);
    $i=1;
    while($data=mysqli_fetch_object($query)){
    ?>
      
      <tr>
        <th scope="row"><?=$i++?></th>
        <td><?=$data->client_name?></td>
        <td><?=$data->contact_person?? ''?></td>
        <td><?=$data->entry_date?></td>
        <td><?=$data->next_followup_date?? ''?></td>
	      <td><?=$data->assigned_representative?></td>
        <td><?=$data->priority_status?></td> <!-- Data for status column -->
        <td><?=$data->followup_date?></td>
        <td><?=$data->status ?? ''?></td>
      </tr>
  <? }?>
    </tbody>
  </table>
  
    </body>
  </html>
  <?php
  
  }
//Re-Order Sales Report (6)

if($_POST['report']==38082025){ ?>

  <!doctype html>
  <html lang="en">
    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
  
      <title>Re-Order Sales Report</title>
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
  <center class="mb-4"><h3 style="text-align:center; line-height:5px; padding-top:5px;">Re-Order Sales Report</h3></center>
   <h6 style="text-align:center; line-height:10px">Date: <?=$_POST['time_from']?> To <?=$_POST['time_to']?></h6>
    <table class="table table-bordered" id="ExportTable">
    <thead>
      <tr>

        <th scope="col" style="text-align:center">S/L</th>
        <th scope="col" style="text-align:center">Client Name</th>
        <th scope="col" style="text-align:center">Previous Order Date</th>
        <th scope="col" style="text-align:center">Last Product Bought</th>
        <!-- <th scope="col" style="text-align:center">Re-Order Date</th> -->
        <th scope="col" style="text-align:center">New Products Requested</th>
        <th scope="col" style="text-align:center">Amount</th>
        <th scope="col" style="text-align:center">Sales Representative</th>
		    <th scope="col" style="text-align:center">Status</th>
		    <th scope="col" style="text-align:center">Notes</th>
        
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
  
    $sql = "SELECT o.*, a.*, l.*, o.name AS client_name, a.fname AS assigned_representative , l.lead_name, l.lead_value, l.entry_at AS previous_order_date, s.status
            FROM crm_project_org o
            LEFT JOIN user_activity_management a ON o.assigned_person_id = a.user_id
            LEFT JOIN crm_project_lead l ON l.organization = o.id
            LEFT JOIN crm_lead_status s ON l.status = s.id
            WHERE 1 $con 
            GROUP BY o.id 
            ORDER BY o.id DESC";
  


    $query=db_query($sql);
    $i=1;
    while($data=mysqli_fetch_object($query)){
    ?>
      
      <tr>
        <th scope="row"><?=$i++?></th>
        <td><?=$data->client_name?></td>
        <td><?=$data->previous_order_date?></td>
        <!-- <td><?=find_a_field('crm_lead_activity','count(activity_id)','lead_id="'.$data->lead_id.'" and activity_type = "Call" ') ?> </td> -->
        <td><?=find_a_field('crm_project_lead','lead_name','status=9  GROUP BY organization ORDER BY id DESC')?> </td>
        <!-- <td><?=$data->re_order_date?? ''?></td> -->
	      <td><?=$data->lead_name?></td>
	      <td><?=$data->lead_value?></td>
        <td><?=$data->assigned_representative?></td>
        <td><?=$data->status?></td>
        <td><?=$data->note ?? ''?></td>
      </tr>
  <? }?>
    </tbody>
  </table>
  
    </body>
  </html>
  <?php
  
  }



//Additional Sales & Visit Reports (Table-wise Format) (7)

if($_POST['report']==25082025) 
  {
     $company = $_POST['org'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Additional Sales & Visit Reports (Table-wise Format)</title>
	  <script language="javascript">
      function hide() {
        document.getElementById('pr').style.display='none';
      }
    </script>

	  <?  //require_once "../../../controllers/core/inc.exporttable.php"; ?>
  </head>

  <body>
    <?=$title?>
    <center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
    <center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Additional Sales & Visit Reports (Table-wise Format)</h3></center>
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
          <th scope="col"style="text-align:center">Date</th>
          <th scope="col"style="text-align:center; min-width: 65px;">Sales Representative</th>
          <th scope="col"style="text-align:center">Calls Made</th>
          <th scope="col"style="text-align:center; min-width: 90px;">Email Sent</th>
          <th scope="col"style="text-align:center; min-width: 150px;">Meetings Held</th>
          <th scope="col"style="text-align:center">Deals Created</th>
          <th scope="col"style="text-align:center">Follow-up Schedule</th>
          <th scope="col"style="text-align:center">Notes</th>
        </tr>
      </thead>

      <tbody>
        <?php
          if($_POST['org']!=''){
          $con=' and id="'.$_POST['org'].'"';
          }

          $sql = "SELECT count(c.activity_id) AS Meeting, a.name, a.id, b.id as lead_id
                  FROM crm_project_org a 
                  LEFT JOIN crm_project_lead b ON b.organization = a.id 
                  LEFT JOIN crm_lead_activity c ON c.lead_id = b.id 
                  WHERE c.activity_type = 'Meeting' group by a.id $con ";
                  $query=db_query($sql);
                  $ia=1;

                  while($data=mysqli_fetch_object($query)){
          ?>
        <tr>
          <th scope="row"><?=$ia++?></th>  
          <td><?=$data->date ?? '' ?></td> 
          <td><?=$data->name?></td>          
          <td><?=find_a_field('crm_lead_activity','count(activity_id)','lead_id="'.$data->lead_id.'" and activity_type = "Call" ') ?> </td>
          <td><?=find_a_field('crm_lead_activity','count(activity_id)','lead_id="'.$data->lead_id.'" and activity_type = "Email" ') ?> </td>
          <!-- <td><?=$data->email_sent ?></td> -->
          <td><?=$data->Meeting ?></td>
          <td><?=find_a_field('crm_project_lead','count(id)','organization="'.$data->id.'" ') ?> </td> <!---Deals Created--->
          <td><?=$data->follow_up_schedule ?? '' ?> </td>
          <td><?=$data->notes ?? '' ?> </td>
        <?  } ?>
      </tbody> 
    </table>

  </body>
</html>
<?php

}




//Sales Territory Visit Report (8)

if($_POST['report']==830){
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

    <title >Sales Territory Visit Report</title>
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
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Sales Territory Visit Report</h3></center>
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
      <th scope="col"style="text-align:center">Visit Date</th>
      <th scope="col"style="text-align:center">Region</th>
	  <th scope="col"style="text-align:center">Sales Rep</th>
	  <th scope="col"style="text-align:center">Client Visited</th>
      <th scope="col"style="text-align:center">Meeting Purpose</th>
	   <th scope="col"style="text-align:center">Outcome</th>
	   <th scope="col"style="text-align:center">Follow-up Needed</th>

	   
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
    $sql= 'SELECT o.*, b.lead_value, a.*,b.assign_person
			FROM crm_project_org o
			LEFT JOIN crm_project_lead b ON b.organization = o.id
			LEFT JOIN crm_lead_activity a ON a.lead_id = b.id
			WHERE 1'. $con.'';

	
/*	select o.* ,b.lead_value 
	from crm_project_org o
	left join crm_project_lead b on b.id = o.id where 1'.$con.'';*/
  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>

      <th scope="row"><?=$ia++?></th>
      <td><?=$data->date?></td>
      <td><?=$data->location?></td>
	    <td><?=$data->sales_req?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
      <td><?=$data->subject?></td>
	    <td><?=$data->outcome?? '' ?></td>
	    <td><?=$data->details?> </td>

    </tr>

<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}




//Sales Conversion Funnel Report (9)

if($_POST['report']==26082025) 
  {
     $company = $_POST['org'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Sales Conversion Funnel Report</title>
	  <script language="javascript">
      function hide() {
        document.getElementById('pr').style.display='none';
      }
    </script>

	  <?  //require_once "../../../controllers/core/inc.exporttable.php"; ?>
  </head>

  <body>
    <?=$title?>
    <center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
    <center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Sales Conversion Funnel Report</h3></center>
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
          <th scope="col"style="text-align:center; min-width: 65px;">Sales Representative</th>
          <th scope="col"style="text-align:center">Leads Contacted</th>
          <th scope="col"style="text-align:center; min-width: 90px;">Meetings Held</th>
          <th scope="col"style="text-align:center; min-width: 150px;">Deals Created</th>
          <th scope="col"style="text-align:center">Deals Closed</th>
          <th scope="col"style="text-align:center">Conversion Rate (%)</th>
        </tr>
      </thead>

      <tbody>
        <?php
          if($_POST['org']!=''){
          $con=' and id="'.$_POST['org'].'"';
          }

          $sql = "SELECT count(c.activity_id) AS Meeting, a.name, a.id, u.fname AS sales_representative
                  FROM crm_project_org a 
                  LEFT JOIN crm_project_lead b ON b.organization = a.id 
                  LEFT JOIN crm_lead_activity c ON c.lead_id = b.id
                  LEFT JOIN user_activity_management u ON u.user_id = a.assigned_person_id
                  WHERE c.activity_type = 'Meeting' GROUP BY a.id $con ";

            $query=db_query($sql);
            $ia=1;

                  while($data=mysqli_fetch_object($query)){
          ?>
        <tr>
          <th scope="row"><?=$ia++?></th>  
          <td><?=$data->sales_representative ?></td> 
          <td><?=$data->name ?></td>
          <td><?=$data->Meeting ?></td>
          <td><?=find_a_field('crm_project_lead','count(id)','organization="'.$data->id.'" ') ?> </td>
          <td><?= find_a_field('crm_project_lead', 'COUNT(id)', 'status = 9 and organization="'.$data->id.'" ') ?> </td>
          <td><?=$data->conversion_rate ?? '' ?> </td>
        <?  } ?>
      </tbody>
    </table>

  </body>
</html>
<?php

}




//Lost Deal Analysis Report (10)

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

    <title >Lost Deal Analysis Report</title>
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
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Lost Deal Analysis Report</h3></center>
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
     
      <!-- <th scope="col"style="text-align:center">S/L</th>
      <th scope="col"style="text-align:center">Sales/Deal Owner</th>
      <th scope="col"style="text-align:center">Amount</th>
      <th scope="col"style="text-align:center">Sales/Deal Name</th>
      <th scope="col"style="text-align:center">Client Name</th>
      <th scope="col"style="text-align:center">Project Name</th>
      <th scope="col"style="text-align:center">Disrict</th>
      <th scope="col"style="text-align:center">Stage </th> -->

     <th scope="col"style="text-align:center">S/L</th>
     <th scope="col"style="text-align:center; min-width: 100px;">Deal Name</th>
     <th scope="col"style="text-align:center; min-width: 90px;">Client Name</th>
     <th scope="col"style="text-align:center; width: 180px;">Company Address</th>
     <th scope="col"style="text-align:center">Sales Representative</th>
     <th scope="col"style="text-align:center; min-width: 65px;">Lost Date</th>
     <th scope="col"style="text-align:center; min-width: 200px;">Reason for loss</th>
     <th scope="col"style="text-align:center; min-width: 65px">Deal Value</th>
     <th scope="col"style="text-align:center">Competitor</th>
     <th scope="col"style="text-align:center; min-width: 200px;">Improvement Plan</th>
	   
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
    $sql = "SELECT o.*, u.fname AS sales_representative
            FROM crm_project_org o
            LEFT JOIN user_activity_management u ON o.assigned_person_id = u.user_id
            WHERE 1 $con ";



  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
  


    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->deal_name??''?></td>
      <td><?=$data->name?></td>
      <td><?=$data->address?> <?=$data->city?><?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
      <td><?=$data->sales_representative?></td>
	    <td><?=$data->lost_date?? ''?></td>
	    <td><?=$data->reason_for_loss?? ''?></td>
      <td><?=$data->deal_value?? ''?></td>
	    <td><?=$data->competitor?? ''?></td>
	    <td><?=$data->improvement_plan?? ''?></td>
    </tr>

<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}





//Response Time Report (Lead to Contact) (11)

if($_POST['report']==27082025) 
  {
     $company = $_POST['org'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Response Time Report (Lead to Contact)</title>
	  <script language="javascript">
      function hide() {
        document.getElementById('pr').style.display='none';
      }
    </script>

	  <?  //require_once "../../../controllers/core/inc.exporttable.php"; ?>
  </head>

  <body>
    <?=$title?>
    <center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
    <center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Response Time Report (Lead to Contact)</h3></center>
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
          <th scope="col"style="text-align:center; min-width: 65px;">Lead Name</th>
          <th scope="col"style="text-align:center">Assigned Representative</th>
          <th scope="col"style="text-align:center; min-width: 90px;">Date Created</th>
          <th scope="col"style="text-align:center; min-width: 150px;">First Contacted</th>
          <th scope="col"style="text-align:center">Response Time</th>
          <th scope="col"style="text-align:center">Status</th>
        </tr>
      </thead>

      <tbody>
        <?php
          if($_POST['org']!=''){
          $con=' and id="'.$_POST['org'].'"';
          }

          // $sql = "SELECT count(c.activity_id) AS Meeting, a.name, a.id
          //         FROM crm_project_org a 
          //         LEFT JOIN crm_project_lead b ON b.organization = a.id 
          //         LEFT JOIN crm_lead_activity c ON c.lead_id = b.id 
          //         WHERE c.activity_type = 'Meeting' group by a.id $con ";

          $sql = "SELECT COUNT(c.activity_id) AS Meeting, a.name AS organization_name, a.id AS organization_id, u.fname AS sales_representative, b.entry_at AS date_created
                    FROM crm_project_org a
                    LEFT JOIN crm_project_lead b ON b.organization = a.id
                    LEFT JOIN crm_lead_activity c ON c.lead_id = b.id
                    LEFT JOIN user_activity_management u  ON a.assigned_person_id = u.user_id
                    $con
                    GROUP BY a.id, u.fname";
            $query=db_query($sql);
            $ia=1;

                  while($data=mysqli_fetch_object($query)){
          ?>
        <tr>
          <th scope="row"><?=$ia++?></th>   
          <td><?=$data->organization_name?></td>
          <td><?=$data->sales_representative ?></td>
          <td><?=$data->date_created ?></td>
          <!-- <td><?=find_a_field('crm_project_lead','count(id)','organization="'.$data->id.'" ') ?> </td>
          <td><?= find_a_field('crm_project_lead', 'COUNT(id)', 'status = 9 and organization="'.$data->id.'" ') ?> </td> -->
          <td><?=$data->first_contacted ?? '' ?> </td>
          <td><?=$data->response_time ?? '' ?> </td>
          <td><?=$data->status ?? '' ?> </td>
        <?  } ?>
      </tbody>
    </table>

  </body>
</html>
<?php

}




//New Lead Follow-up Workflow (12)

if($_POST['report']==32082025) 
  {
     $company = $_POST['org'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >New Lead Follow-up Workflow</title>
	  <script language="javascript">
      function hide() {
        document.getElementById('pr').style.display='none';
      }
    </script>

	  <?  //require_once "../../../controllers/core/inc.exporttable.php"; ?>
  </head>

  <body>
    <?=$title?>
    <center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
    <center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >New Lead Follow-up Workflow</h3></center>
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
          <th scope="col"style="text-align:center">Step</th>
          <th scope="col"style="text-align:center; min-width: 65px;">Trigger</th>
          <th scope="col"style="text-align:center">Action</th>
          <th scope="col"style="text-align:center; min-width: 90px;">Delay</th>
          <th scope="col"style="text-align:center; min-width: 150px;">Goal</th>
      </thead>

      <tbody>
        <?php
          if($_POST['org']!=''){
          $con=' and id="'.$_POST['org'].'"';
          }


           $sql = "SELECT l.status, a.note, a.entry_at, a.activity_type, a.note,
                  CONCAT( CEIL(TIMESTAMPDIFF(SECOND, a.entry_at, NOW()) / 86400),' days (since ', DATE(a.entry_at), ')') AS days_passed
                  FROM crm_project_lead l
                  LEFT JOIN crm_lead_activity a ON a.lead_id = l.id
                  WHERE 1 $con";
                  $query=db_query($sql);
                  $ia=1;

                  while($data=mysqli_fetch_object($query)){
          ?>
        <tr>
          <th scope="row"><?=$ia++?></th>   
          <td><?=find_a_field('crm_lead_status','status','id="'.$data->status.'"');   ?></td>
          <td><?=$data->activity_type ?></td>
          <td><?=$data->days_passed?></td>
          <td><?=$data->note?> </td>
        <?  } ?>
      </tbody>
    </table>

  </body>
</html>
<?php

}




//No-response Follow-up Workflow (13)

if($_POST['report']==33082025) 
  {
     $company = $_POST['org'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >No-response Follow-up Workflow</title>
	  <script language="javascript">
      function hide() {
        document.getElementById('pr').style.display='none';
      }
    </script>

	  <?  //require_once "../../../controllers/core/inc.exporttable.php"; ?>
  </head>

  <body>
    <?=$title?>
    <center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
    <center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >No-response Follow-up Workflow</h3></center>
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
          <th scope="col"style="text-align:center">Step</th>
          <th scope="col"style="text-align:center; min-width: 65px;">Trigger</th>
          <th scope="col"style="text-align:center">Action</th>
          <th scope="col"style="text-align:center; min-width: 90px;">Delay</th>
          <th scope="col"style="text-align:center; min-width: 150px;">Goal</th>
      </thead>

      <tbody>
        <?php
          if($_POST['org']!=''){
          $con=' and id="'.$_POST['org'].'"';
          }
          
          $sql = "SELECT l.status, a.note, a.entry_at, a.activity_type, a.note,
                  CONCAT( CEIL(TIMESTAMPDIFF(SECOND, a.entry_at, NOW()) / 86400),' days (since ', DATE(a.entry_at), ')') AS days_passed
                  FROM crm_project_lead l
                  LEFT JOIN crm_lead_activity a ON a.lead_id = l.id
                  WHERE 1 $con";
                  $query=db_query($sql);
                  $ia=1;

                  while($data=mysqli_fetch_object($query)){
          ?>
        <tr>
          <th scope="row"><?=$ia++?></th>   
          <td><?=find_a_field('crm_lead_status','status','id="'.$data->status.'"');   ?></td>
          <td><?=$data->activity_type ?></td>
          <td><?=$data->days_passed?></td>
          <td><?=$data->note?> </td>
        <?  } ?>
      </tbody>
    </table>

  </body>
</html>
<?php

}



//Proposal/Deal Stage Follow-up Workflow (14)

if($_POST['report']==34082025) 
  {
     $company = $_POST['org'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title >Proposal/Deal Stage Follow-up Workflow</title>
	  <script language="javascript">
      function hide() {
        document.getElementById('pr').style.display='none';
      }
    </script>

	  <?  //require_once "../../../controllers/core/inc.exporttable.php"; ?>
  </head>

  <body>
    <?=$title?>
    <center class="mb-4"><h3 style="font-size: 27px; font-weight: 800;" >ERP COM BD LTD  </h3></center>
    <center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Proposal/Deal Stage Follow-up Workflow</h3></center>
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
          <th scope="col"style="text-align:center">Step</th>
          <th scope="col"style="text-align:center; min-width: 65px;">Trigger</th>
          <th scope="col"style="text-align:center">Action</th>
          <th scope="col"style="text-align:center; min-width: 90px;">Delay</th>
          <th scope="col"style="text-align:center; min-width: 150px;">Goal</th>
      </thead>

      <tbody>
        <?php
          if($_POST['org']!=''){
          $con=' and id="'.$_POST['org'].'"';
          }
          
        $sql = "SELECT l.status, a.note, a.entry_at, a.activity_type,
        CONCAT( CEIL(TIMESTAMPDIFF(SECOND, a.entry_at, NOW()) / 86400),' days (since ', DATE(a.entry_at), ')') AS days_passed
        FROM crm_project_lead l
        LEFT JOIN crm_lead_activity a ON a.lead_id = l.id
        WHERE 1 $con";
                   
                  $query=db_query($sql);
                  $ia=1;

                  while($data=mysqli_fetch_object($query)){
          ?>
        <tr>
          <th scope="row"><?=$ia++?></th>   
          <td><?=find_a_field('crm_lead_status','status','id="'.$data->status.'"');   ?></td>
          <td><?=$data->activity_type ?></td>
          <td><?=$data->days_passed?></td>
          <td><?=$data->note?> </td>
        </tr>
        
        <?  } ?>
      </tbody>
    </table>

  </body>
</html>
<?php

}




//Re-Order or After-Sales Follow-Up (15)

if($_POST['report']==903){
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

    <title >Re-Order or After-Sales Follow-Up</title>
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
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Re-Order or After-Sales Follow-Up</h3></center>
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
      <th scope="col"style="text-align:center">Step</th>
      <th scope="col"style="text-align:center">Trigger</th>
	    <th scope="col"style="text-align:center">Action</th>
	    <th scope="col"style="text-align:center">Delay</th>
      <th scope="col"style="text-align:center">Goal</th>
  
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
$sql = "SELECT l.status, a.note, a.entry_at, a.activity_type,
        CONCAT( CEIL(TIMESTAMPDIFF(SECOND, a.entry_at, NOW()) / 86400),' days (since ', DATE(a.entry_at), ')') AS days_passed
        FROM crm_project_lead l
        LEFT JOIN crm_lead_activity a ON a.lead_id = l.id
        WHERE 1 $con";
  $query=db_query($sql);
  $ia=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->status?></td>
	    <td><?=find_a_field('crm_lead_status','status','id="'.$data->status.'"');   ?></td>
	    <td><?=$data->days_passed ?></td>
      <td><?=$data->client_visited?? '' ?></td>

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}



//Missed Meeting Reschedule Workflow (16)

if($_POST['report']==913){
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

    <title >Missed Meeting Reschedule Workflow</title>
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
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Missed Meeting Reschedule Workflow</h3></center>
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
      <th scope="col"style="text-align:center">Step</th>
      <th scope="col"style="text-align:center">Trigger</th>
	  <th scope="col"style="text-align:center">Action</th>
	  <th scope="col"style="text-align:center">Delay</th>
      <th scope="col"style="text-align:center">Goal</th>
  
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
$sql = "SELECT l.status, a.note, a.entry_at, a.activity_type,
                  CONCAT( CEIL(TIMESTAMPDIFF(SECOND, a.entry_at, NOW()) / 86400),' days (since ', DATE(a.entry_at), ')') AS days_passed
                  FROM crm_project_lead l
                  LEFT JOIN crm_lead_activity a ON a.lead_id = l.id
                  WHERE 1 $con";
                  $query=db_query($sql);
                  $ia=1;

	
/*	select o.* ,b.lead_value 
	from crm_project_org o
	left join crm_project_lead b on b.id = o.id where 1'.$con.'';*/
 /* $query=db_query($sql);*/
  /*$ia=1;*/
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->activity_type ?></td>
      <td><?=find_a_field('crm_lead_status','status','id="'.$data->status.'"');   ?></td>
      <td><?=$data->days_passed ?></td>
      <td><?=$data->client_visited?? '' ?></td>

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}



//MONTHLY SALES ACTIVITY REPORT (TABLE FORMAT) (17)

if($_POST['report']==987){
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

    <title >MONTHLY SALES ACTIVITY REPORT (TABLE FORMAT)</title>
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
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >MONTHLY SALES ACTIVITY REPORT (TABLE FORMAT)</h3></center>
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
      <th scope="col"style="text-align:center">SI no.</th>
      <th scope="col"style="text-align:center">Client Name</th>
	    <th scope="col"style="text-align:center">Client Contact</th>
	    <th scope="col"style="text-align:center">Address</th>
      <th scope="col"style="text-align:center">Description / Business Type</th>
	    <th scope="col"style="text-align:center">Cold Calls Made</th>
	    <th scope="col"style="text-align:center">Follow-up Calls</th>
	    <th scope="col"style="text-align:center">WhatsApp Sent</th>
	    <th scope="col"style="text-align:center">Emails Sent</th>
	    <th scope="col"style="text-align:center">Meetings Arranged</th>
	    <th scope="col"style="text-align:center">Visits Completed</th>
	    <th scope="col"style="text-align:center">Leads Generated</th>
	    <th scope="col"style="text-align:center">Deals Closed</th>
	    <th scope="col"style="text-align:center">Products Sold</th>
	    <th scope="col"style="text-align:center">Sales Revenue (BDT)</th>
	    <th scope="col"style="text-align:center">Status / Notes</th>
	    <th scope="col"style="text-align:center">Next Action Date</th>
	    <th scope="col"style="text-align:center">Assigned Sales Rep</th>
  
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
$sql = "SELECT  a.note,l.lead_name, SUM(l.lead_value) AS lead_value, m.fname, o.name, o.address, CONCAT_WS(' - ', o.contact_person, o.contact_number) AS contact_info
        FROM crm_project_lead l
        LEFT JOIN crm_lead_activity a ON a.lead_id = l.id
        LEFT JOIN user_activity_management m ON m.user_id = l.entry_by
        LEFT JOIN crm_project_org o ON o.entry_by = l.entry_by
        WHERE 1 $con
        GROUP BY o.name";
        $query=db_query($sql);
        $ia=1;


  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->name ?></td>
	    <td><?=$data->contact_info ?>
	    <td><?=$data->address ?></td>
      <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->lead_value ?></td>
	    <td><?=$data->note ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->fname ?></td>
    </tr>
<? } ?>
  </tbody>
</table>

  </body>
</html>
<?php

}


//New Lead Follow-up Workflow(18)

if($_POST['report']==971){
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

    <title >Sales Report (Deal Pipeline Report)</title>
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
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Monthly Sales Summary Report(Table Format)</h3></center>
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
      <th scope="col"style="text-align:center">SI no.</th>
      <th scope="col"style="text-align:center">Sales Rep Name</th>
	    <th scope="col"style="text-align:center">Total Client Visits</th>
	    <th scope="col"style="text-align:center">Total Sales Proposals</th>
      <th scope="col"style="text-align:center">Total Quotations Sent</th>
	    <th scope="col"style="text-align:center">Total Demo Presentations</th>
	    <th scope="col"style="text-align:center">Final Sales (Deals Closed)</th>
	    <th scope="col"style="text-align:center">Total Sales Revenue (BDT)</th>
	    <th scope="col"style="text-align:center">Notes</th>
  
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
  $sql = "SELECT org.*, activity.subject AS purpose_of_visit, user.fname AS sales_representative, lead.lead_value, lead.assign_person as as_person 
          FROM crm_project_lead lead 
          LEFT JOIN crm_project_org org ON lead.organization = org.id 
          LEFT JOIN crm_lead_activity activity ON activity.project_id = org.id 
          LEFT JOIN user_activity_management user ON org.assigned_person_id = user.username 
          WHERE 1 
          GROUP BY lead.assign_person";
          $query=db_query($sql);
          $ia=1;

  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
      <td><?=$data->sales_representative?>::<?=$data->as_person?></td>
	    <td><?=find_a_field('crm_project_lead a, crm_lead_activity b','count(b.activity_id)','b.lead_id = a.id and a.assign_person = "'.$data->as_person.'" AND b.activity_type  = "Visit" '); ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
      <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->client_visited?? '' ?></td>
	    <td><?=$data->lead_value?></td>
	    <td><?=$data->note?? '' ?></td>

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}

//Schedule Report (19)

if($_POST['report']==993){
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

    <title >Schedule Report</title>
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
<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;" >Schedule Report</h3></center>
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
      <th scope="col"style="text-align:center">SI no.</th>
      <th scope="col"style="text-align:center">Entry By</th>
	  <th scope="col"style="text-align:center">Project Name </th>
	  <th scope="col"style="text-align:center">Lead Name</th>
	  <th scope="col"style="text-align:center">Assign Person</th>
      <th scope="col"style="text-align:center">Date</th>
	  <th scope="col"style="text-align:center">Purpose</th>
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and id="'.$_POST['org'].'"';
  }
	
$sql = "SELECT l.status, l.lead_name, a.lead_id, l.assign_person, l.entry_by, a.note, a.entry_at, a.activity_type, a.date, b.name 
        FROM crm_project_lead l 
        LEFT JOIN crm_lead_activity a ON a.lead_id = l.id 
        LEFT JOIN crm_project_org b ON l.assign_person = b.assigned_person_id WHERE 1;";
         
        $query=db_query($sql);
        $ia=1;


  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$ia++?></th>
        <td><?=$data->entry_by?></td>
	    <td><?=$data->name?></td>
	    <td><?=$data->lead_name?>,<?=$data->lead_id?></td>
        <td><?=$data->assign_person?></td>
	    <td><?=$data->date?></td>
	    <td><?=$data->activity_type?></td>
	    
    </tr>
<? } ?>
  </tbody>
</table>

  </body>
</html>
<?php

}

//END LINE
//END LINE
//END LINE
//END LINE
//END LINE
?>