<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
date_default_timezone_set('Asia/Dhaka');
?>

<script>
function getgroupid() {

	var emp_id=$("#emp_id").val();

	$.ajax({

	type: "POST",

	url: "hrm_user_access_ajax.php",

	data:'emp_id='+emp_id,

	success: function(data){

		$("#auto_emp_id").html(data);

	}

	});

}
</script>


<?
//var_dump($_SESSION);
// ::::: Start Edit Section ::::: 
$title='Create User Access';			// Page Name and Page Title
do_calander('#fdate');
// ::::: Edit This Section ::::: 
$table='hrm_user_access';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='user_name';				// For a New or Edit Data a must have data field
// ::::: End Edit Section :::::
$crud      =new crud($table);
if(isset($_POST['search'])){

$crud->insert();
}
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','PBI_JOB_STATUS="In Service"','emp_id');
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','PBI_JOB_STATUS="In Service"','emp_id2');
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

if(isset($_POST['update'])){
$id = $_POST['emp_id'];
$password = $_POST['password'];
$res2 = "UPDATE  hrm_user_access SET  password = $password WHERE  emp_id =$id;";
db_query($res2);
echo 'Update Successfull';
}

?>




<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form">
                    <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
<div class="oe_form_sheetbg" style="min-height:10px;">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">



<form action="" method="post">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="10%" height="35" colspan="3" align="right"><strong>Employee ID :</strong></td>
    <td><strong>
	<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
	<input name="entry_by" id="entry_by" value="<?=$_SESSION['user']['id']?>" type="hidden" />
	<input name="group_id" id="group_id" value="<?=$_SESSION['user']['group']?>" type="hidden" />
	<input name="entry_at" id="entry_at" value="<?=date('Y-m-d H:i:s');?>" type="hidden" />
	<span id="auto_emp_id"></span>
      <input type="text" name="emp_id" id="emp_id" style="width:200px;" value="<?=($_POST['emp_id']!='')?$_POST['emp_id']:'';?>" required onblur="getgroupid()" class="form-control"/>
    </strong></td>
    </tr>
  <tr>
    <td height="35" colspan="3" align="right"><strong>Password:</strong></td>
    <td><strong>
      <input type="password" name="password" id="password" style="width:200px;"  required="required" class="form-control" />
    </strong></td>
  </tr>
  
  <tr>
    <td height="35" colspan="4"><div align="center">
      <input name="search" type="submit" id="search" value="Create" class="btn1 btn1-bg-submit" />
    </div></td>
    </tr>
</form>
<tr><td height="35" colspan="3" align="right">&nbsp;</td><td>&nbsp;</td></tr>
<tr><td height="35" colspan="3" align="right">&nbsp;</td><td>&nbsp;</td></tr>
<tr><td height="35" colspan="3" align="right">&nbsp;</td><td>&nbsp;</td></tr>

<form method="post" action=""> 
<tr><td height="35" colspan="3" align="right">Code</td>
    <td><input type="text" name="emp_id" style="width:200px;"  class="form-control"/></td>
</tr>
<tr><td height="35" colspan="3" align="right">Password</td><td><input type="text" name="password" style="width:200px;"  class="form-control"/></td></tr>
<tr><td scope="row">&nbsp;</td><td><input name="update" type="submit" value="Update" class="btn1 btn1-bg-update" /></td></tr>
</form>

<tr><td height="35" colspan="3" align="right">&nbsp;</td><td>&nbsp;</td></tr>
<tr><td height="35" colspan="3" align="right">&nbsp;</td><td>&nbsp;</td></tr>
<tr><td height="35" colspan="3" align="right">&nbsp;</td><td>&nbsp;</td></tr>

<form method="post" action="">  
<tr>
    <td height="35"  align="right"><strong>Employee ID :</strong></td>
    <td colspan="2"><strong><input type="text" name="emp_id2" id="emp_id2" style="width:200px;" value="<?=($_POST['emp_id2']!='')?$_POST['emp_id2']:'';?>" class="form-control"/></strong></td>
	<td height="35"><input name="search2" type="submit" id="search2" value="SEARCH" class="btn1 btn1-bg-submit" /></td>
</tr>

</table>


<?
if(isset($_POST['search2'])){

$con=" and a.emp_id=".$_POST['emp_id2'];}
$id = $_POST['emp_id2'];
 $res = "select 
a.emp_id, a.emp_id, a.user_name, a.password, u.group_name 
from hrm_user_access a, user_group u 
where 
a.group_id=u.id 
and a.emp_id =$id
";
echo $crud->link_report($res,$link);	
?>		  
</form>



</div></div></div></div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
		 
  </div>




<?


require_once SERVER_CORE."routing/layout.bottom.php";
?>