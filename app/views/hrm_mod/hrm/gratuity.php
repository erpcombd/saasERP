<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";


 
function calculateGratuity($basicSalary, $yearsOfService) {
    // Check if the employee is eligible for gratuity
    if ($yearsOfService <= 5) {
        //return "Not eligible for gratuity. Minimum 5 years of service required.";
    }

    // Constants for the calculation
    $halfMonthSalaryConsidered = 15;
    $avgDaysInMonth = 26;

    // Calculate gratuity
    $gratuity = ($basicSalary * $yearsOfService * $halfMonthSalaryConsidered) / $avgDaysInMonth;
    return $gratuity;
}




	
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Gratuity ';

$entry_by=$_SESSION['user']['id'];


//$PBI_ID=$_REQUEST['PBI_ID']; 
$entry_at=date('Y-m-d h:i:sa');


?>




<?  







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
   
    </div>
    <!-- END NEW SECTION-->
  
    <div class="container-fluid pt-5 p-0 ">
      <table class="table1  table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
          <tr class="bgc-info">
            
            <th>ID NO</th>
            <th>Full Name</th>
            <th>Designation</th>
            <th>Department</th>
		
            <th> Effective Date  </th>
			<th>Gratuity Amount</th>
            <th>  Action </th>
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
                            
                            if($_POST['section']>0) $secConn = " and a.section='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and a.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['cost_center']>0) $CostConn = " and a.cost_center='".$_POST['cost_center']."'";
                     
                            
                            if($_POST['class']>0) $classConn = " and a.class='".$_POST['class']."'";
                           
                            if($_POST['incharge_id']>0) $inchargeConn = " and a.incharge_id='".$_POST['incharge_id']."'";
							
                       
                            						
          
							

						   $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT,a.JOB_LOC_ID,a.PBI_DOJ, a.PBI_CODE,d.*
						   
						   
						   from 

							personnel_basic_info a,salary_info d

							where  a.PBI_ID=d.PBI_ID   ".$codeConn.$idConn.$genderConn.$NameConn.$ReligionConn.$DOJConn.$OrgConn.$classConn.$gradeConn.$work_station.
$lineConn.$inchargeConn.$depConn.$desgConn.$secConn.$JoblocConn.$CostConn.$levelConn.$job_statusConn.$shiftConn."  and 
a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";

							$query = db_query($sql);
						
							
							if (!$query) {  }
							
							while ($info = mysqli_fetch_object($query)) {
   
							
							
						

							?>
          <tr>
              
              	
		
			<td height="26"><?=$info->PBI_CODE?>
           <?php /*?>   <input type="hidden" name="PBI_ID_<?=$info->INCREMENT_D_ID?>" id="PBI_ID_<?=$info->INCREMENT_D_ID?>" value="<?=$info->PBI_ID?>" />
			  <input type="hidden" name="inc_id_<?=$info->INCREMENT_D_ID?>" id="inc_id_<?=$info->INCREMENT_D_ID?>" value="<?=$info->INCREMENT_D_ID?>" /><?php */?>
		    </td>
            <td><?=$info->PBI_NAME?></td>
            <td><?=$info->PBI_DESIGNATION?></td>
            <td><?=$info->PBI_DEPARTMENT?></td>
			<td> <? //=$info->INCREMENT_EFFECT_DATE;?> </td>
			
			
			<?php

        $joiningDate = $info->PBI_DOJ;
        $yearsOfExperience = (new DateTime())->diff(new DateTime($joiningDate))->y;
        $basicSalary = find_a_field('salary_info','basic_salary','PBI_ID="'.$info->PBI_ID.'"'); // Example basic salary plus DA
        $result = calculateGratuity($basicSalary, $yearsOfExperience);

?>
			
			
			
			
			<td><?php
            if (is_numeric($result)) {
                echo round($result);
            } else {
                echo "Not eligible for gratuity. Minimum 5 years of service required."; // Display the ineligibility message
            }
            ?></td> 
			
            <td><div>

            <form method="post">
                <input type="hidden" name="pbi_id" value="<?=$info->PBI_ID?>" />
                <input type="hidden" name="gratuity_amount" value="<?=$result?>" />
                <input type="hidden" name="entry_at" value="<?=$entry_at?>" />
                <input type="hidden" name="entry_by" value="<?=$entry_by?>" />
                <input type="submit" value="Approved" id="Approved" name="Approved" class="btn1 btn1-bg-submit" />
            </form>
            
            </td>
          </tr>
          <?  }   ?>
		
		
		   
        </tbody>
      </table>
  
    </div>
    <?  } ?>
    
    
    
  </form>
</div>



<?php
// Add gratuity insertion logic directly in the approval process
if(isset($_POST['Approved'])) {
    $pbi_id = $_POST['pbi_id'];
    $gratuity_amount = $_POST['gratuity_amount'];
    $entry_at = $_POST['entry_at'];
    $entry_by = $_POST['entry_by'];

    // Validate the data before insertion
    if ($pbi_id && is_numeric($gratuity_amount)) {
        // Prepare the SQL insertion query
        $insert_sql = "INSERT INTO gratuity_records 
                       (PBI_ID, gratuity_amount, entry_at, entry_by, status) 
                       VALUES 
                       ('$pbi_id', '$gratuity_amount', '$entry_at', '$entry_by', 'Approved')";
        
        // Execute the query
        $insert_result = db_query($insert_sql);
        
        if ($insert_result) {
            // Optional: Add a success message
            $success_message = "Gratuity record for employee $pbi_id has been successfully approved and recorded.";
        } else {
            // Optional: Add an error message
            $error_message = "Failed to insert gratuity record. Please try again.";
        }
    }
}
?>

<?php if(isset($success_message)): ?>
    <div class="alert alert-success"><?= $success_message ?></div>
<?php endif; ?>

<?php if(isset($error_message)): ?>
    <div class="alert alert-danger"><?= $error_message ?></div>
<?php endif; ?>



 
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
