<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title="Shift Schedule";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
    //ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

?>



<script src="sweetalerts/sweetalert2.min.js"></script>
<script src="sweetalerts/promise-polyfill.js"></script>
<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />



<link rel="stylesheet" href="assets/css/line-awesome.min.css">
<link rel="stylesheet" href="assets/css/material.css">

<link rel="stylesheet" href="assets/css/select2.min.css">

<style>
    .new-color {
        background-color: #E3F1FD !important;
    }
</style>

  <style>
    .bg-custom {
      background-color: #ffcccb; /* Set your desired background color */
    }
  </style>
  
  
</head>
<body>

<div class="main-wrapper">

<div class="page-wrapper">
<div class="content container-fluid"> 

<?php
session_start();
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    // Process the form data as before

    // Store the selected IDs in the session
    $_SESSION['selected_ids'] = $_POST['check_list'];
    
    // Get the form data
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $shedulee = $_POST['shedulee'];
    $check_list = $_POST['check_list'];

    
    
    // Process the data (this is where you would add the asset_manage.php functionality)
    if(!empty($sdate) && !empty($edate) && !empty($shedulee) && !empty($check_list)) {
        $entry_by = $_SESSION['user']['id'];
        
        foreach($check_list as $key) {
            for($i=date('Y-m-d',strtotime($sdate)); $i<=date('Y-m-d',strtotime($edate)); $i = date('Y-m-d', strtotime($i . " +1 days"))) {
                // Delete existing record if any
                $del_sql = "DELETE FROM hrm_roster_allocation WHERE PBI_ID='".$key."' AND roster_date = '".$i."'";
                db_query($del_sql);
                
                // Insert new record
                $insSql = "INSERT INTO hrm_roster_allocation(PBI_ID, roster_date, shedule_1, job_location, group_for, entry_by) 
                           VALUES ('".$key."', '".$i."', '".$shedulee."', '".$_POST['job_location']."', '".$_POST['group_for']."', '".$entry_by."')";
                $result_new = db_query($insSql);
            }
        }
        
        if(isset($result_new)) {
            echo "<script>
                $(document).ready(function() {
                    swal({
                        title: 'Shift Successfully Changed.',
                        text: 'You Follow The Right Step!',
                        type: 'success',
                        padding: '2em'
                    });
                });
              </script>";
        }
    } else {
        echo "<script>
            $(document).ready(function() {
                swal({
                    title: 'Missing Information',
                    text: 'Please fill all required fields!',
                    type: 'error',
                    padding: '2em'
                });
            });
          </script>";
    }
}

// Retrieve the selected IDs from the session (or initialize an empty array if not set)
 $selected_ids = isset($_SESSION['selected_ids']) ? $_SESSION['selected_ids'] : [];
?>

<?  

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update']) ) {

		$fdatenew = $_POST['fdate'];
		$tdatenew = $_POST['tdate'];
		
		$fdateRoster =  date('Y-m-d',strtotime($fdatenew));
		$tdateRoster =  date('Y-m-d',strtotime($tdatenew));
		

	
		$entry_by = $_SESSION['user']['id'];
		
		$display = $_POST['check_list'];

		foreach ( $display as $key  ) {
		
		for($i=$fdateRoster;$i<=$tdateRoster;$i = date('Y-m-d', strtotime( $i . " +1 days"))){ 
		
		$shedule = $_POST['s_'.$key.'_'.$i];
	

	    $del_sql = "delete from hrm_roster_allocation where PBI_ID='".$key."' and roster_date = '".$i."'";
		db_query($del_sql);
		
		
		  $insSql = 'INSERT INTO hrm_roster_allocation( PBI_ID, roster_date,  shedule_1, job_location,group_for, entry_by) 
		 VALUES ("'.$key.'", "'.$i.'",  "'.$shedule.'", "'.$_POST['job_location'].'", "'.$_POST['group_for'].'", "'.$entry_by.'")';
		$result_new = db_query($insSql);
		
	
		} 
		}
		
			if ($result_new) {
			
			    echo "<script>
                $(document).ready(function() {
                    swal({
                        title: 'Shift Successfully Changed.',
                        text: 'You Follow The Right Step!',
                        type: 'success',
                        padding: '2em'
                    }).then(function() {
                        // Trigger form submission
                       
                        document.getElementById('button-addon1').click();
                    });
                });
              </script>";
              
			}
		
		
		}
?>

<form  method="post" id="employeeForm" onSubmit="return validateDate()">


<div class="container-fluid pt-1 pb-1"><? include('../common/title_bar_shift.php');?></div>



<!--
<div class="container-fluid pt-4 pb-4 mb-3 new-color">
    <div class="row p-0 m-0" >
    


    

      <div class="col-md-4 form-group">
      <label class="label" for="update"> Update For Individual Shift  </label><br>

	 <input type="submit" name="update" id="update" class="btn btn-primary"  value="Update">

	  
    </div>                           

    
        
    <div class="col-md-2 form-group">
      <label class="label" for="sdate">  Shift Change From Date</label>
      <input type="date" name="sdate" autocomplete="off" id="sdate" value="<?=$_POST['sdate']?>"  class="form-control" />
                                          
    </div>
    
        
    <div class="col-md-2 form-group">
      <label class="label" for="edate"> Shift Change To Date </label>
      <input type="date" name="edate" autocomplete="off" id="edate"  value="<?=$_POST['edate']?>"  class="form-control" />
                                          
    </div>
									
							<div class="col-md-2 form-group">
							  <label class="label" for="shedulee"> Shift </label>
														  <select name="shedulee" id="shedulee" value="<?=$_POST_["shedulee"];?>">
														<option></option>
													 
														<? foreign_relation('hrm_schedule_info', 'id', 'CONCAT(schedule_name, "-", acronyms)', $shedulee, '1'); ?>
										
													  </select>
    </div>
    
        
    <div class="col-md-2 form-group">
      <label class="label" for=" "> Make Change </label><br>
 
	  <input type="submit" name="save" id="save" class="btn btn-danger" onClick="submitForm()" value="Save">
	  
    </div>
	
	
	
	
	
    

</div>
</div>-->


  <div class="card">
    <div class="card-body bg-custom">
      <div class="row p-0 m-0">
        <div class="col-md-4 form-group bg-custom">
          <label class="label" for="update"> Update For Individual Shift </label><br>
          <input type="submit" name="update" id="update" class="btn btn-primary" value="Update">
        </div>

        <div class="col-md-2 form-group">
          <label class="label" for="sdate"> Shift Change From Date</label>
          <input type="date" name="sdate" autocomplete="off" id="sdate" value="<?=$_POST['sdate']?$_POST['sdate']:date('Y-m-d');?>" class="form-control" />
        </div>

        <div class="col-md-2 form-group">
          <label class="label" for="edate"> Shift Change To Date </label>
          <input type="date" name="edate" autocomplete="off" id="edate" value="<?=$_POST['edate']?$_POST['edate']:date('Y-m-d');?>" class="form-control" />
        </div>

        <div class="col-md-2 form-group">
          <label class="label" for="shedulee"> Select Shift </label>
          <select name="shedulee" id="shedulee" value="<?=$_POST_["shedulee"];?>">
            <option></option>
            <? foreign_relation('hrm_schedule_info', 'id', 'CONCAT(acronyms, "-", schedule_name)', $shedulee, '1'); ?>
          </select>
        </div>

        <div class="col-md-2 form-group">
          <label class="label" for=" "> Save To Make Change </label><br>
          <input type="submit" name="save" id="savemood" class="btn btn-danger" value="Save">
        </div>
      </div>
    </div>
  </div>



<div class="row">
<div class="col-lg-12">
<div class="table-responsive">
<table class="table1  table-striped table-bordered table-hover table-sm">
<thead class="thead1">


<?  

        $fdate = $_POST['fdate'];
		$tdate = $_POST['tdate'];
		
		$fdate =  date('Y-m-d',strtotime($fdate));
		$tdate =  date('Y-m-d',strtotime($tdate));
		


	


  //if( isset($_POST['button']) ||  isset($_POST['save'])){
  
  
?>






<tr style="background-color:#18a318; color:#FFFFFF">
<th style="width:50px;text-align:center;background-color:#18a318; color:#FFFFFF">Mark</th>
<th style="width:50px;text-align:center;background-color:#18a318; color:#FFFFFF">SL</th>
<th style="background-color:#18a318; color:#FFFFFF">ID</th>
<th style="background-color:#18a318; color:#FFFFFF; ">Employee</th>
<th style="background-color:#18a318; color:#FFFFFF">Weekend</th>
<th style="background-color:#18a318; color:#FFFFFF; padding:14px;">Shift</th>

<? for($i=$fdate;$i<=$tdate;$i = date('Y-m-d', strtotime( $i . " +1 days"))){ 

?>


<th style="background-color:<?= date('D', strtotime($i)) === 'Fri' ? '#FF0000' : '#18a318'; ?>; color:#FFFFFF; width:120px;">
    <?= date('F D j', strtotime($i)); ?>
</th>


<? } ?>




</tr>

</thead>

<tbody class="tbody1">





      <?
	    
	    
	                 
	                       
	                        
	                        if($_POST['PBI_CODE']!="") $codeConn = " and a.PBI_CODE='".$_POST['PBI_CODE']."'";
                            if($_POST['PBI_IDD']!="") $idConn = " and a.PBI_ID ='".$_POST['PBI_IDD']."'";
							
							//if($_POST['weekend_day']!="") $weekendConn = " and a.define_offday_id ='".$_POST['weekend_day']."'";
                          
                            if($_POST['PBI_NAME']!="") $NameConn = " and a.PBI_NAME='".$_POST['PBI_NAME']."'";
                            if($_POST['DESG_ID']>0) $desgConn = " and a.DESG_ID='".$_POST['DESG_ID']."'";
                            if($_POST['DEPT_ID']>0) $depConn = " and a.DEPT_ID='".$_POST['DEPT_ID']."'";
                     
                            
                            if($_POST['PBI_ORG']>0) $OrgConn = " and a.PBI_ORG='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and a.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
							
							//if($_POST['unit_id']>0) $unitConn = " and a.unit_id='".$_POST['unit_id']."'";
							//if($_POST['sub_unit_id']>0) $subUnitConn = " and a.sub_unit_id='".$_POST['sub_unit_id']."'";
                            
                            //if($_POST['section']>0) $secConn = " and a.sub_dept_id='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and a.JOB_LOCATION='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['shedule']>0) $shift = " and a.define_schedule = '".$_POST['shedule']."'";
							if($_POST['tdate']>0) $tdate = $_POST['tdate'] ; 
                            						
		
		$show=1; 
		 if( isset($_POST['button']) ||  isset($_POST['save'])  ){ 	

			//if($_POST['DEPT_ID']==32){ echo 'Have to select Section must!!';}else{

          $blank_delete = "delete from hrm_roster_allocation where shedule_1=0";
		  db_query($blank_delete);
		 
		 $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_CODE,g.DESG_DESC as PBI_DESIGNATION,d.DEPT_DESC as PBI_DEPARTMENT,
		  a.define_schedule,a.Friday,a.Saturday
		from personnel_basic_info a,department d,designation g
		where  1
		".$codeConn.$idConn.$genderConn.$NameConn.$unitConn.$DOJConn.$weekendConn.$OrgConn.$classConn.$subUnitConn.$work_station.
$lineConn.$depConn.$desgConn.$secConn.$JoblocConn.$CostConn.$levelConn.$job_statusConn.$shift." and a.DEPT_ID=d.DEPT_ID and
a.DESG_ID=g.DESG_ID and a.PBI_JOB_STATUS='In Service'  order by a.PBI_ID ";
		
		$query = db_query($sql);
		
		$daysMapping = [
						1 => "Friday",
						2 => "Saturday",
						3 => "Sunday",
						4 => "Monday",
						5 => "Tuesday",
						6 => "Wednesday",
						7 => "Thursday"
					];
		
		
		$sl=0;
		while($info=mysqli_fetch_object($query))
		{
		   $sl++;
		
		$rp2_date = $fdate;
		 	//Roster Alocation
   	    $ros = "select * from hrm_roster_allocation  where PBI_ID='".$info->PBI_ID."' and roster_date between '".$_POST['fdate']."' and '".$_POST['tdate']."' ";
		
		 $ros_r = db_query($ros);
		 while($roster = mysqli_fetch_object($ros_r)){
         
		 $shedule[$roster->PBI_ID][$roster->roster_date]=$roster->shedule_1;
		  
		     
		 }
		
			 	//Roster Assign 
	    //echo $query_assign = "SELECT * FROM hrm_roster_assign   WHERE PBI_ID = '" . $info->PBI_ID . "' AND  roster_end_date > '" . $_POST['tdate'] . "'";
		
		 //$ros_assign = mysql_query($query_assign);
		 //while($assign_roster = mysql_fetch_object($ros_assign)){
         
		 //echo $assign[$assign_roster->PBI_ID] = $assign_roster->shedule_1;

		
		//}
		
		
		?>
		
		
          
		    
		    
		    
		
		<tr>
		

<td style="width:50px">
  <span id="11d"></span>
    <input type="checkbox" style="width:50px" name="check_list[]" value="<?=$info->PBI_ID;?>" <?php echo in_array($info->PBI_ID, $selected_ids) ? 'checked' : ''; ?>>
</td>

		
      <td>
      <?=$sl?>
      </td>
      <td><?=$info->PBI_CODE?>
       
      </td>
      <td><?=$info->PBI_NAME?></td>
      <td><? 
	  
        $offdayId = $info->define_offday_id ?? ''; // fallback if not set
        $offdayName = $daysMapping[$offdayId] ?? 'Not Defined';
		echo $offdayName;
      
	   
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
	  
	   <select name="s_<?=$info->PBI_ID?>_<?=$i?>" id="s_<?=$info->PBI_ID?>_<?=$i?>"  style="color: #FF5722;width:70px !important;">
          <option></option>
          <? foreign_relation('hrm_schedule_info','id','acronyms',$shedule[$info->PBI_ID][$i]);?>
        </select>
		
		<?  }else {  ?>  
		
		
		     <? 
		    
	 
		    $sql = "SELECT * FROM hrm_roster_assign WHERE '$i' BETWEEN roster_start_date AND roster_end_date and PBI_ID='".$info->PBI_ID."'";
            $ros_assign = db_query($sql);
            
            $num_rows = mysqli_num_rows($ros_assign);
            
            if ($num_rows > 0) {
           
                
                
		    while($assign_roster = mysqli_fetch_object($ros_assign)){
            
            $assign[$assign_roster->PBI_ID][$i] = $assign_roster->shedule_1;
            
           
		    ?>
		 
		   <select name="s_<?=$info->PBI_ID?>_<?=$i?>" id="s_<?=$info->PBI_ID?>_<?=$i?>" style="width:120px;">
            <option></option>
            <? foreign_relation('hrm_schedule_info','id','acronyms', $assign[$info->PBI_ID][$i]);?>
           </select>
           
		  
		    
		  
			
		    
		 
		    
		    
		
		<?  } }else{   ?>
		
		
		
		    <select name="s_<?=$info->PBI_ID?>_<?=$i?>" id="schedule" style="width:120px;"> 
			  <option></option>
			  <? foreign_relation('hrm_schedule_info','id','acronyms',$info->define_schedule);?>
			</select>
		
		
		
		<?  }} ?>
		
		
		

      </td>
	    <?    } ?>
	

		
		
    </tr>
	
	 <?	} }  //} ?>   


</tbody>
</table>

 	<div align="left">
	<input type="checkbox" class="form-check-input" id="select-all"><label for="checkbox"><span class="bg-danger text-white">Select All</span></label></div>
	<?  //} ?>
	
</div>
</div>
</div>


</form>





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


<!-- JavaScript code -->
<script>

// Remove the submitForm function since we're handling the form submission directly in PHP

function validateForm() {
    // Check if the required fields have data
    var sdateValue = document.getElementById('sdate').value;
    var edateValue = document.getElementById('edate').value;
    var sheduleeValue = document.getElementById('shedulee').value;
    var checkListValue = document.querySelector('input[name="check_list[]"]:checked');

    // Build the alert message based on missing fields
    var alertMessage = '';
    if (!sdateValue) alertMessage += 'Shift Change From Date is required.\n';
    if (!edateValue) alertMessage += 'Shift Change To Date is required.\n';
    if (!sheduleeValue) alertMessage += 'Shift is required.\n';
    if (!checkListValue) alertMessage += 'At least one employee must be selected.\n';

    // Display the alert message
    if (alertMessage) {
        alert('Please fill in the following required fields:\n\n' + alertMessage);
        return false;
    }
    return true;
}

function validateDate() {
    // Your existing date validation code
    var inputDate = document.getElementById("sdate").value;
    var dateParts = inputDate.split("-");
    var year = parseInt(dateParts[0]);
    var month = parseInt(dateParts[1]);
    var day = parseInt(dateParts[2]);

    if (isNaN(year) || isNaN(month) || isNaN(day) || month < 1 || month > 12 || day < 1 || day > 31 || year < 2023 || year > 9999) {
        alert("Invalid date format or year. Please enter a valid date in Shift Change From Date");
        return false;
    }

    var dateObject = new Date(year, month - 1, day);
    if (dateObject.getFullYear() !== year || dateObject.getMonth() !== month - 1 || dateObject.getDate() !== day) {
        alert("Invalid date. Please enter a valid date.");
        return false;
    }

    return true;
    
    
    var inputDate = document.getElementById("edate").value;
    var dateParts = inputDate.split("-");
    var year = parseInt(dateParts[0]);
    var month = parseInt(dateParts[1]);
    var day = parseInt(dateParts[2]);

    if (isNaN(year) || isNaN(month) || isNaN(day) || month < 1 || month > 12 || day < 1 || day > 31 || year < 2023 || year > 9999) {
        alert("Invalid date format or year. Please enter a valid date in Shift Change To Date");
        return false;
    }

    var dateObject = new Date(year, month - 1, day);
    if (dateObject.getFullYear() !== year || dateObject.getMonth() !== month - 1 || dateObject.getDate() !== day) {
        alert("Invalid date. Please enter a valid date.");
        return false;
    }

    return true;
    
}

// Add select all functionality
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="check_list[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    }
});
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
        /*$(document).ready(function() {
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
        });*/
    </script>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>