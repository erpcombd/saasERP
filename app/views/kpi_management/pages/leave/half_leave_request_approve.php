<?php
@session_start();
ob_start();
require_once "../../config/inc.all.php";
require "../../template/main_layout.php";

// ::::: Edit This Section ::::: 
$title='Leave Application Form';			// Page Name and Page Title
$page="leave_request_input.php";		// PHP File Name

$root='leave';

$table='hrm_leave_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='type';				// For a New or Edit Data a must have data field

$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');

$leave_id = find_all_field('hrm_leave_info','','id='.$_REQUEST['id']);

$imp_info = find_all_field('personnel_basic_info','','PBI_ID='.$leave_id->PBI_ID);

// ::::: End Edit Section :::::


// ::::: End Edit Section :::::


$crud      =new crud($table);

if(isset($_GET[$unique]))
$$unique = $_GET[$unique];
else
$$unique = $_POST[$unique];

$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);
$essentialInfo = find_all_field('essential_info','','PBI_ID='.$_SESSION['employee_selected']);

$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));
$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));

$user_leave_rull = find_all_field('hrm_leave_rull_manage','','id='.$PBI->LEAVE_RULE_ID);

$leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type="Casual Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);

$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type="Sick Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);

$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type="Annual" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);


$prev_lv=mysql_num_rows(mysql_query("select * from hrm_leave_info where PBI_ID='".$_SESSION['employee_selected']."' and s_date='".$_REQUEST['s_date']."' and e_date='".$_REQUEST['e_date']."'"));

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
$_REQUEST['leave_status'] = 'Granted';
$_REQUEST['reporting_note'] = $_POST['reporting_note'];
$_REQUEST['s_time'] = $_POST['s_time'];
$_REQUEST['e_time'] = $_POST['e_time'];
$_REQUEST['total_hrs'] = $_POST['total_hrs'];



$crud->update($unique);

//Text Sms

function sms($dest_addr,$sms_text){
          
       
$url = "https://api.mobireach.com.bd/SendTextMessage?Username=aksid&Password=Akhr@2019&From=AKSID_HR";

$fields = array(
    'Username'      => "aksid",
    'Password'      => "Akhr@2019",
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
			
			
			$massage  = "Your requested Short Leave (SHL) is granted\r\n";
			$massage.="Date: ".date('d-M-Y', strtotime($_POST['half_leave_date']))."\r\n";
			$massage.="Time: ".date('h:i a', strtotime($_POST['s_time']))." to ".date('h:i a', strtotime($_POST['e_time']))."\r\n";
			$massage.="Total Hours: ".$_POST['total_hrs']."\r\n";
			
			
	        $sms_result=sms($recipients,$massage);
	
	
 //Text Sms



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
          
       
$url = "https://api.mobireach.com.bd/SendTextMessage?Username=aksid&Password=Akhr@2019&From=AKSID_HR";

$fields = array(
    'Username'      => "aksid",
    'Password'      => "Akhr@2019",
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
			
			
			$massage  = "Your requested Short Leave (SHL) is granted\r\n";
			
			
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
while (list($key, $value)=each($data))
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



<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->
          <div class="">
		  
		  
           
        <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Plain Page</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
				  	 <div class="openerp openerp_webclient_container">
                    <table class="oe_webclient">
                    <tbody>
   
                      <tr>
			
				  
				  
                  <div class="x_content">



<form action="" method="post" enctype="multipart/form-data">
  <div class="oe_view_manager oe_view_manager_current">
    <? include('../../common/title_bar.php');?>
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
                  <div class="oe_form_sheet oe_form_sheet_width"> <?php echo $msggg; ?>
				  
				  <span class="oe_form_sheet oe_form_sheet_width" style=" font-size:12px;"><div align="center">
                    <? 



				  $curMonthTo = date('Y-m-01');



				  $curMonthFrom = date('Y-m-31');



				  



				  $date_dfrnc = date_diff(date_create(date('Y-m-d')), date_create($PBI->PBI_DOJ));



                  $total_job_days = $date_dfrnc->format('%a');



				  


                 if($leave_id->PBI_ID>0){
				 $leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date between "'.$curMonthTo.'" and "'.$curMonthFrom.'" and PBI_ID='.$leave_id->PBI_ID);
				 }else{
				 $leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date between "'.$curMonthTo.'" and "'.$curMonthFrom.'" and PBI_ID='.$_SESSION['employee_selected']);
				 }



				 



				 if($leave_days_half == 1){



				   echo "<h2 style='color:green'>1 Day Short Leave (SHL) Already Availed <br> ১ টি  Short Leave(SHL) ইতিমধ্যে সম্পূর্ণ হয়েছে </h2>";



				 }elseif($leave_days_half == 2){



				   echo "<h2 style='color:green'>2 Day's Short Leave (SHL) Already Availed <br> 2 টি  Short Leave(SHL) ইতিমধ্যে সম্পূর্ণ হয়েছে </h2>";



				 }elseif($leave_days_half == 3 && $total_job_days<365 && $essentialInfo->EMPLOYMENT_TYPE != 'Permanent'){



				   echo "<h2 style='color:red'>3 Day's Short Leave (SHL) Will Deduct 1 day Salary <br> ১ দিনের বেতন কর্তন করা হবে </h2>";



				 }elseif($leave_days_half == 3 && $total_job_days<365){



				   echo "<h2 style='color:red'>3 Day's Short Leave (SHL) Will Deduct 1 day Casual Leave(CL) <br> ১ দিনের Casual Leave(CL) কর্তন করা হবে  </h2>";



				 }elseif($leave_days_half == 3 && $total_job_days>365 && $essentialInfo->EMPLOYMENT_TYPE == 'Permanent'){



				   echo "<h2 style='color:red'>3 Day's Short Leave (SHL) Will Deduct 1 day Annual Leave(AL) <br> ১ দিনের Annual Leave(AL) কর্তন করা হবে  </h2>";



				 }else{



				   echo "<h2></h2>";



				 }



				 ?>
                    </div></span>
                    <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell" width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">
                              <tbody>
                                
                                <tr class="oe_form_group_row">
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">
								  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                    <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['user']['id']?>" type="hidden" />
                                    &nbsp;&nbsp;Leave Types  :</td>
                                  <td class="oe_form_group_cell" colspan="4"> <input type="text" name="type" value="Short Leave (SHL)"  readonly  />                               </td>
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
                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Duration : </td>
                                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><table width="100%" border="0">
                                      <tr>
                                        <td width="1">
                                          <select name="s_time" id="s_time" class="form-control" onchange="totalhrs();" required>



											  <option disabled="disabled">Select Start Time</option>



											 <?

											    if($s_time!=''){

											  ?>



											 <option  value="<?=$s_time?>"><?=date('h:i a', strtotime($s_time));?></option>

											 

											 <? } ?>



											  <option value="<?=date('Y-m-d');?> 08:00:00">08:00 AM</option>



											 <option value="<?=date('Y-m-d');?> 08:30:00">08:30 AM</option>



											<option value="<?=date('Y-m-d');?> 09:00:00">09:00 AM</option>



											   <option value="<?=date('Y-m-d');?> 09:30:00">09:30 AM</option>



											    <option value="<?=date('Y-m-d');?> 10:00:00">10:00 AM</option>



											   <option value="<?=date('Y-m-d');?> 10:30:00">10:30 AM</option>



											    <option value="<?=date('Y-m-d');?> 11:00:00">11:00 AM</option>



											    <option value="<?=date('Y-m-d');?> 11:30:00">11:30 AM</option>



												 <option value="<?=date('Y-m-d');?> 12:00:00">12:00 PM</option>



												 <option value="<?=date('Y-m-d');?> 12:30:00">12:30 PM</option>



												  <option value="<?=date('Y-m-d');?> 13:00:00">01:00 PM</option>



												   <option value="<?=date('Y-m-d');?> 13:30:00">01:30 PM</option>



												     <option value="<?=date('Y-m-d');?> 14:00:00">02:00 PM</option>



													 <option value="<?=date('Y-m-d');?> 14:30:00">02:30 PM</option>



													 <option value="<?=date('Y-m-d');?> 15:00:00">03:00 PM</option>



													 



													   <option value="<?=date('Y-m-d');?> 15:30:00">03:30 PM</option>



													   <option value="<?=date('Y-m-d');?> 16:00:00">04:00 PM</option>



													    <option value="<?=date('Y-m-d');?> 16:30:00">04:30 PM</option>

														

														<option value="<?=date('Y-m-d');?> 17:00:00">05:00 PM</option>



														<option value="<?=date('Y-m-d');?> 17:30:00">05:30 PM</option>
											 </select>
										 </td>
                                        <td width="80"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">-to- </span></div></td>
                                        <td width="1"><span class="oe_form_group_cell oe_form_group_cell_label">
                                         
                                          <select name="e_time" id="e_time" onchange="totalhrs();" required>



											  <option disabled="disabled">Select End Time</option>



											  

                                              <?

											    if($e_time!=''){

											  ?>

											 <option value="<?=$e_time?>"><?=date('h:i a', strtotime($e_time));?></option>



											 <? 

											  }

											 ?>



											  

                                               <option value="<?=date('Y-m-d');?> 08:30:00">08:30 AM</option>

											   

											  <option value="<?=date('Y-m-d');?> 09:00:00">09:00 AM</option>



											   <option value="<?=date('Y-m-d');?> 09:30:00">09:30 AM</option>



											    <option value="<?=date('Y-m-d');?> 10:00:00">10:00 AM</option>



											   <option value="<?=date('Y-m-d');?> 10:30:00">10:30 AM</option>

											   

											   <option value="<?=date('Y-m-d');?> 11:00:00">11:00 AM</option>



											    <option value="<?=date('Y-m-d');?> 11:30:00">11:30 AM</option>



												 <option value="<?=date('Y-m-d');?> 12:00:00">12:00 PM</option>



												 <option value="<?=date('Y-m-d');?> 12:30:00">12:30 PM</option>



												  <option value="<?=date('Y-m-d');?> 13:00:00">01:00 PM</option>



												   <option value="<?=date('Y-m-d');?> 13:30:00">01:30 PM</option>



												     <option value="<?=date('Y-m-d');?> 14:00:00">02:00 PM</option>



													 <option value="<?=date('Y-m-d');?> 14:30:00">02:30 PM</option>



													 <option value="<?=date('Y-m-d');?> 15:00:00">03:00 PM</option>



													 



													   <option value="<?=date('Y-m-d');?> 15:30:00">03:30 PM</option>



													   <option value="<?=date('Y-m-d');?> 16:00:00">04:00 PM</option>



													    <option value="<?=date('Y-m-d');?> 16:30:00">04:30 PM</option>



														<option value="<?=date('Y-m-d');?> 17:00:00">05:00 PM</option>



														<option value="<?=date('Y-m-d');?> 17:30:00">05:30 PM</option>



														<option value="<?=date('Y-m-d');?> 18:00:00">06:00 PM</option>
											 </select>
                                          </span></td>
                                        <td>

 										   &nbsp;&nbsp;<b id="total_leave"> Total <input type="text" name="total_hrs" id="total_hrs" value="<? if($total_hrs) echo $total_hrs;?>" style="width:5px;"  readonly=""/>



                                          Hrs (Max 3 Hrs)



                                          </b></td>
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
                                    <textarea name="reason" style="width:500px;" required><?=$reason?></textarea>
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
								  $dept = find_a_field('personnel_basic_info','PBI_DEPARTMENT','PBI_ID='.$unique_pbi_id); 
								  $projec_t = find_a_field('personnel_basic_info','JOB_LOCATOIN','PBI_ID='.$unique_pbi_id); 
								  if($dept>0){
								  foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.PBI_DESIGNATION=d.DESG_ID and p.PBI_JOB_STATUS="In Service" and PBI_DEPARTMENT="'.$dept.'" and PBI_ID != '.$_SESSION['user']['id'].' order by p.PBI_NAME');
								    }else{
									 foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.PBI_DESIGNATION=d.DESG_ID and p.PBI_JOB_STATUS="In Service" and JOB_LOCATION="'.$projec_t.'" and PBI_ID != '.$_SESSION['user']['id'].' order by p.PBI_NAME');
									}
								  ?>
                                  </select>
                                    <input type="hidden" name="reporting_auth" value="<?=find_a_field('essential_info','ESSENTIAL_REPORTING','PBI_ID='.$_SESSION['user']['id'])?>" />                                
                                <tr class="oe_form_group_row">
                                  <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Approve/Not Approve Note								   </td>
                                  <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4"><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <textarea name="reporting_note" id="reporting_note" style="width:500px;" ><?=$reporting_note?>
                                    </textarea>
                                  </span>
                                </tbody>
                          </table></td>
						 
                        </tr>
                        <tr>
                          <td><div align="center">
                                
							  <? if($_SESSION['employee_selected']==101656){?>
                              <span class="oe_form_buttons_edit" style="display: inline;">
                              <button name="granted" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Granted</button>
                              </span>
							  <span class="oe_form_buttons_edit" style="display: inline;">
                              <button name="not_granted" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Not Granted</button>
                              </span>
                              <? }?>
							 
							  
                            </div></td>
                        </tr>
                      </tbody>
                    </table>
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






include_once("../../template/footer.php");



?>