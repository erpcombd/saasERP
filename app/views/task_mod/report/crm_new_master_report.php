<?php 
   session_start();

   ob_start();
    
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
    require "../include/custom.php";
   date_default_timezone_set('Asia/Dhaka');

$title="<center class=''><h2>".$_SESSION['company_name']."</h2></center>";

if($_POST['report']==404){


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">

    <title>Organization Report</title>
	<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	require_once "../../../controllers/core/inc.exporttable.php";
	?>
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3>Organization Report</h3></center>
 
  <table class="table table-bordered" id="ExportTable">
  <thead>
    <tr>
      <th scope="col">S/L</th>
      <th scope="col">Organization Name</th>
      <th scope="col">Address</th>
      <th scope="col">Total Employee</th>
	   <th scope="col">Anual Revenue</th>
	   <th scope="col">Contact Person Information</th>
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
      <td><?=$data->address?>,<?=$data->city?>,<?=find_a_field('crm_country_management','country_name','id="'.$data->country.'"')?></td>
      <td><?=$data->total_employees?></td>
	  <td><?=$data->annual_revenue?></td>
	  <td width="40%">
<?php
$csql='select * from crm_org_contacts where project_id="'.$data->id.'"';
$cquery=db_query($csql);
$i=1;
while($conRow=mysqli_fetch_object($cquery)){
  echo "<b>Contact Person-".$i."</b><br> Name: ".$conRow->contact_name." , Phone: ".$conRow->contact_phone." , Email: ".$conRow->contact_email." , Designation: ".$conRow->contact_designation.".<br>";
$i++;
}
?>


    </td>
    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}
if($_POST['report']==505){ ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">

    <title>Organization Report</title>
		<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	require_once "../../../controllers/core/inc.exporttable.php";
	?>
	
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3>Lead Report</h3></center>
 
  <table class="table table-bordered" id="ExportTable">
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
    </tr>
  </thead>
  <tbody>
  
  <?php
  if($_POST['org']!=''){
  $con=' and organization="'.$_POST['org'].'"';
  }

   $sql='select l.*,o.name,p.products from crm_project_lead l,crm_project_org o,crm_lead_products p where l.organization=o.id and l.product=p.id  '.$con.'';
  $query=db_query($sql);
  $i=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$i++?></th>
      <td><?=$data->name."##".$data->products?></td>
      <td><?=find_a_field('crm_lead_status','status','id="'.$data->status.'"')?></td>
      <td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->assign_person.'"');?></td>
	  <td><?=find_a_field('crm_org_contacts','concat(contact_name,", ",contact_phone)','project_id="'.$data->organization.'"')?></td>
    <td><?=find_a_field('crm_lead_activity','count(lead_id)','lead_id="'.$data->id.'" and activity_type="Call"')?></td>
    <td><?=find_a_field('crm_lead_activity','count(lead_id)','lead_id="'.$data->id.'" and activity_type="Visit"')?></td>
    <td><?=find_a_field('crm_lead_activity','count(lead_id)','lead_id="'.$data->id.'" and activity_type="Meeting"')?></td>
    

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>
<?php

}
if($_POST['report']==606 && $_POST['lead']!=''){ ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">

    <title>Lead Log Report</title>
		<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	require_once "../../../controllers/core/inc.exporttable.php";
	?>
	
  </head>
  <body>

<?=$title?>
<center class="mb-4"><h3>Lead Log Report</h3></center>

<center><h4><?=find_a_field('crm_project_org o,crm_project_lead l,crm_lead_log a,crm_lead_products p','concat(o.name,"##(",p.products,")")','l.organization=o.id and l.product=p.id and l.id="'.$_POST['lead'].'"')?></h4></center><br><br>
 
  <table class="table table-bordered" id="ExportTable">
  <thead>
    <tr>
      <th scope="col">S/L</th>
      <th scope="col">Activity Type</th>
      <th scope="col">Date</th>
      <th scope="col">Details</th>
    </tr>
  </thead>
  <tbody>
  
  <?php
  
 
  if($_POST['lead']!=''){
  $con=' and a.lead_id="'.$_POST['lead'].'"';
  

   $sql='select l.*,s.status from crm_lead_log l,crm_lead_status s where l.status=s.id and lead_id="'.$_POST['lead'].'" order by id ASC';
   }
  $query=db_query($sql);
  $i=1;
  while($data=mysqli_fetch_object($query)){
  ?>
    <tr>
      <th scope="row"><?=$i++?></th>
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
    require_once "../../../controllers/core/inc.exporttable.php";
    ?>
    
    </head>
    <body>
  
  <?=$title?>
  <center class="mb-4"><h3>Lead Activity Report</h3></center>
   
    <table class="table table-bordered" id="ExportTable">
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
      </tr>
    </thead>
    <tbody>
    
    <?php
    if($_POST['org']!=''){
    $con=' and organization="'.$_POST['org'].'"';
    }
  
     $sql='select l.*,o.name,p.products from crm_project_lead l,crm_project_org o,crm_lead_products p where l.organization=o.id and l.product=p.id  '.$con.'';
    $query=db_query($sql);
    $i=1;
    while($data=mysqli_fetch_object($query)){
    ?>
      <tr>
        <th scope="row"><?=$i++?></th>
        <td><?=$data->name."##".$data->products?></td>
        <td><?=find_a_field('crm_lead_status','status','id="'.$data->status.'"')?></td>
        <td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->assign_person.'"');?></td>
      <td><?=find_a_field('crm_org_contacts','concat(contact_name,", ",contact_phone)','project_id="'.$data->organization.'"')?></td>
      <td><?=find_a_field('crm_lead_activity','count(lead_id)','lead_id="'.$data->id.'" and activity_type="Call"')?></td>
      <td><?=find_a_field('crm_lead_activity','count(lead_id)','lead_id="'.$data->id.'" and activity_type="Visit"')?></td>
      <td><?=find_a_field('crm_lead_activity','count(lead_id)','lead_id="'.$data->id.'" and activity_type="Meeting"')?></td>
      
  
      </tr>
  <? }?>
    </tbody>
  </table>
  
    </body>
  </html>
  <?php
  
  } ?>