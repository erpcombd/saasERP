<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";



$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';



do_calander('#roster_date');

do_calander('#s_date');
do_calander('#e_date');

$title='Salary Adjustment';			// Page Name and Page Title




?>
<?  


if(isset($_POST['search']))
{

       
		
		
	$edit_by = $_SESSION['user']['id'];

	$edit_at = date('Y-m-d h:i:s');

	$job_location = $_POST['job_location'];

	$group_for = $_POST['group_for'];
	
	$entry_by = $_SESSION['user']['id'];


	$adjustment_reason = mysqli_real_escape_string($_POST['adjustment_reason']);
	$adjustment_amt = $_POST['adjustment_amt'];
	
	$adjustment_date = $_REQUEST['adjustment_date'];
	

////////////////////////
$display = $_POST['check_list'];

foreach ( $display as $key  ) {


//___________________ START ________________
//roster_start_date < "' . $s_date . '" AND
$sSql = 'SELECT id, PBI_ID FROM salary_adjustment WHERE PBI_ID="' . $key . '" AND adjustment_date between "'.$adjustment_date.'" and  "'.$adjustment_date.'"';
$sQuery = db_query($sSql);
$sData = mysqli_fetch_object($sQuery);

if ($sData->id > 0) {

     $upSql = 'UPDATE salary_adjustment 
    SET  adjustment_date = "'.$adjustment_date.'",  adjustment_amt = "'.$adjustment_amt.'" , adjustment_reason= "'.$adjustment_reason.'"
	
	edit_at="' . $edit_at . '", edit_by = "' . $edit_by . '" WHERE id=' . $sData->id;
    db_query($upSql);


    
    
	
	
} else {

	 
	
        $att_sql = "INSERT INTO salary_adjustment (PBI_ID,adjustment_amt,adjustment_date,adjustment_reason,entry_by) 
        VALUES ('$key','$adjustment_amt', '$adjustment_date' , '$adjustment_reason','$entry_by')";
        $att_query = db_query($att_sql);
        
      
 
 
}


}

}








?>
<style type="text/css">

<!--

.style1 {

	color: #FFFFFF;

	font-weight: bold;

}

-->

</style>
<!--Three input table-->
<div class="form-container_large">
 
  <form action="?"  method="post">
  
   <? include('../common/title_bar_shift_assign.php');?>
   
     
    <!--  ******************* NEW SECTION  *********************-->
	  <?  	if(isset($_POST['button'])){ ?>
	  
    <div class="container-fluid bg-form-titel">
      <div class="row">
	  
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Adjustment Date : </label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <input type="text" name="adjustment_date" autocomplete="off" id="s_date" style="width:50%;" class="form-control" />
			  
            </div>
          </div>
        </div>
		

        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <div class="form-group row m-0">
  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Adjustment Amount : </label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
               <input type="text" name="adjustment_amt"  id="adjustment_amt" style="width:50%;" class="form-control" />
            </div>
          </div>
        </div>
		
		
		    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <div class="form-group row m-0">
  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Remarks : </label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
               <input type="text" name="adjustment_reason"  id="adjustment_reason" style="width:50%;" class="form-control" />
            </div>
          </div>
        </div>
		
		
		
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <input name="search" id="search" value="Apply" type="submit" class="btn btn-danger">
        </div>
      </div>
    </div>
    <!-- END NEW SECTION-->
  
    <div class="container-fluid pt-5 p-0 ">
      <table class="table1  table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
          <tr class="bgc-info">
            
            <th style="width:50px;text-align:center">Mark</th>
            <th>ID NO</th>
            <th>Full Name</th>
            <th>Designation</th>
            <th>Department</th>
		
            <th> Job Location  </th>
            <th>  Shift </th>
            
          </tr>
        </thead>
        <tbody class="tbody1">
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
							if($_POST['shedule']>0) $shiftConn = " and a.define_schedule ='".$_POST['shedule']."'";
                            						
          
							

						   $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT,a.JOB_LOC_ID, a.PBI_CODE,a.define_schedule
						   
						   
						   from 

							personnel_basic_info a

							where  1 ".$codeConn.$idConn.$genderConn.$NameConn.$ReligionConn.$DOJConn.$OrgConn.$classConn.$gradeConn.$work_station.
$lineConn.$inchargeConn.$depConn.$desgConn.$secConn.$JoblocConn.$CostConn.$levelConn.$job_statusConn.$shiftConn."  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";

							$query = db_query($sql);

							while($info=mysqli_fetch_object($query))

							{

							$rosterAllocation = find_all_field('hrm_roster_allocation','','PBI_ID="'.$info->PBI_ID.'" and roster_date="'.$_POST['roster_date'].'"');

							$point_1 = $rosterAllocation->point_1;

							$shedule_1 = $rosterAllocation->shedule_1;
							
						

							?>
          <tr>
              
              	
		
			<td style="width:50px"><input type="checkbox" style="width:50px" name="check_list[]" value="<?=$info->PBI_ID;?>"></td>
             			
						
            <td><?=$info->PBI_CODE?>
              <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>
            <td><?=$info->PBI_NAME?></td>
            <td><?=$info->PBI_DESIGNATION?></td>
            <td><?=$info->PBI_DEPARTMENT?></td>
			
			<!-- <td> <?=$rosterAllocation->roster_date?></td> -->
			
			
			<td> <?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$info->JOB_LOC_ID);?> </td>
			
            <td> <?=find_a_field('hrm_schedule_info','schedule_name','id='.$info->define_schedule);?> </td>
  
             
                
          </tr>
          <?  }   ?>
		
		
		   <tr>
    <td style="width:50px" colspan="2" align="center">
        <input type="checkbox" class="form-check-input" id="select-all">
        <label for="select-all"><span class="bg-danger text-white">Mark All</span></label>
    </td>

    <td colspan="5"> <!-- Adjust the colspan value as needed -->
        <!-- Content for the fifth column goes here -->
    </td>
</tr>
						  
									  
        </tbody>
      </table>
  
    </div>
    <?  } ?>
    
    
    
  </form>
</div>

  <script>

document.getElementById('select-all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}




</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
