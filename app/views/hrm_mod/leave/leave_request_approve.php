<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//__________________________  Fractional Calculate method Function ______________
function roundToQuarter($number)
{
  $integerPart = floor($number);
  $fractionalPart = $number - $integerPart;

  if ($fractionalPart >= 0.0 && $fractionalPart <= 0.24) {
    $roundedFractionalPart = 0.0;
  } elseif ($fractionalPart >= 0.25 && $fractionalPart <= 0.49) {
    $roundedFractionalPart = 0.25;
  } elseif ($fractionalPart >= 0.5 && $fractionalPart <= 0.74) {
    $roundedFractionalPart = 0.5;
  } elseif ($fractionalPart >= 0.75 && $fractionalPart <= 0.99) {
    $roundedFractionalPart = 0.75;
  } else {
    // Handle invalid input or out-of-range fractional parts here
    return false;
  }

  return $integerPart + $roundedFractionalPart;
}

//__________________________ END  Fractional Calculate method Function ______________

// ::::: Edit This Section ::::: 
$title = 'Leave Information';     // Page Name and Page Title
$page = "leave_entry.php";    // PHP File Name
$root = 'leave';
$table = 'hrm_leave_info';
$unique = 'id';
$shown = 's_date';
// ::::: End Edit Section :::::


$crud      = new crud($table);

if(isset($_GET[$unique]))
$$unique = $_GET[$unique];
else
$$unique = $_POST[$unique];


$u_id=$_SESSION['user']['id'];

$leave_id = find_all_field('hrm_leave_info','','id='.$_REQUEST['id']);


$emp_code =  $leave_id->PBI_ID;

$emp = find_all_field('personnel_basic_info', 'concat(PBI_NAME,"-",PBI_ID)', 'PBI_ID=' . $emp_code);

$essentialInfo = find_all_field('personnel_basic_info', '', 'PBI_ID='.$emp_code);




// LEAVE BALANCE CHECKER



$g_s_date = date('Y-01-01');
$g_e_date = date('Y-12-31');

$leave_rule_check = find_all_field('hrm_leave_rull_manage_individual', '', 'PBI_ID="'.$emp_code.'"');




if($leave_rule_check->PBI_ID>0){
    
$leave_rule = find_all_field('hrm_leave_rull_manage_individual', '', 'PBI_ID="'.$emp_code.'"');    
    
}else{

$leave_rule = find_all_field('hrm_leave_rull_manage', '', '1');    
    
    
}





 $annual_leave_opening = find_a_field('annual_leave_balance', 'BALANCE', 'PBI_ID="' .$emp_code. '"');
 $annual_leave_earn = find_a_field('hrm_att_summary', 'sum(annual_leave)', 'emp_id="' .$emp_code. '" and att_date BETWEEN 
 "' . $g_s_date . '"  and "' . $g_e_date . '" ');

$final_annual_earn = roundToQuarter($annual_leave_earn / 18);
$total_annual_allocated = ($annual_leave_opening+$final_annual_earn);



$joiningdate = find_a_field('personnel_basic_info', 'PBI_DOJ', 'PBI_ID=' . $emp_code);
$g_e_datee = date('Y-12-31');
$start = strtotime($joiningdate);
$end = strtotime($g_e_datee);
$days_between = ceil(abs($start - $end) / 86400);



if (prevent_multi_submit()) {

  

  if (isset($_POST[$shown]) && $emp_code >0 && isset($_POST['search'])) {

    $$unique = $_POST[$unique];
	
    $_POST['entry_at'] = date('Y-m-d H:i:s');
    $_POST['leave_status'] = 'GRANTED';
    $_POST['incharge_status'] = 'Approve';
	$_POST['reporting_auth'] = $essentialInfo->incharge_id;
    $s_date = strtotime($_REQUEST['s_date']);
    $e_date = strtotime($_REQUEST['e_date']);
	$_REQUEST['total_days'] = $_POST['total_days'];
	
	

 
 


    $lv_days_casual = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=1 and leave_status="GRANTED" and s_date between "' . $g_s_date . '" and "' . $g_e_date . '" and PBI_ID=' .$emp_code);
    $lv_days_sick   = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=2 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$emp_code);
    $lv_days_annual   = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=3 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$emp_code);
    $lv_days_marrage  = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=4 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$emp_code);
    $lv_days_maternity  = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=5 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$emp_code);
    $lv_days_paternity  = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=6 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$emp_code);
    $hj_days = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=7 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '" and PBI_ID=' .$emp_code);
    $old_leave = find_a_field('hrm_att_summary', 'leave_id', 'leave_id>0 and att_date between "' . $_POST['s_date'] . '" and  "' . $_POST['e_date'] . '" and  
	emp_id="' .$emp_code. '"');



  

    //___________ !!!!!!!!  __  Fractional LEAVE BALANACE ____________!!!!!!!!!!!!!!!!!!!!!!!!!!

    $joiningdate = find_a_field('personnel_basic_info', 'PBI_DOJ', 'PBI_ID=' .$emp_code);
    $g_e_datee = date('Y-12-31');
    $start = strtotime($joiningdate);
    $end = strtotime($g_e_datee);
    $days_between_pre = ceil(abs($start - $end) / 86400);
    
    $joiningYear = date('Y', strtotime($joiningdate));
	$currentYear = date('Y');


   	if ($joiningYear < $currentYear && $days_between_pre >= 365) {
      $total_casual = $leave_rule->CL;
      $total_MED = $leave_rule->MED;
       $total_ANU = $total_annual_allocated; 
      $total_ML = $leave_rule->ML;
      $total_hajj_lv = $leave_rule->HL;
      $total_hajj_lv = $leave_rule->PL;
	  
   }elseif($joiningYear < $currentYear && $days_between_pre < 365){
	   $total_casual = $leave_rule->CL;
       $total_MED = $leave_rule->MED;
       $total_ML = $leave_rule->ML;	
		
    } else {

      $total_casual =  roundToQuarter($leave_rule->CL / 360 * $days_between);
      $total_MED =  roundToQuarter($leave_rule->MED / 360 * $days_between);
      $total_ANU = 0; // roundToQuarter($annual_leave / 18);
      $total_ML = roundToQuarter($leave_rule->ML / 360 * $days_between);
      $total_hajj_lv = $leave_rule->HL;
      $total_hajj_lv = $leave_rule->PL;
    }
    //""""""""""""""""""""" END DYNAMIC BALANCE CHACKEr """""""""""""""""""




    if ($old_leave > 0) {
      $msggg = "<h4 class='alert alert-danger'>You Can't Add Duplicate Leave</h4>";
    } elseif (($_POST['type'] == 1) && (($lv_days_casual + $_POST['total_days']) > $total_casual)) {
      $msggg = "<h4 class='alert alert-danger'> You Can't apply Casual Leave (CL) more than the limit </h4>";
    } elseif (($_POST['type'] == 1) && (($lv_days_casual + $_POST['total_days']) > $total_casual)) {
      $msggg = "<h4 class='alert alert-danger'>Your Casual Leave (CL) already completed </h4>";
    } elseif (($_POST['type'] == 2) && ($_POST['total_days']) > $total_MED) {
      $msggg = "<h4 class='alert alert-danger'>You Can't apply Sick Leave (SL) more than the limit</h4>";
    } elseif (($_POST['type'] == 2) && (($lv_days_sick + $_POST['total_days']) > $total_MED)) {
      $msggg = "<h4 class='alert alert-danger'>Your Sick Leave (SL) already completed </h4>";
    } 
	  
	  elseif (($_POST['type'] == 3) && ($_POST['total_days']) > $total_ANU) {
      $msggg = "<h4 class='alert alert-danger'>You Can't apply Annual Leave (SL) more than the limit</h4>";
    } 
	  
	  elseif (($_POST['type'] == 3) && (($lv_days_annual + $_POST['total_days']) > $total_ANU)) {
      $msggg = "<h4 class='alert alert-danger'>Your Annual Leave (AL) already completed </h4>";
    } 
	  
	  elseif (($_POST['type'] == 4) && ($_POST['total_days']) > $leave_rule->ML) {
      $msggg = "<h4 class='alert alert-danger'>You Can't apply Marriage Leave (ML) more than the limit</h4>";
    } 
	  
	  elseif (($_POST['type'] == 4) && (($lv_days_marrage + $_POST['total_days']) > $leave_rule->ML)) {
      $msggg = "<h4 class='alert alert-danger'>Your Marriage Leave (ML) already completed </h4>";
    } 
	  
	  elseif (($_POST['type'] == 5) && ($_POST['total_days']) > $leave_rule->MTR) {
      $msggg = "<h4 class='alert alert-danger'>You Can't apply Maternity Leave (MLV) more than the limit</h4>";
    } 
	  
	  elseif (($_POST['type'] == 5) && (($lv_days_maternity + $_POST['total_days']) > $leave_rule->MTR)) {
      $msggg = "<h4 class='alert alert-danger'>Your Maternity Leave (MLV) already completed </h4>";
    } 
	  elseif (($_POST['type'] == 6) && ($_POST['total_days']) > $leave_rule->PL) {
      $msggg = "<h4 class='alert alert-danger'>You Can't apply Paternity Leave (PL)more than the limit</h4>";
    } 
	  elseif (($_POST['type'] == 6) && (($lv_days_paternity + $_POST['total_days']) > $leave_rule->PL)) {
      $msggg = "<h4 class='alert alert-danger'>Your Paternity Leave (PL) already completed </h4>";
    }
	  elseif (($_POST['type'] == 7) && ($_POST['total_days']) > $total_hajj_lv) {
      $msggg = "<h4 class='alert alert-danger'>You Can't apply Hajj Leave (HL) more than the limit</h4>";
    } 
	  elseif (($_POST['type'] == 7) && (($hj_days_paternity + $_POST['total_days']) > $total_hajj_lv)) {
      $msggg = "<h4 class='alert alert-danger'>Your Hajj Leave (HL) already completed </h4>";
    } else {
    

    $crud->update($unique);
 

      $_GET['leave_id'] =  $_REQUEST['id'];

      $full_leave = find_all_field('hrm_leave_info', '', 'id=' . $_GET['leave_id']);

         for ($i = $s_date; $i <= $e_date; $i += 86400) {

        if($full_leave->half_or_full=="Full"){
        $leave_duration = '1.0';
        }else{
        $leave_duration = $full_leave->total_days; // '1.0';
        }
        
        
        $att_date = date('Y-m-d', $i);


        $sql = "select id from hrm_att_summary where emp_id='" . $emp_code . "' and att_date='" . $att_date . "'";
        $query = db_query($sql);
        $num_rows = mysqli_num_rows($query);
        $data = mysqli_fetch_object($query);

        if ($num_rows > 0) {

          $up_query = "update hrm_att_summary set leave_id='" . $full_leave->id . "', leave_type='" . $full_leave->half_or_full . "',
          leave_reason='" .$full_leave->reason. "',leave_duration='" . $leave_duration . "', 
          leave_approved_by='" . $_SESSION['user']['id'] . "',
          leave_entry_at='" . $full_leave->entry_at . "', leave_entry_by='" . $full_leave->PBI_ID . "' where id=" . $data->id;
          $result_new = db_query($up_query);
        } else {

          $ins_query = "INSERT INTO hrm_att_summary( att_date, emp_id, leave_id, leave_type, leave_reason, leave_duration,leave_approved_by, leave_entry_at, leave_entry_by,dayname) 

VALUES ('" . $att_date . "','" . $full_leave->PBI_ID . "', '" . $full_leave->id . "', '" . $full_leave->half_or_full . "', 
 '" .$full_leave->reason. "',
'" . $leave_duration . "', 
'" . $_SESSION['user']['id'] . "', '" . $full_leave->entry_at . "', '" . $full_leave->PBI_ID . "' , dayname('" . $att_date . "'))";
          $result_new = db_query($ins_query);
        }
      }
      
    header("Location:leave_approval_all.php");
 
			
    }
  }
  
  
  
  
  //Disapprove
  if (isset($_POST['disapprove'])) {
      
    $_POST['leave_status'] = 'Cancel';
    //$_POST['incharge_status'] = 'Cancel';   
      
    $crud->update($unique); 
    
    header("Location: leave_approval_all.php");
      
      
  }
  
  
  
  
}




?>

<script type="text/javascript">
  function DoNav(lk) {


    return GB_show('ggg', '../../hrm_mod/pages/leave/leave_entry_input.php?id=' + lk, 600, 940)


  }
</script>


<script type="text/javascript">
  /*

$(document).ready(function(){


$("#e_date").change(function (){

var from_leave = $("#s_date").datepicker('getDate');
var to_leave = $("#e_date").datepicker('getDate');
var days   = ((to_leave - from_leave)/1000/60/60/24)+1;

if(days>0&&days<100){
$("#total_days").val(days);}
 });

$("#s_date").change(function (){
var from_leave = $("#s_date").datepicker('getDate');
var to_leave = $("#e_date").datepicker('getDate');
var days   = ((to_leave - from_leave)/1000/60/60/24)+1;

if(days>0&&days<100){

$("#total_days").val(days);}

});

});


*/
</script>

<style>
  .bg-custom {
    background-color: #ffcccb;
  }
</style>


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





<div class="oe_view_manager oe_view_manager_current">
  <form action="leave_entry.php" method="post" enctype="multipart/form-data">
    <? include('../../common/title_bar_individual.php'); ?>

  </form>
  <div class="container mt-4">
    <div class="card">

      <div class="card-header bg-info text-white">
        <h5 class="card-title text-center">Leave Information Entry</h5>
          <h5 class="card-title text-center"><?php echo $msggg; ?></h5>
      </div>

   
     
    
      <div class="card-body bg-custom">
        <form action="" method="post">
          <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label text-right">Leave Type:</label>
            <div class="col-sm-4">
			<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
			
		  <input name="PBI_ID" type="hidden" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" required value="<?=$leave_id->PBI_ID;?>" readonly="readonly" />

              <select name="type" id="type" class="form-control" required>
                <option value=""></option>
            
				
				<option <?=($leave_id->type==1)?'Selected':'';?> value="1" >Casual Leave (CL)</option>
				
                <option <?=($leave_id->type==2)?'Selected':'';?> value="2">Sick Leave (SL)</option>
                <option <?=($leave_id->type==3)?'Selected':'';?> value="3">Annual Leave (AL)</option>
                <!-- <option value="4">Marriage Leave (ML)</option> -->
                <option <?=($leave_id->type==5)?'Selected':'';?> value="5">Maternity Leave (MLV)</option>
              
             
                <option <?=($leave_id->type==8)?'Selected':'';?> value="8"> Previlize Leave </option>
                <option <?=($leave_id->type==9)?'Selected':'';?> value="9">Leave Without Pay (LWP)</option>
              </select>
			  
			  
		
				  
				  
            </div>



            <label for="Period_type" class="col-sm-2 col-form-label text-right">Period:</label>
            <div class="col-sm-4">
              <select name="half_or_full" id="leaveType" class="form-control" onchange="updateEndDate()" required>
                <option value=""></option>
                <option <?=($leave_id->half_or_full=="Full")?'Selected':'';?> value="Full">Full</option>
                <option <?=($leave_id->half_or_full=="Early Half")?'Selected':'';?> value="Early Half">1st Half</option>
                <option <?=($leave_id->half_or_full=="Last Half")?'Selected':'';?> value="Last Half">2nd Half</option>
                <option <?=($leave_id->half_or_full=="first_qtr")?'Selected':'';?> value="first_qtr">1st Qtr</option>
                <option <?=($leave_id->half_or_full=="second_qtr")?'Selected':'';?> value="second_qtr">2nd Qtr</option>
                <option <?=($leave_id->half_or_full=="third_qtr")?'Selected':'';?> value="third_qtr">3rd Qtr</option>
                <option <?=($leave_id->half_or_full=="fourth_qtr")?'Selected':'';?> value="fourth_qtr">4th Qtr</option>
              </select>
            </div>
          </div>


          <div class="form-group row">
            <label for="s_date" class="col-sm-2 col-form-label text-right">Start Date:</label>
            <div class="col-sm-4">
              <input type="date" name="s_date" id="startDate" value="<?=$leave_id->s_date?>" class="form-control" onchange="updateEndDate()" style="width:100px;" autocomplete="off" required />
            </div>
            <label for="total_days" class="col-sm-2 col-form-label text-right">Leave Days:</label>
            <div class="col-sm-4">
              <input type="number" step="0.25" name="total_days" value="<?=$leave_id->total_days?>" id="totalDays" style="width:100px;" onchange="updateEndDate()" required="required" class="form-control" />
            </div>
          </div>






          <div class="form-group row">

            <label for="e_date" class="col-sm-2 col-form-label text-right">End Date:</label>
            <div class="col-sm-4">
              <input type="date" name="e_date" id="endDate" value="<?=$leave_id->e_date?>" style="width:100px;" autocomplete="off" readonly="readonly" class="form-control" required />
            </div>


            <label for="total_days" class="col-sm-2 col-form-label text-right"> Desk Look After :</label>
            <div class="col-sm-4">
              <input type="text" list="incharge" name="leave_responsibility_name" id="leave_responsibility_name" class="form-control"  
			  value="<?=$leave_id->leave_responsibility_name;?>" />
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
              <input type="text" name="reason" value="<?=$leave_id->reason?>" id="reason" class="form-control" required />
            </div>

            
             
             <div class="col-sm-2 offset-sm-2">


              <input name="search" type="submit" id="search" class="btn btn-success" value="Approve" />

            </div>
            
     
            
           <div class="col-sm-2"><input name="disapprove" type="submit" id="search" class="btn btn-danger" value="Disapprove" /> 
           
           </td>
           </tr>

            </div> 
            
            
            
            
              <!-- <div class="col-sm-2">

      <a href="detail_leave_report_copy.php?PBI_ID=<?=$emp_code;?>" target="_blank" class="btn btn-success btn-flat"> 
   <i class="fa fa-eye">  View </i> 
</a>
</td>
              </tr>

            </div> -->
            
            
            
            
          </div>
          
          
        
         
   

      </div>
    </div>
  </div>





  <br />
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-8 col-md-8 col-lg-8">
        <table class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
            <tr class="bgc-info">
              <th>SL</th>
              <th>Type of Leave</th>
              <th>Form Date</th>
              <th>To Date</th>
              <th>Day(s) </th>
              <th>Period</th>
              <th>Reason</th>
			  <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody class="tbody1">
            <?
            $s = 1;
			
		
			
			
            $pbi_id = find_a_field('personnel_basic_info', 'PBI_ID', 'PBI_CODE="' .$emp_code. '"');

             $sql = "select * from hrm_leave_info where PBI_ID='" . $emp_code . "'  and
			 
			 s_date BETWEEN  '" . $g_s_date . "' and '" . $g_e_date ."'
			 
			 order by s_date desc";

            $query = db_query($sql);

            while ($row = mysqli_fetch_object($query)) {



            ?>
              <tr>
                <td><?= $s++; ?></td>
                <td><?= find_a_field('hrm_leave_type', 'leave_short_name', 'id="' . $row->type . '"'); ?></td>
                <td><?=date('d-M-Y',strtotime($row->s_date))?></td>
                 <td><?=date('d-M-Y',strtotime($row->e_date))?> </td>
                <td><?= $row->total_days; ?></td>
                <td><?= $row->half_or_full; ?></td>
                <td><?= $row->reason; ?></td>
				<td><?= $row->leave_status; ?></td>
				
				<? if($row->dept_head_status == "Pending"){ ?>
           	
             <td> <a href="leave_log_delete.php?asign_id=<?= $row->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-flat"> <i class="fa fa-trash"></i> </a> </td>
              
                <? }else{ ?>
                <td> <a href="detail_leave_report_copy.php?PBI_ID=<?=$emp_code;?>" target="_blank" class="btn btn-success btn-flat"> 
   <i class="fa fa-eye">  View </i> 
</a></td>
                <? } ?>

			
              
              </tr>

            <? } ?>
          </tbody>
        </table>
      </div>



      <?


      $g_s_date = date('Y-01-01');



      $g_e_date = date('Y-12-31');



      //$essentialInfo = find_all_field('personnel_basic_info','','PBI_ID='.$_POST['employee_selected']);
      $emp_id = find_a_field('hrm_leave_info', 'PBI_ID', 'PBI_ID=' . $emp_code);

      $leave_days_casual = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=1 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '"   and PBI_ID=' . $emp_id);
      $leave_days_sick = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=2 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '"   and PBI_ID=' . $emp_id);
      $leave_days_annual = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=3 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '"   and PBI_ID=' . $emp_id);
      $leave_days_marrige = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=4 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '"   and PBI_ID=' . $emp_id);
      $leave_days_maternity = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=5 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '"   and PBI_ID=' . $emp_id);
      $leave_days_paternity = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=6 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '"   and PBI_ID=' . $emp_id);
      $leave_days_Hajj = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=7 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '"   and PBI_ID=' . $emp_id);
      $leave_days_half = find_a_field('hrm_leave_info', 'sum(total_days)', 'type="Short Leave (SHL)" and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '"   and PBI_ID=' . $emp_id);
      $leave_days_EOL = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=8 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '"   and PBI_ID=' . $emp_id);
      $leave_days_lwp = find_a_field('hrm_leave_info', 'sum(total_days)', 'type=9 and leave_status="GRANTED" and s_date>="' . $g_s_date . '" and e_date<="' . $g_e_date . '"   and PBI_ID=' . $emp_id);





      //""""""""""""""""""""" DYNAMIC LEAVE BALANCE CHACKEr """""""""""""""""""

      /*$currentYearr = date("Y");
$date2mon = 12;
$date1 = new DateTime($joiningdate);
$date2 = new DateTime($currentYearr.'-'.$date2mon.'-'.'31');

$interval = $date1->diff($date2);

$totalMonthss = $interval->format('%m');
$totalMonthss += $interval->format('%y') * 12+1;*/






      //___________ !!!!!!!!  __  Fractional LEAVE BALANACE ____________!!!!!!!!!!!!!!!!!!!!!!!!!!
      $joiningdate = find_a_field('personnel_basic_info', 'PBI_DOJ', 'PBI_ID=' . $emp_code);
      $year_e_datee = date('Y-12-31');
	  $g_e_datee = date('Y-m-d');
      $start = strtotime($joiningdate);
      $end = strtotime($g_e_datee);
	  $current_y_end = strtotime($year_e_datee);
	  
	  $days_between_current_year = ceil(abs($start - $current_y_end) / 86400);
	  
      $days_between = ceil(abs($start - $end) / 86400);
	  
	   
	  
	 $Check_joinDate = date('Y-m-d', strtotime($joiningdate . ' + ' . (date('Y', strtotime($g_e_datee)) - date('Y', strtotime($joiningdate))) . ' years'));
	   
	
		
		
	     $annual_leave_status_opening = find_a_field('annual_leave_balance', 'BALANCE', 'PBI_ID="' .$emp_code. '"');
 
		  $annual_leave_status_earn = find_a_field('hrm_att_summary', 'sum(annual_leave)', 'emp_id="' .$emp_code. '" and att_date BETWEEN  "' . $g_s_date . '" 
		 and "' . $g_e_date . '" ');
		  
		if (strtotime($Check_joinDate) < strtotime($g_e_datee)) {
	      	 $final_annual_status_earn = ($annual_leave_status_earn / 18);
		 
		}else{
		 	 $final_annual_status_earn = 0;
		     }
		

		 $total_al_allocated = ($annual_leave_status_opening+$final_annual_status_earn);
		

	  
	   $joiningYear = date('Y', strtotime($joiningdate));
	   $currentYear = date('Y');
	   
	   if ($joiningYear < $currentYear && $days_between >= 365) {
	   
        $total_casual = $leave_rule_in->CL;
        $total_MED = $leave_rule_in->MED;
        $total_ML = $leave_rule_in->ML;
		$total_HL = $leave_rule_in->HL;
		$total_EOL = $leave_rule_in->PL;
		$total_MTR = $leave_rule_in->MTR;
		$total_ANU = $total_al_allocated;
		
	   }elseif($joiningYear < $currentYear && $days_between < 365){
	   
	   $total_casual = $leave_rule_in->CL;
       $total_MED = $leave_rule_in->MED;
       $total_ML = $leave_rule_in->ML;
	   $total_HL = $leave_rule_in->HL;
	   $total_EOL = $leave_rule_in->PL;
	   $total_MTR = $leave_rule_in->MTR;
	  // $total_ANU = $annual_leave->BALANCE+$final_annual_earnn; //roundToQuarter($annual_leave / 18);
	   
      } else {

        $total_casual =  roundToQuarter($leave_rule_in->CL / 360 * $days_between_current_year);
        $total_MED =  roundToQuarter($leave_rule_in->MED / 360 * $days_between_current_year);
        $total_ANU =  0; //roundToQuarter($annual_leave / 18);
        $total_ML = roundToQuarter($leave_rule_in->ML / 360 * $days_between_current_year);
         $total_EOL = $leave_rule_in->PL;
         $total_HL = $leave_rule_in->HL;
     
      }
      //""""""""""""""""""""" END DYNAMIC BALANCE CHACKEr """""""""""""""""""


      ?>


      <div class="col-sm-4 col-md-4 col-lg-4">
        <table class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
            <tr class="bgc-info">
              <th></th>
              <th colspan="3">Day(s)</th>
            </tr>
            <tr class="bgc-info">
              <th>Leave Type</th>
              <th>Allocated </th>
              <th>Availed</th>
              <th>Balance</th>
            </tr>
          </thead>
			
          <tbody class="tbody1">
            <tr>
              <td>Casual</td>
              <td><?= $total_casual; ?></td>
              <td><?= $leave_days_casual ?></td>
              <td><?= $total_casual - $leave_days_casual ?></td>
            </tr>
			  
            <tr>
              <td>Sick</td>
              <td><?= $total_MED ?></td>
              <td><?= $leave_days_sick ?></td>
              <td><?= $total_MED - $leave_days_sick ?></td>
            </tr>
			  
            <tr>
              <td>Annual</td>
              <td><?= $total_ANU ?></td>
              <td><?= $leave_days_annual ?></td>
              <td><?= $total_ANU - $leave_days_annual ?></td>
            </tr>
            
            
              <tr>
              <td>LWP</td>
              <td></td>
              <td><?=$leave_days_lwp ?></td>
              <td></td>
            </tr>
			  
			  
          </tbody>
        </table>
      </div>
    </div>

  </div>
  
  <br />
  <br />
  
  </form>

</div>


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
<?




require_once SERVER_CORE."routing/layout.bottom.php";

?>