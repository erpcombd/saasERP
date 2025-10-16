<?php
session_start();
ob_start();
require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Posting Entry Management';			// Page Name and Page Title
$page="posting _entey.php";		// PHP File Name
$input_page="posting _entey_input.php";
$root='hrm';

$table='posting';		// Database Table Name Mainly related to this page
$unique='POSTING_CODE';			// Primary Key of this Database table
$shown='POSTING_DESIGNATION';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$required_id=find_a_field($table,$unique,"PBI_ID='".$_SESSION['employee_selected']."'");
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
if(isset($_POST[$shown]))
{	if(isset($_POST['insert']))
		{		
				$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
				unset($_POST[$unique]);
				$crud->insert();
				
				$vars['PBI_ID']=$_SESSION['employee_selected'];

$vars['PBI_DESIGNATION']=$_POST['POSTING_DESIGNATION'];
$vars['PBI_DOMAIN']=$_POST['POSTING_DOMAIN'];
$vars['PBI_DEPARTMENT']=$_POST['POSTING_DEPARTMENT'];
$vars['PBI_PROJECT']=$_POST['POSTING_PROJECT'];
$vars['PBI_ZONE']=$_POST['POSTING_ZONE'];
$vars['PBI_AREA']=$_POST['POSTING_AREA'];
$vars['PBI_BRANCH']=$_POST['POSTING_BRANCH'];
db_update('personnel_basic_info', $vars['PBI_ID'], $vars, 'PBI_ID');

				$type=1;
				$msg='New Entry Successfully Inserted.';
				unset($_POST);
				unset($$unique);
$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
		}
	//for Modify..................................
	if(isset($_POST['update']))
	{
				$vars['PBI_ID']=$_SESSION['employee_selected'];

$vars['PBI_DESIGNATION']=$_POST['POSTING_DESIGNATION'];
$vars['PBI_DOMAIN']=$_POST['POSTING_DOMAIN'];
$vars['PBI_DEPARTMENT']=$_POST['POSTING_DEPARTMENT'];
$vars['PBI_PROJECT']=$_POST['POSTING_PROJECT'];
$vars['PBI_ZONE']=$_POST['POSTING_ZONE'];
$vars['PBI_AREA']=$_POST['POSTING_AREA'];
$vars['PBI_BRANCH']=$_POST['POSTING_BRANCH'];
db_update('personnel_basic_info', $vars['PBI_ID'], $vars, 'PBI_ID');

				$crud->update($unique);
				$type=1;
	}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>

<form action="" method="post" enctype="multipart/form-data">
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
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table width="1171" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
            <tbody><tr class="oe_form_group_row">
            <td colspan="1" class="oe_form_group_cell" width="50%"><table width="1155" height="288" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell" width="47%"><table width="546" height="181" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                    <tbody>
                        <tr class="oe_form_group_row">
                          <td height="29" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Designation :</label></td>
                          <td colspan="1" class="oe_form_group_cell"><select name="POSTING_DESIGNATION" id="POSTING_DESIGNATION">
                              <? foreign_relation('designation','DESG_SHORT_NAME','DESG_DESC',$POSTING_DESIGNATION);?>
                            </select>
                              <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td width="35%" height="28" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Domain :</td>
                          <td width="65%" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="POSTING_DOMAIN" id="POSTING_DOMAIN">
                            <? foreign_relation('domai','DOMAIN_SHORT_NAME','DOMAIN_DESC',$POSTING_DOMAIN);?>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td height="29" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Project :</td>
                          <td colspan="1" class="oe_form_group_cell"><select name="POSTING_PROJECT">
                              <? foreign_relation('project','PROJECT_SHORT_NAME','PROJECT_DESC',$POSTING_PROJECT);?>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td height="26" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Department :</td>
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><select name="POSTING_DEPARTMENT">
                              <? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$POSTING_DEPARTMENT);?>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;  Region :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="POSTING_REGION">
                              <? foreign_relation('region','region_id','region_name',$POSTING_REGION);?>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                          <td colspan="1" class="oe_form_group_cell">&nbsp;</td>
                        </tr>
                      </tbody>
                  </table></td>
                  <td colspan="1" class="oe_form_group_cell oe_group_right" width="53%"><table width="569" height="182" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                    <tbody>
                      <tr class="oe_form_group_row">
                        <td width="25%" height="31" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Zone :</label></td>
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell" width="75%"><select name="POSTING_ZONE">
                              <? foreign_relation('zon','ZONE_NAME','ZONE_NAME',$POSTING_ZONE);?>
                          </select></td>
                      </tr>
                        <tr class="oe_form_group_row">
                          <td height="27" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Area :</td>
                          <td colspan="1" class="oe_form_group_cell"><select name="POSTING_AREA">
                               <? foreign_relation('area','AREA_NAME','AREA_NAME',$POSTING_AREA );?>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td height="31" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Branch :</td>
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><select name="POSTING_BRANCH">
                              <? foreign_relation('branch','BRANCH_NAME','BRANCH_NAME',$POSTING_BRANCH);?>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td height="29" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Posting By :</label></td>
                          <td colspan="1" class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date"><span>
                            <input value="" id="dp" class="oe_datepicker_container hasDatepicker" disabled="disabled" style="display: none;" type="text" />
                            <input name="POSTING_BY" type="text" id="POSTING_BY" value="<?=$POSTING_BY?>" />
                          </span></span></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td height="27" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Memo No :</td>
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                            <input name="POSTING_MEMO" type="text" id="POSTING_MEMO" value="<?=$POSTING_MEMO?>" />
                          </span></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                          <td colspan="1" class="oe_form_group_cell">&nbsp;</td>
                        </tr>
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table>
            </td>
            <td colspan="1" class="oe_form_group_cell oe_group_right" width="50%">&nbsp;</td>
            </tr></tbody></table></div>
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