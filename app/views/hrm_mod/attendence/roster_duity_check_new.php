<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title="Shift Schedule";
$head = '<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


?>




<link rel="stylesheet" href="assets/css/line-awesome.min.css">
<link rel="stylesheet" href="assets/css/material.css">

<link rel="stylesheet" href="assets/css/select2.min.css">


</head>
<body>

<div class="main-wrapper">

<div class="page-wrapper">
<div class="content container-fluid">






<form  method="post" id="employeeForm">
    
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
<div class="d-grid">


</div>
</div> 


 </div>

</div>

</div>





<!--  STRAT  -->
<div class="card text-center">
<div class="card-body" style="background-color:#F8D7DA;">
      
      
<div class="row filter-row">
    
 <div class="col-sm-6 col-md-3">
<div class="input-block mb-3 form-focus select-focus">
    <label class="focus-label"> Shift Start Date</label>
    <input type="date" name="sdate" autocomplete="off" id="sdate" style="width:50%;"  value="<?=$_POST['sdate']?>"  class="form-control" />

</div>
</div>


<div class="col-sm-6 col-md-3">
<div class="input-block mb-3 form-focus select-focus">
 <label class="focus-label">Shift End  Date</label>
  <input type="date" name="edate" autocomplete="off" id="edate" style="width:50%;"  value="<?=$_POST['edate']?>"  class="form-control" />

</div>
</div>

<div class="col-sm-6 col-md-3">
<div class="input-block mb-3 form-focus">
    <label class="focus-label"> Shift </label>
    
            <select name="shedulee" id="shedulee" value="<?=$_POST_["shedulee"];?>">
                <option></option>
             
				<? foreign_relation('hrm_schedule_info', 'id', 'CONCAT(schedule_name, "-", acronyms)', $shedulee, '1'); ?>

              </select>
              

</div>
</div>


<div class="col-sm-6 col-md-3">
<div class="d-grid">

 
  <label class="focus-label"> Make Change  </label>
   <button type="button" class="btn btn-danger" onclick="submitForm()">Submit</button>


</div>
</div> 


 </div>

</div>

</div>

<!--  END -->




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



  if(isset($_POST['button'])){
  
  
?>



</thead>


<tr style="background-color:#18a318; color:#FFFFFF">
<th style="width:50px;text-align:center;background-color:#18a318; color:#FFFFFF">Mark</th>
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
							if($_POST['shedule']>0) $shift = " and a.define_schedule = '".$_POST['shedule']."'";
							if($_POST['tdate']>0) $tdate = $_POST['tdate'] ; 
                            						
		
		$show=1;
		
		 $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_CODE,g.DESG_DESC as PBI_DESIGNATION,d.DEPT_DESC as PBI_DEPARTMENT,a.define_schedule,
		 a.Friday,a.Saturday
		from personnel_basic_info a,department d,designation g
		where  1
		".$codeConn.$idConn.$genderConn.$NameConn.$ReligionConn.$DOJConn.$OrgConn.$classConn.$gradeConn.$work_station.
$lineConn.$inchargeConn.$depConn.$desgConn.$secConn.$JoblocConn.$CostConn.$levelConn.$job_statusConn.$shift." and a.DEPT_ID=d.DEPT_ID and a.define_schedule>0 and
a.DESG_ID=g.DESG_ID and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";
		
		$query = db_query($sql);
		
		while($info=mysqli_fetch_object($query))
		{
		
		
		$rp2_date = $fdate;
		
   	    $ros = "select * from hrm_roster_allocation  where PBI_ID='".$info->PBI_ID."' and roster_date between '".$_POST['fdate']."' and '".$_POST['tdate']."' ";
		
		 $ros_r = db_query($ros);
		 while($roster = mysqli_fetch_object($ros_r)){
         
		 $shedule[$roster->PBI_ID][$roster->roster_date]=$roster->shedule_1;

		
		}
		?>
		
		
		<tr>
		
	 <td style="width:50px"><input type="checkbox" style="width:50px" name="check_list[]" value="<?=$info->PBI_ID;?>"></td>
		
      <td><?=$info->PBI_CODE?>
        <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" />
      </td>
      <td><?=$info->PBI_NAME?></td>
      <td><? 
      
      if($info->Friday == "Weekend"){
       echo "Friday" ;
      }elseif ($info->Saturday == "Weekend"){
           echo "Saturday" ;
      }else{ }  
      ?></td>
      <td><?=find_a_field('hrm_schedule_info','acronyms','id="'.$info->define_schedule.'"');?></td>
      
	     <? 
		 
		    $fdate = $_POST['fdate'] ;
			$tdate = $_POST['tdate'] ;
		   for($i=$fdate;$i<=$tdate; $i = date('Y-m-d', strtotime( $i . " +1 days"))){ 
			//$rp2_date = date('Y-m-d',$i);
			?> 
			

			
      <td class='shift-cell'>
	  
	  <?  
	   $shift_check = find_a_field('hrm_roster_allocation','id','roster_date="'.$i.'" and PBI_ID ="'.$info->PBI_ID.'" ');
	  
	  if($shift_check>0){    ?>
	  
	   <select name="s_<?=$info->PBI_ID?>_<?=$i?>" id="s_<?=$info->PBI_ID?>_<?=$i?>" class="shift-dropdown" style="color: #3A71D6;">
          <option></option>
          <? foreign_relation('hrm_schedule_info','id','acronyms',$shedule[$info->PBI_ID][$i]);?>
        </select>
		
		<?  }else {  ?>  
		
		   <select name="s_<?=$info->PBI_ID?>_<?=$i?>" id="s_<?=$info->PBI_ID?>_<?=$i?>" class="shift-dropdown">
			  <option></option>
			  <? foreign_relation('hrm_schedule_info','id','acronyms',$info->define_schedule);?>
			</select>
		
		<? } ?>
		
		
		

      </td>
	    <?    } ?>
	

		
		
    </tr>
	
	 <?	}   ?>   


</tbody>
</table>

 	<div align="left"><input type="checkbox" class="form-check-input" id="select-all"><label for="checkbox"><span class="bg-danger text-white">Select All</span></label></div>
	<?  } ?>
	
</div>
</div>
</div>


</form>



<div id="result"></div>



</div>

</div>


<script>
 function submitForm() {
    var sdate = $("#sdate").val();
    var edate = $("#edate").val();
    var shedule = $("#shedulee").val();
    
    // Use :checked selector to get selected checkboxes and map to their values
    var check_list = $("input[name='check_list[]']:checked").map(function(){
        return $(this).val();
    }).get();
	
    $.ajax({
        type: "POST",
        url: "asset_manage.php",
        data: {
            sdate: sdate,
            edate: edate,
            shedule: shedule,
            check_list: check_list
        },
		
        success: function(response) {
            $("#result").html(response);
        }
    });
}

</script>





<!--<script src="asset.js"></script>-->


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

document.getElementById('select-all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}




</script>

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