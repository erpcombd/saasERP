<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title="Shift Schedule";
$head = '<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


?>




<!--<link rel="stylesheet" href="assets/css/bootstrap.min.css">-->



<link rel="stylesheet" href="assets/css/line-awesome.min.css">
<link rel="stylesheet" href="assets/css/material.css">

<link rel="stylesheet" href="assets/css/select2.min.css">

<!--<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">-->

<!--<link rel="stylesheet" href="assets/css/style.css">-->
</head>
<body>

<div class="main-wrapper">

<div class="page-wrapper">
<div class="content container-fluid">
<form action="?"  method="post">
    
<? include('../../common/title_bar_shift.php');?>

<div class="card text-center">
<div class="card-body" style="background-color:#A5D392;">
      
      
<div class="row filter-row">
    
 <div class="col-sm-6 col-md-3">
<div class="input-block mb-3 form-focus select-focus">
    <label class="focus-label"> Shift Start Date</label>
    <input type="date" name="fdate" autocomplete="off" id="fdate" style="width:50%;"  value="<?=$_POST['fdate']?>"  class="form-control" />

</div>
</div>


<div class="col-sm-6 col-md-3">
<div class="input-block mb-3 form-focus select-focus">
 <label class="focus-label">Shift End  Date</label>
  <input type="date" name="tdate" autocomplete="off" id="tdate" style="width:50%;"  value="<?=$_POST['tdate']?>"  class="form-control" />

</div>
</div>

<div class="col-sm-6 col-md-3">
<div class="input-block mb-3 form-focus">
    <label class="focus-label"> Shift </label>
    
            <select name="shedule" id="shedule" value="<?=$_POST_["shedule"];?>">
                <option></option>
                <? foreign_relation('hrm_schedule_info','id','schedule_name',$shedule,'1');?>
              </select>
              

</div>
</div>


<div class="col-sm-6 col-md-3">
<div class="d-grid">
 <!-- <input name="create" id="create" value="SHOW EMPLOYEE" type="submit" class="btn btn-danger"> -->
 
 
  <?  if(isset($_POST['button'])){ ?>
  <label class="focus-label">  </label>
  <input name="save" type="submit" id="save" value="SAVE" class="btn btn-primary form-control"/>
  <? } ?>



</div>
</div> 


 </div>

</div>

</div>

<div class="row">
<div class="col-lg-12">
<div class="table-responsive">
<table class="table table-bordered table-sm">
<thead>

<?  


$fdate = $_POST['fdate'];
$tdate = $_POST['tdate'];

$fdate =  date('Y-m-d',strtotime($fdate));
$tdate =  date('Y-m-d',strtotime($tdate));

if(isset($_POST['save']))
{		
		//if($_POST['designation']>0) $con .=' and a.PBI_DESIGNATION='.$_POST['designation'];
		if($_POST['department']>0) 		$con .=' and a.DEPT_ID='.$_POST['department'];
		if($_POST['job_location']>0) 	$con .=' and a.JOB_LOCATION='.$_POST['job_location'];
		if($_POST['group_for']>0) 		$con .=' and a.PBI_ORG='.$_POST['group_for'];
		if($_POST['PBI_DOMAIN']!='')	$con .=' and a.PBI_DOMAIN="'.$_POST['PBI_DOMAIN'].'"';
		
		 $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,d.DEPT_DESC as PBI_DEPARTMENT from 
		personnel_basic_info a,department d
		where  1 ".$con." and d.DEPT_ID=a.DEPT_ID  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";
		
		$query = db_query($sql);
		while($info=mysqli_fetch_object($query))
		{
		
$r_date = $rp1_date = $rp2_date = $rp3_date = $_POST['fdate'];
$re_date = date('Y-m-d',strtotime($r_date)+(6*86400));
		
		$roster_date = $_POST['roster_date'];
		$entry_by = $_SESSION['user']['id'];
		
		for($i=$fdate;$i<=$tdate;$i = date('Y-m-d', strtotime( $i . " +1 days"))){ 
		
    

		
		$shedule = $_POST['s_'.$info->PBI_ID.'_'.$i];
		
		if($shedule>0){
		$del_sql = "delete from hrm_roster_allocation where PBI_ID='".$info->PBI_ID."' and roster_date = '".$i."'";
		db_query($del_sql);
		 $insSql = 'INSERT INTO hrm_roster_allocation( PBI_ID, roster_date,  shedule_1, job_location,group_for, entry_by) 
		 VALUES ("'.$info->PBI_ID.'", "'.$i.'",  "'.$shedule.'", "'.$_POST['job_location'].'", "'.$_POST['group_for'].'", "'.$entry_by.'")';
		db_query($insSql);
		}
 //$rp3_date = date ("Y-m-d", strtotime("+1 day", strtotime($rp3_date)));
 
               } 
			}
		}




?>



</thead>


<tr style="background-color:#18a318; color:#FFFFFF">
<th style="background-color:#18a318; color:#FFFFFF">ID</th>
<th style="background-color:#18a318; color:#FFFFFF">Employee</th>
<th style="background-color:#18a318; color:#FFFFFF">Weekend</th>
<th style="background-color:#18a318; color:#FFFFFF">Shift</th>

<? for($i=$fdate;$i<=$tdate;$i = date('Y-m-d', strtotime( $i . " +1 days"))){ 

?>
<th style="background-color:#18a318; color:#FFFFFF"><?=date('F D j',strtotime($i));?></th>

<? } ?>




</tr>
<tbody>


      <?
	     if(isset($_POST['button'])){
	    
	                 
	                       
	                        
	                        if($_POST['PBI_CODE']!="") $codeConn = " and a.PBI_CODE='".$_POST['PBI_CODE']."'";
                            if($_POST['PBI_IDD']!="") $idConn = " and a.PBI_ID ='".$_POST['PBI_IDD']."'";
                          
                            if($_POST['PBI_NAME']!="") $NameConn = " and a.PBI_NAME='".$_POST['PBI_NAME']."'";
                            if($_POST['DESG_ID']>0) $desgConn = " and a.DESG_ID='".$_POST['DESG_ID']."'";
                            if($_POST['DEPT_ID']>0) $depConn = " and a.DEPT_ID='".$_POST['DEPT_ID']."'";
                            if($_POST['PBI_SEX']!="") $genderConn = " and a.PBI_SEX='".$_POST['PBI_SEX']."'";
                            if($_POST['grade']>0) $gradeConn = " and a.grade='".$_POST['grade']."'";  
                            if($_POST['work_station']>0) $work_station = " and a.PBI_WORK_STATION='".$_POST['work_station']."'";  
                            
                            
                            
                            if($_POST['PBI_RELIGION']!="") $ReligionConn = " and a.PBI_RELIGION='".$_POST['PBI_RELIGION']."'";
                            if($_POST['PBI_ORG']>0) $OrgConn = " and a.PBI_ORG='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and a.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
                            
                            if($_POST['section']>0) $secConn = " and a.section='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and a.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['cost_center']>0) $CostConn = " and a.cost_center='".$_POST['cost_center']."'";
                     
                            
                            if($_POST['class']>0) $classConn = " and a.class='".$_POST['class']."'";
                            if($_POST['line']>0) $lineConn = " and a.line='".$_POST['line']."'";
                            if($_POST['incharge_id']>0) $inchargeConn = " and a.incharge_id='".$_POST['incharge_id']."'";
                            if($_POST['DOJ']>0) $DOJConn = " and a.PBI_DOJ='".$_POST['DOJ']."'";
                            						
		
		$show=1;
		
		 $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_CODE,g.DESG_DESC as PBI_DESIGNATION,d.DEPT_DESC as PBI_DEPARTMENT,a.define_schedule,
		 a.Friday,a.Saturday
		from personnel_basic_info a,department d,designation g
		where  1 ".$codeConn.$idConn.$genderConn.$NameConn.$ReligionConn.$DOJConn.$OrgConn.$classConn.$gradeConn.$work_station.
$lineConn.$inchargeConn.$depConn.$desgConn.$secConn.$JoblocConn.$CostConn.$levelConn.$job_statusConn." and a.DEPT_ID=d.DEPT_ID and a.DESG_ID=g.DESG_ID and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";
		
		$query = db_query($sql);
		
		while($info=mysqli_fetch_object($query))
		{
		$rp2_date = $fdate;
		
		 if($_POST['shedule']>0) $shift = " and shedule_1 = '".$_POST['shedule']."'";
		
		 $ros = "select * from hrm_roster_allocation 
		 where PBI_ID='".$info->PBI_ID."'  ".$shift."
		 
		 and roster_date between '".$fdate."' and '".$tdate."' ";
		
		$ros_r = db_query($ros);
		while($roster = mysqli_fetch_object($ros_r)){
		
		//$point[$roster->PBI_ID]=$roster->point_1;

	    $shedule[$roster->PBI_ID][$roster->roster_date]=$roster->shedule_1;

		
		}
		?>
		
		
		<tr>
      <td><?=$info->PBI_CODE?>
        <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" />
        <input type="hidden" name="sdate" id="sdate" value="<?=$fdate?>" />
        <input type="hidden" name="tdate" id="tdate" value="<?=$tdate?>" /></td>
      <td><?=$info->PBI_NAME?></td>
      <td><? 
      
      if($info->Friday == "Weekend"){
       echo "Friday" ;
      }elseif ($info->Saturday == "Weekend"){
           echo "Saturday" ;
      }else{ }  
      ?></td>
      <td><?=find_a_field('hrm_schedule_info','acronyms','id="'.$info->define_schedule.'"');?></td>
      
	     <? for($i=$fdate;$i<=$tdate; $i = date('Y-m-d', strtotime( $i . " +1 days"))){ 
			//$rp2_date = date('Y-m-d',$i);
			?> 
			

			
      <td class='shift-cell'><select name="s_<?=$info->PBI_ID?>_<?=$i?>" id="s_<?=$info->PBI_ID?>_<?=$i?>" class="shift-dropdown">
          <option></option>
          <? foreign_relation('hrm_schedule_info','id','acronyms',$shedule[$info->PBI_ID][$i]);?>
        </select>

      </td>
	    <?    } ?>
	

		
		
    </tr>
	
	 <?	} }?>

<!--<tr>

<td>1001</td>

<td></td>
<td>Friday</td>
<td style="background-color:#18a318; color:#FFFFFF">Day</td>
<td><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#attendance_info">NS</a></td>
<td><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#attendance_info">NS</a></td>
<td><i class="fa fa-close text-danger"></i> </td>
<td><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#attendance_info">DS</a></td>
<td><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#attendance_info">DS</a></td>



</tr>-->














</tbody>
</table>
</div>
</div>
</div>
</div>

</form>


<div class="modal custom-modal fade" id="attendance_info" role="dialog">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Attendance Info</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<div class="row">
<div class="col-md-6">
<div class="card punch-status">
<div class="card-body">
<h5 class="card-title">Timesheet <small class="text-muted">11 Mar 2019</small></h5>
<div class="punch-det">
<h6>Punch In at</h6>
<p>Wed, 11th Mar 2019 10.00 AM</p>
</div>
<div class="punch-info">
<div class="punch-hours">
<span>3.45 hrs</span>
</div>
</div>
<div class="punch-det">
<h6>Punch Out at</h6>
<p>Wed, 20th Feb 2019 9.00 PM</p>
</div>
<div class="statistics">
<div class="row">
<div class="col-md-6 col-6 text-center">
<div class="stats-box">
<p>Break</p>
<h6>1.21 hrs</h6>
</div>
</div>
<div class="col-md-6 col-6 text-center">
<div class="stats-box">
<p>Overtime</p>
<h6>3 hrs</h6>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-md-6">
<div class="card recent-activity">
<div class="card-body">
<h5 class="card-title">Activity</h5>
<ul class="res-activity-list">
<li>
<p class="mb-0">Punch In at</p>
<p class="res-activity-time">
<i class="fa-regular fa-clock"></i>
10.00 AM.
</p>
</li>
<li>
<p class="mb-0">Punch Out at</p>
<p class="res-activity-time">
<i class="fa-regular fa-clock"></i>
11.00 AM.
</p>
</li>
<li>
<p class="mb-0">Punch In at</p>
<p class="res-activity-time">
<i class="fa-regular fa-clock"></i>
11.15 AM.
</p>
</li>
<li>
<p class="mb-0">Punch Out at</p>
<p class="res-activity-time">
<i class="fa-regular fa-clock"></i>
1.30 PM.
</p>
</li>
<li>
<p class="mb-0">Punch In at</p>
<p class="res-activity-time">
<i class="fa-regular fa-clock"></i>
2.00 PM.
</p>
</li>
<li>
<p class="mb-0">Punch Out at</p>
<p class="res-activity-time">
<i class="fa-regular fa-clock"></i>
7.30 PM.
</p>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>

</div>




<!--<script src="assets/js/jquery-3.7.0.min.js"></script>-->

<script src="assets/js/bootstrap.bundle.min.js"></script>

<!--<script src="assets/js/jquery.slimscroll.min.js"></script>

<script src="assets/js/select2.min.js"></script>

<script src="assets/js/moment.min.js"></script>-->
<!--<script src="assets/js/bootstrap-datetimepicker.min.js"></script>-->

<!--<script src="assets/js/layout.js"></script>
<script src="assets/js/theme-settings.js"></script>
<script src="assets/js/greedynav.js"></script>-->

<!--<script src="assets/js/app.js"></script>-->
</body>
</html>


    <script>
        $(document).ready(function() {
            // Event handler when a shift dropdown value changes.
            $('.shift-dropdown').change(function() {
                const selectedShift = $(this).val();

                // Find the index of the changed dropdown.
                const selectedIndex = $(this).parent().index();

                // Update the same-day shifts for all employees.
                $('table tr').each(function() {
                    $(this).find('td:eq(' + selectedIndex + ') select').val(selectedShift);
                });
            });
        });
    </script>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>