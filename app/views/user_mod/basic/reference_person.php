<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Reference Person Management';			// Page Name and Page Title
$page="reference_person.php";		// PHP File Name
$input_page="reference_person_input.php";
$root='hrm';

$table='reference_person';		// Database Table Name Mainly related to this page
$unique='RPERSON_ID';			// Primary Key of this Database table
$shown='RPERSON_F_NAME';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
if(isset($_POST[$shown]))
{	if(isset($_POST['insert']))
		{		
				$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
				$crud->insert();
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
				$crud->update($unique);
				$type=1;
	}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
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
          </h1><table width="781" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
            <tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell" width="51%"><table width="391" height="248" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                      <tbody>
                        <tr class="oe_form_group_row">
                          <td width="49%" height="28" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;1st Reference Person Name :</td>
                          <td bgcolor="#E8E8E8" width="51%" colspan="1" class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                              <input name="RPERSON_F_NAME" type="text" id="RPERSON_F_NAME" value="<?=$RPERSON_F_NAME?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td height="26" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Profession  :</label></td>
                          <td colspan="1" class="oe_form_group_cell"><input name="RPERSON_F_PROFESSION" type="text" id="RPERSON_F_PROFESSION" value="<?=$RPERSON_F_PROFESSION?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td height="26" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Organization/Institute/dept :</td>
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="RPERSON_F_OID" type="text" id="RPERSON_F_OID" value="<?=$RPERSON_F_OID?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td height="28" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Working Location :</td>
                          <td colspan="1" class="oe_form_group_cell"><input name="RPERSON_F_WORKING_LOCATION" type="text" id="RPERSON_F_WORKING_LOCATION" value="<?=$RPERSON_F_WORKING_LOCATION?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td height="28" bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Relation :</td>
                          <td colspan="1"  bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="RPERSON_F_RELATION" type="text" id="RPERSON_F_RELATION" value="<?=$RPERSON_F_RELATION?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td height="28" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mobile :</td>
                          <td colspan="1" class="oe_form_group_cell"><input name="RPERSON_F_MOBILE" type="text" id="RPERSON_F_MOBILE" value="<?=$RPERSON_F_MOBILE?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" height="28" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Phone :</td>
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="RPERSON_F_PHONE" type="text" id="RPERSON_F_PHONE" value="<?=$RPERSON_F_PHONE?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td "height="28" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Email :</td>
                          <td colspan="1" class="oe_form_group_cell"><input name="RPERSON_F_EMAIL" type="text" id="RPERSON_F_EMAIL" value="<?=$RPERSON_F_EMAIL?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" height="28" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Fax :</td>
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="RPERSON_F_FAX" type="text" id="RPERSON_F_FAX" value="<?=$RPERSON_F_FAX?>" /></td>
                        </tr>
                      </tbody>
                  </table></td>
                  <td colspan="1" class="oe_form_group_cell oe_group_right" width="49%"><table width="97%" height="271" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                    <tbody>
                      <tr class="oe_form_group_row">
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="57%"><label>&nbsp;&nbsp;2nd Reference Person Name :</label></td>
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell" width="43%"><input name="	RPERSON_S_NAME" type="text" id="RPERSON_S_NAME" value="<?=$RPERSON_S_NAME?>" /></td>
                      </tr>
                        <tr class="oe_form_group_row">
                          <td height="32" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Profession  :</td>
                          <td colspan="1" class="oe_form_group_cell"><input name="RPERSON_S_PROFESSION" type="text" id="RPERSON_S_PROFESSION" value="<?=$RPERSON_S_PROFESSION?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" height="33" colspan="1"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Organization/Institute/dept :</td>
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="RPERSON_S_OID" type="text" id="RPERSON_S_OID" value="<?=$RPERSON_S_OID?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td height="30" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Working Location :</td>
                          <td colspan="1" class="oe_form_group_cell"><input name="RPERSON_S_WORKING_LOCATION" type="text" id="RPERSON_S_WORKING_LOCATION" value="<?=$RPERSON_S_WORKING_LOCATION?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Relation :</td>
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="RPERSON_S_RELATION" type="text" id="RPERSON_S_RELATION" value="<?=$RPERSON_S_RELATION?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Mobile :</td>
                          <td colspan="1" class="oe_form_group_cell"><input name="RPERSON_S_MOBILE" type="text" id="RPERSON_S_MOBILE" value="<?=$RPERSON_S_MOBILE?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Phone :</td>
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="RPERSON_S_PHONE" type="text" id="RPERSON_S_PHONE" value="<?=$RPERSON_S_PHONE?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Email :</td>
                          <td colspan="1" class="oe_form_group_cell"><input name="RPERSON_S_EMAIL" type="text" id="RPERSON_S_EMAIL" value="<?=$RPERSON_S_EMAIL?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Fax :</td>
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="RPERSON_S_FAX" type="text" id="RPERSON_S_FAX" value="<?=$RPERSON_S_FAX?>" /></td>
                        </tr>
                      </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table>            </td>
            </tr></tbody></table>
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>