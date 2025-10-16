<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Leave Application Form';			// Page Name and Page Title
//$page="leave_request_input.php";		// PHP File Name
$root='leave';
$table='hrm_leave_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='type';				// For a New or Edit Data a must have data field
$leave_id = find_all_field('hrm_leave_info','','id='.$_REQUEST['id']);
$imp_info = find_all_field('personnel_basic_info','','PBI_ID='.$leave_id->PBI_ID);
$essentialInfo = find_all_field('personnel_basic_info','','PBI_ID='.$leave_id->PBI_ID);
// ::::: End Edit Section :::::




// ::::: End Edit Section :::::
$crud      =new crud($table);
if(isset($_GET[$unique]))
$$unique = $_GET[$unique];
else
$$unique = $_POST[$unique];


$u_id=$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);
$_SESSION['employee_selected'] = $PBI_ID;
//$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);



$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));
$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));
$user_leave_rull = find_all_field('hrm_leave_rull_manage','','id='.$PBI->LEAVE_RULE_ID);

$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');

$leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type="Casual Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);
$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type="Sick Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);
$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type="Annual" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);
$prev_lv=mysqli_num_rows(db_query("select * from hrm_leave_info where PBI_ID='".$_SESSION['employee_selected']."' and s_date='".$_REQUEST['s_date']."' and e_date='".$_REQUEST['e_date']."'"));


//echo $user_leave_rull->MED. ' OK '.$_POST['type']. ' lv '.$leave_days_sick;





if(isset($_POST['insert']))







{







if($prev_lv>0){







$msggg= "<h2 style='color:#FF0000'>You Can't Add Same Leave Twice</h2>";







}







elseif(($_POST['type']=='Casual Leave') && (($leave_days_casual+$_POST['total_days'])> $user_leave_rull->CL)){







$msggg= "<h2 style='color:#FF0000'>You Have Availed All Your Casual Leave for This Year</h2>";







}















elseif(($_POST['type']=='Sick Leave') && (($leave_days_sick+$_POST['total_days'])>$user_leave_rull->MED)){







$msggg= "<h2 style='color:#FF0000'>You Can Avail All Your Sick Leave for This Year</h2>";







}















elseif(($_POST['type']=='Annual') && (($leave_days_annual+$_POST['total_days'])>$user_leave_rull->ANU)){







$msggg= "<h2 style='color:#FF0000'>You Have Availed All Your Annual Leave for This Year</h2>";







}















else{		







$now= time();







$extention=explode('.',$_FILES['att_file']['name']);







$extention=strtolower(end($extention));







$target_dir = "picture/leave_files/";







$target_file = $target_dir . $$unique.'.'.$extention;















$projectId = array(2,3,4,5);







//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];







$_REQUEST['PBI_IN_CHARGE'] = $essentialInfo->ESSENTIAL_REPORTING;















if(in_array($essentialInfo->ESSENTIAL_PROJECT, $projectId)){







$_REQUEST['PBI_DEPT_HEAD'] = 111659;}















$_REQUEST['leave_status'] = "PENDING";















$_REQUEST['entry_at'] = date('Y-m-d H:i:s');







$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));







$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));







$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));















if($_FILES['att_file']['tmp_name']!=""){







$_REQUEST['att_file']= $target_file;}







$crud->insert();























move_uploaded_file($_FILES["att_file"]["tmp_name"], '../../'.$target_file);















$type=1;







$msg='New Entry Successfully Inserted.';























unset($_POST);







unset($$unique);







echo '<script type="text/javascript">parent.parent.document.location.href = "../leave/view_leave.php?notify=12";</script>';















}







}















//for Modify..................................















if(isset($_POST['update']))







{















$extention=explode('.',$_FILES['att_file']['name']);







$extention=strtolower(end($extention));







$target_dir = "picture/leave_files/";







$target_file = $target_dir . $$unique.'.'.$extention;















//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];







//$_REQUEST['leave_status'] = 'PENDING';







//$_REQUEST['leave_status_detail'] = 'Waiting for Replacement';







$_REQUEST['edit_at'] = date('Y-m-d H:i:s');







$_REQUEST['leave_from_date']= date('Y-m-d',strtotime($_REQUEST['leave_from_date']));







$_REQUEST['leave_to_date']= date('Y-m-d',strtotime($_REQUEST['leave_to_date']));







$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));















if($_FILES['att_file']['tmp']!=""){







$_REQUEST['att_file']= $target_file;}















		$crud->update($unique);







		







		move_uploaded_file($_FILES["att_file"]["tmp_name"], '../../'.$target_file);







		







		$type=1;







		$msg='Successfully Updated.';







				echo '<script type="text/javascript">







parent.parent.document.location.href = "../inventory/home_leave.php?notify=12";







</script>';







}







//for Delete..................................















if(isset($_POST['delete']))







{		$condition=$unique."=".$$unique;		$crud->delete($condition);







		unset($$unique);







		echo '<script type="text/javascript">







parent.parent.document.location.href = "../inventory/home_leave.php?notify=12";







</script>';







		$type=1;







		$msg='Successfully Deleted.';







}















if(isset($_POST['granted']))







{		

unset($_REQUEST);
$_POST['leave_status'] = 'Granted';
$_POST['reporting_note'] = $_POST['reporting_note'];
$_POST['s_time'] = $_POST['s_time'];
$_POST['e_time'] = $_POST['e_time'];
$_POST['total_hrs'] = $_POST['total_hrs'];
$_POST['half_leave_date'] = $_POST['half_leave_date'];
$_POST['s_date'] = $_POST['half_leave_date'];
$_POST['e_date'] = $_POST['half_leave_date'];
$s_date= strtotime($_POST['s_date']);




$crud->update($unique);




$curMonthTo = date('Y-m-01');
$curMonthFrom = date('Y-m-31');


/* HRM ATTENDANCE ATOMATION START*/

$full_leave = find_all_field('hrm_leave_info','','id='.$leave_id->id);
for($i=$s_date; $i<=$s_date; $i+=86400){
$leave_duration = '0.5';

if($full_leave->leave_slot=="Early Half"){

$sort_leave_start_time = '8:30';

$sort_leave_end_time   = '12:45';

}else{

$sort_leave_start_time = '12:45';

$sort_leave_end_time   = '17:00';

}





$att_date=date('Y-m-d',$i);
$sql="select id from hrm_att_summary where emp_id='".$full_leave->PBI_ID."' and att_date='".$att_date."'";
$query=db_query($sql);
$num_rows=mysqli_num_rows($query);
$data=mysqli_fetch_object($query);

if($num_rows>0){
$up_query="update hrm_att_summary set leave_id='".$full_leave->id."', leave_type='".$full_leave->leave_slot."',leave_category='".$full_leave->type."', leave_entry_at='".date('Y-m-d H:i:s')."',
leave_start_time='".$sort_leave_start_time."',leave_end_time='".$sort_leave_end_time."', leave_entry_by='".$full_leave->PBI_ID."',leave_duration='".$leave_duration."' where id=".$data->id;

db_query($up_query);

}else{

$ins_query="INSERT INTO hrm_att_summary( att_date, emp_id, leave_id, leave_type,leave_entry_at,leave_entry_by,leave_start_time,leave_end_time,leave_category,leave_duration) 
VALUES ('".$att_date."','".$full_leave->PBI_ID."', '".$full_leave->id."', '".$full_leave->leave_slot."','".date('Y-m-d H:i:s')."', '".$full_leave->PBI_ID."' ,'".$sort_leave_start_time."',
'".$sort_leave_end_time."','".$full_leave->type."','".$leave_duration."')";
db_query($ins_query);
}



}


/* HRM ATTENDANCE ATOMATION START*/



//  LEAVE DEDUCT AFTER TAKING MORE THEN 3 SORT LEAVE
$total_half_leave=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date between "'.$curMonthTo.'" and "'.$curMonthFrom.'" and PBI_ID='.$leave_id->PBI_ID);



if($total_half_leave==3){

$date_dfrnc = date_diff(date_create(date('Y-m-d')), date_create($imp_info->PBI_DOJ));
$total_job_days = $date_dfrnc->format('%a');


if($total_job_days<365 && $essentialInfo->EMPLOYMENT_TYPE != 'Permanent'){


$lwp_insert = 'INSERT INTO `hrm_leave_info` (`leave_apply_date`, `incharge_status`, `PBI_ID`, `type`, `mon`, `year`, `s_date`, `e_date`, `total_days`, `half_or_full`, `reason`, `half_leave_date`, `leave_status`) VALUES ("'.date('Y-m-d').'","Approve","'.$leave_id->PBI_ID.'","9","'.date('m').'","'.date('Y').'","'.date('Y-m-d').'","'.date('Y-m-d').'","1","Full","3 Days Short Leave","'.date('Y-m-d').'","GRANTED")';

db_query($lwp_insert);


}elseif($total_job_days<365 && $essentialInfo->EMPLOYMENT_TYPE == 'Permanent'){

$casual_insert = 'INSERT INTO `hrm_leave_info` (`leave_apply_date`, `incharge_status`, `PBI_ID`, `type`, `mon`, `year`, `s_date`, `e_date`, `total_days`, `half_or_full`, `reason`, `half_leave_date`, `leave_status`) VALUES ("'.date('Y-m-d').'","Approve","'.$leave_id->PBI_ID.'","1","'.date('m').'","'.date('Y').'","'.date('Y-m-d').'","'.date('Y-m-d').'","1","Full","3 Days Short Leave","'.date('Y-m-d').'","GRANTED")';
db_query($casual_insert);

/*$avail_casual = find_a_field('leave_days_define','casual','PBI_ID="'.$leave_id->PBI_ID.'" and year="'.date('Y').'"');
$new_casual = $avail_casual-1; 
$casual_update = 'update leave_days_define set casual="'.$new_casual.'" where PBI_ID="'.$leave_id->PBI_ID.'" and year="'.date('Y').'"';
db_query($casual_update);*/

}elseif($total_job_days>365 && $essentialInfo->EMPLOYMENT_TYPE == 'Permanent'){
$annual_insert = 'INSERT INTO `hrm_leave_info` (`leave_apply_date`, `incharge_status`, `PBI_ID`, `type`, `mon`, `year`, `s_date`, `e_date`, `total_days`, `half_or_full`, `reason`, `half_leave_date`, `leave_status`) VALUES ("'.date('Y-m-d').'","Approve","'.$leave_id->PBI_ID.'","3","'.date('m').'","'.date('Y').'","'.date('Y-m-d').'","'.date('Y-m-d').'","1","Full","3 Days Short Leave","'.date('Y-m-d').'","GRANTED")';
db_query($annual_insert);

/*$avail_annual = find_a_field('leave_days_define','annual','PBI_ID="'.$leave_id->PBI_ID.'" and year="'.date('Y').'"');
$new_annual = $avail_annual-1; 
$annual_update = 'update leave_days_define set annual="'.$new_annual.'" where PBI_ID="'.$leave_id->PBI_ID.'" and year="'.date('Y').'"';
db_query($annual_update);*/


}

}

//Text Sms
/*function sms($dest_addr,$sms_text){
$url = "https://api.mobireach.com.bd/SendTextMessage?Username=aksid&Password=Akhr@2020&From=AKSID_HR";
$fields = array(
'Username'      => "aksid",
'Password'      => "Akhr@2020",
'From'          => "AKSID HR",
'To'            => $dest_addr,
'Message'       => $sms_text
);*/

//open connection
/*$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

$result = curl_exec($ch);

curl_close($ch);
}*/

/*$recipients='88'.$imp_info->PBI_MOBILE.'';
$massage  = "Your requested Short Leave (SHL) is granted\r\n";
$massage.="Date: ".date('d-M-Y', strtotime($_POST['half_leave_date']))."\r\n";
$massage.="Time: ".date('h:i a', strtotime($_POST['s_time']))." to ".date('h:i a', strtotime($_POST['e_time']))."\r\n";
$massage.="Total Hours: ".$_POST['total_hrs']."\r\n";
$sms_result=sms($recipients,$massage);*/

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_hrm_half.php?notify=12";
</script>';
$type=1;
$msg='Successfully Granted.';



}















if(isset($_POST['not_granted']))







{		







unset($_REQUEST);







$_REQUEST['leave_status'] = 'Not Granted';







$_REQUEST['reporting_note'] = $_POST['reporting_note'];















$crud->update($unique);















//Text Sms















function sms($dest_addr,$sms_text){







          







       







$url = "https://api.mobireach.com.bd/SendTextMessage?Username=aksid&Password=Akhr@2020&From=AKSID_HR";















$fields = array(







    'Username'      => "aksid",







    'Password'      => "Akhr@2020",







    'From'          => "AKSID HR",







    'To'            => $dest_addr,







    'Message'       => $sms_text







);















//open connection







$ch = curl_init();















//set the url, number of POST vars, POST data







curl_setopt($ch, CURLOPT_URL, $url);







curl_setopt($ch, CURLOPT_POST, count($fields));







curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));















//execute post







$result = curl_exec($ch);















//close connection







curl_close($ch);























}















            $recipients='88'.$imp_info->PBI_MOBILE.'';







			







			







			$massage  = "Your requested Short Leave (SHL) is not granted\r\n";







			







			







	        $sms_result=sms($recipients,$massage);







	







	







 //Text Sms







































echo '<script type="text/javascript">







parent.parent.document.location.href = "../leave/view_leave_hrm_half.php?notify=12";







</script>';















$type=1;







$msg='Successfully Deleted.';







}















































if(isset($$unique))







{







$condition=$unique."=".$$unique;







$data=db_fetch_object($table,$condition);







foreach ($data as $key => $value)







{ $$key=$value;}







}







if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);































































?>
<style type="text/css">







.MATERNITY_LEAVE{







display:none;







}















input[type="radio"], input[type="checkbox"] {







    line-height: normal;







    margin: 4px 0 0;







	width:20px;







}







.radio, .checkbox {







    min-height: 20px;







    padding-left: 20px;







}







.checkbox {







    margin-right: 4px !important;







}















.radio.inline, .checkbox.inline {







    display: inline-block;







    margin-bottom: 0;







    padding-top: 5px;







    vertical-align: middle;







}.radio.inline, .checkbox.inline {







    display: inline-block;







    margin-bottom: 0;







    padding-top: 5px;







    vertical-align: middle;







}







.radio.inline + .radio.inline, .checkbox.inline + .checkbox.inline {







    margin-left: 10px;







}







</style>
<script type="text/javascript">







$(document).ready(function(){















 $("#MATERNITY_LEAVE_LEVEL1").hide();







   $("#MATERNITY_LEAVE_INPUT1").hide();







 $('#leave_type').click(function(){







  var num =$("#leave_type").val();







   if(num=="MATERNITY"){







   $("#MATERNITY_LEAVE_LEVEL1").show();







   $("#MATERNITY_LEAVE_INPUT1").show();







    







   }







   else{







    $("#MATERNITY_LEAVE_LEVEL1").hide();







    $("#MATERNITY_LEAVE_INPUT1").hide();







     $("#materlan_count_level").hide();







   $("#materlan_count_input").hide();







   }







 });







 







 







  $('#MATERNITY_past').click(function(){







  var num =$("#MATERNITY_past").val();







   if(num=="yes"){







   $("#materlan_count_level").show();







   $("#materlan_count_input").show();







    







   }







   else{







    $("#materlan_count_level").hide();







   $("#materlan_count_input").hide();







   }







 });







 







  $("#materlan_count").change(function (){







    var materlan_count =  $("#materlan_count").val();







	







  if(materlan_count==2){







    alert("You are not Eligible for this Leave.");







	$('button[type="submit"]').attr('disabled','disabled');







  }else{







  $('button[type="submit"]').removeAttr('disabled');







  }







   







  });







   







  $("#e_date").change(function (){







     var from_leave = $("#s_date").datepicker('getDate');







     var to_leave = $("#e_date").datepicker('getDate');







    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;















	$("#total_days").val(days);







	







	$("#total_leave").text(' Total  '+ days +'  Days ');







  });







    







    







  







});







 







</script>
<div class="right_col" role="main">
<!-- Must not delete it ,this is main design header-->
<div class="">
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="openerp openerp_webclient_container">
  <div class="x_content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-primary" align="center">
          <div class="panel-heading">
            <h3 class="panel-title">Short Leave Approval Form</h3>
          </div>
          <div class="panel-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="oe_view_manager oe_view_manager_current">
                <? //include('../../common/title_bar.php');?>
                <div class="oe_view_manager_body">
                  <div  class="oe_view_manager_view_list"></div>
                  <div class="oe_view_manager_view_form">
                    <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
                      <div class="oe_form_buttons"></div>
                      <div class="oe_form_sidebar"></div>
                      <div class="oe_form_pager"></div>
                      <div class="oe_form_container">
                        <div class="oe_form">
                          <div class="">
                            <div class="oe_form_sheetbg">
                              <div class="oe_form_sheet oe_form_sheet_width"> <?php echo $msggg; ?> <span class="" style=" font-size:12px;">
                                <div align="center">
                                  <? 



















$curMonthTo = date('Y-m-01');




//echo $imp_info->PBI_ID;




$curMonthFrom = date('Y-m-31');
$date_dfrnc = date_diff(date_create(date('Y-m-d')), date_create($imp_info->PBI_DOJ));
$total_job_days = $date_dfrnc->format('%a');






//$check_sort_leaves=find_a_field('hrm_leave_info','COUNT(id)','type="Short Leave (SHL)"  and mon= "'.$_POST['mon'].'" and year= "'.$_POST['year'].'"  and  PBI_ID='.$_SESSION['employee_selected']);

 $sqld = 'select mon,id
from hrm_leave_info
where type="Short Leave (SHL)" and leave_status="Granted"  and  PBI_ID='.$leave_id->PBI_ID.' order by id desc limit 1';
$queryd=db_query($sqld);
while($data_mon = mysqli_fetch_object($queryd)){ 
$year = date('Y');
$mon  = $data_mon->mon;

$gg_s_date = $year.'-'.$mon.'-'.'01';
$gg_e_date = $year.'-'.$mon.'-'.'31';


}




if($leave_id->PBI_ID>0){

$mon_current = date('m');
if($mon_current == $mon ){

 $leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date>="'.$gg_s_date.'" and half_leave_date<="'.$gg_e_date.'" 
  and PBI_ID='.$leave_id->PBI_ID);

}else{



 $leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date between "'.$curMonthTo.'" and "'.$curMonthFrom.'" and 
PBI_ID='.$leave_id->PBI_ID);


}



 }else{
 $leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date between "'.$curMonthTo.'" and "'.$curMonthFrom.'" and
  PBI_ID='.$_SESSION['employee_selected']);

 }
 
 
 
 if($leave_days_half == 1){
  echo "<h2 style='color:white' class='alert alert-info'>1 Day Short Leave (SHL) Already Availed <br> ১ টি  Short Leave (SHL) ইতিমধ্যে সম্পূর্ণ হয়েছে </h2>";
  
  }elseif($leave_days_half == 2 && $total_job_days<365 && $essentialInfo->EMPLOYMENT_TYPE == 'Permanent'){
  echo "<h2 style='color:white' class='alert alert-danger'>Your 3rd Short Leave (SHL) application will result in 1 day Casual Leave (CL) deduction<br> 
আপনার ৩য় Short Leave (SHL) আবেদনের ফলে ১ দিনের Casual Leave কাটা হবে </h2>";
  
  }elseif($leave_days_half == 3 && $total_job_days<365 && $essentialInfo->EMPLOYMENT_TYPE != 'Permanent'){
  echo "<h2 style='color:white' class='alert alert-danger'>Your 3rd Short Leave (SHL) application will result in 1 day salary deduction <br> আপনার ৩য় Short Leave আবেদনের ফলে ১ দিনের বেতন কেটে নেওয়া হবে </h2>";
  
 
  
  }elseif($leave_days_half == 2 && $total_job_days>365 && $essentialInfo->EMPLOYMENT_TYPE == 'Permanent'){
  echo "<h2 style='color:white' class='alert alert-danger'>Your 3rd Short Leave (SHL) application will result in 1 day Annual Leave (AL) deduction <br>
আপনার ৩য় Short Leave (SHL) আবেদনের ফলে ১ দিনের Annual Leave (AL) কাটা হবে</h2>";
  }else{
  echo "<h2></h2>";
 }




 /* if($leave_days_half == 1){
  echo "<h2 style='color:white' class='alert alert-info'>1 Day Short Leave (SHL) Already Availed <br> ১ টি  Short Leave (SHL) ইতিমধ্যে সম্পূর্ণ হয়েছে </h2>";
  }elseif($leave_days_half == 2){
  echo "<h2 style='color:white' class='alert alert-info'>2 Day's Short Leave (SHL) Already Availed <br> 2 টি  Short Leave (SHL) ইতিমধ্যে সম্পূর্ণ হয়েছে </h2>";
  
  }elseif($leave_days_half == 3 && $total_job_days<365 && $essentialInfo->EMPLOYMENT_TYPE != 'Permanent'){
  echo "<h2 style='color:white' class='alert alert-danger'>3 Day's Short Leave (SHL) Will Deduct 1 day Salary <br> ১ দিনের বেতন কর্তন করা হবে </h2>";
  }elseif($leave_days_half == 3 && $total_job_days<365){
  echo "<h2 style='color:white' class='alert alert-danger'>3 Day's Short Leave (SHL) Will Deduct 1 day Casual Leave(CL) <br> ১ দিনের Casual Leave (CL) কর্তন করা হবে  </h2>";
  }elseif($leave_days_half == 3 && $total_job_days>365 && $essentialInfo->EMPLOYMENT_TYPE == 'Permanent'){
  echo "<h2 style='color:white' class='alert alert-danger'>3 Day's Short Leave (SHL) Will Deduct 1 day Annual Leave(AL) <br> ১ দিনের Annual Leave (AL) কর্তন করা হবে  </h2>";
  }else{
  echo "<h2></h2>";
 }*/































				 ?>
                                </div>
                                </span>
                                <table class="table table-bordered table-sm" border="0" cellpadding="0" cellspacing="0">
                                  <tbody>
                                    <tr class="oe_form_group_row">
                                      <td colspan="1" class="oe_form_group_cell" width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">
                                          <tbody>
                                            <tr class="oe_form_group_row">
                                              <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                                <input name="PBI_ID" id="PBI_ID" value="<?=$leave_id->PBI_ID?>" type="hidden" />
                                                &nbsp;&nbsp;Leave Types  :</td>
                                              <td class="oe_form_group_cell" colspan="4"><input type="text" name="type" value="Short Leave (SHL)"  readonly  />
                                              </td>
                                            </tr>
                                            <!--<tr class="oe_form_group_row">







                  <td  id="MATERNITY_LEAVE_LEVEL1" bgcolor="#fff" colspan="1" class="oe_form_group_cell oe_form_group_cell_label MATERNITY_LEAVE">&nbsp;&nbsp;আপনি কি আগে ছুটি ভোগ করেছেন? :</td>







                  <td id="MATERNITY_LEAVE_INPUT1" bgcolor="#fff" class="oe_form_group_cell MATERNITY_LEAVE">







				  <select onChange="MATERNITY_yes_check(this.value)" id="MATERNITY_past" name="MATERNITY_past">







                     <option value="" selected="selected">বাছাই করুন</option>







                          <option <?php if($MATERNITY_past=="yes") echo "selected"; ?> value="yes">হ্যা</option>







                             <option <?php if($MATERNITY_past=="no") echo "selected"; ?> value="no">না</option>







                         </select></td>







						    <td id="materlan_count_level" bgcolor="#fff" colspan="2" class="oe_form_group_cell oe_form_group_cell_label MATERNITY_LEAVE">&nbsp;&nbsp;কতবার ভোগ করেছেন? :</td>







                  <td id="materlan_count_input" bgcolor="#fff" class="oe_form_group_cell MATERNITY_LEAVE">







				  <select name="materlan_count" id="materlan_count">







                       <option value="" selected="selected">বাছাই করুন</option>







                       <option <?php if($materlan_count==1) echo "selected"; ?> value="1">১ বার</option>







                       <option <?php if($materlan_count==2) echo "selected"; ?> value="2">২ বার</option>







                       </select></td>







                  </tr>-->
                                            <!--<tr class="oe_form_group_row">







                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;সংযুক্তি :</td>







                  <td colspan="3" class="oe_form_group_cell"><input type="file" name="att_file" /></td>







                  </tr>-->
                                            <tr class="oe_form_group_row">
                                              <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Leave Slot : </td>
                                              <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><table width="100%" border="0">
                                                  <tr>
                                                    
                                                
                                                    <td ><select name="leave_slot" id="leave_slot" required="required">



                                    <option value="<?=$leave_slot?>"><?=$leave_slot?></option>



                                    <option <?=($half_or_full=='Early Half')?'Selected':'';?> >Early Half</option>



                                    <option <?=($half_or_full=='Last Half')?'Selected':'';?> >Last Half</option>



                                </select></td>
                                                   
                                                  </tr>
                                                </table></td>
                                            </tr>
                                            <tr class="oe_form_group_row">
                                              <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Leave&nbsp;Date : </td>
                                              <td class="oe_form_group_cell" colspan="4"><script language="javascript">















$('#leave_to_date').change(function() {















     var from_leave = $("#leave_from_date").datepicker('getDate');







     var to_leave = $("#leave_to_date").datepicker('getDate');







    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;















	















           $.ajax({







            success: function(response) {







           $( "#leave_join_date" ).datepicker({







			changeMonth: true,







			changeYear: true,







			minDate: +days, 







			maxDate: +30, 







			dateFormat: "dd-mm-yy"







		});







                /*added following line to solve this issue ..but not worked*/







                //$( ".datepicker" ).datepicker({dateFormat: "dd-mm-yy"});















            } ,







            error: function () {}







        });







       });







	   







	   







	   function totalhrs(){































	  var sTime = $("#s_time").val();































	  var eTime = $('#e_time').val();































	  var t1 = Date.parse(sTime);































	  var t2 = Date.parse(eTime);































	  document.getElementById('total_hrs').value = parseFloat(((t2-t1)/60)/60000);















 }























</script>
                                                <?php do_calander('#half_leave_date');?>
                                                <input required name="half_leave_date" type="date" id="half_leave_date" value="<?php if($half_leave_date) echo $half_leave_date; ?>" /></td>
                                            </tr>
                                            <tr class="oe_form_group_row">
                                              <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Reason :</td>
                                              <td class="oe_form_group_cell" colspan="4"><span class="oe_form_group_cell oe_form_group_cell_label">
                                                <textarea name="reason" style="width:500px;" required><?=$reason?>
</textarea>
                                                </span></td>
                                            </tr>
                                            <tr class="oe_form_group_row">
                                              <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Supporting Doc: </td>
                                              <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="file" name="att_file" /></td>
                                            </tr>
                                            <tr class="oe_form_group_row">
                                              <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Submission Date: </td>
                                              <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="text" name="leave_apply_date" id="leave_apply_date" value="<?=$leave_apply_date?>" /></td>
                                            </tr>
                                            <tr class="oe_form_group_row">
                                              <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                              <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4"><select name="leave_responsibility_name" id="leave_responsibility_name" style="width:420px;" >
                                                  <? 







								  $dept = find_a_field('personnel_basic_info','DEPT_ID','PBI_ID='.$unique_pbi_id); 







								  $projec_t = find_a_field('personnel_basic_info','JOB_LOCATOIN','PBI_ID='.$unique_pbi_id); 







								  if($dept>0){







								  foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.DESG_ID=d.DESG_ID and p.PBI_JOB_STATUS="In Service" and DEPT_ID="'.$dept.'" and PBI_ID != '.$_SESSION['user']['id'].' order by p.PBI_NAME');







								    }else{







									 foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.DESG_ID=d.DESG_ID and p.PBI_JOB_STATUS="In Service" and JOB_LOCATION="'.$projec_t.'" and PBI_ID != '.$_SESSION['user']['id'].' order by p.PBI_NAME');







									}







								  ?>
                                                </select>
                                                <input type="hidden" name="reporting_auth" value="<?=find_a_field('essential_info','ESSENTIAL_REPORTING','PBI_ID='.$_SESSION['user']['id'])?>" />
                                            <tr class="oe_form_group_row">
                                              <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Approve/Not Approve Note </td>
                                              <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4"><span class="oe_form_group_cell oe_form_group_cell_label">
                                                <textarea name="reporting_note" id="reporting_note" style="width:500px;" ><?=$reporting_note?>







                                    </textarea>
                                                </span>
                                          </tbody>
                                        </table></td>
                                    </tr>
                                    <tr>
                                      <td><div align="center">
                                          <? //if($_SESSION['employee_selected']==101656){?>
                                          <span class="oe_form_buttons_edit" style="display: inline;">
                                          <button name="granted" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Granted</button>
                                          </span> <span class="oe_form_buttons_edit" style="display: inline;">
                                          <button name="not_granted" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Not Granted</button>
                                          </span>
                                          <? //}?>
                                        </div></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <? if(isset($_GET[$unique]) && $_SESSION['employee_selected']==101656){?>
                                <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#ccc">
                                  <?











	    $emp_id = find_a_field('hrm_leave_info','PBI_ID','id='.$_REQUEST['id']);











	     $leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type=1 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);











 $leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type=2 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);























$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type=3 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);











$leave_days_marrige=find_a_field('hrm_leave_info','sum(total_days)','type=4 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);















$leave_days_maternity=find_a_field('hrm_leave_info','sum(total_days)','type=5 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);
$leave_days_paternity=find_a_field('hrm_leave_info','sum(total_days)','type=6 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);
$leave_days_Hajj=find_a_field('hrm_leave_info','sum(total_days)','type=7 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);
$leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date>="'.$g_s_date.'" and half_leave_date<="'.$g_e_date.'" 
  and PBI_ID='.$emp_id);
$leave_days_EOL=find_a_field('hrm_leave_info','sum(total_days)','type=8 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);
$leave_days_lwp= find_a_field('hrm_leave_info','sum(total_days)','type=9 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$emp_id);?>
                                  <tr>
                                    <td colspan="11"  bgcolor="#FFFFFF" style="background:#2299C3; color:#FFFFFF;"><div align="center" class="style1">Leave Status of
                                        <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$emp_id)?>
                                        for <?php echo date('Y')?></div></td>
                                  </tr>
                                  <tr style="background:#f1f1f0" height="60">
                                    <td width="118" align="center" valign="middle"><strong><span class="style10">
                                      <div align="center" style="margin-top:15px">Type</div>
                                      </span></strong></td>
                                    <td width="101" align="center" valign="middle"><strong><span class="style10">
                                      <div align="center" style="margin-top:15px">Casual Leave (CL)</div>
                                      </span></strong></td>
                                    <td width="130" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">
                                        <div align="center">Sick Leave (SL)</div>
                                        </span></strong></div></td>
                                    <td width="98" align="center" valign="middle"><div align="center" style="margin-top:13px"><strong><span class="style10">
                                        <div align="center">Annual Leave (AL)</div>
                                        </span></strong></div></td>
                                    <td width="109" align="center" valign="middle"><strong><span class="style10">
                                      <div align="center" style="margin-top:15px">Short Leave (SHL)</div>
                                      </span></strong></td>
                                    <td width="127" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">
                                        <div align="center"><strong>Marriage Leave</strong></div>
                                        </span></strong></div></td>
                                    <?

 

	      if($PBI->PBI_SEX=="Female"){



	      ?>
                                    <td width="125" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">Maternity Leave (ML)</span></strong></div></td>
                                    <? } else{?>
                                    <td width="125" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">Paternity Leave (PL)</span></strong></div></td>
                                    <? } ?>
                                    <td width="127" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">Hajj Leave </span></strong></div></td>
                                    <td width="3%" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">Dayoff</span></strong></div></td>
                                    <td width="103" align="center" valign="middle"><div align="center"><strong><span class="style10">
                                        <div align="center">Leave <br>
                                          Without Pay (LWP)</div>
                                        </span></strong></div></td>
                                    <td width="125" align="center" valign="middle"><div align="center"><strong><span class="style10">
                                        <div align="center" style="margin-top:10px">Extra Ordinary Leave (EOL)</div>
                                        </span></strong></div></td>
                                  </tr>
                                  <tr align="center">
                                    <td width="8%" height="10" align="center"  bgcolor="#FFFFFF"><div align="center" style="margin-top:15px;"><span class="style4"><strong>Entitlement</strong></span></div></td>
                                    <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF" ><div align="center" style="margin-top:20px;">
                                        <?=$casual=find_a_field('hrm_leave_type','yearly_leave_days','id=1');?>
                                      </div></td>
                                    <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;">
                                        <?=$sick_leave=find_a_field('hrm_leave_type','yearly_leave_days','id=2');?>
                                      </div></td>
                                    <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
                                        <div align="center" style="margin-top:15px;">
                                          <?=$annual=find_a_field('hrm_leave_type','yearly_leave_days','id=3');?>
                                        </div>
                                        </span></div></td>
                                    <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:15px;"><span class="style4"> 24 </span></div></td>
                                    <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;">
                                        <?=$marrage=find_a_field('hrm_leave_type','yearly_leave_days','id=4');?>
                                      </div></td>
                                    <?

	      if($personnel_basic_info->PBI_SEX=="Female"){

	      ?>
                                    <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;">
                                        <?=$Maternity=find_a_field('hrm_leave_type','yearly_leave_days','id=5');?>
                                      </div></td>
                                    <? }else{?>
                                    <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;">
                                        <?=$paternity=find_a_field('hrm_leave_type','yearly_leave_days','id=6');?>
                                      </div></td>
                                    <? } ?>
                                    <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;">
                                        <?=$hajj=find_a_field('hrm_leave_type','yearly_leave_days','id=7');?>
                                      </div></td>
                                    <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;"></div></td>
                                    <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center">As per Management Approval </div></td>
                                    <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"> </div></td>
                                  </tr>
                                  <tr>
                                    <td width="118" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4"><strong>Availed</strong></span></div></td>
                                    <td width="101" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">
                                        <?=$leave_days_casual?>
                                        </span></div></td>
                                    <td width="130" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">
                                        <?=$leave_days_sick?>
                                        </span></div></td>
                                    <td width="98" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">
                                        <?=$leave_days_annual?>
                                        </span></div></td>
                                    <td width="109" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" >
                                        <?=$leave_days_half?>
                                      </div></td>
                                    <td width="125" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" >
                                        <?=$leave_days_marrige?>
                                      </div></td>
                                    <?

	      if($personnel_basic_info->PBI_SEX=="Female"){

	      ?>
                                    <td width="127" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center">
                                        <?=$leave_days_maternity?>
                                      </div></td>
                                    <? }else{ ?>
                                    <td width="127" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center">
                                        <?=$leave_days_paternity?>
                                      </div></td>
                                    <? } ?>
                                    <td width="125" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center">
                                        <?=$leave_days_Hajj?>
                                      </div></td>
                                    <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center">
                                        <?=$dayoff?>
                                      </div></td>
                                    <td width="103" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center">
                                        <?=$leave_days_lwp?>
                                      </div></td>
                                    <td width="130" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
                                        <?=$leave_days_EOL?>
                                        </span></div></td>
                                  </tr>
                                  <tr style="font-weight:bold;">
                                    <td width="118" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><strong>Balance</strong></span></div></td>
                                    <td width="101" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">
                                        <?=8-$leave_days_casual?>
                                        </span></div></td>
                                    <td width="130" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">
                                        <?=8-$leave_days_sick?>
                                        </span></div></td>
                                    <td width="98" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">
                                        <?=14-$leave_days_annual?>
                                        </span></div></td>
                                    <td width="98" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">
                                        <?=24-$leave_days_half?>
                                        </span></div></td>
                                    <td width="125" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">
                                        <?=5-$leave_days_marrige?>
                                      </div></td>
                                    <?

	      if($personnel_basic_info->PBI_SEX=="Female"){

	      ?>
                                    <td width="127" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
                                        <?=180-$leave_days_maternity?>
                                        </span></div></td>
                                    <? }else{ ?>
                                    <td width="127" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
                                        <?=3-$leave_days_paternity?>
                                        </span></div></td>
                                    <? } ?>
                                    <td width="125" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4">
                                        <?=10-$leave_days_Hajj?>
                                        </span></div></td>
                                    <td width="103" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"></span></div></td>
                                    <td width="130" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"></span></div></td>
                                    <td width="130" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"></span></div></td>
                                  </tr>
                                </table>
                                <? } ?>
                              </div>
                            </div>
                            <div class="oe_chatter">
                              <div class="oe_followers oe_form_invisible">
                                <div class="oe_follower_list"></div>
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
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
<?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";







?>
