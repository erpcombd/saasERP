<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Not in Service Status';		// Page Name and Page Title
$page="not_in_service_status.php";		// PHP File Name
$input_page="not_in_service_status.php";
$root='hrm';

$table='personnel_basic_info';		// Database Table Name Mainly related to this page
$unique='PBI_ID';			// Primary Key of this Database table
$shown='resign_date';	

do_calander('#resign_date');



// ::::: End Edit Section :::::


$crud      =new crud($table);

$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
if(isset($_POST[$shown]))
{	if(isset($_POST['insert']))
		{		
				$path='../../pic/staff';
				$_POST['pic']=image_upload($path,$_FILES['pic']);
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
				$path='../../pic/staff';
				$_POST['pic']=image_upload($path,$_FILES['pic']);
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
          </h1><table width="801" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
            <tbody><tr class="oe_form_group_row">
            <td colspan="1" class="oe_form_group_cell" width="100%"><table width="794" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="23%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;ID :</td>
                  <td bgcolor="#E8E8E8" width="23" colspan="2" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="PBI_ID" type="text" id="PBI_ID" value="<?=$PBI_ID?>" readonly="readonly" /></td>
                  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Domain :</span></td>
                  <td bgcolor="#E8E8E8" width="31%" class="oe_form_group_cell"><select name="PBI_DOMAIN" readonly="readonly">
                    <? foreign_relation('domai','DOMAIN_SHORT_NAME','DOMAIN_SHORT_NAME',$PBI_DOMAIN);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp; Name :</label></td>
                  <td colspan="2" class="oe_form_group_cell"><input name="PBI_NAME" type="text" id="PBI_NAME" value="<?=$PBI_NAME?>" readonly="readonly" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Department :</span></td>
                  <td class="oe_form_group_cell"><select name="PBI_DEPARTMENT" readonly="readonly">
                    <? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$PBI_DEPARTMENT);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Appointment Letter :</td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="PBI_APPOINTMENT_LETTER_NO" type="text" id="PBI_APPOINTMENT_LETTER_NO" value="<?=$PBI_APPOINTMENT_LETTER_NO?>" readonly="readonly" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Project :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_PROJECT" readonly="readonly">
                    <? foreign_relation('project','PROJECT_SHORT_NAME','PROJECT_DESC',$PBI_PROJECT);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Initial Joining Date :</td>
                  <td colspan="2" class="oe_form_group_cell"><input name="PBI_DOJ" type="text" id="PBI_DOJ" value="<?=$PBI_DOJ?>" readonly="readonly" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Zone : </span></td>
                  <td class="oe_form_group_cell"><select name="PBI_ZONE" readonly="readonly">
                    <? foreign_relation('zon','ZONE_NAME','ZONE_NAME',$PBI_ZONE);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Designation :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_DESIGNATION" readonly="readonly">
                    <? foreign_relation('designation','DESG_SHORT_NAME','DESG_DESC',$PBI_DESIGNATION);?>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
        <input name="PBI_DESG_GRADE" type="text" id="PBI_DESG_GRADE" value="<?=find_a_field("designation","DESG_GRADE","DESG_SHORT_NAME='".$PBI_DESIGNATION."'");?>" style="width:30px;" readonly="readonly" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Area : </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_AREA" readonly="readonly">
                    <? foreign_relation('area','AREA_NAME','AREA_NAME',$PBI_AREA);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Branch : </td>
                  <td colspan="2" class="oe_form_group_cell"><select name="PBI_BRANCH" readonly="readonly">
                    <? foreign_relation('branch','BRANCH_NAME','BRANCH_NAME',$PBI_BRANCH);?>
                  </select></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Total Service Length :</span></td>
                  <td class="oe_form_group_cell"><input name="PBI_SERVICE_LENGTH" type="text" id="PBI_SERVICE_LENGTH" value="<?=$PBI_SERVICE_LENGTH?>" readonly="readonly" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Confirmation Date :</td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="PBI_DOC" type="text" id="PBI_DOC" value="<?=$PBI_DOC?>" readonly="readonly" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Service Length (PP) :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="PBI_SERVICE_LENGTH_PP" type="text" id="PBI_SERVICE_LENGTH_PP" value="<?=$PBI_SERVICE_LENGTH_PP?>" readonly="readonly" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Joining Date(PP):</td>
                  <td colspan="2" class="oe_form_group_cell"><input name="PBI_DOJ_PP" type="text" id="PBI_DOJ_PP" value="<?=$PBI_DOJ_PP?>" readonly="readonly" /></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Date of Birth :</span></td>
                  <td class="oe_form_group_cell"><input name="PBI_DOB" type="text" id="PBI_DOB" value="<?=$PBI_DOB?>" readonly="readonly" />
                  </td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td colspan="2" class="oe_form_group_cell">&nbsp;</td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="5" bgcolor="#66CC00" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp; Not In Service Status :</strong></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Job Status :</td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_JOB_STATUS">
                    <option selected="selected">
                      <?=$PBI_JOB_STATUS?>
                      </option>
                    <option>In Service</option>
                    <option>Not In Service</option>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Type of Separation :</td>
                  <td colspan="2" bgcolor="#FFFFFF" class="oe_form_group_cell"><select name="PBI_separation_type">
                    <option selected="selected">
                      <?=$PBI_separation_type?>
                      </option>
                    <option>Resignation</option>
                    <option>Discharge</option>
                    <option>Dismissal</option>
                    <option>Termination (Self)</option>
                    <option>Termination (Authority)</option>
                    <option>Retirement</option>
                    </select></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;</span>Resign Date :</td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="resign_date" type="text" id="resign_date" value="<?=$resign_date?>" /></td>
                </tr>
                </tbody></table></td>
            <td colspan="1" class="oe_form_group_cell oe_group_right" width="100%">&nbsp;</td>
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>