<?php
@session_start();
ob_start();
require_once "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Leave Application Form';			// Page Name and Page Title
$page="leave_request_input.php";		// PHP File Name

$root='leave';

$table='hrm_leave_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='type';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


// ::::: End Edit Section :::::
$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);


$full_leave = find_all_field('hrm_leave_info','','id='.$_GET['leave_id']);
$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();

$target_dir = "../../../picture/leave_files/";
$target_file = $target_dir . $now.basename($_FILES["att_file"]["name"]);


//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
$_REQUEST['entry_at'] = date('Y-m-d H:i:s');
$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));
$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));
$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));
//$_REQUEST['attachment_file']= $target_file;
$crud->insert();


move_uploaded_file($_FILES["att_file"]["tmp_name"], $target_file);

$type=1;
$msg='New Entry Successfully Inserted.';


unset($_POST);
unset($$unique);
echo '<script type="text/javascript">parent.parent.document.location.href = "../leave/view_leave.php?notify=11";</script>';

}


//for Modify..................................


//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php";
</script>';
		$type=1;
		$msg='Successfully Deleted.';
}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);


//echo $full_leave->PBI_DEPT_HEAD;
if(isset($_POST['update']))
{
if($full_leave->PBI_DEPT_HEAD!=""){
$_REQUEST['leave_status'] = "REC. by INCHARGE/SUPERVISOR";
}else{
$_REQUEST['leave_status'] = "GRANTED";
}

$_REQUEST['incharge_aprv_at'] = date('Y-m-d H:i:s');
$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));
$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));
$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));

		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php";
</script>';
}


if(isset($_POST['cancel']))
{
$_REQUEST['leave_status'] = "CANCELLED";
$_REQUEST['incharge_cncl_at'] = date('Y-m-d H:i:s');


		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
				echo '<script type="text/javascript">
parent.parent.document.location.href = "../leave/view_leave_incharge.php";
</script>';
}
//echo $full_leave->PBI_DEPT_HEAD;
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


<form action="?leave_id=<?=$_GET['leave_id']?>" method="post" enctype="multipart/form-data">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">

<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

<table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td colspan="1" class="oe_form_group_cell" width="100%">
			
			<table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">
              <tbody>
			   <tr class="oe_form_group_row">
                                  <td bgcolor="#FFFFFF" colspan="5" class="oe_form_group_cell oe_form_group_cell_label"> <div align="right" class="style1"><a href="hrm_detail_leave_report.php?id=<?php echo $full_leave->PBI_ID?>" target="_blank" > View Leave Details &gt;&gt; </a> </div></td>
                                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Name :</td>
                  <td bgcolor="#E8E8E8" colspan="4" class="oe_form_group_cell">
				  <?
				  $sql =  @mysql_query("select PBI_ID,PBI_NAME,PBI_DEPARTMENT,PBI_DESIGNATION from  personnel_basic_info where PBI_ID = ".$full_leave->PBI_ID."");
				  $row = @mysql_fetch_object($sql);
				  $full_name = $row->emptitle.' '.$row->first_name.' '.$row->middle_name.' '.$row->last_name;
				  $full_desg = find_a_field('designation','DESG_DESC','DESG_ID='.$row->PBI_DESIGNATION);
				  $full_dept = find_a_field('department','DEPT_DESC','DEPT_ID='.$row->PBI_DEPARTMENT);
				  ?>
				  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$_GET['leave_id']?>" type="hidden" />
				  <input name="PBI_ID" id="PBI_ID" value="<?=$row->PBI_ID?>" type="hidden" />
				  <input name="first_name_bangla" type="text" id="first_name_bangla" value="<?php echo $row->PBI_NAME; ?>"  style="width:420px;"/>                  </td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Department :</label></td>
                  <td class="oe_form_group_cell"><input name="department" type="text" id="department" value="<?=$full_dept?>" /></td>
                  
                  <td colspan="2" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Designation :</span></td>
                  <td class="oe_form_group_cell"><input name="designation" type="text" id="designation" value="<?=$full_desg?>" /></td>
                  
                  <td class="oe_form_group_cell">&nbsp;</td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Leave Types  :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4">
<?php /*?>				  <?
$sql = 'select 1 from hrm_personal_information where gender="female" and marital_status="Married" and PBI_ID="'.$_SESSION['employee_selected'].'"';
$query = mysql_query($sql);
$count = mysql_num_rows($query);
?>
<select onChange="" id="leave_type" name="leave_type" required>
<option <?=($leave_type=='CASUAL')?'Selected':'';?><?=($leave_type=='')?'Selected':'';?>>CASUAL LEAVE</option>
<option <?=($leave_type=='SICK')?'Selected':'';?>>SICK LEAVE</option>
<option <?=($leave_type=='OUT COUNTRY')?'Selected':'';?>>OUT COUNTRY LEAVE</option>
<? if($count>0){?><option <?=($leave_type=='MATERNITY')?'Selected':'';?>>MATERNITY</option><? }?>
</select><?php */?>




<select name="type" id="type">
				  <option></option>
				  <option selected="selected">Casual Leave</option>
				  <option <?=($full_leave->type=='Sick Leave')?'Selected':'';?> >Sick Leave</option>
				  <option <?=($full_leave->type=='Maternity Leave')?'Selected':'';?> >Maternity Leave</option>
				  <option <?=($full_leave->type=='Annual')?'Selected':'';?> >Annual </option>
				  <option <?=($full_leave->type=='Compensatory Off')?'Selected':'';?> >Compensatory Off</option>
				  <option <?=($full_leave->type=='LWP (Leave Without Pay)')?'Selected':'';?> >LWP (Leave Without Pay)</option>
				  <option <?=($full_leave->type=='Special Leave')?'Selected':'';?> >Special Leave (Leave With Pay)</option>
				  </select>								 </td>
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
                
                     <tr class="oe_form_group_row" id="leave_MATERNITY">
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Reason :</td>
                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><textarea name="reason" style="width:500px;" required><?=$full_leave->reason?></textarea></td>
                  </tr>
           
                <!--<tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;সংযুক্তি :</td>
                  <td colspan="3" class="oe_form_group_cell"><input type="file" name="att_file" /></td>
                  </tr>-->
                
                <tr class="oe_form_group_row">
                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Duration : </td>
                  <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><table width="100%" border="0">
                    <tr>
                      <td width="1">
					  <?
					  do_calander('#s_date','-0','+30');
					  ?>
					  <input name="s_date" type="text" id="s_date" required value="<?php echo $full_leave->s_date; ?>" /></td>
                      <td width="80"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">-to-
                        
                      </span></div></td>
                      <td width="1"><span class="oe_form_group_cell oe_form_group_cell_label">
<?
do_calander('#e_date','-0','+30');
?><input name="e_date" type="text" id="e_date" required value="<?php echo $full_leave->e_date; ?>" />
                      </span></td>
                      <td>
					  

<input name="total_days" type="hidden" id="total_days"  value="<?php echo $full_leave->total_days; ?>" /> 
&nbsp;&nbsp;<b id="total_leave"> Total <? if($full_leave->s_date!=''){$diff = date_diff(date_create($full_leave->s_date),date_create($full_leave->e_date)); echo $diff->format("%a")+1;?> Days <? }?></b></td>
                    </tr>
                  </table></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Joining Date After Leave : </td>
                  <td class="oe_form_group_cell" colspan="4">
<script language="javascript">

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

<?php do_calander('#leave_join_date','-0','+30');?>
<input required name="leave_join_date" type="text" id="leave_join_date" value="<?php  echo $full_leave->leave_join_date; ?>" /></td>
                  </tr>
				  <tr class="oe_form_group_row">
                  <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Leave Address  : </td>
                  <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4"><textarea required name="leave_address" style="width:500px;"><?=$full_leave->leave_address?></textarea></td>
				  </tr>
				  <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Contact No.  : </td>
                  <td class="oe_form_group_cell" colspan="4"><input name="leave_mobile_number" type="text" id="leave_mobile_number" value="<?=$full_leave->leave_mobile_number?>"/></td>
                  </tr>
				  <tr class="oe_form_group_row">
                  <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Duties would be carried out by  : </td>
                  <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4">
				  
				   <select name="leave_responsibility_name" id="leave_responsibility_name" style="width:420px;" required >
<? foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_NAME," :: ",EMP_ID)',$full_leave->leave_responsibility_name,' 1   and PBI_JOB_STATUS=1 and PBI_DEPARTMENT="'.$row->PBI_DEPARTMENT.'"   and PBI_ID = '.$full_leave->leave_responsibility_name);?>
                   </select>
                  <tr class="oe_form_group_row">
                    <td  bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Note : </td>
                    <td  bgcolor="#E8E8E8" class="oe_form_group_cell" colspan="4"><textarea name="note" style="width:500px;"><?=$full_leave->note?>
                    </textarea>                  
                  </tbody></table>
            </td>
            </tr>
			<tr><td><div align="center">
			
	<span class="oe_form_buttons_edit" style="display: inline;">
      <button style="float:left" name="delete" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Delete Leave Application</button>
    </span>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button  name="cancel" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Cancel Leave Application</button>
    </span>
    <? if($full_leave->leave_status=="VERIFIED by HR"){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button style="float:right" name="update" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Recommended by INCHARGE / Supervisor</button>
    </span>
    <? }?>
			    </div></td></tr></tbody></table>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
    </div>
</form>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>