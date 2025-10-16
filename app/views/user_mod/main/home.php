<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='User Management';			// Page Name and Page Title
$page="create_user.php";		// PHP File Name

$table='user_activity_management';		// Database Table Name Mainly related to this page
$unique='user_id';			// Primary Key of this Database table
$shown='username';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];
$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert']))
{		
$proj_id			= $_SESSION['proj_id'];
$now				= time();


$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['update']))
{

		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';
}
}

if(isset($$unique))
{
echo $condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
var_dump($data);
foreach ($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>


<form action="" method="post">
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
    <? include('../../common/input_bar.php');?>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <?=$title?>
    </label><span class="oe_form_field oe_form_field_char oe_inline">
        
        
            <span class="oe_form_char_content"></span>
        
    </span></h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell" width="50%"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Full Name :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="fname" type="text" id="fname" value="<?=$fname?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Mobile No:</label></td>
                  <td colspan="1" class="oe_form_group_cell"><input name="mobile" type="text" id="mobile" value="<?=$mobile?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td width="1%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Designation:</label></td>
                  <td width="99%" colspan="1" class="oe_form_group_cell"><input name="designation" type="text" id="designation" value="<?=$designation?>" /></td>
                </tr>
                </tbody></table></td><td colspan="1" class="oe_form_group_cell oe_group_right" width="50%"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label>User Type:</label></td><td colspan="1" class="oe_form_group_cell" width="99%"><select name="level">
      <? foreign_relation('user_type','user_level','user_type_name_show',$level);?>
    </select></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label>UserName:</label></td><td colspan="1" class="oe_form_group_cell" width="99%"><span class="oe_form_field oe_datepicker_root oe_form_field_date"><span>
        
        <input value="" id="dp1358603602645" class="oe_datepicker_container hasDatepicker" disabled="disabled" style="display: none;" type="text">
        <input name="username" type="text" id="username" value="<?=$username?>" />
    </span></span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label>Password:</label></td><td colspan="1" class="oe_form_group_cell" width="99%"><input name="password" type="text" id="password" value="<?=$password?>" /></td></tr></tbody></table></td></tr></tbody></table></div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div><div style="display: none;" class="oe_record_thread">
        <div class="oe_mail-placeholder">
        </div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
    </div>
</form>
<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>