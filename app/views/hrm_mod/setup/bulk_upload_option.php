<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title="Employee Basic Information";
$head = '<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


?>



<?php
    
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {
  
		  $user_id = $_SESSION['user']['id'];
	
		  $first_reporting = $_POST['incharge_id'];
		  $second_reporting = $_POST['incharge_id_2'];
		
		  $display = $_POST['check_list'];
				   
          foreach ( $display as $key  ) {
				   

		  if($first_reporting>0)			
		  $sql = "UPDATE personnel_basic_info SET incharge_id = '$first_reporting',  entry_by = '$user_id' 
		  WHERE PBI_ID = '$key'";
		  $att_query1 = db_query($sql);
		  
		  
		  if($second_reporting>0)			
		  $sql = "UPDATE personnel_basic_info SET incharge_id_2 = '$second_reporting', entry_by = '$user_id' 
		  WHERE PBI_ID = '$key'";
		  $att_query1 = db_query($sql);
				
					
				
				   }



			
			if ($att_query1) {
				// Include SweetAlert script to display a success message
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
			}}

  ?>
  
  
  
  
  <?php
    
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["amendment"]) &&$_POST['t_date']!=''&&$_POST['f_date']!='' ) {
  
		  $user_id = $_SESSION['user']['id'];
	
		 $iom_type=$_POST['iom_type'];

		$iom_reason = $_POST['reason'] =$_POST['iom_reason'];
		
		$iom_entry_at=date('Y-m-d H:i:s');
		
		$iom_entry_by=$_SESSION['user']['id'];
		
		$s_date=($_POST['f_date']);
		
		$e_date=($_POST['t_date']);
		
		$iom_category = $_POST['iom_category'];
		
		
		
		$s_time=($_POST['s_time']);
		
		$e_time=($_POST['e_time']);
		
		
		
		$from_date=$_REQUEST['s_date']=strtotime($_POST['f_date']);
		
		$to_date=$_REQUEST['e_date']=strtotime($_POST['t_date']);


		
		  $display = $_POST['check_list'];
				   
          foreach ( $display as $key  ) {
				   



 'ID : '.$old_iom = find_a_field('hrm_att_summary','iom_sl_no',' att_date between "'.$_REQUEST['f_date'].'" and  "'.$_REQUEST['t_date'].'" and  
 emp_id="'.$key.'" and iom_sl_no>0');

' att_date between "'.$_REQUEST['s_date'].'" and  "'.$_REQUEST['e_date'].'" and  emp_id="'.$key.'" and iom_sl_no>0';







if($old_iom==0){

$from_dates = date_create($from_date);

$to_dates = date_create($to_date);

$diff = date_diff(date_create($s_date),date_create($e_date)); 

$total_days =  $diff->format("%a")+1;



if($_POST['iom_type']=='Early Half'){

	 $s_time = '08:30';

	 $e_time = '12:45';

	}elseif($_POST['iom_type']=='Last Half'){

		$s_time = '12:45';

		$e_time = '17:00';

		}elseif($_POST['iom_type']=='Full'){

		$s_time = '08:30';

		$e_time = '17:00';

		}







 $ssql = "INSERT INTO hrm_iom_info (`dept_head_status` ,`PBI_ID` ,`type` ,`s_date` ,`e_date` , `reason` ,`iom_category`,`total_days`,`s_time`,`e_time`,`iom_status`,`entry_at`)



VALUES (  'Approve', '".$key."', '".$_POST['iom_type']."',  '".$_POST['f_date']."', '".$_POST['t_date']."', '".$iom_reason."','".$iom_category."','".$total_days."', 
'".$s_time."' , '".$e_time."','GRANTED','".date('Y-m-d H:i:s')."')";

db_query($ssql);
$iom_sl_no=  mysqli_insert_id();

for($i=$from_date; $i<=$to_date; $i=$i+86400)

{

$att_date=date('Y-m-d',$i);

$found = find_a_field('hrm_att_summary','1','emp_id="'.$key.'" and att_date="'.$att_date.'"');
if($found==0)
{
$sql="INSERT INTO hrm_att_summary (emp_id, iom_type, iom_id, att_date,iom_start_time,iom_end_time,iom_entry_at,iom_entry_by,iom_category , iom_reason , dayname)

VALUES ('$key', '$iom_type', '$iom_sl_no','$att_date','$s_time','$e_time','$iom_entry_at','$iom_entry_by','$iom_category' , '$iom_reason' , dayname('".$att_date."'))";
$query=db_query($sql);

}else{

$sql='update hrm_att_summary set iom_type="'.$iom_type.'", iom_id="'.$iom_sl_no.'",iom_start_time="'.$s_time.'",iom_end_time="'.$e_time.'",
dayname=dayname("'.$att_date.'"),

iom_entry_at="'.$iom_entry_at.'", iom_entry_by="'.$iom_entry_by.'",iom_category="'.$iom_category.'"

where  emp_id="'.$key.'" and att_date="'.$att_date.'" ';

$query=db_query($sql); 

}} 

}

else echo $msggg= "<h2 style='color:#FF0000'>You Can't Add Duplicate IOM</h2>";



				
					
				
				   }



			
			if ($query) {
				// Include SweetAlert script to display a success message
				echo "<script>
					$(document).ready(function() {
						swal({
							title: 'Amendment Entry Successfully Complete.',
							text: 'You Follow The Right Step!',
							type: 'success',
							padding: '2em'
						});
					});
				</script>";
			}}

  ?>
  
  
   
  <?php
    
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["grace"]) &&$_POST['grace_date']!='') {
  

		$grace_date=($_POST['grace_date']);

		$in_grace_time=($_POST['in_grace_time']);
		
		$out_grace_time=($_POST['out_grace_time']);
		
	



		
		  $display = $_POST['check_list'];
				   
          foreach ( $display as $key  ) {
				   

			echo $sql='update hrm_att_summary set manual_in_grace="'.$in_grace_time.'" , manual_out_grace="'.$out_grace_time.'"
			
			where  emp_id="'.$key.'" and att_date="'.$grace_date.'" ';
			
			$query=db_query($sql); 

}





			
			if ($query) {
				// Include SweetAlert script to display a success message
				echo "<script>
					$(document).ready(function() {
						swal({
							title: 'Grace Entry Successfully Complete.',
							text: 'You Follow The Right Step!',
							type: 'success',
							padding: '2em'
						});
					});
				</script>";
			}
			
			}

  ?>
  
  
  <script>
  function updateEndDate() {
    var leaveType = document.getElementById('leaveType').value;
    var startDate = new Date(document.getElementById('startDate').value);
    var totalDaysInput = document.getElementById('totalDays');
    var totalDays;

    if (leaveType === 'Full') {
      totalDays = Math.floor(parseFloat(totalDaysInput.value)); // Round down for full days
    } else if (leaveType === 'Early Half') {
      totalDays = 0.5; // For half day, set total days to 0.5

    } else if (leaveType === 'Last Half') {
      totalDays = 0.5; // For half day, set total days to 0.5

    } else if (leaveType === 'first_qtr') {
      totalDays = 0.25; // For guitar leave, set total days to 0.25
    } else if (leaveType === 'second_qtr') {
      totalDays = 0.25; // For guitar leave, set total days to 0.25
    } else if (leaveType === 'third_qtr') {
      totalDays = 0.25; // For guitar leave, set total days to 0.25
    } else if (leaveType === 'fourth_qtr') {
      totalDays = 0.25; // For guitar leave, set total days to 0.25
    }

    totalDaysInput.value = totalDays;

    var endDate = new Date(startDate);

    if (leaveType !== 'Full') {
      endDate = startDate; // For half or guitar day, end date is the same as start date
    } else {
      endDate.setDate(startDate.getDate() + totalDays - 1);
    }

    document.getElementById('endDate').value = endDate.toISOString().split('T')[0];
  }
</script>


 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 <script src="timepicker.min.js"></script>


<form action="" method="post" enctype="multipart/form-data">



<div class="oe_view_manager oe_view_manager_current">
<? include('../../common/title_bar_new.php');?>
<div class="oe_view_manager_body">
 <div  class="oe_view_manager_view_list"></div>
          <div class="oe_view_manager_view_form">
          <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
          <div class="oe_form_container">
          <div class="oe_form">
              
              

<div class="main-wrapper">
<div class="page-wrapper">

<div class="row">
<div class="col-md-12">
<div class="table-responsive">   
  
 <div class="container-fluid  new-color pt-3 mb-3">
<div class="row m-0 p-0" style="zoom: 90%;">
<div class="col-sm-1 m-0 p-0">
<input type="submit" name="save" class="btn btn-success" value="Save"> <br>   
</div>
</div>
 </div>
 
 
 
 
 <!-- __________________  BULK LEAVE OPTION START _____________ -->
 <?php /*?><div class="container mt-4">
    <div class="card">

      <div class="card-header bg-info text-white">
        <h5 class="card-title text-center">Bulk Leave Information Entry</h5>
          <h5 class="card-title text-center"></h5>
      </div>

   
     
    
      <div class="card-body bg-custom">
     
          <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label text-right">Leave Type:</label>
            <div class="col-sm-4">
              <input name="PBI_ID" type="hidden" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" required value="<?= $_SESSION['employee_selected'] ?>" readonly="readonly" />

              <select name="type" id="type" class="form-control" required>
                <option value=""></option>
                <option value="1">Casual Leave (CL)</option>
                <option value="2">Sick Leave (SL)</option>
                <option value="3">Annual Leave (AL)</option>
                <!-- <option value="4">Marriage Leave (ML)</option> -->
                <option value="5">Maternity Leave (MLV)</option>
                <option value="6">Paternity Leave (PL)</option>
                <option value="7">Hajj Leave</option> 
                <option value="8"> Previlize Leave </option>
                <option value="9">Leave Without Pay (LWP)</option>
              </select>
            </div>



            <label for="Period_type" class="col-sm-2 col-form-label text-right">Period:</label>
            <div class="col-sm-4">
              <select name="half_or_full" id="leaveType" class="form-control" onchange="updateEndDate()" required>
                <option value=""></option>
                <option value="Full">Full</option>
                <option value="Early Half">1st Half</option>
                <option value="Last Half">2nd Half</option>
                <option value="first_qtr">1st Qtr</option>
                <option value="second_qtr">2nd Qtr</option>
                <option value="third_qtr">3rd Qtr</option>
                <option value="fourth_qtr">4th Qtr</option>
              </select>
            </div>
          </div>


          <div class="form-group row">
            <label for="s_date" class="col-sm-2 col-form-label text-right">Start Date:</label>
            <div class="col-sm-4">
              <input type="date" name="s_date" id="startDate" class="form-control" onchange="updateEndDate()" style="width:100px;" autocomplete="off" required />
            </div>
            <label for="total_days" class="col-sm-2 col-form-label text-right">Leave Days:</label>
            <div class="col-sm-4">
              <input type="number" step="0.25" name="total_days" id="totalDays" style="width:100px;" onchange="updateEndDate()" required="required" class="form-control" />
            </div>
          </div>






          <div class="form-group row">

            <label for="e_date" class="col-sm-2 col-form-label text-right">End Date:</label>
            <div class="col-sm-4">
              <input type="date" name="e_date" id="endDate" style="width:100px;" autocomplete="off" readonly="readonly" class="form-control" required />
            </div>


            <label for="total_days" class="col-sm-2 col-form-label text-right"> Desk Look After :</label>
            <div class="col-sm-4">
              <input type="text" list="incharge" name="leave_responsibility_name" id="leave_responsibility_name" class="form-control"  value="<? if ($incharge_id > 0) echo $incharge_id; ?>" />
              <datalist id="incharge">
                <option></option>

                <?
                foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_NAME, " - ", PBI_CODE)', $leave_responsibility_name, ' 1 order by PBI_NAME asc'); ?>

              </datalist>

            </div>
          </div>






          <div class="form-group row">
            <label for="reason" class="col-sm-2 col-form-label text-right" >Reason:</label>
            <div class="col-sm-4">
              <input type="text" name="reason" id="reason" class="form-control" required />
            </div>

            
             
             <div class="col-sm-2 offset-sm-2">


              <input name="search" type="submit" id="search" class="btn btn-danger" value="SUBMIT" />

            </div>
            

</td>
              </tr>

            </div>
            
            
            
            
          </div>
          
          
        
         
   

      </div>
    </div>
  </div>
  <?php */?>
  
  <!-- _________ BULK LEAVE OPTION END ___________-->
 
 
 <!--Bulk Grace time Start -->
 
 
 
 
 <div class="page-content page-container" id="page-content">
   <div class="padding">
    <div class="row">
      <div class="col-lg-12">
    
		
		
		
          <div class="card">
            <div class="card-header" style="color:#E16127;"><strong> Manual Grace Time </strong></div>
            <div class="card-body">
        
       <div class="form-row">
                <div class="form-group col-sm-4">
                  <label>Grace Date</label>
       <input type="date" name="grace_date" id="grace_date" class="form-control" autocomplete="off" value="<?=$grace_date?>">
                </div>
                <div class="form-group col-sm-4">
                  <label>In Grace Time</label>
  
	  
	  <input type="text" id="timeInput" name="in_grace_time" value="<?=$in_grace_time?>"  class="form-control" placeholder="hh:mm">
								  
								  
                </div>
                
                
                 <div class="form-group col-sm-4">
                  <label>Out Grace Time</label>


<input type="text" id="grace_time" name="out_grace_time" value="<?=$out_grace_time?>"  class="form-control" placeholder="hh:mm">

                </div>
                
                
              </div>
              
              

			
              
              
              
     <div class="text-right">
      <button name="grace" accesskey="S" class="btn btn-danger" type="submit"> <i class="fa-duotone fa-share-all"></i> Upload</button>
     </div>
              
              
                

            </div>
          </div>
     
      </div>
  
  
    </div>
</div></div>
 
 
 
 
 
 
 
 
 
 
 
 

<!--Balk Amendment option Start -->
 
 
  
 <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mx-auto mt-5" style="max-width: 600px;">
                <div class="card-header bg-success text-white text-center">
                    <h2 class="mb-0">Amendment Entry</h2>
                </div>
                <div class="card-body">
           
                        <div class="form-group row">
                            <label for="iom_type" class="col-sm-4 col-form-label text-right">Amendment Type:</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>">
                                <select name="iom_type" id="iom_type" class="form-control">
                                    <option></option>
                                    <option value="Full">Absent</option>
                                    <option value="Early Half">In Late</option>
                                    <option value="Last Half">Early Out</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="iom_reason" class="col-sm-4 col-form-label text-right">Reason:</label>
                            <div class="col-sm-8">
                                <input type="text" name="iom_reason" id="iom_reason" class="form-control" value="<?=$iom_reason?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="f_date" class="col-sm-4 col-form-label text-right">Date From:</label>
                            <div class="col-sm-8">
                                <input type="date" name="f_date" id="date" class="form-control" autocomplete="off" value="<?=$f_date?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_date" class="col-sm-4 col-form-label text-right">Date To:</label>
                            <div class="col-sm-8">
                                <input type="date" name="t_date" id="date" autocomplete="off" class="form-control" value="<?=$t_date?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8">
                            
                                <button type="submit" name="amendment" class="btn btn-primary">SUBMIT</button>
                            </div>
                        </div>
                 
                </div>
            </div>
        </div>
    </div>
</div>


<!--Balk Amendment option end -->
 
    
<table class="table table-bordered table-sm"> 
<thead class="bg-light">
<tr align="center" class="table-info">
<th>Mark</th>
<th>ID No</th>
<th>Emp Code</th>
<th>Employee Name</th>
<th>Designation</th>
<th>Department</th>
<th>DOJ</th>
<th>Grade</th>

<th>Section </th>  
<th>Work Station</th> 



<th>View</th>



</tr>
</thead>
<tbody>



<?

if(isset($_POST['button'])){

if($_POST['old_id']>0) $oldConn = " and a.old_id ='".$_POST['old_id']."'";

if($_POST['PBI_CODE']!="") $codeConn = " and a.PBI_CODE='".$_POST['PBI_CODE']."'";
if($_POST['PBI_ID']>0) $idConn = " and a.PBI_ID='".$_POST['PBI_ID']."'";
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
//if($_POST['level']>0) $levelConn = " and a.level='".$_POST['level']."'";

if($_POST['class']>0) $classConn = " and a.class='".$_POST['class']."'";
if($_POST['line']>0) $lineConn = " and a.line='".$_POST['line']."'";
if($_POST['incharge_id']>0) $inchargeConn = " and a.incharge_id='".$_POST['incharge_id']."'";
if($_POST['DOJ']>0) $DOJConn = " and a.PBI_DOJ='".$_POST['DOJ']."'";

 $user_id  =  $_SESSION['user']['id'];



if($user_id == 10073 || $user_id == 10074 || $user_id == 10108) $JOB_LOC_ID_BLOCK = " and a.JOB_LOC_ID !=3";



$sqld = 'select a.* from  personnel_basic_info a 
where 1 '.$codeConn.$idConn.$genderConn.$NameConn.$ReligionConn.$DOJConn.$OrgConn.$classConn.$gradeConn.$work_station.
$lineConn.$inchargeConn.$depConn.$desgConn.$secConn.$JoblocConn.$oldConn.$CostConn.$levelConn.$job_statusConn.$JOB_LOC_ID_BLOCK.' order by a.PBI_ID';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){



$m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';
$m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';
$entry_by=$data->entry_by;
$tot_ded = $data->other_deduction+$data->other_deductions;
$join_date_org = date('Y-m-d', strtotime($data->PBI_DOJ));
$join_date_diff = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($data->PBI_DOJ) ) ));
$joindate = date_parse_from_format("Y-m-d", $data->PBI_DOJ);
$joining_month =  $joindate["month"];
$joining_year =  $joindate["year"];
$deduction_days =$data->mtd-$data->pay;
$deduction_amt  =$data->gross_salary/$data->mtd;
$deduction_amttotal=$deduction_days*$deduction_amt;
?>

<tr>
<td style="width:50px"><input type="checkbox" style="width:50px" name="check_list[]" value="<?=$data->PBI_ID;?>"></td>
<td><?=$data->PBI_CODE;?></td>
<td><?=$data->PBI_ID;?></td>
<td><h2 class="table-avatar"><a href="#" onclick="submitForm('<?=$data->PBI_CODE?>')"><?=$data->PBI_NAME;?></span></a></h2></td>
<td class="text-center"><?=find_a_field('designation','DESG_DESC','DESG_ID="'.$data->DESG_ID.'"');?></td>
<td class="text-center"><?=find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');?></td>
<td> <?=date('d-M-Y',strtotime($data->PBI_DOJ))?> </td>
<td class="text-center"><?=find_a_field('hrm_grade','grade_name','id="'.$data->grade.'"');?></td>
<td class="text-center"><?=find_a_field('PBI_Section','sec_name','sec_id="'.$data->section.'"');?></td>
<td class="text-center"><?=find_a_field('hrm_workstation','work_station_name','station_id="'.$data->PBI_WORK_STATION.'"');?></td>

<td class="text-center"><span class="btn btn-warning btn-sm"><a href="#" onclick="submitForm('<?=$data->PBI_CODE?>')"><b>Open</b></a></span></td>


</tr>


<? } }?>

</tbody>
</table>

<div align="left">
	<input type="checkbox" class="form-check-input" id="select-all">
	<label for="checkbox"><span class="bg-danger text-white">Select All</span></label>
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
    </div>
  </div>
  </div>
</form>

 <script>
        $(document).ready(function(){
            $('#timeInput').timepicker({
                timeFormat: 'H:i',
                step: 1,
                scrollDefault: 'now'
            });
        });
    </script>
	
	   <script>
        $(document).ready(function(){
            $('#grace_time').timepicker({
                timeFormat: 'H:i',
                step: 1,
                scrollDefault: 'now'
            });
        });
    </script>
	
    
 
	

<script>
  // Get references to the input fields
  const startDateInput = document.getElementById('s_date');
  const endDateInput = document.getElementById('e_date');
  const daysInput = document.getElementById('total_days');

  // Attach event listeners to both date inputs
  startDateInput.addEventListener('input', calculateDays);
  endDateInput.addEventListener('input', calculateDays);

  // Function to calculate the number of days
  function calculateDays() {
    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);

    if (!isNaN(startDate) && !isNaN(endDate)) {
      const timeDiff = endDate - startDate;
      const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24) + 1);
      daysInput.value = daysDiff;
    } else {
      daysInput.value = ''; // Clear the days input if dates are invalid
    }
  }
</script>

  <script>

document.getElementById('select-all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}




</script>

<script>
    function submitForm(code) {
        // Create a form dynamically
        var form = document.createElement('form');
        form.action = 'employee_basic_information_nal.php';
        form.method = 'post';

        // Create an input field
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'employee_selected';
        input.value = code;

        // Append the input field to the form
        form.appendChild(input);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }
</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>