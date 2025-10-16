<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';



//do_calander('#roster_date');
//do_calander('#s_date');
//do_calander('#e_date');

$title='Individual Holiday Setup';			// Page Name and Page Title




?>
<?  


if(isset($_POST['search']))
{

       
		
		
	$edit_by = $_SESSION['user']['id'];

	$edit_at = date('Y-m-d h:i:s');

	$job_location = $_POST['job_location'];


	
	$entry_by = $_SESSION['user']['id'];


	$reason=$_POST['reason'];
	
	$s_date= $_REQUEST['s_date'];
	$e_date= $_REQUEST['e_date'];

////////////////////////
$display = $_POST['check_list'];

foreach ( $display as $key  ) {




$start_d=strtotime($_POST['s_date']);
$end_d=strtotime($_POST['e_date']);
for($i=$start_d; $i<=$end_d; $i+=86400){
$holiday_date= date('Y-m-d',$i);

 $ins_query='INSERT INTO salary_holy_day_individual ( PBI_ID , holy_day, reason) 
VALUES ( "'.$key.'" , "'.$holiday_date.'", "'.$_POST['reason'].'")';
db_query($ins_query);





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
  
   <? include('../common/title_bar_bulk_upload.php');?>
   
     
    <!--  ******************* NEW SECTION  *********************-->
	  <?  	if(isset($_POST['button'])){ ?>
	  
    <div class="container-fluid bg-form-titel">
      <div class="row">
	  
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Start Date : </label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <input type="date" name="s_date" autocomplete="off" id="s_date" style="width:50%;" class="form-control" />
			
            </div>
          </div>
        </div>
		
		
		  <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> End Date : </label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
           
			  
			   <input type="date" name="e_date" autocomplete="off" id="e_date"  style="width:50%;" class="form-control" />
            </div>
          </div>
        </div>
		

		
		

		
		
		
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Reason : </label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <input type="text" name="reason" autocomplete="off" id="reason"  style="width:50%;" class="form-control" />
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
                     
                          
                            
                            
                            
                            if($_POST['PBI_ORG']>0) $OrgConn = " and a.PBI_ORG='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and a.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
                            
                        
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and a.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
                         
                     
                            
                            if($_POST['class']>0) $classConn = " and a.class='".$_POST['class']."'";
                          
                            if($_POST['incharge_id']>0) $inchargeConn = " and a.incharge_id='".$_POST['incharge_id']."'";
							
                          
							if($_POST['shedule']>0) $shiftConn = " and b.shedule_1 ='".$_POST['shedule']."'";
                            						
          
							

						   $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT,a.JOB_LOC_ID, a.PBI_CODE,
						   a.define_schedule,b.roster_date
						   
						   
						   from 

							personnel_basic_info a,hrm_roster_allocation b

							where  a.PBI_ID=b.PBI_ID   ".$codeConn.$idConn.$genderConn.$NameConn.$ReligionConn.$DOJConn.$OrgConn.$classConn.$gradeConn.$work_station.
$lineConn.$inchargeConn.$depConn.$desgConn.$secConn.$JoblocConn.$CostConn.$levelConn.$job_statusConn.$shiftConn."  and 
a.PBI_JOB_STATUS='In Service' GROUP BY a.PBI_ID  order by a.PBI_ID ";

							$query = db_query($sql);

							while($info=mysqli_fetch_object($query))

							{

							$rosterAllocation = find_all_field('hrm_roster_allocation','','PBI_ID="'.$info->PBI_ID.'" and roster_date="'.$_POST['fdate'].'"');

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
			
            <td> <?=find_a_field('hrm_schedule_info','schedule_name','id='.$shedule_1);?> </td>
  
             
                
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
