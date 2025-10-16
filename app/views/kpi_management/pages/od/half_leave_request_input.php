<?php
@session_start();
ob_start();
require_once "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Leave Application Form';			// Page Name and Page Title
$page="half_leave_request_input.php";		// PHP File Name

$root='leave';

$table='hrm_leave_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='type';				// For a New or Edit Data a must have data field

$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');

// ::::: End Edit Section :::::


// ::::: End Edit Section :::::


$crud      =new crud($table);

if(isset($_GET[$unique]))
$$unique = $_GET[$unique];
else
$$unique = $_POST[$unique];


$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);
$essentialInfo = find_all_field('essential_info','','PBI_ID='.$_SESSION['employee_selected']);
$status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);

//$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));
//$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));

$user_leave_rull = find_all_field('hrm_leave_rull_manage','','id='.$PBI->LEAVE_RULE_ID);

$leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type="Casual Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);

$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type="Sick Leave" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);

$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type="Annual" and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$_SESSION['employee_selected']);


$prev_lv=mysql_num_rows(mysql_query("select * from hrm_leave_info where PBI_ID='".$_SESSION['employee_selected']."' and s_date='".$_REQUEST['s_date']."' and e_date='".$_REQUEST['e_date']."'"));

//echo $user_leave_rull->MED. ' OK '.$_POST['type']. ' lv '.$leave_days_sick;

if(isset($_POST['insert']))
{



	
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

$_REQUEST['half_or_full'] = "Half";

$_REQUEST['entry_at'] = date('Y-m-d H:i:s');
//$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));
//$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));
//$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));

if($_FILES['att_file']['tmp_name']!=""){
$_REQUEST['att_file']= $target_file;}
$crud->insert();


move_uploaded_file($_FILES["att_file"]["tmp_name"], '../../'.$target_file);

$type=1;
$msg='New Entry Successfully Inserted.';


unset($_POST);
unset($$unique);
echo '<script type="text/javascript">parent.parent.document.location.href = "../leave/view_leave_half.php?notify=12";</script>';


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
parent.parent.document.location.href = "view_leave_half.php?notify=12";
</script>';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
parent.parent.document.location.href = "view_leave_half.php?notify=12";
</script>';
		$type=1;
		$msg='Successfully Deleted.';
}

if(isset($_POST['reportingAuthority']))
{		
unset($_REQUEST);
$_REQUEST['leave_status'] = 'Approve';
$_REQUEST['incharge_status'] = 'Approve';
$crud->update($unique);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge_half.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}

if(isset($_POST['departmentHead']))
{		
unset($_REQUEST);
$_REQUEST['leave_status'] = 'Approve';
$crud->update($unique);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}

if(isset($_POST['hrapprove']))
{		
$_REQUEST['leave_status'] = 'Granted';
$crud->update($unique);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}

if(isset($$unique))
{+
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);




if(isset($_POST['reportingAuthority']))
{
if($PBI_DEPT_HEAD>0)		
$_REQUEST['leave_status'] = 'Approve';
else
$_REQUEST['leave_status'] = 'Approve';

$crud->update($unique);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge_half.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}

if(isset($_POST['departmentHead']))
{		
$_REQUEST['leave_status'] = 'Approve';
$crud->update($unique);

echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php?notify=12";
</script>';

$type=1;
$msg='Successfully Deleted.';
}
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
  
  function totalhrs(){
     
	 var sTime = document.getElementById('s_time').value;
	  var eTime = document.getElementById('e_time').value;
	  
	  var t1 = Date.parse(sTime)
	  var t2 = Date.parse(eTime)
	  
	  
	  document.getElementById('total_hrs').value = ((t2-t1)/60)/60000;
  }
         					  
 
</script>
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
				 <?
				 $leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Half Leave" and leave_status="GRANTED" and PBI_ID='.$_SESSION['employee_selected']);
				 if($leave_days_half == 1){
				   echo "<h2 style='color:green'>1 Day Short Leave (SHL) Already Availed</h2>";
				 }elseif($leave_days_half == 2){
				   echo "<h2 style='color:green'>2 Day's Short Leave (SHL) Already Availed</h2>";
				 }elseif($leave_days_half == 3){
				   echo "<h2 style='color:red'>3 Day's Short Leave (SHL) Will Deduct 1 day Salary </h2>";
				 }else{
				   echo "<h2></h2>";
				 }
				 ?>
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
                                  <td class="oe_form_group_cell" colspan="4">
								  <input type="text" name="type" value="Short Leave (SHL)"  readonly  />                             </td>
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
                                          
										     <select name="s_time" id="s_time" required>
											  <option disabled="disabled">Select Start Time</option>
											    <option></option>
											 <option><?=$s_time?></option>
											 <option value="<?=date('d-M-Y');?> 08:30:00">08:30 AM</option>
											<option value="<?=date('d-M-Y');?> 09:00:00">09:00 AM</option>
											   <option value="<?=date('d-M-Y');?> 09:30:00">09:30 AM</option>
											    <option value="<?=date('d-M-Y');?>10:00:00">10:00 AM</option>
											   <option value="<?=date('d-M-Y');?> 10:30:00">10:30 AM</option>
											    <option value="<?=date('d-M-Y');?> 11:30:00">11:30 AM</option>
												 <option value="<?=date('d-M-Y');?> 12:00:00">12:00 PM</option>
												 <option value="<?=date('d-M-Y');?> 12:30:00">12:30 PM</option>
												  <option value="<?=date('d-M-Y');?> 13:00:00">01:00 PM</option>
												   <option value="<?=date('d-M-Y');?> 13:30:00">01:30 PM</option>
												     <option value="<?=date('d-M-Y');?> 14:00:00">02:00 PM</option>
													 <option value="<?=date('d-M-Y');?> 14:30:00">02:30 PM</option>
													 <option value="<?=date('d-M-Y');?> 15:00:00">03:00 PM</option>
													 
													   <option value="<?=date('d-M-Y');?> 15:30:00">03:30 PM</option>
													   <option value="<?=date('d-M-Y');?> 16:00:00">04:00 PM</option>
													    <option value="<?=date('d-M-Y');?> 16:30:00">04:30 PM</option>
											   
											 </select>
										  </td>
                                        <td width="80"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">-to- </span></div></td>
                                        <td width="1"><span class="oe_form_group_cell oe_form_group_cell_label">
                                         
                                         <select name="e_time" id="e_time" onchange="totalhrs();" required>
											  <option disabled="disabled">Select End Time</option>
											   <option></option>
											 <option><?=$e_time?></option>
											 
											  
											  <option value="<?=date('d-M-Y');?> 09:00:00">09:00 AM</option>
											   <option value="<?=date('d-M-Y');?> 09:30:00">09:30 AM</option>
											    <option value="<?=date('d-M-Y');?> 10:00:00">10:00 AM</option>
											   <option value="<?=date('d-M-Y');?> 10:30:00">10:30 AM</option>
											    <option value="<?=date('d-M-Y');?> 11:30:00">11:30 AM</option>
												 <option value="<?=date('d-M-Y');?> 12:00:00">12:00 PM</option>
												 <option value="<?=date('d-M-Y');?> 12:30:00">12:30 PM</option>
												  <option value="<?=date('d-M-Y');?> 13:00:00">01:00 PM</option>
												   <option value="<?=date('d-M-Y');?> 13:30:00">01:30 PM</option>
												     <option value="<?=date('d-M-Y');?> 14:00:00">02:00 PM</option>
													 <option value="<?=date('d-M-Y');?> 14:30:00">02:30 PM</option>
													 <option value="<?=date('d-M-Y');?> 15:00:00">03:00 PM</option>
													 
													   <option value="<?=date('d-M-Y');?> 15:30:00">03:30 PM</option>
													   <option value="<?=date('d-M-Y');?> 16:00:00">04:00 PM</option>
													    <option value="<?=date('d-M-Y');?> 16:30:00">04:30 PM</option>
											   
											 </select>
											 
                                          </span>
										 
										 
										  
										 
										  
										     
										  </td>
                                        <td>
										
 										   &nbsp;&nbsp;<b id="total_leave"> Total <input type="text" name="total_hrs" id="total_hrs" value="" style="width:5px;"  readonly=""/>
                                          Hrs (Max 3 Hrs)
                                          </b></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Reason :</td>
                                  <td class="oe_form_group_cell" colspan="4"><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <textarea name="reason" style="width:500px;" required><?=$reason?></textarea>
                                  </span></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Supporting Doc: </td>
                                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="file" name="att_file" /><input type="hidden" name="total_days" value="1"></td>
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
</script>
                                    <?php do_calander('#half_leave_date','-0','+30');?>
                                    <input required name="half_leave_date" type="text" id="half_leave_date" value="<?php if($half_leave_date) echo date('d-m-Y',strtotime($half_leave_date)); ?>" /></td>
                                </tr>
								

                                <tr class="oe_form_group_row">
                                  <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Substitue Associate :								   </td>
                                  <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4"><select name="leave_responsibility_name" id="leave_responsibility_name" style="width:420px;" >
								  <? foreign_relation('personnel_basic_info p, designation d','p.PBI_ID','concat(p.PBI_NAME," :: ",d.DESG_DESC)',$leave_responsibility_name,'p.PBI_DESIGNATION=d.DESG_ID and p.PBI_JOB_STATUS="In Service" and PBI_DEPARTMENT="'.$PBI->PBI_DEPARTMENT.'" and PBI_ID != '.$_SESSION['user']['id'].' order by p.PBI_NAME');?>
								  
                                    </select>
									 <input type="hidden" name="reporting_auth" value="<?=find_a_field('essential_info','ESSENTIAL_REPORTING','PBI_ID='.$_SESSION['user']['id'])?>" />
                              </tbody>
                          </table></td>
						 
                        </tr>
                        <tr>
                          <td><div align="center">
                              <? if(!isset($_GET[$unique])){?>
                              <span class="oe_form_buttons_edit" style="display: inline;">
                              <button name="insert" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Apply</button>
                              </span>
                              <? }?>
                             
							  <? if(isset($_GET[$unique]) && $_SESSION['employee_selected']==$PBI_IN_CHARGE){?>
                              <span class="oe_form_buttons_edit" style="display: inline;">
                              <button name="reportingAuthority" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Approve</button>
                              </span>
                              <? }?>
							  <? if(isset($_GET[$unique]) && $PBI_DEPT_HEAD==$_SESSION['employee_selected']){?>
                              <span class="oe_form_buttons_edit" style="display: inline;">
                              <button name="departmentHead" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Approve</button>
                              </span>
                              <? }?>
							  
							  <?
								   if($status == 'PENDING'){
								?>
								
								 <? if(isset($_GET[$unique]) && $PBI_ID==$_SESSION['employee_selected']){?>
                              <span class="oe_form_buttons_edit" style="display: inline;">
                              <button name="update" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Update</button>
                              </span>
                              <? }?>
							  
							  <? if(isset($_GET[$unique])){?>
                              <span class="oe_form_buttons_edit" style="display: inline;">
                              <button name="delete" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Cancel</button>
                              </span>
                              <? } } ?>
							  
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
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>
